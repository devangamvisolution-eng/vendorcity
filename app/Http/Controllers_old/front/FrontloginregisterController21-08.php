<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\front\Frontloginregister;
use Hash;
use DB;
use Session;
use Socialite;
use Exception;
use Helper;
use Str;
// use App\Jobs\SendEmailJob;

use Carbon\Carbon;
use App\Models\Admin\City;
use Symfony\Component\Mime\Email;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;




class FrontloginregisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,  $id = null)
    {
       echo $id;
       
       return view('front.frontloginregister');
    }

    function test($id = null){

        $decryptedId = base64_decode($id);
        // echo $decryptedId;exit;
        
        return view('front.frontloginregister',['decryptedId' => $decryptedId]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('front.front_login');
    }

    function search_package(Request $request){ 

       
    //     session()->forget('search_city_id');

    //      //echo"<pre>";print_r($request->search_city);echo"</pre>";exit;

    //    $cityId =  Session::put('search_city_id', $request->search_city);

    //   // echo $cityId;


    //     Session::put('search_content', $request->search);
        
    //     // echo "<pre>";print_r($request->all());echo "</pre>";exit;  
    //    $data['serach_var'] =  $search = $request->search;
    //    $data['search_city'] =  $search_city = $request->search_city;

    //    $CityName = City::where('id',$request->search_city)->first();

    //   // echo"<pre>";print_r($CityName);echo"</pre>";exit;

    //     if($CityName) {
    //         $slug = Str::slug($CityName->name);
    //         Session::put('search_city_name', $slug);
    //     } else {
    //         Session::put('search_city_name', 'dubai');
    //     }

    //    // echo session('search_city_name');exit;

    //    $query = DB::table('subservices');
    //    $query = $query->where('is_active','0')->where('subservicename', 'like', '%' . $search . '%');
    //    $pagination =  $query->orderBy('id', 'DESC')->first(); 

    //    if($request->search == "" && $request->currentUrl_header != ''){
    //     return Redirect::away($request->currentUrl_header);
    //    }elseif(empty($request->search)){
    //     return redirect()->to('/')->with('L_strsucessMessage','');
    //   }

    //    if($pagination != ''){
    //         $pageUrl = $pagination->page_url;
    //         return redirect()->route('package-lists', ['page_url' => $pageUrl,'search_city' => $search_city]);
    //    }else{

    //     return redirect()->to('/')->with('L_strsucessMessage','');
    //     //echo "<pre>";print_r($request->all());echo "</pre>";exit;
    //    }

     session()->forget('search_city_id');

    // Save selected city
    Session::put('search_city_id', $request->search_city);
    Session::put('search_content', $request->search);

    $search       = $request->search;
    $search_city  = $request->search_city;

    $CityName = City::where('id', $search_city)->first();

    if ($CityName) {
        $slug = Str::slug($CityName->name);
        Session::put('search_city_name', $slug);
    } else {
        $slug = 'dubai';
        Session::put('search_city_name', $slug);
    }

    
     $currentUrl = $request->input('currentUrl_header') ?: $request->headers->get('referer');

    // --- Robust path parsing (works with /dev_vc base) ---
    $path = parse_url($currentUrl, PHP_URL_PATH) ?? '/';
    $base = $request->getBaseUrl();              // e.g. "/dev_vc"
    if (Str::startsWith($path, $base)) {
        $relative = ltrim(Str::after($path, $base), '/'); // e.g. "dubai/service/cleaning"
    } else {
        $relative = ltrim($path, '/');                   // fallback
    }

    // Split into segments
    $segments = array_values(array_filter(explode('/', $relative)));

    // Build a set of valid city slugs to decide if segment[0] is a city
    // (cache in real app if cities list is large)
    $citySlugs = City::pluck('name')->map(fn($n) => Str::slug($n))->toArray();

    // CASE A: Root (no segments) -> treat as home -> redirect to /{slug}
    if (count($segments) === 0) {
        $newPath = '/' . $slug; // "/abu-dhabi"
        $absolute = $request->getSchemeAndHttpHost() . $base . $newPath;
        return redirect()->away($absolute);
    }

    // CASE B: City Home "/{city}" ONLY if first segment is a valid city
    if (count($segments) === 1 && in_array($segments[0], $citySlugs, true)) {
        $segments[0] = $slug; // replace city
        $newPath = '/' . implode('/', $segments); // "/sharjah"
        $absolute = $request->getSchemeAndHttpHost() . $base . $newPath;
        return redirect()->away($absolute);
    }

    // CASE C: City Service "/{city}/service/..." ONLY if pattern matches
    if (count($segments) >= 2 && $segments[1] === 'service' && in_array($segments[0], $citySlugs, true)) {
        $segments[0] = $slug; // replace city
        $newPath = '/' . implode('/', $segments); // "/sharjah/service/cleaning"
        $absolute = $request->getSchemeAndHttpHost() . $base . $newPath;
        return redirect()->away($absolute);
    }
    
    $query = DB::table('subservices')
        ->where('is_active','0')
        ->where('subservicename', 'like', '%' . $search . '%');

    $pagination = $query->orderBy('id', 'DESC')->first(); 

    if ($search == "" && $currentUrl != '') {
        return Redirect::away($currentUrl);
    } elseif (empty($search)) {
        return redirect()->to('/')->with('L_strsucessMessage','');
    }

    if ($pagination != '') {
        $pageUrl = $pagination->page_url;
        return redirect()->route('package-lists', [
            'page_url'   => $pageUrl,
            'search_city'=> $search_city
        ]);
    } else {
        return redirect()->to('/')->with('L_strsucessMessage','');
    }

     
        
    }
    public function Sign_in(Request $request)
    {
		
		session(['prev_url' => url()->previous()]);
		
        $lastReferringUrl = $request->server('HTTP_REFERER');
    
        $explodedUrls = explode('/', $lastReferringUrl);
        $endUrl = end($explodedUrls);
        
        if ($endUrl != 'register') {

            if(Session::get('redirect_url') != ''){
                Session::put('redirect_url', Session::get('redirect_url'));
            }else{
                Session::put('redirect_url', $request->server('HTTP_REFERER'));
            }
            
        }

        $data['meta_title'] = "";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "Sign in to your VendorsCity account for quick access to orders, service bookings, and vendor interactions. Enjoy a seamless user experience!"; 

        return view('front.front_login', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // echo"<pre>";print_r($request->post());echo"</pre>";exit;
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'], 
            'email' => 'required|email|max:255',
            'mobile' => 'required|numeric',
            'captcha' => 'required',
        ]);

        if ($request->captcha != Session::get('captcha')) {
            return redirect()->back()->withErrors(['captcha' => 'Invalid captcha code!']);
        }
    
    
    
        // echo"<pre>";print_r($validatedData);echo"</pre>";exit;

        $frontloginregister= new Frontloginregister;
        if($request->refer_id !=''){
            $frontloginregister->refer_id=$request->refer_id;
        }        
        $frontloginregister->name=$request->name;
        $frontloginregister->email=$request->email;
        $frontloginregister->password= Hash::make($request->password);
        $plainPassword = $request->password;
        $frontloginregister->mobile=$request->mobile;  
        $frontloginregister->status=1;    
      

        $frontloginregister->save();

        $frontloginregister_id = $frontloginregister->id;
        $data_u['customer_id'] = "VC-".$frontloginregister_id."";
        DB::table('frontloginregisters')->where('id', $frontloginregister_id)->update($data_u);

        $newuserdata = array(
            'userid'  => $frontloginregister->id,
            'refer_id'  => $frontloginregister->refer_id,
            'name'  => $frontloginregister->name,            
            'email'  => $frontloginregister->email,       
            'mobile'  => $frontloginregister->mobile,       
            'logged_in' => true
        );
        $check = Session::put('user', $newuserdata);
        $html = '<!doctype html> <html>
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
            <img src="'.asset("public/site/images/VC-FULL-COLOR.png").'"" style="width: 40%;"  >
            </div>
            <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                <p>Hi '.$request->name.',</p>
                <p>Welcome to VendorsCity!</p>
                <p>We are thrilled to have you on board. Your account has been successfully created, and you are now ready to explore our wide range of services designed to make your life easier.
                </p>
                <p>Here is what you can do next:</p>
                <p><span style="font-weight: bolder;">Explore Services:</span> Browse our extensive list of home services to find exactly what you need.</p>
                <p><span style="font-weight: bolder;">Book Appointments or Request Quotes:</span> Schedule services or Get up to 5 Free Quotes at your convenience with just a few clicks.
                </p>
                <p><span style="font-weight: bolder;">Manage Your Account:</span> Update your profile, track your bookings, and manage your preferences easily.</p>
                <p>If you have any questions or need assistance, our support team is here to help. Visit our Help Center or  <a href="'.url("/contact").'">contact us</a> directly at <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a>.</p>

                <p>Thank you for choosing VendorsCity. We&#39;re excited to help you simplify your life!
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
    $subject = "Welcome to VendorsCity! Your Journey to Hassle-Free Living Starts Here";
    $to =$request->email;
    $bccRecipients = ['hello@vendorscity.com','zafar@quickserverelo.com'];
    $ccRecipients = array();
    // SendEmailJob::dispatch($to, $subject, $html, $ccRecipients);
     
        Mail::send([], [], function($message) use($html, $to, $subject,$ccRecipients,$bccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->cc($ccRecipient);
            }
            foreach ($bccRecipients as $bccRecipient) {
                $message->bcc($bccRecipient);
            }
            $message->html($html);
        });

        

        $admin = "devang.hnrtechnologies@gmail.com";
      

        $redirectUrl = Session::get('redirect_url');

        // dd($redirectUrl);
		
		if(session::has('refer_earn_flag')){
				 return redirect()->to('refer&earn')->with('L_strsucessMessage','');
			 }
		
		 if (session()->has('prev_url')) {
				return redirect(session('prev_url'));
			}

        if (!empty($redirectUrl)) {
            return redirect()->to($redirectUrl)->with('L_strsucessMessage','Registration Successfully.');
            }else{
            return redirect()->to('/')->with('L_strsucessMessage','Registration  Successfully.');
            }      

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // echo"<pre>";
        // print_r($frontloginregister);
        // echo"</pre>";exit;
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
        // echo"test";exit;
    }
    function registration_mail_check(){

        // echo "test";exit;

        $email = $_POST['email']; 

        $result = DB::table('frontloginregisters')
            ->select('*')
            ->where('email', $email)
            ->first();

        if ($result) {
            return 1;
        } else {
            return 0;
        }

            echo $result;
    }

    public function check_login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        
        $user = DB::table('frontloginregisters')->where('email', $email)->first();
    
        if ($user && Hash::check($password, $user->password)) {
            if ($user->status == 1) {
                echo 1; // Login successful
            } else {
                echo 2; // Status is not 1
            }           
            
        } else {
            
            echo 0;
        }
    }
    // if ($user && Hash::check($password, $user->password)  && $user->status == 1)
    public function user_signout()
    {
        Session::flush();
        // return redirect()->route('Sign-in');
        return redirect()->route('fronthome');
        
    }
    public function user_login(Request $request)
    {
        $data['email'] = $request->email;
        $data['password'] = $request->password;
    
        // Check if the user exists based on the email
        $checklogin = DB::table('frontloginregisters')->where('email', $data['email'])->first();
    
        if ($checklogin && Hash::check($data['password'], $checklogin->password)) {
            // Login successful
            $newuserdata = [
                'userid' => $checklogin->id,
                'refer_id'  => $checklogin->refer_id,
                'name' => $checklogin->name,
                'email' => $checklogin->email,
                'mobile' => $checklogin->mobile,
                'logged_in' => true,
            ];
			
			/* $packageEnquiryFormId = session('packages_enquiry_form_id');
			
			if(isset($packageEnquiryFormId) && $packageEnquiryFormId != ''){
					
					$data_en_form['name'] = $checklogin->name;
					$data_en_form['email'] = $checklogin->email;
					$data_en_form['mobile'] = $checklogin->mobile;
					
					DB::table('packages_enquiry')->where('id', '=', $packageEnquiryFormId)->update($data_en_form);
					
					session()->forget('packages_enquiry_form_id');
			} */
			
			
			
			//echo session('prev_url')
    
            Session::put('user', $newuserdata);

            $redirectUrl = Session::get('redirect_url');

            if(\Cart::count() > 0){
                return redirect()->to('/checkout')->with('L_strsucessMessage','Login Successfully.');
             }
			 
			 if(session::has('refer_earn_flag')){
				 return redirect()->to('refer&earn')->with('L_strsucessMessage','You have successfully logged in.');
			 }
			 
			 

            // echo session('refer_earn_flag');exit;
			 
			if (session()->has('prev_url')) {
				return redirect(session('prev_url'));
			}

            if (!empty($redirectUrl)) {
                return redirect()->to($redirectUrl)->with('L_strsucessMessage','You have successfully logged in.');
                }else{
                return redirect()->to('/')->with('L_strsucessMessage','Log in Successfully.');
                }
    
           
        }
        
    }
    public function lost_password(){

        $data['meta_title'] = "";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "";

        return view('front.lost_password',$data);
    }
        public function emailCheck(Request $request)
    {
        $email = $request->email;
        $user = DB::table('frontloginregisters')->select('*')->where('email','=',$email)->first();
        if ($user == '')
        {
            echo "0";
        }
        else
        {
            echo "1";
        }
    }

     public function get_password(Request $request)
    {
        $email = $request->email;
        
        $user_data = DB::table('frontloginregisters')->where('email','=',$email)->first();
        $encrypted = Crypt::encryptString($user_data->id);
        $data = '<!doctype html> <html>
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
                    <img src="'.asset("public/site/images/VC-FULL-COLOR.png").'"" style="width: 40%;"   >
                    </div>
                    <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;" >
                        <h2 style= "font-size: 26px;font-weight: bolder;margin: 0;">Reset Your Password</h2>
                        <p>Dear '.$user_data->name.',</p>
                        <p>Let&apos;s reset your password so you can get back to using our services. </p>
                        <p><a class="btnlink" href="'.URL::to('/reset-password').'/'.$encrypted.'" style="background: #0040E6;color: #fff !important;
                        text-decoration: none;width: 100%;display: block;padding: 9px 0;
                        text-align: center;font-size: 16px;border-radius: 9px;">Reset Password</a></p>
                        <p>If you did not ask to reset your password you may want to review your recent account access for any unsual activity.</p>
                        <p>We&apos;re here to help if you need it, <a style="color: #555;" href="'.URL::to('/contact').'">Contact Us</a> so we can help resolve your problem immediately.</p>
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
                                <a href="'.url("/terms-of-service").'" style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                <a href="'.url("/privacy-policy").'" style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                <a href="'.url("/contact").'" style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                                </div>
                                <p style="margin:0;">This message was mailed to '.$email.' as part of you account registered with us on VendorsCity</p>
                            </div>
                        </div>
                    </div>
                </div>  
            </body>
        </html>';
        $subject = "Complete Your Password Reset Request";

      // echo $data;exit;
        $bccRecipients = ['hello@vendorscity.com','zafar@quickserverelo.com'];
        $to = $email;
        $ccRecipients = array();
        Mail::send([], [], function($message) use($data, $to, $subject,$ccRecipients,$bccRecipients) {
            $message->to($to,'VendorsCity');
            $message->subject($subject);
           
            foreach ($ccRecipients as $ccRecipient) {
                $message->cc($ccRecipient);
            }
            foreach ($bccRecipients as $bccRecipient) {
                $message->bcc($bccRecipient);
            }
            $message->html($data);
        });

        
        return redirect()->to('/forget-password')->with('L_strsucessMessageForegot','E-mail has been sent Successfully');
    }

        public function reset_password(Request $request)
    {
        $user_id = $request->uid;
        $user_id = Crypt::decryptString($user_id);
        $data['uid'] = $user_id;

        $data['meta_title'] = "";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "";

        return view('front.reset-password',$data);
    }
   

    public function set_password(Request $request)
    {
        $user_id = $request->uid;
        if ($_POST['action'] == "reset-password")
        {
            foreach($_POST as $key => $value)
            {
                $data[$key] = $_POST[$key];
            }
        }
        $password = Hash::make($data['password']);
        
        DB::table('frontloginregisters')->where('id','=',$user_id)->update(['password' => $password]);
        return redirect()->route('Sign-in')->with('L_strsucessMessage','Password Changed Successfully');
    }

    public function check_email(Request $request){

        $email = $request->email;
        $result = DB::table('subscribes')->where('email',$email)->first();
        
        if($result !=''){
            echo 0;
        }else{

            // echo "test";exit;
            echo 1;
        }
    }

    public function news_letter_email(Request $request){
        // echo "test";exit;
        $data['email'] = $request->subs_email;
        $data['created_at'] = date('Y-m-d');

        //echo "<pre>";print_r($data);echo "</pre>";exit;
        DB::table('subscribes')->insert($data);

        $html = '<!doctype html> <html>
        
            <head>
                <meta charset="utf-8">
                <title>Subscribes Email</title>
                <style>
                    .logo {
                        text-align: center;
                        width: 100%;
                          }
        
                    .wrapper {
                        width: 100%;
                        max-width:500px;
                        margin:auto;               
                        font-size:14px;
                        line-height:24px;
                        font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;
                        color:#555;
                    }
        
                    .wrapper div {                
                        height: auto;
                        
                        margin-bottom: 15px;
                        width:100%;
                    }
                    .text-center {
                        text-align: center;                
                    }
        
                    .email-wrapper {
                        padding:5px;
                        border:1px solid #ccc;
                        width:100%;
                    }
        
                    .big {
        
                        text-align: center;
        
                        font-size: 26px;
        
                        color: #e31e24;
        
                        font-weight: bold;
        
                        margin-bottom: 0 !important;
        
                        text-transform: uppercase;
        
                        line-height: 34px;
                    }
        
                    .welcome {                
        
                        font-size: 17px;                
        
                        font-weight: bold;
                    }
        
                    .footer {
        
                        text-align: center;
        
                        color: #999;
        
                        font-size: 13px;
                    }
        
                </style>
            </head>     
            <body>
                <div class="wrapper" >
                
                    <div class="logo">
                        <img src="'.asset("public/site/images/VC-LONG-COLOR.png").'" style="width: 30%;float: inherit;" >
                    </div>
                    <div class="email-wrapper" >
                        <table style="border-collapse:collapse;" width="100%" border="0" cellspacing="0" cellpadding="10">          
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="5">   
                                        <tr>
                                            <td style="font-size:18px;">Hello ,</td>
                                        </tr>
                                        <tr>
                                            <td style="line-height:20px;">
                                               Please find the below Subscribe details
                                            </td> 
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table style="border-top:3px solid #333;" bgcolor="#f7f7f7" width="100%" border="0" cellspacing="0" cellpadding="5">   
                                        <tr>
                                            <td width="50%">        
                                                <table width="100%" border="0" cellspacing="0" cellpadding="5">   
                                                    
                                                    <tr><td width="100px">Email: </td><td>'.$data['email'].'</td></tr>
                                                   
                                                </table>
                                            </td>   
                                        </tr>   
                                    </table>
                                </td>   
                            </tr>
                        </table>
                    </div>
                    
                </div>
            </body>
        </html>';

        //echo $html;exit;
        $subject = "Thank you for Subscribe - VendorsCity";
        //$to = $data['email'];
         $to = 'devang.hnrtechnologies@gmail.com';
         $bccRecipients = ['hello@vendorscity.com','zafar@quickserverelo.com'];
        // $to = $request->email;
         
        $to = $email;
        $ccRecipients = array();
        Mail::send([], [], function($message) use($html, $to, $subject,$ccRecipients,$bccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->cc($ccRecipient);
            }
            foreach ($bccRecipients as $bccRecipient) {
                $message->bcc($bccRecipient);
            }
            $message->html($html);
        });


        // return redirect()->route('/')->with('L_strsucessMessage','News Letter Email Added successfully');
        return redirect()->to('/')->with('L_strsucessMessage','News Letter Email Added successfully');
    }



    public function redirectToGoogle()
{
    return Socialite::driver('google')->stateless()->redirect();
}

