@include('front.includes.header')
<style>

.body_content{background-color: #fafafa;}
 #category_form {
    /* margin-top:80px !important; */
    border: 1px solid #ccc;
    background-color: #fff;
    padding: 13px 13px 13px 20px;
    border-radius: 10px;
    /* min-height: 100vh; */
    }
    .form-select{
      height : 55px;
    }
  .automobile_lists{
      position: relative;
      top: 91px;
  }

     .main-content {
      /* padding-bottom: 300px; */
      min-height: 200px;
    }


    .sidebar-wrapper {
      position: relative;
      height: 100%;
    }

    /* .right-sidebar {
      width: 300px;
    } */

    .fixed-sidebar {
      position: fixed;
         top: 190px;
    border-radius: 10px;
    /* border: 1px solid #ccc; */
      /* width: 25%; */
    }

    .absolute-sidebar {
      position: absolute;
    }

    
.summary_div_price{
      background-color: #fff;
    border: 1px solid #ccc;
    box-shadow: inherit;
}

.book_inspection{
      padding: 28px 0 0 0;
}

.book_inspection .title {
    font-weight: 800;
    font-size: 1.5rem;
        line-height: 2rem;
}
   
hr{
  background-color: #ccc;
    margin-top: 0;
    opacity: inherit;
}

.where_is_my_car_section .radio-group input[type="radio"] {
    display: none;
}
.where_is_my_car_section  .radio-checked input[type="radio"] + label {
    color: #000;
    /* outline: grey; */
}
.where_is_my_car_section .radio-group input[type="radio"]:checked + label {
    background-color: #0040E6;
    color: #fff;
}

.where_is_my_car_section  .radio-group label {
    display: inline-block;
    padding: 26px 10px;
    margin: 5px;
    /* border: 2px solid #0040E6; */
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}

.where_is_my_car_section  .labelclass{
    width: 100%;
    border-radius: 20px !important;
    margin: 0 auto !important;
    text-align: center;
}

.where_is_my_car_section  .labelclass p:first-child {
    color: #ccc;
    font-size: 2rem;
    /* margin: 0; */
}

.where_is_my_car_section .labelclass p{
  color: #ccc;
    font-size: .875rem;
    line-height: 1.25rem;
    font-weight: 500;
}

.where_is_my_car_section  .radio-group input[type="radio"]:checked + .labelclass p{
  color: #fff;
}

.where_is_my_car_section  .wicp_info{
      font-weight: 500;
    font-size: .875rem;
    line-height: 1.25rem;
    margin-top: 25px;
}



.vehicle_make_sec .radio-group input[type="radio"] {
    display: none;
}
.vehicle_make_sec  .radio-checked input[type="radio"] + label {
    color: #000;
    /* outline: grey; */
}
.vehicle_make_sec .radio-group input[type="radio"]:checked + label {
    background-color: #0040E6;
    color: #fff;
}

.vehicle_make_sec  .radio-group label {
    display: inline-block;
    padding: 26px 6px;
    margin: 5px;
    /* border: 2px solid #0040E6; */
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}

.vehicle_make_sec  .labelclass{
    width: 100%;
    border-radius: 20px !important;
    margin: 0 auto !important;
    text-align: center;
}




.vehicle_make_sec .labelclass p{
  color: #ccc;
    font-size: .875rem;
    line-height: 1.25rem;
    font-weight: 500;
    margin: 0;
}

.vehicle_make_sec  .radio-group input[type="radio"]:checked + .labelclass p{
  color: #fff;
}
.vehicle_make_sec  img{
  margin-bottom:10px;
}
.summary_div_price h2{
  font-weight: 700;
    font-size: 1rem;
    line-height: 1.5rem;
}

.summary_div_price .package_div{
  gap: 8.05rem;
}
.summary_div_price .package_div p{
      font-weight: 400;
    color: rgb(102 112 133 / var(--tw-text-opacity, 1));
    font-size: .875rem;
    line-height: 1.25rem;
}
.summary_div_price .package_div span{
      font-weight: 400;
    color: rgb(102 112 133 / var(--tw-text-opacity, 1));
    font-size: .875rem;
    line-height: 1.25rem;
}

.summary_div_price .price_div{
  gap: 9.75rem;
}
.summary_div_price .price_div p{
     font-weight: 700;
    color: #000;
    font-size: .875rem;
    line-height: 1.25rem;
}
.summary_div_price .price_div span{
     font-weight: 700;
    color: #000;
    font-size: .875rem;
    line-height: 1.25rem;
}

#category_form row{
  visibility: visible;
}
.modal-title {
    font-size: 20px;
}
.booknow-otp-input{
    padding-left: 0px !important;   
}
.book-email-otp-input{
    padding-left: 0px !important;   
}
</style>
@php
          $userdata = Session::get('user');
       
