<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Addons;
use DB;


class Addonscontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata'] = Addons::orderBy('id', 'DESC')->get();
        return view('admin.addons.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['service_data'] = DB::table('services')->select('*')->where('is_active', 0)->orderBy('id', 'DESC')->get();
        $data['subservice_data'] = DB::table('subservices')->select('*')->where('is_active', 0)->orderBy('id', 'DESC')->get();
        $data['package_categories_data'] = DB::table('package_categories')->select('*')->orderBy('id', 'DESC')->get();
        return view('admin.addons.add', $data);
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

        $data['serviceid'] = $request->serviceid;

        if (isset($request->subservice_id)) {
            $data['subserviceid'] = implode(",", $request->subservice_id);
        }
        $data['name'] = $request->name;
        $data['price'] = $request->price;
        $data['image_alt_tag'] = $request->image_alt_tag;
        $data['popup_image_alt_tag'] = $request->popup_image_alt_tag;
        $data['discount'] = $request->discount;
        $data['discount_type'] = $request->discount_type;
        $data['short_desc'] = $request->short_description;
        $data['description'] = $request->description;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = time() . '-' . $originalName . '.' . $extension;
            if (strtolower($extension) === 'webp' || strtolower($extension) === 'avif') {
                // Move to the large folder first
                $largeDestinationPath = public_path('upload/addons/' . $imageName);
                $image->move(public_path('upload/addons'), $imageName);

                // Copy the file to other directories
                copy($largeDestinationPath, public_path('upload/addons/' . $imageName));
            } else {
                $largeDestinationPath = public_path('upload/addons/' . $imageName);
                $this->resizeImage($image->getRealPath(), $largeDestinationPath, 97, 97);
                $image->move(public_path('upload/addons/'), $imageName);
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
                $largeDestinationPath = public_path('upload/addons/' . $popup_imageName);
                $popup_image->move(public_path('upload/addons/'), $popup_imageName);

                // Copy the file to other directories
                copy($largeDestinationPath, public_path('upload/addons/' . $popup_imageName));
            } else {
                $largeDestinationPath = public_path('upload/addons/' . $popup_imageName);
                $this->resizeImage($popup_image->getRealPath(), $largeDestinationPath, 500, 160);
                $popup_image->move(public_path('upload/addons/'), $popup_imageName);
            }
            $data['popup_image'] = $popup_imageName;
        } else {
            $data['popup_image'] = "";
        }

        $addons = Addons::insert($data);

        return redirect()->route('addons.lists')->with('success', 'Add Ons Data Added Successfully');
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
        $data['addons'] = Addons::where('id', $id)->first();
        $data['service_data'] = DB::table('services')->select('*')->where('is_active', 0)->orderBy('id', 'DESC')->get();
        $data['subservice_data'] = DB::table('subservices')->select('*')->where('is_active', 0)->where('serviceid', $data['addons']->serviceid)->orderBy('id', 'DESC')->get();
        return view('admin.addons.edit', $data);
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
        //echo "<pre>";print_r($request->all());echo "</pre>";exit;

        $data['serviceid'] = $request->serviceid;

        if (isset($request->subservice_id)) {
            $data['subserviceid'] =  implode(",", $request->subservice_id);
        } else {
            $data['subserviceid'] =  '';
        }


        $data['name'] = $request->name;
        $data['price'] = $request->price;
        $data['image_alt_tag'] = $request->image_alt_tag;
        $data['popup_image_alt_tag'] = $request->popup_image_alt_tag;
        $data['discount'] = $request->discount;
        $data['discount_type'] = $request->discount_type;
        $data['short_desc'] = $request->short_description;
        $data['description'] = $request->description;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = time() . '-' . $originalName . '.' . $extension;
            if (strtolower($extension) === 'webp' || strtolower($extension) === 'avif') {
                // Move to the large folder first
                $largeDestinationPath = public_path('upload/addons/' . $imageName);
                $image->move(public_path('upload/addons'), $imageName);

                // Copy the file to other directories
                copy($largeDestinationPath, public_path('upload/addons/' . $imageName));
            } else {
                $largeDestinationPath = public_path('upload/addons/' . $imageName);
                $this->resizeImage($image->getRealPath(), $largeDestinationPath, 97, 97);
                $image->move(public_path('upload/addons'), $imageName);
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
                $largeDestinationPath = public_path('upload/addons/' . $popup_imageName);
                $popup_image->move(public_path('upload/addons'), $popup_imageName);

                // Copy the file to other directories
                copy($largeDestinationPath, public_path('upload/addons/' . $popup_imageName));
            } else {
                $largeDestinationPath = public_path('upload/addons/' . $popup_imageName);
                $this->resizeImage($popup_image->getRealPath(), $largeDestinationPath, 500, 160);
                $popup_image->move(public_path('upload/addons'), $popup_imageName);
            }
            $data['popup_image'] = $popup_imageName;
        }

        Addons::where('id', $id)->update($data);

        return redirect()->route('addons.lists')->with('success', 'Add Ons Data Updated Successfully');
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

    function subservice_show()
    {
        $service_id = $_POST['service_id'];
        // echo $service_id;exit;

        $result = DB::table('subservices')->select('*')->where('serviceid', '=', $service_id)->orderBy('id', 'DESC')->get();

        $result_new = $result->toArray();

        $html = ' <select class="form-control" id="subservice_id" name="subservice_id[]" multiple="multiple">';
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

    public function set_order()

    {

        $id = $_POST['id'];

        $val = $_POST['val'];

        // echo $id . "-" . $val;
        // exit;

        DB::table('addons')->where('id', $id)->update(array('set_order' => $val));

        echo "1";

        // return redirect()->route('product.index')->with('success','Set Order has been Updated successfully');

    }

    public  function change_status()
    {



        $id = $_POST['id'];

        $value = $_POST['value'];

        DB::table('addons')->where('id', $id)->update(array('is_active' => $value));

        echo "1";
    }
}
