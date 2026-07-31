<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use DB;

class ReportsDashboardController extends Controller
{
    public function index(Request $request)
    {
        $vendor_id = $request->input('vendor_id');
        $sales_person_id = $request->input('sales_person_id');
        $crew_id = $request->input('crew_id');
        $customer_id = $request->input('customer_id');
        $service_id = $request->input('service_id');
        $city_id = $request->input('city_id');
        $status = $request->input('status');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Helper to apply filters to order queries
        $applyOrderFilters = function ($q, $tableName = 'ci_orders') use ($vendor_id, $sales_person_id, $crew_id, $customer_id, $status, $start_date, $end_date) {
            if ($vendor_id || $sales_person_id || $crew_id) {
                if ($tableName == 'ci_orders') {
                    $q->whereIn("$tableName.order_id", function($subquery) use ($vendor_id, $sales_person_id, $crew_id) {
                        $subquery->select('order_id')->from('ci_order_item');
                        if ($vendor_id) $subquery->where('vendor_id', $vendor_id);
                        if ($sales_person_id) $subquery->where('salesperson_id', $sales_person_id);
                        if ($crew_id) $subquery->whereRaw("FIND_IN_SET(?, cleaner_id)", [$crew_id]);
                    });
                } else {
                    // For package_order_amount_attr, order_id stores the format_order_id string (e.g. #HC-...)
                    $q->whereIn("$tableName.order_id", function($subquery) use ($vendor_id, $sales_person_id, $crew_id) {
                        $subquery->select('ci_orders.format_order_id')
                                 ->from('ci_orders')
                                 ->join('ci_order_item', 'ci_orders.order_id', '=', 'ci_order_item.order_id');
                        if ($vendor_id) $subquery->where('ci_order_item.vendor_id', $vendor_id);
                        if ($sales_person_id) $subquery->where('ci_order_item.salesperson_id', $sales_person_id);
                        if ($crew_id) $subquery->whereRaw("FIND_IN_SET(?, ci_order_item.cleaner_id)", [$crew_id]);
                    });
                }
            }
            
            if ($customer_id && $tableName == 'ci_orders') $q->where("$tableName.user_id", $customer_id);
            if ($status && $tableName == 'ci_orders') $q->where("$tableName.order_status", $status);
            
            $dateField = ($tableName == 'ci_orders') ? 'created_at' : 'order_date';
            if ($start_date) $q->whereDate("$tableName.$dateField", '>=', $start_date);
            if ($end_date) $q->whereDate("$tableName.$dateField", '<=', $end_date);
        };

        try {
            $q1 = DB::table('ci_orders')->where('is_delete', '0')->where('payment_status', 'SUCCESS');
            $applyOrderFilters($q1, 'ci_orders');
            $total_revenue = $q1->sum('order_total') ?? 0;
            if ($total_revenue == 0) {
                $q2 = DB::table('ci_orders')->where('is_delete', '0')->where('payment_status', 'SUCCESS');
                $applyOrderFilters($q2, 'ci_orders');
                $total_revenue = $q2->sum('total') ?? 0;
            }
        } catch (\Exception $e) { $total_revenue = 0; }
        
        try {
            $q_bookings = DB::table('ci_orders')->where('is_delete', '0');
            $applyOrderFilters($q_bookings, 'ci_orders');
            $total_bookings = $q_bookings->count();
        } catch (\Exception $e) { $total_bookings = 0; }

        try {
            $q_vc = DB::table('package_order_amount_attr');
            if ($service_id) $q_vc->where('service_id', $service_id);
            $applyOrderFilters($q_vc, 'package_order_amount_attr');
            
            $package_order_amount_attr = $q_vc->orderBy('order_id', 'DESC')->get();

            $total_commission_amount = 0;
            $displayedOrderIds = [];

            foreach($package_order_amount_attr as $data) {
                $showRow = !in_array($data->order_id, $displayedOrderIds);
                if ($showRow) {
                    $displayedOrderIds[] = $data->order_id;
                    $amount_without_vat = $data->order_total - $data->vatcharge;
                } else {
                    $amount_without_vat = 0;
                }
                
                // In package_order_amount_attr, order_id is the string format_order_id.
                // We need the integer order_id to query ci_order_item.
                $order_record = DB::table('ci_orders')->where('format_order_id', $data->order_id)->first();
                $item = null;
                if ($order_record) {
                    $item = DB::table('ci_order_item')->where('order_id', $order_record->order_id)->first();
                }
                
                $commission_amount = 0;

                if ($item) {
                    $fixedAmount = (float) ($item->subservice_booking_amount ?? 0);
                    $percentage = (float) ($item->subservice_booking_percentage ?? 0);
                    
                    if ($fixedAmount > 0) {
                        $commission_amount = $showRow ? $fixedAmount : 0; // Apply fixed amount once per order
                    } elseif ($percentage > 0) {
                        $commission_amount = $amount_without_vat * $percentage / 100;
                    } else {
                        // Fallback to original attribute if both are 0
                        $commission_amount = $amount_without_vat * ($data->booking_percentage ?? 0) / 100;
                    }
                } else {
                    $commission_amount = $amount_without_vat * ($data->booking_percentage ?? 0) / 100;
                }
                
                if($data->payment_type == "Online"){
                    $cc_fee = $data->add_amount * 2.625 / 100;
                }else{
                    $cc_fee = 0;
                }

                $commission_cc_charge = $commission_amount + $cc_fee;
                $total_commission_amount += $commission_cc_charge;
            }
            $vat_on_sum_charge = $total_commission_amount * 5 / 100;
            $vendor_commission = $total_commission_amount + $vat_on_sum_charge;

        } catch (\Exception $e) { $vendor_commission = 0; }
        
        try {
            $profit = $total_revenue - $vendor_commission; 
        } catch (\Exception $e) { $profit = 0; }

        try {
            $active_crew = DB::table('users')->where('role_id', '16')->where('is_active', 0)->count();
        } catch (\Exception $e) { $active_crew = 0; }

        try {
            $active_sales_persons = DB::table('users')->whereIn('role_id', [11, 12])->where('is_active', 0)->count();
        } catch (\Exception $e) { $active_sales_persons = 0; }
        
        try {
            $new_customers = DB::table('frontloginregisters')->whereMonth('created_at', date('m'))->count();
        } catch (\Exception $e) { $new_customers = 0; }

        $kpis = [
            'total_revenue' => $total_revenue,
            'total_bookings' => $total_bookings,
            'ad_spend' => 0, // Not available easily
            'profit' => $profit, 
            'vendor_commission' => $vendor_commission,
            'active_crew' => $active_crew,
            'active_sales_persons' => $active_sales_persons, 
            'new_customers' => $new_customers,
        ];

        // Fetch data for filters
        try {
            $vendors = DB::table('users')->where('vendor', '1')->select('id', 'name')->get();
        } catch (\Exception $e) { $vendors = collect(); }

        try {
            $sales_persons = DB::table('users')->whereIn('role_id', [11, 12])->where('is_active', 0)->select('id', 'name')->get();
        } catch (\Exception $e) { $sales_persons = collect(); }

        try {
            $crews = DB::table('users')->where('role_id', '16')->where('is_active', 0)->select('id', 'name')->get();
        } catch (\Exception $e) { $crews = collect(); }

        try {
            $customers = DB::table('frontloginregisters')->select('id', 'name')->get();
        } catch (\Exception $e) { $customers = collect(); }

        try {
            $services = DB::table('services')->where('is_active', '0')->select('id', 'servicename')->get();
        } catch (\Exception $e) { $services = collect(); }

        try {
            $cities = DB::table('cities')->select('id', 'name')->get();
        } catch (\Exception $e) { $cities = collect(); }

        return view('admin.reports_dashboard', compact('kpis', 'vendors', 'sales_persons', 'crews', 'customers', 'services', 'cities'));
    }
}
