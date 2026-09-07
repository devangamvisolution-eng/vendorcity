@extends('admin.includes.Template')
<style>
    ul li {
        list-style: inherit !important;
    }

    .service-form-wrapper {
        max-width: 1400px;
        margin: auto;
        padding: 16px 20px;
        background: #f6f7f9;
        /* Outer background */
    }

    .compact-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 16px 20px;
        margin-bottom: 16px;
        box-shadow: none;
    }

    .compact-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 12px;
        margin-bottom: 16px;
        border-bottom: 1px solid #e5e7eb;
    }

    .compact-header h5 {
        font-size: 15px;
        font-weight: 600;
        margin: 0;
        color: #1f2937;
    }

    .compact-header h5 i {
        font-size: 14px;
        margin-right: 6px;
    }

    .service-form-wrapper label {
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 4px;
        color: #4b5563;
    }

    .service-form-wrapper .form-control {
        height: 38px;
        font-size: 13px;
        border: 1px solid #e2e5ea;
        border-radius: 6px;
        padding: 6px 12px;
    }

    .service-form-wrapper .form-control:focus {
        border-color: #6777ef;
        box-shadow: 0 0 0 2px rgba(103, 119, 239, 0.08);
    }

    .service-form-wrapper .form-group {
        margin-bottom: 12px;
    }

    .service-form-wrapper .select2-container .select2-selection--single {
        height: 38px;
        border: 1px solid #e2e5ea;
        border-radius: 6px;
    }

    .service-form-wrapper .select2-container .select2-selection--multiple {
        min-height: 38px;
        border: 1px solid #e2e5ea;
        border-radius: 6px;
    }

    .ck-editor__editable {
        min-height: 120px !important;
        max-height: 200px !important;
        font-size: 13px;
    }

    .sticky-action-bar {
        position: sticky;
        bottom: 0;
        background: #fff;
        border-top: 1px solid #e5e7eb;
        padding: 12px 20px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        z-index: 1000;
        box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.02);
    }

    .sticky-action-bar .btn {
        font-size: 13px;
        padding: 8px 16px;
        height: 38px;
        margin-left: 10px;
        border-radius: 6px;
    }

    .page-title-compact {
        font-size: 20px;
        font-weight: 600;
        margin: 0;
    }

    .breadcrumb-compact {
        background: transparent;
        padding: 0;
        margin: 0 0 0 15px;
        font-size: 12px;
    }