@endphp
<div class="automobile_lists">
  <section class="book_inspection">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2 class="title">Book Inspection</h2>
        </div>
      </div>
    </section>
  <section class="pt30">
      <div class="container">
        
        <div class="row wrap">
          <div class="col-lg-8">
            <div class="column main-content">
                <form id="category_form" action="{{route('book-inspection-form')}}" method="POST">
                  @csrf
                  <input type="hidden" name="package_id" id="package_id" value="{{ $package->id }}">
                <input type="hidden" name="total_amount" id="total_amount" value="{{ $package->price }}">
                  <div class="row" >
                    <div class="col-xl-10 col-lg-10">
                         <label class="form-label fw500 dark-color">Your Number</label>
                         <input name="mobile" type="text" class="form-control " id="mobile" placeholder="Your Number" value="{{ $userdata['mobile'] ?? '' }}" onkeypress="return validateNumber(event)">
                         <p id="mobile-error" style="display: none;color:red;"></p>
                         @error('mobile')
                                    <p class="text-danger">{{ $message }}</p>
                                        @enderror
                    </div>
                  </div>
                  <div class="row" >
                    <div class="col-xl-10 col-lg-10">
                      <h5 class="title mb-1 mt30">Location Details</h5>
                      <p><i class="fa-regular fa-circle-info"></i> Prices may vary based on Emirate.</p>
                      <hr>
                      </div>

                      
                    
                  </div>
                  <div class="row" >
                    
                    <div class="col-xl-10 col-lg-10">
                         <label class="form-label fw500 dark-color">Inspection Location</label>
                         <select name="location" id="location" class="form-select">
                            <option value="">Select</option>
                            <option value="Abu Dhabi">Abu Dhabi</option>
                            <option value="Dubai">Dubai</option>
                            <option value="Sharjah">Sharjah</option>
                            <option value="Ajman">Ajman</option>
                            <option value="Ras Al Khaimah">Ras Al Khaimah</option>
                            <option value="Fujairah">Fujairah</option>
                            <option value="Umm Al Quwain">Umm Al Quwain</option>
                          </select>
                          <p id="location-error" style="display: none;color:red;"></p>
                         @error('location')
                                    <p class="text-danger">{{ $message }}</p>
                                        @enderror
                    </div>
                  </div>

                   <div class="row mt25" >
                    
                    <div class="col-xl-10 col-lg-10">
                         <label class="form-label fw500 dark-color">Address</label>
                         <input name="address" type="text" class="form-control " id="address" placeholder="Address">
                          <p id="address-error" style="display: none;color:red;"></p>
                         @error('address')
                                    <p class="text-danger">{{ $message }}</p>
                                        @enderror
                    </div>
                  </div>
                   <div class="row mt25" >
                    
                    <div class="col-xl-10 col-lg-10">
                         <label class="form-label fw500 dark-color">Additional Location Details</label>
                         <textarea name="additional_details" class="form-control " row="5" col="30"  id="additional_details" placeholder="Additional Location Details"></textarea>
                          <p id="additional_details-error" style="display: none;color:red;"></p>
                         @error('additional_details')
                                    <p class="text-danger">{{ $message }}</p>
                                        @enderror
                         
                    </div>
                  </div>


                   <div class="row mt25 where_is_my_car_section" >
                    <label class="form-label fw500 dark-color">Where is car parked?</label>
                    <div class="col-xl-10 col-lg-10">
                         <div class="radio-group radio-checked row">
                          <!-- <div class="row"> -->
                            <div class="col-md-4">
                              <div class="button_weekly">
                              <input type="radio" id="cleaning_once" name="where_is_car_parked" value="Showroom" onclick="cleaning_change(this.value)" checked>
                              <label for="cleaning_once" class="labelclass">
                                <p style="font-weight:1000; "><i class="fas fa-building"></i></p>
                                <p style="margin:0;"><b>Showroom</b></p>
                              </label>
                               
                              </div>
                            </div>
                        <div class="col-md-4">
                            <div class="button_weekly">
                            <input type="radio" id="cleaning_weekly" name="where_is_car_parked" value="Outdoor" onclick="cleaning_change(this.value)">
                              <label for="cleaning_weekly" class="labelclass">
                                <p style="font-weight:1000; "><i class="fa-regular fa-car-building"></i></p>
                                <p style="margin:0;"><b>Outdoor</b></p>
                              </label>
                            </div>
                          </div>
                        <div class="col-md-4">
                            <div class="button_weekly">
                            <input type="radio" id="cleaning_multiple_times" name="where_is_car_parked" value="Home" onclick="cleaning_change(this.value)">
                            <label for="cleaning_multiple_times" class="labelclass">
                                <p style="font-weight:1000; "><i class="fa-regular fa-house"></i></p>
                                <p style="margin:0;"><b>Home</b></p>
                              </label>
                            </div>
                            <p id="cleaning_once-error" style="display: none;color:red;"></p>
                         @error('cleaning_once')
                                    <p class="text-danger">{{ $message }}</p>
                                        @enderror
                            </div>
                            <p class="form-error-text" id="where_is_car_parked_error" style="color: red; margin-top: 10px;">
                        </p>
                            <p class="wicp_info"><i class="fa-regular fa-circle-info"></i> Please ensure enough space for inspection.If a deposit for a test drive is needed, please pay showroom in advance.</p>
                            <!-- </div> -->
                            
                        </div>
                    </div>
                  </div>

                  <div class="row vdtitle" >
                    <div class="col-xl-10 col-lg-10">
                      <h5 class="title mb-3 mt30">Vehicle Details</h5>
                      <hr>
                      </div>

                      
                    
                  </div>
                  @if(isset($vehicles) && count($vehicles) > 0)
                  <div class="row mt25 vehicle_make_sec" >
                    <label class="form-label fw500 dark-color ">Select Vehicle Make</label>
                    <div class="col-xl-10 col-lg-10">
                         <div class="radio-group radio-checked row">
                          <!-- <div class="row"> -->
                            @foreach($vehicles as $index=>$data)
                            <div class="col-md-3">
                              <div class="brand_div">
                              <input type="radio" id="{{$data->name}}" name="vehicle_make" value="{{$data->id}}" onclick="car_change(this.value)" @if($index == 0) checked @endif >
                              <label for="{{$data->name}}" class="labelclass">
                                <img src="{{ asset('public/upload/vehicle/medium/'.$data->image) }}" alt="{{$data->name}}" class="img-fluid">
                                <p><b>{{$data->name}}</b></p>
                              </label>
                              </div>
                            </div>
                            @endforeach
                             <div class="col-md-3">
                            <div class="button_weekly">
                            <input type="radio" id="others" name="vehicle_make" value="0" onclick="car_change(this.value)">
                            <label for="others" class="labelclass">
                                <img src="{{ asset('public/site/images/car/search.jpg') }}" alt="Search" class="img-fluid">
                                <p><b>others</b></p>
                              </label>
                            </div>
                            </div>
                            <p id="vehicle_make-error" style="display: none;color:red;"></p>
                         @error('vehicle_make')
                                    <p class="text-danger">{{ $message }}</p>
                                        @enderror

                        <!-- <div class="col-md-3">
                            <div class="button_weekly">
                            <input type="radio" id="mercedes-benz" name="vehicle_make" value="mercedes-benz" onclick="car_change(this.value)">
                              <label for="mercedes-benz" class="labelclass">
                                <img src="{{ asset('public/site/images/car/mercdez.png') }}" alt="Mercedes-Benz" class="img-fluid">
                                <p><b>Mercedes-Benz</b></p>
                              </label>
                            </div>
                          </div>
                        <div class="col-md-3">
                            <div class="button_weekly">
                            <input type="radio" id="dodge" name="vehicle_make" value="dodge" onclick="car_change(this.value)">
                            <label for="dodge" class="labelclass">
                                <img src="{{ asset('public/site/images/car/mercdez.png') }}" alt="Mercedes-Benz" class="img-fluid">
                                <p><b>Dodge</b></p>
                              </label>
                            </div>
                            </div>

                             <div class="col-md-3">
                            <div class="button_weekly">
                            <input type="radio" id="toyota" name="vehicle_make" value="toyota" onclick="car_change(this.value)">
                            <label for="toyota" class="labelclass">
                                <img src="{{ asset('public/site/images/car/toyota.png') }}" alt="Toyota" class="img-fluid">
                                <p><b>Toyota</b></p>
                              </label>
                            </div>
                            </div>

                            <div class="col-md-3">
                            <div class="button_weekly">
                            <input type="radio" id="audi" name="vehicle_make" value="audi" onclick="car_change(this.value)">
                            <label for="audi" class="labelclass">
                                <img src="{{ asset('public/site/images/car/audi.png') }}" alt="Audi" class="img-fluid">
                                <p><b>Audi</b></p>
                              </label>
                            </div>
                            </div>

                            <div class="col-md-3">
                            <div class="button_weekly">
                            <input type="radio" id="search" name="vehicle_make" value="search" onclick="car_change(this.value)">
                            <label for="search" class="labelclass">
                                <img src="{{ asset('public/site/images/car/search.jpg') }}" alt="Search" class="img-fluid">
                                <p><b>Search</b></p>
                              </label>
                            </div>
                            </div> -->

                            
                        </div>
                    </div>
                  </div>
                  @endif


                  <div class="row mt25 other_car_div"  style="display:none;">
                    <label class="form-label fw500 dark-color">Select Vehicle Make</label>
                    <div class="col-xl-10 col-lg-10">
                        <select name="other_vehicle_make" id="other_vehicle_make" class="form-select" onchange="other_car_change(this.value);">
                            <option value="">Select Vehicle Make</option>
                            @foreach($other_vehicles as $data)
                            <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                          </select>
                    </div>
                     <p id="other_vehicle_make-error" style="display: none;color:red;"></p>
                         @error('other_vehicle_make')
                                    <p class="text-danger">{{ $message }}</p>
                                        @enderror
                  </div>

                  <div class="row mt25 model_div"  style="">
                    <label class="form-label fw500 dark-color">Model</label>
                    <div class="col-xl-10 col-lg-10">
                      <span id="changeModel">
                        <select name="other_vehicle_model" id="other_vehicle_model" class="form-select" onchange="showCategory(this.value);">
                            <option value="">Select Vehicle Model</option>
                            <!-- <option value="Model 1">Model 1</option>
                            <option value="Model 2">Model 2</option>
                            <option value="Model 3">Model 3</option>
                            <option value="Model 4">Model 4</option> -->
                          </select>
                          </span>
                          <p id="other_vehicle_model-error" style="display: none;color:red;"></p>
                           @error('other_vehicle_model')
                                    <p class="text-danger">{{ $message }}</p>
                                        @enderror
                    </div>
                  </div>
                  <div class="col-xl-10 col-lg-10 mt25" id="category_replace" style="display:none;">
                         <label class="form-label fw500 dark-color">Category</label>
                         <input name="category" type="text" class="form-control " id="category" placeholder="Category" val="" readonly>
                    </div>

                   <div class="row vdtitle mt25" >
                    <div class="col-xl-10 col-lg-10">
                      <h5 class="title mb-3 mt30">Slot Selection</h5>
                      <p><i class="fa-regular fa-circle-info"></i> Select your preferred date & time, our time will reach out to you within 24 hours to confirm your date & time based on availability.</p>
                      <hr>
                      </div>
                  </div>
                  <div class="row mt25 model_div"  style="">
                    <label class="form-label fw500 dark-color ">Date</label>
                    <div class="col-xl-10 col-lg-10">
                        <input type="date" name="inspection_date" id="inspection_date" class="form-control " id="" placeholder="Select Date">
                        <p id="inspection_date-error" style="display: none;color:red;"></p>
                           @error('inspection_date')
                                    <p class="text-danger">{{ $message }}</p>
                                        @enderror
                    </div>
                  </div>
                  <div class="row mt25 model_div"  style="">
                    <label class="form-label fw500 dark-color ">Time</label>
                    <div class="col-xl-10 col-lg-10">
                        <select name="inspection_time" id="inspection_time" class="form-select">
                            <option value="">Select Time</option>
                             @foreach($subservice_timeslot_price as $data)
                            <option value="{{$data->time_slot_id}}">{{$data->name}}</option>
                             @endforeach
                            <!-- <option value="9:30 AM - 11:00 AM">9:30 AM - 11:00 AM</option>
                            <option value="10:00 AM - 11:30 AM">10:00 AM - 11:30 AM</option>
                            <option value="10:30 AM - 12:00 PM">10:30 AM - 12:00 PM</option>
                            <option value="11:00 AM - 12:30 PM">11:00 AM - 12:30 PM</option>
                            <option value="11:30 AM - 1:00 PM">11:30 AM - 1:00 PM</option>
                            <option value="12:00 PM - 1:30 PM">12:00 PM - 1:30 PM</option> -->
                          </select>
                    </div>
                    <p id="inspection_time-error" style="display: none;color:red;"></p>
                           @error('inspection_time')
                                    <p class="text-danger">{{ $message }}</p>
                                        @enderror
                  </div>

              </form>
            </div>
          </div>
          <div class="col-lg-4 sidebar-wrapper">
            <div class="column right-sidebar" id="sidebar">
              <div class="blog-sidebar ms-lg-auto">
                <div class="price-widget pt25 bdrs8 summary_div_price">
                  <h2>Total</h2>
                  <hr>
                  <div class="d-flex align-items-center justify-content-between package_div">
                    <p class="text fz14">{{$package->name}}</p>
                    <span class="price" >AED <span id="price">{{$package->price}}</span></span>
                  </div>

                  <div class="d-flex align-items-center justify-content-between price_div">
                    <p class="text fz14">Total</p>
                    <span class="price">AED <span id="totalprice">{{$package->price}}</span></span>
                  </div>
                  
                  <div class="d-grid mt25">
                     <button class="ud-btn btn-thm" type="button" disabled id="spinner_button"
                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>

                                    Loading...

                                </button>
                    <a class="ud-btn btn-thm" id="submit_btn" onclick="book_inspection();">Proceed</a>
                  </div>
                </div>
                <!-- <div class="freelancer-style1 service-single mb-0 bdrs8">
                  <h4>About Buyer</h4>
                  <div class="wrapper d-flex align-items-center mt20">
                    <div class="thumb position-relative mb25">
                      <img class="rounded-circle mx-auto" src="images/team/client-1.png" alt="">
                    </div>
                    <div class="ml20">
                      <h5 class="title mb-1">Dropbox</h5>
                      <p class="mb-0">Digital Marketing</p>
                      <div class="review"><p><i class="fas fa-star fz10 review-color pr10"></i><span class="dark-color">4.9</span> (595 reviews)</p></div>
                    </div>
                  </div>
                  <hr class="opacity-100">
                  <div class="details">
                    <div class="fl-meta d-flex align-items-center justify-content-between">
                      <a class="meta fw500 text-start">Location<br><span class="fz14 fw400">London</span></a>
                      <a class="meta fw500 text-start">Employees<br><span class="fz14 fw400">11-20</span></a>
                      <a class="meta fw500 text-start">Departments<br><span class="fz14 fw400">Designer</span></a>
                    </div>
                  </div>
                  <div class="d-grid mt30">
                    <a href="page-contact.html" class="ud-btn btn-thm-border">Contact Buyer<i class="fal fa-arrow-right-long"></i></a>
                  </div>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    
  <!-- <div class="modal fade login-form-modal" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" data-backdrop="true" data-keyboard="true">
    <div class="modal-dialog user-modal-dialog modal-dialog-centered">
        <div class="modal-content details-modal-content">
          <div class="modal-header details-header">
            <h5 class="modal-title text-center" id="exampleModalLabel">Your Details</h5>
            <button type="button" class="btn-close d-none" data-dismiss="modal" aria-label="Close"></button>
          </div> 
          <div class="modal-body">
            <form class="form-horizontal details-form" id="userDetailForm" method="POST" action="{{ route('user-detail-login') }}">
                @csrf
              <input type="hidden" name="action" id="action" value="user-detail-form">
             <input type="hidden" name="redirectUrl" value="{{ $redirectUrl }}">
              <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
              <input type="hidden" name="subservice_id" id="subservice_id" value="{{ $subservice_id }}">
              <div class="form-group mb-2">
                <label for="user-name">Your Name</label>
                <input type="text" placeholder="Enter Your Name" class="input-field" name="name" id="user-name">
                <p id="name-error" style="display: none;color:red;"></p>
              </div>
              <div class="form-group mb-2">
                <label for="user-name">Your Phone Number</label>
                <input type="hidden" name="country_code" id="country_code" value="">
                <input type="text" class="input-field" name="phone" id="user-phone-number" placeholder="Mobile No" onkeypress="return validateNumber(event)">
                 <p id="phone-error" style="display: none;color:red;"></p>
              </div>
              <div class="form-group mb-2">
                <label for="user-name">Your Email</label>
                 <input type="email" class="input-field" name="email" id="user-email" placeholder="Enter Your Email Address">
                 <p id="email-error" style="display: none;color:red;"></p>
              </div>
              <div class="form-group mb-2">
                <label for="user-name">Your Area</label>
                 <input type="text" class="input-field" name="area" id="user-area" placeholder="Enter Your Area">
                 <p id="area-error" style="display: none;color:red;"></p>
              </div>
             
              <div class="col-md-12 text-center">
                <button type="button" class="ud-btn btn-thm default-box-shadow2 detail-continue-btn" onclick="javascript:userPopupLoginForm()" id="submit_button">Continue</button>
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>
</div> -->

