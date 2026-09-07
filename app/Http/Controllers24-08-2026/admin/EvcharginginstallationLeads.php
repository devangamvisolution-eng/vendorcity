<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class EvcharginginstallationLeads extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $startdate = $request->s_date;
        $enddate = $request->e_date;
        $servicename = $request->servicename;
        $all_search = $request->all_search;

        $query = DB::table('packages_enquiry')->where('subservice_id', 94);

        if ($startdate !='')
        {   
            $query = $query->where('added_date', '>=', date('Y-m-d', strtotime($startdate)));
        }

        if ($enddate !='')
        {   
            $query = $query->where('added_date', '<=', date('Y-m-d', strtotime($enddate)));
        }    

        if ($all_search != '') {
            $query->where(function($q) use ($all_search) {
                $q->where('name', 'LIKE', "%{$all_search}%")
                ->orWhere('email', 'LIKE', "%{$all_search}%")
                ->orWhere('mobile', 'LIKE', "%{$all_search}%")
                ->orWhere('inquiry_id', 'LIKE', "%{$all_search}%");
            });
        }
        
        

        $data['startdate'] =$startdate;
        $data['enddate'] =$enddate;
        $data['all_search'] =$all_search;

        $data['service_data']=DB::table('services')->get();

        $data['system']=DB::table('system')->first();

        $data['customer_data'] = DB::table('packages_enquiry')->groupBy('name')->get();

        $data['packages_data'] = $query->orderBy('id','DESC')->get();
        
        return view('admin.ev_charging_installation.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    function details($enquiry_id){
        $data['packages_enquiry']=DB::table('more_formfields_details')->where('package_inquiry_id',$enquiry_id)->get();
        return view('admin.ev_charging_installation.details',$data);
    }
}
