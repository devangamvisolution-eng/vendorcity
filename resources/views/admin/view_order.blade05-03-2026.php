@extends('admin.includes.Template')
<style>
    /* Gradient Header Background */
    .detail-header-bg {
        background: linear-gradient(135deg, #605bff 0%, #3f39cc 100%);
        padding: 40px 20px 100px;
        margin: -25px -25px 0 -25px;
        border-radius: 0 0 30px 30px;
    }

    .main-content-wrapper {
        margin-top: -70px;
        /* Pull content up into the gradient */
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    /* Timeline Styling for Service */
    .service-timeline {
        position: relative;
        padding-left: 30px;
    }

    .service-timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 5px;
        height: 100%;
        width: 2px;
        background: #e2e8f0;
    }

    .timeline-dot {
        position: absolute;
        left: 0;
        top: 5px;
        width: 22px;
        height: 22px;
        background: #fff;
        border: 4px solid #605bff;
        border-radius: 50%;
    }

    /* Pricing Table */
    .price-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed #eee;
    }

    .price-row.total {
        border-bottom: none;
        background: #605bff;
        color: white;
        border-radius: 12px;
        padding: 15px;
        margin-top: 15px;
    }

    .label-caps {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: #94a3b8;
        letter-spacing: 1px;
    }

    .currency_dhiram {
        display: inline-block;
        width: 16px;
        height: 16px;

        background-color: currentColor;

        -webkit-mask: url('https://vendorcity.b-cdn.net/public/site/icons/dirham.svg') no-repeat center;
        mask: url('https://vendorcity.b-cdn.net/public/site/icons/dirham.svg') no-repeat center;

        -webkit-mask-size: contain;
        mask-size: contain;
    }
</style>
@php
    if ($order->order_status == 'P') {
        if ($order->items[0]->service_id == 50) {
            $statusText = 'Awaiting Confirmation';
        } else {
            $statusText = 'Booking Confirmed';
        }
        $statusColor = 'bg-success-light text-success';
    } elseif ($order->order_status == 'PA') {
        $statusText = 'Vendor Assigned';
        $statusColor = 'bg-success-light text-success';
    } elseif ($order->order_status == 'CO') {
        $statusText = 'Booking Completed';
        $statusColor = 'bg-success-light text-success';
    } elseif ($order->order_status == 'CL') {
        $statusText = 'Booking Cancelled';
        $statusColor = 'bg-danger-light text-danger';
    } elseif ($order->order_status == 'BK') {
        $statusText = 'Booking Requested';
        $statusColor = 'bg-success-light text-success';
    } else {
        $statusColor = 'bg-success-light text-success';
        $statusText = 'Unknown';
    }
