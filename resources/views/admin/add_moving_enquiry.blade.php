@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Add Moving & Storage Enquiry</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('frontuser.index') }}">Add Moving & Storage Enquiry</a>
                        </li>

                        <li class="breadcrumb-item active">Add Moving & Storage Enquiry</li>

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

                        <form id="category_form" action="{{ route('admin.movingstorageenquirystore') }}" method="POST">

                            @csrf

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Customer Name</label>
                                        <select id="customer_id" name="customer_id" class="form-control form-select">
                                            <option value="">Select Customer Name</option>
                                            @foreach ($customer_data as $item)
                                                <option value="{{ $item->id }}" data-email="{{ $item->email }}"
                                                    data-name="{{ $item->name }}" data-phone = "{{ $item->mobile }}">
                                                    {{ $item->id }}-{{ $item->name }}-{{ $item->email }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="customer_id_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Service Name</label>
                                        <select id="service_id" name="service_id" class="form-control form-select">
                                            <option value="">Select Service Name</option>
                                            @foreach ($service_data as $item)
                                                <option value="{{ $item->id }}">{{ $item->servicename }}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="service_id_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Sub Service Name</label>
                                        <select id="sub_service_id" name="sub_service_id" class="form-control form-select"
                                            onchange="getForms()">
                                            <option value="">Select Sub Service</option>
                                        </select>

                                        <p class="form-error-text" id="sub_service_id_error"
                                            style="color: red; margin-top: 10px;"></p>

                                    </div>
                                </div>

                                <div class="col-md-3 enquiry_type_div" style="display: none;">
                                    <div class="form-group">
                                        <label>Enquiry Type</label>
                                        <select id="enquiry_type" name="enquiry_type" class="form-control form-select"
                                            onchange="getForms()">
                                            <option value="">Select Type</option>
                                            <option value="Local">Local</option>
                                            <option value="International">International</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="dynamic_forms" class="row">
                                </div>



                            </div>




                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('frontuser.index') }}"> Cancel</a>



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
        $('#customer_id').select2({
            placeholder: 'Select Customer Name',
            allowClear: true
        });

        function category_validation() {



            var customer_id = jQuery("#customer_id").val();

            if (customer_id == '') {
                jQuery('#customer_id_error').html("Please Select Customer Name");
                jQuery('#customer_id_error').show().delay(0).fadeIn('show');
                jQuery('#customer_id_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#customer_id').offset().top - 150
                }, 1000);
                return false;
            }

            var service_id = jQuery("#service_id").val();

            if (service_id == '') {
                jQuery('#service_id_error').html("Please Select Service Name");
                jQuery('#service_id_error').show().delay(0).fadeIn('show');
                jQuery('#service_id_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#service_id').offset().top - 150
                }, 1000);
                return false;
            }

            var sub_service_id = jQuery("#sub_service_id").val();
            if (sub_service_id == '') {
                jQuery('#sub_service_id_error').html("Please Select Sub Service Name");
                jQuery('#sub_service_id_error').show().delay(0).fadeIn('show');
                jQuery('#sub_service_id_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#sub_service_id').offset().top - 150
                }, 1000);
                return false;
            }

            $('#spinner_button').show();

            $('#submit_button').hide();

            // if (!validateDynamicForm()) {
            //     e.preventDefault(); // stop form submission
            // }



            $('#category_form').submit();

        }
    </script>

    <script>
        $(document).ready(function() {
            $('#service_id').on('change', function() {
                var service_id = $(this).val();
                if (service_id) {
                    $.ajax({
                        url: "{{ url('/get-subservices') }}/" + service_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#sub_service_id').empty();
                            $('#sub_service_id').append(
                                '<option value="">Select Sub Service</option>');
                            $.each(data, function(key, value) {
                                $('#sub_service_id').append('<option value="' + value
                                    .id + '">' + value.subservicename + '</option>');
                            });
                        }
                    });
                } else {
                    $('#sub_service_id').empty();
                    $('#sub_service_id').append('<option value="">Select Sub Service</option>');
                }
            });

            $('#sub_service_id').on('change', function() {

                var sub_service_id = $(this).val();

                if (sub_service_id == 23 || sub_service_id == 26 || sub_service_id == 53) {
                    $('.enquiry_type_div').show();
                } else {
                    $('.enquiry_type_div').hide();
                }
            });
        });

        function getForms() {
            //alert('hi');
            var service_id = $('#service_id').val();
            var sub_service_id = $('#sub_service_id').val();
            var enquiry_type = $('#enquiry_type').val();

            $.ajax({
                url: "{{ route('admin.get.dynamic.forms') }}",
                type: "POST",
                data: {
                    service_id: service_id,
                    sub_service_id: sub_service_id,
                    enquiry_type: enquiry_type,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "html",
                success: function(data) {
                    //console.log(data);
                    $('#dynamic_forms').html(data);

                    $(".multiple").select2({
                        placeholder: "Select a Form Fields" // Replace with your desired placeholder text
                    });
                }
            });


        }

        // function validateDynamicForm() {
        //     let isValid = true;

        //     // loop through each field
        //     document.querySelectorAll(".dynamic-field").forEach(function(input) {
        //         let value = input.value.trim();


        //         // check required
        //         if (input.hasAttribute("required") && value === "") {
        //             alert(input.placeholder + " is required");
        //             input.focus();
        //             isValid = false;
        //             return false; // break loop
        //         }


        //     });

        //     return isValid;
        // }

        function get_sub_select(val, form_id) {

            var url = '{{ route('admin.change_drop_down') }}';

            $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "form_inner_id": val,
                    "form_id": form_id
                },
                success: function(msg) {
                    document.getElementById('replace_select_' + form_id).innerHTML = msg;
                    $(".multiple").select2({
                        placeholder: "Select a Form Fields" // Replace with your desired placeholder text
                    });
                }
            });

        }


        $(".multiple").select2({
            placeholder: "Select a Form Fields" // Replace with your desired placeholder text
        });
    </script>


@stop
