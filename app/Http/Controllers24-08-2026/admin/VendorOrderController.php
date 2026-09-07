<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Mail;
use App\Models\front\Ciorder;
use App\Models\front\CiorderItem;
use App\Models\front\CiShippingAddress;

class VendorOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($order_id = '', $status = '')
    {
        $vendors_id = Auth::user()->id;
        $data['error'] = '';
        //$data['subscribe_data'] = Subscribe::orderBy('id','DESC')->get();    
        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            //->leftJoin('ci_shipping_address', 'ci_orders.order_id', '=', 'ci_shipping_address.order_id')
            ->select('frontloginregisters.email as user_email', 'frontloginregisters.name as user_name', 'frontloginregisters.mobile as user_mobile',  'ci_orders.*')
            ->where('ci_orders.order_from', '!=', 2)
            ->where('ci_orders.order_from', '=', 0)
            ->where('ci_orders.order_from', '!=', 1);;

        if (!empty($order_id)) {
            $query->where('ci_orders.order_id', $order_id);
        }
        if (!empty($status)) {
            if ($status == 'SUCCESS' || $status == 'FAILED') {
                $query->where('ci_orders.payment_status', $status);
            } else {
                $query->where('ci_orders.order_status', $status);
            }
        }
        $query->where('ci_orders.vendor_id', $vendors_id);
        $query->orderBy('ci_orders.order_id', 'DESC');

        $orderList = $query->get();

        foreach ($orderList as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('subservice_id', 23)
                ->get();

            $total = 0;
            $additionalCost = 0;
            foreach ($itemList as $item) {
                $product = DB::table('packages')
                    ->where('id', $item->package_id)
                    ->first();
                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }
                $total += $product_item_price * $item->package_quantity;
            }
            $order->items = $itemList;
        }
        $orderList;
        $data['vendororders_list'] = $orderList;
        return view('admin.list_vendororder', $data);
    }

    public function vendor_all_order()
    {
        $vendors_id = Auth::user()->id;

        // Get vendor details
        $vendorData = DB::table('users')->where('id', $vendors_id)->first();

        $cityCodes = DB::table('cities')
            ->whereIn('id', $vendorData->city ? explode(',', $vendorData->city) : [])
            ->pluck('city_code')
            ->toArray();

        // Convert vendor serviceList & subserviceList to arrays
        $serviceList = [];
        $subserviceList = [];

        if (!empty($vendorData->serviceList)) {
            $serviceList = explode(',', $vendorData->serviceList);
        }

        if (!empty($vendorData->subserviceList)) {
            $subserviceList = explode(',', $vendorData->subserviceList);
        }

        // 🔹 Get all order_ids this vendor has already accepted/rejected
        $excludedOrders = DB::table('vendor_order_accept_reject')
            ->where('vendor_id', $vendors_id)
            ->pluck('order_id')
            ->toArray();

        // Fetch all orders that are not assigned and not already processed by vendor
        $orders = DB::table('ci_orders as o')
            ->leftJoin('frontloginregisters as f', 'o.user_id', '=', 'f.id')
            ->where('o.is_delete', '0')
            ->where('o.payment_status', 'Success') // ✅ Only successful payments
            ->where(function ($q) {
                $q->where('o.vendor_id', 0)
                    ->orWhere('o.vendor_id', '')
                    ->orWhereNull('o.vendor_id');
            })
            ->whereNotIn('o.order_id', $excludedOrders)
            ->select(
                'o.*',
                'f.email as user_email',
                'f.name as user_name',
                'f.mobile as user_mobile'
            )
            ->orderByDesc('o.order_id')
            ->get()
            ->map(function ($order) use ($serviceList, $subserviceList) {

                // ✅ Fetch only items that match BOTH service and subservice
                $order->items = DB::table('ci_order_item as i')
                    ->where('i.order_id', $order->order_id)
                    ->whereIn('i.service_id', $serviceList)
                    ->whereIn('i.subservice_id', $subserviceList)
                    ->select('i.*')
                    ->get();

                return $order;
            })
            // ✅ Keep only orders with at least one valid item
            ->filter(function ($order) {
                return $order->items->isNotEmpty();
            })
            ->values();

        $data['vendororders_list'] = $orders;

        return view('admin.list_vendor_all_order', $data);
    }




    public function cleaning_listing($order_id = '', $status = '')
    {
        $vendors_id = Auth::user()->id;
        $data['error'] = '';

        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )
            ->where('ci_orders.order_from', 1) // This already excludes 0 and 2
            ->where('ci_orders.vendor_id', $vendors_id);

        if (!empty($order_id)) {
            $query->where('ci_orders.order_id', $order_id);
        }

        if (!empty($status)) {
            if ($status == 'SUCCESS' || $status == 'FAILED') {
                $query->where('ci_orders.payment_status', $status);
            } else {
                $query->where('ci_orders.order_status', $status);
            }
        }

        $query->orderBy('ci_orders.order_id', 'DESC');
        $allOrders = $query->get();

        $filteredOrders = [];

        foreach ($allOrders as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('service_id', 45)
                ->get();

            if ($itemList->isEmpty()) {
                continue; // Skip orders that don't have service_id 48
            }

            $total = 0;
            foreach ($itemList as $item) {
                $product = DB::table('packages')
                    ->where('id', $item->package_id)
                    ->first();

                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }

                $total += $product_item_price * $item->package_quantity;
            }

            $order->items = $itemList;
            $filteredOrders[] = $order;
        }

        $data['vendororders_list'] = $filteredOrders;
        return view('admin.list_vendororder', $data);
    }

    public function healthcare_at_home_listing($order_id = '', $status = '')
    {
        $vendors_id = Auth::user()->id;
        $data['error'] = '';

        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )
            ->where('ci_orders.order_from', 1) // This already excludes 0 and 2
            ->where('ci_orders.vendor_id', $vendors_id);

        if (!empty($order_id)) {
            $query->where('ci_orders.order_id', $order_id);
        }

        if (!empty($status)) {
            if ($status == 'SUCCESS' || $status == 'FAILED') {
                $query->where('ci_orders.payment_status', $status);
            } else {
                $query->where('ci_orders.order_status', $status);
            }
        }

        $query->orderBy('ci_orders.order_id', 'DESC');
        $allOrders = $query->get();

        $filteredOrders = [];

        foreach ($allOrders as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('service_id', 54)
                ->get();

            if ($itemList->isEmpty()) {
                continue; // Skip orders that don't have service_id 48
            }

            $total = 0;
            foreach ($itemList as $item) {
                $product = DB::table('packages')
                    ->where('id', $item->package_id)
                    ->first();

                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }

                $total += $product_item_price * $item->package_quantity;
            }

            $order->items = $itemList;
            $filteredOrders[] = $order;
        }

        $data['vendororders_list'] = $filteredOrders;
        return view('admin.list_vendororder', $data);
    }

    public function salon_spa_listing($order_id = '', $status = '')
    {
        $vendors_id = Auth::user()->id;
        $data['error'] = '';

        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )
            ->where('ci_orders.order_from', 1) // This already excludes 0 and 2
            ->where('ci_orders.vendor_id', $vendors_id);

        if (!empty($order_id)) {
            $query->where('ci_orders.order_id', $order_id);
        }

        if (!empty($status)) {
            if ($status == 'SUCCESS' || $status == 'FAILED') {
                $query->where('ci_orders.payment_status', $status);
            } else {
                $query->where('ci_orders.order_status', $status);
            }
        }

        $query->orderBy('ci_orders.order_id', 'DESC');
        $allOrders = $query->get();

        $filteredOrders = [];

        foreach ($allOrders as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('service_id', 48)
                ->get();

            if ($itemList->isEmpty()) {
                continue; // Skip orders that don't have service_id 48
            }

            $total = 0;
            foreach ($itemList as $item) {
                $product = DB::table('packages')
                    ->where('id', $item->package_id)
                    ->first();

                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }

                $total += $product_item_price * $item->package_quantity;
            }

            $order->items = $itemList;
            $filteredOrders[] = $order;
        }

        $data['vendororders_list'] = $filteredOrders;

        return view('admin.list_vendororder', $data);
    }


    public function pest_control_listing($order_id = '', $status = '')
    {
        $vendors_id = Auth::user()->id;
        $data['error'] = '';

        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )
            ->where('ci_orders.order_from', 1) // This already excludes 0 and 2
            ->where('ci_orders.vendor_id', $vendors_id);

        if (!empty($order_id)) {
            $query->where('ci_orders.order_id', $order_id);
        }

        if (!empty($status)) {
            if ($status == 'SUCCESS' || $status == 'FAILED') {
                $query->where('ci_orders.payment_status', $status);
            } else {
                $query->where('ci_orders.order_status', $status);
            }
        }

        $query->orderBy('ci_orders.order_id', 'DESC');
        $allOrders = $query->get();

        $filteredOrders = [];

        foreach ($allOrders as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('service_id', 47)
                ->get();

            if ($itemList->isEmpty()) {
                continue; // Skip orders that don't have service_id 48
            }

            $total = 0;
            foreach ($itemList as $item) {
                $product = DB::table('packages')
                    ->where('id', $item->package_id)
                    ->first();

                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }

                $total += $product_item_price * $item->package_quantity;
            }

            $order->items = $itemList;
            $filteredOrders[] = $order;
        }

        $data['vendororders_list'] = $filteredOrders;
        return view('admin.list_vendororder', $data);
    }

    public function handyman_and_service_listing($order_id = '', $status = '')
    {
        $vendors_id = Auth::user()->id;
        $data['error'] = '';

        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )
            //->where('ci_orders.order_from', 1) // This already excludes 0 and 2
            ->where('ci_orders.vendor_id', $vendors_id);

        if (!empty($order_id)) {
            $query->where('ci_orders.order_id', $order_id);
        }

        if (!empty($status)) {
            if ($status == 'SUCCESS' || $status == 'FAILED') {
                $query->where('ci_orders.payment_status', $status);
            } else {
                $query->where('ci_orders.order_status', $status);
            }
        }

        $query->orderBy('ci_orders.order_id', 'DESC');
        $allOrders = $query->get();

        $filteredOrders = [];

        foreach ($allOrders as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('service_id', 34)
                ->get();

            if ($itemList->isEmpty()) {
                continue; // Skip orders that don't have service_id 48
            }

            $total = 0;
            foreach ($itemList as $item) {
                $product = DB::table('packages')
                    ->where('id', $item->package_id)
                    ->first();

                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }

                $total += $product_item_price * $item->package_quantity;
            }

            $order->items = $itemList;
            $filteredOrders[] = $order;
        }

        $data['vendororders_list'] = $filteredOrders;

        return view('admin.list_vendororder', $data);
    }

    public function car_inspection_order_listing($order_id = '', $status = '')
    {
        $vendors_id = Auth::user()->id;
        $data['error'] = '';

        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )
            ->where('ci_orders.order_from', 3) // This already excludes 0 and 2
            ->where('ci_orders.vendor_id', $vendors_id);

        if (!empty($order_id)) {
            $query->where('ci_orders.order_id', $order_id);
        }

        if (!empty($status)) {
            if ($status == 'SUCCESS' || $status == 'FAILED') {
                $query->where('ci_orders.payment_status', $status);
            } else {
                $query->where('ci_orders.order_status', $status);
            }
        }

        $query->orderBy('ci_orders.order_id', 'DESC');
        $allOrders = $query->get();

        $filteredOrders = [];

        foreach ($allOrders as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('service_id', 50)
                ->where('subservice_id', '=', '92')
                ->get();

            if ($itemList->isEmpty()) {
                continue; // Skip orders that don't have service_id 48
            }

            $total = 0;
            foreach ($itemList as $item) {
                $product = DB::table('packages')
                    ->where('id', $item->package_id)
                    ->first();

                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }

                $total += $product_item_price * $item->package_quantity;
            }

            $order->items = $itemList;
            $filteredOrders[] = $order;
        }

        $data['vendororders_list'] = $filteredOrders;

        return view('admin.list_vendororder', $data);
    }


    public function automobile_vendor_order($order_id = '', $status = '')
    {
        $vendors_id = Auth::user()->id;
        $data['error'] = '';

        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )
            //->where('ci_orders.order_from', 3) // This already excludes 0 and 2
            ->where('ci_orders.vendor_id', $vendors_id);

        if (!empty($order_id)) {
            $query->where('ci_orders.order_id', $order_id);
        }

        if (!empty($status)) {
            if ($status == 'SUCCESS' || $status == 'FAILED') {
                $query->where('ci_orders.payment_status', $status);
            } else {
                $query->where('ci_orders.order_status', $status);
            }
        }

        $query->orderBy('ci_orders.order_id', 'DESC');
        $allOrders = $query->get();

        $filteredOrders = [];

        foreach ($allOrders as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('service_id', 50)
                ->where('subservice_id', '!=', '92')
                ->get();

            if ($itemList->isEmpty()) {
                continue; // Skip orders that don't have service_id 48
            }

            $total = 0;
            foreach ($itemList as $item) {
                $product = DB::table('packages')
                    ->where('id', $item->package_id)
                    ->first();

                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }

                $total += $product_item_price * $item->package_quantity;
            }

            $order->items = $itemList;
            $filteredOrders[] = $order;
        }

        $data['vendororders_list'] = $filteredOrders;

        return view('admin.list_vendororder', $data);
    }


    public function painting_listing($order_id = '', $status = '')
    {
        $vendors_id = Auth::user()->id;
        $data['error'] = '';

        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )
            ->where('ci_orders.order_from', 2) // only painting orders
            ->where('ci_orders.vendor_id', $vendors_id);

        if (!empty($order_id)) {
            $query->where('ci_orders.order_id', $order_id);
        }

        if (!empty($status)) {
            if ($status == 'SUCCESS' || $status == 'FAILED') {
                $query->where('ci_orders.payment_status', $status);
            } else {
                $query->where('ci_orders.order_status', $status);
            }
        }

        $query->orderBy('ci_orders.order_id', 'DESC');
        $allOrders = $query->get();

        $filteredOrders = [];

        foreach ($allOrders as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('subservice_id', 47)
                ->get();

            if ($itemList->isEmpty()) {
                continue; // skip orders without subservice_id 47
            }

            $total = 0;
            foreach ($itemList as $item) {
                $product = DB::table('packages')
                    ->where('id', $item->package_id)
                    ->first();

                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }

                $total += $product_item_price * $item->package_quantity;
            }

            $order->items = $itemList;
            $filteredOrders[] = $order;
        }

        $data['vendororders_list'] = $filteredOrders;

        return view('admin.list_vendororder', $data);
    }

    function assign_driver(Request $request)
    {

        $order_id = $request->order_id;

        $ci_order_data = DB::table('ci_orders')
            ->where('order_id', $order_id)
            ->first();
        $ci_order_item_data = DB::table('ci_order_item')
            ->where('order_id', $order_id)
            ->first();

        $user = Auth::user();

        $html = '<select id="driver_id" name="driver_id"  class="form-control">';

        $html .= "<option value=''>Select Driver</option>";

        $driver_data = DB::table('users')
            ->where('role_id', '=', '15')
            ->where('added_by', $user->id)
            ->where('is_active', 0)
            ->get()->toArray();

        foreach ($driver_data as $driver_data_new) {
            if ($driver_data_new != '') {

                if ($ci_order_item_data->driver_id == $driver_data_new->id) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }

                $html .= "<option value='" . $driver_data_new->id . "'" . $selected . ">" . $driver_data_new->name . "</option>";
            }
        }

        $html .= "</select>";
        $html .= "<input type='hidden' name='order_id' id='order_id' value='" . $order_id . "'/>";
        return $html;
    }

    function vendor_cleaner_assign_form()
    {

        $order_id = $_POST['order_id'];
        $cleaner_id = $_POST['cleaner'];

        // echo"<pre>";print_r($_POST);echo"</pre>";exit;

        $currentOrder = DB::table('ci_order_item')->where('order_id', $order_id)->first();

        $bookingDate = $currentOrder->bookingdate;
        $bookingmonth = $currentOrder->month;
        $bookingyear   = $currentOrder->bookingyear;
        $hour = $currentOrder->how_many_hours_should_they_stay;
        $timeSlot =  $currentOrder->time_slot;

        $requiredSlots = [];
        for ($i = 0; $i <= $hour; $i++) {
            $requiredSlots[] = $timeSlot + $i;
        }

        $existingBookings = DB::table('ci_order_item')
            ->where('cleaner_id', $cleaner_id)
            ->where('bookingdate', $bookingDate)
            ->where('month', $bookingmonth)
            ->where('bookingyear', $bookingyear)
            ->where('id', '!=', $order_id)
            ->select('time_slot', 'how_many_hours_should_they_stay')
            ->get();

        $conflict = false;

        foreach ($existingBookings as $booking) {
            $bookedSlots = [];
            for ($i = 0; $i < $booking->how_many_hours_should_they_stay; $i++) {
                $bookedSlots[] = $booking->time_slot + $i;
            }
            // Check if any of the bookedSlots intersect with requiredSlots
            if (count(array_intersect($bookedSlots, $requiredSlots)) > 0) {
                $conflict = true;
                break;
            }
        }
        if ($conflict) {
            return response()->json(['status' => 0, 'message' => 'Cleaner already assigned for this time slot.', 'order_id' => $order_id]);
        }


        DB::table('ci_order_item')
            ->where('order_id', $order_id)
            ->update(['cleaner_id' => $cleaner_id]);

        // Ensure proper JSON response
        return response()->json(['status' => 1, 'order_id' => $order_id]);
    }


    function vendor_multi_cleaner_time_slot(Request $request)
    {

        $order_id = $request->input('order_id');
        $cleaner = $request->input('cleaner');

        $order_data = DB::table('ci_order_item')->where('order_id', $order_id)->first();

        $allItems = [];

        if (!empty($cleaner) && count($cleaner) > 0) {

            foreach ($cleaner as $cleaner_id) {
                $items = DB::table('ci_order_item')
                    ->whereRaw("FIND_IN_SET(?, cleaner_id)", [$cleaner_id])
                    ->where('bookingdate', $order_data->bookingdate)
                    ->where('month', $order_data->month)
                    ->where('bookingyear', $order_data->bookingyear)
                    ->get()->toArray();

                foreach ($items as $item) {

                    $hours = $item->how_many_hours_should_they_stay;
                    $start_slot = (int)$item->time_slot;

                    // Block current slot and next slots based on hours
                    for ($i = 0; $i <= $hours; $i++) {
                        $blockedSlots[$cleaner_id][] = $start_slot + $i;
                    }

                    $allItems[] = [
                        'order_id' => $item->order_id,
                        'cleaner_id' => $cleaner_id,
                        'time_slot' => $item->time_slot,
                        'bookingdate' => $item->bookingdate,
                        'month' => $item->month,
                        'bookingyear' => $item->bookingyear,
                        'how_many_hours_should_they_stay' => $item->how_many_hours_should_they_stay,
                    ];
                }
            }
            $total_slots = DB::table('subservice_timeslot_price')
                ->where('subservice_id', $order_data->subservice_id)
                ->where('is_active', '1')
                ->pluck('time_slot_id')
                ->toArray();

            $availableCleaners = [];
            $notAvailableCleaners = [];

            // Calculate required slots for the order
            $requiredSlots = [];
            for ($i = 0; $i <= $order_data->how_many_hours_should_they_stay; $i++) {
                $requiredSlots[] = $order_data->time_slot + $i;
            }

            foreach ($cleaner as $cleaner_id) {
                $allSlots = $total_slots;
                $booked = $blockedSlots[$cleaner_id] ?? [];
                $availableSlots = array_diff($allSlots, $booked);

                // Check if all required slots are available
                if (count(array_intersect($requiredSlots, $availableSlots)) === count($requiredSlots)) {
                    $availableCleaners[] = $cleaner_id;
                } else {
                    $notAvailableCleaners[] = $cleaner_id;
                }
            }

            // You now have two arrays: $availableCleaners and $notAvailableCleaners
            return response()->json([
                'order_id' => $order_id,
                'available_cleaners' => $availableCleaners,
                'not_available_cleaners_id' => $notAvailableCleaners,
                'not_available_cleaners' => Helper::cleanername_new($notAvailableCleaners)
            ]);
        }
    }
    function vendor_multi_cleaner_assign_form()
    {

        // echo"<pre>";print_r($_POST);echo"</pre>";exit;

        $order_id = $_POST['order_id'];
        $cleaner_ids = $_POST['cleaner'];

        if (!empty($order_id) && !empty($cleaner_ids) && is_array($cleaner_ids)) {

            $cleaner_ids_string = implode(',', $cleaner_ids);

            // echo"<pre>";print_r($cleaner_ids_string);echo"</pre>";exit;

            DB::table('ci_order_item')
                ->where('order_id', $order_id)
                ->update(['cleaner_id' => $cleaner_ids_string]);
        }

        // Ensure proper JSON response
        return response()->json(['status' => 1, 'order_id' => $order_id]);
    }


    function assign_driver_form()
    {
        //echo"here";exit;

        $order_id = $_POST['order_id'];
        $driver_id = $_POST['driver_id'];

        if ($driver_id != '') {
            DB::table('ci_order_item')
                ->where('order_id', $order_id)
                ->update(['driver_id' => $driver_id]);

            $this->driver_mail($order_id, $driver_id);
        }

        return redirect()->back()->with('success', 'Driver Assign successfully');
    }
    function driver_mail($order_id, $driver_id)
    {

        $order_data = DB::table('ci_order_item')
            ->where('order_id', $order_id)
            ->first();
        $driver_data = DB::table('users')
            ->where('id', $driver_id)
            ->first();

        $ci_orders_data  = DB::table('ci_orders')
            ->where('order_id', $order_id)
            ->first();

        if ($ci_orders_data->paymentmode == 1) { //Cod mail
            $payment_mode = "Cash On Delivery (Please Collect from Customer)";
        } else {
            $payment_mode = "Online (Paid)";
        }

        $driver_html = '';

        $driver_html .= '<!doctype html>
            <html lang="en">
            <head>
            <meta charset="utf-8">
            <title>Account Registration:</title>
            <style>
            .logo {
                border-bottom: 4px solid #FFD413;
            }
            .logo img{
                width: 45%;
            }
            .wrapper {
                width: 100%;
                max-width:500px;
                margin:auto;
                font-size:14px;
                line-height:24px;
                font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;
                color:#555;
                padding:50px 0;
            }   
            .email_wrapper {
                width:100%;
                margin-top: 18px;
                font-size: 16px;
            }
            h2 {
                font-size: 26px;
                font-weight: bolder;
                margin: 0;
            }
            .btnlink {
                background: #0040E6;
                color: #fff !important;
                text-decoration: none;
                width: 100%;
                display: block;
                padding: 9px 0;
                text-align: center;
                font-size: 16px;
                border-radius: 9px;
            }
            .email_footer {
                width:100%;
                margin-top: 20px;
            }
            h3 {
                font-size: 20px;
                font-weight: bolder;
                margin: 0;
                border-bottom: 3px solid #6B7177;
                padding-bottom: 20px;
                margin-bottom: 15px;
            }
            .email_footer_div {
                width:100%;
                display: flex; 
            }
            .footer_left {
                width: 100px;
                float: left;
            }
            .footer_right {
                margin-left:10px;
                float: left;
            }
            .footer_right p{
                margin:0;
            }
            .footer_links {
                margin:10px 0;
            }
            .footer_links a {
                width: 100%;
                color: #555;
                display: inline-block;
            }
            </style>
            </head>
            <body>
            <div class="wrapper" style="width: 100%;max-width:500px;margin:auto;
                                        font-size:14px;line-height:24px;
                                        font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
            <div class="logo" style="float: inherit;border-bottom: 4px solid #FFD413;">
            <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;" >
            </div>
            <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                            <p>  Dear ' . $driver_data->name . ',</p>
                            <p>We are excited to inform you that a new order has been assigned to you through VendorsCity! Below are the details for the upcoming service:</p>';
        $driver_html .= '<p><strong>Order Details:</strong><br>';
        $driver_html .= '<ul>
                                                <li><strong>Date and Time: </strong> ' . $order_data->bookingdate . '-' . $order_data->month . '-' . $order_data->bookingyear . 'at' . Helper::timeslotname($order_data->time_slot) . '</li>
                                                <li><strong>Service: </strong> ' . Helper::servicename($order_data->service_id) . '</li>
                                                <li><strong>Payment Type: </strong> ' . $payment_mode . '</li>
                                                </ul>';
        $driver_html .= '<p>Press “View Order” or login to your Driver portal to access all the customer details to complete the order.</p>';
        $driver_html .= '<button class="btn btn-primary" type="button"
                                style="background-color: #1F6EEC;border-color: #1F6EEC;color: #fff;
                                padding: 10px 18px;border-radius: 11px;">
                                <a href="' . url("vendor/login") . '" style="color:#fff !important; text-decoration:none !important;">View Order</a></button>';
        $driver_html .= '
                            <p>Your prompt attention to this order is greatly appreciated. If you have any questions or need further assistance, feel free to reach out to us at any time.</p>
                            <p>Thank you for your continued partnership and dedication to providing top-notch service.
                            </p>
                        </div>
                        <div class="email_footer" style="width:100%;margin-top: 20px;">
                            <h3 style=" font-size: 20px;font-weight: bolder;margin: 0;
                                        border-bottom: 3px solid #6B7177;padding-bottom: 20px;
                                        margin-bottom: 15px;">The VendorsCity Team</h3>
                                    <div class="email_footer_div" style=" width:100%;
                                        display: flex; ">
                                    <div class="footer_left" style="width: 100px;
                                        float: left;">
                                    <img style="width:70%;" src="' . asset("public/site/images/vcfaviconwap.png") . '"" >
                                </div>
                                <div class="footer_right"  style="margin-left:10px;
                                            float: left;">
                                    <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a></p>
                                    <p style="margin:0;">VendorsCity Portal LLC</p>
                                    <div class="footer_links" style=" margin:10px 0;">
                                    <a href="' . url("/terms-of-service") . '" style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                    <a href="' . url("/privacy-policy") . '" style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                    <a href="' . url("/contact") . '" style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </body>
            </html>';

        $subject = "New " . $order_data->service_name . " Order Assigned on VendorsCity | Order No. " . $ci_orders_data->format_order_id . "";
        $to = $driver_data->email;

        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        $ccRecipients = array();
        Mail::send([], [], function ($message) use ($driver_html, $to, $subject, $ccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($driver_html);
        });
    }
    function vendordetail($order_id)
    {
        $data['error'] = '';
        $vendors_id = Auth::user()->id;
        $query = Ciorder::leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->leftJoin('ci_shipping_address', 'ci_orders.order_id', '=', 'ci_shipping_address.order_id')
            ->select('frontloginregisters.email as user_email', 'frontloginregisters.name as user_name', 'frontloginregisters.country_code as user_country_code', 'frontloginregisters.mobile as user_mobile',  'ci_orders.*',  'ci_shipping_address.*');
        if (!empty($order_id)) {
            $query->where('ci_orders.order_id', $order_id);
        }
        if (!empty($status)) {
            if ($status == 'SUCCESS' || $status == 'FAILED') {
                $query->where('ci_orders.payment_status', $status);
            } else {
                $query->where('ci_orders.order_status', $status);
            }
        }
        $query->where('ci_orders.vendor_id', $vendors_id);
        $query->orderBy('ci_orders.order_id', 'DESC');
        $orderList = $query->get();
        foreach ($orderList as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_number)
                ->get();
            if ($order->order_from != 2) {

                $total = 0;
                $additionalCost = 0;
                foreach ($itemList as $item) {
                    $product = DB::table('packages')
                        ->where('id', $item->package_id)
                        ->first();
                    if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                        $product_item_price = $item->product_discount_amount;
                    } else {
                        $product_item_price = $item->package_item_price;
                    }
                    $total += $product_item_price * $item->package_quantity;
                }
                $order->sub_total = $total;
            }
            $order->items = $itemList;
        }
        $orderList;
        $data['order'] = $orderList[0];
        return view('admin.view_vendor_order', $data);
    }

    function vendor_all_order_detail($order_id)
    {
        // Fetch the specific order with user info
        $order = Ciorder::from('ci_orders as o')
            ->leftJoin('frontloginregisters as f', 'o.user_id', '=', 'f.id')
            ->where('o.is_delete', '0')
            ->where('o.order_id', $order_id) // filter by specific order
            ->where(function ($q) {
                $q->where('o.vendor_id', 0)
                    ->orWhere('o.vendor_id', '')
                    ->orWhereNull('o.vendor_id');
            })
            ->select(
                'o.*',
                'f.email as user_email',
                'f.name as user_name',
                'f.mobile as user_mobile',
                'f.country_code as user_country_code'
            )
            ->first(); // get single order

        // If order not found, redirect back or show 404
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }

        // Fetch only order items that match vendor's service list
        $order->items = DB::table('ci_order_item as i')
            ->where('i.order_id', $order->order_id)
            //->whereIn('i.service_id', $serviceList)
            ->select('i.*')
            ->get();

        // Pass data to view
        $data['order'] = $order;
        return view('admin.view_vendor_all_order', $data);
    }

    function check_order_vendor(Request $request)
    {

        $order_id = $request->order_id;
        $vendor_id = Auth::user()->id; // current logged-in vendor

        // Get order details
        $order = DB::table('ci_orders')->where('order_id', $order_id)->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found.'
            ]);
        }

        // Check if vendor_id is 0 or NULL
        if (empty($order->vendor_id) || $order->vendor_id == 0) {
            //Update order with current vendor
            DB::table('ci_orders')->where('order_id', $order_id)->update([
                'vendor_id' => $vendor_id,
                //'updated_at' => now(),
            ]);

            $data['order_id'] = $order_id;
            $data['vendor_id'] = $vendor_id;
            $data['accept_reject'] = 0;
            $data['added_date'] = date('Y-m-d');

            DB::table('vendor_order_accept_reject')->insert($data);

            $mail = $this->booking_accept_mail($order_id, $vendor_id);

            //echo "<pre>";print_r($mail);echo"</pre>";exit;

            return response()->json([
                'status' => 'success',
                'message' => 'Order accepted successfully.'
            ]);
        } else {
            // Already assigned
            return response()->json([
                'status' => 'error',
                'message' => 'This order is already accepted by another vendor.'
            ]);
        }
    }

    function booking_accept_mail($order_id, $vendor_id)
    {
        //echo $order_id;exit;

        $vendor_detail = DB::table('users')->where('vendor', 1)->where('id', $vendor_id)->first();
        $order_data = DB::table('ci_orders')->where('order_id', $order_id)->first();
        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_id)->get()->toArray();
        $customer_data = DB::table('frontloginregisters')->where('id', $order_data->user_id)->first();

        $date = $order_item_data[0]->bookingdate ?? "";
        $month = $order_item_data[0]->month ?? "";
        $year = $order_item_data[0]->bookingyear ?? "";

        if ($date != '' && $month != '' && $year != '') {
            $booking_date = $month . ' ' . $date . ', ' . $year;
        } else {
            $booking_date = "-";
        }




        $html_append = "";

        if ($order_data->paymentmode == 1) { //Cod mail
            $payment_mode = "Cash On Delivery (Please Collect from Customer)";
            $payment_mode_customer = "Cash On Delivery";
            $html_append .= "<p>Please <strong>contact the customer as soon as possible</strong> regarding the service. The customer may also contact you directly to discuss any specifics or ask questions about the service. Please ensure timely communication.";
            $html_append .= "<p><strong>Please note the following instructions for COD payments:</strong><br>";

            $html_append .= '<ul>
                                <li>Kindly collect the <strong>full payment</strong> from the customer <strong>upon completing the service.</strong></li>
                                <li>A VendorsCity representative will visit your location within 5 working days to collect the cash payment. Alternatively, if you prefer a bank transfer, please inform us, and we will provide you with our transfer details.
                                </li>
                            </ul>';
        } else {
            $payment_mode = "Online (Paid)";
            $payment_mode_customer = "Online";
            $html_append .= "<p><strong>Important Information:</strong><br>";

            $html_append .= '<ul>
                                <li><strong>Payment:</strong>Your payment will be processed after the successful completion of the job and confirmation from the customer.</li>
                                <li><strong>Customer Contact:</strong> Please <strong>contact the customer as soon as possible</strong> regarding the service. The customer may also contact you directly to discuss any specifics or ask questions about the service. Please ensure timely communication.
                                </li>
                            </ul>';
        }

        $vendor_html = '';

        $vendor_html .= '<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Account Registration:</title>
