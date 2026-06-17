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
                    <h3 class="page-title">Edit Packages </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('packages.index') }}">Edit Packages </a>
                        </li>
                        <li class="breadcrumb-item active">Edit Packages </li>
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

                        <form id="category_form" action="{{ route('packages.update', $packages->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="service">Service</label>
                                        <select class="form-control" id="service_id" name="service_id"
                                            onchange="subservice_change(this.value);">
                                            <option value="">Select Service</option>
                                            @foreach ($service_data as $service)
                                                <option value="{{ $service->id }}"
                                                    {{ $service->id == $packages->service_id ? 'selected' : '' }}>
                                                    {{ $service->servicename }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="service_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="subservice">Sub Service</label>
                                        <span id="subservice_chang">
                                            <select class="form-control" id="subservice_id" name="subservice_id"
                                                onchange="packagecategory_change(this.value);">
                                                <option value="">Select Sub Service</option>
                                                @foreach ($subservice_data as $subservice)
                                                    <option value="{{ $subservice->id }}"
                                                        {{ $subservice->id == $packages->subservice_id ? 'selected' : '' }}>
                                                        {{ $subservice->subservicename }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </span>
                                        <p class="form-error-text" id="subservice_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="state">Package Category</label>
                                        <span id="packagecategory_chang">
                                            <select class="form-control" id="packagecategory_id" name="packagecategory_id">
                                                <option value="">Select Package Category</option>
                                                @foreach ($packagecat_data as $packagecat)
                                                    <option value="{{ $packagecat->id }}"
                                                        {{ $packagecat->id == $packages->packagecategory_id ? 'selected' : '' }}>
                                                        {{ $packagecat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </span>
                                        <p class="form-error-text" id="packagecategory_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Title</label>
                                        <input id="title" name="title" type="text" class="form-control"
                                            placeholder="Enter Title" value="{{ $packages->title }}" />
                                        <p class="form-error-text" id="title_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Sub Title</label>
                                        <input id="sub_title" name="sub_title" type="text" class="form-control"
                                            placeholder="Enter Sub Title" value="{{ $packages->sub_title }}" />
                                        <p class="form-error-text" id="sub_title_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input id="name" name="name" type="text" class="form-control"
                                            placeholder="Enter Name" value="{{ $packages->name }}" />
                                        <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="page_url">Page Url</label>
                                        <input id="page_url" name="page_url" type="text" class="form-control"
                                            placeholder="Enter  Page Url" value="{{ $packages->page_url }}" />
                                        <p class="form-error-text" id="page_url_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">Price</label>
                                        <input id="price" name="price" type="text" class="form-control"
                                            placeholder="Enter Price" onkeypress="return validateNumber(event)"
                                            value="{{ $packages->price }}" />
                                        <p class="form-error-text" id="price_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Image (97px x 97px)</label>
                                        <input id="image" name="image" type="file" class="form-control"
                                            placeholder="Enter" value="" />
                                        @if ($packages->image != '')
                                            <img src="{{ url('public/upload/packages/large/' . $packages->image) }}"
                                                style="height: 50px;width: 50px;">
                                        @endif
                                        <p class="form-error-text" id="image_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Popup Image (500px x 160px)</label>
                                        <input id="popup_image" name="popup_image" type="file" class="form-control"
                                            placeholder="Enter" value="" />
                                            @if ($packages->popup_image != '')
                                            <img src="{{ url('public/upload/packages/popupimage/' . $packages->popup_image) }}"
                                                style="height: 50px;width: 50px;">
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Image Alt tag</label>
                                        <input id="image_alt_tag" name="image_alt_tag" type="text" class="form-control"
                                            placeholder="Enter Image Alt tag" 
                                            value="{{ $packages->image_alt_tag }}" />
                                        <p class="form-error-text" id="image_alt_tag_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Popup Image Alt tag</label>
                                        <input id="popup_image_alt_tag" name="popup_image_alt_tag" type="text" class="form-control"
                                            placeholder="Enter Popup Image Alt tag" 
                                            value="{{ $packages->popup_image_alt_tag }}" />
                                        <p class="form-error-text" id="popup_image_alt_tag_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Discount</label>
                                        <input type="text" class="form-control" id="discount" name="discount"
                                            placeholder="Enter Discount" onkeypress="return validateNumber(event)"
                                            value="{{ $packages->discount }}">
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="width: 100%;">Discount Type</label>
                                        <div style="padding: 9px 0;">
                                            <input type="radio" name="discount_type" value="0"
                                                @if ($packages->discount_type == 0) {{ 'checked' }} @endif>
                                            Percentage
                                            <input type="radio" name="discount_type" value="1"
                                                @if ($packages->discount_type == 1) {{ 'checked' }} @endif> Price
                                            <input type="radio" name="discount_type" value="2"
                                                @if ($packages->discount_type == 2) {{ 'checked' }} @endif> None
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Booking Service Percentage</label>
                                        <input id="booking_service_per" name="booking_service_per" type="text"
                                            class="form-control" placeholder="Enter Booking Service Percentage"
                                            value="{{ $packages->booking_service_per }}" />
                                        <p class="form-error-text" id="booking_service_per_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                {{-- Incluser add more start --}}

                                @if ($attribute_data != '')
                                    <input type="hidden" name="incluser_name1[]" value="">


                                    @for ($i = 0; $i < count($attribute_data); $i++)
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="hidden" name="updateid1xxx[]"
                                                    id="updateid1xxx{{ $i + 1 }}"
                                                    value="{{ $attribute_data[$i]->id }}">


                                                <div class="form-group"> <label for="poc">Incluser Name</label>
                                                    <input type="text" id="incluser_nameu" name="incluser_nameu[]"
                                                        class="form-control" placeholder="Enter Incluser Name"
                                                        value="{{ $attribute_data[$i]->incluser_name }}">
                                                </div>

                                            </div>



                                            <a href="#"
                                                onclick="singledelete('{{ route('remove_packages_att', ['pid' => $attribute_data[$i]->pid, 'id' => $attribute_data[$i]->id]) }}')"
                                                class="btn btn-danger pull-right remove_field1"
                                                style="margin-right: 0;margin-top: 22px;width: 9%;float: right;height: 40px;margin-left: 166px;">Remove</a>

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
                                    // echo '<pre>';
                                    // print_r($attribute_data);
                                    // echo '</pre>';
                                @endphp
                                <span style="@php echo $style; @endphp">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group"> <label for="poc">Incluser Name</label>
                                                <input type="text" id="incluser_name" name="incluser_name1[]"
                                                    class="form-control" placeholder="Enter Incluser Name">
                                            </div>
                                        </div>
                                    </div>
                                </span>

                                <div class="input_fields_wrap12"> </div>
                                <div class="form-group">

                                    <div class="col-sm-12">
                                        <button
                                            style="border: medium none;margin-right: 50px;line-height: 26px;margin-top: -62px; "
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button12">Add</button>
                                    </div>
                                </div>

                                {{-- Incluseradd more End --}}

                                {{-- Excluser add more start --}}

                                @if ($attributes_data != '')
                                    <input type="hidden" name="excluser_name1[]" value="">


                                    @for ($i = 0; $i < count($attributes_data); $i++)
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="hidden" name="exupdateid1xxx[]"
                                                    id="exupdateid1xxx{{ $i + 1 }}"
                                                    value="{{ $attributes_data[$i]->id }}">


                                                <div class="form-group"> <label for="poc">Excluser Name</label>
                                                    <input type="text" id="excluser_nameu" name="excluser_nameu[]"
                                                        class="form-control" placeholder="Enter Excluser Name"
                                                        value="{{ $attributes_data[$i]->excluser_name }}">
                                                </div>

                                            </div>

                                            <a href="#"
                                                onclick="singledelete('{{ route('remove_package_att', ['pid' => $attributes_data[$i]->pid, 'id' => $attributes_data[$i]->id]) }}')"
                                                class="btn btn-danger pull-right remove_field123"
                                                style="margin-right: 0;margin-top: 22px;width: 9%;float: right;height: 40px;margin-left: 166px;">Remove</a>

                                        </div>
                                    @endfor
                                @endif

                                @php

                                    $test123 = count($attributes_data);
                                    if ($test123 > 0) {
                                        $stylee = 'display:none';
                                    } else {
                                        $stylee = 'display:block';
                                    }
                                    // echo '<pre>';
                                    // print_r($attributes_data);
                                    // echo '</pre>';
                                @endphp
                                <span style="{{ $stylee }}">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group"> <label for="poc">Excluser Name</label>
                                                <input type="text" id="excluser_name" name="excluser_name1[]"
                                                    class="form-control" placeholder="Enter Excluser Name">
                                            </div>
                                        </div>
                                    </div>
                                </span>

                                <div class="input_fields_wrap123"> </div>
                                <div class="form-group">

                                    <div class="col-sm-12">
                                        <button
                                            style="border: medium none;margin-right: 50px;line-height: 26px;margin-top: -62px; "
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button123">Add</button>
                                    </div>
                                </div>

                                {{-- Excluser add more End --}}

                                {{-- Others add more start --}}

                                @if ($attributess_data != '')
                                    <input type="hidden" name="others1[]" value="">


                                    @for ($i = 0; $i < count($attributess_data); $i++)
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="hidden" name="updateid1xxxx[]"
                                                    id="updateid1xxxx{{ $i + 1 }}"
                                                    value="{{ $attributess_data[$i]->id }}">


                                                <div class="form-group"> <label for="poc">Others</label>
                                                    <input type="text" id="othersu" name="othersu[]"
                                                        class="form-control" placeholder="Enter others"
                                                        value="{{ $attributess_data[$i]->others }}">
                                                </div>

                                            </div>



                                            <a href="#"
                                                onclick="singledelete('{{ route('remove_others_att', ['pid' => $attributess_data[$i]->pid, 'id' => $attributess_data[$i]->id]) }}')"
                                                class="btn btn-danger pull-right remove_field1234"
                                                style="margin-right: 0;margin-top: 22px;width: 9%;float: right;height: 40px;margin-left: 166px;">Remove</a>

                                        </div>
                                    @endfor
                                @endif

                                @php

                                    $test = count($attributess_data);
                                    if ($test > 0) {
                                        $style = 'display:none';
                                    } else {
                                        $style = 'display:block';
                                    }
                                    // echo '<pre>';
                                    // print_r($attribute_data);
                                    // echo '</pre>';
                                @endphp
                                <span style="@php echo $style; @endphp">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group"> <label for="poc">Others</label>
                                                <input type="text" id="others" name="others1[]"
                                                    class="form-control" placeholder="Enter others">
                                            </div>
                                        </div>
                                    </div>
                                </span>

                                <div class="input_fields_wrap1234"> </div>
                                <div class="form-group">

                                    <div class="col-sm-12">
                                        <button
                                            style="border: medium none;margin-right: 50px;line-height: 26px;margin-top: -62px; "
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button1234">Add</button>
                                    </div>
                                </div>

                                {{-- Others more End --}}

                                {{-- Packages more Start --}}
                                @php
                                    $k = 0;
                                @endphp

                                @if ($package_attribute_data != '')

                                    <input type="hidden" name="title_addmore1[]" value="">
                                    <input type="hidden" name="image_alt_tag_addmore1[]" value="">

                                    <input type="file" name="e_image1_<?php echo $k; ?>" value=""
                                        style="display: none;">

                                    <input type="hidden" name="description_addmore1[]" value="">

                                    @for ($i = 0; $i < count($package_attribute_data); $i++)
                                        <div class="row">
                                            <input type="hidden" name="updateid1xxx1[]"
                                                id="updateid1xxx1{{ $i + 1 }}"
                                                value="{{ $package_attribute_data[$i]->id }}">

                                            <div class="col-md-3">

                                                <div class="form-group"> <label for="categoryname">Title</label>

                                                    <input type="text" id="price" name="title_addmoreu[]"
                                                        class="form-control" placeholder="Enter  Title"
                                                        value="{{ $package_attribute_data[$i]->title_addmore }}">

                                                </div>

                                            </div>
                                            <div class="col-md-3">

                                                <div class="form-group"> <label for="categoryname">Image (510px X
                                                        340px)</label>

                                                    <input type="file" id="image"
                                                        name="imageu_{{ $i }}" class="form-control"
                                                        placeholder="" value="">

                                                    <img src="{{ url('public/upload/packages/packages_attr/large/' . $package_attribute_data[$i]->image) }}"
                                                        style="width:35%;">

                                                </div>
                                            </div>

                                           

                                            <div class="col-md-3">

                                                <div class="form-group"> <label for="categoryname">Description</label>

                                                    <input type="text" id="description_addmoreu"
                                                        name="description_addmoreu[]" class="form-control"
                                                        placeholder="Enter Description"
                                                        value="{{ $package_attribute_data[$i]->description_addmore }}">

                                                </div>

                                            </div>
                                             <div class="col-md-9">

                                        <div class="form-group"> <label for="categoryname">Image Alt tag</label>

                                            <input type="text" id="image_alt_tag_addmoreu" name="image_alt_tag_addmoreu[]"
                                                class="form-control" placeholder="Enter  Image Alt tag" value="{{ $package_attribute_data[$i]->image_alt_tag_addmore }}">

                                        </div>

                                    </div>

                                            <a href="#"
                                                onclick="singledelete('{{ route('remove_addmore_att', ['pid' => $package_attribute_data[$i]->pid, 'id' => $package_attribute_data[$i]->id]) }}')"
                                                class="btn btn-danger pull-right remove_field1"
                                                style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a>

                                        </div>


                                        @php
                                            $k++;
                                        @endphp
                                    @endfor
                                @endif
                                @if ($package_attribute_data == '')
                                    <div class="row">
                                        <div class="col-md-3">

                                            <div class="form-group"> <label for="categoryname">Title</label>
                                                <input type="text" id="title_addmore1" name="title_addmore1[]"
                                                    class="form-control" placeholder="Enter  Title" value="">
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group"> <label for="categoryname">image</label>
                                                <input type="file" id="image1" name="e_image1_0"
                                                    class="form-control">

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group"> <label for="categoryname">Description</label>
                                                <input type="text" id="description_addmore1"
                                                    name="description_addmore1[]" class="form-control"
                                                    placeholder="Enter Description">

                                            </div>
                                        </div>
                                        <div class="col-md-9">

                                            <div class="form-group"> <label for="categoryname">Image Alt tag</label>
                                                <input type="text" id="image_alt_tag_addmore1" name="image_alt_tag_addmore1[]"
                                                    class="form-control" placeholder="Enter  Image Alt tag" value="">
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




                                <div class="form-group">
                                    <label for="name"> Short Description</label>
                                    <textarea class="form-control" name="short_description" id="short_description">{{ $packages->short_description }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="name"> Description</label>
                                    <textarea name="description" id="description" cols="30" rows="10">{{ $packages->description }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="name">Term and Condition</label>
                                    <textarea name="term_condition" id="term_condition" cols="30" rows="10">{{ $packages->term_condition }}</textarea>
                                </div>

                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('packages.index') }}"> Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary"
                                    onclick="javascript:category_validation()"id="submit_button">Submit</button>
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
        $(function() {
            $("#name").keyup(function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#page_url").val(Text);
            });
        });
    </script>


    <script type="text/javascript">
        function subservice_change(service_id) {

            var url = '{{ url('subservice_show') }}';

            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "service_id": service_id
                },
                success: function(msg) {
                    document.getElementById('subservice_chang').innerHTML = msg;
                }
            });
        }

        function packagecategory_change(subservice_id) {

            var url = '{{ url('packagecategory_show') }}';
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "subservice_id": subservice_id
                },
                success: function(msg) {
                    document.getElementById('packagecategory_chang').innerHTML = msg;
                }
            });

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

    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}",
                }
            })
            .catch(error => {

            });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#term_condition'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}",
                }
            })
            .catch(error => {

            });
    </script>

    <script>
        $(function() {

            $("#name").keyup(function() {

                var Text = $(this).val();

                Text = Text.toLowerCase();

                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');

                $("#page_url").val(Text);

            });

        });

        function category_validation() {
            var service_id = jQuery("#service_id").val();
            if (service_id == '') {
                jQuery('#service_error').html("Please Select Service");
                jQuery('#service_error').show().delay(0).fadeIn('show');
                jQuery('#service_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#service_id').offset().top - 150
                }, 1000);
                return false;
            }
            var subservice_id = jQuery("#subservice_id").val();
            if (subservice_id == '') {
                jQuery('#subservice_error').html("Please Select Sub Service");
                jQuery('#subservice_error').show().delay(0).fadeIn('show');
                jQuery('#subservice_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#subservice_id').offset().top - 150
                }, 1000);
                return false;
            }
            var packagecategory_id = jQuery("#packagecategory_id").val();
            if (packagecategory_id == '') {
                jQuery('#packagecategory_error').html("Please Select Package Category");
                jQuery('#packagecategory_error').show().delay(0).fadeIn('show');
                jQuery('#packagecategory_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#packagecategory_id').offset().top - 150
                }, 1000);
                return false;
            }
            var title = jQuery("#title").val();
            if (title == '') {
                jQuery('#title_error').html("Please Enter Title");
                jQuery('#title_error').show().delay(0).fadeIn('show');
                jQuery('#title_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#title').offset().top - 150
                }, 1000);
                return false;
            }
            var sub_title = jQuery("#sub_title").val();
            if (sub_title == '') {
                jQuery('#sub_title_error').html("Please Enter Sub Title");
                jQuery('#sub_title_error').show().delay(0).fadeIn('show');
                jQuery('#sub_title_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#sub_title').offset().top - 150
                }, 1000);
                return false;
            }
            var name = jQuery("#name").val();
            if (name == '') {
                jQuery('#name_error').html("Please Enter Name ");
                jQuery('#name_error').show().delay(0).fadeIn('show');
                jQuery('#name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#name').offset().top - 150
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

            var price = jQuery("#price").val();
            if (price == '') {
                jQuery('#price_error').html("Please Enter Price");
                jQuery('#price_error').show().delay(0).fadeIn('show');
                jQuery('#price_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#price').offset().top - 150
                }, 1000);
                return false;
            }


            $('#spinner_button').show();
            $('#submit_button').hide();

            $('#category_form').submit();
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



        $(document).ready(function() {

            var max_fields = 50;

            var wrapper = $(".input_fields_wrap1234");

            var add_button = $("#add_field_button1234");



            var b = 0;

            $(add_button).click(function(e) { //alert('ok');

                e.preventDefault();

                if (b < max_fields) {

                    b++;

                    $(wrapper).append(

                        '<div class="row"><div class="col-md-8"><div class="form-group"> <label for="poc">Others</label><input type="text" id="others" name="others1[]"class="form-control" placeholder="Enter others"></div></div><a href="#" class="btn btn-danger pull-right remove_field1234" style="margin-right: 0;margin-top: 22px;width: 9%;float: right;height: 40px;margin-left: 150px;">Remove</a></div>'

                    );

                }

            });

            $(wrapper).on("click", ".remove_field1234", function(e) {

                e.preventDefault();

                $(this).parent('div').remove();

                b--;

            })

        });

        $(document).ready(function() {

            var max_fields = 50;

            var wrapper = $(".input_fields_wrap12");

            var add_button = $("#add_field_button12");



            var b = 0;

            $(add_button).click(function(e) { //alert('ok');

                e.preventDefault();

                if (b < max_fields) {

                    b++;

                    $(wrapper).append(

                        '<div class="row"><div class="col-md-8"><div class="form-group"> <label for="poc">Incluser Name</label><input type="text" id="incluser_name" name="incluser_name1[]"class="form-control" placeholder="Enter Incluser Name"></div></div><a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 0;margin-top: 22px;width: 9%;float: right;height: 40px;margin-left: 150px;">Remove</a></div>'

                    );

                }

            });

            $(wrapper).on("click", ".remove_field1", function(e) {

                e.preventDefault();

                $(this).parent('div').remove();

                b--;

            })

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



        $(document).ready(function() {

            var max_field = 50;

            var wrapperr = $(".input_fields_wrap123");

            var add_buttonn = $("#add_field_button123");



            var c = 0;

            $(add_buttonn).click(function(e) { //alert('ok');

                e.preventDefault();

                if (c < max_field) {

                    c++;

                    $(wrapperr).append(

                        '<div class="row"><div class="col-md-8"><div class="form-group"><label for="poc">Excluser Name</label><input type="text" id="excluser_name" name="excluser_name1[]"class="form-control" placeholder="Enter Excluser Name"></div></div><a href="#" class="btn btn-danger pull-right remove_field123" style="margin-right: 0;margin-top: 22px;width: 9%;float: right;height: 40px;margin-left: 150px;">Remove</a></div>'

                    );

                }

            });

            $(wrapperr).on("click", ".remove_field123", function(e) {

                e.preventDefault();

                $(this).parent('div').remove();

                b--;

            })

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

        $(document).ready(function() {

            var max_fields = 50;

            var wrapper = $(".input_fields_wrap01");

            var add_button = $("#add_field_button01");



            var b = 0;

            $(add_button).click(function(e) { //alert('ok');

                e.preventDefault();

                if (b < max_fields) {

                    b++;

                    $(wrapper).append(

                        '<div class="row"> <div class="col-md-3"> <div class="form-group"> <label for="categoryname">Title</label>  <input type="text" id="price" name="title_addmore1[]" class="form-control" placeholder="Enter  Title"></div></div><div class="col-md-3">  <div class="form-group"> <label for="categoryname">image(510px X 340px)</label><input type="file" id="price" name="e_image1_' +
                        b +
                        '"class="form-control"  placeholder=""> </div></div> <div class="col-md-3"><div class="form-group"> <label for="categoryname">Description</label> <input type="text" id="price" name="description_addmore1[]" class="form-control"placeholder="Enter Description"> </div></div><div class="col-md-9"><div class="form-group"> <label for="categoryname">Image Alt tag</label> <input type="text" id="image_alt_tag_addmore1" name="image_alt_tag_addmore1[]" class="form-control" placeholder="Enter  Image Alt tag" value=""></div>       </div><a href="#" class="btn btn-danger pull-right remove_field01" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height: 38px;margin-left: 30px;">Remove</a></div>'

                    );

                }

            });

            $(wrapper).on("click", ".remove_field01", function(e) {

                e.preventDefault();

                $(this).parent('div').remove();

                b--;

            })


        });
    </script>


@stop
