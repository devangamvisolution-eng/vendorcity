<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Helper;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonPeriod;

class Calendarcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role_id == '1') {
            $orders = DB::table('ci_order_item')
                    ->join('ci_orders', 'ci_orders.order_id', '=', 'ci_order_item.order_id')
                    ->where('ci_orders.is_delete', '0')
                    ->select('ci_order_item.*', 'ci_orders.*')
                    ->get();
        }else{
             $query = DB::table('ci_order_item')
        ->join('ci_orders', 'ci_orders.order_id', '=', 'ci_order_item.order_id')
        ->where('ci_orders.is_delete', '0');
        // Filter based on user role
        if ($user->role_id == '11' || $user->role_id == '12') { // Salesperson
            $query->where('ci_order_item.salesperson_id', $user->id);
        } elseif ($user->role_id == '15') { // Driver
            $query->where('ci_order_item.driver_id', $user->id);
        } elseif ($user->role_id == '16') { // Cleaner
           $query->where(function($q) use ($user) {
               $q->whereRaw("FIND_IN_SET(?, ci_order_item.cleaner_id)", [$user->id])
                 ->orWhereExists(function ($subquery) use ($user) {
                     $subquery->select(DB::raw(1))
                              ->from('ci_order_visits')
                              ->whereColumn('ci_order_visits.order_id', 'ci_order_item.order_id')
                              ->whereRaw("FIND_IN_SET(?, ci_order_visits.cleaner_id)", [$user->id]);
                 });
           });
        } else { // Vendor
            $query->where('ci_orders.vendor_id', $user->id);
        }

        // Finalize the query with selected columns
        $orders = $query->select('ci_order_item.*', 'ci_orders.*')->get();

        }
        
        

        $events = [];
        
        foreach ($orders as $order) {

            $servicename = DB::table('services')->where('id', $order->service_id)->pluck('servicename')->first();
            $subservicename = DB::table('subservices')->where('id', $order->subservice_id)->pluck('subservicename')->first();
         

            $slotText = 'N/A';

            if (!empty($order->time_slot)) {
                $time_slot = DB::table('time_slots')
                    ->where('id', $order->time_slot)
                    ->first();
            
                if ($time_slot && isset($time_slot->name)) {
                    $slotText = $time_slot->name; // replace with your actual column name
                }
                
            }
        
            $ci_orders_data = DB::table('ci_orders')
                            ->where('order_id', $order->order_id)
                            ->first();
                            
            $user_data = DB::table('frontloginregisters')
                        ->where('id', $order->user_info_id)
                        ->first();

            $orderIdText = $ci_orders_data->format_order_id ?? 'N/A';
            $customerName = $user_data->name ?? 'N/A';
            $No_of_hours = $order->how_many_hours_should_they_stay ?? 'N/A';
            
            // Build address only with non-null parts
            $addressParts = array_filter([
                $order->apartment_villa_no,
                $order->building_street_no,
                $order->area,
                $order->city
            ]);

            $fullAddress = !empty($addressParts) ? implode(', ', $addressParts) : 'N/A';

            // if($order->location_link != '') {
            //     $mapUrl = "https://www.google.com/maps/search/?api=1&query=" . urlencode($order->location_link);
            // }else{
            //     $mapUrl = $order->location_link = 'N/A';
            // }
            $mapUrl = $order->location_link;
            // echo"<pre>";print_r($order);echo"</pre>";exit;
            $VendorName = Helper::vendorsname($ci_orders_data->vendor_id ?? 0);
            $salesPersonName = Helper::salesperson($order->salesperson_id);
            $DriverName = Helper::drivername($order->driver_id);
            $cleanerNames = [];

            if (!empty($order->cleaner_id)) {
                // Split the cleaner_id string into an array
                $cleanerIds = explode(',', $order->cleaner_id);

                foreach ($cleanerIds as $id) {
                    $cleanerNames[] = Helper::cleanername_new(trim($id));
                }
            }
            $cleanerName = !empty($cleanerNames) ? implode(', ', $cleanerNames) : 'N/A';

            $locationText = ($mapUrl == 'N/A') ? 'N/A' : "<a href=\"{$mapUrl}\" target=\"_blank\">View on Map</a>";
            
            $orderDetails = "Order ID: {$orderIdText}<br><br>"
                          . "Customer Name: {$customerName}<br>"
                          . "Customer Address: {$fullAddress}<br>"
                          . "Location: {$locationText}<br><br>"
                          . "Vendor Name: {$VendorName}<br>"
                          . "Sales Person: {$salesPersonName}<br>"
                          . "Driver Name : {$DriverName}<br>"
                          . "Crew: {$cleanerName}<br>"
                          . "No Of Hours: {$No_of_hours} hours<br>"
                          . "Time Slot: {$slotText}<br>"
                          . "Service: {$servicename}<br>"
                          . "Date: {$order->bookingdate}-{$order->month}-{$order->bookingyear}<br>"
                          . "OrderEndDate: {$order->end_date}<br>";

            $monthName = $order->month;
            $dateObj = DateTime::createFromFormat('F', $monthName);

            if (!$dateObj) {
                $dateObj = DateTime::createFromFormat('M', $monthName);
            }

            if ($dateObj) {
                $monthNumber = $dateObj->format('m');
                $eventDate = $order->bookingyear . '-' . $monthNumber . '-' . str_pad
                ($order->bookingdate, 2, '0', STR_PAD_LEFT);

                $times = explode('-', $slotText);

              if (count($times) == 2) {
                        $startTimeStr = trim($times[0]);
                        $endTimeStr = trim($times[1]);

                        // Default start datetime
                        $startDateTimeBase = $eventDate . ' ' . $startTimeStr;
                        $endDateTimeBase = $eventDate . ' ' . $endTimeStr;

                        // Determine end time for subservice_id 28
                        if ($order->subservice_id == 28) {
                            $hours = isset($order->how_many_hours_should_they_stay) ? (int) $order->how_many_hours_should_they_stay : 4;

                            $endSlotId = $order->time_slot + $hours;
                            $end_time_slot = DB::table('time_slots')->where('id', $endSlotId)->first();

                            $endslotText = isset($end_time_slot->name) ? $end_time_slot->name : null;

                            if ($endslotText) {
                                $end_times = explode('-', $endslotText);
                                $End_endTimeStr = trim($end_times[1]);
                            } else {
                                $End_endTimeStr = $endTimeStr; // fallback
                            }

                           $days = explode(',', $order->which_day_of_the_week_do_you_want_the_service); // e.g., ['Monday', 'Tuesday']
                           $days = array_map('trim', $days); // Remove extra spaces

                        } else {
                            $days = [ Carbon::parse($eventDate)->format('l') ];
                            $End_endTimeStr = $endTimeStr;
                        }

                        // If no end_date is provided, only use the single eventDate
                        $repeatUntil = $order->end_date ? Carbon::parse($order->end_date) : Carbon::parse($eventDate);

                        // Create CarbonPeriod to loop from eventDate to endDate
                        $period = CarbonPeriod::create($eventDate, $repeatUntil);

                        foreach ($period as $date) {

                            $dayName = $date->format('l');

                            if (!in_array($dayName, $days)) {
                                continue; 
                            }

                            $dateStr = $date->format('Y-m-d');

                            $startDateTime = Carbon::parse($dateStr . ' ' . $startTimeStr)->format('Y-m-d\TH:i:s');
                            $endDateTime = Carbon::parse($dateStr . ' ' . $End_endTimeStr)->format('Y-m-d\TH:i:s');

                            $visitCheck = DB::table('ci_order_visits')
                                ->where('order_id', $order->order_id)
                                ->where('visit_date', $dateStr)
                                ->first();

                            $visitStatus = $visitCheck ? $visitCheck->visit_status : 'upcoming';
                            $effectiveCleaners = ($visitCheck && !empty($visitCheck->cleaner_id)) ? $visitCheck->cleaner_id : $order->cleaner_id;

                            // If logged in as cleaner, only show if they are assigned to THIS specific visit
                            if ($user->role_id == '16') {
                                if (empty($effectiveCleaners)) {
                                    continue;
                                }
                                $cleanerIdsArray = explode(',', $effectiveCleaners);
                                $cleanerIdsArray = array_map('trim', $cleanerIdsArray);
                                if (!in_array($user->id, $cleanerIdsArray)) {
                                    continue;
                                }
                            }

                            $isCancelled = in_array($visitStatus, ['cancelled', 'skipped']);
                            $backgroundColor = $isCancelled ? '#e74c3c' : '#3498db';
                            $titlePrefix = $isCancelled ? 'Cancelled: ' : '';

                            // Resolve cleaner names for this visit
                            $visitCleanerNames = [];
                            if (!empty($effectiveCleaners)) {
                                $effCleanerIds = explode(',', $effectiveCleaners);
                                foreach ($effCleanerIds as $id) {
                                    if(trim($id)) {
                                        $visitCleanerNames[] = Helper::cleanername_new(trim($id));
                                    }
                                }
                            }
                            $visitCleanerNameStr = !empty($visitCleanerNames) ? implode(', ', $visitCleanerNames) : 'N/A';

                            $locationText = ($mapUrl == 'N/A') ? 'N/A' : "<a href=\"{$mapUrl}\" target=\"_blank\">View on Map</a>";
                            $visitOrderDetails = "Order ID: {$orderIdText}<br><br>"
                                          . "Customer Name: {$customerName}<br>"
                                          . "Customer Address: {$fullAddress}<br>"
                                          . "Location: {$locationText}<br><br>"
                                          . "Vendor Name: {$VendorName}<br>"
                                          . "Sales Person: {$salesPersonName}<br>"
                                          . "Driver Name : {$DriverName}<br>"
                                          . "Crew: {$visitCleanerNameStr}<br>"
                                          . "No Of Hours: {$No_of_hours} hours<br>"
                                          . "Time Slot: {$slotText}<br>"
                                          . "Service: {$servicename}<br>"
                                          . "Date: {$order->bookingdate}-{$order->month}-{$order->bookingyear}<br>"
                                          . "OrderEndDate: {$order->end_date}<br>";

                            $events[] = [
                                'title' => $titlePrefix . $subservicename . ' - ' . $orderIdText,
                                'start' => Carbon::parse($startDateTime, 'Asia/Dubai')->format('Y-m-d\TH:i:s'),
                                'end' => Carbon::parse($endDateTime, 'Asia/Dubai')->format('Y-m-d\TH:i:s'),
                                'backgroundColor' => $backgroundColor,
                                'extendedProps' => [
                                    'details' => $visitOrderDetails,
                                ],
                            ];
                        }
                    }
                } else {
                    // Log or handle invalid month format
                    \Log::warning("Invalid month name: " . $monthName);
                }
                }
				
				//echo "<pre>";print_r($events);echo"</pre>";exit;
                
                return view('admin.calendar', ['events' => $events]);
        
    }

  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
