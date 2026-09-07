<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SalesReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($order_id = '', $status = '')
    {
        $data['error'] = '';

        //$data['subscribe_data'] = Subscribe::orderBy('id','DESC')->get();    

        $data['error'] = '';

        //$data['subscribe_data'] = Subscribe::orderBy('id','DESC')->get();    

    $query = DB::table('ci_orders')->where('ci_orders.is_delete','0')
        ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
        //->leftJoin('ci_shipping_address', 'ci_orders.order_id', '=', 'ci_shipping_address.order_id')
        ->select('frontloginregisters.email as user_email', 'frontloginregisters.name as user_name', 'frontloginregisters.mobile as user_mobile',  'ci_orders.*');

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

    $orderList = $query->where('payment_status',"Success")->get();

    foreach ($orderList as $order) {
        $itemList = DB::table('ci_order_item')
            ->where('order_id', $order->order_id)
            ->get();

        $total = 0;
        $additionalCost = 0;

        foreach ($itemList as $item) {
            $product = DB::table('packages')
                ->where('id', $item->package_id)
                ->first();

            if($item->product_discount_amount != 0 && $item->product_discount_amount != ''){
                $product_item_price = $item->product_discount_amount;
            }else{
                $product_item_price = $item->package_item_price;
            }

            $total += $product_item_price * $item->package_quantity;
        }

        $order->items = $itemList;
        $order->sub_total = $total;
    }

    $orderList;  

    $data['orders_list'] = $orderList;
    
        // echo"<pre>";
        // print_r($data);
        // echo"</pre>";exit;
        return view('admin.list_salesreport',$data);
    }
    function detail($order_id){
        //echo $id;exit;
        $data['error'] = '';

        $query = DB::table('ci_orders')->where('ci_orders.is_delete','0')
        ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
       ->leftJoin('ci_shipping_address', 'ci_orders.order_id', '=', 'ci_shipping_address.order_id')
        ->select('frontloginregisters.email as user_email', 'frontloginregisters.name as user_name', 'frontloginregisters.mobile as user_mobile',  'ci_orders.*',  'ci_shipping_address.*');

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
            ->where('order_id', $order->order_id)
            ->get();

        $total = 0;
        $additionalCost = 0;

        foreach ($itemList as $item) {
            $product = DB::table('packages')
                ->where('id', $item->package_id)
                ->first();

            if($item->product_discount_amount != 0 && $item->product_discount_amount != ''){
                $product_item_price = $item->product_discount_amount;
            }else{
                $product_item_price = $item->package_item_price;
            }

            $total += $product_item_price * $item->package_quantity;
        }

        $order->items = $itemList;
        $order->sub_total = $total;
    }

    $orderList;  

    $data['order'] = $orderList[0];

//     $sql = $query->toSql();
// echo $sql;

    //echo "<pre>";print_r($query);echo"</pre>";
       //echo "<pre>";print_r($data);echo"</pre>";exit;  

        return view('admin.view_salesreport_deial',$data);
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