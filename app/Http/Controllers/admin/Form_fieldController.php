<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Form_filed;
use DB;

class Form_fieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lable_name = $request->lable_name;
        $type = $request->type;
        $query = new Form_filed;

        if ($lable_name != '') {
            $query = $query->where('lable_name', $lable_name);
        }
        if ($type != '') {
            $query = $query->where('type', $type);
        }

        $data['lable_name'] = $lable_name;
        $data['type'] = $type;
        $data['form_data'] = $query->orderBy('id', 'DESC')->get();

        // if($type !=''){
        //     echo "<pre>";print_r($data['form_data']->toArray());echo "</pre>";exit;
        // }

        //$data['form_data'] = Form_filed::orderBy('id','DESC')->paginate(10);
        return view('admin.list_form_field', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add-form_field');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo"<pre>";print_r($request->post());echo"</pre>";exit;
        $request->validate([
            'lable_name' => 'required',
            'type' => 'required',
        ]);



        $form_field1 = new Form_filed;
        $form_field1->lable_name = $request->lable_name;
        $form_field1->type = $request->type;
        $form_field1->save();

        if ($request->form_option != '' && count($request->form_option) > 0) {
            for ($i = 0; $i < count($request->form_option); $i++) {
                if ($request->form_option[$i] != '') {
                    $content['form_id'] = $form_field1->id;
                    $content['form_option'] = $request->form_option[$i];

                    $test = DB::table('form_attributes')->insertGetId($content);

                    if ($request->has("more_form_option$i") && is_array($request->input("more_form_option$i"))) {
                        foreach ($request->input("more_form_option$i") as $option) {
                            if ($option != '') {
                                $data['attr_id'] = $test;
                                $data['form_id'] = $form_field1->id;
                                $data['more_form_option'] = $option;

                                DB::table('more_form_attributes')->insert($data);
                            }
                        }
                    }
                }
            }
        }


        return redirect()->route('form_field.index')->with('success', 'Form Field Added Successfully.');
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
        $form_filed = DB::table('form_fileds')->where('id', '=', $id)->first();
        $data['addition_item'] = DB::table('form_attributes')->select('*')->where('form_id', '=', $id)->get()->toArray();
        //echo "<pre>"; print_r ($data); echo "</pre>";exit;
        return view('admin.edit_form_field', compact('form_filed'), $data);
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
        //echo "<pre>"; print_r ($request->post()); echo "</pre>";

        $form_field1 = Form_filed::find($id);
        $request->validate([
            'lable_name' => 'required',
            'type' => 'required',
        ]);

        $form_field1->lable_name = $request->lable_name;
        $form_field1->type = $request->type;
        $form_field1->update();

        if ($request->form_optionu != '') {
            for ($i = 0; $i < count($request->form_optionu); $i++) {
                if ($request->form_optionu[$i] != '') {

                    $contentu['form_id'] = $form_field1->id;
                    $contentu['form_option'] = $request->form_optionu[$i];
                    $contentu['id'] = $request->updateid1[$i];


                    DB::table('form_attributes')->where('id', '=', $contentu['id'])->update($contentu);

                    if ($request->has("updateid2") && is_array($request->input("updateid2"))) {
                        for ($j = 0; $j < count($request->updateid2); $j++) {
                            $updateId = $request->updateid2[$j];


                            $moreFormOptionKey = "more_form_optionu" . $updateId;
                            if ($request->has($moreFormOptionKey) && is_array($request->input($moreFormOptionKey))) {
                                $data['more_form_option'] = $request->$moreFormOptionKey[0];
                                DB::table('more_form_attributes')->where('id', '=', $updateId)->update($data);
                            }
                        }
                    }
                }
            }

            if ($request->updateid1 != '') {

                for ($h = 0; $h < count($request->updateid1); $h++) {
                    $updateIds = $request->updateid1[$h];

                    $moreFormOptionKeys = "more_form_optionuin" . $updateIds;


                    $dataa['form_id'] = $form_field1->id;
                    $dataa['attr_id'] = $updateIds;

                    if ($request->has($moreFormOptionKeys) && is_array($request->input($moreFormOptionKeys))) {

                        $test = $request->input($moreFormOptionKeys);

                        foreach ($test as $key => $val) {

                            $dataa['more_form_option'] = $val;
                            DB::table('more_form_attributes')->insert($dataa);
                            //echo "<pre>asdfadsf"; print_r ($val); echo "</pre>";

                        }
                        // exit;

                    }
                }
                //exit;
            }
        }

        if (count($request->form_option1) > 0 && $request->form_option1 != '') {
            //echo "<pre>"; print_r ($request->form_option1); echo "</pre>";exit;
            for ($i = 0; $i < count($request->form_option1); $i++) {
                if ($request->form_option1[$i] != '') {
                    $content1['form_id'] = $form_field1->id;
                    $content1['form_option'] = $request->form_option1[$i];


                    $test = DB::table('form_attributes')->insertGetId($content1);


                    if ($request->has("more_form_option$i") && is_array($request->input("more_form_option$i"))) {
                        foreach ($request->input("more_form_option$i") as $option) {
                            if ($option != '') {
                                $data['attr_id'] = $test;
                                $data['form_id'] = $form_field1->id;
                                $data['more_form_option'] = $option;

                                DB::table('more_form_attributes')->insert($data);
                            }
                        }
                    }
                }
            }
        }
        return redirect()->route('form_field.index')->with('success', 'Form Field Updated successfully.');
    }
    public function remove_more_attribute(Request $request)
    {
        // echo $request->form_id."-".$request->id."-".$request->attr_id;exit;

        $form_id = $request->form_id;
        $id = $request->id;
        $attr_id = $request->attr_id;

        $result = DB::table('more_form_attributes')->where('form_id', '=', $form_id)->where('id', '=', $id)->where('attr_id', '=', $attr_id)->delete();

        return redirect()->route('form_field.edit', $form_id)->with('success', 'Form Attribute has been deleted successfully');
    }
    public function remove_attribute(Request $request)
    {
        // echo $request->id."-".$request->pid;exit;
        $form_id = $request->form_id;
        $id = $request->id;

        $result = DB::table('form_attributes')->where('form_id', '=', $form_id)->where('id', '=', $id)->delete();

        return redirect()->route('form_field.edit', $form_id)->with('success', 'Form Attribute has been deleted successfully');
    }

    public function delete_form_field(Request $request)
    {
        $delete_id = $request->selected;
        // echo $delete_id;exit;
        Form_filed::whereIn('id', $delete_id)->delete();
        DB::table('form_attributes')->whereIn('form_id', $delete_id)->delete();
        return redirect()->route('form_field.index')->with('success', 'Form Field has been deleted successfully');
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

    public function set_order_form_fields()

    {



        $id = $_POST['id'];

        $val = $_POST['val'];

        // echo $id."-".$val;exit;

        DB::table('form_fileds')->where('id', $id)->update(array('set_order' => $val));

        echo "1";

        // return redirect()->route('product.index')->with('success','Set Order has been Updated successfully');

    }
    public  function validate_form_field()
    {



        $id = $_POST['id'];

        $value = $_POST['value'];

        DB::table('form_fileds')->where('id', $id)->update(array('is_active' => $value));

        echo "1";
    }
    public  function mail_send_fun()
    {

        $id = $_POST['id'];

        $value = $_POST['value'];

        DB::table('form_fileds')->where('id', $id)->update(array('mail_send' => $value));

        echo "1";
    }
}