{{-- Login PopModal --}}



<!-- OTP Popup Start-->
<div class="modal modal-mobile-bottom-otp otp-login-form-modal" id="exampleModalLong" tabindex="-1" aria-labelledby="otpLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-bottom-otp user-modal-dialog modal-dialog-centered">
    <div class="modal-content details-modal-content">
      <div class="modal-header details-header">
      <h5 class="modal-title w-100" id="modalStepTitle">Log in or Sign Up</h5>
      </div> 

      <div class="modal-body">
        <div id="booknow_refresh_otp_div">
        <input type="hidden" name="book_session_otp" id="book_session_otp" value= "{{session('book-login-otp')}}">
        </div>
        <form class="form-horizontal details-form" id="BookOtpForm" method="POST" action="{{ route('booknow-user-otp-login') }}">

        <input type="hidden" name="redirectUrl" value="{{ $redirectUrl }}">
        <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
        <input type="hidden" name="subservice_id" id="subservice_id" value="{{ $subservice_id }}">

        @csrf

          <!-- STEP 1: Mobile Input -->
          <div id="booknow-step-phone">
            <div class="form-group mb-2">
              <label id="mobilename-label">Please Enter Your WhatsApp mobile number</label>
              <input type="hidden" name="country_code" id="country_code" value="">
              <input type="text" class="input-field" name="phone" id="user-phone-number" placeholder="Mobile No" onkeypress="return validateNumber(event)">
              <p id="booknow_otp_phone_error" style="display:none;color:red;"></p>
            </div>
			<a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp" data-bs-target="#book_email_otp_popup_Modal">Don't have a WhatsApp Number? Login with Email</a>
            <div class="text-center mt-3">
			
			<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_phone_book1" style="display: none;">
				<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...
            </button>
			
              <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_phone_book1" onclick="booknow_otp_verification('1')">Continue</button>
            </div>
          </div>

          <!-- STEP 2: OTP Verification -->
          <div id="booknow-step-otp" style="display: none;">
            <label id="mobilename-label">Please enter the <strong>WhatsApp code</strong> that was sent to:<br>
              <span id="booknow-whatsapp-number">+971 58 520 0722</span>
            </label>

            <div class="d-flex justify-content-center gap-2 my-3">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
            </div>
            <p id="booknow_otp_error" style="display:none;color:red;"></p>

            <a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp" data-bs-target="#book_email_otp_popup_Modal">Can't log in? Use your Email Address</a>

            <div class="text-center mt-3">
			<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_phone_book2" style="display: none;">
				<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...
            </button>
              <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_phone_book2" onclick="booknow_otp_verification('2')" >Verify Number</button>
            </div>
          </div>

          <!-- STEP 3: Personal Details -->
        <div id="booknow-step-details" style="display: none;">
        <label id="mobilename-label">Contact information</label>
        <div class="form-group mt-3">
            <input type="text" class="form-control" name="book_name" id="booknow_user_name" placeholder="Full Name">
            <p id="booknow_name_error" style="display:none;color:red;"></p>
        </div>
        <div class="form-group mt-3">
            <input type="email" class="form-control" id="booknow_user_email" name="book_email" placeholder="Email">
            <p id="booknow_email_error" style="display:none;color:red;"></p>
        </div>
        <div class="text-center mt-3">
		<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_phone_book3" style="display: none;">

        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>

        <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_phone_book3" onclick="booknow_otp_verification('3')">All Done</button>

        </div>
        
        <div class="mt-3">
            <a href="{{ route('privacy_policy') }}" class="footer-link me-3">Privacy Policy</a>
            <a href="{{ route('term_condition') }}" class="footer-link">Terms of Service</a>
        </div>

        </div>


        </form>
      </div>

    </div>
  </div>
