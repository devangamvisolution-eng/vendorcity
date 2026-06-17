@extends('admin.includes.Template')
@section('content')
    <style>
        /* [KEEP ALL YOUR EXISTING CSS STYLES HERE - NO CHANGES TO STYLE] */
        :root {
            --action-blue: #2563eb;
            --border-classic: #e2e8f0;
            --text-dark: #0f172a;
            --hover-bg: #f7df7e;
        }

        .content {
            overflow: visible !important;
        }

        .action-card {
            overflow: visible !important;
            background: #fff;
            border: 1px solid var(--border-classic);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding-top: 20px;
            display: flex;
            gap: 5px;
            justify-content: flex-end;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: #fff !important;
            border-radius: 50px !important;
            color: var(--text-dark) !important;
            font-weight: 600 !important;
            font-size: 12px !important;
            cursor: pointer;
            transition: all 0.2s;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--action-blue) !important;
            color: #fff !important;
            border-color: var(--action-blue) !important;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        }

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
            padding: 8px 12px;
            vertical-align: middle;
            font-size: 13px;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .stack-top {
            display: block;
            font-weight: 700;
            color: var(--text-dark);
        }

        .stack-bottom {
            display: block;
            font-size: 0.75rem;
            color: #64748b;
        }

        .btn-utility {
            background: #fff;
            border: 1px solid var(--border-classic);
            padding: 6px;
            border-radius: 6px;
            color: #64748b;
        }

        @media only screen and (max-width: 767px) {

            .action-card {
                overflow: scroll !important;
            }
        }
    </style>

    <div class="content container-fluid">
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">
                        {{-- Logic from backup for page titles --}}
                        @if (Route::currentRouteName() == 'cleaning-listing')
                            Package Order - Cleaning
                        @elseif(Route::currentRouteName() == 'painting-listing')
                            Package Order - Painting
                        @elseif(Route::currentRouteName() == 'salon-spa-listing')
                            Package Order - Salon & Spa
                        @elseif(Route::currentRouteName() == 'pest-control-listing')
                            Package Order - Pest Control
                        @elseif(Route::currentRouteName() == 'handyman-and-service-listing')
                            Package Order - Handyman & Service
                        @elseif(Route::currentRouteName() == 'car-inspection-order-listing')
                            Package Order - Car Inspection
                        @elseif(Route::currentRouteName() == 'automobile-vendor-order')
                            Package Order - Automobile
                        @elseif(Route::currentRouteName() == 'storage-vendor-listing')
                            Package Order - Storage
                        @else
                            Package Order - Moving
                        @endif
                    </h3>
                    <ul class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Order List</li>
                    </ul>
                </div>

                @if (in_array('40', $edit_perm))
                    <div class="col-auto">
                        @if (Route::currentRouteName() == 'cleaning-listing')
                            <a class="btn btn-primary" href="{{ route('cleaning-admin-order') }}">
                                <i class="fas fa-plus me-1"></i> Add Cleaning Order
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- Success/Error Messages from backup --}}
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">
            <strong>Success! </strong><span id="success_message"></span>
        </div>
        <div class="alert alert-danger alert-dismissible fade show error_show" style="display: none;">
            <strong>Failed! </strong><span id="error_message"></span>
        </div>

        <div class="action-card">
            <div class="card-body p-4">
                <form id="form" action="{{ route('delete_order') }}">
                    @csrf
                    <table class="action-table" id="example">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Created At</th>
                                <th>Client Name</th>
                                <th>Region</th>
                                <th>Amount</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($vendororders_list) && count($vendororders_list))
                                @foreach ($vendororders_list as $vendororders)
                                    <tr>
                                        <td>
                                            <span
                                                class="stack-top text-primary">#{{ $vendororders->format_order_id }}</span>
                                        </td>
                                        <td>{{ date('d M, Y', strtotime($vendororders->created_at)) }}</td>
                                        <td>
                                            <span class="stack-top">{{ $vendororders->user_name }}</span>
                                            <span class="stack-bottom">
                                                @if ($vendororders->paymentmode == '1')
                                                    Cash On Delivery
                                                @else
                                                    Online Payment
                                                @endif
                                            </span>
                                        </td>
                                        <td>{{ $vendororders->items[0]?->city ?? '' }}</td>
                                        <td>{{ number_format($vendororders->order_total, 2) }}</td>

                                        <td class="text-center">
                                            @if ($vendororders->order_status === 'P')
                                                <span class="badge bg-success">Booking Confirmed</span>
                                            @elseif($vendororders->order_status == 'PA')
                                                <span class="badge bg-info">Vendor Assigned</span>
                                            @elseif($vendororders->order_status == 'CO')
                                                <span class="badge bg-success">Booking Completed</span>
                                            @elseif($vendororders->order_status == 'CL')
                                                <span class="badge bg-danger">Booking Cancelled</span>
                                            @elseif($vendororders->order_status == 'BK')
                                                <span class="badge bg-info">Booking Requested</span>
                                            @endif
                                        </td>

                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-1">
                                                {{-- Action Buttons from backup --}}
                                                @if (isset($vendororders->items[0]) && isset($vendororders->items[0]->service_id))
                                                    @php
                                                        $detailRoute = 'vendor-moving-detail';
                                                        if ($vendororders->items[0]->subservice_id == 52) {
                                                            $detailRoute = 'vendor-handyman-and-service-detail';
                                                        } elseif ($vendororders->items[0]->service_id == 34) {
                                                            $detailRoute = 'vendor-painting-detail';
                                                        } elseif ($vendororders->items[0]->service_id == 45) {
                                                            $detailRoute = 'vendor-cleaning-detail';
                                                        } elseif ($vendororders->items[0]->service_id == 48) {
                                                            $detailRoute = 'vendor-salon-spa-detail';
                                                        } elseif ($vendororders->items[0]->service_id == 47) {
                                                            $detailRoute = 'vendor-pest-control-detail';
                                                        } elseif (
                                                            $vendororders->items[0]->service_id == 50 &&
                                                            $vendororders->items[0]->subservice_id == 92
                                                        ) {
                                                            $detailRoute = 'vendor-car-inspection-detail';
                                                        } elseif (
                                                            $vendororders->items[0]->service_id == 50 &&
                                                            $vendororders->items[0]->subservice_id != 92
                                                        ) {
                                                            $detailRoute = 'vendor-automobile-detail';
                                                        } elseif ($vendororders->items[0]->service_id == 44) {
                                                            $detailRoute = 'vendor-storage-detail';
                                                        }
                                                    @endphp
                                                    <a class="btn-utility"
                                                        href="{{ route($detailRoute, [$vendororders->order_id]) }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="View Details">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                @endif

                                                <button type="button" class="btn-utility"
                                                    onclick="assign_driver('{{ $vendororders->order_id }}');"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Assign Driver">
                                                    <i class="fas fa-truck"></i>
                                                </button>

                                                @if (Route::currentRouteName() == 'cleaning-listing')
                                                    @if (isset($vendororders->items[0]))
                                                        @if ($vendororders->items[0]->cleaner_id == 2)
                                                            <button type="button" class="btn-utility"
                                                                onclick="assign_cleaner('{{ $vendororders->order_id }}');"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Assign Crew">
                                                                <i class="fas fa-user"></i>
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn-utility"
                                                                onclick="assign_multi_cleaner('{{ $vendororders->order_id }}');"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Assign Multiple Crew">
                                                                <i class="fas fa-users"></i>
                                                            </button>
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
@stop

@section('footer_js')
    {{-- Keep all the Modal HTML and Scripts from the backup file here to ensure functionality --}}
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


    <!--- cleaner Modal Start-->
    @foreach ($vendororders_list as $key => $orders)
        @php
            $cleaner_data = DB::table('users')
                ->where('role_id', 16)
                ->where('is_active', '0')
                ->whereRaw('FIND_IN_SET(?, service)', [$orders->items[0]->service_id])
                ->whereRaw('FIND_IN_SET(?, subservice)', [$orders->items[0]->subservice_id])
                ->orderBy('id', 'ASC')
                ->get();
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
        <script>
            $(document).ready(function() {
                $('#multi_cleaner_{{ $orders->order_id }}').select2({
                    placeholder: "Select Multiple Crew",
                    dropdownParent: $('#multi_cleaner_model_{{ $orders->order_id }}')
                });
            });
        </script>
        @php
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

            var cleaner = jQuery("#cleaner_" + order_id).val();
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