public function gmail()
{
    try {
        if (!request()->has('code')) {
            return redirect('/')->with('L_strerrorMessage', 'Google login failed. Please try again.');
        }

        $user = Socialite::driver('google')->stateless()->user();

        $email = $user->getEmail();
        $username = $user->getName();

        $checklogin = DB::table('frontloginregisters')->where('email', $email)->first();

        if ($checklogin) {
            $newuserdata = [
                'userid' => $checklogin->id,
                'refer_id' => $checklogin->refer_id,
                'name' => $checklogin->name,
                'email' => $checklogin->email,
                'mobile' => $checklogin->mobile,
                'logged_in' => true,
            ];
            Session::put('user', $newuserdata);
        } else {
            $frontloginregister = new Frontloginregister;
            $frontloginregister->name = $username;
            $frontloginregister->email = $email;
            $frontloginregister->password = bcrypt(strval(time()));
            $frontloginregister->status = 1;
            $frontloginregister->save();

            $checklogin = DB::table('frontloginregisters')->where('email', $email)->first();

            $newuserdata = [
                'userid' => $checklogin->id,
                'refer_id' => $checklogin->refer_id,
                'name' => $checklogin->name,
                'email' => $checklogin->email,
                'mobile' => $checklogin->mobile,
                'logged_in' => true,
            ];
            Session::put('user', $newuserdata);
        }

        $redirectUrl = Session::get('redirect_url');

        if (\Cart::count() > 0) {
            return redirect()->to('/checkout')->with('L_strsucessMessage', 'Login Successfully.');
        }

        if (Session::has('refer_earn_flag')) {
            return redirect()->to('refer&earn')->with('L_strsucessMessage', 'You have successfully logged in.');
        }

        if (Session::has('prev_url')) {
            return redirect(Session::get('prev_url'));
        }

        if (Session::has('param_ids')) {
            return redirect()->route('enquiry', [
                'service_id' => Session::get('param_ids')['service_id'],
                'subservice_id' => Session::get('param_ids')['subservice_id'],
            ])->with('L_strsucessMessage', '');
        }

        return !empty($redirectUrl)
            ? redirect()->to($redirectUrl)->with('L_strsucessMessage', 'You have successfully logged in.')
            : redirect('/')->with('L_strsucessMessage', 'Log in Successfully.');

    } catch (\Throwable $e) {
        \Log::error('Google Login Error: '.$e->getMessage());
        return redirect('/')->with('L_strerrorMessage', 'Google login failed. Please try again.');
    }
}


    public function test_mail(){
       // echo "here";exit;

       $vendor_data = DB::table('users')->where('id',119)->first();

        $subject = "VendorsCity test";
       // $html = "Welcome to VendorsCity";
        
        $htmll = '<!doctype html> <html>
                <head>
                    <meta charset="utf-8">
                    <title>Registration Email</title>
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
                    <div class="wrapper" style="width: 100%;
                            max-width:500px;
                            margin:auto;
                            font-size:14px;
                            line-height:24px;
                            font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;
                            color:#555;
                            padding:50px 0;">
                        <div class="logo" style="float: inherit;border-bottom: 4px solid #FFD413;">
                        <img src="'.asset("public/site/images/VC-FULL-COLOR.png").'"" style="width: 40%;" >
                        </div>
                        <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                            <p>Dear '.$vendor_data->name.',</p>
                            
                            <p>Congratulations! We are delighted to inform you that your registration as a vendor on VendorsCity has been accepted. Welcome aboard!</p>';

                                               
                            
                            $htmll .=' 

                            <p><strong>Your Vendor Login Details:</strong> <br>Email: '.$vendor_data->email.'</p>
                            <p>You can now access your vendor dashboard and start offering your services to our customers. Here are some key actions you can take in your dashboard:</p>
                            <ol>
                                <li><b>Manage Bookings:</b> View, accept, manage bookings and quote requests from customers.
                                    
                                </li>
                                <li><b>View Payments:</b> Track your earnings and payment history.
                                </li>
                                <li><b>Customer Communication:</b> Communicate with customers and address their queries.
                                </li>
                            </ol>

                            <p><a class="btnlink" href="'.url("admin").'">Get Started</a></p>

                            <p>If you have any questions or need assistance, feel free to reach out to us at <a href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a>. We are here to support you throughout your journey with VendorsCity.
                            </p>
                            
                            
                            <p>Once again, welcome to our platform, and we look forward to a successful partnership!</p>

                            
                        </div>
                        <div class="email_footer" style="width:100%;margin-top: 20px;">
                            <h3>The VendorsCity Team</h3>
                            <div class="email_footer_div" style=" width:100%;
                            display: flex; ">
                                <div class="footer_left" style="width: 100px;
                            float: left;">
                                    <img style="width:70%;" src="'.asset("public/site/images/vcfaviconwap.png").'"" >
                                </div>
                                <div class="footer_right" style="margin:0;">
                                    <p>Questions? Email <a style="color: #555;" href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a></p>
                                    <p>VendorsCity Portal LLC</p>
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

        //echo $htmll;exit;
         $to = 'devang.hnrtechnologies@gmail.com';
        // $to = $request->email;
        Mail::send([], [], function($message) use($htmll, $to, $subject) {
            $message->to($to);
            $message->subject($subject);
            //$message->from('devang.hnrtechnologies@gmail.com', 'VendorsCity');
            $message->html($htmll);
        });

        
    }



    function book_user_otp_login(Request $request){

        // echo"<pre>";print_r($request->all());echo"</pre>";exit;

         $data['service_id'] = $service_id = $request->service_id;
        $redirectUrl = $request->redirectUrl;
        $data['subservice_id'] = $subservice_id = $request->subservice_id;
        $data['name'] = $request->book_email_name;
        $data['email'] = $request->book_email_email;
        $data['phone'] = $request->book_email_mobile;
        if($subservice_id != 47 || $subservice_id != 92){
        $data['area'] = $request->book_email_area;
        }else{
            $data['area'] = '';
        }
        $data['password'] = bcrypt(strval(time())); 
        

        $html = '<!doctype html> <html>
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
            <img src="'.asset("public/site/images/VC-FULL-COLOR.png").'"" style="width: 40%;"  >
            </div>
            <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                <p>Hello Admin ,</p>
                <p>A User has successfully logged into the website. Below are the details of the login:</p>
                 <p><strong>Here are the Login Details:</strong></p>
                <ul><li style= "list-style-type: disc;margin-bottom: -15px;">User Name: '.$data['name'].'.</li>
                <li style= "list-style-type: disc;margin-bottom: -15px;">User Mobile Number:'.$data['phone'] .'.</li>
                <li style= "list-style-type: disc";>User Email: '.$data['email'].' .</li>
                <li style= "list-style-type: disc";>For this service: '.\Helper::servicename($service_id).' .</li>
                <li style= "list-style-type: disc";>For this subservice: '.\Helper::subservicename($subservice_id).' </li></ul>  
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
        $subject = "Someone has visit on VendorsCity Here is the details";
        $to =['hello@vendorscity.com'];
        // $to =['devang.hnrtechnologies@gmail.com'];
        $ccRecipients = array();
        $bccRecipients = ['zafar@quickserverelo.com'];
        // $bccRecipients = ['adarsh.hnrtechnologies@gmail.com'];

        $ccRecipients = array();
        //$to = $request->email;
        Mail::send([], [], function($message) use($html, $to, $subject, $ccRecipients,$bccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->cc($ccRecipient);
            }
            foreach ($bccRecipients as $bccRecipient) {
                $message->bcc($bccRecipient);
            }
            $message->html($html);
        });

        // Check if the user exists based on the email
        $isUserExits = DB::table('frontloginregisters')->where('email', $data['email'])->first();

        // echo "<pre>";print_r($isUserExits);echo "</pre>";exit;
        if($isUserExits == ""){
            $paintingUsers           = new Frontloginregister;    
            $paintingUsers->name     = $data['name'];
            $paintingUsers->email    = $data['email'];
            $paintingUsers->password = $data['password'];
            $plainPassword           = strval(time());
            $paintingUsers->mobile   = $data['phone'];  
            if($subservice_id != 47){
                $paintingUsers->area   = $data['area'];
            }else{
                $paintingUsers->area  = '';
            }
            
            $paintingUsers->status   = 1;       
            $paintingUsers->save();

            $frontloginregister_id = $paintingUsers->id;
            $data_u['customer_id'] = $customer_id = "VC-".$frontloginregister_id."";
            DB::table('frontloginregisters')->where('id', $frontloginregister_id)->update($data_u);
            }else {
                // If user exists, update their information
                DB::table('frontloginregisters')
                    ->where('email', $data['email'])
                    ->update([
                        'name'     => $data['name'],
                        'password' => $data['password'],
                        'mobile'   => $data['phone'],
                        'area'     => ($subservice_id != 47) ? $data['area'] : '',
                    ]);
            }
            $currentDate = date("Y-m-d");

            $paintingUsers = array(
                "service_id" => $data['service_id'],
                "subservice_id" => $data['subservice_id'],
                "name" => $data['name'],
                // "country_code" => $data['country_code'],
                "email" => $data['email'],
                "mobile_number" => $data['phone'],
                "created_at" => $currentDate
            );
    
            $userOfPaintingId = DB::table("enquiry_users")->insertGetId($paintingUsers);
            $newPaintingUser = DB::table('frontloginregisters')->select('*')->where('email','=',$data['email'])->first();


            
            
            $newuserdata = array(
                'userid'  => $newPaintingUser->id,
                'refer_id'  => "",
                'name'  => $newPaintingUser->name,            
                'email'  => $newPaintingUser->email,       
                'mobile'  => $newPaintingUser->mobile,       
                'logged_in' => true
            );

           
            Session::put('user', $newuserdata);

            // echo "<pre>";print_r(Session::get('user'));echo "</pre>";exit;
        if (!empty($redirectUrl)) {
            return redirect()->to($redirectUrl)->with('L_strsucessMessage','You have successfully logged in.');
        }else{
            return redirect()->to('/')->with('L_strsucessMessage','Log in Successfully.');
        }
    }

    function booknow_user_otp_login(Request $request){

        
        $data['service_id'] = $service_id = $request->service_id;
        $redirectUrl = $request->redirectUrl;
        $data['subservice_id'] = $subservice_id = $request->subservice_id;
        $data['name'] = $request->book_name;
        $data['country_code'] = '+'.$request->country_code;
        $data['email'] = $request->book_email;
        $data['phone'] = $request->phone;
        if($subservice_id != 47 || $subservice_id != 92){
        $data['area'] = $request->area;
        }else{
            $data['area'] = '';
        }
        $data['password'] = bcrypt(strval(time())); 
        

        $html = '<!doctype html> <html>
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
            <img src="'.asset("public/site/images/VC-FULL-COLOR.png").'"" style="width: 40%;"  >
            </div>
            <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                <p>Hello Admin ,</p>
                <p>A User has successfully logged into the website. Below are the details of the login:</p>
                 <p><strong>Here are the Login Details:</strong></p>
                <ul><li style= "list-style-type: disc;margin-bottom: -15px;">User Name: '.$data['name'].'.</li>
                <li style= "list-style-type: disc;margin-bottom: -15px;">User Mobile Number:'.$data['phone'].'.</li>
                <li style= "list-style-type: disc";>User Email: '.$data['email'].' .</li>
                <li style= "list-style-type: disc";>For this service: '.\Helper::servicename($service_id).' .</li>
                <li style= "list-style-type: disc";>For this subservice: '.\Helper::subservicename($subservice_id).' </li></ul>  
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
        $subject = "Someone has visit on VendorsCity Here is the details";

        $to =['hello@vendorscity.com'];
        $ccRecipients = array();
        $bccRecipients = ['zafar@quickserverelo.com'];

        $ccRecipients = array();
        //$to = $request->email;
        Mail::send([], [], function($message) use($html, $to, $subject, $ccRecipients,$bccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->cc($ccRecipient);
            }
            foreach ($bccRecipients as $bccRecipient) {
                $message->bcc($bccRecipient);
            }
            $message->html($html);
        });

        // $to =['hello@vendorscity.com','zafar@quickserverelo.com'];
        // $ccRecipients = ['hello@vendorscity.com'];
        // $bccRecipients = ['zafar@quickserverelo.com'];

        // $ccRecipients = array();
        // $to = $request->email;
        // Mail::send([], [], function($message) use($html, $to, $subject, $ccRecipients,$bccRecipients) {
        //     $message->to($to);
        //     $message->subject($subject);
        //     $message->from('hello@vendorscity.com', 'VendorsCity');
        //     foreach ($ccRecipients as $ccRecipient) {
        //         $message->cc($ccRecipient);
        //     }
        //     $message->html($html);
        // });

        // Check if the user exists based on the email
        $isUserExits = DB::table('frontloginregisters')->where('email', $data['email'])->first();

        // echo "<pre>";print_r($isUserExits);echo "</pre>";exit;
        if($isUserExits == ""){
            $paintingUsers           = new Frontloginregister;    
            $paintingUsers->name     = $data['name'];
            $paintingUsers->email    = $data['email'];
            $paintingUsers->password = $data['password'];
            $plainPassword           = strval(time());
            $paintingUsers->mobile   = $data['phone'];  
            if($subservice_id != 47){
                $paintingUsers->area   = $data['area'];
            }else{
                $paintingUsers->area  = '';
            }
            
            $paintingUsers->status   = 1;       
            $paintingUsers->save();

            $frontloginregister_id = $paintingUsers->id;
            $data_u['customer_id'] = $customer_id = "VC-".$frontloginregister_id."";
            DB::table('frontloginregisters')->where('id', $frontloginregister_id)->update($data_u);
            }else {
                // If user exists, update their information
                DB::table('frontloginregisters')
                    ->where('email', $data['email'])
                    ->update([
                        'name'     => $data['name'],
                        'password' => $data['password'],
                        'mobile'   => $data['phone'],
                        'area'     => ($subservice_id != 47) ? $data['area'] : '',
                    ]);
            }
            $currentDate = date("Y-m-d");

            $paintingUsers = array(
                "service_id" => $data['service_id'],
                "subservice_id" => $data['subservice_id'],
                "name" => $data['name'],
                "country_code" => $data['country_code'],
                "email" => $data['email'],
                "mobile_number" => $data['phone'],
                "created_at" => $currentDate
            );
    
            $userOfPaintingId = DB::table("enquiry_users")->insertGetId($paintingUsers);
            $newPaintingUser = DB::table('frontloginregisters')->select('*')->where('email','=',$data['email'])->first();


            
            
            $newuserdata = array(
                'userid'  => $newPaintingUser->id,
                'refer_id'  => "",
                'name'  => $newPaintingUser->name,            
                'email'  => $newPaintingUser->email,       
                'mobile'  => $newPaintingUser->mobile,       
                'logged_in' => true
            );

           
            Session::put('user', $newuserdata);

            // echo "<pre>";print_r(Session::get('user'));echo "</pre>";exit;
        if (!empty($redirectUrl)) {
            return redirect()->to($redirectUrl)->with('L_strsucessMessage','You have successfully logged in.');
        }else{
            return redirect()->to('/')->with('L_strsucessMessage','Log in Successfully.');
        }
    }

    function booknow_otp_sent(){
        $country_code = $_POST['country_code'];
        $mobile = $_POST['mobile'];

        $phone = $_POST['country_code'].''.$_POST['mobile']; 
        $otp = rand(100000, 999999);     // e.g., "123456"

        

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
        CURLOPT_POSTFIELDS =>'{"messages":[{"to":"'.$phone.'","content":{"templateName":"login_otp_vc2","language":"en","templateData":{"body":{"placeholders":["'.$otp.'"]}}}}]}',
        CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'content-type: application/json',
            'Authorization: key_uTZeOXQPMd'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response, true);

      //echo"<pre>";print_r($response);echo"</pre>";exit;
        if (isset($response['statusCode']) && $response['statusCode'] == 400) {
            return response()->json([
                'success' => false,
                'message' => $response['message'][0] ?? 'An error occurred',
                'error' => $response // already an array
            ], 500);
        } else {
            if (isset($response['messages'][0]['status']) && $response['messages'][0]['status'] === 'SENT') {
        
                session(['book-login-otp' => $otp]);
        
                $user_data = DB::table('frontloginregisters')->where('mobile', $mobile)->first();
        
                return response()->json([
                    'success' => true,
                    'message' => 'OTP sent via WhatsApp',
                    'user_data' => $user_data
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send OTP',
                    'error' => $response // remove ->json()
                ], 500);
            }
    }

        

        // session(['book-login-otp' => $otp]);

        // $user_data = DB::table('frontloginregisters')->where('mobile',$mobile)->first();

        // return response()->json([
        //     'success' => true,
        //     'message' => 'OTP sent via WhatsApp',
        //     'user_data' => $user_data,
        //     'otp' => $otp
        // ]);

        // echo"<pre>";print_r($otp);echo"<pre>";exit;
        
    }

    public function book_email_otp_sent(Request $request){

        $email = $request->email_email; 
        $otp = rand(100000, 999999);     // e.g., "123456"

        session(['book-email-login-otp' => $otp]);

        // echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $html = '<!doctype html> <html>
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
            <img src="'.asset("public/site/images/VC-FULL-COLOR.png").'"" style="width: 40%;"  >
            </div>
            <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                <table width="100%" bgcolor="#f4f4f4" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center">
                        <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; padding:30px; font-family:Arial, sans-serif; margin:20px 0;">
                            
                            <tr>
                            <td style="font-size:16px; color:#666666; padding-bottom:20px;">
                                Hi,
                            </td>
                            </tr>
                            <tr>
                            <td style="font-size:16px; color:#666666; padding-bottom:20px;">
                                Your one time password (OTP) is
                            </td>
                            </tr>
                            <tr>
                            <td style="padding:20px 0;">
                                <div style="display:inline-block; background-color:#0040E6; color:#ffffff; font-size:28px; font-weight:bold; padding:14px 24px; border-radius:6px; letter-spacing:6px;">
                                '.$otp.'
                                </div>
                            </td>
                            </tr>
                            <tr>
                            <td style="font-size:14px; color:#999999;padding:20px 0 10px;">
                                Please note this is a temporary password and will expire in 5 minutes. If there\'s been a mistake, please contact our customer support team on +971 56 VENDORS (836 3677).
                            </td>
                            </tr>
                        </table>
                        </td>
                    </tr>
                    </table>  
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

        $subject = "$otp is the OTP for your VendorsCity account verification";
        

        $ccRecipients = array();
        $to = $request->email_email;
        //$to = 'devang.hnrtechnologies@gmail.com';

        $user_data = DB::table('frontloginregisters')->where('email', $to)->first();

        try {
            Mail::send([], [], function($message) use($html, $to, $subject, $ccRecipients) {
                $message->to($to);
                $message->subject($subject);
                foreach ($ccRecipients as $ccRecipient) {
                    $message->cc($ccRecipient);
                }
                $message->html($html);
            });
        
            return response()->json([
                'success' => true,
                'message' => 'OTP sent via email',
                'user_data' => $user_data,
                'otp' => $otp
            ]);
        
        } catch (\Exception $e) {
            // Optionally log the error for debugging
            Log::error('Mail sending failed: ' . $e->getMessage());
        
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP via email. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }

    }
    public function user_detail_login(Request $request)
    {
        //echo "<pre>";print_r($request->all());echo "</pre>";exit;
        $data['service_id'] = $service_id = $request->service_id;
        $redirectUrl = $request->redirectUrl;
        $data['subservice_id'] = $subservice_id = $request->subservice_id;
        $data['name'] = $request->name;
        $data['country_code'] = '+'.$request->country_code;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        if($subservice_id != 47){
        $data['area'] = $request->area;
        }else{
            $data['area'] = '';
        }
        $data['password'] = bcrypt(strval(time())); 
        

        $html = '<!doctype html> <html>
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
            <img src="'.asset("public/site/images/VC-FULL-COLOR.png").'"" style="width: 40%;"  >
            </div>
            <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                <p>Hello Admin ,</p>
                <p>A User has successfully logged into the website. Below are the details of the login:</p>
                 <p><strong>Here are the Login Details:</strong></p>
                <ul><li style= "list-style-type: disc;margin-bottom: -15px;">User Name: '.$data['name'].'.</li>
                <li style= "list-style-type: disc;margin-bottom: -15px;">User Mobile Number:'.$data['phone'].'.</li>
                <li style= "list-style-type: disc";>User Email: '.$data['email'].' .</li>
                <li style= "list-style-type: disc";>For this service: '.\Helper::servicename($service_id).' .</li>
                <li style= "list-style-type: disc";>For this subservice: '.\Helper::subservicename($subservice_id).' </li></ul>  
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
        $subject = "Someone has visit on VendorsCity Here is the details";
        

        $to =['hello@vendorscity.com'];
        $ccRecipients = array();
        $bccRecipients = ['zafar@quickserverelo.com'];

        $ccRecipients = array();
        //$to = $request->email;
        Mail::send([], [], function($message) use($html, $to, $subject, $ccRecipients,$bccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->cc($ccRecipient);
            }
            foreach ($bccRecipients as $bccRecipient) {
                $message->bcc($bccRecipient);
            }
            $message->html($html);
        });

        // $ccRecipients = array();
        // $to = $request->email;
        // Mail::send([], [], function($message) use($html, $to, $subject, $ccRecipients,$bccRecipients) {
        //     $message->to($to);
        //     $message->subject($subject);
        //     $message->from('hello@vendorscity.com', 'VendorsCity');
        //     foreach ($ccRecipients as $ccRecipient) {
        //         $message->cc($ccRecipient);
        //     }
        //     $message->html($html);
        // });

        // Check if the user exists based on the email
        $isUserExits = DB::table('frontloginregisters')->where('email', $data['email'])->first();

        // echo "<pre>";print_r($isUserExits);echo "</pre>";exit;
        if($isUserExits == ""){
            $paintingUsers           = new Frontloginregister;    
            $paintingUsers->name     = $data['name'];
            $paintingUsers->email    = $data['email'];
            $paintingUsers->password = $data['password'];
            $plainPassword           = strval(time());
            $paintingUsers->mobile   = $data['phone'];  
            if($subservice_id != 47){
                $paintingUsers->area   = $data['area'];
            }else{
                $paintingUsers->area  = '';
            }
            
            $paintingUsers->status   = 1;       
            $paintingUsers->save();

            $frontloginregister_id = $paintingUsers->id;
            $data_u['customer_id'] = $customer_id = "VC-".$frontloginregister_id."";
            DB::table('frontloginregisters')->where('id', $frontloginregister_id)->update($data_u);
            }else {
                // If user exists, update their information
                DB::table('frontloginregisters')
                    ->where('email', $data['email'])
                    ->update([
                        'name'     => $data['name'],
                        'password' => $data['password'],
                        'mobile'   => $data['phone'],
                        'area'     => ($subservice_id != 47) ? $data['area'] : '',
                    ]);
            }
            $currentDate = date("Y-m-d");

            $paintingUsers = array(
                "service_id" => $data['service_id'],
                "subservice_id" => $data['subservice_id'],
                "name" => $data['name'],
                "country_code" => $data['country_code'],
                "email" => $data['email'],
                "mobile_number" => $data['phone'],
                "created_at" => $currentDate
            );
    
            $userOfPaintingId = DB::table("enquiry_users")->insertGetId($paintingUsers);
            $newPaintingUser = DB::table('frontloginregisters')->select('*')->where('email','=',$data['email'])->first();


            
            
            $newuserdata = array(
                'userid'  => $newPaintingUser->id,
                'refer_id'  => "",
                'name'  => $newPaintingUser->name,            
                'email'  => $newPaintingUser->email,       
                'mobile'  => $newPaintingUser->mobile,       
                'logged_in' => true
            );

           
            Session::put('user', $newuserdata);

            // echo "<pre>";print_r(Session::get('user'));echo "</pre>";exit;
        if (!empty($redirectUrl)) {
            return redirect()->to($redirectUrl)->with('L_strsucessMessage','You have successfully logged in.');
        }else{
            return redirect()->to('/')->with('L_strsucessMessage','Log in Successfully.');
        }
    }


    public function facebook(Request $request)
    {   
       //echo "<pre>";print_r($_POST);echo "</pre>";exit;
      /*  $email = $request->email;
        $fname = $request->fname;
        $checklogin = DB::table('front_users')
                        ->where('email', $email)
                        ->first();
        if ($checklogin !='' && isset($checklogin)) {
          
          $newuserdata = array(
                'userid'  => $checklogin->id,
                'name'  => $checklogin->name,
                'phone'  => $checklogin->phone,
                'email'  => $checklogin->email,       
                'logged_in' => true
            );
            $check = Session::push('user', $newuserdata);
        } else {
            $data['email'] = $email;
            $namearray = explode(' ',$fname);
            $data['name']  = $namearray[0]; 
            $data['lname']  = $namearray[1]; 
            $data['fullname'] = $namearray[0].' '.$namearray[1];
            $data['registerfrom']  = '1'; 
            $content = [
                'name' => $data['fullname'],
                'email' => $data['email'],
                'password' => bcrypt(strval(time())), // Use bcrypt for password
                'added_date' => date('Y-m-d'), // Use Laravel's 'now()' to get the current date and time
            ];
            $insertedId = DB::table('front_users')->insertGetId($content);
            $checklogin = DB::table('front_users')
                        ->where('email', $email)
                        ->first();
            $newuserdata = array(
                'userid'  => $checklogin->id,
                'name'  => $checklogin->name,
                'phone'  => $checklogin->phone,
                'email'  => $checklogin->email,       
                'logged_in' => true
            );
            $check = Session::push('user', $newuserdata);
        }*/
        //echo "<pre>";print_r($request->post());echo "</pre>";exit;
    }
    
    
}