@extends('admin.includes.Template')
@section('content')
<style type="text/css">
    ul li{list-style: inherit;}
</style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Package Order - Cleaning</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cleaning_package_order_edit', ['id' => $order->order_id]) }}">
                        Edit Package Order - Cleaning</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Package Order - Cleaning</li>
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

                        <form action="{{ route('cleaning-order-update', $order->order_id) }}" method="POST" id="form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    <input type="hidden" name="service_charge" id="service_charge" value="0">
                    <input type="hidden" name="sub_total" id="sub_total" value="0">
                    <input type="hidden" name="vat_charge" id="vat_charge" value="0">
                    <input type="hidden" name="order_total" id="order_total" value="0">
                    <input type="hidden" name="cleaner_per_hour_charge" id="cleaner_per_hour_charge" value="0">
                    <input type="hidden" name="time_charge_hidden" id="time_charge_hidden" value="0">
                    <input type="hidden" name="date_charge_hidden" id="date_charge_hidden" value="0">
                    <input type="hidden" name="order_id" id="order_id" value="{{  $order->order_id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Customer Name</label>
                                        <select id="customer_id" name="customer_id" class="form-control form-select">
                                            <option value="">Select Customer Name</option>
                                            @foreach ($customer_data as $item)
                                               <option value="{{ $item->id }}" {{ $item->id == $order->user_id ? 'selected' : '' }}>
                                                {{ $item->id }} - {{ $item->name }} - {{ $item->email }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="customer_name_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Subservice</label>
                                        <select id="subservice_id" name="subservice_id" class="form-control form-select">
                                            <option value="">Select Subservice</option>
                                            @foreach ($subservice_data as $item)
                                            <option value="{{ $item->id }}" {{ isset($order->items[0]) && $item->id == $order->items[0]->subservice_id ? 'selected' : '' }}>
                                                {{ $item->subservicename }}
                                            </option>
                                        @endforeach

                                        </select>
                                        <p class="form-error-text" id="subservice_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                            
                            <div class="home_cleaning_form" style="{{ isset($order->items[0]) && $order->items[0]->subservice_id == 28 ? '' : 'display: none;' }}">
                                <h4>Service Details : </h4>
                                <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>How many hours your cleaner will stay ?</label>
                                        <select id="hour_value" name="hour_value" class="form-control form-select">
                                            <option value="">Select Cleaning Hour Value</option>
                                            @foreach ($cleanin_subserviceprice as $key => $data)
                                            <option value="{{ $data->hour_value }}" {{ isset($order->items[0]) && $data->hour_value == $order->items[0]->how_many_hours_should_they_stay ? 'selected' : '' }}>
                                                {{ $data->hour_value }}
                                            </option>

                                        @endforeach
                                        

                                        </select>
                                        <p class="form-error-text" id="hour_value_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Cleaner Charge Per Hour</label>
                                       <input type="number" name="cleaner_charge" id="cleaner_charge" class="form-control"
                                        placeholder="Enter Cleaner Charge Per Hour"
                                        value="{{ $order->cleaner_per_hour_charge }}">

                                        <p class="form-error-text" id="cleaner_charge_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>How many cleaners do you require ?</label>
                                        <select id="how_many_cleaner" name="how_many_cleaner" class="form-control form-select">
                                            <option value="">Select Cleaners</option>
                                            <option value="1" {{ isset($order->items[0]) && $order->items[0]->how_many_cleaners_do_you_need == 1 ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ isset($order->items[0]) && $order->items[0]->how_many_cleaners_do_you_need == 2 ? 'selected' : '' }}>2</option>
                                            <option value="3" {{ isset($order->items[0]) && $order->items[0]->how_many_cleaners_do_you_need == 3 ? 'selected' : '' }}>3</option>
                                            <option value="4" {{ isset($order->items[0]) && $order->items[0]->how_many_cleaners_do_you_need == 4 ? 'selected' : '' }}>4</option>
                                            <option value="5" {{ isset($order->items[0]) && $order->items[0]->how_many_cleaners_do_you_need == 5 ? 'selected' : '' }}>5</option>
                                            <option value="6" {{ isset($order->items[0]) && $order->items[0]->how_many_cleaners_do_you_need == 6 ? 'selected' : '' }}>6</option>

                                        </select>
                                        <p class="form-error-text" id="how_many_cleaner_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>How often do you need cleaning ?</label>
                                        <select id="how_often_you_need" name="how_often_you_need" class="form-control form-select">
                                            <option value="">Select how often do you need</option>
                                            <option value="Once" {{ isset($order->items[0]) && $order->items[0]->how_often_do_you_need_cleaning == 'Once' ? 'selected' : '' }} > Once</option>
                                            <option value="Weekly" {{ isset($order->items[0]) && $order->items[0]->how_often_do_you_need_cleaning == 'Weekly' ? 'selected' : '' }} > Weekly</option>
                                            <option value="Multiple times a week" {{ isset($order->items[0]) && $order->items[0]->how_often_do_you_need_cleaning == 'Multiple times a week' ? 'selected' : '' }} > Multiple Times a Week</option>
                                        </select>
                                        <p class="form-error-text" id="how_often_you_need_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                
                                <div class="col-md-4" id="which_day_you_want_div" style="{{ isset($order->items[0]) && $order->items[0]->how_often_do_you_need_cleaning == 'Multiple times a week' ? '' : 'display: none;' }}">
                                    <div class="form-group">
                                        <label>Which days of the week do you want the service ?</label>
                                    @php
                                        $selectedDays = isset($order->items[0]) && $order->items[0]->which_day_of_the_week_do_you_want_the_service
                                            ? explode(',', $order->items[0]->which_day_of_the_week_do_you_want_the_service)
                                            : [];
                                    @endphp

                                    <select id="which_day_you_want" name="which_day_you_want[]" class="form-control form-select" multiple="multiple">
                                        <option value="">Select which days you want service</option>
                                        <option value="Monday" {{ in_array('Monday', $selectedDays) ? 'selected' : '' }}>Monday</option>
                                        <option value="Tuesday" {{ in_array('Tuesday', $selectedDays) ? 'selected' : '' }}>Tuesday</option>
                                        <option value="Wednesday" {{ in_array('Wednesday', $selectedDays) ? 'selected' : '' }}>Wednesday</option>
                                        <option value="Thursday" {{ in_array('Thursday', $selectedDays) ? 'selected' : '' }}>Thursday</option>
                                        <option value="Friday" {{ in_array('Friday', $selectedDays) ? 'selected' : '' }}>Friday</option>
                                        <option value="Saturday" {{ in_array('Saturday', $selectedDays) ? 'selected' : '' }}>Saturday</option>
                                        <option value="Sunday" {{ in_array('Sunday', $selectedDays) ? 'selected' : '' }}>Sunday</option>
                                    </select>

                                        <p class="form-error-text" id="which_day_you_want_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Need cleaning materials ?</label>
                                        <select id="need_cleaning_material" name="need_cleaning_material" class="form-control form-select">
                                            <option value="">Select Cleaning Materials</option>
                                            <option value="Yes" {{ isset($order->items[0]) && $order->items[0]->do_you_need_cleaning_material == 'Yes' ? 'selected' : '' }} > Yes</option>
                                            <option value="No" {{ isset($order->items[0]) && $order->items[0]->do_you_need_cleaning_material == 'No' ? 'selected' : '' }}> No</option>
                                        </select>
                                        <p class="form-error-text" id="need_cleaning_material_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4" id="cleaning_material_charge_div" style="{{ isset($order->items[0]) && $order->items[0]->do_you_need_cleaning_material == 'Yes' ? '' : 'display: none;' }}">
                                    <div class="form-group">
                                        <label>Cleaning Materials Charge Per Hour</label>
                                        <input type="text" name="cleaning_material_charge" id="cleaning_material_charge" class="form-control"
                                            placeholder="Enter Cleaning Material Charge"  value="{{ $order->material_charge_per_hour }}">
                                        <p class="form-error-text"  id="cleaning_material_charge_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="special_instruction" style="margin:15px 0 5px 0px; width:100%;">
                                            Do you have any special instructions</label>
                                        <textarea id="special_instruction" name="special_instruction" class="form-control" placeholder="Enter Special Instruction">{{ isset($order->items[0]) && $order->items[0]->any_special_instruction }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="add_to_cart" style="display: none;">
                            <h4>Service Details:</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Your Package Category</label>
                                        <div id="package_category_change">
                                            <select id="package_category" name="package_category[]" class="form-control form-select" onchange="get_package();" multiple="multiple">
                                                <option value="">Select Package Category</option>
                                            </select>
                                        </div>
                                        <p class="form-error-text" id="package_category_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Your Package</label>
                                        <div id="package_change">
                                            <select id="package" name="package[]" class="form-control form-select" multiple="multiple" onchange="showPackageFields()">
                                         
                                            </select>
                                        </div>
                                        <p class="form-error-text" id="package_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="package_fields"></div>
                            
                        </div>

                       <h4>Scheduling Your Service : </h4>
                       
                        <div class="col-md-4" id="cleaner_div"  style="{{ isset($order->items[0]) && $order->items[0]->how_many_cleaners_do_you_need == '1' ? '' : 'display: none;' }}">
                            <div class="form-group">
                                <label>Select your Preferred Crew</label>
                                <div id="cleaner_change">
                                <select id="cleaner" name="cleaner" class="form-control form-select" onchange="cleaner_on_change();">
                                    <option value="">Select Preferred Crew</option>
                                </select>
                                </div>
                                <p class="form-error-text" id="cleaner_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                @php
                    // Combine the parts to form a valid date string
                    $raw_day = $order->items[0]->bookingdate ?? '';
                    $raw_month = $order->items[0]->month ?? '';
                    $raw_year = $order->items[0]->bookingyear ?? '';

                    // Convert "June" to "06", etc., using strtotime
                    $combined_date = '';

                    if ($raw_day && $raw_month && $raw_year) {
                        $parsed_date = date('Y-m-d', strtotime("$raw_day $raw_month $raw_year"));
                        $combined_date = $parsed_date;
                    }
                @endphp

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>When would you like your service ?</label>
                                <input type="date" name="service_date" id="service_date" class="form-control" value="{{ $combined_date }}"
                                    placeholder="Enter Service Date">
                                <p class="form-error-text" id="service_date_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="time_slot_change">
                                <label>What time would you like us to start ?</label>
                                <div id="time_slot_change"> 
                               <select id="time_slot" name="time_slot" class="form-control form-select" >
                                    <option value="">Select Time Slot</option>
                                    
                                </select>
                                </div>
                            </div>
                                <p class="form-error-text" id="time_slot_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date Charge</label>
                                <input type="text" name="date_charge" id="date_charge" class="form-control" value="{{ $order->date_charge }}"
                                    placeholder="Enter Date Charge" >
                                <p class="form-error-text" id="date_charge_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Timing Charge</label>
                                <input type="text" name="timing_charge" id="timing_charge" class="form-control"  value="{{ $order->time_charge }}"
                                    placeholder="Enter Timing Charge" >
                                <p class="form-error-text" id="timing_charge_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Service Fee</label>
                                <input type="text" name="service_fee" id="service_fee" class="form-control" value="{{ $order->service_fee }}"
                                    placeholder="Enter Service Fee" value="0">
                                <p class="form-error-text" id="service_fee_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cash On Delivery Charge</label>
                                <input type="text" name="cod_charge" id="cod_charge" class="form-control" value="{{ $order->cod_charge }}"
                                    placeholder="Enter Cash On Delivery Charge" value="0">
                                <p class="form-error-text" id="cod_charge_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Vat Charge Include</label>
                                <select id="include_vat" name="include_vat" class="form-control form-select">
                                    <option value="">Select Vat Charge Include</option>
                                   <option value="yes" {{ ($order->vatcharge != "" && $order->vatcharge != 0) ? 'selected' : '' }}>Yes</option>
                                    <option value="no" {{ ($order->vatcharge == "" || $order->vatcharge == 0) ? 'selected' : '' }}>No</option>

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
                                    <option value="home" {{ isset($order->items[0]) && $order->items[0]->address_type == 'home' ? 'selected' : '' }}>Home</option>
                                    <option value="office" {{ isset($order->items[0]) && $order->items[0]->address_type == 'office' ? 'selected' : '' }}>Office</option>
                                    <option value="other" {{ isset($order->items[0]) && $order->items[0]->address_type == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <p class="form-error-text" id="address_type_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Select Your City</label>
                                <select id="city" name="city" class="form-control form-select">
                                    <option value="">Select Your City</option>
                                    <option value="Dubai" {{ isset($order->items[0]) && $order->items[0]->city == 'Dubai' ? 'selected' : '' }}>Dubai</option>
                                    <option value="Abu Dhabhi" {{ isset($order->items[0]) && $order->items[0]->city == 'Abu Dhabhi' ? 'selected' : '' }}>Abu Dhabhi</option>
                                    <option value="Sharjah" {{ isset($order->items[0]) && $order->items[0]->city == 'Sharjah' ? 'selected' : '' }}>Sharjah</option>
                                </select>
                                <p class="form-error-text" id="city_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Your Area</label>
                                <input type="text" name="area" id="area" class="form-control"
                                    placeholder="Enter Your Area" value="{{ isset($order->items[0]) ? $order->items[0]->area : '' }}">
                                <p class="form-error-text" id="area_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Your Building Name</label>
                                <input type="text" name="building_name" id="building_name" class="form-control" value="{{ isset($order->items[0]) ? $order->items[0]->building_street_no : '' }}"
                                    placeholder="Enter Your Building name and/or street">
                                <p class="form-error-text" id="building_name_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Your Apartment or Villa Number</label>
                                <input type="text" name="apartment_villa_num" id="apartment_villa_num" class="form-control" value={{  isset($order->items[0]) ? $order->items[0]->apartment_villa_no : '' }}
                                    placeholder="Enter Your Apartment number & floor or Villa Number">
                                <p class="form-error-text" id="apartment_villa_num_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>
                  </div>
                            <div class="text-end mt-4">
                                <a href="{{ route('cleaning_package_order') }}" class="btn btn-primary text-light">Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" onclick="validation();" id="submit_button"
                                    class="btn btn-primary">Update</button>
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
            var subservice_id = $("#subservice_id").val();
            if(subservice_id == 28){

            var hour_value = jQuery("#hour_value").val();
               if (hour_value == '') {
                   jQuery('#hour_value_error').html("Please Select Cleaning Hour Value");
                   jQuery('#hour_value_error').show().delay(0).fadeIn('show');
                   jQuery('#hour_value_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#hour_value').offset().top - 150
                   }, 1000);
                   return false;
               }

            var cleaner_charge = jQuery("#cleaner_charge").val();
               if (cleaner_charge == '') {
                   jQuery('#cleaner_charge_error').html("Please Enter Cleaner Charge Per Hour");
                   jQuery('#cleaner_charge_error').show().delay(0).fadeIn('show');
                   jQuery('#cleaner_charge_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#cleaner_charge').offset().top - 150
                   }, 1000);
                   return false;
               }

            var how_many_cleaner = jQuery("#how_many_cleaner").val();
               if (how_many_cleaner == '') {
                   jQuery('#how_many_cleaner_error').html("Please Select How many cleaners do you require");
                   jQuery('#how_many_cleaner_error').show().delay(0).fadeIn('show');
                   jQuery('#how_many_cleaner_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#how_many_cleaner').offset().top - 150
                   }, 1000);
                   return false;
               }

            var how_often_you_need = jQuery("#how_often_you_need").val();
               if (how_often_you_need == '') {
                   jQuery('#how_often_you_need_error').html("Please Select How Often Do You Need Cleaning");
                   jQuery('#how_often_you_need_error').show().delay(0).fadeIn('show');
                   jQuery('#how_often_you_need_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#how_often_you_need').offset().top - 150
                   }, 1000);
                   return false;
               }
               if(how_often_you_need == 'Multiple times a week'){
                   var which_day_you_want = jQuery("#which_day_you_want").val();
                   if (which_day_you_want == '') {
                       jQuery('#which_day_you_want_error').html("Please Select Which days of the week do you want the service");
                       jQuery('#which_day_you_want_error').show().delay(0).fadeIn('show');
                       jQuery('#which_day_you_want_error').show().delay(2000).fadeOut('show');
                       $('html, body').animate({
                           scrollTop: $('#which_day_you_want').offset().top - 150
                       }, 1000);
                       return false;
                   }
               }

               var need_cleaning_material = jQuery("#need_cleaning_material").val();
               if (need_cleaning_material == '') {
                   jQuery('#need_cleaning_material_error').html("Please Select Need Cleaning Materials");
                   jQuery('#need_cleaning_material_error').show().delay(0).fadeIn('show');
                   jQuery('#need_cleaning_material_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#need_cleaning_material').offset().top - 150
                   }, 1000);
                   return false;
               }

               if(need_cleaning_material === 'Yes'){
               var cleaning_material_charge = jQuery("#cleaning_material_charge").val();
               if (cleaning_material_charge == '') {
                   jQuery('#cleaning_material_charge_error').html("Please Enter Cleaning Materials Charge");
                   jQuery('#cleaning_material_charge_error').show().delay(0).fadeIn('show');
                   jQuery('#cleaning_material_charge_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#cleaning_material_charge').offset().top - 150
                   }, 1000);
                   return false;
               }
            }
            }else{
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

               var package_quantity = jQuery("#package_quantity").val();
               if (package_quantity == '') {
                   jQuery('#package_quantity_error').html("Please Enter Package Quantity");
                   jQuery('#package_quantity_error').show().delay(0).fadeIn('show');
                   jQuery('#package_quantity_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#package_quantity').offset().top - 150
                   }, 1000);
                   return false;
               }

               var package_price = jQuery("#package_price").val();
               if (package_price == '') {
                   jQuery('#package_price_error').html("Please Enter Package Price");
                   jQuery('#package_price_error').show().delay(0).fadeIn('show');
                   jQuery('#package_price_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#package_price').offset().top - 150
                   }, 1000);
                   return false;
               }

            }
          
            if (how_many_cleaner == 1 ) {
            var cleaner = jQuery("#cleaner").val();
               if (cleaner == '') {
                   jQuery('#cleaner_error').html("Please Select Cleaner");
                   jQuery('#cleaner_error').show().delay(0).fadeIn('show');
                   jQuery('#cleaner_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#cleaner').offset().top - 150
                   }, 1000);
                   return false;
               }
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
            

            if(subservice_id == 28){
                 // for home cleaning Calculation
                home_cleaning_calculation();
            }else{
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
        futureDate.setDate(today.getDate() + 14);

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
    // Initialize select2 once for which_day_you_want with placeholder
    $('#which_day_you_want').select2({
        placeholder: 'Select which days you want service',
        allowClear: true,
        width: '100%'
    });

    // Show/hide which_day_you_want_div on how_often_you_need change
    $('#how_often_you_need').change(function() {
        const how_often_you_need = $(this).val();
        if (how_often_you_need === 'Multiple times a week') {
            $('#which_day_you_want_div').show();
        } else {
            $('#which_day_you_want_div').hide();
            $('#which_day_you_want').val(null).trigger('change');  // clear selection
        }
        }).trigger('change'); // trigger on page load to set initial state

        // Initialize other select2 fields once
        $('#customer_id').select2({
            placeholder: 'Select Customer Name',
            allowClear: true,
            width: '100%'
        });
        $('#package').select2({
            placeholder: 'Select Packages',
            width: '100%'
        });
        $('#package_category').select2({
            placeholder: 'Select Package Category',
            width: '100%'
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


 $(document).ready(function () {
    var isPageLoad = true;
    var selectedCleanerId = "{{ isset($order->items[0]) ? $order->items[0]->cleaner_id : '' }}";
    var how_many_cleaner_value = {{ isset($order->items[0]) ? $order->items[0]->how_many_cleaners_do_you_need : 1 }};

    function updateCleanerVisibility() {
        var subservice_id = $('#subservice_id').val();
        var currentCleanerCount = $('#how_many_cleaner').val();

        if (subservice_id == 28) {
            $('.home_cleaning_form').show();
            $('.add_to_cart').hide();
            $('.add_to_cart').find('input, select, textarea').val('');

            if (currentCleanerCount == 1) {
                $('#cleaner_div').show();
            } else {
                $('#cleaner_div').hide();
                $('#cleaner').val('');
                // currentCleanerId = '';
            }
        } else {
            $('.home_cleaning_form').hide();
            $('#cleaner_div').hide();
            $('.add_to_cart').show();
            $('.home_cleaning_form').find('input, select, textarea').val('');
        }
    }

    $('#subservice_id').change(function () {
        var subservice_id = $(this).val();

        if (!isPageLoad) {
            $('#time_slot').val('');
            $('#service_date').val('');
        }

        updateCleanerVisibility(); // 🔁 Call this here to show/hide correctly

        // Fetch and preselect cleaner
        $.ajax({
            url: '{{ url('get-subservice-cleaners') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                subservice_id: subservice_id,
                selectedCleanerId: selectedCleanerId
            },
            success: function (msg) {
                $('#cleaner_change').html(msg);

            }
        });

        // Fetch package category
        $.ajax({
            url: '{{ url('get-package-category') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                subservice_id: subservice_id
            },
            success: function (msg) {
                $('#package_category_change').html(msg);
                $('#package_category').select2({
                    placeholder: 'Select Package Category'
                });
            }
        });

        isPageLoad = false;
    });

    // On cleaner count change
    $('#how_many_cleaner').change(function () {
        updateCleanerVisibility();
    });

    // On page load
    updateCleanerVisibility();
    $('#subservice_id').trigger('change');
});

// On hour value change the time slot and service date will be empty
        $('#hour_value').change(function(){
            $('#time_slot').val('');
            $('#service_date').val('');
        });
    

//On date change the Time slot will change
var allowTimeSlotChange = false;
let selectedTimeSlot = "{{ isset($order->items[0]) ? $order->items[0]->time_slot : '' }}";
let originalServiceDate = "{{ $combined_date }}"; 

let currentCleanerId = "{{ isset($order->items[0]) ? $order->items[0]->cleaner_id : '' }}";
// alert(originalServiceDate);
// alert(selectedTimeSlot);

// Change listener for time slot
$(document).on('change', '#time_slot', function () {
    if (allowTimeSlotChange) {
        time_slot_on_change();
    }
});




$('#service_date').change(function () {
    const date = $('#service_date').val(); // User-selected date (format: 'YYYY-MM-DD')
    // const cleaner = $('#cleaner').val();
    const cleaner = currentCleanerId;
    const subservice_id = $('#subservice_id').val();

    const url = '{{ url('get-cleaners-time-slot') }}';

    // ✅ Reset selectedTimeSlot if selected date ≠ original
    let useOriginalSlot = false;
    if (originalServiceDate && date === originalServiceDate) {
        useOriginalSlot = true;
    } else {
        selectedTimeSlot = '';
    }

    $.ajax({
        url: url,
        type: 'post',
        data: {
            "_token": "{{ csrf_token() }}",
            "date": date,
            "cleaner": cleaner,
            "subservice_id": subservice_id,
            "selectedTimeSlot": selectedTimeSlot // Pass the selected time slot
            
        },
        success: function (msg) {
            document.getElementById('time_slot_change').innerHTML = msg;
            // alert(msg);

            setTimeout(function () {
            const $timeSlot = $('#time_slot');
            allowTimeSlotChange = false;

            if (!selectedTimeSlot) {
                selectedTimeSlot = $timeSlot.val(); 
            }

            if (useOriginalSlot && selectedTimeSlot && $timeSlot.find('option[value="' + selectedTimeSlot + '"]').length) {
                $timeSlot.val(selectedTimeSlot);
            } else {
                $timeSlot.val('');
            }

            allowTimeSlotChange = true;
        }, 50);

        }
    });
});

// On first load, trigger change
$(document).ready(function () {
    $('#service_date').trigger('change');
   
});
    
//On cleaner change the time slot and service date will be empty
function  cleaner_on_change(){
    $('#service_date').val('');
    $('#time_slot').val('');

    currentCleanerId = $('#cleaner').val();
$('#service_date').trigger('change');
}
        

function get_package(){

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


    function time_slot_on_change(){

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
                dataType: "json",  // Ensure response is treated as JSON
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
function home_cleaning_calculation() {

    let hour_value = parseFloat($('#hour_value').val()) || 0;
    let cleaner_charge = parseFloat($('#cleaner_charge').val()) || 0;
    let how_many_cleaner = parseInt($('#how_many_cleaner').val()) || 0;
    let cleaning_material_charge = parseFloat($('#cleaning_material_charge').val()) || 0;
    let cod_charge = parseFloat($('#cod_charge').val()) || 0;
    let timing_charge = parseFloat($('#timing_charge').val()) || 0;
    let date_charge = parseFloat($('#date_charge').val()) || 0;
    let service_fee = parseFloat($('#service_fee').val()) || 0;
    let include_vat = $('#include_vat').val();

    // Calculate the service charge

   
    let service_charge = hour_value * cleaner_charge * how_many_cleaner;
    let additional_charge = hour_value * how_many_cleaner * cleaning_material_charge;


    // alert(how_many_cleaner);
    // alert(cleaner_charge);
    // alert(hour_value);
    // alert(service_charge);
    
    // Calculate subtotal
    let sub_total = service_charge + additional_charge + cod_charge + service_fee + timing_charge + date_charge;

    // alert(sub_total);
    // Initialize vat_charge
    let vat_charge = 0;

    if (include_vat === 'yes') {
        vat_charge = sub_total * 5 / 100;
    }

    // Calculate order total
    let order_total = sub_total + vat_charge;
    // alert(vat_charge);
    // alert(order_total);
    // Update the form fields
    $('#service_charge').val(service_charge.toFixed(2));
    $('#date_charge_hidden').val(date_charge.toFixed(2));
    $('#time_charge_hidden').val(timing_charge.toFixed(2));
    $('#cleaner_per_hour_charge').val(cleaner_charge.toFixed(2));
    $('#sub_total').val(sub_total.toFixed(2));
    $('#vat_charge').val(vat_charge.toFixed(2));
    $('#order_total').val(order_total.toFixed(2));
}

function package_calculation(){

    let packageCategory = $('#package_category').val();
    let selectedPackages = $('#package').val();
    
    let service_charge = 0;

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



function showPackageFields() {
    const packageSelect = document.getElementById('package');
    const packageFields = document.getElementById('package_fields');
    const selectedPackages = Array.from(packageSelect.selectedOptions).map(option => option.value);

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
                        <input type="number" name="${packageId}_quantity" class="form-control" min="1" placeholder="Enter Quantity">
                    </div>
                    <div class="col-6">
                        <label>${packageName} - Price</label>
                        <input type="number" name="${packageId}_price" class="form-control" min="0" step="0.01" placeholder="Enter Price">
                    </div>
                </div>
            `;

            packageFields.appendChild(packageDiv);
        }
    });
}

// Add event listener to the select element
const packageSelect = document.getElementById('package');
packageSelect.addEventListener('change', showPackageFields);


</script>
@stop
