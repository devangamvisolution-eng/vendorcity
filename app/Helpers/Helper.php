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

    public static function timeslotname(?int $id)
    {
        if (is_null($id)) {
            return "-";
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
            $ip = request()->ip();

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
            "city"         => null,
            "state_prov"   => null,
            "country_name" => null,
            "latitude"     => null,
            "longitude"    => null
        ];
    }
}
