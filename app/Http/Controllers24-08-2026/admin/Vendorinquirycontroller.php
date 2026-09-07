<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

use DB;

class Vendorinquirycontroller extends Controller
{
    //
    public function index(Request $request)
    {
        // Fetch filtering parameters
        $startdate = $request->input('s_date');
        $enddate = $request->input('e_date');
        $servicename = $request->input('servicename');

        // Initialize the query
        $query = DB::table('packages_enquiry')->select('*');

        if (!empty($startdate)) {
            $query->where('added_date', '>=', date('Y-m-d', strtotime($startdate)));
        }

        if (!empty($enddate)) {
            $query->where('added_date', '<=', date('Y-m-d', strtotime($enddate)));
        }

        if (!empty($servicename)) {
            $query->where('service_id', $servicename);
        }

        // Filter by count and order by id
        $data['packages_enquiry'] = $query->where('count', '<', 5)
            ->orderBy('id', 'desc')
            ->get();

        // Pass data to the view
        $data['startdate'] = $startdate;
        $data['enddate'] = $enddate;
        $data['filter_service_id'] = $servicename;

        $data['service_data'] = DB::table('services')->get();

        //    echo"<pre>";print_r($data['startdate']);echo"</pre>";
        //    echo"<pre>";print_r($data['enddate']);echo"</pre>";
        //    echo"<pre>";print_r($data['filter_service_id']);echo"</pre>";exit;

        return view('admin.list_vendor_inquiry', $data);
    }

    function accept_vendor_inquiry(Request $request)
    {
        //echo "here";exit;
        // echo"<pre>";
        // print_r($request->all());
        // echo"</pre>";exit;

        $inquiryId = $request->input('inquiry_id');
        $vendorId = $request->input('vendor_id');

        $package_data = DB::table('packages_enquiry')->where('id', $inquiryId)->first();

        $package_count = $package_data->count + 1;

        DB::table('packages_enquiry')
            ->where('id', $inquiryId)
            ->update([
                'count' => $package_count,
            ]);

        $data['packages_inquiry_id'] = $inquiryId;
        $data['vendor_id'] = $vendorId;
        $data['accept_reject'] = 0;
        $data['added_date'] = date('Y-m-d');

        DB::table('package_inquiry_accepted')->insert($data);



        // $countIsAccept = DB::table('packages_enquiry')        
        //                     ->where('is_accept', 1)
        //                     ->count();
        //                     echo $countIsAccept;exit;

        // Redirect or do something else after the update
        return redirect()->route('vendorinquiry.index')->with('success', 'Inquiry Accept Successfully');
    }
    function accepted_vendor_inquiry($userId, $Inquiry_id)
    {


        $vendors_id = Crypt::decrypt($userId);
        $enquiry_id = $Inquiry_id;

        $get_more_id = DB::table('package_inquiry_accepted')
            ->where('vendor_id', '=', $vendors_id)
            ->where('packages_inquiry_id', '=', $enquiry_id)
            ->first();



        if ($get_more_id == '') {
            $package_data = DB::table('packages_enquiry')->where('id', $enquiry_id)->first();


            $package_count = $package_data->count + 1;

            DB::table('packages_enquiry')
                ->where('id', $enquiry_id)
                ->update([
                    'count' => $package_count,
                ]);

            $data['packages_inquiry_id'] = $enquiry_id;
            $data['vendor_id'] = $vendors_id;
            $data['accept_reject'] = 0;
            $data['added_date'] = date('Y-m-d');

            DB::table('package_inquiry_accepted')->insert($data);


            return redirect()->route('acceptleads.index')->with('success', 'Inquiry Accept Successfully');
        } else {
            return redirect()->route('acceptleads.index')->with('success', 'You Are Already Inquiry Accepted');
        }
    }

    function garden_accept_vendor_inquiry($userId, $Inquiry_id)
    {


        $vendors_id = Crypt::decrypt($userId);
        $enquiry_id = $Inquiry_id;

        $get_more_id = DB::table('package_inquiry_accepted')
            ->where('vendor_id', '=', $vendors_id)
            ->where('packages_inquiry_id', '=', $enquiry_id)
            ->first();



        if ($get_more_id == '') {
            $package_data = DB::table('packages_enquiry')->where('id', $enquiry_id)->first();


            $package_count = $package_data->count + 1;

            DB::table('packages_enquiry')
                ->where('id', $enquiry_id)
                ->update([
                    'count' => $package_count,
                ]);

            $data['packages_inquiry_id'] = $enquiry_id;
            $data['vendor_id'] = $vendors_id;
            $data['accept_reject'] = 0;
            $data['added_date'] = date('Y-m-d');

            DB::table('package_inquiry_accepted')->insert($data);


            return redirect()->route('garden_acceptleads.index')->with('success', 'Inquiry Accept Successfully');
        } else {
            return redirect()->route('garden_acceptleads.index')->with('success', 'You Are Already Inquiry Accepted');
        }
    }

    public function enquiry_details($enquiry_id)
    {
        // $data['vendor_id'] = $vendor_id = auth::user()['id'];
        // $data['service_id'] = $service_id = session('subscription_ids')[0]; // 0 is service Id
        // $data['subservice_id'] = $sub_service = session('subscription_ids')[1]; // 1 is subservice Id

        // $subscription_vendor_data= DB::table('subscription')
        //                     ->whereRaw('FIND_IN_SET(?, services)', [$service_id])
        //                     ->whereRaw('FIND_IN_SET(?, sub_service)', [$sub_service])
        //                             ->where('vendor_id',$vendor_id)
        //                             ->get();

        // $subscription_subservice_attribute = DB::table('subscription_subservice_attribute')
        //                                     ->select('*')
        //                                     ->where('subscription_id', $subscription_vendor_data->subscription_id)
        //                                     ->whereRaw('FIND_IN_SET(?, service_id)', [$subscription_vendor_data->services])
        //                                      ->whereRaw('FIND_IN_SET(?, subservice_id)', [$subscription_vendor_data->sub_service])
        //                                     ->first();
        //  echo"<pre>";
        //    print_r($subscription_subservice_attribute);
        // echo"</pre>";exit;

        $data['packages_enquiry'] = DB::table('more_formfields_details')->where('package_inquiry_id', $enquiry_id)->get();

        // echo"<pre>";
        //     print_r($data['packages_enquiry']);
        // echo"</pre>";exit;

        return view('admin.list_enquiry_accpet_reject', $data);
    }

    public function painting_enquiry_detail($enquiry_id)
    {
        $data['painting_enquiry_data'] = DB::table('painting_enquiry')->where('id', $enquiry_id)->first();
        return view('admin.list_vender_paint_inquiry_detail', $data);
    }

    public function wooden_enquiry_detail($enquiry_id)
    {
        $data['wooden_enquiry_data'] = DB::table('wooden_floor_enquiry')->where('id', $enquiry_id)->first();
        return view('admin.list_vender_wooden_inquiry_detail', $data);
    }

    public function enquiry_detailss($enquiry_id)
    {
        // echo $enquiry_id;exit;

        $data['packages_enquiry'] = DB::table('more_formfields_details')->where('package_inquiry_id', $enquiry_id)->get();
        $data['packagesenq'] = DB::table('packages_enquiry')->where('id', $enquiry_id)->first();
        $data['userdata'] = DB::table('frontloginregisters')->where('id',  $data['packagesenq']->user_id)->first();


        // echo "<pre>";
        // print_r($data);
        // exit;

        return view('admin.list_enquiry_accpeted', $data);
    }

    public function add_reject_reason(Request $request)
    {


        if ($request->reject_reason != "Other" && $request->reject_reason_text == "") {
            $data['reject_reason'] = $request->reject_reason;
        }

        if ($request->reject_reason == "Other" && $request->reject_reason_text != "") {
            $data['reject_reason'] = $request->reject_reason_text;
        }

        $data['packages_inquiry_id'] = $request->inquiry_id;
        $data['vendor_id'] = $request->vendor_id;
        $data['accept_reject'] = 1;
        $data['added_date'] = date('Y-m-d');

        DB::table('package_inquiry_accepted')->insert($data);
        return redirect()->route('vendorinquiry.index')->with('success', 'Form Submited Successfully');
    }

    public function add_garden_reject_reason(Request $request)
    {

        // echo"<pre>";print_r($request->all());echo"</pre>";exit;
        if ($request->reject_reason != "Other" && $request->reject_reason_text == "") {
            $data['reject_reason'] = $request->reject_reason;
        }

        if ($request->reject_reason == "Other" && $request->reject_reason_text != "") {
            $data['reject_reason'] = $request->reject_reason_text;
        }

        $data['packages_inquiry_id'] = $request->inquiry_id;
        $data['vendor_id'] = $request->vendor_id;
        $data['accept_reject'] = 1;
        $data['added_date'] = date('Y-m-d');

        DB::table('package_inquiry_accepted')->insert($data);
        return redirect()->route('garden-inquiry.index')->with('success', 'Form Submited Successfully');
    }
    public function accpet_form($package_inquiry_id, $user_id)
    {

        $data['packages_enquiry_data'] = DB::table('packages_enquiry')->where('id', $package_inquiry_id)->first();


        $data['service_data'] = DB::table('service_quote_includes')->where('service_id', $data['packages_enquiry_data']->service_id)->get();


        return view('admin.list_accpet_form', $data);
    }

    public function garden_accpet_form($package_inquiry_id, $user_id)
    {

        $data['packages_enquiry_data'] = DB::table('packages_enquiry')->where('id', $package_inquiry_id)->first();

        return view('admin.list_garden_accpet_form', $data);
    }

    public function garden_accept_lead_form(Request $request)
    {

        $vendor_id = $request->vendor_id;
        $vendor_data = DB::table('users')->where('id', $request->vendor_id)->first();
        $garden_data = DB::table('packages_enquiry')->where('id', $request->inquiry_id)->first();

        if ($garden_data->form_type == 'Local Move') {
            $typeOfPackage = 0;
        }


        if ($garden_data->count < 5) {


            $subscription_vendor_data = DB::table('subscription')
                ->whereRaw('FIND_IN_SET(?, services)', [$garden_data->service_id])
                ->whereRaw('FIND_IN_SET(?, sub_service)', [$garden_data->subservice_id])
                ->where('vendor_id', '=', $vendor_id)
                ->where('type_of_subscription', '!=', 2)
                ->where('type_of_package', $typeOfPackage)
                ->where('is_deleted', '=', '0')
                ->orderBy('id', 'DESC')
                ->get()
                ->toArray();

            // echo"<pre>";print_r($subscription_vendor_data);echo"</pre>";exit;

            $vendor_package_no_of_inquiry = 0;
            $vendor_lead_no_of_inquiry = 0;

            if (!empty($subscription_vendor_data)) {

                foreach ($subscription_vendor_data as $subscription_vendor_da) {
                    if ($subscription_vendor_da->type_of_subscription == 0) {
                        $vendor_package_no_of_inquiry += $subscription_vendor_da->no_of_inquiry_package;
                    } else {
                        $vendor_lead_no_of_inquiry += 1;
                    }
                }
            }

            // echo"<pre>";print_r($vendor_package_no_of_inquiry);echo"</pre>";
            // echo"<pre>";print_r($vendor_lead_no_of_inquiry);echo"</pre>";exit;

            $vendor_accept_inquiry_data = DB::table('package_inquiry_accepted')
                ->selectRaw('SUM(no_of_inquiry) as total_no_of_inquiry')
                ->where('vendor_id', $vendor_id)
                ->where('accept_reject', 0)
                ->where('subscription_type', 'p')
                ->first();

            // echo"<pre>";print_r($vendor_accept_inquiry_data->total_no_of_inquiry);echo"</pre>";exit;
            $redirect_type = "";

            if ($vendor_package_no_of_inquiry > $vendor_accept_inquiry_data->total_no_of_inquiry && $vendor_lead_no_of_inquiry == 0) {

                // echo"hete454";exit;

                $data_package['packages_inquiry_id'] = $request->inquiry_id;
                $data_package['vendor_id'] = $vendor_id;
                $data_package['added_date'] = date('Y-m-d');
                $data_package['accept_reject'] = 0;
                $data_package['subscription_type'] = 'p';
                $data_package['subscription_id'] = $subscription_vendor_data[0]->id;
                $data_package['no_of_inquiry'] = 1;
                $data_package['service_id'] = $garden_data->service_id;
                $data_package['subservice_id'] = $garden_data->subservice_id;
                $data_package['type_of_leads'] = $garden_data->form_type;

                // echo"<pre>";print_r($data_package);echo"</pre>";exit;
                $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_package);
                $redirect_type = 'success';
            } else {
                // echo"hete";exit;

                if ($vendor_lead_no_of_inquiry != 0) {

                    $subs_service_id = explode(',', $subscription_vendor_data[0]->services);
                    $subs_subservice_id = explode(',', $subscription_vendor_data[0]->sub_service);

                    // echo"<pre>";print_r($subs_service_id);echo"</pre>";
                    // echo"<pre>";print_r($subs_subservice_id);echo"</pre>";exit;
                    //For mouse and Gardening
                    if (in_array('47', $subs_service_id)) {

                        $service_data = DB::table('services')->select('*')
                            ->where('id', 47)
                            ->first();

                        // check only Pst Control  service
                        if (in_array('77', $subs_subservice_id) || in_array('78', $subs_subservice_id)) {

                            $garden_size_of_home = DB::table('garden_enquiry')->where('inquiry_id', $garden_data->id)->first();

                            //   echo"<pre>";print_r($garden_size_of_home);echo"</pre>";exit;

                            $subscription_local_move_attribute = DB::table('subscription_local_move_attribute')->select('*')->where('subscription_id', $subscription_vendor_data[0]->id)
                                ->where('form_id', 70)
                                ->where('more_form_attributes_id', $garden_size_of_home->size_of_home_id)
                                ->first();

                            // echo"<pre>";print_r($subscription_local_move_attribute);echo"</pre>";exit;

                            $vendors_data = DB::table('users')->where('id', $vendor_id)->first();

                            if ($subscription_local_move_attribute->local_move_charge > $vendors_data->wallet_amount || $vendors_data->wallet_amount == 0) {
                                echo "<script>
                            alert('Insufficient wallet balance or wallet is empty');
                            window.location.href = '" . route('wallet.index') . "'; 
                            </script>";
                                die();
                            } else {

                                $vendor_wallet_amount = $vendors_data->wallet_amount - $subscription_local_move_attribute->local_move_charge;

                                $data_inquiry_garden['packages_inquiry_id'] = $request->inquiry_id;
                                $data_inquiry_garden['vendor_id'] = $vendor_id;
                                $data_inquiry_garden['added_date'] = date('Y-m-d');
                                $data_inquiry_garden['accept_reject'] = 0;
                                $data_inquiry_garden['subscription_type'] = 'l';
                                $data_inquiry_garden['no_of_inquiry'] = 1;
                                $data_inquiry_garden['service_id'] = $garden_data->service_id;
                                $data_inquiry_garden['subservice_id'] = $garden_data->subservice_id;
                                $data_inquiry_garden['type_of_leads'] = null;
                                $data_inquiry_garden['size_of_house_id'] = null;
                                $data_inquiry_garden['price_of_lead'] = $subscription_local_move_attribute->local_move_charge;
                                $data_inquiry_garden['subscription_id'] = $subscription_local_move_attribute->subscription_id;

                                $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_inquiry_garden);

                                DB::table('users')->where('id', $vendor_id)->update(['wallet_amount' => $vendor_wallet_amount]);


                                $data_wallet['vendors_id'] = $vendor_id;
                                $data_wallet['price'] = $subscription_local_move_attribute->local_move_charge;
                                $data_wallet['add_deduct'] = 1;
                                $data_wallet['subscription_id'] = $subscription_vendor_data[0]->id;

                                $wallet_id = DB::table('wallets')->insertGetId($data_wallet);

                                $vendor_data_new = DB::table('users')->where('id', $vendor_id)->first();
                                $year = date('y');
                                $data_u['transaction_id'] = "TID-" . $vendor_data_new->vendor_id . "-" . $year . "-" . sprintf("%06d", $wallet_id);

                                DB::table('wallets')->where('id', $wallet_id)->update($data_u);


                                $redirect_type = 'success';
                            }
                        }
                    }
                } else {

                    $redirect_type = 'error';
                    $redirect_message = 'Your Subscription has been expire or finish. Please contact Vendorscity for new or renew Subscription.';
                }
            }