<style>
.logo {
    border-bottom: 4px solid #FFD413;
}
.logo img{
    width: 45%;
}
.wrapper {
    width: 100%;
    max-width:500px;
    margin:auto;
    font-size:14px;
    line-height:24px;
    font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;
    color:#555;
    padding:50px 0;
}   
.email_wrapper {
    width:100%;
    margin-top: 18px;
    font-size: 16px;
}
h2 {
    font-size: 26px;
    font-weight: bolder;
    margin: 0;
}
.btnlink {
    background: #0040E6;
    color: #fff !important;
    text-decoration: none;
    width: 100%;
    display: block;
    padding: 9px 0;
    text-align: center;
    font-size: 16px;
    border-radius: 9px;
}
.email_footer {
    width:100%;
    margin-top: 20px;
}
h3 {
    font-size: 20px;
    font-weight: bolder;
    margin: 0;
    border-bottom: 3px solid #6B7177;
    padding-bottom: 20px;
    margin-bottom: 15px;
}
.email_footer_div {
    width:100%;
    display: flex; 
}
.footer_left {
    width: 100px;
    float: left;
}
.footer_right {
    margin-left:10px;
    float: left;
}
.footer_right p{
    margin:0;
}
.footer_links {
    margin:10px 0;
}
.footer_links a {
    width: 100%;
    color: #555;
    display: inline-block;
}
</style>
</head>
<body>
<div class="wrapper" style="width: 100%;max-width:500px;margin:auto;
                            font-size:14px;line-height:24px;
                            font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
