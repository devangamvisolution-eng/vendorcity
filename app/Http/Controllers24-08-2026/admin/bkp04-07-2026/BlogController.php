<?php



namespace App\Http\Controllers\admin;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Image;

use DB;

use App\Models\admin\Blog;
use Illuminate\Http\JsonResponse;



class BlogController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $data['blog_data']=Blog::orderBy('id','DESC')->get();

      

        return view('admin.list_blog',$data);

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {
        $data['service_data']=DB::table('services')->orderBy('id','DESC')->select('*')->get();

        $data['blog_category_data']=DB::table('blog_category')->orderBy('id','DESC')->select('*')->get();

        return view('admin.add_blog',$data);

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

        $data['blog_category'] = $request->input('blog_category');

        $data['title'] = $request->input('title');

        $data['blog_url'] = $request->input('blog_url');

        $data['date'] = $request->input('date');

        $data['short_description'] = $request->input('short_description');

        $data['description'] = $request->input('description');

        $data['service'] = $request->input('service');

        $data['subservice'] = $request->input('subservice');

        $data['metatitle'] = $request->input('metatitle');

        $data['metadescription'] = $request->input('metadescription');
        $data['image_alt_tag'] = $request->input('image_alt_tag');

          if($request->hasfile('image') != ''){
            $image = $request->file('image');
            $remove_space = str_replace(' ', '-', $image->getClientOriginalName());
            $data['image'] = time().$remove_space;
           $destination_path = public_path('upload/blog/large');
           $img = Image::make($image->path());
           $width = 970;
           $height = 400;
           $img->resize($width,$height,function($contrainst){
           })->save($destination_path."/".$data['image']);
           $destination_path = public_path('upload/blog/detail');
           $img = Image::make($image->path());
           $width = 1400;
           $height = 575;
           $img->resize($width,$height,function($contrainst){
           })->save($destination_path."/".$data['image']);
           $width = 70;
           $height = 70;
           $destination_path = public_path('upload/blog/small');
           $img->resize($width,$height,function($constraint){
           })->save($destination_path."/".$data['image']);
           $destinationPath = public_path('upload/blog');
           $image->move($destinationPath,$data['image']);
           $image = $data['image'];
               $data['image']  = $image;
           }else{
               $data['image'] = "";
           }


        DB::table('blogs')->insert($data);

        return redirect()->route('blog.index')->with('success', 'Blog Added Successfully');

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

        $data['blog'] = DB::table('blogs')->where('id', $id)->first();
        $data['service_data'] = DB::table('services')->where('is_active', '0')->orderBy('id','DESC')->get();  
        $data['blog_category_data']=DB::table('blog_category')->orderBy('id','DESC')->select('*')->get();
        $data['subservice_data'] = DB::table('subservices')->where('serviceid',$data['blog']->service)->orderBy('id','DESC')->get();
        
      

        return view('admin.edit_blog',$data);

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
       // echo "<pre>";print_r($request->all());echo "</pre>";exit;

        $data['blog_category'] = $request->input('blog_category');

        $data['title'] = $request->input('title');

        $data['blog_url'] = $request->input('blog_url');

        $data['date'] = $request->input('date');

        $data['short_description'] = $request->input('short_description');

        $data['description'] = $request->input('description');

        $data['service'] = $request->input('service');

        $data['subservice'] = $request->input('subservice');

        $data['metatitle'] = $request->input('metatitle');

        $data['metadescription'] = $request->input('metadescription');

        $data['image_alt_tag'] = $request->input('image_alt_tag');

           if($request->hasfile('image') != ''){
            $image = $request->file('image');
            $remove_space = str_replace(' ', '-', $image->getClientOriginalName());
            $data['image'] = time().$remove_space;
           $destination_path = public_path('upload/blog/large');
           $img = Image::make($image->path());
           $width = 970;
           $height = 400;
           $img->resize($width,$height,function($contrainst){
           })->save($destination_path."/".$data['image']);
           $destination_path = public_path('upload/blog/detail');
           $img = Image::make($image->path());
           $width = 1400;
           $height = 575;
           $img->resize($width,$height,function($contrainst){
           })->save($destination_path."/".$data['image']);
           $width = 70;
           $height = 70;
           $destination_path = public_path('upload/blog/small');
           $img->resize($width,$height,function($constraint){
           })->save($destination_path."/".$data['image']);
           $destinationPath = public_path('upload/blog');
           $image->move($destinationPath,$data['image']);
           $image = $data['image'];
               $data['image']  = $image;
           }

        // echo "<pre>";print_r($data);echo "</pre>";exit;

        DB::table('blogs')->where('id', $id)->update($data);

        return redirect()->route('blog.index')->with('success','Blog Updated Successfully');

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

        Blog::whereIn('id',$delete_id)->delete();

        return redirect()->route('blog.index')->with('success','Blog has been deleted successfully');

    }
    function subservice_show(){
        $service_id = $_POST['service'];
        // echo $service_id;exit;
        
        $result = DB::table('subservices')->select('*')->where('serviceid','=',$service_id)->orderBy('id','DESC')->get();        

        $result_new = $result->toArray();

        $html = ' <select class="form-control" id="subservice" name="subservice">';
        $html .= '<option value="">Select Sub Service</option>';
        if($result != '' && count($result) >0)
        {
            for($i=0;$i<count($result);$i++)
            {
                // echo "<pre>";print_r($result[$i]->id);echo "</pre>";exit;
                $html .= "<option value='".$result[$i]->id ."'>".$result[$i]->subservicename."</option>";
            }
        }
        $html .="</select>";
        // echo "<pre>";print_r($html);echo "</pre>";exit;
        echo $html;
    }
public function upload(Request $request): JsonResponse
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
      
            $request->file('upload')->move(public_path('media'), $fileName);
            
      
            $url = asset('public/media/' . $fileName);
  
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }
}