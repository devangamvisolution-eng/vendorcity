<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\front\Croncontroller;

class PackageInquiryvendormailcron extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'vendormailcron';

    /**
     * The console command description.
     */
    protected $description = 'Send Package Inquiry Emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cron = new Croncontroller();

        // Call your existing function
        $cron->package_inquiry_vendormailcron();

        $this->info('Package Inquiry Cron Completed Successfully.');

        return Command::SUCCESS;
    }
}
