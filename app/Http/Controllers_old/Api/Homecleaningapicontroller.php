<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Admin\Service;
use App\Models\Admin\Subservice;
use Illuminate\Support\Facades\Mail;
use Helper;

class Homecleaningapicontroller extends Controller
{
    function home_cleaning_api()
    {

        // $data['addons'] = DB::table('addons')
        //     ->where('serviceid', $service_id)
        //     ->where('is_active', 0)
        //     ->whereRaw("FIND_IN_SET(?, subserviceid)", [$subservice_id])
        //     ->orderBy("set_order", 'asc')
        //     ->get()->toArray();

        echo "here";
        exit;
    }

    function get_addons(Request $request)
    {

        // echo "<pre>";
        // print_r($request->all());
        // exit;
        $service_id = $request->serviceid;
        $subservice_id = $request->subserviceid;
        $addons = DB::table('addons')
            ->where('serviceid', $service_id)
            ->where('is_active', 0)
            ->whereRaw("FIND_IN_SET(?, subserviceid)", [$subservice_id])
            ->orderBy("set_order", 'asc')
            ->get()->toArray();

        if (empty($addons)) {

            return response()->json([
                'status' => false,
                'message' => 'No addons found',
                'data' => []
            ], 404);
        }

        $data = [];

        foreach ($addons as $addonsdata) {

            $data[] = [
                'id' => $addonsdata->id,
                'name' => $addonsdata->name,
                'price' => $addonsdata->price,
                'discount' => $addonsdata->discount,
                'discount_type' => $addonsdata->discount_type,
                'discount_type_logic' => "0=percentage,1=price,2=none",
                'image' => !empty($addonsdata->image)
                    ? asset('public/upload/addons/' . $addonsdata->image)
                    : '',
                'popup_image' => !empty($addonsdata->popup_image)
                    ? asset('public/upload/addons/' . $addonsdata->popup_image)
                    : '',
                'short_desc' => $addonsdata->short_desc ?? '',
                'description' => $addonsdata->description ?? '',
            ];
        }



        return response()->json([
            'status' => true,
            'message' => 'Addons fetched successfully',
            'data' => $data
        ]);
    }

    public function home_cleaning_config()
    {

        $subserviceId = 28;

        $basePrices = DB::table('cleanin_subserviceprice')
            ->where('subservice_id', $subserviceId)
            ->orderBy('hour_value')
            ->get([
                'hour_value as hours',
                'hourly_price',
                'cleaning_material_price_per_hour'
            ]);

        $pricing = DB::table('system')
            ->where('id', 1)
            ->first();

        $timeslots = DB::table('subservice_timeslot_price as st')
            ->join('time_slots as ts', 'ts.id', '=', 'st.time_slot_id')
            ->where('st.subservice_id', $subserviceId)
            ->where('st.is_active', 1)
            ->orderBy('ts.set_order')
            ->select(
                'ts.id',
                'ts.name as time',
                'st.price as extra_charge'
            )
            ->get();

        $cleaners = DB::table('users')
            // ->where('role_id', 16)
            ->whereRaw('FIND_IN_SET(?, role_id)', [16])
            ->where('is_active', 0)
            ->select(
                'id',
                'name',
                'profile_image',
                'city'
            )
            ->get()
            ->map(function ($cleaner) {
                return [
                    'id' => $cleaner->id,
                    'name' => $cleaner->name,
                    'image' => !empty($cleaner->profile_image) ? asset('public/upload/cleaners/large/' . $cleaner->profile_image) : '',
                    'city_ids' => !empty($cleaner->city)
                        ? explode(',', $cleaner->city)
                        : [],
                    'is_auto_assign' => false
                ];
            });


        $addons = DB::table('addons')
            // ->where('serviceid', $serviceId)
            ->where('is_active', 0)
            ->whereRaw('FIND_IN_SET(?, subserviceid)', [$subserviceId])
            ->orderBy('set_order')
            ->select(
                'id',
                'name',
                'price',
                'image',
                'popup_image',
                'image_alt_tag',
                'discount',
                'discount_type',
                'short_desc',
                'description'
            )
            ->get()
            ->map(function ($addon) {
                return [
                    'id' => $addon->id,
                    'name' => $addon->name,
                    'price' => $addon->price,
                    'discount' => $addon->discount,
                    'discount_type' => $addon->discount_type,
                    'discount_type_logic' => "0=percentage,1=price,2=none",
                    'image' => !empty($addon->image)
                        ? asset('public/upload/addons/' . $addon->image)
                        : '',
                    'popup_image' => !empty($addon->popup_image)
                        ? asset('public/upload/addons/' . $addon->popup_image)
                        : '',
                    'image_alt_tag' => $addon->image_alt_tag,
                    'short_desc' => $addon->short_desc ?? '',
                    'description' => $addon->description ?? '',
                ];
            });

        $response = [
            "status" => true,
            "data" => [
                "service_details" => [
                    // "service_id" => 54,
                    // "subservice_id" => 28,
                    "subservice_name" => "Home Cleaning",
                    "vat_percentage" => 5
                ],

                "pricing_rules" => [
                    "base_prices" => $basePrices,

                    "timing_charge" => 0,
                    "service_fee" => 9,

                    "frequency_discounts" => [
                        "once" => 0,
                        "weekly" => $pricing->weekly_percentage,
                        "multiple" => $pricing->multiple_time_week
                    ]
                ],

                "options" => [
                    "available_hours" => [2, 3, 4, 5, 6, 7, 8],
                    "available_cleaners_count" => [1, 2, 3, 4, 5, 6],

                    "frequencies" => [
                        [
                            "id" => "once",
                            "title" => "ONCE",
                            "subtitle" => "One Time Cleaning Session",
                            "requires_days_selection" => false
                        ],
                        [
                            "id" => "weekly",
                            "title" => "WEEKLY",
                            "subtitle" => "10% off Per Visit",
                            "requires_days_selection" => false
                        ],
                        [
                            "id" => "multiple",
                            "title" => "MULTIPLE TIMES A WEEK",
                            "subtitle" => "Select 2 or more days",
                            "requires_days_selection" => true,
                            "min_days_required" => 2,
                            "available_days" => [
                                "Monday",
                                "Tuesday",
                                "Wednesday",
                                "Thursday",
                                "Friday",
                                "Saturday",
                                "Sunday"
                            ]
                        ]
                    ]
                ],

                "scheduling" => [
                    "timeslots" => $timeslots,

                    "cleaners_list" => $cleaners,
                ],

                "addons" => $addons,
            ]
        ];

        return response()->json($response);
    }

