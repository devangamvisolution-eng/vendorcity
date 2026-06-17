@extends('admin.includes.Template')
@section('content')


    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Package Category</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('packagecategory.index') }}">Edit Package Category</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Package Category</li>
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

                        <form id="category_form" action="{{ route('packagecategory.update', $packagecategory->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group">
                                    <label for="service">Service</label>
                                    <select class="form-control" id="service_id" name="service_id"
                                        onchange="subservice_change(this.value);">
                                        <option value="">Select Service</option>
                                        @foreach ($service_data as $service)
                                            <option value="{{ $service->id }}"
                                                {{ $service->id == $packagecategory->service_id ? 'selected' : '' }}>
                                                {{ $service->servicename }}</option>
                                        @endforeach
                                    </select>
                                    <p class="form-error-text" id="service_error" style="color: red; margin-top: 10px;"></p>
                                </div>

                                <div class="form-group">
                                    <label for="subservice">Sub Service</label>
                                    <span id="subservice_chang">
                                        <select class="form-control" id="subservice_id" name="subservice_id">
                                            <option value="">Select Sub Service</option>
                                            @foreach ($subservice_data as $subservice)
                                                <option value="{{ $subservice->id }}"
                                                    {{ $subservice->id == $packagecategory->subservice_id ? 'selected' : '' }}>
                                                    {{ $subservice->subservicename }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </span>
                                    <p class="form-error-text" id="subservice_error" style="color: red; margin-top: 10px;">
                                    </p>
                                </div>


                                <div class="form-group">
                                    <label for="name">Package Category Name</label>
                                    <input id="name" name="name" type="text" class="form-control"
                                        placeholder="Enter Package Category Name" value="{{ $packagecategory->name }}" />
                                    <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image (Size : 491px X 183px )</label>
                                        <input type="file" class="form-control" id="image" name="image"
                                            value="{{ $packagecategory->image }}">
                                        @if ($packagecategory->image != '')
                                            <img src="{{ asset('public/upload/packagecategory/large/' . $packagecategory->image) }}"
                                                style="width: 15%;margin-top: 10px;" />
                                        @endif
                                        <p class="form-error-text" id="image_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Image Alt tag</label>
                                    <input id="image_alt_tag" name="image_alt_tag" type="text" class="form-control"
                                        placeholder="Enter Image Alt tag" value="{{ $packagecategory->image_alt_tag }}" />
                                    <p class="form-error-text" id="image_alt_tag_error"
                                        style="color: red; margin-top: 10px;"></p>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Slider Image (Optional, for category tabs)</label>
                                        <input type="file" class="form-control" id="slider_image" name="slider_image"
                                            value="{{ $packagecategory->slider_image }}">
                                        @if ($packagecategory->slider_image != '')
                                            <img src="{{ asset('public/upload/packagecategory/' . $packagecategory->slider_image) }}"
                                                style="height: 80px; object-fit: cover; margin-top: 10px; border-radius: 8px;" />
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="slider_image_alt_tag">Slider Image Alt tag</label>
                                    <input id="slider_image_alt_tag" name="slider_image_alt_tag" type="text"
                                        class="form-control" placeholder="Enter Slider Image Alt tag"
                                        value="{{ $packagecategory->slider_image_alt_tag }}" />
                                </div>


                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('packagecategory.index') }}"> Cancel</a>
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
    </script>

    <script>
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
            var name = jQuery("#name").val();
            if (name == '') {
                jQuery('#name_error').html("Please Enter Package Category Name");
                jQuery('#name_error').show().delay(0).fadeIn('show');
                jQuery('#name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#name').offset().top - 150
                }, 1000);
                return false;
            }


            $('#spinner_button').show();
            $('#submit_button').hide();

            $('#category_form').submit();
        }
    </script>
@stop