</div>

<!-- OTP Popup End-->


<!-- email OTP Popup Start-->

<div class="modal modal-mobile-bottom-otp otp-login-form-modal" id="book_email_otp_popup_Modal" tabindex="-1" aria-labelledby="otpLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-bottom-otp user-modal-dialog modal-dialog-centered">
    <div class="modal-content details-modal-content">
      <div class="modal-header details-header">
      <h5 class="modal-title w-100" id="booknow_email_modalStepTitle">Log in or Sign Up</h5>
      </div> 

      <div class="modal-body">
        <div id="book_email_refresh_otp_div">
        <input type="hidden" name="book_email_session_otp" id="book_email_session_otp" value= "{{session('book-email-login-otp')}}">
        </div>
        <form class="form-horizontal details-form" id="bookemailOtpForm" method="POST" action="{{ route('home.book-email-otp-login') }}">
        <input type="hidden" name="redirectUrl" value="{{ $redirectUrl }}">
        <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
        <input type="hidden" name="subservice_id" id="subservice_id" value="{{ $subservice_id }}">
          @csrf


          <!-- STEP 1: Mobile Input -->
          <div id="book-email-step-phone">
            <div class="form-group mb-2">
              <label id="mobilename-label">Please Enter Your Email Address</label>
              <input type="text" class="input-field" name="book_email_email" id="book_email_email" placeholder="Email Address">
              <p id="book_email_email_error" style="display:none;color:red;"></p>
            </div>
			<a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp" data-bs-target="#exampleModalLong">Can't access your email? Log in with your WhatsApp
			Number</a>
            <div class="text-center mt-3">
				<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_email_book1"
                                style="display: none;">

                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                Loading...

            </button>
              <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_email_book1" onclick="book_email_goToOtpVerification('1')">Continue</button>
            </div>
          </div>

          <!-- STEP 2: OTP Verification -->
          <div id="booknow-email-step-otp" style="display: none;">
            <label id="mobilename-label">Please enter the <strong>OTP</strong> that was sent to:<br>
			 <span id="book_email_address_model">+971 58 520 0722</span>
            </label>

            <div class="d-flex justify-content-center gap-2 my-3">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
            </div>
            <p id="book_email_otp_error" style="display:none;color:red;"></p>
            <a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp" data-bs-target="#exampleModalLong">Can't access your email? Log in with your WhatsApp
			Number</a>

            <div class="text-center mt-3">
			<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_email_book2" style="display: none;">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>

              <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_email_book2" onclick="book_email_goToOtpVerification('2')" >Verify Email</button>
            </div>
          </div>

          <!-- STEP 3: Personal Details -->
        <div id="booknow-email-step-details" style="display: none;">
        <label id="mobilename-label">Contact information</label>
        <div class="form-group mt-3">
            <input type="text" class="form-control" name="book_email_name" id="book_email_name" placeholder="Full Name">
            <p id="book_email_name_error" style="display:none;color:red;"></p>
        </div>
        <div class="form-group mt-3">
            <input type="text" class="form-control" id="book_email_mobile" name="book_email_mobile" placeholder="Phone Number" onkeypress="return validateNumber(event)">
            <p id="book_email_mobile_error" style="display:none;color:red;"></p>
        </div>
        <div class="form-group mt-3">
            <input type="text" class="form-control" id="book_email_area" name="book_email_area" placeholder="Area">
            <p id="book_email_area_error" style="display:none;color:red;"></p>
        </div>
        <div class="text-center mt-3">
		<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_email_book3" style="display: none;"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>

        <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_email_book3" onclick="book_email_goToOtpVerification('3')">All Done</button>
        </div>

        <div class="mt-3">
            <a href="{{ route('privacy_policy') }}" class="footer-link me-3">Privacy Policy</a>
            <a href="{{ route('term_condition') }}" class="footer-link">Terms of Service</a>
        </div>
        </div>


        </form>
      </div>

    </div>
  </div>
