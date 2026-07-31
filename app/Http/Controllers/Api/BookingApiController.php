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

        $response = [];

        $response['order'] = [

            'order_id'        => $order->order_id,
            'booking_id'      => $order->booking_id,
            'order_number'    => $order->order_number,
            'order_status'    => $order->order_status,
            'payment_status'  => $order->payment_status,

            'customer_name'   => $order->user_name,
            'customer_email'  => $order->user_email,
            'customer_mobile' => $order->user_mobile,

            'sub_total'       => $order->sub_total,
            'service_charge'  => $order->service_charge,
            'vat'             => $order->vatcharge,
            'discount'        => $order->discount,
            'order_total'     => $order->order_total,

            'payment_method'  => $order->payment_method,
            'created_at'      => $order->created_at,

        ];


        echo "<pre>";
        print_r($order);
        exit;
    }
}
