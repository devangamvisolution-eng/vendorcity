<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data['systems'] = DB::table('system')->where('id', '=',  $id)->first();   
        $data['allcity'] =  DB::table('cities')->where('country',22)->get(); 
        $data['system_attribute'] = DB::table('system_attribute')
                                        ->select('*')                            
                                        ->where('system_id', '=',$id)                            
                                        ->get()                            
                                        ->toArray();      
        return view('admin.edit_systems',$data);
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
        
        $data['percentage']= $request->percentage;
        $data['weekly_percentage']= $request->weekly_percentage;
        $data['multiple_time_week']= $request->multiple_time_week;

        DB::table('system')->where('id',$id)->update($data);

         if (count($_POST['city_addmore_third1']) > 0 && $_POST['city_addmore_third1'] != '') {
            for ($i = 0; $i < count($_POST['city_addmore_third1']); $i++) {    
               
                if($_POST['city_addmore_third1'][$i] != ''){
                    $content['system_id'] = $id;
                    $content['city'] = $_POST['city_addmore_third1'][$i];  
                    $content['meta_title'] = $_POST['meta_title_addmore1'][$i];    
                    $content['meta_keyword'] = $_POST['meta_keyword_addmore1'][$i];    
                    $content['meta_description'] = $_POST['meta_description_addmore1'][$i];    
                    $this->insert_attribute($content);    
                }    
            }    
        }

        if (isset($_POST['city_addmore_thirdu']) && count($_POST['city_addmore_thirdu']) > 0 && $_POST['city_addmore_thirdu'] != '') {
            for ($i = 0; $i < count($_POST['city_addmore_thirdu']); $i++) {

                if($_POST['city_addmore_thirdu'][$i] != ''){
                    $content['system_id'] = $id;
                    $content['city'] = $_POST['city_addmore_thirdu'][$i];  
                    $content['meta_title'] = $_POST['meta_title_addmoreu'][$i];    
                    $content['meta_keyword'] = $_POST['meta_keyword_addmoreu'][$i];    
                    $content['meta_description'] = $_POST['meta_description_addmoreu'][$i]; 
                    $content['updateid1xxx2'] = $_POST['updateid1xxx2'][$i];   
                    $this->update_attribute($content);    
                }    
            }    
        }

        return redirect()->route('system.edit',$id)->with('success', 'Systems Percentage Update Successfully');

    }

    function insert_attribute($content){
        $data['system_id'] = $content['system_id'];      
        $data['city'] = $content['city'];
        $data['meta_title'] = $content['meta_title'];
        $data['meta_keyword'] = $content['meta_keyword'];
        $data['meta_description'] = $content['meta_description'];
        DB::table('system_attribute')->insertGetId($data);

    }


    function update_attribute($content){
        $data['system_id'] = $content['system_id'];      
        $data['city'] = $content['city'];
        $data['meta_title'] = $content['meta_title'];
        $data['meta_keyword'] = $content['meta_keyword'];
        $data['meta_description'] = $content['meta_description'];
        DB::table('system_attribute')->where('id', $content['updateid1xxx2'])->update($data);
     }

     function removed_system_att (Request $request){
        $system_id = $request->pid;

        $id = $request->id;

        $result = DB::table('system_attribute')->where('system_id', '=',$system_id)->where('id', '=',$id)->delete();

        return redirect()->route('system.edit',$system_id)->with('success','Systems attribute deleted successfully');
        

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