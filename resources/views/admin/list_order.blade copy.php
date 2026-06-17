@extends('admin.includes.Template')
@section('content')
<style>
    .payment-id-cell .copy-btn {
        opacity: 0;
        /* Hidden by default */
        transition: opacity 0.2s ease;
        text-decoration: none;
    }

    .payment-id-cell:hover .copy-btn {
        opacity: 1;
        /* Shows only when hovering the row cell */
    }

    .cursor-pointer {
        cursor: help;
    }

    /* Customizing the Bootstrap Tooltip look */
    .tooltip-inner {
        background-color: #2c3e50;
        font-size: 12px;
        padding: 8px 12px;
        border-radius: 6px;
    }
</style>
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                @if(Route::currentRouteName() == 'cleaning_package_order')
                <h3 class="page-title">Package Order - Cleaning</h3>
                @elseif(Route::currentRouteName() == 'painting-service-order')
                <h3 class="page-title">Package Order - Painting</h3>
                @elseif(Route::currentRouteName() == 'handyman-service-order')
                <h3 class="page-title">Package Order - HandyMan</h3>
                @elseif(Route::currentRouteName() == 'salon-spa-order')
                <h3 class="page-title">Package Order - Salon & Spa</h3>
                @elseif(Route::currentRouteName() == 'pest-control-order')
                <h3 class="page-title">Package Order - Pest Control</h3>
                @elseif(Route::currentRouteName() == 'automobile-order')
                <h3 class="page-title">Package Order - Automobile</h3>
                @else
                <h3 class="page-title">Package Order - Moving</h3>
                @endif
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                    </li>
                    @if(Route::currentRouteName() == 'cleaning_package_order')
                    <li class="breadcrumb-item active">Package Order - Cleaning</li>
                    @elseif(Route::currentRouteName() == 'painting-service-order')
                    <li class="breadcrumb-item active">Package Order - Painting</li>
                    @elseif(Route::currentRouteName() == 'handyman-service-order')
                    <li class="breadcrumb-item active">Package Order - HandyMan</li>
                    @elseif(Route::currentRouteName() == 'salon-spa-order')
                    <li class="breadcrumb-item active">Package Order - Salon & Spa</li>
                    @elseif(Route::currentRouteName() == 'pest-control-order')
                    <li class="breadcrumb-item active">Package Order - Pest Control</li>
                    @elseif(Route::currentRouteName() == 'automobile-order')
                    <li class="breadcrumb-item active">Package Order - Automobile</li>
                    @else
                    <li class="breadcrumb-item active">Package Order - Moving</li>
                    @endif
                    {{-- <li class="breadcrumb-item active">Package Order</li> --}}
                </ul>
            </div>
            @if (in_array('40', $edit_perm) || in_array('19', $edit_perm) || in_array('44', $edit_perm) || in_array('45', $edit_perm) || in_array('42', $edit_perm) || in_array('59', $edit_perm))
            <div class="col-auto">
                @if(Route::currentRouteName() == 'cleaning_package_order')
                <a class="btn btn-primary me-1" href="{{ route('cleaning-admin-order') }}">
                    <i class="fas fa-plus"></i> Add Cleaning Order
                </a>
                <a class="btn btn-danger me-1" href="javascript:void('0');" onclick="delete_cleaning_order();">
                    <i class="fas fa-trash"></i> Delete
                </a>
                @endif
                @if(Route::currentRouteName() == 'order.index')
                <a class="btn btn-primary me-1" href="{{ route('moving-admin-order') }}">
                    <i class="fas fa-plus"></i> Add Moving Order
                </a>
                @endif
                @if(Route::currentRouteName() == 'salon-spa-order')
                <a class="btn btn-primary me-1" href="{{ route('salon-spa-admin-order') }}">
                    <i class="fas fa-plus"></i> Add Salon & Spa Order
                </a>
                @endif
                @if(Route::currentRouteName() == 'pest-control-order')
                <a class="btn btn-primary me-1" href="{{ route('pest-control-admin-order') }}">
                    <i class="fas fa-plus"></i> Add Pest Control Order
                </a>
                @endif
                @if(Route::currentRouteName() == 'handyman-service-order')
                <a class="btn btn-primary me-1" href="{{ route('handyman-service-admin-order') }}">
                    <i class="fas fa-plus"></i> Add Handyman Service Order
                </a>
                @endif
                @if(Route::currentRouteName() == 'painting-service-order')
                <a class="btn btn-primary me-1" href="{{ route('painting-service-admin-order') }}">
                    <i class="fas fa-plus"></i> Add Painting Service Order
                </a>
                @endif
                @if(Route::currentRouteName() == 'automobile-order')
                <a class="btn btn-primary me-1" href="{{ route('automobile-admin-order') }}">
                    <i class="fas fa-plus"></i> Add Automobile Order
                </a>
                @endif
            </div>
            @endif
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
                                        <th style="display: none">Sr no</th>
                                        @if(Route::currentRouteName() == 'cleaning_package_order')
                                        <th>Select</th>
                                        @endif
                                        <th>Order Id</th>
                                        <th>Order Date</th>
                                        @if(Route::currentRouteName() == 'painting-service-order')
                                        <th>Date & Time</th>
                                        @endif
                                        <th>Service</th>
                                        <th>User Name</th>
                                        <th>Amount</th>
                                        <th>Payment Mode</th>
                                        <th>Order Status</th>
                                        <th>Payment Status</th>
                                        <th>Payment Id</th>
                                        {{--<th>Create Shipment</th>
                                            <th>Schedule Pickup </th>
                                            <th>Label</th>
                                            <th>Track Order</th> --}}
                                        @if(Route::currentRouteName() == 'cleaning_package_order')
                                        <th>No. of Cleaner</th>
                                        @endif
                                        @if(Route::currentRouteName() == 'cleaning_package_order' || Route::currentRouteName() == 'handyman-service-order' || Route::currentRouteName() == 'salon-spa-order' || Route::currentRouteName() == 'pest-control-order')
                                        <th>Assign SalesPerson</th>
                                        <th>Crew</th>
                                        <th>Add Crew Price</th>
                                        @endif
                                        <th>Assign Vendor</th>
                                        <th>Location Link</th>
                                        <th>Booking Percentage</th>
                                        <th>Details</th>
                                        <th>Add Amount</th>
                                        @if(Route::currentRouteName() == 'cleaning_package_order')
                                        <th>End Date</th>
                                        <th>Actions</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    // echo"
                                    <pre>";print_r($orders_list);echo"</pre>";exit;

                                    if (isset($orders_list) && count($orders_list)) {
                                    foreach ($orders_list as $key => $orders) {
                                    // echo "
                                    <pre>";print_r($orders->items);echo"</pre>";
                                    @endphp

                                    @if(!empty($orders->items))
                                    <tr>

                                        <td style="display: none">{{ $i }}</td>
                                        @if(Route::currentRouteName() == 'cleaning_package_order')
                                        <td>
                                            <input name="selected[]" id="selected[]" value="{{ $orders->order_id }}"
                                                type="checkbox" class="minimal-red"
                                                style="height: 20px;width: 20px;border-radius: 0px;color: red;">
                                        </td>
                                        @endif
                                        <td>{{$orders->format_order_id}}</td>
                                        <td>
                                            @php
                                            $order_date = strtotime( $orders->created_at);
                                            echo $mysqldate = date( 'F d, Y', $order_date );
                                            @endphp
                                        </td>
                                        @if(Route::currentRouteName() == 'painting-service-order')
                                        <td>
                                            @php
                                            $date = $orders->items[0]->bookingdate ?? "";
                                            $month = $orders->items[0]->month ?? "";
                                            $year = $orders->items[0]->bookingyear ?? "";
                                            $timeSlot = Helper::timeslotname(strval($orders->items[0]->time_slot));
                                            if($date != '' && $month != '' && $year != ''){
                                            echo $month.' '.$date.', '.$year.'<br />'.$timeSlot;

                                            }else{
                                            echo "-";
                                            }
                                            @endphp
                                        </td>
                                        @endif

                                        <td>
                                            <div class="small fw-bold">{!! isset($orders->items[0]) ? Helper::servicename($orders->items[0]->service_id) : '-' !!}</div>
                                            <div class="text-muted" style="font-size: 11px;">{!! isset($orders->items[0]) ? Helper::subservicename($orders->items[0]->subservice_id) : '-' !!}</div>
                                        </td>

                                        <td>{{$orders->user_name}}</td>
                                        <td>{{number_format($orders->order_total,2);}}</td>
                                        <td>
                                            @if ($orders->paymentmode == '1')
                                            Cash On Delivery
                                            @elseif ($orders->paymentmode == '2')
                                            Online Payment
                                            @endif
                                        </td>
                                        <td>
                                            <select name="order_status" id="order_status_{{ $orders->order_id }}" class="form-control form-select" onchange="order_status_change({{ $orders->order_id }}, this)">
                                                <option value="BK" {{ $orders->order_status === 'BK' ? 'selected' : '' }}>Booking Requested</option>
                                                <option value="P" {{ $orders->order_status === 'P' ? 'selected' : '' }}>Booking Confirmed</option>
                                                <option value="PA" {{ $orders->order_status === 'PA' ? 'selected' : '' }}>Vendor Assigned</option>
                                                <option value="CO" {{ $orders->order_status === 'CO' ? 'selected' : '' }}>Booking Completed</option>
                                                <option value="CL" {{ $orders->order_status === 'CL' ? 'selected' : '' }}>Booking Cancelled</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="payment_status" name="payment_status" class="form-control form-select" onchange="payment_status_change({{ $orders->order_id }},this)">
                                                <option value="Success" {{ $orders->payment_status === 'Success' ? 'selected' : '' }}>Success</option>
                                                <option value="FAILED" {{ $orders->payment_status === 'FAILED' ? 'selected' : '' }}>Failed</option>
                                            </select>
                                        </td>
                                        <td class="payment-id-cell">
                                            @if($orders->payment_id != '')
                                            <div class="d-flex align-items-center">
                                                <span class="text-truncate cursor-pointer"
                                                    style="max-width: 120px; display: inline-block;"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="{{ $orders->payment_id }}">
                                                    {{ \Illuminate\Support\Str::limit($orders->payment_id, 15, '...') }}
                                                </span>

                                                <button type="button"
                                                    class="btn btn-link btn-sm p-0 ms-2 copy-btn"
                                                    onclick="copyToClipboard('{{ $orders->payment_id }}', this)"
                                                    title="Copy ID">
                                                    <i class="far fa-copy text-muted"></i>
                                                </button>
                                            </div>
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                        {{-- <td></td>
                                                <td></td>--}}
                                        @if(Route::currentRouteName() == 'cleaning_package_order')
                                        <td>
                                            @if(isset($orders->items[0]) && $orders->items[0]->how_many_cleaners_do_you_need !== null)
                                            {{ $orders->items[0]->how_many_cleaners_do_you_need }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                        @endif
                                        @if(Route::currentRouteName() == 'cleaning_package_order' || Route::currentRouteName() == 'handyman-service-order' || Route::currentRouteName() == 'salon-spa-order' || Route::currentRouteName() == 'pest-control-order')
                                        {{-- <td></td> --}}
                                        <td>
                                            @if(isset($orders->items[0]))
                                            @if($orders->items[0]->salesperson_id != "" && $orders->items[0]->salesperson_id != null)
                                            {!! Helper::salesperson($orders->items[0]->salesperson_id) !!}
                                            @else
                                            <a class="btn btn-primary" href="javascript:void(0)" onclick="assign_salesperson('{{$orders->order_id}}');">Assign SalesPerson</a>
                                            @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($orders->items[0]))
                                            @if($orders->items[0]->cleaner_id == 2)
                                            <a class="btn btn-primary" href="javascript:void(0)" onclick="assign_cleaner('{{$orders->order_id}}');">Assign Crew</a>
                                            @elseif($orders->items[0]->cleaner_id)

                                            @php
                                            $cleaner_Id = explode(",",$orders->items[0]->cleaner_id);
                                            @endphp
                                            {!! Helper::cleanername_new($cleaner_Id) !!}
                                            @else
                                            <a class="btn btn-primary" href="javascript:void(0)" onclick="assign_multi_cleaner('{{$orders->order_id}}');">Assign Multiple Crew</a>
                                            @endif
                                            @else
                                            -
                                            @endif
                                        </td>


                                        <td>
                                            @if($orders->items[0]->subservice_id != 28)
                                            @if(!empty($orders->items[0]->cleaner_id))
                                            @if(empty($orders->items[0]->cleaner_price))
                                            <a class="btn btn-primary" href="javascript:void(0)" onclick="add_cleaner_price('{{ $orders->order_id }}');">Add Per Crew Price</a>
                                            @else
                                            {{ $orders->items[0]->cleaner_price }}
                                            @endif
                                            @endif
                                            @else
                                            @php
                                            $cleaners_needed = $orders->items[0]->how_many_cleaners_do_you_need ?? 0;
                                            $service_charge = $orders->service_charge ?? 0;
                                            $home_cleaner_price = 0;
                                            if ($cleaners_needed > 0) {
                                            $home_cleaner_price = $service_charge / $cleaners_needed;
                                            }
                                            @endphp
                                            {{$home_cleaner_price}}
                                            @endif
                                        </td>

                                        @endif

                                        <td>
                                            @if($orders->payment_status == "Success")
                                            <p>
                                                @if($orders->vendor_id != 0 && $orders->vendor_id != '')
                                                {!! Helper::vendorsname($orders->vendor_id) !!}
                                                @endif
                                            </p>
                                            @if($orders->items[0]->service_id == 50)
                                            <a class="btn btn-primary" href="javascript:void(0)" onclick="assign_vendor_car('{{$orders->order_id}}');">Assign Vendor car</a>
                                            @else
                                            <a class="btn btn-primary" href="javascript:void(0)" onclick="assign_vendor('{{$orders->order_id}}');">Assign Vendor</a>
                                            @endif

                                            @else
                                            <lable>-</lable>
                                            @endif
                                        </td>

                                        <td>
                                            @if(!empty($orders->items[0]->location_link == ''))
                                            <a class="btn btn-primary" href="javascript:void(0)" onclick="location_link('{{$orders->order_id}}');">Location Link</a>
                                            @else
                                            <div class="d-flex align-items-center">
                                                <span class="text-truncate cursor-pointer"
                                                    style="max-width: 120px; display: inline-block;"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="{{ $orders->items[0]->location_link }}">
                                                    {{ \Illuminate\Support\Str::limit($orders->items[0]->location_link, 15, '...') }}
                                                </span>

                                                <button type="button"
                                                    class="btn btn-link btn-sm p-0 ms-2 copy-btn"
                                                    onclick="copyToClipboard('{{ $orders->items[0]->location_link }}', this)"
                                                    title="Copy ID">
                                                    <i class="far fa-copy text-muted"></i>
                                                </button>
                                            </div>
                                            @endif
                                        </td>


                                        <td class="left">

                                            @if(isset($orders->items[0]))
                                            <input type="text" value="{{ $orders->items[0]->subservice_booking_percentage }}"
                                                onchange="updateorder_booking_percentage(this.value, '{{ $orders->items[0]->id }}');"
                                                class="form-control" />
                                            @else
                                            <input type="text" value=""
                                                onchange="updateorder_booking_percentage(this.value, '');"
                                                class="form-control" placeholder="No data available" disabled />
                                            @endif
                                        </td>


                                        <td class="text-right">
                                            @if($orders->items[0]->service_id == 34)
                                            <a class="btn btn-primary" href="{{ route('painting-detail', [$orders->order_id]) }}"><i class="far fa-eye me-2"></i>Details</a>
                                            @elseif($orders->items[0]->service_id == 45)
                                            <a class="btn btn-primary" href="{{ route('cleaning-detail', [$orders->order_id]) }}"><i class="far fa-eye me-2"></i>Details</a>
                                            @elseif($orders->items[0]->subservice_id == 71)
                                            <a class="btn btn-primary" href="{{ route('handyman-detail', [$orders->order_id]) }}"><i class="far fa-eye me-2"></i>Details</a>
                                            @elseif($orders->items[0]->service_id == 48)
                                            <a class="btn btn-primary" href="{{ route('salon-spa-detail', [$orders->order_id]) }}"><i class="far fa-eye me-2"></i>Details</a>
                                            @elseif($orders->items[0]->service_id == 47)
                                            <a class="btn btn-primary" href="{{ route('pest-control-detail', [$orders->order_id]) }}"><i class="far fa-eye me-2"></i>Details</a>
                                            @else
                                            <a class="btn btn-primary" href="{{ route('moving-detail', [$orders->order_id]) }}"><i class="far fa-eye me-2"></i>Details</a>
                                            @endif
                                        </td>

                                        <td>
                                            @if($orders->vendor_id != 0 && $orders->vendor_id != '')
                                            <a class="btn btn-primary" href="javascript:void(0)" onclick="add_amount_model('{{$orders->order_id}}');">Add Amount</a>
                                            @else
                                            <lable>-</lable>
                                            @endif
                                        </td>
                                        @if(Route::currentRouteName() == 'cleaning_package_order')
                                        <td>
                                            @if($orders->items[0]->how_often_do_you_need_cleaning == 'Weekly' || $orders->items[0]->how_often_do_you_need_cleaning == 'Multiple times a week')
                                            <p>{{ $orders->items[0]->end_date ?? '-' }}</p>
                                            <a class="btn btn-primary" href="javascript:void(0);" onclick="set_end_date({{ $orders->order_id }})">
                                                End Date
                                            </a>
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <a class="btn btn-primary"
                                                href="{{ route('cleaning_package_order_edit', ['id' => $orders->order_id]) }}"><i
                                                    class="far fa-edit"></i></a>
                                        </td>

                                        @endif
                                        @endif
                                    </tr>
                                    @php
                                    $i++;
                                    } }
                                    @endphp

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
                    <input type="date" name="end_date" id="end_date" class="form-control" placeholder="Select End Date">
                    <p class="form-error-text" id="end_date_error" style="color: red; margin-top: 10px;"></p>
                </div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary mb-1" type="button" disabled id="end_date_spinner" style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...</button>
                <button type="button" id="end_date_submit" class="btn btn-primary" onclick="end_date_form_sub();">Submit</button>
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
// echo"
<pre>";print_r($orders);echo"</pre>";exit;
$salesperson_data = DB::table('users')
->whereIn('role_id', [11, 12])
->where('is_active', '0')
->get();

