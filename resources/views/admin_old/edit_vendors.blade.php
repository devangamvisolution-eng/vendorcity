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

                    <h3 class="page-title">Edit Vendors</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('vendors.index') }}">Vendors</a></li>

                        <li class="breadcrumb-item active">Edit Vendors</li>

                    </ul>

                </div>

            </div>

        </div>

        <!-- /Page Header -->



        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">

                <strong>Success!</strong> {{ $message }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

            </div>
        @endif



        <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">

            <strong>Success! </strong><span id="success_message"></span>

            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->

        </div>



        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <form id="category_form" action="{{ route('vendors.update', $vendors->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            @method('PUT')

                            <div class="row">


                                <div class="form-group" style="display: none;">
                                    <label for="vendors">User Category</label>
                                    <select class="form-control" id="role_id" name="role_id">
                                        @foreach ($permission_data as $permission)
                                            <option value="{{ $permission->id }}" <?php if ($permission->id == $vendors->name) {
                                                echo 'selected';
                                            } ?>>
                                                {{ $permission->cname }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="hidden_role_id" id="hidden_role_id" value="">

                                </div>

                                <div class="form-group">
                                    <label for="name">Company Name</label>
                                    <input id="name" name="name" type="text" class="form-control"
                                        placeholder="Enter Name" value="{{ $vendors->name }}" />
                                    <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>
                                </div>



                                <div class="form-group">
                                    <input id="user_name" name="user_name" type="hidden" class="form-control"
                                        placeholder="Enter  Name" value="{{ $vendors->user_name }}" />
                                </div>


                                {{-- add more start --}}
                                @if ($attribute_data != '')
                                    <input type="hidden" name="poc1[]" value="">
                                    <input type="hidden" name="poctitle1[]" value="">
                                    <input type="hidden" name="c_email1[]" value="">
                                    <input type="hidden" name="telephone1[]" value="">
                                    <input type="hidden" name="country_code1[]" class="country_code_vendor">


                                    @for ($i = 0; $i < count($attribute_data); $i++)
                                        <div class="row">

                                            <input type="hidden" name="updateid1xxx[]"
                                                id="updateid1xxx{{ $i + 1 }}"
                                                value="{{ $attribute_data[$i]->id }}">

                                            <div class="col-md-2">
                                                <div class="form-group"> <label for="poc">POC Full</label>
                                                    <input type="text" id="pocu" name="pocu[]" class="form-control"
                                                        placeholder="Enter POC" value="{{ $attribute_data[$i]->poc }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group"> <label for="poctitle">POC Title</label>
                                                    <input type="text" id="poctitleu" name="poctitleu[]"
                                                        class="form-control" placeholder="Enter  POC Title"
                                                        value="{{ $attribute_data[$i]->poctitle }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group"> <label for="email">Company Email</label>
                                                    <input type="text" id="c_emailu" name="c_emailu[]"
                                                        class="form-control" placeholder="Enter Email"
                                                        value="{{ $attribute_data[$i]->c_email }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3 mobile_div">
                                                <div class="form-group"> <label for="telephone">Phone</label>
                                                    <input type="text" id="telephoneu" name="telephoneu[]"
                                                        onkeypress="return validateNumber(event)"
                                                        class="form-control company-phone" placeholder="Enter Telephone"
                                                        value="{{ $attribute_data[$i]->telephone }}">
                                                    <input type="hidden" name="country_codeu[]"
                                                        class="country_code_vendor"
                                                        value="{{ $attribute_data[$i]->country_code }}">

                                                </div>
                                            </div>
                                            <a href="#"
                                                onclick="singledelete('{{ route('remove_vendors_att', ['pid' => $attribute_data[$i]->pid, 'id' => $attribute_data[$i]->id]) }}')"
                                                class="btn btn-danger pull-right remove_field1"
                                                style="margin-right: 0;margin-top: 22px;width: 9%;float: right;height: 40px;margin-left: 85px;">Remove</a>

                                        </div>
                                    @endfor
                                @endif

                                @php

                                    $test = count($attribute_data);
                                    if ($test > 0) {
                                        $style = 'display:none';
                                    } else {
                                        $style = 'display:block';
                                    }
                                @endphp
                                <span style="@php echo $style; @endphp">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group"> <label for="poc">POC Full</label>
                                                <input type="text" id="poc" name="poc1[]" class="form-control"
                                                    placeholder="Enter POC">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group"> <label for="poctitle">POC Title</label>
                                                <input type="text" id="poctitle" name="poctitle1[]"
                                                    class="form-control" placeholder="Enter  POC Title">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group"> <label for="email">Company Email</label>
                                                <input type="text" id="c_email" name="c_email1[]"
                                                    class="form-control" placeholder="Enter Email">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mobile_div"> <label for="telephone">Phone</label>
                                                <input type="text" id="telephone" name="telephone1[]"
                                                    onkeypress="return validateNumber(event)"
                                                    class="form-control company-phone" placeholder="Enter Telephone">
                                                <input type="hidden" name="country_code1[]" class="country_code_vendor">
                                            </div>
                                        </div>
                                    </div>
                                </span>

                                <div class="input_fields_wrap12"> </div>
                                <div class="form-group">

                                    <div class="col-sm-12">
                                        <button
                                            style="border: medium none;margin-right: 50px;line-height: 26px;margin-top: -62px;"
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button12">Add</button>
                                    </div>
                                </div>

                                {{-- add more End --}}
                                @php
                                    $serviceListArray = explode(',', $vendors->serviceList);
                                @endphp

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="category">What services do you
                                            offer?
                                            (Click all that apply)</label>

                                        <select class="form-control multiple" id="serviceList" name="serviceList[]"
                                            multiple="multiple">
                                            <option value="">Select Service</option>
                                            @foreach ($service_data as $service)
                                                <option value="{{ $service->id }}"
                                                    @if (in_array($service->id, $serviceListArray)) {{ 'selected' }} @endif>
                                                    {{ $service->servicename }}</option>
                                            @endforeach
                                        </select>

                                        <p class="form-error-text" id="serviceList_error"
                                            style="color: red; margin-top: 10px;">

                                    </div>
                                </div>

                                @php
                                    $subserviceListArray = explode(',', $vendors->subserviceList);
                                @endphp

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label class="form-label" for="category">What Sub Services do you
                                            offer?
                                            (Click all that apply)</label>

                                        <select class="form-control multiple" id="subserviceList" name="subserviceList[]"
                                            multiple="multiple">
                                            <option value="">Select Sub Service</option>
                                            @foreach ($subservice_data as $subservice)
                                                <option value="{{ $subservice->id }}"
                                                    @if (in_array($subservice->id, $subserviceListArray)) {{ 'selected' }} @endif>
                                                    {{ $subservice->subservicename }}</option>
                                            @endforeach

                                        </select>
                                        <p class="form-error-text" id="subserviceList_error"
                                            style="color: red; margin-top: 10px;">

                                    </div>
                                </div>



                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Company Website</label>
                                        <input id="companywebsite" name="companywebsite" type="text"
                                            class="form-control" placeholder="Enter Company Website"
                                            value="{{ $vendors->companywebsite }}" />
                                    </div>
                                </div>

                                @php
                                    $city_selected = explode(',', $vendors->city);
                                @endphp
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="vendors">Company City</label>
                                        <select class="form-control multiple" id="city" name="city[]"
                                            multiple="multiple">
                                            <option value="">Select Company City</option>
                                            @foreach ($city_data as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ in_array($city->id, $city_selected) ? 'selected' : '' }}>
                                                    {{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Company Role</label>
                                        <input id="crole" name="crole" type="text" class="form-control"
                                            placeholder="Enter Company Role" value="{{ $vendors->crole }}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Parent Company Name</label>
                                        <input id="parentcname" name="parentcname" type="text" class="form-control"
                                            placeholder="Enter Parent Company Name"
                                            value="{{ $vendors->parentcname }}" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">Establishment Date</label>
                                        <input id="establishment_date" name="establishment_date" type="date"
                                            class="form-control" placeholder="Select Establishment Date"
                                            value="{{ $vendors->establishment_date }}" />
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4 mb-3">
                                    <h4>Document Section</h4>
                                    <hr>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">Company Logo (90px * 90px)</label>
                                        <input id="company_logo" name="company_logo" type="file" class="form-control"
                                            placeholder="Select Company Logo" />
                                        @if ($vendors->company_logo != '')
                                            <a href="{{ asset('public/upload/vendors/' . $vendors->company_logo) }}"
                                                class="btn btn-primary" target="_blank">View</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">VAT Certificate<span class="text-danger">*</span></label>
                                        <input id="vatcertificate" name="vatcertificate" type="file"
                                            class="form-control" placeholder="Select VAT Certificate" />
                                        @if ($vendors->vatcertificate != '')
                                            <a href="{{ asset('public/upload/vendors/' . $vendors->vatcertificate) }}"
                                                class="btn btn-primary mt-2" target="_blank">View</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">TRN Certificate Number<span
                                                class="text-danger">*</span></label>
                                        <input id="trn_certificate_number" name="trn_certificate_number" type="text"
                                            class="form-control" placeholder="Enter TRN Certificate Number"
                                            value="{{ $vendors->trn_certificate_number ?? '' }}" />
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Trade License<span class="text-danger">*</span></label>
                                        <input id="tradelicense" name="tradelicense" type="file" class="form-control"
                                            placeholder="Select Trade License" />
                                        @if ($vendors->tradelicense != '')
                                            <a href="{{ asset('public/upload/vendors/' . $vendors->tradelicense) }}"
                                                class="btn btn-primary mt-2" target="_blank">View</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Trade License Number<span
                                                class="text-danger">*</span></label>
                                        <input id="trade_license_number" name="trade_license_number" type="text"
                                            class="form-control" placeholder="Enter Trade License Number"
                                            value="{{ $vendors->trade_license_number ?? '' }}" />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Trade License Expiry Date<span
                                                class="text-danger">*</span></label>
                                        <input id="tlexpiry" name="tlexpiry" type="date" class="form-control"
                                            placeholder="Select Trade License Expiry Date"
                                            value="{{ $vendors->tlexpiry }}" />
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Passport (authorized person)<span
                                                class="text-danger">*</span></label>
                                        <input id="passport" name="passport" type="file" class="form-control"
                                            placeholder="Select Passport" />
                                        @if ($vendors->passport != '')
                                            <a href="{{ asset('public/upload/vendors/' . $vendors->passport) }}"
                                                class="btn btn-primary mt-2" target="_blank">View</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Passport Number (authorized person)<span
                                                class="text-danger">*</span></label>
                                        <input id="passport_number" name="passport_number" type="text"
                                            class="form-control" placeholder="Enter Passport Number"
                                            value="{{ $vendors->passport_number ?? '' }}" />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Passport Expiry Date (authorized person)<span
                                                class="text-danger">*</span></label>
                                        <input id="passport_expiry" name="passport_expiry" type="date"
                                            class="form-control" placeholder="Select Passport Expiry Date"
                                            value="{{ $vendors->passport_expiry }}" />
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Emirates ID (authorized person)<span
                                                class="text-danger">*</span></label>
                                        <input id="emirates_id" name="emirates_id" type="file" class="form-control"
                                            placeholder="Select emirates_id" />
                                        @if ($vendors->emirates_id != '')
                                            <a href="{{ asset('public/upload/vendors/' . $vendors->emirates_id) }}"
                                                class="btn btn-primary mt-2" target="_blank">View</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Emirates ID Number (authorized person)<span
                                                class="text-danger">*</span></label>
                                        <input id="emirates_id_number" name="emirates_id_number" type="text"
                                            class="form-control" placeholder="Enter Emirates ID Number"
                                            value="{{ $vendors->emirates_id_number ?? '' }}" />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Emirates ID Expiry Date (authorized person)<span
                                                class="text-danger">*</span></label>
                                        <input id="emirates_id_expiry" name="emirates_id_expiry" type="date"
                                            class="form-control" placeholder="Select Emirates ID Expiry Date"
                                            value="{{ $vendors->emirates_id_expiry }}" />
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4 mb-3">
                                    <h4>Additional Information</h4>
                                    <hr>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        @php $maxStaff = 20; @endphp
                                        <label for="">No Of Staff</label>
                                        <select class="form-control" id="staff" name="staff">
                                            <option value="">Select No Of Staff</option>
                                            @for ($i = 1; $i <= $maxStaff; $i++)
                                                <option value="{{ $i }}"
                                                    @if ($i == $vendors->staff) selected @endif>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Remarks</label>
                                        <input id="remarks" name="remarks" type="text" class="form-control"
                                            placeholder="Enter Remarks" value="{{ $vendors->remarks }}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Social Media</label>
                                        <input id="socialmedai" name="socialmedai" type="text" class="form-control"
                                            placeholder="Enter Social Media" value="{{ $vendors->socialmedai }}" />
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                    <label for="name">Password</label>
                                    <input id="password" name="password" type="password" class="form-control"
                                        placeholder="Enter Password" value="{{ $vendors->password }}" />
                                </div> --}}

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Email for Login</label>

                                        <input id="email" name="email" type="text" class="form-control"
                                            placeholder="Enter Email" value="{{ $vendors->email }}" />

                                        <p class="form-error-text" id="email_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>
                                <div class="col-lg-6">

                                    <div class="form-group mobile_div">

                                        <label for="name">Mobile No.</label>

                                        <input id="mobile" name="mobile" type="text"
                                            class="form-control company-phone" placeholder="Enter Mobile No."
                                            onkeypress="return validateNumber(event)" value="{{ $vendors->mobile }}" />
                                        <input type="hidden" name="country_code_vendor" id="country_code_vendor"
                                            class="country_code_vendor" value="{{ $vendors->country_code }}">
                                        <p class="form-error-text" id="mobile_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Rating</label>
                                        <input id="rating" name="rating" type="number" class="form-control"
                                            placeholder="Enter Rating" value="{{ $vendors->rating }}" />
                                        <p class="form-error-text" id="rating_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Numbers Of Review</label>
                                        <input id="number_of_review" name="number_of_review" type="number"
                                            class="form-control" placeholder="Enter Numbers Of Review"
                                            value="{{ $vendors->number_of_review }}" />
                                        <p class="form-error-text" id="number_of_review_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Review Link</label>
                                        <input id="review_link" name="review_link" type="text" class="form-control"
                                            placeholder="Enter Review Link" value="{{ $vendors->review_link }}" />
                                        <p class="form-error-text" id="review_link_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name"> Tell us a bit about your company</label>
                                        <textarea class="form-control" name="short_description" id="short_description">{{ $vendors->short_description }}</textarea>
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

        $(document).ready(function() {
            var role_id = jQuery("#role_id").val();

            $("#hidden_role_id").val(role_id);
        });



        $(function() {

            $("#name").keyup(function() {

                var Text = $(this).val();

                Text = Text.toLowerCase();

                Text = Text.replace(/[^a-zA-Z0-9]+/g, ' ');

                $("#user_name").val(Text);

            });

        });



        function category_validation() {

            $(document).ready(function() {
                var role_id = jQuery("#role_id").val();

                $("#hidden_role_id").val(role_id);
            });

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

                jQuery('#email_error').html("Enter Valid Email Address.");

                jQuery('#email_error').show().delay(0).fadeIn('show');

                jQuery('#email_error').show().delay(2000).fadeOut('show');

                $('html, body').animate({

                    scrollTop: $('#email').offset().top - 150

                }, 1000);

                return false;

            }

            var url = '{{ url('vendor_edit_check_mail') }}';
            var vendor_id = '{{ $vendors->id }}';

            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "email": email,
                    "vendor_id": vendor_id
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
    <script>
        function singledelete(url) {

            var t = confirm('Are You Sure To Delete The Attribute ?');

            if (t) {

                window.location.href = url;

            } else {

                return false;

            }

        }
    </script>

    <script>
        $(document).ready(function() {
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap12");
            var add_button = $("#add_field_button12");
            var b = $(".company-phone").length; // count existing rows

            // ✅ Initialize intlTelInput for all existing telephone fields
            initializeIntlTelInputs();

            // ✅ Add new field
            $(document).on('click', '#add_field_button12', function(e) {
                e.preventDefault();
                if (b < max_fields) {
                    b++;

                    var newField = `
                <div class="row poc-row mt-2">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>POC Full</label>
                            <input type="text" name="poc1[]" class="form-control" placeholder="Enter POC">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>POC Title</label>
                            <input type="text" name="poctitle1[]" class="form-control" placeholder="Enter POC Title">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Company Email</label>
                            <input type="text" name="c_email1[]" class="form-control" placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mobile_div">
                            <label>Phone</label>
                            <input type="tel" name="telephone1[]" class="form-control company-phone" placeholder="Enter Telephone">
                            <input type="hidden" name="country_code1[]" class="country_code_vendor">
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <a href="#" class="btn btn-danger remove_field1 w-100">Remove</a>
                    </div>
                </div>`;

                    $(wrapper).append(newField);

                    // ✅ Apply intl-tel-input to the newly added phone field
                    var lastPhone = $(wrapper).find(".company-phone").last()[0];
                    initializeIntlTelInput(lastPhone);
                }
            });

            // ✅ Remove POC row
            $(wrapper).on("click", ".remove_field1", function(e) {
                e.preventDefault();
                $(this).closest(".poc-row").remove();
                b--;
            });

            // ========================
            // Helper Functions
            // ========================

            function initializeIntlTelInputs() {
                $(".company-phone").each(function() {
                    initializeIntlTelInput(this);
                });
            }

            function initializeIntlTelInput(input) {
                if (!input || input.classList.contains('iti-initialized')) return;

                const hiddenInput = input.closest(".mobile_div").querySelector(".country_code_vendor");
                const savedDialCode = hiddenInput ? hiddenInput.value : null;

                const iti = window.intlTelInput(input, {
                    initialCountry: savedDialCode ? getCountryCodeFromDialCode(savedDialCode) : "ae",
                    separateDialCode: true,
                    nationalMode: false,
                    preferredCountries: ["in", "ae", "us", "gb"],
                    autoPlaceholder: "off",
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
                });

                input.classList.add("iti-initialized");

                // Update hidden input when country changes
                function updateDialCode() {
                    if (hiddenInput) hiddenInput.value = iti.getSelectedCountryData().dialCode;
                }

                updateDialCode(); // set initial value
                input.addEventListener("countrychange", updateDialCode);
            }

            // Helper: convert dial code to ISO code
            function getCountryCodeFromDialCode(dialCode) {
                const countryData = window.intlTelInputGlobals.getCountryData();
                for (let i = 0; i < countryData.length; i++) {
                    if (countryData[i].dialCode == dialCode) return countryData[i].iso2;
                }
                return "ae"; // fallback
            }

            // Initialize all phone inputs on page load
            $(document).ready(function() {
                $(".company-phone").each(function() {
                    initializeIntlTelInput(this);
                });
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

        // ✅ Company Mobile (Main vendor mobile)
        /* document.addEventListener("DOMContentLoaded", function () {
            const mobileInput = document.querySelector("#mobile");
            if (!mobileInput) return;

            const iti = window.intlTelInput(mobileInput, {
                initialCountry: "ae",
                separateDialCode: true,
                nationalMode: false,
                preferredCountries: ["in", "ae", "us", "gb"],
                autoPlaceholder: "off",
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
            });

            const codeInput = document.querySelector("#country_code_vendor");

            function updateVendorCode() {
                const data = iti.getSelectedCountryData();
                if (codeInput) codeInput.value = data.dialCode;
            }

            updateVendorCode();
            mobileInput.addEventListener("countrychange", updateVendorCode);
        }); */
    </script>

@stop
