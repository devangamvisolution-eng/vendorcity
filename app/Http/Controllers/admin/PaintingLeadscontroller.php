<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;
use Illuminate\Support\Facades\Auth;

class PaintingLeadscontroller extends Controller
{
    public function index()
    {   
        $vendor_id = auth::user()->id;
      
        $data['all_data'] = DB::table('painting_enquiry')->where('vendor_id', 'LIKE', '%'.$vendor_id.'%')->orderBy('id', 'desc')->get();

        //echo"<pre>";print_r($data['all_data']);echo"</pre>";exit;       
        //echo"<pre>";print_r($data);echo"</pre>";exit;       
       return view('admin.vendor_painting_inquiry',$data);
    }

    function painting_assign_vendor(){
        
        $inquiry_id = $_POST['inquiry_id'];
		
		$painting_enquiry_data = DB::table('painting_enquiry')
            ->where('id', $inquiry_id)
            ->first();
        
        $currentDate = now();
			//echo "<pre>";print_r($vendor_subscription);echo"</pre>";exit;
        $html = '<label>Select a Vendor</label>';
        $html .= '<select id="painting_vendor_id" name="painting_vendor_id[]" class="form-control vendor-mul-drop select2" multiple="multiple">';
                
                $html .= "<option value=''>Select Vendor</option>";

                $vendor_data = DB::table('users')
                                ->whereRaw("FIND_IN_SET(?, serviceList)", [$painting_enquiry_data->service_id])
                                ->where('vendor', 1)
                                ->where('is_active', 0)
                                ->where('wallet_amount','>',0)
                                ->get()->toArray();
                       
                foreach($vendor_data as $vendor_data_new){

                    if(in_array($vendor_data_new->id,explode(",",$painting_enquiry_data->vendor_id))){
                        $selected = "selected";
                    } else {
                        $selected = "";
                    }

                    $html .= "<option value='" . $vendor_data_new->id . "'" . $selected . ">" . $vendor_data_new->name.' ('.$vendor_data_new->wallet_amount.')' . "</option>";
                }

        $html .= '</select>';
        $html .= "<input type='hidden' name='inquiry_id' id='inquiry_id' value='" . $inquiry_id . "'/>";
        echo $html;
    }

    function painting_email_vendor(){
        
        $inquiry_id = $_POST['inquiry_id'];
		
		$painting_enquiry_data = DB::table('painting_enquiry')
            ->where('id', $inquiry_id)
            ->first();
        
        $currentDate = now();
			//echo "<pre>";print_r($vendor_subscription);echo"</pre>";exit;
        $html = '<label>Select a Vendor</label>';
        $html .= '<select id="painting_vendor_id" name="painting_vendor_id[]" class="form-control vendor-mul-drop select2" multiple="multiple">';
                
                $html .= "<option value=''>Select Vendor</option>";

                $vendor_data = DB::table('users')
                                ->whereRaw("FIND_IN_SET(?, serviceList)", [$painting_enquiry_data->service_id])
                                ->where('vendor', 1)
                                ->where('is_active', 0)
                                ->where('wallet_amount','<',0)
                                ->get()->toArray();
                       
                foreach($vendor_data as $vendor_data_new){

                    if(in_array($vendor_data_new->id,explode(",",$painting_enquiry_data->vendor_id_for_email))){
                        $selected = "selected";
                    } else {
                        $selected = "";
                    }
        
                    $html .= "<option value='" . $vendor_data_new->id . "'".$selected.">" . $vendor_data_new->name.' ('.$vendor_data_new->wallet_amount.')' . "</option>";
                }

        $html .= '</select>';
        $html .= "<input type='hidden' name='inquiry_id' id='inquiry_id' value='" . $inquiry_id . "'/>";
        echo $html;
    }


