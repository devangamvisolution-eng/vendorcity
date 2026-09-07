<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ErpRejectedquotecontroller extends Controller
{
    public function index()
    {
        $data['erp_enquiry_data'] = DB::table('erp_enquiry')->where('quote_level',2)->where('is_reject',1)->orderBy('id','desc')->get();

        return view('admin.erp_rejectedquote.list',$data);
    }

    function reasonget(Request $request)
    {
        $id = $request->id;
        $reason = DB::table('erp_enquiry')->where('id', $id)->value('reject_reason');
        if (!$reason) {
            return response()->json(['error' => 'No reason found for this enquiry.'], 404);
        }
        // Return the reason as a JSON response
        return response()->json(['reason' => $reason]);
    }

    
}
