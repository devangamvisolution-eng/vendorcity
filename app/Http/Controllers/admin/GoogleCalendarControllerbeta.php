<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Carbon\Carbon;
use DB;
use App\Helpers\Helper;

class GoogleCalendarController extends Controller
{
    private function getClient()
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/devang-google-calendar.json'));
        $client->addScope(Google_Service_Calendar::CALENDAR);

        // ✅ IMPORTANT
        $client->setAccessType('offline');
        // ❌ REMOVE consent forcing (this was your issue)
        // $client->setPrompt('select_account consent');

        $client->setRedirectUri(route('admin.google.callback'));

        $tokenPath = storage_path('app/devang-google-token.json');

        // ❌ If no token → login required
        if (!file_exists($tokenPath)) {
            return redirect()->route('admin.google.auth');
        }

        $token = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($token);

        // 🔁 AUTO REFRESH TOKEN
        if ($client->isAccessTokenExpired()) {

            if (!empty($token['refresh_token'])) {

                $newToken = $client->fetchAccessTokenWithRefreshToken($token['refresh_token']);

                // keep refresh token safe
                if (!isset($newToken['refresh_token'])) {
                    $newToken['refresh_token'] = $token['refresh_token'];
                }

                file_put_contents($tokenPath, json_encode($newToken));
                $client->setAccessToken($newToken);
            } else {
                // 🔐 fallback login
                return redirect()->route('admin.google.auth');
            }
        }