    function painting_vendor_form(){

        $vendorId = implode(",",$_POST['painting_vendor_id']);
		
		$arrVendor = explode(",",$vendorId);

        $inquiry_id = $_POST['inquiry_id'];
		$painting_data = DB::table('painting_enquiry')
                                ->where('id', $inquiry_id)->first();


       // echo "<pre>";print_r(!empty(array_intersect((array) $painting_data->vendor_id, $arrVendor)));echo "</pre>";exit;
                                

        $vendor_detail = DB::table('users')->where('vendor', 1)->whereIn('id',explode(",",$vendorId))->get();

        $vendor_html ='';
		$emptyWalletVendor = [];
		$exitsAssignedVendor = [];
        $successMessage = "";
        foreach($vendor_detail as $vendordata){

        $vendor_id = $vendordata->id;
        $service_id = $painting_data->service_id;
        $subservice_id = $painting_data->subservice_id;
		
		$subscriptionCharge = DB::table('subscription_subservice_attribute')->select('*')
                                                ->where('service_id', $service_id)
                                                ->where('subservice_id', $subservice_id)
                                                ->first();

			if ( $vendordata->wallet_amount != 0 ) 
			{   

                $checkVendor = DB::table('package_inquiry_accepted')->select('*')
                                                ->where('packages_inquiry_id', $inquiry_id)
                                                ->where('vendor_id', $vendordata->id)
                                                ->first();
				
				if(empty($checkVendor)){

				$vendor_name = DB::table('users')->where('vendor', 1)->where('id',$vendordata->id)->value('name');

				$request_date = $painting_data->enquiry_month.' '.$painting_data->enquiry_date.', '.$painting_data->enquiry_year;

				$vendor_html .='<!doctype html>
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
							<img src="'.asset("public/site/images/VC-FULL-COLOR.png").'"" style="width: 40%;" >
							</div>
							<div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
											   <p>  Dear '.$vendor_name.',</p>
									   <p>We are excited to inform you that a new enquiry has been assigned to you through VendorsCity! Below are the details for the upcoming service:</p>';
									  $vendor_html .='<p><strong>Enquiry Details:</strong><br>';
										$vendor_html .='<ul>
															<li><strong>Service: </strong> '.\Helper::servicename($painting_data->service_id).'</li>
															<li><strong>Painting Service: </strong> '.$painting_data->type_of_painting.'</li>
															<li><strong>Customer Name: </strong> '.$painting_data->name.'</li>
															 <li><strong>Customer Email: </strong> '.$painting_data->email.'</li>
															<li><strong>Customer Contact: </strong> '.$painting_data->mobile.'</li>
															<li><strong>Date Requested: </strong> '.$request_date.'</li>
														</ul>';
									   
									$vendor_html .='
									<p>Your prompt attention to this enquiry is greatly appreciated. If you have any questions or need further assistance, feel free to reach out to us at any time.</p>
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
											   <img style="width:70%;" src="'.asset("public/site/images/vcfaviconwap.png").'"" >
										   </div>
										   <div class="footer_right"  style="margin-left:10px;
													float: left;">
											   <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a></p>
											   <p style="margin:0;">VendorsCity Portal LLC</p>
											   <div class="footer_links" style=" margin:10px 0;">
											   <a href="'.url("/terms-of-service").'" style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
											   <a href="'.url("/privacy-policy").'" style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
											   <a href="'.url("/contact").'" style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
											   </div>
											   
										   </div>
									   </div>
								   </div>
							   </div>
						   </body>
					</html>';
					$subject = "New ".\Helper::servicename($painting_data->service_id)." Enquiry Assigned on VendorsCity | Enquiry No. ".$painting_data->inquiry_id." ";
					$to = $vendordata->email;
				   
					$ccRecipients = DB::table('vendors_attribute')->where('pid',$vendordata->id)->pluck('c_email')->toArray();
                    $staticEmails = ['zafar@quickserverelo.com', 'hello@vendorscity.com'];
                    $ccRecipients = array_merge($ccRecipients, $staticEmails);
					Mail::send([], [], function($message) use($vendor_html, $to, $subject,$ccRecipients) {
						$message->to($to);
						$message->subject($subject);
						foreach ($ccRecipients as $ccRecipient) {
							$message->bcc($ccRecipient->c_email);
						}
						$message->html($vendor_html);
					});

                    DB::table('painting_enquiry')
                        ->where('id', $inquiry_id)
                        ->update(['vendor_id' => $vendorId]);
                    
					$walletAmountDeduct = $this->painting_wallet_amount_deduct($vendor_id,$service_id,$subservice_id,$inquiry_id);
                    
                    $successMessage = "Vendor Assign successfully";
				}else{
					$exitsAssignedVendor[] = $vendordata->name;
				}
			}else{
                $emptyWalletVendor[] = $vendordata->name;
            }

        } // vendor loop end  
       //echo "<pre>";print_r($emptyWalletVendor);echo"</pre>";exit;
		
		$walletErrorMessage = "";
		$vendorExitsErrorMessage = "";
		if($emptyWalletVendor !="" && count($emptyWalletVendor) > 0){
			
			$vendorNames = implode(', ', $emptyWalletVendor);
			if (count($emptyWalletVendor) == 1) {
				$var = "is";
			} else {
				$var = "are";
			}
			
			$walletErrorMessage = "The wallet amount for " . $vendorNames . " " . $var . " currently low.";
		}
		
        $errorMessage = $walletErrorMessage;

        // echo "<pre>";print_r($errorMessage);echo"</pre>";
        // echo "<pre>";print_r($emptyWalletVendor);echo"</pre>";
		//echo "<pre>";print_r($successMessage);echo"</pre>";exit;
     
        return redirect()->route('painting-enquiry')->with('success',$successMessage)->with('error',$errorMessage);
    }

