@extends('admin.includes.Template')
<style>
    .custom-card {
        border: 1px solid rgba(0, 0, 0, .125) !important;
        border-radius: 12px !important;
    }

    .booking_detail h5 {
        color: #000000de;
        font-size: 22px;
        font-style: normal;
        font-weight: 700;
        letter-spacing: 0;
        line-height: 32px;
    }

    .booking_detail ul li {
        align-items: center !important;
        justify-content: space-between !important;
        display: flex;
        margin-bottom: 0.75rem;
    }

    .booking_detail ul li strong {
        font-size: 16px;
        letter-spacing: .1px;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        color: #00000061 !important;
    }

    .booking_detail .status-completed {
        font-size: 16px;
        letter-spacing: .1px;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        color: #49a361 !important;
    }

    .booking_detail .right {
        font-size: 16px;
        letter-spacing: .1px;
        color: #000000de;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        display: flex;
        align-items: center;
        gap: 2px;
    }

    .currency_dhiram {
        display: inline-block;
        width: 16px;
        height: 16px;

        background-color: currentColor;

        -webkit-mask: url('{{ asset('public/site/icons/dirham.svg') }}') no-repeat center;
        mask: url('{{ asset('public/site/icons/dirham.svg') }}') no-repeat center;

        -webkit-mask-size: contain;
        mask-size: contain;
    }
