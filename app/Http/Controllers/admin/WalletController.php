<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Wallet;
use Illuminate\Support\Facades\Mail;
use Auth;
Use DB;
use Session;
use Stripe\Stripe;
use Stripe\Charge;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendor_data = Auth::user();       
        
        $data['wallet_data'] = Wallet::where('vendors_id', $vendor_data->id)->orderBy('id', 'DESC')->get();        
        
        return view('admin.list_wallet',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add_wallet');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo"<pre>";
        // print_r($request->post());
        // echo"</pre>";exit;
      $vendor_id = Auth::user()->id;
      

      

       $wallet= new Wallet;
       $wallet->price=$request->price;
       $wallet->payment=$request->payment;
       $wallet->vendors_id=Auth::user()->id;
       $wallet->add_deduct=0;
       $wallet->status=0; 
       //$wallet->transaction_id=$transaction_id; 



       if ($request->payment == 0){
            $wallet->payment_status='Success';
       }
       if ($request->payment == 1){
            $wallet->payment_status='Fail';
       }

       $wallet->save();

       $wallet_id = $wallet->id;

       $vendor_data_new = DB::table('users')->where('id',$vendor_id)->first();
       $year =date('y');
       $data_u['transaction_id'] = "TID-".$vendor_data_new->vendor_id."-" . $year ."-". sprintf("%06d", $wallet_id);
       DB::table('wallets')->where('id', $wallet_id)->update($data_u);

       /* notification sectio start */
       $data_notification['vendor_id'] = 1;
       $data_notification['subject'] = 'Vendor '.$vendor_data_new->name.' has added amount '.$request->price.'';
       $data_notification['added_datetime'] = date('Y-m-d h:i:s');

       DB::table('notification')->insert($data_notification);
   /* notification sectio end */


       Session::put('wallet_id', $wallet_id);

       if ($request->payment == 0){

        $vendor_id = Auth::user()->id;

        // echo"<pre>";print_r($wallet->created_at->format('d-m-Y'));echo"</pre>";exit;

        $html1 = '<!doctype html> <html>
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
            <img src="'.asset("public/site/images/VC-FULL-COLOR.png").'"" style="width: 40%;">
            </div>
            <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                
            <p>Dear Admin,</p>                 
            <p>We are excited to inform you that a new Request is received for approval of vendor wallet.</p>
            <p><strong>Please find the below vendor Details:</strong></p>
            <ul><li style= "list-style-type: disc;margin-bottom: -15px;">Vendor Name : '.\Helper::vendorsname($vendor_id).'</li>                       
            <li style= "list-style-type: disc;margin-bottom: -15px;">Request Amount : '.$request->price.'</li>
            <li style= "list-style-type: disc";>Request Date : '.$wallet->created_at->format('d-m-Y').'</li></ul>                        
            <p><a class="btnlink" href="'.route("adminwallet.index").'" style=" background: #0040E6;color: #fff !important;text-decoration: none;width: 100%;display: block;padding: 9px 0;text-align: center;
                font-size: 16px;border-radius: 9px;">View Request</a></p>

            <p><strong>What You Need to Do:</strong></p>
            <ul><li style= "list-style-type: disc;margin-bottom: -15px;"> Log in to your : <a href="'.route("adminwallet.index").'">Admin Portal</a></li>
            <li style= "list-style-type: disc";> View the full details and Vendor Request information.</li></ul>

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
                            <img style="width:70%;" src="'.asset("public/site/images/vcfaviconwap.png").'"" >
                        </div>
                        <div class="footer_right" style="margin-left:10px;
                        float: left;">
                            <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a></p>
                            <p  style="margin:0;">VendorsCity Portal LLC</p>
                            <div class="footer_links" style=" margin:10px 0;">
                        <a href="'.url("/terms-of-service").'"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                        <a href="'.url("/privacy-policy").'"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                        <a href="'.url("/contact").'"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                        </div>
                            <p style="margin:0;">This message was mailed to Admin as part of you account registered with us on VendorsCity</p>
                        </div>
                    </div>
              </div>
            </div>
        </body>
        </html>';

   

        $subject = "New Request for Vendor Wallet Approval on Vendorscity";

        $to_admin = ["hello@vendorscity.com"];

        Mail::send([], [], function($message) use($html1, $to_admin,  $subject) {
            // echo"test";exit;
            $message->to($to_admin,'VendorsCity');
            $message->subject($subject);
            $message->from('devang.hnrtechnologies@gmail.com','VendorsCity');
            $message->html($html1);
        });

        return redirect()->route('wallet.index')->with('success',"Wallet Data Added Successfully");
       }
       if ($request->payment == 1){
           
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));

            $response = $stripe->checkout->sessions->create([
                'line_items' => [
                  [
                    'price_data' => [
                      'currency' => 'aed',
                      'product_data' => [
                          'name' => 'Wallet'
                      ],
                      'unit_amount' => $request->price*100,
                    ],
                    'quantity' => 1,
                  ],
                ],
                'payment_method_types' => ['card'],
                'metadata' => [
                    'user_id' => Auth::user()->id, // Add user's ID to metadata
                ],
                'mode' => 'payment',
                'success_url' => route('paymentSuccess'),
                'cancel_url' => route('paymentFail'),
            ]);
           
            

            if(isset($response->id) && $response->id != ''){
                Session::put('stripe_session_id', $response->id);
                return redirect($response->url);
            }else{
                return redirect()->route('paymentFail');
            }

       }
    //    echo"<pre>";print_r($stripe);echo"</pre>";exit;
    }

    public function paymentSuccess(Request $request){
        $stripe_session_id = Session::get('stripe_session_id');

        $wallet_id = Session::get('wallet_id');

        if(isset($stripe_session_id)){

            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));

            $response = $stripe->checkout->sessions->retrieve($stripe_session_id);

            if($response->status == 'complete'){

                $data_u['payment_id'] = $response->id; 
                $data_u['payment_status'] = "Success";
                $data_u['status'] = 1;

                $orderdata = DB::table('wallets')->where('id',$wallet_id)->update($data_u);

                // Retrieve data from 'wallets' table, including the 'price' column
                $walletData = DB::table('wallets')->where('id', $wallet_id)->first();
                $value = 1;
                // Assuming 'users' table has a column 'wallet_amount', update it
                DB::table('users')->where('id', $walletData->vendors_id)->update([
                    'wallet_amount' => DB::raw('wallet_amount ' . ($value == 0 ? '-' : '+') . ' ' . $walletData->price),
                    // Adjust column names as needed
                ]);

                return redirect()->route('wallet.index')->with('success',"Wallet Data Added Successfully");
 
            }
            
        }else{
            return redirect()->route('paymentFail');
        }
    }

    function paymentFail(Request $request){
        
        session()->forget('wallet_id');
        session()->forget('stripe_session_id');
        
        return redirect()->route('wallet.index')->with('fail',"Payment Fail");

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
}