<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Helpers\Helper;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Auth;

class DayReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $userId = Auth::user();

    //    echo"<pre>";print_r($userId);echo"</pre>";exit;

        $startdate = $request->s_date;
        $enddate = $request->e_date;
        $service_name = $request->servicename;
        $salesperson_id = $request->salesperson_id;
        
        // echo $service_name;exit;
        $data['error'] = '';
        
        $query = DB::table('ci_orders')->where('ci_orders.is_delete','0')
        ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
        ->select(
            'frontloginregisters.email as user_email',
            'frontloginregisters.name as user_name',
            'frontloginregisters.mobile as user_mobile',
            'ci_orders.*'
        )
        ->whereExists(function ($subQuery) use ($salesperson_id, $service_name, $startdate, $enddate, $userId) {

            $subQuery->select(DB::raw(1))
                ->from('ci_order_item')
                ->whereColumn('ci_order_item.order_id', 'ci_orders.order_id');
    
            if (!empty($service_name)) {
                $subQuery->where('ci_order_item.service_id', $service_name);
            }
            if ($userId->role_id == 11) {
                $subQuery->where('ci_order_item.salesperson_id', $userId->id);
            } elseif (!empty($salesperson_id)) {
                $subQuery->where('ci_order_item.salesperson_id', $salesperson_id);
            }
            if (!empty($startdate)) {
                $subQuery->whereDate('ci_order_item.cdate', '>=', date('Y-m-d', strtotime($startdate)));
            }
            if (!empty($enddate)) {
                $subQuery->whereDate('ci_order_item.cdate', '<=', date('Y-m-d', strtotime($enddate)));
            }
            if($userId->role_id == 15){
                $subQuery->where('ci_order_item.driver_id', $userId->id);
            }
            if($userId->role_id == 16){
                $subQuery->whereRaw("FIND_IN_SET(?, ci_order_item.cleaner_id)", [$userId->id]);
            }
        });
    
    if (!empty($order_id)) {
        $query->where('ci_orders.order_id', $order_id);
    }

    if($userId->vendor == 1){
            $query->where('ci_orders.vendor_id', $userId->id);
    }

 
    
    if (!empty($status)) {
        if ($status == 'SUCCESS' || $status == 'FAILED') {
            $query->where('ci_orders.payment_status', $status);
        } else {
            $query->where('ci_orders.order_status', $status);
        }
    }
    
    $query->orderBy('ci_orders.order_id', 'DESC');
    $orderList = $query->get();
    
    // Attach items and subtotal
    foreach ($orderList as $order) {
        $itemList = DB::table('ci_order_item')
            ->where('order_id', $order->order_id)
            ->get();

        $order->items = $itemList;
    }
    
        
        $data['orders_list'] = $orderList;
        $data['startdate'] =$startdate;
        $data['enddate'] =$enddate;
        $data['filter_service_id'] =$service_name;
        $data['filter_salesperson_id'] =$salesperson_id;

      $data['service_data'] = DB::table('services')->where('is_active','0')->get();

      $data['user_data'] = DB::table('users')->where('role_id',11)->get();

        return view('admin.list_day_report',$data);
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

    public function filter_day_report_data(Request $request){
    
        $userId = Auth::user();

        $startdate = $request->input('startdate_fil','');
        $enddate =  $request->input('enddate_fil','');
        $service_name = $request->input('filter_service_id_fil','');
        $salesperson_id = $request->input('filter_salesperson_id_fil','');

        // echo"<pre>";print_r($request->all());echo"</pre>";exit;
        $data['error'] = '';
        
        $query = DB::table('ci_orders')->where('ci_orders.is_delete','0')
        ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
        ->select(
            'frontloginregisters.email as user_email',
            'frontloginregisters.name as user_name',
            'frontloginregisters.mobile as user_mobile',
            'ci_orders.*'
        )
         ->whereExists(function ($subQuery) use ($salesperson_id, $service_name, $startdate, $enddate, $userId) {
            $subQuery->select(DB::raw(1))
                ->from('ci_order_item')
                ->whereColumn('ci_order_item.order_id', 'ci_orders.order_id');
    
            if (!empty($service_name)) {
                $subQuery->where('ci_order_item.service_id', $service_name);
            }
            if ($userId->role_id == 11) {
                $subQuery->where('ci_order_item.salesperson_id', $userId->id);
            } elseif (!empty($salesperson_id)) {
                $subQuery->where('ci_order_item.salesperson_id', $salesperson_id);
            }
            if (!empty($startdate)) {
                $subQuery->whereDate('ci_order_item.cdate', '>=', date('Y-m-d', strtotime($startdate)));
            }
            if (!empty($enddate)) {
                $subQuery->whereDate('ci_order_item.cdate', '<=', date('Y-m-d', strtotime($enddate)));
            }
             if($userId->role_id == 15){
                $subQuery->where('ci_order_item.driver_id', $userId->id);
            }
            if($userId->role_id == 16){
                $subQuery->whereRaw("FIND_IN_SET(?, ci_order_item.cleaner_id)", [$userId->id]);
            }
        });
    
    if (!empty($order_id)) {
        $query->where('ci_orders.order_id', $order_id);
    }
     if($userId->vendor == 1){
            $query->where('ci_orders.vendor_id', $userId->id);
    }
    if (!empty($status)) {
        if ($status == 'SUCCESS' || $status == 'FAILED') {
            $query->where('ci_orders.payment_status', $status);
        } else {
            $query->where('ci_orders.order_status', $status);
        }
    }
    
    $query->orderBy('ci_orders.order_id', 'DESC');
    
    $orderList = $query->get();
    
    // Attach items and subtotal
    foreach ($orderList as $order) {
        $itemList = DB::table('ci_order_item')
            ->where('order_id', $order->order_id)
            ->get();

        $order->items = $itemList;
    }
    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $download_date = date('Y-m-d');
     
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

        $sheet->getStyle('A'.($row_new + 1))->applyFromArray($styleArray2);
        $sheet->getStyle('A'.($row_new + 2))->applyFromArray($styleArray2);
        $sheet->getStyle('A'.($row_new + 3))->applyFromArray($styleArray2);
        $sheet->getStyle('A'.($row_new + 4))->applyFromArray($styleArray2);
        $sheet->getStyle('A'.($row_new + 5))->applyFromArray($styleArray2);
        $sheet->getStyle('A'.($row_new + 6))->applyFromArray($styleArray2);
        $sheet->getStyle('A'.($row_new + 7))->applyFromArray($styleArray2);

        $sheet->getStyle('B'.($row_new + 1))->applyFromArray($styleArray1);
        $sheet->getStyle('B'.($row_new + 2))->applyFromArray($styleArray1);
        $sheet->getStyle('B'.($row_new + 3))->applyFromArray($styleArray1);
        $sheet->getStyle('B'.($row_new + 4))->applyFromArray($styleArray1);
        $sheet->getStyle('B'.($row_new + 5))->applyFromArray($styleArray1);
        $sheet->getStyle('B'.($row_new + 6))->applyFromArray($styleArray1);
        $sheet->getStyle('B'.($row_new + 7))->applyFromArray($styleArray1);

        $sheet->setCellValue('A'.$row_new.'', 'Day Report');
        $sheet->getStyle('A'.$row_new)->getFont()->setBold(true)->setUnderline(true);

        
        $sheet->setCellValue('A'.($row_new + 1), 'Service Name');
        $sheet->getStyle('B'.($row_new + 1))->getFont()->setBold(true);
        $sheet->setCellValue('B'.($row_new + 1), Helper::servicename($service_name));

        // echo"<pre>";print_r($userId);echo"</pre>";exit;
        if($userId->vendor == 1){

        $sheet->setCellValue('A'.($row_new + 2), 'Vendor Name');
        $sheet->getStyle('B'.($row_new + 2))->getFont()->setBold(true);
        $sheet->setCellValue('B'.($row_new + 2), Helper::vendorsname($userId->id));  

        }elseif($userId->role_id == 11){

        $sheet->setCellValue('A'.($row_new + 2), 'Salesperson Name');
        $sheet->getStyle('B'.($row_new + 2))->getFont()->setBold(true);
        $sheet->setCellValue('B'.($row_new + 2), Helper::salesperson($userId->id));
        }elseif($userId->role_id == 15){

        $sheet->setCellValue('A'.($row_new + 2), 'Driver Name');
        $sheet->getStyle('B'.($row_new + 2))->getFont()->setBold(true);
        $sheet->setCellValue('B'.($row_new + 2), Helper::drivername($userId->id));
        }elseif($userId->role_id == 16){

        $sheet->setCellValue('A'.($row_new + 2), 'Crew Name');
        $sheet->getStyle('B'.($row_new + 2))->getFont()->setBold(true);
        $sheet->setCellValue('B'.($row_new + 2), Helper::cleanername_new($userId->id));
        }else{
        $sheet->setCellValue('A'.($row_new + 2), 'Salesperson Name');
        $sheet->getStyle('B'.($row_new + 2))->getFont()->setBold(true);
        $sheet->setCellValue('B'.($row_new + 2), Helper::salesperson($salesperson_id));
        }

        $sheet->setCellValue('A'.($row_new + 3), 'Report Download Date');
        $sheet->setCellValue('B'.($row_new + 3), $download_date);

        $sheet->setCellValue('A'.($row_new + 4), 'Start Date');
        $sheet->setCellValue('B'.($row_new + 4), $startdate ?: '-');

        $sheet->setCellValue('A'.($row_new + 5), 'End Date');
        $sheet->setCellValue('B'.($row_new + 5), $enddate ?: '-');


        $sheet->setCellValue('A9', 'Order Id');
        $sheet->setCellValue('B9', 'Order Date');
        $sheet->setCellValue('C9', 'Service Name');
        $sheet->setCellValue('D9', 'Vendor Name');
        $sheet->setCellValue('E9', 'Crew Name');
        $sheet->setCellValue('F9', 'Salesperson Name');
        $sheet->setCellValue('G9', 'User Name');
        $sheet->setCellValue('H9', 'User Email');
        $sheet->setCellValue('I9', 'User Mobile');
        $sheet->setCellValue('J9', 'User Address');
        $sheet->setCellValue('K9', 'Time Slot');
        $sheet->setCellValue('L9', 'Order Amount');
        $sheet->setCellValue('M9', 'Order Status');
        $sheet->setCellValue('N9', 'Payment Mode');
        $sheet->setCellValue('O9', 'Payment Id');

        $row= 10;

        if(isset($orderList) && !empty($orderList)){

            foreach($orderList as $key => $orders){

            $order_date = strtotime( $orders->created_at);
            $order_date_format = date( 'F d, Y', $order_date);

            $address = $orders->items[0]->building_street_no .','.$orders->items[0]->apartment_villa_no.','.$orders->items[0]->area.','.$orders->items[0]->city;
           
            $cleaner_Id = explode(",",$orders->items[0]->cleaner_id);

            if ($orders->format_order_id !== null) {
                $sheet->setCellValue('A' . $row, $orders->format_order_id);
            } else {
               $sheet->setCellValue('A' . $row, '-'); 
            }

            if ($order_date_format !== null) {
                $sheet->setCellValue('B' . $row, $order_date_format);
            } else {
               $sheet->setCellValue('B' . $row, '-'); 
            }

            if ($orders->items[0]->service_id !== null) {
                $sheet->setCellValue('C' . $row, Helper::servicename($orders->items[0]->service_id));
            } else {
               $sheet->setCellValue('C' . $row, '-'); 
            }
            
            if ($orders->vendor_id !== null) {
                $sheet->setCellValue('D' . $row, Helper::vendorsname($orders->vendor_id));
            } else {
               $sheet->setCellValue('D' . $row, '-'); 
            }

            if (isset($cleaner_Id) && count($cleaner_Id) > 0) {
                $sheet->setCellValue('E' . $row, Helper::cleanername_new($cleaner_Id));
            } else {
               $sheet->setCellValue('E' . $row, '-'); 
            }

            if ($orders->items[0]->salesperson_id !== null) {
                $sheet->setCellValue('F' . $row, Helper::salesperson($orders->items[0]->salesperson_id));
            } else {
               $sheet->setCellValue('F' . $row, '-'); 
            }

            if ($orders->user_name !== null) {
                $sheet->setCellValue('G' . $row, $orders->user_name);
            } else {
               $sheet->setCellValue('G' . $row, '-'); 
            }

            if ($orders->user_email !== null) {
                $sheet->setCellValue('H' . $row, $orders->user_email);
            } else {
               $sheet->setCellValue('H' . $row, '-'); 
            }

            if ($orders->user_mobile !== null) {
                $sheet->setCellValue('I' . $row, $orders->user_mobile);
            } else {
               $sheet->setCellValue('I' . $row, '-'); 
            }

            if ($address !== null) {
                $sheet->setCellValue('J' . $row, $address);
            } else {
               $sheet->setCellValue('J' . $row, '-'); 
            }

            if ($orders->items[0]->time_slot !== null) {
                $sheet->setCellValue('K' . $row, Helper::timeslotname($orders->items[0]->time_slot));
            } else {
               $sheet->setCellValue('K' . $row, '-'); 
            }

            if ($orders->order_total !== null) {
                $sheet->setCellValue('L' . $row,$orders->order_total);
            } else {
               $sheet->setCellValue('L' . $row, '-'); 
            }
         
            if($orders->order_status === "CO") {
                $order_status = "Completed";
            }elseif($orders->order_status === "P") {
                $order_status = "Pending";
            }else{
                $order_status = "Cancelled";
            }
            

            if (!empty($order_status)) {
                $sheet->setCellValue('M' . $row, $order_status);
            } else {
                $sheet->setCellValue('M' . $row, '-');
            }

            if($orders->paymentmode == '1'){
                $paymentmode = "Cash On Delivery";
            }else{
                $paymentmode = "Online Payment";
            }

            if (!empty($orders->paymentmode)) {
                $sheet->setCellValue('N' . $row, $paymentmode);
            } else {
                $sheet->setCellValue('N' . $row, '-');
            }

            if (!empty($orders->payment_id)) {
                $sheet->setCellValue('O' . $row, $orders->payment_id);
            } else {
                $sheet->setCellValue('O' . $row, '-');
            }


            $row++;

            }

        }



        $writer = new Xlsx($spreadsheet);

        while (ob_get_level() > 0) {
            ob_end_clean(); // Clean all active output buffers
        }
        ob_start();
        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="DayReport.xlsx"');
        header('Cache-Control: max-age=0');

        // Write the file to the browser
        $writer->save('php://output');
        exit;
    }
}