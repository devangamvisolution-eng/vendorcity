<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorExpiryReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $vendor;
    public $expiringDocuments;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vendor, $expiringDocuments)
    {
        $this->vendor = $vendor;
        $this->expiringDocuments = $expiringDocuments;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Action Required: Document Expiry Notice')
                    ->view('emails.vendor_expiry_reminder');
    }
}