    function painting_wallet_amount_deduct($vendor_id,$service_id,$subservice_id,$inquiry_id)
    {  
        $vendor_data = DB::table('users')->where('id',$vendor_id)->first();
        $painting_data = DB::table('painting_enquiry')->where('id', $inquiry_id)->first();
        $subscription_vendor_data = DB::table('subscription')
                                    ->where('services',$service_id)
                                    ->where('sub_service',$subservice_id)
                                    ->where('vendor_id', '=', $vendor_id)
                                    ->orderBy('id','DESC')
                                    ->get()
                                    ->toArray();

        $vendor_package_no_of_inquiry = 0;
        $vendor_lead_no_of_inquiry = 0;

        if(!empty($subscription_vendor_data)){

            foreach($subscription_vendor_data as $subscription_vendor_da){
                if($subscription_vendor_da->type_of_subscription == 0){
                    $vendor_package_no_of_inquiry += $subscription_vendor_da->no_of_inquiry_package;
                }else{
                    $vendor_lead_no_of_inquiry += 1;
                }
            }
        }

        $vendor_accept_inquiry_data = DB::table('package_inquiry_accepted')
                                    ->selectRaw('SUM(no_of_inquiry) as total_no_of_inquiry')
                                    ->where('vendor_id', $vendor_id)
                                    ->where('accept_reject', 0)
                                    ->where('subscription_type', 'p')
                                    ->first();

       //echo"<pre>";print_r($vendor_id);echo"</pre>";exit;
       if($vendor_package_no_of_inquiry > $vendor_accept_inquiry_data->total_no_of_inquiry){
            //echo "in";exit;
            $data_package['packages_inquiry_id'] = $inquiry_id;
            $data_package['vendor_id'] = $vendor_id;
            $data_package['added_date'] = date('Y-m-d');
            $data_package['accept_reject'] = 0;
            $data_package['subscription_type'] = 'p';
            $data_package['no_of_inquiry'] = 1;
            $data_package['service_id'] = $service_id;
            $data_package['subservice_id'] = $subservice_id;
            $data_package['type_of_leads'] = null;

            $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_package);
            $redirect_type = 'success';

        }else{
           // echo $vendor_lead_no_of_inquiry;exit;
            if($vendor_lead_no_of_inquiry != 0){
								
				if($subservice_id == 47)
				{					
                    $subscription_subservice_attribute = DB::table('subscription_subservice_attribute')->select('*')
                                                ->where('service_id', $service_id)
                                                ->where('subservice_id', $subservice_id)
                                                ->orderBy('id','DESC')
                                                ->first();
                                            // echo "<pre>";print_r($subscription_subservice_attribute);echo "</pre>";exit;                       
                    $vendors_data = DB::table('users')->where('id', $vendor_id)->first();

                    if($subscription_subservice_attribute->charge > 0){

                        if($subscription_subservice_attribute->charge > $vendors_data->wallet_amount || $vendors_data->wallet_amount == 0 )
                        {
							//$emptyWalletVendor[] = $vendordata->name;
                            echo "<script>
                            alert('Insufficient wallet balance or wallet is empty');
                            window.location.href = '" . route('wallet.index') . "'; 
                            </script>"; die();
                        }else{

                            $vendor_wallet_amount = $vendors_data->wallet_amount - $subscription_subservice_attribute->charge;
               
                            $data_inquiry_painting['packages_inquiry_id'] = $inquiry_id;
                            $data_inquiry_painting['vendor_id'] = $vendor_id;
                            $data_inquiry_painting['added_date'] = date('Y-m-d');
                            $data_inquiry_painting['accept_reject'] = 0;
                            $data_inquiry_painting['subscription_type'] = 'l';
                            $data_inquiry_painting['no_of_inquiry'] = 1;
                            $data_inquiry_painting['service_id'] = $service_id;
                            $data_inquiry_painting['subservice_id'] = $subservice_id;
                            $data_inquiry_painting['type_of_leads'] = null;
                            $data_inquiry_painting['size_of_house_id'] = null;
                            $data_inquiry_painting['price_of_lead'] = $subscription_subservice_attribute->charge;
                            
                            $id_package_inquiry_accepted =  DB::table('package_inquiry_accepted')->insertGetId($data_inquiry_painting);
                            
                            DB::table('users')->where('id', $vendor_id)->update(['wallet_amount' => $vendor_wallet_amount]);
                            
                            
                            $data_wallet['vendors_id'] = $vendor_id;
                            $data_wallet['price'] = $subscription_subservice_attribute->charge;
                            $data_wallet['add_deduct'] = 1;
                            $data_wallet['subscription_id'] = $subscription_vendor_data[0]->id;

                            $wallet_id = DB::table('wallets')->insertGetId($data_wallet);
                            
                            $vendor_data_new = DB::table('users')->where('id',$vendor_id)->first();
                            $year =date('y');
                            $data_u['transaction_id'] = "TID-".$vendor_data_new->vendor_id."-" . $year ."-". sprintf("%06d", $wallet_id);

                            DB::table('wallets')->where('id', $wallet_id)->update($data_u);
                        
                        
                            $redirect_type = 'success';
                        }
                        
                    }else{
                        
                        $redirect_type = 'error';
                        $redirect_message = 'You are not purchase Lead Subscription or Package for this Inquiry.'; 
                    }   
                }
			}else{
               
				$redirect_type = 'error';
                $redirect_message = 'Your Subscription has been expire or finish. Please contact Vendorscity for new or renew Subscription.'; 
				
			}
        }