</div>

<!-- Email Otp Popup end -->


@include('front.includes.footer')

<script>
// $(function () {
//   var cols = $('.wrap .column');
//   var footer = $('footer'); // Adjust selector based on your actual footer tag or class
//   var enabled = true;

//   var scrollbalance = new ScrollBalance(cols, {
//     minwidth: 1199
//   });

//   scrollbalance.bind();

//   // Function to check if footer is visible and adjust sidebar
//   // Initial check
// });
</script>
 <!-- <script>
    const sidebar = document.getElementById('rightSidebar');
    const footer = document.querySelector('.footer-style1');

    function handleSidebarPosition() {
      const sidebarBottom = sidebar.getBoundingClientRect().bottom;
      const footerTop = footer.getBoundingClientRect().top;

      if (sidebarBottom >= footerTop) {
        sidebar.classList.add('stop-at-footer');
      } else {
        sidebar.classList.remove('stop-at-footer');
      }
    }

    window.addEventListener('scroll', handleSidebarPosition);
    window.addEventListener('resize', handleSidebarPosition);
    document.addEventListener('DOMContentLoaded', handleSidebarPosition);
  </script> -->

<script>
  const sidebar = document.getElementById('sidebar');
  const sidebarWrapper = document.querySelector('.sidebar-wrapper');
  const footer = document.querySelector('.footer-style1');

  function updateSidebarPosition() {
    // Only run on large screens (like ScrollBalance minwidth)
    if (window.innerWidth < 1199) {
      sidebar.classList.remove('fixed-sidebar', 'absolute-sidebar');
      sidebar.style.top = '';
      return;
    }

    const sidebarHeight = sidebar.offsetHeight + 110;
    const sidebarTop = sidebarWrapper.getBoundingClientRect().top + window.scrollY;
    const footerTop = footer.getBoundingClientRect().top + window.scrollY;
    const scrollY = window.scrollY;
    const fixedTop = 0;
    const sidebarBottom = scrollY + sidebarHeight;

    if (sidebarBottom >= footerTop) {
      sidebar.classList.remove('fixed-sidebar');
      sidebar.classList.add('absolute-sidebar');
      sidebar.style.top = (footerTop - sidebarTop - sidebarHeight) + 'px';
    } else {
      sidebar.classList.remove('absolute-sidebar');
      sidebar.classList.add('fixed-sidebar');
      sidebar.style.top = '190px';
    }
  }

  window.addEventListener('scroll', updateSidebarPosition);
  window.addEventListener('resize', updateSidebarPosition);
  document.addEventListener('DOMContentLoaded', updateSidebarPosition);

  $(document).ready(function () {
    var defaultCar = $('input[name="vehicle_make"]:checked').val();
    if (defaultCar) {
        car_change(defaultCar); // This already checks if value === '0'
        
       
    }
});

  function car_change(value) {
    //alert(value);exit;
    if (value === '0') {
      document.querySelector('.other_car_div').style.display = 'block';
      
      var select = document.getElementById('other_vehicle_model');
      select.innerHTML = '<option value="">Select Vehicle Model</option>';

    } else {
      document.querySelector('.other_car_div').style.display = 'none';
    }
        $.ajax({
            type:"Post",
             url: "{{ url('change_model') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "value": value,
                },
                success: function(returndata) {
                        
                       //alert(returndata.html);

                        $('#changeModel').html(returndata.html);
                         $('#category_replace').hide();
                        $('#category').val('');
                    // if (returndata == 1)

                    //    
                    // $('.success_show').show().delay(0).fadeIn('show');
                    // $('.success_show').show().delay(5000).fadeOut('show');
                    // $('#status_modell').modal('hide');
                }
        });

  }

    function other_car_change(val){
        $.ajax({
            type:"Post",
             url: "{{ url('change_model') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "value": val,
                },
                success: function(returndata) {
                        
                       //alert(returndata.html);
                        document.querySelector('.other_car_div').style.display = 'block';
                        $('#changeModel').html(returndata.html);
                        $('#category_replace').hide();
                        $('#category').val('');
                    // if (returndata == 1)

                    //    
                    // $('.success_show').show().delay(0).fadeIn('show');
                    // $('.success_show').show().delay(5000).fadeOut('show');
                    // $('#status_modell').modal('hide');
                }
        });

    }
   function showCategory(val){

    // alert(val);
          $.ajax({
            type:"Post",
             url: "{{ url('show_category') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "value": val,
                },
                success: function(returndata) {
                        
                       //alert(returndata.html);

                        $('#changeModel').html(returndata.html);
                       if (returndata.price !== null && returndata.price !== undefined && returndata.price !== '') {
                        $('#price').text(returndata.price);
                        $('#totalprice').text(returndata.price);
                        $('#total_amount').val(returndata.price);
                        }
                        $('#category_replace').show();
                        $('#category').val(returndata.category);
                    // if (returndata == 1)

                    //    
                    // $('.success_show').show().delay(0).fadeIn('show');
                    // $('.success_show').show().delay(5000).fadeOut('show');
                    // $('#status_modell').modal('hide');
                }
        });

   }
