@extends('admin.includes.Template')
<style>
    /* --- Fit to Screen Optimization --- */
    :root {
        --primary-blue: #0f4b87;
        --deep-blue: #0a335d;
        --accent-orange: #f5aa5f;
    }

    /* Force the container and table to take exactly 100% width with no overflow */
    .content.container-fluid {
        padding-left: 15px;
        padding-right: 15px;
        overflow-x: hidden !important;
        /* Prevents horizontal scroll on the main page */
    }

    .table-responsive {
        overflow-x: hidden !important;
        /* Removes the scrollbar from the table container */
        width: 100%;
    }

    .table {
        width: 100% !important;
        table-layout: auto;
        /* Allows columns to breathe and fit into the available space */
        font-size: 14px !important;
        /* Small font to help fit more data */
        margin-bottom: 0 !important;
    }

    .table .thead-light th {
        background-color: #0052ea !important;
        color: #fff !important;
        border-color: #000;
    }

    @media only screen and (max-width: 767px) {

        .table-responsive {
            overflow-x: scroll !important;
        }
    }
</style>
@section('content')
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

    @endphp
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">

                    <h3 class="page-title">New Bookings</h3>

                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>

                        <li class="breadcrumb-item active">New Bookings</li>


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
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
        </div>
        <div class="alert alert-danger alert-dismissible fade show error_show" style="display: none;">
            <strong>Failed! </strong><span id="error_message"></span>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
        </div>
        <!-- Search Filter -->
        <div id="filter_inputs" class="card filter-card">
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Search Filter -->
        @php
            // echo"<pre>";print_r($vendororders_list);echo"</pre>";
        @endphp
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <form id="form" action="{{ route('delete_order') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <!-- <th>select</th> -->
                                            <th style="display: none">Sr no</th>
                                            <th>Order Id</th>
                                            <th>Created At</th>
                                            <th>Service Details</th>
                                            {{-- <th>Client</th>                                    --}}
                                            <th>Amount</th>
                                            <th>Payment</th>

                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @php
                                            $i = 1;
                                        @endphp

                                        @if (isset($vendororders_list) and count($vendororders_list))

                                            @foreach ($vendororders_list as $key => $vendororders)
                                                <tr>
                                                    <td style="display: none">{{ $i }}</td>
                                                    <td>
                                                        <a
                                                            href="{{ route('vendor-all-order-detail', [$vendororders->order_id]) }}">
                                                            <span
                                                                class="text-primary fw-bold">{{ $vendororders->format_order_id }}</span>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="d-block">{{ date('d M Y', strtotime($vendororders->created_at)) }}</span>
                                                        <small
                                                            class="text-muted">{{ date('h:i A', strtotime($vendororders->created_at)) }}</small>
                                                    </td>
                                                    <td>
                                                        <div class="fw-600 text-dark">
                                                            {!! isset($vendororders->items[0]) ? Helper::servicename($vendororders->items[0]->service_id) : '-' !!}
                                                        </div>
                                                        <small class="text-muted">
                                                            {!! isset($vendororders->items[0]) ? Helper::subservicename($vendororders->items[0]->subservice_id) : '-' !!}
                                                        </small>
                                                    </td>
                                                    {{-- <td>
                                                    <span class="d-block fw-bold">{{$vendororders->user_name}}</span>
                                                   <span class="badge bg-light text-dark border"><i class="fas fa-map-marker-alt me-1 text-danger"></i>{{ $vendororders->items[0]->city }}</span>
                                                </td> --}}
                                                    <td>{{ number_format($vendororders->order_total, 2) }}</td>
                                                    <td>
                                                        @if ($vendororders->paymentmode == '1')
                                                            <span class="text-muted small"><i
                                                                    class="fas fa-money-bill-wave text-success me-1"></i>
                                                                COD</span>
                                                        @else
                                                            <span class="text-muted small"><i
                                                                    class="fas fa-credit-card text-primary me-1"></i>
                                                                Online</span>
                                                        @endif
                                                    </td>


                                                    <td>
                                                        @php
                                                            $statusClasses = [
                                                                'BC' => 'bg-success-light text-success',
                                                                'P' => 'bg-success-light text-success',
                                                                'PA' => 'bg-info-light text-info',
                                                                'OTW' => 'bg-info-light text-info',
                                                                'IP' => 'bg-primary-light text-primary',
                                                                'CO' => 'bg-success-light text-success',
                                                                'CL' => 'bg-danger-light text-danger',
                                                                'BK' => 'bg-warning-light text-warning',
                                                                'UP' => 'bg-secondary-light text-secondary',
                                                            ];
                                                            $statusLabels = [
                                                                'BC' => 'Booking Confirmed',
                                                                'P' => 'Booking Confirmed',
                                                                'PA' => 'Vendor Assigned',
                                                                'OTW' => 'On the way',
                                                                'IP' => 'In progress',
                                                                'CO' => 'Booking Completed',
                                                                'CL' => 'Booking Cancelled',
                                                                'BK' => 'Booking Requested',
                                                                'UP' => 'Unpaid',
                                                            ];
                                                            $cls =
                                                                $statusClasses[$vendororders->order_status] ??
                                                                'bg-secondary-light text-secondary';
                                                            $lbl =
                                                                $statusLabels[$vendororders->order_status] ?? 'Pending';
                                                        @endphp
                                                        <span
                                                            class="badge rounded-pill {{ $cls }}">{{ $lbl }}</span>
                                                    </td>
                                                    <td>

                                                        <a href="{{ route('vendor-all-order-detail', [$vendororders->order_id]) }}"
                                                            class="btn btn-sm btn-white text-primary border me-2">
                                                            <i class="far fa-eye"></i>
                                                        </a>

                                                    </td>

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


    <!-- Assign Driver Modal -->
    <div class="modal custom-modal fade" id="assign_driver_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="assign_driver_form" action="{{ url('assign-driver-form') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="modal-text text-center">
                            <!-- <h3>Delete Expense Category</h3> -->
                            <!-- <p>Select Vendor</p> -->
                        </div>
                        <div class="modal-text text-center" id="driver_dropdownreplace">
                        </div>
                        <p class="form-error-text" id="driver_id_error" style="color: red; margin-top: 10px;"></p>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                            style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                        <button type="button" id="submit_button" class="btn btn-primary"
                            onclick="form_sub_driver();">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Assign Driver Modal -->

    <!--- cleaner Modal Start-->

    @foreach ($vendororders_list as $key => $orders)
        @php

            // echo"<pre>";print_r($orders);echo"</pre>";exit;
            $cleaner_data = DB::table('users')
                ->where('role_id', 16)
                ->where('is_active', '0')
                ->whereRaw('FIND_IN_SET(?, service)', [$orders->items[0]->service_id])
                ->whereRaw('FIND_IN_SET(?, subservice)', [$orders->items[0]->subservice_id])
                ->orderBy('id', 'ASC')
                ->get();
            //    echo"<pre>";print_r($cleaner_data);echo"</pre>";exit;
        @endphp
        <div class="modal custom-modal fade" id="cleaner_model_{{ $orders->order_id }}" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="cleaner_assign_form" action="{{ url('vendor-cleaner-assign-form') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <select name="cleaner" id="cleaner_{{ $orders->order_id }}" class="form-control">
                                <option value="">Select Cleaner</option>
                                @foreach ($cleaner_data as $data)
                                    @if ($data->id != 2)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <p class="form-error-text" id="cleaner_error_{{ $orders->order_id }}"
                                style="color: red; margin-top: 10px;"></p>
                        </div>

                        <div class="modal-footer text-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary mb-1" type="button" disabled
                                id="spinner_button_{{ $orders->order_id }}" style="display: none;">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                            <button type="button" class="btn btn-primary"
                                onclick="cleaner_assign({{ $orders->order_id }});"
                                id="cleaner_button_{{ $orders->order_id }}">Submit</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
        </div>
    @endforeach




    <!--- Cleaner Modal Close --->


    <!--- Multi cleaner Modal Start -->

    @foreach ($vendororders_list as $key => $orders)
        {{-- @php
    // echo"<pre>";print_r($orders);echo"</pre>";exit;
    @endphp --}}
        <script>
            $(document).ready(function() {
                $('#multi_cleaner_{{ $orders->order_id }}').select2({
                    placeholder: "Select Multiple Crew",
                    dropdownParent: $('#multi_cleaner_model_{{ $orders->order_id }}')
                });
            });
        </script>

        @php
            // echo"<pre>";print_r($orders->items[0]);echo"</pre>";exit;
            $cleaner_data = DB::table('users')
                ->where('role_id', 16)
                ->where('is_active', '0')
                ->whereRaw('FIND_IN_SET(?, service)', [$orders->items[0]->service_id])
                ->whereRaw('FIND_IN_SET(?, subservice)', [$orders->items[0]->subservice_id])
                ->orderBy('id', 'ASC')
                ->get();

        @endphp
        <div class="modal custom-modal fade" id="multi_cleaner_model_{{ $orders->order_id }}" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="multi_cleaner_assign_form" action="{{ url('vendor-multi-cleaner-assign-form') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <select name="multi_cleaner_{{ $orders->order_id }}"
                                id="multi_cleaner_{{ $orders->order_id }}" class="form-control" multiple="mulitple"
                                onchange="vendor_multi_cleaner_timeslot({{ $orders->order_id }},{{ $orders->items[0]->subservice_id }});"
                                data-max-select="{{ $orders->items[0]->how_many_cleaners_do_you_need }}">
                                @foreach ($cleaner_data as $data)
                                    @if ($data->id != 2)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endif
                                @endforeach
                            </select>

                            <p class="form-error-text" id="multi_cleaner_error_{{ $orders->order_id }}"
                                style="color: red; margin-top: 10px;"></p>

                            <div class="modal-footer text-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary mb-1" type="button" disabled
                                    id="multi_spinner_button_{{ $orders->order_id }}" style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary"
                                    onclick="multi_cleaner_assign({{ $orders->order_id }} ,{{ $orders->items[0]->how_many_cleaners_do_you_need }})"
                                    id="multi_cleaner_button_{{ $orders->order_id }}">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach




    <!--- Multi Cleaner Modal Close --->
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

        function assign_cleaner(order_id) {

            $('#cleaner_model_' + order_id).modal('show');

        }

        function assign_multi_cleaner(order_id) {

            $('#multi_cleaner_model_' + order_id).modal('show');

        }

        function assign_driver(order_id) {

            var url = '{{ url('assign-driver') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": order_id
                },
                success: function(msg) {
                    document.getElementById('driver_dropdownreplace').innerHTML = msg;
                    $('#assign_driver_model').modal('show');

                }
            });
        }

        function form_sub_driver() {
            var driver_id = jQuery("#driver_id").val();
            if (driver_id == '') {
                jQuery('#driver_id_error').html("Please Select Driver");
                jQuery('#driver_id_error').show().delay(0).fadeIn('show');
                jQuery('#driver_id_error').show().delay(2000).fadeOut('show');

                return false;
            }
            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#assign_driver_form').submit();
        }

        function vendor_multi_cleaner_timeslot(order_id, subservice_id) {

            var selectElement = jQuery("#multi_cleaner_" + order_id);
            var maxSelect = selectElement.data("max-select"); // Get the max selection count
            var selectedOptions = selectElement.val();


            if (subservice_id == 28) {
                if (selectedOptions.length > maxSelect) {
                    alert("You can only select up to " + maxSelect + " Crew.");
                    // Deselect the last selected option
                    selectedOptions.pop();
                    selectElement.val(selectedOptions);

                    // Trigger change event to update UI
                    selectElement.trigger('change');
                    return;
                }
            }

            var url = '{{ url('vendor-multi-cleaner-time-slot') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "cleaner": selectedOptions,
                    "order_id": order_id
                },
                success: function(response) {
                    const notAvailable = response.not_available_cleaners?.trim();
                    if (notAvailable && notAvailable !== '-') {
                        var cleanerName = response.not_available_cleaners;
                        alert('This Crew is not available: ' + cleanerName);
                    }

                    var cleanerIds = response.not_available_cleaners_id;
                    if (cleanerIds && cleanerIds.length > 0) {
                        cleanerIds.forEach(function(id) {
                            var option = selectElement.find(`option[value="${id}"]`);
                            if (option.length) {
                                option.prop('selected', false); // Deselect unavailable option
                            }
                        });

                        // Trigger change event to update UI
                        selectElement.trigger('change');
                    }
                }
            });
        }


        //Multiple Cleaner Assign Popup Submit

        function multi_cleaner_assign(order_id, cleaner_count) {

            var cleaner = jQuery("#multi_cleaner_" + order_id).val();

            if (cleaner == '' || cleaner == null) {
                jQuery('#multi_cleaner_error_' + order_id).html("Please Select Crew");
                jQuery('#multi_cleaner_error_' + order_id).show().delay(2000).fadeOut('show');
                return false;
            }

            // Count the selected cleaners
            let selected_cleaner_count = Array.isArray(cleaner) ? cleaner.length : 0;

            if (selected_cleaner_count < cleaner_count) {
                jQuery('#multi_cleaner_error_' + order_id).html('Please select ' + cleaner_count + ' cleaners');
                jQuery('#multi_cleaner_error_' + order_id).show().delay(2000).fadeOut('show');
                return false;
            }
            $('#multi_cleaner_button_' + order_id).hide();
            $('#multi_spinner_button_' + order_id).show();

            var url = '{{ url('vendor-multi-cleaner-assign-form') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": order_id,
                    "cleaner": cleaner,
                },
                success: function(response) {
                    if (response.status == 1) {
                        $('#success_message').text("Multiple Crew Assigned Successfully");
                        $('.success_show').fadeIn().delay(1000).fadeOut();
                        $('#multi_cleaner_model_' + response.order_id).modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                }
            });
        }
        //Multiple Cleaner Assign Popup Submit End

        //Auto assign Cleaner Popoup Submit
        function cleaner_assign(order_id) {

            // alert(order_id);
            // return false;

            var cleaner = jQuery("#cleaner_" + order_id).val();
            // alert(cleaner);

            if (cleaner == '') {
                jQuery('#cleaner_error_' + order_id).html("Please Select Crew");
                jQuery('#cleaner_error_' + order_id).show().delay(2000).fadeOut('show');
                return false;
            }

            $('#cleaner_button_' + order_id).hide();
            $('#spinner_button_' + order_id).show();

            var url = '{{ url('vendor-cleaner-assign-form') }}';

            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": order_id,
                    "cleaner": cleaner,
                },
                success: function(response) {
                    if (response.status == 1) {
                        $('#success_message').text("Crew Assigned Successfully");
                        $('.success_show').fadeIn().delay(1000).fadeOut();
                        $('#cleaner_model_' + response.order_id).modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else if (response.status == 0) {
                        $('#cleaner_model_' + response.order_id).modal('hide');
                        $('#error_message').text(response.message);
                        $('.error_show').fadeIn().delay(1000).fadeOut();

                        // setTimeout(function() {location.reload();},1500);
                    }
                }
            });
        }
        //Auto assign Cleaner Popup Submit End
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
