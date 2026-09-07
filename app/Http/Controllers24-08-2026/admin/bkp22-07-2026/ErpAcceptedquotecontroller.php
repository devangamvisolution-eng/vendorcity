<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Route;
use App\Models\Admin\Erpdescriptionofgoods;
use Mpdf\Mpdf;

class ErpAcceptedquotecontroller extends Controller
{
    public function index()
    {
        $data['erp_enquiry_data'] = DB::table('erp_enquiry')->where('enquiry_level', 1)->where('survey_level', 1)->where('quote_level', 1)->where('accept_quote_level', 0)->orderBy('id', 'desc')->get();

        return view('admin.erp_acceptedquote.list', $data);
    }

    function sendmail($id)
    {

        $accept_inquiry = DB::table('erp_enquiry')->where('id', $id)->first();

        $customerName = $accept_inquiry->client_name;
        $customerEmail = $accept_inquiry->client_email;

        $price = $accept_inquiry->grand_total ?? 0;

        $inquiry_id = base64_encode($accept_inquiry->id);

        $payment_url = URL::to('/paymentstripe') . '/' . $inquiry_id;

        // echo "<pre>";print_r($payment_url);
        // echo "<pre>";print_r($accept_inquiry);exit;



        $html = '<!doctype html> <html>
        
       <head>
           <meta charset="utf-8">
           <title></title>
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
                   <img src="' . asset("public/admin/assets/img/logo.png") . '" style="width: 30%;" >
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
                                          Please find the below Payment details
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
                                               <tr>
													<td width="100px">Name: </td><td>' . $customerName . '</td>
												</tr>
                                                <tr>
													<td width="100px">Email: </td><td>' . $customerEmail . '</td>
												</tr>
                                                 <tr>
													<td width="100px">Quotation No: </td><td>' . $accept_inquiry->quote_id . '</td>
												</tr>
                                                <tr>
													
													<td width="100px">Amount: </td><td>' . $price . '</td>
												</tr>
												
												<tr>
													
													<td width="100px">Payment Link: </td><td>' . $payment_url . '</td>
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

        $salesmanData = DB::table('users')->where('id', $accept_inquiry->assign_to)->first();
        $salespersonEmail = $salesmanData->email ?? '';

        $subject = "Payment For - " . $accept_inquiry->description . ' ( ' . $accept_inquiry->quote_id . ' )' ?? "";
        $ccRecipients = ['devang.hnrtechnologies@gmail.com'];

        if (!empty($salespersonEmail)) {
            $ccRecipients[] = $salespersonEmail;
        }

        $to = $customerEmail;

        if ($customerEmail != '') {
            Mail::send([], [], function ($message) use ($html, $to, $subject, $ccRecipients) {
                $message->to($to);
                $message->subject($subject);
                foreach ($ccRecipients as $ccRecipient) {
                    $message->bcc($ccRecipient);
                }
                $message->html($html);
            });
            return redirect()->route('erp_acceptedquote.lists')->with('success', 'Mail Send Successfully.');
        } else {
            return redirect()->route('erp_acceptedquote.lists')->with('error', 'Something Went Wrong');
        }
    }

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

        $data['salesperson_data'] = DB::table('users')->where('role_id', '11')->where('is_active', 0)->where('vendor', 0)->get();

        $data['current_route'] = Route::currentRouteName();

        $data['servicedata'] = DB::table('services')->where('id', $data['followup_data']->service)->first();

        $data['descriptionofgoods'] = Erpdescriptionofgoods::latest('id')->get();

