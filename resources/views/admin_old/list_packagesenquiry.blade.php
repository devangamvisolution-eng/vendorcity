@extends('admin.includes.Template')
@section('content')
    <style>
        /* Modern Layout Variables */
        :root {
            --action-blue: #2563eb;
            --border-classic: #e2e8f0;
            --text-dark: #0f172a;
            --hover-bg: #f7df7e;
        }

        .content {
            overflow: visible !important;
        }

        /* Matches the Action Card style from Vendor List */
        .action-card {
            overflow: visible !important;
            background: #fff;
            border: 1px solid var(--border-classic);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        /* Consistent Table Header and Hover effects */
        .action-table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        .action-table thead th {
            background: #4c7aef;
            padding: 10px 12px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #ffffff;
            border-bottom: 2px solid var(--border-classic);
            position: sticky;
            top: var(--admin-header-height);
            z-index: 100;
        }

        .action-table tbody tr:hover {
            background-color: var(--hover-bg) !important;
        }

        .action-table td {
            padding: 12px;
            vertical-align: middle;
            font-size: 13px;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border-classic);
        }

        /* Toggle Switch Styling */
        .toggle {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .toggle input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #8B0000;
            transition: 0.4s;
            border-radius: 17px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #22c55e;
        }

        input:checked+.slider:before {
            transform: translateX(24px);
        }

        /* DataTables Pagination styling */
        .dataTables_wrapper .dataTables_paginate {
            padding: 15px;
            display: flex;
            justify-content: flex-end;
            gap: 5px;
        }

        .th-4 {
            width: 130px;
        }

        .th-7 {
            width: 80px;
        }

        @media only screen and (max-width: 767px) {
            .action-card {
                overflow-x: auto !important;
            }
        }
    </style>

    <div class="content container-fluid">
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leads Enquiry</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Leads Enquiry</li>
                    </ul>
                </div>
                <div class="col-auto d-flex">
                    <div class="d-flex me-2">
                        <label class="toggle me-1">
                            <input type="checkbox" id="is_active_toggle"
                                {{ $system->auto_accept_package == 1 ? 'checked' : '' }}
                                onchange="fun_status(this.checked ? 1 : 0)" value="0">
                            <span class="slider"></span>
                        </label>
                        <p style="margin-top: 10px;">Auto Accept</p>
                    </div>
                    <a class="btn btn-primary me-2" href="{{ route('admin.movingenquiryadd') }}">
                        Add New Enquiry
                    </a>
                    <a class="btn btn-primary me-2" href="javascript:void('0');" onclick="excel_download();">
                        Excel Download
                    </a>
                    <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                        <i class="fas fa-filter"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Alerts Section --}}
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">
            <strong>Success! </strong><span id="success_message"></span>
        </div>
        <div class="alert alert-danger alert-dismissible fade show failed_show" style="display: none;">
            <strong>Failed! </strong><span id="failed_message" style="color: red;"></span>
        </div>

        {{-- Search Filter Section --}}
        <form method="GET" action="{{ url('filter_data_enquiry') }}" id="filter_data">
            <input type="hidden" name="startdate_fil" id="startdate_fil" value="{{ $startdate ?: '' }}">
            <input type="hidden" name="enddate_fil" id="enddate_fil" value="{{ $enddate ?: '' }}">
            <input type="hidden" name="filter_service_id_fil" id="filter_service_id_fil"
                value="{{ $filter_service_id ?: '' }}">
            <input type="hidden" name="filter_customer_name_fil" id="filter_customer_name_fil"
                value="{{ $filter_customer_name ?: '' }}">
        </form>

        @php
            $css =
                !empty($startdate) || !empty($enddate) || !empty($filter_service_id) || !empty($filter_customer_name)
                    ? 'display:block;'
                    : 'display:none;';
        @endphp

        <div id="filter_inputs" class="action-card mb-4" style="{{ $css }}">
            <div class="card-body p-4">
                <form id="filter_form" action="{{ route('enquiry-filter') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="filter">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Start Date</label>
                            <input type="date" class="form-control" name="s_date" id="s_date"
                                value="{{ $startdate ?: '' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">End Date</label>
                            <input type="date" class="form-control" name="e_date" id="e_date"
                                value="{{ $enddate ?: '' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Service</label>
                            <select name="servicename" class="form-select" id="servicename">
                                <option value="">Select Service</option>
                                @foreach ($service_data as $service_data_new)
                                    <option value="{{ $service_data_new->id }}"
                                        @if ($service_data_new->id == $filter_service_id) {{ 'selected' }} @endif>
                                        {{ $service_data_new->servicename }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="button" class="btn btn-primary w-100"
                                onclick="filter_validation()">Submit</button>
                            <a class="btn btn-light border w-100" href="{{ route('enquiry.index') }}">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="action-card">
            <div class="card-body p-4"> {{-- p-0 to allow table to touch edges like vendor list --}}
                <form id="form" action="" enctype="multipart/form-data">
                    <input type="hidden" name="hidPgRefRan" value="<?php echo rand(); ?>">
                    @csrf
                    <div class="table-responsive">
                        <table class="action-table table-hover" id="example">
                            <thead>
                                <tr>
                                    <th style="display: none">Sr No</th>
                                    <th>Date</th>
                                    <th>Inquiry No</th>
                                    <th>Status</th>
                                    <th class="th-4">Auto Accept Status</th>
                                    <th>Customer Info</th>
                                    {{-- <th>Email/Mobile</th> --}}
                                    <th class="th-7">Service Info</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($packages_data as $data)
                                    <tr>
                                        <td style="display: none">{{ $i }}</td>
                                        <td>{{ date('d-m-Y', strtotime($data->added_date)) }}</td>
                                        <td><span class="fw-bold text-primary">#{{ $data->inquiry_id }}</span></td>
                                        <td>
                                            <a href="javascript:void(0)" class="badge bg-info-light text-info"
                                                onclick="agent_detail('{{ $data->id }}');">
                                                <i class="far fa-user me-1"></i> {{ $data->count }}/5 Accepted
                                            </a>
                                        </td>
                                        @php
                                            $packges_accepted_data = DB::table('package_inquiry_accepted')
                                                ->where('packages_inquiry_id', $data->id)
                                                ->where('subscription_type', '=', 'A')
                                                ->count();
                                        @endphp
                                        <td>
                                            <a href="javascript:void(0)" class="badge bg-success-light text-success"
                                                onclick="auto_accept_agent_detail('{{ $data->id }}');">
                                                {{ $packges_accepted_data }} Vendors
                                            </a>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $data->name }}</span>
                                            <div class="small">{{ $data->email }}</div>
                                            <div class="text-muted small">{{ $data->mobile }}</div>
                                        </td>
                                        {{-- <td>
                                            <div class="small">{{ $data->email }}</div>
                                            <div class="text-muted small">{{ $data->mobile }}</div>
                                        </td> --}}
                                        <td>
                                            <div class="fw-bold">{!! Helper::servicename($data->service_id) !!}</div>
                                            <div class="small text-muted">{!! Helper::subservicename($data->subservice_id) !!}</div>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-1">
                                                <a class="btn btn-sm btn-outline-primary"
                                                    href="{{ url('enquiry_page', $data->id) }}" title="View Info">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                @if ($system->auto_accept_package == 0)
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        onclick="assign_vendor('{{ $data->id }}');">
                                                        Assign
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('footer_js')
    <!-- Delete  Modal -->
    @if ($packages_data != '')
        @foreach ($packages_data as $data)
            <div class="modal custom-modal fade" id="delete_model_{{ $data->id }}" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="modal-text text-center">
                                <!-- <h3>Delete Expense Category</h3> -->
                                @php
                                    $result = DB::table('more_formfields_details')
                                        ->select('*')
                                        ->where('package_inquiry_id', '=', $data->id)
                                        ->get();
                                    //$servicename = Helper::servicename($result->service_id);
                                    // echo '<pre>';
                                    // print_r($result);
                                    // echo '</pre>';
                                    // exit();
                                @endphp
                                @if ($result != '')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="invoice-table table table-bordered">
                                                    <thead>
                                                        @foreach ($result as $result_data)
                                                            <tr>
                                                                <th>{!! Helper::form_fields($result_data->form_field_id) !!}</th>
                                                            </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            @if ($result_data->formfield_value != '')
                                                                <td>{{ $result_data->formfield_value }}</td>
                                                            @else
                                                                <td>{{ '-' }}</td>
                                                            @endif
                                                        </tr>
                                @endforeach
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <p>No Data Found</p>
        @endif
        </div>
        </div>
        </div>
        </div>
        </div>
    @endforeach
    @endif
    @foreach ($packages_data as $packages)
        @php
            $packages_accepted_data = DB::table('package_inquiry_accepted')
                ->select('*')
                ->where('subscription_type', '!=', 'A')
                ->where('packages_inquiry_id', '=', $packages->id)
                ->get();
            $inquiry_id = $packages->id;
        @endphp
        <div class="modal custom-modal fade" id="show_comment_model_{{ $inquiry_id }}" role="dialog">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 80% !important;">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-text text-center"></div>
                        <div class="modal-text text-center" id="dropdownreplace">
                            <div class="row">
                                <div id="agent_detail">
                                    @if ($packages_accepted_data)
                                        <div class="table-responsive mb-30" style="margin-bottom: 40px;">
                                            <table class="table mb-30">
                                                <thead>
                                                    <tr>
                                                        <th>Vendor Name</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($packages_accepted_data as $data)
                                                        <tr>
                                                            <td>{!! Helper::vendorsname($data->vendor_id) !!}</td>
                                                            <td>{{ $packages->name ?? '' }}</td>
                                                            <td>{{ $packages->email ?? '' }}</td>
                                                            <td>{{ $data->price_of_lead ?? '0' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div>No Agent Data Found.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @foreach ($packages_data as $packages)
        @php
            $packages_accepted_data = DB::table('package_inquiry_accepted')
                ->select('*')
                ->where('subscription_type', '=', 'A')
                ->where('packages_inquiry_id', '=', $packages->id)
                ->get();
            $inquiry_id = $packages->id;
        @endphp
        <div class="modal custom-modal fade" id="show_comment_model_auto_accept{{ $inquiry_id }}" role="dialog">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 80% !important;">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-text text-center"></div>
                        <div class="modal-text text-center" id="dropdownreplace">
                            <div class="row">
                                <div id="auto_accept_agent_detail">
                                    @if ($packages_accepted_data)
                                        <div class="table-responsive mb-30" style="margin-bottom: 40px;">
                                            <table class="table mb-30">
                                                <thead>
                                                    <tr>
                                                        <th>Vendor Name</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        {{-- <th>Price</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($packages_accepted_data as $data)
                                                        <tr>
                                                            <td>{!! Helper::vendorsname($data->vendor_id) !!}</td>
                                                            <td>{{ $packages->name ?? '' }}</td>
                                                            <td>{{ $packages->email ?? '' }}</td>
                                                            {{-- <td>{{ $data->price_of_lead ?? '0' }}</td> --}}
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div>No Agent Data Found.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="modal custom-modal fade" id="status_modell" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <h3>Are you sure you want to change the Auto Accept status</h3>
                        <input type="hidden" name="is_active_val" id="is_active_val" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary" onclick="fun_review_status();"
                            id="modal_yes_button">Yes</button>
                        <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                            style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal custom-modal fade" id="assign_vendor_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="manual_assign_vendor_form" action="{{ url('manual-assign-vendor-form') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-text text-center">
                            <!-- <h3>Delete Expense Category</h3> -->
                            <!-- <p>Select Vendor</p> -->
                        </div>
                        <div class="modal-text text-center" id="dropdownreplace_new">
                        </div>
                        <p class="form-error-text" id="manual_lead_vendor_id_error"
                            style="color: red; margin-top: 10px;"></p>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="submit_button"
                            onclick="form_sub_vendor();">Submit</button>
                        <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button_assign"
                            style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function assign_vendor(inquiry_id) {
            var url = '{{ url('manual-assign-lead') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "inquiry_id": inquiry_id
                },
                success: function(msg) {
                    // console.log(msg); // Check the response in the console
                    document.getElementById('dropdownreplace_new').innerHTML = msg;
                    $('#assign_vendor_model').modal('show');
                    $('#dropdownreplace_new .select2').select2({
                        dropdownParent: $('#assign_vendor_model'),
                        placeholder: "Select a Vendor",
                        allowClear: false, // Set to false for multiple select to properly display placeholder
                        closeOnSelect: true, // Keep dropdown open for multiple selection if needed
                    });
                }
            });
        }

        function form_sub_vendor() {
            var vendor_id = jQuery("#manual_lead_vendor_id").val();
            if (vendor_id == '') {
                jQuery('#manual_lead_vendor_id_error').html("Please Select Vendor");
                jQuery('#manual_lead_vendor_id_error').show().delay(0).fadeIn('show');
                jQuery('#manual_lead_vendor_id_error').show().delay(2000).fadeOut('show');
                return false;
            }
            $('#spinner_button_assign').show();
            $('#submit_button').hide();
            $('#manual_assign_vendor_form').submit();
        }
    </script>
    <script>
        function fun_status(value) {
            // alert(value);
            $('#is_active_val').val(value);
            $('#status_modell').modal('show');
        }

        function fun_review_status() {
            // Hide "Yes" button and show the spinner
            $('#modal_yes_button').hide();
            $('#spinner_button').show();
            var value = $('#is_active_val').val();
            // alert(value);
            $.ajax({
                type: "post",
                url: "{{ url('change_status_auto_accept') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "value": value,
                },
                success: function(returndata) {
                    if (returndata == 2) {
                        $('#failed_message').text(
                            'Auto Accept Package Status Off has been Updated successfully.');
                        $('.failed_show').show().delay(0).fadeIn('show');
                        $('.failed_show').show().delay(5000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#failed_message').offset().top - 150
                        }, 1000);
                        $("#form").load(location.href + " #form");
                        // $('#is_active_toggle').prop('checked', false);
                    }
                    if (returndata == 1) {
                        $('#success_message').text(
                            'Auto Accept Package Status On has been Updated successfully');
                        $('.success_show').show().delay(0).fadeIn('show');
                        $('.success_show').show().delay(5000).fadeOut('show');
                        $("#form").load(location.href + " #form");
                        // $('#is_active_toggle').prop('disabled', true);
                    }
                    // Hide the spinner and modal after request completion
                    $('#spinner_button').hide();
                    $('#modal_yes_button').show(); // Optional: If you want to show the "Yes" button again.
                    $('#status_modell').modal('hide');
                },
            });
        }
    </script>
    <script>
        function excel_download() {
            $('#filter_data').submit();
        }

        function delete_category(id) {
            // alert(id);
            $('#delete_model_' + id).modal('show');
        }

        function filter_validation() {
            // var vendor_id = jQuery("#vendor_id").val();
            // if (vendor_id == '') {
            //     jQuery('#vendor_id_error').html("Please Select Vendor");
            //     jQuery('#vendor_id_error').show().delay(0).fadeIn('show');
            //     jQuery('#vendor_id_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#vendor_id').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            $('#filter_form').submit();
        }
    </script>
    <script>
        if ($.fn.DataTable.isDataTable('#example')) {
            $('#example').DataTable().destroy();
        }
        $(document).ready(function() {
            $('#example').dataTable({
                "searching": true
            });
        })

        function agent_detail(inquiry_id) {
            $('#show_comment_model_' + inquiry_id).modal('show');
        }

        function auto_accept_agent_detail(inquiry_id) {
            $('#show_comment_model_auto_accept' + inquiry_id).modal('show');
        }
    </script>
@stop
