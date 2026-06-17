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

@media only screen and (max-width: 600px) {
    .mt120 {
        margin-top: 120px !important;
    }
}

</style>
<div class="body_content">
    <!-- Our LogIn Area -->
    <section class="our-login mt120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto wow fadeInUp" data-wow-delay="300ms">
                    <div class="main-title text-center" >
                        <h2 class="title">Log In </h2>

                    </div>
                </div>
            </div>
            <form action="{{ route('user_login') }}" id="category_form" method="post">
                @csrf
                <div class="row wow fadeInRight" data-wow-delay="300ms">
                    <div class="col-xl-6 mx-auto">
                        <div
                            class="log-reg-form search-modal form-style1 bgc-white p50 p30-sm default-box-shadow1 bdrs12">
                            {{-- <div class="mb30">
                                <h4>We're glad to see you again!</h4>
                                <p class="text">Don't have an account? <a href="{{ url('Sign-Up') }}"
                                        class="text-thm">Sign
                                        Up!</a></p>
                            </div> --}}
                            <div class="mb20">
                                <label class="form-label fw600 dark-color requiredStar">Email Address</label>
                                <input type="text" id="email" name="email" class="form-control"
                                    placeholder="Enter Email Address">
                                <p class="form-error-text" id="email_error" style="color: red; margin-top: 10px;">
                                </p>
                            </div>
                            <div class="mb15">
                                <label class="form-label fw600 dark-color requiredStar">Password</label>
                                <input type="password"id="password" name="password" class="form-control"
                                    placeholder="Enter Password">
                                <p class="form-error-text" id="password_error" style="color: red; margin-top: 10px;">
                                </p>
                            </div>
                            <span id="contact_error_login" class="error alert-message valierror "
                                style="display: none;"></span>
                            <div
                                class="checkbox-style1 d-block d-sm-flex align-items-center justify-content-between mb20">
                                <label class="custom_checkbox fz14 ff-heading">Remember me
                                    <input type="checkbox" checked="checked">
                                    <span class="checkmark"></span>
                                </label>
                                <a class="fz14 ff-heading" href="{{ url('forget-password') }}">Lost your password?</a>
                            </div>
                            <div class="d-grid mb20">
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>

                                    Loading...

                                </button>
                                <button type="button" class="ud-btn btn-thm" onclick="javascript:category_validation()"
                                    id="submit_button">Login</button>

                            </div>
                            <div class="or-seperator text-center"><i>or</i></div>
                                <p class="text-center">Login with your social media account</p>
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

                            <div class="mb30">
                                {{-- <h4>We're glad to see you again!</h4> --}}
                                <p class="text fs18">Don't have an account? <a href="{{ url('Sign-Up') }}"
                                        class="text-thm" style="color: #0040E6;">Sign Up!</a></p>
                            </div>


                        </div>
                    </div>


                    <div class="col-xl-4">

                        <div class="row">
                            @foreach (Cart::content() as $items)
                                <div class="col-xl-6">
                                    <div class="listing-style1"style="padding: 18px;">
                                        {{-- <div class="">
                                            @if ($items->options->image)
                                                <a href="{{ url('package-detail/' . $items->options->page_url) }}"><img
                                                        src="{{ asset('public/upload/packages/large/' . $items->options->image) }}"
                                                        alt="cart-1.png" width="100%"></a>
                                            @else
                                                <a href="{{ url('package-detail/' . $items->options->page_url) }}"><img
                                                        src="images/shop/cart-1.png" alt="cart-1.png"
                                                        width="100%"></a>
                                            @endif


                                        </div> --}}
                                        <div>

                                            {{ $items->name }} x {{ $items->qty }}
                                        </div>
                                        @php

                                            if ($items->options->discount_type != '') {
                                                if ($items->options->discount_type == 0) {
                                                    //percentage
                                                    $disc_price_new = ($items->price * $items->options->discount) / 100;

                                                    $disc_price = $items->price - $disc_price_new;

                                                    $p_price = $disc_price;
                                                } elseif ($items->options->discount_type == 1) {
                                                    $disc_price = $items->price - $items->options->discount;
                                                    $p_price = $disc_price;
                                                } else {
                                                    $disc_price = '0';
                                                    $p_price = $items->price;
                                                }
                                            } else {
                                                $disc_price = '0';
                                            }

                                        @endphp
                                        <div class="cart-price">
                                            {{-- <del>AED 1234</del>
                                                AED 1172.3 --}}
                                            @if ($disc_price != '0')
                                                <del>AED {{ $items->price }}</del>
                                                AED {{ $disc_price }}
                                            @else
                                                AED {{ $items->price }}
                                            @endif

                                        </div>
                                    </div>

                                </div>
                            @endforeach
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

        $.ajax({
            type: "post",
            url: "{{ url('check_login') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "email": email,
                "password": password,

            },
            success: function(returndata) {
                if (returndata == 1) {

                    $('#spinner_button').show();

                    $('#submit_button').hide();

                    $('#category_form').submit();

                } else if (returndata == 2) {
                    // Code for status not equal to 1
                    $('#contact_error_login').html("Account is not active.");
                    $('#contact_error_login').show().delay(2000).fadeOut('show');
                    return false;
                } else {
                    jQuery('#contact_error_login').html(" Email OR Password Not Valid ");
                    jQuery('#contact_error_login').show().delay(0).fadeIn('show');
                    jQuery('#contact_error_login').show().delay(2000).fadeOut('show');
                    return false;

                }



            }
        });




    }
</script>
<script>
window.fbAsyncInit = function() {
    FB.init({
      appId      : '1378858689331425000', 
      cookie     : true,  
      xfbml      : true, 
      version    : 'v2.8' 
    });
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
    }});
};
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
function fbLogin() {
    FB.login(function (response) {
        if (response.authResponse) {
            getFbUserData();
        } else {
        }
    }, {scope: 'email'});
}
function getFbUserData(){
    FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
    function (response) {
        var email = response.email;
        var fname = response.first_name+' '+response.last_name;
        var fid = response.id;
       // alert(email);
        $.ajax({
            type: "POST",
            url: "{{ url('facebook-login') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "email": email,
                "fname": fname,
                "fid": fid,
             },
            success:function(msg)
            { 
               // window.location.href="{{ url('/') }}";
               window.location.href = "{{ url('/') }}?loginSuccess=true";
            }
        });
    });
}
$(function() {
    if (window.location.href.indexOf('?loginSuccess=true') > -1) {
        // Display the success message on the main page
        $("#message_succsess").html("You have successfully logged in.");
        $('#message_succsess').show().delay(0).fadeIn('show');
       // $('#message_succsess').show().delay(2000).fadeOut('show');
        $('#message_succsess').show().delay(2000).fadeOut('show', function() {
                    
                    window.location.href = "{{ url('/') }}";
        });
    }
});
function fbLogout() {
    FB.logout(function() {
        document.getElementById('fbLink').setAttribute("onclick","fbLogin()");
        document.getElementById('fbLink').innerHTML = '<img src="fblogin.png"/>';
        document.getElementById('userData').innerHTML = '';
        document.getElementById('status').innerHTML = 'You have successfully logout from Facebook.';
    });
}
</script>
