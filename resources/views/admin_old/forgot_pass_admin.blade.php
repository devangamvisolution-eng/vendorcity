<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<title>VendorsCity</title>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="{{ asset('public/admin/assets/img/favicon_new.png') }}">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ asset('public/admin/assets/css/bootstrap.min.css')}}">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/fontawesome/css/fontawesome.min.css')}}">
		<link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/fontawesome/css/all.min.css')}}">
		
		<!-- Main CSS -->
		<link rel="stylesheet" href="{{ asset('public/admin/assets/css/style.css')}}">
		
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
	
		<!-- Main Wrapper -->
        <div class="main-wrapper login-body">
            <div class="login-wrapper">
            	<div class="container">
					
				
                	<div class="loginbox"> 
                        <div class="login-right">
							<div class="login-right-wrap">
                                <img class="img-fluid logo-dark mb-2" src="{{asset('public/admin/assets/img/logo.png')}}" alt="Logo">
								<h1>Forgot Password?</h1>
								<p class="account-subtitle">Enter your email to get a password reset link</p>
								
								<!-- Form -->
								<form action="{{ url('lost-password') }}" id="category_form" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="lost_pass" >
									<div class="form-group">
										<label class="form-control-label">Email Address</label>
										
                                        <input type="text" id="email" name="email" class="form-control"
                                    placeholder="Enter Email Address">
                                    <p class="form-error-text" id="email_error" style="color: red; margin-top: 10px;">
                                    </p>
									</div>
                                    <span id="contact_error_login" class="error alert-message valierror "
                                style="display: none;color: red;"></span>

                                @if (Session::get('L_strsucessMessageForegot_admin') != '')
                                    <p style="color: #28a745;font-size: 20px;text-align: center;">Email Sent Successfully</p>
                                @endif
									<div class="form-group mb-0">
										<button class="btn btn-lg btn-block btn-primary w-100" type="button" onclick="validation()">Reset Password</button>
									</div>
								</form>
								<!-- /Form -->
								
								<div class="text-center dont-have">Remember your password? <a href="{{ url('admin') }}">Login</a></div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="{{ asset('public/admin/assets/js/jquery-3.6.0.min.js')}}"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="{{ asset('public/admin/assets/js/bootstrap.bundle.min.js')}}"></script>
		
		<!-- Feather Icon JS -->
		<script src="{{ asset('public/admin/assets/js/feather.min.js')}}"></script>
		
		<!-- Custom JS -->
		<script src="{{ asset('public/admin/assets/js/script.js')}}"></script>

        <script>
            function validation(){
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
            url: "{{ url('email-check-login-admin') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "email": email,

            },
            success: function(returndata) {
                if (returndata == 0) {

                    // alert(returndata);

                    jQuery('#contact_error_login').html(" Email Id Is Not Register With VendorsCity ");
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

	</body>
</html>