        if($redirect_type == 'success'){
			
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
                        
                    <p>Dear '.$vendor_data->name.',</p>  
                   
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
                            <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;border-collapse: collapse;"> '.$painting_data->name.'</td>
                        </tr>
                        <tr>
                            <td class="custome_td" style="background-color: #0040E6;
                            color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;border-collapse: collapse;">Email:</td>
                            <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;border-collapse: collapse;"> '.$painting_data->email.'</td>
                        </tr>
                        <tr>
                            <td class="custome_td" style="background-color: #0040E6;
                            color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;
                        border-collapse: collapse;">Mobile No:</td>
                            <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;
                        border-collapse: collapse;"> '.$painting_data->mobile.'</td>
                        </tr>
						<tr>
                            <td class="custome_td" style="background-color: #0040E6;
                            color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;
                        border-collapse: collapse;">Date:</td>
                            <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;
                        border-collapse: collapse;"> '.$painting_data->enquiry_month.' '.$painting_data->enquiry_date.', '.$painting_data->enquiry_year.'</td>
                        </tr>
						<tr>
                            <td class="custome_td" style="background-color: #0040E6;
                            color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;
                        border-collapse: collapse;">Time:</td>
                            <td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;
                        border-collapse: collapse;"> '.\Helper::timeslotname(strval($painting_data->time_slot)).'</td>
                        </tr>
						<tr>';
                           
						if($painting_data->no_of_rooms_painted != 0){
							$html.='<td class="custome_td" style="background-color: #0040E6;
								color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;
							border-collapse: collapse;">Paint individual rooms:</td>
								<td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;
							border-collapse: collapse;"> '.$painting_data->no_of_rooms_painted.'</td>
							</tr>';
						}
						
						if($painting_data->no_of_walls_painted != 0){
							$html.='<td class="custome_td" style="background-color: #0040E6;
								color: #fff;padding: 10px 60px 10px 12px;border-bottom-color: #fff !important;border: 1px solid black;
							border-collapse: collapse;">Paint individual walls:</td>
								<td class="custome_td_new" style=" padding: 10px 12px;border: 1px solid black;
							border-collapse: collapse;"> '.$painting_data->no_of_walls_painted.'</td>
							</tr>';
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
		
			$subject = "VendorsCity Painting Lead for ".$painting_data->type_of_painting."! Here Are the Details";
			$to = $vendor_data->email;
            $ccRecipients = explode(',', $cc);
			$ccRecipients = array_filter($ccRecipients, 'strlen');
            $staticEmails = ['zafar@quickserverelo.com', 'hello@vendorscity.com'];
            $ccRecipients = array_merge($ccRecipients, $staticEmails);
			Mail::send([], [], function($message) use($html, $to,  $subject,$ccRecipients) {
                    $message->to($to,'VendorsCity');
                //  $message->bcc($bccEmails);
                    $message->subject($subject);
                    foreach ($ccRecipients as $ccRecipient) {
                        $message->bcc($ccRecipient);
                    }
                    $message->html($html);
            });
			
			$customer_html_new ='';
 
        $customer_html_new .='<!doctype html>

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
								<img src="'.asset("public/site/images/VC-FULL-COLOR.png").'""style="width: 40%;" >
								</div>

                <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                   <p>  Dear '.$painting_data->name.',</p>
                   <p>We hope this email finds you well.</p>';
				   
                    $text1 = "A vendor has reviewed your service request on VendorsCity and would like to conduct a survey before providing an accurate quote. Here are the details:";

                    $text2 = "The vendor will contact you soon to confirm the survey details.  If you do not hear from the vendor within the next 24 hours, please contact them directly at ".$vendor_data->mobile.".";

                    $text3 = "This survey will help the vendor understand your specific needs and ensure you receive the most accurate and competitive quote for the service.";
                    $subject_type = "Survey Request for Your " . \Helper::servicename($painting_data->service_id) ." Request on VendorsCity!";
                  $customer_html_new .='<p>'.$text1 .'<br><br>';


                   $customer_html_new .='<span style="
                    margin-bottom: 15px;
                    display: inline-block;
                "><strong>Service Requested: </strong>' .  \Helper::servicename($painting_data->service_id) .'</span><br>';
                                
                                $customer_html_new .='<span style="
                    margin-bottom: 15px;
                    display: inline-block;
                ">
                                <strong>Vendor Name:</strong> '.$vendor_data->name.'</span><br>
                                <span style="
                    margin-bottom: 15px;
                    display: inline-block;
                ">
                                <strong>Vendor Contact:</strong> '.$vendor_data->mobile.'</span><br>';
                
                

                $customer_html_new .='<p>'.$text2.'</p>

                <p>'.$text3.'
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
                                    <img style="width:70%;" src="'.asset("public/site/images/vcfaviconwap.png").'"" >
                                </div>
                                <div class="footer_right" style="margin-left:10px;
                                float: left;">
                                    <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                                    <p style="margin:0;">VendorsCity Portal LLC</p>
                                    <div class="footer_links" style=" margin:10px 0;">
                                <a href="'.url("/terms-of-service").'"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                <a href="'.url("/privacy-policy").'"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                <a href="'.url("/contact").'"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                                </div>
                                    <p style="margin:0;">This message was mailed to '.$painting_data->email.' as part of you account registered with us on VendorsCity</p>
                                </div>
                            </div>
                     </div>
                 </div>
            </body>
			</html>';
			
			$subject = $subject_type;
            $to = $painting_data->email;
            $ccRecipients = ['hello@vendorscity.com','zafar@quickserverelo.com'];
			
			Mail::send([], [], function($message) use($customer_html_new, $to,  $subject,$ccRecipients) {
				$message->to($to,'VendorsCity');
				//  $message->bcc($bccEmails);
				$message->subject($subject);
				//$message->from('devang.hnrtechnologies@gmail.com','VendorsCity');
				foreach ($ccRecipients as $ccRecipient) {
					$message->bcc($ccRecipient);
				}
				$message->html($customer_html_new);
			});
			
		}


    }


