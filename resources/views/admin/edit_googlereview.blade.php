@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Edit Google Review</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('google_review.index') }}">Google Review</a></li>

                        <li class="breadcrumb-item active">Edit Google Review</li>

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

                        <form id="category_form" action="{{ route('google_review.update', $googlereview->id) }}"
                            method="POST" enctype="multipart/form-data">

                            @csrf

                            @method('PUT')

                            <div class="row">



                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="services">Service</label>
                                        <select class="form-control" id="services" name="services[]" multiple="multiple">
                                            <option value="">Select Service</option>
                                            @php $service_array = !empty($googlereview->services) ? explode(',', $googlereview->services) : []; @endphp
                                            @foreach ($allservices as $allservices_data)
                                                <option value="{{ $allservices_data->id }}"
                                                    @if (in_array($allservices_data->id, $service_array)) selected @endif>
                                                    {{ $allservices_data->servicename }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="services_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="packages">Sub Service</label>
                                        <select class="form-control" id="packages" name="subservice_id[]"
                                            multiple="multiple">
                                            <option value="">Select Sub Service</option>
                                            @php $package_array = !empty($googlereview->subservice_id) ? explode(',', $googlereview->subservice_id) : []; @endphp
                                            @foreach ($allsubservices as $allsubservices_data)
                                                <option value="{{ $allsubservices_data->id }}"
                                                    @if (in_array($allsubservices_data->id, $package_array)) selected @endif>
                                                    {{ $allsubservices_data->subservicename }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="packages_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input id="name" name="name" type="text" class="form-control"
                                            placeholder="Enter Name" value="{{ $googlereview->name }}" />
                                        <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Review</label>
                                        <select id="label" name="label" class="form-control">
                                            <option value="">Select Review</option>
                                            <option value="1" {{ $googlereview->label == 1 ? 'selected' : '' }}>1
                                            </option>
                                            <option value="2" {{ $googlereview->label == 2 ? 'selected' : '' }}>2
                                            </option>
                                            <option value="3" {{ $googlereview->label == 3 ? 'selected' : '' }}>3
                                            </option>
                                            <option value="4" {{ $googlereview->label == 4 ? 'selected' : '' }}>4
                                            </option>
                                            <option value="5" {{ $googlereview->label == 5 ? 'selected' : '' }}>5
                                            </option>
                                        </select>
                                        <p class="form-error-text" id="label_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="review_date">Review Date</label>
                                        <input id="review_date" name="review_date" type="date" class="form-control"
                                            value="{{ $googlereview->review_date }}" />
                                        <p class="form-error-text" id="review_date_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">Description</label>
                                        <textarea id="description" name="description" class="form-control" placeholder="Enter Description" value="">{{ $googlereview->description }}</textarea>
                                        <p class="form-error-text" id="description_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                            </div>


                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('google_review.index') }}"> Cancel</a>



                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>

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

        $("#packages").select2({
            placeholder: "Select a Sub Service"
        });

        $("#services").select2({
            placeholder: "Select a Service"
        });

        // Saved subservice IDs to re-select after AJAX reload
        var savedSubserviceIds = @json(!empty($googlereview->subservice_id) ? explode(',', $googlereview->subservice_id) : []);

        // When service selection changes, fetch matching subservices via AJAX
        $("#services").on("change", function() {
            var selectedServices = $(this).val();
            $("#packages").empty().append('<option value="">Select Sub Service</option>');

            if (!selectedServices || selectedServices.length === 0) {
                $("#packages").trigger("change");
                return;
            }

            var allSubservices = [];
            var fetchCount = 0;
            $.each(selectedServices, function(i, serviceId) {
                if (!serviceId) {
                    fetchCount++;
                    return;
                }
                $.getJSON('{{ url('admin/get-subservices-by-service') }}/' + serviceId, function(data) {
                    allSubservices = allSubservices.concat(data);
                    fetchCount++;
                    if (fetchCount === selectedServices.length) {
                        var seen = {};
                        $.each(allSubservices, function(j, sub) {
                            if (!seen[sub.id]) {
                                seen[sub.id] = true;
                                var selected = savedSubserviceIds.indexOf(String(sub
                                    .id)) !== -1 ? ' selected' : '';
                                $("#packages").append('<option value="' + sub.id + '"' +
                                    selected + '>' + sub.subservicename + '</option>');
                            }
                        });
                        $("#packages").trigger("change");
                    }
                });
            });
        });
    </script>

@stop
