<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Helper;

class Vendorquotecontroller extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $data['erp_enquiry_data'] = DB::table('erp_enquiry')->where('enquiry_level',1)->where('survey_level',1)->where('quote_level',0)->where('surveyor',$userId)->orderBy('id','desc')->get();

        return view('admin.vendor_quote.list',$data);
    }

    public function getSurveyDetails($id)
    {
        //$id = 14;
        $data = DB::table('erp_enquiry')->where('id', $id)->first();

        if ($data) {

            if ($data->service == '30') {

                $countryname = Helper::countryname($data->origin_country);
                $originParts = [
                    $data->origin_add ?? '',
                    $data->origin_location ?? '',
                    $data->origin_city ?? '',
                    $data->origin_state ?? '',
                    $countryname ?? '',
                    $data->origin_zip_post ?? '',
                ];
                $fullOriginAddress = implode(', ', array_filter($originParts));

                // destination
                $countrynamedesti = Helper::countryname($data->desti_country);
                $originPartsDesti = [
                    $data->desti_add ?? '',
                    $data->desti_location ?? '',
                    $data->desti_city ?? '',
                    $data->desti_state ?? '',
                    $countrynamedesti ?? '',
                    $data->desti_zip_post ?? '',
                ];
                $fullDestiAddress = implode(', ', array_filter($originPartsDesti));

            // Decide what to return
            
                $address = [
                    'origin' => $fullOriginAddress,
                    'desti' => $fullDestiAddress,
                ];
            } else {
                $address = [
                    'client' => $data->address,
                ];
            }


            return response()->json([
                'success' => true,
                'data' => $data,   // returns all columns
                'address' => $address,
            ]);
        }

        return response()->json(['success' => false]);
    }

    function uploaddocument($id){
        //echo $id;exit;
        $data['id'] = $id;
        $data['erp_vendor_surveydocuments'] = DB::table('erp_vendor_surveydocuments')->where('inquiry_id',$id)->get();

        $inquiryData = DB::table('erp_enquiry')->where('id',$id)->first();

        $data['volume_in_cbm'] = $inquiryData->volume_in_cbm ?? '';

        return view('admin.vendor_quote.uploaddocument',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'document.*' => 'nullable|max:2048'
        ]);

        $inquiryId = $request->input('inquiry_id_hidden');

        if($request->hasFile('document')){
            foreach($request->file('document') as $file){

                $originalName = $file->getClientOriginalName();
                $safeName = str_replace(' ', '-', $originalName);
                $customName = time() . '-' . $safeName;
                //$filePath = $file->storeAs('upload/erp_vendor_surveydocuments', $customName, 'public');
                $destinationPath = public_path('upload/erp_vendor_surveydocuments');
                $file->move($destinationPath, $customName);

                DB::table('erp_vendor_surveydocuments')->insert([
                    'inquiry_id'  => $inquiryId,
                    'document'   => $customName,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);

            }
        }

        if($request->input('volume_in_cbm')){

            $data['volume_in_cbm'] = $request->volume_in_cbm;
            DB::table('erp_enquiry')->where('id',$inquiryId)->update($data);

        }

        return  redirect()->route('vendorquote.lists')->with('success', 'Document has been added successfully');

    }

    public function deleteDoc($id)
    {
        $document = DB::table('erp_vendor_surveydocuments')->where('id', $id)->first();

        //echo"<pre>";print_r($document);exit;

        if ($document) {
            // Delete file from folder
            $filePath = public_path('upload/erp_vendor_surveydocuments/' . $document->document);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete from DB
            DB::table('erp_vendor_surveydocuments')->where('id', $id)->delete();

            return response()->json(['status' => 'success', 'message' => 'Document deleted successfully']);
        }

        return response()->json(['status' => 'error', 'message' => 'Document not found'], 404);
    }
}
