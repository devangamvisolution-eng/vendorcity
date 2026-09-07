@extends('admin.includes.Template')

@section('content')
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

        .badge-status {
            padding: 6px 14px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 12px;
            display: inline-block;
            text-align: center;
        }

        .badge-completed {
            background-color: #e6f6ec;
            color: #2e8b57;
        }

        .badge-pending {
            background-color: #fff8e5;
            color: #d4a305;
        }

        .badge-cancelled {
            background-color: #fdeded;
            color: #c0392b;
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

    @php

        $userId = Auth::id();

        $get_user_data = Helper::get_user_data($userId);

        // $get_permission_data = Helper::get_permission_data($get_user_data->role_id);

        // $edit_perm = [];

        // if ($get_permission_data->editperm != '') {
        //     $edit_perm = $get_permission_data->editperm;

        //     $edit_perm = explode(',', $edit_perm);
        // }
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

        $userdata = Auth::user();

        //echo"<pre>";print_r($userdata->role_id);echo"</pre>";

    @endphp

    <style>
        #delete_model_1 .modal-dialog {
            max-width: 50% !important;
        }
    </style>

    <div class="content container-fluid">





        <!-- Page Header -->

        <div class="page-header">

            <div class="row align-items-center">

                <div class="col">

                    <h3 class="page-title">Vendor Commission Report</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>

                        </li>

                        <li class="breadcrumb-item active">Vendor Commission Report</li>

                    </ul>

                </div>

                <div class="col-auto">
                    <a class="btn btn-primary btn-premium me-1" href="javascript:void('0');" onclick="excel_download();"><i
                            class="fas fa-file-excel"></i> Excel Download</a>
                </div>

            </div>

        </div>

        <!-- /Page Header -->


        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">

                <strong>Success!</strong> {{ $message }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

            </div>
        @endif

        <form method="GET" action="{{ url('filter_data_vendor') }}" id="filter_data">

            <input type="hidden" name="startdate_fil" id="startdate_fil" value="{{ $startdate ?: '' }}">

            <input type="hidden" name="enddate_fil" id="enddate_fil" value="{{ $enddate ?: '' }}">

            <input type="hidden" name="filter_vendor_id_fil" id="filter_service_id_fil"
                value="{{ $filter_vendor_id ?: '' }}">

            <input type="hidden" name="filter_service_id_fil" id="filter_service_id_fil"
                value="{{ $filter_service_id ?: '' }}">

        </form>

        <!-- Search Filter -->

        <div id="filter_inputs" class="card filter-card" style="display: block !important;">

            <div class="card-body pb-0">
                <form id="filter_form" action="{{ route('vendors-filter') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="filter">

                    <div class="row">

                        <div class="col-sm-6 col-md-8">
                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="date" class="form-control" name="s_date" id="s_date"
                                            placeholder="Enter Start Date" value="{{ $startdate ?: '' }}">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" class="form-control" name="e_date" id="e_date"
                                            placeholder="Enter End Date" value="{{ $enddate ?: '' }}">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Select Service</label>
                                        <select name="servicename" class="form-control form-select" id="servicename">
                                            <option value="">Select Service</option>
                                            @foreach ($service_data as $service_data_new)
                                                <option value="{{ $service_data_new->id }}"
                                                    @if ($service_data_new->id == $filter_service_id) {{ 'selected' }} @endif>
                                                    {{ $service_data_new->servicename }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="servicename_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Select Vendor</label>
                                        @if ($userdata->vendor == 1)
                                            <input type="text" class="form-control" value="{{ $userdata->name }}"
                                                readonly>
                                            <input type="hidden" name="vendorname" id="vendorname"
                                                value="{{ $userdata->id }}">
                                        @else
                                            <select name="vendorname" class="form-control form-select" id="vendorname">
                                                <option value="">Select Vendor</option>

                                                @foreach ($vendor_data as $vendor_data_new)
                                                    <option value="{{ $vendor_data_new->id }}"
                                                        @if ($vendor_data_new->id == $filter_vendor_id || $vendor_data_new->id == $userId) {{ 'selected' }} @endif>
                                                        {{ $vendor_data_new->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        <p class="form-error-text" id="vendorname_error"
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
                                    href="{{ route('vendor-commission-report') }}"
                                    style="margin-top: 22px; background: #6c757d; color: white;">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        @php
            // echo "<pre>";print_r($packages_data);echo"</pre>";
        @endphp

        <div class="row">

            <div class="col-sm-12">

                <div class="card premium-card">

                    <div class="card-body">

                        <form id="form" action="{{-- route('delete_price') --}}" enctype="multipart/form-data">

                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">

                            @csrf

                            <div class="table-responsive">
                                <table class="table premium-table datatable" id="example">

                                    <thead class="thead-light">

                                        <tr>
                                            <th style="display: none">>Sr No</th>
                                            <th>Order Id</th>
                                            <th>Service Name</th>
                                            <th>Added Date</th>
                                            <th>Order Date</th>
                                            <th>Vendor Name</th>
                                            <th>Payment Mode</th>
                                            <th>Received By</th>
                                            <th>Total Amount (Incl. VAT)</th>
                                            <th>Amount (Without VAT)</th>
                                            <th>Add Amount</th>
                                            <th>Commission % (VC)</th>
                                            <th>Commission (VC)</th>
                                            <th>CC Fee</th>
                                            <th>Commission + CC Charges</th>
                                            {{-- <th>Commission Amount</th> --}}
                                            {{-- <th>Amount to Vendor</th> --}}

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            $total_commission_amount = 0;
                                            $total_amount = 0;
                                            $vc_commission = 0;
                                            $vc_received = 0;
                                            $vendor_received = 0;
                                            $vendor_total = 0;
                                            $vat_on_sum_charge = 0;
                                            $displayedOrderIds = [];

                                            $i = 1;

                                            $commission_cc_charge = 0;

                                        @endphp

                                        @if ($filter_vendor_id != '')
                                            @foreach ($package_order_amount_attr as $data)
                                                @php
                                                    $showRow = !in_array($data->order_id, $displayedOrderIds);
                                                    if ($showRow) {
                                                        $displayedOrderIds[] = $data->order_id;
                                                    }
                                                @endphp

                                                @if ($data->collect_by == 'Vendorscity')
                                                    @php
                                                        $vc_received += $data->add_amount;
                                                    @endphp
                                                @endif
                                                @if ($data->collect_by == 'Vendor')
                                                    @php
                                                        $vendor_received += $data->add_amount;
                                                    @endphp
                                                @endif

                                                <tr>
                                                    <td style="display: none">{{ $i }}</td>
                                                    <td>
                                                        {{ $data->order_id }}
                                                    </td>
                                                    <td>
                                                        {!! Helper::servicename($data->service_id) !!}
                                                    </td>
                                                    <td>
                                                        {{ $data->date }}
                                                    </td>
                                                    <td>
                                                        {{ $data->order_date }}
                                                    </td>
                                                    <td>
                                                        {!! Helper::vendorsname($data->vendor_id) !!}
                                                    </td>
                                                    <td>
                                                        {{ $data->payment_type }}
                                                    </td>
                                                    <td>
                                                        {{ $data->collect_by }}
                                                    </td>

                                                    <td>
                                                        @if ($showRow)
                                                            @php
                                                                $data->order_total = $data->order_total;
                                                            @endphp
                                                        @else
                                                            @php
                                                                $data->order_total = 0;
                                                            @endphp
                                                        @endif
                                                        {{ $data->order_total }}
                                                    </td>
                                                    @php
                                                        $amount_without_vat = $data->order_total - $data->vatcharge;
                                                    @endphp
                                                    <td>
                                                        @if ($showRow)
                                                            @php
                                                                $amount_without_vat = $amount_without_vat;
                                                            @endphp
                                                        @else
                                                            @php
                                                                $amount_without_vat = 0;
                                                            @endphp
                                                        @endif

                                                        {{ $amount_without_vat }}
                                                    </td><!-- Amount with out VAT  -->
                                                    <td>
                                                        {{ $data->add_amount }} <!--Add amount-->
                                                    </td>
                                                    <td>
                                                        {{ $data->booking_percentage }}
                                                    </td>



                                                    @php
                                                        $commission_amount =
                                                            ($amount_without_vat * $data->booking_percentage) / 100;

                                                        $amount_to_vendor = $data->add_amount - $commission_amount;

                                                        if ($data->payment_type == 'Online') {
                                                            $cc_fee = ($data->add_amount * 2.625) / 100;
                                                        } else {
                                                            $cc_fee = '0';
                                                        }

                                                        $commission_cc_charge = $commission_amount + $cc_fee;

                                                        $total_commission_amount += $commission_cc_charge;

                                                        $vat_on_sum_charge = ($total_commission_amount * 5) / 100;

                                                        $vc_commission = $total_commission_amount + $vat_on_sum_charge;

                                                        $total_amount += $data->order_total;

                                                        $vendor_total = $total_amount - $vc_commission;
                                                    @endphp

                                                    <td>
                                                        @if ($showRow)
                                                            {{ $commission_amount }}
                                                            @else{{ '-' }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $cc_fee }}</td>
                                                    <td>{{ $commission_cc_charge }}</td>
                                                    {{-- <td>{{$amount_to_vendor}}</td> --}}
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        @endif
                                    </tbody>

                                </table>

                            </div>

                        </form>
                        @if ($filter_vendor_id != '')
                            <div class="row mt-4 mb-3">
                                <div class="col-md-7 col-lg-8"></div>
                                <div class="col-md-5 col-lg-4">
                                    <div class="card premium-card mb-0 shadow-sm" style="border: 1px solid #eef2f5;">
                                        <div class="card-header bg-light border-bottom">
                                            <h5 class="card-title mb-0 text-center text-uppercase fw-bold"
                                                style="letter-spacing: 1px; font-size: 14px; color: #495057;">Summary</h5>
                                        </div>
                                        <div class="card-body p-0">
                                            <table class="table premium-table mb-0" id="summary_table">
                                                @php
                                                    $amount_without_commission = $total_amount - $vc_commission;
                                                    $paid_to_vendor = $vendor_total - $vendor_received;
                                                @endphp
                                                <tr>
                                                    <td class="text-muted fw-bold"
                                                        style="padding: 12px 20px; font-size: 14px; border-bottom: 1px solid #f1f3f5;">
                                                        Vat on Sum of charges</td>
                                                    <td class="text-end fw-bold text-dark"
                                                        style="padding: 12px 20px; font-size: 14px; border-bottom: 1px solid #f1f3f5;">
                                                        {{ number_format($vat_on_sum_charge, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted fw-bold"
                                                        style="padding: 12px 20px; font-size: 14px; border-bottom: 1px solid #f1f3f5;">
                                                        Total VC Commision</td>
                                                    <td class="text-end fw-bold text-dark"
                                                        style="padding: 12px 20px; font-size: 14px; border-bottom: 1px solid #f1f3f5;">
                                                        {{ number_format($vc_commission, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted fw-bold"
                                                        style="padding: 12px 20px; font-size: 14px; border-bottom: 1px solid #f1f3f5;">
                                                        Vendors Total</td>
                                                    <td class="text-end fw-bold text-dark"
                                                        style="padding: 12px 20px; font-size: 14px; border-bottom: 1px solid #f1f3f5;">
                                                        {{ number_format($vendor_total, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted fw-bold"
                                                        style="padding: 12px 20px; font-size: 14px; border-bottom: 1px solid #f1f3f5;">
                                                        Vendor Received</td>
                                                    <td class="text-end fw-bold text-dark"
                                                        style="padding: 12px 20px; font-size: 14px; border-bottom: 1px solid #f1f3f5;">
                                                        {{ number_format($vendor_received, 2) }}</td>
                                                </tr>
                                                <tr style="background-color: #f8f9fa;">
                                                    <td class="fw-bold"
                                                        style="padding: 16px 20px; font-size: 15px; color: #0d6efd; border-bottom: none;">
                                                        Paid to Vendor</td>
                                                    <td class="text-end fw-bold"
                                                        style="padding: 16px 20px; font-size: 16px; color: #0d6efd; border-bottom: none;">
                                                        {{ number_format($paid_to_vendor, 2) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>
@stop
@section('footer_js')

    <!-- Delete  Modal -->




    <script>
        function excel_download() {
            $('#filter_data').submit();
        }

        function delete_category(id) {

            // alert(id);

            $('#delete_model_' + id).modal('show');


        }

        function filter_validation() {

            var vendorname = jQuery("#vendorname").val();

            if (vendorname == '') {
                jQuery('#vendorname_error').html("Please Select Vendor");
                jQuery('#vendorname_error').show().delay(0).fadeIn('show');
                jQuery('#vendorname_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#vendorname').offset().top - 150
                }, 1000);
                return false;
            }

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
    </script>

@stop
