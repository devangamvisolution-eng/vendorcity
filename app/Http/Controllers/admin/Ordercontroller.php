<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Helper as HelpersHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Order;
use App\Models\admin\VerifyBuyPackage;
use App\Models\admin\Vehicles;
use App\Models\admin\ModelModule;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\front\Ciorder;
use App\Models\front\CiorderItem;
use App\Models\front\CiShippingAddress;
use Illuminate\Support\Facades\URL;


class Ordercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {

        //     $user = Auth::user();
        //     if ($user->role_id != 1) {
        //         abort(404);
        //     }
        //     return $next($request);
        // });

    }
    public function index($order_id = '', $status = '')
    {
        $data['error'] = '';
        //$data['subscribe_data'] = Subscribe::orderBy('id','DESC')->get();    
        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )

            ->whereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('ci_order_item')
                    ->whereColumn('ci_order_item.order_id', 'ci_orders.order_id')
                    ->where('ci_order_item.service_id', 30);
            });


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

        // Get distinct orders where service_id is 45
        $orderList = $query->get();

        foreach ($orderList as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('service_id', 30)
                ->get();

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

            // Attach the items and subtotal to the order object
            $order->items = $itemList;
            //$order->sub_total = $total;
        }

        $data['orders_list'] = $orderList;

        // echo "<pre>";
        // print_r($data);
        // exit;
        return view('admin.list_order', $data);
    }
    public function cleaning_package_order($order_id = '', $status = '')
    {
        $data['error'] = '';
        // First, fetch distinct orders
        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )->whereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('ci_order_item')
                    ->whereColumn('ci_order_item.order_id', 'ci_orders.order_id')
                    ->where('ci_order_item.service_id', 45);
            });
        $query = $query->where('order_from', '!=', 2);
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
        // Get distinct orders where service_id is 45
        $orderList = $query->get();
        // Now, for each order, fetch its items
        foreach ($orderList as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('service_id', 45)
                ->get();
            $total = 0;
            // echo"<pre>";print_r($itemList);echo"</pre>";
            foreach ($itemList as $item) {
                $product = DB::table('packages')
                    ->where('id', $item->package_id)
                    ->first();
                // echo"<pre>";print_r($product);echo"</pre>";exit;

                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }
                $total += $product_item_price * $item->package_quantity;
            }
            // Attach the items and subtotal to the order object
            $order->items = $itemList;
            //$order->sub_total = $total;
        }
        $data['orders_list'] = $orderList;
        // echo"<pre>";print_r($data);echo"</pre>";exit;
        return view('admin.list_order', $data);
    }



    public function handyman_service_order($order_id = '', $status = '')
    {
        $data['error'] = '';
        // First, fetch distinct orders
        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )->whereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('ci_order_item')
                    ->whereColumn('ci_order_item.order_id', 'ci_orders.order_id')
                    ->where('ci_order_item.service_id', 34);
            });
        //$query = $query->where('order_from','!=',2); 
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
        // Get distinct orders where service_id is 71
        $orderList = $query->get();
        // Now, for each order, fetch its items
        foreach ($orderList as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('service_id', 34)
                ->get();
            $total = 0;
            // echo"<pre>";print_r($itemList);echo"</pre>";
            foreach ($itemList as $item) {
                $product = DB::table('packages')
                    ->where('id', $item->package_id)
                    ->first();
                // echo"<pre>";print_r($product);echo"</pre>";exit;

                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }
                $total += $product_item_price * $item->package_quantity;
            }
            // Attach the items and subtotal to the order object
            $order->items = $itemList;
            //$order->sub_total = $total;
        }
        $data['orders_list'] = $orderList;
        // echo"<pre>";print_r($data);echo"</pre>";exit;
        return view('admin.list_order', $data);
    }

    public function car_inspection_order($order_id = '', $status = '')
    {
        $data['error'] = '';
        // First, fetch distinct orders
        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )->whereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('ci_order_item')
                    ->whereColumn('ci_order_item.order_id', 'ci_orders.order_id')
                    ->where('ci_order_item.service_id', 50)
                    ->where('ci_order_item.subservice_id', 92);
            });
        $query = $query->where('order_from', '!=', 2);
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
        // Get distinct orders where service_id is 71
        $orderList = $query->get();
        // Now, for each order, fetch its items
        foreach ($orderList as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('service_id', 50)
                ->get();
            $total = 0;
            // echo"<pre>";print_r($itemList);echo"</pre>";
            foreach ($itemList as $item) {
                $product = DB::table('packages')
                    ->where('id', $item->package_id)
                    ->first();
                // echo"<pre>";print_r($product);echo"</pre>";exit;

                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }
                $total += $product_item_price * $item->package_quantity;
            }
            // Attach the items and subtotal to the order object
            $order->items = $itemList;
            $order->sub_total = $total;
        }
        $data['orders_list'] = $orderList;
        //echo"<pre>";print_r($data['orders_list']);echo"</pre>";exit;

        $data['subservice_timeslot_price'] = DB::table('time_slots')
            ->leftjoin('subservice_timeslot_price', 'time_slots.id', '=', 'subservice_timeslot_price.time_slot_id')
            ->where('subservice_timeslot_price.service_id', 50)
            ->where('subservice_timeslot_price.subservice_id', 92)
            ->where('subservice_timeslot_price.is_active', 1)
            ->select('time_slots.*', 'subservice_timeslot_price.*')
            ->get();


        return view('admin.list_inspection_order', $data);
    }

    function car_inpsection_form(request $request)
    {
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $order_id = $request->car_inpsection_order;
        $inspection_date = $request->update_inspection_date;
        $inspection_time = $request->update_inspection_time;

        $updateorder = DB::table('ci_orders')
            ->where('order_id', $order_id)
            ->update(['moving_date' => $inspection_date]);

        $date = Carbon::parse($inspection_date);
        $booking_date = $date->day;
        $monthName = $date->format('F');
        $year = $date->year;

        $updateorderitem = DB::table('ci_order_item')
            ->where('order_id', $order_id)
            ->update(['bookingdate' => $booking_date, 'month' => $monthName, 'bookingyear' => $year, 'end_date' => $inspection_date, 'time_slot' => $inspection_time]);

        return redirect()->route('car-inspection-order')->with('success', 'Inspection Date & Time Updated Successfully');
    }
    public function car_inspection_document_upload($id)
    {
        // echo $id;

        $data['ordredocument'] = DB::table('ci_order_item')
            ->where('order_id', $id)
            ->first();
        // echo"<pre>";print_r($data['ordredocument']);echo"</pre>";exit;


        return view('admin.edit_document', $data);
    }
    public function car_inspection_document_upload_store(request $request)
    {


        if ($request->hasfile('attachment1') != '') {
            $image = $request->file('attachment1');
            $remove_space = str_replace(' ', '-', $image->getClientOriginalName());
            $data['image'] = time() . $remove_space;

            $destinationPath = public_path('upload/documents/');
            $image->move($destinationPath, $data['image']);
            $image = $data['image'];
            $data['verifybuy_documents']  = $image;
        }
        $order_id = $request->id;
        $res = DB::table('ci_order_item')
            ->where('order_id', $order_id)
            ->update(['verifybuy_documents' => $data['verifybuy_documents']]);

        return redirect()->route('car-inspection-document-upload', $order_id)->with('success', 'Document Uploaded Successfully.');
    }



    public function painting_service_order($order_id = '', $status = '')
    {
        $data['error'] = '';
        // First, fetch distinct orders
        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )
            ->where('order_from', '=', 2)
            ->where('order_from', '!=', 0)
            ->where('order_from', '!=', 1);

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

        // Get distinct orders where service_id is 45
        $orderList = $query->get();

        // Fetch items for each order
        foreach ($orderList as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('subservice_id', 47)
                ->get();

            $total = $itemList->sum('price'); // Calculate total if price field exists

            // Attach items and subtotal to the order object
            $order->items = $itemList;
            // $order->sub_total = $total;
        }

        $data['orders_list'] = $orderList;
        // echo"<pre>";print_r($data['orders_list']);echo"</pre>";exit;
        return view('admin.list_order', $data);
    }
    public function salon_spa_order($order_id = '', $status = '')
    {
        $data['error'] = '';
        // First, fetch distinct orders
        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )->whereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('ci_order_item')
                    ->whereColumn('ci_order_item.order_id', 'ci_orders.order_id')
                    ->where('ci_order_item.service_id', 48);
            });
        $query = $query->where('order_from', '!=', 2);
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
        // Get distinct orders where service_id is 45
        $orderList = $query->get();
        // Now, for each order, fetch its items
        foreach ($orderList as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('service_id', 48)
                ->get();
            $total = 0;
            // echo"<pre>";print_r($itemList);echo"</pre>";
            foreach ($itemList as $item) {
                $product = DB::table('packages')
                    ->where('id', $item->package_id)
                    ->first();
                // echo"<pre>";print_r($product);echo"</pre>";exit;

                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }
                $total += $product_item_price * $item->package_quantity;
            }
            // Attach the items and subtotal to the order object
            $order->items = $itemList;
            // $order->sub_total = $total;
        }
        $data['orders_list'] = $orderList;
        // echo"<pre>";print_r($data);echo"</pre>";exit;
        return view('admin.list_order', $data);
    }

    public function pest_control_order($order_id = '', $status = '')
    {
        $data['error'] = '';
        // First, fetch distinct orders
        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )->whereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('ci_order_item')
                    ->whereColumn('ci_order_item.order_id', 'ci_orders.order_id')
                    ->where('ci_order_item.service_id', 47);
            });
        $query = $query->where('order_from', '!=', 2);
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
        // Get distinct orders where service_id is 45
        $orderList = $query->get();
        // Now, for each order, fetch its items
        foreach ($orderList as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('service_id', 47)
                ->get();
            $total = 0;
            // echo"<pre>";print_r($itemList);echo"</pre>";
            foreach ($itemList as $item) {
                $product = DB::table('packages')
                    ->where('id', $item->package_id)
                    ->first();
                // echo"<pre>";print_r($product);echo"</pre>";exit;

                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }
                $total += $product_item_price * $item->package_quantity;
            }
            // Attach the items and subtotal to the order object
            $order->items = $itemList;
            // $order->sub_total = $total;
        }
        $data['orders_list'] = $orderList;
        // echo"<pre>";print_r($data);echo"</pre>";exit;
        return view('admin.list_order', $data);
    }

    function detail($order_id)
    {
        $data['error'] = '';
        $query = Ciorder::leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->leftJoin('ci_shipping_address', 'ci_orders.order_id', '=', 'ci_shipping_address.order_id')
            ->select('frontloginregisters.email as user_email', 'frontloginregisters.name as user_name', 'frontloginregisters.mobile as user_mobile', 'frontloginregisters.country_code as user_country_code', 'ci_orders.*',  'ci_shipping_address.*');
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
                $order->items = $itemList;
                // if ($order->order_from == 1 && $order->order_from != 2) {
                // if ($order->order_from == 1 && $order->order_from != 2) {
                //     $order->sub_total = $order->sub_total;
                // } else {
                //     $order->sub_total = $total;
                // }
            } else {
                foreach ($itemList as $item) {
                    $product = DB::table('packages')
                        ->where('id', $item->package_id)
                        ->first();
                }
                $order->items = $itemList;
            }
        }
        $orderList;
        $data['order'] = $orderList[0];

        // echo "<pre>";print_r($data);exit;
        return view('admin.view_order', $data);
    }
    public function destroy(Request $request)
    {
        $delete_id = $request->selected;

        DB::table('ci_orders')->where('order_id', $delete_id)->update(['is_delete' => '1']);

        return redirect()->route('cleaning_package_order')->with('success', 'Order Deleted Successfully');
    }

    function set_end_date()
    {
        $end_date = $_POST['end_date'];
        $order_id = $_POST['order_id'];
        if (empty($end_date) || empty($order_id)) {
            return response()->json(['status' => 0, 'message' => 'End date or order ID is missing.']);
        } else {
            DB::table('ci_order_item')
                ->where('order_id', $order_id)
                ->update(['end_date' => $end_date]);

            return response()->json(['status' => 1, 'message' => 'End date order ID is updated successfully.', 'order_id' => $order_id]);
        }
    }

    function assign_vendor()
    {

        $order_id = $_POST['order_id'];

        $ci_order_data = DB::table('ci_orders')
            ->where('order_id', $order_id)
            ->first();
        $ci_order_item_data = DB::table('ci_order_item')
            ->where('order_id', $order_id)
            ->first();

        $currentDate = now();

        $html = '<select id="vendor_id" name="vendor_id"  class="form-control">';

        $html .= "<option value=''>Select Vendor</option>";

        $vendor_data = DB::table('users')
            ->whereRaw("FIND_IN_SET(?, serviceList)", [$ci_order_item_data->service_id])
            ->where('vendor', 1)
            ->where('is_active', 0)
            ->get()->toArray();

        foreach ($vendor_data as $vendor_data_new) {
            if ($vendor_data != '') {

                if ($ci_order_data->vendor_id == $vendor_data_new->id) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }


                $html .= "<option value='" . $vendor_data_new->id . "'" . $selected . ">" . $vendor_data_new->name . "</option>";
            }
        }

        $html .= "</select>";
        $html .= "<input type='hidden' name='order_id' id='order_id' value='" . $order_id . "'/>";
        echo $html;
    }

    function assign_vendor_car()
    {
        $order_id = $_POST['order_id'];

        $ci_order_data = DB::table('ci_orders')
            ->where('order_id', $order_id)
            ->first();
        $ci_order_item_data = DB::table('ci_order_item')
            ->where('order_id', $order_id)
            ->first();

        $currentDate = now();

        $html = '<select id="vendor_id_car" name="vendor_id"  class="form-control" onchange="checkcar_vendor_available(' . $order_id . ')">';

        $html .= "<option value=''>Select Vendor</option>";

        $vendor_data = DB::table('users')
            ->whereRaw("FIND_IN_SET(?, serviceList)", [$ci_order_item_data->service_id])
            ->where('vendor', 1)
            ->where('is_active', 0)
            ->get()->toArray();

        foreach ($vendor_data as $vendor_data_new) {
            if ($vendor_data != '') {

                if ($ci_order_data->vendor_id == $vendor_data_new->id) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }


                $html .= "<option value='" . $vendor_data_new->id . "'" . $selected . ">" . $vendor_data_new->name . "</option>";
            }
        }

        $html .= "</select>";
        $html .= "<input type='hidden' name='order_id' id='order_id' value='" . $order_id . "'/>";
        echo $html;
    }

    function checkcar_vendor_available(Request $request)
    {
        $order_id   = $request->order_id;
        $vendor_id  = $request->vendor_id_car;

        // 1. Get order item (date & slot info)
        $orderItem = DB::table('ci_order_item')
            ->where('order_id', $order_id)
            ->first();

        if (!$orderItem) {
            return response()->json(['status' => false, 'message' => 'Order item not found']);
        }

        //     $booked_date = date(
        //     'Y-m-d',
        //     strtotime($orderItem->bookingyear . '-' . $orderItem->month . '-' . $orderItem->bookingdate)
        // );
        $booked_date = Carbon::createFromFormat(
            'Y-F-j',
            $orderItem->bookingyear . '-' . $orderItem->month . '-' . $orderItem->bookingdate
        )->format('Y-m-d');

        $time_slot   = $orderItem->time_slot;
        // echo"<pre>";print_r($orderItem);echo"</pre>";
        // echo $booked_date;
        // echo $time_slot;exit;




        // 2. Check vendor availability
        $alreadyBooked = DB::table('carwashvendor_bookedtimeslot')
            ->where('vendor_id', $vendor_id)
            ->where('booked_date', $booked_date)
            ->where('timeslot_id', $time_slot)
            ->exists();

        if ($alreadyBooked) {
            return response()->json(['status' => false, 'message' => 'Vendor not available on this date & time slot']);
        }

        if (isset($vendor_id) && $vendor_id != '') {

            //3. Insert into vendor booked timeslot
            DB::table('carwashvendor_bookedtimeslot')->insert([
                'service_id'    => $orderItem->service_id ?? null,
                'subservice_id' => $orderItem->subservice_id ?? null,
                'vendor_id'     => $vendor_id,
                'timeslot_id'   => $time_slot,
                'booked_date'   => $booked_date,
            ]);

            // 4. Assign vendor in ci_orders
            DB::table('ci_orders')->where('order_id', $order_id)->update([
                'vendor_id' => $vendor_id
            ]);

            //$this->send_carwash_vendor_assign_email($order_id,$vendor_id);

        } else {
            return response()->json(['status' => false, 'message' => 'Please Select Vendor First']);
        }



        return response()->json(['status' => true, 'message' => 'Vendor assigned successfully']);
    }

    function send_carwash_vendor_assign_email($order_id, $vendor_id)
    {

        $vendor_detail = DB::table('users')->where('vendor', 1)->where('id', $vendor_id)->first();
        $order_data = DB::table('ci_orders')
            ->where('order_id', $order_id)->first();
        $order_item_data = DB::table('ci_order_item')
            ->where('order_id', $order_id)->get()->toArray();
        $customer_data = DB::table('frontloginregisters')
            ->where('id', $order_data->user_id)->first();


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

        $subject = "New " . $order_item_data[0]->service_name . " Order Assigned on VendorsCity | Order No. " . $order_data->format_order_id . "";

        $to = $vendor_detail->email;
        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        Mail::send([], [], function ($message) use ($vendor_html, $to, $subject, $ccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($vendor_html);
        });

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
                        <p>We are pleased to inform you that a vendor has been assigned to fulfill your service order with VendorsCity. Here are the details:</p>';

        $customer_html .= '<ul>
                                            <li><strong>Order Number: </strong> ' . $order_data->format_order_id . '</li>
                                            <li><strong>Payment Type: </strong> ' . $payment_mode_customer . '</li>
                                            <li><strong>Service: </strong> ' . Helper::servicename($order_item_data[0]->service_id) . '</li>
                                            <li><strong>Vendor Name: </strong> ' . $vendor_detail->name . '</li>
                                                <li><strong>Contact Information: </strong> ' . $vendor_detail->mobile . '</li>
                                            </ul>';
        $customer_html .= '<p>The vendor will reach out to you shortly to finalize the service details and arrange for scheduling. If this is a cash-on-delivery order, please make the payment directly to the vendor upon completion of the service.</p>';

        $customer_html .= '
                        <p>If you have any questions or need further assistance, feel free to reach out to us at <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a> or call us at 056 VENDORS (836 3677).
                        </p>
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

        $subject = "Vendor Assigned for Your " . $order_item_data[0]->service_name . "  Order with VendorsCity | Order No. " . $order_data->format_order_id . "";
        $to = $customer_data->email;
        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];

        Mail::send([], [], function ($message) use ($customer_html, $to, $subject, $ccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($customer_html);
        });
    }

    function cleaner_assign_form()
    {
        $order_id = $_POST['order_id'];
        $cleaner_id = $_POST['cleaner'];

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
            return response()->json(['status' => 0, 'message' => 'Crew already assigned for this time slot.', 'order_id' => $order_id]);
        }


        DB::table('ci_order_item')
            ->where('order_id', $order_id)
            ->update(['cleaner_id' => $cleaner_id]);

        // Ensure proper JSON response
        return response()->json(['status' => 1, 'order_id' => $order_id]);
    }


    function multi_cleaner_time_slot()
    {

        $order_id = $_POST['order_id'];
        $cleaner = $_POST['cleaner'];

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

            // echo"<pre>";print_r($availableCleaners);echo"</pre>";
            // echo"<pre>";print_r($notAvailableCleaners);echo"</pre>";exit;

            // You now have two arrays: $availableCleaners and $notAvailableCleaners
            return response()->json([
                'order_id' => $order_id,
                'available_cleaners' => $availableCleaners,
                'not_available_cleaners_id' => $notAvailableCleaners,
                'not_available_cleaners' => Helper::cleanername_new($notAvailableCleaners)
            ]);
        }
    }
    function multi_cleaner_assign_form()
    {
        $order_id = $_POST['order_id'];
        $cleaner_ids = $_POST['cleaner'];

        if (!empty($order_id) && !empty($cleaner_ids) && is_array($cleaner_ids)) {

            $cleaner_ids_string = implode(',', $cleaner_ids);
            DB::table('ci_order_item')
                ->where('order_id', $order_id)
                ->update(['cleaner_id' => $cleaner_ids_string]);
        }
        // Ensure proper JSON response
        return response()->json(['status' => 1, 'order_id' => $order_id]);
    }

    function salesperson_assign_form()
    {
        $order_id = $_POST['order_id'];
        $salesperson_id = $_POST['salesperson_id'];

        if (!empty($order_id) && !empty($salesperson_id)) {

            DB::table('ci_order_item')
                ->where('order_id', $order_id)
                ->update(['salesperson_id' => $salesperson_id]);

            $this->salesperson_mail($order_id, $salesperson_id);
        }

        return response()->json(['status' => 1, 'order_id' => $order_id]);
    }
    function salesperson_mail($order_id, $driver_id)
    {

        $order_data = DB::table('ci_order_item')
            ->where('order_id', $order_id)
            ->first();
        $salesperson_data = DB::table('users')
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

        $salesperson_html = '';

        $salesperson_html .= '<!doctype html>
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
                            <p>  Dear ' . $salesperson_data->name . ',</p>
                            <p>We are excited to inform you that a new order has been assigned to you through VendorsCity! Below are the details for the upcoming service:</p>';
        $salesperson_html .= '<p><strong>Order Details:</strong><br>';
        $salesperson_html .= '<ul>
                                                <li><strong>Date and Time: </strong> ' . $order_data->bookingdate . '-' . $order_data->month . '-' . $order_data->bookingyear . 'at' . Helper::timeslotname($order_data->time_slot) . '</li>
                                                <li><strong>Service: </strong> ' . Helper::servicename($order_data->service_id) . '</li>
                                                <li><strong>Payment Type: </strong> ' . $payment_mode . '</li>
                                                </ul>';
        $salesperson_html .= '<p>Press “View Order” or login to your Salesperson portal to access all the customer details to complete the order.</p>';
        $salesperson_html .= '<button class="btn btn-primary" type="button"
                                style="background-color: #1F6EEC;border-color: #1F6EEC;color: #fff;
                                padding: 10px 18px;border-radius: 11px;">
                                <a href="' . url("vendor/login") . '" style="color:#fff !important; text-decoration:none !important;">View Order</a></button>';
        $salesperson_html .= '
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
        $to = $salesperson_data->email;

        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        // $ccRecipients = array();
        Mail::send([], [], function ($message) use ($salesperson_html, $to, $subject, $ccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($salesperson_html);
        });
    }

    function add_cleaner_price_form()
    {
        // echo"<pre>";print_r($_POST);echo"</pre>";exit;

        $order_id = $_POST['order_id'];
        $cleaner_price = $_POST['cleaner_price'];

        if (!empty($order_id) && $cleaner_price != "") {

            DB::table('ci_order_item')->where('order_id', $order_id)->update(['cleaner_price' => $cleaner_price]);
        }

        return response()->json(['status' => 1, 'order_id' => $order_id]);
    }


    function location_link_form()
    {

        $order_id = $_POST['order_id'];
        $location_link = $_POST['location_link'];

        if (!empty($order_id) && $location_link != "") {

            DB::table('ci_order_item')->where('order_id', $order_id)->update(['location_link' => $location_link]);
        }

        return response()->json(['status' => 1, 'order_id' => $order_id]);
    }
    function vendor_commission_report(Request $request)
    {

        // $userId = Auth::id();

        // $get_user_data = Helper::get_user_data($userId);

        // $get_permission_data = Helper::get_permission_data($get_user_data->role_id);

        // $permission1 = [];

        // if (
        //     is_object($get_permission_data) &&
        //     property_exists($get_permission_data, 'permission') &&
        //     $get_permission_data->permission !== ''
        // ) {
        //     $permission1 = $get_permission_data->permission;
        //     $permission1 = explode(',', $permission1);
        // } else {
        //     echo '';
        //     // Handle the case where $get_permission_data is not an object or 'permission' property is empty.
        // }
        // if (!in_array('36', $permission1)){
        //     return redirect()->to('admin')->with('error', 'Invalid permission data.');
        // }


        $startdate = $request->s_date;
        $enddate = $request->e_date;
        $vendorname = $request->vendorname;
        $servicename = $request->servicename;

        // echo "<pre>";print_r($request->all());echo"</pre>";exit;
        $query = DB::table('package_order_amount_attr');

        if ($startdate != '') {
            $query = $query->where('order_date', '>=', date('Y-m-d', strtotime($startdate)));
        }

        if ($enddate != '') {
            $query = $query->where('order_date', '<=', date('Y-m-d', strtotime($enddate)));
        }
        if ($vendorname != '') {
            $query = $query->where('vendor_id', $vendorname);
        }

        if ($servicename != '') {
            $query = $query->where('service_id', $servicename);
        }


        $data['startdate'] = $startdate;
        $data['enddate'] = $enddate;
        $data['filter_vendor_id'] = $vendorname;
        $data['filter_service_id'] = $servicename;

        $data['package_order_amount_attr'] = $query->orderBy('order_id', 'DESC')->get();

        $data['vendor_data'] = DB::table('users')->where('vendor', '1')->get();

        $data['service_data'] = DB::table('services')->where('is_active', '0')->get();

        // echo "<pre>";print_r($data['package_order_amount_attr']);echo"</pre>";exit;

        return view('admin.list_vendor_commission', $data);
    }
    function filter_data_vendor(Request $request)
    {

        $startdate = $request->input('startdate_fil', '');
        $enddate = $request->input('enddate_fil', '');
        $vendorname = $request->input('filter_vendor_id_fil', '');
        $servicename = $request->input('filter_service_id_fil', '');

        $query = DB::table('package_order_amount_attr');

        if ($startdate != '') {
            $query = $query->where('order_date', '>=', date('Y-m-d', strtotime($startdate)));
        }

        if ($enddate != '') {
            $query = $query->where('order_date', '<=', date('Y-m-d', strtotime($enddate)));
        }
        if ($vendorname != '') {
            $query = $query->where('vendor_id', $vendorname);
        }
        if ($servicename != '') {
            $query = $query->where('service_id', $servicename);
        }


        $data = $query->orderBy('order_id', 'DESC')->get()->toArray();

        // $vendor_data = DB::table('users')->where('id','$vendorname')->first();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $total_commission_amount = 0;
        $total_amount = 0;
        $vc_commission = 0;
        $vc_received = 0;
        $vendor_received = 0;
        $vendor_total = 0;
        $displayedOrderIds = [];
        $commission_cc_charge = 0;
        $vat_on_sum_charge = 0;

        $total_amount = 0;
        $vc_commission = 0;
        $vc_received = 0;
        $vendor_received = 0;


        foreach ($data as $data_new) {

            $showRow = !in_array($data_new->order_id, $displayedOrderIds);

            if ($showRow) {
                $displayedOrderIds[] = $data_new->order_id;
            }
            if ($data_new->collect_by == "Vendorscity") {
                $vc_received += $data_new->add_amount;
            }
            if ($data_new->collect_by == "Vendor") {
                $vendor_received += $data_new->add_amount;
            }
            if ($showRow) {
                $data_new->order_total = $data_new->order_total;
            } else {
                $data_new->order_total = 0;
            }

            $amount_without_vat = $data_new->order_total - $data_new->vatcharge;

            if ($showRow) {
                $amount_without_vat = $amount_without_vat;
            } else {
                $amount_without_vat = 0;
            }


            $commission_amount = $amount_without_vat * $data_new->booking_percentage / 100;

            $amount_to_vendor = $data_new->add_amount - $commission_amount;

            if ($data_new->payment_type == "Online") {
                $cc_fee = $data_new->add_amount * 2.625 / 100;
            } else {
                $cc_fee = '0';
            }

            $commission_cc_charge = $commission_amount + $cc_fee;

            $total_commission_amount += $commission_cc_charge;

            $vat_on_sum_charge = $total_commission_amount * 5 / 100;

            $vc_commission = $total_commission_amount + $vat_on_sum_charge;

            $total_amount += $data_new->order_total;

            $vendor_total = $total_amount - $vc_commission;

            if ($showRow) {
                $commission_amount = $commission_amount;
            } else {
                $commission_amount = 0;
            }
        }

        $amount_without_commission = $total_amount - $vc_commission;
        $paid_to_vendor = $vendor_total - $vendor_received;

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



        // Apply background color to cells E($row_new+1), E($row_new+2), and E($row_new+3)

        $row_new = 1;

        $sheet->getStyle('E' . ($row_new + 1))->applyFromArray($styleArray);
        $sheet->getStyle('E' . ($row_new + 2))->applyFromArray($styleArray);
        $sheet->getStyle('E' . ($row_new + 3))->applyFromArray($styleArray);

        $sheet->getStyle('F' . ($row_new + 1))->applyFromArray($styleArray1);
        $sheet->getStyle('F' . ($row_new + 2))->applyFromArray($styleArray1);
        $sheet->getStyle('F' . ($row_new + 3))->applyFromArray($styleArray1);

        $sheet->getStyle('A' . ($row_new))->applyFromArray($styleArray2);
        $sheet->getStyle('B' . ($row_new))->applyFromArray($styleArray2);
        $sheet->getStyle('A' . ($row_new + 1))->applyFromArray($styleArray2);
        $sheet->getStyle('A' . ($row_new + 2))->applyFromArray($styleArray2);
        $sheet->getStyle('A' . ($row_new + 3))->applyFromArray($styleArray2);
        $sheet->getStyle('A' . ($row_new + 4))->applyFromArray($styleArray2);
        $sheet->getStyle('A' . ($row_new + 5))->applyFromArray($styleArray2);

        $sheet->getStyle('B' . ($row_new + 1))->applyFromArray($styleArray2);
        $sheet->getStyle('B' . ($row_new + 2))->applyFromArray($styleArray2);
        $sheet->getStyle('B' . ($row_new + 3))->applyFromArray($styleArray2);
        $sheet->getStyle('B' . ($row_new + 4))->applyFromArray($styleArray2);
        $sheet->getStyle('B' . ($row_new + 5))->applyFromArray($styleArray2);


        $sheet->setCellValue('A' . $row_new . '', 'Summary');
        $sheet->getStyle('A' . $row_new)->getFont()->setBold(true)->setUnderline(true);


        $sheet->setCellValue('A' . $row_new + 1  . '', 'Vat on Sum of charges');
        $sheet->setCellValue('B' . $row_new + 1  . '', '' . $vat_on_sum_charge . '');

        $sheet->setCellValue('A' . $row_new + 2  . '', 'Total VC Commision');
        $sheet->setCellValue('B' . $row_new + 2  . '', '' . $vc_commission . '');

        $sheet->setCellValue('A' . $row_new + 3  . '', 'Vendors Total');
        $sheet->setCellValue('B' . $row_new + 3  . '', '' . $vendor_total . '');

        $sheet->setCellValue('A' . $row_new + 4  . '', 'Vendor Received');
        $sheet->setCellValue('B' . $row_new + 4  . '', '' . $vendor_received . '');

        $sheet->setCellValue('A' . $row_new + 5  . '', 'Paid to Vendor');
        $sheet->setCellValue('B' . $row_new + 5  . '', '' . $paid_to_vendor . '');


        $sheet->setCellValue('E' . $row_new + 1  . '', 'Date:');
        $sheet->setCellValue('F' . $row_new + 1  . '', '' . $download_date . '');

        $sheet->setCellValue('E' . $row_new + 2  . '', 'From Date:');
        if ($startdate) {
            $sheet->setCellValue('F' . $row_new + 2  . '', '' . $startdate . '');
        } else {
            $sheet->setCellValue('F' . $row_new + 2  . '', '-');
        }

        $sheet->setCellValue('E' . $row_new + 3  . '', 'To Date:');
        if ($enddate) {
            $sheet->setCellValue('F' . $row_new + 3  . '', '' . $enddate . '');
        } else {
            $sheet->setCellValue('F' . $row_new + 3  . '', '-');
        }

        $sheet->setCellValue('A' . $row_new + 7  . '', 'Vendor Name');
        $sheet->getStyle('A' . $row_new + 7)->getFont()->setBold(true);
        $sheet->setCellValue('B' . ($row_new + 7), Helper::vendorsname($vendorname));


        $sheet->setCellValue('A10', 'Order Id');
        $sheet->setCellValue('B10', 'Service Name');
        $sheet->setCellValue('C10', 'Added Date');
        $sheet->setCellValue('D10', 'Order Date');
        $sheet->setCellValue('E10', 'Vendor Name');
        $sheet->setCellValue('F10', 'Payment Mode');
        $sheet->setCellValue('G10', 'Received By');
        $sheet->setCellValue('H10', 'Total Amount Incl. VAT');
        $sheet->setCellValue('I10', 'Amount (Without VAT)');
        $sheet->setCellValue('J10', 'Add Amount');
        $sheet->setCellValue('K10', 'Commission % (VC)');
        $sheet->setCellValue('L10', 'Commission (VC)');
        $sheet->setCellValue('M10', 'CC Fee');
        $sheet->setCellValue('N10', 'Commission + CC Charge');

        $row = 11;



        if (isset($data)) {
            $displayedOrderIdsn = [];
            foreach ($data as $data_new) {

                $showRown = !in_array($data_new->order_id, $displayedOrderIdsn);

                if ($showRown) {
                    $displayedOrderIdsn[] = $data_new->order_id;
                }
                if ($data_new->collect_by == "Vendorscity") {
                    $vc_received += $data_new->add_amount;
                }
                if ($data_new->collect_by == "Vendor") {
                    $vendor_received += $data_new->add_amount;
                }

                $amount_without_vat = $data_new->order_total - $data_new->vatcharge;

                if ($showRown) {

                    $amount_without_vat = $amount_without_vat;
                } else {
                    $amount_without_vat = 0;
                }


                $commission_amount = $amount_without_vat * $data_new->booking_percentage / 100;

                $amount_to_vendor = $data_new->add_amount - $commission_amount;

                if ($data_new->payment_type == "Online") {
                    $cc_fee = $data_new->add_amount * 2.625 / 100;
                } else {
                    $cc_fee = '0';
                }

                $commission_cc_charge = $commission_amount + $cc_fee;

                $total_commission_amount += $commission_cc_charge;

                $vat_on_sum_charge = $total_commission_amount * 5 / 100;

                $vc_commission = $total_commission_amount + $vat_on_sum_charge;

                $total_amount += $data_new->order_total;

                $vendor_total = $total_amount - $vc_commission;

                if ($showRown) {
                    $commission_amount = $commission_amount;
                } else {
                    $commission_amount = 0;
                }

                $vendorname = DB::table('users')->where('id', $data_new->vendor_id)->first();

                $service_data = DB::table('services')->where('id', $data_new->service_id)->where('is_active', '0')->first();

                if ($data_new->order_id !== null) {
                    $sheet->setCellValue('A' . $row, $data_new->order_id);
                } else {
                    $sheet->setCellValue('A' . $row, '-');
                }

                if ($service_data->servicename !== null) {
                    $sheet->setCellValue('B' . $row, $service_data->servicename);
                } else {
                    $sheet->setCellValue('B' . $row, '-');
                }

                if ($data_new->date !== null) {
                    $sheet->setCellValue('C' . $row, $data_new->date);
                } else {
                    $sheet->setCellValue('C' . $row, '-');
                }
                if ($data_new->order_date !== null) {
                    $sheet->setCellValue('D' . $row, $data_new->order_date);
                } else {
                    $sheet->setCellValue('D' . $row, '-');
                }
                if ($vendorname !== null) {
                    $sheet->setCellValue('E' . $row, $vendorname->name);
                } else {
                    $sheet->setCellValue('E' . $row, '-');
                }
                if ($data_new->payment_type !== null) {
                    $sheet->setCellValue('F' . $row, $data_new->payment_type);
                } else {
                    $sheet->setCellValue('F' . $row, '-');
                }
                if ($data_new->collect_by !== null) {
                    $sheet->setCellValue('G' . $row, $data_new->collect_by);
                } else {
                    $sheet->setCellValue('G' . $row, '-');
                }
                if ($data_new->order_total !== null) {
                    $sheet->setCellValue('H' . $row, $data_new->order_total);
                } else {
                    $sheet->setCellValue('H' . $row, '-');
                }

                if ($amount_without_vat !== null) {
                    $sheet->setCellValue('I' . $row, $amount_without_vat);
                } else {
                    $sheet->setCellValue('I' . $row, '-');
                }

                if ($data_new->add_amount  !== null) {
                    $sheet->setCellValue('J' . $row, $data_new->add_amount);
                } else {
                    $sheet->setCellValue('J' . $row, '-');
                }
                if ($data_new->booking_percentage !== null) {
                    $sheet->setCellValue('K' . $row, $data_new->booking_percentage);
                } else {
                    $sheet->setCellValue('K' . $row, '-');
                }
                if ($commission_amount !== null) {
                    $sheet->setCellValue('L' . $row, $commission_amount);
                } else {
                    $sheet->setCellValue('L' . $row, '-');
                }
                if ($cc_fee !== null) {
                    $sheet->setCellValue('M' . $row, $cc_fee);
                } else {
                    $sheet->setCellValue('M' . $row, '-');
                }
                if ($commission_cc_charge !== null) {
                    $sheet->setCellValue('N' . $row, $commission_cc_charge);
                } else {
                    $sheet->setCellValue('N' . $row, '-');
                }
                $row++;
            }
        }

        $writer = new Xlsx($spreadsheet);

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Vendor-Commission-Report.xlsx"');
        header('Cache-Control: max-age=0');

        // Write the file to the browser
        $writer->save('php://output');
    }





    public function checkAmountorder(Request $request)
    {
        $order = DB::table('ci_orders')
            ->where('order_id', $request->order_id)
            ->first();

        if (!$order) {
            return response()->json(['status' => 'invalid']);
        }

        $total_add_amount = DB::table('package_order_amount_attr')
            ->where('order_id', $order->format_order_id) // ✅ FIXED
            ->sum('add_amount');

        // ✅ PERFECT MONEY CALCULATION
        $balance = bcsub($order->order_total, $total_add_amount, 2);

        if ($balance <= 0) {
            return response()->json([
                'status' => 'paid'
            ]);
        }

        if ($request->add_amount > $balance) {
            return response()->json([
                'status' => 'exceed',
                'balance' => $balance
            ]);
        }

        return response()->json([
            'status' => 'ok',
            'balance' => $balance
        ]);
    }



    public function add_amount_form(Request $request)
    {
        $order_id = $request->order_id;

        $order = DB::table('ci_orders')
            ->where('order_id', $order_id)
            ->first();

        if (!$order) {
            return response()->json(['status' => 'invalid']);
        }

        $total_add_amount = DB::table('package_order_amount_attr')
            ->where('order_id',  $order->format_order_id) // ✅ FIXED
            ->sum('add_amount');

        // ✅ PERFECT MONEY CALCULATION
        $balance = bcsub($order->order_total, $total_add_amount, 2);

        if ($balance <= 0) {
            return response()->json(['status' => 'paid']);
        }

        if ($request->add_amount > $balance) {
            return response()->json([
                'status' => 'exceed',
                'balance' => $balance
            ]);
        }

        $service = DB::table('ci_order_item')
            ->where('order_id', $order_id)
            ->first();

        DB::table('package_order_amount_attr')->insert([
            'order_id'      => $order->format_order_id, // ✅ IMPORTANT FIX
            'vendor_id'     => $order->vendor_id,
            'service_id'    => $service->service_id ?? null,
            'order_total'   => $order->order_total,
            'vatcharge'     => $order->vatcharge,
            'booking_percentage' => $service->subservice_booking_percentage ?? null,
            'add_amount'    => $request->add_amount,
            'collect_by'    => $request->collect_by,
            'payment_type'  => $request->payment_type,
            'date'          => $request->date,
            'order_date'    => $service->cdate ?? null,
            'added_date'    => date("Y-m-d"),
        ]);

        return response()->json(['status' => 'success']);
    }

    public function order_vendor_form()
    {
        $vendor_id = $_POST['vendor_id'];
        $order_id = $_POST['order_id'];
        $redirectUrl = $_POST['painting_order'];

        // 1. Immediate Database Update
        DB::table('ci_orders')
            ->where('order_id', $order_id)
            ->update([
                'vendor_id' => $vendor_id,
                'order_status' => 'PA'
            ]);

        // 2. Dispatch the Job
        // \App\Jobs\AssignVendorJob::dispatchSync($vendor_id, $order_id);
        \App\Jobs\AssignVendorJob::dispatch($vendor_id, $order_id);

        return redirect()->route($redirectUrl)->with('success', 'Vendor Assign successfully');
    }

    public function set_booking_percentage()
    {
        $order_id = $_POST['order_id'];
        $percentage = $_POST['percentage'];
        DB::table('ci_order_item')->where('id', $order_id)->update(array('subservice_booking_percentage' => $percentage));
        echo "1";
        // return redirect()->route('product.index')->with('success','Set Order has been Updated successfully');
    }
    public function cleaning_admin_order()
    {
        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();

        $data['subservice_data'] = DB::table('subservices')->where('serviceid', '45')->where('is_active', '0')->orderBy('id', 'DESC')->get();

        $data['cleanin_subserviceprice'] = DB::table('cleanin_subserviceprice')->where('subservice_id', '28')->get();


        return view('admin.package-orders.cleaning.add_order', $data);
    }

    public function automobile_admin_order()
    {
        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();

        $data['subservice_data'] = DB::table('subservices')->where('serviceid', '50')->where('id', '!=', '92')->where('is_active', '0')->orderBy('id', 'DESC')->get();




        return view('admin.package-orders.auto-mobile.add_order', $data);
    }

    public function cleaning_package_order_edit($order_id)
    {
        $data['error'] = '';
        $order = DB::table('ci_orders')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )
            ->where('ci_orders.order_id', $order_id)
            ->whereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('ci_order_item')
                    ->whereColumn('ci_order_item.order_id', 'ci_orders.order_id')
                    ->where('ci_order_item.service_id', 45);
            })
            ->where('ci_orders.order_from', '!=', 2)
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found or invalid');
        }

        $itemList = DB::table('ci_order_item')
            ->where('order_id', $order->order_id)
            ->where('service_id', 45)
            ->get();

        $total = 0;

        foreach ($itemList as $item) {
            $categoryIds = DB::table('ci_order_item_packages')
                ->where('order_id', $order->order_id)
                ->pluck('package_id')
                ->unique()
                ->toArray();
            if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                $product_item_price = $item->product_discount_amount;
            } else {
                $product_item_price = $item->package_item_price;
            }

            $total += $product_item_price * $item->package_quantity;
        }

        $order->packagecategory_ids = $categoryIds;

        // Attach item list and subtotal
        $order->items = $itemList;
        $order->sub_total = $total;

        $data['order'] = $order;
        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();
        $data['subservice_data'] = DB::table('subservices')->where('serviceid', '45')->where('is_active', '0')->orderBy('id', 'DESC')->get();
        $data['cleanin_subserviceprice'] = DB::table('cleanin_subserviceprice')->where('subservice_id', '28')->get();
        $data['orderItemPackages'] = DB::table('ci_order_item_packages')->where('order_id', $order_id)->get();
        return view('admin.package-orders.cleaning.edit_order', $data);
    }

    public function moving_admin_order()
    {

        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();

        $data['subservice_data'] = DB::table('subservices')->where('serviceid', '30')->where('is_active', '0')->where('is_bookable', '1')->orderBy('id', 'DESC')->get();

        $data['country_data'] = DB::table('countries')->get();


        $data['emiratesList'] = [
            ['name' => 'Dubai',          'id' => 17],
            ['name' => 'Abu Dhabi',      'id' => 20],
            ['name' => 'Sharjah',        'id' => 22],
            ['name' => 'Ajman',          'id' => 23],
            ['name' => 'Umm Al Quwain',  'id' => 24],
            ['name' => 'Ras Al Khaimah', 'id' => 25],
            ['name' => 'Fujairah',       'id' => 26],
        ];

        return view('admin.package-orders.moving.add_order', $data);
    }

    public function get_time_slot(Request $request)
    {
        $subservice_id = $request->subservice_id;
        $selected_time_slot = $request->selected_time_slot ?? '';
        $availableSlots = DB::table('subservice_timeslot_price')
            ->where('subservice_id', $subservice_id)
            ->where('is_active', '1')
            ->get();

        $html = '<select class="form-control form-select" id="time_slot" name="time_slot" onchange="get_time_slot_price()">';
        $html .= "<option value=''>Select Time Slot</option>";
        if ($availableSlots->isNotEmpty()) {
            foreach ($availableSlots as $slot) {

                $selected = ($slot->time_slot_id == $selected_time_slot) ? 'selected' : '';
                $html .= "<option value='" . $slot->time_slot_id . "' $selected>" . Helper::timeslotname(strval($slot->time_slot_id)) . "</option>";
            }
        }
        $html .= "</select>";

        return $html;
    }

    public function salon_spa_admin_order()
    {

        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();

        $data['subservice_data'] = DB::table('subservices')->where('serviceid', '48')->where('is_active', '0')->orderBy('id', 'DESC')->get();

        return view('admin.package-orders.salon-spa.add_order', $data);
    }
    public function pest_control_admin_order()
    {

        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();

        $data['subservice_data'] = DB::table('subservices')->where('serviceid', '47')->where('is_active', '0')->orderBy('id', 'DESC')->get();

        return view('admin.package-orders.pest-control.add_order', $data);
    }

    public function painting_service_admin_order()
    {

        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();

        $data['subservice_data'] = DB::table('subservices')->where('serviceid', '34')->where('is_active', '0')->orderBy('id', 'DESC')->get();

        /* Apartment Painting Data */
        $data['Apartment_painting_price_data'] = DB::table('painting_prices')->where('types_of_tab', 'apartment')->where('flags_of_tab', '=', null)->get();

        /* Villa Painting Data */
        $data['villaPainting_price_data'] = DB::table('painting_prices')->where('types_of_tab', 'villa')->where('flags_of_tab', '=', null)->get();

        return view('admin.package-orders.painting.add_order', $data);
    }

    public function car_inspection_service_admin_order()
    {

        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();
        $data['package_data'] = VerifyBuyPackage::where('is_active', 0)->orderBy('id', 'DESC')->get();
        $data['vehicles'] = Vehicles::orderBy('id', 'DESC')->get();

        $data['subservice_timeslot_price'] = DB::table('time_slots')
            ->leftjoin('subservice_timeslot_price', 'time_slots.id', '=', 'subservice_timeslot_price.time_slot_id')
            ->where('subservice_timeslot_price.service_id', 50)
            ->where('subservice_timeslot_price.subservice_id', 92)
            ->where('subservice_timeslot_price.is_active', 1)
            ->select('time_slots.*', 'subservice_timeslot_price.*')
            ->get();

        return view('admin.package-orders.car-inspection.add_order', $data);
    }
    public function show_customer_details(request $request)
    {

        $id = $request->customer_id;

        $mobile_no = DB::table('frontloginregisters')->where('id', $id)->value('mobile');
        return response()->json(['mobile' => $mobile_no]);
    }
    public function show_vehicle_model(request $request)
    {
        $id = $request->vehicle_id;




        $models = ModelModule::where('vehicle_name', $id)->get();



        $html = '<select id="vehicle_model" name="vehicle_model" class="form-control form-select" onchange="showPrice(this.value);">';
        $html .= '<option value="">Select Vehicle Model</option>';
        foreach ($models as $row) {
            $html .= '<option value="' . $row->model_name . '">' . $row->model_name . '</option>';
        }
        $html .= '</select>';
        return response()->json(['html' => $html]);
    }

    function show_price(request $request)
    {
        $val = $request->value;
        $models = ModelModule::where('model_name', $val)->first();

        return response()->json(['category' => $models->category, 'price' => $models->price]);
    }

    function show_package_price(request $request)
    {
        $val = $request->value;
        $package_price = VerifyBuyPackage::where('id', $val)->value('price');
        return response()->json(['price' => $package_price]);
    }

    public function car_inspection_order_store(request $request)
    {

        //$id = $request->payment_hidden;
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

        $intOrderNumber = DB::table('ci_orders')
            ->select(DB::raw('MAX(order_id) as lastOrderNumber'))
            ->first();
        $nextOrderNumber = 0;
        if ($intOrderNumber) {
            $intOrderNumber = $intOrderNumber->lastOrderNumber + 1;

            $intOrderNumber_new = $intOrderNumber;
            $nextOrderNumber;
        } else {
            $intOrderNumber_new = 1;
        }

        Session::put('order_number', $intOrderNumber_new);
        $order_number = Session::get('order_number');

        $userid = $request->customer_id;

        $order_total_new = $request->total_amount;

        $front_wallet_amount_new = 0;

        $order_from = 3;

        $subservice_id = $request->subservice_id;
        $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($request->location) . '%'])->first();
        $subserviceData = DB::table('subservices')->where('id', $subservice_id)->first();

        if (isset($subserviceData)) {
            if (isset($subserviceData->subservice_code)) {
                $subserviceCode = $subserviceData->subservice_code;
            } else {
                $subserviceCode = 'OT';
            }
        } else {
            $subserviceCode = 'OT';
        }

        $cityCode = 'DU';
        if (isset($cityData)) {
            if (isset($cityData->city_code)) {
                $cityCode = $cityData->city_code;
            } else {
                $cityCode = 'OT';
            }
        }
        // echo $request->city."<br>";
        // echo $cityCode;
        // echo"<pre>";print_r($cityData);echo"</pre>";exit;
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

        $content = array(
            'user_id'               => $userid,
            'order_number'          => $order_number,
            'order_total'           => $order_total_new,
            'front_wallet_amount'   => $front_wallet_amount_new,
            'shippingcost'          => '',
            'vatcharge'             => '',
            'order_currency'        => 'AED',
            'order_status'          => $order_status,
            'paymentmode'           => $paymentmode,
            'payment_status'        => $payment_status,
            'created_at'            => date('Y-m-d H:i:s'),
            'coupan_to_wallet'      => '',
            'coupondiscount'        => '',
            'coupon_code'           => '',
            'moving_date'           => $request->inspection_date,
            'send_notification'           => $request->send_notification,
            //'ip_address'            => $_SERVER['REMOTE_ADDR'],
            'list_order_status'     => $list_order_status,
            'order_from'     => $order_from,
            'subservice_code'       => $subserviceCode,
            'city_code'             => $cityCode,
            'order_year'            => $year,
            'sequence_no'           => $nextSequence,
            'format_order_id'           => $formatOrderId,
        );

        $arrOrderId = DB::table('ci_orders')->insertGetId($content);

        // $year =date('y');
        // $data_u['format_order_id'] = "VC-" . $year ."-UAE-". sprintf("%06d", $arrOrderId);
        // DB::table('ci_orders')->where('order_id', $arrOrderId)->update($data_u);

        Session::put('format_order_id', $formatOrderId);

        if ($arrOrderId) {
            $arrOrderId;
        }

        $date = Carbon::parse($request->inspection_date);
        $booking_date = $date->day;
        $monthName = $date->format('F');
        $year = $date->year;

        if ($request->vehicle_make == '0') {
            $vehicle_make = $request->other_vehicle_make;
            $others = 1;
        } else {
            $vehicle_make = $request->vehicle_make;
            $others = 0;
        }


        $arrData = array(
            'order_id'                             => $arrOrderId,
            'user_info_id'                         => $userid,
            'service_id'                           => 50,
            'subservice_id'                        => 92,
            'bookingdate'                          => $booking_date,
            'bookingyear'                          => $year,
            'month'                                => $monthName,
            'time_slot'                            => $request->inspection_time,
            'end_date'                            => $request->inspection_date,
            'verifybuy_package_id'                => $request->package_id,
            'verifybuy_mobile'                     => $request->mobile,
            'verifybuy_location'                 => $request->location,
            'verifybuy_address'                  => $request->address,
            'verifybuy_additional_details'       => $request->additional_details,
            'verifybuy_where_is_car_parked'      => $request->where_is_car_parked,
            'verifybuy_vehicle'                    => $vehicle_make,
            'verifybuy_model'                    => $request->other_vehicle_model,
            'verifybuy_category'                 => $request->category,
            'verifybuy_others'                  => $others,
            'cdate'                                => date('Y-m-d'),
        );

        DB::table('ci_order_item')->insertGetId($arrData);

        $data['first_name'] = "";
        $data['last_name'] = "";
        $data['country'] = "";
        $data['address1'] = $request->address;
        $data['state'] = "";
        $data['city'] = "";
        $data['zipcode'] = "";
        $data['address2'] = "";
        $data['phone_number'] = $request->mobile;
        $data['email_address'] = "";
        $data['additional_message'] = $request->additional_details;
        $data['payment_method'] = "";
        $data['order_id'] = $arrOrderId;
        $data['user_id'] = $userid;

        DB::table('ci_shipping_address')->insert($data);

        if ($id == 1) {

            //$success = $this->success_mail();

            //return redirect('thankyou-book-now');

            if ($request->send_notification == '1') {
                $this->success_whatsapp_message($userid, $arrOrderId);
            }

            return redirect()->route('car-inspection-order')->with('success', 'Your booking has been successfully placed. Thank you!');

            // if ($success) {
            //     return redirect('thankyou-book-now');
            // } 
        }
        return redirect()->route('car-inspection-order')->with('success', 'Your booking has been successfully placed. Thank you!');
    }
    public function car_inspection_order_edit($order_id)
    {
        $data['error'] = '';
        // First, fetch distinct orders
        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )
            ->where('ci_orders.order_id', $order_id)
            ->whereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('ci_order_item')
                    ->whereColumn('ci_order_item.order_id', 'ci_orders.order_id')
                    ->where('ci_order_item.service_id', 50);
            });
        $query = $query->where('order_from', '!=', 2);
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
        // Get distinct orders where service_id is 71
        $orderList = $query->get();
        // Now, for each order, fetch its items
        foreach ($orderList as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('service_id', 50)
                ->get();
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
            // Attach the items and subtotal to the order object
            $order->items = $itemList;
            $order->sub_total = $total;
        }
        $data['order'] = $orderList->first();

        $data['subservice_timeslot_price'] = DB::table('time_slots')
            ->leftjoin('subservice_timeslot_price', 'time_slots.id', '=', 'subservice_timeslot_price.time_slot_id')
            ->where('subservice_timeslot_price.service_id', 50)
            ->where('subservice_timeslot_price.subservice_id', 92)
            ->where('subservice_timeslot_price.is_active', 1)
            ->select('time_slots.*', 'subservice_timeslot_price.*')
            ->get();

        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();
        $data['package_data'] = VerifyBuyPackage::where('is_active', 0)->orderBy('id', 'DESC')->get();
        $data['vehicles'] = Vehicles::orderBy('id', 'DESC')->get();

        return view('admin.package-orders.car-inspection.edit_order', $data);
    }

    public function handyman_service_admin_order()
    {

        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();

        $data['subservice_data'] = DB::table('subservices')->where('serviceid', '34')->where('is_active', '0')->orderBy('id', 'DESC')->get();
        $data['ev_charger_type'] = DB::table('ev_charger_type')->orderBy('set_order', 'asc')->get();
        $data['ev_charger_location_type'] = DB::table('ev_charger_location_type')->orderBy('set_order', 'asc')->get();

        return view('admin.package-orders.handyman.add_order', $data);
    }

    public function get_package_category(Request $request)
    {
        $subservice_id = $request?->subservice_id ?? '';
        $selectedCategories = $request->packageCategoryId ?? [];
        $package_category = DB::table('package_categories')->where('subservice_id', $subservice_id)->get();

        $html = '<select class="form-control form-select" id="package_category" name="package_category[]" onchange="get_package()" multiple="multiple">';
        $html .= "<option value=''>Select Package Category</option>";
        if ($package_category->isNotEmpty()) {
            foreach ($package_category as $data) {
                $selected = in_array($data->id, (array)$selectedCategories) ? 'selected' : '';
                $html .= "<option value='" . $data->id . "' $selected>" . $data->name . "</option>";
            }
        }
        $html .= "</select>";
        return $html;
    }

    public function get_package(Request $request)
    {
        $subservice_id = $request->subservice_id;
        // Handle both single string or array of IDs
        $package_category = (array) $request->package_category;
        $selectedPackages = (array) ($request->selectedPackages ?? []);

        $query = DB::table('packages')
            ->where('subservice_id', $subservice_id);

        if (!empty($package_category)) {
            $query->whereIn('packagecategory_id', $package_category);
        }

        $packages = $query->get();

        $html = '<select class="form-control form-select" id="package" name="package[]" multiple="multiple" onchange="showPackageFields();">';
        if ($packages->isNotEmpty()) {
            foreach ($packages as $package) {
                $selected = in_array($package->id, $selectedPackages) ? 'selected' : '';
                $html .= "<option value='" . $package->id . "' $selected>" . $package->name . "</option>";
            }
        }
        $html .= "</select>";

        return $html;
    }

    public function get_package_old()
    {
        $package_category_id = $_POST['package_category'];
        $subservice_id = $_POST['subservice_id'];
        $selectedPackages = $_POST['selectedPackages'] ?? [];

        $package = DB::table('packages')
            ->whereIn('packagecategory_id', $selectedPackages)
            ->where('subservice_id', $subservice_id)
            ->get();

        $html = '<select class="form-control form-select" id="package" name="package[]" multiple="multiple" onchange="showPackageFields();">';

        $html .= "<option value=''>Select Package</option>";
        if ($package->isNotEmpty()) {
            foreach ($package as $data) {
                $selected = in_array($data->id, $selectedPackages) ? 'selected' : '';
                $html .= "<option value='" . $data->id . "' $selected>" . $data->name . "</option>";
            }
        }
        $html .= "</select>";

        return $html;
    }
    public function get_subservice_cleaners()
    {
        $subservice_id = $_POST['subservice_id'];
        $cleaner_id = $_POST['selectedCleanerId'] ?? null;

        $cleaners = DB::table('users')
            ->where('role_id', '16')
            ->whereRaw("FIND_IN_SET(?, subservice)", [$subservice_id])
            ->get();

        $html = '<select class="form-control form-select" id="cleaner" name="cleaner" onchange="cleaner_on_change()">';
        $html .= "<option value=''>Select Preferred Cleaner</option>";

        if ($cleaners->isNotEmpty()) {
            foreach ($cleaners as $data) {
                $selected = ($data->id == $cleaner_id) ? 'selected' : '';
                $html .= "<option value='" . $data->id . "' $selected>" . $data->name . "</option>";
            }
        }

        $html .= "</select>";

        echo $html;
    }


    //     public function get_cleaners_time_slot(){

    //         // echo"<pre>";print_r($_POST);echo"</pre>";exit;

    //         $date = $_POST['date'];
    //         $dateObject = new DateTime($date);
    //         $date = $dateObject->format('j'); 
    //         $month = $dateObject->format('F'); 
    //         $year = $dateObject->format('Y'); 
    //         $cleaner = $_POST['cleaner'];
    //         $subservice_id = $_POST['subservice_id'];
    //         $selectedTimeSlot = $_POST['selectedTimeSlot'] ?? '';


    //             $time_slots = DB::table('subservice_timeslot_price')
    //                         ->where('subservice_id', $subservice_id) 
    //                         ->where('is_active', '1')
    //                         ->pluck('time_slot_id')
    //                         ->toArray();

    //             if ($cleaner == 2) {
    //                 $already_time_slots = collect(); // Use an empty collection to avoid errors
    //             } else {
    //                 $already_time_slots = DB::table('ci_order_item')
    //                                         ->where('bookingdate', $date)
    //                                         ->where('month', $month)
    //                                         ->where('bookingyear', $year)
    //                                         ->whereRaw("FIND_IN_SET(?, cleaner_id)", [$cleaner])
    //                                         ->whereIn('time_slot', $time_slots)
    //                                         ->get();
    //             }

    //             $time_slot = $already_time_slots->pluck('time_slot');
    //             $hours = $already_time_slots->pluck('how_many_hours_should_they_stay');

    //             $html = '<select id="time_slot" name="time_slot" class="form-control form-select" onchange="time_slot_on_change(this.value);">';
    //             $html .= "<option value=''>Select Time Slot</option>";

    //        foreach ($time_slots as $data) {
    //     $disabled = '';
    //     $selected = '';

    //     $isBooked = false;

    //     if ($cleaner != 2 && in_array($data, $time_slot->toArray())) {
    //         $isBooked = true;
    //     } else {
    //         foreach ($time_slot as $key => $selected_slot) {
    //             $stay_hours = $hours[$key] ?? 0;

    //             if ($data >= $selected_slot && $data <= ($selected_slot + $stay_hours)) {
    //                 $isBooked = true;
    //                 break;
    //             }
    //         }
    //     }

    //     if ($data == $selectedTimeSlot) {
    //         $selected = 'selected';
    //         $disabled = '';
    //     } elseif ($isBooked) {
    //         $disabled = 'disabled';
    //     }

    //     $label = Helper::timeslotname(strval($data));
    //     if ($isBooked && !$selected) {
    //         $label .= ' (Booked)';
    //     }

    //     $html .= "<option value='" . $data . "' $disabled $selected>" . $label . "</option>";
    // }




    //             $html .= "</select>";

    //             echo $html;

    //     }
    public function get_cleaners_time_slot()
    {
        $date = $_POST['date'];
        $dateObject = new DateTime($date);
        $day = $dateObject->format('j');
        $month = $dateObject->format('F');
        $year = $dateObject->format('Y');
        $cleaner = $_POST['cleaner'];
        $subservice_id = $_POST['subservice_id'];
        $selectedTimeSlot = $_POST['selectedTimeSlot'] ?? $_POST['selected_time_slot'] ?? '';


        // Format selected date
        $selectedDate = DateTime::createFromFormat('Y-F-d', "$year-$month-$day");

        // Get all time slots
        $time_slots = DB::table('subservice_timeslot_price')
            ->where('subservice_id', $subservice_id)
            ->where('is_active', '1')
            ->pluck('time_slot_id')
            ->toArray();

        $matchedBookings = collect();

        if ($cleaner != 2) {
            $all_bookings = DB::table('ci_order_item')
                ->whereRaw("FIND_IN_SET(?, cleaner_id)", [$cleaner])
                ->where('subservice_id', $subservice_id)
                ->where('is_return', '0')
                ->get();

            foreach ($all_bookings as $booking) {
                $bookingDate = DateTime::createFromFormat(
                    'Y-F-d',
                    sprintf('%04d-%s-%02d', $booking->bookingyear, $booking->month, $booking->bookingdate)
                );
                $endDate = new DateTime($booking->end_date);

                if ($booking->how_often_do_you_need_cleaning === 'Once') {
                    if ($bookingDate->format('Y-m-d') == $selectedDate->format('Y-m-d')) {
                        $matchedBookings->push($booking);
                    }
                } elseif ($booking->how_often_do_you_need_cleaning === 'Weekly') {
                    $targetDay = strtolower(trim($booking->which_day_of_the_week_do_you_want_the_service));
                    $current = clone $bookingDate;

                    while (strtolower($current->format('l')) != $targetDay) {
                        $current->modify('+1 day');
                    }

                    while ($current <= $endDate) {
                        if ($current->format('Y-m-d') == $selectedDate->format('Y-m-d')) {
                            $matchedBookings->push($booking);
                            break;
                        }
                        $current->modify('+7 days');
                    }
                } elseif ($booking->how_often_do_you_need_cleaning === 'Multiple times a week') {
                    $days = explode(',', $booking->which_day_of_the_week_do_you_want_the_service);
                    $selectedDay = strtolower($selectedDate->format('l'));

                    $dayMatch = collect($days)->map(fn($d) => strtolower(trim($d)))->contains($selectedDay);

                    if (
                        $dayMatch &&
                        $selectedDate >= $bookingDate &&
                        $selectedDate <= $endDate
                    ) {
                        $matchedBookings->push($booking);
                    }
                }
            }
        }

        // Extract booked time slots and hours
        $booked_slots = $matchedBookings->pluck('time_slot');
        $hours = $matchedBookings->pluck('how_many_hours_should_they_stay');

        // Build time slot dropdown
        $html = '<select id="time_slot" name="time_slot" class="form-control form-select" onchange="time_slot_on_change(this.value);">';
        $html .= "<option value=''>Select Time Slot</option>";

        foreach ($time_slots as $data) {
            $disabled = '';
            $selected = '';
            $isBooked = false;

            if ($cleaner != 2 && in_array($data, $booked_slots->toArray())) {
                $isBooked = true;
            } else {
                foreach ($booked_slots as $key => $selected_slot) {
                    $stay_hours = $hours[$key] ?? 0;

                    if ($data >= $selected_slot && $data <= ($selected_slot + $stay_hours)) {
                        $isBooked = true;
                        break;
                    }
                }
            }

            if ($data == $selectedTimeSlot) {
                $selected = 'selected';
                $disabled = ''; // allow selected one
            } elseif ($isBooked) {
                $disabled = 'disabled';
            }

            $label = Helper::timeslotname(strval($data));
            if ($isBooked && !$selected) {
                $label .= ' (Booked)';
            }

            $html .= "<option value='" . $data . "' $disabled $selected>" . $label . "</option>";
        }

        $html .= "</select>";

        return $html;
    }


    function time_slot_available()
    {
        // echo"<pre>";print_r($_POST);echo"</pre>";exit;
        $time_slot = $_POST['time_slot'];
        $hour_value = $_POST['hour_value'];
        $cleaner = $_POST['cleaner'];
        $subservice_id = $_POST['subservice_id'];

        $service_date = $_POST['service_date'];

        $date_object = new DateTime($service_date);

        $date = $date_object->format('j');
        $month = $date_object->format('F');
        $year = $date_object->format('Y');

        // echo"<pre>";print_r($date);echo"</pre>";
        // echo"<pre>";print_r($month);echo"</pre>";exit;

        if ($cleaner == 2) {
            return response()->json(["status" => "success"]);
        }

        $selected_slots = [];
        for ($i = 0; $i <= $hour_value; $i++) {
            $selected_slots[] = $time_slot + $i;
        }

        // echo"<pre>";print_r($selected_slots);echo"</pre>";exit;

        $availableSlots = DB::table('subservice_timeslot_price')
            ->where('subservice_id', $subservice_id)
            ->where('is_active', '1')
            ->pluck('time_slot_id')
            ->toArray();

        if (array_diff($selected_slots, $availableSlots)) {
            return response()->json(["status" => "error", "message" => "Not enough consecutive slots available for the selected time."]);
        }

        $bookedSlots = DB::table('ci_order_item')
            ->where('bookingdate', $date)
            ->where('month', $month)
            ->where('bookingyear', $year)
            ->whereIn('time_slot', $selected_slots)
            ->where('cleaner_id', $cleaner)
            ->get();

        if ($bookedSlots->count() > 0) {
            return response()->json(["status" => "error", "message" => "The next consecutive slots are already booked. Please select a different date."]);
        } else {
            return response()->json(["status" => "success"]);
        }
    }
    function order_status_change(Request $request)
    {
        $order_status_value = $request->order_status_value;
        $order_id = $request->order_id;

        if ($order_status_value !== "") {
            DB::table('ci_orders')->where('order_id', $order_id)->update(['order_status' => $order_status_value]);

            if ($order_status_value == "CL") {
                DB::table('ci_orders')->where('order_id', $order_id)->update([
                    'cancel_date_time' => Carbon::now('Asia/Dubai')->toDateTimeString(),
                ]);

                DB::table('ci_order_item')->where('order_id', $order_id)->update([
                    'end_date' => Carbon::now('Asia/Dubai')->toDateString(),
                ]);
            }
            return 1;
        }
    }

    function payment_status_change()
    {

        // echo"<pre>";print_r($_POST);echo"</pre>";exit;

        $payment_status_value = $_POST['payment_status_value'];
        $order_id = $_POST['order_id'];

        if ($payment_status_value !== "") {
            DB::table('ci_orders')->where('order_id', $order_id)->update(['payment_status' => $payment_status_value]);

            echo 1;
        }
    }

    function cleaning_order_store(Request $request)
    {
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;


        $intOrderNumber = DB::table('ci_orders')
            ->select(DB::raw('MAX(order_id) as lastOrderNumber'))
            ->first();
        $nextOrderNumber = 0;
        if ($intOrderNumber) {
            $intOrderNumber = $intOrderNumber->lastOrderNumber + 1;

            $intOrderNumber_new = $intOrderNumber;
            $nextOrderNumber;
        } else {
            $intOrderNumber_new = 1;
        }
        $user_id = $request->customer_id;


        if ($request->subservice_id == '28') {

            // echo"here in cleaning";exit;

            $timing_date_charge = $request->timing_charge + $request->date_charge;

            $additional_charge = $request->hour_value * $request->how_many_cleaner * $request->cleaning_material_charge;

            if ($request->payment_method == 'ONLINE') {
                $mode = 2;
            } else {
                $mode = 1;
            }

            $subservice_id = $request->subservice_id;
            $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($request->city) . '%'])->first();

            $subserviceData = DB::table('subservices')->where('id', $subservice_id)->first();

            if (isset($subserviceData)) {
                if (isset($subserviceData->subservice_code)) {
                    $subserviceCode = $subserviceData->subservice_code;
                } else {
                    $subserviceCode = 'OT';
                }
            } else {
                $subserviceCode = 'OT';
            }

            $cityCode = 'DU';
            if (isset($cityData)) {
                if (isset($cityData->city_code)) {
                    $cityCode = $cityData->city_code;
                } else {
                    $cityCode = 'OT';
                }
            }

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

            // echo"<pre>";print_r($formatOrderId);echo"</pre>";exit;
            $content = array(
                'user_id'               => $user_id,
                'order_number'          => $intOrderNumber_new,
                'order_total'           => $request->order_total,
                'vatcharge'             => $request->vat_charge,
                'front_wallet_amount'   => '0',
                'order_currency'        => 'AED',
                'order_status'          => 'BK',
                'paymentmode'           => $mode,
                'payment_status'        => 'Success',
                'created_at'            => date('Y-m-d H:i:s'),
                'list_order_status'     => '0',
                'date_charge'       => $request->date_charge_hidden,
                'time_charge'       => $request->time_charge_hidden,
                'cleaner_per_hour_charge'       => $request->cleaner_per_hour_charge,
                'material_charge_per_hour'       => $request->cleaning_material_charge,
                'service_charge'     => $request->service_charge,
                'timing_charge'     => $timing_date_charge,
                'additional_charge' => $additional_charge,
                'sub_total'     => $request->sub_total,
                'cod_charge'     => $request->cod_charge,
                'service_fee'     => $request->service_fee,
                'send_notification'     => $request->send_notification,
                'order_from'     => '1',
                'subservice_code'       => $subserviceCode,
                'city_code'             => $cityCode,
                'order_year'            => $year,
                'sequence_no'           => $nextSequence,
                'format_order_id'           => $formatOrderId,
            );
            // echo"<pre>";print_r($content);echo"</pre>";exit;

            $arrOrderId = DB::table('ci_orders')->insertGetId($content);

            // $year = date('y');
            // $data_u['format_order_id'] = "VC-" . $year ."-UAE-". sprintf("%06d", $arrOrderId);
            // DB::table('ci_orders')->where('order_id', $arrOrderId)->update($data_u);

            $service_id = DB::table('subservices')->where('id', $request->subservice_id)->pluck('serviceid')->first();

            $bookingdate = $request->service_date;
            $bookingyear = date('Y', strtotime($bookingdate));
            $month = date('F', strtotime($bookingdate)); // e.g., February
            $day = date('j', strtotime($bookingdate));   // e.g., 5 (without leading zero)
            $formatted_date = date('Y-m-d', strtotime($bookingdate)); // full date
            $which_day_of_the_week_do_you_want_the_service = null;

            // Determine end date and day of week based on repeat frequency
            switch ($request->how_often_you_need) {
                case 'Once':
                    $end_date = $formatted_date;
                    $which_day_of_the_week_do_you_want_the_service = date('l', strtotime($formatted_date)); // e.g., Monday
                    break;

                case 'Weekly':
                    $end_date = date('Y-m-d', strtotime($formatted_date . ' +1 year'));
                    $which_day_of_the_week_do_you_want_the_service = date('l', strtotime($formatted_date));
                    break;

                case 'Multiple times a week':
                    $end_date = date('Y-m-d', strtotime($formatted_date . ' +1 year'));
                    if (!empty($request->which_day_you_want) && is_array($request->which_day_you_want)) {
                        $which_day_of_the_week_do_you_want_the_service = implode(',', $request->which_day_you_want);
                    } else {
                        $which_day_of_the_week_do_you_want_the_service = null; // fallback
                    }
                    break;

                default:
                    $end_date = $formatted_date;
                    break;
            }

            // Save to DB
            $data = [
                'order_id'                             => $arrOrderId,
                'user_info_id'                         => $user_id,
                'cleaner_id'                           => $request->cleaner,
                'service_id'                           => $service_id,
                'subservice_id'                        => $request->subservice_id,
                'how_many_cleaners_do_you_need'        => $request->how_many_cleaner,
                'how_many_hours_should_they_stay'      => $request->hour_value,
                'how_often_do_you_need_cleaning'       => $request->how_often_you_need,
                'do_you_need_cleaning_material'        => $request->need_cleaning_material,
                'any_special_instruction'              => $request->special_instruction,
                'address_type'                         => $request->address_type,
                'city'                                 => $request->city,
                'area'                                 => $request->area,
                'building_street_no'                   => $request->building_name,
                'apartment_villa_no'                   => $request->apartment_villa_num,
                'bookingdate'                          => $day,
                'bookingyear'                          => $bookingyear,
                'month'                                => $month,
                'end_date'                             => $end_date,
                'time_slot'                            => $request->time_slot,
                'which_day_of_the_week_do_you_want_the_service' => $which_day_of_the_week_do_you_want_the_service,
                'cdate'                                => date('Y-m-d'),
            ];

            // echo"<pre>";print_r($data);echo"</pre>";exit;
            $order_item_id = DB::table('ci_order_item')->insertGetId($data);


            $shipping_data = array(
                'order_id'      => $arrOrderId,
                'user_id'       => $user_id,
                'first_name'    => "",
                'last_name'     => "",
                'country'       => "",
                'address1'      => "",
                'state'         => "",
                'city'          => "",
                'zipcode'       => "",
                'address2'      => "",
                'phone_number'  => "",
                'email_address' => "",
            );

            DB::table('ci_shipping_address')->insert($shipping_data);
        } else {

            // echo"<pre>";print_r($_POST);echo"</pre>";exit;

            /* ---------------- SERVICE & CITY CODE ---------------- */

            $subservice_id = $request->subservice_id;
            $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($request->city) . '%'])->first();
            $subserviceData = DB::table('subservices')->where('id', $subservice_id)->first();

            if (isset($subserviceData)) {
                if (isset($subserviceData->subservice_code)) {
                    $subserviceCode = $subserviceData->subservice_code;
                } else {
                    $subserviceCode = 'OT';
                }
            } else {
                $subserviceCode = 'OT';
            }

            $cityCode = 'DU';
            if (isset($cityData)) {
                if (isset($cityData->city_code)) {
                    $cityCode = $cityData->city_code;
                } else {
                    $cityCode = 'OT';
                }
            }
            // echo $request->city."<br>";
            // echo $cityCode;
            // echo"<pre>";print_r($cityData);echo"</pre>";exit;
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

            $timing_date_charge = $request->timing_charge + $request->date_charge;
            // echo"here";exit;
            $content = array(
                'user_id'               => $user_id,
                'order_number'          => $intOrderNumber_new,
                'order_total'           => $request->order_total,
                'vatcharge'             => $request->vat_charge,
                'front_wallet_amount'   => '0',
                'order_currency'        => 'AED',
                'order_status'          => 'P',
                'paymentmode'           => '1',
                'payment_status'        => 'Success',
                'created_at'            => date('Y-m-d H:i:s'),
                'list_order_status'     => '0',
                'service_charge'     => $request->service_charge,
                'timing_charge'     => $timing_date_charge,
                'additional_charge' => "",
                'sub_total'     => $request->sub_total,
                'cod_charge'     => $request->cod_charge,
                'service_fee'     => $request->service_fee,
                'order_from'     => '1',
                'subservice_code'       => $subserviceCode,
                'city_code'             => $cityCode,
                'order_year'            => $year,
                'sequence_no'           => $nextSequence,
                'format_order_id'           => $formatOrderId,
            );

            // echo"<pre>";print_r($content);echo"</pre>";exit;

            $arrOrderId = DB::table('ci_orders')->insertGetId($content);

            // $year = date('y');
            // $data_u['format_order_id'] = "VC-" . $year ."-UAE-". sprintf("%06d", $arrOrderId);
            // DB::table('ci_orders')->where('order_id', $arrOrderId)->update($data_u);

            $service_id = DB::table('subservices')->where('id', $request->subservice_id)->pluck('serviceid')->first();

            $bookingdate = $request->service_date;
            $bookingyear = date('Y', strtotime($request->service_date));
            $month = date('F', strtotime($request->service_date)); // Full month name (e.g., February)
            $day = date('j', strtotime($request->service_date));




            $data = array(
                'order_id'                             => $arrOrderId,
                'user_info_id'                         => $user_id,
                'cleaner_id'                           => $request->cleaner,
                'service_id'                           => $service_id,
                'subservice_id'                        => $request->subservice_id,
                'how_many_cleaners_do_you_need'        => $request->how_many_cleaner,
                'how_many_hours_should_they_stay'      => $request->hour_value,
                'how_often_do_you_need_cleaning'       => $request->how_often_you_need,
                'do_you_need_cleaning_material'        => $request->need_cleaning_material,
                'any_special_instruction'              => $request->special_instruction,
                'address_type'                         => $request->address_type,
                'city'                                 => $request->city,
                'area'                                 => $request->area,
                'building_street_no'                   => $request->building_name,
                'apartment_villa_no'                   => $request->apartment_villa_num,
                'bookingdate'                          => $day,
                'bookingyear'                          => $bookingyear,
                'month'                                => $month,
                'time_slot'                            => $request->time_slot,
                'which_day_of_the_week_do_you_want_the_service' => implode(',', $request->which_day_you_want ?? []),
                'cdate'                                => date('Y-m-d'),
            );

            $order_item_id = DB::table('ci_order_item')->insertGetId($data);


            if (!empty($request->package) && is_array($request->package)) {
                $service_name = DB::table('services')->where('id', $service_id)->value('servicename');
                $subservice_name = DB::table('subservices')->where('id', $request->subservice_id)->value('subservicename');

                foreach ($request->package as $packageId) {
                    $quantityKey = $packageId . '_quantity';
                    $priceKey = $packageId . '_price';

                    // Fetch package item details
                    $package_item = DB::table('packages')->where('id', $packageId)->first();

                    if ($package_item) {
                        // Fetch the category details for this specific package
                        $package_category_id = $package_item->packagecategory_id;
                        $package_category_name = DB::table('package_categories')->where('id', $package_category_id)->value('name');

                        // Check if quantity and price exist
                        if (isset($request->$quantityKey) && isset($request->$priceKey)) {
                            $data = [
                                'order_id'              => $arrOrderId,
                                'order_item_id'         => $order_item_id,
                                'user_info_id'          => $user_id,
                                'package_id'            => $packageId,
                                'package_item_name'     => $package_item->name,
                                'package_quantity'      => is_array($request->$quantityKey) ? implode(',', $request->$quantityKey) : $request->$quantityKey,
                                'package_item_price'    => is_array($request->$priceKey) ? implode(',', $request->$priceKey) : $request->$priceKey,
                                'service_id'            => $service_id,
                                'service_name'          => $service_name,
                                'subservice_id'         => $request->subservice_id,
                                'subservice_name'       => $subservice_name,
                                'packagecategory_id'    => $package_category_id,
                                'packagecategory_name'  => $package_category_name,
                                'page_url'              => $package_item->page_url,
                                'image'                 => $package_item->image,
                                'cdate'                 => date('Y-m-d'),
                            ];

                            // Insert data into the database
                            DB::table('ci_order_item_packages')->insertGetId($data);
                        }
                    }
                }
            }

            $shipping_data = array(
                'order_id'      => $arrOrderId,
                'user_id'       => $user_id,
                'first_name'    => "",
                'last_name'     => "",
                'country'       => "",
                'address1'      => "",
                'state'         => "",
                'city'          => "",
                'zipcode'       => "",
                'address2'      => "",
                'phone_number'  => "",
                'email_address' => "",
            );

            DB::table('ci_shipping_address')->insert($shipping_data);
        }

        // Send Email to User

        if ($request->send_notification == 'yes') {
            $this->success_book_now_mail($user_id, $arrOrderId);
            $this->success_whatsapp_message($user_id, $arrOrderId);
        }



        return redirect()->route('cleaning_package_order')->with('success', 'Order has been added successfully');
    }

    function cleaning_order_update(Request $request, $id)
    {
        $order_id = $id;
        $user_id = $request->customer_id;

        if (!$order_id) {
            // Handle error: can't update without IDs
            return back()->with('error', 'Order ID or Order Item ID missing.');
        }

        $mode = ($request->payment_method == 'ONLINE') ? 2 : 1;

        // Prepare order data to update
        $content = [
            'user_id'             => $user_id,
            'order_total'         => $request->order_total,
            'vatcharge'           => $request->vat_charge,
            'front_wallet_amount' => '0',
            'order_currency'      => 'AED',
            'order_status'        => 'P',
            'paymentmode'         => $mode,
            'payment_status'      => 'Success',
            'service_charge'      => $request->service_charge,
            'timing_charge'       => $request->time_charge_hidden + $request->date_charge_hidden,
            'date_charge'       => $request->date_charge_hidden,
            'time_charge'       => $request->time_charge_hidden,
            'cleaner_per_hour_charge'       => $request->cleaner_per_hour_charge,
            'material_charge_per_hour'       => $request->cleaning_material_charge,
            'additional_charge'   => $request->hour_value * $request->how_many_cleaner * $request->cleaning_material_charge,
            'sub_total'           => $request->sub_total,
            'cod_charge'          => $request->cod_charge,
            'service_fee'         => $request->service_fee,
            'date_charge'         => $request->date_charge,
            'material_charge_per_hour' => $request->cleaning_material_charge,
            'service_fee'         => $request->service_fee,
            'order_from'          => '1',

        ];

        // Update order
        DB::table('ci_orders')->where('order_id', $order_id)->update($content);


        // Prepare order item update data
        $service_id = DB::table('subservices')->where('id', $request->subservice_id)->pluck('serviceid')->first();

        // $bookingdate = $request->service_date;
        // $bookingyear = date('Y', strtotime($bookingdate));
        // $month = date('F', strtotime($bookingdate));
        // $day = date('j', strtotime($bookingdate));



        // $order_item_data = [
        //     'order_id'                                 => $order_id,
        //     'user_info_id'                             => $user_id,
        //     'cleaner_id'                               => $request->cleaner,
        //     'service_id'                               => $service_id,
        //     'subservice_id'                            => $request->subservice_id,
        //     'how_many_cleaners_do_you_need'            => $request->how_many_cleaner,
        //     'how_many_hours_should_they_stay'          => $request->hour_value,
        //     'how_often_do_you_need_cleaning'           => $request->how_often_you_need,
        //     'do_you_need_cleaning_material'            => $request->need_cleaning_material,
        //     'any_special_instruction'                   => $request->special_instruction,
        //     'address_type'                             => $request->address_type,
        //     'city'                                     => $request->city,
        //     'area'                                     => $request->area,
        //     'building_street_no'                       => $request->building_name,
        //     'apartment_villa_no'                       => $request->apartment_villa_num,
        //     'bookingdate'                              => $day,
        //     'bookingyear'                              => $bookingyear,
        //     'month'                                    => $month,
        //     'time_slot'                                => $request->time_slot,
        //     'which_day_of_the_week_do_you_want_the_service' => implode(',', $request->which_day_you_want ?? []),
        //     'cdate'                                    => date('Y-m-d'),
        // ];
        $bookingdate = $request->service_date;
        $bookingyear = date('Y', strtotime($bookingdate));
        $month = date('F', strtotime($bookingdate)); // e.g., February
        $day = date('j', strtotime($bookingdate));   // e.g., 5 (without leading zero)
        $formatted_date = date('Y-m-d', strtotime($bookingdate)); // full date
        $which_day_of_the_week_do_you_want_the_service = null;

        // Determine end date and day of week based on repeat frequency
        switch ($request->how_often_you_need) {
            case 'Once':
                $end_date = $formatted_date;
                $which_day_of_the_week_do_you_want_the_service = date('l', strtotime($formatted_date)); // e.g., Monday
                break;

            case 'Weekly':
                $end_date = date('Y-m-d', strtotime($formatted_date . ' +1 year'));
                $which_day_of_the_week_do_you_want_the_service = date('l', strtotime($formatted_date));
                break;

            case 'Multiple times a week':
                $end_date = date('Y-m-d', strtotime($formatted_date . ' +1 year'));
                if (!empty($request->which_day_you_want) && is_array($request->which_day_you_want)) {
                    $which_day_of_the_week_do_you_want_the_service = implode(',', $request->which_day_you_want);
                } else {
                    $which_day_of_the_week_do_you_want_the_service = null; // fallback
                }
                break;

            default:
                $end_date = $formatted_date;
                break;
        }

        // Save to DB
        $order_item_data = [
            'order_id'                             => $order_id,
            'user_info_id'                         => $user_id,
            'cleaner_id'                           => $request->cleaner,
            'service_id'                           => $service_id,
            'subservice_id'                        => $request->subservice_id,
            'how_many_cleaners_do_you_need'        => $request->how_many_cleaner,
            'how_many_hours_should_they_stay'      => $request->hour_value,
            'how_often_do_you_need_cleaning'       => $request->how_often_you_need,
            'do_you_need_cleaning_material'        => $request->need_cleaning_material,
            'any_special_instruction'              => $request->special_instruction,
            'address_type'                         => $request->address_type,
            'city'                                 => $request->city,
            'area'                                 => $request->area,
            'building_street_no'                   => $request->building_name,
            'apartment_villa_no'                   => $request->apartment_villa_num,
            'bookingdate'                          => $day,
            'bookingyear'                          => $bookingyear,
            'month'                                => $month,
            'end_date'                             => $end_date,
            'time_slot'                            => $request->time_slot,
            'which_day_of_the_week_do_you_want_the_service' => $which_day_of_the_week_do_you_want_the_service,
            'cdate'                                => date('Y-m-d'),
        ];

        DB::table('ci_order_item')->where('order_id', $order_id)->update($order_item_data);

        $orderItem = DB::table('ci_order_item')->where('order_id', $order_id)->first();

        DB::table('ci_order_item_packages')->where('order_id', $order_id)->delete();

        if (!empty($request->package) && is_array($request->package)) {
            $service_name = DB::table('services')->where('id', $service_id)->value('servicename');
            $subservice_name = DB::table('subservices')->where('id', $request->subservice_id)->value('subservicename');

            foreach ($request->package as $packageId) {
                $quantityKey = $packageId . '_quantity';
                $priceKey = $packageId . '_price';

                // Fetch package item details
                $package_item = DB::table('packages')->where('id', $packageId)->first();

                if ($package_item) {
                    // Fetch the category details for this specific package
                    $package_category_id = $package_item->packagecategory_id;
                    $package_category_name = DB::table('package_categories')->where('id', $package_category_id)->value('name');

                    // Check if quantity and price exist
                    if (isset($request->$quantityKey) && isset($request->$priceKey)) {

                        $data = [
                            'order_id'              => $order_id,
                            'order_item_id'         => $orderItem->id,
                            'user_info_id'          => $user_id,
                            'package_id'            => $packageId,
                            'package_item_name'     => $package_item->name,
                            'package_quantity'      => is_array($request->$quantityKey) ? implode(',', $request->$quantityKey) : $request->$quantityKey,
                            'package_item_price'    => is_array($request->$priceKey) ? implode(',', $request->$priceKey) : $request->$priceKey,
                            'service_id'            => $service_id,
                            'service_name'          => $service_name,
                            'subservice_id'         => $request->subservice_id,
                            'subservice_name'       => $subservice_name,
                            'packagecategory_id'    => $package_category_id,
                            'packagecategory_name'  => $package_category_name,
                            'page_url'              => $package_item->page_url,
                            'image'                 => $package_item->image,
                            'cdate'                 => date('Y-m-d'),
                        ];

                        // Insert data into the database
                        DB::table('ci_order_item_packages')->insertGetId($data);
                    }
                }
            }
        }


        // Prepare shipping data to update
        $shipping_data = [
            'first_name'     => "",
            'last_name'      => "",
            'country'        => "",
            'address1'       => "",
            'state'          => "",
            'city'           => "",
            'zipcode'        => "",
            'address2'       => "",
            'phone_number'   => "",
            'email_address'  => "",
        ];

        // Update shipping address
        DB::table('ci_shipping_address')->where('order_id', $order_id)->update($shipping_data);
        return redirect()->route('cleaning_package_order')->with('success', 'Order has been updated successfully');
    }
    function salon_spa_order_store(Request $request)
    {
        // echo"<pre>";print_r($_POST);echo"</pre>";exit;


        $intOrderNumber = DB::table('ci_orders')
            ->select(DB::raw('MAX(order_id) as lastOrderNumber'))
            ->first();

        $nextOrderNumber = 0;
        if ($intOrderNumber) {
            $intOrderNumber = $intOrderNumber->lastOrderNumber + 1;

            $intOrderNumber_new = $intOrderNumber;
            $nextOrderNumber;
        } else {
            $intOrderNumber_new = 1;
        }
        $user_id = $request->customer_id;


        if ($request->subservice_id != '') {

            // echo"<pre>aaa";print_r($_POST);echo"</pre>";exit;

            $timing_date_charge = $request->timing_charge + $request->date_charge;

            if ($request->payment_method == 'ONLINE') {
                $mode = 2;
            } else {
                $mode = 1;
            }

            $subservice_id = $request->subservice_id;
            $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($request->city) . '%'])->first();
            $subserviceData = DB::table('subservices')->where('id', $subservice_id)->first();

            if (isset($subserviceData)) {
                if (isset($subserviceData->subservice_code)) {
                    $subserviceCode = $subserviceData->subservice_code;
                } else {
                    $subserviceCode = 'OT';
                }
            } else {
                $subserviceCode = 'OT';
            }

            $cityCode = 'DU';
            if (isset($cityData)) {
                if (isset($cityData->city_code)) {
                    $cityCode = $cityData->city_code;
                } else {
                    $cityCode = 'OT';
                }
            }

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

            $content = array(
                'user_id'               => $user_id,
                'order_number'          => $intOrderNumber_new,
                'order_total'           => $request->order_total,
                'vatcharge'             => $request->vat_charge,
                'front_wallet_amount'   => '0',
                'order_currency'        => 'AED',
                'order_status'          => 'BK',
                'paymentmode'           => $mode,
                'payment_status'        => 'Success',
                'created_at'            => date('Y-m-d H:i:s'),
                'list_order_status'     => '0',
                'service_charge'     => $request->service_charge,
                'timing_charge'     => $timing_date_charge,
                'additional_charge' => "",
                'sub_total'     => $request->sub_total,
                'cod_charge'     => $request->cod_charge,
                'service_fee'     => $request->service_fee,
                'send_notification'     => $request->send_notification,
                'order_from'     => '1',
                'subservice_code'       => $subserviceCode,
                'city_code'             => $cityCode,
                'order_year'            => $year,
                'sequence_no'           => $nextSequence,
                'format_order_id'           => $formatOrderId,
            );

            $arrOrderId = DB::table('ci_orders')->insertGetId($content);

            // $year = date('y');
            // $data_u['format_order_id'] = "VC-" . $year ."-UAE-". sprintf("%06d", $arrOrderId);
            // DB::table('ci_orders')->where('order_id', $arrOrderId)->update($data_u);

            $service_id = DB::table('subservices')->where('id', $request->subservice_id)->pluck('serviceid')->first();

            $bookingdate = $request->service_date;
            $bookingyear = date('Y', strtotime($request->service_date));
            $month = date('F', strtotime($request->service_date)); // Full month name (e.g., February)
            $day = date('j', strtotime($request->service_date));

            $data = array(
                'order_id'                             => $arrOrderId,
                'user_info_id'                         => $user_id,
                'cleaner_id'                           => $request->cleaner,
                'service_id'                           => $service_id,
                'subservice_id'                        => $request->subservice_id,
                'how_many_cleaners_do_you_need'        => $request->how_many_cleaner,
                'how_many_hours_should_they_stay'      => $request->hour_value,
                'how_often_do_you_need_cleaning'       => $request->how_often_you_need,
                'do_you_need_cleaning_material'        => $request->need_cleaning_material,
                'any_special_instruction'              => $request->special_instruction,
                'address_type'                         => $request->address_type,
                'city'                                 => $request->city,
                'area'                                 => $request->area,
                'building_street_no'                   => $request->building_name,
                'apartment_villa_no'                   => $request->apartment_villa_num,
                'bookingdate'                          => $day,
                'bookingyear'                          => $bookingyear,
                'month'                                => $month,
                'time_slot'                            => $request->time_slot,
                'which_day_of_the_week_do_you_want_the_service' => implode(',', $request->which_day_you_want ?? []),
                'cdate'                                => date('Y-m-d'),
            );

            $order_item_id = DB::table('ci_order_item')->insertGetId($data);


            if (!empty($request->package) && is_array($request->package)) {
                $service_name = DB::table('services')->where('id', $service_id)->value('servicename');
                $subservice_name = DB::table('subservices')->where('id', $request->subservice_id)->value('subservicename');

                foreach ($request->package as $packageId) {
                    $quantityKey = $packageId . '_quantity';
                    $priceKey = $packageId . '_price';

                    // Fetch package item details
                    $package_item = DB::table('packages')->where('id', $packageId)->first();

                    if ($package_item) {
                        // Fetch the category details for this specific package
                        $package_category_id = $package_item->packagecategory_id;
                        $package_category_name = DB::table('package_categories')->where('id', $package_category_id)->value('name');

                        // Check if quantity and price exist
                        if (isset($request->$quantityKey) && isset($request->$priceKey)) {
                            $data = [
                                'order_id'              => $arrOrderId,
                                'order_item_id'         => $order_item_id,
                                'user_info_id'          => $user_id,
                                'package_id'            => $packageId,
                                'package_item_name'     => $package_item->name,
                                'package_quantity'      => is_array($request->$quantityKey) ? implode(',', $request->$quantityKey) : $request->$quantityKey,
                                'package_item_price'    => is_array($request->$priceKey) ? implode(',', $request->$priceKey) : $request->$priceKey,
                                'service_id'            => $service_id,
                                'service_name'          => $service_name,
                                'subservice_id'         => $request->subservice_id,
                                'subservice_name'       => $subservice_name,
                                'packagecategory_id'    => $package_category_id,
                                'packagecategory_name'  => $package_category_name,
                                'page_url'              => $package_item->page_url,
                                'image'                 => $package_item->image,
                                'cdate'                 => date('Y-m-d'),
                            ];

                            // Insert data into the database
                            DB::table('ci_order_item_packages')->insertGetId($data);
                        }
                    }
                }
            }
            $shipping_data = array(
                'order_id'      => $arrOrderId,
                'user_id'       => $user_id,
                'first_name'    => "",
                'last_name'     => "",
                'country'       => "",
                'address1'      => "",
                'state'         => "",
                'city'          => "",
                'zipcode'       => "",
                'address2'      => "",
                'phone_number'  => "",
                'email_address' => "",
            );

            DB::table('ci_shipping_address')->insert($shipping_data);
        }

        if ($request->send_notification == 'yes') {
            $this->success_book_now_mail($user_id, $arrOrderId);
            $this->success_whatsapp_message($user_id, $arrOrderId);
        }


        return redirect()->route('salon-spa-order')->with('success', 'Order has been added successfully');
    }

    function pest_control_order_store(Request $request)
    {
        // echo"<pre>";print_r($_POST);echo"</pre>";exit;


        $intOrderNumber = DB::table('ci_orders')
            ->select(DB::raw('MAX(order_id) as lastOrderNumber'))
            ->first();

        $nextOrderNumber = 0;
        if ($intOrderNumber) {
            $intOrderNumber = $intOrderNumber->lastOrderNumber + 1;

            $intOrderNumber_new = $intOrderNumber;
            $nextOrderNumber;
        } else {
            $intOrderNumber_new = 1;
        }
        $user_id = $request->customer_id;


        if ($request->subservice_id != '') {

            // echo"<pre>aaa";print_r($_POST);echo"</pre>";exit;

            $timing_date_charge = $request->timing_charge + $request->date_charge;

            if ($request->payment_method == 'ONLINE') {
                $mode = 2;
            } else {
                $mode = 1;
            }

            $subservice_id = $request->subservice_id;
            $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($request->city) . '%'])->first();
            $subserviceData = DB::table('subservices')->where('id', $subservice_id)->first();

            if (isset($subserviceData)) {
                if (isset($subserviceData->subservice_code)) {
                    $subserviceCode = $subserviceData->subservice_code;
                } else {
                    $subserviceCode = 'OT';
                }
            } else {
                $subserviceCode = 'OT';
            }

            $cityCode = 'DU';
            if (isset($cityData)) {
                if (isset($cityData->city_code)) {
                    $cityCode = $cityData->city_code;
                } else {
                    $cityCode = 'OT';
                }
            }
            // echo $request->city."<br>";
            // echo $cityCode;
            // echo"<pre>";print_r($cityData);echo"</pre>";exit;
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

            // echo"here";exit;
            $content = array(
                'user_id'               => $user_id,
                'order_number'          => $intOrderNumber_new,
                'order_total'           => $request->order_total,
                'vatcharge'             => $request->vat_charge,
                'front_wallet_amount'   => '0',
                'order_currency'        => 'AED',
                'order_status'          => 'BK',
                'paymentmode'           => $mode,
                'payment_status'        => 'Success',
                'created_at'            => date('Y-m-d H:i:s'),
                'list_order_status'     => '0',
                'service_charge'     => $request->service_charge,
                'timing_charge'     => $timing_date_charge,
                'additional_charge' => "",
                'sub_total'     => $request->sub_total,
                'cod_charge'     => $request->cod_charge,
                'service_fee'     => $request->service_fee,
                'send_notification'     => $request->send_notification,
                'order_from'     => '1',
                'subservice_code'       => $subserviceCode,
                'city_code'             => $cityCode,
                'order_year'            => $year,
                'sequence_no'           => $nextSequence,
                'format_order_id'           => $formatOrderId,
            );

            // echo"<pre>";print_r($content);echo"</pre>";exit;

            $arrOrderId = DB::table('ci_orders')->insertGetId($content);

            // $year = date('y');
            // $data_u['format_order_id'] = "VC-" . $year ."-UAE-". sprintf("%06d", $arrOrderId);
            // DB::table('ci_orders')->where('order_id', $arrOrderId)->update($data_u);

            $service_id = DB::table('subservices')->where('id', $request->subservice_id)->pluck('serviceid')->first();

            $bookingdate = $request->service_date;
            $bookingyear = date('Y', strtotime($request->service_date));
            $month = date('F', strtotime($request->service_date)); // Full month name (e.g., February)
            $day = date('j', strtotime($request->service_date));




            $data = array(
                'order_id'                             => $arrOrderId,
                'user_info_id'                         => $user_id,
                'cleaner_id'                           => $request->cleaner,
                'service_id'                           => $service_id,
                'subservice_id'                        => $request->subservice_id,
                'how_many_cleaners_do_you_need'        => $request->how_many_cleaner,
                'how_many_hours_should_they_stay'      => $request->hour_value,
                'how_often_do_you_need_cleaning'       => $request->how_often_you_need,
                'do_you_need_cleaning_material'        => $request->need_cleaning_material,
                'any_special_instruction'              => $request->special_instruction,
                'address_type'                         => $request->address_type,
                'city'                                 => $request->city,
                'area'                                 => $request->area,
                'building_street_no'                   => $request->building_name,
                'apartment_villa_no'                   => $request->apartment_villa_num,
                'bookingdate'                          => $day,
                'bookingyear'                          => $bookingyear,
                'month'                                => $month,
                'time_slot'                            => $request->time_slot,
                'which_day_of_the_week_do_you_want_the_service' => implode(',', $request->which_day_you_want ?? []),
                'cdate'                                => date('Y-m-d'),
            );

            $order_item_id = DB::table('ci_order_item')->insertGetId($data);


            if (!empty($request->package) && is_array($request->package)) {
                $service_name = DB::table('services')->where('id', $service_id)->value('servicename');
                $subservice_name = DB::table('subservices')->where('id', $request->subservice_id)->value('subservicename');

                foreach ($request->package as $packageId) {
                    $quantityKey = $packageId . '_quantity';
                    $priceKey = $packageId . '_price';

                    // Fetch package item details
                    $package_item = DB::table('packages')->where('id', $packageId)->first();

                    if ($package_item) {
                        // Fetch the category details for this specific package
                        $package_category_id = $package_item->packagecategory_id;
                        $package_category_name = DB::table('package_categories')->where('id', $package_category_id)->value('name');

                        // Check if quantity and price exist
                        if (isset($request->$quantityKey) && isset($request->$priceKey)) {
                            $data = [
                                'order_id'              => $arrOrderId,
                                'order_item_id'         => $order_item_id,
                                'user_info_id'          => $user_id,
                                'package_id'            => $packageId,
                                'package_item_name'     => $package_item->name,
                                'package_quantity'      => is_array($request->$quantityKey) ? implode(',', $request->$quantityKey) : $request->$quantityKey,
                                'package_item_price'    => is_array($request->$priceKey) ? implode(',', $request->$priceKey) : $request->$priceKey,
                                'service_id'            => $service_id,
                                'service_name'          => $service_name,
                                'subservice_id'         => $request->subservice_id,
                                'subservice_name'       => $subservice_name,
                                'packagecategory_id'    => $package_category_id,
                                'packagecategory_name'  => $package_category_name,
                                'page_url'              => $package_item->page_url,
                                'image'                 => $package_item->image,
                                'cdate'                 => date('Y-m-d'),
                            ];

                            // Insert data into the database
                            DB::table('ci_order_item_packages')->insertGetId($data);
                        }
                    }
                }
            }
            $shipping_data = array(
                'order_id'      => $arrOrderId,
                'user_id'       => $user_id,
                'first_name'    => "",
                'last_name'     => "",
                'country'       => "",
                'address1'      => "",
                'state'         => "",
                'city'          => "",
                'zipcode'       => "",
                'address2'      => "",
                'phone_number'  => "",
                'email_address' => "",
            );

            DB::table('ci_shipping_address')->insert($shipping_data);
        }

        if ($request->send_notification == 'yes') {
            $this->success_book_now_mail($user_id, $arrOrderId);
            $this->success_whatsapp_message($user_id, $arrOrderId);
        }


        return redirect()->route('pest-control-order')->with('success', 'Order has been added successfully');
    }

    function handyman_service_order_store(Request $request)
    {
        // echo"<pre>";print_r($request->all());exit;
        $intOrderNumber = DB::table('ci_orders')
            ->select(DB::raw('MAX(order_id) as lastOrderNumber'))
            ->first();

        $nextOrderNumber = 0;
        if ($intOrderNumber) {
            $intOrderNumber = $intOrderNumber->lastOrderNumber + 1;

            $intOrderNumber_new = $intOrderNumber;
            $nextOrderNumber;
        } else {
            $intOrderNumber_new = 1;
        }
        $user_id = $request->customer_id;


        if ($request->subservice_id != '') {

            $timing_date_charge = $request->timing_charge + $request->date_charge;
            if ($request->payment_method == 'ONLINE') {
                $mode = 2;
            } else {
                $mode = 1;
            }

            $subservice_id = $request->subservice_id;
            $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($request->city) . '%'])->first();
            $subserviceData = DB::table('subservices')->where('id', $subservice_id)->first();

            if (isset($subserviceData)) {
                if (isset($subserviceData->subservice_code)) {
                    $subserviceCode = $subserviceData->subservice_code;
                } else {
                    $subserviceCode = 'OT';
                }
            } else {
                $subserviceCode = 'OT';
            }

            $cityCode = 'DU';
            if (isset($cityData)) {
                if (isset($cityData->city_code)) {
                    $cityCode = $cityData->city_code;
                } else {
                    $cityCode = 'OT';
                }
            }

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

            $content = array(
                'user_id'               => $user_id,
                'order_number'          => $intOrderNumber_new,
                'order_total'           => $request->order_total,
                'vatcharge'             => $request->vat_charge,
                'front_wallet_amount'   => '0',
                'order_currency'        => 'AED',
                'order_status'          => 'BK',
                'paymentmode'           => $mode,
                'payment_status'        => 'Success',
                'created_at'            => date('Y-m-d H:i:s'),
                'list_order_status'     => '0',
                'service_charge'     => $request->service_charge,
                'timing_charge'     => $timing_date_charge,
                'additional_charge' => "",
                'sub_total'     => $request->sub_total,
                'cod_charge'     => $request->cod_charge,
                'service_fee'     => $request->service_fee,
                'send_notification'     => $request->send_notification,
                'order_from'     => '1',
                'subservice_code'       => $subserviceCode,
                'city_code'             => $cityCode,
                'order_year'            => $year,
                'sequence_no'           => $nextSequence,
                'format_order_id'           => $formatOrderId,
            );

            $arrOrderId = DB::table('ci_orders')->insertGetId($content);

            // $year = date('y');
            // $data_u['format_order_id'] = "VC-" . $year ."-UAE-". sprintf("%06d", $arrOrderId);
            // DB::table('ci_orders')->where('order_id', $arrOrderId)->update($data_u);

            $service_id = DB::table('subservices')->where('id', $request->subservice_id)->pluck('serviceid')->first();

            $bookingdate = $request->service_date;
            $bookingyear = date('Y', strtotime($request->service_date));
            $month       = date('F', strtotime($request->service_date));
            $day         = date('j', strtotime($request->service_date));

            $formatted_date = date('Y-m-d', strtotime($bookingdate));

            $end_date = $formatted_date;

            $data = array(
                'order_id'                             => $arrOrderId,
                'user_info_id'                         => $user_id,
                'cleaner_id'                           => $request->cleaner,
                'service_id'                           => $service_id,
                'subservice_id'                        => $request->subservice_id,
                'how_many_cleaners_do_you_need'        => $request->how_many_cleaner,
                'how_many_hours_should_they_stay'      => $request->hour_value,
                'how_often_do_you_need_cleaning'       => $request->how_often_you_need,
                'do_you_need_cleaning_material'        => $request->need_cleaning_material,
                'any_special_instruction'              => $request->special_instruction,
                'address_type'                         => $request->address_type,
                'city'                                 => $request->city,
                'area'                                 => $request->area,
                'building_street_no'                   => $request->building_name,
                'apartment_villa_no'                   => $request->apartment_villa_num,
                'bookingdate'                          => $day,
                'bookingyear'                          => $bookingyear,
                'month'                                => $month,
                'end_date'                                => $end_date,
                'time_slot'                            => $request->time_slot,
                'charger_type'                         => $request->charger_type,
                'installation_location_type'           => $request->installation_location_type,
                'installation_charge'                   => $request->installation_charge,
                'which_day_of_the_week_do_you_want_the_service' => implode(',', $request->which_day_you_want ?? []),
                'cdate'                                => date('Y-m-d'),
            );

            $order_item_id = DB::table('ci_order_item')->insertGetId($data);


            if (!empty($request->package) && is_array($request->package)) {
                $service_name = DB::table('services')->where('id', $service_id)->value('servicename');
                $subservice_name = DB::table('subservices')->where('id', $request->subservice_id)->value('subservicename');

                foreach ($request->package as $packageId) {
                    $quantityKey = $packageId . '_quantity';
                    $priceKey = $packageId . '_price';

                    // Fetch package item details
                    $package_item = DB::table('packages')->where('id', $packageId)->first();

                    if ($package_item) {
                        // Fetch the category details for this specific package
                        $package_category_id = $package_item->packagecategory_id;
                        $package_category_name = DB::table('package_categories')->where('id', $package_category_id)->value('name');

                        // Check if quantity and price exist
                        if (isset($request->$quantityKey) && isset($request->$priceKey)) {
                            $data = [
                                'order_id'              => $arrOrderId,
                                'order_item_id'         => $order_item_id,
                                'user_info_id'          => $user_id,
                                'package_id'            => $packageId,
                                'package_item_name'     => $package_item->name,
                                'package_quantity'      => is_array($request->$quantityKey) ? implode(',', $request->$quantityKey) : $request->$quantityKey,
                                'package_item_price'    => is_array($request->$priceKey) ? implode(',', $request->$priceKey) : $request->$priceKey,
                                'service_id'            => $service_id,
                                'service_name'          => $service_name,
                                'subservice_id'         => $request->subservice_id,
                                'subservice_name'       => $subservice_name,
                                'packagecategory_id'    => $package_category_id,
                                'packagecategory_name'  => $package_category_name,
                                'page_url'              => $package_item->page_url,
                                'image'                 => $package_item->image,
                                'cdate'                 => date('Y-m-d'),
                            ];

                            DB::table('ci_order_item_packages')->insertGetId($data);
                        }
                    }
                }
            }

            $shipping_data = array(
                'order_id'      => $arrOrderId,
                'user_id'       => $user_id,
                'first_name'    => "",
                'last_name'     => "",
                'country'       => "",
                'address1'      => "",
                'state'         => "",
                'city'          => "",
                'zipcode'       => "",
                'address2'      => "",
                'phone_number'  => "",
                'email_address' => "",
            );

            DB::table('ci_shipping_address')->insert($shipping_data);
        }

        if ($request->send_notification == 'yes') {
            $this->success_book_now_mail($user_id, $arrOrderId);
            $this->success_whatsapp_message($user_id, $arrOrderId);
        }


        return redirect()->route('handyman-service-order')->with('success', 'Order has been added successfully');
    }
    function automobile_order_store(Request $request)
    {
        // echo"<pre>";print_r($_POST);echo"</pre>";exit;


        $intOrderNumber = DB::table('ci_orders')
            ->select(DB::raw('MAX(order_id) as lastOrderNumber'))
            ->first();

        $nextOrderNumber = 0;
        if ($intOrderNumber) {
            $intOrderNumber = $intOrderNumber->lastOrderNumber + 1;

            $intOrderNumber_new = $intOrderNumber;
            $nextOrderNumber;
        } else {
            $intOrderNumber_new = 1;
        }
        $user_id = $request->customer_id;


        if ($request->subservice_id != '') {

            // echo"<pre>aaa";print_r($_POST);echo"</pre>";exit;

            $timing_date_charge = $request->timing_charge + $request->date_charge;
            if ($request->payment_method == 'ONLINE') {
                $mode = 2;
            } else {
                $mode = 1;
            }

            $subservice_id = $request->subservice_id;
            $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($request->city) . '%'])->first();
            $subserviceData = DB::table('subservices')->where('id', $subservice_id)->first();

            if (isset($subserviceData)) {
                if (isset($subserviceData->subservice_code)) {
                    $subserviceCode = $subserviceData->subservice_code;
                } else {
                    $subserviceCode = 'OT';
                }
            } else {
                $subserviceCode = 'OT';
            }

            $cityCode = 'DU';
            if (isset($cityData)) {
                if (isset($cityData->city_code)) {
                    $cityCode = $cityData->city_code;
                } else {
                    $cityCode = 'OT';
                }
            }
            // echo $request->city."<br>";
            // echo $cityCode;
            // echo"<pre>";print_r($cityData);echo"</pre>";exit;
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
            // echo"here";exit;
            $content = array(
                'user_id'               => $user_id,
                'order_number'          => $intOrderNumber_new,
                'order_total'           => $request->order_total,
                'vatcharge'             => $request->vat_charge,
                'front_wallet_amount'   => '0',
                'order_currency'        => 'AED',
                'order_status'          => 'BK',
                'paymentmode'           => $mode,
                'payment_status'        => 'Success',
                'created_at'            => date('Y-m-d H:i:s'),
                'list_order_status'     => '0',
                'service_charge'     => $request->service_charge,
                'timing_charge'     => $timing_date_charge,
                'additional_charge' => "",
                'sub_total'     => $request->sub_total,
                'cod_charge'     => $request->cod_charge,
                'service_fee'     => $request->service_fee,
                'send_notification'     => $request->send_notification,
                'order_from'     => '1',
                'subservice_code'       => $subserviceCode,
                'city_code'             => $cityCode,
                'order_year'            => $year,
                'sequence_no'           => $nextSequence,
                'format_order_id'           => $formatOrderId,
            );

            // echo"<pre>";print_r($content);echo"</pre>";exit;

            $arrOrderId = DB::table('ci_orders')->insertGetId($content);

            // $year = date('y');
            // $data_u['format_order_id'] = "VC-" . $year ."-UAE-". sprintf("%06d", $arrOrderId);
            // DB::table('ci_orders')->where('order_id', $arrOrderId)->update($data_u);

            $service_id = DB::table('subservices')->where('id', $request->subservice_id)->pluck('serviceid')->first();

            $bookingdate = $request->service_date;
            $bookingyear = date('Y', strtotime($request->service_date));
            $month = date('F', strtotime($request->service_date)); // Full month name (e.g., February)
            $day = date('j', strtotime($request->service_date));




            $data = array(
                'order_id'                             => $arrOrderId,
                'user_info_id'                         => $user_id,
                'cleaner_id'                           => $request->cleaner,
                'service_id'                           => $service_id,
                'subservice_id'                        => $request->subservice_id,
                'how_many_cleaners_do_you_need'        => $request->how_many_cleaner,
                'how_many_hours_should_they_stay'      => $request->hour_value,
                'how_often_do_you_need_cleaning'       => $request->how_often_you_need,
                'do_you_need_cleaning_material'        => $request->need_cleaning_material,
                'any_special_instruction'              => $request->special_instruction,
                'address_type'                         => $request->address_type,
                'city'                                 => $request->city,
                'area'                                 => $request->area,
                'building_street_no'                   => $request->building_name,
                'apartment_villa_no'                   => $request->apartment_villa_num,
                'bookingdate'                          => $day,
                'bookingyear'                          => $bookingyear,
                'month'                                => $month,
                'time_slot'                            => $request->time_slot,
                'which_day_of_the_week_do_you_want_the_service' => implode(',', $request->which_day_you_want ?? []),
                'cdate'                                => date('Y-m-d'),
            );

            $order_item_id = DB::table('ci_order_item')->insertGetId($data);


            if (!empty($request->package) && is_array($request->package)) {
                $service_name = DB::table('services')->where('id', $service_id)->value('servicename');
                $subservice_name = DB::table('subservices')->where('id', $request->subservice_id)->value('subservicename');

                foreach ($request->package as $packageId) {
                    $quantityKey = $packageId . '_quantity';
                    $priceKey = $packageId . '_price';

                    // Fetch package item details
                    $package_item = DB::table('packages')->where('id', $packageId)->first();

                    if ($package_item) {
                        // Fetch the category details for this specific package
                        $package_category_id = $package_item->packagecategory_id;
                        $package_category_name = DB::table('package_categories')->where('id', $package_category_id)->value('name');

                        // Check if quantity and price exist
                        if (isset($request->$quantityKey) && isset($request->$priceKey)) {
                            $data = [
                                'order_id'              => $arrOrderId,
                                'order_item_id'         => $order_item_id,
                                'user_info_id'          => $user_id,
                                'package_id'            => $packageId,
                                'package_item_name'     => $package_item->name,
                                'package_quantity'      => is_array($request->$quantityKey) ? implode(',', $request->$quantityKey) : $request->$quantityKey,
                                'package_item_price'    => is_array($request->$priceKey) ? implode(',', $request->$priceKey) : $request->$priceKey,
                                'service_id'            => $service_id,
                                'service_name'          => $service_name,
                                'subservice_id'         => $request->subservice_id,
                                'subservice_name'       => $subservice_name,
                                'packagecategory_id'    => $package_category_id,
                                'packagecategory_name'  => $package_category_name,
                                'page_url'              => $package_item->page_url,
                                'image'                 => $package_item->image,
                                'cdate'                 => date('Y-m-d'),
                            ];

                            // Insert data into the database
                            DB::table('ci_order_item_packages')->insertGetId($data);
                        }
                    }
                }
            }
            $shipping_data = array(
                'order_id'      => $arrOrderId,
                'user_id'       => $user_id,
                'first_name'    => "",
                'last_name'     => "",
                'country'       => "",
                'address1'      => "",
                'state'         => "",
                'city'          => "",
                'zipcode'       => "",
                'address2'      => "",
                'phone_number'  => "",
                'email_address' => "",
            );

            DB::table('ci_shipping_address')->insert($shipping_data);
        }

        if ($request->send_notification == 'yes') {
            $this->success_book_now_mail($user_id, $arrOrderId);
            $this->success_whatsapp_message($user_id, $arrOrderId);
        }



        return redirect()->route('automobile-order')->with('success', 'Order has been added successfully');
    }

    function painting_service_order_store(Request $request)
    {

        $order_status = 'BK';

        $list_order_status = '0';
        $payment_status = 'Success';
        $payment_mode = "COD";

        $intOrderNumber = DB::table('ci_orders')
            ->select(DB::raw('MAX(order_id) as lastOrderNumber'))
            ->first();

        $nextOrderNumber = 0;
        if ($intOrderNumber) {
            $intOrderNumber = $intOrderNumber->lastOrderNumber + 1;

            $intOrderNumber_new = $intOrderNumber;
            $nextOrderNumber;
        } else {
            $intOrderNumber_new = 1;
        }


        Session::put('order_number', $intOrderNumber_new);
        $order_number = Session::get('order_number');

        if ($request->subservice_id != '') {

            $userid = $request->customer_id;

            $vat_total = $request->vat_charge;
            $order_from = 2; // booking form data

            $timing_date_charge = $request->timing_charge + $request->date_charge;

            if ($request->payment_method == 'ONLINE') {
                $paymentmode = 2;
            } else {
                $paymentmode = 1;
            }

            $subservice_id = $request->subservice_id;
            $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($request->city) . '%'])->first();
            $subserviceData = DB::table('subservices')->where('id', $subservice_id)->first();

            if (isset($subserviceData)) {
                if (isset($subserviceData->subservice_code)) {
                    $subserviceCode = $subserviceData->subservice_code;
                } else {
                    $subserviceCode = 'OT';
                }
            } else {
                $subserviceCode = 'OT';
            }

            $cityCode = 'DU';
            if (isset($cityData)) {
                if (isset($cityData->city_code)) {
                    $cityCode = $cityData->city_code;
                } else {
                    $cityCode = 'OT';
                }
            }
            // echo $request->city."<br>";
            // echo $cityCode;
            // echo"<pre>";print_r($cityData);echo"</pre>";exit;
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


            $content = array(
                'user_id'               => $userid,
                'order_number'          => $order_number,
                'front_wallet_amount'   => '0',
                'order_total'           => $request->order_total,
                'vatcharge'             => $vat_total,
                'order_currency'        => 'AED',
                'order_status'          => $order_status,
                'paymentmode'           => $paymentmode,
                'payment_status'        => $payment_status,
                'created_at'            => date('Y-m-d H:i:s'),
                //'ip_address'            => $_SERVER['REMOTE_ADDR'],
                'list_order_status'     => $list_order_status,
                'service_charge'     => $request->size_of_home_price,
                'promo_discount'     => '0',
                'cleaning_discount_additional'     => '',
                'timing_charge'     => $timing_date_charge,
                'additional_charge'     => $request->additionalCharge,
                'sub_total'     => $request->sub_total,
                'cod_charge'     => $request->cod_charge ?: "",
                'service_fee'     => $request->service_fee ?: "",
                'send_notification'     => $request->send_notification ?: "",
                'order_from'     => $order_from,
                'subservice_code'       => $subserviceCode,
                'city_code'             => $cityCode,
                'order_year'            => $year,
                'sequence_no'           => $nextSequence,
                'format_order_id'           => $formatOrderId,
            );


            $arrOrderId = DB::table('ci_orders')->insertGetId($content);

            // $year = date('y');
            // $data_u['format_order_id'] = "VC-" . $year ."-UAE-". sprintf("%06d", $arrOrderId);
            // DB::table('ci_orders')->where('order_id', $arrOrderId)->update($data_u);
            Session::put('format_order_id', $formatOrderId);

            if ($arrOrderId) {
                $arrOrderId;
            }

            if ($request->selected_home_furnished_price != 0) {
                $isYourHomeFurnished = "Yes";
            } else {
                $isYourHomeFurnished = "No";
            }

            $day = date('j', strtotime($request->service_date));
            $bookingyear = date('Y', strtotime($request->service_date));
            $month = date('F', strtotime($request->service_date));

            $arrData = array(
                'order_id'                             => $arrOrderId,
                'user_info_id'                         => $userid,
                'service_id'                           => '34',
                'subservice_id'                        => $request->subservice_id,
                'address_type'                         => $request->address_type,
                'city'                                 => $request->city,
                'area'                                 => $request->area,
                'building_street_no'                   => $request->building_name,
                'apartment_villa_no'                   => $request->apartment_villa_num,
                'bookingdate'                          => $day,
                'bookingyear'                          => $bookingyear,
                'month'                                => $month,
                'time_slot'                            => $request->time_slot,
                'type_of_painting'                     => $request->type_of_painting,
                'selected_type_home'                   => $request->selected_type_home,
                'selected_size_home'                   => $request->selected_size_home,
                'service_charge_price'                 => $request->size_of_home_price,
                'color_you_want_painted_price'         => $request->color_you_want_painted_price,
                'walls_now_price'                      => $request->color_your_walls_now_price,
                'you_want_paint_color'                 => $request->selected_you_want_color_name,
                'your_walls_now_color'                 => $request->selected_your_walls_now_name,
                'is_home_furnished'                    => $isYourHomeFurnished,
                'no_of_ceilings'                       => $request->no_of_ceilings ?: "",
                'describe_painting_service'            => "",
                'cdate'                                => date('Y-m-d'),
            );

            $order_item_id = DB::table('ci_order_item')->insertGetId($arrData);

            $data['first_name'] = "";
            $data['last_name'] = "";
            $data['country'] = "";
            $data['address1'] = "";
            $data['state'] = "";
            $data['city'] = "";
            $data['zipcode'] = "";
            $data['address2'] = "";
            $data['phone_number'] = "";
            $data['email_address'] = "";
            $data['additional_message'] = "";
            $data['payment_method'] = "";
            $data['order_id'] = $arrOrderId;
            $data['user_id'] = $userid;

            DB::table('ci_shipping_address')->insert($data);

            if ($request->send_notification == 'yes') {
                $this->success_book_now_mail($userid, $arrOrderId);
                $this->success_whatsapp_message($userid, $arrOrderId);
            }


            return redirect()->route('painting-service-order')->with('success', 'Order has been added successfully');
        } else {
            return redirect()->route('painting-service-order')->with('error', 'Please select subservice');
        }

        //



    }

    public function success_moving_mail($user_id, $order_id)
    {

        $orderdata = DB::table('ci_orders')->where('order_number', $order_id)->first();

        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_id)->get();

        $user_data = DB::table('frontloginregisters')->where('id', $user_id)->first();

        if ($orderdata->paymentmode == 1) {
            $payment_mode = "COD";
        } else {
            $payment_mode = "Online";
        }


        $date = $order_item_data[0]->bookingdate ?? "";
        $month = $order_item_data[0]->month ?? "";
        $year = $order_item_data[0]->bookingyear ?? "";

        if ($date != '' && $month != '' && $year != '') {
            $booking_date = $month . ' ' . $date . ', ' . $year;
        } else {
            $booking_date = "-";
        }


        $phone = $user_data->country_code . '' . $user_data->mobile;
        $customer_name = $user_data->name;
        $service_name = Helper::servicename($order_item_data[0]->service_id);
        //$booking_date = '2023-10-10';
        $booking_time = Helper::timeslotname(strval($order_item_data[0]->time_slot));
        //    $url = $order_id;
        $url = "329";

        //    exit;



        //echo"<pre>";print_r($response);echo"</pre>";exit;


        $user_name = $user_data->name;
        $message_bodyy = '';

        $message_bodyy .= '<!doctype html>
 
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
                <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;"  >
                </div>

                    <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;" > 
                    <p> Dear ' . $user_name . ',</p>
                    <p>Thank you for booking a service with VendorsCity! We are excited to assist you.</p>

                    <p>Your booking details are as follows:</p>';

        foreach ($order_item_data as $arrRowDeailtss) {
            $message_bodyy .= '<strong>Service: </strong> ' . $arrRowDeailtss->service_name . '<br>';
        }

        $message_bodyy .= '
                     <strong>Date: </strong> ' . $orderdata->moving_date . '<br>
                     <strong>Order No: </strong> ' . $orderdata->format_order_id . '';

        if ($payment_mode == 'COD') {
            $message_bodyy .= '<p>Payment needs to be processed once our crew reaches the location. You will receive a detailed invoice from our crew. Accepted payment methods include cash, credit card, and debit card. In case an online transfer is required, please inform us and ensure it is completed a day prior to our arrival onsite.</p>';
        } else {
            $message_bodyy .= '<p>Your payment has been successfully processed. You will receive another email with a detailed receipt shortly.</p>';
        }


        $message_bodyy .= '<p>Your service provider will contact you soon to confirm the details and make any necessary arrangements. If you do not hear from them within 2 business days, please email us at <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a> or call us at 056 VENDORS (836 3677).</p>

                     <p>If you have any questions or need to make changes to your booking, please do not hesitate to   <a href="' . url("/contact") . '">Contact Us</a>.
                     </p>
                     <p>Thank you for choosing VendorsCity. We look forward to providing you with exceptional service.</p>
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
                                <div class="footer_right" style="margin-left:10px;
                                float: left;">
                                    <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                                    <p  style="margin:0;">VendorsCity Portal LLC</p>
                                    <div class="footer_links" style=" margin:10px 0;">
                                <a href="' . url("/terms-of-service") . '"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                <a href="' . url("/privacy-policy") . '"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                <a href="' . url("/contact") . '"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                                </div>
                                   
                                </div>
                            </div>
                      </div>
                </div>
            </body>
 </html>';


        $subject = "Service Booking Confirmation " . $orderdata->format_order_id . "";

        $to = $user_data->email;
        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];

        Mail::send([], [], function ($message) use ($message_bodyy, $to, $subject, $ccRecipients) {
            $message->to($to);
            $message->subject($subject);
            $message->from('devang.hnrtechnologies@gmail.com', 'Vendors City');
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($message_bodyy);
        });

        return true;
    }
    public function success_storage_mail($user_id, $order_id)
    {

        $orderdata = DB::table('ci_orders')->where('order_number', $order_id)->first();

        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_id)->get();

        $user_data = DB::table('frontloginregisters')->where('id', $user_id)->first();

        if ($orderdata->paymentmode == 1) {
            $payment_mode = "COD";
        } else {
            $payment_mode = "Online";
        }


        $date = $order_item_data[0]->bookingdate ?? "";
        $month = $order_item_data[0]->month ?? "";
        $year = $order_item_data[0]->bookingyear ?? "";

        if ($date != '' && $month != '' && $year != '') {
            $booking_date = $month . ' ' . $date . ', ' . $year;
        } else {
            $booking_date = "-";
        }


        $phone = $user_data->country_code . '' . $user_data->mobile;
        $customer_name = $user_data->name;
        $service_name = Helper::servicename($order_item_data[0]->service_id);
        //$booking_date = '2023-10-10';
        $booking_time = Helper::timeslotname(strval($order_item_data[0]->time_slot));
        //    $url = $order_id;
        $url = "329";

        //    exit;



        //echo"<pre>";print_r($response);echo"</pre>";exit;


        $user_name = $user_data->name;
        $message_bodyy = '';

        $message_bodyy .= '<!doctype html>
 
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
                <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;"  >
                </div>

                    <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;" > 
                    <p> Dear ' . $user_name . ',</p>
                    <p>Thank you for booking a service with VendorsCity! We are excited to assist you.</p>

                    <p>Your booking details are as follows:</p>';

        foreach ($order_item_data as $arrRowDeailtss) {
            $message_bodyy .= '<strong>Service: </strong> ' . $arrRowDeailtss->service_name . '<br>';
        }

        $message_bodyy .= '
                     <strong>Date: </strong> ' . $orderdata->moving_date . '<br>
                     <strong>Order No: </strong> ' . $orderdata->format_order_id . '';




        $message_bodyy .= '<p>Your service provider will contact you soon to confirm the details and make any necessary arrangements. If you do not hear from them within 2 business days, please email us at <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a> or call us at 056 VENDORS (836 3677).</p>

                     <p>If you have any questions or need to make changes to your booking, please do not hesitate to   <a href="' . url("/contact") . '">Contact Us</a>.
                     </p>
                     <p>Thank you for choosing VendorsCity. We look forward to providing you with exceptional service.</p>
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
                                <div class="footer_right" style="margin-left:10px;
                                float: left;">
                                    <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                                    <p  style="margin:0;">VendorsCity Portal LLC</p>
                                    <div class="footer_links" style=" margin:10px 0;">
                                <a href="' . url("/terms-of-service") . '"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                <a href="' . url("/privacy-policy") . '"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                <a href="' . url("/contact") . '"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                                </div>
                                   
                                </div>
                            </div>
                      </div>
                </div>
            </body>
 </html>';


        $subject = "Service Booking Confirmation " . $orderdata->format_order_id . "";

        $to = $user_data->email;
        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        // $ccRecipients = [];

        Mail::send([], [], function ($message) use ($message_bodyy, $to, $subject, $ccRecipients) {
            $message->to($to);
            $message->subject($subject);
            $message->from('devang.hnrtechnologies@gmail.com', 'Vendors City');
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($message_bodyy);
        });

        return true;
    }

    public function success_storage_renew_mail($user_id, $order_id)
    {

        $orderdata = DB::table('ci_orders')->where('order_number', $order_id)->first();

        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_id)->get();

        $user_data = DB::table('frontloginregisters')->where('id', $user_id)->first();

        if ($orderdata->paymentmode == 1) {
            $payment_mode = "COD";
        } else {
            $payment_mode = "Online";
        }


        $date = $order_item_data[0]->bookingdate ?? "";
        $month = $order_item_data[0]->month ?? "";
        $year = $order_item_data[0]->bookingyear ?? "";

        if ($date != '' && $month != '' && $year != '') {
            $booking_date = $month . ' ' . $date . ', ' . $year;
        } else {
            $booking_date = "-";
        }


        $phone = $user_data->country_code . '' . $user_data->mobile;
        $customer_name = $user_data->name;
        $service_name = Helper::servicename($order_item_data[0]->service_id);
        //$booking_date = '2023-10-10';
        $booking_time = Helper::timeslotname(strval($order_item_data[0]->time_slot));
        //    $url = $order_id;
        $url = "329";

        //    exit;



        //echo"<pre>";print_r($response);echo"</pre>";exit;


        $user_name = $user_data->name;
        $message_bodyy = '';

        $message_bodyy .= '<!doctype html>
 
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
                <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;"  >
                </div>

                    <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;" > 
                    <p> Dear ' . $user_name . ',</p>
                    <p>Thank you for renewing your service with VendorsCity! We are glad to continue assisting you.</p>

