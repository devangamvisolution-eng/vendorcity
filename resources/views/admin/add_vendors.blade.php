@extends('admin.includes.Template')
<link rel="stylesheet" href="{{ asset('public/site/css/intlTelInput.css') }}">

<script src="{{ asset('public/site/js/intlTelInput.min.js') }}"></script>
<style>
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

    .mobile_div .iti {
        width: 100% !important;
    }
</style>

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Vendors</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('vendors.index') }}">Vendors</a></li>

                        <li class="breadcrumb-item active">Add Vendors</li>

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

                        <!-- <h4 class="card-title">Basic Info</h4> -->

                        <form id="category_form" action="{{ route('vendors.store') }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="row">
                                <div class="col-md-6" style="display: none;">
                                    <div class="form-group">
                                        <label for="category">User Category</label>
                                        {{-- <select class="form-control" id="role_id" name="role_id" disabled>
                                        @foreach ($permission_data as $permission)
                                        <option value="{{ $permission->id }}" data-value="{{ $permission->id }}">
                                            {{ $permission->cname }}
                                        </option>
                                        @endforeach
                                    </select> --}}
                                        <input type="hidden" name="hidden_role_id" id="hidden_role_id" value="10">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Company Name</label>
                                        <input id="name" name="name" type="text" class="form-control"
                                            placeholder="Enter Name" value="" />

                                        <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input id="user_name" name="user_name" type="hidden" class="form-control"
                                        placeholder="Enter  Name" value="" />
                                </div>

                                {{-- add more start --}}

                                <div class="row">
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
                                    <div class="col-md-2">
                                        <div class="form-group"> <label for="email">Company Email</label>
                                            <input type="text" id="c_email" name="c_email[]" class="form-control"
                                                placeholder="Enter Email">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group"> <label for="telephone">Phone</label>
                                            <input type="text" id="telephone" name="telephone[]"
                                                onkeypress="return validateNumber(event)" class="form-control company-phone"
                                                placeholder="Enter Telephone">
                                        </div>
                                    </div>
                                </div>
                                <div class="input_fields_wrap12"></div>
                                <div class="form-group">

                                    <div class="col-sm-12">

                                        <button
                                            style="border: medium none;margin-right: 50px;line-height: 25px;margin-top: -62px;"
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button12">Add</button>

                                    </div>

                                </div>

                                {{-- add more End --}}

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="category">What services do you
                                            offer?
                                            (Click all that apply)</label>

                                        <select class="form-control multiple" id="serviceList" name="serviceList[]"
                                            multiple="multiple">
                                            <option value="">Select Service</option>
                                            @foreach ($service_data as $service)
                                                <option value="{{ $service->id }}">{{ $service->servicename }}</option>
                                            @endforeach
                                        </select>

                                        <p class="form-error-text" id="serviceList_error"
                                            style="color: red; margin-top: 10px;">

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label class="form-label" for="category">What Sub Services do you
                                            offer?
                                            (Click all that apply)</label>

                                        <select class="form-control multiple" id="subserviceList" name="subserviceList[]"
                                            multiple="multiple">
                                            <option value="">Select Service</option>

                                        </select>
                                        <p class="form-error-text" id="subserviceList_error"
                                            style="color: red; margin-top: 10px;">

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Company Website</label>
                                        <input id="companywebsite" name="companywebsite" type="text"
                                            class="form-control" placeholder="Enter Company Website" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Company City</label>
                                        <select class="form-control multiple" id="city" name="city[]"
                                            multiple="multiple">
                                            <option value="">Select Company City</option>
                                            @foreach ($city_data as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Company Role</label>
                                        <input id="crole" name="crole" type="text" class="form-control"
                                            placeholder="Enter Company Role" value="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Parent Company Name</label>
                                        <input id="parentcname" name="parentcname" type="text" class="form-control"
                                            placeholder="Enter Parent Company Name" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Establishment Date</label>
                                        <input id="establishment_date" name="establishment_date" type="date"
                                            class="form-control" placeholder="Select Establishment Date" />
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4 mb-3">
                                    <h4>Document Section</h4>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Company Logo (90px * 90px)</label>
                                        <input id="company_logo" name="company_logo" type="file" class="form-control"
                                            placeholder="Select Company Logo" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">VAT Certificate<span class="text-danger">*</span></label>
                                        <input id="vatcertificate" name="vatcertificate" type="file"
                                            class="form-control" placeholder="Select VAT Certificate" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">TRN Certificate Number<span
                                                class="text-danger">*</span></label>
                                        <input id="trn_certificate_number" name="trn_certificate_number" type="text"
                                            class="form-control" placeholder="Enter TRN Certificate Number" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Trade License<span class="text-danger">*</span></label>
                                        <input id="tradelicense" name="tradelicense" type="file" class="form-control"
                                            placeholder="Select Trade License" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Trade License Number<span
                                                class="text-danger">*</span></label>
                                        <input id="trade_license_number" name="trade_license_number" type="text"
                                            class="form-control" placeholder="Enter Trade License Number" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Trade License Expiry Date<span
                                                class="text-danger">*</span></label>
                                        <input id="tlexpiry" name="tlexpiry" type="date" class="form-control"
                                            placeholder="Select Trade License Expiry Date" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Passport (authorized person)<span
                                                class="text-danger">*</span></label>
                                        <input id="passport" name="passport" type="file" class="form-control"
                                            placeholder="Select Passport" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Passport Number (authorized person)<span
                                                class="text-danger">*</span></label>
                                        <input id="passport_number" name="passport_number" type="text"
                                            class="form-control" placeholder="Enter Passport Number" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Passport Expiry Date (authorized person)<span
                                                class="text-danger">*</span></label>
                                        <input id="passport_expiry" name="passport_expiry" type="date"
                                            class="form-control" placeholder="Select Passport Expiry Date" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Emirates ID (authorized person)<span
                                                class="text-danger">*</span></label>
                                        <input id="emirates_id" name="emirates_id" type="file" class="form-control"
                                            placeholder="Select Emirates Id" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Emirates ID Number (authorized person)<span
                                                class="text-danger">*</span></label>
                                        <input id="emirates_id_number" name="emirates_id_number" type="text"
                                            class="form-control" placeholder="Enter Emirates ID Number" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Emirates ID Expiry Date (authorized person)<span
                                                class="text-danger">*</span></label>
                                        <input id="emirates_id_expiry" name="emirates_id_expiry" type="date"
                                            class="form-control" placeholder="Select Emirates ID Expiry Date" />
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4 mb-3">
                                    <h4>Additional Information</h4>
                                    <hr>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        @php $maxStaff = 20; @endphp
                                        <label for="">No Of Staff</label>
                                        <select class="form-control" id="staff" name="staff">
                                            <option value="">Select No Of Staff</option>
                                            @for ($i = 1; $i <= $maxStaff; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Remarks</label>
                                        <input id="remarks" name="remarks" type="text" class="form-control"
                                            placeholder="Enter Remarks" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Social Media</label>
                                        <input id="socialmedai" name="socialmedai" type="text" class="form-control"
                                            placeholder="Enter Social Media" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Email For Login</label>
                                        <input id="email" name="email" type="text" class="form-control"
                                            placeholder="Enter Email" />
                                        <p class="form-error-text" id="email_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Password</label>
                                        <input id="password" name="password" type="password" class="form-control"
                                            placeholder="Enter Password" />
                                        <p class="form-error-text" id="password_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Confirm Password</label>
                                        <input id="conf_password" name="conf_password" type="password"
                                            class="form-control" placeholder="Enter Confirm Password" />
                                        <p class="form-error-text" id="confirm_password_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group mobile_div">
                                        <label for="name">Company Mobile No.</label>
                                        <input type="hidden" name="country_code_vendor" id="country_code_vendor"
                                            value="">
                                        <input id="mobile" name="mobile" type="text" class="form-control"
                                            placeholder="Enter Mobile No." onkeypress="return validateNumber(event)" />
                                        <p class="form-error-text" id="mobile_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Rating</label>
                                        <input id="rating" name="rating" type="number" class="form-control"
                                            placeholder="Enter Rating" />
                                        <p class="form-error-text" id="rating_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Numbers Of Review</label>
                                        <input id="number_of_review" name="number_of_review" type="number"
                                            class="form-control" placeholder="Enter Numbers Of Review" />
                                        <p class="form-error-text" id="number_of_review_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Review Link</label>
                                        <input id="review_link" name="review_link" type="text" class="form-control"
                                            placeholder="Enter Review Link" />
                                        <p class="form-error-text" id="review_link_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-12" style="display:none;">
                                    <div class="form-group">
                                        <label for="name"> Short Description</label>
                                        <textarea class="form-control" name="short_description" id="short_description"></textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('vendors.index') }}"> Cancel</a>

                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>

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

    <!-- /Main Wrapper -->



    <script>
        $("#city").select2({
            placeholder: "Select a Cities" // Replace with your desired placeholder text
        });

        $("#serviceList").select2({
            placeholder: "Select a Service" // Replace with your desired placeholder text
        });
        $("#subserviceList").select2({
            placeholder: "Select a Sub Service" // Replace with your desired placeholder text
        });

        // $(document).ready(function() {
        //     var role_id = jQuery("#role_id").val();

        //     $("#hidden_role_id").val(role_id);
        // });



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
                    scrollTop: $('#serviceList').offset().top - 150
                }, 1000);
                return false;
            }

            var subserviceList = $('select[name="subserviceList[]"]').val();

            if (!subserviceList || subserviceList.length === 0) {
                jQuery('#subserviceList_error').html("Please select at least one subservice");
                jQuery('#subserviceList_error').show().delay(0).fadeIn('show');
                jQuery('#subserviceList_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#subserviceList').offset().top - 150
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

            var url = '{{ url('vendor_check_mail') }}';

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

                        $('#spinner_button').show();

                        $('#submit_button').hide();

                        $('#category_form').submit();

                    }
                }
            });







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



    <script type="text/javascript" language="javascript">
        /* $(document).ready(function() {

                    var max_fields = 50;

                    var wrapper = $(".input_fields_wrap12");

                    var add_button = $("#add_field_button12");



                    var b = 0;

                    $(add_button).click(function(e) { //alert('ok');

                        e.preventDefault();

                        if (b < max_fields) {

                            b++;

                            $(wrapper).append(

                                '<div class="row"><div class="col-md-2"><div class="form-group"><label for="poc">POC Full</label><input type="text" id="poc" name="poc[]" class="form-control" placeholder="Enter POC"></div></div><div class="col-md-2"><div class="form-group"> <label for="poctitle">POC Title</label><input type="text" id="poctitle" name="poctitle[]" class="form-control" placeholder="Enter  POC Title"></div></div><div class="col-md-2"><div class="form-group"> <label for="email">Company Email</label><input type="text" id="c_email" name="c_email[]" class="form-control" placeholder="Enter Email"></div></div><div class="col-md-2"><div class="form-group"><label for="telephone">Phone</label><input type="text" id="telephone" name="telephone[]" onkeypress="return validateNumber(event)" class="form-control" placeholder="Enter Telephone"></div></div><a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 127px;">Remove</a></div>'
                            );

                        }

                    });

                    $(wrapper).on("click", ".remove_field1", function(e) {

                        e.preventDefault();

                        $(this).parent('div').remove();

                        b--;

                    })

                });
         */

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
                        <div class="form-group">
                            <label for="poc">POC Full</label>
                            <input type="text" name="poc[]" class="form-control" placeholder="Enter POC">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="poctitle">POC Title</label>
                            <input type="text" name="poctitle[]" class="form-control" placeholder="Enter POC Title">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="email">Company Email</label>
                            <input type="text" name="c_email[]" class="form-control" placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="telephone">Phone</label>
                            <input type="tel" name="telephone[]" class="form-control company-phone" placeholder="Enter Telephone">
                        </div>
                    </div>
                    <a href="#" class="btn btn-danger pull-right remove_field1"
                       style="margin-top: 23px; width: 10%; height: 38px; margin-left: 54px;">Remove</a>
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
                    url: "{{ route('front.getSubservices', ['city' => 'dubai']) }}",
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
    </script>


@stop
