<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Email;
use App\Models\front\Frontloginregister;
use DB;
use Session;
use Cart;
use App\Models\Admin\Form_filed;
use App\Models\Admin\VerifyBuyPackage;
use App\Models\Admin\VerifyBuyPackageAttr;
use App\Models\Admin\Vehicles;
use App\Models\Admin\ModelModule;
use App\Models\Admin\Service;
use App\Models\Admin\Subservice;
use Illuminate\Support\Facades\Crypt;
use DateTime;
use Carbon\Carbon;
use App\Models\Admin\City;
use Str;


class Automobilecontroller extends Controller
{

    function __construct(Type $var = null)
    {
        $search_city_id = session('search_city_id');

        if (!empty($search_city_id)) {
            Session::put('search_city_id', $search_city_id);
        } else {
            Session::put('search_city_id', 17);
        }

        $CityName = City::where('id', session('search_city_id'))->first();

        if ($CityName) {
            $slug = Str::slug($CityName->name);
            Session::put('search_city_name', $slug);
        } else {
            Session::put('search_city_name', 'dubai');
        }
    }


    public function listing(Request $request, $page_url = '')
    {
        $data['subservices_data'] = $subservices_data = DB::table('subservices')->where('page_url', $page_url)->first();

        $data['meta_title'] =  $subservices_data->meta_title;
        $data['meta_keyword'] = $subservices_data->meta_keyword;
        $data['meta_description'] = $subservices_data->meta_description;


        return view('front.automobile.automobile_lists', $data);
    }

    public function book_inspection(Request $request, $id)
    {
        // Handle the booking inspection logic here
        $data['vehicles'] = Vehicles::where('show_inform', 0)->orderBy('id', 'DESC')->get();
        $data['other_vehicles'] = Vehicles::where('show_inform', 1)->orderBy('id', 'DESC')->get();
        $data['package'] = VerifyBuyPackage::where('id', $id)->first();
        $page_url = request()->segment('1');
        $data['service_id'] = Service::where('page_url', $page_url)->value('id');
        $data['subservice_id'] = Subservice::where('serviceid', $data['service_id'])->value('id');

        $data['subservice_timeslot_price'] = DB::table('time_slots')
            ->leftjoin('subservice_timeslot_price', 'time_slots.id', '=', 'subservice_timeslot_price.time_slot_id')
            ->where('subservice_timeslot_price.service_id', $data['service_id'])
            ->where('subservice_timeslot_price.subservice_id', $data['subservice_id'])
            ->where('subservice_timeslot_price.is_active', 1)
            ->select('time_slots.*', 'subservice_timeslot_price.*')
            ->get();



        //      echo"<pre>";
        // print_r($data['subservice_timeslot_price']);
        // echo"</pre>";exit;

        $data['redirectUrl'] = route('automobile.bookinspection', ['id' => $id]);
        $data['meta_title'] =  "";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "";


        return view('front.automobile.book_inspection', $data);
    }
    public function change_model(Request $request)
    {

        $val = $request->value;
        $vehicles = Vehicles::where('id', $val)->first();
        //  echo"<pre>";
        // print_r($vehicles);
        // echo"</pre>";exit;
        $models = ModelModule::where('vehicle_name', $vehicles->id)->get();


        $html = '<select name="other_vehicle_model" id="other_vehicle_model" class="form-select" onchange="showCategory(this.value);">';
        $html .= '<option value="">Select Vehicle Model</option>';
        foreach ($models as $row) {
            $html .= '<option value="' . $row->model_name . '">' . $row->model_name . '</option>';
        }
        $html .= '</select>';
        return response()->json(['html' => $html]);
    }
    public function show_category(Request $request)
    {
        $val = $request->value;
        $models = ModelModule::where('model_name', $val)->first();

        return response()->json(['category' => $models->category, 'price' => $models->price]);
        //   echo"<pre>";
        // print_r($models);
        // echo"</pre>";exit;



    }
    public function book_inspection_form(Request $request)
    {
        //   echo"<pre>";
        // print_r($request->all());
        // echo"</pre>";exit;

        $userdata = Session::get('user');

        $id = $request->payment_hidden;

        //echo $id;exit;

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

        $intOrderNumber = DB::table('ci_orders')
            ->select(DB::raw('MAX(order_id) as lastOrderNumber'))
            ->first();
        if ($intOrderNumber) {
            $intOrderNumber = $intOrderNumber->lastOrderNumber + 1;

            $intOrderNumber_new = $intOrderNumber;
            $nextOrderNumber;
        } else {
            $intOrderNumber_new = 1;
        }

        Session::put('order_number', $intOrderNumber_new);
        $order_number = Session::get('order_number');

        $userid = $userdata['userid'];

        $order_total_new = $request->total_amount;

        $front_wallet_amount_new = 0;

        $order_from = 3;

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
            //'ip_address'            => $_SERVER['REMOTE_ADDR'],
            'list_order_status'     => $list_order_status,
            'order_from'     => $order_from,
        );

