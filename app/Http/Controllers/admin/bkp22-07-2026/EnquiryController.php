<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use DateTime;
use App\Models\Admin\Form_filed;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $startdate = $request->s_date;
        $enddate = $request->e_date;
        $servicename = $request->servicename;
        $customer_name = $request->customer_name;

        $query = DB::table('packages_enquiry')->whereIn('service_id', [30, 44]);

        if ($startdate != '') {
            $query = $query->where('added_date', '>=', date('Y-m-d', strtotime($startdate)));
        }

        if ($enddate != '') {
            $query = $query->where('added_date', '<=', date('Y-m-d', strtotime($enddate)));
        }
        if ($servicename != '') {
            $query = $query->where('service_id', $servicename);
        }
        if ($customer_name != '') {
            $query = $query->where('name', $customer_name);
        }


        $data['startdate'] = $startdate;
        $data['enddate'] = $enddate;
        $data['filter_service_id'] = $servicename;
        $data['filter_customer_name'] = $customer_name;

        $data['service_data'] = DB::table('services')->get();

        $data['system'] = DB::table('system')->first();

        $data['customer_data'] = DB::table('packages_enquiry')->groupBy('name')->get();

        $data['packages_data'] = $query->orderBy('id', 'DESC')->get();

        return view('admin.list_packagesenquiry', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function manual_assign_lead()
    {

        // echo"<pre>";print_r($_POST);echo"</pre>";exit;
        $inquiry_id = $_POST['inquiry_id'];

        $lead_inquiry_Data = DB::table('packages_enquiry')
            ->where('id', $inquiry_id)
            ->first();

        $package_inquiry_accepted_data = DB::table('package_inquiry_accepted')
            ->where('packages_inquiry_id', $inquiry_id)
            ->get();

        // echo"<pre>";print_r($package_inquiry_accepted_data);echo"</pre>";exit;

        $html = '';

        if (!$package_inquiry_accepted_data->isEmpty()) {
            $html .= '<table style="margin: 0 auto; border-collapse: collapse; border: 1px solid black; width: 100%;">';
            $html .= '<tr>';
            $html .= '<th style="text-align: center; border: 1px solid black; padding: 10px;" colspan="2">Assign Vendors</th>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<th style="text-align: center; border: 1px solid black; padding: 10px;">Vendor Name</th>';
            $html .= '<th style="text-align: center; border: 1px solid black; padding: 10px;">Assigned Date</th>';
            $html .= '</tr>';
            foreach ($package_inquiry_accepted_data as $data) {
                $html .= '<tr>';
                $html .= '<td style="text-align: center; border: 1px solid black; padding: 10px;">' . \Helper::vendorsname($data->vendor_id) . '</td>';
                $html .= '<td style="text-align: center; border: 1px solid black; padding: 10px;">' . $data->added_date . '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
        }



        $html .= '<label>Select a Vendor</label>';
        $html .= '<select id="manual_lead_vendor_id" name="manual_lead_vendor_id[]" class="form-control vendor-mul-drop select2" multiple="multiple" placeholder="Please Select Vendor">';

        $html .= "<option value='' placeholder='Please Select Vendor'>Select Vendor</option>";

        $vendor_data = DB::table('users')
            ->whereRaw("FIND_IN_SET(?, serviceList)", [$lead_inquiry_Data->service_id])
            ->where('vendor', 1)
            ->where('is_active', 0)
            ->get()->toArray();

        $more_formfields_details_data = DB::table('more_formfields_details')
            ->where('package_inquiry_id', $lead_inquiry_Data->id)
            ->where('form_field_id', 17)
            ->first();

        if ($more_formfields_details_data) {
            $form_attributes_data = DB::table('form_attributes')
                ->where(
                    'id',
                    $more_formfields_details_data->formfield_value
                )
                ->first();


            $city_data = DB::table('cities')
                ->where('name', $form_attributes_data->form_option)
                ->first();



            if ($lead_inquiry_Data->form_type == 'International Move') {
                $typeOfPackage = 1;
            } elseif ($lead_inquiry_Data->form_type == 'Local Move') {
                $typeOfPackage = 0;
            } else {
                $typeOfPackage = "";
            }


            // Initialize an array to keep track of added vendor IDs
            $processed_vendor_ids = [];

            // Loop through vendor data
            foreach ($vendor_data as $vendor_data_new) {
                $subscription_vendor_data = DB::table('subscription')
                    ->whereRaw('FIND_IN_SET(?, services)', [$lead_inquiry_Data->service_id])
                    ->whereRaw('FIND_IN_SET(?, sub_service)', [$lead_inquiry_Data->subservice_id])
                    ->whereRaw('FIND_IN_SET(?, city)', [$city_data->id])
                    ->where('is_deleted', '=', '0')
                    ->where('type_of_subscription', '=', 2)
                    ->where('type_of_package', '=', $typeOfPackage)
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();

                foreach ($subscription_vendor_data as $subscription_vendor_data_new) {
                    // Get vendor IDs from the subscription data
                    $vendor_ids = explode(",", $subscription_vendor_data_new->vendor_id);

                    foreach ($vendor_ids as $vendor_id) {
                        // Check if the vendor already has an entry in the 'package_inquiry_accepted' table for this inquiry
                        $is_already_accepted = DB::table('package_inquiry_accepted')
                            ->where('packages_inquiry_id', $inquiry_id)
                            ->where('vendor_id', $vendor_id)
                            ->exists();

                        // If the vendor is not already accepted and hasn't been processed
                        if (!$is_already_accepted && !in_array($vendor_id, $processed_vendor_ids)) {
                            $processed_vendor_ids[] = $vendor_id;

                            $html .= "<option value='" . $vendor_id . "'>" . \Helper::vendorsname($vendor_id) . "</option>";
                        }
                    }
                }
            }
        }

        $html .= '</select>';

        $html .= "<input type='hidden' name='inquiry_id' id='inquiry_id' value='" . $inquiry_id . "'/>";
        echo $html;
    }

    public function manual_assign_vendor_form()
    {

        // echo"<pre>";print_r($_POST);echo"</pre>";exit;
        $vendorId = implode(",", $_POST['manual_lead_vendor_id']);

        $arrVendor = explode(",", $vendorId);

        $inquiry_id = $_POST['inquiry_id'];

        $package_inquiry = DB::table('packages_enquiry')->where('id', $inquiry_id)->first();

        $more_formfields_details_data = DB::table('more_formfields_details')
            ->where('package_inquiry_id', $package_inquiry->id)
            ->where('form_field_id', 17)
            ->first();

        $form_attributes_data = DB::table('form_attributes')
            ->where(
                'id',
                $more_formfields_details_data->formfield_value
            )
            ->first();

        $city_data = DB::table('cities')
            ->where('name', $form_attributes_data->form_option)
            ->first();

        if ($package_inquiry->form_type == 'International Move') {
            $typeOfPackage = 1;
        } elseif ($package_inquiry->form_type == 'Local Move') {
            $typeOfPackage = 0;
        } else {
            $typeOfPackage = "";
        }

        $subscription_vendor_data = DB::table('subscription')
            //->where('services',$request->service_id)
            ->whereRaw('FIND_IN_SET(?, services)', [$package_inquiry->service_id])
            ->whereRaw('FIND_IN_SET(?, sub_service)', [$package_inquiry->subservice_id])
            ->whereRaw('FIND_IN_SET(?, city)', [$city_data->id])
            ->where('is_deleted', '=', '0')
            ->where('type_of_subscription', '=', 2)
            ->where('type_of_package', '=', $typeOfPackage)
            ->orderBy('id', 'DESC')
            ->get()->toArray();

        // echo"<pre>";print_r($subscription_vendor_data);echo"</pre>";exit;

        if (!empty($subscription_vendor_data)) {

            foreach ($subscription_vendor_data as $subscription_vendor) {




                $data_package['packages_inquiry_id'] = $package_inquiry->id;
                $data_package['vendor_id'] = $subscription_vendor->vendor_id;
                $data_package['added_date'] = date('Y-m-d');
                $data_package['accept_reject'] = 0;
                $data_package['subscription_type'] = 'A';
                $data_package['subscription_id'] = $subscription_vendor->id;
                $data_package['no_of_inquiry'] = 1;
                $data_package['service_id'] = $package_inquiry->service_id;
                $data_package['subservice_id'] = $package_inquiry->subservice_id;
                $data_package['type_of_leads'] = $package_inquiry->form_type;

                $checkInquiryAccept = DB::table('package_inquiry_accepted')->where('packages_inquiry_id', $package_inquiry->id)->where('vendor_id', $subscription_vendor->vendor_id)->first();


                //    echo"<pre>here";print_r($checkInquiryAccept);echo"</pre>";

                $CountSubscription = DB::table('package_inquiry_accepted')->where('subscription_id', $subscription_vendor->id)->count();

                //    echo"<pre>test";print_r($CountSubscription);echo"</pre>";exit;


                if (empty($checkInquiryAccept) && $subscription_vendor->no_of_inquiry_package > $CountSubscription && in_array($subscription_vendor->vendor_id, $arrVendor)) {
                    //  echo "in";

                    $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_package);

                    $this->vendor_mail($subscription_vendor->vendor_id, $package_inquiry->id);
                }
            }
        }
        // exit;
        return redirect()->route('enquiry.index')->with('success', 'The E-mail to the vendor has been sent successfully.');
    }
    function vendor_mail($vendor_id, $inquiryId)
    {

        // echo"<pre>";print_r($vendor_id);echo"</pre>";
        // echo"<pre>";print_r($inquiryId);echo"</pre>";exit;

        $vendor_data = DB::table('users')->where('id', $vendor_id)->first();

        $package_data = DB::table('packages_enquiry')->where('id', $inquiryId)->first();

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
                    
                <p>Dear ' . $vendor_data->name . ',</pre>  
            
                <p>Congratulations! You have successfully accepted a new lead on VendorsCity. Below, you Will find the customer information necessary to fulfill the request.</p>

                <span><strong>Your Quote:</strong></span>';

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

                    // echo "<pre>";print_r($form_field_data);echo "</pre>";exit;




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
    }

    public function change_status_auto_accept()
    {

        // echo"<pre>";print_r($_POST);echo"</pre>";exit;
        $auto_accept_package  = $_POST['value'];

        if ($auto_accept_package !== null) {
            DB::table('system')
                ->update(['auto_accept_package' => $auto_accept_package]);
        }
        if ($auto_accept_package == 1) {
            echo "1";
        } else {
            echo "2";
        }
    }

    public function enquiry_details($enquiry_id)
    {
        // echo $enquiry_id;exit;
        $data['packages_enquiry'] = DB::table('more_formfields_details')->where('package_inquiry_id', $enquiry_id)->get();
        return view('admin.list_enquiry_acc_rej', $data);
    }
    public function painting_enquiry_details($enquiry_id)
    {
        $data['painting_enquiry_data'] = DB::table('painting_enquiry')->where('id', $enquiry_id)->first();

        return view('admin.list_painting_enquiry_view', $data);
    }

    public function wooden_floor_lead_details($enquiry_id)
    {
        $data['wooden_enquiry_data'] = DB::table('wooden_floor_enquiry')->where('id', $enquiry_id)->first();

        return view('admin.list_wooden_enquiry_view', $data);
    }

    public function garden_enquiry_detail($enquiry_id)
    {
        $data['garden_enquiry_data'] = DB::table('garden_enquiry')->where('inquiry_id', $enquiry_id)->first();

        // echo"<pre>";print_r($data['garden_enquiry_data']);echo"</pre>";exit;
        return view('admin.list_garden_enquiry_view', $data);
    }

    public function download($filepath)
    {
        $Downloads = public_path("upload/enquiry_images/{$filepath}");
        return response()->download($Downloads);
    }
    public function filter_data_enquiry(Request $request)
    {

        $startdate = $request->input('startdate_fil', '');
        $enddate = $request->input('enddate_fil', '');
        $servicename = $request->input('filter_service_id_fil', '');
        $customer_name = $request->input('filter_customer_name_fil', '');

        $query = DB::table('packages_enquiry')->whereIn('service_id', [30, 44]);;

        if ($startdate != '') {
            $query = $query->where('added_date', '>=', date('Y-m-d', strtotime($startdate)));
        }
        if ($enddate != '') {
            $query = $query->where('added_date', '<=', date('Y-m-d', strtotime($enddate)));
        }
        if ($servicename != '') {
            $query = $query->where('service_id', $servicename);
        }
        if ($customer_name != '') {
            $query = $query->where('name', $customer_name);
        }

        $data = $query->orderBy('id', 'DESC')->get()->toArray();

        // echo"<pre>";
        // print_r($data);
        // echo"</pre>";exit;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Date');
        $sheet->setCellValue('B1', 'Inquiry No');
        $sheet->setCellValue('C1', 'Status');
        $sheet->setCellValue('D1', 'Name');
        $sheet->setCellValue('E1', 'Email');
        $sheet->setCellValue('F1', 'Mobile');
        $sheet->setCellValue('G1', 'Service');
        $sheet->setCellValue('H1', 'Sub Service');

        $row = 2;
        // echo"<pre>";print_r($data_new);echo"</pre>";exit;

        if (isset($data)) {
            foreach ($data as $data_new) {

                $service_data = DB::table('services')->where('id', $data_new->service_id)->first();

                $sub_service_data = DB::table('subservices')->where('id', $data_new->subservice_id)->first();

                $customer_data = DB::table('packages_enquiry')->groupBy('name')->where('name', $data_new->name)->first();

                // 

                if ($data_new->added_date !== null) {
                    $sheet->setCellValue('A' . $row, $data_new->added_date);
                } else {
                    $sheet->setCellValue('A' . $row, '-');
                }

                if ($data_new->inquiry_id !== null) {
                    $sheet->setCellValue('B' . $row, $data_new->inquiry_id);
                } else {
                    $sheet->setCellValue('B' . $row, '-');
                }
                if ($data_new->count !== null) {
                    $sheet->setCellValue('C' . $row, $data_new->count . '/5 Accepted');
                } else {
                    $sheet->setCellValue('C' . $row, '-');
                }
                if ($customer_data->name !== null) {
                    $sheet->setCellValue('D' . $row, $customer_data->name);
                } else {
                    $sheet->setCellValue('D' . $row, '-');
                }
                if ($data_new->email !== null) {
                    $sheet->setCellValue('E' . $row, $data_new->email);
                } else {
                    $sheet->setCellValue('E' . $row, '-');
                }
                if ($data_new->mobile !== null) {
                    $sheet->setCellValue('F' . $row, $data_new->mobile);
                } else {
                    $sheet->setCellValue('F' . $row, '-');
                }
                if ($service_data->servicename !== null) {
                    $sheet->setCellValue('G' . $row, $service_data->servicename);
                } else {
                    $sheet->setCellValue('G' . $row, '-');
                }
                if ($sub_service_data->subservicename !== null) {
                    $sheet->setCellValue('H' . $row, $sub_service_data->subservicename);
                } else {
                    $sheet->setCellValue('H' . $row, '-');
                }
                $row++;
            }
        }
        $writer = new Xlsx($spreadsheet);

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Enquiry-list.xlsx"');
        header('Cache-Control: max-age=0');

        // Write the file to the browser
        $writer->save('php://output');
    }


    public function getSubServices($service_id)
    {
        $subservices = DB::table('subservices')
            ->where('serviceid', $service_id)
            ->where('is_active', 0)
            ->orderBy('set_order', 'ASC')
            ->get();

        return response()->json($subservices);
    }


    function movingenquiryadd()
    {
        //echo "test";exit;

        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();
        $data['service_data'] = DB::table('services')->whereIn('id', [30, 44])->orderBy('servicename', 'ASC')->get();

        return view('admin.add_moving_enquiry', $data);
    }

    function getDynamicForms(Request $request)
    {
        $service_id = $request->input('service_id');
        $subservice_id = $request->input('sub_service_id');
        $enquiry_type = $request->input('enquiry_type');

        $html = '';

        // 1️⃣ Get service fields (except when subservice_id = 31)
        if ($subservice_id != '31') {
            $form_field_data_ser = DB::table('services')->where('id', $service_id)->first();
        } else {
            $form_field_data_ser = null;
        }

        // 2️⃣ Get subservice fields
        $form_field_data_sub = DB::table('subservices')->where('id', $subservice_id)->first();

        // 3️⃣ Handle first group of fields (form_fields)
        $form_fields_service = $form_field_data_ser ? explode(',', $form_field_data_ser->form_fields) : [];
        $form_fields_subservice = explode(',', $form_field_data_sub->form_fields);

        $form_fields_merged = array_unique(array_merge($form_fields_service, $form_fields_subservice));
        $tags = explode(',', implode(',', $form_fields_merged));

        $result1 = DB::table('form_fileds')
            ->whereIn('id', $tags)
            ->orderBy('set_order')
            ->get();

        // 4️⃣ Handle second group of fields (form_fields_two)
        $form_fields_service_two = $form_field_data_ser ? explode(',', $form_field_data_ser->form_fields_two ?? '') : [];
        $form_fields_subservice_two = explode(',', $form_field_data_sub->form_fields_two);

        $form_fields_merged_two = array_unique(array_merge($form_fields_service_two, $form_fields_subservice_two));
        $tags2 = explode(',', implode(',', $form_fields_merged_two));

        $result2 = DB::table('form_fileds')
            ->whereIn('id', $tags2)
            ->orderBy('set_order')
            ->get();

        // Choose set based on enquiry_type
        if ($enquiry_type == 'Local') {
            $FinalFormField = $result1;
        } elseif ($enquiry_type == 'International') {
            $FinalFormField = $result2;
        } else {
            $FinalFormField = $result1;
        }

        if ($FinalFormField) {
            foreach ($FinalFormField as $field) {
                $options = DB::table('form_attributes')
                    ->where('form_id', $field->id)
                    ->get();

                $colSize = $field->col_size ?? 3;

                $html .= '';

                $html .= '<div class="col-md-' . $colSize . '">';
                $html .= '<div class="form-group mb15">';

                $html .= '<label class="form-label fw500 dark-color">' . e($field->lable_name) . '</label>';

                switch ($field->type) {
                    case 1: // text
                        $html .= '<input type="hidden" name="formfield_id[]" value="' . e($field->id) . '"><input type="text" name="formfield_value[]" class="form-control dynamic-field" placeholder="' . e($field->lable_name) . '" required>';
                        break;

                    case 2: // dropdown
                        $html .= '<input type="hidden" name="formfield_id[]" value="' . e($field->id) . '"><select name="formfield_value[]" class="form-control form-select dynamic-field" required onchange="get_sub_select(this.value, ' . $field->id . ')" >';
                        $html .= '<option value="">Select ' . e($field->lable_name) . '</option>';
                        foreach ($options as $opt) {
                            $html .= '<option value="' . e($opt->id) . '">' . e($opt->form_option) . '</option>';
                        }
                        $html .= '</select><span id="replace_select_' . e($field->id) . '"></span>';
                        break;

                    case 3: // radio
                        $html .= '<input type="hidden" name="form_field_radio_id_one[]" value="' . e($field->id) . '">';
                        foreach ($options as $key => $opt) {
                            $required = $key == 0 ? 'required' : ''; // required only on first radio input
                            $html .= '<div class="form-check">';
                            $html .= '<input class="form-check-input dynamic-field" type="radio" name="formfield_radio_' . $field->id . '" value="' . e($opt->form_option) . '" ' . $required . '>';
                            $html .= '<label class="form-check-label">' . e($opt->form_option) . '</label>';
                            $html .= '</div>';
                        }
                        break;

                    case 4: // checkbox
                        $html .= '<input type="hidden" name="form_field_checkbox_id_one[]" value="' . e($field->id) . '">';
                        foreach ($options as $key => $opt) {
                            $required = $key == 0 ? 'required' : ''; // required only once
                            $html .= '<div class="form-check">';
                            $html .= '<input class="form-check-input dynamic-field" type="checkbox" name="formfield_checkbox_' . $field->id . '[]" value="' . e($opt->form_option) . '" ' . $required . '>';
                            $html .= '<label class="form-check-label">' . e($opt->form_option) . '</label>';
                            $html .= '</div>';
                        }
                        break;

                    case 5: // textarea
                        $html .= '<input type="hidden" name="formfield_id[]" value="' . e($field->id) . '">';
                        $html .= '<textarea name="formfield_value[]" class="form-control dynamic-field" placeholder="' . e($field->lable_name) . '" required></textarea>';
                        break;

                    case 6: // date
                        $html .= '<input type="hidden" name="formfield_id[]" value="' . e($field->id) . '">';
                        $html .= '<input type="date" name="formfield_value[]" class="form-control dynamic-field" required>';
                        break;

                    case 7: // multi select
                        $html .= '<input type="hidden" name="form_field_mul_dropdown_id[]" value="' . e($field->id) . '">';
                        $html .= '<select multiple name="formfield_mul_dropdown_' . $field->id . '[]" class="form-control form-select multiple dynamic-field" required>';
                        foreach ($options as $opt) {
                            $html .= '<option value="' . e($opt->form_option) . '">' . e($opt->form_option) . '</option>';
                        }
                        $html .= '</select>';
                        break;

                    case 8: // file upload
                        $html .= '<input type="hidden" name="form_field_id_image[]" value="' . e($field->id) . '">';
                        $html .= '<input type="file" name="formfield_Image_value' . $field->id . '[]" class="form-control dynamic-field" multiple required>';
                        break;

                    case 9: // time
                        $html .= '<input type="hidden" name="formfield_id[]" value="' . e($field->id) . '">';
                        $html .= '<input type="time" name="formfield_value[]" class="form-control dynamic-field" required>';
                        break;

                    case 10: // number
                        $html .= '<input type="hidden" name="formfield_id[]" value="' . e($field->id) . '">';
                        $html .= '<input type="number" name="formfield_value[]" class="form-control dynamic-field" placeholder="' . e($field->lable_name) . '" required>';
                        break;

                    case 11: // email
                        $html .= '<input type="hidden" name="formfield_id[]" value="' . e($field->id) . '">';
                        $html .= '<input type="email" name="formfield_value[]" class="form-control dynamic-field" placeholder="' . e($field->lable_name) . '" required>';
                        break;

                    case 12: // password
                        $html .= '<input type="hidden" name="formfield_id[]" value="' . e($field->id) . '">';
                        $html .= '<input type="password" name="formfield_value[]" class="form-control dynamic-field" placeholder="' . e($field->lable_name) . '" required>';
                        break;
                }

                $html .= '</div>'; // close form-group
                $html .= '</div>'; // close col
            }
        }

        echo $html;
    }

    function movingstorageenquirystore(Request $request)
    {
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $userdata = DB::table('frontloginregisters')->where('id', $request->customer_id)->first();

        if ($request->service_id != '') {
            $data['service_id'] = $request->service_id;
        }
        if ($request->sub_service_id != '') {
            $data['subservice_id'] = $request->sub_service_id;
        }
        if ($request->packagecategory_id != '') {
            $data['packagecategory_id'] = $request->packagecategory_id;
        }


        if ($request->enquiry_type == 'Local') {
            $enquiry_type = 'Local Move';
        } elseif ($request->enquiry_type == 'International') {
            $enquiry_type = 'International Move';
        } else {
            $enquiry_type = 'Local Move';
        }

        $data['added_date'] = date('Y-m-d');
        $data['form_type'] = $enquiry_type;

        $data['name'] = $userdata->name;
        $data['email'] = $userdata->email;
        $data['mobile'] = $userdata->mobile;

        $package_inquiry = DB::table('packages_enquiry',)->insertGetId($data);

        $package_data_n = DB::table('packages_enquiry',)->where('id', $package_inquiry)->first();


        $service_name = \Helper::servicename($package_data_n->service_id);
        // $processed_text = strtoupper(str_replace(' ', '', $service_name));
        // $year =date('y');
        // $data_u['inquiry_id'] = "IQ-".$processed_text."-" . $year ."-". sprintf("%06d", $package_inquiry);
        if ($request->sub_service_id == 23 || $request->sub_service_id == 26 || $request->sub_service_id == 53) { //apartment moving,villa moving,office moving

            if ($request->enquiry_type == 'Local') {

                $formFieldIds   = $request->formfield_id;
                $formFieldVals  = $request->formfield_value;

                $cityOptionId = null;

                foreach ($formFieldIds as $index => $fieldId) {
                    if ($fieldId == 17) {   // 17 = City field ID
                        $cityOptionId = $formFieldVals[$index];
                        break;
                    }
                }

                $cityOption = DB::table('form_attributes')
                    ->where('id', $cityOptionId)
                    ->first();

                $CityName = $cityOption->form_option ?? '';

                //$cityId = $request->formfield_value[0] ?? 0;

                $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($CityName) . '%'])->first();
                $subserviceData = DB::table('subservices')->where('id', $request->sub_service_id)->first();

                if (isset($subserviceData)) {
                    if (isset($subserviceData->subservice_code)) {
                        $subserviceCode = $subserviceData->subservice_code;
                    } else {
                        $subserviceCode = 'OT';
                    }
                } else {
                    $subserviceCode = 'OT';
                }

                $cityCode = 'DU';
                if (isset($cityData)) {
                    if (isset($cityData->city_code)) {
                        $cityCode = $cityData->city_code;
                    } else {
                        $cityCode = 'OT';
                    }
                }

                $year = date('y');

                $lastSequence = DB::table('packages_enquiry')
                    ->where('subservice_code', $subserviceCode)
                    ->where('city_code', $cityCode)
                    ->where('order_year', $year)
                    ->lockForUpdate()
                    ->max('sequence_no');

                $nextSequence = $lastSequence ? $lastSequence + 1 : 1;

                $formatOrderId = sprintf(
                    "%s-%s-%s-%06d",
                    $subserviceCode,
                    $year,
                    $cityCode,
                    $nextSequence
                );

                $data_u['subservice_code'] = $subserviceCode;
                $data_u['city_code'] = $cityCode;
                $data_u['order_year'] = $year;
                $data_u['sequence_no'] = $nextSequence;
                $data_u['inquiry_id'] = $formatOrderId;
            } else {

                $formFieldIds   = $request->formfield_id;
                $formFieldVals  = $request->formfield_value;

                $countryOptionId = null;

                foreach ($formFieldIds as $index => $fieldId) {
                    if ($fieldId == 57) {   // 57 = Country field ID internatonal
                        $countryOptionId = $formFieldVals[$index];
                        break;
                    }
                }
                //echo $countryOptionId;exit;

                $countryOption = DB::table('form_attributes')
                    ->where('id', $countryOptionId)
                    ->first();

                //echo"<pre>";print_r($countryOption);exit;

                $CountryName = $countryOption->form_option ?? 'OT';
                $countryCode = mb_strtoupper(mb_substr($CountryName, 0, 3, 'UTF-8'));

                $subserviceData = DB::table('subservices')->where('id', $request->sub_service_id)->first();

                if (isset($subserviceData)) {
                    if (isset($subserviceData->subservice_code)) {
                        $subserviceCode = "I" . $subserviceData->subservice_code;
                    } else {
                        $subserviceCode = 'OT';
                    }
                } else {
                    $subserviceCode = 'OT';
                }

                $year = date('y');

                $lastSequence = DB::table('packages_enquiry')
                    ->where('subservice_code', $subserviceCode)
                    ->where('city_code', $countryCode)
                    ->where('order_year', $year)
                    ->lockForUpdate()
                    ->max('sequence_no');

                $nextSequence = $lastSequence ? $lastSequence + 1 : 1;

                $formatOrderId = sprintf(
                    "%s-%s-%s-%06d",
                    $subserviceCode,
                    $year,
                    $countryCode,
                    $nextSequence
                );

                $data_u['subservice_code'] = $subserviceCode;
                $data_u['city_code'] = $countryCode;
                $data_u['order_year'] = $year;
                $data_u['sequence_no'] = $nextSequence;
                $data_u['inquiry_id'] = $formatOrderId;
            }
        }

        if ($request->sub_service_id == 31) { // vehicle shipping

            $formFieldIds   = $request->formfield_id;
            $formFieldVals  = $request->formfield_value;

            $countryOptionId = null;

            foreach ($formFieldIds as $index => $fieldId) {
                if ($fieldId == 39) {   // 39 = Country field ID internatonal
                    $countryOptionId = $formFieldVals[$index];
                    break;
                }
            }
            //echo $countryOptionId;exit;

            $countryOption = DB::table('form_attributes')
                ->where('id', $countryOptionId)
                ->first();

            //echo"<pre>";print_r($countryOption);exit;

            $CountryName = $countryOption->form_option;

            $countriesData = DB::table('countries')->whereRaw('country LIKE ?', ['%' . strtolower($CountryName) . '%'])->first();

            if (isset($countriesData)) {
                $countryCode = $countriesData->country_code ?? '';
            } else {
                $countryCode = mb_strtoupper(mb_substr($CountryName, 0, 3, 'UTF-8'));
            }

            $subserviceData = DB::table('subservices')->where('id', $request->sub_service_id)->first();

            if (isset($subserviceData)) {
                if (isset($subserviceData->subservice_code)) {
                    $subserviceCode = $subserviceData->subservice_code;
                } else {
                    $subserviceCode = 'OT';
                }
            } else {
                $subserviceCode = 'OT';
            }

            $year = date('y');

            $lastSequence = DB::table('packages_enquiry')
                ->where('subservice_code', $subserviceCode)
                ->where('city_code', $countryCode)
                ->where('order_year', $year)
                ->lockForUpdate()
                ->max('sequence_no');

            $nextSequence = $lastSequence ? $lastSequence + 1 : 1;

            $formatOrderId = sprintf(
                "%s-%s-%s-%06d",
                $subserviceCode,
                $year,
                $countryCode,
                $nextSequence
            );

            $data_u['subservice_code'] = $subserviceCode;
            $data_u['city_code'] = $countryCode;
            $data_u['order_year'] = $year;
            $data_u['sequence_no'] = $nextSequence;
            $data_u['inquiry_id'] = $formatOrderId;
        }

        if ($request->sub_service_id == 61 || $request->sub_service_id == 62 || $request->sub_service_id == 64 || $request->sub_service_id == 66) { // self storage,ac storage,non ac storage,vehicle storage

            $formFieldIds   = $request->formfield_id;
            $formFieldVals  = $request->formfield_value;

            $cityOptionId = null;

            foreach ($formFieldIds as $index => $fieldId) {
                if ($fieldId == 69) {   // 39 = city field 
                    $cityOptionId = $formFieldVals[$index];
                    break;
                }
            }

            $cityOption = DB::table('form_attributes')
                ->where('id', $cityOptionId)
                ->first();

            $CityName = $cityOption->form_option ?? '';

            //$cityId = $request->formfield_value[0] ?? 0;

            $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($CityName) . '%'])->first();
            $subserviceData = DB::table('subservices')->where('id', $request->sub_service_id)->first();

            if (isset($subserviceData)) {
                if (isset($subserviceData->subservice_code)) {
                    $subserviceCode = $subserviceData->subservice_code;
                } else {
                    $subserviceCode = 'OT';
                }
            } else {
                $subserviceCode = 'OT';
            }

            $cityCode = 'DU';
            if (isset($cityData)) {
                if (isset($cityData->city_code)) {
                    $cityCode = $cityData->city_code;
                } else {
                    $cityCode = 'OT';
                }
            }

            $year = date('y');

            $lastSequence = DB::table('packages_enquiry')
                ->where('subservice_code', $subserviceCode)
                ->where('city_code', $cityCode)
                ->where('order_year', $year)
                ->lockForUpdate()
                ->max('sequence_no');

            $nextSequence = $lastSequence ? $lastSequence + 1 : 1;

            $formatOrderId = sprintf(
                "%s-%s-%s-%06d",
                $subserviceCode,
                $year,
                $cityCode,
                $nextSequence
            );

            $data_u['subservice_code'] = $subserviceCode;
            $data_u['city_code'] = $cityCode;
            $data_u['order_year'] = $year;
            $data_u['sequence_no'] = $nextSequence;
            $data_u['inquiry_id'] = $formatOrderId;
        }



        DB::table('packages_enquiry')->where('id', $package_inquiry)->update($data_u);

        if ($request->formfield_id != '' && count($request->formfield_id) > 0) {

            foreach ($request->formfield_id as $key => $value) {

                if (!empty($value) && isset($request->formfield_value[$key])) {
                    $data1['package_inquiry_id'] = $package_inquiry;
                    $data1['form_field_id'] = $value;
                    $data1['formfield_value'] = $request->formfield_value[$key];

                    DB::table('more_formfields_details')->insert($data1);

                    if ($request->has("formfield_value_more" . $value) && is_array($request->input("formfield_value_more" . $value))) {
                        foreach ($request->input("formfield_value_more" . $value) as $option) {
                            if ($option != '') {

                                $data_attr['form_id'] = $value;
                                $data_attr['more_form_attributes_id'] = $option;
                                $data_attr['package_inquiry_id'] = $package_inquiry;
                                DB::table('more_formfields_details_att')->insert($data_attr);
                            }
                        }
                    }
                }
            }
        }

        if ($request->form_field_radio_id_one != '' && count($request->form_field_radio_id_one) > 0) {

            foreach ($request->form_field_radio_id_one as $key1 => $values1) {

                $radioVal = $request->form_field_radio_id_one[$key1];

                if ($request->form_field_radio_id_one[$key1] != '') {

                    $data2['package_inquiry_id'] = $package_inquiry;

                    $data2['form_field_id'] = $request->form_field_radio_id_one[$key1];
                    $data2['formfield_value'] = $request['formfield_radio_' . $radioVal];


                    DB::table('more_formfields_details')->insert($data2);
                }
            }
        }


        if ($request->form_field_checkbox_id_one != '' && count($request->form_field_checkbox_id_one) > 0) {

            foreach ($request->form_field_checkbox_id_one as $key1 => $values1) {

                $ckeckboxVal = $request->form_field_checkbox_id_one[$key1];

                if ($request->form_field_checkbox_id_one[$key1] != '') {

                    $data3['package_inquiry_id'] = $package_inquiry;

                    $data3['form_field_id'] = $request->form_field_checkbox_id_one[$key1];
                    $data3['formfield_value'] = $request['formfield_checkbox_' . $ckeckboxVal];



                    // $data3['formfield_value'] = $request['formfield_checkbox_'.$key1];
                    if ($data3['formfield_value'] != '') {

                        $data3['formfield_value'] = implode(",", $data3['formfield_value']);
                    } else {
                        $data3['formfield_value'] = null;
                    }



                    // echo "<pre>";print_r($data123);echo "</pre>";exit;

                    DB::table('more_formfields_details')->insert($data3);
                }
            }
        }

        if ($request->form_field_mul_dropdown_id != '' && count($request->form_field_mul_dropdown_id) > 0) {

            foreach ($request->form_field_mul_dropdown_id as $key1 => $values1) {

                $Multiple_drop_down_Val = $request->form_field_mul_dropdown_id[$key1];

                if ($request->form_field_mul_dropdown_id[$key1] != '') {

                    $data4['package_inquiry_id'] = $package_inquiry;

                    $data4['form_field_id'] = $request->form_field_mul_dropdown_id[$key1];
                    $data4['formfield_value'] = $request['formfield_mul_dropdown_' . $Multiple_drop_down_Val];



                    // $data3['formfield_value'] = $request['formfield_checkbox_'.$key1];
                    if ($data4['formfield_value'] != '') {

                        $data4['formfield_value'] = implode(",", $data4['formfield_value']);
                    } else {
                        $data4['formfield_value'] = null;
                    }
                    // echo "<pre>";print_r($data123);echo "</pre>";exit;

                    DB::table('more_formfields_details')->insert($data4);
                }
            }
        }


        if (isset($request->form_field_id_image[0]) && $request->form_field_id_image[0] != '') {
            $formImage_id = $request->form_field_id_image[0];
            $formImageValue = $request->file('formfield_Image_value' . $formImage_id);
            //echo "<pre>";print_r($files);echo "</pre>";exit;
            if ($formImageValue != '') {

                foreach ($formImageValue as $key1 => $values1) {
                    $imageVal = $formImageValue[$key1];


                    if ($formImageValue[$key1] != '') {
                        $data1['package_inquiry_id'] = $package_inquiry;

                        $data1['form_field_id'] = $formImage_id;

                        $images = $formImageValue[$key1];

                        $imageName = time() . '-' . $images->getClientOriginalName();
                        //echo "<pre>";print_r($imageName);echo "</pre>";exit;
                        $destinationPath = public_path('upload/enquiry_images');
                        $images->move($destinationPath, $imageName);

                        $data1['formfield_value'] = $imageName;

                        //echo "<pre>";print_r($data1);echo "</pre>";exit;
                        DB::table('more_formfields_details')->insert($data1);
                    }
                }
            }
        }

        $this->send_moving_enquiry_email_to_vendor($package_inquiry, $userdata);

        return redirect()->route('enquiry.index')->with('success', 'Enquiry Added Successfully');

        //echo"<pre>";print_r($userdata);echo"</pre>";exit;
    }

    function send_moving_enquiry_email_to_vendor($enquiry_id, $userdata)
    {

        $packageEnquiryFormId = $enquiry_id;

        $package_inquiry_data = DB::table('more_formfields_details')
            ->where('package_inquiry_id', $packageEnquiryFormId)
            ->where('form_field_id', 17)
            ->first();

        if (!empty($package_inquiry_data)) {

            $form_attributes_data = DB::table('form_attributes')
                ->where('id', $package_inquiry_data->formfield_value)
                ->first();


            $city_data = DB::table('cities')
                ->where('name', $form_attributes_data->form_option)
                ->first();
        }

        $package_inquiry_data_new = DB::table('packages_enquiry')
            ->where('id', $packageEnquiryFormId)
            ->first();

        if ($package_inquiry_data_new->form_type == 'Local Move') {
            $type = 0;
        } else {
            $type = 1;
        }

        $currentDate = now();

        if ($package_inquiry_data_new->subservice_id != 0) {

            $subscription_vendor_data = $query = DB::table('subscription')
                ->where('type_of_package', $type)
                ->where('is_deleted', '=', '0')
                ->whereRaw('FIND_IN_SET(?, services)', [$package_inquiry_data_new->service_id])
                ->whereRaw('FIND_IN_SET(?, sub_service)', [$package_inquiry_data_new->subservice_id]);
            if (!empty($package_inquiry_data)) {
                $subscription_vendor_data = $subscription_vendor_data->whereRaw('FIND_IN_SET(?, city)', [$city_data->id]);
            }

            $subscription_vendor_data = $subscription_vendor_data->get();
        } else {
            $subscription_vendor_data = DB::table('subscription')->where('services', $package_inquiry_data_new->service_id)
                ->where('is_deleted', '=', '0')
                ->where('enddate', '>=', $currentDate)
                ->get();
        }

        $vendor_id_array = array();
        if ($subscription_vendor_data != '' && !empty($subscription_vendor_data)) {

            foreach ($subscription_vendor_data as $subscription_vendor_val) {
                $vendor_id_array[] = $subscription_vendor_val->vendor_id;
            }
        }
        $vendor_id_array_dataunique = array_unique($vendor_id_array);
        /* vendor mail send start */
        foreach ($vendor_id_array_dataunique as $vendor_id_array_data) {

            $vendor_data = DB::table('users')->where('id', $vendor_id_array_data)->where('is_active', 0)->first();

            if (!empty($vendor_data)) {

                $vendor_att_email = array();
                $vendor_data_attr = DB::table('vendors_attribute')->where('pid', $vendor_data->id)->get()->toArray();

                foreach ($vendor_data_attr as $attr_data) {
                    if (!empty($attr_data->c_email)) {
                        $vendor_att_email[] = $attr_data->c_email;
                    }
                }

                if (!empty($vendor_att_email)) {
                    $cc = implode(',', $vendor_att_email);
                } else {
                    $cc = '';
                }

                $vendors_id = Crypt::encrypt($vendor_data->id);

                $form_fields_data = DB::table('more_formfields_details')->where('package_inquiry_id', $packageEnquiryFormId)->get()->toArray();

                if ($vendor_data && $vendor_data->is_active == 0) {

                    $field_array = array();

                    foreach ($form_fields_data as $key => $values) {
                        $form_fields = DB::table('form_fileds')
                            ->select('*')
                            ->where('id', $values->form_field_id)
                            ->first();

                        $packageEnquiryFormId = $enquiry_id;

                        if ($values->formfield_value != '') {
                            //echo "inner<br>";
                            // If the key doesn't exist, add the entry to the array
                            $field_array[$key] = array('name' => $form_fields->lable_name, 'value' => $values->formfield_value, 'id' => $form_fields->id, 'mail_send' => $form_fields->mail_send);
                        }
                    }

                    $user_name = $userdata->name;
                    $Date = date('d-m-Y');

                    $html = '<!doctype html> <html>
                                <head>
                                    <meta charset="utf-8">
                                    <title>New </title>
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
                                        <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;">
                                        </div>
                                        <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                                            
                                        <p>Dear ' . ucfirst($vendor_data->name) . ',</p>                 
                                        <p>We are excited to inform you that a new customer has requested a quote for ' . \Helper::servicename($package_inquiry_data_new->service_id) . ' on VendorsCity!</p>
                                        <p><strong>Request Details:</strong></p>
                                        <ul><li style= "list-style-type: disc;margin-bottom: -15px;"> Service Requested : ' . \Helper::servicename($package_inquiry_data_new->service_id) . '</li>                       
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
                                                        <img style="width:70%;" src="' . asset("public/site/images/vcfaviconwap.png") . '"" >
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

                    /* notification sectio start */
                    $data_notification['vendor_id'] = $vendor_data->id;
                    $data_notification['subject'] = 'New Lead Generated for ' . \Helper::servicename($package_inquiry_data_new->service_id) . '';
                    $data_notification['added_datetime'] = date('Y-m-d h:i:s');

                    DB::table('notification')->insert($data_notification);

                    $user_email = $userdata->email;
                    $user_name = $userdata->name;

                    $subject = " New Quote Request for  " . \Helper::servicename($package_inquiry_data_new->service_id) . " on VendorsCity! Customer Name : " . $user_name . "";

                    $to = $vendor_data->email;

                    $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
                    if (!empty($cc)) {
                        $ccRecipients = explode(',', $cc);
                    }

                    Mail::send([], [], function ($message) use ($html, $to,  $subject, $ccRecipients) {
                        $message->to($to, 'VendorsCity');
                        $message->subject($subject);
                        foreach ($ccRecipients as $ccRecipient) {
                            $message->bcc($ccRecipient);
                        }
                        $message->html($html);
                    });
                }
            }
        }

        /* vendor mail send end */


        /* customer mail start */

        $user_email = $userdata->email;
        $user_name = $userdata->name;


        $message_bodyy = '';

        $message_bodyy .= '<!doctype html>

    
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
                        font-size:14px;line-height:24px;font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
            <div class="logo"style="float: inherit;border-bottom: 4px solid #FFD413;">
            <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;"  >
            </div>
            <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;" >
                <p>Dear ' . $user_name . ',</p>
                <p>Thank you for reaching out to VendorsCity! We have received your request for up to 5 free quotes for ' . \Helper::servicename($package_inquiry_data_new->service_id) . '.
                </p>
                <p><strong>What Happens Next?</strong></p>

                <p>Our trusted vendors will review your request and will contact you within 2 business days.
                You will receive up to 5 quotes tailored to your specific  ' . \Helper::servicename($package_inquiry_data_new->service_id) . ' needs.
                </p>
                <p><strong>How to Choose the Best Vendor:</strong></p>
                <ul><li style= "list-style-type: disc;margin-bottom: -15px;">Review the quotes you receive.</li>
                <li style= "list-style-type: disc;margin-bottom: -15px;">Check out the vendor ratings and reviews to make an informed decision.</li>
                <li style= "list-style-type: disc";>Select the vendor that best suits your requirements.</li></ul>  
                <p>We are committed to helping you find the best services quickly and easily. If you have any questions or need further assistance, please don&#39;t hesitate to contact us at support@vendorscity.com.
                </p> 
                
                <p>Thank you for choosing VendorsCity!</p>
            
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
                                        <p  style="margin:0;">VendorsCity Portal LLC</p>
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

        $subject = " Your Request for Free Quotes on " . \Helper::servicename($package_inquiry_data_new->service_id) . " is Being Processed!";
        $to = $user_email;

        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];

        Mail::send([], [], function ($message) use ($message_bodyy, $to, $subject, $ccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($message_bodyy);
        });


        /* customer mail end */
    }
}
