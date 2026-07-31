<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Cleaning_PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.edit_cleaning_price');
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
    public function edit()
    {
        // echo"<pre>";print_r($id);echo"</pre>";exit;
        // $data['cleaning_price_data'] = DB::table('cleanin_subserviceprice')->whereIn('subservice_id', ['28','30'])->get();  

        // echo"<pre>";print_r($data);echo"</pre>";exit;

        return view('admin.edit_cleaning_price');
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
    if (count($request['hourly_price_home']) > 0 && $request['hourly_price_home'] != '') {

        for ($i = 0; $i < count($request['hourly_price_home']); $i++) {

            if($request['hourly_price_home'][$i] != ''){

                $content['hourly_price_home'] = $request['hourly_price_home'][$i];    
                
                $content['update_homecleaningid'] = $request['update_homecleaningid'][$i];
                
                $this->update_home_price($content);
            }                    
        }

    }
    if (count($request['hourly_price_office']) > 0 && $request['hourly_price_office'] != '') {

        for ($i = 0; $i < count($request['hourly_price_office']); $i++) {

            if($request['hourly_price_office'][$i] != ''){

                $content['hourly_price_office'] = $request['hourly_price_office'][$i];    
                
                $content['update_officecleaningid'] = $request['update_officecleaningid'][$i];
                
                $this->update_office_price($content);
            }                    
        }

    }
        return redirect()->route('cleaning_price.index')->with('success', 'Hourly Price value Update Successfully');
    }

    function update_home_price($content){
        // echo"<pre>";print_r($content);echo"</pre>";exit;
        $data['hourly_price'] = $content['hourly_price_home'];    

        DB::table('cleanin_subserviceprice')->where('id', $content['update_homecleaningid'])->update($data);
    }

    function update_office_price($content){
        // echo"<pre>";print_r($content);echo"</pre>";exit;
        $data['hourly_price'] = $content['hourly_price_office'];    

        DB::table('cleanin_subserviceprice')->where('id', $content['update_officecleaningid'])->update($data);
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