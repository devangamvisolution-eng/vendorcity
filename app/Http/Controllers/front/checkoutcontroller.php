<?php

namespace App\Http\Controllers\front;

use App\Helpers\Helper as HelpersHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use DB;
use Helper;
use Session;
use Mail;
use Cart;
//use Illuminate\Contracts\Session\Session as SessionSession;
use Stripe\Stripe;
use Stripe\Charge;
use Carbon\Carbon;
use DateTime;


class checkoutcontroller extends Controller
{
    //

    public function __construct()
    {
        // Disable ModSecurity for this script
        putenv('MODSEC_ENABLE=Off');
    }


    public function checkout()
    {
        $data['meta_title'] = "";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "";
        $data['country'] = DB::table('countries')->orderBy('id', 'DESC')->get();
        return view('front.checkout', $data);
    }

    function order_place(Request $request)
    {

        // echo "<pre>";print_r($request->all());exit;
        $userdata = Session::get('user');

        $cart = \Cart::content();

        $service_ids = \Cart::content()->pluck('options.service_id');
        $subservice_ids = \Cart::content()->pluck('options.subservice_id');

        // echo "<pre>";print_r($subservice_ids[0]);
        // echo "<pre>";print_r($cart);exit;

        $date = Carbon::parse($request->moving_date);
        $booking_date = $date->day;
        $monthName = $date->format('F');
        $year = $date->year;

        $id = $_POST['payment_method'];

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

        $wallet_plus_amount = DB::table('front_user_wallet')
            ->where('refer_id', $userdata['userid'])
            ->where('added_from', 0)
            ->sum('wallet_amount');

        $wallet_minus_amount = DB::table('front_user_wallet')
            ->where('refer_id', $userdata['userid'])
            ->where('added_from', 1)
            ->sum('wallet_amount');

        $front_wallet_amount = $wallet_plus_amount - $wallet_minus_amount;

        $order_total =  session('order_total');

        if ($request->apply_button == 1) {

            if ($front_wallet_amount > $order_total) {

                $order_total_new = 0;
                $front_wallet_amount_new = $order_total;
            } else {
                $order_total_new = $order_total - $front_wallet_amount;
                $front_wallet_amount_new = $front_wallet_amount;
            }
        } elseif ($request->cancel_button == 0) {
            $order_total_new = $order_total;
            $front_wallet_amount_new = 0;
        } else {
            $order_total_new = $order_total;
            $front_wallet_amount_new = 0;
        }
        foreach ($cart as $items) {

            $subtotal = $items->price * $items->qty;
        }

        // echo "<pre>";print_r($subtotal);exit;

        $coupon_discounted = 0;
        $coupan_code_name = "";
        $coupan_to_wallet = "";

        if (Session::has('coupan_data')) {

            $coupon_discounted = 0;
            $coupan_code_name = session('coupan_data.coupancode');

            if (session('coupan_data.coupan_apply_wallet') == 0) {

                if (session('coupan_data.discount') != '' && session('coupan_data.coupanvalue') == 0) {
                    $coupon_discounted = round(($request->sub_total * session('coupan_data.discount')) / 100);
                }
                if (session('coupan_data.discount') != '' && session('coupan_data.coupanvalue') == 1) {
                    $coupon_discounted = session('coupan_data.discount');
                }

                $wallet_content = [
                    'userid'              => $userid,
                    'refer_id'             => $userid,
                    'order_currency'       => 'AED',
                    'order_total'          => $order_total_new,
                    'system_percentage'    => '',
                    'wallet_amount'        => $coupon_discounted,
                    'added_from'           => 0,
                    'order_id'             => $order_number,
                    'added_date'           => date('Y-m-d'),
                ];
                DB::table('front_user_wallet')->insertGetId($wallet_content);

                $coupan_to_wallet = '1';
            } else {
                if (session('coupan_data.discount') != '' && session('coupan_data.coupanvalue') == 0) {
                    $coupon_discounted = round((session('coupan_data.sub_total') * session('coupan_data.discount')) / 100);
                }
                if (session('coupan_data.discount') != '' && session('coupan_data.coupanvalue') == 1) {
                    $coupon_discounted = session('coupan_data.discount');
                }
                $coupan_to_wallet = '0';
            }
        }

        $subservice_id = $subservice_ids[0];
        //$subservice_id = $request->subservice_id;
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
            'user_id'               => $userid,
            'order_number'          => $order_number,
            'order_total'           => $order_total_new,
            'front_wallet_amount'   => $front_wallet_amount_new,
            'shippingcost'          => session('shippingcahrge'),
            'vatcharge'             => session('vatcharge'),
            'order_currency'        => 'AED',
            'order_status'          => $order_status,
            'paymentmode'           => $paymentmode,
            'payment_status'        => $payment_status,
            'created_at'            => date('Y-m-d H:i:s'),
            'coupan_to_wallet'      => $coupan_to_wallet,
            'coupondiscount'        => $coupon_discounted,
            'coupon_code'           => $coupan_code_name,
            'moving_date'           => $request->moving_date,
            //'ip_address'            => $_SERVER['REMOTE_ADDR'],
            'list_order_status'     => $list_order_status,
            'sub_total'             => $subtotal,
            'format_order_id'       => $formatOrderId,
            'subservice_code'       => $subserviceCode,
            'city_code'             => $cityCode,
            'order_year'            => $year,
            'sequence_no'           => $nextSequence,
        );

        $arrOrderId = DB::table('ci_orders')->insertGetId($content);
        // $year = date('y');
        // $data_u['format_order_id'] = "VC-" . $year . "-UAE-" . sprintf("%06d", $arrOrderId);
        // DB::table('ci_orders')->where('order_id', $arrOrderId)->update($data_u);

        Session::put('format_order_id', $formatOrderId);

        if ($arrOrderId) {
            $arrOrderId;
        }

        $date = Carbon::parse($request->moving_date);
        $booking_date = $date->day;
        $monthName = $date->format('F');
        $year = $date->year;

        foreach (\Cart::content() as $arrRowDeailts) {

            $arrData = array(
                'order_id'                        => $arrOrderId,
                'user_info_id'                    => $userid,
                'package_id'                      => $arrRowDeailts->id,
                'package_item_name'               => $arrRowDeailts->name,
                'package_quantity'                => $arrRowDeailts->qty,
                'package_item_price'              => $arrRowDeailts->price,
                'service_id'                      => $arrRowDeailts->options->service_id,
                'service_name'                    => $arrRowDeailts->options->service_name,
                'subservice_id'                   => $arrRowDeailts->options->subservice_id,
                'subservice_name'                 => $arrRowDeailts->options->subservice_name,
                'packagecategory_id'              => $arrRowDeailts->options->packagecategory_id,
                'packagecategory_name'            => $arrRowDeailts->options->packagecategory_name,
                'page_url'                        => $arrRowDeailts->options->page_url,
                'image'                           => $arrRowDeailts->options->image,
                'discount'                        => $arrRowDeailts->options->discount,
                'discount_type'                   => $arrRowDeailts->options->discount_type,
                'product_discount_amount'         => round($arrRowDeailts->options->product_discount_amount),
                'cdate'                           => date('Y-m-d'),
                'subservice_booking_percentage'   => $arrRowDeailts->options->subservice_booking_percentage,
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

            );


            DB::table('ci_order_item')->insertGetId($arrData);
        }

        if ($request->fname != '') {
            $data['first_name'] = $request->fname;
            $data['last_name'] = $request->lname;
            $data['country'] = $request->country;
            $data['emirate'] = $request->emirate;
            $data['area'] = $request->area;
            $data['address1'] = $request->address1;
            $data['state'] = $request->state_name;
            $data['city'] = $request->city;
            $data['zipcode'] = $request->zipcode;
            $data['address2'] = $request->optional;
            $data['phone_number'] = $request->phone;
            $data['email_address'] = $request->email_ship;
            $data['additional_message'] = $request->additional_message;
            $data['payment_method'] = $request->payment_method;
            $data['order_id'] = $arrOrderId;
            $data['user_id'] = $userid;

            DB::table('ci_shipping_address')->insert($data);
        }

        if ($request->apply_button == 1) {
            $walletdiscount = Session::get('walletdiscount') ?? "";
            $userWalletamount = Session::get('user_wallet_amount') ?? "";
            if ($walletdiscount != "" && $userWalletamount != "") {

                if ($userWalletamount > $walletdiscount) {

                    // $Pending_data = $userWalletamount - $walletdiscount;

                    $walletData = array(
                        'userid'          => 0,
                        'refer_id'        => $userid,
                        'order_currency'  => 'AED',
                        'order_total'     => session('order_total'),
                        'wallet_amount'   => $walletdiscount,
                        'added_from'      => 1,
                        'order_id'        => $arrOrderId,
                        'added_date'      => date('Y-m-d'),
                    );

                    DB::table('front_user_wallet')->insertGetId($walletData);
                } else {

                    $walletData = array(
                        'userid'          => 0,
                        'refer_id'        => $userid,
                        'order_currency'  => 'AED',
                        'order_total'     => session('order_total'),
                        'wallet_amount'   => $userWalletamount,
                        'added_from'      => 1,
                        'order_id'        => $arrOrderId,
                        'added_date'      => date('Y-m-d'),
                    );

                    DB::table('front_user_wallet')->insertGetId($walletData);
                }
            }
        }

