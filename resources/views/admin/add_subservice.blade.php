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

                    <h3 class="page-title">Sub Service</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('subservice.index') }}">Sub Service</a></li>

                        <li class="breadcrumb-item active">Add Sub Service</li>

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

                        <form id="subservice_form" action="{{ route('subservice.store') }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="row">
							
							
                               
								

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Service</label>

                                        <select name="serviceid" id="serviceid" class="form-control">

                                            <option value=""> Select Service</option>

                                            @foreach ($service_data as $all_service_data)
                                                <option value="{{ $all_service_data['id'] }}">
                                                    {{ $all_service_data['servicename'] }}

                                                </option>
                                            @endforeach

                                        </select>
                                        <p class="form-error-text" id="service_error" style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Subservice Code</label>

                                        <input id="subservice_code" name="subservice_code" type="text" class="form-control"
                                            placeholder="Enter Sub Service Code" value="" />
                                        <p class="form-error-text" id="subservice_code_error" style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>
								<div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <select class="form-control search_country" id="country" name="country[]" onchange="city_change($(this).val())" multiple="multiple">
                                            <option value="">Select Country</option>
                                          
                                            @foreach ($country_data as $country)
                                                <option value="{{ $country->id }}">{{ $country->country }}</option>
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
                                           
                                        </select>
                                    </span>
                                    <p class="form-error-text" id="city_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Sub Service</label>
                                        <input id="subservicename" name="subservicename" type="text" class="form-control"
                                            placeholder="Enter Sub Service" value="" />

                                        <p class="form-error-text" id="subservice_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="page_url">Page Url</label>
                                        <input id="page_url" name="page_url" type="text" class="form-control"
                                            placeholder="Enter Page Url" value="" />

                                        <p class="form-error-text" id="page_url_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="page_url">Promo Discount (in % only)</label>
                                        <input id="promo_discount" name="promo_discount" type="text" class="form-control"
                                            placeholder="Enter Promo Discount" value="" />
                                        

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
                                        <input type="radio" name="discount_type" id="price" value="0">
                                        <lable for="Percentage">Percentage</lable>
                                        <input type="radio" name="discount_type" id="percentage" value="1">
                                        <lable for="None">None</lable>
                                        <input type="radio" name="discount_type" id="none" value="2">
                                        </div>  

                                        <p class="form-error-text" id="discount_type_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6"> 
                                    <div class="form-group">

                                        <label for="name">Banner Title</label>

                                        <input id="banner_title" name="banner_title" type="text" class="form-control"value="" placeholder="Enter Banner Title" />
                                        <p class="form-error-text" id="banner_title_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-6"> 
                                    <div class="form-group">

                                        <label for="name">Banner Subtitle</label>

                                        <input id="banner_subtitle" name="banner_subtitle" type="text" class="form-control"value="" placeholder="Enter Banner Title"/>
                                        <p class="form-error-text" id="banner_subtitle_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>


                                <div class="col-lg-4"> 
                                    <div class="form-group">

                                        <label for="name">Image (840px x 570px)</label>

                                        <input id="image" name="image" type="file" class="form-control"value="" />
                                        <p class="form-error-text" id="image_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                

                                <div class="col-lg-4">
                                    <div class="form-group">

                                        <label for="name">Banner Image (1350px x 440px)</label>

                                        <input id="banner_image" name="banner_image" type="file"
                                            class="form-control"value="" />
                                        <p class="form-error-text" id="banner_image_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">

                                        <label for="name">Mobile Banner Image (400px x 475px)</label>

                                        <input id="mobile_banner_image" name="mobile_banner_image" type="file"
                                            class="form-control"value="" />
                                        <p class="form-error-text" id="mobile_banner_image_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-4"> 
                                    <div class="form-group">

                                        <label for="name">Image Alt tag</label>

                                        <input id="image_alt_tag" name="image_alt_tag" type="text" class="form-control"value="" placeholder="Enter Image Alt tag"/>
                                        <p class="form-error-text" id="image_alt_tag_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-4"> 
                                    <div class="form-group">

                                        <label for="name">Banner Image Alt tag</label>

                                        <input id="banner_image_alt_tag" name="banner_image_alt_tag" type="text" class="form-control"value="" placeholder="Enter Banner Image Alt tag"/>
                                        <p class="form-error-text" id="banner_image_alt_tag_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-4"> 
                                    <div class="form-group">

                                        <label for="name">Mobile  Image Alt tag</label>

                                        <input id="mobile_image_alt_tag" name="mobile_image_alt_tag" type="text" class="form-control"value="" placeholder="Enter Banner Image Alt tag"/>
                                        <p class="form-error-text" id="mobile_image_alt_tag_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="width: 100%;">Is Bookable</label>
                                        <div style="padding: 9px 0;">
                                            <input type="checkbox" name="is_bookable[]" value="0" id="is_bookable">
                                            Book Now
                                            <input type="checkbox" name="is_bookable[]" value="1" id="is_bookable">
                                            Inquiry
                                        </div>
                                        <p class="form-error-text" id="book_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>



                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Inquiry Charge</label>

                                        <input id="charge" name="charge" type="text" class="form-control"
                                            placeholder="Enter Inquiry Charge" value=""
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
                                            class="form-control" placeholder="Enter No Of Inquiry" value=""
                                            onkeypress="return validateNumber(event)" />
                                        <p class="form-error-text" id="inquiry_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Booking Service Percentage</label>
                                        <input id="servicepercentage" name="servicepercentage" type="text"
                                            class="form-control" placeholder="Enter Booking Service Percentage" value=""
                                            onkeypress="return validateNumber(event)" />
                                        <p class="form-error-text" id="servicepercentage_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Additional Charge Popup</label>
                                        <textarea id="additional_charge_popup" name="additional_charge_popup" type="text"
                                            class="form-control" placeholder="Enter Additional Charge Discription" value=""/></textarea>
                                        <p class="form-error-text" id="additional_charge_popup_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Timing Fee Popup</label>
                                        <textarea id="timing_fee_popup" name="timing_fee_popup" type="text"
                                            class="form-control" placeholder="Enter Timing Fee Discription" value=""/></textarea>
                                        <p class="form-error-text" id="timing_fee_popup_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Delivery Charge Popup</label>
                                        <textarea id="delivery_charge_popup" name="delivery_charge_popup" type="text"
                                            class="form-control" placeholder="Enter Delivery Charge Discription" value=""/></textarea>
                                        <p class="form-error-text" id="delivery_charge_popup_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Service fee Popup</label>
                                        <textarea id="service_fee_popup" name="service_fee_popup" type="text"
                                            class="form-control" placeholder="Enter Service Fee Popup Discription" value=""/></textarea>
                                        <p class="form-error-text" id="service_fee_popup_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                
                                <div class="form-group">

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">Cancel Policy Description</label>

                                    <textarea id="cancel_policy" name="cancel_policy" class="form-control" placeholder="Enter Cancel Policy"></textarea>

                                </div>

                                {{-- <div class="form-group">

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">Top
                                        Description</label>

                                    <textarea id="top_description" name="top_description" class="form-control" placeholder="Enter Top Description"></textarea>

                                </div> --}}

                                 <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="city">Local Fields</label>
                                        <select class="form-control" id="form_fields" name="form_fields[]"
                                            multiple="multiple">
                                            <option value="">Select Form Fields</option>
                                            @foreach ($form_field_data as $form_field)
                                                <option value="{{ $form_field->id }}">{{ $form_field->lable_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="form_fields_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="city">International Fields</label>
                                        <select class="form-control" id="form_fields_two" name="form_fields_two[]"
                                            multiple="multiple">
                                            <option value="">Select Form Fields</option>
                                            @foreach ($form_field_data as $form_field)
                                                <option value="{{ $form_field->id }}">{{ $form_field->lable_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="form_fields_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>


                                <div class="form-group">

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">

                                        Description</label>

                                    <textarea id="description" name="description" class="form-control" placeholder="Enter Description"></textarea>

                                </div>

                                
                                <div class="col-lg-6"> 
                                    <div class="form-group">

                                        <label for="name">Service Detail Image (513px x 180px)</label>

                                        <input id="service_detail_image" name="service_detail_image" type="file" class="form-control"value="" />
                                        <p class="form-error-text" id="service_detail_image_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Service Detail Image Alt tag</label>

                                        <input id="service_detail_image_alt_tag" name="service_detail_image_alt_tag" type="text" class="form-control"
                                            value="" placeholder="Service Detail Image Alt tag"/>
                                        <p class="form-error-text" id="service_detail_image_alt_tag_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-lg-12"> 
                                <div class="form-group">
                                    <label for="service_detail_short_description" style="margin:15px 0 5px 0px; width:100%;">Service Detail Short Description</label>
                                    <textarea id="service_detail_short_description" name="service_detail_short_description" class="form-control" placeholder="Enter Service Detail Short Description"></textarea>
                                </div>
                                </div>

                                <div class="col-lg-12"> 
                                <div class="form-group">
                                    <label for="service_detail_popup_description" style="margin:15px 0 5px 0px; width:100%;">Service Detail Description</label>
                                    <textarea id="service_detail_popup_description" name="service_detail_popup_description" class="form-control" placeholder="Enter Service Detail Description"></textarea>
                                </div>
                                </div>

                                <!-- <div class="col-lg-12"> 
                                    <div class="form-group">
                                        <label for="service_detail_popup_description" style="margin:15px 0 5px 0px; width:100%;">Meta Title</label>
                                        <input id="meta_title" name="meta_title" type="text" class="form-control">

                                        
                                    </div>
                                    </div>
                                    <div class="col-lg-12"> 
                                        <div class="form-group">
                                            <label for="service_detail_popup_description" style="margin:15px 0 5px 0px; width:100%;">Meta Keyword</label>
                                            <input id="meta_keyword" name="meta_keyword" type="text" class="form-control">
    
                                            
                                        </div>
                                        </div>
                                        <div class="col-lg-12"> 
                                            <div class="form-group">
                                                <label for="meta_description" style="margin:15px 0 5px 0px; width:100%;">Meta Description</label>
                                                <textarea id="meta_description" name="meta_description" class="form-control" placeholder="Enter Meta Description"></textarea>
                                            </div>
                                            </div> -->

            <div class="row">
                <div class="col-md-12">
                        <h5>Add More Top Description Section</h5>
                        <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9">
                <div class="form-group"> <label for="categoryname">City</label>
                <select class="form-control" id="city_addmore_top_description" name="city_addmore_top_description[]">
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

 <div class="row">
                                      <div class="col-md-12">
                                            <h5>Add More Banners Section</h5>
                                            <hr>
                                      </div>
                                </div>
                                <div class="row">
                                      <div class="col-md-4">
                                        <div class="form-group"> <label for="categoryname">City</label>
                                        <select class="form-control" id="city_addmore_banner" name="city_addmore_banner[]">
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
                                            <input type="text" id="title_addmore_banner" name="title_addmore_banner[]" class="form-control" placeholder="Enter  Title" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group"> <label for="categoryname">Image (2025px X 660px)</label>
                                            <input type="file" id="image" name="image_addmore_banner[]" class="form-control"
                                                placeholder="">
                                        </div>
                                    </div>
                                    
                                <div class="col-lg-4">
                                    <div class="form-group">

                                        <label for="name">Mobile Banner Image (400px x 475px)</label>

                                        <input id="mobile_banner_image_addmore" name="mobile_banner_image_addmore[]" type="file"
                                            class="form-control"value="" />
                                        <p class="form-error-text" id="mobile_banner_image_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                    <div class="col-md-5">
                                        <div class="form-group"> <label for="categoryname">Short Description</label>
                                            <textarea id="description_addmore_banner" name="description_addmore_banner[]" class="form-control"
                                                placeholder="Enter Description"></textarea>
                                        </div>
                                    </div>
                                    

                                </div>
                                <div class="input_fields_wrap">
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button style="border: medium none;margin-right: 0px;line-height: 25px;margin-top: -62px;" class="submit btn bg-purple pull-right" type="button"  id="add_field_button">Add More </button>
                                    </div>
                                </div>
                                
                                
                                
<div class="row">
                                      <div class="col-md-12">
                                            <h5>Add More Content Section</h5>
                                            <hr>
                                      </div>
                                </div>
                                {{-- Packages more Start --}}
                                <div class="row">
                                     <div class="col-md-4">
                                        <div class="form-group"> <label for="categoryname">City</label>
                                        <select class="form-control" id="city_addmore_second" name="city_addmore_second[]">
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

                                            <input type="text" id="title_addmore" name="title_addmore[]"
                                                class="form-control" placeholder="Enter  Title" value="">

                                        </div>

                                    </div>
                                    <div class="col-md-4">

                                        <div class="form-group"> <label for="categoryname">Image (510px X 340px)</label>

                                            <input type="file" id="image" name="image_0" class="form-control"
                                                placeholder="">

                                        </div>

                                    </div>
                                    <div class="col-md-5">

                                        <div class="form-group"> <label for="categoryname">Description</label>

                                            {{-- <input type="text" id="price" name="description_addmore[]"
                                                class="form-control" placeholder="Enter Description"> --}}
                                            <textarea id="description_addmore" name="description_addmore[]" class="form-control"
                                                placeholder="Enter Description"></textarea>


                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> <label for="categoryname">Image Alt tag</label>
                                            <input type="text" id="image_alt_tag_addmore" name="image_alt_tag_addmore[]" class="form-control" placeholder="Enter  Image Alt tag" value="">
                                        </div>
                                    </div>





                                </div>
                                <div class="input_fields_wrap01">

                                </div>

                                <div class="form-group">

                                    <div class="col-sm-12">

                                        <button
                                            style="border: medium none;margin-right: 0px;line-height: 25px;margin-top: -62px;"
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button01">Add More </button>

                                    </div>

                                </div>
                                {{-- Packages more End --}}
                               

 <div class="row">
                                      <div class="col-md-12">
                                            <h5>Add More Meta Section</h5>
                                            <hr>
                                      </div>
                                </div>
                                            <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group"> <label for="categoryname">City</label>
                                        <select class="form-control" id="city_addmore_third" name="city_addmore_third[]">
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
                                            <input type="text" id="meta_title_addmore" name="meta_title_addmore[]" class="form-control"
                                                placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> <label for="categoryname">Meta Keyword</label>
                                            <input type="text" id="meta_keyword_addmore" name="meta_keyword_addmore[]" class="form-control"
                                                placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group"><label for="categoryname">Meta Description</label>
                                            <textarea id="meta_description_addmore" name="meta_description_addmore[]" class="form-control"
                                                placeholder="Enter Meta Description"></textarea>
                                        </div>
                                    </div>
                                  

                                </div>
                                <div class="input_fields_wrap02">
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button style="border: medium none;margin-right: 0px;line-height: 25px;margin-top: -62px;" class="submit btn bg-purple pull-right" type="button"  id="add_field_button02">Add More </button>
                                    </div>
                                </div>


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



            var image = jQuery("#image").val();
            if (image == '') {
                jQuery('#image_error').html("Please Select Image");
                jQuery('#image_error').show().delay(0).fadeIn('show');
                jQuery('#image_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#image').offset().top - 150
                }, 1000);
                return false;
            }
            var mobile_image = jQuery("#mobile_image").val();
            if (mobile_image == '') {
                jQuery('#mobile_image_error').html("Please Select Mobile Image");
                jQuery('#mobile_image_error').show().delay(0).fadeIn('show');
                jQuery('#mobile_image_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#mobile_image').offset().top - 150
                }, 1000);
                return false;
            }
			
            var mobile_banner_image = jQuery("#mobile_banner_image").val();
            if (mobile_banner_image == '') {
                jQuery('#mobile_banner_image_error').html("Please Select Mobile Banner-Image");
                jQuery('#mobile_banner_image_error').show().delay(0).fadeIn('show');
                jQuery('#mobile_banner_image_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#mobile_banner_image').offset().top - 150
                }, 1000);
                return false;
            }

            var banner_image = jQuery("#banner_image").val();
            if (banner_image == '') {
                jQuery('#banner_image_error').html("Please Select Banner-Image");
                jQuery('#banner_image_error').show().delay(0).fadeIn('show');
                jQuery('#banner_image_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#banner_image').offset().top - 150
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
            // var serviceprice = jQuery("#serviceprice").val();
            // if (serviceprice == '') {
            //     jQuery('#serviceprice_error').html("Please Enter  Booking Service Price");
            //     jQuery('#serviceprice_error').show().delay(0).fadeIn('show');
            //     jQuery('#serviceprice_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#serviceprice').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            var additional_charge_popup = jQuery("#additional_charge_popup").val();
            if (additional_charge_popup == '') {
                jQuery('#additional_charge_popup_error').html("Please Enter Additional Charge Popup Discription");
                jQuery('#additional_charge_popup_error').show().delay(0).fadeIn('show');
                jQuery('#additional_charge_popup_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#additional_charge_popup').offset().top - 150
                }, 1000);
                return false;
            }

            var timing_fee_popup = jQuery("#timing_fee_popup").val();
            if (timing_fee_popup == '') {
                jQuery('#timing_fee_popup_error').html("Please Enter Timing fee Popup Discription");
                jQuery('#timing_fee_popup_error').show().delay(0).fadeIn('show');
                jQuery('#timing_fee_popup_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#timing_fee_popup').offset().top - 150
                }, 1000);
                return false;
            }

            var delivery_charge_popup = jQuery("#delivery_charge_popup").val();
            if (delivery_charge_popup == '') {
                jQuery('#delivery_charge_popup_error').html("Please Enter Delivery Charge  Popup Discription");
                jQuery('#delivery_charge_popup_error').show().delay(0).fadeIn('show');
                jQuery('#delivery_charge_popup_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#delivery_charge_popup').offset().top - 150
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
        ClassicEditor.create(document.querySelector('#description_addmore_top_description'), {
            heading: {
                options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
            ]
            }
        }).catch(error => {
            console.error(error);
        });
        ClassicEditor

            .create(document.querySelector('#cancel_policy'))

            .catch(error => {

                console.error(error);

            });
        ClassicEditor

            .create(document.querySelector('#description_addmore'))

            .catch(error => {

                console.error(error);

            });
        ClassicEditor

            .create(document.querySelector('#service_detail_popup_description'))

            .catch(error => {

                console.error(error);

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
    </script>
    <script type="text/javascript" language="javascript">
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
                        '<div class="row"><hr><div class="col-md-4"><div class="form-group"> <label for="categoryname">City</label><select class="form-control" id="city_addmore_banner" name="city_addmore_banner[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Title</label><input type="text" id="title_addmore_banner" name="title_addmore_banner[]" class="form-control" placeholder="Enter  Title" value=""></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Image (2025px X 660px)</label><input type="file" id="image" name="image_addmore_banner[]" class="form-control"placeholder=""></div></div><div class="col-lg-4"><div class="form-group"><label for="name">Mobile Banner Image (400px x 475px)</label><input id="mobile_banner_image" name="mobile_banner_image" type="file"class="form-control"value="" /><p class="form-error-text" id="mobile_banner_image_error"style="color: red; margin-top: 10px;"></p></div></div><div class="col-md-5"><div class="form-group"> <label for="categoryname">Short Description</label><textarea id="description_addmore_banner" name="description_addmore_banner[]" class="form-control"placeholder="Enter Description"></textarea></div></div><a href="#" class="btn btn-danger pull-right remove_field" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
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
                                options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
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
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap01");
            var add_button = $("#add_field_button01");
            var b = 0;

            $(add_button).click(function(e) {
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    var newField = $(
                        '<div class="row"><hr><div class="col-md-4"><div class="form-group"> <label for="categoryname">City</label><select class="form-control" id="city_addmore_second" name="city_addmore_second[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div> <div class="col-md-4"> <div class="form-group"> <label for="categoryname">Title</label>  <input type="text" id="title_addmore" name="title_addmore[]" class="form-control" placeholder="Enter  Title"></div></div><div class="col-md-4"><div class="form-group"><label for="categoryname">Image(510px X 340px)</label><input type="file" id="price" name="image_' +
                        b +
                        '" class="form-control"  placeholder=""> </div></div> <div class="col-md-5"><div class="form-group"><label for="categoryname">Description</label><textarea id="description_addmoree_' +
                        b +
                        '" name="description_addmore[]" class="form-control" placeholder="Enter Description"></textarea></div></div><div class="col-md-4"> <div class="form-group"> <label for="categoryname">Image Alt tag</label>  <input type="text" id="image_alt_tag_addmore" name="image_alt_tag_addmore[]" class="form-control" placeholder="Enter  Image Alt tag"></div></div><a href="#" class="btn btn-danger pull-right remove_field01" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
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



        $("#form_fields").select2({
            placeholder: "Select a Local Fields" // Replace with your desired placeholder text
        });
        $("#form_fields_two").select2({
            placeholder: "Select a International Fields" // Replace with your desired placeholder text
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
                        '<div class="row"><hr><div class="col-md-4"><div class="form-group"> <label for="categoryname">City</label><select class="form-control" id="city" name="city_addmore_third[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Meta Title</label><input type="text" id="meta_title_addmore" name="meta_title_addmore[]" class="form-control" placeholder=""></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Meta Keyword</label><input type="text" id="meta_keyword_addmore" name="meta_keyword_addmore[]" class="form-control"placeholder=""></div></div><div class="col-md-4"><div class="form-group"><label for="categoryname">Meta Description</label><textarea id="meta_description_addmore" name="meta_description_addmore[]" class="form-control"placeholder="Enter Meta Description"></textarea></div></div><a href="#" class="btn btn-danger pull-right remove_field02" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
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
		
		
		function city_change(country_ids) {

				// If multiple countries selected, country_ids will be an array
				$.ajax({
					url: "{{ url('city_show_new') }}",
					type: "POST",
					data: {
						country_id: country_ids,
						"_token": "{{ csrf_token() }}",
					},
					success: function (response) {
						$("#city").empty(); // Remove old options

						$("#city").append(`<option value="">Select City</option>`);

						$.each(response, function (index, city) {
							$("#city").append(`<option value="${city.id}">${city.name}</option>`);
						});
					}
				});
			}
    </script>



@stop
