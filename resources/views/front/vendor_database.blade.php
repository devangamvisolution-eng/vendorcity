@include('front.includes.header')
<style type="text/css">
    .vendor_banner_sec h2 {
        font-size: 50px;
        width: 80%;
    }

    .vendor_banner_sec img {
        width: 60%;
    }

    .vendor_banner_sec .about-img {
        text-align: center;
    }
</style>

<style>
    .banner_sec {
        margin-left: 9%;
    }
	.we_cut_out_paragraph {
    line-height: 35px;
    border-left: 2px solid gray;
    padding-left: 25px;
}

    .cta-service-v3 {
        background-image: inherit;
        background-color: #eee;
    }
    .ticker-container {
      overflow: hidden;
      white-space: nowrap;
      width: 100%;
    }
    .ticker-items {
      display: inline-block;
      white-space: nowrap;
    }
    .ticker-item {
      display: inline-block;
      padding: 0 10px;
    }

    .review-color {
        color: #f2c300;
        margin-right: 2px;
    }

    @media only screen and (max-width: 600px) {
        .reviewListBox {
            height: auto;
            margin: 0 0 10px 0;
        }
        .breadcumb-section {
          padding: 20px 15px;
      }
    }
</style>

<section class="breadcumb-section pt-4 container mt120">
<div>
    <div class="container cta-service-v3 cta-banner mx-auto maxw1700 pt120 pb120 position-relative overflow-hidden d-flex align-items-center px30-lg" style="background-image: linear-gradient(to right, #0040E6, #FFD312); height: 220px; border-radius: 20px;">
        
        <!--<img class="service-v3-vector d-none d-lg-block" src="{{ asset('public/site/images/test_new.jpg') }}"
            alt="Customer service experience with Vendorscity UAE">-->
        
            <div class="row wow fadeInUp container">
                <div class="col-xl-12">
                    <div class="position-relative">
                        <h1 class=" banner_title" style="color: #fff;" >Our Vendors</h1>
                        <!-- <p class="text mb30 text-white">Give your visitor a smooth online experience with a solid UX design</p> -->
                        <!--<div class="d-flex align-items-center">
							<h6 class="mb-0" style="color: #fff;" >Use Code MoveitMoveit</h6>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--<section class="breadcumb-section pt-4">
    <div class="container">
        <div
            class="cta-service-v3 cta-banner mx-auto maxw1700 pt120 pb120 bdrs16 position-relative overflow-hidden d-flex align-items-center mx20-lg px30-lg">

            <img class="service-v3-vector d-none d-lg-block" src="{{ asset('public/site/images/Vendor Database-min-min.png') }}"
                alt="">

            <div class="row wow fadeInUp">
                <div class="col-xl-10 banner_sec">
                    <div class="position-relative">
                        <h2 class=" banner_title">Get the best deals from the best vendors</h2>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>-->
<!--
<section class="our-about bgc-thm2 container pb0 pt0 mb30 mt50 vendor_banner_sec">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-xl-5 offset-xl-1">
                <div class="position-relative wow fadeInLeft" data-wow-delay="300ms">
                    <h2 class=" mb35">Get the best deals
                        from the best
                        vendors</h2>

                </div>
            </div>
            <div class="col-xl-6">
                <div class="position-relative mb30-lg">

                    <div class="about-img wow fadeInRight" data-wow-delay="300ms">
                        <img class="" src="{{ asset('public/site/images/regasvendor_new1-removebg-preview.png') }}" alt="">
                    </div>

                </div>
            </div>
        </div>
    </div>
