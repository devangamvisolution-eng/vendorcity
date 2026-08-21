<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // Run recurring payment processing daily at 1 AM
        $schedule->command('payments:process-recurring')->dailyAt('01:00');

        // Check vendor expiries daily at midnight (Dubai Time)
        $schedule->command('vendor:check-expiries')->timezone('Asia/Dubai')->dailyAt('00:00');
        $schedule->command('vendor:check-documents')->timezone('Asia/Dubai')->dailyAt('00:00');

        // Run package inquiries every minute
        $schedule->command('package:inquiry')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
