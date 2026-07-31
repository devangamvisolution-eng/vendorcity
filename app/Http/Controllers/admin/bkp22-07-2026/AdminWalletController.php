<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Wallet;
use Auth;
use DB;
use DateTime;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // echo"<pre>";print_r($request->all());echo"</pre>";exit;
        $query = DB::table('wallets');

        $startdate = $request->s_date;
        $enddate = $request->e_date;
        $vendorname = $request->vendor_id;

        if ($startdate != '') {
            $query = $query->where('created_at', '>=', date('Y-m-d', strtotime($startdate)));
        }

        if ($enddate != '') {
            $query = $query->where('created_at', '<=', date('Y-m-d', strtotime($enddate)));
        }
        if ($vendorname != '') {
            $query = $query->where('vendors_id', $vendorname);
        }

        $data['startdate'] = $startdate;
        $data['enddate'] = $enddate;
        $data['filter_vendor_name'] = $vendorname;

        $data['wallet_data'] = $query->orderBy('id', 'DESC')->get();
        $data['all_vendor'] = DB::table('users')->where('vendor', 1)->where('is_active', 0)->get()->toArray();

        return view('admin.list_adminwallet', $data);
    }
    public function vendors_wallet($id)
    {

        // echo"<pre>";
        // print_r($id);
        // echo"</pre>";exit;
        $data['wallets_data'] = Wallet::where('vendors_id', $id)->orderBy('id', 'DESC')->get();

        return view('admin.list_vendorswallet', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['error'] = "";
        $data['all_vendor'] = DB::table('users')->where('vendor', 1)->get()->toArray();
        return view('admin.add_adminwallet', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['vendors_id'] = $request->input('vendor_id');
        $data['payment'] = $request->input('payment_type');
        $data['deduct_reason'] = $request->input('deduct_reason');
        $data['price'] = $request->input('price');
        $data['add_deduct'] = 0;
        $data['status'] = 0;

        if ($data['payment'] == 4) {
            $data['add_deduct'] = 1;
        }

        $wallet_id = DB::table('wallets')->insertGetId($data);


        $vendor_data_new = DB::table('users')->where('id', $data['vendors_id'])->first();
        $year = date('y');

        $data_u['transaction_id'] = "TID-" . $vendor_data_new->vendor_id . "-" . $year . "-" . sprintf("%06d", $wallet_id);
        DB::table('wallets')->where('id', $wallet_id)->update($data_u);

        return redirect()->route('adminwallet.index')->with('success', 'Admin Wallet Added Successfully');

        //echo"<pre>";print_r($request->all());echo"</pre>";exit;
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
        //echo"<pre>";
        // print_r($value);
        // echo"</pre>";exit;
    }
    public function vendor_wallet_check()
    {
        // echo"<pre>";print_r($_POST);echo"</pre>";exit;
        $vendorid = $_POST['vendor_id'];
        $payment_type = $_POST['payment_type'];
        $price = $_POST['price'];

        $vendor_data = DB::table('users')->where('id', $vendorid)->first();

        if ($payment_type == 4 && $price <= $vendor_data->wallet_amount) {

            $data['wallet_amount'] = $vendor_data->wallet_amount - $price;

            $vendor_data = DB::table('users')->where('id', $vendorid)->update($data);
            // echo"<pre>";print_r($wallet_amount);echo"</pre>";exit;

        } else {
            echo 2;
            die();
        }
        echo "1";
    }
    public  function change_status_wallet()
    {

        $id = $_POST['id'];
        $vendorid = $_POST['vendorid'];
        $value = $_POST['value'];

        // echo"<pre>";
        // print_r($value);
        // echo"</pre>";exit;

        // Update 'wallets' table
        DB::table('wallets')->where('id', $id)->update(['status' => $value]);


        $vendor_data = DB::table('users')->where('id', $vendorid)->first();

        // Retrieve data from 'wallets' table, including the 'price' column

        $walletData = DB::table('wallets')->where('id', $id)->first();

        if ($value == 1 && $walletData->payment != 4) {
            $wallet_amount = $vendor_data->wallet_amount + $walletData->price;
        } elseif ($vendor_data->wallet_amount >= $walletData->price) {
            $wallet_amount = $vendor_data->wallet_amount - $walletData->price;
        } else {
            echo 2;
            die();
        }

        $data_wa['wallet_amount'] = $wallet_amount;

        DB::table('users')->where('id', $vendorid)->update($data_wa);

        // Assuming 'users' table has a column 'wallet_amount', update it
        // DB::table('users')->where('id', $vendorid)->update([
        //     'wallet_amount' => DB::raw('wallet_amount ' . ($value == 0 ? '-' : '+') . ' ' . $walletData->price),
        //     // Adjust column names as needed
        // ]);

        if ($value == 1) {


            $wallets_data = DB::table('wallets')->where('id', $id)->first();
            $vendor_data_new = DB::table('users')->where('id', $vendorid)->first();


            $dateTime = new DateTime($wallets_data->created_at);
            $year = $dateTime->format("y");

            $TransactionId = $wallets_data->transaction_id;

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
                        <div class="logo"style="float: inherit;border-bottom: 4px solid #FFD413;">
                        <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;" >
                        </div>
                        <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                            <p>Dear ' . $vendor_data->name . ',</p>
                            
                            <p>We are pleased to inform you that your funds request of ' . $wallets_data->price . ' AED has been approved and successfully added to your account wallet. </p>';


            $htmll .= ' </p>

                            <p>Here are the details:</p>
                            <ul>
                                <li>Requested Amount: ' . $wallets_data->price . ' AED </li>
                                <li>Approval Date: ' . $newDate = date("d-m-Y", strtotime($wallets_data->created_at)) . '</li>
                                <li>Transaction ID: ' . $TransactionId . '</li>
                                <li>New Wallet Balance: ' . $vendor_data_new->wallet_amount . ' AED</li>
                                
                            </ul>

                            <p>You can now utilize these funds to purchase subscriptions for acquiring leads on VendorsCity. Should you require any assistance or have further questions, please dont hesitate to reach out to us by replying to this email.
                            </p>

                            
                        </div>
                        <div class="email_footer"  style="width:100%;margin-top: 20px;">
                            <h3 style=" font-size: 20px;font-weight: bolder;margin: 0;
                            border-bottom: 3px solid #6B7177;padding-bottom: 20px;
                            margin-bottom: 15px;">
                            <h3 style=" font-size: 20px;font-weight: bolder;margin: 0;
                            border-bottom: 3px solid #6B7177;padding-bottom: 20px;
                            margin-bottom: 15px;">Accounts Team</h3>
                            <div class="email_footer_div" style="width:100%;
                            display: flex;">
                                <div class="footer_left" style=" width: 100px;
                            float: left;">
                                    <img style="width:70%;" src="' . asset("public/site/images/vcfaviconwap.png") . '"" >
                                </div>
                                <div class="footer_right" style=" margin-left:10px;
                            float: left;">
                                    <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a></p>
                                    <p style="margin:0;">VendorsCity Portal LLC</p>
                                    <div class="footer_links" style="margin:10px 0;">
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
            $subject = "Funds Approval Confirmation";
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


            /* notification sectio start */
            $data_notification['vendor_id'] = $vendor_data->id;
            $data_notification['subject'] = 'Your added fund has been approved. ';
            $data_notification['added_datetime'] = date('Y-m-d h:i:s');

            DB::table('notification')->insert($data_notification);
            /* notification sectio end */

            //echo"<pre>";print_r($vendor_data);echo"</pre>";exit;
        }



        echo "1";
    }
    public function filter_data_adminwallet(Request $request)
    {

        // echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $startdate = $request->input('startdate_fil', '');
        $enddate = $request->input('enddate_fil', '');
        $vendor_name = $request->input('filter_vendor_name_fil', '');


        $query = DB::table('wallets');

        if ($startdate != '') {
            $query = $query->where('created_at', '>=', date('Y-m-d', strtotime($startdate)));
        }

        if ($enddate != '') {
            $query = $query->where('created_at', '<=', date('Y-m-d', strtotime($enddate)));
        }
        if ($vendor_name != '') {
            $query = $query->where('vendors_id', $vendor_name);
        }

        $data = $query->orderBy('id', 'DESC')->get()->toArray();

        // echo"<pre>";
        // print_r($data);
        // echo"</pre>";exit;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Sr No');
        $sheet->setCellValue('B1', 'Transaction No');
        $sheet->setCellValue('C1', 'Name');
        $sheet->setCellValue('D1', 'Price');
        $sheet->setCellValue('E1', 'Payment Type');
        $sheet->setCellValue('F1', 'Add/Deduct');
        $sheet->setCellValue('G1', 'Status');
        $sheet->setCellValue('H1', 'Date');

        $row = 2;
        $i = 1;

        if (isset($data)) {

            foreach ($data as $data_new) {

                $vendor_data = DB::table('users')->where('vendor', 1)->where('is_active', 0)->where('id', $data_new->vendors_id)->first();

                $sheet->setCellValue('A' . $row, $i);

                if ($data_new->transaction_id !== null) {
                    $sheet->setCellValue('B' . $row, $data_new->transaction_id);
                } else {
                    $sheet->setCellValue('B' . $row, '-');
                }
                if ($vendor_data->name !== null) {
                    $sheet->setCellValue('C' . $row, $vendor_data->name);
                } else {
                    $sheet->setCellValue('C' . $row, '-');
                }
                if ($data_new->price !== null) {
                    $sheet->setCellValue('D' . $row, $data_new->price);
                } else {
                    $sheet->setCellValue('D' . $row, '-');
                }
                if ($data_new->payment !== null) {
                    if ($data_new->payment === 0) {
                        $sheet->setCellValue('E' . $row, 'Cash');
                    } elseif ($data_new->payment === 1) {
                        $sheet->setCellValue('E' . $row, 'Online');
                    } elseif ($data_new->payment === 2) {
                        $sheet->setCellValue('E' . $row, 'Cheque');
                    } elseif ($data_new->payment === 3) {
                        $sheet->setCellValue('E' . $row, 'Refund');
                    } elseif ($data_new->payment === 4) {
                        $sheet->setCellValue('E' . $row, 'Deduct');
                    }
                } else {
                    $sheet->setCellValue('E' . $row, '-');
                }

                if ($data_new->add_deduct !== null) {
                    if ($data_new->add_deduct === 0) {
                        $sheet->setCellValue('F' . $row, 'Add');
                    } else {
                        $sheet->setCellValue('F' . $row, 'Deduct');
                    }
                } else {
                    $sheet->setCellValue('F' . $row, '-');
                }


                if ($data_new->status === 0) {
                    if ($data_new->add_deduct === 1) {
                        $sheet->setCellValue('G' . $row, '-');
                    } else {
                        $sheet->setCellValue('G' . $row, 'Not-Approved');
                    }
                } else {
                    $sheet->setCellValue('G' . $row, 'Approved');
                }

                if ($data_new->created_at !== null) {
                    $sheet->setCellValue('H' . $row, date('Y-m-d', strtotime($data_new->created_at)));
                } else {
                    $sheet->setCellValue('H' . $row, '-');
                }
                $row++;
                $i++;
            }
        }
        $writer = new Xlsx($spreadsheet);

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="AdminWallet-list.xlsx"');
        header('Cache-Control: max-age=0');

        // Write the file to the browser
        $writer->save('php://output');
    }
}
