@include('front.includes.header')
<link rel="stylesheet" href="{{ asset('public/site/css/select2/css/select2.min.css') }}">
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
<section class="our-register" style="background: #eee; padding-top: 40px; padding-bottom: 60px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto wow fadeInUp" data-wow-delay="300ms">
                <div class="main-title text-center mb-4">
                    <h2 class="title">Become A Vendor</h2>
                    <!-- <p class="paragraph">Give your visitor a smooth online experience with a solid UX design</p> -->
                </div>
            </div>
        </div>
        <form id="category_form" action="{{ url(session('search_city_name', 'dubai') . '/vendors_data') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="row wow fadeInRight" data-wow-delay="300ms">
                <div class="col-xl-10 mx-auto">
                    <div class="log-reg-form search-modal form-style1 bgc-white p50 p30-sm default-box-shadow1 bdrs12">

                        <!-- Step Tracker -->
                        <div class="row mb-4">
                            <div class="col-12 text-center">
                                <h5 id="step_title">Step 1 of 5</h5>
                            </div>
                        </div>

                        <!-- STEP 1 -->
                        <div id="step1" class="step-content">
                            <div class="row vendorTopContent text-center">
                                <div class="col-sm-12 col-xl-4">
                                    <img src="{{ asset('public/site/images/high_quality_leads.png') }}"
                                        alt="High quality business leads – Vendorscity UAE">
                                    <h3>GET HIGH QUALITY LEADS</h3>
                                    <p>Unlock access to a multitude of service requests in your chosen city! </p>
                                </div>
                                <div class="col-sm-12 col-xl-4">
                                    <img src="{{ asset('public/site/images/expand_your_market.png') }}"
                                        alt="Expand your market with Vendorscity service platform">
                                    <h3>EXPAND YOUR MARKET REACH</h3>
                                    <p>Enhance your visibility and expand your customer base without extensive marketing
                                        efforts.</p>
                                </div>
                                <div class="col-sm-12 col-xl-4">
                                    <img src="{{ asset('public/site/images/flexible_engagement.png') }}"
                                        alt="Flexible engagement models – Vendorscity services">
                                    <h3>FLEXIBLE ENGAGEMENT</h3>
                                    <p>Choose how you engage with leads, whether by providing instant quotes or
                                        customized proposals.</p>
                                </div>
                            </div>

                            <div class="row vendorTopContent text-center">
                                <div class="col-12">
                                    <h4>Join VendorsCity's Thriving Network of Service Providers!</h4>
                                    <p>Don’t miss out on the opportunity to become part of VendorsCity’s dynamic and
                                        rapidly growing network. Fill out the form below, and one of our sales
                                        representatives will get in touch with you within 2 business days. Let's grow
                                        together!</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb25">
                                    <label class="form-label fw500 dark-color requiredStar">Company Name</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        placeholder="Company Name">
                                    <p class="form-error-text" id="name_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                                <div class="form-group">
                                    <input id="user_name" name="user_name" type="hidden" class="form-control"
                                        value="" />
                                </div>
                            </div>

                            <div class="row poc-row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="poc">POC Full</label>
                                        <input type="text" id="poc" name="poc[]" class="form-control"
                                            placeholder="Enter POC">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="poctitle">POC Title</label>
                                        <input type="text" id="poctitle" name="poctitle[]" class="form-control"
                                            placeholder="Enter POC Title">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="c_email">Company Email</label>
                                        <input type="text" id="c_email" name="c_email[]" class="form-control"
                                            placeholder="Enter Email">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="telephone">Phone</label>
                                        <input type="text" id="telephone" name="telephone[]"
                                            onkeypress="return validateNumber(event)" class="form-control company-phone"
                                            placeholder="Enter Phone">
                                    </div>
                                </div>
                                <div class="col-md-2" style="padding-top:35px;">
                                    <button class="btn btn-primary" type="button" id="add_field_button12"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="input_fields_wrap12"></div>
                            <p class="form-error-text" id="step1_error"
                                style="color: red; margin-top: 10px; display:none;"></p>

                            <div class="row mt-3">
                                <div class="col-12 text-end">
                                    <button type="button" class="ud-btn btn-thm default-box-shadow2"
                                        onclick="nextStep(2)">Next <i class="fal fa-arrow-right-long"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 2 -->
                        <div id="step2" class="step-content" style="display:none;">
                            @php
                                $service_data = DB::table('services')
                                    ->where('is_active', 0)
                                    ->orderBy('set_order')
                                    ->get();
                            @endphp
                            <div class="row">
                                <div class="col-md-6 mb25" id="serviceListid">
                                    <label class="form-label fw500 dark-color requiredStar">What services do you offer?
                                        (Click all that apply)</label>
                                    <select class="form-control multiple" id="serviceList" name="serviceList[]"
                                        multiple="multiple">
                                        @foreach ($service_data as $service)
                                            <option value="{{ $service->id }}">{{ $service->servicename }}</option>
                                        @endforeach
                                    </select>
                                    <p class="form-error-text" id="serviceList_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>

                                <div class="col-md-6 mb25" id="subserviceListid">
                                    <label class="form-label fw500 dark-color requiredStar">What sub services do you
                                        offer? (Click all that apply)</label>
                                    <select class="form-control multiple" id="subserviceList" name="subserviceList[]"
                                        multiple="multiple"></select>
                                    <p class="form-error-text" id="subserviceList_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb25">
                                    <label class="form-label fw500 dark-color">Company Website</label>
                                    <input type="text" id="companywebsite" name="companywebsite"
                                        class="form-control" placeholder="Enter Company Website">
                                </div>
                                <div class="col-md-6 mb25">
                                    <label class="form-label fw500 dark-color requiredStar">Cities where you offer
                                        Services</label>
                                    <select class="form-control multiple" id="city" name="city[]"
                                        multiple="multiple">
                                        @foreach ($city_data as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="form-error-text" id="city_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                            </div>
                            <p class="form-error-text" id="step2_error"
                                style="color: red; margin-top: 10px; display:none;"></p>
                            <div class="row mt-3">
                                <div class="col-12 text-end">
                                    <button type="button" class="ud-btn btn-white default-box-shadow2 mr-2"
                                        onclick="prevStep(1)">Back</button>
                                    <button type="button" class="ud-btn btn-thm default-box-shadow2"
                                        onclick="nextStep(3)">Next <i class="fal fa-arrow-right-long"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 3 -->
                        <div id="step3" class="step-content" style="display:none;">
                            <div class="row">
                                <div class="col-md-6 mb25">
                                    <label class="form-label fw500 dark-color requiredStar">VAT Certificate</label>
                                    <input type="file" id="vatcertificate" name="vatcertificate"
                                        class="form-control">
                                    <p class="form-error-text" id="vatcertificate_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                                <div class="col-md-6 mb25">
                                    <label class="form-label fw500 dark-color requiredStar">TRN Certificate
                                        Number</label>
                                    <input type="text" id="trn_certificate_number" name="trn_certificate_number"
                                        class="form-control" placeholder="Enter TRN Certificate Number">
                                    <p class="form-error-text" id="trn_certificate_number_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb25">
                                    <label class="form-label fw500 dark-color requiredStar">Trade License</label>
                                    <input type="file" id="tradelicense" name="tradelicense"
                                        class="form-control">
                                    <p class="form-error-text" id="tradelicense_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                                <div class="col-md-4 mb25">
                                    <label class="form-label fw500 dark-color requiredStar">Trade License
                                        Number</label>
                                    <input type="text" id="trade_license_number" name="trade_license_number"
                                        class="form-control" placeholder="Enter Trade License Number">
                                    <p class="form-error-text" id="trade_license_number_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                                <div class="col-md-4 mb25">
                                    <label class="form-label fw500 dark-color requiredStar">Trade License Expiry
                                        Date</label>
                                    <input type="date" id="tlexpiry" name="tlexpiry" class="form-control">
                                    <p class="form-error-text" id="tlexpiry_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb25">
                                    <label class="form-label fw500 dark-color requiredStar">Passport (authorized
                                        person)</label>
                                    <input type="file" id="passport" name="passport" class="form-control">
                                    <p class="form-error-text" id="passport_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                                <div class="col-md-4 mb25">
                                    <label class="form-label fw500 dark-color requiredStar">Passport Number (authorized
                                        person)</label>
                                    <input type="text" id="passport_number" name="passport_number"
                                        class="form-control" placeholder="Enter Passport Number">
                                    <p class="form-error-text" id="passport_number_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                                <div class="col-md-4 mb25">
                                    <label class="form-label fw500 dark-color requiredStar">Passport Expiry Date
                                        (authorized person)</label>
                                    <input type="date" id="passport_expiry" name="passport_expiry"
                                        class="form-control">
                                    <p class="form-error-text" id="passport_expiry_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb25">
                                    <label class="form-label fw500 dark-color requiredStar">Emirates ID (authorized
                                        person)</label>
                                    <input type="file" id="emirates_id" name="emirates_id" class="form-control">
                                    <p class="form-error-text" id="emirates_id_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                                <div class="col-md-4 mb25">
                                    <label class="form-label fw500 dark-color requiredStar">Emirates ID Number
                                        (authorized person)</label>
                                    <input type="text" id="emirates_id_number" name="emirates_id_number"
                                        class="form-control" placeholder="Enter Emirates ID Number">
                                    <p class="form-error-text" id="emirates_id_number_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                                <div class="col-md-4 mb25">
                                    <label class="form-label fw500 dark-color requiredStar">Emirates ID Expiry Date
                                        (authorized person)</label>
                                    <input type="date" id="emirates_id_expiry" name="emirates_id_expiry"
                                        class="form-control">
                                    <p class="form-error-text" id="emirates_id_expiry_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                            </div>
                            <p class="form-error-text" id="step3_error"
                                style="color: red; margin-top: 10px; display:none;"></p>
                            <div class="row mt-3">
                                <div class="col-12 text-end">
                                    <button type="button" class="ud-btn btn-white default-box-shadow2 mr-2"
                                        onclick="prevStep(2)">Back</button>
                                    <button type="button" class="ud-btn btn-thm default-box-shadow2"
                                        onclick="nextStep(4)">Next <i class="fal fa-arrow-right-long"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 4 -->
                        <div id="step4" class="step-content" style="display:none;">
                            <div class="row">
                                <div class="col-md-6 mb25">
                                    <label class="form-label fw500 dark-color requiredStar">Number of Staff</label>
                                    <input id="staff" name="staff" type="text" class="form-control"
                                        placeholder="Enter Number of Staff" onkeypress="return validateNumber(event)">
                                    <p class="form-error-text" id="staff_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                                <div class="col-md-6 mb25">
                                    <label class="form-label fw500 dark-color">Remarks</label>
                                    <input type="text" id="remarks" name="remarks" class="form-control"
                                        placeholder="Enter Remarks">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb25">
                                    <label class="form-label fw500 dark-color requiredStar">Email For Login</label>
                                    <input id="email" name="email" type="text" class="form-control"
                                        placeholder="Enter Email">
                                    <p class="form-error-text" id="email_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb15">
                                    <label class="form-label fw500 dark-color requiredStar">Password</label>
                                    <input id="password" name="password" type="password" class="form-control"
                                        placeholder="Enter Password">
                                    <p class="form-error-text" id="password_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                                <div class="col-md-6 mb15">
                                    <label class="form-label fw500 dark-color requiredStar">Confirm Password</label>
                                    <input id="conf_password" name="conf_password" type="password"
                                        class="form-control" placeholder="Enter Confirm Password">
                                    <p class="form-error-text" id="confirm_password_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mb15">
                                    <label class="form-label fw500 dark-color requiredStar">Company Telephone (Shared
                                        with Customers)</label>
                                    <input type="hidden" name="country_code_vendor" id="country_code_vendor"
                                        value="">
                                    <input id="mobile" name="mobile" type="text" class="form-control"
                                        placeholder="Enter Company Telephone"
                                        onkeypress="return validateNumber(event)">
                                    <p class="form-error-text" id="mobile_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                                <div class="col-md-4 mb15" style="padding-top:35px;">
                                    <button type="button" class="btn btn-primary" id="btn_send_otp"
                                        onclick="sendOtp()">Send OTP</button>
                                    <span id="otp_sent_msg" style="color:green; display:none;"><i
                                            class="fas fa-check"></i> OTP Sent</span>
                                </div>
                            </div>
                            <div class="row" id="otp_verification_section" style="display:none;">
                                <div class="col-md-6 mb15">
                                    <label class="form-label fw500 dark-color requiredStar">Enter OTP</label>
                                    <input type="text" id="otp_code" class="form-control"
                                        placeholder="Enter OTP">
                                    <p class="form-error-text" id="otp_code_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                                <div class="col-md-6 mb15" style="padding-top:35px;">
                                    <button type="button" class="btn btn-success" id="btn_verify_otp"
                                        onclick="verifyOtp()">Verify</button>
                                    <button type="button" class="btn btn-secondary" id="btn_resend_otp"
                                        onclick="sendOtp()">Resend OTP</button>
                                    <span id="otp_verified_msg" style="color:green; display:none;"><i
                                            class="fas fa-check"></i> Verified</span>
                                </div>
                                <input type="hidden" id="is_otp_verified" value="0">
                            </div>
                            <p class="form-error-text" id="step4_error"
                                style="color: red; margin-top: 10px; display:none;"></p>
                            <div class="row mt-3">
                                <div class="col-12 text-end">
                                    <button type="button" class="ud-btn btn-white default-box-shadow2 mr-2"
                                        onclick="prevStep(3)">Back</button>
                                    <button type="button" class="ud-btn btn-thm default-box-shadow2" id="btn_next_4"
                                        onclick="nextStep(5)">Next <i class="fal fa-arrow-right-long"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 5 -->
                        <div id="step5" class="step-content" style="display:none;">
                            <div class="row">
                                <div class="col-md-6 mb15">
                                    <label class="form-label fw500 dark-color requiredStar">Company Logo</label>
                                    <input id="company_logo" name="company_logo" type="file"
                                        class="form-control">
                                    <p class="form-error-text" id="company_logo_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                                <div class="col-md-12 mb15">
                                    <label class="form-label fw500 dark-color">Tell us a bit about your
                                        company</label>
                                    <textarea name="short_description" id="sort_discription" class="form-control" rows="5"></textarea>
                                    <p class="form-error-text" id="sort_discription_error"
                                        style="color: red; margin-top: 10px; display:none;"></p>
                                </div>
                            </div>

                            @php
                                $vendor_captcha = rand('1111', '9999');
                                session::put('vendor_captcha', $vendor_captcha);
                            @endphp
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb15">
                                        <label class="form-label fw500 dark-color requiredStar">Enter This code below:
                                            {{ $vendor_captcha }}</label>
                                        <input id="vendor_captcha" name="vendor_captcha" type="text"
                                            class="form-control" placeholder="Enter This code"
                                            onkeypress="return validateNumber(event)">
                                        <p class="form-error-text" id="code_error"
                                            style="color: red; margin-top: 10px; display:none;"></p>
                                        @error('vendor_captcha')
                                            <p class="form-error-text" id="code_error"
                                                style="color: red; margin-top: 10px;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-end">
                                    <button type="button" class="ud-btn btn-white default-box-shadow2 mr-2"
                                        onclick="prevStep(4)">Back</button>
                                    <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                        style="display: none;">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span> Loading...
                                    </button>
                                    <button type="button" class="ud-btn btn-thm default-box-shadow2"
                                        onclick="submitForm()" id="submit_button">Submit</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>


    </div>
</section>
@include('front.includes.footer')

<script src="{{ asset('public/site/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $(".multiple").select2({
            placeholder: "Select a Form Fields" // Replace with your desired placeholder text
        });
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

                    var captcha_store = '{{ session::get('vendor_captcha') }}';

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

    document.addEventListener("DOMContentLoaded", function() {
        const Otpphoneinput = document.querySelector("#mobile");

        const Otpphoneinputnew = window.intlTelInput(Otpphoneinput, {
            initialCountry: "ae", // UAE
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
        Otpphoneinput.addEventListener("countrychange", function() {
            setCountryCode();
        });
    });

    $('#serviceList').on('change', function() {
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
                success: function(response) {
                    $('#subserviceList').empty();

                    // Populate new options
                    $.each(response, function(index, subservice) {
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


    function nextStep(step) {
        if (step == 2) {
            if ($('#name').val() == '') {
                $('#name_error').html("Please Enter Company Name").show().delay(2000).fadeOut();
                return false;
            }
        } else if (step == 3) {
            var serviceList = $('select[name="serviceList[]"]').val();
            if (!serviceList || serviceList.length === 0) {
                $('#serviceList_error').html("Please select at least one service").show().delay(2000).fadeOut();
                return false;
            }
            var subserviceList = $('select[name="subserviceList[]"]').val();
            if (!subserviceList || subserviceList.length === 0) {
                $('#subserviceList_error').html("Please select at least one subservice").show().delay(2000).fadeOut();
                return false;
            }
            var city = $('#city').val();
            if (!city || city.length === 0) {
                $('#city_error').html("Please select city").show().delay(2000).fadeOut();
                return false;
            }
        } else if (step == 4) {
            var step3_valid = true;
            var req3 = [{
                    id: '#vatcertificate',
                    err: '#vatcertificate_error',
                    msg: "Please upload VAT Certificate"
                },
                {
                    id: '#trn_certificate_number',
                    err: '#trn_certificate_number_error',
                    msg: "Please enter TRN Certificate Number"
                },
                {
                    id: '#tradelicense',
                    err: '#tradelicense_error',
                    msg: "Please upload Trade License"
                },
                {
                    id: '#trade_license_number',
                    err: '#trade_license_number_error',
                    msg: "Please enter Trade License Number"
                },
                {
                    id: '#tlexpiry',
                    err: '#tlexpiry_error',
                    msg: "Please enter Trade License Expiry Date"
                },
                {
                    id: '#passport',
                    err: '#passport_error',
                    msg: "Please upload Passport"
                },
                {
                    id: '#passport_number',
                    err: '#passport_number_error',
                    msg: "Please enter Passport Number"
                },
                {
                    id: '#passport_expiry',
                    err: '#passport_expiry_error',
                    msg: "Please enter Passport Expiry Date"
                },
                {
                    id: '#emirates_id',
                    err: '#emirates_id_error',
                    msg: "Please upload Emirates ID"
                },
                {
                    id: '#emirates_id_number',
                    err: '#emirates_id_number_error',
                    msg: "Please enter Emirates ID Number"
                },
                {
                    id: '#emirates_id_expiry',
                    err: '#emirates_id_expiry_error',
                    msg: "Please enter Emirates ID Expiry Date"
                }
            ];
            for (var i = 0; i < req3.length; i++) {
                if ($(req3[i].id).val() == '') {
                    $(req3[i].err).html(req3[i].msg).show().delay(2000).fadeOut();
                    step3_valid = false;
                }
            }
            if (!step3_valid) return false;
        } else if (step == 5) {
            if ($('#staff').val() == '') {
                $('#staff_error').html("Please Enter Number of Staff").show().delay(2000).fadeOut();
                return false;
            }
            var email = $('#email').val();
            if (email == '') {
                $('#email_error').html("Please Enter Email").show().delay(2000).fadeOut();
                return false;
            }
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!filter.test(email)) {
                $('#email_error').html("Please Enter Valid Email").show().delay(2000).fadeOut();
                return false;
            }

            var emailExists = false;
            $.ajax({
                url: "{{ url('vendors_check_mail') }}",
                type: 'post',
                async: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "email": email
                },
                success: function(msg) {
                    if (msg == 1) {
                        emailExists = true;
                    }
                }
            });
            if (emailExists) {
                $('#email_error').html("Email Address Already Exists").show().delay(2000).fadeOut();
                return false;
            }

            var password = $('#password').val();
            if (password == '') {
                $('#password_error').html("Please Enter Password").show().delay(2000).fadeOut();
                return false;
            }
            var conf_password = $('#conf_password').val();
            if (conf_password == '') {
                $('#confirm_password_error').html("Please Enter Confirm Password").show().delay(2000).fadeOut();
                return false;
            }
            if (conf_password != password) {
                $('#confirm_password_error').html("Confirm Password Doesn't Match Password").show().delay(2000)
                .fadeOut();
                return false;
            }
            if ($('#mobile').val() == '') {
                $('#mobile_error').html("Please Enter Company Telephone").show().delay(2000).fadeOut();
                return false;
            }
            if ($('#is_otp_verified').val() != '1') {
                $('#mobile_error').html("Please Verify Company Telephone using OTP").show().delay(2000).fadeOut();
                return false;
            }
        }

        $('.step-content').hide();
        $('#step' + step).show();
        $('#step_title').text('Step ' + step + ' of 5');
    }

    function prevStep(step) {
        $('.step-content').hide();
        $('#step' + step).show();
        $('#step_title').text('Step ' + step + ' of 5');
    }

    function sendOtp() {
        var mobile = $('#mobile').val();
        var country_code = $('#country_code_vendor').val();
        if (mobile == '') {
            $('#mobile_error').html('Please enter mobile number').show();
            return false;
        }
        $('#mobile_error').hide();

        var btn = $('#btn_send_otp');
        var originalText = btn.html();
        btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...')
            .prop('disabled', true);

        $.ajax({
            url: '{{ route('vendor-otp-sent') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                mobile: mobile,
                country_code: country_code
            },
            success: function(res) {
                btn.html(originalText).prop('disabled', false);
                if (res.status == 'success') {
                    $('#otp_sent_msg').show();
                    $('#otp_verification_section').show();
                    $('#btn_send_otp').hide();
                } else {
                    alert('Error sending OTP. Please try again.');
                }
            },
            error: function() {
                btn.html(originalText).prop('disabled', false);
                alert('Error sending OTP. Please try again.');
            }
        });
    }

    function verifyOtp() {
        var otp_code = $('#otp_code').val();
        if (otp_code == '') {
            $('#otp_code_error').html('Please enter OTP').show();
            return false;
        }

        var btn = $('#btn_verify_otp');
        var originalText = btn.html();
        btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verifying...')
            .prop('disabled', true);

        $.ajax({
            url: '{{ route('vendor-otp-verify') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                otp: otp_code
            },
            success: function(res) {
                btn.html(originalText).prop('disabled', false);
                if (res.status == 'success') {
                    $('#otp_verified_msg').show();
                    $('#is_otp_verified').val('1');
                    $('#btn_verify_otp').hide();
                    $('#btn_resend_otp').hide();

                    // Go to next step after verification
                    nextStep(5);
                } else {
                    $('#otp_code_error').html('Invalid OTP').show();
                }
            },
            error: function() {
                btn.html(originalText).prop('disabled', false);
                $('#otp_code_error').html('Invalid OTP').show();
            }
        });
    }

    function submitForm() {
        var company_logo = $('#company_logo').val();
        if (company_logo == '') {
            $('#company_logo_error').html('Please upload Company Logo').show().delay(2000).fadeOut();
            return false;
        }

        var captcha_store = '{{ session::get('vendor_captcha') }}';
        var captcha = $('#vendor_captcha').val();
        if (captcha == '' || captcha != captcha_store) {
            $('#code_error').html('Please Enter Valid Captcha Number').show().delay(2000).fadeOut();
            return false;
        }

        $('#spinner_button').show();
        $('#submit_button').hide();
        $('#category_form').submit();
    }

    function category_validation() {
        // this is here to satisfy the onclick that was old, but we changed the submit button to onclick="submitForm()"
        submitForm();
    }
</script>
