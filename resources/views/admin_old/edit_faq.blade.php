@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Edit FAQ</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('faq.index') }}">FAQ</a></li>

                        <li class="breadcrumb-item active">Edit FAQ</li>

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

                        <form id="category_form" action="{{ route('faq.update', $faq->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            @method('PUT')

                            <div class="row">
							
							@php
                                    $services_array = explode(',',$faq->services);
                                 @endphp

                                <div class="form-group">
                                       <label for="packages">Sub Service</label>
                                       <select class="form-control" id="services" name="services[]" multiple="multiple">
                                           <option value="">Select Service</option>
                                           @foreach ($allservices as $allservices_data)
                                               <option value="{{ $allservices_data->id }}" @php  if(in_array($allservices_data->id, $services_array)) {echo "selected";} @endphp>{{ $allservices_data->servicename }}</option>
                                           @endforeach
                                       </select>
                                       <p class="form-error-text" id="packages_error" style="color: red; margin-top: 10px;">
                                       </p>
                                   </div>
								   
                                @php
                                    $package_array = explode(',',$faq->packages);
                                 @endphp

                                <div class="form-group">
                                       <label for="packages">Sub Service</label>
                                       <select class="form-control" id="packages" name="packages[]" multiple="multiple">
                                           <option value="">Select Sub Service</option>
                                           @foreach ($allsubservices as $allsubservices_data)
                                               <option value="{{ $allsubservices_data->id }}" @php  if(in_array($allsubservices_data->id, $package_array)) {echo "selected";} @endphp>{{ $allsubservices_data->subservicename }}</option>
                                           @endforeach
                                       </select>
                                       <p class="form-error-text" id="packages_error" style="color: red; margin-top: 10px;">
                                       </p>
                                   </div>

                                <div class="form-group">

                                    <label for="name">Question</label>

                                    <input id="question" name="question" type="text" class="form-control"
                                        placeholder="Enter Question" value="{{ $faq->question }}" />

                                    <p class="form-error-text" id="question_error" style="color: red; margin-top: 10px;">
                                    </p>

                                </div>
                                <div class="form-group">

                                    <label for="name">Answer</label>

                                    <textarea name="answer" id="answer" cols="30" rows="10">{{ $faq->answer }}</textarea>


                                </div>

                            </div>

                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('faq.index') }}"> Cancel</a>



                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                                    Loading...

                                </button>



                                <button type="button" class="btn btn-primary" id="submit_button"
                                    onclick="javascript:faq_validation()">Submit</button>

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
        function faq_validation() {

            /* var selectedValues = $("#packages").val();
               if (selectedValues == '') {
                   jQuery('#packages_error').html("Please Select Sub Service");
                   jQuery('#packages_error').show().delay(0).fadeIn('show');
                   jQuery('#packages_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#packages').offset().top - 150
                   }, 1000);
                   return false;
               }
 */

            var question = jQuery("#question").val();

            if (question == '') {
                jQuery('#question_error').html("Please Enter Question");
                jQuery('#question_error').show().delay(0).fadeIn('show');
                jQuery('#question_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#question').offset().top - 150
                }, 1000);
                return false;
            }

            $('#spinner_button').show();

            $('#submit_button').hide();



            $('#category_form').submit();

        }

        $("#packages").select2({
               placeholder: "Select a Sub Service" // Replace with your desired placeholder text
           });
		   $("#services").select2({
               placeholder: "Select a Service" // Replace with your desired placeholder text
           });

    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>



    <script>
        ClassicEditor

            .create(document.querySelector('#answer'))

            .catch(error => {

                console.error(error);

            });
    </script>

@stop
