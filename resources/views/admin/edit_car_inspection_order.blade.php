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
                    <h3 class="page-title">Package Order - Car Inspection</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('handyman-service-order') }}">Package Order - Car Inspection</a></li>
                        <li class="breadcrumb-item active">Edit Package Order - Car Inspection</li>
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

                    <form action="{{ route('car-inspection-order-update', $order->order_id) }}" method="POST" id="form"
                            enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="payment_hidden" id="payment_hidden" value="1">
                    <input type="hidden" name="package_id" id="package_id" value="">
                        
                <input type="hidden" name="total_amount" id="total_amount" value="">
                 
           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Customer Name</label>
                                        <select id="customer_id" name="customer_id" class="form-control form-select" onchange="customerdetails(this.value);">
                                            <option value="">Select Customer Name</option>
                                            @foreach ($customer_data as $item)
                                                <option value="{{ $item->id }}" @if($item->id == $order->user_id) selected @endif>{{ $item->id }}-{{ $item->name }}-{{ $item->email }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="customer_name_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pacakges</label>
                                        <select id="select_package_id" name="select_package_id" class="form-control form-select" onchange="showpackage
                                        (this.value);">
                                            <option value="">Select Pacakges</option>
                                            @foreach ($package_data as $item)
                                                <option value="{{ $item->id }}" @if($item->id == $order->items[0]->verifybuy_package_id) selected @endif>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="package_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Customer Mobile No</label>
                                            <input type="text" name="mobile" id="mobile" class="form-control"
                                    placeholder="Enter a Mobile No" value="{{$order->user_mobile}}">
                                        
                                        <p class="form-error-text" id="mobile-error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Inspection Location</label>
                                        <select id="location" name="location" class="form-control form-select">
                                           <option value="">Select</option>
                                            <option value="Abu Dhabi" @if($order->items[0]->verifybuy_location == 'Abu Dhabi') selected @endif>Abu Dhabi</option>
                                            <option value="Dubai" @if($order->items[0]->verifybuy_location == 'Dubai') selected @endif>Dubai</option>
                                            <option value="Sharjah" @if($order->items[0]->verifybuy_location == 'Sharjah') selected @endif>Sharjah</option>
                                            <option value="Ajman" @if($order->items[0]->verifybuy_location == 'Ajman') selected @endif>Ajman</option>
                                            <option value="Ras Al Khaimah" @if($order->items[0]->verifybuy_location == 'Ras Al Khaimah') selected @endif>Ras Al Khaimah</option>
                                            <option value="Fujairah" @if($order->items[0]->verifybuy_location == 'Fujairah') selected @endif>Fujairah</option>
                                            <option value="Umm Al Quwain" @if($order->items[0]->verifybuy_location == 'Umm Al Quwain') selected @endif>Umm Al Quwain</option>
                                        </select>
                                        <p class="form-error-text" id="location-error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                 <div class="col-md-6">
                                    <label class="form-label fw500 dark-color">Address</label>
                                    <input name="address" type="text" class="form-control " id="address" placeholder="Address" value="{{$order->items[0]->verifybuy_address}}">
                                    <p id="address-error" style="display: none;color:red;"></p>
                                    @error('address')
                                                <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                </div>
                                  <div class="col-md-6">
                                        <label class="form-label fw500 dark-color">Additional Location Details</label>
                                        <textarea name="additional_details" class="form-control " row="5" col="30"  id="additional_details" placeholder="Additional Location Details">{{$order->items[0]->verifybuy_additional_details}}</textarea>
                                        <p id="additional_details-error" style="display: none;color:red;"></p>
                                        @error('additional_details')
                                                    <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                        
                                    </div>

                                     <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Where is car parked?</label>
                                        <select id="where_is_car_parked" name="where_is_car_parked" class="form-control form-select">
                                            <option value="">Select</option>
                                             <option value="Showroom"  @if($order->items[0]->verifybuy_where_is_car_parked == 'Showroom') selected @endif>Showroom</option>
                                            <option value="Outdoor"  @if($order->items[0]->verifybuy_where_is_car_parked == 'Outdoor') selected @endif >Outdoor</option>
                                            <option value="Home"  @if($order->items[0]->verifybuy_where_is_car_parked == 'Home') selected @endif>Home</option>
                                        </select>
                                        <p class="form-error-text" id="where_is_car_parked_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                
                                     <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Vehicle Make</label>
                                        <select id="vehicle_make" name="vehicle_make" class="form-control form-select" onchange="showmodel(this.value)">
                                            <option value="">Select</option>
                                           @foreach ($vehicles as $item)
                                                <option value="{{ $item->id }}"  @if($item->id == $order->items[0]->verifybuy_vehicle) selected @endif>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="vehicle_make-error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                
                                     <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Vehicle Model</label>
                                        <span id="change_model">
                                        <select id="other_vehicle_model" name="other_vehicle_model" class="form-control form-select" onchange="showPrice(this.value);">
                                            <option value="">Select</option>
                                        
                                        </select>
                                    </span>
                                        <p class="form-error-text" id="subservice_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <label class="form-label fw500 dark-color">Date</label>
                                    <input name="inspection_date" type="date" class="form-control " id="inspection_date" placeholder="Address" value="{{$order->moving_date}}">
                                    <p id="inspection_date-error" style="display: none;color:red;"></p>
                                    @error('address')
                                                <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                </div>
                                 <div class="col-md-6">
                                    <label class="form-label fw500 dark-color">Time</label>
                                     <select id="inspection_time" name="inspection_time" class="form-control form-select">
                                            <option value="">Select Time</option>
                                            @foreach ($subservice_timeslot_price as $item)
                                                <option value="{{ $item->time_slot_id }}"  @if($item->time_slot_id == $order->items[0]->time_slot) selected @endif>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <p id="inspection_time-error" style="display: none;color:red;"></p>
                                    @error('address')
                                                <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                </div>
                           
                        

                      
                  </div>
                            <div class="text-end mt-4">
                                <a href="{{ route('car-inspection-order') }}" class="btn btn-primary text-light">Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" onclick="book_inspection();" id="submit_button"
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
         $(document).ready(function(){
        var defaultPackageId = $('#select_package_id').val(); // or set manually, e.g., var 
          // alert(defaultPackageId);
        if (defaultPackageId) {
            showpackage(defaultPackageId);
        }
    });


      function book_inspection(){

         var customer_id = $('#customer_id').val();
if (customer_id == '') {
    jQuery('#customer_name_error').html("Please Select a Customer");
    jQuery('#customer_name_error').show().delay(0).fadeIn('show');
    jQuery('#customer_name_error').show().delay(2000).fadeOut('show');
     $('html, body').animate({
                                scrollTop: $('#customer_id').offset().top - 150
                            }, 1000);
    return false;
}
   var pacakge_id = $('#pacakge_id').val();
if (pacakge_id == '') {
    jQuery('#package_error').html("Please Select a Package");
    jQuery('#package_error').show().delay(0).fadeIn('show');
    jQuery('#package_error').show().delay(2000).fadeOut('show');
     $('html, body').animate({
                                scrollTop: $('#pacakge_id').offset().top - 150
                            }, 1000);
    return false;
}
        

  var mobile = $('#mobile').val();
if (mobile == '') {
    jQuery('#mobile-error').html("Please enter a Mobile No");
    jQuery('#mobile-error').show().delay(0).fadeIn('show');
    jQuery('#mobile-error').show().delay(2000).fadeOut('show');
     $('html, body').animate({
                                scrollTop: $('#mobile').offset().top - 150
                            }, 1000);
    return false;
}
  var location = $('#location').val();
if (location == '') {
    jQuery('#location-error').html("Please Select Inspection Location");
    jQuery('#location-error').show().delay(0).fadeIn('show');
    jQuery('#location-error').show().delay(2000).fadeOut('show');
     $('html, body').animate({
                                scrollTop: $('#mobile').offset().top - 150
                            }, 1000);
    return false;
}
  var address = $('#address').val();
if (address == '') {
    jQuery('#address-error').html("Please enter an Address");
    jQuery('#address-error').show().delay(0).fadeIn('show');
    jQuery('#address-error').show().delay(2000).fadeOut('show');
     $('html, body').animate({
                                scrollTop: $('#address').offset().top - 150
                            }, 1000);
    return false;
}
  
var where_is_car_parked = $('#where_is_car_parked').val();

if (where_is_car_parked == '') {
jQuery('#where_is_car_parked_error').html("Please Select a Where is car parked");
    jQuery('#where_is_car_parked_error').show().delay(0).fadeIn('show');
    jQuery('#where_is_car_parked_error').show().delay(2000).fadeOut('show');
    // Scroll to radio section if needed
    $('html, body').animate({
        scrollTop: $('.where_is_my_car_section').offset().top - 150
    }, 1000);

    return false;
}
var vehicle_make = $('#vehicle_make').val();

if (vehicle_make == '') {
jQuery('#vehicle_make-error').html("Please Select a Vehicle Make");
    jQuery('#vehicle_make-error').show().delay(0).fadeIn('show');
    jQuery('#vehicle_make-error').show().delay(2000).fadeOut('show');
    // Scroll to radio section if needed
    $('html, body').animate({
        scrollTop: $('.vehicle_make_sec').offset().top - 150
    }, 1000);

    return false;
}
var inspection_date = $('#inspection_date').val();

if (inspection_date == '') {
jQuery('#inspection_date-error').html("Please Select an Inspection Date");
    jQuery('#inspection_date-error').show().delay(0).fadeIn('show');
    jQuery('#inspection_date-error').show().delay(2000).fadeOut('show');
    // Scroll to radio section if needed
    $('html, body').animate({
        scrollTop: $('.vehicle_make_sec').offset().top - 150
    }, 1000);

    return false;
}
var inspection_time = $('#inspection_time').val();

if (inspection_time == '') {
jQuery('#inspection_time-error').html("Please Select a Inspection Time");
    jQuery('#inspection_time-error').show().delay(0).fadeIn('show');
    jQuery('#inspection_time-error').show().delay(2000).fadeOut('show');
    // Scroll to radio section if needed
    $('html, body').animate({
        scrollTop: $('.vehicle_make_sec').offset().top - 150
    }, 1000);

    return false;
}
 $('#spinner_button').show();
 $('#submit_btn').hide();
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
        if (how_many_cleaner == 1 ) {
            $('#cleaner_div').show();
        } else {
            $('#cleaner_div').hide();
        }
    });
  
 
