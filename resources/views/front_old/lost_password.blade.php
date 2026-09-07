@include('front.includes.header')
<div class="body_content">
    <!-- Our LogIn Area -->
    <section class="our-login">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto wow fadeInUp" data-wow-delay="300ms">
                    <div class="main-title text-center">
                        <h2 class="title">Forgot Password</h2>

                    </div>
                </div>
            </div>
            <form action="{{ url('resetpassword') }}" id="category_form" method="POST">
                @csrf
                <div class="row wow fadeInRight" data-wow-delay="300ms">
                    <div class="col-xl-6 mx-auto">
                        <div
                            class="log-reg-form search-modal form-style1 bgc-white p50 p30-sm default-box-shadow1 bdrs12">
                            <div class="mb30">

                                <p class="text">Don't have an account? <a href="{{ url('Sign-Up') }}"
                                        class="text-thm" style="color: #0040E6;">Sign
                                        Up!</a></p>
                            </div>
                            <div class="mb20">
                                <label class="form-label fw600 dark-color requiredStar">Email Address</label>
                                <input type="text" id="email" name="email" class="form-control"
                                    placeholder="Enter Email Address">
                                <p class="form-error-text" id="email_error" style="color: red; margin-top: 10px;">
                                </p>
                            </div>

                            <span id="contact_error_login" class="error alert-message valierror "
                                style="display: none;"></span>

                                @if (Session::get('L_strsucessMessageForegot') != '')
                                    <p style="color: #28a745;font-size: 20px;text-align: center;">Email Sent Successfully</p>
                                @endif

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

            jQuery('#email_error').html("Please Enter Valid Email");
            jQuery('#email_error').show().delay(0).fadeIn('show');
            jQuery('#email_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#email').offset().top - 150
            }, 1000);
            return false;

        }


        $.ajax({
            type: "post",
            url: "{{ url('email-check-login') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "email": email,

            },
            success: function(returndata) {
                if (returndata == 0) {

                    // alert(returndata);

                    jQuery('#contact_error_login').html(" Email OR Password Not Valid ");
                    jQuery('#contact_error_login').show().delay(0).fadeIn('show');
                    jQuery('#contact_error_login').show().delay(2000).fadeOut('show');
                    return false;


                } else {


                    // alert(returndata);
                    $('#category_form').submit();


                }



            }
        });




    }
</script>
