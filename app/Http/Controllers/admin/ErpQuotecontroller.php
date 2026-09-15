<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;
use Mail;
use Route;
use App\Models\Admin\Erpdescriptionofgoods;

class ErpQuotecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['erp_enquiry_data'] = DB::table('erp_enquiry')->where('enquiry_level', 1)->where('survey_level', 1)->where('quote_level', 0)->orderBy('id', 'desc')->get();

        return view('admin.erp_quote.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $enquiry_id = $_GET['enquiry_id'];
        $data['followup_data'] = DB::table('erp_enquiry')->where('id', $enquiry_id)->first();
        $data['country_data'] = DB::table('countries')->get();
        $data['surveyor_type'] = DB::table('surveyor_type')->get();
        $data['vendors_data'] = DB::table('users')->where('vendor', 1)->where('is_active', 0)->orderBy('id', 'DESC')->get()->toArray();

        $data['enquiry_status'] = DB::table('enquiry_status_remark')
            ->where('enquiry_id', '=', $enquiry_id)
            ->orderBy('id', 'DESC')
            ->first() ?? (object) ['status' => null];

        $data['costing_attribute'] = DB::table('costing_attribute')->where('enquiry_id', $enquiry_id)->get();

        $data['salesperson_data']  = DB::table('users')->where('role_id', '11')->where('is_active', 0)->where('vendor', 0)->get();

        $data['current_route'] = Route::currentRouteName();

        $data['servicedata'] = DB::table('services')->where('id', $data['followup_data']->service)->first();
        $data['descriptionofgoods'] = Erpdescriptionofgoods::latest('id')->get();

        // echo "<pre>";
        // print_r($data['descriptionofgoods']);
        // die;
        return view('admin.erp_quote.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //echo "<pre>"; print_r($request->all()); die;


        $inquiry_id = $request->inquiry_id_hidden;
        // $data['quotation_date'] = $request->quotation_date;
        $data['quotation_date'] = date('Y-m-d', strtotime($request->quotation_date));
        $data['volume_in_cbm'] = $request->volume_in_cbm;
        $data['grand_total'] = $request->grand_total;
        $data['margin_percent'] = $request->margin;
        $data['margin_amount'] = $request->margin_amount;
        $data['total_sum'] = $request->total_sum;
        $data['prepared_by'] = $request->prepared_by;
        $data['est_time_to_complete'] = $request->est_time_to_complete;
        $data['vat_charge'] = $request->vat_charge;
        $data['mail_to_customer'] = $request->mail_to_customer;
        $data['description'] = $request->head_description;

        $data['scope_of_job'] = $request->scope_of_job;
        $data['price_includes'] = $request->price_includes;
        $data['price_excludes'] = $request->price_excludes;
        $data['disclaimer'] = $request->disclaimer;
        $data['insurance'] = $request->insurance;
        $data['payment_terms'] = $request->payment_terms;

        if ($request->action === "revise-quotation" && !empty($request->action) && $request->action != "") {
            $followup_data = DB::table('erp_enquiry')->where('id', $inquiry_id)->first();

            $reviseRequestPlus = $followup_data->revise_quotation_count += 1;

            $data['revise_quotation_count'] = $reviseRequestPlus;
            // echo "<pre>";print_r($reviseRequestPlus);echo "</pre>";exit;
        }

        DB::table('erp_enquiry')->where('id', $inquiry_id)->update($data);

        if ($request->qty != "" && !empty($request->qty)) {

            if (count($request->qty) > 0 && $request->qty != '') {

                for ($i = 0; $i < count($request->qty); $i++) {

                    if ($request->qty[$i] != '') {

                        $content['enquiry_id'] = $inquiry_id;
                        $content['qty']        = $request->qty[$i] ?: 0;
                        $content['description']  = $request->description[$i] ?: NULL;
                        $content['prov']         = $request->prov[$i] ?: 0;
                        $content['total']        = $request->total[$i] ?: 0;
                        $this->insert_attribute($content);
                    }
                }
            }
        }

        if ($request->qtyu != '' && count($request->qtyu) > 0  && count($request->updateid1xxx) > 0) {
            $countOfCode = count($request->qtyu);
            for ($i = 0; $i < $countOfCode; $i++) {
                if ($request->qtyu[$i] != '') {

                    $contentUpdate['enquiry_id']              = $inquiry_id;
                    $contentUpdate['updateid1xxx']            = $request->updateid1xxx[$i] ?: 0;
                    $contentUpdate['qtyu']                    = $request->qtyu[$i] ?: 0;
                    $contentUpdate['descriptionu']            = $request->descriptionu[$i] ?: NULL;
                    $contentUpdate['provu']                   = $request->provu[$i] ?: 0;
                    $contentUpdate['totalu']                  = $request->totalu[$i] ?: 0;
                    $this->update_attribute($contentUpdate);
                }
            }
        }

        $current_route = $request->current_route;

        if ($current_route == 'erp_quote.revisequote') {
            return redirect()->route('erp_quote.lists')->with('success', 'Quote Added Successfully');
        } elseif ($current_route == 'erp_acceptedquote.revisequote') {
            return redirect()->route('erp_acceptedquote.lists')->with('success', 'Quote Added Successfully');
        } else {
            return redirect()->route('erp_quote.lists')->with('success', 'Quote Added Successfully');
        }
    }

    function insert_attribute($content)
    {
        // Map the incoming content to the database fields
        $data['enquiry_id']              = $content['enquiry_id'];
        $data['qty']                     = $content['qty'];
        $data['description']             = $content['description'];
        $data['prov']                    = $content['prov'];
        $data['total']                   = $content['total'];
        DB::table('costing_attribute')->insertGetId($data);
    }

    public function update_attribute($content)
    {
        // echo"<pre>";print_r($content);echo"</pre>";exit;
        // Map the incoming content to the database fields
        $data = [
            'enquiry_id'          => $content['enquiry_id'] ?? null,
            'qty'                 => $content['qtyu'] ?? 0,
            'description'         => $content['descriptionu'] ?? null,
            'prov'                => $content['provu'] ?? 0,
            'total'               => $content['totalu'] ?? 0,
        ];

        // Perform the update operation using the provided ID
        if (!empty($content['updateid1xxx'])) {
            DB::table('costing_attribute')
                ->where('id', $content['updateid1xxx'])
                ->update($data);
        } else {
            throw new \Exception('Missing or invalid ID for update operation');
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

    public function costing_remove(Request $request)
    {
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;
        $enquiryId = $request->enquiry_id;
        $id = $request->id;
        $updatefrom = $request->updatefrom;
        $result = DB::table('costing_attribute')->where('enquiry_id', '=', $enquiryId)->where('id', '=', $id)->delete();

        return redirect()->back()->with('success', 'Attribute Deleted Successfully');
    }

    public function customer_mail($enquiry_id)
    {
        $data['enquiry_id'] = $enquiry_id;
        $data['followup_data'] = $followup_data = DB::table('erp_enquiry')->where('id', $enquiry_id)->first();
        //echo "<pre>"; print_r($data); die;
        //$data['cc_email_data'] = DB::table('cc_emails')->get();
        $data['cc_email_data'] = [
            (object) ['email' => 'hello@vendorscity.com'],

        ];
        return view("admin.erp_quote.customer-mail-format", $data);
    }

    public function mail_format_type(Request $request)
    {
        $formatType = $request->formatType;
        $enquiry_id = $request->enquiry_id;
        $followup_data = DB::table('erp_enquiry')->where('id', $enquiry_id)->first();
        $mailSubject = $followup_data->description . ' ( ' . $followup_data->quote_id . ' )' ?? "";
        $mailFormatType1 = "";
        $mailFormatType2 = "";
        $mailFormatType3 = "";
        $acceptQuoteStyle = "display: none;";
        if ($formatType == 1) {
            $mailFormatType1 .= $this->quoteEmailFormat1($enquiry_id, $acceptQuoteStyle);
            return response()->json(['status' => 'success', 'data' => $mailFormatType1, 'subject' => $mailSubject]);
        }
        // if($formatType == 2){
        //     $mailFormatType2 .= $this->quoteEmailFormat2($enquiry_id,$acceptQuoteStyle);
        //     return response()->json(['status' => 'success', 'data' => $mailFormatType2, 'subject' => $mailSubject]);
        // }
        // if($formatType == 3){
        //     $mailFormatType3 .= $this->quoteEmailFormat3($enquiry_id,$acceptQuoteStyle);
        //     return response()->json(['status' => 'success', 'data' => $mailFormatType3, 'subject' => $mailSubject]);
        // }
        //  if($formatType == 4){
        //     $mailFormatType3 .= $this->storagequoteEmailformat($enquiry_id,$acceptQuoteStyle);
        //     return response()->json(['status' => 'success', 'data' => $mailFormatType3, 'subject' => $mailSubject]);
        // }
    }


    public function quoteEmailFormat1($enquiry_id, $acceptQuoteStyle, $forPdf = false)
    {

        $clientName = "";
        $data['contactPerson'] = "";
        $data['followup_data'] = $followup_data = DB::table('erp_enquiry')->where('id', $enquiry_id)->first();

        $data['costing_attribute'] = DB::table('costing_attribute')->where('enquiry_id', $enquiry_id)->get();

        $data['forPdf'] = $forPdf;
        $data['acceptQuoteStyle'] = $acceptQuoteStyle;
        //
        $data['servicedata'] = DB::table('services')->where('id', $followup_data->service)->first();

        //echo "<pre>";print_r($data);echo "</pre>";exit;
        return view('admin.erp_quote.format1_pdf', $data)->render();
    }

    // public function quotation_download(Request $request)
    // {
    //     try {

    //         $mailFormatType = "";
    //         $formatType  = $request->query('formatType'); // Use query() for GET parameters
    //         $enquiry_id  = $request->query('enquiry_id');

    //         $followup_data = DB::table('erp_enquiry')->where('id', $enquiry_id)->first();
    //         // echo "<pre>";
    //         // print_r($followup_data);
    //         // exit;
    //         $acceptQuoteStyle = "display: none;";
    //         if ($formatType == 1) {
    //             $selectedFormatType = 1;
    //             $mailFormatType .= $this->quoteEmailFormat1($enquiry_id, $acceptQuoteStyle, true);
    //         }


    //         $mpdf = new Mpdf();
    //         $mpdf->SetMargins(10, 10, 10);
    //         $mpdf->SetAutoPageBreak(true, 0);



    //         // Add HTML content to PDF
    //         $mpdf->WriteHTML($mailFormatType);


    //         $quoteId = $followup_data->quote_id ?? "Quotation";
    //         $quoteId = trim($quoteId); // remove spaces
    //         $quoteId = preg_replace('/[\x00-\x1F\x7F]/', '', $quoteId); // remove control characters
    //         $filename = "{$quoteId}.pdf";

    //         //$fileName = "Quotation-ERP.pdf";
    //         return response()->streamDownload(function () use ($mpdf) {
    //             echo $mpdf->Output('', 'S');
    //         }, $filename, [
    //             'Content-Type' => 'application/pdf',
    //         ]);
    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Something went wrong. Please try again later.');
    //     }
    // }
    public function quotation_download(Request $request)
    {
        try {
            $formatType = $request->query('formatType');
            $enquiry_id = $request->query('enquiry_id');

            $followup_data = DB::table('erp_enquiry')
                ->where('id', $enquiry_id)
                ->first();

            if (!$followup_data) {
                abort(404, 'Enquiry not found');
            }

            $mailFormatType = "";
            $acceptQuoteStyle = "display: none;";

            if ($formatType == 1) {
                $mailFormatType .= $this->quoteEmailFormat1(
                    $enquiry_id,
                    $acceptQuoteStyle,
                    true
                );
            }

            // 1. Define a secure, writable directory inside Laravel's storage folder
            $tempDir = storage_path('app/mpdf');

            // 2. Automatically create the directory if it doesn't exist
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0775, true);
            }

            // 3. Initialize mPDF with the custom temp directory configuration
            $mpdf = new \Mpdf\Mpdf([
                'tempDir' => $tempDir
            ]);

            $mpdf->SetMargins(10, 10, 10);
            $mpdf->SetAutoPageBreak(true, 0);

            $mpdf->WriteHTML($mailFormatType);

            $quoteId = $followup_data->quote_id ?? "Quotation";

            $quoteId = trim($quoteId);
            $quoteId = preg_replace('/[\x00-\x1F\x7F]/', '', $quoteId);

            $filename = $quoteId . '.pdf';

            if (ob_get_length()) {
                ob_end_clean();
            }

            return response()->streamDownload(function () use ($mpdf) {
                echo $mpdf->Output('', 'S');
            }, $filename, [
                'Content-Type' => 'application/pdf',
            ]);
        } catch (\Exception $e) {
            // Better production practice: Log the exact error and give a user-friendly response
            Log::error('PDF Generation Failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate PDF. Please try again later.'], 500);
        }
    }
    // function send_quotation_mail(Request $request)
    // {

    //     // echo"<pre>";print_r($request->all());echo"</pre>";exit;

    //     try {

    //         $formatType  = $request->formatType;
    //         $enquiry_id  = $request->enquiry_id;
    //         $mailSubject = $request->mailSubject;

    //         $cc_emailsclient   = $request->cc_emails ?? [];

    //         $to_mail     = (array) $request->to_mail ?? [];



    //         $selectedFormatType = "";
    //         $followup_data = DB::table('erp_enquiry')->where('id', $enquiry_id)->first();
    //         //echo"sdw";exit;
    //         $costing_data  = DB::table('costing_attribute')->where('enquiry_id', $enquiry_id)->get();

    //         $mailFormatType = "";

    //         if ($formatType == 1) {
    //             $selectedFormatType = 1;
    //             $acceptQuoteStyle = "display: none;";
    //             $mailFormatType .= $this->quoteEmailFormat1($enquiry_id, $acceptQuoteStyle, true);
    //         }

    //         $to_mail = is_array($to_mail) ? $to_mail : [];
    //         $customerEmail = $followup_data->client_email;
    //         $customerName = $followup_data->client_name ?? "Customer";
    //         if (isset($customerEmail)) {
    //             array_push($to_mail, $customerEmail);
    //         }

    //         // if (!empty($request->to_mail)) {
    //         //     array_push($cc_emailsclient, $request->to_mail);
    //         // }

    //         if (!empty($followup_data->assign_to)) {
    //             $userEmail = DB::table('users')->where('id', $followup_data->assign_to)->value('email');
    //             if ($userEmail != "" && !empty($userEmail)) {
    //                 array_push($cc_emailsclient, $userEmail);
    //             }
    //         }



    //         $quoteId = $followup_data->quote_id ?? "Quotation";
    //         $quoteId = preg_replace('/[^A-Za-z0-9\-]/', '', $quoteId);

    //         //    echo $customerName."<br>";
    //         //    echo $enquiry_id."<br>";
    //         //    echo $selectedFormatType."<br>";exit;
    //         $html = "";

    //         $html = '<!doctype html> <html>
    //     <head>
    //     <meta charset="utf-8">
    //     <title>Account Registration:</title>
    //     <style>
    //         .logo {
    //             border-bottom: 4px solid #FFD413;
    //         }
    //         .logo img{
    //             width: 45%;
    //         }
    //         .wrapper {
    //             width: 100%;
    //             max-width:500px;
    //             margin:auto;
    //             font-size:14px;
    //             line-height:24px;
    //             font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;
    //             color:#555;
    //             padding:50px 0;
    //         }   
    //         .email_wrapper {
    //             width:100%;
    //             margin-top: 18px;
    //             font-size: 16px;
    //         }
    //         h2 {
    //             font-size: 26px;
    //             font-weight: bolder;
    //             margin: 0;
    //         }
    //         .btnlink {
    //             background: #0040E6;
    //             color: #fff !important;
    //             text-decoration: none;
    //             width: 100%;
    //             display: block;
    //             padding: 9px 0;
    //             text-align: center;
    //             font-size: 16px;
    //             border-radius: 9px;
    //         }
    //         .email_footer {
    //             width:100%;
    //             margin-top: 20px;
    //         }
    //         h3 {
    //             font-size: 20px;
    //             font-weight: bolder;
    //             margin: 0;
    //             border-bottom: 3px solid #6B7177;
    //             padding-bottom: 20px;
    //             margin-bottom: 15px;
    //         }
    //         .email_footer_div {
    //             width:100%;
    //             display: flex; 
    //         }
    //         .footer_left {
    //             width: 100px;
    //             float: left;
    //         }
    //         .footer_right {
    //             margin-left:10px;
    //             float: left;
    //         }
    //         .footer_right p{
    //             margin:0;
    //         }
    //         .footer_links {
    //             margin:10px 0;
    //         }
    //         .footer_links a {
    //             width: 100%;
    //             color: #555;
    //             display: inline-block;
    //         }
    //     </style>
    // </head>
    // <body>
    //     <div class="wrapper" style="width: 100%;max-width:500px;margin:auto;
    //                         font-size:14px;line-height:24px;
    //                         font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
    //         <div class="logo" style="float: inherit;border-bottom: 4px solid #FFD413;">
    //         <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;"  >
    //         </div>
    //         <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
    //             <p>Hi ' . $customerName . ',</p>
    //             <p>Your personalized quotation from VendorsCity is ready — carefully tailored to give you the best price, trusted professionals, and a smooth, worry-free experience from start to finish.</p>
    //             <p>We’ve reserved a special slot just for you, so the sooner you confirm, the faster our team can get everything arranged and ready.
    //             </p>
    //             <p>Click below to accept your quotation and let’s get things moving — we’ll handle the rest for you!</p>

    //             <a href="' . route('accept.quotation', ['enquiry_id' => $enquiry_id, 'format_type' => $selectedFormatType]) . '" style="text-decoration: none;">
    //                 <button type="button"
    //                         style="background-color: #0056b3;
    //                             color: #fff;
    //                             padding: 10px 20px;
    //                             border: none;
    //                             border-radius: 5px;
    //                             cursor: pointer;
    //                             font-size: 16px;">
    //                     Accept Quotation
    //                 </button>
    //             </a>

    //         </div>
    //        <div class="email_footer" style="width:100%;margin-top: 20px;">
    //                         <h3 style=" font-size: 20px;font-weight: bolder;margin: 0;
    //                         border-bottom: 3px solid #6B7177;padding-bottom: 20px;
    //                         margin-bottom: 15px;">The VendorsCity Team</h3>
    //                         <div class="email_footer_div" style=" width:100%;
    //                         display: flex; ">
    //                             <div class="footer_left" style="width: 100px;
    //                         float: left;">
    //                                 <img style="width:70%;" src="' . asset("public/site/images/vcfaviconwap.png") . '"" >
    //                             </div>
    //                             <div class="footer_right" style="margin-left:10px;
    //                             float: left;">
    //                                 <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
    //                                 <p style="margin:0;">VendorsCity Portal LLC</p>
    //                                 <div class="footer_links" style=" margin:10px 0;">
    //                             <a href="' . url("/terms-of-service") . '" style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
    //                             <a href="' . url("/privacy-policy") . '" style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
    //                             <a href="' . url("/contact") . '" style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
    //                             </div>
    //                 </div>
    //             </div>
    //         </div>
    //     </div>
    // </body>
    // </html>';
    //         // $html .= '<!DOCTYPE html>
    //         //                 <html lang="en">
    //         //                 <head>
    //         //                     <meta charset="UTF-8">
    //         //                     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    //         //                     <title>ERP-Quotation</title>
    //         //                 </head>
    //         //                 <body>';



    //         // $html .= '<p>Dear '.$customerName.',</p>
    //         // <p>I would like to thank you for the opportunity to bid on the upcoming relocation.</p>
    //         // <p>Please find attached our rate for the requested services.</p>
    //         // <p>If you need any other information regarding our services, please feel free to contact us.</p>
    //         // <p>Rest assured you will receive top-quality service &amp; prompt attention.</p>
    //         // <p>I hope that you will find our rates competitive &amp; favour us with your valued order.</p>
    //         // <p>Looking forward to your confirmation.</p>';


    //         //     $html .= '<a href="' . route('accept.quotation', ['enquiry_id' => $enquiry_id, 'format_type' => $selectedFormatType]) . '" style="text-decoration: none;">
    //         //         <button type="button"
    //         //                 style="background-color: #0056b3;
    //         //                     color: #fff;
    //         //                     padding: 10px 20px;
    //         //                     border: none;
    //         //                     border-radius: 5px;
    //         //                     cursor: pointer;
    //         //                     font-size: 16px;">
    //         //             Accept Quotation
    //         //         </button>
    //         //     </a>
    //         // </body>
    //         // </html>';

    //         // echo"<pre>";print_r($to_mail);echo"</pre>";
    //         // echo"<pre>";print_r($cc_emailsclient);echo"</pre>";exit;

    //         $mpdf = new Mpdf();
    //         $mpdf->SetMargins(10, 10, 10);
    //         $mpdf->SetAutoPageBreak(true, 0);



    //         $mpdf->WriteHTML($mailFormatType);

    //         //echo $mailFormatType."sdw1 ee";exit;



    //         $pdfContent = $mpdf->Output('', 'S');
    //         // $subject = $mailSubject;
    //         $subject = 'Ready When You Are — Confirm Your Quotation Now ✅';

    //         $quoteId = $followup_data->quote_id ?? "Quotation";
    //         $quoteId = trim($quoteId);
    //         $quoteId = preg_replace('/[\x00-\x1F\x7F]/', '', $quoteId);
    //         $filename = "{$quoteId}.pdf";



    //         foreach ($to_mail as $to) {
    //             if (isset($to) && filter_var($to, FILTER_VALIDATE_EMAIL)) {
    //                 Mail::send([], [], function ($message) use ($html, $to, $subject, $pdfContent, $cc_emailsclient, $filename) {
    //                     $message->to($to);
    //                     $message->subject($subject);
    //                     $message->attachData($pdfContent, $filename, [
    //                         'mime' => 'application/pdf',
    //                     ]);

    //                     if (!empty($cc_emailsclient)) {
    //                         foreach ($cc_emailsclient as $ccRecipient) {
    //                             if (filter_var($ccRecipient, FILTER_VALIDATE_EMAIL)) {
    //                                 $message->bcc($ccRecipient);
    //                             }
    //                         }
    //                     }
    //                     $message->html($html);
    //                 });
    //             }
    //         }

    //         return response()->json(['status' => 'SUCCESS', 'message' => 'Mail has been sent successfully'], 200);
    //     } catch (\Exception $e) {

    //         \Log::error('Quotation Mail Error: ' . $e->getMessage());
    //         return response()->json(['status' => 'ERROR', 'message' => 'Something went wrong. Please try again later'], 500);
    //     }
    // }

    public function send_quotation_mail(Request $request)
    {
        try {
            $formatType  = $request->formatType;
            $enquiry_id  = $request->enquiry_id;
            $mailSubject = $request->mailSubject;

            $cc_emailsclient = $request->cc_emails ?? [];
            $to_mail         = (array) $request->to_mail ?? [];

            $selectedFormatType = "";
            $followup_data = DB::table('erp_enquiry')->where('id', $enquiry_id)->first();

            if (!$followup_data) {
                return response()->json(['status' => 'ERROR', 'message' => 'Enquiry records not found'], 404);
            }

            $costing_data  = DB::table('costing_attribute')->where('enquiry_id', $enquiry_id)->get();
            $mailFormatType = "";

            if ($formatType == 1) {
                $selectedFormatType = 1;
                $acceptQuoteStyle = "display: none;";
                $mailFormatType .= $this->quoteEmailFormat1($enquiry_id, $acceptQuoteStyle, true);
            }

            $to_mail = is_array($to_mail) ? $to_mail : [];
            $customerEmail = $followup_data->client_email;
            $customerName = $followup_data->client_name ?? "Customer";

            if (isset($customerEmail) && !empty($customerEmail)) {
                array_push($to_mail, $customerEmail);
            }

            if (!empty($followup_data->assign_to)) {
                $userEmail = DB::table('users')->where('id', $followup_data->assign_to)->value('email');
                if ($userEmail != "" && !empty($userEmail)) {
                    array_push($cc_emailsclient, $userEmail);
                }
            }

            $quoteId = $followup_data->quote_id ?? "Quotation";
            $quoteId = preg_replace('/[^A-Za-z0-9\-]/', '', $quoteId);

            // Building HTML Content for Email
            $html = '<!doctype html> 
        <html>
        <head>
            <meta charset="utf-8">
            <title>Account Registration</title>
            <style>
                .logo { border-bottom: 4px solid #FFD413; }
                .logo img { width: 45%; }
                .wrapper { width: 100%; max-width:500px; margin:auto; font-size:14px; line-height:24px; font-family:Helvetica Neue, Helvetica, Arial, sans-serif; color:#555; padding:50px 0; }   
                .email_wrapper { width:100%; margin-top: 18px; font-size: 16px; }
                .btnlink { background: #0040E6; color: #fff !important; text-decoration: none; width: 100%; display: block; padding: 9px 0; text-align: center; font-size: 16px; border-radius: 9px; }
                .email_footer { width:100%; margin-top: 20px; }
                h3 { font-size: 20px; font-weight: bolder; margin: 0; border-bottom: 3px solid #6B7177; padding-bottom: 20px; margin-bottom: 15px; }
                .email_footer_div { width:100%; display: flex; }
                .footer_left { width: 100px; float: left; }
                .footer_right { margin-left:10px; float: left; }
                .footer_right p { margin:0; }
                .footer_links { margin:10px 0; }
                .footer_links a { width: 100%; color: #555; display: inline-block; }
            </style>
        </head>
        <body>
            <div class="wrapper">
                <div class="logo">
                    <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '" style="width: 40%;">
                </div>
                <div class="email_wrapper">
                    <p>Hi ' . $customerName . ',</p>
                    <p>Your personalized quotation from VendorsCity is ready — carefully tailored to give you the best price, trusted professionals, and a smooth, worry-free experience from start to finish.</p>
                    <p>We’ve reserved a special slot just for you, so the sooner you confirm, the faster our team can get everything arranged and ready.</p>
                    <p>Click below to accept your quotation and let’s get things moving — we’ll handle the rest for you!</p>
                    <br>
                    <a href="' . route('accept.quotation', ['enquiry_id' => $enquiry_id, 'format_type' => $selectedFormatType]) . '" style="text-decoration: none;">
                        <button type="button" style="background-color: #0056b3; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
                            Accept Quotation
                        </button>
                    </a>
                </div>
                <div class="email_footer">
                    <h3>The VendorsCity Team</h3>
                    <div class="email_footer_div">
                        <div class="footer_left">
                            <img style="width:70%;" src="' . asset("public/site/images/vcfaviconwap.png") . '">
                        </div>
                        <div class="footer_right">
                            <p>Questions? Email <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                            <p>VendorsCity Portal LLC</p>
                            <div class="footer_links">
                                <a href="' . url("/terms-of-service") . '">Terms of Use</a> | 
                                <a href="' . url("/privacy-policy") . '">Privacy Policy</a> | 
                                <a href="' . url("/contact") . '">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>';

            // --- MANAGING THE MPDF FIX HERE ---
            $tempDir = storage_path('app/mpdf');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0775, true);
            }

            // Initialize with the custom storage pathway configurations
            $mpdf = new \Mpdf\Mpdf([
                'tempDir' => $tempDir
            ]);

            $mpdf->SetMargins(10, 10, 10);
            $mpdf->SetAutoPageBreak(true, 0);
            $mpdf->WriteHTML($mailFormatType);

            // Render PDF content directly to string stream safely
            $pdfContent = $mpdf->Output('', 'S');

            $subject = !empty($mailSubject) ? $mailSubject : 'Ready When You Are — Confirm Your Quotation Now ✅';

            $quoteId = $followup_data->quote_id ?? "Quotation";
            $quoteId = trim($quoteId);
            $quoteId = preg_replace('/[\x00-\x1F\x7F]/', '', $quoteId);
            $filename = "{$quoteId}.pdf";

            // Sending Email Loop
            foreach ($to_mail as $to) {
                if (isset($to) && filter_var($to, FILTER_VALIDATE_EMAIL)) {
                    Mail::send([], [], function ($message) use ($html, $to, $subject, $pdfContent, $cc_emailsclient, $filename) {
                        $message->to($to);
                        $message->subject($subject);
                        $message->attachData($pdfContent, $filename, [
                            'mime' => 'application/pdf',
                        ]);

                        if (!empty($cc_emailsclient)) {
                            foreach ($cc_emailsclient as $ccRecipient) {
                                if (filter_var($ccRecipient, FILTER_VALIDATE_EMAIL)) {
                                    $message->bcc($ccRecipient);
                                }
                            }
                        }
                        $message->html($html);
                    });
                }
            }

            return response()->json(['status' => 'SUCCESS', 'message' => 'Mail has been sent successfully'], 200);
        } catch (\Exception $e) {
            // This will now catch structural/network mail exceptions if they occur, instead of mPDF directory write failures
            \Log::error('Quotation Mail Error: ' . $e->getMessage());
            return response()->json(['status' => 'ERROR', 'message' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }

    public function accept_quotation($enquiryId, $formatType)
    {
        $acceptQuoteStyle = "display: block;";
        if ($formatType == 1) {
            $selectedFormatType = 1;
            return $this->quoteEmailFormat1($enquiryId, $acceptQuoteStyle, false);
        }
    }
    public function request_accepted($enquiry_id, $format_type)
    {
        // echo $enquiryId; echo "<br>";
        // echo $formatType; exit;
        $followup_data = DB::table('erp_enquiry')->where('id', $enquiry_id)->first();

        $service_name = \Helper::servicename($followup_data->service);


        //echo"<pre>";print_r($followup_data);echo"</pre>";exit;
        $data['accepted_quotation'] = 1;
        $data['quote_level'] = 1;

        DB::table('erp_enquiry')->where('id', $enquiry_id)->update($data);

        $customerName = $followup_data->client_name ?? "Customer";
        $customerEmail = $followup_data->client_email ?? "";
        $clientPhoneNo = $followup_data->client_mobile ?? "";
        $contactPersonName = $followup_data->contact_person ?? "";
        //$contactPersonEmail = $followup_data->contact_person_email ?? "";
        $contactPersonPhoneNo = $followup_data->contact_person_mobile ?? "";


        $bodyMessage = '<!doctype html> <html>
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
                <p>Dear ' . $customerName . ',</p>
                <p>Thank you for choosing VendorsCity!</p>
                 <p>This is to confirm that our team will arrive on the scheduled date and time to provide the requested service.</p>
                 <p>Upon arrival, the team will follow the instructions provided in your booking. If you are available, you can give additional guidance or highlight any areas that need special attention. If you are not present, the team will proceed carefully based on your prior instructions.</p>
                 <p>The service is expected to be completed as per the agreed quotation. Please ensure any required permissions (such as building or society approvals) are arranged beforehand.</p>
                 <p>If you need to make any changes to the schedule, please inform us at least 48 hours in advance. For any additional requests, our team will be happy to assist you.</p>
                 <p>We look forward to delivering a smooth and professional service experience!</p>
                
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




        // $bodyMessage = '<!DOCTYPE html>
        //                 <html lang="en">
        //                 <head>
        //                     <meta charset="UTF-8">
        //                     <meta name="viewport" content="width=device-width, initial-scale=1.0">
        //                     <title>ERP-Quotation</title>
        //                 </head>
        //                 <body>
        //                     <p>Dear '.$customerName.',</p>
        //                     <p>Thank you for your confirmation.</p>
        //                     <p>This email is to confirm that our moving crew will arrive on the scheduled date & time to begin your relocation.</p>
        //                     <p>Upon arrival, the team will conduct a brief walk-through of the residence before starting the move. To ensure the safety of your valuable and important items/documents, we recommend keeping them with you.</p>
        //                     <p>The entire move is expected to be completed as mentioned in the quotation.</p>
        //                     <p>Kindly inform the crew leader upon arrival about the specific area from which you would like us to begin the move. Additionally please inform the crew leader any items belonging to the landlord that should not be moved.</p>
        //                     <p>If you require any assistance, please do not hesitate to contact us. Should you need to make any changes to the moving date & time, kindly notify us at least 48 hours in advance.</p>
        //                     <p>Please ensure that any necessary move-in/out permits are arranged from your end.</p>
        //                     <p>Finally, if you are interested in purchasing insurance for your belongings, please inform us as soon as possible, as the activation of the insurance policy requires 2 to 3 business days.</p><br/>
        //                     <p>Happy Moving !!</p>
        //                 </body>
        //                 </html>';



        $acceptedMailToAdmin = '
            <!doctype html>
            <html>
                <head>
                    <meta charset="utf-8">
                    <title>Email Template</title>
                    <style>
                        .logo {
                            text-align: center;
                            width: 100%;
                        }
                        .wrapper {
                            width: 100%;
                            max-width: 500px;
                            margin: auto;
                            font-size: 14px;
                            line-height: 24px;
                            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
                            color: #555;
                        }
                        .wrapper div {
                            height: auto;
                            float: left;
                            margin-bottom: 15px;
                            width: 100%;
                        }
                        .text-center {
                            text-align: center;
                        }
                        .email-wrapper {
                            padding: 5px;
                            border: 1px solid #ccc;
                            width: 100%;
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
                    <div class="wrapper">
                        <div class="email-wrapper">
                            <table style="border-collapse: collapse;" width="100%" border="0" cellspacing="0" cellpadding="10">
                                <tr>
                                    <td>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                            <tr>
                                                <td style="font-size: 18px;">Hello Team,</td>
                                            </tr>
                                            <tr>
                                                <td style="line-height: 20px;">
                                                    Quotation has been Accepted By Customer <br><br> Please find the Below details
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table style="border-top: 3px solid #333;" bgcolor="#f7f7f7" width="100%" border="0" cellspacing="0" cellpadding="5">
                                            <tr>
                                                <td width="50%">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="5">';

        if (isset($customerName) && !empty($customerName) && $customerName != "") {

            $acceptedMailToAdmin .= '<tr>
                                                            <td width="150px">Client Name:</td>
                                                            <td>' . $customerName . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="150px">Client Email:</td>
                                                            <td>' . $customerEmail . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="150px">Client Phone No:</td>
                                                            <td>' . $clientPhoneNo . '</td>
                                                        </tr>';
        }

        if (isset($contactPersonName) && $contactPersonPhoneNo != "") {
            $acceptedMailToAdmin .= '<tr>
                                                                <td width="150px">Contact Person Name:</td>
                                                                <td>' . $contactPersonName . '</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td width="150px">Contact Person Phone No:</td>
                                                                <td>' . $contactPersonPhoneNo . '</td>
                                                            </tr>';
        }



        $acceptedMailToAdmin .= '<tr>
                                                            <td width="100px">Enquiry ID:</td>
                                                            <td>' . $followup_data->quote_no . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="100px">Quotation ID:</td>
                                                            <td>' . $followup_data->quote_id . '</td>
                                                        </tr>
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


        $ccRecipients = ['devang.hnrtechnologies@gmail.com'];


        $ccRecipients = array_unique($ccRecipients);
        $subject = "Service Confirmation –" . $service_name;

        if (isset($customerEmail) && filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
            Mail::send([], [], function ($message) use ($bodyMessage, $customerEmail, $subject, $ccRecipients) {
                $message->to($customerEmail);
                $message->subject($subject);
                $message->html($bodyMessage);
                // Add CC recipients
                foreach ($ccRecipients as $ccRecipient) {
                    $message->bcc($ccRecipient);
                }
            });
        }



        //$admin = 'devang.hnrtechnologies@gmail.com';
        $admin = 'hello@vendorscity.com';
        $subjectAdmin = "Quotation Accepted (" . $followup_data->quote_id . ") - VendorsCity";

        if (isset($admin) && filter_var($admin, FILTER_VALIDATE_EMAIL)) {
            $toAdmin = [$admin];
            Mail::send([], [], function ($message) use ($acceptedMailToAdmin, $toAdmin, $subjectAdmin, $ccRecipients) {
                $message->to($toAdmin);
                $message->subject($subjectAdmin);
                $message->html($acceptedMailToAdmin);
                // Add CC recipients
                foreach ($ccRecipients as $ccRecipient) {
                    $message->bcc($ccRecipient);
                }
            });
        }

        return redirect()->route('accept.quotation', ['enquiry_id' => $followup_data->id, 'format_type' => $format_type])->with('success', 'Quotation Accepted Successfully');
    }

    public function accept_quotation_byadmin(Request $request)
    {

        //echo "<pre>";print_r($request->all());echo "</pre>";exit;
        $enquiry_id = $request->enquiry_id;
        $status = $request->status_id;


        $data['accepted_quotation'] = 1;
        $data['quote_level'] = 1;

        DB::table('erp_enquiry')->where('id', $enquiry_id)->update($data);

        $userId = Auth::id();
        $data_status['user_id']            = $userId;
        $data_status['enquiry_id']         = $enquiry_id;
        $data_status['status']             = $status ?? 0;
        $data_status['created_at']         = date('Y-m-d');
        $data_status['enquiry_level']      = 1;
        $data_status['survey_level']       = 1;
        $data_status['quote_level']        = 1;
        DB::table('enquiry_status_remark')->insert($data_status);


        $followup_data = DB::table('erp_enquiry')->where('id', $enquiry_id)->first();

        $customerName = $followup_data->client_name ?? "Customer";
        $customerEmail = $followup_data->client_email ?? "";
        $clientPhoneNo = $followup_data->client_mobile ?? "";
        $contactPersonName = $followup_data->contact_person ?? "";
        //$contactPersonEmail = $followup_data->contact_person_email ?? "";
        $contactPersonPhoneNo = $followup_data->contact_person_mobile ?? "";

        $service_name = \Helper::servicename($followup_data->service);


        $bodyMessage = '<!doctype html> <html>
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
                <p>Dear ' . $customerName . ',</p>
                <p>Thank you for choosing VendorsCity!</p>
                 <p>This is to confirm that our team will arrive on the scheduled date and time to provide the requested service.</p>
                 <p>Upon arrival, the team will follow the instructions provided in your booking. If you are available, you can give additional guidance or highlight any areas that need special attention. If you are not present, the team will proceed carefully based on your prior instructions.</p>
                 <p>The service is expected to be completed as per the agreed quotation. Please ensure any required permissions (such as building or society approvals) are arranged beforehand.</p>
                 <p>If you need to make any changes to the schedule, please inform us at least 48 hours in advance. For any additional requests, our team will be happy to assist you.</p>
                 <p>We look forward to delivering a smooth and professional service experience!</p>
                
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

        $acceptedMailToAdmin = '
            <!doctype html>
            <html>
                <head>
                    <meta charset="utf-8">
                    <title>Email Template</title>
                    <style>
                        .logo {
                            text-align: center;
                            width: 100%;
                        }
                        .wrapper {
                            width: 100%;
                            max-width: 500px;
                            margin: auto;
                            font-size: 14px;
                            line-height: 24px;
                            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
                            color: #555;
                        }
                        .wrapper div {
                            height: auto;
                            float: left;
                            margin-bottom: 15px;
                            width: 100%;
                        }
                        .text-center {
                            text-align: center;
                        }
                        .email-wrapper {
                            padding: 5px;
                            border: 1px solid #ccc;
                            width: 100%;
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
                    <div class="wrapper">
                        <div class="email-wrapper">
                            <table style="border-collapse: collapse;" width="100%" border="0" cellspacing="0" cellpadding="10">
                                <tr>
                                    <td>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                            <tr>
                                                <td style="font-size: 18px;">Hello Team,</td>
                                            </tr>
                                            <tr>
                                                <td style="line-height: 20px;">
                                                    Quotation has been Accepted By Customer <br><br> Please find the Below details
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table style="border-top: 3px solid #333;" bgcolor="#f7f7f7" width="100%" border="0" cellspacing="0" cellpadding="5">
                                            <tr>
                                                <td width="50%">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="5">';

        if (isset($customerName) && !empty($customerName) && $customerName != "") {

            $acceptedMailToAdmin .= '<tr>
                                                            <td width="150px">Client Name:</td>
                                                            <td>' . $customerName . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="150px">Client Email:</td>
                                                            <td>' . $customerEmail . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="150px">Client Phone No:</td>
                                                            <td>' . $clientPhoneNo . '</td>
                                                        </tr>';
        }

        if (isset($contactPersonName) && $contactPersonPhoneNo != "") {
            $acceptedMailToAdmin .= '<tr>
                                                                <td width="150px">Contact Person Name:</td>
                                                                <td>' . $contactPersonName . '</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td width="150px">Contact Person Phone No:</td>
                                                                <td>' . $contactPersonPhoneNo . '</td>
                                                            </tr>';
        }



        $acceptedMailToAdmin .= '<tr>
                                                            <td width="100px">Enquiry ID:</td>
                                                            <td>' . $followup_data->quote_no . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="100px">Quotation ID:</td>
                                                            <td>' . $followup_data->quote_id . '</td>
                                                        </tr>
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


        $ccRecipients = ['devang.hnrtechnologies@gmail.com'];


        $ccRecipients = array_unique($ccRecipients);
        $subject = "Service Confirmation –" . $service_name;

        if (isset($customerEmail) && filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
            Mail::send([], [], function ($message) use ($bodyMessage, $customerEmail, $subject, $ccRecipients) {
                $message->to($customerEmail);
                $message->subject($subject);
                $message->html($bodyMessage);
                // Add CC recipients
                foreach ($ccRecipients as $ccRecipient) {
                    $message->bcc($ccRecipient);
                }
            });
        }



        //$admin = 'devang.hnrtechnologies@gmail.com';
        $admin = 'hello@vendorscity.com';
        $subjectAdmin = "Quotation Accepted (" . $followup_data->quote_id . ") - VendorsCity";

        if (isset($admin) && filter_var($admin, FILTER_VALIDATE_EMAIL)) {
            $toAdmin = [$admin];
            Mail::send([], [], function ($message) use ($acceptedMailToAdmin, $toAdmin, $subjectAdmin, $ccRecipients) {
                $message->to($toAdmin);
                $message->subject($subjectAdmin);
                $message->html($acceptedMailToAdmin);
                // Add CC recipients
                foreach ($ccRecipients as $ccRecipient) {
                    $message->bcc($ccRecipient);
                }
            });
        }

        return response()->json(['status' => 'SUCCESS', 'message' => 'Quotation Accepted Successfully'], 200);
    }

    function quatation_reject_form(Request $request)
    {
        //echo "<pre>";print_r($request->all());echo "</pre>";exit;
        $enquiry_id = $request->quatation_reject_inquiry_id;
        $reason = $request->quatation_reject_remark;

        $data['quote_level'] = 2;
        $data['is_reject'] = 1;
        $data['reject_reason'] = $reason;
        $data['reject_date'] = date('Y-m-d H:i:s');

        //echo "<pre>";print_r($data);echo "</pre>";exit;
        DB::table('erp_enquiry')->where('id', $enquiry_id)->update($data);

        return redirect()->route('erp_quote.lists')->with('success', 'Quotation has been rejected successfully');
    }

    public function getSurveydocument($id)
    {

        //echo $id;exit;
        $documents = DB::table('erp_vendor_surveydocuments')->where('inquiry_id', $id)->get();

        if ($documents->isEmpty()) {
            return response()->json(['success' => false, 'data' => []]);
        }

        // return list as JSON
        return response()->json([
            'success' => true,
            'data' => $documents
        ]);
    }
}
