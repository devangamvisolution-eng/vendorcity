<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\PackageCategory;
use DB;

class PackageCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['packagecategory_data'] = DB::table('package_categories')->orderBy('id', 'DESC')->get();


        return view('admin.list_packagecategory', $data);
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
        return view('admin.add_packagecategory', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['service_id'] = $request->service_id;
        $data['subservice_id'] = $request->subservice_id;
        $data['name'] = $request->name;
        $data['image_alt_tag'] = $request->image_alt_tag;
        $data['slider_image_alt_tag'] = $request->slider_image_alt_tag;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = time() . '-' . $originalName . '.' . $extension;
            if (strtolower($extension) === 'webp' || strtolower($extension) === 'avif') {
                // Move to the large folder first
                $largeDestinationPath = public_path('upload/packagecategory/large/' . $imageName);
                $image->move(public_path('upload/packagecategory/large'), $imageName);

                // Copy the file to other directories
                copy($largeDestinationPath, public_path('upload/packagecategory/' . $imageName));
            } else {
                $largeDestinationPath = public_path('upload/packagecategory/large/' . $imageName);
                $this->resizeImage($image->getRealPath(), $largeDestinationPath, 491, 183);
                $image->move(public_path('upload/packagecategory'), $imageName);
            }
            $data['image'] = $imageName;
        } else {
            $data['image'] = "";
        }

        if ($request->hasFile('slider_image')) {
            $sliderImage = $request->file('slider_image');
            $extension = $sliderImage->getClientOriginalExtension();
            $originalName = pathinfo($sliderImage->getClientOriginalName(), PATHINFO_FILENAME);
            $sliderImageName = time() . '-slider-' . $originalName . '.' . $extension;
            $sliderImage->move(public_path('upload/packagecategory'), $sliderImageName);
            $data['slider_image'] = $sliderImageName;
        } else {
            $data['slider_image'] = "";
        }

        DB::table('package_categories')->insert($data);
        return redirect()->route('packagecategory.index')->with('success', 'Package Category Data Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // echo"<pre>";
        // print_r($data['subservice_data']);
        // echo"</pre>";exit;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['packagecategory'] = DB::table('package_categories')->where('id', $id)->first();
        $data['service_data'] = DB::table('services')->orderBy('id', 'DESC')->get();
        $data['subservice_data'] = DB::table('subservices')->where('serviceid', $data['packagecategory']->service_id)->orderBy('id', 'DESC')->get();



        return view('admin.edit_packagecategory', $data);
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

        $data['service_id'] = $request->service_id;
        $data['subservice_id'] = $request->subservice_id;
        $data['name'] = $request->name;
        $data['image_alt_tag'] = $request->image_alt_tag;
        $data['slider_image_alt_tag'] = $request->slider_image_alt_tag;


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = time() . '-' . $originalName . '.' . $extension;
            if (strtolower($extension) === 'webp' || strtolower($extension) === 'avif') {
                // Move to the large folder first
                $largeDestinationPath = public_path('upload/packagecategory/large/' . $imageName);
                $image->move(public_path('upload/packagecategory/large'), $imageName);

                // Copy the file to other directories
                copy($largeDestinationPath, public_path('upload/packagecategory/' . $imageName));
            } else {
                $largeDestinationPath = public_path('upload/packagecategory/large/' . $imageName);
                $this->resizeImage($image->getRealPath(), $largeDestinationPath, 491, 183);
                $image->move(public_path('upload/packagecategory'), $imageName);
            }
            $data['image'] = $imageName;
        }

        if ($request->hasFile('slider_image')) {
            $sliderImage = $request->file('slider_image');
            $extension = $sliderImage->getClientOriginalExtension();
            $originalName = pathinfo($sliderImage->getClientOriginalName(), PATHINFO_FILENAME);
            $sliderImageName = time() . '-slider-' . $originalName . '.' . $extension;
            $sliderImage->move(public_path('upload/packagecategory'), $sliderImageName);
            $data['slider_image'] = $sliderImageName;
        }

        DB::table('package_categories')->where('id', $id)->update($data);

        return redirect()->route('packagecategory.index')->with('success', 'Package Category Data Updated Successfully');
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
        DB::table('package_categories')->whereIn('id', $id)->delete();
        return redirect()->route('packagecategory.index')->with('success', 'Package Category Data Deleted Successfully');
    }

    public  function change_status()
    {



        $id = $_POST['id'];

        $value = $_POST['value'];

        DB::table('package_categories')->where('id', $id)->update(array('is_active' => $value));

        echo "1";
    }
    public function set_order()

    {

        $id = $_POST['id'];

        $val = $_POST['val'];

        // echo $id . "-" . $val;
        // exit;

        DB::table('package_categories')->where('id', $id)->update(array('set_order' => $val));

        echo "1";

        // return redirect()->route('product.index')->with('success','Set Order has been Updated successfully');

    }
    function subservice_show()
    {
        $service_id = $_POST['service_id'];
        // echo $service_id;exit;

        $result = DB::table('subservices')->select('*')->where('serviceid', '=', $service_id)->orderBy('id', 'DESC')->get();

        $result_new = $result->toArray();

        $html = ' <select class="form-control" id="subservice_id" name="subservice_id">';
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
