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
                    <h3 class="page-title">Package Order - Moving</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Package Order - Moving</a></li>
                        <li class="breadcrumb-item active">Edit Package Order - Moving</li>
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

                        <form action="{{ route('moving_order_update', $order->order_id) }}" method="POST" id="form"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
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
                                                <option value="{{ $item->id }}" data-email="{{ $item->email }}"
                                                    data-name="{{ $item->name }}" data-phone = "{{ $item->mobile }}"
                                                    {{ $item->id == $order->user_id ? 'selected' : '' }}>
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
                                                <option value="{{ $item->id }}"
                                                    {{ isset($order->items[0]) && $item->id == $order->items[0]->subservice_id ? 'selected' : '' }}>
                                                    {{ $item->subservicename }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="subservice_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Payment Mode</label>
                                        <select id="payment_method" name="payment_method" class="form-control form-select">
                                            <option value="">Select</option>
                                            <option value="ONLINE"
                                                {{ isset($order->paymentmode) && $order->paymentmode == '2' ? 'selected' : '' }}>
                                                ONLINE</option>
                                            <option value="COD"
                                                {{ isset($order->paymentmode) && $order->paymentmode == '1' ? 'selected' : '' }}>
                                                COD</option>
                                        </select>
                                        <p class="form-error-text" id="payment_method_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-2 d-none">
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

                                <h4>Customer Details : </h4>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>First Name:</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name"
                                            placeholder="Enter First Name"
                                            value="{{ old('first_name', $shippingAddress->first_name ?? '') }}">
                                        <p class="form-error-text" id="first_name_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Last Name:</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name"
                                            placeholder="Enter Last Name"
                                            value="{{ old('last_name', $shippingAddress->last_name ?? '') }}">
                                        <p class="form-error-text" id="last_name_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                {{-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Country:</label>
                                        <select id="country" name="country" class="form-control form-select">
                                            <option value="">Select Country</option>
                                            @foreach ($country_data as $item)
                                                <option value="{{ $item->id }}" @selected(old('country', $shippingAddress->country ?? '') == $item->id)>
                                                    {{ $item->country }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="country_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Emirates:</label>
                                        <select id="emirates" name="emirates" class="form-control form-select">
                                            <option value="">Select Emirates</option>
                                            @foreach ($emiratesList as $emirate)
                                                <option value="{{ $emirate['name'] }}" data-id="{{ $emirate['id'] }}"
                                                    @selected(old('emirates', $shippingAddress->emirate ?? '') == $emirate['name'])>
                                                    {{ $emirate['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="emirates_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Area:</label>
                                        <input type="text" class="form-control" name="area" id="area"
                                            placeholder="Enter Area"
                                            value="{{ old('area', $shippingAddress->area ?? '') }}">
                                        <p class="form-error-text" id="area_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Street:</label>
                                        <input type="text" class="form-control" name="street" id="street"
                                            placeholder="Enter Street"
                                            value="{{ old('street', $shippingAddress?->address1 ?? '') }}">
                                        <p class="form-error-text" id="street_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Apartment/Villa No:</label>
                                        <input type="text" class="form-control" name="apartment_villa"
                                            id="apartment_villa" placeholder="Enter Apartment/Villa No"
                                            value="{{ old('apartment_villa', $shippingAddress?->address2 ?? '') }}">
                                        <p class="form-error-text" id="apartment_villa_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div> --}}

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Phone:</label>
                                        <input type="text" class="form-control" name="phone" id="phone"
                                            placeholder="Enter Phone"
                                            value="{{ old('phone', $shippingAddress->phone_number ?? '') }}">
                                        <p class="form-error-text" id="phone_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email Address:</label>
                                        <input type="text" class="form-control" name="email" id="email"
                                            placeholder="Enter Email Address"
                                            value="{{ old('email', $shippingAddress?->email_address ?? '') }}">
                                        <p class="form-error-text" id="email_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>When would you like to move ?</label>
                                        <input type="date" class="form-control" name="moving_date" id="moving_date"
                                            value="{{ old('moving_date', $order?->moving_date ?? '') }}">
                                        <p class="form-error-text" id="moving_date_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label>What time would you like to reschedule to ?</label>
                                        <div id="time_slot_change">
                                            <select id="time_slot" name="time_slot" class="form-control form-select">
                                                <option value="">Select Time Slot</option>

                                            </select>
                                            <p class="form-error-text" id="time_slot_error"
                                                style="color: red; margin-top: 10px;"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h4>Origin:/Pick up</h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group ">
                                                <label for="name">Address:</label>
                                                <input id="origin_add" name="origin_add" type="text"
                                                    class="form-control" value="{{ $order->items[0]->origin_add }}"
                                                    placeholder="Enter Origin Address" />
                                                @error('origin_add')
                                                    <p class="form-error-text text-danger">{{ $message }}</p>
                                                @enderror
                                                <p class="form-error-text" id="origin_add_error" style="color: red;"></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Country:</label>
                                                <select name="origin_country" id="origin_country"
                                                    class="form-control @error('origin_country') is-invalid @enderror">
                                                    <option value="">Select Country</option>
                                                    @foreach ($country_data as $country)
                                                        <option value="{{ $country->id }}"
                                                            {{ $order->items[0]->origin_country == $country->id ? 'selected' : '' }}>
                                                            {{ $country->country }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('origin_country')
                                                    <p class="form-error-text text-danger">{{ $message }}</p>
                                                @enderror
                                                <p class="form-error-text" id="origin_country_error" style="color: red;">
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">State:</label>
                                                <input id="origin_state" name="origin_state" type="text"
                                                    class="form-control" placeholder="Enter Origin State"
                                                    value="{{ $order->items[0]->origin_state }}" />
                                                @error('origin_state')
                                                    <p class="form-error-text text-danger">{{ $message }}</p>
                                                @enderror
                                                <p class="form-error-text" id="origin_state_error" style="color: red;">
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">City:</label>
                                                <input id="origin_city" name="origin_city" type="text"
                                                    class="form-control" value="{{ $order->items[0]->origin_city }}"
                                                    placeholder="Enter Origin City" />
                                                @error('origin_city')
                                                    <p class="form-error-text text-danger">{{ $message }}</p>
                                                @enderror
                                                <p class="form-error-text" id="origin_city_error" style="color: red;">
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Location:</label>
                                                <input id="origin_location" name="origin_location" type="text"
                                                    class="form-control" value="{{ $order->items[0]->origin_location }}"
                                                    placeholder="Enter Origin Location" />
                                                @error('origin_location')
                                                    <p class="form-error-text text-danger">{{ $message }}</p>
                                                @enderror
                                                <p class="form-error-text" id="origin_location_error"
                                                    style="color: red;"></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">ZIP/POST Code:</label>
                                                <input id="origin_zip_post" name="origin_zip_post" type="text"
                                                    class="form-control" value="{{ $order->items[0]->origin_zip_post }}"
                                                    placeholder="Enter Origin ZIP/POST Code" />
                                                @error('origin_zip_post')
                                                    <p class="form-error-text text-danger">{{ $message }}</p>
                                                @enderror
                                                <p class="form-error-text" id="origin_zip_post_error"
                                                    style="color: red;"></p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <h4>Destination:/Delivery</h4>
                                    <div class="form-group">
                                        <label for="name">Address:</label>
                                        <input id="desti_add" name="desti_add" type="text" class="form-control"
                                            value="{{ $order->items[0]->desti_add }}"
                                            placeholder="Enter Destination Address" />
                                        @error('desti_add')
                                            <p class="form-error-text text-danger">{{ $message }}</p>
                                        @enderror
                                        <p class="form-error-text" id="desti_add_error" style="color: red;"></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Country:</label>
                                        <select name="desti_country" id="desti_country"
                                            class="form-select select form-control" />
                                        <option value="">Select Country</option>
                                        @foreach ($country_data as $country)
                                            <option value="{{ $country->id }}"
                                                {{ $order->items[0]->desti_country == $country->id ? 'selected' : '' }}>
                                                {{ $country->country }}</option>
                                        @endforeach
                                        </select>
                                        @error('desti_country')
                                            <p class="form-error-text text-danger">{{ $message }}</p>
                                        @enderror
                                        <p class="form-error-text" id="desti_country_error" style="color: red;"></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">State:</label>
                                        <input id="desti_state" name="desti_state" type="text" class="form-control"
                                            value="{{ $order->items[0]->desti_state }}"
                                            placeholder="Enter Destination State" />
                                        @error('desti_state')
                                            <p class="form-error-text text-danger">{{ $message }}</p>
                                        @enderror
                                        <p class="form-error-text" id="desti_state_error" style="color: red;"></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">City:</label>
                                        <input id="desti_city" name="desti_city" type="text" class="form-control"
                                            value="{{ $order->items[0]->desti_city }}"
                                            placeholder="Enter Destination City" />
                                        @error('desti_city')
                                            <p class="form-error-text text-danger">{{ $message }}</p>
                                        @enderror
                                        <p class="form-error-text" id="desti_city_error" style="color: red;"></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Location:</label>
                                        <input id="desti_location" name="desti_location" type="text"
                                            class="form-control" value="{{ $order->items[0]->desti_location }}"
                                            placeholder="Enter Destination Location" />
                                        @error('desti_location')
                                            <p class="form-error-text text-danger">{{ $message }}</p>
                                        @enderror
                                        <p class="form-error-text" id="desti_location_error" style="color: red;"></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">ZIP/POST Code:</label>
                                        <input id="desti_zip_post" name="desti_zip_post" type="text"
                                            class="form-control" value="{{ $order->items[0]->desti_zip_post }}"
                                            placeholder="Enter Destination ZIP/POST Code" />
                                        @error('desti_zip_post')
                                            <p class="form-error-text text-danger">{{ $message }}</p>
                                        @enderror
                                        <p class="form-error-text" id="desti_zip_post_error" style="color: red;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Vat Charge Include</label>
                                        <select id="include_vat" name="include_vat" class="form-control form-select">
                                            <option value="">Select Vat Charge Include</option>
                                            <option value="yes"
                                                {{ $order->vatcharge != '' && $order->vatcharge != 0 ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="no"
                                                {{ $order->vatcharge == '' || $order->vatcharge == 0 ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                        <p class="form-error-text" id="include_vat_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Cash On Delivery Charge</label>
                                        <input type="text" name="cod_charge" id="cod_charge" class="form-control"
                                            placeholder="Enter Cash On Delivery Charge"
                                            value="{{ old('cod_charge', $order?->cod_charge ?? '0') }}">
                                        <p class="form-error-text" id="cod_charge_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Additional information:</label>
                                        <textarea class="form-control" name="additional_message" id="additional_message" rows="4" cols="50"
                                            placeholder="Please detail your job as much as you can">{!! old('additional_message', $shippingAddress?->additional_message ?? '') !!}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <a href="{{ route('order.index') }}" class="btn btn-primary text-light">Cancel</a>
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
        let codCharge = window.Enums.vcCharges.COD.value;
        let vatPercent = window.Enums.vcCharges.VAT_PERCENT.value;
    </script>
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

            if (!validatePackageFields()) {
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


            // for Package System Calculation
            package_calculation();



            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#form').submit();

        }

        /* $('#payment_method').on('change', function() {

            let payment_method = $(this).val();
            let charge_payment = 0;

            if (payment_method === 'COD') {
                charge_payment = codCharge;
            }

            $('#cod_charge').val(charge_payment);
        }); */
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

            $('#customer_id').on('change', function() {
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

        $(document).ready(function() {

            function loadSubserviceData(subservice_id) {

                if (!subservice_id) return;

                $('.add_to_cart').show();

                var selected_time_slot = "{{ isset($order->items[0]) ? $order->items[0]->time_slot : '' }}";
                var packageCategoryId =
                    "{{ isset($order->items[0]) ? $order->items[0]->packagecategory_id : '' }}";

                var existingCategories = @json($order->items->pluck('packagecategory_id') ?? []);


                $.ajax({
                    url: '{{ url('get-package-category') }}',
                    type: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "subservice_id": subservice_id,
                        "packageCategoryId": existingCategories[0],
                    },
                    success: function(msg) {
                        $('#package_category_change').html(msg);

                        $('#package_category').select2({
                            placeholder: 'Select Package Category',
                        });

                        get_package();
                        showPackageFields(true);
                    }
                });

                $.ajax({
                    url: '{{ url('get-time-slot') }}',
                    type: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "subservice_id": subservice_id,
                        "selected_time_slot": selected_time_slot
                    },
                    success: function(msg) {
                        $('#time_slot_change').html(msg);
                    }
                });
            }

            // On change (normal working)
            $('#subservice_id').change(function() {
                var subservice_id = $(this).val();
                loadSubserviceData(subservice_id);
            });

            // For edit page (auto trigger if value exists)
            var existingSubservice = $('#subservice_id').val();
            if (existingSubservice) {
                loadSubserviceData(existingSubservice);
            }

        });


        function get_package() {
            var selectedPackages = @json($order->items->pluck('package_id') ?? []) || $('#package').val() || [];
            var package_category = $('#package_category').val();
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
                    document.getElementById('package_change').innerHTML = msg;
                    $('#package').select2({
                        placeholder: 'Select Packages'
                    });


                    showPackageFields();
                    fillExistingPackageData();
                }
            });
        }

        function fillExistingPackageData() {
            var existingItems = @json($order->items ?? []);

            existingItems.forEach(item => {
                var qtyInput = $(`#${item.package_id}_quantity`);
                var priceInput = $(`#${item.package_id}_price`);

                // Only fill if the inputs exist and haven't been manually changed yet
                if (qtyInput.length && qtyInput.val() === "") {
                    qtyInput.val(item.quantity);
                }
                if (priceInput.length && priceInput.val() === "") {
                    priceInput.val(item.price);
                }
            });

            // Refresh calculations for subtotal/VAT
            package_calculation();
        }
    </script>

    <script>
        function package_calculation() {

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
            let code_charge = parseFloat($('#cod_charge').val());
            let sub_total = service_charge + code_charge;

            // Initialize vat_charge
            let vat_charge = 0;

            if (include_vat === 'yes') {
                vat_charge = sub_total * (vatPercent / 100);
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

        function showPackageFields(isEdit = false) {
            const packageSelect = document.getElementById('package');
            const packageFields = document.getElementById('package_fields');
            const selectedPackages = Array.from(packageSelect.selectedOptions).map(option => option.value);

            // Existing data from the controller
            const existingData = @json($order->items ?? []);

            selectedPackageIds = selectedPackages;

            // Remove fields for unselected packages
            const existingFields = packageFields.querySelectorAll('[data-package-id]');
            existingFields.forEach(field => {
                const packageId = field.getAttribute('data-package-id');
                if (!selectedPackages.includes(packageId)) {
                    field.remove();
                }
            });

            // Add fields for selected packages
            selectedPackages.forEach(packageId => {
                if (!document.querySelector(`[data-package-id="${packageId}"]`)) {
                    const packageName = packageSelect.querySelector(`option[value="${packageId}"]`).text;

                    // Find if this package has saved data in the database
                    const savedItem = existingData.find(item => item.package_id == packageId);
                    const savedQty = savedItem ? savedItem.package_quantity : '';
                    const savedPrice = savedItem ? savedItem.package_item_price : '';

                    const packageDiv = document.createElement('div');
                    packageDiv.className = 'col-12';
                    packageDiv.setAttribute('data-package-id', packageId);

                    packageDiv.innerHTML = `
                <div class="row align-items-center mb-3">
                    <div class="col-6">
                        <label>${packageName} - Quantity</label>
                        <input type="number" name="${packageId}_quantity" id="${packageId}_quantity" 
                               class="form-control" min="1" placeholder="Enter Quantity" value="${savedQty}">
                        <p class="form-error-text" id="${packageId}_quantity_error" style="color: red; margin-top: 10px;"></p>
                    </div>
                    <div class="col-6">
                        <label>${packageName} - Price</label>
                        <input type="number" name="${packageId}_price" id="${packageId}_price" 
                               class="form-control" min="0" step="0.01" placeholder="Enter Price" value="${savedPrice}">
                        <p class="form-error-text" id="${packageId}_price_error" style="color: red; margin-top: 10px;"></p>
                    </div>
                </div>
            `;
                    packageFields.appendChild(packageDiv);
                }
            });

            // Always recalculate totals when fields are generated
            package_calculation();
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
    <script>
        $(document).ready(function() {
            // Check for Error Message
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Try Again'
                });
            @endif
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
@stop
