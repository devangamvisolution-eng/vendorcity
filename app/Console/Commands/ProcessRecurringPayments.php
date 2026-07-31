<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Carbon\Carbon;

class ProcessRecurringPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:process-recurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process payments for upcoming recurring visits';

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
        $this->info('Starting recurring payments processing...');

        // Get visits happening in the next 24 hours that are pending payment and not cancelled
        $targetDate = Carbon::now()->addDay()->format('Y-m-d');
        
        $pendingVisits = DB::table('ci_order_visits')
            ->join('ci_orders', 'ci_order_visits.order_id', '=', 'ci_orders.format_order_id')
            ->select('ci_order_visits.*', 'ci_orders.user_id', 'ci_orders.order_total', 'ci_orders.order_currency')
            ->where('ci_order_visits.visit_date', '<=', $targetDate)
            ->where('ci_order_visits.payment_status', 'pending')
            ->where('ci_order_visits.visit_status', 'upcoming')
            ->whereNotIn('ci_orders.paymentmode', [1, 3]) // Exclude COD (1) and Tabby (3)
            ->get();

        if($pendingVisits->count() == 0) {
            $this->info('No pending visits found for ' . $targetDate);
            return 0;
        }

        Stripe::setApiKey(env('STRIPE_SK'));

        foreach($pendingVisits as $visit) {
            $this->info('Processing payment for visit ID: ' . $visit->id);

            // Fetch the user's saved Stripe Customer ID from your users table (Example logic)
            $user = DB::table('frontloginregisters')->where('id', $visit->user_id)->first();
            
            if(!$user || empty($user->stripe_customer_id)) {
                $this->error('No Stripe Customer ID found for User ID: ' . $visit->user_id);
                continue;
            }

            try {
                // Charge the saved card
                $paymentIntent = PaymentIntent::create([
                    'amount' => round($visit->order_total * 100), // Stripe expects cents
                    'currency' => strtolower($visit->order_currency ?: 'aed'),
                    'customer' => $user->stripe_customer_id,
                    'payment_method_types' => ['card'],
                    'off_session' => true,
                    'confirm' => true,
                    'description' => 'Recurring Visit Charge for Order ' . $visit->order_id,
                ]);

                if($paymentIntent->status == 'succeeded') {
                    // Update visit status
                    DB::table('ci_order_visits')
                        ->where('id', $visit->id)
                        ->update(['payment_status' => 'paid']);
                    
                    $this->info('Payment successful for Visit ID: ' . $visit->id);
                }

            } catch (\Stripe\Exception\CardException $e) {
                $this->error('Payment failed for Visit ID: ' . $visit->id . ' - ' . $e->getMessage());
                DB::table('ci_order_visits')
                    ->where('id', $visit->id)
                    ->update(['payment_status' => 'failed']);
                
                // You can add logic here to notify the user that their card declined
            } catch (\Exception $e) {
                $this->error('Error for Visit ID: ' . $visit->id . ' - ' . $e->getMessage());
            }
        }

        $this->info('Finished processing.');
        return 0;
    }
}
