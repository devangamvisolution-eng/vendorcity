<?php



namespace App\Http\Controllers\admin;



use App\Models\admin\Cms;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;



class CmsController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $data['cms_data']=Cms::orderBy('id','desc')->get();        

        return view('admin.list_cms',$data);

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('admin.add_cms');

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        // echo"<pre>";print_r($request->post());echo"</pre>";exit;

        $cms= new Cms;

        $cms->name              =   $request->name;

        $cms->description       =   $request->description;

        $cms->meta_title        =   $request->meta_title;

        $cms->meta_keyword      =   $request->meta_keyword;

        $cms->meta_description  =   $request->meta_description;

        $cms->save();

        return redirect()->route('cms.index')->with('success','CMS Added Successfully');



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

        $data['cms'] = Cms::where('id', '=',  $id)->first();

        return view('admin.edit_cms',$data);

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

        $cms= Cms::find($id);

        $cms->name              =   $request->name;

        $cms->description       =   $request->description;

        $cms->meta_title        =   $request->meta_title;

        $cms->meta_keyword      =   $request->meta_keyword;

        $cms->meta_description  =   $request->meta_description;

        $cms->save();

        return redirect()->route('cms.index')->with('success','CMS  Updated Successfully');

        

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy(Request $request)

    {

        $id=$request->selected;

        Cms::whereIn('id',$id)->delete();

        return redirect()->route('cms.index')->with('success','CMS Deleted Successfully');



    }

}