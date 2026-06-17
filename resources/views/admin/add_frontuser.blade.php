@extends('admin.includes.Template')
<link rel="stylesheet" href="{{ asset('public/site/css/intlTelInput.css') }}">

   <script src="{{ asset('public/site/js/intlTelInput.min.js') }}"></script>
@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Customer User</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('frontuser.index') }}">Customer User</a></li>

                        <li class="breadcrumb-item active">Add Customer User</li>

                    </ul>

                </div>

            </div>

        </div>

        <!-- /Page Header -->



        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">

            <span id="login_error"></span>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>



        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <!-- <h4 class="card-title">Basic Info</h4> -->

                        <form id="category_form" action="{{ route('frontuser.store') }}" method="POST">

                            @csrf

                            <div class="row">






                                <div class="form-group">

                                    <label for="name">Name</label>

                                    <input id="name" name="name" type="text" class="form-control"

                                        placeholder="Enter Name" value="{{ old('name') }}" />
                                <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>

                                @error('name')
                                    <p class="form-error-text" id="" style="color: red; margin-top: 10px;">{{$message}}</p>
                                @enderror

                                </div>
                                <div class="form-group">

                                    <label for="name">Email</label>

                                    <input id="email" name="email" type="email" class="form-control"

                                        placeholder="Enter Email" value="{{ old('email') }}" />
                                <p class="form-error-text" id="email_error" style="color: red; margin-top: 10px;"></p>
                                @error('email')
                                    <p class="form-error-text" id="" style="color: red; margin-top: 10px;">{{$message}}</p>
                                @enderror
                                </div>

                                <div class="form-group">

                                    <label for="name">Mobile</label>
									<input type="hidden" name="country_code_user" id="country_code_user" value="">
                                    <input id="mobile" name="mobile" type="text" class="form-control"

                                        placeholder="Enter Mobile" value="{{ old('mobile') }}" pattern="[0-9]*" inputmode="numeric"/>
                                <p class="form-error-text" id="mobile_error" style="color: red; margin-top: 10px;"></p>
                                @error('mobile')
                                    <p class="form-error-text" id="" style="color: red; margin-top: 10px;">{{$message}}</p>
                                @enderror
                                </div>

                               

                            </div>




                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('frontuser.index') }}"> Cancel</a>



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

        function category_validation() {



            var name = jQuery("#name").val();

            if (name == '') {
                jQuery('#name_error').html("Please Enter Name");
                jQuery('#name_error').show().delay(0).fadeIn('show');
                jQuery('#name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#name').offset().top - 150
                }, 1000);
                return false;
            }

            var email = jQuery("#email").val();

            if (email == '') {
                jQuery('#email_error').html("Please Enter email");
                jQuery('#email_error').show().delay(0).fadeIn('show');
                jQuery('#email_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#email').offset().top - 150
                }, 1000);
                return false;
            }

            var mobile = jQuery("#mobile").val();
            if (mobile == '') {
                jQuery('#mobile_error').html("Please Enter mobile");
                jQuery('#mobile_error').show().delay(0).fadeIn('show');
                jQuery('#mobile_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#mobile').offset().top - 150
                }, 1000);
                return false;
            }

            $('#spinner_button').show();

            $('#submit_button').hide();



            $('#category_form').submit();

        }
		
		document.addEventListener("DOMContentLoaded", function () {
        const Otpphoneinput = document.querySelector("#mobile");

        const Otpphoneinputnew = window.intlTelInput(Otpphoneinput, {
            initialCountry: "ae",  // UAE
            separateDialCode: true,
            autoPlaceholder: "aggressive",
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        // Assign globally
        window.Otpphoneinputnew = Otpphoneinputnew;

        // Update hidden country code when user selects a country
        const countryCodeInput = document.querySelector("#country_code_user");

        function setCountryCode() {
            const countryData = Otpphoneinputnew.getSelectedCountryData();
            countryCodeInput.value = countryData.dialCode; // store only dial code (e.g. 971)
            // If you want full ISO code (like 'AE') → use countryData.iso2
        }

        // Set default initially
        setCountryCode();

        // Listen to country change
        Otpphoneinput.addEventListener("countrychange", function () {
            setCountryCode();
        });
    });

    </script>

@stop

