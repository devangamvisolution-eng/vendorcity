<?php



namespace App\Http\Controllers\admin;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Admin\Googlereview;



class GooglereviewController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $data['country_data']=Googlereview::orderBy('id','desc')->get();

        return view('admin.list_googlereview',$data);

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('admin.add_googlereview');

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $country= new Googlereview;

        $country->label=$request->label;
        $country->description=$request->description;
        $country->name=$request->name;

        

        $country->save();

        return redirect()->route('google_review.index')->with('success','Google Review Added Successfully');

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

        //echo "sd".$id;exit;
         $googlereview = Googlereview::findOrFail($id);

         //echo "<pre>";print_r($Googlereview);echo"</pre>";exit;

       return view('admin.edit_googlereview',compact('googlereview'));

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

        $country = Googlereview::find($id);

        $country->label     = $request->label;
        $country->description     = $request->description;
        $country->name     = $request->name;

       

        $country->save();



        return redirect()->route('google_review.index')->with('success', 'Google Review Updated Successfully');

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

      

        Googlereview::whereIn('id',$delete_id)->delete();

        return redirect()->route('google_review.index')->with('success','Google Review Deleted Successfully');

    }

}