    function painting_wallet_vendor(){
        $vendor_id = implode(",",$_POST['painting_vendor_id']);

        $inquiry_id = $_POST['inquiry_id'];

        DB::table('painting_enquiry')
            ->where('id', $inquiry_id)
            ->update(['vendor_id_for_email' => $vendor_id]);

        $vendor_detail = DB::table('users')->where('vendor', 1)->whereIn('id',explode(",",$vendor_id))->get();
        $painting_data = DB::table('painting_enquiry')
                                ->where('id', $inquiry_id)->first();
            
        $vendor_html ='';
        foreach($vendor_detail as $vendordata){

            $vendor_html .='<!doctype html>
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
<img src="'.asset("public/site/images/VC-FULL-COLOR.png").'"" style="width: 40%;" >
</div>
<div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                   <p>  Dear '.$vendordata->name.',</p>
                   <p>I am reaching out to inform you that the current balance in your wallet has fallen below the minimum required amount. To ensure uninterrupted service and transactions, we kindly request that you update your wallet at the earliest convenience.</p>';
                   
                $vendor_html .='<p>Thank you for your continued partnership and dedication to providing top-notch service.
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
                           <img style="width:70%;" src="'.asset("public/site/images/vcfaviconwap.png").'"" >
                       </div>
                       <div class="footer_right"  style="margin-left:10px;
                                float: left;">
                           <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a></p>
                           <p style="margin:0;">VendorsCity Portal LLC</p>
                           <div class="footer_links" style=" margin:10px 0;">
                           <a href="'.url("/terms-of-service").'" style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                           <a href="'.url("/privacy-policy").'" style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                           <a href="'.url("/contact").'" style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                           </div>
                           
                       </div>
                   </div>
               </div>
           </div>
       </body>
</html>';
        $subject = "Wallet Balance Update Required";
        $to = $vendordata->email;
       
        $ccRecipients = DB::table('vendors_attribute')->where('pid',$vendordata->id)->pluck('c_email')->toArray();
        $staticEmails = ['zafar@quickserverelo.com', 'hello@vendorscity.com'];
        $ccRecipients = array_merge($ccRecipients, $staticEmails);
        Mail::send([], [], function($message) use($vendor_html, $to, $subject,$ccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient->c_email);
            }
            $message->html($vendor_html);
        });

        } 
        return redirect()->route('painting-enquiry')->with('success','The E-mail to the vendor has been sent successfully.');
    }
}