<p>Your renewal details are as follows:</p>';

        foreach ($order_item_data as $arrRowDeailtss) {
            $message_bodyy .= '<strong>Renewed Service: </strong> ' . $arrRowDeailtss->service_name . '<br>';
        }

        $message_bodyy .= '
                     <strong>Renewal Date: </strong> ' . $orderdata->moving_date . '<br>
                     <strong>Order No: </strong> ' . $orderdata->format_order_id . '';




        $message_bodyy .= '<p>Your service has been successfully renewed. If any further coordination is required, our team or service provider will get in touch with you.</p>

                     <p>If you have any questions or need to make changes to your booking, please do not hesitate to   <a href="' . url("/contact") . '">Contact Us</a>.
                     </p>
                     <p>Thank you for continuing with VendorsCity. We appreciate your trust and look forward to serving you again.</p>
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
                                <div class="footer_right" style="margin-left:10px;
                                float: left;">
                                    <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                                    <p  style="margin:0;">VendorsCity Portal LLC</p>
                                    <div class="footer_links" style=" margin:10px 0;">
                                <a href="' . url("/terms-of-service") . '"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                <a href="' . url("/privacy-policy") . '"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                <a href="' . url("/contact") . '"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                                </div>
                                   
                                </div>
                            </div>
                      </div>
                </div>
            </body>
 </html>';


        $subject = "VendorsCity Service Renewal Confirmation - " . $orderdata->format_order_id;

        $to = $user_data->email;
        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        // $ccRecipients = [];

        Mail::send([], [], function ($message) use ($message_bodyy, $to, $subject, $ccRecipients) {
            $message->to($to);
            $message->subject($subject);
            $message->from('devang.hnrtechnologies@gmail.com', 'Vendors City');
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($message_bodyy);
        });

        return true;
    }

    function success_book_now_mail($user_id, $order_id)
    {


        $user_data = DB::table('frontloginregisters')->where('id', $user_id)->first();

        $orderdata = DB::table('ci_orders')->where('order_id', $order_id)->first();

        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_id)->first();

        $service_name = Helper::subservicename(strval($order_item_data->subservice_id));

        $when = $order_item_data->bookingdate . " " . $order_item_data->month . ", " . $order_item_data->bookingyear;

        $Where = $order_item_data->city . ", " . $order_item_data->area . ", " . $order_item_data->building_street_no . ", " . $order_item_data->apartment_villa_no;

        $message_bodyy = '';
        if ($orderdata->order_from == 1) {
            $message_bodyy .= '<!doctype html>
    
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

            .custom_col_2{
                width: 18%;
            display: inline-block;
            }

            .custom_col_8{
                width: 75%;
            display: inline-block;
            }

            .custom_col_2_payment{
                width: 29%;
            display: inline-block;
            }

            .custom_col_8_payment{
                width: 70%;
                text-align: right;
            display: inline-block;
            }
                .main_row{margin:10px 0;}
            .custom_col_2 h5{font-size: 17px;margin: 0;}
            .custom_col_8 p{margin: 0;}

            .custom_col_2_payment h5{font-size: 17px;margin: 0;}
            .custom_col_8_payment p{margin: 0;}
        </style>
        </head>
        <body>
        <div class="wrapper" style="width: 100%;max-width:500px;margin:auto;
                                    font-size:14px;line-height:24px;
                                    font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
            <div class="logo" style="float: inherit;border-bottom: 4px solid #FFD413;">
            <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;" >
            </div>

            <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;" >
                                <p><strong>Dear ' . $user_data->name . '</strong>,</p>
                                <p>Thank you for choosing VendorsCity! We\'re pleased to confirm your ' . $service_name . '     service booking</p>
                            <div class="heading" style="font-weight: bold;font-size: 20px;margin-top: 7%;">
                                Here are the details of your service:
                                </div>
                            <hr>
                            <div class="main">
                                    <div class="row main_row" style="margin:10px 0;">

                                        <div class="col-lg-2 custom_col_2" style="width: 100%;
                                        display: inline-block;">
                                        <ul style="margin: 0;padding: 0"><li>
                                            <h5 style="font-size: 14px;margin: 0;">Service Type: ';

            $message_bodyy .= '<span style="margin: 0;font-weight:100;color: #000;">' . $service_name . '</span></h5></li></ul>';

            $message_bodyy .= '</div>
                                    </div>

                                    <div class="row main_row" style="margin:10px 0;">
                                        <div class="col-lg-2 custom_col_2" style="width: 100%;
                                        display: inline-block;">
                                        <ul style="margin: 0;padding: 0"><li>
                                            <h5 style="font-size: 14px;margin: 0;">Date: <span style="margin: 0;font-weight:100;"> ' . $when . ' </span></h5>
                                            </li></ul>
                                        </div>
                                    </div>
                                    
                                    <div class="row main_row" style="margin:10px 0;">
                                        <div class="col-lg-2 custom_col_2" style="width: 100%;
                                        display: inline-block;">
                                        <ul style="margin: 0;padding: 0"><li>
                                            <h5 style="font-size: 14px;margin: 0;">Time: 
                                            <span style="margin: 0;font-weight:100;"> ' . Helper::timeslotname($order_item_data->time_slot) . '</span></h5> </li></ul>
                                        </div>
                                    </div>';


            if ($order_item_data->subservice_id == 28) {
                $message_bodyy .= '<div class="row main_row" style="margin:10px 0;">
                                        <div class="col-lg-2 custom_col_2" style="width: 100%;
                                        display: inline-block;">
                                        <ul style="margin: 0;padding: 0"><li>
                                            <h5 style="font-size: 14px;margin: 0;">No. of Cleaners: 
                                            <span style="margin: 0;font-weight:100;"> ' . $order_item_data->how_many_cleaners_do_you_need . ' Cleaner(s)</span></h5> </li></ul>
                                        </div>
                                    </div>

                                    <div class="row main_row" style="margin:10px 0;">
                                        <div class="col-lg-2 custom_col_2" style="width: 100%;
                                        display: inline-block;">
                                        <ul style="margin: 0;padding: 0"><li>
                                            <h5 style="font-size: 14px;margin: 0;">No. of Hours: 
                                            <span style="margin: 0;font-weight:100;"> ' . $order_item_data->how_many_hours_should_they_stay . ' Hours</span></h5> </li></ul>
                                        </div>
                                    </div>

                                    <div class="row main_row" style="margin:10px 0;">
                                        <div class="col-lg-2 custom_col_2" style="width: 100%;
                                        display: inline-block;">
                                        <ul style="margin: 0;padding: 0"><li>
                                            <h5 style="font-size: 14px;margin: 0;">Frequency:
                                            <span style="margin: 0;font-weight:100;"> ' . $order_item_data->how_often_do_you_need_cleaning . '</span></h5> </li></ul>
                                        </div>
                                    </div>

                                    <div class="row main_row" style="margin:10px 0;">
                                        <div class="col-lg-2 custom_col_2" style="width: 100%;
                                        display: inline-block;">
                                        <ul style="margin: 0;padding: 0"><li>
                                            <h5 style="font-size: 14px;margin: 0;">Material:
                                            <span style="margin: 0;font-weight:100;"> ' . $order_item_data->do_you_need_cleaning_material . '</span></h5> </li></ul>
                                        </div>
                                    </div>';
            }

            $message_bodyy .= '<div class="row main_row" style="margin:10px 0;">
                                        <div class="col-lg-2 custom_col_2" style="width: 100%;
                                        display: inline-block;">
                                        <ul style="margin: 0;padding: 0"><li>
                                            <h5 style="font-size: 14px;margin: 0;">Address:
                                            <span style="margin: 0;font-weight:100;"> ' . $Where . '</span></h5> </li></ul>
                                        </div>
                                    </div>
                            </div>';

            if ($order_item_data->subservice_id == 47) {
                $message_bodyy .= '<p>Our professional pest control team will arrive promptly at the scheduled time, fully equipped to ensure your space is treated thoroughly and effectively.</p>.';
            } else {
                $message_bodyy .= '<p>Our professional cleaning team will arrive promptly at the scheduled time, equipped with everything needed to leave your 
                                ' . $service_name . ' spotless.</p>';
            }

            if ($orderdata->paymentmode == '1' && $order_item_data->how_often_do_you_need_cleaning == "Weekly") {
                $message_bodyy .= '<h5 style="font-size: 14px;margin: 0;">Weekly Payment:</h5>
                            <p>Since this is a <strong style="font-weight:700;">cash on delivery service </strong>, payment of amount <img src="' . asset("public/site/images/automobile/DirhamBlack.png") . '"" style="width: 15px;" > <strong style="font-weight:1000;"> ' . $orderdata->order_total . '</strong>is due weekly in full upon completion of the service. Please have the payment ready for our team.</p>';
            }

            if ($orderdata->paymentmode == '1' && $order_item_data->how_often_do_you_need_cleaning == "Once") {
                $message_bodyy .= '<p>Since this is a <strong style="font-weight:700;">cash on delivery service </strong>, payment of amount <img src="' . asset("public/site/images/automobile/DirhamBlack.png") . '"" style="width: 15px;" > <strong style="font-weight:1000;">' . $orderdata->order_total . '</strong> is due in full upon completion of the service. Please have the payment ready for our team.</p>';
            }

            $message_bodyy .= '<h5 style="font-size: 14px;margin: 0;">Important Notes:</h5> 
                            <ul><li>
                            Please ensure someone is available at home to grant access to our team.</li>
                            <li>If you need to reschedule or have any special instructions, don\'t hesitate to reach out to us at 056 836 3677 or <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a>.</li>
                            <li>Charges may apply for last minute cancellations or rescheduling of service.</li>
                            </ul>
                            <p>We are excited to deliver an exceptional service experience for you.
                            </p>

                            <div class="heading" style="font-weight: bold;font-size: 20px;
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
                                    <div class="footer_right" style="margin-left:10px;
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

            $subject = " Confirmation of Your $service_name Service Booking ";
            $to = $user_data->email;
            $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
            Mail::send([], [], function ($message) use ($message_bodyy, $to, $subject, $ccRecipients) {
                $message->to($to);
                $message->subject($subject);
                foreach ($ccRecipients as $ccRecipient) {
                    $message->bcc($ccRecipient);
                }
                $message->html($message_bodyy);
            });

            return true;
        } elseif ($orderdata->order_from == 2) {


            //painting mail 

            $date = $order_item_data->bookingdate ?? "";
            $month = $order_item_data->month ?? "";
            $year = $order_item_data->bookingyear ?? "";

            $timeSlot = Helper::timeslotname(strval($order_item_data->time_slot));

            if ($date != '' && $month != '' && $year != '') {

                $date_and_time = $month . ' ' . $date . ', ' . $year;
            } else {
                $date_and_time = "-";
            }

            $address_painting = $order_item_data->area . ', ' . $order_item_data->building_street_no . ', ' . $order_item_data->apartment_villa_no;

            $message_bodyy .= '<!doctype html>
 
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

     .custom_col_2{
        width: 18%;
    display: inline-block;
    }

    .custom_col_8{
        width: 75%;
    display: inline-block;
    }

    .custom_col_2_payment{
        width: 29%;
    display: inline-block;
    }

    .custom_col_8_payment{
        width: 70%;
        text-align: right;
    display: inline-block;
    }
        .main_row{margin:10px 0;}
    .custom_col_2 h5{font-size: 17px;margin: 0;}
    .custom_col_8 p{margin: 0;}

    .custom_col_2_payment h5{font-size: 17px;margin: 0;}
    .custom_col_8_payment p{margin: 0;}
 </style>
</head>
<body>
<div class="wrapper" style="width: 100%;max-width:500px;margin:auto;
                            font-size:14px;line-height:24px;
                            font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
    <div class="logo" style="float: inherit;border-bottom: 4px solid #FFD413;">
    <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;" >
    </div>

     <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;" >
                        <p>  Dear ' . $user_data->name . ',</p>';
            if ($orderdata->paymentmode == 1) {
                $message_bodyy .= '<p>Thank you for choosing VendorsCity! We\'re pleased to confirm your painting service booking.</p>';
            } else {
                $message_bodyy .= '<p>Thank you for choosing VendorsCity! We\'re pleased to confirm your painting service booking.</p>';
            }

            $message_bodyy .= '<!--<p>A Super Cleaner is:</p>
                       <ul>
                        <li>One of our highest rated cleaners</li>
                        <li>Rated 4.75 out of 5 by over 1000 customers</li>
                        <li>Highly trained, experienced, and ready to make your home shine</li>
                       </ul> -->

                       <div class="heading" style="font-weight: bold;font-size: 20px;margin-top: 7%;">
                        Here are the details of your service:
                        </div>
                       <hr>
                       <div class="main">
                            <div class="row main_row" style="margin:10px 0;">

                                <div class="col-lg-2 custom_col_2" style="width: 100%;
                                display: inline-block;">
                                <ul style="margin: 0;padding: 0"><li>
                                    <h5 style="font-size: 14px;margin: 0;">Service Type: ';
            if (!empty($order_item_package_data)) {
                foreach ($order_item_package_data as $package_data) {
                    $message_bodyy .= '<p style="margin: 0;">' . $package_data->package_item_name . ' * ' . $package_data->package_quantity . '</p>';
                }
            } else {
                $message_bodyy .= '<span style="margin: 0;font-weight:100;color: #000;">' . $service_name . '</span></h5></li></ul>';
            }
            $message_bodyy .= '</div>
                             </div>

                             <div class="row main_row" style="margin:10px 0;">
                                <div class="col-lg-2 custom_col_2" style="width: 100%;
                                display: inline-block;">
                                <ul style="margin: 0;padding: 0"><li>
                                    <h5 style="font-size: 14px;margin: 0;">Date: <span style="margin: 0;font-weight:100;color: #000;"> ' . $date_and_time . ' </span></h5>
                                    </li></ul>
                                </div>
                             </div>

                             <div class="row main_row" style="margin:10px 0;">
                                <div class="col-lg-2 custom_col_2" style="width: 100%;
                                display: inline-block;">
                                <ul style="margin: 0;padding: 0"><li>
                                    <h5 style="font-size: 14px;margin: 0;">Time: 
                                     <span style="margin: 0;font-weight:100;color: #000;"> ' . $timeSlot . '</span></h5> </li></ul>
                                </div>
                             </div>

                             <div class="row main_row" style="margin:10px 0;">
                                <div class="col-lg-2 custom_col_2" style="width: 100%; display: inline-block;">
                                <ul style="margin: 0;padding: 0"><li>
                                    <h5 style="font-size: 14px;margin: 0;">Service: 
                                     <span style="margin: 0;font-weight:100;color: #000;"> ' . $order_item_data->type_of_painting . '</span></h5> </li></ul>
                                </div>
                             </div>

                             <div class="row main_row" style="margin:10px 0;">
                                <div class="col-lg-2 custom_col_2" style="width: 100%;
                                display: inline-block;">
                                <ul style="margin: 0;padding: 0"><li>
                                    <h5 style="font-size: 14px;margin: 0;">Size of Home: 
                                     <span style="margin: 0;font-weight:100;color: #000;"> ' . $order_item_data->selected_type_home . ' - ' . $order_item_data->selected_size_home . '</span></h5> </li></ul>
                                </div>
                             </div>

                             <div class="row main_row" style="margin:10px 0;">
                                <div class="col-lg-2 custom_col_2" style="width: 100%;
                                display: inline-block;">
                                <ul style="margin: 0;padding: 0"><li>
                                    <h5 style="font-size: 14px;margin: 0;">Furnished:
                                     <span style="margin: 0;font-weight:100;color: #000;"> ' . $order_item_data->is_home_furnished . '</span></h5> </li></ul>
                                </div>
                             </div>

                             <div class="row main_row" style="margin:10px 0;">
                                <div class="col-lg-2 custom_col_2" style="width: 100%;
                                display: inline-block;">
                                <ul style="margin: 0;padding: 0"><li>
                                    <h5 style="font-size: 14px;margin: 0;">Color:
                                     <span style="margin: 0;font-weight:100;color: #000;"> ' . $order_item_data->your_walls_now_color . ' to ' . $order_item_data->you_want_paint_color . '</span></h5> </li></ul>
                                </div>
                             </div>';

            if ($order_item_data->no_of_ceilings != "") {

                $message_bodyy .= '<div class="row main_row" style="margin:10px 0;">
                                    <div class="col-lg-2 custom_col_2" style="width: 100%;
                                    display: inline-block;">
                                    <ul style="margin: 0;padding: 0"><li>
                                        <h5 style="font-size: 14px;margin: 0;">Ceilings:
                                        <span style="margin: 0;font-weight:100;color: #000;"> ' . $order_item_data->no_of_ceilings . '</span></h5> </li></ul>
                                    </div>
                                </div>';
            }

            $message_bodyy .= '<div class="row main_row" style="margin:10px 0;">
                                    <div class="col-lg-2 custom_col_2" style="width: 100%;
                                    display: inline-block;">
                                    <ul style="margin: 0;padding: 0"><li>
                                        <h5 style="font-size: 14px;margin: 0;">Address:
                                        <span style="margin: 0;font-weight:100;color: #000;"> ' . $address_painting . '</span></h5> </li></ul>
                                    </div>
                                </div>';

            $message_bodyy .= '</div>';
            if ($orderdata->paymentmode == 1) {
                $message_bodyy .= '<p>Our professional painting team will arrive promptly at the scheduled time, prepared with everything necessary to give your home a fresh, vibrant look.</p>';

                $message_bodyy .= '<p>Since this is a <strong style="font-weight:700;">cash on delivery</strong> service, payment of amount <img src="' . asset("public/site/images/automobile/DirhamBlack.png") . '"" style="width: 15px;" > <strong style="font-weight:700;">' . $orderdata->order_total . '</strong> is due in full upon completion of the service. Please have the payment ready for our team.</p>';
            } else {
                $message_bodyy .= '<p>Our professional painting team will arrive promptly at the scheduled time, prepared with everything necessary to give your home a fresh, vibrant look.</p>';
            }

            $message_bodyy .= '<h5 style="font-size: 14px;margin: 0;">Important Notes:</h5> 
                    <ul><li>
                    Please ensure someone is available at home to grant access to our team.</li>
                    <li>If you need to reschedule or have any specific color preferences or instructions, don’t hesitate to reach out to us at 056 836 3677 or <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a>.</li>
                    <li>Charges may apply for last-minute cancellations or rescheduling of service.</li>
                    </ul>
                    <p>We’re excited to provide you with an exceptional painting experience.<br/>
                    </p>

                    <div class="heading" style="font-weight: bold;font-size: 20px;
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
                            <div class="footer_right" style="margin-left:10px;
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

            $subject = " Confirmation of Your $service_name Booking .'$orderdata->format_order_id'. ";

            //$to = $user_data->email;
            $to = 'devang.hnrtechnologies@gmail.com';
            $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
            // $ccRecipients = array();
            Mail::send([], [], function ($message) use ($message_bodyy, $to, $subject, $ccRecipients) {
                $message->to($to);
                $message->subject($subject);
                foreach ($ccRecipients as $ccRecipient) {
                    $message->bcc($ccRecipient);
                }
                $message->html($message_bodyy);
            });

            return true;
        }
    }


    function car_inspection_order_update(Request $request, $order_id)
    {

        $id = $request->payment_hidden;

        if ($id == '1') {
            $order_status = 'P';
            $paymentmode = $id;
            $list_order_status = '0';
            $payment_status = 'Success';
            $payment_mode = "COD";
        } else {
            $order_status = 'P';
            $paymentmode = $id;
            $list_order_status = '0';
            $payment_status = 'FAILED';
            $payment_mode = "ONLINE PAYMENT";
        }

        $mode = ($request->payment_method == 'ONLINE') ? 2 : 1;

        $userid = $request->customer_id;
        $order_total_new = $request->total_amount;
        $front_wallet_amount_new = 0;
        $order_from = 3;

        $order_update = [
            'user_id'               => $userid,
            'order_total'           => $order_total_new,
            'front_wallet_amount'   => $front_wallet_amount_new,
            'shippingcost'          => '',
            'vatcharge'             => '',
            'order_currency'        => 'AED',
            'order_status'          => $order_status,
            'paymentmode'           => $mode,
            'payment_status'        => $payment_status,
            'moving_date'           => $request->inspection_date,
            'list_order_status'     => $list_order_status,
            'order_from'            => $order_from,
            'created_at'            => date('Y-m-d H:i:s')
        ];

        DB::table('ci_orders')->where('order_id', $order_id)->update($order_update);

        $year = date('y');
        $format_order_id = "VC-" . $year . "-UAE-" . sprintf("%06d", $order_id);
        DB::table('ci_orders')->where('order_id', $order_id)->update(['format_order_id' => $format_order_id]);
        Session::put('format_order_id', $format_order_id);


        $date = \Carbon\Carbon::parse($request->inspection_date);
        $booking_date = $date->day;
        $monthName = $date->format('F');
        $yearFull = $date->year;

        if ($request->vehicle_make == '0') {
            $vehicle_make = $request->other_vehicle_make;
            $others = 1;
        } else {
            $vehicle_make = $request->vehicle_make;
            $others = 0;
        }

        $arrData = [
            'bookingdate'                      => $booking_date,
            'bookingyear'                      => $yearFull,
            'month'                            => $monthName,
            'time_slot'                        => $request->inspection_time,
            'end_date'                         => $request->inspection_date,
            'verifybuy_package_id'             => $request->package_id,
            'verifybuy_mobile'                 => $request->mobile,
            'verifybuy_location'               => $request->location,
            'verifybuy_address'                => $request->address,
            'verifybuy_additional_details'     => $request->additional_details,
            'verifybuy_where_is_car_parked'    => $request->where_is_car_parked,
            'verifybuy_vehicle'                => $vehicle_make,
            'verifybuy_model'                  => $request->other_vehicle_model,
            'verifybuy_category'               => $request->category,
            'verifybuy_others'                 => $others,
            'cdate'                            => date('Y-m-d'),
        ];

        DB::table('ci_order_item')
            ->where('order_id', $order_id)
            ->where('service_id', 50)
            ->update($arrData);


        $shippingData = [
            'address1'            => $request->address,
            'phone_number'        => $request->mobile,
            'additional_message'  => $request->additional_details,
        ];

        DB::table('ci_shipping_address')
            ->where('order_id', $order_id)
            ->update($shippingData);


        return redirect()->route('car-inspection-order')
            ->with('success', 'Your booking has been successfully updated.');
    }

    public function automobile_order($order_id = '', $status = '')
    {
        $data['error'] = '';
        // First, fetch distinct orders
        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )->whereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('ci_order_item')
                    ->whereColumn('ci_order_item.order_id', 'ci_orders.order_id')
                    ->where('ci_order_item.service_id', 50)
                    ->where('ci_order_item.subservice_id', '!=', 92);
            });
        $query = $query->where('order_from', '!=', 2);
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
        // Get distinct orders where service_id is 45
        $orderList = $query->get();
        // Now, for each order, fetch its items
        foreach ($orderList as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->where('service_id', 50)
                ->get();
            $total = 0;
            // echo"<pre>";print_r($itemList);echo"</pre>";
            foreach ($itemList as $item) {
                $product = DB::table('packages')
                    ->where('id', $item->package_id)
                    ->first();
                // echo"<pre>";print_r($product);echo"</pre>";exit;

                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }
                $total += $product_item_price * $item->package_quantity;
            }
            // Attach the items and subtotal to the order object
            $order->items = $itemList;
            // $order->sub_total = $total;
        }
        $data['orders_list'] = $orderList;
        //echo"<pre>";print_r($data);echo"</pre>";exit;
        return view('admin.list_order', $data);
    }

    function success_whatsapp_message($user_id, $order_id)
    {

        $orderdata = DB::table('ci_orders')->where('order_number', $order_id)->first();

        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_id)->get();

        $user_data = DB::table('frontloginregisters')->where('id', $user_id)->first();

        $date = $order_item_data[0]->bookingdate ?? "";
        $month = $order_item_data[0]->month ?? "";
        $year = $order_item_data[0]->bookingyear ?? "";

        if ($date != '' && $month != '' && $year != '') {
            $booking_date = $month . ' ' . $date . ', ' . $year;
        } else {
            $booking_date = "-";
        }


        $phone = $user_data->country_code . '' . $user_data->mobile;
        $customer_name = $user_data->name;
        $service_name = Helper::servicename($order_item_data[0]->service_id);
        $subservice_name = Helper::subservicename($order_item_data[0]->subservice_id);
        //$booking_date = '2023-10-10';
        $booking_time = Helper::timeslotname(strval($order_item_data[0]->time_slot));
        $url = $order_id;

        /*  $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"messages":[{"to":"' . $phone . '","content":{"templateName":"service_confirmation_vc","language":"en","templateData":{"body":{"placeholders":["' . $customer_name . '","' . $subservice_name . '","' . $booking_date . '","' . $booking_time . '"]},"buttons":[{"type":"URL","parameter":"' . $url . '"}]}}}]}',
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

        curl_close($curl);

        $response = json_decode($response, true);

        //echo"<pre>";print_r($response);echo"</pre>";exit;

    }

    function success_whatsapp_message_vendorassign($vendor_id, $order_id)
    {

        $orderdata = DB::table('ci_orders')->where('order_number', $order_id)->first();

        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_id)->get();

        $vendorData = DB::table('users')->where('id', $vendor_id)->first();
        $UserData = DB::table('frontloginregisters')->where('id', $orderdata->user_id)->first();

        $userName = $UserData->name;

        $subservice_name = Helper::subservicename($order_item_data[0]->subservice_id);

        $date = $order_item_data[0]->bookingdate ?? "";
        $month = $order_item_data[0]->month ?? "";
        $year = $order_item_data[0]->bookingyear ?? "";

        if ($date != '' && $month != '' && $year != '') {
            $booking_date = $month . ' ' . $date . ', ' . $year;
        } else {
            $booking_date = "-";
        }


        $phone = $vendorData->country_code . '' . $vendorData->mobile;
        $service_name = Helper::servicename($order_item_data[0]->service_id);
        //$booking_date = '2023-10-10';
        $booking_time = Helper::timeslotname(strval($order_item_data[0]->time_slot));


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
        CURLOPT_POSTFIELDS =>'{"messages":[{"to":"'.$phone.'","content":{"templateName":"vendor_booking_assigned","language":"en","templateData":{"body":{"placeholders":["'.$userName.'","'.$subservice_name.'","'.$booking_date.'","'.$booking_time.'"]},"buttons":[{"type":"URL"}]}}}]}',
        CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'content-type: application/json',
            'Authorization: key_uTZeOXQPMd'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);      
        
        $response = json_decode($response, true); */

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

                    /*  $curl = curl_init();

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
                        "' . $vendorData->name . '"
                        ]
                    },
                    "buttons": [
                        {
                        "type": "URL",
                        "parameter": "' . $url . '"
                        }
                    ]
                    },
                    "templateName": "vendor_assigned"
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

            $response = json_decode($response, true);
        }
    }


    function moving_order_store(Request $request)
    {
        // 
        // echo "<pre>";
        // print_r($request->all());
        // exit;
        DB::beginTransaction();

        try {

            $intOrderNumber = DB::table('ci_orders')
                ->select(DB::raw('MAX(order_id) as lastOrderNumber'))
                ->first();

            $nextOrderNumber = 0;
            if ($intOrderNumber) {
                $intOrderNumber = $intOrderNumber->lastOrderNumber + 1;

                $intOrderNumber_new = $intOrderNumber;
                $nextOrderNumber;
            } else {
                $intOrderNumber_new = 1;
            }

            if ($request->payment_method == 'ONLINE') {
                $mode = 2;
            } else {
                $mode = 1;
            }



            $subservice_id = $request->subservice_id;
            $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($request->emirates) . '%'])->first();
            $subserviceData = DB::table('subservices')->where('id', $subservice_id)->first();

            if (isset($subserviceData)) {
                if (isset($subserviceData->subservice_code)) {
                    $subserviceCode = $subserviceData->subservice_code;
                } else {
                    $subserviceCode = 'OT';
                }
            } else {
                $subserviceCode = 'OT';
            }

            $cityCode = 'DU';
            if (isset($cityData)) {
                if (isset($cityData->city_code)) {
                    $cityCode = $cityData->city_code;
                } else {
                    $cityCode = 'OT';
                }
            }

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


            $content = array(
                'user_id'               => $request->customer_id,
                'order_number'          => $intOrderNumber_new,
                'order_total'           => $request->order_total,
                'front_wallet_amount'   => "0",
                'shippingcost'          => "0",
                'vatcharge'             => $request->vat_charge,
                'cod_charge'             => $request->cod_charge,
                'order_currency'        => 'AED',
                'order_status'          => 'BK',
                'paymentmode'           => $mode,
                'payment_status'        => 'Success',
                'created_at'            => date('Y-m-d H:i:s'),
                'coupan_to_wallet'      => "0",
                'coupondiscount'        => "0",
                'moving_date'           => $request->moving_date,
                'send_notification'     => $request->send_notification,
                'order_from'            => '0',
                'subservice_code'       => $subserviceCode,
                'city_code'             => $cityCode,
                'order_year'            => $year,
                'sequence_no'           => $nextSequence,
                'format_order_id'       => $formatOrderId,
                'sub_total'             => $request->sub_total,
            );

            $arrOrderId = DB::table('ci_orders')->insertGetId($content);

            //  echo"<pre>";print_r($request->all());exit;
            // $year =date('y');
            // $data_u['format_order_id'] = "VC-" . $year ."-UAE-". sprintf("%06d", $arrOrderId);
            // DB::table('ci_orders')->where('order_id', $arrOrderId)->update($data_u);

            $service_id = DB::table('subservices')->where('id', $request->subservice_id)->pluck('serviceid')->first();

            $date = Carbon::parse($request->moving_date);
            $booking_date = $date->day;
            $monthName = $date->format('F');
            $year = $date->year;

            if (!empty($request->package) && is_array($request->package)) {
                $service_name = DB::table('services')->where('id', $service_id)->value('servicename');
                $subservice_name = DB::table('subservices')->where('id', $request->subservice_id)->value('subservicename');

                foreach ($request->package as $packageId) {
                    $quantityKey = $packageId . '_quantity';
                    $priceKey = $packageId . '_price';

                    // Fetch package item details
                    $package_item = DB::table('packages')->where('id', $packageId)->first();

                    if ($package_item) {
                        // Fetch the category details for this specific package
                        $package_category_id = $package_item->packagecategory_id;
                        $package_category_name = DB::table('package_categories')->where('id', $package_category_id)->value('name');

                        // Check if quantity and price exist
                        if (isset($request->$quantityKey) && isset($request->$priceKey)) {
                            $data = [
                                'order_id'                        => $arrOrderId,
                                'user_info_id'                    => $request->customer_id,
                                'package_id'                      => $package_item->id,
                                'package_item_name'               => $package_item->name,
                                'package_quantity'                => is_array($request->$quantityKey) ? implode(',',                    $request->$quantityKey) : $request->$quantityKey,
                                'package_item_price'            => is_array($request->$priceKey) ? implode(',', $request->$priceKey) : $request->$priceKey,
                                'service_id'                      => $service_id,
                                'service_name'                    => $service_name,
                                'subservice_id'                   => $request->subservice_id,
                                'subservice_name'                 => $subservice_name,
                                'packagecategory_id'              => $package_category_id,
                                'packagecategory_name'            => $package_category_name,
                                'page_url'                        => "",
                                'cdate'                           => date('Y-m-d'),
                                'bookingdate'   => $booking_date,
                                'month'   => $monthName,
                                'bookingyear'   => $year,
                                'time_slot'   => $request->time_slot,
                                'origin_add'   => $request->origin_add,
                                'origin_country'   => $request->origin_country,
                                'origin_state'   => $request->origin_state,
                                'origin_city'   => $request->origin_city,
                                'origin_location'   => $request->origin_location,
                                'origin_zip_post'   => $request->origin_zip_post,
                                'desti_add'   => $request->desti_add,
                                'desti_country'   => $request->desti_country,
                                'desti_state'   => $request->desti_state,
                                'desti_city'   => $request->desti_city,
                                'desti_location'   => $request->desti_location,
                                'desti_zip_post'   => $request->desti_zip_post,
                                'any_special_instruction'   => $request->additional_message,
                            ];

                            DB::table('ci_order_item')->insertGetId($data);
                        }
                    }
                }
            }

            if ($request->first_name != '') {
                $data_new['first_name'] = $request->first_name;
                $data_new['last_name'] = $request->last_name;
                $data_new['country'] = $request->country;
                $data_new['emirate'] = $request->emirates;
                $data_new['area'] = $request->area;
                $data_new['address1'] = $request->street;
                $data_new['state'] = $request->state_name;
                $data_new['city'] = $request->city;
                $data_new['zipcode'] = $request->zipcode;
                $data_new['address2'] = $request->apartment_villa;
                $data_new['phone_number'] = $request->phone;
                $data_new['email_address'] = $request->email;
                $data_new['additional_message'] = $request->additional_message;
                $data_new['payment_method'] = "1";
                $data_new['order_id'] = $arrOrderId;
                $data_new['user_id'] = $request->customer_id;


                DB::table('ci_shipping_address')->insert($data_new);
            }

            if ($request->send_notification == 'yes') {
                $this->success_moving_mail($request->customer_id, $arrOrderId);
                $this->success_whatsapp_message($request->customer_id, $arrOrderId);
            }
            DB::commit();
            return redirect()->route('order.index')->with('success', 'Order has been added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Moving Order store failed : " . $e);
            return redirect()->back()->with('error', 'Moving Order Store failed')->withInput();
        }
    }

    public function moving_package_order_edit($order_id)
    {

        $data['error'] = '';
        // Fetch the single order
        $order = DB::table('ci_orders')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )
            ->where('ci_orders.order_id', $order_id)
            ->whereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('ci_order_item')
                    ->whereColumn('ci_order_item.order_id', 'ci_orders.order_id')
                    ->where('ci_order_item.service_id', 30);
            })
            ->where('ci_orders.order_from', '!=', 2)
            ->first();

        if (!$order) {
            // Handle not found
            return redirect()->back()->with('error', 'Order not found or invalid');
        }

        // Get items for this order
        $itemList = DB::table('ci_order_item')
            ->where('order_id', $order->order_id)
            ->where('service_id', 30)
            ->get();

        $total = 0;

        foreach ($itemList as $item) {
            $categoryIds = DB::table('ci_order_item_packages')
                ->where('order_id', $order->order_id)
                ->pluck('package_id')
                ->unique()
                ->toArray();

            if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                $product_item_price = $item->product_discount_amount;
            } else {
                $product_item_price = $item->package_item_price;
            }

            $total += $product_item_price * $item->package_quantity;
        }

        $order->packagecategory_ids = $categoryIds;

        // Attach item list and subtotal
        $order->items = $itemList;
        $order->sub_total = $total;

        $data['shippingAddress'] = DB::table('ci_shipping_address')->where('order_id', $order->order_id)->where('user_id', $order->user_id)->first();

        $data['order'] = $order;

        $data['emiratesList'] = [
            ['name' => 'Dubai',          'id' => 17],
            ['name' => 'Abu Dhabi',      'id' => 20],
            ['name' => 'Sharjah',        'id' => 22],
            ['name' => 'Ajman',          'id' => 23],
            ['name' => 'Umm Al Quwain',  'id' => 24],
            ['name' => 'Ras Al Khaimah', 'id' => 25],
            ['name' => 'Fujairah',       'id' => 26],
        ];

        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();
        $data['subservice_data'] = DB::table('subservices')->where('serviceid', '30')->where('is_active', '0')->orderBy('id', 'DESC')->get();

        $data['country_data'] = DB::table('countries')->get();
        $data['selectedPackages'] = $itemList->pluck('package_id')->toArray();
        return view('admin.package-orders.moving.edit_order', $data);
    }

    public function moving_order_update(Request $request, Ciorder $ci_order)
    {
        //echo"<pre>";print_r($request->all());exit;
        //  echo"<pre>";print_r($request->all());exit;
        DB::beginTransaction();
        try {

            $mode = ($request->payment_method == 'ONLINE') ? 2 : 1;

            $content = [
                'user_id'             => $request->customer_id,
                'order_total'         => $request->order_total,
                'front_wallet_amount'   => "0",
                'shippingcost'          => "0",
                'paymentmode'           => $mode,
                'vatcharge'             => $request->vat_charge,
                'cod_charge'             => $request->cod_charge,
                'sub_total'             => $request->sub_total,
                'order_status'          => 'BK',
                'payment_status'        => 'Success',
                'coupan_to_wallet'      => "0",
                'coupondiscount'        => "0",
                'moving_date'           => $request->moving_date,
                'order_from'            => '0',
                'created_at'            => $ci_order->created_at ?? date('Y-m-d H:i:s'),
            ];

            $ci_order->update($content);

            $order_id = $ci_order->order_id;

            CiorderItem::orderId($order_id)->delete();

            $subservice_id = $request->subservice_id;
            $subserviceData = DB::table('subservices')->where('id', $subservice_id)->first();
            $service_id = $subserviceData->serviceid ?? null;

            $date = Carbon::parse($request->moving_date);
            $booking_date = $date->day;
            $monthName = $date->format('F');
            $yearValue = $date->year;

            if (!empty($request->package) && is_array($request->package)) {
                $service_name = DB::table('services')->where('id', $service_id)->value('servicename');
                $subservice_name = $subserviceData->subservicename ?? '';

                foreach ($request->package as $packageId) {
                    $quantityKey = $packageId . '_quantity';
                    $priceKey = $packageId . '_price';

                    $package_item = DB::table('packages')->where('id', $packageId)->first();

                    if ($package_item && isset($request->$quantityKey)) {
                        $package_category_id = $package_item->packagecategory_id;
                        $package_category_name = DB::table('package_categories')->where('id', $package_category_id)->value('name');

                        CiorderItem::create([
                            'order_id'             => $order_id,
                            'user_info_id'         => $request->customer_id,
                            'package_id'           => $package_item->id,
                            'package_item_name'    => $package_item->name,
                            'package_quantity'     => is_array($request->$quantityKey) ? implode(',', $request->$quantityKey) : $request->$quantityKey,
                            'package_item_price'   => is_array($request->$priceKey) ? implode(',', $request->$priceKey) : $request->$priceKey,
                            'service_id'           => $service_id,
                            'service_name'         => $service_name,
                            'subservice_id'        => $request->subservice_id,
                            'subservice_name'      => $subservice_name,
                            'packagecategory_id'   => $package_category_id,
                            'packagecategory_name' => $package_category_name,
                            'page_url'             => "",
                            'cdate'                => date('Y-m-d'),
                            'bookingdate'          => $booking_date,
                            'month'                => $monthName,
                            'bookingyear'          => $yearValue,
                            'time_slot'            => $request->time_slot,
                            'origin_add'   => $request->origin_add,
                            'origin_country'   => $request->origin_country,
                            'origin_state'   => $request->origin_state,
                            'origin_city'   => $request->origin_city,
                            'origin_location'   => $request->origin_location,
                            'origin_zip_post'   => $request->origin_zip_post,
                            'desti_add'   => $request->desti_add,
                            'desti_country'   => $request->desti_country,
                            'desti_state'   => $request->desti_state,
                            'desti_city'   => $request->desti_city,
                            'desti_location'   => $request->desti_location,
                            'desti_zip_post'   => $request->desti_zip_post,
                            'any_special_instruction'   => $request->additional_message,
                        ]);
                    }
                }
            }

            if ($request->first_name != '') {
                $shippingData = [
                    'first_name'         => $request->first_name,
                    'last_name'          => $request->last_name,
                    'country'            => $request->country,
                    'emirate'            => $request->emirates,
                    'area'               => $request->area,
                    'address1'           => $request->street,
                    'state'              => $request->state_name,
                    'city'               => $request->city,
                    'zipcode'            => $request->zipcode,
                    'address2'           => $request->apartment_villa,
                    'phone_number'       => $request->phone,
                    'email_address'      => $request->email,
                    'additional_message' => $request->additional_message,
                    'payment_method'     => "1",
                    'user_id'            => $request->customer_id,
                    'order_id'           => $order_id,
                ];

                CiShippingAddress::orderId($order_id)->update($shippingData);
            }

            DB::commit();
            return redirect()->route('order.index')->with('success', 'Order has been updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Moving Order update failed : " . $e->getMessage());
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage())->withInput();
        }
    }

    public function handyman_order_edit(Ciorder $ci_order)
    {
        $data['error'] = '';

        if (!$ci_order) {
            return redirect()->back()->with('error', 'Order not found or invalid');
        }

        $itemList = CiorderItem::orderId($ci_order->order_id)->serviceId(34)->get();

        $total = 0;

        foreach ($itemList as $item) {
            $categoryIds = DB::table('ci_order_item_packages')
                ->where('order_id', $ci_order->order_id)
                ->pluck('package_id')
                ->unique()
                ->toArray();

            if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                $product_item_price = $item->product_discount_amount;
            } else {
                $product_item_price = $item->package_item_price;
            }

            $total += $product_item_price * $item->package_quantity;
        }


        $data['orderItemPackages'] = DB::table('ci_order_item_packages')->where('order_id', $ci_order->order_id)->get();

        $ci_order->packagecategory_ids = $categoryIds;

        $ci_order->items = $itemList;

        $ci_order->sub_total = $total;

        $data['shippingAddress'] = CiShippingAddress::orderId($ci_order->order_id)->userId($ci_order->user_id)->first();

        $data['order'] = $ci_order;

        $data['emiratesList'] = [
            ['name' => 'Dubai',          'id' => 17],
            ['name' => 'Abu Dhabi',      'id' => 20],
            ['name' => 'Sharjah',        'id' => 22],
            ['name' => 'Ajman',          'id' => 23],
            ['name' => 'Umm Al Quwain',  'id' => 24],
            ['name' => 'Ras Al Khaimah', 'id' => 25],
            ['name' => 'Fujairah',       'id' => 26],
        ];

        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();
        $data['subservice_data'] = DB::table('subservices')->where('serviceid', '34')->where('is_active', '0')->orderBy('id', 'DESC')->get();

        $data['country_data'] = DB::table('countries')->get();
        $data['selectedPackages'] = $itemList->pluck('package_id')->toArray();
        $data['ev_charger_type'] = DB::table('ev_charger_type')->orderBy('set_order', 'asc')->get();
        $data['ev_charger_location_type'] = DB::table('ev_charger_location_type')->orderBy('set_order', 'asc')->get();
        return view('admin.package-orders.handyman.edit_order', $data);
    }

    public function handyman_order_update(Request $request, Ciorder $ci_order)
    {
        //echo"<pre>";print_r($request->all());exit;
        DB::beginTransaction();
        try {
            $user_id = $request->customer_id;
            $order_id = $ci_order->order_id;

            // 1. Calculate Charges Logic (From Handyman Store)
            $timing_date_charge = $request->date_time_charge;
            $mode = ($request->payment_method == 'ONLINE') ? 2 : 1;

            // 2. Update the main Order record (Ciorder)
            $content = [
                'user_id'             => $user_id,
                'order_total'         => $request->order_total,
                'vatcharge'           => $request->vat_charge,
                'front_wallet_amount' => '0',
                'order_status'        => 'BK',
                'paymentmode'         => $mode,
                'payment_status'      => 'Success',
                'service_charge'      => $request->service_charge,
                'timing_charge'       => $timing_date_charge,
                'sub_total'           => $request->sub_total,
                'cod_charge'          => $request->cod_charge,
                'list_order_status'     => '0',
                'service_fee'         => $request->service_fee,
                'created_at'          => $ci_order->created_at ?? date('Y-m-d H:i:s'),
            ];

            $ci_order->update($content);

            // 3. Clear existing items and package records to prevent duplicates
            CiorderItem::orderId($order_id)->delete();
            DB::table('ci_order_item_packages')->where('order_id', $order_id)->delete();

            // 4. Handle Service and Date Logic
            $subservice_id = $request->subservice_id;
            $subserviceData = DB::table('subservices')->where('id', $subservice_id)->first();
            $service_id = $subserviceData->serviceid ?? null;

            // Consistent Date Formatting (Store Logic)
            $bookingdate_input = $request->service_date; // Using service_date as per store function
            $bookingyear = date('Y', strtotime($bookingdate_input));
            $month       = date('F', strtotime($bookingdate_input));
            $day         = date('j', strtotime($bookingdate_input));


            $formatted_date = date('Y-m-d', strtotime($bookingdate_input));

            $end_date = $formatted_date;

            // 5. Insert into ci_order_item
            $item_data = [
                'order_id'                          => $order_id,
                'user_info_id'                      => $user_id,
                'cleaner_id'                        => $request->cleaner,
                'service_id'                        => $service_id,
                'subservice_id'                     => $subservice_id,
                'address_type'                      => $request->address_type,
                'city'                              => $request->city,
                'area'                              => $request->area,
                'building_street_no'                => $request->building_name,
                'apartment_villa_no'                => $request->apartment_villa_num,
                'bookingdate'                       => $day,
                'bookingyear'                       => $bookingyear,
                'month'                             => $month,
                'end_date'                          => $end_date,
                'time_slot'                         => $request->time_slot,
                'charger_type'                      => $request->charger_type,
                'installation_location_type'        => $request->installation_location_type,
                'installation_charge'               => $request->installation_charge,
                'cdate'                             => date('Y-m-d'),
            ];

            $order_item_id = DB::table('ci_order_item')->insertGetId($item_data);

            // 6. Handle Packages (Loop Logic)
            if (!empty($request->package) && is_array($request->package)) {
                $service_name = DB::table('services')->where('id', $service_id)->value('servicename');
                $subservice_name = $subserviceData->subservicename ?? '';

                foreach ($request->package as $packageId) {
                    $quantityKey = $packageId . '_quantity';
                    $priceKey = $packageId . '_price';

                    $package_item = DB::table('packages')->where('id', $packageId)->first();

                    if ($package_item && isset($request->$quantityKey)) {
                        $package_category_id = $package_item->packagecategory_id;
                        $package_category_name = DB::table('package_categories')->where('id', $package_category_id)->value('name');

                        DB::table('ci_order_item_packages')->insert([
                            'order_id'             => $order_id,
                            'order_item_id'        => $order_item_id,
                            'user_info_id'         => $user_id,
                            'package_id'           => $packageId,
                            'package_item_name'    => $package_item->name,
                            'package_quantity'     => is_array($request->$quantityKey) ? implode(',', $request->$quantityKey) : $request->$quantityKey,
                            'package_item_price'   => is_array($request->$priceKey) ? implode(',', $request->$priceKey) : $request->$priceKey,
                            'service_id'           => $service_id,
                            'service_name'         => $service_name,
                            'subservice_id'        => $subservice_id,
                            'subservice_name'      => $subservice_name,
                            'packagecategory_id'   => $package_category_id,
                            'packagecategory_name' => $package_category_name,
                            'image'                => $package_item->image,
                            'cdate'                => date('Y-m-d'),
                        ]);
                    }
                }
            }

            $shipping_data = array(
                'order_id'      => $order_id,
                'user_id'       => $user_id,
                'first_name'    => "",
                'last_name'     => "",
                'country'       => "",
                'address1'      => "",
                'state'         => "",
                'city'          => "",
                'zipcode'       => "",
                'address2'      => "",
                'phone_number'  => "",
                'email_address' => "",
            );

            CiShippingAddress::orderId($order_id)->update($shipping_data);

            DB::commit();

            return redirect()->route('handyman-service-order')->with('success', 'Order has been updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Handyman Order update failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage())->withInput();
        }
    }

    public function salon_spa_order_edit(Ciorder $ci_order)
    {
        $data['error'] = '';

        if (!$ci_order) {
            return redirect()->back()->with('error', 'Order not found or invalid');
        }

        $itemList = CiorderItem::orderId($ci_order->order_id)->serviceId(48)->get();

        $total = 0;

        foreach ($itemList as $item) {
            $categoryIds = DB::table('ci_order_item_packages')
                ->where('order_id', $ci_order->order_id)
                ->pluck('package_id')
                ->unique()
                ->toArray();

            if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                $product_item_price = $item->product_discount_amount;
            } else {
                $product_item_price = $item->package_item_price;
            }

            $total += $product_item_price * $item->package_quantity;
        }


        $data['orderItemPackages'] = DB::table('ci_order_item_packages')->where('order_id', $ci_order->order_id)->get();

        $ci_order->packagecategory_ids = $categoryIds;

        $ci_order->items = $itemList;

        $ci_order->sub_total = $total;

        $data['shippingAddress'] = CiShippingAddress::orderId($ci_order->order_id)->userId($ci_order->user_id)->first();

        $data['order'] = $ci_order;

        $data['emiratesList'] = [
            ['name' => 'Dubai',          'id' => 17],
            ['name' => 'Abu Dhabi',      'id' => 20],
            ['name' => 'Sharjah',        'id' => 22],
            ['name' => 'Ajman',          'id' => 23],
            ['name' => 'Umm Al Quwain',  'id' => 24],
            ['name' => 'Ras Al Khaimah', 'id' => 25],
            ['name' => 'Fujairah',       'id' => 26],
        ];

        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();
        $data['subservice_data'] = DB::table('subservices')->where('serviceid', '48')->where('is_active', '0')->orderBy('id', 'DESC')->get();

        $data['country_data'] = DB::table('countries')->get();
        $data['selectedPackages'] = $itemList->pluck('package_id')->toArray();
        return view('admin.package-orders.salon-spa.edit_order', $data);
    }

    public function salon_spa_order_update(Request $request, Ciorder $ci_order)
    {
        DB::beginTransaction();
        try {
            $user_id = $request->customer_id;
            $order_id = $ci_order->order_id;

            // 1. Calculate Charges Logic (From Handyman Store)
            $timing_date_charge = $request->date_time_charge;
            $mode = ($request->payment_method == 'ONLINE') ? 2 : 1;

            // 2. Update the main Order record (Ciorder)
            $content = [
                'user_id'             => $user_id,
                'order_total'         => $request->order_total,
                'vatcharge'           => $request->vat_charge,
                'front_wallet_amount' => '0',
                'order_status'        => 'BK',
                'paymentmode'         => $mode,
                'payment_status'      => 'Success',
                'service_charge'      => $request->service_charge,
                'timing_charge'       => $timing_date_charge,
                'sub_total'           => $request->sub_total,
                'cod_charge'          => $request->cod_charge,
                'list_order_status'     => '0',
                'service_fee'         => $request->service_fee,
                'created_at'          => $ci_order->created_at ?? date('Y-m-d H:i:s'),
            ];

            $ci_order->update($content);

            // 3. Clear existing items and package records to prevent duplicates
            CiorderItem::orderId($order_id)->delete();
            DB::table('ci_order_item_packages')->where('order_id', $order_id)->delete();

            // 4. Handle Service and Date Logic
            $subservice_id = $request->subservice_id;
            $subserviceData = DB::table('subservices')->where('id', $subservice_id)->first();
            $service_id = $subserviceData->serviceid ?? null;

            // Consistent Date Formatting (Store Logic)
            $bookingdate_input = $request->service_date; // Using service_date as per store function
            $bookingyear = date('Y', strtotime($bookingdate_input));
            $month       = date('F', strtotime($bookingdate_input));
            $day         = date('j', strtotime($bookingdate_input));

            // 5. Insert into ci_order_item
            $item_data = [
                'order_id'                          => $order_id,
                'user_info_id'                      => $user_id,
                'cleaner_id'                        => $request->cleaner,
                'service_id'                        => $service_id,
                'subservice_id'                     => $subservice_id,
                'address_type'                      => $request->address_type,
                'city'                              => $request->city,
                'area'                              => $request->area,
                'building_street_no'                => $request->building_name,
                'apartment_villa_no'                => $request->apartment_villa_num,
                'bookingdate'                       => $day,
                'bookingyear'                       => $bookingyear,
                'month'                             => $month,
                'time_slot'                         => $request->time_slot,
                'cdate'                             => date('Y-m-d'),
            ];

            $order_item_id = DB::table('ci_order_item')->insertGetId($item_data);

            // 6. Handle Packages (Loop Logic)
            if (!empty($request->package) && is_array($request->package)) {
                $service_name = DB::table('services')->where('id', $service_id)->value('servicename');
                $subservice_name = $subserviceData->subservicename ?? '';

                foreach ($request->package as $packageId) {
                    $quantityKey = $packageId . '_quantity';
                    $priceKey = $packageId . '_price';

                    $package_item = DB::table('packages')->where('id', $packageId)->first();

                    if ($package_item && isset($request->$quantityKey)) {
                        $package_category_id = $package_item->packagecategory_id;
                        $package_category_name = DB::table('package_categories')->where('id', $package_category_id)->value('name');

                        DB::table('ci_order_item_packages')->insert([
                            'order_id'             => $order_id,
                            'order_item_id'        => $order_item_id,
                            'user_info_id'         => $user_id,
                            'package_id'           => $packageId,
                            'package_item_name'    => $package_item->name,
                            'package_quantity'     => is_array($request->$quantityKey) ? implode(',', $request->$quantityKey) : $request->$quantityKey,
                            'package_item_price'   => is_array($request->$priceKey) ? implode(',', $request->$priceKey) : $request->$priceKey,
                            'service_id'           => $service_id,
                            'service_name'         => $service_name,
                            'subservice_id'        => $subservice_id,
                            'subservice_name'      => $subservice_name,
                            'packagecategory_id'   => $package_category_id,
                            'packagecategory_name' => $package_category_name,
                            'image'                => $package_item->image,
                            'cdate'                => date('Y-m-d'),
                        ]);
                    }
                }
            }

            $shipping_data = array(
                'order_id'      => $order_id,
                'user_id'       => $user_id,
                'first_name'    => "",
                'last_name'     => "",
                'country'       => "",
                'address1'      => "",
                'state'         => "",
                'city'          => "",
                'zipcode'       => "",
                'address2'      => "",
                'phone_number'  => "",
                'email_address' => "",
            );

            CiShippingAddress::orderId($order_id)->update($shipping_data);

            DB::commit();

            return redirect()->route('salon-spa-order')->with('success', 'Order has been updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Salon & Spa Order update failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage())->withInput();
        }
    }


    public function pest_control_order_edit(Ciorder $ci_order)
    {
        $data['error'] = '';

        if (!$ci_order) {
            return redirect()->back()->with('error', 'Order not found or invalid');
        }

        $itemList = CiorderItem::orderId($ci_order->order_id)->serviceId(47)->get();

        $total = 0;

        foreach ($itemList as $item) {
            $categoryIds = DB::table('ci_order_item_packages')
                ->where('order_id', $ci_order->order_id)
                ->pluck('package_id')
                ->unique()
                ->toArray();

            if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                $product_item_price = $item->product_discount_amount;
            } else {
                $product_item_price = $item->package_item_price;
            }

            $total += $product_item_price * $item->package_quantity;
        }


        $data['orderItemPackages'] = DB::table('ci_order_item_packages')->where('order_id', $ci_order->order_id)->get();

        $ci_order->packagecategory_ids = $categoryIds;

        $ci_order->items = $itemList;

        $ci_order->sub_total = $total;

        $data['shippingAddress'] = CiShippingAddress::orderId($ci_order->order_id)->userId($ci_order->user_id)->first();

        $data['order'] = $ci_order;

        $data['emiratesList'] = [
            ['name' => 'Dubai',          'id' => 17],
            ['name' => 'Abu Dhabi',      'id' => 20],
            ['name' => 'Sharjah',        'id' => 22],
            ['name' => 'Ajman',          'id' => 23],
            ['name' => 'Umm Al Quwain',  'id' => 24],
            ['name' => 'Ras Al Khaimah', 'id' => 25],
            ['name' => 'Fujairah',       'id' => 26],
        ];

        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();
        $data['subservice_data'] = DB::table('subservices')->where('serviceid', '47')->where('is_active', '0')->orderBy('id', 'DESC')->get();

        $data['country_data'] = DB::table('countries')->get();
        $data['selectedPackages'] = $itemList->pluck('package_id')->toArray();
        return view('admin.package-orders.pest-control.edit_order', $data);
    }

    public function pest_control_order_update(Request $request, Ciorder $ci_order)
    {
        DB::beginTransaction();
        try {
            $user_id = $request->customer_id;
            $order_id = $ci_order->order_id;

            // 1. Calculate Charges Logic (From Handyman Store)
            $timing_date_charge = $request->date_time_charge;
            $mode = ($request->payment_method == 'ONLINE') ? 2 : 1;

            // 2. Update the main Order record (Ciorder)
            $content = [
                'user_id'             => $user_id,
                'order_total'         => $request->order_total,
                'vatcharge'           => $request->vat_charge,
                'front_wallet_amount' => '0',
                'order_status'        => 'BK',
                'paymentmode'         => $mode,
                'payment_status'      => 'Success',
                'service_charge'      => $request->service_charge,
                'timing_charge'       => $timing_date_charge,
                'sub_total'           => $request->sub_total,
                'cod_charge'          => $request->cod_charge,
                'list_order_status'     => '0',
                'service_fee'         => $request->service_fee,
                'created_at'          => $ci_order->created_at ?? date('Y-m-d H:i:s'),
            ];

            $ci_order->update($content);

            // 3. Clear existing items and package records to prevent duplicates
            CiorderItem::orderId($order_id)->delete();
            DB::table('ci_order_item_packages')->where('order_id', $order_id)->delete();

            // 4. Handle Service and Date Logic
            $subservice_id = $request->subservice_id;
            $subserviceData = DB::table('subservices')->where('id', $subservice_id)->first();
            $service_id = $subserviceData->serviceid ?? null;

            // Consistent Date Formatting (Store Logic)
            $bookingdate_input = $request->service_date; // Using service_date as per store function
            $bookingyear = date('Y', strtotime($bookingdate_input));
            $month       = date('F', strtotime($bookingdate_input));
            $day         = date('j', strtotime($bookingdate_input));

            // 5. Insert into ci_order_item
            $item_data = [
                'order_id'                          => $order_id,
                'user_info_id'                      => $user_id,
                'cleaner_id'                        => $request->cleaner,
                'service_id'                        => $service_id,
                'subservice_id'                     => $subservice_id,
                'address_type'                      => $request->address_type,
                'city'                              => $request->city,
                'area'                              => $request->area,
                'building_street_no'                => $request->building_name,
                'apartment_villa_no'                => $request->apartment_villa_num,
                'bookingdate'                       => $day,
                'bookingyear'                       => $bookingyear,
                'month'                             => $month,
                'time_slot'                         => $request->time_slot,
                'cdate'                             => date('Y-m-d'),
            ];

            $order_item_id = DB::table('ci_order_item')->insertGetId($item_data);

            // 6. Handle Packages (Loop Logic)
            if (!empty($request->package) && is_array($request->package)) {
                $service_name = DB::table('services')->where('id', $service_id)->value('servicename');
                $subservice_name = $subserviceData->subservicename ?? '';

                foreach ($request->package as $packageId) {
                    $quantityKey = $packageId . '_quantity';
                    $priceKey = $packageId . '_price';

                    $package_item = DB::table('packages')->where('id', $packageId)->first();

                    if ($package_item && isset($request->$quantityKey)) {
                        $package_category_id = $package_item->packagecategory_id;
                        $package_category_name = DB::table('package_categories')->where('id', $package_category_id)->value('name');

                        DB::table('ci_order_item_packages')->insert([
                            'order_id'             => $order_id,
                            'order_item_id'        => $order_item_id,
                            'user_info_id'         => $user_id,
                            'package_id'           => $packageId,
                            'package_item_name'    => $package_item->name,
                            'package_quantity'     => is_array($request->$quantityKey) ? implode(',', $request->$quantityKey) : $request->$quantityKey,
                            'package_item_price'   => is_array($request->$priceKey) ? implode(',', $request->$priceKey) : $request->$priceKey,
                            'service_id'           => $service_id,
                            'service_name'         => $service_name,
                            'subservice_id'        => $subservice_id,
                            'subservice_name'      => $subservice_name,
                            'packagecategory_id'   => $package_category_id,
                            'packagecategory_name' => $package_category_name,
                            'image'                => $package_item->image,
                            'cdate'                => date('Y-m-d'),
                        ]);
                    }
                }
            }

            $shipping_data = array(
                'order_id'      => $order_id,
                'user_id'       => $user_id,
                'first_name'    => "",
                'last_name'     => "",
                'country'       => "",
                'address1'      => "",
                'state'         => "",
                'city'          => "",
                'zipcode'       => "",
                'address2'      => "",
                'phone_number'  => "",
                'email_address' => "",
            );

            CiShippingAddress::orderId($order_id)->update($shipping_data);

            DB::commit();

            return redirect()->route('pest-control-order')->with('success', 'Order has been updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Pest Control Order update failed: " . $e);
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage())->withInput();
        }
    }

    public function automobile_order_edit(Ciorder $ci_order)
    {
        $data['error'] = '';

        if (!$ci_order) {
            return redirect()->back()->with('error', 'Order not found or invalid');
        }

        $itemList = CiorderItem::orderId($ci_order->order_id)->serviceId(50)->get();

        $total = 0;

        foreach ($itemList as $item) {
            $categoryIds = DB::table('ci_order_item_packages')
                ->where('order_id', $ci_order->order_id)
                ->pluck('package_id')
                ->unique()
                ->toArray();

            if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                $product_item_price = $item->product_discount_amount;
            } else {
                $product_item_price = $item->package_item_price;
            }

            $total += $product_item_price * $item->package_quantity;
        }


        $data['orderItemPackages'] = DB::table('ci_order_item_packages')->where('order_id', $ci_order->order_id)->get();

        $ci_order->packagecategory_ids = $categoryIds;

        $ci_order->items = $itemList;

        $ci_order->sub_total = $total;

        $data['shippingAddress'] = CiShippingAddress::orderId($ci_order->order_id)->userId($ci_order->user_id)->first();

        $data['order'] = $ci_order;

        $data['emiratesList'] = [
            ['name' => 'Dubai',          'id' => 17],
            ['name' => 'Abu Dhabi',      'id' => 20],
            ['name' => 'Sharjah',        'id' => 22],
            ['name' => 'Ajman',          'id' => 23],
            ['name' => 'Umm Al Quwain',  'id' => 24],
            ['name' => 'Ras Al Khaimah', 'id' => 25],
            ['name' => 'Fujairah',       'id' => 26],
        ];

        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();
        $data['subservice_data'] = DB::table('subservices')->where('serviceid', '50')->where('is_active', '0')->orderBy('id', 'DESC')->get();

        $data['country_data'] = DB::table('countries')->get();
        $data['selectedPackages'] = $itemList->pluck('package_id')->toArray();
        return view('admin.package-orders.auto-mobile.edit_order', $data);
    }

    public function automobile_order_update(Request $request, Ciorder $ci_order)
    {
        DB::beginTransaction();
        try {
            $user_id = $request->customer_id;
            $order_id = $ci_order->order_id;

            // 1. Calculate Charges Logic (From Handyman Store)
            $timing_date_charge = $request->date_time_charge;
            $mode = ($request->payment_method == 'ONLINE') ? 2 : 1;

            // 2. Update the main Order record (Ciorder)
            $content = [
                'user_id'             => $user_id,
                'order_total'         => $request->order_total,
                'vatcharge'           => $request->vat_charge,
                'front_wallet_amount' => '0',
                'order_status'        => 'BK',
                'paymentmode'         => $mode,
                'payment_status'      => 'Success',
                'service_charge'      => $request->service_charge,
                'timing_charge'       => $timing_date_charge,
                'sub_total'           => $request->sub_total,
                'cod_charge'          => $request->cod_charge,
                'list_order_status'     => '0',
                'service_fee'         => $request->service_fee,
                'created_at'          => $ci_order->created_at ?? date('Y-m-d H:i:s'),
            ];

            $ci_order->update($content);

            // 3. Clear existing items and package records to prevent duplicates
            CiorderItem::orderId($order_id)->delete();
            DB::table('ci_order_item_packages')->where('order_id', $order_id)->delete();

            // 4. Handle Service and Date Logic
            $subservice_id = $request->subservice_id;
            $subserviceData = DB::table('subservices')->where('id', $subservice_id)->first();
            $service_id = $subserviceData->serviceid ?? null;

            // Consistent Date Formatting (Store Logic)
            $bookingdate_input = $request->service_date; // Using service_date as per store function
            $bookingyear = date('Y', strtotime($bookingdate_input));
            $month       = date('F', strtotime($bookingdate_input));
            $day         = date('j', strtotime($bookingdate_input));

            // 5. Insert into ci_order_item
            $item_data = [
                'order_id'                          => $order_id,
                'user_info_id'                      => $user_id,
                'cleaner_id'                        => $request->cleaner,
                'service_id'                        => $service_id,
                'subservice_id'                     => $subservice_id,
                'address_type'                      => $request->address_type,
                'city'                              => $request->city,
                'area'                              => $request->area,
                'building_street_no'                => $request->building_name,
                'apartment_villa_no'                => $request->apartment_villa_num,
                'bookingdate'                       => $day,
                'bookingyear'                       => $bookingyear,
                'month'                             => $month,
                'time_slot'                         => $request->time_slot,
                'cdate'                             => date('Y-m-d'),
            ];

            $order_item_id = DB::table('ci_order_item')->insertGetId($item_data);

            // 6. Handle Packages (Loop Logic)
            if (!empty($request->package) && is_array($request->package)) {
                $service_name = DB::table('services')->where('id', $service_id)->value('servicename');
                $subservice_name = $subserviceData->subservicename ?? '';

                foreach ($request->package as $packageId) {
                    $quantityKey = $packageId . '_quantity';
                    $priceKey = $packageId . '_price';

                    $package_item = DB::table('packages')->where('id', $packageId)->first();

                    if ($package_item && isset($request->$quantityKey)) {
                        $package_category_id = $package_item->packagecategory_id;
                        $package_category_name = DB::table('package_categories')->where('id', $package_category_id)->value('name');

                        DB::table('ci_order_item_packages')->insert([
                            'order_id'             => $order_id,
                            'order_item_id'        => $order_item_id,
                            'user_info_id'         => $user_id,
                            'package_id'           => $packageId,
                            'package_item_name'    => $package_item->name,
                            'package_quantity'     => is_array($request->$quantityKey) ? implode(',', $request->$quantityKey) : $request->$quantityKey,
                            'package_item_price'   => is_array($request->$priceKey) ? implode(',', $request->$priceKey) : $request->$priceKey,
                            'service_id'           => $service_id,
                            'service_name'         => $service_name,
                            'subservice_id'        => $subservice_id,
                            'subservice_name'      => $subservice_name,
                            'packagecategory_id'   => $package_category_id,
                            'packagecategory_name' => $package_category_name,
                            'image'                => $package_item->image,
                            'cdate'                => date('Y-m-d'),
                        ]);
                    }
                }
            }

            $shipping_data = array(
                'order_id'      => $order_id,
                'user_id'       => $user_id,
                'first_name'    => "",
                'last_name'     => "",
                'country'       => "",
                'address1'      => "",
                'state'         => "",
                'city'          => "",
                'zipcode'       => "",
                'address2'      => "",
                'phone_number'  => "",
                'email_address' => "",
            );

            CiShippingAddress::orderId($order_id)->update($shipping_data);

            DB::commit();

            return redirect()->route('automobile-order')->with('success', 'Order has been updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Auto Mobiles Order update failed: " . $e);
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage())->withInput();
        }
    }

    public function getCleaners(Request $request)
    {
        $data = DB::table('users')
            ->where('role_id', 16)
            ->where('is_active', '0')
            ->whereRaw('FIND_IN_SET(?, service)', [$request->service_id])
            ->whereRaw('FIND_IN_SET(?, subservice)', [$request->subservice_id])
            ->orderBy('id', 'ASC')
            ->get();

        return response()->json([
            'status' => 1,
            'data' => $data
        ]);
    }
    // public function getAmountHistory(Request $request)
    // {
    //     $order = DB::table('ci_orders')
    //         ->where('order_id', $request->order_id)
    //         ->first();

    //     $data = DB::table('package_order_amount_attr')
    //         ->where('order_id', $order->format_order_id)
    //         ->get();

    //     $total = $data->sum('add_amount');
    //     $balance = $order->order_total - $total;

    //     return response()->json([
    //         'data' => $data,
    //         'balance' => $balance
    //     ]);
    // }
    public function getAmountHistory(Request $request)
    {
        $order = DB::table('ci_orders')
            ->where('order_id', $request->order_id)
            ->first();

        if (!$order) {
            return response()->json([
                'data' => [],
                'balance' => 0
            ]);
        }

        // ✅ IMPORTANT FIX: use numeric order_id
        $data = DB::table('package_order_amount_attr')
            ->where('order_id', $order->format_order_id)
            ->orderBy('id', 'desc')
            ->get();

        // ✅ Sum with proper precision
        $total = $data->sum('add_amount');

        // ✅ Use bcsub for currency safety
        $balance = bcsub($order->order_total, $total, 2);

        return response()->json([
            'data' => $data,
            'balance' => $balance
        ]);
    }


    private function getValidDates($item)
    {
        $dates = [];

        $current_start = strtotime(date('Y-m-01'));
        $current_end   = strtotime(date('Y-m-t'));

        $start = strtotime($item->bookingdate . ' ' . $item->month . ' ' . $item->bookingyear);
        $end   = !empty($item->end_date) ? strtotime($item->end_date) : $start;

        $days = [];

        if (!empty($item->which_day_of_the_week_do_you_want_the_service)) {
            $days = array_map('trim', explode(',', $item->which_day_of_the_week_do_you_want_the_service));
        }

        // ONCE
        if (empty($days)) {
            if ($start >= $current_start && $start <= $current_end) {
                $dates[] = date('Y-m-d', $start);
            }
            return $dates;
        }

        // WEEKLY / MULTIPLE
        for ($d = $current_start; $d <= $current_end; $d = strtotime("+1 day", $d)) {

            if ($d < $start || $d > $end) {
                continue;
            }

            if (in_array(date('l', $d), $days)) {
                $dates[] = date('Y-m-d', $d);
            }
        }

        return $dates;
    }

    public function markAttendance(Request $request, $order_id)
    {
        $items = DB::table('ci_order_item')->where('order_id', $order_id)->get();

        // ✅ DEFAULT MONTH (from order if not selected)
        $firstItem = $items->first();

        $defaultMonth = (!empty($firstItem->bookingdate) && !empty($firstItem->month) && !empty($firstItem->bookingyear))
            ? date('Y-m', strtotime($firstItem->bookingdate . ' ' . $firstItem->month . ' ' . $firstItem->bookingyear))
            : date('Y-m');

        $month = $request->month ?? $defaultMonth;

        $start_month = date('Y-m-01', strtotime($month));
        $end_month   = date('Y-m-t', strtotime($month));

        $all_dates = [];
        $crew_ids = [];

        foreach ($items as $item) {

            // ✅ CREW IDS
            if (!empty($item->cleaner_id)) {
                $crew_ids = array_merge($crew_ids, explode(',', $item->cleaner_id));
            }

            $type = $item->how_often_do_you_need_cleaning;

            // ======================================
            // ✅ CASE 1: ONCE + DEEP CLEANING
            // ======================================
            if (empty($type) || $type == 'Once') {

                if (!empty($item->bookingdate) && !empty($item->month) && !empty($item->bookingyear)) {

                    $date = date('Y-m-d', strtotime(
                        $item->bookingdate . ' ' . $item->month . ' ' . $item->bookingyear
                    ));
                } elseif (!empty($item->end_date)) {

                    $date = date('Y-m-d', strtotime($item->end_date));
                } else {
                    continue;
                }

                // ✅ FILTER BY SELECTED MONTH
                if ($date >= $start_month && $date <= $end_month) {
                    $all_dates[] = $date;
                }
            }

            // ======================================
            // ✅ CASE 2: WEEKLY
            // ======================================
            elseif ($type == 'Weekly') {

                $day = $item->which_day_of_the_week_do_you_want_the_service;

                $current = strtotime($start_month);
                $end     = strtotime($end_month);

                while ($current <= $end) {

                    if (strtolower(date('l', $current)) == strtolower($day)) {
                        $all_dates[] = date('Y-m-d', $current);
                    }

                    $current = strtotime('+1 day', $current);
                }
            }

            // ======================================
            // ✅ CASE 3: MULTIPLE TIMES
            // ======================================
            elseif ($type == 'Multiple times a week') {

                $days = explode(',', $item->which_day_of_the_week_do_you_want_the_service);
                $days = array_map('trim', $days);

                $current = strtotime($start_month);
                $end     = strtotime($end_month);

                while ($current <= $end) {

                    if (in_array(date('l', $current), $days)) {
                        $all_dates[] = date('Y-m-d', $current);
                    }

                    $current = strtotime('+1 day', $current);
                }
            }
        }

        // ======================================
        // ✅ SAFETY: IF STILL EMPTY
        // ======================================
        if (empty($all_dates) && count($items)) {

            foreach ($items as $item) {

                if (!empty($item->end_date)) {
                    $all_dates[] = date('Y-m-d', strtotime($item->end_date));
                }
            }
        }

        // ======================================
        // ✅ FINAL CLEANUP
        // ======================================
        $all_dates = array_unique($all_dates);
        sort($all_dates);

        $crew_ids = array_unique($crew_ids);

        // ======================================
        // ✅ CREW LIST
        // ======================================
        $crews = DB::table('users')
            ->whereIn('id', $crew_ids)
            ->pluck('name', 'id');

        // ======================================
        // ✅ ALL CREW (REPLACE DROPDOWN)
        // ======================================
        $all_crews = DB::table('users')
            ->where('role_id', 16)
            ->orderBy('name')
            ->get();

        // ======================================
        // ✅ OLD ATTENDANCE
        // ======================================
        $attendance = DB::table('ci_crew_attendance')
            ->where('order_id', $order_id)
            ->whereBetween('attendance_date', [$start_month, $end_month])
            ->get()
            ->keyBy(fn($i) => $i->crew_id . '_' . $i->attendance_date);

        return view('admin.attendance.attendance', compact(
            'all_dates',
            'crew_ids',
            'crews',
            'attendance',
            'order_id',
            'all_crews',
            'month'
        ));
    }
    public function saveAttendance(Request $request)
    {
        foreach ($request->attendance as $crew_id => $dates) {

            foreach ($dates as $date => $row) {

                DB::table('ci_crew_attendance')->updateOrInsert(
                    [
                        'order_id' => $request->order_id,
                        'crew_id' => $crew_id,
                        'attendance_date' => $date,
                    ],
                    [
                        'work_type' => $row['type'] ?? null,
                        'hours' => $row['hours'] ?? 0,
                        'bonus' => $row['bonus'] ?? 0,
                        'material_used' => $row['material'] ?? 'No',
                        'material_cost' => $row['material_cost'] ?? 0,
                        'replaced_by' => $row['replace'] ?? null,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }

        return back()->with('success', 'Attendance Saved Successfully');
    }

    public function storage_package_order($order_id = '', $status = '')
    {
        $data['error'] = '';
        // First, fetch distinct orders
        $query = DB::table('ci_orders')->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*'
            )->whereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('ci_order_item')
                    ->whereColumn('ci_order_item.order_id', 'ci_orders.order_id')
                    ->where(function ($q) {
                        $q->whereIn('ci_order_item.subservice_id', [61, 62, 63, 66])
                            ->orWhere('ci_order_item.service_id', 44)
                            ->orWhereIn('ci_order_item.service_id', [30, 44]); // Broaden for anything related
                    })
                    ->where(function ($q) {
                        // Additional check to keep it storage focused if service is 30
                        $q->where('ci_order_item.service_id', '!=', 30)
                            ->orWhereIn('ci_order_item.subservice_id', [61, 62, 63, 66, 70]);
                    });
            });
        $query = $query->where('order_from', '!=', 2);
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
        $orderList = $query->get();
        // Now, for each order, fetch its items
        foreach ($orderList as $order) {
            $itemList = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->get();
            $total = 0;
            foreach ($itemList as $item) {
                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }
                $total += $product_item_price * $item->package_quantity;
            }
            // Attach the items and subtotal to the order object
            $order->items = $itemList;
            // $order->sub_total = $total;
        }
        $data['orders_list'] = $orderList;
        return view('admin.list_order', $data);
    }

    public function storage_admin_order(Request $request)
    {
        $enquiry_id = $request->enquiry_id;
        $renew_id = $request->renew_id;
        $data['enquiry_id'] = $enquiry_id;
        $data['enquiry_data'] = null;
        $data['warehouse_data'] = null;
        $data['old_order_item'] = null;
        $data['costing_attribute'] = collect();
        $data['prefilled_items'] = [];
        $data['renew_id'] = 0;

        $data['warehouse_info'] = [
            'warehouse_name' => '',
            'unit_no' => '',
            'emirate_id' => '',
            'trade_license' => '',
            'from_date' => '',
            'to_date' => ''
        ];


        if ($renew_id) {
            $data['renew_id'] = $renew_id;
            $data['old_order'] = DB::table('ci_orders')->where('order_id', $renew_id)->first();
            $old_order_item = DB::table('ci_order_item')->where('order_id', $renew_id)->first();
            $data['old_order_item'] = $old_order_item;

            if ($old_order_item) {

                $instruction = $old_order_item->items_to_store ?? '';
                // The store method saves it as "Items to store: Item1, Item2..." or similar
                $possible_items = ['Furniture', 'Personal Items', 'Company Goods / Inventory', 'Cars', 'Perishables', 'Event / Exhibition Items', 'Documents', 'Pianos'];
                foreach ($possible_items as $pi) {
                    if (stripos($instruction, $pi) !== false) {
                        $data['prefilled_items'][] = $pi;
                    }
                }


                $w_name = $old_order_item->warehouse_name ?? '';
                $u_no = $old_order_item->unit_no ?? '';

                if ($w_name && $u_no) {
                    $data['parsed_warehouse_name'] = $w_name;
                    $data['parsed_unit_no'] = $u_no;
                }
            }

            // Fetch quotation items for the old order specifically
            $old_quotation_items = DB::table('ci_order_quotation_items')->where('ci_order_id', $renew_id)->get();
            if ($old_quotation_items->isNotEmpty()) {
                $data['costing_attribute'] = $old_quotation_items;
            } else {
                // Fallback to enquiry level for older orders
                if ($enquiry_id) {
                    $data['costing_attribute'] = DB::table('costing_attribute')->where('enquiry_id', $enquiry_id)->get();
                }
            }

            // Ensure "Storage Rent" is present for renewals
            $has_storage_rent = false;
            foreach ($data['costing_attribute'] as $item) {
                if (stripos($item->description, 'Storage Rent') !== false) {
                    $has_storage_rent = true;
                    break;
                }
            }

            if (!$has_storage_rent) {
                $storage_rent_item = (object) [
                    'id' => null,
                    'description' => 'Storage Rent',
                    'qty' => 1,
                    'prov' => $data['old_order']->order_total ?? 0,
                    'total' => $data['old_order']->order_total ?? 0
                ];
                // Convert to collection if it wasn't already or just push
                if (!($data['costing_attribute'] instanceof \Illuminate\Support\Collection)) {
                    $data['costing_attribute'] = collect($data['costing_attribute']);
                }
                $data['costing_attribute']->push($storage_rent_item);
            }

            $data['enquiry_data'] = DB::table('erp_enquiry')->where('id', $old_quotation_items[0]->enqid)->first();

            $data['warehouse_info'] = [
                'warehouse_name' => $old_order_item->warehouse_name ?? '',
                'unit_no' => $old_order_item->unit_no ?? '',
                'emirate_id' => $old_order_item->emirate_id ?? '',
                'trade_license' => $old_order_item->trade_license ?? '',
                'from_date' => $old_order_item->storage_from_date ?? '',
                'to_date' => $old_order_item->storage_to_date ?? ''
            ];
        }

        if ($enquiry_id) {
            $data['enquiry_data'] = DB::table('erp_enquiry')->where('id', $enquiry_id)->first();
            $data['warehouse_data'] = DB::table('erp_assign_warehouse')->where('enquiry_id', $enquiry_id)->first();
            $data['costing_attribute'] = DB::table('costing_attribute')->where('enquiry_id', $enquiry_id)->get();

            $data['warehouse_info'] = [
                'warehouse_name' => $data['warehouse_data']->warehouse_name ?? '',
                'unit_no' => $data['warehouse_data']->unit_no ?? '',
                'emirate_id' => $data['warehouse_data']->emirate_id ?? '',
                'trade_license' => $data['warehouse_data']->trade_license ?? '',
                'from_date' => $data['warehouse_data']->from_date ?? '',
                'to_date' => $data['warehouse_data']->to_date ?? ''
            ];
        }

        $data['customer_data'] = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();

        $data['subservice_data'] = DB::table('subservices')->where('is_active', 0)->where('is_bookable', 1)->where(function ($query) {
            $query->where('serviceid', 44)->orWhere('id', 70);
        })->orderBy('id', 'DESC')->get();

        $data['country_data'] = DB::table('countries')->get();

        $data['enquiry_id'] = $enquiry_id ?? '';


        $data['emiratesList'] = [
            ['name' => 'Dubai',          'id' => 17],
            ['name' => 'Abu Dhabi',      'id' => 20],
            ['name' => 'Sharjah',        'id' => 22],
            ['name' => 'Ajman',          'id' => 23],
            ['name' => 'Umm Al Quwain',  'id' => 24],
            ['name' => 'Ras Al Khaimah', 'id' => 25],
            ['name' => 'Fujairah',       'id' => 26],
        ];



        return view('admin.package-orders.storage.add_order', $data);
    }

    function storage_order_store(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // exit;

        DB::beginTransaction();
        try {

            $intOrderNumber = DB::table('ci_orders')
                ->select(DB::raw('MAX(order_id) as lastOrderNumber'))
                ->first();

            $nextOrderNumber = 0;
            if ($intOrderNumber) {
                $intOrderNumber = $intOrderNumber->lastOrderNumber + 1;
                $intOrderNumber_new = $intOrderNumber;
            } else {
                $intOrderNumber_new = 1;
            }

            if ($request->payment_method == 'ONLINE') {
                $mode = 2;
            } else {
                $mode = 1;
            }



            $subservice_id = $request->subservice_id;
            $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($request->emirates) . '%'])->first();
            $subserviceData = DB::table('subservices')->where('id', $subservice_id)->first();

            if (isset($subserviceData)) {
                if (isset($subserviceData->subservice_code)) {
                    $subserviceCode = $subserviceData->subservice_code;
                } else {
                    $subserviceCode = 'OT';
                }
            } else {
                $subserviceCode = 'OT';
            }

            $cityCode = 'DU';
            if (isset($cityData)) {
                if (isset($cityData->city_code)) {
                    $cityCode = $cityData->city_code;
                } else {
                    $cityCode = 'OT';
                }
            }

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

            if ($request->renew_id > 0) {
                $renewId = $request->renew_id;
            } else {
                $renewId = null;
            }

            $content = array(
                'user_id' => $request->customer_id,
                'order_number' => $intOrderNumber_new,
                'order_total' => $request->order_total,
                'front_wallet_amount' => "0",
                'shippingcost' => "0",
                'vatcharge' => $request->vat_charge,
                'cod_charge' => $request->cod_charge,
                //'space_price' => $request->space_price ?? 0,
                'order_currency' => 'AED',
                'order_status' => 'BK',
                'paymentmode' => $mode,
                'payment_status' => 'Success',
                'created_at' => date('Y-m-d H:i:s'),
                'coupan_to_wallet' => "0",
                'coupondiscount' => "0",
                'moving_date' => $request->moving_date,
                'send_notification' => $request->send_notification,
                'order_from' => 1,
                'subservice_code' => $subserviceCode,
                'city_code' => $cityCode,
                'order_year' => $year,
                'sequence_no' => $nextSequence,
                'format_order_id' => $formatOrderId,
                'sub_total' => $request->sub_total,
                'date_charge' => $request->date_charge ?? 0,
                'timing_charge' => $request->timing_charge ?? 0,
                'service_fee' => $request->service_fee ?? 0,
                'renew_id' => $renewId,
            );

            $arrOrderId = DB::table('ci_orders')->insertGetId($content);



            $service_id = DB::table('subservices')->where('id', $request->subservice_id)->pluck('serviceid')->first();

            $date = Carbon::parse($request->moving_date);
            $booking_date = $date->day;
            $monthName = $date->format('F');
            $yearValue = $date->year;

            $service_name = DB::table('services')->where('id', $service_id)->value('servicename');
            $subservice_name = DB::table('subservices')->where('id', $request->subservice_id)->value('subservicename');

            $items_to_store = isset($request->items_to_store) ? implode(', ', $request->items_to_store) : '';

            $data = [
                'order_id' => $arrOrderId,
                'user_info_id' => $request->customer_id,
                'package_id' => 0,
                'package_item_name' => null,
                'package_quantity' => null,
                'package_item_price' => null,
                'service_id' => $service_id,
                'service_name' => $service_name,
                'subservice_id' => $request->subservice_id,
                'subservice_name' => $subservice_name,
                'packagecategory_id' => 0,
                'packagecategory_name' => '',
                'page_url' => "",
                'cdate' => date('Y-m-d'),
                'bookingdate' => $booking_date,
                'month' => $monthName,
                'bookingyear' => $yearValue,
                'time_slot' => $request->time_slot,
                'any_special_instruction' => null,
                'storage_type' => $request->storage_type,
                'storage_location' => $request->storage_location,
                'storage_from_date' => $request->from_date,
                'storage_to_date' => $request->storage_to_date,
                'items_to_store' => $items_to_store,
                'space_required' => $request->space_required,
                'warehouse_name' => $request->warehouse_name,
                'unit_no' => $request->unit_no,
                'emirate_id' => $request->emirate_id,
                'trade_license' => $request->trade_license,
                'space_price' => $request->space_price,
                'enquiry_id' => $request->enquiry_id,
                'subservice_booking_percentage' => $request->margin_percentage,
            ];

            $order_item_id = DB::table('ci_order_item')->insertGetId($data);



            $enqid = $request->enquiry_id;
            // Handle pre-filled/updated items
            if ($request->has('descriptionu')) {
                foreach ($request->descriptionu as $key => $desc) {
                    if (empty($desc))
                        continue;
                    DB::table('ci_order_quotation_items')->insert([
                        'ci_order_id' => $arrOrderId,
                        'ci_orderitem_id' => $order_item_id ?? null,
                        'enqid' => $enqid,
                        'description' => $desc,
                        'qty' => $request->qtyu[$key] ?? 0,
                        'prov' => $request->provu[$key] ?? 0,
                        'total' => $request->totalu[$key] ?? 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }

            // Handle new items
            if ($request->has('description')) {
                foreach ($request->description as $key => $desc) {
                    if (empty($desc))
                        continue;
                    DB::table('ci_order_quotation_items')->insert([
                        'ci_order_id' => $arrOrderId,
                        'ci_orderitem_id' => $order_item_id ?? null,
                        'enqid' => $enqid,
                        'description' => $desc,
                        'qty' => $request->qty[$key] ?? 0,
                        'prov' => $request->prov[$key] ?? 0,
                        'total' => $request->total[$key] ?? 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }



            if ($request->customer_id != '') {
                $data_new['first_name'] = $request->first_name;
                $data_new['last_name'] = $request->last_name;
                $data_new['country'] = $request->country;
                $data_new['emirate'] = $request->emirates;
                $data_new['area'] = $request->area;
                $data_new['address1'] = $request->street;
                $data_new['state'] = $request->state_name;
                $data_new['city'] = $request->city;
                $data_new['zipcode'] = $request->zipcode;
                $data_new['address2'] = $request->apartment_villa;
                $data_new['phone_number'] = $request->phone;
                $data_new['email_address'] = $request->email;
                $data_new['additional_message'] = $request->additional_message;
                $data_new['payment_method'] = "1";
                $data_new['order_id'] = $arrOrderId;
                $data_new['user_id'] = $request->customer_id;


                DB::table('ci_shipping_address')->insert($data_new);
            }

            // echo "step5";
            // exit;

            if ($request->send_notification == 'yes') {

                if ($request->renew_id > 0) {
                    $this->success_storage_renew_mail($request->customer_id, $arrOrderId);
                } else {
                    $this->success_storage_mail($request->customer_id, $arrOrderId);
                    $this->success_whatsapp_message($request->customer_id, $arrOrderId);
                }
            }
            DB::commit();
            return redirect()->route('storage_package_order')->with('success', 'Storage Order has been added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Storage Order store failed : " . $e);
            return redirect()->back()->with('error', 'Storage Order Store failed')->withInput();
        }
    }
    function storage_package_order_edit($id)
    {
        $order = DB::table('ci_orders')->where('order_id', $id)->first();
        if (!$order) {
            return redirect()->route('storage_package_order')->with('error', 'Order not found');
        }

        $order_items = DB::table('ci_order_item')->where('order_id', $id)->get();
        // Assume first item contains storage details
        $storage_item = $order_items->first();

        $customer_data = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();
        $subservice_data = DB::table('subservices')->whereIn('id', [61, 62, 63, 66, 70])->get();

        $shipping_address = DB::table('ci_shipping_address')->where('order_id', $id)->first();

        // Parse special instructions for warehouse details to find associated Enquiry
        $warehouse_name = $storage_item->warehouse_name ?? '';
        $unit_no = $storage_item->unit_no ?? '';
        $emirate_id = $storage_item->emirate_id ?? '';
        $trade_license = $storage_item->trade_license ?? '';
        $enquiry_id = $storage_item->enquiry_id ?? null;


        $enquiry_data = null;
        $warehouse_data = null;
        $costing_attribute = collect();

        if ($warehouse_name && $unit_no) {


            // Prioritize items from the dedicated order quotation items table
            $costing_attribute = DB::table('ci_order_quotation_items')->where('ci_order_id', $id)->get();
            if ($costing_attribute->isEmpty()) {

                $costing_attribute = DB::table('costing_attribute')->where('enquiry_id', $enquiry_id)->get();
            }
        }

        // Fetch time slots for the subservice
        $subservice_id = $storage_item->subservice_id ?? 0;
        $time_slot = DB::table('subservice_timeslot_price')
            ->join('time_slots', 'subservice_timeslot_price.time_slot_id', '=', 'time_slots.id')
            ->where('subservice_timeslot_price.subservice_id', $subservice_id)
            ->where('subservice_timeslot_price.is_active', '1')
            ->select('time_slots.id', 'time_slots.name')
            ->get();

        return view('admin.package-orders.storage.edit_order', compact(
            'order',
            'order_items',
            'storage_item',
            'customer_data',
            'subservice_data',
            'shipping_address',
            'time_slot',
            'warehouse_name',
            'unit_no',
            'emirate_id',
            'trade_license',
            'enquiry_data',
            'costing_attribute',
            'enquiry_id'
        ));
    }

    function storage_package_order_update(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // exit;

        Log::info('Storage Update Request: ' . json_encode($request->all()));
        try {
            DB::beginTransaction();
            $order_id = $request->order_id;
            $enquiry_id = $request->enquiry_id;

            $items_to_store = isset($request->items_to_store) ? implode(', ', $request->items_to_store) : '';



            $content = array(
                'order_total' => $request->order_total,
                'vatcharge' => $request->vat_charge,
                'cod_charge' => $request->cod_charge,
                'date_charge' => $request->date_charge ?? 0,
                'timing_charge' => $request->timing_charge ?? 0,
                'service_fee' => $request->service_fee ?? 0,
                //'space_price' => $request->space_price ?? 0,
                'moving_date' => $request->moving_date,
                'send_notification' => $request->send_notification,
                'sub_total' => $request->sub_total,
            );

            DB::table('ci_orders')->where('order_id', $order_id)->update($content);

            $updated_item_ids = [];
            if (isset($request->updateid1xxx)) {
                foreach ($request->updateid1xxx as $key => $id) {
                    $desc = $request->descriptionu[$key] ?? '';
                    $qty = $request->qtyu[$key] ?? 0;
                    $prov = $request->provu[$key] ?? 0;
                    $total = $request->totalu[$key] ?? ($qty * $prov);

                    DB::table('ci_order_quotation_items')->where('id', $id)->update([
                        'description' => $desc,
                        'qty' => $qty,
                        'prov' => $prov,
                        'total' => $total,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    $updated_item_ids[] = $id;
                }
            }

            DB::table('ci_order_quotation_items')
                ->where('ci_order_id', $order_id)
                ->whereNotIn('id', $updated_item_ids)
                ->delete();

            if (isset($request->description)) {
                foreach ($request->description as $key => $desc) {
                    if (empty($desc))
                        continue;
                    $qty = $request->qty[$key] ?? 0;
                    $prov = $request->prov[$key] ?? 0;
                    $total = $request->total[$key] ?? ($qty * $prov);

                    DB::table('ci_order_quotation_items')->insert([
                        'ci_order_id' => $order_id,
                        'ci_orderitem_id' => null,
                        'enqid' => $enquiry_id,
                        'description' => $desc,
                        'qty' => $qty,
                        'prov' => $prov,
                        'total' => $total,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }

            $subservice_name = DB::table('subservices')->where('id', $request->subservice_id)->value('subservicename');

            DB::table('ci_order_item')->where('order_id', $order_id)->update([
                'bookingdate' => Carbon::parse($request->moving_date)->day,
                'month' => Carbon::parse($request->moving_date)->format('F'),
                'bookingyear' => Carbon::parse($request->moving_date)->year,
                'time_slot' => $request->time_slot,
                'subservice_id' => $request->subservice_id,
                'subservice_name' => $subservice_name,
                'any_special_instruction' => null,
                'storage_type' => $request->storage_type,
                'storage_location' => $request->storage_location,
                'storage_to_date' => $request->storage_to_date,
                'items_to_store' => $items_to_store,
                'space_required' => $request->space_required,
                'package_item_price' => $request->space_price ?? 0, // Sync space price back to item price
            ]);

            DB::commit();
            return redirect()->route('storage_package_order')->with('success', 'Storage Order has been updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Storage Order update failed : " . $e);
            return redirect()->back()->with('error', 'Storage Order Update failed: ' . $e->getMessage())->withInput();
        }
    }

    public function storage_renew_mail(Request $request)
    {
        try {
            $order_id = $request->order_id;

            // Get order
            $orderdata = DB::table('ci_orders')->where('order_id', $order_id)->first();

            if (!$orderdata) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Order not found'
                ]);
            }

            $user_id = $orderdata->user_id;

            // Call your mail function
            $this->storage_renew_mail_customer($user_id, $order_id);

            return response()->json([
                'status' => 1,
                'message' => 'Mail sent successfully'
            ]);
        } catch (\Exception $e) {
            Log::error("Renew Mail Error: " . $e->getMessage());

            return response()->json([
                'status' => 0,
                'message' => 'Failed to send mail'
            ]);
        }
    }



    function storage_renew_mail_customer($user_id, $order_id)
    {

        $orderdata = DB::table('ci_orders')->where('order_id', $order_id)->first();

        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_id)->get();

        $user_data = DB::table('frontloginregisters')->where('id', $user_id)->first();

        $user_name = $user_data->name;

        if (!$user_data || !$orderdata) {
            Log::error("Outstanding Mail Error - Data not found");
            return false;
        }

        $user_name = $user_data->name;
        $invoice_no = $orderdata->format_order_id ?? '';

        $message_bodyy = '';

        $amount = $orderdata->order_total;

        $order_id = base64_encode($order_id);

        $payment_link = URL::to('/paymentstorageorder') . '/' . $order_id;



        $message_bodyy .= '<!doctype html>
 
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
         .box {
    background:#f8f8f8;
    padding:15px;
    border-radius:8px;
    margin:15px 0;
}
 </style>
        </head>
            <body>
            <div class="wrapper" style="width: 100%;max-width:500px;margin:auto;
                            font-size:14px;line-height:24px;
                            font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
                <div class="logo" style="float: inherit;border-bottom: 4px solid #FFD413;">
                <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;"  >
                </div>

                    <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;" > 
                    <p> Dear ' . $user_name . ',</p>
                    <p>Greetings from VendorsCity Portal LLC.</p>

                    <p>We would like to inform you regarding your outstanding balance of AED ' . $amount . '.</p>';



        $message_bodyy .= ' <div class="box">
            <strong>Order No:</strong> ' . $invoice_no . '<br>
            <strong>From Date:</strong> ' . $order_item_data[0]->storage_from_date . '<br>
            <strong>To Date:</strong> ' .  $order_item_data[0]->storage_to_date . '<br>
           
        </div>';

        $message_bodyy .= '<p>Please proceed with the payment using the link below:</p>';

        if ($payment_link != '') {
            $message_bodyy .= '<a href="' . $payment_link . '" class="btnlink">Pay Now</a>';
        }

        $message_bodyy .= '

        <p><strong>Alternatively, you may choose:</strong></p>

        <ul>
            <li>Cash or cheque collection (share location & time)</li>
            <li>Bank transfer or deposit</li>
        </ul>

        <div class="box">
            <h3>Bank Details</h3>
            A/C Name: VendorsCity Portal LLC<br>
            A/C No.: 13450800920001<br>
            Bank: Abu Dhabi Commercial Bank<br>
            IBAN: AE060030013450800920001<br>
            Swift Code: ADCBAEAAXXX<br>
            Bank Address: 251 / Al Rigga Road
        </div>

        <p>If you have already completed the payment, please ignore this message or reply with confirmation.</p>

        <h3>Important Notes:</h3>
        <ul>
            <li>Warehouse Timings: 08:00 AM – 05:00 PM (Mon–Sat)</li>
            <li>Extra charges for Sundays / holidays</li>
            <li>Storage rent must be paid monthly in advance</li>
            <li>Late fee AED 250 after 7 days</li>
            <li>15-day notice required for termination</li>
            <li>Non-payment > 3 months → items may be disposed</li>
        </ul>';




        $message_bodyy .= '<p>Your service provider will contact you soon to confirm the details and make any necessary arrangements. If you do not hear from them within 2 business days, please email us at <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a> or call us at 056 VENDORS (836 3677).</p>

                     <p>If you have any questions or need to make changes to your booking, please do not hesitate to   <a href="' . url("/contact") . '">Contact Us</a>.
                     </p>
                     <p>Thank you for choosing VendorsCity. We look forward to providing you with exceptional service.</p>
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
                                <div class="footer_right" style="margin-left:10px;
                                float: left;">
                                    <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                                    <p  style="margin:0;">VendorsCity Portal LLC</p>
                                    <div class="footer_links" style=" margin:10px 0;">
                                <a href="' . url("/terms-of-service") . '"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                <a href="' . url("/privacy-policy") . '"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                <a href="' . url("/contact") . '"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                                </div>
                                   
                                </div>
                            </div>
                      </div>
                </div>
            </body>
 </html>';

        $subject = "Outstanding Payment Reminder " . $orderdata->format_order_id . "";

        $to = $user_data->email;
        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        // $ccRecipients = [];

        Mail::send([], [], function ($message) use ($message_bodyy, $to, $subject, $ccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            $message->html($message_bodyy);
        });

        return true;
    }

    public function addCommission(Request $request)
    {
        DB::table('ci_order_item')
            ->where('order_id', $request->order_id)
            ->update([

                'subservice_booking_percentage' => $request->percentage,

                'subservice_booking_amount' => $request->amount,
            ]);

        return response()->json([

            'status' => 1,

            'message' => 'Commission Saved Successfully'
        ]);
    }
}
