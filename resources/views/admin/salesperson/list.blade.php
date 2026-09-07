@extends('admin.includes.Template')

@section('content')

    @php

        $userId = Auth::id();

        //
        $get_user_data = Helper::get_user_data($userId);

        // $get_permission_data = Helper::get_permission_data($get_user_data->role_id);

        // $edit_perm = [];

        // if ($get_permission_data->editperm != '') {

        //     $edit_perm = $get_permission_data->editperm;

        //     $edit_perm = explode(',', $edit_perm);

        // }

        $user_data = Auth::user();
        // echo"<pre>";print_r($user_data);echo"</pre>";exit;

        $roleIds = explode(',', $get_user_data->role_id);

        $edit_perm = [];

        foreach ($roleIds as $roleId) {
            $roleId = trim($roleId); // Clean any spaces

            $get_permission_data = Helper::get_permission_data($roleId);

            if (
                is_object($get_permission_data) &&
                property_exists($get_permission_data, 'editperm') &&
                $get_permission_data->editperm != ''
            ) {
                $perms = explode(',', $get_permission_data->editperm);
                $edit_perm = array_merge($edit_perm, $perms); // Combine permissions
            }
        }

        // Optional: remove duplicates and reset array keys
        $edit_perm = array_values(array_unique($edit_perm));

    @endphp

    <style>
        .premium-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
            background: #fff;
            margin-bottom: 24px;
        }

        .premium-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #e9ecef;
        }

        .premium-table thead th {
            background-color: #428df5;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #eef2f5;
            padding: 16px;
            white-space: nowrap;
            border-right: 1px solid rgba(255, 255, 255, 0.3);
        }

        .premium-table thead th:last-child {
            border-right: none;
        }

        .premium-table tbody td {
            padding: 16px;
            vertical-align: middle;
            color: #555;
            border-bottom: 1px solid #e9ecef;
            border-right: 1px solid #e9ecef;
            font-size: 14px;
            transition: background-color 0.2s ease;
        }

        .premium-table tbody td:last-child {
            border-right: none;
        }

        .premium-table tbody tr:hover td {
            background-color: #eaeaea;
        }

        .premium-table tbody tr:hover td:first-child {
            box-shadow: inset 3px 0 0 #ffc107;
        }

        .premium-table tbody tr:hover td:last-child {
            box-shadow: inset -3px 0 0 #ffc107;
        }

        .filter-card {
            border-radius: 12px;
            border: 1px solid #eef2f5;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            background: #fafbfc;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.02);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.15);
        }

        .btn-premium {
            border-radius: 8px;
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 123, 255, 0.3);
        }

        .page-title {
            font-weight: 700;
            color: #2c3e50;
            font-size: 24px;
        }

        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
    </style>




    <div class="content container-fluid">





        <!-- Page Header -->

        <div class="page-header">

            <div class="row align-items-center">

                <div class="col">

                    <h3 class="page-title">Sales Person Report</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>

                        </li>

                        <li class="breadcrumb-item active">Sales Person Report</li>

                    </ul>

                </div>



                @if (in_array('73', $edit_perm))
                    <div class="col-auto">
                        <a class="btn btn-primary shadow-sm me-1" href="javascript:void(0);" id="filter_search">
                            <i class="fas fa-filter"></i>
                        </a>
                    </div>
                @endif





            </div>

        </div>





        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">

                <strong>Success!</strong> {{ $message }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

            </div>
        @endif



        <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">

            <strong>Success! </strong><span id="success_message"></span>

            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->

        </div>

        <form method="post" action="{{ route('filter_data_salesperson') }}" id="filter_data">
            @csrf

            <input type="hidden" name="startdate_fil" id="startdate_fil" value="{{ $startdate ?: '' }}">

            <input type="hidden" name="enddate_fil" id="enddate_fil" value="{{ $enddate ?: '' }}">
            <input type="hidden" name="service_id" id="service_id" value="{{ $filter_service_id ?: '' }}">
            <input type="hidden" name="subservice_id" id="subservice_id" value="{{ $filter_subservice_id ?: '' }}">

            <input type="hidden" name="filter_salesperson_id" id="filter_salesperson_id"
                value="{{ $filter_salesperson_id ?: '' }}">
            <input type="hidden" name="order_type_fil" id="order_type_fil"
                value="{{ isset($filter_order_type) ? $filter_order_type : '' }}">

        </form>


        @php
            $isFilterActive =
                !empty($startdate) ||
                !empty($enddate) ||
                !empty($filter_service_id) ||
                !empty($filter_subservice_id) ||
                !empty($filter_salesperson_id) ||
                !empty($filter_order_type);
        @endphp

        <div id="filter_inputs" class="card filter-card mb-4"
            style="display: {{ $isFilterActive ? 'block' : 'none' }} !important;">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card premium-card mb-0">
                        <div class="card-header pb-0 border-0 bg-white pt-3">
                            <h5 class="card-title mb-0" style="font-size: 16px; font-weight: 600; color: #333;"><i
                                    class="fas fa-filter text-muted me-2"></i> Filter Reports</h5>
                        </div>
                        <div class="card-body">
                            <form id="filter_form" action="{{ route('salesperson_report') }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="filter">
                                <div class="row align-items-end">
                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">Start Date</label>
                                        <input type="date" class="form-control form-control-sm" name="s_date"
                                            id="s_date" value="{{ $startdate }}">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">End Date</label>
                                        <input type="date" class="form-control form-control-sm" name="e_date"
                                            id="e_date" value="{{ $enddate }}">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">Service</label>
                                        <select name="service_id" class="form-control" id="service_id">
                                            <option value="">All</option>
                                            @foreach ($service_data as $serviceData)
                                                <option value="{{ $serviceData->id }}"
                                                    @if ($serviceData->id == $filter_service_id) {{ 'selected' }} @endif>
                                                    {{ $serviceData->servicename }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">Sub Service</label>
                                        <select name="subservice_id" class="form-control" id="subservice_id">
                                            <option value="">All</option>
                                            @foreach ($subservice_data as $subserviceData)
                                                <option value="{{ $subserviceData->id }}"
                                                    @if ($subserviceData->id == $filter_subservice_id) {{ 'selected' }} @endif>
                                                    {{ $subserviceData->subservicename }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @php
                                        if ($user_data->role_id == 16) {
                                            $style = 'display:none;';
                                        } else {
                                            $style = 'display:block;';
                                        }
                                    @endphp

                                    <div class="col-md-2 mb-3" style="{{ $style }}">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">Sales Person</label>
                                        <select name="salesperson_id" class="form-control" id="salesperson_id">
                                            <option value="">All</option>
                                            @foreach ($salesperson as $data)
                                                <option value="{{ $data->id }}"
                                                    @if ($data->id == $filter_salesperson_id) {{ 'selected' }} @endif>
                                                    {{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">Order Type</label>
                                        <select name="order_type" class="form-control form-control-sm" id="order_type">
                                            <option value="">All</option>
                                            <option value="survey" @if (isset($filter_order_type) && $filter_order_type == 'survey') selected @endif>Survey
                                            </option>
                                            <option value="manpower" @if (isset($filter_order_type) && $filter_order_type == 'manpower') selected @endif>
                                                Manpower</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12 text-end mt-2">
                                        <a href="javascript:void(0);" onclick="filter_validation()"
                                            class="btn btn-sm btn-primary px-3 rounded"><i class="fas fa-search"></i>
                                            Search</a>
                                        <a href="{{ route('salesperson_report') }}"
                                            class="btn btn-sm btn-light border px-3 rounded"><i class="fas fa-sync"></i>
                                            Reset</a>

                                        @if (in_array('73', $edit_perm) && $filter_salesperson_id != '')
                                            <a href="javascript:void('0');" onclick="excel_download();" id="excel_btn"
                                                class="btn btn-sm btn-success px-3 rounded ms-2"><i
                                                    class="fas fa-file-excel"></i> Download Excel</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-sm-12">

                <div class="card premium-card">
                    <div class="card-body">
                        <form id="form" action="">
                            @csrf
                            <div class="table-responsive">
                                <table class="table premium-table" id="example">
                                    <thead>
                                        <tr>
                                            <th style="display: none">Sr no</th>
                                            <th>Booking Date</th>
                                            <th>Service Type</th>
                                            <th>Order Id</th>
                                            <th>Sales Person</th>
                                            <th>Customer Details</th>
                                            <th>Vendor Name</th>
                                            <th>Vendor Charge</th>
                                            <th>Agent Comm.</th>
                                            <th>Other Expenses</th>
                                            <th>Vat %</th>
                                            <th>Service Charge</th>
                                            <th>Invoice Amount</th>
                                            <th>Profit</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($salesperson_order_data) && count($salesperson_order_data) > 0)
                                            @foreach ($salesperson_order_data as $salesperson_order)
                                                @php
                                                    $user_data = DB::table('frontloginregisters')
                                                        ->where('id', $salesperson_order->user_info_id)
                                                        ->first();
                                                    $address = '';
                                                    if ($salesperson_order->service_id == '45') {
                                                        // cleaning
                                                        $address =
                                                            $salesperson_order->city .
                                                            ',' .
                                                            $salesperson_order->area .
                                                            ',' .
                                                            $salesperson_order->building_street_no .
                                                            ',' .
                                                            $salesperson_order->apartment_villa_no;
                                                    } elseif ($salesperson_order->service_id == '30') {
                                                        //moving
                                                    }

                                                    if (
                                                        isset($salesperson_order->is_cancelled) &&
                                                        $salesperson_order->is_cancelled
                                                    ) {
                                                        $invoice_amount = 0;
                                                        $vat_amount = 0;
                                                        $base_amount = 0;
                                                        $salesperson_order->service_charge = 0;
                                                    } else {
                                                        $invoice_amount = $salesperson_order->order_total ?? 0;
                                                        $vat_amount = $invoice_amount - $invoice_amount / 1.05;
                                                        $base_amount = $invoice_amount - $vat_amount;
                                                    }

                                                    $vendor_payout = 0;
                                                    $commission = 0;

                                                    if (
                                                        $salesperson_order->vendor_id != 0 &&
                                                        !(
                                                            isset($salesperson_order->is_cancelled) &&
                                                            $salesperson_order->is_cancelled
                                                        )
                                                    ) {
                                                        if (
                                                            !empty($salesperson_order->subservice_booking_amount) &&
                                                            $salesperson_order->subservice_booking_amount > 0
                                                        ) {
                                                            $commission = $salesperson_order->subservice_booking_amount;
                                                            if (
                                                                isset($salesperson_order->extra_charge) &&
                                                                $salesperson_order->extra_charge > 0
                                                            ) {
                                                                $original_invoice =
                                                                    $invoice_amount - $salesperson_order->extra_charge;
                                                                if ($original_invoice > 0) {
                                                                    $original_vat =
                                                                        $original_invoice - $original_invoice / 1.05;
                                                                    $original_base = $original_invoice - $original_vat;
                                                                    if ($original_base > 0) {
                                                                        $percentage = $commission / $original_base;
                                                                        $commission = $base_amount * $percentage;
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            $commission =
                                                                ($base_amount *
                                                                    $salesperson_order->subservice_booking_percentage) /
                                                                100;
                                                        }
                                                        $vendor_payout = $base_amount - $commission;
                                                    }

                                                    $profit = $invoice_amount - $vat_amount - $vendor_payout;
                                                @endphp
                                                <tr>
                                                    <td style="display: none">{{ $salesperson_order->order_id }}</td>
                                                    <td>
                                                        {{ $salesperson_order->visit_date ?? '' }}<br>
                                                        {{ $salesperson_order->visit_day ?? '' }}<br>
                                                        @if (isset($salesperson_order->is_cancelled) && $salesperson_order->is_cancelled)
                                                            <span class="badge bg-danger mt-1">Cancelled</span><br>
                                                        @endif
                                                    </td>
                                                    <td>{!! Helper::servicename($salesperson_order->service_id) !!}
                                                        <br>
                                                        {!! Helper::subservicename($salesperson_order->subservice_id) !!}
                                                    </td>
                                                    <td>{{ $salesperson_order->format_order_id ?? '' }}</td>
                                                    <td>{!! Helper::salesperson($salesperson_order->salesperson_id) !!}</td>
                                                    <td>
                                                        {{ $user_data->name }}<br>
                                                        {{ $user_data->country_code ?? '' }}
                                                        {{ $user_data->mobile ?? '' }}<br>
                                                        {{ $address }}
                                                    </td>
                                                    <td>
                                                        @if ($salesperson_order->vendor_id != '' && $salesperson_order->vendor_id != 0)
                                                            {!! Helper::vendorsname($salesperson_order->vendor_id) !!}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    <td>{{ number_format($vendor_payout, 2, '.', '') }}</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>{{ number_format($vat_amount, 2, '.', '') }}</td>
                                                    <td>{{ !empty($salesperson_order->service_charge) && $salesperson_order->service_charge > 0
                                                        ? $salesperson_order->service_charge
                                                        : $salesperson_order->sub_total }}
                                                    </td>
                                                    <td>{{ number_format($invoice_amount, 2, '.', '') }}</td>
                                                    <td>{{ number_format($profit, 2, '.', '') }}</td>

                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="14">No Data Found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card premium-card">
                    <div class="card-body">
                        <table class="table premium-table">
                            <thead>
                                <tr>
                                    <th colspan="2" class="py-2 text-center" style="font-size: 16px;">Sales Report
                                        Summary
                                    </th>
                                </tr>
                                <tr>
                                    <th>Charges</th>
                                    <th>Total (AED)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_invoice = 0;
                                    $total_service_charge = 0;
                                    $total_vendor_payout = 0;
                                    $total_vat = 0;
                                    $service_grouping = [];

                                    if (isset($salesperson_order_data)) {
                                        foreach ($salesperson_order_data as $order) {
                                            if (isset($order->is_cancelled) && $order->is_cancelled) {
                                                $invoice_amount = 0;
                                                $vat_amount = 0;
                                                $base_amount = 0;
                                                $order->service_charge = 0;
                                            } else {
                                                $invoice_amount = $order->order_total ?? 0;
                                                $vat_amount = $invoice_amount - $invoice_amount / 1.05;
                                                $base_amount = $invoice_amount - $vat_amount;
                                            }

                                            $total_invoice += $invoice_amount;
                                            $total_service_charge += $order->service_charge;
                                            $total_vat += $vat_amount;

                                            // Calculate Vendor Payout
                                            $vendor_payout = 0;
                                            $commission = 0;
                                            if (
                                                $order->vendor_id != 0 &&
                                                !(isset($order->is_cancelled) && $order->is_cancelled)
                                            ) {
                                                if (
                                                    !empty($order->subservice_booking_amount) &&
                                                    $order->subservice_booking_amount > 0
                                                ) {
                                                    $commission = $order->subservice_booking_amount;
                                                    if (isset($order->extra_charge) && $order->extra_charge > 0) {
                                                        $original_invoice = $invoice_amount - $order->extra_charge;
                                                        if ($original_invoice > 0) {
                                                            $original_vat =
                                                                $original_invoice - $original_invoice / 1.05;
                                                            $original_base = $original_invoice - $original_vat;
                                                            if ($original_base > 0) {
                                                                $percentage = $commission / $original_base;
                                                                $commission = $base_amount * $percentage;
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    $commission =
                                                        ($base_amount * $order->subservice_booking_percentage) / 100;
                                                }
                                                $vendor_payout = $base_amount - $commission;
                                                $total_vendor_payout += $vendor_payout;
                                            }

                                            $order_profit = $invoice_amount - $vat_amount - $vendor_payout;

                                            // Grouping by Service for the second table
                                            $sName = Helper::servicename($order->service_id);
                                            if (!isset($service_grouping[$sName])) {
                                                $service_grouping[$sName] = [
                                                    'invoice_amount' => 0,
                                                    'profit' => 0,
                                                    'jobs' => 0,
                                                ];
                                            }
                                            $service_grouping[$sName]['invoice_amount'] += $invoice_amount;
                                            $service_grouping[$sName]['jobs'] += 1;
                                            $service_grouping[$sName]['profit'] += $order_profit;
                                        }
                                    }

                                    // Formula: Profit = Invoice - VAT - Vendor Charges
                                    $total_profit = $total_invoice - $total_vat - $total_vendor_payout;
                                @endphp
                                <tr>
                                    <td class="text-start ps-3">Invoice Amount</td>
                                    <td class="text-end pe-3">{{ number_format($total_invoice, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start ps-3">Service Charge</td>
                                    <td class="text-end pe-3">{{ number_format($total_service_charge, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start ps-3">Vendor Charges</td>
                                    <td class="text-end pe-3">{{ number_format($total_vendor_payout, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start ps-3">VAT</td>
                                    <td class="text-end pe-3">{{ number_format($total_vat, 2) }}</td>
                                </tr>
                                <tr style="background-color: #428df5; font-weight: bold;">
                                    <td class="text-start ps-3" style="color: #ffffff !important;">Total Profit</td>
                                    <td class="text-end pe-3" style="color: #ffffff !important;">
                                        {{ number_format($total_profit, 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card premium-card">
                    <div class="card-body">
                        <table class="table premium-table">
                            <thead>
                                <tr>
                                    <th colspan="5" class="py-2 text-center" style="font-size: 16px;">Service wise
                                        Sales
                                    </th>
                                </tr>
                                <tr>
                                    <th>Services</th>
                                    <th>Invoice Amount</th>
                                    <th>Profit</th>
                                    <th>Percentage %</th>
                                    <th>No. of Jobs</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($service_grouping) > 0)
                                    @foreach ($service_grouping as $name => $data)
                                        @php
                                            $percentage = 0;
                                            if ($data['invoice_amount'] > 0) {
                                                $percentage = ($data['profit'] / $data['invoice_amount']) * 100;
                                            }
                                        @endphp
                                        <tr>
                                            <td class="text-start ps-3">{!! $name !!}</td>
                                            <td class="text-end pe-3">{{ number_format($data['invoice_amount'], 2) }}</td>
                                            <td class="text-end pe-3">{{ number_format($data['profit'], 2) }}</td>
                                            <td class="text-end pe-3">{{ number_format($percentage, 2) }}%</td>
                                            <td class="text-center">{{ $data['jobs'] }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">No Service Data</td>
                                    </tr>
                                @endif
                                <tr style="font-weight: bold; background-color: #f8f9fa;">
                                    <td class="text-start ps-3">Total Sales</td>
                                    <td class="text-end pe-3">{{ number_format($total_invoice, 2) }}</td>
                                    <td class="text-end pe-3">{{ number_format($total_profit, 2) }}</td>
                                    <td class="text-end pe-3">
                                        {{ $total_invoice > 0 ? number_format(($total_profit / $total_invoice) * 100, 2) : '0.00' }}%
                                    </td>
                                    <td class="text-center">
                                        {{ isset($salesperson_order_data) ? count($salesperson_order_data) : 0 }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

@stop
@section('footer_js')



    <!-- Delete  Modal -->

    <div class="modal custom-modal fade" id="delete_model" role="dialog">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-body">

                    <div class="modal-icon text-center mb-3">

                        <i class="fas fa-trash-alt text-danger"></i>

                    </div>

                    <div class="modal-text text-center">

                        <!-- <h3>Delete Expense Category</h3> -->

                        <p>Are you sure want to delete?</p>

                    </div>

                </div>

                <div class="modal-footer text-center">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" onclick="form_sub();">Delete</button>

                </div>

            </div>

        </div>

    </div>

    <!-- /Delete Modal -->



    <!-- Select one record Category Modal -->

    <div class="modal custom-modal fade" id="select_one_record" role="dialog">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-body">

                    <div class="modal-text text-center">

                        <h3>Please select at least one record to delete</h3>

                        <!-- <p>Are you sure want to delete?</p> -->

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- /Select one record Category Modal -->
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "searching": true,
                "paging": true,
                "pageLength": 10,
                "lengthChange": true,
                "info": true,
                "language": {
                    "search": "",
                    "searchPlaceholder": "Quick Search...",
                    "paginate": {
                        "next": '<i class="fas fa-chevron-right"></i>',
                        "previous": '<i class="fas fa-chevron-left"></i>'
                    }
                },
                "dom": '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip><"clear">'
            });
        });
    </script>


    <script>
        function delete_category() {

            // alert('test');

            var checked = $("#form input:checked").length > 0;

            if (!checked) {

                $('#select_one_record').modal('show');

            } else {

                $('#delete_model').modal('show');

            }

        }



        function form_sub() {

            $('#form').submit();

        }

        function excel_download() {
            let btn = $('#excel_btn');
            let originalHTML = btn.html();
            btn.css('pointer-events', 'none');
            btn.html('<i class="fas fa-spinner fa-spin"></i> Downloading...');

            $('#filter_data').submit();

            setTimeout(function() {
                btn.css('pointer-events', 'auto');
                btn.html(originalHTML);
            }, 3000);
        }

        function filter_validation() {

            var cleaner_name = jQuery("#cleaner_name").val();

            if (cleaner_name == '') {
                jQuery('#cleaner_name_error').html("Please Select Cleaner");
                jQuery('#cleaner_name_error').show().delay(0).fadeIn('show');
                jQuery('#cleaner_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#cleaner_name').offset().top - 150
                }, 1000);
                return false;
            }

            $('#filter_form').submit();
        }

        $(document).ready(function() {
            // Initialize Select2 for search and select
            function initSelect2() {
                $('select[name="service_id"], select[name="subservice_id"], select[name="salesperson_id"]')
                    .select2({
                        width: '100%',
                        placeholder: "Search..."
                    });
            }

            initSelect2();

            // Re-initialize if the filter button is clicked, in case it was hidden and width was 0
            $('#filter_search').on('click', function() {
                setTimeout(initSelect2, 100);
            });

            $('select[name="service_id"]').change(function() {
                var service_id = $(this).val();
                if (service_id != '') {
                    $.ajax({
                        url: "{{ route('front.getSubservices', ['city' => 'dubai']) }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            service_ids: [service_id]
                        },
                        success: function(response) {
                            var $subservice_select = $('select[name="subservice_id"]');
                            $subservice_select.empty();
                            $subservice_select.append('<option value="">All</option>');
                            $.each(response, function(index, subservice) {
                                $subservice_select.append('<option value="' + subservice
                                    .id + '">' + subservice.subservicename +
                                    '</option>');
                            });
                            // Re-initialize/update Select2 UI
                            $subservice_select.trigger('change');
                        }
                    });
                } else {
                    var $subservice_select = $('select[name="subservice_id"]');
                    $subservice_select.empty().append('<option value="">All</option>');
                    $subservice_select.trigger('change');
                }
            });
        });
    </script>

@stop
