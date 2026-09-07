<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Subservice;
use App\Models\Admin\Service;
use Image;
use DB;
use File;

class SubserviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['subservice_data'] = Subservice::orderBy('id', 'DESC')->get();

        return view('admin.list_subservice', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        $data['service_data'] = service::where('is_active', 0)->orderBy('id', 'DESC')->get();
        $data['form_field_data'] = DB::table('form_fileds')->get();

        $data['country_data'] = DB::table('countries')->select('*')->orderBy('country', 'ASC')->get();

        $data['allcity'] = DB::table('cities')->where('country', 22)->orderBy('id', 'DESC')->get();
        $data['all_subservices'] = Subservice::where('is_active', 0)->orderBy('subservicename', 'ASC')->get();

        return view('admin.add_subservice', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subservice = new Subservice;

        if (isset($request->country)) {
            $subservice->country = implode(",", $request->country);
        }

        if (isset($request->city)) {
            $subservice->city = implode(",", $request->city);
        }

        $subservice->serviceid = $request->serviceid;
        $subservice->subservice_code = $request->subservice_code;
        $subservice->subservicename = $request->subservicename;
        $subservice->page_url = $request->page_url;
        $subservice->promo_discount = $request->promo_discount;
        $subservice->discount_type = $request->discount_type;
        $subservice->banner_title = $request->banner_title;
        $subservice->banner_subtitle = $request->banner_subtitle;
        $subservice->description = $request->description;
        $subservice->cancel_policy = $request->cancel_policy;
        $subservice->top_description = $request->top_description;
        $subservice->service_detail_short_description = $request->service_detail_short_description;
        $subservice->service_detail_popup_description = $request->service_detail_popup_description;
        $subservice->charge = $request->charge;
        $subservice->no_of_inquiry = $request->no_of_inquiry;
        $subservice->servicepercentage = $request->servicepercentage;
        $subservice->additional_charge_popup = $request->additional_charge_popup;
        $subservice->timing_fee_popup = $request->timing_fee_popup;
        $subservice->delivery_charge_popup = $request->delivery_charge_popup;
        $subservice->service_fee_popup = $request->service_fee_popup;
        $subservice->meta_title = $request->meta_title;
        $subservice->meta_keyword = $request->meta_keyword;
        $subservice->meta_description = $request->meta_description;


        $subservice->image_alt_tag = $request->image_alt_tag;
        $subservice->banner_image_alt_tag = $request->banner_image_alt_tag;
        $subservice->mobile_image_alt_tag = $request->mobile_image_alt_tag;
        $subservice->service_detail_image_alt_tag = $request->service_detail_image_alt_tag;

        $subservice->is_bookable = implode(',', $request->is_bookable);
        $subservice->set_order = 0;

        if (isset($request->form_fields)) {
            $subservice->form_fields = implode(",", $request->form_fields);
        }
        if (isset($request->form_fields_two)) {
            $subservice->form_fields_two = implode(",", $request->form_fields_two);
        }

        $subservice->step_1_title = $request->step_1_title;
        $subservice->step_2_title = $request->step_2_title;
        $subservice->step_3_title = $request->step_3_title;
        $subservice->step_4_title = $request->step_4_title;

        for ($i = 1; $i <= 4; $i++) {
            $field = 'step_' . $i . '_image';
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $fileName = time() . '-' . str_replace(' ', '-', $file->getClientOriginalName());
                $path = public_path('upload/subservice/');
                if (!\File::exists($path)) {
                    \File::makeDirectory($path, 0755, true);
                }
                $file->move($path, $fileName);
                $subservice->$field = $fileName;
            }
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalName = $file->getClientOriginalName();
            $modifiedName = str_replace(' ', '-', $originalName);
            $modifiedName = trim($modifiedName);
            $fileName = time() . '-' . $modifiedName;

            $pathOriginal = public_path('upload/subservice/');
            $pathLarge = public_path('upload/subservice/large/');
            $pathMedium = public_path('upload/subservice/medium/');
            $pathSmall = public_path('upload/subservice/small/');

            // Create directories if they don't exist
            foreach ([$pathOriginal, $pathLarge, $pathMedium, $pathSmall] as $path) {
                if (!\File::exists($path)) {
                    \File::makeDirectory($path, 0755, true);
                }
            }

            // Get temporary path for the uploaded file
            $tempPath = $file->getRealPath();

            // Save original
            \File::copy($tempPath, $pathOriginal . $fileName);

            // Resize and save large (840x570)
            Image::make($tempPath)
                ->resize(840, 570)
                ->save($pathLarge . $fileName);

            // Resize and save medium (150x105)
            Image::make($tempPath)
                ->resize(150, 105)
                ->save($pathMedium . $fileName);

            // Resize and save small (95x65)
            Image::make($tempPath)
                ->resize(95, 65)
                ->save($pathSmall . $fileName);

            // Save image name
            $subservice->image = $fileName;
        }

        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $originalName = $file->getClientOriginalName();
            $path1 = public_path('upload/subservice/banner/large/');
            $path2 = public_path('upload/subservice/banner/');

            $modifiedName = str_replace(' ', '-', $originalName);
            $modifiedName = trim($modifiedName);
            $fileName = time() . '-' . $modifiedName;

            // Ensure directories exist
            if (!File::exists($path1)) {
                File::makeDirectory($path1, 0755, true);
            }
            if (!File::exists($path2)) {
                File::makeDirectory($path2, 0755, true);
            }

            // Resize and save image using Intervention Image
            $image = Image::make($file)
                ->resize(1350, 440, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($path1 . $fileName);

            // Copy to the second path
            File::copy($path1 . $fileName, $path2 . $fileName);

            // Store the file name
            $subservice->banner_image = $fileName;
        }

        if ($request->hasFile('mobile_banner_image')) {

            $file = $request->file('mobile_banner_image');
            $originalName = $file->getClientOriginalName();
            $path1 = public_path('upload/subservice/banner/medium/');
            $path2 = public_path('upload/subservice/banner/');

            $modifiedName = str_replace(' ', '-', $originalName);
            $modifiedName = trim($modifiedName);
            $fileName = time() . '-' . $modifiedName;


            // Ensure directories exist
            if (!File::exists($path1)) {
                File::makeDirectory($path1, 0755, true);
            }
            // Resize and save image using Intervention Image
            $image = Image::make($file)
                ->resize(400, 475, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($path1 . $fileName);

            $file->move($path2, $fileName);
            // Store the file name
            $subservice->mobile_banner_image = $fileName;
        }

        if ($request->hasFile('service_detail_image')) {
            $service_detail_image = $request->file('service_detail_image');
            $extension = $service_detail_image->getClientOriginalExtension();
            $originalName = pathinfo($service_detail_image->getClientOriginalName(), PATHINFO_FILENAME);
            $service_detail_imageName = time() . '-' . $originalName . '.' . $extension;
            if (strtolower($extension) === 'webp' || strtolower($extension) === 'avif') {
                // Move to the large folder first
                $largeDestinationPath = public_path('upload/service/large/' . $service_detail_imageName);
                $service_detail_image->move(public_path('upload/service/large'), $service_detail_imageName);

                // Copy the file to other directories
                copy($largeDestinationPath, public_path('upload/service/' . $service_detail_imageName));
            } else {
                $largeDestinationPath = public_path('upload/service/large' . $service_detail_imageName);
                $this->resizeImage($service_detail_image->getRealPath(), $largeDestinationPath, 513, 180);
                $service_detail_image->move(public_path('upload/service'), $service_detail_imageName);
            }
            $subservice->service_detail_image = $service_detail_imageName;
        } else {
            $subservice->service_detail_image = "";
        }


        // echo"<pre>";
        // print_r($data);
        // echo"</pre>";exit;
        $subservice->save();

        $package_id = $subservice->id;



        if (!empty($_POST['city_addmore_top_description']) && is_array($_POST['city_addmore_top_description'])) {
            for ($i = 0; $i < count($_POST['city_addmore_top_description']); $i++) {


                if (!empty($_POST['city_addmore_top_description'][$i])) {
                    $content['city'] = $_POST['city_addmore_top_description'][$i];
                    $content['description'] = $_POST['description_addmore_top_description'][$i];
                    $content['p_id'] = $id;
                    $this->insert_attribute_top_description($content);
                }
            }
        }

        if (count($_POST['title_addmore_banner']) > 0 && $_POST['title_addmore_banner'] != '') {
            for ($i = 0; $i < count($_POST['title_addmore_banner']); $i++) {

                if (
                    isset($_FILES['image_addmore_banner' . $i]) &&
                    !empty($_FILES['image_addmore_banner' . $i]['name'])
                ) {
                    $image = $_FILES['image_addmore_banner' . $i]['tmp_name'];
                    $originalName = $_FILES['image_addmore_banner' . $i]['name']; // Get the original file name    
                    $filename = time() . '-' . str_replace(' ', '-', $originalName);

                    Image::make($image)
                        ->resize(510, 340)
                        ->save(public_path('upload/subservice/banner_attr/large/' . $filename));

                    Image::make($image)
                        ->save(public_path('upload/subservice/banner_attr/' . $filename));

                    $content['image'] = $filename;
                } else {
                    $content['image'] = '';
                }

                if (
                    isset($_FILES['mobile_banner_image_addmore' . $i]) &&
                    !empty($_FILES['mobile_banner_image_addmore' . $i]['name'])
                ) {
                    $image = $_FILES['mobile_banner_image_addmore' . $i]['tmp_name'];
                    $originalName = $_FILES['mobile_banner_image_addmore' . $i]['name']; // Get the original file name    
                    $filename = time() . '-' . str_replace(' ', '-', $originalName);

                    Image::make($image)
                        ->resize(400, 475)
                        ->save(public_path('upload/subservice/mobile_banner/large/' . $filename));

                    Image::make($image)
                        ->save(public_path('upload/subservice/mobile_banner/' . $filename));

                    $content['moble_banner_image'] = $filename;
                } else {
                    $content['moble_banner_image'] = '';
                }
                if ($_POST['title_addmore_banner'][$i] != '') {
                    $content['city'] = $_POST['city_addmore_banner'][$i];
                    $content['p_id'] = $package_id;
                    $content['title'] = $_POST['title_addmore_banner'][$i];
                    $content['description_addmore_banner'] = $_POST['description_addmore_banner'][$i];
                    $this->insert_banner_attribute($content);
                }
            }
        }

        if (count($_POST['title_addmore']) > 0 && $_POST['title_addmore'] != '') {
            for ($i = 0; $i < count($_POST['title_addmore']); $i++) {
                if (
                    isset($_FILES['image_' . $i]) &&
                    !empty($_FILES['image_' . $i]['name'])
                ) {
                    $image = $_FILES['image_' . $i]['tmp_name'];
                    $originalName = $_FILES['image_' . $i]['name']; // Get the original file name    
                    $filename = time() . '-' . str_replace(' ', '-', $originalName);

                    Image::make($image)
                        ->resize(510, 340)
                        ->save(public_path('upload/subservice/subservice_attr/large/' . $filename));

                    Image::make($image)
                        ->save(public_path('upload/subservice/subservice_attr/' . $filename));

                    $content['image'] = $filename;
                }
                if ($_POST['title_addmore'][$i] != '') {
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

                if ($_POST['city_addmore_third'][$i] != '') {
                    $content['subservice_id'] = $package_id;
                    $content['city'] = $_POST['city_addmore_third'][$i];
                    $content['meta_title'] = $_POST['meta_title_addmore'][$i];
                    $content['meta_keyword'] = $_POST['meta_keyword_addmore'][$i];
                    $content['meta_description'] = $_POST['meta_description_addmore'][$i];
                    $this->insert_subservice_contains($content);
                }
            }
        }

        if (isset($_POST['city_addmore_why_choose']) && is_array($_POST['city_addmore_why_choose'])) {
            for ($i = 0; $i < count($_POST['city_addmore_why_choose']); $i++) {
                if (!empty($_POST['city_addmore_why_choose'][$i])) {
                    $content['subservice_id'] = $package_id;
                    $content['city'] = $_POST['city_addmore_why_choose'][$i];
                    $content['description'] = $_POST['whychoosevc_addmore'][$i];
                    $this->insert_why_choose_attribute($content);
                }
            }
        }

        if (isset($_POST['city_addmore_more_service']) && is_array($_POST['city_addmore_more_service'])) {
            for ($i = 0; $i < count($_POST['city_addmore_more_service']); $i++) {
                if (!empty($_POST['city_addmore_more_service'][$i])) {
                    $content['subservice_id'] = $package_id;
                    $content['city'] = $_POST['city_addmore_more_service'][$i];
                    $content['more_subservice_id'] = isset($_POST['subservice_addmore_more_service'][$i]) ? implode(",", (array)$_POST['subservice_addmore_more_service'][$i]) : '';
                    $this->insert_more_service_attribute($content);
                }
            }
        }


        if (isset($_POST['city_addmore_what_else_service']) && is_array($_POST['city_addmore_what_else_service'])) {
            for ($i = 0; $i < count($_POST['city_addmore_what_else_service']); $i++) {
                if (!empty($_POST['city_addmore_what_else_service'][$i])) {
                    $content['subservice_id'] = $package_id;
                    $content['city'] = $_POST['city_addmore_what_else_service'][$i];
                    $content['what_else_subservice_id'] = isset($_POST['subservice_addmore_what_else_service'][$i]) ? implode(",", (array)$_POST['subservice_addmore_what_else_service'][$i]) : '';
                    $this->insert_what_else_service_attribute($content);
                }
            }
        }

        if (isset($_POST['city_addmore_description']) && is_array($_POST['city_addmore_description'])) {
            for ($i = 0; $i < count($_POST['city_addmore_description']); $i++) {
                if (!empty($_POST['city_addmore_description'][$i])) {
                    \App\Models\Admin\SubserviceDescription::create([
                        'subservice_id' => $package_id,
                        'city' => $_POST['city_addmore_description'][$i],
                        'description' => $_POST['description_addmore_new'][$i] ?? ''
                    ]);
                }
            }
        }

        return redirect()->route('subservice.index')->with('success', 'Sub Service Added Successfully');
    }

    function insert_banner_attribute($content)
    {
        //  echo "<pre>";print_r($content);echo"</pre>";exit;
        $data['city'] = $content['city'];

        $data['subservice_id'] = $content['p_id'];

        $data['title'] = $content['title'];

        $data['image'] = $content['image'];
        $data['mobile_banner_image'] = $content['mobile_banner_image'];

        $data['short_description'] = $content['description_addmore_banner'];

        DB::table('subservice_banner_attr')->insertGetId($data);
    }
    function insert_package_attribute($content)
    {
        $data['city'] = $content['city'];

        $data['pid'] = $content['p_id'];

        $data['title_addmore'] = $content['title_addmore'];

        $data['image'] = $content['image'];

        $data['description_addmore'] = $content['description_addmore'];
        $data['image_alt_tag'] = $content['image_alt_tag_addmore'];



        DB::table('subservice_attr')->insertGetId($data);
    }

    function insert_subservice_contains($content)
    {
        $data['subservice_id'] = $content['subservice_id'];
        $data['city'] = $content['city'];
        $data['meta_title'] = $content['meta_title'];
        $data['meta_keyword'] = $content['meta_keyword'];
        $data['meta_description'] = $content['meta_description'];
        DB::table('sub_service_contains')->insertGetId($data);
    }
    public function removed_addmore_att(Request $request)
    {



        $service = $request->pid;

        $id = $request->id;

        $result = DB::table('subservice_attr')->where('pid', '=', $service)->where('id', '=', $id)->delete();

        return redirect()->route('subservice.edit', $service)->with('success', 'deleted successfully');
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
    public function edit(Subservice $subservice)
    {

        /*  echo "<pre>";
        print_r($subservice);
        echo "</pre>";
        exit; */

        $data['all_service'] = Service::orderBy('id', 'DESC')->get();
        $countryArray = explode(',', $subservice->country);
        $data['allcity'] = DB::table('cities')->whereIn('country', $countryArray)->get();
        $data['form_field_data'] = DB::table('form_fileds')->get();
        $data['banner_attribute_data'] = DB::table('subservice_banner_attr')
            ->select('*')
            ->where('subservice_id', '=', $subservice->id)
            ->get()
            ->toArray();
        $data['package_attribute_data'] = DB::table('subservice_attr')
            ->select('*')
            ->where('pid', '=', $subservice->id)
            ->get()
            ->toArray();
        $data['subservice_contains_data'] = DB::table('sub_service_contains')
            ->select('*')
            ->where('subservice_id', '=', $subservice->id)
            ->get()
            ->toArray();
        $data['subservice_why_choose_attr'] = DB::table('subservice_why_choose_attr')
            ->select('*')
            ->where('subservice_id', '=', $subservice->id)
            ->get()
            ->toArray();
        //$data['allcity'] =  DB::table('cities')->where('country',22)->get();		

        $data['subservice_top_description_attr'] = DB::table('subservice_top_description_attr')
            ->select('*')
            ->where('subservice_id', '=', $subservice->id)
            ->get()
            ->toArray();

        $data['subservice_more_service_attr'] = DB::table('subservice_more_services')
            ->select('*')
            ->where('subservice_id', '=', $subservice->id)
            ->get()->toArray();

        $data['subservice_what_else_service_attr'] = DB::table('subservice_what_else_services')
            ->select('*')
            ->where('subservice_id', '=', $subservice->id)
            ->get()->toArray();

        $data['subservice_description_addmores'] = \App\Models\Admin\SubserviceDescription::where('subservice_id', $subservice->id)
            ->get()->toArray();

        $data['all_subservices'] = Subservice::where('is_active', 0)->orderBy('subservicename', 'ASC')->get();

        $data['country_data'] = DB::table('countries')->select('*')->orderBy('country', 'ASC')->get();

        return view('admin.edit_subservice', compact('subservice'), $data);
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

        //  echo"<pre>";print_r($request->all());echo"</pre>";exit;

        // $subservice=Subservice::find($id);
        $data['serviceid'] = $request->serviceid;
        $data['subservice_code'] = $request->subservice_code;

        if (isset($request->country)) {
            $data['country'] = implode(",", $request->country);
        }

        if (isset($request->city)) {
            $data['city'] = implode(",", $request->city);
        }

        $data['subservicename'] = $request->subservicename;
        $data['page_url'] = $request->page_url;
        $data['promo_discount'] = $request->promo_discount;
        $data['discount_type'] = $request->discount_type;
        $data['banner_title'] = $request->banner_title;
        $data['banner_subtitle'] = $request->banner_subtitle;
        $data['description'] = $request->description;
        $data['cancel_policy'] = $request->cancel_policy;
        $data['top_description'] = $request->top_description;
        $data['service_detail_short_description'] = $request->service_detail_short_description;
        $data['service_detail_popup_description'] = $request->service_detail_popup_description;
        $data['charge'] = $request->charge;
        $data['no_of_inquiry'] = $request->no_of_inquiry;
        $data['servicepercentage'] = $request->servicepercentage;
        $data['additional_charge_popup'] = $request->additional_charge_popup;
        $data['timing_fee_popup'] = $request->timing_fee_popup;
        $data['delivery_charge_popup'] = $request->delivery_charge_popup;
        $data['service_fee_popup'] = $request->service_fee_popup;
        $data['meta_title'] = $request->meta_title;
        $data['meta_keyword'] = $request->meta_keyword;
        $data['meta_description'] = $request->meta_description;


        $data['image_alt_tag'] = $request->image_alt_tag;
        $data['banner_image_alt_tag'] = $request->banner_image_alt_tag;
        $data['mobile_image_alt_tag'] = $request->mobile_image_alt_tag;
        $data['service_detail_image_alt_tag'] = $request->service_detail_image_alt_tag;

        $data['is_bookable'] = implode(',', $request->is_bookable);
        if (isset($request->form_fields)) {
            $data['form_fields'] = implode(",", $request->form_fields);
        }
        if (isset($request->form_fields_two)) {
            $data['form_fields_two'] = implode(",", $request->form_fields_two);
        }

        $data['step_1_title'] = $request->step_1_title;
        $data['step_2_title'] = $request->step_2_title;
        $data['step_3_title'] = $request->step_3_title;
        $data['step_4_title'] = $request->step_4_title;

        for ($i = 1; $i <= 4; $i++) {
            $field = 'step_' . $i . '_image';
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $fileName = time() . '-' . str_replace(' ', '-', $file->getClientOriginalName());
                $path = public_path('upload/subservice/');
                if (!\File::exists($path)) {
                    \File::makeDirectory($path, 0755, true);
                }
                $file->move($path, $fileName);
                $data[$field] = $fileName;
            }
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalName = $file->getClientOriginalName();
            $modifiedName = str_replace(' ', '-', $originalName);
            $modifiedName = trim($modifiedName);
            $fileName = time() . '-' . $modifiedName;

            $pathOriginal = public_path('upload/subservice/');
            $pathLarge = public_path('upload/subservice/large/');
            $pathMedium = public_path('upload/subservice/medium/');
            $pathSmall = public_path('upload/subservice/small/');

            // Create directories if they don't exist
            foreach ([$pathOriginal, $pathLarge, $pathMedium, $pathSmall] as $path) {
                if (!\File::exists($path)) {
                    \File::makeDirectory($path, 0755, true);
                }
            }

            // Get temporary path for the uploaded file
            $tempPath = $file->getRealPath();

            // Save original
            \File::copy($tempPath, $pathOriginal . $fileName);

            // Resize and save large (840x570)
            Image::make($tempPath)
                ->resize(840, 570)
                ->save($pathLarge . $fileName);

            // Resize and save medium (150x105)
            Image::make($tempPath)
                ->resize(150, 105)
                ->save($pathMedium . $fileName);

            // Resize and save small (95x65)
            Image::make($tempPath)
                ->resize(95, 65)
                ->save($pathSmall . $fileName);

            // Save image name
            $data['image'] = $fileName;
        }


        // if ($request->hasFile('banner_image')) {
        //     $file = $request->file('banner_image');
        //     $originalName = $file->getClientOriginalName();  // Get the original file name
        //     $path1 = public_path('upload/subservice/banner/large/');
        //     $path2 = public_path('upload/subservice/banner/');

        //     $modifiedName = str_replace(' ', '-', $originalName);
        //     // Optionally, you can remove any unwanted spaces from the start or end (trim)
        //     $modifiedName = trim($modifiedName);
        //     $fileName = time() . '-'. $modifiedName;

        //    // echo"<pre>";print_r($file);echo"</pre>";


        //     // Move the file to the first path
        //     $file->move($path1, $fileName);

        //     // Copy the file to other paths
        //     \File::copy($path1 . $fileName, $path2 . $fileName);

        //     // Store the file name
        //     $data['banner_image'] = $fileName;

        // }
        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $originalName = $file->getClientOriginalName();
            $path1 = public_path('upload/subservice/banner/large/');
            $path2 = public_path('upload/subservice/banner/');

            $modifiedName = str_replace(' ', '-', $originalName);
            $modifiedName = trim($modifiedName);
            $fileName = time() . '-' . $modifiedName;

            // Ensure directories exist
            if (!File::exists($path1)) {
                File::makeDirectory($path1, 0755, true);
            }
            if (!File::exists($path2)) {
                File::makeDirectory($path2, 0755, true);
            }

            // Resize and save image using Intervention Image
            $image = Image::make($file)
                ->resize(1350, 440, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($path1 . $fileName);

            // Copy to the second path
            File::copy($path1 . $fileName, $path2 . $fileName);

            // Store the file name
            $data['banner_image'] = $fileName;
        }

        if ($request->hasFile('mobile_banner_image')) {

            $file = $request->file('mobile_banner_image');
            $originalName = $file->getClientOriginalName();
            $path1 = public_path('upload/subservice/banner/medium/');
            $path2 = public_path('upload/subservice/banner/');

            $modifiedName = str_replace(' ', '-', $originalName);
            $modifiedName = trim($modifiedName);
            $fileName = time() . '-' . $modifiedName;


            // Ensure directories exist
            if (!File::exists($path1)) {
                File::makeDirectory($path1, 0755, true);
            }
            // Resize and save image using Intervention Image
            $image = Image::make($file)
                ->resize(400, 475, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($path1 . $fileName);

            $file->move($path2, $fileName);
            // Store the file name
            $data['mobile_banner_image'] = $fileName;
        }

        if ($request->hasFile('service_detail_image')) {
            $service_detail_image = $request->file('service_detail_image');
            $extension = $service_detail_image->getClientOriginalExtension();
            $originalName = pathinfo($service_detail_image->getClientOriginalName(), PATHINFO_FILENAME);
            $service_detail_imageName = time() . '-' . $originalName . '.' . $extension;
            if (strtolower($extension) === 'webp' || strtolower($extension) === 'avif') {
                // Move to the large folder first
                $largeDestinationPath = public_path('upload/subservice/large/' . $service_detail_imageName);
                $service_detail_image->move(public_path('upload/subservice/large'), $service_detail_imageName);

                // Copy the file to other directories
                copy($largeDestinationPath, public_path('upload/subservice/' . $service_detail_imageName));
            } elseif (strtolower($extension) === 'svg') {
                // Handle SVG files — just move them without resizing
                $service_detail_image->move(public_path('upload/subservice'), $service_detail_imageName);
            } else {
                $largeDestinationPath = public_path('upload/subservice/large' . $service_detail_imageName);
                $this->resizeImage($service_detail_image->getRealPath(), $largeDestinationPath, 513, 180);
                $service_detail_image->move(public_path('upload/subservice'), $service_detail_imageName);
            }
            $data['service_detail_image'] = $service_detail_imageName;
        }       // echo"<pre>";print_r($_POST);echo"</pre>";

        // echo"<pre>";print_r($data);echo"</pre>";exit;

        DB::table('subservices')->where('id', $id)->update($data);

        if (!empty($_POST['city_addmore_top_description']) && is_array($_POST['city_addmore_top_description'])) {
            for ($i = 0; $i < count($_POST['city_addmore_top_description']); $i++) {


                if (!empty($_POST['city_addmore_top_description'][$i])) {
                    $content['city'] = $_POST['city_addmore_top_description'][$i];
                    $content['description'] = $_POST['description_addmore_top_description'][$i];
                    $content['p_id'] = $id;
                    $this->insert_attribute_top_description($content);
                }
            }
        }

        if ($request->city_addmore_top_descriptionu != '' && count($request->city_addmore_top_descriptionu) > 0) {
            for ($i = 0; $i < count($_POST['city_addmore_top_descriptionu']); $i++) {
                //echo"<pre>";print_r($_FILES['imageu_'.$i]);echo"</pre>";exit;
                if ($_POST['city_addmore_top_descriptionu'][$i] != '') {
                    $contentu['city'] = $_POST['city_addmore_top_descriptionu'][$i];
                    $contentu['p_id'] = $id;
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
                        ->save(public_path('upload/subservice/banner_attr/large/' . $filename));

                    Image::make($image)
                        ->save(public_path('upload/subservice/banner_attr/' . $filename));

                    $content['image'] = $filename;
                } else {
                    $content['image'] = '';
                }

                if (!empty($_FILES['mobile_banner_image_addmore1']['name'][$i])) {
                    $image = $_FILES['mobile_banner_image_addmore1']['tmp_name'][$i];
                    $originalName = $_FILES['mobile_banner_image_addmore1']['name'][$i];

                    $filename = time() . '-' . str_replace(' ', '-', $originalName);

                    Image::make($image)
                        ->resize(400, 475)
                        ->save(public_path('upload/subservice/mobile_banner/large/' . $filename));

                    Image::make($image)
                        ->save(public_path('upload/subservice/mobile_banner/' . $filename));

                    $content['mobile_banner_image'] = $filename;
                } else {
                    $content['mobile_banner_image'] = '';
                }

                if (!empty($_POST['city_addmore_banner1'][$i])) {
                    $content['city'] = $_POST['city_addmore_banner1'][$i];
                    $content['p_id'] = $id;
                    $content['title'] = $_POST['title_addmore_banner1'][$i] ?? '';
                    $content['description_addmore_banner'] = $_POST['description_addmore_banner1'][$i] ?? '';

                    //             echo"<pre>";
                    // print_r($content);
                    // echo"</pre>";
                    // exit;

                    $this->insert_banner_attribute($content);
                }
            }
        }


        if (count($_POST['title_addmore1']) > 0 && $_POST['title_addmore1'] != '') {

            for ($i = 0; $i < count($_POST['title_addmore1']); $i++) {

                if (isset($_FILES['e_image1_' . $i]['name']) && $_FILES['e_image1_' . $i]['name'] != '') {

                    $image = $_FILES['e_image1_' . $i]['tmp_name'];

                    $originalName = $_FILES['e_image1_' . $i]['name']; // Get the original file name

                    $filename = time() . '-' . str_replace(' ', '-', $originalName);


                    Image::make($image)

                        ->resize(510, 340)

                        ->save(public_path('upload/subservice/subservice_attr/large/' . $filename));


                    Image::make($image)

                        ->save(public_path('upload/subservice/subservice_attr/' . $filename));


                    $content['image'] = $filename;
                } else {
                    $content['image'] = '';
                }

                if ($_POST['title_addmore1'][$i] != '') {

                    $content['city'] = $_POST['city_addmore_second1'][$i];

                    $content['p_id'] = $id;

                    $content['title_addmore'] = $_POST['title_addmore1'][$i];

                    $content['description_addmore'] = $_POST['description_addmore1'][$i];
                    $content['image_alt_tag_addmore'] = $_POST['image_alt_tag_addmore1'][$i];

                    $this->insert_package_attribute($content);
                }
            }
        }


        if ($request->title_addmoreu != '' && count($request->title_addmoreu) > 0) {

            for ($i = 0; $i < count($_POST['title_addmoreu']); $i++) {

                //echo"<pre>";print_r($_FILES['imageu_'.$i]);echo"</pre>";exit;
                if ($_POST['title_addmoreu'][$i] != '') {
                    //

                    if ($_FILES['imageu_' . $i]['name'] != '') {
                        $image = $_FILES['imageu_' . $i]['tmp_name'];


                        $originalName = $_FILES['imageu_' . $i]['name']; // Get the original file name

                        $filename = time() . '-' . str_replace(' ', '-', $originalName);


                        Image::make($image)

                            ->resize(510, 340)

                            ->save(public_path('upload/subservice/subservice_attr/large/' . $filename));


                        Image::make($image)

                            ->save(public_path('upload/subservice/subservice_attr/' . $filename));


                        $contentu['image'] = $filename;
                    } else {

                        $contentu['image'] = '';
                    }
                    $contentu['city'] = $_POST['city_addmore_secondu'][$i];
                    $contentu['p_id'] = $id;

                    $contentu['title_addmore'] = $_POST['title_addmoreu'][$i];

                    $contentu['description_addmore'] = $_POST['description_addmoreu'][$i];
                    $contentu['image_alt_tag_addmore'] = $_POST['image_alt_tag_addmoreu'][$i];

                    $contentu['updateid1xxx1'] = $_POST['updateid1xxx1'][$i];


                    // echo"<pre>";print_r($contentu);echo"</pre>";exit;
                    $this->update_Package_attribute($contentu);
                }
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
                            ->save(public_path('upload/subservice/mobile_banner/large/' . $filename));

                        // Save original
                        Image::make($image)
                            ->save(public_path('upload/subservice/mobile_banner/' . $filename));

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

                if ($_POST['city_addmore_thirdu'][$i] != '') {
                    $content['subservice_id'] = $id;
                    $content['city'] = $_POST['city_addmore_thirdu'][$i];
                    $content['meta_title'] = $_POST['meta_title_addmoreu'][$i];
                    $content['meta_keyword'] = $_POST['meta_keyword_addmoreu'][$i];
                    $content['meta_description'] = $_POST['meta_description_addmoreu'][$i];
                    $content['updateid1xxx2'] = $_POST['updateid1xxx2'][$i];
                    $this->update_subservice_contains($content);
                }
            }
        }
        if (count($_POST['city_addmore_third1']) > 0 && $_POST['city_addmore_third1'] != '') {
            for ($i = 0; $i < count($_POST['city_addmore_third1']); $i++) {

                if ($_POST['city_addmore_third1'][$i] != '') {
                    $content['subservice_id'] = $id;
                    $content['city'] = $_POST['city_addmore_third1'][$i];
                    $content['meta_title'] = $_POST['meta_title_addmore1'][$i];
                    $content['meta_keyword'] = $_POST['meta_keyword_addmore1'][$i];
                    $content['meta_description'] = $_POST['meta_description_addmore1'][$i];
                    $this->insert_subservice_contains($content);
                }
            }
        }

        if (isset($_POST['city_addmore_why_chooseu']) && count($_POST['city_addmore_why_chooseu']) > 0 && $_POST['city_addmore_why_chooseu'] != '') {
            for ($i = 0; $i < count($_POST['city_addmore_why_chooseu']); $i++) {
                if ($_POST['city_addmore_why_chooseu'][$i] != '') {
                    $content['subservice_id'] = $id;
                    $content['city'] = $_POST['city_addmore_why_chooseu'][$i];
                    $content['description'] = $_POST['whychoosevc_addmoreu'][$i];
                    $content['updateid_why_choose'] = $_POST['updateid_why_choose'][$i];
                    $this->update_why_choose_attribute($content);
                }
            }
        }
        if (isset($_POST['city_addmore_why_choose1']) && count($_POST['city_addmore_why_choose1']) > 0 && $_POST['city_addmore_why_choose1'] != '') {
            for ($i = 0; $i < count($_POST['city_addmore_why_choose1']); $i++) {
                if ($_POST['city_addmore_why_choose1'][$i] != '') {
                    $content['subservice_id'] = $id;
                    $content['city'] = $_POST['city_addmore_why_choose1'][$i];
                    $content['description'] = $_POST['whychoosevc_addmore1'][$i];
                    $this->insert_why_choose_attribute($content);
                }
            }
        }

        if (isset($_POST['city_addmore_more_serviceu']) && count($_POST['city_addmore_more_serviceu']) > 0 && $_POST['city_addmore_more_serviceu'] != '') {
            for ($i = 0; $i < count($_POST['city_addmore_more_serviceu']); $i++) {
                if ($_POST['city_addmore_more_serviceu'][$i] != '') {
                    $content['subservice_id'] = $id;
                    $content['city'] = $_POST['city_addmore_more_serviceu'][$i];
                    $content['more_subservice_id'] = isset($_POST['subservice_addmore_more_serviceu'][$i]) ? implode(",", (array)$_POST['subservice_addmore_more_serviceu'][$i]) : '';
                    $content['updateid_more_service'] = $_POST['updateid_more_service'][$i];
                    $this->update_more_service_attribute($content);
                }
            }
        }
        if (isset($_POST['city_addmore_more_service1']) && count($_POST['city_addmore_more_service1']) > 0 && $_POST['city_addmore_more_service1'] != '') {
            for ($i = 0; $i < count($_POST['city_addmore_more_service1']); $i++) {
                if ($_POST['city_addmore_more_service1'][$i] != '') {
                    $content['subservice_id'] = $id;
                    $content['city'] = $_POST['city_addmore_more_service1'][$i];
                    $content['more_subservice_id'] = isset($_POST['subservice_addmore_more_service1'][$i]) ? implode(",", (array)$_POST['subservice_addmore_more_service1'][$i]) : '';
                    $this->insert_more_service_attribute($content);
                }
            }
        }

        if (isset($_POST['city_addmore_what_else_serviceu']) && count($_POST['city_addmore_what_else_serviceu']) > 0 && $_POST['city_addmore_what_else_serviceu'] != '') {
            for ($i = 0; $i < count($_POST['city_addmore_what_else_serviceu']); $i++) {
                if ($_POST['city_addmore_what_else_serviceu'][$i] != '') {
                    $content['subservice_id'] = $id;
                    $content['city'] = $_POST['city_addmore_what_else_serviceu'][$i];
                    $content['what_else_subservice_id'] = isset($_POST['subservice_addmore_what_else_serviceu'][$i]) ? implode(",", (array)$_POST['subservice_addmore_what_else_serviceu'][$i]) : '';
                    $content['updateid_what_else_service'] = $_POST['updateid_what_else_service'][$i];
                    $this->update_what_else_service_attribute($content);
                }
            }
        }
        if (isset($_POST['city_addmore_what_else_service1']) && count($_POST['city_addmore_what_else_service1']) > 0 && $_POST['city_addmore_what_else_service1'] != '') {
            for ($i = 0; $i < count($_POST['city_addmore_what_else_service1']); $i++) {
                if ($_POST['city_addmore_what_else_service1'][$i] != '') {
                    $content['subservice_id'] = $id;
                    $content['city'] = $_POST['city_addmore_what_else_service1'][$i];
                    $content['what_else_subservice_id'] = isset($_POST['subservice_addmore_what_else_service1'][$i]) ? implode(",", (array)$_POST['subservice_addmore_what_else_service1'][$i]) : '';
                    $this->insert_what_else_service_attribute($content);
                }
            }
        }

        if (isset($_POST['city_addmore_descriptionu']) && count($_POST['city_addmore_descriptionu']) > 0 && $_POST['city_addmore_descriptionu'] != '') {
            for ($i = 0; $i < count($_POST['city_addmore_descriptionu']); $i++) {
                if ($_POST['city_addmore_descriptionu'][$i] != '') {
                    $descId = $_POST['updateid_description'][$i];
                    $descriptionModel = \App\Models\Admin\SubserviceDescription::find($descId);
                    if ($descriptionModel) {
                        $descriptionModel->city = $_POST['city_addmore_descriptionu'][$i];
                        $descriptionModel->description = $_POST['description_addmore_newu'][$i] ?? '';
                        $descriptionModel->save();
                    }
                }
            }
        }

        if (isset($_POST['city_addmore_description1']) && count($_POST['city_addmore_description1']) > 0 && $_POST['city_addmore_description1'] != '') {
            for ($i = 0; $i < count($_POST['city_addmore_description1']); $i++) {
                if ($_POST['city_addmore_description1'][$i] != '') {
                    \App\Models\Admin\SubserviceDescription::create([
                        'subservice_id' => $id,
                        'city' => $_POST['city_addmore_description1'][$i],
                        'description' => $_POST['description_addmore_new1'][$i] ?? ''
                    ]);
                }
            }
        }

        //   echo"<pre>";print_r($data);echo"</pre>";exit;

        return redirect()->route('subservice.index')->with('success', 'Sub Service Updated Successfully');
    }

    function insert_attribute_top_description($content)
    {

        $data['city'] = $content['city'];
        $data['subservice_id'] = $content['p_id'];
        $data['description'] = $content['description'];
        DB::table('subservice_top_description_attr')->insertGetId($data);
    }

    function update_attribute_top_description($content)
    {

        //echo"<pre>";print_r($content);echo"</pre>";exit;
        $data['city'] = $content['city'];

        $data['subservice_id'] = $content['p_id'];
        $data['description'] = $content['description'];
        DB::table('subservice_top_description_attr')->where('id', $content['updateid1xxx1_top_description'])->update($data);
    }

    function update_subservice_contains($content)
    {
        $data['subservice_id'] = $content['subservice_id'];
        $data['city'] = $content['city'];
        $data['meta_title'] = $content['meta_title'];
        $data['meta_keyword'] = $content['meta_keyword'];
        $data['meta_description'] = $content['meta_description'];
        DB::table('sub_service_contains')->where('id', $content['updateid1xxx2'])->update($data);
    }
    function removed_subservice_contain_att(Request $request)
    {
        $subservice = $request->pid;

        $id = $request->id;

        $result = DB::table('sub_service_contains')->where('subservice_id', '=', $subservice)->where('id', '=', $id)->delete();

        return redirect()->route('subservice.edit', $subservice)->with('success', 'SubService Contain attribute deleted successfully');
    }

    function insert_why_choose_attribute($content)
    {
        $data['subservice_id'] = $content['subservice_id'];
        $data['city'] = $content['city'];
        $data['description'] = $content['description'];
        $data['created_at'] = date('Y-m-d H:i:s');
        DB::table('subservice_why_choose_attr')->insertGetId($data);
    }

    function update_why_choose_attribute($content)
    {
        $data['city'] = $content['city'];
        $data['description'] = $content['description'];
        $data['updated_at'] = date('Y-m-d H:i:s');
        DB::table('subservice_why_choose_attr')->where('id', $content['updateid_why_choose'])->update($data);
    }

    function removed_why_choose_att(Request $request)
    {
        $subservice = $request->pid;
        $id = $request->id;
        $result = DB::table('subservice_why_choose_attr')->where('subservice_id', '=', $subservice)->where('id', '=', $id)->delete();
        return redirect()->route('subservice.edit', $subservice)->with('success', 'Why Choose VendorCity attribute deleted successfully');
    }

    function removed_description_att(Request $request)
    {
        $subservice = $request->pid;
        $id = $request->id;
        $result = \App\Models\Admin\SubserviceDescription::where('subservice_id', '=', $subservice)->where('id', '=', $id)->delete();
        return redirect()->route('subservice.edit', $subservice)->with('success', 'Description attribute deleted successfully');
    }
    function removed_subservice_banner_addmore_att(Request $request)
    {
        $subservice = $request->pid;

        $id = $request->id;

        $result = DB::table('subservice_banner_attr')->where('subservice_id', '=', $subservice)->where('id', '=', $id)->delete();

        return redirect()->route('subservice.edit', $subservice)->with('success', 'SubService banner attribute deleted successfully');
    }

    function update_Package_attribute($content)
    {

        //echo"<pre>";print_r($content);echo"</pre>";exit;
        $data['city'] = $content['city'];

        $data['pid'] = $content['p_id'];

        $data['title_addmore'] = $content['title_addmore'];

        if ($content['image'] != '') {
            $data['image'] = $content['image'];
        }
        $data['description_addmore'] = $content['description_addmore'];
        $data['image_alt_tag'] = $content['image_alt_tag_addmore'];

        DB::table('subservice_attr')->where('id', $content['updateid1xxx1'])->update($data);
    }


    function update_banner_attribute($content)
    {
        $data['city'] = $content['city'];
        $data['subservice_id'] = $content['p_id'];

        $data['title'] = $content['title_addmore'];

        if ($content['image'] != '') {
            $data['image'] = $content['image'];
        }
        if ($content['mobile_banner_image'] != '') {
            $data['mobile_banner_image'] = $content['mobile_banner_image'];
        }
        $data['short_description'] = $content['description_addmore'];

        DB::table('subservice_banner_attr')->where('id', $content['updateid1xxx0'])->update($data);
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

        Subservice::whereIn('id', $delete_id)->delete();

        return redirect()->route('subservice.index')->with('success', 'Sub Service Deleted Successfully');
    }
    public function set_order_subservice()
    {

        $id = $_POST['id'];

        $val = $_POST['val'];

        // echo $id."-".$val;exit;

        DB::table('subservices')->where('id', $id)->update(array('set_order' => $val));

        echo "1";

        // return redirect()->route('product.index')->with('success','Set Order has been Updated successfully');

    }

    function change_status_subservice()
    {

        $id = $_POST['id'];

        $value = $_POST['value'];

        DB::table('subservices')->where('id', $id)->update(array('is_active' => $value));

        echo "1";
    }
    private function resizeImage($sourcePath, $destinationPath, $newWidth, $newHeight)
    {
        list($width, $height, $type) = getimagesize($sourcePath);
        switch ($type) {
            case IMAGETYPE_JPEG:
                $src = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $src = imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
                $src = imagecreatefromgif($sourcePath);
                break;
            default:
                throw new \Exception('Unsupported image type');
        }
        $dst = imagecreatetruecolor($newWidth, $newHeight);
        // Preserve transparency for PNG and GIF images
        if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
            imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
        }
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($dst, $destinationPath);
                break;
            case IMAGETYPE_PNG:
                imagepng($dst, $destinationPath);
                break;
            case IMAGETYPE_GIF:
                imagegif($dst, $destinationPath);
                break;
        }
        imagedestroy($src);
        imagedestroy($dst);
    }

    function subservice_removed_top_descatt(Request $request)
    {

        $subservice = $request->pid;

        $id = $request->id;

        $result = DB::table('subservice_top_description_attr')->where('subservice_id', '=', $subservice)->where('id', '=', $id)->delete();

        return redirect()->route('subservice.edit', $subservice)->with('success', 'Top Description attribute deleted successfully');
    }

    function removed_more_service_att(Request $request)
    {
        $subservice = $request->pid;
        $id = $request->id;
        DB::table('subservice_more_services')->where('subservice_id', '=', $subservice)->where('id', '=', $id)->delete();
        return redirect()->route('subservice.edit', $subservice)->with('success', 'More Service attribute deleted successfully');
    }

    function insert_more_service_attribute($content)
    {
        $data['subservice_id'] = $content['subservice_id'];
        $data['city'] = $content['city'];
        $data['more_subservice_id'] = $content['more_subservice_id'];
        $data['created_at'] = date('Y-m-d H:i:s');
        DB::table('subservice_more_services')->insertGetId($data);
    }

    function update_more_service_attribute($content)
    {
        $data['city'] = $content['city'];
        $data['more_subservice_id'] = $content['more_subservice_id'];
        $data['updated_at'] = date('Y-m-d H:i:s');
        DB::table('subservice_more_services')->where('id', $content['updateid_more_service'])->update($data);
    }

    function removed_what_else_att(Request $request)
    {
        $subservice = $request->pid;
        $id = $request->id;
        DB::table('subservice_what_else_services')->where('subservice_id', '=', $subservice)->where('id', '=', $id)->delete();
        return redirect()->route('subservice.edit', $subservice)->with('success', 'What Else Service attribute deleted successfully');
    }

    function insert_what_else_service_attribute($content)
    {
        $data['subservice_id'] = $content['subservice_id'];
        $data['city'] = $content['city'];
        $data['what_else_subservice_id'] = $content['what_else_subservice_id'];
        $data['created_at'] = date('Y-m-d H:i:s');
        DB::table('subservice_what_else_services')->insertGetId($data);
    }

    function update_what_else_service_attribute($content)
    {
        $data['city'] = $content['city'];
        $data['what_else_subservice_id'] = $content['what_else_subservice_id'];
        $data['updated_at'] = date('Y-m-d H:i:s');
        DB::table('subservice_what_else_services')->where('id', $content['updateid_what_else_service'])->update($data);
    }
}
