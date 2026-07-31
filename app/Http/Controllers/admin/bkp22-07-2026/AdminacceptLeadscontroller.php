<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use DB;
class AdminacceptLeadscontroller extends Controller
{
    //
    public function enquiry_accept(Request $request)
    {
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;       

        $query = DB::table('package_inquiry_accepted')->select('*')->where('accept_reject', 0);  

        $startdate = $request->s_date;
        $enddate = $request->e_date;
        $vendor_ids = $request->vendor_id; // Retrieve array of vendor IDs

        // echo"<pre>";print_r($vendor_ids);echo"</pre>";exit;    

        if ($startdate !='')
        {   
            $query = $query->where('added_date', '>=', date('Y-m-d', strtotime($startdate)));
        }

        if ($enddate !='')
        {   
            $query = $query->where('added_date', '<=', date('Y-m-d', strtotime($enddate)));
        }    
        // Apply vendor ID filter
        if (!empty($vendor_ids)) {
            $query = $query->whereIn('vendor_id', $vendor_ids); // Use `whereIn` for array filtering
        }

        $data['startdate'] =$startdate;
        $data['enddate'] =$enddate;
        $data['filter_vendor_id'] =$vendor_ids;

        

        $data['package_inquiry_accepted'] = $query->whereIn('service_id', [30,44])->orderBy('id', 'desc')->get();
        $data['all_vendor'] = DB::table('users')->where('vendor',1)->where('is_active',0)->get()->toArray();
        return view('admin.list_adminaccept_leads',$data);
    }

    public function enquiry_reject(Request $request)
    {
         $query = DB::table('package_inquiry_accepted')
                                       ->select('*')
                                       ->whereIn('service_id',[30,44])
                                       //->where('vendor_id', '=', $userId)
                                       ->where('accept_reject', 1);
                                       
        $data['filter_vendor_id'] = "";
        if($request->action == 'filter'){
            $query->where('vendor_id',$request->vendor_id);
            $data['filter_vendor_id'] =$request->vendor_id;
        }
        $data['package_inquiry_accepted'] = $query->orderBy('id', 'desc')->get();
        $data['all_vendor'] = DB::table('users')->where('vendor',1)->where('is_active',0)->get()->toArray();
             
       return view('admin.list_adminreject_leads',$data);
    }

    public function painting_enquiry(Request $request)
    {
        $data['painting_enquiry'] = DB::table('painting_enquiry')->orderBy('id', 'desc')->get();
       // echo"<pre>";print_r($data['painting_enquiry']);echo"</pre>";exit;                          
        return view('admin.list_painting_enquiry',$data);
    }

    public function wooden_floor_enquiry(Request $request)
    {
        $data['wooden_floor_enquiry'] = DB::table('wooden_floor_enquiry')->orderBy('id', 'desc')->get();
       // echo"<pre>";print_r($data['painting_enquiry']);echo"</pre>";exit;                          
        return view('admin.list_wooden_floor_enquiry',$data);
    }

    public function garden_enquiry(Request $request)
    {
        $startdate = $request->s_date;
        $enddate = $request->e_date;

        $query = DB::table('garden_enquiry');

        if ($startdate !='')
        {   
            $query = $query->where('added_date', '>=', date('Y-m-d', strtotime($startdate)));
        }

        if ($enddate !='')
        {   
            $query = $query->where('added_date', '<=', date('Y-m-d', strtotime($enddate)));
        }    

        $data['startdate'] =$startdate;
        $data['enddate'] =$enddate;

        $data['garden_enquiry'] = $query->orderBy('id','DESC')->get();

        return view('admin.list_garden_enquiry',$data);
    }

