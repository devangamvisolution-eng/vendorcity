@include('front.includes.header')
<section class="our-register">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto wow fadeInUp" data-wow-delay="300ms">
                <div class="main-title text-center">
                    <h2 class="title">ENQUIRY</h2>
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

        <form id="category_form" action="{{ route('package_inquiry') }}" method="POST"
            style="display: {{ $display_oldform }};">
            @csrf
            <div class="row wow fadeInRight" data-wow-delay="300ms">
                <div class="col-xl-6 mx-auto">
                    <div class="log-reg-form search-modal form-style1 bgc-white p50 p30-sm default-box-shadow1 bdrs12">
                        {{-- @if ($package_id != '')
                            <input name="pakage_id" type="hidden" class="form-control" value="{{ $package_id }}">
                        @endif --}}

                        <input name="service_id" type="hidden" class="form-control" value="{{ $service_id }}">
                        {{-- <input name="subservice_id" type="hidden" class="form-control" value="{{ $subservice_id }}">
                        <input name="packagecategory_id" type="hidden" class="form-control"
                            value="{{ $packagecategory_id }}"> --}}



                        <div <?php if(count($result2) == 0) { ?> style="display:none;" <?php } ?>>
                            <input id="localorintLocal" name="localorint" type="radio" value="loc"
                                checked='checked' onclick="hideshow('local');">
                            <label class="form-label fw500 dark-color">Local</label>

                            <input id="localorintInt" name="localorint" value="int" type="radio"
                                onclick="hideshow('int');">
                            <label class="form-label fw500 dark-color">International</label>
                        </div>
                        <script>
                            function hideshow(val) {
                                if (val == 'local') {
                                    $("#localform").show();
                                    $("#intform").hide();
                                } else {
                                    $("#localform").hide();
                                    $("#intform").show();
                                }
                            }
                        </script>
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
                                        // print_r($result1);
                                        // echo '</pre>';
                                        // exit();
                                    @endphp
                                    @if ($result1[$i]->lable_name == $formFields[$k]->lable_name)
                                        @if ($result1[$i]->type == '1')
                                            <div class="mb15">
                                                <label
                                                    class="form-label fw500 dark-color">{{ $formFields[$k]->lable_name }}</label>
                                                <input name="form_field_id[]" type="hidden" class="m-0"
                                                    id="form_field_id[]" value=" {{ $formFields[$k]->id }}">
                                                <input name="formfield_value[]" type="text"
                                                    class="form-control {{ $formFields[$k]->id }}"
                                                    id="formfield_value_{{ $formFields[$k]->id }}"
                                                    placeholder="{{ $formFields[$k]->lable_name }}">
                                            </div>
                                            <p class="form-error-text" id="name_error"
                                                style="color: red; margin-top: 10px;">
                                            </p>
                                        @endif
                                        @if ($result1[$i]->type == '2' && $result1[$i]->lable_name != 'Do you require any additional service?')
                                            <div class="form-group mb-3">
                                                <label class="form-label fw500 dark-color"
                                                    for="country">{{ $formFields[$k]->lable_name }}</label>
                                                <input name="form_field_id[]" type="hidden" class="m-0"
                                                    id="form_field_id[]" value="{{ $formFields[$k]->id }}">
                                                <select class="form-control"
                                                    id="formfield_value_test{{ $formFields[$k]->id }}"
                                                    name="formfield_value[]">
                                                    <option value="">Select {{ $formFields[$k]->lable_name }}
                                                    </option>
                                                    @foreach ($form_additionalData as $form_additional)
                                                        <option value="{{ $form_additional->form_option }}">
                                                            {{ $form_additional->form_option }}</option>
                                                    @endforeach
                                                </select>
                                                <p class="form-error-text"
                                                    id="drop_down_error_formfield_value_{{ $formFields[$k]->id }}"
                                                    style="color: red; margin-top: 10px;">
                                                </p>
                                            </div>
                                        @endif
                                        @if ($result1[$i]->type == '3')
                                            <label
                                                class="form-label fw500 dark-color">{{ $formFields[$k]->lable_name }}</label>

                                            <input name="form_field_radio_id[]" type="hidden" class="m-0"
                                                id="form_field_id[]" value="{{ $formFields[$k]->id }}">

                                            @foreach ($form_additionalData as $form_additional)
                                                <input name="formfield_radio_{{ $formFields[$k]->id }}" type="radio"
                                                    class="m-0" id="formfield_value_{{ $formFields[$k]->id }}"
                                                    placeholder="" value="{{ $form_additional->form_option }}">
                                                <label></label>
                                                <label>{{ $form_additional->form_option }}</label>
                                            @endforeach
                                            <p class="form-error-text" id="radio_error"
                                                style="color: red; margin-top: 10px;">
                                            </p>
                                        @endif

                                        @if ($result1[$i]->type == '4')
                                            <br>
                                            <input name="form_field_checkbox_id[]" type="hidden" class="m-0"
                                                id="form_field_id[]" value="{{ $formFields[$k]->id }}">
                                            <label
                                                class="form-label fw500 dark-color">{{ $formFields[$k]->lable_name }}</label>
                                            @foreach ($form_additionalData as $form_additional)
                                                <input name="formfield_checkbox_{{ $formFields[$k]->id }}[]"
                                                    type="checkbox" class="m-0"
                                                    id="formfield_value_checkbox{{ $formFields[$k]->id }}"
                                                    placeholder="" value="{{ $form_additional->form_option }}">

                                                <label>{{ $form_additional->form_option }}</label>
                                            @endforeach
                                            <p class="form-error-text"
                                                id="formfield_value_checkbox1{{ $formFields[$k]->id }}"
                                                style="color: red; margin-top: 10px;">
                                            </p>
                                        @endif
                                        @if ($result1[$i]->type == '5')
                                            <input name="form_field_id[]" type="hidden" class="m-0"
                                                id="form_field_id[]" value="{{ $formFields[$k]->id }}">
                                            <label
                                                class="form-label fw500 dark-color">{{ $formFields[$k]->lable_name }}</label>
                                            <textarea name="formfield_value[]" id="formfield_value_textarea{{ $formFields[$k]->id }}"
                                                placeholder="{{ $formFields[$k]->lable_name }}"></textarea>

                                            <p class="form-error-text" id="textarea_error"
                                                style="color: red; margin-top: 10px;">
                                            </p>
                                        @endif
                                        @if ($result1[$i]->type == '6')
                                            <div class="mb15">
                                                <label
                                                    class="form-label fw500 dark-color">{{ $formFields[$k]->lable_name }}</label>
                                                <input name="form_field_id[]" type="hidden" class="m-0"
                                                    id="form_field_id[]" value=" {{ $formFields[$k]->id }}">
                                                <input name="formfield_value[]" type="date" class="form-control"
                                                    id="formfield_value_date{{ $formFields[$k]->id }}"
                                                    placeholder="{{ $formFields[$k]->lable_name }}" class="">
                                            </div>
                                            <p class="form-error-text"
                                                id="formfield_value_date12{{ $formFields[$k]->id }}"
                                                style="color: red; margin-top: 10px;">
                                            </p>
                                        @endif

                                        @if ($result1[$i]->type == '2' && $result1[$i]->lable_name == 'Do you require any additional service?')
                                            <div class="form-group mb-3">
                                                <label class="form-label fw500 dark-color"
                                                    for="country">{{ $formFields[$k]->lable_name }}</label>


                                                {{-- <input name="form_field_mul_dropdown_id[]" type="hidden"
                                                    class="m-0" id="form_field_id[]"
                                                    value="{{ $formFields[$k]->id }}"> --}}
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
                                            <p class="form-error-text" id="mul_drop_error"
                                                style="color: red; margin-top: 10px;">
                                            </p>
                                        @endif
                                        @if ($result1[$i]->type == '7')
                                            <div class="mb15">
                                                <label
                                                    class="form-label fw500 dark-color">{{ $formFields[$k]->lable_name }}</label>
                                                <input name="form_field_id[]" type="hidden" class="m-0"
                                                    id="form_field_id[]" value=" {{ $formFields[$k]->id }}">
                                                <input name="formfield_value[]" type="text" class="form-control"
                                                    id="formfield_value_{{ $formFields[$k]->id }}"
                                                    placeholder="{{ $formFields[$k]->lable_name }}" class="">
                                            </div>
                                            <p class="form-error-text" id="text_error"
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
                                        // print_r($result2);
                                        // echo '</pre>';
                                        // exit();
                                    @endphp
                                    @if ($result2[$i]->lable_name == $formFields[$k]->lable_name)
                                        @if ($result2[$i]->type == '1')
                                            <div class="mb15">
                                                <label
                                                    class="form-label fw500 dark-color">{{ $formFields[$k]->lable_name }}</label>
                                                <input name="form_field_id[]" type="hidden" class="m-0"
                                                    id="form_field_id[]" value=" {{ $formFields[$k]->id }}">
                                                <input name="formfield_value[]" type="text" class="form-control"
                                                    id="formfield_value_123{{ $formFields[$k]->id }}"
                                                    placeholder="{{ $formFields[$k]->lable_name }}" class="">

                                                <p class="form-error-text" id="name2_error"
                                                    style="color: red; margin-top: 10px;">
                                                </p>
                                            </div>
                                        @endif
                                        @if ($result2[$i]->type == '2' && $result2[$i]->lable_name != 'Do you require any additional service?')
                                            <div class="form-group mb-3">
                                                <label class="form-label fw500 dark-color"
                                                    for="country">{{ $formFields[$k]->lable_name }}</label>
                                                <input name="form_field_id[]" type="hidden" class="m-0"
                                                    id="form_field_id[]" value="{{ $formFields[$k]->id }}">
                                                <select class="form-control"
                                                    id="formfield_value_2{{ $formFields[$k]->id }}"
                                                    name="formfield_value[]">
                                                    <option value="">Select {{ $formFields[$k]->lable_name }}
                                                    </option>
                                                    @foreach ($form_additionalData as $form_additional)
                                                        <option value="{{ $form_additional->form_option }}">
                                                            {{ $form_additional->form_option }}</option>
                                                    @endforeach
                                                </select>
                                                <p class="form-error-text"
                                                    id="drop_down_error_formfield_value_2{{ $formFields[$k]->id }}"
                                                    style="color: red; margin-top: 10px;">
                                                </p>
                                            </div>
                                        @endif
                                        {{-- @if ($result2[$i]->type == '3')
                                            <label
                                                class="form-label fw500 dark-color">{{ $formFields[$k]->lable_name }}</label>

                                            <input name="form_field_radio_id[]" type="hidden" class="m-0"
                                                id="form_field_id[]" value="{{ $formFields[$k]->id }}">

                                            @foreach ($form_additionalData as $form_additional)
                                                <input name="formfield_radio_{{ $formFields[$k]->id }}"
                                                    type="radio" class="m-0"
                                                    id="formfield_value_radio12{{ $formFields[$k]->id }}"
                                                    placeholder="" value="{{ $form_additional->form_option }}">
                                                <label></label>
                                                <label>{{ $form_additional->form_option }}</label>
                                            @endforeach
                                            <p class="form-error-text"
                                                id="formfield_value_radio123{{ $formFields[$k]->id }}"
                                                style="color: red; margin-top: 10px;">
                                            </p>
                                        @endif --}}
                                        @if ($result2[$i]->type == '3')
                                            <label
                                                class="form-label fw500 dark-color">{{ $formFields[$k]->lable_name }}</label>

                                            <input name="form_field_radio_id[]" type="hidden" class="m-0"
                                                id="form_field_id[]" value="{{ $formFields[$k]->id }}">

                                            @foreach ($form_additionalData as $form_additional)
                                                <input name="formfield_radio_{{ $formFields[$k]->id }}"
                                                    type="radio" class="m-0"
                                                    id="formfield_value_{{ $formFields[$k]->id }}" placeholder=""
                                                    value="{{ $form_additional->form_option }}">
                                                <label></label>
                                                <label>{{ $form_additional->form_option }}</label>
                                            @endforeach
                                            <p class="form-error-text"
                                                id="formfield_value_red{{ $formFields[$k]->id }}"
                                                style="color: red; margin-top: 10px;">
                                            </p>
                                        @endif

                                        @if ($result2[$i]->type == '4')
                                            <br>
                                            <input name="form_field_checkbox_id[]" type="hidden" class="m-0"
                                                id="form_field_id[]" value="{{ $formFields[$k]->id }}">
                                            <label
                                                class="form-label fw500 dark-color">{{ $formFields[$k]->lable_name }}</label>
                                            @foreach ($form_additionalData as $form_additional)
                                                <input name="formfield_checkbox_{{ $formFields[$k]->id }}[]"
                                                    type="checkbox" class="m-0" id="formfield_value[]"
                                                    placeholder="" value="{{ $form_additional->form_option }}"
                                                    id="formfield_value_{{ $formFields[$k]->id }}">

                                                <label>{{ $form_additional->form_option }}</label>
                                            @endforeach
                                            <p class="form-error-text"
                                                id="formfield_value_c2{{ $formFields[$k]->id }}"
                                                style="color: red; margin-top: 10px;">
                                            </p>
                                        @endif
                                        {{-- @if ($result2[$i]->type == '5')
                                            <input name="form_field_id[]" type="hidden" class="m-0"
                                                id="form_field_id[]" value="{{ $formFields[$k]->id }}">
                                            <label
                                                class="form-label fw500 dark-color">{{ $formFields[$k]->lable_name }}</label>
                                            <textarea name="formfield_value[]" type="checkbox" class="m-0"
                                                id="formfield_value_textarea{{ $formFields[$k]->id }}" placeholder="{{ $formFields[$k]->lable_name }}"
                                                value=""></textarea>
                                            <label></label>&nbsp;
                                            <p class="form-error-text" id="textarea2_error"
                                                style="color: red; margin-top: 10px;">
                                            </p>
                                        @endif --}}
                                        @if ($result2[$i]->type == '5')
                                            <input name="form_field_id[]" type="hidden" class="m-0"
                                                id="form_field_id[]" value="{{ $formFields[$k]->id }}">
                                            <label
                                                class="form-label fw500 dark-color">{{ $formFields[$k]->lable_name }}</label>
                                            <textarea name="formfield_value[]" id="formfield_value{{ $formFields[$k]->id }}"
                                                placeholder="{{ $formFields[$k]->lable_name }}"></textarea>

                                            <p class="form-error-text"
                                                id="formfield_value_01{{ $formFields[$k]->id }}"
                                                style="color: red; margin-top: 10px;">
                                            </p>
                                        @endif

                                        {{-- @if ($result2[$i]->type == '6')
                                            <div class="mb15">
                                                <label
                                                    class="form-label fw500 dark-color">{{ $formFields[$k]->lable_name }}</label>
                                                <input name="form_field_id[]" type="hidden" class="m-0"
                                                    id="form_field_id[]" value=" {{ $formFields[$k]->id }}">
                                                <input name="formfield_value[]" type="date" class="form-control"
                                                    id="formfield_value_date{{ $formFields[$k]->id }}"
                                                    placeholder="{{ $formFields[$k]->lable_name }}" class="">
                                            </div>
                                            <p class="form-error-text"
                                                id="formfield_value_date_test{{ $formFields[$k]->id }}"
                                                style="color: red; margin-top: 10px;">
                                            </p>
                                        @endif --}}
                                        @if ($result2[$i]->type == '6')
                                            <div class="mb15">
                                                <label
                                                    class="form-label fw500 dark-color">{{ $formFields[$k]->lable_name }}</label>
                                                <input name="form_field_id[]" type="hidden" class="m-0"
                                                    id="form_field_id[]" value=" {{ $formFields[$k]->id }}">
                                                <input name="formfield_value[]" type="date" class="form-control"
                                                    id="formfield_value{{ $formFields[$k]->id }}"
                                                    placeholder="{{ $formFields[$k]->lable_name }}" class="">
                                            </div>
                                            <p class="form-error-text"
                                                id="formfield_value_date_2{{ $formFields[$k]->id }}"
                                                style="color: red; margin-top: 10px;">
                                            </p>
                                        @endif

                                        @if ($result2[$i]->type == '2' && $result2[$i]->lable_name == 'Do you require any additional service?')
                                            <div class="form-group mb-3">
                                                <label class="form-label fw500 dark-color"
                                                    for="country">{{ $formFields[$k]->lable_name }}</label>
                                                <input name="form_field_mul_dropdown_id[]" type="hidden"
                                                    class="m-0" id="form_field_id[]"
                                                    value="{{ $formFields[$k]->id }}">
                                                <select class="form-control multiple"
                                                    id="formfield_value_mul{{ $formFields[$k]->id }}"
                                                    name="formfield_mul_dropdown_{{ $formFields[$k]->id }}[]"
                                                    multiple="multiple">
                                                    <option value="">Select {{ $formFields[$k]->lable_name }}
                                                    </option>
                                                    @foreach ($form_additionalData as $form_additional)
                                                        <option value="{{ $form_additional->form_option }}">
                                                            {{ $form_additional->form_option }}</option>
                                                    @endforeach
                                                </select>
                                                <p class="form-error-text" id="mul2_drop_error"
                                                    style="color: red; margin-top: 10px;">
                                                </p>
                                            </div>
                                        @endif
                                        @if ($result2[$i]->type == '7')
                                            <div class="mb15">
                                                <label
                                                    class="form-label fw500 dark-color">{{ $formFields[$k]->lable_name }}</label>
                                                <input name="form_field_id[]" type="hidden" class="m-0"
                                                    id="form_field_id[]" value=" {{ $formFields[$k]->id }}">
                                                <input name="formfield_value[]" type="text" class="form-control"
                                                    id="formfield_value_text{{ $formFields[$k]->id }}"
                                                    placeholder="{{ $formFields[$k]->lable_name }}" class="">
                                            </div>
                                            <p class="form-error-text" id="text2_error"
                                                style="color: red; margin-top: 10px;">
                                            </p>
                                        @endif
                                    @endif
                                @endfor
                            @endfor
                        </div>

                        <div class="d-grid mb20">
                            <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                style="display: none;">

                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>

                                Loading...

                            </button>
                            <button type="button" class="ud-btn btn-thm default-box-shadow2"
                                onclick="javascript:category_validation()" id="submit_button">Submit</button>

                          <!--   <div class="or-seperator"><i>or</i></div>
                            <p class="text-center">Login with your social media account</p>
                            <div class="text-center social-btn">
                                <a href="#" class="btn btn-secondary"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
                                <a href="#" class="btn btn-info"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
                                <a href="#" class="btn btn-danger"><i class="fa fa-google"></i>&nbsp; Google</a>
                            </div>
 -->

                        </div>

                    </div>
                </div>
            </div>
        </form>


        <form id="category_form_new" action="{{ route('package_inquiry_new') }}" method="POST"
            style="display: {{ $display_newform }};">
            @csrf

            <div class="row wow fadeInRight" data-wow-delay="300ms">
                <div class="col-xl-6 mx-auto">
                    <div class="log-reg-form search-modal form-style1 bgc-white p50 p30-sm default-box-shadow1 bdrs12">

                        <div class="tab1">

                            @php

                                $userdata = Session::get('user');

                                if (isset($userdata)) {
                                    $name = $userdata['name'];
                                    $mobile = $userdata['mobile'];
                                    $email = $userdata['email'];
                                } else {
                                    $name = '';
                                    $mobile = '';
                                    $email = '';
                                }

                            @endphp

                            <div class="mb25">
                                <label class="form-label fw500 dark-color">Full Name:</label>
                                <input id="name_new" name="name_new" type="text" class="form-control"
                                    placeholder="Enter Full Name:" value="{{ $name }}">

                                <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;">
                                </p>
                            </div>
                            <div class="mb15">
                                <label class="form-label fw500 dark-color">Phone Number:</label>
                                <input id="mobile_new" name="mobile_new" type="number" class="form-control"
                                    placeholder="Enter Phone Number:" onkeypress="return validateNumber(event)"
                                    value="{{ $mobile }}">
                                <p class="form-error-text" id="mobile_error" style="color: red; margin-top: 10px;">
                                </p>
                            </div>

                            <div class="mb25">
                                <label class="form-label fw500 dark-color">Email ID:</label>
                                <input id="email_new" name="email_new" type="text" class="form-control"
                                    placeholder="Enter Email ID:" value="{{ $email }}">
                                <p class="form-error-text" id="email_error" style="color: red; margin-top: 10px;">
                                </p>
                            </div>

                            <span id="tab1_error" class="error alert-message valierror" style="display:none;"></span>

                            <button type="button" class="ud-btn btn-thm default-box-shadow2" id="nextBtn12"
                                onclick="get_hide_show(2);">Save</button>
                        </div>

                        <div class="tab2" style="display:none">

                            <div class="col-12">
                                <h5 class="card-title mb-md-4">Please review your request and submit it to start
                                    receiving your quotes.</h5>
                            </div>
                            <div class="">
                                <hr>
                                <div class="font-weight-bold h5">

                                    Service Details 444
                                </div>

                                @php

                                    $packageEnquiryFormId = session('packages_enquiry_form_id');

                                @endphp
                                @if (isset($packageEnquiryFormId) && $packageEnquiryFormId != '')

                                    @php
                                        $att_data = DB::table('more_formfields_details')
                                            ->where('package_inquiry_id', '=', $packageEnquiryFormId)
                                            ->get();

                                        //echo "<pre>";print_r($att_data);echo "</pre>";

                                    @endphp

                                    @if (isset($att_data) && $att_data != '')
                                        @foreach ($att_data as $att_data_new)
                                            @php
                                                $form_label = DB::table('form_fileds')
                                                    ->where('id', '=', $att_data_new->form_field_id)
                                                    ->first();

                                                // echo '<pre>';
                                                // print_r($form_label);
                                                // echo '</pre>';

                                            @endphp
                                            <div class="d-flex justify-content-between my-2">
                                                <div>
                                                    @if ($att_data_new->formfield_value != '')
                                                        {{ $form_label->lable_name }}
                                                    @endif

                                                </div>
                                                <div class="font-weight-bold">{{ $att_data_new->formfield_value }}
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                @endif




                                <hr>


                            </div>

                            <button type="button" class="ud-btn btn-thm default-box-shadow2" id="nextBtn12"
                                onclick="get_hide_show(3);">Get Quote</button>
                        </div>

                        <div class="tab3" style="display:none">

                            <div class="col-12">
                                <h5 class="card-title mb-md-4">Thank you for the enquiry. Our support team will get
                                    back to asap</h5>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </form>
    </div>