$(document).ready(function () {
  // Lock both modals on load
  $('#exampleModalLong').modal({
    backdrop: 'static',
    keyboard: false,
    show: false // Don't show initially
  });

  $('#book_email_otp_popup_Modal').modal({
    backdrop: 'static',
    keyboard: false,
    show: false
  });

  // Show if user not logged in
  @if(Session::get('user') == "")
    $('#exampleModalLong').modal('show');
  @endif
});
function validateNumber(event) {
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode === 8 || event.keyCode === 46) {
        return true;
    } else if (key < 48 || key > 57) {
        return false;
    } else {
        return true;
    }
}
const phoneInputField = document.querySelector("#user-phone-number"); // flagphone
const phoneInput = window.intlTelInput(phoneInputField, {
  initialCountry: "ae",  // UAE flag and country code (+971) as default
  separateDialCode: true, // Separate country code from the number field
  autoPlaceholder: "aggressive",
  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
});

 
function booknow_otp_verification(id) {
    // STEP 1: Mobile Input
    // alert('here');
    if (id == '1') {
        var mobile = jQuery("#user-phone-number").val().trim();
        // alert(mobile);

        const selectedCountryCode = getCountryCode();
        $("#country_code").val(selectedCountryCode);
        if (mobile == '') {

        jQuery('#booknow_otp_phone_error').html("Please Enter Mobile No");
        jQuery('#booknow_otp_phone_error').show().delay(0).fadeIn('show');
        jQuery('#booknow_otp_phone_error').show().delay(2000).fadeOut('show');
        return false;

        }
        if (mobile != '') {
            // var filter = /^\d{7}$/;
            if (mobile.length < 7 || mobile.length > 15) {
                jQuery('#booknow_otp_phone_error').html("Please Enter Valid Mobile Number");
                jQuery('#booknow_otp_phone_error').show().delay(0).fadeIn('show');
                jQuery('#booknow_otp_phone_error').show().delay(2000).fadeOut('show');
                return false;
            }
        }

        var url = '{{ url('booknow-otp-sent') }}';
        var mobile = $('#user-phone-number').val();
        var country_code = $('#country_code').val();
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                'mobile': mobile,
                'country_code': country_code
            },
            beforeSend: function () {
                
				$('#spinner_button_phone_book1').show();
				$('#submit_button_phone_book1').hide();
                //$('.detail-continue-btn').prop('disabled', true);
            },
            success: function (response) {
                
                if(response.success === true){
                 
                $("#booknow_refresh_otp_div").load(location.href + " #booknow_refresh_otp_div");

                document.getElementById('booknow-step-phone').style.display = 'none';
                document.getElementById('booknow-step-otp').style.display = 'block';
                document.getElementById('modalStepTitle').innerText = "Verify your phone number";

                $('#booknow-whatsapp-number').text('+' + country_code  + mobile);
                
                if (response.user_data) {
                    $('#booknow_user_name').val(response.user_data.name);
                    $('#booknow_user_email').val(response.user_data.email);
                }

                }

				$('#spinner_button_phone_book1').hide();
				$('#submit_button_phone_book1').show();

                
            },
            error: function (xhr) {

               if (xhr.responseJSON && xhr.responseJSON.message) {
                    alert(xhr.responseJSON.message);
                    $('#exampleModalLong form')[0].reset();
                    $('#exampleModalLong #spinner_button_phone_book1').hide();
                    $('#exampleModalLong #submit_button_phone_book1').show();
                    $('#exampleModalLong').modal('show'); 
                } else {
                    alert("Failed to send OTP. Please try again.");
                     $('#exampleModalLong form')[0].reset();
                    $('#exampleModalLong #spinner_button_phone_book1').hide();
                    $('#exampleModalLong #submit_button_phone_book1').show();
                    $('#exampleModalLong').modal('show'); 
                }
                
            },
            complete: function () {
                $('.detail-continue-btn').prop('disabled', false);
            }
        });

        return false;

       
    }

    // STEP 2: OTP Verification
    if (id == '2') {
        var allFilled = true;
        jQuery('.booknow-otp-input').each(function () {
            if (jQuery(this).val().trim() === '') {
                allFilled = false;
            }
        });

        if (!allFilled) {
            jQuery('#booknow_otp_error').html("Please Enter OTP");
            jQuery('#booknow_otp_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_otp_error').show().delay(2000).fadeOut('show');
            return false;
        }

        let otp = $('#book_session_otp').val();
        // alert(otp);
        let enteredOtp = '';
        document.querySelectorAll('.booknow-otp-input').forEach(input => {
            enteredOtp += input.value;
        });
        // alert(enteredOtp);

        if(otp != enteredOtp){
            jQuery('#booknow_otp_error').html("OTP doesn't match");
            jQuery('#booknow_otp_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_otp_error').show().delay(2000).fadeOut('show');
            return false;
        }
        
      

        let name = jQuery("input[name='book_name']").val().trim();
        let email = jQuery("input[name='book_email']").val().trim();
		
		$('#spinner_button_phone_book2').show();
		$('#submit_button_phone_book2').hide();

        if (name !== '' && email !== '' ) {
                jQuery("#BookOtpForm").submit();
        } else {
            document.getElementById('booknow-step-otp').style.display = 'none';
            document.getElementById('booknow-step-details').style.display = 'block';
            document.getElementById('modalStepTitle').innerText = "Personal Details";
        }
    }

    // STEP 3: Personal Details
    if (id == '3') {
        var name = jQuery("input[name='book_name']").val().trim();
        var email = jQuery("input[name='book_email']").val().trim();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (name === '') {

            jQuery('#booknow_name_error').html("Please Enter Full  Name");
            jQuery('#booknow_name_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_name_error').show().delay(2000).fadeOut('show');
            return false;
        }
        if (email === '') {
            jQuery('#booknow_email_error').html("Please Enter email");
            jQuery('#booknow_email_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_email_error').show().delay(2000).fadeOut('show');
            return false;
        }

        if (!emailRegex.test(email)) {
            jQuery('#booknow_email_error').html("Please Enter Valid email");
            jQuery('#booknow_email_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_email_error').show().delay(2000).fadeOut('show');
            return false;
        }
        
		$('#spinner_button_phone_book3').show();
		$('#submit_button_phone_book3').hide();

        // All validation passed, submit the form
        jQuery("#BookOtpForm").submit();
    }
}

$(document).ready(function () {
    $('.booknow-otp-input').on('input', function () {
        let input = $(this);
        let value = input.val();
        if (/^\d$/.test(value)) {
            input.next('.booknow-otp-input').focus();
        } else {
            input.val('');
        }
    });

    $('.booknow-otp-input').on('keydown', function (e) {
        let input = $(this);
        if (e.key === "Backspace" && input.val() === '') {
            input.prev('.booknow-otp-input').focus();
        }
    });

    $('.booknow-otp-input').on('paste', function (e) {
        let data = e.originalEvent.clipboardData.getData('text');
        let digits = data.replace(/\D/g, '').substring(0, 6).split('');
        $('.booknow-otp-input').each(function (index, element) {
            $(element).val(digits[index] || '');
        });
        if (digits.length > 0) {
            $('.booknow-otp-input').eq(digits.length - 1).focus();
        }
        e.preventDefault();
    });
});

