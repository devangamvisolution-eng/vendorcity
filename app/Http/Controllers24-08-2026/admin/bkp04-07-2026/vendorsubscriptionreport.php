<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class vendorsubscriptionreport extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $startdate = $request->s_date;
        $enddate = $request->e_date;
        $vendorname = $request->vendorname;
        $vendorsubscriptionid = $request->vendorsubscription;

        
        $data['package_accept_inquiry'] = array();
        $data['vendor_subscription'] =  array();
        if($request->action == 'filtersubscription'){

            //echo"<pre>";print_r($request->all());echo"</pre>";exit;

            $query = DB::table('package_inquiry_accepted')
                    ->leftJoin('subscription', 'package_inquiry_accepted.subscription_id', '=', 'subscription.id')
                    ->leftJoin('packages_enquiry', 'package_inquiry_accepted.packages_inquiry_id', '=', 'packages_enquiry.id');

                if (!empty($startdate)) {   
                    $query->where('package_inquiry_accepted.added_date', '>=', date('Y-m-d', strtotime($startdate)));
                }

                if (!empty($enddate)) {   
                    $query->where('package_inquiry_accepted.added_date', '<=', date('Y-m-d', strtotime($enddate)));
                }    

                if (!empty($vendorname)) {
                    $query->where('package_inquiry_accepted.vendor_id', $vendorname);
                }

                if (!empty($vendorsubscriptionid)) {
                    $query->where('package_inquiry_accepted.subscription_id', $vendorsubscriptionid);
                }

                // Fetching the data
                $data['package_accept_inquiry'] = $query->select(
                        'package_inquiry_accepted.*',
                        'subscription.subscription_name', // Example column from subscription
                        'subscription.id as subscription_id',
                        'subscription.type_of_subscription as subscription_type_of_subscription',
                        'subscription.type_of_package as subscription_type_of_package',
                        'subscription.no_of_inquiry_package as subscription_no_of_inquiry_package',
                        'subscription.price_package as subscription_price_package',
                        'packages_enquiry.inquiry_id as inq_idformat',
                        'packages_enquiry.id as inq_id',
                        'packages_enquiry.name as inq_name',
                        'packages_enquiry.service_id as inq_service_id',
                        'packages_enquiry.subservice_id as inq_subservice_id',
                        'packages_enquiry.subservice_id as inq_subservice_id',
                        'packages_enquiry.email as inq_email',
                        'packages_enquiry.mobile as inq_mobile',
                        'packages_enquiry.form_type as inq_form_type',
                    )
                    ->orderBy('package_inquiry_accepted.id', 'DESC')
                    ->get();


                    $result = DB::table('subscription')->select('*')->where('vendor_id','=',$vendorname)->where('is_deleted' , '=' ,'0')->orderBy('id','DESC')->get();        

                    $result_new = $result->toArray();

                    $data['vendor_subscription'] = $result_new;

            
        }

    //    echo"<pre>";print_r($data['package_accept_inquiry']);echo"</pre>";exit;

            //echo "sd";exit;

       
        $data['vendor_data'] = DB::table('users')->where('vendor','1')->get();

        $data['startdate'] =$startdate;
        $data['enddate'] =$enddate;
        $data['filter_vendor_id'] =$vendorname;
        $data['filter_vendorsubscriptionid'] =$vendorsubscriptionid;

        return view('admin.list_vendor_subscriptionreport',$data);
    }

    function filter_vendorsubscriptionreport(Request $request){

        $startdate = $request->input('startdate_fil','');
        $enddate = $request->input('enddate_fil','');
        $vendorname = $request->input('filter_vendor_id_fil','');
        $vendorsubscriptionid = $request->input('filter_vendorsubscriptionid','');

        $query = DB::table('package_inquiry_accepted')
                    ->leftJoin('subscription', 'package_inquiry_accepted.subscription_id', '=', 'subscription.id')
                    ->leftJoin('packages_enquiry', 'package_inquiry_accepted.packages_inquiry_id', '=', 'packages_enquiry.id');

        if (!empty($startdate)) {   
            $query->where('package_inquiry_accepted.added_date', '>=', date('Y-m-d', strtotime($startdate)));
        }

        if (!empty($enddate)) {   
            $query->where('package_inquiry_accepted.added_date', '<=', date('Y-m-d', strtotime($enddate)));
        }    

        if (!empty($vendorname)) {
            $query->where('package_inquiry_accepted.vendor_id', $vendorname);
        }

        if (!empty($vendorsubscriptionid)) {
            $query->where('package_inquiry_accepted.subscription_id', $vendorsubscriptionid);
        }

                // Fetching the data
                $data = $query->select(
                        'package_inquiry_accepted.*',
                        'subscription.subscription_name', // Example column from subscription
                        'subscription.id as subscription_id',
                        'subscription.type_of_subscription as subscription_type_of_subscription',
                        'subscription.type_of_package as subscription_type_of_package',
                        'subscription.no_of_inquiry_package as subscription_no_of_inquiry_package',
                        'subscription.price_package as subscription_price_package',
                        'packages_enquiry.inquiry_id as inq_idformat',
                        'packages_enquiry.id as inq_id',
                        'packages_enquiry.name as inq_name',
                        'packages_enquiry.service_id as inq_service_id',
                        'packages_enquiry.subservice_id as inq_subservice_id',
                        'packages_enquiry.subservice_id as inq_subservice_id',
                        'packages_enquiry.email as inq_email',
                        'packages_enquiry.mobile as inq_mobile',
                        'packages_enquiry.form_type as inq_form_type',
                    )
                    ->orderBy('package_inquiry_accepted.id', 'DESC')
                    ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $styleArray = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'A9A9A9', // Dark Grey background
                ],
            ],
            'font' => [
                    'bold' => true, // Makes the text bold
                ],
        ];

        $styleArray1 = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FFFF00', // Yellow background
                ],
            ],
        ];

        $styleArray2 = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '0000FF', // Blue background
                ],
            ],
            'font' => [
                'color' => [
                    'rgb' => 'FFFFFF', // White text
                ],
                'bold' => true, // Bold text
            ],
        ];
        


        $row_new =1;

        $download_date = date('Y-m-d');

        $sheet->getStyle('E'.($row_new + 1))->applyFromArray($styleArray);
        $sheet->getStyle('E'.($row_new + 2))->applyFromArray($styleArray);
        $sheet->getStyle('E'.($row_new + 3))->applyFromArray($styleArray);

        $sheet->getStyle('F'.($row_new + 1))->applyFromArray($styleArray1);
        $sheet->getStyle('F'.($row_new + 2))->applyFromArray($styleArray1);
        $sheet->getStyle('F'.($row_new + 3))->applyFromArray($styleArray1);

        $sheet->setCellValue('E'.$row_new + 1  .'', 'Date:');
        $sheet->setCellValue('F'.$row_new + 1  .'', ''.$download_date.'');

        $sheet->setCellValue('E'.$row_new + 2  .'', 'From Date:');
        if($startdate){
        $sheet->setCellValue('F'.$row_new + 2  .'', ''.$startdate.'');
        }else{
        $sheet->setCellValue('F'.$row_new + 2  .'', '-');
        }

        $sheet->setCellValue('E'.$row_new + 3  .'', 'To Date:');
        if($enddate){
        $sheet->setCellValue('F'.$row_new + 3  .'', ''.$enddate.'');
        }else{
        $sheet->setCellValue('F'.$row_new + 3  .'', '-');
        }

        if($data[0]->subscription_type_of_subscription == 0 || $data[0]->subscription_type_of_subscription == 2 && count($data) > 0){
            
            $sheet->getStyle('A'.($row_new))->applyFromArray($styleArray2);
            $sheet->getStyle('B'.($row_new))->applyFromArray($styleArray2);
            $sheet->getStyle('A'.($row_new + 1))->applyFromArray($styleArray2);
            $sheet->getStyle('A'.($row_new + 2))->applyFromArray($styleArray2);
            $sheet->getStyle('A'.($row_new + 3))->applyFromArray($styleArray2);
            $sheet->getStyle('A'.($row_new + 4))->applyFromArray($styleArray2);
            $sheet->getStyle('A'.($row_new + 5))->applyFromArray($styleArray2);
            $sheet->getStyle('A'.($row_new + 6))->applyFromArray($styleArray2);

            $sheet->getStyle('B'.($row_new + 1))->applyFromArray($styleArray2);
            $sheet->getStyle('B'.($row_new + 2))->applyFromArray($styleArray2);
            $sheet->getStyle('B'.($row_new + 3))->applyFromArray($styleArray2);
            $sheet->getStyle('B'.($row_new + 4))->applyFromArray($styleArray2);
            $sheet->getStyle('B'.($row_new + 5))->applyFromArray($styleArray2);
            $sheet->getStyle('B'.($row_new + 6))->applyFromArray($styleArray2);

            $sheet->setCellValue('A'.$row_new.'', $data[0]->subscription_name);
            $sheet->getStyle('A'.$row_new)->getFont()->setBold(true)->setUnderline(true);


            $acceptInquiry = count($data);
            $totalInquiry = $data[0]->subscription_no_of_inquiry_package;
            $pendingInquiry = $totalInquiry - $acceptInquiry;
            $amountSpend = $data[0]->subscription_price_package / $data[0]->subscription_no_of_inquiry_package * count($data);

            $userwallet = DB::table('users')->where('id',$data[0]->vendor_id)->value('wallet_amount');  

            $sheet->setCellValue('A'.$row_new + 1  .'', 'Package Price');
            $sheet->setCellValue('B'.$row_new + 1  .'', ''.$data[0]->subscription_price_package.'');

            $sheet->setCellValue('A'.$row_new + 2  .'', 'Total Inquiry');
            $sheet->setCellValue('B'.$row_new + 2  .'', ''.$totalInquiry.'');

            $sheet->setCellValue('A'.$row_new + 3  .'', 'Accepted Inquiry');
            $sheet->setCellValue('B'.$row_new + 3  .'', ''.$acceptInquiry.'');

            $sheet->setCellValue('A'.$row_new + 4  .'', 'Pending Inquiry');
            $sheet->setCellValue('B'.$row_new + 4  .'', ''.$pendingInquiry.'');

            $sheet->setCellValue('A'.$row_new + 5  .'', 'Amount Spend');
            $sheet->setCellValue('B'.$row_new + 5  .'', ''.$amountSpend.'');

            $sheet->setCellValue('A'.$row_new + 6  .'', 'Current Wallet Amount');
            $sheet->setCellValue('B'.$row_new + 6  .'', ''.$userwallet.'');
        }else{

            $sheet->setCellValue('A'.$row_new.'', $data[0]->subscription_name);
            $sheet->getStyle('A'.$row_new)->getFont()->setBold(true)->setUnderline(true);

            $sheet->getStyle('A'.($row_new))->applyFromArray($styleArray2);
            $sheet->getStyle('A'.($row_new + 1))->applyFromArray($styleArray2);
            $sheet->getStyle('A'.($row_new + 2))->applyFromArray($styleArray2);
            $sheet->getStyle('A'.($row_new + 3))->applyFromArray($styleArray2);

            
            $sheet->getStyle('B'.($row_new))->applyFromArray($styleArray2);
            $sheet->getStyle('B'.($row_new + 1))->applyFromArray($styleArray2);
            $sheet->getStyle('B'.($row_new + 2))->applyFromArray($styleArray2);
            $sheet->getStyle('B'.($row_new + 3))->applyFromArray($styleArray2);

            $userwallet = DB::table('users')->where('id',$data[0]->vendor_id)->value('wallet_amount');  

            $acceptInquiry = count($data);

            $amountSpend = 0;
            foreach($data as $package_accept_inquirydata){

                $amountSpend += $package_accept_inquirydata->price_of_lead;
            }

            $sheet->setCellValue('A'.$row_new + 1  .'', 'Accepted Inquiry');
            $sheet->setCellValue('B'.$row_new + 1  .'', ''.$acceptInquiry.'');

            $sheet->setCellValue('A'.$row_new + 2  .'', 'Amount Spend');
            $sheet->setCellValue('B'.$row_new + 2  .'', ''.$amountSpend.'');

            $sheet->setCellValue('A'.$row_new + 3  .'', 'Current Wallet Amount');
            $sheet->setCellValue('B'.$row_new + 3  .'', ''.$userwallet.'');

        }

        

        

        $sheet->setCellValue('A9', 'Vendor Name');
        $sheet->setCellValue('B9', 'Inquiry Id');
        $sheet->setCellValue('C9', 'Accepted Date');
        $sheet->setCellValue('D9', 'Name');
        $sheet->setCellValue('E9', 'Service');
        $sheet->setCellValue('F9', 'Sub Service');
        $sheet->setCellValue('G9', 'Lead Amount');

        $row =10;

        if(isset($data)){
            foreach ($data as $data_new) {


                $date = date('d-m-Y', strtotime($data_new->added_date));
                $service_name = \Helper::servicename(strval($data_new->service_id));
                $subservice_name = \Helper::subservicename(strval($data_new->subservice_id));
                $vendor_id = \Helper::vendorsname(strval($data_new->vendor_id)); 

                if (isset($data_new->price_of_lead) && !empty($data_new->price_of_lead)) {
                    $price_of_lead = $data_new->price_of_lead;
                } else {
                    $price_of_lead = ($data_new->subscription_no_of_inquiry_package > 0) 
                        ? ($data_new->subscription_price_package / $data_new->subscription_no_of_inquiry_package) 
                        : 0; // Avoid division by zero
                }

                $sheet->setCellValue('A' . $row, $vendor_id);
                $sheet->setCellValue('B' . $row, $data_new->inq_idformat);
                $sheet->setCellValue('C' . $row, $date);
                $sheet->setCellValue('D' . $row, $data_new->inq_name);
                $sheet->setCellValue('E' . $row, $service_name);
                $sheet->setCellValue('F' . $row, $subservice_name);
                $sheet->setCellValue('G' . $row, $price_of_lead);
                

                $row++;
            }
        }

        $writer = new Xlsx($spreadsheet);

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Vendor-Subscription-Report.xlsx"');
        header('Cache-Control: max-age=0');

        // Write the file to the browser
        $writer->save('php://output');

                    echo "<pre>";print_r($data);echo"</pre>";exit;
    }

    function subscription_change(){
        $vendorid = $_POST['vendorid'];
        // echo $service_id;exit;
        
        $result = DB::table('subscription')->select('*')->where('vendor_id','=',$vendorid)->where('is_deleted' , '=' ,'0')->orderBy('id','DESC')->get();        

        $result_new = $result->toArray();

        $html = ' <select class="form-control" id="vendorsubscription" name="vendorsubscription">';
        $html .= '<option value="">Select Select Subscription</option>';
        if($result != '' && count($result) >0)
        {
            for($i=0;$i<count($result);$i++)
            {
                // echo "<pre>";print_r($result[$i]->id);echo "</pre>";exit;
                $html .= "<option value='".$result[$i]->id ."'>".$result[$i]->subscription_name." - ".$result[$i]->id."</option>";
            }
        }
        $html .="</select>";
        // echo "<pre>";print_r($html);echo "</pre>";exit;
        echo $html;
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
    public function destroy($id)
    {
        //
    }
}
