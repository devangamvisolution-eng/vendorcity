@include('front.includes.header')
<style>
    .vendorTopContent {
        margin-bottom: 50px;
    }

    .vendorTopContent img {
        width: 150px;
        margin-bottom: 10px;
    }

    .vendorTopContent h3 {
        font-size: 22px;
    }

    .styledRadioLabel {
        position: relative;
        display: inline-block;
        cursor: pointer;
        margin: 0 5px;
    }

    .checkmark {
        border-radius: 50rem;
        border: 1px solid #0040E6;
        padding: 7px 30px;
        display: inline-block;
    }

    .styledRadio:checked~.checkmark {
        background-color: #0040E6;
        color: #fff;
    }

    .styledRadio {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }
</style>
<section class="our-register mt120" style="
    background: #eee;
">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto wow fadeInUp" data-wow-delay="300ms">
                <div class="main-title text-center">
                    <h2 class="title">Become A Vendor</h2>
                    <!-- <p class="paragraph">Give your visitor a smooth online experience with a solid UX design</p> -->
                </div>
            </div>
        </div>
        <form id="category_form" action="{{ url('/vendors_data') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row wow fadeInRight" data-wow-delay="300ms">
                <div class="col-xl-10 mx-auto">
                    <div class="log-reg-form search-modal form-style1 bgc-white p50 p30-sm default-box-shadow1 bdrs12">
                        <!-- <div class="mb30">
                <h4>Let's create your account!</h4>
                <p class="text mt20">Already have an account? <a href="page-login.html" class="text-thm">Log In!</a></p>
              </div> -->

                        <div class="row vendorTopContent text-center">
                            <div class="col-sm-12 col-xl-4">
                                <img src="{{ asset('public/site/images/high_quality_leads.png') }}" alt="High quality business leads – Vendorscity UAE">
                                <h3>GET HIGH QUALITY LEADS</h3>
                                <p>Unlock access to a multitude of service requests in your chosen city! </p>
                            </div>
                            <div class="col-sm-12 col-xl-4">
                                <img src="{{ asset('public/site/images/expand_your_market.png') }}" alt="Expand your market with Vendorscity service platform">
                                <h3>EXPAND YOUR MARKET REACH</h3>
                                <p>Enhance your visibility and expand your customer base without extensive marketing
                                    efforts.</p>
                            </div>
                            <div class="col-sm-12 col-xl-4">
                                <img src="{{ asset('public/site/images/flexible_engagement.png') }}" alt="Flexible engagement models – Vendorscity services">
                                <h3>FLEXIBLE ENGAGEMENT</h3>
                                <p>Choose how you engage with leads, whether by providing instant quotes or customized
                                    proposals.</p>
                            </div>
                        </div>

                        <div class="row vendorTopContent text-center">
                            <div class="col-12">
                                <h4>Join VendorsCity's Thriving Network of Service Providers!</h4>
                                <p>Don’t miss out on the opportunity to become part of VendorsCity’s dynamic and rapidly
                                    growing network. Fill out the form below, and one of our sales representatives will
                                    get in touch with you within 2 business days. Let's grow together!</p>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6" style="display: none;">
                                <div class="form-group">
                                    <label for="category">User Category</label>
                                    <select class="form-control" id="role_id" name="role_id" disabled>
                                        @foreach ($permission_data as $permission)
                                            <option value="{{ $permission->id }}" data-value="{{ $permission->id }}">
                                                {{ $permission->cname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="hidden_role_id" id="hidden_role_id" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb25">
                                <label class="form-label fw500 dark-color requiredStar">Company Name</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Company Name">
                                <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;">
                                </p>
                            </div>
                            <div class="form-group">
                                <input id="user_name" name="user_name" type="hidden" class="form-control"
                                    placeholder="Enter  Name" value="" />
                            </div>


                            {{-- add more start --}}

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group"> <label for="poc">POC Full</label>
                                        <input type="text" id="poc" name="poc[]" class="form-control"
                                            placeholder="Enter POC">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group"> <label for="poctitle">POC Title</label>
                                        <input type="text" id="poctitle" name="poctitle[]" class="form-control"
                                            placeholder="Enter  POC Title">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group"> <label for="email">Company Email</label>
                                        <input type="text" id="c_email" name="c_email[]" class="form-control"
                                            placeholder="Enter Email">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group"> <label for="telephone">Phone</label>
                                        <input type="text" id="telephone" name="telephone[]"
                                            onkeypress="return validateNumber(event)" class="form-control company-phone"
                                            placeholder="Enter Phone">
                                    </div>
                                </div>
                            </div>
                            <div class="input_fields_wrap12"></div>
                            <div class="form-group">

                                <div class="col-sm-12">

                                    <button
                                        style="border: medium none;margin-top: -46px;float: right;    color: #fff;"
                                        class="btn btn-primary" type="button"
                                        id="add_field_button12"><i class="fas fa-plus"></i></button>

                                </div>

                            </div>

                            {{-- add more End --}}

                            @php
                                $service_data = DB::table('services')
                                    ->where('is_active', 0)
                                    ->orderBy('set_order')
                                    ->get();
                            @endphp

                            <div class="col-md-6">

                            <div class="mb25 mt25" id="serviceListid">

                                <label class="form-label fw500 dark-color requiredStar" for="category">What services do you
                                    offer?
                                    (Click all that apply)</label>

                                    <select class="form-control multiple" id="serviceList" name="serviceList[]" multiple="multiple">
                                        <option value="">Select Service</option>
                                        @foreach ($service_data as $service)
                                            <option value="{{ $service->id }}">{{ $service->servicename }}</option>
                                        @endforeach
                                    </select>
                                
                                <p class="form-error-text" id="serviceList_error"
                                style="color: red; margin-top: 10px;">
                            </div>
                            </div>

                            <div class="col-md-6">

                            <div class="mb25 mt25" id="subserviceListid">

                                <label class="form-label fw500 dark-color requiredStar" for="category">What sub services do you
                                    offer?
                                    (Click all that apply)</label>

                                    <select class="form-control multiple" id="subserviceList" name="subserviceList[]" multiple="multiple">
                                        <option value="">Select Subservice</option>
                                        
                                    </select>
                                
                                <p class="form-error-text" id="subserviceList_error"
                                style="color: red; margin-top: 10px;">
                            </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb25">
                                    <label class="form-label fw500 dark-color">Company Website</label>
                                    <input type="text" id="companywebsite" name="companywebsite"
                                        class="form-control" placeholder="Enter Company Website">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb25">

                                    <label class="form-label fw500 dark-color requiredStar" for="category">Cities where you offer Services</label>
                                    <select class="form-control multiple" id="city" name="city[]" multiple="multiple">
                                        <option value="">Select City</option>
                                        @foreach ($city_data as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="form-error-text" id="city_error"
                                        style="color: red; margin-top: 10px;">
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb25">
                                    @php $maxStaff=20; @endphp
                                    <label class="form-label fw500 dark-color requiredStar" for="">Number of Staff</label>

                                    <input id="staff" name="staff" type="text" class="form-control"
                                        placeholder="Enter Number of Staff">

                                        <p class="form-error-text" id="staff_error"
                                        style="color: red; margin-top: 10px;">
                                    </p>

                                    {{-- <select class="form-control" id="staff" name="staff">
                                        <option value="">Select No Of Staff</option>
                                        @for ($i = 1; $i <= $maxStaff; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select> --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb25">
                                    <label class="form-label fw500 dark-color requiredStar">Email For Login</label>
                                    <input id="email" name="email" type="text" class="form-control"
                                        placeholder="Enter Email">
                                    <p class="form-error-text" id="email_error"
                                        style="color: red; margin-top: 10px;">
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb15">
                                    <label class="form-label fw500 dark-color requiredStar">Password</label>
                                    <input id="password" name="password" type="password" class="form-control"
                                        placeholder="Enter Password">
                                    <p class="form-error-text" id="password_error"
                                        style="color: red; margin-top: 10px;">
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="mb15">
                                    <label class="form-label fw500 dark-color requiredStar">Confirm Password</label>
                                    <input id="conf_password" name="conf_password" type="password"
                                        class="form-control" placeholder="Enter Confirm Password">
                                    <p class="form-error-text" id="confirm_password_error"
                                        style="color: red; margin-top: 10px;"></p>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="mb15">
                                    <label class="form-label fw500 dark-color requiredStar">Company Telephone (Shared with Customers)</label>
                                    <input type="hidden" name="country_code_vendor" id="country_code_vendor" value="">
                                    <input id="mobile" name="mobile" type="text" class="form-control"
                                        placeholder="Enter Company Telephone" onkeypress="return validateNumber(event)">
                                    <p class="form-error-text" id="mobile_error"
                                        style="color: red; margin-top: 10px;">
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="mb15">
                                    <label class="form-label fw500 dark-color">Company Logo</label>
                                    <input id="company_logo" name="company_logo" type="file" class="form-control">
                                    <p class="form-error-text" id="company_logo_error"
                                        style="color: red; margin-top: 10px;">
                                    </p>
                                </div>
                            </div>
                            <div class="mb15">
                                <label class="form-label fw500 dark-color requiredStar">Tell us a bit about your company</label>
                                <textarea name="short_description" id="sort_discription" rows="5"></textarea>
                                <p class="form-error-text" id="sort_discription_error"
                                        style="color: red; margin-top: 10px;">
                                    </p>
                                
                            </div>

                            @php
                            $vendor_captcha = rand('1111','9999');

                            session::put('vendor_captcha',$vendor_captcha);
                            @endphp

                         <div class="col-md-6">
                            <div class="mb15">
                                <label class="form-label fw500 dark-color requiredStar">Enter This code below: {{$vendor_captcha}}</label>
                                <input id="vendor_captcha" name="vendor_captcha" type="text" class="form-control"
                                    placeholder="Enter This code" onkeypress="return validateNumber(event)">
                                <p class="form-error-text" id="code_error" style="color: red; margin-top: 10px;">
                                </p>
                                
                            @error('vendor_captcha')
                                <p class="form-error-text" id="code_error"
                                    style="color: red; margin-top: 10px;">{{ $message }}</p>
                                
                            @enderror

                            </div>
                         </div>
                        </div>


                        <div class=" mb20">
                            {{-- <button class="ud-btn btn-thm default-box-shadow2" type="button">Submit
                                 <i class="fal fa-arrow-right-long"></i> 
                            </button> --}}
                            <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                style="display: none;">

                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>

                                Loading...

                            </button>
                            <button type="button" class="ud-btn btn-thm default-box-shadow2"
                                onclick="javascript:category_validation()" id="submit_button">Submit</button>
                        </div>


                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@include('front.includes.footer')

<script>

    $(".multiple").select2({
        placeholder: "Select a Form Fields" // Replace with your desired placeholder text
    });

    function category_validation() {

        var name = jQuery("#name").val();

        if (name == '') {
            jQuery('#name_error').html("Please Enter Company Name");
            jQuery('#name_error').show().delay(0).fadeIn('show');
            jQuery('#name_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#name').offset().top - 150
            }, 1000);
            return false;
        }

        var serviceList = $('select[name="serviceList[]"]').val(); 

        if (!serviceList || serviceList.length === 0) {
            jQuery('#serviceList_error').html("Please select at least one service");
            jQuery('#serviceList_error').show().delay(0).fadeIn('show');
            jQuery('#serviceList_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#serviceListid').offset().top - 150
            }, 1000);
            return false;
        }

        var subserviceList = $('select[name="subserviceList[]"]').val(); 

        if (!subserviceList || subserviceList.length === 0) {
            jQuery('#subserviceList_error').html("Please select at least one subservice");
            jQuery('#subserviceList_error').show().delay(0).fadeIn('show');
            jQuery('#subserviceList_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#subserviceListid').offset().top - 150
            }, 1000);
            return false;
        }

        // var serviceList = $('input[name="serviceList[]"]:checked').length > 0;

        // if (!serviceList) {
        //     jQuery('#serviceList_error').html("Please select service");
        //     jQuery('#serviceList_error').show().delay(0).fadeIn('show');
        //     jQuery('#serviceList_error').show().delay(2000).fadeOut('show');
        //     $('html, body').animate({
        //         scrollTop: $('#serviceListid').offset().top - 150
        //     }, 1000);
        //     return false;
        // }

        var city = jQuery("#city").val();

        if (city == '') {
            jQuery('#city_error').html("Please select city");
            jQuery('#city_error').show().delay(0).fadeIn('show');
            jQuery('#city_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#city').offset().top - 150
            }, 1000);
            return false;
        }

        var staff = jQuery("#staff").val();

        if (staff == '') {
            jQuery('#staff_error').html("Please Enter Number of Staff");
            jQuery('#staff_error').show().delay(0).fadeIn('show');
            jQuery('#staff_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#staff').offset().top - 150
            }, 1000);
            return false;
        }


       

        var email = jQuery("#email").val();

        if (email == '') {
            jQuery('#email_error').html("Please Enter Email");
            jQuery('#email_error').show().delay(0).fadeIn('show');
            jQuery('#email_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#email').offset().top - 150
            }, 1000);
            return false;
        }

        



        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (!filter.test(email)) {

            jQuery('#email_error').html("Please  Enter Valid Email");
            jQuery('#email_error').show().delay(0).fadeIn('show');
            jQuery('#email_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#email').offset().top - 150
            }, 1000);
            return false;

        }

        var url = "{{ url('vendors_check_mail') }}";


        $.ajax({
            url: url,
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "email": email
            },
            success: function(msg) {
                if (msg == 1) {
                    jQuery('#email_error').html("Email Address Already Exists");
                    jQuery('#email_error').show().delay(0).fadeIn('show');
                    jQuery('#email_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#email').offset().top - 150
                    }, 1000);
                    return false;

                } else {

                    var password = jQuery("#password").val();

                    if (password == '') {

                        jQuery('#password_error').html("Please  Enter Password");
                        jQuery('#password_error').show().delay(0).fadeIn('show');
                        jQuery('#password_error').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#password').offset().top - 150
                        }, 1000);
                        return false;

                    }



                    var conf_password = jQuery("#conf_password").val();

                    if (conf_password == '') {

                        jQuery('#confirm_password_error').html("Please  Enter Confirm-Password");
                        jQuery('#confirm_password_error').show().delay(0).fadeIn('show');
                        jQuery('#confirm_password_error').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#conf_password').offset().top - 150
                        }, 1000);
                        return false;

                    }



                    if (conf_password != password) {

                        jQuery('#confirm_password_error').html("Confirm Password Doesn't Match Password");
                        jQuery('#confirm_password_error').show().delay(0).fadeIn('show');
                        jQuery('#confirm_password_error').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#conf_password').offset().top - 150
                        }, 1000);
                        return false;

                    }

                    // var mobile = jQuery("#mobile").val();

                    // if (mobile == '') {

                    //     jQuery('#mobile_error').html("Please Enter mobile");
                    //     jQuery('#mobile_error').show().delay(0).fadeIn('show');
                    //     jQuery('#mobile_error').show().delay(2000).fadeOut('show');
                    //     $('html, body').animate({
                    //         scrollTop: $('#mobile').offset().top - 150
                    //     }, 1000);
                    //     return false;

                    // }


                    // var filter = /^\d{10}$/;

                    // if (mobile != '' && !filter.test(mobile)) {

                    //     jQuery('#mobile_error').html("Please Enter Valid Mobile");
                    //     jQuery('#mobile_error').show().delay(0).fadeIn('show');
                    //     jQuery('#mobile_error').show().delay(2000).fadeOut('show');
                    //     $('html, body').animate({
                    //         scrollTop: $('#mobile').offset().top - 150
                    //     }, 1000);
                    //     return false;

                    // }

                    // var sort_discription = jQuery("#sort_discription").val();

                    // if (sort_discription == '') {

                    //     jQuery('#sort_discription_error').html("Please Tell us a bit about your company");
                    //     jQuery('#sort_discription_error').show().delay(0).fadeIn('show');
                    //     jQuery('#sort_discription_error').show().delay(2000).fadeOut('show');
                    //     $('html, body').animate({
                    //         scrollTop: $('#sort_discription').offset().top - 150
                    //     }, 1000);
                    //     return false;

                    // }

                    var captcha_store = '{{session::get('vendor_captcha')}}';

                    var captcha = jQuery("#vendor_captcha").val();
                    if (captcha == '') {
                        jQuery('#code_error').html("Please Enter Captcha Code");
                        jQuery('#code_error').show().delay(0).fadeIn('show');
                        jQuery('#code_error').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#vendor_captcha').offset().top - 150
                        }, 1000);
                        return false;

                    }
                    if (captcha != captcha_store) {
                            jQuery('#code_error').html("Please Enter Valid Captcha Number");
                            jQuery('#code_error').show().delay(0).fadeIn('show');
                            jQuery('#code_error').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#vendor_captcha').offset().top - 150
                            }, 1000);
                            return false;
                    }


                    $('#spinner_button').show();

                    $('#submit_button').hide();

                    $('#category_form').submit();

                }
            }
        });







    }
