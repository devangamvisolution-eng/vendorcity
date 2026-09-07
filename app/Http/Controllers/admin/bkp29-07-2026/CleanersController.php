<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use DB;
use App\Models\admin\UserPermission;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use PhpOption\Option;

class CleanersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data['cleaners_data']=DB::table('cleaners')->orderBy('id','DESC')->get();
        $user = Auth::user();

        if ($user->role_id == 1) {
            $data['cleaners_data'] = DB::table('users')->where('role_id', '=', '16')->orderBy('id', 'desc')->get();
            // echo"<pre>";print_r($request->all());echo"</pre>";exit;
        } else {
            $data['cleaners_data'] = DB::table('users')->where('role_id', '=', '16')->where('added_by', $user->id)->orderBy('id', 'desc')->get();
        }

        return view('admin.list_cleaners', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['user_category'] = UserPermission::where('id', '=', '16')->get();
        $data['country_data'] = DB::table('countries')->orderBy('id', 'DESC')->get();
        $data['service_data'] = DB::table('services')->where('is_active', '0')->orderBy('id', 'DESC')->get();
        return view('admin.add_cleaners', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $data['name'] = $request->name;
        $data['role_id'] = $request->user_id;
        $data['user_name'] = $request->user_name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['phone'] = $request->phone;
        $data['nationality'] = $request->nationality;
        $data['area'] = $request->area;
        $data['country'] = $request->country;
        $data['state'] = $request->state;
        $data['added_by'] = $user->id;
        $data['vendor'] = 0;
        $data['city'] = implode(',', $request->input('city'));
        $data['service'] = implode(',', $request->input('service'));
        $data['subservice'] = implode(',', $request->input('subservice'));

        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
            $image = $request->file('profile_image');
            $remove_space = str_replace(' ', '-', $image->getClientOriginalName());
            $data['profile_image'] = time() . $remove_space;
            $destination_path = public_path('upload/cleaners/large');
            if (!file_exists($destination_path)) {
                mkdir($destination_path, 0755, true);
            }
            $img = Image::make($image->path());
            $width = 95;
            $height = 95;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($destination_path . "/" . $data['profile_image']);
            $data['profile_image'] = $data['profile_image'];
        } else {
            $data['profile_image'] = "";
        }
        $data['cleaner_desc'] = $request->cleaner_desc;
        $data['language'] = $request->language;

        // echo"<pre>";print_r($data);echo"</pre>";exit;

        DB::table('users')->insert($data);

        return redirect()->route('cleaners.index')->with('success', 'Cleaner Added Successfully');
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
        $data['cleaners'] = DB::table('users')->where('id', $id)->first();

        $city_id = explode(',', $data['cleaners']->city);
        $data['country_data'] = DB::table('countries')
            ->orderBy('id', 'DESC')
            ->get();

        $data['state_data'] = DB::table('states')
            ->where('country_id', $data['cleaners']->country)
            ->get();

        $data['city_data'] = DB::table('cities')
            ->where('state', $data['cleaners']->state)
            ->whereIn('id', $city_id)
            ->orderBy('id', 'DESC')
            ->get();

        $service_id = explode(',', $data['cleaners']->service);

        $data['service'] = DB::table('services')->where('is_active', '0')->orderBy('id', 'DESC')->get();

        // $data['subservice'] = DB::table('subservices')->whereIn('serviceid', $service_id)->where('is_active', '0')->orderBy('id', 'DESC')->get();
        $data['subservice'] = DB::table('subservices')
            ->whereIn('serviceid', $service_id)
            ->where(function ($query) {
                $query->where('id', 97)
                    ->orWhere('is_active', '0');
            })
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.edit_cleaners', $data);
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
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['nationality'] = $request->nationality;
        $data['country'] = $request->country;
        $data['state'] = $request->state;
        $data['area'] = $request->area;
        $data['city'] = implode(',', $request->input('city'));
        $data['service'] = implode(',', $request->input('service'));
        $data['subservice'] = implode(',', $request->input('subservice'));

        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
            $image = $request->file('profile_image');
            $remove_space = str_replace(' ', '-', $image->getClientOriginalName());
            $data['profile_image'] = time() . $remove_space;
            $destination_path = public_path('upload/cleaners/large');
            if (!file_exists($destination_path)) {
                mkdir($destination_path, 0755, true);
            }
            $img = Image::make($image->path());
            $width = 95;
            $height = 95;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($destination_path . "/" . $data['profile_image']);
            $data['profile_image'] = $data['profile_image'];
        }
        $data['cleaner_desc'] = $request->cleaner_desc;
        $data['language'] = $request->language;
        DB::table('users')->where('id', $id)->update($data);
        return redirect()->route('cleaners.index')->with('success', 'Cleaner Updated Successfully');
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
        DB::table('users')->whereIn('id', $delete_id)->delete();
        return redirect()->route('cleaners.index')->with('success', 'Cleaner has been deleted successfully');
    }

    function cleaners_subservice_show()
    {
        $service_id = $_POST['service'];
        $selected_subservice_ids = $_POST['selected_subservice_ids'] ?? [];
        // $subservices = DB::table('subservices')
        //                     ->select('*')
        //                     ->whereIn('serviceid', $service_id)
        //                     ->where('is_active', '0')
        //                     ->get();
        $subservices = DB::table('subservices')
            ->select('*')
            ->whereIn('serviceid', $service_id)
            ->where(function ($query) {
                $query->where('id', 97)
                    ->orWhere('is_active', '0');
            })
            ->get();
        $html = '<select class="form-control" id="subservice" name="subservice[]" multiple="multiple">';
        $html .= "<option value=''>Select Sub Service</option>";

        if ($subservices->isNotEmpty()) {
            foreach ($subservices as $subservice) {
                $selected = in_array($subservice->id, $selected_subservice_ids) ? ' selected' : '';
                $html .= "<option value='" . $subservice->id . "'" . $selected . ">" . $subservice->subservicename . "</option>";
            }
        }
        $html .= "</select>";

        // Return the generated HTML
        echo $html;
    }

    function cleaners_state_show()
    {

        $country_id = $_POST['country'];
        $state_data = DB::table('states')->where('country_id', $country_id)->get();

        $html = '<select class="form-control" id="state" name="state" onchange="city_change(this.value);">';
        $html .= "<option value=''>Select State </option>";
        if ($state_data->isNotEmpty()) {
            foreach ($state_data as $data) {
                $html .= "<option value= '" . $data->id . " '>" . $data->state . "</option>";
            }
        }
        $html .= "</select>";
        echo $html;
    }

    function cleaners_city_show()
    {

        $state_id = $_POST['state'];
        $selectedCity = $_POST['selectedCity'] ?? [];

        $city_data = DB::table('cities')->where('state', $state_id)->get();

        // echo"<pre>";print_r($city_data);echo"</pre>";exit;
        $html = '<select class="form-control" id="city" name="city[]" multiple="multiple">';

        $html .= "<option value=''>Select City</option>";

        if ($city_data->isNotEmpty()) {
            foreach ($city_data as $data) {
                $selected = in_array($data->id, $selectedCity) ? 'selected' : '';

                $html .= "<option value ='" . $data->id . " " . $selected . "'>" . $data->name . "</option>";
            }
        }

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

            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }
}