        if ($id == 1) {
            $success = $this->success_mail();
            if ($success) {
                // Redirect to the 'thankyou' route
                return redirect('thankyou');
            }
        } else {

            // Set your secret key. Remember to switch to your live secret key in production.
            // See your keys here: https://dashboard.stripe.com/apikeys
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
                'success_url' => route('payment_success'),
                'cancel_url' => route('payment_fail'),
            ]);

            if (isset($response->id) && $response->id != '') {

                Session::put('stripe_session_id', $response->id);


                return redirect($response->url);
            } else {
                return redirect()->route('payment_fail');
            }
        }
    }

    function book_now_order(Request $request)
    {

        // echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $userdata = Session::get('user');

        $isPaintingBookOrEnquiry = $request->is_book_or_quote ?? "";
        $type_of_paintingInset = $request->type_of_painting ?? "";
        $cleaingService = $request->how_many_cleaners_do_you_need ?? "";
        $WoodenFloorService = $request->property_type ?? "";

        if (
            $isPaintingBookOrEnquiry != "get-quote" && $type_of_paintingInset == "Move in / Move Out Painting"
            || $cleaingService != "" ||
            $request->subservice_id == 70 || $request->subservice_id == 29 ||
            $request->subservice_id == 71 || $request->subservice_id == 72 ||
            $request->subservice_id == 73 || $request->subservice_id == 79 ||
            $request->subservice_id == 80 || $request->subservice_id == 81 ||
            $request->subservice_id == 82 || $request->subservice_id == 83 ||
            $request->subservice_id == 84 || $request->subservice_id == 85 ||
            $request->subservice_id == 86 || $request->subservice_id == 87 ||
            $request->subservice_id == 88 ||
            $request->subservice_id == 93
        ) {



            $payment_type = $request->payment_type;
            if ($payment_type == 'COD') {
                $order_status = 'BK';
                $paymentmode = 1;
                $list_order_status = '0';
                $payment_status = 'Success';
                $payment_mode = "COD";
            } elseif ($payment_type == 'TABBY') {
                $order_status = 'BK';
                $paymentmode = 3;
                $list_order_status = '0';
                $payment_status = 'FAILED';
                $payment_mode = "TABBY";
            } else {
                $order_status = 'BK';
                $paymentmode = 2;
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
            //echo "<pre>";print_r($userid);echo"</pre>";exit;



            $isPaintingData = $request->type_of_painting ?? "";

            if ($isPaintingData == "" && empty($isPaintingData)) {

                $order_from = 1; // booking form data

                $wallet_plus_amount = DB::table('front_user_wallet')
                    ->where('refer_id', $userdata['userid'])
                    ->where('added_from', 0)
                    ->sum('wallet_amount');

                $wallet_minus_amount = DB::table('front_user_wallet')
                    ->where('refer_id', $userdata['userid'])
                    ->where('added_from', 1)
                    ->sum('wallet_amount');

                $front_wallet_amount = $wallet_plus_amount - $wallet_minus_amount;

                $order_total = $request->total_to_pay;

                if ($request->apply_button == 1) {

                    if ($front_wallet_amount > $order_total) {

                        $order_total_new = 0;
                        $front_wallet_amount_new = $order_total;
                    } else {
                        $order_total_new = $order_total - $front_wallet_amount;
                        $front_wallet_amount_new = $front_wallet_amount;
                    }
                } elseif ($request->cancel_button == 0) {
                    $order_total_new = $order_total;
                    $front_wallet_amount_new = 0;
                } else {
                    $order_total_new = $order_total;
                    $front_wallet_amount_new = 0;
                }

                $coupon_discounted = 0;
                $coupan_code_name = "";
                $coupan_to_wallet = "";

                // dd(Session::get('coupan_data'));

                if (Session::has('coupan_data')) {

                    $coupon_discounted = 0;
                    $coupan_code_name = session('coupan_data.coupancode');


                    if (session('coupan_data.coupan_apply_wallet') == 0) {

                        if (session('coupan_data.discount') != '' && session('coupan_data.coupanvalue') == 0) {
                            $coupon_discounted = round(($request->sub_total * session('coupan_data.discount')) / 100);
                        }
                        if (session('coupan_data.discount') != '' && session('coupan_data.coupanvalue') == 1) {
                            $coupon_discounted = session('coupan_data.discount');
                        }

                        $wallet_content = [
                            'userid'              => $userid,
                            'refer_id'             => $userid,
                            'order_currency'       => 'AED',
                            'order_total'          => $order_total_new,
                            'system_percentage'    => '',
                            'wallet_amount'        => $coupon_discounted,
                            'added_from'           => 0,
                            'order_id'             => $order_number,
                            'added_date'           => date('Y-m-d'),
                        ];
                        DB::table('front_user_wallet')->insertGetId($wallet_content);

                        $coupan_to_wallet = '1';
                    } else {
                        if (session('coupan_data.discount') != '' && session('coupan_data.coupanvalue') == 0) {
                            $coupon_discounted = round(($request->sub_total * session('coupan_data.discount')) / 100);
                        }
                        if (session('coupan_data.discount') != '' && session('coupan_data.coupanvalue') == 1) {
                            $coupon_discounted = session('coupan_data.discount');
                        }
                        $coupan_to_wallet = '0';
                    }
                }

                $vat_total = $request->vat_total;

                $timing_charger = $request->timing_charge + $request->weekly_off_charge;

                $content = array(
                    'user_id'               => $userid,
                    'order_number'          => $order_number,
                    'order_total'           => $order_total_new,
                    'front_wallet_amount'   => $front_wallet_amount_new,
                    'vatcharge'             => $vat_total,
                    'order_currency'        => 'AED',
                    'order_status'          => $order_status,
                    'paymentmode'           => $paymentmode,
                    'payment_status'        => $payment_status,
                    'created_at'            => date('Y-m-d H:i:s'),
                    'coupan_to_wallet'     => $coupan_to_wallet,
                    'coupondiscount'     => $coupon_discounted,
                    'coupon_code'     => $coupan_code_name,
                    'list_order_status'     => $list_order_status,
                    'service_charge'     => $request->service_charge,
                    'promo_discount'     => $request->promo_discount,
                    'cleaning_discount_additional'     => $request->cleaning_discount_additional,
                    'timing_charge'     => $timing_charger,
                    'additional_charge'     => $request->additional_charge,
                    'sub_total'     => $request->sub_total,
                    'cod_charge'     => $request->cod_charge,
                    'service_fee'     => $request->service_fee,
                    'order_from'     => $order_from,
                );
            }

            if ($isPaintingData != "" && !empty($isPaintingData)) {

                // echo"painting_here";exit;

                $wallet_plus_amount = DB::table('front_user_wallet')
                    ->where('refer_id', $userdata['userid'])
                    ->where('added_from', 0)
                    ->sum('wallet_amount');

                $wallet_minus_amount = DB::table('front_user_wallet')
                    ->where('refer_id', $userdata['userid'])
                    ->where('added_from', 1)
                    ->sum('wallet_amount');

                $front_wallet_amount = $wallet_plus_amount - $wallet_minus_amount;

                $order_total = $request->total_to_pay_charge_price;

                if ($request->apply_button == 1) {
                    //  echo"in";exit;
                    if ($front_wallet_amount > $order_total) {

                        $order_total_new = 0;
                        $front_wallet_amount_new = $order_total;
                    } else {
                        $order_total_new = $order_total - $front_wallet_amount;
                        $front_wallet_amount_new = $front_wallet_amount;
                    }
                } elseif ($request->cancel_button == 0) {
                    $order_total_new = $order_total;
                    $front_wallet_amount_new = 0;
                } else {
                    $order_total_new = $order_total;
                    $front_wallet_amount_new = 0;
                }



                $vat_total = $request->hidden_vat_charge_price;
                $order_from = 2; // booking form data

                $content = array(
                    'user_id'               => $userid,
                    'order_number'          => $order_number,
                    'front_wallet_amount'   => $front_wallet_amount_new,
                    'order_total'           => $order_total_new,
                    'vatcharge'             => $vat_total,
                    'order_currency'        => 'AED',
                    'order_status'          => $order_status,
                    'paymentmode'           => $paymentmode,
                    'payment_status'        => $payment_status,
                    'created_at'            => date('Y-m-d H:i:s'),
                    //'ip_address'            => $_SERVER['REMOTE_ADDR'],
                    'list_order_status'     => $list_order_status,
                    'service_charge'     => $request->size_of_home_price,
                    'promo_discount'     => $request->hidden_discount_price,
                    'cleaning_discount_additional'     => '',
                    'timing_charge'     => $request->timing_charge,
                    'additional_charge'     => $request->additional_charge_price,
                    'sub_total'     => $request->hidden_subtotal_price,
                    'cod_charge'     => $request->cod_charge_new ?: "",
                    'service_fee'     => $request->service_fee,
                    'order_from'     => $order_from,
                );
            }

            // echo "<pre>";print_r($content);echo"</pre>";exit;
            $arrOrderId = DB::table('ci_orders')->insertGetId($content);

            if ($request->subservice_id == 47) {

                $cityName = $request->city ?? '';

                $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($cityName) . '%'])->first();
                $subserviceData = DB::table('subservices')->where('id', $request->subservice_id)->first();

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

                $data_u['subservice_code'] = $subserviceCode;
                $data_u['city_code'] = $cityCode;
                $data_u['order_year'] = $year;
                $data_u['sequence_no'] = $nextSequence;
                $data_u['format_order_id'] = $formatOrderId;
            }

            DB::table('ci_orders')->where('order_id', $arrOrderId)->update($data_u);
            Session::put('format_order_id', $formatOrderId);

            // $year = date('y');
            // $data_u['format_order_id'] = "VC-" . $year ."-UAE-". sprintf("%06d", $arrOrderId);
            // DB::table('ci_orders')->where('order_id', $arrOrderId)->update($data_u);
            // Session::put('format_order_id', $data_u['format_order_id']);

            if ($arrOrderId) {
                $arrOrderId;
            }

            if ($request->which_day_of_the_week_do_you_want_the_service != '') {
                $which_day_of_the_week_do_you_want_the_service = implode(',', $request->which_day_of_the_week_do_you_want_the_service);
            } else {
                $which_day_of_the_week_do_you_want_the_service = "";
            }

            if ($isPaintingData == "" && empty($isPaintingData)) {

                $monthName = $request->month;
                $dateObj = DateTime::createFromFormat('F', ucfirst(strtolower($monthName)));
                $monthNumber = $dateObj ? $dateObj->format('m') : null;

                $formatted_date = sprintf('%04d-%02d-%02d', date('Y'), $monthNumber, $request->date);

                if ($request->how_often_do_you_need_cleaning == 'Once') {
                    $formatted_date = sprintf('%04d-%02d-%02d', date('Y'), $monthNumber, $request->date);
                    $end_date = $formatted_date;
                    $which_day_of_the_week_do_you_want_the_service = date('l', strtotime($formatted_date));
                } elseif ($request->how_often_do_you_need_cleaning == 'Weekly') {
                    $formatted_date = sprintf('%04d-%02d-%02d', date('Y'), $monthNumber, $request->date);
                    $end_date = date('Y-m-d', strtotime($formatted_date . ' +1 year'));
                    $which_day_of_the_week_do_you_want_the_service = date('l', strtotime($formatted_date));
                } elseif ($request->how_often_do_you_need_cleaning == 'Multiple times a week') {
                    $formatted_date = sprintf('%04d-%02d-%02d', date('Y'), $monthNumber, $request->date);
                    $end_date = date('Y-m-d', strtotime($formatted_date . ' +1 year'));
                } else {
                    $end_date = $formatted_date;
                }

                $arrData = array(
                    'order_id'                             => $arrOrderId,
                    'user_info_id'                         => $userid,
                    'cleaner_id'                           => $request->cleaner_id,
                    'service_id'                           => $request->service_id,
                    'subservice_id'                        => $request->subservice_id,
                    'how_many_cleaners_do_you_need'        => $request->how_many_cleaners_do_you_need,
                    'how_many_hours_should_they_stay'      => $request->how_many_hours_should_they_stay,
                    'how_often_do_you_need_cleaning'       => $request->how_often_do_you_need_cleaning,
                    'do_you_need_cleaning_material'        => $request->do_you_need_cleaning_material,
                    'any_special_instruction'              => $request->any_special_instruction,
                    'address_type'                         => $request->address_type,
                    'city'                                 => $request->city,
                    'area'                                 => $request->area,
                    'building_street_no'                   => $request->building_street_no,
                    'apartment_villa_no'                   => $request->apartment_villa_no,
                    'bookingdate'                          => $request->date,
                    'bookingyear'                          => date('Y'),
                    'month'                                => $request->month,
                    'time_slot'                            => $request->time_slot,
                    'end_date'                            => $end_date,
                    'which_day_of_the_week_do_you_want_the_service' => $which_day_of_the_week_do_you_want_the_service,
                    'cdate'                                => date('Y-m-d'),
                );
            }

            if ($isPaintingData !== "" && !empty($isPaintingData)) {

                if ($request->selected_home_furnished_price != 0) {
                    $isYourHomeFurnished = "Yes";
                } else {
                    $isYourHomeFurnished = "No";
                }

                $monthName = $request->month;
                $dateObj = DateTime::createFromFormat('F', ucfirst(strtolower($monthName)));
                $monthNumber = $dateObj ? $dateObj->format('m') : null;

                $formatted_date = sprintf('%04d-%02d-%02d', date('Y'), $monthNumber, $request->date);
                $arrData = array(
                    'order_id'                             => $arrOrderId,
                    'user_info_id'                         => $userid,
                    'service_id'                           => $request->service_id,
                    'subservice_id'                        => $request->subservice_id,
                    'address_type'                         => $request->address_type,
                    'city'                                 => $request->city,
                    'area'                                 => $request->area,
                    'building_street_no'                   => $request->building_street_no,
                    'apartment_villa_no'                   => $request->apartment_villa_no,
                    'bookingdate'                          => $request->date,
                    'bookingyear'                          => date('Y'),
                    'month'                                => $request->month,
                    'end_date'                            => $formatted_date,
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
                    'describe_painting_service'            => $request->describe_painting_service ?: "",
                    'cdate'                                => date('Y-m-d'),
                );
            }

            $order_item_id = DB::table('ci_order_item')->insertGetId($arrData);




            if ($isPaintingData == "" && empty($isPaintingData) && $request->subservice_id == 70 || $request->subservice_id == 29 || $request->subservice_id == 71 || $request->subservice_id == 72 || $request->subservice_id == 73 || $request->subservice_id == 79 || $request->subservice_id == 80 || $request->subservice_id == 81 || $request->subservice_id == 82 || $request->subservice_id == 83 || $request->subservice_id == 84 || $request->subservice_id == 85 || $request->subservice_id == 86 || $request->subservice_id == 87 || $request->subservice_id == 88 || $request->subservice_id == 93) {
                //  echo"Deep Cleaning and Furniture Cleaning";exit;
                // echo"<pre>";print_r($request->all());echo"</pre>";exit;
                if (\Cart::count() > 0) {
                    foreach (\Cart::content() as $arrRowDeailts) {

                        $arrData_package = array(
                            'order_id'                        => $arrOrderId,
                            'order_item_id'                   => $order_item_id,
                            'user_info_id'                    => $userid,
                            'package_id'                      => $arrRowDeailts->id,
                            'package_item_name'               => $arrRowDeailts->name,
                            'package_quantity'                => $arrRowDeailts->qty,
                            'package_item_price'              => $arrRowDeailts->price,
                            'service_id'                      => $arrRowDeailts->options->service_id,
                            'service_name'                    => $arrRowDeailts->options->service_name,
                            'subservice_id'                   => $arrRowDeailts->options->subservice_id,
                            'subservice_name'                 => $arrRowDeailts->options->subservice_name,
                            'packagecategory_id'              => $arrRowDeailts->options->packagecategory_id,
                            'packagecategory_name'            => $arrRowDeailts->options->packagecategory_name,
                            'page_url'                        => $arrRowDeailts->options->page_url,
                            'image'                           => $arrRowDeailts->options->image,
                            'discount'                        => $arrRowDeailts->options->discount,
                            'discount_type'                   => $arrRowDeailts->options->discount_type,
                            'product_discount_amount'         => round($arrRowDeailts->options->product_discount_amount),
                            'cdate'                           => date('Y-m-d'),
                            'subservice_booking_percentage'   => $arrRowDeailts->options->subservice_booking_percentage,

                        );

                        // echo "<pre>";print_r($arrData);echo"</pre>";exit;


                        DB::table('ci_order_item_packages')->insertGetId($arrData_package);
                    }
                }
            }

            //if($request->fname !=''){
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

            if ($isPaintingData != "" && !empty($isPaintingData)) {
                // echo"painting_here";exit;

                if ($request->apply_button == 1) {
                    $walletdiscount = Session::get('walletdiscount') ?? "";
                    $userWalletamount = Session::get('user_wallet_amount') ?? "";
                    if ($walletdiscount != "" && $userWalletamount != "") {

                        if ($userWalletamount > $walletdiscount) {

                            // $Pending_data = $userWalletamount - $walletdiscount;
                            $order_total = $request->total_to_pay_charge_price;
                            $order_total = round((float) $order_total, 2);

                            $walletData = array(
                                'userid'          => 0,
                                'refer_id'        => $userid,
                                'order_currency'  => 'AED',
                                'order_total'     => $order_total,
                                'wallet_amount'   => $walletdiscount,
                                'added_from'      => 1,
                                'order_id'        => $arrOrderId,
                                'added_date'      => date('Y-m-d'),
                            );

                            DB::table('front_user_wallet')->insertGetId($walletData);
                        } else {

                            $walletData = array(
                                'userid'          => 0,
                                'refer_id'        => $userid,
                                'order_currency'  => 'AED',
                                'order_total'     => $order_total,
                                'wallet_amount'   => $userWalletamount,
                                'added_from'      => 1,
                                'order_id'        => $arrOrderId,
                                'added_date'      => date('Y-m-d'),
                            );

                            DB::table('front_user_wallet')->insertGetId($walletData);
                        }
                    }
                }
            } else {
                // echo"cleaning_here";exit;
                if ($request->apply_button == 1) {
                    $walletdiscount = Session::get('walletdiscount') ?? "";
                    $userWalletamount = Session::get('user_wallet_amount') ?? "";


                    if ($walletdiscount != "" && $userWalletamount != "") {

                        if ($userWalletamount > $walletdiscount) {

                            // $Pending_data = $userWalletamount - $walletdiscount;
                            $order_total = $request->total_to_pay;
                            $order_total = round((float) $order_total, 2);

                            $walletData = array(
                                'userid'          => 0,
                                'refer_id'        => $userid,
                                'order_currency'  => 'AED',
                                'order_total'     => $order_total,
                                'wallet_amount'   => $walletdiscount,
                                'added_from'      => 1,
                                'order_id'        => $arrOrderId,
                                'added_date'      => date('Y-m-d'),
                            );

                            DB::table('front_user_wallet')->insertGetId($walletData);
                        } else {

                            // echo"<pre>";print_r($walletdiscount);echo"</pre>";
                            // echo"<pre>";print_r($userWalletamount);echo"</pre>";exit;

                            $walletData = array(
                                'userid'          => 0,
                                'refer_id'        => $userid,
                                'order_currency'  => 'AED',
                                'order_total'     => $order_total,
                                'wallet_amount'   => $userWalletamount,
                                'added_from'      => 1,
                                'order_id'        => $arrOrderId,
                                'added_date'      => date('Y-m-d'),
                            );

                            DB::table('front_user_wallet')->insertGetId($walletData);
                        }
                    }
                }
            }

            Session::put('painting_service_name', $type_of_paintingInset);
            if ($payment_type == 'COD') {
                // echo"here";exit;
                $success = $this->success_mail_book_now();
                $success_vendor = $this->success_mail_book_now_allvendor();
                if ($success) {
                    // Redirect to the 'thankyou' route

                    if ($isPaintingData == "" && empty($isPaintingData)) {

                        return redirect('thankyou_book_now');
                    } else {
                        return redirect('thankyou-book-now');
                    }
                }
            } elseif ($payment_type == 'TABBY') {
                $tabbyService = app(\App\Services\TabbyService::class);

                $bookingData = [
                    'order_id' => $formatOrderId,
                    'total_amount' => $order_total_new,
                    'customer_phone' => $userdata['mobile'] ?? '',
                    'customer_email' => $userdata['email'] ?? '',
                    'customer_name' => $userdata['name'] ?? '',
                    'tax_amount' => $vat_total ?? 0,
                    'items' => []
                ];

                $response = $tabbyService->createSession($bookingData);

                if ($response && isset($response['configuration']['available_products']['installments'][0]['web_url'])) {
                    $paymentId = $response['payment']['id'] ?? '';
                    try {
                        DB::table('ci_orders')->where('order_id', $arrOrderId)->update(['tabby_payment_id' => $paymentId]);
                    } catch (\Exception $e) {
                        \Log::warning("Could not save tabby_payment_id, migration likely missing.", ['msg' => $e->getMessage()]);
                    }
                    return redirect($response['configuration']['available_products']['installments'][0]['web_url']);
                }
                return redirect()->route('payment_fail')->with('error', 'Tabby payment initialization failed.');
            } else {
                // echo"Online";exit;

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
                    'success_url' => route('payment_success'),
                    'cancel_url' => route('payment_fail'),
                ]);

                // dd($response);
                // echo "dev".$response->id;
                if (isset($response->id) && $response->id != '') {

                    Session::put('stripe_session_id', $response->id);


                    return redirect($response->url);
                } else {
                    return redirect()->route('payment_fail');
                }
            }
        } elseif (isset($WoodenFloorService) && $WoodenFloorService != "") {

            // echo "<pre>";print_r($request->all());exit;
            $service_id = $request->service_id;
            $subservice_id = $request->subservice_id;
            $name = $userdata['name'];
            $email = $userdata['email'];
            $mobile = $userdata['mobile'];
            $property_type = $request->property_type;
            $area_of_floor = $request->area_of_floor;
            $condition_of_floor = $request->condition_of_floor;
            $service_required = $request->service_required;
            $schedule_site_survey = $request->schedule_site_survey;
            if ($request->hasFile('upload_video') && $request->file('upload_video')->isValid()) {
                // $path = $request->file('upload_video')->store('upload/video', 'public');
                $file = $request->file('upload_video');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('upload/video'), $filename);
            }
            $describe_your_requirements = $request->describe_your_requirements;
            $enquiry_date = $request->date;
            $enquiry_month = $request->month;
            $enquiry_year = date('Y');
            $time_slot = $request->time_slot;
            $addressType = $request->address_type;
            $city = $request->city;
            $area = $request->area;
            $building_street_no = $request->building_street_no;

            $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($city) . '%'])->first();
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

            $lastSequence = DB::table('wooden_floor_enquiry')
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

            $arrayOfWoodenEnquiry = array(
                'service_id'                => $service_id,
                'subservice_id'             => $subservice_id,
                'name'                      => $name,
                'email'                     => $email,
                'mobile'                    => $mobile,
                'property_type'             => $property_type,
                'area_of_floor'             => $area_of_floor,
                'condition_of_floor'        => $condition_of_floor,
                'service_required'          => $service_required,
                'schedule_site_survey'      => $schedule_site_survey,
                'describe_your_requirements' => $describe_your_requirements ?? "",
                'video'                     => $filename ?? "",
                'enquiry_date'              => $enquiry_date,
                'enquiry_month'             => $enquiry_month,
                'enquiry_year'              => $enquiry_year,
                'time_slot'                 => $time_slot,
                'addressType'               => $addressType,
                'city'                      => $city,
                'area'                      => $area,
                'building_street_no'        => $building_street_no,
                'added_date'                => date("Y-m-d"),
                'subservice_code'           => $subserviceCode,
                'city_code'                 => $cityCode,
                'order_year'                => $year,
                'sequence_no'               => $nextSequence,
                'inquiry_id'                => $formatOrderId,
            );

            // echo "<pre>";print_r($arrayOfWoodenEnquiry);echo"</pre>";exit;

            $enquiryInsertId =  DB::table('wooden_floor_enquiry')->insertGetId($arrayOfWoodenEnquiry);
            // $processed_text = "WoodenFloor";
            // $yearForId =date('y');
            // $data_u['inquiry_id'] = "IQ-".$processed_text."-" . $yearForId ."-". sprintf("%06d", $enquiryInsertId);
            // DB::table('wooden_floor_enquiry')->where('id', $enquiryInsertId)->update($data_u);

            $arrayData = array('name' => $name, 'type_of_painting' => 'Wooden Floor Polishing Service');
            Session::put('enquiry_user_data', $arrayData);
            $success = $this->success_mail_wooden_floor_enquiry();

            return redirect()->route('thank-you');
        } else {
            // 
            // echo "<pre>";print_r($request->all());exit;
            $type_of_painting = $request->type_of_painting;
            $service_id = $request->service_id;
            $subservice_id = $request->subservice_id;
            $name = $userdata['name'];
            $email = $userdata['email'];
            $mobile = $userdata['mobile'];
            $addressType = $request->address_type;
            $city = $request->city;
            $area = $request->area;
            $building_street_no = $request->building_street_no;
            $enquiry_date = $request->date;
            $enquiry_month = $request->month;
            $enquiry_year = date('Y');
            $time_slot = $request->time_slot;
            $description = $request->describe_painting_service;

            if ($request->formfield_value == "Paint individual rooms") {
                $no_of_rooms_paint = $request->how_many_rooms_painted ?? '';
                $noRoomsPaint =  $no_of_rooms_paint;
            } else {
                $noRoomsPaint = 0;
            }

            if ($request->formfield_value == "Paint individual walls") {
                $no_of_walls_paint = $request->how_many_walls_painted ?? '';
                $noWallsPaint =  $no_of_walls_paint;
            } else {
                $noWallsPaint = 0;
            }

            $CityName = $request->city ?? '';

            $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($CityName) . '%'])->first();
            $subserviceData = DB::table('subservices')->where('id', $request->subservice_id)->first();

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

            $lastSequence = DB::table('painting_enquiry')
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

            $arrayOfEnquiry = array(
                'type_of_painting'          => $type_of_painting,
                'name'                      => $name,
                'service_id'                => $service_id,
                'subservice_id'             => $subservice_id,
                'email'                     => $email,
                'mobile'                    => $mobile,
                'addressType'               => $addressType,
                'city'                      => $city,
                'area'                      => $area,
                'building_street_no'        => $building_street_no,
                'enquiry_date'              => $enquiry_date,
                'enquiry_month'             => $enquiry_month,
                'enquiry_year'              => $enquiry_year,
                'time_slot'                 => $time_slot,
                'no_of_rooms_painted'       => $noRoomsPaint,
                'no_of_walls_painted'       => $noWallsPaint,
                'describe_painting_service' => $description ?? "",
                'added_date'                => date("Y-m-d"),
                'subservice_code'           => $subserviceCode,
                'city_code'                 => $cityCode,
                'order_year'                => $year,
                'sequence_no'               => $nextSequence,
                'inquiry_id'                => $formatOrderId,
            );

            //echo "<pre>";print_r($arrayOfEnquiry);echo"</pre>";exit;

            $enquiryInsertId =  DB::table('painting_enquiry')->insertGetId($arrayOfEnquiry);
            //   $processed_text = "Painting";
            //   $yearForId =date('y');
            //   $data_u['inquiry_id'] = "IQ-".$processed_text."-" . $yearForId ."-". sprintf("%06d", $enquiryInsertId);
            //DB::table('painting_enquiry')->where('id', $enquiryInsertId)->update($data_u);

            $arrayData = array('name' => $name, 'type_of_painting' => $type_of_painting);
            Session::put('enquiry_user_data', $arrayData);
            $success = $this->success_mail_painting_enquiry();
            /*  if ($success) {
                    if($isPaintingData == "" && empty($isPaintingData)){
                        return redirect('thankyou_book_now');
                    }else{
                        return redirect('thankyou-book-now');
                    }
                }  */


            return redirect()->route('thank-you');
        }

        // echo "<pre>";print_r($request->all());echo"</pre>";exit;
    }

    public function book_now_garden_order(Request $request)
    {
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $userdata = Session::get('user');

        $garden_data = $request->service_type;

        if ($request->subservice == 77 || $request->subservice == 78) {

            $data['name'] = $userdata['name'];
            $data['email'] = $userdata['email'];
            $data['mobile'] = $userdata['mobile'];

            if ($request->pakage_id != '') {
                $data['pakage_id'] = $request->pakage_id;
            }
            if ($request->service != '') {
                $data['service_id'] = $request->service;
            }
            if ($request->subservice != '') {
                $data['subservice_id'] = $request->subservice;
            }
            if ($request->packagecategory != '') {
                $data['packagecategory_id'] = $request->packagecategory_id;
            }

            $data['added_date'] = date('Y-m-d');

            $data['form_type'] = "Local Move";

            $cityData = DB::table('cities')->where('id', $request->city)->first();
            $subserviceData = DB::table('subservices')->where('id', $request->subservice)->first();

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

            $lastSequence = DB::table('packages_enquiry')
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

            $data['subservice_code'] = $subserviceCode;
            $data['city_code'] = $cityCode;
            $data['order_year'] = $year;
            $data['sequence_no'] = $nextSequence;
            $data['inquiry_id'] = $formatOrderId;

            // echo"<pre>";print_r($data);echo"</pre>";exit;


            $package_inquiry = DB::table('packages_enquiry',)->insertGetId($data);

            // $package_data_n = DB::table('packages_enquiry',)->where('id',$package_inquiry)->first();

            // $service_name = \Helper::servicename($package_data_n->service_id);

            // $processed_text = strtoupper(str_replace(' ', '', $service_name));

            // $year =date('y');

            // $data_u['inquiry_id'] = "IQ-".$processed_text."-" . $year ."-". sprintf("%06d", $package_inquiry);
            // DB::table('packages_enquiry')->where('id', $package_inquiry)->update($data_u);

            //  echo"here"; exit;

            if (isset($garden_data) && !empty($garden_data) || $request->subservice == 77) {

                $inquiry_id = $package_inquiry;
                $name = $userdata['name'];
                $email = $userdata['email'];
                $mobile = $userdata['mobile'];
                $service      = $request->service;
                $subservice   = $request->subservice;
                $service_type = $request->service_type;
                $service_date = date('Y-m-d', strtotime($request->service_date));
                $address      = $request->address;
                $city      = $request->city;
                $type_of_home = $request->type_of_home;
                $size_of_home = $request->size_of_home_1;
                $size_of_home_id = $request->size_of_home_id;
                $describe_your_requirements = $request->describe_your_requirements;


                $arrayOfGardenEnquiry = array(
                    'inquiry_id'            => $inquiry_id,
                    'user_name'             => $name,
                    'user_email'            => $email,
                    'user_mobile'           => $mobile,
                    'service'               => $service,
                    'subservice'            => $subservice,
                    'service_type'          => $service_type,
                    'service_date'          => $service_date,
                    'city'                  => $city,
                    'address'               => $address,
                    'type_of_home'          => $type_of_home,
                    'size_of_home_id'       => $size_of_home_id,
                    'size_of_home'          => $size_of_home,
                    'describe_your_requirements' => $describe_your_requirements,
                    'subservice_code' => $subserviceCode,
                    'city_code' => $cityCode,
                    'order_year' => $year,
                    'sequence_no' => $nextSequence,
                    //'inquiry_id' => $formatOrderId,
                    'added_date'            => date("Y-m-d"),
                );

                //echo "<pre>";print_r($arrayOfEnquiry);echo"</pre>";exit;

                $enquiryInsertId =  DB::table('garden_enquiry')->insertGetId($arrayOfGardenEnquiry);

                if ($request->subservice == 77) {
                    $arrayData = array('name' => $name, 'type_of_painting' => Helper::subservicename(strval($request->subservice)));
                } else {
                    $arrayData = array('name' => $name, 'type_of_painting' => $service_type);
                }
                $this->vendor_mail_for_garden($package_inquiry);
                Session::put('enquiry_user_data', $arrayData);
                Session::put('garden_enquiry_id', $enquiryInsertId);
                Session::put('garden_enquiry_data', $arrayOfGardenEnquiry);
                Session::put('garden_ref_code', $formatOrderId);

                return redirect()->route('thank-you');
            }
        }
    }
    public function vendor_mail_for_garden($package_inquiry_id)
    {

        $package_data = DB::table('packages_enquiry')->where('id', $package_inquiry_id)->first();
        $currentDate = date('Y-m-d');

        $garden_data = DB::table('garden_enquiry')->where('inquiry_id', $package_inquiry_id)->first();
        // echo $request->subservice_id;
        if ($package_data->subservice_id != 0) {

            $subscription_vendor_data = DB::table('subscription')
                ->whereRaw("FIND_IN_SET(?, services)", [$package_data->service_id])
                ->whereRaw("FIND_IN_SET(?, sub_service)", [$package_data->subservice_id])
                ->where('is_deleted', '=', '0')
                ->whereRaw("FIND_IN_SET(?, city)", [$garden_data->city])
                ->where('enddate', '>=', $currentDate)
                ->get();
        }

        //  echo"<pre>";print_r($garden_data);echo"</pre>";
        //  echo"<pre>";print_r($subscription_vendor_data);echo"</pre>";
        //  echo"<pre>";print_r($package_data);echo"</pre>";exit;

        $vendor_id_array = array();

        if ($subscription_vendor_data != '' && !empty($subscription_vendor_data)) {

            foreach ($subscription_vendor_data as $subscription_vendor_val) {
                $vendor_id_array[] = $subscription_vendor_val->vendor_id;
            }
        }
        $vendor_id_array_dataunique = array_unique($vendor_id_array);

        //  echo"<pre>";print_r($vendor_id_array_dataunique);echo"</pre>";exit;

        foreach ($vendor_id_array_dataunique as $vendor_id_array_data) {

            $vendor_data = DB::table('users')->where('id', $vendor_id_array_data)->where('is_active', 0)->first();

            if (!empty($vendor_data)) {

                $vendor_att_email = array();
                $vendor_data_attr = DB::table('vendors_attribute')->where('pid', $vendor_data->id)->get()->toArray();

                foreach ($vendor_data_attr as $attr_data) {
                    if (!empty($attr_data->c_email)) {
                        $vendor_att_email[] = $attr_data->c_email;
                    }
                }

                // echo"<pre>";print_r($vendor_att_email);echo"</pre>";exit;

                if (!empty($vendor_att_email)) {
                    $cc = implode(',', $vendor_att_email);
                } else {
                    $cc = '';
                }


                // $vendors_id = Crypt::encrypt($vendor_data->id);

                $userdata = Session::get('user');
                $user_name = $userdata['name'];
                $Date = date('d-m-Y');


                // new mail start-----------------------------------------------------------------------------

                $html = '<!doctype html> <html>
        <head>
            <meta charset="utf-8">
            <title>Forget Password Email</title>
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
                <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;">
                </div>
                <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;">
                    
                <p>Dear ' . ucfirst($vendor_data->name) . ',</p>                 
                <p>We are excited to inform you that a new customer has requested a quote for ' . \Helper::servicename($package_data->service_id) . ' on VendorsCity!</p>
                <p><strong>Request Details:</strong></p>
                <ul><li style= "list-style-type: disc;margin-bottom: -15px;"> Service Requested : ' . \Helper::servicename($package_data->service_id) . '</li>                       
                <li style= "list-style-type: disc;margin-bottom: -15px;"> Customer Name : ' . $user_name . '</li>
                <li style= "list-style-type: disc";> Request Date : ' . $Date . '</li></ul>                        
                <p><a class="btnlink" href="' . route("vendor.login") . '" style=" background: #0040E6;color: #fff !important;text-decoration: none;width: 100%;display: block;padding: 9px 0;text-align: center;
                    font-size: 16px;border-radius: 9px;">View Request</a></p>

                <p><strong>What You Need to Do:</strong></p>
                <ul><li style= "list-style-type: disc;margin-bottom: -15px;"> Log in to your : <a href="' . route("vendor.login") . '">Vendor Portal</a></li>
                <li style= "list-style-type: disc";> View the full request details and customer information.</li></ul>

                <p>Submit your quote <strong>within 24 hours</strong>. Please ensure your quote is competitive and detailed to increase your chances of securing the job. If you have any questions or need assistance, feel free to reach out to us at hello@vendorscity.com.</p>
                <p>Thank you for your prompt attention to this request.</p>
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
                                <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:vendors@vendorscity.com">vendors@vendorscity.com</a></p>
                                <p  style="margin:0;">VendorsCity Portal LLC</p>
                                <div class="footer_links" style=" margin:10px 0;">
                            <a href="' . url("/terms-of-service") . '"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                            <a href="' . url("/privacy-policy") . '"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                            <a href="' . url("/contact") . '"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                            </div>
                                <p style="margin:0;">This message was mailed to ' . $vendor_data->email . ' as part of you account registered with us on VendorsCity</p>
                            </div>
                        </div>
                  </div>
            </div>
        </body>
        </html>';

                // new mail end---------------------------------------------------------------------------------------------

                /* notification sectio start */
                $data_notification['vendor_id'] = $vendor_data->id;
                $data_notification['subject'] = 'New Lead Generated for ' . \Helper::servicename($package_data->service_id) . '';
                $data_notification['added_datetime'] = date('Y-m-d h:i:s');

                DB::table('notification')->insert($data_notification);
                /* notification sectio end */


                $userdata = Session::get('user');
                $user_email = $userdata['email'];
                $user_name = $userdata['name'];

                $subject = " New Quote Request for  " . \Helper::servicename($package_data->service_id) . " on VendorsCity! Customer Name : " . $user_name . "";

                $to = $vendor_data->email;

                // $ccRecipients = ['hello@vendorscity.com','zafar@quickserverelo.com'];
                // if (!empty($cc)) {
                //     $ccRecipients = explode(',', $cc); 
                // }

                $ccRecipients = array();
                $bccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
                if (!empty($cc)) {
                    $bccRecipients = explode(',', $cc);
                }

                Mail::send([], [], function ($message) use ($html, $to,  $subject, $ccRecipients, $bccRecipients) {
                    $message->to($to, 'VendorsCity');
                    $message->subject($subject);
                    foreach ($ccRecipients as $ccRecipient) {
                        $message->bcc($ccRecipient);
                    }
                    foreach ($bccRecipients as $bccRecipient) {
                        $message->bcc($bccRecipient);
                    }
                    $message->html($html);
                });
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
                $this->creditCouponWallet($order_number);

                $item = DB::table('ci_order_item')->where('order_id', $order_number)->first();

                $success = $this->success_mail_book_now();
                $success_vendor = $this->success_mail_book_now_allvendor();
                if ($success) {

                    if ($item->service_id == 45) {
                        return redirect()->route('cleaning.thankyou_book_now');
                    } elseif ($item->service_id == 48) {
                        return redirect()->route('saloon_spa.thankyou_book_now');
                    } elseif ($item->service_id == 34) {
                        return redirect()->route('hanyman.thankyou_book_now');
                    } elseif ($item->service_id == 47) {
                        return redirect()->route('pest_control.thankyou_book_now');
                    } else {
                        return redirect('thankyou_book_now');
                    }
                    // Redirect to the 'thankyou' route

                }
            }
        } else {
            return redirect()->route('payment_fail');
        }
    }

    public function creditCouponWallet($orderIdOrNumber)
    {
        $order = DB::table('ci_orders')
            ->where('order_id', $orderIdOrNumber)
            ->orWhere('order_number', $orderIdOrNumber)
            ->first();

        if ($order && $order->coupan_to_wallet == '1' && $order->coupondiscount > 0) {
            $exists = DB::table('front_user_wallet')
                ->where('order_id', $order->order_number)
                ->where('added_from', 0)
                ->exists();
            if (!$exists) {
                $wallet_content = [
                    'userid'              => $order->user_id,
                    'refer_id'             => $order->user_id,
                    'order_currency'       => $order->order_currency ?? 'AED',
                    'order_total'          => $order->order_total,
                    'system_percentage'    => '',
                    'wallet_amount'        => $order->coupondiscount,
                    'added_from'           => 0,
                    'order_id'             => $order->order_number,
                    'added_date'           => date('Y-m-d'),
                ];
                DB::table('front_user_wallet')->insert($wallet_content);
            }
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

        $order_number = Session::get('order_number');

        $format_order_id = Session::get('format_order_id');

        $orderdata = DB::table('ci_orders')->where('order_number', $order_number)->first();


        Session::put('order_payment_mode', $orderdata->paymentmode);

        if ($orderdata->paymentmode == 1) {
            $payment_mode = "Cash On Delivery";
        } else {
            $payment_mode = "Online Payment";
        }

        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_number)->get();


        //  $shiaddress = DB::table('ci_shipping_address')->where('order_id',$order_number)->first();
        //    echo "<pre>";print_r($order_item_data);echo"</pre>";
        // echo "<pre>";print_r($orderdata);echo "</pre>";

        $i = 1;

        $message_body = '';

        $message_body .= '<!doctype html>
 
 <html lang="en">
 
     <body style="margin: 0;font-family: Arial, Helvetica, sans-serif;">
 
         <div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;">
 
             <header style="text-align:center;"><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
 
                 <a href="{{ config("app.url") }}"><img style="max-width:100%;display: inline-block;" src="' . asset("public/site/images/VC-LONG-COLOR.png") . '"></a>           </header>
 
             <div style="background:#ababab;padding: 7% 8% 6%;">
 
                 <p style="font-size: 17px;letter-spacing: 0.5px;text-align:center;line-height: 30px;color:#fff;margin:0;">
 
                     Hi, Your order number <strong>' . $format_order_id . '</strong> has been<br>
 
                     successfully placed.
 
                 </p>
 
             </div>
 
             <div style="background:#EDEDED;padding: 20px 7%;font-size: 14px;text-align: left;">
 
                 <div style="width:55%;background:#EDEDED;text-align: left;display: inline-block;margin-bottom: 10px;">
 
                     <p style="margin:0">
 
                         <strong>Order Details</strong><br>
 
                         Order No.: ' . $format_order_id . '<br><br>
 
                         Payment Mode: ' . $payment_mode . '<br>
 
                     </p>
 
                 </div>
 
 
             </div>
 
             <div style="padding: 0px 30px;">
 
                 <p style="text-align: left;text-align: left;border-bottom: 2px solid #727171;padding-bottom: 4px;"><strong>Item(s) in Your Order</strong></p>
 
                 <table style="border-collapse: collapse;width: 100%;">';

        $pvalue = '0';

        $userdata = Session::get('user');

        $userid = $userdata['userid'];

        $user_email = $userdata['email'];

        foreach ($order_item_data as $arrRowDeailts) {

            if ($arrRowDeailts->product_discount_amount != 0 && $arrRowDeailts->product_discount_amount != '') {
                $product_discount_amount = $arrRowDeailts->product_discount_amount;
            } else {
                $product_discount_amount = $arrRowDeailts->package_item_price;
            }

            $totalgst = '0';

            $message_body .= '<tr style="border-bottom: 2px solid #CCCECF;">';

            if ($arrRowDeailts->image != '') {

                $message_body .= ' <td style="width: 85px;padding-bottom: 10px;vertical-align: top;"><img src="' . asset("public/upload/packages/large/" . $arrRowDeailts->image) . '" style="width:85px;height:97px;border: 2px solid gray;" /></td>';
            } else {
                $message_body .= '<td style="width: 85px;padding-bottom: 10px;vertical-align: top;"><img src="' . asset("public/upload/packages/large/no-image.png") . '" style="width:85px;height:97px;border: 2px solid gray;" /></td>';
            }

            $message_body .= '<td style="text-align: left;vertical-align: top;padding-left: 15px;padding-bottom: 10px;">
 
                         <p style="margin: 0;"><strong>' . $arrRowDeailts->package_item_name . '</strong></p>
 
                         <p style="margin: 0;"> <span style="color:gray;">Quantity:</span> ' . $arrRowDeailts->package_quantity . '</p><br>
 
                     </td>
 
                     <td style="vertical-align: top;width: 150px;text-align: right;padding-bottom: 10px;">' .



                $orderdata->order_currency . ' ' . number_format(($product_discount_amount * $arrRowDeailts->package_quantity), 2);

            /* $message .='&nbsp; <del style="color:gray;">Rs.: 1599</del></td>';*/

            $message_body .= '</tr>';

            $i++;

            $pvalue = ($pvalue +  (($product_discount_amount) * $arrRowDeailts->package_quantity));
        }

        $message_body .= '<tr style="border-bottom: 2px solid #CCCECF;color: #808080;">
 
                         <td style="text-align:left;" colspan="2">Subtotal</td>
 
                         <td style="text-align:right;">' . $orderdata->order_currency . ' ' . number_format($pvalue, 2) . '</td>
 
                     </tr>';

        if ($orderdata->coupondiscount != "" && $orderdata->coupondiscount != 0) {

            $message_body .= '<tr style="border-bottom: 2px solid #CCCECF;color: #808080;">
 
                         <td style="text-align:left;" colspan="2">Discount</td>
 
                         <td style="text-align:right;">' . $orderdata->order_currency . ' ' . number_format($orderdata->coupondiscount, 2) . '</td>
 
                     </tr>';
        }


        if ($orderdata->shippingcost != "" && $orderdata->shippingcost != 0) {

            $message_body .= '<tr style="color: #808080;">
 
                      <td style="text-align:left;" colspan="2">Shipping</td>
 
                      <td style="text-align:right;">' . $orderdata->order_currency . ' ' . number_format($orderdata->shippingcost, 2) . '</td>
 
                     </tr>';
        }

        if ($orderdata->vatcharge != "" && $orderdata->vatcharge != 0) {

            $message_body .= '<tr style="color: #808080;">
    
                         <td style="text-align:left;" colspan="2">VAT 5%</td>
    
                         <td style="text-align:right;">' . $orderdata->order_currency . ' ' . number_format($orderdata->vatcharge, 2) . '</td>
    
                        </tr>';
        }

        if ($orderdata->front_wallet_amount != "" && $orderdata->front_wallet_amount != 0) {

            $message_body .= '<tr style="color: #808080;">
    
                         <td style="text-align:left;" colspan="2">Wallet Amount</td>
    
                         <td style="text-align:right;">' . '-' . $orderdata->order_currency . ' ' . number_format($orderdata->front_wallet_amount, 2) . '</td>
    
                        </tr>';
        }

        $message_body .= '<tr style="border-bottom: 1px solid #000;border-top: 1px solid #000;font-weight: bold;">
 
                         <td style="text-align:left;" colspan="2">Total</td>
 
                         <td style="text-align:right;">' . $orderdata->order_currency . ' ' . number_format($orderdata->order_total, 2) . '</td>
 
                     </tr>
 
                 </table>
 
             </div>
 
         </div>
 
     </body>
 
 </html>';


        $subject = "Thank you for shopping with Vendors City";
        $refer_id = $userdata['refer_id'];

        $system_percentage = DB::table('system')->first();
        $total = ($orderdata->order_total * $system_percentage->percentage / 100);

        // echo $total;exit;
        if (isset($userdata['refer_id']) && $userdata['refer_id'] != '') {
            $existing_wallet = DB::table('front_user_wallet')->where('userid', $userdata['userid'])->first();
            if (!$existing_wallet) {
                $data['userid'] = $userdata['userid'];
                $data['refer_id'] = $userdata['refer_id'];
                $data['order_currency'] = $orderdata->order_currency;
                $data['wallet_amount'] = $total;
                $data['system_percentage'] = $system_percentage->percentage;
                $data['order_total'] = $orderdata->order_total;
                $data['added_date'] = date('Y-m-d');

                DB::table('front_user_wallet')->insert($data);
            }
        }


        //  $to = $user_email;
        //  $ccRecipients = ['support@vendorscity.com'];

        //  Mail::send([], [], function($message) use($message_body, $to, $subject) {
        //      $message->to($to);
        //      $message->subject($subject);
        //      $message->from('devang.hnrtechnologies@gmail.com', 'Vendors City');
        //      $message->html($message_body);
        //  });

        if ($orderdata->paymentmode == 1) {
            $payment_mode = "COD";
        } else {
            $payment_mode = "Online";
        }

        $user_name = $userdata['name'];
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
        $refer_id = $userdata['refer_id'];

        $system_percentage = DB::table('system')->first();
        $total = ($orderdata->order_total * $system_percentage->percentage / 100);

        // echo $message_bodyy;exit;

        $to = $user_email;
        $ccRecipients = array();

        $bccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        // $to = "mayudin.hnrtechnologies@gmail.com";
        Mail::send([], [], function ($message) use ($message_bodyy, $to, $subject, $ccRecipients, $bccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            foreach ($bccRecipients as $bccRecipient) {
                $message->bcc($bccRecipient);
            }
            $message->html($message_bodyy);
        });




        return true;
    }
    public function success_mail_book_now()
    {

        $userdata = Session::get('user');
        $userid = $userdata['userid'];


        $order_number = Session::get('order_number');
        $format_order_id = Session::get('format_order_id');



        $orderdata = DB::table('ci_orders')->where('order_id', $order_number)->first();

        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_number)->first();

        if (!empty($type_of_painting)) {

            $service_name = $type_of_painting->type_of_painting;

            //Session::put('book_now_subservice_name_session', $type_of_painting_name);
        } else {
            $service_name = \Helper::subservicename(strval($order_item_data->subservice_id));
            //Session::put('book_now_subservice_name_session', $service_name);
        }
        Session::put('book_now_subservice_name_session', $service_name);




        if (session('country_code')) {
            $country_code = session('country_code');
        } else {
            $country_code = '971';
        }

        $phone = $country_code . '' . $userdata['mobile'];
        $customer_name = $userdata['name'];

        $date = $order_item_data->bookingdate ?? "";
        $month = $order_item_data->month ?? "";
        $year = $order_item_data->bookingyear ?? "";

        $booking_time = Helper::timeslotname(strval($order_item_data->time_slot));

        if ($date != '' && $month != '' && $year != '') {

            $booking_date = $month . ' ' . $date . ', ' . $year;
        } else {
            $booking_date = "-";
        }

        $url = $order_number;





        Session::put('order_payment_mode', $orderdata->paymentmode);

        if ($orderdata->paymentmode == 1) {
            $payment_mode = "Cash On Delivery";
        } else {
            $payment_mode = "Online Payment";
        }


        // echo"<pre>";print_r($order_item_data);echo"</pre>";exit;

        if ($order_item_data->subservice_id == 47) {
            $type_of_painting = DB::table('ci_order_item')->where('order_id', $order_number)->where('service_id', $order_item_data->service_id)->where('subservice_id', $order_item_data->subservice_id)->first();
        } else {
            $type_of_painting = array();
        }



        //echo"<pre>sss";print_r($type_of_painting);echo"</pre>";


        //echo $service_name;exit;


        //$service_name = \Helper::subservicename(strval($order_item_data->subservice_id));



        if ($order_item_data->how_often_do_you_need_cleaning != '') {
            $service_mail = $service_name . " - " . $order_item_data->how_often_do_you_need_cleaning . " for " . $order_item_data->how_many_hours_should_they_stay . " hours " . $order_item_data->how_many_cleaners_do_you_need . " cleaner(s)";

            $order_item_package_data = array();
        } else {
            $service_mail = '';
            $order_item_package_data = DB::table('ci_order_item_packages')
                ->where('order_id', $order_number)
                ->where('order_item_id', $order_item_data->id)
                ->get()->toArray();
        }

        //echo"<pre>";print_r($order_item_package_data);echo"</pre>";exit;


        if ($order_item_data->which_day_of_the_week_do_you_want_the_service != '') {
            $when = $order_item_data->which_day_of_the_week_do_you_want_the_service . " " . $order_item_data->bookingdate . " " . $order_item_data->month . ", " . $order_item_data->bookingyear . " at " . $order_item_data->time_slot;
        } else {
            $when = $order_item_data->bookingdate . " " . $order_item_data->month . ", " . $order_item_data->bookingyear;
        }

        $Where = $order_item_data->city . ", " . $order_item_data->area . ", " . $order_item_data->building_street_no . ", " . $order_item_data->apartment_villa_no;

        $total = $orderdata->sub_total * 5 / 100;
        $total = floor($total);

        $user_name = $userdata['name'];
        $user_email = $userdata['email'];



        $importantNotes = "";

        $importantNotes .= "<li>Please ensure that someone is available at your location during the scheduled appointment time.</li>";
        $importantNotes .= "<li>If you need to change your requested date or time, please inform us in advance.</li>";
        $importantNotes .= '<li>For urgent queries or updates, you can reach us at 056 836 3677 or <a href="https://wa.me/971568363677" target="_blank" style="color:#555;">WhatsApp</a>.</li>';

        if ($order_item_data->subservice_id == 95) {
            $importantNotes .= "<li>For insurance claim purposes, your receipt has been attached to this email. You can also access it at any time by visiting our website, logging into your profile, selecting your booking, and viewing the receipt.</li>";
            $importantNotes .= "<li>Please ensure that your Emirates ID or passport is available at the time of your appointment and present it to the visiting nurse or doctor for verification.</li>";
            $importantNotes .= "<li>The turnaround time for your lab results will be communicated by the nurse or doctor during the visit.</li>";
            $importantNotes .= "<li>If your selected time slot becomes fully booked, our nurse or doctor will contact you to arrange an alternative appointment time.</li>";
            $importantNotes .= "<li>Please note that the Dubai Health Authority (DHA) may access electronic medical records, and test results may be shared where required by law.</li>";
        }






        $message_bodyy = '';
        if ($orderdata->order_from == 1 && $orderdata->order_from != 2) {
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
                        <p><strong>Dear </strong>' . $user_name . ',</p>
                        <p>Thank you for choosing VendorsCity! We’ve successfully received your request for ' . $service_name . ' service.</p>
                        <p>Your booking has been confirmed. Our team will be ready to assist you as scheduled. For any updates, changes, or assistance related to your booking, please contact our support team directly.</p>

                       
                       <div class="heading" style="font-weight: bold;font-size: 20px;margin-top: 7%;">
                        Here are the details of your request:
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
                                    <h5 style="font-size: 14px;margin: 0;">Date: <span style="margin: 0;font-weight:100;"> ' . $when . ' </span></h5>
                                    </li></ul>
                                </div>
                             </div>
                             
                            <div class="row main_row" style="margin:10px 0;">
                                <div class="col-lg-2 custom_col_2" style="width: 100%;
                                display: inline-block;">
                                <ul style="margin: 0;padding: 0"><li>
                                    <h5 style="font-size: 14px;margin: 0;">Time: 
                                     <span style="margin: 0;font-weight:100;"> ' . \Helper::timeslotname($order_item_data->time_slot) . '</span></h5> </li></ul>
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
                       </div>
                      
';

            if ($orderdata->paymentmode == '1' && $order_item_data->how_often_do_you_need_cleaning == "Weekly") {
                $message_bodyy .= '<h5 style="font-size: 14px;margin: 0;">Weekly Payment:</h5>
                    <p>Since this is a <strong style="font-weight:700;">cash on delivery service </strong>, payment of amount <img src="' . asset("public/site/images/automobile/DirhamBlack.png") . '"" style="width: 15px;" > <strong style="font-weight:1000;"> ' . $orderdata->order_total . '</strong>is due weekly in full upon completion of the service. Please have the payment ready for our team.</p>.';
            }
            if ($orderdata->paymentmode == '2' && $order_item_data->how_often_do_you_need_cleaning == "Weekly") {
                $message_bodyy .= '<h5 style="font-size: 14px;margin: 0;">Weekly Payment:</h5>
                    <p>You will be debited each week from your original payment method for your service until you cancel your cleaning subscription with us. If you wish to cancel your subscription reach out to support@vendorscity.com or WhatsApp us at 056 836 3677 and we will sort it out.</p>.';
            }

            if ($orderdata->paymentmode == '1' && $order_item_data->how_often_do_you_need_cleaning == "Once") {
                $message_bodyy .= '<p>Since this is a <strong style="font-weight:700;">cash on delivery service </strong>, payment of amount <img src="' . asset("public/site/images/automobile/DirhamBlack.png") . '"" style="width: 15px;" > <strong style="font-weight:1000;">' . $orderdata->order_total . '</strong> is due in full upon completion of the service. Please have the payment ready for our team.</p>.';
            }

            $message_bodyy .= '
                    <h5 style="font-size: 14px;margin: 0;">What happens next:</h5> 
                    <ul><li>
                    If any additional information is required or your selected time slot needs to be rescheduled, our team will contact you directly.</li>
                    <li>You’ll receive WhatsApp updates when your assigned service team is on the way.</li>
                    <li>You can also track your booking status anytime by visiting our website and checking your profile.</li>
                    <li>Sit back and relax — we’ll take care of the rest.</li>
                    </ul>
                    
                    <h5 style="font-size: 14px;margin: 0;">Important Notes:</h5> 
                    <ul>' . $importantNotes . '
                    
                    </ul>

                    <p>We appreciate your trust in VendorsCity and look forward to providing you with an exceptional service experience!</p>

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
            //  echo $message_bodyy;exit;

            // $subject = " Confirmation of Your $service_name Service Booking .'$orderdata->format_order_id'. ";
            $subject = "$service_name Service Request Has Been Received – VendorsCity";
        } else if ($orderdata->order_from == 2 && $orderdata->order_from != 1) {

            /* Email For Painting */

            $date = $order_item_data->bookingdate ?? "";
            $month = $order_item_data->month ?? "";
            $year = $order_item_data->bookingyear ?? "";

            $timeSlot = Helper::timeslotname(strval($order_item_data->time_slot));

            if ($date != '' && $month != '' && $year != '') {

                $date_and_time = $month . ' ' . $date . ', ' . $year;
            } else {
                $date_and_time = "-";
            }

            /* Address */
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
                        <p>Dear ' . $user_name . ',</p>';
            if ($orderdata->paymentmode == 1) {
                $message_bodyy .= '<p>Thank you for choosing VendorsCity! We’ve successfully received your request for ' . $service_name . ' .</p>';
            } else {
                $message_bodyy .= '<p>Thank you for choosing VendorsCity! We’ve successfully received your request for ' . $service_name . '.</p>';
            }

            $message_bodyy .= '
                        <p>Your booking has been confirmed. Our team will be ready to assist you as scheduled. For any updates, changes, or assistance related to your booking, please contact our support team directly.</p>
                       <div class="heading" style="font-weight: bold;font-size: 20px;margin-top: 7%;">
                        Here are the details of your request:
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

                $message_bodyy .= '<p>Since this is a <strong style="font-weight:700;">cash on delivery</strong> service, payment of amount <img src="' . asset("public/site/images/automobile/DirhamBlack.png") . '"" style="width: 15px;" > <strong style="font-weight:700;">' . $orderdata->order_total . '</strong> is due in full upon completion of the service. Please have the payment ready for our team.</p>';
            } else {
                $message_bodyy .= '';
            }

            $message_bodyy .= '
                    <h5 style="font-size: 14px;margin: 0;">What happens next:</h5> 
                    <ul><li>
                    If any additional information is required or your selected time slot needs to be rescheduled, our team will contact you directly.</li>
                    <li>You’ll receive WhatsApp updates when your assigned service team is on the way.</li>
                    <li>You can also track your booking status anytime by visiting our website and checking your profile.</li>
                    <li>Sit back and relax — we’ll take care of the rest.</li>
                    
                    </ul>

                    <h5 style="font-size: 14px;margin: 0;">Important Notes:</h5> 
                    <ul>' . $importantNotes . '
                    
                    </ul>
                    <p>We appreciate your trust in VendorsCity and look forward to providing you with an exceptional service experience!</p>

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

            //$subject = " Confirmation of Your $service_name Booking .'$orderdata->format_order_id'. ";
            $subject = " $service_name Request Has Been Received – VendorsCity  ";
        }


        $system_percentage = DB::table('system')->first();
        $total = ($orderdata->order_total * $system_percentage->percentage / 100);

        // echo $total;exit;
        if (isset($userdata['refer_id']) && $userdata['refer_id'] != '') {
            $existing_wallet = DB::table('front_user_wallet')->where('userid', $userdata['userid'])->first();
            if (!$existing_wallet) {
                $data['userid'] = $userdata['userid'];
                $data['refer_id'] = $userdata['refer_id'];
                $data['order_currency'] = $orderdata->order_currency;
                $data['wallet_amount'] = $total;
                $data['system_percentage'] = $system_percentage->percentage;
                $data['order_total'] = $orderdata->order_total;
                $data['added_date'] = date('Y-m-d');

                DB::table('front_user_wallet')->insert($data);
            }
        }


        // Define missing variables for PDF generation
        $tempDir = storage_path('app/mpdf');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $itemList = DB::table('ci_order_item')->where('order_id', $order_number)->get();
        $visit_date = $order_item_data->bookingdate . ' ' . $order_item_data->month . ' ' . $order_item_data->bookingyear;

        $data_pdf['orders'] = $orderdata;
        $data_pdf['items'] = $itemList;
        $data_pdf['visit_date'] = $visit_date;

        request()->merge(['download' => 'pdf']);
        $html = view('front.view_receipts', $data_pdf)->render();

        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => $tempDir,
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ]);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->showWatermarkImage = true;
        $mpdf->watermarkImgBehind = true;
        $mpdf->SetWatermarkImage(public_path('site/images/VC-BLACK-SHORT.png'), 0.025, 'D', 'C');
        $mpdf->WriteHTML($html);

        $fileName = $orderdata->format_order_id . '.pdf';
        $pdfOutput = $mpdf->Output('', 'S');

        $to = $user_email;
        //$to = 'devang.hnrtechnologies@gmail.com';
        $bccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        $ccRecipients = array();
        Mail::send([], [], function ($message) use ($message_bodyy, $to, $subject, $ccRecipients, $bccRecipients, $pdfOutput, $fileName) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            foreach ($bccRecipients as $bccRecipient) {
                $message->bcc($bccRecipient);
            }
            $message->html($message_bodyy);
            $message->attachData($pdfOutput, $fileName, [
                'mime' => 'application/pdf',
            ]);
        });




        $this->success_msg_whatsapp_customer($userid, $order_number);

        return true;

        // echo"<pre>";print_r($order_item_data);echo"</pre>";exit;
    }


    // 	 function success_mail_book_now_allvendor()
    // {
    //     $userdata = Session::get('user');
    //     $order_number = Session::get('order_number');
    //     $format_order_id = Session::get('format_order_id');

    //     // Fetch order and related items/packages
    //     $orders = DB::table('ci_orders as o')
    //         ->select('o.*')
    //         ->where('o.order_id', $order_number)
    //         ->where('o.payment_status', 'Success') // ✅ Only successful payments
    //         ->orderByDesc('o.order_id')
    //         ->get()
    //         ->map(function ($order) {
    //             $order->items = DB::table('ci_order_item as i')
    //                 ->where('i.order_id', $order->order_id)
    //                 ->select('i.*')
    //                 ->get()
    //                 ->map(function ($item) {
    //                     $item->packages = DB::table('ci_order_item_packages as p')
    //                         ->where('p.order_item_id', $item->id)
    //                         ->select('p.*')
    //                         ->get();
    //                     return $item;
    //                 });
    //             return $order;
    //         });

    //     if ($orders->isEmpty()) {
    //         return "No successful order found.";
    //     }

    //     // Extract all service IDs and subservice IDs from order items
    //     $serviceIds = [];
    //     $subserviceIds = [];
    //     foreach ($orders as $order) {
    //         foreach ($order->items as $item) {
    //             if (!empty($item->service_id)) {
    //                 $serviceIds[] = $item->service_id;
    //             }
    //             if (!empty($item->subservice_id)) {
    //                 $subserviceIds[] = $item->subservice_id;
    //             }
    //         }
    //     }

    //     $serviceIds = array_unique($serviceIds);
    //     $subserviceIds = array_unique($subserviceIds);

    //     if (empty($serviceIds) && empty($subserviceIds)) {
    //         return "No service/subservice IDs found in this order.";
    //     }

    //     // Fetch vendors who provide matching services & subservices
    //     $vendors = DB::table('users')
    //         ->where('vendor', 1)
    //         ->where('is_active', 0)
    //         ->get()
    //         ->filter(function ($vendor) use ($serviceIds, $subserviceIds) {
    //             if (empty($vendor->serviceList) || empty($vendor->subserviceList)) return false;

    //             $vendorServices = explode(',', $vendor->serviceList);
    //             $vendorSubservices = explode(',', $vendor->subserviceList);

    //             $hasServiceMatch = count(array_intersect($serviceIds, $vendorServices)) > 0;
    //             $hasSubserviceMatch = count(array_intersect($subserviceIds, $vendorSubservices)) > 0;

    //             // ✅ Require both to match
    //             return $hasServiceMatch && $hasSubserviceMatch;
    //         });

    //     $firstItem = $orders->flatMap->items->first(); // First item across all orders

    //     $service_name = '';
    //     if ($firstItem && !empty($firstItem->subservice_id)) {
    //         $service_name = \Helper::subservicename(strval($firstItem->subservice_id));
    //     }

    //     $subject = "You got New Booking for " . $service_name . " | Order Number " . $format_order_id;

    //     $vendor_bcc_emails = ['hello@vendorscity.com','zafar@quickserverelo.com'];

    //     // ============ SEND MAIL TO VENDORS ASYNC ============
    //     dispatch(function () use ($vendors, $orders, $userdata, $order_number, $subject,$vendor_bcc_emails) {
    //         foreach ($vendors as $vendor) {
    //             try {
    //                 // if (empty($vendor->email)) continue;

    //                 // Mail::send('emails.vendor_booking_order_notification', [
    //                 //     'user' => $userdata,
    //                 //     'orders' => $orders,
    //                 //     'order_number' => $order_number,
    //                 //     'vendor' => $vendor,
    //                 // ], function ($message) use ($vendor, $subject,$vendor_bcc_emails) {
    //                 //     $message->to($vendor->email, $vendor->name ?? 'Vendor')
    //                 //             ->bcc($vendor_bcc_emails) // ✅ Add BCC here
    //                 //             ->subject($subject);
    //                 // });

    //                 // ✅ Fetch attribute emails for vendor
    //                 $attributeEmails = DB::table('vendors_attribute')
    //                     ->where('pid', $vendor->id)
    //                     ->whereNotNull('c_email')
    //                     ->pluck('c_email')
    //                     ->toArray();

    //                 // Merge main vendor + attributes emails
    //                 $allVendorEmails = array_filter(array_merge([$vendor->email], $attributeEmails));

    //                 if (!empty($allVendorEmails)) {
    //                     Mail::send('emails.vendor_booking_order_notification', [
    //                         'user' => $userdata,
    //                         'orders' => $orders,
    //                         'order_number' => $order_number,
    //                         'vendor' => $vendor,
    //                     ], function ($message) use ($allVendorEmails, $vendor, $subject, $vendor_bcc_emails) {
    //                         $message->to($allVendorEmails, $vendor->name ?? 'Vendor')
    //                                 ->bcc($vendor_bcc_emails)
    //                                 ->subject($subject);
    //                     });
    //                 }
    //                 $this->success_msg_whatsapp_allVendor($vendor->id,$order_number);

    //             } catch (\Exception $e) {
    //                 \Log::error('Vendor mail failed (' . $vendor->email . '): ' . $e->getMessage());
    //             }
    //         }
    //     })->afterResponse();

    //     return true;
    // }

    function success_mail_book_now_allvendor()
    {
        $userdata        = Session::get('user');
        $order_number    = Session::get('order_number');
        $format_order_id = Session::get('format_order_id');

        // ===================== FETCH ORDER =====================
        $orders = DB::table('ci_orders as o')
            ->select('o.*')
            ->where('o.order_id', $order_number)
            ->where('o.payment_status', 'Success')
            ->orderByDesc('o.order_id')
            ->get()
            ->map(function ($order) {
                $order->items = DB::table('ci_order_item as i')
                    ->where('i.order_id', $order->order_id)
                    ->select('i.*')
                    ->get()
                    ->map(function ($item) {
                        $item->packages = DB::table('ci_order_item_packages as p')
                            ->where('p.order_item_id', $item->id)
                            ->select('p.*')
                            ->get();
                        return $item;
                    });

                return $order;
            });

        if ($orders->isEmpty()) {
            return "No successful order found.";
        }

        // ===================== EXTRACT SERVICE / SUBSERVICE / CITY =====================
        $serviceIds     = [];
        $subserviceIds  = [];
        $orderCities    = [];

        foreach ($orders as $order) {
            foreach ($order->items as $item) {

                if (!empty($item->service_id)) {
                    $serviceIds[] = $item->service_id;
                }
                if (!empty($item->subservice_id)) {
                    $subserviceIds[] = $item->subservice_id;
                }
                if (!empty($item->city)) {      // here item->city = name e.g. Dubai
                    $orderCities[] = trim($item->city);
                }
            }
        }

        $serviceIds    = array_unique($serviceIds);
        $subserviceIds = array_unique($subserviceIds);
        $orderCities   = array_unique($orderCities);

        if (empty($serviceIds) && empty($subserviceIds)) {
            return "No service/subservice IDs found.";
        }

        // ===================== FETCH ALL CITY MASTER FOR ONE-TIME USE =====================
        $cityMaster = DB::table('cities')->pluck('name', 'id')->toArray();
        // Example: [27 => "Dubai", 29 => "Abu Dhabi"]

        // ===================== FILTER VENDORS =====================
        $vendors = DB::table('users')
            ->where('vendor', 1)
            ->where('is_active', 0)
            ->get()
            ->filter(function ($vendor) use ($serviceIds, $subserviceIds, $orderCities, $cityMaster) {

                // Vendor must have service + subservice + cityList
                if (empty($vendor->serviceList) || empty($vendor->subserviceList) || empty($vendor->city)) {
                    return false;
                }

                // -------- SERVICE & SUBSERVICE CHECK --------
                $vendorServices     = explode(',', $vendor->serviceList);
                $vendorSubservices  = explode(',', $vendor->subserviceList);

                $hasServiceMatch    = count(array_intersect($serviceIds, $vendorServices)) > 0;
                $hasSubserviceMatch = count(array_intersect($subserviceIds, $vendorSubservices)) > 0;


                // -------- CITY CHECK --------
                $vendorCityIDs = explode(',', $vendor->city); // e.g. 27,29

                // Convert Vendor City IDs → Names
                $vendorCityNames = [];
                foreach ($vendorCityIDs as $cid) {
                    if (isset($cityMaster[$cid])) {
                        $vendorCityNames[] = trim($cityMaster[$cid]);
                    }
                }

                // Check if order item cities match vendor cities
                $hasCityMatch = count(array_intersect($orderCities, $vendorCityNames)) > 0;

                // Must match all three
                return $hasServiceMatch && $hasSubserviceMatch && $hasCityMatch;
            });

        // No vendors matched
        if ($vendors->isEmpty()) {
            return "No vendor matched service/subservice/city.";
        }

        // ===================== SUBJECT =====================
        $firstItem    = $orders->flatMap->items->first();
        $service_name = $firstItem ? \Helper::subservicename($firstItem->subservice_id) : '';

        $subject = "You got New Booking for $service_name | Order Number $format_order_id";

        $vendor_bcc_emails = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        // $vendor_bcc_emails = ['raj.amvisolution@gmail.com'];

        // ===================== SEND MAIL TO VENDORS ASYNC =====================
        dispatch(function () use ($vendors, $orders, $userdata, $order_number, $subject, $vendor_bcc_emails) {

            foreach ($vendors as $vendor) {
                try {

                    // Fetch extra vendor emails
                    $attributeEmails = DB::table('vendors_attribute')
                        ->where('pid', $vendor->id)
                        ->whereNotNull('c_email')
                        ->pluck('c_email')
                        ->toArray();

                    // Merge vendor main email + attribute emails
                    $allVendorEmails = array_filter(array_merge([$vendor->email], $attributeEmails));

                    if (!empty($allVendorEmails)) {

                        Mail::send('emails.vendor_booking_order_notification', [
                            'user'         => $userdata,
                            'orders'       => $orders,
                            'order_number' => $order_number,
                            'vendor'       => $vendor,
                        ], function ($message) use ($allVendorEmails, $vendor, $subject, $vendor_bcc_emails) {

                            $message->to($allVendorEmails, $vendor->name ?? 'Vendor')
                                ->bcc($vendor_bcc_emails)
                                ->subject($subject);
                        });
                    }

                    // WhatsApp message
                    $this->success_msg_whatsapp_allVendor($vendor->id, $order_number);
                } catch (\Exception $e) {
                    \Log::error('Vendor mail failed (' . $vendor->email . '): ' . $e->getMessage());
                }
            }
        })->afterResponse();

        return true;
    }


    function success_msg_whatsapp_allVendor($vendor_id, $order_number)
    {

        // echo "sd";exit;

        // $vendor_id = '100028';
        // $order_number = '349';
        $vendors = DB::table('users')->where('id', $vendor_id)->where('is_active', 0)->first();
        $vendors_attribute = DB::table('vendors_attribute')->where('pid', $vendors->id)->get();

        $orders = DB::table('ci_orders as o')
            ->select('o.*')
            ->where('o.order_id', $order_number)
            ->where('o.payment_status', 'Success') // ✅ Only successful payments
            ->orderByDesc('o.order_id')
            ->get()
            ->map(function ($order) {
                $order->items = DB::table('ci_order_item as i')
                    ->where('i.order_id', $order->order_id)
                    ->select('i.*')
                    ->get()
                    ->map(function ($item) {
                        $item->packages = DB::table('ci_order_item_packages as p')
                            ->where('p.order_item_id', $item->id)
                            ->select('p.*')
                            ->get();
                        return $item;
                    });
                return $order;
            });

        $firstItem = $orders->flatMap->items->first();

        $subservice  = \Helper::subservicename($firstItem->subservice_id);

        // echo"<pre>";print_r($vendors);echo"";
        // echo"<pre>";print_r($subservice);echo"";
        // exit;

        $phone = $vendors->country_code . '' . $vendors->mobile;


        if (isset($vendors->country_code) && isset($vendors->mobile)) {
            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            //     CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'POST',
            //     CURLOPT_POSTFIELDS => '{"messages":[{"to":"' . $phone . '","content":{"templateName":"new_booking_alert","language":"en","templateData":{"body":{"placeholders":["' . $subservice . '"]},"buttons":[{"type":"URL"}]}}}]}',
            //     CURLOPT_HTTPHEADER => array(
            //         'accept: application/json',
            //         'content-type: application/json',
            //         'Authorization: key_uTZeOXQPMd'
            //     ),
            // ));

            // $response = curl_exec($curl);

            // curl_close($curl);

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
                        "' . $subservice . '"
                        ]
                    }
                    },
                    "templateName": "new_booking_alert"
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
        }

        if (isset($vendors_attribute) && count($vendors_attribute) > 0) {

            foreach ($vendors_attribute as  $vendorAtt) {

                $vendorAttphone = $vendorAtt->country_code . '' . $vendorAtt->telephone;
                if (isset($vendorAtt->country_code) && isset($vendorAtt->telephone)) {
                    // $curl = curl_init();

                    // curl_setopt_array($curl, array(
                    //     CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
                    //     CURLOPT_RETURNTRANSFER => true,
                    //     CURLOPT_ENCODING => '',
                    //     CURLOPT_MAXREDIRS => 10,
                    //     CURLOPT_TIMEOUT => 0,
                    //     CURLOPT_FOLLOWLOCATION => true,
                    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    //     CURLOPT_CUSTOMREQUEST => 'POST',
                    //     CURLOPT_POSTFIELDS => '{"messages":[{"to":"' . $vendorAttphone . '","content":{"templateName":"new_booking_alert","language":"en","templateData":{"body":{"placeholders":["' . $subservice . '"]},"buttons":[{"type":"URL"}]}}}]}',
                    //     CURLOPT_HTTPHEADER => array(
                    //         'accept: application/json',
                    //         'content-type: application/json',
                    //         'Authorization: key_uTZeOXQPMd'
                    //     ),
                    // ));

                    // $response = curl_exec($curl);

                    // curl_close($curl);

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
                                "' . $subservice . '"
                                ]
                            }
                            },
                            "templateName": "new_booking_alert"
                        },
                        "from": "+971503204846",
                        "to": "' . $vendorAttphone . '"
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
        }



        return true;
        //echo"<pre>";print_r($response);echo"";exit;
    }


    function success_msg_whatsapp_customer($userid, $order_number)
    {

        $userdata = DB::table('frontloginregisters')->where('id', $userid)->first();
        $orders = DB::table('ci_orders as o')
            ->select('o.*')
            ->where('o.order_id', $order_number)
            ->where('o.payment_status', 'Success') // ✅ Only successful payments
            ->orderByDesc('o.order_id')
            ->get()
            ->map(function ($order) {
                $order->items = DB::table('ci_order_item as i')
                    ->where('i.order_id', $order->order_id)
                    ->select('i.*')
                    ->get()
                    ->map(function ($item) {
                        $item->packages = DB::table('ci_order_item_packages as p')
                            ->where('p.order_item_id', $item->id)
                            ->select('p.*')
                            ->get();
                        return $item;
                    });
                return $order;
            });

        $firstItem = $orders->flatMap->items->first();

        $subservice  = \Helper::subservicename($firstItem->subservice_id);
        // echo"<pre>";print_r($userdata);echo"";
        // echo"<pre>";print_r($subservice);echo"";
        // exit;
        $phone = $userdata->country_code . '' . $userdata->mobile;
        $customer_name = $userdata->name;
        if (isset($userdata->country_code) && isset($userdata->mobile)) {
            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            //     CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'POST',
            //     CURLOPT_POSTFIELDS => '{"messages":[{"to":"' . $phone . '","content":{"templateName":"service_requested","language":"en","templateData":{"body":{"placeholders":["' . $customer_name . '","' . $subservice . '"]},"buttons":[{"type":"URL","parameter": "' . $order_number . '"}]}}}]}',
            //     CURLOPT_HTTPHEADER => array(
            //         'accept: application/json',
            //         'content-type: application/json',
            //         'Authorization: key_uTZeOXQPMd'
            //     ),
            // ));

            // $response = curl_exec($curl);

            // curl_close($curl);

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
                            "' . $subservice . '"
                            ]
                        },
                        "buttons": [
                            {
                            "type": "URL",
                            "parameter": "' . $order_number . '"
                            }
                        ]
                        },
                        "templateName": "service_requested"
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
        }
        return true;

        //frontloginregisters

    }




    function success_mail_wooden_floor_enquiry()
    {

        $userdata = Session::get('user');
        $user_email = $userdata['email'];
        $user_name = $userdata['name'];

        // echo "<pre>";print_r(Session::get('enquiry_user_data'));echo "</pre>";exit;
        $woodenfloorServiceName = Session::get('enquiry_user_data')['type_of_painting'];
        $message_bodyy = "";
        $message_bodyy .= '<!doctype html>

  
        <head>
        <meta charset="utf-8">
        <title>Painting Enquiry:</title>
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
                        font-size:14px;line-height:24px;font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
            <div class="logo"style="float: inherit;border-bottom: 4px solid #FFD413;">
            <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;"  >
            </div>
            <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;" >
                <p>Dear ' . $user_name . ',</p>
                <p>Thank you for reaching out to VendorsCity! We have received your request for up to 5 free quotes for ' . $woodenfloorServiceName . '.</p>
                <p><strong>What Happens Next?</strong></p>
    
                <p>Our trusted vendors will review your request and will contact you within 2 business days. You will receive up to 5 quotes tailored to your specific wooden floor polishing needs.</p>
                <p><strong>How to Choose the Best Vendor:</strong></p>
                <ul><li style= "list-style-type: disc;margin-bottom: -15px;">Review the quotes you receive.</li>
                <li style= "list-style-type: disc;margin-bottom: -15px;">Check out the vendor ratings and reviews to make an informed decision.</li>
                <li style= "list-style-type: disc";>Select the vendor that best suits your requirements.</li></ul>  
                <p>We are committed to helping you find the best services quickly and easily. If you have any questions or need further assistance, please don&#39;t hesitate to contact us at <a href="mailto:support@vendorscity">support@vendorscity.com</a>.
                </p> 
                
                <p>Thank you for choosing VendorsCity!</p>
               
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

        $subject = " Your Request for Free Quotes on Wooden Floor Polishing is being Processed!";



        $to = $user_email;
        $bccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        $ccRecipients = array();

        Mail::send([], [], function ($message) use ($message_bodyy, $to, $subject, $ccRecipients, $bccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            foreach ($bccRecipients as $bccRecipient) {
                $message->bcc($bccRecipient);
            }
            $message->html($message_bodyy);
        });
    }

    function success_mail_painting_enquiry()
    {

        $order_number = Session::get('order_number');

        $orderdata = DB::table('ci_orders')->where('order_number', $order_number)->first();
        $userdata = Session::get('user');
        $user_email = $userdata['email'];
        $user_name = $userdata['name'];

        // echo "<pre>";print_r(Session::get('enquiry_user_data'));echo "</pre>";exit;
        $paintingServiceName = Session::get('enquiry_user_data')['type_of_painting'];
        $message_bodyy = "";
        $message_bodyy .= '<!doctype html>

  
        <head>
        <meta charset="utf-8">
        <title>Painting Enquiry:</title>
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
                        font-size:14px;line-height:24px;font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
            <div class="logo"style="float: inherit;border-bottom: 4px solid #FFD413;">
            <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;"  >
            </div>
            <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;" >
                <p>Dear ' . $user_name . ',</p>
                <p>Thank you for reaching out to VendorsCity! We have received your request for up to 5 free quotes for ' . $paintingServiceName . '.</p>
                <p><strong>What Happens Next?</strong></p>
    
                <p>Our trusted vendors will review your request and will contact you within 2 business days. You will receive up to 5 quotes tailored to your specific painting needs.</p>
                <p><strong>How to Choose the Best Vendor:</strong></p>
                <ul><li style= "list-style-type: disc;margin-bottom: -15px;">Review the quotes you receive.</li>
                <li style= "list-style-type: disc;margin-bottom: -15px;">Check out the vendor ratings and reviews to make an informed decision.</li>
                <li style= "list-style-type: disc";>Select the vendor that best suits your requirements.</li></ul>  
                <p>We are committed to helping you find the best services quickly and easily. If you have any questions or need further assistance, please don&#39;t hesitate to contact us at <a href="mailto:support@vendorscity">support@vendorscity.com</a>.
                </p> 
                
                <p>Thank you for choosing VendorsCity!</p>
               
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

        $subject = " Your Request for Free Quotes on Painting is being Processed!";



        $to = $user_email;
        $bccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        $system_percentage = DB::table('system')->first();


        if ($orderdata != "") {

            $total = ($orderdata->order_total * $system_percentage->percentage / 100);

            // echo $total;exit;
            if (isset($userdata['refer_id']) && $userdata['refer_id'] != '') {
                $existing_wallet = DB::table('front_user_wallet')->where('userid', $userdata['userid'])->first();
                if (!$existing_wallet) {
                    $data['userid'] = $userdata['userid'];
                    $data['refer_id'] = $userdata['refer_id'];
                    $data['order_currency'] = $orderdata->order_currency;
                    $data['wallet_amount'] = $total;
                    $data['system_percentage'] = $system_percentage->percentage;
                    $data['order_total'] = $orderdata->order_total;
                    $data['added_date'] = date('Y-m-d');

                    DB::table('front_user_wallet')->insert($data);
                }
            }
        }



        $ccRecipients = array();
        // $to = "mayudin.hnrtechnologies@gmail.com";
        Mail::send([], [], function ($message) use ($message_bodyy, $to, $subject, $ccRecipients, $bccRecipients) {
            $message->to($to);
            $message->subject($subject);
            foreach ($ccRecipients as $ccRecipient) {
                $message->bcc($ccRecipient);
            }
            foreach ($bccRecipients as $bccRecipient) {
                $message->bcc($bccRecipient);
            }
            $message->html($message_bodyy);
        });
    }

    function thankyou_book_now()
    {

        \Cart::destroy();
        session()->forget('coupan_data');
        session()->forget('shippingcahrge');
        session()->forget('discount_amount');
        session()->forget('order_total');
        session()->forget('stripe_session_id');
        session()->forget('walletdiscount');
        session()->forget('user_wallet_amount');

        $order_number = Session::get('order_number');

        $data['thank_order_data'] = $orderData =  DB::table('ci_orders')->where('order_id', $order_number)->first();
        $data['thank_ci_order_data'] = $orderitemData =  DB::table('ci_order_item')->where('order_id', $order_number)->first();





        $userdata = Session::get('user');

        if (session('country_code')) {
            $country_code = session('country_code');
        } else {
            $country_code = '971';
        }

        $service_name = Session::get('book_now_subservice_name_session');

        $subservice_name = Helper::subservicename($orderitemData->subservice_id);

        $phone = $country_code . '' . $userdata['mobile'];
        $customer_name = $userdata['name'];

        $date = $orderitemData->bookingdate ?? "";
        $month = $orderitemData->month ?? "";
        $year = $orderitemData->bookingyear ?? "";

        $booking_time = Helper::timeslotname(strval($orderitemData->time_slot));

        if ($date != '' && $month != '' && $year != '') {

            $booking_date = $month . ' ' . $date . ', ' . $year;
        } else {
            $booking_date = "-";
        }

        $url = $order_number;




        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        // CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // CURLOPT_CUSTOMREQUEST => 'POST',
        // CURLOPT_POSTFIELDS =>'{"messages":[{"to":"'.$phone.'","content":{"templateName":"service_confirmation_vc","language":"en","templateData":{"body":{"placeholders":["'.$customer_name.'","'.$subservice_name.'","'.$booking_date.'","'.$booking_time.'"]},"buttons":[{"type":"URL","parameter":"'.$url.'"}]}}}]}',
        // CURLOPT_HTTPHEADER => array(
        //     'accept: application/json',
        //     'content-type: application/json',
        //     'Authorization: key_uTZeOXQPMd'
        // ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);

        // $response = json_decode($response, true);

        //echo"<pre>";print_r($response);echo"</pre>";exit;



        $data['meta_title'] = "";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "";

        $data['message'] =  "Book Now";
        return view('front.thank_you_book_now', $data);
    }
    function thankyou_painting()
    {

        \Cart::destroy();
        session()->forget('coupan_data');
        session()->forget('shippingcahrge');
        session()->forget('discount_amount');
        session()->forget('order_total');
        session()->forget('stripe_session_id');
        session()->forget('walletdiscount');
        session()->forget('user_wallet_amount');

        $order_number = Session::get('order_number');

        $data['thank_order_data'] = $orderData =  DB::table('ci_orders')->where('order_id', $order_number)->first();
        $data['thank_ci_order_data'] = $orderitemData =  DB::table('ci_order_item')->where('order_id', $order_number)->first();





        $userdata = Session::get('user');

        if (session('country_code')) {
            $country_code = session('country_code');
        } else {
            $country_code = '971';
        }

        $service_name = Session::get('book_now_subservice_name_session');

        $subservice_name = Helper::subservicename($orderitemData->subservice_id);

        $phone = $country_code . '' . $userdata['mobile'];
        $customer_name = $userdata['name'];

        $date = $orderitemData->bookingdate ?? "";
        $month = $orderitemData->month ?? "";
        $year = $orderitemData->bookingyear ?? "";

        $booking_time = Helper::timeslotname(strval($orderitemData->time_slot));

        if ($date != '' && $month != '' && $year != '') {

            $booking_date = $month . ' ' . $date . ', ' . $year;
        } else {
            $booking_date = "-";
        }

        $url = $order_number;




        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => '{"messages":[{"to":"' . $phone . '","content":{"templateName":"service_confirmation_vc","language":"en","templateData":{"body":{"placeholders":["' . $customer_name . '","' . $subservice_name . '","' . $booking_date . '","' . $booking_time . '"]},"buttons":[{"type":"URL","parameter":"{{' . $url . '}}"}]}}}]}',
        //     CURLOPT_HTTPHEADER => array(
        //         'accept: application/json',
        //         'content-type: application/json',
        //         'Authorization: key_uTZeOXQPMd'
        //     ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);

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

        $data['meta_title'] = "";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "";

        $data['message'] =  "Book Now";
        return view('front.thank_you_painting', $data);
    }

    function thankyou()
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

        $data['message'] =  "Thank you for choosing VendorsCity! Your order has been successfully processed. A detailed confirmation email has been sent to your registered email address. If you need any assistance or have questions, please don't hesitate to contact us at support@vendorscity.com or call us at 056 VENDORS (056 836 3677). We're here to help!";

        return view('front.thank_you', $data);
    }

    function bill_state_change()
    {

        $country_id = $_POST['country_id'];

        $result = DB::table('states')
            ->select('*')
            ->where('country_id', '=', $country_id)
            ->get();

        $result_new = $result->toArray();
        // echo"<pre>";print_r($result_new);echo"</pre>";exit;
        $html  = "<select name='state_name' id='state_name' class='form-control' onchange='ship_state_change(this.value);'>";
        $html .= "<option value=''>Select State</option>";
        if ($result != '' &&  count($result) > 0) {

            for ($i = 0; $i < count($result); $i++) {

                $html .= "<option value='" . $result[$i]->id . "'>" . $result[$i]->state . "</option>";
            }
        }
        $html  .= "<select>";
        echo $html;
    }

    function ship_state_change()
    {

        $country_id = $_POST['country'];
        $state_id = $_POST['state_id'];

        $result = DB::table('cities')
            ->select('*')
            ->where('country', '=', $country_id)
            ->where('state', '=', $state_id)
            ->get();

        $result_new = $result->toArray();
        // echo"<pre>";print_r($result_new);echo"</pre>";exit;
        $html  = "<select name='city' id='city' class='form-control'>";
        $html .= "<option value=''>Select Town / City</option>";
        if ($result != '' &&  count($result) > 0) {

            for ($i = 0; $i < count($result); $i++) {

                $html .= "<option value='" . $result[$i]->id . "'>" . $result[$i]->name . "</option>";
            }
        }
        $html  .= "<select>";
        echo $html;
    }

    function apply_wallet_dicount(Request $request)
    {
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $walletdiscount = $request->total_wallet_amount;
        $userWalletamount = $request->userWalletamount;
        Session::put('walletdiscount', $walletdiscount);
        Session::put('user_wallet_amount', $userWalletamount);

        $sessionWalletAmt = Session::get('walletdiscount', $walletdiscount);
        echo $sessionWalletAmt;
    }
    function cancel_wallet_dicount(Request $request)
    {
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $walletdiscount = $request->orderTotal;
        $userWalletamount = $request->userWalletAmount;
        Session::put('walletdiscount', $walletdiscount);
        Session::put('user_wallet_amount', $userWalletamount);

        $sessionuserWalletamount = Session::get('user_wallet_amount', $userWalletamount);
        echo $sessionuserWalletamount;
    }

    function book_now_homecleaning(Request $request)
    {

        /* echo "<pre>";
        print_r($request->all());
        echo "</pre>";
        exit; */
        $coupan_data = session('coupan_data');
        $userdata = Session::get('user');
        $userid = $userdata['userid'];
        $payment_type = $request->payment_type;

        if ($payment_type == 'COD') {
            $order_status = 'BK';
            $paymentmode = 1;
            $list_order_status = '0';
            $payment_status = 'Success';
            $payment_mode = "COD";
        } else {
            $order_status = 'BK';
            $paymentmode = 2;
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

        $order_from = 1;
        $order_total = $request->total_to_pay;
        $front_wallet_amount_new = 0;
        $vat_total = $request->vat_total;

        $cleaning_discount_additional = "";

        $timing_charger = $request->timing_charge;

        $coupan_to_wallet = '';
        $coupon_discounted = 0;
        $coupan_code_name = "";

        $order_total_new = $request->sub_total + $vat_total;

        if (Session::has('coupan_data')) {

            $coupan_code_name = $coupan_data['coupancode'];

            if ($coupan_data['discount'] != '' && $coupan_data['coupanvalue'] == 0) {
                $coupon_discounted = ($order_total_new * $coupan_data['discount']) / 100;
            }
            if ($coupan_data['discount'] != '' && $coupan_data['coupanvalue'] == 1) {
                $coupon_discounted = $coupan_data['discount'];
            }

            if ($coupan_data['coupan_apply_wallet'] == 0) {
                $coupan_to_wallet = '1';

                // Credit customer's wallet immediately if COD booking is completed successfully
                if ($payment_type == 'COD') {
                    $wallet_content = [
                        'userid'              => $userid,
                        'refer_id'             => $userid,
                        'order_currency'       => 'AED',
                        'order_total'          => $order_total,
                        'system_percentage'    => '',
                        'wallet_amount'        => $coupon_discounted,
                        'added_from'           => 0, // credit
                        'order_id'             => $order_number,
                        'added_date'           => date('Y-m-d'),
                    ];
                    DB::table('front_user_wallet')->insertGetId($wallet_content);
                }
            } else {
                $coupan_to_wallet = '0';
            }
        }

        $walletAmount = 0;
        if ($request->wallet_used != '' && $request->wallet_used > 0) {

            $wallet_content = [
                'userid'              => $userid,
                'refer_id'             => $userid,
                'order_currency'       => 'AED',
                'order_total'          => $order_total_new,
                'system_percentage'    => '',
                'wallet_amount'        => $request->wallet_used,
                'added_from'           => 1,
                'order_id'             => $order_number,
                'added_date'           => date('Y-m-d'),
            ];
            DB::table('front_user_wallet')->insertGetId($wallet_content);

            $walletAmount = $request->wallet_used;
        }

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


        $content = array(
            'user_id'               => $userid,
            'order_number'          => $order_number,
            'order_total'           => $order_total,
            'front_wallet_amount'   => $front_wallet_amount_new,
            'vatcharge'             => $vat_total,
            'order_currency'        => 'AED',
            'order_status'          => $order_status,
            'paymentmode'           => $paymentmode,
            'payment_status'        => $payment_status,
            'created_at'            => date('Y-m-d H:i:s'),
            'coupan_to_wallet'     => $coupan_to_wallet,
            'coupondiscount'     => $coupon_discounted,
            'coupon_code'     => $coupan_code_name,
            'list_order_status'     => $list_order_status,
            'service_charge'     => $request->service_charge,
            'promo_discount'     => $request->promo_discount,
            'cleaning_discount_additional'     => $cleaning_discount_additional,
            'timing_charge'     => $timing_charger,
            'additional_charge'     => "",
            'sub_total'     => $request->sub_total,
            'cod_charge'     => $request->cod_charge,
            'service_fee'     => $request->service_fee,
            'order_from'     => $order_from,
            'front_wallet_amount'  => $walletAmount,
            // 🔥 NEW FIELDS
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

        $monthName = $request->month;
        $dateObj = DateTime::createFromFormat('F', ucfirst(strtolower($monthName)));
        $monthNumber = $dateObj ? $dateObj->format('m') : null;

        $end_date = sprintf('%04d-%02d-%02d', date('Y'), $monthNumber, $request->date);
        $which_day_of_the_week_do_you_want_the_service = "";
        if ($request->how_often_do_you_need_cleaning == 'Once') {
            $formatted_date = sprintf('%04d-%02d-%02d', date('Y'), $monthNumber, $request->date);
            $end_date = $formatted_date;
            $which_day_of_the_week_do_you_want_the_service = date('l', strtotime($formatted_date));
        } elseif ($request->how_often_do_you_need_cleaning == 'Weekly') {
            $formatted_date = sprintf('%04d-%02d-%02d', date('Y'), $monthNumber, $request->date);
            $end_date = date('Y-m-d', strtotime($formatted_date . ' +1 year'));
            $which_day_of_the_week_do_you_want_the_service = date('l', strtotime($formatted_date));
        } elseif ($request->how_often_do_you_need_cleaning == 'Multiple times a week') {
            $formatted_date = sprintf('%04d-%02d-%02d', date('Y'), $monthNumber, $request->date);
            $end_date = date('Y-m-d', strtotime($formatted_date . ' +1 year'));

            $which_day_of_the_week_do_you_want_the_service = implode(', ', $request->which_day_of_the_week_do_you_want_the_service);
        } else {
            $end_date = $formatted_date;
        }

        $arrData = array(
            'order_id'                             => $arrOrderId,
            'user_info_id'                         => $userid,
            'cleaner_id'                           => $request->cleaner_id,
            'service_id'                           => $request->service_id,
            'subservice_id'                        => $request->subservice_id,
            'how_many_cleaners_do_you_need'        => $request->how_many_cleaners_do_you_need,
            'how_many_hours_should_they_stay'      => $request->how_many_hours_should_they_stay,
            'how_often_do_you_need_cleaning'       => $request->how_often_do_you_need_cleaning,
            'do_you_need_cleaning_material'        => $request->do_you_need_cleaning_material,
            'any_special_instruction'              => $request->any_special_instruction,
            'address_type'                         => $request->address_type,
            'city'                                 => $request->city,
            'area'                                 => $request->area,
            'building_street_no'                   => $request->building_street_no,
            'apartment_villa_no'                   => $request->apartment_villa_no,
            'bookingdate'                          => $request->date,
            'bookingyear'                          => date('Y'),
            'month'                                => $request->month,
            'time_slot'                            => $request->time_slot,
            'end_date'                            => $end_date,
            'which_day_of_the_week_do_you_want_the_service' => $which_day_of_the_week_do_you_want_the_service,
            'cdate'                                => date('Y-m-d'),
        );

        $order_item_id = DB::table('ci_order_item')->insertGetId($arrData);

        $cart_data = Session::get('addons_cart', []);

        if (count($cart_data) > 0) {
            foreach ($cart_data as $cart) {

                $arrData_addons = array(
                    'order_id'                        => $arrOrderId,
                    'order_item_id'                   => $order_item_id,
                    'user_info_id'                    => $userid,
                    'package_id'                      => $cart['options']['addon_id'],
                    'package_item_name'               => $cart['name'],
                    'package_quantity'                => $cart['qty'],
                    'package_item_price'              => $cart['price'],
                    'service_id'                      => $cart['options']['service_id'],
                    'service_name'                    => $cart['options']['service_name'],
                    'subservice_id'                   => $cart['options']['subservice_id'],
                    'subservice_name'                 => $cart['options']['subservice_name'],
                    //'page_url'                        => $arrRowDeailts->options->page_url,
                    'image'                           => $cart['options']['image'],
                    'discount'                        => $cart['options']['discount'],
                    'discount_type'                   => $cart['options']['discount_type'],
                    'product_discount_amount'         => round($cart['options']['product_discount_amount']),
                    'cdate'                           => date('Y-m-d'),
                    //'subservice_booking_percentage'   => $arrRowDeailts->options->subservice_booking_percentage,

                );

                DB::table('ci_order_item_addons')->insertGetId($arrData_addons);
            }
        }

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

        session()->forget('coupan_data');
        session()->forget('addons_cart');

        if ($payment_type == 'COD') {

            $success = $this->success_mail_book_now();
            $success_vendor = $this->success_mail_book_now_allvendor();
            if ($success) {
                // Redirect to the 'thankyou' route


                return redirect()->route('cleaning.thankyou_book_now');
            }
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
                'success_url' => route('payment_success'),
                'cancel_url' => route('payment_fail'),
            ]);

            // dd($response);
            // echo "dev".$response->id;
            if (isset($response->id) && $response->id != '') {

                Session::put('stripe_session_id', $response->id);


                return redirect($response->url);
            } else {
                return redirect()->route('payment_fail');
            }
        }
    }


    function book_now_package(Request $request)
    {

        $cart_data = Session::get('package_cart', []);
        $coupan_data = session('coupan_data');

        //echo"<pre>";print_r($coupan_data);echo"</pre>";exit;
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $userdata = Session::get('user');

        $payment_type = $request->payment_type;
        if ($payment_type == 'COD') {
            $order_status = 'BK';
            $paymentmode = 1;
            $list_order_status = '0';
            $payment_status = 'Success';
            $payment_mode = "COD";
        } elseif ($payment_type == 'TABBY') {
            $order_status = 'BK';
            $paymentmode = 3;
            $list_order_status = '0';
            $payment_status = 'FAILED';
            $payment_mode = "TABBY";
        } else {
            $order_status = 'BK';
            $paymentmode = 2;
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

        $order_from = 1;
        $order_total = $request->total_to_pay;
        $front_wallet_amount_new = 0;
        $vat_total = $request->vat_total;

        $cleaning_discount_additional = "";

        $timing_charger = $request->timing_charge;

        $coupan_to_wallet = '';
        $coupon_discounted = 0;
        $coupan_code_name = "";

        $order_total_new = $request->sub_total + $vat_total;

        if (Session::has('coupan_data')) {

            $coupan_code_name = $coupan_data['coupancode'];

            if ($coupan_data['coupan_apply_wallet'] == 0) {

                if ($coupan_data['discount'] != '' && $coupan_data['coupanvalue'] == 0) {
                    $coupon_discounted = ($order_total_new * $coupan_data['discount']) / 100;
                }
                if ($coupan_data['discount'] != '' && $coupan_data['coupanvalue'] == 1) {
                    $coupon_discounted = $coupan_data['discount'];
                }

                $wallet_content = [
                    'userid'              => $userid,
                    'refer_id'             => $userid,
                    'order_currency'       => 'AED',
                    'order_total'          => $order_total_new,
                    'system_percentage'    => '',
                    'wallet_amount'        => $coupon_discounted,
                    'added_from'           => 0,
                    'order_id'             => $order_number,
                    'added_date'           => date('Y-m-d'),
                ];
                DB::table('front_user_wallet')->insertGetId($wallet_content);

                $coupan_to_wallet = '1';
            } else {
                if ($coupan_data['discount'] != '' && $coupan_data['coupanvalue'] == 0) {
                    $coupon_discounted = ($order_total_new * $coupan_data['discount']) / 100;
                }
                if ($coupan_data['discount'] != '' && $coupan_data['coupanvalue'] == 1) {
                    $coupon_discounted = $coupan_data['discount'];
                }
                $coupan_to_wallet = '0';
            }
        }

        $walletAmount = 0;
        if ($request->wallet_used != '' && $request->wallet_used > 0) {

            $wallet_content = [
                'userid'              => $userid,
                'refer_id'             => $userid,
                'order_currency'       => 'AED',
                'order_total'          => $order_total_new,
                'system_percentage'    => '',
                'wallet_amount'        => $request->wallet_used,
                'added_from'           => 1,
                'order_id'             => $order_number,
                'added_date'           => date('Y-m-d'),
            ];
            DB::table('front_user_wallet')->insertGetId($wallet_content);

            $walletAmount = $request->wallet_used;
        }

        // echo $request->sub_total."<br>";
        // echo $order_total."<br>";
        // echo $coupon_discounted."<br>";

        // exit;

        /* ---------------- SERVICE & CITY CODE ---------------- */

        $subservice_id = $request->subservice_id;
        $cityData = DB::table('cities')->where('name', $request->city)->first();
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
            'order_total'           => $order_total,
            'front_wallet_amount'   => $front_wallet_amount_new,
            'vatcharge'             => $vat_total,
            'order_currency'        => 'AED',
            'order_status'          => $order_status,
            'paymentmode'           => $paymentmode,
            'payment_status'        => $payment_status,
            'created_at'            => date('Y-m-d H:i:s'),
            'coupan_to_wallet'     => $coupan_to_wallet,
            'coupondiscount'     => $coupon_discounted,
            'coupon_code'     => $coupan_code_name,
            'list_order_status'     => $list_order_status,
            'service_charge'     => $request->service_charge,
            'promo_discount'     => $request->promo_discount,
            'cleaning_discount_additional'     => $cleaning_discount_additional,
            'timing_charge'     => $timing_charger,
            'additional_charge'     => "",
            'sub_total'     => $request->sub_total,
            'cod_charge'     => $request->cod_charge,
            'service_fee'     => $request->service_fee,
            'order_from'     => $order_from,
            'front_wallet_amount'  => $walletAmount,
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

        $monthName = $request->month;
        $dateObj = DateTime::createFromFormat('F', ucfirst(strtolower($monthName)));
        $monthNumber = $dateObj ? $dateObj->format('m') : null;

        $end_date = sprintf('%04d-%02d-%02d', date('Y'), $monthNumber, $request->date);

        $arrData = array(
            'order_id'                             => $arrOrderId,
            'user_info_id'                         => $userid,
            'service_id'                           => $request->service_id,
            'subservice_id'                        => $request->subservice_id,
            'address_type'                         => $request->address_type,
            'city'                                 => $request->city,
            'area'                                 => $request->area,
            'building_street_no'                   => $request->building_street_no,
            'apartment_villa_no'                   => $request->apartment_villa_no,
            'emirates_id_number'                   => ($request->service_id == 54) ? $request->emirates_id_number : '',
            'passport_number'                   => ($request->service_id == 54) ? $request->passport_number : '',
            'bookingdate'                          => $request->date,
            'bookingyear'                          => date('Y'),
            'month'                                => $request->month,
            'time_slot'                            => $request->time_slot,
            'end_date'                            => $end_date,
            'cdate'                                => date('Y-m-d'),
        );

        $order_item_id = DB::table('ci_order_item')->insertGetId($arrData);
        // echo"<pre>";print_r($cart_data);echo"</pre>";exit;
        if (count($cart_data) > 0) {

            foreach ($cart_data as $cart) {

                if ($cart['type'] == 'package') {
                    $arrData_package = array(
                        'order_id'                        => $arrOrderId,
                        'order_item_id'                   => $order_item_id,
                        'user_info_id'                    => $userid,
                        'package_id'                      => $cart['id'],
                        'package_item_name'               => $cart['name'],
                        'package_quantity'                => $cart['qty'],
                        'package_item_price'              => $cart['price'],
                        'service_id'                      => $cart['options']['service_id'],
                        'service_name'                    => $cart['options']['service_name'],
                        'subservice_id'                   => $cart['options']['subservice_id'],
                        'subservice_name'                 => $cart['options']['subservice_name'],
                        'packagecategory_id'              => $cart['options']['packagecategory_id'],
                        'packagecategory_name'            => $cart['options']['packagecategory_name'],
                        //'page_url'                        => $arrRowDeailts->options->page_url,
                        'image'                           => $cart['options']['image'],
                        'discount'                        => $cart['options']['discount'],
                        'discount_type'                   => $cart['options']['discount_type'],
                        'product_discount_amount'         => round($cart['options']['product_discount_amount']),
                        'cdate'                           => date('Y-m-d'),
                        //'subservice_booking_percentage'   => $arrRowDeailts->options->subservice_booking_percentage,

                    );

                    DB::table('ci_order_item_packages')->insertGetId($arrData_package);
                } else {
                    $arrData_addons = array(
                        'order_id'                        => $arrOrderId,
                        'order_item_id'                   => $order_item_id,
                        'user_info_id'                    => $userid,
                        'package_id'                      => $cart['id'],
                        'package_item_name'               => $cart['name'],
                        'package_quantity'                => $cart['qty'],
                        'package_item_price'              => $cart['price'],
                        'service_id'                      => $cart['options']['service_id'],
                        'service_name'                    => $cart['options']['service_name'],
                        'subservice_id'                   => $cart['options']['subservice_id'],
                        'subservice_name'                 => $cart['options']['subservice_name'],
                        'packagecategory_id'              => $cart['options']['packagecategory_id'],
                        'packagecategory_name'            => $cart['options']['packagecategory_name'],
                        //'page_url'                        => $arrRowDeailts->options->page_url,
                        'image'                           => $cart['options']['image'],
                        'discount'                        => $cart['options']['discount'],
                        'discount_type'                   => $cart['options']['discount_type'],
                        'product_discount_amount'         => round($cart['options']['product_discount_amount']),
                        'cdate'                           => date('Y-m-d'),
                        //'subservice_booking_percentage'   => $arrRowDeailts->options->subservice_booking_percentage,

                    );

                    DB::table('ci_order_item_addons')->insertGetId($arrData_addons);
                }
            }
        }

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

        session()->forget('coupan_data');
        session()->forget('package_cart');

        if ($payment_type == 'COD') {

            $success = $this->success_mail_book_now();
            $success_vendor = $this->success_mail_book_now_allvendor();
            if ($success) {
                // Redirect to the 'thankyou' route
                if ($request->service_id == 45) {
                    return redirect()->route('cleaning.thankyou_book_now');
                } elseif ($request->service_id == 48) {
                    return redirect()->route('saloon_spa.thankyou_book_now');
                } elseif ($request->service_id == 34) {
                    return redirect()->route('hanyman.thankyou_book_now');
                } elseif ($request->service_id == 47) {
                    return redirect()->route('pest_control.thankyou_book_now');
                } else {
                    return redirect('thankyou_book_now');
                }
            }
        } elseif ($payment_type == 'TABBY') {
            $tabbyService = app(\App\Services\TabbyService::class);

            $bookingData = [
                'order_id' => $formatOrderId,
                'total_amount' => $order_total_new,
                'customer_phone' => $userdata['mobile'] ?? '',
                'customer_email' => $userdata['email'] ?? '',
                'customer_name' => $userdata['name'] ?? '',
                'tax_amount' => $vat_total,
                'items' => []
            ];

            $response = $tabbyService->createSession($bookingData);

            if ($response && isset($response['configuration']['available_products']['installments'][0]['web_url'])) {
                $paymentId = $response['payment']['id'] ?? '';

                try {
                    DB::table('ci_orders')->where('order_id', $arrOrderId)->update(['tabby_payment_id' => $paymentId]);
                } catch (\Exception $e) {
                    \Log::warning("Could not save tabby_payment_id, migration likely missing.", ['msg' => $e->getMessage()]);
                }

                return redirect($response['configuration']['available_products']['installments'][0]['web_url']);
            }
            return redirect()->route('payment_fail')->with('error', 'Tabby payment initialization failed.');
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
                'success_url' => route('payment_success'),
                'cancel_url' => route('payment_fail'),
            ]);

            // dd($response);
            // echo "dev".$response->id;
            if (isset($response->id) && $response->id != '') {

                Session::put('stripe_session_id', $response->id);


                return redirect($response->url);
            } else {
                return redirect()->route('payment_fail');
            }
        }
    }
}