<div class="logo" style="float: inherit;border-bottom: 4px solid #FFD413;">
<img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;" >
</div>
<div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                   <p>  Dear ' . $vendor_detail->name . ',</p>
                   <p>We are excited to inform you that a new order has been assigned to you through VendorsCity! Below are the details for the upcoming service:</p>';
        $vendor_html .= '<p><strong>Order Details:</strong><br>';
        $vendor_html .= '<ul>
                                        <li><strong>Service: </strong> ' . Helper::servicename($order_item_data[0]->service_id) . '</li>
                                        <li><strong>Customer Name: </strong> ' . $customer_data->name . '</li>
                                         <li><strong>Customer Email: </strong> ' . $customer_data->email . '</li>
                                        <li><strong>Customer Contact: </strong> ' . $customer_data->mobile . '</li>
                                        <li><strong>Date Requested: </strong> ' . $booking_date . '</li>
                                        <li><strong>Payment Type: </strong> ' . $payment_mode . '</li>
                                    </ul>';
        $vendor_html .= '<p>Press “View Order” or login to your vendor portal to access all the customer details to complete the order.</p>';
        $vendor_html .= '<button class="btn btn-primary" type="button"
                    style="background-color: #1F6EEC;border-color: #1F6EEC;color: #fff;
                    padding: 10px 18px;border-radius: 11px;">
                    <a href="' . route("vendororder.index") . '" style="color:#fff !important; text-decoration:none !important;">View Order</a></button>';
        $vendor_html .= $html_append;
        $vendor_html .= '
                <p>Your prompt attention to this order is greatly appreciated. If you have any questions or need further assistance, feel free to reach out to us at any time.</p>
                <p>Thank you for your continued partnership and dedication to providing top-notch service.
                </p>
               </div>
               <div class="email_footer" style="width:100%;margin-top: 20px;">
                  <h3 style=" font-size: 20px;font-weight: bolder;margin: 0;
                            border-bottom: 3px solid #6B7177;padding-bottom: 20px;
                            margin-bottom: 15px;">The VendorsCity Team</h3>
                        <div class="email_footer_div" style=" width:100%;
                            display: flex; ">
                        <div class="footer_left" style="width: 100px;
                            float: left;">
                           <img style="width:70%;" src="' . asset("public/site/images/vcfaviconwap.png") . '"" >
                       </div>
                       <div class="footer_right"  style="margin-left:10px;
                                float: left;">
                           <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a></p>
                           <p style="margin:0;">VendorsCity Portal LLC</p>
                           <div class="footer_links" style=" margin:10px 0;">
                           <a href="' . url("/terms-of-service") . '" style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                           <a href="' . url("/privacy-policy") . '" style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                           <a href="' . url("/contact") . '" style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                           </div>
                           
                       </div>
                   </div>
               </div>
           </div>
       </body>
