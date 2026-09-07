@extends('admin.includes.Template')
@section('content')


    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Vendor Booked Timeslot</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vendorbookedtimeslot.lists') }}"> Vendor Booked Timeslot</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Vendor Booked Timeslot</li>
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
                        <!-- <h4 class="card-title">Category</h4> -->
                        <form action="{{ route('vendorbookedtimeslot.update',$id) }}" id="category_form_new" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-6">
                                <div class="form-group">
                                    <label for="service">Service</label>
                                    <select class="form-control" id="service_id" name="service_id"
                                        onchange="subservice_change(this.value);">
                                        <option value="">Select Service</option>
                                        @foreach ($service_data as $service)
                                            <option value="{{ $service->id }}"
                                                {{ $service->id == $carwashvendor_bookedtimeslot->service_id ? 'selected' : '' }}>
                                                {{ $service->servicename }}</option>
                                        @endforeach
                                    </select>
                                    <p class="form-error-text" id="service_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                </div>
<div class="col-6">
                               <div class="form-group">
                                    <label for="subservice">Sub Service</label>
                                    <span id="subservice_chang">
                                        <select class="form-control" id="subservice_id" name="subservice_id">
                                            <option value="">Select Sub Service</option>
                                            @foreach ($subservice_data as $subservice)
                                                <option value="{{ $subservice->id }}"
                                                    {{ $subservice->id == $carwashvendor_bookedtimeslot->subservice_id ? 'selected' : '' }}>
                                                    {{ $subservice->subservicename }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </span>
                                    <p class="form-error-text" id="subservice_error" style="color: red; margin-top: 10px;">
                                    </p>
                                </div>
                                 </div>

                                 <div class="col-12">
                                <div class="form-group">
                                    <label for="service">Vendor</label>
                                    <select class="form-control" id="vendor_id" name="vendor_id"
                                        >
                                        <option value="">Select Vendor</option>
                                        @foreach ($carvendor as $carvendorData)
                                            <option value="{{ $carvendorData->id }}" {{ $carvendorData->id == $carwashvendor_bookedtimeslot->vendor_id ? 'selected' : '' }}>{{ $carvendorData->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="form-error-text" id="vendor_id_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                </div>

                                <div class="col-6">
                                <div class="form-group">
                                    <label for="service">Time Slot</label>
                                    <select class="form-control" id="timeslot_id" name="timeslot_id"
                                        >
                                        <option value="">Select Vendor</option>
                                        @foreach ($time_slots as $time)
                                            <option value="{{ $time->id }}" {{ $time->id == $carwashvendor_bookedtimeslot->timeslot_id ? 'selected' : '' }}>{{ $time->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="form-error-text" id="timeslot_id_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                </div>

                                <div class="col-6">
                                <div class="form-group">
                                    <label for="service">Booked Date</label>
                                    <input type="date" class="form-control" id="booked_date" name="booked_date" value="{{$carwashvendor_bookedtimeslot->booked_date}}">
                                    
                                    <p class="form-error-text" id="booked_date_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                </div>

                                
    

                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('vendorbookedtimeslot.lists') }}"> Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
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
            

            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#category_form_new').submit();
        }
    </script>
@stop
