<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Helper
{

    public static function get_user_data(string $string)
    {
        $query = DB::table("users")->where("id", $string);
        if ($query->count() > 0) {
            return $query->get()->first();
        } else {
            return false;
        }
    }

    public static function get_front_user_data(string $string)
    {
        $query = DB::table("frontloginregisters")->where("id", $string);
        if ($query->count() > 0) {
            return $query->get()->first();
        } else {
            return false;
        }
    }

    public static function get_product_data(string $string)
    {
        $query = DB::table("products")->where("id", $string);
        if ($query->count() > 0) {
            return $query->get()->first();
        } else {
            return false;
        }
    }

    public static function get_permission_data(string $string)
    {
        $query = DB::table("user_permissions")->where("id", $string);
        if ($query->count() > 0) {
            return $query->get()->first();
        } else {
            return false;
        }
    }

    public static function categoryname(int $id)
    {

        $result = DB::table('categories')->where('id', $id)->first();

        if ($result != '' && isset($result)) {
            return $result->name;
        } else {
            echo "-";
        }
    }

    public static function groupname(string $group_id)
    {
        $query = DB::table('groups')->where('id', $group_id)->first();
        if ($query) {
            return $query->name;
        } else {

            return '-';
        }
    }
    public static function countryname(string $country_id)
    {
        $query = DB::table('countries')->where('id', $country_id)->first();
        if ($query) {
            return $query->country;
        } else {

            return '-';
        }
    }

    public static function continent_name(string $continent_id)
    {
        $query = DB::table('continents')->where('id', $continent_id)->first();
        if ($query) {
            return $query->continent;
        } else {

            return '-';
        }
    }
    public static function cityname(string $city)
    {
        $query = DB::table('cities')->where('id', $city)->first();
        if ($query) {
            return $query->name;
        } else {

            return '-';
        }
    }
    public static function city_name_for_garden(?string $city)
    {
        if (empty($city)) {
            return '-';
        }

        $query = DB::table('cities')->where('id', $city)->first();

        return $query?->name ?? '-';
    }

    public static function state_name(string $state_id)
    {
        $query = DB::table('states')->where('id', $state_id)->first();
        if ($query) {
            return $query->state;
        } else {

            return '-';
        }
    }

    public static function user_role_name(int $id)
    {

        $result = DB::table('user_permissions')->where('id', $id)->first();
        if ($result != '' && isset($result)) {
            return $result->cname;
        } else {
            echo "-";
        }
    }

    public static function check_wishlist($product_id)
    {
        $query = DB::table("wishlist")->where("userid", Session::get('userdata')['userid'])->where("product_id", $product_id);
        if ($query->count() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public static function servicename($id)
    {

        $result = DB::table('services')->where('id', $id)->first();

        if ($result != '' && isset($result)) {
            return $result->servicename;
        } else {
            return "-";
        }
    }

    public static function subservicename(int $id)
    {

        $result = DB::table('subservices')->where('id', $id)->first();

        if ($result != '' && isset($result)) {
            return $result->subservicename;
        } else {
            echo "-";
        }
    }

    public static function subservicename_multiple($ids)
    {
        if (empty($ids)) {
            return "-";
        }

        // Convert "20,21" into array [20,21]
        $idArray = explode(',', $ids);

        // Fetch names for all IDs
        $result = DB::table('subservices')
            ->whereIn('id', $idArray)
            ->pluck('subservicename');

        if ($result->isEmpty()) {
            return "-";
        }

        // Convert collection to comma separated string
        return implode(', ', $result->toArray());
    }

    public static function timeslotname($id)
    {
        if (empty($id)) {
            return "-";
        }

        if (!is_numeric($id)) {
            return $id;
        }

        $result = DB::table('time_slots')->where('id', $id)->first();

        return $result->name ?? "-";
    }

    public static function packagescategory(int $id)
    {

        $result = DB::table('package_categories')->where('id', $id)->first();

        if ($result != '' && isset($result)) {
            return $result->name;
        } else {
            echo "-";
        }
    }
    public static function vendorsname(int $id)
    {

        $result = DB::table('users')->where('id', $id)->first();

        if ($result != '' && isset($result)) {
            return $result->name;
        } else {
            return "-";
        }
    }

    public static function vendorInfo(int $id)
    {

        $result = DB::table('users')->where('id', $id)->first();

        if ($result != '' && isset($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public static function salesPersonInfo(int $salesperson_id)
    {

        $result = DB::table('users')->where('id', $salesperson_id)->first();

        if ($result != '' && isset($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public static function crewInfo(array $crewIds, ?int $serviceId = null, ?int $subServiceId = null)
    {
        $query = DB::table('users')
            ->where('role_id', 16)
            ->where('is_active', '0')
            ->whereIn('id', $crewIds);

        if ($serviceId) {
            $query->whereRaw('FIND_IN_SET(?, service)', [$serviceId]);
        }

        if ($subServiceId) {
            $query->whereRaw('FIND_IN_SET(?, subservice)', [$subServiceId]);
        }

        return $query->get(); // Always return collection
    }

    public static function driverInfo(int $driverId)
    {
        $user = Auth::user();
        $query = DB::table('users')
            ->where('role_id', 15)
            ->where('is_active', '0')
            ->where('added_by', $user->id)
            ->where('id', $driverId)
            ->first();

        return $query ?? false;
    }

    public static function singleCrewInfo(int $crewId, ?int $serviceId = null, ?int $subServiceId = null)
    {
        $query = DB::table('users')
            ->where('role_id', 16)
            ->where('is_active', '0')
            ->where('id', $crewId);

        if ($serviceId) {
            $query->whereRaw('FIND_IN_SET(?, service)', [$serviceId]);
        }

        if ($subServiceId) {
            $query->whereRaw('FIND_IN_SET(?, subservice)', [$subServiceId]);
        }

        return $query->first(); // returns object or null
    }

    public static function salesperson(?int $id)
    {
        if (is_null($id)) {
            return "-";
        }

        $result = DB::table('users')->where('id', $id)->first();

        return $result->name ?? "-";
    }

    public static function crewNames(array $crewIds, ?int $serviceId = null, ?int $subServiceId = null)
    {
        $query = DB::table('users')
            ->where('role_id', 16)
            ->where('is_active', '0')
            ->whereIn('id', $crewIds);

        if ($serviceId) {
            $query->whereRaw('FIND_IN_SET(?, service)', [$serviceId]);
        }

        if ($subServiceId) {
            $query->whereRaw('FIND_IN_SET(?, subservice)', [$subServiceId]);
        }

        $result = $query->pluck('name'); // get only names

        if ($result->isNotEmpty()) {
            return $result->implode(', '); // comma separated
        }

        return '-';
    }

    public static function drivername(?int $id)
    {
        if (is_null($id)) {
            return "-";
        }

        $result = DB::table('users')->where('id', $id)->first();

        return $result->name ?? "-";
    }
    public static function cleanername(?int $id)
    {

        if (is_null($id)) {
            return "-";
        }
        $result = DB::table('users')->where('id', $id)->first();

        return $result->name ?? "-";
    }

    public static function cleanername_new($id)
    {
        if (is_null($id)) {
            return "-";
        }

        if (!is_array($id)) {
            $id = [$id];
        }
        $cleaners = DB::table('users')
            ->whereIn('id', $id)
            ->pluck('name')
            ->toArray();


        return !empty($cleaners) ? implode(', ', $cleaners) : '-';
    }


    public static function packages_enquiry(int $id)
    {

        $result = DB::table('packages')->where('id', $id)->first();

        if ($result != '' && isset($result)) {
            return $result->name;
        } else {
            echo "-";
        }
    }
    public static function addonspackages_enquiry(int $id)
    {

        $result = DB::table('addons')->where('id', $id)->first();

        if ($result != '' && isset($result)) {
            return $result->name;
        } else {
            echo "-";
        }
    }
    public static function form_fields(int $id)
    {

        $result = DB::table('form_fileds')->where('id', $id)->first();

        if ($result != '' && isset($result)) {
            return $result->lable_name;
        } else {
            echo "-";
        }
    }
    public static function form_fields_attr(string $id)
    {

        $result = DB::table('form_attributes')->where('id', $id)->first();

        if ($result != '' && isset($result)) {
            return $result->form_option;
        } else {
            echo "-";
        }
    }

    public static function form_fields_attr_more(string $id)
    {

        $result = DB::table('more_form_attributes')->where('id', $id)->first();

        if ($result != '' && isset($result)) {
            return $result->more_form_option;
        } else {
            echo "-";
        }
    }

    public static function blog_categoryname(string $id)
    {

        $result = DB::table('blog_category')->where('id', $id)->first();

        if ($result != '' && isset($result)) {
            return $result->name;
        } else {
            echo "-";
        }
    }

    public static function vendorsnamepainting(array $ids)
    {
        $result = DB::table('users')->whereIn('id', $ids)->pluck('name');

        if ($result->isNotEmpty()) {
            return implode(", ", $result->toArray());
        } else {
            return "-";
        }
    }
    public static function vehiclename(string $id)
    {

        $result = DB::table('vehicles')->where('id', $id)->first();

        if ($result != '' && isset($result)) {
            return $result->name;
        } else {
            echo "-";
        }
    }

    public static function twoLineText($text, $limit = 120)
    {
        $text = strip_tags($text); // remove HTML

        if (strlen($text) <= $limit) {
            return $text;
        }

        return substr($text, 0, $limit) . '...';
    }

    //     public static function getUserLocation()
    // {
    //     try {

    //         // 1. Use session if already have good data
    //         if (session()->has('user_geo_location')) {

    //             $data = session('user_geo_location');

    //             if (!empty($data['city']) && $data['city'] !== "Unknown") {
    //                 return $data;
    //             }
    //         }

    //         // 2. Detect IP
    //         $ip = request()->ip();
    //         if ($ip == "127.0.0.1" || $ip == "::1") {
    //             $ip = "103.85.8.80";
    //             //$ip = "5.38.115.11"; //dubai ip
    //         }

    //         $apiKey = env('IPGEO_API_KEY');
    //         $url = "https://api.ipgeolocation.io/ipgeo?apiKey={$apiKey}&ip={$ip}";

    //         $response = Http::timeout(3)->get($url);

    //         // 3. API success?
    //         if ($response->successful()) {

    //             $data = $response->json();

    //             if (!empty($data['city']) && $data['city'] !== "Unknown") {

    //                 session(['user_geo_location' => $data]);

    //                 return $data;
    //             }
    //         }

    //     } catch (\Exception $e) {
    //         \Log::error("IP GEO API FAILED: " . $e->getMessage());
    //     }

    //     // DO NOT STORE UNKNOWN VALUES
    //     return [
    //         "city"          => null,
    //         "state_prov"    => null,
    //         "country_name"  => null,
    //         "latitude"      => null,
    //         "longitude"     => null
    //     ];
    // }
    public static function getUserLocation()
    {
        try {

            $ip = request()->ip();

            Log::info("Cron hit from IP {$ip} → " . $_SERVER['REQUEST_URI']);

            if (url()->current() == 'https://www.vendorscity.com/package_inquiry_vendormailcron') {
                mail('devang.hnrtechnologies@gmail.com', 'Cron Mail package_inquiry_vendormailcron', "Cron hit from IP {$ip}");
            }

            // If saved earlier → DO NOT CALL API AGAIN
            if (session()->has('user_geo_location')) {
                $data = session('user_geo_location');

                if (!empty($data['city']) && $data['city'] !== "Unknown") {
                    return $data;
                }
            }

            /**
             * Detect IP
             */


            // Localhost fallback
            if ($ip == "127.0.0.1" || $ip == "::1") {
                // 🔥 CHANGE HERE during testing
                //$ip = "103.238.107.103";   // Dubai
                //$ip = "162.120.187.97";   // Dubai 2
                $ip = "103.85.11.13";      // CURRENT: Mumbai
                $ip = "213.202.4.175"; //oman
                $ip = "37.41.54.71"; //ibri
            }

            /**
             * Call IP Geolocation API
             */
            $url = "https://api.ipgeolocation.io/ipgeo?apiKey=" . env('IPGEO_API_KEY') . "&ip={$ip}";

            $response = Http::timeout(4)->get($url);

            if ($response->successful()) {
                $data = $response->json();

                // Some APIs return "Unknown"
                if (!empty($data['city']) && $data['city'] !== "Unknown") {

                    // Save for future (DO NOT SAVE MULTIPLE TIMES)
                    session(['user_geo_location' => $data]);

                    // Log success
                    Log::info("Geo Success: IP {$ip} → " . $data['city']);



                    return $data;
                }
            }
        } catch (\Exception $e) {
            Log::error("IP GEO API FAILED: " . $e->getMessage());
        }

        /**
         * SAFE fallback
         */
        Log::warning("Geo Fallback triggered (city not found). IP: {$ip}");

        return [
            "city" => null,
            "state_prov" => null,
            "country_name" => null,
            "latitude" => null,
            "longitude" => null
        ];
    }

    public static function getVisitTransaction($order_id, $visit_date)
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('ci_visit_transactions')) {
            \Illuminate\Support\Facades\Schema::create('ci_visit_transactions', function ($table) {
                $table->id();
                $table->integer('order_id');
                $table->date('visit_date');
                $table->string('transaction_id');
                $table->decimal('amount_deducted', 10, 2);
                $table->timestamps();
            });
        }

        return DB::table('ci_visit_transactions')
            ->where('order_id', $order_id)
            ->where('visit_date', $visit_date)
            ->first();
    }

    public static function getStripeCustomerId($user_id)
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('ci_stripe_customers')) {
            \Illuminate\Support\Facades\Schema::create('ci_stripe_customers', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('stripe_customer_id');
                $table->timestamps();
            });
        }

        $record = DB::table('ci_stripe_customers')->where('user_id', $user_id)->first();
        return $record ? $record->stripe_customer_id : null;
    }

    public static function saveStripeCustomerId($user_id, $stripe_customer_id)
    {
        self::getStripeCustomerId($user_id); // Ensures table exists

        $existing = DB::table('ci_stripe_customers')->where('user_id', $user_id)->first();
        if ($existing) {
            DB::table('ci_stripe_customers')
                ->where('user_id', $user_id)
                ->update(['stripe_customer_id' => $stripe_customer_id, 'updated_at' => now()]);
        } else {
            DB::table('ci_stripe_customers')->insert([
                'user_id' => $user_id,
                'stripe_customer_id' => $stripe_customer_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    public static function getOrCreateStripeCustomer($user_id)
    {
        $stripe_customer_id = self::getStripeCustomerId($user_id);
        if (!$stripe_customer_id) {
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $user_record = DB::table('frontloginregisters')->where('id', $user_id)->first();
            $customer = $stripe->customers->create([
                'name' => $user_record ? $user_record->name : 'Guest',
                'email' => $user_record ? $user_record->email : 'guest@example.com',
            ]);
            $stripe_customer_id = $customer->id;
            self::saveStripeCustomerId($user_id, $stripe_customer_id);
        }
        return $stripe_customer_id;
    }

    public static function getUpcomingVisits($order_id, $limit = 5, $type = 'upcoming')
    {
        $order = DB::table('ci_orders')->where('order_id', $order_id)->first();
        if (!$order) {
            return collect();
        }

        $order_item = DB::table('ci_order_item')->where('order_id', $order_id)->first();
        if (!$order_item) {
            return collect();
        }

        $frequency = $order_item->how_often_do_you_need_cleaning ?? 'Once';
        if (empty($frequency) || $frequency == 'Once') {
            return collect();
        }

        // Handle cases where bookingyear is unexpectedly formatted (e.g., empty or object)
        $year = (is_string($order_item->bookingyear) && !empty($order_item->bookingyear)) ? $order_item->bookingyear : date('Y');
        $currentDateStr = $order_item->bookingdate . ' ' . $order_item->month . ' ' . $year;

        try {
            $startDate = \Carbon\Carbon::parse($currentDateStr);
        } catch (\Exception $e) {
            $startDate = \Carbon\Carbon::today();
        }

        $endDateCarbon = \Carbon\Carbon::parse($order_item->end_date);

        $allGeneratedVisits = [];

        if ($frequency == 'Multiple times a week' && !empty($order_item->which_day_of_the_week_do_you_want_the_service)) {
            $days = $order_item->which_day_of_the_week_do_you_want_the_service;
            $selectedDays = is_array($days) ? array_map('trim', $days) : array_map('trim', explode(',', $days));

            $period = new \DatePeriod(
                $startDate,
                new \DateInterval('P1D'),
                $endDateCarbon->copy()->addDay()
            );

            $visitCount = 0;
            foreach ($period as $date) {
                if (in_array($date->format('l'), $selectedDays)) {
                    $allGeneratedVisits[] = [
                        'visit_date' => $date->format('Y-m-d'),
                        'visit_time' => $order_item->time_slot ?? null,
                        'payment_status' => static::getVisitPaymentStatus($order->paymentmode, $visitCount),
                        'visit_status' => 'upcoming',
                    ];
                    $visitCount++;
                }
            }
        } else {
            $i = 0;
            $visitCount = 0;
            while (true) {
                if ($frequency == 'Weekly') {
                    $visitDateObj = $startDate->copy()->addWeeks($i);
                } elseif ($frequency == 'Every 2 Weeks') {
                    $visitDateObj = $startDate->copy()->addWeeks($i * 2);
                } else {
                    $visitDateObj = $startDate->copy()->addDays($i * 7);
                }

                if ($visitDateObj->gt($endDateCarbon)) {
                    break;
                }

                $allGeneratedVisits[] = [
                    'visit_date' => $visitDateObj->format('Y-m-d'),
                    'visit_time' => $order_item->time_slot ?? null,
                    'payment_status' => static::getVisitPaymentStatus($order->paymentmode, $visitCount),
                    'visit_status' => 'upcoming',
                ];
                $visitCount++;
                $i++;
            }
        }

        if (!\Illuminate\Support\Facades\Schema::hasColumn('ci_order_visits', 'cleaner_id')) {
            \Illuminate\Support\Facades\Schema::table('ci_order_visits', function ($table) {
                $table->integer('cleaner_id')->nullable()->after('visit_status');
            });
        }

        // Fetch stored actions (skipped/cancelled/completed)
        $storedVisits = [];
        if (\Illuminate\Support\Facades\Schema::hasTable('ci_order_visits')) {
            $storedRecords = DB::table('ci_order_visits')
                ->leftJoin('users', 'ci_order_visits.cleaner_id', '=', 'users.id')
                ->select('ci_order_visits.*', 'users.name as cleaner_name')
                ->where('order_id', $order_id)
                ->get();

            foreach ($storedRecords as $rec) {
                $storedVisits[$rec->visit_date] = (object) [
                    'id' => $rec->id,
                    'visit_status' => $rec->visit_status,
                    'payment_status' => $rec->payment_status,
                    'cleaner_id' => $rec->cleaner_id,
                    'cleaner_name' => $rec->cleaner_name,
                    'extra_hours' => $rec->extra_hours,
                    'extra_charge' => $rec->extra_charge
                ];
            }
        }

        // Default cleaner from order item
        $defaultCleanerId = null;
        $defaultCleanerName = 'Not Assigned';
        if (!empty($order_item->cleaner_id)) {
            $defaultCleanerId = explode(',', $order_item->cleaner_id)[0];
            $cleaner = DB::table('users')->where('id', $defaultCleanerId)->first();
            if ($cleaner) {
                $defaultCleanerName = $cleaner->name;
            }
        }

        // Filter valid visits: >= today and apply stored status
        $upcomingVisits = [];
        $todayStr = date('Y-m-d');

        foreach ($allGeneratedVisits as $gv) {
            $dateStr = $gv['visit_date'];

            if (($type === 'upcoming' && $dateStr >= $todayStr) || ($type === 'past' && $dateStr < $todayStr) || $type === 'all') {
                $status = 'upcoming';
                $id = null;
                $payment_status = $gv['payment_status'];
                $assigned_cleaner_id = $defaultCleanerId;
                $assigned_cleaner_name = $defaultCleanerName;
                $extra_hours = 0;
                $extra_charge = 0;

                if (isset($storedVisits[$dateStr])) {
                    $status = $storedVisits[$dateStr]->visit_status;
                    $id = $storedVisits[$dateStr]->id;
                    $payment_status = $storedVisits[$dateStr]->payment_status;
                    if (!empty($storedVisits[$dateStr]->cleaner_id)) {
                        $assigned_cleaner_id = $storedVisits[$dateStr]->cleaner_id;
                        $assigned_cleaner_name = $storedVisits[$dateStr]->cleaner_name;
                    }
                    $extra_hours = $storedVisits[$dateStr]->extra_hours;
                    $extra_charge = $storedVisits[$dateStr]->extra_charge;
                }

                $upcomingVisits[] = (object) [
                    'id' => $id,
                    'order_id' => $order_id,
                    'visit_date' => $dateStr,
                    'visit_time' => $gv['visit_time'],
                    'payment_status' => $payment_status,
                    'visit_status' => $status,
                    'cleaner_id' => $assigned_cleaner_id,
                    'cleaner_name' => $assigned_cleaner_name,
                    'extra_hours' => $extra_hours,
                    'extra_charge' => $extra_charge
                ];

                if (count($upcomingVisits) >= $limit) {
                    break;
                }
            }
        }

        return collect($upcomingVisits);
    }

    private static function getVisitPaymentStatus($paymentmode, $index)
    {
        if ($paymentmode == 3) {
            return 'paid'; // Tabby
        } elseif ($paymentmode == 1) {
            return 'pending'; // COD
        } else {
            return ($index == 0) ? 'paid' : 'pending'; // Stripe
        }
    }

    public static function timeAgo($time_ago)
    {
        $time_ago = strtotime($time_ago);
        $cur_time = time();
        $time_elapsed = $cur_time - $time_ago;
        $seconds = $time_elapsed;
        $minutes = round($time_elapsed / 60);
        $hours = round($time_elapsed / 3600);
        $days = round($time_elapsed / 86400);
        $weeks = round($time_elapsed / 604800);
        $months = round($time_elapsed / 2600640);
        $years = round($time_elapsed / 31207680);
        // Seconds
        if ($seconds <= 60) {
            return "just now";
        }
        //Minutes
        else if ($minutes <= 60) {
            if ($minutes == 1) {
                return "one minute ago";
            } else {
                return "$minutes minutes ago";
            }
        }
        //Hours
        else if ($hours <= 24) {
            if ($hours == 1) {
                return "an hour ago";
            } else {
                return "$hours hrs ago";
            }
        }
        //Days
        else if ($days <= 7) {
            if ($days == 1) {
                return "yesterday";
            } else {
                return "$days days ago";
            }
        }
        //Weeks
        else if ($weeks <= 4.3) {
            if ($weeks == 1) {
                return "a week ago";
            } else {
                return "$weeks weeks ago";
            }
        }
        //Months
        else if ($months <= 12) {
            if ($months == 1) {
                return "a month ago";
            } else {
                return "$months months ago";
            }
        }
        //Years
        else {
            if ($years == 1) {
                return "one year ago";
            } else {
                return "$years years ago";
            }
        }
    }

    public static function success_msg_whatsapp_allVendor($vendor_id, $order_number)
    {
        $vendors = DB::table('users')->where('id', $vendor_id)->where('is_active', 0)->first();
        if (!$vendors)
            return true;

        $vendors_attribute = DB::table('vendors_attribute')->where('pid', $vendors->id)->get();

        $firstItem = DB::table('ci_order_item')->where('order_id', $order_number)->first();
        if (!$firstItem)
            return true;

        $subservice = self::subservicename((int) $firstItem->subservice_id);
        if (empty($subservice)) {
            $subservice = self::servicename((int) $firstItem->service_id);
        }
        if (empty($subservice)) {
            $subservice = 'Service';
        }
        $phone = $vendors->country_code . '' . $vendors->mobile;

        $headers = [
            'Authorization: key_uTZeOXQPMd',
            'accept: application/json',
            'content-type: application/json'
        ];

        $payload = function ($toPhone) use ($subservice) {
            return json_encode([
                "messages" => [
                    [
                        "content" => [
                            "language" => "en",
                            "templateData" => [
                                "body" => [
                                    "placeholders" => [$subservice]
                                ]
                            ],
                            "templateName" => "new_booking_alert"
                        ],
                        "from" => "+971503204846",
                        "to" => $toPhone
                    ]
                ]
            ]);
        };

        if (!empty($vendors->country_code) && !empty($vendors->mobile)) {
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
                CURLOPT_POSTFIELDS => $payload($phone),
                CURLOPT_HTTPHEADER => $headers,
            ));
            curl_exec($curl);
            curl_close($curl);
        }

        if ($vendors_attribute->isNotEmpty()) {
            foreach ($vendors_attribute as $vendorAtt) {
                $vendorAttphone = $vendorAtt->country_code . '' . $vendorAtt->telephone;
                if (!empty($vendorAtt->country_code) && !empty($vendorAtt->telephone)) {
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
                        CURLOPT_POSTFIELDS => $payload($vendorAttphone),
                        CURLOPT_HTTPHEADER => $headers,
                    ));
                    curl_exec($curl);
                    curl_close($curl);
                }
            }
        }
        return true;
    }

    public static function success_msg_whatsapp_customer($userid, $order_number)
    {
        $userdata = DB::table('frontloginregisters')
            ->where('id', $userid)
            ->first();

        if (!$userdata) {
            \Log::error('WhatsApp: User not found', [
                'userid' => $userid,
                'order_number' => $order_number,
            ]);
            return false;
        }

        $firstItem = DB::table('ci_order_item')
            ->where('order_id', $order_number)
            ->first();

        if (!$firstItem) {
            \Log::error('WhatsApp: Order item not found', [
                'userid' => $userid,
                'order_number' => $order_number,
            ]);
            return false;
        }

        $subservice = self::subservicename((int) $firstItem->subservice_id);

        if (empty($subservice)) {
            $subservice = self::servicename((int) $firstItem->service_id);
        }

        if (empty($subservice)) {
            $subservice = 'Service';
        }

        $customer_name = !empty($userdata->name)
            ? $userdata->name
            : 'Customer';

        /*
         * IMPORTANT:
         * Remove + from country code/mobile if database already stores
         * only numeric values.
         */
        $countryCode = preg_replace('/[^0-9]/', '', $userdata->country_code);
        $mobile = preg_replace('/[^0-9]/', '', $userdata->mobile);

        $phone = $countryCode . $mobile;

        if (empty($countryCode) || empty($mobile)) {
            \Log::error('WhatsApp: Invalid customer phone', [
                'userid' => $userid,
                'country_code' => $userdata->country_code,
                'mobile' => $userdata->mobile,
                'final_phone' => $phone,
            ]);

            return false;
        }

        $payload = [
            "messages" => [
                [
                    "content" => [
                        "language" => "en",
                        "templateData" => [
                            "body" => [
                                "placeholders" => [
                                    $customer_name,
                                    $subservice
                                ]
                            ],
                            "buttons" => [
                                [
                                    "type" => "URL",
                                    "parameter" => (string) $order_number
                                ]
                            ]
                        ],
                        "templateName" => "service_requested"
                    ],
                    "from" => "+971503204846",
                    "to" => "+" . $phone
                ]
            ]
        ];

        \Log::info('WhatsApp request started', [
            'userid' => $userid,
            'order_number' => $order_number,
            'phone' => '+' . $phone,
            'customer_name' => $customer_name,
            'subservice' => $subservice,
            'template' => 'service_requested',
            'payload' => $payload,
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Authorization: key_uTZeOXQPMd',
                'Accept: application/json',
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);

        $curlError = curl_error($curl);
        $curlErrno = curl_errno($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        \Log::info('WhatsApp API response', [
            'userid' => $userid,
            'order_number' => $order_number,
            'phone' => '+' . $phone,
            'http_code' => $httpCode,
            'curl_errno' => $curlErrno,
            'curl_error' => $curlError,
            'response' => $response,
        ]);

        if ($curlError) {
            \Log::error('WhatsApp CURL ERROR', [
                'error' => $curlError,
                'errno' => $curlErrno,
            ]);

            return false;
        }

        if ($httpCode < 200 || $httpCode >= 300) {
            \Log::error('WhatsApp DoubleTick API ERROR', [
                'http_code' => $httpCode,
                'response' => $response,
                'phone' => '+' . $phone,
            ]);

            return false;
        }

        return true;
    }
    public static function get_front_url($path, $city_slug = 'dubai')
    {
        return url("/" . $city_slug . "/" . ltrim($path, '/'));
    }
}
