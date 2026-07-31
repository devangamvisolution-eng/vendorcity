<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Admin\Subservice;

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
                    "service_id" => 54,
                    "subservice_id" => 28,
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
            'cleaner_id'     => 'required|integer',
            'subservice_id'  => 'required|integer',
            'service_date'   => 'required|date_format:Y-m-d',
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

        $date  = $selectedDate->day;
        $month = $selectedDate->month;
        $year  = $selectedDate->year;

        $cleanerId     = $request->cleaner_id;
        $subserviceId  = $request->subservice_id;
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
                (int)$booking->how_many_hours_should_they_stay;
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

                    $disableHours = (int)$booking->how_many_hours_should_they_stay;

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
                'slot_name'    => $slot->slot_name,
                'price'        => $slot->price,
                'available'    => $isAvailable
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
}
