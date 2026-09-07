<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CleanerReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $startdate = $request->s_date;
        // $enddate = $request->e_date;
        // $cleaner_name = $request->cleaner_name;

        // $user_data = Auth::user();

        // // echo"<pre>";print_r($user_data->role_id);echo"</pre>";exit;

        // $query = DB::table('ci_order_item')
        //     ->join('ci_orders', 'ci_orders.order_id', '=', 'ci_order_item.order_id')
        //     ->where('ci_orders.is_delete', '0');

        // if (!empty($startdate)) {
        //     $query->where('cdate', '>=', date('Y-m-d', strtotime($startdate)));
        // }

        // if (!empty($enddate)) {
        //     $query->where('cdate', '<=', date('Y-m-d', strtotime($enddate)));
        // }

        // if (!empty($cleaner_name)) {
        //     $query->whereRaw("FIND_IN_SET(?, cleaner_id)", [$cleaner_name]);
        // }


        // if ($user_data->role_id == 11) {

        //     $query->where('salesperson_id', $user_data->id);
        // }
        // $data['cleaner_order_data'] = $query->OrderBy('id', 'DESC')->get();

        // $data['cleaner_data'] = DB::table('users')->where('role_id', '=', '16')->orderBy('id', 'DESC')->get();

        // // echo"<pre>";print_r($data['cleaner_order_data']);echo"</pre>";exit;

        // $data['startdate'] = $startdate;
        // $data['enddate'] = $enddate;
        // $data['filter_cleaner_id'] = $cleaner_name;

        $startdate     = $request->s_date;
        $enddate       = $request->e_date;
        $cleaner_name  = $request->cleaner_name;

        $user_data = Auth::user();

        // Base Query (NO date filter here)
        $query = DB::table('ci_order_item')
            ->join('ci_orders', 'ci_orders.order_id', '=', 'ci_order_item.order_id')
            ->where('ci_orders.is_delete', '0');

        // Cleaner filter
        if (!empty($cleaner_name)) {
            $query->whereRaw("FIND_IN_SET(?, ci_order_item.cleaner_id)", [$cleaner_name]);
        }

        // Salesperson filter
        if ($user_data->role_id == 11) {
            $query->where('ci_order_item.salesperson_id', $user_data->id);
        }

        // Get orders
        $orders = $query->orderBy('ci_order_item.id', 'DESC')->get();

        // Convert filter dates
        $filterStart = !empty($startdate) ? date('Y-m-d', strtotime($startdate)) : null;
        $filterEnd   = !empty($enddate) ? date('Y-m-d', strtotime($enddate)) : null;

        $final_data = [];

        // Pre-fetch all explicit visit assignments
        $all_order_ids = $orders->pluck('order_id')->toArray();
        $visit_overrides = [];
        if (\Illuminate\Support\Facades\Schema::hasTable('ci_order_visits')) {
            $overrides = DB::table('ci_order_visits')
                ->whereIn('order_id', $all_order_ids)
                ->whereNotNull('cleaner_id')
                ->get();
            foreach ($overrides as $ov) {
                $visit_overrides[$ov->order_id][$ov->visit_date] = $ov->cleaner_id;
            }
        }

        foreach ($orders as $order) {

            // Build start date
            $start = date('Y-m-d', strtotime($order->bookingdate . '-' . $order->month . '-' . $order->bookingyear));
            $end   = $order->end_date;

            // Days array
            $days = [];

            if (!empty($order->which_day_of_the_week_do_you_want_the_service)) {
                $days = array_map('trim', explode(',', strtolower($order->which_day_of_the_week_do_you_want_the_service)));
            }

            $order_default_cleaners = explode(',', $order->cleaner_id ?? '');

            // ✅ CASE 1: Once / Deep Cleaning
            if (empty($days)) {

                $visitDate = $start;
                $active_cleaner = isset($visit_overrides[$order->order_id][$visitDate]) ? $visit_overrides[$order->order_id][$visitDate] : (count($order_default_cleaners) > 0 ? $order_default_cleaners[0] : null);

                // Apply cleaner filter
                if (!empty($cleaner_name) && $active_cleaner != $cleaner_name) {
                    continue;
                }

                // Apply visit date filter
                if (
                    ($filterStart && $visitDate < $filterStart) ||
                    ($filterEnd && $visitDate > $filterEnd)
                ) {
                    continue;
                }

                $newRow = clone $order;
                $newRow->visit_date = $visitDate;
                $newRow->actual_cleaner_id = $active_cleaner;

                $final_data[] = $newRow;
            }

            // ✅ CASE 2: Weekly / Multiple Days
            else {

                $period = new \DatePeriod(
                    new \DateTime($start),
                    new \DateInterval('P1D'),
                    (new \DateTime($end))->modify('+1 day')
                );

                foreach ($period as $date) {

                    $dayName = strtolower($date->format('l'));

                    if (in_array($dayName, $days)) {

                        $visitDate = $date->format('Y-m-d');
                        $active_cleaner = isset($visit_overrides[$order->order_id][$visitDate]) ? $visit_overrides[$order->order_id][$visitDate] : (count($order_default_cleaners) > 0 ? $order_default_cleaners[0] : null);

                        // Apply cleaner filter
                        if (!empty($cleaner_name) && $active_cleaner != $cleaner_name) {
                            continue;
                        }

                        // Apply visit date filter
                        if (
                            ($filterStart && $visitDate < $filterStart) ||
                            ($filterEnd && $visitDate > $filterEnd)
                        ) {
                            continue;
                        }

                        $newRow = clone $order;
                        $newRow->visit_date = $visitDate;
                        $newRow->actual_cleaner_id = $active_cleaner;

                        $final_data[] = $newRow;
                    }
                }
            }
        }

        // Cleaner List
        $data['cleaner_data'] = DB::table('users')
            ->where('role_id', 16)
            ->orderBy('id', 'DESC')
            ->get();

        // Final Data
        $data['cleaner_order_data'] = $final_data;

        $data['startdate'] = $startdate;
        $data['enddate'] = $enddate;
        $data['filter_cleaner_id'] = $cleaner_name;

        // echo "<pre>";
        // print_r($data['cleaner_order_data']);
        // exit;

        return view('admin.list_cleaner_report', $data);
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

    public function filter_data_cleaner(Request $request)
    {

        // echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $user_data = Auth::user();

        $startdate = $request->input('startdate_fil', '');
        $enddate = $request->input('enddate_fil', '');
        $cleaner_name = $request->input('filter_cleaner_id_fil', '');

        $query = DB::table('ci_order_item');
        // ->join('ci_orders', 'ci_orders.order_id', '=', 'ci_order_item.order_id') // Join ci_orders table
        // ->where('ci_orders.order_status', 'CO'); 

        if (!empty($startdate)) {
            $query->where('cdate', '>=', date('Y-m-d', strtotime($startdate)));
        }

        if (!empty($enddate)) {
            $query->where('cdate', '<=', date('Y-m-d', strtotime($enddate)));
        }

        if (!empty($cleaner_name)) {
            $query->whereRaw("FIND_IN_SET(?, cleaner_id)", [$cleaner_name]);
        }
        if ($user_data->role_id == 11) {

            $query->where('salesperson_id', $user_data->id);
        }

        $total_amount = $query->sum('cleaner_price');

        $cleaner_order_data = $query->OrderBy('id', 'DESC')->get();

        // echo"<pre>";print_r($cleaner_order_data);echo"</pre>";exit;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $download_date = date('Y-m-d');

        $total_complete_order = 0;
        $pending_complete_order = 0;
        $total_cleaner_price = [];

        foreach ($cleaner_order_data as $data) {
            $ci_orders_data = DB::table('ci_orders')->where('order_id', $data->order_id)->first();


            if ($data->subservice_id == 28) {
                if ($ci_orders_data) {
                    $service_charge = $ci_orders_data->service_charge ?? 0;
                    $no_of_cleaners = $data->how_many_cleaners_do_you_need ?? 0;

                    $cleaner_price = ($no_of_cleaners > 0) ? ($service_charge / $no_of_cleaners) : 0;
                    $total_cleaner_price[] = $cleaner_price;
                }
            }

            $total_complete_order += DB::table('ci_orders')
                ->where('order_id', $data->order_id)
                ->where('order_status', 'CO')
                ->count();

            $pending_complete_order += DB::table('ci_orders')
                ->where('order_id', $data->order_id)
                ->where('order_status', 'P')
                ->count();
        }

        // Add the accumulated cleaner price to the total amount
        $final_total = array_sum($total_cleaner_price) + $total_amount;

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



        // Apply background color to cells E($row_new+1), E($row_new+2), and E($row_new+3)

        $row_new = 1;

        $sheet->getStyle('A' . ($row_new + 1))->applyFromArray($styleArray2);
        $sheet->getStyle('A' . ($row_new + 2))->applyFromArray($styleArray2);
        $sheet->getStyle('A' . ($row_new + 3))->applyFromArray($styleArray2);
        $sheet->getStyle('A' . ($row_new + 4))->applyFromArray($styleArray2);
        $sheet->getStyle('A' . ($row_new + 5))->applyFromArray($styleArray2);
        $sheet->getStyle('A' . ($row_new + 6))->applyFromArray($styleArray2);
        $sheet->getStyle('A' . ($row_new + 7))->applyFromArray($styleArray2);

        $sheet->getStyle('B' . ($row_new + 1))->applyFromArray($styleArray1);
        $sheet->getStyle('B' . ($row_new + 2))->applyFromArray($styleArray1);
        $sheet->getStyle('B' . ($row_new + 3))->applyFromArray($styleArray1);
        $sheet->getStyle('B' . ($row_new + 4))->applyFromArray($styleArray1);
        $sheet->getStyle('B' . ($row_new + 5))->applyFromArray($styleArray1);
        $sheet->getStyle('B' . ($row_new + 6))->applyFromArray($styleArray1);
        $sheet->getStyle('B' . ($row_new + 7))->applyFromArray($styleArray1);

        $sheet->setCellValue('A' . $row_new . '', 'Summary');
        $sheet->getStyle('A' . $row_new)->getFont()->setBold(true)->setUnderline(true);


        $sheet->setCellValue('A' . $row_new + 1  . '', 'Total Completed Order');
        $sheet->setCellValue('B' . $row_new + 1  . '', '' . $total_complete_order . '');

        $sheet->setCellValue('A' . $row_new + 2  . '', 'Total Pending Order');
        $sheet->setCellValue('B' . $row_new + 2  . '', '' . $pending_complete_order . '');

        $sheet->setCellValue('A' . $row_new + 3  . '', 'Total Amount');
        $sheet->setCellValue('B' . $row_new + 3  . '', '' . $final_total . '');

        $sheet->setCellValue('A' . $row_new + 4  . '', 'Date');
        $sheet->setCellValue('B' . $row_new + 4  . '', '' . $download_date . '');

        $sheet->setCellValue('A' . $row_new + 5  . '', 'Start Date');
        if ($startdate) {
            $sheet->setCellValue('B' . $row_new + 5  . '', '' . $startdate . '');
        } else {
            $sheet->setCellValue('B' . $row_new + 5  . '', '-');
        }

        $sheet->setCellValue('A' . $row_new + 6  . '', 'End Date:');
        if ($enddate) {
            $sheet->setCellValue('B' . $row_new + 6  . '', '' . $enddate . '');
        } else {
            $sheet->setCellValue('B' . $row_new + 6  . '', '-');
        }

        $sheet->setCellValue('A' . $row_new + 7  . '', 'Cleaner Name');
        $sheet->getStyle('B' . $row_new + 7)->getFont()->setBold(true);
        $sheet->setCellValue('B' . ($row_new + 7), Helper::cleanername($cleaner_name));



        $sheet->setCellValue('A10', 'Order Id');
        $sheet->setCellValue('B10', 'Date');
        $sheet->setCellValue('C10', 'Starting Time');
        $sheet->setCellValue('D10', 'Ending Time');
        $sheet->setCellValue('E10', 'Sales Person');
        $sheet->setCellValue('F10', 'Customer Name');
        $sheet->setCellValue('G10', 'Contact No.');
        $sheet->setCellValue('H10', 'Address');
        $sheet->setCellValue('I10', 'Cleaners');
        $sheet->setCellValue('J10', 'Type of Job');
        $sheet->setCellValue('K10', 'Vendor Name');
        $sheet->setCellValue('L10', 'Total Amount');
        $sheet->setCellValue('M10', 'Duration');
        $sheet->setCellValue('N10', 'Status');
        $sheet->setCellValue('O10', 'Remarks');
        $sheet->setCellValue('P10', 'Client Review');
        $sheet->setCellValue('Q10', 'Payment Status');

        $row = 11;

        if (isset($cleaner_order_data)) {
            foreach ($cleaner_order_data as $data) {

                // echo"<pre>";print_r($data);echo"</pre>";exit;

                $user_data = DB::table('frontloginregisters')->where('id', $data->user_info_id)->first();

                $order_data = DB::table('ci_orders')->where('order_id', $data->order_id)->first();

                $cleaner_Id = explode(",", $data->cleaner_id);


                if ($order_data->format_order_id !== null) {
                    $sheet->setCellValue('A' . $row, $order_data->format_order_id);
                } else {
                    $sheet->setCellValue('A' . $row, '-');
                }

                if ($data->cdate !== null) {
                    $sheet->setCellValue('B' . $row, $data->cdate);
                } else {
                    $sheet->setCellValue('B' . $row, '-');
                }

                if ($data->time_slot !== null) {
                    $sheet->setCellValue('C' . $row, Helper::timeslotname($data->time_slot));
                } else {
                    $sheet->setCellValue('C' . $row, '-');
                }

                if ($data->subservice_id == 28) {
                    $hours = $data->how_many_hours_should_they_stay;

                    if ($hours) {
                        // Calculate the target end time
                        $target_end_time = $data->time_slot + $hours;

                        // Find the corresponding time slot that matches the calculated ending time
                        $next_slot = DB::table('time_slots')
                            ->where('id', $target_end_time)
                            ->first();
                    }
                }

                if ($data->subservice_id == 28) {
                    if ($next_slot !== null) {
                        $sheet->setCellValue('D' . $row, $next_slot->name);
                    }
                } else {
                    $sheet->setCellValue('D' . $row, '-');
                }

                if ($data->salesperson_id !== null) {
                    $sheet->setCellValue('E' . $row, Helper::salesperson($data->salesperson_id));
                } else {
                    $sheet->setCellValue('E' . $row, '-');
                }

                if ($user_data->name !== null) {
                    $sheet->setCellValue('F' . $row, $user_data->name);
                } else {
                    $sheet->setCellValue('F' . $row, '-');
                }

                if ($user_data->mobile !== null) {
                    $sheet->setCellValue('G' . $row, $user_data->mobile);
                } else {
                    $sheet->setCellValue('G' . $row, '-');
                }

                if ($data->apartment_villa_no !== null) {
                    $address = $data->apartment_villa_no . ', ' . $data->building_street_no . ', ' . $data->area . ', ' . $data->city;
                    $sheet->setCellValue('H' . $row, $address);
                } else {
                    $sheet->setCellValue('H' . $row, '-');
                }




                // Ensure there is a valid cleaner ID before calling the helper
                if (!empty($cleaner_Id)) {
                    $sheet->setCellValue('I' . $row, Helper::cleanername_new($cleaner_Id));
                } else {
                    $sheet->setCellValue('I' . $row, '-');
                }

                if (!empty($data->subservice_id)) {
                    $sheet->setCellValue('J' . $row, Helper::subservicename($data->subservice_id));
                } else {
                    $sheet->setCellValue('J' . $row, '-');
                }

                if (!empty($order_data->vendor_id)) {
                    $sheet->setCellValue('K' . $row, Helper::vendorsname($order_data->vendor_id));
                } else {
                    $sheet->setCellValue('K' . $row, '-');
                }

                if ($data->subservice_id == 28) {

                    $service_charge = $order_data->service_charge ?? 0;
                    $no_of_cleaners = $data->how_many_cleaners_do_you_need ?? 0;

                    $cleaner_price = $service_charge / $no_of_cleaners;

                    if (!empty($cleaner_price)) {
                        $sheet->setCellValue('L' . $row, $cleaner_price);
                    } else {
                        $sheet->setCellValue('L' . $row, '-');
                    }
                } else {

                    if (!empty($data->cleaner_price)) {
                        $sheet->setCellValue('L' . $row, $data->cleaner_price);
                    } else {
                        $sheet->setCellValue('L' . $row, '-');
                    }
                }

                if ($data->subservice_id == 28) {
                    if (!empty($hours)) {
                        $sheet->setCellValue('M' . $row, $hours);
                    }
                } else {
                    $sheet->setCellValue('M' . $row, '-');
                }


                if ($order_data->order_status === "CO") {
                    $order_status = "Completed";
                } elseif ($order_data->order_status === "P") {
                    $order_status = "Pending";
                } else {
                    $order_status = "Cancelled";
                }


                if (!empty($order_status)) {
                    $sheet->setCellValue('N' . $row, $order_status);
                } else {
                    $sheet->setCellValue('N' . $row, '-');
                }

                if (!empty($data->subservice_id)) {
                    $sheet->setCellValue('O' . $row, '-');
                } else {
                    $sheet->setCellValue('O' . $row, '-');
                }

                if (!empty($data->subservice_id)) {
                    $sheet->setCellValue('P' . $row, '-');
                } else {
                    $sheet->setCellValue('P' . $row, '-');
                }


                if ($order_data->payment_status == "Success") {
                    $payment_status = "Success";
                } else {
                    $payment_status = "Failed";
                }

                if (!empty($order_data->payment_status)) {
                    $sheet->setCellValue('Q' . $row, $payment_status);
                } else {
                    $sheet->setCellValue('Q' . $row, '-');
                }
                $row++;
            }
        }

        $writer = new Xlsx($spreadsheet);

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="CleanersReport.xlsx"');
        header('Cache-Control: max-age=0');

        // Write the file to the browser
        $writer->save('php://output');
        exit;
    }
}
