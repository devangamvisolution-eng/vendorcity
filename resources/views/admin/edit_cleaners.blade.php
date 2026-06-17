@extends('admin.includes.Template')
@section('content')
<style type="text/css">
    ul li{list-style: inherit;}
</style>
   <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Crew</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cleaners.index') }}">Crew</a></li>
                        <li class="breadcrumb-item active">Edit Crew</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div id="validator" class="alert alert-danger alert-dismissable" style="display:none;">
            <i class="fa fa-warning"></i>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
            <b>Error &nbsp;: </b><span id="error_msg1"></span>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Info</h4> -->
                        <form id="form" action="{{ route('cleaners.update', $cleaners->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $cleaners->name }}">
                                        <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $cleaners->email }}">
                                        <p class="form-error-text" id="email_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone" value="{{ $cleaners->phone }}">
                                        <p class="form-error-text" id="phone_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nationality</label>
                                        <input type="text" class="form-control" id="nationality" name="nationality" placeholder="Enter Nationality" value="{{ $cleaners->nationality }}"> 
                                        <p class="form-error-text" id="phone_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Country</label>
                                  
                                    <select type="text" class="form-control" id="country" name="country" onchange="state_change();">
                                        
                                        <option value="">Select Country</option>
                                        @foreach($country_data as $data)
                                        @if($data->id != 276)
                                        <option  value="{{$data->id}}"@if (($data->id == $cleaners->country)) {{ 'selected' }} @endif>{{$data->country}}</option>
                                        @endif
                                        @endforeach
                                        </select>
                                  
                                       <p class="form-error-text" id="country_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>State</label>
                                    <span id="state_chang">
                                    <select class="form-control" id="state" name="state" onchange="city_change();">
                                        @php
                                            $in_state_id = $cleaners->state;
                                        @endphp
                                        <option value="">Select State</option>
                                        @foreach($state_data as $data)
                                            <option value="{{ $data->id }}"
                                                @if(($data->id == $in_state_id)) {{ 'selected' }} @endif>{{ $data->state }}</option>
                                        @endforeach
                                        </select>
                                    </span>
                                       <p class="form-error-text" id="state_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Area</label>
                                        <input type="text" class="form-control" id="area" name="area" placeholder="Enter Area" value="{{ $cleaners->area }}">
                                        <p class="form-error-text" id="area_error"  style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>City</label>
                                    <span id="city_chang">
                                    <select class="form-control" id="city" name="city[]" multiple="multiple">
                                        @php $in_city_id = explode(",",$cleaners->city); @endphp
                                        <option value="">Select City</option>
                                        @foreach ($city_data as $data)
                                                <option value="{{ $data->id }}"
                                                    @if (in_array($data->id, $in_city_id)) {{ 'selected' }} @endif>
                                                    {{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                       <p class="form-error-text" id="city_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Service</label>
                                        <select type="text" class="form-control" id="service"  multiple="multiple" name="service[]" onchange="subservice_change();">
                                            @php $in_service_id = explode(",",$cleaners->service); @endphp
                                            <option value="">Select Service</option>
                                            @foreach ($service as $service_data)
                                                <option value="{{ $service_data->id }}"
                                                    @if (in_array($service_data->id, $in_service_id)) {{ 'selected' }} @endif>
                                                    {{ $service_data->servicename }}</option>
                                            @endforeach
                                        </select>
                                       <p class="form-error-text" id="service_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sub Service</label>
                                        <span id="subservice_chang">
                                        <select type="text" class="form-control" id="subservice"  multiple="multiple" name="subservice[]">
                                            @php $in_subservice_id = explode(",",$cleaners->subservice); @endphp
                                            <option value="">Select Subservice</option>
                                            @foreach ($subservice as $subcat_data)
                                                <option value="{{ $subcat_data->id }}"
                                                    @if (in_array($subcat_data->id, $in_subservice_id)) {{ 'selected' }} @endif>
                                                    {{ $subcat_data->subservicename }}</option>
                                            @endforeach
                                        </select>
                                        </span>
                                       <p class="form-error-text" id="subservice_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Profile Image (Size : 95px X 95px )</label>
                                        <input type="file" class="form-control" id="profile_image" name="profile_image" value="">
                                        @if ($cleaners->profile_image != '')
                                        <img src="{{ asset('public/upload/cleaners/large/' . $cleaners->profile_image) }}"
                                            style="width: 15%;margin-top: 10px;" />
                                         @endif
                                        <p class="form-error-text" id="profile_image_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Language</label>
                                        <input type="text" class="form-control" id="language" name="language" value="{{ $cleaners->language }}">
                                        <p class="form-error-text" id="language_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Crew Description</label>
                                    <textarea name="cleaner_desc" id="cleaner_desc" class="form-control">{{ $cleaners->cleaner_desc }}</textarea>
                                </div>
                               
                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('cleaners.index') }}"> Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                style="display: none;">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary" id="submit_button"
                                    onclick="javascript:validation()">Submit</button>
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
    function validation() {
        var name = jQuery("#name").val();
               if (name == '') {
                   jQuery('#name_error').html("Please Name");
                   jQuery('#name_error').show().delay(0).fadeIn('show');
                   jQuery('#name_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#name').offset().top - 150
                   }, 1000);
                   return false;
               }
               var email = jQuery("#email").val();
            if (email == '') {
                jQuery('#email_error').html("Plaese Enter Email Address.");
                jQuery('#email_error').show().delay(0).fadeIn('show');
                jQuery('#email_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#email').offset().top - 150
                }, 1000);
                return false;
            }
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!filter.test(email)) {
                jQuery('#email_error').html("Plaese Enter Valid Email Address.");
                jQuery('#email_error').show().delay(0).fadeIn('show');
                jQuery('#email_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#email').offset().top - 150
                }, 1000);
                return false;
            }
            var phone = jQuery("#phone").val();
            if (phone == '') {
                jQuery('#phone_error').html("Plaese Enter Phone.");
                jQuery('#phone_error').show().delay(0).fadeIn('show');
                jQuery('#phone_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#phone').offset().top - 150
                }, 1000);
                return false;
            }
            var filter = /^\d{10}$/;
            if (!filter.test(phone)) {
                jQuery('#phone_error').html("Plaese Enter Valid Phone.");
                jQuery('#phone_error').show().delay(0).fadeIn('show');
                jQuery('#phone_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#phone').offset().top - 150
                }, 1000);
                return false;
            }
            var country = jQuery("#country").val();
            if (country == '') {
                jQuery('#country_error').html("Please Select Country");
                jQuery('#country_error').show().delay(0).fadeIn('show');
                jQuery('#country_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#country').offset().top - 150
                }, 1000);
                return false;
            }
            var state = jQuery("#state").val();
            if (state == '') {
                jQuery('#state_error').html("Please Select State");
                jQuery('#state_error').show().delay(0).fadeIn('show');
                jQuery('#state_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#state').offset().top - 150
                }, 1000);
                return false;
            }
            var city = jQuery("#city").val();
            if (city == '') {
                jQuery('#city_error').html("Please Select City");
                jQuery('#city_error').show().delay(0).fadeIn('show');
                jQuery('#city_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#city').offset().top - 150
                }, 1000);
                return false;
            }
            var area = jQuery("#area").val();
            if (area == '') {
                jQuery('#area_error').html("Please Select Area");
                jQuery('#area_error').show().delay(0).fadeIn('show');
                jQuery('#area_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#area').offset().top - 150
                }, 1000);
                return false;
            }
            var service = jQuery("#service").val();
            if (service == '') {
                jQuery('#service_error').html("Please Select Service");
                jQuery('#service_error').show().delay(0).fadeIn('show');
                jQuery('#service_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#service').offset().top - 150
                }, 1000);
                return false;
            }
            var subservice = jQuery("#subservice").val();
            if (subservice == '') {
                jQuery('#subservice_error').html("Please Select Subservice");
                jQuery('#subservice_error').show().delay(0).fadeIn('show');
                jQuery('#subservice_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#subservice').offset().top - 150
                }, 1000);
                return false;
            }
            var language = jQuery("#language").val();
            if (language == '') {
                jQuery('#language_error').html("Please Enter Languages");
                jQuery('#language_error').show().delay(0).fadeIn('show');
                jQuery('#language_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#language').offset().top - 150
                }, 1000);
                return false;
            }
        $('#spinner_button').show();
        $('#submit_button').hide();
        $('#form').submit();
    }
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector("#cleaner_desc"), {
            ckfinder: {
                uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}",
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
<script type="text/javascript">
    $("#city").select2({
           placeholder: "Select a City" // Replace with your desired placeholder text
       });
       $("#service").select2({
               placeholder: "Select a Services" // Replace with your desired placeholder text
           });
        $("#subservice").select2({
               placeholder: "Select a Services" // Replace with your desired placeholder text
           });
    function subservice_change(){
        var url = '{{ url('cleaners-subservice-show') }}';
        var service = $('#service').val();
        var selectedSubservices = $("#subservice").val();
        // alert(service);
        $.ajax({
            url: url,
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "service": service,
                "selected_subservice_ids": selectedSubservices
            },
            success: function(msg) {
                document.getElementById('subservice_chang').innerHTML = msg;
                $("#subservice").select2({
               placeholder: "Select a Subservice" // Replace with your desired placeholder text
           });
            }
        });
    }
     
   function state_change(){

var url = '{{ url('cleaners-state-show') }}';
var country = $('#country').val();

$.ajax({
    url:url,
    type:'post',
    data:{
        "_token" : "{{ csrf_token() }}",
        "country" :country,
    },
    success:function(msg){
        document.getElementById('state_chang').innerHTML = msg;
    }
});
}

function city_change(){

var url = '{{ url('cleaners-city-show') }}';
var state = $("#state").val();
var selectedCity = $('#city').val();


$.ajax({
   url:url,
   type:'post',
   data:{
        "_token" : "{{ csrf_token() }}",
        "state" : state,
        "selectedCity" : selectedCity,
   },
   success:function(msg){
    document.getElementById('city_chang').innerHTML = msg;
    $("#city").select2({
           placeholder: "Select a City" // Replace with your desired placeholder text
       });
   }
});
}
</script>
@stop