//On subservice Change the cleaner will change and date & time slot will be empty

     $('#subservice_id').change(function(){
        var subservice_id = $(this).val();

        $('#time_slot').val('');
        $('#service_date').val('');

        if(subservice_id == 28){
            $('.home_cleaning_form').show();
            $('.add_to_cart').hide();
            $('#cleaner_div').show();
            $('.add_to_cart').find('input, select, textarea').val(''); 
        }else{
            $('.home_cleaning_form').hide();
            $('#cleaner_div').hide();
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
        $('#hour_value').change(function(){
            $('#time_slot').val('');
            $('#service_date').val('');
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
    
//On cleaner change the time slot and service date will be empty
        function  cleaner_on_change(){
            $('#service_date').val('');
            $('#time_slot').val('');
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



function customerdetails(id){
      

      $.ajax({
            type:"Post",
             url: "{{ url('show_customer_details') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "customer_id": id,
                },
                success: function(returndata) {
                        
                      // alert(returndata.mobile);

                        $('#mobile').val(returndata.mobile);
                     
                }
        });
            
 
}
function showmodel(id){
   
      

      $.ajax({
            type:"Post",
             url: "{{ url('show_vehicle_model') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "vehicle_id": id,
                },
                success: function(returndata) {
                        
                      // alert(returndata.mobile);

                        
                        $('#change_model').html(returndata.html);
                     
                }
        });
            
 
}
function showPrice(val){

    // alert(val);
          $.ajax({
            type:"Post",
             url: "{{ url('show_price') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "value": val,
                },
                success: function(returndata) {
                        
                       
                        $('#changeModel').html(returndata.html);
                       if (returndata.price !== null && returndata.price !== undefined && returndata.price !== '') {
                        
                        $('#total_amount').val(returndata.price);
                        }
                        $('#category_replace').show();
                        
                    // if (returndata == 1)

                    //    
                    // $('.success_show').show().delay(0).fadeIn('show');
                    // $('.success_show').show().delay(5000).fadeOut('show');
                    // $('#status_modell').modal('hide');
                }
        });

   }
   function showpackage(val){
    

     $('#package_id').val(val);
       $.ajax({
            type:"Post",
             url: "{{ url('show_package_price') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "value": val,
                },
                success: function(returndata) {

                    //alert(returndata.price)
                        
                       
                        
                       if (returndata.price !== null && returndata.price !== undefined && returndata.price !== '') {
                        
                        $('#total_amount').val(returndata.price);
                        }
                       
                        
                    // if (returndata == 1)

                    //    
                    // $('.success_show').show().delay(0).fadeIn('show');
                    // $('.success_show').show().delay(5000).fadeOut('show');
                    // $('#status_modell').modal('hide');
                }
        });

   

  

   }


  

</script>
@stop
