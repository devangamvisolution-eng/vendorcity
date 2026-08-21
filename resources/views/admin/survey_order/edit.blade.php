@extends('admin.includes.Template')
@section('content')

    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Survey Order</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('survey-orders.index') }}">Survey Orders</a></li>
                        <li class="breadcrumb-item active">Edit Survey Order</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div id="validator" class="alert alert-danger alert-dismissable" style="display:none;">
            <i class="fa fa-warning"></i>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
            <b>Error &nbsp; </b><span id="error_msg1"></span>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form id="add_form" action="{{ route('survey-orders.update', $order->order_id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- removed hidden service_id to prevent ID conflict -->
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Customer Name</label>
                                        <select name="customer_id" id="customer_id" class="form-control form-select">
                                            <option value="">Select Customer Name</option>
                                            @foreach ($customer as $customer_data)
                                                <option value="{{ $customer_data->id }}" {{ $order->user_id == $customer_data->id ? 'selected' : '' }}>{{ $customer_data->id }}-{{ $customer_data->name }}-{{ $customer_data->email }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="customer_name_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Service</label>
                                        <select name="service_id" id="service_id" class="form-control" required>
                                            <option value="">Select Service</option>
                                            @foreach($services as $srv)
                                                <option value="{{ $srv->id }}" {{ ($orderItem->service_id ?? 0) == $srv->id ? 'selected' : '' }}>{{ $srv->servicename }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="service_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Subservice</label>
                                        <select name="subservice_id" id="subservice_id" class="form-control form-select">
                                            <option value="">Select Subservice</option>
                                            @foreach($subservices as $subsrv)
                                                <option value="{{ $subsrv->id }}" {{ ($orderItem->subservice_id ?? 0) == $subsrv->id ? 'selected' : '' }}>{{ $subsrv->subservicename }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="subservice_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Order Status</label>
                                        <select name="order_status" class="form-control">
                                            <option value="P" {{ $order->order_status == 'P' ? 'selected' : '' }}>Pending</option>
                                            <option value="CO" {{ $order->order_status == 'CO' ? 'selected' : '' }}>Completed</option>
                                            <option value="C" {{ $order->order_status == 'C' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Send Notification</label>
                                        <select id="send_notification" name="send_notification" class="form-control form-select">
                                            <option value="no">No</option>
                                            <option value="yes">Yes (Resend)</option>
                                        </select>
                                        <p class="form-error-text" id="send_notification_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Payment Mode</label>
                                        <select id="payment_method" name="payment_method" class="form-control form-select">
                                            <option value="CASH ON DELIVERY" {{ $order->paymentmode == 'CASH ON DELIVERY' || $order->paymentmode == '3' ? 'selected' : '' }}>CASH ON DELIVERY</option>
                                            <option value="ONLINE" {{ $order->paymentmode == 'ONLINE' || $order->paymentmode == '1' ? 'selected' : '' }}>ONLINE</option>
                                        </select>
                                        <p class="form-error-text" id="payment_method_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3" id="survey_div">
                                    <h4>Survey Requirment:</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Additional Notes</label>
                                                <textarea name="manpower_additional_notes" class="form-control" rows="3" placeholder="Enter any additional notes...">{{ $orderItem->manpower_additional_notes ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Subtotal (AED)</label>
                                                <input type="number" name="sub_total" id="manual_price" class="form-control" placeholder="Enter Price" onkeyup="package_calculation()" onchange="package_calculation()" value="{{ $order->sub_total }}">
                                                <small class="text-muted">Admin can directly add price for this survey order.</small>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <h4>Scheduling Your Service : </h4>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        @php
                                            $service_date = '';
                                            if($orderItem) {
                                                $service_date = date('Y-m-d', strtotime($orderItem->bookingyear.'-'.$orderItem->month.'-'.$orderItem->bookingdate));
                                            }
                                        @endphp
                                        <label>When would you like your service ?</label>
                                        <input type="date" name="service_date" id="service_date" class="form-control"
                                            placeholder="Enter Service Date" value="{{ $service_date }}">
                                        <p class="form-error-text" id="service_date_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="time_slot_change">
                                            <label>What time would you like us to start ?</label>
                                            <div id="time_slot_change">
                                                <select id="time_slot" name="time_slot" class="form-control form-select">
                                                    <option value="">Select Time Slot</option>
                                                    @foreach($time_slots as $slot)
                                                        <option value="{{ $slot->name }}" {{ (isset($orderItem->time_slot) && $orderItem->time_slot == $slot->name) ? 'selected' : '' }}>
                                                            {{ $slot->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <p class="form-error-text" id="time_slot_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date Charge</label>
                                        <input type="text" name="date_charge" id="date_charge" class="form-control"
                                            placeholder="Enter Date Charge" value="{{ $order->date_charge ?? 0 }}" onkeyup="package_calculation()" onchange="package_calculation()">
                                        <p class="form-error-text" id="date_charge_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Timing Charge</label>
                                        <input type="text" name="timing_charge" id="timing_charge"
                                            class="form-control" placeholder="Enter Timing Charge" value="{{ $order->timing_charge ?? 0 }}" onkeyup="package_calculation()" onchange="package_calculation()">
                                        <p class="form-error-text" id="timing_charge_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Service Fee</label>
                                        <input type="text" name="service_fee" id="service_fee" class="form-control"
                                            placeholder="Enter Service Fee" value="{{ $order->service_fee ?? 0 }}" onkeyup="package_calculation()" onchange="package_calculation()">
                                        <p class="form-error-text" id="service_fee_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Cash On Delivery Charge</label>
                                        <input type="text" name="cod_charge" id="cod_charge" class="form-control"
                                            placeholder="Enter Cash On Delivery Charge" value="{{ $order->cod_charge ?? 0 }}" onkeyup="package_calculation()" onchange="package_calculation()">
                                        <p class="form-error-text" id="cod_charge_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Vat Charge Include</label>
                                        <select id="include_vat" name="include_vat" class="form-control form-select" onchange="package_calculation()">
                                            <option value="">Select Vat Charge Include</option>
                                            <option value="yes" {{ (isset($order->vat_charge) && $order->vat_charge > 0) ? 'selected' : '' }}>Yes</option>
                                            <option value="no" {{ (!isset($order->vat_charge) || $order->vat_charge == 0) ? 'selected' : '' }}>No</option>
                                        </select>
                                        <p class="form-error-text" id="include_vat_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <h4>Your Location : </h4>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Where would you like your service ?</label>
                                        <select id="address_type" name="address_type" class="form-control form-select">
                                            <option value="">Select Your Address</option>
                                            <option value="home" {{ (isset($orderItem->address_type) && $orderItem->address_type == 'home') ? 'selected' : '' }}>Home</option>
                                            <option value="office" {{ (isset($orderItem->address_type) && $orderItem->address_type == 'office') ? 'selected' : '' }}>Office</option>
                                            <option value="other" {{ (isset($orderItem->address_type) && $orderItem->address_type == 'other') ? 'selected' : '' }}>Other</option>
                                        </select>
                                        <p class="form-error-text" id="address_type_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Select Your City</label>
                                        <!-- For simplicity since we don't have emiratesList in this controller easily, we just output the previously selected city as selected or typical hardcoded like in Handyman. -->
                                        <select id="city" name="city" class="form-control form-select">
                                            <option value="">Select Your City</option>
                                            <option value="Dubai" {{ (isset($orderItem->city) && $orderItem->city == 'Dubai') ? 'selected' : '' }}>Dubai</option>
                                            <option value="Abu Dhabi" {{ (isset($orderItem->city) && $orderItem->city == 'Abu Dhabi') ? 'selected' : '' }}>Abu Dhabi</option>
                                            <option value="Sharjah" {{ (isset($orderItem->city) && $orderItem->city == 'Sharjah') ? 'selected' : '' }}>Sharjah</option>
                                            <option value="Ajman" {{ (isset($orderItem->city) && $orderItem->city == 'Ajman') ? 'selected' : '' }}>Ajman</option>
                                            <option value="Umm Al Quwain" {{ (isset($orderItem->city) && $orderItem->city == 'Umm Al Quwain') ? 'selected' : '' }}>Umm Al Quwain</option>
                                            <option value="Ras Al Khaimah" {{ (isset($orderItem->city) && $orderItem->city == 'Ras Al Khaimah') ? 'selected' : '' }}>Ras Al Khaimah</option>
                                            <option value="Fujairah" {{ (isset($orderItem->city) && $orderItem->city == 'Fujairah') ? 'selected' : '' }}>Fujairah</option>
                                        </select>
                                        <p class="form-error-text" id="city_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Your Area</label>
                                        <input type="text" name="area" id="area" class="form-control" placeholder="Enter Your Area" value="{{ $orderItem->area ?? '' }}">
                                        <p class="form-error-text" id="area_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Your Building Name</label>
                                        <input type="text" name="building_name" id="building_name"
                                            class="form-control" placeholder="Enter Your Building name and/or street" value="{{ $orderItem->building_street_no ?? '' }}">
                                        <p class="form-error-text" id="building_name_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Your Apartment or Villa Number</label>
                                        <input type="text" name="apartment_villa_num" id="apartment_villa_num"
                                            class="form-control" placeholder="Enter Your Apartment number & floor or Villa Number" value="{{ $orderItem->apartment_villa_no ?? '' }}">
                                        <p class="form-error-text" id="apartment_villa_num_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <hr class="mt-4">
                                
                                <input type="hidden" id="computed_sub_total" name="computed_sub_total" value="{{ $order->sub_total }}">
                                <input type="hidden" id="vat_charge" name="vat_charge" value="{{ $order->vat_charge ?? 0 }}">
                                <input type="hidden" id="order_total" name="order_total" value="{{ $order->order_total }}">
                                <input type="hidden" name="salesperson_id" value="{{ $orderItem->salesperson_id ?? '' }}">
                                <input type="hidden" name="vendor_id" value="{{ $orderItem->vendor_id ?? '' }}">

                            </div>
                            <div class="text-end mt-4">
                                <a href="{{ route('survey-orders.index') }}" class="btn btn-primary text-light">Cancel</a>
                                <button type="submit" id="submit_button" class="btn btn-primary">Update Survey Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer_js')
    <script>
        let codCharge = window.Enums ? window.Enums.vcCharges.COD.value : 0;
        let vatPercent = window.Enums ? window.Enums.vcCharges.VAT_PERCENT.value : 5;
    </script>
    <script>
        $(document).ready(function() {
            $('#customer_id, select[name="vendor_id"], select[name="salesperson_id"]').select2({
                placeholder: 'Select an option',
            });
            
            $('#service_id').change(function() {
                var service_id = $(this).val();
                if(service_id) {
                    $.ajax({
                        url: '{{ route("general-enquiries.get-subservices") }}',
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            service_id: service_id
                        },
                        dataType: "json",
                        success:function(data) {
                            $('#subservice_id').empty();
                            $('#subservice_id').append('<option value="">Select Subservice</option>');
                            $.each(data, function(key, value) {
                                $('#subservice_id').append('<option value="'+ value.id +'">'+ value.subservicename +'</option>');
                            });
                        }
                    });
                } else {
                    $('#subservice_id').empty();
                }
            });
        });

        function package_calculation() {
            let service_charge = parseFloat($('#manual_price').val()) || 0;
            let cod_charge = parseFloat($('#cod_charge').val()) || 0;
            let timing_charge = parseFloat($('#timing_charge').val()) || 0;
            let date_charge = parseFloat($('#date_charge').val()) || 0;
            let service_fee = parseFloat($('#service_fee').val()) || 0;
            let include_vat = $('#include_vat').val();

            let sub_total = service_charge + cod_charge + service_fee + timing_charge + date_charge;
            let vat_charge = 0;

            if (include_vat === 'yes') {
                vat_charge = sub_total * (vatPercent / 100);
            }

            let order_total = sub_total + vat_charge;

            $('#computed_sub_total').val(sub_total.toFixed(2));
            $('#vat_charge').val(vat_charge.toFixed(2));
            $('#order_total').val(order_total.toFixed(2));
        }
        
        // Removed AJAX logic for service_date -> time_slot_change for survey orders
    </script>
@stop
