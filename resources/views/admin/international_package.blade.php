@extends('admin.includes.Template')
@section('content')


    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">International Package</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vendors.subscription', $id) }}">Subscription</a>
                        </li>
                        <li class="breadcrumb-item active">International Package</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">

                <strong>Success!</strong> {{ $message }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

            </div>
        @endif

        {{-- <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div> --}}
        <p class="form-error-text" id="validate" style="color: red; margin-top: 10px;"></p>

        @php
            $wallet_amount = DB::table('users')->where('id', $id)->first();
            //    echo '<pre>';
            //    print_r($amount);
            //    echo '</pre>';
        @endphp
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Category</h4> -->
                        <form action="{{ route('international-package', ['id' => $id]) }}" id="category_form_new" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="subscription_name" id="subscription_name"
                                value="International Package">
                            <input type="hidden" name="subscription_id" id="subscription_id" value="2">
                            <input type="hidden" name="action" id="subscription_id" value="add">

                            <input type="hidden" name="vendor_id" id="subscription_id" value="{{ $id }}">


                            @csrf
                            <div class="row">

                                @php
                                if($subscription_data){
                                 $country_array = explode(',',$subscription_data->country);
                                }else{
                                    $country_array = [];
                                }
                                //  echo "<pre>";print_r($country_array);echo"</pre>";exit;
                                @endphp

                                <div class="form-group">
                                    <label for="country">Moving from Country</label>
                                    <select class="form-control" id="country" name="country[]" multiple="multiple">
                                        <option value="">Select country</option>
                                        @foreach ($country_data as $country)
                                        @if($country->id == '276')
                                        @continue
                                        @endif
                                        <option value="{{ $country->id }}"  @if(request()->has('subs_id') && in_array($country->id, $country_array)) 
                                                selected 
                                            @endif>{{ $country->country }}</option>
                                        @endforeach
                                    </select>
                                    <p class="form-error-text" id="country_error" style="color: red; margin-top: 10px;">
                                    </p>
                                </div>

                                @php
                                   if($subscription_data){
                                    $continents_array = explode(',',$subscription_data->continents);
                                   }else{
                                       $continents_array = [];
                                   }
   
                                   //  echo "<pre>";print_r($country_array);echo"</pre>";exit;
                                   @endphp

                                <div class="form-group">
                                    <label for="state">Continents</label>
                                    <span>
                                        <select class="form-control" id="continents" name="continents[]" multiple="multiple" 
                                            onchange="to_country_change();">
                                            <option value="">Select Continents</option>
                                            @foreach ($continents_data as $continent)
                                                <option value="{{ $continent->id }}" @if(request()->has('subs_id') && in_array($continent->id, $continents_array)) selected @endif>{{ $continent->continent }}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                    <p class="form-error-text" id="state_error" style="color: red; margin-top: 10px;">
                                    </p>
                                </div>

                                

                                <div class="form-group">
                                    <label for="state">Moving to Country</label>
                                    <span id="to_country_chang">
                                        <select class="form-control" id="to_country" name="to_country[]"  multiple="multiple" >
                                            <option value="">Select Moving to Country</option>
                                            {{-- @foreach ($country_data as $country)
                                                <option value="{{ $country->id }}">{{ $country->country }}</option>
                                            @endforeach --}}
                                        </select>
                                    </span>
                                    <p class="form-error-text" id="state_error" style="color: red; margin-top: 10px;">
                                    </p>
                                </div>

                                @php
                                   if($subscription_data){
                                    $service_array = explode(',',$subscription_data->services);
                                   }else{
                                       $service_array = [];
                                   }
   
                                   //  echo "<pre>";print_r($country_array);echo"</pre>";exit;
                                   @endphp

                                <div class="form-group">
                                    <label for="city">Services</label>
                                    <select class="form-control" id="services" name="services[]" multiple="multiple"
                                        onchange="subservice_change(this.value);">
                                        <option value="">Select Services</option>
                                        @foreach ($allservices as $services)
                                        <option value="{{ $services->id }}"@if(request()->has('subs_id') && in_array($services->id, $service_array)) selected @endif>{{ $services->servicename }}</option>
                                        @endforeach
                                    </select>
                                    <p class="form-error-text" id="services_error" style="color: red; margin-top: 10px;">
                                    </p>
                                </div>

                                <div class="form-group">
                                    <label for="city">Sub Services</label>
                                    <span id="subservice_option">
                                        <select class="form-control" id="sub_service" name="sub_service[]"
                                            multiple="multiple">
                                            <option value="">Select Sub Service</option>
                                        </select>
                                    </span>
                                    <p class="form-error-text" id="sub_service_error"
                                        style="color: red; margin-top: 10px;"></p>

                                </div>

                                <div class="form-group row">
                                         <label class="col-form-label col-md-12">Type of Subscription</label>
                                         <div class="col-md-10">
                                            <div class="type_of_subscription" style="width: 10%;display: inline-block;">
                                                <label>
                                                    <input type="radio" name="type_of_subscription"  id="radio_type" value="0" @if($subscription_data){{ $subscription_data->type_of_subscription == 0 ? 'checked' : '' }} @endif
                                                    onclick="toggleDiv(this.value)">
                                                Package
                                                </label>
                                            </div>
                                            <div class="radio" style="width: 10%;display: inline-block;">
                                                <label>
                                                    <input type="radio" id="radio_type" name="type_of_subscription" value="1" @if($subscription_data){{ $subscription_data->type_of_subscription == 1 ? 'checked' : '' }}@endif onclick="toggleDiv(this.value)"> Leads
                                                </label>
                                            </div>
                                            <div class="type_of_subscription" style="width: 30%;display: inline-block;">
                                                <label>
                                                    <input type="radio" name="type_of_subscription" id="radio_type" value="2" @if($subscription_data){{ $subscription_data->type_of_subscription == 2 ? 'checked' : '' }}@endif  onclick="toggleDiv(this.value)"> Auto Accept Package
                                                </label>
                                            </div>
                                             
                                         </div>
                                     </div>

                                 <div id="packageDiv" style="display:none">


                                     {{-- <div class="form-group row">
                                         <label class="col-form-label col-md-12">Type of Package</label>
                                         <div class="col-md-10">
                                             <div class="type_of_package" style="width: 10%;display: inline-block;">
                                                 <label>
                                                     <input type="radio" name="type_of_package" value="0" > Local
                                                 </label>
                                             </div>
                                             <div class="radio" style="width: 15%;display: inline-block;">
                                                 <label>
                                                     <input type="radio" name="type_of_package" value="1" > International
                                                 </label>
                                             </div>
                                             
                                         </div>
                                     </div> --}}

                                     <div class="row" style="margin-bottom: 35px;">
                                         <div class="col-md-12">
                                             <div class="table-responsive">
                                                 <table class="invoice-table table table-bordered">
                                                     <thead>
                                                         <tr>
                                                             <th class="text-end">No Of Inquiry</th>
                                                             <th class="text-end">Package Price</th>
                                                             <!-- 
                                                             <th class="text-end">Final Price</th> -->
                                                         </tr>
                                                     </thead>
                                                     <tbody>
                                                         <tr>
                                                            <td>
                                                                <input 
                                                                id="no_of_inquiry_package" 
                                                                name="no_of_inquiry_package" 
                                                                type="text" 
                                                                class="form-control no-of-inquiry-input" 
                                                                placeholder="Enter No Of Inquiry" 
                                                                value="@if($subscription_data && $subscription_data->no_of_inquiry_package){{ $subscription_data->no_of_inquiry_package }}@else{{ '' }}@endif" 
                                                                oninput="updateTotal_package()"/>
                                                                    
                                                                    </td>
                                                            <td>
                                                                <input id='price_package' name='price_package' type='text' class='form-control price-input' placeholder='Enter Price' value="@if($subscription_data && $subscription_data->price_package){{ $subscription_data->price_package }}@else{{ '' }}@endif"   oninput='updateTotal_package()'/>
                                                                
                                                            </td>
                                                             
                                                             <!-- <td>
                                                                 <span id='replace_final_price_package'></span> <input id='finalprice_package' name='finalprice_package' type='hidden' value='' />
                                                             </td> -->
                                                         </tr>
                                                     </tbody>
                                                 </table>
                                             </div>
                                         </div>
                                     </div>
                                     <input type="hidden" name="total_package" id="total_package" value="0">
                                 </div>

                                <div class="col-lg-12" id="subservice_table_change_div">

                                </div>

                                <div class="col-lg-12" id="moving_change_div" style="display: none;">

                                </div>

                                <input type="hidden" name="final_total_new" id="final_total_new" value="">

                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('vendors.subscription', $id) }}"> Back</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                                {{-- @if ($wallet_amount->wallet_amount != 0) --}}
                                <button type="button" class="btn btn-primary"
                                    onclick="javascript:category_validation()"id="submit_button">Buy Now</button>
                                {{-- @endif --}}
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

         function updateTotal_new(loop_id,sub_serviceid) {
             var no_of_inquiry = $('#no_of_inquiry_'+ loop_id).val();
             var price = $('#price_'+ loop_id).val();

             var finalprice = (no_of_inquiry) * price;
             document.getElementById('replace_final_price_'+ loop_id).innerText = finalprice.toFixed(2);
             var price_final = $('#finalprice_'+ loop_id).val(finalprice);


             var finalPrices = document.getElementsByName('finalprice[]');
             var total = 0;

             for (var i = 0; i < finalPrices.length; i++) {
                 total += parseFloat(finalPrices[i].value);
             }

             document.getElementById('total-span').innerText = total.toFixed(2);
             document.getElementById('total').value = total.toFixed(2);

             var finalPrices_international = document.getElementsByName('international_total[]');
             var total_local = 0;

             for (var i = 0; i < finalPrices_international.length; i++) {
                 total_local += parseFloat(finalPrices_international[i].value);
             }

             var inquiry_total = $('#total').val();

             var final_total = parseFloat(inquiry_total) + parseFloat(total_local);

             $('#final_total_new').val(final_total);

             var url = '{{ url('session_subs_price_change') }}';
             //alert(url);
             $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "price": price,
                    "no_of_inquiry": no_of_inquiry,
                    "sub_serviceid": sub_serviceid
                },
                success: function(msg) {

                    //document.getElementById('state_chang').innerHTML = msg;
                }
            });


             //alert(no_of_inquiry);
         }


         function updateTotal_new_international(form_id,form_att_id,more_form_attributes_id) {

             var international_no_of_inquiry = $('#international_no_of_inquiry_'+ form_id + '_'+form_att_id +'_'+ more_form_attributes_id).val();

             var international_move_charge = $('#international_move_charge_'+ form_id + '_'+form_att_id +'_'+ more_form_attributes_id).val();


             var finalprice = (international_no_of_inquiry) * international_move_charge;
             document.getElementById('replace_international_final_price_'+ form_id + '_'+form_att_id +'_'+ more_form_attributes_id).innerText = finalprice.toFixed(2);
             
             var price_final = $('#replace_hidden_international_final_price_'+ form_id + '_'+form_att_id +'_'+ more_form_attributes_id).val(finalprice);


             //var finalPrices = document.getElementsByName('local_finalprice_'+form_id+'_'+form_att_id+'[]');

             var finalPrices = document.getElementsByName('international_finalprice_' + form_id + '_' + form_att_id + '[]');


             //alert(finalPrices);
             // var total = 0;

             // for (var i = 0; i < finalPrices.length; i++) {
             //     total += parseFloat(finalPrices[i].value);
             // }

             var total = 0;

             for (var i = 0; i < finalPrices.length; i++) {
                 var value = parseFloat(finalPrices[i].value);
                 if (!isNaN(value)) {
                     total += value;
                 }
             }

            // alert(total);

             document.getElementById('international-total-span_' + form_id + '_' + form_att_id).innerText = total.toFixed(2);
             //document.getElementById('local_total_'+form_id+'_'+form_att_id+'').value = total.toFixed(2);

             document.getElementById('international_total_' + form_id + '_' + form_att_id).value = total.toFixed(2);



             var finalPrices_international = document.getElementsByName('international_total[]');
             var total_internationl = 0;

             for (var i = 0; i < finalPrices_international.length; i++) {
                total_internationl += parseFloat(finalPrices_international[i].value);
             }

             var inquiry_total = $('#total').val();

             var final_total = parseFloat(inquiry_total) + parseFloat(total_internationl);

             $('#final_total_new').val(final_total);

             //alert(local_no_of_inquiry);
             //var price = $('#price_'+ loop_id).val();
         }


        function updateTotal(val,sub_serviceid) {

         // alert(val);
         // alert(sub_serviceid);
            let total = 0;

            // Select all input fields with the class 'price-input'
            document.querySelectorAll('.price-input').forEach(function(input) {
                let charge = parseFloat(input.getAttribute('data-charge'));
                let inputValue = parseFloat(input.value);

                // If the entered value is a valid number, use it; otherwise, fall back to the default charge
                if (!isNaN(inputValue)) {
                    total += inputValue;
                } else {
                    total += charge;
                }
                //    alert(total);
            });

            // Update the total amount in the designated HTML element
            document.getElementById('total-span').innerText = total.toFixed(2);
            document.getElementById('total').value = total.toFixed(2); // Store the total in a hidden input field if needed

            var url = '{{ url('session_subs_price_change') }}';
            // alert(url);
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "val": val,
                    "sub_serviceid": sub_serviceid
                },
                success: function(msg) {
                    //document.getElementById('state_chang').innerHTML = msg;
                }
            });
        }


        $(function() {
            $("#name").keyup(function() {

                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#page_url").val(Text);
            });
        });
    </script>


       

    <script type="text/javascript">

        function getQueryParam(param) {
                let urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
                }

                // Get subs_id from the URL (if it exists)
                let subs_id = getQueryParam('subs_id') || 0; // Use 0 as the default value

              

       function to_country_change() {

                var continents_id = $('#continents').val();
                var selectedCountries = $('#to_country').val();
                //    alert(continents_id);
                var url = '{{ url('to_country_show_subscription') }}';
                // alert(url);
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "continents_id": continents_id,
                        "selectedCountries": selectedCountries,
                        "subs_id": subs_id
                    },
                    success: function(msg) {
                        document.getElementById('to_country_chang').innerHTML = msg;
                        $("#to_country").select2({placeholder: "Select Moving to Country"});
                    //     if (selectedCountries) {
                    //         $('#to_country').val(selectedCountries).trigger('change');
                    // }
                }
            });
        }

        function subservice_change(value) {
            var selectedValues = $("#services").val();
                // alert(service_id);
            var url = '{{ url('subservice_change') }}';
            // alert(url);
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "service_id": selectedValues,
                    "subs_id" : subs_id
                    
                },
                success: function(msg) {
                    document.getElementById('subservice_option').innerHTML = msg;

                    chnage_moving_price_for_int(selectedValues);

                    $("#sub_service").select2({
                        placeholder: "Select a Sub service" 
                    });
                    $('#subservice_table_change_div').hide();
                }
            });

            //alert(selectedValues);
        }

        function chnage_moving_price_for_int(id){

         var url = '{{ url('chnage_moving_price_for_int') }}';

         $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "service_id": id,
                    "subs_id": subs_id
                },
                success: function(msg) {

                 document.getElementById('moving_change_div').innerHTML = msg;
                 // $('#moving_change_div').show();
                 //    document.getElementById('subservice_option').innerHTML = msg;

                 //    chnage_moving_price_for_int(selectedValues);

                 //    $("#sub_service").select2({
                 //        placeholder: "Select a Sub service" // Replace with your desired placeholder text
                 //    });
                 //    $('#subservice_table_change_div').hide();
                }
            });
         // alert(id);
        }

        function subservice_table_change() {
            var selectedValues = $("#sub_service").val();

            var url = '{{ url('subservice_table_change') }}';
            // alert(url);
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "subservice_id": selectedValues,
                    "subs_id":subs_id
                },
                success: function(msg) {
                 if(msg != ''){
                     document.getElementById('subservice_table_change_div').innerHTML = msg;
                    $('#subservice_table_change_div').show();
                    $('#moving_change_div').show();
                 }else{
                     $('#subservice_table_change_div').hide();
                     $('#moving_change_div').hide();
                 }
                    
                }
            });
        }
    </script>

    <script>
        function category_validation() {

            var walletAmount = {!! json_encode($wallet_amount->wallet_amount) !!};
            if (walletAmount == 0) {
                // Display an error message for zero wallet amount
                jQuery('#validate').html("Your Wallet amount is zero");
                jQuery('#validate').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#validate').offset().top - 150
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

            if(country != '22'){
                 $('#state_div').show();
                 var state = jQuery("#state").val();
                 if (state == '') {
                     jQuery('#state_error').html("Please Select State");
                     jQuery('#state_error').show().delay(0).fadeIn('show');
                     jQuery('#state_error').show().delay(2000).fadeOut('show');
                     $('html, body').animate({
                         scrollTop: $('#state').offset().top - 150
                     }, 1000);
                     return false;
                 }
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

            var selectedValues = $("#services").val();
            if (selectedValues == '') {
                jQuery('#services_error').html("Please Select Service");
                jQuery('#services_error').show().delay(0).fadeIn('show');
                jQuery('#services_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#services').offset().top - 150
                }, 1000);
                return false;
            }

            var sub_service = $("#sub_service").val();
            if (sub_service == '') {
                jQuery('#sub_service_error').html("Please Select Sub Service");
                jQuery('#sub_service_error').show().delay(0).fadeIn('show');
                jQuery('#sub_service_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#sub_service').offset().top - 150
                }, 1000);
                return false;
            }


            var totalPrice = $("#total").val();

         //    alert(totalPrice);
         //    alert(walletAmount);
            if (totalPrice > walletAmount) {
                jQuery('#validate').html("Wallet amount should be greater than total price");
                jQuery('#validate').show().delay(0).fadeIn('show');
                jQuery('#validate').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#validate').offset().top - 150
                }, 1000);
                return false;
            }



            $('#spinner_button').show();
            $('#submit_button').hide();

            $('#category_form_new').submit();
        }

        $("#services").select2({
            placeholder: "Select a service" // Replace with your desired placeholder text
        });
        $("#sub_service").select2({
            placeholder: "Select a Sub service" // Replace with your desired placeholder text
        });
        $("#country").select2({
            placeholder: "Select Country" // Replace with your desired placeholder text
        });
        $("#continents").select2({
                placeholder: "Select Continents"
        });

        $("#to_country").select2({
            placeholder: "Select Moving to Country"
        });


        function toggleDiv(val){
         //alert(val);
         if(val == 0){
                $('#packageDiv').show();
                $('#subservice_table_change_div').hide();
                $('#moving_change_div').hide();
            }else if(val == 2){
                $('#packageDiv').show();
                $('#subservice_table_change_div').hide();
                $('#moving_change_div').hide();
            }else{
                $('#packageDiv').hide();
                $('#subservice_table_change_div').show();
                $('#moving_change_div').show();
            }
        }

        function updateTotal_package(){

             var no_of_inquiry_package = $('#no_of_inquiry_package').val();
             var price_package = $('#price_package').val();

             // var finalprice = (no_of_inquiry_package) * price_package;
             var finalprice = price_package;

             $('#total_package').val(finalprice);

             document.getElementById('replace_final_price_package').innerText = finalprice.toFixed(2);
        }
    </script>
     @if(isset($_GET['subs_id']) && !empty($_GET['subs_id']) && intval($_GET['subs_id']) > 0)
     <script>
         $(document).ready(function() {
             // Get the current country value and trigger state_change to populate states
             var continent_id = $('#continent').val();
             to_country_change(continent_id);

             var service_id = $('#services').val();
             subservice_change(service_id);

             // var subservice_id = $('#sub_service').val();
             // subservice_table_change(subservice_id);

             setTimeout(function() {
             subservice_table_change();
         }, 1000);


             });
     </script>
 @endif
 