</style>
@section('content')

    <div class="content container-fluid service-form-wrapper">

        <!-- Compact Page Header -->
        <div class="d-flex align-items-center mb-3">
            <h3 class="page-title-compact">Add Service</h3>
            <ul class="breadcrumb breadcrumb-compact">
                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('service.index') }}">Service</a></li>
                <li class="breadcrumb-item active">Add Service</li>
            </ul>
        </div>

        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <form id="service_form" action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="compact-card">
                <div class="compact-header">
                    <h5><i class="fa fa-info-circle me-2" style="color: #6777ef;"></i> Basic & Other Information</h5>
                </div>
                <div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <select class="form-control" id="country" name="country[]"
                                    onchange="city_change($(this).val())" multiple="multiple">
                                    <option value="">Select Country</option>
                                    @foreach ($country_data as $country)
                                        <option value="{{ $country->id }}">
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


                                            @foreach ($allcity as $city)
                                                <option value="{{ $city->id }}">
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
                                    placeholder="Enter Service Name" value="" />

                                <p class="form-error-text" id="service_error" style="color: red; margin-top: 10px;">
                                </p>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">

                                <label for="name">Page Url</label>

                                <input id="page_url" name="page_url" type="text" class="form-control"
                                    placeholder="Enter Page Url" value="" />

                                <p class="form-error-text" id="page_url_error" style="color: red; margin-top: 10px;"></p>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">

                                <label for="name">Home Icon </label>

                                <input id="home_icon" name="home_icon" type="file" class="form-control" value="" />

                                <p class="form-error-text" id="home_icon_error" style="color: red; margin-top: 10px;"></p>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">

                                <label for="name">Home Icon Alt tag</label>

                                <input id="homeicon_alt_tag" name="homeicon_alt_tag" type="text" class="form-control"
                                    value="" placeholder="Home Icon Alt tag" />
                                <p class="form-error-text" id="homeicon_alt_tag_error"
                                    style="color: red; margin-top: 10px;"></p>

                            </div>
                        </div>



                        <div class="col-lg-6">
                            <div class="form-group">

                                <label for="name">App Icon </label>

                                <input id="app_icon" name="app_icon" type="file" class="form-control"
                                    value="" />

                                <p class="form-error-text" id="app_icon_error" style="color: red; margin-top: 10px;"></p>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">

                                <label for="name">App Icon Alt tag</label>

                                <input id="appicon_alt_tag" name="appicon_alt_tag" type="text" class="form-control"
                                    value="" placeholder="App Icon Alt tag" />
                                <p class="form-error-text" id="appicon_alt_tag_error"
                                    style="color: red; margin-top: 10px;"></p>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="city">Local Fields</label>
                                <select class="form-control" id="form_fields" name="form_fields[]" multiple="multiple">
                                    <option value="">Select Form Fields</option>
                                    @if ($form_field_data != '' && count($form_field_data) > 0)
                                        @foreach ($form_field_data as $form_field)
                                            <option value="{{ $form_field->id }}">
                                                {{ $form_field->lable_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="form-error-text" id="form_fields_error" style="color: red; margin-top: 10px;">
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="city">International Fields</label>
                                <select class="form-control" id="form_fields_two" name="form_fields_two[]"
                                    multiple="multiple">
                                    <option value="">Select Form Fields</option>
                                    @if ($form_field_data != '' && count($form_field_data) > 0)
                                        @foreach ($form_field_data as $form_field)
                                            <option value="{{ $form_field->id }}">
                                                {{ $form_field->lable_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="form-error-text" id="form_fields_error" style="color: red; margin-top: 10px;">
                                </p>
                            </div>
                        </div>



                        <div class="row">
                        </div>
                    </div>
                </div>
                <div class="compact-card">
                    <div class="compact-header">
                        <h5><i class="fa fa-image me-2" style="color: #6777ef;"></i> Banners Section</h5>
                        <button class="btn btn-sm btn-primary" type="button" id="add_field_button"
                            style="height: 34px; font-size: 13px; font-weight: 500; border-radius: 6px;">+ Add
                            More</button>
                    </div>
                    <div>
                        <div class="col-md-12">

                        </div>
                    </div>

                    @php
                        $k = 0;
                    @endphp

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group"> <label for="categoryname">City</label>
                                <select class="form-control" id="city_addmore_banner" name="city_addmore_banner1[]">
                                    <option value="">Select City</option>
                                    @foreach ($allcity as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"> <label for="categoryname">Title</label>
                                <input type="text" id="title_addmore_banner" name="title_addmore_banner1[]"
                                    class="form-control" placeholder="Enter Title" value="">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group"> <label for="categoryname">Image (2025px X 660px)</label>
                                <input type="file" id="image" name="image_addmore_banner1[]" class="form-control"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="name">Mobile Banner Image (400px x 475px)</label>
                                <input id="mobile_banner_image_addmore" name="mobile_banner_image_addmore1[]"
                                    type="file" class="form-control" value="" />
                                <p class="form-error-text" id="ombile_banner_image_error"
                                    style="color: red; margin-top: 10px;"></p>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group"> <label for="categoryname">Short Description</label>
                                <textarea id="description_addmore_banner" name="description_addmore_banner1[]" class="form-control"
                                    placeholder="Enter Description"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="input_fields_wrap"></div>

                    <div class="row mt-4"></div>
                </div>

                <div class="compact-card">
                    <div class="compact-header">
                        <h5><i class="fa fa-align-left me-2" style="color: #6777ef;"></i> Top Description Section</h5>
                        <button class="btn btn-sm btn-primary" type="button" id="add_field_button01_top_description"
                            style="height: 34px; font-size: 13px; font-weight: 500; border-radius: 6px;">+ Add
                            More</button>
                    </div>
                    <div></div>

                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group"> <label for="categoryname">City</label>
                                <select class="form-control" id="city_addmore_top_description"
                                    name="city_addmore_top_description[]">
                                    <option value="">Select City</option>
                                    @foreach ($allcity as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
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
                    <div class="input_fields_wrap01_top_description"></div>
                </div>



                <div class="compact-card">
                    <div class="compact-header">
                        <h5><i class="fa fa-search me-2" style="color: #6777ef;"></i> Meta & SEO Information</h5>
                        <button class="btn btn-sm btn-primary" type="button" id="add_field_button02"
                            style="height: 34px; font-size: 13px; font-weight: 500; border-radius: 6px;">+ Add
                            More</button>
                    </div>
                    <div>
                        @php
                            $k = 0;
                        @endphp

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"> <label for="categoryname">City</label>
                                    <select class="form-control" id="city_addmore_third1" name="city_addmore_third1[]">
                                        <option value="">Select City</option>
                                        @foreach ($allcity as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group"> <label for="categoryname">Meta Title</label>
                                    <input type="text" id="meta_title" name="meta_title1[]" class="form-control"
                                        placeholder="">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group"> <label for="categoryname">Meta Keyword</label>
                                    <input type="text" id="meta_keyword" name="meta_keyword1[]" class="form-control"
                                        placeholder="">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group"><label for="categoryname">Meta Description</label>
                                    <textarea id="meta_description" name="meta_description1[]" class="form-control"
                                        placeholder="Enter Meta Description"></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="input_fields_wrap02">
                        </div>
                    </div>
                </div>

                <div class="compact-card">
                    <div class="compact-header">
                        <h5><i class="fa fa-file-text me-2" style="color: #6777ef;"></i> Service Policies & Details</h5>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="scope_of_job">Scope Of Job</label>
                                    <textarea id="scope_of_job" name="scope_of_job" class="form-control" placeholder="Enter Scope Of Job"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="price_includes">Price Includes</label>
                                    <textarea id="price_includes" name="price_includes" class="form-control" placeholder="Enter Price Includes"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="price_excludes">Price Excludes</label>
                                    <textarea id="price_excludes" name="price_excludes" class="form-control" placeholder="Enter Price Excludes"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="disclaimer">Disclaimer</label>
                                    <textarea id="disclaimer" name="disclaimer" class="form-control" placeholder="Enter Disclaimer"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="insurance">Insurance</label>
                                    <textarea id="insurance" name="insurance" class="form-control" placeholder="Enter Insurance"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="payment_terms">Payment Terms</label>
                                    <textarea id="payment_terms" name="payment_terms" class="form-control" placeholder="Enter Payment Terms"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sticky Action Bar -->
                <div class="sticky-action-bar">
                    <a class="btn btn-light border" href="{{ route('service.index') }}">Cancel</a>
                    <button class="btn btn-primary" type="button" disabled id="spinner_button" style="display: none;">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <button type="button" class="btn btn-primary" id="submit_button"
                        onclick="javascript:service_validation()">Save Service</button>
                </div>
        </form>
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


        var oldCities = [];

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


        var oldCities = [];

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

        ClassicEditor.create(document.querySelector('#description_addmore_top_description'), {
            heading: {
                options: [{
                    model: 'paragraph',
                    title: 'Paragraph',
                    class: 'ck-heading_paragraph'
                }, {
                    model: 'heading1',
                    view: 'h1',
                    title: 'Heading 1',
                    class: 'ck-heading_heading1'
                }, {
                    model: 'heading2',
                    view: 'h2',
                    title: 'Heading 2',
                    class: 'ck-heading_heading2'
                }, {
                    model: 'heading3',
                    view: 'h3',
                    title: 'Heading 3',
                    class: 'ck-heading_heading3'
                }, {
                    model: 'heading4',
                    view: 'h4',
                    title: 'Heading 4',
                    class: 'ck-heading_heading4'
                }, {
                    model: 'heading5',
                    view: 'h5',
                    title: 'Heading 5',
                    class: 'ck-heading_heading5'
                }, {
                    model: 'heading6',
                    view: 'h6',
                    title: 'Heading 6',
                    class: 'ck-heading_heading6'
                }]
            }
        }).catch(error => {
            console.error(error);
        });

        $(document).ready(function() {
            var max_fields = 50;

            // --- BANNERS SECTION ---
            var wrapper_banner = $(".input_fields_wrap");
            var add_button_banner = $("#add_field_button");
            var b_banner = 0;

            $(add_button_banner).click(function(e) {
                e.preventDefault();
                if (b_banner < max_fields) {
                    b_banner++;
                    var newField = $(
                        '<div class="row border-top pt-3 mt-3"><div class="col-md-4"><div class="form-group"> <label>City</label><select class="form-control" name="city_addmore_banner1[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div><div class="col-md-4"><div class="form-group"> <label>Title</label><input type="text" name="title_addmore_banner1[]" class="form-control" placeholder="Enter Title"></div></div><div class="col-md-4"><div class="form-group"> <label>Image (2025px X 660px)</label><input type="file" name="image_addmore_banner1[]" class="form-control"></div></div><div class="col-lg-4"><div class="form-group"><label>Mobile Banner Image (400px x 475px)</label><input name="mobile_banner_image_addmore1[]" type="file" class="form-control" /></div></div><div class="col-md-5"><div class="form-group"><label>Short Description</label><textarea id="description_addmore_banner_' +
                        b_banner +
                        '" name="description_addmore_banner1[]" class="form-control"></textarea></div></div><div class="col-md-2 d-flex align-items-end"><a href="#" class="btn btn-sm btn-danger remove_field w-100 mb-2">Remove</a></div></div>'
                    );
                    $(wrapper_banner).append(newField);
                }
            });

            $(wrapper_banner).on("click", ".remove_field", function(e) {
                e.preventDefault();
                $(this).closest('.row').remove();
                b_banner--;
            });


            // --- TOP DESCRIPTION SECTION ---
            var wrapper_top = $(".input_fields_wrap01_top_description");
            var add_button_top = $("#add_field_button01_top_description");
            var b_top = 0;

            $(add_button_top).click(function(e) {
                e.preventDefault();
                if (b_top < max_fields) {
                    b_top++;
                    var newField = $(
                        '<div class="row border-top pt-3 mt-3"><div class="col-md-9"><div class="form-group"> <label>City</label><select class="form-control" name="city_addmore_top_description[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div><div class="col-md-9"><div class="form-group"><label>Description</label><textarea id="description_addmoree_top_description_' +
                        b_top +
                        '" name="description_addmore_top_description[]" class="form-control"></textarea></div></div><div class="col-md-3 d-flex align-items-end"><a href="#" class="btn btn-sm btn-danger remove_field01_top_description w-100 mb-2" style="height: 38px;">Remove</a></div></div>'
                    );
                    $(wrapper_top).append(newField);
                    var newDesc = newField.find('#description_addmoree_top_description_' + b_top);
                    ClassicEditor.create(newDesc[0], {
                        heading: {
                            options: [{
                                model: 'paragraph',
                                title: 'Paragraph',
                                class: 'ck-heading_paragraph'
                            }, {
                                model: 'heading1',
                                view: 'h1',
                                title: 'Heading 1',
                                class: 'ck-heading_heading1'
                            }, {
                                model: 'heading2',
                                view: 'h2',
                                title: 'Heading 2',
                                class: 'ck-heading_heading2'
                            }, {
                                model: 'heading3',
                                view: 'h3',
                                title: 'Heading 3',
                                class: 'ck-heading_heading3'
                            }, {
                                model: 'heading4',
                                view: 'h4',
                                title: 'Heading 4',
                                class: 'ck-heading_heading4'
                            }, {
                                model: 'heading5',
                                view: 'h5',
                                title: 'Heading 5',
                                class: 'ck-heading_heading5'
                            }, {
                                model: 'heading6',
                                view: 'h6',
                                title: 'Heading 6',
                                class: 'ck-heading_heading6'
                            }]
                        }
                    }).catch(error => {
                        console.error(error);
                    });
                }
            });

            $(wrapper_top).on("click", ".remove_field01_top_description", function(e) {
                e.preventDefault();
                $(this).closest('.row').remove();
                b_top--;
            });



            // --- META & SEO SECTION ---
            var wrapper_meta = $(".input_fields_wrap02");
            var add_button_meta = $("#add_field_button02");
            var b_meta = 0;

            $(add_button_meta).click(function(e) {
                e.preventDefault();
                if (b_meta < max_fields) {
                    b_meta++;
                    var newField = $(
                        '<div class="row border-top pt-3 mt-3"><div class="col-md-4"><div class="form-group"> <label>City</label><select class="form-control" name="city_addmore_third1[]"><option value="">Select City</option>@foreach ($allcity as $data)<option value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div><div class="col-md-4"><div class="form-group"> <label>Meta Title</label><input type="text" name="meta_title1[]" class="form-control"></div></div><div class="col-md-4"><div class="form-group"> <label>Meta Keyword</label><input type="text" name="meta_keyword1[]" class="form-control"></div></div><div class="col-md-10"><div class="form-group"><label>Meta Description</label><textarea name="meta_description1[]" class="form-control"></textarea></div></div><div class="col-md-2 d-flex align-items-end"><a href="#" class="btn btn-sm btn-danger remove_field02 w-100 mb-2">Remove</a></div></div>'
                    );
                    $(wrapper_meta).append(newField);
                }
            });

            $(wrapper_meta).on("click", ".remove_field02", function(e) {
                e.preventDefault();
                $(this).closest('.row').remove();
                b_meta--;
            });


            // Add a function to update the textarea content before form submission
            $('form').submit(function() {
                $('.input_fields_wrap textarea, .input_fields_wrap01_top_description textarea, .input_fields_wrap01 textarea')
                    .each(function() {
                        $(this).val($(this).siblings('.ck-editor__editable').html());
                    });
            });
        });
    </script>



@stop
