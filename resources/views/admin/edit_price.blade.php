@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Vendor Listing Price</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('price.edit', 1) }}">Vendor Listing Price</a></li>

                        <li class="breadcrumb-item active">Vendor Listing Price</li>

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



        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <!-- <h4 class="card-title">Basic Info</h4> -->

                        <form id="category_form" action="{{ route('price.update', $price->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            @method('PUT')

                            <div class="row">


                                {{-- <h5>Based on Booking Services</h5>

                                <div class="col-lg-6">

                                    <div class="form-group">

                                        <label for="based_on_booking_service_label">Label</label>

                                        <input id="based_on_booking_service_label" name="based_on_booking_service_label"
                                            type="text" class="form-control" placeholder="Enter Label"
                                            value="{{ $price->based_on_booking_service_label }}" />
                                        <p class="form-error-text" id="based_on_booking_service_label_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div> --}}

                                {{-- <div class="col-lg-6">

                                    <div class="form-group">

                                        <label for="based_on_booking_service_price">Price</label>

                                        <input id="based_on_booking_service_price" name="based_on_booking_service_price"
                                            type="text" class="form-control" placeholder="Enter Price"
                                            value="{{ $price->based_on_booking_service_price }}"
                                            onkeypress="return validateNumber(event)" />
                                        <p class="form-error-text" id="based_on_booking_service_price"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div> --}}

                                <h5>Based on Listing Criteria</h5>

                                <div class="col-lg-6">

                                    <div class="form-group">

                                        <label for="based_on_listing_criteria_label">Label</label>

                                        <input id="based_on_listing_criteria_label" name="based_on_listing_criteria_label"
                                            type="text" class="form-control" placeholder="Enter Label"
                                            value="{{ $price->based_on_listing_criteria_label }}" />
                                        <p class="form-error-text" id="based_on_booking_service_label_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group">

                                        <label for="based_on_listing_criteria_price">Vendor Listing Price</label>

                                        <input id="based_on_listing_criteria_price" name="based_on_listing_criteria_price"
                                            type="text" class="form-control" placeholder="Enter Price"
                                            value="{{ $price->based_on_listing_criteria_price }}"
                                            onkeypress="return validateNumber(event)" />
                                        <p class="form-error-text" id="based_on_listing_criteria_price"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>


                            </div>

                            <div class="text-end mt-4">

                                <!-- <a class="btn btn-primary" href="{{ route('price.index') }}"> Cancel</a> -->



                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                                    Loading...

                                </button>



                                <button type="button" class="btn btn-primary" id="submit_button"
                                    onclick="javascript:category_validation()">Submit</button>

                                <!-- <input type="submit" name="submit" value="Submit" class="btn btn-primary"> -->

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
        function validateNumber(event) {

            var key = window.event ? event.keyCode : event.which;

            if (event.keyCode === 8 || event.keyCode === 46) {

                return true;

            } else if (key < 48 || key > 57) {

                return false;

            } else {

                return true;

            }

        }

        // var radioButtons = document.querySelectorAll('input[type="radio"][name="service_type"]');
        // function isRadioButtonSelected() {
        //     for (var i = 0; i < radioButtons.length; i++) {
        //         if (radioButtons[i].checked) {
        //             return true;
        //         }
        //     }
        //     return false;
        // }

        function category_validation() {

            //   if (!isRadioButtonSelected()) {

            //     jQuery('#service_error').html("Please Select Service Type");
            //     jQuery('#service_error').show().delay(0).fadeIn('show');
            //     jQuery('#service_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#serviceid').offset().top - 150
            //     }, 1000);
            //     return false;

            // }



            // var price = jQuery("#price").val();

            // if (price == '') {

            //     jQuery('#price_error').html("Please Enter Price");

            //     jQuery('#price_error').show().delay(0).fadeIn('show');

            //     jQuery('#price_error').show().delay(2000).fadeOut('show');

            //     return false;

            // }



            $('#spinner_button').show();

            $('#submit_button').hide();



            $('#category_form').submit();

        }
    </script>

@stop
