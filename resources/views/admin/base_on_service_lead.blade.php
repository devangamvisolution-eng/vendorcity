   @extends('admin.includes.Template')
   @section('content')


       <div class="content container-fluid">

           <!-- Page Header -->
           <div class="page-header">
               <div class="row">
                   <div class="col-sm-12">
                       <h3 class="page-title">Based on Services Leads</h3>
                       <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                           <li class="breadcrumb-item"><a href="{{ route('vendors.subscription', $id) }}">Subscription</a>
                           </li>
                           <li class="breadcrumb-item active">Based on Services Leads</li>
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
                           <form action="{{ route('base_on_service_lead', ['id' => $id]) }}" id="category_form_new"
                               method="POST" enctype="multipart/form-data">
                               <input type="hidden" name="subscription_name" id="subscription_name"
                                   value="Based on Services Leads">
                               <input type="hidden" name="subscription_id" id="subscription_id" value="1">
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
                                       <label for="country">Country</label>
                                       <select class="form-control" id="country" name="country"
                                           onchange="state_change(this.value);">
                                           <option value="">Select country</option>
                                           @foreach ($country_data as $country)
                                               <option value="{{ $country->id }}" @if(!request()->has('subs_id') && $country->id == 22) 
                                                selected 
                                            @elseif(request()->has('subs_id') && in_array($country->id, $country_array)) 
                                                selected 
                                            @endif>{{ $country->country }}</option>
                                           @endforeach
                                       </select>
                                       <p class="form-error-text" id="country_error" style="color: red; margin-top: 10px;">
                                       </p>
                                   </div>

                                   <div class="form-group" id="state_div" style="display: block">
                                       <label for="state">State</label>
                                       <span id="state_chang">
                                           <select class="form-control" id="state" name="state"
                                               onchange="city_change(this.value);">
                                               <option value="">Select State</option>
                                               {{-- @foreach ($state_data as $state)
                                                   <option value="{{ $state->id }}">{{ $state->state }}</option>
                                               @endforeach --}}
                                           </select>
                                       </span>
                                       <p class="form-error-text" id="state_error" style="color: red; margin-top: 10px;">
                                       </p>
                                   </div>

                                   <div class="form-group">
                                       <label for="city">City</label>
                                       <span id="city_chang">
                                           <select class="form-control" id="city" name="city[]" multiple="multiple">
                                               <option value="">Select City</option>
                                               {{-- @foreach ($allcity as $city)
                                                   <option value="{{ $city->id }}">{{ $city->name }}</option>
                                               @endforeach --}}
                                           </select>
                                       </span>
                                       <p class="form-error-text" id="city_error" style="color: red; margin-top: 10px;"></p>
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


                                   <div class="col-md-12">
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

                                        <div class="col-lg-12" id="subservice_table_change_div">

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

                var finalPrices_local = document.getElementsByName('local_total[]');
                var total_local = 0;

                for (var i = 0; i < finalPrices_local.length; i++) {
                    total_local += parseFloat(finalPrices_local[i].value);
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


            function updateTotal_new_local(form_id,form_att_id,more_form_attributes_id) {

                var local_no_of_inquiry = $('#local_no_of_inquiry_'+ form_id + '_'+form_att_id +'_'+ more_form_attributes_id).val();

                // alert(local_no_of_inquiry);

                var local_move_charge = $('#local_move_charge_'+ form_id + '_'+form_att_id +'_'+ more_form_attributes_id).val();

                // alert(local_move_charge);
                
                var finalprice = (local_no_of_inquiry) * local_move_charge;
                // alert(finalprice);

                document.getElementById('replace_local_final_price_'+ form_id + '_'+form_att_id +'_'+ more_form_attributes_id).innerText = finalprice.toFixed(2);

               

                var price_final = $('#replace_hidden_local_final_price_'+ form_id + '_'+form_att_id +'_'+ more_form_attributes_id).val(finalprice);


                //var finalPrices = document.getElementsByName('local_finalprice_'+form_id+'_'+form_att_id+'[]');

                var finalPrices = document.getElementsByName('local_finalprice_' + form_id + '_' + form_att_id + '[]');


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

                document.getElementById('local-total-span_' + form_id + '_' + form_att_id).innerText = total.toFixed(2);
                //document.getElementById('local_total_'+form_id+'_'+form_att_id+'').value = total.toFixed(2);

                document.getElementById('local_total_' + form_id + '_' + form_att_id).value = total.toFixed(2);



                var finalPrices_local = document.getElementsByName('local_total[]');
                var total_local = 0;

                for (var i = 0; i < finalPrices_local.length; i++) {
                    total_local += parseFloat(finalPrices_local[i].value);
                }

                var inquiry_total = $('#total').val();

                var final_total = parseFloat(inquiry_total) + parseFloat(total_local);

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

           function state_change(country_id) {

            if(country_id == '22'){
                $('#state_div').hide();
                city_change(0);
            }else{
                $('#state_div').show();
            }
           
               // alert(country_id);
               var url = '{{ url('state_show_subscription') }}';
               // alert(url);
               $.ajax({
                   url: url,
                   type: 'post',
                   data: {
                       "_token": "{{ csrf_token() }}",
                       "country_id": country_id,
                       "subs_id": subs_id
                   },
                   success: function(msg) {
                       document.getElementById('state_chang').innerHTML = msg;
                        var state_id = $('#state').val();
                        city_change(state_id, country_id);
                   }
               });
           }

           function getQueryParam(param) {
                let urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
                }

                // Get subs_id from the URL (if it exists)
                let subs_id = getQueryParam('subs_id') || 0; // Use 0 as the default value

    function city_change(state_id,country_id) {
            // alert(country_id);
               var url = '{{ url('city_show') }}';
               // alert(url);
               $.ajax({
                   url: url,
                   type: 'post',
                   data: {
                       "_token": "{{ csrf_token() }}",
                       "state_id": state_id,
                       "country_id": country_id,
                       "subs_id": subs_id
                   },
                   success: function(msg) {
                       document.getElementById('city_chang').innerHTML = msg;
                       $("#city").select2({
                           placeholder: "Select a City" // Replace with your desired placeholder text
                       });
                   }
               });
           }

    function subservice_change() {
            var selectedValues = $("#services").val();
                //  alert(selectedValues);
               var url = '{{ url('subservice_change') }}';
               // alert(url);
               $.ajax({
                   url: url,
                   type: 'post',
                   data: {
                    // alert(subs_id);
                       "_token": "{{ csrf_token() }}",
                       "service_id": selectedValues,
                       "service_onload_id": selectedValues,
                       "subs_id":subs_id

                   },
                   success: function(msg) {
                    // alert(msg);
                       document.getElementById('subservice_option').innerHTML = msg;

                       chnage_moving_price(selectedValues);

                       $("#sub_service").select2({
                           placeholder: "Select a Sub service" // Replace with your desired placeholder text
                       });
                       $('#subservice_table_change_div').hide();
                   }
               });

               //alert(selectedValues);
           }

     function chnage_moving_price(id){

            var url = '{{ url('chnage_moving_price') }}';

            $.ajax({
                   url: url,
                   type: 'post',
                   data: {
                       "_token": "{{ csrf_token() }}",
                       "service_id": id,
                       "subs_id": subs_id
                   },
                   success: function(msg) {

                    // alert(msg);

                    document.getElementById('moving_change_div').innerHTML = msg;
                    // $('#moving_change_div').show();
                    //    document.getElementById('subservice_option').innerHTML = msg;

                    //    chnage_moving_price(selectedValues);

                    //    $("#sub_service").select2({
                    //        placeholder: "Select a Sub service" // Replace with your desired placeholder text
                    //    });
                    //    $('#subservice_table_change_div').hide();
                   }
               });
            // alert(id);
           }

           function subservice_table_change(){
               var selectedValues = $("#sub_service").val();
              // alert(selectedValues);
               var url = '{{ url('subservice_table_change') }}';
                // alert(url);
               $.ajax({
                   url: url,
                   type: 'post',
                   data: {
                       "_token": "{{ csrf_token() }}",
                       "subservice_id": selectedValues,
                       "sub_service_onload_id": selectedValues,
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

            // var type_of_subscription = jQuery('#type_of_subscription').val();
            var radio_type = jQuery("#radio_type").val();
            
            // alert(radio_type);exit;
            var walletAmount = {!! json_encode($wallet_amount->wallet_amount) !!};

            if(radio_type === 0){
                
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

               var finalprice = $("#total_package").val();

                // $('#total_package').val(finalprice);

            //    alert(walletAmount);
            //    alert(finalprice);exit;
               if (finalprice > walletAmount) {

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
           $("#city").select2({
               placeholder: "Select a City" // Replace with your desired placeholder text
           });

           $("#sub_service").select2({
               placeholder: "Select a Sub service" // Replace with your desired placeholder text
           });
        //    $("#country").select2({
        //        placeholder: "Select Country" // Replace with your desired placeholder text
        //    });
        
            

           function toggleDiv(val){

            // alert(val);
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

                var finalPriceElement = document.getElementById('replace_final_price_package');

                if (finalPriceElement && !isNaN(finalprice)) {
                    finalPriceElement.innerText = finalprice.toFixed(2);
                } else if (finalPriceElement) {
                    finalPriceElement.innerText = '0.00';
                }
           }

           
         
           

            // function updateTotal_new_local(form_id,form_att_id,more_form_attributes_id){}

            $(document).ready(function() {
            // Get the current country value and trigger state_change to populate states
            var country_id = $('#country').val();
            state_change(country_id);

            // Once states are populated, call city_change based on the selected state
            $(document).on('change', '#state', function() {
                var state_id = $(this).val();
                city_change(state_id, country_id);
            });

            // Trigger subservice_change
            subservice_change();

            // Check if 'subs_id' is set and valid, then execute subservice_table_change
            <?php if (isset($_GET['subs_id']) && !empty($_GET['subs_id']) && intval($_GET['subs_id']) > 0): ?>
                setTimeout(function() {
                    subservice_table_change();
                }, 1000); // 1000 milliseconds = 1 second
            <?php endif; ?>
        });

          

        

      
       </script>

@if(isset($_GET['subs_id']) && !empty($_GET['subs_id']) && intval($_GET['subs_id']) > 0)

@php
    $s_data = DB::table('subscription_local_move_attribute')
                 ->where('subscription_id', $_GET['subs_id'])
                 ->get()->toArray();
@endphp

@if(!empty($s_data))
    @foreach($s_data as $s_data_new)
        <script>
            $(document).ready(function() {
                let form_id_new = '{{ $s_data_new->form_id }}';
                let form_attributes_id_subs_new = '{{ $s_data_new->form_attributes_id }}';
                let more_form_attributes_id_subs_new = '{{ $s_data_new->more_form_attributes_id }}';

                setTimeout(function() {

                updateTotal_new_local(form_id_new, form_attributes_id_subs_new, more_form_attributes_id_subs_new);

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
