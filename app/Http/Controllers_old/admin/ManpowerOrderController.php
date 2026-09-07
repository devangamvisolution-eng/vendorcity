<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin\Order;
use App\Models\front\Ciorder;
use App\Models\front\CiorderItem;

class ManpowerOrderController extends Controller
{
    public function index(Request $request)
    {
        $data['error'] = '';

        if (!\Illuminate\Support\Facades\Schema::hasColumn('ci_orders', 'is_manpower_order')) {
            \Illuminate\Support\Facades\Schema::table('ci_orders', function ($table) {
                $table->tinyInteger('is_manpower_order')->default(0)->after('is_survey_order');
            });
        }

        $query = DB::table('ci_orders')
            ->where('ci_orders.is_delete', '0')
            ->where('ci_orders.is_manpower_order', 1)
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )
            ->orderBy('ci_orders.order_id', 'DESC');

        $orderList = $query->get();

        foreach ($orderList as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->get();
            $order->items = $itemList;
        }

        $data['orders_list'] = $orderList;

        return view('admin.manpower_order.list', $data);
    }

    public function create()
    {
        $data['customer'] = DB::table('frontloginregisters')->get();
        $data['services'] = DB::table('services')->where('is_active', '0')->get();
        $data['salespersons'] = DB::table('users')->whereIn('role_id', [11, 12])->where('is_active', '0')->get();
        $data['vendors'] = DB::table('users')->where('vendor', 1)->where('is_active', '0')->get();
        $data['time_slots'] = DB::table('time_slots')->orderBy('set_order', 'ASC')->get();

        return view('admin.manpower_order.add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'service_id' => 'required',
            'subservice_id' => 'required',
            'service_date' => 'required',
            'sub_total' => 'required|numeric'
        ]);

        if ($request->payment_method == 'ONLINE') {
            $id = 2;
        } else {
            $id = 1;
        }

        if ($id == '1') {
            $order_status = 'BK';
            $paymentmode = $id;
            $list_order_status = '0';
            $payment_status = 'Success';
            $payment_mode = "COD";
        } else {
            $order_status = 'BK';
            $paymentmode = $id;
            $list_order_status = '0';
            $payment_status = 'FAILED';
            $payment_mode = "ONLINE PAYMENT";
        }

        $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($request->city) . '%'])->first();
        $cityCode = 'DU';
        if (isset($cityData)) {
            if (isset($cityData->city_code)) {
                $cityCode = $cityData->city_code;
            } else {
                $cityCode = 'OT';
            }
        }
        $subserviceCode = 'MAN';
        $year = date('y');

        /* ---------------- SEQUENCE LOGIC ---------------- */
        $lastSequence = DB::table('ci_orders')
            ->where('subservice_code', $subserviceCode)
            ->where('city_code', $cityCode)
            ->where('order_year', $year)
            ->selectRaw('MAX(CAST(sequence_no AS UNSIGNED)) as seq')
            ->lockForUpdate()
            ->value('seq');

        $nextSequence = $lastSequence ? $lastSequence + 1 : 1;

        $formatOrderId = sprintf(
            "%s-%s-%s-%06d",
            $subserviceCode,
            $year,
            $cityCode,
            $nextSequence
        );

        $orderData = [
            'user_id' => $request->customer_id,
            'is_manpower_order' => 1,
            'order_status' => $order_status,
            'paymentmode' => $paymentmode,
            'payment_status' => $payment_status,
            'list_order_status' => $list_order_status,
            'sub_total' => $request->sub_total,
            'order_total' => $request->order_total ?? $request->sub_total,
            'timing_charge' => $request->timing_charge ?? 0,
            'date_charge' => $request->date_charge ?? 0,
            'service_fee' => $request->service_fee ?? 0,
            'cod_charge' => $request->cod_charge ?? 0,
            'vatcharge' => $request->vat_charge ?? 0,
            'vendor_id' => $request->vendor_id ?? 0,
            'created_at' => date('Y-m-d H:i:s'),
            'subservice_code' => $subserviceCode,
            'city_code' => $cityCode,
            'order_year' => $year,
            'sequence_no' => $nextSequence,
            'format_order_id' => $formatOrderId,
        ];

        $insertedOrderId = DB::table('ci_orders')->insertGetId($orderData);

        $bookingdate = date('d', strtotime($request->service_date));
        $month = date('M', strtotime($request->service_date));
        $bookingyear = date('Y', strtotime($request->service_date));

        // Create the order item
        $orderItemData = [
            'order_id' => $insertedOrderId,
            'user_info_id' => $request->customer_id,
            'service_id' => $request->service_id,
            'subservice_id' => $request->subservice_id,
            'salesperson_id' => $request->salesperson_id,
            'bookingdate' => $bookingdate,
            'month' => $month,
            'bookingyear' => $bookingyear,
            'manpower_service_required' => $request->manpower_service_required,
            'manpower_workers_required' => $request->manpower_workers_required,
            'manpower_start_date' => $request->manpower_start_date,
            'manpower_end_date' => $request->manpower_end_date,
            'manpower_duration' => $request->manpower_duration,
            'manpower_job_description' => $request->manpower_job_description,
            'manpower_additional_notes' => $request->manpower_additional_notes,
            'time_slot' => $request->time_slot,
            'address_type' => $request->address_type,
            'city' => $request->city,
            'area' => $request->area,
            'building_street_no' => $request->building_name,
            'apartment_villa_no' => $request->apartment_villa_num,
            'cdate' => date('Y-m-d H:i:s'),
        ];

        DB::table('ci_order_item')->insert($orderItemData);

        $customer = DB::table('frontloginregisters')->where('id', $request->customer_id)->first();
        $phone_number = $customer ? $customer->mobile : '';
        $email_address = $customer ? $customer->email : '';

        $shippingData = [
            'first_name' => "",
            'last_name' => "",
            'country' => "",
            'address1' => $request->building_name ?? "",
            'state' => "",
            'city' => $request->city ?? "",
            'zipcode' => "",
            'address2' => $request->apartment_villa_num ?? "",
            'phone_number' => $phone_number,
            'email_address' => $email_address,
            'additional_message' => $request->manpower_additional_notes ?? "",
            'payment_method' => $payment_mode ?? "",
            'order_id' => $insertedOrderId,
            'user_id' => $request->customer_id,
        ];

        DB::table('ci_shipping_address')->insert($shippingData);

        // Notification logic
        if ($request->send_notification == 'Yes') {
            // Need to implement mail logic here
            // Helper::order_email($insertedOrderId); (if such helper exists)
        }

        return redirect()->route('manpower-orders.index')->with('success', 'Manpower Order Added Successfully');
    }

    public function show($id)
    {
        $order = DB::table('ci_orders')->where('order_id', $id)->first();
        if (!$order) {
            return redirect()->route('manpower-orders.index')->with('error', 'Order not found');
        }

        $orderItem = DB::table('ci_order_item')->where('order_id', $order->order_id)->first();
        $customer = DB::table('frontloginregisters')->where('id', $order->user_id)->first();
        $service = DB::table('services')->where('id', $orderItem->service_id ?? 0)->first();
        $subservice = DB::table('subservices')->where('id', $orderItem->subservice_id ?? 0)->first();
        $salesperson = DB::table('users')->where('id', $orderItem->salesperson_id ?? 0)->first();
        $vendor = DB::table('users')->where('id', $order->vendor_id ?? 0)->first();

        $data = compact('order', 'orderItem', 'customer', 'service', 'subservice', 'salesperson', 'vendor');
        return view('admin.manpower_order.detail', $data);
    }

    public function edit($id)
    {
        $order = DB::table('ci_orders')->where('order_id', $id)->first();
        if (!$order) {
            return redirect()->route('manpower-orders.index')->with('error', 'Order not found');
        }

        $orderItem = DB::table('ci_order_item')->where('order_id', $order->order_id)->first();

        $data['order'] = $order;
        $data['orderItem'] = $orderItem;

        $data['customer'] = DB::table('frontloginregisters')->get();
        $data['services'] = DB::table('services')->where('is_active', '0')->get();
        $data['subservices'] = DB::table('subservices')->where('serviceid', $orderItem->service_id ?? 0)->where('is_active', '0')->get();
        $data['salespersons'] = DB::table('users')->whereIn('role_id', [11, 12])->where('is_active', '0')->get();
        $data['vendors'] = DB::table('users')->where('vendor', 1)->where('is_active', '0')->get();
        $data['time_slots'] = DB::table('time_slots')->orderBy('set_order', 'ASC')->get();

        return view('admin.manpower_order.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sub_total' => 'required|numeric'
        ]);

        $order = DB::table('ci_orders')->where('order_id', $id)->first();
        if (!$order) {
            return redirect()->route('manpower-orders.index')->with('error', 'Order not found');
        }

        if ($request->payment_method == 'ONLINE') {
            $payid = 2;
        } else {
            $payid = 1;
        }

        $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($request->city) . '%'])->first();
        $cityCode = 'DU';
        if (isset($cityData)) {
            if (isset($cityData->city_code)) {
                $cityCode = $cityData->city_code;
            } else {
                $cityCode = 'OT';
            }
        }
        $subserviceCode = 'MAN';
        $year = date('y');

        $orderData = [
            'user_id' => $request->customer_id ?? $order->user_id,
            'order_status' => $request->order_status,
            'paymentmode' => $payid,
            'sub_total' => $request->sub_total,
            'order_total' => $request->order_total ?? $request->sub_total,
            'timing_charge' => $request->timing_charge ?? 0,
            'date_charge' => $request->date_charge ?? 0,
            'service_fee' => $request->service_fee ?? 0,
            'cod_charge' => $request->cod_charge ?? 0,
            'vatcharge' => $request->vat_charge ?? 0,
            'vendor_id' => $request->vendor_id ?? 0,
            'subservice_code' => $subserviceCode,
            'city_code' => $cityCode,
        ];

        if (empty($order->sequence_no)) {
            $lastSequence = DB::table('ci_orders')
                ->where('subservice_code', $subserviceCode)
                ->where('city_code', $cityCode)
                ->where('order_year', $year)
                ->selectRaw('MAX(CAST(sequence_no AS UNSIGNED)) as seq')
                ->lockForUpdate()
                ->value('seq');

            $nextSequence = $lastSequence ? $lastSequence + 1 : 1;

            $formatOrderId = sprintf(
                "%s-%s-%s-%06d",
                $subserviceCode,
                $year,
                $cityCode,
                $nextSequence
            );

            $orderData['order_year'] = $year;
            $orderData['sequence_no'] = $nextSequence;
            $orderData['format_order_id'] = $formatOrderId;
        }

        DB::table('ci_orders')->where('order_id', $id)->update($orderData);

        $bookingdate = date('d', strtotime($request->service_date));
        $month = date('M', strtotime($request->service_date));
        $bookingyear = date('Y', strtotime($request->service_date));

        $orderItemData = [
            'service_id' => $request->service_id ?? ($orderItem->service_id ?? 0),
            'user_info_id' => $request->customer_id ?? ($orderItem->user_info_id ?? 0),
            'subservice_id' => $request->subservice_id ?? ($orderItem->subservice_id ?? 0),
            'salesperson_id' => $request->salesperson_id,
            'bookingdate' => $bookingdate,
            'month' => $month,
            'bookingyear' => $bookingyear,
            'manpower_service_required' => $request->manpower_service_required,
            'manpower_workers_required' => $request->manpower_workers_required,
            'manpower_start_date' => $request->manpower_start_date,
            'manpower_end_date' => $request->manpower_end_date,
            'manpower_duration' => $request->manpower_duration,
            'manpower_job_description' => $request->manpower_job_description,
            'manpower_additional_notes' => $request->manpower_additional_notes,
            'time_slot' => $request->time_slot,
            'address_type' => $request->address_type,
            'city' => $request->city,
            'area' => $request->area,
            'building_street_no' => $request->building_name,
            'apartment_villa_no' => $request->apartment_villa_num,
        ];

        DB::table('ci_order_item')->where('order_id', $order->order_id)->update($orderItemData);

        if ($request->send_notification == 'Yes') {
            // Send email
        }

        return redirect()->route('manpower-orders.index')->with('success', 'Manpower Order Updated Successfully');
    }

    public function destroy($id)
    {
        // soft delete
        DB::table('ci_orders')->where('order_id', $id)->update(['is_delete' => '1']);
        return redirect()->route('manpower-orders.index')->with('success', 'Manpower Order Deleted Successfully');
    }
}
