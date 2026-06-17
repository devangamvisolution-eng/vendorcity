@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Edit Time Slot Price</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        {{-- <li class="breadcrumb-item"><a href="{{ route('state.index') }}">System</a></li> --}}

                        <li class="breadcrumb-item active">Edit Time Slot Price</li>

                    </ul>

                </div>

            </div>

        </div>

        <!-- /Page Header -->



        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">
            <strong>Success! </strong><span id="success_message"></span>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
        </div>



        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <!-- <h4 class="card-title">Basic Info</h4> -->

                        <form id="time_slot_price_form" action="{{ route('time_slot_price.update',$id) }}" method="POST"
                            enctype="multipart/form-data">

                           
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
                                                {{ $service->id == $time_data->service_id ? 'selected' : '' }}>
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
                                                    {{ $subservice->id == $time_data->subservice_id ? 'selected' : '' }}>
                                                    {{ $subservice->subservicename }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </span>
                                    <p class="form-error-text" id="subservice_error" style="color: red; margin-top: 10px;">
                                    </p>
                                </div>

                                @php
                                $i=0;
                                @endphp
                                @foreach ($time_slot as $data)

                                @php
                                   $subservice_timeslot_price =  DB::table('subservice_timeslot_price')
                                                ->where('time_slot_id',$data->id)
                                                ->where('service_id',$time_data->service_id)
                                                ->where('subservice_id',$time_data->subservice_id)
                                                ->first();
                                if(isset($subservice_timeslot_price) && !empty($subservice_timeslot_price)){
                                   $value =  $subservice_timeslot_price->price;
                                }else{
                                    $value = 0;
                                }
                                @endphp
                                <div class="row">
                                    <div class="col-md-4">
                                        @if($i == 0)
                                        <label for="name"><b>Hours</b></label>
                                        @endif
                                        <input type="hidden" id="time_slot_id" value="{{$data->id}}" name="time_slot_id[]" > 

                                        <input type="text" name="time_slot_name[]" value="{{$data->name}}" class="form-control" style="margin-top: 10px;" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        @if($i == 0)
                                        <label for="name"><b>Price</b></label>
                                        @endif
                                        <input type="text" name="price[]" id="{{$data->id}}" value="{{$value}}" placeholder="Enter Price" class="form-control" style="margin-top: 10px;" >
                                    </div>
                                    <div class="col-md-4">
                                        @if($i == 0)
                                        <label for="name"><b>Slot Status</b></label>
                                        @endif
                                        <select name="is_active[]" class="form-control" style="margin-top: 10px;">
                                            <option value="1" @if(isset($subservice_timeslot_price) && $subservice_timeslot_price->is_active == 1) selected @endif>Active</option>
                                            <option value="0" @if(isset($subservice_timeslot_price) && $subservice_timeslot_price->is_active == 0) selected @endif>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                @php

                                $i++;
                                @endphp
                                @endforeach


                            </div>



                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('time_slot_price.index') }}"> Cancel</a>



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
        // var name = jQuery("#name").val();
        // if (name == '') {
        //     jQuery('#name_error').html("Please Enter Package Category Name");
        //     jQuery('#name_error').show().delay(0).fadeIn('show');
        //     jQuery('#name_error').show().delay(2000).fadeOut('show');
        //     $('html, body').animate({
        //         scrollTop: $('#name').offset().top - 150
        //     }, 1000);
        //     return false;
        // }


        $('#spinner_button').show();
        $('#submit_button').hide();

        $('#time_slot_price_form').submit();
    }
</script>


@stop
