<!-- OTP Popup Start-->
<div class="modal modal-mobile-bottom-otp otp-login-form-modal" id="exampleModalLong" tabindex="-1"
    aria-labelledby="otpLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom-otp user-modal-dialog modal-dialog-centered">
        <div class="modal-content details-modal-content">
            <div class="modal-header details-header bn-modal-header">
                <h5 class="modal-title w-100" id="modalStepTitle">Log in or Sign Up</h5>
            </div>

            <div class="modal-body">
                <div id="booknow_refresh_otp_div">
                    <input type="hidden" name="book_session_otp" id="book_session_otp"
                        value="{{ session('book-login-otp') }}">
                </div>
                <form class="form-horizontal details-form" id="BookOtpForm" method="POST"
                    action="{{ route('booknow-user-otp-login') }}">

                    <input type="hidden" name="redirectUrl" value="{{ $redirectUrl ?? '' }}">
                    <input type="hidden" name="service_id" id="service_id" value="{{ $service_id ?? '' }}">
                    <input type="hidden" name="subservice_id" id="subservice_id" value="{{ $subservice_id ?? '' }}">

                    @csrf

                    <!-- STEP 1: Mobile Input -->
                    <div id="booknow-step-phone">
                        <div class="form-group mb-2">
                            <label id="mobilename-label">Please Enter Your WhatsApp mobile number</label>
                            <input type="hidden" name="country_code_otp_popup_Modal"
                                id="country_code_otp_popup_Modal_book" value="">
                            <input type="tel" class="input-field" name="phone" id="user-phone-number"
                                placeholder="Mobile No" onkeypress="return validateNumber(event)">
                            <p id="booknow_otp_phone_error" style="display:none;color:red;"></p>
                        </div>
                        <a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp"
                            data-bs-target="#book_email_otp_popup_Modal">Don't have a WhatsApp Number? Login with
                            Email</a>
                        <div class="text-center mt-3">

                            <button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button"
                                disabled id="spinner_button_phone_book1" style="display: none;">
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>Loading...
                            </button>

                            <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                id="submit_button_phone_book1" onclick="booknow_otp_verification('1')">Continue</button>
                        </div>
                    </div>

                    <!-- STEP 2: OTP Verification -->
                    <div id="booknow-step-otp" style="display: none;">
                        <label id="mobilename-label">Please enter the <strong>WhatsApp code</strong> that was sent
                            to:<br>
                            <span id="booknow-whatsapp-number">+971 58 520 0722</span>
                        </label>

                        <div class="d-flex justify-content-center gap-2 my-3">
                            <input type="tel" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="tel" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="tel" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="tel" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="tel" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="tel" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                        </div>
                        <p id="booknow_otp_error" style="display:none;color:red;"></p>

                        <a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp"
                            data-bs-target="#book_email_otp_popup_Modal">Can't log in? Use your Email Address</a>

                        <div class="text-center mt-3">
                            <button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button"
                                disabled id="spinner_button_phone_book2" style="display: none;">
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>Loading...
                            </button>
                            <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                id="submit_button_phone_book2" onclick="booknow_otp_verification('2')">Verify
                                Number</button>
                        </div>
                    </div>

                    <!-- STEP 3: Personal Details -->
                    <div id="booknow-step-details" style="display: none;">
                        <label id="mobilename-label">Contact information</label>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="book_name" id="booknow_user_name"
                                placeholder="Full Name">
                            <p id="booknow_name_error" style="display:none;color:red;"></p>
                        </div>
                        <div class="form-group mt-3">
                            <input type="email" class="form-control" id="booknow_user_email" name="book_email"
                                placeholder="Email">
                            <p id="booknow_email_error" style="display:none;color:red;"></p>
                        </div>

                        <div class="text-center mt-3">
                            <button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button"
                                disabled id="spinner_button_phone_book3" style="display: none;">

                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>Loading...</button>

                            <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                id="submit_button_phone_book3" onclick="booknow_otp_verification('3')">All
                                Done</button>

                        </div>

                        <div class="mt-3">
                            <a href="{{ route('privacy_policy') }}" class="footer-link me-3">Privacy Policy</a>
                            <a href="{{ route('term_condition') }}" class="footer-link">Terms of Service</a>
                        </div>

                    </div>


                </form>
            </div>

        </div>
    </div>
</div>

<!-- OTP Popup End-->


<!-- email OTP Popup Start-->

