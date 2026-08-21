<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\front\Ciorder;
use App\Models\front\CiorderItem;
use App\Models\front\CiShippingAddress;

class BookingApiController extends Controller
{
    public function myBookings(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'user_id'      => 'required|integer',
            'booking_type' => 'required'

        ]);

        if ($validator->fails()) {

            return response()->json([

                'status' => false,
                'message' => $validator->errors()->first()

            ], 422);
        }

        $userid = $request->user_id;

        $bookingType = strtolower($request->booking_type);

        $perPage = 10;

        $today = date('Y-m-d');

        $orders = DB::table('ci_orders')
            ->leftJoin(
                'frontloginregisters',
                'ci_orders.user_id',
                '=',
                'frontloginregisters.id'
            )
            ->select(
                'ci_orders.*',
                'frontloginregisters.name as user_name',
                'frontloginregisters.email as user_email',
                'frontloginregisters.mobile as user_mobile'
            )
            ->where('ci_orders.user_id', $userid)
            ->where('ci_orders.is_delete', '0')
            ->orderBy('ci_orders.order_id', 'DESC')
            ->get();

        if ($orders->count() == 0) {

            return response()->json([

                'status' => false,
                'message' => 'No bookings found.',
                'data' => []

            ]);
        }

        $bookingCollection = collect();

        foreach ($orders as $order) {

            $items = DB::table('ci_order_item')
                ->where('order_id', $order->order_id)
                ->get();

            if ($items->count() == 0) {
                continue;
            }

            $order->items = $items;

            $item = $items->first();

            $total = 0;

            foreach ($items as $row) {

                $price = !empty($row->product_discount_amount)
                    ? $row->product_discount_amount
                    : $row->package_item_price;

                $total += ($price * $row->package_quantity);
            }

            $order->sub_total = $total;

            try {

                $startDate = Carbon::parse(
                    $item->bookingdate . ' ' .
                        $item->month . ' ' .
                        $item->bookingyear
                );
            } catch (\Exception $e) {

                $startDate = Carbon::today();
            }

            if (!empty($item->end_date)) {

                $endDate = Carbon::parse($item->end_date);
            } else {

                $endDate = $startDate->copy();
            }

            $visitDates = [];

            /*
            |--------------------------------------------------------------------------
            | Generate Visit Dates
            |--------------------------------------------------------------------------
            */

            if ($item->how_often_do_you_need_cleaning == 'Weekly') {

                $current = $startDate->copy();

                while ($current <= $endDate) {

                    $visitDates[] = $current->toDateString();

                    $current->addWeek();
                }
            } elseif (
                strtolower($item->how_often_do_you_need_cleaning) == 'multiple times a week'
            ) {

                $days = explode(',', $item->which_day_of_the_week_do_you_want_the_service);

                $days = array_map('trim', $days);

                $current = $startDate->copy();

                while ($current <= $endDate) {

                    if (in_array(
                        strtolower($current->format('l')),
                        array_map('strtolower', $days)
                    )) {

                        $visitDates[] = $current->toDateString();
                    }

                    $current->addDay();
                }
            } else {

                $visitDates[] = $startDate->toDateString();
            }

            /*
            |--------------------------------------------------------------------------
            | Find Latest Past Visit & Next Upcoming Visit
            |--------------------------------------------------------------------------
            */

            $latestPastVisit = null;

            $nextUpcomingVisit = null;

            foreach ($visitDates as $visitDate) {

                if ($visitDate < $today) {

                    $latestPastVisit = $visitDate;
                } elseif (!$nextUpcomingVisit) {

                    $nextUpcomingVisit = $visitDate;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Tips
            |--------------------------------------------------------------------------
            */

            $tips = collect();

            $tipAmount = 0;

            if ($nextUpcomingVisit) {

                $tips = DB::table('ci_tips')
                    ->where('order_id', $order->order_id)
                    ->where('visit_date', $nextUpcomingVisit)
                    ->where('payment_status', 'paid')
                    ->get();

                $tipAmount = $tips->sum('tip_amount');
            } elseif ($latestPastVisit) {

                $tips = DB::table('ci_tips')
                    ->where('order_id', $order->order_id)
                    ->where('visit_date', $latestPastVisit)
                    ->where('payment_status', 'paid')
                    ->get();

                $tipAmount = $tips->sum('tip_amount');
            }

            /*
            |--------------------------------------------------------------------------
            | Service Details
            |--------------------------------------------------------------------------
            */

            $serviceData = DB::table('services')->where('id', $item->service_id)->first();

            $serviceName = "";

            if (!empty($item->subservice_id)) {

                $serviceName = Helper::subservicename($item->subservice_id);
            }

            $cleaner = "";

            if (!empty($order->cleaner_id)) {

                $cleaner = Helper::cleanername_new($order->cleaner_id);
            }

            $timeSlot = "";

            if (!empty($item->time_slot)) {

                $timeSlot = Helper::timeslotname($item->time_slot);
            }

            /*
            |--------------------------------------------------------------------------
            | Prepare Response Array
            |--------------------------------------------------------------------------
            */

            $booking = [];

            $booking['order_id'] = $order->order_id;
            $booking['subservice_icon'] = !empty($serviceData->app_icon)
                ? asset('public/upload/service/' . $serviceData->app_icon)
                : '';

            //$booking['booking_no'] = $order->booking_id;

            $booking['subservice_name'] = $serviceName;

            $booking['cleaner_name'] = $cleaner;

            $booking['booking_date'] = Carbon::parse(
                $item->bookingdate . ' ' . $item->month . ' ' . $item->bookingyear
            )->format('Y-m-d');

            $booking['booking_time'] = $timeSlot;

            $booking['visit_date'] = $nextUpcomingVisit;

            $booking['latest_visit'] = $latestPastVisit;

            $booking['subtotal'] = number_format($order->sub_total, 2, '.', '');

            $booking['order_total'] = number_format($order->order_total, 2, '.', '');

            $booking['tips'] = number_format($tipAmount, 2, '.', '');

            $booking['order_status'] = $order->order_status;

            $booking['payment_status'] = $order->payment_status;

            //$booking['address'] = $order->address;

            // $booking['latitude'] = $order->latitude;

            // $booking['longitude'] = $order->longitude;

            $booking['items'] = $items;



            /*
            |--------------------------------------------------------------------------
            | Part 3 Starts Here
            | Upcoming
            | Completed
            | Cancelled
            | Unpaid
            |--------------------------------------------------------------------------
            */

            /*
            |--------------------------------------------------------------------------
            | Upcoming Bookings
            |--------------------------------------------------------------------------
            */

            if ($bookingType == 'upcoming') {

                if (
                    !empty($nextUpcomingVisit) &&
                    $order->order_status != 'CL' &&
                    $order->order_status != 'CO'
                ) {

                    $booking['display_status'] = 'Upcoming';
                    $booking['visit_date'] = $nextUpcomingVisit;
                    $booking['book_again'] = false;

                    $bookingCollection->push($booking);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Completed Bookings
            |--------------------------------------------------------------------------
            */ elseif ($bookingType == 'completed') {

                if (
                    !empty($latestPastVisit) ||
                    ($order->order_status == 'CO' && !empty($nextUpcomingVisit))
                ) {

                    $booking['display_status'] = 'Completed';

                    if (!empty($latestPastVisit)) {
                        $booking['visit_date'] = $latestPastVisit;
                    } else {
                        $booking['visit_date'] = $nextUpcomingVisit;
                    }

                    $booking['book_again'] = true;

                    $bookingCollection->push($booking);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Cancelled Bookings
            |--------------------------------------------------------------------------
            */ elseif ($bookingType == 'cancelled') {

                if ($order->order_status == 'CL') {

                    $booking['display_status'] = 'Cancelled';
                    $booking['visit_date'] = !empty($latestPastVisit)
                        ? $latestPastVisit
                        : $nextUpcomingVisit;

                    $booking['book_again'] = true;

                    $bookingCollection->push($booking);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Unpaid Bookings
            |--------------------------------------------------------------------------
            */ elseif ($bookingType == 'unpaid') {

                if (
                    strtolower($order->payment_status) == 'pending' ||
                    strtolower($order->payment_status) == 'unpaid'
                ) {

                    $booking['display_status'] = 'Unpaid';
                    $booking['visit_date'] = $nextUpcomingVisit;
                    $booking['book_again'] = false;

                    $bookingCollection->push($booking);
                }
            }
        } // End foreach orders


        /*
        |--------------------------------------------------------------------------
        | Sort Collection
        |--------------------------------------------------------------------------
        */

        $bookingCollection = $bookingCollection->sortByDesc('order_id')->values();

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $page = LengthAwarePaginator::resolveCurrentPage();

        $results = new LengthAwarePaginator(

            $bookingCollection->forPage($page, $perPage),

            $bookingCollection->count(),

            $perPage,

            $page,

            [

                'path' => request()->url(),

                'query' => request()->query()

            ]

        );

        /*
        |--------------------------------------------------------------------------
        | Part 4 Starts Here
        | Final JSON Response
        | API Success Response
        |--------------------------------------------------------------------------
        */
        /*
        |--------------------------------------------------------------------------
        | Return Empty Data
        |--------------------------------------------------------------------------
        */

        if ($results->count() == 0) {

            return response()->json([

                'status' => true,

                'message' => 'No ' . ucfirst($bookingType) . ' bookings found.',

                'current_page' => 1,

                'last_page' => 1,

                'per_page' => $perPage,

                'total' => 0,

                'data' => []

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Success Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'status' => true,

            'message' => ucfirst($bookingType) . ' bookings fetched successfully.',

            'current_page' => $results->currentPage(),

            'last_page' => $results->lastPage(),

            'per_page' => $results->perPage(),

            'total' => $results->total(),

            'data' => $results->values()

        ]);




        // echo "<pre>";
        // print_r($orders);
        // exit;
    }

    function bookingDetails(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'user_id'      => 'required|integer',
            'order_id' => 'required|integer'

        ]);

        $order_id = $request->order_id;

        if ($validator->fails()) {

            return response()->json([

                'status' => false,
                'message' => $validator->errors()->first()

            ], 422);
        }

        $query = Ciorder::leftJoin('frontloginregisters', 'ci_orders.user_id', '=', 'frontloginregisters.id')
            ->leftJoin('ci_shipping_address', 'ci_orders.order_id', '=', 'ci_shipping_address.order_id')
            ->select(
                'frontloginregisters.email as user_email',
                'frontloginregisters.name as user_name',
                'frontloginregisters.mobile as user_mobile',
                'frontloginregisters.country_code as user_country_code',
                'ci_orders.*',
                'ci_shipping_address.*'
            )
            ->where('ci_orders.order_id', $order_id)
            ->where('ci_orders.user_id', $request->user_id);

        $order = $query->first();

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found.'
            ]);
        }

        $items = DB::table('ci_order_item')
            ->where('order_id', $order->order_id)
            ->get();

        $today = date('Y-m-d');



        $item = $items->first();

        $total = 0;



        try {

            $startDate = Carbon::parse(
                $item->bookingdate . ' ' .
                    $item->month . ' ' .
                    $item->bookingyear
            );
        } catch (\Exception $e) {

            $startDate = Carbon::today();
        }

        if (!empty($item->end_date)) {

            $endDate = Carbon::parse($item->end_date);
        } else {

            $endDate = $startDate->copy();
        }

        $visitDates = [];

        /*
            |--------------------------------------------------------------------------
            | Generate Visit Dates
            |--------------------------------------------------------------------------
            */

        if ($item->how_often_do_you_need_cleaning == 'Weekly') {

            $current = $startDate->copy();

            while ($current <= $endDate) {

                $visitDates[] = $current->toDateString();

                $current->addWeek();
            }
        } elseif (
            strtolower($item->how_often_do_you_need_cleaning) == 'multiple times a week'
        ) {

            $days = explode(',', $item->which_day_of_the_week_do_you_want_the_service);

            $days = array_map('trim', $days);

            $current = $startDate->copy();

            while ($current <= $endDate) {

                if (in_array(
                    strtolower($current->format('l')),
                    array_map('strtolower', $days)
                )) {

                    $visitDates[] = $current->toDateString();
                }

                $current->addDay();
            }
        } else {

            $visitDates[] = $startDate->toDateString();
        }

        /*
            |--------------------------------------------------------------------------
            | Find Latest Past Visit & Next Upcoming Visit
            |--------------------------------------------------------------------------
            */

        $latestPastVisit = null;

        $nextUpcomingVisit = null;

        foreach ($visitDates as $visitDate) {

            if ($visitDate < $today) {

                $latestPastVisit = $visitDate;
            } elseif (!$nextUpcomingVisit) {

                $nextUpcomingVisit = $visitDate;
            }
        }

        /*
            |--------------------------------------------------------------------------
            | Tips
            |--------------------------------------------------------------------------
            */

        $tips = collect();

        $tipAmount = 0;

        if ($nextUpcomingVisit) {

            $tips = DB::table('ci_tips')
                ->where('order_id', $order->order_id)
                ->where('visit_date', $nextUpcomingVisit)
                ->where('payment_status', 'paid')
                ->get();

            $tipAmount = $tips->sum('tip_amount');
        } elseif ($latestPastVisit) {

            $tips = DB::table('ci_tips')
                ->where('order_id', $order->order_id)
                ->where('visit_date', $latestPastVisit)
                ->where('payment_status', 'paid')
                ->get();

            $tipAmount = $tips->sum('tip_amount');
        }

        $response = [];

        $serviceName = "";

        if (!empty($item->subservice_id)) {

            $serviceName = Helper::subservicename($item->subservice_id);
        }

        $itemData = [];

        foreach ($items as $row) {

            $price = !empty($row->product_discount_amount)
                ? $row->product_discount_amount
                : $row->package_item_price;

            $cleaner_Id = explode(',', $row->cleaner_id);

            $cleanerName = !empty($row->cleaner_id)
                ? Helper::cleanername_new(explode(',', $row->cleaner_id))
                : null;

            $origin_country = !empty($row->origin_country)
                ? Helper::countryname($row->origin_country)
                : null;
            $desti_country = !empty($row->desti_country)
                ? Helper::countryname($row->desti_country)
                : null;

            $itemData[] = [

                'item_id' => $row->id,

                'service_name' => Helper::subservicename($row->subservice_id),

                'booking_date' => Carbon::parse(
                    $row->bookingdate . ' ' . $row->month . ' ' . $row->bookingyear
                )->format('Y-m-d'),

                'booking_time' => Helper::timeslotname($row->time_slot),

                'frequency' => $row->how_often_do_you_need_cleaning,

                'quantity' => (int) $row->package_quantity,

                'price' => (float) $price,

                'total' => (float) ($price * $row->package_quantity),

                'visit_date' => $nextUpcomingVisit,
                'cleaner_name' => $cleanerName,
                'how_many_cleaners_do_you_need' => $row->how_many_cleaners_do_you_need,
                'how_many_hours_should_they_stay' => $row->how_many_hours_should_they_stay,
                'how_often_do_you_need_cleaning' => $row->how_often_do_you_need_cleaning,
                'do_you_need_cleaning_material' => $row->do_you_need_cleaning_material,
                'any_special_instruction' => $row->any_special_instruction,
                'address_type' => $row->address_type,
                'city' => $row->city,
                'area' => $row->area,
                'building_street_no' => $row->building_street_no,
                'apartment_villa_no' => $row->apartment_villa_no,
                'emirates_id_number' => $row->emirates_id_number,
                'passport_number' => $row->passport_number,
                'location_link' => $row->location_link,
                'which_day_of_the_week_do_you_want_the_service' => $row->which_day_of_the_week_do_you_want_the_service,
                'verifybuy_location' => $row->verifybuy_location,
                'verifybuy_address' => $row->verifybuy_address,
                'verifybuy_additional_details' => $row->verifybuy_additional_details,
                'verifybuy_where_is_car_parked' => $row->verifybuy_where_is_car_parked,
                'verifybuy_vehicle' => $row->verifybuy_vehicle,
                'verifybuy_model' => $row->verifybuy_model,
                'verifybuy_category' => $row->verifybuy_category,
                'verifybuy_others' => $row->verifybuy_others,
                'verifybuy_documents' => $row->verifybuy_documents,
                'origin_add' => $row->origin_add,
                'origin_country' => $origin_country,
                'origin_state' => $row->origin_state,
                'origin_city' => $row->origin_city,
                'origin_location' => $row->origin_location,
                'origin_zip_post' => $row->origin_zip_post,
                'desti_add' => $row->desti_add,
                'desti_country' => $desti_country,
                'desti_state' => $row->desti_state,
                'desti_city' => $row->desti_city,
                'desti_location' => $row->desti_location,
                'desti_zip_post' => $row->desti_zip_post,
                'charger_type' => $row->charger_type,
                'installation_location_type' => $row->installation_location_type,
                'installation_charge' => $row->installation_charge,
                'charger_type' => $row->charger_type,
                'installation_location_type' => $row->installation_location_type,
                'installation_charge' => $row->installation_charge,
                'storage_type' => $row->storage_type,
                'storage_location' => $row->storage_location,
                'storage_from_date' => $row->storage_from_date,
                'storage_to_date' => $row->storage_to_date,
                'items_to_store' => $row->items_to_store,
                'space_required' => $row->space_required,
                'warehouse_name' => $row->warehouse_name,
                'unit_no' => $row->unit_no,
                'emirate_id' => $row->emirate_id,
                'trade_license' => $row->trade_license,
                'space_price' => $row->space_price,
                'manpower_service_required' => $row->manpower_service_required,
                'manpower_workers_required' => $row->manpower_workers_required,
                'manpower_start_date' => $row->manpower_start_date,
                'manpower_end_date' => $row->manpower_end_date,
                'manpower_duration' => $row->manpower_duration,
                'manpower_job_description' => $row->manpower_job_description,
                'manpower_additional_notes' => $row->manpower_additional_notes,

            ];
        }


        $response['order'] = [

            'order_id'        => $order->order_id,
            'booking_id'      => $order->format_order_id,
            'order_status'    => $order->order_status,
            'payment_status'  => $order->payment_status,

            'customer_name'   => $order->user_name,
            'customer_email'  => $order->user_email,
            'customer_mobile' => $order->user_mobile,

            'sub_total'       => $order->sub_total,
            // 'service_charge'  => $order->service_charge,
            'vat'             => $order->vatcharge,
            'discount'        => $order->discount,
            'order_total'     => $order->order_total,
            'service_fee'     => $order->service_fee,
            'cod_charge'     => $order->cod_charge,
            'timing_charge'     => $order->timing_charge,
            'date_charge'     => $order->date_charge,
            'additional_charge'     => $order->additional_charge,
            'coupondiscount'     => $order->coupondiscount,

            'payment_method'  => $order->payment_method,
            'created_at'      => $order->created_at,

        ];

        $response['items'] = $itemData;


        // echo "<pre>";
        // print_r($response);
        // exit;

        return response()->json([
            'status' => true,
            'message' => 'Booking details fetched successfully.',
            'data' => $response
        ]);
    }

    public function paymentIntent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'payment_method' => 'required|in:stripe,tabby,cod,google_pay,apple_pay',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $paymentMethod = strtolower($request->payment_method);
        $amount = $request->amount; // Amount in AED
        $user = auth()->user();

        // Both google_pay and apple_pay use Stripe Payment Intents
        if (in_array($paymentMethod, ['stripe', 'google_pay', 'apple_pay'])) {
            try {
                $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));

                // 1. Create or retrieve Customer
                $customer = $stripe->customers->create([
                    'email' => $user->email ?? 'test@example.com',
                    'name'  => $user->name ?? 'Mobile App User',
                ]);

                // 2. Create Ephemeral Key
                $ephemeralKey = $stripe->ephemeralKeys->create(
                    ['customer' => $customer->id],
                    ['stripe_version' => '2022-08-01']
                );

                // 3. Create Payment Intent
                $paymentIntent = $stripe->paymentIntents->create([
                    'amount' => intval($amount * 100), // Amount must be in cents/fils
                    'currency' => 'aed',
                    'customer' => $customer->id,
                    'automatic_payment_methods' => [
                        'enabled' => 'true',
                    ],
                ]);

                return response()->json([
                    'status' => true,
                    'payment_method' => 'stripe', // Always 'stripe' for mobile SDK integration
                    'data' => [
                        'clientSecret' => $paymentIntent->client_secret,
                        'customerId' => $customer->id,
                        'ephemeralKeySecret' => $ephemeralKey->secret,
                        'publishableKey' => config('stripe.stripe_pk')
                    ]
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Stripe Error: ' . $e->getMessage()
                ], 500);
            }
        } elseif ($paymentMethod === 'tabby') {
            // Mock Tabby Integration for now, until Tabby API credentials are provided
            // Usually involves a server-to-server request to Tabby API to create a session
            return response()->json([
                'status' => true,
                'payment_method' => 'tabby',
                'data' => [
                    'session_id' => 'tabby_test_session_' . time(),
                    'payment_url' => 'https://checkout.tabby.ai/test'
                ]
            ]);
        } elseif ($paymentMethod === 'cod') {
            return response()->json([
                'status' => true,
                'payment_method' => 'cod',
                'message' => 'Cash on delivery selected successfully',
                'data' => []
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Invalid payment method'], 400);
    }
}
