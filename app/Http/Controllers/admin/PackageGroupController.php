<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class PackageGroupController extends Controller
{
    public function index()
    {
        $packagegroup_data = DB::table('package_groups')
            ->leftJoin('package_categories', 'package_groups.packagecategory_id', '=', 'package_categories.id')
            ->leftJoin('subservices', 'package_categories.subservice_id', '=', 'subservices.id')
            ->select('package_groups.*', 'package_categories.name as packagecategory_name', 'package_categories.subservice_id', 'subservices.serviceid as service_id')
            ->orderBy('package_groups.id', 'DESC')
            ->get();
        return view('admin.list_package_groups', compact('packagegroup_data'));
    }

    public function create()
    {
        $service_data = DB::table('services')->where('is_active', 0)->orderBy('id', 'DESC')->get();
        return view('admin.add_package_group', compact('service_data'));
    }

    public function store(Request $request)
    {
        $data = [
            'packagecategory_id' => $request->packagecategory_id,
            'name' => $request->name,
            'short_description' => $request->short_description,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/upload/package_groups/');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }

        DB::table('package_groups')->insert($data);
        return redirect()->route('packagegroup.index')->with('success', 'Package Group Added Successfully');
    }

    public function edit($id)
    {
        $packagegroup = DB::table('package_groups')->where('id', $id)->first();
        
        $packagecategory = DB::table('package_categories')->where('id', $packagegroup->packagecategory_id)->first();
        $subservice = DB::table('subservices')->where('id', $packagecategory->subservice_id)->first();

        $packagegroup->service_id = $subservice->serviceid;
        $packagegroup->subservice_id = $packagecategory->subservice_id;

        $service_data = DB::table('services')->where('is_active', 0)->orderBy('id', 'DESC')->get();
        $subservice_data = DB::table('subservices')->where('serviceid', $subservice->serviceid)->get();
        $packagecategory_data = DB::table('package_categories')->where('subservice_id', $packagecategory->subservice_id)->get();
        
        return view('admin.edit_package_group', compact('packagegroup', 'service_data', 'subservice_data', 'packagecategory_data', 'subservice'));
    }

    public function update(Request $request, $id)
    {
        $data = [
            'packagecategory_id' => $request->packagecategory_id,
            'name' => $request->name,
            'short_description' => $request->short_description,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/upload/package_groups/');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }

        DB::table('package_groups')->where('id', $id)->update($data);
        return redirect()->route('packagegroup.index')->with('success', 'Package Group Updated Successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->selected;
        if ($id) {
            DB::table('package_groups')->whereIn('id', $id)->delete();
        }
        return redirect()->route('packagegroup.index')->with('success', 'Package Group Deleted Successfully');
    }

    public function change_status(Request $request)
    {
        $id = $request->id;
        $value = $request->value;
        DB::table('package_groups')->where('id', $id)->update(['is_active' => $value]);
        echo "1";
    }

    public function set_order(Request $request)
    {
        $id = $request->id;
        $val = $request->val;
        DB::table('package_groups')->where('id', $id)->update(['set_order' => $val]);
        echo "1";
    }
}
