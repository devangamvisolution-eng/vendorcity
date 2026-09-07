   @extends('admin.includes.Template')
   @section('content')


       <div class="content container-fluid">

           <!-- Page Header -->
           <div class="page-header">
               <div class="row">
                   <div class="col-sm-12">
                       <h3 class="page-title">Edit Subscription </h3>
                       <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                           <li class="breadcrumb-item"><a href="{{ route('base_on_service_lead', ['id' => $id]) }}">Subscription</a>
                           </li>
                           <li class="breadcrumb-item active">Edit Subscription</li>
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
               $wallet_amount = DB::table('users')->where('id', $vendor_id)->first();
               //    echo '<pre>';
               //    print_r($amount);
               //    echo '</pre>';
           @endphp
           <div class="row">
               <div class="col-md-12">
                   <div class="card">
                       <div class="card-body">
                           <!-- <h4 class="card-title">Category</h4> -->
                           <form action="{{ route('edit_subscription', ['id' => $id]) }}" id="category_form_new"
                               method="POST" enctype="multipart/form-data">
                               
                               <input type="hidden" name="action" id="subscription_id" value="add">

                               <input type="hidden" name="id" id="subscription_id" value="{{ $id }}">


                               @csrf
                               <div class="row">

                                <div class="col-md-4">

                                   <div class="form-group">
                                       <label for="country">Country</label>
                                       <select class="form-control" id="country" name="country"
                                           onchange="state_change(this.value);" disabled>
                                           <option value="">Select country</option>
                                           @foreach ($country_data as $country)
                                               <option value="{{ $country->id }}" @if($country->id == $subscription_data->country) {{ 'selected' }} @endif>{{ $country->country }}</option>
                                           @endforeach
                                       </select>
                                       <p class="form-error-text" id="country_error" style="color: red; margin-top: 10px;">
                                       </p>
                                   </div>
                                   </div>
                                   <div class="col-md-4" id="state_div" style="display: block">
                                   <div class="form-group" >
                                       <label for="state">State</label>
                                       <span id="state_chang">
                                           <select class="form-control" id="state" name="state"
                                                disabled>
                                               <option value="">Select State</option>
                                               @foreach ($state_data as $state)
                                                   <option value="{{ $state->id }}" @if($state->id == $subscription_data->state) {{ 'selected' }} @endif>{{ $state->state }}</option>
                                               @endforeach
                                           </select>
                                       </span>
                                       <p class="form-error-text" id="state_error" style="color: red; margin-top: 10px;">
                                       </p>
                                   </div>
                                   </div>
                                   <div class="col-md-4">
                                    @php
                                        $city_array = explode(',',$subscription_data->city);
                                    @endphp
                                   <div class="form-group">
                                       <label for="city">City</label>
                                       <span id="city_chang">
                                           <select class="form-control" id="city" name="city[]" multiple="multiple" disabled>
                                               <option value="">Select City</option>
                                               @foreach ($allcity as $city)
                                                   <option value="{{ $city->id }}" @if(in_array($city->id,$city_array)) {{ 'selected' }} @endif>{{ $city->name }}</option>
                                               @endforeach
                                           </select>
                                       </span>
                                       <p class="form-error-text" id="city_error" style="color: red; margin-top: 10px;"></p>
                                   </div>
                                   </div>
                                   <div class="col-md-12">
                                    @php
                                        $services_array = explode(',',$subscription_data->services);
                                    @endphp
                                   <div class="form-group">
                                       <label for="city">Services</label>
                                       <select class="form-control" id="services" name="services[]" multiple="multiple"
                                           onchange="subservice_change(this.value);" disabled>
                                           <option value="">Select Services</option>
                                           @foreach ($allservices as $services)
                                               <option value="{{ $services->id }}" @if(in_array($services->id,$services_array)) {{ 'selected' }} @endif>{{ $services->servicename }}</option>
                                           @endforeach
                                       </select>
                                       <p class="form-error-text" id="services_error" style="color: red; margin-top: 10px;">
                                       </p>
                                   </div>
                                   </div>
                                   <div class="col-md-12">
                                    @php
                                        $sub_services_array = explode(',',$subscription_data->sub_service);
                                    @endphp
                                   <div class="form-group">
                                       <label for="city">Sub Services</label>
                                       <span id="subservice_option">
                                           <select class="form-control" id="sub_service" name="sub_service[]"
                                               multiple="multiple" disabled>
                                               <option value="">Select Sub Service</option>
                                               @foreach ($allsub_services as $subservices)
                                               <option value="{{ $subservices->id }}" @if(in_array($subservices->id,$sub_services_array)) {{ 'selected' }} @endif>{{ $subservices->subservicename }}</option>
                                           @endforeach
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
                                                <input type="radio" name="type_of_subscription" value="0" onclick="toggleDiv(this.value)" disabled @if($subscription_data->type_of_subscription == 0) {{ 'checked' }} @endif> Package
                                            </label>
                                        </div>
                                        <div class="radio" style="width: 10%;display: inline-block;">
                                            <label>
                                                <input type="radio" name="type_of_subscription" value="1" onclick="toggleDiv(this.value)" disabled @if($subscription_data->type_of_subscription == 1) {{ 'checked' }} @endif> Leads
                                            </label>
                                        </div>

                                        <div class="radio" style="width: 30%;display: inline-block;">
                                            <label>
                                                <input type="radio" name="type_of_subscription" value="2" onclick="toggleDiv(this.value)" disabled @if($subscription_data->type_of_subscription == 2) {{ 'checked' }} @endif> Auto Accept Package
                                            </label>
                                        </div>
                                        
                                    </div>
                                </div>

                                    <input type="hidden" name="hidden_type_of_package" value="{{ $subscription_data->type_of_subscription }}" id="hidden_type_of_package">

                                    <div id="packageDiv" style="display:none">


                                        {{-- <div class="form-group row">
                                            <label class="col-form-label col-md-12">Type of Package</label>
                                            <div class="col-md-10">
                                                <div class="type_of_package" style="width: 10%;display: inline-block;">
                                                    <label>
                                                        <input type="radio" name="type_of_package" value="0" @if($subscription_data->type_of_package == 0) {{ 'checked' }} @endif> Local
                                                    </label>
                                                </div>
                                                <div class="radio" style="width: 15%;display: inline-block;">
                                                    <label>
                                                        <input type="radio" name="type_of_package" value="1" @if($subscription_data->type_of_package == 1) {{ 'checked' }} @endif> International
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
                                                                    <input id='no_of_inquiry_package' name='no_of_inquiry_package' type='text' class='form-control no-of-inquiry-input' placeholder='Enter No Of Inquiry' value="{{ $subscription_data->no_of_inquiry_package }}" />
                                                                </td>
                                                                <td>
                                                                    <input id='price_package' name='price_package' type='text' class='form-control price-input' placeholder='Enter Price' value="{{ $subscription_data->price_package }}" />

                                                                    <input id='price_package_old' name='price_package_old' type='hidden' class='form-control price-input' placeholder='Enter Price' value="{{ $subscription_data->price_package }}" />
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

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="invoice-table table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Sub Services</th>
                                                            <th class="text-end">Number of Leads</th>
                                                            <th class="text-end">Price</th>
                                                            <th class="text-end">Final Price</th>
                                                        </tr>
                                                    </thead>
                                                    @php
                                                        $subscription_subservice_attribute = DB::table('subscription_subservice_attribute')->where('subscription_id',$id)->get()->toArray();
                                                        // echo"<pre>";print_r($subscription_subservice_attribute);echo"</pre>";
                                                    @endphp
                                                    <tbody>
                                                        @php
                                                            $total = 0;
                                                        @endphp

                                                        @if(!empty($subscription_subservice_attribute))
                                                        @foreach($subscription_subservice_attribute as $subscription_subservice_attribute_data)

                                                        <input type="hidden" name="subscription_subservice_attribute_id[]" value="{{ $subscription_subservice_attribute_data->id }}" id="subscription_subservice_attribute_id">
                                                        <tr>
                                                            {{-- <td>{{ $subscription_subservice_attribute_data->service_id }}</td> --}}
                                                            <td>{!! Helper::subservicename($subscription_subservice_attribute_data->subservice_id) !!}</td>
                                                            <td><input class="form-control no-of-inquiry-input" type="number" id="no_of_inquiry_{{ $subscription_subservice_attribute_data->id }}" name="no_of_inquiry_{{ $subscription_subservice_attribute_data->id }}" value="{{ $subscription_subservice_attribute_data->no_of_inquiry }}" oninput="updateTotal_new('{{ $subscription_subservice_attribute_data->id  }}')"></td>
                                                            <td><input class="form-control no-of-inquiry-input" type="number" name="price_{{ $subscription_subservice_attribute_data->id }}" id="price_{{ $subscription_subservice_attribute_data->id }}" value="{{ $subscription_subservice_attribute_data->charge }}" oninput="updateTotal_new('{{ $subscription_subservice_attribute_data->id  }}')"></td>
                                                            <td><span id="replace_final_price_{{ $subscription_subservice_attribute_data->id }}">{{ round($subscription_subservice_attribute_data->no_of_inquiry * $subscription_subservice_attribute_data->charge) }}</span><input id='finalprice_{{ $subscription_subservice_attribute_data->id }}' name='finalprice[]' type='hidden' value='{{ round($subscription_subservice_attribute_data->no_of_inquiry * $subscription_subservice_attribute_data->charge) }}' /></td>
                                                            
                                                        </tr>
                                                        @php
                                                            $final_price = $subscription_subservice_attribute_data->no_of_inquiry * $subscription_subservice_attribute_data->charge;

                                                            $total += $final_price;
                                                        @endphp
                                                        @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                                <div class="col-md-6 col-xl-4 ms-auto">
                                                    <div class="table-responsive">
                                                        <table class="invoice-table-two table">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Total :</th>
                                                                    <td><span id="total-span">{{ $total }}</span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="total" id="total" value="{{ $total }}">
                                            </div>
                                        </div>
                                    </div>

                                   </div>

                                   <div class="col-lg-12" id="moving_change_div" style="display: none;">

                                    @if($subscription_data->type_of_package == 0)

                                    @php

                                        $local_move = DB::table('subscription_local_move_attribute')
                                                        ->where('subscription_id',$subscription_data->id)
                                                        ->get()->toArray();

                                    @endphp
                                    
                                    @if(!empty($local_move))
                                    <div class="table-responsive">
                                        <h5>Local Move</h5>
                                        <table class="invoice-table table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Package</th>
                                                    <th>Size of House</th>
                                                    <th>Rate/1 Lead</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($local_move as $local_move_data)

                                                @php

                                                $package_name = DB::table('form_attributes')
                                                                ->where('id',$local_move_data->form_attributes_id)
                                                                ->where('form_id',$local_move_data->form_id)->first();
                                                
                                                $size_of_house_name = DB::table('more_form_attributes')
                                                ->where('id',$local_move_data->more_form_attributes_id)
                                                ->where('attr_id',$local_move_data->form_attributes_id)
                                                ->where('form_id',$local_move_data->form_id)->first();

                                                @endphp

                                            @if(!empty($package_name))
                                                <input type="hidden" name="hidden_local_move_id[]" id="hidden_local_move_id" value="{{ $local_move_data->id }}" >
                                                <tr>
                                                    <td>{{ $package_name->form_option }}</td>
                                                    <td>{{ $size_of_house_name->more_form_option }}</td>
                                                    <td><input type="number" class="form-control" name="local_price_{{ $local_move_data->id }}" id="local_price_{{ $local_move_data->id }}" value="{{ $local_move_data->local_move_charge }}"></td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                    @endif


                                    @if($subscription_data->type_of_package == 1)

                                    @php

                                        $international_move = DB::table('subscription_international_move_attribute')
                                                        ->where('subscription_id',$subscription_data->id)
                                                        ->get()->toArray();

                                    @endphp
                                    
                                    @if(!empty($international_move))
                                    <div class="table-responsive">
                                        <h5>International Move</h5>
                                        <table class="invoice-table table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Package</th>
                                                    <th>Size of House</th>
                                                    <th>Rate/1 Lead</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($international_move as $international_move_data)

                                                @php

                                                $package_name = DB::table('form_attributes')
                                                                ->where('id',$international_move_data->form_attributes_id)
                                                                ->where('form_id',$international_move_data->form_id)->first();
                                                
                                                $size_of_house_name = DB::table('more_form_attributes')
                                                                        ->where('id',$international_move_data->more_form_attributes_id)
                                                                        ->where('attr_id',$international_move_data->form_attributes_id)
                                                                        ->where('form_id',$international_move_data->form_id)->first();

                                                @endphp

                                            @if(!empty($package_name))
                                                <input type="hidden" name="hidden_international_move_id[]" id="hidden_international_move_id" value="{{ $international_move_data->id }}" >
                                                <tr>
                                                    <td>{{ $package_name->form_option }}</td>
                                                    <td>{{ $size_of_house_name->more_form_option }}</td>
                                                    <td><input type="number" class="form-control" name="international_price_{{ $international_move_data->id }}" id="international_price_{{ $international_move_data->id }}" value="{{ $international_move_data->local_move_charge }}"></td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                    @endif

                                   </div>

                                   <input type="hidden" name="final_total_new" id="final_total_new" value="">

                               </div>
                               <div class="text-end mt-4">
                                   <a class="btn btn-primary" href="{{ route('vendors.subscription', $vendor_id) }}"> Back</a>
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
         $("#services").select2({
               placeholder: "Select a service" // Replace with your desired placeholder text
           });
           $("#city").select2({
               placeholder: "Select a City" // Replace with your desired placeholder text
           });

           $("#sub_service").select2({
               placeholder: "Select a Sub service" // Replace with your desired placeholder text
           });

           function state_change(country_id) {

            if(country_id == '22'){
                $('#state_div').hide();
                
            }else{
                $('#state_div').show();
            }

                // // alert(country_id);
                // var url = '{{ url('state_show_subscription') }}';
                // // alert(url);
                // $.ajax({
                //     url: url,
                //     type: 'post',
                //     data: {
                //         "_token": "{{ csrf_token() }}",
                //         "country_id": country_id
                //     },
                //     success: function(msg) {
                //         document.getElementById('state_chang').innerHTML = msg;
                //     }
                // });
            }

            function toggleDiv(){

            var val = $('#hidden_type_of_package').val();
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

           function updateTotal_new(sub_serviceid) {
                var no_of_inquiry = $('#no_of_inquiry_'+ sub_serviceid).val();
                var price = $('#price_'+ sub_serviceid).val();

                var finalprice = (no_of_inquiry) * price;
                document.getElementById('replace_final_price_'+ sub_serviceid).innerText = finalprice.toFixed(2);
                var price_final = $('#finalprice_'+ sub_serviceid).val(finalprice);


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

               
                //alert(no_of_inquiry);
            }

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

                $('#spinner_button').show();
                $('#submit_button').hide();
                $('#category_form_new').submit();

            }


            window.onload = function() {
            var country_id = $('#country').val();
            state_change(country_id);
            toggleDiv();
            };
       </script>
   @stop
