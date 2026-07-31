<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use DB;
class GardenAcceptLeadsController extends Controller
{
    //
    public function index()
    {
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;       

        $query = DB::table('package_inquiry_accepted')->select('*')->where('accept_reject', 0);  


        $data['package_inquiry_accepted'] = $query->whereIn('subservice_id',['78,77'])->orderBy('id', 'desc')->get();

        // echo"<pre>";print_r($data['package_inquiry_accepted']);echo"</pre>";exit;
        return view('admin.list_garden_accept_leads',$data);
    }
    public function garden_enquiry_view($enquiry_id){
    
        $data['garden_enquiry_data']=DB::table('garden_enquiry')->where('inquiry_id',$enquiry_id)->first();

        // echo"<pre>";print_r($data['garden_enquiry_data']);echo"</pre>";exit;
        return view('admin.view_garden_enquiry',$data);

    }
    public function garden_reject_leads(Request $request)
    {
         $query = DB::table('package_inquiry_accepted')
                                       ->select('*')
                                    //    ->where('vendor_id', '=', $userId)
                                       ->where('accept_reject', 1);
                                       
       
        $data['package_inquiry_rejected'] = $query->orderBy('id', 'desc')->get();

        // echo"<pre>";print_r($data['package_inquiry_accepted']);echo"</pre>";exit;
             
       return view('admin.list_vendor_garden_reject_leads',$data);
    }

 
    
}
