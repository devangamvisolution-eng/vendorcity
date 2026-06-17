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
                    <h3 class="page-title">Package Order - Painting Service</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('painting-service-order') }}">Package Order - Painting Service</a></li>
                        <li class="breadcrumb-item active">Add Package Order - Painting Service</li>
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

                    <form action="{{ route('painting-service-order-store') }}" method="POST" id="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="sub_total" id="sub_total" value="0">
                    <input type="hidden" name="vat_charge" id="vat_charge" value="0">
                    <input type="hidden" name="order_total" id="order_total" value="0">
                    <input type="hidden" name="additionalCharge" id="additionalCharge" value="0">

                    <input type="hidden" name="selected_type_home" id="selected_type_home" value="">
                    <input type="hidden" name="selected_size_home" id="selected_size_home" value="">
                     <input type="hidden" name="selected_you_want_color_name" id="selected_you_want_color_name" value="">
                    <input type="hidden" name="selected_your_walls_now_name" id="selected_your_walls_now_name" value="">
                     <input type="hidden" name="selected_home_furnished" id="selected_home_furnished" value="">
                     <input type="hidden" name="no_of_ceilings" id="no_of_ceilings" value="">
                    {{-- <input type="hidden" name="size_of_home_price" id="size_of_home_price" value=""> --}}
                    {{-- <input type="hidden" name="color_you_want_painted_price" id="color_you_want_painted_price" value=""> --}}
                    
                    {{-- <input type="hidden" name="color_your_walls_now_price" id="color_your_walls_now_price" value=""> --}}
                  
                    {{-- <input type="hidden" name="selected_home_furnished_price" id="selected_home_furnished_price" value=""> --}}
                   
                    {{-- <input type="hidden" name="selected_ceiling_price" id="selected_ceiling_price" value=""> --}}
                    
                    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Customer Name</label>
                                        <select id="customer_id" name="customer_id" class="form-control form-select">
                                            <option value="">Select Customer Name</option>
                                            @foreach ($customer_data as $item)
                                                <option value="{{ $item->id }}">{{ $item->id }}-{{ $item->name }}-{{ $item->email }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="customer_name_error" style="color: red; margin-top: 10px;"></p>
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
                                            <option value="ONLINE">ONLINE</option>
                                            <option value="COD">COD</option>
                                        </select>
                                        <p class="form-error-text" id="payment_method_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Please Select Subservice</label>
                                    <select id="subservice_id" name="subservice_id" class="form-control form-select">
                                        <option value="">Select Subservice</option>
                                        @foreach ($subservice_data as $data)
                                            @if($data->id == 47)
                                            <option value="{{ $data->id }}">{{ $data->subservicename }}</option>    
                                            @endif
                                        @endforeach
                                        
                                    </select>
                                    <p class="form-error-text" id="subservice_id_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Please select the type of painting</label>
                                    <select id="type_of_painting" name="type_of_painting" class="form-control form-select">
                                        <option value="">Select Type Of Painting</option>
                                        <option value="Move in / Move Out Painting">Move in / Move Out Painting</option>
                                    </select>
                                    <p class="form-error-text" id="type_of_painting_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                            </div>
                           
                            <h4>Service Details:</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>What type of home do you live in?</label>
                                        <select id="type_of_home" name="type_of_home" class="form-control form-select" onchange="type_of_homeFun();">
                                            <option value="">Select type of Home</option>
                                            <option value="2">Apartment</option>
                                            <option value="3">Villa</option>
                                        </select>
                                        <p class="form-error-text" id="type_of_home_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <!-- Apartment Sizes -->
                                <div class="col-md-4" id="apartment-size-group" style="display: none;">
                                    <div class="form-group">
                                        <label>What is the size of your home?</label>
                                        <select name="size_of_home_1" class="form-control form-select" onchange="sizeOfHome();">
                                            <option>Select Apartment Size</option>
                                            @foreach ($Apartment_painting_price_data as $data)
                                                <option value="{{ $data->id }}">{{ $data->size_of_home }}</option>                                            
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="apartment_size_home_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <!-- Villa Sizes -->
                                <div class="col-md-4" id="villa-size-group" style="display: none;">
                                    <div class="form-group" >
                                        <label>What is the size of your home?</label>
                                        <select name="size_of_home_2" class="form-control form-select" id="size_of_home_2" onchange="sizeOfHome();">
                                            <option>Select Villa Size</option>
                                            @foreach ($villaPainting_price_data as $data)
                                                <option value="{{ $data->id }}">{{ $data->size_of_home }}</option>                                            
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="villa_size_home_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4" id="price-div" style="display: none;">
                                    <div class="form-group" >
                                        <label>size of your home Price</label>
                                        <input type="text" name="size_of_home_price" id="size_of_home_price" class="form-control" value="">
                                        <p class="form-error-text" id="size_of_home_price_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                            </div> 

                        <div class="row">
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label>What color do you want your walls painted ?</label>
                                        <select name="color_do_you_want_walls_painted" id="color_do_you_want_walls_painted" class="form-control form-select" onchange="newColor(1);">
                                            <option>Select Color do you want your walls painted</option>
                                            <option value="white">White</option>
                                            <option value="off-white">Off-White</option>
                                        </select>
                                        <p class="form-error-text" id="color_do_you_want_walls_painted_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label>color do you want your walls painted Price</label>
                                        <input type="text" name="color_you_want_painted_price" id="color_you_want_painted_price" class="form-control" value="">
                                        <p class="form-error-text" id="color_do_you_want_walls_painted_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label>What color are your walls now ?</label>
                                        <select name="what_color_your_walls_now" id="what_color_your_walls_now" class="form-control form-select" onchange="newColor(2);">
                                            <option>Select Color are your walls now</option>
                                            <option value="white">White</option>
                                            <option value="off-white">Off-White</option>
                                            <option value="color">Color</option>
                                            <option value="mixed">Mixed</option>
                                        </select>
                                        <p class="form-error-text" id="what_color_your_walls_now_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Color are your walls now Price</label>
                                        <input type="text" name="color_your_walls_now_price" id="color_your_walls_now_price" class="form-control" value="">
                                        <p class="form-error-text" id="color_do_you_want_walls_painted_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Is your home furnished ?</label>
                                    <select name="isYourHomeFurnshed" id="isYourHomeFurnshed" class="form-control form-select" onchange="homeFurnished();">
                                            <option>Select Yes Or No</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        <p class="form-error-text" id="isYourHomeFurnshed_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                 <div class="col-md-4" style="display: none;" id="home_furnished_div">
                                    <div class="form-group">
                                        <label>Home furnished Charge?</label>
                                      <input type="text" name="selected_home_furnished_price" id="selected_home_furnished_price" class="form-control" value="">
                                        <p class="form-error-text" id="selected_home_furnished_price_error" style="color: red; margin-top: 10px;"></p>
                                        <p class="form-error-text" id="selected_home_furnished_price_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Do you need ceilings painted ?</label>
                                        <select name="do_you_need_ceiling_painted" id="do_you_need_ceiling_painted" class="form-control form-select" onchange="isCeilingPainted();">
                                            <option>Select Yes Or No</option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                        <p class="form-error-text" id="do_you_need_ceiling_painted_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>



                                 <div class="col-md-4" id="ceiling_painted_div" style="display: none;">
                                    <div class="form-group">
                                        <label>Do you need ceilings painted ?</label>
                                        <select name="per_ceiling_costs" id="per_ceiling_costs" class="form-control form-select" onchange="isCeilingPainted();">
                                            <option>Select how many Ceiling</option>
                                           <option value="1">1 </option>
                                            <option value="2">2 </option>
                                            <option value="3">3 </option>
                                            <option value="4">4 </option>
                                            <option value="5">5 </option>
                                        </select>
                                        <p class="form-error-text" id="per_ceiling_costs_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                 <div class="col-md-4" id="ceiling_price_div" style="display: none;">
                                    <div class="form-group">
                                        <label>ceilings painted Price</label>
                                        <input type="text" name="selected_ceiling_price" id="selected_ceiling_price" class="form-control" value="">
                                        <p class="form-error-text" id="selected_ceiling_price_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>


                            </div>

                            
                            
                            

                       <h4>Scheduling Your Service : </h4>
                       
                       <div class="col-md-4" id="cleaner_div" style="display: none;">
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
                                    placeholder="Enter Date Charge" value="0">
                                <p class="form-error-text" id="date_charge_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Timing Charge</label>
                                <input type="text" name="timing_charge" id="timing_charge" class="form-control"
                                    placeholder="Enter Timing Charge" value="0">
                                <p class="form-error-text" id="timing_charge_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Service Fee</label>
                                <input type="text" name="service_fee" id="service_fee" class="form-control"
                                    placeholder="Enter Service Fee" value="0">
                                <p class="form-error-text" id="service_fee_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cash On Delivery Charge</label>
                                <input type="text" name="cod_charge" id="cod_charge" class="form-control"
                                    placeholder="Enter Cash On Delivery Charge" value="0">
                                <p class="form-error-text" id="cod_charge_error" style="color: red; margin-top: 10px;"></p>
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
                                <input type="text" name="area" id="area" class="form-control"
                                    placeholder="Enter Your Area">
                                <p class="form-error-text" id="area_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Your Building Name</label>
                                <input type="text" name="building_name" id="building_name" class="form-control"
                                    placeholder="Enter Your Building name and/or street">
                                <p class="form-error-text" id="building_name_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Your Apartment or Villa Number</label>
                                <input type="text" name="apartment_villa_num" id="apartment_villa_num" class="form-control"
                                    placeholder="Enter Your Apartment number & floor or Villa Number">
                                <p class="form-error-text" id="apartment_villa_num_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>
                  </div>
                            <div class="text-end mt-4">
                                <a href="{{ route('salon-spa-order') }}" class="btn btn-primary text-light">Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
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
                   jQuery('#subservice_id_error').html("Please Select Subservice");
                   jQuery('#subservice_id_error').show().delay(0).fadeIn('show');
                   jQuery('#subservice_id_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#subservice_id').offset().top - 150
                   }, 1000);
                   return false;
               }

            var type_of_painting = jQuery("#type_of_painting").val();
               if (type_of_painting == '') {
                   jQuery('#type_of_painting_error').html("Please Select Type Of Painting");
                   jQuery('#type_of_painting_error').show().delay(0).fadeIn('show');
                   jQuery('#type_of_painting_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#type_of_painting').offset().top - 150
                   }, 1000);
                   return false;
               }

             var type_of_home = jQuery("#type_of_home").val();
               if (type_of_home == '') {
                   jQuery('#type_of_home_error').html("Please Select Type Of Home");    
                   jQuery('#type_of_home_error').show().delay(0).fadeIn('show');
                   jQuery('#type_of_home_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#type_of_home').offset().top - 150
                   }, 1000);
                   return false;
               }



               if(type_of_home == '2'){

                var size_of_home_1 = jQuery("#size_of_home_1").val();
               if (size_of_home_1 == '') {
                   jQuery('#apartment_size_home_error').html("Please Select Apartment Size");    
                   jQuery('#apartment_size_home_error').show().delay(0).fadeIn('show');
                   jQuery('#apartment_size_home_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#size_of_home_1').offset().top - 150
                   }, 1000);
                   return false;
               }
               }else if(type_of_home == '3'){

                var size_of_home_2 = jQuery("#size_of_home_2").val();
                if (size_of_home_2 == '') {
                   jQuery('#villa_size_home_error').html("Please Select Villa Size");    
                   jQuery('#villa_size_home_error').show().delay(0).fadeIn('show');
                   jQuery('#villa_size_home_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#size_of_home_2').offset().top - 150
                   }, 1000);
                   return false;
               }
               }

               var color_do_you_want_walls_painted = jQuery("#color_do_you_want_walls_painted").val();
               if (color_do_you_want_walls_painted == '') {
                   jQuery('#color_do_you_want_walls_painted_error').html("Please Select Color do you want your walls painted");
                   jQuery('#color_do_you_want_walls_painted_error').show().delay(0).fadeIn('show');
                   jQuery('#color_do_you_want_walls_painted_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#color_do_you_want_walls_painted').offset().top - 150
                   }, 1000);
                   return false;
               }

               var what_color_your_walls_now = jQuery("#what_color_your_walls_now").val();
               if (what_color_your_walls_now == '') {
                   jQuery('#what_color_your_walls_now_error').html("Please Select Color Your Walls Now");
                   jQuery('#what_color_your_walls_now_error').show().delay(0).fadeIn('show');
                   jQuery('#what_color_your_walls_now_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#what_color_your_walls_now').offset().top - 150
                   }, 1000);
                   return false;
               }

               var isYourHomeFurnshed = jQuery("#isYourHomeFurnshed").val();
               if (isYourHomeFurnshed == '') {
                   jQuery('#isYourHomeFurnshed_error').html("Please Select Yes or No");
                   jQuery('#isYourHomeFurnshed_error').show().delay(0).fadeIn('show');
                   jQuery('#isYourHomeFurnshed_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#isYourHomeFurnshed').offset().top - 150
                   }, 1000);
                   return false;
               }

               var do_you_need_ceiling_painted = jQuery("#do_you_need_ceiling_painted").val();
               if (do_you_need_ceiling_painted == '') {
                   jQuery('#do_you_need_ceiling_painted_error').html("Please Select Yes or No");
                   jQuery('#do_you_need_ceiling_painted_error').show().delay(0).fadeIn('show');
                   jQuery('#do_you_need_ceiling_painted_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#do_you_need_ceiling_painted').offset().top - 150
                   }, 1000);
                   return false;
               }
               if(do_you_need_ceiling_painted == '1'){

                var per_ceiling_costs = jQuery("#per_ceiling_costs").val();
                 if (isYourHomeFurnshed == '') {
                   jQuery('#per_ceiling_costs_error').html("Please Select Yes or No");
                   jQuery('#per_ceiling_costs_error').show().delay(0).fadeIn('show');
                   jQuery('#per_ceiling_costs_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#per_ceiling_costs').offset().top - 150
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
            

            painting_calculation();
            
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
            $('#customer_id').select2({
                placeholder: 'Select Customer Name',
                allowClear: true
            });
        });


            
