<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\UserPermission;
use App\Models\User;
use DB;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = Auth::user();

        if($user->role_id == 1){
            $data['driver_data'] = DB::table('users')->where('role_id','=','15')->get();
        }else{
             $data['driver_data'] = DB::table('users')->where('role_id','=','15')->where('added_by',$user->id)->get();
        }

       return view('admin.list_driver',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_data['user_category'] =UserPermission::where('id','=','15')->get(); 

        return view('admin.add_driver',$user_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // echo"<pre>";print_r($user);die;

        $data = Validator::make($request->all(),[
            'user_id'   => 'required',
            'name'      => 'required',
            'user_name' => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6|max:20',
            'mobile'    => 'required|numeric|digits:10'
        ]);

        if($data->fails()){
            return redirect()->back()->withErrors($data)->withInput();
        }
        
        $data =new User;
        $data->role_id   = $request->user_id;
        $data->name      = $request->name;
        $data->user_name = $request->user_name;
        $data->email     = $request->email;
        $data->password  = Hash::make($request->password);     
        $data->mobile    = $request->mobile;
        $data->added_by  = $user->id;
        $data->vendor    = 0; 
        $data->save();      
        return redirect()->route('driver.index')->with('success','Driver Added Successfully.');
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
        $data['driver'] = DB::table('users')->where('id' , '=' , $id)->first(); 

        $data['user_category'] = DB::select('select * from user_permissions');

        return view('admin.edit_driver',$data);
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
        $data = User::find($id);
        $data->name      = $request->name;
        $data->user_name      = $request->user_name;
        $data->email      = $request->email;
        // $data->password      = $request->password;     
        $data->mobile      = $request->mobile; 
        $data->save();
        return redirect()->route('driver.index')->with('success','Driver Updated Successfully.');
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
        DB::table('users')->whereIn('id',$delete_id)->delete();
        return redirect()->route('driver.index')->with('success','Driver Deleted Successfully.');
    }
}
