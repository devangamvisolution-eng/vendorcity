<?php







namespace App\Http\Controllers\admin;







use App\Http\Controllers\Controller;



use Illuminate\Http\Request;



use App\Models\User;



use App\Models\admin\UserPermission;



use Illuminate\Support\Facades\Hash;



use DB;

use Illuminate\Support\Facades\Crypt;
use Symfony\Component\Mime\Email;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Mail;









class AdminpassController extends Controller



{



    /**



     * Display a listing of the resource.



     *



     * @return \Illuminate\Http\Response



     */

    function lost_password(Request $request){
        //echo "here";exit;

        if($request->action == 'lost_pass'){
            $email = $request->email;
        
        $user_data = DB::table('users')->where('email','=',$email)->first();
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
                    <img src="'.asset("public/site/images/VC-FULL-COLOR.png").'"" style="width: 40%;" >
                    </div>
                    <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                        <h2 style=" font-size: 26px;font-weight: bolder;margin: 0;">Reset Your Password</h2>
                        <p>Dear '.$user_data->name.',</p>
                        <p>Let&apos;s reset your password so you can get back to using our services. </p>
                        <p><a class="btnlink" href="'.URL::to('/reset-password-vendor').'/'.$encrypted.'" style=" background: #0040E6;color: #fff !important;text-decoration: none;width: 100%;display: block;padding: 9px 0;text-align: center;font-size: 16px;border-radius: 9px;">Reset Password</a></p>
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
                                <a href="'.url("/terms-of-service").'"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                <a href="'.url("/privacy-policy").'"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                <a href="'.url("/contact").'"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
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
        $to = $email;
        $ccRecipients = ['hello@vendorscity.com','zafar@quickserverelo.com'];
        Mail::send([], [], function($message) use($data, $to, $subject,$ccRecipients) {
            $message->to($to,'VendorsCity');
            $message->subject($subject);
            $message->from('devang.hnrtechnologies@gmail.com','VendorsCity');
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($data);
        });
        return redirect()->to('/lost-password')->with('L_strsucessMessageForegot_admin','E-mail has been sent Successfully');


        }
        return view('admin.forgot_pass_admin');
    }
    public function emailCheck(Request $request)
    {
        $email = $request->email;
        $user = DB::table('users')->select('*')->where('email','=',$email)->first();
        if ($user == '')
        {
            echo "0";
        }
        else
        {
            echo "1";
        }
    }

    public function reset_password(Request $request)
    {
        $user_id = $request->uid;
        $user_id = Crypt::decryptString($user_id);
        $data['uid'] = $user_id;

        $data['meta_title'] = "";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "";

        return view('admin.reset_pass_admin',$data);
    }

    public function set_password_vendor(Request $request)
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
        
        DB::table('users')->where('id','=',$user_id)->update(['password' => $password]);
        return redirect()->to('/admin')->with('L_strsucessMessage','Password Changed Successfully');
    }


}