    public function garden_accept(Request $request)
    {
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;       

        $query = DB::table('package_inquiry_accepted')->select('*')->where('accept_reject', 0);  

        $startdate = $request->s_date;
        $enddate = $request->e_date;
        $vendor_ids = $request->vendor_id; // Retrieve array of vendor IDs

        // echo"<pre>";print_r($vendor_ids);echo"</pre>";exit;    

        if ($startdate !='')
        {   
            $query = $query->where('added_date', '>=', date('Y-m-d', strtotime($startdate)));
        }

        if ($enddate !='')
        {   
            $query = $query->where('added_date', '<=', date('Y-m-d', strtotime($enddate)));
        }    
        // Apply vendor ID filter
        if (!empty($vendor_ids)) {
            $query = $query->whereIn('vendor_id', $vendor_ids); // Use `whereIn` for array filtering
        }

        $data['startdate'] =$startdate;
        $data['enddate'] =$enddate;
        $data['filter_vendor_id'] =$vendor_ids;

        

        $data['package_inquiry_accepted'] = $query->where('service_id', '=', 47)->orderBy('id', 'desc')->get();
        $data['all_vendor'] = DB::table('users')->where('vendor',1)->where('is_active',0)->get()->toArray();
        return view('admin.list_garden_admin_accept_leads',$data);
    }
    public function garden_enquiry_reject(Request $request)
    {
         $query = DB::table('package_inquiry_accepted')
                                       ->select('*')
                                       ->where('service_id','=',47)
                                       //->where('vendor_id', '=', $userId)
                                       ->where('accept_reject', 1);

        $data['package_inquiry_accepted'] = $query->orderBy('id', 'desc')->get();
             
       return view('admin.list_garden_admin_reject_leads',$data);
    }

    public function filter_data(Request $request)
    {
       

        $startdate = $request->startdate_fil;
        $enddate = $request->enddate_fil;
        $vendor_ids = $request->filter_vendor_id_fil;

        if (!is_array($vendor_ids)) {
            $vendor_ids = !empty($vendor_ids) ? explode(',', $vendor_ids) : [];
        }
        // echo"<pre>";print_r($vendor_ids);echo"</pre>";exit;

        $query = DB::table('package_inquiry_accepted')->select('*')->where('accept_reject', 0)->whereIn('service_id', [30,44]);
      

        if ($startdate !='')
        {   
            $query = $query->where('added_date', '>=', date('Y-m-d', strtotime($startdate)));
        }

        if ($enddate !='')
        {   
            $query = $query->where('added_date', '<=', date('Y-m-d', strtotime($enddate)));
        }    
        if (!empty($vendor_ids)) {
            $query = $query->whereIn('vendor_id', $vendor_ids); 
        }

        $data = $query->orderBy('id', 'desc')->get();

        // echo"<pre>";print_r($data);echo"</pre>";exit;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Date');
        $sheet->setCellValue('B1', 'Vendor Name');
        $sheet->setCellValue('C1', 'Inquiry No');
        $sheet->setCellValue('D1', 'Accepted Date');
        $sheet->setCellValue('E1', 'Name');
        $sheet->setCellValue('F1', 'Service');
        $sheet->setCellValue('G1', 'Sub Service');
        $sheet->setCellValue('H1', 'Lead Amount');
        $row = 2;
        if(isset($data)){
            foreach ($data as $data_new) {
            $service_data=DB::table('services')->where('id',$data_new->service_id)->first();
            $sub_service_data=DB::table('subservices')->where('id',$data_new->subservice_id)->first();
            $vendor_data = DB::table('users')->where('vendor',1)->where('is_active',0)->where('id',$data_new->vendor_id)->first();
            $packages_enquiry_data = DB::table('packages_enquiry')->where('id','=',$data_new->packages_inquiry_id,)->first();
            // echo"<pre>";print_r($packages_enquiry_data);echo"</pre>";exit;
            // $customer_data = DB::table('packages_enquiry')->groupBy('name')->where('name',$data_new->name)->first();
            if ($packages_enquiry_data->added_date !== null) {
                $sheet->setCellValue('A' . $row, $packages_enquiry_data->added_date);
            } else {
               $sheet->setCellValue('A' . $row, '-'); 
            }
            if ($vendor_data && $vendor_data->name !== null) {
                $sheet->setCellValue('B' . $row, $vendor_data->name);
            } else {
               $sheet->setCellValue('B' . $row, '-'); 
            }
            if ($packages_enquiry_data->inquiry_id !== null) {
                $sheet->setCellValue('C' . $row, $packages_enquiry_data->inquiry_id);
            } else {
               $sheet->setCellValue('C' . $row, '-'); 
            }
            if ($data_new->added_date !== null) {
                $sheet->setCellValue('D' . $row,$data_new->added_date);
            } else {
               $sheet->setCellValue('D' . $row, '-'); 
            }
            if ($packages_enquiry_data->name !== null) {
                $sheet->setCellValue('E' . $row, $packages_enquiry_data->name);
            } else {
               $sheet->setCellValue('E' . $row, '-'); 
            }
            if ($service_data->servicename !== null) {
                $sheet->setCellValue('F' . $row, $service_data->servicename);
            } else {
               $sheet->setCellValue('F' . $row, '-'); 
            }
            if ($sub_service_data->subservicename !== null) {
                $sheet->setCellValue('G' . $row, $sub_service_data->subservicename);
            } else {
               $sheet->setCellValue('G' . $row, '-'); 
            }
            if ($data_new->price_of_lead !== null) {
                $sheet->setCellValue('H' . $row, $data_new->price_of_lead);
            } else {
               $sheet->setCellValue('H' . $row, '0'); 
            }
            $row++;
            }
           
        }
        $writer = new Xlsx($spreadsheet);
        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Accepted-Enquiry-list.xlsx"');
        header('Cache-Control: max-age=0');
        // Write the file to the browser
        $writer->save('php://output');
    }

