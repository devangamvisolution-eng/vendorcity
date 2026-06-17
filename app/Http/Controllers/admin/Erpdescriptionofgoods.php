<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Erpdescriptionofgoods as dsgmodel;

class Erpdescriptionofgoods extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata'] = dsgmodel::orderBy('id', 'desc')->get();
        return view('admin.erp_dog.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['error'] = "";
        return view('admin.erp_dog.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];


        $validated = $request->validate($rules);

        $data['name']  = $request->name;
        $id = dsgmodel::insertGetId($data);

        return  redirect()->route('erp_dog.lists')->with('success', 'Description Of Goods  added successfully');
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
        $data['error'] = "";
        $data['data'] = dsgmodel::where('id', $id)->first();
        return view('admin.erp_dog.edit', $data);
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
        $rules = [
            'name' => 'required',
        ];


        $validated = $request->validate($rules);

        $data['name']  = $request->name;
        dsgmodel::where('id', $id)->update($data);
        return  redirect()->route('erp_dog.lists')->with('success', 'Description Of Goods Update successfully');
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
        dsgmodel::whereIn('id', $delete_id)->delete();
        return redirect()->route('erp_dog.lists')->with('success', 'Description Of Goods deleted successfully.');
    }
}
