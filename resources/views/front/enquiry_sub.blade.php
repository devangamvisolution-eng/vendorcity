@include('front.includes.header')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    /* Premium Modern UI Styles - Inspired by ServiceMarket */
    body {
        background-color: #F8FAFC !important;
        color: #0F172A;
        font-family: 'Inter', sans-serif;
    }

    .our-register {
        padding: 50px 0 80px 0;
        background-color: #F8FAFC;
    }

    .main-title .title {
        font-weight: 800;
        font-size: 28px;
        color: #0F172A;
        letter-spacing: -0.75px;
        margin-bottom: 25px;
    }

    /* Stepper Progress Bar */
    .stepper-progress-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 600px;
        margin: 0 auto 40px auto;
        padding: 0 10px;
    }

    .step-item-new {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
        flex: 1;
    }

    .step-circle-new {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background-color: #E2E8F0;
        color: #64748B;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 700;
        font-size: 16px;
        border: 4px solid #F8FAFC;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
    }

    .step-label-new {
        font-size: 13px;
        font-weight: 600;
        color: #64748B;
        margin-top: 8px;
        transition: all 0.3s ease;
    }

    .step-line-new {
        height: 4px;
        background-color: #E2E8F0;
        flex: 1;
        margin: -22px 0 0 0;
        position: relative;
        z-index: 1;
        border-radius: 2px;
    }

    .step-item-new.active .step-circle-new {
        background-color: #0040E6;
        color: #ffffff;
        box-shadow: 0 0 0 4px rgba(0, 64, 230, 0.15);
    }

    .step-item-new.active .step-label-new {
        color: #0040E6;
        font-weight: 700;
    }

    .step-item-new.completed .step-circle-new {
        background-color: #10B981;
        color: #ffffff;
    }

    .step-item-new.completed .step-label-new {
        color: #10B981;
    }

    .step-line-new.completed {
        background-color: #10B981;
    }

    /* Grid Layout */
    .enquiry-layout-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
        align-items: start;
        margin-top: 10px;
        max-width: 760px;
        margin-left: auto;
        margin-right: auto;
    }

    .enquiry-left-column {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .sticky-sidebar-new {
        position: sticky;
        top: 100px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        z-index: 10;
    }

    /* Card styling */
    .enquiry-card-ui {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
        padding: 35px;
        border: 1px solid rgba(0, 64, 230, 0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-title-new {
        font-size: 19px;
        font-weight: 700;
        color: #0F172A;
        margin-bottom: 25px;
        border-bottom: 1px solid #F1F5F9;
        padding-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Form Elements */
    .enquiry-card-ui .form-label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
        font-size: 14px;
        display: inline-block;
    }

    .enquiry-card-ui .form-control {
        height: 52px;
        border-radius: 10px;
        border: 1px solid #CBD5E1;
        padding: 12px 16px;
        font-size: 15px;
        color: #0F172A;
        transition: all 0.2s ease-in-out;
        background-color: #F8FAFC;
        box-shadow: none;
    }

    .enquiry-card-ui .form-control:focus {
        border-color: #0040E6;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(0, 64, 230, 0.12);
        outline: none;
    }

    .enquiry-card-ui select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748B'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1.2rem center;
        background-size: 1.1em;
        padding-right: 40px;
    }

    .enquiry-card-ui textarea.form-control {
        height: auto;
        min-height: 110px;
        background-color: #F8FAFC;
    }

    /* Segmented Control for Local/International */
    .segmented-control {
        display: inline-flex;
        flex-wrap: wrap;
        gap: 10px;
        background: transparent;
        padding: 0;
        border-radius: 0;
        margin-bottom: 30px;
        width: 100%;
        max-width: 100%;
        border: none;
    }

    .segmented-control .styledRadioLabel {
        flex: none;
        margin: 0;
        position: relative;
    }

    .segmented-control .checkmark {
        display: block;
        padding: 10px 24px;
        border-radius: 30px;
        font-weight: 500;
        font-size: 15px;
        color: #0040E6;
        background-color: #ffffff;
        border: 1.5px solid #0040E6;
        transition: all 0.25s ease;
        cursor: pointer;
        z-index: 2;
        position: relative;
    }

    .segmented-control .styledRadio:checked ~ .checkmark {
        background-color: #0040E6;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(0, 64, 230, 0.15);
    }

    .segmented-control .styledRadio {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* Buttons */
    .enquiry-card-ui .btn-thm, .btn-thm {
        background: #0040E6;
        color: #fff !important;
        border-radius: 10px;
        padding: 15px 30px;
        font-weight: 700;
        font-size: 16px;
        width: 100%;
        border: none;
        transition: all 0.25s ease;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 64, 230, 0.15);
        position: relative !important;
        overflow: hidden !important;
    }

    .enquiry-card-ui .btn-thm:hover, .btn-thm:hover {
        background: #0033B8;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0, 64, 230, 0.25);
    }

    /* Right Sidebar Summary Card */
    .sidebar-summary-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 28px;
        border: 1px solid rgba(0, 64, 230, 0.05);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    .sidebar-summary-card .summary-header {
        font-weight: 800;
        color: #0F172A;
        margin-bottom: 22px;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .sidebar-summary-card .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 14px 0;
        border-bottom: 1px solid #F1F5F9;
        font-size: 14px;
    }

    .sidebar-summary-card .summary-item:last-of-type {
        border-bottom: none;
    }

    .sidebar-summary-card .summary-label {
        color: #64748B;
        font-weight: 600;
        max-width: 50%;
    }

    .sidebar-summary-card .summary-value {
        font-weight: 700;
        color: #0F172A;
        text-align: right;
    }

    /* Price / Estimated Total Styles */
    .price-box-new {
        background: #ECFDF5;
        border-radius: 10px;
        padding: 18px;
        margin-top: 24px;
        border: 1px dashed #A7F3D0;
        text-align: center;
    }

    .price-box-new .price-label {
        font-size: 12px;
        color: #065F46;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .price-box-new .price-value {
        font-size: 22px;
        font-weight: 800;
        color: #059669;
    }

    /* Trust Badge Notice Card */
    .notice-card-new {
        background: #EFF6FF;
        border: 1px solid #DBEAFE;
        border-radius: 16px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .notice-item-new {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 13px;
        color: #1E3A8A;
        line-height: 1.5;
    }

    .notice-item-new i {
        color: #3B82F6;
        font-size: 16px;
        margin-top: 2px;
    }

    /* Custom Radio & Checkbox Styles (Cards) */
    .radio-card-group, .checkbox-card-group {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 12px;
        margin-bottom: 24px;
    }

    .radio-card-item, .checkbox-card-item {
        position: relative;
        background: #ffffff;
        border: 1.5px solid #0040E6;
        border-radius: 30px;
        padding: 10px 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .radio-card-item:hover, .checkbox-card-item:hover {
        background-color: rgba(0, 64, 230, 0.05);
    }

    .radio-card-item input[type="radio"], .checkbox-card-item input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .radio-card-label, .checkbox-card-label {
        font-size: 15px;
        font-weight: 500;
        color: #0040E6;
        margin: 0;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .radio-card-item.active, .checkbox-card-item.active,
    .radio-card-item:has(input:checked), .checkbox-card-item:has(input:checked) {
        background-color: #0040E6 !important;
        border-color: #0040E6 !important;
    }

    .radio-card-item.active .radio-card-label, .checkbox-card-item.active .checkbox-card-label,
    .radio-card-item:has(input:checked) .radio-card-label, .checkbox-card-item:has(input:checked) .checkbox-card-label {
        color: #ffffff !important;
    }

    .requiredStar::after {
        content: "*";
        color: #EF4444;
        margin-left: 4px;
    }

    /* Error Text badge */
    .form-error-text {
        font-size: 13px;
        font-weight: 500;
        color: #EF4444 !important;
        margin-top: 6px;
        display: none;
        align-items: center;
        gap: 6px;
        background: #FEF2F2;
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #FEE2E2;
    }

    /* Success Icon styling */
    .success-icon {
        width: 72px;
        height: 72px;
        background: #10B981;
        color: #fff;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto 24px auto;
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.2);
    }
    
    .success-icon i {
        font-size: 30px;
    }

    .textp {
        font-size: 15px;
        color: #475569;
        line-height: 1.6;
    }

    /* Custom file upload styling */
    .file-upload-wrapper {
        border: 2px dashed #CBD5E1;
        border-radius: 12px;
        padding: 30px 20px;
        text-align: center;
        background: #F8FAFC;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-bottom: 10px;
    }

    .file-upload-wrapper:hover {
        border-color: #0040E6;
        background: #FFF;
    }

    .file-upload-icon {
        font-size: 32px;
        color: #64748B;
        margin-bottom: 12px;
    }

    /* Select2 Overrides */
    .select2-container--default .select2-selection--single {
        height: 52px !important;
        border-radius: 10px !important;
        border: 1px solid #CBD5E1 !important;
        background-color: #F8FAFC !important;
        display: flex !important;
        align-items: center !important;
        padding-left: 8px !important;
        outline: none !important;
        transition: all 0.2s ease;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #0F172A !important;
        font-size: 15px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 50px !important;
        right: 12px !important;
    }
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #0040E6 !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 4px rgba(0, 64, 230, 0.12) !important;
    }
    select[style*="display: none"] + .select2-container,
    select[style*="display:none"] + .select2-container {
        display: none !important;
    }

    /* Responsive Spacing & Header Overlap Fixes */
    .our-register {
        padding: 140px 0 80px 0 !important; /* Extra padding to prevent sticky header overlap on desktop */
    }

    .main-title {
        margin-bottom: 15px !important;
    }

    .main-title .title {
        font-size: 32px;
        line-height: 1.2;
        margin-bottom: 10px !important;
    }

    .stepper-progress-container {
        max-width: 480px; /* More compact for 2 steps */
        margin: 0 auto 20px auto !important;
    }

    /* Media Queries for Tablet & Mobile Support */
    @media (max-width: 991px) {
        .our-register {
            padding: 110px 0 60px 0 !important; /* Padding for tablets/mobiles */
        }
        .main-title .title {
            font-size: 26px;
            margin-bottom: 20px;
        }
    }

    @media (max-width: 576px) {
        .our-register {
            padding: 100px 0 50px 0 !important;
        }
        .main-title .title {
            font-size: 22px;
            margin-bottom: 15px;
        }
        .enquiry-card-ui {
            padding: 20px 15px !important; /* Smaller padding inside cards on mobile */
            border-radius: 12px;
        }
        .stepper-progress-container {
            margin-bottom: 25px;
        }
        .step-circle-new {
            width: 36px;
            height: 36px;
            font-size: 14px;
            border-width: 3px;
        }
        .step-line-new {
            margin: -18px 0 0 0; /* Align with center of 36px circle */
        }
        .step-label-new {
            font-size: 11px;
            margin-top: 6px;
        }
        .radio-card-item, .checkbox-card-item {
            padding: 8px 16px !important;
            font-size: 13px !important;
        }
        .radio-card-label, .checkbox-card-label {
            font-size: 13px !important;
        }
        .segmented-control .checkmark {
            padding: 8px 16px !important;
            font-size: 13px !important;
        }
    }
</style>
<section class="our-register ">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto wow fadeInUp" data-wow-delay="300ms">
                <div class="main-title text-center">
                    <h2 class="title" id="head_hide" style="display: block">YOUR QUOTE REQUEST</h2>
                    {{-- <p class="paragraph">Give your visitor a smooth online experience with a solid UX design</p> --}}
                </div>
            </div>
        </div>
        @php
            // echo '<pre>';
            // print_r($formFields);
            // echo '</pre>';

            $packageEnquiryFormId = session('packages_enquiry_form_id');

            if (isset($packageEnquiryFormId) && $packageEnquiryFormId != '') {
                $display_oldform = 'none';

                $display_newform = 'block';
            } else {
                $display_oldform = 'block';
                $display_newform = 'none';
            }
        @endphp

        <!-- Progress Stepper -->
        <div class="row mb-4" id="enquiry_stepper_row">
            <div class="col-12">
                <div class="stepper-progress-container">
                    <div class="step-item-new @if($display_oldform == 'block') active @else completed @endif" id="step1_indicator">
                        <div class="step-circle-new">
                            @if($display_oldform == 'block')
                                1
                            @else
                                <i class="fa-solid fa-check"></i>
                            @endif
                        </div>
                        <div class="step-label-new">Job Details</div>
                    </div>
                    <div class="step-line-new @if($display_newform == 'block') completed @endif" id="step_line_1"></div>
                    <div class="step-item-new @if($display_newform == 'block') active @endif" id="step2_indicator">
                        <div class="step-circle-new">2</div>
                        <div class="step-label-new">Summary Details</div>
                    </div>
                </div>
            </div>
        </div>

        <form id="category_form" action="{{ route('package_inquiry') }}" method="POST"
            style="display: {{ $display_oldform }};" enctype="multipart/form-data">
            @csrf

           

            <div class="enquiry-layout-grid wow fadeInRight" data-wow-delay="300ms">
                <!-- Left Column -->
                <div class="enquiry-left-column">
                    <div class="enquiry-card-ui">
                        {{-- @if ($package_id != '')
                            <input name="pakage_id" type="hidden" class="form-control" value="{{ $package_id }}">
                        @endif --}}



                        <input name="service_id" type="hidden" class="form-control" value="{{ $service_id }}">
                        <input name="subservice_id" type="hidden" class="form-control" value="{{ $subservice_id }}">


                        <div <?php if(count($result2) == 0) { ?> style="display:none;" <?php } ?> style="text-align: center;">
                            <div class="segmented-control">
                                <label class="styledRadioLabel" for="localorintLocal">
                                    <input class="styledRadio" id="localorintLocal" name="localorint" type="radio" value="loc" checked='checked' onclick="hideshow('local');">
                                    <span class="checkmark">Local</span>
                                </label>
                                <label class="styledRadioLabel" for="localorintInt">
                                    <input class="styledRadio" id="localorintInt" name="localorint" value="int" type="radio" onclick="hideshow('int');">
                                    <span class="checkmark">International</span>
                                </label>
                            </div>
                        </div>
                        <script>
                            function hideshow(val) {
                                if (val == 'local') {

                                    $('#form_type').val('Local Move');
                                    $("#localform").show();
                                    $("#intform").hide();
                                } else {
                                    $('#form_type').val('International Move');
                                    $("#localform").hide();
                                    $("#intform").show();
                                }
                            }
                        </script>
                        @php
                            // echo '<pre>';
                            // print_r($result1);
                            // echo '</pre>';
                            // echo '<pre>';
                            // print_r($formFields);
                            // echo '</pre>';
                            // exit();
                        @endphp

                        <input type="hidden" name="form_type" id="form_type" value="Local Move">
                        @php
                            $userdata = Session::get('user');
                            // echo"<pre>";print_r($userdata);echo"</pre>";exit;
                        @endphp

                        {{-- @if($userdata == "")
                        
                        <div class="row">
                            <div class="mb25">
                                <label class="form-label fw500 dark-color">Full Name:</label>
                                <input id="name_new" name="name_new" type="text" class="form-control"
                                    placeholder="Enter Full Name:" value="">
                                <p class="form-error-text" id="name_new_error" style="color: red; margin-top: 10px;">
                                </p>
                            </div>
                            <div class="mb15">
                                <label class="form-label fw500 dark-color">Phone Number:</label>
                                <input id="mobile_new" name="mobile_new" type="text" class="form-control"
                                    placeholder="Enter Phone Number:" onkeypress="return validateNumber(event)"
                                    value="">
                                <p class="form-error-text" id="mobile_new_error" style="color: red; margin-top: 10px;">
                                </p>
                            </div>

                            <p class="form-error-text" id="mobile_new_error" style="color: red; margin-top: 10px;">
                
                            <div class="mb25">
                                <label class="form-label fw500 dark-color">Email ID:</label>
                                <input id="email_new" name="email_new" type="text" class="form-control"
                                    placeholder="Enter Email ID:" value="">
                                <p class="form-error-text" id="email_new_error" style="color: red; margin-top: 10px;">
                                </p>
                            </div>

                            <p class="form-error-text" id="email_new_error" style="color: red; margin-top: 10px;">
                        </div>
                        @endif --}}
                        <div class="row" id="localform">
                             @for ($i = 0; $i < count($result1); $i++)
                                 @for ($k = 0; $k < count($formFields); $k++)
 
                                     @php
 
                                         $form_additionalData = DB::table('form_attributes')
                                             ->select('*')
                                             ->where('form_id', '=', $result1[$i]->id)
                                             ->get()
                                             ->toArray();
                                         // echo '<pre>';
                                         // print_r($form_additionalData);
                                         // echo '</pre>';
                                         // exit();
 
                                         $required = $formFields[$k]->is_active;
                                     @endphp
                                     @if ($result1[$i]->lable_name == $formFields[$k]->lable_name)
                                         @php
                                             $fieldName = trim($formFields[$k]->lable_name);
                                             $colClass = 'col-12';
                                             if (
                                                 strcasecmp($fieldName, 'Moving From') === 0 || 
                                                 strcasecmp($fieldName, 'Moving From?') === 0 || 
                                                 strcasecmp($fieldName, 'Moving From Area') === 0 || 
                                                 strcasecmp($fieldName, 'Moving To') === 0 || 
                                                 strcasecmp($fieldName, 'Moving To Area') === 0 || 
                                                 strcasecmp($fieldName, 'Moving To Country') === 0 || 
                                                 strcasecmp($fieldName, 'Moving To City') === 0 || 
                                                 strcasecmp($fieldName, 'ZIP Code') === 0
                                             ) {
                                                 $colClass = 'col-md-6 col-12';
                                             }
                                         @endphp

                                         @if ($result1[$i]->type == '1')
                                             <div class="mb15 {{ $colClass }}" id="hide_div_{{ $formFields[$k]->id }}">
                                                 <label
                                                     class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}" id="formfield_label_{{ $formFields[$k]->id }}">{{ $formFields[$k]->lable_name }}</label>
                                                 <input name="form_field_id[]" type="hidden" class="m-0"
                                                     id="form_field_id[]" value=" {{ $result1[$i]->id }}">
                                                 <input name="formfield_value[]" type="text"
                                                     class="form-control {{ $formFields[$k]->id }}"
                                                     id="formfield_value_{{ $formFields[$k]->id }}"
                                                     placeholder="{{ $formFields[$k]->lable_name }}">
 
                                                     <p class="form-error-text" id="name_error_{{ $formFields[$k]->id }}"
                                                 style="color: red; margin-top: 10px;">
                                             </p>
                                             </div>
                                             
                                         @endif
 
                                         @if ($result1[$i]->type == '2' && $result1[$i]->lable_name != 'Do you require any additional service?')
                                             <div class="form-group mb-3 {{ $colClass }}">
                                                 <label class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}"
                                                     for="country">{{ $formFields[$k]->lable_name }}</label>
                                                 <input name="form_field_id[]" type="hidden" class="m-0"
                                                     id="form_field_id[]" value="{{ $result1[$i]->id }}">
                                                 
                                                 @php
                                                     $pill_labels = ['Move Type', 'What is the size of your move?', 'What is the size of your home?', 'What is the size of your garden?'];
                                                     $is_pill = false;
                                                     foreach ($pill_labels as $pill_label) {
                                                         if (strpos(strtolower($formFields[$k]->lable_name), strtolower($pill_label)) !== false) {
                                                             $is_pill = true;
                                                             break;
                                                         }
                                                     }
                                                 @endphp
 
                                                 @if($is_pill)
                                                     <div class="radio-card-group select-pill-group" data-select-id="formfield_value_test{{ $formFields[$k]->id }}">
                                                         @if($formFields[$k]->id == 20)
                                                             @php
                                                                if($subservice_id == 23){
                                                                     $in_array = array(56);
                                                                }elseif($subservice_id == 26){
                                                                     $in_array = array(57);
                                                                }elseif($subservice_id == 53){
                                                                     $in_array = array(496);
                                                                }else{
                                                                     $in_array = array();
                                                                }
                                                             @endphp
                                                             @foreach ($form_additionalData as $form_additional)
                                                                 @if(in_array($form_additional->id, $in_array))
                                                                     <div class="radio-card-item select-pill-item" data-value="{{ $form_additional->id }}">
                                                                         <span class="radio-card-label">{{ $form_additional->form_option }}</span>
                                                                     </div>
                                                                 @endif
                                                             @endforeach
                                                         @else
                                                             @foreach ($form_additionalData as $form_additional)
                                                                 <div class="radio-card-item select-pill-item" data-value="{{ $form_additional->id }}">
                                                                     <span class="radio-card-label">{{ $form_additional->form_option }}</span>
                                                                 </div>
                                                             @endforeach
                                                         @endif
                                                     </div>
                                                 @endif
 
                                                 <select class="form-control searches_drop_{{ $formFields[$k]->id }}"
                                                     id="formfield_value_test{{ $formFields[$k]->id }}"
                                                     name="formfield_value[]"
                                                     onchange="get_sub_select(this.value,'{{ $formFields[$k]->id }}')"
                                                     @if($is_pill) style="display: none;" @endif>
                                                     <option value="">Select {{ $formFields[$k]->lable_name }}
                                                     </option>
 
                                                     
                                                     @if($formFields[$k]->id == 20)
 
                                                         @php
                                                            if($subservice_id == 23){
                                                                 $in_array = array(56);
                                                            }elseif($subservice_id == 26){
                                                                 $in_array = array(57);
                                                            }elseif($subservice_id == 53){
                                                                 $in_array = array(496);
                                                            }else{
                                                                 $in_array = array();
                                                            }
                                                         @endphp
 
 @foreach ($form_additionalData as $form_additional)
 @if(in_array($form_additional->id, $in_array))
     <option value="{{ $form_additional->id}}">
         {{ $form_additional->form_option }}
     </option>
 @endif
 @endforeach
 
                                                     @else
 
                                                         @foreach ($form_additionalData as $form_additional)
                                                             <option value="{{ $form_additional->id }}"
                                                                 @if ($form_additional->form_id == 39 && $form_additional->form_option == 'UAE' || $form_additional->form_id == 39 && $form_additional->form_option == 'United Arab Emirates') selected @endif>
                                                                 {{ $form_additional->form_option }}</option>
                                                         @endforeach
 
                                                     @endif
                                                 </select>
                                                 <p class="form-error-text"
                                                     id="drop_down_error_formfield_value_{{ $formFields[$k]->id }}"
                                                     style="color: red; margin-top: 10px;"></p>
                                                 <span id="replace_select_{{ $formFields[$k]->id }}"></span>
                                             </div>
                                         @endif
 
                                         @if ($result1[$i]->type == '3')
                                             <div class="mb15 {{ $colClass }}">
                                                 <label
                                                     class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}">{{ $formFields[$k]->lable_name }}</label>
 
                                                 <input name="form_field_radio_id_one[]" type="hidden" class="m-0"
                                                     id="form_field_id[]" value="{{ $result1[$i]->id }}">
 
                                                 <div class="radio-card-group">
                                                     @foreach ($form_additionalData as $form_additional)
                                                         <label class="radio-card-item">
                                                             <input name="formfield_radio_{{ $formFields[$k]->id }}"
                                                                 type="radio"
                                                                 id="formfield_value_{{ $formFields[$k]->id }}_{{ $loop->index }}" placeholder=""
                                                                 value="{{ $form_additional->form_option }}">
                                                             <span class="radio-card-label">{{ $form_additional->form_option }}</span>
                                                         </label>
                                                     @endforeach
                                                 </div>
                                                 <p class="form-error-text" id="radio_error"
                                                     style="color: red; margin-top: 10px;">
                                                 </p>
                                             </div>
                                         @endif
 
                                         @if ($result1[$i]->type == '4')
                                             <div class="mb15 {{ $colClass }}">
                                                 <input name="form_field_checkbox_id_one[]" type="hidden" class="m-0"
                                                     id="form_field_id[]" value="{{ $result1[$i]->id }}">
                                                 <label
                                                     class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}">{{ $formFields[$k]->lable_name }}</label>
                                                 <div class="checkbox-card-group">
                                                     @foreach ($form_additionalData as $form_additional)
                                                         <label class="checkbox-card-item">
                                                             <input name="formfield_checkbox_{{ $formFields[$k]->id }}[]"
                                                                 type="checkbox"
                                                                 id="formfield_value_checkbox{{ $formFields[$k]->id }}_{{ $loop->index }}"
                                                                 placeholder="" value="{{ $form_additional->form_option }}">
                                                             <span class="checkbox-card-label">{{ $form_additional->form_option }}</span>
                                                         </label>
                                                     @endforeach
                                                 </div>
                                                 <p class="form-error-text"
                                                     id="formfield_value_checkbox1{{ $formFields[$k]->id }}"
                                                     style="color: red; margin-top: 10px;">
                                                 </p>
                                             </div>
                                         @endif
                                         @if ($result1[$i]->type == '5')
                                             <div class="mb15 {{ $colClass }}">
                                                 <input name="form_field_id[]" type="hidden" class="m-0"
                                                     id="form_field_id[]" value="{{ $result1[$i]->id }}">
                                                 <label
                                                     class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}">{{ $formFields[$k]->lable_name }}</label>
                                                 <textarea name="formfield_value[]" id="formfield_value_textarea{{ $formFields[$k]->id }}"
                                                     placeholder="{{ $formFields[$k]->lable_name }}" class="form-control"></textarea>
 
                                                 <p class="form-error-text" id="textarea_error"
                                                     style="color: red; margin-top: 10px;">
                                                 </p>
                                             </div>
                                         @endif
                                         @if ($result1[$i]->type == '6')
                                             <div class="mb15 {{ $colClass }}">
                                                 <label
                                                     class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}">{{ $formFields[$k]->lable_name }}</label>
                                                 <input name="form_field_id[]" type="hidden" class="m-0"
                                                     id="form_field_id[]" value=" {{ $result1[$i]->id }}">
                                                 <input name="formfield_value[]" type="date" class="form-control"
                                                     id="formfield_value_date{{ $formFields[$k]->id }}"
                                                     placeholder="{{ $formFields[$k]->lable_name }}" class="">
                                             </div>
                                             <p class="form-error-text"
                                                 id="formfield_value_date12{{ $formFields[$k]->id }}"
                                                 style="color: red; margin-top: 10px;">
                                             </p>
                                         @endif
 
                                         @if ($result1[$i]->type == '7')
                                             <div class="form-group mb-3 {{ $colClass }}">
                                                 <label class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}"
                                                     for="country">{{ $formFields[$k]->lable_name }}</label>
                                                 <input name="form_field_mul_dropdown_id[]" type="hidden"
                                                     class="m-0" id="form_field_id[]"
                                                     value="{{ $formFields[$k]->id }}">
                                                 <select class="form-control multiple"
                                                     id="formfield_value_{{ $formFields[$k]->id }}"
                                                     name="formfield_mul_dropdown_{{ $formFields[$k]->id }}[]"
                                                     multiple="multiple">
                                                     <option value="">Select {{ $formFields[$k]->lable_name }}
                                                     </option>
                                                     @foreach ($form_additionalData as $form_additional)
                                                         <option value="{{ $form_additional->form_option }}">
                                                             {{ $form_additional->form_option }}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                             <p class="form-error-text" id="mul_drop_error_{{ $formFields[$k]->id }}"
                                                 style="color: red; margin-top: 10px;">
                                             </p>
                                         @endif
                                         {{-- @if ($result1[$i]->type == '8')
                                             <div class="mb15">
                                                 <label
                                                     class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}">{{ $formFields[$k]->lable_name }}</label>
                                                 <input name="form_field_id[]" type="hidden" class="m-0"
                                                     id="form_field_id[]" value=" {{ $result1[$i]->id }}">
                                                 <input name="formfield_Image_value[]" type="file"
                                                     class="form-control {{ $formFields[$k]->id }}"
                                                     id="formfield_value_Image{{ $formFields[$k]->id }}"
                                                     placeholder="{{ $formFields[$k]->lable_name }}">
                                             </div>
                                             <p class="form-error-text" id="file_error_{{ $formFields[$k]->id }}"
                                                 style="color: red; margin-top: 10px;">
                                             </p>
                                         @endif --}}
                                         @if ($result1[$i]->type == '8')
                                             <div class="mb15 {{ $colClass }}">
                                                 <label
                                                     class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}">{{ $formFields[$k]->lable_name }}</label>
                                                 <input name="form_field_id_image[]" type="hidden" class="m-0"
                                                     id="form_field_id" value="{{ $result1[$i]->id }}">
                                                 
                                                 <div class="file-upload-wrapper" onclick="document.getElementById('formfield_value_Image{{ $formFields[$k]->id }}').click()">
                                                     <div class="file-upload-icon">
                                                         <i class="fa-solid fa-cloud-arrow-up"></i>
                                                     </div>
                                                     <div style="font-weight: 600; color: #475569; font-size: 14px;">Click to upload photos</div>
                                                     <div style="color: #94A3B8; font-size: 12px; margin-top: 4px;">PNG, JPG or JPEG (multiple allowed)</div>
                                                     <input name="formfield_Image_value{{ $formFields[$k]->id }}[]"
                                                         type="file" class="form-control {{ $formFields[$k]->id }}"
                                                         id="formfield_value_Image{{ $formFields[$k]->id }}"
                                                         placeholder="{{ $formFields[$k]->lable_name }}" multiple style="display: none;"
                                                         onchange="updateFileNameDisplay(this, 'file_name_display_{{ $formFields[$k]->id }}')">
                                                     
                                                     <div id="file_name_display_{{ $formFields[$k]->id }}" style="margin-top: 10px; font-weight: 600; color: #0040E6; font-size: 13px;"></div>
                                                 </div>
                                             </div>
                                             <p class="form-error-text" id="file_error_{{ $formFields[$k]->id }}"
                                                 style="color: red; margin-top: 10px;"></p>
                                         @endif
                                         @if ($result1[$i]->type == '9')
                                             <div class="mb15 {{ $colClass }}">
                                                 <label
                                                     class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}">{{ $formFields[$k]->lable_name }}</label>
                                                 <input name="form_field_id[]" type="hidden" class="m-0"
                                                     id="form_field_id[]" value=" {{ $result1[$i]->id }}">
                                                 <input name="formfield_value[]" type="time" class="form-control"
                                                     id="formfield_value_time{{ $formFields[$k]->id }}"
                                                     placeholder="{{ $formFields[$k]->lable_name }}" class="">
                                             </div>
                                             <p class="form-error-text"
                                                 id="formfield_value_time_one{{ $formFields[$k]->id }}"
                                                 style="color: red; margin-top: 10px;">
                                             </p>
                                         @endif
                                     @endif
                                 @endfor
                             @endfor
                        </div>

                         <div class="row" id="intform" style="display:none;">
                             @for ($i = 0; $i < count($result2); $i++)
                                 @for ($k = 0; $k < count($formFields); $k++)
                                     @php
 
                                         $form_additionalData = DB::table('form_attributes')
                                             ->select('*')
                                             ->where('form_id', '=', $result2[$i]->id)
                                             ->get()
                                             ->toArray();
                                         // echo '<pre>';
                                         // print_r($form_additionalData);
                                         // echo '</pre>';
                                         // exit();
 
                                         $required = $formFields[$k]->is_active;
                                     @endphp
                                     @if ($result2[$i]->lable_name == $formFields[$k]->lable_name)
                                         @php
                                             $fieldName = trim($formFields[$k]->lable_name);
                                             $colClass = 'col-12';
                                             if (
                                                 strcasecmp($fieldName, 'Moving From') === 0 || 
                                                 strcasecmp($fieldName, 'Moving From?') === 0 || 
                                                 strcasecmp($fieldName, 'Moving From Area') === 0 || 
                                                 strcasecmp($fieldName, 'Moving To') === 0 || 
                                                 strcasecmp($fieldName, 'Moving To Area') === 0 || 
                                                 strcasecmp($fieldName, 'Moving To Country') === 0 || 
                                                 strcasecmp($fieldName, 'Moving To City') === 0 || 
                                                 strcasecmp($fieldName, 'ZIP Code') === 0
                                             ) {
                                                 $colClass = 'col-md-6 col-12';
                                             }
                                         @endphp

                                         @if ($result2[$i]->type == '1')
                                             <div class="mb15 {{ $colClass }}">
                                                 <label
                                                     class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}">{{ $formFields[$k]->lable_name }}</label>
                                                 <input name="form_field_id[]" type="hidden" class="m-0"
                                                     id="form_field_id[]" value=" {{ $result2[$i]->id }}">
                                                 <input name="formfield_value[]" type="text" class="form-control"
                                                     id="formfield_value_123{{ $formFields[$k]->id }}"
                                                     placeholder="{{ $formFields[$k]->lable_name }}" class="">
 
                                                 <p class="form-error-text" id="name2_error_{{ $formFields[$k]->id }}"
                                                     style="color: red; margin-top: 10px;">
                                                 </p>
                                             </div>
                                         @endif
                                         @if ($result2[$i]->type == '2' && $result2[$i]->lable_name != 'Do you require any additional service?')
                                             <div class="form-group mb-3 {{ $colClass }}">
                                                 <label class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}"
                                                     for="country">{{ $formFields[$k]->lable_name }}</label>
                                                 <input name="form_field_id[]" type="hidden" class="m-0"
                                                     id="form_field_id[]" value="{{ $result2[$i]->id }}">
                                                 
                                                 @php
                                                     $pill_labels = ['Move Type', 'What is the size of your move?', 'What is the size of your home?', 'What is the size of your garden?'];
                                                     $is_pill = false;
                                                     foreach ($pill_labels as $pill_label) {
                                                         if (strpos(strtolower($formFields[$k]->lable_name), strtolower($pill_label)) !== false) {
                                                             $is_pill = true;
                                                             break;
                                                         }
                                                     }
                                                 @endphp
 
                                                 @if($is_pill)
                                                     <div class="radio-card-group select-pill-group" data-select-id="formfield_value_drop{{ $formFields[$k]->id }}">
                                                         @foreach ($form_additionalData as $form_additional)
                                                             <div class="radio-card-item select-pill-item" data-value="{{ $form_additional->id }}">
                                                                 <span class="radio-card-label">{{ $form_additional->form_option }}</span>
                                                             </div>
                                                         @endforeach
                                                     </div>
                                                 @endif
 
                                                 <select class="form-control searches_drop_{{ $formFields[$k]->id }}"
                                                     id="formfield_value_drop{{ $formFields[$k]->id }}"
                                                     name="formfield_value[]"
                                                     onchange="get_sub_select_two(this.value,'{{ $formFields[$k]->id }}')"
                                                     @if($is_pill) style="display: none;" @endif>
                                                     <option value="">Select {{ $formFields[$k]->lable_name }}
                                                     </option>
                                                     @foreach ($form_additionalData as $form_additional)
                                                         <option value="{{ $form_additional->id }}"
                                                             {{-- @if ($form_additional->form_id == 57 && $form_additional->form_option == 'UAE') selected @endif --}}>
                                                             {{ $form_additional->form_option }}</option>
                                                     @endforeach
                                                 </select>
                                                 <p class="form-error-text"
                                                     id="drop_down_error_formfield_value_drop{{ $formFields[$k]->id }}"
                                                     style="color: red; margin-top: 10px;">
                                                 </p>
                                                 <span id="replace_select_two{{ $formFields[$k]->id }}"></span>
                                             </div>
                                         @endif
                                         @if ($result2[$i]->type == '3')
                                             <div class="mb15 {{ $colClass }}">
                                                 <label
                                                     class="form-label fw500 dark-color">{{ $formFields[$k]->lable_name }}</label>
 
                                                 <input name="form_field_radio_id_two[]" type="hidden" class="m-0"
                                                     id="form_field_id[]" value="{{ $result2[$i]->id }}">
 
                                                 <div class="radio-card-group">
                                                     @foreach ($form_additionalData as $form_additional)
                                                         <label class="radio-card-item">
                                                             <input name="formfield_radio_{{ $formFields[$k]->id }}"
                                                                 type="radio"
                                                                 id="formfield_value_{{ $formFields[$k]->id }}_{{ $loop->index }}" placeholder=""
                                                                 value="{{ $form_additional->form_option }}">
                                                             <span class="radio-card-label">{{ $form_additional->form_option }}</span>
                                                         </label>
                                                     @endforeach
                                                 </div>
                                                 <p class="form-error-text"
                                                     id="formfield_value_red{{ $formFields[$k]->id }}"
                                                     style="color: red; margin-top: 10px;">
                                                 </p>
                                             </div>
                                         @endif
 
                                         @if ($result2[$i]->type == '4')
                                             <div class="mb15 {{ $colClass }}">
                                                 <input name="form_field_checkbox_id_two[]" type="hidden" class="m-0"
                                                     id="form_field_id[]" value="{{ $result2[$i]->id }}">
                                                 <label
                                                     class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}">{{ $formFields[$k]->lable_name }}</label>
                                                 <div class="checkbox-card-group">
                                                     @foreach ($form_additionalData as $form_additional)
                                                         <label class="checkbox-card-item">
                                                             <input name="formfield_checkbox_{{ $formFields[$k]->id }}[]"
                                                                 type="checkbox"
                                                                 id="formfield_value_{{ $formFields[$k]->id }}_{{ $loop->index }}"
                                                                 placeholder="" value="{{ $form_additional->form_option }}">
                                                             <span class="checkbox-card-label">{{ $form_additional->form_option }}</span>
                                                         </label>
                                                     @endforeach
                                                 </div>
                                                 <p class="form-error-text"
                                                     id="formfield_value_c2{{ $formFields[$k]->id }}"
                                                     style="color: red; margin-top: 10px;">
                                                 </p>
                                             </div>
                                         @endif
                                         @if ($result2[$i]->type == '5')
                                             <div class="mb15 {{ $colClass }}">
                                                 <input name="form_field_id[]" type="hidden" class="m-0"
                                                     id="form_field_id[]" value="{{ $result2[$i]->id }}">
                                                 <label
                                                     class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}">{{ $formFields[$k]->lable_name }}</label>
                                                 <textarea name="formfield_value[]" id="formfield_value{{ $formFields[$k]->id }}"
                                                     placeholder="{{ $formFields[$k]->lable_name }}" class="form-control"></textarea>
 
                                                 <p class="form-error-text"
                                                     id="formfield_value_01{{ $formFields[$k]->id }}"
                                                     style="color: red; margin-top: 10px;">
                                                 </p>
                                             </div>
                                         @endif
 
                                         @if ($result2[$i]->type == '6')
                                             <div class="mb15 {{ $colClass }}">
                                                 <label
                                                     class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}">{{ $formFields[$k]->lable_name }}</label>
                                                 <input name="form_field_id[]" type="hidden" class="m-0"
                                                     id="form_field_id[]" value=" {{ $result2[$i]->id }}">
                                                 <input name="formfield_value[]" type="date" class="form-control"
                                                     id="formfield_value{{ $formFields[$k]->id }}"
                                                     placeholder="{{ $formFields[$k]->lable_name }}" class="">
                                             </div>
                                             <p class="form-error-text"
                                                 id="formfield_value_date_2{{ $formFields[$k]->id }}"
                                                 style="color: red; margin-top: 10px;">
                                             </p>
                                         @endif
 
                                         @if ($result2[$i]->type == '7')
                                             <div class="form-group mb-3 {{ $colClass }}">
                                                 <label class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}"
                                                     for="country">{{ $formFields[$k]->lable_name }}</label>
                                                 <input name="formfield_mul_dropdown_[]" type="hidden" class="m-0"
                                                     id="form_field_id[]" value="{{ $result2[$i]->id }}">
                                                 <select class="form-control multiple"
                                                     id="formfield_value_mul_test2{{ $formFields[$k]->id }}"
                                                     name="formfield_mul_dropdown_{{ $formFields[$k]->id }}[]"
                                                     multiple="multiple">
                                                     <option value="">Select {{ $formFields[$k]->lable_name }}
                                                     </option>
                                                     @foreach ($form_additionalData as $form_additional)
                                                         <option value="{{ $form_additional->form_option }}">
                                                             {{ $form_additional->form_option }}</option>
                                                     @endforeach
                                                 </select>
                                                 <p class="form-error-text"
                                                     id="mul2_drop_error_{{ $formFields[$k]->id }}"
                                                     style="color: red; margin-top: 10px;">
                                                 </p>
                                             </div>
                                         @endif
                                         @if ($result2[$i]->type == '8')
                                             <div class="mb15 {{ $colClass }}">
                                                 <label
                                                     class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}">{{ $formFields[$k]->lable_name }}</label>
                                                 <input name="form_field_id_image[]" type="hidden" class="m-0"
                                                     id="form_field_id" value="{{ $result1[$i]->id }}">
                                                 
                                                 <div class="file-upload-wrapper" onclick="document.getElementById('formfield_value_Image_two{{ $formFields[$k]->id }}').click()">
                                                     <div class="file-upload-icon">
                                                         <i class="fa-solid fa-cloud-arrow-up"></i>
                                                     </div>
                                                     <div style="font-weight: 600; color: #475569; font-size: 14px;">Click to upload photos</div>
                                                     <div style="color: #94A3B8; font-size: 12px; margin-top: 4px;">PNG, JPG or JPEG (multiple allowed)</div>
                                                     <input name="formfield_Image_value{{ $formFields[$k]->id }}[]"
                                                         type="file" class="form-control {{ $formFields[$k]->id }}"
                                                         id="formfield_value_Image_two{{ $formFields[$k]->id }}"
                                                         placeholder="{{ $formFields[$k]->lable_name }}" multiple style="display: none;"
                                                         onchange="updateFileNameDisplay(this, 'file_name_display_two_{{ $formFields[$k]->id }}')">
                                                     
                                                     <div id="file_name_display_two_{{ $formFields[$k]->id }}" style="margin-top: 10px; font-weight: 600; color: #0040E6; font-size: 13px;"></div>
                                                 </div>
                                             </div>
                                             <p class="form-error-text" id="file_error_two_{{ $formFields[$k]->id }}"
                                                 style="color: red; margin-top: 10px;"></p>
                                         @endif
                                         @if ($result2[$i]->type == '9')
                                             <div class="mb15 {{ $colClass }}">
                                                 <label
                                                     class="form-label fw500 dark-color {{ $required == 1 ? 'requiredStar' : '' }}">{{ $formFields[$k]->lable_name }}</label>
                                                 <input name="form_field_id[]" type="hidden" class="m-0"
                                                     id="form_field_id[]" value=" {{ $result1[$i]->id }}">
                                                 <input name="formfield_value[]" type="time" class="form-control"
                                                     id="formfield_value_time_two{{ $formFields[$k]->id }}"
                                                     placeholder="{{ $formFields[$k]->lable_name }}" class="">
                                             </div>
                                             <p class="form-error-text"
                                                 id="formfield_value_time_sec{{ $formFields[$k]->id }}"
                                                 style="color: red; margin-top: 10px;">
                                         @endif
                                     @endif
                                 @endfor
                             @endfor
                        </div>

                        <!-- Step 1 Actions -->
                        <div class="d-grid mt-4 pt-3" style="border-top: 1px solid #F1F5F9;">
                            <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                style="display: none; height: 50px; border-radius: 8px;">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                            <button type="button" class="btn-thm"
                                onclick="javascript:category_validation()" id="submit_button">
                                Continue <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>


        <form id="category_form_new" action="{{ route('package_inquiry_new') }}" method="POST"
            style="display: {{ $display_newform }};">
            @csrf
            <input name="service_id" id="service_id" type="hidden" class="form-control"
                value="{{ $service_id }}">
            <input name="subservice_id" id="subservice_id" type="hidden" class="form-control"
                value="{{ $subservice_id }}">

            <div class="enquiry-layout-grid wow fadeInRight" data-wow-delay="300ms">
                <!-- Left Column: Step Cards -->
                <div class="enquiry-left-column">
                    <div class="enquiry-card-ui">
                        <div class="card-title-new" style="display: flex; align-items: center; gap: 10px; margin-bottom: 25px;">
                            <i class="fa-solid fa-clipboard-check" style="color: #0040E6; font-size: 20px;"></i>
                            <span style="font-size: 20px; font-weight: 700; color: #0F172A;">Booking Summary</span>
                        </div>

                        <ul class="detail-list" style="list-style: none; padding: 0; margin: 0 0 25px 0;">
                            <li style="display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #F1F5F9;">
                                <span style="color: #64748B; font-weight: 500;">Service Category</span>
                                <span style="color: #0F172A; font-weight: 600;">{!! Helper::servicename($service_id) !!}</span>
                            </li>
                            <li style="display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #F1F5F9;">
                                <span style="color: #64748B; font-weight: 500;">Service Type</span>
                                <span style="color: #0F172A; font-weight: 600;">{!! Helper::subservicename($subservice_id) !!}</span>
                            </li>
                            @if(isset($enquiry))
                                <li style="display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #F1F5F9;">
                                    <span style="color: #64748B; font-weight: 500;">Move/Job Type</span>
                                    <span style="color: #0F172A; font-weight: 600;">{{ $enquiry->form_type }}</span>
                                </li>
                            @endif
                            @if(isset($submittedFields))
                                @foreach($submittedFields as $field)
                                    @if($field->formfield_value != '')
                                        @php
                                            $displayValue = $field->formfield_value;
                                            if (is_numeric($displayValue)) {
                                                $option = DB::table('form_attributes')->where('id', $displayValue)->first();
                                                if ($option) {
                                                    $displayValue = $option->form_option;
                                                }
                                            }
                                        @endphp
                                        <li style="display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #F1F5F9;">
                                            <span style="color: #64748B; font-weight: 500;">{{ $field->lable_name }}</span>
                                            <span style="color: #0F172A; font-weight: 600;">{{ $displayValue }}</span>
                                        </li>
                                        @php
                                            $packageEnquiryFormId = session('packages_enquiry_form_id');
                                            $subFields = DB::table('more_formfields_details_att')
                                                ->where('form_id', '=', $field->form_field_id)
                                                ->where('package_inquiry_id', '=', $packageEnquiryFormId)
                                                ->get();
                                        @endphp
                                        @if(count($subFields) > 0)
                                            @foreach($subFields as $subField)
                                                @php
                                                    $subLabel = "What is the size of your home?";
                                                    if ($field->form_field_id == 35) {
                                                        $subLabel = "What days of the week would you like the service";
                                                    }
                                                    $subValue = \Helper::form_fields_attr_more($subField->more_form_attributes_id);
                                                @endphp
                                                <li style="display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #F1F5F9;">
                                                    <span style="color: #64748B; font-weight: 500;">{{ $subLabel }}</span>
                                                    <span style="color: #0F172A; font-weight: 600;">{{ $subValue }}</span>
                                                </li>
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        </ul>

                        <div style="margin-top: 30px;">
                            <button type="submit" class="btn-thm" id="submit_button_final" style="width: 100%;">
                                Get Quote <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const form = document.getElementById('category_form_new');
                                if (form) {
                                    form.addEventListener('submit', function() {
                                        const btn = document.getElementById('submit_button_final');
                                        if (btn) {
                                            btn.disabled = true;
                                            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="margin-right: 8px;"></span>Loading...';
                                        }
                                    });
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

{{-- Login PopModal --}}


<!-- OTP Popup Start-->
<div class="modal modal-mobile-bottom-otp otp-login-form-modal" id="exampleModalLong" tabindex="-1" aria-labelledby="otpLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-bottom-otp user-modal-dialog modal-dialog-centered">
    <div class="modal-content details-modal-content">
      <div class="modal-header details-header">
      <h5 class="modal-title w-100" id="modalStepTitle">Log in or Sign Up</h5>
      </div> 

      <div class="modal-body">
        <div id="booknow_refresh_otp_div">
        <input type="hidden" name="book_session_otp" id="book_session_otp" value= "{{session('book-login-otp')}}">
        </div>
        <form class="form-horizontal details-form" id="BookOtpForm" method="POST" action="{{ route('booknow-user-otp-login') }}">

        <input type="hidden" name="redirectUrl" value="{{ $redirectUrl }}">
        <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
        <input type="hidden" name="subservice_id" id="subservice_id" value="{{ $subservice_id }}">

        @csrf

          <!-- STEP 1: Mobile Input -->
          <div id="booknow-step-phone">
            <div class="form-group mb-2">
              <label id="mobilename-label">Please Enter Your WhatsApp mobile number</label>
              <input type="hidden" name="country_code_otp_popup_Modal" id="country_code_otp_popup_Modal_book" value="">
              <input type="text" class="input-field" name="phone" id="user-phone-number" placeholder="Mobile No" onkeypress="return validateNumber(event)">
              <p id="booknow_otp_phone_error" style="display:none;color:red;"></p>
            </div>
			<a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp" data-bs-target="#book_email_otp_popup_Modal">Don't have a WhatsApp Number? Login with Email</a>
            <div class="text-center mt-3">
			
			<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_phone_book1" style="display: none;">
				<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...
            </button>
			
              <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_phone_book1" onclick="booknow_otp_verification('1')">Continue</button>
            </div>
          </div>

          <!-- STEP 2: OTP Verification -->
          <div id="booknow-step-otp" style="display: none;">
            <label id="mobilename-label">Please enter the <strong>WhatsApp code</strong> that was sent to:<br>
              <span id="booknow-whatsapp-number">+971 58 520 0722</span>
            </label>

            <div class="d-flex justify-content-center gap-2 my-3">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
            </div>
            <p id="booknow_otp_error" style="display:none;color:red;"></p>

            <a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp" data-bs-target="#book_email_otp_popup_Modal">Can't log in? Use your Email Address</a>

            <div class="text-center mt-3">
			<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_phone_book2" style="display: none;">
				<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...
            </button>
              <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_phone_book2" onclick="booknow_otp_verification('2')" >Verify Number</button>
            </div>
          </div>

          <!-- STEP 3: Personal Details -->
        <div id="booknow-step-details" style="display: none;">
        <label id="mobilename-label">Contact information</label>
        <div class="form-group mt-3">
            <input type="text" class="form-control" name="book_name" id="booknow_user_name" placeholder="Full Name">
            <p id="booknow_name_error" style="display:none;color:red;"></p>
        </div>
        <div class="form-group mt-3">
            <input type="email" class="form-control" id="booknow_user_email" name="book_email" placeholder="Email">
            <p id="booknow_email_error" style="display:none;color:red;"></p>
        </div>
        <div class="text-center mt-3">
		<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_phone_book3" style="display: none;">

        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>

        <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_phone_book3" onclick="booknow_otp_verification('3')">All Done</button>

        </div>
        
        <div class="mt-3">
            <a href="{{ route('privacy_policy') }}" class="footer-link me-3">Privacy Policy</a>
            <a href="{{ route('term_condition') }}" class="footer-link">Terms of Service</a>
        </div>

        </div>


        </form>
      </div>

    </div>
  </div>
</div>

<!-- OTP Popup End-->


<!-- email OTP Popup Start-->

<div class="modal modal-mobile-bottom-otp otp-login-form-modal" id="book_email_otp_popup_Modal" tabindex="-1" aria-labelledby="otpLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-bottom-otp user-modal-dialog modal-dialog-centered">
    <div class="modal-content details-modal-content">
      <div class="modal-header details-header">
      <h5 class="modal-title w-100" id="booknow_email_modalStepTitle">Log in or Sign Up</h5>
      </div> 

      <div class="modal-body">
        <div id="book_email_refresh_otp_div">
        <input type="hidden" name="book_email_session_otp" id="book_email_session_otp" value= "{{session('book-email-login-otp')}}">
        </div>
        <form class="form-horizontal details-form" id="bookemailOtpForm" method="POST" action="{{ route('home.book-email-otp-login') }}">
        <input type="hidden" name="redirectUrl" value="{{ $redirectUrl }}">
        <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
        <input type="hidden" name="subservice_id" id="subservice_id" value="{{ $subservice_id }}">
		<input type="hidden" name="country_code_book_popup_Modal_book" id="country_code_book_popup_Modal_book" value="">
          @csrf


          <!-- STEP 1: Mobile Input -->
          <div id="book-email-step-phone">
            <div class="form-group mb-2">
              <label id="mobilename-label">Please Enter Your Email Address</label>
              <input type="text" class="input-field" name="book_email_email" id="book_email_email" placeholder="Email Address">
              <p id="book_email_email_error" style="display:none;color:red;"></p>
            </div>
			<a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp" data-bs-target="#exampleModalLong">Can't access your email? Log in with WhatsApp</a>
            <div class="text-center mt-3">
				<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_email_book1"
                                style="display: none;">

                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                Loading...

            </button>
              <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_email_book1" onclick="book_email_goToOtpVerification('1')">Continue</button>
            </div>
          </div>

          <!-- STEP 2: OTP Verification -->
          <div id="booknow-email-step-otp" style="display: none;">
            <label id="mobilename-label">Please enter the <strong>OTP</strong> that was sent to:<br>
			 <span id="book_email_address_model">+971 58 520 0722</span>
            </label>

            <div class="d-flex justify-content-center gap-2 my-3">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
            </div>
            <p id="book_email_otp_error" style="display:none;color:red;"></p>
            <a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp" data-bs-target="#exampleModalLong">Can't access your email? Log in with WhatsApp</a>

            <div class="text-center mt-3">
			<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_email_book2" style="display: none;">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>

              <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_email_book2" onclick="book_email_goToOtpVerification('2')" >Verify Email</button>
            </div>
          </div>

          <!-- STEP 3: Personal Details -->
        <div id="booknow-email-step-details" style="display: none;">
        <label id="mobilename-label">Contact information</label>
        <div class="form-group mt-3">
            <input type="text" class="form-control" name="book_email_name" id="book_email_name" placeholder="Full Name">
            <p id="book_email_name_error" style="display:none;color:red;"></p>
        </div>
        <div class="form-group mt-3">
            <input type="text" class="form-control" id="book_email_mobile" name="book_email_mobile" placeholder="Phone Number" onkeypress="return validateNumber(event)">
            <p id="book_email_mobile_error" style="display:none;color:red;"></p>
        </div>
        {{-- <div class="form-group mt-3">
            <input type="text" class="form-control" id="book_email_area" name="book_email_area" placeholder="Area">
            <p id="book_email_area_error" style="display:none;color:red;"></p>
        </div> --}}
        <div class="text-center mt-3">
		<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_email_book3" style="display: none;"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>

        <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_email_book3" onclick="book_email_goToOtpVerification('3')">All Done</button>
        </div>

        <div class="mt-3">
            <a href="{{ route('privacy_policy') }}" class="footer-link me-3">Privacy Policy</a>
            <a href="{{ route('term_condition') }}" class="footer-link">Terms of Service</a>
        </div>
        </div>


        </form>
      </div>

    </div>
  </div>
</div>

<!-- Email Otp Popup end -->

@include('front.includes.footer')


<script>
    @for ($k = 0; $k < count($formFields); $k++)
        $(document).ready(function() {
            $('.searches_drop_{{ $formFields[$k]->id }}').select2();
        });
    @endfor
</script>

<script>
    function updateFileNameDisplay(input, elementId) {
        var display = document.getElementById(elementId);
        if (input.files && input.files.length > 0) {
            var names = Array.from(input.files).map(f => f.name).join(', ');
            display.innerHTML = '<i class="fa-solid fa-file-image"></i> Selected: ' + names;
        } else {
            display.innerHTML = '';
        }
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

document.addEventListener("DOMContentLoaded", function () {
    const Otpphoneinput = document.querySelector("#user-phone-number");

    const Otpphoneinputnew = window.intlTelInput(Otpphoneinput, {
        initialCountry: "ae",  // UAE
        separateDialCode: true,
        autoPlaceholder: "aggressive",
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });

    // Assign globally
    window.Otpphoneinputnew = Otpphoneinputnew;

    // Update hidden country code when user selects a country
    const countryCodeInput = document.querySelector("#country_code_otp_popup_Modal_book");

    function setCountryCode() {
        const countryData = Otpphoneinputnew.getSelectedCountryData();
        countryCodeInput.value = countryData.dialCode; // store only dial code (e.g. 971)
        // If you want full ISO code (like 'AE') → use countryData.iso2
    }

    // Set default initially
    setCountryCode();

    // Listen to country change
    Otpphoneinput.addEventListener("countrychange", function () {
        setCountryCode();
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const Otpphoneinput = document.querySelector("#book_email_mobile");

    const Otpphoneinputnew = window.intlTelInput(Otpphoneinput, {
        initialCountry: "ae",  // UAE
        separateDialCode: true,
        autoPlaceholder: "aggressive",
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });

    // Assign globally
    window.Otpphoneinputnew = Otpphoneinputnew;

    // Update hidden country code when user selects a country
    const countryCodeInput = document.querySelector("#country_code_book_popup_Modal_book");

    function setCountryCode() {
        const countryData = Otpphoneinputnew.getSelectedCountryData();
        countryCodeInput.value = countryData.dialCode; // store only dial code (e.g. 971)
        // If you want full ISO code (like 'AE') → use countryData.iso2
    }

    // Set default initially
    setCountryCode();

    // Listen to country change
    Otpphoneinput.addEventListener("countrychange", function () {
        setCountryCode();
    });
});

// @if(Session::get('user') =="")
// $(document).ready(function() {
//   $('#exampleModalLong').modal({
//     backdrop: 'static',  // Prevent closing on clicking outside
//     keyboard: false       // Prevent closing with ESC key
//   }).modal('show');      // Show the modal on page load
// });

// $(document).ready(function() {
//     $('#exampleModalLong').modal('show'); // Show the modal on page load
//   });
// @endif

// const phoneInputField = document.querySelector("#user-phone-number"); // flagphone
// const phoneInput = window.intlTelInput(phoneInputField, {
//   initialCountry: "ae",  // UAE flag and country code (+971) as default
//   separateDialCode: true, // Separate country code from the number field
//   autoPlaceholder: "aggressive",
//   utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
// });

// // Function to get the selected country code
// function getCountryCode() {
//   const countryData = phoneInput.getSelectedCountryData();
//   const countryCode = countryData.dialCode; // Get the dial code (country code)
//   console.log(countryCode); // Example: "+971" for UAE
//   return countryCode;
// }

// function userPopupLoginForm(){

// var name = $('#user-name').val();
// if (name == '') {
//     jQuery('#name-error').html("Please enter a your name");
//     jQuery('#name-error').show().delay(0).fadeIn('show');
//     jQuery('#name-error').show().delay(2000).fadeOut('show');
//     return false;
// }

// var email = $('#user-email').val();
// if (email == '') {
//     jQuery('#email-error').html("Please enter a your email");
//     jQuery('#email-error').show().delay(0).fadeIn('show');
//     jQuery('#email-error').show().delay(2000).fadeOut('show');
//     return false;
// }

// var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
// if (!filter.test(email)) {

//     jQuery('#email-error').html("Please Enter Valid Email");
//     jQuery('#email-error').show().delay(0).fadeIn('show');
//     jQuery('#email-error').show().delay(2000).fadeOut('show');
//     return false;

// }

// var mobile = jQuery("#user-phone-number").val();
// if (mobile == '') {

//     jQuery('#phone-error').html("Please Enter Mobile No");
//     jQuery('#phone-error').show().delay(0).fadeIn('show');
//     jQuery('#phone-error').show().delay(2000).fadeOut('show');
//     return false;

// }
// if (mobile != '') {
//     // var filter = /^\d{7}$/;
//     if (mobile.length < 7 || mobile.length > 15) {
//         jQuery('#phone-error').html("Please Enter Valid Mobile Number");
//         jQuery('#phone-error').show().delay(0).fadeIn('show');
//         jQuery('#phone-error').show().delay(2000).fadeOut('show');
//         return false;
//     }
// }

// const selectedCountryCode = getCountryCode();
// $("#country_code").val(selectedCountryCode);
// $("#userDetailForm").submit();
// }

$(document).ready(function () {
  // Lock both modals on load
  $('#exampleModalLong').modal({
    backdrop: 'static',
    keyboard: false,
    show: false // Don't show initially
  });

  $('#book_email_otp_popup_Modal').modal({
    backdrop: 'static',
    keyboard: false,
    show: false
  });

  // Show if user not logged in
  @if(Session::get('user') == "")
    $('#exampleModalLong').modal('show');
  @endif
});

/* const phoneInputField = document.querySelector("#user-phone-number"); // flagphone
const phoneInput = window.intlTelInput(phoneInputField, {
  initialCountry: "ae",  // UAE flag and country code (+971) as default
  separateDialCode: true, // Separate country code from the number field
  autoPlaceholder: "aggressive",
  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
});

// Function to get the selected country code
function getCountryCode() {
  const countryData = phoneInput.getSelectedCountryData();
  const countryCode = countryData.dialCode; // Get the dial code (country code)
  console.log(countryCode); // Example: "+971" for UAE
  return countryCode;
} */

   
function booknow_otp_verification(id) {
    // STEP 1: Mobile Input
    // alert('here');
    if (id == '1') {
        var mobile = jQuery("#user-phone-number").val().trim();
        // alert(mobile);

        const selectedCountryCode = getCountryCode();
        $("#country_code").val(selectedCountryCode);
        if (mobile == '') {

        jQuery('#booknow_otp_phone_error').html("Please Enter Mobile No");
        jQuery('#booknow_otp_phone_error').show().delay(0).fadeIn('show');
        jQuery('#booknow_otp_phone_error').show().delay(2000).fadeOut('show');
        return false;

        }
        if (mobile != '') {
            // var filter = /^\d{7}$/;
            if (mobile.length < 7 || mobile.length > 15) {
                jQuery('#booknow_otp_phone_error').html("Please Enter Valid Mobile Number");
                jQuery('#booknow_otp_phone_error').show().delay(0).fadeIn('show');
                jQuery('#booknow_otp_phone_error').show().delay(2000).fadeOut('show');
                return false;
            }
        }

        var url = '{{ url('booknow-otp-sent') }}';
        var mobile = $('#user-phone-number').val();
        var country_code = $('#country_code_otp_popup_Modal_book').val();
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                'mobile': mobile,
                'country_code': country_code
            },
            beforeSend: function () {
                
				$('#spinner_button_phone_book1').show();
				$('#submit_button_phone_book1').hide();
                //$('.detail-continue-btn').prop('disabled', true);
            },
            success: function (response) {
                
                if(response.success === true){
                 
                $("#booknow_refresh_otp_div").load(location.href + " #booknow_refresh_otp_div");

                document.getElementById('booknow-step-phone').style.display = 'none';
                document.getElementById('booknow-step-otp').style.display = 'block';
                document.getElementById('modalStepTitle').innerText = "Verify your phone number";

                $('#booknow-whatsapp-number').text('+' + country_code  + mobile);
                
                if (response.user_data) {
                    $('#booknow_user_name').val(response.user_data.name);
                    $('#booknow_user_email').val(response.user_data.email);
                }

                }

				$('#spinner_button_phone_book1').hide();
				$('#submit_button_phone_book1').show();

                
            },
            error: function (xhr) {

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    alert(xhr.responseJSON.message);
                    $('#exampleModalLong form')[0].reset();
                    $('#exampleModalLong #spinner_button_phone_book1').hide();
                    $('#exampleModalLong #submit_button_phone_book1').show();
                    $('#exampleModalLong').modal('show'); 
                } else {
                    alert("Failed to send OTP. Please try again.");
                     $('#exampleModalLong form')[0].reset();
                    $('#exampleModalLong #spinner_button_phone_book1').hide();
                    $('#exampleModalLong #submit_button_phone_book1').show();
                    $('#exampleModalLong').modal('show'); 
                }
                
            },
            complete: function () {
                $('.detail-continue-btn').prop('disabled', false);
            }
        });

        return false;

       
    }

    // STEP 2: OTP Verification
    if (id == '2') {
        var allFilled = true;
        jQuery('.booknow-otp-input').each(function () {
            if (jQuery(this).val().trim() === '') {
                allFilled = false;
            }
        });

        if (!allFilled) {
            jQuery('#booknow_otp_error').html("Please Enter OTP");
            jQuery('#booknow_otp_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_otp_error').show().delay(2000).fadeOut('show');
            return false;
        }

        let otp = $('#book_session_otp').val();
        // alert(otp);
        let enteredOtp = '';
        document.querySelectorAll('.booknow-otp-input').forEach(input => {
            enteredOtp += input.value;
        });
        // alert(enteredOtp);

        if(otp != enteredOtp){
            jQuery('#booknow_otp_error').html("OTP doesn't match");
            jQuery('#booknow_otp_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_otp_error').show().delay(2000).fadeOut('show');
            return false;
        }
        
      

        let name = jQuery("input[name='book_name']").val().trim();
        let email = jQuery("input[name='book_email']").val().trim();
		
		$('#spinner_button_phone_book2').show();
		$('#submit_button_phone_book2').hide();

        if (name !== '' && email !== '' ) {
                jQuery("#BookOtpForm").submit();
        } else {
            document.getElementById('booknow-step-otp').style.display = 'none';
            document.getElementById('booknow-step-details').style.display = 'block';
            document.getElementById('modalStepTitle').innerText = "Personal Details";
        }
    }

    // STEP 3: Personal Details
    if (id == '3') {
        var name = jQuery("input[name='book_name']").val().trim();
        var email = jQuery("input[name='book_email']").val().trim();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (name === '') {

            jQuery('#booknow_name_error').html("Please Enter Full  Name");
            jQuery('#booknow_name_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_name_error').show().delay(2000).fadeOut('show');
            return false;
        }
        if (email === '') {
            jQuery('#booknow_email_error').html("Please Enter email");
            jQuery('#booknow_email_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_email_error').show().delay(2000).fadeOut('show');
            return false;
        }

        if (!emailRegex.test(email)) {
            jQuery('#booknow_email_error').html("Please Enter Valid email");
            jQuery('#booknow_email_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_email_error').show().delay(2000).fadeOut('show');
            return false;
        }
        
		$('#spinner_button_phone_book3').show();
		$('#submit_button_phone_book3').hide();

        // All validation passed, submit the form
        jQuery("#BookOtpForm").submit();
    }
}

