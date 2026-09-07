@extends('admin.includes.Template')
@section('content')

    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Add Survey Order</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('survey-orders.index') }}">Survey Orders</a></li>
                        <li class="breadcrumb-item active">Add Survey Order</li>
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
                        <form id="add_form" action="{{ route('survey-orders.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Customer Name</label>
                                        <select name="customer_id" id="customer_id" class="form-control form-select">
                                            <option value="">Select Customer Name</option>
                                            @foreach ($customer as $customer_data)
                                                <option value="{{ $customer_data->id }}">{{ $customer_data->id }}-{{ $customer_data->name }}-{{ $customer_data->email }}</option>
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
                                                <option value="{{ $srv->id }}">{{ $srv->servicename }}</option>
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
                                            <!-- Dynamically populated -->
                                        </select>
                                        <p class="form-error-text" id="subservice_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Send Notification</label>
                                        <select id="send_notification" name="send_notification" class="form-control form-select">
                                            <option value="">Select</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        <p class="form-error-text" id="send_notification_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Payment Mode</label>
                                        <select id="payment_method" name="payment_method" class="form-control form-select">
                                            <option value="">Select</option>
                                            <option value="CASH ON DELIVERY">CASH ON DELIVERY</option>
                                            <option value="ONLINE">ONLINE</option>
                                        </select>
                                        <p class="form-error-text" id="payment_method_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3" id="survey_div" style="display: none;">
                                    <h4>Survey Requirment:</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Additional Notes</label>
                                                <textarea name="manpower_additional_notes" class="form-control" rows="3" placeholder="Enter any additional notes..."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Subtotal (AED)</label>
                                                <input type="number" name="sub_total" id="manual_price" class="form-control" placeholder="Enter Price" onkeyup="package_calculation()" onchange="package_calculation()">
                                                <small class="text-muted">Admin can directly add price for this survey order.</small>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <h4>Scheduling Your Service : </h4>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>When would you like your service ?</label>
                                        <input type="date" name="service_date" id="service_date" class="form-control"
                                            placeholder="Enter Service Date">
                                        <p class="form-error-text" id="service_date_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="time_slot_change">
                                            <label>What time would you like us to start ?</label>
                                            <div id="time_slot_change">
                                                <select id="time_slot" name="time_slot" class="form-control form-select" onchange="time_slot_on_change();">
                                                    <option value="">Select Time Slot</option>
                                                    @foreach($time_slots as $slot)
                                                        <option value="{{ $slot->name }}">{{ $slot->name }}</option>
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
                                            placeholder="Enter Date Charge" value="0" onkeyup="package_calculation()" onchange="package_calculation()">
                                        <p class="form-error-text" id="date_charge_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Timing Charge</label>
                                        <input type="text" name="timing_charge" id="timing_charge"
                                            class="form-control" placeholder="Enter Timing Charge" value="0" onkeyup="package_calculation()" onchange="package_calculation()">
                                        <p class="form-error-text" id="timing_charge_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Service Fee</label>
                                        <input type="text" name="service_fee" id="service_fee" class="form-control"
                                            placeholder="Enter Service Fee" value="0" onkeyup="package_calculation()" onchange="package_calculation()">
                                        <p class="form-error-text" id="service_fee_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Cash On Delivery Charge</label>
                                        <input type="text" name="cod_charge" id="cod_charge" class="form-control"
                                            placeholder="Enter Cash On Delivery Charge" value="0" onkeyup="package_calculation()" onchange="package_calculation()">
                                        <p class="form-error-text" id="cod_charge_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Vat Charge Include</label>
                                        <select id="include_vat" name="include_vat" class="form-control form-select" onchange="package_calculation()">
                                            <option value="">Select Vat Charge Include</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
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
                                            <option value="home" selected>Home</option>
                                            <option value="office">Office</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <p class="form-error-text" id="address_type_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Select Your City</label>
                                        <select id="city" name="city" class="form-control form-select">
                                            <option value="">Select Your City</option>
                                            <option value="Dubai" data-id="17" selected>Dubai</option>
                                            <option value="Abu Dhabi" data-id="20">Abu Dhabi</option>
                                            <option value="Sharjah" data-id="22">Sharjah</option>
                                            <option value="Ajman" data-id="23">Ajman</option>
                                            <option value="Umm Al Quwain" data-id="24">Umm Al Quwain</option>
                                            <option value="Ras Al Khaimah" data-id="25">Ras Al Khaimah</option>
                                            <option value="Fujairah" data-id="26">Fujairah</option>
                                        </select>
                                        <p class="form-error-text" id="city_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Your Area</label>
                                        <input type="text" name="area" id="area" class="form-control" placeholder="Enter Your Area">
                                        <p class="form-error-text" id="area_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Your Building Name</label>
                                        <input type="text" name="building_name" id="building_name"
                                            class="form-control" placeholder="Enter Your Building name and/or street">
                                        <p class="form-error-text" id="building_name_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Your Apartment or Villa Number</label>
                                        <input type="text" name="apartment_villa_num" id="apartment_villa_num"
                                            class="form-control" placeholder="Enter Your Apartment number & floor or Villa Number">
                                        <p class="form-error-text" id="apartment_villa_num_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <input type="hidden" id="computed_sub_total" name="computed_sub_total">
                                <input type="hidden" id="vat_charge" name="vat_charge">
                                <input type="hidden" id="order_total" name="order_total">

                            </div>
                            <div class="text-end mt-4">
                                <a href="{{ route('survey-orders.index') }}" class="btn btn-primary text-light">Cancel</a>
                                <button type="button" class="btn btn-primary" onclick="validation();">Submit</button>
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

            $('#subservice_id').change(function() {
                var subservice_id = $(this).val();
                if(subservice_id == '102') { // 102 is manpower
                    $('#survey_div').show();
                } else {
                    $('#survey_div').show(); // The user wants "Survey Requirment" unconditionally? Wait, they said "if i click subservice manpower this same design i want in this survey order". I'll show it for all survey orders, since subtotal is required for all.
                }
            });
            $('#survey_div').show();
        });

        function validation() {
            var customer_id = $("#customer_id").val();
            if (customer_id == '') {
                $('#customer_name_error').html("Please Select Customer Name");
                $('#customer_name_error').show().delay(0).fadeIn('show');
                $('#customer_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({ scrollTop: $('#customer_id').offset().top - 150 }, 1000);
                return false;
            }

            var service_id = $("#service_id").val();
            if (service_id == '') {
                $('#service_error').html("Please Select Service");
                $('#service_error').show().delay(0).fadeIn('show');
                $('#service_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({ scrollTop: $('#service_id').offset().top - 150 }, 1000);
                return false;
            }

            var subservice_id = $("#subservice_id").val();
            if (subservice_id == '') {
                $('#subservice_error').html("Please Select Subservice");
                $('#subservice_error').show().delay(0).fadeIn('show');
                $('#subservice_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({ scrollTop: $('#subservice_id').offset().top - 150 }, 1000);
                return false;
            }

            var send_notification = $("#send_notification").val();
            if (send_notification == '') {
                $('#send_notification_error').html("Please Select Send Notification");
                $('#send_notification_error').show().delay(0).fadeIn('show');
                $('#send_notification_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({ scrollTop: $('#send_notification').offset().top - 150 }, 1000);
                return false;
            }

            var payment_method = $("#payment_method").val();
            if (payment_method == '') {
                $('#payment_method_error').html("Please Select Payment Mode");
                $('#payment_method_error').show().delay(0).fadeIn('show');
                $('#payment_method_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({ scrollTop: $('#payment_method').offset().top - 150 }, 1000);
                return false;
            }

            var service_date = $("#service_date").val();
            if (service_date == '') {
                $('#service_date_error').html("Please Select Service Date");
                $('#service_date_error').show().delay(0).fadeIn('show');
                $('#service_date_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({ scrollTop: $('#service_date').offset().top - 150 }, 1000);
                return false;
            }

            var time_slot = $("#time_slot").val();
            if (time_slot == '') {
                $('#time_slot_error').html("Please Select Time Slot");
                $('#time_slot_error').show().delay(0).fadeIn('show');
                $('#time_slot_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({ scrollTop: $('#time_slot').offset().top - 150 }, 1000);
                return false;
            }

            var address_type = $("#address_type").val();
            if (address_type == '') {
                $('#address_type_error').html("Please Select Address Type");
                $('#address_type_error').show().delay(0).fadeIn('show');
                $('#address_type_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({ scrollTop: $('#address_type').offset().top - 150 }, 1000);
                return false;
            }

            var city = $("#city").val();
            if (city == '') {
                $('#city_error').html("Please Select City");
                $('#city_error').show().delay(0).fadeIn('show');
                $('#city_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({ scrollTop: $('#city').offset().top - 150 }, 1000);
                return false;
            }

            var area = $("#area").val();
            if (area == '') {
                $('#area_error').html("Please Enter Your Area");
                $('#area_error').show().delay(0).fadeIn('show');
                $('#area_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({ scrollTop: $('#area').offset().top - 150 }, 1000);
                return false;
            }

            var sub_total = $("#manual_price").val();
            if (sub_total == '') {
                // Add error placeholder under manual_price if it doesn't exist, or just alert/focus
                alert("Please Enter Subtotal (AED)");
                $('html, body').animate({ scrollTop: $('#manual_price').offset().top - 150 }, 1000);
                return false;
            }

            $('#add_form').submit();
        }

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
