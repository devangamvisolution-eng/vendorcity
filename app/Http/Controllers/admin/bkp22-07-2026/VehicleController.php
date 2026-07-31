<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Vehicles;
use Image;

class VehicleController extends Controller
{
    //
    public function index()
    {
        $data['vehicles'] = Vehicles::orderBy('id', 'DESC')->get();
        return view('admin.list_vehicle', $data);
    }
    public function create()
    {

        return view('admin.add_vehicle');
    }
    public function store(request $request)
    {
        $Vehicles = new Vehicles();
        $Vehicles->name = $request->name;
        if ($request->hasfile('image') != '') {
            $image = $request->file('image');
            $remove_space = str_replace(' ', '-', $image->getClientOriginalName());
            $data['image'] = time() . $remove_space;
            $destination_path = public_path('upload/vehicle/medium/');
            $img = Image::make($image->path());
            $width = 65;
            $height = 65;
            $img->resize($width, $height, function ($contrainst) {})->save($destination_path . "/" . $data['image']);
            $width = 50;
            $height = 50;
            $destination_path = public_path('upload/vehicle/small');
            $img->resize($width, $height, function ($constraint) {})->save($destination_path . "/" . $data['image']);
            $destinationPath = public_path('upload/vehicle/');
            $image->move($destinationPath, $data['image']);
            $image = $data['image'];
            $Vehicles->image  = $image;
        } else {
            $Vehicles->image = "";
        }
        $Vehicles->save();
        return redirect()->route('vehicle.index')->with('success', 'Vehicle Added Successfully.');
    }

    public function edit($id)
    {
        $data['vehicles'] = Vehicles::findorfail($id);
        return view('admin.edit_vehicle', $data);
    }
    public function update(request $request, $id)
    {
        $Vehicles = Vehicles::findorfail($id);
        $Vehicles->name = $request->name;
        if ($request->hasfile('image') != '') {
            $image = $request->file('image');
            $remove_space = str_replace(' ', '-', $image->getClientOriginalName());
            $data['image'] = time() . $remove_space;
            $destination_path = public_path('upload/vehicle/medium/');
            $img = Image::make($image->path());
            $width = 64;
            $height = 64;
            $img->resize($width, $height, function ($contrainst) {})->save($destination_path . "/" . $data['image']);
            $width = 50;
            $height = 50;
            $destination_path = public_path('upload/vehicle/small');
            $img->resize($width, $height, function ($constraint) {})->save($destination_path . "/" . $data['image']);
            $destinationPath = public_path('upload/vehicle/');
            $image->move($destinationPath, $data['image']);
            $image = $data['image'];
            $Vehicles->image  = $image;
        }
        $Vehicles->save();
        return redirect()->route('vehicle.index')->with('success', 'Vehicle Updated Successfully.');
    }
    public function destroy(request $request)
    {
        $id = $request->selected;
        $res = Vehicles::whereIn('id', $id)->delete();
        return redirect()->route('vehicle.index')->with('success', 'Vehicle Deleted Successfully.');
    }

    function change_status_vehicle(request $request)
    {
        //    echo"<pre>";
        // print_r($request->all());
        // echo"</pre>";exit;
        $id = $request->id;
        $val = $request->value;
        $res = Vehicles::where('id', $id)->update(['show_inform' => $val]);
        echo "1";
    }
}