$(document).ready(function () {
    $('.booknow-otp-input').on('input', function () {
        let input = $(this);
        let value = input.val();
        if (/^\d$/.test(value)) {
            input.next('.booknow-otp-input').focus();
        } else {
            input.val('');
        }
    });

    $('.booknow-otp-input').on('keydown', function (e) {
        let input = $(this);
        if (e.key === "Backspace" && input.val() === '') {
            input.prev('.booknow-otp-input').focus();
        }
    });

    $('.booknow-otp-input').on('paste', function (e) {
        let data = e.originalEvent.clipboardData.getData('text');
        let digits = data.replace(/\D/g, '').substring(0, 6).split('');
        $('.booknow-otp-input').each(function (index, element) {
            $(element).val(digits[index] || '');
        });
        if (digits.length > 0) {
            $('.booknow-otp-input').eq(digits.length - 1).focus();
        }
        e.preventDefault();
    });
});

function book_email_goToOtpVerification(id) {
	
	if (id == '1') {
		
        
		var email_email = jQuery("input[name='book_email_email']").val().trim();
		var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		if (email_email === '') {
            jQuery('#book_email_email_error').html("Please Enter email");
            jQuery('#book_email_email_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_email_error').show().delay(2000).fadeOut('show');
            return false;
        }

        if (!emailRegex.test(email_email)) {
            jQuery('#book_email_email_error').html("Please Enter Valid email");
            jQuery('#book_email_email_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_email_error').show().delay(2000).fadeOut('show');
            return false;
        }
		
		// alert(email_email);
		
		var url = '{{ route('home.book-email-otp-sent') }}';
      
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                'email_email': email_email
            },
            beforeSend: function () {
				
				$('#spinner_button_email_book1').show();
				$('#submit_button_email_book1').hide();
                
                //$('.email-detail-continue-btn').prop('disabled', true);
            },
            success: function (response) {
                
                if(response.success === true){
                 
					$("#book_email_refresh_otp_div").load(location.href + " #book_email_refresh_otp_div");

					document.getElementById('book-email-step-phone').style.display = 'none';
					document.getElementById('booknow-email-step-otp').style.display = 'block';
					document.getElementById('booknow_email_modalStepTitle').innerText = "Verify your Email";

					$('#book_email_address_model').text(email_email);
					
					if (response.user_data) {
						$('#book_email_name').val(response.user_data.name);
						$('#book_email_mobile').val(response.user_data.mobile);
						//$('#book_email_area').val(response.user_data.area);
						$('#country_code_book_popup_Modal_book').val(response.user_data.country_code);
					}

                }

                
            },
            error: function (xhr) {

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    alert(xhr.responseJSON.message);
                    $('#book_email_otp_popup_Modal form')[0].reset();
                    $('#book_email_otp_popup_Modal #spinner_button_email_book1').hide();
                    $('#book_email_otp_popup_Modal #submit_button_email_book1').hide();
                    $('#book_email_otp_popup_Modal').modal('show'); 
                } else {
                    alert("Failed to send OTP. Please try again.");
                    $('#book_email_otp_popup_Modal form')[0].reset();
                    $('#book_email_otp_popup_Modal #spinner_button_email_book1').hide();
                    $('#book_email_otp_popup_Modal #submit_button_email_book1').hide();
                    $('#book_email_otp_popup_Modal').modal('show'); 
                }
				
				$('#spinner_button_email_book1').hide();
				$('#submit_button_email_book1').show();
                
            },
            complete: function () {
				
				$('#spinner_button_email_book1').hide();
				$('#submit_button_email_book1').show();
                // Re-enable button
                //$('.email-detail-continue-btn').prop('disabled', false);
            }
        });
		
	}
	
	// STEP 2: OTP Verification
    if (id == '2') {
        var allFilled = true;
        jQuery('.book-email-otp-input').each(function () {
            if (jQuery(this).val().trim() === '') {
                allFilled = false;
            }
        });

        if (!allFilled) {
            jQuery('#book_email_otp_error').html("Please Enter OTP");
            jQuery('#book_email_otp_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_otp_error').show().delay(2000).fadeOut('show');
            return false;
        }

        let otp = $('#book_email_session_otp').val();
        let enteredOtp = '';
        document.querySelectorAll('.book-email-otp-input').forEach(input => {
            enteredOtp += input.value;
        });
        // alert(otp);

        if(otp != enteredOtp){
            jQuery('#book_email_otp_error').html("OTP doesn't match");
            jQuery('#book_email_otp_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_otp_error').show().delay(2000).fadeOut('show');
            return false;
        }
       

        let email_name = jQuery("input[name='book_email_name']").val().trim();
        let email_mobile = jQuery("input[name='book_email_mobile']").val().trim();
		
		$('#spinner_button_email_book2').show();
		$('#submit_button_email_book2').hide();

        if (email_name !== '' && email_mobile !== '') {
           
            jQuery("#bookemailOtpForm").submit();
           
        } else {
            // One or both fields are empty, show Step 3
            document.getElementById('booknow-email-step-otp').style.display = 'none';
            document.getElementById('booknow-email-step-details').style.display = 'block';
            document.getElementById('booknow_email_modalStepTitle').innerText = "Personal Details";
			
			$('#spinner_button_email_book2').hide();
			$('#submit_button_email_book2').show();
        }
    }

    // STEP 3: Personal Details
    if (id == '3') {
        var email_name = jQuery("input[name='book_email_name']").val().trim();
        var email_mobile = jQuery("input[name='book_email_mobile']").val().trim();
        //var email_area = jQuery("input[name='book_email_area']").val().trim();

        if (email_name === '') {

            jQuery('#book_email_name_error').html("Please Enter Full  Name");
            jQuery('#book_email_name_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_name_error').show().delay(2000).fadeOut('show');
            return false;
        }
        if (email_mobile === '') {
            jQuery('#book_email_mobile_error').html("Please Enter Mobile Number");
            jQuery('#book_email_mobile_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_mobile_error').show().delay(2000).fadeOut('show');
            return false;
        }

        if (email_mobile != '') {
            // var filter = /^\d{7}$/;
            if (email_mobile.length < 7 || email_mobile.length > 15) {
                jQuery('#book_email_mobile_error').html("Please Enter Valid Mobile Number");
                jQuery('#book_email_mobile_error').show().delay(0).fadeIn('show');
                jQuery('#book_email_mobile_error').show().delay(2000).fadeOut('show');
                return false;
            }
        }
          /* if (email_area === '') {

            jQuery('#book_email_area_error').html("Please Enter Area");
            jQuery('#book_email_area_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_area_error').show().delay(2000).fadeOut('show');
            return false;
        } */
		
		$('#spinner_button_email_book3').show();
		$('#submit_button_email_book3').hide();

        // All validation passed, submit the form
        jQuery("#bookemailOtpForm").submit();
    }
}

