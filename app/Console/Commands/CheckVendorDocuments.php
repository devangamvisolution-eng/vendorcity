<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CheckVendorDocuments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendor:check-documents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check vendor document expiration dates and suspend accounts or send warnings.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $today = Carbon::today();
        
        $columns = ['tlexpiry', 'vat_certificate_expiry', 'trn_certificate_expiry', 'passport_expiry', 'emirates_id_expiry'];
        
        $activeVendors = DB::table('users')
            ->where('vendor', 1)
            ->where('is_active', 0)
            ->get();

        $vendorsToSuspend = [];
        $vendorsExpiringToday = [];

        foreach ($activeVendors as $vendor) {
            $isSuspended = false;
            $isWarning = false;

            foreach ($columns as $col) {
                $dateString = trim($vendor->$col);
                if (!empty($dateString) && $dateString !== '0000-00-00' && $dateString !== '0000-00-00 00:00:00' && $dateString !== '1970-01-01') {
                    try {
                        $expiryDate = Carbon::parse($dateString);
                        if ($expiryDate->year > 2000) {
                            $daysExpired = $today->diffInDays($expiryDate, false);
                            // If expired by 7 or more days ($daysExpired is negative)
                            if ($daysExpired <= -7) {
                                $isSuspended = true;
                                break; // No need to check other docs if one is already expired by 7 days
                            } elseif ($daysExpired == 0) {
                                $isWarning = true;
                            }
                        }
                    } catch (\Exception $e) {}
                }
            }

            if ($isSuspended) {
                $vendorsToSuspend[] = $vendor;
            } elseif ($isWarning) {
                $vendorsExpiringToday[] = $vendor;
            }
        }

        foreach ($vendorsToSuspend as $vendor) {
            DB::table('users')->where('id', $vendor->id)->update([
                'is_active' => 1,
                'suspension_reason' => 'document_expired'
            ]);

            $this->info("Suspended vendor ID {$vendor->id} due to expired documents.");

            // Optionally send email
            // Mail::to($vendor->email)->send(new AccountSuspendedMail($vendor));
        }

        foreach ($vendorsExpiringToday as $vendor) {
            $this->info("Sent document expired warning to vendor ID {$vendor->id}.");
            // Optionally send email
            // Mail::to($vendor->email)->send(new DocumentExpiredMail($vendor));
        }

        return Command::SUCCESS;
    }
}
