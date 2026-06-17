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
                    <h3 class="page-title">Crew</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cleaners.index') }}">Crew</a></li>
                        <li class="breadcrumb-item active">Add Crew</li>
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
        <!-- <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
                                   <span id="login_error"></span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                  </div> -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Info</h4> -->
                        <form action="{{ route('cleaners.store') }}" method="POST" id="form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                  <div class="form-group" style="display: none;">
                                    <label for="category">User Category</label>
                                    <select class="form-control" id="user_id" name="user_id">
                                        <option value="">Select User Category</option>
                                        @foreach ($user_category as $user_data)
                                            <option value="{{ $user_data->id }}" selected>{{ $user_data->cname }}</option>
                                        @endforeach
                                    </select>
                                <p class="form-error-text" id="user_error" style="color: red; margin-top: 10px;"></p>
                                </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                                        <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                 <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="name">User Name</label>
                                    <input id="user_name" name="user_name" type="text" class="form-control"
                                        placeholder="Enter User Name" value="" />
                                    <p class="form-error-text" id="user_name_error" style="color: red; margin-top: 10px;">
                                    </p>
                                </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
                                        <p class="form-error-text" id="email_error" style="color: red; margin-top: 10px;"></p>
                                         @error('email')
                                            <p class="form-error-text" id="email_error" style="color: red; margin-top: 10px;">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                               
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Password</label>
                                    <input id="password" name="password" type="password" class="form-control"
                                        placeholder="Enter Password" value="" />
                                    <p class="form-error-text" id="password_error" style="color: red; margin-top: 10px;">
                                    </p>
                                     @error('password')
                                         <p class="form-error-text" id="password_error" style="color: red; margin-top: 10px;">
                                        {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Confirm Password</label>
                                    <input id="conf_password" name="conf_password" type="password" class="form-control"
                                        placeholder="Enter Confirm Password" value="" />
                                    <p class="form-error-text" id="con_password_error"
                                        style="color: red; margin-top: 10px;">
                                    </p>
                                    @error('conf_password')
                                         <p class="form-error-text" id="con_password_error" style="color: red; margin-top: 10px;">
                                        {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                </div>

                                

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone">
                                        <p class="form-error-text" id="phone_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nationality</label>
                                        <input type="text" class="form-control" id="nationality" name="nationality" placeholder="Enter Nationality">
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
                                        <option  value="{{$data->id}}">{{$data->country}}</option>
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
                                        <option value="">Select State</option>
                                        </select>
                                    </span>
                                       <p class="form-error-text" id="state_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>City</label>
                                    <span id="city_chang">
                                    <select class="form-control" id="city" name="city[]" multiple="multiple">
                                        <option value="">Select City</option>
                                        </select>
                                    </span>
                                       <p class="form-error-text" id="city_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Area</label>
                                        <input type="text" class="form-control" id="area" name="area" placeholder="Enter Area">
                                        <p class="form-error-text" id="area_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Service</label>
                                        <select type="text" class="form-control" id="service"  multiple="multiple" name="service[]" onchange="subservice_change();">
                                            <option value="">Select Service</option>
                                            @foreach($service_data as $data)
                                            <option  value="{{$data->id}}">{{$data->servicename}}</option>
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
                                            <option value="">Select Subservice</option>
                                        </select>
                                        </span>
                                       <p class="form-error-text" id="subservice_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Profile Image (Size : 95px X 95px )</label>
                                        <input type="file" class="form-control" id="profile_image" name="profile_image">
                                        <p class="form-error-text" id="profile_image_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Language</label>
                                        <input type="text" class="form-control" id="language" name="language">
                                        <p class="form-error-text" id="language_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Crew Description</label>
                                    <textarea name="cleaner_desc" id="cleaner_desc" class="form-control" ></textarea>
                                </div>

                            </div>
                            <div class="text-end mt-4">
                                <a href="{{ route('cleaners.index') }}" class="btn btn-primary text-light">Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                   </button>
                                <button type="button" onclick="validation();" id="submit_button" class="btn btn-primary">Submit</button>
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
              var password = jQuery("#password").val();

            if (password == '') {

                jQuery('#password_error').html("Please Enter Password");
                jQuery('#password_error').show().delay(0).fadeIn('show');
                jQuery('#password_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#password').offset().top - 150
                }, 1000);
                return false;

            }



            var conf_password = jQuery("#conf_password").val();

            if (conf_password == '') {

                jQuery('#con_password_error').html("Please Enter Confirm Password");
                jQuery('#con_password_error').show().delay(0).fadeIn('show');
                jQuery('#con_password_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#conf_password').offset().top - 150
                }, 1000);
                return false;

            }



            if (conf_password != password) {

                jQuery('#con_password_error').html("Confirm Password Doesn't Match Password");
                jQuery('#con_password_error').show().delay(0).fadeIn('show');
                jQuery('#con_password_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#conf_password').offset().top - 150
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
            var profile_image = jQuery("#profile_image").val();
            if (profile_image == '') {
                jQuery('#profile_image_error').html("Please Select Profile Image");
                jQuery('#profile_image_error').show().delay(0).fadeIn('show');
                jQuery('#profile_image_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#profile_image').offset().top - 150
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
               placeholder: "Select a Subservices" // Replace with your desired placeholder text
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