@endphp
<div class="modal custom-modal fade" id="assign_salesperson_model_{{$orders->order_id}}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="salesperson_assign_form" action="{{ url('salesperson-assign-form') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <select name="cleaner" id="salesperson_{{$orders->order_id}}" class="form-control">
                        <option value="">Select Salesperson</option>
                        @foreach($salesperson_data as $data)
                        <option value="{{$data->id}}">{{$data->name}}</option>
                        @endforeach
                    </select>
                    <p class="form-error-text" id="salesperson_error_{{$orders->order_id}}" style="color: red; margin-top: 10px;"></p>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary mb-1" type="button" disabled id="salesperson_spinner_button_{{$orders->order_id}}" style="display: none;">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <button type="button" class="btn btn-primary" onclick="salesperson_assign({{$orders->order_id}});" id="salesperson_button_{{$orders->order_id}}">Submit</button>
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
<div class="modal custom-modal fade" id="location_link_model_{{$orders->order_id}}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="cleaner_assign_form" action="{{ url('location-link-form') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="location_link" id="location_link_{{$orders->order_id}}" class="form-control" placeholder="Enter Location Link">
                    </div>
                    <p class="form-error-text" id="location_link_error_{{$orders->order_id}}" style="color: red; margin-top: 10px;"></p>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button_{{$orders->order_id}}" style="display: none;">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <button type="button" class="btn btn-primary" onclick="location_link_added({{$orders->order_id}});" id="cleaner_button_{{$orders->order_id}}">Submit</button>
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
// echo"
<pre>";print_r($orders);echo"</pre>";exit;
$cleaner_data = DB::table('users')
->where('role_id', 16)
->where('is_active', '0')
->whereRaw("FIND_IN_SET(?, service)", [$orders->items[0]->service_id])
->whereRaw("FIND_IN_SET(?, subservice)", [$orders->items[0]->subservice_id])
->orderBy('id', 'ASC')
->get();

@endphp
<div class="modal custom-modal fade" id="cleaner_model_{{$orders->order_id}}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="cleaner_assign_form" action="{{ url('cleaner-assign-form') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <select name="cleaner" id="cleaner_{{$orders->order_id}}" class="form-control">
                        <option value="">Select Cleaner</option>
                        @foreach($cleaner_data as $data)
                        @if($data->id != 2)
                        <option value="{{$data->id}}">{{$data->name}}</option>
                        @endif
                        @endforeach
                    </select>
                    <p class="form-error-text" id="cleaner_error_{{$orders->order_id}}" style="color: red; margin-top: 10px;"></p>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button_{{$orders->order_id}}" style="display: none;">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <button type="button" class="btn btn-primary" onclick="cleaner_assign({{$orders->order_id}});" id="cleaner_button_{{$orders->order_id}}">Submit</button>
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
        $('#multi_cleaner_{{$orders->order_id}}').select2({
            placeholder: "Select Multiple Cleaners",
            dropdownParent: $('#multi_cleaner_model_{{$orders->order_id}}')
        });
    });
</script>
@php
// echo"
<pre>";print_r($orders->items[0]);echo"</pre>";exit;
$cleaner_data = DB::table('users')
->where('role_id', 16)
->where('is_active', '0')
->whereRaw("FIND_IN_SET(?, service)", [$orders->items[0]->service_id])
->whereRaw("FIND_IN_SET(?, subservice)", [$orders->items[0]->subservice_id])
->orderBy('id', 'ASC')
->get();

@endphp
<div class="modal custom-modal fade" id="multi_cleaner_model_{{$orders->order_id}}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="multi_cleaner_assign_form" action="{{ url('multi-cleaner-assign-form') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <select name="multi_cleaner_{{ $orders->order_id }}" id="multi_cleaner_{{$orders->order_id}}" class="form-control" multiple="mulitple" onchange="multi_cleaner_timeslot({{$orders->order_id}},{{$orders->items[0]->subservice_id}});" data-max-select="{{$orders->items[0]->how_many_cleaners_do_you_need}}">
                        @foreach($cleaner_data as $data)
                        @if($data->id != 2)
                        <option value="{{$data->id}}">{{$data->name}}</option>
                        @endif
                        @endforeach
                    </select>
                    <p class="form-error-text" id="multi_cleaner_error_{{$orders->order_id}}" style="color: red; margin-top: 10px;"></p>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary mb-1" type="button" disabled id="multi_spinner_button_{{$orders->order_id}}" style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                        <button type="button" class="btn btn-primary" onclick="multi_cleaner_assign({{$orders->order_id}} ,{{$orders->items[0]->how_many_cleaners_do_you_need }})" id="multi_cleaner_button_{{$orders->order_id}}">Submit</button>
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
<div class="modal custom-modal fade" id="add_cleaner_price_model_{{$orders->order_id}}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="add_cleaner_price_form" action="{{ url('add-cleaner-price-form') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <lable>Add Per Cleaner Price</lable>
                    <input type="number" name="cleaner_price_{{ $orders->order_id }}" id="cleaner_price_{{ $orders->order_id }}" class="form-control">
                    <p class="form-error-text" id="cleaner_price_error_{{ $orders->order_id }}" style="color: red; margin-top: 10px;"></p>

                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary mb-1" type="button" disabled id="add_spinner_button_{{$orders->order_id}}" style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                        <button type="button" class="btn btn-primary" onclick="add_cleaner_price_popup({{$orders->order_id}})" id="add_cleaner_price_{{$orders->order_id}}">Submit</button>
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
            <form id="order_vendor_form" action="{{ url('order_vendor_form') }}" method="POST" enctype="multipart/form-data">
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
                    <button type="button" class="btn btn-primary" onclick="form_sub_vendor();" id="vedor_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Assign Vendor  Modal -->
<div class="modal custom-modal fade" id="assign_vendor_model_car" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="order_vendor_form" action="{{ url('order_vendor_form') }}" method="POST" enctype="multipart/form-data">
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
                {{--<div class="modal-footer text-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                    style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                    </button>
                <button type="button" class="btn btn-primary" onclick="form_sub_vendor();" id="vedor_submit">Submit</button>
            </div>--}}
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
@if (isset($orders_list) and count($orders_list))
@foreach ($orders_list as $key => $orders)
<div class="modal custom-modal fade" id="add_amount_model{{$orders->order_id}}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="add_amount_form{{$orders->order_id}}" action="{{ url('add_amount_form') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="painting_order" value="painting-service-order">
                    <input type="hidden" name="cleaning_order" value="">
                    <div class="modal-text">
                        @php
                        $service_data = DB::table('ci_order_item')->where('order_id',$orders->order_id)->first();
                        @endphp
                        <input type="hidden" name="order_id" value="{{ $orders->order_id }}">
                        <input type="hidden" name="service_id" value="{{ $service_data->service_id }}">
                        <input type="hidden" name="order_total" value="{{ $orders->order_total }}">
                        <div class="form-group text-center">
                            <label>Total Amount:AED {{number_format($orders->order_total,2)}} </label>
                        </div>
                        <div class="form-group">
                            <label>Add Amount</label>
                            <input type="number" name="add_amount" id="add_amount{{$orders->order_id}}" class="form-control" placeholder="Add Amount">
                            <p class="form-error-text" id="add_amount_error{{$orders->order_id}}" style="color: red; margin-top: 10px;"></p>
                        </div>

                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="date" id="date{{$orders->order_id}}" class="form-control" placeholder="Date">
                            <p class="form-error-text" id="date_error{{$orders->order_id}}" style="color: red; margin-top: 10px;"></p>
                        </div>
                        <div class="form-group">
                            <label>Colllect By</label>
                            <select class="form-control" name="collect_by" id="collect_by{{$orders->order_id}}">
                                <option value="">Select Colllect By</option>
                                <option value="Vendorscity">Vendorscity</option>
                                <option value="Vendor">Vendor</option>
                            </select>
                            <p class="form-error-text" id="collect_by_error{{$orders->order_id}}" style="color: red; margin-top: 10px;"></p>
                        </div>
                        <div class="form-group">
                            <label>Payment Type</label>
                            <select class="form-control" name="payment_type" id="payment_type{{$orders->order_id}}">
                                <option value="">Select Payment Type</option>
                                <option value="Online">Online</option>
                                <option value="Cash">Cash</option>
                            </select>
                            <p class="form-error-text" id="payment_type_error{{$orders->order_id}}" style="color: red; margin-top: 10px;"></p>
                        </div>
                    </div>
                    @php
                    $package_order_amount_attr_data = DB::table('package_order_amount_attr')->where('order_id',$orders->format_order_id)->get();
                    // echo"
                    <pre>";print_r($package_order_amount_attr_data);echo"</pre>";exit;
                    $total_add_amount = $package_order_amount_attr_data->sum('add_amount');
                    $balance_amount = $orders->order_total - $total_add_amount;
                    @endphp
                    <div class="form-group">
                        <label>Amount Details : (Balance Amount :AED {{$balance_amount}})</label>
                    </div>
                    @foreach($package_order_amount_attr_data as $data)
                    <div class="form-group">
                        <label>{{$data->date}} : AED {{$data->add_amount}}</label>
                    </div>
                    @endforeach
                </div>


                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button{{$orders->order_id}}"
                        style="display: none;">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <button type="button" class="btn btn-primary" onclick="add_amount_popup('{{$orders->order_id}}');" id="submit_button{{$orders->order_id}}">Submit</button>
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
            url: '{{ url('
            set - end - date ') }}',
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
        var url = '{{ url('
        checkAmountorder ') }}';
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
                    $('#payment_type_error' + order_id).text("Added Amount Should Less than Balance Amount");
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
        var url = '{{ url('
        location - link - form ') }}';
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
        var url = '{{ url('
        cleaner - assign - form ') }}';
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
        var url = '{{ url('
        add - cleaner - price - form ') }}';
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
        var url = '{{ url('
        multi - cleaner - assign - form ') }}';
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
        var url = '{{ url('
        salesperson - assign - form ') }}';
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
        var url = '{{ url('
        multi - cleaner - time - slot ') }}';
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
        var url = '{{ url('
        assign_vendor ') }}';
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
        var url = '{{ route('
        admin.assign_vendor_car ') }}';
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
        //  alert(order_id);
        //  alert(vendor_id_car);
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
    $(document).ready(function() {
        // Initialize Bootstrap Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });

    function copyToClipboard(text, element) {
        // Create a temporary input to copy from
        var tempInput = document.createElement("input");
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);

        // Visual Feedback: Change icon temporarily
        var icon = element.querySelector('i');
        icon.classList.remove('far', 'fa-copy');
        icon.classList.add('fas', 'fa-check', 'text-success');

        // Reset icon after 2 seconds
        setTimeout(function() {
            icon.classList.remove('fas', 'fa-check', 'text-success');
            icon.classList.add('far', 'fa-copy', 'text-muted');
        }, 2000);
    }
</script>
@stop