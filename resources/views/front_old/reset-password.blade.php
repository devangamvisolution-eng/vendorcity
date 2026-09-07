@include('front.includes.header')
<div class="body_content">
    <!-- Our LogIn Area -->
    <section class="our-login">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto wow fadeInUp" data-wow-delay="300ms">
                    <div class="main-title text-center">
                        <h2 class="title">Reset Password</h2>

                    </div>
                </div>
            </div>
            <form action="{{ url('set_password', $uid) }}" id="category_form" method="POST">
                @csrf
                <input type="hidden" name="action" id="action" value="reset-password">
                <div class="row wow fadeInRight" data-wow-delay="300ms">
                    <div class="col-xl-6 mx-auto">
                        <div
                            class="log-reg-form search-modal form-style1 bgc-white p50 p30-sm default-box-shadow1 bdrs12">
                            <div class="mb30">

                                <p class="text">Don't have an account? <a href="{{ url('Sign-Up') }}"
                                        class="text-thm">Sign
                                        Up!</a></p>
                            </div>
                            <div class="mb20">
                                <label class="form-label fw600 dark-color requiredStar">New Password</label>
                                <input type="text" id="password" name="password" class="form-control"
                                    placeholder="Enter New Password">
                                <p class="form-error-text" id="password_error" style="color: red; margin-top: 10px;">
                                </p>
                            </div>
                            <div class="mb20">
                                <label class="form-label fw600 dark-color requiredStar">Confirm Password </label>
                                <input type="text" id="cpassword" name="cpassword" class="form-control"
                                    placeholder="Enter Confirm Password">
                                <p class="form-error-text" id="cpassword_error" style="color: red; margin-top: 10px;">
                                </p>
                            </div>

                            <span id="contact_error_login" class="error alert-message valierror "
                                style="display: none;"></span>

                            <div class="d-grid mb20">

                                <button type="button" class="ud-btn btn-thm"
                                    onclick="javascript:category_validation()">Submit</button>

                            </div>


                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>


@include('front.includes.footer')

<script>
    function category_validation() {

        var password = jQuery("#password").val();

        if (password == '') {
            jQuery('#password_error').html("Please Enter New Password");
            jQuery('#password_error').show().delay(0).fadeIn('show');
            jQuery('#password_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#password').offset().top - 150
            }, 1000);
            return false;
        }

        var cpassword = jQuery("#cpassword").val();

        if (cpassword == '') {

            jQuery('#cpassword_error').html("Please Enter Enter Confirm Password");
            jQuery('#cpassword_error').show().delay(0).fadeIn('show');
            jQuery('#cpassword_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#cpassword').offset().top - 150
            }, 1000);
            return false;

        }
        if (password !== cpassword) {

            jQuery('#cpassword_error').html("Password Doesn't Match");
            jQuery('#cpassword_error').show().delay(0).fadeIn('show');
            jQuery('#cpassword_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#cpassword').offset().top - 150
            }, 1000);
            return false;
        }


        $('#category_form').submit();


    }
</script>
