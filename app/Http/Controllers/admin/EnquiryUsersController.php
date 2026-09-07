<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EnquiryUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        // $data['enquiry_users_data'] = \DB::table("enquiry_users")->orderBy('id','DESC')->get();        
        //echo "<pre>";print_r($data);echo "</pre>";exit;
        $data['service_data'] = \DB::table('services')->orderBy('id','DESC')->get();
        // $data['subservice_data'] = \DB::table('subservices')->orderBy('id','DESC')->get();

        $startdate = $request->s_date;
        $enddate = $request->e_date;
        $servicename = $request->servicename;
        // $subservice_name = $request->subservice_name;

        $query= \DB::table('enquiry_users');

        if ($startdate !='')
        {   
            $query = $query->where('created_at', '>=', date('Y-m-d', strtotime($startdate)));
        }

        if ($enddate !='')
        {   
            $query = $query->where('created_at', '<=', date('Y-m-d', strtotime($enddate)));
        }    
        if ($servicename !='')
        {
            $query=$query->where('service_id', $servicename);
        }
        // if ($subservice_name !='')
        // {
        //     $query=$query->where('subservice_id', $subservice_name);
        // }
      
        $data['startdate'] =$startdate;
        $data['enddate'] =$enddate;
        $data['filter_service_id'] =$servicename;
        // $data['filter_subservice_id'] =$subservice_name;

        $data['enquiry_users_data'] = $query->orderBy('id','DESC')->get();
        

        return view('admin.list_enquiry_users',$data);
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
        //
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
        //
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
        \DB::table('enquiry_users')->whereIn('id',$delete_id)->delete();
        return redirect()->route('enquiry-users.index')->with('success','Enquiry User has been deleted successfully');
    }

    public function filter_data_enquiryusers(Request $request){

        $startdate = $request->input('startdate_fil','');
        $enddate = $request->input('enddate_fil','');
        $servicename = $request->input('filter_service_id_fil','');
        // $subservice_name = $request->input('filter_subservice_id_fil','');

        $query = \DB::table('enquiry_users');

        if ($startdate !='')
        {   
            $query = $query->where('created_at', '>=', date('Y-m-d', strtotime($startdate)));
        }
        if ($enddate !='')
        {   
            $query = $query->where('created_at', '<=', date('Y-m-d', strtotime($enddate)));
        }    
        if ($servicename !='')
        {
            $query=$query->where('service_id', $servicename);
        }
        // if ($subservice_name !='')
        // {
        //     $query=$query->where('subservice_id', $subservice_name);
        // }

        $data =$query->orderBy('id','DESC')->get()->toArray();

        // echo"<pre>";print_r($data);echo"</pre>";exit;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Service');
        $sheet->setCellValue('B1', 'Subservice');
        $sheet->setCellValue('C1', 'Name');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Mobile');
        $sheet->setCellValue('F1', 'created at');
       
        $row = 2;

        if(isset($data)){
            foreach ($data as $data_new) {

                $service_data= \DB::table('services')->where('id',$data_new->service_id)->first();

                $sub_service_data= \DB::table('subservices')->where('id',$data_new->subservice_id)->first();

                $enquiryusers_data = \DB::table('enquiry_users')->where('email',$data_new->email)->first();

                // echo"<pre>";print_r($data_new);echo"</pre>";exit;

                if ($service_data->servicename !== null) {
                    $sheet->setCellValue('A' . $row, $service_data->servicename);
                } else {
                   $sheet->setCellValue('A' . $row, '-'); 
                }
                if ($sub_service_data->subservicename !== null) {
                    $sheet->setCellValue('B' . $row, $sub_service_data->subservicename);
                } else {
                   $sheet->setCellValue('B' . $row, '-'); 
                }
                if ($enquiryusers_data->name !== null) {
                    $sheet->setCellValue('C' . $row, $data_new->name);
                } else {
                   $sheet->setCellValue('C' . $row, '-'); 
                }
                if ($enquiryusers_data->email !== null) {
                    $sheet->setCellValue('D' . $row, $enquiryusers_data->email);
                } else {
                   $sheet->setCellValue('D' . $row, '-'); 
                }
                if ($enquiryusers_data->mobile_number !== null) {
                    $sheet->setCellValue('E' . $row, $enquiryusers_data->mobile_number);
                } else {
                   $sheet->setCellValue('E' . $row, '-'); 
                }
                if ($enquiryusers_data->created_at !== null) {
                    $sheet->setCellValue('F' . $row, $enquiryusers_data->created_at);
                } else {
                   $sheet->setCellValue('F' . $row, '-'); 
                }
                $row++;
            }
        }
        $writer = new Xlsx($spreadsheet);

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Enquiryusers-list.xlsx"');
        header('Cache-Control: max-age=0');

        // Write the file to the browser
        $writer->save('php://output');

    }
}
