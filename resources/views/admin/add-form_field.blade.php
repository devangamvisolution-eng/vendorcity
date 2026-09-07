@extends('admin.includes.Template')
@section('content')

    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Form Field</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('form_field.index') }}">Form Field</a></li>
                        <li class="breadcrumb-item active">Add Form Field</li>
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
                        <form id="Field_form" action="{{ route('form_field.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <label for="name">Lable Name</label>
                                    <input id="name" name="lable_name" type="text" class="form-control"
                                        placeholder="Enter Lable Name" value="" />
                                    <p class="form-error-text" id="lable_name_error" style="color: red; margin-top: 10px;">
                                    </p>
                                </div>

                                <div class="form-group">
                                    <label for="name"> Type </label>
                                    <select id="type" name="type" class="form-control">
                                        <option value="" selected>Select Type</option>
                                        <option value="1">Input</option>
                                        <option value="2">Dropdown</option>
                                        <option value="3">Radio</option>
                                        <option value="4">Checkbox</option>
                                        <option value="5">Text area</option>
                                        <option value="6">Date</option>
                                        <option value="7">Multiple Dropdown</option>
                                        <option value="8">Upload Image</option>
                                        <option value="9">Time</option>
                                    </select>
                                    <p class="form-error-text" id="type_error" style="color: red; margin-top: 10px;">
                                    </p>

                                </div>

                                <div class="col-md-9 mb-3">
                                    <label for="category">Option</label>
                                    <input id="form_option" name="form_option[]" type="text" class="form-control"
                                        placeholder="Enter Option" value="" />
                                </div>

                                <div class="input_fields_wrap0"></div>

                                <div class="form-group" style="margin-bottom:37px;">
                                    <div class="col-sm-12">
                                        <button
                                            style="border: medium none; margin-left: 935px; line-height: 28px; margin-top: -68px;"
                                            class="btn btn-primary" type="button" id="add_field_button0">Add More ++
                                        </button>
                                    </div>
                                </div>

                                <div class="input_fields_wrap12"></div>

                                <div class="form-group" style="margin-bottom:37px;">
                                    <div class="col-sm-12">
                                        <button
                                            style="border: medium none; margin-left: 935px; line-height: 28px; margin-top: -68px;"
                                            class="btn btn-primary" type="button" id="add_field_button12">Add More
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('form_field.index') }}"> Cancel</a>
                                <button type="button" class="btn btn-primary"
                                    onclick="javascript:Field_validation()">Submit</button>
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

    {{-- CKEditor CDN --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>

    <!-- <script>
        $(function() {
            $("#name").keyup(function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#page_url").val(Text);
            });
        });
    </script> -->

    <script>
        function Field_validation() {
            var name = jQuery("#name").val();
            if (name == '') {
                jQuery('#lable_name_error').html("Please Enter Lable Name");
                jQuery('#lable_name_error').show().delay(0).fadeIn('show');
                jQuery('#lable_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#name').offset().top - 150
                }, 1000);
                return false;
            }

            var type = jQuery("#type").val();
            if (type == '') {
                jQuery('#type_error').html("Please Enter Type");
                jQuery('#type_error').show().delay(0).fadeIn('show');
                jQuery('#type_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#type').offset().top - 150
                }, 1000);
                return false;
            }

            $('#Field_form').submit();
        }
    </script>


    <script type="text/javascript" language="javascript">
        $(document).ready(function() {
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap12");
            var add_button = $("#add_field_button12");

            var b = 0;
            $(add_button).click(function(e) {
                //alert('ok');
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    $(wrapper).append(
                        '<div class="col-md-12"><div class="row"><div class="col-md-9 mb-3"><label for="category">Option</label><input id="form_option" name="form_option[]" type="text" class="form-control" placeholder="Enter Option" value="" /></div><div class="input_fields_wrap' +
                        b +
                        '"></div><div class="form-group" style="margin-bottom:37px;"><div class="col-sm-12"><button style="border: medium none; margin-left: 935px; line-height: 28px; margin-top: -68px;"class="btn btn-primary" type="button" id="add_field_button' +
                        b + '" onclick="add_m(' + b +
                        ')">Add More +++</button></div></div></div><a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 100px; margin-top: -42px;line-height: 25px;">Remove</a></div>'
                    );
                }
            });
            $(wrapper).on("click", ".remove_field1", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            })
        });




        $(document).ready(function() {
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap0");
            var add_button = $("#add_field_button0");

            var b = 0;
            $(add_button).click(function(e) {
                //alert('ok');
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    $(wrapper).append(
                        '<div class="col-md-12"><div class="row"><div class="col-md-4 mb-3"><label for="category">More Option</label><input id="form_option" name="more_form_option0[]" type="text" class="form-control" placeholder="Enter Option" value="" /></div></div><a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 100px; margin-top: -42px;line-height: 25px;">-</a></div>'
                    );
                }
            });
            $(wrapper).on("click", ".remove_field1", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            })
        });

        function add_m(id) {


            var max_fields = 50;
            var wrapper = $(".input_fields_wrap" + id);
            var add_button = $("#add_field_button" + id);

            var b = 0;
            if (b < max_fields) {
                b++;
                $(".input_fields_wrap" + id).append(
                    '<div class="col-md-12"><div class="row"><div class="col-md-4 mb-3"><label for="category">More Option</label><input id="form_option" name="more_form_option' +
                    b +
                    '[]" type="text" class="form-control" placeholder="Enter Option" value="" /></div></div><a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 100px; margin-top: -42px;line-height: 25px;">-</a></div>'
                );
            }
            //alert(b);
            $(".input_fields_wrap" + id).on("click", ".remove_field1", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            });
        }
    </script>

@stop
