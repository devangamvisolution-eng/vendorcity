<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\ModelModule;
use App\Models\admin\Vehicles;



class ModelController extends Controller
{
    //
    public function index(){
         $data['models']=ModelModule::orderBy('id','DESC')->get();
          return view('admin.list_models', $data);
    }
     public function create(){
        $data['vehicles']=Vehicles::orderBy('id','DESC')->get();
          return view('admin.add_models',$data);
     }
     public function store(request $request){
              $model = new ModelModule();
              $model->vehicle_name=$request->name;
              $model->model_name=$request->model_name;
              $model->category=$request->category;
              $model->price=$request->price;
              $model->save();
              return redirect()->route('model.index')->with('success','Model added Successfully.');

     }
       public function edit($id){
        $data['models']=ModelModule::findorfail($id);
        $data['vehicles']=Vehicles::orderBy('id','DESC')->get();
         return view('admin.edit_models',$data);

    }
    public function update(request $request,$id){
        $model = ModelModule::findorfail($id);
       $model->vehicle_name=$request->name;
              $model->model_name=$request->model_name;
              $model->category=$request->category;
              $model->price=$request->price;
        $model->save();
        return redirect()->route('model.index')->with('success','Model Updated Successfully.');

    }
    public function destroy(request $request){
           $id = $request->selected;
            $res = ModelModule::whereIn('id',$id)->delete();
             return redirect()->route('model.index')->with('success','Model Deleted Successfully.');
    }

}
