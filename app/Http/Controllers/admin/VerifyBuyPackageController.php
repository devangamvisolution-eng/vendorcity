<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\VerifyBuyPackage;
use App\Models\Admin\VerifyBuyPackageAttr;
use Image;


class VerifyBuyPackageController extends Controller
{
    //
    public function index()
    {
        $data['verifybuypackages'] = VerifyBuyPackage::orderBy('id', 'DESC')->get();
        return view('admin.list_verifybuy_packages', $data);
    }
    public function create()
    {
        return view('admin.add_verifybuy_packages');
    }
    public function store(request $request)
    {
        //echo "<pre>"; print_r($request->all()); echo "</pre>";exit;
        $VerifyBuyPackage = new VerifyBuyPackage();
        $VerifyBuyPackage->name = $request->name;
        $VerifyBuyPackage->price = $request->price;
        $VerifyBuyPackage->tag = $request->tag;
        if ($request->hasfile('image') != '') {
            $image = $request->file('image');
            $remove_space = str_replace(' ', '-', $image->getClientOriginalName());
            $data['image'] = time() . $remove_space;
            $destination_path = public_path('upload/verifybuypackages/medium/');
            $img = Image::make($image->path());
            $width = 1400;
            $height = 575;
            $img->resize($width, $height, function ($contrainst) {})->save($destination_path . "/" . $data['image']);
            $width = 70;
            $height = 70;
            $destination_path = public_path('upload/verifybuypackages/small');
            $img->resize($width, $height, function ($constraint) {})->save($destination_path . "/" . $data['image']);
            $destinationPath = public_path('upload/verifybuypackages/');
            $image->move($destinationPath, $data['image']);
            $image = $data['image'];
            $VerifyBuyPackage->image  = $image;
        } else {
            $VerifyBuyPackage->image = "";
        }
        $VerifyBuyPackage->save();
        $id = $VerifyBuyPackage->id;

        if (count($_POST['details']) > 0 && $_POST['details'] != '') {

            for ($i = 0; $i < count($_POST['details']); $i++) {

                if ($_POST['details'][$i] != '') {

                    $content['verify_buy_package_id'] = $id;
                    $content['details'] = $_POST['details'][$i];


                    $this->insert_attribute($content);
                }
            }
        }


        return redirect()->route('verifybuy-packages.index')->with('success', 'Verifybuy Package Added Successfully');
    }
    function insert_attribute($content)
    {
        $VerifyBuyPackageAttr = new VerifyBuyPackageAttr();
        $VerifyBuyPackageAttr->verify_buy_package_id = $content['verify_buy_package_id'];
        $VerifyBuyPackageAttr->details = $content['details'];
        $VerifyBuyPackageAttr->save();
    }

    public function edit($id)
    {
        $data['verifybuypackages'] = VerifyBuyPackage::findorfail($id);
        $data['verifybuypackagesattr'] = VerifyBuyPackageAttr::where('verify_buy_package_id', $id)->get();
        return view('admin.edit_verifybuy_packages', $data);
    }
    public function update(request $request, $id)
    {
        //  echo "<pre>"; print_r($request->all()); echo "</pre>";exit;
        $VerifyBuyPackage = VerifyBuyPackage::findorfail($id);
        $VerifyBuyPackage->name = $request->name;
        $VerifyBuyPackage->price = $request->price;
        $VerifyBuyPackage->tag = $request->tag;
        if ($request->hasfile('image') != '') {
            $image = $request->file('image');
            $remove_space = str_replace(' ', '-', $image->getClientOriginalName());
            $data['image'] = time() . $remove_space;
            $destination_path = public_path('upload/verifybuypackages/medium/');
            $img = Image::make($image->path());
            $width = 1400;
            $height = 575;
            $img->resize($width, $height, function ($contrainst) {})->save($destination_path . "/" . $data['image']);
            $width = 70;
            $height = 70;
            $destination_path = public_path('upload/verifybuypackages/small');
            $img->resize($width, $height, function ($constraint) {})->save($destination_path . "/" . $data['image']);
            $destinationPath = public_path('upload/verifybuypackages/');
            $image->move($destinationPath, $data['image']);
            $image = $data['image'];
            $VerifyBuyPackage->image  = $image;
        }
        $VerifyBuyPackage->save();

        if (count($_POST['details1']) > 0 && $_POST['details1'] != '') {

            for ($i = 0; $i < count($_POST['details1']); $i++) {

                if ($_POST['details1'][$i] != '') {

                    $content['verify_buy_package_id'] = $id;
                    $content['details'] = $_POST['details1'][$i];


                    $this->insert_attribute($content);
                }
            }
        }

        if (isset($_POST['detailsu']) && count($_POST['detailsu']) > 0 && $_POST['detailsu'] != '') {

            for ($i = 0; $i < count($_POST['detailsu']); $i++) {

                if ($_POST['detailsu'][$i] != '') {

                    $contentu['verify_buy_package_id'] = $id;
                    $contentu['details'] = $_POST['detailsu'][$i];
                    $contentu['updateid1xxx'] = $_POST['updateid1xxx'][$i];


                    $this->update_attribute($contentu);
                }
            }
        }
        return redirect()->route('verifybuy-packages.index')->with('success', 'Verifybuy Package Updated Successfully');
    }
    function update_attribute($contentu)
    {
        $data['verify_buy_package_id'] = $contentu['verify_buy_package_id'];
        $data['details'] = $contentu['details'];
        $VerifyBuyPackageAttr = VerifyBuyPackageAttr::where('id', $contentu['updateid1xxx'])->update($data);
    }

    public function destroy(request $request)
    {
        $id = $request->selected;
        $res = VerifyBuyPackage::whereIn('id', $id)->delete();
        return redirect()->route('verifybuy-packages.index')->with('success', 'Verifybuy Package Deleted Successfully');
    }
    function remove_attr($pid, $id)
    {
        $res = VerifyBuyPackageAttr::where('verify_buy_package_id', $pid)->where('id', $id)->delete();
        return redirect()->route('verifybuy-packages.edit', $pid)->with('success', 'Verifybuy Package Attribute Deleted Successfully');
    }

    function change_status_inspection_packages(request $request)
    {
        $id = $_POST['id'];

        $value = $_POST['value'];

        $res = VerifyBuyPackage::where('id', $id)->update(array('is_active' => $value));

        echo "1";
    }
}
