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
                        @if (Route::currentRouteName() == 'cleaning_package_order')
                            Package Order - Cleaning
                        @elseif(Route::currentRouteName() == 'painting-service-order')
                            Package Order - Painting
                        @elseif(Route::currentRouteName() == 'handyman-service-order')
                            Package Order - HandyMan
                        @elseif(Route::currentRouteName() == 'salon-spa-order')
                            Package Order - Salon & Spa
                        @elseif(Route::currentRouteName() == 'pest-control-order')
                            Package Order - Pest Control
                        @elseif(Route::currentRouteName() == 'automobile-order')
                            Package Order - Automobile
                        @else
                            Package Order - Moving
                        @endif
                    </h3>
                    <ul class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Order List</li>
                    </ul>
                </div>

                @if (in_array('40', $edit_perm) ||
                        in_array('19', $edit_perm) ||
                        in_array('44', $edit_perm) ||
                        in_array('45', $edit_perm) ||
                        in_array('42', $edit_perm) ||
                        in_array('59', $edit_perm))
                    <div class="col-auto">
                        @php
                            $addRoutes = [
                                'cleaning_package_order' => ['route' => 'cleaning-admin-order', 'label' => 'Cleaning'],
                                'order.index' => ['route' => 'moving-admin-order', 'label' => 'Moving'],
                                'salon-spa-order' => ['route' => 'salon-spa-admin-order', 'label' => 'Salon & Spa'],
                                'pest-control-order' => [
                                    'route' => 'pest-control-admin-order',
                                    'label' => 'Pest Control',
                                ],
                                'handyman-service-order' => [
                                    'route' => 'handyman-service-admin-order',
                                    'label' => 'Handyman',
                                ],
                                'painting-service-order' => [
                                    'route' => 'painting-service-admin-order',
                                    'label' => 'Painting',
                                ],
                                'automobile-order' => ['route' => 'automobile-admin-order', 'label' => 'Automobile'],
                            ];
                            $curr = Route::currentRouteName();
                        @endphp

                        @if (isset($addRoutes[$curr]))
                            <a class="btn btn-primary" href="{{ route($addRoutes[$curr]['route']) }}">
                                <i class="fas fa-plus me-1"></i> Add {{ $addRoutes[$curr]['label'] }} Order
                            </a>
                        @endif

                        @if ($curr == 'cleaning_package_order')
                            <a class="btn btn-danger fw-bold ms-1" href="javascript:void('0');"
                                onclick="delete_cleaning_order();">
                                <i class="fas fa-trash me-1"></i> Delete
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="action-card">
            <div class="card-body p-4">
                <form id="form" action="{{ route('delete_order') }}">
                    @csrf
                    <table class="action-table" id="example">
                        <thead>
                            <tr>
                                @if (Route::currentRouteName() == 'cleaning_package_order')
                                    <th>Select</th>
                                @else
                                    <th class="d-none">Select</th>
                                @endif
                                <th>Order Detail</th>
                                <th>Customer & Service</th>
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
                                            @if (Route::currentRouteName() == 'cleaning_package_order')
                                                <td><input name="selected[]" value="{{ $orders->order_id }}" type="checkbox"
                                                        class="minimal-red" style="height: 18px; width: 18px;"></td>
                                            @else
                                                <td class="d-none"><input name="selected[]" value="{{ $orders->order_id }}"
                                                        type="checkbox" class="minimal-red"></td>
                                            @endif
                                            <td>
                                                <span class="stack-top text-primary">#{{ $orders->format_order_id }}</span>
                                                <span
                                                    class="stack-bottom">{{ date('d M, Y', strtotime($orders->created_at)) }}</span>
                                            </td>
                                            <td>
                                                <span class="stack-top">{{ $orders->user_name }}</span>
                                                <span class="stack-bottom">{!! isset($orders->items[0]) ? Helper::subservicename($orders->items[0]->subservice_id) : '-' !!}</span>
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm mb-1 fw-bold"
                                                    style="font-size: 12px;"
                                                    onchange="order_status_change({{ $orders->order_id }}, this)">
                                                    <option value="BK"
                                                        {{ $orders->order_status === 'BK' ? 'selected' : '' }}>Booking
                                                        Requested
                                                    </option>
                                                    <option value="P"
                                                        {{ $orders->order_status === 'P' ? 'selected' : '' }}>Booking
                                                        Confirmed
                                                    </option>
                                                    <option value="PA"
                                                        {{ $orders->order_status === 'PA' ? 'selected' : '' }}>Vendor
                                                        Assigned
                                                    </option>
                                                    <option value="CO"
                                                        {{ $orders->order_status === 'CO' ? 'selected' : '' }}>Booking
                                                        Completed
                                                    </option>
                                                    <option value="CL"
                                                        {{ $orders->order_status === 'CL' ? 'selected' : '' }}>
                                                        Booking Cancelled</option>
                                                </select>
                                                <div class="d-flex align-items-center">
                                                    <input type="text"
                                                        value="{{ $orders->items[0]->subservice_booking_percentage }}"
                                                        onchange="updateorder_booking_percentage(this.value, '{{ $orders->items[0]->id }}');"
                                                        class="form-control form-control-sm text-center"
                                                        style="width: 45px; height: 22px; font-size: 11px;">
                                                    <span class="ms-1 small text-muted">Comm %</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    @if (isset($orders->items[0]))
                                                        @if ($orders->items[0]->salesperson_id != '' && $orders->items[0]->salesperson_id != null)
                                                            {{-- {!! Helper::salesperson($orders->items[0]->salesperson_id) !!} --}}
                                                        @else
                                                            <button type="button" class="btn-utility"
                                                                onclick="assign_salesperson('{{ $orders->order_id }}')"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Assign Salesperson">

                                                                <i class="fas fa-user-tie"></i>
                                                            </button>
                                                        @endif
                                                    @endif


                                                    @if (Route::currentRouteName() == 'cleaning_package_order' ||
                                                            Route::currentRouteName() == 'handyman-service-order' ||
                                                            Route::currentRouteName() == 'salon-spa-order' ||
                                                            Route::currentRouteName() == 'pest-control-order')
                                                        {{-- ================= SALES PERSON ================= --}}



                                                        {{-- ================= CLEANER / CREW ================= --}}
                                                        @if (isset($orders->items[0]))
                                                            {{-- If Cleaner ID = 2 → Assign Single Crew --}}
                                                            @if ($orders->items[0]->cleaner_id == 2)
                                                                <button type="button" class="btn-utility"
                                                                    onclick="assign_cleaner('{{ $orders->order_id }}', '{{ $orders->items[0]->service_id }}', '{{ $orders->items[0]->subservice_id }}')">
                                                                    <i class="fas fa-user"></i>
                                                                </button>

                                                                {{-- If Cleaner Already Assigned --}}
                                                            @elseif($orders->items[0]->cleaner_id)
                                                                @php
                                                                    $cleaner_Id = explode(
                                                                        ',',
                                                                        $orders->items[0]->cleaner_id,
                                                                    );
                                                                @endphp

                                                                {{-- {!! Helper::cleanername_new($cleaner_Id) !!} --}}

                                                                {{-- If No Cleaner Assigned → Assign Multiple --}}
                                                            @else
                                                                <button type="button" class="btn-utility"
                                                                    onclick="assign_multi_cleaner(
        '{{ $orders->order_id }}',
        '{{ $orders->items[0]->service_id }}',
        '{{ $orders->items[0]->subservice_id }}',
        '{{ $orders->items[0]->how_many_cleaners_do_you_need }}'
    )"
                                                                    title="Assign Multiple Crew">

                                                                    <i class="fas fa-users"></i>
                                                                </button>
                                                            @endif
                                                        @else
                                                            {{ '-' }}
                                                        @endif

                                                        {{-- @if (isset($orders->items[0]))
                                                            @if (!empty($orders->items[0]->cleaner_id))
                                                                <a href="{{ url('mark-attendance/' . $orders->order_id) }}"
                                                                    class="btn-utility" data-bs-toggle="tooltip"
                                                                    title="Attendance">

                                                                    <i class="fas fa-calendar-check"></i>
                                                                </a>
                                                            @endif
                                                        @endif --}}

                                                        {{-- ================= ADD PER CREW PRICE ================= --}}
                                                        {{-- @if ($orders->items[0]->subservice_id != 28) --}}
                                                        {{-- @if (!empty($orders->items[0]->cleaner_id))
                                                            @if (empty($orders->items[0]->cleaner_price) && $orders->items[0]->cleaner_price == null)
                                                                <button type="button" class="btn-utility"
                                                                    onclick="add_cleaner_price('{{ $orders->order_id }}');"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Add Per Crew Price">

                                                                    <i class="fas fa-dollar-sign"></i>
                                                                </button>
                                                            @endif
                                                        @endif --}}
                                                        {{-- @endif --}}
                                                    @endif

                                                    @if ($orders->payment_status == 'Success')
                                                        @if ($orders->items[0]->service_id == 50)
                                                            <button type="button" class="btn-utility"
                                                                onclick="assign_vendor_car('{{ $orders->order_id }}');"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Assign Vendor car">

                                                                <i class="fas fa-user"></i>
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn-utility"
                                                                onclick="assign_vendor('{{ $orders->order_id }}');"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Assign Vendor">

                                                                <i class="fas fa-user"></i>
                                                            </button>
                                                        @endif
                                                    @endif

                                                    @if (empty($orders->items[0]->location_link))
                                                        <button class="btn-utility"
                                                            onclick="openLocationLink('{{ $orders->order_id }}')"
                                                            title="Location Link">

                                                            <i class="fas fa-map-marker-alt"></i>
                                                        </button>
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
                                                        @php
                                                            $routeMap = [
                                                                'order.index' => [
                                                                    'route' => 'moving_package_order_edit',
                                                                    'param' => 'id',
                                                                ],
                                                                'handyman-service-order' => [
                                                                    'route' => 'handyman_order_edit',
                                                                    'param' => 'ci_order',
                                                                ],
                                                                'painting-service-order' => [
                                                                    'route' => 'painting_order_edit',
                                                                    'param' => 'ci_order',
                                                                ],
                                                                'salon-spa-order' => [
                                                                    'route' => 'salon_spa_order_edit',
                                                                    'param' => 'ci_order',
                                                                ],
                                                                'pest-control-order' => [
                                                                    'route' => 'pest_control_order_edit',
                                                                    'param' => 'ci_order',
                                                                ],
                                                                'automobile-order' => [
                                                                    'route' => 'automobile_order_edit',
                                                                    'param' => 'ci_order',
                                                                ],
                                                                'cleaning_package_order' => [
                                                                    'route' => 'cleaning_package_order_edit',
                                                                    'param' => 'id',
                                                                ],
                                                            ];
                                                            $currentRoute = Route::currentRouteName();
                                                        @endphp

                                                        @if (isset($routeMap[$currentRoute]))
                                                            <a class="dropdown-item"
                                                                href="{{ route($routeMap[$currentRoute]['route'], [$routeMap[$currentRoute]['param'] => $orders->order_id]) }}"><i
                                                                    class="far fa-edit me-2"></i>Edit Order</a>
                                                        @endif

                                                        @if ($orders->items[0]->service_id == 34)
                                                            <a class="dropdown-item"
                                                                href="{{ route('painting-detail', [$orders->order_id]) }}">
                                                            @elseif($orders->items[0]->service_id == 45)
                                                                <a class="dropdown-item"
                                                                    href="{{ route('cleaning-detail', [$orders->order_id]) }}">
                                                                @elseif($orders->items[0]->service_id == 71)
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('handyman-detail', [$orders->order_id]) }}">
                                                                    @else
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('moving-detail', [$orders->order_id]) }}">
                                                        @endif
                                                        <i class="far fa-eye me-2"></i>Details
                                                        </a>

                                                        @if ($orders->vendor_id != 0 && $orders->vendor_id != '')
                                                            <button type="button" class="dropdown-item"
                                                                onclick="add_amount_model(
        '{{ $orders->order_id }}',
        '{{ $orders->order_total }}'
    )">
                                                                <i class="fas fa-money-bill-wave me-2"></i>Add Amount
                                                            </button>
                                                        @endif
                                                        @if (Route::currentRouteName() == 'cleaning_package_order')
                                                            @if (
                                                                $orders->items[0]->how_often_do_you_need_cleaning == 'Weekly' ||
                                                                    $orders->items[0]->how_often_do_you_need_cleaning == 'Multiple times a week')
                                                                <a class="dropdown-item" href="javascript:void(0)"
                                                                    onclick="set_end_date({{ $orders->order_id }})">
                                                                    <i class="far fa-calendar me-2"></i>End Date
                                                                </a>
                                                            @endif
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
    {{-- Rest of JS/Modals remain unchanged --}}
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
    <div class="modal custom-modal fade" id="assign_salesperson_modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">

                    <input type="hidden" id="modal_order_id">

                    <select id="salesperson_select" class="form-control">
                        <option value="">Select Salesperson</option>

                        @php
                            $salesperson_data = DB::table('users')
                                ->whereIn('role_id', [11, 12])
                                ->where('is_active', '0')
                                ->get();
                        @endphp

                        @foreach ($salesperson_data as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                        @endforeach

                    </select>

                    <p id="salesperson_error" style="color:red;margin-top:10px;"></p>

                </div>

                <div class="modal-footer text-center">

                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    <button class="btn btn-primary mb-1" type="button" disabled id="salesperson_spinner_button"
                        style="display:none;">
                        <span class="spinner-border spinner-border-sm"></span>
                        Loading...
                    </button>

                    <button type="button" class="btn btn-primary" onclick="salesperson_assign()"
                        id="salesperson_button">
                        Submit
                    </button>

                </div>

            </div>
        </div>
    </div>
    <!--- Salesperson Modal Close --->
    <!--- Location Link Modal Start-->
    <div class="modal fade" id="locationModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">

                    <input type="hidden" id="location_order_id">

                    <input type="text" id="location_link_input" class="form-control"
                        placeholder="Enter Location Link">

                    <p id="location_error" style="color:red"></p>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button class="btn btn-primary" onclick="submitLocation()">
                        Submit
                    </button>

                </div>

            </div>
        </div>
    </div>
    <!--- Location Link Modal End-->
    <!--- cleaner Modal Start-->
    <div class="modal fade" id="cleaner_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form id="cleaner_assign_form">
                    @csrf

                    <input type="hidden" id="modal_order_id">

                    <div class="modal-body">

                        <select id="cleaner_dropdown" class="form-control">
                            <option value="">Select Cleaner</option>
                        </select>

                        <p class="form-error-text" id="cleaner_error" style="color:red; margin-top:10px;"></p>

                    </div>

                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                        <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                            style="display:none;">
                            <span class="spinner-border spinner-border-sm"></span>
                            Loading...
                        </button>

                        <button type="button" class="btn btn-primary" onclick="cleaner_assign()">Submit</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <!--- Cleaner Modal Close --->
    <!--- Multi cleaner Modal Start -->
    <div class="modal fade" id="multi_cleaner_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form id="multi_cleaner_assign_form">
                    @csrf

                    <input type="hidden" id="multi_order_id">
                    <input type="hidden" id="required_cleaner_count">

                    <div class="modal-body">

                        <select id="multi_cleaner_dropdown" class="form-control" multiple="multiple"></select>

                        <p id="multi_cleaner_error" style="color:red;margin-top:10px;"></p>

                    </div>

                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                        <button class="btn btn-primary mb-1" type="button" disabled id="multi_spinner_button"
                            style="display:none;">
                            <span class="spinner-border spinner-border-sm"></span>
                            Loading...
                        </button>

                        <button type="button" class="btn btn-primary" onclick="multi_cleaner_assign()">Submit</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <!--- Multi Cleaner Modal Close --->
    <!--- Per Cleaner Price Modal Start--->
    {{-- @foreach ($orders_list as $key => $orders)
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
    @endforeach --}}
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
                        <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button_vendor"
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
    <!-- Assign Vendor  Modal -->
    <div class="modal custom-modal fade" id="assign_vendor_model_car" role="dialog">
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
                        <div class="modal-text text-center" id="dropdownreplace_car">
                        </div>
                        <div id="vendor_message" style="margin-top:10px; font-weight: 600; display:none;"></div>
                        <p class="form-error-text" id="vendor_id_error" style="color: red; margin-top: 10px;"></p>
                    </div>
                    {{-- <div class="modal-footer text-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                    style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                    </button>
                <button type="button" class="btn btn-primary" onclick="form_sub_vendor();" id="vedor_submit">Submit</button>
            </div> --}}
                </form>
            </div>
        </div>
    </div>
    <div class="modal custom-modal fade" id="set_order_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <h3>Are you sure you want to Change Percentage</h3>
                        <input type="hidden" name="percentage" id="percentage" value="">
                        <input type="hidden" name="order_id" id="order_id" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary" onclick="updateorder();">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Assign Vendor Modal -->
    <!--Add Amount Modal -->
    <div class="modal fade" id="add_amount_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form id="add_amount_form">
                    @csrf

                    <input type="hidden" id="amount_order_id">
                    <input type="hidden" id="amount_order_total">

                    <div class="modal-body">

                        <div class="form-group text-center">
                            <label id="total_amount_label"></label>
                        </div>

                        <div class="form-group">
                            <label>Add Amount</label>
                            <input type="number" id="add_amount" class="form-control">
                            <p id="add_amount_error" style="color:red;"></p>
                        </div>

                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" id="date" class="form-control">
                            <p id="date_error" style="color:red;"></p>
                        </div>

                        <div class="form-group">
                            <label>Collect By</label>
                            <select id="collect_by" class="form-control">
                                <option value="">Select</option>
                                <option value="Vendorscity">Vendorscity</option>
                                <option value="Vendor">Vendor</option>
                            </select>
                            <p id="collect_by_error" style="color:red;"></p>
                        </div>

                        <div class="form-group">
                            <label>Payment Type</label>
                            <select id="payment_type" class="form-control">
                                <option value="">Select</option>
                                <option value="Online">Online</option>
                                <option value="Cash">Cash</option>
                            </select>
                            <p id="payment_type_error" style="color:red;"></p>
                        </div>

                        <div id="amount_history"></div>

                    </div>

                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                        <button class="btn btn-primary mb-1" type="button" disabled id="amount_spinner"
                            style="display:none;">
                            <span class="spinner-border spinner-border-sm"></span>
                            Loading...
                        </button>

                        <button type="button" class="btn btn-primary" id="amount_button"
                            onclick="add_amount_popup()">Submit</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <!--Add Amount Modal -->

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "searching": true,
                "paging": true,
                "pageLength": 10,
                "info": false,
                "language": {
                    "search": "",
                    "searchPlaceholder": "Quick Search...",
                    "paginate": {
                        "next": '<i class="fas fa-chevron-right"></i>',
                        "previous": '<i class="fas fa-chevron-left"></i>'
                    }
                },
                "dom": '<"top"f>rt<"bottom"p><"clear">'
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Check for Error Message
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Try Again'
                });
            @endif
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
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
            var vendor_id = jQuery("#vendor_id").val();
            if (vendor_id == '') {
                jQuery('#vendor_id_error').html("Please Select Vendor");
                jQuery('#vendor_id_error').show().delay(0).fadeIn('show');
                jQuery('#vendor_id_error').show().delay(2000).fadeOut('show');

                return false;
            }
            $('#vedor_submit').hide();
            $('#spinner_button_vendor').show();
            $('#order_vendor_form').submit();
        }

        // function add_amount_popup() {

        //     var order_id = $('#amount_order_id').val();
        //     var add_amount = $('#add_amount').val();
        //     var date = $('#date').val();
        //     var collect_by = $('#collect_by').val();
        //     var payment_type = $('#payment_type').val();

        //     if (!add_amount) {
        //         $('#add_amount_error').text("Please Add Amount");
        //         return false;
        //     }

        //     if (!date) {
        //         $('#date_error').text("Please Select Date");
        //         return false;
        //     }

        //     if (!collect_by) {
        //         $('#collect_by_error').text("Please Select Collect By");
        //         return false;
        //     }

        //     if (!payment_type) {
        //         $('#payment_type_error').text("Please Select Payment Type");
        //         return false;
        //     }

        //     $.ajax({
        //         url: "{{ url('checkAmountorder') }}",
        //         type: "POST",
        //         data: {
        //             _token: "{{ csrf_token() }}",
        //             order_id: order_id,
        //             add_amount: add_amount
        //         },
        //         success: function(res) {

        //             if (res == 0) {
        //                 $('#payment_type_error').text("Amount exceeds balance");
        //             } else {

        //                 $('#amount_spinner').show();
        //                 $('#amount_button').hide();

        //                 $.ajax({
        //                     url: "{{ url('add_amount_form') }}",
        //                     type: "POST",
        //                     data: {
        //                         _token: "{{ csrf_token() }}",
        //                         order_id: order_id,
        //                         add_amount: add_amount,
        //                         date: date,
        //                         collect_by: collect_by,
        //                         payment_type: payment_type
        //                     },
        //                     success: function(response) {

        //                         $('#add_amount_model').modal('hide');

        //                         $('#success_message').text("Amount Added Successfully");
        //                         $('.success_show').fadeIn().delay(1000).fadeOut();

        //                         setTimeout(() => location.reload(), 1500);
        //                     }
        //                 });
        //             }
        //         }
        //     });
        // }

        function add_amount_popup() {

            var order_id = $('#amount_order_id').val();
            var add_amount = parseFloat($('#add_amount').val());
            var date = $('#date').val();
            var collect_by = $('#collect_by').val();
            var payment_type = $('#payment_type').val();

            // ✅ Validation
            if (!add_amount || add_amount <= 0) {
                Swal.fire('Error', 'Please enter valid amount', 'error');
                return;
            }

            if (!date) {
                Swal.fire('Error', 'Please Select Date', 'error');
                return;
            }

            if (!collect_by) {
                Swal.fire('Error', 'Please Select Collect By', 'error');
                return;
            }

            if (!payment_type) {
                Swal.fire('Error', 'Please Select Payment Type', 'error');
                return;
            }

            // ✅ First Check
            $.ajax({
                url: "{{ url('checkAmountorder') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order_id: order_id,
                    add_amount: add_amount
                },
                success: function(res) {

                    if (res.status === 'paid') {
                        Swal.fire('Warning', 'Payment already completed', 'warning');
                        return;
                    }

                    if (res.status === 'exceed') {
                        Swal.fire('Error', 'Remaining: AED ' + res.balance, 'error');
                        return;
                    }

                    // ✅ Confirm
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Add this amount?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes'
                    }).then((result) => {

                        if (result.isConfirmed) {

                            $('#amount_spinner').show();
                            $('#amount_button').hide();

                            $.ajax({
                                url: "{{ url('add_amount_form') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    order_id: order_id,
                                    add_amount: add_amount,
                                    date: date,
                                    collect_by: collect_by,
                                    payment_type: payment_type
                                },
                                success: function(response) {

                                    $('#amount_spinner').hide();
                                    $('#amount_button').show();

                                    if (response.status === 'paid') {
                                        Swal.fire('Warning', 'Payment already completed',
                                            'warning');
                                        return;
                                    }

                                    if (response.status === 'exceed') {
                                        Swal.fire('Error', 'Remaining: AED ' + response
                                            .balance, 'error');
                                        return;
                                    }

                                    if (response.status === 'success') {

                                        $('#add_amount_model').modal('hide');

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: 'Amount Added Successfully',
                                            timer: 1500,
                                            showConfirmButton: false
                                        });

                                        setTimeout(() => location.reload(), 1500);
                                    }
                                }
                            });
                        }
                    });
                }
            });
        }

        function assign_cleaner(order_id, service_id, subservice_id) {

            $('#modal_order_id').val(order_id);
            $('#cleaner_dropdown').html('<option>Loading...</option>');

            $('#cleaner_model').modal('show');

            $.ajax({
                url: "{{ url('get-cleaners') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    service_id: service_id,
                    subservice_id: subservice_id
                },
                success: function(res) {

                    let options = '<option value="">Select Cleaner</option>';

                    res.data.forEach(function(item) {
                        if (item.id != 2) {
                            options += `<option value="${item.id}">${item.name}</option>`;
                        }
                    });

                    $('#cleaner_dropdown').html(options);
                }
            });
        }

        function assign_salesperson(order_id) {
            $('#modal_order_id').val(order_id);

            $('#assign_salesperson_modal').modal('show');
        }

        function openLocationLink(order_id) {
            // $('#location_link_model_' + order_id).modal('show');
            $('#location_order_id').val(order_id);
            $('#location_link_input').val('');
            $('#locationModal').modal('show');
        }

        function submitLocation() {

            var order_id = $('#location_order_id').val();
            var location_link = $('#location_link_input').val();

            if (location_link == '') {
                $('#location_error').html("Please Enter Location Link");
                return false;
            }

            $.ajax({

                url: "{{ url('location-link-form') }}",
                type: "POST",

                data: {
                    _token: "{{ csrf_token() }}",
                    order_id: order_id,
                    location_link: location_link
                },

                success: function(res) {

                    if (res.status == 1) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Location Link Added Successfully'
                        });

                        $('#locationModal').modal('hide');

                    }

                }

            });

        }
        //Auto assign Cleaner Popoup Submit
        function cleaner_assign() {

            var order_id = $('#modal_order_id').val();
            var cleaner = $('#cleaner_dropdown').val();

            if (cleaner == '') {
                $('#cleaner_error').html("Please Select Cleaner").show().delay(2000).fadeOut();
                return false;
            }

            $('#spinner_button').show();

            $.ajax({
                url: "{{ url('cleaner-assign-form') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order_id: order_id,
                    cleaner: cleaner
                },
                success: function(response) {

                    $('#spinner_button').hide();

                    if (response.status == 1) {
                        $('#success_message').text("Crew Assigned Successfully");
                        $('.success_show').fadeIn().delay(1000).fadeOut();

                        $('#cleaner_model').modal('hide');

                        setTimeout(function() {
                            location.reload();
                        }, 1500);

                    } else {
                        $('#error_message').text(response.message);
                        $('.error_show').fadeIn().delay(1000).fadeOut();
                    }
                }
            });
        }

        $(document).ready(function() {
            $('#multi_cleaner_dropdown').select2({
                placeholder: "Select Multiple Cleaners",
                dropdownParent: $('#multi_cleaner_model')
            });
        });

        function assign_multi_cleaner(order_id, service_id, subservice_id, cleaner_count) {

            $('#multi_order_id').val(order_id);
            $('#required_cleaner_count').val(cleaner_count);

            $('#multi_cleaner_dropdown').html('<option>Loading...</option>').trigger('change');

            $('#multi_cleaner_model').modal('show');

            $.ajax({
                url: "{{ url('get-cleaners') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    service_id: service_id,
                    subservice_id: subservice_id
                },
                success: function(res) {

                    let options = '';

                    res.data.forEach(function(item) {
                        if (item.id != 2) {
                            options += `<option value="${item.id}">${item.name}</option>`;
                        }
                    });

                    $('#multi_cleaner_dropdown').html(options).trigger('change');
                }
            });
        }

        // function add_cleaner_price(order_id) {
        //     $('#add_cleaner_price_model_' + order_id).modal('show');
        // }
        // // Add Cleaner Price Popup submit

        // function add_cleaner_price_popup(order_id) {
        //     var cleaner_price = jQuery("#cleaner_price_" + order_id).val();
        //     if (cleaner_price == '' || cleaner_price == null) {
        //         jQuery('#cleaner_price_error_' + order_id).html("Please Enter Cleaner Price");
        //         jQuery('#cleaner_price_error_' + order_id).show().delay(2000).fadeOut('show');
        //         return false;
        //     }
        //     $('#add_cleaner_price_' + order_id).hide();
        //     $('#add_spinner_button_' + order_id).show();
        //     var url = '{{ url('add-cleaner-price-form') }}';
        //     $.ajax({
        //         url: url,
        //         type: 'post',
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //             "order_id": order_id,
        //             "cleaner_price": cleaner_price,
        //         },
        //         success: function(response) {
        //             if (response.status == 1) {
        //                 $('#success_message').text("Crew Price added Successfully");
        //                 $('.success_show').fadeIn().delay(1000).fadeOut();
        //                 $('#add_cleaner_price_model_' + response.order_id).modal('hide');
        //                 setTimeout(function() {
        //                     location.reload();
        //                 }, 1500);
        //             }
        //         }
        //     });
        //     // alert(order_id);
        // }
        //Multiple Cleaner Assign Popup Submit

        function multi_cleaner_assign() {

            var order_id = $('#multi_order_id').val();
            var cleaner = $('#multi_cleaner_dropdown').val();
            var cleaner_count = $('#required_cleaner_count').val();

            if (!cleaner || cleaner.length == 0) {
                $('#multi_cleaner_error').html("Please Select Crew").show().delay(2000).fadeOut();
                return false;
            }

            if (cleaner.length < cleaner_count) {
                $('#multi_cleaner_error').html('Please select ' + cleaner_count + ' cleaners')
                    .show().delay(2000).fadeOut();
                return false;
            }

            $('#multi_spinner_button').show();

            $.ajax({
                url: "{{ url('multi-cleaner-assign-form') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order_id: order_id,
                    cleaner: cleaner
                },
                success: function(response) {

                    $('#multi_spinner_button').hide();

                    if (response.status == 1) {
                        $('#success_message').text("Multiple Crew Assigned Successfully");
                        $('.success_show').fadeIn().delay(1000).fadeOut();

                        $('#multi_cleaner_model').modal('hide');

                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                }
            });
        }

        function salesperson_assign() {

            var order_id = $('#modal_order_id').val();
            var salesperson = $('#salesperson_select').val();

            if (salesperson == '' || salesperson == null) {
                $('#salesperson_error').html("Please Select SalesPerson");
                return false;
            }

            $('#salesperson_button').hide();
            $('#salesperson_spinner_button').show();

            $.ajax({
                url: "{{ url('salesperson-assign-form') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    order_id: order_id,
                    salesperson_id: salesperson
                },

                success: function(response) {

                    if (response.status == 1) {

                        $('#assign_salesperson_modal').modal('hide');

                        $('#success_message').text("SalesPerson Assigned Successfully");
                        $('.success_show').fadeIn().delay(1000).fadeOut();

                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }

                }

            });

        }

        // function salesperson_assign(order_id) {
        //     var salesperson = jQuery("#salesperson_" + order_id).val();
        //     if (salesperson == '' || salesperson == null) {
        //         jQuery('#salesperson_error_' + order_id).html("Please Select SalesPerson");
        //         jQuery('#salesperson_error_' + order_id).show().delay(2000).fadeOut('show');
        //         return false;
        //     }
        //     $('#salesperson_button_' + order_id).hide();
        //     $('#salesperson_spinner_button_' + order_id).show();
        //     var url = '{{ url('salesperson-assign-form') }}';
        //     $.ajax({
        //         url: url,
        //         type: 'post',
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //             "order_id": order_id,
        //             "salesperson_id": salesperson,
        //         },
        //         success: function(response) {
        //             if (response.status == 1) {
        //                 $('#success_message').text("SalesPerson Assigned Successfully");
        //                 $('.success_show').fadeIn().delay(1000).fadeOut();
        //                 $('#assign_salesperson_model_' + response.order_id).modal('hide');
        //                 setTimeout(function() {
        //                     location.reload();
        //                 }, 1500);

        //             }
        //         }
        //     });
        // }

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

        function add_amount_model(order_id, order_total) {

            $('#amount_order_id').val(order_id);
            $('#amount_order_total').val(order_total);

            $('#total_amount_label').text("Total Amount: AED " + order_total);

            $('#add_amount_model').modal('show');

            // Load history
            $.ajax({
                url: "{{ url('get-order-amount-history') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order_id: order_id
                },
                success: function(res) {

                    let html = '';

                    html += `<div><b>Balance Amount: AED ${res.balance}</b></div>`;

                    res.data.forEach(function(item) {
                        html += `
                    <div style="margin-top:10px;">
                        <label>${item.date} : AED ${item.add_amount}</label><br>
                        <label>Collect By : ${item.collect_by}</label><br>
                        <label>Payment : ${item.payment_type}</label>
                    </div>
                `;
                    });

                    $('#amount_history').html(html);
                }
            });
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

        function assign_vendor_car(order_id) {
            var url = '{{ route('admin.assign_vendor_car') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": order_id
                },
                success: function(msg) {
                    document.getElementById('dropdownreplace_car').innerHTML = msg;
                    $('#assign_vendor_model_car').modal('show');

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

                    if (response == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Order Status Updated Successfully',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                        // $('#success_message').text("Order Status Update Successfully");
                        // $('.success_show').fadeIn().delay(1000).fadeOut();
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

        function checkcar_vendor_available(order_id) {
            var vendor_id_car = $('#vendor_id_car').val();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.checkcar_vendor_available') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "vendor_id_car": vendor_id_car,
                    "order_id": order_id
                },
                success: function(response) {
                    if (response.status === true) {
                        // Success message
                        $('#vendor_message')
                            .removeClass('text-danger')
                            .addClass('text-success')
                            .text(response.message)
                            .fadeIn().delay(2000).fadeOut();
                        //$('#assign_vendor_model_car').modal('hide');
                        location.reload();
                    } else {
                        // Error message
                        $('#vendor_message')
                            .removeClass('text-success')
                            .addClass('text-danger')
                            .text(response.message)
                            .fadeIn().delay(3000).fadeOut();

                    }
                },
                error: function() {
                    $('#vendor_message')
                        .removeClass('text-success')
                        .addClass('text-danger')
                        .text("Something went wrong! Please try again.")
                        .fadeIn().delay(3000).fadeOut();
                }
            });
        }
    </script>

    <script>
        // Tooltip Initialization Helper
        function initTooltips() {
            // Remove existing tooltips to prevent ghosting
            $('.tooltip').remove();
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        }

        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#example')) {
                $('#example').DataTable().destroy();
            }

            var table = $('#example').DataTable({
                "searching": true
            });

            // Initialize tooltips on first load
            initTooltips();

            // Re-initialize tooltips whenever the table is redrawn (pagination, sorting, etc.)
            table.on('draw', function() {
                initTooltips();
            });
        });

        function copyToClipboard(text, element) {
            var tempInput = document.createElement("input");
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);

            var icon = element.querySelector('i');
            icon.classList.remove('far', 'fa-copy');
            icon.classList.add('fas', 'fa-check', 'text-success');

            setTimeout(function() {
                icon.classList.remove('fas', 'fa-check', 'text-success');
                icon.classList.add('far', 'fa-copy', 'text-muted');
            }, 2000);
        }
    </script>


@stop
