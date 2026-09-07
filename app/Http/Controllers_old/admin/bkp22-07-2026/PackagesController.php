<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\Admin\Packages;
use DB;
use Image;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['packages_data'] = DB::table('packages')->orderBy('id', 'DESC')->get();
        return view('admin.list_packages', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['service_data'] = DB::table('services')->select('*')->orderBy('id', 'DESC')->get();
        $data['subservice_data'] = DB::table('subservices')->select('*')->orderBy('id', 'DESC')->get();
        $data['package_categories_data'] = DB::table('package_categories')->select('*')->orderBy('id', 'DESC')->get();
        return view('admin.add_packages', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo "<pre>";print_r($request->all());echo "</pre>";exit;

        $data['service_id'] = $request->service_id;
        $data['subservice_id'] = $request->subservice_id;
        $data['packagecategory_id'] = $request->packagecategory_id;
        $data['title'] = $request->title;
        $data['sub_title'] = $request->sub_title;
        $data['name'] = $request->name;
        $data['page_url'] = $request->page_url;
        $data['price'] = $request->price;
        $data['short_description'] = $request->short_description;
        $data['description'] = $request->description;
        $data['term_condition'] = $request->term_condition;
        $data['discount'] = $request->discount;
        $data['discount_type'] = $request->discount_type;
        $data['booking_service_per'] = $request->booking_service_per;

        $data['image_alt_tag'] = $request->image_alt_tag;
        $data['popup_image_alt_tag'] = $request->popup_image_alt_tag;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = time() . '-' . $originalName . '.' . $extension;
            if (strtolower($extension) === 'webp' || strtolower($extension) === 'avif') {
                // Move to the large folder first
                $largeDestinationPath = public_path('upload/packages/large/' . $imageName);
                $image->move(public_path('upload/packages/large'), $imageName);

                // Copy the file to other directories
                copy($largeDestinationPath, public_path('upload/packages/popupimage/' . $imageName));
            } else {
                $largeDestinationPath = public_path('upload/packages/large/' . $imageName);
                $this->resizeImage($image->getRealPath(), $largeDestinationPath, 97, 97);
                $image->move(public_path('upload/packages/popupimage/'), $imageName);
            }
            $data['image'] = $imageName;
        } else {
            $data['image'] = "";
        }


        if ($request->hasFile('popup_image')) {
            $popup_image = $request->file('popup_image');
            $extension = $popup_image->getClientOriginalExtension();
            $originalName = pathinfo($popup_image->getClientOriginalName(), PATHINFO_FILENAME);
            $popup_imageName = time() . '-' . $originalName . '.' . $extension;
            if (strtolower($extension) === 'webp' || strtolower($extension) === 'avif') {
                // Move to the large folder first
                $largeDestinationPath = public_path('upload/packages/popupimage/large/' . $popup_imageName);
                $popup_image->move(public_path('upload/packages/popupimage/large'), $popup_imageName);

                // Copy the file to other directories
                copy($largeDestinationPath, public_path('upload/packages/popupimage/' . $popup_imageName));
            } else {
                $largeDestinationPath = public_path('upload/packages/popupimage/' . $popup_imageName);
                $this->resizeImage($popup_image->getRealPath(), $largeDestinationPath, 500, 160);
                $popup_image->move(public_path('upload/packages/popupimage/'), $popup_imageName);
            }
            $data['popup_image'] = $popup_imageName;
        } else {
            $data['popup_image'] = "";
        }



        // echo"<pre>";
        // print_r($data);
        // echo"</pre>";exit;
        $package_id = DB::table('packages')->insertGetId($data);

        if (count($_POST['title_addmore']) > 0 && $_POST['title_addmore'] != '') {
            for ($i = 0; $i < count($_POST['title_addmore']); $i++) {
                if ($_FILES['image_' . $i]['name'] != '') {
                    $image = $_FILES['image_' . $i]['tmp_name'];
                    $originalName = $_FILES['image_' . $i]['name']; // Get the original file name    
                    $filename = time() . '-' . str_replace(' ', '-', $originalName);

                    Image::make($image)
                        ->resize(510, 340)
                        ->save(public_path('upload/packages/packages_attr/large/' . $filename));

                    Image::make($image)
                        ->save(public_path('upload/packages/packages_attr/' . $filename));

                    $content['image']   = $filename;
                }
                if ($_POST['title'][$i] != '') {
                    $content['p_id'] = $package_id;
                    $content['title_addmore'] = $_POST['title_addmore'][$i];
                    $content['description_addmore'] = $_POST['description_addmore'][$i];
                    $content['image_alt_tag_addmore'] = $_POST['image_alt_tag_addmore'][$i];
                    $this->insert_package_attribute($content);
                }
            }
        }





        if (count($_POST['others']) > 0 && $_POST['others'] != '') {

            for ($i = 0; $i < count($_POST['others']); $i++) {

                if ($_POST['others'][$i] != '') {

                    $content['pid'] = $package_id;

                    $content['others'] = $_POST['others'][$i];

                    $this->inserts_attribute($content);
                }
            }
        }
        if (count($_POST['incluser_name']) > 0 && $_POST['incluser_name'] != '') {

            for ($i = 0; $i < count($_POST['incluser_name']); $i++) {

                if ($_POST['incluser_name'][$i] != '') {

                    $content['pid'] = $package_id;

                    $content['incluser_name'] = $_POST['incluser_name'][$i];

                    $this->insert_attribute($content);
                }
            }
        }

        if (count($_POST['excluser_name']) > 0 && $_POST['excluser_name'] != '') {

            for ($i = 0; $i < count($_POST['excluser_name']); $i++) {

                if ($_POST['excluser_name'][$i] != '') {

                    $content['pid'] = $package_id;

                    $content['excluser_name'] = $_POST['excluser_name'][$i];

                    $this->insertt_attribute($content);
                }
            }
        }


        return redirect()->route('packages.index')->with('success', 'Packages Data Added Successfully');
    }
    function insert_package_attribute($content)
    {

        $data['pid'] = $content['p_id'];

        $data['title_addmore'] = $content['title_addmore'];
        if (isset($content['image'])) {
            $data['image'] = $content['image'];
        }


        $data['description_addmore'] = $content['description_addmore'];
        $data['image_alt_tag_addmore'] = $content['image_alt_tag_addmore'];



        DB::table('package_attr')->insertGetId($data);
    }
    function inserts_attribute($content)
    {

        $data['pid'] = $content['pid'];
        $data['others'] = $content['others'];

        DB::table('packages_others')->insertGetId($data);
    }
    function insert_attribute($content)
    {

        $data['pid'] = $content['pid'];
        $data['incluser_name'] = $content['incluser_name'];

        DB::table('packages_incluser')->insertGetId($data);
    }
    function insertt_attribute($content)
    {

        $data['pid'] = $content['pid'];
        $data['excluser_name'] = $content['excluser_name'];

        DB::table('packages_excluser')->insertGetId($data);
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
     * // echo "<pre>";print_r($data['subservice_data']);echo "</pre>";exit;
     */
    public function edit($id)
    {
        // echo "<pre>";print_r($id);echo "</pre>";exit;
        $data['packages'] = DB::table('packages')->where('id', $id)->first();
        $data['attributess_data'] = DB::table('packages_others')
            ->select('*')
            ->where('pid', '=', $data['packages']->id)
            ->get()
            ->toArray();
        $data['attribute_data'] = DB::table('packages_incluser')
            ->select('*')
            ->where('pid', '=', $data['packages']->id)
            ->get()
            ->toArray();
        $data['attributes_data'] = DB::table('packages_excluser')
            ->select('*')
            ->where('pid', '=', $data['packages']->id)
            ->get()
            ->toArray();
        $data['package_attribute_data'] = DB::table('package_attr')
            ->select('*')
            ->where('pid', '=', $data['packages']->id)
            ->get()
            ->toArray();

        // echo"<pre>";
        // print_r( $data['package_attribute_data']);
        // echo"</pre>";exit;



        $data['service_data'] = DB::table('services')->select('*')->orderBy('id', 'DESC')->get();
        $data['subservice_data'] = DB::table('subservices')->select('*')->where('serviceid', $data['packages']->service_id)->orderBy('id', 'DESC')->get();
        $data['packagecat_data'] = DB::table('package_categories')->select('*')->where('subservice_id', $data['packages']->subservice_id)->orderBy('id', 'DESC')->get();
        return view('admin.edit_packages', $data);
    }
    public function remove_others_att(Request $request)
    {

        $others_id = $request->pid;

        $id = $request->id;

        $result = DB::table('packages_others')->where('pid', '=', $others_id)->where('id', '=', $id)->delete();

        return redirect()->route('packages.edit', $others_id)->with('success', 'deleted successfully');
    }
    public function remove_packages_att(Request $request)
    {

        $packages_id = $request->pid;

        $id = $request->id;

        $result = DB::table('packages_incluser')->where('pid', '=', $packages_id)->where('id', '=', $id)->delete();

        return redirect()->route('packages.edit', $packages_id)->with('success', 'deleted successfully');
    }
    public function remove_package_att(Request $request)
    {

        $packages_id = $request->pid;

        $id = $request->id;

        $result = DB::table('packages_excluser')->where('pid', '=', $packages_id)->where('id', '=', $id)->delete();

        return redirect()->route('packages.edit', $packages_id)->with('success', 'deleted successfully');
    }
    public function remove_addmore_att(Request $request)
    {



        $service = $request->pid;

        $id = $request->id;

        $result = DB::table('package_attr')->where('pid', '=', $service)->where('id', '=', $id)->delete();

        return redirect()->route('packages.edit', $service)->with('success', 'deleted successfully');
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
        // echo "<pre>";print_r($request->post());echo "</pre>";exit;
        $data['service_id'] = $request->service_id;
        $data['subservice_id'] = $request->subservice_id;
        $data['packagecategory_id'] = $request->packagecategory_id;
        $data['title'] = $request->title;
        $data['sub_title'] = $request->sub_title;
        $data['name'] = $request->name;
        $data['page_url'] = $request->page_url;
        $data['price'] = $request->price;
        $data['short_description'] = $request->short_description;
        $data['description'] = $request->description;
        $data['term_condition'] = $request->term_condition;
        $data['discount'] = $request->discount;
        $data['discount_type'] = $request->discount_type;
        $data['booking_service_per'] = $request->booking_service_per;


        $data['image_alt_tag'] = $request->image_alt_tag;
        $data['popup_image_alt_tag'] = $request->popup_image_alt_tag;


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = time() . '-' . $originalName . '.' . $extension;
            if (strtolower($extension) === 'webp' || strtolower($extension) === 'avif') {
                // Move to the large folder first
                $largeDestinationPath = public_path('upload/packages/large/' . $imageName);
                $image->move(public_path('upload/packages/large'), $imageName);

                // Copy the file to other directories
                copy($largeDestinationPath, public_path('upload/packages/popupimage/' . $imageName));
            } else {
                $largeDestinationPath = public_path('upload/packages/large/' . $imageName);
                $this->resizeImage($image->getRealPath(), $largeDestinationPath, 97, 97);
                $image->move(public_path('upload/packages'), $imageName);
            }
            $data['image'] = $imageName;
        }

        if ($request->hasFile('popup_image')) {
            $popup_image = $request->file('popup_image');
            $extension = $popup_image->getClientOriginalExtension();
            $originalName = pathinfo($popup_image->getClientOriginalName(), PATHINFO_FILENAME);
            $popup_imageName = time() . '-' . $originalName . '.' . $extension;
            if (strtolower($extension) === 'webp' || strtolower($extension) === 'avif') {
                // Move to the large folder first
                $largeDestinationPath = public_path('upload/packages/popupimage/large/' . $popup_imageName);
                $popup_image->move(public_path('upload/packages/popupimage/large'), $popup_imageName);

                // Copy the file to other directories
                copy($largeDestinationPath, public_path('upload/packages/popupimage/' . $popup_imageName));
            } else {
                $largeDestinationPath = public_path('upload/packages/popupimage/' . $popup_imageName);
                $this->resizeImage($popup_image->getRealPath(), $largeDestinationPath, 500, 160);
                $popup_image->move(public_path('upload/packages'), $popup_imageName);
            }
            $data['popup_image'] = $popup_imageName;
        }


        DB::table('packages')->where('id', $id)->update($data);

        if (count($_POST['title_addmore1']) > 0 && $_POST['title_addmore1'] != '') {

            for ($i = 0; $i < count($_POST['title_addmore1']); $i++) {

                if ($_FILES['e_image1_' . $i]['name'] != '') {

                    $image = $_FILES['e_image1_' . $i]['tmp_name'];

                    $originalName = $_FILES['e_image1_' . $i]['name']; // Get the original file name

                    $filename = time() . '-' . str_replace(' ', '-', $originalName);


                    Image::make($image)

                        ->resize(510, 340)

                        ->save(public_path('upload/packages/packages_attr/large/' . $filename));


                    Image::make($image)

                        ->save(public_path('upload/packages/packages_attr/' . $filename));


                    $content['image']   = $filename;
                } else {
                    $content['image']  = '';
                }

                if ($_POST['title_addmore1'][$i] != '') {



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

                //  echo"<pre>";print_r($_FILES['imageu_'.$i]);echo"</pre>";exit;
                if ($_POST['title_addmoreu'][$i] != '') {
                    //

                    if ($_FILES['imageu_' . $i]['name'] != '') {
                        $image = $_FILES['imageu_' . $i]['tmp_name'];

                        //   echo $image;exit;


                        $originalName = $_FILES['imageu_' . $i]['name']; // Get the original file name

                        $filename = time() . '-' . str_replace(' ', '-', $originalName);


                        Image::make($image)

                            ->resize(510, 340)

                            ->save(public_path('upload/packages/packages_attr/large/' . $filename));


                        Image::make($image)

                            ->save(public_path('upload/packages/packages_attr/' . $filename));


                        $contentu['image']   = $filename;
                    } else {

                        $contentu['image']   = '';
                    }

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




        if (count($_POST['others1']) > 0 && $_POST['others1'] != '') {

            for ($i = 0; $i < count($_POST['others1']); $i++) {



                if ($_POST['others1'][$i] != '') {


                    $content['pid'] = $id;

                    $content['others'] = $_POST['others1'][$i];


                    $this->inserts_attribute($content);
                }
            }
        }
        if ($request->othersu != '' && count($request->othersu) > 0) {

            for ($i = 0; $i < count($_POST['othersu']); $i++) {



                if ($_POST['othersu'][$i] != '') {


                    $content['pid'] = $id;

                    $content['others'] = $_POST['othersu'][$i];


                    $content['updateid1xxxx'] = $_POST['updateid1xxxx'][$i];

                    $this->updates_attribute($content);
                }
            }
        }


        if (count($_POST['incluser_name1']) > 0 && $_POST['incluser_name1'] != '') {

            for ($i = 0; $i < count($_POST['incluser_name1']); $i++) {



                if ($_POST['incluser_name1'][$i] != '') {


                    $content['pid'] = $id;

                    $content['incluser_name'] = $_POST['incluser_name1'][$i];


                    $this->insert_attribute($content);
                }
            }
        }

        if ($request->incluser_nameu != '' && count($request->incluser_nameu) > 0) {

            for ($i = 0; $i < count($_POST['incluser_nameu']); $i++) {



                if ($_POST['incluser_nameu'][$i] != '') {


                    $content['pid'] = $id;

                    $content['incluser_name'] = $_POST['incluser_nameu'][$i];


                    $content['updateid1xxx'] = $_POST['updateid1xxx'][$i];

                    $this->update_attribute($content);
                }
            }
        }

        if (count($_POST['excluser_name1']) > 0 && $_POST['excluser_name1'] != '') {

            for ($i = 0; $i < count($_POST['excluser_name1']); $i++) {



                if ($_POST['excluser_name1'][$i] != '') {


                    $content['pid'] = $id;

                    $content['excluser_name'] = $_POST['excluser_name1'][$i];


                    $this->insertt_attribute($content);
                }
            }
        }

        if ($request->excluser_nameu != '' && count($request->excluser_nameu) > 0) {

            for ($i = 0; $i < count($_POST['excluser_nameu']); $i++) {



                if ($_POST['excluser_nameu'][$i] != '') {


                    $content['pid'] = $id;

                    $content['excluser_name'] = $_POST['excluser_nameu'][$i];


                    $content['exupdateid1xxx'] = $_POST['exupdateid1xxx'][$i];

                    $this->updated_attribute($content);
                }
            }
        }



        return redirect()->route('packages.index')->with('success', 'Packages Data Updated Successfully');
    }

    function update_Package_attribute($content)
    {

        // echo"<pre>";print_r($content);echo"</pre>";exit;

        $data['pid'] = $content['p_id'];

        $data['title_addmore'] = $content['title_addmore'];

        if ($content['image'] != '') {
            $data['image'] =  $content['image'];
        }
        $data['description_addmore'] = $content['description_addmore'];
        $data['image_alt_tag_addmore'] = $content['image_alt_tag_addmore'];

        DB::table('package_attr')->where('id', $content['updateid1xxx1'])->update($data);
    }



    function updates_attribute($content)
    {



        $data['pid'] = $content['pid'];

        $data['others'] = $content['others'];

        DB::table('packages_others')->where('id', $content['updateid1xxxx'])->update($data);
    }
    function update_attribute($content)
    {



        $data['pid'] = $content['pid'];

        $data['incluser_name'] = $content['incluser_name'];

        DB::table('packages_incluser')->where('id', $content['updateid1xxx'])->update($data);
    }

    function updated_attribute($content)
    {



        $data['pid'] = $content['pid'];

        $data['excluser_name'] = $content['excluser_name'];

        DB::table('packages_excluser')->where('id', $content['exupdateid1xxx'])->update($data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->selected;
        DB::table('packages')->whereIn('id', $id)->delete();
        return redirect()->route('packages.index')->with('success', 'Packages Data Deleted Successfully');
    }
    function subservice_show()
    {
        $service_id = $_POST['service_id'];
        // echo $service_id;exit;

        $result = DB::table('subservices')->select('*')->where('serviceid', '=', $service_id)->orderBy('id', 'DESC')->get();

        $result_new = $result->toArray();

        $html = ' <select class="form-control" id="subservice_id" name="subservice_id" onchange="packagecategory_change(this.value);">';
        $html .= '<option value="">Select Sub Service</option>';
        if ($result != '' && count($result) > 0) {
            for ($i = 0; $i < count($result); $i++) {
                // echo "<pre>";print_r($result[$i]->id);echo "</pre>";exit;
                $html .= "<option value='" . $result[$i]->id . "'>" . $result[$i]->subservicename . "</option>";
            }
        }
        $html .= "</select>";
        // echo "<pre>";print_r($html);echo "</pre>";exit;
        echo $html;
    }
    function packagecategory_show()
    {
        $subservice_id = $_POST['subservice_id'];
        // echo $service_id;exit;

        $result = DB::table('package_categories')->select('*')->where('subservice_id', '=', $subservice_id)->orderBy('id', 'DESC')->get();

        $result_new = $result->toArray();

        $html = '<select class="form-control" id="packagecategory_id" name="packagecategory_id">';
        $html .= '<option value="">Select Package Category</option>';
        if ($result != '' && count($result) > 0) {
            for ($i = 0; $i < count($result); $i++) {
                // echo "<pre>";print_r($result[$i]->id);echo "</pre>";exit;
                $html .= "<option value='" . $result[$i]->id . "'>" . $result[$i]->name . "</option>";
            }
        }
        $html .= "</select>";

        echo $html;
    }
    function editimage(Request $request, $id)
    {

        // echo $id;exit;
        $data['id'] = $id;
        $data['packagesimages'] = DB::table('packages_image')

            ->select('*')
            ->where('pid', '=', $id)
            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();



        //echo "<pre>";print_r($data);echo"</pre>";exit;

        return view('admin.edit_images', $data);
    }
    function editimage_store(Request $request)
    {

        for ($i = 0; $i < count($_FILES['attachment1']['name']); $i++) {

            if ($_FILES['attachment1']['name'][$i] != '') {

                $image = $_FILES['attachment1']['tmp_name'][$i];

                $originalName = $_FILES['attachment1']['name'][$i]; // Get the original file name



                // Generate a unique filename based on the original name

                $filename = time() . '-' . str_replace(' ', '-', $originalName);



                // Resize and save the image

                Image::make($image)

                    ->resize(839, 548)

                    ->save(public_path('upload/packages_slider_img/large/' . $filename));


                Image::make($image)

                    ->resize(150, 112)

                    ->save(public_path('upload/packages_slider_img/small/' . $filename));


                Image::make($image)

                    ->save(public_path('upload/packages_slider_img/' . $filename));





                $data1['image'] = $filename;
            } else {

                $data1['image'] = "";
            }



            $data1['pid'] = $request->id;



            $this->upload_product_image($data1);
        }



        return redirect()->to('editimage/' . $request->id)->with('success', 'Packages Image has been added successfully');
    }

    function upload_product_image($content)
    {



        //echo "<pre>";print_r($content);echo"</pre>";exit;



        $data['pid'] = $content['pid'];

        $data['image'] = $content['image'];

        // $data['baseimage'] = 0;

        // $data['baseimageHover'] =0;

        DB::table('packages_image')->insertGetId($data);
    }
    public function packages_removeimage(Request $request)
    {

        $packages = $request->pid;

        $id = $request->id;

        $result = DB::table('packages_image')->where('pid', '=', $packages)->where('id', '=', $id)->delete();

        return redirect()->route('editimage', $packages)->with('success', 'Packages Image has been deleted successfully');
    }
    public function set_order_packages()

    {

        $id = $_POST['id'];

        $val = $_POST['val'];

        // echo $id."-".$val;exit;

        DB::table('packages')->where('id', $id)->update(array('set_order' => $val));

        echo "1";

        // return redirect()->route('product.index')->with('success','Set Order has been Updated successfully');

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

            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }

    public  function change_status()
    {



        $id = $_POST['id'];

        $value = $_POST['value'];

        DB::table('packages')->where('id', $id)->update(array('is_active' => $value));

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
}