</script>

<script>
    $(document).ready(function() {
        var role_id = jQuery("#role_id").val();

        $("#hidden_role_id").val(role_id);
    });



    $(function() {

        $("#name").keyup(function() {

            var Text = $(this).val();

            Text = Text.toLowerCase();

            Text = Text.replace(/[^a-zA-Z0-9]+/g, ' ');

            $("#user_name").val(Text);

        });

    });
</script>


<script>
    // $(document).ready(function() {

    //     var max_fields = 50;

    //     var wrapper = $(".input_fields_wrap12");

    //     var add_button = $("#add_field_button12");



    //     var b = 0;

    //     $(add_button).click(function(e) { //alert('ok');

    //         e.preventDefault();

    //         if (b < max_fields) {

    //             b++;

    //             $(wrapper).append(

    //                 '<div class="row"><div class="col-md-2"><div class="form-group"><label for="poc">POC Full</label><input type="text" id="poc" name="poc[]" class="form-control" placeholder="Enter POC"></div></div><div class="col-md-2"><div class="form-group"> <label for="poctitle">POC Title</label><input type="text" id="poctitle" name="poctitle[]" class="form-control" placeholder="Enter  POC Title"></div></div><div class="col-md-3"><div class="form-group"> <label for="email">Company Email</label><input type="text" id="c_email" name="c_email[]" class="form-control" placeholder="Enter Email"></div></div><div class="col-md-3"><div class="form-group"><label for="telephone">Phone</label><input type="text" id="telephone" name="telephone[]" onkeypress="return validateNumber(event)" class="form-control company-phone" placeholder="Enter Phone"></div></div><a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 0;margin-top: 37px;width: 10%;float: right;height: 38px;color: #fff;">Remove</a></div>'
    //             );

    //         }

    //     });

    //     $(wrapper).on("click", ".remove_field1", function(e) {

    //         e.preventDefault();

    //         $(this).parent('div').remove();

    //         b--;

    //     })

    // });

     $(document).ready(function() {
    var max_fields = 50;
    var wrapper = $(".input_fields_wrap12");
    var add_button = $("#add_field_button12");
    var b = 0;

    // Initialize intlTelInput on existing telephone fields
    initializeIntlTelInputs();

    // Add new field logic
    $(add_button).click(function(e) {
        e.preventDefault();
        if (b < max_fields) {
            b++;
            var newField = `
                <div class="row poc-row">
                    <div class="col-md-2">
                                    <div class="form-group"> <label for="poc">POC Full</label>
                                        <input type="text" id="poc" name="poc[]" class="form-control"
                                            placeholder="Enter POC">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group"> <label for="poctitle">POC Title</label>
                                        <input type="text" id="poctitle" name="poctitle[]" class="form-control"
                                            placeholder="Enter  POC Title">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group"> <label for="email">Company Email</label>
                                        <input type="text" id="c_email" name="c_email[]" class="form-control"
                                            placeholder="Enter Email">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group"> <label for="telephone">Phone</label>
                                        <input type="text" id="telephone" name="telephone[]"
                                            onkeypress="return validateNumber(event)" class="form-control company-phone"
                                            placeholder="Enter Phone">
                                    </div>
                                </div>
                    <a href="#" class="btn btn-danger pull-right remove_field1"
                       style="margin-top: 37px;width: 5%;height: max-content;margin-left: 22px;color: #fff;"><i class="fas fa-minus"></i></a>
                </div>`;
            $(wrapper).append(newField);

            // Initialize intlTelInput for the new field only
            var lastPhoneInput = $(wrapper).find('.company-phone').last()[0];
            initializeIntlTelInput(lastPhoneInput);
        }
    });

    // Remove field
    $(wrapper).on("click", ".remove_field1", function(e) {
        e.preventDefault();
        $(this).closest('.poc-row').remove();
        b--;
    });

    // ---- Function Definitions ----

    function initializeIntlTelInputs() {
        $(".company-phone").each(function() {
            initializeIntlTelInput(this);
        });
    }

    function initializeIntlTelInput(input) {
        if (!input) return;
        const iti = window.intlTelInput(input, {
            initialCountry: "ae",
            separateDialCode: true,
            autoPlaceholder: "aggressive",
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        // Optional: You can add hidden field to store country code per row if needed
        let hidden = document.createElement("input");
        hidden.type = "hidden";
        hidden.name = "country_code[]";
        input.closest('.form-group').appendChild(hidden);

        function setCountryCode() {
            const data = iti.getSelectedCountryData();
            hidden.value = data.dialCode;
        }
        setCountryCode();

        input.addEventListener("countrychange", setCountryCode);
    }
});
</script>

<script type="text/javascript">
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
    const countryCodeInput = document.querySelector("#country_code_vendor");

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

$('#serviceList').on('change', function () {
    var selectedServices = $(this).val(); // array of selected service IDs
    var selectedSubservices = $('#subserviceList').val() || []; // keep currently selected subservices

    if (selectedServices && selectedServices.length > 0) {
        $.ajax({
            url: "{{ route('front.getSubservices') }}",
            type: "POST",
            data: {
                service_ids: selectedServices,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                $('#subserviceList').empty();

                // Populate new options
                $.each(response, function (index, subservice) {
                    var option = $('<option>', {
                        value: subservice.id,
                        text: subservice.subservicename
                    });

                    // Retain previously selected subservices
                    if (selectedSubservices.includes(subservice.id.toString())) {
                        option.attr('selected', 'selected');
                    }

                    $('#subserviceList').append(option);
                });
            }
        });
    } else {
        $('#subserviceList').empty().append('<option value="">Select Subservice</option>');
    }
});

</script>