$(document).ready(function () {
    // Toggle active classes on custom radio/checkbox pills
    $(document).on('change', '.radio-card-item input[type="radio"]', function() {
        let name = $(this).attr('name');
        $(`input[type="radio"][name="${name}"]`).closest('.radio-card-item').removeClass('active');
        if ($(this).is(':checked')) {
            $(this).closest('.radio-card-item').addClass('active');
        }
    });

    $(document).on('change', '.checkbox-card-item input[type="checkbox"]', function() {
        if ($(this).is(':checked')) {
            $(this).closest('.checkbox-card-item').addClass('active');
        } else {
            $(this).closest('.checkbox-card-item').removeClass('active');
        }
    });

    // Set initial active states for pre-filled values
    $('.radio-card-item input[type="radio"]:checked').closest('.radio-card-item').addClass('active');
    $('.checkbox-card-item input[type="checkbox"]:checked').closest('.checkbox-card-item').addClass('active');

    // Toggle active classes on select-pill items and update the hidden select element
    $(document).on('click', '.select-pill-item', function() {
        let parent = $(this).closest('.select-pill-group');
        let selectId = parent.data('select-id');
        let value = $(this).data('value');

        parent.find('.select-pill-item').removeClass('active');
        $(this).addClass('active');

        let selectElement = $('#' + selectId);
        selectElement.val(value).trigger('change');
    });

    // Set initial active states for select pills on load
    $('.select-pill-group').each(function() {
        let selectId = $(this).data('select-id');
        let selectVal = $('#' + selectId).val();
        if (selectVal) {
            $(this).find(`.select-pill-item[data-value="${selectVal}"]`).addClass('active');
        }
    });

    $('.book-email-otp-input').on('input', function () {
        let input = $(this);
        let value = input.val();
        if (/^\d$/.test(value)) {
            input.next('.book-email-otp-input').focus();
        } else {
            input.val('');
        }
    });

    $('.book-email-otp-input').on('keydown', function (e) {
        let input = $(this);
        if (e.key === "Backspace" && input.val() === '') {
            input.prev('.book-email-otp-input').focus();
        }
    });

    $('.book-email-otp-input').on('paste', function (e) {
        let data = e.originalEvent.clipboardData.getData('text');
        let digits = data.replace(/\D/g, '').substring(0, 6).split('');
        $('.book-email-otp-input').each(function (index, element) {
            $(element).val(digits[index] || '');
        });
        if (digits.length > 0) {
            $('.book-email-otp-input').eq(digits.length - 1).focus();
        }
        e.preventDefault();
    });
});

