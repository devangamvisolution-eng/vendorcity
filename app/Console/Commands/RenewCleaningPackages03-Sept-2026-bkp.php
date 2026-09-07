<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RenewCleaningPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:renew-packages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically renew expired cleaning packages via Stripe';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting cleaning package renewals processing...');

        $targetDate = Carbon::now()->format('Y-m-d');

        $expiredItems = DB::table('ci_order_item')
            ->join('ci_orders', 'ci_order_item.order_id', '=', 'ci_orders.order_id')
            ->select('ci_order_item.*', 'ci_orders.user_id as order_user_id', 'ci_orders.order_total', 'ci_orders.order_currency', 'ci_orders.order_status', 'ci_orders.payment_status', 'ci_orders.subservice_code', 'ci_orders.city_code', 'ci_orders.order_year')
            ->where('ci_order_item.end_date', '<', $targetDate)
            ->where('ci_order_item.end_date', '>', '2000-01-01')
            ->where('ci_order_item.is_renewed', 0)
            ->where('ci_orders.order_id', 241)
            ->where('ci_orders.user_id', 1)
            ->whereNotIn('ci_order_item.how_often_do_you_need_cleaning', ['Once'])
            ->whereNotNull('ci_order_item.how_often_do_you_need_cleaning')
            ->get();


        /* echo "<pre>";
        print_r($expiredItems);
        echo "</pre>";
        exit; */



        if ($expiredItems->count() == 0) {
            $this->info('No expired packages to renew for ' . $targetDate);
            return 0;
        }

        Stripe::setApiKey(config('stripe.stripe_sk'));

        foreach ($expiredItems as $item) {
            $this->info('Processing renewal for Item ID: ' . $item->id . ' (Order ID: ' . $item->order_id . ')');

            $user = DB::table('frontloginregisters')->where('id', $item->order_user_id)->first();

            if (!$user || empty($user->stripe_customer_id)) {
                $this->error('No Stripe Customer ID found for User ID: ' . $item->order_user_id);
                continue;
            }

            try {
                // Determine price to charge (assume the item price or order total)
                $amountToCharge = $item->package_item_price ? $item->package_item_price : $item->order_total;
                if ($amountToCharge <= 0) {
                    $this->error('Invalid amount for Item ID: ' . $item->id);
                    continue;
                }

                $paymentIntent = PaymentIntent::create([
                    'amount' => round($amountToCharge * 100),
                    'currency' => strtolower($item->order_currency ?: 'aed'),
                    'customer' => $user->stripe_customer_id,
                    'payment_method_types' => ['card'],
                    'off_session' => true,
                    'confirm' => true,
                    'description' => 'Renewal Charge for Package Item ' . $item->id,
                ]);

                if ($paymentIntent->status == 'succeeded') {

                    DB::beginTransaction();
                    try {
                        // Mark old item as renewed
                        DB::table('ci_order_item')
                            ->where('id', $item->id)
                            ->update(['is_renewed' => 1]);

                        // Calculate sequence
                        $year = date('y');
                        $lastSequence = DB::table('ci_orders')
                            ->where('subservice_code', $item->subservice_code)
                            ->where('city_code', $item->city_code)
                            ->where('order_year', $year)
                            ->selectRaw('MAX(CAST(sequence_no AS UNSIGNED)) as seq')
                            ->lockForUpdate()
                            ->value('seq');

                        $nextSequence = $lastSequence ? $lastSequence + 1 : 1;

                        $formatOrderId = sprintf(
                            "%s-%s-%s-%06d",
                            $item->subservice_code,
                            $year,
                            $item->city_code,
                            $nextSequence
                        );

                        // Clone Order
                        $newOrderData = (array) DB::table('ci_orders')->where('order_id', $item->order_id)->first();
                        unset($newOrderData['order_id']); // Remove primary key
                        $newOrderData['created_at'] = Carbon::now();
                        $newOrderData['payment_status'] = 'Success';
                        $newOrderData['payment_id'] = $paymentIntent->id;
                        $newOrderData['order_year'] = $year;
                        $newOrderData['sequence_no'] = $nextSequence;
                        $newOrderData['format_order_id'] = $formatOrderId;

                        $newOrderId = DB::table('ci_orders')->insertGetId($newOrderData);

                        // Calculate new dates
                        $oldEndDate = Carbon::parse($item->end_date);
                        $oldStartDate = Carbon::parse($item->cdate ?: ($item->bookingyear . '-' . $item->month . '-' . $item->bookingdate));

                        // Fallback 30 days if invalid
                        $diffInDays = $oldEndDate->diffInDays($oldStartDate) > 0 ? $oldEndDate->diffInDays($oldStartDate) : 30;

                        $newStartDate = $oldEndDate->copy()->addDay();
                        $newEndDate = $newStartDate->copy()->addDays($diffInDays);

                        // Clone Order Item
                        $newItemData = (array) $item;
                        unset($newItemData['id'], $newItemData['order_user_id'], $newItemData['order_total'], $newItemData['order_currency'], $newItemData['order_status'], $newItemData['payment_status'], $newItemData['subservice_code'], $newItemData['city_code'], $newItemData['order_year']); // Remove joined and primary fields

                        $newItemData['order_id'] = $newOrderId;
                        $newItemData['is_renewed'] = 0;
                        $newItemData['cdate'] = Carbon::now()->format('Y-m-d');
                        $newItemData['end_date'] = $newEndDate->format('Y-m-d');
                        $newItemData['bookingdate'] = $newStartDate->day;
                        $newItemData['month'] = $newStartDate->format('F');
                        $newItemData['bookingyear'] = $newStartDate->year;

                        DB::table('ci_order_item')->insert($newItemData);

                        DB::commit();
                        $this->info('Successfully renewed Item ID: ' . $item->id . ' to new Order ID: ' . $newOrderId);
                    } catch (\Exception $e) {
                        DB::rollBack();
                        $this->error('Failed to duplicate order data for Item ID: ' . $item->id . ' - ' . $e->getMessage());
                    }
                }
            } catch (\Stripe\Exception\CardException $e) {
                $this->error('Payment failed for Item ID: ' . $item->id . ' - ' . $e->getMessage());
                // Handle failure (e.g. notify customer)
            } catch (\Exception $e) {
                $this->error('Error for Item ID: ' . $item->id . ' - ' . $e->getMessage());
            }
        }

        $this->info('Finished processing renewals.');
        return 0;
    }
}
