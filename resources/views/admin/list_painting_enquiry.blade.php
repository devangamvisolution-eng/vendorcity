@extends('admin.includes.Template')
@section('content')
    <style>
        /* Modern Layout Variables - Copied from Leads Enquiry */
        :root {
            --action-blue: #2563eb;
            --border-classic: #e2e8f0;
            --text-dark: #0f172a;
            --hover-bg: #f7df7e;
        }

        .content {
            overflow: visible !important;
        }

        /* Matches the Action Card style */
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

        /* DataTables Pagination styling */
        .dataTables_wrapper .dataTables_paginate {
            padding: 15px;
            display: flex;
            justify-content: flex-end;
            gap: 5px;
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
                    <h3 class="page-title">Painting Leads Enquiry</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Painting Leads Enquiry</li>
                    </ul>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-primary me-2" href="javascript:void('0');" onclick="excel_download();">
                        Excel Download
                    </a>
                    <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                        <i class="fas fa-filter"></i>
                    </a>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if ($message = Session::get('vendor-assigned-error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="GET" action="{{ url('filter_data') }}" id="filter_data">
            <input type="hidden" name="filter_vendor_id_fil" id="filter_vendor_id_fil" value="">
        </form>

        <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">
            <strong>Success! </strong><span id="success_message"></span>
        </div>

        @php
            $css = !empty($filter_vendor_id) ? 'display:block;' : 'display:none;';
        @endphp

        <div id="filter_inputs" class="action-card mb-4" style="{{ $css }}">
            <div class="card-body p-4">
                <form id="filter_form" action="{{ route('enquiry_accept') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="filter">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Vendor</label>
                            <select class="form-select" id="vendor_id" name="vendor_id">
                                <option value="">Select Vendor</option>
                                @if (!empty($all_vendor))
                                    @foreach ($all_vendor as $all_vendor_data)
                                        <option value="{{ $all_vendor_data->id }}"
                                            @if ($filter_vendor_id == $all_vendor_data->id) {{ 'selected' }} @endif>
                                            {{ $all_vendor_data->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <p class="form-error-text" id="vendor_id_error" style="color: red; margin-top: 10px;"></p>
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="button" class="btn btn-primary w-100"
                                onclick="filter_validation()">Submit</button>
                            <a class="btn btn-light border w-100" href="{{ route('enquiry_accept') }}">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="action-card">
            <div class="card-body p-4">
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
                                    <th>Customer Info</th>
                                    <th>Service Info</th>
                                    <th>Assign Vendor</th>
                                    <th>Email Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($painting_enquiry != '')
                                    @php $i = 1; @endphp
                                    @foreach ($painting_enquiry as $painting_data)
                                        <tr>
                                            <td style="display: none">{{ $i }}</td>
                                            <td>{{ date('d-m-Y', strtotime($painting_data->added_date)) }}</td>
                                            <td><span class="fw-bold text-primary">#{{ $painting_data->inquiry_id }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{ $painting_data->name ?? '' }}</span>
                                                <div class="small">{{ $painting_data->email ?? '' }}</div>
                                                <div class="text-muted small">{{ $painting_data->mobile ?? '' }}</div>
                                            </td>
                                            <td>
                                                <div class="fw-bold">
                                                    @if ($painting_data->service_id ?? '')
                                                        {!! Helper::servicename(strval($painting_data->service_id)) !!}
                                                    @endif
                                                </div>
                                                <div class="small text-muted">
                                                    @if ($painting_data->subservice_id ?? '')
                                                        {!! Helper::subservicename(strval($painting_data->subservice_id)) !!}
                                                    @endif
                                                </div>
                                                <div class="badge bg-info-light text-info mt-1">
                                                    {{ $painting_data->type_of_painting }}</div>
                                            </td>
                                            <td>
                                                <div class="mb-2">
                                                    @if ($painting_data->vendor_id != 0 && $painting_data->vendor_id != '')
                                                        <span class="small text-muted d-block">Assigned:</span>
                                                        {!! Helper::vendorsnamepainting(explode(',', $painting_data->vendor_id)) !!}
                                                    @endif
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    onclick="assign_vendor('{{ $painting_data->id }}');">
                                                    <i class="fas fa-user-plus me-1"></i> Assign
                                                </button>
                                            </td>
                                            <td>
                                                <div class="mb-2">
                                                    @if ($painting_data->vendor_id_for_email != 0 && $painting_data->vendor_id_for_email != '')
                                                        <span class="small text-muted d-block">Emailed:</span>
                                                        {!! Helper::vendorsnamepainting(explode(',', $painting_data->vendor_id_for_email)) !!}
                                                    @endif
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-info"
                                                    onclick="email_to_vendor('{{ $painting_data->id }}');">
                                                    <i class="fas fa-envelope me-1"></i> Email
                                                </button>
                                            </td>
                                            <td class="text-end">
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ url('painting-lead-detail', $painting_data->id) }}">
                                                    View Info
                                                </a>
                                            </td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                @endif
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
    <!-- set order Modal -->
    <div class="modal custom-modal fade" id="set_order_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <h3>Are you sure you want to Set order of Groups</h3>
                        <input type="hidden" name="set_order_val" id="set_order_val" value="">
                        <input type="hidden" name="set_order_id" id="set_order_id" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary" onclick="updateorder();">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /set orderModal -->

    <!-- Assign Vendor  Modal -->
    <div class="modal custom-modal fade" id="assign_vendor_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="painting_vendor_form" action="{{ url('painting-vendor-form') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="modal-text text-center">
                            <!-- <h3>Delete Expense Category</h3> -->
                            <!-- <p>Select Vendor</p> -->
                        </div>
                        <div class="modal-text text-center" id="dropdownreplace_new">
                        </div>
                        <p class="form-error-text" id="painting_vendor_id_error" style="color: red; margin-top: 10px;">
                        </p>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="form_sub_vendor();">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Email to Vendor  Modal -->
    <div class="modal custom-modal fade" id="email_vendor_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="painting_email_to_vendor" action="{{ url('painting-wallet-vendor') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="modal-text text-center">
                            <!-- <h3>Delete Expense Category</h3> -->
                            <!-- <p>Select Vendor</p> -->
                        </div>
                        <div class="modal-text text-center" id="dropdownreplace_vendor">
                        </div>
                        <p class="form-error-text" id="painting_email_vendor_id_error"
                            style="color: red; margin-top: 10px;"></p>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="form_sub_email_vendor();">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function assign_vendor(inquiry_id) {

            var url = '{{ url('painting-assign-vendor') }}';
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
            var vendor_id = jQuery("#painting_vendor_id").val();
            if (vendor_id == '') {
                jQuery('#painting_vendor_id_error').html("Please Select Vendor");
                jQuery('#painting_vendor_id_error').show().delay(0).fadeIn('show');
                jQuery('#painting_vendor_id_error').show().delay(2000).fadeOut('show');

                return false;
            }
            $('#painting_vendor_form').submit();
        }


        function email_to_vendor(inquiry_id) {

            var url = '{{ url('painting-email-vendor') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "inquiry_id": inquiry_id
                },
                success: function(msg) {
                    // console.log(msg); // Check the response in the console
                    document.getElementById('dropdownreplace_vendor').innerHTML = msg;
                    $('#email_vendor_model').modal('show');
                    $('#dropdownreplace_vendor .select2').select2({
                        dropdownParent: $('#email_vendor_model'),
                        placeholder: "Select a Vendor",
                        allowClear: false, // Set to false for multiple select to properly display placeholder
                        closeOnSelect: true, // Keep dropdown open for multiple selection if needed
                    });
                }
            });
        }


        function form_sub_email_vendor() {
            var vendor_id = jQuery("#painting_vendor_id").val();
            if (vendor_id == '') {
                jQuery('#painting_email_vendor_id_error').html("Please Select Vendor");
                jQuery('#painting_email_vendor_id_error').show().delay(0).fadeIn('show');
                jQuery('#painting_email_vendor_id_error').show().delay(2000).fadeOut('show');

                return false;
            }
            $('#painting_email_to_vendor').submit();
        }

        function excel_download() {
            $('#filter_data').submit();
        }

        $('#vendor_id').select2();

        function filter_validation() {

            var vendor_id = jQuery("#vendor_id").val();
            if (vendor_id == '') {
                jQuery('#vendor_id_error').html("Please Select Vendor");
                jQuery('#vendor_id_error').show().delay(0).fadeIn('show');
                jQuery('#vendor_id_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#vendor_id').offset().top - 150
                }, 1000);
                return false;
            }
            $('#filter_form').submit();
        }

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

        function quotes_leads(id) {
            $('#show_comment_model_' + id).modal('show');
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
    </script>
@stop
