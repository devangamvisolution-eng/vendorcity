<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Vendors;
use App\Models\Admin\City;
use App\Models\Admin\UserPermission;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Image;
use DateTime;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Redirect;

class VendorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = DB::table('users')->where('vendor', 1);

        if ($request->filled('service_id')) {
            $query->whereRaw('FIND_IN_SET(?, serviceList)', [$request->service_id]);
        }

        if ($request->filled('subservice_id')) {
            $query->whereRaw('FIND_IN_SET(?, subserviceList)', [$request->subservice_id]);
        }

        if ($request->filled('city_id')) {
            $query->whereRaw('FIND_IN_SET(?, city)', [$request->city_id]);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $data['vendors_data'] = $query->orderBy('id', 'DESC')->paginate(10);

        // Fetch data for filter dropdowns
        $data['services'] = DB::table('services')->where('is_active', 0)->orderBy('servicename', 'ASC')->get();

        if ($request->filled('service_id')) {
            $data['subservices'] = DB::table('subservices')
                ->where('serviceid', $request->service_id)
                ->orderBy('subservicename', 'ASC')
                ->get();
        } else {
            $data['subservices'] = collect();
        }
        $data['cities'] = DB::table('cities')->orderBy('name', 'ASC')->get();

        return view('admin.list_vendors', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $data['user_data'] = DB::select('select * from permission order by id desc');
        $data['permission_data'] = UserPermission::orderBy('id', 'DESC')->get();
        $data['city_data'] = City::where('country', 22)->get();
        $data['service_data'] = DB::table('services')
            ->where('is_active', 0)
            ->orderBy('set_order')
            ->get();


        return view('admin.add_vendors', $data);
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

        //$data['role_id']=$_POST['hidden_role_id'];
        $data['name'] = $_POST['name'];
        $data['user_name'] = $_POST['user_name'];
        $data['companywebsite'] = $_POST['companywebsite'];
        // $data['city']=$_POST['city'];
        if (isset($_POST['city'])) {
            $data['city'] = implode(',', $_POST['city']);
        } else {
            $data['city'] = '';
        }
        $data['crole'] = $_POST['crole'];
        $data['parentcname'] = $_POST['parentcname'];
        $data['establishment_date'] = $_POST['establishment_date'];
        $data['tlexpiry'] = $_POST['tlexpiry'];
        $data['staff'] = $_POST['staff'];
        $data['remarks'] = $_POST['remarks'];
        $data['socialmedai'] = $_POST['socialmedai'];
        $data['password'] = Hash::make($_POST['password']);
        $data['email'] = $_POST['email'];
        $data['rating'] = $_POST['rating'];
        $data['number_of_review'] = $_POST['number_of_review'];
        $data['review_link'] = $_POST['review_link'];
        $data['short_description'] = $_POST['short_description'];
        if ($_POST['mobile'] != '') {
            $data['mobile'] = preg_replace('/\D/', '', $_POST['mobile']);
        } else {
            $data['mobile'] = null;
        }

        $data['country_code'] = $_POST['country_code_vendor'];

        if (request()->has('serviceList') && !empty(request()->input('serviceList'))) {
            $serviceList = request()->input('serviceList');

            if (is_array($serviceList)) {
                $data['serviceList'] = implode(',', $serviceList);
            } else {
                // Handle the case where serviceList is not an array if necessary
                // For example, you might set a default value or throw an error
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
                if ($value == '54') {
                    $roleIds[] = 23;
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

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $path = public_path('upload/vendors/');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            // Save the original image
            $file->move($path, $fileName);
            $data['company_logo'] = $fileName;

            // Create a resized copy of the image
            $resizedImage = Image::make($path . $fileName)->resize(60, 60);
            $resizedFileName = uniqid() . '_thumb.' . $file->getClientOriginalExtension();
            $resizedImage->save($path . $resizedFileName);

            // Save the resized image file name in data if needed
            $data['company_logo'] = $resizedFileName;
        }

        if ($request->hasFile('vatcertificate')) {

            $file = $request->file('vatcertificate');

            $path = public_path('upload/vendors/');

            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($path, $fileName);


            $data['vatcertificate'] = $fileName;
        }
        if ($request->hasFile('trncertificate')) {

            $file = $request->file('trncertificate');

            $path = public_path('upload/vendors/');

            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($path, $fileName);


            $data['trncertificate'] = $fileName;
        }
        if ($request->hasFile('tradelicense')) {

            $file = $request->file('tradelicense');

            $path = public_path('upload/vendors/');

            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($path, $fileName);


            $data['tradelicense'] = $fileName;
        }
        if ($request->hasFile('passport')) {

            $file = $request->file('passport');

            $path = public_path('upload/vendors/');

            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($path, $fileName);


            $data['passport'] = $fileName;
        }
        if ($request->hasFile('emirates_id')) {

            $file = $request->file('emirates_id');

            $path = public_path('upload/vendors/');

            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($path, $fileName);


            $data['emirates_id'] = $fileName;
        }



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
        // echo"<pre>";print_r($data);echo"</pre>";exit;
        return redirect()->route('vendors.index')->with('success', 'Vendor Added Successfully');
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


        $data['vendors'] = DB::table('users')->where('id', '=', $id)->first();
        // echo"<pre>";
        // print_r($data['vendors']);
        // echo"</pre>";exit;

        $selectedServices = !empty($data['vendors']->serviceList)
            ? explode(',', $data['vendors']->serviceList)
            : [];


        $data['attribute_data'] = DB::table('vendors_attribute')
            ->select('*')
            ->where('pid', '=', $data['vendors']->id)
            ->get()
            ->toArray();

        // Fetch all subservices that belong to those selected services
        $data['subservice_data'] = DB::table('subservices')
            ->whereIn('serviceid', $selectedServices ?: [0])
            ->get();


        $data['permission_data'] = UserPermission::orderBy('id', 'DESC')->get();
        $data['city_data'] = City::where('country', 22)->get();
        $data['service_data'] = DB::table('services')->where('is_active', 0)->orderBy('set_order')->get();
        return view('admin.edit_vendors', $data);
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
        // echo"<pre>";
        // print_r($request->all());
        // echo"</pre>";exit;

        //$data['role_id']=$_POST['hidden_role_id'];
        $data['name'] = $_POST['name'];
        $data['user_name'] = $_POST['user_name'];
        $data['companywebsite'] = $_POST['companywebsite'];
        // $data['city']=$_POST['city'];
        // $data['city'] = implode(',', $_POST['city']);  
        if (isset($_POST['city'])) {
            $data['city'] = implode(',', $_POST['city']);
        } else {
            $data['city'] = '';
        }
        $data['crole'] = $_POST['crole'];
        $data['parentcname'] = $_POST['parentcname'];
        $data['establishment_date'] = $_POST['establishment_date'];
        $data['tlexpiry'] = $_POST['tlexpiry'];
        $data['staff'] = $_POST['staff'];
        $data['remarks'] = $_POST['remarks'];
        $data['socialmedai'] = $_POST['socialmedai'];
        $data['rating'] = $_POST['rating'];
        $data['number_of_review'] = $_POST['number_of_review'];
        $data['review_link'] = $_POST['review_link'];
        $data['short_description'] = $_POST['short_description'];
        // $data['password']=Hash::make ($_POST['password']);        
        $data['email'] = $_POST['email'];
        $data['country_code'] = $_POST['country_code_vendor'];
        if ($_POST['mobile'] != '') {
            $data['mobile'] = preg_replace('/\D/', '', $_POST['mobile']);
        } else {
            $data['mobile'] = null;
        }

        if (isset($_POST['serviceList']) && !empty($_POST['serviceList'])) {
            $serviceList = $_POST['serviceList'];

            if (is_array($serviceList) && count($serviceList) > 0) {
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
                if ($value == '50') {
                    $roleIds[] = 22;
                }
                if ($value == '54') {
                    $roleIds[] = 23;
                }
            }

            $commaSeparatedRoles = implode(',', $roleIds);

            $data['role_id'] = $commaSeparatedRoles;
        } else {
            $data['serviceList'] = null;
        }

        if (isset($_POST['subserviceList']) && !empty($_POST['subserviceList'])) {
            $subserviceList = $_POST['subserviceList'];

            if (is_array($subserviceList) && count($subserviceList) > 0) {
                $data['subserviceList'] = implode(',', $subserviceList);
            } else {
                $data['subserviceList'] = '';
            }
        }





        $data['vendor'] = 1;

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $path = public_path('upload/vendors/');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            // Save the original image
            $file->move($path, $fileName);
            $data['company_logo'] = $fileName;

            // Create a resized copy of the image
            $resizedImage = Image::make($path . $fileName)->resize(60, 60);
            $resizedFileName = uniqid() . '_thumb.' . $file->getClientOriginalExtension();
            $resizedImage->save($path . $resizedFileName);

            // Save the resized image file name in data if needed
            $data['company_logo'] = $resizedFileName;
        }

        if ($request->hasFile('vatcertificate')) {

            $file = $request->file('vatcertificate');

            $path = public_path('upload/vendors/');

            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($path, $fileName);


            $data['vatcertificate'] = $fileName;
        }
        if ($request->hasFile('trncertificate')) {

            $file = $request->file('trncertificate');

            $path = public_path('upload/vendors/');

            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($path, $fileName);


            $data['trncertificate'] = $fileName;
        }
        if ($request->hasFile('tradelicense')) {

            $file = $request->file('tradelicense');

            $path = public_path('upload/vendors/');

            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($path, $fileName);


            $data['tradelicense'] = $fileName;
        }
        if ($request->hasFile('passport')) {

            $file = $request->file('passport');

            $path = public_path('upload/vendors/');

            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($path, $fileName);


            $data['passport'] = $fileName;
        }
        if ($request->hasFile('emirates_id')) {

            $file = $request->file('emirates_id');

            $path = public_path('upload/vendors/');

            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($path, $fileName);


            $data['emirates_id'] = $fileName;
        }

        //    echo"<pre>";
        //     print_r($data);
        //     echo"</pre>";exit;


        //    $vendors_id = DB::table('users')->insertGetId($data);
        DB::table('users')->where('id', $id)->update($data);

        if (count($_POST['poc1']) > 0 && $_POST['poc1'] != '') {

            for ($i = 0; $i < count($_POST['poc1']); $i++) {



                if ($_POST['poc1'][$i] != '') {



                    $content['p_id'] = $id;

                    $content['poc'] = $_POST['poc1'][$i];

                    $content['poctitle'] = $_POST['poctitle1'][$i];

                    $content['c_email'] = $_POST['c_email1'][$i];

                    $content['telephone'] = $_POST['telephone1'][$i];
                    $content['country_code'] = $_POST['country_code1'][$i];

                    $this->insert_attribute($content);
                }
            }
        }

        if ($request->pocu != '' && count($request->pocu) > 0) {

            for ($i = 0; $i < count($_POST['pocu']); $i++) {



                if ($_POST['pocu'][$i] != '') {



                    $content['p_id'] = $id;

                    $content['poc'] = $_POST['pocu'][$i];

                    $content['poctitle'] = $_POST['poctitleu'][$i];

                    $content['c_email'] = $_POST['c_emailu'][$i];

                    $content['telephone'] = $_POST['telephoneu'][$i];
                    $content['country_code'] = $_POST['country_codeu'][$i];

                    $content['updateid1xxx'] = $_POST['updateid1xxx'][$i];

                    $this->update_attribute($content);
                }
            }
        }
        return redirect()->route('vendors.index')->with('success', 'Vendors Updated Successfully.');
    }

    function update_attribute($content)
    {



        $data['pid'] = $content['p_id'];

        $data['poc'] = $content['poc'];

        $data['poctitle'] = $content['poctitle'];

        $data['c_email'] = $content['c_email'];

        $data['telephone'] = preg_replace('/\D+/', '', trim($content["telephone"]));
        $data['country_code'] = $content['country_code'];


        DB::table('vendors_attribute')->where('id', $content['updateid1xxx'])->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {


        $delete_id = $request->selected;

        // echo"<pre>";
        // print_r($delete_id);
        // echo"</pre>";exit;

        DB::table('users')->whereIn('id', $delete_id)->delete();

        return redirect()->route('vendors.index')->with('success', 'Vendors has been deleted successfully');
    }

    public function remove_vendors_att(Request $request)
    {

        $service = $request->pid;

        $id = $request->id;

        $result = DB::table('vendors_attribute')->where('pid', '=', $service)->where('id', '=', $id)->delete();

        return redirect()->route('vendors.edit', $service)->with('success', 'Vendors Attribute has been deleted successfully');
    }

    public function change_status_vendors()
    {



        $id = $_POST['id'];

        $value = $_POST['value'];

        // echo"<pre>";
        // print_r($_POST);
        // echo"</pre>";exit;

        if ($value == 0) {

            $vendor_data = DB::table('users')->where('id', $id)->first();

            $dateTime = new DateTime($vendor_data->created_at);
            $year = $dateTime->format("y");

            $vendorId = $vendor_data->vendor_id;

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
                    <div class="wrapper" style="width: 100%;max-width:500px;margin:auto;
                            font-size:14px;line-height:24px;
                            font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
                    <div class="logo" style="float: inherit;border-bottom: 4px solid #FFD413;">
                    <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;" >
                    </div>
                    <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                            <p>Dear ' . $vendor_data->name . ',</p>
                            
                            <p>Congratulations! We are delighted to inform you that your registration as a vendor on VendorsCity has been accepted. Welcome aboard!</p>';

            $htmll_service = '<strong>Services Offered:</strong> ';
            $services = explode(',', $vendor_data->serviceList);
            $count = count($services);
            foreach ($services as $key => $service) {

                $htmll_service .= \Helper::servicename($service);
                if ($key < $count - 1) {
                    $htmll_service .= ', '; // Add comma and space for all except the last item
                }
            }

            $htmll .= '<p><strong>Your Vendor ID:</strong> ' . $vendorId . ' <br> ' . $htmll_service . '</p>';



            $htmll .= ' 

                            <p><strong>Your Vendor Login Details:</strong> <br>Email: ' . $vendor_data->email . '</p>
                            <p>You can now access your vendor dashboard and start offering your services to our customers. Here are some key actions you can take in your dashboard:</p>
                            <ol>
                                <li><b>Manage Bookings:</b> View, accept, manage bookings and quote requests from customers.
                                    
                                </li>
                                <li><b>View Payments:</b> Track your earnings and payment history.
                                </li>
                                <li><b>Customer Communication:</b> Communicate with customers and address their queries.
                                </li>
                            </ol>

                            <p><a class="btnlink" href="' . url("admin") . '" style=" background: #0040E6;color: #fff !important;text-decoration: none;width: 100%;display: block;padding: 9px 0;text-align: center;font-size: 16px; border-radius: 9px;">Get Started</a></p>

                            <p>If you have any questions or need assistance, feel free to reach out to us at <a href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a>. We are here to support you throughout your journey with VendorsCity.
                            </p>
                            
                            
                            <p>Once again, welcome to our platform, and we look forward to a successful partnership!</p>

                            
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

            // echo $htmll;exit;
            // echo"<pre>";print_r($vendor_data);echo"</pre>";exit;

            $subject = "Important Update: Your Vendor Account at VendorsCity";
            $admin = $vendor_data->email;
            $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];

            Mail::send([], [], function ($message) use ($htmll, $admin, $subject, $ccRecipients) {
                $message->to($admin);
                $message->subject($subject);
                foreach ($ccRecipients as $ccRecipient) {
                    $message->bcc($ccRecipient);
                }
                $message->html($htmll);
            });
        }

        DB::table('users')->where('id', $id)->update(array('is_active' => $value));

        echo "1";
    }

    function vendor_check_mail()
    {

        $email = $_POST['email']; // Replace with the email you want to search for

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

    function vendor_edit_check_mail()
    {

        $email = $_POST['email'];
        $vendor_id = $_POST['vendor_id'];

        $result = DB::table('users')
            ->select('*')
            ->where('email', $email)
            ->where('id', '!=', $vendor_id) // Exclude user with ID 1
            ->first();

        if ($result) {
            return 1;
        } else {
            return 0;
        }

        echo $result;
    }

    public function subscription($id)
    {

        $data['id'] = $id;
        return view('admin.subscription_page', $data);
    }
    // public function copy_package_subscription($id){

    //     // echo"<pre>";print_r($id);echo"</pre>";exit;
    //     $data['id'] = $id;

    //     $data['subscription_data'] = DB::table('subscription')->where('id',$id)->first();

    //     return view('admin.subscription_copy_page',$data);
    // }
    public function vendor_login($id)
    {
        $user_id = $id;

        // echo"<pre>";print_r($user_id);echo"</pre>";exit;

        $vendor_data = DB::table('users')->where('id', $user_id)->where('vendor', '1')->first();

        Auth::loginUsingId($vendor_data->id); // Use this instead to log in by ID

        return redirect(RouteServiceProvider::HOME);
    }

    function excel_download_vendors(Request $request)
    {
        $query = DB::table('users')->where('vendor', 1);

        if ($request->filled('service_id')) {
            $query->whereRaw('FIND_IN_SET(?, serviceList)', [$request->service_id]);
        }

        if ($request->filled('subservice_id')) {
            $query->whereRaw('FIND_IN_SET(?, subserviceList)', [$request->subservice_id]);
        }

        if ($request->filled('city_id')) {
            $query->whereRaw('FIND_IN_SET(?, city)', [$request->city_id]);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $vendors_data = $query->orderBy('id', 'DESC')->get()->toArray();
        // echo "<pre>";print_r($vendors_data);echo"</pre>";exit;


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Vendor Id');
        $sheet->setCellValue('B1', 'Company Name');
        $sheet->setCellValue('C1', 'Services');
        $sheet->setCellValue('D1', 'Email for Login');
        $sheet->setCellValue('E1', 'Parent Company Name');
        $sheet->setCellValue('F1', 'city');
        $sheet->setCellValue('G1', 'Mobile');
        $sheet->setCellValue('H1', 'Wallet Amount');
        $sheet->setCellValue('I1', 'Status');
        $sheet->setCellValue('J1', 'Company Website');
        $sheet->setCellValue('K1', 'Company Role');
        $sheet->setCellValue('L1', 'Establishment Date');
        $sheet->setCellValue('M1', 'TL expiry date');
        $sheet->setCellValue('N1', 'No Of Staff');

        $row = 2;

        if (isset($vendors_data)) {
            foreach ($vendors_data as $data_new) {

                $vendors_services = explode(',', $data_new->serviceList);
                $services_names = [];
                foreach ($vendors_services as $city_id) {
                    // Assuming getCityNameById is your helper function
                    $services_names[] = \Helper::servicename(trim($city_id)); // trim to remove any extra whitespace
                }
                $services_names = implode(',', $services_names);


                $vendors_city = explode(',', $data_new->city);
                $city_names = [];
                foreach ($vendors_city as $city_id) {
                    // Assuming getCityNameById is your helper function
                    $city_names[] = \Helper::cityname(trim($city_id)); // trim to remove any extra whitespace
                }
                $city_names = implode(',', $city_names);

                if ($data_new->is_active == 1) {
                    $status = "Deactive";
                } else {
                    $status = "Active";
                }

                $sheet->setCellValue('A' . $row, $data_new->vendor_id);
                $sheet->setCellValue('B' . $row, $data_new->name);
                $sheet->setCellValue('C' . $row, $services_names);
                $sheet->setCellValue('D' . $row, $data_new->email);
                $sheet->setCellValue('E' . $row, $data_new->parentcname);
                $sheet->setCellValue('F' . $row, $city_names);
                $sheet->setCellValue('G' . $row, $data_new->mobile);
                $sheet->setCellValue('H' . $row, $data_new->wallet_amount); // Set payment mode once
                $sheet->setCellValue('I' . $row, $status);
                $sheet->setCellValue('J' . $row, $data_new->companywebsite);
                $sheet->setCellValue('K' . $row, $data_new->crole);
                $sheet->setCellValue('L' . $row, $data_new->establishment_date);
                $sheet->setCellValue('M' . $row, $data_new->tlexpiry);
                $sheet->setCellValue('N' . $row, $data_new->staff);
                $row++;
            }
        }


        $writer = new Xlsx($spreadsheet);

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="vendors_data.xlsx"');
        header('Cache-Control: max-age=0');

        // Write the file to the browser
        $writer->save('php://output');
    }

    public function edit_subscription($subscription_id)
    {

        if (request()->input('action') == 'add') {

            $subscription = DB::table('subscription')->where('id', $subscription_id)->first();
            $vendors_data = DB::table('users')->where('id', $subscription->vendor_id)->first();

            if (request()->input('hidden_type_of_package') == 0) { //package update code



                //echo "<pre>";print_r($vendors_data);echo"</pre>";
                $data_package_update['no_of_inquiry_package'] = $_POST['no_of_inquiry_package'];
                $data_package_update['price_package'] = $_POST['price_package'];
                DB::table('subscription')->where('id', $subscription_id)->update($data_package_update);

                $wallet_amount_diff = $_POST['price_package'] - $_POST['price_package_old'];

                /*-----Start Update Vendor wallet amount-----*/
                $vendor_wallet_amount = $vendors_data->wallet_amount - $wallet_amount_diff;
                DB::table('users')->where('id', $vendors_data->id)->update(['wallet_amount' => $vendor_wallet_amount]);
                /*-----End Update Vendor wallet amount-----*/

                /* Wallet data insert start */
                $data_wallet['vendors_id'] = $vendors_data->id;
                $data_wallet['price'] = $wallet_amount_diff;
                $data_wallet['payment'] = 0;
                $data_wallet['add_deduct'] = 1;
                $data_wallet['status'] = 0;
                $data_wallet['subscription_id'] = $subscription_id;
                //echo "<pre>";print_r($data_wallet);echo"</pre>";
                $wallet_id = DB::table('wallets')->insertGetId($data_wallet);

                $year = date('y');
                $data_wau['transaction_id'] = "TID-" . $vendors_data->vendor_id . "-" . $year . "-" . sprintf("%06d", $wallet_id);
                DB::table('wallets')->where('id', $wallet_id)->update($data_wau);

                /* Wallet data insert end */
            } else { //lead update code
                if (isset($_POST['subscription_subservice_attribute_id'])) {

                    foreach ($_POST['subscription_subservice_attribute_id'] as $key => $value) {

                        // $data_att['id'] = $value;
                        $data_att['no_of_inquiry'] = $_POST['no_of_inquiry_' . $value . ''];
                        $data_att['charge'] = $_POST['price_' . $value . ''];

                        DB::table('subscription_subservice_attribute')->where('id', $value)->update($data_att);


                        //echo "<pre>";print_r($data_att);echo"</pre>";
                    }
                }

                if (isset($_POST['hidden_local_move_id'])) {

                    foreach ($_POST['hidden_local_move_id'] as $key => $value) {

                        $data_local['local_move_charge'] = $_POST['local_price_' . $value . ''];

                        DB::table('subscription_local_move_attribute')->where('id', $value)->update($data_local);
                    }
                }

                if (isset($_POST['hidden_international_move_id'])) {

                    foreach ($_POST['hidden_international_move_id'] as $key => $value) {

                        $data_local['local_move_charge'] = $_POST['international_price_' . $value . ''];

                        DB::table('subscription_international_move_attribute')->where('id', $value)->update($data_local);
                    }
                }
            }

            //echo "<pre>";print_r($_POST);echo"</pre>";exit;

            return Redirect::route('vendors.subscription', ['id' => $vendors_data->id])->with('success', 'Subscription Update Successfully.');

            //echo "<pre>";print_r($_POST);echo"</pre>";exit;
        }
        $data['subscription_data'] = DB::table('subscription')->where('id', $subscription_id)->first();
        $data['country_data'] = DB::table('countries')->select('*')->orderBy('country', 'ASC')->get();
        $data['state_data'] = DB::table('states')->select('*')->orderBy('id', 'DESC')->get();
        $data['allcity'] = DB::table('cities')->select('*')->get();
        $data['allservices'] = DB::table('services')->select('*')->where('is_active', 0)->get();
        $data['allsub_services'] = DB::table('subservices')->select('*')->get();

        $data['id'] = $subscription_id;
        $data['vendor_id'] = $data['subscription_data']->vendor_id;

        // echo "<pre>";print_r($data);echo"</pre>";exit;

        return view('admin.edit_subscription', $data);
    }
    public function edit_international_subscription($subscription_id)
    {

        if (request()->input('action') == 'add') {

            $subscription = DB::table('subscription')->where('id', $subscription_id)->first();
            $vendors_data = DB::table('users')->where('id', $subscription->vendor_id)->first();

            if (request()->input('hidden_type_of_package') == 0) { //package update code



                //echo "<pre>";print_r($vendors_data);echo"</pre>";
                $data_package_update['no_of_inquiry_package'] = $_POST['no_of_inquiry_package'];
                $data_package_update['price_package'] = $_POST['price_package'];
                DB::table('subscription')->where('id', $subscription_id)->update($data_package_update);

                $wallet_amount_diff = $_POST['price_package'] - $_POST['price_package_old'];

                /*-----Start Update Vendor wallet amount-----*/
                $vendor_wallet_amount = $vendors_data->wallet_amount - $wallet_amount_diff;
                DB::table('users')->where('id', $vendors_data->id)->update(['wallet_amount' => $vendor_wallet_amount]);
                /*-----End Update Vendor wallet amount-----*/

                /* Wallet data insert start */
                $data_wallet['vendors_id'] = $vendors_data->id;
                $data_wallet['price'] = $wallet_amount_diff;
                $data_wallet['payment'] = 0;
                $data_wallet['add_deduct'] = 1;
                $data_wallet['status'] = 0;
                $data_wallet['subscription_id'] = $subscription_id;
                //echo "<pre>";print_r($data_wallet);echo"</pre>";
                $wallet_id = DB::table('wallets')->insertGetId($data_wallet);

                $year = date('y');
                $data_wau['transaction_id'] = "TID-" . $vendors_data->vendor_id . "-" . $year . "-" . sprintf("%06d", $wallet_id);
                DB::table('wallets')->where('id', $wallet_id)->update($data_wau);

                /* Wallet data insert end */
            } else { //lead update code
                if (isset($_POST['subscription_subservice_attribute_id'])) {

                    foreach ($_POST['subscription_subservice_attribute_id'] as $key => $value) {

                        // $data_att['id'] = $value;
                        $data_att['no_of_inquiry'] = $_POST['no_of_inquiry_' . $value . ''];
                        $data_att['charge'] = $_POST['price_' . $value . ''];

                        DB::table('subscription_subservice_attribute')->where('id', $value)->update($data_att);


                        //echo "<pre>";print_r($data_att);echo"</pre>";
                    }
                }

                if (isset($_POST['hidden_local_move_id'])) {

                    foreach ($_POST['hidden_local_move_id'] as $key => $value) {

                        $data_local['local_move_charge'] = $_POST['local_price_' . $value . ''];

                        DB::table('subscription_local_move_attribute')->where('id', $value)->update($data_local);
                    }
                }

                if (isset($_POST['hidden_international_move_id'])) {

                    foreach ($_POST['hidden_international_move_id'] as $key => $value) {

                        $data_local['local_move_charge'] = $_POST['international_price_' . $value . ''];

                        DB::table('subscription_international_move_attribute')->where('id', $value)->update($data_local);
                    }
                }
            }

            //echo "<pre>";print_r($_POST);echo"</pre>";exit;

            return Redirect::route('vendors.subscription', ['id' => $vendors_data->id])->with('success', 'Subscription Update Successfully.');

            //echo "<pre>";print_r($_POST);echo"</pre>";exit;
        }
        $data['subscription_data'] = DB::table('subscription')->where('id', $subscription_id)->first();
        $data['country_data'] = DB::table('countries')->select('*')->orderBy('country', 'ASC')->get();
        $data['continents_data'] = DB::table('continents')->select('*')->get();
        $data['state_data'] = DB::table('states')->select('*')->orderBy('id', 'DESC')->get();
        $data['allcity'] = DB::table('cities')->select('*')->get();
        $data['allservices'] = DB::table('services')->select('*')->where('is_active', 0)->get();
        $data['allsub_services'] = DB::table('subservices')->select('*')->get();

        $data['id'] = $subscription_id;
        $data['vendor_id'] = $data['subscription_data']->vendor_id;

        // echo "<pre>";print_r($data['subscription_data']);echo"</pre>";exit;

        return view('admin.edit_international_subscription', $data);
    }
}
