<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;

class CronController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
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
    public function auto_accept_package(){
        // echo"here";exit;
        $system = DB::table('system')->first();

       
        if($system->auto_accept_package == 1){

            $today = date('Y-m-d');
            $todyInquiry = DB::table('packages_enquiry')->where('added_date',$today)->where('cron_check',0)->get()->toArray();

            // echo"<pre>";print_r($todyInquiry);echo"</pre>";exit;

            if(!empty($todyInquiry)){

                foreach($todyInquiry as $Inquirydata){

                    $more_formfields_details_data = DB::table('more_formfields_details')
                                ->where('package_inquiry_id', $Inquirydata->id)
                                ->where('form_field_id', 17)
                                ->first();

                    $form_attributes_data = DB::table('form_attributes')
                                ->where('id',
                                $more_formfields_details_data->formfield_value)
                                ->first();

                    $city_data = DB::table('cities')
                                ->where('name', $form_attributes_data->form_option)
                                ->first();

                    if($Inquirydata->form_type == 'International Move'){
                        $typeOfPackage = 1;
                        
                    }elseif($Inquirydata->form_type == 'Local Move'){
                        $typeOfPackage = 0;
                    }else{
                        $typeOfPackage = "";
                    }

                    $subscription_vendor_data= DB::table('subscription')
                                //->where('services',$request->service_id)
                                ->whereRaw('FIND_IN_SET(?, services)', [$Inquirydata->service_id])
                                ->whereRaw('FIND_IN_SET(?, sub_service)', [$Inquirydata->subservice_id])
                                ->whereRaw('FIND_IN_SET(?, city)', [$city_data->id])
                                ->where('is_deleted' , '=' ,'0')
                                ->where('type_of_subscription', '=', 2)
                                ->where('type_of_package', '=', $typeOfPackage)
                                ->orderBy('id','DESC')
                                ->get()->toArray();
                                
                    // echo"<pre>";print_r($subscription_vendor_data);echo"</pre>";exit;

                    if(!empty($subscription_vendor_data)){

                        foreach($subscription_vendor_data as $subscription_vendor){

                            $this->vendor_mail($subscription_vendor->vendor_id,$Inquirydata->id);


                            $data_package['packages_inquiry_id'] = $Inquirydata->id;
                            $data_package['vendor_id'] = $subscription_vendor->vendor_id;
                            $data_package['added_date'] = date('Y-m-d');
                            $data_package['accept_reject'] = 0;
                            $data_package['subscription_type'] = 'A';
                            $data_package['subscription_id'] = $subscription_vendor->id;
                            $data_package['no_of_inquiry'] = 1;
                            $data_package['service_id'] = $Inquirydata->service_id;
                            $data_package['subservice_id'] = $Inquirydata->subservice_id;
                            $data_package['type_of_leads'] = $Inquirydata->form_type;

                           $checkInquiryAccept = DB::table('package_inquiry_accepted')->where('packages_inquiry_id',$Inquirydata->id)->where('vendor_id',$subscription_vendor->vendor_id)->first();



                           $CountSubscription = DB::table('package_inquiry_accepted')->where('subscription_id',$subscription_vendor->id)->count();

                        
                           if(empty($checkInquiryAccept) && $subscription_vendor->no_of_inquiry_package > $CountSubscription){
                            // echo "in";exit;

                            $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_package);
                            
                            DB::table('packages_enquiry')->where('id', $Inquirydata->id)->update(['cron_check' => 1]);

                           }
                        //    else{
                        //     echo "out";
                        //    }

                            //return $checkInquiryAccept;

                            //echo"<pre>";print_r($subscription_vendor);echo"</pre>";
                            //echo"<pre>";print_r($CountSubscription);echo"</pre>";

                            // $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_package);
                            // DB::table('packages_enquiry')->where('id', $inquiry->id)->update(['cron_check' => 1]);
                            

                        }

                
                        
                    }                                
                    // echo"<pre>";print_r($Inquirydata);echo"</pre>";
                    // echo"<pre>";print_r($city_data);echo"</pre>";
                    
                }
            }

            // exit;
        }
        

    }

    function vendor_mail($vendor_id,$inquiryId)  {

        // echo"<pre>";print_r($vendor_id);echo"</pre>";
        // echo"<pre>";print_r($inquiryId);echo"</pre>";exit;

        $vendor_data = DB::table('users')->where('id', $vendor_id)->first();

        $package_data = DB::table('packages_enquiry')->where('id',$inquiryId)->first();
        
        $form_fields_data= DB::table('more_formfields_details')->where('package_inquiry_id',$inquiryId)->get()->toArray();

        $field_array = array();
        foreach ($form_fields_data as $key => $values) {

            $form_fields = DB::table('form_fileds')
                ->select('*')
                ->where('id', $values->form_field_id)
                ->first();

                if ($values->formfield_value != '') {
                    // If the key doesn't exist, add the entry to the array
                    $field_array[$key] = array('name' => $form_fields->lable_name, 'value' => $values->formfield_value,'id' => $form_fields->id,'mail_send' => $form_fields->mail_send);
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
                <img src="'.asset("public/site/images/VC-FULL-COLOR.png").'"" style="width: 40%;" >
                </div>
                <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                    
                <p>Dear '.$vendor_data->name.',</pre>  
            
                <p>Congratulations! You have successfully accepted a new lead on VendorsCity. Below, you Will find the customer information necessary to fulfill the request.</p>

                <span><strong>Your Quote:</strong></span>';

                    $html.='<table style="width: 100%;">
                        <tr>
                            <th style="text-align: left;border: 1px solid #000;   background-color: #0040e6;color: #fff;padding: 10px 60px 10px 12px;">Quote</th>
                            <th style="text-align: left;border: 1px solid #000;   background-color: #0040e6;color: #fff;padding: 10px 60px 10px 12px;">Additional Information</th> 
                        </tr>
                        <tr>
                            <td style="text-align: left;border: 1px solid #000;padding: 10px 60px 10px 12px;">Based On Final Survey</td>
                            <td style="text-align: left;border: 1px solid #000;padding: 10px 60px 10px 12px;">This lead is chargeable. There was no quote provided to the client. Please quote the client directly via email and copy <a style="color: #555;tetext-decoration: inherit;" href="mailto:support@vendorscity.com">support@vendorscity.com</a> for our record.</td>
                        </tr>
                </table>';

             
                $html.='<br>
                <span><strong>Customer Details:</strong></span>
                <table id="table_new" style="width: 100%;border: 1px solid black;
                    border-collapse: collapse;">
                    
                    <tr>
                        <td class="custome_td" style="background-color: #0040E6;
                        color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;border-collapse: collapse;">Name:</td>
                        <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;border-collapse: collapse;"> '.$package_data->name.'</td>
                    </tr>
                    <tr>
                        <td class="custome_td" style="background-color: #0040E6;
                        color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;border-collapse: collapse;">Email:</td>
                        <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;border-collapse: collapse;"> '.$package_data->email.'</td>
                    </tr>
                    <tr>
                        <td class="custome_td" style="background-color: #0040E6;
                        color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;
                    border-collapse: collapse;">Mobile No:</td>
                        <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;
                    border-collapse: collapse;"> '.$package_data->mobile.'</td>
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
                                            if($form_field_data['id'] != $i){
                                                $html .= '<td class="custome_td" style="background-color: #0040E6;
                                                color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;
                    border-collapse: collapse;">'. $form_field_data['name'] .'</td>  ';
                                            }                                                             

                                        if(is_numeric($form_field_data['value']) && $form_field_data['id'] != 30 && $form_field_data['id'] != 60){
                                                $html.='<td   class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;
                    border-collapse: collapse;">'. \Helper::form_fields_attr($form_field_data['value']) .'</td>';
                                        }else{
                                        
                                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif','jfif'];
                                            $extension = pathinfo($form_field_data['value'],PATHINFO_EXTENSION);
                                        
                                            if (in_array(strtolower($extension), $imageExtensions)) { 
                                                // if($form_field_data['id'] == $i){                                                                                                                                              
                                                $html .= '<td colspan="2" class="text-center"><a href="' . url('download/' . $form_field_data['value']) . '">Download</a></td>';
                                            // }
                                            }else{
                                                $html.='<td  class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;
                                                border-collapse: collapse;" >'.$form_field_data['value'] .'</td>';
                                            }                                                                                         
                                        }
                                        $html.=' </tr>';
                            }
                    // echo "<pre>";print_r($get_more_id);echo "</pre>";
                            
                            if(isset($get_more_id) && count($get_more_id) > 0){
                                foreach ($get_more_id as $get_more_id_data) {    
                                    $html .= '<tr>';
                                    if($form_field_data['value'] == 111 && $form_field_data['id'] == 35){
                                        $html .= '<td class="custome_td" style="background-color: #0040E6;
                                                color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;"> What days of the week would you like the service</td>'; 
                                    }else{
                                        $html .= '<td  class="custome_td" style="background-color: #0040E6;
                                                color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;"> Type of Home</td>';
                                    }
                                    $html .= '                                          
                                    <td class="custome_td_new" style=" padding: 10px 12px;">'. \Helper::form_fields_attr_more($get_more_id_data->more_form_attributes_id) .'</td>                                               
                                </tr>';
                                }
                            }
                            

                        }

                        $i = $form_field_data['id'];

                        }
                    }
                
                
                    $html.='</table>

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
                                <img style="width:70%;" src="'.asset("public/site/images/vcfaviconwap.png").'"" >
                            </div>
                            <div class="footer_right" style="margin-left:10px;
                            float: left;">
                                <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a></p>
                                <p style="margin:0;">VendorsCity Portal LLC</p>
                                <div class="footer_links" style=" margin:10px 0;">
                            <a href="'.url("/terms-of-service").'"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                            <a href="'.url("/privacy-policy").'"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                            <a href="'.url("/contact").'"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                            </div>
                                
                            </div>
                        </div>
                </div>
            </div>
        </body>
    </html>';
    
        $vendor_att_email=array();
        $vendor_data_attr= DB::table('vendors_attribute')->where('pid',$vendor_id)->get()->toArray();

        // echo"<pre>";print_r($vendor_data_attr);echo"</pre>";exit;

        foreach($vendor_data_attr as $attr_data){
            $vendor_att_email[] = $attr_data->c_email;
        

        }

        if(!empty($vendor_att_email)){
            $cc = implode(',',$vendor_att_email);
        }else{
            $cc = '';
        }
    
        $subject = "VendorsCity Lead Accepted for ".$package_data->name."! Here Are the Details";
        $to = $vendor_data->email;
        $ccRecipients = explode(',', $cc);
        $ccRecipients = array_filter($ccRecipients, 'strlen');
        Mail::send([], [], function($message) use($html, $to,  $subject,$ccRecipients) {
                $message->to($to,'VendorsCity');
            //  $message->bcc($bccEmails);
                $message->subject($subject);
                //$message->from('devang.hnrtechnologies@gmail.com','VendorsCity');
                foreach ($ccRecipients as $ccRecipient) {
                    $message->bcc($ccRecipient);
                }
                $message->html($html);
        });
        
    }




}