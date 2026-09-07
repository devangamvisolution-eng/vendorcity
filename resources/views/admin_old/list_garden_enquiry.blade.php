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

        /* Matches the Action Card style from Package List */
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
                    <h3 class="page-title">Garden and Mouse Enquiry</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Garden and Mouse Enquiry</li>
                    </ul>
                </div>
                <div class="col-auto">
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
        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">
            <strong>Success! </strong><span id="success_message"></span>
        </div>

        <form method="GET" action="{{ url('garden_filter_data') }}" id="filter_data">
            <input type="hidden" name="startdate_fil" id="startdate_fil" value="{{ $startdate ?: '' }}">
            <input type="hidden" name="enddate_fil" id="enddate_fil" value="{{ $enddate ?: '' }}">
        </form>

        @php
            $css = !empty($startdate) || !empty($enddate) ? 'display:block;' : 'display:none;';
        @endphp

        <div id="filter_inputs" class="action-card mb-4" style="{{ $css }}">
            <div class="card-body p-4">
                <form id="filter_form" action="{{ route('garden-enquiry-filter') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="filter">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Start Date</label>
                            <input type="date" class="form-control" name="s_date" id="s_date"
                                value="{{ $startdate ?: '' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">End Date</label>
                            <input type="date" class="form-control" name="e_date" id="e_date"
                                value="{{ $enddate ?: '' }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end gap-2">
                            <button type="button" class="btn btn-primary w-100"
                                onclick="filter_validation()">Submit</button>
                            <a class="btn btn-light border w-100" href="{{ route('garden-enquiry') }}">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

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
                                    <th>Status</th>
                                    <th>Service Info</th>
                                    <th>Service Date</th>
                                    <th>Customer Info</th>
                                    <th>Vendor</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($garden_enquiry != '')
                                    @php $i = 1; @endphp
                                    @foreach ($garden_enquiry as $garden_data)
                                        @php
                                            $package_enquiry = DB::table('packages_enquiry')
                                                ->where('id', $garden_data->inquiry_id)
                                                ->first();
                                        @endphp
                                        <tr>
                                            <td style="display: none">{{ $i }}</td>
                                            <td>{{ date('d-m-Y', strtotime($garden_data->added_date)) }}</td>
                                            <td><span
                                                    class="fw-bold text-primary">#{{ $package_enquiry->inquiry_id ?? $garden_data->inquiry_id }}</span>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" class="badge bg-info-light text-info"
                                                    onclick="agent_detail('{{ $garden_data->id }}');">
                                                    <i class="far fa-user me-1"></i> {{ $package_enquiry->count ?? '0' }}/5
                                                    Accepted
                                                </a>
                                            </td>
                                            <td>
                                                <div class="fw-bold">
                                                    @if ($garden_data->service ?? '')
                                                        {!! Helper::servicename(strval($garden_data->service)) !!}
                                                    @endif
                                                </div>
                                                <div class="small text-muted">
                                                    @if ($garden_data->subservice ?? '')
                                                        {!! Helper::subservicename(strval($garden_data->subservice)) !!}
                                                    @endif
                                                </div>
                                            </td>
                                            <td><span
                                                    class="badge bg-light text-dark">{{ $garden_data->service_date }}</span>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ $garden_data->user_name ?? '' }}</div>
                                                <div class="small text-muted">{{ $garden_data->user_email ?? '' }}</div>
                                                <div class="small text-muted">{{ $garden_data->user_mobile ?? '' }}</div>
                                            </td>
                                            <td>
                                                @if ($garden_data->vendor_id != 0 && $garden_data->vendor_id != '')
                                                    <div class="small text-success fw-bold">
                                                        {!! Helper::vendorsnamepainting(explode(',', $garden_data->vendor_id)) !!}
                                                    </div>
                                                @else
                                                    <span class="text-muted small">Not Assigned</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex justify-content-end gap-1">
                                                    <a class="btn btn-sm btn-outline-primary"
                                                        href="{{ url('garden-enquiry-view', $garden_data->inquiry_id) }}"
                                                        title="View Info">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        onclick="garden_assign_vendor('{{ $garden_data->id }}');">
                                                        Assign
                                                    </button>
                                                </div>
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
    <!-- Vendor Status Modal -->
    @foreach ($garden_enquiry as $garden_data)
        @php
            $packages_accepted_data = DB::table('package_inquiry_accepted')
                ->select('*')
                ->where('subscription_type', '!=', 'A')
                ->where('packages_inquiry_id', '=', $garden_data->inquiry_id)
                ->get();
            // echo"<pre>";print_r($packages_accepted_data);echo"</pre>";exit;
            $id = $garden_data->id;
        @endphp
        <div class="modal custom-modal fade" id="show_comment_model_{{ $id }}" role="dialog">
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
                                                            <td>{{ $garden_data->user_name ?? '' }}</td>
                                                            <td>{{ $garden_data->user_email ?? '' }}</td>
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
    <!-- /set orderModal -->
    <!-- Assign Vendor  Modal -->
    <div class="modal custom-modal fade" id="assign_vendor_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="garden_vendor_form" action="{{ url('garden-vendor-form') }}" method="POST"
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
    <script>
        function garden_assign_vendor(inquiry_id) {
            var url = '{{ url('garden-assign-vendor') }}';
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
            $('#garden_vendor_form').submit();
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

        function agent_detail(id) {
            $('#show_comment_model_' + id).modal('show');
        }
    </script>
@stop
