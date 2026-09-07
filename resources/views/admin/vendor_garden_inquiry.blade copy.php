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
        #delete_model_1 .modal-dialog {
            max-width: 50% !important;
        }
    </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Garden and Mouse Inquiry</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Garden and Mouse Inquiry</li>
                    </ul>
                </div>
                <div class="col-auto">
                    {{-- <a class="btn btn-primary me-1" href="javascript:void('0');" onclick="excel_download();">Excel Download</a> --}}

                    {{-- <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                        <i class="fas fa-filter"></i>
                    </a> --}}

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
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
        </div>
        <!-- Search Filter -->

        <!-- Search Filter -->
        <div id="filter_inputs" class="card filter-card">
            <div class="card-body pb-0">
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
        <!-- /Search Filter -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <form id="form" action="" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf

                            @php
                                $userId = Auth::id();
                                $currentDate = now();

                                $vendor_subscription = DB::table('subscription')
                                    ->select('*')
                                    ->where('vendor_id', '=', $userId)
                                    ->where('is_deleted', '=', '0')
                                    // ->where('enddate', '>=', $currentDate)
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
                                            'subs_id' => $vendor_subscription_data->id,
                                            'service_id' => $vendor_subscription_att_data->service_id,
                                            'subservice_id' => $vendor_subscription_att_data->subservice_id,
                                            'city_id' => $vendor_subscription_data->city,
                                            'country_id' => $vendor_subscription_data->country,
                                            'to_country' => $vendor_subscription_data->to_country,
                                            'type_of_package' => $vendor_subscription_data->type_of_package,
                                        ];
                                    }
                                }

                                $combined_data = [];

                                foreach ($resultArray as $resultArray_data) {
                                    if ($resultArray_data['type_of_package'] == '0') {
                                        $typeInquiry = 'Local Move';
                                    }

                                    $packages_enquiry = DB::table('packages_enquiry')
                                        ->select('*')
                                        ->where('service_id', '=', $resultArray_data['service_id'])
                                        ->where('subservice_id', '=', $resultArray_data['subservice_id'])
                                        ->where('count', '<', 5)
                                        ->orderBy('id', 'desc')
                                        ->get();

                                    foreach ($packages_enquiry as $packages_enquiry_da) {
                                        if (
                                            ($packages_enquiry_da->service_id == 47 &&
                                                $packages_enquiry_da->subservice_id == 77) ||
                                            ($packages_enquiry_da->service_id == 47 &&
                                                $packages_enquiry_da->subservice_id == 78)
                                        ) {
                                            $garden_data = DB::table('garden_enquiry')
                                                ->where('inquiry_id', $packages_enquiry_da->id)
                                                ->first();

                                            if (!empty($garden_data->city)) {
                                                $city_data = DB::table('cities')
                                                    ->where('id', $garden_data->city)
                                                    ->first();

                                                $subs_city = explode(',', $resultArray_data['city_id']);

                                                if (
                                                    in_array($city_data->id, $subs_city) &&
                                                    isset($resultArray_data['type_of_package']) &&
                                                    $resultArray_data['type_of_package'] == '0'
                                                ) {
                                                    $combined_data[] = $packages_enquiry_da->id;
                                                }
                                            }
                                        }
                                    }
                                }

                                $uniqueArray = [];

                                foreach ($resultArray as $entry) {
                                    // Create a unique key for each combination
                                    $key = $entry['service_id'] . '_' . $entry['subservice_id'];

                                    // Check if the combination already exists in the unique array
                                    if (!isset($uniqueArray[$key])) {
                                        // If not, add it to the unique array
                                        $uniqueArray[$key] = $entry;
                                    }
                                }

                                $resultArray = array_values($uniqueArray);

                                // echo"<pre>";print_r($resultArray);echo"</pre>";exit;

                            @endphp

                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="enqury_table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="display: none;">Sr No</th>
                                            <th>Date</th>
                                            <th>Inquiry No</th>
                                            <th>Name</th>
                                            <th>Service</th>
                                            <th>Sub Service</th>
                                            <th>Lead Info</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($all_data != '')
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($resultArray as $resultArray_data)
                                                @php

                                                    $packages_enquiry = DB::table('packages_enquiry')
                                                        ->select('*')
                                                        ->where('service_id', '=', $resultArray_data['service_id'])
                                                        ->where(
                                                            'subservice_id',
                                                            '=',
                                                            $resultArray_data['subservice_id'],
                                                        )
                                                        ->where('count', '<', 5)
                                                        ->orderBy('id', 'desc')
                                                        ->get();
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
                                                        @if (in_array($packages_enquiry_data->id, $combined_data))
                                                            <tr>
                                                                <td style="display: none">{{ $i }}</td>
                                                                <td>{{ date('d-m-Y', strtotime($packages_enquiry_data->added_date)) }}
                                                                </td>
                                                                <td>{{ $packages_enquiry_data->inquiry_id }}</td>
                                                                <td>{{ $packages_enquiry_data->name }}</td>
                                                                <td>
                                                                    @if ($packages_enquiry_data->service_id != '')
                                                                        {!! Helper::servicename(strval($packages_enquiry_data->service_id)) !!}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($packages_enquiry_data->subservice_id != '')
                                                                        {!! Helper::subservicename(strval($packages_enquiry_data->subservice_id)) !!}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-primary"
                                                                        href="{{ url('garden-enquiry-detail', $packages_enquiry_data->id) }}">View
                                                                        Information</a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach
                                            @endforeach
                                        @else
                                            <p>No Data Found</p>
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