<div class="modal modal-mobile-bottom-otp otp-login-form-modal" id="book_email_otp_popup_Modal" tabindex="-1"
    aria-labelledby="otpLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom-otp user-modal-dialog modal-dialog-centered">
        <div class="modal-content details-modal-content">
            <div class="modal-header details-header bn-modal-header">
                <h5 class="modal-title w-100" id="booknow_email_modalStepTitle">Log in or Sign Up</h5>
            </div>

            <div class="modal-body">
                <div id="book_email_refresh_otp_div">
                    <input type="hidden" name="book_email_session_otp" id="book_email_session_otp"
                        value="{{ session('book-email-login-otp') }}">
                </div>
                <form class="form-horizontal details-form" id="bookemailOtpForm" method="POST"
                    action="{{ route('home.book-email-otp-login') }}">
                    <input type="hidden" name="redirectUrl" value="{{ $redirectUrl ?? '' }}">
                    <input type="hidden" name="service_id" id="service_id" value="{{ $service_id ?? '' }}">
                    <input type="hidden" name="subservice_id" id="subservice_id" value="{{ $subservice_id ?? '' }}">

                    <input type="hidden" name="country_code_book_popup_Modal_book"
                        id="country_code_book_popup_Modal_book" value="">
                    @csrf


                    <!-- STEP 1: Mobile Input -->
                    <div id="book-email-step-phone">
                        <div class="form-group mb-2">
                            <label id="mobilename-label">Please Enter Your Email Address</label>
                            <input type="text" class="input-field" name="book_email_email" id="book_email_email"
                                placeholder="Email Address">
                            <p id="book_email_email_error" style="display:none;color:red;"></p>
                        </div>
                        <a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp"
                            data-bs-target="#exampleModalLong">Can't access your email? Log in with WhatsApp</a>
                        <div class="text-center mt-3">
                            <button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button"
                                disabled id="spinner_button_email_book1" style="display: none;">

                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                                Loading...

                            </button>
                            <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                id="submit_button_email_book1"
                                onclick="book_email_goToOtpVerification('1')">Continue</button>
                        </div>
                    </div>

                    <!-- STEP 2: OTP Verification -->
                    <div id="booknow-email-step-otp" style="display: none;">
                        <label id="mobilename-label">Please enter the <strong>OTP</strong> that was sent to:<br>
                            <span id="book_email_address_model">+971 58 520 0722</span>
                        </label>

                        <div class="d-flex justify-content-center gap-2 my-3">
                            <input type="text" maxlength="1" class="book-email-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="text" maxlength="1" class="book-email-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="text" maxlength="1" class="book-email-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="text" maxlength="1" class="book-email-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="text" maxlength="1" class="book-email-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="text" maxlength="1" class="book-email-otp-input form-control text-center"
                                style="width: 40px;">
                        </div>
                        <p id="book_email_otp_error" style="display:none;color:red;"></p>
                        <a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp"
                            data-bs-target="#exampleModalLong">Can't access your email? Log in with WhatsApp</a>

                        <div class="text-center mt-3">
                            <button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button"
                                disabled id="spinner_button_email_book2" style="display: none;">
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>Loading...</button>

                            <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                id="submit_button_email_book2" onclick="book_email_goToOtpVerification('2')">Verify
                                Email</button>
                        </div>
                    </div>

                    <!-- STEP 3: Personal Details -->
                    <div id="booknow-email-step-details" style="display: none;">
                        <label id="mobilename-label">Contact information</label>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="book_email_name" id="book_email_name"
                                placeholder="Full Name">
                            <p id="book_email_name_error" style="display:none;color:red;"></p>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" id="book_email_mobile" name="book_email_mobile"
                                placeholder="Phone Number" onkeypress="return validateNumber(event)">
                            <p id="book_email_mobile_error" style="display:none;color:red;"></p>
                        </div>

                        <div class="text-center mt-3">
                            <button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button"
                                disabled id="spinner_button_email_book3" style="display: none;"><span
                                    class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>Loading...</button>

                            <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                id="submit_button_email_book3" onclick="book_email_goToOtpVerification('3')">All
                                Done</button>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('privacy_policy') }}" class="footer-link me-3">Privacy Policy</a>
                            <a href="{{ route('term_condition') }}" class="footer-link">Terms of Service</a>
                        </div>
                    </div>


                </form>
            </div>

        </div>
    </div>
</div>

<!-- Email Otp Popup end -->
<script>
    function submitLoginFormAjax(formId, callback) {
        var form = document.getElementById(formId);
        var formData = new FormData(form);
        var url = form.action;

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function (response) {
                if (response.success) {
                    window.isUserLoggedIn = true;
                    $('.modal').modal('hide');
                    if (callback && typeof callback === 'function') {
                        callback();
                    }
                } else {
                    alert(response.message || 'Login failed');
                    $('#spinner_button_phone_book3').hide();
                    $('#submit_button_phone_book3').show();
                    $('#spinner_button_email_book3').hide();
                    $('#submit_button_email_book3').show();
                }
            },
            error: function (xhr) {
                var message = 'An error occurred. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                alert(message);
                $('#spinner_button_phone_book3').hide();
                $('#submit_button_phone_book3').show();
                $('#spinner_button_email_book3').hide();
                $('#submit_button_email_book3').show();
            }
        });
    }

    function proceedAfterLogin() {
        if (typeof nextStep === 'function') {
            nextStep(3);
        }
    }
</script>
<script src="{{ asset('public/site/js/otp_functions.js') }}"></script>