</html>';
        //echo $vendor_html;exit;
        $subservice_name = Helper::subservicename(strval($order_item_data[0]->subservice_id));
        $subject = "New " . $subservice_name . " Order Assigned on VendorsCity | Order No. " . $order_data->format_order_id . "
";
        $to = $vendor_detail->email;
        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        //$ccRecipients = [];
        // $ccRecipients = array();
        // $to = $request->email;
        Mail::send([], [], function ($message) use ($vendor_html, $to, $subject, $ccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($vendor_html);
        });

        $vendors_attribute = DB::table('vendors_attribute')->where('pid', $vendor_detail->id)->get();

        if (isset($vendors_attribute) && count($vendors_attribute) > 0) {

            foreach ($vendors_attribute as $vendors_attributeData) {

                if (!empty($vendors_attributeData->c_email)) {

                    $to = $vendors_attributeData->c_email;
                    $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];

                    Mail::send([], [], function ($message) use ($vendor_html, $to, $subject, $ccRecipients) {
                        $message->to($to);
                        $message->subject($subject);
                        foreach ($ccRecipients as $ccRecipient) {
                            $message->bcc($ccRecipient);
                        }
                        $message->html($vendor_html);
                    });
                }
            }
        }


        $customer_html = '';

        $customer_html .= '<!doctype html>
                <html lang="en">
                <head>
                <meta charset="utf-8">
                <title>Account Registration:</title>
                <style>
                .logo {
                border-bottom: 4px solid #FFD413;
                }
                .logo img{
                width: 45%;
                }
                .wrapper {
                width: 100%;
                max-width:500px;
                margin:auto;
                font-size:14px;
                line-height:24px;
                font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;
                color:#555;
                padding:50px 0;
                }   
                .email_wrapper {
                width:100%;
                margin-top: 18px;
                font-size: 16px;
                }
                h2 {
                font-size: 26px;
                font-weight: bolder;
                margin: 0;
                }
                .btnlink {
                background: #0040E6;
                color: #fff !important;
                text-decoration: none;
                width: 100%;
                display: block;
                padding: 9px 0;
                text-align: center;
                font-size: 16px;
                border-radius: 9px;
                }
                .email_footer {
                width:100%;
                margin-top: 20px;
                }
                h3 {
                font-size: 20px;
                font-weight: bolder;
                margin: 0;
                border-bottom: 3px solid #6B7177;
                padding-bottom: 20px;
                margin-bottom: 15px;
                }
                .email_footer_div {
                width:100%;
                display: flex; 
                }
                .footer_left {
                width: 100px;
                float: left;
                }
                .footer_right {
                margin-left:10px;
                float: left;
                }
                .footer_right p{
                margin:0;
                }
                .footer_links {
                margin:10px 0;
                }
                .footer_links a {
                width: 100%;
                color: #555;
                display: inline-block;
                }
                </style>
                </head>
                <body>
                <div class="wrapper" style="width: 100%;max-width:500px;margin:auto;
                            font-size:14px;line-height:24px;
                            font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
                <div class="logo" style="float: inherit;border-bottom: 4px solid #FFD413;">
                <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '""style="width: 40%;" >
                </div>
                <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                        <p>  Dear ' . $customer_data->name . ',</p>
                        <p>We’re happy to inform you that your service request has been confirmed and a trusted vendor has been assigned to complete your order through VendorsCity.</p>';

        $customer_html .= '
                        <p>Here are your service details:</p>
                        <ul>
                                            <li><strong>Order Number: </strong> ' . $order_data->format_order_id . '</li>
                                            <li><strong>Payment Type: </strong> ' . $payment_mode_customer . '</li>
                                            <li><strong>Service: </strong> ' . Helper::servicename($order_item_data[0]->service_id) . '</li>
                                            <li><strong>Assigned Vendor: </strong> ' . $vendor_detail->name . '</li>
                                                <li><strong>Vendor Contact: </strong> ' . $vendor_detail->mobile . '</li>
                                            </ul>';
        $customer_html .= '<p>The assigned vendor will contact you shortly to coordinate the final service details and confirm the exact timing.
