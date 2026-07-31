@extends('admin.includes.Template')

@section('content')
    <style>
        ul li {
            list-style: inherit;
        }
    </style>

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Edit Sub Service</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('subservice.index') }}"> Sub Service</a></li>

                        <li class="breadcrumb-item active">Edit Sub Service</li>

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

                        <form id="subservice_form" action="{{ route('subservice.update', $subservice->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            @method('PUT')

                            <div class="row">

                                <div class="col-lg-6">

                                    <div class="form-group">

                                        <label for="name">Service</label>

                                        <select name="serviceid" id="serviceid" class="form-control">

                                            <option value=""> Select Service</option>

                                            @foreach ($all_service as $service)
                                                <option value="{{ $service->id }}"
                                                    @if ($subservice->serviceid == $service->id) {{ 'selected' }} @endif>

                                                    {{ $service['servicename'] }}</option>
                                            @endforeach

                                        </select>
                                        <p class="form-error-text" id="service_error" style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Subservice Code</label>

                                        <input id="subservice_code" name="subservice_code" type="text"
                                            class="form-control" placeholder="Enter Sub Service Code"
                                            value="{{ $subservice->subservice_code ?? '' }}" />
                                        <p class="form-error-text" id="subservice_code_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <select class="form-control" id="country" name="country[]"
                                            onchange="city_change($(this).val())" multiple="multiple">
                                            <option value="">Select Country</option>
                                            @php $countryArray = explode(',',$subservice->country); @endphp
                                            @foreach ($country_data as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ in_array($country->id, $countryArray) ? 'selected' : '' }}>
                                                    {{ $country->country }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="country_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <span id="city_chang">
                                            <select class="form-control" id="city" name="city[]" multiple="multiple">
                                                <option value="">Select City</option>
                                                @if ($allcity != '' && count($allcity) > 0)
                                                    @php $cityname = explode(',',$subservice->city); @endphp

                                                    @foreach ($allcity as $city)
                                                        <option value="{{ $city->id }}"
                                                            {{ in_array($city->id, $cityname) ? 'selected' : '' }}>
                                                            {{ $city->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </span>
                                        <p class="form-error-text" id="city_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group">

                                        <label for="name">Sub Service</label>

                                        <input id="subservicename" name="subservicename" type="text" class="form-control"
                                            placeholder="Enter Sub Service" value="{{ $subservice->subservicename }}" />
                                        <p class="form-error-text" id="subservice_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="page_url">Page Url</label>
                                        <input id="page_url" name="page_url" type="text" class="form-control"
                                            placeholder="Enter Page Url" value="{{ $subservice->page_url }}" />

                                        <p class="form-error-text" id="page_url_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="page_url">Promo Discount (in % only)</label>
                                        <input id="promo_discount" name="promo_discount" type="text"
                                            class="form-control" placeholder="Enter Promo Discount"
                                            value="{{ $subservice->promo_discount }}" />


                                        <p class="form-error-text" id="promo_discount_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="page_url">Promo Discount Type</label>
                                        <br>
                                        <div class="radio" style="margin-top: 10px;">
                                            <lable for="Price">Price</lable>
                                            <input type="radio" name="discount_type" id="price" value="0"
                                                @if ($subservice->discount_type == 0) checked @endif>
                                            <lable for="Percentage">Percentage</lable>
                                            <input type="radio" name="discount_type" id="percentage" value="1"
                                                @if ($subservice->discount_type == 1) checked @endif>
                                            <lable for="None">None</lable>
                                            <input type="radio" name="discount_type" id="none" value="2"
                                                @if ($subservice->discount_type == 2) checked @endif>
                                        </div>

                                        <p class="form-error-text" id="discount_type_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Banner Title</label>

                                        <input id="banner_title" name="banner_title" type="text"
                                            class="form-control"value="{{ $subservice->banner_title }}"
                                            placeholder="Enter Banner Title" />
                                        <p class="form-error-text" id="banner_title_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Banner Subtitle</label>

                                        <input id="banner_subtitle" name="banner_subtitle" type="text"
                                            class="form-control"value="{{ $subservice->banner_subtitle }}"
                                            placeholder="Enter Banner Subtitle" />
                                        <p class="form-error-text" id="banner_subtitle_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="form-group">

                                        <label for="name">Image (840px x 570px)</label>

                                        <input id="image" name="image" type="file"
                                            class="form-control"value="" />
                                        @if ($subservice->image != '')
                                            <img src="{{ asset('public/upload/subservice/large/' . $subservice->image) }}"
                                                style=" width: 50px;margin-top: 10px;" />
                                        @endif

                                    </div>
                                </div>
                                {{-- <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Mobile Image (140px x 107px)</label>

                                        <input id="mobile_image" name="mobile_image" type="file" class="form-control"value="" />
                                        @if ($subservice->mobile_image != '')
                                            <img src="{{ asset('public/upload/subservice/medium/' . $subservice->mobile_image) }}"
                                                style=" width: 50px;margin-top: 10px;" />
                                        @endif

                                    </div>
                                </div> --}}
                                <div class="col-lg-4">
                                    <div class="form-group">

                                        <label for="name">Banner Image (1350px x 440px)</label>

                                        <input id="banner_image" name="banner_image" type="file"
                                            class="form-control"value="" />
                                        @if ($subservice->banner_image != '')
                                            <img src="{{ asset('public/upload/subservice/banner/' . $subservice->banner_image) }}"
                                                style=" width: 50px;margin-top: 10px;" />
                                        @endif

                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">

                                        <label for="name">Mobile Banner Image (400px x 475px)</label>

                                        <input id="mobile_banner_image" name="mobile_banner_image" type="file"
                                            class="form-control"value="" />
                                        @if ($subservice->mobile_banner_image != '')
                                            <img src="{{ asset('public/upload/subservice/banner/' . $subservice->mobile_banner_image) }}"
                                                style=" width: 50px;margin-top: 10px;" />
                                        @endif

                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">

                                        <label for="name">Image Alt tag</label>

                                        <input id="image_alt_tag" name="image_alt_tag" type="text"
                                            class="form-control" value="{{ $subservice->image_alt_tag }}"
                                            placeholder="Enter Image Alt tag" />
                                        <p class="form-error-text" id="image_alt_tag_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">

                                        <label for="name">Banner Image Alt tag</label>

                                        <input id="banner_image_alt_tag" name="banner_image_alt_tag" type="text"
                                            class="form-control" value="{{ $subservice->banner_image_alt_tag }}"
                                            placeholder="Enter Banner Image Alt tag" />
                                        <p class="form-error-text" id="banner_image_alt_tag_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">

                                        <label for="name">Mobile Image Alt tag</label>

                                        <input id="mobile_image_alt_tag" name="mobile_image_alt_tag" type="text"
                                            class="form-control" value="{{ $subservice->mobile_image_alt_tag }}"
                                            placeholder="Enter Banner Image Alt tag" />
                                        <p class="form-error-text" id="mobile_image_alt_tag_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label style="width: 100%;">Is Bookable</label>

                                        <div style="padding: 9px 0;">

                                            <input type="checkbox" name="is_bookable[]" id="is_bookable" value="0"
                                                @if (in_array('0', explode(',', $subservice->is_bookable))) {{ 'checked' }} @endif>
                                            Book Now
                                            <input type="checkbox" name="is_bookable[]" id="is_bookable" value="1"
                                                @if (in_array('1', explode(',', $subservice->is_bookable))) {{ 'checked' }} @endif> Inquiry
                                        </div>

                                        <p class="form-error-text" id="book_error" style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Inquiry Charge</label>

                                        <input id="charge" name="charge" type="text" class="form-control"
                                            placeholder="Enter Inquiry Charge" value="{{ $subservice->charge }}"
                                            onkeypress="return validateNumber(event)" />
                                        <p class="form-error-text" id="charge_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">No Of Inquiry</label>

                                        <input id="no_of_inquiry" name="no_of_inquiry" type="text"
                                            class="form-control" placeholder="Enter No Of Inquiry"
                                            value="{{ $subservice->no_of_inquiry }}"
                                            onkeypress="return validateNumber(event)" />

                                        <p class="form-error-text" id="inquiry_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>
                                <div class="form-group col-lg-6">

                                    <label for="name">Booking Service Percentage</label>

                                    <input id="servicepercentage" name="servicepercentage" type="text"
                                        class="form-control" placeholder="Enter Booking Service Percentage"
                                        value="{{ $subservice->servicepercentage }}"
                                        onkeypress="return validateNumber(event)" />

                                    <p class="form-error-text" id="serviceprice_error"
                                        style="color: red; margin-top: 10px;">
                                    </p>

                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Additional Charge Popup</label>
                                        <textarea id="additional_charge_popup" name="additional_charge_popup" type="text" class="form-control"
                                            placeholder="Enter Additional Charge Discription" value="" />{{ $subservice->additional_charge_popup }}</textarea>
                                        <p class="form-error-text" id="additional_charge_popup_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Timing Fee Popup</label>
                                        <textarea id="timing_fee_popup" name="timing_fee_popup" type="text" class="form-control"
                                            placeholder="Enter Timing Fee Discription" value="" />{{ $subservice->timing_fee_popup }}</textarea>
                                        <p class="form-error-text" id="timing_fee_popup_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Delivery Charge Popup</label>
                                        <textarea id="delivery_charge_popup" name="delivery_charge_popup" type="text" class="form-control"
                                            placeholder="Enter Delivery Charge Discription" value="" />{{ $subservice->delivery_charge_popup }}</textarea>
                                        <p class="form-error-text" id="delivery_charge_popup_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Service fee Popup</label>
                                        <textarea id="service_fee_popup" name="service_fee_popup" type="text" class="form-control"
                                            placeholder="Enter Service Fee Popup Discription" value="" />{{ $subservice->service_fee_popup }}</textarea>
                                        <p class="form-error-text" id="service_fee_popup_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">Cancel Policy
                                        Description</label>

                                    <textarea id="cancel_policy" name="cancel_policy" class="form-control" placeholder="Enter Cancel Policy">{{ $subservice->cancel_policy }}</textarea>

                                </div>

                                {{-- <div class="form-group">

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">Top
                                        Description</label>

                                    <textarea id="top_description" name="top_description" class="form-control" placeholder="Enter Top Description">{{ $subservice->top_description }}</textarea>

                                </div> --}}

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="city">Local Fields</label>
                                        <select class="form-control" id="form_fields" name="form_fields[]"
                                            multiple="multiple">
                                            <option value="">Select Form Fields</option>
                                            @if ($form_field_data != '' && count($form_field_data) > 0)
                                                @php $mucraft = explode(',',$subservice->form_fields); @endphp
                                                @foreach ($form_field_data as $form_field)
                                                    <option value="{{ $form_field->id }}"
                                                        {{ in_array($form_field->id, $mucraft) ? 'selected' : '' }}>
                                                        {{ $form_field->lable_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p class="form-error-text" id="form_fields_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="city">International Fields</label>
                                        <select class="form-control" id="form_fields_two" name="form_fields_two[]"
                                            multiple="multiple">
                                            <option value="">Select Form Fields</option>
                                            @if ($form_field_data != '' && count($form_field_data) > 0)
                                                @php $mucraft = explode(',',$subservice->form_fields_two); @endphp
                                                @foreach ($form_field_data as $form_field)
                                                    <option value="{{ $form_field->id }}"
                                                        {{ in_array($form_field->id, $mucraft) ? 'selected' : '' }}>
                                                        {{ $form_field->lable_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p class="form-error-text" id="form_fields_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">

                                        <label for="description" style="margin:15px 0 5px 0px; width:100%;">

                                            Description</label>

                                        <textarea id="description" name="description" class="form-control" placeholder="Enter Description">{{ $subservice->description }}</textarea>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Service Detail Image (513px x 180px)</label>
                                        <input id="service_detail_image" name="service_detail_image" type="file"
                                            class="form-control"value="" />
                                        <img src="{{ asset('public/upload/subservice/' . $subservice->service_detail_image) }}"
                                            style=" width: 50px;margin-top: 10px;" />
                                        <p class="form-error-text" id="service_detail_image_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Service Detail Image Alt tag</label>

                                        <input id="service_detail_image_alt_tag" name="service_detail_image_alt_tag"
                                            type="text" class="form-control"
                                            value="{{ $subservice->service_detail_image_alt_tag }}"
                                            placeholder="Service Detail Image Alt tag" />
                                        <p class="form-error-text" id="service_detail_image_alt_tag_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="service_detail_short_description"
                                            style="margin:15px 0 5px 0px; width:100%;">Service Detail Short
                                            Description</label>
                                        <textarea id="service_detail_short_description" name="service_detail_short_description" class="form-control"
                                            placeholder="Enter Service Detail Short Description">{{ $subservice->service_detail_short_description }}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="service_detail_popup_description"
                                            style="margin:15px 0 5px 0px; width:100%;">Service Detail Description</label>
                                        <textarea id="service_detail_popup_description" name="service_detail_popup_description" class="form-control"
                                            placeholder="Enter Service Detail Description">{{ $subservice->service_detail_popup_description }}</textarea>
                                    </div>
                                </div>




                                <!-- <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="service_detail_popup_description" style="margin:15px 0 5px 0px; width:100%;">Meta Title</label>
                                                        <input id="meta_title" name="meta_title" type="text" class="form-control" value="{{ $subservice->meta_title }}">

                                                        
                                                    </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="service_detail_popup_description" style="margin:15px 0 5px 0px; width:100%;">Meta Keyword</label>
                                                            <input id="meta_keyword" name="meta_keyword" type="text" class="form-control" value="{{ $subservice->meta_keyword }}">
                    
                                                            
                                                        </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="meta_description" style="margin:15px 0 5px 0px; width:100%;">Meta Description</label>
                                                                <textarea id="meta_description" name="meta_description" class="form-control" placeholder="Enter Meta Description">{{ $subservice->meta_description }}</textarea>
                                                            </div>
                                                            </div> -->

                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Add More Top Description Section</h5>
                                        <hr>
                                    </div>
                                </div>

                                @php
                                    $k = 0;
                                @endphp

                                @if ($subservice_top_description_attr != '')
                                    <input type="hidden" name="city_addmore_top_description[]" value="">


                                    <input type="hidden" name="description_addmore_top_description[]" value="">



                                    @for ($i = 0; $i < count($subservice_top_description_attr); $i++)
                                        <div class="row">
                                            @if ($i != 0)
                                                <hr>
                                            @endif
                                            <input type="hidden" name="updateid1xxx1_top_description[]"
                                                id="updateid1xxx1{{ $i + 1 }}"
                                                value="{{ $subservice_top_description_attr[$i]->id }}">

                                            <div class="col-md-9">
                                                <div class="form-group"> <label for="categoryname">City</label>
                                                    <select class="form-control" id="city_addmore_top_descriptionu"
                                                        name="city_addmore_top_descriptionu[]">
                                                        <option value="">Select City</option>
                                                        @foreach ($allcity as $data)
                                                            <option
                                                                value="{{ $data->id }}"@if ($data->id == $subservice_top_description_attr[$i]->city) selected @endif>
                                                                {{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="col-md-9">

                                                <div class="form-group"> <label for="categoryname">Description</label>



                                                    <textarea id="description_addmore_top_descriptionu_{{ $subservice_top_description_attr[$i]->id }}"
                                                        name="description_addmore_top_descriptionu[]" class="form-control" placeholder="Enter Description">{{ $subservice_top_description_attr[$i]->description }}</textarea>



                                                </div>

                                            </div>



                                            <a href="#"
                                                onclick="singledelete('{{ route('subservice_removed_top_descatt', ['pid' => $subservice_top_description_attr[$i]->subservice_id, 'id' => $subservice_top_description_attr[$i]->id]) }}')"
                                                class="btn btn-danger pull-right remove_field1"
                                                style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a>

                                        </div>


                                        @php
                                            $k++;
                                        @endphp
                                    @endfor
                                @endif

                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group"> <label for="categoryname">City</label>
                                            <select class="form-control" id="city_addmore_top_description"
                                                name="city_addmore_top_description[]">
                                                <option value="">Select City</option>
                                                @foreach ($allcity as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-9">

                                        <div class="form-group"> <label for="categoryname">Description</label>

                                            {{-- <input type="text" id="price" name="description_addmore[]"
													class="form-control" placeholder="Enter Description"> --}}
                                            <textarea id="description_addmore_top_description" name="description_addmore_top_description[]" class="form-control"
                                                placeholder="Enter Description"></textarea>


                                        </div>

                                    </div>

                                </div>
                                <div class="input_fields_wrap01_top_description">

                                </div>

                                <div class="form-group">

                                    <div class="col-sm-12">

                                        <button
                                            style="border: medium none;margin-right: 0px;line-height: 25px;margin-top: -62px;"
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button01_top_description">Add More </button>

                                    </div>

                                </div>



                                @php
                                    $k = 0;
                                @endphp


                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Add More Banners Section</h5>
                                        <hr>
                                    </div>
                                </div>
                                @if (!empty($banner_attribute_data))
                                    <input type="hidden" name="city_addmore_banner1[]" value="">
                                    <input type="hidden" name="title_addmore_banner1[]" value="">
                                    <input type="file" name="image_addmore_banner1[]" value=""
                                        style="display: none;">
                                    <input type="file" name="mobile_banner_image_addmore1[]" value=""
                                        style="display: none;">
                                    <input type="hidden" name="description_addmore_banner1[]" value="">
                                    @for ($i = 0; $i < count($banner_attribute_data); $i++)
                                        <div class="row">
                                            @if ($i != 0)
                                                <hr>
                                            @endif
                                            <input type="hidden" name="updateid1xxx0[]"
                                                id="updateid1xxx0{{ $i + 1 }}"
                                                value="{{ $banner_attribute_data[$i]->id }}">


                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="categoryname">City</label>
                                                    <select class="form-control" id="city_addmore_banner"
                                                        name="city_addmore_banneru[]">
                                                        <option value="">Select City</option>
                                                        @foreach ($allcity as $data)
                                                            <option value="{{ $data->id }}"
                                                                {{ $data->id == $banner_attribute_data[$i]->city ? 'selected' : '' }}>
                                                                {{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">

                                                <div class="form-group"> <label for="categoryname">Title</label>
                                                    <input type="text" id="title_addmore_banner"
                                                        name="title_addmore_banneru[]" class="form-control"
                                                        placeholder="Enter  Title"
                                                        value="{{ $banner_attribute_data[$i]->title }}">
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="categoryname">image</label>
                                                    <input type="file" id="image" name="image_addmoreu[]"
                                                        class="form-control">

                                                    <img src="{{ url('public/upload/service/banner_attr/large/' . $banner_attribute_data[$i]->image) }}"
                                                        style="width:35%;">

                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">

                                                    <label for="name">Mobile Banner Image (400px x 475px)</label>

                                                    <input id="mobile_banner_image_addmoreu"
                                                        name="mobile_banner_image_addmoreu[]" type="file"
                                                        class="form-control"value="" />
                                                    <img src="{{ url('public/upload/subservice/mobile_banner/large/' . $banner_attribute_data[$i]->mobile_banner_image) }}"
                                                        style="width:35%;">
                                                    <p class="form-error-text" id="mobile_banner_image_error"
                                                        style="color: red; margin-top: 10px;">
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group"> <label for="categoryname">Description</label>
                                                    {{-- <input type="text" id="description_addmore1"
                                                    name="description_addmore1[]" class="form-control"
                                                    placeholder="Enter Description"> --}}
                                                    <textarea id="description_addmoreu_{{ $banner_attribute_data[$i]->id }}" name="description_addmore_banneru[]"
                                                        class="form-control" placeholder="Enter Description">{{ $banner_attribute_data[$i]->short_description }}</textarea>

                                                </div>
                                            </div>



                                            <a href="#"
                                                onclick="singledeletebannerattr('{{ route('removed_subservice_banner_addmore_att', ['pid' => $banner_attribute_data[$i]->subservice_id, 'id' => $banner_attribute_data[$i]->id]) }}')"
                                                class="btn btn-danger pull-right remove_field1"
                                                style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a>
                                        </div>




                                        @php
                                            $k++;
                                        @endphp
                                    @endfor
                                @else
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group"> <label for="categoryname">City</label>
                                                <select class="form-control" id="city_addmore_banner"
                                                    name="city_addmore_banner1[]">
                                                    <option value="">Select City</option>
                                                    @foreach ($allcity as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group"> <label for="categoryname">Title</label>
                                                <input type="text" id="title_addmore_banner"
                                                    name="title_addmore_banner1[]" class="form-control"
                                                    placeholder="Enter  Title" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group"> <label for="categoryname">Image (2025px X
                                                    660px)</label>
                                                <input type="file" id="image" name="image_addmore_banner1[]"
                                                    class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">

                                                <label for="name">Mobile Banner Image (400px x 475px)</label>

                                                <input id="mobile_banner_image_addmore"
                                                    name="mobile_banner_image_addmore1[]" type="file"
                                                    class="form-control"value="" />
                                                <p class="form-error-text" id="mobile_banner_image_error"
                                                    style="color: red; margin-top: 10px;">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="form-group"> <label for="categoryname">Short Description</label>
                                                <textarea id="description_addmore_banner" name="description_addmore_banner1[]" class="form-control"
                                                    placeholder="Enter Description"></textarea>
                                            </div>
                                        </div>


                                    </div>

                                @endif

                                <div class="input_fields_wrap">
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button
                                            style="border: medium none;margin-right: 0px;line-height: 25px;margin-top: -62px;"
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button">Add More </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Add More Content Section</h5>
                                        <hr>
                                    </div>
                                </div>



                                {{-- Packages more Start --}}
                                @php
                                    $k = 0;
                                @endphp

                                @if ($package_attribute_data != '')
                                    <input type="hidden" name="city_addmore_second1[]" value="">
                                    <input type="hidden" name="title_addmore1[]" value="">
                                    <input type="hidden" name="image_alt_tag_addmore1[]" value="">

                                    <input type="file" name="e_image1_<?php echo $k; ?>" value=""
                                        style="display: none;">

                                    <input type="hidden" name="description_addmore1[]" value="">

                                    {{-- <textarea type="hidden" name="description_addmore1[]" value=""></textarea> --}}

                                    @for ($i = 0; $i < count($package_attribute_data); $i++)
                                        <div class="row">
                                            @if ($i != 0)
                                                <hr>
                                            @endif
                                            <input type="hidden" name="updateid1xxx1[]"
                                                id="updateid1xxx1{{ $i + 1 }}"
                                                value="{{ $package_attribute_data[$i]->id }}">

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="categoryname">City</label>
                                                    <select class="form-control" id="city_addmore_secondu"
                                                        name="city_addmore_secondu[]">
                                                        <option value="">Select City</option>
                                                        @foreach ($allcity as $data)
                                                            <option
                                                                value="{{ $data->id }}"@if ($data->id == $package_attribute_data[$i]->city) selected @endif>
                                                                {{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">

                                                <div class="form-group"> <label for="categoryname">Title</label>

                                                    <input type="text" id="price" name="title_addmoreu[]"
                                                        class="form-control" placeholder="Enter  Title"
                                                        value="{{ $package_attribute_data[$i]->title_addmore }}">

                                                </div>

                                            </div>
                                            <div class="col-md-4">

                                                <div class="form-group"> <label for="categoryname">Image (510px X
                                                        340px)</label>

                                                    <input type="file" id="image"
                                                        name="imageu_{{ $i }}" class="form-control"
                                                        placeholder="" value="">

                                                    <img src="{{ url('public/upload/subservice/subservice_attr/large/' . $package_attribute_data[$i]->image) }}"
                                                        style="width:35%;">

                                                </div>
                                            </div>

                                            <div class="col-md-5">

                                                <div class="form-group"> <label for="categoryname">Description</label>

                                                    {{-- <input type="text" id="description_addmoreu"
                                                        name="description_addmoreu[]" class="form-control"
                                                        placeholder="Enter Description"
                                                        value="{{ $package_attribute_data[$i]->description_addmore }}"> --}}

                                                    <textarea id="description_addmoreu_{{ $package_attribute_data[$i]->id }}" name="description_addmoreu[]"
                                                        class="form-control" placeholder="Enter Description">{{ $package_attribute_data[$i]->description_addmore }}</textarea>



                                                </div>

                                            </div>

                                            <div class="col-md-4">

                                                <div class="form-group"> <label for="categoryname">Image Alt tag</label>

                                                    <input type="text" id="image_alt_tag"
                                                        name="image_alt_tag_addmoreu[]" class="form-control"
                                                        placeholder="Enter  Image Alt tag"
                                                        value="{{ $package_attribute_data[$i]->image_alt_tag }}">

                                                </div>

                                            </div>

                                            <a href="#"
                                                onclick="singledelete('{{ route('removed_addmore_att', ['pid' => $package_attribute_data[$i]->pid, 'id' => $package_attribute_data[$i]->id]) }}')"
                                                class="btn btn-danger pull-right remove_field1"
                                                style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a>

                                        </div>


                                        @php
                                            $k++;
                                        @endphp
                                    @endfor
                                @endif



                                @if (empty($package_attribute_data))
                                    <input type="file" name="e_image1_0" value="" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group"> <label for="categoryname">City</label>
                                                <select class="form-control" id="city_addmore_second1"
                                                    name="city_addmore_second1[]">
                                                    <option value="">Select City</option>
                                                    @foreach ($allcity as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">

                                            <div class="form-group"> <label for="categoryname">Title</label>
                                                <input type="text" id="title_addmore1" name="title_addmore1[]"
                                                    class="form-control" placeholder="Enter  Title" value="">
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group"> <label for="categoryname">image</label>
                                                <input type="file" id="image1" name="e_image1_1"
                                                    class="form-control">

                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group"> <label for="categoryname">Description</label>
                                                {{-- <input type="text" id="description_addmore1"
                                                    name="description_addmore1[]" class="form-control"
                                                    placeholder="Enter Description"> --}}
                                                <textarea id="description_addmore1" name="description_addmore1[]" class="form-control"
                                                    placeholder="Enter Description"></textarea>

                                            </div>
                                        </div>
                                        <div class="col-md-4">

                                            <div class="form-group"> <label for="categoryname">Image Alt tag</label>
                                                <input type="text" id="image_alt_tag_addmore1"
                                                    name="image_alt_tag_addmore1[]" class="form-control"
                                                    placeholder="Enter  Image Alt tag" value="">
                                            </div>

                                        </div>
                                    </div>
                                @endif


                                <div class="input_fields_wrap01">

                                </div>

                                <div class="form-group">

                                    <div class="col-sm-12">

                                        <button
                                            style="border: medium none;margin-right: -21px;line-height: 26px;margin-top: -62px;"
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button01">Add More </button>

                                    </div>



                                </div>
                                {{-- Packages more End --}}




                                @php
                                    $k = 0;
                                @endphp


                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Add More Meta Section</h5>
                                        <hr>
                                    </div>
                                </div>
                                @if (!empty($subservice_contains_data))

                                    <input type="hidden" name="city_addmore_third1[]" value="">
                                    <input type="hidden" name="meta_title_addmore1[]" value="">
                                    <input type="hidden" name="meta_keyword_addmore1[]" value="">
                                    <input type="hidden" name="meta_description_addmore1[]" value="">
                                    @for ($i = 0; $i < count($subservice_contains_data); $i++)
                                        <div class="row">
                                            <input type="hidden" name="updateid1xxx2[]"
                                                id="updateid1xxx2{{ $i + 1 }}"
                                                value="{{ $subservice_contains_data[$i]->id }}">

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="categoryname">City</label>
                                                    <select class="form-control" id="city_addmore_thirdu"
                                                        name="city_addmore_thirdu[]">
                                                        <option value="">Select City</option>
                                                        @foreach ($allcity as $data)
                                                            <option
                                                                value="{{ $data->id }}"@if ($data->id == $subservice_contains_data[$i]->city) selected @endif>
                                                                {{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="categoryname">Meta Title</label>
                                                    <input type="text" id="meta_title_addmoreu"
                                                        name="meta_title_addmoreu[]" class="form-control" placeholder=""
                                                        value="{{ $subservice_contains_data[$i]->meta_title }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="categoryname">Meta Keyword</label>
                                                    <input type="text" id="meta_keyword_addmoreu"
                                                        name="meta_keyword_addmoreu[]" class="form-control"
                                                        placeholder=""
                                                        value="{{ $subservice_contains_data[$i]->meta_keyword }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group"><label for="categoryname">Meta Description</label>
                                                    <textarea id="meta_description_addmoreu" name="meta_description_addmoreu[]" class="form-control"
                                                        placeholder="Enter Meta Description">{{ $subservice_contains_data[$i]->meta_description }}</textarea>
                                                </div>
                                            </div>
                                            <a href="#"
                                                onclick="singledeleteattr('{{ route('removed_subservice_contain_att', ['pid' => $subservice_contains_data[$i]->subservice_id, 'id' => $subservice_contains_data[$i]->id]) }}')"
                                                class="btn btn-danger pull-right remove_field1"
                                                style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a>
                                        </div>

                                        @php
                                            $k++;
                                        @endphp
                                    @endfor
                                @else
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group"> <label for="categoryname">City</label>
                                                <select class="form-control" id="city_addmore_third1"
                                                    name="city_addmore_third1[]">
                                                    <option value="">Select City</option>
                                                    @foreach ($allcity as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group"> <label for="categoryname">Meta Title</label>
                                                <input type="text" id="meta_title_addmore1"
                                                    name="meta_title_addmore1[]" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group"> <label for="categoryname">Meta Keyword</label>
                                                <input type="text" id="meta_keyword_addmore1"
                                                    name="meta_keyword_addmore1[]" class="form-control" placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group"><label for="categoryname">Meta Description</label>
                                                <textarea id="meta_description_addmore1" name="meta_description_addmore1[]" class="form-control"
                                                    placeholder="Enter Meta Description"></textarea>
                                            </div>
                                        </div>


                                    </div>

                                @endif
                                <div class="input_fields_wrap02">
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button style="border: medium none;margin-right: 0px;line-height: 25px;"
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button02">Add More </button>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Add More Why Choose VendorCity Section</h5>
                                        <hr>
                                    </div>
                                </div>
                                @if (!empty($subservice_why_choose_attr))
                                    <input type="hidden" name="city_addmore_why_choose1[]" value="">
                                    <input type="hidden" name="whychoosevc_addmore1[]" value="">
                                    @for ($i = 0; $i < count($subservice_why_choose_attr); $i++)
                                        <div class="row">
                                            @if ($i != 0)
                                                <hr>
                                            @endif
                                            <input type="hidden" name="updateid_why_choose[]"
                                                id="updateid_why_choose{{ $i + 1 }}"
                                                value="{{ $subservice_why_choose_attr[$i]->id }}">

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="categoryname">City</label>
                                                    <select class="form-control" id="city_addmore_why_chooseu"
                                                        name="city_addmore_why_chooseu[]">
                                                        <option value="">Select City</option>
                                                        @foreach ($allcity as $data)
                                                            <option
                                                                value="{{ $data->id }}"@if ($data->id == $subservice_why_choose_attr[$i]->city) selected @endif>
                                                                {{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="form-group"><label for="categoryname">Description</label>
                                                    <textarea id="whychoosevc_addmoreu_{{ $subservice_why_choose_attr[$i]->id }}" name="whychoosevc_addmoreu[]"
                                                        class="form-control" placeholder="Enter Description">{{ $subservice_why_choose_attr[$i]->description }}</textarea>
                                                </div>
                                            </div>
                                            <a href="#"
                                                onclick="singledeleteattr('{{ route('removed_why_choose_att', ['pid' => $subservice_why_choose_attr[$i]->subservice_id, 'id' => $subservice_why_choose_attr[$i]->id]) }}')"
                                                class="btn btn-danger pull-right remove_field_why_choose"
                                                style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a>
                                        </div>
                                    @endfor
                                @else
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group"> <label for="categoryname">City</label>
                                                <select class="form-control" id="city_addmore_why_choose1"
                                                    name="city_addmore_why_choose1[]">
                                                    <option value="">Select City</option>
                                                    @foreach ($allcity as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="form-group"><label for="categoryname">Description</label>
                                                <textarea id="whychoosevc_addmore1" name="whychoosevc_addmore1[]" class="form-control"
                                                    placeholder="Enter Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="input_fields_wrap_why_choose">
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button
                                            style="border: medium none;margin-right: 15px;line-height: 25px; margin-top: 10px; margin-bottom: 20px;"
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button_why_choose">Add More </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Add More Description Section</h5>
                                        <hr>
                                    </div>
                                </div>
                                @if (isset($subservice_description_addmores) && count($subservice_description_addmores) > 0)
                                    <input type="hidden" name="city_addmore_description1[]" value="">
                                    <input type="hidden" name="description_addmore_new1[]" value="">
                                    @for ($i = 0; $i < count($subservice_description_addmores); $i++)
                                        <div class="row">
                                            @if ($i != 0)
                                                <hr>
                                            @endif
                                            <input type="hidden" name="updateid_description[]"
                                                id="updateid_description{{ $i + 1 }}"
                                                value="{{ $subservice_description_addmores[$i]['id'] }}">

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="categoryname">City</label>
                                                    <select class="form-control" id="city_addmore_descriptionu"
                                                        name="city_addmore_descriptionu[]">
                                                        <option value="">Select City</option>
                                                        @foreach ($allcity as $data)
                                                            <option
                                                                value="{{ $data->id }}"@if ($data->id == $subservice_description_addmores[$i]['city']) selected @endif>
                                                                {{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="form-group"><label for="categoryname">Description</label>
                                                    <textarea id="description_addmore_newu_{{ $subservice_description_addmores[$i]['id'] }}"
                                                        name="description_addmore_newu[]" class="form-control" placeholder="Enter Description">{{ $subservice_description_addmores[$i]['description'] }}</textarea>
                                                </div>
                                            </div>
                                            <a href="#"
                                                onclick="singledeleteattr('{{ route('removed_description_att', ['pid' => $subservice_description_addmores[$i]['subservice_id'], 'id' => $subservice_description_addmores[$i]['id']]) }}')"
                                                class="btn btn-danger pull-right remove_field_description"
                                                style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a>
                                        </div>
                                    @endfor
                                @else
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group"> <label for="categoryname">City</label>
                                                <select class="form-control" id="city_addmore_description1"
                                                    name="city_addmore_description1[]">
                                                    <option value="">Select City</option>
                                                    @foreach ($allcity as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="form-group"><label for="categoryname">Description</label>
                                                <textarea id="description_addmore_new1" name="description_addmore_new1[]" class="form-control"
                                                    placeholder="Enter Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="input_fields_wrap_description">
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button
                                            style="border: medium none;margin-right: 15px;line-height: 25px; margin-top: 10px; margin-bottom: 20px;"
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button_description">Add More </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Add More Services You'll Love Section</h5>
                                        <hr>
                                    </div>
                                </div>
                                @if (!empty($subservice_more_service_attr))
                                    <input type="hidden" name="city_addmore_more_service1[]" value="">
                                    <input type="hidden" name="subservice_addmore_more_service1[]" value="">
                                    @for ($i = 0; $i < count($subservice_more_service_attr); $i++)
                                        <div class="row">
                                            @if ($i != 0)
                                                <hr>
                                            @endif
                                            <input type="hidden" name="updateid_more_service[]"
                                                id="updateid_more_service{{ $i + 1 }}"
                                                value="{{ $subservice_more_service_attr[$i]->id }}">

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="categoryname">City</label>
                                                    <select class="form-control" id="city_addmore_more_serviceu"
                                                        name="city_addmore_more_serviceu[]">
                                                        <option value="">Select City</option>
                                                        @foreach ($allcity as $data)
                                                            <option
                                                                value="{{ $data->id }}"@if ($data->id == $subservice_more_service_attr[$i]->city) selected @endif>
                                                                {{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="form-group"><label for="categoryname">Subservices</label>
                                                    <select class="form-control select2"
                                                        id="subservice_addmore_more_serviceu_{{ $i }}"
                                                        name="subservice_addmore_more_serviceu[{{ $i }}][]"
                                                        multiple="multiple" data-placeholder="Select Subservices"
                                                        style="width: 100%;">
                                                        @php
                                                            $selectedSubservices = explode(
                                                                ',',
                                                                $subservice_more_service_attr[$i]->more_subservice_id,
                                                            );
                                                        @endphp
                                                        @foreach ($all_subservices as $data)
                                                            <option value="{{ $data->id }}"
                                                                @if (in_array($data->id, $selectedSubservices)) selected @endif>
                                                                {{ $data->subservicename }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <a href="#"
                                                onclick="singledeleteattr('{{ route('removed_more_service_att', ['pid' => $subservice_more_service_attr[$i]->subservice_id, 'id' => $subservice_more_service_attr[$i]->id]) }}')"
                                                class="btn btn-danger pull-right remove_field_more_service"
                                                style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a>
                                        </div>
                                    @endfor
                                @else
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group"> <label for="categoryname">City</label>
                                                <select class="form-control" id="city_addmore_more_service1"
                                                    name="city_addmore_more_service1[]">
                                                    <option value="">Select City</option>
                                                    @foreach ($allcity as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="form-group"><label for="categoryname">Subservices</label>
                                                <select class="form-control select2"
                                                    id="subservice_addmore_more_service1_0"
                                                    name="subservice_addmore_more_service1[0][]" multiple="multiple"
                                                    data-placeholder="Select Subservices" style="width: 100%;">
                                                    @foreach ($all_subservices as $data)
                                                        <option value="{{ $data->id }}">{{ $data->subservicename }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="input_fields_wrap_more_service">
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button
                                            style="border: medium none;margin-right: 15px;line-height: 25px; margin-top: 10px; margin-bottom: 20px;"
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button_more_service">Add More </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>What Else Can We Help With? Section</h5>
                                        <hr>
                                    </div>
                                </div>
                                @if (count($subservice_what_else_service_attr) > 0)
                                    @for ($i = 0; $i < count($subservice_what_else_service_attr); $i++)
                                        <div class="row">
                                            @if ($i != 0)
                                                <hr>
                                            @endif
                                            <input type="hidden" name="updateid_what_else_service[]"
                                                id="updateid_what_else_service{{ $i + 1 }}"
                                                value="{{ $subservice_what_else_service_attr[$i]->id }}">

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="categoryname">City</label>
                                                    <select class="form-control" id="city_addmore_what_else_serviceu"
                                                        name="city_addmore_what_else_serviceu[]">
                                                        <option value="">Select City</option>
                                                        @foreach ($allcity as $data)
                                                            <option
                                                                value="{{ $data->id }}"@if ($data->id == $subservice_what_else_service_attr[$i]->city) selected @endif>
                                                                {{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="form-group"><label for="categoryname">Subservices</label>
                                                    <select class="form-control select2"
                                                        id="subservice_addmore_what_else_serviceu_{{ $i }}"
                                                        name="subservice_addmore_what_else_serviceu[{{ $i }}][]"
                                                        multiple="multiple" data-placeholder="Select Subservices"
                                                        style="width: 100%;">
                                                        @php
                                                            $selectedSubservicesWhatElse = explode(
                                                                ',',
                                                                $subservice_what_else_service_attr[$i]
                                                                    ->what_else_subservice_id,
                                                            );
                                                        @endphp
                                                        @foreach ($all_subservices as $data)
                                                            <option value="{{ $data->id }}"
                                                                @if (in_array($data->id, $selectedSubservicesWhatElse)) selected @endif>
                                                                {{ $data->subservicename }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <a href="#"
                                                onclick="singledeleteattr('{{ route('removed_what_else_att', ['pid' => $subservice_what_else_service_attr[$i]->subservice_id, 'id' => $subservice_what_else_service_attr[$i]->id]) }}')"
                                                class="btn btn-danger pull-right remove_field_what_else_service"
                                                style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a>
                                        </div>
                                    @endfor
                                @else
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group"> <label for="categoryname">City</label>
                                                <select class="form-control" id="city_addmore_what_else_service1"
                                                    name="city_addmore_what_else_service1[]">
                                                    <option value="">Select City</option>
                                                    @foreach ($allcity as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="form-group"><label for="categoryname">Subservices</label>
                                                <select class="form-control select2"
                                                    id="subservice_addmore_what_else_service1_0"
                                                    name="subservice_addmore_what_else_service1[0][]"
                                                    multiple="multiple" data-placeholder="Select Subservices"
                                                    style="width: 100%;">
                                                    @foreach ($all_subservices as $data)
                                                        <option value="{{ $data->id }}">
                                                            {{ $data->subservicename }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="input_fields_wrap_what_else_service">
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button
                                            style="border: medium none;margin-right: 15px;line-height: 25px; margin-top: 10px; margin-bottom: 20px;"
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button_what_else_service">Add More </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>How to Book Services Section</h5>
                                        <hr>
                                    </div>
                                </div>
                                @for ($i = 1; $i <= 4; $i++)
                                    @php
                                        $stepTitleField = 'step_' . $i . '_title';
                                        $stepImageField = 'step_' . $i . '_image';
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6>Step {{ $i }}</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"> <label for="{{ $stepTitleField }}">Step
                                                    {{ $i }} Title</label>
                                                <input type="text" id="{{ $stepTitleField }}"
                                                    name="{{ $stepTitleField }}" class="form-control"
                                                    placeholder="Enter Step {{ $i }} Title"
                                                    value="{{ $subservice->$stepTitleField }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"> <label for="{{ $stepImageField }}">Step
                                                    {{ $i }} Image</label>
                                                <input type="file" id="{{ $stepImageField }}"
                                                    name="{{ $stepImageField }}" class="form-control"
                                                    placeholder="">
                                                @if ($subservice->$stepImageField != '')
                                                    <img src="{{ url('public/upload/subservice/' . $subservice->$stepImageField) }}"
                                                        alt="" style="width: 100px; margin-top: 10px;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endfor

                            </div>

                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('subservice.index') }}"> Cancel</a>

                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>

                                    Loading...

                                </button>



                                <button type="button" class="btn btn-primary" id="submit_button"
                                    onclick="javascript:subservice_validation()">Submit</button>

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
            placeholder: "Select a City" // Replace with your desired placeholder text
        });

        $("#country").select2({
            placeholder: "Select a Country" // Replace with your desired placeholder text
        });
        $(function() {

            $("#subservicename").keyup(function() {

                var Text = $(this).val();

                Text = Text.toLowerCase();

                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');

                $("#page_url").val(Text);

            });

        });


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

        // function city_change(country_ids) {

        //     // If multiple countries selected, country_ids will be an array
        //     $.ajax({
        //         url: "{{ url('city_show_new') }}",
        //         type: "POST",
        //         data: {
        //             country_id: country_ids,
        //             "_token": "{{ csrf_token() }}",
        //         },
        //         success: function(response) {
        //             $("#city").empty(); // Remove old options

        //             $("#city").append(`<option value="">Select City</option>`);

        //             $.each(response, function(index, city) {
        //                 $("#city").append(`<option value="${city.id}">${city.name}</option>`);
        //             });
        //         }
        //     });
        // }
        var oldCities = @json(explode(',', $service->city));

        function city_change(country_ids) {

            var selectedCities = $("#city").val() || oldCities || [];

            $.ajax({
                url: "{{ url('city_show_new') }}",
                type: "POST",
                data: {
                    country_id: country_ids,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {

                    $("#city").empty();
                    $("#city").append('<option value="">Select City</option>');

                    $.each(response, function(index, city) {

                        var selected = selectedCities.includes(city.id.toString()) ? 'selected' : '';

                        $("#city").append(
                            '<option value="' + city.id + '" ' + selected + '>' + city.name +
                            '</option>'
                        );

                    });

                    $("#city").trigger('change');

                }
            });

        }
    </script>



    <script>
        function subservice_validation() {

            var serviceid = jQuery("#serviceid").val();
            if (serviceid == '') {
                jQuery('#service_error').html("Please Select Service");
                jQuery('#service_error').show().delay(0).fadeIn('show');
                jQuery('#service_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#serviceid').offset().top - 150
                }, 1000);
                return false;
            }

            var subservice_code = jQuery("#subservice_code").val();

            if (subservice_code == '') {
                jQuery('#subservice_code_error').html("Please Enter Subservice Code");
                jQuery('#subservice_code_error').show().delay(0).fadeIn('show');
                jQuery('#subservice_code_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#subservice_code').offset().top - 150
                }, 1000);
                return false;
            }



            var subservicename = jQuery("#subservicename").val();
            if (subservicename == '') {
                jQuery('#subservice_error').html("Please Enter Sub Service");
                jQuery('#subservice_error').show().delay(0).fadeIn('show');
                jQuery('#subservice_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#subservicename').offset().top - 150
                }, 1000);
                return false;
            }

            var page_url = jQuery("#page_url").val();
            if (page_url == '') {
                jQuery('#page_url_error').html("Please Enter Page Url");
                jQuery('#page_url_error').show().delay(0).fadeIn('show');
                jQuery('#page_url_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#page_url').offset().top - 150
                }, 1000);
                return false;
            }

            var isBookableCheckboxes = jQuery('input[name="is_bookable[]"]:checked');

            if (isBookableCheckboxes.length === 0) {
                jQuery('#book_error').html("Please Select Is Bookable");
                jQuery('#book_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: jQuery('#is_bookable').offset().top - 150
                }, 1000);
                return false;
            }

            var charge = jQuery("#charge").val();
            if (charge == '') {
                jQuery('#charge_error').html("Please Enter Inquiry Charge");
                jQuery('#charge_error').show().delay(0).fadeIn('show');
                jQuery('#charge_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#charge').offset().top - 150
                }, 1000);
                return false;
            }

            var no_of_inquiry = jQuery("#no_of_inquiry").val();
            if (no_of_inquiry == '') {
                jQuery('#inquiry_error').html("Please Enter No Of Inquiry");
                jQuery('#inquiry_error').show().delay(0).fadeIn('show');
                jQuery('#inquiry_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#no_of_inquiry').offset().top - 150
                }, 1000);
                return false;
            }
            var promo_discount = jQuery("#promo_discount").val();
            if (promo_discount == '') {
                jQuery('#promo_discount_error').html("Please Enter Promo Discount");
                jQuery('#promo_discount_error').show().delay(0).fadeIn('show');
                jQuery('#promo_discount_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#promo_discount').offset().top - 150
                }, 1000);
                return false;
            }
            // var service_fee_popup = jQuery("#service_fee_popup").val();
            // if (service_fee_popup == '') {
            //     jQuery('#service_fee_popup_error').html("Please Enter Service fee Popup Discription");
            //     jQuery('#service_fee_popup_error').show().delay(0).fadeIn('show');
            //     jQuery('#service_fee_popup_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#service_fee_popup').offset().top - 150
            //     }, 1000);
            //     return false;
            // }

            // var banner_title = jQuery("#banner_title").val();
            // if (banner_title == '') {
            //     jQuery('#banner_title_error').html("Please Enter Banner Title");
            //     jQuery('#banner_title_error').show().delay(0).fadeIn('show');
            //     jQuery('#banner_title_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#banner_title').offset().top - 150
            //     }, 1000);
            //     return false;
            // }

            // var banner_subtitle = jQuery("#banner_subtitle").val();
            // if (banner_subtitle == '') {
            //     jQuery('#banner_subtitle_error').html("Please Enter Banner Sub Title");
            //     jQuery('#banner_subtitle_error').show().delay(0).fadeIn('show');
            //     jQuery('#banner_subtitle_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#banner_subtitle').offset().top - 150
            //     }, 1000);
            //     return false;
            // }




            $('#spinner_button').show();

            $('#submit_button').hide();

            $('#subservice_form').submit();

        }
    </script>


    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script> --}}
    <script src="{{ asset('public/admin/assets/ckeditor/build/ckeditor.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>


    <script>
        ClassicEditor

            .create(document.querySelector('#description'))

            .catch(error => {

                console.error(error);

            });
        ClassicEditor.create(document.querySelector('#top_description'), {
            heading: {
                options: [{
                        model: 'paragraph',
                        title: 'Paragraph',
                        class: 'ck-heading_paragraph'
                    },
                    {
                        model: 'heading1',
                        view: 'h1',
                        title: 'Heading 1',
                        class: 'ck-heading_heading1'
                    },
                    {
                        model: 'heading2',
                        view: 'h2',
                        title: 'Heading 2',
                        class: 'ck-heading_heading2'
                    }
                ]
            }
        }).catch(error => {
            console.error(error);
        });


        ClassicEditor
            .create(document.querySelector('#top_description'), {
                toolbar: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'underline',
                    '|',
                    'fontFamily',
                    'fontSize',
                    'fontColor',
                    'fontBackgroundColor',
                    '|',
                    'link',
                    'bulletedList',
                    'numberedList',
                    'blockQuote'
                ],
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Verdana, Geneva, sans-serif'
                    ]
                },
                fontSize: {
                    options: [
                        9,
                        11,
                        13,
                        'default',
                        17,
                        19,
                        21
                    ]
                }
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor

            .create(document.querySelector('#cancel_policy'))

            .catch(error => {

                console.error(error);

            });
        ClassicEditor

            .create(document.querySelector('#description_addmore1'))

            .catch(error => {

                console.error(error);

            });

        @if ($subservice_why_choose_attr != '')
            @for ($i = 0; $i < count($subservice_why_choose_attr); $i++)
                ClassicEditor
                    .create(document.querySelector(
                        '#whychoosevc_addmoreu_{{ $subservice_why_choose_attr[$i]->id }}'))
                    .catch(error => {
                        console.error(error);
                    });
            @endfor
        @endif
        @if (empty($subservice_why_choose_attr))
            ClassicEditor
                .create(document.querySelector('#whychoosevc_addmore1'))
                .catch(error => {
                    console.error(error);
                });
        @endif

        $(document).ready(function() {
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap_why_choose");
            var add_button = $("#add_field_button_why_choose");
            var b = 0;

            $(add_button).click(function(e) {
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    var newField = $(
                        '<div class="row"><hr><div class="col-md-4"><div class="form-group"> <label for="categoryname">City</label><select class="form-control" name="city_addmore_why_choose1[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div><div class="col-md-8"><div class="form-group"><label for="categoryname">Description</label><textarea id="whychoosevc_addmore_' +
                        b +
                        '" name="whychoosevc_addmore1[]" class="form-control" placeholder="Enter Description"></textarea></div></div><a href="#" class="btn btn-danger pull-right remove_field_why_choose" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
                    );

                    $(wrapper).append(newField);
                    var newDescriptionField = newField.find('#whychoosevc_addmore_' + b);
                    if (newDescriptionField.length) {
                        ClassicEditor.create(newDescriptionField[0]).catch(error => {
                            console.error(error);
                        });
                    }
                }
            });

            $(wrapper).on("click", ".remove_field_why_choose", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            });

            // Add a function to update the textarea content before form submission
            $('form').submit(function() {
                $('.input_fields_wrap_why_choose textarea').each(function() {
                    $(this).val($(this).siblings('.ck-editor__editable').html());
                });
            });
        });

        @if (isset($subservice_description_addmores) && count($subservice_description_addmores) > 0)
            @for ($i = 0; $i < count($subservice_description_addmores); $i++)
                ClassicEditor
                    .create(document.querySelector(
                        '#description_addmore_newu_{{ $subservice_description_addmores[$i]['id'] }}'))
                    .catch(error => {
                        console.error(error);
                    });
            @endfor
        @else
            ClassicEditor
                .create(document.querySelector('#description_addmore_new1'))
                .catch(error => {
                    console.error(error);
                });
        @endif

        $(document).ready(function() {
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap_description");
            var add_button = $("#add_field_button_description");
            var b = 0;

            $(add_button).click(function(e) {
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    var newField = $(
                        '<div class="row"><hr><div class="col-md-4"><div class="form-group"> <label for="categoryname">City</label><select class="form-control" name="city_addmore_description1[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div><div class="col-md-8"><div class="form-group"><label for="categoryname">Description</label><textarea id="description_addmore_new_' +
                        b +
                        '" name="description_addmore_new1[]" class="form-control" placeholder="Enter Description"></textarea></div></div><a href="#" class="btn btn-danger pull-right remove_field_description" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
                    );

                    $(wrapper).append(newField);
                    var newDescriptionField = newField.find('#description_addmore_new_' + b);
                    if (newDescriptionField.length) {
                        ClassicEditor.create(newDescriptionField[0]).catch(error => {
                            console.error(error);
                        });
                    }
                }
            });

            $(wrapper).on("click", ".remove_field_description", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            });

            // Add a function to update the textarea content before form submission
            $('form').submit(function() {
                $('.input_fields_wrap_description textarea').each(function() {
                    $(this).val($(this).siblings('.ck-editor__editable').html());
                });
            });
        });


        @for ($i = 0; $i < count($package_attribute_data); $i++)
            ClassicEditor

                .create(document.querySelector('#description_addmoreu_{{ $package_attribute_data[$i]->id }}'))

                .catch(error => {

                    console.error(error);

                });
        @endfor
        ClassicEditor

            .create(document.querySelector('#service_detail_popup_description'))

            .catch(error => {

                console.error(error);

            });

        $("#form_fields").select2({
            placeholder: "Select a Local Fields" // Replace with your desired placeholder text
        });
        $("#form_fields_two").select2({
            placeholder: "Select a International Fields" // Replace with your desired placeholder text
        });
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

        function singledeleteattr(url) {
            var t = confirm('Are You Sure To Delete The Attribute ?');

            if (t) {

                window.location.href = url;

            } else {

                return false;

            }


        }

        function singledeletebannerattr(url) {
            var t = confirm('Are You Sure To Delete The Attribute ?');

            if (t) {

                window.location.href = url;

            } else {

                return false;

            }


        }
        $(document).ready(function() {
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap");
            var add_button = $("#add_field_button");
            var b = 0;

            $(add_button).click(function(e) {
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    var newField = $(
                        '<div class="row"><hr><div class="col-md-4"><div class="form-group"> <label for="categoryname">City</label><select class="form-control" id="city_addmore_banner1" name="city_addmore_banner1[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Title</label><input type="text" id="title_addmore_banner1" name="title_addmore_banner1[]" class="form-control" placeholder="Enter  Title" value=""></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Image (2025px X 660px)</label><input type="file" id="image" name="image_addmore_banner1[]" class="form-control"placeholder=""></div></div><div class="col-lg-4"><div class="form-group"><label for="name">Mobile Banner Image (400px x 475px)</label><input id="mobile_banner_image_addmore" name="mobile_banner_image_addmore[]" type="file"class="form-control"value="" /><p class="form-error-text" id="mobile_banner_image_error"style="color: red; margin-top: 10px;"></p></div></div><div class="col-md-5"><div class="form-group"> <label for="categoryname">Short Description</label><textarea id="description_addmore_banner" name="description_addmore_banner1[]" class="form-control"placeholder="Enter Description"></textarea></div></div><a href="#" class="btn btn-danger pull-right remove_field" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
                    );

                    $(wrapper).append(newField);
                    var newDescriptionField = newField.find('#description_addmoree_' + b);
                    ClassicEditor
                        .create(newDescriptionField[0])
                        .catch(error => {
                            console.error(error);
                        });
                }
            });

            $(wrapper).on("click", ".remove_field", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            });

            // Add a function to update the textarea content before form submission
            $('form').submit(function() {
                $('.input_fields_wrap01 textarea').each(function() {
                    $(this).val($(this).siblings('.ck-editor__editable').html());
                });
            });
        });

        $(document).ready(function() {
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap01");
            var add_button = $("#add_field_button01");
            var b = 0;

            $(add_button).click(function(e) {
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    var newField = $(
                        '<div class="row"><hr><div class="col-md-4"><div class="form-group"> <label for="categoryname">City</label><select class="form-control" id="city_addmore_second1" name="city_addmore_second1[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option> @endforeach</select></div></div><div class="col-md-4"> <div class="form-group"> <label for="categoryname">Title</label>  <input type="text" id="title_addmore" name="title_addmore1[]" class="form-control" placeholder="Enter  Title"></div></div><div class="col-md-4"><div class="form-group"><label for="categoryname">Image(510px X 340px)</label><input type="file" id="price" name="e_image1_' +
                        b +
                        '" class="form-control"  placeholder=""> </div></div> <div class="col-md-5"><div class="form-group"><label for="categoryname">Description</label><textarea id="description_addmoree_' +
                        b +
                        '" name="description_addmore1[]" class="form-control" placeholder="Enter Description"></textarea></div></div><div class="col-md-4"> <div class="form-group"> <label for="categoryname">Image Alt tag</label>  <input type="text" id="title_addmore" name="image_alt_tag_addmore1[]" class="form-control" placeholder="Enter  Image Alt tag"></div></div><a href="#" class="btn btn-danger pull-right remove_field01" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
                    );

                    $(wrapper).append(newField);
                    var newDescriptionField = newField.find('#description_addmoree_' + b);
                    ClassicEditor
                        .create(newDescriptionField[0])
                        .catch(error => {
                            console.error(error);
                        });
                }
            });

            $(wrapper).on("click", ".remove_field01", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            });

            // Add a function to update the textarea content before form submission
            $('form').submit(function() {
                $('.input_fields_wrap01 textarea').each(function() {
                    $(this).val($(this).siblings('.ck-editor__editable').html());
                });
            });
        });
        $(document).ready(function() {
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap02");
            var add_button = $("#add_field_button02");
            var b = 0;

            $(add_button).click(function(e) {
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    var newField = $(
                        '<div class="row"><hr><div class="col-md-4"><div class="form-group"> <label for="categoryname">City</label><select class="form-control" id="city" name="city_addmore_third1[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Meta Title</label><input type="text" id="meta_title_addmore1" name="meta_title_addmore1[]" class="form-control" placeholder=""></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Meta Keyword</label><input type="text" id="meta_keyword_addmore1" name="meta_keyword_addmore1[]" class="form-control"placeholder=""></div></div><div class="col-md-4"><div class="form-group"><label for="categoryname">Meta Description</label><textarea id="meta_description_addmore1" name="meta_description_addmore1[]" class="form-control"placeholder="Enter Meta Description"></textarea></div></div><a href="#" class="btn btn-danger pull-right remove_field02" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
                    );

                    $(wrapper).append(newField);
                    var newDescriptionField = newField.find('#description_addmoree_' + b);
                    ClassicEditor
                        .create(newDescriptionField[0])
                        .catch(error => {
                            console.error(error);
                        });
                }
            });

            $(wrapper).on("click", ".remove_field02", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            });

            // Add a function to update the textarea content before form submission
            $('form').submit(function() {
                $('.input_fields_wrap01 textarea').each(function() {
                    $(this).val($(this).siblings('.ck-editor__editable').html());
                });
            });
        });
        ClassicEditor.create(document.querySelector('#description_addmore_top_description'), {
            heading: {
                options: [{
                        model: 'paragraph',
                        title: 'Paragraph',
                        class: 'ck-heading_paragraph'
                    },
                    {
                        model: 'heading1',
                        view: 'h1',
                        title: 'Heading 1',
                        class: 'ck-heading_heading1'
                    },
                    {
                        model: 'heading2',
                        view: 'h2',
                        title: 'Heading 2',
                        class: 'ck-heading_heading2'
                    }
                ]
            }
        }).catch(error => {
            console.error(error);
        });


        @for ($i = 0; $i < count($subservice_top_description_attr); $i++)


            ClassicEditor.create(document.querySelector(
                '#description_addmore_top_descriptionu_{{ $subservice_top_description_attr[$i]->id }}'), {
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        }
                    ]
                }
            }).catch(error => {
                console.error(error);
            });
        @endfor

        $(document).ready(function() {
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap01_top_description");
            var add_button = $("#add_field_button01_top_description");
            var b = 0;

            $(add_button).click(function(e) {
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    var newField = $(
                        '<div class="row"><hr><div class="col-md-9"><div class="form-group"> <label for="categoryname">City</label><select class="form-control" id="city_addmore_top_description" name="city_addmore_top_description[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div> <div class="col-md-9"><div class="form-group"><label for="categoryname">Description</label><textarea id="description_addmoree_top_description_' +
                        b +
                        '" name="description_addmore_top_description[]" class="form-control" placeholder="Enter Description"></textarea></div></div><a href="#" class="btn btn-danger pull-right remove_field01_top_description" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
                    );

                    $(wrapper).append(newField);
                    var newDescriptionField = newField.find('#description_addmoree_top_description_' + b);
                    if (newDescriptionField.length) {
                        ClassicEditor.create(newDescriptionField[0], {
                            heading: {
                                options: [{
                                        model: 'paragraph',
                                        title: 'Paragraph',
                                        class: 'ck-heading_paragraph'
                                    },
                                    {
                                        model: 'heading1',
                                        view: 'h1',
                                        title: 'Heading 1',
                                        class: 'ck-heading_heading1'
                                    },
                                    {
                                        model: 'heading2',
                                        view: 'h2',
                                        title: 'Heading 2',
                                        class: 'ck-heading_heading2'
                                    }
                                ]
                            }
                        }).catch(error => {
                            console.error(error);
                        });
                    }
                }
            });

            $(wrapper).on("click", ".remove_field01_top_description", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            });

            // Add a function to update the textarea content before form submission
            $('form').submit(function() {
                $('.input_fields_wrap01_top_description textarea').each(function() {
                    $(this).val($(this).siblings('.ck-editor__editable').html());
                });
            });
        });

        $(document).ready(function() {
            // Initialize existing select2 elements
            $('select[id^="subservice_addmore_"]').select2({
                placeholder: "Select Subservices"
            });

            var max_fields = 50;
            var wrapper = $(".input_fields_wrap_more_service");
            var add_button = $("#add_field_button_more_service");
            var b = 0;

            $(add_button).click(function(e) {
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    var newField = $(
                        '<div class="row"><hr><div class="col-md-4"><div class="form-group"> <label for="categoryname">City</label><select class="form-control" name="city_addmore_more_service1[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div><div class="col-md-8"><div class="form-group"><label for="categoryname">Subservices</label><select class="form-control select2" id="subservice_addmore_more_service1_' +
                        b + '" name="subservice_addmore_more_service1[' + b +
                        '][]" multiple="multiple" data-placeholder="Select Subservices" style="width: 100%;">@foreach ($all_subservices as $data)<option value="{{ $data->id }}">{{ $data->subservicename }}</option>@endforeach</select></div></div><a href="#" class="btn btn-danger pull-right remove_field_more_service" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
                    );

                    $(wrapper).append(newField);

                    // Initialize Select2 on the new select element
                    $('#subservice_addmore_more_service1_' + b).select2({
                        placeholder: "Select Subservices"
                    });
                }
            });

            $(wrapper).on("click", ".remove_field_more_service", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
            });
        });
        $(document).ready(function() {
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap_what_else_service");
            var add_button = $("#add_field_button_what_else_service");
            var b = 0;

            $(add_button).click(function(e) {
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    var newField = $(
                        '<div class="row"><hr><div class="col-md-4"><div class="form-group"> <label for="categoryname">City</label><select class="form-control" name="city_addmore_what_else_service1[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div><div class="col-md-8"><div class="form-group"><label for="categoryname">Subservices</label><select class="form-control select2" id="subservice_addmore_what_else_service1_' +
                        b + '" name="subservice_addmore_what_else_service1[' + b +
                        '][]" multiple="multiple" data-placeholder="Select Subservices" style="width: 100%;">@foreach ($all_subservices as $data)<option value="{{ $data->id }}">{{ $data->subservicename }}</option>@endforeach</select></div></div><a href="#" class="btn btn-danger pull-right remove_field_what_else_service" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
                    );

                    $(wrapper).append(newField);

                    // Initialize Select2 on the new select element
                    $('#subservice_addmore_what_else_service1_' + b).select2({
                        placeholder: "Select Subservices"
                    });
                }
            });

            $(wrapper).on("click", ".remove_field_what_else_service", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
            });
        });
    </script>



@stop
