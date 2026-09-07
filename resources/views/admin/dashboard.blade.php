@extends('admin.includes.Template')
@section('content')
    <style>
        .currency_dhiram {
            display: inline-block;
            width: 18px;
            height: 18px;

            background-color: currentColor;

            -webkit-mask: url('{{ asset('public/site/icons/dirham.svg') }}') no-repeat center;
            mask: url('{{ asset('public/site/icons/dirham.svg') }}') no-repeat center;

            -webkit-mask-size: contain;
            mask-size: contain;
        }
    </style>
    <div class="content container-fluid">

        @if ($message = Session::get('login_success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <div class="ms-2"><strong>Welcome back!</strong> {{ $message }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title text-dark fw-bold">Admin Dashboard</h3>
                    <ul class="breadcrumb">
                        {{-- <li class="breadcrumb-item active"><a href="{{ url('/admin') }}">Home</a></li> --}}
                        {{-- <li class="breadcrumb-item active">Statistics</li> --}}
                    </ul>
                </div>
            </div>
        </div>

        @php
            $service_count = DB::table('services')->count();
            $vendors_count = DB::table('users')->where('vendor', 1)->count();
            $customers_count = DB::table('frontloginregisters')->count();
            $leads_count = DB::table('packages_enquiry')->count();

            $services = DB::table('ci_order_item as oi')
                ->join('services as s', 's.id', '=', 'oi.service_id')
                ->select('s.servicename', DB::raw('COUNT(oi.service_id) as total'))
                ->groupBy('s.id', 's.servicename')
                ->get();

            $serviceLabels = $services->pluck('servicename');
            $serviceCounts = $services->pluck('total');
        @endphp

        {{-- Leads Query --}}
        @php
            $movingLeadCount = DB::table('packages_enquiry')->where('service_id', 30)->count();
            $storageLeadCount = DB::table('packages_enquiry')->where('service_id', 44)->count();
            $gardenLeadCount = DB::table('garden_enquiry')->where('service', 47)->count();
            $paintingLeadCount = DB::table('painting_enquiry')->where('service_id', 34)->count();
            $woodenFloorLeadCount = DB::table('wooden_floor_enquiry')->count();

        @endphp

        <div class="row">

            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card dash-widget-card bg-white w-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="dash-icon bg-soft-primary">
                                <i class="fas fa-concierge-bell"></i>
                            </div>
                            <div class="dash-info text-end">
                                <p class="text-muted mb-1 stat-label">Services</p>
                                <h3 class="fw-bold mb-0 stat-value">{{ $service_count }}</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('service.index') }}" class="btn btn-sm btn-dash-action w-100">
                                View Details <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card dash-widget-card bg-white w-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="dash-icon bg-soft-success">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="dash-info text-end">
                                <p class="text-muted mb-1 stat-label">Vendors</p>
                                <h3 class="fw-bold mb-0 stat-value">{{ $vendors_count }}</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('vendors.index') }}" class="btn btn-sm btn-dash-action w-100">
                                Manage Vendors <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card dash-widget-card bg-white w-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="dash-icon bg-soft-info">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="dash-info text-end">
                                <p class="text-muted mb-1 stat-label">Customers</p>
                                <h3 class="fw-bold mb-0 stat-value">{{ $customers_count }}</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('frontuser.index') }}" class="btn btn-sm btn-dash-action w-100">
                                User List <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-xl-3 col-sm-6 col-12 d-flex d-none">
                <div class="card dash-widget-card bg-white w-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="dash-icon bg-soft-warning">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="dash-info text-end">
                                <p class="text-muted mb-1 stat-label">Total Leads</p>
                                <h3 class="fw-bold mb-0 stat-value">{{ $leads_count }}</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('enquiry.index') }}" class="btn btn-sm btn-dash-action w-100">
                                Check Leads <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @php

                $today = strtotime(date('Y-m-d'));
                // $today = "2026-03-11";
                // $today = strtotime($today);

                $current_start = strtotime('-1 month +1 day', $today);
                $current_end = $today;

                $last_start = strtotime('-2 month +1 day', $today);
                $last_end = strtotime('-1 month', $today);

                $orders = DB::table('ci_orders as o')
                    ->join('ci_order_item as oi', 'oi.order_id', '=', 'o.order_id')
                    ->select(
                        'o.order_status',
                        'o.order_total',
                        'oi.bookingdate',
                        'oi.month',
                        'oi.bookingyear',
                        'oi.end_date',
                        'oi.which_day_of_the_week_do_you_want_the_service',
                    )
                    ->where('o.order_status', 'CO')
                    ->get();

                $current_sales = 0;
                $last_sales = 0;

                foreach ($orders as $order) {
                    $start_date = strtotime($order->bookingdate . ' ' . $order->month . ' ' . $order->bookingyear);
                    $end_date = !empty($order->end_date) ? strtotime($order->end_date) : $start_date;

                    if (!$start_date) {
                        continue;
                    }

                    $service_days = [];

                    if (!empty($order->which_day_of_the_week_do_you_want_the_service)) {
                        $service_days = array_map(
                            'trim',
                            explode(',', $order->which_day_of_the_week_do_you_want_the_service),
                        );
                    }

                    // ONE TIME SERVICE
                    if (empty($service_days)) {
                        if ($start_date >= $current_start && $start_date <= $current_end) {
                            $current_sales += $order->order_total;
                        }

                        if ($start_date >= $last_start && $start_date <= $last_end) {
                            $last_sales += $order->order_total;
                        }

                        continue;
                    }

                    // RECURRING SERVICES
                    for ($date = $start_date; $date <= $end_date; $date = strtotime('+1 day', $date)) {
                        $day_name = date('l', $date);

                        if (!in_array($day_name, $service_days)) {
                            continue;
                        }

                        if ($date >= $current_start && $date <= $current_end) {
                            $current_sales += $order->order_total;
                        }

                        if ($date >= $last_start && $date <= $last_end) {
                            $last_sales += $order->order_total;
                        }
                    }
                }

                // echo "<pre>";print_r($current_sales);
                // echo "<pre>";print_r($last_sales);

                $percentage = 0;

                if ($last_sales > 0) {
                    $percentage = (($current_sales - $last_sales) / $last_sales) * 100;
                }

                $percentage = round($percentage, 2);
                $progress = min(abs($percentage), 100);

            @endphp

            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card dash-widget-card bg-white w-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="dash-icon bg-soft-info">
                                {{-- <i class="fas fa-dollar-sign"></i> --}}
                                <span class="currency_dhiram"></span>
                            </div>
                            <div class="dash-info text-end">
                                <p class="text-muted mb-1 stat-label">Sales Amount</p>
                                <h3 class="fw-bold mb-0 stat-value">{{ number_format($current_sales, 2) }}</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="progress progress-sm mt-3">
                                <div class="progress-bar bg-5" role="progressbar" style="width: {{ $progress }}%">
                                </div>
                            </div>

                            <p class="text-muted mt-3 mb-0">

                                @if ($percentage >= 0)
                                    <span class="text-success me-1">
                                        <i class="fas fa-arrow-up me-1"></i>{{ $percentage }}%
                                    </span>
                                @else
                                    <span class="text-danger me-1">
                                        <i class="fas fa-arrow-down me-1"></i>{{ abs($percentage) }}%
                                    </span>
                                @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @php

            $current_year = date('Y');
            $current_month = date('n');

            $orders = DB::table('ci_orders as o')
                ->join('ci_order_item as oi', 'oi.order_id', '=', 'o.order_id')
                ->select(
                    'o.order_status',
                    'o.order_total',
                    'o.sub_total',
                    'o.vendor_id',
                    'oi.subservice_booking_percentage',
                    'oi.bookingdate',
                    'oi.month',
                    'oi.bookingyear',
                    'oi.end_date',
                    'oi.which_day_of_the_week_do_you_want_the_service',
                )
                ->get();

            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            $receivedArray = array_fill(0, 12, 0);
            $pendingArray = array_fill(0, 12, 0);

            $total_sales = 0;
            $vendor_charge = 0;

            $current_month_sales = 0;
            $current_month_vendor = 0;

            foreach ($orders as $order) {
                $start_date = strtotime($order->bookingdate . ' ' . $order->month . ' ' . $order->bookingyear);
                $end_date = !empty($order->end_date) ? strtotime($order->end_date) : $start_date;

                if (!$start_date) {
                    continue;
                }

                $service_days = [];

                if (!empty($order->which_day_of_the_week_do_you_want_the_service)) {
                    $service_days = array_map(
                        'trim',
                        explode(',', $order->which_day_of_the_week_do_you_want_the_service),
                    );
                }

                $vendor_payout = 0;

                if ($order->vendor_id != 0 && $order->subservice_booking_percentage > 0) {
                    $commission = ($order->sub_total * $order->subservice_booking_percentage) / 100;

                    $vendor_payout = $order->sub_total - $commission;
                }

                // ONE TIME SERVICES
                if (empty($service_days)) {
                    $month_index = date('n', $start_date) - 1;

                    if ($order->order_status == 'CO') {
                        $receivedArray[$month_index] += $order->order_total;
                        $total_sales += $order->order_total;
                        $vendor_charge += $vendor_payout;

                        if (date('Y', $start_date) == $current_year && date('n', $start_date) == $current_month) {
                            $current_month_sales += $order->order_total;
                            $current_month_vendor += $vendor_payout;
                        }
                    } else {
                        if ($order->order_status != 'CL') {
                            $pendingArray[$month_index] += $order->order_total;
                        }
                    }

                    continue;
                }

                // RECURRING SERVICES
                for ($date = $start_date; $date <= $end_date; $date = strtotime('+1 day', $date)) {
                    $day_name = date('l', $date);

                    if (!in_array($day_name, $service_days)) {
                        continue;
                    }

                    $month_index = date('n', $date) - 1;

                    if ($order->order_status == 'CO') {
                        $receivedArray[$month_index] += $order->order_total;
                        $total_sales += $order->order_total;
                        $vendor_charge += $vendor_payout;

                        if (date('Y', $date) == $current_year && date('n', $date) == $current_month) {
                            $current_month_sales += $order->order_total;
                            $current_month_vendor += $vendor_payout;
                        }
                    } else {
                        $pendingArray[$month_index] += $order->order_total;
                    }
                }
            }

            $current_month_profit = $current_month_sales - $current_month_vendor;

            // Format values
            $total_sales = number_format($total_sales, 2, '.', '');
            $vendor_charge = number_format($vendor_charge, 2, '.', '');
            $current_month_sales = number_format($current_month_sales, 2, '.', '');
            $current_month_vendor = number_format($current_month_vendor, 2, '.', '');
            $current_month_profit = number_format($current_month_profit, 2, '.', '');

            $receivedArray = array_map(fn($v) => number_format($v, 2, '.', ''), $receivedArray);
            $pendingArray = array_map(fn($v) => number_format($v, 2, '.', ''), $pendingArray);

        @endphp

        <div class="row">
            <div class="col-xl-7 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Orders Analytics</h5>

                            {{-- <div class="dropdown">
                                <button class="btn btn-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Monthly
                                </button>
                                <ul class="dropdown-menu d-none" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">Weekly</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">Monthly</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">Yearly</a>
                                    </li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap">
                            <div class="w-md-100 d-flex align-items-center mb-3">
                                <div>
                                    <span>Total Sales</span>
                                    <p class="h3 text-primary me-5">{{ $current_month_sales }}</p>
                                </div>
                                <div>
                                    <span>Vendor Charge</span>
                                    <p class="h3 text-danger me-5">{{ $current_month_vendor }}</p>
                                </div>
                                <div>
                                    <span>Profit</span>
                                    <p class="h3 text-dark me-5">{{ $current_month_profit }}</p>
                                </div>
                            </div>
                        </div>

                        <div id="booking_column_chart"></div>
                    </div>
                </div>
            </div>
            {{-- Orders Pie Chart --}}
            <div class="col-xl-5 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Services Order</h5>

                        </div>
                    </div>
                    <div class="card-body">
                        <div id="serviceCount"></div>

                    </div>
                </div>
            </div>


        </div>
        @php
            $recentorders = DB::table('ci_orders as o')
                ->join('ci_order_item as oi', 'oi.order_id', '=', 'o.order_id')
                ->join('frontloginregisters as u', 'u.id', '=', 'o.user_id')
                ->select(
                    'o.*',
                    'oi.subservice_booking_percentage',
                    'oi.bookingdate',
                    'oi.month',
                    'oi.bookingyear',
                    'oi.end_date',
                    'oi.service_id as service_id',
                    'oi.which_day_of_the_week_do_you_want_the_service',
                    'u.name as username',
                    'u.mobile as usermobile',
                )
                ->orderBy('o.order_id', 'desc')
                ->limit(5)
                ->get();

            // echo "<pre>";print_r( $recentorders);

        @endphp

        <div class="row">
            <div class="col-md-7 col-sm-7">
                @if (isset($recentorders) && count($recentorders) > 0)
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title">Recent Bookings</h5>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">


                            <div class="table-responsive">

                                <table class="table table-stripped table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Booking Date</th>
                                            <th>Status</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentorders as $recentordersData)
                                            <tr>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        {{ $recentordersData->username }}
                                                    </h2>
                                                </td>
                                                <td>{{ $recentordersData->order_total }}</td>
                                                <td>{{ $recentordersData->bookingdate }},{{ $recentordersData->month }},{{ $recentordersData->bookingyear }}
                                                </td>
                                                @php
                                                    $status = [
                                                        'BK' => ['Booking Requested', 'warning'],
                                                        'P' => ['Booking Confirmed', 'info'],
                                                        'PA' => ['Vendor Assigned', 'primary'],
                                                        'CO' => ['Booking Completed', 'success'],
                                                        'CL' => ['Booking Cancelled', 'danger'],
                                                    ];

                                                    $current = $status[$recentordersData->order_status] ?? [
                                                        'Unknown',
                                                        'secondary',
                                                    ];
                                                @endphp

                                                <td>
                                                    <span class="badge bg-{{ $current[1] }}-light">
                                                        {{ $current[0] }}
                                                    </span>
                                                </td>
                                                <td class="text-right">
                                                    @php
                                                        $routes = [
                                                            34 => 'painting-detail',
                                                            45 => 'cleaning-detail',
                                                            71 => 'handyman-detail',
                                                        ];

                                                        $route =
                                                            $routes[$recentordersData->service_id] ?? 'moving-detail';
                                                    @endphp

                                                    <a class="dropdown-item"
                                                        href="{{ route($route, [$recentordersData->order_id]) }}">
                                                        <i class="far fa-eye me-2"></i>Details
                                                    </a>
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


            {{-- Leads Pie Chart --}}
            <div class="col-xl-5 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Services Leads</h5>

                        </div>
                    </div>
                    <div class="card-body">
                        <div id="leadCount"></div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        /* Custom CSS for Kanaku Theme Enhancement */

        /* Soft Backgrounds for Icons */
        .bg-soft-primary {
            background-color: rgba(67, 97, 238, 0.1);
            color: #4361ee;
        }

        .bg-soft-success {
            background-color: rgba(42, 157, 143, 0.1);
            color: #2a9d8f;
        }

        .bg-soft-info {
            background-color: rgba(72, 202, 228, 0.1);
            color: #0077b6;
        }

        .bg-soft-warning {
            background-color: rgba(255, 183, 3, 0.1);
            color: #fb8500;
        }

        .dash-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 20px;
            transition: all 0.3s ease;
        }

        /* Card Hover Logic */
        .dash-widget-card {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
        }

        .dash-widget-card:hover {
            background-color: #4361ee !important;
            /* Kanaku Primary Blue */
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2) !important;
        }

        /* Change text to white on card hover */
        .dash-widget-card:hover .stat-label,
        .dash-widget-card:hover .stat-value,
        .dash-widget-card:hover .btn-dash-action {
            color: #ffffff !important;
        }

        /* Button Styling */
        .btn-dash-action {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 500;
            border: none;
            padding: 8px;
            transition: all 0.3s ease;
        }

        .dash-widget-card:hover .btn-dash-action {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Icon movement on hover */
        .dash-widget-card:hover .dash-icon {
            background-color: rgba(255, 255, 255, 0.3);
            color: #fff !important;
            transform: scale(1.1);
        }

        .breadcrumb-item a {
            color: #4361ee;
            text-decoration: none;
        }
    </style>

@stop

@section('footer_js')
    <script>
        // Orders Pie Chart
        $(document).ready(function() {

            var serviceLabels = @json($serviceLabels);
            var serviceCounts = @json($serviceCounts);

            // Professional Color Palette
            var dynamicColors = [
                '#7638ff', '#ff737b', '#fda600', '#1ec1b0',
                '#28a745', '#dc3545', '#17a2b8', '#ffc107',
                '#6f42c1', '#20c997', '#fd7e14', '#343a40'
            ];

            var pieCtx = document.getElementById("serviceCount");

            var pieConfig = {
                series: serviceCounts,
                chart: {
                    fontFamily: 'Poppins, sans-serif',
                    height: 350,
                    type: 'donut',
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                colors: dynamicColors.slice(0, serviceLabels.length),
                labels: serviceLabels,
                stroke: {
                    width: 2,
                    colors: ['#fff']
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: "vertical",
                        shadeIntensity: 0.5,
                        opacityFrom: 0.9,
                        opacityTo: 1,
                        stops: [0, 100]
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val.toFixed(1) + "%";
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + " Orders";
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                name: {
                                    show: false // Hide changing service name
                                },
                                value: {
                                    show: false // Hide changing value
                                },
                                total: {
                                    show: true,
                                    label: 'Total Orders',
                                    fontSize: '18px',
                                    fontWeight: 700,
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 280
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var pieChart = new ApexCharts(pieCtx, pieConfig);
            pieChart.render();

        });

        // Leads Pie Chart
        $(document).ready(function() {

            let movingLeadCount = @json($movingLeadCount ?? 0);
            let storageLeadCount = @json($storageLeadCount ?? 0);
            let gardenLeadCount = @json($gardenLeadCount ?? 0);
            let paintingLeadCount = @json($paintingLeadCount ?? 0);
            let woodenFloorLeadCount = @json($woodenFloorLeadCount ?? 0);

            var serviceLabels = ['Moving', 'Storage', 'Garden & Mouse', 'Painting', 'Wooden Floor Polishing'];
            var serviceCounts = [movingLeadCount, storageLeadCount, gardenLeadCount, paintingLeadCount,
                woodenFloorLeadCount
            ];

            // Professional Color Palette
            var dynamicColors = [
                '#7638ff', '#ff737b', '#fda600', '#1ec1b0', '#28a745'
            ];

            var pieCtx = document.getElementById("leadCount");

            var pieConfig = {
                series: serviceCounts,
                chart: {
                    fontFamily: 'Poppins, sans-serif',
                    height: 350,
                    type: 'donut',
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                colors: dynamicColors.slice(0, serviceLabels.length),
                labels: serviceLabels,
                stroke: {
                    width: 2,
                    colors: ['#fff']
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: "vertical",
                        shadeIntensity: 0.5,
                        opacityFrom: 0.9,
                        opacityTo: 1,
                        stops: [0, 100]
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val.toFixed(1) + "%";
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + " Orders";
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                name: {
                                    show: false // Hide changing service name
                                },
                                value: {
                                    show: false // Hide changing value
                                },
                                total: {
                                    show: true,
                                    label: 'Total Orders',
                                    fontSize: '18px',
                                    fontWeight: 700,
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 280
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var pieChart = new ApexCharts(pieCtx, pieConfig);
            pieChart.render();

        });

        // Column Chart For Booking Orders
        $(document).ready(function() {

            var receivedData = @json($receivedArray);
            var pendingData = @json($pendingArray);
            var months = @json($months);


            var columnCtx = document.getElementById("booking_column_chart");

            var columnConfig = {
                colors: ['#1F6EEC', '#FF0000'],
                series: [{
                        name: "Received",
                        type: "column",
                        data: receivedData
                    },
                    {
                        name: "Pending",
                        type: "column",
                        data: pendingData
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '60%',
                        endingShape: 'rounded'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: months
                },
                yaxis: {
                    title: {
                        text: 'Order Amount'
                    }
                },
                tooltip: {
                    enabled: true,
                    custom: function({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) {
                        // Get the value of the current data point
                        var value = series[seriesIndex][dataPointIndex];
                        // Get the series name (Received or Pending)
                        var seriesName = w.globals.seriesNames[seriesIndex];

                        return (
                            '<div class="p-2" style="background: #fff; border: 1px solid #ccc; border-radius: 4px;">' +
                            '<strong>' + seriesName + '</strong>: ' +
                            '<div style="display: flex; align-items: center; gap: 4px;">' +
                            '<span class="currency_dhiram"></span>' +
                            '<span>' + value.toLocaleString() + '</span>' +
                            '</div>' +
                            '</div>'
                        );
                    }
                }
            };

            var columnChart = new ApexCharts(columnCtx, columnConfig);
            columnChart.render();
        });
    </script>
@stop
