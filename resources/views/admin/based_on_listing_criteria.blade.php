   @extends('admin.includes.Template')
   @section('content')


       <div class="content container-fluid">

           @php

               $price_data = DB::table('prices')
                   ->select('*')
                   ->orderBy('id', 'desc')
                   ->first();

               //echo "<pre>";print_r($price_data);echo "</pre>";

           @endphp

           <!-- Page Header -->
           <div class="page-header">
               <div class="row">
                   <div class="col-sm-12">
                       <!-- <h3 class="page-title">Add City</h3> -->
                       <h3 class="page-title">{{ $price_data->based_on_listing_criteria_label }}</h3>
                       <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{ url('/vendors') }}">Dashboard</a></li>
                           <li class="breadcrumb-item"><a href="{{ route('vendors.subscription', $id) }}">Subscription</a>
                           </li>
                           <li class="breadcrumb-item active">{{ $price_data->based_on_listing_criteria_label }}</li>
                       </ul>
                   </div>
               </div>
           </div>
           <!-- /Page Header -->

           <!--  <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
                   <span id="login_error"></span>
                   <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
               </div> -->


           <div class="row">
               <div class="col-md-12">
                   <div class="card">
                       <div class="card-body">
                           <!-- <h4 class="card-title">Category</h4> -->
                           <form action="{{ route('based_on_listing_criteria', ['id' => $id]) }}" id="category_form_new"
                               method="POST" enctype="multipart/form-data">

                               <input type="hidden" name="vendor_id" id="subscription_id" value="{{ $id }}">

                               <input type="hidden" name="subscription_id" id="subscription_id" value="3">
                               <input type="hidden" name="action" id="subscription_id" value="add">

                               @csrf
                               <div class="row">

                                <div class="form-group">
                                       <label for="country">Country</label>
                                       <select class="form-control" id="country" name="country"
                                           onchange="state_change(this.value);">
                                           <option value="">Select country</option>
                                           @foreach ($country_data as $country)
                                               <option value="{{ $country->id }}">{{ $country->country }}</option>
                                           @endforeach
                                       </select>
                                       <p class="form-error-text" id="country_error" style="color: red; margin-top: 10px;">
                                       </p>
                                   </div>

                                   <div class="form-group">
                                       <label for="state">State</label>
                                       <span id="state_chang">
                                           <select class="form-control" id="state" name="state"
                                               onchange="city_change(this.value);">
                                               <option value="">Select State</option>
                                               @foreach ($state_data as $state)
                                                   <option value="{{ $state->id }}">{{ $state->state }}</option>
                                               @endforeach
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
                                               @foreach ($allcity as $city)
                                                   <option value="{{ $city->id }}">{{ $city->name }}</option>
                                               @endforeach
                                           </select>
                                       </span>
                                       <p class="form-error-text" id="city_error" style="color: red; margin-top: 10px;"></p>
                                   </div>

                                   <div class="form-group">
                                       <label for="country">Subscription Name</label>
                                       <input type="text" name="subscription_name" id="subscription_name"
                                           value="{{ $price_data->based_on_listing_criteria_label }}" class="form-control"
                                           readonly>
                                       
                                       </p>
                                   </div>

                                   <div class="form-group">
                                       <label for="country">Subscription Price</label>
                                       <input type="text" name="total" id="total"
                                           value="{{ $price_data->based_on_listing_criteria_price }}" class="form-control"
                                           readonly>
                                      
                                   </div>

                               </div>
                               <div class="text-end mt-4">
                                   <a class="btn btn-primary" href="{{ route('vendors.subscription', $id) }}"> Back</a>
                                   <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                       style="display: none;">
                                       <span class="spinner-border spinner-border-sm" role="status"
                                           aria-hidden="true"></span>
                                       Loading...
                                   </button>
                                   <button type="button" class="btn btn-primary"
                                       onclick="javascript:category_validation()"id="submit_button">Buy Now</button>

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

        function state_change(country_id) {
               // alert(country_id);
               var url = '{{ url('state_show_subscription') }}';
               // alert(url);
               $.ajax({
                   url: url,
                   type: 'post',
                   data: {
                       "_token": "{{ csrf_token() }}",
                       "country_id": country_id
                   },
                   success: function(msg) {
                       document.getElementById('state_chang').innerHTML = msg;
                   }
               });
           }

           function city_change(state_id) {
               // alert(state_id);
               var url = '{{ url('city_show') }}';
               // alert(url);
               $.ajax({
                   url: url,
                   type: 'post',
                   data: {
                       "_token": "{{ csrf_token() }}",
                       "state_id": state_id
                   },
                   success: function(msg) {
                       document.getElementById('city_chang').innerHTML = msg;
                       $("#city").select2({
                           placeholder: "Select a City" // Replace with your desired placeholder text
                       });
                   }
               });
           }

           function category_validation() {

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


               $('#spinner_button').show();
               $('#submit_button').hide();

               $('#category_form_new').submit();
           }
           $("#city").select2({
               placeholder: "Select a City" // Replace with your desired placeholder text
           });

       </script>
   @stop