//On date change the Time slot will change

        $('#service_date').change(function(){
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

function type_of_homeFun(){

    var typeOfHome = $("#type_of_home").val(); // get selected home type
    if (typeOfHome == "2") {  // Apartment
        $('#selected_type_home').val("Apartment"); 
        $("#apartment-size-group").show();
        $("#price-div").show();
        $("#villa-size-group").hide().find('select').val('Select Villa Size');
        sizeOfHome();
    } else if (typeOfHome == "3") { // Villa
        $('#selected_type_home').val("Villa");
        $("#apartment-size-group").hide().find('select').val('Select Apartment Size');
        $("#villa-size-group").show();
        $("#price-div").show();
        sizeOfHome();
    } else {
        $('#selected_type_home').val(""); 
        $("#price-div").hide();
        $("#apartment-size-group").hide().find('select').val('Select Apartment Size');
        $("#villa-size-group").hide().find('select').val('Select Villa Size');
        sizeOfHome();
    }
}
 

function sizeOfHome(){
    
        var typeOfHome = $("#type_of_home").val(); // get selected home type
        var sizeOfHomeId = null;

        if (typeOfHome == "2") {  // Apartment
            sizeOfHomeId = $("select[name='size_of_home_1']").val();
        } else if (typeOfHome == "3") { // Villa
            sizeOfHomeId = $("select[name='size_of_home_2']").val();
        }

        if (!sizeOfHomeId) {
            $("#size_of_home_price").val('');
            $("#selected_size_home").val('');
        }

        $.ajax({
            type: 'POST',
            url: '{{ url('get-size-home-price') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                'size_home_id': sizeOfHomeId,
            },
            success: function(responses) {
                if(responses){
                    var response_ajax = JSON.parse(responses);
                    $("#size_of_home_price").val(response_ajax.price.toFixed(2));
                    $("#selected_size_home").val(response_ajax.size_of_home);
                    painting_calculation();
                }
            }
        });
    }

 function newColor(colorType) {
    var type_of_home = $("#type_of_home").val();

    let whatColornew = "";
    if (colorType == 1) {
        whatColornew = $("#color_do_you_want_walls_painted").val();
    } else {
        whatColornew = $("#what_color_your_walls_now").val();
    }

    let colorYouWantPaint = (type_of_home == 2) ? 1 : 2;

    if (!whatColornew || whatColornew.startsWith("Select")) {
        // Optional: handle empty or placeholder value
        return;
    }

    $.ajax({
        type: 'POST',
        url: '{{ url('get-color-painted-price') }}',
        data: {
            "_token": "{{ csrf_token() }}",
            'color_you_want_paint_id': colorYouWantPaint,
            'color_type': whatColornew
        },
        success: function(responses) {
            if (responses) {
                let floatPrice = parseFloat(responses);

                if (colorType == 1) {
                    $("#color_you_want_painted_price").val(floatPrice.toFixed(2));
                    $("#selected_you_want_color_name").val(whatColornew);
                } else {
                    $("#color_your_walls_now_price").val(floatPrice.toFixed(2));
                    $("#selected_your_walls_now_name").val(whatColornew);
                }

                painting_calculation();
            }
        }
    });
}

function homeFurnished(){
    var isYourHomeFurnshed = $("#isYourHomeFurnshed").val();
    // alert(isYourHomeFurnshed);
    // return false;

    var type_of_home = $("#type_of_home").val(); 

    if(type_of_home == 2){
        isYourHomeFurnishedFlag = 3; 
        $('#home_furnished_div').show();
    }else{
        isYourHomeFurnishedFlag = 4; 
        $('#home_furnished_div').show();
    }

    if(isYourHomeFurnshed == 'Yes'){
            $.ajax({
            type: 'POST',
            url: '{{ url('get-home-furnished-price') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                'is_your_home_furnished_flg': isYourHomeFurnishedFlag,
                'home_furnished_val': ""
            },
            success: function(responses) {
                // return false;
                let furnishedPrice = parseFloat(responses);
                $("#selected_home_furnished_price").val(furnishedPrice.toFixed(2));
                $("#selected_home_furnished").val(furnishedPrice.toFixed(2));
                painting_calculation();

            }
        });
    }else{
        $("#selected_home_furnished_price").val('0');
        $("#selected_home_furnished").val('');
        painting_calculation();
    } 
}

