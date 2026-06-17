@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Google Review</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('google_review.index') }}">Google Review</a></li>

                        <li class="breadcrumb-item active">Add Google Review</li>

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

                        <form id="category_form" action="{{ route('google_review.store') }}" method="POST"

                            enctype="multipart/form-data">

                            @csrf

                            <div class="row">

                                <div class="form-group">

                                    <label for="name">Review</label>

                                   <!--  <input id="label" name="label" type="text" class="form-control"

                                        placeholder="Enter Label" value="" /> -->

                                        <select id="label" name="label" class="form-control">
                                             <option value="">Select Review</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>

                                    <p class="form-error-text" id="label_error" style="color: red; margin-top: 10px;"></p>

                                </div>

                                <div class="form-group">

                                    <label for="name">Description</label>
                                    <textarea id="description" name="description" class="form-control"

                                        placeholder="Enter Description" value=""></textarea>

                                    <p class="form-error-text" id="description_error" style="color: red; margin-top: 10px;"></p>

                                </div>

                                <div class="form-group">

                                    <label for="name">Name</label>

                                    <input id="name" name="name" type="text" class="form-control"

                                        placeholder="Enter Name" value="" />

                                    <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>

                                </div>



                            </div>

                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('google_review.index') }}"> Cancel</a>



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

            var label = jQuery("#label").val();            

            if (label == '') {
                jQuery('#label_error').html("Please Select Review");
                jQuery('#label_error').show().delay(0).fadeIn('show');
                jQuery('#label_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#label').offset().top - 150
                }, 1000);
                return false;
            }

            var description = jQuery("#description").val();            

            if (description == '') {
                jQuery('#description_error').html("Please Enter Description");
                jQuery('#description_error').show().delay(0).fadeIn('show');
                jQuery('#description_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#description').offset().top - 150
                }, 1000);
                return false;
            }


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



            $('#spinner_button').show();

            $('#submit_button').hide();



            $('#category_form').submit();

        }

    </script>

@stop

