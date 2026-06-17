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
								<h1>Reset Password</h1>
								
								<!-- Form -->
								<form action="{{ url('set_password_vendor', $uid) }}" id="category_form" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" id="action" value="reset-password">
									<div class="form-group">
										<label class="form-control-label">New Password</label>
										
                                        <input type="text" id="password" name="password" class="form-control"
                                    placeholder="Enter New Password">
                                <p class="form-error-text" id="password_error" style="color: red; margin-top: 10px;">
                                    </p>
									</div>
                                    <div class="form-group">
                                        <label class="form-label fw600 dark-color">Confirm Password </label>
                                <input type="text" id="cpassword" name="cpassword" class="form-control"
                                    placeholder="Enter Confirm Password">
                                <p class="form-error-text" id="cpassword_error" style="color: red; margin-top: 10px;">
                                </p>
                                    </div>
                                    <span id="contact_error_login" class="error alert-message valierror "
                                style="display: none;"></span>

                                @if (Session::get('L_strsucessMessageForegot_admin') != '')
                                    <p style="color: #28a745;font-size: 20px;text-align: center;">Email Sent Successfully</p>
                                @endif
									<div class="form-group mb-0">
										<button class="btn btn-lg btn-block btn-primary w-100" type="button" onclick="validation()">Submit</button>
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

	</body>
</html>