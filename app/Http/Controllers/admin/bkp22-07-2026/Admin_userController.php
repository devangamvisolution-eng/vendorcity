<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin\UserPermission;
use Illuminate\Support\Facades\Hash;
use DB;
use DateTime;

class Admin_userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['user_data'] = DB::table('users')->orderBy('id', 'DESC')->where('vendor', 0)->get();
        return view('admin.list_admin_user', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_data['user_category'] = UserPermission::get();
        // $user_data['user_category'] =DB::table('users')->get();               
        return view('admin.add_admin_user', $user_data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new User;
        $data->role_id      = $request->user_id;
        $data->name      = $request->name;
        $data->user_name      = $request->user_name;
        $data->email      = $request->email;
        $data->password      = Hash::make($request->password);
        $data->mobile      = $request->mobile;
        $data->vendor = 0;
        $data->save();
        return redirect()->route('adminuser.index')->with('success', 'User Added Successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show() {}
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $adminuser = DB::table('users')->where('id', '=', $id)->first();
        $data['user_category'] = DB::select('select * from user_permissions');
        return view('admin.edit_admin_user', compact('adminuser'), $data);
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
        $data = User::find($id);
        $data->role_id      = $request->user_id;
        $data->name      = $request->name;
        $data->user_name      = $request->user_name;
        $data->email      = $request->email;
        // $data->password      = $request->password;     
        $data->mobile      = $request->mobile;
        $data->save();
        return redirect()->route('adminuser.index')->with('success', 'User Updated Successfully.');
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
        DB::table('users')->whereIn('id', $delete_id)->delete();
        return redirect()->route('adminuser.index')->with('success', 'User Deleted Successfully.');
    }

    function change_status_adminuser()
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
            $ccRecipients = [];

            // Mail::send([], [], function($message) use($htmll, $admin, $subject,$ccRecipients) {
            //     $message->to($admin);
            //     $message->subject($subject);
            //     foreach ($ccRecipients as $ccRecipient) {
            //         $message->bcc($ccRecipient);
            //     }
            //     $message->html($htmll);
            // });
        }

        DB::table('users')->where('id', $id)->update(array('is_active' => $value));

        echo "1";
    }
}