@endphp
@section('content')
    <div class="content container-fluid">
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Booking Details</h3>
                    <ul class="breadcrumb" style="background:none; padding:0;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">#{{ $order->format_order_id }}</li>
                    </ul>
                </div>
                {{-- <div class="col-auto">
                    <span class="badge {{ $statusColor }} me-2 p-2">
                        <i class="fas fa-user-check me-1"></i> {{ $statusText }}
                    </span>
                    <button class="btn btn-white btn-sm border"><i class="fas fa-print"></i></button>
                </div> --}}
            </div>
        </div>

        @php
            $sub_total_new =
                (float) $order->service_charge +
                (float) $order->promo_discount +
                (float) $order->additional_charge +
                (float) $order->timing_charge +
                (float) $order->service_fee +
                (float) $order->cod_charge;
        @endphp

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge {{ $statusColor }} mb-2"
                                    style="font-size: 0.85rem; padding: 0.5em 1em;">
                                    {{ $statusText }}
                                </span>
                                <h4 class="fw-bold mb-1">Order {{ $order->format_order_id }}</h4>
                                {{-- <p class="text-muted mb-0">Placed on 20 Feb 2026 </p> --}}
                            </div>
                            <div class="text-end">
                                <p class="text-muted mb-1 small text-uppercase fw-bold">Total Amount</p>
                                <h3 class="text-primary fw-bold"><span class="currency_dhiram"></span>
                                    {{ number_format(round($order->order_total), 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-transparent border-bottom">
                        <h5 class="card-title mb-0"><i class="fas fa-user-circle me-2 text-primary"></i> Customer Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <p class="text-muted mb-1 small uppercase">Full Name</p>
                                <h6 class="fw-bold">{{ $order->user_name }}</h6>
                            </div>
                            @if (isset($order->user_mobile) || isset($order->user_country_code))
                                <div class="col-md-4">
                                    <p class="text-muted mb-1 small">Phone</p>
                                    <h6 class="fw-bold">
                                        @if ($order?->user_country_code)
                                            {{ '+' . $order?->user_country_code ?? '' }}
                                        @endif
                                        {{ $order->user_mobile }}
                                    </h6>
                                </div>
                            @endif

                            <div class="col-md-4">
                                <p class="text-muted mb-1 small">Country</p>
                                <h6 class="fw-bold">United Arab Emirates</h6>
                            </div>
                            @if (isset($order->items[0]->city))
                                <div class="col-md-4">
                                    <p class="text-muted mb-1 small">Region</p>
                                    <h6 class="fw-bold">{{ $order->items[0]->city }}</h6>
                                </div>
                            @endif
                            @if (isset($order->items[0]->area))
                                <div class="col-md-4">
                                    <p class="text-muted mb-1 small">Area</p>
                                    <h6 class="fw-bold">{{ $order->items[0]->area }}</h6>
                                </div>
                            @endif
                            @if (isset($order->items[0]->building_street_no))
                                <div class="col-md-4">
                                    <p class="text-muted mb-1 small">Building/Street</p>
                                    <h6 class="fw-bold">{{ $order->items[0]->building_street_no }}</h6>
                                </div>
                            @endif
                            @if (isset($order->items[0]->apartment_villa_no))
                                <div class="col-md-4">
                                    <p class="text-muted mb-1 small">Apartment/Villa No</p>
                                    <h6 class="fw-bold">{{ $order->items[0]->apartment_villa_no }}</h6>
                                </div>
                            @endif
                            @if (isset($order->items[0]->location_link))
                                <div class="col-12 mt-2">
                                    <a href="{{ $order->items[0]->location_link }}" target="_blank"
                                        class="text-decoration-none fw-semibold text-primary d-inline-flex align-items-center">
                                        <i class="fas fa-map-marker-alt me-2" style="color:#EA4335; font-size:18px;"></i>
                                        View Location on Map
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-transparent border-bottom">
                        <h5 class="card-title mb-0"><i class="fas fa-broom me-2 text-primary"></i> Service Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            @php
                                $total_package_price = 0;
                            @endphp
                            @foreach ($order->items as $item)
                                @php
                                    if ($item->how_often_do_you_need_cleaning != '') {
                                        $order_item_package_data = collect();
                                    } else {
                                        $order_item_package_data = DB::table('ci_order_item_packages')
                                            ->where('order_id', $item->order_id)
                                            ->where('order_item_id', $item->id)
                                            ->get();

                                        if ($order_item_package_data->isEmpty()) {
                                            $order_item_package_data = DB::table('ci_order_item')
                                                ->where('order_id', $item->order_id)
                                                ->where('id', $item->id)
                                                ->get();
                                        }
                                    }

                                    $order_item_addonspackage_data = DB::table('ci_order_item_addons')
                                        ->where('order_id', $item->order_id)
                                        ->where('order_item_id', $item->id)
                                        ->get()
                                        ->toArray();

                                    // ✅ add total price
                                    $total_package_price += $order_item_package_data->sum('package_item_price');
                                @endphp

                                <div class="col-md-6 col-xl-4">
                                    <div class="d-flex align-items-center">
                                        {{-- <div class="avatar avatar-sm bg-light-primary text-primary rounded me-3 d-flex align-items-center justify-content-center"
                                        style="width:40px; height:40px;">
                                        <i class="fas fa-home"></i>
                                    </div> --}}
                                        <div>
                                            <p class="text-muted mb-0 small">Service Type</p>
                                            <span class="fw-bold">{!! Helper::subservicename(strval($item->subservice_id)) !!}</span>
                                        </div>
                                    </div>
                                </div>
                                @if (isset($item->cleaner_id))
                                    @php
                                        $cleaner_Id = explode(',', $item->cleaner_id);
                                    @endphp
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Cleaner Name</p>
                                        <span class="fw-bold text-dark">{!! Helper::cleanername_new($cleaner_Id) !!}</span>
                                    </div>
                                @endif

                                @if (!empty($order_item_package_data))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Services</p>
                                        @foreach ($order_item_package_data as $package_data)
                                            <span class="fw-bold text-dark">{!! $package_data->package_item_name !!} *
                                                {!! $package_data->package_quantity !!}</span>
                                        @endforeach
                                    </div>
                                @endif

                                @if (!empty($order_item_addonspackage_data))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Addons Services</p>
                                        @foreach ($order_item_addonspackage_data as $package_data)
                                            <span class="fw-bold text-dark">{!! $package_data->package_item_name !!} *
                                                {!! $package_data->package_quantity !!}</span>
                                        @endforeach
                                    </div>
                                @endif
                                @if (isset($item->how_many_cleaners_do_you_need))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">No. of Cleaners</p>
                                        <span class="fw-bold text-dark">{{ $item->how_many_cleaners_do_you_need }}</span>
                                    </div>
                                @endif
                                @if (isset($item->how_many_hours_should_they_stay))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">No. of Hours</p>
                                        <span class="fw-bold text-dark">{{ $item->how_many_hours_should_they_stay }}</span>
                                    </div>
                                @endif
                                @if (isset($item->how_often_do_you_need_cleaning))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Frequency</p>
                                        <span class="fw-bold text-dark">{{ $item->how_often_do_you_need_cleaning }}</span>
                                    </div>
                                @endif
                                @if (isset($item->which_day_of_the_week_do_you_want_the_service) &&
                                        $item->which_day_of_the_week_do_you_want_the_service != '')
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Days of the week</p>
                                        <span
                                            class="fw-bold text-dark">{{ $item->which_day_of_the_week_do_you_want_the_service }}</span>
                                    </div>
                                @endif
                                @if (isset($item->do_you_need_cleaning_material))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Materials Provided</p>
                                        <span class="fw-bold text-dark">{{ $item->do_you_need_cleaning_material }}</span>
                                    </div>
                                @endif
                                @if ($item->subservice_id == '47')
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Service</p>
                                        <span class="fw-bold text-dark">{{ $item->type_of_painting }}</span>
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Size of home</p>
                                        <span
                                            class="fw-bold text-dark">{{ $item->selected_type_home . ' - ' . $item->selected_size_home }}</span>
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Home Furnished</p>
                                        <span class="fw-bold text-dark">{{ $item->is_home_furnished }}</span>
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Colors</p>
                                        <span
                                            class="fw-bold text-dark">{{ $item->your_walls_now_color . ' to ' . $item->you_want_paint_color }}</span>
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Ceilings</p>
                                        <span class="fw-bold text-dark">{{ $item->no_of_ceilings ?: '-' }}</span>
                                    </div>
                                @endif
                                @if ($item->subservice_id == '92')
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Inspection Location</p>
                                        <span class="fw-bold text-dark">{{ $item->verifybuy_location ?: '-' }}</span>
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Address</p>
                                        <span class="fw-bold text-dark">{{ $item->verifybuy_address ?: '-' }}</span>
                                    </div>
                                    @if ($item->verifybuy_additional_details != '')
                                        <div class="col-md-6 col-xl-4">
                                            <p class="text-muted mb-0 small">Additional Location Details</p>
                                            <span
                                                class="fw-bold text-dark">{{ $item->verifybuy_additional_details ?: '-' }}</span>
                                        </div>
                                    @endif
                                    @if ($item->verifybuy_where_is_car_parked != '')
                                        <div class="col-md-6 col-xl-4">
                                            <p class="text-muted mb-0 small">Where is Car Parked?</p>
                                            <span
                                                class="fw-bold text-dark">{{ $item->verifybuy_where_is_car_parked ?: '-' }}</span>
                                        </div>
                                    @endif
                                    @if ($item->verifybuy_vehicle != '')
                                        <div class="col-md-6 col-xl-4">
                                            <p class="text-muted mb-0 small">Vehicle Details</p>
                                            <span class="fw-bold text-dark">{!! Helper::vehiclename($item->verifybuy_vehicle) !!}</span>
                                        </div>
                                    @endif
                                    @if ($item->verifybuy_model != '')
                                        <div class="col-md-6 col-xl-4">
                                            <p class="text-muted mb-0 small">Vehicle Model</p>
                                            <span class="fw-bold text-dark">{{ $item->verifybuy_model ?: '-' }}</span>
                                        </div>
                                    @endif
                                    @if ($item->verifybuy_category != '')
                                        <div class="col-md-6 col-xl-4">
                                            <p class="text-muted mb-0 small">Vehicle Category</p>
                                            <span class="fw-bold text-dark">{{ $item->verifybuy_category ?: '-' }}</span>
                                        </div>
                                    @endif
                                @endif
                                <div class="col-md-6 col-xl-4">
                                    <p class="text-muted mb-0 small">Booking Schedule</p>
                                    <span class="fw-bold text-primary"> {{ $item->bookingdate }}
                                        {{ $item->month }} {{ $item->bookingyear }}</span><br>
                                    <small class="text-muted">{!! Helper::timeslotname($item->time_slot) !!}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                @php
                    $statusFlow = [
                        'BK' => 'Booking Requested',
                        'P' => 'Booking Confirmed',
                        'PA' => 'Vendor Assigned',
                        'CO' => 'Booking Completed',
                        'CL' => 'Booking Cancelled',
                    ];

                    $currentStatus = $order->order_status;
                    $statusKeys = array_keys($statusFlow);
                    $currentIndex = array_search($currentStatus, $statusKeys);

                    // Statuses to show in normal flow (exclude Cancelled from normal flow)
                    $normalFlow = array_filter($statusFlow, fn($key) => $key !== 'CL', ARRAY_FILTER_USE_KEY);
                @endphp

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-stream me-2 text-primary"></i>Order Activity
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="vertical-timeline ps-3 mt-2">

                            @if ($currentStatus == 'CL')
                                <!-- Cancelled Special Case -->
                                <div class="timeline-item ps-4 position-relative">
                                    <span
                                        class="position-absolute start-0 top-0 translate-middle badge rounded-circle bg-danger p-2"
                                        style="margin-left:-1.5px;">
                                        <i class="fas fa-times"></i>
                                    </span>
                                    <h6 class="fw-bold text-danger">Booking Cancelled</h6>
                                    <p class="text-muted small mb-0">Order was cancelled.</p>
                                </div>
                            @else
                                @foreach ($normalFlow as $key => $label)
                                    @php
                                        $index = array_search($key, $statusKeys);
                                        $isCompleted = $index < $currentIndex;
                                        $isCurrent = $index === $currentIndex;

                                        if ($currentStatus === 'CO') {
                                            $isCompleted = true;
                                            $isCurrent = false;
                                        }

                                        $isLast = $key === array_key_last($normalFlow);
                                    @endphp

                                    <div
                                        class="timeline-item pb-4 {{ $isLast ? '' : 'border-start' }} ps-4 position-relative">
                                        <span
                                            class="position-absolute start-0 top-0 translate-middle badge rounded-circle p-2
                            {{ $isCompleted ? 'bg-success' : ($isCurrent ? 'bg-primary' : 'bg-light text-muted') }}"
                                            style="margin-left:-1.5px;">

                                            @if ($isCompleted)
                                                <i class="fas fa-check text-white"></i>
                                            @elseif ($isCurrent)
                                                <i class="fas fa-clock text-white"></i>
                                            @else
                                                <i class="fas fa-circle text-muted"></i>
                                            @endif
                                        </span>

                                        <h6 class="fw-bold mb-1 {{ $isCurrent ? 'text-primary' : '' }}">
                                            {{ $label }}
                                        </h6>
                                        <p class="text-muted small mb-0">
                                            {{ $isCompleted ? 'Completed' : ($isCurrent ? 'Current Status' : 'Pending') }}
                                        </p>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 bg-light-blue">
                    <div class="card-header bg-transparent border-bottom">
                        <h5 class="card-title mb-0">Payment Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <div class="d-flex flex-column">
                                <span class="text-muted">Payment Method</span>
                                @if ($order->payment_id)
                                    <span class="mt-1 small text-primary fw-normal">Payment ID:</span>
                                @endif
                            </div>

                            <div class="text-end d-flex flex-column">
                                <div class="fw-bold">
                                    @if ($order->paymentmode == 1)
                                        COD
                                    @else
                                        Online
                                    @endif
                                </div>

                                <div class="mt-1">
                                    {!! $order->payment_status_label !!}
                                </div>

                                @if ($order->payment_id)
                                    <div class="mt-1 small text-muted">
                                        {{ $order->payment_id ? 'Payment ID: ' . $order->payment_id : '' }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr>
                        @if (isset($order->service_charge) && $order->service_charge > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Service Charge</span>
                                <span><span class="currency_dhiram"></span>
                                    {{ number_format($order->service_charge, 2) }}</span>
                            </div>
                        @endif
                        @if (isset($order->timing_charge) && $order->timing_charge > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Timing Fee</span>
                                <span><span class="currency_dhiram"></span>
                                    {{ number_format($order->timing_charge, 2) }}</span>
                            </div>
                        @endif
                        @if (isset($order_item_addonspackage_data) && count($order_item_addonspackage_data) > 0)
                            @php
                                $addOnstotal = 0;
                                foreach ($order_item_addonspackage_data as $addonsData) {
                                    $addOnstotal += $addonsData->package_quantity * $addonsData->package_item_price;
                                }
                            @endphp
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Addons Charge</span>
                                <span><span class="currency_dhiram"></span>
                                    {{ number_format($addOnstotal, 2) }}</span>
                            </div>
                        @endif
                        @if (isset($order->cod_charge) && $order->cod_charge > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">COD Charge</span>
                                <span><span class="currency_dhiram"></span>
                                    {{ number_format($order->cod_charge, 2) }}</span>
                            </div>
                        @endif
                        @if (isset($order->additional_charge) && $order->additional_charge > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Material Charge</span>
                                <span><span class="currency_dhiram"></span>
                                    {{ number_format($order->additional_charge, 2) }}</span>
                            </div>
                        @endif
                        @if (isset($order->service_fee) && $order->service_fee > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Service Fee</span>
                                <span><span class="currency_dhiram"></span>
                                    {{ number_format($order->service_fee, 2) }}</span>
                            </div>
                        @endif

                        @if ((isset($sub_total_new) && $sub_total_new > 0) || (isset($total_package_price) && $total_package_price > 0))
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span><span class="currency_dhiram"></span>
                                    @if ($sub_total_new > 0)
                                        {{ number_format($sub_total_new, 2) }}
                                    @else
                                        {{ number_format($total_package_price, 2) }}
                                    @endif
                                </span>
                            </div>
                        @endif
                        @if (isset($order->vatcharge) && $order->vatcharge > 0)
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">VAT Charge</span>
                                <span><span class="currency_dhiram"></span>
                                    {{ number_format($order->vatcharge, 2) }}</span>
                            </div>
                        @endif
                        @if (isset($order->promo_discount) && $order->promo_discount > 0)
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Promo Discount</span>
                                <span><span class="currency_dhiram"></span>
                                    {{ number_format($order->promo_discount, 2) }}</span>
                            </div>
                        @endif
                        @if (isset($order->front_wallet_amount) && $order->front_wallet_amount > 0)
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Wallet Discount</span>
                                <span><span class="currency_dhiram"></span>
                                    {{ number_format($order->front_wallet_amount, 2) }}</span>
                            </div>
                        @endif
                        @if (isset($order->order_total) && $order->order_total > 0)
                            <div class="d-flex justify-content-between border-top pt-3 mt-3">
                                <h5 class="fw-bold">Total (Inc. VAT)</h5>
                                <h5 class="fw-bold text-primary"><span class="currency_dhiram"></span>
                                    {{ number_format(round($order->order_total), 2) }}</h5>
                            </div>
                        @endif
                    </div>
                    {{-- <div class="card-footer bg-white border-0">
                        <button class="btn btn-primary w-100 py-2">Generate Invoice</button>
                    </div> --}}
                </div>
                <div class="card shadow-sm border-0 mb-4 border-start border-4 border-success">

                    <!-- Card Header -->
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-semibold text-dark">
                            <i class="fas fa-shuttle-van me-2 text-success"></i>
                            Assigned Vendor
                        </h5>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        @php
                            $vendor = Helper::vendorInfo($order->vendor_id);
                        @endphp

                        @if ($vendor)
                            <div class="d-flex align-items-center justify-content-between flex-wrap">

                                <!-- Left Section -->
                                <div class="d-flex align-items-center">

                                    <!-- Avatar -->
                                    {{-- <div class="rounded-circle bg-success bg-opacity-10 text-success 
                                    d-flex align-items-center justify-content-center me-3"
                                        style="width:60px; height:60px;">
                                        <i class="fas fa-building fa-lg"></i>
                                    </div> --}}

                                    <!-- Vendor Info -->
                                    <div>
                                        <h6 class="fw-bold mb-1">
                                            {{ ucfirst(Helper::vendorsname($order->vendor_id)) }}
                                        </h6>

                                        <div class="small text-muted">
                                            <div>Vendor ID: #{{ $vendor->id }}</div>
                                            <div>Email: {{ $vendor->email ?? 'N/A' }}</div>
                                            <div>Phone: {{ '+' . $vendor->country_code . ' ' . $vendor->mobile ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Right Section -->
                                <div class="mt-3 mt-md-0 text-md-end d-none">
                                    <span class="badge bg-success-subtle text-success px-3 py-2">
                                        Assigned
                                    </span>
                                </div>

                            </div>
                        @else
                            <!-- No Vendor Assigned -->
                            <div class="text-center py-4">
                                <i class="fas fa-user-slash fa-2x text-muted mb-3"></i>
                                <h6 class="fw-semibold text-muted">No Vendor Assigned</h6>
                                <button class="btn btn-success btn-sm mt-2 d-none">
                                    <i class="fas fa-plus me-1"></i> Assign Vendor
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                @php
                    $orderItem = App\Models\front\CiorderItem::orderId($order->order_id)->first();
                @endphp

                {{-- Start Sales Person --}}
                @php
                    $salesPerson = null;

                    if ($orderItem && $orderItem->salesperson_id) {
                        $salesPerson = Helper::salesPersonInfo($orderItem->salesperson_id);
                    }
                @endphp

                <div class="card shadow-sm border-0 mb-4 border-start border-4 border-success">
                    <!-- Card Header -->
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-semibold text-dark">
                            <i class="fas fa-user-tie me-2 text-success"></i>
                            Assigned Salesperson
                        </h5>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        @if ($salesPerson)
                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                <!-- Left Section -->
                                <div class="d-flex align-items-center">
                                    <!-- Salesperson Info -->
                                    <div>
                                        <h6 class="fw-bold mb-1">
                                            {{ ucfirst(Helper::salesperson($orderItem->salesperson_id)) }}
                                        </h6>
                                        <div class="small text-muted">
                                            <div>Salesperson ID: #{{ $salesPerson->id }}</div>
                                            <div>Email: {{ $salesPerson->email ?? 'N/A' }}</div>
                                            <div>
                                                Phone:
                                                @if ($salesPerson->mobile)
                                                    +{{ $salesPerson->country_code }} {{ $salesPerson->mobile }}
                                                @else
                                                    N/A
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-user-slash fa-2x text-muted mb-3"></i>
                                <h6 class="fw-semibold text-muted">
                                    No Salesperson Assigned
                                </h6>
                            </div>
                        @endif
                    </div>
                </div>


                {{-- End Sales Person --}}

                {{-- Start Multiple Crew --}}

                @php
                    $crewIds = [];

                    if ($orderItem && $orderItem->cleaner_id) {
                        $crewIds = is_array($orderItem->cleaner_id)
                            ? $orderItem->cleaner_id
                            : explode(',', $orderItem->cleaner_id);

                        $crewIds = array_filter($crewIds); // remove empty values
                    }
                @endphp
                @php
                    $multipleCrew = collect();

                    if ($orderItem && $orderItem->cleaner_id) {
                        $crewIds = is_array($orderItem->cleaner_id)
                            ? $orderItem->cleaner_id
                            : explode(',', $orderItem->cleaner_id);

                        $multipleCrew = Helper::crewInfo($crewIds, $orderItem->service_id, $orderItem->subservice_id);
                    }
                @endphp

                @if (count($crewIds) > 1)

                    @php
                        $multipleCrew = Helper::crewInfo($crewIds, $orderItem->service_id, $orderItem->subservice_id);
                    @endphp

                    <div class="card shadow-sm border-0 mb-4 border-start border-4 border-success">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 fw-semibold text-dark">
                                <i class="fas fa-users me-2 text-success"></i>
                                Assigned Multiple Crew
                            </h5>
                        </div>

                        <div class="card-body">

                            @if ($multipleCrew && $multipleCrew->isNotEmpty())

                                @foreach ($multipleCrew as $crew)
                                    <div class="d-flex align-items-start mb-3 p-3 border rounded">
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-1">{{ ucfirst($crew->name) }}</h6>
                                            <div class="small text-muted">
                                                <div>Crew ID: #{{ $crew->id }}</div>
                                                <div>Email: {{ $crew->email ?? 'N/A' }}</div>
                                                <div>
                                                    Phone:
                                                    @if ($crew->mobile)
                                                        +{{ $crew->country_code }} {{ $crew->mobile }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-user-slash fa-2x text-muted mb-3"></i>
                                    <h6 class="fw-semibold text-muted">No Crew Assigned</h6>
                                </div>
                            @endif

                        </div>
                    </div>

                @endif

                {{-- End Multiple Crew --}}


                {{-- Start Single Crew --}}
                @if (count($crewIds) === 1)

                    @php
                        $singleCrew = Helper::singleCrewInfo(
                            (int) $crewIds[0],
                            $orderItem->service_id,
                            $orderItem->subservice_id,
                        );
                    @endphp

                    <div class="card shadow-sm border-0 mb-4 border-start border-4 border-success">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 fw-semibold text-dark">
                                <i class="fas fa-user-tie me-2 text-success"></i>
                                Assigned Single Crew
                            </h5>
                        </div>

                        <div class="card-body">

                            @if ($singleCrew)

                                <div class="d-flex align-items-start p-3 border rounded">
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-1">{{ ucfirst($singleCrew->name) }}</h6>
                                        <div class="small text-muted">
                                            <div>Crew ID: #{{ $singleCrew->id }}</div>
                                            <div>Email: {{ $singleCrew->email ?? 'N/A' }}</div>
                                            <div>
                                                Phone:
                                                @if ($singleCrew->mobile)
                                                    +{{ $singleCrew->country_code }} {{ $singleCrew->mobile }}
                                                @else
                                                    N/A
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-user-slash fa-2x text-muted mb-3"></i>
                                    <h6 class="fw-semibold text-muted">No Crew Assigned</h6>
                                </div>
                            @endif

                        </div>
                    </div>

                @endif

                {{-- End Single Crew --}}

                {{-- <div class="card border-0 shadow-sm mt-4 text-center p-3 bg-light">
                    <p class="text-muted mb-1 small text-uppercase">Reference Code</p>
                    <h5 class="fw-bold mb-0">HC-26-DXB-000124</h5>
                </div> --}}
            </div>
        </div>
    </div>
    {{-- <div class="content container-fluid">
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Order Details</h3>
                    <ul class="breadcrumb" style="background:none; padding:0;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">#ORD12345</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <div class="dropdown">
                        <button class="btn btn-white btn-sm border dropdown-toggle" type="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-download me-1"></i> Download
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">PDF Invoice</a></li>
                            <li><a class="dropdown-item" href="#">Packing Slip</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-primary btn-sm ms-2">
                        <i class="fas fa-print me-1"></i> Print Order
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge bg-success-light text-success mb-2"
                                    style="font-size: 0.85rem; padding: 0.5em 1em;">
                                    <i class="fas fa-check-circle me-1"></i> Delivered
                                </span>
                                <h4 class="fw-bold mb-1">Order #ORD12345</h4>
                                <p class="text-muted mb-0">Placed on 20 Feb 2026 at 10:15 AM</p>
                            </div>
                            <div class="text-end">
                                <p class="text-muted mb-1 small text-uppercase fw-bold">Total Amount</p>
                                <h3 class="text-primary fw-bold">₹ 3,250.00</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h5 class="card-title mb-0"><i class="fas fa-box-open me-2 text-primary"></i>Items Ordered</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Product Details</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th class="text-end pe-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded p-2 me-3"
                                                style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-mouse text-secondary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">Wireless Mouse</h6>
                                                <small class="text-muted">SKU: WM123 | Color: Black</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>₹ 750</td>
                                    <td>x 2</td>
                                    <td class="text-end pe-4 fw-bold">₹ 1,500</td>
                                </tr>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded p-2 me-3"
                                                style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-keyboard text-secondary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">Mechanical Keyboard</h6>
                                                <small class="text-muted">SKU: KB456 | RGB</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>₹ 1,750</td>
                                    <td>x 1</td>
                                    <td class="text-end pe-4 fw-bold">₹ 1,750</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-transparent py-3">
                        <div class="row">
                            <div class="col-sm-6 text-muted small">
                                <strong>Note:</strong> Items will be delivered in one package.
                            </div>
                            <div class="col-sm-6">
                                <div class="row text-end g-2">
                                    <div class="col-7 text-muted">Subtotal:</div>
                                    <div class="col-5 fw-bold">₹ 3,250.00</div>
                                    <div class="col-7 text-muted">Shipping:</div>
                                    <div class="col-5 text-success">Free</div>
                                    <div class="col-7 text-muted">Tax (GST):</div>
                                    <div class="col-5">₹ 0.00</div>
                                    <div class="col-7 h5 fw-bold mt-2">Total:</div>
                                    <div class="col-5 h5 fw-bold mt-2 text-primary">₹ 3,250.00</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h5 class="card-title mb-0"><i class="fas fa-stream me-2 text-primary"></i>Order Activity</h5>
                    </div>
                    <div class="card-body">
                        <div class="vertical-timeline ps-3 mt-2">
                            <div class="timeline-item pb-4 border-start ps-4 position-relative">
                                <span
                                    class="position-absolute start-0 top-0 translate-middle badge rounded-circle bg-success p-2"
                                    style="margin-left: -1.5px;"><i class="fas fa-check"></i></span>
                                <h6 class="fw-bold mb-1">Delivered</h6>
                                <p class="text-muted small mb-0">Package was delivered to Rahul Sharma • 22 Feb, 11:00 AM
                                </p>
                            </div>
                            <div class="timeline-item pb-4 border-start ps-4 position-relative">
                                <span
                                    class="position-absolute start-0 top-0 translate-middle badge rounded-circle bg-primary p-2"
                                    style="margin-left: -1.5px;"><i class="fas fa-truck"></i></span>
                                <h6 class="fw-bold mb-1">Shipped</h6>
                                <p class="text-muted small mb-0">Carrier: BlueDart • Tracking: #BD88291 • 21 Feb, 02:30 PM
                                </p>
                            </div>
                            <div class="timeline-item ps-4 position-relative">
                                <span
                                    class="position-absolute start-0 top-0 translate-middle badge rounded-circle bg-secondary p-2"
                                    style="margin-left: -1.5px;"><i class="fas fa-shopping-cart"></i></span>
                                <h6 class="fw-bold mb-1">Order Placed</h6>
                                <p class="text-muted small mb-0">Payment via Credit Card confirmed • 20 Feb, 10:15 AM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 45px; height: 45px;">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 fw-bold">Rahul Sharma</h6>
                                <p class="text-muted small mb-0">Customer ID: #CUS-9921</p>
                            </div>
                            <a href="#" class="btn btn-light btn-sm"><i class="fas fa-external-link-alt"></i></a>
                        </div>
                        <hr class="text-light">
                        <p class="mb-2 small text-muted"><i class="fas fa-envelope me-2"></i> rahul@email.com</p>
                        <p class="mb-0 small text-muted"><i class="fas fa-phone-alt me-2"></i> +91 9876543210</p>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3 d-flex justify-content-between">
                            Shipping Address
                            <a href="#" class="text-primary small fw-normal">Edit</a>
                        </h6>
                        <p class="mb-1 fw-bold small">Home Address</p>
                        <p class="text-muted small mb-0">
                            Flat 201, Shree Apartment, Satellite Road,<br>
                            Ahmedabad, Gujarat - 380015<br>
                            India
                        </p>
                    </div>
                </div>

                <div class="card shadow-sm border-0 bg-primary text-white">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Payment Info</h6>
                        <div class="d-flex align-items-center">
                            <i class="fab fa-cc-visa fa-2x me-3 text-white-50"></i>
                            <div>
                                <p class="mb-0 small">Visa ending in **** 4242</p>
                                <p class="mb-0 small opacity-75">Status: Authorized</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="content container-fluid">
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Booking Details</h3>
                    <ul class="breadcrumb" style="background:none; padding:0; font-size: 0.85rem;">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active text-muted">HC-26-DXB-000124</li>
                    </ul>
                </div>
                <div class="col-auto d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit me-1"></i> Edit
                        Booking</button>
                    <button class="btn btn-primary btn-sm"><i class="fas fa-print me-1"></i> Print Invoice</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-9 col-lg-8">

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="row g-0 text-center">
                            <div class="col-6 col-md-3 border-end py-3">
                                <p class="text-muted mb-1 small uppercase fw-bold">Status</p>
                                <span class="badge bg-success-light text-success"><i class="fas fa-check-circle me-1"></i>
                                    Vendor Assigned</span>
                            </div>
                            <div class="col-6 col-md-3 border-end py-3">
                                <p class="text-muted mb-1 small uppercase fw-bold">Booking Date</p>
                                <h6 class="mb-0 fw-bold">23 Feb 2026</h6>
                            </div>
                            <div class="col-6 col-md-3 border-end py-3">
                                <p class="text-muted mb-1 small uppercase fw-bold">Service Time</p>
                                <h6 class="mb-0 fw-bold">02:00 PM - 02:30 PM</h6>
                            </div>
                            <div class="col-6 col-md-3 py-3">
                                <p class="text-muted mb-1 small uppercase fw-bold">Ref Code</p>
                                <h6 class="mb-0 text-primary fw-bold">HC-26-DXB-000124</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-transparent border-bottom">
                                <h5 class="card-title mb-0"><i class="fas fa-user-circle me-2 text-primary"></i> Customer
                                    Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="text-muted small d-block">Full Name</label>
                                    <span class="fw-bold fs-5">Ali</span>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small d-block">Phone Number</label>
                                    <span class="fw-bold">+971 555500945</span>
                                </div>
                                <div class="mb-0">
                                    <label class="text-muted small d-block">Service Address</label>
                                    <p class="fw-bold mb-1">Villa 16, Cluster 50, Jumeirah Islands</p>
                                    <p class="text-muted mb-2 small">Dubai, United Arab Emirates</p>
                                    <a href="#" class="btn btn-sm btn-soft-info w-100 mt-2">
                                        <i class="fas fa-map-marked-alt me-1"></i> Open in Google Maps
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-transparent border-bottom">
                                <h5 class="card-title mb-0"><i class="fas fa-concierge-bell me-2 text-primary"></i>
                                    Service Details</h5>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                        <span class="text-muted">Service Type</span>
                                        <span class="fw-bold">Home Cleaning</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                        <span class="text-muted">No. of Cleaners / Hours</span>
                                        <span class="fw-bold">2 Cleaners / 2 Hours</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                        <span class="text-muted">Frequency</span>
                                        <span class="fw-bold">Once</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                        <span class="text-muted">Day of week</span>
                                        <span class="fw-bold">Monday</span>
                                    </li>
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center py-3 border-0">
                                        <span class="text-muted">Materials Required?</span>
                                        <span class="badge bg-danger-light text-danger">No</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-bottom">
                        <h5 class="card-title mb-0"><i class="fas fa-id-card me-2 text-primary"></i> Assigned Vendor
                            Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg bg-light rounded-circle me-3 d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <i class="fas fa-user-tie text-secondary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Sparkle Clean Services LLC</h6>
                                <p class="text-muted small mb-0">Vendor ID: #V-9901 | Contact: +971 500 000 000</p>
                            </div>
                            <div class="ms-auto">
                                <button class="btn btn-sm btn-white border">View Profile</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Payment Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4 text-center">
                            <p class="text-muted mb-1 small text-uppercase">Payment Method</p>
                            <h6 class="fw-bold"><i class="fas fa-credit-card me-1 text-primary"></i> Online</h6>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Service Charge</span>
                            <span class="fw-bold text-dark">132.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Service Fee</span>
                            <span class="fw-bold text-dark">9.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Subtotal</span>
                            <span class="fw-bold text-dark">141.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                            <span class="text-muted small">VAT Charge (5%)</span>
                            <span class="fw-bold text-dark">7.00</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2">
                            <h6 class="mb-0 fw-bold">Total (Inc. VAT)</h6>
                            <h4 class="mb-0 text-primary fw-bold">148.00</h4>
                        </div>
                        <p class="text-end text-muted x-small mt-1">Currency: AED</p>

                        <hr class="my-4">

                        <button class="btn btn-primary w-100 py-2 mb-2">Send Payment Receipt</button>
                        <button class="btn btn-white border w-100 py-2">Download PDF</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content container-fluid">
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Manage Booking <span class="text-muted fs-6">#HC-26-DXB-000124</span></h3>
                </div>
                <div class="col-auto d-flex gap-2">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle border" data-bs-toggle="dropdown">Change
                            Status</button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Mark In-Progress</a></li>
                            <li><a class="dropdown-item" href="#">Mark Completed</a></li>
                            <li><a class="dropdown-item text-danger" href="#">Cancel Booking</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Changes</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-9 col-lg-8">

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between step-indicator position-relative">
                            <div class="text-center z-index-1">
                                <div class="rounded-circle bg-success text-white mb-2 mx-auto d-flex align-items-center justify-content-center"
                                    style="width:35px; height:35px;"><i class="fas fa-check"></i></div>
                                <span class="small fw-bold">Booked</span>
                            </div>
                            <div class="text-center z-index-1">
                                <div class="rounded-circle bg-success text-white mb-2 mx-auto d-flex align-items-center justify-content-center"
                                    style="width:35px; height:35px;"><i class="fas fa-user-check"></i></div>
                                <span class="small fw-bold">Assigned</span>
                            </div>
                            <div class="text-center z-index-1">
                                <div class="rounded-circle bg-primary text-white mb-2 mx-auto d-flex align-items-center justify-content-center"
                                    style="width:35px; height:35px;"><i class="fas fa-clock"></i></div>
                                <span class="small fw-bold">In-Transit</span>
                            </div>
                            <div class="text-center z-index-1">
                                <div class="rounded-circle bg-light text-muted mb-2 mx-auto d-flex align-items-center justify-content-center"
                                    style="width:35px; height:35px;"><i class="fas fa-flag-checkered"></i></div>
                                <span class="small text-muted">Finished</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header p-0 border-bottom">
                        <ul class="nav nav-tabs nav-tabs-solid border-0 mb-0">
                            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                    href="#details_tab">General Details</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#audit_tab">Activity Log
                                    (Audit)</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#photos_tab">Service
                                    Photos (0)</a></li>
                        </ul>
                    </div>
                    <div class="card-body tab-content">
                        <div class="tab-pane show active" id="details_tab">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <h6 class="fw-bold border-start border-primary border-4 ps-2 mb-3 text-primary">Service
                                        Specifications</h6>
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td class="text-muted">Type:</td>
                                            <td class="fw-bold">Home Cleaning</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Capacity:</td>
                                            <td class="fw-bold">2 Cleaners / 2 Hours</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Frequency:</td>
                                            <td class="fw-bold">Once (Monday)</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Materials:</td>
                                            <td><span class="badge bg-danger-light text-danger">None</span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold border-start border-primary border-4 ps-2 mb-3 text-primary">
                                        Customer Profile</h6>
                                    <p class="mb-1 fw-bold">Ali <span
                                            class="badge bg-light text-dark fw-normal ms-2">Regular Client</span></p>
                                    <p class="mb-1 small text-muted"><i class="fas fa-phone me-1"></i> +971 555500945</p>
                                    <p class="mb-0 small text-muted"><i class="fas fa-map-marker-alt me-1"></i> Villa 16,
                                        Cluster 50, Jumeirah Islands</p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="audit_tab">
                            <div class="timeline-simple">
                                <div class="mb-3 ps-3 border-start border-2">
                                    <p class="mb-0 fw-bold small">Vendor Assigned</p>
                                    <p class="text-muted x-small mb-1">By Admin: John Doe | 23 Feb 11:30 AM</p>
                                </div>
                                <div class="mb-3 ps-3 border-start border-2">
                                    <p class="mb-0 fw-bold small">Payment Confirmed</p>
                                    <p class="text-muted x-small mb-1">System | 23 Feb 10:15 AM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4">

                <div class="card border-0 shadow-sm mb-4 bg-primary text-white">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Assigned Vendor</h6>
                        <div class="d-flex align-items-center">
                            <div class="bg-white-50 rounded p-2 me-3"><i class="fas fa-tools text-white"></i></div>
                            <div>
                                <p class="mb-0 fw-bold">Sparkle Services</p>
                                <a href="#" class="text-white-50 small">Contact Vendor</a>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-light w-100 mt-3">Re-assign Vendor</button>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom">
                        <h6 class="mb-0 fw-bold">Payment Tracking</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Service:</span>
                            <span class="fw-bold">132.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-danger">
                            <span class="text-muted small">Tax:</span>
                            <span>7.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Total</h5>
                            <h4 class="mb-0 text-primary fw-bold">148.00 <small class="fs-6">AED</small></h4>
                        </div>
                        <div class="mt-3">
                            <span class="badge w-100 py-2 bg-success">PAID via STRIPE</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content container-fluid">
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Booking Command Center</h3>
                    <p class="text-muted mb-0">Reference: <span class="fw-bold text-primary">#HC-26-DXB-000124</span></p>
                </div>
                <div class="col-auto d-flex gap-2">
                    <button class="btn btn-white border text-danger"><i class="fas fa-times-circle me-1"></i> Cancel
                        Booking</button>
                    <button class="btn btn-primary"><i class="fas fa-check-double me-1"></i> Complete Order</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="card-title mb-0 text-dark fw-bold">
                            <i class="fas fa-user-tag me-2 text-primary"></i> Customer Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="text-muted small d-block">Full Name</label>
                                <span class="fw-bold">Ali</span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="text-muted small d-block">Phone Number</label>
                                <span class="fw-bold">+971 555500945</span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="text-muted small d-block">Location</label>
                                <span class="fw-bold">Dubai, UAE</span>
                            </div>
                            <div class="col-12">
                                <label class="text-muted small d-block">Detailed Address</label>
                                <p class="fw-bold mb-0">Jumeirah Islands, Cluster 50, Villa 16</p>
                                <a href="#" class="btn btn-link btn-sm p-0 text-decoration-none mt-1">
                                    <i class="fas fa-external-link-alt me-1"></i> View on Satellite Map
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="card-title mb-0 text-dark fw-bold">
                            <i class="fas fa-broom me-2 text-primary"></i> Service Specifications
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody class="align-middle">
                                    <tr class="border-bottom">
                                        <td class="ps-4 py-3 text-muted" style="width: 30%;">Service Type</td>
                                        <td class="fw-bold text-dark">Home Cleaning</td>
                                        <td class="text-muted">Cleaners / Hours</td>
                                        <td class="fw-bold text-dark">2 / 2</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="ps-4 py-3 text-muted">Frequency</td>
                                        <td class="fw-bold text-dark">Once (Monday)</td>
                                        <td class="text-muted">Materials Provided?</td>
                                        <td><span class="badge bg-danger-light text-danger">No</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3 text-muted">Scheduled For</td>
                                        <td colspan="3" class="fw-bold text-primary">
                                            <i class="far fa-calendar-alt me-1"></i> 23 February 2026
                                            <i class="far fa-clock ms-3 me-1"></i> 2:00 PM - 2:30 PM
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4 border-start border-4 border-success">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="card-title mb-0 text-dark fw-bold">
                            <i class="fas fa-shuttle-van me-2 text-success"></i> Assigned Vendor Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg bg-light-success text-success rounded-circle me-3 d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <i class="fas fa-building fa-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold">Sparkle Clean Services LLC</h6>
                                <p class="text-muted small mb-0">Registration: #V-DXB-9921 | <i
                                        class="fas fa-star text-warning"></i> 4.8</p>
                            </div>
                            <div class="text-end">
                                <button class="btn btn-outline-primary btn-sm mb-1">Contact Vendor</button><br>
                                <button class="btn btn-link btn-sm text-muted p-0">Re-assign</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="card-title mb-0 text-dark fw-bold">
                            <i class="fas fa-history me-2 text-secondary"></i> System Activity Log
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="activity-feed">
                            <div class="d-flex mb-3">
                                <div class="me-3 text-center" style="width: 50px;">
                                    <span class="small text-muted d-block">Today</span>
                                    <span class="fw-bold">11:30</span>
                                </div>
                                <div class="border-start ps-3 pb-2">
                                    <p class="mb-0 fw-bold small">Vendor Assigned</p>
                                    <p class="text-muted x-small">Admin "John" assigned Sparkle Clean Services.</p>
                                </div>
                            </div>
                            <div class="d-flex mb-0">
                                <div class="me-3 text-center" style="width: 50px;">
                                    <span class="small text-muted d-block">Today</span>
                                    <span class="fw-bold">10:15</span>
                                </div>
                                <div class="border-start ps-3">
                                    <p class="mb-0 fw-bold small">Booking Received</p>
                                    <p class="text-muted x-small">Customer placed order via Mobile App (Paid Online).</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">

                <div class="card shadow-sm border-0 mb-4 bg-primary text-white">
                    <div class="card-body">
                        <label class="small opacity-75 d-block mb-1">CURRENT STATUS</label>
                        <h4 class="fw-bold mb-3">Vendor Assigned</h4>
                        <div class="progress mb-2" style="height: 6px; background: rgba(255,255,255,0.2);">
                            <div class="progress-bar bg-white" style="width: 50%;"></div>
                        </div>
                        <small class="opacity-75">Step 2 of 4: Awaiting Service Start</small>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="card-title mb-0 text-dark fw-bold">Payment Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Method</span>
                            <span class="badge bg-light text-dark border"><i class="fas fa-credit-card me-1"></i>
                                Online</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Service Charge</span>
                            <span>132.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Service Fee</span>
                            <span>9.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">VAT (5%)</span>
                            <span>7.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h6 mb-0 fw-bold">Grand Total</span>
                            <span class="h4 mb-0 fw-bold text-primary">148.00 <small
                                    class="fs-6 text-muted">AED</small></span>
                        </div>
                        <button class="btn btn-soft-primary w-100 mt-4 py-2">
                            <i class="fas fa-file-invoice me-1"></i> Download Invoice PDF
                        </button>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="card-title mb-0 text-dark fw-bold">Internal Admin Notes</h5>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control mb-2" rows="3" placeholder="Add a private note for other admins..."></textarea>
                        <button class="btn btn-white border btn-sm w-100">Save Note</button>
                    </div>
                </div>

            </div>
        </div>
    </div> --}}


@stop
