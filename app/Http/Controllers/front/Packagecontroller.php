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
use Illuminate\Support\Facades\Crypt;
use DateTime;
use Helper;
use Str;
use App\Models\Admin\City;
use App\Models\Admin\Service;
use App\Models\Admin\Subservice;
use Illuminate\Support\Facades\Cache;

class Packagecontroller extends Controller
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

    public function package_lists(Request $request, $city = '', $page_url = '')
    {



        $formattedCity = ucwords(str_replace('-', ' ', $city));

        $city = DB::table('cities')->where('name', $formattedCity)->first();
        $cityId = $city->id ?? null;


        $subservices_data = DB::table('subservices')->where('page_url', $page_url)->first();
        $service_data = $subservices_data ? $subservices_data->serviceid : null;


        //  echo"<pre>";
        // print_r($request->search_city);
        // echo"</pre>";
        // exit;

        $cartItems = Cart::content();

        foreach ($cartItems as $item) {
            if ($item->options->subservice_id != $subservices_data->id) {
                // Remove items belonging to other subservices
                Cart::remove($item->rowId);
            }
        }

        $package_cart = session()->get('package_cart', []);
        $filtered_package_cart = [];
        foreach ($package_cart as $id => $item) {
            if (isset($item['subservice_id']) && $item['subservice_id'] == $subservices_data->id) {
                $filtered_package_cart[$id] = $item;
            }
        }
        session()->put('package_cart', $filtered_package_cart);

        $addons_cart = session()->get('addons_cart', []);
        $filtered_addons_cart = [];
        foreach ($addons_cart as $id => $item) {
            if (isset($item['subservice_id']) && $item['subservice_id'] == $subservices_data->id) {
                $filtered_addons_cart[$id] = $item;
            }
        }
        session()->put('addons_cart', $filtered_addons_cart);

        $coupan_data = session::get('coupan_data');

        if (session()->has('coupan_data')) {
            // echo "<pre>";print_r($coupan_data);echo "</pre>";exit;
            if ($coupan_data['sub_service'] != $subservices_data->id) {
                // echo"in";exit;
                session()->forget('coupan_data');
            }
        }


        $data['banner_subservices'] = DB::table('subservices')->where('page_url', $page_url)->first();

        $search_city_id = session('search_city_id');

        $query = DB::table('packages')
            ->select('packages.*', 'services.id as ser_id', 'services.servicename as ser_name', 'services.title as ser_title', 'services.sub_title as ser_sub_title')
            ->leftJoin('services', 'packages.service_id', '=', 'services.id')
            ->where(function ($query) use ($search_city_id) {
                $query->whereRaw('FIND_IN_SET(?, services.city)', [$search_city_id])
                    ->orWhereNull('services.city');
            });

        if ($subservices_data != '') {

            if ($subservices_data != '') {
                $query = $query->where('subservice_id', $subservices_data->id);
            }
            //  $pagination = DB::table('packages')->where('subservice_id', $subservices_data->id)->orderBy('id', 'desc')->paginate(2);

            if ($request->get('filter_price_start') !== null && $request->get('filter_price_end') !== null) {
                $filter_price_start = $request->get('filter_price_start');
                $filter_price_end = $request->get('filter_price_end');

                if ($filter_price_start > 0 && $filter_price_end > 0) {

                    $query = $query->whereBetween('price', [$filter_price_start, $filter_price_end]);
                }
            }

            $package_cat_ids = $request->get('package_cat');
            if ($package_cat_ids !== null && $request->get('package_cat') !== null) {

                $query = $query->whereIn('packagecategory_id', $package_cat_ids);
                $data['package_cat_ids'] = implode(",", $package_cat_ids);
            } else {
                $data['package_cat_ids'] = $package_cat_ids = "";
            }

            $pagination = $query->orderBy('packages.set_order')->get();

            $search_city_id = session('search_city_id');

            $data['package_data'] = $pagination;
            $data['package_count'] = $pagination->count();


            $data['package_pagination'] = $pagination;
            // $data['package_count'] = $pagination->count();
            $data['subservice_data'] = DB::table('subservices')->where('id', '!=', 102)->where('serviceid', $service_data)->get();
            $data['package_category'] = DB::table('package_categories')->get();
            $data['subservices_new'] = $subservices_data;
            $data['services_id'] = $service_data;

            $data['max_price'] = DB::table('packages')->max('price');
            $data['filter_price_start'] = $request->get('filter_price_start');
            $data['filter_price_end'] = $request->get('filter_price_end');
        } else {
            $data['package_data'] = '';
            $data['package_count'] = 0;
        }

        $data['serach_var'] = "";


        $sub_id = $data['subservices_new']->id;

        $data['faq'] = DB::table('faqs')
            ->whereRaw('FIND_IN_SET(?, packages)', [$sub_id])
            ->orderBy('id', 'desc')
            ->get()->toArray();

        $data['googleReview'] = DB::table('googlereviews')->orderBy('id', 'DESC')->get()->toArray();

        // echo"<pre>";print_r($data);echo"</pre>";exit;

        $data['subservice_banner_attr'] = DB::table('subservice_banner_attr')->where('city', $cityId)->where('subservice_id', $data['subservices_new']->id)->first();

        $data['top_description'] = DB::table('subservice_top_description_attr')
            ->where('subservice_id', $data['subservices_new']->id)
            ->where('city', $cityId)
            ->first();

        $data['package_attr'] = DB::table('subservice_attr')
            ->where('pid', $data['subservices_new']->id)
            ->where('city', $cityId)
            ->get();
        $data['formattedCity'] = $formattedCity;

        $subserviceMetaContent = DB::table('sub_service_contains')->where('city', $cityId)->where('subservice_id', $subservices_data->id)->first();

        $data['meta_title'] = $subserviceMetaContent->meta_title ?? $subservices_data->meta_title ?? '';
        $data['meta_keyword'] = $subserviceMetaContent->meta_keyword ?? $subservices_data->meta_keyword ?? '';
        $data['meta_description'] = $subserviceMetaContent->meta_description ?? $subservices_data->meta_description ?? '';
        //echo"<pre>";print_r($data['subservice_banner_attr']);echo"</pre>";exit;

        return view('front.package_lists', $data);
    }

    public function package_detail($page_url = '')
    {

        $data['meta_title'] = "";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "";

        $packages_data = DB::table('packages')->where('page_url', $page_url)->first();

        // echo "<pre>";print_r($packages_data);echo "</pre>";exit; 

        if ($packages_data != '') {
            $data['package_detail'] = $packages_data;
        } else {
            $data['package_detail'] = "";
        }

        $sub_id = $data['package_detail']->subservice_id;
        $data['faq'] = DB::table('faqs')
            ->whereRaw('FIND_IN_SET(?, packages)', [$sub_id])
            ->orderBy('id', 'desc')
            ->get()->toArray();

        $data['googleReview'] = DB::table('googlereviews')->orderBy('id', 'DESC')->get()->toArray();

        //echo "<pre>";print_r($data);echo "</pre>";exit;     

        return view('front.package_detail', $data);
    }

    public function enquiry(Request $request, $service_param)
    {
        if (is_numeric($service_param)) {
            $service = Service::findOrFail($service_param);

            $city = $request->route('city') ?? 'dubai';
            $url = url($city . '/enquiry/' . $service->page_url);
            if ($request->getQueryString()) {
                $url .= '?' . $request->getQueryString();
            }
            return redirect($url, 301);
        }

        $service = Service::where('page_url', $service_param)->firstOrFail();

        $service_id = $service->id;

        $form_field_data = Cache::remember("form_field_data_{$service_id}", 86400, function () use ($service_id) {
            return DB::table('services')->where('id', $service_id)->first();
        });

        $data['result1'] = Cache::remember("form_fields_result1_{$service_id}", 86400, function () use ($form_field_data) {
            $tags = explode(',', $form_field_data->form_fields);
            return DB::table('form_fileds')->whereIn('id', $tags)->orderBy('set_order')->get()->toArray();
        });

        $data['formFields'] = Cache::remember('form_fields_all', 86400, function () {
            return DB::table('form_fileds')->get()->toArray();
        });

        $data['result2'] = Cache::remember("form_fields_result2_{$service_id}", 86400, function () use ($form_field_data) {
            $tags = explode(',', $form_field_data->form_fields_two);
            return DB::table('form_fileds')->whereIn('id', $tags)->orderBy('set_order')->get()->toArray();
        });


        $data['service_id'] = $service_id;

        return view('front.enquiry', $data);
    }

    public function booknow(Request $request, $service_param, $subservice_param)
    {
        if (is_numeric($service_param) || is_numeric($subservice_param)) {
            $service = is_numeric($service_param)
                ? Service::findOrFail($service_param)
                : Service::where('page_url', $service_param)->firstOrFail();

            $subservice = Subservice::where(is_numeric($subservice_param) ? 'id' : 'page_url', $subservice_param)
                ->where('serviceid', $service->id)
                ->firstOrFail();

            $city = $request->route('city') ?? 'dubai';
            $url = url($city . '/booknow/' . $service->page_url . '/' . $subservice->page_url);
            if ($request->getQueryString()) {
                $url .= '?' . $request->getQueryString();
            }
            return redirect($url, 301);
        }

        $service = Service::where('page_url', $service_param)->firstOrFail();
        $subservice = Subservice::where('page_url', $subservice_param)->where('serviceid', $service->id)->firstOrFail();

        $service_id = $service->id;
        $subservice_id = $subservice->id;

        $coupan_data = session::get('coupan_data');


        if (session()->has('coupan_data')) {
            // echo "<pre>";print_r($coupan_data);echo "</pre>";exit;
            if ($coupan_data['sub_service'] != $subservice_id) {
                // echo"in";exit;
                session()->forget('coupan_data');
            }
        }

        $cartItems = Cart::content();

        foreach ($cartItems as $item) {
            if ($item->options->subservice_id != $subservice_id) {
                // Remove items belonging to other subservices
                Cart::remove($item->rowId);
            }
        }

        $package_cart = session()->get('package_cart', []);
        $filtered_package_cart = [];
        foreach ($package_cart as $id => $item) {
            if (isset($item['subservice_id']) && $item['subservice_id'] == $subservice_id) {
                $filtered_package_cart[$id] = $item;
            }
        }
        session()->put('package_cart', $filtered_package_cart);

        $addons_cart = session()->get('addons_cart', []);
        $filtered_addons_cart = [];
        foreach ($addons_cart as $id => $item) {
            if (isset($item['subservice_id']) && $item['subservice_id'] == $subservice_id) {
                $filtered_addons_cart[$id] = $item;
            }
        }
        session()->put('addons_cart', $filtered_addons_cart);


        $lastReferringUrl = // Get the current URL
            $currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $explodedUrls = explode('/', $lastReferringUrl);
        $endUrl = end($explodedUrls);

        if ($endUrl != 'register') {
            Session::put('redirect_url', $lastReferringUrl);
        }

        $userData = Session::get('user');

        if (!empty($userData) && isset($userData['userid'])) {
            $user_id = $userData['userid'];
            $customerInfo = DB::table('frontloginregisters')->where('id', $user_id)->first();

            if ($customerInfo) {
                // Check if they already have an active pending lead for this service in this session
                $existingLeadId = Session::get('booknow_pending_lead_id');
                $shouldCreateNew = true;

                if ($existingLeadId) {
                    $existingLead = DB::table('general_enquiries')->where('id', $existingLeadId)->first();
                    if ($existingLead && $existingLead->service_id == $service_id && $existingLead->subservice_id == $subservice_id) {
                        $shouldCreateNew = false;
                    }
                }

                if ($shouldCreateNew) {
                    $sourceWebsite = DB::table('source_leads')->where('name', 'Website')->first();
                    $repeatedSource = DB::table('source_leads')->where('name', 'Repeted Customer')->first();

                    $pastOrders = DB::table('ci_orders')->where('user_id', $user_id)->count();
                    $sourceWebsiteId = $sourceWebsite ? $sourceWebsite->id : null;
                    $repeatedSourceId = $repeatedSource ? $repeatedSource->id : null;

                    if ($pastOrders > 0 && $repeatedSourceId && $sourceWebsiteId) {
                        $sourceLeadId = $sourceWebsiteId . ',' . $repeatedSourceId;
                    } else {
                        $sourceLeadId = $sourceWebsiteId;
                    }

                    $salespersonId = null;
                    if ($pastOrders > 0) {
                        $lastOrder = DB::table('ci_orders')
                            ->join('ci_order_item', 'ci_orders.order_id', '=', 'ci_order_item.order_id')
                            ->where('ci_orders.user_id', $user_id)
                            ->whereNotNull('ci_order_item.salesperson_id')
                            ->orderBy('ci_orders.order_id', 'desc')
                            ->select('ci_order_item.salesperson_id')
                            ->first();
                        if ($lastOrder) {
                            $salespersonId = $lastOrder->salesperson_id;
                        }
                    }

                    $leadId = DB::table('general_enquiries')->insertGetId([
                        'customer_id' => $user_id,
                        'customer_name' => $customerInfo->name,
                        'customer_phone' => $customerInfo->mobile,
                        'customer_email' => $customerInfo->email,
                        'country_code' => $customerInfo->country_code,
                        'service_id' => $service_id,
                        'subservice_id' => $subservice_id,
                        'source_lead_id' => $sourceLeadId,
                        'salesperson_id' => $salespersonId,
                        'status' => 'Pending',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    Session::put('booknow_pending_lead_id', $leadId);
                }
            }
        }

        $data['error'] = "";
        $data['price_data'] = DB::table('cleanin_subserviceprice')->where('subservice_id', $subservice_id)->first();

        $data['service_id'] = $service_id;
        $data['subservice_id'] = $subservice_id;
        $data['subservice_name'] = \Helper::subservicename(strval($subservice_id));

        $data['painting_dis_price'] = DB::table('subservices')->where('id', $subservice_id)->first();

        $data['redirectUrl'] = route('booknow', ['service_id' => $service_id, 'subservice_id' => $subservice_id]);

        /* Apartment Painting Data */
        $data['painting_price_data'] = DB::table('painting_prices')->where('types_of_tab', 'apartment')->where('flags_of_tab', '=', null)->get();

        /* Villa Painting Data */
        $data['villaPainting_price_data'] = DB::table('painting_prices')->where('types_of_tab', 'villa')->where('flags_of_tab', '=', null)->get();

        $data['city_data'] = DB::table('cities')
            ->where('country', 22)
            ->get();


        $data['form_fileds_data'] = DB::table('form_fileds')->where('id', 70)->first();

        $data['subservice_data'] = DB::table('subservices')
            ->where('id', $subservice_id)
            ->first();

        $cityId = Session::get('search_city_id', 17);
        $data['subservice_why_choose'] = DB::table('subservice_why_choose_attr')
            ->where('subservice_id', $subservice_id)
            ->where('city', $cityId)
            ->get();

        $subservice_more_service = DB::table('subservice_more_services')
            ->where('subservice_id', $subservice_id)
            ->where('city', $cityId)
            ->first();

        $more_services = [];
        if ($subservice_more_service && !empty($subservice_more_service->more_subservice_id)) {
            $more_ids = explode(',', $subservice_more_service->more_subservice_id);
            $more_services = DB::table('subservices')->whereIn('id', $more_ids)->get();
        }
        $data['more_services_data'] = $more_services;

        $subservice_what_else_service = DB::table('subservice_what_else_services')
            ->where('subservice_id', $subservice_id)
            ->where('city', $cityId)
            ->first();

        $what_else_services = [];
        if ($subservice_what_else_service && !empty($subservice_what_else_service->what_else_subservice_id)) {
            $what_else_ids = explode(',', $subservice_what_else_service->what_else_subservice_id);
            $what_else_services = DB::table('subservices')->whereIn('id', $what_else_ids)->get();
        }
        $data['what_else_services_data'] = $what_else_services;

        $data['subservice_description_data'] = DB::table('subservice_descriptions')
            ->where('subservice_id', $subservice_id)
            ->where('city', $cityId)
            ->get();

        // FAQ: load only entries linked to this subservice
        $data['faq_data'] = DB::table('faqs')
            ->whereRaw("FIND_IN_SET(?, packages)", [$subservice_id])
            ->get();

        // Attempt to fix database automatically if columns are missing
        try {
            DB::statement('ALTER TABLE `googlereviews` ADD COLUMN `review_date` DATE NULL AFTER `name`');
            DB::statement('ALTER TABLE `googlereviews` ADD COLUMN `services` TEXT NULL AFTER `review_date`');
            DB::statement('ALTER TABLE `googlereviews` ADD COLUMN `subservice_id` TEXT NULL AFTER `services`');
        } catch (\Exception $e) {
            try {
                DB::statement('ALTER TABLE `googlereviews` CHANGE COLUMN `packages` `subservice_id` TEXT NULL');
                DB::statement('ALTER TABLE `googlereviews` ADD COLUMN `review_date` DATE NULL AFTER `name`');
            } catch (\Exception $e2) {
                // Ignore, columns probably already exist
            }
        }

        // Google Reviews: load only entries linked to this subservice
        $data['google_reviews_data'] = DB::table('googlereviews')
            ->whereRaw("FIND_IN_SET(?, subservice_id)", [$subservice_id])
            ->get();

        $package_cats = DB::table('package_categories')
            ->where('service_id', $service_id)
            ->where('is_active', 0)
            ->where('subservice_id', $subservice_id)
            ->orderBy("set_order", 'asc')
            ->get()->toArray();

        $filtered_package_cat = [];
        foreach ($package_cats as $cat) {
            $has_packages = DB::table('packages')
                ->where('service_id', $service_id)
                ->where('subservice_id', $subservice_id)
                ->where('packagecategory_id', $cat->id)
                ->where('is_active', 0)
                ->exists();

            if ($has_packages) {
                $filtered_package_cat[] = $cat;
            }
        }
        $data['package_cat'] = $filtered_package_cat;

        $data['addons'] = DB::table('addons')
            ->where('serviceid', $service_id)
            ->where('is_active', 0)
            ->whereRaw("FIND_IN_SET(?, subserviceid)", [$subservice_id])
            ->orderBy("set_order", 'asc')
            ->get()->toArray();

        $data['timeslot'] = DB::table('time_slots')->orderBy('set_order', 'asc')->get()->toArray();
        $data['allcleaners'] = DB::table('users')->where('role_id', '16')
            ->where('is_active', 0)
            //->whereRaw("FIND_IN_SET(?, city)", [17])
            ->whereRaw("FIND_IN_SET(?, service)", [$service_id])
            ->whereRaw("FIND_IN_SET(?, subservice)", [$subservice_id])
            ->orderBy('id', 'asc') // Ensures the first cleaner is prioritized
            ->get();
        //echo "<pre>";print_r($data['timeslot']);echo"</pre>";exit; 

        // if($subservice_id == 28){
        //     return view('front.servicespage.homecleaning',$data);
        // }

        // return view('front.booknow',$data);
        if ($subservice_id == 89) {

            $meta_title = "Book Now – Choose Your Home Service";
            $meta_keyword = "";
            $meta_description = "Select your desired service & book in minutes. Easy, fast & reliable—reserve now!";
        }

        $data['meta_title'] = $meta_title ?? '';
        $data['meta_keyword'] = $meta_keyword ?? '';
        $data['meta_description'] = $meta_description ?? '';

        $data['system_data'] = DB::table('system')->where('id', 1)->first();

        $urlPromo = trim($request->input('promo', ''));
        $data['promo'] = '';
        if (!empty($urlPromo)) {
            $promoExists = DB::table('coupans')
                ->where('coupan_code', $urlPromo)
                ->where('is_active', 0)
                ->where('startdate', '<=', now()->toDateString())
                ->where('enddate', '>=', now()->toDateString())
                ->exists();
            if ($promoExists) {
                $data['promo'] = $urlPromo;
                // Persist the promo code in session so we know it was applied via URL
                Session::put('url_promo_applied', $urlPromo);
            }
        } else {
            // URL promo is empty/absent. If a URL promo was previously applied, forget it.
            if (Session::has('url_promo_applied')) {
                Session::forget('coupan_data');
                Session::forget('url_promo_applied');
            }
        }

        // // TEMP DEBUG: Write to a file so we know what happens during actual page load
        // $debugInfo = sprintf(
        //     "[%s] urlPromo: '%s', data['promo']: '%s', existsCheck: %s, session: %s\n",
        //     now()->toDateTimeString(),
        //     $urlPromo,
        //     $data['promo'],
        //     isset($promoExists) ? ($promoExists ? 'true' : 'false') : 'N/A',
        //     Session::get('url_promo_code', 'none')
        // );
        // file_put_contents(public_path('promo_debug_log.txt'), $debugInfo, FILE_APPEND);

        // Pass the currently-applied session coupon code so JS knows if it's already active
        $data['session_coupon_applied'] = session('coupan_data.coupancode', '');

        if ($service_id == '54') {
            $data['emiratesShow'] = true;
        } else {
            $data['emiratesShow'] = false;
        }

        if ($subservice_id == 101) { // cleaning subscription
            $data['durations'] = DB::table('cleaning_subscription_durations')->where('is_active_web', 1)->orderBy('set_order')->get();
            $data['frequencies'] = DB::table('cleaning_subscription_frequencies')->where('is_active_web', 1)->orderBy('set_order')->get();
            $data['packages'] = DB::table('cleaning_subscription_packages')->where('is_active_web', 1)->orderBy('set_order')->get();
            $data['pricing_rules'] = DB::table('cleaning_subscription_pricing')->where('is_active_web', 1)->get();
            $user_id = Session::get('user')['userid'] ?? '';
            $data['is_first_time_user'] = DB::table('ci_order_item')->where('user_info_id', $user_id)->where('subservice_id', '101')->first();
            $data['promo'] = $request->query('promo', '');
            $data['session_coupon_applied'] = session()->has('coupan_data') ? session('coupan_data.coupancode', '') : '';
            return view('front.cleaningsubscription', $data);
        } elseif ($subservice_id == 101) { // cleaning subscription
            $data['durations'] = DB::table('cleaning_subscription_durations')->where('is_active_web', 1)->orderBy('set_order')->get();
            $data['frequencies'] = DB::table('cleaning_subscription_frequencies')->where('is_active_web', 1)->orderBy('set_order')->get();
            $data['packages'] = DB::table('cleaning_subscription_packages')->where('is_active_web', 1)->orderBy('set_order')->get();
            $data['pricing_rules'] = DB::table('cleaning_subscription_pricing')->where('is_active_web', 1)->get();
            $user_id = Session::get('user')['userid'] ?? '';
            $data['is_first_time_user'] = DB::table('ci_order_item')->where('user_info_id', $user_id)->where('subservice_id', '101')->first();
            $data['promo'] = $request->query('promo', '');
            $data['session_coupon_applied'] = session()->has('coupan_data') ? session('coupan_data.coupancode', '') : '';
            return view('front.cleaningsubscription', $data);
        } elseif ($subservice_id == 28) { // home cleaning
            //    return view('front.booknow',$data);
            $data['cleaning_price'] = DB::table('cleanin_subserviceprice')->Where('subservice_id', $subservice_id)->get()->toArray();

            $user_id = Session::get('user')['userid'] ?? "";

            $data['is_first_time_user'] = DB::table('ci_order_item')->where('user_info_id', $user_id)->where('subservice_id', '28')->first();

            // Google Ads promo: read ?gpromo= from URL and pass to view
            $data['promo'] = $request->query('promo', '');

            // Pass whether a coupon is already applied in session
            $data['session_coupon_applied'] = session()->has('coupan_data') ? session('coupan_data.coupancode', '') : '';

            return view('front.homecleaning', $data);
        } elseif ($subservice_id == 89) {
            return view('front.book-online', $data);
        } elseif ($subservice_id == 78 || $subservice_id == 77) {
            return view('front.garden-online', $data);
        } else {
            //session()->forget('coupan_data');
            //session()->forget('package_cart');
            return view('front.booknownew', $data);
        }

        // if($subservice_id == 29 || $subservice_id == 70){
        //     return view('front.booknownew',$data);
        // }

        // if($subservice_id == 47 || $subservice_id == 89){
        //     return view('front.book-online',$data);
        // }elseif($subservice_id == 78 || $subservice_id == 77){
        //     return view('front.garden-online',$data);
        // }else{
        //     return view('front.booknow',$data);
        // }
    }
    public function apply_wallet_discount_book_now(Request $request)
    {

        // echo "<pre>";print_r($request->all());echo"</pre>";exit;

        $walletdiscount = $request->total_wallet_amount;
        $userWalletamount = $request->userWalletamount;
        Session::put('walletdiscount', $walletdiscount);
        Session::put('user_wallet_amount', $userWalletamount);

        $sessionWalletAmt = Session::get('walletdiscount', $walletdiscount);
        echo $sessionWalletAmt;
    }
    function cancel_wallet_discount_book_now(Request $request)
    {
        // echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $walletdiscount = $request->orderTotal;
        $userWalletamount = $request->userWalletAmount;
        Session::put('walletdiscount', $walletdiscount);
        Session::put('user_wallet_amount', $userWalletamount);

        $sessionuserWalletamount = Session::get('user_wallet_amount', $userWalletamount);
        echo $sessionuserWalletamount;
    }

    function get_price_cleaning()
    {

        // $user_id = Session::get('user')['userid'];
        $user_id = 100001;

        $is_first_time_user = !DB::table('ci_order_item')->where('user_info_id', $user_id)->where('subservice_id', $_POST['service_id'])->first();

        $price_data = DB::table('cleanin_subserviceprice')
            ->where('subservice_id', $_POST['service_id'])
            ->where('hour_value', $_POST['how_many_hours_should_they_stay_value'])
            ->first();

        $service_data = DB::table('subservices')
            ->where('id', $_POST['service_id'])
            ->first();



        if ($is_first_time_user) {
            // $hour_price = 9;
            $hour_price = $price_data->hourly_price;
        } else {
            $hour_price = $price_data->hourly_price;
        }

        $data = [
            'status' => 'success',
            'hour_price' => $hour_price,
            'cleaning_material_price_per_hour' => $price_data->cleaning_material_price_per_hour,
            'promo_discount' => $service_data->promo_discount,
            'promo_discount_type' => $service_data->discount_type,
        ];

        echo json_encode($data);
        // echo "<pre>";print_r($data);echo"</pre>";exit;
    }

    //     public function cleaner_time_check(Request $request) {
    //         $cleaner_id = $request->cleaner_id;
    //         $date = $request->date;
    //         $month = $request->month;
    //         $year = $request->year;
    //         $subserviceId = $request->subservice_id;

    //         // echo"<pre>";print_r($day);echo"</pre>";exit;
    //         $booked_slots = DB::table('ci_order_item')
    //                         ->join('ci_orders', 'ci_orders.order_id', '=', 'ci_order_item.order_id')
    //                         ->whereRaw("FIND_IN_SET(?, ci_order_item.cleaner_id)", [$cleaner_id])
    //                         // ->where('ci_order_item.bookingdate', $date)
    //                         // ->where('ci_order_item.month', $month)
    //                         // ->where('ci_order_item.bookingyear', $year)
    //                         ->where('ci_orders.is_delete', '0') 
    //                         ->select('ci_order_item.*') 
    //                         ->get();



    //             $AllSelectedDays = [];

    //             foreach ($booked_slots as $booked_slot) {

    //                 if ($booked_slot->how_often_do_you_need_cleaning == "Once") {
    //                     $AllSelectedDays[] = $booked_slot;

    //                 } elseif ($booked_slot->how_often_do_you_need_cleaning == "Weekly") {

    //                     // Weekly logic
    //                     $start_date = sprintf('%04d-%02d-%02d', $booked_slot->bookingyear, date('m', strtotime($booked_slot->month)), $booked_slot->bookingdate);
    //                     $end_date = $booked_slot->end_date;

    //                     $targetDayName = strtolower($booked_slot->which_day_of_the_week_do_you_want_the_service);

    //                     $currentDate = new DateTime($start_date);
    //                     $endDateObj = new DateTime($end_date);

    //                     // Adjust to the first correct weekday
    //                     while (strtolower($currentDate->format('l')) != $targetDayName) {
    //                         $currentDate->modify('+1 day');
    //                     }

    //                     // Loop weekly
    //                     while ($currentDate <= $endDateObj) {
    //                         $clonedSlot = clone $booked_slot;
    //                         $clonedSlot->bookingdate = $currentDate->format('d');
    //                         $clonedSlot->month = $currentDate->format('F');
    //                         $clonedSlot->bookingyear = $currentDate->format('Y');

    //                         $AllSelectedDays[] = $clonedSlot;

    //                         $currentDate->modify('+7 day');
    //                     }

    //                 } elseif ($booked_slot->how_often_do_you_need_cleaning == "Multiple times a week") {

    //                     // Multiple days per week logic
    //                     $start_date = sprintf('%04d-%02d-%02d', $booked_slot->bookingyear, date('m', strtotime($booked_slot->month)), $booked_slot->bookingdate);
    //                     $end_date = $booked_slot->end_date;

    //                     $currentDate = new DateTime($start_date);
    //                     $endDateObj = new DateTime($end_date);

    //                     $selectedDays = array_map('trim', explode(',', $booked_slot->which_day_of_the_week_do_you_want_the_service));
    //                     $selectedDays = array_map('strtolower', $selectedDays);

    //                     while ($currentDate <= $endDateObj) {
    //                         $dayName = strtolower($currentDate->format('l'));

    //                         if (in_array($dayName, $selectedDays)) {
    //                             $clonedSlot = clone $booked_slot;
    //                             $clonedSlot->bookingdate = $currentDate->format('d');
    //                             $clonedSlot->month = $currentDate->format('F');
    //                             $clonedSlot->bookingyear = $currentDate->format('Y');

    //                             $AllSelectedDays[] = $clonedSlot;
    //                         }

    //                         $currentDate->modify('+1 day');
    //                     }
    //                 }
    //             }


    //         //echo"<pre>";print_r($AllSelectedDays);echo"</pre>";exit;


    // $AllSelectedDays = collect($AllSelectedDays); 





    // 		$timeslot_master = DB::table('subservice_timeslot_price as stp')
    //                            ->leftJoin('time_slots as ts', 'stp.time_slot_id', '=', 'ts.id')
    //                            ->where('stp.subservice_id', $subserviceId)
    //                            ->where('stp.is_active', 1)
    //                            ->select('stp.*', 'ts.name as slot_name') 
    //                            ->get();


    //         if ($AllSelectedDays->isEmpty()) {
    //             return response()->json([
    //             'timeslot' => [],
    //             'date' => $date,
    //             'month' => $month,
    //             'year' => $year,
    //             'timeslot_master' => $timeslot_master, 
    //             'cleaner_id' => $cleaner_id, 
    //             'hours' => 0]);
    //         }

    //         // Extract all time slots and sum up hours
    //         $time_slots = $AllSelectedDays->pluck('time_slot'); 
    //         $hours = $AllSelectedDays->pluck('how_many_hours_should_they_stay');

    //         return response()->json([
    //             'timeslot' => $time_slots, 
    //             'date' => $date,
    //             'month' => $month,
    //             'year' => $year,
    //             'timeslot_master' => $timeslot_master, 
    //             'hours' => $hours,
    //             'cleaner_id' => $cleaner_id
    //         ]);

    //     }
    public function cleaner_time_check(Request $request)
    {
        $cleaner_id = $request->cleaner_id;
        $date = $request->date;
        $month = $request->month;
        $year = $request->year;
        $subserviceId = $request->subservice_id;

        // Get all bookings for this cleaner
        $booked_slots = DB::table('ci_order_item')
            ->whereRaw("FIND_IN_SET(?, cleaner_id)", [$cleaner_id])
            ->where('subservice_id', $subserviceId)
            ->where('is_return', '0')
            //->where('is_delete', '0')
            ->get();

        // Load time slots for rendering
        $timeslot_master = DB::table('subservice_timeslot_price as stp')
            ->leftJoin('time_slots as ts', 'stp.time_slot_id', '=', 'ts.id')
            ->where('stp.subservice_id', $subserviceId)
            ->where('stp.is_active', 1)
            ->select('stp.*', 'ts.name as slot_name')
            ->orderBy('ts.set_order', 'asc')
            ->get();

        // Prepare for selected date
        $selectedDateStr = "$year-$month-$date";
        $selectedDate = DateTime::createFromFormat('Y-F-d', $selectedDateStr);
        $matchedBookings = [];

        foreach ($booked_slots as $booked_slot) {
            $slotStartDate = DateTime::createFromFormat(
                'Y-F-d',
                sprintf('%04d-%s-%02d', $booked_slot->bookingyear, $booked_slot->month, $booked_slot->bookingdate)
            );
            $endDate = new DateTime($booked_slot->end_date);

            if ($booked_slot->how_often_do_you_need_cleaning == "Once") {
                if (
                    $slotStartDate->format('Y-m-d') == $selectedDate->format('Y-m-d')
                ) {
                    $matchedBookings[] = $booked_slot;
                }
            } elseif ($booked_slot->how_often_do_you_need_cleaning == "Weekly") {
                $targetDay = strtolower(trim($booked_slot->which_day_of_the_week_do_you_want_the_service));
                $current = clone $slotStartDate;

                // Move to first matching weekday
                while (strtolower($current->format('l')) != $targetDay) {
                    $current->modify('+1 day');
                }

                while ($current <= $endDate) {
                    if ($current->format('Y-m-d') == $selectedDate->format('Y-m-d')) {
                        $matchedBookings[] = $booked_slot;
                        break;
                    }
                    $current->modify('+7 days');
                }
            } elseif ($booked_slot->how_often_do_you_need_cleaning == "Multiple times a week") {
                $days = explode(',', $booked_slot->which_day_of_the_week_do_you_want_the_service);
                $selectedDay = strtolower($selectedDate->format('l'));

                $dayMatch = collect($days)->map(fn($d) => strtolower(trim($d)))->contains($selectedDay);

                if (
                    $dayMatch &&
                    $selectedDate >= $slotStartDate &&
                    $selectedDate <= $endDate
                ) {
                    $matchedBookings[] = $booked_slot;
                }
            }
        }

        $matchedBookings = collect($matchedBookings);

        if ($matchedBookings->isEmpty()) {
            return response()->json([
                'timeslot' => [],
                'date' => $date,
                'month' => $month,
                'year' => $year,
                'timeslot_master' => $timeslot_master,
                'cleaner_id' => $cleaner_id,
                'hours' => 0
            ]);
        }

        // Return the time slots and hours for disabling
        return response()->json([
            'timeslot' => $matchedBookings->pluck('time_slot'),
            'date' => $date,
            'month' => $month,
            'year' => $year,
            'timeslot_master' => $timeslot_master,
            'hours' => $matchedBookings->pluck('how_many_hours_should_they_stay'),
            'cleaner_id' => $cleaner_id
        ]);
    }

    function homecleaner_time_check(Request $request)
    {
        $cleanerId = $request->cleaner_id;
        $date = $request->date;   // 01–31
        $month = $request->month;  // 01–12
        $year = $request->year;   // YYYY
        $subserviceId = $request->subservice_id;

        // BOOKINGS
        $bookedSlots = DB::table('ci_order_item')
            ->whereRaw("FIND_IN_SET(?, cleaner_id)", [$cleanerId])
            ->where('subservice_id', $subserviceId)
            ->where('is_return', '0')
            ->get();

        //echo"<pre>";print_r($bookedSlots);echo"</pre>";exit;
        // TIME SLOTS
        $timeslotMaster = DB::table('subservice_timeslot_price as stp')
            ->leftJoin('time_slots as ts', 'stp.time_slot_id', '=', 'ts.id')
            ->where('stp.subservice_id', $subserviceId)
            ->where('stp.is_active', 1)
            ->select('stp.*', 'ts.name as slot_name')
            ->orderBy('ts.set_order', 'asc')
            ->get();

        // SELECTED DATE
        $selectedDate = DateTime::createFromFormat(
            'Y-m-d',
            sprintf('%04d-%02d-%02d', $year, $month, $date)
        );

        if (!$selectedDate) {
            return response()->json([
                'timeslot' => [],
                'hours' => 0,
                'timeslot_master' => $timeslotMaster
            ]);
        }

        $matchedBookings = [];

        foreach ($bookedSlots as $booking) {

            $startDate = DateTime::createFromFormat(
                'Y-m-d',
                sprintf(
                    '%04d-%02d-%02d',
                    $booking->bookingyear,
                    $booking->month,
                    $booking->bookingdate
                )
            );

            if (!$startDate)
                continue;

            $endDate = new DateTime($booking->end_date);

            // ONCE
            if ($booking->how_often_do_you_need_cleaning === "Once") {
                if ($startDate->format('Y-m-d') === $selectedDate->format('Y-m-d')) {
                    $matchedBookings[] = $booking;
                }
            }

            // WEEKLY
            elseif ($booking->how_often_do_you_need_cleaning === "Weekly") {

                $targetDay = strtolower(trim($booking->which_day_of_the_week_do_you_want_the_service));
                $current = clone $startDate;

                while (strtolower($current->format('l')) !== $targetDay) {
                    $current->modify('+1 day');
                }

                while ($current <= $endDate) {
                    if ($current->format('Y-m-d') === $selectedDate->format('Y-m-d')) {
                        $matchedBookings[] = $booking;
                        break;
                    }
                    $current->modify('+7 days');
                }
            }

            // MULTIPLE TIMES A WEEK
            elseif ($booking->how_often_do_you_need_cleaning === "Multiple times a week") {

                $days = collect(explode(',', $booking->which_day_of_the_week_do_you_want_the_service))
                    ->map(fn($d) => strtolower(trim($d)));

                $selectedDay = strtolower($selectedDate->format('l'));

                if (
                    $days->contains($selectedDay) &&
                    $selectedDate >= $startDate &&
                    $selectedDate <= $endDate
                ) {
                    $matchedBookings[] = $booking;
                }
            }
        }

        $matchedBookings = collect($matchedBookings);

        if ($matchedBookings->isEmpty()) {
            return response()->json([
                'timeslot' => [],
                'date' => $date,
                'month' => $month,
                'year' => $year,
                'timeslot_master' => $timeslotMaster,
                'cleaner_id' => $cleanerId,
                'hours' => 0
            ]);
        }

        return response()->json([
            'timeslot' => $matchedBookings->pluck('time_slot'),
            'date' => $date,
            'month' => $month,
            'year' => $year,
            'timeslot_master' => $timeslotMaster,
            'hours' => $matchedBookings->pluck('how_many_hours_should_they_stay'),
            'cleaner_id' => $cleanerId
        ]);
    }

    public function getCleanersByCity(Request $request)
    {
        $city_id = $request->city_id;
        $service_id = $request->service_id;
        $subservice_id = $request->subservice_id;

        $cleaners = DB::table('users')
            ->where('role_id', 16)
            ->where('is_active', 0)
            ->where(function ($q) use ($city_id) {
                $q->whereRaw("FIND_IN_SET(?, city)", [$city_id]) // city-based
                    ->orWhere('id', 2); // auto-assign cleaner (global)
            })
            ->whereRaw("FIND_IN_SET(?, service)", [$service_id])
            ->whereRaw("FIND_IN_SET(?, subservice)", [$subservice_id])
            ->orderByRaw("id = 2 DESC") // optional: keep auto cleaner first
            ->get();

        if ($cleaners->isEmpty()) {
            return response()->json([
                'html' => '<li class="splide__slide text-center">
                        <div class="alert alert-warning">
                            No cleaners available for this area
                        </div>
                       </li>'
            ]);
        }

        $html = '';

        foreach ($cleaners as $data) {

            $name = htmlspecialchars($data->name, ENT_QUOTES);
            $image = url('public/upload/cleaners/large/' . $data->profile_image);

            $badge = ($data->id == 2)
                ? '<p class="cleaners-para">Best in Your Area</p>'
                : '<p class="cleaners-para">Recommended in your Area</p>';

            $Model = ($data->id == 2)
                ? '<p class="cleaner-name">' . $name . '</p>'
                : '<a style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#cleaner_description_' . $data->id . '"><p class="cleaner-name">' . $name . '</p></a>';

            $html .= '<li class="splide__slide text-center">
            <div class="cleaner-selection-card"
                onclick="cleaner_data(this, \'' . $data->id . '\', \'' . $name . '\')">
                
                <input type="radio"
                    id="cleaner_' . $data->id . '"
                    name="cleaner" 
                    class="cleaners-radio"
                    value="' . $name . '"
                    data-cleaner-id="' . $data->id . '">

                <div class="cleaner-card-avatar">
                    <img src="' . $image . '" alt="' . $name . '">
                    ' . ($data->id != 2 ? '<div class="cleaner-info-badge"><i class="fa-solid fa-star" style="color: #FFD700; font-size: 10px;"></i></div>' : '') . '
                </div>

                <div class="cleaner-card-name">' . $name . '</div>
                
                ' . ($data->id != 2 ? '
                    <div class="cleaner-card-meta">' . $data->nationality . '</div>
                    <div class="cleaner-card-tag">Recommended</div>
                    
                    <a href="javascript:void(0)" 
                       class="mt-2"
                       style="font-size: 10px; color: #0040E6; text-decoration: underline; font-weight: 600;"
                       data-bs-toggle="modal"
                       data-bs-target="#cleaner_description_' . $data->id . '"
                       onclick="event.stopPropagation()">
                       View Profile
                    </a>
                ' : '
                    <div class="cleaner-card-meta">Best Availability</div>
                    <div class="cleaner-card-tag">Flexible</div>
                ') . '
            </div>
        </li>';
        }

        return response()->json(['html' => $html]);
    }





    function painting_time_check(Request $request)
    {

        $day = $request->input('date');      // 1
        $month = $request->input('month');   // July
        $year = $request->input('year');     // 2025
        $subservice_id = $request->input('subservice_id');

        // Convert to standard date format: YYYY-MM-DD
        $monthNumber = date('m', strtotime($month));
        $selectedDateStr = sprintf('%04d-%02d-%02d', $year, $monthNumber, $day);

        // Compare with today's date
        date_default_timezone_set('Asia/Dubai');
        $todayStr = date('Y-m-d');
        $isToday = $selectedDateStr === $todayStr;

        // Current time + 2 hour buffer (in minutes)
        $currentHour = date('H');
        $currentMinute = date('i');
        $currentTotalMinutes = ($currentHour * 60) + $currentMinute;
        $bufferMinutes = $currentTotalMinutes + 120;

        $html = '';
        $i = 1;

        $timeslots = DB::table('time_slots')->orderBy('set_order', 'asc')->get();

        foreach ($timeslots as $slot) {
            $slotStart = explode('-', $slot->name)[0]; // e.g. "2:00 PM"
            $slotTimestamp = strtotime($slotStart);    // converts to UNIX timestamp
            $slotHour = date('H', $slotTimestamp);
            $slotMinute = date('i', $slotTimestamp);
            $slotTotalMinutes = ($slotHour * 60) + $slotMinute;

            // Only skip if today and slot is less than buffer time
            if ($isToday && $slotTotalMinutes < $bufferMinutes) {
                continue;
            }

            $slotPrice = DB::table('subservice_timeslot_price')
                ->where('subservice_id', $subservice_id)
                ->where('time_slot_id', $slot->id)
                ->where('is_active', 1)
                ->first();

            if (!$slotPrice)
                continue;

            $price = $slotPrice->price ?? 0;

            $html .= '<div class="surcharge-badge-timeslot items">';
            if ($price > 0) {
                $html .= '<span class="badgespantime">+ <p class="currency_dhiramnew">AED</p> ' . $price . '</span>';
            }
            $html .= '<input type="radio" id="time' . $i . '" name="time_slot"
                    data-name="' . $slot->name . '"
                    onclick="timeslot_price(\'' . $price . '\', \'' . $slot->name . '\', this);"
                    value="' . $slot->id . '">';
            $html .= '<label class="labeltime" for="time' . $i . '" style="border-radius: 50px;">' . $slot->name . '</label>';
            $html .= '</div>';

            $i++;
        }

        return response()->json(['html' => $html]);
    }

    public function hours_check()
    {

        // echo"<pre>";print_r($_POST);echo"</pre>";exit;

        $hours = $_POST['hours'];
        $timeslotId = $_POST['timeslotId'];
        $cleaner_id = $_POST['cleaner_id'];
        $date = $_POST['date'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        $subserviceId = $_POST['subserviceId'];

        // echo"<pre>";print_r($year);echo"</pre>";exit;

        if ($cleaner_id == 2) {
            return response()->json(["status" => "success"]);
        }

        $selected_slots = [];
        for ($i = 0; $i <= $hours; $i++) {
            $selected_slots[] = $timeslotId + $i;
        }

        // echo"<pre>";print_r($selected_slots);echo"</pre>";exit;

        $availableSlots = DB::table('subservice_timeslot_price')
            ->where('subservice_id', $subserviceId)
            ->where('is_active', '1')
            ->pluck('time_slot_id')
            ->toArray();

        if (array_diff($selected_slots, $availableSlots)) {
            return response()->json(["status" => "error", "message" => "Not enough consecutive slots available for the selected time."]);
        }

        $bookedSlots = DB::table('ci_order_item')
            ->join('ci_orders', 'ci_orders.order_id', '=', 'ci_order_item.order_id')
            ->where('ci_order_item.bookingdate', $date)
            ->where('ci_order_item.month', $month)
            ->where('ci_order_item.bookingyear', $year)
            ->whereIn('ci_order_item.time_slot', $selected_slots)
            ->whereRaw("FIND_IN_SET(?, ci_order_item.cleaner_id)", [$cleaner_id])
            ->where('ci_orders.is_delete', '0')
            ->select('ci_order_item.*')
            ->get();


        if ($bookedSlots->count() > 0) {
            return response()->json(["status" => "error", "message" => "The next consecutive slots are already booked. Please select a different date."]);
        } else {
            return response()->json(["status" => "success"]);
        }
    }


    public function enquiry_sub(Request $request, $service_param, $subservice_param)
    {
        if (is_numeric($service_param) || is_numeric($subservice_param)) {
            $service = is_numeric($service_param)
                ? Service::findOrFail($service_param)
                : Service::where('page_url', $service_param)->firstOrFail();

            $subservice = Subservice::where(is_numeric($subservice_param) ? 'id' : 'page_url', $subservice_param)
                ->where('serviceid', $service->id)
                ->firstOrFail();

            $city = $request->route('city') ?? 'dubai';
            $url = url($city . '/enquiry/' . $service->page_url . '/' . $subservice->page_url);
            if ($request->getQueryString()) {
                $url .= '?' . $request->getQueryString();
            }
            return redirect($url, 301);
        }

        $service = Service::where('page_url', $service_param)->firstOrFail();
        $subservice = Subservice::where('page_url', $subservice_param)->where('serviceid', $service->id)->firstOrFail();

        $service_id = $service->id;
        $subservice_id = $subservice->id;

        $isAjax = $request->ajax() || $request->header('X-Requested-With') == 'XMLHttpRequest';
        $fromFirstForm = session()->has('redirected_from_first_form');
        $fromLoginOrOtp = session()->has('L_strsucessMessage') || session()->has('success') || session()->has('message') || session()->has('book-login-otp') || session()->has('book-email-login-otp') || session()->has('login-otp') || session()->has('email-login-otp');

        if (!$isAjax && !$fromFirstForm && !$fromLoginOrOtp) {
            session()->forget('packages_enquiry_form_id');
        } else {
            $packageEnquiryFormId = session('packages_enquiry_form_id');
            $userdata = Session::get('user');
            if (!empty($packageEnquiryFormId) && !empty($userdata['userid'])) {
                DB::table('packages_enquiry')->where('id', $packageEnquiryFormId)->update([
                    'user_id' => $userdata['userid'] ?? 0,
                    'name' => $userdata['name'] ?? '',
                    'email' => $userdata['email'] ?? '',
                    'mobile' => $userdata['mobile'] ?? ''
                ]);
            }
        }

        $userData = Session::get('user');
        if (!empty($userData) && isset($userData['userid'])) {
            $user_id = $userData['userid'];
            $customerInfo = DB::table('frontloginregisters')->where('id', $user_id)->first();
            if ($customerInfo) {
                $existingLeadId = Session::get('enquiry_pending_lead_id');
                $shouldCreateNew = true;

                if ($existingLeadId) {
                    $existingLead = DB::table('general_enquiries')->where('id', $existingLeadId)->first();
                    if ($existingLead && $existingLead->service_id == $service_id && $existingLead->subservice_id == $subservice_id) {
                        $shouldCreateNew = false;
                    }
                }

                if ($shouldCreateNew) {
                    $sourceWebsite = DB::table('source_leads')->where('name', 'Website')->first();
                    $repeatedSource = DB::table('source_leads')->where('name', 'Repeted Customer')->first();
                    $pastOrders = DB::table('ci_orders')->where('user_id', $user_id)->count();

                    $sourceWebsiteId = $sourceWebsite ? $sourceWebsite->id : null;
                    $repeatedSourceId = $repeatedSource ? $repeatedSource->id : null;
                    if ($pastOrders > 0 && $repeatedSourceId && $sourceWebsiteId) {
                        $sourceLeadId = $sourceWebsiteId . ',' . $repeatedSourceId;
                    } else {
                        $sourceLeadId = $sourceWebsiteId;
                    }

                    $salespersonId = null;
                    if ($pastOrders > 0) {
                        $lastOrder = DB::table('ci_orders')
                            ->join('ci_order_item', 'ci_orders.order_id', '=', 'ci_order_item.order_id')
                            ->where('ci_orders.user_id', $user_id)
                            ->whereNotNull('ci_order_item.salesperson_id')
                            ->orderBy('ci_orders.order_id', 'desc')
                            ->select('ci_order_item.salesperson_id')
                            ->first();
                        if ($lastOrder) {
                            $salespersonId = $lastOrder->salesperson_id;
                        }
                    }

                    $leadId = DB::table('general_enquiries')->insertGetId([
                        'customer_id' => $user_id,
                        'customer_name' => $customerInfo->name,
                        'customer_phone' => $customerInfo->mobile,
                        'customer_email' => $customerInfo->email,
                        'country_code' => $customerInfo->country_code,
                        'service_id' => $service_id,
                        'subservice_id' => $subservice_id,
                        'source_lead_id' => $sourceLeadId,
                        'salesperson_id' => $salespersonId,
                        'status' => 'Pending',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    Session::put('enquiry_pending_lead_id', $leadId);
                }
            }
        }

        // if($subservice_id != '31') {
        //     $form_field_data_ser = DB::table('services')->where('id', $service_id)->first();
        // } else {
        //     $form_field_data_ser = array();
        // }
        // $form_field_data_sub = DB::table('subservices')->where('id', $subservice_id)->first();

        // //$form_fields_service = explode(',', $form_field_data_ser->form_fields);
        // $form_fields_service = array();
        // $form_fields_subservice = explode(',', $form_field_data_sub->form_fields);

        // echo "here";exit;

        // new
        if ($subservice_id != '31') {
            $form_field_data_ser = DB::table('services')->where('id', $service_id)->first();
        } else {
            $form_field_data_ser = null; // Set it to null instead of an empty array
        }

        $form_field_data_sub = DB::table('subservices')->where('id', $subservice_id)->first();

        $form_fields_service = [];
        $form_fields_subservice = explode(',', $form_field_data_sub->form_fields);

        if ($form_field_data_ser) {
            $form_fields_service = explode(',', $form_field_data_ser->form_fields);
        }
        // new



        $form_fields_merged = array_unique(array_merge($form_fields_service, $form_fields_subservice));

        $form_fields_to_use_string = implode(',', $form_fields_merged);

        $tags = explode(',', $form_fields_to_use_string);

        $data['result1'] = DB::table('form_fileds')->whereIn('id', $tags)->orderBy('set_order')->get()->toArray();


        $data['formFields'] = DB::table('form_fileds')->get()->toArray();

        $form_fields_service = array();
        $form_fields_service = explode(',', $form_field_data_ser->form_fields_two ?? '');

        $form_fields_subservice = explode(',', $form_field_data_sub->form_fields_two);
        $form_fields_merged = array_unique(array_merge($form_fields_service, $form_fields_subservice));
        $form_fields_to_use_string = implode(',', $form_fields_merged);
        $tags2 = explode(',', $form_fields_to_use_string);

        $data['result2'] = DB::table('form_fileds')
            ->whereIn('id', $tags2)
            ->orderBy('set_order')
            ->get()
            ->toArray();
        // echo "<pre>";print_r($data['result2']);echo "</pre>";exit;           


        $data['service_id'] = $service_id;
        $data['subservice_id'] = $subservice_id;

        $data['service_name'] = $form_field_data_ser ? $form_field_data_ser->servicename : '';
        $data['subservice_name'] = $form_field_data_sub ? $form_field_data_sub->subservicename : '';

        $data['redirectUrl'] = route('enquiry', ['service_id' => $service_id, 'subservice_id' => $subservice_id]);

        $data['submittedFields'] = [];
        $data['enquiry'] = null;
        $packageEnquiryFormId = session('packages_enquiry_form_id');
        if ($packageEnquiryFormId) {
            $data['enquiry'] = DB::table('packages_enquiry')->where('id', $packageEnquiryFormId)->first();
            $data['submittedFields'] = DB::table('more_formfields_details')
                ->join('form_fileds', 'more_formfields_details.form_field_id', '=', 'form_fileds.id')
                ->where('more_formfields_details.package_inquiry_id', $packageEnquiryFormId)
                ->select('form_fileds.lable_name', 'more_formfields_details.formfield_value', 'more_formfields_details.form_field_id')
                ->get()
                ->toArray();
        }

        return view('front.enquiry_sub', $data);
    }


    public function package_inquiry(Request $request)
    {

        //   echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $userdata = Session::get('user');

        //    echo "<pre>";print_r($userdata);echo "</pre>";exit;


        if (isset($userdata) && $userdata != "" && !empty($userdata)) {
            //echo "if";exit;
            $data['name'] = $username = $userdata['name'];
            $data['email'] = $email = $userdata['email'];
            $data['mobile'] = $mobile = $userdata['mobile'];
        } else {
            $data['name'] = $username = '';
            $data['email'] = $email = '';
            $data['mobile'] = $mobile = '';
        }

        // echo "<pre>";print_r($request->all());echo "</pre>";exit;

        //$data['name']=$request->name;
        if ($request->pakage_id != '') {
            $data['pakage_id'] = $request->pakage_id;
        }
        if ($request->service_id != '') {
            $data['service_id'] = $request->service_id;
        } elseif ($request->service != '') {
            $data['service_id'] = $request->service;
        }

        if ($request->subservice_id != '') {
            $data['subservice_id'] = $request->subservice_id;
        } elseif ($request->subservice != '') {
            $data['subservice_id'] = $request->subservice;
        }
        if ($request->packagecategory_id != '') {
            $data['packagecategory_id'] = $request->packagecategory_id;
        }

        $data['added_date'] = date('Y-m-d');
        $data['form_type'] = $request->form_type;
        $data['user_id'] = $userdata['userid'] ?? 0;

        if ($request->subservice_id == 94) {
            $data['cron_mail_send'] = 1;
        }

        $package_inquiry = DB::table('packages_enquiry',)->insertGetId($data);

        $customerInfo = DB::table('frontloginregisters')->where('id', $data['user_id'] ?? 0)->first();
        $pendingLeadId = Session::get('enquiry_pending_lead_id');
        if ($pendingLeadId) {
            DB::table('general_enquiries')->where('id', $pendingLeadId)->update([
                'status' => 'Pending',
                'customer_name' => $customerInfo ? $customerInfo->name : ($data['name'] ?? null),
                'customer_phone' => $customerInfo ? $customerInfo->mobile : ($data['mobile'] ?? null),
                'customer_email' => $customerInfo ? $customerInfo->email : ($data['email'] ?? null),
                'updated_at' => now(),
            ]);
        } else {
            $sourceWebsite = DB::table('source_leads')->where('name', 'Website')->first();

            $repeatedSource = DB::table('source_leads')->where('name', 'Repeted Customer')->first();
            $pastOrders = DB::table('ci_orders')->where('user_id', $data['user_id'] ?? 0)->count();
            $sourceWebsiteId = $sourceWebsite ? $sourceWebsite->id : null;
            $repeatedSourceId = $repeatedSource ? $repeatedSource->id : null;
            if ($pastOrders > 0 && $repeatedSourceId) {
                $sourceLeadId = $sourceWebsiteId . ',' . $repeatedSourceId;
            } else {
                $sourceLeadId = $sourceWebsiteId;
            }

            $salespersonId = null;
            if ($pastOrders > 0) {
                $lastOrder = DB::table('ci_orders')
                    ->join('ci_order_item', 'ci_orders.order_id', '=', 'ci_order_item.order_id')
                    ->where('ci_orders.user_id', $data['user_id'] ?? 0)
                    ->whereNotNull('ci_order_item.salesperson_id')
                    ->orderBy('ci_orders.order_id', 'desc')
                    ->select('ci_order_item.salesperson_id')
                    ->first();
                if ($lastOrder) {
                    $salespersonId = $lastOrder->salesperson_id;
                }
            }

            $leadId = DB::table('general_enquiries')->insertGetId([
                'salesperson_id' => $salespersonId,
                'customer_id' => $data['user_id'] ?? null,
                'customer_name' => $customerInfo ? $customerInfo->name : ($data['name'] ?? null),
                'customer_phone' => $customerInfo ? $customerInfo->mobile : ($data['mobile'] ?? null),
                'customer_email' => $customerInfo ? $customerInfo->email : ($data['email'] ?? null),
                'country_code' => $customerInfo ? $customerInfo->country_code : null,
                'service_id' => $data['service_id'] ?? null,
                'subservice_id' => $data['subservice_id'] ?? null,
                'source_lead_id' => $sourceLeadId,
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            Session::put('enquiry_pending_lead_id', $leadId);
        }
        $package_data_n = DB::table('packages_enquiry',)->where('id', $package_inquiry)->first();

        $service_name = \Helper::servicename($package_data_n->service_id);

        $processed_text = strtoupper(str_replace(' ', '', $service_name));

        $year = date('y');
        $data_u = []; // Initialize to prevent undefined variable error

        if ($request->subservice_id == 23 || $request->subservice_id == 26 || $request->subservice_id == 53 || $request->subservice_id == 94 || $request->subservice_id == 100 || $request->subservice_id == 98) { //apartment moving,villa moving,office moving, international moving, studio moving

            if ($request->form_type == 'Local Move') {

                $formFieldIds = $request->form_field_id;
                $formFieldVals = $request->formfield_value;

                $cityOptionId = null;

                foreach ($formFieldIds as $index => $fieldId) {
                    if ($fieldId == 17) {   // 17 = City field ID
                        $cityOptionId = $formFieldVals[$index];
                        break;
                    }
                }

                $cityOption = DB::table('form_attributes')
                    ->where('id', $cityOptionId)
                    ->first();

                $CityName = $cityOption->form_option ?? '';

                //$cityId = $request->formfield_value[0] ?? 0;

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

                $data_u['subservice_code'] = $subserviceCode;
                $data_u['city_code'] = $cityCode;
                $data_u['order_year'] = $year;
                $data_u['sequence_no'] = $nextSequence;
                $data_u['inquiry_id'] = $formatOrderId;
            } else {

                $formFieldIds = $request->form_field_id;
                $formFieldVals = $request->formfield_value;

                $countryOptionId = null;

                foreach ($formFieldIds as $index => $fieldId) {
                    if ($fieldId == 57) {   // 57 = Country field ID internatonal
                        $countryOptionId = $formFieldVals[$index];
                        break;
                    }
                }
                //echo $countryOptionId;exit;

                $countryOption = DB::table('form_attributes')
                    ->where('id', $countryOptionId)
                    ->first();

                //echo"<pre>";print_r($countryOption);exit;

                $CountryName = $countryOption->form_option ?? 'OT';
                $countryCode = mb_strtoupper(mb_substr($CountryName, 0, 3, 'UTF-8'));

                $subserviceData = DB::table('subservices')->where('id', $request->subservice_id)->first();

                if (isset($subserviceData)) {
                    if (isset($subserviceData->subservice_code)) {
                        $subserviceCode = "I" . $subserviceData->subservice_code;
                    } else {
                        $subserviceCode = 'OT';
                    }
                } else {
                    $subserviceCode = 'OT';
                }

                $year = date('y');

                $lastSequence = DB::table('packages_enquiry')
                    ->where('subservice_code', $subserviceCode)
                    ->where('city_code', $countryCode)
                    ->where('order_year', $year)
                    ->selectRaw('MAX(CAST(sequence_no AS UNSIGNED)) as seq')
                    ->lockForUpdate()
                    ->value('seq');

                $nextSequence = $lastSequence ? $lastSequence + 1 : 1;

                $formatOrderId = sprintf(
                    "%s-%s-%s-%06d",
                    $subserviceCode,
                    $year,
                    $countryCode,
                    $nextSequence
                );

                $data_u['subservice_code'] = $subserviceCode;
                $data_u['city_code'] = $countryCode;
                $data_u['order_year'] = $year;
                $data_u['sequence_no'] = $nextSequence;
                $data_u['inquiry_id'] = $formatOrderId;
            }
        }

        if ($request->subservice_id == 31) { // vehicle shipping

            $formFieldIds = $request->form_field_id;
            $formFieldVals = $request->formfield_value;

            $countryOptionId = null;

            foreach ($formFieldIds as $index => $fieldId) {
                if ($fieldId == 39) {   // 39 = Country field ID internatonal
                    $countryOptionId = $formFieldVals[$index];
                    break;
                }
            }
            //echo $countryOptionId;exit;

            $countryOption = DB::table('form_attributes')
                ->where('id', $countryOptionId)
                ->first();

            //echo"<pre>";print_r($countryOption);exit;

            $CountryName = $countryOption->form_option;

            $countriesData = DB::table('countries')->whereRaw('country LIKE ?', ['%' . strtolower($CountryName) . '%'])->first();

            if (isset($countriesData)) {
                $countryCode = $countriesData->country_code ?? '';
            } else {
                $countryCode = mb_strtoupper(mb_substr($CountryName, 0, 3, 'UTF-8'));
            }

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

            $year = date('y');

            $lastSequence = DB::table('packages_enquiry')
                ->where('subservice_code', $subserviceCode)
                ->where('city_code', $countryCode)
                ->where('order_year', $year)
                ->selectRaw('MAX(CAST(sequence_no AS UNSIGNED)) as seq')
                ->lockForUpdate()
                ->value('seq');

            $nextSequence = $lastSequence ? $lastSequence + 1 : 1;

            $formatOrderId = sprintf(
                "%s-%s-%s-%06d",
                $subserviceCode,
                $year,
                $countryCode,
                $nextSequence
            );

            $data_u['subservice_code'] = $subserviceCode;
            $data_u['city_code'] = $countryCode;
            $data_u['order_year'] = $year;
            $data_u['sequence_no'] = $nextSequence;
            $data_u['inquiry_id'] = $formatOrderId;
        }

        if ($request->subservice_id == 61 || $request->subservice_id == 62 || $request->subservice_id == 64 || $request->subservice_id == 66) { // self storage,ac storage,non ac storage,vehicle storage

            $formFieldIds = $request->form_field_id;
            $formFieldVals = $request->formfield_value;

            $cityOptionId = null;

            foreach ($formFieldIds as $index => $fieldId) {
                if ($fieldId == 69) {   // 39 = city field 
                    $cityOptionId = $formFieldVals[$index];
                    break;
                }
            }

            $cityOption = DB::table('form_attributes')
                ->where('id', $cityOptionId)
                ->first();

            $CityName = $cityOption->form_option ?? '';

            //$cityId = $request->formfield_value[0] ?? 0;

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

            $data_u['subservice_code'] = $subserviceCode;
            $data_u['city_code'] = $cityCode;
            $data_u['order_year'] = $year;
            $data_u['sequence_no'] = $nextSequence;
            $data_u['inquiry_id'] = $formatOrderId;
        }

        //echo"<pre>";print_r($data_u);exit;
        if (!empty($data_u)) {
            DB::table('packages_enquiry')->where('id', $package_inquiry)->update($data_u);
        }

        //$data_u['inquiry_id'] = "IQ-".$processed_text."-" . $year ."-". sprintf("%06d", $package_inquiry);
        //DB::table('packages_enquiry')->where('id', $package_inquiry)->update($data_u);

        Session::put('packages_enquiry_form_id', $package_inquiry);

        if ($request->form_field_id != '' && count($request->form_field_id) > 0) {
            foreach ($request->form_field_id as $key => $value) {
                // Check if both form_field_id and formfield_value are not empty
                if (!empty($value) && isset($request->formfield_value[$key])) {
                    $data1['package_inquiry_id'] = $package_inquiry;
                    $data1['form_field_id'] = $value;
                    $data1['formfield_value'] = $request->formfield_value[$key];

                    DB::table('more_formfields_details')->insert($data1);



                    if ($request->has("formfield_value_more" . $value) && is_array($request->input("formfield_value_more" . $value))) {
                        foreach ($request->input("formfield_value_more" . $value) as $option) {
                            if ($option != '') {

                                $data_attr['form_id'] = $value;
                                $data_attr['more_form_attributes_id'] = $option;
                                $data_attr['package_inquiry_id'] = $package_inquiry;
                                DB::table('more_formfields_details_att')->insert($data_attr);
                            }
                        }
                    }
                }
            }
        }


        if ($request->form_field_radio_id_one != '' && count($request->form_field_radio_id_one) > 0) {

            foreach ($request->form_field_radio_id_one as $key1 => $values1) {

                $radioVal = $request->form_field_radio_id_one[$key1];

                if ($request->form_field_radio_id_one[$key1] != '') {

                    $data2['package_inquiry_id'] = $package_inquiry;

                    $data2['form_field_id'] = $request->form_field_radio_id_one[$key1];
                    $data2['formfield_value'] = $request['formfield_radio_' . $radioVal];


                    DB::table('more_formfields_details')->insert($data2);
                }
            }
        }
        // if ($request->form_field_radio_id_two != '' && count($request->form_field_radio_id_two) > 0) {

        //     foreach($request->form_field_radio_id_two as $key1 => $values1) {

        //         $radioVal = $request->form_field_radio_id_two[$key1];

        //         if ($request->form_field_radio_id_two[$key1] != '') {

        //             $data2['package_inquiry_id'] = $package_inquiry;

        //              $data2['form_field_id'] = $request->form_field_radio_id_two[$key1];
        //              $data2['formfield_value'] = $request['formfield_radio_'.$radioVal];


        //              DB::table('more_formfields_details')->insert($data2);
        //         }
        //     }    
        // }

        if ($request->form_field_checkbox_id_one != '' && count($request->form_field_checkbox_id_one) > 0) {

            foreach ($request->form_field_checkbox_id_one as $key1 => $values1) {

                $ckeckboxVal = $request->form_field_checkbox_id_one[$key1];

                if ($request->form_field_checkbox_id_one[$key1] != '') {

                    $data3['package_inquiry_id'] = $package_inquiry;

                    $data3['form_field_id'] = $request->form_field_checkbox_id_one[$key1];
                    $data3['formfield_value'] = $request['formfield_checkbox_' . $ckeckboxVal];



                    // $data3['formfield_value'] = $request['formfield_checkbox_'.$key1];
                    if ($data3['formfield_value'] != '') {

                        $data3['formfield_value'] = implode(",", $data3['formfield_value']);
                    } else {
                        $data3['formfield_value'] = null;
                    }



                    // echo "<pre>";print_r($data123);echo "</pre>";exit;

                    DB::table('more_formfields_details')->insert($data3);
                }
            }
        }

        // if ($request->form_field_checkbox_id_two != '' && count($request->form_field_checkbox_id_two) > 0) {

        //     foreach($request->form_field_checkbox_id_two as $key1 => $values1) {                    

        //         $ckeckboxVal = $request->form_field_checkbox_id_two[$key1];                    

        //         if ($request->form_field_checkbox_id_two[$key1] != '') {

        //             $data3['package_inquiry_id'] = $package_inquiry;

        //              $data3['form_field_id'] = $request->form_field_checkbox_id_two[$key1];
        //              $data3['formfield_value'] = $request['formfield_checkbox_'.$ckeckboxVal];



        //             // $data3['formfield_value'] = $request['formfield_checkbox_'.$key1];
        //            if($data3['formfield_value'] !=''){

        //             $data3['formfield_value'] = implode(",", $data3['formfield_value']);

        //            }else{
        //             $data3['formfield_value'] = null;
        //            }



        //             // echo "<pre>";print_r($data123);echo "</pre>";exit;

        //              DB::table('more_formfields_details')->insert($data3);
        //         }
        //     }    
        // }

        if ($request->form_field_mul_dropdown_id != '' && count($request->form_field_mul_dropdown_id) > 0) {

            foreach ($request->form_field_mul_dropdown_id as $key1 => $values1) {

                $Multiple_drop_down_Val = $request->form_field_mul_dropdown_id[$key1];

                if ($request->form_field_mul_dropdown_id[$key1] != '') {

                    $data4['package_inquiry_id'] = $package_inquiry;

                    $data4['form_field_id'] = $request->form_field_mul_dropdown_id[$key1];
                    $data4['formfield_value'] = $request['formfield_mul_dropdown_' . $Multiple_drop_down_Val];



                    // $data3['formfield_value'] = $request['formfield_checkbox_'.$key1];
                    if ($data4['formfield_value'] != '') {

                        $data4['formfield_value'] = implode(",", $data4['formfield_value']);
                    } else {
                        $data4['formfield_value'] = null;
                    }


                    // echo "<pre>";print_r($data123);echo "</pre>";exit;

                    DB::table('more_formfields_details')->insert($data4);
                }
            }
        }

        if (isset($request->form_field_id_image[0]) && $request->form_field_id_image[0] != '') {
            $formImage_id = $request->form_field_id_image[0];
            $formImageValue = $request->file('formfield_Image_value' . $formImage_id);
            //echo "<pre>";print_r($files);echo "</pre>";exit;
            if ($formImageValue != '') {

                foreach ($formImageValue as $key1 => $values1) {
                    $imageVal = $formImageValue[$key1];


                    if ($formImageValue[$key1] != '') {
                        $data1['package_inquiry_id'] = $package_inquiry;

                        $data1['form_field_id'] = $formImage_id;

                        $images = $formImageValue[$key1];

                        $imageName = time() . '-' . $images->getClientOriginalName();
                        //echo "<pre>";print_r($imageName);echo "</pre>";exit;
                        $destinationPath = public_path('upload/enquiry_images');
                        $images->move($destinationPath, $imageName);

                        $data1['formfield_value'] = $imageName;

                        //echo "<pre>";print_r($data1);echo "</pre>";exit;
                        DB::table('more_formfields_details')->insert($data1);
                    }
                }
            }
        }

        $userdata = Session::get('user');


        //if(isset($userdata)){
        return redirect()
            ->route('enquiry', ['service_id' => $data['service_id'], 'subservice_id' => $data['subservice_id']])
            ->with('L_strsucessMessage', '')
            ->with('redirected_from_first_form', true);
        // }else{

        //     $param_ids = [
        //             'service_id' => $data['service_id'],
        //             'subservice_id'  => $data['subservice_id']
        //         ];

        //     Session::put('param_ids', $param_ids);
        // 	return redirect()->route('Sign-in');
        // }

    }

    public function package_inquiry_new(Request $request)
    {

        $packageEnquiryFormId = session('packages_enquiry_form_id');

        Session::put('get_quote_session_orderid', $packageEnquiryFormId);

        $package_data = DB::table('packages_enquiry')->where('id', $packageEnquiryFormId)->first();

        if (!$package_data) {
            return redirect()->to('/');
        }

        $subservice_name = \Helper::subservicename($package_data->subservice_id);


        $userdata = Session::get('user');
        $user_email = $userdata['email'] ?? '';
        $user_name = $userdata['name'] ?? '';
        $user_mobile = $userdata['mobile'] ?? '';
        $user_id = $userdata['userid'] ?? 0;

        DB::table('packages_enquiry')->where('id', $packageEnquiryFormId)->update([
            'user_id' => $user_id,
            'name' => $user_name,
            'email' => $user_email,
            'mobile' => $user_mobile
        ]);

        $pendingLeadId = Session::get('enquiry_pending_lead_id');
        if ($pendingLeadId) {
            DB::table('general_enquiries')->where('id', $pendingLeadId)->update([
                'status' => 'Booked',
                'updated_at' => now(),
            ]);
            Session::forget('enquiry_pending_lead_id');
        }

        $message_bodyy = '';

        if ($package_data->subservice_id == 94) {
            $thankMsg = 'Thank you for reaching out to VendorsCity! We have received your request for free quotes for ';
            $thankMsg1 = 'quotes';
        } else {
            $thankMsg = 'Thank you for reaching out to VendorsCity! We have received your request for up to 5 free quotes for ';
            $thankMsg1 = '5 quotes ';
        }

        $message_bodyy .= '<!doctype html>

    
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
                        font-size:14px;line-height:24px;font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
            <div class="logo"style="float: inherit;border-bottom: 4px solid #FFD413;">
            <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '"" style="width: 40%;"  >
            </div>
            <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;" >
                <p>Dear ' . $user_name . ',</p>
                <p>' . $thankMsg . ' ' . \Helper::servicename($request->service_id) . '.
                </p>
                <p><strong>What Happens Next?</strong></p>

                <p>Our trusted vendors will review your request and will contact you within 2 business days.
                You will receive up to ' . $thankMsg1 . ' tailored to your specific  ' . \Helper::servicename($request->service_id) . ' needs.
                </p>
                <p><strong>How to Choose the Best Vendor:</strong></p>
                <ul><li style= "list-style-type: disc;margin-bottom: -15px;">Review the quotes you receive.</li>
                <li style= "list-style-type: disc;margin-bottom: -15px;">Check out the vendor ratings and reviews to make an informed decision.</li>
                <li style= "list-style-type: disc";>Select the vendor that best suits your requirements.</li></ul>  
                <p>We are committed to helping you find the best services quickly and easily. If you have any questions or need further assistance, please don&#39;t hesitate to contact us at support@vendorscity.com.
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


        $subject = " Your Request for Free Quotes on " . \Helper::servicename($request->service_id) . " is Being Processed!";


        //    echo $message_bodyy;exit;

        $to = $user_email;
        $ccRecipients = [];

        // $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];
        // $to = "mayudin.hnrtechnologies@gmail.com";
        if (isset($to)) {
            Mail::send([], [], function ($message) use ($message_bodyy, $to, $subject, $ccRecipients) {
                $message->to($to);
                $message->subject($subject);
                foreach ($ccRecipients as $ccRecipient) {
                    $message->bcc($ccRecipient);
                }
                $message->html($message_bodyy);
            });
        }

        if (isset($packageEnquiryFormId) && $packageEnquiryFormId != '') {
            session()->forget('packages_enquiry_form_id');
        }

        $packageEnquiryFormId = session('get_quote_session_orderid');
        Session::put('thank_enquiry_id', $packageEnquiryFormId);

        return redirect()->route('enquiry.thankyou');
    }
    public function enquiry_thankyou(Request $request)
    {
        $enquiryId = session('thank_enquiry_id');
        if (!$enquiryId) {
            return redirect('/');
        }

        $enquiry = DB::table('packages_enquiry')->where('id', $enquiryId)->first();
        if (!$enquiry) {
            return redirect('/');
        }

        $submittedFields = DB::table('more_formfields_details')
            ->join('form_fileds', 'more_formfields_details.form_field_id', '=', 'form_fileds.id')
            ->where('more_formfields_details.package_inquiry_id', $enquiryId)
            ->select('form_fileds.lable_name', 'more_formfields_details.formfield_value', 'more_formfields_details.form_field_id')
            ->get();

        return view('front.enquiry_thankyou_new', [
            'enquiry' => $enquiry,
            'submittedFields' => $submittedFields
        ]);
    }
    function change_drop_down(Request $request)
    {

        $form_id = $request->form_id;
        $form_inner_id = $request->form_inner_id;

        $get_data = DB::table('more_form_attributes')
            ->where('form_id', '=', $form_id)
            ->where('attr_id', '=', $form_inner_id)
            ->get();
        $html = "";
        if (isset($get_data) && count($get_data) > 0) {
            $html .= '<label class="form-label fw500 dark-color"
            for="country">What is the size of your home?</label>';
            if ($form_id == 35 && $form_inner_id == 111) {
                $html .= '<select class="form-control multiple" id="formfield_value_test" name="formfield_value_more' . $form_id . '[]" multiple="multiple">';
            } else {
                $html .= '<select class="form-control" id="formfield_value_test" name="formfield_value_more' . $form_id . '[]">';
            }

            $html .= '<option value="">Select </option>';
            foreach ($get_data as $index => $get_data_new) {

                $selected = ($index == 0) ? 'selected' : '';

                // Add the option to the dropdown
                $html .= '<option value="' . $get_data_new->id . '" ' . $selected . '>' . $get_data_new->more_form_option . '</option>';
                // echo "<pre>";
                // print_r($get_data_new);
                // echo "</pre>";
            }
            $html .= '</select>';
        }
        echo $html;
        // Output the retrieved data

        //exit;
    }
    function change_drop_down_two(Request $request)
    {

        $form_id = $request->form_id;
        $form_inner_id = $request->form_inner_id;

        $get_data = DB::table('more_form_attributes')
            ->where('form_id', '=', $form_id)
            ->where('attr_id', '=', $form_inner_id)
            ->get();
        $html = "";
        if (isset($get_data) && count($get_data) > 0) {
            $html .= '<label class="form-label fw500 dark-color" for="country">What is the size of your home?</label>';
            $html .= '<select class="form-control" id="formfield_value_test" name="formfield_value_more' . $form_id . '[]">';
            $html .= '<option value="">Select </option>';
            foreach ($get_data as $index => $get_data_new) {

                $selected = ($index == 0) ? 'selected' : '';

                // Add the option to the dropdown
                $html .= '<option value="' . $get_data_new->id . '" ' . $selected . '>' . $get_data_new->more_form_option . '</option>';
                // echo "<pre>";
                // print_r($get_data_new);
                // echo "</pre>";
            }
            $html .= '</select>';
        }
        echo $html;
        // Output the retrieved data

        //exit;
    }
    public function download($filepath)
    {
        $Downloads = public_path("upload/enquiry_images/{$filepath}");
        return response()->download($Downloads);
    }

    function get_size_home_price(Request $request)
    {

        $homeSizeId = $request->size_home_id;
        $result = DB::table('painting_prices')->where('id', $homeSizeId)->first();
        // echo "<pre>";print_r($result);echo "</pre>";exit;

        $data = [
            'status' => 'success',
            'price' => $result->price,
            'size_of_home' => $result->size_of_home
        ];

        echo json_encode($data);
        //echo $result;

    }
    function get_color_painted_price(Request $request)
    {

        // echo "<pre>";print_r($request->all());echo "</pre>";exit;
        if ($request->color_you_want_paint_id == 1) {
            // echo"here";exit;
            /* Get Apartment Price  */
            $colorYouWantPaintId = $request->color_you_want_paint_id;
            $colorType = $request->color_type;
            $types_of_tab = "apartment";
            $result = DB::table('painting_prices')
                ->where('size_of_home', 'LIKE', '%' . $colorType . '%')
                ->where('flags_of_tab', $colorYouWantPaintId)
                ->where('types_of_tab', $types_of_tab)
                ->value('price');
            echo $result;
        }

        if ($request->color_you_want_paint_id == 2) {
            /* Get Villa Price  */
            $colorYouWantPaintId = $request->color_you_want_paint_id;
            $colorType = $request->color_type;
            $types_of_tab = "villa";
            $result = DB::table('painting_prices')
                ->where('size_of_home', 'LIKE', '%' . $colorType . '%')
                ->where('flags_of_tab', $colorYouWantPaintId)
                ->where('types_of_tab', $types_of_tab)
                ->value('price');
            echo $result;
        }
    }
    function get_colornow_paint_price(Request $request)
    {

        //echo "<pre>";print_r($request->all());echo "</pre>";exit;
        if ($request->color_your_walls_now_id == 1) {
            /* Get Apartment Price  */
            $colorYourWallsNowId = $request->color_your_walls_now_id;
            $colorType = $request->color_type;
            $types_of_tab = "apartment";
            $result = DB::table('painting_prices')
                ->where('size_of_home', 'LIKE', '%' . $colorType . '%')
                ->where('flags_of_tab', $colorYourWallsNowId)
                ->where('types_of_tab', $types_of_tab)
                ->value('price');
            echo $result;
        }

        if ($request->color_your_walls_now_id == 2) {
            /* Get Villa Price  */
            $colorYourWallsNowId = $request->color_your_walls_now_id;
            $colorType = $request->color_type;
            $types_of_tab = "villa";
            $result = DB::table('painting_prices')
                ->where('size_of_home', 'LIKE', '%' . $colorType . '%')
                ->where('flags_of_tab', $colorYourWallsNowId)
                ->where('types_of_tab', $types_of_tab)
                ->value('price');
            echo $result;
        }
    }

    function get_home_furnished_price(Request $request)
    {

        //   echo "<pre>";print_r($request->all());echo "</pre>";exit;
        if ($request->is_your_home_furnished_flg == 3) {

            /* Get Apartment Price  */
            $isYourHomeFurnishedFlag = $request->is_your_home_furnished_flg;
            $isYourHomeFurnishedVal = $request->home_furnished_val;
            $types_of_tab = "apartment";
            $result = DB::table('painting_prices')
                ->where('flags_of_tab', $isYourHomeFurnishedFlag)
                ->where('types_of_tab', $types_of_tab)
                ->value('price');

            // echo "<pre>";print_r($result);echo "</pre>";exit;
            echo $result;
        }

        if ($request->is_your_home_furnished_flg == 4) {
            /* Get Villa Price  */
            $isYourHomeFurnishedFlag = $request->is_your_home_furnished_flg;
            $colorType = $request->home_furnished_val;
            $types_of_tab = "villa";
            $result = DB::table('painting_prices')
                ->where('flags_of_tab', $isYourHomeFurnishedFlag)
                ->where('types_of_tab', $types_of_tab)
                ->value('price');
            echo $result;
        }
    }

    function whatsappmsg_tmp_new_lead_alert($vendor_data, $package_id)
    {


        $package_inquiry_data = DB::table('packages_enquiry')
            ->where('id', $package_id)
            ->first();

        $phone = $vendor_data->country_code . '' . $vendor_data->mobile;
        $service_name = Helper::servicename($package_inquiry_data->service_id);


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
            CURLOPT_POSTFIELDS => '{"messages":[{"to":"' . $phone . '","content":{"templateName":"new_lead_alert","language":"en","templateData":{"body":{"placeholders":["' . $service_name . '"]},"buttons":[{"type":"URL"}]}}}]}',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'content-type: application/json',
                'Authorization: key_uTZeOXQPMd'
            ),
        ));

        $response = curl_exec($curl);
    }

    public function package_get_timeslots(Request $request)
    {
        //echo "<pre>";print_r($request->all());echo"</pre>";exit;
        $subservice_id = $request->subservice_id;
        $selectedDate = $request->date;  // format: 2025-11-21

        $today = \Carbon\Carbon::now('Asia/Dubai')->format('Y-m-d');
        $currentTime = \Carbon\Carbon::now('Asia/Dubai');
        $bufferTime = $currentTime->copy()->addHours(2);

        $timeslots = \DB::table('time_slots')
            ->orderBy('set_order', 'asc')
            ->get();

        $html = "";
        $i = 1;

        foreach ($timeslots as $slot) {

            // Extract start time
            $startTimeString = explode('-', $slot->name)[0];
            $slotStartTime = \Carbon\Carbon::createFromFormat('g:i A', trim($startTimeString), 'Asia/Dubai');

            // Apply buffer logic ONLY if date == today
            if ($selectedDate == $today && $slotStartTime->lt($bufferTime)) {
                continue;
            }

            // Fetch price
            $priceData = \DB::table('subservice_timeslot_price')
                ->where('subservice_id', $subservice_id)
                ->where('time_slot_id', $slot->id)
                ->where('is_active', 1)
                ->first();

            if (!$priceData) {
                continue;
            }

            $price = ($priceData && $priceData->price > 0) ? $priceData->price : 0;
            $dirhamIcon = asset('public/site/images/automobile/DirhamBlack.png');
            // Build slot HTML
            $html .= '
<div class="surcharge-badge-timeslot items">
    ' . ($price > 0
                ? '<span class="badgespantime">+ <p class="currency_dhiramnew">AED</p> ' . $price . '</span>'
                : ''
            ) . '
    <input type="radio" id="time' . $i . '" name="time_slot"
           value="' . $slot->id . '"
           onclick="timeSlotClick(' . $price . ', \'' . $slot->name . '\')">

    <label class="labeltime" for="time' . $i . '" style="border-radius:50px;">
        ' . $slot->name . '
    </label>
</div>';
            $i++;
        }

        return response()->json(['html' => $html]);
    }
}
