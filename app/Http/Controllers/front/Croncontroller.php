<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;
use Log;

class Croncontroller extends Controller
{
    //
    function package_inquiry_vendormailcron()
    {
        Log::info("enter function package_inquiry_vendormailcron");
        // try {

        //     $subject = "Beta Cron Working";
        //     $html = "<h2>Beta Cron Working Successfully</h2><p>Body</p>";

        //     $to = "activeserver.net@gmail.com";

        //     $bccRecipients = [
        //         'devang.hnrtechnologies@gmail.com'
        //     ];

        //     Mail::send([], [], function ($message) use ($to, $subject, $html, $bccRecipients) {

        //         $message->to($to, 'VendorsCity');

        //         foreach ($bccRecipients as $bccRecipient) {
        //             $message->bcc($bccRecipient);
        //         }

        //         $message->subject($subject);

        //         $message->html($html);
        //     });

        //     echo "Mail Sent Successfully";
        // } catch (\Exception $e) {

        //     echo $e->getMessage();
        // }


        // exit;
        // 1. Fetch all pending inquiries
        $pendingInquiries = DB::table('packages_enquiry')
            ->where('cron_mail_send', 0)
            ->get();

        //  echo "<pre>";
        //  print_r($pendingInquiries);
        //  echo "<pre>";
        //  exit;

        if ($pendingInquiries->isEmpty()) {
            Log::info("No pending package enquiry cron emails.");
            return;
        }

        foreach ($pendingInquiries as $inquiry) {

            $packageEnquiryFormId = $inquiry->id;
            $type = ($inquiry->form_type == 'Local Move') ? 0 : 1;

            // 2. Get city field from more_formfields_details
            $package_inquiry_data = DB::table('more_formfields_details')
                ->where('package_inquiry_id', $packageEnquiryFormId)
                ->where('form_field_id', 17)
                ->first();



            $city_data = null;
            if (!empty($package_inquiry_data)) {

                $form_attributes_data = DB::table('form_attributes')
                    ->where('id', $package_inquiry_data->formfield_value)
                    ->first();

                if ($form_attributes_data) {
                    $city_data = DB::table('cities')
                        ->where('name', $form_attributes_data->form_option)
                        ->first();
                }
            }

            // 3. Get subscription vendors
            $subscriptionQuery = DB::table('subscription')
                ->where('type_of_package', $type)
                ->where('is_deleted', '0')
                ->whereRaw('FIND_IN_SET(?, services)', [$inquiry->service_id]);

            if ($inquiry->subservice_id != 0) {
                $subscriptionQuery->whereRaw('FIND_IN_SET(?, sub_service)', [$inquiry->subservice_id]);
            }

            if (!empty($city_data)) {
                $subscriptionQuery->whereRaw('FIND_IN_SET(?, city)', [$city_data->id]);
            }

            $subscription_vendor_data = $subscriptionQuery->get();

            // 4. Unique vendor IDs
            $vendor_ids = $subscription_vendor_data->pluck('vendor_id')->unique()->toArray();

            // echo "<pre>";
            // print_r($vendor_ids);
            // echo "<pre>";
            // exit;

            // 5. Loop vendors
            foreach ($vendor_ids as $vendor_id) {

                $vendor_data = DB::table('users')
                    ->where('id', $vendor_id)
                    ->where('is_active', 0)
                    ->first();

                if (empty($vendor_data)) continue;

                // Vendor attribute emails (cc)
                $vendor_att_email = DB::table('vendors_attribute')
                    ->where('pid', $vendor_data->id)
                    ->pluck('c_email')
                    ->filter()
                    ->toArray();

                $ccRecipients = empty($vendor_att_email)
                    ? ['hello@vendorscity.com', 'zafar@quickserverelo.com']
                    : $vendor_att_email;

                // Build email HTML (same as original)
                $html = $this->buildEmailHtml($vendor_data, $inquiry);

                $subject = "New Quote Request for " . \Helper::servicename($inquiry->service_id) . " on VendorsCity!";

                try {
                    // Send email
                    Mail::send([], [], function ($message) use ($vendor_data, $subject, $html, $ccRecipients) {
                        $message->to($vendor_data->email, 'VendorsCity');
                        $message->subject($subject);
                        foreach ($ccRecipients as $ccRecipient) {
                            $message->bcc($ccRecipient);
                        }
                        $message->html($html);
                    });

                    // WhatsApp alert
                    if (!empty($vendor_data->country_code) && !empty($vendor_data->mobile)) {
                        // Call your existing WhatsApp function exactly like before
                        $this->whatsappmsg_tmp_new_lead_alert($vendor_data, $packageEnquiryFormId);
                    }

                    // Notification
                    DB::table('notification')->insert([
                        'vendor_id' => $vendor_data->id,
                        'subject' => $subject,
                        'added_datetime' => now()
                    ]);

                    Log::info("Cron: Email sent to vendor " . $vendor_data->email);
                } catch (\Exception $e) {
                    Log::error("Cron mail failed for vendor " . $vendor_data->email . " : " . $e->getMessage());
                }
            }

            // 6. Update cron_mail_send flag
            DB::table('packages_enquiry')
                ->where('id', $packageEnquiryFormId)
                ->update(['cron_mail_send' => 1]);

            Log::info("Cron: Completed inquiry ID " . $packageEnquiryFormId);

            echo "Cron Run Successfully";
            exit;
        }

        //echo "<pre>";print_r($pendingInquiries);echo "</pre>";exit;
    }



