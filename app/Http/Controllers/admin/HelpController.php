<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['help']=DB::table('help')->orderBy('id','DESC')->get();

        return view('admin.list_help',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        
        $data['allsubservices'] = DB::table('subservices')->where('is_active',0)->orderBy('id','desc')->get();

        return view('admin.add_help',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $data = [
        'subservice' => is_array($request->packages) ? implode(',', $request->packages) : null,
        'question' => $request->question,
        'answers' => $request->answer,
       ];

        DB::table('help')->insert($data);

        return redirect()->route('help.index')->with('success','Help Data Added Successfully');

       
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
    public function edit(Request $request,$id)
    {
        $help = DB::table('help')->where('id', $id)->first();

        $allsubservices = DB::table('subservices')->where('is_active', 0)->orderBy('id', 'desc')->get();

         return view('admin.edit_help', compact('help', 'allsubservices'));
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
        $data = [
        'subservice' => is_array($request->packages) ? implode(',', $request->packages) : null,
        'question' => $request->question,
        'answers' => $request->answer,
       ];

        DB::table('help')->where('id',$id)->update($data);

        return redirect()->route('help.index')->with('success','Help Data Updated Successfully');

    }

    public function destroy(Request $request)
    {
        $id=$request->selected;

        DB::table('help')->where('id',$id)->delete();

        return redirect()->route('help.index')->with('success','Help Data Deleted Successfully');
    }

    public function appointment_status(){

        $id=$_POST['id'];

        $value=$_POST['value'];       

        DB::table('help')->where('id',$id)->update(array('appointment'=>$value));

        echo"1";

    }
    public function ticket_status(){

        $id=$_POST['id'];

        $value=$_POST['value'];       

        DB::table('help')->where('id',$id)->update(array('ticket'=>$value));

        echo"1";

    }
}