<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use DatePeriod;
use DateTime;
use DateInterval;
use App\Helpers\Helper;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Salespersonreportcontroller extends Controller

{
    public function index(Request $request)
    {
        $data['error'] = "";

        $startdate = $request->s_date;
        $enddate = $request->e_date;
        $salesperson_id = $request->salesperson_id;
        $service_id = $request->service_id;
        $subservice_id = $request->subservice_id;
        $user_data = Auth::user();

        $query = DB::table('ci_order_item')
            ->join('ci_orders', 'ci_orders.order_id', '=', 'ci_order_item.order_id')
            ->where('ci_orders.order_status', 'CO')
            ->where('ci_orders.is_delete', '0');

        // ❌ REMOVE old date filter (IMPORTANT)
        // because now we filter on visit_date, not cdate

        if (!empty($service_id)) {
            $query->where("ci_order_item.service_id", $service_id);
        }
        if (!empty($subservice_id)) {
            $query->where("ci_order_item.subservice_id", $subservice_id);
        }
        if (!empty($salesperson_id)) {
            $query->where("salesperson_id", $salesperson_id);
        }

        if ($user_data->role_id == 11) {
            $query->where('salesperson_id', $user_data->id);
        }

        $orders = !empty($salesperson_id)
            ? $query->orderBy('ci_order_item.id', 'DESC')->get()
            : collect();

        // ✅ FINAL VISIT BASED DATA
        $final_data = [];

        // echo "<pre>";
        // print_r($orders);
        // exit;

        foreach ($orders as $item) {

            // 👉 Create start date
            $start_date = date('Y-m-d', strtotime(
                $item->bookingdate . ' ' . $item->month . ' ' . $item->bookingyear
            ));

            $days = $item->which_day_of_the_week_do_you_want_the_service;
            $end  = $item->end_date;

            $visit_dates = [];

            // ✅ ONE TIME (villa / deep cleaning)
            if (empty($days)) {

                $visit_dates[] = $start_date;
            } else {

                $selected_days = array_map('trim', explode(',', $days));

                // if end_date missing → treat as one-time
                if (empty($end)) {

                    $visit_dates[] = $start_date;
                } else {

                    $period = new DatePeriod(
                        new DateTime($start_date),
                        new DateInterval('P1D'),
                        new DateTime($end . ' +1 day')
                    );

                    foreach ($period as $date) {
                        if (in_array($date->format('l'), $selected_days)) {
                            $visit_dates[] = $date->format('Y-m-d');
                        }
                    }
                }
            }

            // ✅ MAKE ROW PER VISIT
            foreach ($visit_dates as $vdate) {

                // ✅ APPLY FILTER HERE (IMPORTANT 🔥)
                if (!empty($startdate) && $vdate < date('Y-m-d', strtotime($startdate))) continue;
                if (!empty($enddate) && $vdate > date('Y-m-d', strtotime($enddate))) continue;

                $row = clone $item;

                $row->visit_date = $vdate;
                $row->visit_day  = date('l', strtotime($vdate));

                $final_data[] = $row;
            }
        }

        // ✅ SORT BY VISIT DATE
        usort($final_data, function ($a, $b) {
            return strtotime($a->visit_date) - strtotime($b->visit_date);
        });

        $data['salesperson_order_data'] = $final_data;

        // salesperson dropdown
        $data['salesperson'] = DB::table('users')
            ->whereIn('role_id', [11, 12])
            ->where('is_active', '0')
            ->get();

        $data['service_data'] = DB::table('services')->where('is_active', '0')->get();
        $data['subservice_data'] = DB::table('subservices')->where('is_active', '0')->orderBy('id', 'DESC')->get();

        $data['startdate'] = $startdate;
        $data['enddate'] = $enddate;
        $data['filter_salesperson_id'] = $salesperson_id;
        $data['filter_service_id'] = $service_id;
        $data['filter_subservice_id'] = $subservice_id;

        // echo "<pre>";
        // print_r($data['salesperson_order_data']);
        // exit;

        return view('admin.salesperson.list', $data);
    }

    function filter_data_salesperson(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // exit;

        $startdate = $request->startdate_fil;
        $enddate = $request->enddate_fil;
        $salesperson_id = $request->filter_salesperson_id;
        $service_id = $request->service_id;
        $subservice_id = $request->subservice_id;
        $user_data = Auth::user();

        $query = DB::table('ci_order_item')
            ->join('ci_orders', 'ci_orders.order_id', '=', 'ci_order_item.order_id')
            ->where('ci_orders.order_status', 'CO')
            ->where('ci_orders.is_delete', '0');

        // ❌ REMOVE old date filter (IMPORTANT)
        // because now we filter on visit_date, not cdate

        if (!empty($service_id)) {
            $query->where("ci_order_item.service_id", $service_id);
        }
        if (!empty($subservice_id)) {
            $query->where("ci_order_item.subservice_id", $subservice_id);
        }
        if (!empty($salesperson_id)) {
            $query->where("salesperson_id", $salesperson_id);
        }

        if ($user_data->role_id == 11) {
            $query->where('salesperson_id', $user_data->id);
        }

        $orders = !empty($salesperson_id)
            ? $query->orderBy('ci_order_item.id', 'DESC')->get()
            : collect();

        // ✅ FINAL VISIT BASED DATA
        $final_data = [];

        foreach ($orders as $item) {

            // 👉 Create start date
            $start_date = date('Y-m-d', strtotime(
                $item->bookingdate . ' ' . $item->month . ' ' . $item->bookingyear
            ));

            $days = $item->which_day_of_the_week_do_you_want_the_service;
            $end  = $item->end_date;

            $visit_dates = [];

            // ✅ ONE TIME (villa / deep cleaning)
            if (empty($days)) {

                $visit_dates[] = $start_date;
            } else {

                $selected_days = array_map('trim', explode(',', $days));

                // if end_date missing → treat as one-time
                if (empty($end)) {

                    $visit_dates[] = $start_date;
                } else {

                    $period = new DatePeriod(
                        new DateTime($start_date),
                        new DateInterval('P1D'),
                        new DateTime($end . ' +1 day')
                    );

                    foreach ($period as $date) {
                        if (in_array($date->format('l'), $selected_days)) {
                            $visit_dates[] = $date->format('Y-m-d');
                        }
                    }
                }
            }

            // ✅ MAKE ROW PER VISIT
            foreach ($visit_dates as $vdate) {

                // ✅ APPLY FILTER HERE (IMPORTANT 🔥)
                if (!empty($startdate) && $vdate < date('Y-m-d', strtotime($startdate))) continue;
                if (!empty($enddate) && $vdate > date('Y-m-d', strtotime($enddate))) continue;

                $row = clone $item;

                $row->visit_date = $vdate;
                $row->visit_day  = date('l', strtotime($vdate));

                $final_data[] = $row;
            }
        }

        // ✅ SORT BY VISIT DATE
        usort($final_data, function ($a, $b) {
            return strtotime($a->visit_date) - strtotime($b->visit_date);
        });

        $service_wise_sales = [];
        $total_invoice_amt = 0;
        $total_service_charge = 0;
        $total_vendor_charges = 0;
        $total_vat = 0;

        foreach ($final_data as $row) {
            $sName = Helper::servicename($row->service_id);
            if (!isset($service_wise_sales[$sName])) {
                $service_wise_sales[$sName] = [
                    'invoice_amount' => 0,
                    'profit' => 0,
                    'jobs' => 0
                ];
            }
            $service_wise_sales[$sName]['invoice_amount'] += $row->order_total;
            $service_wise_sales[$sName]['jobs'] += 1;

            $total_invoice_amt += $row->order_total;
            $total_service_charge += $row->service_charge;
            $total_vat += $row->vatcharge;

            // Vendor Charge Logic
            $order_vendor_payout = 0;
            if ($row->vendor_id != 0 && $row->subservice_booking_percentage > 0) {
                $commission = ($row->sub_total * $row->subservice_booking_percentage) / 100;
                $order_vendor_payout = $row->sub_total - $commission;
                $total_vendor_charges += $order_vendor_payout;
            }
                    $order_profit = $row->service_charge - $order_vendor_payout;
            $service_wise_sales[$sName]['profit'] += $order_profit;
        }

        // Profit calculation
        $total_profit = $total_service_charge - $total_vendor_charges;

        // ✅ 2. DRAW THE SUMMARY TABLES IN EXCEL
        $row_num = 1;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 1st Table: Sales Report Summary
        $sheet->mergeCells("A{$row_num}:B{$row_num}");
        $sheet->setCellValue("A{$row_num}", 'Sales Report Summary');
        $sheet->getStyle("A{$row_num}")->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle("A{$row_num}:B{$row_num}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFD312'); // Yellow
        $sheet->getStyle("A{$row_num}")->getAlignment()->setHorizontal('center');
        
        $row_num++;
        
        $sheet->setCellValue("A{$row_num}", "Charges");
        $sheet->setCellValue("B{$row_num}", "Total (AED)");
        $sheet->getStyle("A{$row_num}:B{$row_num}")->getFont()->setBold(true);
        $row_num++;
        
        $sheet->setCellValue("A{$row_num}", "Invoice Amount");
        $sheet->setCellValue("B{$row_num}", number_format($total_invoice_amt, 2));
        $row_num++;
        $sheet->setCellValue("A{$row_num}", "Service Charge");
        $sheet->setCellValue("B{$row_num}", number_format($total_service_charge, 2));
        $row_num++;
        $sheet->setCellValue("A{$row_num}", "Agent Commission");
        $sheet->setCellValue("B{$row_num}", "0.00");
        $row_num++;
        $sheet->setCellValue("A{$row_num}", "Vendor Charges");
        $sheet->setCellValue("B{$row_num}", number_format($total_vendor_charges, 2));
        $row_num++;
        $sheet->setCellValue("A{$row_num}", "Other Expenses");
        $sheet->setCellValue("B{$row_num}", "0.00");
        $row_num++;
        $sheet->setCellValue("A{$row_num}", "Vat");
        $sheet->setCellValue("B{$row_num}", number_format($total_vat, 2));
        $row_num++;
        $sheet->setCellValue("A{$row_num}", "Total Profit");
        $sheet->setCellValue("B{$row_num}", number_format($total_profit, 2));
        $sheet->getStyle("A{$row_num}:B{$row_num}")->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle("A{$row_num}:B{$row_num}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0040E6'); // Blue
        
        $row_num += 2; // Leave a blank row

        // 2nd Table: Service wise Sales
        $sheet->mergeCells("A{$row_num}:E{$row_num}");
        $sheet->setCellValue("A{$row_num}", 'Service wise Sales');
        $sheet->getStyle("A{$row_num}")->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle("A{$row_num}:E{$row_num}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFD312'); // Yellow
        $sheet->getStyle("A{$row_num}")->getAlignment()->setHorizontal('center');
        
        $row_num++;

        $sheet->setCellValue("A{$row_num}", 'Services');
        $sheet->setCellValue("B{$row_num}", 'Invoice Amount');
        $sheet->setCellValue("C{$row_num}", 'Profit');
        $sheet->setCellValue("D{$row_num}", 'Percentage %');
        $sheet->setCellValue("E{$row_num}", 'No. of Jobs');
        $sheet->getStyle("A{$row_num}:E{$row_num}")->getFont()->setBold(true);
        $row_num++;

        foreach ($service_wise_sales as $name => $data) {
            $percentage = 0;
            if($data['invoice_amount'] > 0){
                $percentage = ($data['profit'] / $data['invoice_amount']) * 100;
            }
            $sheet->setCellValue("A{$row_num}", $name);
            $sheet->setCellValue("B{$row_num}", number_format($data['invoice_amount'], 2));
            $sheet->setCellValue("C{$row_num}", number_format($data['profit'], 2));
            $sheet->setCellValue("D{$row_num}", number_format($percentage, 2) . '%');
            $sheet->setCellValue("E{$row_num}", $data['jobs']);
            $row_num++;
        }

        $total_percentage = 0;
        if($total_invoice_amt > 0){
            $total_percentage = ($total_profit / $total_invoice_amt) * 100;
        }

        $sheet->setCellValue("A{$row_num}", "Total Sales");
        $sheet->setCellValue("B{$row_num}", number_format($total_invoice_amt, 2));
        $sheet->setCellValue("C{$row_num}", number_format($total_profit, 2));
        $sheet->setCellValue("D{$row_num}", number_format($total_percentage, 2) . '%');
        $sheet->setCellValue("E{$row_num}", count($final_data));
        
        $sheet->getStyle("A{$row_num}:E{$row_num}")->getFont()->setBold(true);
        $sheet->getStyle("A{$row_num}:E{$row_num}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFD312');

        $row_num += 2; // Leave a blank row
        
        // ✅ 3. START ORDER LISTING BELOW SUMMARY
        // Table Header for Orders
        $order_headers = ['Booking Date', 'Service Type', 'Order Id', 'Sales Person', 'Customer', 'Vendor', 'Vendor Charge', 'Profit'];
        $column = 'A';
        foreach ($order_headers as $h) {
            $sheet->setCellValue($column . $row_num, $h);
            $column++;
        }
        $sheet->getStyle("A{$row_num}:H{$row_num}")->getFont()->setBold(true);

        $row_num++;

        // Fill Order Data
        foreach ($final_data as $order) {
            $v_payout = 0;
            if ($order->vendor_id != 0 && $order->subservice_booking_percentage > 0) {
                $comm = ($order->sub_total * $order->subservice_booking_percentage) / 100;
                $v_payout = ($order->sub_total - $comm);
            }

            $sheet->setCellValue("A{$row_num}", $order->visit_date);
            $sheet->setCellValue("B{$row_num}", Helper::servicename($order->service_id));
            $sheet->setCellValue("C{$row_num}", $order->format_order_id);
            $sheet->setCellValue("D{$row_num}", Helper::salesperson($order->salesperson_id));
            $sheet->setCellValue("E{$row_num}", $order->name ?? 'N/A');
            $sheet->setCellValue("F{$row_num}", ($order->vendor_id != 0) ? Helper::vendorsname($order->vendor_id) : '-');
            $sheet->setCellValue("G{$row_num}", number_format($v_payout, 2));
            $sheet->setCellValue("H{$row_num}", number_format($order->service_charge - $v_payout, 2));
            $row_num++;
        }

        $writer = new Xlsx($spreadsheet);

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="SalespersonReport.xlsx"');
        header('Cache-Control: max-age=0');

        // Write the file to the browser
        $writer->save('php://output');
        exit;
    }
}
