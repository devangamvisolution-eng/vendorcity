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
    
    {{-- Login PopModal --}}
  <div class="modal fade login-form-modal" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" data-backdrop="true" data-keyboard="true">
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
</div>
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
   @if(Session::get('user') =="")
$(document).ready(function() {
  $('#exampleModalLong').modal({
    backdrop: 'static',  // Prevent closing on clicking outside
    keyboard: false       // Prevent closing with ESC key
  }).modal('show');      // Show the modal on page load
});

$(document).ready(function() {
    $('#exampleModalLong').modal('show'); // Show the modal on page load
  });
@endif
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
function userPopupLoginForm(){

var name = $('#user-name').val();
if (name == '') {
    jQuery('#name-error').html("Please enter a your name");
    jQuery('#name-error').show().delay(0).fadeIn('show');
    jQuery('#name-error').show().delay(2000).fadeOut('show');
    return false;
}

var email = $('#user-email').val();
if (email == '') {
    jQuery('#email-error').html("Please enter a your email");
    jQuery('#email-error').show().delay(0).fadeIn('show');
    jQuery('#email-error').show().delay(2000).fadeOut('show');
    return false;
}

var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
if (!filter.test(email)) {

    jQuery('#email-error').html("Please Enter Valid Email");
    jQuery('#email-error').show().delay(0).fadeIn('show');
    jQuery('#email-error').show().delay(2000).fadeOut('show');
    return false;

}

var mobile = jQuery("#user-phone-number").val();
if (mobile == '') {

    jQuery('#phone-error').html("Please Enter Mobile No");
    jQuery('#phone-error').show().delay(0).fadeIn('show');
    jQuery('#phone-error').show().delay(2000).fadeOut('show');
    return false;

}
if (mobile != '') {
    // var filter = /^\d{7}$/;
    if (mobile.length < 7 || mobile.length > 15) {
        jQuery('#phone-error').html("Please Enter Valid Mobile Number");
        jQuery('#phone-error').show().delay(0).fadeIn('show');
        jQuery('#phone-error').show().delay(2000).fadeOut('show');
        return false;
    }
}
var area = jQuery("#user-area").val();
if (area == '') {

    jQuery('#area-error').html("Please Enter Area");
    jQuery('#area-error').show().delay(0).fadeIn('show');
    jQuery('#area-error').show().delay(2000).fadeOut('show');
    return false;

}

const selectedCountryCode = getCountryCode();
$("#country_code").val(selectedCountryCode);
$("#userDetailForm").submit();
}
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



