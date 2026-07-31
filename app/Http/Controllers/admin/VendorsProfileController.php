<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Image;
use App\Models\admin\City;
use App\Models\admin\UserPermission;

class VendorsProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.vendorsprofile");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $data["vendorsprofile"] = DB::table("users")
            ->where("id", "=", $id)
            ->first();

        $selectedServices = !empty($data['vendorsprofile']->serviceList)
        ? explode(',', $data['vendorsprofile']->serviceList)
        : [];

        $data['subservice_data'] = DB::table('subservices')
                                    ->whereIn('serviceid', $selectedServices ?: [0])
                                    ->get();

        $data["attribute_data"] = DB::table("vendors_attribute")
            ->where("pid", $data["vendorsprofile"]->id)
            ->get()
            ->toArray();

        $data["city_data"] = City::orderBy("id", "DESC")->get();
        $data["permission_data"] = UserPermission::orderBy("id", "DESC")->get();
        $data["service_data"] = DB::table("services")
            ->where("is_active", 0)
            ->orderBy("set_order")
            ->get();

        return view("admin.editvendorsprofile", $data);
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
        // echo "<pre>";
        // print_r($request->all());
        // echo "</pre>";
        // exit();

        $data["role_id"] = $_POST["hidden_role_id"];
        $data["name"] = $_POST["name"];
        $data["user_name"] = $_POST["user_name"];
        $data["companywebsite"] = $_POST["companywebsite"];
        // $data['city']=$_POST['city'];
        if (isset($_POST["city"])) {
            $data["city"] = implode(",", $_POST["city"]);
        } else {
            $data["city"] = "";
        }
        $data["crole"] = $_POST["crole"];
        $data["parentcname"] = $_POST["parentcname"];
        $data["establishment_date"] = $_POST["establishment_date"];
        $data["tlexpiry"] = $_POST["tlexpiry"];
        $data["staff"] = $_POST["staff"];
        $data["remarks"] = $_POST["remarks"];
        $data["socialmedai"] = $_POST["socialmedai"];
        $data["country_code"] = preg_replace('/\D+/', '', trim($_POST["country_code_vendor"]));

        // $data['password']=Hash::make ($_POST['password']);
        $data["email"] = $_POST["email"];
        if ($_POST["mobile"] != "") {
            $data["mobile"] = preg_replace('/\D+/', '', trim($_POST["mobile"]));
        } else {
            $data["mobile"] = null;
        }

        if (isset($_POST['serviceList']) && !empty($_POST['serviceList'])) {
            $serviceList = $_POST['serviceList'];
        
            if (is_array($serviceList) && count($serviceList) > 0) {
                $data['serviceList'] = implode(',', $serviceList);
            } else {
                $data['serviceList'] = '';
            }
             $roleIds = [];
			foreach($serviceList as $key => $value){
				if($value == '45'){
					$roleIds[] = 18;
				}
				if($value == '30'){
					$roleIds[] = 19;
				}
				if($value == '44'){
					$roleIds[] = 19;
				}
				if($value == '34'){
					$roleIds[] = 20;
				}
				if($value == '47'){
					$roleIds[] = 21;
				}
				if($value == '48'){
					$roleIds[] = 17;
				}
                if($value == '50'){
					$roleIds[] = 22;
				}
			}
			
			$commaSeparatedRoles = implode(',', $roleIds);
			
			$data['role_id'] = $commaSeparatedRoles;
        } else {
            $data['serviceList'] = null;
        }

        if (isset($_POST['subserviceList']) && !empty($_POST['subserviceList'])) {
            $subserviceList = $_POST['subserviceList'];
        
            if (is_array($subserviceList) && count($subserviceList) > 0) {
                $data['subserviceList'] = implode(',', $subserviceList);
            } else {
                $data['subserviceList'] = '';
            }
        } 
        
        $data["vendor"] = 1;

        if ($request->hasfile("image") != "") {
            $image = $request->file("image");
            $remove_space = str_replace(
                " ",
                "-",
                $image->getClientOriginalName()
            );
            $data["image"] = time() . $remove_space;
            $destinationPath = public_path("upload/vendors/small");
            $img = Image::make($image->path());
            $width = 100;
            $height = 100;
            $img->resize($width, $height, function ($constraint) {})->save(
                $destinationPath . "/" . $data["image"]
            );

            $destinationPath = public_path("upload/vendors/");
            $image->move($destinationPath, $data["image"]);
            $image = $data["image"];
            $data["image"] = $image;
        }

        if ($request->hasFile("company_logo")) {
            $file = $request->file("company_logo");
            $path = public_path("upload/vendors/");
            $fileName = uniqid() . "." . $file->getClientOriginalExtension();

            // Save the original image
            $file->move($path, $fileName);
            $data["company_logo"] = $fileName;

            // Create a resized copy of the image
            $resizedImage = Image::make($path . $fileName)->resize(60, 60);
            $resizedFileName =
                uniqid() . "_thumb." . $file->getClientOriginalExtension();
            $resizedImage->save($path . $resizedFileName);

            // Save the resized image file name in data if needed
            $data["company_logo"] = $resizedFileName;
        }

        if ($request->hasFile("vatcertificate")) {
            $file = $request->file("vatcertificate");

            $path = public_path("upload/vendors/");

            $fileName = uniqid() . "." . $file->getClientOriginalExtension();

            $file->move($path, $fileName);

            $data["vatcertificate"] = $fileName;
        }
        if ($request->hasFile("trncertificate")) {
            $file = $request->file("trncertificate");

            $path = public_path("upload/vendors/");

            $fileName = uniqid() . "." . $file->getClientOriginalExtension();

            $file->move($path, $fileName);

            $data["trncertificate"] = $fileName;
        }
        if ($request->hasFile("tradelicense")) {
            $file = $request->file("tradelicense");

            $path = public_path("upload/vendors/");

            $fileName = uniqid() . "." . $file->getClientOriginalExtension();

            $file->move($path, $fileName);

            $data["tradelicense"] = $fileName;
        }

        if (isset($_POST["serviceList"]) && !empty($_POST["serviceList"])) {
            $serviceList = $_POST["serviceList"];

            if (is_array($serviceList) && count($serviceList) > 0) {
                $data["serviceList"] = implode(",", $serviceList);
            } else {
                $data["serviceList"] = "";
            }
        } else {
            $data["serviceList"] = null;
        }

        // echo"<pre>";
        // print_r($data);
        // echo"</pre>";exit;
        //    $vendors_id = DB::table('users')->insertGetId($data);
        DB::table("users")
            ->where("id", $id)
            ->update($data);

        if (count($_POST["poc1"]) > 0 && $_POST["poc1"] != "") {
            for ($i = 0; $i < count($_POST["poc1"]); $i++) {
                if ($_POST["poc1"][$i] != "") {
                    $content["p_id"] = $id;

                    $content["poc"] = $_POST["poc1"][$i];

                    $content["poctitle"] = $_POST["poctitle1"][$i];

                    $content["c_email"] = $_POST["c_email1"][$i];

                    $content["telephone"] = $_POST["telephone1"][$i];
                    $content["country_code"] = str_replace(' ', '', trim($_POST["country_code1"][$i]));;

                    $this->insert_attribute($content);
                }
            }
        }

        if ($request->pocu != "" && count($request->pocu) > 0) {
            for ($i = 0; $i < count($_POST["pocu"]); $i++) {
                if ($_POST["pocu"][$i] != "") {
                    $content["p_id"] = $id;

                    $content["poc"] = $_POST["pocu"][$i];

                    $content["poctitle"] = $_POST["poctitleu"][$i];

                    $content["c_email"] = $_POST["c_emailu"][$i];

                    $content["telephone"] = $_POST["telephoneu"][$i];
                    $content["country_code"] = str_replace(' ', '', trim($_POST["country_codeu"][$i]));

                    $content["updateid1xxx"] = $_POST["updateid1xxx"][$i];

                    $this->update_attribute($content);
                }
            }
        }
        return redirect()
            ->route("vendorsprofile.index")
            ->with("success", "Vendors profile Updated Successfully.");
    }
    function insert_attribute($content)
    {
        $data["pid"] = $content["p_id"];
        $data["poc"] = $content["poc"];
        $data["poctitle"] = $content["poctitle"];
        $data["c_email"] = $content["c_email"];
        $data["telephone"] = preg_replace('/\D+/', '', trim($content["telephone"]));
        $data["country_code"] = $content["country_code"];
        DB::table("vendors_attribute")->insertGetId($data);
    }
    function update_attribute($content)
    {
        $data["pid"] = $content["p_id"];

        $data["poc"] = $content["poc"];

        $data["poctitle"] = $content["poctitle"];

        $data["c_email"] = $content["c_email"];

        $data["telephone"] = preg_replace('/\D+/', '', trim($content["telephone"]));
        $data["country_code"] = $content["country_code"];

        DB::table("vendors_attribute")
            ->where("id", $content["updateid1xxx"])
            ->update($data);
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

    public function remove_vendorsprofile_att(Request $request)
    {
        $service = $request->pid;

        $id = $request->id;

        $result = DB::table("vendors_attribute")
            ->where("pid", "=", $service)
            ->where("id", "=", $id)
            ->delete();

        return redirect()
            ->route("vendorsprofile.edit", $service)
            ->with("success", " Deleted Successfully");
    }
}
