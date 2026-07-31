<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\admin\UserPermission;

use DB;

class UserPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data['permission_data'] = UserPermission::orderBy('id','DESC')->get();       
        return view('admin.list_userpermission',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission_data['permission'] = DB::table('permissions')->get();        
        return view('admin.add_userpermission',$permission_data);
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
        $request->validate([
            'cname' => 'required',
            'permission_type' => 'required',
            'permission' => '',
        ]);
       
        $user_permission = new UserPermission;
        $user_permission->cname = $request->cname;
        $user_permission->permission_type = $request->permission_type;
        if ($request->permission != '')
        {
            $user_permission->permission = implode(',',$request->permission);
        }
        if ($request->add_edit_perm != '')
        {
            $user_permission->editperm = implode(',',$request->add_edit_perm);
        }
        $user_permission->save();
        return redirect()->route('userpermission.index')->with('success','Permission Added Successfully.');
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
        $user_permission=   DB::table('user_permissions')->where('id',$id)->first();
        
        $permission_data['permission'] = DB::table('permissions')->get();
        return view('admin.edit_userpermission',compact('user_permission'),$permission_data);
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
      
        $request->validate([
            'cname' => 'required',
            'permission_type' => 'required',
            'permission' => '',
        ]);
        
        $user_permission = UserPermission::find($id);
        
        $user_permission->cname = $request->cname;
        $user_permission->permission_type = implode(',',$request->permission_type);
        if ($request->permission != '')
        {
            $user_permission->permission = implode(',',$request->permission);
        }
        if ($request->has('add_edit_perm')) {
            $user_permission->editperm = implode(',', $request->input('add_edit_perm'));
        } else {
            $user_permission->editperm = ''; // Clear the editperm value if no checkboxes are selected
        }   
        
       
        $user_permission->save();
        return redirect()->route('userpermission.index')->with('success','Permission Updated Successfully.');
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
    public function destroyPermission(Request $request)
    {   
       // echo "<pre>";print_r($request->per_id);echo "</pre>";exit;
        $delete_id = $request->per_id;
        DB::table('permission')->where('id',$delete_id)->delete();
        return redirect()->route('userpermission.create')->with('success','Permission has been deleted successfully');
    }
    public function delete_permission(Request $request)
    {
        $delete_id = $request->selected;
        UserPermission::whereIn('id',$delete_id)->delete();
        return redirect()->route('userpermission.index')->with('success','Permission has been deleted successfully');
    }
}