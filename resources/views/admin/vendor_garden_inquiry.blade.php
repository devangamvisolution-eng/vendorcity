@extends('admin.includes.Template')
@section('content')
    @php
        $userId = Auth::id();
        $get_user_data = Helper::get_user_data($userId);
        $get_permission_data = Helper::get_permission_data($get_user_data->role_id);
        $edit_perm = [];
        if ($get_permission_data->editperm != '') {
            $edit_perm = $get_permission_data->editperm;
            $edit_perm = explode(',', $edit_perm);
        }
    @endphp
    <style>
        /* Modern Layout Variables - Copied from Reference */
        :root {
            --action-blue: #2563eb;
            --border-classic: #e2e8f0;
            --text-dark: #0f172a;
            --hover-bg: #f7df7e;
        }

        .content {
            overflow: visible !important;
        }

        /* Modern Action Card style */
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

        #delete_model_1 .modal-dialog {
            max-width: 50% !important;
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
                    <h3 class="page-title">Garden and Mouse Inquiry</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Garden and Mouse Inquiry</li>
                    </ul>
                </div>
                <div class="col-auto">
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

        @php
            $css =
                !empty($startdate) || !empty($enddate) || !empty($filter_service_id)
                    ? 'display:block;'
                    : 'display:none;';
        @endphp

        <div id="filter_inputs" class="action-card mb-4" style="{{ $css }}">
            <div class="card-body p-4">
                <form id="filter_form" action="javascript:void(0);" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="filter">
                    <div class="row">
                        <div class="col-sm-6 col-md-8">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="date" class="form-control" name="s_date" id="s_date"
                                            placeholder="Enter Start Date" value="">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" class="form-control" name="e_date" id="e_date"
                                            placeholder="Enter End Date" value="">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-3 col-md-4">
                            <div class="form-group">
                                <a class="btn btn-primary filter-btn" href="javascript:void(0);" style="margin-top: 22px;"
                                    onclick="filter_validation()">Submit</a>
                                <a class="btn btn-primary filter-btn" href="javascript:void(0);"
                                    style="margin-top: 22px;">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="action-card">
                    <div class="card-body p-4">
                        <form id="form" action="" enctype="multipart/form-data">
                            <input type="hidden" name="hidPgRefRan" value="<?php echo rand(); ?>">
                            @csrf

                            {{-- START OF ORIGINAL LOGIC SECTION --}}
                            @php
                                $userId = Auth::id();
                                $currentDate = now();
                                $vendor_subscription = DB::table('subscription')
                                    ->select('*')
                                    ->where('vendor_id', '=', $userId)
                                    ->where('is_deleted', '=', '0')
                                    ->orderBy('id', 'desc')
                                    ->get();

                                $resultArray = [];
                                foreach ($vendor_subscription as $vendor_subscription_data) {
                                    $vendor_subscription_att = DB::table('subscription_subservice_attribute')
                                        ->select('*')
                                        ->where('subscription_id', '=', $vendor_subscription_data->id)
                                        ->get();
                                    foreach ($vendor_subscription_att as $vendor_subscription_att_data) {
                                        $resultArray[] = [
                                            'service_id' => $vendor_subscription_att_data->service_id,
                                            'subservice_id' => $vendor_subscription_att_data->subservice_id,
                                        ];
                                    }
                                }
                                $uniqueArray = [];
                                foreach ($resultArray as $entry) {
                                    $key = $entry['service_id'] . '_' . $entry['subservice_id'];
                                    if (!isset($uniqueArray[$key])) {
                                        $uniqueArray[$key] = $entry;
                                    }
                                }
                                $resultArray = array_values($uniqueArray);
                            @endphp
                            {{-- END OF ORIGINAL LOGIC SECTION --}}

                            <div class="table-responsive">
                                <table class="action-table table-hover" id="enqury_table">
                                    <thead>
                                        <tr>
                                            <th style="display: none;">Sr No</th>
                                            <th>Date</th>
                                            <th>Inquiry No</th>
                                            <th>Customer Name</th>
                                            <th>Service Details</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($vendor_subscription->isNotEmpty())
                                            @php $i = 1; @endphp
                                            @foreach ($resultArray as $resultArray_data)
                                                @php
                                                    $query = DB::table('packages_enquiry')
                                                        ->select('*')
                                                        ->where('service_id', '=', $resultArray_data['service_id'])
                                                        ->where(
                                                            'subservice_id',
                                                            '=',
                                                            $resultArray_data['subservice_id'],
                                                        )
                                                        ->where('count', '<', 5);

                                                    if (!empty($startdate)) {
                                                        $query->where(
                                                            'added_date',
                                                            '>=',
                                                            date('Y-m-d', strtotime($startdate)),
                                                        );
                                                    }
                                                    if (!empty($enddate)) {
                                                        $query->where(
                                                            'added_date',
                                                            '<=',
                                                            date('Y-m-d', strtotime($enddate)),
                                                        );
                                                    }
                                                    if (!empty($filter_service_id)) {
                                                        $query->where('service_id', '=', $filter_service_id);
                                                    }

                                                    $packages_enquiry = $query->orderBy('id', 'desc')->get();
                                                @endphp
                                                @foreach ($packages_enquiry as $packages_enquiry_data)
                                                    @php
                                                        $vendor_data = Auth::user();
                                                        $vendors_data = DB::table('package_inquiry_accepted')
                                                            ->where('packages_inquiry_id', $packages_enquiry_data->id)
                                                            ->where('vendor_id', $vendor_data->id)
                                                            ->first();
                                                    @endphp
                                                    @if ($vendors_data == '')
                                                        <tr>
                                                            <td style="display: none">{{ $packages_enquiry_data->id }}</td>
                                                            <td>{{ date('d-m-Y', strtotime($packages_enquiry_data->added_date)) }}
                                                            </td>
                                                            <td><span
                                                                    class="fw-bold text-primary">#{{ $packages_enquiry_data->inquiry_id }}</span>
                                                            </td>
                                                            <td class="fw-bold text-dark">
                                                                {{ $packages_enquiry_data->name }}</td>
                                                            <td>
                                                                <div class="fw-bold">{!! Helper::servicename(strval($packages_enquiry_data->service_id)) !!}</div>
                                                                <div class="small text-muted">{!! Helper::subservicename(strval($packages_enquiry_data->subservice_id)) !!}</div>
                                                            </td>
                                                            <td class="text-end">
                                                                <a class="btn btn-sm btn-outline-primary"
                                                                    href="{{ url('enquiry_detail', $packages_enquiry_data->id) }}"data-bs-toggle="tooltip"
                                                                    data-bs-placement="top" title="View Information">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @php $i++; @endphp
                                                @endforeach
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">No Data Found</td>
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
    </div>
@stop
@section('footer_js')


    <!-- Delete  Modal -->
    {{-- <div class="modal custom-modal fade" id="delete_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <h3>Are you sure want to Accept</h3>
                        <p></p>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" onclick="form_sub();">Yes</button>
                </div>
            </div>
        </div>
    </div> --}}
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
    <script>
        function filter_validation() {
            $('#filter_form').submit();
        }

        function Enquiry(id) {
            $('#delete_model_' + id).modal('show');
        }
    </script>
    <script>
        if ($.fn.DataTable.isDataTable('#enqury_table')) {
            $('#enqury_table').DataTable().destroy();
        }
        $(document).ready(function() {
            $('#enqury_table').dataTable({
                "searching": true,
                "order": [
                    [0, "desc"]
                ]
            });
        })
    </script>
@stop
