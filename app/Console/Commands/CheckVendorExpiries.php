<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorExpiryReminder;
use Illuminate\Support\Facades\Log;

class CheckVendorExpiries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendor:check-expiries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check vendor document expiries and send reminders or deactivate if expired for > 1 month.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get all active vendors (In this codebase, is_active = 0 means active)
        $vendors = User::where('vendor', 1)->where('is_active', 0)->get();
        $now = Carbon::now();

        $documentsToCheck = [
            'vat_certificate_expiry' => 'VAT Certificate',
            'trn_certificate_expiry' => 'TRN Certificate',
            'tlexpiry' => 'Trade License',
            'passport_expiry' => 'Passport',
            'emirates_id_expiry' => 'Emirates ID'
        ];

        foreach ($vendors as $vendor) {
            $expiringDocuments = [];
            $shouldDeactivate = false;

            foreach ($documentsToCheck as $column => $name) {
                $dateString = trim($vendor->$column);
                if (!empty($dateString) && $dateString !== '0000-00-00' && $dateString !== '0000-00-00 00:00:00' && $dateString !== '1970-01-01') {
                    try {
                        // Some formats might be dd-mm-yyyy, handle gracefully if invalid
                        $expiryDate = Carbon::parse($dateString);
                        // If it parsed as 1970 or something weird, skip
                        if ($expiryDate->year < 2000) {
                            continue;
                        }
                    } catch (\Exception $e) {
                        continue;
                    }

                    // Check if expired for more than 1 month (30 days)
                    if ($expiryDate->copy()->addDays(30)->isPast()) {
                        $shouldDeactivate = true;
                    }

                    // Check if expiring within 30 days or already expired
                    if ($expiryDate->diffInDays($now, false) >= -30) {
                        // Diff is >= -30 means today is at most 30 days before expiry date.
                        // Wait, diffInDays(now, false) means (now - expiryDate) in days.
                        // If expiryDate is in the future, it's negative.
                        // Let's use simpler logic:
                        
                        $daysUntilExpiry = $now->diffInDays($expiryDate, false); 
                        // If expiry is tomorrow, diff is 1. If expired yesterday, diff is -1.
                        
                        if ($daysUntilExpiry <= 30) {
                            $expiringDocuments[] = [
                                'name' => $name,
                                'date' => $expiryDate->format('Y-m-d'),
                                'is_expired' => $expiryDate->isPast()
                            ];
                        }
                    }
                }
            }

            if ($shouldDeactivate) {
                // In this codebase, 1 means deactivated
                $vendor->is_active = 1;
                $vendor->save();
                Log::info("Deactivated vendor ID {$vendor->id} due to documents expired for more than 1 month.");
                // Optionally send a deactivation email here
                continue;
            }

            if ($vendor->id == 100028) {
                \Log::info("====== DEBUG VENDOR 100028 ======");
                \Log::info("IS ACTIVE: " . $vendor->is_active);
                \Log::info("EXPIRING DOCS FOUND: " . count($expiringDocuments));
                \Log::info("SHOULD DEACTIVATE: " . ($shouldDeactivate ? 'YES' : 'NO'));
                \Log::info("LAST REMINDER: " . $vendor->last_expiry_reminder_sent_at);
            }

            if (count($expiringDocuments) > 0) {
                if ($vendor->id == 100028) \Log::info("Entered >0 block.");
                $lastReminderStr = trim($vendor->last_expiry_reminder_sent_at);
                $lastReminder = null;
                
                if (!empty($lastReminderStr) && $lastReminderStr !== '0000-00-00 00:00:00' && strtolower($lastReminderStr) !== 'null') {
                    try {
                        $parsed = Carbon::parse($lastReminderStr);
                        if ($parsed->year > 2000) {
                            $lastReminder = $parsed;
                            if ($vendor->id == 100028) \Log::info("Parsed last reminder successfully: " . $lastReminder->format('Y-m-d H:i:s'));
                        }
                    } catch (\Exception $e) {
                        if ($vendor->id == 100028) \Log::info("Parse exception for last reminder.");
                    }
                } else {
                    if ($vendor->id == 100028) \Log::info("Last reminder was considered empty or null.");
                }
                
                // If never sent or sent more than 7 days ago
                if (!$lastReminder || $lastReminder->diffInDays($now) >= 7) {
                    if ($vendor->id == 100028) \Log::info("Decision: WILL SEND EMAIL. diffInDays >= 7 or lastReminder is null.");
                    try {
                        Mail::to($vendor->email)->send(new VendorExpiryReminder($vendor, $expiringDocuments));
                        $vendor->last_expiry_reminder_sent_at = $now;
                        $vendor->save();
                        Log::info("Sent expiry reminder to vendor ID {$vendor->id}");
                    } catch (\Exception $e) {
                        Log::error("Failed to send expiry reminder to vendor ID {$vendor->id}: " . $e->getMessage());
                    }
                } else {
                    if ($vendor->id == 100028) \Log::info("Decision: WON'T SEND EMAIL. Only been " . $lastReminder->diffInDays($now) . " days.");
                }
            } else {
                if ($vendor->id == 100028) \Log::info("Decision: WON'T SEND EMAIL. No expiring docs.");
            }
        }

        $this->info('Vendor expiries checked successfully.');
        return Command::SUCCESS;
    }
}
