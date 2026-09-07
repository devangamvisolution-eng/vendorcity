@extends('admin.includes.Template')
@section('content')
    <style>
        /* ACTION-FIRST DESIGN SYSTEM */
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

        /* PREMIUM PAGINATION STYLE - EXACTLY AS PER SCREENSHOT */
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

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--action-blue) !important;
            color: #fff !important;
            border-color: var(--action-blue) !important;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        }

        /* Table Styling - UPDATED FOR REDUCED GAPS */
        .action-table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        .action-table thead th {
            background: #4c7aef;
            padding: 10px 12px;
            /* Reduced from 15px 20px */
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #ffffff;
            border-bottom: 2px solid var(--border-classic);

            /* Sticky Properties */
            position: sticky;
            top: var(--admin-header-height);
            /* This keeps it below the top nav */
            z-index: 100;
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
            box-shadow: inset 0 -1px 0 var(--border-classic);
        }

        .action-table tbody tr {
            border-bottom: 1px solid var(--border-classic);
            transition: background 0.15s;
        }

        .action-table tbody tr:hover {
            background-color: var(--hover-bg) !important;
        }

        .action-table td {
            padding: 8px 12px;
            /* Reduced from 16px 20px to close column and row gaps */
            vertical-align: middle;
            font-size: 13px;
            color: var(--text-dark);
            line-height: 1.2;
            /* Tighter line height for stacked text */
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
            /* Reduced from 8px */
            border-radius: 6px;
            color: #64748b;
        }

        table.dataTable td,
        table.dataTable th {
            -webkit-box-sizing: content-box;
            box-sizing: content-box;
            border-bottom: 1px solid cornflowerblue;
        }
    </style>

    <div class="content container-fluid">
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Package Order - Car Inspection</h3>
                    <ul class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Order List</li>
                    </ul>
                </div>
                <div class="col-auto">
                    @if (Route::currentRouteName() == 'car-inspection-order')
                        <a class="btn btn-primary" href="{{ route('car-inspection-admin-order') }}">
                            <i class="fas fa-plus me-1"></i> Add Car Inspection Order
                        </a>
                    @endif
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="action-card">
            <div class="card-body p-4">
                <form id="form" action="{{ route('delete_order') }}">
                    @csrf
                    <table class="action-table" id="example">
                        <thead>
                            <tr>
                                <th>Order Detail</th>
                                <th>Inspection Date</th>
                                <th>Customer & Service</th>
                                <th>Amount & Payment</th>
                                <th>Status</th>
                                <th class="text-center">Assign</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($orders_list) && count($orders_list))
                                @foreach ($orders_list as $orders)
                                    @if (!empty($orders->items))
                                        <tr>
                                            <td>
                                                <span class="stack-top text-primary">#{{ $orders->format_order_id }}</span>
                                                <span
                                                    class="stack-bottom">{{ date('d M, Y', strtotime($orders->created_at)) }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $date = $orders->items[0]->bookingdate ?? '';
                                                    $month = $orders->items[0]->month ?? '';
                                                    $year = $orders->items[0]->bookingyear ?? '';
                                                    $timeSlot = Helper::timeslotname(
                                                        strval($orders->items[0]->time_slot),
                                                    );
                                                @endphp
                                                @if ($date != '' && $month != '')
                                                    <span class="stack-top">{{ $month }} {{ $date }},
                                                        {{ $year }}</span>
                                                    <span class="stack-bottom text-muted small"><i
                                                            class="far fa-clock me-1"></i>{{ $timeSlot }}</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <span class="stack-top">{{ $orders->user_name }}</span>
                                                <span class="stack-bottom">{!! isset($orders->items[0]) ? Helper::subservicename($orders->items[0]->subservice_id) : '-' !!}</span>
                                            </td>
                                            <td>
                                                <span class="stack-top">{{ number_format($orders->order_total, 2) }}</span>
                                                <span class="stack-bottom">
                                                    @if ($orders->paymentmode == '1')
                                                        COD
                                                    @else
                                                        Online
                                                    @endif
                                                    | {{ $orders->payment_status }}
                                                </span>
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm mb-1 fw-bold"
                                                    style="font-size: 11px;"
                                                    onchange="order_status_change({{ $orders->order_id }}, this)">
                                                    <option value="P"
                                                        {{ $orders->order_status === 'P' ? 'selected' : '' }}>Confirmed
                                                    </option>
                                                    <option value="PA"
                                                        {{ $orders->order_status === 'PA' ? 'selected' : '' }}>Vendor
                                                        Assigned</option>
                                                    <option value="CO"
                                                        {{ $orders->order_status === 'CO' ? 'selected' : '' }}>Completed
                                                    </option>
                                                    <option value="CL"
                                                        {{ $orders->order_status === 'CL' ? 'selected' : '' }}>Cancelled
                                                    </option>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    @if ($orders->payment_status == 'Success')
                                                        <button type="button" class="btn-utility"
                                                            onclick="assign_vendor('{{ $orders->order_id }}');"
                                                            title="Assign Vendor">
                                                            <i class="fas fa-user-friends"></i>
                                                        </button>
                                                    @else
                                                        <span class="text-muted small">Pending Payment</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle fw-bold"
                                                        type="button" data-bs-toggle="dropdown">
                                                        Manage
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow border-0">
                                                        <a class="dropdown-item"
                                                            href="{{ route('car-inspection-detail', [$orders->order_id]) }}">
                                                            <i class="far fa-eye me-2"></i>Details
                                                        </a>
                                                        @if (in_array('58', $edit_perm))
                                                            <a class="dropdown-item" href="#"
                                                                onclick="updatepopup('{{ $orders->items[0]->end_date }}','{{ $orders->items[0]->time_slot }}','{{ $orders->items[0]->order_id }}');">
                                                                <i class="far fa-edit me-2"></i>Update Date
                                                            </a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('car-inspection-document-upload', ['id' => $orders->order_id]) }}">
                                                                <i class="fas fa-file-upload me-2"></i>Documents
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
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
    <!-- End Date  Modal -->
    <div class="modal custom-modal fade" id="end_date_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-icon text-center mb-3">
                        <label>Set End Date</label>
                    </div>
                    <div class="modal-text text-center">
                        <input type="hidden" id="end_date_order_id" name="end_date_order_id">
                        <input type="date" name="end_date" id="end_date" class="form-control"
                            placeholder="Select End Date">
                        <p class="form-error-text" id="end_date_error" style="color: red; margin-top: 10px;"></p>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary mb-1" type="button" disabled id="end_date_spinner"
                        style="display: none;">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...</button>
                    <button type="button" id="end_date_submit" class="btn btn-primary"
                        onclick="end_date_form_sub();">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /End Date Modal -->
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
    <!--- Salesperson Modal Start-->
    @foreach ($orders_list as $key => $orders)
        @php
            // echo"<pre>";print_r($orders);echo"</pre>";exit;
            $salesperson_data = DB::table('users')
                ->whereIn('role_id', [11, 12])
                ->where('is_active', '0')
                ->get();

        @endphp
        <div class="modal custom-modal fade" id="assign_salesperson_model_{{ $orders->order_id }}" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="salesperson_assign_form" action="{{ url('salesperson-assign-form') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <select name="cleaner" id="salesperson_{{ $orders->order_id }}" class="form-control">
                                <option value="">Select Salesperson</option>
                                @foreach ($salesperson_data as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                            <p class="form-error-text" id="salesperson_error_{{ $orders->order_id }}"
                                style="color: red; margin-top: 10px;"></p>
                        </div>
                        <div class="modal-footer text-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary mb-1" type="button" disabled
                                id="salesperson_spinner_button_{{ $orders->order_id }}" style="display: none;">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                            <button type="button" class="btn btn-primary"
                                onclick="salesperson_assign({{ $orders->order_id }});"
                                id="salesperson_button_{{ $orders->order_id }}">Submit</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
        </div>
    @endforeach
    <!--- Salesperson Modal Close --->
    <!--- Location Link Modal Start-->
    @foreach ($orders_list as $key => $orders)
        <div class="modal custom-modal fade" id="location_link_model_{{ $orders->order_id }}" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="cleaner_assign_form" action="{{ url('location-link-form') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" name="location_link" id="location_link_{{ $orders->order_id }}"
                                    class="form-control" placeholder="Enter Location Link">
                            </div>
                            <p class="form-error-text" id="location_link_error_{{ $orders->order_id }}"
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
                                onclick="location_link_added({{ $orders->order_id }});"
                                id="cleaner_button_{{ $orders->order_id }}">Submit</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
        </div>
    @endforeach
    <!--- Location Link Modal End-->
    <!--- cleaner Modal Start-->
    @foreach ($orders_list as $key => $orders)
        @php
            // echo"<pre>";print_r($orders);echo"</pre>";exit;
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
                    <form id="cleaner_assign_form" action="{{ url('cleaner-assign-form') }}" method="POST"
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
    @foreach ($orders_list as $key => $orders)
        {{-- @php
    // echo"<pre>";print_r($orders);echo"</pre>";exit;
    @endphp --}}
        <script>
            $(document).ready(function() {
                $('#multi_cleaner_{{ $orders->order_id }}').select2({
                    placeholder: "Select Multiple Cleaners",
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
                    <form id="multi_cleaner_assign_form" action="{{ url('multi-cleaner-assign-form') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <select name="multi_cleaner_{{ $orders->order_id }}"
                                id="multi_cleaner_{{ $orders->order_id }}" class="form-control" multiple="mulitple"
                                onchange="multi_cleaner_timeslot({{ $orders->order_id }},{{ $orders->items[0]->subservice_id }});"
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
    <!--- Per Cleaner Price Modal Start--->
    @foreach ($orders_list as $key => $orders)
        <div class="modal custom-modal fade" id="add_cleaner_price_model_{{ $orders->order_id }}" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="add_cleaner_price_form" action="{{ url('add-cleaner-price-form') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <lable>Add Per Cleaner Price</lable>
                            <input type="number" name="cleaner_price_{{ $orders->order_id }}"
                                id="cleaner_price_{{ $orders->order_id }}" class="form-control">
                            <p class="form-error-text" id="cleaner_price_error_{{ $orders->order_id }}"
                                style="color: red; margin-top: 10px;"></p>

                            <div class="modal-footer text-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary mb-1" type="button" disabled
                                    id="add_spinner_button_{{ $orders->order_id }}" style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary"
                                    onclick="add_cleaner_price_popup({{ $orders->order_id }})"
                                    id="add_cleaner_price_{{ $orders->order_id }}">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <!--- Per Cleaner Price Modal Close--->
    <!-- Assign Vendor  Modal -->
    <div class="modal custom-modal fade" id="assign_vendor_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="order_vendor_form" action="{{ url('order_vendor_form') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="painting_order" value="{{ Route::currentRouteName() }}">


                    <div class="modal-body">

                        <div class="modal-text text-center">
                            <!-- <h3>Delete Expense Category</h3> -->
                            <!-- <p>Select Vendor</p> -->
                        </div>
                        <div class="modal-text text-center" id="dropdownreplace">
                        </div>
                        <p class="form-error-text" id="vendor_id_error" style="color: red; margin-top: 10px;"></p>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                            style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                        <button type="button" class="btn btn-primary" onclick="form_sub_vendor();"
                            id="vedor_submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal custom-modal fade" id="update_popup_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="order_inspection_form" action="{{ url('car_inpsection_form') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="car_inpsection_order" id="car_inpsection_order" value="">


                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="update_inspection_date" id="update_inspection_date"
                                        class="form-control" value="">
                                    <p class="form-error-text" id="add_amount_error{{ $orders->order_id }}"
                                        style="color: red; margin-top: 10px;"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Time</label>
                                    <select name="update_inspection_time" id="update_inspection_time"
                                        class="form-select">
                                        <option value="">Select Time</option>
                                        @foreach ($subservice_timeslot_price as $data)
                                            <option value="{{ $data->time_slot_id }}">{{ $data->name }}</option>
                                        @endforeach

                                    </select>
                                    <p class="form-error-text" id="add_amount_error{{ $orders->order_id }}"
                                        style="color: red; margin-top: 10px;"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                            style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                        <button type="button" class="btn btn-primary" onclick="form_sub_vendor();"
                            id="vedor_submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Assign Vendor Modal -->
    <!--Add Amount Modal -->
    @if (isset($orders_list) and count($orders_list))
        @foreach ($orders_list as $key => $orders)
            <div class="modal custom-modal fade" id="add_amount_model{{ $orders->order_id }}" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form id="add_amount_form{{ $orders->order_id }}" action="{{ url('add_amount_form') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="painting_order" value="painting-service-order">
                                <input type="hidden" name="cleaning_order" value="">
                                <div class="modal-text">
                                    @php
                                        $service_data = DB::table('ci_order_item')
                                            ->where('order_id', $orders->order_id)
                                            ->first();
                                    @endphp
                                    <input type="hidden" name="order_id" value="{{ $orders->order_id }}">
                                    <input type="hidden" name="service_id" value="{{ $service_data->service_id }}">
                                    <input type="hidden" name="order_total" value="{{ $orders->order_total }}">
                                    <div class="form-group text-center">
                                        <label>Total Amount:AED {{ number_format($orders->order_total, 2) }} </label>
                                    </div>
                                    <div class="form-group">
                                        <label>Add Amount</label>
                                        <input type="number" name="add_amount" id="add_amount{{ $orders->order_id }}"
                                            class="form-control" placeholder="Add Amount">
                                        <p class="form-error-text" id="add_amount_error{{ $orders->order_id }}"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>

                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" name="date" id="date{{ $orders->order_id }}"
                                            class="form-control" placeholder="Date">
                                        <p class="form-error-text" id="date_error{{ $orders->order_id }}"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Colllect By</label>
                                        <select class="form-control" name="collect_by"
                                            id="collect_by{{ $orders->order_id }}">
                                            <option value="">Select Colllect By</option>
                                            <option value="Vendorscity">Vendorscity</option>
                                            <option value="Vendor">Vendor</option>
                                        </select>
                                        <p class="form-error-text" id="collect_by_error{{ $orders->order_id }}"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Payment Type</label>
                                        <select class="form-control" name="payment_type"
                                            id="payment_type{{ $orders->order_id }}">
                                            <option value="">Select Payment Type</option>
                                            <option value="Online">Online</option>
                                            <option value="Cash">Cash</option>
                                        </select>
                                        <p class="form-error-text" id="payment_type_error{{ $orders->order_id }}"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                @php
                                    $package_order_amount_attr_data = DB::table('package_order_amount_attr')
                                        ->where('order_id', $orders->format_order_id)
                                        ->get();
                                    // echo"<pre>";print_r($package_order_amount_attr_data);echo"</pre>";exit;
                                    $total_add_amount = $package_order_amount_attr_data->sum('add_amount');
                                    $balance_amount = $orders->order_total - $total_add_amount;
                                @endphp
                                <div class="form-group">
                                    <label>Amount Details : (Balance Amount :AED {{ $balance_amount }})</label>
                                </div>
                                @foreach ($package_order_amount_attr_data as $data)
                                    <div class="form-group">
                                        <label>{{ $data->date }} : AED {{ $data->add_amount }}</label>
                                    </div>
                                @endforeach
                            </div>


                            <div class="modal-footer text-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary mb-1" type="button" disabled
                                    id="spinner_button{{ $orders->order_id }}" style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary"
                                    onclick="add_amount_popup('{{ $orders->order_id }}');"
                                    id="submit_button{{ $orders->order_id }}">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <!--Add Amount Modal -->
    <script>
        function delete_cleaning_order() {
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

        function set_end_date(order_id) {
            $('#end_date_order_id').val(order_id);
            $('#end_date_model').modal('show');
        }

        function end_date_form_sub() {
            var end_date = jQuery("#end_date").val();
            var end_date_order_id = jQuery("#end_date_order_id").val();
            if (end_date == '') {
                jQuery('#end_date_error').html("Please Select End Date");
                jQuery('#end_date_error').show().delay(0).fadeIn('show');
                jQuery('#end_date_error').show().delay(2000).fadeOut('show');

                return false;
            }
            $('#end_date_submit').hide();
            $('#end_date_spinner').show();

            $.ajax({
                url: '{{ url('set-end-date') }}',
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "end_date": end_date,
                    "order_id": end_date_order_id
                },
                success: function(response) {
                    if (response.status == 1) {
                        $('#end_date_model').modal('hide');
                        $('#success_message').text("End Date Set Successfully");
                        $('.success_show').fadeIn().delay(1000).fadeOut();
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                }
            });
        }

        function form_sub_vendor() {
            // var vendor_id = jQuery("#vendor_id").val();
            //     if (vendor_id == '') {
            //         jQuery('#vendor_id_error').html("Please Select Vendor");
            //         jQuery('#vendor_id_error').show().delay(0).fadeIn('show');
            //         jQuery('#vendor_id_error').show().delay(2000).fadeOut('show');

            //         return false;
            //     }
            $('#vedor_submit').hide();
            $('#spinner_button').show();
            $('#order_vendor_form').submit();
        }

        function add_amount_popup(order_id) {
            var add_amount = jQuery("#add_amount" + order_id).val();
            if (add_amount == '') {
                jQuery('#add_amount_error' + order_id).html("Please Add Amount");
                jQuery('#add_amount_error' + order_id).show().delay(0).fadeIn('show');
                jQuery('#add_amount_error' + order_id).show().delay(2000).fadeOut('show');

                return false;
            }
            var date = jQuery("#date" + order_id).val();
            if (date == '') {
                jQuery('#date_error' + order_id).html("Please Select Date");
                jQuery('#date_error' + order_id).show().delay(0).fadeIn('show');
                jQuery('#date_error' + order_id).show().delay(2000).fadeOut('show');

                return false;
            }
            var collect_by = jQuery("#collect_by" + order_id).val();
            if (collect_by == '') {
                jQuery('#collect_by_error' + order_id).html("Please Select Collect By");
                jQuery('#collect_by_error' + order_id).show().delay(0).fadeIn('show');
                jQuery('#collect_by_error' + order_id).show().delay(2000).fadeOut('show');

                return false;
            }
            var payment_type = jQuery("#payment_type" + order_id).val();
            if (payment_type == '') {
                jQuery('#payment_type_error' + order_id).html("Please Select Payment Type");
                jQuery('#payment_type_error' + order_id).show().delay(0).fadeIn('show');
                jQuery('#payment_type_error' + order_id).show().delay(2000).fadeOut('show');

                return false;
            }
            var url = '{{ url('checkAmountorder') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": order_id,
                    "add_amount": add_amount,
                },
                success: function(returnedData) {
                    if (returnedData == 0) {
                        $('#payment_type_error' + order_id).text(
                            "Added Amount Should Less than Balance Amount");
                    } else {
                        $('#spinner_button' + order_id).show();
                        $('#submit_button' + order_id).hide();
                        $('#add_amount_form' + order_id).submit();
                    }

                }
            });

        }

        function assign_cleaner(order_id) {
            $('#cleaner_model_' + order_id).modal('show');
        }

        function assign_salesperson(order_id) {
            $('#assign_salesperson_model_' + order_id).modal('show');
        }

        function location_link(order_id) {
            $('#location_link_model_' + order_id).modal('show');
        }

        function location_link_added(order_id) {
            var location_link = jQuery("#location_link_" + order_id).val();
            if (location_link == '' || location_link == null) {
                jQuery('#location_link_error_' + order_id).html("Please Enter Location Link");
                jQuery('#location_link_error_' + order_id).show().delay(2000).fadeOut('show');
                return false;
            }
            $('#cleaner_button_' + order_id).hide();
            $('#spinner_button_' + order_id).show();
            var url = '{{ url('location-link-form') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": order_id,
                    "location_link": location_link,
                },
                success: function(response) {
                    if (response.status == 1) {
                        $('#success_message').text("Location Link Added Successfully");
                        $('.success_show').fadeIn().delay(1000).fadeOut();
                        $('#location_link_model_' + response.order_id).modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                }
            });
        }
        //Auto assign Cleaner Popoup Submit
        function cleaner_assign(order_id) {

            var cleaner = jQuery("#cleaner_" + order_id).val();
            // alert(cleaner);

            if (cleaner == '') {
                jQuery('#cleaner_error_' + order_id).html("Please Select Cleaner");
                jQuery('#cleaner_error_' + order_id).show().delay(2000).fadeOut('show');
                return false;
            }
            $('#cleaner_button_' + order_id).hide();
            $('#spinner_button_' + order_id).show();
            var url = '{{ url('cleaner-assign-form') }}';
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

        function assign_multi_cleaner(order_id) {
            $('#multi_cleaner_model_' + order_id).modal('show');
        }

        function add_cleaner_price(order_id) {
            $('#add_cleaner_price_model_' + order_id).modal('show');
        }
        // Add Cleaner Price Popup submit

        function add_cleaner_price_popup(order_id) {
            var cleaner_price = jQuery("#cleaner_price_" + order_id).val();
            if (cleaner_price == '' || cleaner_price == null) {
                jQuery('#cleaner_price_error_' + order_id).html("Please Enter Cleaner Price");
                jQuery('#cleaner_price_error_' + order_id).show().delay(2000).fadeOut('show');
                return false;
            }
            $('#add_cleaner_price_' + order_id).hide();
            $('#add_spinner_button_' + order_id).show();
            var url = '{{ url('add-cleaner-price-form') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": order_id,
                    "cleaner_price": cleaner_price,
                },
                success: function(response) {
                    if (response.status == 1) {
                        $('#success_message').text("Crew Price added Successfully");
                        $('.success_show').fadeIn().delay(1000).fadeOut();
                        $('#add_cleaner_price_model_' + response.order_id).modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                }
            });
            // alert(order_id);
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
            var url = '{{ url('multi-cleaner-assign-form') }}';
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
        //Assign Salesperson Popup Submit

        function salesperson_assign(order_id) {
            var salesperson = jQuery("#salesperson_" + order_id).val();
            if (salesperson == '' || salesperson == null) {
                jQuery('#salesperson_error_' + order_id).html("Please Select SalesPerson");
                jQuery('#salesperson_error_' + order_id).show().delay(2000).fadeOut('show');
                return false;
            }
            $('#salesperson_button_' + order_id).hide();
            $('#salesperson_spinner_button_' + order_id).show();
            var url = '{{ url('salesperson-assign-form') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": order_id,
                    "salesperson_id": salesperson,
                },
                success: function(response) {
                    if (response.status == 1) {
                        $('#success_message').text("SalesPerson Assigned Successfully");
                        $('.success_show').fadeIn().delay(1000).fadeOut();
                        $('#assign_salesperson_model_' + response.order_id).modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);

                    }
                }
            });
        }

        function multi_cleaner_timeslot(order_id, subservice_id) {
            var selectElement = jQuery("#multi_cleaner_" + order_id);
            var maxSelect = selectElement.data("max-select"); // Get the max selection count
            var selectedOptions = selectElement.val();
            if (subservice_id == 28) {
                if (selectedOptions.length > maxSelect) {
                    alert("You can only select up to " + maxSelect + " cleaners.");
                    // Deselect the last selected option
                    selectedOptions.pop();
                    selectElement.val(selectedOptions);

                    // Trigger change event to update UI
                    selectElement.trigger('change');
                    return;
                }
            }
            var url = '{{ url('multi-cleaner-time-slot') }}';
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
                        alert('This Cleaner is not available: ' + cleanerName);
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

        function add_amount_model(order_id) {
            $('#add_amount_model' + order_id).modal('show');
        }

        function assign_vendor(order_id) {
            var url = '{{ url('assign_vendor') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": order_id
                },
                success: function(msg) {
                    document.getElementById('dropdownreplace').innerHTML = msg;
                    $('#assign_vendor_model').modal('show');

                }
            });
        }

        function updateorder_booking_percentage(val, id) {
            $('#percentage').val(val);
            $('#order_id').val(id);
            $('#set_order_model').modal('show');
        }

        function updateorder() {
            var percentage = $('#percentage').val();
            var order_id = $('#order_id').val();
            $.ajax({
                type: "POST",
                url: "{{ url('set_booking_percentage') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": order_id,
                    "percentage": percentage
                },
                success: function(returnedData) {
                    // alert(returnedData);
                    if (returnedData == 1) {
                        //alert('yes');
                        $('#success_message').text("Booking Percentage Updated successfully");
                        //$('.success_show').show();
                        $('.success_show').show().delay(0).fadeIn('show');
                        $('.success_show').show().delay(5000).fadeOut('show');
                        $('#set_order_model').modal('hide');
                    }
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            // Check if the DataTable instance already exists
            if ($.fn.DataTable.isDataTable('#example')) {
                // Destroy the existing DataTable before reinitializing
                $('#example').DataTable().destroy();
            }
            // Initialize DataTable with the new options
            $('#example').dataTable({
                "searching": true
            });
        });

        function order_status_change(order_id, element) {
            var order_status_value = element.value;
            $.ajax({
                type: "POST",
                url: "{{ url('order-status-change') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_status_value": order_status_value,
                    "order_id": order_id
                },
                success: function(response) {
                    // alert(response);
                    if (response == 1) {
                        $('#success_message').text("Order Status Update Successfully");
                        $('.success_show').fadeIn().delay(1000).fadeOut();
                        // setTimeout(function() {location.reload();},1500);
                    }
                },
            });
        }

        function payment_status_change(order_id, element) {
            var payment_status_value = element.value;
            $.ajax({
                type: "POST",
                url: "{{ url('payment-status-change') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "payment_status_value": payment_status_value,
                    "order_id": order_id
                },
                success: function(response) {
                    // alert(response);
                    if (response == 1) {
                        $('#success_message').text("Payment Status Update Successfully");
                        $('.success_show').fadeIn().delay(1000).fadeOut();
                        // setTimeout(function() {location.reload();},1500);
                    }
                },
            });
        }

        function updatepopup(date, time, order_id) {
            //     alert(date);
            //    alert(time);
            //    alert(order_id);
            $('#update_inspection_date').val(date);
            $('#update_inspection_time').val(time);
            $('#car_inpsection_order').val(order_id);
            $('#update_popup_model').modal('show');

        }
    </script>
@stop