document.addEventListener('DOMContentLoaded', function () {
  const otpModal = document.getElementById('exampleModalLong');

  otpModal.addEventListener('shown.bs.modal', function () {
    // Reset to step 1
    document.getElementById('booknow-step-phone').style.display = 'block';
    document.getElementById('book-email-step-phone').style.display = 'block';
    document.getElementById('booknow-step-otp').style.display = 'none';
    document.getElementById('booknow-step-details').style.display = 'none';
    document.getElementById('booknow-email-step-otp').style.display = 'none';
    document.getElementById('booknow-email-step-details').style.display = 'none';

    // Reset input fields
    document.getElementById('user-phone-number').value = '';
    document.getElementById('booknow_user_name').value = '';
    document.getElementById('booknow_user_email').value = '';
    document.getElementById('booknow_user_area').value = '';
    document.getElementById('book_email_email').value = '';
    document.getElementById('book_email_name').value = '';
    document.getElementById('book_email_mobile').value = '';
    //document.getElementById('book_email_area').value = '';
    document.querySelectorAll('.booknow-otp-input').forEach(input => input.value = '');
    document.querySelectorAll('.book-email-otp-input').forEach(input => input.value = '');

    // Hide errors
    document.getElementById('booknow_otp_phone_error').style.display = 'none';
    document.getElementById('booknow_otp_error').style.display = 'none';
    document.getElementById('booknow_name_error').style.display = 'none';
    document.getElementById('booknow_email_error').style.display = 'none';
    document.getElementById('booknow_area_error').style.display = 'none';
    document.getElementById('book_email_email_error').style.display = 'none';
    document.getElementById('book_email_otp_error').style.display = 'none';
    document.getElementById('book_email_name_error').style.display = 'none';
    document.getElementById('book_email_mobile_error').style.display = 'none';
    //document.getElementById('book_email_area_error').style.display = 'none';

    // Reset spinner buttons and enable primary buttons
    ['1', '2', '3'].forEach(step => {
      document.getElementById(`spinner_button_phone_book${step}`).style.display = 'none';
      document.getElementById(`submit_button_phone_book${step}`).style.display = 'inline-block';
    });
    ['1', '2', '3'].forEach(step => {
      document.getElementById(`spinner_button_email_book${step}`).style.display = 'none';
      document.getElementById(`submit_button_email_book${step}`).style.display = 'inline-block';
    });
  });
});
</script>


