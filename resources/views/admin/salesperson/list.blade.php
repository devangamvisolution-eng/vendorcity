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
        }

        .premium-table thead th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #eef2f5;
            padding: 16px;
            white-space: nowrap;
        }

        .premium-table tbody td {
            padding: 16px;
            vertical-align: middle;
            color: #555;
            border-bottom: 1px solid #f1f3f5;
            font-size: 14px;
        }

        .premium-table tbody tr {
            transition: all 0.2s ease;
        }

        .premium-table tbody tr:hover {
            background-color: #fcfcfc;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
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

                        @if ($filter_salesperson_id != '')
                            <a class="btn btn-primary btn-premium me-1" href="javascript:void('0');"
                                onclick="excel_download();"><i class="fas fa-file-excel"></i> Excel Download</a>
                        @endif

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

        </form>


        <div id="filter_inputs" class="card filter-card" style="display: block !important;">

            <div class="card-body pb-0">
                <form id="filter_form" action="{{ route('salesperson_report') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="filter">

                    <div class="row">

                        <div class="col-sm-6 col-md-8">
                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="date" class="form-control" name="s_date" id="s_date"
                                            placeholder="Enter Start Date" value="{{ $startdate }}">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" class="form-control" name="e_date" id="e_date"
                                            placeholder="Enter End Date" value="{{ $enddate }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Select Service</label>
                                        <select name="service_id" class="form-control form-select" id="service_id">
                                            <option value="">Select Service</option>

                                            @foreach ($service_data as $serviceData)
                                                <option value="{{ $serviceData->id }}"
                                                    @if ($serviceData->id == $filter_service_id) {{ 'selected' }} @endif>
                                                    {{ $serviceData->servicename }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="service_id_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Select Sub Service</label>
                                        <select name="subservice_id" class="form-control form-select" id="subservice_id">
                                            <option value="">Select Sub Service</option>

                                            @foreach ($subservice_data as $subserviceData)
                                                <option value="{{ $subserviceData->id }}"
                                                    @if ($subserviceData->id == $filter_subservice_id) {{ 'selected' }} @endif>
                                                    {{ $subserviceData->subservicename }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="subservice_id_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                @php

                                    if ($user_data->role_id == 16) {
                                        $style = 'display:none;';
                                    } else {
                                        $style = 'display:block;';
                                    }
                                @endphp

                                <div class="col-lg-4" style="{{ $style }}">
                                    <div class="form-group">
                                        <label>Select Sales Person</label>
                                        <select name="salesperson_id" class="form-control form-select"
                                            id="salesperson_id">
                                            <option value="">Select Sales Person</option>

                                            @foreach ($salesperson as $data)
                                                <option value="{{ $data->id }}"
                                                    @if ($data->id == $filter_salesperson_id) {{ 'selected' }} @endif>
                                                    {{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="salesperson_id_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-4">
                            <div class="form-group">
                                <a class="btn btn-primary btn-premium filter-btn" href="javascript:void(0);"
                                    style="margin-top: 22px;" onclick="filter_validation()">Submit</a>

                                <a class="btn btn-secondary btn-premium filter-btn"
                                    href="{{ route('salesperson_report') }}"
                                    style="margin-top: 22px; background: #6c757d; color: white;">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
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

                                                    $vendor_payout = 0;
                                                    $commission = 0;

                                                    if (
                                                        $salesperson_order->vendor_id != 0 &&
                                                        $salesperson_order->subservice_booking_percentage > 0
                                                    ) {
                                                        if (
                                                            !empty($salesperson_order->subservice_booking_amount) &&
                                                            $salesperson_order->subservice_booking_amount > 0
                                                        ) {
                                                            $commission = $salesperson_order->subservice_booking_amount;
                                                        } else {
                                                            $commission =
                                                                ($salesperson_order->sub_total *
                                                                    $salesperson_order->subservice_booking_percentage) /
                                                                100;
                                                        }

                                                        $vendor_payout = $salesperson_order->sub_total - $commission;
                                                    }

                                                    $profit = $salesperson_order->service_charge - $vendor_payout;
                                                @endphp
                                                <tr>
                                                    <td style="display: none">{{ $salesperson_order->order_id }}</td>
                                                    <td>
                                                        {{ $salesperson_order->visit_date ?? '' }}<br>
                                                        {{ $salesperson_order->visit_day ?? '' }}<br>
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

                                                    <td>{{ $vendor_payout }}</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>{{ $salesperson_order->vatcharge }}</td>
                                                    <td>{{ $salesperson_order->service_charge }}</td>
                                                    <td>{{ $salesperson_order->order_total }}</td>
                                                    <td>{{ $profit }}</td>

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
                                        Summary</th>
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
                                            $total_invoice += $order->order_total;
                                            $total_service_charge += $order->service_charge;
                                            $total_vat += $order->vatcharge;

                                            // Calculate Vendor Payout
                                            $vendor_payout = 0;
                                            if (
                                                $order->vendor_id != 0 &&
                                                ($order->subservice_booking_percentage > 0 ||
                                                    $order->subservice_booking_amount > 0)
                                            ) {
                                                if (
                                                    !empty($order->subservice_booking_amount) &&
                                                    $order->subservice_booking_amount > 0
                                                ) {
                                                    $commission = $order->subservice_booking_amount;
                                                } else {
                                                    $commission =
                                                        ($order->sub_total * $order->subservice_booking_percentage) /
                                                        100;
                                                }
                                                $vendor_payout = $order->sub_total - $commission;
                                                $total_vendor_payout += $vendor_payout;
                                            }

                                            // Grouping by Service for the second table
                                            $sName = Helper::servicename($order->service_id);
                                            if (!isset($service_grouping[$sName])) {
                                                $service_grouping[$sName] = [
                                                    'invoice_amount' => 0,
                                                    'profit' => 0,
                                                    'jobs' => 0,
                                                ];
                                            }
                                            $service_grouping[$sName]['invoice_amount'] += $order->order_total;
                                            $service_grouping[$sName]['jobs'] += 1;

                                            $order_vendor_payout = 0;
                                            if (
                                                $order->vendor_id != 0 &&
                                                ($order->subservice_booking_percentage > 0 ||
                                                    $order->subservice_booking_amount > 0)
                                            ) {
                                                if (
                                                    !empty($order->subservice_booking_amount) &&
                                                    $order->subservice_booking_amount > 0
                                                ) {
                                                    $commission = $order->subservice_booking_amount;
                                                } else {
                                                    $commission =
                                                        ($order->sub_total * $order->subservice_booking_percentage) /
                                                        100;
                                                }
                                                $order_vendor_payout = $order->sub_total - $commission;
                                            }
                                            $order_profit = $order->service_charge - $order_vendor_payout;
                                            $service_grouping[$sName]['profit'] += $order_profit;
                                        }
                                    }

                                    // Formula: Profit = Service Charges - Vendor Charges
                                    $total_profit = $total_service_charge - $total_vendor_payout;
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
                                <tr style="background-color: #0040E6; color: #ffffff; font-weight: bold;">
                                    <td class="text-start ps-3">Total Profit</td>
                                    <td class="text-end pe-3">{{ number_format($total_profit, 2) }}</td>
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
                                        Sales</th>
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
                                        {{ isset($salesperson_order_data) ? count($salesperson_order_data) : 0 }}</td>
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
                "info": false,
                "language": {
                    "search": "",
                    "searchPlaceholder": "Quick Search...",
                    "paginate": {
                        "next": '<i class="fas fa-chevron-right"></i>',
                        "previous": '<i class="fas fa-chevron-left"></i>'
                    }
                },
                "dom": '<"top"f>rt<"bottom"p><"clear">'
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
            $('#filter_data').submit();
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
    </script>

@stop
