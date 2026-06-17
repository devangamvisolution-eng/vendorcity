<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Service;
use Illuminate\Support\Facades\DB;

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
}