        return $client;
    }

    // 🔐 FIRST TIME LOGIN ONLY
    public function auth()
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/devang-google-calendar.json'));
        $client->addScope(Google_Service_Calendar::CALENDAR);

        $client->setRedirectUri(route('admin.google.callback'));

        // ✅ only needed first time
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        return redirect($client->createAuthUrl());
    }

    // 🔐 CALLBACK
    public function callback(Request $request)
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/devang-google-calendar.json'));
        $client->setRedirectUri(route('admin.google.callback'));

        $token = $client->fetchAccessTokenWithAuthCode($request->code);

        $tokenPath = storage_path('app/devang-google-token.json');

        // ✅ preserve refresh token
        if (file_exists($tokenPath)) {
            $oldToken = json_decode(file_get_contents($tokenPath), true);

            if (!isset($token['refresh_token']) && isset($oldToken['refresh_token'])) {
                $token['refresh_token'] = $oldToken['refresh_token'];
            }
        }

        file_put_contents($tokenPath, json_encode($token));

        return redirect()->route('admin.orders.index')
            ->with('success', 'Google Connected Successfully');
    }

    // 🚀 MAIN SYNC FUNCTION
    public function sync(Request $request)
    {
        $id = $request->order_id;

        $order = DB::table('ci_orders')->where('order_id', $id)->first();
        if (!$order) {
            return response()->json(['status' => 0, 'message' => 'Order not found']);
        }

        $item = DB::table('ci_order_item')->where('order_id', $order->order_id)->first();
        if (!$item) {
            return response()->json(['status' => 0, 'message' => 'Order item not found']);
        }

        // 🔥 VISIT DATES
        $startDate = Carbon::parse($item->bookingdate . ' ' . $item->month . ' ' . $item->bookingyear);
        $endDate = !empty($item->end_date) ? Carbon::parse($item->end_date) : $startDate;

        $visitDates = [];

        if ($item->how_often_do_you_need_cleaning == 'Weekly') {
            $current = $startDate->copy();
            while ($current <= $endDate) {
                $visitDates[] = $current->toDateString();
                $current->addWeek();
            }
        } elseif (strtolower($item->how_often_do_you_need_cleaning) == 'multiple times a week') {

            $days = array_map('trim', explode(',', $item->which_day_of_the_week_do_you_want_the_service));

            $current = $startDate->copy();
            while ($current <= $endDate) {
                if (in_array(strtolower($current->format('l')), array_map('strtolower', $days))) {
                    $visitDates[] = $current->toDateString();
                }
                $current->addDay();
            }
        } else {
            $visitDates[] = $startDate->toDateString();
        }

        // 🔥 GOOGLE CLIENT
        $client = $this->getClient();
        if ($client instanceof \Illuminate\Http\RedirectResponse) {
            return $client;
        }

        $service = new Google_Service_Calendar($client);

        // 🔥 DELETE OLD EVENTS
        if (!empty($order->google_event_id)) {
            $oldEvents = json_decode($order->google_event_id, true);

            if (is_array($oldEvents)) {
                foreach ($oldEvents as $eventId) {
                    try {
                        $service->events->delete('primary', $eventId);
                    } catch (\Exception $e) {
                        \Log::error("Delete Failed: " . $e->getMessage());
                    }
                }
            }
        }

        // 🔥 TIME SLOT LOGIC
        $timeSlot = DB::table('time_slots')->where('id', $item->time_slot)->value('name'); // e.g. "9:00 AM - 9:30 AM"

        $startTime = '';
        if (!empty($timeSlot)) {
            $parts = explode('-', $timeSlot);
            $startTime = trim($parts[0]); // "9:00 AM"
        }

        $hours = $item->how_many_hours_should_they_stay ?? 0;
        $hasHours = !empty($hours) && $hours > 0;

        // 🔥 BASIC DATA
        $subserviceName = Helper::subservicename((string)$item->subservice_id);
        $Userdata = Helper::get_front_user_data((string)$order->user_id);
        $salespersonName = !empty($item->salesperson_id)
            ? Helper::salesperson((string)$item->salesperson_id)
            : "";

        $origin_country = !empty($item->origin_country) ? Helper::countryname($item->origin_country) : "";
        $desti_country  = !empty($item->desti_country) ? Helper::countryname($item->desti_country) : "";

        $vendorsname  = !empty($order->vendor_id) ? Helper::vendorsname($order->vendor_id) : "";
        $crewNames = '';

        if (!empty($item->cleaner_id)) {
            $cleaner_id = explode(',', $item->cleaner_id); // [123, 23]

            $names = [];

            foreach ($cleaner_id as $cid) {
                $name = Helper::vendorsname(trim($cid)); // your helper function
                if (!empty($name)) {
                    $names[] = $name;
                }
            }

            if (!empty($names)) {
                $crewNames = implode(', ', $names);
            }
        }

        // 🔥 ADDRESS FORMATTER
        $formatAddress = function ($parts) {
            return implode(', ', array_filter($parts));
        };

        $originFull = $formatAddress([
            $item->origin_add ?? '',
            $item->origin_city ?? '',
            $item->origin_state ?? '',
            $origin_country,
            $item->origin_zip_post ?? ''
        ]);

        $destiFull = $formatAddress([
            $item->desti_add ?? '',
            $item->desti_city ?? '',
            $item->desti_state ?? '',
            $desti_country,
            $item->desti_zip_post ?? ''
        ]);

        $extraAddress = $formatAddress([
            $item->address_type ?? '',
            $item->building_street_no ?? '',
            $item->apartment_villa_no ?? '',
            $item->area ?? '',
            $item->city ?? ''
        ]);

        $LocationLink = $item->location_link ?? '';

        $vendor_payout = 0;

        // safe values (avoid null / empty errors)
        $subTotal = (float) ($order->sub_total ?? 0);
        $percentage = (float) ($item->subservice_booking_percentage ?? 0);
        $serviceCharge = (float) ($order->sub_total ?? 0);
        $vendorId = (int) ($order->vendor_id ?? 0);

        if ($vendorId > 0 && $percentage > 0) {

            $commission = ($subTotal * $percentage) / 100;

            $vendor_payout = $subTotal - $commission;
        }

        // final profit
        $profit = $serviceCharge - $vendor_payout;



        $package_orderamount_data = DB::table('package_order_amount_attr')
            ->where('order_id', $order->format_order_id)
            ->orderBy('id', 'desc')
            ->get();

        $package_orderamount_data_total = $package_orderamount_data->sum('add_amount');
        $balance = bcsub($order->order_total, $package_orderamount_data_total, 2);

        $amountHistory = '';

        if ($package_orderamount_data->count() > 0) {

            $amountHistory .= "<b>Balance Amount:</b> AED {$balance}\n\n";

            foreach ($package_orderamount_data as $package_orderamount_dataItems) {

                $amountHistory .= "Collect By : {$package_orderamount_dataItems->collect_by}\n";
                $amountHistory .= "{$package_orderamount_dataItems->date} : AED {$package_orderamount_dataItems->add_amount}\n";
                $amountHistory .= "Payment : {$package_orderamount_dataItems->payment_type}\n";
                $amountHistory .= "-------------------------\n";
            }
        }

        // 🔥 DESCRIPTION
        $description = ""
            . "<b>Job Type</b>: {$subserviceName}\n <br><br>"
            . "<b>Sales Person</b>: {$salespersonName}\n"
            . "<b>Customer Name</b>: {$Userdata->name}\n"
            . "<b>Customer Email</b>: {$Userdata->email}\n"
            . "<b>Customer Mobile</b>: {$Userdata->mobile}\n";

        if (!empty($extraAddress)) {
            $description .= "<b>Service Address:</b> {$extraAddress}\n";
        }

        if (!empty($LocationLink)) {
            $description .= "<b>Location Link:</b> {$LocationLink}\n";
        }

        if (!empty($originFull)) {
            $description .= "<br><b>Origin:</b> {$originFull}<br>";
        }

        if (!empty($destiFull)) {
            $description .= "<br><b>Destination:</b> {$destiFull}<br>";
        }
        if (!empty($crewNames)) {
            $description .= "<br><b>Crew:</b> {$crewNames}\n";
            $description .= "<b>Driver:</b> \n";
        }

        if (!empty($vendorsname)) {
            $description .= "<br><b>Vendor:</b> {$vendorsname}\n";
            $description .= "<br><b>VendorsCity:</b> {$profit}\n";
            $description .= "<b>Vendor:</b> {$vendor_payout}\n";
            $description .= "<b>VAT :</b> {$order->vatcharge}\n";
            $description .= "<b>Order Amount :</b> {$order->order_total}\n";
        }

        if (isset($order->paymentmode)) {
            if ($order->paymentmode == 1) {
                $PaymentMode = "COD";
            } else {
                $PaymentMode = "Online";
            }
            $description .= "<b>Payment Terms :</b> {$PaymentMode}\n";
        }
        $description .= "{$amountHistory}\n";

        if (isset($item->any_special_instruction)) {

            $description .= "<b>Important Notes :</b> {$item->any_special_instruction}\n";
        }




        // 🔥 CREATE EVENTS
        $eventIds = [];

        foreach ($visitDates as $date) {
            try {


                // ✅ TIME-BASED EVENT (HOME CLEANING)
                if (!empty($startTime) && $hasHours) {

                    $start = Carbon::parse($date . ' ' . $startTime, 'Asia/Kolkata');
                    $end   = $start->copy()->addHours($hours);

                    $event = new Google_Service_Calendar_Event([
                        'summary' => $vendorsname . ' - ' . $Userdata->name . ' - Order #' . $order->format_order_id,
                        'description' => $description,
                        'start' => [
                            'dateTime' => $start->toRfc3339String(),
                            'timeZone' => 'Asia/Kolkata',
                        ],
                        'end' => [
                            'dateTime' => $end->toRfc3339String(),
                            'timeZone' => 'Asia/Kolkata',
                        ],
                    ]);
                } else {
                    // ✅ FULL DAY EVENT (OTHER SERVICES)
                    $event = new Google_Service_Calendar_Event([
                        'summary' => $vendorsname . ' - ' . $Userdata->name . ' - Order #' . $order->format_order_id,
                        'description' => $description,
                        'start' => ['date' => $date],
                        'end' => [
                            'date' => date('Y-m-d', strtotime($date . ' +1 day')),
                        ],
                    ]);
                }

                $createdEvent = $service->events->insert('primary', $event);
                $eventIds[] = $createdEvent->id;
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Google Error: ' . $e->getMessage()
                ]);
            }
        }

        // 🔥 SAVE EVENT IDS
        DB::table('ci_orders')
            ->where('order_id', $id)
            ->update([
                'google_event_id' => json_encode($eventIds)
            ]);

        return response()->json([
            'status' => 1,
            'message' => 'Calendar synced successfully'
        ]);
    }
}
