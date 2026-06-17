@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Edit Cleaning Price</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        {{-- <li class="breadcrumb-item"><a href="{{ route('state.index') }}">System</a></li> --}}

                        <li class="breadcrumb-item active">Edit Cleaning Price</li>

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

                        <form id="cleaning_price_form" action="{{ route('cleaning_price.update',2) }}" method="POST"
                            enctype="multipart/form-data">

                            @php

                            $homecleaning = DB::table('cleanin_subserviceprice')->where('subservice_id',28)->get()->toArray();

                            $officecleaning = DB::table('cleanin_subserviceprice')->where('subservice_id',30)->get()->toArray();

                            // echo "<pre>";print_r($homecleaning);echo "</pre>";
                            @endphp

                            @csrf

                            @method('PUT')

                            <div class="row">

                                <div class="form-group">
                                    <h3><u>Home Cleaning Price</u></h3>
                                    <div class="row">
                                    <div class="col-md-6">
                                    <label for="name"><b>Hour</b></label>
                                    @foreach ($homecleaning as $data)
                                    <input type="text" name="{{$data->hour_value}}" value="{{$data->hour_value}} hour" class="form-control" style="margin-top: 10px;" readonly>
                                    @endforeach
                                    </div>

                                    <div class="col-md-6">
                                    <label for="name"><b>Hourly Price</b></label>

                                    @foreach ($homecleaning as $data)
                                    <input type="hidden" name="update_homecleaningid[]"
                                    id="update_homecleaningid{{$data->id}}"
                                    value="{{$data->id}}">

                                    <input id="hourly_price" name="hourly_price_home[]" type="text" class="form-control"
                                    placeholder="Enter Hourly Price" value="{{ $data->hourly_price }}" style="margin-top: 10px;" />
                                    @endforeach
                                    </div>
                                    </div>
                                        
                                    

                                    <h3 style="margin-top: 20px;"><u>Office Cleaning Price</u></h3>

                                    <div class="row">
                                    <div class="col-md-6">
                                    <label for="name"><b>Hour</b></label>
                                    @foreach ($officecleaning as $data)
                                    <input type="text" name="{{$data->hour_value}}" value="{{$data->hour_value}} hour" class="form-control" style="margin-top: 10px;" readonly> 
                                    @endforeach
                                    </div>

                                    <div class="col-md-6">
                                    <label for="name"><b>Hourly Price</b></label>
                                    @foreach ($officecleaning as $data)
                                    <input type="hidden" name="update_officecleaningid[]"
                                    id="update_officecleaningid{{$data->id}}"
                                    value="{{$data->id}}">
                                    <input id="hourly_price" name="hourly_price_office[]" type="text" class="form-control"
                                    placeholder="Enter Hourly Price" value="{{ $data->hourly_price }}" style="margin-top: 10px;" />
                                    @endforeach
                                    </div>
                                    </div>
                                    <p class="form-error-text" id="percentage_error" style="color: red; margin-top: 10px;">
                                    </p>

                                </div>



                            </div>



                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ url('/admin') }}"> Cancel</a>



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

            var percentage = jQuery("#percentage").val();

            if (percentage == '') {
                jQuery('#percentage_error').html("Please Enter Percentage");
                jQuery('#percentage_error').show().delay(0).fadeIn('show');
                jQuery('#percentage_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#percentage').offset().top - 150
                }, 1000);
                return false;
            }

            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#cleaning_price_form').submit();

        }
    </script>


@stop
