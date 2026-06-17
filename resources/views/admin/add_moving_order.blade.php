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
                    <h3 class="page-title">Package Order - Moving</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Package Order - Moving</a></li>
                        <li class="breadcrumb-item active">Add Package Order - Moving</li>
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

                        <form action="{{ route('moving-order-store') }}" method="POST" id="form"
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
                                                <option value="{{ $item->id }}" data-email="{{ $item->email }}" data-name="{{ $item->name }}" data-phone = "{{ $item->mobile }}">{{ $item->id }}-{{ $item->name }}-{{ $item->email }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="customer_name_error" style="color: red; margin-top: 10px;"></p>
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
                                        <p class="form-error-text" id="subservice_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-2">
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
                                <div class="col-md-2">
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

                       <h4>Customer Details : </h4>
                       <div class="col-md-4">
                            <div class="form-group">
                                <label>First Name:</label>
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                    placeholder="Enter First Name">
                                <p class="form-error-text" id="first_name_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>
                        

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Last Name:</label>
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                    placeholder="Enter Last Name">
                                <p class="form-error-text" id="last_name_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Country:</label>
                                <select id="country" name="country" class="form-control form-select">
                                    <option value="">Select Country</option>
                                    @foreach ($country_data as $item)
                                        <option value="{{ $item->id }}">{{ $item->country }}</option>
                                    @endforeach
                                </select>
                                <p class="form-error-text" id="country_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Emirates:</label>
                                <select id="emirates" name="emirates" class="form-control form-select">
                                    <option value="">Select Emirates</option>
                                    <option value="Dubai" data-id="17" selected>Dubai</option>
                            <option value="Abu Dhabi" data-id="20">Abu Dhabi</option>
                            <option value="Sharjah" data-id="22">Sharjah</option>
                            <option value="Ajman" data-id="23">Ajman</option>
                            <option value="Umm Al Quwain" data-id="24">Umm Al Quwain</option>
                            <option value="Ras Al Khaimah" data-id="25">Ras Al Khaimah</option>
                            <option value="Fujairah" data-id="26">Fujairah</option>
                                </select>
                                <p class="form-error-text" id="emirates_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Area:</label>
                               <input type="text" class="form-control" name="area" id="area"
                                    placeholder="Enter Area">
                                <p class="form-error-text" id="area_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Street:</label>
                               <input type="text" class="form-control" name="street" id="street"
                                    placeholder="Enter Street">
                                <p class="form-error-text" id="street_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Apartment/Villa No:</label>
                               <input type="text" class="form-control" name="apartment_villa" id="apartment_villa"
                                    placeholder="Enter Apartment/Villa No">
                                <p class="form-error-text" id="apartment_villa_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Phone:</label>
                               <input type="text" class="form-control" name="phone" id="phone"
                                    placeholder="Enter Phone">
                                <p class="form-error-text" id="phone_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email Address:</label>
                               <input type="text" class="form-control" name="email" id="email"
                                    placeholder="Enter Email Address">
                                <p class="form-error-text" id="email_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>When would you like to move ?</label>
                               <input type="date" class="form-control" name="moving_date" id="moving_date">
                                <p class="form-error-text" id="moving_date_error" style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label>What time would you like to reschedule to ?</label>
                                <div id="time_slot_change">
                                <select id="time_slot" name="time_slot" class="form-control form-select">
                                    <option value="">Select Time Slot</option>

                                </select>
                                <p class="form-error-text" id="time_slot_error" style="color: red; margin-top: 10px;"></p>
                            </div>
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

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Additional information:</label>
                                 <textarea class="form-control" name="additional_info" id="additional_info" rows="4" cols="50"
                                    placeholder="Please detail your job as much as you can"></textarea>
                            </div>
                        </div>
                         </div>
                        <div class="text-end mt-4">
                            <a href="{{ route('order.index') }}" class="btn btn-primary text-light">Cancel</a>
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

                if(!validatePackageFields()) {
                    return false;
                }
                

                
               var first_name = jQuery("#first_name").val();
               if (first_name == '') {
                   jQuery('#first_name_error').html("Please Enter First Name");
                   jQuery('#first_name_error').show().delay(0).fadeIn('show');
                   jQuery('#first_name_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#first_name').offset().top - 150
                   }, 1000);
                   return false;
               }
               var last_name = jQuery("#last_name").val();
               if (last_name == '') {
                   jQuery('#last_name_error').html("Please Enter Last Name");
                   jQuery('#last_name_error').show().delay(0).fadeIn('show');
                   jQuery('#last_name_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#last_name').offset().top - 150
                   }, 1000);
                   return false;
               }

               var country = jQuery("#country").val();
               if (country == '') {
                   jQuery('#country_error').html("Please Select Country");
                   jQuery('#country_error').show().delay(0).fadeIn('show');
                   jQuery('#country_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#country').offset().top - 150
                   }, 1000);
                   return false;
               }

               var emirates = jQuery("#emirates").val();
               if (emirates == '') {
                   jQuery('#emirates_error').html("Please Select emirates");
                   jQuery('#emirates_error').show().delay(0).fadeIn('show');
                   jQuery('#emirates_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#emirates').offset().top - 150
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

               var street = jQuery("#street").val();
               if (street == '') {
                   jQuery('#street_error').html("Please Enter Street Name ");
                   jQuery('#street_error').show().delay(0).fadeIn('show');
                   jQuery('#street_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#street').offset().top - 150
                   }, 1000);
                   return false;
               }

               var apartment_villa = jQuery("#apartment_villa").val();
               if (apartment_villa == '') {
                   jQuery('#apartment_villa_error').html("Please Enter Apartment or Villa Number");
                   jQuery('#apartment_villa_error').show().delay(0).fadeIn('show');
                   jQuery('#apartment_villa_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#apartment_villa').offset().top - 150
                   }, 1000);
                   return false;
               }

                var phone = jQuery("#phone").val();
                if (phone == '') {
                    jQuery('#phone_error').html("Plaese Enter phone.");
                    jQuery('#phone_error').show().delay(0).fadeIn('show');
                    jQuery('#phone_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#phone').offset().top - 150
                    }, 1000);
                    return false;
                }
                var filter = /^\d{7,15}$/;
                if (!filter.test(phone)) {
                    jQuery('#phone_error').html("Plaese Enter Valid phone.");
                    jQuery('#phone_error').show().delay(0).fadeIn('show');
                    jQuery('#phone_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#phone').offset().top - 150
                    }, 1000);
                    return false;
                }

                var email = jQuery("#email").val();
                if (email == '') {
                    jQuery('#email_error').html("Plaese Enter Email Address.");
                    jQuery('#email_error').show().delay(0).fadeIn('show');
                    jQuery('#email_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#email').offset().top - 150
                    }, 1000);
                    return false;
                }
                var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!filter.test(email)) {
                    jQuery('#email_error').html("Plaese Enter Valid Email Address.");
                    jQuery('#email_error').show().delay(0).fadeIn('show');
                    jQuery('#email_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#email').offset().top - 150
                    }, 1000);
                    return false;
                }
            

                var moving_date = jQuery("#moving_date").val();
                if (moving_date == '') {
                    jQuery('#moving_date_error').html("Please Enter Moving Date");
                    jQuery('#moving_date_error').show().delay(0).fadeIn('show');
                    jQuery('#moving_date_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#moving_date').offset().top - 150
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
            

                // for Package System Calculation
                package_calculation();
            

                
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
        const dateInput = document.getElementById('moving_date');
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
         $('#customer_id').on('change', function () {
            let selectedOption = $(this).find('option:selected');
            let email = selectedOption.data('email') || '';
            let first_name = selectedOption.data('name') || '';
            let phone = selectedOption.data('phone') || '';

            $('#email').val(email);
            $('#first_name').val(first_name);
            $('#phone').val(phone);
        });
        $('#package').select2({
                placeholder: 'Select Packages', // Add your desired placeholder text here
            });
        $('#package_category').select2({
                placeholder: 'Select Package Category', // Add your desired placeholder text here
            });
    });

 
//On subservice Change the cleaner will change and date & time slot will be empty

     $('#subservice_id').change(function(){
        var subservice_id = $(this).val();
        $('.add_to_cart').show();

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


            $.ajax({
                url: '{{ url('get-time-slot') }}',
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "subservice_id": subservice_id
                },
                success: function(msg) {
                    // alert(msg);
                    document.getElementById('time_slot_change').innerHTML = msg;
                }
            });
        });


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

    

    let include_vat = $('#include_vat').val();

    let sub_total = service_charge;

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