function isCeilingPainted(){

        let noOfCeilings;
        let selectedCeilingPrice;
        let sumofAdditionalChrgCeiling;

        if ($("#do_you_need_ceiling_painted").val() == "1") { 
            $("#ceiling_painted_div").show();
            $("#ceiling_price_div").show();
            noOfCeilings = $("#per_ceiling_costs").val()
        
            // Check if 'noOfCeilings' is valid and between 1-5
            if (noOfCeilings >= 1 && noOfCeilings <= 5) {
                selectedCeilingPrice = noOfCeilings * 125; // Calculate price for ceilings

                // alert(selectedCeilingPrice);
                $("#selected_ceiling_price").val(selectedCeilingPrice);
                $("#no_of_ceilings").val(noOfCeilings);
                painting_calculation();
            }

        } else if ($("#do_you_need_ceiling_painted").val() == "2") { 
            $("#ceiling_painted_div").hide();
            $("#ceiling_price_div").hide();
            $("#no_of_ceilings").val('');
            $("#selected_ceiling_price").val('0');
            painting_calculation();
        }

}


</script>

<script>

function painting_calculation() {
   
    
    let size_of_home_price = parseFloat($("#size_of_home_price").val()) || 0;
    let color_you_want_painted_price = parseFloat($("#color_you_want_painted_price").val()) || 0;
    let color_your_walls_now_price = parseFloat($("#color_your_walls_now_price").val()) || 0;
    let selected_home_furnished_price = parseFloat($("#selected_home_furnished_price").val()) || 0;
    let selected_ceiling_price = parseFloat($("#selected_ceiling_price").val()) || 0;

    let selected_you_want_color_name = $("#selected_you_want_color_name").val();
    let selected_your_walls_now_name = $("#selected_your_walls_now_name").val();

    let additionalCharge = 0;

    if (selected_you_want_color_name === selected_your_walls_now_name) {
        additionalCharge = selected_home_furnished_price + selected_ceiling_price;
    } else if (color_you_want_painted_price !== 0 && color_your_walls_now_price === 0) {
        additionalCharge = selected_home_furnished_price + color_you_want_painted_price;
    } else {
        additionalCharge = selected_home_furnished_price + color_your_walls_now_price + selected_ceiling_price;
    }

    
    if (selected_home_furnished_price > 0) {
        additionalCharge = selected_home_furnished_price + selected_ceiling_price;
    }

    
    let cod_charge = parseFloat($('#cod_charge').val()) || 0;
    let timing_charge = parseFloat($('#timing_charge').val()) || 0;
    let date_charge = parseFloat($('#date_charge').val()) || 0;
    let service_fee = parseFloat($('#service_fee').val()) || 0;
    let include_vat = $('#include_vat').val();

    let sub_total = cod_charge + service_fee + timing_charge + date_charge + additionalCharge + size_of_home_price;

    let vat_charge = 0;
    if (include_vat === 'yes') {
        vat_charge = sub_total * 0.05;
    }

    let order_total = sub_total + vat_charge;

    // alert(order_total);
    $('#sub_total').val(sub_total.toFixed(2));
    $('#vat_charge').val(vat_charge.toFixed(2));
    $('#order_total').val(order_total.toFixed(2));
    $('#additionalCharge').val(additionalCharge.toFixed(2));
}

</script>
@stop
