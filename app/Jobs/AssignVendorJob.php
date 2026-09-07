<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Helpers\Helper;

class AssignVendorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $vendor_id;
    protected $order_id;

    public function __construct($vendor_id, $order_id)
    {
        $this->vendor_id = $vendor_id;
        $this->order_id = $order_id;
    }

    public function handle()
    {
        $vendor_id = $this->vendor_id;
        $order_id = $this->order_id;

        // --- FETCH DATA ---
        $vendor_detail = DB::table('users')->where('vendor', 1)->where('id', $vendor_id)->first();
        $order_data = DB::table('ci_orders')->where('order_id', $order_id)->first();
        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_id)->get()->toArray();
        $customer_data = DB::table('frontloginregisters')->where('id', $order_data->user_id)->first();

        if (!$vendor_detail || !$order_data || empty($order_item_data)) return;

        // --- BOOKING DATE LOGIC ---
        $date = $order_item_data[0]->bookingdate ?? "";
        $month = $order_item_data[0]->month ?? "";
        $year = $order_item_data[0]->bookingyear ?? "";
        $booking_date = ($date != '' && $month != '' && $year != '') ? "$month $date, $year" : "-";

        // --- PAYMENT & HTML APPEND LOGIC ---
        $html_append = "";
        if ($order_data->paymentmode == 1) {
            $payment_mode = "Cash On Delivery (Please Collect from Customer)";
            $payment_mode_customer = "Cash On Delivery";
            $html_append .= "<p>Please <strong>contact the customer as soon as possible</strong> regarding the service. The customer may also contact you directly to discuss any specifics or ask questions about the service. Please ensure timely communication.</p>";
            $html_append .= "<p><strong>Please note the following instructions for COD payments:</strong><br><ul><li>Kindly collect the <strong>full payment</strong> from the customer <strong>upon completing the service.</strong></li><li>A VendorsCity representative will visit your location within 5 working days to collect the cash payment. Alternatively, if you prefer a bank transfer, please inform us, and we will provide you with our transfer details.</li></ul></p>";
        } else {
            $payment_mode = "Online (Paid)";
            $payment_mode_customer = "Online";
            $html_append .= "<p><strong>Important Information:</strong><br><ul><li><strong>Payment:</strong>Your payment will be processed after the successful completion of the job and confirmation from the customer.</li><li><strong>Customer Contact:</strong> Please <strong>contact the customer as soon as possible</strong> regarding the service.</li></ul></p>";
        }

        // --- SEND VENDOR EMAIL ---
        $vendor_html = $this->getVendorEmailTemplate($vendor_detail, $customer_data, $order_item_data, $booking_date, $payment_mode, $html_append);
        $vendor_subject = "New " . $order_item_data[0]->service_name . " Order Assigned on VendorsCity | Order No. " . $order_data->format_order_id;

        $this->sendEmail($vendor_detail->email, $vendor_subject, $vendor_html);

        // Check for attribute emails
        $vendors_attribute = DB::table('vendors_attribute')->where('pid', $vendor_id)->get();
        foreach ($vendors_attribute as $attr) {
            if (!empty($attr->c_email)) {
                $this->sendEmail($attr->c_email, $vendor_subject, $vendor_html);
            }
        }

        $customer_html_append = "";

        if ($order_data->paymentmode == 1) {
            $customer_html_append .= '<p>The assigned vendor will contact you shortly to coordinate the final service details and confirm the exact timing.
If your order is Cash on Delivery, please make the payment directly to the vendor upon service completion.</p>';
        } else {
            $customer_html_append .= '<p>The assigned vendor will contact you shortly to coordinate the final service details and confirm the exact timing.</p>';
        }

        // --- SEND CUSTOMER EMAIL ---
        $subservice_name = Helper::subservicename(strval($order_item_data[0]->subservice_id));
        $customer_html = $this->getCustomerEmailTemplate($customer_data, $order_data, $order_item_data, $vendor_detail, $payment_mode_customer, $customer_html_append);
        $customer_subject = $subservice_name . " Has Been Confirmed – Vendor Assigned by VendorsCity";

        //$this->sendEmail($customer_data->email, $customer_subject, $customer_html);

        // --- WHATSAPP LOGIC ---
        $this->sendWhatsAppNotifications($vendor_id, $order_id, $vendor_detail, $customer_data, $order_data, $order_item_data, $booking_date);
    }

    private function sendEmail($to, $subject, $html)
    {
        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        Mail::send([], [], function ($message) use ($html, $to, $subject, $ccRecipients) {
            $message->to($to)->subject($subject);
            foreach ($ccRecipients as $cc) {
                $message->bcc($cc);
            }
            $message->html($html);
        });
    }

    private function sendWhatsAppNotifications($vendor_id, $order_id, $vendorData, $UserData, $orderdata, $order_item_data, $booking_date)
    {
        $userName = $UserData->name;
        $subservice_name = Helper::subservicename($order_item_data[0]->subservice_id);
        $booking_time = Helper::timeslotname(strval($order_item_data[0]->time_slot));
        $phone_vendor = $vendorData->country_code . $vendorData->mobile;

        // Vendor WhatsApp
        $this->executeWhatsAppCurl($phone_vendor, "vendor_booking_assigned", [$userName, $subservice_name, $booking_date, $booking_time]);

        // Secondary Vendor Emails WhatsApp
        $vendors_attribute = DB::table('vendors_attribute')->where('pid', $vendor_id)->get();
        foreach ($vendors_attribute as $attr) {
            if (!empty($attr->country_code) && !empty($attr->telephone)) {
                $this->executeWhatsAppCurl($attr->country_code . $attr->telephone, "vendor_booking_assigned", [$userName, $subservice_name, $booking_date, $booking_time]);
            }
        }

        // Customer WhatsApp
        $phone_customer = $UserData->country_code . $UserData->mobile;
        //$this->executeWhatsAppCurl($phone_customer, "vendor_assigned", [$vendorData->name], $order_id);
    }

    private function executeWhatsAppCurl($to, $template, $placeholders, $url = null)
    {
        $payload = [
            "messages" => [[
                "content" => [
                    "language" => "en",
                    "templateName" => $template,
                    "templateData" => ["body" => ["placeholders" => $placeholders]]
                ],
                "from" => "+971503204846",
                "to" => $to
            ]]
        ];

        if ($url) {
            $payload['messages'][0]['content']['templateData']['buttons'] = [["type" => "URL", "parameter" => $url]];
        }

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => ['Authorization: key_uTZeOXQPMd', 'accept: application/json', 'content-type: application/json'],
        ]);
        curl_exec($curl);
        curl_close($curl);
    }

    private function getVendorEmailTemplate($vendor_detail, $customer_data, $order_item_data, $booking_date, $payment_mode, $html_append)
    {
        return '<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Account Registration:</title>
<style>
.logo {
    border-bottom: 4px solid #FFD413;
}
.logo img{
    width: 45%;
}
.wrapper {
    width: 100%;
    max-width:500px;
    margin:auto;
    font-size:14px;
    line-height:24px;
    font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;
    color:#555;
    padding:50px 0;
}   
.email_wrapper {
    width:100%;
    margin-top: 18px;
    font-size: 16px;
}
h2 {
    font-size: 26px;
    font-weight: bolder;
    margin: 0;
}
.btnlink {
    background: #0040E6;
    color: #fff !important;
    text-decoration: none;
    width: 100%;
    display: block;
    padding: 9px 0;
    text-align: center;
    font-size: 16px;
    border-radius: 9px;
}
.email_footer {
    width:100%;
    margin-top: 20px;
}
h3 {
    font-size: 20px;
    font-weight: bolder;
    margin: 0;
    border-bottom: 3px solid #6B7177;
    padding-bottom: 20px;
    margin-bottom: 15px;
}
.email_footer_div {
    width:100%;
    display: flex; 
}
.footer_left {
    width: 100px;
    float: left;
}
.footer_right {
    margin-left:10px;
    float: left;
}
.footer_right p{
    margin:0;
}
.footer_links {
    margin:10px 0;
}
.footer_links a {
    width: 100%;
    color: #555;
    display: inline-block;
}
</style>
</head>
<body>
<div class="wrapper" style="width: 100%;max-width:500px;margin:auto;
                            font-size:14px;line-height:24px;
                            font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
<div class="logo" style="float: inherit;border-bottom: 4px solid #FFD413;">
<img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;" >
</div>
<div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;"> <p>  Dear ' . $vendor_detail->name . ',</p>
                   <p>We are excited to inform you that a new order has been assigned to you through VendorsCity! Below are the details for the upcoming service:</p><p><strong>Order Details:</strong><br>
            <ul>
                <li><strong>Service: </strong> ' . Helper::servicename($order_item_data[0]->service_id) . '</li>
                <li><strong>Customer Name: </strong> ' . $customer_data->name . '</li>
                <li><strong>Date Requested: </strong> ' . $booking_date . '</li>
                <li><strong>Payment Type: </strong> ' . $payment_mode . '</li>
            </ul>   
            <p>Press “View Order” or login to your vendor portal to access all the customer details to complete the order.</p><button class="btn btn-primary" type="button"
                    style="background-color: #1F6EEC;border-color: #1F6EEC;color: #fff;
                    padding: 10px 18px;border-radius: 11px;">
                    <a href="' . route("vendororder.index") . '" style="color:#fff !important; text-decoration:none !important;">View Order</a></button>' . $html_append . '
                    
            <p>Your prompt attention to this order is greatly appreciated. If you have any questions or need further assistance, feel free to reach out to us at any time.</p>
                <p>Thank you for your continued partnership and dedication to providing top-notch service.
                </p>
               </div>
               <div class="email_footer" style="width:100%;margin-top: 20px;">
                  <h3 style=" font-size: 20px;font-weight: bolder;margin: 0;
                            border-bottom: 3px solid #6B7177;padding-bottom: 20px;
                            margin-bottom: 15px;">The VendorsCity Team</h3>
                        <div class="email_footer_div" style=" width:100%;
                            display: flex; ">
                        <div class="footer_left" style="width: 100px;
                            float: left;">
                           <img style="width:70%;" src="' . asset("public/site/images/vcfaviconwap.png") . '"" >
                       </div>
                       <div class="footer_right"  style="margin-left:10px;
                                float: left;">
                           <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a></p>
                           <p style="margin:0;">VendorsCity Portal LLC</p>
                           <div class="footer_links" style=" margin:10px 0;">
                           <a href="' . url("/terms-of-service") . '" style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                           <a href="' . url("/privacy-policy") . '" style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                           <a href="' . url("/contact") . '" style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                           </div>
                           
                       </div>
                   </div>
               </div>
           </div>
       </body>
</html>
    ';
    }

    private function getCustomerEmailTemplate($customer_data, $order_data, $order_item_data, $vendor_detail, $payment_mode_customer, $customer_html_append)
    {
        return '<!doctype html>
                <html lang="en">
                <head>
                <meta charset="utf-8">
                <title>Account Registration:</title>
                <style>
                .logo {
                border-bottom: 4px solid #FFD413;
                }
                .logo img{
                width: 45%;
                }
                .wrapper {
                width: 100%;
                max-width:500px;
                margin:auto;
                font-size:14px;
                line-height:24px;
                font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;
                color:#555;
                padding:50px 0;
                }   
                .email_wrapper {
                width:100%;
                margin-top: 18px;
                font-size: 16px;
                }
                h2 {
                font-size: 26px;
                font-weight: bolder;
                margin: 0;
                }
                .btnlink {
                background: #0040E6;
                color: #fff !important;
                text-decoration: none;
                width: 100%;
                display: block;
                padding: 9px 0;
                text-align: center;
                font-size: 16px;
                border-radius: 9px;
                }
                .email_footer {
                width:100%;
                margin-top: 20px;
                }
                h3 {
                font-size: 20px;
                font-weight: bolder;
                margin: 0;
                border-bottom: 3px solid #6B7177;
                padding-bottom: 20px;
                margin-bottom: 15px;
                }
                .email_footer_div {
                width:100%;
                display: flex; 
                }
                .footer_left {
                width: 100px;
                float: left;
                }
                .footer_right {
                margin-left:10px;
                float: left;
                }
                .footer_right p{
                margin:0;
                }
                .footer_links {
                margin:10px 0;
                }
                .footer_links a {
                width: 100%;
                color: #555;
                display: inline-block;
                }
                </style>
                </head>
                <body>
                <div class="wrapper" style="width: 100%;max-width:500px;margin:auto;
                            font-size:14px;line-height:24px;
                            font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
                <div class="logo" style="float: inherit;border-bottom: 4px solid #FFD413;">
                <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '""style="width: 40%;" >
                </div>
                <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                        <p>  Dear ' . $customer_data->name . ',</p>
                        <p>We’re happy to inform you that your service request has been confirmed and a trusted vendor has been assigned to complete your order through VendorsCity.</p>

                         <p>Here are your service details:</p>
                        <ul>
                            <li><strong>Order Number: </strong> ' . $order_data->format_order_id . '</li>
                            <li><strong>Payment Type: </strong> ' . $payment_mode_customer . '</li>
                            <li><strong>Service: </strong> ' . Helper::servicename($order_item_data[0]->service_id) . '</li>
                            <li><strong>Assigned Vendor: </strong> ' . $vendor_detail->name . '</li>
                                <li><strong>Vendor Contact: </strong> ' . $vendor_detail->mobile . '</li>
                            </ul>' . $customer_html_append . '

                             <h5 style="font-size: 14px;margin: 0;">Important Notes:</h5> 
                            <ul><li>
                            Please ensure someone is available at the location during the scheduled time.</li>
                            <li>For any changes or special requests, feel free to discuss them directly with the vendor.</li>
                            <li>If you face any issues or need further assistance, our support team is always here to help — reach us at <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a> or call us at 056 VENDORS (836 3677).</li>
                            </ul>

                        <p>Thank you for choosing VendorsCity!
                        </p>
                        <p>We appreciate your trust and look forward to ensuring your service experience is smooth and satisfying.
                </p>
                    </div>
                     <div class="email_footer" style="width:100%;margin-top: 20px;">
                  <h3 style=" font-size: 20px;font-weight: bolder;margin: 0;
                            border-bottom: 3px solid #6B7177;padding-bottom: 20px;
                            margin-bottom: 15px;">The VendorsCity Team</h3>
                        <div class="email_footer_div" style=" width:100%;
                            display: flex; ">
                        <div class="footer_left" style="width: 100px;
                            float: left;">
                           <img style="width:70%;" src="' . asset("public/site/images/vcfaviconwap.png") . '"" >
                       </div>
                       <div class="footer_right"  style="margin-left:10px;
                                float: left;">
                           <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                           <p style="margin:0;">VendorsCity Portal LLC</p>
                           <div class="footer_links" style=" margin:10px 0;">
                           <a href="' . url("/terms-of-service") . '" style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                           <a href="' . url("/privacy-policy") . '" style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                           <a href="' . url("/contact") . '" style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                           </div>
                           
                       </div>
                   </div>
               </div>
                </div>
                </body>
                </html>
        ';
    }
}