        $arrOrderId = DB::table('ci_orders')->insertGetId($content);

        $year = date('y');
        $data_u['format_order_id'] = "VC-" . $year . "-UAE-" . sprintf("%06d", $arrOrderId);
        DB::table('ci_orders')->where('order_id', $arrOrderId)->update($data_u);

        Session::put('format_order_id', $data_u['format_order_id']);

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

            return redirect()->route('automobile.thank-you')->with('success', 'Your booking has been successfully placed. Thank you!');

            // if ($success) {
            //     return redirect('thankyou-book-now');
            // } 
        } else {

            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));

            $response = $stripe->checkout->sessions->create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'aed',
                            'product_data' => [
                                'name' => 'Your Total'
                            ],
                            'unit_amount' => $order_total_new * 100,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('payment_success_automobile'),
                'cancel_url' => route('payment_fail_automobile'),
            ]);

            if (isset($response->id) && $response->id != '') {

                Session::put('stripe_session_id', $response->id);


                return redirect($response->url);
            } else {
                return redirect()->route('payment_fail_automobile');
            }
        }
    }

    public function payment_success(Request $request)
    {

        $stripe_session_id = Session::get('stripe_session_id');

        $order_number = Session::get('order_number');

        if (isset($stripe_session_id)) {

            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));

            $response = $stripe->checkout->sessions->retrieve($stripe_session_id);

            if ($response->status == 'complete') {

                $data_u['payment_id'] = $response->id;
                $data_u['currency'] = $response->currency;
                $data_u['payment_status'] = "Success";

                $orderdata = DB::table('ci_orders')->where('order_number', $order_number)->update($data_u);

                // $success = $this->success_mail();
                // if ($success) {
                // Redirect to the 'thankyou' route
                return redirect()->route('automobile.thank-you')->with('success', 'Your booking has been successfully placed. Thank you!');
                //} 
            }
        } else {
            return redirect()->route('payment_fail_automobile');
        }
    }

    function payment_fail(Request $request)
    {


        \Cart::destroy();
        session()->forget('coupan_data');
        session()->forget('shippingcahrge');
        session()->forget('discount_amount');
        session()->forget('order_total');
        session()->forget('stripe_session_id');
        session()->forget('walletdiscount');
        session()->forget('user_wallet_amount');

        //echo "here";exit;
        $data['meta_title'] = "";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "";

        $data['message'] =  "Payment Fail";

        return view('front.payment_fail', $data);
    }

    public function success_mail()
    {

        $userdata = Session::get('user');
        $order_number = Session::get('order_number');
        $format_order_id = Session::get('format_order_id');

        $orderdata = DB::table('ci_orders')->where('order_id', $order_number)->first();
    }

    public function thankyou()
    {
        $order_number = Session::get('order_number');

        $data['order_data'] = DB::table('ci_order_item')->where('order_id', $order_number)->first();
        $data['orders'] = DB::table('ci_orders')->where('order_id', $order_number)->first();
        // echo"<pre>";print_r($order_number);echo"</pre>";exit;
        $data['message'] = "Thank you for booking with us. Your booking has been successfully placed.";
        return view('front.automobile.thank_you', $data);
    }

    public function packages(Request $request)
    {
        $data['subservices_data'] = array();
        $data['packages'] = VerifyBuyPackage::where('is_active', 0)->orderBy('id', 'DESC')->get();
        $data['meta_title'] =  '';
        $data['meta_keyword'] = '';
        $data['meta_description'] = '';


        return view('front.automobile.packages', $data);
    }
}