            if ($redirect_type == 'success') {

                if (!empty($id_package_inquiry_accepted)) {

                    // echo"<pre>";print_r($id_package_inquiry_accepted);echo"</pre>";exit;

                    $data_n['accept_lead'] = $request->accept_lead;
                    $data_n['qoute'] = $request->qoute;

                    if (!empty($request->qoute)) {


                        $data_n['package_inquiry_accepted_id'] = $id_package_inquiry_accepted;
                        $data_n['packages_inquiry_id'] = $request->inquiry_id;
                        $data_n['vendor_id'] = $request->vendor_id;
                        $data_n['qoute'] = $request->qoute;
                        $data_n['added_date'] = date('Y-m-d');

                        DB::table('qoute_includes')->insert($data_n);
                    }
                }
                // exit;

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
                    #table_new,#table_new
                    th,
                    #table_new td {
                        border: 1px solid black;
                        border-collapse: collapse;
                    }

                    .custome_td{
                            background-color: #0040E6;
                            color: #fff;
                            padding: 10px 60px 10px 12px;
                            border-bottom-color: #fff !important;
                    }
                    .custome_td_new{
                            padding: 10px 12px;
                    }
                    .cutomer_td{
                        text-align:center;
                        background-color: #0040E6;
                        color: #fff;
                        border-bottom-color: #fff !important;
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
                    <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                        
                    <p>Dear ' . $vendor_data->name . ',</p>  
                   
                    <p>Congratulations! You have successfully accepted a new lead on VendorsCity. Below, you Will find the customer information necessary to fulfill the request.</p>

                    <span><strong>Your Quote:</strong></span>';


                if (isset($quote_includes_data[0]) && $quote_includes_data[0]->accept_lead == 'Enter Qoute') {

                    $html .= '<table style="width: 100%;border: 1px solid #000;border-collapse: collapse;">
                                    <tr>
                                        <th style="text-align: left;border: 1px solid #000;   background-color: #0040e6;color: #fff;padding: 10px 60px 10px 12px;">Quote</th>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;border: 1px solid #000;padding: 10px 60px 10px 12px;">' . $quote_includes_data[0]->qoute . ' AED (Including 5% VAT)</td>
                                    </tr>
                                  </table>';
                } else {

                    $html .= '<table style="width: 100%;">
                            <tr>
                                <th style="text-align: left;border: 1px solid #000;   background-color: #0040e6;color: #fff;padding: 10px 60px 10px 12px;">Quote</th>
                                <th style="text-align: left;border: 1px solid #000;   background-color: #0040e6;color: #fff;padding: 10px 60px 10px 12px;">Additional Information</th> 
                            </tr>
                            <tr>
                                <td style="text-align: left;border: 1px solid #000;padding: 10px 60px 10px 12px;">Based On Final Survey</td>
                                <td style="text-align: left;border: 1px solid #000;padding: 10px 60px 10px 12px;">This lead is chargeable. There was no quote provided to the client. Please quote the client directly via email and copy <a style="color: #555;tetext-decoration: inherit;" href="mailto:support@vendorscity.com">support@vendorscity.com</a> for our record.</td>
                            </tr>
                    </table>';
                }
                $html .= '<br>
                    <span><strong>Customer Details:</strong></span>
                    <table id="table_new" style="width: 100%;border: 1px solid black;
                        border-collapse: collapse;">
                        
                        <tr>
                            <td class="custome_td" style="background-color: #0040E6;
                            color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;border-collapse: collapse;">Name:</td>
                            <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;border-collapse: collapse;"> ' . $garden_data->name . '</td>
                        </tr>
                        <tr>
                            <td class="custome_td" style="background-color: #0040E6;
                            color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;border-collapse: collapse;">Email:</td>
                            <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;border-collapse: collapse;"> ' . $garden_data->email . '</td>
                        </tr>
                        <tr>
                            <td class="custome_td" style="background-color: #0040E6;
                            color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;
                        border-collapse: collapse;">Mobile No:</td>
                            <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;
                        border-collapse: collapse;"> ' . $garden_data->mobile . '</td>
                        </tr>';

                $html .= '</table>

                        <p><strong>Next Steps:</strong></p>
                        <ol>
                            <li><strong>Contact the Customer:</strong> Confirm the service details and any additional requirements with the customer.</li>
                            <li><strong>Prepare for the Service:</strong>Make necessary preparations to fulfill the customer is request as specified.</li>
                            <li><strong>Complete the Service:</strong>Ensure the service is carried out professionally and to the customer is satisfaction.</li>
                            <li><strong>Payment Collection:</strong>If this is a Cash on Delivery (COD) order, collect the full payment upon job completion.</li>
                        </ol>
                        
                        <p>If you have any questions or need assistance, please do not hesitate to contact our vendor support team at <a style="color: #555;" href="mailto:vendors@vendorscity.com"> vendors@vendorscity.com</a>or call us at 056 VENDORS (836 3677).
                        </p>


                   
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
                                <div class="footer_right" style="margin-left:10px;
                                float: left;">
                                    <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a></p>
                                    <p style="margin:0;">VendorsCity Portal LLC</p>
                                    <div class="footer_links" style=" margin:10px 0;">
                                <a href="' . url("/terms-of-service") . '"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                <a href="' . url("/privacy-policy") . '"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                <a href="' . url("/contact") . '"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                                </div>
                                    
                                </div>
                            </div>
                      </div>
                </div>
            </body>
        </html>';

                $vendor_att_email = array();
                $vendor_data_attr = DB::table('vendors_attribute')->where('pid', $vendor_id)->get()->toArray();

                // echo"<pre>";print_r($vendor_data_attr);echo"</pre>";exit;

                foreach ($vendor_data_attr as $attr_data) {
                    $vendor_att_email[] = $attr_data->c_email;
                }

                if (!empty($vendor_att_email)) {
                    $cc = implode(',', $vendor_att_email);
                } else {
                    $cc = '';
                }

                $subject = "VendorsCity Lead Accepted for " . $garden_data->name . "! Here Are the Details";
                $to = $vendor_data->email;
                $ccRecipients = explode(',', $cc);
                $ccRecipients = array_filter($ccRecipients, 'strlen');
                $staticEmails = ['zafar@quickserverelo.com', 'hello@vendorscity.com'];
                $ccRecipients = array_merge($ccRecipients, $staticEmails);
                Mail::send([], [], function ($message) use ($html, $to,  $subject, $ccRecipients) {
                    $message->to($to, 'VendorsCity');
                    //  $message->bcc($bccEmails);
                    $message->subject($subject);
                    //$message->from('devang.hnrtechnologies@gmail.com','VendorsCity');
                    foreach ($ccRecipients as $ccRecipient) {
                        $message->bcc($ccRecipient);
                    }
                    $message->html($html);
                });

                $quote_includes_data = DB::table('qoute_includes')->where('packages_inquiry_id', $request->inquiry_id)->where('vendor_id', $vendor_id)->get()->toArray();

                $customer_html_new = '';

                $customer_html_new .= '<!doctype html>

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
                   <p>  Dear ' . $garden_data->name . ',</p>
                   <p>We hope this email finds you well.</p>';


                $quote_includes_data = DB::table('qoute_includes')->where('packages_inquiry_id', $request->inquiry_id)->where('vendor_id', $vendor_data->id)->get()->toArray();

                //echo "<pre>";print_r($quote_includes_data);echo"</pre>";exit;

                if (!empty($quote_includes_data) && isset($quote_includes_data[0]->accept_lead) && $quote_includes_data[0]->accept_lead == 'Enter Qoute') {
                    $text1 = "We are excited to inform you that a vendor has submitted a quote for the service you requested on VendorsCity. Here are the details:";

                    $text2 = "The vendor will contact you soon to discuss the details further. If you do not hear from the vendor within the next 24 hours, please contact them directly at " . $vendor_data->mobile . ".";

                    $text3 = "You can compare the quote with others you might receive and select the one that best fits your needs.";

                    $subject_type = "New Quote Received for Your " . \Helper::servicename($garden_data->service_id) . " Request on VendorsCity!
";
                } else {

                    $text1 = "A vendor has reviewed your service request on VendorsCity and would like to conduct a survey before providing an accurate quote. Here are the details:";

                    $text2 = "The vendor will contact you soon to confirm the survey details.  If you do not hear from the vendor within the next 24 hours, please contact them directly at " . $vendor_data->mobile . ".";

                    $text3 = "This survey will help the vendor understand your specific needs and ensure you receive the most accurate and competitive quote for the service.
";

                    $subject_type = "Survey Request for Your " . \Helper::servicename($garden_data->service_id) . " Request on VendorsCity!
";
                }

                $customer_html_new .= '<p>' . $text1 . '<br><br>';


                $customer_html_new .= '<span style="
                    margin-bottom: 15px;
                    display: inline-block;
                "><strong>Service Requested: </strong>' .  \Helper::servicename($garden_data->service_id) . '</span><br>';

                $customer_html_new .= '<span style="
                    margin-bottom: 15px;
                    display: inline-block;
                ">
                                <strong>Vendor Name:</strong> ' . $vendor_data->name . '</span><br>
                                <span style="
                    margin-bottom: 15px;
                    display: inline-block;
                ">
                                <strong>Vendor Contact:</strong> ' . $vendor_data->mobile . '</span><br>';


                $customer_html_new .= '<p>' . $text2 . '</p>

                <p>' . $text3 . '
                </p>
                <p>If you have any questions or need further assistance, feel free to reach out to us at <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a> or call us at 056 VENDORS (836 3677).
                </p>
                <p>Thank you for choosing VendorsCity. We look forward to helping you find the best service providers for your needs.
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
                                <div class="footer_right" style="margin-left:10px;
                                float: left;">
                                    <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                                    <p style="margin:0;">VendorsCity Portal LLC</p>
                                    <div class="footer_links" style=" margin:10px 0;">
                                <a href="' . url("/terms-of-service") . '"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                <a href="' . url("/privacy-policy") . '"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                <a href="' . url("/contact") . '"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                                </div>
                                    <p style="margin:0;">This message was mailed to ' . $garden_data->email . ' as part of you account registered with us on VendorsCity</p>
                                </div>
                            </div>
                     </div>
                 </div>
            </body>
			</html>';

                $subject = $subject_type;
                $to = $garden_data->email;
                $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];

                Mail::send([], [], function ($message) use ($customer_html_new, $to,  $subject, $ccRecipients) {
                    $message->to($to, 'VendorsCity');
                    //  $message->bcc($bccEmails);
                    $message->subject($subject);
                    //$message->from('devang.hnrtechnologies@gmail.com','VendorsCity');
                    foreach ($ccRecipients as $ccRecipient) {
                        $message->bcc($ccRecipient);
                    }
                    $message->html($customer_html_new);
                });

                $package_count = $garden_data->count + 1;

                DB::table('packages_enquiry')
                    ->where('id', $request->inquiry_id)
                    ->update([
                        'count' => $package_count,
                    ]);

