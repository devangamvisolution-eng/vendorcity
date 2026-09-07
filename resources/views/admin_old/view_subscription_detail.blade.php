   @extends('admin.includes.Template')
   @section('content')


       <div class="content container-fluid">

           <!-- Page Header -->
           <div class="page-header">
               <div class="row">
                   <div class="col-sm-12">
                       <h3 class="page-title">View Subscription Detail </h3>
                       <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{ url('/vendors') }}">Dashboard</a></li>
                           <li class="breadcrumb-item"><a href="{{ route('subscription-details.index') }}">Subscription Details</a></li>
                           <li class="breadcrumb-item active">View Subscription Detail</li>
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

           <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
               <span id="login_error"></span>
               <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
           </div>

           @php
           //echo "<pre>";print_r($all_data);echo "</pre>";
           @endphp

           <div class="row">
               <div class="col-md-12">
                   <div class="card">
                       <div class="card-body">
                           <!-- <h4 class="card-title">Category</h4> -->
                           <form action="{{ route('base_on_service_lead', ['id' => $id]) }}" id="category_form_new" method="POST"
                               enctype="multipart/form-data">
                               <input type="hidden" name="subscription_name" id="subscription_name" value="Based on Services Leads">
                               <input type="hidden" name="subscription_id" id="subscription_id" value="1">
                               <input type="hidden" name="action" id="subscription_id" value="add">

                               @csrf
                               <div class="row">

                                 @if($all_data->country != '' && $all_data->country != '0')
                                  <div class="form-group">
                                       <label for="country">Country</label>
                                       <select class="form-control" id="country" name="country" disabled >
                                           <option value="">Select country</option>
                                           @foreach ($country_data as $country)
                                               <option value="{{ $country->id }}" {{ $country->id == $all_data->country ? "selected" : "" }}>{{ $country->country }}</option>
                                           @endforeach
                                       </select>
                                        <p class="form-error-text" id="country_error" style="color: red; margin-top: 10px;"></p>
                                   </div>
                                @endif

                                @if($all_data->state != '' && $all_data->state != '0')
                                <div class="form-group">
                                       <label for="state">State</label>
                                       <span id="state_chang">
                                           <select class="form-control" id="state" name="state" disabled>
                                               <option value="">Select State</option>
                                               @foreach ($state_data as $state)
                                                   <option value="{{ $state->id }}" {{ $state->id == $all_data->state ? "selected" : "" }}>{{ $state->state }}</option>
                                               @endforeach
                                           </select>
                                       </span>
                                       <p class="form-error-text" id="state_error" style="color: red; margin-top: 10px;"></p>
                                   </div>
                                   @endif
                                   @if($all_data->city != '' && $all_data->city != '0')
                                   <div class="form-group">
                                    <label for="city">City</label>
                                    <span id="city_chang">
                                        <select class="form-control" id="city" name="city" disabled>
                                        <option value="">Select City</option>
                                        @foreach($allcity as $city)
                                        <option value="{{$city->id}}" {{ $city->id == $all_data->city ? "selected" : "" }}>{{$city->name}}</option>
                                        @endforeach
                                        </select>
                                    </span>
                                    <p class="form-error-text" id="city_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                @endif

                                 @if($all_data->services != '')
                                 @php
                                    $service_array = explode(',',$all_data->services);
                                 @endphp
                                <div class="form-group">
                                    <label for="city">Services</label>
                                        <select class="form-control" id="services" name="services[]" multiple="multiple" disabled>
                                        <option value="">Select Services</option>
                                        @foreach($allservices as $services)
                                        <option value="{{$services->id}}" @php  if(in_array($services->id, $service_array)) {echo "selected";} @endphp>{{$services->servicename}}</option>
                                        @endforeach
                                        </select>
                                    <p class="form-error-text" id="services_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                 @endif

                                 @if($all_data->sub_service != '')
                                 @php
                                    $sub_service_array = explode(',',$all_data->sub_service);
                                 @endphp
                                  <div class="form-group">
                                    <label for="city">Sub Services</label>
                                    <span id="subservice_option">
                                        <select class="form-control" id="sub_service" name="sub_service[]" multiple="multiple" disabled>
                                        <option value="">Select Sub Service</option>
                                        
                                                @foreach($allsub_services as $subservices_data)
                                        <option value="{{$subservices_data->id}}" @php  if(in_array($subservices_data->id, $sub_service_array)) {echo "selected";} @endphp>{{$subservices_data->subservicename}}</option>
                                        @endforeach
                                       
                                       
                                        </select>
                                         </span>
                                    <p class="form-error-text" id="sub_service_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                @endif

                                {{-- <div class="form-group">
                                       <label for="country">Subscription Name</label>
                                       <input type="text" name="subscription_name" id="subscription_name" value="{{$all_data->subscription_name}}" class="form-control" readonly>
                                        <p class="form-error-text" id="country_error" style="color: red; margin-top: 10px;"></p>
                                </div> --}}

                                {{-- <div class="form-group">
                                       <label for="country">Subscription Price</label>
                                       <input type="text" name="total" id="total" value="{{$all_data->total}}" class="form-control" readonly>
                                        <p class="form-error-text" id="country_error" style="color: red; margin-top: 10px;"></p>
                                </div> --}}

                                @php

                                $startdate = date('Y-m-d', strtotime($all_data->startdate));
                                @endphp

                                <div class="form-group">
                                       <label for="country">Subscription Start Date</label>
                                       <input type="date" name="startdate" id="startdate" value="{{$startdate}}" class="form-control" readonly>
                                        <p class="form-error-text" id="country_error" style="color: red; margin-top: 10px;"></p>
                                </div>

                                @php

                                $enddate = date('Y-m-d', strtotime($all_data->enddate));
                                @endphp

                                <div class="form-group">
                                       <label for="country">Subscription End Date</label>
                                       <input type="date" name="enddate" id="enddate" value="{{$enddate}}" class="form-control" readonly>
                                        <p class="form-error-text" id="country_error" style="color: red; margin-top: 10px;"></p>
                                </div>



                               </div>

                               <div class="text-end mt-4">
                                   <a class="btn btn-primary" href="{{ route('subscription-details.index') }}"> Back</a>
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

    function city_change(state_id){
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
            }
        });
    }

    function subservice_change(value){
        var selectedValues = $("#services").val();

        var url = '{{ url('subservice_change') }}';
        // alert(url);
        $.ajax({
            url: url,
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "service_id": selectedValues
            },
            success: function(msg) {
                document.getElementById('subservice_option').innerHTML = msg;

                $("#sub_service").select2({
              placeholder: "Select a Sub service" // Replace with your desired placeholder text
            });
                $('#subservice_table_change_div').hide();
                            }
        });

        //alert(selectedValues);
    }

    function subservice_table_change(){
        var selectedValues = $("#sub_service").val();

        var url = '{{ url('subservice_table_change') }}';
        // alert(url);
        $.ajax({
            url: url,
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "subservice_id": selectedValues
            },
            success: function(msg) {
                document.getElementById('subservice_table_change_div').innerHTML = msg;
                $('#subservice_table_change_div').show();
            }
        });
    }


       </script>

       <script>
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

            //alert(selectedValues);


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
       </script>

       

   @stop
