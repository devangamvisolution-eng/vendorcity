@extends('admin.includes.Template')
<link rel="stylesheet" href="{{ asset('public/site/css/intlTelInput.css') }}">

   <script src="{{ asset('public/site/js/intlTelInput.min.js') }}"></script>
@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Edit Customer User</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('frontuser.index') }}">Edit Customer User</a></li>

                        <li class="breadcrumb-item active">Edit Customer User</li>

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

                        <form id="category_form" action="{{ route('frontuser.update', $frontuser_data->id) }}" method="POST">

                            @csrf
                            @method('PUT')

                            <div class="row">






                                <div class="form-group">

                                    <label for="name">Name</label>

                                    <input id="name" name="name" type="text" class="form-control"

                                        placeholder="Enter Name" value="{{ $frontuser_data->name }}" />
                                <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>

                                @error('name')
                                    <p class="form-error-text" id="" style="color: red; margin-top: 10px;">{{$message}}</p>
                                @enderror

                                </div>
                                <div class="form-group">

                                    <label for="name">Email</label>

                                    <input id="email" name="email" type="email" class="form-control"

                                        placeholder="Enter Email" value="{{ $frontuser_data->email }}" />
                                <p class="form-error-text" id="email_error" style="color: red; margin-top: 10px;"></p>
                                @error('email')
                                    <p class="form-error-text" id="" style="color: red; margin-top: 10px;">{{$message}}</p>
                                @enderror
                                </div>

                                <div class="form-group mobile_div">

                                    <label for="name">Mobile</label>
									<input type="hidden" name="country_code_user" id="country_code_user" class="country_code_user" value="{{ $frontuser_data->country_code }}">
                                    <input id="mobile" name="mobile" type="text" class="form-control company-phone"

                                        placeholder="Enter Mobile" value="{{ $frontuser_data->mobile }}" pattern="[0-9]*" inputmode="numeric"/>
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
		
		function initializeIntlTelInput(input) {
    if (!input || input.classList.contains('iti-initialized')) return;

    const hiddenInput = input.closest(".mobile_div").querySelector(".country_code_user");
    const savedDialCode = hiddenInput ? hiddenInput.value : null;

    const iti = window.intlTelInput(input, {
        initialCountry: savedDialCode ? getCountryCodeFromDialCode(savedDialCode) : "ae",
        separateDialCode: true,
        nationalMode: false,
        preferredCountries: ["in", "ae", "us", "gb"],
        autoPlaceholder: "off",
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });

    input.classList.add("iti-initialized");

    // Update hidden input when country changes
    function updateDialCode() {
        if (hiddenInput) hiddenInput.value = iti.getSelectedCountryData().dialCode;
    }

    updateDialCode(); // set initial value
    input.addEventListener("countrychange", updateDialCode);
}

// Helper: convert dial code to ISO code
function getCountryCodeFromDialCode(dialCode) {
    const countryData = window.intlTelInputGlobals.getCountryData();
    for (let i = 0; i < countryData.length; i++) {
        if (countryData[i].dialCode == dialCode) return countryData[i].iso2;
    }
    return "ae"; // fallback
}

// Initialize all phone inputs on page load
$(document).ready(function() {
    $(".company-phone").each(function() {
        initializeIntlTelInput(this);
    });
});

    </script>

@stop

