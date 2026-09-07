<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FrontLoginRegister;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class SystemApiController extends Controller
{
    public function getWeatherIcon(Request $request)
    {
        $system = DB::table('system')->where('id', 1)->first();

        if (!$system) {
            return response()->json([
                'status' => false,
                'message' => 'System settings not found.'
            ], 404);
        }

        $data = [];

        // Check Web Icon
        if ($system->weather_is_web_active == 1 && !empty($system->weather_web_icon)) {
            $data['web'] = [
                'status' => true,
                'icon' => asset('public/upload/weather/' . $system->weather_web_icon),
                'alt_tag' => $system->weather_alt_tag,
                'title' => $system->weather_title,
                'short_description' => $system->weather_short_description
            ];
        } else {
            $data['web'] = [
                'status' => false,
                'message' => 'Web Icon is not selected or not uploaded.'
            ];
        }

        // Check App Icon
        if ($system->weather_is_app_active == 1 && !empty($system->weather_app_icon)) {
            $data['app'] = [
                'status' => true,
                'icon' => asset('public/upload/weather/' . $system->weather_app_icon),
                'alt_tag' => $system->weather_alt_tag,
                'title' => $system->weather_title,
                'short_description' => $system->weather_short_description
            ];
        } else {
            $data['app'] = [
                'status' => false,
                'message' => 'App Icon is not selected or not uploaded.'
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Weather icons data retrieved successfully.',
            'data' => $data
        ], 200);
    }

    public function getHorizontalBanners(Request $request)
    {
        $web_banners = DB::table('coupans')
            ->where('is_active', 0)
            ->where('display_image', 'Horizontal')
            ->where('active_for_web', 1)
            ->whereNotNull('horizontal_image')
            ->where('horizontal_image', '!=', '')
            ->get();

        $app_banners = DB::table('coupans')
            ->where('is_active', 0)
            ->where('display_image', 'Horizontal')
            ->where('active_for_app', 1)
            ->whereNotNull('horizontal_image')
            ->where('horizontal_image', '!=', '')
            ->get();

        $web_data = $web_banners->map(function ($item) {
            $item->image_url = asset('public/upload/coupans/' . $item->horizontal_image);
            return $item;
        });

        $app_data = $app_banners->map(function ($item) {
            $item->image_url = asset('public/upload/coupans/' . $item->horizontal_image);
            return $item;
        });

        return response()->json([
            'status' => true,
            'message' => 'Horizontal banners retrieved successfully.',
            'data' => [
                'web' => $web_data,
                'app' => $app_data
            ]
        ], 200);
    }

    public function getVerticalBanners(Request $request)
    {
        $web_banners = DB::table('coupans')
            ->where('is_active', 0)
            ->where('display_image', 'Vertical')
            ->where('active_for_web', 1)
            ->whereNotNull('vertical_image')
            ->where('vertical_image', '!=', '')
            ->get();

        $app_banners = DB::table('coupans')
            ->where('is_active', 0)
            ->where('display_image', 'Vertical')
            ->where('active_for_app', 1)
            ->whereNotNull('vertical_image')
            ->where('vertical_image', '!=', '')
            ->get();

        $web_data = $web_banners->map(function ($item) {
            $item->image_url = asset('public/upload/coupans/' . $item->vertical_image);
            return $item;
        });

        $app_data = $app_banners->map(function ($item) {
            $item->image_url = asset('public/upload/coupans/' . $item->vertical_image);
            return $item;
        });

        return response()->json([
            'status' => true,
            'message' => 'Vertical banners retrieved successfully.',
            'data' => [
                'web' => $web_data,
                'app' => $app_data
            ]
        ], 200);
    }
}
