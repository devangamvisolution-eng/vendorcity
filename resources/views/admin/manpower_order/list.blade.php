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
        transition: all 0.2s;
    }

    .btn-utility:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: var(--action-blue);
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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
                <h3 class="page-title">Package Order - Manpower Order</h3>
                <ul class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Order List</li>
                </ul>
            </div>
            @if(in_array('81', $edit_perm))
            <div class="col-auto">
                <a class="btn btn-primary" href="{{ route('manpower-orders.create') }}">
                    <i class="fas fa-plus me-1"></i> Add Manpower Order
                </a>
            </div>
            @endif
        </div>
    </div>


    <div class="action-card">
        <div class="card-body p-4">
            <table class="action-table" id="example">
                <thead>
                    <tr>
                        <th>Order Detail</th>
                        <th>Customer & Service</th>
                        <th>Status</th>
                        <th class="text-center">Assign</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($orders_list) && count($orders_list) > 0)
                        @foreach($orders_list as $order)
                            @php
                                $item = $order->items->first();
                            @endphp
                            <tr>
                                <td>
                                    <span class="stack-top text-primary">#{{ $order->format_order_id }}</span>
                                    <span class="stack-bottom">{{ date('d M, Y', strtotime($order->created_at)) }}</span>
                                </td>
                                <td>
                                    <span class="stack-top">{{ $order->user_name }}</span>
                                    <span class="stack-bottom">
                                        @if($item)
                                            {{ \App\Helpers\Helper::servicename($item->service_id) }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <select class="form-select form-select-sm mb-1 fw-bold" style="font-size: 12px;"
                                        onchange="order_status_change({{ $order->order_id }}, this)">
                                        <option value="BK" {{ $order->order_status === 'BK' ? 'selected' : '' }}>Booking Requested
                                        </option>
                                        <option value="P" {{ $order->order_status === 'P' ? 'selected' : '' }}>Booking Confirmed
                                        </option>
                                        <option value="PA" {{ $order->order_status === 'PA' ? 'selected' : '' }}>Vendor Assigned
                                        </option>
                                        <option value="CO" {{ $order->order_status === 'CO' ? 'selected' : '' }}>Booking Completed
                                        </option>
                                        <option value="CL" {{ $order->order_status === 'CL' ? 'selected' : '' }}>Booking Cancelled
                                        </option>
                                    </select>
                                    <div class="d-flex align-items-center">
                                        <input type="text" value="{{ $item->subservice_booking_percentage ?? 0 }}"
                                            onchange="updateorder_booking_percentage(this.value, '{{ $item->id ?? 0 }}');"
                                            class="form-control form-control-sm text-center"
                                            style="width: 45px; height: 22px; font-size: 11px;">
                                        <span class="ms-1 small text-muted">Comm %</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn-utility"
                                            onclick="assign_salesperson('{{ $order->order_id }}', '{{ $item->salesperson_id ?? '' }}'); event.preventDefault();"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Assign Salesperson">
                                            <i
                                                class="fas fa-user-tie {{ !empty($item->salesperson_id) ? 'text-success' : '' }}"></i>
                                        </button>
                                        <button type="button" class="btn-utility"
                                            onclick="assign_vendor('{{ $order->order_id }}', '{{ $order->vendor_id ?? '' }}'); event.preventDefault();"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Assign Vendor">
                                            <i class="fas fa-user {{ !empty($order->vendor_id) ? 'text-success' : '' }}"></i>
                                        </button>
                                        <button type="button" class="btn-utility"
                                            onclick="openLocationLink('{{ $order->order_id }}', '{{ $item->location_link ?? '' }}'); event.preventDefault();"
                                            title="Location Link">
                                            <i
                                                class="fas fa-map-marker-alt {{ !empty($item->location_link) ? 'text-success' : '' }}"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle fw-bold" type="button"
                                            data-bs-toggle="dropdown">
                                            Manage
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end shadow border-0">
                                            @if(in_array('81', $edit_perm))
                                            <a class="dropdown-item py-2"
                                                href="{{ route('manpower-orders.edit', $order->order_id) }}">
                                                <i class="fas fa-edit text-muted me-2"></i> Edit Order
                                            </a>
                                            @endif
                                            <a class="dropdown-item py-2"
                                                href="{{ route('manpower-order-detail', $order->order_id) }}">
                                                <i class="fas fa-eye text-muted me-2"></i> Details
                                            </a>

                                            @if(in_array('81', $edit_perm))
                                            <button type="button" class="dropdown-item py-2"
                                                onclick="add_comm_model('{{ $order->order_id }}', '{{ $order->order_total }}', '{{ $order->sub_total }}', '{{ $item->subservice_booking_percentage ?? 0 }}', '{{ $item->subservice_booking_amount ?? 0 }}')">
                                                <i class="fas fa-coins text-muted me-2"></i>Add Commission
                                            </button>

                                            @if ($order->vendor_id != 0 && $order->vendor_id != '')
                                                <button type="button" class="dropdown-item py-2"
                                                    onclick="add_amount_model('{{ $order->order_id }}', '{{ $order->order_total }}')">
                                                    <i class="fas fa-money-bill-wave text-muted me-2"></i>Add Amount
                                                </button>
                                            @endif
                                            @endif

                                            <button type="button" class="dropdown-item py-2"
                                                onclick="handlecalanderAction('{{ $order->order_id }}', '{{ ($order->is_calendar_event_create ?? 0) == 1 ? 'update' : 'create' }}')">
                                                <i class="far fa-calendar-alt text-muted me-2"></i>
                                                {{ ($order->is_calendar_event_create ?? 0) == 1 ? 'Update Calendar' : 'Add to Calendar' }}
                                            </button>

                                            @if(in_array('81', $edit_perm))
                                            <div class="dropdown-divider"></div>
                                            <form id="delete-form-{{ $order->order_id }}"
                                                action="{{ route('manpower-orders.destroy', $order->order_id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item py-2 text-danger"
                                                    onclick="confirmDelete('{{ $order->order_id }}')">
                                                    <i class="fas fa-trash text-danger me-2"></i> Delete Order
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">No Manpower Orders found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Salesperson Modal -->
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary mb-1" type="button" disabled id="salesperson_spinner_button"
                    style="display:none;">
                    <span class="spinner-border spinner-border-sm"></span> Loading...
                </button>
                <button type="button" class="btn btn-primary" onclick="salesperson_assign()"
                    id="salesperson_button">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Vendor Modal -->
<div class="modal custom-modal fade" id="assign_vendor_model" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="order_vendor_form" action="{{ url('order_vendor_form') }}" method="POST">
                @csrf
                <input type="hidden" name="painting_order" value="{{ Route::currentRouteName() }}">
                <div class="modal-body">
                    <input type="hidden" id="modal_order_id">
                    <div id="dropdownreplace">
                        <!-- Populated via AJAX -->
                    </div>
                    <p class="form-error-text" id="vendor_id_error" style="color: red; margin-top: 10px;"></p>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="form_sub_vendor();"
                        id="vendor_button">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Commission Modal -->
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
                    <button class="btn btn-primary mb-1" type="button" disabled id="amount_spinner" style="display:none;">
                        <span class="spinner-border spinner-border-sm"></span> Loading...
                    </button>
                    <button type="button" class="btn btn-primary" id="amount_button" onclick="add_amount_popup()">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Add Amount Modal -->

<div class="modal fade" id="add_comm_model" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="comm_order_id">
                <input type="hidden" id="comm_order_total">
                <input type="hidden" id="comm_sub_total">

                <label id="total_comm_label" class="fw-bold text-primary mb-3" style="font-size: 16px;"></label>

                <div class="form-group mb-3">
                    <label>Commission Percentage (%)</label>
                    <input type="text" id="add_percentage" class="form-control" placeholder="Enter Percentage">
                    <span id="add_percentage_error" class="text-danger small"></span>
                </div>

                <div class="form-group mb-3">
                    <label>Commission Amount (AED)</label>
                    <input type="text" id="add_percentage_amount" class="form-control" placeholder="Enter Amount">
                    <span id="add_percentage_amount_error" class="text-danger small"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="comm_button" onclick="add_comm_popup()">Save
                    Commission</button>
                <button class="btn btn-primary mb-1" type="button" disabled id="comm_spinner" style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
            </div>
        </div>
    </div>
</div>

@stop
@section('footer_js')
<script>
    function order_status_change(order_id, element) {
        var order_status = element.value;
        Swal.fire({
            title: 'Updating...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });
        $.ajax({
            type: "POST",
            url: "{{ url('order-status-change') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "order_status_value": order_status,
                "order_id": order_id
            },
            success: function (response) {
                Swal.close();
                if (response == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Order Status Updated Successfully',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
            },
            error: function () {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong! Please try again.'
                });
            }
        });
    }

    function updateorder_booking_percentage(percentage, item_id) {
        $.ajax({
            type: "POST",
            url: "{{ url('update-booking-percentage') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "percentage": percentage,
                "item_id": item_id
            },
            success: function (response) {
                // updated quietly
            }
        });
    }

    function assign_salesperson(order_id, salesperson_id) {
        $('#modal_order_id').val(order_id);
        $('#salesperson_select').val(salesperson_id);
        $('#assign_salesperson_modal').modal('show');
    }

    function salesperson_assign() {
        var order_id = $('#modal_order_id').val();
        var salesperson = $('#salesperson_select').val();

        if (salesperson == '' || salesperson == null) {
            Swal.fire('Error', 'Please Select SalesPerson', 'error');
            return false;
        }

        $('#salesperson_button').hide();
        $('#salesperson_spinner_button').show();

        Swal.fire({
            title: 'Assigning Salesperson...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ url('salesperson-assign-form') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "order_id": order_id,
                "salesperson_id": salesperson
            },
            success: function (response) {
                Swal.close();
                $('#salesperson_button').show();
                $('#salesperson_spinner_button').hide();

                if (response.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Assigned',
                        text: 'SalesPerson Assigned Successfully',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#assign_salesperson_modal').modal('hide');
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
            }
        });
    }

    function assign_vendor(order_id) {
        $('#modal_order_id').val(order_id);
        var url = '{{ url("assign_vendor") }}';
        $.ajax({
            url: url,
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "order_id": order_id
            },
            success: function (msg) {
                document.getElementById('dropdownreplace').innerHTML = msg;
                $('#assign_vendor_model').modal('show');
            }
        });
    }

    function form_sub_vendor() {
        var vendor_id = jQuery("#vendor_id").val();
        if (vendor_id == '') {
            Swal.fire('Error', 'Please Select Vendor', 'error');
            return false;
        }

        Swal.fire({
            title: 'Assigning Vendor...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });

        $('#order_vendor_form').submit();
    }

    function add_comm_model(order_id, order_total, sub_total, commission_percentage = '', commission_amount = '') {
        $('#comm_order_id').val(order_id);
        $('#comm_order_total').val(order_total);
        $('#comm_sub_total').val(sub_total);
        $('#add_percentage').val(commission_percentage);
        $('#add_percentage_amount').val(commission_amount);
        $('#total_comm_label').text("Total Amount : AED " + sub_total);
        $('#add_comm_model').modal('show');
    }

    $('#add_percentage').on('keyup change', function () {
        let percentage = parseFloat($(this).val());
        let total = parseFloat($('#comm_sub_total').val());
        if (!isNaN(percentage) && !isNaN(total)) {
            let amount = (total * percentage) / 100;
            $('#add_percentage_amount').val(amount.toFixed(2));
        } else {
            $('#add_percentage_amount').val('');
        }
    });

    $('#add_percentage_amount').on('keyup change', function () {
        let amount = parseFloat($(this).val());
        let total = parseFloat($('#comm_sub_total').val());
        if (!isNaN(amount) && !isNaN(total) && total > 0) {
            let percentage = (amount / total) * 100;
            $('#add_percentage').val(percentage.toFixed(2));
        } else {
            $('#add_percentage').val('');
        }
    });

    function add_comm_popup() {
        let order_id = $('#comm_order_id').val();
        let percentage = $('#add_percentage').val();
        let amount = $('#add_percentage_amount').val();
        let _token = '{{ csrf_token() }}';

        $('#add_percentage_error').html('');
        $('#add_percentage_amount_error').html('');

        if (percentage == '') {
            $('#add_percentage_error').html('Please enter percentage');
            return false;
        }

        $('#comm_button').hide();
        $('#comm_spinner').show();

        $.ajax({
            url: "{{ route('add.commission') }}",
            type: "POST",
            data: {
                _token: _token,
                order_id: order_id,
                percentage: percentage,
                amount: amount
            },
            success: function (response) {
                $('#comm_button').show();
                $('#comm_spinner').hide();

                if (response.status == 1) {
                    $('#add_comm_model').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Success', text: response.message });
                    location.reload();
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: response.message });
                }
            },
            error: function () {
                $('#comm_button').show();
                $('#comm_spinner').hide();
                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong' });
            }
        });
    }

    function handlecalanderAction(order_id, type) {
        let title = type === 'update' ? 'Update Calendar Event?' : 'Add to Calendar?';
        let text = type === 'update' ? "This will update the event in Google Calendar." : "This will create a new event in Google Calendar.";

        Swal.fire({
            title: title,
            text: text,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Yes, continue!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading() }
                });

                $.ajax({
                    url: "{{ route('admin.calendar.sync') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        order_id: order_id,
                        action_type: type
                    },
                    success: function (response) {
                        Swal.close();
                        if (response.status == 1) {
                            Swal.fire({ icon: 'success', title: 'Success', text: response.message || 'Action completed successfully', timer: 2000, showConfirmButton: false });
                        } else {
                            Swal.fire('Error', response.message || 'Something failed', 'error');
                        }
                    },
                    error: function (xhr) {
                        Swal.close();
                        Swal.fire('Error', 'Server error occurred!', 'error');
                    }
                });
            }
        });
    }

    function confirmDelete(order_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading() }
                });
                document.getElementById('delete-form-' + order_id).submit();
            }
        })
    }

    // Tooltip Initialization Helper
    function initTooltips() {
        // Remove existing tooltips to prevent ghosting
        $('.tooltip').remove();
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    }

    $(document).ready(function () {
        if ($.fn.DataTable.isDataTable('#example')) {
            $('#example').DataTable().destroy();
        }

        var table = $('#example').DataTable({
            "searching": true,
            "order": []
        });

        // Initialize tooltips on first load
        initTooltips();

        // Re-initialize tooltips whenever the table is redrawn (pagination, sorting, etc.)
        table.on('draw', function () {
            initTooltips();
        });
    });

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

    function add_amount_popup() {
        var order_id = $('#amount_order_id').val();
        var add_amount = parseFloat($('#add_amount').val());
        var date = $('#date').val();
        var collect_by = $('#collect_by').val();
        var payment_type = $('#payment_type').val();

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

        // Check if amount exceeds balance
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

                // Confirm and add amount
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Add this amount?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Adding Amount...',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });

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
                                Swal.close();
                                if (response.status === 'paid') {
                                    Swal.fire('Warning', 'Payment already completed', 'warning');
                                    return;
                                }
                                if (response.status === 'exceed') {
                                    Swal.fire('Error', 'Remaining: AED ' + response.balance, 'error');
                                    return;
                                }
                                if (response.status === 'success') {
                                    $('#add_amount_model').modal('hide');
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: 'Amount Added Successfully',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                    setTimeout(() => location.reload(), 2000);
                                }
                            },
                            error: function() {
                                Swal.close();
                                Swal.fire('Error', 'Something went wrong!', 'error');
                            }
                        });
                    }
                });
            }
        });
    }

</script>

@if ($message = Session::get('success'))
    <script>
        $(document).ready(function () {
            Swal.fire({
                title: 'Success!',
                text: "{{ $message }}",
                icon: 'success',
                timer: 3000,
                showConfirmButton: false,
                background: '#ffffff',
                iconColor: '#10b981',
                customClass: {
                    title: 'text-success font-weight-bold'
                }
            });
        });
    </script>
@endif

@if ($message = Session::get('error'))
    <script>
        $(document).ready(function () {
            Swal.fire({
                title: 'Error!',
                text: "{{ $message }}",
                icon: 'error',
                timer: 3000,
                showConfirmButton: false,
                background: '#ffffff',
                iconColor: '#ef4444',
                customClass: {
                    title: 'text-danger font-weight-bold'
                }
            });
        });
    </script>
@endif
@stop
