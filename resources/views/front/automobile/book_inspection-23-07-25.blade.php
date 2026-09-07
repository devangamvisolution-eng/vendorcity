@include('front.includes.header')
<style>

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
      top: 121px;
      /* width: 25%; */
    }

    .absolute-sidebar {
      position: absolute;
    }

    
.summary_div_price{
      background-color: #fff;
    border: inherit;
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
    padding: 26px 10px;
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
  gap: 9.75rem;
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
                <form id="category_form" action="" method="POST">
                  @csrf

                  <div class="row" >
                    <div class="col-xl-10 col-lg-10">
                         <label class="form-label fw500 dark-color">Your Number</label>
                         <input name="mobile" type="text" class="form-control " id="" placeholder="Your Number">
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
                         <select name="location" class="form-select">
                            <option value="">Select</option>
                            <option value="Abu Dhabi">Abu Dhabi</option>
                            <option value="Dubai">Dubai</option>
                            <option value="Sharjah">Sharjah</option>
                            <option value="Ajman">Ajman</option>
                            <option value="Ras Al Khaimah">Ras Al Khaimah</option>
                            <option value="Fujairah">Fujairah</option>
                            <option value="Umm Al Quwain">Umm Al Quwain</option>
                          </select>
                         
                    </div>
                  </div>

                   <div class="row mt25" >
                    
                    <div class="col-xl-10 col-lg-10">
                         <label class="form-label fw500 dark-color">Address</label>
                         <input name="address" type="text" class="form-control " id="" placeholder="Address">
                    </div>
                  </div>
                   <div class="row mt25" >
                    
                    <div class="col-xl-10 col-lg-10">
                         <label class="form-label fw500 dark-color">Additional Location Details</label>
                         <textarea name="additional_details" class="form-control " row="5" col="30"  id="" placeholder="Additional Location Details"></textarea>
                         
                    </div>
                  </div>


                   <div class="row mt25 where_is_my_car_section" >
                    <label class="form-label fw500 dark-color">Where is car parked?</label>
                    <div class="col-xl-10 col-lg-10">
                         <div class="radio-group radio-checked row">
                          <!-- <div class="row"> -->
                            <div class="col-md-4">
                              <div class="button_weekly">
                              <input type="radio" id="cleaning_once" name="how_often_do_you_need_cleaning" value="Once" onclick="cleaning_change(this.value)" checked>
                              <label for="cleaning_once" class="labelclass">
                                <p style="font-weight:1000; "><i class="fas fa-building"></i></p>
                                <p><b>Showroom</b></p>
                              </label>
                              </div>
                            </div>
                        <div class="col-md-4">
                            <div class="button_weekly">
                            <input type="radio" id="cleaning_weekly" name="how_often_do_you_need_cleaning" value="Weekly" onclick="cleaning_change(this.value)">
                              <label for="cleaning_weekly" class="labelclass">
                                <p style="font-weight:1000; "><i class="fa-regular fa-car-building"></i></p>
                                <p><b>Outdoor</b></p>
                              </label>
                            </div>
                          </div>
                        <div class="col-md-4">
                            <div class="button_weekly">
                            <input type="radio" id="cleaning_multiple_times" name="how_often_do_you_need_cleaning" value="Multiple times a week" onclick="cleaning_change(this.value)">
                            <label for="cleaning_multiple_times" class="labelclass">
                                <p style="font-weight:1000; "><i class="fa-regular fa-house"></i></p>
                                <p><b>Home</b></p>
                              </label>
                            </div>
                            </div>

                            <p class="wicp_info"><i class="fa-regular fa-circle-info"></i> Please ensure enough space for inspection.If a deposit for a test drive is needed, please pay showroom in advance.</p>
                            <!-- </div> -->
                            <p class="form-error-text" id="how_often_do_you_need_cleaning_error" style="color: red; margin-top: 10px;">
                        </p>
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
                            @foreach($vehicles as $data)
                            <div class="col-md-3">
                              <div class="brand_div">
                              <input type="radio" id="nissan" name="vehicle_make" value="nissan" onclick="car_change(this.value)" checked>
                              <label for="nissan" class="labelclass">
                                <img src="{{ asset('public/upload/vehicle/medium/'.$data->image) }}" alt="{{$data->name}}" class="img-fluid">
                                <p><b>{{$data->name}}</b></p>
                              </label>
                              </div>
                            </div>
                            @endforeach

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
                    <label class="form-label fw500 dark-color ">Select Vehicle Make</label>
                    <div class="col-xl-10 col-lg-10">
                        <select name="vehicle_make" class="form-select">
                            <option value="">Select Vehicle Make</option>
                            <option value="Model 1">Ferrari</option>
                            <option value="Model 2">BMW</option>
                            <option value="Model 3">Devinci</option>
                            <option value="Model 4">Honda</option>
                          </select>
                    </div>
                  </div>

                  <div class="row mt25 model_div"  style="">
                    <label class="form-label fw500 dark-color ">Model</label>
                    <div class="col-xl-10 col-lg-10">
                        <select name="vehicle_model" class="form-select">
                            <option value="">Select Vehicle Model</option>
                            <option value="Model 1">Model 1</option>
                            <option value="Model 2">Model 2</option>
                            <option value="Model 3">Model 3</option>
                            <option value="Model 4">Model 4</option>
                          </select>
                    </div>
                  </div>

                   <div class="row vdtitle mt25" >
                    <div class="col-xl-10 col-lg-10">
                      <h5 class="title mb-3 mt30">Slot Selection</h5>
                      <hr>
                      </div>
                  </div>
                  <div class="row mt25 model_div"  style="">
                    <label class="form-label fw500 dark-color ">Date</label>
                    <div class="col-xl-10 col-lg-10">
                        <input type="date" name="inspection_date" class="form-control " id="" placeholder="Select Date">
                    </div>
                  </div>
                  <div class="row mt25 model_div"  style="">
                    <label class="form-label fw500 dark-color ">Time</label>
                    <div class="col-xl-10 col-lg-10">
                        <select name="inspection_time" class="form-select">
                            <option value="">Select Time</option>
                            <option value="9:00 AM - 10:30 AM">9:00 AM - 10:30 AM</option>
                            <option value="9:30 AM - 11:00 AM">9:30 AM - 11:00 AM</option>
                            <option value="10:00 AM - 11:30 AM">10:00 AM - 11:30 AM</option>
                            <option value="10:30 AM - 12:00 PM">10:30 AM - 12:00 PM</option>
                            <option value="11:00 AM - 12:30 PM">11:00 AM - 12:30 PM</option>
                            <option value="11:30 AM - 1:00 PM">11:30 AM - 1:00 PM</option>
                            <option value="12:00 PM - 1:30 PM">12:00 PM - 1:30 PM</option>
                          </select>
                    </div>
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
                    <p class="text fz14">360-Advance</p>
                    <span class="price">AED 100</span>
                  </div>

                  <div class="d-flex align-items-center justify-content-between price_div">
                    <p class="text fz14">Total</p>
                    <span class="price">AED 100</span>
                  </div>
                  
                  <div class="d-grid mt25">
                    <a href="" class="ud-btn btn-thm">Proceed</a>
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
      sidebar.style.top = '121px';
    }
  }

  window.addEventListener('scroll', updateSidebarPosition);
  window.addEventListener('resize', updateSidebarPosition);
  document.addEventListener('DOMContentLoaded', updateSidebarPosition);

  function car_change(value) {
    if (value === 'search') {
      document.querySelector('.other_car_div').style.display = 'block';
    } else {
      document.querySelector('.other_car_div').style.display = 'none';
    }
  }
</script>



