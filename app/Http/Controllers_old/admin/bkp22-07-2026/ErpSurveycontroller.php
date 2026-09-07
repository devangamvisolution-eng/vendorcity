<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class ErpSurveycontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['erp_enquiry_data'] = DB::table('erp_enquiry')->where('enquiry_level',1)->where('survey_level',0)->get();

        return view('admin.erp_survey.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $enquiry_id = $_GET['enquiry_id'];
        $data['followup_data'] = DB::table('erp_enquiry')->where('id',$enquiry_id)->first();
        $data['country_data'] = DB::table('countries')->get();
        $data['surveyor_type'] = DB::table('surveyor_type')->get();
        $data['vendors_data']=DB::table('users')->where('vendor',1)->where('is_active',0)->orderBy('id','DESC')->get()->toArray();

        $data['enquiry_status'] = DB::table('enquiry_status_remark')
                                        ->where('enquiry_id', '=', $enquiry_id)
                                        ->orderBy('id', 'DESC')
                                        ->first() ?? (object) ['status' => null];

        return view('admin.erp_survey.add',$data);
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

        $data['survey_type'] = $request->survey_type;
        $data['surveyor'] = $request->surveyor_name;
        $data['s_date'] = $request->survey_date;
        $data['map_link'] = $request->map_link;
        //$data['status'] = $request->status_id;
        

        if($request->status_id == 2){
            $enquiryId = sprintf('%06d', $inquiry_id);
            $currentYear = date('Y');
            $data['quote_id']  = 'QUO-'.$currentYear.'-'.$enquiryId;
            $data['survey_level']   = 1;
        }

        DB::table('erp_enquiry')->where('id',$inquiry_id)->update($data);

        $userId = Auth::id();
        $data_status['user_id']         = $userId;
        $data_status['enquiry_id']      = $inquiry_id;
        $data_status['status']          = $request->status_id;
        $data_status['enquiry_level']   = 1;
        $data_status['notes'] = $request->notes;

        DB::table('enquiry_status_remark')->insert($data_status);

        return redirect()->route('erp_survey.lists')->with('success','Survey Added Successfully');
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
}
