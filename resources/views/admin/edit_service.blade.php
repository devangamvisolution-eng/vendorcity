@extends('admin.includes.Template')
<style>
    ul li {
        list-style: inherit !important;
    }
</style>
@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Edit Service</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('service.index') }}">Service</a></li>

                        <li class="breadcrumb-item active">Edit Service</li>

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

                        <form id="service_form" action="{{ route('service.update', $service->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            @method('PUT')

                            <div class="row">

                                {{-- <div class="form-group">

                                <label for="name">Group</label>

                                <select name="group_id" id="group_id" class="form-control">

                                    <option value=""> Select Group</option>

                                    @foreach ($all_group as $all_group_data)

                                    <option value="{{ $all_group_data['id'] }}" @if ($all_group_data['id'] == $service->group_id) {{ 'selected' }} @endif>

                                        {{ $all_group_data['name'] }}</option>

                                    @endforeach

                                </select>

                            </div> --}}
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <select class="form-control" id="country" name="country[]"
                                            onchange="city_change($(this).val())" multiple="multiple">
                                            <option value="">Select Country</option>
                                            @php $countryArray = explode(',', $service->country); @endphp@foreach ($country_data as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ in_array($country->id, $countryArray) ? 'selected' : '' }}>
                                                    {{ $country->country }}
                                                </option>
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
                                                    @php $cityname = explode(',', $service->city); @endphp

                                                    @foreach ($allcity as $city)
                                                        <option value="{{ $city->id }}"
                                                            {{ in_array($city->id, $cityname) ? 'selected' : '' }}>
                                                            {{ $city->name }}
                                                        </option>
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

                                        <label for="name">Service Name</label>

                                        <input id="servicename" name="servicename" type="text" class="form-control"
                                            placeholder="Enter Service Name" value="{{ $service->servicename }}" />

                                        <p class="form-error-text" id="service_error" style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Page Url</label>

                                        <input id="page_url" name="page_url" type="text" class="form-control"
                                            placeholder="Enter Page Url" value="{{ $service->page_url }}" />

                                        <p class="form-error-text" id="page_url_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="title1">Home Banner Title 1</label>

                                        <input id="title1" name="title1" type="text" class="form-control"
                                            placeholder="Enter Banner Title 1" value="{{ $service->title1 }}" />

                                        <p class="form-error-text" id="title1_error" style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="title2">Home Banner Title 2</label>

                                        <input id="title2" name="title2" type="text" class="form-control"
                                            placeholder="Enter Banner Title 2" value="{{ $service->title2 }}" />

                                        <p class="form-error-text" id="title2_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="banner_url">Home Banner Url</label>

                                        <input id="banner_url" name="banner_url" type="text" class="form-control"
                                            placeholder="Enter Banner Url" value="{{ $service->banner_url }}" />

                                        <p class="form-error-text" id="banner_url_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        @php
                                            $shortDescription = trim($service->sort_description);
                                        @endphp

                                        <label for="banner_url">Sort Discription</label>
                                        <textarea class="form-control" name="sort_description" id="sort_description" placeholder="Enter Sort Discription">{{ $shortDescription }}
                                        </textarea>

                                        <p class="form-error-text" id="banner_url_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Home Icon </label>

                                        <input id="home_icon" name="home_icon" type="file" class="form-control"
                                            value="" />
                                        @if ($service->home_icon != '')
                                            <img src="{{ asset('public/upload/service/' . $service->home_icon) }}"
                                                style=" width: 10%;margin-top: 10px;" />
                                        @endif
                                        <p class="form-error-text" id="home_icon_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Home Icon Alt tag</label>

                                        <input id="homeicon_alt_tag" name="homeicon_alt_tag" type="text"
                                            class="form-control" value="{{ $service->homeicon_alt_tag }}"
                                            placeholder="Home Icon Alt tag" />
                                        <p class="form-error-text" id="homeicon_alt_tag_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group">

                                        <label for="name">Home Banner (1350px x 440px)</label>

                                        <input id="image" name="image" type="file" class="form-control"
                                            value="" />
                                        @if ($service->image != '')
                                            <img src="{{ asset('public/upload/service/large/' . $service->image) }}"
                                                style=" width: 10%;margin-top: 10px;" />
                                        @endif
                                        <p class="form-error-text" id="image_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Home Banner Alt tag</label>

                                        <input id="homebanner_alt_tag" name="homebanner_alt_tag" type="text"
                                            class="form-control" value="{{ $service->homebanner_alt_tag }}"
                                            placeholder="Home Banner Alt tag" />
                                        <p class="form-error-text" id="homebanner_alt_tag_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="banner">Home Mobile Banner (400px x 475px)</label>

                                        <input id="banner" name="banner" type="file" class="form-control"
                                            value="" />
                                        @if ($service->banner != '')
                                            <img src="{{ asset('public/upload/service/banner/large/' . $service->banner) }}"
                                                style=" width: 10%;margin-top: 10px;" />
                                        @endif
                                        <p class="form-error-text" id="banner_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>





                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Home Mobile Banner Alt tag</label>

                                        <input id="homebanner_mobile_alt_tag" name="homebanner_mobile_alt_tag"
                                            type="text" class="form-control"
                                            value="{{ $service->homebanner_mobile_alt_tag }}"
                                            placeholder="Home Mobile Banner Alt tag" />
                                        <p class="form-error-text" id="homebanner_mobile_alt_tag_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">App Icon </label>

                                        <input id="app_icon" name="app_icon" type="file" class="form-control"
                                            value="" />
                                        @if ($service->app_icon != '')
                                            <img src="{{ asset('public/upload/service/' . $service->app_icon) }}"
                                                style=" width: 10%;margin-top: 10px;" />
                                        @endif
                                        <p class="form-error-text" id="app_icon_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">App Icon Alt tag</label>

                                        <input id="appicon_alt_tag" name="appicon_alt_tag" type="text"
                                            class="form-control" value="{{ $service->appicon_alt_tag }}"
                                            placeholder="App Icon Alt tag" />
                                        <p class="form-error-text" id="appicon_alt_tag_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                {{-- <div class="form-group">

                                <label for="description" style="margin:15px 0 5px 0px; width:100%;">Top
                                    Description</label>

                                <textarea id="top_description" name="top_description" class="form-control"
                                    placeholder="Enter Top Description">
                                        {{$service->top_description}}
                                    </textarea>

                            </div> --}}

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="title">Banner Title</label>

                                        <input id="title" name="title" type="text" class="form-control"
                                            placeholder="Enter Banner Title" value="{{ $service->title }}" />

                                        <p class="form-error-text" id="title_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="sub_title">Banner Sub-title</label>

                                        <input id="sub_title" name="sub_title" type="text" class="form-control"
                                            placeholder="Enter Banner Sub-title" value="{{ $service->sub_title }}" />

                                        <p class="form-error-text" id="sub_title_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>



                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="city">Local Fields</label>
                                        <select class="form-control" id="form_fields" name="form_fields[]"
                                            multiple="multiple">
                                            <option value="">Select Form Fields</option>
                                            @if ($form_field_data != '' && count($form_field_data) > 0)
                                                @php $mucraft = explode(',', $service->form_fields); @endphp
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
                                                @php $mucraft = explode(',', $service->form_fields_two); @endphp
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

                                <div class="form-group">

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">Scope Of
                                        Job</label>

                                    <textarea id="scope_of_job" name="scope_of_job" class="form-control" placeholder="Enter Scope Of Job">{{ $service->scope_of_job }}</textarea>

                                </div>

                                <div class="form-group">

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">Price
                                        Includes</label>

                                    <textarea id="price_includes" name="price_includes" class="form-control" placeholder="Enter Price Includes">{{ $service->price_includes }}</textarea>

                                </div>

                                <div class="form-group">

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">Price
                                        Excludes</label>

                                    <textarea id="price_excludes" name="price_excludes" class="form-control" placeholder="Enter Price Excludes">{{ $service->price_excludes }}</textarea>

                                </div>
                                <div class="form-group">

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">Disclaimer</label>

                                    <textarea id="disclaimer" name="disclaimer" class="form-control" placeholder="Enter Disclaimer">{{ $service->disclaimer }}</textarea>

                                </div>
                                <div class="form-group">

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">Insurance</label>

                                    <textarea id="insurance" name="insurance" class="form-control" placeholder="Enter Insurance">{{ $service->insurance }}</textarea>

                                </div>
                                <div class="form-group">

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">Payment
                                        Terms</label>

                                    <textarea id="payment_terms" name="payment_terms" class="form-control" placeholder="Enter Payment Terms">{{ $service->payment_terms }}</textarea>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Add More Top Description Section</h5>
                                        <hr>
                                    </div>
                                </div>

                                @if ($service_top_description_attr != '')
                                    <input type="hidden" name="city_addmore_top_description[]" value="">


                                    <input type="hidden" name="description_addmore_top_description[]" value="">



                                    @for ($i = 0; $i < count($service_top_description_attr); $i++)
                                        <div class="row">
                                            @if ($i != 0)
                                                <hr>
                                            @endif
                                            <input type="hidden" name="updateid1xxx1_top_description[]"
                                                id="updateid1xxx1{{ $i + 1 }}"
                                                value="{{ $service_top_description_attr[$i]->id }}">

                                            <div class="col-md-9">
                                                <div class="form-group"> <label for="categoryname">City</label>
                                                    <select class="form-control" id="city_addmore_top_descriptionu"
                                                        name="city_addmore_top_descriptionu[]">
                                                        <option value="">Select City</option>
                                                        @foreach ($allcity as $data)
                                                            <option value="{{ $data->id }}"
                                                                @if ($data->id == $service_top_description_attr[$i]->city) selected @endif>
                                                                {{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="col-md-9">

                                                <div class="form-group"> <label for="categoryname">Description</label>



                                                    <textarea id="description_addmore_top_descriptionu_{{ $service_top_description_attr[$i]->id }}"
                                                        name="description_addmore_top_descriptionu[]" class="form-control" placeholder="Enter Description">{{ $service_top_description_attr[$i]->description }}</textarea>



                                                </div>

                                            </div>



                                            <a href="#"
                                                onclick="singledelete('{{ route('service_removed_top_descatt', ['pid' => $service_top_description_attr[$i]->service_id, 'id' => $service_top_description_attr[$i]->id]) }}')"
                                                class="btn btn-danger pull-right remove_field12"
                                                style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a>

                                        </div>
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


                                @php
                                    $k = 0;
                                @endphp





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

                                                    <input id="mobile_banner_image_addmore"
                                                        name="mobile_banner_image_addmoreu[]" type="file"
                                                        class="form-control" value="" />
                                                    <img src="{{ url('public/upload/service/banner_attr/large/' . $banner_attribute_data[$i]->mobile_banner_image) }}"
                                                        style="width:35%;">
                                                    <p class="form-error-text" id="mobile_banner_image_error"
                                                        style="color: red; margin-top: 10px;">
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group"> <label for="categoryname">Description</label>
                                                    {{-- <input type="text" id="description_addmore1" name="description_addmore1[]"
                                                    class="form-control" placeholder="Enter Description"> --}}
                                                    <textarea id="description_addmoreu_{{ $banner_attribute_data[$i]->id }}" name="description_addmore_banneru[]"
                                                        class="form-control" placeholder="Enter Description">{{ $banner_attribute_data[$i]->short_description }}</textarea>

                                                </div>
                                            </div>



                                            <a href="#"
                                                onclick="singledeletebannerattr('{{ route('removed_banner_addmore_att', ['pid' => $banner_attribute_data[$i]->service_id, 'id' => $banner_attribute_data[$i]->id]) }}')"
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
                                                    class="form-control" value="" />
                                                <p class="form-error-text" id="ombile_banner_image_error"
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
                                            id="add_field_button">Add
                                            More </button>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Add More Content Section</h5>
                                        <hr>
                                    </div>
                                </div>




                                @php
                                    $k = 0;
                                @endphp



                                @if (!empty($package_attribute_data))
                                    <input type="hidden" name="title_addmore1[]" value="">
                                    <input type="hidden" name="image_alt_tag_addmore1[]" value="">

                                    <input type="file" name="image_addmore1[]" value="" style="display: none;">

                                    <input type="hidden" name="description_addmore1[]" value="">
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
                                                    <select class="form-control" id="city_addmore_second"
                                                        name="city_addmore_secondu[]">
                                                        <option value="">Select City</option>
                                                        @foreach ($allcity as $data)
                                                            <option value="{{ $data->id }}"
                                                                {{ $data->id == $package_attribute_data[$i]->city ? 'selected' : '' }}>
                                                                {{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">

                                                <div class="form-group"> <label for="categoryname">Title</label>
                                                    <input type="text" id="title_addmoreu" name="title_addmoreu[]"
                                                        class="form-control" placeholder="Enter  Title"
                                                        value="{{ $package_attribute_data[$i]->title_addmore }}">
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="categoryname">image</label>
                                                    <input type="file" id="image" name="image_addmore1u[]"
                                                        class="form-control">

                                                    <img src="{{ url('public/upload/service/service_attr/large/' . $package_attribute_data[$i]->image) }}"
                                                        style="width:35%;">

                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group"> <label for="categoryname">Description</label>
                                                    {{-- <input type="text" id="description_addmore1" name="description_addmore1[]"
                                                    class="form-control" placeholder="Enter Description"> --}}
                                                    <textarea id="description_addmoreu_{{ $package_attribute_data[$i]->id }}" name="description_addmoreu[]"
                                                        class="form-control" placeholder="Enter Description">{{ $package_attribute_data[$i]->description_addmore }}</textarea>

                                                </div>
                                            </div>

                                            <div class="col-md-4">

                                                <div class="form-group"> <label for="categoryname">Image Alt tag</label>
                                                    <input type="text" id="image_alt_tag_addmoreu"
                                                        name="image_alt_tag_addmoreu[]" class="form-control"
                                                        placeholder="Enter  Image Alt tag"
                                                        value="{{ $package_attribute_data[$i]->image_alt_tag }}">
                                                </div>

                                            </div>

                                            <a href="#"
                                                onclick="singledelete('{{ route('removed_service_addmore_att', ['pid' => $package_attribute_data[$i]->pid, 'id' => $package_attribute_data[$i]->id]) }}')"
                                                class="btn btn-danger pull-right remove_field1"
                                                style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a>
                                        </div>
                                        @php
                                            $k++;
                                        @endphp
                                    @endfor
                                @else
                                    <input type="file" name="e_image1_0" value="" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group"> <label for="categoryname">City</label>
                                                <select class="form-control" id="city_addmore_second"
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
                                                <input type="file" id="image1" name="image_addmore1[]"
                                                    class="form-control">

                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group"> <label for="categoryname">Description</label>
                                                {{-- <input type="text" id="description_addmore1" name="description_addmore1[]"
                                                class="form-control" placeholder="Enter Description"> --}}
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



                                @php
                                    $k = 0;
                                @endphp

                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Add More Meta Section</h5>
                                        <hr>
                                    </div>
                                </div>



                                @if (!empty($service_contains_data))

                                    <input type="hidden" name="city_addmore_third1[]" value="">
                                    <input type="hidden" name="meta_title1[]" value="">
                                    <input type="hidden" name="meta_keyword1[]" value="">
                                    <input type="hidden" name="meta_description1[]" value="">
                                    @for ($i = 0; $i < count($service_contains_data); $i++)
                                        <div class="row">
                                            @if ($i != 0)
                                                <hr>
                                            @endif
                                            <input type="hidden" name="updateid1xxx2[]"
                                                id="updateid1xxx2{{ $i + 1 }}"
                                                value="{{ $service_contains_data[$i]->id }}">

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="categoryname">City</label>
                                                    <select class="form-control" id="city_addmore_thirdu"
                                                        name="city_addmore_thirdu[]">
                                                        <option value="">Select City</option>
                                                        @foreach ($allcity as $data)
                                                            <option value="{{ $data->id }}"
                                                                @if ($data->id == $service_contains_data[$i]->city) selected @endif>
                                                                {{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="categoryname">Meta Title</label>
                                                    <input type="text" id="meta_title" name="meta_titleu[]"
                                                        class="form-control" placeholder=""
                                                        value="{{ $service_contains_data[$i]->meta_title }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="categoryname">Meta Keyword</label>
                                                    <input type="text" id="meta_keyword" name="meta_keywordu[]"
                                                        class="form-control" placeholder=""
                                                        value="{{ $service_contains_data[$i]->meta_keyword }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group"><label for="categoryname">Meta Description</label>
                                                    <textarea id="meta_description" name="meta_descriptionu[]" class="form-control"
                                                        placeholder="Enter Meta Description">{{ $service_contains_data[$i]->meta_description }}</textarea>
                                                </div>
                                            </div>
                                            <a href="#"
                                                onclick="singledeleteattr('{{ route('removed_service_contain_att', ['pid' => $service_contains_data[$i]->service_id, 'id' => $service_contains_data[$i]->id]) }}')"
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
                                                <input type="text" id="meta_title" name="meta_title1[]"
                                                    class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group"> <label for="categoryname">Meta Keyword</label>
                                                <input type="text" id="meta_keyword" name="meta_keyword1[]"
                                                    class="form-control" placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group"><label for="categoryname">Meta Description</label>
                                                <textarea id="meta_description" name="meta_description1[]" class="form-control"
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







                            </div>

                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('service.index') }}"> Cancel</a>

                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>

                                    Loading...

                                </button>



                                <button type="button" class="btn btn-primary" id="submit_button"
                                    onclick="javascript:service_validation()">Submit</button>

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

    <script src="{{ asset('public/admin/assets/ckeditor/build/ckeditor.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>



    <script>
        ClassicEditor

            .create(document.querySelector('#banner_description'))

            .catch(error => {

                console.error(error);

            });

        ClassicEditor
            .create(document.querySelector('#top_description'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}"
                }
            })
            .catch(error => {
                console.error(error);
            });


        $("#form_fields").select2({
            placeholder: "Select a Local Fields" // Replace with your desired placeholder text
        });
        $("#form_fields_two").select2({
            placeholder: "Select a International Fields" // Replace with your desired placeholder text
        });
        $("#country").select2({
            placeholder: "Select a Country" // Replace with your desired placeholder text
        });

        ClassicEditor
            .create(document.querySelector('#scope_of_job'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}"
                }
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#price_includes'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}"
                }
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#price_excludes'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}"
                }
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#disclaimer'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}"
                }
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#insurance'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}"
                }
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#payment_terms'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}"
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>



    <script>
        $(function() {

            $("#servicename").keyup(function() {

                var Text = $(this).val();

                Text = Text.toLowerCase();

                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');

                $("#page_url").val(Text);

            });

        });

        function singledelete(url) {
            var t = confirm('Are You Sure To Delete The Attribute ?');

            if (t) {

                window.location.href = url;

            } else {

                return false;

            }


        }

        function singledeleteattr(url) {
            var t = confirm('Are You Sure To Delete The Service Contain Attribute ?');

            if (t) {

                window.location.href = url;

            } else {

                return false;

            }


        }

        function singledeletebannerattr(url) {
            var t = confirm('Are You Sure To Delete The Banner Contain Attribute ?');

            if (t) {

                window.location.href = url;

            } else {

                return false;

            }


        }

        function service_validation() {

            var country = jQuery("#country").val();

            if (country == '') {
                jQuery('#country_error').html("Please Select Country");
                jQuery('#country_error').show().delay(0).fadeIn('show');
                jQuery('#country_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#country').offset().top - 150
                }, 1000);
                return false;
            }

            var servicename = jQuery("#servicename").val();

            if (servicename == '') {
                jQuery('#service_error').html("Please Enter Service Name");
                jQuery('#service_error').show().delay(0).fadeIn('show');
                jQuery('#service_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#servicename').offset().top - 150
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



            $('#spinner_button').show();

            $('#submit_button').hide();



            $('#service_form').submit();

        }


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

        // function city_change(country_ids) {

        // 	// If multiple countries selected, country_ids will be an array
        // 	$.ajax({
        // 		url: "{{ url('city_show_new') }}",
        // 		type: "POST",
        // 		data: {
        // 			country_id: country_ids,
        // 			"_token": "{{ csrf_token() }}",
        // 		},
        // 		success: function (response) {
        // 			$("#city").empty(); // Remove old options

        // 			$("#city").append(`<option value="">Select City</option>`);

        // 			$.each(response, function (index, city) {
        // 				$("#city").append(`<option value="${city.id}">${city.name}</option>`);
        // 			});
        // 		}
        // 	});
        // }

        $("#city").select2({
            placeholder: "Select a City" // Replace with your desired placeholder text
        });

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
                        '<div class="row"><hr><div class="col-md-4"><div class="form-group"> <label for="categoryname">City</label><select class="form-control" id="city_addmore_banner" name="city_addmore_banner1[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Title</label><input type="text" id="title_addmore_banner" name="title_addmore_banner1[]" class="form-control" placeholder="Enter  Title" value=""></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Image (2025px X 660px)</label><input type="file" id="image" name="image_addmore_banner1[]" class="form-control"placeholder=""></div></div><div class="col-lg-4"><div class="form-group"><label for="name">Mobile Banner Image (400px x 475px)</label><input id="mobile_banner_image_addmore" name="mobile_banner_image_addmore1[]" type="file" class="form-control" value="" /><p class="form-error-text" id="ombile_banner_image_error"style="color: red; margin-top: 10px;"></p></div></div><div class="col-md-5"><div class="form-group"> <label for="categoryname">Short Description</label><textarea id="description_addmore_banner" name="description_addmore_banner1[]" class="form-control"placeholder="Enter Description"></textarea></div></div><a href="#" class="btn btn-danger pull-right remove_field" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
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
            var b = 1;

            $(add_button).click(function(e) {
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    var newField = $(
                        '<div class="row"><hr><div class="col-md-4"><div class="form-group"> <label for="categoryname">City</label> <select class="form-control" id="city_addmore_second" name="city_addmore_second1[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div> <div class="col-md-4"> <div class="form-group"> <label for="categoryname">Title</label>  <input type="text" id="title_addmore" name="title_addmore1[]" class="form-control" placeholder="Enter  Title"></div></div><div class="col-md-4"><div class="form-group"><label for="categoryname">Image(510px X 340px)</label><input type="file" id="price" name="image_addmore1[]" class="form-control"  placeholder=""> </div></div> <div class="col-md-5"><div class="form-group"><label for="categoryname">Description</label><textarea id="description_addmoree_' +
                        b +
                        '" name="description_addmore1[]" class="form-control" placeholder="Enter Description"></textarea></div></div><div class="col-md-4"> <div class="form-group"> <label for="categoryname">Title</label>  <input type="text" id="title_addmore" name="image_alt_tag_addmore1[]" class="form-control" placeholder="Enter  Image Alt tag"></div></div><a href="#" class="btn btn-danger pull-right remove_field01" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
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

        // function onPageLoad() {
        //     city_change('{{ $service->country }}');
        //     // Your code here
        // }

        // window.onload = onPageLoad;
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
                        '<div class="row"><hr><div class="col-md-4"><div class="form-group"> <label for="categoryname">City</label><select class="form-control" id="city_addmore_third1" name="city_addmore_third1[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Meta Title</label><input type="text" id="meta_title" name="meta_title1[]" class="form-control" placeholder=""></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Meta Keyword</label><input type="text" id="meta_keyword" name="meta_keyword1[]" class="form-control"placeholder=""></div></div><div class="col-md-4"><div class="form-group"><label for="categoryname">Meta Description</label><textarea id="meta_description" name="meta_description1[]" class="form-control"placeholder="Enter Meta Description"></textarea></div></div><a href="#" class="btn btn-danger pull-right remove_field02" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
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
                    },
                    {
                        model: 'heading3',
                        view: 'h3',
                        title: 'Heading 3',
                        class: 'ck-heading_heading3'
                    },
                    {
                        model: 'heading4',
                        view: 'h4',
                        title: 'Heading 4',
                        class: 'ck-heading_heading4'
                    },
                    {
                        model: 'heading5',
                        view: 'h5',
                        title: 'Heading 5',
                        class: 'ck-heading_heading5'
                    },
                    {
                        model: 'heading6',
                        view: 'h6',
                        title: 'Heading 6',
                        class: 'ck-heading_heading6'
                    }
                ]
            }
        }).catch(error => {
            console.error(error);
        });

        @for ($i = 0; $i < count($service_top_description_attr); $i++)


            ClassicEditor.create(document.querySelector(
                '#description_addmore_top_descriptionu_{{ $service_top_description_attr[$i]->id }}'), {
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
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3'
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Heading 4',
                            class: 'ck-heading_heading4'
                        },
                        {
                            model: 'heading5',
                            view: 'h5',
                            title: 'Heading 5',
                            class: 'ck-heading_heading5'
                        },
                        {
                            model: 'heading6',
                            view: 'h6',
                            title: 'Heading 6',
                            class: 'ck-heading_heading6'
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
                                    },
                                    {
                                        model: 'heading3',
                                        view: 'h3',
                                        title: 'Heading 3',
                                        class: 'ck-heading_heading3'
                                    },
                                    {
                                        model: 'heading4',
                                        view: 'h4',
                                        title: 'Heading 4',
                                        class: 'ck-heading_heading4'
                                    },
                                    {
                                        model: 'heading5',
                                        view: 'h5',
                                        title: 'Heading 5',
                                        class: 'ck-heading_heading5'
                                    },
                                    {
                                        model: 'heading6',
                                        view: 'h6',
                                        title: 'Heading 6',
                                        class: 'ck-heading_heading6'
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
    </script>



@stop
