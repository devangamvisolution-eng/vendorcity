<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class Vendorbookedtimeslotcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata'] = DB::table('carwashvendor_bookedtimeslot')->orderBy('id','desc')->get();
        return view('admin.vendorbookedtimeslot.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['error'] = "";
        $data['service_data'] = DB::table('services')->select('*')->where('id',50)->orderBy('id','DESC')->get();
        $data['time_slots'] = DB::table('time_slots')->select('*')->orderBy('set_order','asc')->get();
        $data['carvendor'] = DB::table('users')->where('is_active',0)->whereRaw("FIND_IN_SET(?, serviceList)", [50])->get();

        //echo"<pre>";print_r($data);echo"</pre>";exit;
        return view('admin.vendorbookedtimeslot.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;
        $data['service_id'] = $request->service_id;
        $data['subservice_id'] = $request->subservice_id;
        $data['vendor_id'] = $request->vendor_id;
        $data['timeslot_id'] = $request->timeslot_id;
        $data['booked_date'] = $request->booked_date;

        DB::table('carwashvendor_bookedtimeslot')->insert($data);

        return redirect()->route('vendorbookedtimeslot.lists')->with('success', 'Vendor Booked Timeslot  Added Successfully');

        //echo"<pre>";print_r($data);echo"</pre>";exit;
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
        $data['service_data'] = DB::table('services')->select('*')->where('id',50)->orderBy('id','DESC')->get();

        $data['carwashvendor_bookedtimeslot'] = DB::table('carwashvendor_bookedtimeslot')->where('id', $id)->first();

        $data['subservice_data'] = DB::table('subservices')->where('serviceid',$data['carwashvendor_bookedtimeslot']->service_id)->select('*')->orderBy('id','DESC')->get();
        $data['time_slots']=DB::table('time_slots')->orderBy('set_order','ASC')->get();
        $data['carvendor'] = DB::table('users')->where('is_active',0)->whereRaw("FIND_IN_SET(?, serviceList)", [50])->get();

        $data['id'] = $id;

        return view('admin.vendorbookedtimeslot.edit',$data);

       
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
        $data['service_id'] = $request->service_id;
        $data['subservice_id'] = $request->subservice_id;
        $data['vendor_id'] = $request->vendor_id;
        $data['timeslot_id'] = $request->timeslot_id;
        $data['booked_date'] = $request->booked_date;

        DB::table('carwashvendor_bookedtimeslot')->where('id', $id)->update($data);

         return redirect()->route('vendorbookedtimeslot.lists')->with('success', 'Vendor Booked Timeslot  Updated Successfully');
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
        DB::table('carwashvendor_bookedtimeslot')->whereIn('id',$delete_id)->delete();
        return redirect()->route('vendorbookedtimeslot.lists')->with('success','Vendor Booked Timeslot deleted successfully.');
    }
}
