<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Time_Slot_PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['time_data']=DB::table('subservice_timeslot_price')->orderBy('id','DESC')->groupBy('subservice_id')->get();
        
        return view('admin.list_time_slot_price',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['service_data'] = DB::table('services')->select('*')->orderBy('id','DESC')->get();

        $data['subservice_data'] = DB::table('subservices')->select('*')->orderBy('id','DESC')->get();
        $data['time_slot']=DB::table('time_slots')->orderBy('set_order','ASC')->get();
        return view('admin.add_time_slot_price',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //echo"<pre>";print_r($request->all());echo"</pre>";exit;

        if (count($request['time_slot_id']) > 0 && $request['time_slot_id'] != '') {

            for ($i = 0; $i < count($request['time_slot_id']); $i++) {
    
                if($request['time_slot_id'][$i] != ''){
    
                    $content['time_slot_id'] = $request['time_slot_id'][$i];    
                    $content['price'] = $request['price'][$i]; 
                    $content['service_id'] = $request->input('service_id'); 
                    $content['subservice_id'] = $request->input('subservice_id'); 
                    $content['is_active'] = $request['is_active'][$i]; 

                    $subservice_timeslot_price = DB::table('subservice_timeslot_price')
                                                ->where('time_slot_id',$content['time_slot_id'])
                                                ->where('subservice_id',$content['subservice_id'])
                                                ->first();

                    //echo"<pre>";print_r($content);echo"</pre>";exit;


                    if(isset($subservice_timeslot_price) && !empty($subservice_timeslot_price)){
                        $content['id'] = $subservice_timeslot_price->id; 
                        $this->update_subservice_timeslot_price($content);
                    }else{
                        $this->insert_subservice_timeslot_price($content);
                    }
                    //echo"<pre>";print_r($subservice_timeslot_price);echo"</pre>";
                    //$this->update_home_price($content);
                }                    
            }
    
        }

        return redirect()->route('time_slot_price.index')->with('success', 'Time Slot  Price  Added Successfully');
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
        $data['service_data'] = DB::table('services')->select('*')->orderBy('id','DESC')->get();

        $data['time_data'] = DB::table('subservice_timeslot_price')->where('id', $id)->first();

        $data['subservice_data'] = DB::table('subservices')->where('serviceid',$data['time_data']->service_id)->select('*')->orderBy('id','DESC')->get();
        $data['time_slot']=DB::table('time_slots')->orderBy('set_order','ASC')->get();

        $data['id'] = $id;

        return view('admin.edit_time_slot_price',$data);
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
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;

        if (count($request['time_slot_id']) > 0 && $request['time_slot_id'] != '') {

            for ($i = 0; $i < count($request['time_slot_id']); $i++) {
    
                if($request['time_slot_id'][$i] != ''){
    
                    $content['time_slot_id'] = $request['time_slot_id'][$i];    
                    $content['price'] = $request['price'][$i]; 
                    $content['service_id'] = $request->input('service_id'); 
                    $content['subservice_id'] = $request->input('subservice_id'); 
                    $content['is_active'] = $request['is_active'][$i]; 

                    $subservice_timeslot_price = DB::table('subservice_timeslot_price')
                                                ->where('time_slot_id',$content['time_slot_id'])
                                                ->where('subservice_id',$content['subservice_id'])
                                                ->first();

                    // echo"<pre>";print_r($content);echo"</pre>";exit;


                    if(isset($subservice_timeslot_price) && !empty($subservice_timeslot_price)){
                        $content['id'] = $subservice_timeslot_price->id; 
                        $this->update_subservice_timeslot_price($content);
                    }else{
                        $this->insert_subservice_timeslot_price($content);
                    }
                    //echo"<pre>";print_r($subservice_timeslot_price);echo"</pre>";
                    //$this->update_home_price($content);
                }                    
            }
    
        }


        

        return redirect()->route('time_slot_price.index')->with('success', 'Time Slot  Price  Update Successfully');

       // exit;
    }

    function update_subservice_timeslot_price($content){
        $data['time_slot_id'] = $content['time_slot_id'];    
        $data['price'] = $content['price'];    
        $data['service_id'] = $content['service_id'];    
        $data['subservice_id'] = $content['subservice_id'];    
        $data['is_active'] = $content['is_active'];    

        DB::table('subservice_timeslot_price')->where('id', $content['id'])->update($data);
    }

    function insert_subservice_timeslot_price($content){
        $data['time_slot_id'] = $content['time_slot_id'];    
        $data['price'] = $content['price'];    
        $data['service_id'] = $content['service_id'];
        $data['subservice_id'] = $content['subservice_id'];    
        $data['is_active'] = $content['is_active'];    

        DB::table('subservice_timeslot_price')->insert($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //echo"<pre>";print_r($request->all());echo"</pre>";
        $id=$request->selected;
        if(isset($id) && count($id) > 0){

            foreach($id as $key => $value){
                $datatime = DB::table('subservice_timeslot_price')->where('id',$value)->first();

                DB::table('subservice_timeslot_price')->where('service_id',$datatime->service_id)->where('subservice_id',$datatime->subservice_id)->delete();
                //echo"<pre>";print_r($datatime->subservice_id);echo"</pre>";
            }
        }
        //exit;
        // $datatime = DB::table('subservice_timeslot_price')->whereIn('id',$id)->delete();
        return redirect()->route('time_slot_price.index')->with('success','Time slot Data Deleted Successfully');
    }
}