    public function garden_accept_filter_data(Request $request)
    {
       

        $startdate = $request->startdate_fil;
        $enddate = $request->enddate_fil;
        $vendor_ids = $request->filter_vendor_id_fil;

        if (!is_array($vendor_ids)) {
            $vendor_ids = !empty($vendor_ids) ? explode(',', $vendor_ids) : [];
        }
        // echo"<pre>";print_r($vendor_ids);echo"</pre>";exit;

        $query = DB::table('package_inquiry_accepted')->select('*')->where('accept_reject', 0)->where('service_id','=',47);
      

        if ($startdate !='')
        {   
            $query = $query->where('added_date', '>=', date('Y-m-d', strtotime($startdate)));
        }

        if ($enddate !='')
        {   
            $query = $query->where('added_date', '<=', date('Y-m-d', strtotime($enddate)));
        }    
        if (!empty($vendor_ids)) {
            $query = $query->whereIn('vendor_id', $vendor_ids); 
        }

        $data = $query->orderBy('id', 'desc')->get();

        // echo"<pre>";print_r($data);echo"</pre>";exit;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Date');
        $sheet->setCellValue('B1', 'Vendor Name');
        $sheet->setCellValue('C1', 'Inquiry No');
        $sheet->setCellValue('D1', 'Accepted Date');
        $sheet->setCellValue('E1', 'Name');
        $sheet->setCellValue('F1', 'Service');
        $sheet->setCellValue('G1', 'Sub Service');
        $sheet->setCellValue('H1', 'Lead Amount');
        $row = 2;
        if(isset($data)){
            foreach ($data as $data_new) {
            $service_data=DB::table('services')->where('id',$data_new->service_id)->first();
            $sub_service_data=DB::table('subservices')->where('id',$data_new->subservice_id)->first();
            $vendor_data = DB::table('users')->where('vendor',1)->where('is_active',0)->where('id',$data_new->vendor_id)->first();
            $packages_enquiry_data = DB::table('packages_enquiry')->where('id','=',$data_new->packages_inquiry_id,)->first();
            // echo"<pre>";print_r($packages_enquiry_data);echo"</pre>";exit;
            // $customer_data = DB::table('packages_enquiry')->groupBy('name')->where('name',$data_new->name)->first();
            if ($packages_enquiry_data->added_date !== null) {
                $sheet->setCellValue('A' . $row, $packages_enquiry_data->added_date);
            } else {
               $sheet->setCellValue('A' . $row, '-'); 
            }
            if ($vendor_data && $vendor_data->name !== null) {
                $sheet->setCellValue('B' . $row, $vendor_data->name);
            } else {
               $sheet->setCellValue('B' . $row, '-'); 
            }
            if ($packages_enquiry_data->inquiry_id !== null) {
                $sheet->setCellValue('C' . $row, $packages_enquiry_data->inquiry_id);
            } else {
               $sheet->setCellValue('C' . $row, '-'); 
            }
            if ($data_new->added_date !== null) {
                $sheet->setCellValue('D' . $row,$data_new->added_date);
            } else {
               $sheet->setCellValue('D' . $row, '-'); 
            }
            if ($packages_enquiry_data->name !== null) {
                $sheet->setCellValue('E' . $row, $packages_enquiry_data->name);
            } else {
               $sheet->setCellValue('E' . $row, '-'); 
            }
            if ($service_data->servicename !== null) {
                $sheet->setCellValue('F' . $row, $service_data->servicename);
            } else {
               $sheet->setCellValue('F' . $row, '-'); 
            }
            if ($sub_service_data->subservicename !== null) {
                $sheet->setCellValue('G' . $row, $sub_service_data->subservicename);
            } else {
               $sheet->setCellValue('G' . $row, '-'); 
            }
            if ($data_new->price_of_lead !== null) {
                $sheet->setCellValue('H' . $row, $data_new->price_of_lead);
            } else {
               $sheet->setCellValue('H' . $row, '0'); 
            }
            $row++;
            }
           
        }
        $writer = new Xlsx($spreadsheet);
        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Garden-Accepted-Enquiry-list.xlsx"');
        header('Cache-Control: max-age=0');
        // Write the file to the browser
        $writer->save('php://output');
    }

