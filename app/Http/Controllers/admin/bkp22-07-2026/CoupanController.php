<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use DB;

class CoupanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['all_coupan']= DB::table('coupans')->orderBy('id','DESC')->get();

       return view('admin.list_coupan',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['service'] = DB::table('services')->where('is_active', '0')->orderBy('id','DESC')->get();
        $data['subservice'] = DB::table('subservices')->orderBy('id','DESC')->get();
        return view('admin.add_coupan',$data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo"<pre>";print_r($_POST);echo"<pre>";exit;

        $data['coupan_name'] = $request->input('coupan_name');
        $data['coupan_code'] = $request->input('coupan_code');
        $data['service_id'] = implode(',', $request->input('service_id'));
        $data['subservice_id'] = implode(',', $request->input('subservice_id'));
        $data['discount'] = $request->input('discount');
        $data['coupanvalue'] = $request->input('coupanvalue');
        $data['coupan_apply_wallet'] = $request->input('coupan_apply_wallet');
        $data['minimum_order'] = $request->input('minimum_order');
        $data['no_of_coupons'] = $request->input('no_of_coupons');
        $data['no_of_coupons_user'] = $request->input('no_of_coupons_user');
        $data['startdate'] = $request->input('startdate');
        $data['enddate'] = $request->input('enddate');
        $data['description'] = $request->input('description');
        $data['is_active'] = 0;

        DB::table('coupans')->insert($data);

    return redirect()->route('coupan.index')->with('success','Coupon Added Successfully.');  
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data['coupan_data'] = DB::table('coupans')->where('id',$id)->first();

        // echo"<pre>";print_r($data['coupan_data']);echo"<pre>";exit;

        $service_id = explode(',', $data['coupan_data']->service_id);

        // ECHO"<PRE>";PRINT_R($service_id);EXIT;

        $data['service'] = DB::table('services')->where('is_active', '0')->orderBy('id','DESC')->get();

        $data['subservice'] = DB::table('subservices')->whereIn('serviceid',$service_id)->orderBy('id','DESC')->get();

        return view('admin.edit_coupan',$data);

    }

    public function update(Request $request, $id)
    {
        // echo"<pre>";print_r($_POST);echo"<pre>";exit;
        $data['coupan_name'] = $request->input('coupan_name');
        $data['coupan_code'] = $request->input('coupan_code');
        $data['service_id'] = implode(',', $request->input('service_id'));
        $data['subservice_id'] = implode(',', $request->input('subservice_id'));
        $data['discount'] = $request->input('discount');
        $data['coupanvalue'] = $request->input('coupanvalue');
        $data['coupan_apply_wallet'] = $request->input('coupan_apply_wallet');
        $data['minimum_order'] = $request->input('minimum_order');
        $data['no_of_coupons'] = $request->input('no_of_coupons');
        $data['no_of_coupons_user'] = $request->input('no_of_coupons_user');
        $data['startdate'] = $request->input('startdate');
        $data['enddate'] = $request->input('enddate');
        $data['description'] = $request->input('description');

        DB::table('coupans')->where('id',$id)->update($data);

    return redirect()->route('coupan.index')->with('success','Coupon Updated Successfully.');

    }

    public function destroy(Request $request)
    {
        // echo"<pre>";print_r($request->all());echo"<pre>";exit;

        $delete_id = $request->selected;

        // echo"<pre>";print_r($delete_id);echo"<pre>";exit;

        DB::table('coupans')->whereIn('id',$delete_id)->delete();

        return redirect()->route('coupan.index')->with('success','Coupon has been deleted successfully');
    }

    public  function change_status_coupan(){
        $id=$_POST['id'];
        $value=$_POST['value'];
        DB::table('coupans')->where('id',$id)->update(array('is_active'=>$value));

        echo"1";

    }
    public function coupan_subservice_change(){

        // echo"<pre>";print_r($_POST);echo"<pre>";exit;

    $service_id = $_POST['service_id'];
    $selected_subservice_ids = $_POST['selected_subservice_ids'] ?? [];

    $subservices = DB::table('subservices')
                        ->select('*')
                        ->whereIn('serviceid', $service_id)
                        ->where('is_active', '0')
                        ->get();
    $html = '<select class="form-control" id="subservice_id" name="subservice_id[]" multiple="multiple">';
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
}
