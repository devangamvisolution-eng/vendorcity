@include('front.includes.header')
<style>
    .loginBtn {
      box-sizing: border-box;
      position: relative;
      /* width: 13em;  - apply for fixed size */
      margin: 0.2em;
      padding: 0 15px 0 46px;
      border: none;
      text-align: left;
      line-height: 34px;
      white-space: nowrap;
      border-radius: 0.2em;
      font-size: 16px;
      color: #FFF;
    }
    .loginBtn:before {
      content: "";
      box-sizing: border-box;
      position: absolute;
      top: 0;
      left: 0;
      width: 34px;
      height: 100%;
    }
    .loginBtn:focus {
      outline: none;
    }
    .loginBtn:active {
      box-shadow: inset 0 0 0 32px rgba(0,0,0,0.1);
    }
    
    
    /* Facebook */
    .loginBtn--facebook {
      background-color: #4C69BA;
      background-image: linear-gradient(#4C69BA, #3B55A0);
      /*font-family: "Helvetica neue", Helvetica Neue, Helvetica, Arial, sans-serif;*/
      text-shadow: 0 -1px 0 #354C8C;
    }
    .loginBtn--facebook:before {
      border-right: #364e92 1px solid;
      background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_facebook.png') 6px 6px no-repeat;
    }
    .loginBtn--facebook:hover,
    .loginBtn--facebook:focus {
      background-color: #5B7BD5;
      background-image: linear-gradient(#5B7BD5, #4864B1);
    }
    
    
    /* Google */
    .loginBtn--google {
      /*font-family: "Roboto", Roboto, arial, sans-serif;*/
      background: #DD4B39;
    }
    .loginBtn--google:before {
      border-right: #BB3F30 1px solid;
      background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_google.png') 6px 6px no-repeat;
    }
    .loginBtn--google:hover,
    .loginBtn--google:focus {
      background: #E74B37;
    }
    .our-login {
        padding: 50px 0;
    }
    .main-title {
        margin-bottom: 0;
    }
    .fs18 {
        font-size: 18px;
    }
    
    .google-sign-in-button {
        cursor: pointer;
        transition: background-color .3s, box-shadow .3s;
        padding: 12px 16px 12px 42px;
        border: none;
        border-radius: 3px;
        box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 1px 1px rgba(0, 0, 0, .25);
        color: #6B7177 !important;
        font-size: 20px;
        font-weight: bolder;
        background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMTcuNiA5LjJsLS4xLTEuOEg5djMuNGg0LjhDMTMuNiAxMiAxMyAxMyAxMiAxMy42djIuMmgzYTguOCA4LjggMCAwIDAgMi42LTYuNnoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDE4YzIuNCAwIDQuNS0uOCA2LTIuMmwtMy0yLjJhNS40IDUuNCAwIDAgMS04LTIuOUgxVjEzYTkgOSAwIDAgMCA4IDV6IiBmaWxsPSIjMzRBODUzIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNNCAxMC43YTUuNCA1LjQgMCAwIDEgMC0zLjRWNUgxYTkgOSAwIDAgMCAwIDhsMy0yLjN6IiBmaWxsPSIjRkJCQzA1IiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNOSAzLjZjMS4zIDAgMi41LjQgMy40IDEuM0wxNSAyLjNBOSA5IDAgMCAwIDEgNWwzIDIuNGE1LjQgNS40IDAgMCAxIDUtMy43eiIgZmlsbD0iI0VBNDMzNSIgZmlsbC1ydWxlPSJub256ZXJvIi8+PHBhdGggZD0iTTAgMGgxOHYxOEgweiIvPjwvZz48L3N2Zz4=);
        background-color: white;
        background-repeat: no-repeat;
        background-position: 14px 17px;
        box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 2px 4px rgba(0, 0, 0, .25);
    }
    .google-sign-in-button a{
        color: #6B7177 !important;
    }
    
    </style>
<style>
    .our-register {
        padding: 50px 0;
    }
    .main-title {
        margin-bottom: 0;
    }
    .fs18 {
        font-size: 18px;
    }
</style>
<section class="our-register mt120">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto wow fadeInUp" data-wow-delay="300ms">
                <div class="main-title text-center">
                    <h2 class="title">Sign Up</h2>
                    {{-- <p class="paragraph">Give your visitor a smooth online experience with a solid UX design</p> --}}
                </div>
            </div>
        </div>
        <form id="category_form" action="{{ route('Sign-Up.store') }}" method="POST">
            @csrf
            @if (isset($decryptedId) && $decryptedId != '')
                <input type="hidden" name="refer_id" value="{{ $decryptedId }}">
            @endif

            <div class="row wow fadeInRight" data-wow-delay="300ms">
                <div class="col-xl-6 mx-auto">
                    <div class="log-reg-form search-modal form-style1 bgc-white p50 p30-sm default-box-shadow1 bdrs12">
                        <div class="mb30">
                            <h4>Let's create your account!</h4>
                            {{-- <p class="text mt20">Already have an account? <a href="{{ route('Sign-Up.create') }}"
                                    class="text-thm">Log In!</a></p> --}}
                        </div>
                        <div class="mb25">
                            <label class="form-label fw500 dark-color requiredStar">Name</label>
                            <input id="name" name="name" type="text" class="form-control"
                                placeholder="Enter Name">
                            <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;">
                            </p>
                        </div>
                        <div class="mb25">
                            <label class="form-label fw500 dark-color requiredStar">Email</label>
                            <input id="email" name="email" type="text" class="form-control"
                                placeholder="Enter Email">
                            <p class="form-error-text" id="email_error" style="color: red; margin-top: 10px;">
                            </p>
                        </div>

                        <div class="mb15">
                            <label class="form-label fw500 dark-color requiredStar">Password</label>
                            <input id="password" name="password" type="password" class="form-control"
                                placeholder="Enter Password">
                            <p class="form-error-text" id="password_error" style="color: red; margin-top: 10px;">
                            </p>
                        </div>

                        <div class="mb15">
                            <label class="form-label fw500 dark-color requiredStar">Confirm-Password</label>
                            <input id="conf_password" name="conf_password" type="password" class="form-control"
                                placeholder="Enter Confirm-Password">
                            <p class="form-error-text" id="conf_password_error" style="color: red; margin-top: 10px;">
                            </p>
                        </div>

                        <div class="mb15">
                            <label class="form-label fw500 dark-color requiredStar">Mobile</label>
                            <input id="mobile" name="mobile" type="text" class="form-control"
                                placeholder="Enter Mobile Number" onkeypress="return validateNumber(event)">
                            <p class="form-error-text" id="mobile_error" style="color: red; margin-top: 10px;">
                            </p>
                        </div>

                       @php
                            $captcha = rand('1111','9999');

                            session::put('captcha',$captcha);
                    @endphp
                        

                        <div class="mb15">
                            <label class="form-label fw500 dark-color requiredStar">Enter This code below: {{$captcha}}</label>
                            <input id="captcha" name="captcha" type="text" class="form-control"
                                placeholder="Enter This code" onkeypress="return validateNumber(event)">
                            <p class="form-error-text" id="code_error" style="color: red; margin-top: 10px;">
                            </p>
                        </div>

                        @error('captcha')
                            <p class="form-error-text" id="code_error"
                                style="color: red; margin-top: 10px;">{{ $message }}</p>
                            
                        @enderror

                        <div class="d-grid mb20">
                            <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                style="display: none;">

                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                                Loading...

                            </button>
                            <button type="button" class="ud-btn btn-thm default-box-shadow2"
                                onclick="javascript:category_validation()" id="submit_button">Create</button>

                            {{-- <button class="ud-btn btn-thm default-box-shadow2" type="button">Submit
                            <i class="fal fa-arrow-right-long"></i>
                        </button> --}}
                        </div>

                        <div class="mb30">

                            <p class="text mt20 fs18">Already have an account? <a href="{{ route('Sign-in') }}"
                                    class="text-thm" style="color: #0040E6;">Log In!</a></p>
                        </div>

                        <div class="or-seperator text-center"><i>or</i></div>
                                <p class="text-center">Sign Up with Google</p>
                                <div class="text-center">
                                   <!--  <button class="loginBtn loginBtn--facebook" disabled>
                                      Login with Facebook
                                    </button> -->

                                    <!--  <button class="loginBtn loginBtn--facebook" onclick="fbLogin();">
                                      Login with Facebook
                                    </button> -->

                                    {{-- <button class="loginBtn loginBtn--google">
                                    <a href="{{ url('auth/google') }}" style="color:white;">
                                        Login with Google
                                    </a>
                                    </button> --}}

                                    <button type="button" class="google-sign-in-button" >
                                        <a href="{{ url('auth/google') }}">
                                            Continue With Google
                                        </a>
                                    </button>

                                    {{-- <a href="{{ url('auth/google') }}">
                                        <img style="
                                        border: 1px solid #ccc;
                                    " class="bdrs15" src="{{ asset('public/site/images/googleLogin.jpg') }}" alt="">
                                    </a> --}}
                                </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@include('front.includes.footer')


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

        var url = '{{ url('registration_mail_check') }}';

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

                        jQuery('#password_error').html("Please Enter Password");
                        jQuery('#password_error').show().delay(0).fadeIn('show');
                        jQuery('#password_error').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#password').offset().top - 150
                        }, 1000);
                        return false;

                    }

                    var conf_password = jQuery("#conf_password").val();

                    if (conf_password == '') {

                        jQuery('#conf_password_error').html("Please Enter Confirm-Password");
                        jQuery('#conf_password_error').show().delay(0).fadeIn('show');
                        jQuery('#conf_password_error').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#conf_password').offset().top - 150
                        }, 1000);
                        return false;

                    }
                    if (conf_password != password) {

                        jQuery('#conf_password_error').html(
                            "Confirm Password Doesn't Match Password");
                        jQuery('#conf_password_error').show().delay(0).fadeIn('show');
                        jQuery('#conf_password_error').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#conf_password').offset().top - 150
                        }, 1000);
                        return false;

                    }

                    var mobile = jQuery("#mobile").val();
                    if (mobile == '') {

                        jQuery('#mobile_error').html("Please Enter Mobile");
                        jQuery('#mobile_error').show().delay(0).fadeIn('show');
                        jQuery('#mobile_error').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#mobile').offset().top - 150
                        }, 1000);
                        return false;

                    }
                    if (mobile != '') {
                        // var filter = /^\d{7}$/;
                        if (mobile.length < 7 || mobile.length > 15) {
                            jQuery('#mobile_error').html("Please Enter Valid Mobile Number");
                            jQuery('#mobile_error').show().delay(0).fadeIn('show');
                            jQuery('#mobile_error').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#mobile').offset().top - 150
                            }, 1000);
                            return false;
                        }
                    }

                    // var captcha_store = '{{session::get('captcha')}}';

                    // var captcha = jQuery("#captcha").val();
                    // if (captcha == '') {
                    //     jQuery('#code_error').html("Please Enter Captcha Number");
                    //     jQuery('#code_error').show().delay(0).fadeIn('show');
                    //     jQuery('#code_error').show().delay(2000).fadeOut('show');
                    //     $('html, body').animate({
                    //         scrollTop: $('#captcha').offset().top - 150
                    //     }, 1000);
                    //     return false;

                    // }
                    // if (captcha != captcha_store) {
                    //         jQuery('#code_error').html("Please Enter Valid Captcha Number");
                    //         jQuery('#code_error').show().delay(0).fadeIn('show');
                    //         jQuery('#code_error').show().delay(2000).fadeOut('show');
                    //         $('html, body').animate({
                    //             scrollTop: $('#captcha').offset().top - 150
                    //         }, 1000);
                    //         return false;
                    // }


                    $('#spinner_button').show();

                    $('#submit_button').hide();

                    $('#category_form').submit();

                }
            }
        });
    }

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
</script>