</style>
@section('content')



    <!-- Page Wrapper -->

    @php
        // echo "<pre>";print_r($order);exit;
    @endphp

    <div class="content container-fluid">

        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card custom-card booking_detail">
                    <div class="card-body">
                        <h5 class="mb-3">Customer Details</h5>

                        <ul class="list-unstyled mb-3">

                            <li><strong>Full Name:</strong> <span class="right">{{ $order->user_name }}</span></li>
                            @if (isset($order->user_mobile) && isset($order->user_country_code))
                                <li><strong>Phone:</strong> <span
                                        class="right">+{{ $order->user_country_code }}{{ $order->user_mobile }}</span></li>
                            @endif
                            <li><strong>Country:</strong> <span class="right">United Arab Emirates</span></li>
                            @if (isset($order->items[0]->city))
                                <li><strong>Region:</strong> <span class="right">{{ $order->items[0]->city }}</span></li>
                            @endif
                            @if (isset($order->items[0]->area))
                                <li><strong>Area:</strong> <span class="right">{{ $order->items[0]->area }}</span></li>
                            @endif
                            @if (isset($order->items[0]->building_street_no))
                                <li><strong>Building/Street:</strong> <span
                                        class="right">{{ $order->items[0]->building_street_no }}</span></li>
                            @endif
                            @if (isset($order->items[0]->apartment_villa_no))
                                <li><strong>Apartment/Villa No:</strong> <span
                                        class="right">{{ $order->items[0]->apartment_villa_no }}</span></li>
                            @endif
                            @if (isset($order->items[0]->location_link))
                                <li><strong>Location:</strong> <span class="right"><a
                                            href="{{ $order->items[0]->location_link }}" target="_BLANK">click here to see
                                            location</a></span></li>
                            @endif
                        </ul>
                    </div>
                </div>
                @php
                    if ($order->order_status == 'P') {
                        if ($order->items[0]->service_id == 50) {
                            $statusText = 'Awaiting Confirmation';
                        } else {
                            $statusText = 'Booking Confirmed';
                        }
                        $statusColor = '';
                    } elseif ($order->order_status == 'PA') {
                        $statusText = 'Vendor Assigned';
                        $statusColor = '';
                    } elseif ($order->order_status == 'CO') {
                        $statusText = 'Booking Completed';
                        $statusColor = '';
                    } elseif ($order->order_status == 'CL') {
                        $statusText = 'Booking Cancelled';
                        $statusColor = 'red';
                    } elseif ($order->order_status == 'BK') {
                        $statusText = 'Booking Requested';
                        $statusColor = '';
                    } else {
                        $statusColor = '';
                        $statusText = 'Unknown';
                    }
                @endphp
                <div class="card custom-card booking_detail">
                    <div class="card-body">
                        <h5 class="mb-3">Booking Details</h5>

                        <ul class="list-unstyled mb-3">
                            <li><strong>Status:</strong> <span class="status-completed"
                                    style="color: {{ $statusColor }} !important;">{{ $statusText }}</span></li>
                            <li><strong>Reference Code:</strong> <span class="right">{{ $order->format_order_id }}</span>
                            </li>
                            @if (isset($order->items[0]->any_special_instruction))
                                <li><strong>Notes:</strong> <span
                                        class="right">{{ $order->items[0]->any_special_instruction }}</span></li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="card custom-card booking_detail">
                    <div class="card-body">
                        <h5 class="mb-3">Service Details</h5>

                        <ul class="list-unstyled mb-3">
                            @foreach ($order->items as $item)
                                @php
                                    /*echo "<pre>";print_r($item);echo "</pre>"; */

                                    if ($item->how_often_do_you_need_cleaning != '') {
                                        $order_item_package_data = [];
                                    } else {
                                        $order_item_package_data = DB::table('ci_order_item_packages')
                                            ->where('order_id', $item->order_id)
                                            ->where('order_item_id', $item->id)
                                            ->get()
                                            ->toArray();

                                        // echo"<pre>";print_r($item);echo"</pre>";exit;
                                    }
                                    $order_item_addonspackage_data = DB::table('ci_order_item_addons')
                                        ->where('order_id', $item->order_id)
                                        ->where('order_item_id', $item->id)
                                        ->get()
                                        ->toArray();
                                @endphp
                                <li><strong>Service Type:</strong> <span class="right">{!! Helper::subservicename(strval($item->subservice_id)) !!}</span></li>

                                @if (isset($item->cleaner_id))
                                    @php
                                        $cleaner_Id = explode(',', $item->cleaner_id);
                                    @endphp

                                    <li><strong>Cleaner Name:</strong> <span class="right">{!! Helper::cleanername_new($cleaner_Id) !!}</span>
                                    </li>
                                @endif

                                @if (!empty($order_item_package_data))
                                    <li><strong>Services:</strong>
                                        <span class="right">
                                            @foreach ($order_item_package_data as $package_data)
                                                {!! $package_data->package_item_name !!} * {!! $package_data->package_quantity !!}<br>
                                            @endforeach
                                        </span>
                                    </li>
                                @endif
                                @if (!empty($order_item_addonspackage_data))
                                    <li><strong>Addons Services:</strong>
                                        <span class="right">
                                            @foreach ($order_item_addonspackage_data as $package_data)
                                                {!! $package_data->package_item_name !!} * {!! $package_data->package_quantity !!}<br>
                                            @endforeach
                                        </span>
                                    </li>
                                @endif


                                @if (isset($item->how_many_cleaners_do_you_need))
                                    <li><strong>No. of Cleaners:</strong> <span
                                            class="right">{{ $item->how_many_cleaners_do_you_need }}</span></li>
                                @endif

                                @if (isset($item->how_many_hours_should_they_stay))
                                    <li><strong>No. of Hours:</strong> <span
                                            class="right">{{ $item->how_many_hours_should_they_stay }}</span></li>
                                @endif

                                @if (isset($item->how_often_do_you_need_cleaning))
                                    <li><strong>Frequency:</strong> <span
                                            class="right">{{ $item->how_often_do_you_need_cleaning }}</span></li>
                                @endif

                                @if (isset($item->which_day_of_the_week_do_you_want_the_service) &&
                                        $item->which_day_of_the_week_do_you_want_the_service != '')
                                    <li><strong>Days of the week:</strong> <span
                                            class="right">{{ $item->which_day_of_the_week_do_you_want_the_service }}</span>
                                    </li>
                                @endif

                                @if (isset($item->do_you_need_cleaning_material))
                                    <li><strong>Materials:</strong> <span
                                            class="right">{{ $item->do_you_need_cleaning_material }}</span></li>
                                @endif



                                @if ($item->subservice_id == '47')
                                    <li><strong>Service:</strong> <span class="right">{{ $item->type_of_painting }}</span>
                                    </li>

                                    <li><strong>Size of home:</strong> <span
                                            class="right">{{ $item->selected_type_home . ' - ' . $item->selected_size_home }}</span>
                                    </li>

                                    <li><strong>Home Furnished:</strong> <span
                                            class="right">{{ $item->is_home_furnished }}</span></li>
                                    <li><strong>Colors:</strong> <span
                                            class="right">{{ $item->your_walls_now_color . ' to ' . $item->you_want_paint_color }}</span>
                                    </li>
                                    <li><strong>Ceilings:</strong> <span
                                            class="right">{{ $item->no_of_ceilings ?: '-' }}</span></li>
                                @endif

                                @if ($item->subservice_id == '92')
                                    <li><strong>Inspection Location:</strong> <span
                                            class="right">{{ $item->verifybuy_location ?: '-' }}</span></li>

                                    <li><strong>Address:</strong> <span
                                            class="right">{{ $item->verifybuy_address ?: '-' }}</span></li>

                                    @if ($item->verifybuy_additional_details != '')
                                        <li><strong>Additional Location Details:</strong> <span
                                                class="right">{{ $item->verifybuy_additional_details ?: '-' }}</span>
                                        </li>
                                    @endif

                                    <li><strong>Where is Car Parked?:</strong> <span
                                            class="right">{{ $item->verifybuy_where_is_car_parked ?: '-' }}</span></li>


                                    <li><strong>Vehicle Details:</strong> <span
                                            class="right">{!! Helper::vehiclename($item->verifybuy_vehicle) !!}</span></li>

                                    <li><strong>Vehicle Model:</strong> <span
                                            class="right">{{ $item->verifybuy_model ?: '-' }}</span></li>

                                    <li><strong>Vehicle Category:</strong> <span
                                            class="right">{{ $item->verifybuy_category ?: '-' }}</span></li>
                                @endif

                                <li><strong>Date & Time:</strong> <span class="right">{{ $item->bookingdate }}
                                        {{ $item->month }} {{ $item->bookingyear }}, {!! Helper::timeslotname($item->time_slot) !!}</span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card custom-card booking_detail">
                    <div class="card-body">
                        <h5 class="mb-3">Payment Details</h5>

                        <ul class="list-unstyled mb-3">
                            <li><strong>Payment Method:</strong> <span class="right">
                                    @if ($order->paymentmode == 1)
                                        COD
                                    @else
                                        Online
                                    @endif
                                </span></li>

                            @if (isset($order->service_charge) && $order->service_charge > 0)
                                <li><strong>Service Charge:</strong> <span class="right"><span
                                            class="currency_dhiram"></span>
                                        {{ number_format($order->service_charge, 2) }}</span></li>
                            @endif

                            @if (isset($order->timing_charge) && $order->timing_charge > 0)
                                <li><strong>Timing Fee:</strong> <span class="right"><span class="currency_dhiram"></span>
                                        {{ number_format($order->timing_charge, 2) }}</span></li>
                            @endif

                            @if (isset($order_item_addonspackage_data) && count($order_item_addonspackage_data) > 0)
                                @php
                                    $addOnstotal = 0;
                                    foreach ($order_item_addonspackage_data as $addonsData) {
                                        $addOnstotal += $addonsData->package_quantity * $addonsData->package_item_price;
                                    }
                                @endphp
                                <li><strong>Addons Charge :</strong> <span class="right"><span
                                            class="currency_dhiram"></span> {{ $addOnstotal }}</span></li>
                            @endif



                            @if (isset($order->cod_charge) && $order->cod_charge > 0)
                                <li><strong>COD Charge:</strong> <span class="right"><span class="currency_dhiram"></span>
                                        {{ number_format($order->cod_charge, 2) }}</span></li>
                            @endif

                            @if (isset($order->additional_charge) && $order->additional_charge > 0)
                                <li><strong>Material Charges:</strong> <span class="right"><span
                                            class="currency_dhiram"></span>
                                        {{ number_format($order->additional_charge, 2) }}</span></li>
                            @endif

                            @if (isset($order->service_fee) && $order->service_fee > 0)
                                <li><strong>Service Fee:</strong> <span class="right"><span class="currency_dhiram"></span>
                                        {{ number_format($order->service_fee, 2) }}</span></li>
                            @endif

                            @php
                                $sub_total_new =
                                    (float) $order->service_charge +
                                    (float) $order->promo_discount +
                                    (float) $order->additional_charge +
                                    (float) $order->timing_charge +
                                    (float) $order->service_fee +
                                    (float) $order->cod_charge;
                            @endphp

                            @if (isset($sub_total_new) && $sub_total_new > 0)
                                <li><strong>Subtotal:</strong> <span class="right"><span class="currency_dhiram"></span>
                                        {{ number_format($sub_total_new, 2) }}</span></li>
                            @endif

                            @if (isset($order->vatcharge) && $order->vatcharge > 0)
                                <li><strong>VAT Charge:</strong> <span class="right"><span class="currency_dhiram"></span>
                                        {{ number_format($order->vatcharge, 2) }}</span></li>
                            @endif

                            @if (isset($order->promo_discount) && $order->promo_discount > 0)
                                <li><strong>Promo Discount :</strong> <span class="right">- <span
                                            class="currency_dhiram"></span>
                                        {{ number_format($order->promo_discount, 2) }}</span></li>
                            @endif
                            @if (isset($order->front_wallet_amount) && $order->front_wallet_amount > 0)
                                <li><strong>Wallet Discount :</strong> <span class="right">- <span
                                            class="currency_dhiram"></span>
                                        {{ number_format($order->front_wallet_amount, 2) }}</span></li>
                            @endif

                            @if (isset($order->order_total) && $order->order_total > 0)
                                <li><strong>Total (Inc. VAT):</strong> <span class="right"><span
                                            class="currency_dhiram"></span>
                                        {{ number_format(round($order->order_total), 2) }}</span></li>
                            @endif
                        </ul>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- /Page Wrapper -->


@stop