    // function cleaner_availability_check(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'cleaner_id' => 'required|integer',
    //         'subservice_id' => 'required|integer',
    //         'service_date' => 'required|date_format:Y-m-d',
    //         'selected_hours' => 'required|integer|min:1'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation Error',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     $date = Carbon::parse($request->service_date);

    //     $day = $date->day;
    //     $month = $date->month;
    //     $year = $date->year;

    //     $cleanerId = $request->cleaner_id;
    //     $subserviceId = $request->subservice_id;
    //     $selectedHours = $request->selected_hours;
    //     echo "<pre>";
    //     print_r($request->all());
    //     exit;
    // }
    public function cleaner_availability_check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cleaner_id' => 'required|integer',
            'subservice_id' => 'required|integer',
            'service_date' => 'required|date_format:Y-m-d',
            'selected_hours' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $selectedDate = Carbon::parse($request->service_date);

        $date = $selectedDate->day;
        $month = $selectedDate->month;
        $year = $selectedDate->year;

        $cleanerId = $request->cleaner_id;
        $subserviceId = $request->subservice_id;
        $selectedHours = $request->selected_hours;

        /*
    |--------------------------------------------------------------------------
    | GET ALL BOOKINGS
    |--------------------------------------------------------------------------
    */
        $bookedSlots = DB::table('ci_order_item')
            ->whereRaw("FIND_IN_SET(?, cleaner_id)", [$cleanerId])
            ->where('subservice_id', $subserviceId)
            ->where('is_return', '0')
            ->get();

        /*
    |--------------------------------------------------------------------------
    | GET MASTER TIME SLOTS
    |--------------------------------------------------------------------------
    */
        $timeslotMaster = DB::table('subservice_timeslot_price as stp')
            ->leftJoin('time_slots as ts', 'stp.time_slot_id', '=', 'ts.id')
            ->where('stp.subservice_id', $subserviceId)
            ->where('stp.is_active', 1)
            ->select(
                'stp.time_slot_id',
                'stp.price',
                'ts.name as slot_name',
                'ts.set_order'
            )
            ->orderBy('ts.set_order', 'asc')
            ->get();

        /*
    |--------------------------------------------------------------------------
    | FIND MATCHED BOOKINGS
    |--------------------------------------------------------------------------
    */
        $matchedBookings = [];

        foreach ($bookedSlots as $booking) {

            $startDate = Carbon::parse(
                "{$booking->bookingdate} {$booking->month} {$booking->bookingyear}"
            );

            $endDate = Carbon::parse($booking->end_date);

            /*
        |--------------------------------------------------------------------------
        | ONCE
        |--------------------------------------------------------------------------
        */
            if ($booking->how_often_do_you_need_cleaning == "Once") {

                if ($startDate->format('Y-m-d') == $selectedDate->format('Y-m-d')) {
                    $matchedBookings[] = $booking;
                }
            }

            /*
        |--------------------------------------------------------------------------
        | WEEKLY
        |--------------------------------------------------------------------------
        */ elseif ($booking->how_often_do_you_need_cleaning == "Weekly") {

                $targetDay = strtolower(trim(
                    $booking->which_day_of_the_week_do_you_want_the_service
                ));

                $current = $startDate->copy();

                while (strtolower($current->format('l')) != $targetDay) {
                    $current->addDay();
                }

                while ($current->lte($endDate)) {

                    if ($current->format('Y-m-d') == $selectedDate->format('Y-m-d')) {
                        $matchedBookings[] = $booking;
                        break;
                    }

                    $current->addDays(7);
                }
            }

            /*
        |--------------------------------------------------------------------------
        | MULTIPLE TIMES A WEEK
        |--------------------------------------------------------------------------
        */ elseif ($booking->how_often_do_you_need_cleaning == "Multiple times a week") {

                $days = collect(
                    explode(',', $booking->which_day_of_the_week_do_you_want_the_service)
                )->map(function ($day) {
                    return strtolower(trim($day));
                });

                $selectedDay = strtolower($selectedDate->format('l'));

                if (
                    $days->contains($selectedDay) &&
                    $selectedDate->between($startDate, $endDate)
                ) {
                    $matchedBookings[] = $booking;
                }
            }
        }

        $matchedBookings = collect($matchedBookings);

        /*
    |--------------------------------------------------------------------------
    | BOOKED SLOT IDS
    |--------------------------------------------------------------------------
    */
        $bookedSlotIds = [];
        $hoursData = [];

        foreach ($matchedBookings as $booking) {

            $bookedSlotIds[] = $booking->time_slot;

            $hoursData[$booking->time_slot] =
                (int) $booking->how_many_hours_should_they_stay;
        }

        /*
    |--------------------------------------------------------------------------
    | PREPARE FINAL AVAILABLE SLOTS
    |--------------------------------------------------------------------------
    */
        $availableSlots = [];

        $renderLimit = count($timeslotMaster) - $selectedHours;

