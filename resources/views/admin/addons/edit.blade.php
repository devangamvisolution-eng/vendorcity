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
                    <h3 class="page-title">Edit Add Ons </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('addons.lists') }}">Edit Add Ons </a>
                        </li>
                        <li class="breadcrumb-item active">Edit Add Ons </li>
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

                        <form id="category_form" action="{{ route('addons.update', $addons->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="service">Service</label>
                                        <select class="form-control" id="service_id" name="serviceid"
                                            onchange="subservice_change(this.value);">
                                            <option value="">Select Service</option>
                                            @foreach ($service_data as $service)
                                                <option value="{{ $service->id }}"
                                                    {{ $service->id == $addons->serviceid ? 'selected' : '' }}>
                                                    {{ $service->servicename }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="service_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="subservice">Sub Service</label>

                                        @php 
                                            $Subarray = explode(',',$addons->subserviceid); 
                                            //echo "<pre>";print_r($Subarray);echo "</pre>";
                                            @endphp
                                        <span id="subservice_chang">
                                            <select class="form-control" id="subservice_id" name="subservice_id[]" multiple="multiple"
                                                >
                                                <option value="">Select Sub Service</option>
                                                @foreach ($subservice_data as $subservice)
                                                    <option value="{{ $subservice->id }}"
                                                        {{ in_array($subservice->id, $Subarray) ? 'selected' : '' }}>
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
                                

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input id="name" name="name" type="text" class="form-control"
                                            placeholder="Enter Name" value="{{ $addons->name }}" />
                                        <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                               
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Price</label>
                                        <input id="price" name="price" type="text" class="form-control"
                                            placeholder="Enter Price" onkeypress="return validateNumber(event)"
                                            value="{{ $addons->price }}" />
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
                                        @if ($addons->image != '')
                                            <img src="{{ url('public/upload/addons/' . $addons->image) }}"
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
                                            @if ($addons->popup_image != '')
                                            <img src="{{ url('public/upload/addons/' . $addons->popup_image) }}"
                                                style="height: 50px;width: 50px;">
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Image Alt tag</label>
                                        <input id="image_alt_tag" name="image_alt_tag" type="text" class="form-control"
                                            placeholder="Enter Image Alt tag" 
                                            value="{{ $addons->image_alt_tag }}" />
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
                                            value="{{ $addons->popup_image_alt_tag }}" />
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
                                            value="{{ $addons->discount }}">
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="width: 100%;">Discount Type</label>
                                        <div style="padding: 9px 0;">
                                            <input type="radio" name="discount_type" value="0"
                                                @if ($addons->discount_type == 0) {{ 'checked' }} @endif>
                                            Percentage
                                            <input type="radio" name="discount_type" value="1"
                                                @if ($addons->discount_type == 1) {{ 'checked' }} @endif> Price
                                            <input type="radio" name="discount_type" value="2"
                                                @if ($addons->discount_type == 2) {{ 'checked' }} @endif> None
                                        </div>
                                    </div>
                                </div>
                                




                                <div class="form-group">
                                    <label for="name"> Short Description</label>
                                    <textarea class="form-control" name="short_description" id="short_description">{{ $addons->short_desc }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="name"> Description</label>
                                    <textarea name="description" id="description" cols="30" rows="10">{{ $addons->description }}</textarea>
                                </div>

                                

                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('addons.lists') }}"> Cancel</a>
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
        // $(function() {
        //     $("#name").keyup(function() {
        //         var Text = $(this).val();
        //         Text = Text.toLowerCase();
        //         Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
        //         $("#page_url").val(Text);
        //     });
        // });
    </script>


    <script type="text/javascript">

    $('#subservice_id').select2();
        function subservice_change(service_id) {

            var url = '{{ route('addons.subservice_show') }}';

            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "service_id": service_id
                },
                success: function(msg) {
                    document.getElementById('subservice_chang').innerHTML = msg;
                    $('#subservice_id').select2();
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

        
    </script>


@stop