<script>
    function get_hide_show(id)

    {
        if (id == 1) {

            $(".tab1").css("display", "block");
            $(".tab2").css("display", "none");
        }

        if (id == 2) {
            var name_new = $('#name_new').val().trim();
            if (name_new == '') {
                $('#name_new_error').html("Please Enter Full Name");
                $('#name_new_error').show().delay(0).fadeIn('show');
                $('#name_new_error').show().delay(2000).fadeOut('show');
                return false;
            }

            var mobile_new = $('#mobile_new').val().trim();
            if (mobile_new == '') {
                $('#mobile_new_error').html("Please Enter Phone");
                $('#mobile_new_error').show().delay(0).fadeIn('show');
                $('#mobile_new_error').show().delay(2000).fadeOut('show');
                return false;
            }

            var email_new = jQuery("#email_new").val().trim();
            if (email_new == '') {
                jQuery('#email_new_error').html("Please Enter Email Id");
                jQuery('#email_new_error').show().delay(0).fadeIn('show');
                jQuery('#email_new_error').show().delay(2000).fadeOut('show');
                return false;
            }

            var filter1 = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!filter1.test(email_new)) {
                jQuery('#email_new_error').html("Please Enter Valid Email Id");
                jQuery('#email_new_error').show().delay(0).fadeIn('show');
                jQuery('#email_new_error').show().delay(2000).fadeOut('show');
                return false;
            }

            // Copy values to review screen
            $('#review_name_val').text(name_new);
            $('#review_phone_val').text(mobile_new);
            $('#review_email_val').text(email_new);

            $(".tab1").css("display", "none");
            $(".tab2").css("display", "block");
        }

        if (id == 3) {
            var name_new = $('#name_new').val();
            var mobile_new = $('#mobile_new').val();
            var email_new = jQuery("#email_new").val();
            var service_id = jQuery("#service_id").val();
            var subservice_id = jQuery("#subservice_id").val();

            $('#spinner_button_final').show();
            $('#submit_button_final').hide();

            var url = '{{ url('package_inquiry_new') }}';

            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "email_new": email_new,
                    "name_new": name_new,
                    "mobile_new": mobile_new,
                    "service_id": service_id,
                    "subservice_id": subservice_id,
                },
                success: function(msg) {
                    var response_ajax = JSON.parse(msg);

                    if (response_ajax.status === "success") {
                        $('#service_name_ajax').html(response_ajax.subservicename);
                        $('#order_id_ajax').html(response_ajax.order_id);
                        $('#user_name_ajax').html(response_ajax.username);

                        $(".tab1").css("display", "none");
                        $(".tab2").css("display", "none");
                        $("#head_hide").css("display", "none");
                        $(".tab3").css("display", "block");

                        // Update Stepper to completed state
                        $('#step1_indicator').removeClass('active').addClass('completed').find('.step-circle-new').html('<i class="fa-solid fa-check"></i>');
                        $('#step_line_1').addClass('completed');
                        $('#step2_indicator').removeClass('active').addClass('completed').find('.step-circle-new').html('<i class="fa-solid fa-check"></i>');
                        $('#step_line_2').addClass('completed');
                        $('#step3_indicator').addClass('completed').addClass('active').find('.step-circle-new').html('<i class="fa-solid fa-check"></i>');

                        // Hide right sidebar on final success screen
                        $(".enquiry-right-column").css("display", "none");
                        $(".enquiry-layout-grid").css("grid-template-columns", "1fr");
                    }
                }
            });
        }
    }

    function category_validation() {
        var isLocal = $('input[name="localorint"]:checked').val();

        if (isLocal === "loc") {
            // alert("local");
            validateLocalForm();
        } else if (isLocal === "int") {
            // alert("intr");
            validateInternationalForm();
        }
    }

    function validateLocalForm() {
        // Validate local form fields
        // var localFormValid = true;
        // alert(localFormValid);

        //alert('Local form validation not implemented yet.');

        
        // var name_new = jQuery("#name_new").val();
        // if (name_new == '') {

        //     jQuery('#name_new_error').html("Please Enter Name");
        //     jQuery('#name_new_error').show().delay(0).fadeIn('show');
        //     jQuery('#name_new_error').show().delay(2000).fadeOut('show');
        //     $('html, body').animate({
        //         scrollTop: $('#name_new').offset().top - 150
        //     }, 1000);
        //     return false;

        // }
        // var mobile_new = jQuery("#mobile_new").val();
        // if (mobile_new == '') {


        //     jQuery('#mobile_new_error').show().delay(0).fadeIn('show');
        //     jQuery('#mobile_new_error').show().delay(2000).fadeOut('show');
        //     $('html, body').animate({
        //         scrollTop: $('#mobile_new').offset().top - 150
        //     }, 1000);
        //     return false;

        // }
        // if (mobile_new != '') {
        //     // var filter = /^\d{7}$/;
        //     if (mobile_new.length < 7 || mobile_new.length > 15) {
        //         jQuery('#mobile_new_error').html("Please Enter Valid Mobile Number");
        //         jQuery('#mobile_new_error').show().delay(0).fadeIn('show');
        //         jQuery('#mobile_new_error').show().delay(2000).fadeOut('show');
        //         $('html, body').animate({
        //             scrollTop: $('#mobile_new').offset().top - 150
        //         }, 1000);
        //         return false;
        //     }
        // }


        // var email_new = jQuery("#email_new").val();

        // if (email_new == '') {
        //     jQuery('#email_new_error').html("Please Enter Email");
        //     jQuery('#email_new_error').show().delay(0).fadeIn('show');
        //     jQuery('#email_new_error').show().delay(2000).fadeOut('show');
        //     $('html, body').animate({
        //         scrollTop: $('#email_new').offset().top - 150
        //     }, 1000);
        //     return false;
        // }



        // var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        // if (!filter.test(email_new)) {

        //     jQuery('#email_new_error').html("Please Enter Valid Email");
        //     jQuery('#email_new_error').show().delay(0).fadeIn('show');
        //     jQuery('#email_new_error').show().delay(2000).fadeOut('show');
        //     $('html, body').animate({
        //         scrollTop: $('#email_new').offset().top - 150
        //     }, 1000);
        //     return false;

        // }


        // Example: Validate a text field
        @for ($i = 0; $i < count($result1); $i++)
            @for ($k = 0; $k < count($formFields); $k++)
                @if ($result1[$i]->lable_name == $formFields[$k]->lable_name)
                    @if ($result1[$i]->type == '1' && $result1[$i]->is_active == '1')
                        // Define test within the scope
                        var test = jQuery("#formfield_value_{{ $formFields[$k]->id }}").val();
                        if (test == '') {
                            jQuery('#name_error_{{ $formFields[$k]->id }}').html(
                                "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#name_error_{{ $formFields[$k]->id }}').show().delay(0).fadeIn('show');
                            jQuery('#name_error_{{ $formFields[$k]->id }}').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_{{ $formFields[$k]->id }}').offset().top - 150
                            }, 1000);
                            return false;
                        }
                    @endif

                    @if ($result1[$i]->type == '2' && $result1[$i]->is_active == '1')
                        var drop_down = jQuery("#formfield_value_test{{ $formFields[$k]->id }}").val();
                        if (drop_down == '') {
                            jQuery('#drop_down_error_formfield_value_{{ $formFields[$k]->id }}').html(
                                "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#drop_down_error_formfield_value_{{ $formFields[$k]->id }}').show().delay(0)
                                .fadeIn('show');
                            jQuery('#drop_down_error_formfield_value_{{ $formFields[$k]->id }}').show().delay(2000)
                                .fadeOut('show');
                            
                            var targetScroll = jQuery('#formfield_value_test{{ $formFields[$k]->id }}');
                            if (!targetScroll.is(':visible')) {
                                var pillGroup = targetScroll.prev('.select-pill-group');
                                if (pillGroup.length > 0) {
                                    targetScroll = pillGroup;
                                }
                            }
                            var offset = targetScroll.offset();
                            var scrollTopVal = offset ? offset.top - 150 : 0;
                            $('html, body').animate({
                                scrollTop: scrollTopVal
                            }, 1000);
                            return false;
                        }
                    @endif
                    @if ($result1[$i]->type == '3' && $result1[$i]->is_active == '1')
                        var radioSelected = jQuery('input[name="formfield_radio_{{ $formFields[$k]->id }}"]:checked')
                            .val();

                        if (!radioSelected) {
                            jQuery('#radio_error').html("Please select {{ $formFields[$k]->lable_name }}");
                            jQuery('#radio_error').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_{{ $formFields[$k]->id }}').offset().top - 150
                            }, 1000);
                            return false;
                        }
                    @endif

                    // @if ($result1[$i]->type == '3' && $result1[$i]->is_active == '1')
                    //     var radio = jQuery("#formfield_value_{{ $formFields[$k]->id }}").val();
                    //     // alert(drop_down);
                    //     if (radio == '') {
                    //         jQuery('#radio_error').html("Please Enter {{ $formFields[$k]->lable_name }}");
                    //         jQuery('#radio_error').show().delay(0).fadeIn('show');
                    //         jQuery('#radio_error').show().delay(2000).fadeOut('show');
                    //         $('html, body').animate({
                    //             scrollTop: $('#formfield_value_{{ $formFields[$k]->id }}').offset().top - 150
                    //         }, 1000);
                    //         return false;
                    //     }
                    // @endif

                    @if ($result1[$i]->type == '4' && $result1[$i]->is_active == '1')
                        // var checkbox = jQuery("#formfield_value_checkbox{{ $formFields[$k]->id }}").val();
                        var checkboxes = document.querySelectorAll(
                            'input[name^="formfield_checkbox_{{ $formFields[$k]->id }}"]:checked');
                        // alert(checkbox);
                        if (checkboxes.length === 0) {
                            var errorMessage =
                                jQuery('#formfield_value_checkbox1{{ $formFields[$k]->id }}').html(
                                    "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#formfield_value_checkbox1{{ $formFields[$k]->id }}').show().delay(0).fadeIn(
                                'show');
                            jQuery('#formfield_value_checkbox1{{ $formFields[$k]->id }}').show().delay(2000).fadeOut(
                                'show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_checkbox1{{ $formFields[$k]->id }}').offset()
                                    .top - 150
                            }, 1000);
                            return false;
                        }
                    @endif
                    @if ($result1[$i]->type == '5' && $result1[$i]->is_active == '1')
                        var textarea = jQuery("#formfield_value_textarea{{ $formFields[$k]->id }}").val();
                        // alert(drop_down);
                        if (textarea == '') {
                            jQuery('#textarea_error').html("Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#textarea_error').show().delay(0).fadeIn('show');
                            jQuery('#textarea_error').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_textarea{{ $formFields[$k]->id }}').offset()
                                    .top - 150
                            }, 1000);
                            return false;
                        }
                    @endif
                    @if ($result1[$i]->type == '6' && $result1[$i]->is_active == '1')
                        var date = jQuery("#formfield_value_date{{ $formFields[$k]->id }}").val();
                        if (date == '') {
                            jQuery('#formfield_value_date12{{ $formFields[$k]->id }}').html(
                                "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#formfield_value_date12{{ $formFields[$k]->id }}').show().delay(0).fadeIn('show');
                            jQuery('#formfield_value_date12{{ $formFields[$k]->id }}').show().delay(2000).fadeOut(
                                'show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_date{{ $formFields[$k]->id }}').offset().top -
                                    150
                            }, 1000);
                            return false;
                        }
                    @endif
                    @if ($result1[$i]->type == '7' && $result1[$i]->is_active == '1')
                        var mul_drop_down = jQuery("#formfield_value_{{ $formFields[$k]->id }}").val();
                        if (mul_drop_down == '') {
                            jQuery('#mul_drop_error_{{ $formFields[$k]->id }}').html(
                                "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#mul_drop_error_{{ $formFields[$k]->id }}').show().delay(0).fadeIn('show');
                            jQuery('#mul_drop_error_{{ $formFields[$k]->id }}').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_{{ $formFields[$k]->id }}').offset().top - 150
                            }, 1000);
                            return false;
                        }
                    @endif
                    @if ($result1[$i]->type == '8' && $result1[$i]->is_active == '1')
                        var Image = jQuery("#formfield_value_Image{{ $formFields[$k]->id }}").val();

                        if (Image == '') {
                            jQuery('#file_error_{{ $formFields[$k]->id }}').html(
                                "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#file_error_{{ $formFields[$k]->id }}').show().delay(0).fadeIn('show');
                            jQuery('#file_error_{{ $formFields[$k]->id }}').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_Image{{ $formFields[$k]->id }}').offset().top -
                                    150
                            }, 1000);
                            return false;
                        }
                    @endif
                    @if ($result1[$i]->type == '9' && $result1[$i]->is_active == '1')
                        var Time = jQuery("#formfield_value_time{{ $formFields[$k]->id }}").val();

                        if (Time == '') {
                            jQuery('#formfield_value_time_one{{ $formFields[$k]->id }}').html(
                                "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#formfield_value_time_one{{ $formFields[$k]->id }}').show().delay(0).fadeIn(
                                'show');
                            jQuery('#formfield_value_time_one{{ $formFields[$k]->id }}').show().delay(2000).fadeOut(
                                'show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_time{{ $formFields[$k]->id }}').offset().top -
                                    150
                            }, 1000);
                            return false;
                        }
                    @endif
                @endif
            @endfor
        @endfor


           



        // if (!localFormValid) {
        //     return false;
        // }


        $('#spinner_button').show();

        $('#submit_button').hide();

        $('#category_form').submit();

        // Add more validation for other fields as needed

        // If local form is not valid, prevent form submission


        // Proceed with form submission if local form is valid
        // Your form submission code here
    }

    function validateInternationalForm() {

        var name_new = jQuery("#name_new").val();
        // if (name_new == '') {

        //     jQuery('#name_new_error').html("Please Enter Name");
        //     jQuery('#name_new_error').show().delay(0).fadeIn('show');
        //     jQuery('#name_new_error').show().delay(2000).fadeOut('show');
        //     $('html, body').animate({
        //         scrollTop: $('#name_new').offset().top - 150
        //     }, 1000);
        //     return false;

        // }
        var mobile_new = jQuery("#mobile_new").val();
        // if (mobile_new == '') {

        //     jQuery('#mobile_new_error').html("Please Enter Mobile");
        //     jQuery('#mobile_new_error').show().delay(0).fadeIn('show');
        //     jQuery('#mobile_new_error').show().delay(2000).fadeOut('show');
        //     $('html, body').animate({
        //         scrollTop: $('#mobile_new').offset().top - 150
        //     }, 1000);
        //     return false;

        // }
        // if (mobile_new != '') {
        //     // var filter = /^\d{7}$/;
        //     if (mobile_new.length < 7 || mobile_new.length > 15) {
        //         jQuery('#mobile_new_error').html("Please Enter Valid Mobile Number");
        //         jQuery('#mobile_new_error').show().delay(0).fadeIn('show');
        //         jQuery('#mobile_new_error').show().delay(2000).fadeOut('show');
        //         $('html, body').animate({
        //             scrollTop: $('#mobile_new').offset().top - 150
        //         }, 1000);
        //         return false;
        //     }
        // }


        var email_new = jQuery("#email_new").val();

        // if (email_new == '') {
        //     jQuery('#email_new_error').html("Please Enter Email");
        //     jQuery('#email_new_error').show().delay(0).fadeIn('show');
        //     jQuery('#email_new_error').show().delay(2000).fadeOut('show');
        //     $('html, body').animate({
        //         scrollTop: $('#email_new').offset().top - 150
        //     }, 1000);
        //     return false;
        // }



        // var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        // if (!filter.test(email_new)) {

        //     jQuery('#email_new_error').html("Please Enter Valid Email");
        //     jQuery('#email_new_error').show().delay(0).fadeIn('show');
        //     jQuery('#email_new_error').show().delay(2000).fadeOut('show');
        //     $('html, body').animate({
        //         scrollTop: $('#email_new').offset().top - 150
        //     }, 1000);
        //     return false;

        // }

        // var intFormValid = true;
        @for ($i = 0; $i < count($result2); $i++)
            @for ($k = 0; $k < count($formFields); $k++)
                @if ($result2[$i]->lable_name == $formFields[$k]->lable_name)
                    @if ($result2[$i]->type == '1' && $result2[$i]->is_active == '1')
                        // Define test within the scope
                        var test_two = jQuery("#formfield_value_123{{ $formFields[$k]->id }}").val();
                        if (test_two == '') {
                            jQuery('#name2_error_{{ $formFields[$k]->id }}').html(
                                "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#name2_error_{{ $formFields[$k]->id }}').show().delay(0).fadeIn('show');
                            jQuery('#name2_error_{{ $formFields[$k]->id }}').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_123{{ $formFields[$k]->id }}').offset().top -
                                    150
                            }, 1000);
                            return false;
                        }
                    @endif

                    @if ($result2[$i]->type == '2' && $result2[$i]->is_active == '1')
                        // Define drop_down_test within the scope
                        var drop_down_test = jQuery("#formfield_value_drop{{ $formFields[$k]->id }}").val();
                        if (drop_down_test == '') {
                            jQuery('#drop_down_error_formfield_value_drop{{ $formFields[$k]->id }}').html(
                                "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#drop_down_error_formfield_value_drop{{ $formFields[$k]->id }}').show().delay(0)
                                .fadeIn('show');
                            jQuery('#drop_down_error_formfield_value_drop{{ $formFields[$k]->id }}').show().delay(
                                    2000)
                                .fadeOut('show');
                            
                            var targetScroll2 = jQuery('#formfield_value_drop{{ $formFields[$k]->id }}');
                            if (!targetScroll2.is(':visible')) {
                                var pillGroup2 = targetScroll2.prev('.select-pill-group');
                                if (pillGroup2.length > 0) {
                                    targetScroll2 = pillGroup2;
                                }
                            }
                            var offset2 = targetScroll2.offset();
                            var scrollTopVal2 = offset2 ? offset2.top - 150 : 0;
                            $('html, body').animate({
                                scrollTop: scrollTopVal2
                            }, 1000);
                            return false;
                        }
                    @endif


                    @if ($result2[$i]->type == '3' && $result2[$i]->is_active == '1')
                        var radio2 = jQuery('input[name="formfield_radio_{{ $formFields[$k]->id }}"]:checked')
                            .val();

                        if (!radio2) {
                            jQuery('#formfield_value_red{{ $formFields[$k]->id }}').html(
                                "Please select {{ $formFields[$k]->lable_name }}");
                            jQuery('#formfield_value_red{{ $formFields[$k]->id }}').show().delay(2000).fadeOut(
                                'show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_red{{ $formFields[$k]->id }}').offset()
                                    .top -
                                    150
                            }, 1000);
                            return false;
                        }
                    @endif


                    @if ($result2[$i]->type == '4' && $result2[$i]->is_active == '1')
                        var checkboxes2 = document.querySelectorAll(
                            'input[name^="formfield_checkbox_{{ $formFields[$k]->id }}"]:checked');
                        if (checkboxes2.length === 0) {
                            var errorMessage =
                                jQuery('#formfield_value_c2{{ $formFields[$k]->id }}').html(
                                    "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#formfield_value_c2{{ $formFields[$k]->id }}').show().delay(0).fadeIn('show');
                            jQuery('#formfield_value_c2{{ $formFields[$k]->id }}').show().delay(2000).fadeOut(
                                'show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_c2{{ $formFields[$k]->id }}').offset()
                                    .top -
                                    150
                            }, 1000);
                            return false;
                        }
                    @endif
                    @if ($result2[$i]->type == '5' && $result2[$i]->is_active == '1')
                        var textareas = jQuery("#formfield_value{{ $formFields[$k]->id }}").val();
                        // alert(textareas);
                        if (textareas == '') {
                            jQuery('#formfield_value_01{{ $formFields[$k]->id }}').html(
                                "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#formfield_value_01{{ $formFields[$k]->id }}').show().delay(0).fadeIn('show');
                            jQuery('#formfield_value_01{{ $formFields[$k]->id }}').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value{{ $formFields[$k]->id }}').offset()
                                    .top - 150
                            }, 1000);
                            return false;
                        }
                    @endif
                    @if ($result2[$i]->type == '6' && $result2[$i]->is_active == '1')
                        var date_test = jQuery("#formfield_value{{ $formFields[$k]->id }}").val();
                        if (date_test == '') {
                            jQuery('#formfield_value_date_2{{ $formFields[$k]->id }}').html(
                                "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#formfield_value_date_2{{ $formFields[$k]->id }}').show().delay(0).fadeIn('show');
                            jQuery('#formfield_value_date_2{{ $formFields[$k]->id }}').show().delay(2000).fadeOut(
                                'show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value{{ $formFields[$k]->id }}').offset().top -
                                    150
                            }, 1000);
                            return false;
                        }
                    @endif

                    @if ($result2[$i]->type == '7' && $result2[$i]->is_active == '1')
                        var mul_drop_down = jQuery("#formfield_value_mul_test2{{ $formFields[$k]->id }}").val();
                        if (mul_drop_down == '') {
                            jQuery('#mul2_drop_error_{{ $formFields[$k]->id }}').html(
                                "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#mul2_drop_error_{{ $formFields[$k]->id }}').show().delay(0).fadeIn('show');
                            jQuery('#mul2_drop_error_{{ $formFields[$k]->id }}').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_mul_test2{{ $formFields[$k]->id }}').offset()
                                    .top -
                                    150
                            }, 1000);
                            return false;
                        }
                    @endif
                    @if ($result2[$i]->type == '8' && $result2[$i]->is_active == '1')
                        var Image_int = jQuery("#formfield_value_Image_two{{ $formFields[$k]->id }}").val();

                        if (Image_int == '') {
                            jQuery('#file_error_two_{{ $formFields[$k]->id }}').html(
                                "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#file_error_two_{{ $formFields[$k]->id }}').show().delay(0).fadeIn('show');
                            jQuery('#file_error_two_{{ $formFields[$k]->id }}').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_Image_two{{ $formFields[$k]->id }}').offset()
                                    .top -
                                    150
                            }, 1000);
                            return false;
                        }
                    @endif
                    @if ($result2[$i]->type == '9' && $result2[$i]->is_active == '1')
                        var time_sec = jQuery("#formfield_value_time_two{{ $formFields[$k]->id }}").val();

                        if (time_sec == '') {
                            jQuery('#formfield_value_time_sec{{ $formFields[$k]->id }}').html(
                                "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#formfield_value_time_sec{{ $formFields[$k]->id }}').show().delay(0).fadeIn(
                                'show');
                            jQuery('#formfield_value_time_sec{{ $formFields[$k]->id }}').show().delay(2000).fadeOut(
                                'show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_time_two{{ $formFields[$k]->id }}').offset()
                                    .top -
                                    150
                            }, 1000);
                            return false;
                        }
                    @endif
                @endif
            @endfor
        @endfor

        // if (!intFormValid) {
        //     return false;
        // }
        $('#spinner_button').show();

        $('#submit_button').hide();

        $('#category_form').submit();

        // Add more validation for other fields as needed

        // If international form is not valid, prevent form submission


        // Proceed with form submission if international form is valid
        // Your form submission code here
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

