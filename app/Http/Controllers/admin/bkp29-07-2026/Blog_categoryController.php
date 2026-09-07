<?php



namespace App\Http\Controllers\admin;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Image;

use DB;

use App\Models\admin\Blog;



class Blog_categoryController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $data['blog_category_data']=DB::table('blog_category')->orderBy('id','DESC')->get();

      

        return view('admin.list_blog_category',$data);

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {
        return view('admin.add_blog_category');

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
        $data['name'] = $request->input('name');

        $data['page_url'] = $request->input('page_url');

        DB::table('blog_category')->insert($data);

        return redirect()->route('blog_category.index')->with('success', 'Blog Category Added Successfully');

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

        $data['blog_category_data'] = DB::table('blog_category')->where('id', $id)->first();

        return view('admin.edit_blog_category',$data);

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

        $data['name'] = $request->input('name');

        $data['page_url'] = $request->input('page_url');
          
        DB::table('blog_category')->where('id', $id)->update($data);

        return redirect()->route('blog_category.index')->with('success','Blog Category Updated Successfully');

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

        DB::table('blog_category')->whereIn('id',$delete_id)->delete();

        return redirect()->route('blog_category.index')->with('success','Blog Category has been deleted successfully');

    }
   }