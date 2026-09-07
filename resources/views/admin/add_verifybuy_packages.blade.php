@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Verifybuy Package</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('verifybuy-packages.index') }}">Verifybuy Package</a></li>
                        <li class="breadcrumb-item active">Add Verifybuy Package</li>
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
                        <form id="category_form" action="{{ route('verifybuy-packages.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                 <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input id="name" name="name" type="text" class="form-control"
                                        placeholder="Enter Name" value="" />
                                    <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                </div>
                                 <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input id="price" name="price" type="text" class="form-control"
                                        placeholder="Enter Price" value="" />
                                    <p class="form-error-text" id="price_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                </div>
                                   <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tag">Tag</label>
                                    <input id="tag" name="tag" type="text" class="form-control"
                                        placeholder="Enter Tag" value="" />
                                    <p class="form-error-text" id="tag_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input id="image" name="image" type="file" class="form-control"
                                         value="" />
                                    <p class="form-error-text" id="image_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                </div>

                                  <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="poc">Details</label>
                                            <input type="text" id="details" name="details[]" class="form-control"
                                                placeholder="Enter Details">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="input_fields_wrap12"></div>
                                <div class="form-group">

                                    <div class="col-sm-12">

                                        <button
                                            style="border: medium none;margin-right: 20%;line-height: 25px;margin-top: -62px;width: 8%;"
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button12">Add</button>

                                    </div>

                                </div>

                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('verifybuy-packages.index') }}"> Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary" id="submit_button"
                                    onclick="javascript:category_validation()">Submit</button>
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
        function category_validation() {
            var name = jQuery("#name").val();            
            if (name == '') {
                jQuery('#name_error').html("Please Enter Name");
                jQuery('#name_error').show().delay(0).fadeIn('show');
                jQuery('#name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#name').offset().top - 150
                }, 1000);
                return false;
            }
            var image = jQuery("#image").val();            
            if (image == '') {
                jQuery('#image_error').html("Please select an Image");
                jQuery('#image_error').show().delay(0).fadeIn('show');
                jQuery('#image_error').show().delay(2000).fadeOut('show');
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
      <script type="text/javascript" language="javascript">
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

                        '<div class="row"><div class="col-md-6"><div class="form-group"> <label for="poc">Details</label><input type="text" id="details" name="details[]" class="form-control"placeholder="Enter Details"></div></div><a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 0;margin-top: 22px;width: 8%;float: right;height: 38px;margin-left: 13%;">Remove</a></div>'
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
@stop
