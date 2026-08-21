@extends('admin.includes.Template')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
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
        if (isset($order->items[0]) && $order->items[0]->service_id == 50) {
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
                                    {{ number_format($order->order_total, 2) }}
                                </h3>
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

                @if (isset($order->items[0]->subservice_id) && $order->items[0]->subservice_id == 93)
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-transparent border-bottom">
                            <h5 class="card-title mb-0"><i class="fas fa-car me-2 text-primary"></i> Car Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <p class="text-muted mb-1 small text-uppercase">Plate Source</p>
                                    <h6 class="fw-bold">{{ $order->items[0]->plate_source ?? '-' }}</h6>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-muted mb-1 small text-uppercase">Plate Code</p>
                                    <h6 class="fw-bold">{{ $order->items[0]->plate_code ?? '-' }}</h6>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-muted mb-1 small text-uppercase">Plate Number</p>
                                    <h6 class="fw-bold">{{ $order->items[0]->plate_number ?? '-' }}</h6>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <p class="text-muted mb-1 small text-uppercase">Car Description</p>
                                    <h6 class="fw-bold">{{ $order->items[0]->describe_your_car ?? '-' }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-transparent border-bottom">
                        <h5 class="card-title mb-0"><i class="fas fa-broom me-2 text-primary"></i> Service Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            @foreach ($order->items as $item)
                                @php
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

                                <div class="col-md-6 col-xl-4">
                                    <div class="d-flex align-items-center">

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

                                @if (!empty($item->package_item_name))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Services</p>
                                        <span class="fw-bold text-dark">{!! $item->package_item_name !!} *
                                            {!! $item->package_quantity !!}</span>
                                    </div>
                                @endif

                                @if (!empty($item->charger_type) && $item->subservice_id != '102')
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Charger Type</p>
                                        <span class="fw-bold text-dark">{!! $item->charger_type !!}</span>
                                    </div>
                                @endif
                                @if (!empty($item->installation_location_type) && $item->subservice_id != '102')
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Installation Location Type</p>
                                        <span class="fw-bold text-dark">{!! $item->installation_location_type !!}</span>
                                    </div>
                                @endif

                                @if (!empty($item->origin_add))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Origin Address</p>
                                        <span class="fw-bold text-dark">{!! $item->origin_add !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->origin_country))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Origin Country</p>
                                        <span class="fw-bold text-dark">{!! Helper::countryname($item->origin_country) !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->origin_state))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Origin State</p>
                                        <span class="fw-bold text-dark">{!! $item->origin_state !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->origin_city))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Origin City</p>
                                        <span class="fw-bold text-dark">{!! $item->origin_city !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->origin_location))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Origin Location</p>
                                        <span class="fw-bold text-dark">{!! $item->origin_location !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->origin_zip_post))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Origin ZIP/POST Code</p>
                                        <span class="fw-bold text-dark">{!! $item->origin_zip_post !!} </span>
                                    </div>
                                @endif

                                @if (!empty($item->desti_add))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Destination Address</p>
                                        <span class="fw-bold text-dark">{!! $item->desti_add !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->desti_country))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Destination Country</p>
                                        <span class="fw-bold text-dark">{!! Helper::countryname($item->desti_country) !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->desti_state))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Destination State</p>
                                        <span class="fw-bold text-dark">{!! $item->desti_state !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->desti_city))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Destination City</p>
                                        <span class="fw-bold text-dark">{!! $item->desti_city !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->desti_location))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Destination Location</p>
                                        <span class="fw-bold text-dark">{!! $item->desti_location !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->desti_zip_post))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Destination ZIP/POST Code</p>
                                        <span class="fw-bold text-dark">{!! $item->desti_zip_post !!} </span>
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
                                        <span
                                            class="fw-bold text-dark">{{ $item->how_many_hours_should_they_stay }}</span>
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
                                @if ($order->is_manpower_order == 1)
                                    <div class="col-12 mt-3 mb-2">
                                        <h6 class="fw-bold text-primary border-bottom pb-2">Manpower Requirements</h6>
                                    </div>
                                    @if (!empty($item->manpower_service_required))
                                        <div class="col-md-6 col-xl-4">
                                            <p class="text-muted mb-0 small">Service Required</p>
                                            <span class="fw-bold text-dark">{{ $item->manpower_service_required }}</span>
                                        </div>
                                    @endif
                                    @if (!empty($item->manpower_workers_required))
                                        <div class="col-md-6 col-xl-4">
                                            <p class="text-muted mb-0 small">Number of Workers</p>
                                            <span class="fw-bold text-dark">{{ $item->manpower_workers_required }}</span>
                                        </div>
                                    @endif
                                    @if (!empty($item->manpower_duration))
                                        <div class="col-md-6 col-xl-4">
                                            <p class="text-muted mb-0 small">Duration / Per Day</p>
                                            <span class="fw-bold text-dark">{{ $item->manpower_duration }}</span>
                                        </div>
                                    @endif
                                    @if (!empty($item->manpower_start_date))
                                        <div class="col-md-6 col-xl-4">
                                            <p class="text-muted mb-0 small">Start Date</p>
                                            <span
                                                class="fw-bold text-dark">{{ date('d M Y', strtotime($item->manpower_start_date)) }}</span>
                                        </div>
                                    @endif
                                    @if (!empty($item->manpower_end_date))
                                        <div class="col-md-6 col-xl-4">
                                            <p class="text-muted mb-0 small">End Date</p>
                                            <span
                                                class="fw-bold text-dark">{{ date('d M Y', strtotime($item->manpower_end_date)) }}</span>
                                        </div>
                                    @endif
                                    @if (!empty($item->manpower_job_description))
                                        <div class="col-12 mt-2">
                                            <p class="text-muted mb-0 small">Job Description / Requirements</p>
                                            <span class="fw-bold text-dark">{{ $item->manpower_job_description }}</span>
                                        </div>
                                    @endif
                                    @if (!empty($item->manpower_additional_notes))
                                        <div class="col-12 mt-2">
                                            <p class="text-muted mb-0 small">Additional Notes</p>
                                            <span class="fw-bold text-dark">{{ $item->manpower_additional_notes }}</span>
                                        </div>
                                    @endif
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
                                @if ($item->any_special_instruction != '')
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Instruction</p>
                                        <span class="fw-bold text-dark">{{ $item->any_special_instruction ?: '-' }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                @php
                    $statusFlow = [
                        'BK' => 'Booking Requested',
                        'BC' => 'Booking Confirmed',
                        'P' => 'Booking Confirmed',
                        'PA' => 'Vendor Assigned',
                        'OTW' => 'On the way',
                        'IP' => 'In progress',
                        'CO' => 'Booking Completed',
                        'CL' => 'Booking Cancelled',
                        'UP' => 'Unpaid',
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

                @php
                    // Fetch recurring visits dynamically for this order using Helper
                    $recurring_visits = \App\Helpers\Helper::getUpcomingVisits($order->order_id, 5);
                @endphp

                @if ($recurring_visits->count() > 0)
                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-header bg-transparent border-bottom py-3">
                            <h5 class="card-title mb-0">
                                <i class="far fa-calendar-alt me-2 text-primary"></i>Upcoming Visits
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                            <th>Assigned Cleaner</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recurring_visits as $visit)
                                            <tr>
                                                <td><strong>{{ date('d M Y', strtotime($visit->visit_date)) }}</strong>
                                                </td>
                                                <td>
                                                    {{ \App\Helpers\Helper::timeslotname($visit->visit_time) }}
                                                    @php
                                                        $h = isset($visit->extra_hours) ? $visit->extra_hours : 0;
                                                        $c = isset($visit->extra_charge) ? $visit->extra_charge : 0;
                                                    @endphp
                                                    @if ($h != 0 || $c != 0)
                                                        <br>
                                                        <span
                                                            class="badge {{ $h > 0 || $c > 0 ? 'bg-warning text-dark' : 'bg-danger text-white' }} mt-1">
                                                            @if ($h != 0)
                                                                {{ $h > 0 ? '+' : '' }}{{ $h }} Hrs
                                                            @endif
                                                            @if ($c != 0)
                                                                @if ($h != 0)
                                                                    (
                                                                @endif
                                                                {{ $c > 0 ? '+' : '' }}{{ $c }} AED
                                                                @if ($h != 0)
                                                                    )
                                                                @endif
                                                            @endif
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($visit->visit_status == 'cancelled')
                                                        <span class="badge bg-danger">Cancelled</span>
                                                    @elseif($visit->visit_status == 'completed')
                                                        <span class="badge bg-success">Completed</span>
                                                    @else
                                                        <span class="badge bg-info">Upcoming</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($visit->cleaner_name)
                                                        {{ $visit->cleaner_name }}
                                                    @else
                                                        <span class="text-muted">Not Assigned</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    @php
                                                        $txn = null;
                                                        if ($order->paymentmode == 2) {
                                                            $txn = \App\Helpers\Helper::getVisitTransaction(
                                                                $order->order_id,
                                                                $visit->visit_date,
                                                            );
                                                        }
                                                        $basePrice = $order->order_total ?? 0;
                                                    @endphp

                                                    @if ($txn)
                                                        <div class="mb-1 text-end">
                                                            <span class="badge bg-success"
                                                                style="font-size: 0.75rem;">Cut:
                                                                {{ number_format($txn->amount_deducted, 2) }}
                                                                AED</span><br>
                                                            <small class="text-muted" style="font-size: 0.65rem;">Txn:
                                                                {{ $txn->transaction_id }}</small>
                                                        </div>
                                                    @endif

                                                    @if ($visit->visit_status != 'cancelled' && $visit->visit_status != 'completed')
                                                        <div class="dropdown mt-1">
                                                            <button class="btn btn-sm btn-light border dropdown-toggle"
                                                                type="button" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fas fa-cog text-secondary"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                                @if ($order->paymentmode == 2 && !$txn && $visit->visit_status != 'cancelled' && $visit->visit_status != 'skipped')
                                                                    <li>
                                                                        <button
                                                                            class="dropdown-item text-success deduct-visit-btn"
                                                                            type="button"
                                                                            data-date="{{ $visit->visit_date }}"
                                                                            data-order="{{ $order->order_id }}"
                                                                            data-base="{{ $basePrice }}"
                                                                            data-extra="{{ $visit->extra_charge ?? 0 }}">
                                                                            <i class="fas fa-hand-holding-usd me-2"></i>
                                                                            Deduct
                                                                        </button>
                                                                    </li>
                                                                    <li>
                                                                        <hr class="dropdown-divider">
                                                                    </li>
                                                                @endif
                                                                <li>
                                                                    <button
                                                                        class="dropdown-item text-primary assign-cleaner-btn"
                                                                        type="button"
                                                                        data-date="{{ $visit->visit_date }}"
                                                                        data-order="{{ $order->order_id }}"
                                                                        data-cleaner="{{ $visit->cleaner_id }}">
                                                                        <i class="fas fa-user-plus me-2"></i> Assign
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <button
                                                                        class="dropdown-item text-warning adjust-hours-btn"
                                                                        type="button"
                                                                        data-date="{{ $visit->visit_date }}"
                                                                        data-order="{{ $order->order_id }}"
                                                                        data-extrahours="{{ $visit->extra_hours ?? 0 }}"
                                                                        data-extracharge="{{ $visit->extra_charge ?? 0 }}">
                                                                        <i class="fas fa-clock me-2"></i> Adjust Hours
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <button
                                                                        class="dropdown-item text-danger cancel-visit-btn"
                                                                        type="button"
                                                                        data-date="{{ $visit->visit_date }}"
                                                                        data-order="{{ $order->order_id }}">
                                                                        <i class="fas fa-times me-2"></i> Skip/Cancel
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Assign Cleaner Modal -->
                    <div class="modal fade" id="assignCleanerModal" tabindex="-1"
                        aria-labelledby="assignCleanerModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="assignCleanerModalLabel">Assign Cleaner to Visit</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="assign_visit_date">
                                    <input type="hidden" id="assign_order_id">
                                    <div class="mb-3">
                                        <label class="form-label">Select Cleaner</label>
                                        @php
                                            $cleaners_list = DB::table('users')->where('role_id', '16')->get();
                                        @endphp
                                        <select class="form-select" id="assign_cleaner_id">
                                            <option value="">-- Select Cleaner --</option>
                                            @foreach ($cleaners_list as $cln)
                                                <option value="{{ $cln->id }}">{{ $cln->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="saveAssignedCleanerBtn">Save
                                        Assignment</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Adjust Hours Modal -->
                    <div class="modal fade" id="adjustHoursModal" tabindex="-1" aria-labelledby="adjustHoursModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="adjustHoursModalLabel">Adjust Visit Hours</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="adjust_visit_date">
                                    <input type="hidden" id="adjust_order_id">
                                    <div class="mb-3">
                                        <label class="form-label">Adjustment Type</label>
                                        <select class="form-select" id="adjust_adjustment_type">
                                            <option value="add">Add Extra Hours (+)</option>
                                            <option value="deduct">Deduct Hours (-)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Hours</label>
                                        <input type="number" step="0.5" class="form-control"
                                            id="adjust_extra_hours" placeholder="e.g. 2">
                                        <small class="text-muted">Enter the number of hours.</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Amount (AED)</label>
                                        <input type="number" step="0.01" class="form-control"
                                            id="adjust_extra_charge" placeholder="e.g. 80.00">
                                        <small class="text-muted">Manually enter the total charge adjustment.</small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-warning" id="saveAdjustHoursBtn">Save
                                        Adjustment</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            $('.adjust-hours-btn').on('click', function() {
                                let visitDate = $(this).data('date');
                                let orderId = $(this).data('order');
                                let extraHours = parseFloat($(this).data('extrahours')) || 0;
                                let extraCharge = parseFloat($(this).data('extracharge')) || 0;

                                let type = 'add';
                                if (extraHours < 0) {
                                    type = 'deduct';
                                    extraHours = Math.abs(extraHours);
                                    extraCharge = Math.abs(extraCharge);
                                }

                                $('#adjust_visit_date').val(visitDate);
                                $('#adjust_order_id').val(orderId);
                                $('#adjust_adjustment_type').val(type);
                                $('#adjust_extra_hours').val(extraHours == 0 ? '' : extraHours);
                                $('#adjust_extra_charge').val(extraCharge == 0 ? '' : extraCharge);

                                $('#adjustHoursModal').modal('show');
                            });

                            $('#saveAdjustHoursBtn').on('click', function() {
                                let visitDate = $('#adjust_visit_date').val();
                                let orderId = $('#adjust_order_id').val();
                                let adjType = $('#adjust_adjustment_type').val();
                                let extraHours = $('#adjust_extra_hours').val();
                                let extraCharge = $('#adjust_extra_charge').val();

                                if (extraHours === '' || extraCharge === '') {
                                    Swal.fire('Error!', 'Please enter valid hours and charge', 'error');
                                    return;
                                }

                                $(this).prop('disabled', true).text('Saving...');
                                $.ajax({
                                    url: "{{ route('admin.adjust_visit_hours') }}",
                                    type: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        visit_date: visitDate,
                                        order_id: orderId,
                                        adjustment_type: adjType,
                                        extra_hours: extraHours,
                                        manual_extra_charge: extraCharge
                                    },
                                    success: function(response) {
                                        if (response.status == 1) {
                                            Swal.fire('Success!', response.message, 'success').then(() => {
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire('Error!', response.message, 'error');
                                            $('#saveAdjustHoursBtn').prop('disabled', false).text(
                                                'Save Adjustment');
                                        }
                                    },
                                    error: function(err) {
                                        Swal.fire('Error!', 'Something went wrong', 'error');
                                        $('#saveAdjustHoursBtn').prop('disabled', false).text(
                                        'Save Adjustment');
                                    }
                                });
                            });

                            $('.assign-cleaner-btn').on('click', function() {
                                $('#assign_visit_date').val($(this).data('date'));
                                $('#assign_order_id').val($(this).data('order'));
                                $('#assign_cleaner_id').val($(this).data('cleaner'));
                                $('#assignCleanerModal').modal('show');
                            });

                            $('#saveAssignedCleanerBtn').on('click', function() {
                                let visitDate = $('#assign_visit_date').val();
                                let orderId = $('#assign_order_id').val();
                                let cleanerId = $('#assign_cleaner_id').val();

                                if (!cleanerId) {
                                    Swal.fire('Error', 'Please select a cleaner', 'error');
                                    return;
                                }

                                $(this).prop('disabled', true).text('Saving...');

                                $.ajax({
                                    url: "{{ route('admin.assign_visit_cleaner') }}",
                                    type: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        visit_date: visitDate,
                                        order_id: orderId,
                                        cleaner_id: cleanerId
                                    },
                                    success: function(response) {
                                        if (response.status == 1) {
                                            Swal.fire('Success!', response.message, 'success').then(() => {
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire('Error!', response.message, 'error');
                                            $('#saveAssignedCleanerBtn').prop('disabled', false).text(
                                                'Save Assignment');
                                        }
                                    },
                                    error: function(err) {
                                        Swal.fire('Error!', 'Something went wrong', 'error');
                                        $('#saveAssignedCleanerBtn').prop('disabled', false).text(
                                            'Save Assignment');
                                    }
                                });
                            });

                            $('.cancel-visit-btn').on('click', function() {
                                let visitDate = $(this).data('date');
                                let orderId = $(this).data('order');

                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "Do you want to cancel this specific visit?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, cancel it!',
                                    showLoaderOnConfirm: true,
                                    preConfirm: () => {
                                        return $.ajax({
                                            url: "{{ route('admin.cancel_recurring_visit') }}",
                                            type: "POST",
                                            data: {
                                                _token: "{{ csrf_token() }}",
                                                visit_date: visitDate,
                                                order_id: orderId
                                            }
                                        }).catch(error => {
                                            Swal.showValidationMessage(`Request failed: ${error}`);
                                        });
                                    },
                                    allowOutsideClick: () => !Swal.isLoading()
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        if (result.value.status == 1) {
                                            Swal.fire(
                                                'Cancelled!',
                                                result.value.message,
                                                'success'
                                            ).then(() => {
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire(
                                                'Error!',
                                                result.value.message,
                                                'error'
                                            );
                                        }
                                    }
                                });
                            });
                        });
                    </script>
                @endif

                @php
                    $past_visits = \App\Helpers\Helper::getUpcomingVisits($order->order_id, 100, 'past')->sortByDesc(
                        'visit_date',
                    );
                @endphp

                @if ($past_visits->count() > 0)
                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-header bg-transparent border-bottom py-3">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-history me-2 text-secondary"></i>Past Visits
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                            <th>Assigned Cleaner</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($past_visits as $visit)
                                            <tr>
                                                <td><strong>{{ date('d M Y', strtotime($visit->visit_date)) }}</strong>
                                                </td>
                                                <td>
                                                    {{ \App\Helpers\Helper::timeslotname($visit->visit_time) }}
                                                    @php
                                                        $h = isset($visit->extra_hours) ? $visit->extra_hours : 0;
                                                        $c = isset($visit->extra_charge) ? $visit->extra_charge : 0;
                                                    @endphp
                                                    @if ($h != 0 || $c != 0)
                                                        <br>
                                                        <span
                                                            class="badge {{ $h > 0 || $c > 0 ? 'bg-warning text-dark' : 'bg-danger text-white' }} mt-1">
                                                            @if ($h != 0)
                                                                {{ $h > 0 ? '+' : '' }}{{ $h }} Hrs
                                                            @endif
                                                            @if ($c != 0)
                                                                @if ($h != 0)
                                                                    (
                                                                @endif
                                                                {{ $c > 0 ? '+' : '' }}{{ $c }} AED
                                                                @if ($h != 0)
                                                                    )
                                                                @endif
                                                            @endif
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($visit->visit_status == 'cancelled' || $visit->visit_status == 'skipped')
                                                        <span class="badge bg-danger">Cancelled</span>
                                                    @elseif($visit->visit_status == 'completed')
                                                        <span class="badge bg-success">Completed</span>
                                                    @else
                                                        <span class="badge bg-secondary">Past</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($visit->cleaner_name)
                                                        {{ $visit->cleaner_name }}
                                                    @else
                                                        <span class="text-muted">Not Assigned</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    @if ($order->paymentmode == 2)
                                                        @php
                                                            $txn = \App\Helpers\Helper::getVisitTransaction(
                                                                $order->order_id,
                                                                $visit->visit_date,
                                                            );
                                                            $basePrice = $order->order_total ?? 0;
                                                        @endphp
                                                        @if ($txn)
                                                            <div class="mb-1 text-end">
                                                                <span class="badge bg-success"
                                                                    style="font-size: 0.75rem;">Cut:
                                                                    {{ number_format($txn->amount_deducted, 2) }}
                                                                    AED</span><br>
                                                                <small class="text-muted" style="font-size: 0.65rem;">Txn:
                                                                    {{ $txn->transaction_id }}</small>
                                                            </div>
                                                        @elseif($visit->visit_status != 'cancelled' && $visit->visit_status != 'skipped')
                                                            <button
                                                                class="btn btn-sm btn-outline-success mb-1 deduct-visit-btn w-100"
                                                                type="button" data-date="{{ $visit->visit_date }}"
                                                                data-order="{{ $order->order_id }}"
                                                                data-base="{{ $basePrice }}"
                                                                data-extra="{{ $visit->extra_charge ?? 0 }}">
                                                                <i class="fas fa-hand-holding-usd"></i> Deduct
                                                            </button>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

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
                                    <div class="mt-1 small text-muted d-flex align-items-center justify-content-end">
                                        <span title="{{ $order->payment_id }}" class="text-truncate d-inline-block"
                                            style="max-width: 150px; vertical-align: middle;">
                                            {{ $order->payment_id }}
                                        </span>
                                        <button type="button" class="btn btn-sm btn-link p-0 text-primary ms-2"
                                            onclick="navigator.clipboard.writeText('{{ $order->payment_id }}'); alert('Payment ID copied!');"
                                            title="Copy Payment ID">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z" />
                                            </svg>
                                        </button>
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

                        @php
                            //echo "<pre>";print_r($order->items[0]->package_item_name);
                        @endphp

                        @if (isset($order->items[0]->package_item_name))
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Service Charge</span>
                                <span><span class="currency_dhiram"></span>
                                    {{ number_format($order->items[0]->package_quantity * $order->items[0]->package_item_price, 2) }}</span>
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
                                    {{ number_format((float) $order->service_fee, 2) }}</span>
                            </div>
                        @endif
                        @php
                            //echo"<pre>";print_r($order);
                        @endphp

                        @if (isset($order->sub_total) && $order->sub_total > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span><span class="currency_dhiram"></span>
                                    {{ number_format($order->sub_total, 2) }}</span>
                            </div>
                        @endif
                        {{-- @if (isset($sub_total_new) && $sub_total_new > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span><span class="currency_dhiram"></span>
                            {{ number_format($sub_total_new, 2) }}</span>
                    </div>
                    @endif --}}
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
                                    {{ number_format($order->order_total, 2) }}
                                </h5>
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
                                    {{-- <div
                                    class="rounded-circle bg-success bg-opacity-10 text-success 
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
                                    @php
                                        $Getreview = DB::table('ci_cleaners_review')
                                            ->where('order_id', $order->order_id)
                                            ->where('crew_id', $crew->id)
                                            ->first();
                                    @endphp
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
                                                @php
                                                    $rating = $Getreview->rating ?? 0;
                                                @endphp

                                                <div class="text-warning" style="font-size: 12px;">
                                                    Rating:
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $rating)
                                                            <i class="bi bi-star-fill text-warning"></i>
                                                        @else
                                                            <i class="bi bi-star"></i>
                                                        @endif
                                                    @endfor
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

                                @php
                                    $Getreview = DB::table('ci_cleaners_review')
                                        ->where('order_id', $order->order_id)
                                        ->where('crew_id', $singleCrew->id)
                                        ->first();
                                @endphp

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

                                            @if (!empty($Getreview))
                                                @php
                                                    $rating = $Getreview->rating ?? 0;
                                                @endphp

                                                <div class="text-warning" style="font-size: 12px;">
                                                    Rating:
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $rating)
                                                            <i class="bi bi-star-fill text-warning"></i>
                                                        @else
                                                            <i class="bi bi-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            @endif
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

                @php
                    $recurring_visits = collect();
                    if (\Illuminate\Support\Facades\Schema::hasTable('ci_order_visits')) {
                        $orderIdForVisits = !empty($order->format_order_id)
                            ? $order->format_order_id
                            : $order->order_id;
                        $recurring_visits = DB::table('ci_order_visits')
                            ->where('order_id', $orderIdForVisits)
                            ->orderBy('visit_date', 'asc')
                            ->get();
                    }
                @endphp

                @if ($recurring_visits->count() > 0)
                    <div class="card shadow-sm border-0 mb-4 border-start border-4 border-info">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 fw-semibold text-dark">
                                <i class="fas fa-calendar-alt me-2 text-info"></i>
                                Upcoming Schedule
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="px-4">Date</th>
                                            <th>Status</th>
                                            <th>Payment</th>
                                            <th class="text-end px-4">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recurring_visits as $visit)
                                            <tr>
                                                <td class="px-4 align-middle">
                                                    <strong>{{ date('d M Y', strtotime($visit->visit_date)) }}</strong>
                                                </td>
                                                <td class="align-middle">
                                                    @if ($visit->visit_status == 'cancelled')
                                                        <span class="badge bg-danger">Skipped</span>
                                                    @elseif($visit->visit_status == 'completed')
                                                        <span class="badge bg-success">Completed</span>
                                                    @else
                                                        <span class="badge bg-info">Upcoming</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if ($visit->payment_status == 'paid')
                                                        <span class="badge bg-success"><i
                                                                class="fas fa-check-circle me-1"></i>
                                                            Paid</span>
                                                    @elseif($visit->payment_status == 'pending' && $order->paymentmode == 1)
                                                        <span class="badge bg-warning text-dark"><i
                                                                class="fas fa-money-bill me-1"></i>
                                                            COD Pending</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark"><i
                                                                class="fas fa-clock me-1"></i>
                                                            Pending</span>
                                                    @endif
                                                </td>
                                                <td class="text-end px-4 align-middle">
                                                    @if ($visit->visit_status != 'cancelled' && $visit->visit_status != 'completed')
                                                        @if ($visit->payment_status == 'pending' && $order->paymentmode == 1)
                                                            <button class="btn btn-sm btn-outline-success admin-mark-paid"
                                                                data-id="{{ $visit->id }}">
                                                                <i class="fas fa-check"></i> Mark Paid
                                                            </button>
                                                        @endif

                                                        <button
                                                            class="btn btn-sm btn-outline-danger admin-cancel-visit ms-1"
                                                            data-id="{{ $visit->id }}">
                                                            <i class="fas fa-times"></i> Skip
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            $('.admin-cancel-visit').on('click', function() {
                                let visitId = $(this).data('id');
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "Do you want to cancel this visit for the user?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, cancel it!',
                                    showLoaderOnConfirm: true,
                                    preConfirm: () => {
                                        return $.ajax({
                                            url: "{{ route('admin.cancel_recurring_visit') }}",
                                            type: "POST",
                                            data: {
                                                _token: "{{ csrf_token() }}",
                                                visit_id: visitId
                                            }
                                        }).catch(error => {
                                            Swal.showValidationMessage(`Request failed: ${error}`);
                                        });
                                    },
                                    allowOutsideClick: () => !Swal.isLoading()
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        if (result.value.status == 1) {
                                            Swal.fire(
                                                'Cancelled!',
                                                result.value.message,
                                                'success'
                                            ).then(() => {
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire('Error!', result.value.message, 'error');
                                        }
                                    }
                                });
                            });

                            $('.admin-mark-paid').on('click', function() {
                                let visitId = $(this).data('id');
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "Do you want to mark this COD visit as Paid?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#28a745',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, Mark Paid!',
                                    showLoaderOnConfirm: true,
                                    preConfirm: () => {
                                        return $.ajax({
                                            url: "{{ route('admin.mark_visit_paid') }}",
                                            type: "POST",
                                            data: {
                                                _token: "{{ csrf_token() }}",
                                                visit_id: visitId
                                            }
                                        }).catch(error => {
                                            Swal.showValidationMessage(`Request failed: ${error}`);
                                        });
                                    },
                                    allowOutsideClick: () => !Swal.isLoading()
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        if (result.value.status == 1) {
                                            Swal.fire(
                                                'Paid!',
                                                result.value.message,
                                                'success'
                                            ).then(() => {
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire('Error!', result.value.message, 'error');
                                        }
                                    }
                                });
                            });
                        });
                    </script>
                @endif
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(document).on('click', '.deduct-visit-btn', function(e) {
                e.preventDefault();
                let btn = $(this);
                let visitDate = btn.data('date');
                let orderId = btn.data('order');
                let baseCharge = parseFloat(btn.data('base')) || 0;
                let extraCharge = parseFloat(btn.data('extra')) || 0;
                let totalDeduct = baseCharge + extraCharge;

                Swal.fire({
                    title: 'Deduct Amount',
                    html: `Are you sure you want to mark this visit's amount as consumed?<br><br>
                       <b>Base Charge:</b> ${baseCharge.toFixed(2)} AED<br>
                       <b>Extra Charge:</b> ${extraCharge.toFixed(2)} AED<br>
                       <hr>
                       <b>Total Cut Amount:</b> <span class="text-success fw-bold">${totalDeduct.toFixed(2)} AED</span>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Deduct',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return $.ajax({
                            url: "{{ route('admin.deduct_visit_charge') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                order_id: orderId,
                                visit_date: visitDate
                            }
                        }).catch(error => {
                            Swal.showValidationMessage(`Request failed: ${error}`);
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (result.value.status == 1) {
                            Swal.fire('Success!', result.value.message, 'success').then(() =>
                                location.reload());
                        } else {
                            Swal.fire('Error!', result.value.message, 'error');
                        }
                    }
                });
            });
        });
    </script>

@stop