function book_email_goToOtpVerification(id) {
	
	if (id == '1') {
		
        
		var email_email = jQuery("input[name='book_email_email']").val().trim();
		var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		if (email_email === '') {
            jQuery('#book_email_email_error').html("Please Enter email");
            jQuery('#book_email_email_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_email_error').show().delay(2000).fadeOut('show');
            return false;
        }

        if (!emailRegex.test(email_email)) {
            jQuery('#book_email_email_error').html("Please Enter Valid email");
            jQuery('#book_email_email_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_email_error').show().delay(2000).fadeOut('show');
            return false;
        }
		
		// alert(email_email);
		
		var url = '{{ route('home.book-email-otp-sent') }}';
      
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                'email_email': email_email
            },
            beforeSend: function () {
				
				$('#spinner_button_email_book1').show();
				$('#submit_button_email_book1').hide();
                
                //$('.email-detail-continue-btn').prop('disabled', true);
            },
            success: function (response) {
                
                if(response.success === true){
                 
					$("#book_email_refresh_otp_div").load(location.href + " #book_email_refresh_otp_div");

					document.getElementById('book-email-step-phone').style.display = 'none';
					document.getElementById('booknow-email-step-otp').style.display = 'block';
					document.getElementById('booknow_email_modalStepTitle').innerText = "Verify your Email";

					$('#book_email_address_model').text(email_email);
					
					if (response.user_data) {
						$('#book_email_name').val(response.user_data.name);
						$('#book_email_mobile').val(response.user_data.mobile);
						$('#book_email_area').val(response.user_data.area);
					}

                }

                
            },
            error: function (xhr) {

              if (xhr.responseJSON && xhr.responseJSON.message) {
                    alert(xhr.responseJSON.message);
                    $('#book_email_otp_popup_Modal form')[0].reset();
                    $('#book_email_otp_popup_Modal #spinner_button_email_book1').hide();
                    $('#book_email_otp_popup_Modal #submit_button_email_book1').hide();
                    $('#book_email_otp_popup_Modal').modal('show'); 
                } else {
                    alert("Failed to send OTP. Please try again.");
                    $('#book_email_otp_popup_Modal form')[0].reset();
                    $('#book_email_otp_popup_Modal #spinner_button_email_book1').hide();
                    $('#book_email_otp_popup_Modal #submit_button_email_book1').hide();
                    $('#book_email_otp_popup_Modal').modal('show'); 
                }
				
              $('#spinner_button_email_book1').hide();
              $('#submit_button_email_book1').show();
                
            },
            complete: function () {
				
				$('#spinner_button_email_book1').hide();
				$('#submit_button_email_book1').show();
                // Re-enable button
                //$('.email-detail-continue-btn').prop('disabled', false);
            }
        });
		
	}
	
	// STEP 2: OTP Verification
    if (id == '2') {
        var allFilled = true;
        jQuery('.book-email-otp-input').each(function () {
            if (jQuery(this).val().trim() === '') {
                allFilled = false;
            }
        });

        if (!allFilled) {
            jQuery('#book_email_otp_error').html("Please Enter OTP");
            jQuery('#book_email_otp_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_otp_error').show().delay(2000).fadeOut('show');
            return false;
        }

        let otp = $('#book_email_session_otp').val();
        let enteredOtp = '';
        document.querySelectorAll('.book-email-otp-input').forEach(input => {
            enteredOtp += input.value;
        });
        // alert(otp);

        if(otp != enteredOtp){
            jQuery('#book_email_otp_error').html("OTP doesn't match");
            jQuery('#book_email_otp_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_otp_error').show().delay(2000).fadeOut('show');
            return false;
        }
       

        let email_name = jQuery("input[name='book_email_name']").val().trim();
        let email_mobile = jQuery("input[name='book_email_mobile']").val().trim();
		
		$('#spinner_button_email_book2').show();
		$('#submit_button_email_book2').hide();

        if (email_name !== '' && email_mobile !== '') {
           
            jQuery("#bookemailOtpForm").submit();
           
        } else {
            // One or both fields are empty, show Step 3
            document.getElementById('booknow-email-step-otp').style.display = 'none';
            document.getElementById('booknow-email-step-details').style.display = 'block';
            document.getElementById('booknow_email_modalStepTitle').innerText = "Personal Details";
			
			$('#spinner_button_email_book2').hide();
			$('#submit_button_email_book2').show();
        }
    }

    // STEP 3: Personal Details
    if (id == '3') {
        var email_name = jQuery("input[name='book_email_name']").val().trim();
        var email_mobile = jQuery("input[name='book_email_mobile']").val().trim();
        var email_area = jQuery("input[name='book_email_area']").val().trim();

        if (email_name === '') {

            jQuery('#book_email_name_error').html("Please Enter Full  Name");
            jQuery('#book_email_name_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_name_error').show().delay(2000).fadeOut('show');
            return false;
        }
        if (email_mobile === '') {
            jQuery('#book_email_mobile_error').html("Please Enter Mobile Number");
            jQuery('#book_email_mobile_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_mobile_error').show().delay(2000).fadeOut('show');
            return false;
        }

        if (email_mobile != '') {
            // var filter = /^\d{7}$/;
            if (email_mobile.length < 7 || email_mobile.length > 15) {
                jQuery('#book_email_mobile_error').html("Please Enter Valid Mobile Number");
                jQuery('#book_email_mobile_error').show().delay(0).fadeIn('show');
                jQuery('#book_email_mobile_error').show().delay(2000).fadeOut('show');
                return false;
            }
        }
          if (email_area === '') {

            jQuery('#book_email_area_error').html("Please Enter Area");
            jQuery('#book_email_area_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_area_error').show().delay(2000).fadeOut('show');
            return false;
        }
		
		$('#spinner_button_email_book3').show();
		$('#submit_button_email_book3').hide();

        // All validation passed, submit the form
        jQuery("#bookemailOtpForm").submit();
    }
}

$(document).ready(function () {
    $('.book-email-otp-input').on('input', function () {
        let input = $(this);
        let value = input.val();
        if (/^\d$/.test(value)) {
            input.next('.book-email-otp-input').focus();
        } else {
            input.val('');
        }
    });

    $('.book-email-otp-input').on('keydown', function (e) {
        let input = $(this);
        if (e.key === "Backspace" && input.val() === '') {
            input.prev('.book-email-otp-input').focus();
        }
    });

    $('.book-email-otp-input').on('paste', function (e) {
        let data = e.originalEvent.clipboardData.getData('text');
        let digits = data.replace(/\D/g, '').substring(0, 6).split('');
        $('.book-email-otp-input').each(function (index, element) {
            $(element).val(digits[index] || '');
        });
        if (digits.length > 0) {
            $('.book-email-otp-input').eq(digits.length - 1).focus();
        }
        e.preventDefault();
    });
});

document.addEventListener('DOMContentLoaded', function () {
  const otpModal = document.getElementById('exampleModalLong');

  otpModal.addEventListener('shown.bs.modal', function () {
    // Reset to step 1
    document.getElementById('booknow-step-phone').style.display = 'block';
    document.getElementById('book-email-step-phone').style.display = 'block';
    document.getElementById('booknow-step-otp').style.display = 'none';
    document.getElementById('booknow-step-details').style.display = 'none';
    document.getElementById('booknow-email-step-otp').style.display = 'none';
    document.getElementById('booknow-email-step-details').style.display = 'none';

    // Reset input fields
    document.getElementById('user-phone-number').value = '';
    document.getElementById('booknow_user_name').value = '';
    document.getElementById('booknow_user_email').value = '';
    document.getElementById('booknow_user_area').value = '';
    document.getElementById('book_email_email').value = '';
    document.getElementById('book_email_name').value = '';
    document.getElementById('book_email_mobile').value = '';
    document.getElementById('book_email_area').value = '';
    document.querySelectorAll('.booknow-otp-input').forEach(input => input.value = '');
    document.querySelectorAll('.book-email-otp-input').forEach(input => input.value = '');

    // Hide errors
    document.getElementById('booknow_otp_phone_error').style.display = 'none';
    document.getElementById('booknow_otp_error').style.display = 'none';
    document.getElementById('booknow_name_error').style.display = 'none';
    document.getElementById('booknow_email_error').style.display = 'none';
    document.getElementById('booknow_area_error').style.display = 'none';
    document.getElementById('book_email_email_error').style.display = 'none';
    document.getElementById('book_email_otp_error').style.display = 'none';
    document.getElementById('book_email_name_error').style.display = 'none';
    document.getElementById('book_email_mobile_error').style.display = 'none';
    document.getElementById('book_email_area_error').style.display = 'none';

    // Reset spinner buttons and enable primary buttons
    ['1', '2', '3'].forEach(step => {
      document.getElementById(`spinner_button_phone_book${step}`).style.display = 'none';
      document.getElementById(`submit_button_phone_book${step}`).style.display = 'inline-block';
    });
    ['1', '2', '3'].forEach(step => {
      document.getElementById(`spinner_button_email_book${step}`).style.display = 'none';
      document.getElementById(`submit_button_email_book${step}`).style.display = 'inline-block';
    });
  });
});