        foreach ($timeslotMaster as $index => $slot) {

            if ($index >= $renderLimit) {
                continue;
            }

            $isAvailable = true;

            // Booked check
            if (in_array($slot->time_slot_id, $bookedSlotIds)) {
                $isAvailable = false;
            }

            // Disable next slots according to booking hours
            foreach ($matchedBookings as $booking) {

                if ($booking->time_slot == $slot->time_slot_id) {

                    $disableHours = (int) $booking->how_many_hours_should_they_stay;

                    for ($j = 1; $j <= $disableHours; $j++) {

                        $nextIndex = array_search(
                            $booking->time_slot,
                            array_column($timeslotMaster->toArray(), 'time_slot_id')
                        );

                        if (
                            $nextIndex !== false &&
                            ($nextIndex + $j) == $index
                        ) {
                            $isAvailable = false;
                        }
                    }
                }
            }

            /*
        |--------------------------------------------------------------------------
        | TODAY + 2 HOUR BUFFER
        |--------------------------------------------------------------------------
        */
            if ($selectedDate->isToday()) {

                $dubaiNow = Carbon::now('Asia/Dubai')->addHours(2);

                $startTime = trim(explode('-', $slot->slot_name)[0]);

                $slotDateTime = Carbon::parse(
                    $selectedDate->format('Y-m-d') . ' ' . $startTime,
                    'Asia/Dubai'
                );

                if ($slotDateTime->lt($dubaiNow)) {
                    $isAvailable = false;
                }
            }

            $availableSlots[] = [
                'time_slot_id' => $slot->time_slot_id,
                'slot_name' => $slot->slot_name,
                'price' => $slot->price,
                'available' => $isAvailable
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Cleaner availability fetched successfully',
            'data' => [
                'cleaner_id' => $cleanerId,
                'service_date' => $selectedDate->format('Y-m-d'),
                'selected_hours' => $selectedHours,
                'slots' => $availableSlots
            ]
        ]);
    }

    function cancelpolicy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subservice_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'data' => []
            ], 422);
        }

        // Find Subservice
        $subservice = Subservice::where('id', $request->subservice_id)->first();

        if (!$subservice) {
            return response()->json([
                'status' => false,
                'message' => 'Subservice not found.',
                'data' => []
            ], 404);
        }

        // Return only cancel policy
        return response()->json([
            'status' => true,
            'message' => 'Cancel policy fetched successfully.',
            'data' => [
                'cancelpolicy' => $subservice->cancel_policy
            ]
        ], 200);
    }

    public function packages(Request $request)
    {
        $request->validate([
            'service_id' => 'required|integer',
            'subservice_id' => 'required|integer',
        ]);

        $service_id = $request->service_id;
        $subservice_id = $request->subservice_id;

        $countryId = 22;

        // Validate Service
        $service = Service::where('id', $service_id)
            ->whereRaw('FIND_IN_SET(?, country)', [$countryId])
            ->where('is_active', 0)
            ->first();

        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'No service found.',
                'data' => []
            ], 404);
        }

        // Validate Subservice
        $subservice = Subservice::where('serviceid', $service_id)
            ->where('id', $subservice_id)
            ->where('is_active', 0)
            ->whereRaw('FIND_IN_SET(?, country)', [$countryId])
            ->first();

        if (!$subservice) {
            return response()->json([
                'status' => false,
                'message' => 'No subservice found.',
                'data' => []
            ], 404);
        }

        // Get Package Categories
        $packageCategories = DB::table('package_categories')
            ->where('service_id', $service_id)
            ->where('subservice_id', $subservice_id)
            ->where('is_active', 0)
            ->orderBy('set_order', 'ASC')
            ->get();

        if ($packageCategories->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'No package categories found.',
                'data' => []
            ], 200);
        }

        $responseData = [];

        foreach ($packageCategories as $category) {


            $packages = DB::table('packages')
                ->where('service_id', $service_id)
                ->where('subservice_id', $subservice_id)
                ->where('packagecategory_id', $category->id)
                ->where('is_active', 0)
                ->orderBy('set_order', 'ASC')
                ->get();

            $packageData = [];

            foreach ($packages as $package) {
                $packageData[] = [
                    'id' => $package->id,
                    'name' => $package->name,
                    'price' => $package->price,
                    'discount' => $package->discount,
                    'discount_type' => $package->discount_type,
                    'short_description' => $package->short_description,
                    'description' => $package->description,
                    'image' => !empty($package->image)
                        ? asset('public/upload/packages/large/' . $package->image)
                        : '',
                    'popup_image' => !empty($package->popup_image)
                        ? asset('public/upload/packages/popupimage/' . $package->popup_image)
                        : '',
                ];
            }
            if ($packages->count() > 0) {

                $responseData[] = [
                    'package_category_id' => $category->id,
                    'package_category_name' => $category->name, // change column name if different
                    'image' => !empty($category->slider_image)
                        ? asset('public/upload/packagecategory/' . $category->slider_image)
                        : '',
                    'listing_image' => !empty($category->image)
                        ? asset('public/upload/packagecategory/large/' . $category->image)
                        : '',
                    'packages' => $packageData
                ];
            }
        }

        // Get Addons
        $addons = DB::table('addons')
            ->where('serviceid', $service_id)
            ->where('is_active', 0)
            ->whereRaw("FIND_IN_SET(?, subserviceid)", [$subservice_id])
            ->orderBy('set_order', 'ASC')
            ->get();

        $addonData = [];

        foreach ($addons as $addon) {
            $addonData[] = [
                'id' => $addon->id,
                'name' => $addon->name,
                'price' => $addon->price,
                'discount' => $addon->discount,
                'discount_type' => $addon->discount_type,
                'discount_type_logic' => "0=percentage,1=price,2=none",
                'image' => !empty($addon->image)
                    ? asset('public/upload/addons/' . $addon->image)
                    : '',
                'popup_image' => !empty($addon->popup_image)
                    ? asset('public/upload/addons/' . $addon->popup_image)
                    : '',
                'short_desc' => $addon->short_desc ?? '',
                'description' => $addon->description ?? '',
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Package categories found.',
            'data' => [
                'package_categories' => $responseData,
                'addons' => $addonData
            ]
        ]);
    }

    public function store_checkout(Request $request)
    {
        if ($request->service_id != 45 || $request->subservice_id != 28) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot access this API like this.'
            ], 403);
        }

        $user = $request->user();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }
        $userid = $user->id;

        $payment_type = $request->payment_type;
        if ($payment_type == 'COD') {
            $order_status = 'BK';
            $paymentmode = 1;
            $list_order_status = '0';
            $payment_status = 'Success';
        } elseif ($payment_type == 'TABBY') {
            $order_status = 'BK';
            $paymentmode = 3;
            $list_order_status = '0';
            $payment_status = 'FAILED';
        } else {
            $order_status = 'BK';
            $paymentmode = 2;
            $list_order_status = '0';
            $payment_status = 'FAILED';
        }

        $intOrderNumber = DB::table('ci_orders')
            ->select(DB::raw('MAX(order_id) as lastOrderNumber'))
            ->first();

        $order_number = $intOrderNumber ? $intOrderNumber->lastOrderNumber + 1 : 1;

        $wallet_plus_amount = DB::table('front_user_wallet')
            ->where('refer_id', $userid)
            ->where('added_from', 0)
            ->sum('wallet_amount');

        $wallet_minus_amount = DB::table('front_user_wallet')
            ->where('refer_id', $userid)
            ->where('added_from', 1)
            ->sum('wallet_amount');

        $front_wallet_amount = $wallet_plus_amount - $wallet_minus_amount;

        $order_total = $request->total_to_pay;

        $order_total_new = $order_total;
        $front_wallet_amount_new = 0;

        if ($request->apply_button == 1) {
            if ($front_wallet_amount > $order_total) {
                $order_total_new = 0;
                $front_wallet_amount_new = $order_total;
            } else {
                $order_total_new = $order_total - $front_wallet_amount;
                $front_wallet_amount_new = $front_wallet_amount;
            }
        }

        $timing_charger = $request->timing_charge + $request->weekly_off_charge;

        $content = array(
            'user_id' => $userid,
            'order_number' => $order_number,
            'order_total' => $order_total_new,
            'front_wallet_amount' => $front_wallet_amount_new,
            'vatcharge' => $request->vat_total,
            'order_currency' => 'AED',
            'order_status' => $order_status,
            'paymentmode' => $paymentmode,
            'payment_status' => $payment_status,
            'created_at' => date('Y-m-d H:i:s'),
            'coupan_to_wallet' => '', // API handle promos internally or passed from frontend
            'coupondiscount' => $request->promo_discount,
            'coupon_code' => '', // Replace if you pass coupon code in API
            'list_order_status' => $list_order_status,
            'service_charge' => $request->service_charge,
            'promo_discount' => $request->promo_discount,
            'timing_charge' => $timing_charger,
            'additional_charge' => $request->additional_charge,
            'sub_total' => $request->sub_total,
            'cod_charge' => $request->cod_charge,
            'service_fee' => $request->service_fee,
            'order_from' => 1,
        );

        $arrOrderId = DB::table('ci_orders')->insertGetId($content);

        // Sequence Number Generation
        $cityName = $request->city ?? '';
        $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($cityName) . '%'])->first();
        $subserviceData = DB::table('subservices')->where('id', $request->subservice_id)->first();

        $subserviceCode = isset($subserviceData->subservice_code) ? $subserviceData->subservice_code : 'OT';
        $cityCode = isset($cityData->city_code) ? $cityData->city_code : 'DU';
        $year = date('y');

        $lastSequence = DB::table('ci_orders')
            ->where('subservice_code', $subserviceCode)
            ->where('city_code', $cityCode)
            ->where('order_year', $year)
            ->selectRaw('MAX(CAST(sequence_no AS UNSIGNED)) as seq')
            ->lockForUpdate()
            ->value('seq');

        $nextSequence = $lastSequence ? $lastSequence + 1 : 1;

        $formatOrderId = sprintf("%s-%s-%s-%06d", $subserviceCode, $year, $cityCode, $nextSequence);

        DB::table('ci_orders')->where('order_id', $arrOrderId)->update([
            'subservice_code' => $subserviceCode,
            'city_code' => $cityCode,
            'order_year' => $year,
            'sequence_no' => $nextSequence,
            'format_order_id' => $formatOrderId
        ]);

        $which_day = "";
        if (!empty($request->which_day_of_the_week_do_you_want_the_service) && is_array($request->which_day_of_the_week_do_you_want_the_service)) {
            $which_day = implode(',', $request->which_day_of_the_week_do_you_want_the_service);
        }

        // Parse booking_date (e.g., "2026-08-15")
        $bookingDateStr = $request->booking_date;
        $carbonDate = \Carbon\Carbon::parse($bookingDateStr);

        $reqDate = $carbonDate->format('d'); // '15'
        $reqMonth = $carbonDate->format('F'); // 'August'
        $reqYear = $carbonDate->format('Y'); // '2026'

        $formatted_date = $carbonDate->format('Y-m-d');

        $end_date = $formatted_date;
        if ($request->how_often_do_you_need_cleaning == 'Once') {
            $which_day = date('l', strtotime($formatted_date));
        } elseif ($request->how_often_do_you_need_cleaning == 'Weekly') {
            $end_date = date('Y-m-d', strtotime($formatted_date . ' +1 year'));
            $which_day = date('l', strtotime($formatted_date));
        } elseif ($request->how_often_do_you_need_cleaning == 'Multiple times a week') {
            $end_date = date('Y-m-d', strtotime($formatted_date . ' +1 year'));
        }

        $arrData = array(
            'order_id' => $arrOrderId,
            'user_info_id' => $userid,
            'service_id' => $request->service_id,
            'subservice_id' => $request->subservice_id,
            'how_many_cleaners_do_you_need' => $request->how_many_cleaners_do_you_need,
            'how_many_hours_should_they_stay' => $request->how_many_hours_should_they_stay,
            'how_often_do_you_need_cleaning' => $request->how_often_do_you_need_cleaning,
            'do_you_need_cleaning_material' => $request->do_you_need_cleaning_material,
            'any_special_instruction' => $request->any_special_instruction,
            'address_type' => $request->address_type,
            'city' => $request->city,
            'area' => $request->area,
            'building_street_no' => $request->building_street_no,
            'apartment_villa_no' => $request->apartment_villa_no,
            'bookingdate' => $reqDate,
            'bookingyear' => $reqYear,
            'month' => $reqMonth,
            'time_slot' => $request->time_slot,
            'end_date' => $end_date,
            'which_day_of_the_week_do_you_want_the_service' => $which_day,
            'cdate' => date('Y-m-d'),
        );

        $order_item_id = DB::table('ci_order_item')->insertGetId($arrData);

        if ($request->has('addons') && is_array($request->addons) && count($request->addons) > 0) {
            foreach ($request->addons as $addon) {
                $addonDetails = DB::table('addons')->where('id', $addon['addon_id'])->first();

                $arrData_addons = array(
                    'order_id' => $arrOrderId,
                    'order_item_id' => $order_item_id,
                    'user_info_id' => $userid,
                    'package_id' => $addon['addon_id'],
                    'package_item_name' => $addon['name'] ?? ($addonDetails->name ?? ''),
                    'package_quantity' => $addon['qty'],
                    'package_item_price' => $addon['price'],
                    'service_id' => $request->service_id,
                    'service_name' => '',
                    'subservice_id' => $request->subservice_id,
                    'subservice_name' => '',
                    'image' => $addonDetails ? $addonDetails->image : '',
                    'discount' => $addonDetails ? $addonDetails->discount : '',
                    'discount_type' => $addonDetails ? $addonDetails->discount_type : '',
                    'product_discount_amount' => 0,
                    'cdate' => date('Y-m-d'),
                );

                DB::table('ci_order_item_addons')->insertGetId($arrData_addons);
            }
        }
        // Recurring visits
        $frequency = $request->how_often_do_you_need_cleaning ?? 'Once';
        if (!empty($frequency) && $frequency != 'Once') {
            $visits = [];
            $currentDate = $carbonDate->copy();
            $endDateCarbon = \Carbon\Carbon::parse($end_date);

            if ($frequency == 'Multiple times a week' && !empty($which_day)) {
                $selectedDays = array_map('trim', explode(',', $which_day));
                $period = new \DatePeriod(
                    $currentDate,
                    new \DateInterval('P1D'),
                    $endDateCarbon->copy()->addDay()
                );

                $visitCount = 0;
                foreach ($period as $visit_d) {
                    if (in_array($visit_d->format('l'), $selectedDays)) {
                        $v_payment_status = 'pending';
                        if ($paymentmode == 3)
                            $v_payment_status = 'paid';
                        elseif ($paymentmode == 2 && $visitCount == 0)
                            $v_payment_status = 'paid';

                        $visits[] = [
                            'order_id' => $arrOrderId,
                            'visit_date' => $visit_d->format('Y-m-d'),
                            'visit_time' => $request->time_slot ?? null,
                            'payment_status' => $v_payment_status,
                            'visit_status' => 'upcoming',
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                        $visitCount++;
                    }
                }
            } else {
                $i = 0;
                while (true) {
                    if ($frequency == 'Weekly') {
                        $visitDateObj = $currentDate->copy()->addWeeks($i);
                    } elseif ($frequency == 'Every 2 Weeks') {
                        $visitDateObj = $currentDate->copy()->addWeeks($i * 2);
                    } else {
                        $visitDateObj = $currentDate->copy()->addDays($i * 7);
                    }

                    if ($visitDateObj->gt($endDateCarbon))
                        break;

                    $v_payment_status = 'pending';
                    if ($paymentmode == 3)
                        $v_payment_status = 'paid';
                    elseif ($paymentmode == 2 && $i == 0)
                        $v_payment_status = 'paid';

                    $visits[] = [
                        'order_id' => $arrOrderId,
                        'visit_date' => $visitDateObj->format('Y-m-d'),
                        'visit_time' => $request->time_slot ?? null,
                        'payment_status' => $v_payment_status,
                        'visit_status' => 'upcoming',
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                    $i++;
                }
            }

            if (count($visits) > 0) {
                DB::table('ci_order_visits')->insert($visits);
            }
        }

        // Shipping Address
        $dataShip = [
            'first_name' => $user->name,
            'last_name' => '',
            'country' => 'UAE',
            'city' => $request->city,
            'area' => $request->area,
            'address1' => $request->building_street_no,
            'address2' => $request->apartment_villa_no,
            'phone_number' => $user->mobile,
            'email_address' => $user->email,
            'additional_message' => $request->any_special_instruction,
            'payment_method' => $request->payment_type,
            'order_id' => $arrOrderId,
            'user_id' => $userid,
        ];
        DB::table('ci_shipping_address')->insert($dataShip);

        // Wallet Deduction Logging
        if ($request->apply_button == 1 && $front_wallet_amount > 0) {
            $walletData = array(
                'userid' => 0,
                'refer_id' => $userid,
                'order_currency' => 'AED',
                'order_total' => $order_total,
                'wallet_amount' => min($front_wallet_amount, $order_total),
                'added_from' => 1,
                'order_id' => $arrOrderId,
                'added_date' => date('Y-m-d'),
            );
            DB::table('front_user_wallet')->insertGetId($walletData);
        }

        if ($payment_type == 'COD') {
            $this->send_success_mail_api($arrOrderId, $user);
            $this->send_vendor_lead_mail_api($arrOrderId, $user);

            return response()->json([
                'status' => true,
                'message' => 'Booking placed successfully.',
                'data' => [
                    'order_id' => $arrOrderId,
                    'format_order_id' => $formatOrderId
                ]
            ]);
        } elseif ($payment_type == 'TABBY') {
            $tabbyService = app(\App\Services\TabbyService::class);
            $bookingData = [
                'order_id' => $formatOrderId,
                'total_amount' => $order_total_new,
                'customer_phone' => $user->mobile ?? '',
                'customer_email' => $user->email ?? '',
                'customer_name' => $user->name ?? '',
                'tax_amount' => $request->vat_total ?? 0,
                'items' => []
            ];

            $response = $tabbyService->createSession($bookingData);

            if ($response && isset($response['configuration']['available_products']['installments'][0]['web_url'])) {
                $paymentId = $response['payment']['id'] ?? '';
                DB::table('ci_orders')->where('order_id', $arrOrderId)->update(['tabby_payment_id' => $paymentId]);

                return response()->json([
                    'status' => true,
                    'message' => 'Tabby Session created',
                    'data' => [
                        'order_id' => $arrOrderId,
                        'format_order_id' => $formatOrderId,
                        'payment_url' => $response['configuration']['available_products']['installments'][0]['web_url']
                    ]
                ]);
            }
            return response()->json(['status' => false, 'message' => 'Tabby payment initialization failed.'], 500);
        } else {
            // STRIPE
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'aed',
                            'product_data' => ['name' => 'Your Total'],
                            'unit_amount' => $order_total_new * 100,
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('payment_success'), // Or a deep link for mobile
                'cancel_url' => route('payment_fail'),
            ]);

            if (isset($response->id) && $response->id != '') {
                DB::table('ci_orders')->where('order_id', $arrOrderId)->update(['stripe_session_id' => $response->id]);
                return response()->json([
                    'status' => true,
                    'message' => 'Stripe Session created',
                    'data' => [
                        'order_id' => $arrOrderId,
                        'format_order_id' => $formatOrderId,
                        'payment_url' => $response->url
                    ]
                ]);
            } else {
                return response()->json(['status' => false, 'message' => 'Stripe payment initialization failed.'], 500);
            }
        }
    }

    public function send_success_mail_api($order_id, $user)
    {
        $orderdata = DB::table('ci_orders')->where('order_id', $order_id)->first();
        $order_item_data = DB::table('ci_order_item')->where('order_id', $order_id)->get();

        if (!$orderdata)
            return false;

        $payment_mode = ($orderdata->paymentmode == 1) ? "COD" : "Online";

        $subject = "Service Booking Confirmation " . $orderdata->format_order_id;
        $to = $user->email;
        $bccRecipients = ['hello@vendorscity.com'];

        dispatch(function () use ($orderdata, $order_item_data, $user, $payment_mode, $to, $subject, $bccRecipients, $order_id) {
            Mail::send('emails.customer_booking_request', [
                'orderdata' => $orderdata,
                'order_item_data' => $order_item_data,
                'user' => $user,
                'payment_mode' => $payment_mode
            ], function ($message) use ($to, $subject, $bccRecipients) {
                $message->to($to);
                $message->subject($subject);
                foreach ($bccRecipients as $bcc) {
                    $message->bcc($bcc);
                }
            });

            \Helper::success_msg_whatsapp_customer($user->id, $order_id);
        })->afterResponse();

        return true;
    }

    public function send_vendor_lead_mail_api($order_id, $user)
    {
        $orders = DB::table('ci_orders as o')
            ->select('o.*')
            ->where('o.order_id', $order_id)
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

        if ($orders->isEmpty())
            return false;

        $orderdata = $orders->first();

        // Extract services, subservices, cities
        $serviceIds = [];
        $subserviceIds = [];
        $orderCities = [];

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                if (!empty($item->service_id))
                    $serviceIds[] = $item->service_id;
                if (!empty($item->subservice_id))
                    $subserviceIds[] = $item->subservice_id;
                if (!empty($item->city))
                    $orderCities[] = trim($item->city);
            }
        }

        $serviceIds = array_unique($serviceIds);
        $subserviceIds = array_unique($subserviceIds);
        $orderCities = array_unique($orderCities);

        if (empty($serviceIds) && empty($subserviceIds)) {
            return false;
        }

        $cityMaster = DB::table('cities')->pluck('name', 'id')->toArray();

        $vendors = DB::table('users')
            ->where('vendor', 1)
            ->where('is_active', 0)
            ->get()
            ->filter(function ($vendor) use ($serviceIds, $subserviceIds, $orderCities, $cityMaster) {
                if (empty($vendor->serviceList) || empty($vendor->subserviceList) || empty($vendor->city)) {
                    return false;
                }
                $vendorServices = explode(',', $vendor->serviceList);
                $vendorSubservices = explode(',', $vendor->subserviceList);

                $hasServiceMatch = count(array_intersect($serviceIds, $vendorServices)) > 0;
                $hasSubserviceMatch = count(array_intersect($subserviceIds, $vendorSubservices)) > 0;

                $vendorCityIDs = explode(',', $vendor->city);
                $vendorCityNames = [];
                foreach ($vendorCityIDs as $cid) {
                    if (isset($cityMaster[$cid])) {
                        $vendorCityNames[] = trim($cityMaster[$cid]);
                    }
                }
                $hasCityMatch = count(array_intersect($orderCities, $vendorCityNames)) > 0;

                return $hasServiceMatch && $hasSubserviceMatch && $hasCityMatch;
            });

        if ($vendors->isEmpty()) {
            return false;
        }

        $firstItem = $orders->flatMap->items->first();
        $service_name = $firstItem ? \Helper::subservicename($firstItem->subservice_id) : '';
        $subject = "You got New Booking for $service_name | Order Number {$orderdata->format_order_id}";

        $vendor_bcc_emails = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];

        // SEND MAIL TO VENDORS ASYNC
        dispatch(function () use ($vendors, $orders, $order_id, $user, $orderdata, $service_name, $subject, $vendor_bcc_emails) {
            foreach ($vendors as $vendor) {
                try {
                    $attributeEmails = DB::table('vendors_attribute')
                        ->where('pid', $vendor->id)
                        ->whereNotNull('c_email')
                        ->pluck('c_email')
                        ->toArray();

                    $allVendorEmails = array_filter(array_merge([$vendor->email], $attributeEmails));

                    if (!empty($allVendorEmails)) {
                        Mail::send('emails.vendor_booking_order_notification', [
                            'user' => $user,
                            'orders' => $orders,
                            'order_number' => $order_id,
                            'vendor' => $vendor,
                        ], function ($message) use ($allVendorEmails, $vendor, $subject, $vendor_bcc_emails) {
                            $message->to($allVendorEmails, $vendor->name ?? 'Vendor')
                                ->bcc($vendor_bcc_emails)
                                ->subject($subject);
                        });
                    }

                    // insert into notification table
                    // $data_notification = [
                    //     'vendor_id' => $vendor->id,
                    //     'subject' => 'New Lead Generated for ' . $service_name,
                    //     'added_datetime' => date('Y-m-d h:i:s')
                    // ];
                    // DB::table('notification')->insert($data_notification);

                    \Helper::success_msg_whatsapp_allVendor($vendor->id, $order_id);
                } catch (\Exception $e) {
                    \Log::error('Vendor mail failed (' . $vendor->email . '): ' . $e->getMessage());
                }
            }
        })->afterResponse();

        return true;
    }

    public function package_checkout(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }
        $userid = $user->id;

        $payment_type = $request->payment_type;
        if ($payment_type == 'COD') {
            $order_status = 'BK';
            $paymentmode = 1;
            $list_order_status = '0';
            $payment_status = 'Success';
        } elseif ($payment_type == 'TABBY') {
            $order_status = 'BK';
            $paymentmode = 3;
            $list_order_status = '0';
            $payment_status = 'FAILED';
        } else {
            $order_status = 'BK';
            $paymentmode = 2;
            $list_order_status = '0';
            $payment_status = 'FAILED';
        }

        $intOrderNumber = DB::table('ci_orders')
            ->select(DB::raw('MAX(order_id) as lastOrderNumber'))
            ->first();

        $order_number = $intOrderNumber ? $intOrderNumber->lastOrderNumber + 1 : 1;

        $wallet_plus_amount = DB::table('front_user_wallet')
            ->where('refer_id', $userid)
            ->where('added_from', 0)
            ->sum('wallet_amount');

        $wallet_minus_amount = DB::table('front_user_wallet')
            ->where('refer_id', $userid)
            ->where('added_from', 1)
            ->sum('wallet_amount');

        $front_wallet_amount = $wallet_plus_amount - $wallet_minus_amount;

        $order_total = $request->total_to_pay;
        $vat_total = $request->vat_total ?? 0;
        $order_total_new = ($request->sub_total ?? 0) + $vat_total;

        $coupan_to_wallet = '';
        $coupon_discounted = 0;
        $coupan_code_name = $request->coupon_code ?? '';

        if (!empty($coupan_code_name)) {
            $coupon_discount = $request->coupon_discount ?? 0;
            $coupanvalue = $request->coupanvalue ?? 0; // 0 for %, 1 for flat

            if ($request->coupan_apply_wallet == 0) {
                if ($coupon_discount != '' && $coupanvalue == 0) {
                    $coupon_discounted = ($order_total_new * $coupon_discount) / 100;
                }
                if ($coupon_discount != '' && $coupanvalue == 1) {
                    $coupon_discounted = $coupon_discount;
                }

                $wallet_content = [
                    'userid' => $userid,
                    'refer_id' => $userid,
                    'order_currency' => 'AED',
                    'order_total' => $order_total_new,
                    'system_percentage' => '',
                    'wallet_amount' => $coupon_discounted,
                    'added_from' => 0,
                    'order_id' => $order_number,
                    'added_date' => date('Y-m-d'),
                ];
                DB::table('front_user_wallet')->insertGetId($wallet_content);
                $coupan_to_wallet = '1';
            } else {
                if ($coupon_discount != '' && $coupanvalue == 0) {
                    $coupon_discounted = ($order_total_new * $coupon_discount) / 100;
                }
                if ($coupon_discount != '' && $coupanvalue == 1) {
                    $coupon_discounted = $coupon_discount;
                }
                $coupan_to_wallet = '0';
            }
        }

        $walletAmount = 0;
        if ($request->wallet_used != '' && $request->wallet_used > 0) {
            $wallet_content = [
                'userid' => $userid,
                'refer_id' => $userid,
                'order_currency' => 'AED',
                'order_total' => $order_total_new,
                'system_percentage' => '',
                'wallet_amount' => $request->wallet_used,
                'added_from' => 1,
                'order_id' => $order_number,
                'added_date' => date('Y-m-d'),
            ];
            DB::table('front_user_wallet')->insertGetId($wallet_content);
            $walletAmount = $request->wallet_used;
        }

        $front_wallet_amount_new = $walletAmount;

        $timing_charger = $request->timing_charge + $request->weekly_off_charge;

        $content = array(
            'user_id' => $userid,
            'order_number' => $order_number,
            'order_total' => $order_total,
            'front_wallet_amount' => $front_wallet_amount_new,
            'vatcharge' => $request->vat_total,
            'order_currency' => 'AED',
            'order_status' => $order_status,
            'paymentmode' => $paymentmode,
            'payment_status' => $payment_status,
            'created_at' => date('Y-m-d H:i:s'),
            'coupan_to_wallet' => $coupan_to_wallet,
            'coupondiscount' => $coupon_discounted,
            'coupon_code' => $coupan_code_name,
            'list_order_status' => $list_order_status,
            'service_charge' => $request->service_charge,
            'promo_discount' => $request->promo_discount,
            'timing_charge' => $timing_charger,
            'additional_charge' => $request->additional_charge,
            'sub_total' => $request->sub_total,
            'cod_charge' => $request->cod_charge,
            'service_fee' => $request->service_fee,
            'order_from' => 1,
        );

        $arrOrderId = DB::table('ci_orders')->insertGetId($content);

        // Sequence Number Generation
        $cityName = $request->city ?? '';
        $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($cityName) . '%'])->first();
        $subserviceData = DB::table('subservices')->where('id', $request->subservice_id)->first();

        $subserviceCode = isset($subserviceData->subservice_code) ? $subserviceData->subservice_code : 'OT';
        $cityCode = isset($cityData->city_code) ? $cityData->city_code : 'DU';
        $year = date('y');

        $lastSequence = DB::table('ci_orders')
            ->where('subservice_code', $subserviceCode)
            ->where('city_code', $cityCode)
            ->where('order_year', $year)
            ->selectRaw('MAX(CAST(sequence_no AS UNSIGNED)) as seq')
            ->lockForUpdate()
            ->value('seq');

        $nextSequence = $lastSequence ? $lastSequence + 1 : 1;

        $formatOrderId = sprintf("%s-%s-%s-%06d", $subserviceCode, $year, $cityCode, $nextSequence);

        DB::table('ci_orders')->where('order_id', $arrOrderId)->update([
            'subservice_code' => $subserviceCode,
            'city_code' => $cityCode,
            'order_year' => $year,
            'sequence_no' => $nextSequence,
            'format_order_id' => $formatOrderId
        ]);

        $which_day = "";
        if (!empty($request->which_day_of_the_week_do_you_want_the_service) && is_array($request->which_day_of_the_week_do_you_want_the_service)) {
            $which_day = implode(',', $request->which_day_of_the_week_do_you_want_the_service);
        }

        // Parse booking_date (e.g., "2026-08-15")
        $bookingDateStr = $request->booking_date;
        $carbonDate = \Carbon\Carbon::parse($bookingDateStr);

        $reqDate = $carbonDate->format('d');
        $reqMonth = $carbonDate->format('F');
        $reqYear = $carbonDate->format('Y');

        $formatted_date = $carbonDate->format('Y-m-d');
        $end_date = $formatted_date;

        $arrData = array(
            'order_id' => $arrOrderId,
            'user_info_id' => $userid,
            'service_id' => $request->service_id,
            'subservice_id' => $request->subservice_id,
            'how_many_cleaners_do_you_need' => $request->how_many_cleaners_do_you_need,
            'how_many_hours_should_they_stay' => $request->how_many_hours_should_they_stay,
            'how_often_do_you_need_cleaning' => $request->how_often_do_you_need_cleaning,
            'do_you_need_cleaning_material' => $request->do_you_need_cleaning_material,
            'any_special_instruction' => $request->any_special_instruction,
            'address_type' => $request->address_type,
            'city' => $request->city,
            'area' => $request->area,
            'building_street_no' => $request->building_street_no,
            'apartment_villa_no' => $request->apartment_villa_no,
            'emirates_id_number' => ($request->service_id == 54) ? ($request->emirates_id_number ?? '') : '',
            'passport_number' => ($request->service_id == 54) ? ($request->passport_number ?? '') : '',
            'plate_source' => ($request->subservice_id == 93) ? ($request->plate_source ?? '') : '',
            'plate_code' => ($request->subservice_id == 93) ? ($request->plate_code ?? '') : '',
            'plate_number' => ($request->subservice_id == 93) ? ($request->plate_number ?? '') : '',
            'describe_your_car' => ($request->subservice_id == 93) ? ($request->car_description ?? '') : '',
            'bookingdate' => $reqDate,
            'bookingyear' => $reqYear,
            'month' => $reqMonth,
            'time_slot' => $request->time_slot,
            'end_date' => $end_date,
            'which_day_of_the_week_do_you_want_the_service' => $which_day,
            'cdate' => date('Y-m-d'),
        );

        $order_item_id = DB::table('ci_order_item')->insertGetId($arrData);

        if ($request->has('pending_lead_id') && $request->pending_lead_id != '') {
            DB::table('general_enquiries')->where('id', $request->pending_lead_id)->update([
                'status' => 'Booked',
                'updated_at' => now(),
            ]);
        }

        // Packages insert
        if ($request->has('packages') && is_array($request->packages) && count($request->packages) > 0) {
            foreach ($request->packages as $package) {
                $packageDetails = DB::table('packages')->where('id', $package['package_id'])->first();

                $packageCatName = '';
                try {
                    if ($packageDetails && $packageDetails->packagecategory_id) {
                        $cat = DB::table('package_categories')->where('id', $packageDetails->packagecategory_id)->first();
                        $packageCatName = $cat ? $cat->name : '';
                    }
                } catch (\Exception $e) {
                    try {
                        if ($packageDetails && $packageDetails->packagecategory_id) {
                            $cat = DB::table('packagecategory')->where('id', $packageDetails->packagecategory_id)->first();
                            $packageCatName = $cat ? $cat->name : '';
                        }
                    } catch (\Exception $e2) {
                        // Ignore
                    }
                }

                $arrData_package = array(
                    'order_id' => $arrOrderId,
                    'order_item_id' => $order_item_id,
                    'user_info_id' => $userid,
                    'package_id' => $package['package_id'],
                    'package_item_name' => $package['name'] ?? ($packageDetails->name ?? ''),
                    'package_quantity' => $package['qty'],
                    'package_item_price' => $package['price'] ?? ($packageDetails->price ?? 0),
                    'service_id' => $request->service_id,
                    'service_name' => '',
                    'subservice_id' => $request->subservice_id,
                    'subservice_name' => '',
                    'packagecategory_id' => $packageDetails ? $packageDetails->packagecategory_id : 0,
                    'packagecategory_name' => $packageCatName,
                    'image' => $packageDetails ? $packageDetails->image : '',
                    'discount' => $packageDetails ? $packageDetails->discount : '',
                    'discount_type' => $packageDetails ? $packageDetails->discount_type : '',
                    'product_discount_amount' => 0,
                    'cdate' => date('Y-m-d'),
                );

                DB::table('ci_order_item_packages')->insertGetId($arrData_package);
            }
        }

        // Addons insert
        if ($request->has('addons') && is_array($request->addons) && count($request->addons) > 0) {
            foreach ($request->addons as $addon) {
                $addonDetails = DB::table('addons')->where('id', $addon['addon_id'])->first();

                $arrData_addons = array(
                    'order_id' => $arrOrderId,
                    'order_item_id' => $order_item_id,
                    'user_info_id' => $userid,
                    'package_id' => $addon['addon_id'],
                    'package_item_name' => $addon['name'] ?? ($addonDetails->name ?? ''),
                    'package_quantity' => $addon['qty'],
                    'package_item_price' => $addon['price'] ?? ($addonDetails->price ?? 0),
                    'service_id' => $request->service_id,
                    'service_name' => '',
                    'subservice_id' => $request->subservice_id,
                    'subservice_name' => '',
                    'image' => $addonDetails ? $addonDetails->image : '',
                    'discount' => $addonDetails ? $addonDetails->discount : '',
                    'discount_type' => $addonDetails ? $addonDetails->discount_type : '',
                    'product_discount_amount' => 0,
                    'cdate' => date('Y-m-d'),
                );

                DB::table('ci_order_item_addons')->insertGetId($arrData_addons);
            }
        }

        // Shipping Address
        $dataShip = [
            'first_name' => $user->name,
            'last_name' => '',
            'country' => 'UAE',
            'city' => $request->city,
            'area' => $request->area,
            'address1' => $request->building_street_no,
            'address2' => $request->apartment_villa_no,
            'phone_number' => $user->mobile,
            'email_address' => $user->email,
            'additional_message' => $request->any_special_instruction,
            'payment_method' => $request->payment_type,
            'order_id' => $arrOrderId,
            'user_id' => $userid,
        ];
        DB::table('ci_shipping_address')->insert($dataShip);

        // Removed previous simple wallet deduction logic because it's now handled by the walletAmount calculation above

        if ($payment_type == 'COD') {
            $this->send_success_mail_api($arrOrderId, $user);
            $this->send_vendor_lead_mail_api($arrOrderId, $user);

            return response()->json([
                'status' => true,
                'message' => 'Booking placed successfully.',
                'data' => [
                    'order_id' => $arrOrderId,
                    'format_order_id' => $formatOrderId
                ]
            ]);
        } elseif ($payment_type == 'TABBY') {
            $tabbyService = app(\App\Services\TabbyService::class);
            $bookingData = [
                'order_id' => $formatOrderId,
                'total_amount' => $order_total_new,
                'customer_phone' => $user->mobile ?? '',
                'customer_email' => $user->email ?? '',
                'customer_name' => $user->name ?? '',
                'tax_amount' => $request->vat_total ?? 0,
                'items' => []
            ];

            $response = $tabbyService->createSession($bookingData);

            if ($response && isset($response['configuration']['available_products']['installments'][0]['web_url'])) {
                $paymentId = $response['payment']['id'] ?? '';
                DB::table('ci_orders')->where('order_id', $arrOrderId)->update(['tabby_payment_id' => $paymentId]);

                return response()->json([
                    'status' => true,
                    'message' => 'Tabby Session created',
                    'data' => [
                        'order_id' => $arrOrderId,
                        'format_order_id' => $formatOrderId,
                        'payment_url' => $response['configuration']['available_products']['installments'][0]['web_url']
                    ]
                ]);
            }
            return response()->json(['status' => false, 'message' => 'Tabby payment initialization failed.'], 500);
        } else {
            // STRIPE
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'aed',
                            'product_data' => ['name' => 'Your Total'],
                            'unit_amount' => $order_total_new * 100,
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('payment_success'),
                'cancel_url' => route('payment_fail'),
            ]);

            if (isset($response->id) && $response->id != '') {
                DB::table('ci_orders')->where('order_id', $arrOrderId)->update(['stripe_session_id' => $response->id]);
                return response()->json([
                    'status' => true,
                    'message' => 'Stripe Session created',
                    'data' => [
                        'order_id' => $arrOrderId,
                        'format_order_id' => $formatOrderId,
                        'payment_url' => $response->url
                    ]
                ]);
            } else {
                return response()->json(['status' => false, 'message' => 'Stripe payment initialization failed.'], 500);
            }
        }
    }
}
