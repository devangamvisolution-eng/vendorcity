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
                            {{-- @if (isset($order->user_mobile) || isset($order->user_country_code))
                                <div class="col-md-4">
                                    <p class="text-muted mb-1 small">Phone</p>
                                    <h6 class="fw-bold">
                                        @if ($order?->user_country_code)
                                            {{ '+' . $order?->user_country_code ?? '' }}
                                        @endif
                                        {{ $order->user_mobile }}
                                    </h6>
                                </div>
                            @endif --}}

                            @if (data_get($order, 'items.0.subservice_id') == 95)
                                @if (!empty($order->user_mobile) || !empty($order->user_country_code))
                                    <div class="col-md-4">
                                        <p class="text-muted mb-1 small">Phone</p>
                                        <h6 class="fw-bold">
                                            @if (!empty($order->user_country_code))
                                                +{{ $order->user_country_code }}
                                            @endif
                                            {{ $order->user_mobile }}
                                        </h6>
                                    </div>
                                @endif
                            @endif

                            @if (data_get($order, 'items.0.subservice_id') == 95)
                                @if (!empty($order->user_email))
                                    <div class="col-md-4">
                                        <p class="text-muted mb-1 small">Email</p>
                                        <h6 class="fw-bold">
                                            @if (!empty($order->user_email))
                                                {{ $order->user_email }}
                                            @endif
                                        </h6>
                                    </div>
                                @endif
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

                            @php
                                $firstItem = data_get($order, 'items.0');
                            @endphp

                            @if (data_get($firstItem, 'subservice_id') == 95 && !empty(data_get($firstItem, 'building_street_no')))
                                <div class="col-md-4">
                                    <p class="text-muted mb-1 small">Building/Street</p>
                                    <h6 class="fw-bold">
                                        {{ data_get($firstItem, 'building_street_no') }}
                                    </h6>
                                </div>
                            @endif
                            @if (data_get($firstItem, 'subservice_id') == 95 && !empty(data_get($firstItem, 'apartment_villa_no')))
                                <div class="col-md-4">
                                    <p class="text-muted mb-1 small">Apartment/Villa No</p>
                                    <h6 class="fw-bold">
                                        {{ data_get($firstItem, 'apartment_villa_no') }}
                                    </h6>
                                </div>
                            @endif
                            @if (data_get($firstItem, 'subservice_id') == 95 && !empty(data_get($firstItem, 'emirates_id_number')))
                                <div class="col-md-4">
                                    <p class="text-muted mb-1 small">Emirates ID Number</p>
                                    <h6 class="fw-bold">
                                        {{ data_get($firstItem, 'emirates_id_number') }}
                                    </h6>
                                </div>
                            @endif
                            @if (data_get($firstItem, 'subservice_id') == 95 && !empty(data_get($firstItem, 'passport_number')))
                                <div class="col-md-4">
                                    <p class="text-muted mb-1 small">Passport Number</p>
                                    <h6 class="fw-bold">
                                        {{ data_get($firstItem, 'passport_number') }}
                                    </h6>
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
                            {{-- @php
                                echo '<pre>dev';
                                print_r($order);
                            @endphp --}}
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
                                    }
                                    $order_item_addonspackage_data = DB::table('ci_order_item_addons')
                                        ->where('order_id', $item->order_id)
                                        ->where('order_item_id', $item->id)
                                        ->get()
                                        ->toArray();
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

                                @if (!empty($item->storage_type))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Type of storage</p>
                                        <span class="fw-bold text-dark">{!! $item->storage_type !!} </span>
                                    </div>
                                @endif

                                @if (!empty($item->storage_location))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Where would you like to store</p>
                                        <span class="fw-bold text-dark">{!! $item->storage_location !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->storage_from_date))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">From Date</p>
                                        <span class="fw-bold text-dark">{!! $item->storage_from_date !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->storage_to_date))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">To Date</p>
                                        <span class="fw-bold text-dark">{!! $item->storage_to_date !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->warehouse_name))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Warehouse Name</p>
                                        <span class="fw-bold text-dark">{!! $item->warehouse_name !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->unit_no))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Unit No</p>
                                        <span class="fw-bold text-dark">{!! $item->unit_no !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->emirate_id))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Emirate ID</p>
                                        <span class="fw-bold text-dark">{!! $item->emirate_id !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->trade_license))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Company Trade Licence</p>
                                        <span class="fw-bold text-dark">{!! $item->trade_license !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->space_required))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Space Required</p>
                                        <span class="fw-bold text-dark">{!! $item->space_required !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->space_price))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Space Price</p>
                                        <span class="fw-bold text-dark">{!! $item->space_price !!} </span>
                                    </div>
                                @endif
                                @if (!empty($item->items_to_store))
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">What would you like to store?</p>
                                        <span class="fw-bold text-dark">{!! $item->items_to_store !!} </span>
                                    </div>
                                @endif

                                @if (!empty($item->charger_type) && $item->subservice_id != '102')
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Charger Type</p>
                                        <span class="fw-bold text-dark">{{ $item->charger_type }} </span>
                                    </div>
                                @endif
                                @if (!empty($item->installation_location_type) && $item->subservice_id != '102')
                                    <div class="col-md-6 col-xl-4">
                                        <p class="text-muted mb-0 small">Installation Location Type</p>
                                        <span class="fw-bold text-dark">{{ $item->installation_location_type }} </span>
                                    </div>
                                @endif
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
                                @if ($item->subservice_id == '102')
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
                                    <h6 class="fw-bold text-danger mb-1">Booking Cancelled</h6>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recurring_visits as $visit)
                                            <tr>
                                                <td><strong>{{ date('d M Y', strtotime($visit->visit_date)) }}</strong>
                                                </td>
                                                <td>{{ $visit->visit_time ?? '-' }}</td>
                                                <td>
                                                    @if ($visit->visit_status == 'cancelled' || $visit->visit_status == 'skipped')
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
                            <span class="text-muted">Payment Method</span>
                            <div class="text-end">
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

                        {{-- @if (isset($sub_total_new) && $sub_total_new > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span><span class="currency_dhiram"></span>
                                    {{ number_format($sub_total_new, 2) }}</span>
                            </div>
                        @endif --}}
                        @if (isset($order->sub_total) && $order->sub_total > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span><span class="currency_dhiram"></span>
                                    {{ number_format($order->sub_total, 2) }}</span>
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
                @php
                    $driverInfo = null;

                    $orderItem = App\Models\front\CiorderItem::orderId($order->order_id)->first();

                    if ($orderItem && $orderItem->driver_id) {
                        $driverInfo = Helper::driverInfo($orderItem->driver_id);
                    }
                @endphp

                <div class="card shadow-sm border-0 mb-4 border-start border-4 border-success">

                    <!-- Card Header -->
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-semibold text-dark">
                            <i class="fas fa-shuttle-van me-2 text-success"></i>
                            Assigned Driver
                        </h5>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        @if ($driverInfo)
                            <div class="d-flex align-items-center justify-content-between flex-wrap">

                                <!-- Left Section -->
                                <div class="d-flex align-items-center">
                                    <!-- Vendor Info -->
                                    <div>
                                        <h6 class="fw-bold mb-1">
                                            {{ ucfirst(Helper::drivername($driverInfo->id)) }}
                                        </h6>

                                        <div class="small text-muted">
                                            <div>Driver ID: #{{ $driverInfo->id }}</div>
                                            <div>Email: {{ $driverInfo->email ?? 'N/A' }}</div>
                                            <div>Phone:
                                                {{ '+' . $driverInfo->country_code . ' ' . $driverInfo->mobile ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @else
                            <!-- No Vendor Assigned -->
                            <div class="text-center py-4">
                                <i class="fas fa-user-slash fa-2x text-muted mb-3"></i>
                                <h6 class="fw-semibold text-muted">No Driver Assigned</h6>
                            </div>
                        @endif
                    </div>
                </div>

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
            </div>
        </div>
    </div>
@stop