@if(isset($_GET['subs_id']) && !empty($_GET['subs_id']) && intval($_GET['subs_id']) > 0)

@php
    $s_data = DB::table('subscription_international_move_attribute')
                ->where('subscription_id', $_GET['subs_id'])
                ->get()->toArray();

                // echo"<pre>";print_r($s_data);echo"</pre>";exit;
@endphp

@if(!empty($s_data))
    @foreach($s_data as $s_data_new)
        <script>
            $(document).ready(function() {
                let form_id_new = '{{ $s_data_new->form_id }}';
                let form_attributes_id_subs_new = '{{ $s_data_new->form_attributes_id }}';
                let more_form_attributes_id_subs_new = '{{ $s_data_new->more_form_attributes_id }}';

                // alert(form_id_new);
                // alert(form_attributes_id_subs_new);
                // alert(more_form_attributes_id_subs_new);

                setTimeout(function() {

                    updateTotal_new_international(form_id_new, form_attributes_id_subs_new, more_form_attributes_id_subs_new);

            }, 1500);
            });
        </script>
    @endforeach
@endif

@endif


<script>
    $(document).ready(function() {

setTimeout(function() {

    var selected_package_type = document.querySelector('input[name="type_of_subscription"]:checked');
    //alert(selected_package_type.value);
        toggleDiv(selected_package_type.value); // Call on page load

    }, 2000); 
    });    
</script>


@stop