    public function garden_filter_data(Request $request){
      
        $startdate = $request->input('startdate_fil','');
        $enddate = $request->input('enddate_fil','');
       

        $query = DB::table('garden_enquiry');

        if ($startdate !='')
        {   
            $query = $query->where('added_date', '>=', date('Y-m-d', strtotime($startdate)));
        }
        if ($enddate !='')
        {   
            $query = $query->where('added_date', '<=', date('Y-m-d', strtotime($enddate)));
        }    

        $data =$query->orderBy('id','DESC')->get()->toArray();

        // echo"<pre>";
        // print_r($data);
        // echo"</pre>";exit;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Date');
        $sheet->setCellValue('B1', 'Inquiry No');
        $sheet->setCellValue('C1', 'Status');
        $sheet->setCellValue('D1', 'Name');
        $sheet->setCellValue('E1', 'Email');
        $sheet->setCellValue('F1', 'Mobile');
        $sheet->setCellValue('G1', 'Service');
        $sheet->setCellValue('H1', 'Sub Service');
        $sheet->setCellValue('I1', 'Type of Home');
        $sheet->setCellValue('J1', 'Size of Home');
        $sheet->setCellValue('K1', 'Service Date');
       
        $row = 2;

        if(isset($data)){
            foreach ($data as $data_new) {

                $service_data=DB::table('services')->where('id',$data_new->service)->first();

                $sub_service_data=DB::table('subservices')->where('id',$data_new->subservice)->first();

                $package_enquiry_data = DB::table('packages_enquiry')->where('id',$data_new->inquiry_id)->first();

                // echo"<pre>";print_r($customer_data);echo"</pre>";exit;

                if ($data_new->added_date !== null) {
                    $sheet->setCellValue('A' . $row, $data_new->added_date);
                } else {
                   $sheet->setCellValue('A' . $row, '-'); 
                }

                if ($package_enquiry_data->inquiry_id !== null) {
                    $sheet->setCellValue('B' . $row, $package_enquiry_data->inquiry_id);
                } else {
                   $sheet->setCellValue('B' . $row, '-'); 
                }
                if ($package_enquiry_data->count !== null) {
                    $sheet->setCellValue('C' . $row, $package_enquiry_data->count . '/5 Accepted');
                } else {
                   $sheet->setCellValue('C' . $row, '-'); 
                }
                if ($data_new->user_name !== null) {
                    $sheet->setCellValue('D' . $row, $data_new->user_name);
                } else {
                   $sheet->setCellValue('D' . $row, '-'); 
                }
                if ($data_new->user_email !== null) {
                    $sheet->setCellValue('E' . $row, $data_new->user_email);
                } else {
                   $sheet->setCellValue('E' . $row, '-'); 
                }
                if ($data_new->user_mobile !== null) {
                    $sheet->setCellValue('F' . $row, $data_new->user_mobile);
                } else {
                   $sheet->setCellValue('F' . $row, '-'); 
                }
                if ($service_data->servicename !== null) {
                    $sheet->setCellValue('G' . $row, $service_data->servicename);
                } else {
                   $sheet->setCellValue('G' . $row, '-'); 
                }
                if ($sub_service_data->subservicename !== null) {
                    $sheet->setCellValue('H' . $row, $sub_service_data->subservicename);
                } else {
                   $sheet->setCellValue('H' . $row, '-'); 
                }
                if ($data_new->type_of_home !== null) {
                    $sheet->setCellValue('I' . $row, $data_new->type_of_home);
                } else {
                   $sheet->setCellValue('I' . $row, '-'); 
                }
                if ($data_new->size_of_home !== null) {
                    $sheet->setCellValue('J' . $row, $data_new->size_of_home);
                } else {
                   $sheet->setCellValue('J' . $row, '-'); 
                }
                if ($data_new->service_date !== null) {
                    $sheet->setCellValue('K' . $row, $data_new->service_date);
                } else {
                   $sheet->setCellValue('K' . $row, '-'); 
                }
                $row++;

            }
        }
        $writer = new Xlsx($spreadsheet);

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Garden-Enquiry-list.xlsx"');
        header('Cache-Control: max-age=0');

        // Write the file to the browser
        $writer->save('php://output');

        


    }
}
