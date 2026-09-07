@extends('admin.includes.Template')

@section('content')

@php
    $userId = Auth::id();
    $get_user_data = Helper::get_user_data($userId);
    $roleIds = explode(',', $get_user_data->role_id);
    $permission1 = [];

    foreach ($roleIds as $roleId) {
        $roleId = trim($roleId);
        $get_permission_data = Helper::get_permission_data($roleId);

        if (
            is_object($get_permission_data) &&
            property_exists($get_permission_data, 'permission') &&
            $get_permission_data->permission !== ''
        ) {
            $perms = explode(',', $get_permission_data->permission);
            $permission1 = array_merge($permission1, $perms);
        }
    }
    $permission1 = array_unique($permission1);
@endphp

<style>
    .reports-dashboard {
        font-family: 'Inter', 'Roboto', sans-serif;
        background-color: #f8f9fa;
        padding-bottom: 30px;
    }
    .kpi-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background: #fff;
    }
    .kpi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }
    .kpi-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .kpi-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0;
    }
    .kpi-label {
        font-size: 0.875rem;
        color: #64748b;
        font-weight: 500;
    }
    .report-category-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #334155;
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e2e8f0;
    }
    .report-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        height: 100%;
        transition: all 0.3s ease;
    }
    .report-card:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }
    .report-icon-wrapper {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f1f5f9;
        color: #3b82f6;
        margin-bottom: 15px;
    }
    .report-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #0f172a;
    }
    .report-desc {
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 1.5rem;
        flex-grow: 1;
    }
    .filters-section {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
    }
    .chart-placeholder {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-weight: 500;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
        border: 2px dashed #e2e8f0;
    }
    .bg-light-primary { background-color: #eff6ff; color: #2563eb; }
    .bg-light-success { background-color: #f0fdf4; color: #16a34a; }
    .bg-light-warning { background-color: #fffbeb; color: #d97706; }
    .bg-light-danger { background-color: #fef2f2; color: #dc2626; }
    .bg-light-info { background-color: #ecfeff; color: #0891b2; }
    .bg-light-purple { background-color: #faf5ff; color: #9333ea; }
    
</style>

<div class="content container-fluid reports-dashboard">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Reports & Analytics</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Reports</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <h5 class="mb-3"><i data-feather="filter" class="me-2"></i>Global Filters</h5>
        <form method="GET" action="{{ route('reports_dashboard') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Vendor</label>
                    <select class="form-select" name="vendor_id">
                        <option value="">All Vendors</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ request('vendor_id') == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sales Person</label>
                    <select class="form-select" name="sales_person_id">
                        <option value="">All Sales Persons</option>
                        @foreach($sales_persons as $sp)
                            <option value="{{ $sp->id }}" {{ request('sales_person_id') == $sp->id ? 'selected' : '' }}>{{ $sp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Crew</label>
                    <select class="form-select" name="crew_id">
                        <option value="">All Crew</option>
                        @foreach($crews as $crew)
                            <option value="{{ $crew->id }}" {{ request('crew_id') == $crew->id ? 'selected' : '' }}>{{ $crew->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Customer</label>
                    <select class="form-select" name="customer_id">
                        <option value="">All Customers</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Service</label>
                    <select class="form-select" name="service_id">
                        <option value="">All Services</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>{{ $service->servicename ?? $service->name ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">City</label>
                    <select class="form-select" name="city_id">
                        <option value="">All Cities</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Booking Status</label>
                    <select class="form-select" name="status">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-12 text-end mt-3">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('reports_dashboard') }}" class="btn btn-outline-secondary ms-2">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- KPI Summary Cards -->
    <div class="row mb-4">
        <!-- Revenue -->
        <div class="col-xl-3 col-sm-6 col-12 mb-4">
            <div class="kpi-card p-3">
                <div class="d-flex align-items-center">
                    <div class="kpi-icon bg-light-primary me-3">
                        <i data-feather="dollar-sign"></i>
                    </div>
                    <div>
                        <p class="kpi-label">Total Revenue</p>
                        <h4 class="kpi-value">{{ number_format($kpis['total_revenue'] ?? 0, 2) }} AED</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bookings -->
        <div class="col-xl-3 col-sm-6 col-12 mb-4">
            <div class="kpi-card p-3">
                <div class="d-flex align-items-center">
                    <div class="kpi-icon bg-light-success me-3">
                        <i data-feather="calendar"></i>
                    </div>
                    <div>
                        <p class="kpi-label">Total Bookings</p>
                        <h4 class="kpi-value">{{ $kpis['total_bookings'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vendor Commission -->
        <div class="col-xl-3 col-sm-6 col-12 mb-4">
            <div class="kpi-card p-3">
                <div class="d-flex align-items-center">
                    <div class="kpi-icon bg-light-warning me-3">
                        <i data-feather="briefcase"></i>
                    </div>
                    <div>
                        <p class="kpi-label">Vendor Commission</p>
                        <h4 class="kpi-value">{{ number_format($kpis['vendor_commission'] ?? 0, 2) }} AED</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Profit -->
        <div class="col-xl-3 col-sm-6 col-12 mb-4">
            <div class="kpi-card p-3">
                <div class="d-flex align-items-center">
                    <div class="kpi-icon bg-light-success me-3">
                        <i data-feather="pie-chart"></i>
                    </div>
                    <div>
                        <p class="kpi-label">Profit</p>
                        <h4 class="kpi-value">{{ number_format($kpis['profit'] ?? 0, 2) }} AED</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Active Crew -->
        <div class="col-xl-3 col-sm-6 col-12 mb-4">
            <div class="kpi-card p-3">
                <div class="d-flex align-items-center">
                    <div class="kpi-icon bg-light-info me-3">
                        <i data-feather="users"></i>
                    </div>
                    <div>
                        <p class="kpi-label">Active Crew</p>
                        <h4 class="kpi-value">{{ $kpis['active_crew'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Active Sales Persons -->
        <div class="col-xl-3 col-sm-6 col-12 mb-4">
            <div class="kpi-card p-3">
                <div class="d-flex align-items-center">
                    <div class="kpi-icon bg-light-purple me-3">
                        <i data-feather="user-check"></i>
                    </div>
                    <div>
                        <p class="kpi-label">Active Sales Persons</p>
                        <h4 class="kpi-value">{{ $kpis['active_sales_persons'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- New Customers -->
        <div class="col-xl-3 col-sm-6 col-12 mb-4">
            <div class="kpi-card p-3">
                <div class="d-flex align-items-center">
                    <div class="kpi-icon bg-light-primary me-3">
                        <i data-feather="user-plus"></i>
                    </div>
                    <div>
                        <p class="kpi-label">New Customers</p>
                        <h4 class="kpi-value">{{ $kpis['new_customers'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <div class="col-lg-6">
            <div class="chart-placeholder">
                <div class="text-center">
                    <i data-feather="bar-chart-2" class="mb-2" style="width: 32px; height: 32px;"></i>
                    <p>Revenue & Booking Trend (Placeholder)</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-placeholder">
                <div class="text-center">
                    <i data-feather="pie-chart" class="mb-2" style="width: 32px; height: 32px;"></i>
                    <p>Booking Sources (Placeholder)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Categories -->
    
    <!-- 1. Sales & Revenue -->
    <h4 class="report-category-title"><i data-feather="trending-up" class="me-2 text-primary"></i>Sales & Revenue</h4>
    <div class="row g-4">
        @if(in_array('22', $permission1))
        <div class="col-md-4">
            <div class="card report-card p-3 d-flex flex-column">
                <div class="report-icon-wrapper"><i data-feather="file-text"></i></div>
                <h5 class="report-title">Sales Report</h5>
                <p class="report-desc">Detailed overview of all sales, including status and breakdown.</p>
                <div class="d-flex justify-content-between mt-auto">
                    <a href="{{ route('salesreport.index') }}" class="btn btn-sm btn-primary">View Report</a>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">Export</button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">PDF</a></li>
                            <li><a class="dropdown-item" href="#">Excel</a></li>
                            <li><a class="dropdown-item" href="#">CSV</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(in_array('50', $permission1))
        <div class="col-md-4">
            <div class="card report-card p-3 d-flex flex-column">
                <div class="report-icon-wrapper"><i data-feather="sun"></i></div>
                <h5 class="report-title">Day Report</h5>
                <p class="report-desc">Daily breakdown of transactions and activities.</p>
                <div class="d-flex justify-content-between mt-auto">
                    <a href="{{ route('day-report.index') }}" class="btn btn-sm btn-primary">View Report</a>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">Export</button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">PDF</a></li>
                            <li><a class="dropdown-item" href="#">Excel</a></li>
                            <li><a class="dropdown-item" href="#">CSV</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-4">
            <div class="card report-card p-3 d-flex flex-column">
                <div class="report-icon-wrapper"><i data-feather="calendar"></i></div>
                <h5 class="report-title">Monthly/Yearly Sales</h5>
                <p class="report-desc">Aggregated sales data for monthly and yearly analysis.</p>
                <div class="d-flex justify-content-between mt-auto">
                    <a href="#" class="btn btn-sm btn-primary disabled">Coming Soon</a>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Financial & Vendor Reports -->
    <h4 class="report-category-title"><i data-feather="dollar-sign" class="me-2 text-success"></i>Financial & Vendor Reports</h4>
    <div class="row g-4">
        @if(in_array('33', $permission1))
        <div class="col-md-4">
            <div class="card report-card p-3 d-flex flex-column">
                <div class="report-icon-wrapper"><i data-feather="percent"></i></div>
                <h5 class="report-title">Vendor Commission Report</h5>
                <p class="report-desc">Track and calculate vendor commissions across bookings.</p>
                <div class="d-flex justify-content-between mt-auto">
                    <a href="{{ route('vendor-commission-report') }}" class="btn btn-sm btn-primary">View Report</a>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">Export</button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Excel</a></li>
                            <li><a class="dropdown-item" href="#">CSV</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(in_array('36', $permission1))
        <div class="col-md-4">
            <div class="card report-card p-3 d-flex flex-column">
                <div class="report-icon-wrapper"><i data-feather="credit-card"></i></div>
                <h5 class="report-title">Vendor Subscription Report</h5>
                <p class="report-desc">Monitor vendor subscription statuses and payments.</p>
                <div class="d-flex justify-content-between mt-auto">
                    <a href="{{ route('vendorsubscriptionreport') }}" class="btn btn-sm btn-primary">View Report</a>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">Export</button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Excel</a></li>
                            <li><a class="dropdown-item" href="#">CSV</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-4">
            <div class="card report-card p-3 d-flex flex-column">
                <div class="report-icon-wrapper"><i data-feather="book-open"></i></div>
                <h5 class="report-title">Expense Report</h5>
                <p class="report-desc">Detailed accounting of business expenses.</p>
                <div class="d-flex justify-content-between mt-auto">
                    <a href="#" class="btn btn-sm btn-primary disabled">Coming Soon</a>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Team Reports -->
    <h4 class="report-category-title"><i data-feather="users" class="me-2 text-info"></i>Team Reports</h4>
    <div class="row g-4">
        @if(in_array('37', $permission1))
        <div class="col-md-4">
            <div class="card report-card p-3 d-flex flex-column">
                <div class="report-icon-wrapper"><i data-feather="tool"></i></div>
                <h5 class="report-title">Crew Report</h5>
                <p class="report-desc">Monitor crew assignments, productivity, and ratings.</p>
                <div class="d-flex justify-content-between mt-auto">
                    <a href="{{ route('cleaner-report') }}" class="btn btn-sm btn-primary">View Report</a>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">Export</button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Excel</a></li>
                            <li><a class="dropdown-item" href="#">CSV</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(in_array('73', $permission1))
        <div class="col-md-4">
            <div class="card report-card p-3 d-flex flex-column">
                <div class="report-icon-wrapper"><i data-feather="user-check"></i></div>
                <h5 class="report-title">Sales Person Report</h5>
                <p class="report-desc">Track sales person performance, leads assigned, and conversion rate.</p>
                <div class="d-flex justify-content-between mt-auto">
                    <a href="{{ route('salesperson_report') }}" class="btn btn-sm btn-primary">View Report</a>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">Export</button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Excel</a></li>
                            <li><a class="dropdown-item" href="#">CSV</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-4">
            <div class="card report-card p-3 d-flex flex-column">
                <div class="report-icon-wrapper"><i data-feather="clock"></i></div>
                <h5 class="report-title">Attendance Report</h5>
                <p class="report-desc">Track attendance and shift completion for all staff.</p>
                <div class="d-flex justify-content-between mt-auto">
                    <a href="#" class="btn btn-sm btn-primary disabled">Coming Soon</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 4. Booking Reports -->
    <h4 class="report-category-title"><i data-feather="briefcase" class="me-2 text-warning"></i>Booking Reports</h4>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card report-card p-3 d-flex flex-column">
                <div class="report-icon-wrapper"><i data-feather="check-square"></i></div>
                <h5 class="report-title">Booking Summary</h5>
                <p class="report-desc">High level summary of all incoming, completed, and pending bookings.</p>
                <div class="d-flex justify-content-between mt-auto">
                    <a href="#" class="btn btn-sm btn-primary disabled">Coming Soon</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card report-card p-3 d-flex flex-column">
                <div class="report-icon-wrapper text-danger"><i data-feather="x-circle"></i></div>
                <h5 class="report-title">Cancelled Bookings</h5>
                <p class="report-desc">Track cancellations, reasons, and lost revenue.</p>
                <div class="d-flex justify-content-between mt-auto">
                    <a href="#" class="btn btn-sm btn-primary disabled">Coming Soon</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card report-card p-3 d-flex flex-column">
                <div class="report-icon-wrapper"><i data-feather="map-pin"></i></div>
                <h5 class="report-title">City-wise Bookings</h5>
                <p class="report-desc">Geographical breakdown of your booking volume.</p>
                <div class="d-flex justify-content-between mt-auto">
                    <a href="#" class="btn btn-sm btn-primary disabled">Coming Soon</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 5. Marketing Reports -->
    <h4 class="report-category-title"><i data-feather="target" class="me-2 text-danger"></i>Marketing Reports</h4>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card report-card p-3 d-flex flex-column">
                <div class="report-icon-wrapper"><i data-feather="speaker"></i></div>
                <h5 class="report-title">Marketing ROI</h5>
                <p class="report-desc">Return on investment for advertisement campaigns.</p>
                <div class="d-flex justify-content-between mt-auto">
                    <a href="#" class="btn btn-sm btn-primary disabled">Coming Soon</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card report-card p-3 d-flex flex-column">
                <div class="report-icon-wrapper"><i data-feather="user-plus"></i></div>
                <h5 class="report-title">Cost Per Lead</h5>
                <p class="report-desc">Analyze acquisition cost metrics over time.</p>
                <div class="d-flex justify-content-between mt-auto">
                    <a href="#" class="btn btn-sm btn-primary disabled">Coming Soon</a>
                </div>
            </div>
        </div>
    </div>
    
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if(typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>

@endsection