</section> -->
<!-- Listings All Lists -->
<section class="pt30 pb20">
    <div class="container">
        <div class="row">


            <div class="col-lg-3">
                <form id="search_mini_form" name="search_mini_form" method="get">

                    <div class="list-sidebar-style1 d-none d-lg-block">
                        <div class="accordion" id="accordionExample">
                            <div class="card mb20 pb5">
                                <div class="card-header active" id="heading2">
                                    <h4>
                                        <button class="btn btn-link ps-0" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse2" aria-expanded="true"
                                            aria-controls="collapse2">Services Offered</button>
                                    </h4>
                                </div>

                                @php
                                    if ($services_ids != '') {
                                        $package_cat_array = explode(',', $services_ids);
                                    } else {
                                        $package_cat_array = [];
                                    }
                                @endphp

                                <div id="collapse2" class="collapse show" aria-labelledby="heading2"
                                    data-parent="#accordionExample">
                                    <div class="card-body card-body px-0 pt-0">
                                        @foreach ($services as $services_data)
                                            <div class="checkbox-style1">
                                                <div class="checkbox-style1 mb15">
                                                    <label class="custom_checkbox">{{ $services_data->servicename }}
                                                        <input type="checkbox" onclick="allfilter1()"
                                                            value="{{ $services_data->id }}" name="service_id[]"
                                                            @php if(in_array($services_data->id,$package_cat_array)){ echo "checked"; } @endphp>
                                                        <span class="checkmark"></span>

                                                    </label>
                                                </div>

                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            @if (isset($cities) && count($cities) > 0)

                                @php
                                    if ($city_ids != '') {
                                        $city_array = explode(',', $city_ids);
                                    } else {
                                        $city_array = [];
                                    }
                                @endphp

                                <div class="card mb20 pb5">
                                    <div class="card-header active" id="heading2">
                                        <h4>
                                            <button class="btn btn-link ps-0" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse2" aria-expanded="true"
                                                aria-controls="collapse2">Cities</button>
                                        </h4>
                                    </div>
                                    <div id="collapse2" class="collapse show" aria-labelledby="heading2"
                                        data-parent="#accordionExample">
                                        <div class="card-body card-body px-0 pt-0">

                                            @foreach ($cities as $cities_data)
                                                <div class="checkbox-style1">
                                                    <div class="checkbox-style1 mb15">
                                                        <label class="custom_checkbox">{{ $cities_data->name }}
                                                            <input type="checkbox" onclick="allfilter1()"
                                                                value="{{ $cities_data->id }}" name="city_id[]"
                                                                @php if(in_array($cities_data->id,$city_array)){ echo "checked"; } @endphp>
                                                            <span class="checkmark"></span>

                                                        </label>
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!-- <div class="card mb20 pb5">
                  <div class="card-header active" id="heading3">
                    <h4>
                      <button class="btn btn-link ps-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="true" aria-controls="collapse3">Location</button>
                    </h4>
                  </div>
                  <div id="collapse3" class="collapse show" aria-labelledby="heading3" data-parent="#accordionExample">
                    <div class="card-body card-body px-0 pt-0">
                      <div class="search_area mb15">
                        <input type="text" class="form-control" placeholder="What are you looking for?">
                        <label><span class="flaticon-loupe"></span></label>
                      </div>
                      <div class="checkbox-style1 mb15">
                        <label class="custom_checkbox">United States
                          <input type="checkbox">
                          <span class="checkmark"></span>
                          <span class="right-tags">(1,945)</span>
                        </label>
                        <label class="custom_checkbox">United Kingdom
                          <input type="checkbox" checked="checked">
                          <span class="checkmark"></span>
                          <span class="right-tags">(8,136)</span>
                        </label>
                        <label class="custom_checkbox">Canada
                          <input type="checkbox">
                          <span class="checkmark"></span>
                          <span class="right-tags">(917)</span>
                        </label>
                        <label class="custom_checkbox">Germany
                          <input type="checkbox">
                          <span class="checkmark"></span>
                          <span class="right-tags">(240)</span>
                        </label>
                        <label class="custom_checkbox">Turkey
                          <input type="checkbox">
                          <span class="checkmark"></span>
                          <span class="right-tags">((2,460)</span>
                        </label>
                      </div>
                      <a class="text-thm" href="">+20 more</a>
                    </div>
                  </div>
                </div>
                <div class="card mb20 pb5">
                  <div class="card-header active" id="heading4">
                    <h4>
                      <button class="btn btn-link ps-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="true" aria-controls="collapse4">Speaks</button>
                    </h4>
                  </div>
                  <div id="collapse4" class="collapse show" aria-labelledby="heading4" data-parent="#accordionExample">
                    <div class="card-body card-body px-0 pt-0">
                      <div class="checkbox-style1 mb15">
                        <label class="custom_checkbox">Turkish
                          <input type="checkbox">
                          <span class="checkmark"></span>
                          <span class="right-tags">(1,945)</span>
                        </label>
                        <label class="custom_checkbox">English
                          <input type="checkbox" checked="checked">
                          <span class="checkmark"></span>
                          <span class="right-tags">(8,136)</span>
                        </label>
                        <label class="custom_checkbox">Italian
                          <input type="checkbox">
                          <span class="checkmark"></span>
                          <span class="right-tags">(917)</span>
                        </label>
                        <label class="custom_checkbox">Spanish
                          <input type="checkbox">
                          <span class="checkmark"></span>
                          <span class="right-tags">(240)</span>
                        </label>
                      </div>
                      <a class="text-thm" href="">+20 more</a>
                    </div>
                  </div>
                </div> -->
                            <!--  <div class="card mb20 pb0">
                  <div class="card-header active" id="heading5">
                    <h4>
                      <button class="btn btn-link ps-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="true" aria-controls="collapse5">Level</button>
                    </h4>
                  </div>
                  <div id="collapse5" class="collapse show" aria-labelledby="heading5" data-parent="#accordionExample">
                    <div class="card-body card-body px-0 pt-0">
                      <div class="checkbox-style1">
                        <label class="custom_checkbox">Top Rated Seller
                          <input type="checkbox">
                          <span class="checkmark"></span>
                          <span class="right-tags">(1,945)</span>
                        </label>
                        <label class="custom_checkbox">Level Two
                          <input type="checkbox" checked="checked">
                          <span class="checkmark"></span>
                          <span class="right-tags">(8,136)</span>
                        </label>
                        <label class="custom_checkbox">Level One
                          <input type="checkbox">
                          <span class="checkmark"></span>
                          <span class="right-tags">(917)</span>
                        </label>
                        <label class="custom_checkbox">New Seller
                          <input type="checkbox">
                          <span class="checkmark"></span>
                          <span class="right-tags">(240)</span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div> -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-9">
                <div class="row align-items-center mb20">
                    <div class="col-md-6">
                        <div class="text-center text-md-start">

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div
                            class="page_control_shorting d-md-flex align-items-center justify-content-center justify-content-md-end">
                            <div class="dropdown-lists d-block d-lg-none me-2 mb10-sm">
                                <ul class="p-0 mb-0 text-center text-md-start">
                                    <li>
                                        <!-- Advance Features modal trigger -->
                                        <button type="button" class="open-btn filter-btn-left"> <img class="me-2"
                                                src="{{ asset('public/site/images/icon/all-filter-icon.svg') }}"
                                                alt="Service filter icon – Vendorscity search filter"> All Filter</button>
                                    </li>
                                </ul>
                            </div>
                            {{--<div class="pcs_dropdown dark-color pr10 text-center text-md-end"><span>Sort by</span>
                                <select class="selectpicker show-tick">
                                    <option>Best Selling</option>
                                    <option>Recommended</option>
                                    <option>New Arrivals</option>
                                </select>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="row">

                    @php
                        //echo"<pre>";print_r($allvendor);echo"</pre>";
                    @endphp

                    @if ($allvendor != '' && count($allvendor) > 0)

                        @php
                            //echo"<pre>";print_r($allvendor);echo"</pre>";
                        @endphp

                        @foreach ($allvendor as $allvendor_data)

                         @php

                               $currentDate = now();

                               $id = $allvendor_data->user_id;

                               $result = DB::table('subscription')
                                   ->select('*')
                                   ->where('vendor_id', '=', $id)
                                   ->where('enddate', '>=', $currentDate)
                                   ->orderBy('id', 'desc')
                                   ->get();
                               $result_new = $result->toArray();
                              //echo "<pre>";print_r($result_new);echo "</pre>";

                              $allServices = [];

                              foreach ($result_new as $result_new_data) {
                                
                                   $services_test = explode(',', $result_new_data->services);
                                    $allServices = array_merge($allServices, $services_test);
                                }

                            $allServices = array_unique($allServices);
                            $allServices = array_values($allServices);

                           


                            //echo "<pre>";print_r($allvendor_data);echo "</pre>";

                              
                           @endphp
                            <div class="col-md-6 col-lg-12">
                                <div class="freelancer-style1 bdr1 hover-box-shadow row ms-0 align-items-lg-center">
                                    <div class="col-lg-8 ps-0">
                                        <div class="d-lg-flex  bdrn-xl pr15 pr0-lg">
                                            <div class="thumb w60 position-relative rounded-circle mb15-md">
                                                @if ($allvendor_data->company_logo != '')
                                                    <img class="rounded-circle mx-auto"
                                                        src="{{ asset('public/upload/vendors/' . $allvendor_data->company_logo) }}"
                                                        alt="" width="60px">
                                                @else
                                                    <img class="rounded-circle mx-auto"
                                                        src="{{ asset('public/upload/avatar.jpg') }}"
                                                        alt="Profile Image" width="60px">
                                                @endif
                                                <span class="online-badge2"></span>
                                            </div>
                                            <div class="details ml15 ml0-md mb15-md">
                                                <h5 class="title mb-3">{{ $allvendor_data->name }}</h5>

                                                <div class="review">
                                                    <p>
                                                        @if($allvendor_data->rating != '')
                                                        <i class="fas fa-star fz10 review-color pr10"></i>
                                                        <span class="dark-color fw500">{{$allvendor_data->rating}}</span> 
                                                        @endif
                                                        @if($allvendor_data->number_of_review != '')

                                                            @if($allvendor_data->review_link != '')
                                                            <a href="{{$allvendor_data->review_link}}">({{$allvendor_data->number_of_review}} reviews)</a>
                                                            @else

                                                            ({{$allvendor_data->number_of_review}} reviews)
                                                            @endif
                                                        @endif
                                                            
                                                    </p>
                                                </div>

                                                @if ($allvendor_data->user_city != '')
                                                    <p class="mb-0 fz14 list-inline-item mb5-sm pe-1"><i
                                                            class="flaticon-place fz16 vam text-thm2 me-1"></i>
                                                        {!! Helper::cityname($allvendor_data->user_city) !!}</p>
                                                @endif

                                                {{-- @if ($allvendor_data->short_description != '')
                                                    <p class="text mt10">{{ $allvendor_data->short_description }}</p>
                                                @endif --}}



                                                 @if(!empty($allServices))
                                                <div
                                                    class="skill-tags d-flex align-items-center justify-content-start">
                                                    @foreach($allServices as $allServices_data)
                                                    <span class="tag mx10">{!! Helper::servicename($allServices_data) !!}</span>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 ps-0 ps-xl-3 pe-0" style="display:none;">

                                        <div class="d-grid mt15">
                                            <a href="#" class="ud-btn btn-thm2">Get free quote</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        No Vendor Available

                    @endif



                </div>
                {{-- {!! $allvendor->appends($_GET)->render('pagination::bootstrap-4') !!} --}}
            </div>

            <!--  <div class="row">
              <div class="mbp_pagination mt30 text-center">
                <ul class="page_navigation">
                  <li class="page-item">
                    <a class="page-link" href="#"> <span class="fas fa-angle-left"></span></a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item active" aria-current="page">
                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">4</a></li>
                  <li class="page-item d-inline-block d-sm-none"><a class="page-link" href="#">...</a></li>
                  <li class="page-item"><a class="page-link" href="#">5</a></li>
                  <li class="page-item d-none d-sm-inline-block"><a class="page-link" href="#">...</a></li>
                  <li class="page-item d-none d-sm-inline-block"><a class="page-link" href="#">20</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#"><span class="fas fa-angle-right"></span></a>
                  </li>
                </ul>
                <p class="mt10 mb-0 pagination_page_count text-center">1 – 20 of 300+ property available</p>
              </div>
            </div> -->
        </div>
    </div>
    </div>
</section>

<section class="pb90 pb30-md pt30">
    <div class="container">
	<div class="container">
        <div class="row wow fadeInUp" data-wow-delay="00ms" style="visibility: visible; animation-delay: 0ms; animation-name: fadeInUp;">
            <div class="col-lg-6">
                <div class="main-title2">
                    <h2 class="title we_do_heading">Most Popular Services</h2>

                </div>
            </div>
            <div class="col-lg-6">

                <p class="paragraph we_cut_out_paragraph">Get your weekend back, we've got your to-do list covered. Hire our top rated verified vendors for the best in class stress free service and top class prices
                </p>

            </div>
        </div>

    </div>
        
        <div class="tab-content ha" id="pills-tabContent">
            <div class="tab-pane fade fz15 text show active" id="pills-home" role="tabpanel"
                aria-labelledby="pills-home-tab">
                <div class="navi_pagi_bottom_center slider-4-grid owl-carousel owl-theme">
                    @foreach ($services->where('is_active', 0) as $services_data)
                        <div class="item">
                            <div class="listing-style1">
                                <div class="list-thumb">
                                    <a href="{{ url('service/' . $services_data->page_url) }}">
                                        @if (isset($services_data->image) && $services_data->image != '')
                                            <img class="w-100"
                                                src="{{ asset('public/upload/service/large/' . $services_data->image) }}"
                                                alt="">
                                        @else
                                            <img class="w-100"
                                                src="{{ asset('public/upload/service/large/1715859524No_Image_Available.jpg') }}"
                                                alt="">
                                        @endif
                                    </a>
                                    {{-- <a href="" class="listing-fav fz12"><span class="far fa-heart"></span></a> --}}
                                </div>
                                <div class="list-content"
                                    style="padding: 35px 15px 20px 15px; background:#eee; !important">

                                    {{--<div class="review-meta d-flex align-items-center">
                                        <i class="fas fa-star fz10 review-color"></i>
                                        <i class="fas fa-star fz10 review-color"></i>
                                        <i class="fas fa-star fz10 review-color"></i>
                                        <i class="fas fa-star fz10 review-color"></i>

                                    </div>--}}

                                    <div class="list-meta d-flex justify-content-between align-items-center mt15">
                                        <a class="d-flex" href="{{ url('service/' . $services_data->page_url) }}">
                                            <span class="fz14"
                                                style="font-size: 20px;!important">{{ $services_data->servicename }}</span>
                                        </a>
                                        <div class="budget">
                                            <i class="far fa-arrow-right-long"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>

    </div>
</section>

<section class=" mt-30 pb-0">
    <div class="container">
        <div class="row wow fadeInUp" data-wow-delay="00ms">
            <div class="col-lg-6">
                <div class="main-title2">
                    <h2 class="title we_do_heading">Hear what Our Clients Have to say About Us</h2>

                </div>
            </div>
            <div class="col-lg-6">

                <p class="paragraph we_cut_out_paragraph">Step into a world of satisfaction and trust as you explore stories and positive experiences ahared by our delighted customers.Discover firsthand the joy and reliability that defines our services!
                </p>

            </div>
        </div>

    </div>
</section>

<section class="bgc-thm3 pt50 pb40" style="display: none;">
    <div class="container">
        <div class="row align-items-md-center">
            <div class="col-md-6 col-lg-8 mb30-md wow fadeInUp" data-wow-delay="100ms">
                <div class="main-title">
                    <h2 class="title">Customers Love Us</h2>
                    <p class="paragraph">100% Satisfaction guaranteed. Our customers are our
                        priority which is why we are the best rated brand on
                        Google.</p>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-lg-4">
                        <div class="funfact_one">
                            <div class="details">
                                
                                <ul class="ps-0 d-flex mb-0">
                                    <li>
                                        <div class="timer">4.7</div>
                                    </li>

                                    <li><span>/</span></li>
                                    <li>
                                        <div class="timer">5</div>
                                    </li>
                                </ul>
                                <p class="text mb-0">Ratings on Google </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="funfact_one">
                            <div class="details">
                                <ul class="ps-0 d-flex mb-0">
                                    <li>
                                        <div class="timer">300</div>
                                    </li>
                                    <li><span>+</span></li>
                                </ul>
                                <p class="text mb-0">Positive reviews</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-4">

                @if(!empty($googleReview))
                <div class="testimonial-slider2 mb15 navi_pagi_bottom_center slider-1-grid owl-carousel owl-theme wow fadeInUp"
                    data-wow-delay="300ms">

                    @foreach($googleReview as $googleReview_data)
                    <div class="item">
                        <div class="testimonial-style1 default-box-shadow1 position-relative bdrs16 mb35">
                            <div class="testimonial-content">
                                @if($googleReview_data->label != '')

                                <div class="d-flex">
                                       @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $googleReview_data->label)
                                                <i class="fas fa-star review-color"></i>
                                            @else
                                                <i class="far fa-star review-color ms-2"></i>
                                            @endif
                                        @endfor
                                      </div>
                                    
                                @endif 
                                <span class="icon fas fa-quote-left"></span>
                                @if($googleReview_data->description != '')
                                <h4 class="t_content">“{{$googleReview_data->description}}”</h4>
                                     @endif 
                            </div>
                            <div class="thumb d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('public/site/images/profileimage.png') }}"
                                    alt="" style="width: 75px !important;">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    @if($googleReview_data->name != '')
                                    <h6 class="mb-0">{{$googleReview_data->name}}</h6>
                                    @endif 
                                    <!-- <p class="fz14 mb-0">Web Designer</p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- <div class="item">
                        <div class="testimonial-style1 default-box-shadow1 position-relative bdrs16 mb35">
                            <div class="testimonial-content">
                                <h4 class="title text-thm text_blue">Good Service</h4>
                                <span class="icon fas fa-quote-left"></span>
                                <h4 class="t_content">“Very friendly staff, i got few big boxes, and 10 small boxea and some moving-needed stuff.
                                    I tell you it is reliable to conyltain your home stuff while moving homes.
                                    Highly recommended. And one more thing... It is half the price of the box from Amazon”</h4>
                            </div>
                            <div class="thumb d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('public/site/images/profileimage.png') }}"
                                    alt="" style="width: 75px !important;">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Ali Boshra</h6>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="item">
                        <div class="testimonial-style1 default-box-shadow1 position-relative bdrs16 mb35">
                            <div class="testimonial-content">
                                <h4 class="title text-thm text_blue">Great Service</h4>
                                <span class="icon fas fa-quote-left"></span>
                                <h4 class="t_content">“Really good service! Very importantly they came on time, they did their job quickly and cleaned up after. Highly recommend this company.”</h4>
                            </div>
                            <div class="thumb d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('public/site/images/profileimage.png') }}"
                                        alt="" style="width: 75px !important;">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Anna B</h6>
                                   
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="testimonial-style1 default-box-shadow1 position-relative bdrs16 mb35">
                            <div class="testimonial-content">
                                <h4 class="title text-thm text_blue">Professional Service</h4>
                                <span class="icon fas fa-quote-left"></span>
                                <h4 class="t_content">“Professional and friendly team moved all our goods and helped us with a few other odds and ends around the house - highly recommended”</h4>
                            </div>
                            <div class="thumb d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('public/site/images/profileimage.png') }}"
                                        alt="" style="width: 75px !important;">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Tim Jaja</h6>
                                   
                                </div>
                            </div>
                        </div>
                    </div> -->

                    

                </div>

                 @endif
            </div>
        </div>
    </div>
</section>

<div class="container wow fadeInUp" data-wow-delay="300ms">
    <div class="reviewList">
        <div class="row align-items-md-center">
            <div class="col-lg-12">
                <h2>Read Our Verified Reviews</h2>
            </div>
        </div>
        <div class="row" style="margin:0; ">
            @if(!empty($googleReview))
                @foreach($googleReview as $googleReview_data)
                <div class="col-lg-3">
                    <div class="reviewListBox">

                        @if($googleReview_data->name != '')
                        <h5 class="mb-0">{{$googleReview_data->name}}</h5>
                        @endif 

                        @if($googleReview_data->label != '')
                        <div class="d-flex">
                               @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $googleReview_data->label)
                                        <i class="fas fa-star review-color"></i>
                                    @else
                                        <i class="far fa-star review-color ms-2"></i>
                                    @endif
                                @endfor
                              </div>
                            
                        @endif 
                        @if($googleReview_data->description != '')
                            <p>“{{$googleReview_data->description}}”</p>
                        @endif 
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<div class="container">
    <div class="googlereview">
        <div class="row align-items-md-center">
            <div class="col-lg-5 wow fadeInUp" data-wow-delay="300ms">
                <h3>Curiouos about what sets apart?</h3>
                <p>Explore our Google Reviews and discover why customers trust us with home service needs</p>
            </div>
            <div class="col-lg-3 wow fadeInUp" data-wow-delay="300ms">
                <a style="width: 100%;" href="https://www.google.com/search?q=vendorscity+dubai&sca_esv=e472bba1732e8ddb&sca_upv=1&rlz=1C5CHFA_enAE1014AE1015&sxsrf=ADLYWIKMm77ohxWtSjtB2FywHuiQPICeBA%3A1716628559794&ei=T6xRZquOMNCVxc8Ph-eCsAo&ved=0ahUKEwjr8ZHcu6iGAxXQSvEDHYezAKYQ4dUDCBA&uact=5&oq=vendorscity+dubai&gs_lp=Egxnd3Mtd2l6LXNlcnAiEXZlbmRvcnNjaXR5IGR1YmFpMgQQIxgnMggQABgIGA0YHjIIEAAYCBgNGB4yCBAAGAgYDRgeMgsQABiABBiGAxiKBTILEAAYgAQYhgMYigUyCxAAGIAEGIYDGIoFMgsQABiABBiGAxiKBTIIEAAYgAQYogQyCBAAGIAEGKIESMAKUMoEWN8GcAF4AZABAJgB_wGgAcYDqgEFMC4xLjG4AQPIAQD4AQGYAgOgAtMDwgIKEAAYsAMY1gQYR8ICBxAAGIAEGA3CAggQABgFGA0YHsICChAAGAUYDRgeGA-YAwDiAwUSATEgQIgGAZAGCJIHBTEuMC4yoAeUEA&sclient=gws-wiz-serp#lrd=0x4c30ffdf4bf81567:0xaf176b54bfc73c00,1" target="_blank" class="ud-btn btn-thm">Read More Reviews</a>
            </div>
            <div class="col-lg-4 wow fadeInUp" data-wow-delay="300ms" style="text-align: right;">
                <img class="w100" src="{{ asset('public/site/images/googlereview.png') }}" alt="" style="max-width: 400px;">
            </div>
        </div>
    </div>
</div>

<section class="our-faq pb90" style="display:none;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 m-auto wow fadeInUp" data-wow-delay="300ms">
                <div class="main-title mb30">
                    <h2 class="title">Have Questions?<br>Get Answers.</h2>
                    <h4 class="title">Payments</h4>
                </div>
            </div>
        </div>
        <div class="row wow fadeInUp" data-wow-delay="300ms">
            <div class="col-lg-12 mx-auto">
                <div class="ui-content">
                    <div class="accordion-style1 faq-page mb-4 mb-lg-5">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item active">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">What methods of payments are supported?</button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="accordion-body">Cras vitae ac nunc orci. Purus amet tortor non at
                                        phasellus ultricies hendrerit. Eget a, sit morbi nunc sit id massa. Metus,
                                        scelerisque volutpat nec sit vel donec. Sagittis, id volutpat erat vel.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">Can I cancel at anytime?</button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse"
                                    aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="accordion-body">Cras vitae ac nunc orci. Purus amet tortor non at
                                        phasellus ultricies hendrerit. Eget a, sit morbi nunc sit id massa. Metus,
                                        scelerisque volutpat nec sit vel donec. Sagittis, id volutpat erat vel.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                        aria-expanded="false" aria-controls="collapseThree">How do I get a receipt for
                                        my purchase?</button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <div class="accordion-body">Cras vitae ac nunc orci. Purus amet tortor non at
                                        phasellus ultricies hendrerit. Eget a, sit morbi nunc sit id massa. Metus,
                                        scelerisque volutpat nec sit vel donec. Sagittis, id volutpat erat vel.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">Which license do I
                                        need?</button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse"
                                    aria-labelledby="headingFour" data-parent="#accordionExample">
                                    <div class="accordion-body">Cras vitae ac nunc orci. Purus amet tortor non at
                                        phasellus ultricies hendrerit. Eget a, sit morbi nunc sit id massa. Metus,
                                        scelerisque volutpat nec sit vel donec. Sagittis, id volutpat erat vel.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                        aria-expanded="false" aria-controls="collapseFive">How do I get access to a
                                        theme I purchased?</button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse"
                                    aria-labelledby="headingFive" data-parent="#accordionExample">
                                    <div class="accordion-body">Cras vitae ac nunc orci. Purus amet tortor non at
                                        phasellus ultricies hendrerit. Eget a, sit morbi nunc sit id massa. Metus,
                                        scelerisque volutpat nec sit vel donec. Sagittis, id volutpat erat vel.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="our-about bgc-thm2 container pb0 pt0 mb30 mt30">
    <div class="container">
        <div class="row align-items-center custom_marquee">


            {{-- <marquee width="100%" direction="left">| 15,000+ Customers | <span class="flaticon-star custom_icon">
                </span>Rated 4.8 out of 5 | <span class="flaticon-call custom_icon"> </span>Live Customer Support |
                15,000+ Customers | <span class="flaticon-star custom_icon"> </span>Rated 4.8 out of 5 | <span
                    class="flaticon-call custom_icon"> </span>Live Customer Support | 15,000+ Customers | <span
                    class="flaticon-star custom_icon"> </span>Rated 4.8 out of 5 | <span
                    class="flaticon-call custom_icon"> </span>Live Customer Support | 15,000+ Customers | <span
                    class="flaticon-star custom_icon"> </span>Rated 4.8 out of 5 | <span
                    class="flaticon-call custom_icon"> </span>Live Customer Support | 15,000+ Customers | <span
                    class="flaticon-star custom_icon"> </span>Rated 4.8 out of 5 | <span
                    class="flaticon-call custom_icon"> </span>Live Customer Support | 15,000+ Customers | <span
                    class="flaticon-star custom_icon"> </span>Rated 4.8 out of 5 | <span
                    class="flaticon-call custom_icon"> </span>Live Customer Support |
            </marquee> --}}

            <div class="ticker-container">
                <div class="ticker-items">
                  <div class="ticker-item"><span class="fa-regular fa-user custom_icon"></span> 15,000+ Customers </div>
                  <div class="ticker-item"><span class="fa-regular fa-star custom_icon"></span> Rated 4.8 out of 5</div>
                  <div class="ticker-item"><span class="fa-regular fa-phone custom_icon"></span> Live Customer Support</div>
                  <!-- Add more items as needed -->
                </div>
            </div>

        </div>
    </div>
</section>
@include('front.includes.footer')

<script>
    function allfilter1() {
        //alert('test');
        document.search_mini_form.submit();
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.0/gsap.min.js"></script>
  <script>
    const tickerContainer = document.querySelector('.ticker-container');
    const tickerItems = document.querySelector('.ticker-items');
    const items = document.querySelectorAll('.ticker-item');

    // Calculate the width of all items combined
    let itemsWidth = 0;
    items.forEach(item => {
      itemsWidth += item.offsetWidth;
    });

    // Clone items to fill the container at least twice
    while (tickerItems.offsetWidth < tickerContainer.offsetWidth * 2) {
      items.forEach(item => {
        const clone = item.cloneNode(true);
        tickerItems.appendChild(clone);
      });
    }

    // Set up GSAP animation
    gsap.to(tickerItems, {
      duration: 5, // Adjust duration as needed
      x: -itemsWidth,
      ease: 'none',
      repeat: -1
    });

    
  </script>
