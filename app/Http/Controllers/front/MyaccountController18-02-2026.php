<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\front\Frontloginregister;
use Hash;
use DB;
use Session;
use DateTime;

use Carbon\Carbon;

use Symfony\Component\Mime\Email;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Str;
use App\Models\Admin\City;

class MyaccountController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function my_order(Request $request)
    {
        $userdata = Session::get('user');

        /* if (empty($userdata)) {
            return redirect()->to('/Sign-in');
        }

        $userid = $userdata['userid']; */

        if ($userdata == '') {

            $userid = null;
        } else {
            $userid = $userdata['userid'];
        }

        $perPage = 4;

        $baseQuery = DB::table('ci_orders')
            ->where('ci_orders.is_delete', '0')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->select('frontloginregisters.email as user_email', 'frontloginregisters.name as user_name', 'frontloginregisters.mobile as user_mobile', 'ci_orders.*')
            ->where('ci_orders.user_id', $userid)
            ->orderBy('ci_orders.order_id', 'DESC')
            ->get();

        $today = date('Y-m-d');

        // Split into upcoming and past collections
        $upcomingCollection = collect();
        $pastCollection = collect();

        foreach ($baseQuery as $order) {
            $items = DB::table('ci_order_item')->where('order_id', $order->order_id)->get();
            $order->items = $items;

            $total = 0;
            $latestEndDate = null;

            foreach ($items as $item) {
                $price = $item->product_discount_amount ?: $item->package_item_price;
                $total += $price * $item->package_quantity;

                if (!empty($item->end_date)) {
                    $end = date('Y-m-d', strtotime($item->end_date));
                    if (!$latestEndDate || $end > $latestEndDate) {
                        $latestEndDate = $end;
                    }
                }
            }

            $order->sub_total = $total;

            if ($latestEndDate && $latestEndDate > $today) {
                $upcomingCollection->push($order);
            } elseif ($latestEndDate && $latestEndDate <= $today) {
                $pastCollection->push($order);
            }
        }

        // Manual pagination using LengthAwarePaginator
        $upcomingPage = LengthAwarePaginator::resolveCurrentPage('upcoming_page');
        $pastPage = LengthAwarePaginator::resolveCurrentPage('past_page');

        $upcomingOrders = new LengthAwarePaginator(
            $upcomingCollection->forPage($upcomingPage, $perPage),
            $upcomingCollection->count(),
            $perPage,
            $upcomingPage,
            ['path' => url()->current(), 'pageName' => 'upcoming_page']
        );

        $pastOrders = new LengthAwarePaginator(
            $pastCollection->forPage($pastPage, $perPage),
            $pastCollection->count(),
            $perPage,
            $pastPage,
            ['path' => url()->current(), 'pageName' => 'past_page']
        );

        return view('front.my_order', [
            'upcomingOrders' => $upcomingOrders,
            'pastOrders' => $pastOrders,
            'activeTab' => $request->get('tab', 'upcoming')
        ]);
    }
    public function my_account()
    {
        $userdata = Session::get('user');

        if ($userdata == '') {

            $name = null;
        } else {
            $name = $userdata['name'];
        }

        $data['name'] = $name;

        return view('front.my_account', $data);
    }
    public function myleads(Request $request)
    {
        $userdata = Session::get('user');

        if ($userdata == '') {
            //return redirect()->to('/Sign-in');
            $mobile = null;
            $email = null;
        } else {
            $mobile = $userdata['mobile'];
            $email = $userdata['email'];
        }



        // Base queries for all three tables
        $packages = DB::table('packages_enquiry')
            ->select(
                'id',
                'name',
                'email',
                'mobile',
                'service_id',
                'subservice_id',
                'inquiry_id',
                DB::raw("'packages' as type"),
                'added_date'
            )
            ->where('email', $email)
            ->where('mobile', $mobile)
            ->where('service_id', '!=', 47);
        //->where('subservice_id', '!=', 77);


        $wooden = DB::table('wooden_floor_enquiry')
            ->select(
                'id',
                'name',
                'email',
                'mobile',
                'service_id',
                'subservice_id',
                'inquiry_id',
                DB::raw("'wooden' as type"),
                'added_date'
            )
            ->where('email', $email)
            ->where('mobile', $mobile);

        $painting = DB::table('painting_enquiry')
            ->select(
                'id',
                'name',
                'email',
                'mobile',
                'service_id',
                'subservice_id',
                'inquiry_id',
                DB::raw("'painting' as type"),
                'added_date'
            )
            ->where('email', $email)
            ->where('mobile', $mobile);

        $pcgarden = DB::table('packages_enquiry')
            ->select(
                'id',
                'name',
                'email',
                'mobile',
                'service_id',
                'subservice_id',
                'inquiry_id',
                DB::raw("'pcgarden' as type"),
                'added_date'
            )
            ->where('email', $email)
            ->where('mobile', $mobile)
            ->where('service_id', '=', 47);
        //->where('subservice_id', '!=', 77);

        // Combine all three using unionAll
        $unionQuery = $packages
            ->unionAll($wooden)
            ->unionAll($painting)
            ->unionAll($pcgarden);

        // Split between latest and past
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        // Latest Leads (within 30 days)
        $latestLeads = DB::query()
            ->fromSub($unionQuery, 'all_enquiries')
            ->where('added_date', '>=', $thirtyDaysAgo)
            ->orderByDesc('added_date')
            ->paginate(10, ['*'], 'latest_page');

        // Past Leads (older than 30 days)
        $pastLeads = DB::query()
            ->fromSub($unionQuery, 'all_enquiries')
            ->where('added_date', '<', $thirtyDaysAgo)
            ->orderByDesc('added_date')
            ->paginate(10, ['*'], 'past_page');


        $data['latestLeads'] = $latestLeads;
        $data['pastLeads'] = $pastLeads;

        //echo "<pre>";print_r($data);echo"</pre>";exit;
        return view('front.my_leads', $data);
    }

    public function myLeadDetail($type, $id)
    {
        $userdata = Session::get('user');

        /* if ($userdata == '') {
            return redirect()->to('/Sign-in');
        }

        $mobile = $userdata['mobile'];
        $email = $userdata['email']; */

        if ($userdata == '') {
            //return redirect()->to('/Sign-in');
            $mobile = null;
            $email = null;
        } else {
            $mobile = $userdata['mobile'];
            $email = $userdata['email'];
        }

        // Determine which table to use based on type
        switch ($type) {
            case 'packages':
                $lead = DB::table('packages_enquiry')->where('id', $id)->where('email', $email)->where('mobile', $mobile)->first();
                break;
            case 'wooden':
                $lead = DB::table('wooden_floor_enquiry')->where('id', $id)->where('email', $email)->where('mobile', $mobile)->first();
                break;
            case 'painting':
                $lead = DB::table('painting_enquiry')->where('id', $id)->where('email', $email)->where('mobile', $mobile)->first();
                break;
            case 'pcgarden':
                $lead = DB::table('packages_enquiry')->where('id', $id)->where('email', $email)->where('mobile', $mobile)->first();
                break;
            default:
                abort(404);
        }

        //echo "<pre>";print_r($lead);exit;

        /* if (!$lead) {
            abort(404);
        } */

        // Fetch accepted vendors if any
        $acceptedVendors = DB::table('package_inquiry_accepted')
            ->where('packages_inquiry_id', $id)
            ->get();

        $data['lead'] = $lead;
        $data['type'] = $type;



        $data['acceptedVendors'] = $acceptedVendors;

        return view('front.my_lead_detail', $data);
    }

    // function myleads_service($id){

    //     $data['subservices'] = DB::table('subservices')->where('serviceid',$id)->whereRaw('FIND_IN_SET(1, is_bookable)')->where('is_active',0)->get();
    //     return view('front.my_leads_services',$data);
    // }
    // function myleads_subservice($serviceid,$subserviceid){

    //     $userdata = Session::get('user');

    //     if($serviceid == 30 && $subserviceid == 23){ //apartment moving leads

    //         $data['packages_enquiry'] = DB::table('packages_enquiry')
    //                                         ->where('service_id',$serviceid)
    //                                         ->where('subservice_id',$subserviceid)
    //                                         ->where('mobile',$userdata['mobile'])
    //                                         ->where('email',$userdata['email'])
    //                                         ->orderBy('id','desc')
    //                                         ->get();
    //         return view('front.my_leads_moving_and_storage',$data);
    //     }elseif($serviceid == 30 && $subserviceid == 26){ //villa moving leads

    //         $data['packages_enquiry'] = DB::table('packages_enquiry')
    //                                         ->where('service_id',$serviceid)
    //                                         ->where('subservice_id',$subserviceid)
    //                                         ->where('mobile',$userdata['mobile'])
    //                                         ->where('email',$userdata['email'])
    //                                         ->orderBy('id','desc')
    //                                         ->get();
    //         return view('front.my_leads_moving_and_storage',$data);
    //     }elseif($serviceid == 30 && $subserviceid == 31){ //vehicle moving leads

    //         $data['packages_enquiry'] = DB::table('packages_enquiry')
    //                                         ->where('service_id',$serviceid)
    //                                         ->where('subservice_id',$subserviceid)
    //                                         ->where('mobile',$userdata['mobile'])
    //                                         ->where('email',$userdata['email'])
    //                                         ->orderBy('id','desc')
    //                                         ->get();
    //         return view('front.my_leads_moving_and_storage',$data);
    //     }elseif($serviceid == 30 && $subserviceid == 53){ //office moving leads

    //         $data['packages_enquiry'] = DB::table('packages_enquiry')
    //                                         ->where('service_id',$serviceid)
    //                                         ->where('subservice_id',$subserviceid)
    //                                         ->where('mobile',$userdata['mobile'])
    //                                         ->where('email',$userdata['email'])
    //                                         ->orderBy('id','desc')
    //                                         ->get();
    //         return view('front.my_leads_moving_and_storage',$data);
    //     }elseif($serviceid == 44 && $subserviceid == 61){ //self storage leads

    //         $data['packages_enquiry'] = DB::table('packages_enquiry')
    //                                         ->where('service_id',$serviceid)
    //                                         ->where('subservice_id',$subserviceid)
    //                                         ->where('mobile',$userdata['mobile'])
    //                                         ->where('email',$userdata['email'])
    //                                         ->orderBy('id','desc')
    //                                         ->get();
    //         return view('front.my_leads_moving_and_storage',$data);
    //     }elseif($serviceid == 44 && $subserviceid == 62){ //ac storage leads

    //         $data['packages_enquiry'] = DB::table('packages_enquiry')
    //                                         ->where('service_id',$serviceid)
    //                                         ->where('subservice_id',$subserviceid)
    //                                         ->where('mobile',$userdata['mobile'])
    //                                         ->where('email',$userdata['email'])
    //                                         ->orderBy('id','desc')
    //                                         ->get();
    //         return view('front.my_leads_moving_and_storage',$data);
    //     }elseif($serviceid == 44 && $subserviceid == 64){ //non ac storage leads

    //         $data['packages_enquiry'] = DB::table('packages_enquiry')
    //                                         ->where('service_id',$serviceid)
    //                                         ->where('subservice_id',$subserviceid)
    //                                         ->where('mobile',$userdata['mobile'])
    //                                         ->where('email',$userdata['email'])
    //                                         ->orderBy('id','desc')
    //                                         ->get();
    //         return view('front.my_leads_moving_and_storage',$data);
    //     }elseif($serviceid == 44 && $subserviceid == 66){ //vehicle storage leads

    //         $data['packages_enquiry'] = DB::table('packages_enquiry')
    //                                         ->where('service_id',$serviceid)
    //                                         ->where('subservice_id',$subserviceid)
    //                                         ->where('mobile',$userdata['mobile'])
    //                                         ->where('email',$userdata['email'])
    //                                         ->orderBy('id','desc')
    //                                         ->get();
    //         return view('front.my_leads_moving_and_storage',$data);
    //     }elseif($serviceid == 34 && $subserviceid == 47){ //painting leads

    //         $data['packages_enquiry'] = DB::table('painting_enquiry')
    //                                         ->where('service_id',$serviceid)
    //                                         ->where('subservice_id',$subserviceid)
    //                                         ->where('mobile',$userdata['mobile'])
    //                                         ->where('email',$userdata['email'])
    //                                         ->orderBy('id','desc')
    //                                         ->get();
    //         return view('front.my_leads_moving_and_storage',$data);
    //     }elseif($serviceid == 34 && $subserviceid == 89){ //woodel floor leads

    //         $data['packages_enquiry'] = DB::table('wooden_floor_enquiry')
    //                                         ->where('service_id',$serviceid)
    //                                         ->where('subservice_id',$subserviceid)
    //                                         ->where('mobile',$userdata['mobile'])
    //                                         ->where('email',$userdata['email'])
    //                                         ->orderBy('id','desc')
    //                                         ->get();
    //         return view('front.my_leads_moving_and_storage',$data);
    //     }

    //     //echo "<pre>";print_r($data);echo"</pre>";exit;


    // }




    public function refer_earn(Request $request)
    {


        Session::put('refer_earn_flag', 1);
        $lastReferringUrl = $request->server('HTTP_REFERER');

        $explodedUrls = explode('/', $lastReferringUrl);
        $endUrl = end($explodedUrls);

        if ($endUrl != 'register') {

            if (Session::get('redirect_url') != '') {
                Session::put('redirect_url', Session::get('redirect_url'));
            } else {
                Session::put('redirect_url', $request->server('HTTP_REFERER'));
            }
        }


        $userdata = Session::get('user');

        /* if($userdata == ''){
            return redirect()->to('/Sign-in');
        } */

        if ($userdata == '') {

            $userid = null;
        } else {
            $userid = $userdata['userid'];
        }

        $data['userid'] = $userid;


        return view('front.refer_earn', $data);
    }

    public function refral()
    {
        $userdata = Session::get('user');

        if ($userdata == '') {

            $userid = 0;
        } else {
            $userid = $userdata['userid'];
        }

        $data['userid'] = $userid;

        return view('front.refers', $data);
    }

    public function refer_earn_frend($userId)
    {
        //echo $userId;exit;
        $decryptedId = base64_decode($userId);

        // echo $decryptedId;exit;

        return view('front.frontloginregister', ['decryptedId' => $decryptedId]);
    }

    public function my_profile()
    {
        $userData = Session::get('user');

        /* if($userData == ''){
            return redirect()->to('/Sign-in');
        }

      $userid = $userData['userid']; */

        if ($userData == '') {

            $userid = null;
        } else {
            $userid = $userData['userid'];
        }

        $data['user_data'] =  DB::table('frontloginregisters')->where('id', $userid)->first();

        //echo "<pre>";print_r($data);echo"</pre>";exit;

        return view('front.my_profile', $data);
    }

    public function edit_profile()
    {
        $userdata = Session::get('user');

        if ($userdata == '') {

            $userid = null;
        } else {
            $userid = $userdata['userid'];
        }


        if (request()->input('action') == 'update_profile') {


            /* $userdata = Session::get('user');
         $userid = $userdata['userid']; */

            $data['name'] = request()->input('fname');
            $data['mobile'] = request()->input('mobile');

            $result = DB::table('frontloginregisters')
                ->where('id', $userid)
                ->update($data);

            return redirect()->to('/my-profile')->with('L_strsucessMessage', 'Profile Updated Successfully');

            //echo "<pre>";print_r($data);echo"</pre>";exit;
        }



        $data['user_data'] =  DB::table('frontloginregisters')->where('id', $userid)->first();

        return view('front.edit_profile', $data);
    }
    public function my_wallet()
    {
        /* $userdata = Session::get('user');

        if($userdata == ''){
            return redirect()->to('/Sign-in');
        } */

        $userData = Session::get('user');
        if ($userData == '') {

            $userid = null;
        } else {
            $userid = $userData['userid'];
        }

        $data['wallet_plus_amount'] = DB::table('front_user_wallet')
            ->where('refer_id', $userid)
            ->where('added_from', 0)
            ->sum('wallet_amount');

        $data['wallet_minus_amount'] = DB::table('front_user_wallet')
            ->where('refer_id', $userid)
            ->where('added_from', 1)
            ->sum('wallet_amount');

        return view('front.my_wallet', $data);
    }
    public function order_detail()
    {

        $userdata = Session::get('user');

        if ($userdata == '') {

            return redirect()->to('/Sign-in');
        }



        $userid = $userdata['userid'];



        $query = DB::table('ci_orders')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->leftJoin('ci_shipping_address', 'ci_orders.order_id', '=', 'ci_shipping_address.order_id')
            ->select('frontloginregisters.email as user_email', 'frontloginregisters.name as user_name', 'frontloginregisters.mobile as user_mobile',  'ci_orders.*',  'ci_shipping_address.*');



        $query->where('ci_orders.user_id', $userid);


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

                if ($item->product_discount_amount != 0 && $item->product_discount_amount != '') {
                    $product_item_price = $item->product_discount_amount;
                } else {
                    $product_item_price = $item->package_item_price;
                }

                $total += $product_item_price * $item->package_quantity;
            }

            $order->items = $itemList;
            $order->sub_total = $total;
        }

        $orderList;

        $data['orders_list'] = $orderList;

        // echo "<pre>";print_r($data);echo"</pre>";exit;
        return view('front.order_detail', $data);
    }
    public function order_details($id)
    {
        /*  $userdata = Session::get('user');

if (empty($userdata)) {
    return redirect()->to('/Sign-in');
} */

        //$userid = $userdata['userid'];

        // Fetch the specific order with user and shipping info
        $query = DB::table('ci_orders')
            ->leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->leftJoin('ci_shipping_address', 'ci_orders.order_id', '=', 'ci_shipping_address.order_id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'ci_orders.*',
                'ci_shipping_address.*'
            )
            //->where('ci_orders.user_id', $userid)
            ->where('ci_orders.order_id', $id)
            ->first();

        if (!$query) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        // Fetch items for the order
        $itemList = DB::table('ci_order_item')
            ->where('order_id', $query->order_id)
            ->get();

        $total = 0;
        $latestEndDate = null;
        $today = date('Y-m-d');

        foreach ($itemList as $item) {
            // Get product details
            $product = DB::table('packages')
                ->where('id', $item->package_id)
                ->first();

            // Calculate item price (considering discount)
            $product_item_price = ($item->product_discount_amount != 0 && $item->product_discount_amount != '')
                ? $item->product_discount_amount
                : $item->package_item_price;

            $total += $product_item_price * $item->package_quantity;

            // Determine latest end date
            if (!empty($item->end_date)) {
                $end = date('Y-m-d', strtotime($item->end_date));
                if (!$latestEndDate || $end > $latestEndDate) {
                    $latestEndDate = $end;
                }
            }
        }

        // Determine if order is upcoming or past
        if ($latestEndDate) {
            if ($latestEndDate >= $today) {
                $query->dateorder_status = 'upcoming';
            } else {
                $query->dateorder_status = 'past';
            }
        } else {
            $query->dateorder_status = 'unknown'; // fallback if no end_date is set
        }

        $query->items = $itemList;
        // $query->sub_total = $total;

        // Return to view
        $data['orders'] = $query;

        // echo"<pre>";print_r($data);echo"</pre>";exit;

        $data['redirectUrl'] = route('order-detail', ['id' => $id]);

        return view('front.order_detail', $data);
    }


    function cancelpackage($id)
    {

        // echo $id;exit;

        $data_u['is_return'] = 1;

        $orderdata = DB::table('ci_order_item')->where('id', $id)->update($data_u);

        return redirect()->to('/my-order')->with('L_strsucessMessage', 'Package Cancel Successfully');
    }

    function update_instruction()
    {
        // echo"<pre>";print_r($_POST);echo"</pre>";exit;
        $order_id = $_POST['order_id'];
        $edit_instruction = $_POST['edit_instruction'];

        DB::table('ci_order_item')->where('order_id', $order_id)->update([
            'any_special_instruction' => $edit_instruction
        ]);

        return redirect('/order-detail/' . $order_id);
    }

    function update_address()
    {

        // echo"<pre>";print_r($_POST);echo"</pre>";exit;
        $order_id = $_POST['order_id'];
        $city = $_POST['city'];
        $area = $_POST['area'];
        $building_street_no = $_POST['building_street_no'];
        $apartment_villa_no = $_POST['apartment_villa_no'];

        DB::table('ci_order_item')->where('order_id', $order_id)->update([
            'city' => $city,
            'area' => $area,
            'building_street_no' => $building_street_no,
            'apartment_villa_no' => $apartment_villa_no,
        ]);

        return redirect('/order-detail/' . $order_id);
    }

    function cancel_order()
    {
        $order_id = $_POST['order_id'];

        if ($order_id) {
            DB::table('ci_orders')->where('order_id', $order_id)->update([
                'order_status' => 'CL',
                'cancel_date_time' => Carbon::now('Asia/Dubai')->toDateTimeString(),
            ]);

            DB::table('ci_order_item')->where('order_id', $order_id)->update([
                'end_date' => Carbon::now('Asia/Dubai')->toDateString(),
            ]);

            $this->whatsappmsg_tmp_cancellation_vc($order_id);
        }
        return redirect('/order-detail/' . $order_id);
    }

    function whatsappmsg_tmp_cancellation_vc($order_id)
    {


        $orderdata = DB::table('ci_orders')->where('order_number', $order_id)->first();
        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_id)->get();
        $user_data = DB::table('frontloginregisters')->where('id', $orderdata->user_id)->first();

        $date = $order_item_data[0]->bookingdate ?? "";
        $month = $order_item_data[0]->month ?? "";
        $year = $order_item_data[0]->bookingyear ?? "";

        if ($date != '' && $month != '' && $year != '') {
            $booking_date = $month . ' ' . $date . ', ' . $year;
        } else {
            $booking_date = "-";
        }

        $phone = $user_data->country_code . '' . $user_data->mobile;

        $service_name = Helper::servicename($order_item_data[0]->service_id);

        if ($user_data->country_code != '' && $user_data->mobile != '') {

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
                CURLOPT_POSTFIELDS => '{"messages":[{"to":"' . $phone . '","content":{"templateName":"cancellation_vc","language":"en","templateData":{"body":{"placeholders":["' . $service_name . '","' . $booking_date . '"]},"buttons":[{"type":"URL"}]}}}]}',
                CURLOPT_HTTPHEADER => array(
                    'accept: application/json',
                    'content-type: application/json',
                    'Authorization: key_uTZeOXQPMd'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
        }
    }

    function reschedule($id)
    {

        $data['ci_orders'] = DB::table('ci_orders')->where('order_id', $id)->first();

        $data['ci_order_item'] = DB::table('ci_order_item')->where('order_id', $id)->first();

        // echo"<pre>";print_r($data['ci_order_item']);echo"</pre>";exit;

        return view('front.reschedule', $data);
    }

    function reschedule_from(Request $request)
    {

        // Ci_orders_data update Step Start
        $orderId = '';
        $monthName = $request->ci_month;
        $dateObj = DateTime::createFromFormat('F', ucfirst(strtolower($monthName)));
        $monthNumber = $dateObj ? $dateObj->format('m') : null;
        $formatted_date = sprintf('%04d-%02d-%02d', date('Y'), $monthNumber, $request->ci_date);

        $old_order_data = DB::table('ci_orders')->where('order_id', $request->old_order_id)->first();

        $old_ci_order_item_data = DB::table('ci_order_item')->where('order_id', $request->old_order_id)->first();




        // Ci_orders_item_data Update Step Start


        /* echo"<pre>";print_r($old_ci_order_item_data);echo"</pre>";
      echo"<pre>";print_r($request->all());echo"</pre>";exit; */
        if ($request->ci_subservice_id != "") {



            if (
                $old_ci_order_item_data->how_often_do_you_need_cleaning == 'Once' || $request->ci_subservice_id == 70 || $request->ci_subservice_id == 29 ||
                $request->ci_subservice_id == 71 || $request->ci_subservice_id == 72 ||
                $request->ci_subservice_id == 73 || $request->ci_subservice_id == 79 ||
                $request->ci_subservice_id == 80 || $request->ci_subservice_id == 81 ||
                $request->ci_subservice_id == 82 || $request->ci_subservice_id == 83 ||
                $request->ci_subservice_id == 84 || $request->ci_subservice_id == 85 ||
                $request->ci_subservice_id == 86 || $request->ci_subservice_id == 87 ||
                $request->ci_subservice_id == 88
            ) {

                $formatted_date = sprintf('%04d-%02d-%02d', date('Y'), $monthNumber, $request->ci_date);
                $end_date = $formatted_date;
                $which_day_of_the_week_do_you_want_the_service = date('l', strtotime($formatted_date));

                // echo"<pre>";print_r($request->all());echo"</pre>";exit;
                $ci_order_data = DB::table('ci_order_item')->where('order_id', $request->old_order_id)->update([
                    'which_day_of_the_week_do_you_want_the_service' => $which_day_of_the_week_do_you_want_the_service,
                    'bookingdate'            => $request->ci_date,
                    'cleaner_id'             => $request->ci_cleaner_id,
                    'bookingyear'            => date('Y'),
                    'month'                  => $request->ci_month,
                    'time_slot'              => $request->time_slot,
                    'end_date'               => $end_date,
                ]);
            } else {

                if ($old_ci_order_item_data->how_often_do_you_need_cleaning == 'Weekly' ||   $old_ci_order_item_data->how_often_do_you_need_cleaning == 'Multiple times a week') {

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



                    $formatted_date = sprintf('%04d-%02d-%02d', date('Y'), $monthNumber, $request->ci_date);
                    $end_date = date('Y-m-d', strtotime($formatted_date . ' +1 year'));
                    $which_day_of_the_week_do_you_want_the_service = date('l', strtotime($formatted_date));


                    $subserviceData = DB::table('subservices')->where('id', $request->ci_subservice_id)->first();

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
                        ->lockForUpdate()
                        ->max('sequence_no');

                    $nextSequence = $lastSequence ? $lastSequence + 1 : 1;

                    $formatOrderId = sprintf(
                        "%s-%s-%s-%06d",
                        $subserviceCode,
                        $year,
                        $cityCode,
                        $nextSequence
                    );



                    $ci_order_data = DB::table('ci_order_item')->where('order_id', $request->old_order_id)->update(['end_date' => $formatted_date,]);

                    $content = array(
                        'user_id'               => $old_order_data->user_id,
                        'order_number'          => $order_number,
                        'order_total'           => $old_order_data->order_total,
                        'front_wallet_amount'   => $old_order_data->front_wallet_amount,
                        'vatcharge'             => $old_order_data->vatcharge,
                        'order_currency'        => 'AED',
                        'order_status'          => $old_order_data->order_status,
                        'paymentmode'           => $old_order_data->paymentmode,
                        'payment_status'        => $old_order_data->payment_status,
                        'created_at'            => date('Y-m-d H:i:s'),
                        'coupan_to_wallet'     => $old_order_data->coupan_to_wallet,
                        'coupondiscount'     => $old_order_data->coupondiscount,
                        'coupon_code'     => $old_order_data->coupon_code,
                        'list_order_status'     => $old_order_data->list_order_status,
                        'service_charge'     => $old_order_data->service_charge,
                        'promo_discount'     => $old_order_data->promo_discount,
                        'cleaning_discount_additional' => $old_order_data->cleaning_discount_additional,
                        'timing_charge'     => $old_order_data->timing_charge,
                        'additional_charge'     => $old_order_data->additional_charge,
                        'sub_total'     => $old_order_data->sub_total,
                        'cod_charge'     => $old_order_data->cod_charge,
                        'service_fee'     => $old_order_data->service_fee,
                        'order_from'     => $old_order_data->order_from,
                        // 🔥 NEW FIELDS
                        'subservice_code'       => $subserviceCode,
                        'city_code'             => $cityCode,
                        'order_year'            => $year,
                        'sequence_no'           => $nextSequence,
                        'format_order_id'       => $formatOrderId,
                    );

                    $arrOrderId = DB::table('ci_orders')->insertGetId($content);

                    $year = date('y');
                    $data_u['format_order_id'] = $formatOrderId;
                    DB::table('ci_orders')->where('order_id', $arrOrderId)->update($data_u);
                    Session::put('format_order_id', $formatOrderId);

                    $arrData = array(
                        'order_id'                             => $arrOrderId,
                        'user_info_id'                         => $old_ci_order_item_data->user_info_id,
                        'cleaner_id'                           => $request->ci_cleaner_id,
                        'service_id'                           => $old_ci_order_item_data->service_id,
                        'subservice_id'                        => $old_ci_order_item_data->subservice_id,
                        'how_many_cleaners_do_you_need'        => $old_ci_order_item_data->how_many_cleaners_do_you_need,
                        'how_many_hours_should_they_stay'      => $old_ci_order_item_data->how_many_hours_should_they_stay,
                        'how_often_do_you_need_cleaning'       => $old_ci_order_item_data->how_often_do_you_need_cleaning,
                        'do_you_need_cleaning_material'        => $old_ci_order_item_data->do_you_need_cleaning_material,
                        'any_special_instruction'              => $old_ci_order_item_data->any_special_instruction,
                        'address_type'                         => $old_ci_order_item_data->address_type,
                        'city'                                 => $old_ci_order_item_data->city,
                        'area'                                 => $old_ci_order_item_data->area,
                        'building_street_no'                   => $old_ci_order_item_data->building_street_no,
                        'apartment_villa_no'                   => $old_ci_order_item_data->apartment_villa_no,
                        'bookingdate'                          => $request->ci_date,
                        'bookingyear'                          => date('Y'),
                        'month'                                => $request->ci_month,
                        'time_slot'                            => $request->time_slot,
                        'end_date'                            => $end_date,
                        'which_day_of_the_week_do_you_want_the_service' => $which_day_of_the_week_do_you_want_the_service,
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
                    $data['user_id'] = $old_ci_order_item_data->user_info_id;


                    $orderId = $arrOrderId;

                    DB::table('ci_shipping_address')->insert($data);
                }

                // return redirect('/order-detail/'.$order_number);
            }

            $this->reschedule_mail_book_now($orderId);

            $this->success_mail_book_now();
            $this->whatsappmsg_tmp_reschedule_vc($orderId);

            return redirect('/order-detail/' . $request->old_order_id);
        }
    }

    function whatsappmsg_tmp_reschedule_vc($order_id)
    {

        $orderdata = DB::table('ci_orders')->where('order_number', $order_id)->first();

        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_id)->get();

        $user_data = DB::table('frontloginregisters')->where('id', $orderdata->user_id)->first();

        $date = $order_item_data[0]->bookingdate ?? "";
        $month = $order_item_data[0]->month ?? "";
        $year = $order_item_data[0]->bookingyear ?? "";

        if ($date != '' && $month != '' && $year != '') {
            $booking_date = $month . ' ' . $date . ', ' . $year;
        } else {
            $booking_date = "-";
        }

        $booking_time = \Helper::timeslotname(strval($order_item_data[0]->time_slot));


        $phone = $user_data->country_code . '' . $user_data->mobile;

        $url = $order_id;

        if ($user_data->country_code != '' && $user_data->mobile != '') {

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
                CURLOPT_POSTFIELDS => '{"messages":[{"to":"' . $phone . '","content":{"templateName":"reschedule_vc","language":"en","templateData":{"body":{"placeholders":["' . $booking_date . '","' . $booking_time . '"]},"buttons":[{"type":"URL","parameter":"{{' . $url . '}}"}]}}}]}',
                CURLOPT_HTTPHEADER => array(
                    'accept: application/json',
                    'content-type: application/json',
                    'Authorization: key_uTZeOXQPMd'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
        }
    }

    public function success_mail_book_now()
    {

        $userdata = Session::get('user');

        $order_number = Session::get('order_number');
        $format_order_id = Session::get('format_order_id');

        $orderdata = DB::table('ci_orders')->where('order_id', $order_number)->first();

        Session::put('order_payment_mode', $orderdata->paymentmode);

        if ($orderdata->paymentmode == 1) {
            $payment_mode = "Cash On Delivery";
        } else {
            $payment_mode = "Online Payment";
        }

        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_number)->first();
        // echo"<pre>";print_r($order_item_data);echo"</pre>";exit;


        $service_name = \Helper::subservicename(strval($order_item_data->subservice_id));

        Session::put('book_now_subservice_name_session', $service_name);

        if ($order_item_data->how_often_do_you_need_cleaning != '') {
            $service_mail = $service_name . " - " . $order_item_data->how_often_do_you_need_cleaning . " for " . $order_item_data->how_many_hours_should_they_stay . " hours " . $order_item_data->how_many_cleaners_do_you_need . " cleaner(s)";

            $order_item_package_data = array();
        }

        //echo"<pre>";print_r($order_item_package_data);echo"</pre>";exit;

        if ($order_item_data->which_day_of_the_week_do_you_want_the_service != '') {
            $when = $order_item_data->which_day_of_the_week_do_you_want_the_service . ", " . $order_item_data->bookingdate . " " . $order_item_data->month . " " . $order_item_data->bookingyear . ", from " . $order_item_data->time_slot;
        } else {
            $when = $order_item_data->bookingdate . " " . $order_item_data->month . ", " . $order_item_data->bookingyear;
        }

        $Where = $order_item_data->city . ", " . $order_item_data->area . ", " . $order_item_data->building_street_no . ", " . $order_item_data->apartment_villa_no;

        $total = $orderdata->sub_total * 5 / 100;
        $total = floor($total);

        $user_name = $userdata['name'];
        $user_email = $userdata['email'];


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
                                <p>Thank you for choosing VendorsCity! We\'re pleased to confirm your ' . $service_name . ' cleaning service booking</p>

                            <!--<p>A Super Cleaner is:</p>
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
                                <p>Our professional cleaning team will arrive promptly at the scheduled time, equipped with everything needed to leave your 
                                ' . $service_name . ' spotless.</p>';

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

            $message_bodyy .= '<h5 style="font-size: 14px;margin: 0;">Important Notes:</h5> 
                            <ul><li>
                            Please ensure someone is available at home to grant access to our team.</li>
                            <li>If you need to reschedule or have any special instructions, don\'t hesitate to reach out to us at 056 836 3677 or <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a>.</li>
                            <li>Charges may apply for last minute cancellations or rescheduling of service.</li>
                            </ul>
                            <p>We are excited to deliver an exceptional service experience for you.</p>

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

            $subject = " Confirmation of Your $service_name Service Booking .'$orderdata->format_order_id'. ";

            $to = $user_email;
            //$to = 'devang.hnrtechnologies@gmail.com';
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
        }
    }


    public function reschedule_mail_book_now($orderId)
    {

        $userdata = Session::get('user');

        $order_number = Session::get('order_number');
        $format_order_id = Session::get('format_order_id');

        $orderdata = DB::table('ci_orders')->where('order_id', $order_number)->first();

        Session::put('order_payment_mode', $orderdata->paymentmode);

        if ($orderdata->paymentmode == 1) {
            $payment_mode = "Cash On Delivery";
        } else {
            $payment_mode = "Online Payment";
        }

        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_number)->first();
        // echo"<pre>";print_r($order_item_data);echo"</pre>";exit;


        $service_name = \Helper::subservicename(strval($order_item_data->subservice_id));

        Session::put('book_now_subservice_name_session', $service_name);

        if ($order_item_data->how_often_do_you_need_cleaning != '') {
            $service_mail = $service_name . " - " . $order_item_data->how_often_do_you_need_cleaning . " for " . $order_item_data->how_many_hours_should_they_stay . " hours " . $order_item_data->how_many_cleaners_do_you_need . " cleaner(s)";

            $order_item_package_data = array();
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
            <div class="wrapper">

                <div class="logo">
                    <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '" style="width:40%;">
                </div>

                <div class="email_wrapper">
                    <p><strong>Dear ' . $user_name . ',</strong></p>

                    <p>Your booking has been rescheduled to <strong>' . $when .  \Helper::timeslotname($order_item_data->time_slot) . '</strong>, as requested.</p>

                    <div style="font-weight:bold;font-size:20px;margin-top:30px;">
                        Here are the details of your service:
                    </div>
                    <hr>

                    <p><strong>Service Type:</strong> ' . $service_name . '</p>
                    <p><strong>Date:</strong> ' . $when . '</p>
                    <p><strong>Time:</strong> ' . \Helper::timeslotname($order_item_data->time_slot) . '</p>';

            if ($order_item_data->subservice_id == 28) {
                $message_bodyy .= '
                        <p><strong>No. of Cleaners:</strong> ' . $order_item_data->how_many_cleaners_do_you_need . ' Cleaner(s)</p>
                        <p><strong>No. of Hours:</strong> ' . $order_item_data->how_many_hours_should_they_stay . ' Hours</p>
                        <p><strong>Frequency:</strong> ' . $order_item_data->how_often_do_you_need_cleaning . '</p>
                        <p><strong>Material:</strong> ' . $order_item_data->do_you_need_cleaning_material . '</p>';
            }

            $message_bodyy .= '
                    <p><strong>Address:</strong> ' . $Where . '</p>

                    <p>
                        Our professional cleaning team will arrive promptly at the scheduled time,
                        equipped with everything needed to leave your ' . $service_name . ' spotless.
                    </p>

                    <h5>Important Notes:</h5>
                    <ul>
                        <li>Please ensure someone is available to grant access.</li>
                        <li>
                            If you need to reschedule, contact
                            <a href="mailto:support@vendorscity.com">support@vendorscity.com</a>
                            or call 056 836 3677.
                        </li>
                        <li>Charges may apply for last-minute changes.</li>
                    </ul>

                    <p>We are excited to deliver an exceptional service experience for you.</p>

                    <div class="email_footer">
                        <h3>The VendorsCity Team</h3>

                        <div style="display:flex;">
                            <div style="width:100px;">
                                <img src="' . asset("public/site/images/vcfaviconwap.png") . '" style="width:70%;">
                            </div>
                            <div style="margin-left:10px;">
                                <p>Questions? Email <a href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                                <p>VendorsCity Portal LLC</p>
                                <a href="' . url("/terms-of-service") . '">Terms of Use</a><br>
                                <a href="' . url("/privacy-policy") . '">Privacy Policy</a><br>
                                <a href="' . url("/contact") . '">Contact Us</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </body>
            </html>';





            $subject = " Reschedule of Your $service_name Service Booking .'$orderdata->format_order_id'. ";

            $to = $user_email;
            //$to = 'devang.hnrtechnologies@gmail.com';
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
        }
    }
}