        //echo "<pre>"; print_r($data['servicedata']); die;
        return view('admin.erp_quote.add', $data);
    }

    // public function sendmailcustomer_ajax(Request $request)
    // {
    //     // echo "<pre>";
    //     // print_r($request->all());
    //     // die;

    //     $erp_enquiry_data = DB::table('erp_enquiry')->where('id', $request->enquiry_id)->first();

    //     if ($erp_enquiry_data) {

    //         $data = [
    //             'enquiry' => $erp_enquiry_data
    //         ];

    //         $update_data = DB::table('erp_enquiry')->where('id', $request->enquiry_id)->update(['mail_type' => $request->mail_type]);
    //         if ($update_data) {

    //             if ($request->mail_type == '1') {
    //                 $view = 'emails.normal';
    //                 $subject = 'New Booking Request - VendorsCity';
    //             } elseif ($request->mail_type == '2') {
    //                 $view = '';
    //                 $subject = "Move Confirmation & Storage Details – VendorsCity";
    //             } elseif ($request->mail_type == '3') {
    //                 $view = "";
    //                 $subject = "Warehouse Delivery & Storage Guidelines – VendorsCity";
    //             }

    //             Mail::send($view, $data, function ($message) use ($erp_enquiry_data, $subject) {
    //                 $message->to($erp_enquiry_data->client_email);
    //                 $message->subject($subject);
    //             });

    //             $status = 'success';
    //             $message = 'Mail Send Successfully.';

    //         } else {
    //             $status = 'error';
    //             $message = 'Something Went Wrong 1';
    //         }

    //     } else {
    //         $status = 'error';
    //         $message = 'No Data Found';
    //     }

    //     return response()->json(['status' => $status, 'message' => $message]);


    // }
    public function sendmailcustomer_ajax(Request $request)
    {
        // Validate
        $request->validate([
            'enquiry_id' => 'required|exists:erp_enquiry,id',
            'mail_type' => 'required|in:1,2,3'
        ]);

        // Get enquiry
        $enquiry = DB::table('erp_enquiry')
            ->where('id', $request->enquiry_id)
            ->first();

        // Mail config mapping
        $mailMap = [
            '1' => [
                'view' => 'emails.normal',
                'subject' => 'New Booking Request - VendorsCity'
            ],
            '2' => [
                'view' => 'emails.with_pickup',
                'subject' => 'Move Confirmation & Storage Details – VendorsCity'
            ],
            '3' => [
                'view' => 'emails.without_pickup',
                'subject' => 'Warehouse Delivery & Storage Guidelines – VendorsCity'
            ]
        ];

        $config = $mailMap[$request->mail_type];

        // Update mail type (no need to check result)
        DB::table('erp_enquiry')
            ->where('id', $request->enquiry_id)
            ->update([
                'mail_type' => $request->mail_type,
                'updated_at' => now()
            ]);

        // Send mail
        Mail::send($config['view'], ['enquiry' => $enquiry], function ($message) use ($enquiry, $config) {
            $message->to($enquiry->client_email)
                ->subject($config['subject'])
                ->bcc(['hello@vendorscity.com', 'zafar@quickserverelo.com']);
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Mail sent successfully'
        ]);
    }

    function addDocuments($id)
    {
        // echo $id;exit;
        $data['error'] = "";
        $data['id'] = $id;
        $data['existing_docs'] = DB::table('erp_accept_doc')
            ->where('enquiry_id', $id)
            ->get();

        return view('admin.erp_acceptedquote.adddocument', $data);
    }

    function addDocumentsstore(Request $request)
    {
        $enquiry_id = $request->enquiry_id;
        $titles = $request->title;
        $files = $request->file('documents');

        if ($titles && is_array($titles)) {
            foreach ($titles as $key => $title) {
                // Only process if both title and corresponding file are present
                if (isset($files[$key]) && $files[$key]->isValid()) {
                    $file = $files[$key];

                    // Generate unique filename
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    // Ensure directory exists and move file
                    $uploadPath = public_path('upload/erpacceptdocument');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }

                    $file->move($uploadPath, $filename);

                    // Insert into database
                    DB::table('erp_accept_doc')->insert([
                        'enquiry_id' => $enquiry_id,
                        'title'      => $title,
                        'document'   => $filename,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Documents Uploaded Successfully');
    }

    function deleteDocument(Request $request)
    {
        $id = $request->id;
        $doc = DB::table('erp_accept_doc')
            ->where('id', $id)
            ->first();

        if ($doc) {
            $filePath = public_path('upload/erpacceptdocument/' . $doc->document);

            // Delete physical file if exists
            if (file_exists($filePath) && !empty($doc->document)) {
                unlink($filePath);
            }

            // Delete database record
            DB::table('erp_accept_doc')->where('id', $id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Document deleted successfully'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Document not found'
        ]);
    }
    public function assignwarehouse($id)
    {
        $data['id'] = $id;
        $data['enquiry'] = DB::table('erp_enquiry')->where('id', $id)->first();
        $data['assignment'] = DB::table('erp_assign_warehouse')->where('enquiry_id', $id)->first();

        return view('admin.erp_acceptedquote.assignwarehouse', $data);
    }

    function assignwarehousestore(Request $request)
    {
        $enquiry_id = $request->enquiry_id;
        $exists = DB::table('erp_assign_warehouse')->where('enquiry_id', $enquiry_id)->first();

        $data = [
            'agreement_date' => $request->agreement_date,
            'warehouse_name' => $request->warehouse_name,
            'unit_no' => $request->unit_no,
            'emirate_id' => $request->emirate_id,
            'trade_license' => $request->trade_license,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'updated_at' => now(),
        ];

        if ($exists) {
            DB::table('erp_assign_warehouse')->where('enquiry_id', $enquiry_id)->update($data);
            $msg = 'Warehouse Assignment Updated Successfully';
        } else {
            $data['enquiry_id'] = $enquiry_id;
            $data['created_at'] = now();
            DB::table('erp_assign_warehouse')->insert($data);
            $msg = 'Warehouse Assigned Successfully';
        }

        return redirect()->back()->with('success', $msg);
    }

    function agreement($id, Request $request)
    {
        $data['erpEnquiryData'] = $erpEnquiryData = DB::table('erp_enquiry')->where('id', $id)->first();
        $data['documents'] = DB::table('erp_accept_doc')->where('enquiry_id', $id)->get();

        $data['cc_email_data'] = [
            (object) ['email' => 'hello@vendorscity.com'],
            (object) ['email' => 'zafar@quickserverelo.com'],
        ];

        $data['id'] = $id;

        $data['mail_html'] = "Dear " . $erpEnquiryData->client_name . ",
<br/><br/>
Please find the storage agreement attached to this email.
<br/><br/>
Kindly review the document, sign it and return it to us at your earliest convenience.
<br/><br/>
Thank you for choosing VendorsCity. We appreciate your trust in us.";

        $data['mail_subject'] = $erpEnquiryData->client_name . ' - Storage Agreement -' . ' ( ' . $erpEnquiryData->quote_id . ' )' ?? "";

        return view('admin.erp_acceptedquote.agreement', $data);
    }

    public function sendAgreementMail(Request $request)
    {
        $enquiry_id = $request->enquiry_id;
        $to_input = $request->to_mail;
        $subject = $request->mail_subject;
        $html = $request->mail_content;

        $erpEnquiryData = DB::table('erp_enquiry')->where('id', $request->enquiry_id)->first();

        // Parse "To" field for multi-comma support
        $emails = array_map('trim', explode(',', $to_input));
        $to = $erpEnquiryData->client_email;
        $extra_cc = array_slice($emails, 1);

        // Merge extra CCs with checkboxes
        $checkbox_cc = $request->cc_email ?? [];
        $final_cc = array_unique(array_filter(array_merge($extra_cc, $checkbox_cc)));

        $documents = DB::table('erp_accept_doc')->where('enquiry_id', $enquiry_id)->get();
        $warehouseData = DB::table('erp_assign_warehouse')->where('enquiry_id', $enquiry_id)->first();

        $costing = DB::table('costing_attribute')
            ->where('enquiry_id', $enquiry_id)
            ->get();

        $data['costing_attribute'] = $costing;

        // ✅ Find Storage Rent (any row)
        $storage = $costing->first(function ($item) {
            return stripos($item->description, 'Storage Rent') !== false;
        });

        // ✅ Find Security Deposit (any row)
        $security = $costing->first(function ($item) {
            return stripos($item->description, 'Security Deposit') !== false;
        });

        // Amounts
        $storageAmount = $storage->total ?? 0;
        $securityAmount = $security->total ?? 0;

        // VAT ONLY for Storage
        $vatEnabled = $data['enquiryData']->vat_charge ?? 0;

        if ($vatEnabled == 1) {
            $vatAmount = ($storageAmount * 5) / 100;
            $storageFinal = $storageAmount + $vatAmount;
        } else {
            $vatAmount = 0;
            $storageFinal = $storageAmount;
        }

        // Pass data
        $data['storageAmount'] = $storageAmount;
        $data['storageFinal'] = $storageFinal;
        $data['vatAmount'] = $vatAmount;
        $data['vatEnabled'] = $vatEnabled;

        $data['securityAmount'] = $securityAmount;
        $data['hasSecurity'] = $security ? true : false;

        // Prepare the PDF for attachment
        $pdf_html = view('admin.erp_acceptedquote.agreement_pdf', [
            'enquiryData' => $erpEnquiryData,
            'warehouseData' => $warehouseData,
            'storageAmount' => $data['storageAmount'],
            'storageFinal' => $data['storageFinal'],
            'vatAmount' => $data['vatAmount'],
            'vatEnabled' => $data['vatEnabled'],
            'securityAmount' => $data['securityAmount'],
            'hasSecurity' => $data['hasSecurity']
        ])->render();

        // $mpdf = new Mpdf([
        //     'mode' => 'utf-8',
        //     'format' => 'A4',
        //     'margin_left' => 10,
        //     'margin_right' => 10,
        //     'margin_top' => 10,
        //     'margin_bottom' => 10,
        // ]);
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'tempDir' => storage_path('app/mpdf'),
        ]);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML($pdf_html);
        $pdf_content = $mpdf->Output('', 'S'); // 'S' for return as string
        $pdf_filename = 'Storage_Agreement_' . ($erpEnquiryData->quote_id ?? 'Request') . '.pdf';

        Mail::send([], [], function ($message) use ($to, $subject, $html, $final_cc, $documents, $pdf_content, $pdf_filename) {
            $message->to($to)
                ->subject($subject)
                ->html($html);

            // Attach the generated PDF
            $message->attachData($pdf_content, $pdf_filename, [
                'mime' => 'application/pdf',
            ]);

            foreach ($final_cc as $cc) {
                if (!empty($cc)) {
                    $message->bcc($cc);
                }
            }

            foreach ($documents as $doc) {
                $filePath = public_path('upload/erpacceptdocument/' . $doc->document);
                if (file_exists($filePath)) {
                    $message->attach($filePath, ['as' => $doc->title . '.' . pathinfo($doc->document, PATHINFO_EXTENSION)]);
                }
            }
        });

        return redirect()->back()->with('success', 'Agreement Mail and PDF Sent Successfully.');
    }

    function agreement_download(Request $request)
    {
        $enquiry_id = $request->enquiry_id;
        $data['enquiryData'] = DB::table('erp_enquiry')->where('id', $enquiry_id)->first();
        $data['warehouseData'] = DB::table('erp_assign_warehouse')->where('enquiry_id', $enquiry_id)->first();

        $costing = DB::table('costing_attribute')
            ->where('enquiry_id', $enquiry_id)
            ->get();

        $data['costing_attribute'] = $costing;

        // ✅ Find Storage Rent (any row)
        $storage = $costing->first(function ($item) {
            return stripos($item->description, 'Storage Rent') !== false;
        });

        // ✅ Find Security Deposit (any row)
        $security = $costing->first(function ($item) {
            return stripos($item->description, 'Security Deposit') !== false;
        });

        // Amounts
        $storageAmount = $storage->total ?? 0;
        $securityAmount = $security->total ?? 0;

        // VAT ONLY for Storage
        $vatEnabled = $data['enquiryData']->vat_charge ?? 0;

        if ($vatEnabled == 1) {
            $vatAmount = ($storageAmount * 5) / 100;
            $storageFinal = $storageAmount + $vatAmount;
        } else {
            $vatAmount = 0;
            $storageFinal = $storageAmount;
        }

        // Pass data
        $data['storageAmount'] = $storageAmount;
        $data['storageFinal'] = $storageFinal;
        $data['vatAmount'] = $vatAmount;
        $data['vatEnabled'] = $vatEnabled;

        $data['securityAmount'] = $securityAmount;
        $data['hasSecurity'] = $security ? true : false;

        $html = view('admin.erp_acceptedquote.agreement_pdf', $data)->render();

        // $mpdf = new Mpdf([
        //     'mode' => 'utf-8',
        //     'format' => 'A4',
        //     'margin_left' => 10,
        //     'margin_right' => 10,
        //     'margin_top' => 10,
        //     'margin_bottom' => 10,
        // ]);
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'tempDir' => storage_path('app/mpdf'),
        ]);

        $mpdf->SetTitle('Storage Agreement - ' . ($data['enquiryData']->quote_id ?? 'Agreement'));
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML($html);

        $fileName = 'Storage_Agreement_' . ($data['enquiryData']->quote_id ?? 'Agreement') . '.pdf';

        return $mpdf->Output($fileName, 'D'); // 'D' for forcing download
    }
}
