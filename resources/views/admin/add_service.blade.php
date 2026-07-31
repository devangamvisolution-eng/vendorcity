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

                    <h3 class="page-title">Service</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('service.index') }}">Service</a></li>

                        <li class="breadcrumb-item active">Add Service</li>

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

                        <form id="service_form" action="{{ route('service.store') }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <select class="form-control search_country" id="country" name="country[]"
                                            onchange="city_change($(this).val())" multiple="multiple">
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
                                        <p class="form-error-text" id="city_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Service Name</label>

                                        <input id="servicename" name="servicename" type="text" class="form-control"
                                            placeholder="Enter Service Name" />

                                        <p class="form-error-text" id="service_error" style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Page Url</label>

                                        <input id="page_url" name="page_url" type="text" class="form-control"
                                            placeholder="Enter Page Url" value="" />

                                        <p class="form-error-text" id="page_url_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="title1">Home Banner Title 1</label>

                                        <input id="title1" name="title1" type="text" class="form-control"
                                            placeholder="Enter Home Banner Title 1" value="" />

                                        <p class="form-error-text" id="title1_error" style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="title2">Home Banner Title 2</label>

                                        <input id="title2" name="title2" type="text" class="form-control"
                                            placeholder="Enter Home Banner Title 2" value="" />

                                        <p class="form-error-text" id="title2_error" style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="banner_url">Home Banner Url</label>

                                        <input id="banner_url" name="banner_url" type="text" class="form-control"
                                            placeholder="Enter Home Banner Url" value="" />

                                        <p class="form-error-text" id="banner_url_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="banner_url">Short Discription</label>
                                        <textarea class="form-control" name="sort_description" id="sort_description" placeholder="Enter Sort Discription"></textarea>

                                        <p class="form-error-text" id="banner_url_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Home Icon </label>

                                        <input id="home_icon" name="home_icon" type="file" class="form-control"
                                            value="" />
                                        <p class="form-error-text" id="home_icon_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Home Icon Alt tag</label>

                                        <input id="homeicon_alt_tag" name="homeicon_alt_tag" type="text"
                                            class="form-control" value="" placeholder="Home Icon Alt tag" />
                                        <p class="form-error-text" id="homeicon_alt_tag_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Home Banner (1350px x 440px)</label>

                                        <input id="image" name="image" type="file" class="form-control"
                                            value="" />
                                        <p class="form-error-text" id="image_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Home Banner Alt tag</label>

                                        <input id="homebanner_alt_tag" name="homebanner_alt_tag" type="text"
                                            class="form-control" value="" placeholder="Home Banner Alt tag" />
                                        <p class="form-error-text" id="homebanner_alt_tag_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="banner">Home Mobile Banner (400 x 475)</label>

                                        <input id="banner" name="banner" type="file" class="form-control"
                                            value="" />
                                        <p class="form-error-text" id="banner_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>




                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">Home Mobile Banner Alt tag</label>

                                        <input id="homebanner_mobile_alt_tag" name="homebanner_mobile_alt_tag"
                                            type="text" class="form-control" value=""
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
                                        <p class="form-error-text" id="app_icon_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="name">App Icon Alt tag</label>

                                        <input id="appicon_alt_tag" name="appicon_alt_tag" type="text"
                                            class="form-control" value="" placeholder="App Icon Alt tag" />
                                        <p class="form-error-text" id="appicon_alt_tag_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                {{-- <div class="form-group">

                                <label for="description" style="margin:15px 0 5px 0px; width:100%;">Top
                                    Description</label>

                                <textarea id="top_description" name="top_description" class="form-control"
                                    placeholder="Enter Top Description"></textarea>

                            </div> --}}

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="title">Banner Title</label>

                                        <input id="title" name="title" type="text" class="form-control"
                                            placeholder="Enter Banner Title" value="" />

                                        <p class="form-error-text" id="title_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label for="sub_title">Banner Sub-title</label>

                                        <input id="sub_title" name="sub_title" type="text" class="form-control"
                                            placeholder="Enter Banner Sub-title" value="" />

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

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">Scope Of
                                        Job</label>

                                    <textarea id="scope_of_job" name="scope_of_job" class="form-control" placeholder="Enter Scope Of Job"></textarea>

                                </div>

                                <div class="form-group">

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">Price
                                        Includes</label>

                                    <textarea id="price_includes" name="price_includes" class="form-control" placeholder="Enter Price Includes"></textarea>

                                </div>

                                <div class="form-group">

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">Price
                                        Excludes</label>

                                    <textarea id="price_excludes" name="price_excludes" class="form-control" placeholder="Enter Price Excludes"></textarea>

                                </div>
                                <div class="form-group">

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">Disclaimer</label>

                                    <textarea id="disclaimer" name="disclaimer" class="form-control" placeholder="Enter Disclaimer"></textarea>

                                </div>
                                <div class="form-group">

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">Insurance</label>

                                    <textarea id="insurance" name="insurance" class="form-control" placeholder="Enter Insurance"></textarea>

                                </div>
                                <div class="form-group">

                                    <label for="description" style="margin:15px 0 5px 0px; width:100%;">Payment
                                        Terms</label>

                                    <textarea id="payment_terms" name="payment_terms" class="form-control" placeholder="Enter Payment Terms"></textarea>

                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Add More Top Description Section</h5>
                                        <hr>
                                    </div>
                                </div>

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


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group"> <label for="categoryname">City</label>
                                            <select class="form-control" id="city_addmore_banner"
                                                name="city_addmore_banner[]">
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
                                            <input type="text" id="title_addmore_banner" name="title_addmore_banner[]"
                                                class="form-control" placeholder="Enter  Title" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group"> <label for="categoryname">Image (2025px X 660px)</label>
                                            <input type="file" id="image" name="image_addmore_banner[]"
                                                class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">

                                            <label for="name">Mobile Banner Image (400px x 475px)</label>

                                            <input id="mobile_banner_image_addmore" name="mobile_banner_image_addmore[]"
                                                type="file" class="form-control" value="" />
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

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group"> <label for="categoryname">City</label>
                                            <select class="form-control" id="city_addmore_second"
                                                name="city_addmore_second[]">
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
                                            <textarea id="description_addmore" name="description_addmore[]" class="form-control"
                                                placeholder="Enter Description"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> <label for="categoryname">Image Alt tag</label>
                                            <input type="text" id="image_alt_tag_addmore"
                                                name="image_alt_tag_addmore[]" class="form-control"
                                                placeholder="Enter  Image Alt tag" value="">
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


                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Add More Meta Section</h5>
                                        <hr>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group"> <label for="categoryname">City</label>
                                            <select class="form-control" id="city_addmore_third"
                                                name="city_addmore_third[]">
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
                                            <input type="text" id="meta_title" name="meta_title[]"
                                                class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> <label for="categoryname">Meta Keyword</label>
                                            <input type="text" id="meta_keyword" name="meta_keyword[]"
                                                class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group"><label for="categoryname">Meta Description</label>
                                            <textarea id="meta_description" name="meta_description[]" class="form-control" placeholder="Enter Meta Description"></textarea>
                                        </div>
                                    </div>


                                </div>
                                <div class="input_fields_wrap02">
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button
                                            style="border: medium none;margin-right: 0px;line-height: 25px;margin-top: -62px;"
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


        ClassicEditor

            .create(document.querySelector('#description_addmore'))

            .catch(error => {

                console.error(error);

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
                        '<div class="row"><hr><div class="col-md-4"><div class="form-group"> <label for="categoryname">City</label><select class="form-control" id="city_addmore_banner" name="city_addmore_banner[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Title</label><input type="text" id="title_addmore_banner" name="title_addmore_banner[]" class="form-control" placeholder="Enter  Title" value=""></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Image (2025px X 660px)</label><input type="file" id="image" name="image_addmore_banner[]" class="form-control"placeholder=""></div></div><div class="col-lg-4"><div class="form-group"><label for="name">Mobile Banner Image (400px x 475px)</label><input id="mobile_banner_image_addmore" name="mobile_banner_image_addmore[]" type="file"class="form-control"value="" /><p class="form-error-text" id="mobile_banner_image_error"style="color: red; margin-top: 10px;"></p></div></div><div class="col-md-5"><div class="form-group"> <label for="categoryname">Short Description</label><textarea id="description_addmore_banner" name="description_addmore_banner[]" class="form-control"placeholder="Enter Description"></textarea></div></div><a href="#" class="btn btn-danger pull-right remove_field" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
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
                        '<div class="row"><hr><div class="col-md-4"><div class="form-group"> <label for="categoryname">City</label><select class="form-control" id="city_addmore_second" name="city_addmore_second[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div><div class="col-md-4"> <div class="form-group"> <label for="categoryname">Title</label>  <input type="text" id="title_addmore" name="title_addmore[]" class="form-control" placeholder="Enter  Title"></div></div><div class="col-md-4"><div class="form-group"><label for="categoryname">Image(510px X 340px)</label><input type="file" id="price" name="image_' +
                        b +
                        '" class="form-control"  placeholder=""> </div></div> <div class="col-md-5"><div class="form-group"><label for="categoryname">Description</label><textarea id="description_addmoree_' +
                        b +
                        '" name="description_addmore[]" class="form-control" placeholder="Enter Description"></textarea></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Image Alt tag</label>                                           <input type="text" id="image_alt_tag_addmore" name="image_alt_tag_addmore[]" class="form-control" placeholder="Enter  Image Alt tag" value=""> </div></div><a href="#" class="btn btn-danger pull-right remove_field01" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
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
                        '<div class="row"><hr><div class="col-md-4"><div class="form-group"> <label for="categoryname">City</label><select class="form-control" id="city_addmore_third" name="city_addmore_third[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Meta Title</label><input type="text" id="meta_title" name="meta_title[]" class="form-control" placeholder=""></div></div><div class="col-md-4"><div class="form-group"> <label for="categoryname">Meta Keyword</label><input type="text" id="meta_keyword" name="meta_keyword[]" class="form-control"placeholder=""></div></div><div class="col-md-4"><div class="form-group"><label for="categoryname">Meta Description</label><textarea id="meta_description" name="meta_description[]" class="form-control"placeholder="Enter Meta Description"></textarea></div></div><a href="#" class="btn btn-danger pull-right remove_field02" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'
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

        $("#form_fields").select2({
            placeholder: "Select a Local Fields" // Replace with your desired placeholder text
        });
        $("#form_fields_two").select2({
            placeholder: "Select a International Fields" // Replace with your desired placeholder text
        });

        $("#country").select2({
            placeholder: "Select a Country" // Replace with your desired placeholder text
        });




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

            // var image = jQuery("#image").val();
            // if (image == '') {
            //     jQuery('#image_error').html("Please Select Banner");
            //     jQuery('#image_error').show().delay(0).fadeIn('show');
            //     jQuery('#image_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#image').offset().top - 150
            //     }, 1000);
            //     return false;
            // }

            $('#spinner_button').show();

            $('#submit_button').hide();



            $('#service_form').submit();



        }
        /* function city_change(country_id) {
                        alert(country_id);
        				return false; 
                       //var url = '{{ url('city_show_new') }}';
            // alert(url);
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "country_id": country_id
                },
                success: function (msg) {
                    document.getElementById('city_chang').innerHTML = msg;
                    $("#city").select2({
                        placeholder: "Select a City" // Replace with your desired placeholder text
                    });
                }
            });
                   } */

        function city_change(country_ids) {

            // If multiple countries selected, country_ids will be an array
            $.ajax({
                url: "{{ url('city_show_new') }}",
                type: "POST",
                data: {
                    country_id: country_ids,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    $("#city").empty(); // Remove old options

                    $("#city").append(`<option value="">Select City</option>`);

                    $.each(response, function(index, city) {
                        $("#city").append(`<option value="${city.id}">${city.name}</option>`);
                    });
                }
            });
        }
        $("#city").select2({
            placeholder: "Select a City" // Replace with your desired placeholder text
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
    <script>
        $(document).ready(function() {
            $('.search_country').select2();
        });
    </script>


@stop
