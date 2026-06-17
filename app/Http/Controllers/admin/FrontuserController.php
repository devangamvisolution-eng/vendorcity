<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContactExport;

use Symfony\Component\Mime\Email;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class FrontuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['frontuser_data']= DB::table('frontloginregisters')->orderBy('id','DESC')->get();

        // echo"<pre>";
        // print_r($data['frontuser_data']);
        // echo"</pre>";exit;
       return view('admin.list_frontuser',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['error_message'] = '';
       return view('admin.add_frontuser',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:frontloginregisters,email',  // unique email
            'mobile' => 'required|unique:frontloginregisters,mobile', // unique mobile
        ]);

        $insert = DB::table('frontloginregisters')->insert([
            'name'   => $request->name,
            'email'  => $request->email,
            'mobile' => preg_replace('/\D+/', '', trim($request->mobile)),
            'country_code' => $request->country_code_user,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->route('frontuser.index')->with('success', 'Customer User Added  Successfully');

    }
    public function downloadXls()
    {
        return Excel::download(new ContactExport, 'Frontuser.xlsx');
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
        $data['error_message'] = '';
        $data['frontuser_data'] = DB::table('frontloginregisters')->where('id',$id)->first();
        return view('admin.edit_frontuser',$data);
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
        $request->validate([
        'name'   => 'required|string|max:255',
        'email'  => [
            'required',
            'email',
            Rule::unique('frontloginregisters', 'email')->ignore($id),
        ],
        'mobile' => [
            'required',
            Rule::unique('frontloginregisters', 'mobile')->ignore($id),
        ],
    ]);


        $update = DB::table('frontloginregisters')->where('id',$id)->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'mobile' => preg_replace('/\D+/', '', trim($request->mobile)),
			'country_code' => $request->country_code_user,
        ]);

        return redirect()->route('frontuser.index')->with('success', 'Customer User updated  Successfully');
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

    public  function change_status_frontuser(){



        $id=$_POST['id'];

        $value=$_POST['value']; 
        
        
           

        DB::table('frontloginregisters')->where('id',$id)->update(array('status'=>$value));
     
        $front_user=DB::table('frontloginregisters')->where('id',$id)->first();

        if($value == 0 ){ //deactive
            $subject =' Important: Your VendorsCity Account Has Been Deactivated';
            $p1 = "We regret to inform you that your VendorsCity account has been deactivated as of ".date('d-m-Y').".";

            $p2 ='This action may have been taken due to a breach of our  <a href="'.url("/terms-of-service").'" style="color: #555;display: inline-block;">Terms of Use</a>. If you believe this deactivation was in error or have any questions regarding this action, please contact our support team at <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a>. Our team will be happy to assist you and address any concerns you may have.';
        }else{

            $subject ='Welcome to VendorsCity! Your Account is Now Active';
            $p1 = "We are delighted to inform you that your VendorsCity account has been successfully activated as of ".date('d-m-Y').".";

            $p2 ='You can now log in and start exploring the wide range of services available on our platform. If you have any questions or need assistance, please do not hesitate to reach out to our support team at <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a>';
        }

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
                            <p>Dear '.$front_user->name.',</p>
                            
                            <p>'.$p1.'</p>
                            <p>'.$p2.'</p>

                        </div>
                        <div class="email_footer" style="width:100%;margin-top: 20px;">
                            <h3>The VendorsCity Team</h3>
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

            $to =$front_user->email;  
            $ccRecipients = ['hello@vendorscity.com','zafar@quickserverelo.com'];
            Mail::send([], [], function($message) use($htmll, $to, $subject,$ccRecipients) {
                $message->to($to);
                $message->subject($subject);
                foreach ($ccRecipients as $ccRecipient) {
                    $message->bcc($ccRecipient);
                }
                $message->html($htmll);
            });


        echo "1";

    }
}