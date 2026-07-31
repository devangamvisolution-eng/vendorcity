@extends('admin.includes.Template')
@section('content')
    <style type="text/css">
        ul li {
            list-style: inherit;
        }
    </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Package Order - Handyman Service</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('handyman-service-order') }}">Package Order - Handyman
                                Service</a></li>
                        <li class="breadcrumb-item active">Add Package Order - Handyman Service</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div id="validator" class="alert alert-danger alert-dismissable" style="display:none;">
            <i class="fa fa-warning"></i>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
            <b>Error &nbsp;: </b><span id="error_msg1"></span>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Info</h4> -->

                        <form action="{{ route('handyman-service-order-store') }}" method="POST" id="form"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="service_charge" id="service_charge" value="0">
                            <input type="hidden" name="sub_total" id="sub_total" value="0">
                            <input type="hidden" name="vat_charge" id="vat_charge" value="0">
                            <input type="hidden" name="order_total" id="order_total" value="0">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Customer Name</label>
                                        <select id="customer_id" name="customer_id" class="form-control form-select">
                                            <option value="">Select Customer Name</option>
                                            @foreach ($customer_data as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->id }}-{{ $item->name }}-{{ $item->email }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="customer_name_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Subservice</label>
                                        <select id="subservice_id" name="subservice_id" class="form-control form-select">
                                            <option value="">Select Subservice</option>
                                            @foreach ($subservice_data as $item)
                                                <option value="{{ $item->id }}">{{ $item->subservicename }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="subservice_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Send Notification</label>
                                        <select id="send_notification" name="send_notification"
                                            class="form-control form-select">
                                            <option value="">Select</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        <p class="form-error-text" id="send_notification_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Payment Mode</label>
                                        <select id="payment_method" name="payment_method" class="form-control form-select">
                                            <option value="">Select</option>
                                            <option value="ONLINE">ONLINE</option>
                                            <option value="COD">COD</option>
                                        </select>
                                        <p class="form-error-text" id="payment_method_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="add_to_cart" style="display: none;">
                                    <h4>Service Details:</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Select Your Package Category</label>
                                                <div id="package_category_change">
                                                    <select id="package_category" name="package_category[]"
                                                        class="form-control form-select" onchange="get_package();"
                                                        multiple="multiple">
                                                        <option value="">Select Package Category</option>
                                                    </select>
                                                </div>
                                                <p class="form-error-text" id="package_category_error"
                                                    style="color: red; margin-top: 10px;"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Select Your Package</label>
                                                <div id="package_change">
                                                    <select id="package" name="package[]"
                                                        class="form-control form-select" multiple="multiple"
                                                        onchange="showPackageFields()">

                                                    </select>
                                                </div>
                                                <p class="form-error-text" id="package_error"
                                                    style="color: red; margin-top: 10px;"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="package_fields"></div>

                                </div>

                                <div class="col-md-12" id="manual_price_div" style="display: none;">
                                    <div class="form-group">
                                        <label>Manual Manpower Price (AED)</label>
                                        <input type="number" name="manual_price" id="manual_price" class="form-control"
                                            placeholder="Enter Price" onkeyup="package_calculation()"
                                            onchange="package_calculation()">
                                    </div>
                                </div>

                                <h4>Scheduling Your Service : </h4>

                                <div class="col-md-4" id="cleaner_div" style="display: none;">
                                    <div class="form-group">
                                        <label>Select your Preferred Crew</label>
                                        <div id="cleaner_change">
                                            <select id="cleaner" name="cleaner" class="form-control form-select"
                                                onchange="cleaner_on_change();">
                                                <option value="">Select Preferred Crew</option>
                                            </select>
                                        </div>
                                        <p class="form-error-text" id="cleaner_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>When would you like your service ?</label>
                                        <input type="date" name="service_date" id="service_date" class="form-control"
                                            placeholder="Enter Service Date">
                                        <p class="form-error-text" id="service_date_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="time_slot_change">
                                            <label>What time would you like us to start ?</label>
                                            <div id="time_slot_change">
                                                <select id="time_slot" name="time_slot" class="form-control form-select"
                                                    onchange="time_slot_on_change();">
                                                    <option value="">Select Time Slot</option>

                                                </select>
                                            </div>
                                        </div>
                                        <p class="form-error-text" id="time_slot_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date Charge</label>
                                        <input type="text" name="date_charge" id="date_charge" class="form-control"
                                            placeholder="Enter Date Charge" value="0">
                                        <p class="form-error-text" id="date_charge_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Timing Charge</label>
                                        <input type="text" name="timing_charge" id="timing_charge"
                                            class="form-control" placeholder="Enter Timing Charge" value="0">
                                        <p class="form-error-text" id="timing_charge_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Service Fee</label>
                                        <input type="text" name="service_fee" id="service_fee" class="form-control"
                                            placeholder="Enter Service Fee" value="0">
                                        <p class="form-error-text" id="service_fee_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Cash On Delivery Charge</label>
                                        <input type="text" name="cod_charge" id="cod_charge" class="form-control"
                                            placeholder="Enter Cash On Delivery Charge" value="0">
                                        <p class="form-error-text" id="cod_charge_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Vat Charge Include</label>
                                        <select id="include_vat" name="include_vat" class="form-control form-select">
                                            <option value="">Select Vat Charge Include</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        <p class="form-error-text" id="include_vat_error"
                                            style="color: red; margin-top: 10px;"></p>
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
                                        <p class="form-error-text" id="address_type_error"
                                            style="color: red; margin-top: 10px;"></p>
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
                                        <p class="form-error-text" id="city_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Your Area</label>
                                        <input type="text" name="area" id="area" class="form-control"
                                            placeholder="Enter Your Area">
                                        <p class="form-error-text" id="area_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Your Building Name</label>
                                        <input type="text" name="building_name" id="building_name"
                                            class="form-control" placeholder="Enter Your Building name and/or street">
                                        <p class="form-error-text" id="building_name_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Your Apartment or Villa Number</label>
                                        <input type="text" name="apartment_villa_num" id="apartment_villa_num"
                                            class="form-control"
                                            placeholder="Enter Your Apartment number & floor or Villa Number">
                                        <p class="form-error-text" id="apartment_villa_num_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <a href="{{ route('salon-spa-order') }}" class="btn btn-primary text-light">Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" onclick="validation();" id="submit_button"
                                    class="btn btn-primary">Submit</button>
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
        function validation() {
            var customer_id = jQuery("#customer_id").val();
            if (customer_id == '') {
                jQuery('#customer_name_error').html("Please Select Customer Name");
                jQuery('#customer_name_error').show().delay(0).fadeIn('show');
                jQuery('#customer_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#customer_id').offset().top - 150
                }, 1000);
                return false;
            }

            var subservice_id = jQuery("#subservice_id").val();
            if (subservice_id == '') {
                jQuery('#subservice_error').html("Please Select Subservice");
                jQuery('#subservice_error').show().delay(0).fadeIn('show');
                jQuery('#subservice_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#subservice_id').offset().top - 150
                }, 1000);
                return false;
            }
            var package_category = jQuery("#package_category").val();
            if (package_category == '') {
                jQuery('#package_category_error').html("Please Select Package Category");
                jQuery('#package_category_error').show().delay(0).fadeIn('show');
                jQuery('#package_category_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#package_category').offset().top - 150
                }, 1000);
                return false;
            }

            var package = jQuery("#package").val();
            if (package == '') {
                jQuery('#package_error').html("Please Select Package");
                jQuery('#package_error').show().delay(0).fadeIn('show');
                jQuery('#package_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#package').offset().top - 150
                }, 1000);
                return false;
            }


            if (!validatePackageFields()) {
                return false; // Stop form submission if validation fails
            }


            var service_date = jQuery("#service_date").val();
            if (service_date == '') {
                jQuery('#service_date_error').html("Please Select Service Date");
                jQuery('#service_date_error').show().delay(0).fadeIn('show');
                jQuery('#service_date_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#service_date').offset().top - 150
                }, 1000);
                return false;
            }

            var date_charge = jQuery("#date_charge").val();
            if (date_charge == '') {
                jQuery('#date_charge_error').html("Please Enter Date Charge");
                jQuery('#date_charge_error').show().delay(0).fadeIn('show');
                jQuery('#date_charge_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#date_charge').offset().top - 150
                }, 1000);
                return false;
            }

            var timing_charge = jQuery("#timing_charge").val();
            if (timing_charge == '') {
                jQuery('#timing_charge_error').html("Please Enter Timing Charge");
                jQuery('#timing_charge_error').show().delay(0).fadeIn('show');
                jQuery('#timing_charge_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#timing_charge').offset().top - 150
                }, 1000);
                return false;
            }


            var service_fee = jQuery("#service_fee").val();
            if (service_fee == '') {
                jQuery('#service_fee_error').html("Please Enter Service Fee");
                jQuery('#service_fee_error').show().delay(0).fadeIn('show');
                jQuery('#service_fee_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#service_fee').offset().top - 150
                }, 1000);
                return false;
            }

            var cod_charge = jQuery("#cod_charge").val();
            if (cod_charge == '') {
                jQuery('#cod_charge_error').html("Please Enter Cash On Delivery Charge");
                jQuery('#cod_charge_error').show().delay(0).fadeIn('show');
                jQuery('#cod_charge_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#cod_charge').offset().top - 150
                }, 1000);
                return false;
            }

            var include_vat = jQuery("#include_vat").val();
            if (include_vat == '') {
                jQuery('#include_vat_error').html("Please Select Include VAT");
                jQuery('#include_vat_error').show().delay(0).fadeIn('show');
                jQuery('#include_vat_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#include_vat').offset().top - 150
                }, 1000);
                return false;
            }

            var time_slot = jQuery("#time_slot").val();
            if (time_slot == '') {
                jQuery('#time_slot_error').html("Please Select Time Slot");
                jQuery('#time_slot_error').show().delay(0).fadeIn('show');
                jQuery('#time_slot_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#time_slot').offset().top - 150
                }, 1000);
                return false;
            }

            var address_type = jQuery("#address_type").val();
            if (address_type == '') {
                jQuery('#address_type_error').html("Please Select Address Type");
                jQuery('#address_type_error').show().delay(0).fadeIn('show');
                jQuery('#address_type_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#address_type').offset().top - 150
                }, 1000);
                return false;
            }

            var city = jQuery("#city").val();
            if (city == '') {
                jQuery('#city_error').html("Please Select City");
                jQuery('#city_error').show().delay(0).fadeIn('show');
                jQuery('#city_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#city').offset().top - 150
                }, 1000);
                return false;
            }

            var area = jQuery("#area").val();
            if (area == '') {
                jQuery('#area_error').html("Please Enter Your Area");
                jQuery('#area_error').show().delay(0).fadeIn('show');
                jQuery('#area_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#area').offset().top - 150
                }, 1000);
                return false;
            }

            var building_name = jQuery("#building_name").val();
            if (building_name == '') {
                jQuery('#building_name_error').html("Please Enter Your Building or Street Name ");
                jQuery('#building_name_error').show().delay(0).fadeIn('show');
                jQuery('#building_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#building_name').offset().top - 150
                }, 1000);
                return false;
            }

            var apartment_villa_num = jQuery("#apartment_villa_num").val();
            if (apartment_villa_num == '') {
                jQuery('#apartment_villa_num_error').html("Please Enter Apartment or Villa Number");
                jQuery('#apartment_villa_num_error').show().delay(0).fadeIn('show');
                jQuery('#apartment_villa_num_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#apartment_villa_num').offset().top - 150
                }, 1000);
                return false;
            }


            if (subservice_id == 28) {
                // for home cleaning Calculation
                home_cleaning_calculation();
            } else {
                // for Package System Calculation
                package_calculation();
            }


            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#form').submit();

        }
    </script>

    <script>
        //For 14 days avaialble for booking
        const today = new Date();
        const futureDate = new Date();

        // Set future date to 14 days from today
        futureDate.setDate(today.getDate() + 30);

        // Format dates to YYYY-MM-DD
        const todayStr = today.toISOString().split('T')[0];
        const futureDateStr = futureDate.toISOString().split('T')[0];

        // Set the min and max attributes
        const dateInput = document.getElementById('service_date');
        dateInput.min = todayStr;
        dateInput.max = futureDateStr;
    </script>

    <script>
        $(document).ready(function() {
            $('#how_often_you_need').change(function() {
                var how_often_you_need = $('#how_often_you_need').val();
                if (how_often_you_need === 'Multiple times a week') {
                    $('#which_day_you_want_div').show();
                    $('#which_day_you_want').select2({
                        placeholder: 'Select which days you want service',
                    });
                } else {
                    $('#which_day_you_want_div').hide();
                    $('#which_day_you_want').val([]).trigger('change');
                }
            });

            $('#customer_id').select2({
                placeholder: 'Select Customer Name',
                allowClear: true
            });
            $('#package').select2({
                placeholder: 'Select Packages', // Add your desired placeholder text here
            });
            $('#package_category').select2({
                placeholder: 'Select Package Category', // Add your desired placeholder text here
            });
        });


        //Need Cleaning Material Yes then Material Value element Show

        $('#need_cleaning_material').change(function() {
            var need_cleaning_material = $('#need_cleaning_material').val();
            if (need_cleaning_material === 'Yes') {
                $('#cleaning_material_charge_div').show();
            } else {
                $('#cleaning_material_charge_div').hide();
            }
        });

        //If cleaner more then 1 then cleaner div hide

        $('#how_many_cleaner').change(function() {
            var how_many_cleaner = $('#how_many_cleaner').val();
            if (how_many_cleaner == 1) {
                $('#cleaner_div').show();
            } else {
                $('#cleaner_div').hide();
            }
        });


        //On subservice Change the cleaner will change and date & time slot will be empty

        $('#subservice_id').change(function() {
            var subservice_id = $(this).val();

            $('#time_slot').val('');
            $('#service_date').val('');

            if (subservice_id == 28) {
                $('.home_cleaning_form').show();
                $('.add_to_cart').hide();
                $('#cleaner_div').show();
                $('#manual_price_div').hide();
                $('.add_to_cart').find('input, select, textarea').val('');
            } else if (subservice_id == 102) {
                $('.home_cleaning_form').hide();
                $('#cleaner_div').hide();
                $('.add_to_cart').hide();
                $('#manual_price_div').show();
                $('.add_to_cart').find('input, select, textarea').val('');
            } else {
                $('.home_cleaning_form').hide();
                $('#cleaner_div').hide();
                $('#manual_price_div').hide();
                $('.add_to_cart').show();
                $('.home_cleaning_form').find('input, select, textarea').val('');
            }


            var url = '{{ url('get-subservice-cleaners') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "subservice_id": subservice_id
                },
                success: function(msg) {
                    // alert(msg);
                    document.getElementById('cleaner_change').innerHTML = msg;
                }
            });

            var url = '{{ url('get-package-category') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "subservice_id": subservice_id
                },
                success: function(msg) {
                    // alert(msg);
                    document.getElementById('package_category_change').innerHTML = msg;
                    $('#package_category').select2({
                        placeholder: 'Select Package Category',
                    });
                }
            });
        });

        // On hour value change the time slot and service date will be empty
        $('#hour_value').change(function() {
            $('#time_slot').val('');
            $('#service_date').val('');
        });

        //On date change the Time slot will change

        $('#service_date').change(function() {
            var date = $(this).val();
            $('#time_slot').val('');
            var cleaner = $('#cleaner').val();

            var subservice_id = $('#subservice_id').val();

            var url = '{{ url('get-cleaners-time-slot') }}';

            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "date": date,
                    "cleaner": cleaner,
                    "subservice_id": subservice_id,

                },
                success: function(msg) {
                    // alert(msg);
                    document.getElementById('time_slot_change').innerHTML = msg;
                }
            });

        });

        //On cleaner change the time slot and service date will be empty
        function cleaner_on_change() {
            $('#service_date').val('');
            $('#time_slot').val('');
        }

        function get_package() {

            selectedPackages = $('#package').val() || [];
            var package_category = $('#package_category').val();
            // alert(package_category);
            var subservice_id = $('#subservice_id').val();
            $('#time_slot').val('');
            $('#service_date').val('');
            var url = '{{ url('get-package') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "package_category": package_category,
                    "subservice_id": subservice_id,
                    "selectedPackages": selectedPackages
                },
                success: function(msg) {
                    // alert(msg);
                    document.getElementById('package_change').innerHTML = msg;
                    $('#package').select2({
                        placeholder: 'Select Packages', // Add your desired placeholder text here
                    });
                }
            });
        }

        function time_slot_on_change() {

            var time_slot = $('#time_slot').val();
            var hour_value = $('#hour_value').val();
            var cleaner = $('#cleaner').val();
            var service_date = $('#service_date').val();
            var subservice_id = $('#subservice_id').val();

            var url = '{{ url('time-slot-available') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "time_slot": time_slot,
                    "hour_value": hour_value,
                    "cleaner": cleaner,
                    "subservice_id": subservice_id,
                    "service_date": service_date,
                },
                dataType: "json", // Ensure response is treated as JSON
                success: function(response) {
                    if (response.status === "error") {
                        alert(response.message);
                        $('#time_slot').val('');
                    } else {
                        console.log("Success");
                    }
                },
            });

        }
    </script>

    <script>
        function package_calculation() {

            let packageCategory = $('#package_category').val();
            let selectedPackages = $('#package').val();
            let subservice_id = $('#subservice_id').val();

            let service_charge = 0;

            if (subservice_id == 102) {
                service_charge = parseFloat($('#manual_price').val()) || 0;
            } else {
                if (selectedPackages && selectedPackages.length > 0) {
                    selectedPackages.forEach(packageId => {
                        let quantity = $(`[name="${packageId}_quantity"]`).val();
                        let price = $(`[name="${packageId}_price"]`).val();

                        quantity = parseFloat(quantity) || 0;
                        price = parseFloat(price) || 0;

                        if (quantity > 0 && price >= 0) {
                            service_charge += quantity * price;
                        }
                    });
                }
            }



            let cod_charge = parseFloat($('#cod_charge').val()) || 0;
            let timing_charge = parseFloat($('#timing_charge').val()) || 0;
            let date_charge = parseFloat($('#date_charge').val()) || 0;
            let service_fee = parseFloat($('#service_fee').val()) || 0;
            let include_vat = $('#include_vat').val();

            let sub_total = service_charge + cod_charge + service_fee + timing_charge + date_charge;

            // Initialize vat_charge
            let vat_charge = 0;

            if (include_vat === 'yes') {
                vat_charge = sub_total * 5 / 100;
            }

            // Calculate order total
            let order_total = sub_total + vat_charge;

            // Update the form fields
            $('#service_charge').val(service_charge.toFixed(2));
            $('#sub_total').val(sub_total.toFixed(2));
            $('#vat_charge').val(vat_charge.toFixed(2));
            $('#order_total').val(order_total.toFixed(2));


        }



        let selectedPackageIds = [];

        function showPackageFields() {
            const packageSelect = document.getElementById('package');
            const packageFields = document.getElementById('package_fields');
            const selectedPackages = Array.from(packageSelect.selectedOptions).map(option => option.value);

            selectedPackageIds = selectedPackages; // ✅ Store for validation use

            // Remove fields for unselected packages
            const existingFields = packageFields.querySelectorAll('[data-package-id]');
            existingFields.forEach(field => {
                const packageId = field.getAttribute('data-package-id');
                if (!selectedPackages.includes(packageId)) {
                    field.remove();
                }
            });

            // Add fields for newly selected packages
            selectedPackages.forEach(packageId => {
                if (!document.querySelector(`[data-package-id="${packageId}"]`)) {
                    const packageName = packageSelect.querySelector(`option[value="${packageId}"]`).text;
                    const packageDiv = document.createElement('div');
                    packageDiv.className = 'col-12';
                    packageDiv.setAttribute('data-package-id', packageId);

                    packageDiv.innerHTML = `
                <div class="row align-items-center mb-3">
                    <div class="col-6">
                        <label>${packageName} - Quantity</label>
                        <input type="number" name="${packageId}_quantity" id="${packageId}_quantity" class="form-control" min="1" placeholder="Enter Quantity">
                        <p class="form-error-text" id="${packageId}_quantity_error" style="color: red; margin-top: 10px;"></p>
                    </div>
                    <div class="col-6">
                        <label>${packageName} - Price</label>
                        <input type="number" name="${packageId}_price" id="${packageId}_price" class="form-control" min="0" step="0.01" placeholder="Enter Price">
                        <p class="form-error-text" id="${packageId}_price_error" style="color: red; margin-top: 10px;"></p>
                    </div>
                </div>
            `;

                    packageFields.appendChild(packageDiv);
                }
            });
        }

        function validatePackageFields() {
            let isValid = true;

            selectedPackageIds.forEach(packageId => {
                const quantity = $(`#${packageId}_quantity`).val();
                const price = $(`#${packageId}_price`).val();

                // Clear previous error messages
                $(`#${packageId}_quantity_error`).html('');
                $(`#${packageId}_price_error`).html('');

                // Validate quantity
                if (quantity === '' || quantity <= 0) {
                    $(`#${packageId}_quantity_error`).html("Please enter a valid quantity")
                        .show().delay(2000).fadeOut('slow');
                    $('html, body').animate({
                        scrollTop: $(`#${packageId}_quantity`).offset().top - 150
                    }, 500);
                    isValid = false;
                }

                // Validate price
                if (price === '' || price < 0) {
                    $(`#${packageId}_price_error`).html("Please enter a valid price")
                        .show().delay(2000).fadeOut('slow');
                    $('html, body').animate({
                        scrollTop: $(`#${packageId}_price`).offset().top - 150
                    }, 500);
                    isValid = false;
                }
            });

            return isValid;
        }


        // Add event listener to the select element
        const packageSelect = document.getElementById('package');
        packageSelect.addEventListener('change', showPackageFields);
    </script>
@stop
