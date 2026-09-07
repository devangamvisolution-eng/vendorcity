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
                    <h3 class="page-title">Garden and Mouse Rejected Leads</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Garden and Mouse Rejected Leads</li>
                    </ul>
                </div>
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
        </div>

        <div id="filter_inputs" class="action-card mb-4">
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Name</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Phone</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="action-card">
            <div class="card-body p-4">
                <form id="form" action="" enctype="multipart/form-data">
                    <input type="hidden" name="hidPgRefRan" value="<?php echo rand(); ?>">
                    @csrf
                    @php
                        $userId = Auth::id();
                        $package_inquiry_rejected = DB::table('package_inquiry_accepted')
                            ->where('vendor_id', '=', $userId)
                            ->where('accept_reject', 1)
                            ->orderBy('id', 'desc')
                            ->get();
                    @endphp
                    <div class="table-responsive">
                        <table class="action-table table-hover" id="example">
                            <thead>
                                <tr>
                                    <th style="display: none">Sr No</th>
                                    <th>Date</th>
                                    <th>Inquiry No</th>
                                    <th>Rejected Date</th>
                                    <th>Service Info</th>
                                    <th class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($package_inquiry_rejected != '')
                                    @php $i = 1; @endphp
                                    @foreach ($package_inquiry_rejected as $package_inquiry_rejected_data)
                                        @php
                                            $packages_enquiry_data = DB::table('packages_enquiry')
                                                ->select('*')
                                                ->where('id', '=', $package_inquiry_rejected_data->packages_inquiry_id)
                                                ->first();
                                        @endphp
                                        <tr>
                                            <td style="display: none">{{ $i }}</td>
                                            <td>{{ date('d-m-Y', strtotime($packages_enquiry_data->added_date)) }}</td>
                                            <td><span
                                                    class="fw-bold text-primary">#{{ $packages_enquiry_data->inquiry_id }}</span>
                                            </td>
                                            <td><span
                                                    class="text-danger">{{ date('d-m-Y', strtotime($package_inquiry_rejected_data->added_date)) }}</span>
                                            </td>
                                            <td>
                                                <div class="fw-bold">
                                                    @if ($packages_enquiry_data->service_id ?? '')
                                                        {!! Helper::servicename(strval($packages_enquiry_data->service_id)) !!}
                                                    @endif
                                                </div>
                                                <div class="small text-muted">
                                                    @if ($packages_enquiry_data->subservice_id ?? '')
                                                        {!! Helper::subservicename(strval($packages_enquiry_data->subservice_id)) !!}
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <span class="badge bg-danger-light text-danger">Rejected</span>
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
