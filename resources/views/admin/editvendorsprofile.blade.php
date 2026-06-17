   @extends('admin.includes.Template')
<link rel="stylesheet" href="{{ asset('public/site/css/intlTelInput.css') }}">

   <script src="{{ asset('public/site/js/intlTelInput.min.js') }}"></script>
   @section('content')

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
</style>

       <!-- Main Wrapper -->
       <!-- <div class="main-wrapper"> -->


       <!-- Page Wrapper -->
       {{-- <div class="page-wrapper"> --}}
       <div class="content container-fluid">
           <div class="page-header">
               <div class="row">
                   <div class="col-sm-6">
                       <h3 class="page-title">Edit Profile</h3>
                       <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{ url('/vendors') }}">Dashboard</a>
                           </li>
                           <li class="breadcrumb-item active">Edit Profile</li>
                       </ul>
                   </div>
               </div>
           </div>

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


               <div class="col-xl-12 col-md-12">

                   <div class="card">
                       <div class="card-header">
                           <h5 class="card-title">Basic information</h5>
                       </div>
                       <div class="card-body">

                           <!-- Form -->
                           <form id="category_form" action="{{ route('vendorsprofile.update', $vendorsprofile->id) }}"
                               method="POST" enctype="multipart/form-data">
                               @csrf

                               @method('PUT')
                               <div class="row form-group">
                                   <label for="name" class="col-sm-3 col-form-label input-label">Image (300px x
                                       300px)</label>
                                   <div class="col-sm-9">
                                       <div class="d-flex align-items-center">
                                           <label class="avatar avatar-xxl profile-cover-avatar m-0" for="edit_img">
                                               @if ($vendorsprofile->image != '')
                                                   <img id="avatarImg" class="avatar-img"
                                                       src="{{ asset('public/upload/vendors/small/' . $vendorsprofile->image) }}"
                                                       alt="Profile Image">
                                               @else
                                                   <img class="avatar-img" src="{{ asset('public/upload/avatar.jpg') }}"
                                                       alt="Profile Image">
                                               @endif

                                               <input type="file" name="image" id="edit_img">
                                               <span class="avatar-edit">
                                                   <i data-feather="edit-2" class="avatar-uploader-icon shadow-soft"></i>
                                               </span>
                                           </label>
                                       </div>
                                   </div>
                               </div>

                               <div class="form-group" style="display: none;">
                                   <label for="vendors">User Category</label>
                                   <select class="form-control" id="role_id" name="role_id">
                                       @foreach ($permission_data as $permission)
                                           <option value="{{ $permission->id }}" <?php if ($permission->id == $vendorsprofile->name) {
                                               echo 'selected';
                                           } ?>>
                                               {{ $permission->cname }}</option>
                                       @endforeach
                                   </select>
                                   <input type="hidden" name="hidden_role_id" id="hidden_role_id" value="">

                               </div>

                               <div class="row form-group">
                                   <label for="name" class="col-sm-3 col-form-label input-label">Company
                                       Name</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" id="name" name="name"
                                           placeholder="Company Name" value="{{ $vendorsprofile->name }}">
                                       <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>
                                   </div>

                               </div>
                               <div class="form-group">
                                   <input id="user_name" name="user_name" type="hidden" class="form-control"
                                       placeholder="Enter  Name" value="{{ $vendorsprofile->user_name }}" />
                               </div>


                               {{-- add more start --}}
                               @if ($attribute_data != '')
                                   <input type="hidden" name="poc1[]" value="">
                                   <input type="hidden" name="poctitle1[]" value="">
                                   <input type="hidden" name="c_email1[]" value="">
                                   <input type="hidden" name="telephone1[]" value="">
                                   <input type="hidden" name="country_code1[]" value="">


                                   @for ($i = 0; $i < count($attribute_data); $i++)
                                       <div class="row">

                                           <input type="hidden" name="updateid1xxx[]" id="updateid1xxx{{ $i + 1 }}"
                                               value="{{ $attribute_data[$i]->id }}">

                                           <div class="col-md-2">
                                               <div class="form-group"> <label for="poc">POC Full</label>
                                                   <input type="text" id="pocu" name="pocu[]"
                                                       class="form-control" placeholder="Enter POC"
                                                       value="{{ $attribute_data[$i]->poc }}">
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
                                           <div class="col-md-2 mobile_div">
                                               <div class="form-group"> <label for="telephone">Phone</label>
                                                   <input type="text" id="telephoneu" name="telephoneu[]"
                                                       onkeypress="return validateNumber(event)" class="form-control company-phone"
                                                       placeholder="Enter Telephone"
                                                       value="{{ $attribute_data[$i]->telephone }}">

                                                       <input type="hidden" name="country_codeu[]" class="country_code_vendor" value="{{ $attribute_data[$i]->country_code }}">
                                               </div>
                                           </div>
                                           <a href="#"
                                               onclick="singledelete('{{ route('remove_vendorsprofile_att', ['pid' => $attribute_data[$i]->pid, 'id' => $attribute_data[$i]->id]) }}')"
                                               class="btn btn-danger pull-right remove_field1"
                                               style="margin-right: 0;margin-top: 22px;width: 9%;float: right;height: 40px;margin-left: 150px;">Remove</a>

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
                                       <div class="col-md-2">
                                           <div class="form-group"> <label for="telephone">Phone</label>
                                               <input type="text" id="telephone" name="telephone1[]"
                                                   onkeypress="return validateNumber(event)" class="form-control"
                                                   placeholder="Enter Telephone">
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

                               @php
                                    $serviceListArray = explode(',', $vendorsprofile->serviceList);
                                @endphp

                               <div class="row form-group">
                                <label for="name" class="col-sm-3 col-form-label input-label">What services do you offer?</label>
                                <div class="col-sm-9">
                                    
                                    <select class="form-control multiple" id="serviceList" name="serviceList[]" multiple="multiple">
                                            <option value="">Select Service</option>
                                            @foreach ($service_data as $service)
                                            <option value="{{ $service->id }}" @if (in_array($service->id, $serviceListArray)) {{ 'selected' }} @endif>{{ $service->servicename }}</option>
                                        @endforeach
                                        </select>
                                    
                                
                                </div>
                            </div>

                             @php
                                    $subserviceListArray = explode(',', $vendorsprofile->subserviceList);
                                @endphp

                               <div class="row form-group">
                                <label for="name" class="col-sm-3 col-form-label input-label">What Sub services do you offer?</label>
                                <div class="col-sm-9">
                                    
                                    <select class="form-control multiple" id="subserviceList" name="subserviceList[]" multiple="multiple">
                                            <option value="">Select Sub Service</option>
											@foreach ($subservice_data as $subservice)
                                            <option value="{{ $subservice->id }}" @if (in_array($subservice->id, $subserviceListArray)) {{ 'selected' }} @endif>{{ $subservice->subservicename }}</option>
                                        @endforeach
                                            
                                        </select>
                                
                                </div>
                            </div>

                               <div class="row form-group">
                                   <label for="name" class="col-sm-3 col-form-label input-label">Company
                                       Website</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" id="companywebsite"
                                           name="companywebsite" placeholder="Company Website"
                                           value="{{ $vendorsprofile->companywebsite }}">
                                   </div>
                               </div>

                               @php
                                $city_selected = explode(',',$vendorsprofile->city);
                                @endphp

                               <div class="row form-group">
                                   <label for="name" class="col-sm-3 col-form-label input-label">Company City</label>
                                   <div class="col-sm-9">
                                       <select class="form-control multiple" id="city" name="city[]" multiple="multiple">
                                           <option value="">Select Company City</option>
                                           @foreach ($city_data as $city)
                                           <option value="{{ $city->id }}"
                                            {{ in_array($city->id, $city_selected) ? 'selected' : '' }}>
                                               {{ $city->name }}</option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>
                               <div class="row form-group">
                                   <label for="name" class="col-sm-3 col-form-label input-label">Company Role</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" id="crole" name="crole"
                                           placeholder="Company Role" value="{{ $vendorsprofile->crole }}">
                                   </div>
                               </div>
                               <div class="row form-group">
                                   <label for="name" class="col-sm-3 col-form-label input-label">Parent Company
                                       Name</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" id="parentcname" name="parentcname"
                                           placeholder="Parent Company Name" value="{{ $vendorsprofile->parentcname }}">
                                   </div>
                               </div>
                               <div class="row form-group">
                                   <label for="name" class="col-sm-3 col-form-label input-label">Establishment
                                       Date</label>
                                   <div class="col-sm-9">
                                       <input type="date" class="form-control" id="establishment_date"
                                           name="establishment_date" placeholder="Select Establishment Date"
                                           value="{{ $vendorsprofile->establishment_date }}">
                                   </div>
                               </div>

                               <div class="row form-group">
                                <label for="name" class="col-sm-3 col-form-label input-label">Company Logo (90px * 90px)</label>
                                <div class="col-sm-9">
                                    <input id="company_logo" name="company_logo" type="file"
                                        class="form-control" placeholder="Select Company Logo" />
                                    

                                        @if ($vendorsprofile->company_logo != '')

                                        <a href="{{ asset('public/upload/vendors/' . $vendorsprofile->company_logo) }}" class="btn btn-primary" target="_blank">View</a>
                                           
                                        @endif
                                </div>
                            </div>

                               <div class="row form-group">
                                   <label for="name" class="col-sm-3 col-form-label input-label">VAT
                                       Certificate</label>
                                   <div class="col-sm-9">
                                       <input id="vatcertificate" name="vatcertificate" type="file"
                                           class="form-control" placeholder="Select VAT Certificate" />

                                           @if ($vendorsprofile->vatcertificate != '')

                                        <a href="{{ asset('public/upload/vendors/' . $vendorsprofile->vatcertificate) }}" class="btn btn-primary" target="_blank">View</a>
                                           
                                        @endif
                                       
                                   </div>
                               </div>

                               <div class="row form-group">
                                   <label for="name" class="col-sm-3 col-form-label input-label">TRN
                                       Certificate</label>
                                   <div class="col-sm-9">
                                       <input id="trncertificate" name="trncertificate" type="file"
                                           class="form-control" placeholder="Select TRN Certificate" />

                                           @if ($vendorsprofile->trncertificate != '')

                                           <a href="{{ asset('public/upload/vendors/' . $vendorsprofile->trncertificate) }}" class="btn btn-primary" target="_blank">View</a>
                                              
                                           @endif

                                       
                                   </div>
                               </div>

                               <div class="row form-group">
                                   <label for="name" class="col-sm-3 col-form-label input-label">Trade License</label>
                                   <div class="col-sm-9">
                                       <input id="tradelicense" name="tradelicense" type="file" class="form-control"
                                           placeholder="Select Trade License" />

                                           @if ($vendorsprofile->tradelicense != '')

                                           <a href="{{ asset('public/upload/vendors/' . $vendorsprofile->tradelicense) }}" class="btn btn-primary" target="_blank">View</a>
                                              
                                           @endif

                                       
                                   </div>
                               </div>

                               <div class="row form-group">
                                   <label for="name" class="col-sm-3 col-form-label input-label">TL expiry
                                       date</label>
                                   <div class="col-sm-9">
                                       <input type="date" class="form-control" id="tlexpiry" name="tlexpiry"
                                           placeholder="Select TL expiry date" value="{{ $vendorsprofile->tlexpiry }}">
                                   </div>
                               </div>
                               <div class="row form-group">
                                   @php $maxStaff = 20; @endphp
                                   <label for="name" class="col-sm-3 col-form-label input-label">No Of Staff</label>
                                   <div class="col-sm-9">
                                       <select class="form-control" id="staff" name="staff">
                                           <option value="">Select No Of Staff</option>
                                           @for ($i = 1; $i <= $maxStaff; $i++)
                                               <option value="{{ $i }}"
                                                   @if ($i == $vendorsprofile->staff) selected @endif>
                                                   {{ $i }}
                                               </option>
                                           @endfor
                                       </select>
                                   </div>
                               </div>

                               <div class="row form-group">
                                   <label for="name" class="col-sm-3 col-form-label input-label">Remarks</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" id="remarks" name="remarks"
                                           placeholder="Enter Remarks" value="{{ $vendorsprofile->remarks }}">
                                   </div>
                               </div>
                               <div class="row form-group">
                                   <label for="name" class="col-sm-3 col-form-label input-label">Social Media</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" id="socialmedai" name="socialmedai"
                                           placeholder="Enter Social Media" value="{{ $vendorsprofile->socialmedai }}">
                                   </div>
                               </div>

                               <div class="row form-group">
                                   <label for="name" class="col-sm-3 col-form-label input-label">Email for
                                       Login</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" id="email" name="email"
                                           placeholder="Enter Email for Login" value="{{ $vendorsprofile->email }}"
                                           readonly>
                                       <p class="form-error-text" id="email_error" style="color: red; margin-top: 10px;">
                                       </p>
                                   </div>

                               </div>

                               <div class="row form-group mobile_div">
                                   <label for="name" class="col-sm-3 col-form-label input-label">Mobile No.</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control company-phone" id="mobile" name="mobile"
                                           onkeypress="return validateNumber(event)" placeholder="Enter Enter Mobile No."
                                           value="{{ $vendorsprofile->mobile }}">
                                           <input type="hidden" name="country_code_vendor" id="country_code_vendor" class="country_code_vendor" value="{{ $vendorsprofile->country_code }}">

                                       <p class="form-error-text" id="mobile_error"
                                           style="color: red; margin-top: 10px;"></p>
                                   </div>
                               </div>

                               <div class="text-end">


                                   <a class="btn btn-primary" href="{{ route('vendorsprofile.index') }}">Cancel</a>
                                   <button type="button" class="btn btn-primary"
                                       onclick="javascript:category_validation()" id="submit_button">Submit</button>
                                   {{-- <button type="submit" class="btn btn-primary">Update</button> --}}
                                   <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                       style="display: none;">

                                       <span class="spinner-border spinner-border-sm" role="status"
                                           aria-hidden="true"></span>

                                       Loading...

                                   </button>

                               </div>
                           </form>
                           <!-- /Form -->

                       </div>
                   </div>
               </div>
           </div>
       </div>
       <!-- </div> -->
       <!-- /Page Wrapper -->
       {{-- </div> --}}
       <!-- /Main Wrapper -->

       <!-- Delete  Modal -->

       <div class="modal custom-modal fade" id="delete_model" role="dialog">

           <div class="modal-dialog modal-dialog-centered">

               <div class="modal-content">

                   <div class="modal-body">
                       <input type="hidden" name="hidden_url" id="hidden_url">

                       <div class="modal-icon text-center mb-3">

                           <i class="fas fa-trash-alt text-danger"></i>

                       </div>

                       <div class="modal-text text-center">

                           <!-- <h3>Delete Expense Category</h3> -->

                           <p>Are you sure want to delete?</p>

                       </div>

                   </div>

                   <div class="modal-footer text-center">

                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                       <button type="button" class="btn btn-primary" onclick="form_sub();">Delete</button>

                   </div>

               </div>

           </div>

       </div>

       <!-- /Delete Modal -->

       <!-- Select one record Category Modal -->

       <div class="modal custom-modal fade" id="select_one_record" role="dialog">

           <div class="modal-dialog modal-dialog-centered">

               <div class="modal-content">

                   <div class="modal-body">

                       <div class="modal-text text-center">

                           <h3>Please select at least one record to delete</h3>

                           <!-- <p>Are you sure want to delete?</p> -->

                       </div>

                   </div>

               </div>

           </div>

       </div>

       <!-- /Select one record Category Modal -->


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
    </script>

       <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
       <script>
        
           function singledelete(url) {


               var checked = url.length > 0;

               $('#hidden_url').val(url);


               if (!checked) {

                   $('#select_one_record').modal('show');

               } else {

                   $('#delete_model').modal('show');

               }



           }

           function form_sub() {
               var url = $('#hidden_url').val();

               window.location.href = url;

           }





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
                            <input type="tel" name="telephone1[]" class="form-control company-phone" placeholder="Enter Phone">
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

        // ✅ Update hidden input and remove spaces on country change
        function updateDialCodeAndClean() {
            if (hiddenInput) hiddenInput.value = iti.getSelectedCountryData().dialCode;
            input.value = input.value.replace(/\s+/g, ''); // remove spaces
        }

        // On country change
        input.addEventListener("countrychange", updateDialCodeAndClean);

        // Also remove spaces while typing
        input.addEventListener("input", function() {
            this.value = this.value.replace(/\s+/g, '');
        });

        // Set initial dial code
        updateDialCodeAndClean();
    }

    // Helper: convert dial code to ISO code
    function getCountryCodeFromDialCode(dialCode) {
        const countryData = window.intlTelInputGlobals.getCountryData();
        for (let i = 0; i < countryData.length; i++) {
            if (countryData[i].dialCode == dialCode) return countryData[i].iso2;
        }
        return "ae"; // fallback
    }

    // ✅ Initialize all phone inputs on page load
    $(".company-phone").each(function() {
        initializeIntlTelInput(this);
    });
});

       </script>
       <script>
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

               var email = jQuery("#email").val();

               if (email == '') {

                   jQuery('#email_error').html("Please Enter Email for Login");
                   jQuery('#email_error').show().delay(0).fadeIn('show');
                   jQuery('#email_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#email').offset().top - 150
                   }, 1000);
                   return false;

               }



               var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

               if (!filter.test(email)) {

                   jQuery('#email_error').html("Please Enter Valid Email for Login");
                   jQuery('#email_error').show().delay(0).fadeIn('show');
                   jQuery('#email_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#email').offset().top - 150
                   }, 1000);
                   return false;

               }

               var mobile = jQuery("#mobile").val();
            //    var filter = /^\d{10}$/;

            //    if (mobile != '' && !filter.test(mobile)) {

            //        jQuery('#mobile_error').html("Please Enter Valid Mobile");
            //        jQuery('#mobile_error').show().delay(0).fadeIn('show');
            //        jQuery('#mobile_error').show().delay(2000).fadeOut('show');
            //        $('html, body').animate({
            //            scrollTop: $('#mobile').offset().top - 150
            //        }, 1000);
            //        return false;

            //    }

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

       <script>
        
           $(document).ready(function() {
               // Listen for changes in the file input
               $("#edit_img").change(function() {
                   readURL(this);
               });

               // Function to read and display the selected image
               function readURL(input) {
                   if (input.files && input.files[0]) {
                       var reader = new FileReader();

                       reader.onload = function(e) {
                           // Set the 'src' attribute of the image tag to the selected image
                           $("#avatarImg").attr("src", e.target.result);

                       };

                       reader.readAsDataURL(input.files[0]);
                   }
               }
           });
       </script>
@stop