                return redirect()->route('garden-inquiry.index')->with('success', 'Inquiry Accept Successfully');
            } else {

                return redirect()->route('garden_accpet_form', [
                    'package_inquiry_id' => $request->inquiry_id,
                    'user_id' => $vendor_id
                ])->with('error', $redirect_message);
            }
        } else {
            return redirect()->route('accpet_form', [
                'package_inquiry_id' => $request->inquiry_id,
                'user_id' => $vendor_id
            ])->with('error', 'Unfortunately, this request has already been accepted by 5 vendors. Don’t miss out on future opportunities—look out for notifications in your email and on your dashboard for the next available request!
        ');
        }
    }

    public function accept_lead_form_new(Request $request)
    {

        // echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $qoute_includes_id = $request->qoute_includes_id;
        $qoute_include_value = $request->qoute_include_value;
        $qoute_includes_name = $request->qoute_includes_name;


        $userId = Auth::id();

        $inquiryId = $request->input('inquiry_id');
        $vendorId = $userId;
        $package_data = DB::table('packages_enquiry')->where('id', $inquiryId)->first();

        $vendor_data = DB::table('users')->where('id', $vendorId)->first();

        $vendor_data_attr = DB::table('vendors_attribute')->where('pid', $vendorId)->get()->toArray();

        if ($package_data->form_type == 'International Move') {
            $typeOfPackage = 1;
        } elseif ($package_data->form_type == 'Local Move') {
            $typeOfPackage = 0;
        } else {
            $typeOfPackage = "";
        }


        if ($package_data->count < 5) {

            // echo"<pre>";print_r($typeOfPackage);echo"</pre>";

            $subscription_vendor_data = DB::table('subscription')
                //->where('services',$request->service_id)
                ->whereRaw('FIND_IN_SET(?, services)', [$package_data->service_id])
                ->whereRaw('FIND_IN_SET(?, sub_service)', [$package_data->subservice_id])
                ->where('vendor_id', '=', $vendorId)
                ->where('is_deleted', '=', '0')
                ->where('type_of_package', '=', $typeOfPackage)
                ->where('type_of_subscription', '!=', 2)
                ->orderBy('id', 'DESC')
                ->get()->toArray();

            // echo"<pre>ssssss";print_r($subscription_vendor_data);echo"</pre>";	exit;		

            if (empty($subscription_vendor_data)) {


                $redirect_message = "Your Need to Add Subscription for this lead please contact Vendorscity Team";
                return redirect()->route('accpet_form', [
                    'package_inquiry_id' => $inquiryId,
                    'user_id' => $vendorId
                ])->with('error', $redirect_message);
            }

            $vendor_package_no_of_inquiry = 0;
            $vendor_lead_no_of_inquiry = 0;

            if (!empty($subscription_vendor_data)) {

                foreach ($subscription_vendor_data as $subscription_vendor_da) {
                    if ($subscription_vendor_da->type_of_subscription == 0) {
                        $vendor_package_no_of_inquiry += $subscription_vendor_da->no_of_inquiry_package;
                    } else {
                        $vendor_lead_no_of_inquiry += 1;
                    }
                }
            }

            // echo"<pre>";print_r($subscription_vendor_data);echo"</pre>";	exit;

            $vendor_accept_inquiry_data = DB::table('package_inquiry_accepted')
                ->selectRaw('SUM(no_of_inquiry) as total_no_of_inquiry')
                ->where('vendor_id', $vendorId)
                ->where('accept_reject', 0)
                ->where('subscription_type', 'p')
                ->where('subscription_id', '!=', '')
                ->first();
            $redirect_type = "";

            // echo"<pre>";print_r($vendor_package_no_of_inquiry);echo"</pre>";
            // echo"<pre>";print_r($vendor_lead_no_of_inquiry);echo"</pre>";
            // echo"<pre>";print_r($vendor_accept_inquiry_data);echo"</pre>";exit;

            if ($vendor_package_no_of_inquiry > $vendor_accept_inquiry_data->total_no_of_inquiry || $vendor_lead_no_of_inquiry == 0) {

                // echo"here";exit;
                // echo"<pre>";print_r($vendor_package_no_of_inquiry);echo"</pre>";exit;


                $data_package['packages_inquiry_id'] = $inquiryId;
                $data_package['vendor_id'] = $vendorId;
                $data_package['added_date'] = date('Y-m-d');
                $data_package['accept_reject'] = 0;
                $data_package['subscription_type'] = 'p';
                $data_package['subscription_id'] = $subscription_vendor_data[0]->id;
                $data_package['no_of_inquiry'] = 1;
                $data_package['service_id'] = $package_data->service_id;
                $data_package['subservice_id'] = $package_data->subservice_id;
                $data_package['type_of_leads'] = $package_data->form_type;

                $purchased = $vendor_package_no_of_inquiry; // total leads purchased
                $accepted  = $vendor_accept_inquiry_data->total_no_of_inquiry; // leads already used

                if ($accepted >= $purchased) {
                    // limit reached → stop
                    $redirect_message = "Your Subscription Has Been Expired, Please Contact Vendorscity Team";
                    return redirect()->route('accpet_form', [
                        'package_inquiry_id' => $inquiryId,
                        'user_id' => $vendorId
                    ])->with('error', $redirect_message);
                } else {
                    // still leads left → insert
                    $id_package_inquiry_accepted = DB::table('package_inquiry_accepted')->insertGetId($data_package);
                }

                // echo"test";exit;
                $redirect_type = 'success';
            } else {


                if ($vendor_lead_no_of_inquiry != 0) {

                    $subs_service_id = explode(',', $subscription_vendor_data[0]->services);
                    $subs_subservice_id = explode(',', $subscription_vendor_data[0]->sub_service);

                    if (in_array('30', $subs_service_id)) { // check only moving service

                        $service_data = DB::table('services')->select('*')
                            ->where('id', 30)
                            ->first();

                        //  echo"<pre>";print_r($package_data);echo"</pre>";
                        // echo"<pre>";print_r($subs_subservice_id);echo"</pre>";exit; 
                        if ($package_data->subservice_id != 31) {
                            if (in_array('23', $subs_subservice_id) || in_array('26', $subs_subservice_id) || in_array('53', $subs_subservice_id)) { // apartment ,villa and office subservice

                                // echo "aprt";exit;

                                if ($package_data->form_type == 'Local Move') {

                                    $local_form_field_array = explode(',', $service_data->form_fields);

                                    // echo"<pre>";print_r($local_form_field_array);echo"</pre>";exit;				

                                    $local_more_formfields_details_att = DB::table('more_formfields_details_att')->select('*')
                                        ->where('package_inquiry_id', $inquiryId)
                                        ->where('form_id', 20)
                                        ->first();


                                    $subscription_local_move_attribute = DB::table('subscription_local_move_attribute')->select('*')
                                        ->where('subscription_id', $subscription_vendor_data[0]->id)
                                        ->where('form_id', 20)
                                        ->where('more_form_attributes_id', $local_more_formfields_details_att->more_form_attributes_id)
                                        ->first();
                                    // echo "<pre>else";
                                    // print_r($local_more_formfields_details_att);
                                    // echo "</pre>";
                                    // exit;

                                    $vendors_data = DB::table('users')->where('id', $vendorId)->first();

                                    //    if($subscription_local_move_attribute->local_move_charge > 0){

                                    if ($subscription_local_move_attribute->local_move_charge > $vendors_data->wallet_amount || $vendors_data->wallet_amount == 0) {

                                        // echo"test";exit;



                                        echo "<script>
                                alert('Insufficient wallet balance or wallet is empty');
                                window.location.href = '" . route('wallet.index') . "'; 
                                </script>";
                                        die();
                                    } else {

                                        $vendor_wallet_amount = $vendors_data->wallet_amount - $subscription_local_move_attribute->local_move_charge;



                                        $data_inquiry_local['packages_inquiry_id'] = $inquiryId;
                                        $data_inquiry_local['vendor_id'] = $vendorId;
                                        $data_inquiry_local['added_date'] = date('Y-m-d');
                                        $data_inquiry_local['accept_reject'] = 0;
                                        $data_inquiry_local['subscription_type'] = 'l';
                                        $data_inquiry_local['no_of_inquiry'] = 1;
                                        $data_inquiry_local['service_id'] = $package_data->service_id;
                                        $data_inquiry_local['subservice_id'] = $package_data->subservice_id;
                                        $data_inquiry_local['type_of_leads'] = $package_data->form_type;
                                        $data_inquiry_local['size_of_house_id'] = $local_more_formfields_details_att->more_form_attributes_id;
                                        $data_inquiry_local['price_of_lead'] = $subscription_local_move_attribute->local_move_charge;
                                        $data_inquiry_local['subscription_id'] = $subscription_local_move_attribute->subscription_id;

                                        $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_inquiry_local);

                                        DB::table('users')->where('id', $vendorId)->update(['wallet_amount' => $vendor_wallet_amount]);


                                        $data_wallet['vendors_id'] = $vendorId;
                                        $data_wallet['price'] = $subscription_local_move_attribute->local_move_charge;
                                        $data_wallet['add_deduct'] = 1;
                                        $data_wallet['subscription_id'] = $subscription_vendor_data[0]->id;

                                        $wallet_id = DB::table('wallets')->insertGetId($data_wallet);

                                        $vendor_data_new = DB::table('users')->where('id', $vendorId)->first();
                                        $year = date('y');
                                        $data_u['transaction_id'] = "TID-" . $vendor_data_new->vendor_id . "-" . $year . "-" . sprintf("%06d", $wallet_id);

                                        DB::table('wallets')->where('id', $wallet_id)->update($data_u);


                                        $redirect_type = 'success';
                                    }
                                    // }else{
                                    //     // echo"out";exit;
                                    //     $redirect_type = 'error';

                                    //     $redirect_message = 'You are not purchase Lead Subscription or Package for this Inquiry.'; 
                                    // }

                                } elseif ($package_data->form_type == 'International Move') {


                                    $international_form_field_array = explode(',', $service_data->form_fields_two);

                                    $international_more_formfields_details_att = DB::table('more_formfields_details_att')->select('*')
                                        ->where('package_inquiry_id', $inquiryId)
                                        ->where('form_id', 63)
                                        ->first();

                                    // echo"<pre>db";print_r($subscription_vendor_data);echo"</pre>";exit;

                                    $subscription_international_move_attribute = DB::table('subscription_international_move_attribute')->select('*')
                                        ->where('subscription_id', $subscription_vendor_data[0]->id)
                                        ->where('form_id', 63)
                                        ->where('more_form_attributes_id', $international_more_formfields_details_att->more_form_attributes_id)
                                        ->first();

                                    $vendors_data = DB::table('users')->where('id', $vendorId)->first();

                                    // echo"<pre>test";print_r($subscription_international_move_attribute);echo"</pre>";exit;

                                    // if($subscription_international_move_attribute->local_move_charge > 0){

                                    if (($subscription_international_move_attribute !== null && $subscription_international_move_attribute->local_move_charge  > $vendors_data->wallet_amount) || $vendors_data->wallet_amount == 0) {
                                        echo "<script>
                            alert('Insufficient wallet balance or wallet is empty');
                            window.location.href = '" . route('wallet.index') . "'; 
                            </script>";
                                        die();
                                    } else {

                                        if ($subscription_international_move_attribute !== null) {
                                            $vendor_wallet_amount = $vendors_data->wallet_amount - $subscription_international_move_attribute->local_move_charge;
                                        } else {
                                            $vendor_wallet_amount = $vendors_data->wallet_amount;
                                        }
                                        $data_inquiry_intl['packages_inquiry_id'] = $inquiryId;
                                        $data_inquiry_intl['vendor_id'] = $vendorId;
                                        $data_inquiry_intl['added_date'] = date('Y-m-d');
                                        $data_inquiry_intl['accept_reject'] = 0;
                                        $data_inquiry_intl['subscription_type'] = 'l';
                                        $data_inquiry_intl['no_of_inquiry'] = 1;
                                        $data_inquiry_intl['service_id'] = $package_data->service_id;
                                        $data_inquiry_intl['subservice_id'] = $package_data->subservice_id;
                                        $data_inquiry_intl['type_of_leads'] = $package_data->form_type;
                                        $data_inquiry_intl['size_of_house_id'] = $international_more_formfields_details_att->more_form_attributes_id;
                                        $data_inquiry_intl['subscription_id'] = $subscription_international_move_attribute->subscription_id;

                                        // echo"<pre>test";print_r($data_inquiry_intl);echo"</pre>";exit;

                                        if ($subscription_international_move_attribute !== null) {
                                            $data_inquiry_intl['price_of_lead'] = $subscription_international_move_attribute->local_move_charge;
                                        } else {
                                            $data_inquiry_intl['price_of_lead'] = 0;  // or another default 
                                        }



                                        $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_inquiry_intl);

                                        DB::table('users')->where('id', $vendorId)->update(['wallet_amount' => $vendor_wallet_amount]);

                                        $data_wallet['vendors_id'] = $vendorId;
                                        if ($subscription_international_move_attribute !== null) {
                                            $data_wallet['price'] = $subscription_international_move_attribute->local_move_charge;
                                        } else {
                                            // Handle the case when $subscription_international_move_attribute is null
                                            $data_wallet['price'] = 0; // or some other default value
                                        }

                                        $data_wallet['add_deduct'] = 1;
                                        $data_wallet['subscription_id'] = $subscription_vendor_data[0]->id;

                                        $wallet_id = DB::table('wallets')->insertGetId($data_wallet);

                                        $vendor_data_new = DB::table('users')->where('id', $vendorId)->first();
                                        $year = date('y');
                                        $data_u['transaction_id'] = "TID-" . $vendor_data_new->vendor_id . "-" . $year . "-" . sprintf("%06d", $wallet_id);
                                        DB::table('wallets')->where('id', $wallet_id)->update($data_u);

                                        $redirect_type = 'success';
                                    }
                                    // }
                                    // else{
                                    //     $redirect_type = 'error';

                                    //     $redirect_message = 'You are not purchase Lead Subscription or Package for this Inquiry.'; 
                                    // }



                                } else {
                                    $redirect_type = 'error';
                                }
                            }
                        }

                        //if($package_data->subservice_id == 31){ // vehicle

                        if ($package_data->subservice_id == 31) {



                            if (in_array('31', $subs_subservice_id)) { // vehicle subservice

                                // echo"here";exit;

                                $package_att_data = DB::table('more_formfields_details')
                                    ->where('package_inquiry_id', $package_data->id)
                                    ->where('form_field_id', 42)
                                    ->first();

                                // echo"<pre>";print_r($package_att_data);echo"</pre>";exit;

                                $form_attributes_val = DB::table('form_attributes')
                                    ->where('id', $package_att_data->formfield_value)
                                    ->first();



                                $subscription_subservice_attribute = DB::table('subscription_subservice_attribute')->select('*')
                                    ->where('subscription_id', $subscription_vendor_data[0]->id)
                                    ->where('service_id', $package_data->service_id)
                                    ->where('subservice_id', $package_data->subservice_id)
                                    ->first();

                                // echo"<pre>";print_r($subscription_subservice_attribute);echo"</pre>";exit;

                                $vendors_data = DB::table('users')->where('id', $vendorId)->first();

                                // $vendor_wallet_amount = $vendors_data->wallet_amount - $price_of_lead;

                                // if($price_of_lead > 0){

                                $price_of_lead = $subscription_subservice_attribute->charge * $form_attributes_val->form_option;

                                if ($price_of_lead > $vendors_data->wallet_amount || $vendors_data->wallet_amount == 0) {

                                    echo "<script>
                            alert('Insufficient wallet balance or wallet is empty');
                            window.location.href = '" . route('wallet.index') . "'; 
                            </script>";
                                    die();
                                } else {




                                    $data_inquiry_other['packages_inquiry_id'] = $inquiryId;
                                    $data_inquiry_other['vendor_id'] = $vendorId;
                                    $data_inquiry_other['added_date'] = date('Y-m-d');
                                    $data_inquiry_other['accept_reject'] = 0;
                                    $data_inquiry_other['subscription_type'] = 'l';
                                    $data_inquiry_other['no_of_inquiry'] = 1;
                                    $data_inquiry_other['service_id'] = $package_data->service_id;
                                    $data_inquiry_other['subservice_id'] = $package_data->subservice_id;
                                    $data_inquiry_other['type_of_leads'] = $package_data->form_type;
                                    $data_inquiry_other['price_of_lead'] = $price_of_lead;
                                    $data_inquiry_other['subscription_id'] = $subscription_subservice_attribute->subscription_id;

                                    // echo"<pre>";print_r($data_inquiry_other);echo"</pre>";exit;

                                    $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_inquiry_other);

                                    $vendor_wallet_amount = $vendors_data->wallet_amount - $price_of_lead;

                                    // echo"<pre>";print_r($vendor_wallet_amount);echo"</pre>";exit;

                                    DB::table('users')->where('id', $vendorId)->update(['wallet_amount' => $vendor_wallet_amount]);

                                    $data_wallet['vendors_id'] = $vendorId;
                                    $data_wallet['price'] = $price_of_lead;
                                    $data_wallet['add_deduct'] = 1;
                                    $data_wallet['subscription_id'] = $subscription_vendor_data[0]->id;

                                    $wallet_id = DB::table('wallets')->insertGetId($data_wallet);

                                    $vendor_data_new = DB::table('users')->where('id', $vendorId)->first();
                                    $year = date('y');
                                    $data_u['transaction_id'] = "TID-" . $vendor_data_new->vendor_id . "-" . $year . "-" . sprintf("%06d", $wallet_id);
                                    DB::table('wallets')->where('id', $wallet_id)->update($data_u);

                                    $redirect_type = 'success';
                                }
                                // }
                                // else{
                                //     $redirect_type = 'error';

                                //     $redirect_message = 'You are not purchase Lead Subscription or Package for this Inquiry.'; 
                                // }


                                // echo"<pre>78";print_r($subscription_subservice_attribute);echo"</pre>";exit;
                            }
                        }
                    }

                    if (in_array('44', $subs_service_id)) { // check only storage service

                        //echo "test"; exit;

                        $subscription_subservice_attribute = DB::table('subscription_subservice_attribute')->select('*')
                            ->where('subscription_id', $subscription_vendor_data[0]->id)
                            ->where('service_id', $package_data->service_id)
                            ->where('subservice_id', $package_data->subservice_id)
                            ->first();

                        $vendors_data = DB::table('users')->where('id', $vendorId)->first();

                        // if($price_of_lead > 0){
                        $price_of_lead = $subscription_subservice_attribute->charge;

                        if ($price_of_lead > $vendors_data->wallet_amount || $vendors_data->wallet_amount == 0) {

                            echo "<script>
                        alert('Insufficient wallet balance or wallet is empty');
                        window.location.href = '" . route('wallet.index') . "'; 
                        </script>";
                            die();
                        } else {




                            $data_inquiry_other['packages_inquiry_id'] = $inquiryId;
                            $data_inquiry_other['vendor_id'] = $vendorId;
                            $data_inquiry_other['added_date'] = date('Y-m-d');
                            $data_inquiry_other['accept_reject'] = 0;
                            $data_inquiry_other['subscription_type'] = 'l';
                            $data_inquiry_other['no_of_inquiry'] = 1;
                            $data_inquiry_other['service_id'] = $package_data->service_id;
                            $data_inquiry_other['subservice_id'] = $package_data->subservice_id;
                            $data_inquiry_other['type_of_leads'] = $package_data->form_type;
                            $data_inquiry_other['price_of_lead'] = $price_of_lead;
                            $data_inquiry_other['subscription_id'] = $subscription_subservice_attribute->subscription_id;

                            $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_inquiry_other);

                            $vendor_wallet_amount = $vendors_data->wallet_amount - $price_of_lead;

                            // echo"<pre>";print_r($vendor_wallet_amount);echo"</pre>";exit;

                            DB::table('users')->where('id', $vendorId)->update(['wallet_amount' => $vendor_wallet_amount]);

                            $data_wallet['vendors_id'] = $vendorId;
                            $data_wallet['price'] = $price_of_lead;
                            $data_wallet['add_deduct'] = 1;
                            $data_wallet['subscription_id'] = $subscription_vendor_data[0]->id;

                            $wallet_id = DB::table('wallets')->insertGetId($data_wallet);

                            $vendor_data_new = DB::table('users')->where('id', $vendorId)->first();
                            $year = date('y');
                            $data_u['transaction_id'] = "TID-" . $vendor_data_new->vendor_id . "-" . $year . "-" . sprintf("%06d", $wallet_id);
                            DB::table('wallets')->where('id', $wallet_id)->update($data_u);


                            $redirect_type = 'success';
                        }
                    }
                } else {

                    $redirect_type = 'error';
                    $redirect_message = 'Your Subscription has been expire or finish. Please contact Vendorscity for new or renew Subscription.';
                }
            }

            if ($redirect_type == 'success') {


                if (!empty($id_package_inquiry_accepted)) {

                    $data_n['accept_lead'] = $request->accept_lead;
                    $data_n['qoute'] = $request->qoute;

                    if (!empty($qoute_includes_id)) {

                        foreach ($qoute_includes_id as $key => $value) {



                            $data_n['package_inquiry_accepted_id'] = $id_package_inquiry_accepted;
                            $data_n['packages_inquiry_id'] = $inquiryId;
                            $data_n['vendor_id'] = $vendorId;
                            $data_n['qoute_includes_id'] = $value;
                            $data_n['qoute_include_value'] = $qoute_include_value[$key];
                            $data_n['qoute_includes_name'] = $qoute_includes_name[$key];
                            $data_n['added_date'] = date('Y-m-d');

                            DB::table('qoute_includes')->insert($data_n);
                        }
                    }
                }

                $form_fields_data = DB::table('more_formfields_details')->where('package_inquiry_id', $inquiryId)->get()->toArray();

                $field_array = array();
                foreach ($form_fields_data as $key => $values) {

                    $form_fields = DB::table('form_fileds')
                        ->select('*')
                        ->where('id', $values->form_field_id)
                        ->first();

                    if ($values->formfield_value != '') {
                        //echo "inner<br>";
                        // If the key doesn't exist, add the entry to the array
                        $field_array[$key] = array('name' => $form_fields->lable_name, 'value' => $values->formfield_value, 'id' => $form_fields->id, 'mail_send' => $form_fields->mail_send);
                    }
                }

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
                    #table_new,#table_new
                    th,
                    #table_new td {
                        border: 1px solid black;
                        border-collapse: collapse;
                    }

                    .custome_td{
                            background-color: #0040E6;
                            color: #fff;
                            padding: 10px 60px 10px 12px;
                            border-bottom-color: #fff !important;
                    }
                    .custome_td_new{
                            padding: 10px 12px;
                    }
                    .cutomer_td{
                        text-align:center;
                        background-color: #0040E6;
                        color: #fff;
                        border-bottom-color: #fff !important;
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
                    <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                        
                    <p>Dear ' . $vendor_data->name . ',</p>  
                   
                    <p>Congratulations! You have successfully accepted a new lead on VendorsCity. Below, you Will find the customer information necessary to fulfill the request.</p>

                    <span><strong>Your Quote:</strong></span>';

                $quote_includes_data = DB::table('qoute_includes')->where('packages_inquiry_id', $inquiryId)->where('vendor_id', $vendor_data->id)->get()->toArray();

                if (isset($quote_includes_data[0]) && $quote_includes_data[0]->accept_lead == 'Enter Qoute') {

                    $html .= '<table style="width: 100%;border: 1px solid #000;border-collapse: collapse;">
                                    <tr>
                                        <th style="text-align: left;border: 1px solid #000;   background-color: #0040e6;color: #fff;padding: 10px 60px 10px 12px;">Quote</th>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;border: 1px solid #000;padding: 10px 60px 10px 12px;">' . $quote_includes_data[0]->qoute . ' AED (Including 5% VAT)</td>
                                    </tr>
                                  </table>';
                } else {

                    $html .= '<table style="width: 100%;">
                            <tr>
                                <th style="text-align: left;border: 1px solid #000;   background-color: #0040e6;color: #fff;padding: 10px 60px 10px 12px;">Quote</th>
                                <th style="text-align: left;border: 1px solid #000;   background-color: #0040e6;color: #fff;padding: 10px 60px 10px 12px;">Additional Information</th> 
                            </tr>
                            <tr>
                                <td style="text-align: left;border: 1px solid #000;padding: 10px 60px 10px 12px;">Based On Final Survey</td>
                                <td style="text-align: left;border: 1px solid #000;padding: 10px 60px 10px 12px;">This lead is chargeable. There was no quote provided to the client. Please quote the client directly via email and copy <a style="color: #555;tetext-decoration: inherit;" href="mailto:support@vendorscity.com">support@vendorscity.com</a> for our record.</td>
                            </tr>
                    </table>';
                }
                $html .= '<br>
                    <span><strong>Customer Details:</strong></span>
                    <table id="table_new" style="width: 100%;border: 1px solid black;
                        border-collapse: collapse;">
                        
                        <tr>
                            <td class="custome_td" style="background-color: #0040E6;
                            color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;border-collapse: collapse;">Name:</td>
                            <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;border-collapse: collapse;"> ' . $package_data->name . '</td>
                        </tr>
                        <tr>
                            <td class="custome_td" style="background-color: #0040E6;
                            color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;border-collapse: collapse;">Email:</td>
                            <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;border-collapse: collapse;"> ' . $package_data->email . '</td>
                        </tr>
                        <tr>
                            <td class="custome_td" style="background-color: #0040E6;
                            color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;
                        border-collapse: collapse;">Mobile No:</td>
                            <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;
                        border-collapse: collapse;"> ' . $package_data->mobile . '</td>
                        </tr>';

                if (!empty($field_array)) {
                    $i = 0;
                    foreach ($field_array as $form_field_data) {
                        if (!empty($form_field_data['mail_send']) && $form_field_data['mail_send'] == '1') {

                            $get_more_id = DB::table('more_formfields_details_att')
                                ->where('form_id', '=', $form_field_data['id'])
                                ->where('package_inquiry_id', '=', $inquiryId)
                                ->get()
                                ->toArray();

                            // echo "<pre>";print_r($form_field_data);echo "</pre>";




                            if ($form_field_data['value'] != '') {
                                $html .= '<tr>';
                                if ($form_field_data['id'] != $i) {
                                    $html .= '<td class="custome_td" style="background-color: #0040E6;
                                                    color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;
                        border-collapse: collapse;">' . $form_field_data['name'] . '</td>  ';
                                }

                                if (is_numeric($form_field_data['value']) && $form_field_data['id'] != 30 && $form_field_data['id'] != 60) {
                                    $html .= '<td   class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;
                        border-collapse: collapse;">' . \Helper::form_fields_attr($form_field_data['value']) . '</td>';
                                } else {

                                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];
                                    $extension = pathinfo($form_field_data['value'], PATHINFO_EXTENSION);

                                    if (in_array(strtolower($extension), $imageExtensions)) {
                                        // if($form_field_data['id'] == $i){                                                                                                                                              
                                        $html .= '<td colspan="2" class="text-center"><a href="' . url('download/' . $form_field_data['value']) . '">Download</a></td>';
                                        // }
                                    } else {
                                        $html .= '<td  class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;
                                                    border-collapse: collapse;" >' . $form_field_data['value'] . '</td>';
                                    }
                                }
                                $html .= ' </tr>';
                            }
                            // echo "<pre>";print_r($get_more_id);echo "</pre>";

                            if (isset($get_more_id) && count($get_more_id) > 0) {
                                foreach ($get_more_id as $get_more_id_data) {
                                    $html .= '<tr>';
                                    if ($form_field_data['value'] == 111 && $form_field_data['id'] == 35) {
                                        $html .= '<td class="custome_td" style="background-color: #0040E6;
                                                    color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;"> What days of the week would you like the service</td>';
                                    } else {
                                        $html .= '<td  class="custome_td" style="background-color: #0040E6;
                                                    color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;"> Type of Home</td>';
                                    }
                                    $html .= '                                          
                                        <td class="custome_td_new" style=" padding: 10px 12px;">' . \Helper::form_fields_attr_more($get_more_id_data->more_form_attributes_id) . '</td>                                               
                                      </tr>';
                                }
                            }
                        }

                        $i = $form_field_data['id'];
                    }
                }


                $html .= '</table>

                        <p><strong>Next Steps:</strong></p>
                        <ol>
                            <li><strong>Contact the Customer:</strong> Confirm the service details and any additional requirements with the customer.</li>
                            <li><strong>Prepare for the Service:</strong>Make necessary preparations to fulfill the customer is request as specified.</li>
                            <li><strong>Complete the Service:</strong>Ensure the service is carried out professionally and to the customer is satisfaction.</li>
                            <li><strong>Payment Collection:</strong>If this is a Cash on Delivery (COD) order, collect the full payment upon job completion.</li>
                        </ol>
                        
                        <p>If you have any questions or need assistance, please do not hesitate to contact our vendor support team at <a style="color: #555;" href="mailto:vendors@vendorscity.com"> vendors@vendorscity.com</a>or call us at 056 VENDORS (836 3677).
                        </p>


                   
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
                                <div class="footer_right" style="margin-left:10px;
                                float: left;">
                                    <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a></p>
                                    <p style="margin:0;">VendorsCity Portal LLC</p>
                                    <div class="footer_links" style=" margin:10px 0;">
                                <a href="' . url("/terms-of-service") . '"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                <a href="' . url("/privacy-policy") . '"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                <a href="' . url("/contact") . '"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                                </div>
                                    
                                </div>
                            </div>
                      </div>
                </div>
            </body>
        </html>';

                $vendor_att_email = array();
                $vendor_data_attr = DB::table('vendors_attribute')->where('pid', $vendorId)->get()->toArray();

                // echo"<pre>";print_r($vendor_data_attr);echo"</pre>";exit;

                foreach ($vendor_data_attr as $attr_data) {
                    $vendor_att_email[] = $attr_data->c_email;
                }

                if (!empty($vendor_att_email)) {
                    $cc = implode(',', $vendor_att_email);
                } else {
                    $cc = '';
                }

                $subject = "VendorsCity Lead Accepted for " . $package_data->name . "! Here Are the Details";
                $to = $vendor_data->email;
                $ccRecipients = explode(',', $cc);
                $ccRecipients = array_filter($ccRecipients, 'strlen');
                $staticEmails = ['zafar@quickserverelo.com', 'hello@vendorscity.com'];
                $ccRecipients = array_merge($ccRecipients, $staticEmails);
                Mail::send([], [], function ($message) use ($html, $to,  $subject, $ccRecipients) {
                    $message->to($to, 'VendorsCity');
                    //  $message->bcc($bccEmails);
                    $message->subject($subject);
                    //$message->from('devang.hnrtechnologies@gmail.com','VendorsCity');
                    foreach ($ccRecipients as $ccRecipient) {
                        $message->bcc($ccRecipient);
                    }
                    $message->html($html);
                });

                $quote_includes_data = DB::table('qoute_includes')->where('packages_inquiry_id', $inquiryId)->where('vendor_id', $vendorId)->get()->toArray();

                $form_fields_data = DB::table('more_formfields_details')->where('package_inquiry_id', $inquiryId)->get()->toArray();

                $field_array = array();
                foreach ($form_fields_data as $key => $values) {

                    $form_fields = DB::table('form_fileds')
                        ->select('*')
                        ->where('id', $values->form_field_id)
                        ->first();

                    if ($values->formfield_value != '') {
                        // If the key doesn't exist, add the entry to the array
                        $field_array[$key] = array('name' => $form_fields->lable_name, 'value' => $values->formfield_value, 'id' => $form_fields->id, 'mail_send' => $form_fields->mail_send);
                    }
                }

                $customer_html_new = '';

                $customer_html_new .= '<!doctype html>

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
                   <p>  Dear ' . $package_data->name . ',</p>
                   <p>We hope this email finds you well.</p>';


                $quote_includes_data = DB::table('qoute_includes')->where('packages_inquiry_id', $inquiryId)->where('vendor_id', $vendor_data->id)->get()->toArray();

                //echo "<pre>";print_r($quote_includes_data);echo"</pre>";exit;

                if (!empty($quote_includes_data) && isset($quote_includes_data[0]->accept_lead) && $quote_includes_data[0]->accept_lead == 'Enter Qoute') {
                    $text1 = "We are excited to inform you that a vendor has submitted a quote for the service you requested on VendorsCity. Here are the details:";

                    $text2 = "The vendor will contact you soon to discuss the details further. If you do not hear from the vendor within the next 24 hours, please contact them directly at " . $vendor_data->mobile . ".";

                    $text3 = "You can compare the quote with others you might receive and select the one that best fits your needs.";

                    $subject_type = "New Quote Received for Your " . \Helper::servicename($package_data->service_id) . " Request on VendorsCity!
";
                } else {

                    $text1 = "A vendor has reviewed your service request on VendorsCity and would like to conduct a survey before providing an accurate quote. Here are the details:";

                    $text2 = "The vendor will contact you soon to confirm the survey details.  If you do not hear from the vendor within the next 24 hours, please contact them directly at " . $vendor_data->mobile . ".";

                    $text3 = "This survey will help the vendor understand your specific needs and ensure you receive the most accurate and competitive quote for the service.
";

                    $subject_type = "Survey Request for Your " . \Helper::servicename($package_data->service_id) . " Request on VendorsCity!
";
                }

                $customer_html_new .= '<p>' . $text1 . '<br><br>';


                $customer_html_new .= '<span style="
                    margin-bottom: 15px;
                    display: inline-block;
                "><strong>Service Requested: </strong>' .  \Helper::servicename($package_data->service_id) . '</span><br>';

                $customer_html_new .= '<span style="
                    margin-bottom: 15px;
                    display: inline-block;
                ">
                                <strong>Vendor Name:</strong> ' . $vendor_data->name . '</span><br>
                                <span style="
                    margin-bottom: 15px;
                    display: inline-block;
                ">
                                <strong>Vendor Contact:</strong> ' . $vendor_data->mobile . '</span><br>';


                $i = 0;
                foreach ($quote_includes_data as $quote_data) {

                    if ($i == 0) {

                        if ($quote_data->accept_lead === 'Enter Qoute') {
                            $customer_html_new .= '<span style="
                            margin-bottom: 15px;
                            display: inline-block;
                        ">
                        <strong>Quote Amount:</strong>' . ' AED ' . $quote_data->qoute . '    (including 5% VAT)</span>';
                        }
                    }

                    $i++;
                }



                $customer_html_new .= '<p>' . $text2 . '</p>

                <p>' . $text3 . '
                </p>
                <p>If you have any questions or need further assistance, feel free to reach out to us at <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a> or call us at 056 VENDORS (836 3677).
                </p>
                <p>Thank you for choosing VendorsCity. We look forward to helping you find the best service providers for your needs.
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
                                <div class="footer_right" style="margin-left:10px;
                                float: left;">
                                    <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                                    <p style="margin:0;">VendorsCity Portal LLC</p>
                                    <div class="footer_links" style=" margin:10px 0;">
                                <a href="' . url("/terms-of-service") . '"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                <a href="' . url("/privacy-policy") . '"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                <a href="' . url("/contact") . '"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                                </div>
                                    <p style="margin:0;">This message was mailed to ' . $package_data->email . ' as part of you account registered with us on VendorsCity</p>
                                </div>
                            </div>
                     </div>
                 </div>
            </body>
			</html>';

                $subject = $subject_type;
                $to = $package_data->email;
                $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];

                Mail::send([], [], function ($message) use ($customer_html_new, $to,  $subject, $ccRecipients) {
                    $message->to($to, 'VendorsCity');
                    //  $message->bcc($bccEmails);
                    $message->subject($subject);
                    //$message->from('devang.hnrtechnologies@gmail.com','VendorsCity');
                    foreach ($ccRecipients as $ccRecipient) {
                        $message->bcc($ccRecipient);
                    }
                    $message->html($customer_html_new);
                });

                $package_count = $package_data->count + 1;

                DB::table('packages_enquiry')
                    ->where('id', $inquiryId)
                    ->update([
                        'count' => $package_count,
                    ]);

                return redirect()->route('vendorinquiry.index')->with('success', 'Inquiry Accept Successfully');
            } else {

                return redirect()->route('accpet_form', [
                    'package_inquiry_id' => $inquiryId,
                    'user_id' => $vendorId
                ])->with('error', $redirect_message);
            }
        } else {
            return redirect()->route('accpet_form', [
                'package_inquiry_id' => $inquiryId,
                'user_id' => $vendorId
            ])->with('error', 'Unfortunately, this request has already been accepted by 5 vendors. Don’t miss out on future opportunities—look out for notifications in your email and on your dashboard for the next available request!
');
        }

        /* echo $redirect_type;	
		
		echo"<pre>";print_r($package_data);echo"</pre>";
		z;print_r($subscription_vendor_data);echo"</pre>";
		
		
		exit; */
    }

    public function accept_lead_form(Request $request)
    {

        // echo"<pre>";print_r($request->all());echo"</pre>";exit;
        $qoute_includes_id = $request->qoute_includes_id;
        $qoute_include_value = $request->qoute_include_value;
        $qoute_includes_name = $request->qoute_includes_name;


        $userId = Auth::id();

        $inquiryId = $request->input('inquiry_id');
        $vendorId = $userId;
        $package_data = DB::table('packages_enquiry')->where('id', $inquiryId)->first();

        $already_user = DB::table('package_inquiry_accepted')->where('packages_inquiry_id', $inquiryId)->where('vendor_id', $vendorId)->first();

        // echo"<pre>";print_r($already_user);echo"</pre>";exit;

        if (!$already_user) {

            $package_count = $package_data->count + 1;

            DB::table('packages_enquiry')
                ->where('id', $inquiryId)
                ->update([
                    'count' => $package_count,
                ]);
        }

        $vendor_data = DB::table('users')->where('id', $vendorId)->first();

        $vendor_att_email = array();
        $vendor_data_attr = DB::table('vendors_attribute')->where('pid', $vendorId)->get()->toArray();

        // echo"<pre>";
        // print_r($vendor_data_attr);
        // echo"</pre>";
        // exit;

        foreach ($vendor_data_attr as $attr_data) {
            $vendor_att_email[] = $attr_data->c_email;
        }

        if (!empty($vendor_att_email)) {
            $cc = implode(',', $vendor_att_email);
        } else {
            $cc = '';
        }



        //      echo"<pre>";
        // print_r($vendor_att_email);
        // echo"</pre>";
        // exit;

        $redirect_type = 'success';
        $redirect_message = '';


        if ($package_data->count < 5) {
            // if($package_data->count < 5){
            //     echo "in";
            // }else{

            //     echo "out";
            // }

            // exit;

            $subscription_vendor_data = DB::table('subscription')
                //->where('services',$request->service_id)
                ->whereRaw('FIND_IN_SET(?, services)', [$package_data->service_id])
                ->whereRaw('FIND_IN_SET(?, sub_service)', [$package_data->subservice_id])
                ->where('vendor_id', '=', $vendorId)
                ->where('is_deleted', '=', '0')
                ->get()->toArray();

            // echo"<pre>ad";print_r($subscription_vendor_data);echo"</pre>";exit;

            $vendor_package_no_of_inquiry = 0;
            $vendor_lead_no_of_inquiry = 0;

            if (!empty($subscription_vendor_data)) {

                foreach ($subscription_vendor_data as $subscription_vendor_da) {
                    if ($subscription_vendor_da->type_of_subscription == 0) {
                        $vendor_package_no_of_inquiry += $subscription_vendor_da->no_of_inquiry_package;
                    } else {
                        $vendor_lead_no_of_inquiry += 1;
                    }
                }
            }

            $vendor_accept_inquiry_data = DB::table('package_inquiry_accepted')
                ->selectRaw('SUM(no_of_inquiry) as total_no_of_inquiry')
                ->where('vendor_id', $vendorId)
                ->where('accept_reject', 0)
                ->where('subscription_type', 'p')
                ->first();
            //echo"<pre>ad";print_r($vendor_accept_inquiry_data);echo"</pre>";;exit;
            if ($vendor_package_no_of_inquiry > $vendor_accept_inquiry_data->total_no_of_inquiry) {
                // echo "package";
                $data_package['packages_inquiry_id'] = $inquiryId;
                $data_package['vendor_id'] = $vendorId;
                $data_package['added_date'] = date('Y-m-d');
                $data_package['accept_reject'] = 0;
                $data_package['subscription_type'] = 'p';
                $data_package['no_of_inquiry'] = 1;
                $data_package['subscription_id'] = $subscription_vendor_data->id;
                $data_package['service_id'] = $package_data->service_id;
                $data_package['subservice_id'] = $package_data->subservice_id;
                $data_package['type_of_leads'] = $package_data->form_type;

                $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_package);



                //echo"<pre>ad";print_r($data_package);echo"</pre>";
            } else {

                //echo "leads";exit;

                // echo"<pre>";print_r($vendor_lead_no_of_inquiry);echo"</pre>";exit;
                if ($vendor_lead_no_of_inquiry != 0) {


                    $subs_service_id = explode(',', $subscription_vendor_data[0]->services);
                    $subs_subservice_id = explode(',', $subscription_vendor_data[0]->sub_service);

                    //  echo"<pre>";print_r($subs_service_id);echo"</pre>";exit;

                    if (in_array('30', $subs_service_id)) { // check only moving service
                        //echo "moving";exit;
                        $service_data = DB::table('services')->select('*')
                            ->where('id', 30)
                            ->first();

                        $local_form_field_array = explode(',', $service_data->form_fields);

                        if (in_array('20', $local_form_field_array)) {

                            //echo"in";exit;

                            $more_formfields_details_att = DB::table('more_formfields_details_att')->select('*')
                                ->where('package_inquiry_id', $inquiryId)
                                ->where('form_id', 20)
                                ->first();

                            //echo"<pre>";print_r($more_formfields_details_att);echo"</pre>";exit;

                            if (!empty($more_formfields_details_att)) {


                                if ($package_data->form_type == 'Local Move') {

                                    // echo "local move";exit;

                                    $subscription_local_move_attribute = DB::table('subscription_local_move_attribute')->select('*')
                                        ->where('subscription_id', $subscription_vendor_data[0]->id)
                                        ->where('form_id', 20)
                                        ->where('more_form_attributes_id', $more_formfields_details_att->more_form_attributes_id)
                                        ->first();
                                    // echo"<pre>ad";print_r($subscription_local_move_attribute);echo"</pre>";exit;

                                    $data_inquiry_local['packages_inquiry_id'] = $inquiryId;
                                    $data_inquiry_local['vendor_id'] = $vendorId;
                                    $data_inquiry_local['added_date'] = date('Y-m-d');
                                    $data_inquiry_local['accept_reject'] = 0;
                                    $data_inquiry_local['subscription_type'] = 'l';
                                    $data_inquiry_local['no_of_inquiry'] = 1;
                                    $data_inquiry_local['service_id'] = $package_data->service_id;
                                    $data_inquiry_local['subservice_id'] = $package_data->subservice_id;
                                    $data_inquiry_local['type_of_leads'] = $package_data->form_type;
                                    $data_inquiry_local['size_of_house_id'] = $more_formfields_details_att->more_form_attributes_id;
                                    $data_inquiry_local['price_of_lead'] = $subscription_local_move_attribute->local_move_charge;



                                    // echo"<pre>ad";print_r($data_inquiry_local);echo"</pre>";exit;

                                    if ($subscription_local_move_attribute->local_move_charge > 0) {
                                        $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_inquiry_local);
                                        //echo $id_package_inquiry_accepted."sfsf";exit;
                                        $data_wallet['vendors_id'] = $vendorId;
                                        $data_wallet['price'] = $subscription_local_move_attribute->local_move_charge;
                                        $data_wallet['add_deduct'] = 1;
                                        $data_wallet['subscription_id'] = $subscription_vendor_data[0]->id;

                                        $wallet_id = DB::table('wallets')->insertGetId($data_wallet);

                                        $vendor_data_new = DB::table('users')->where('id', $vendorId)->first();
                                        $year = date('y');
                                        $data_u['transaction_id'] = "TID-" . $vendor_data_new->vendor_id . "-" . $year . "-" . sprintf("%06d", $wallet_id);
                                        DB::table('wallets')->where('id', $wallet_id)->update($data_u);

                                        $vendors_data = DB::table('users')->where('id', $vendorId)->first();
                                        $vendor_wallet_amount = $vendors_data->wallet_amount - $subscription_local_move_attribute->local_move_charge;
                                        DB::table('users')->where('id', $vendorId)->update(['wallet_amount' => $vendor_wallet_amount]);
                                    } else {

                                        $subscription_subservice_attribute = DB::table('subscription_subservice_attribute')->select('*')
                                            ->where('subscription_id', $subscription_vendor_data[0]->id)
                                            ->where('service_id', $package_data->service_id)
                                            ->where('subservice_id', $package_data->subservice_id)
                                            ->first();


                                        $data_inquiry_other['packages_inquiry_id'] = $inquiryId;
                                        $data_inquiry_other['vendor_id'] = $vendorId;
                                        $data_inquiry_other['added_date'] = date('Y-m-d');
                                        $data_inquiry_other['accept_reject'] = 0;
                                        $data_inquiry_other['subscription_type'] = 'l';
                                        $data_inquiry_other['no_of_inquiry'] = 1;
                                        $data_inquiry_other['service_id'] = $package_data->service_id;
                                        $data_inquiry_other['subservice_id'] = $package_data->subservice_id;
                                        $data_inquiry_other['type_of_leads'] = $package_data->form_type;
                                        $data_inquiry_other['price_of_lead'] = $subscription_subservice_attribute->charge;

                                        $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_inquiry_other);


                                        $data_wallet['vendors_id'] = $vendorId;
                                        $data_wallet['price'] = $subscription_subservice_attribute->charge;
                                        $data_wallet['add_deduct'] = 1;
                                        $data_wallet['subscription_id'] = $subscription_vendor_data[0]->id;

                                        $wallet_id = DB::table('wallets')->insertGetId($data_wallet);

                                        $vendor_data_new = DB::table('users')->where('id', $vendorId)->first();
                                        $year = date('y');
                                        $data_u['transaction_id'] = "TID-" . $vendor_data_new->vendor_id . "-" . $year . "-" . sprintf("%06d", $wallet_id);
                                        DB::table('wallets')->where('id', $wallet_id)->update($data_u);

                                        $vendors_data = DB::table('users')->where('id', $vendorId)->first();
                                        $vendor_wallet_amount = $vendors_data->wallet_amount - $subscription_subservice_attribute->charge;
                                        DB::table('users')->where('id', $vendorId)->update(['wallet_amount' => $vendor_wallet_amount]);
                                    }
                                } else if ($package_data->form_type == 'International Move') {

                                    //  echo "international move";exit;

                                    $subscription_international_move_attribute = DB::table('subscription_international_move_attribute')->select('*')
                                        ->where('subscription_id', $subscription_vendor_data[0]->id)
                                        ->where('form_id', 20)
                                        ->where('more_form_attributes_id', $more_formfields_details_att->more_form_attributes_id)
                                        ->first();

                                    $data_inquiry_intl['packages_inquiry_id'] = $inquiryId;
                                    $data_inquiry_intl['vendor_id'] = $vendorId;
                                    $data_inquiry_intl['added_date'] = date('Y-m-d');
                                    $data_inquiry_intl['accept_reject'] = 0;
                                    $data_inquiry_intl['subscription_type'] = 'l';
                                    $data_inquiry_intl['no_of_inquiry'] = 1;
                                    $data_inquiry_intl['service_id'] = $package_data->service_id;
                                    $data_inquiry_intl['subservice_id'] = $package_data->subservice_id;
                                    $data_inquiry_intl['type_of_leads'] = $package_data->form_type;
                                    $data_inquiry_intl['size_of_house_id'] = $more_formfields_details_att->more_form_attributes_id;
                                    $data_inquiry_intl['price_of_lead'] = $subscription_international_move_attribute->local_move_charge;


                                    if ($subscription_international_move_attribute->local_move_charge > 0) {

                                        $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_inquiry_intl);

                                        $data_wallet['vendors_id'] = $vendorId;
                                        $data_wallet['price'] = $subscription_international_move_attribute->local_move_charge;
                                        $data_wallet['add_deduct'] = 1;
                                        $data_wallet['subscription_id'] = $subscription_vendor_data[0]->id;

                                        $wallet_id = DB::table('wallets')->insertGetId($data_wallet);

                                        $vendor_data_new = DB::table('users')->where('id', $vendorId)->first();
                                        $year = date('y');
                                        $data_u['transaction_id'] = "TID-" . $vendor_data_new->vendor_id . "-" . $year . "-" . sprintf("%06d", $wallet_id);
                                        DB::table('wallets')->where('id', $wallet_id)->update($data_u);

                                        $vendors_data = DB::table('users')->where('id', $vendorId)->first();
                                        $vendor_wallet_amount = $vendors_data->wallet_amount - $subscription_international_move_attribute->local_move_charge;
                                        DB::table('users')->where('id', $vendorId)->update(['wallet_amount' => $vendor_wallet_amount]);
                                    } else {

                                        $subscription_subservice_attribute = DB::table('subscription_subservice_attribute')->select('*')
                                            ->where('subscription_id', $subscription_vendor_data[0]->id)
                                            ->where('service_id', $package_data->service_id)
                                            ->where('subservice_id', $package_data->subservice_id)
                                            ->first();


                                        $data_inquiry_other['packages_inquiry_id'] = $inquiryId;
                                        $data_inquiry_other['vendor_id'] = $vendorId;
                                        $data_inquiry_other['added_date'] = date('Y-m-d');
                                        $data_inquiry_other['accept_reject'] = 0;
                                        $data_inquiry_other['subscription_type'] = 'l';
                                        $data_inquiry_other['no_of_inquiry'] = 1;
                                        $data_inquiry_other['service_id'] = $package_data->service_id;
                                        $data_inquiry_other['subservice_id'] = $package_data->subservice_id;
                                        $data_inquiry_other['type_of_leads'] = $package_data->form_type;
                                        $data_inquiry_other['price_of_lead'] = $subscription_subservice_attribute->charge;

                                        $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_inquiry_other);


                                        $data_wallet['vendors_id'] = $vendorId;
                                        $data_wallet['price'] = $subscription_subservice_attribute->charge;
                                        $data_wallet['add_deduct'] = 1;
                                        $data_wallet['subscription_id'] = $subscription_vendor_data[0]->id;

                                        $wallet_id = DB::table('wallets')->insertGetId($data_wallet);

                                        $vendor_data_new = DB::table('users')->where('id', $vendorId)->first();
                                        $year = date('y');
                                        $data_u['transaction_id'] = "TID-" . $vendor_data_new->vendor_id . "-" . $year . "-" . sprintf("%06d", $wallet_id);
                                        DB::table('wallets')->where('id', $wallet_id)->update($data_u);

                                        $vendors_data = DB::table('users')->where('id', $vendorId)->first();
                                        $vendor_wallet_amount = $vendors_data->wallet_amount - $subscription_subservice_attribute->charge;
                                        DB::table('users')->where('id', $vendorId)->update(['wallet_amount' => $vendor_wallet_amount]);
                                    }

                                    //echo"<pre>ad";print_r($subscription_international_move_attribute);echo"</pre>";

                                } else {

                                    //echo "other";exit;
                                    $redirect_type = 'error';
                                    $redirect_message = 'Your Subscription has been expire or finish. Please contact Vendorscity for new or renew Subscription.';
                                    // return redirect()->route('accpet_form', [
                                    //     'package_inquiry_id' => $inquiryId,
                                    //     'user_id' => $vendorId
                                    // ])->with('error', 'Your Subscription has been expire or finish. Please contact Vendorscity for new or renew Subscription.');
                                }
                            } else {


                                if ($package_data->subservice_id == 31) {

                                    $package_att_data = DB::table('more_formfields_details')
                                        ->where('package_inquiry_id', $package_data->id)
                                        ->where('form_field_id', 42)
                                        ->first();
                                    $form_attributes_val = DB::table('form_attributes')
                                        ->where('id', $package_att_data->formfield_value)
                                        ->first();

                                    $subscription_subservice_attribute = DB::table('subscription_subservice_attribute')->select('*')
                                        ->where('subscription_id', $subscription_vendor_data[0]->id)
                                        ->where('service_id', $package_data->service_id)
                                        ->where('subservice_id', $package_data->subservice_id)
                                        ->first();

                                    $price_of_lead = $subscription_subservice_attribute->charge * $form_attributes_val->form_option;

                                    $data_inquiry_other['packages_inquiry_id'] = $inquiryId;
                                    $data_inquiry_other['vendor_id'] = $vendorId;
                                    $data_inquiry_other['added_date'] = date('Y-m-d');
                                    $data_inquiry_other['accept_reject'] = 0;
                                    $data_inquiry_other['subscription_type'] = 'l';
                                    $data_inquiry_other['no_of_inquiry'] = 1;
                                    $data_inquiry_other['service_id'] = $package_data->service_id;
                                    $data_inquiry_other['subservice_id'] = $package_data->subservice_id;
                                    $data_inquiry_other['type_of_leads'] = $package_data->form_type;
                                    $data_inquiry_other['price_of_lead'] = $price_of_lead;

                                    $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_inquiry_other);


                                    $data_wallet['vendors_id'] = $vendorId;
                                    $data_wallet['price'] = $price_of_lead;
                                    $data_wallet['add_deduct'] = 1;
                                    $data_wallet['subscription_id'] = $subscription_vendor_data[0]->id;

                                    $wallet_id = DB::table('wallets')->insertGetId($data_wallet);

                                    $vendor_data_new = DB::table('users')->where('id', $vendorId)->first();
                                    $year = date('y');
                                    $data_u['transaction_id'] = "TID-" . $vendor_data_new->vendor_id . "-" . $year . "-" . sprintf("%06d", $wallet_id);
                                    DB::table('wallets')->where('id', $wallet_id)->update($data_u);

                                    $vendors_data = DB::table('users')->where('id', $vendorId)->first();
                                    $vendor_wallet_amount = $vendors_data->wallet_amount - $price_of_lead;
                                    DB::table('users')->where('id', $vendorId)->update(['wallet_amount' => $vendor_wallet_amount]);

                                    //echo "<pre>";print_r($form_attributes_val);echo"</pre>";
                                } else {



                                    //echo $package_data->subservice_id;exit;
                                    $subscription_subservice_attribute = DB::table('subscription_subservice_attribute')->select('*')
                                        ->where('subscription_id', $subscription_vendor_data[0]->id)
                                        ->where('service_id', $package_data->service_id)
                                        ->where('subservice_id', $package_data->subservice_id)
                                        ->first();

                                    //echo "<pre>";print_r($subscription_subservice_attribute);echo"</pre>";exit;


                                    $data_inquiry_other['packages_inquiry_id'] = $inquiryId;
                                    $data_inquiry_other['vendor_id'] = $vendorId;
                                    $data_inquiry_other['added_date'] = date('Y-m-d');
                                    $data_inquiry_other['accept_reject'] = 0;
                                    $data_inquiry_other['subscription_type'] = 'l';
                                    $data_inquiry_other['no_of_inquiry'] = 1;
                                    $data_inquiry_other['service_id'] = $package_data->service_id;
                                    $data_inquiry_other['subservice_id'] = $package_data->subservice_id;
                                    $data_inquiry_other['type_of_leads'] = $package_data->form_type;
                                    $data_inquiry_other['price_of_lead'] = $subscription_subservice_attribute->charge;

                                    $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_inquiry_other);


                                    $data_wallet['vendors_id'] = $vendorId;
                                    $data_wallet['price'] = $subscription_subservice_attribute->charge;
                                    $data_wallet['add_deduct'] = 1;
                                    $data_wallet['subscription_id'] = $subscription_vendor_data[0]->id;

                                    $wallet_id = DB::table('wallets')->insertGetId($data_wallet);

                                    $vendor_data_new = DB::table('users')->where('id', $vendorId)->first();
                                    $year = date('y');
                                    $data_u['transaction_id'] = "TID-" . $vendor_data_new->vendor_id . "-" . $year . "-" . sprintf("%06d", $wallet_id);
                                    DB::table('wallets')->where('id', $wallet_id)->update($data_u);

                                    $vendors_data = DB::table('users')->where('id', $vendorId)->first();
                                    $vendor_wallet_amount = $vendors_data->wallet_amount - $subscription_subservice_attribute->charge;
                                    DB::table('users')->where('id', $vendorId)->update(['wallet_amount' => $vendor_wallet_amount]);
                                }
                            }
                        } else {
                            $redirect_type = 'error';
                            $redirect_message = 'test';
                        }
                    } else {

                        //echo "no moving";exit;

                        $subscription_subservice_attribute = DB::table('subscription_subservice_attribute')->select('*')
                            ->where('subscription_id', $subscription_vendor_data[0]->id)
                            ->where('service_id', $package_data->service_id)
                            ->where('subservice_id', $package_data->subservice_id)
                            ->first();


                        $data_inquiry_other['packages_inquiry_id'] = $inquiryId;
                        $data_inquiry_other['vendor_id'] = $vendorId;
                        $data_inquiry_other['added_date'] = date('Y-m-d');
                        $data_inquiry_other['accept_reject'] = 0;
                        $data_inquiry_other['subscription_type'] = 'l';
                        $data_inquiry_other['no_of_inquiry'] = 1;
                        $data_inquiry_other['service_id'] = $package_data->service_id;
                        $data_inquiry_other['subservice_id'] = $package_data->subservice_id;
                        $data_inquiry_other['type_of_leads'] = $package_data->form_type;
                        $data_inquiry_other['price_of_lead'] = $subscription_subservice_attribute->charge;

                        $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_inquiry_other);
                    }
                } else {

                    $redirect_type = 'error';
                    $redirect_message = 'Your Subscription has been expire or finish. Please contact Vendorscity for new or renew Subscription.';

                    // return redirect()->route('accpet_form', [
                    //     'package_inquiry_id' => $inquiryId,
                    //     'user_id' => $vendorId
                    // ])->with('error', 'Your Subscription has been expire or finish. Please contact Vendorscity for new or renew Subscription.');

                    // return redirect()->route('accept.form', ['param1' => $param1, 'param2' => $param2])
                    //  ->with('success', 'Inquiry Accept Successfully');

                    // return redirect()->route('vendorinquiry.index')->with('success', 'Inquiry Accept Successfully');
                    //echo "error";
                }
            }

            //return redirect()->route('vendorinquiry.index')->with('success', 'Inquiry Accept Successfully');


            // echo "sfas".$vendor_lead_no_of_inquiry;


            //

            if ($redirect_type == 'success') {
            }



            if (!empty($id_package_inquiry_accepted)) {

                $data_n['accept_lead'] = $request->accept_lead;
                $data_n['qoute'] = $request->qoute;

                if (!empty($qoute_includes_id)) {

                    foreach ($qoute_includes_id as $key => $value) {

                        $data_n['package_inquiry_accepted_id'] = $id_package_inquiry_accepted;
                        $data_n['packages_inquiry_id'] = $inquiryId;
                        $data_n['vendor_id'] = $vendorId;
                        $data_n['qoute_includes_id'] = $value;
                        $data_n['qoute_include_value'] = $qoute_include_value[$key];
                        $data_n['qoute_includes_name'] = $qoute_includes_name[$key];
                        $data_n['added_date'] = date('Y-m-d');

                        DB::table('qoute_includes')->insert($data_n);
                    }
                }
            }

            //     $data['packages_inquiry_id']=$inquiryId;
            //     $data['vendor_id'] = $vendorId;
            //     $data['accept_reject'] = 0;
            //     $data['added_date'] = date('Y-m-d');

            //    $id_package =  DB::table('package_inquiry_accepted')->insertGetId($data);

            //    $data_n['accept_lead']=$request->accept_lead;
            //    $data_n['qoute']=$request->qoute;

            //     if(!empty($qoute_includes_id)){

            //         foreach($qoute_includes_id as $key => $value){

            //             $data_n['package_inquiry_accepted_id']=$id_package;
            //             $data_n['packages_inquiry_id']=$inquiryId;
            //             $data_n['vendor_id'] = $vendorId;
            //             $data_n['qoute_includes_id'] = $value;
            //             $data_n['qoute_include_value'] = $qoute_include_value[$key];
            //             $data_n['qoute_includes_name'] = $qoute_includes_name[$key];
            //             $data_n['added_date'] = date('Y-m-d');

            //             DB::table('qoute_includes')->insert($data_n);
            //         }
            //     }

            $form_fields_data = DB::table('more_formfields_details')->where('package_inquiry_id', $inquiryId)->get()->toArray();

            $field_array = array();
            foreach ($form_fields_data as $key => $values) {

                $form_fields = DB::table('form_fileds')
                    ->select('*')
                    ->where('id', $values->form_field_id)
                    ->first();

                if ($values->formfield_value != '') {
                    //echo "inner<br>";
                    // If the key doesn't exist, add the entry to the array
                    $field_array[$key] = array('name' => $form_fields->lable_name, 'value' => $values->formfield_value, 'id' => $form_fields->id, 'mail_send' => $form_fields->mail_send);
                }
            }

            // $quote_includes_data = DB::table('qoute_includes')->where('packages_inquiry_id',$inquiryId)->where('vendor_id',$vendor_data->id)->get()->toArray();

            // echo"<pre>";print_r($vendorId);echo"</pre>";exit;


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
                    #table_new,#table_new
                    th,
                    #table_new td {
                        border: 1px solid black;
                        border-collapse: collapse;
                    }

                    .custome_td{
                            background-color: #0040E6;
                            color: #fff;
                            padding: 10px 60px 10px 12px;
                            border-bottom-color: #fff !important;
                    }
                    .custome_td_new{
                            padding: 10px 12px;
                    }
                    .cutomer_td{
                        text-align:center;
                        background-color: #0040E6;
                        color: #fff;
                        border-bottom-color: #fff !important;
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
                    <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                        
                    <p>Dear ' . $vendor_data->name . ',</p>  
                   
                    <p>Congratulations! You have successfully accepted a new lead on VendorsCity. Below, you Will find the customer information necessary to fulfill the request.</p>

                    <span><strong>Your Quote:</strong></span>';

            $quote_includes_data = DB::table('qoute_includes')->where('packages_inquiry_id', $inquiryId)->where('vendor_id', $vendor_data->id)->get()->toArray();

            if (isset($quote_includes_data[0]) && $quote_includes_data[0]->accept_lead == 'Enter Qoute') {

                $html .= '<table style="width: 100%;border: 1px solid #000;border-collapse: collapse;">
                                    <tr>
                                        <th style="text-align: left;border: 1px solid #000;   background-color: #0040e6;color: #fff;padding: 10px 60px 10px 12px;">Quote</th>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;border: 1px solid #000;padding: 10px 60px 10px 12px;">' . $quote_includes_data[0]->qoute . ' AED (Including 5% VAT)</td>
                                    </tr>
                                  </table>';
            } else {

                $html .= '<table style="width: 100%;">
                            <tr>
                                <th style="text-align: left;border: 1px solid #000;   background-color: #0040e6;color: #fff;padding: 10px 60px 10px 12px;">Quote</th>
                                <th style="text-align: left;border: 1px solid #000;   background-color: #0040e6;color: #fff;padding: 10px 60px 10px 12px;">Additional Information</th> 
                            </tr>
                            <tr>
                                <td style="text-align: left;border: 1px solid #000;padding: 10px 60px 10px 12px;">Based On Final Survey</td>
                                <td style="text-align: left;border: 1px solid #000;padding: 10px 60px 10px 12px;">This lead is chargeable. There was no quote provided to the client. Please quote the client directly via email and copy <a style="color: #555;tetext-decoration: inherit;" href="mailto:support@vendorscity.com">support@vendorscity.com</a> for our record.</td>
                            </tr>
                    </table>';
            }
            $html .= '<br>
                    <span><strong>Customer Details:</strong></span>
                    <table id="table_new" style="width: 100%;border: 1px solid black;
                        border-collapse: collapse;">
                        
                        <tr>
                            <td class="custome_td" style="background-color: #0040E6;
                            color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;border-collapse: collapse;">Name:</td>
                            <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;border-collapse: collapse;"> ' . $package_data->name . '</td>
                        </tr>
                        <tr>
                            <td class="custome_td" style="background-color: #0040E6;
                            color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;border-collapse: collapse;">Email:</td>
                            <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;border-collapse: collapse;"> ' . $package_data->email . '</td>
                        </tr>
                        <tr>
                            <td class="custome_td" style="background-color: #0040E6;
                            color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;
                        border-collapse: collapse;">Mobile No:</td>
                            <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;
                        border-collapse: collapse;"> ' . $package_data->mobile . '</td>
                        </tr>';

            if (!empty($field_array)) {
                $i = 0;
                foreach ($field_array as $form_field_data) {
                    if (!empty($form_field_data['mail_send']) && $form_field_data['mail_send'] == '1') {

                        $get_more_id = DB::table('more_formfields_details_att')
                            ->where('form_id', '=', $form_field_data['id'])
                            ->where('package_inquiry_id', '=', $inquiryId)
                            ->get()
                            ->toArray();

                        // echo "<pre>";print_r($form_field_data);echo "</pre>";




                        if ($form_field_data['value'] != '') {
                            $html .= '<tr>';
                            if ($form_field_data['id'] != $i) {
                                $html .= '<td class="custome_td" style="background-color: #0040E6;
                                                    color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;
                        border-collapse: collapse;">' . $form_field_data['name'] . '</td>  ';
                            }

                            if (is_numeric($form_field_data['value']) && $form_field_data['id'] != 30 && $form_field_data['id'] != 60) {
                                $html .= '<td   class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;
                        border-collapse: collapse;">' . \Helper::form_fields_attr($form_field_data['value']) . '</td>';
                            } else {

                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];
                                $extension = pathinfo($form_field_data['value'], PATHINFO_EXTENSION);

                                if (in_array(strtolower($extension), $imageExtensions)) {
                                    // if($form_field_data['id'] == $i){                                                                                                                                              
                                    $html .= '<td colspan="2" class="text-center"><a href="' . url('download/' . $form_field_data['value']) . '">Download</a></td>';
                                    // }
                                } else {
                                    $html .= '<td  class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;
                                                    border-collapse: collapse;" >' . $form_field_data['value'] . '</td>';
                                }
                            }
                            $html .= ' </tr>';
                        }
                        // echo "<pre>";print_r($get_more_id);echo "</pre>";

                        if (isset($get_more_id) && count($get_more_id) > 0) {
                            foreach ($get_more_id as $get_more_id_data) {
                                $html .= '<tr>';
                                if ($form_field_data['value'] == 111 && $form_field_data['id'] == 35) {
                                    $html .= '<td class="custome_td" style="background-color: #0040E6;
                                                    color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;"> What days of the week would you like the service</td>';
                                } else {
                                    $html .= '<td  class="custome_td" style="background-color: #0040E6;
                                                    color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;"> Type of Home</td>';
                                }
                                $html .= '                                          
                                        <td class="custome_td_new" style=" padding: 10px 12px;">' . \Helper::form_fields_attr_more($get_more_id_data->more_form_attributes_id) . '</td>                                               
                                      </tr>';
                            }
                        }
                    }

                    $i = $form_field_data['id'];
                }
            }


            $html .= '</table>

                        <p><strong>Next Steps:</strong></p>
                        <ol>
                            <li><strong>Contact the Customer:</strong> Confirm the service details and any additional requirements with the customer.</li>
                            <li><strong>Prepare for the Service:</strong>Make necessary preparations to fulfill the customer is request as specified.</li>
                            <li><strong>Complete the Service:</strong>Ensure the service is carried out professionally and to the customer is satisfaction.</li>
                            <li><strong>Payment Collection:</strong>If this is a Cash on Delivery (COD) order, collect the full payment upon job completion.</li>
                        </ol>
                        
                        <p>If you have any questions or need assistance, please do not hesitate to contact our vendor support team at <a style="color: #555;" href="mailto:vendors@vendorscity.com"> vendors@vendorscity.com</a>or call us at 056 VENDORS (836 3677).
                        </p>


                   
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
                                <div class="footer_right" style="margin-left:10px;
                                float: left;">
                                    <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a></p>
                                    <p style="margin:0;">VendorsCity Portal LLC</p>
                                    <div class="footer_links" style=" margin:10px 0;">
                                <a href="' . url("/terms-of-service") . '"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                <a href="' . url("/privacy-policy") . '"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                <a href="' . url("/contact") . '"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                                </div>
                                    
                                </div>
                            </div>
                      </div>
                </div>
            </body>
        </html>';

            // echo $html;exit;

            // new mail end---------------------------------------------------------------------------------------------

            // echo "<pre>";print_r($html);echo "</pre>";exit;

            //  echo $vendor_data->email; 
            // echo $html;
            //$subject = "Here are your Customer's details ! Customer : $package_data->name";
            $subject = "VendorsCity Lead Accepted for " . $package_data->name . "! Here Are the Details";

            $to = $vendor_data->email;

            $ccRecipients = explode(',', $cc);

            $ccRecipients = array_filter($ccRecipients, 'strlen');
            $staticEmails = ['zafar@quickserverelo.com', 'hello@vendorscity.com'];
            $ccRecipients = array_merge($ccRecipients, $staticEmails);
            //echo "<pre>";print_r($ccRecipients);echo "</pre>";exit;
            // $to='abhishek.hnrtechnologies@gmail.com';


            // $bccEmails = ["patelnikul321@gmail.com", "asmit@digitalsadhus.com"];

            if ($redirect_type == 'success') {
                Mail::send([], [], function ($message) use ($html, $to,  $subject, $ccRecipients) {
                    $message->to($to, 'VendorsCity');
                    //  $message->bcc($bccEmails);
                    $message->subject($subject);
                    //$message->from('devang.hnrtechnologies@gmail.com','VendorsCity');
                    foreach ($ccRecipients as $ccRecipient) {
                        $message->bcc($ccRecipient);
                    }
                    $message->html($html);
                });
            }


            $quote_includes_data = DB::table('qoute_includes')->where('packages_inquiry_id', $inquiryId)->where('vendor_id', $vendorId)->get()->toArray();

            // echo "<pre>";print_r($quote_includes_data);echo "</pre>";exit;

            $form_fields_data = DB::table('more_formfields_details')->where('package_inquiry_id', $inquiryId)->get()->toArray();

            $field_array = array();
            foreach ($form_fields_data as $key => $values) {

                $form_fields = DB::table('form_fileds')
                    ->select('*')
                    ->where('id', $values->form_field_id)
                    ->first();

                if ($values->formfield_value != '') {
                    //echo "inner<br>";
                    // If the key doesn't exist, add the entry to the array
                    $field_array[$key] = array('name' => $form_fields->lable_name, 'value' => $values->formfield_value, 'id' => $form_fields->id, 'mail_send' => $form_fields->mail_send);
                }
            }




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
                    #table_new,#table_new
                    th,
                    #table_new td {
                        border: 1px solid black;
                        border-collapse: collapse;
                    }

                    .custome_td{
                            background-color: #0040E6;
                            color: #fff;
                            padding: 10px 60px 10px 12px;
                            border-bottom-color: #fff !important;
                            width:50%;
                    }
                    .custome_td_new{
                            padding: 10px 12px;
                    }
                    .cutomer_td{
                        text-align:center;
                        background-color: #0040E6;
                        color: #fff;
                        border-bottom-color: #fff !important;
                    }
                </style>
            </head>
            <body>
                <div class="wrapper">
                    <div class="logo" style="float: inherit;">
                    <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" >
                    </div>
                    <div class="email_wrapper">
                        
                    <p>Dear ' . $package_data->name . ',</p>  
                    <p>You have received a quote from the vendor :' . $vendor_data->name . '</p>
                    <p>Below you will find the quote details.</p>
                    <p>Quotation from Vendor :</p>
                    <table id="table_new" style="width:100%;">
                        <tr><td colspan="2" class="cutomer_td">Vendor Name:' . $vendor_data->name . '</td></tr>';

            $html .= '<tr>';
            $html .= '<td class="custome_td">Status: </td>';
            $html .= '<td class="custome_td_new">';
            $i = 0;

            foreach ($quote_includes_data as $quote_data) {
                if ($i == 0) {

                    if ($quote_data->accept_lead === 'Enter Qoute') {
                        $html .= 'Quoted';
                        $html .= '<tr>';
                        $html .= '<td class="custome_td">Qoute:</td>';
                        $html .= '<td class="custome_td_new">' . $quote_data->qoute . '</td>';
                        $html .= '</tr>';
                    } else {
                        $html .= 'Request Survey';
                    }
                }
                $i++;
            }
            $html .= '</td>';
            $html .= '</tr>';

            $html .= '<tr>
                            <td class="custome_td">Service Requested:</td>
                            <td class="custome_td_new">' . ($package_data->form_type) . '</td>
                        </tr>
                        <tr>
                            <td class="custome_td">Vendor Email</td>
                        <td class="custome_td_new">' . $vendor_data->email . '
                            </td>
                        </tr>
                        <tr>
                            <td class="custome_td">Vendor Phone Number</td>
                            <td class="custome_td_new">' . $vendor_data->mobile . '</td>
                        </tr>';

            foreach ($quote_includes_data as $quote_data) {
                $html .= '<tr>';
                $html .= '<td class="custome_td">' . $quote_data->qoute_includes_name . '</td>';
                $html .= '<td class="custome_td_new">' . $quote_data->qoute_include_value . '</td>';
                $html .= '</tr>';
            }


            if (!empty($field_array)) {
                $i = 0;
                foreach ($field_array as $form_field_data) {
                    if (!empty($form_field_data['mail_send']) && $form_field_data['mail_send'] == '1') {

                        $get_more_id = DB::table('more_formfields_details_att')
                            ->where('form_id', '=', $form_field_data['id'])
                            ->where('package_inquiry_id', '=', $inquiryId)
                            ->get()
                            ->toArray();

                        // echo "<pre>";print_r($form_field_data);echo "</pre>";




                        if ($form_field_data['value'] != '') {
                            $html .= '<tr>';
                            if ($form_field_data['id'] != $i) {
                                $html .= '<td class="custome_td">' . $form_field_data['name'] . '</td>  ';
                            }

                            if (is_numeric($form_field_data['value']) && $form_field_data['id'] != 30 && $form_field_data['id'] != 60) {
                                $html .= '<td  class="custome_td_new">' . \Helper::form_fields_attr($form_field_data['value']) . '</td>';
                            } else {

                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];
                                $extension = pathinfo($form_field_data['value'], PATHINFO_EXTENSION);

                                if (in_array(strtolower($extension), $imageExtensions)) {
                                    // if($form_field_data['id'] == $i){                                                                                                                                              
                                    $html .= '<td colspan="2" class="text-center"><a href="' . url('download/' . $form_field_data['value']) . '">Download</a></td>';
                                    // }
                                } else {
                                    $html .= '<td  class="custome_td_new">' . $form_field_data['value'] . '</td>';
                                }
                            }

                            $html .= ' </tr>';
                        }
                        // echo "<pre>";print_r($get_more_id);echo "</pre>";

                        if (isset($get_more_id) && count($get_more_id) > 0) {
                            foreach ($get_more_id as $get_more_id_data) {
                                $html .= '<tr>';
                                if ($form_field_data['value'] == 111 && $form_field_data['id'] == 35) {
                                    $html .= '<td class="custome_td"> What days of the week would you like the service</td>';
                                } else {
                                    $html .= '<td  class="custome_td">Type of Home</td>';
                                }
                                $html .= '                                          
                                        <td class="custome_td_new">' . \Helper::form_fields_attr_more($get_more_id_data->more_form_attributes_id) . '</td>                                               
                                      </tr>';
                            }
                        }
                    }

                    $i = $form_field_data['id'];
                }
            }

            $html .= '</table>


                   
                    <div class="email_footer">
                        <h3>The VendorsCity Team</h3>
                        <div class="email_footer_div">
                            <div class="footer_left">
                                <img style="width:100%;" src="' . asset("public/site/images/vcfaviconwap.png") . '"" >
                            </div>
                            <div class="footer_right">
                                <p>Questions? Email <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                                <p>VendorsCity Portal LLC</p>
                                <div class="footer_links">
                                <a href="' . url("/terms-of-service") . '">Terms of Use</a>
                                <a href="' . url("/privacy-policy") . '">Privacy Policy</a>
                                <a href="' . url("/contact") . '">Contact Us</a>
                                </div>
                                <p>This message was mailed to ' . $vendor_data->email . ' as part of you account registered with us on VendorsCity</p>
                            </div>
                        </div>
                    </div>
                </div>
            </body>
        </html>';


            $customer_html_new = '';

            $customer_html_new .= '<!doctype html>

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
                   <p>  Dear ' . $package_data->name . ',</p>
                   <p>We hope this email finds you well.</p>';


            $quote_includes_data = DB::table('qoute_includes')->where('packages_inquiry_id', $inquiryId)->where('vendor_id', $vendor_data->id)->get()->toArray();

            //echo "<pre>";print_r($quote_includes_data);echo"</pre>";exit;

            if (!empty($quote_includes_data) && isset($quote_includes_data[0]->accept_lead) && $quote_includes_data[0]->accept_lead == 'Enter Qoute') {
                $text1 = "We are excited to inform you that a vendor has submitted a quote for the service you requested on VendorsCity. Here are the details:";

                $text2 = "The vendor will contact you soon to discuss the details further. If you do not hear from the vendor within the next 24 hours, please contact them directly at " . $vendor_data->mobile . ".";

                $text3 = "You can compare the quote with others you might receive and select the one that best fits your needs.";

                $subject_type = "New Quote Received for Your " . \Helper::servicename($package_data->service_id) . " Request on VendorsCity!
";
            } else {

                $text1 = "A vendor has reviewed your service request on VendorsCity and would like to conduct a survey before providing an accurate quote. Here are the details:";

                $text2 = "The vendor will contact you soon to confirm the survey details.  If you do not hear from the vendor within the next 24 hours, please contact them directly at " . $vendor_data->mobile . ".";

                $text3 = "This survey will help the vendor understand your specific needs and ensure you receive the most accurate and competitive quote for the service.
";

                $subject_type = "Survey Request for Your " . \Helper::servicename($package_data->service_id) . " Request on VendorsCity!
";
            }

            $customer_html_new .= '<p>' . $text1 . '<br><br>';


            $customer_html_new .= '<span style="
                    margin-bottom: 15px;
                    display: inline-block;
                "><strong>Service Requested: </strong>' .  \Helper::servicename($package_data->service_id) . '</span><br>';

            $customer_html_new .= '<span style="
                    margin-bottom: 15px;
                    display: inline-block;
                ">
                                <strong>Vendor Name:</strong> ' . $vendor_data->name . '</span><br>
                                <span style="
                    margin-bottom: 15px;
                    display: inline-block;
                ">
                                <strong>Vendor Contact:</strong> ' . $vendor_data->mobile . '</span><br>';


            $i = 0;
            foreach ($quote_includes_data as $quote_data) {

                if ($i == 0) {

                    if ($quote_data->accept_lead === 'Enter Qoute') {
                        $customer_html_new .= '<span style="
                            margin-bottom: 15px;
                            display: inline-block;
                        ">
                        <strong>Quote Amount:</strong>' . ' AED ' . $quote_data->qoute . '    (including 5% VAT)</span>';
                    }
                }

                $i++;
            }



            $customer_html_new .= '<p>' . $text2 . '</p>

                <p>' . $text3 . '
                </p>
                <p>If you have any questions or need further assistance, feel free to reach out to us at <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a> or call us at 056 VENDORS (836 3677).
                </p>
                <p>Thank you for choosing VendorsCity. We look forward to helping you find the best service providers for your needs.
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
                                <div class="footer_right" style="margin-left:10px;
                                float: left;">
                                    <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                                    <p style="margin:0;">VendorsCity Portal LLC</p>
                                    <div class="footer_links" style=" margin:10px 0;">
                                <a href="' . url("/terms-of-service") . '"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                <a href="' . url("/privacy-policy") . '"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                <a href="' . url("/contact") . '"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                                </div>
                                    <p style="margin:0;">This message was mailed to ' . $package_data->email . ' as part of you account registered with us on VendorsCity</p>
                                </div>
                            </div>
                     </div>
                 </div>
            </body>




