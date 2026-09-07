@include('front.includes.header')
<style>
    .main-title {
        margin-bottom: 30px;
    }
    @media only screen and (max-width: 600px) {
      .breadcumb-section {
          padding: 20px 15px;
      }
    }
</style>
<!-- Our Terms & Conditions -->

<section class="breadcumb-section pt-4 container mt120">
<div>
    <div class="container cta-service-v3 cta-banner mx-auto maxw1700 pt120 pb120 position-relative overflow-hidden d-flex align-items-center px30-lg" style="background-image: linear-gradient(to right, #0040E6, #FFD312); height: 220px; border-radius: 20px;">
        
        <!--<img class="service-v3-vector d-none d-lg-block" src="{{ asset('public/site/images/test_new.jpg') }}"
            alt="Customer service experience with Vendorscity UAE">-->
        
            <div class="row wow fadeInUp container">
                <div class="col-xl-12">
                    <div class="position-relative">
                        <h1 class=" banner_title" style="color: #fff;" >Contact Us</h1>
                        <!-- <p class="text mb30 text-white">Give your visitor a smooth online experience with a solid UX design</p> -->
                        <!--<div class="d-flex align-items-center">
							<h6 class="mb-0" style="color: #fff;" >Use Code MoveitMoveit</h6>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pt-0">
    <div class="container">
        <div class="row wow fadeInUp container" data-wow-delay="300ms">
            <div class="col-lg-6 p50">
                <div class="position-relative">
                    <div class="main-title">
                        <h4 class="form-title mb25">Customer Support.</h4>
                        <p class="text">For inquiries regarding your account, bookings, or general questions, please
                            contact our customer support team.</p>
                    </div>
                    <div class="iconbox-style1 contact-style d-flex align-items-start mb30">
                        <div class="icon flex-shrink-0"><span class="flaticon-call"></span></div>
                        <div class="details">
                            <h5 class="title">Phone</h5>
                            <p class="mb-0 text">+971 56 VENDORS (836 3677)</p>
                        </div>
                    </div>
                    <div class="iconbox-style1 contact-style d-flex align-items-start mb30">
                        <div class="icon flex-shrink-0"><span class="flaticon-mail"></span></div>
                        <div class="details">
                            <h5 class="title">Email</h5>
                            <p class="mb-0 text">support@vendorscity.com</p>
                        </div>
                    </div>
                </div>
                <div class="position-relative mt40">
                    <div class="main-title">
                        <p class="text">If you're a vendor and need assistance, our vendor support team is ready to
                            help.</p>
                    </div>
                    <div class="iconbox-style1 contact-style d-flex align-items-start mb30">
                        <div class="icon flex-shrink-0"><span class="flaticon-call"></span></div>
                        <div class="details">
                            <h5 class="title">Phone</h5>
                            <p class="mb-0 text">+971 56 VENDORS (836 3677)</p>
                        </div>
                    </div>
                    <div class="iconbox-style1 contact-style d-flex align-items-start mb30">
                        <div class="icon flex-shrink-0"><span class="flaticon-mail"></span></div>
                        <div class="details">
                            <h5 class="title">Email</h5>
                            <p class="mb-0 text">hello@vendorscity.com</p>
                        </div>
                    </div>
                </div>
                <div class="position-relative mt40">
                    <div class="main-title">
                        <h4 class="form-title mb25">Office Hours</h4>
                        <p class="text">Our office is open during the following hours:</p>
                    </div>
                    <div class="iconbox-style1 contact-style d-flex align-items-start mb30">
                        <div class="icon flex-shrink-0"><span class="flaticon-call"></span></div>
                        <div class="details">
                            <h5 class="title">Office Time</h5>
                            <p class="mb-0 text">Monday to Sunday: 8:00 AM - 6:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="default-box-shadow1 bdrs8 bdr1 p50 mb30-md bgc-white">
                    <h4 class="form-title mb25">Get in touch with us</h4>
                    <p class="text mb30">Reach out to us for any inquiries, feedback, or assistance</p>

                    <form id="contact_us_form" action="{{ url('/contact_us_data') }}" method="POST"
                        enctype="multipart/form-data" class="form-style1">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb20">
                                    <label class="heading-color ff-heading fw500 mb10 requiredStar" for="">First
                                        Name</label>
                                    <input type="text" class="form-control" placeholder="" name="fname"
                                        id="fname">
                                    <p class="form-error-text" id="fname_error" style="color: red; margin-top: 10px;">
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb20">
                                    <label class="heading-color ff-heading fw500 mb10 requiredStar" for="">Last
                                        Name</label>
                                    <input type="text" class="form-control" placeholder="" name="lname"
                                        id="lname">
                                    <p class="form-error-text" id="lname_error" style="color: red; margin-top: 10px;">
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb20">
                                    <label class="heading-color ff-heading fw500 mb10 requiredStar" for="">Email</label>
                                    <input type="email" class="form-control" placeholder="" name="email"
                                        id="email">
                                    <p class="form-error-text" id="email_error"
                                        style="color: red; margin-top: 10px;">
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb20">
                                    <label class="heading-color ff-heading fw500 mb10 requiredStar" for="">Mobile</label>
                                    <input type="text" class="form-control" placeholder="" name="mobile"
                                        id="mobile" onkeypress="return validateNumber(event)">
                                    <p class="form-error-text" id="mobile_error"
                                        style="color: red; margin-top: 10px;">
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb20">
                                    <label class="heading-color ff-heading fw500 mb10" for="">Messages</label>
                                    <textarea name="message" id="messages" cols="30" rows="6" placeholder="Description"></textarea>
                                    <p class="form-error-text" id="messages_error"
                                        style="color: red; margin-top: 10px;">
                                    </p>
                                </div>
                            </div>
                            @php
                            $captcha = rand('1111','9999');

                            session::put('captcha',$captcha);
                            @endphp
                        

                            <div class="col-md-12">
                                <div class="mb20">
                                    <label class="heading-color ff-heading fw500 mb10" for="">Enter This code below: {{$captcha}} </label>
                                   <input type="text" id="captcha" name="captcha" placeholder="Please Enter code" class="form-control">
                                    <p class="form-error-text" id="code_error"
                                        style="color: red; margin-top: 10px;">
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-12">

                                <div class="">
                                    <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                        style="display: none;">

                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>

                                        Loading...

                                    </button>
                                    <a class="ud-btn btn-thm" href="#" type="button"
                                        onclick="javascript:contact_us_validation()" id="submit_button">Send
                                        Messages<i class="fal fa-arrow-right-long"></i></a>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('front.includes.footer')