    private function buildEmailHtml($vendor_data, $inquiry)
    {
        //$userdata = Session::get('user');
        $user_name = $inquiry->name ?? 'Customer';
        $Date = date('d-m-Y');

        $html = '<!doctype html> <html>
            <head>
                <meta charset="utf-8">
                <title>Forget Password Email</title>
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
                    <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '" style="width: 40%;">
                    </div>
                    <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                        
                    <p>Dear ' . ucfirst($vendor_data->name) . ',</p>                 
                    <p>We are excited to inform you that a new customer has requested a quote for ' . \Helper::servicename($inquiry->service_id) . ' on VendorsCity!</p>
                    <p><strong>Request Details:</strong></p>
                    <ul><li style= "list-style-type: disc;margin-bottom: -15px;"> Service Requested : ' . \Helper::servicename($inquiry->service_id) . '</li>                       
                    <li style= "list-style-type: disc;margin-bottom: -15px;"> Customer Name : ' . $user_name . '</li>
                    <li style= "list-style-type: disc";> Request Date : ' . $Date . '</li></ul>                        
                    <p><a class="btnlink" href="' . route("vendor.login") . '" style=" background: #0040E6;color: #fff !important;text-decoration: none;width: 100%;display: block;padding: 9px 0;text-align: center;
                        font-size: 16px;border-radius: 9px;">View Request</a></p>

                    <p><strong>What You Need to Do:</strong></p>
                    <ul><li style= "list-style-type: disc;margin-bottom: -15px;"> Log in to your : <a href="' . route("vendor.login") . '">Vendor Portal</a></li>
                    <li style= "list-style-type: disc";> View the full request details and customer information.</li></ul>

                    <p>Submit your quote <strong>within 24 hours</strong>. Please ensure your quote is competitive and detailed to increase your chances of securing the job. If you have any questions or need assistance, feel free to reach out to us at hello@vendorscity.com.</p>
                    <p>Thank you for your prompt attention to this request.</p>
                    </div>
                     <div class="email_footer" style="width:100%;margin-top: 20px;">
                            <h3 style=" font-size: 20px;font-weight: bolder;margin: 0;
                            border-bottom: 3px solid #6B7177;padding-bottom: 20px;
                            margin-bottom: 15px;">The VendorsCity Team</h3>
                            <div class="email_footer_div" style=" width:100%;
                            display: flex; ">
                                <div class="footer_left" style="width: 100px;
                            float: left;">
                                    <img style="width:70%;" src="' . asset("public/site/images/vcfaviconwap.png") . '" >
                                </div>
                                <div class="footer_right" style="margin-left:10px;
                                float: left;">
                                    <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a></p>
                                    <p  style="margin:0;">VendorsCity Portal LLC</p>
                                    <div class="footer_links" style=" margin:10px 0;">
                                <a href="' . url("/terms-of-service") . '"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                <a href="' . url("/privacy-policy") . '"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                <a href="' . url("/contact") . '"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                                </div>
                                    <p style="margin:0;">This message was mailed to ' . $vendor_data->email . ' as part of you account registered with us on VendorsCity</p>
                                </div>
                            </div>
                      </div>
                </div>
            </body>
            </html>';

        return $html;
    }

    private function whatsappmsg_tmp_new_lead_alert($vendor_data, $package_id)
    {
        $package_inquiry_data = DB::table('packages_enquiry')
            ->where('id', $package_id)
            ->first();

        if (!$package_inquiry_data) return;

        $phone = $vendor_data->country_code . $vendor_data->mobile;
        $service_name = \Helper::servicename($package_inquiry_data->service_id);

        $apiKey = 'key_uTZeOXQPMd'; // store your API key in .env

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                "messages" => [[
                    "to" => $phone,
                    "content" => [
                        "templateName" => "new_lead_alert",
                        "language" => "en",
                        "templateData" => [
                            "body" => [
                                "placeholders" => [$service_name]
                            ],
                            "buttons" => [
                                ["type" => "URL"]
                            ]
                        ]
                    ]
                ]]
            ]),
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'content-type: application/json',
                'Authorization: ' . $apiKey
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '
            {
            "messages": [
                {
                "content": {
                    "language": "en",
                    "templateData": {
                    "body": {
                        "placeholders": [
                        "' . $service_name . '"
                        ]
                    }
                    },
                    "templateName": "new_booking_alert"
                },
                "from": "+971503204846",
                "to": "' . $phone . '"
                }
            ]
            }
            ',
            CURLOPT_HTTPHEADER => array(
                'Authorization: key_uTZeOXQPMd',
                'accept: application/json',
                'content-type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}