<script>
    $(".multiple").select2({
        placeholder: "Select a Form Fields" // Replace with your desired placeholder text
    });

    // $(".multiple").select2({
    //     placeholder: "Select a Form Fields" // Replace with your desired placeholder text
    // });

    function get_sub_select(val, form_id) {
        // alert(val);
        // alert(form_id);

        if(form_id == 42){

            if(val == 129){

                $('#hide_div_59').css('display','block');
                $('#hide_div_60').css('display','none');
                $('#hide_div_64').css('display','none');
                $('#hide_div_65').css('display','none');
                $('#hide_div_66').css('display','none');

                
            }

            if(val == 130){
                $('#hide_div_59').css('display','block');
                $('#hide_div_60').css('display','block');
                $('#hide_div_64').css('display','none');
                $('#hide_div_65').css('display','none');
                $('#hide_div_66').css('display','none');
            }

            if(val == 131){
                $('#hide_div_59').css('display','block');
                $('#hide_div_60').css('display','block');
                $('#hide_div_64').css('display','block');
                $('#hide_div_65').css('display','none');
                $('#hide_div_66').css('display','none');
            }

            if(val == 132){
               $('#hide_div_59').css('display','block');
                $('#hide_div_60').css('display','block');
                $('#hide_div_64').css('display','block');
                $('#hide_div_65').css('display','block');
                $('#hide_div_66').css('display','none');
            }

            if(val == 133){
                $('#hide_div_59').css('display','block');
                $('#hide_div_60').css('display','block');
                $('#hide_div_64').css('display','block');
                $('#hide_div_65').css('display','block');
                $('#hide_div_66').css('display','block');
            }

            if(val == 134 || val == ''){
                $('#hide_div_59').css('display','none');
                $('#hide_div_60').css('display','none');
                $('#hide_div_64').css('display','none');
                $('#hide_div_65').css('display','none');
                $('#hide_div_66').css('display','none');
            }



        }else{

            var url = '{{ url('change_drop_down') }}';

            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "form_inner_id": val,
                    "form_id": form_id
                },
                success: function(msg) {
                    document.getElementById('replace_select_' + form_id).innerHTML = msg;
                    transformDynamicSelectToPills('replace_select_' + form_id);
                    $(".multiple").select2({
                        placeholder: "Select a Form Fields" // Replace with your desired placeholder text
                    });
                }
            });

        }

        
    }

    function transformDynamicSelectToPills(containerId) {
        let container = $('#' + containerId);
        let select = container.find('select');
        if (select.length === 0) return;

        let label = container.find('label').text().trim();
        let pill_labels = ['Move Type', 'What is the size of your move?', 'What is the size of your home?', 'What is the size of your garden?', 'Type of Paint?'];
        
        let is_pill = false;
        pill_labels.forEach(l => {
            if (label.toLowerCase().includes(l.toLowerCase())) {
                is_pill = true;
            }
        });

        if (is_pill) {
            select.hide();
            let selectId = select.attr('id');
            let pillsHtml = `<div class="radio-card-group select-pill-group" data-select-id="${selectId}">`;
            
            select.find('option').each(function() {
                let optVal = $(this).val();
                let optText = $(this).text().trim();
                if (optVal !== '') {
                    let activeClass = select.val() === optVal ? 'active' : '';
                    pillsHtml += `
                        <div class="radio-card-item select-pill-item ${activeClass}" data-value="${optVal}">
                            <span class="radio-card-label">${optText}</span>
                        </div>`;
                }
            });
            pillsHtml += '</div>';
            
            select.before(pillsHtml);
        }
    }


    window.onload = custom_function;

    function custom_function() { 

        $('#hide_div_59').css('display','none');
        $('#hide_div_60').css('display','none');


        $('#hide_div_64').css('display','none');
        $('#hide_div_65').css('display','none');

        $('#hide_div_66').css('display','none');


     }


    function get_sub_select_two(val, form_id) {
        // alert(val);
        // alert(form_id);

        var url = '{{ url('change_drop_down_two') }}';

        $.ajax({
            url: url,
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "form_inner_id": val,
                "form_id": form_id
            },
            success: function(msg) {
                document.getElementById('replace_select_two' + form_id).innerHTML = msg;
                transformDynamicSelectToPills('replace_select_two' + form_id);
            }
        });
    }

    @for ($i = 0; $i < count($result1); $i++)
            @for ($k = 0; $k < count($formFields); $k++)

            @if ($result1[$i]->id == '21' && $result1[$i]->type == '6' && $result1[$i]->is_active == '1')

            document.addEventListener('DOMContentLoaded', () => {
            const dateInput = document.getElementById('formfield_value_date{{ $formFields[$k]->id }}');
            if (dateInput) {
                // Get tomorrow's date
                const today = new Date();
                const tomorrow = new Date(today);
                tomorrow.setDate(tomorrow.getDate() + 1);
                
                // Format the date to yyyy-mm-dd
                const yyyy = tomorrow.getFullYear();
                const mm = String(tomorrow.getMonth() + 1).padStart(2, '0'); // Months are zero-based
                const dd = String(tomorrow.getDate()).padStart(2, '0');
                const minDate = `${yyyy}-${mm}-${dd}`;
                
                // Set the min attribute
                dateInput.setAttribute('min', minDate);
            }
        });
            // document.addEventListener('DOMContentLoaded', (event) => {

                
            //     const dateInput = document.getElementById('formfield_value_date{{ $formFields[$k]->id }}');
            //     const form = document.getElementById('category_form');

            //     // Get today's date
            //     const today = new Date();
            //     // Set tomorrow's date
            //     const tomorrow = new Date(today);
            //     tomorrow.setDate(tomorrow.getDate() + 1);

            //     // Format the dates as yyyy-mm-dd
            //     const formatDate = (date) => {
            //         const yyyy = date.getFullYear();
            //         const mm = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
            //         const dd = String(date.getDate()).padStart(2, '0');
            //         return `${yyyy}-${mm}-${dd}`;
            //     };

            //     const todayStr = formatDate(today);
            //     const tomorrowStr = formatDate(tomorrow);

            //     // Set the min and max attributes of the date input to restrict to today and tomorrow
            //     dateInput.setAttribute('min', todayStr);
            //     dateInput.setAttribute('max', tomorrowStr);

            //     // Additional validation on form submission
            //     form.addEventListener('submit', (event) => {
            //         const selectedDate = new Date(dateInput.value);
            //         if (selectedDate < today || selectedDate > tomorrow) {
            //             alert('Please select a date either today or tomorrow.');
            //             event.preventDefault(); // Prevent form submission
            //         }
            //     });
            // });


            @endif
            
            @endfor
    @endfor
</script>
@php
    $packageEnquiryFormId = session('packages_enquiry_form_id');
    if (isset($packageEnquiryFormId)) {
@endphp
        <script>
            // Function will be called on page load
            window.onload = function() {

                // alert('here');
                get_hide_show(2);
            };
        </script>
@php
    }
@endphp 

{{-- @if (isset($formFields[$k]) && isset($formFields[$k]->id))
    <script>
        $("#formfield_value_{{ $formFields[$k]->id }}").select2({
            placeholder: "Select "
            // Add any other Select2 options you need
        });
    </script>
@endif --}}

{{-- @if (isset($formFields) && is_array($formFields))
    @foreach ($formFields as $k => $formField)
        @if (isset($formField->id))
            <script>
                $("#formfield_value_{{ $formField->id }}").select2({
                    placeholder: "Select {{ $formFields[$k]->lable_name }}"
                    // Add any other Select2 options you need
                });
            </script>
        @endif
    @endforeach
@endif --}}
