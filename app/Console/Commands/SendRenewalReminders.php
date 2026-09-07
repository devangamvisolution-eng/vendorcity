<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\RenewalReminderEmail;

class SendRenewalReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:send-renewal-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send renewal reminder emails to customers 3 days before subscription expiration.';

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
        $this->info('Starting renewal reminders processing...');

        // Calculate target date: 3 days in the future
        // $targetDate = Carbon::now()->addDays(3)->format('Y-m-d');
        $targetDate = Carbon::parse('2026-08-29')->addDays(3)->format('Y-m-d');

        /* echo "<pre>";
        print_r($targetDate);
        echo "</pre>";
        exit; */

        $this->info("Targeting packages expiring on: {$targetDate}");

        $remindersToSend = DB::table('ci_order_item')
            ->join('ci_orders', 'ci_order_item.order_id', '=', 'ci_orders.order_id')
            ->select('ci_order_item.*', 'ci_orders.user_id as order_user_id', 'ci_orders.order_total', 'ci_orders.order_currency', 'ci_orders.order_status', 'ci_orders.payment_status', 'ci_orders.subservice_code', 'ci_orders.city_code', 'ci_orders.order_year')
            ->where('ci_order_item.end_date', '=', $targetDate)
            ->where('ci_order_item.end_date', '>', '2000-01-01')
            ->where('ci_order_item.is_renewed', 0)
            // ->where('ci_orders.order_id', 241) // Retained specific testing conditions as requested
            // ->where('ci_orders.user_id', 1)    // Retained specific testing conditions as requested
            ->whereNotIn('ci_order_item.how_often_do_you_need_cleaning', ['Once'])
            ->whereNotNull('ci_order_item.how_often_do_you_need_cleaning')
            ->get();

        /* echo "<pre>";
        print_r($remindersToSend);
        echo "</pre>";
        exit;
 */
        if ($remindersToSend->count() == 0) {
            $this->info('No packages expiring on ' . $targetDate . ' require reminders.');
            return 0;
        }

        foreach ($remindersToSend as $item) {
            $this->info('Processing reminder for Item ID: ' . $item->id . ' (Order ID: ' . $item->order_id . ')');

            $user = DB::table('frontloginregisters')->where('id', $item->order_user_id)->first();

            if (!$user || empty($user->email)) {
                $this->error('No email found for User ID: ' . $item->order_user_id);
                continue;
            }

            try {
                $amount = $item->package_item_price ? $item->package_item_price : $item->order_total;

                $data = [
                    'name' => $user->name,
                    'amount' => $amount,
                    'currency' => $item->order_currency ?? 'AED',
                    'renewal_date' => Carbon::parse($item->end_date)->format('j F Y'),
                    'plan_name' => 'Weekly Cleaning Plan' // Replace with logic to determine actual plan name if available
                ];

                Mail::to($user->email)->send(new RenewalReminderEmail($data));
                $this->info('Reminder sent to: ' . $user->email);
            } catch (\Exception $e) {
                $this->error('Failed to send reminder to User ID: ' . $item->order_user_id . '. Error: ' . $e->getMessage());
                Log::error('Renewal Reminder Failed: ' . $e->getMessage());
            }
        }

        $this->info('Renewal reminders processing completed.');
        return 0;
    }
}