</html>';


            // echo $html;exit;

            // new mail end---------------------------------------------------------------------------------------------

            // echo "<pre>";print_r($html);echo "</pre>";exit;

            //  echo $vendor_data->email; 
            // echo $html;
            // $subject = "Here is the Quotation from VendorCity! Vendor :$vendor_data->name";
            $subject = $subject_type;
            $to = $package_data->email;
            $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
            //  $ccRecipients = explode(',', $cc);
            // $to='abhishek.hnrtechnologies@gmail.com';



            if ($redirect_type == 'success') {
                //  $bccEmails = ["patelnikul321@gmail.com", "asmit@digitalsadhus.com"];
                Mail::send([], [], function ($message) use ($customer_html_new, $to,  $subject, $ccRecipients) {
                    $message->to($to, 'VendorsCity');
                    //  $message->bcc($bccEmails);
                    $message->subject($subject);
                    //$message->from('devang.hnrtechnologies@gmail.com','VendorsCity');
                    foreach ($ccRecipients as $ccRecipient) {
                        $message->bcc($ccRecipient);
                    }
                    $message->html($customer_html_new);
                });
            }

            if ($redirect_type == 'success') {
                return redirect()->route('vendorinquiry.index')->with('success', 'Inquiry Accept Successfully');
            } else {

                return redirect()->route('accpet_form', [
                    'package_inquiry_id' => $inquiryId,
                    'user_id' => $vendorId
                ])->with('error', $redirect_message);
            }
        } else {
            return redirect()->route('accpet_form', [
                'package_inquiry_id' => $inquiryId,
                'user_id' => $vendorId
            ])->with('error', 'Unfortunately, this request has already been accepted by 5 vendors. Don’t miss out on future opportunities—look out for notifications in your email and on your dashboard for the next available request!
');
        }
    }
}
