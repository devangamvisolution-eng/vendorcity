<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Email;

use App\Models\Admin\Service;
use App\Models\Admin\Subservice;
use App\Models\Admin\UserPermission;
use Illuminate\Support\Facades\Hash;
use App\Models\front\Frontloginregister;
use DB;
use Illuminate\Support\Facades\Response;
use Helper;
use Session;
use Illuminate\Support\Facades\Log;
use Str;
use Illuminate\Support\Facades\Http;

use App\Models\Admin\City;
use App\Models\Admin\Country;
use App\Models\Admin\State;

class Homecontroller extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */


    public function redirectToCity()
    {
        // Get geo data from session
        $slug = session('search_city_name');

        // If middleware already set city, redirect
        if (!empty($slug)) {
            return redirect()->to(url($slug));
        }

        // echo "here";exit;

        // Fallback (should not happen)
        return redirect()->to(url('dubai'));
    }



    public function index($city = null)
    {

        // $ip = "37.41.54.71";

        // $url = "https://api.ipgeolocation.io/ipgeo?apiKey=" . env('IPGEO_API_KEY') . "&ip={$ip}";

        // $response = Http::timeout(4)->get($url);

        // if ($response->successful()) {
        //     $data = $response->json();
        // }
        // echo "<pre>";
        // print_r($data);
        // exit;

        // session()->forget('search_country_name');
        // session()->forget('search_state_name');
        // session()->forget('search_city_name');
        // session()->forget('search_country_id');
        // session()->forget('search_state_id');
        // session()->forget('search_city_id');
        // session()->forget('user_geo_location');

        // echo"<pre>";print_r(session('user_geo_location')) ;exit;

        $CountryName = session('search_country_name');
        $StateName = session('search_state_name');
        $CityName = session('search_city_name');

        $CountryId = session('search_country_id');
        $StateId = session('search_state_id');
        $CityId = session('search_city_id');

        // echo"<pre>";print_r(session('search_city_name'));exit;

        $formattedCity = ucwords(str_replace('-', ' ', $CityName));

        $cityData = City::where('name', $formattedCity)->first();
        $cityDataId = $cityData?->id ?? null;

        $data['service'] = DB::table('services')->where('is_active', 0)->whereRaw("FIND_IN_SET(?, city)", [$cityDataId])->orderBy('set_order', 'ASC')->get();
        // $data['service']=DB::table('services')->orderBy('set_order')->get();
        $data['faq'] = DB::table('faqs')->orderBy('id', 'DESC')->get();
        $data['googleReview'] = DB::table('googlereviews')->orderBy('id', 'DESC')->get()->toArray();
        $data['sub_service'] = DB::table('subservices')->where('id', '!=', 102)->whereRaw("FIND_IN_SET(?, city)", [$cityDataId])->where('is_active', 0)->orderBy('set_order', 'ASC')->get();

        if ((session('search_country_name') == 'United Arab Emirates')) {
            $data['city'] = DB::table('cities')->where('country', session('search_country_id'))->orderBy('name', 'asc')->get();
        } else {
            $StateId = session('search_state_id');
            $data['city'] = DB::table('cities')
                ->where('country', session('search_country_id'))
                ->when(!empty($StateId), function ($query) use ($StateId) {
                    return $query->where('state', $StateId);
                })
                ->get();
        }

        // $data['city'] = DB::table('cities')->where('country',$CountryId)->get();


        $system_attributeMeta = DB::table('system_attribute')->where('city', $CityId)->where('system_id', 1)->first();


        // $data['meta_title'] = "VendorsCity – Trusted Home Services UAE | Get 5 Up to Free Quotes";
        // $data['meta_keyword'] = "home service dubai";
        // $data['meta_description'] = "Discover Top Home Services in the UAE with VendorsCity. Get Up to 5 free Quotes and Connect with Trusted Service Providers Effortlessly.";  

        $data['meta_title'] = $system_attributeMeta->meta_title ?? 'VendorsCity – Trusted Home Services UAE | Get 5 Up to Free Quotes';
        $data['meta_keyword'] = $system_attributeMeta->meta_keyword ?? 'home service dubai';
        $data['meta_description'] = $system_attributeMeta->meta_description ?? 'Discover Top Home Services in the UAE with VendorsCity. Get Up to 5 free Quotes and Connect with Trusted Service Providers Effortlessly.';

        $data['formattedCity'] = $formattedCity;

        // echo "<pre>";print_r($data);echo "</pre>";exit;
        return view('front.index', $data);
    }
    public function privacy_policy()
    {

        $data['cms_data'] = DB::table('cms')->where('id', 2)->first();

        $data['meta_title'] = $data['cms_data']->meta_title ?? "";
        $data['meta_keyword'] = $data['cms_data']->meta_keyword ?? "";
        $data['meta_description'] = $data['cms_data']->meta_description ?? "";

        // echo "<pre>";print_r($data);echo "</pre>";exit;
        return view('front.privacy_policy', $data);
    }
    public function term_condition()
    {

        $data['cms_data'] = DB::table('cms')->where('id', 1)->first();

        // $data['meta_title'] = "";
        // $data['meta_keyword'] = "";
        // $data['meta_description'] = "";    

        // echo "<pre>";print_r($data);echo "</pre>";exit;
        return view('front.privacy_policy', $data);
    }
    public function payment_refund_policy()
    {

        $data['cms_data'] = DB::table('cms')->where('id', 3)->first();

        // $data['meta_title'] = "";
        // $data['meta_keyword'] = "";
        // $data['meta_description'] = "";    

        // echo "<pre>";print_r($data);echo "</pre>";exit;
        return view('front.privacy_policy', $data);
    }
    public function contact()
    {
        $data['meta_title'] = "Contact VendorsCity UAE | Customer Support Help";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "Reach out to VendorsCity for inquiries, support, or partnerships. Our UAE team is ready to assist with all service questions.";

        return view('front.contact', $data);
    }
    public function careers()
    {

        $data['meta_title'] = "Careers at VendorsCity | Join Our Growing Team";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "Explore job opportunities at VendorsCity. Work with a leading UAE platform in home services and vendor management.";

        return view('front.careers', $data);
    }
    public function about_us()
    {

        $data['meta_title'] = "About VendorsCity | UAE’s Trusted Service Platform";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "Learn how VendorsCity connects users with top-rated service vendors in UAE. Explore our mission, values, and service reach.";

        return view('front.about_us', $data);
    }

    public function blog()
    {

        $query = DB::table('blogs')->orderBy('id', 'DESC');
        // echo "<pre>";print_r($data);echo "</pre>";exit;


        $pagination = $query->paginate(10)->withQueryString();

        $data['blog'] = $pagination;


        $data['recent_blog'] = DB::table('blogs')->orderBy('id', 'DESC')->limit(3)->get()->toArray();
        //echo "<pre>";print_r($data);echo "</pre>";exit;

        $data['meta_title'] = "Expert Tips & Trends | VendorsCity Blog UAE";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "Explore expert tips on home services, grooming, and relocation in UAE. Stay updated with the latest trends and ideas from VendorsCity Blog.";

        return view('front.blog_list', $data);
    }
    public function blog_detail($blog_url)
    {

        // echo $blog_page_url;exit;
        $data['blog_detail'] = DB::table('blogs')->where('blog_url', $blog_url)->first();



        $data['meta_title'] = $data['blog_detail']->metatitle ?? '';
        $data['meta_keyword'] = "";
        $data['meta_description'] = $data['blog_detail']->metadescription ?? '';
        return view('front.blog_detail', $data);
    }



    public function book_services()
    {




        $data['service_data'] = DB::table('services')
            ->where('is_active', 0)
            ->orderBy('set_order')
            ->get();

        $data['service_count'] = $data['service_data']->count();

        $data['meta_title'] = "Explore Services – Clean, Move, Relax | VendorCity";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "Discover top home services in Dubai – cleaning, moving, spa & more. Get quotes & book today!";


        return view('front.book_services', $data);
    }

    public function subservices($city = '', $service_url = '')
    {

        //echo $service_url;exit;

        $formattedCity = ucwords(str_replace('-', ' ', $city));

        $city = DB::table('cities')->where('name', $formattedCity)->first();
        $cityId = $city->id ?? null;

        //$cityId = session('search_city_id');

        // echo "here";exit;
        $data['service_data'] = Service::where('page_url', $service_url)->first();
        $data['subservice_data'] = Subservice::where('serviceid', $data['service_data']->id)->where('id', '!=', 102)->whereRaw("FIND_IN_SET(?, city)", [$cityId])->where('is_active', 0)->orderBy('set_order')->get();

        $data['subservice_count'] = $data['subservice_data']->count();
        $data['googleReview'] = DB::table('googlereviews')->orderBy('id', 'DESC')->get()->toArray();

        $data['service_banner_attr'] = DB::table('service_banner_attr')->where('city', $cityId)->where('service_id', $data['service_data']->id)->first();



        $data['package_attr'] = DB::table('service_attr')->where('pid', $data['service_data']->id)->where('city', $cityId)->get();

        $data['top_description'] = DB::table('service_top_description_attr')
            ->where('service_id', $data['service_data']->id)
            ->where('city', $cityId)
            ->first();

        $data['faq'] = DB::table('faqs')
            ->whereRaw("FIND_IN_SET(?, services)", [$data['service_data']->id])
            ->get();


        $serviceMetaContent = DB::table('service_contains')->where('city', $cityId)->where('service_id', $data['service_data']->id)->first();

        $data['meta_title'] = $serviceMetaContent->meta_title ?? $data['service_data']->meta_title ?? '';
        $data['meta_keyword'] = $serviceMetaContent->meta_keyword ?? $data['service_data']->meta_keyword ?? '';
        $data['meta_description'] = $serviceMetaContent->meta_description ?? $data['service_data']->meta_description ?? '';



        $data['formattedCity'] = $formattedCity;

        //echo "<pre>";print_r($data);echo "</pre>";exit;

        return view('front.book_subservices', $data);
    }

    public function become_vendor()
    {

        $data['permission_data'] = UserPermission::orderBy('id', 'DESC')->get();
        $data['city_data'] = City::where('country', 22)->get();

        $data['meta_title'] = "Become a Vendor | Join VendorsCity Network";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "List your service business on VendorsCity. Get access to leads, grow your reach, and serve customers across the UAE.";

        // echo "<pre>";print_r($data);echo "</pre>";exit;
        return view('front.become_vendor', $data);
    }

    public function getSubservices(Request $request)
    {
        $serviceIds = $request->service_ids;

        $subservices = DB::table('subservices')
            ->whereIn('serviceid', $serviceIds)
            ->where('id', '!=', 102)
            ->where('is_active', 0)
            ->select('id', 'subservicename', 'serviceid')
            ->get();

        return response()->json($subservices);
    }

    public function vendors_data(Request $request)
    {

        //echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $validatedData = $request->validate([
            'vendor_captcha' => 'required',
        ]);

        if ($request->vendor_captcha != Session::get('vendor_captcha')) {
            return redirect()->back()->withErrors(['vendor_captcha' => 'Invalid captcha code!']);
        }

        // echo"<pre>";
        // print_r($request->post());
        // echo"</pre>";exit;

        //$data['role_id']=$_POST['hidden_role_id'];
        $data['name'] = $_POST['name'];
        $data['user_name'] = $_POST['user_name'];
        $data['short_description'] = $_POST['short_description'];
        $data['companywebsite'] = $_POST['companywebsite'];
        // $data['city']= $_POST['city'];
        $data['city'] = implode(',', $_POST['city']);

        // $data['crole']=$_POST['crole'];
        // $data['parentcname']=$_POST['parentcname'];
        // $data['establishment_date']=$_POST['establishment_date'];
        // $data['tlexpiry']=$_POST['tlexpiry'];
        $data['staff'] = $_POST['staff'];
        // $data['remarks']=$_POST['remarks'];
        // $data['socialmedai']=$_POST['socialmedai'];
        $data['password'] = Hash::make($_POST['password']);
        $data['email'] = $_POST['email'];
        if ($_POST['mobile'] != '') {
            $data['mobile'] = $_POST['mobile'];
        } else {
            $data['mobile'] = null;
        }

        $data['country_code'] = $_POST['country_code_vendor'];

        if (request()->has('serviceList') && !empty(request()->input('serviceList'))) {
            $serviceList = request()->input('serviceList');

            if (is_array($serviceList)) {
                $data['serviceList'] = implode(',', $serviceList);
            } else {
                $data['serviceList'] = '';
            }
            $roleIds = [];
            foreach ($serviceList as $key => $value) {
                if ($value == '45') {
                    $roleIds[] = 18;
                }
                if ($value == '30') {
                    $roleIds[] = 19;
                }
                if ($value == '44') {
                    $roleIds[] = 19;
                }
                if ($value == '34') {
                    $roleIds[] = 20;
                }
                if ($value == '47') {
                    $roleIds[] = 21;
                }
                if ($value == '48') {
                    $roleIds[] = 17;
                }
            }

            $commaSeparatedRoles = implode(',', $roleIds);

            $data['role_id'] = $commaSeparatedRoles;
        }

        if (request()->has('subserviceList') && !empty(request()->input('subserviceList'))) {
            $subserviceList = request()->input('subserviceList');

            if (is_array($subserviceList)) {
                $data['subserviceList'] = implode(',', $subserviceList);
            } else {
                $data['subserviceList'] = '';
            }
        }



        $data['vendor'] = 1;
        $data['is_active'] = 1;

        //     if ($request->hasFile('vatcertificate')) 
        // {

        //     $file = $request->file('vatcertificate');

        //     $path = public_path('upload/vendors/');

        //     $fileName = uniqid().'.'.$file->getClientOriginalExtension();

        //     $file->move($path, $fileName);


        //     $data['vatcertificate']= $fileName;

        // }
        // if ($request->hasFile('trncertificate')) 
        // {

        //     $file = $request->file('trncertificate');

        //     $path = public_path('upload/vendors/');

        //     $fileName = uniqid().'.'.$file->getClientOriginalExtension();

        //     $file->move($path, $fileName);


        //     $data['trncertificate']= $fileName;


        // }
        // if ($request->hasFile('tradelicense')) 
        // {

        //     $file = $request->file('tradelicense');

        //     $path = public_path('upload/vendors/');

        //     $fileName = uniqid().'.'.$file->getClientOriginalExtension();

        //     $file->move($path, $fileName);


        //     $data['tradelicense']= $fileName;

        // }


        // echo"<pre>";
        // print_r($data);
        // echo"</pre>";exit;

        $vendors_id = DB::table('users')->insertGetId($data);
        $year = date('y');
        $data_u['vendor_id'] = "VID" . $year . sprintf("%06d", $vendors_id);

        DB::table('users')->where('id', $vendors_id)->update($data_u);


        if (count($_POST['poc']) > 0 && $_POST['poc'] != '') {

            for ($i = 0; $i < count($_POST['poc']); $i++) {

                if ($_POST['poc'][$i] != '') {

                    $content['p_id'] = $vendors_id;

                    $content['poc'] = $_POST['poc'][$i];

                    $content['poctitle'] = $_POST['poctitle'][$i];

                    $content['c_email'] = $_POST['c_email'][$i];

                    $content['telephone'] = $_POST['telephone'][$i];
                    $content['country_code'] = $_POST['country_code'][$i];

                    $this->insert_attribute($content);
                }
            }
        }

        // Mail Start 
        if (isset($data["vatcertificate"])) {
            $base_url_vat = url('public/upload/vendors/' . $data["vatcertificate"]);
        }
        if (isset($data["trncertificate"])) {
            $base_url_vat = url('public/upload/vendors/' . $data["trncertificate"]);
        }
        if (isset($data["tradelicense"])) {
            $base_url_vat = url('public/upload/vendors/' . $data["tradelicense"]);
        }




        // $file = public_path("upload/vendors/{$data['vatcertificate']}");


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
                        <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;"  >
                        </div>
                        <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                           <p>A new vendor has registered on VendorsCity and requires your attention. Please log in to the admin portal to review and take action on the registration.</p>
                         <p><a class="btnlink" href="' . url("admin/vendors") . '" style="background: #0040E6;color: #fff !important;text-decoration: none;width: 100%;display: block;
                         padding: 9px 0;text-align: center;font-size: 16px;
                            border-radius: 9px">View Application</a></p>

                         <p><strong>Vendor Details:</strong></p>
                        <ul><li style= "list-style-type:disc;margin-bottom:-15px;">Name : ' . $data['name'] . '</li>                       
                        <li style= "list-style-type: disc;margin-bottom:-15px;"> Vendor Email : ' . $data['email'] . '</li>
                        <li style= "list-style-type: disc";>Phone:' . $data['mobile'] . '</li>
                        
                        <li style= "list-style-type: disc";>Services Offered: ';
        $services = explode(',', $data['serviceList']);

        foreach ($services as $service) {
            $htmll .= Helper::servicename($service) . ',';
        }
        $htmll .= '</li>
                        
                     </ul>    
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
                                    <p style="margin:0;">VendorsCity Portal LLC</p>
                                    <div class="footer_links" style=" margin:10px 0;">
                                <a href="' . url("/terms-of-service") . '" style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                <a href="' . url("/privacy-policy") . '" style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                <a href="' . url("/contact") . '" style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                                </div>
                                    <p style="margin:0;">This message was mailed to ' . $_POST['email'] . ' as part of you account registered with us on VendorsCity</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </body>
            </html>';

        // echo $htmll;exit;

        $subject = "New Vendor Registration: Admin Action Required";
        // $admin = "devang.hnrtechnologies@gmail.com";

        $admin = "vendors@vendorscity.com";
        //  $admin = "abhishek.hnrtechnologies@gmail.com";

        // echo $html;exit;
        // $to =$data['email'];
        // $to = $request->email;
        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        Mail::send([], [], function ($message) use ($htmll, $admin, $subject, $ccRecipients) {
            $message->to($admin);
            $message->subject($subject);
            $message->from('devang.hnrtechnologies@gmail.com', 'VendorsCity');
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($htmll);
        });

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
                    <div class="wrapper" style="width: 100%;max-width:500px;
                            margin:auto;font-size:14px;line-height:24px;
                            font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
                        <div class="logo" style="float: inherit;border-bottom: 4px solid #FFD413;">
                        <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;" >
                        </div>
                        <div class="email_wrapper"  style="width:100%;margin-top: 18px;font-size: 16px;">
                            <p>Dear ' . $data['name'] . ',</p>
                            <p>Thank you for registering with VendorsCity! We are excited to have you join our network of trusted service providers.</p>
                            <p>Your application is currently under review and will be processed within the next 2 business days. You will receive a confirmation email once your account has been approved and activated.</p>
                            <p>If you do not hear from us within this timeframe or if you have any questions, please feel free to contact us at <a href="mailto:support@vendorscity.com">support@vendorscity.com</a>. We are here to assist you with any inquiries or concerns you may have.</p>
                            <p>We look forward to a successful partnership!</p>
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
        $subject = "Welcome to VendorsCity! Your Registration is Under Review";
        $to = $_POST['email'];
        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        // $ccRecipients = array();
        // $to = $request->email;
        Mail::send([], [], function ($message) use ($htmll, $to, $subject, $ccRecipients) {
            $message->to($to);
            $message->subject($subject);
            $message->from('devang.hnrtechnologies@gmail.com', 'VendorsCity');
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($htmll);
        });





        // End Mail






        return redirect()->to('vendor-registration-succesful')->with('L_strsucessMessage', 'Your Vendor Application has been Received!');
    }

    public function become_vendors()
    {
        return view('front.Wel_become_vendors');
    }

    public function downloads($filename)
    {
        // Build the full path to the file
        $file = public_path("upload/vendors/{$filename}");

        // Check if the file exists
        if (!file_exists($file)) {
            return abort(404);
        }

        // Generate a response to download the file
        return response()->download($file);
    }
    function insert_attribute($content)
    {

        $data['pid'] = $content['p_id'];
        $data['poc'] = $content['poc'];
        $data['poctitle'] = $content['poctitle'];
        $data['c_email'] = $content['c_email'];
        $data['telephone'] = preg_replace('/\D+/', '', trim($content["telephone"]));
        $data['country_code'] = $content['country_code'];
        DB::table('vendors_attribute')->insertGetId($data);
    }

    function vendors_check_mail()
    {

        // echo "test";exit;

        $email = $_POST['email'];

        $result = DB::table('users')
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
    public function contact_us_data(Request $request)
    {
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $validatedData = $request->validate([
            'fname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'lname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => 'required|email|max:255',
            'mobile' => 'required|numeric',
            'captcha' => 'required',
        ]);

        $data['fname'] = $_POST['fname'];
        $data['lname'] = $_POST['lname'];
        $data['email'] = $_POST['email'];
        $data['mobile'] = $_POST['mobile'];
        $data['message'] = $_POST['message'];

        //    echo"<pre>";print_r($data);echo"</pre>";exit;

        DB::table('contact_us')->insert($data);

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
                    <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;" >
                    </div>
                    <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;" >
                    <h2 style="font-size: 26px;font-weight: bolder;margin: 0;">Contact Us</h2>
                        <p>Dear ' . $data['fname'] . ',</p>                 
                        <p>We love hearing from you! Whether you have a question, feedback, or need assistance, our team is here to help. Visit our <a href="' . url("/contact") . '">Contact Us</a> page for more information.</p>
                        <p>Join the VendorsCity community today and experience the ultimate convenience in home services!</p>
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
        $subject = "Contact Us";

        //   echo $html;exit;     
        $to = $data['email'];
        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        Mail::send([], [], function ($message) use ($html, $to, $subject, $ccRecipients) {
            $message->to($to, 'VendorsCity');
            $message->subject($subject);
            $message->from('devang.hnrtechnologies@gmail.com', 'VendorsCity');
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($html);
        });

        $htmll = '<!doctype html> <html>        
        <head>
            <meta charset="utf-8">
            <title>Contact Us Email</title>
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
                    float: left;
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
                <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '" style="max-width: 150px;" >
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
                                        Please find the below Contact Us Details
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
                                            <table width="100%" border="0" cellspacing="0" cellpadding="5"> ';
        if (isset($data['fname']) && $data['fname'] > 0 && $data['fname'] != "") {

            $htmll .= ' <tr><td>First Name: </td><td>' . $data['fname'] . '</td></tr>';
        }
        if (isset($data["lname"]) && $data["lname"] > 0 && $data["lname"] != "") {

            $htmll .= ' <tr><td>Last Name: </td><td>' . $data['lname'] . '</td></tr>';
        }
        if (isset($data["email"]) && $data["email"] > 0 && $data["email"] != "") {

            $htmll .= ' <tr><td>Email: </td><td>' . $data['email'] . '</td></tr>';
        }
        if (isset($data["mobile"]) && $data["mobile"] > 0 && $data["mobile"] != "") {

            $htmll .= '<tr><td>Mobile: </td><td>' . $data['mobile'] . '</td></tr>';
        }
        if (isset($data["message"]) && $data["message"] > 0 && $data["message"] != "") {

            $htmll .= '<tr><td>Message: </td><td>' . $data['message'] . '</td></tr>';
        }

        $htmll .= '                                                       
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

        $subject = "Contact Us - VendorsCity";
        $admin = "devang.hnrtechnologies@gmail.com";

        // echo $html;exit;
        // $to =$data['email'];
        // $to = $request->email;
        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        Mail::send([], [], function ($message) use ($htmll, $admin, $subject, $ccRecipients) {
            $message->to($admin);
            $message->subject($subject);
            $message->from('devang.hnrtechnologies@gmail.com', 'VendorsCity');
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($htmll);
        });


        return redirect()->to('contact')->with('L_strsucessMessage', 'Contact Us Added Successfully.');
    }


    public function otp_sent()
    {

        $country_code = $_POST['country_code'];
        $mobile = $_POST['mobile'];

        Session::put('country_code', $country_code);

        $phone = $_POST['country_code'] . '' . $_POST['mobile'];
        $otp = rand(100000, 999999);     // e.g., "123456"



        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => '{"messages":[{"to":"' . $phone . '","content":{"templateName":"login_otp_vc2","language":"en","templateData":{"body":{"placeholders":["' . $otp . '"]}}}}]}',
        //     CURLOPT_HTTPHEADER => array(
        //         'accept: application/json',
        //         'content-type: application/json',
        //         'Authorization: key_uTZeOXQPMd'
        //     ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
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
              "' . $otp . '"
            ]
          }
        },
        "templateName": "login_otp_vc2"
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

        $response = json_decode($response, true);
        //echo"<pre>";print_r($response);echo"</pre>";exit;
        if (isset($response['statusCode']) && $response['statusCode'] == 400) {
            return response()->json([
                'success' => false,
                'message' => $response['message'][0] ?? 'An error occurred',
                'error' => $response // already an array
            ], 500);
        } else {
            if (isset($response['messages'][0]['status']) && in_array($response['messages'][0]['status'], ['SENT', 'DELIVERED', 'ENQUEUED'])) {

                session(['login-otp' => $otp]);

                $user_data = DB::table('frontloginregisters')->where('mobile', $mobile)->first();

                $data['country_code'] = $country_code;
                $data['mobile'] = $mobile;

                //DB::table('frontloginregisters')->where('mobile', $mobile)->update($data);

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



        // session(['login-otp' => $otp]);

        // $user_data = DB::table('frontloginregisters')->where('mobile',$mobile)->first();

        // return response()->json([
        //     'success' => true,
        //     'message' => 'OTP sent via WhatsApp',
        //     'user_data' => $user_data,
        //     'otp' => $otp
        // ]);




    }

    public function email_otp_sent(Request $request)
    {

        $email = $request->email_email;
        $otp = rand(100000, 999999);     // e.g., "123456"

        session(['email-login-otp' => $otp]);

        //echo"<pre>";print_r($request->all());echo"</pre>";exit;

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
            <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;"  >
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
                                ' . $otp . '
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
                            <img style="width:70%;" src="' . asset("public/site/images/vcfaviconwap.png") . '"" >
                        </div>
                        <div class="footer_right" style="margin-left:10px;
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
    </html>';

        $subject = "$otp is the OTP for your VendorsCity account verification";


        $ccRecipients = array();
        $to = $request->email_email;
        //$to = 'devang.hnrtechnologies@gmail.com';

        $user_data = DB::table('frontloginregisters')->where('email', $to)->first();

        try {
            Mail::send([], [], function ($message) use ($html, $to, $subject, $ccRecipients) {
                $message->to($to);
                $message->subject($subject);
                foreach ($ccRecipients as $ccRecipient) {
                    $message->bcc($ccRecipient);
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

    public function user_otp_login(Request $request)
    {
        //echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $data['name'] = $request->name;
        $data['country_code'] = '+' . $request->country_code;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['country_code'] = $request->country_code_otp_popup_Modal;
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
            <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;"  >
            </div>
            <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                <p>Hello Admin ,</p>
                <p>A User has successfully logged into the website. Below are the details of the login:</p>
                 <p><strong>Here are the Login Details:</strong></p>
                <ul><li style= "list-style-type: disc;margin-bottom: -15px;">User Name: ' . $request->name . '.</li>
                <li style= "list-style-type: disc;margin-bottom: -15px;">User Mobile Number:' . $request->phone . '.</li>
                <li style= "list-style-type: disc";>User Email: ' . $request->email . ' .</li>
               
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
                        <a href="' . url("/terms-of-service") . '" style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                        <a href="' . url("/privacy-policy") . '" style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                        <a href="' . url("/contact") . '" style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>';
        $subject = "Someone has visit on VendorsCity Here is the details";
        $to = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        $ccRecipients = ['hello@vendorscity.com'];
        $bccRecipients = ['zafar@quickserverelo.com'];

        // $ccRecipients = array();
        // $to = $request->email;
        // Mail::send([], [], function($message) use($html, $to, $subject, $ccRecipients,$bccRecipients) {
        //     $message->to($to);
        //     $message->subject($subject);
        //     $message->from('hello@vendorscity.com', 'VendorsCity');
        //     foreach ($ccRecipients as $ccRecipient) {
        //         $message->bcc($ccRecipient);
        //     }
        //     $message->html($html);
        // });

        // Check if the user exists based on the email
        $isUserExits = DB::table('frontloginregisters')->where('mobile', $data['phone'])->first();

        if ($isUserExits == "") {
            $paintingUsers = new Frontloginregister;
            $paintingUsers->name = $data['name'];
            $paintingUsers->email = $data['email'];
            $paintingUsers->password = $data['password'];
            $plainPassword = strval(time());
            $paintingUsers->mobile = $data['phone'];
            $paintingUsers->country_code = $data['country_code'];
            $paintingUsers->status = 1;
            $paintingUsers->save();

            $frontloginregister_id = $paintingUsers->id;
            $data_u['customer_id'] = $customer_id = "VC-" . $frontloginregister_id . "";
            DB::table('frontloginregisters')->where('id', $frontloginregister_id)->update($data_u);
        } else {
            // If user exists, update their information
            DB::table('frontloginregisters')
                ->where('mobile', $data['phone'])
                ->update([
                    'name' => $data['name'],
                    'password' => $data['password'],
                    'country_code' => $data['country_code'],
                    // 'mobile'   => $data['phone'],
                    // 'area'     => ($subservice_id != 47) ? $data['area'] : '',
                ]);
        }
        $currentDate = date("Y-m-d");

        $newPaintingUser = DB::table('frontloginregisters')->select('*')->where('mobile', '=', $data['phone'])->first();


        $newuserdata = array(
            'userid' => $newPaintingUser->id,
            'refer_id' => "",
            'name' => $newPaintingUser->name,
            'email' => $newPaintingUser->email,
            'mobile' => $newPaintingUser->mobile,
            'logged_in' => true
        );


        Session::put('user', $newuserdata);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully logged in.',
                'user' => $newuserdata
            ]);
        }

        return back()->with('L_strsucessMessage', 'You have successfully logged in.');
    }

    public function user_email_otp_login(Request $request)
    {
        //echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $data['name'] = $request->email_name;
        //$data['country_code'] = '+'.$request->country_code;
        $data['email'] = $request->email_email;
        $data['phone'] = $request->email_mobile;
        $data['country_code'] = $request->country_code_email_popup_Modal;
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
            <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;"  >
            </div>
            <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                <p>Hello Admin ,</p>
                <p>A User has successfully logged into the website. Below are the details of the login:</p>
                 <p><strong>Here are the Login Details:</strong></p>
                <ul><li style= "list-style-type: disc;margin-bottom: -15px;">User Name: ' . $request->email_name . '.</li>
                <li style= "list-style-type: disc;margin-bottom: -15px;">User Mobile Number:' . $request->email_mobile . '.</li>
                <li style= "list-style-type: disc";>User Email: ' . $request->email_email . ' .</li>
               
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
                        <a href="' . url("/terms-of-service") . '" style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                        <a href="' . url("/privacy-policy") . '" style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                        <a href="' . url("/contact") . '" style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>';
        $subject = "Someone has visit on VendorsCity Here is the details";
        $to = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        $ccRecipients = ['hello@vendorscity.com'];
        $bccRecipients = ['zafar@quickserverelo.com'];

        // $ccRecipients = array();
        // $to = $request->email;
        // Mail::send([], [], function($message) use($html, $to, $subject, $ccRecipients,$bccRecipients) {
        //     $message->to($to);
        //     $message->subject($subject);
        //     $message->from('hello@vendorscity.com', 'VendorsCity');
        //     foreach ($ccRecipients as $ccRecipient) {
        //         $message->bcc($ccRecipient);
        //     }
        //     $message->html($html);
        // });

        // Check if the user exists based on the email
        $isUserExits = DB::table('frontloginregisters')->where('email', $data['email'])->first();

        if ($isUserExits == "") {
            $paintingUsers = new Frontloginregister;
            $paintingUsers->name = $data['name'];
            $paintingUsers->email = $data['email'];
            $paintingUsers->password = $data['password'];
            $plainPassword = strval(time());
            $paintingUsers->mobile = $data['phone'];
            $paintingUsers->country_code = $data['country_code'];
            $paintingUsers->status = 1;
            $paintingUsers->save();

            $frontloginregister_id = $paintingUsers->id;
            $data_u['customer_id'] = $customer_id = "VC-" . $frontloginregister_id . "";
            DB::table('frontloginregisters')->where('id', $frontloginregister_id)->update($data_u);
        } else {
            // If user exists, update their information
            DB::table('frontloginregisters')
                ->where('mobile', $data['phone'])
                ->update([
                    'name' => $data['name'],
                    'password' => $data['password'],
                    'country_code' => $data['country_code'],
                    // 'mobile'   => $data['phone'],
                    // 'area'     => ($subservice_id != 47) ? $data['area'] : '',
                ]);
        }
        $currentDate = date("Y-m-d");

        $newPaintingUser = DB::table('frontloginregisters')->select('*')->where('email', '=', $data['email'])->first();


        $newuserdata = array(
            'userid' => $newPaintingUser->id,
            'refer_id' => "",
            'name' => $newPaintingUser->name,
            'email' => $newPaintingUser->email,
            'mobile' => $newPaintingUser->mobile,
            'logged_in' => true
        );


        Session::put('user', $newuserdata);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully logged in.',
                'user' => $newuserdata
            ]);
        }

        return back()->with('L_strsucessMessage', 'You have successfully logged in.');
    }

    function testwhatsapptemplate()
    {

        $ip = request()->ip();

        // Localhost fallback
        if ($ip == "127.0.0.1" || $ip == "::1") {
            // 🔥 CHANGE HERE during testing
            //$ip = "103.238.107.103";   // Dubai
            //$ip = "162.120.187.97";   // Dubai 2
            $ip = "103.21.59.0";      // CURRENT: Mumbai
        }

        /**
         * Call IP Geolocation API
         */
        $url = "https://api.ipgeolocation.io/ipgeo?apiKey=" . env('IPGEO_API_KEY') . "&ip={$ip}";

        $response = Http::timeout(4)->get($url);

        if ($response->successful()) {
            $data = $response->json();

            // Some APIs return "Unknown"
            if (!empty($data['city']) && $data['city'] !== "Unknown") {

                // Save for future (DO NOT SAVE MULTIPLE TIMES)
                session(['user_geo_location' => $data]);

                // Log success
                \Log::info("Geo Success: IP {$ip} → " . $data['city']);

                return $data;
            }
        }

        echo "<pre>";
        print_r($response);
        exit;
    }

    function testmail()
    {
        // echo "sd";exit;
        $userdata = Session::get('user');
        $order_number = 386;
        $format_order_id = 'VC-25-UAE-000386';

        // ===================== FETCH ORDER =====================
        $orders = DB::table('ci_orders as o')
            ->select('o.*')
            ->where('o.order_id', $order_number)
            ->where('o.payment_status', 'Success')
            ->orderByDesc('o.order_id')
            ->get()
            ->map(function ($order) {
                $order->items = DB::table('ci_order_item as i')
                    ->where('i.order_id', $order->order_id)
                    ->select('i.*')
                    ->get()
                    ->map(function ($item) {
                        $item->packages = DB::table('ci_order_item_packages as p')
                            ->where('p.order_item_id', $item->id)
                            ->select('p.*')
                            ->get();
                        return $item;
                    });

                return $order;
            });

        if ($orders->isEmpty()) {
            return "No successful order found.";
        }

        // echo "<pre>";print_r($orders);echo "</pre>";exit;

        // ===================== EXTRACT SERVICE / SUBSERVICE / CITY =====================
        $serviceIds = [];
        $subserviceIds = [];
        $orderCities = [];

        foreach ($orders as $order) {
            foreach ($order->items as $item) {

                if (!empty($item->service_id)) {
                    $serviceIds[] = $item->service_id;
                }
                if (!empty($item->subservice_id)) {
                    $subserviceIds[] = $item->subservice_id;
                }
                if (!empty($item->city)) {      // here item->city = name e.g. Dubai
                    $orderCities[] = trim($item->city);
                }
            }
        }


        $serviceIds = array_unique($serviceIds);
        $subserviceIds = array_unique($subserviceIds);
        $orderCities = array_unique($orderCities);

        // echo "<pre>";print_r($serviceIds);echo "</pre>";
        // echo "<pre>";print_r($subserviceIds);echo "</pre>";
        // echo "<pre>";print_r($orderCities);echo "</pre>";

        if (empty($serviceIds) && empty($subserviceIds)) {
            return "No service/subservice IDs found.";
        }

        // ===================== FETCH ALL CITY MASTER FOR ONE-TIME USE =====================
        $cityMaster = DB::table('cities')->pluck('name', 'id')->toArray();

        //echo "<pre>";print_r($cityMaster);echo "</pre>";exit;
        // Example: [27 => "Dubai", 29 => "Abu Dhabi"]

        // ===================== FILTER VENDORS =====================
        $vendors = DB::table('users')
            ->where('vendor', 1)
            ->where('is_active', 0)
            ->get()
            ->filter(function ($vendor) use ($serviceIds, $subserviceIds, $orderCities, $cityMaster) {

                // Vendor must have service + subservice + cityList
                if (empty($vendor->serviceList) || empty($vendor->subserviceList) || empty($vendor->city)) {
                    return false;
                }

                // -------- SERVICE & SUBSERVICE CHECK --------
                $vendorServices = explode(',', $vendor->serviceList);
                $vendorSubservices = explode(',', $vendor->subserviceList);

                $hasServiceMatch = count(array_intersect($serviceIds, $vendorServices)) > 0;
                $hasSubserviceMatch = count(array_intersect($subserviceIds, $vendorSubservices)) > 0;


                // -------- CITY CHECK --------
                $vendorCityIDs = explode(',', $vendor->city); // e.g. 27,29

                // Convert Vendor City IDs → Names
                $vendorCityNames = [];
                foreach ($vendorCityIDs as $cid) {
                    if (isset($cityMaster[$cid])) {
                        $vendorCityNames[] = trim($cityMaster[$cid]);
                    }
                }

                // Check if order item cities match vendor cities
                $hasCityMatch = count(array_intersect($orderCities, $vendorCityNames)) > 0;

                // Must match all three
                return $hasServiceMatch && $hasSubserviceMatch && $hasCityMatch;
            });

        // No vendors matched
        if ($vendors->isEmpty()) {
            return "No vendor matched service/subservice/city.";
        }

        echo "<pre>";
        print_r($vendors);
        echo "</pre>";
        exit;

        // ===================== SUBJECT =====================
        $firstItem = $orders->flatMap->items->first();
        $service_name = $firstItem ? \Helper::subservicename($firstItem->subservice_id) : '';

        $subject = "You got New Booking for $service_name | Order Number $format_order_id";

        // $vendor_bcc_emails = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        $vendor_bcc_emails = ['raj.amvisolution@gmail.com'];

        // ===================== SEND MAIL TO VENDORS ASYNC =====================
        dispatch(function () use ($vendors, $orders, $userdata, $order_number, $subject, $vendor_bcc_emails) {

            foreach ($vendors as $vendor) {
                try {

                    // Fetch extra vendor emails
                    $attributeEmails = DB::table('vendors_attribute')
                        ->where('pid', $vendor->id)
                        ->whereNotNull('c_email')
                        ->pluck('c_email')
                        ->toArray();

                    // Merge vendor main email + attribute emails
                    $allVendorEmails = array_filter(array_merge([$vendor->email], $attributeEmails));

                    if (!empty($allVendorEmails)) {

                        Mail::send('emails.vendor_booking_order_notification', [
                            'user' => $userdata,
                            'orders' => $orders,
                            'order_number' => $order_number,
                            'vendor' => $vendor,
                        ], function ($message) use ($allVendorEmails, $vendor, $subject, $vendor_bcc_emails) {

                            $message->to($allVendorEmails, $vendor->name ?? 'Vendor')
                                ->bcc($vendor_bcc_emails)
                                ->subject($subject);
                        });
                    }

                    // WhatsApp message
                    $this->success_msg_whatsapp_allVendor($vendor->id, $order_number);
                } catch (\Exception $e) {
                    \Log::error('Vendor mail failed (' . $vendor->email . '): ' . $e->getMessage());
                }
            }
        })->afterResponse();

        return true;
    }
}
