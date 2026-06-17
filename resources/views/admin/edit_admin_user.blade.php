@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Edit User</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('adminuser.index') }}">User</a></li>

                        <li class="breadcrumb-item active">Edit User</li>

                    </ul>

                </div>

            </div>

        </div>

        <!-- /Page Header -->



        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">

            <span id="login_error"></span>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>



        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <form id="category_form" action="{{ route('adminuser.update', $adminuser->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            @method('PUT')

                            <div class="row">

                                <div class="form-group">

                                    <label for="adminuser">User Category</label>

                                    <select class="form-control" id="user_id" name="user_id">

                                        <option value="" selected>Select User Category</option>

                                        @foreach ($user_category as $user_data)
                                            <option value="{{ $user_data->id }}" <?php if ($user_data->id == $adminuser->role_id) {
                                                echo 'selected';
                                            } ?>>{{ $user_data->cname }}

                                            </option>
                                        @endforeach

                                    </select>
                                    <p class="form-error-text" id="user_error" style="color: red; margin-top: 10px;"></p>

                                </div>

                                <div class="form-group">

                                    <label for="name">Name</label>

                                    <input id="name" name="name" type="text" class="form-control"
                                        placeholder="Enter Name" value="{{ $adminuser->name }}" />
                                    <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>

                                </div>

                                <div class="form-group">

                                    <label for="name">User Name</label>

                                    <input id="user_name" name="user_name" type="text" class="form-control"
                                        placeholder="Enter User Name" value="{{ $adminuser->user_name }}" />
                                    <p class="form-error-text" id="user_name_error" style="color: red; margin-top: 10px;">
                                    </p>

                                </div>

                                {{-- <div class="form-group">

                                    <label for="name">Password</label>

                                    <input id="password" name="password" type="password" class="form-control"

                                        placeholder="Enter Password" value="{{ $adminuser->password }}" />

                                </div> --}}



                                <div class="form-group">

                                    <label for="name">Email</label>

                                    <input id="email" name="email" type="text" class="form-control"
                                        placeholder="Enter Email" value="{{ $adminuser->email }}" />

                                    <p class="form-error-text" id="email_error" style="color: red; margin-top: 10px;">
                                    </p>

                                </div>

                                <div class="form-group">

                                    <label for="name">Mobile No.</label>

                                    <input id="mobile" name="mobile" type="text" class="form-control"
                                        placeholder="Enter Mobile No." onkeypress="return validateNumber(event)"
                                        value="{{ $adminuser->mobile }}" />
                                    <p class="form-error-text" id="mobile_error" style="color: red; margin-top: 10px;">
                                    </p>
                                </div>

                            </div>

                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('adminuser.index') }}"> Cancel</a>

                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                                    Loading...

                                </button>

                                <button type="button" class="btn btn-primary" onclick="javascript:category_validation()"
                                    id="submit_button">Submit</button>

                                <!-- <input type="submit" name="submit" value="Submit" class="btn btn-primary"> -->

                            </div>

                        </form>



                    </div>

                </div>

            </div>

        </div>

    </div>

@stop

@section('footer_js')





    <script>
        function category_validation() {

            var user_id = jQuery("#user_id").val();

            if (user_id == '') {

                jQuery('#user_error').html("Please  Select User Category");
                jQuery('#user_error').show().delay(0).fadeIn('show');
                jQuery('#user_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#user_id').offset().top - 150
                }, 1000);
                return false;

            }



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



            var user_name = jQuery("#user_name").val();

            if (user_name == '') {

                jQuery('#user_name_error').html("Please Enter User Name");
                jQuery('#user_name_error').show().delay(0).fadeIn('show');
                jQuery('#user_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#user_name').offset().top - 150
                }, 1000);
                return false;

            }







            // var conf_password = jQuery("#conf_password").val();

            // if (conf_password == '') {

            //     jQuery('#validate').html("Please Enter Confirm Password");

            //     jQuery('#validate').show().delay(0).fadeIn('show');

            //     jQuery('#validate').show().delay(2000).fadeOut('show');

            //     $('html, body').animate({

            //         scrollTop: $('#validate').offset().top - 150

            //     }, 1000);

            //     return false;

            // }



            // if (conf_password != password) {

            //     jQuery('#validate').html("Confirm Password Doesn't Match Password");

            //     jQuery('#validate').show().delay(0).fadeIn('show');

            //     jQuery('#validate').show().delay(2000).fadeOut('show');

            //     $('html, body').animate({

            //         scrollTop: $('#validate').offset().top - 150

            //     }, 1000);

            //     return false;

            // }



            var email = jQuery("#email").val();

            if (email == '') {

                jQuery('#email_error').html("Plaese Enter Email Address.");
                jQuery('#email_error').show().delay(0).fadeIn('show');
                jQuery('#email_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#email').offset().top - 150
                }, 1000);
                return false;

            }



            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (!filter.test(email)) {

                jQuery('#email_error').html("Plaese Enter Valid Email Address.");
                jQuery('#email_error').show().delay(0).fadeIn('show');
                jQuery('#email_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#email').offset().top - 150
                }, 1000);
                return false;

            }



            var mobile = jQuery("#mobile").val();

            if (mobile == '') {

                jQuery('#mobile_error').html("Plaese Enter Mobile.");
                jQuery('#mobile_error').show().delay(0).fadeIn('show');
                jQuery('#mobile_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#mobile').offset().top - 150
                }, 1000);
                return false;

            }
            var filter = /^\d{10}$/;
            if (!filter.test(mobile)) {

                jQuery('#mobile_error').html("Plaese Enter Valid Mobile.");
                jQuery('#mobile_error').show().delay(0).fadeIn('show');
                jQuery('#mobile_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#mobile').offset().top - 150
                }, 1000);
                return false;

            }

            $('#spinner_button').show();

            $('#submit_button').hide();

            $('#category_form').submit();

        }
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
    </script>

@stop