// function userPopupLoginForm(){

// var name = $('#user-name').val();
// if (name == '') {
//     jQuery('#name-error').html("Please enter a your name");
//     jQuery('#name-error').show().delay(0).fadeIn('show');
//     jQuery('#name-error').show().delay(2000).fadeOut('show');
//     return false;
// }

// var email = $('#user-email').val();
// if (email == '') {
//     jQuery('#email-error').html("Please enter a your email");
//     jQuery('#email-error').show().delay(0).fadeIn('show');
//     jQuery('#email-error').show().delay(2000).fadeOut('show');
//     return false;
// }

// var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
// if (!filter.test(email)) {

//     jQuery('#email-error').html("Please Enter Valid Email");
//     jQuery('#email-error').show().delay(0).fadeIn('show');
//     jQuery('#email-error').show().delay(2000).fadeOut('show');
//     return false;

// }

// var mobile = jQuery("#user-phone-number").val();
// if (mobile == '') {

//     jQuery('#phone-error').html("Please Enter Mobile No");
//     jQuery('#phone-error').show().delay(0).fadeIn('show');
//     jQuery('#phone-error').show().delay(2000).fadeOut('show');
//     return false;

// }
// if (mobile != '') {
//     // var filter = /^\d{7}$/;
//     if (mobile.length < 7 || mobile.length > 15) {
//         jQuery('#phone-error').html("Please Enter Valid Mobile Number");
//         jQuery('#phone-error').show().delay(0).fadeIn('show');
//         jQuery('#phone-error').show().delay(2000).fadeOut('show');
//         return false;
//     }
// }
// var area = jQuery("#user-area").val();
// if (area == '') {

//     jQuery('#area-error').html("Please Enter Area");
//     jQuery('#area-error').show().delay(0).fadeIn('show');
//     jQuery('#area-error').show().delay(2000).fadeOut('show');
//     return false;

// }

// const selectedCountryCode = getCountryCode();
// $("#country_code").val(selectedCountryCode);
// $("#userDetailForm").submit();
// }




function getCountryCode() {
  const countryData = phoneInput.getSelectedCountryData();
  const countryCode = countryData.dialCode; // Get the dial code (country code)
  console.log(countryCode); // Example: "+971" for UAE
  return countryCode;
}
function book_inspection(){
       var mobile = $('#mobile').val();
if (mobile == '') {
    jQuery('#mobile-error').html("Please enter a Mobile No");
    jQuery('#mobile-error').show().delay(0).fadeIn('show');
    jQuery('#mobile-error').show().delay(2000).fadeOut('show');
     $('html, body').animate({
                                scrollTop: $('#mobile').offset().top - 150
                            }, 1000);
    return false;
}
  var location = $('#location').val();
if (location == '') {
    jQuery('#location-error').html("Please Select Inspection Location");
    jQuery('#location-error').show().delay(0).fadeIn('show');
    jQuery('#location-error').show().delay(2000).fadeOut('show');
     $('html, body').animate({
                                scrollTop: $('#mobile').offset().top - 150
                            }, 1000);
    return false;
}
  var address = $('#address').val();
if (address == '') {
    jQuery('#address-error').html("Please enter an Address");
    jQuery('#address-error').show().delay(0).fadeIn('show');
    jQuery('#address-error').show().delay(2000).fadeOut('show');
     $('html, body').animate({
                                scrollTop: $('#address').offset().top - 150
                            }, 1000);
    return false;
}
  
var where_is_car_parked = $('input[name="where_is_car_parked"]:checked').val();

if (!where_is_car_parked) {
jQuery('#where_is_car_parked_error').html("Please Select a Where is car parked");
    jQuery('#where_is_car_parked_error').show().delay(0).fadeIn('show');
    jQuery('#where_is_car_parked_error').show().delay(2000).fadeOut('show');
    // Scroll to radio section if needed
    $('html, body').animate({
        scrollTop: $('.where_is_my_car_section').offset().top - 150
    }, 1000);

    return false;
}
var vehicle_make = $('input[name="vehicle_make"]:checked').val();

if (!vehicle_make) {
jQuery('#vehicle_make-error').html("Please Select a Vehicle Make");
    jQuery('#vehicle_make-error').show().delay(0).fadeIn('show');
    jQuery('#vehicle_make-error').show().delay(2000).fadeOut('show');
    // Scroll to radio section if needed
    $('html, body').animate({
        scrollTop: $('.vehicle_make_sec').offset().top - 150
    }, 1000);

    return false;
}
// alert(vehicle_make);exit;
 if(vehicle_make == '0'){

    var other_vehicle_make = $('#other_vehicle_make').val();
    if (other_vehicle_make == '') {
        jQuery('#other_vehicle_make-error').html("Please Select a Vehicle Make");
        jQuery('#other_vehicle_make-error').show().delay(0).fadeIn('show');
        jQuery('#other_vehicle_make-error').show().delay(2000).fadeOut('show');
        // Scroll to select section if needed
        $('html, body').animate({
            scrollTop: $('.other_car_div').offset().top - 150
        }, 1000);
        return false;
    }

 }else{

   var other_vehicle_model = $('#other_vehicle_model').val();
    //alert(other_vehicle_model);exit;

    if (other_vehicle_model == '') {
        jQuery('#other_vehicle_model-error').html("Please Select a Vehicle Model");
        jQuery('#other_vehicle_model-error').show().delay(0).fadeIn('show');
        jQuery('#other_vehicle_model-error').show().delay(2000).fadeOut('show');
        // Scroll to select section if needed
        $('html, body').animate({
            scrollTop: $('#other_vehicle_model').offset().top - 150
        }, 1000);
        return false;
    }
     var inspection_date = $('#inspection_date').val();
    if (inspection_date == '') {
        jQuery('#inspection_date-error').html("Please Select a Date");
        jQuery('#inspection_date-error').show().delay(0).fadeIn('show');
        jQuery('#inspection_date-error').show().delay(2000).fadeOut('show');
        // Scroll to select section if needed
        $('html, body').animate({
            scrollTop: $('#inspection_date').offset().top - 150
        }, 1000);
        return false;
    }
        var inspection_time = $('#inspection_time').val();
    if (inspection_time == '') {
        jQuery('#inspection_time-error').html("Please Select a Time");
        jQuery('#inspection_time-error').show().delay(0).fadeIn('show');
        jQuery('#inspection_time-error').show().delay(2000).fadeOut('show');
        // Scroll to select section if needed
        $('html, body').animate({
            scrollTop: $('#inspection_time').offset().top - 150
        }, 1000);
        return false;
    }

        

 }
 $('#spinner_button').show();
 $('#submit_btn').hide();
 $('#category_form').submit();




}

</script>