If your order is Cash on Delivery, please make the payment directly to the vendor upon service completion.</p>';

        $customer_html .= '
                        <h5 style="font-size: 14px;margin: 0;">Important Notes:</h5> 
                            <ul><li>
                            Please ensure someone is available at the location during the scheduled time.</li>
                            <li>For any changes or special requests, feel free to discuss them directly with the vendor.</li>
                            <li>If you face any issues or need further assistance, our support team is always here to help — reach us at <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a> or call us at 056 VENDORS (836 3677).</li>
                            </ul>
                        <p>Thank you for choosing VendorsCity!
                        </p>
                        <p>We appreciate your trust and look forward to ensuring your service experience is smooth and satisfying.
                </p>
                    </div>
                     <div class="email_footer" style="width:100%;margin-top: 20px;">
                  <h3 style=" font-size: 20px;font-weight: bolder;margin: 0;
                            border-bottom: 3px solid #6B7177;padding-bottom: 20px;
                            margin-bottom: 15px;">The VendorsCity Team</h3>
                        <div class="email_footer_div" style=" width:100%;
                            display: flex; ">
                        <div class="footer_left" style="width: 100px;
                            float: left;">
                           <img style="width:70%;" src="' . asset("public/site/images/vcfaviconwap.png") . '"" >
                       </div>
                       <div class="footer_right"  style="margin-left:10px;
                                float: left;">
                           <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                           <p style="margin:0;">VendorsCity Portal LLC</p>
                           <div class="footer_links" style=" margin:10px 0;">
                           <a href="' . url("/terms-of-service") . '" style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                           <a href="' . url("/privacy-policy") . '" style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                           <a href="' . url("/contact") . '" style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                           </div>
                           
                       </div>
                   </div>
               </div>
                </div>
                </body>
                </html>';
        //echo $customer_html;exit;


        // $subject = "Vendor Assigned for Your ".$order_item_data[0]->service_name."  Order with VendorsCity | Order No. ".$order_data->format_order_id."";

        $subservice_name = Helper::subservicename(strval($order_item_data[0]->subservice_id));
        $subject = $subservice_name . " Has Been Confirmed – Vendor Assigned by VendorsCity";
        $to = $customer_data->email;
        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        // $ccRecipients = [];
        // $ccRecipients = array();
        // $to = $request->email;
        Mail::send([], [], function ($message) use ($customer_html, $to, $subject, $ccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($customer_html);
        });

        $data_update = [
            'order_status' => 'PA',
            //'updated_at' => now(),
        ];

        DB::table('ci_orders')
            ->where('order_id', $order_id)
            ->update($data_update);

        $this->success_whatsapp_message_vendorassign_customer($vendor_id, $order_id);
    }

    function success_whatsapp_message_vendorassign_customer($vendor_id, $order_id)
    {


        $orderdata = DB::table('ci_orders')->where('order_number', $order_id)->first();

        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_id)->get();

        $vendorData = DB::table('users')->where('id', $vendor_id)->first();
        $UserData = DB::table('frontloginregisters')->where('id', $orderdata->user_id)->first();



        $subservice_name = Helper::subservicename($order_item_data[0]->subservice_id);

        $userName = $UserData->name;

        $date = $order_item_data[0]->bookingdate ?? "";
        $month = $order_item_data[0]->month ?? "";
        $year = $order_item_data[0]->bookingyear ?? "";

        if ($date != '' && $month != '' && $year != '') {
            $booking_date = $month . ' ' . $date . ', ' . $year;
        } else {
            $booking_date = "-";
        }

        $vendors_attribute = DB::table('vendors_attribute')->where('pid', $vendorData->id)->get();


        $phone = $vendorData->country_code . '' . $vendorData->mobile;
        $service_name = Helper::servicename($order_item_data[0]->service_id);
        //$booking_date = '2023-10-10';
        $booking_time = Helper::timeslotname(strval($order_item_data[0]->time_slot));

        if (isset($vendorData->country_code) && isset($vendorData->mobile)) {

            /* $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{"messages":[{"to":"' . $phone . '","content":{"templateName":"vendor_booking_assigned","language":"en","templateData":{"body":{"placeholders":["' . $userName . '","' . $subservice_name . '","' . $booking_date . '","' . $booking_time . '"]},"buttons":[{"type":"URL"}]}}}]}',
                CURLOPT_HTTPHEADER => array(
                    'accept: application/json',
                    'content-type: application/json',
                    'Authorization: key_uTZeOXQPMd'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl); */

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '
					{
					"messages": [
						{
						"content": {
							"language": "en",
							"templateData": {
							"body": {
								"placeholders": [
								"' . $userName . '",
								"' . $subservice_name . '",
								"' . $booking_date . '",
								"' . $booking_time . '"
								]
							}
							},
							"templateName": "vendor_booking_assigned"
						},
						"from": "+971503204846",
						"to": "' . $phone . '"
						}
					]
					}
					',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: key_uTZeOXQPMd',
                    'accept: application/json',
                    'content-type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            $response = json_decode($response, true);
        }

        if (isset($vendors_attribute) && count($vendors_attribute) > 0) {

            foreach ($vendors_attribute as $vendors_attributeData) {

                $phone = $vendors_attributeData->country_code . '' . $vendors_attributeData->telephone;

                if (isset($vendors_attributeData->country_code) && isset($vendors_attributeData->telephone)) {

                    /* $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => '{"messages":[{"to":"' . $phone . '","content":{"templateName":"vendor_booking_assigned","language":"en","templateData":{"body":{"placeholders":["' . $userName . '","' . $subservice_name . '","' . $booking_date . '","' . $booking_time . '"]},"buttons":[{"type":"URL"}]}}}]}',
                        CURLOPT_HTTPHEADER => array(
                            'accept: application/json',
                            'content-type: application/json',
                            'Authorization: key_uTZeOXQPMd'
                        ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl); */

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => '
					{
					"messages": [
						{
						"content": {
							"language": "en",
							"templateData": {
							"body": {
								"placeholders": [
								"' . $userName . '",
								"' . $subservice_name . '",
								"' . $booking_date . '",
								"' . $booking_time . '"
								]
							}
							},
							"templateName": "vendor_booking_assigned"
						},
						"from": "+971503204846",
						"to": "' . $phone . '"
						}
					]
					}
					',
                        CURLOPT_HTTPHEADER => array(
                            'Authorization: key_uTZeOXQPMd',
                            'accept: application/json',
                            'content-type: application/json'
                        ),
                    ));

                    $response = curl_exec($curl);

                    $response = json_decode($response, true);
                }
            }
        }



        /* customer message */
        $Customercountry_code = $UserData->country_code;
        $Customermobile = $UserData->mobile;
        $customer_name = $UserData->name;

        $Customerphone = $Customercountry_code . '' . $Customermobile;
        $url = $order_id;

        if (isset($UserData->country_code) && isset($UserData->mobile)) {

            /* $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{"messages":[{"to":"' . $Customerphone . '","content":{"templateName":"service_confirmation_vc","language":"en","templateData":{"body":{"placeholders":["' . $customer_name . '","' . $subservice_name . '","' . $booking_date . '","' . $booking_time . '"]},"buttons":[{"type":"URL","parameter":"' . $url . '"}]}}}]}',
                CURLOPT_HTTPHEADER => array(
                    'accept: application/json',
                    'content-type: application/json',
                    'Authorization: key_uTZeOXQPMd'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl); */

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '
            {
            "messages": [
                {
                "content": {
                    "language": "en",
                    "templateData": {
                    "body": {
                        "placeholders": [
                        "' . $customer_name . '",
                        "' . $subservice_name . '",
                        "' . $booking_date . '",
                        "' . $booking_time . '"
                        ]
                    },
                    "buttons": [
                        {
                        "type": "URL",
                        "parameter": "' . $url . '"
                        }
                    ]
                    },
                    "templateName": "service_confirmation_vc"
                },
                "from": "+971503204846",
                "to": "' . $Customerphone . '"
                }
            ]
            }
            ',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: key_uTZeOXQPMd',
                    'accept: application/json',
                    'content-type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $response = json_decode($response, true);
        }
    }

    function reject_order_vendor(Request $request)
    {

        // echo"<pre>";print_r($request->all());exit;
        $order_id = $request->reject_order_id;
        $vendor_id = Auth::user()->id;

        $data['order_id'] = $order_id;
        $data['vendor_id'] = $vendor_id;
        $data['accept_reject'] = 1;
        $data['reject_reason'] = $request->reject_reason;
        $data['added_date'] = date('Y-m-d');

        DB::table('vendor_order_accept_reject')->insert($data);

        $this->booking_reject_mail($order_id, $vendor_id);

        return redirect()->route('vendor-all-order')->with('success', 'Booking Rejected Successfully');
        //echo"<pre>";print_r($request->all());echo"";exit;
    }

    public function booking_reject_mail($order_id, $vendor_id)
    {


        $vendor_detail = DB::table('users')->where('vendor', 1)->where('id', $vendor_id)->first();
        $order_data = DB::table('ci_orders')->where('order_id', $order_id)->first();
        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_id)->get()->toArray();
        $customer_data = DB::table('frontloginregisters')->where('id', $order_data->user_id)->first();

        $date = $order_item_data[0]->bookingdate ?? "";
        $month = $order_item_data[0]->month ?? "";
        $year = $order_item_data[0]->bookingyear ?? "";

        if ($date != '' && $month != '' && $year != '') {
            $booking_date = $month . ' ' . $date . ', ' . $year;
        } else {
            $booking_date = "-";
        }

        // ✅ HTML Start (reused from accept)
        $vendor_html = '
        <!doctype html>
        <html lang="en">
        <head>
        <meta charset="utf-8">
        <title>Order Rejected Notification</title>
        <style>
            .logo { border-bottom: 4px solid #FFD413; }
            .logo img { width: 45%; }
            .wrapper { width: 100%; max-width:500px; margin:auto; font-size:14px; line-height:24px;
                    font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; color:#555; padding:50px 0; }
            .email_wrapper { width:100%; margin-top: 18px; font-size: 16px; }
            h2 { font-size: 26px; font-weight: bolder; margin: 0; }
            .btnlink { background: #E60E0E; color: #fff !important; text-decoration: none; width: 100%; display: block;
                    padding: 9px 0; text-align: center; font-size: 16px; border-radius: 9px; }
            .email_footer { width:100%; margin-top: 20px; }
            h3 { font-size: 20px; font-weight: bolder; margin: 0; border-bottom: 3px solid #6B7177; padding-bottom: 20px;
                margin-bottom: 15px; }
            .email_footer_div { width:100%; display: flex; }
            .footer_left { width: 100px; float: left; }
            .footer_right { margin-left:10px; float: left; }
            .footer_right p { margin:0; }
            .footer_links { margin:10px 0; }
            .footer_links a { width: 100%; color: #555; display: inline-block; }
        </style>
        </head>
        <body>
        <div class="wrapper">
            <div class="logo">
                <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '" style="width: 40%;" >
            </div>
            <div class="email_wrapper">
                <p>Dear ' . $vendor_detail->name . ',</p>
                <p>We confirm that you have <strong style="color:red;">rejected</strong> the following service order on VendorsCity:</p>

                <ul>
                    <li><strong>Order Number: </strong> ' . $order_data->format_order_id . '</li>
                    <li><strong>Service: </strong> ' . Helper::servicename($order_item_data[0]->service_id) . '</li>
                    <li><strong>Customer Name: </strong> ' . $customer_data->name . '</li>
                    <li><strong>Date Requested 12: </strong> ' . $booking_date . '</li>
                </ul>

                <p>This order will now be reallocated to another vendor.</p>
                <p>If this was done by mistake, please contact the VendorsCity support team immediately.</p>

                <a href="' . url('/vendor') . '" class="btnlink" style="background-color: #E60E0E;">Go to Vendor Dashboard</a>

                <p>Thank you for keeping your vendor portal updated. Your timely responses help us ensure a smooth customer experience. </p>
            </div>
            

            <div class="email_footer">
                <h3>The VendorsCity Team</h3>
                <div class="email_footer_div">
                    <div class="footer_left">
                        <img style="width:70%;" src="' . asset("public/site/images/vcfaviconwap.png") . '">
                    </div>
                    <div class="footer_right">
                        <p>Questions? Email <a href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a></p>
                        <p>VendorsCity Portal LLC</p>
                        <div class="footer_links">
                            <a href="' . url("/terms-of-service") . '">Terms of Use</a>
                            <a href="' . url("/privacy-policy") . '">Privacy Policy</a>
                            <a href="' . url("/contact") . '">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </body>
        </html>';

        // ✅ Send to admin or customer
        $subject = "Vendor Rejected " . $order_item_data[0]->service_name . " Order | Order No. " . $order_data->format_order_id;
        $to = $vendor_detail->email; // or $customer_data->email if you want to notify customer too
        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        // $ccRecipients = [];

        Mail::send([], [], function ($message) use ($vendor_html, $to, $subject, $ccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($vendor_html);
        });
    }

    public function rejected_bookings()
    {
        $vendors_id = Auth::user()->id;

        // Get vendor details
        $vendorData = DB::table('users')->where('id', $vendors_id)->first();

        // Convert vendor serviceList to array
        $serviceList = [];
        if (!empty($vendorData->serviceList)) {
            $serviceList = explode(',', $vendorData->serviceList);
        }

        // 🔹 Get all REJECTED order_ids by this vendor (accept_reject = 1)
        $rejectedOrders = DB::table('vendor_order_accept_reject')
            ->where('vendor_id', $vendors_id)
            ->where('accept_reject', 1)
            ->pluck('order_id')
            ->toArray();

        // 🔹 Fetch all orders that were rejected by vendor
        $orders = DB::table('ci_orders as o')
            ->leftJoin('frontloginregisters as f', 'o.user_id', '=', 'f.id')
            ->whereIn('o.order_id', $rejectedOrders)
            ->where('o.is_delete', '0')
            ->select(
                'o.*',
                'f.email as user_email',
                'f.name as user_name',
                'f.mobile as user_mobile'
            )
            ->orderByDesc('o.order_id')
            ->get()
            ->map(function ($order) use ($serviceList) {
                // ✅ Fetch only order items that match vendor's service list
                $order->items = DB::table('ci_order_item as i')
                    ->where('i.order_id', $order->order_id)
                    ->whereIn('i.service_id', $serviceList)
                    ->select('i.*')
                    ->get();

                return $order;
            })
            // ✅ Only keep orders that have at least one matching item
            ->filter(function ($order) {
                return $order->items->isNotEmpty();
            })
            ->values();

        $data['vendororders_list'] = $orders;

        //echo"<pre>";print_r($data);exit;

        return view('admin.list_vendor_all_rejected_order', $data);
    }

    function rejected_booking_details($order_id)
    {


        // Fetch the specific order with user info
        $order = DB::table('ci_orders as o')
            ->leftJoin('frontloginregisters as f', 'o.user_id', '=', 'f.id')
            ->where('o.is_delete', '0')
            ->where('o.order_id', $order_id) // filter by specific order
            ->where(function ($q) {
                $q->where('o.vendor_id', 0)
                    ->orWhere('o.vendor_id', '')
                    ->orWhereNull('o.vendor_id');
            })
            ->select(
                'o.*',
                'f.email as user_email',
                'f.name as user_name',
                'f.mobile as user_mobile'
            )
            ->first(); // get single order

        // If order not found, redirect back or show 404
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }

        // Fetch only order items that match vendor's service list
        $order->items = DB::table('ci_order_item as i')
            ->where('i.order_id', $order->order_id)
            //->whereIn('i.service_id', $serviceList)
            ->select('i.*')
            ->get();

        // Pass data to view
        $data['order'] = $order;

        //echo "<pre>";print_r($data);echo"</pre>";exit;  
        return view('admin.view_vendor_rejected_booking_details', $data);

        //echo "<pre>";print_r($orders);echo"</pre>";exit; 
    }

    public function storage_vendor_listing($order_id = '', $status = '')
    {
        $vendors_id = Auth::user()->id;
        $data['error'] = '';

        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )
            ->where('ci_orders.order_from', 1) // This already excludes 0 and 2
            ->where('ci_orders.vendor_id', $vendors_id);

        if (!empty($order_id)) {
            $query->where('ci_orders.order_id', $order_id);
        }

        if (!empty($status)) {
            if ($status == 'SUCCESS' || $status == 'FAILED' || $status == 'Success') {
                $query->where('ci_orders.payment_status', $status);
            } else {
                $query->where('ci_orders.order_status', $status);
            }
        }

        $query->orderBy('ci_orders.order_id', 'DESC');
        $allOrders = $query->get();

        $filteredOrders = [];

        foreach ($allOrders as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_number)
                ->where('service_id', 44)
                ->get();

            if ($itemList->isEmpty()) {
                continue; // Skip orders that don't have service_id 48
            }

            $total = 0;
            foreach ($itemList as $item) {
                $product = DB::table('packages')
                    ->where('id', $item->package_id)
                    ->first();

                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }

                $total += $product_item_price * $item->package_quantity;
            }

            $order->items = $itemList;
            $filteredOrders[] = $order;
        }

        $data['vendororders_list'] = $filteredOrders;

        // echo "<pre>";
        // print_r($data);
        // exit;
        return view('admin.list_vendororder', $data);
    }
}
