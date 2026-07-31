<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Service;
use App\Models\Admin\Subservice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ServiceController extends Controller
{
    public function index()
    {
        $countryId = 22;
        $cityId = 17;
        $services = Service::where('is_active', 0)
            ->whereRaw('FIND_IN_SET(?, country)', [$countryId])
            ->orderBy('set_order', 'ASC')
            ->get();

        if ($services->isEmpty()) {

            return response()->json([
                'status' => false,
                'message' => 'No services found',
                'data' => []
            ], 404);
        }



        $data = [];

        foreach ($services as $service) {

            $service_banner_attr = DB::table('service_banner_attr')->where('city', $cityId)->where('service_id', $service->id)->first();

            $data[] = [
                'id' => $service->id,
                'name' => $service->servicename,
                'slug' => $service->page_url,
                'sort_description' => $service->sort_description,
                'icon' => !empty($service->home_icon)
                    ? asset('public/upload/service/' . $service->home_icon)
                    : '',
                'banner_image' => !empty($service_banner_attr->mobile_banner_image)
                    ? asset('public/upload/service/banner_attr/large/' . $service_banner_attr->mobile_banner_image)
                    : '',
                'banner_image_alt_text' => $service_banner_attr->title ?? '',
                'banner_title' => $service_banner_attr->title ?? '',
                'banner_short_description' => $service_banner_attr->short_description ?? '',
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Services fetched successfully',
            'data' => $data
        ]);
    }

    function subservice(Request $request)
    {
        $serviceId = $request->service_id;
        $countryId = 22;
        $cityId = 17;
        $services = Service::where('is_active', 0)
            ->where('id', $serviceId)
            ->whereRaw('FIND_IN_SET(?, country)', [$countryId])
            ->first();

        if (empty($services)) {

            return response()->json([
                'status' => false,
                'message' => 'No services found',
                'data' => []
            ], 404);
        }

        $Subservices = Subservice::where('is_active', 0)
            ->where('serviceid', $serviceId)
            ->whereRaw('FIND_IN_SET(?, country)', [$countryId])
            ->orderBy('set_order', 'ASC')
            ->get();

        // echo "<pre>";
        // print_r($Subservices);
        // exit;
        if ($Subservices->isEmpty()) {

            return response()->json([
                'status' => false,
                'message' => 'No Sub services found',
                'data' => []
            ], 404);
        }

        $data = [];

        foreach ($Subservices as $subservice) {

            $subservice_banner_attr = DB::table('subservice_banner_attr')->where('city', $cityId)->where('subservice_id', $subservice->id)->first();

            $data[] = [
                'id' => $subservice->id,
                'serviceid ' => $subservice->serviceid,
                'name' => $subservice->subservicename,
                'slug' => $subservice->page_url,
                'sort_description' => $subservice->sort_description,
                'image' => !empty($subservice->image)
                    ? asset('public/upload/subservice/' . $subservice->image)
                    : '',
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Sub Services fetched successfully',
            'data' => $data
        ]);
    }

    function homeapi()
    {

        $countryId = 22;
        $cityId = 17;

        $services = Service::where('is_active', 0)
            ->whereRaw('FIND_IN_SET(?, country)', [$countryId])
            ->orderBy('set_order', 'ASC')
            ->get();

        if ($services->isEmpty()) {

            return response()->json([
                'status' => false,
                'message' => 'No services found',
                'data' => []
            ], 404);
        }

        $data = [];

        foreach ($services as $service) {

            $serviceBanner = DB::table('service_banner_attr')
                ->where('city', $cityId)
                ->where('service_id', $service->id)
                ->first();

            $subServices = Subservice::where('is_active', 0)
                ->where('serviceid', $service->id)
                ->whereRaw('FIND_IN_SET(?, country)', [$countryId])
                ->orderBy('set_order', 'ASC')
                ->get();

            $subServiceData = [];

            foreach ($subServices as $subservice) {

                $subServiceData[] = [
                    'id' => $subservice->id,
                    'name' => $subservice->subservicename,
                    'slug' => $subservice->page_url,
                    'sort_description' => $subservice->sort_description,
                    'image' => !empty($subservice->image)
                        ? asset('public/upload/subservice/' . $subservice->image)
                        : '',
                ];
            }

            $data[] = [
                'id' => $service->id,
                'name' => $service->servicename,
                'slug' => $service->page_url,
                'sort_description' => $service->sort_description,
                'icon' => !empty($service->app_icon)
                    ? asset('public/upload/service/' . $service->app_icon)
                    : '',
                'banner_image' => !empty($serviceBanner->mobile_banner_image)
                    ? asset('public/upload/service/banner_attr/large/' . $serviceBanner->mobile_banner_image)
                    : '',
                'banner_title' => $serviceBanner->title ?? '',
                'banner_short_description' => $serviceBanner->short_description ?? '',

                'sub_services' => $subServiceData
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Home data fetched successfully',
            'data' => $data
        ]);
    }

    function add_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userid' => 'required|integer',
            'apt_flr_villa_no' => 'required|string|max:255',
            'building_cluster_name' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'address_type' => 'required|in:Home,Office,Other',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $userdata = DB::table('frontloginregisters')
            ->where('id', $request->userid)
            ->first();

        // Corrected condition
        if (!$userdata) {
            return response()->json([
                'status' => false,
                'message' => 'No user found'
            ], 404);
        }

        $data = [
            'user_id' => $request->userid,
            'apt_flr_villa_no' => $request->apt_flr_villa_no,
            'building_cluster_name' => $request->building_cluster_name,
            'street' => $request->street,
            'address_type' => $request->address_type,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $addressId = DB::table('appuser_address')->insertGetId($data);

        return response()->json([
            'status' => true,
            'message' => 'Address added successfully.',
            'data' => [
                'address_id' => $addressId
            ]
        ], 201);
    }

    public function edit_address(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'apt_flr_villa_no' => 'required',
            'building_cluster_name' => 'required',
            'street' => 'required',
            'address_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = auth()->user();

        $address = DB::table('appuser_address')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$address) {
            return response()->json([
                'status' => false,
                'message' => 'Address not found.'
            ], 404);
        }

        DB::table('appuser_address')
            ->where('id', $id)
            ->update([
                'apt_flr_villa_no' => $request->apt_flr_villa_no,
                'building_cluster_name' => $request->building_cluster_name,
                'street' => $request->street,
                'address_type' => $request->address_type,
                'updated_at' => now(),
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Address updated successfully.'
        ]);
    }

    public function address_list(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $addresses = DB::table('appuser_address')
            ->where('user_id', $user->id)
            ->orderBy('id', 'DESC')
            ->get();

        if ($addresses->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No addresses found.',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Address list fetched successfully.',
            'data' => $addresses
        ]);
    }

    public function delete_address($id)
    {
        $user = auth()->user();

        $address = DB::table('appuser_address')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$address) {
            return response()->json([
                'status' => false,
                'message' => 'Address not found.'
            ], 404);
        }

        DB::table('appuser_address')
            ->where('id', $id)
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Address deleted successfully.'
        ]);
    }
}