</section>
@include('front.includes.footer')


<script>
    function get_hide_show(id)

    {
        if (id == 1) {

            $(".tab1").css("display", "block");
            $(".tab2").css("display", "none");
        }

        if (id == 2) {


            var name_new = $('#name_new').val();

            if (name_new == '') {

                $('#tab1_error').html("Please Enter Full Name");

                $('#tab1_error').show().delay(0).fadeIn('show');

                $('#tab1_error').show().delay(2000).fadeOut('show');

                return false;

            }


            var mobile_new = $('#mobile_new').val();

            if (mobile_new == '') {

                $('#tab1_error').html("Please Enter Phone");

                $('#tab1_error').show().delay(0).fadeIn('show');

                $('#tab1_error').show().delay(2000).fadeOut('show');

                return false;

            }


            if (mobile_new != '') {
                // var filter = /^\d{7}$/;
                if (mobile_new.length < 7 || mobile_new.length > 15) {

                    $('#tab1_error').html("Please Enter Valid Phone.");

                    $('#tab1_error').show().delay(0).fadeIn('show');

                    $('#tab1_error').show().delay(2000).fadeOut('show');

                    return false;

                }
            }


            var email_new = jQuery("#email_new").val();

            if (email_new == '') {

                jQuery('#tab1_error').html("Please Enter Email Id");

                jQuery('#tab1_error').show().delay(0).fadeIn('show');

                jQuery('#tab1_error').show().delay(2000).fadeOut('show');

                return false;

            }

            var em1 = jQuery('#email_new').val();

            var filter1 = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (!filter1.test(em1)) {

                jQuery('#tab1_error').html("Please Enter Valid Email Id");

                jQuery('#tab1_error').show().delay(0).fadeIn('show');

                jQuery('#tab1_error').show().delay(2000).fadeOut('show');

                return false;

            }




            $(".tab1").css("display", "none");
            $(".tab2").css("display", "block");
        }

        if (id == 3) {

            var name_new = $('#name_new').val();
            var mobile_new = $('#mobile_new').val();
            var email_new = jQuery("#email_new").val();

            var url = '{{ url('package_inquiry_new') }}';

            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "email_new": email_new,
                    "name_new": name_new,
                    "mobile_new": mobile_new,
                },
                success: function(msg) {
                    //alert(msg);
                    //document.getElementById('city_data').innerHTML = msg;

                    if (msg == 1) {

                        $(".tab1").css("display", "none");
                        $(".tab2").css("display", "none");
                        $(".tab3").css("display", "block");
                    }

                }

            });


            //$('#category_form_new').submit();
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

        // Example: Validate a text field
        @for ($i = 0; $i < count($result1); $i++)
            @for ($k = 0; $k < count($formFields); $k++)
                @if ($result1[$i]->lable_name == $formFields[$k]->lable_name)
                    @if ($result1[$i]->type == '1' && $result1[$i]->is_active == '1')
                        var test = jQuery("#formfield_value_{{ $formFields[$k]->id }}").val();
                        // alert(test);
                        if (test == '') {
                            jQuery('#name_error').html("Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#name_error').show().delay(0).fadeIn('show');
                            jQuery('#name_error').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_{{ $formFields[$k]->id }}').offset().top - 150
                            }, 1000);
                            return false;
                        }
                    @endif
                    @if ($result1[$i]->type == '2' && $result1[$i]->is_active == '1')
                        var drop_down = jQuery("#formfield_value_test{{ $formFields[$k]->id }}").val();
                        // alert(drop_down);
                        if (drop_down == '') {
                            jQuery('#drop_down_error_formfield_value_{{ $formFields[$k]->id }}').html(
                                "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#drop_down_error_formfield_value_{{ $formFields[$k]->id }}').show().delay(0)
                                .fadeIn('show');
                            jQuery('#drop_down_error_formfield_value_{{ $formFields[$k]->id }}').show().delay(2000)
                                .fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_test{{ $formFields[$k]->id }}').offset().top -
                                    150
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
                    @if (
                        $result1[$i]->type == '2' &&
                            $result1[$i]->lable_name == 'Do you require any additional service?' &&
                            $result1[$i]->is_active == '1')
                        var mul_drop_down = jQuery("#formfield_value_{{ $formFields[$k]->id }}").val();
                        if (mul_drop_down == '') {
                            jQuery('#mul_drop_error').html("Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#mul_drop_error').show().delay(0).fadeIn('show');
                            jQuery('#mul_drop_error').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_{{ $formFields[$k]->id }}').offset().top - 150
                            }, 1000);
                            return false;
                        }
                    @endif
                    @if ($result1[$i]->type == '7' && $result1[$i]->is_active == '1')
                        var text = jQuery("#formfield_value_{{ $formFields[$k]->id }}").val();
                        // alert(drop_down);
                        if (text == '') {
                            jQuery('#text_error').html("Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#text_error').show().delay(0).fadeIn('show');
                            jQuery('#text_error').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_{{ $formFields[$k]->id }}').offset().top - 150
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

        // var intFormValid = true;
        @for ($i = 0; $i < count($result2); $i++)
            @for ($k = 0; $k < count($formFields); $k++)
                @if ($result2[$i]->lable_name == $formFields[$k]->lable_name)
                    @if ($result2[$i]->type == '1' && $result2[$i]->is_active == '1')
                        var test = jQuery("#formfield_value_123{{ $formFields[$k]->id }}").val();
                        if (test == '') {
                            jQuery('#name2_error').html("Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#name2_error').show().delay(0).fadeIn('show');
                            jQuery('#name2_error').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_123{{ $formFields[$k]->id }}').offset().top -
                                    150
                            }, 1000);
                            return false;
                        }
                    @endif
                    @if ($result2[$i]->type == '2' && $result2[$i]->is_active == '1')
                        var drop_down = jQuery("#formfield_value_2{{ $formFields[$k]->id }}").val();
                        // alert(drop_down);
                        if (drop_down == '') {
                            jQuery('#drop_down_error_formfield_value_2{{ $formFields[$k]->id }}').html(
                                "Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#drop_down_error_formfield_value_2{{ $formFields[$k]->id }}').show().delay(0)
                                .fadeIn('show');
                            jQuery('#drop_down_error_formfield_value_2{{ $formFields[$k]->id }}').show().delay(2000)
                                .fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_2{{ $formFields[$k]->id }}').offset().top -
                                    150
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

                    @if (
                        $result2[$i]->type == '2' &&
                            $result2[$i]->lable_name == 'Do you require any additional service?' &&
                            $result2[$i]->is_active == '1')
                        var mul_drop_down = jQuery("#formfield_value_mul{{ $formFields[$k]->id }}").val();
                        if (mul_drop_down == '') {
                            jQuery('#mul2_drop_error').html("Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#mul2_drop_error').show().delay(0).fadeIn('show');
                            jQuery('#mul2_drop_error').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_mul{{ $formFields[$k]->id }}').offset().top -
                                    150
                            }, 1000);
                            return false;
                        }
                    @endif
                    @if ($result2[$i]->type == '7' && $result2[$i]->is_active == '1')
                        var text = jQuery("#formfield_value_text{{ $formFields[$k]->id }}").val();
                        // alert(drop_down);
                        if (text == '') {
                            jQuery('#text2_error').html("Please Enter {{ $formFields[$k]->lable_name }}");
                            jQuery('#text2_error').show().delay(0).fadeIn('show');
                            jQuery('#text2_error').show().delay(2000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#formfield_value_text{{ $formFields[$k]->id }}').offset().top -
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
</script>

{{-- @if (isset($formFields[$k]) && isset($formFields[$k]->id))
    <script>
        $("#formfield_value_{{ $formFields[$k]->id }}").select2({
            placeholder: "Select "
            // Add any other Select2 options you need
        });
    </script>
@endif --}}

@if (isset($formFields) && is_array($formFields))
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
@endif
