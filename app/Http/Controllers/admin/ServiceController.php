<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\City;
use App\Models\Admin\Service;
use DB;
use Image;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // echo"test";exit;
        $data['service_data']=Service::orderBy('id','DESC')->get();
        return view('admin.list_service',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $data['country_data'] = DB::table('countries')->select('*')->orderBy('country','ASC')->get();

        $data['allcity'] = DB::table('cities')->where('country',22)->orderBy('id','DESC')->get();

        $data['form_field_data'] = DB::table('form_fileds')->get();

        // echo"<pre>";
        // print_r($data['form_field_data']);
        // echo"</pre>";
        // exit;

        return view('admin.add_service',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo"<pre>";
        // print_r($request->all());
        // echo"</pre>";
        // exit;

        $service=New Service;
        //$service->country = $request->country;
        if(isset($request->country)){
            $service->country = implode(",",$request->country);
        }
		if(isset($request->city)){
            $service->city = implode(",",$request->city);
        }
        $service->servicename=$request->servicename;
        $service->page_url=$request->page_url;
        $service->title1=$request->title1;
        $service->title2=$request->title2;
        $service->title=$request->title;
        $service->sub_title=$request->sub_title;
        $service->banner_url=$request->banner_url;
        $service->sort_description=$request->sort_description;
        $service->top_description=$request->top_description;
        $service->homeicon_alt_tag=$request->homeicon_alt_tag;
        $service->homebanner_alt_tag=$request->homebanner_alt_tag;
        $service->homebanner_mobile_alt_tag=$request->homebanner_mobile_alt_tag;
        
        if(isset($request->form_fields)){
            $service->form_fields = implode(",",$request->form_fields);
        }
        if(isset($request->form_fields_two)){
            $service->form_fields_two = implode(",",$request->form_fields_two);
        }

        $service->set_order = 0;

        $service->scope_of_job = $request->scope_of_job ;
        $service->price_includes = $request->price_includes ;
        $service->price_excludes = $request->price_excludes;
        $service->disclaimer = $request->disclaimer;
        $service->insurance = $request->insurance;
        $service->payment_terms = $request->payment_terms;
		
		if($request->hasfile('home_icon') != ''){

            $home_icon = $request->file('home_icon');
            $remove_space = str_replace(' ', '-', $home_icon->getClientOriginalName());
            $data['home_icon'] = time() . $remove_space;
            //$destinationPath = public_path('upload/service/large/');
            /* $img = Image::make($home_icon->path());
            $width=1350;
            $height=440;
            $img->resize($width,$height,function($constraint){
            })->save($destinationPath.'/'.$data['home_icon']); */
              
            $destinationPath = public_path('upload/service/');
            $home_icon->move($destinationPath,$data['home_icon']);
            $home_icon = $data['home_icon'];
        }else{
            $home_icon = "";
        }
        $service->home_icon  = $home_icon;

        if($request->hasfile('image') != ''){

            $image = $request->file('image');
            $remove_space = str_replace(' ', '-', $image->getClientOriginalName());
            $data['image'] = time() . $remove_space;
            $destinationPath = public_path('upload/service/large/');
            $img = Image::make($image->path());
            $width=1350;
            $height=440;
            $img->resize($width,$height,function($constraint){
            })->save($destinationPath.'/'.$data['image']);
              
            $destinationPath = public_path('upload/service/');
            $image->move($destinationPath,$data['image']);
            $image = $data['image'];
        }else{
            $image = "";
        }
        $service->image  = $image;

        if($request->hasfile('banner') != ''){

            $banner = $request->file('banner');
            $remove_space = str_replace(' ', '-', $banner->getClientOriginalName());
            $data['banner'] = time() . $remove_space;
            $destinationPath = public_path('upload/service/banner/large');
            $img = Image::make($banner->path());
            $width=400;
            $height=475;
            $img->resize($width,$height,function($constraint){
            })->save($destinationPath.'/'.$data['banner']);
              
            $destinationPath = public_path('upload/service/banner/');
            $banner->move($destinationPath,$data['banner']);
            $banner = $data['banner'];
        }else{
            $banner = "";
        }
        $service->banner  = $banner;
        

        // $service->save();
        $service->save(); // Inserts into DB
        $package_id = $service->id;


        if (!empty($_POST['city_addmore_top_description']) && is_array($_POST['city_addmore_top_description'])) {
            for ($i = 0; $i < count($_POST['city_addmore_top_description']); $i++) {

                           
                if (!empty($_POST['city_addmore_top_description'][$i])) {
                    $content['city'] = $_POST['city_addmore_top_description'][$i];
                    $content['description'] = $_POST['description_addmore_top_description'][$i];
                    $content['service_id'] = $package_id;
                    $this->insert_attribute_top_description($content);
                }
            }
        }

        //$package_id = DB::table('services')->insertGetId($service);

    if (!empty($_POST['city_addmore_banner']) && is_array($_POST['city_addmore_banner'])) {
    $total = count($_POST['city_addmore_banner']);

    for ($i = 0; $i < $total; $i++) {
        $content = []; // reset each loop

        // Handle image upload
        if (!empty($_FILES['image_addmore_banner']['name'][$i])) {
            $image = $_FILES['image_addmore_banner']['tmp_name'][$i];
            $originalName = $_FILES['image_addmore_banner']['name'][$i];
            $filename = time() . '-' . str_replace(' ', '-', $originalName);

            // Save large version
            Image::make($image)
                ->resize(510, 340)
                ->save(public_path('upload/service/banner_attr/large/' . $filename));

            // Save original
            Image::make($image)
                ->save(public_path('upload/service/banner_attr/' . $filename));

            $content['image'] = $filename;
        }else{
            $content['image'] = "";
        }

         if (!empty($_FILES['mobile_banner_image_addmore']['name'][$i])) {
            $image = $_FILES['mobile_banner_image_addmore']['tmp_name'][$i];
            $originalName = $_FILES['mobile_banner_image_addmore']['name'][$i];
            $filename = time() . '-' . str_replace(' ', '-', $originalName);

            // Save large version
            Image::make($image)
                ->resize(510, 340)
                ->save(public_path('upload/service/banner_attr/large/' . $filename));

            // Save original
            Image::make($image)
                ->save(public_path('upload/service/banner_attr/' . $filename));

            $content['mobile_banner_image'] = $filename;
        }else{
            $content['mobile_banner_image'] = "";
        }

        // Only insert if city is not empty
        if (!empty($_POST['city_addmore_banner'][$i])) {
            $content['city'] = $_POST['city_addmore_banner'][$i];
            $content['service_id'] = $package_id;
            $content['title_addmore'] = $_POST['title_addmore_banner'][$i] ?? '';
            $content['description_addmore'] =  $_POST['description_addmore_banner'][$i] ?? '';

            $this->insert_banner_attribute($content);
        }
    }
}

        if (count($_POST['city_addmore_second']) > 0 && $_POST['city_addmore_second'] != '') {
            for ($i = 0; $i < count($_POST['city_addmore_second']); $i++) {    
                if($_FILES['image_'.$i]['name'] != '') {                                 
                    $image = $_FILES['image_'.$i]['tmp_name'];    
                    $originalName = $_FILES['image_'.$i]['name']; // Get the original file name    
                    $filename = time() . '-' . str_replace(' ', '-', $originalName);   

                    Image::make($image)    
                    ->resize(510,340)    
                    ->save(public_path('upload/service/service_attr/large/' . $filename));    

                    Image::make($image)              
                    ->save(public_path('upload/service/service_attr/' . $filename)); 

                    $content['image']   = $filename;                       
                }
                if($_POST['city_addmore_second'][$i] != ''){
                    $content['city'] = $_POST['city_addmore_second'][$i];  
                    $content['p_id'] = $package_id;
                    $content['title_addmore'] = $_POST['title_addmore'][$i];  
                    $content['description_addmore'] = $_POST['description_addmore'][$i];    
                    $content['image_alt_tag_addmore'] = $_POST['image_alt_tag_addmore'][$i];    
                    $this->insert_package_attribute($content);    
                }    
            }    
        }
        if (count($_POST['city_addmore_third']) > 0 && $_POST['city_addmore_third'] != '') {
            for ($i = 0; $i < count($_POST['city_addmore_third']); $i++) {    
               
                if($_POST['city_addmore_third'][$i] != ''){
                    $content['service_id'] = $package_id;
                    $content['city'] = $_POST['city_addmore_third'][$i];  
                    $content['meta_title'] = $_POST['meta_title'][$i];    
                    $content['meta_keyword'] = $_POST['meta_keyword'][$i];    
                    $content['meta_description'] = $_POST['meta_description'][$i];    
                    $this->insert_service_contains($content);    
                }    
            }    
        }
        
        return redirect()->route('service.index')->with('success', 'Service Added Successfully');
        
    }

    function insert_attribute_top_description($content){

        $data['city'] =$content['city'];
        $data['service_id'] = $content['service_id'];      
        $data['description'] = $content['description'];        
        DB::table('service_top_description_attr')->insertGetId($data);

    }

    function update_attribute_top_description($content){

//echo"<pre>";print_r($content);echo"</pre>";exit;
        $data['city'] = $content['city'];

        $data['service_id'] = $content['service_id'];
        $data['description'] = $content['description']; 
        DB::table('service_top_description_attr')->where('id', $content['updateid1xxx1_top_description'])->update($data);
    }

    function insert_banner_attribute($content){

          $data['city'] =  $content['city'];
        $data['service_id'] = $content['service_id'];      
        $data['title'] = $content['title_addmore'];
       $data['image'] = $content['image'];
       $data['mobile_banner_image'] = $content['mobile_banner_image'];
        $data['short_description'] = $content['description_addmore'];
        DB::table('service_banner_attr')->insertGetId($data);
    }
    function insert_package_attribute($content){
        //   echo"<pre>";
        // print_r($content);
        // echo"</pre>";
        // exit;

        $data['city'] =  $content['city'];
        $data['pid'] = $content['p_id'];      
        $data['title_addmore'] = $content['title_addmore'];
       $data['image'] = $content['image'];
        $data['description_addmore'] = $content['description_addmore'];
        $data['image_alt_tag'] = $content['image_alt_tag_addmore'];
        DB::table('service_attr')->insertGetId($data);

    }
    function insert_service_contains($content){
        $data['service_id'] = $content['service_id'];      
        $data['city'] = $content['city'];
        $data['meta_title'] = $content['meta_title'];
        $data['meta_keyword'] = $content['meta_keyword'];
        $data['meta_description'] = $content['meta_description'];
        DB::table('service_contains')->insertGetId($data);

    }
    
    public function removed_addmore_att(Request $request){

        $service = $request->pid;
        $id = $request->id;
        $result = DB::table('service_attr')->where('pid', '=',$service)->where('id', '=',$id)->delete();
        return redirect()->route('service.edit',$service)->with('success','deleted successfully');

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
    public function edit(Service $service)
    {
        $data['country_data'] = DB::table('countries')->select('*')->orderBy('id','DESC')->get();

        // $data['allcity'] = DB::table('cities')->whereIn('id',explode(",",$service->city))->select('*')->orderBy('id','DESC')->get();
		
		$countryArray = explode(',', $service->country);

        $data['allcity'] =  DB::table('cities')->whereIn('country',$countryArray)->get();
        $data['banner_attribute_data'] = DB::table('service_banner_attr')
                                    ->select('*')                            
                                    ->where('service_id', '=',$service->id)                            
                                    ->get()                            
                                    ->toArray(); 
        
        $data['package_attribute_data'] = DB::table('service_attr')
                                    ->select('*')                            
                                    ->where('pid', '=',$service->id)                            
                                    ->get()                            
                                    ->toArray(); 

        $data['form_field_data'] = DB::table('form_fileds')->get();
         $data['service_contains_data'] = DB::table('service_contains')                
                                    ->where('service_id', '=',$service->id)                            
                                    ->get()
                                    ->toArray();   
                                    
        $data['service_top_description_attr'] = DB::table('service_top_description_attr')
                            ->select('*')                            
                            ->where('service_id', '=',$service->id)                            
                            ->get()                            
                            ->toArray();
                                    
        
        return view('admin.edit_service',compact('service'),$data);
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
        //  echo"<pre>";
        // print_r($request->all());
        // echo"</pre>";
        // exit;
         
        $service= Service::find($id);
        //$service->country=$request->country;
		if(isset($request->country)){
            $service->country = implode(",",$request->country);
        }
        if(isset($request->city)){
            $service->city = implode(",",$request->city);
        }
        $service->servicename=$request->servicename;
        $service->page_url=$request->page_url;
        $service->title1=$request->title1;
        $service->title2=$request->title2;
        $service->title=$request->title;
        $service->sub_title=$request->sub_title;
        $service->banner_url=$request->banner_url;
        $service->sort_description=$request->sort_description;
        $service->top_description=$request->top_description;
        $service->homeicon_alt_tag=$request->homeicon_alt_tag;
        $service->homebanner_alt_tag=$request->homebanner_alt_tag;
        $service->homebanner_mobile_alt_tag=$request->homebanner_mobile_alt_tag;

        if(isset($request->form_fields)){
            $service->form_fields = implode(",",$request->form_fields);
        }
        if(isset($request->form_fields_two)){
            $service->form_fields_two = implode(",",$request->form_fields_two);
        }

        $service->scope_of_job = $request->scope_of_job ;
        $service->price_includes = $request->price_includes ;
        $service->price_excludes = $request->price_excludes;
        $service->disclaimer = $request->disclaimer;
        $service->insurance = $request->insurance;
        $service->payment_terms = $request->payment_terms;

        //$service->banner_description=$request->banner_description;
		
		if($request->hasfile('home_icon') != ''){

            $home_icon = $request->file('home_icon');
            $remove_space = str_replace(' ', '-', $home_icon->getClientOriginalName());
            $data['home_icon'] = time() . $remove_space;
            /* $destinationPath = public_path('upload/service/large/');
            $img = Image::make($home_icon->path());
            $width=1350;
            $height=440;
            $img->resize($width,$height,function($constraint){
            })->save($destinationPath.'/'.$data['home_icon']); */
              
            $destinationPath = public_path('upload/service/');
            $home_icon->move($destinationPath,$data['home_icon']);
            $home_icon = $data['home_icon'];
            $service->home_icon  = $home_icon;
        }
		
        if($request->hasfile('image') != ''){

            $image = $request->file('image');
            $remove_space = str_replace(' ', '-', $image->getClientOriginalName());
            $data['image'] = time() . $remove_space;
            $destinationPath = public_path('upload/service/large/');
            $img = Image::make($image->path());
            $width=1350;
            $height=440;
            $img->resize($width,$height,function($constraint){
            })->save($destinationPath.'/'.$data['image']);
              
            $destinationPath = public_path('upload/service/');
            $image->move($destinationPath,$data['image']);
            $image = $data['image'];
            $service->image  = $image;
        }
        if($request->hasfile('banner') != ''){

            $banner = $request->file('banner');
            $remove_space = str_replace(' ', '-', $banner->getClientOriginalName());
            $data['banner'] = time() . $remove_space;
            $destinationPath = public_path('upload/service/banner/large/');
            $img = Image::make($banner->path());
            $width=400;
            $height=475;
            $img->resize($width,$height,function($constraint){
            })->save($destinationPath.'/'.$data['banner']);
              
            $destinationPath = public_path('upload/service/banner/');
            $banner->move($destinationPath,$data['banner']);
            $banner = $data['banner'];
            $service->banner  = $banner;
        }
        
        // echo"<pre>";
        // print_r($service);
        // echo"</pre>";
        // exit;
        $service->update();

         if (!empty($_POST['city_addmore_top_description']) && is_array($_POST['city_addmore_top_description'])) {
            for ($i = 0; $i < count($_POST['city_addmore_top_description']); $i++) {

                           
                if (!empty($_POST['city_addmore_top_description'][$i])) {
                    $content['city'] = $_POST['city_addmore_top_description'][$i];
                    $content['description'] = $_POST['description_addmore_top_description'][$i];
                    $content['service_id'] = $id;
                    $this->insert_attribute_top_description($content);
                }
            }
        }

        if ($request->city_addmore_top_descriptionu != '' && count($request->city_addmore_top_descriptionu) > 0 ) {      
            for ($i = 0; $i < count($_POST['city_addmore_top_descriptionu']); $i++) {      
                //echo"<pre>";print_r($_FILES['imageu_'.$i]);echo"</pre>";exit;
                if($_POST['city_addmore_top_descriptionu'][$i] != ''){
                $contentu['city'] = $_POST['city_addmore_top_descriptionu'][$i];
                $contentu['service_id'] = $id;
                $contentu['description'] = $_POST['description_addmore_top_descriptionu'][$i];
                $contentu['updateid1xxx1_top_description'] = $_POST['updateid1xxx1_top_description'][$i];
                $this->update_attribute_top_description($contentu);

                }

            }
      
        }

         if (!empty($_POST['city_addmore_banner1']) && is_array($_POST['city_addmore_banner1'])) {
    for ($i = 0; $i < count($_POST['city_addmore_banner1']); $i++) {

       

        if (!empty($_FILES['image_addmore_banner1']['name'][$i])) {
            $image = $_FILES['image_addmore_banner1']['tmp_name'][$i];
            $originalName = $_FILES['image_addmore_banner1']['name'][$i];

            $filename = time() . '-' . str_replace(' ', '-', $originalName);

            Image::make($image)
                ->resize(510, 340)
                ->save(public_path('upload/service/banner_attr/large/' . $filename));

            Image::make($image)
                ->save(public_path('upload/service/banner_attr/' . $filename));

            $content['image'] = $filename;
        }else{
            $content['image'] = "";
        }

        if (!empty($_FILES['mobile_banner_image_addmore1[]']['name'][$i])) {
            $image = $_FILES['mobile_banner_image_addmore1[]']['tmp_name'][$i];
            $originalName = $_FILES['mobile_banner_image_addmore1[]']['name'][$i];

            $filename = time() . '-' . str_replace(' ', '-', $originalName);

            Image::make($image)
                ->resize(400, 475)
                ->save(public_path('upload/service/banner_attr/large/' . $filename));

            Image::make($image)
                ->save(public_path('upload/service/banner_attr/' . $filename));

            $content['mobile_banner_image'] = $filename;
        }else{
            $content['mobile_banner_image'] = "";
        }

        if (!empty($_POST['city_addmore_banner1'][$i])) {
            $content['city'] = $_POST['city_addmore_banner1'][$i];
            $content['service_id'] = $id;
            $content['title_addmore'] = $_POST['title_addmore_banner1'][$i] ?? '';
            $content['description_addmore'] = $_POST['description_addmore_banner1'][$i] ?? '';

        //             echo"<pre>";
        // print_r($content);
        // echo"</pre>";
        // exit;

            $this->insert_banner_attribute($content);
        }
    }
}

         if (!empty($_POST['city_addmore_second1']) && is_array($_POST['city_addmore_second1'])) {
    for ($i = 0; $i < count($_POST['city_addmore_second1']); $i++) {

       

        if (!empty($_FILES['image_addmore1']['name'][$i])) {
            $image = $_FILES['image_addmore1']['tmp_name'][$i];
            $originalName = $_FILES['image_addmore1']['name'][$i];

            $filename = time() . '-' . str_replace(' ', '-', $originalName);

            Image::make($image)
                ->resize(510, 340)
                ->save(public_path('upload/service/service_attr/large/' . $filename));

            Image::make($image)
                ->save(public_path('upload/service/service_attr/' . $filename));

            $content['image'] = $filename;
        }

        if (!empty($_POST['city_addmore_second1'][$i])) {
            $content['city'] = $_POST['city_addmore_second1'][$i];
            $content['p_id'] = $id;
            
            $content['title_addmore'] = $_POST['title_addmore1'][$i] ?? '';
            $content['description_addmore'] = $_POST['description_addmore1'][$i] ?? '';
            $content['image_alt_tag_addmore'] = $_POST['image_alt_tag_addmore1'][$i] ?? '';

        //             echo"<pre>";
        // print_r($content);
        // echo"</pre>";
        // exit;

            $this->insert_package_attribute($content);
        }
    }
}
//  if (!empty($_POST['city_addmore_secondu']) && is_array($_POST['city_addmore_secondu'])) {
//     $total = count($_POST['city_addmore_secondu']);

//     for ($i = 0; $i < $total; $i++) {
//         $contentu = []; // reset per loop

//         if (!empty($_POST['city_addmore_secondu'][$i])) {
            
//             // If image exists for this index
//             if (!empty($_FILES['image_addmoreu']['name'][$i])) {
//                 $image = $_FILES['image_addmoreu']['tmp_name'][$i];
//                 $originalName = $_FILES['image_addmoreu']['name'][$i];
//                 $filename = time() . '-' . str_replace(' ', '-', $originalName);

//                 // Save large version
//                 Image::make($image)
//                     ->resize(510, 340)
//                     ->save(public_path('upload/service/service_attr/large/' . $filename));

//                 // Save original
//                 Image::make($image)
//                     ->save(public_path('upload/service/service_attr/' . $filename));

//                 $contentu['image'] = $filename;
//             } else {
//                 $contentu['image'] = ''; // Keep empty if no new image uploaded
//             }

//             // Other fields
//             $contentu['city'] = $_POST['city_addmore_secondu'][$i];
//             $contentu['p_id'] = $id;
//             $contentu['title_addmore'] = $_POST['title_addmoreu'][$i] ?? '';
//             $contentu['description_addmore'] = $_POST['description_addmoreu'][$i] ?? '';
//             $contentu['image_alt_tag_addmore'] = $_POST['image_alt_tag_addmoreu'][$i] ?? '';
//             $contentu['updateid1xxx1'] = $_POST['updateid1xxx1'][$i] ?? '';

//             // Update
//             $this->update_Package_attribute($contentu);
//         }
//     }
// }

if (!empty($_POST['city_addmore_secondu']) && is_array($_POST['city_addmore_secondu'])) {
    $total = count($_POST['city_addmore_secondu']);

    for ($i = 0; $i < $total; $i++) {
        $updateId = $_POST['updateid1xxx1'][$i] ?? null;

        if (!$updateId) continue; // skip if no update id

        // Get existing record from DB
        $old = DB::table('service_attr')->find($updateId);

        $contentu = [
            'city'               => $_POST['city_addmore_secondu'][$i],
            'pid'               => $id,
            'title_addmore'      => $_POST['title_addmoreu'][$i] ?? '',
            'description_addmore'=> $_POST['description_addmoreu'][$i] ?? '',
            'image_alt_tag' => $_POST['image_alt_tag_addmoreu'][$i] ?? '',
        ];

        // ✅ Check if new image uploaded for this record
        if (!empty($_FILES['image_addmore1u']['name'][$i])) {
            $image = $_FILES['image_addmore1u']['tmp_name'][$i];
            $originalName = $_FILES['image_addmore1u']['name'][$i];
            $filename = time() . '-' . str_replace(' ', '-', $originalName);

            // Save large
            Image::make($image)
                ->resize(510, 340)
                ->save(public_path('upload/service/service_attr/large/' . $filename));

            // Save original
            Image::make($image)
                ->save(public_path('upload/service/service_attr/' . $filename));

            $contentu['image'] = $filename;
        } else {
            // ✅ Keep old image if not updated
            $contentu['image'] = $old->image ?? null;
        }

        // Update this row
        DB::table('service_attr')->where('id', $updateId)->update($contentu);
    }
}


              if (!empty($_POST['city_addmore_banneru']) && is_array($_POST['city_addmore_banneru'])) {
    $total = count($_POST['city_addmore_banneru']);

    for ($i = 0; $i < $total; $i++) {
        $contentu = []; // reset per loop

        if (!empty($_POST['city_addmore_banneru'][$i])) {
            
            // If image exists for this index
            if (!empty($_FILES['image_addmoreu']['name'][$i])) {
                $image = $_FILES['image_addmoreu']['tmp_name'][$i];
                $originalName = $_FILES['image_addmoreu']['name'][$i];
                $filename = time() . '-' . str_replace(' ', '-', $originalName);

                // Save large version
                Image::make($image)
                    ->resize(510, 340)
                    ->save(public_path('upload/service/banner_attr/large/' . $filename));

                // Save original
                Image::make($image)
                    ->save(public_path('upload/service/banner_attr/' . $filename));

                $contentu['image'] = $filename;
            } else {
                $contentu['image'] = ''; // Keep empty if no new image uploaded
            }

            if (!empty($_FILES['mobile_banner_image_addmoreu']['name'][$i])) {
                $image = $_FILES['mobile_banner_image_addmoreu']['tmp_name'][$i];
                $originalName = $_FILES['mobile_banner_image_addmoreu']['name'][$i];
                $filename = time() . '-' . str_replace(' ', '-', $originalName);

                // Save large version
                Image::make($image)
                    ->resize(400, 475)
                    ->save(public_path('upload/service/banner_attr/large/' . $filename));

                // Save original
                Image::make($image)
                    ->save(public_path('upload/service/banner_attr/' . $filename));

                $contentu['mobile_banner_image'] = $filename;
            } else {
                $contentu['mobile_banner_image'] = ''; // Keep empty if no new image uploaded
            }

            // Other fields
            $contentu['city'] = $_POST['city_addmore_banneru'][$i];
            $contentu['p_id'] = $id;
            $contentu['title_addmore'] = $_POST['title_addmore_banneru'][$i] ?? '';
            $contentu['description_addmore'] = $_POST['description_addmore_banneru'][$i] ?? '';
            $contentu['updateid1xxx0'] = $_POST['updateid1xxx0'][$i] ?? '';

            // Update

        //                 echo"<pre>";
        // print_r($contentu);
        // echo"</pre>";
        // exit;
            $this->update_banner_attribute($contentu);
        }
    }
}

        if (isset($_POST['city_addmore_thirdu']) && count($_POST['city_addmore_thirdu']) > 0 && $_POST['city_addmore_thirdu'] != '') {
            for ($i = 0; $i < count($_POST['city_addmore_thirdu']); $i++) {

                if($_POST['city_addmore_thirdu'][$i] != ''){
                    $content['service_id'] = $id;
                    $content['city'] = $_POST['city_addmore_thirdu'][$i];  
                    $content['meta_title'] = $_POST['meta_titleu'][$i];    
                    $content['meta_keyword'] = $_POST['meta_keywordu'][$i];    
                    $content['meta_description'] = $_POST['meta_descriptionu'][$i]; 
                    $content['updateid1xxx2'] = $_POST['updateid1xxx2'][$i];   
                    $this->update_service_contains($content);    
                }    
            }    
        }
        if (count($_POST['city_addmore_third1']) > 0 && $_POST['city_addmore_third1'] != '') {
            for ($i = 0; $i < count($_POST['city_addmore_third1']); $i++) {    
               
                if($_POST['city_addmore_third1'][$i] != ''){
                    $content['service_id'] = $id;
                    $content['city'] = $_POST['city_addmore_third1'][$i];  
                    $content['meta_title'] = $_POST['meta_title1'][$i];    
                    $content['meta_keyword'] = $_POST['meta_keyword1'][$i];    
                    $content['meta_description'] = $_POST['meta_description1'][$i];    
                    $this->insert_service_contains($content);    
                }    
            }    
        }

        
        
        return redirect()->route('service.index')->with('success', 'Service  Updated Successfully');
    }

     function update_service_contains($content){
        $data['service_id'] = $content['service_id'];      
        $data['city'] = $content['city'];
        $data['meta_title'] = $content['meta_title'];
        $data['meta_keyword'] = $content['meta_keyword'];
        $data['meta_description'] = $content['meta_description'];
        DB::table('service_contains')->where('id', $content['updateid1xxx2'])->update($data);
     }


     function update_Package_attribute($content){

       // echo"<pre>";print_r($content);echo"</pre>";exit;
                 $data['city'] = $content['city'];
                $data['pid'] = $content['p_id'];
        
                $data['title_addmore'] = $content['title_addmore'];    

                if($content['image'] != ''){
                    $data['image'] =  $content['image'];
                } 
                $data['description_addmore'] = $content['description_addmore'];    
                $data['image_alt_tag'] = $content['image_alt_tag_addmore'];    

                DB::table('service_attr')->where('id', $content['updateid1xxx1'])->update($data);
            }

            function update_banner_attribute($content){
                    $data['city'] = $content['city'];
                $data['service_id'] = $content['p_id'];
        
                $data['title'] = $content['title_addmore'];    

                if($content['image'] != ''){
                    $data['image'] =  $content['image'];
                } 
                if($content['mobile_banner_image'] != ''){
                    $data['mobile_banner_image'] =  $content['mobile_banner_image'];
                } 
                $data['short_description'] = $content['description_addmore'];      

                DB::table('service_banner_attr')->where('id', $content['updateid1xxx0'])->update($data);

            }

     //* Remove the specified resource from storage.
     //*
    // * @param  int  $id
    // * @return \Illuminate\Http\Response
   //  */
    public function destroy(Request $request)
    {
        $delete_id=$request->selected;
        Service::whereIn('id',$delete_id)->delete();
        return redirect()->route('service.index')->with('success','Service Deleted Successfully');
    }

    function removed_service_addmore_att(Request $request){
         $service = $request->pid;

        $id = $request->id;

        $result = DB::table('service_attr')->where('pid', '=',$service)->where('id', '=',$id)->delete();

        return redirect()->route('service.edit',$service)->with('success','Service attribute deleted successfully');

    }
    function removed_service_contain_att(Request $request){
         $service = $request->pid;

        $id = $request->id;

        $result = DB::table('service_contains')->where('service_id', '=',$service)->where('id', '=',$id)->delete();

        return redirect()->route('service.edit',$service)->with('success','Service Contain attribute deleted successfully');

    }
     function removed_banner_addmore_att(Request $request){
         $service = $request->pid;

        $id = $request->id;

        $result = DB::table('service_banner_attr')->where('service_id', '=',$service)->where('id', '=',$id)->delete();

        return redirect()->route('service.edit',$service)->with('success','Service Banner attribute deleted successfully');

    }
    public function set_order_service()

    {

        $id = $_POST['id'];

        $val = $_POST['val'];

        // echo $id."-".$val;exit;

        DB::table('services')->where('id', $id)->update(array('set_order' => $val));

        echo "1";

        // return redirect()->route('product.index')->with('success','Set Order has been Updated successfully');

    }
    public  function change_status_service(){



        $id=$_POST['id'];

        $value=$_POST['value'];       

        DB::table('services')->where('id',$id)->update(array('is_active'=>$value));

        echo"1";

    }
    function city_show_new(Request $request){
		
		return City::whereIn('country', (array)$request->country_id)->orderBy('name','ASC')->get();
        /* $country_id = $_POST['country_id'];
        //echo $cat_id;exit;
        $result = DB::table('cities')->select('*')->where('country','=',$country_id)->get();

        $result_new = $result->toArray();

        $html = "<select id='city' name='city[]' class='form-control' multiple='multiple'>";
        $html .= "<option value=''>Select City</option>";
        if($result != '' && count($result) >0)
        {
            for($i=0;$i<count($result);$i++)
            {
                //echo "<pre>";print_r($result[$i]->id);echo "</pre>";exit;
                $html .= "<option value='".$result[$i]->id ."'>".$result[$i]->name ."</option>";
            }
        }
        $html .="</select>";
        //echo "<pre>";print_r($html);echo "</pre>";exit;
        echo $html; */
    }

    public function service_removed_top_descatt(Request $request){



        $service = $request->pid;

        $id = $request->id;

        $result = DB::table('service_top_description_attr')->where('service_id', '=',$service)->where('id', '=',$id)->delete();

        return redirect()->route('service.edit',$service)->with('success','deleted successfully');

    }

    

}