<script>
    function contact_us_validation() {

        var fname = jQuery("#fname").val();

        if (fname == '') {
            jQuery('#fname_error').html("Please Enter First Name");
            jQuery('#fname_error').show().delay(0).fadeIn('show');
            jQuery('#fname_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#fname').offset().top - 150
            }, 1000);
            return false;
        }
        var lname = jQuery("#lname").val();
        if (lname == '') {
            jQuery('#lname_error').html("Please Enter Last Name");
            jQuery('#lname_error').show().delay(0).fadeIn('show');
            jQuery('#lname_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#lname').offset().top - 150
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

        var filter = /^\d{10}$/;

        if (mobile != '' && !filter.test(mobile)) {

            jQuery('#mobile_error').html("Please Enter Valid Mobile");
            jQuery('#mobile_error').show().delay(0).fadeIn('show');
            jQuery('#mobile_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#mobile').offset().top - 150
            }, 1000);
            return false;

        }
        var message = jQuery("#messages").val();
        if (message == '') {
            jQuery('#messages_error').html("Please Enter Message");
            jQuery('#messages_error').show().delay(0).fadeIn('show');
            jQuery('#messages_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#messages').offset().top - 150
            }, 1000);
            return false;
        }
        var captcha_store = '{{session::get('captcha')}}';

        var captcha = jQuery("#captcha").val();
        if (captcha == '') {
            jQuery('#code_error').html("Please Enter Captcha Code.");
            jQuery('#code_error').show().delay(0).fadeIn('show');
            jQuery('#code_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#captcha').offset().top - 150
            }, 1000);
            return false;

        }
        if (captcha != captcha_store) {
                jQuery('#code_error').html("Please Enter Valid Captcha Number");
                jQuery('#code_error').show().delay(0).fadeIn('show');
                jQuery('#code_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#captcha').offset().top - 150
                }, 1000);
                return false;
        }
        $('#spinner_button').show();

        $('#submit_button').hide();

        $('#contact_us_form').submit();



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
