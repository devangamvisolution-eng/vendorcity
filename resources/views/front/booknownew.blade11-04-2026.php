@include('front.includes.header')


<link rel="stylesheet" href="{{ asset('public/site/css/booknownew.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .currency_dhiram {
        display: inline-block;
        width: 18px;
        height: 18px;

        background-color: currentColor;

        -webkit-mask: url('{{ asset('public/site/icons/dirham.svg') }}') no-repeat center;
        mask: url('{{ asset('public/site/icons/dirham.svg') }}') no-repeat center;

        -webkit-mask-size: contain;
        mask-size: contain;
    }
</style>

<section class="our-register">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 sol-sm-12">
                <div class="step-header-main">
                    <div class="step-header" id="stepHeader">Step 1 of 4 — {{ $subservice_data->subservicename }}</div>
                </div>
            </div>
        </div>


        <div class="row main-area-cont">
            <div class="col-lg-8 col-md-12 sol-sm-12">
                <form id="bookingForm" method="POST" action="{{ route('book_now_package') }}">
                    @csrf
                    <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
                    <input type="hidden" name="subservice_id" id="subservice_id" value="{{ $subservice_id }}">
                    <div class="main-content ">

                        <div class="step-content active" id="step1">



                            <div class="sticky-header" id="stickyHeader">
                                <div class="sticky-header-inner">
                                    <h3><strong>{{ $subservice_data->subservicename }}</strong></h3>
                                    <button class="carousel-arrow left-arrow" type="button">&#8249;</button>
                                    <button class="carousel-arrow right-arrow" type="button">&#8250;</button>
                                    <div class="category-tabs-packages" id="categoryTabsPackages">
                                        @foreach ($package_cat as $package_cat_data)
                                            <button type="button"
                                                class="@if ($loop->first) active @endif"
                                                data-target="sofa{{ $package_cat_data->id }}">{{ $package_cat_data->name }}</button>
                                        @endforeach
                                        {{-- <button data-target="mattress" >Mattress</button>
                        <button data-target="carpet" >Carpet</button>
                        <button data-target="curtain" >Curtain</button>
                        <button data-target="combo" >Combos</button>
                        <button data-target="combo1" >Combos1</button>
                        <button data-target="combo2" >Combos2</button>
                        <button data-target="combo3" >Combos3</button>
                        <button data-target="combo4" >Combos4</button>
                        <button data-target="combo5" >Combos5</button> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="section-packages">
                                <div class="image">
                                    @if ($subservice_data->service_detail_image != '')
                                        <img src="{{ url('public/upload/subservice/' . $subservice_data->service_detail_image) }}"
                                            class="img-fluid subservice-image"
                                            alt="{{ $subservice_data->image_alt_tag ?? $subservice_data->subservicename }}">
                                    @else
                                        <img src="{{ asset('public/site/images/no-image.jpg') }}"
                                            class="img-fluid subservice-image"
                                            alt="{{ $subservice_data->image_alt_tag ?? $subservice_data->subservicename }}">
                                    @endif
                                </div>
                                <div class="subservice-desc">
                                    <h5 class="font-weight-bold h3 subservice-name">About our {{ $subservice_name }}
                                        Service </h5>
                                    @if (!empty($subservice_data->service_detail_short_description))
                                        <p style="margin-bottom: 0;">
                                            {{ $subservice_data->service_detail_short_description }}</p>
                                    @endif
                                    <a href="javascript:void(0)" class="custom-arrow" data-bs-toggle="modal"
                                        id="read_more"
                                        data-bs-target="#subservice-read-more-model_{{ $subservice_data->id }}">Read
                                        more </a>
                                </div>
                            </div>

                            @foreach ($package_cat as $package_cat_data)
                                <div id="sofa{{ $package_cat_data->id }}" class="section-packages">

                                    @php
                                        $package = DB::table('packages')
                                            ->where('service_id', $service_id)
                                            ->where('subservice_id', $subservice_id)
                                            ->where('packagecategory_id', $package_cat_data->id)
                                            ->orderBy('set_order')
                                            ->get()
                                            ->toArray();

                                        //$package =array();

                                        //echo"<pre>";print_r($package);echo"</pre>";

                                    @endphp
                                    <h4>{{ $package_cat_data->name }}</h4>

                                    @if (!empty($package))
                                        @foreach ($package as $package_data)
                                            <div class="row fullrow">

                                                @if (!empty($package_data->image))
                                                    <div class="col-md-4 col-sm-2 col-lg-2 col-3 ">

                                                        <img src="{{ asset('public/upload/packages/large/' . $package_data->image) }}"
                                                            alt="Sofa" width="97" class="cleanig_image">

                                                    </div>
                                                @endif

                                                @php
                                                    if (!empty($package_data->image)) {
                                                        $classN = 'col-md-8 col-sm-10 col-lg-10 col-9';
                                                    } else {
                                                        $classN = 'col-md-12 col-sm-12 col-lg-12 col-12';
                                                    }
                                                @endphp

                                                <div class="{{ $classN }}">
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-lg-12">
                                                            <div class="info">
                                                                <a href="javascript:void(0)" class="custom-arrow"
                                                                    data-bs-toggle="modal" id="package_detail"
                                                                    data-bs-target="#package-detail-model_{{ $package_data->id }}"><strong>{{ $package_data->name }}</strong></a>
                                                                <p style="margin-bottom: 0">
                                                                    {{ $package_data->short_description }}</p>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    @php
                                                        $price = $package_data->price;
                                                        $discount_price = 0;

                                                        if (
                                                            !empty($package_data->discount) &&
                                                            isset($package_data->discount_type)
                                                        ) {
                                                            $discount_price =
                                                                $package_data->discount_type == 0
                                                                    ? ($package_data->discount / 100) *
                                                                        $package_data->price
                                                                    : $package_data->discount;

                                                            $price -= $discount_price;
                                                        }
                                                    @endphp
                                                    <div class="row">
                                                        <div class="col-md-5 col-sm-4 col-lg-4 col-8">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mt-1 package-price-box">
                                                                <div class="price">
                                                                    <span class="currency_dhiram"></span>
                                                                    {{ number_format($price, 2) }}
                                                                </div>
                                                                @if ($discount_price > 0)
                                                                    <div class="old-price">
                                                                        <span class="currency_dhiram"></span>

                                                                        {{ number_format($package_data->price, 2) }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7 col-sm-8 col-lg-8 col-4">
                                                            <button type="button" class="addbutton"
                                                                data-id="{{ $package_data->id }}"
                                                                data-name="{{ $package_data->name }}"
                                                                data-price="{{ $price }}"
                                                                data-service="{{ $service_id }}"
                                                                data-subservice_id="{{ $subservice_id }}"
                                                                data-type="package">Add +</button>
                                                            <div class="quantity-control"
                                                                data-id="{{ $package_data->id }}"
                                                                style="display:none;">
                                                                <button class="minus-btn" type="button">-</button>
                                                                <span class="quantity">1</span>
                                                                <button class="plus-btn" type="button">+</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <hr>
                                        @endforeach
                                    @endif

                                </div>
                            @endforeach


                            <div class="step-buttons">
                                <span></span>
                                <div class="sticky-footer-btn">
                                    <div class="row align-items-center">
                                        <div class="col-md-6 col-lg-12 col-sm-6 col-6">
                                            <div class="mobile_total">
                                                <div class="font-weight-bold">
                                                    <div class="cross_amount_div" style="display: none;">

                                                        <span class="currency_dhiram"></span>
                                                        <span class="cross_amount"
                                                            style="text-decoration: line-through;"></span>
                                                    </div>
                                                    <div class="mobile_price" style="font-size: 25px;">
                                                        <span class="currency_dhiram"></span>
                                                        <span class="total_to_pay">0.00</span>
                                                        <i style="margin-left: 5px;"
                                                            class="fa-solid fa-angle-up arrow-toggle-mobile"
                                                            id="aerrowicon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-12 col-sm-6 col-6">
                                            <button class="btn btn-primary custome-black" type="button"
                                                onclick="nextStep(2)">Next</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <!-- Step 2: Add-ons -->
                        @if (isset($addons) && count($addons) > 0)
                            <div class="step-content" id="step2">
                                <h3>Add-ons</h3>


                                <div class="row">

                                    <div id="addons-slider" class="splide">
                                        <div class="splide__track">
                                            <ul class="splide__list">

                                                @foreach ($addons as $addonsData)
                                                    <li class="splide__slide text-center">

                                                        <div class="product-card h-100">
                                                            @if ($addonsData->image)
                                                                <img src="{{ asset('public/upload/addons/' . $addonsData->image) }}"
                                                                    alt="{{ $addonsData->image_alt_tag ?? $addonsData->name }}">
                                                            @endif
                                                            <div class="product-body">
                                                                <h6 class="product-title text-left">
                                                                    {{ $addonsData->name ?? '' }}</h6>
                                                                <p class="product-desc text-left">
                                                                    {!! Helper::twoLineText($addonsData->short_desc ?? '', 42) !!}</p>
                                                                <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                    id="package_detail"
                                                                    data-bs-target="#addons-detail-model_{{ $addonsData->id }}"
                                                                    class="learn-more text-left">Learn more</a>
                                                                @php
                                                                    $priceaddons = $addonsData->price;
                                                                    $discount_priceaddons = 0;

                                                                    if (
                                                                        !empty($addonsData->discount) &&
                                                                        isset($addonsData->discount_type)
                                                                    ) {
                                                                        $discount_priceaddons =
                                                                            $addonsData->discount_type == 0
                                                                                ? ($addonsData->discount / 100) *
                                                                                    $addonsData->price
                                                                                : $addonsData->discount;

                                                                        $priceaddons -= $discount_priceaddons;
                                                                    }
                                                                @endphp

                                                                <div class="price-box text-left addons-price">

                                                                    <span class="price-addons">
                                                                        <span class="currency_dhiram"></span>

                                                                        {{ number_format($priceaddons, 2) }}
                                                                    </span>
                                                                    @if ($discount_priceaddons > 0)
                                                                        <span class="old-price-addons">
                                                                            <span class="currency_dhiram"></span>
                                                                            {{ number_format($addonsData->price, 2) }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="product-footer">
                                                                {{-- <button class="add-btn-addons">Add +</button> --}}
                                                                <button type="button"
                                                                    class="addons-addbutton add-btn-addons"
                                                                    data-id="{{ $addonsData->id }}"
                                                                    data-name="{{ $addonsData->name }}"
                                                                    data-price="{{ $priceaddons }}"
                                                                    data-service="{{ $service_id }}"
                                                                    data-subservice_id="{{ $subservice_id }}"
                                                                    data-type="addons">
                                                                    Add +
                                                                </button>

                                                                <!-- Addon Quantity Control -->
                                                                <div class="addons-quantity-control"
                                                                    data-id="{{ $addonsData->id }}"
                                                                    style="display:none;">
                                                                    <button class="addons-minus-btn"
                                                                        type="button">-</button>
                                                                    <span class="addons-quantity">1</span>
                                                                    <button class="addons-plus-btn"
                                                                        type="button">+</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                                {{-- <li class="splide__slide text-center">
                                      <div class="product-card h-100">
                                          <img src="http://localhost/vendorcitybeta/public/upload/packages/large/dining-chair.png" alt="Cushion">
                                          <div class="product-body">
                                            <h6 class="product-title text-left">Dining chair</h6>
                                            <p class="product-desc text-left">Transform your cushions from drab...</p>
                                            <a href="#" class="learn-more text-left">Learn more</a>
                                            <div class="price-box text-left">
                                              AED 3 <span class="old-price">AED 7</span>
                                            </div>
                                          </div>
                                          <div class="product-footer">
                                            <button class="add-btn">Add +</button>
                                          </div>
                                        </div>
                                   </li>
                                   <li class="splide__slide text-center" >
                                      <div class="product-card h-100">
                                          <img src="http://localhost/vendorcitybeta/public/upload/packages/large/pillows.png" alt="Cushion">
                                          <div class="product-body">
                                            <h6 class="product-title text-left">Pillows</h6>
                                            <p class="product-desc text-left">Transform your cushions from drab...</p>
                                            <a href="#" class="learn-more text-left">Learn more</a>
                                            <div class="price-box text-left" >
                                              AED 3 <span class="old-price">AED 7</span>`
                                            </div>
                                          </div>
                                          <div class="product-footer">
                                            <button class="add-btn">Add +</button>
                                          </div>
                                        </div>
                                   </li>
                                   <li class="splide__slide">
                                      <div class="product-card h-100">
                                          <img src="http://localhost/vendorcitybeta/public/upload/packages/large/cushion-s2.png" alt="Cushion">
                                          <div class="product-body">
                                            <h6 class="product-title text-left">Cushion</h6>
                                            <p class="product-desc text-left">Transform your cushions from drab...</p>
                                            <a href="#" class="learn-more text-left">Learn more</a>
                                            <div class="price-box text-left">
                                              AED 3 <span class="old-price text-left">AED 7</span>
                                            </div>
                                          </div>
                                          <div class="product-footer">
                                            <button class="add-btn">Add +</button>
                                          </div>
                                        </div>
                                   </li> --}}
                                            </ul>
                                        </div>
                                    </div>

                                </div>

                                <div class="step-buttons">
                                    <button class="btn btn-secondary custome-black" type="button"
                                        onclick="prevStep(1)">Back</button>
                                    <div class="sticky-footer-btn">
                                        <div class="row align-items-center">
                                            <div class="col-md-6 col-lg-12 col-sm-6 col-6">
                                                <div class="mobile_total">
                                                    <div class="font-weight-bold">
                                                        <div class="cross_amount_div" style="display: none;">

                                                            <span class="currency_dhiram"></span>
                                                            <span class="cross_amount"
                                                                style="text-decoration: line-through;"></span>
                                                        </div>
                                                        <div class="mobile_price" style="font-size: 25px;"><span
                                                                class="currency_dhiram"></span>
                                                            <span class="total_to_pay">0.00</span>
                                                            <i style="margin-left: 5px;"
                                                                class="fa-solid fa-angle-up arrow-toggle-mobile"
                                                                id="aerrowicon"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-12 col-sm-6 col-6">
                                                <button class="btn btn-primary custome-black" type="button"
                                                    onclick="nextStep(3)">Next</button>
                                            </div>
                                        </div>

                                    </div>
                                    {{-- <button class="btn btn-primary" onclick="nextStep(3)">Next</button> --}}
                                </div>

                            </div>
                        @endif
                        <!-- Step 3: Date & Address -->
                        <div class="step-content" id="step3">
                            <h3>Date & Address</h3>
                            <div class="booking-step">
                                <h5 class="form-label fw500 dark-color">When would you like your service?</h5>

                                <div class="date-slider-wrapper">
                                    <button class="arrow left" type="button">&lt;</button>

                                    <div class="date-slider" id="dateSlider"></div>

                                    <button class="arrow right" type="button">&gt;</button>
                                </div>

                                <div class="form-group mb-3 mt-3">
                                    <label class="form-label fw500 dark-color" for="country">What time would you like
                                        us to start?</label>
                                    <div class="radio-group time-slot-grid time_replace_ab">

                                        @php

                                            use Carbon\Carbon;
                                            date_default_timezone_set('Asia/Dubai');
                                            $currentTime = Carbon::now();
                                            $bufferTime = $currentTime->copy()->addHours(2);
                                            $i = 1;

                                        @endphp

                                        @foreach ($timeslot as $timeslot_data)
                                            @php
                                                // Parse the start time from slot name
                                                $startTimeString = explode('-', $timeslot_data->name)[0];
                                                $slotStartTime = Carbon::createFromFormat(
                                                    'g:i A',
                                                    trim($startTimeString),
                                                    'Asia/Dubai',
                                                );

                                                // Skip if slot is not after buffer time
                                                if ($slotStartTime->lt($bufferTime)) {
                                                    continue;
                                                }

                                                // Get service-specific timeslot price
                                                $timeslot_service = DB::table('subservice_timeslot_price')
                                                    ->where('subservice_id', $subservice_id)
                                                    ->where('time_slot_id', $timeslot_data->id)
                                                    ->where('is_active', 1)
                                                    ->first();

                                                $timeslot_service_price =
                                                    $timeslot_service && $timeslot_service->price > 0
                                                        ? $timeslot_service->price
                                                        : 0;
                                            @endphp

                                            @if ($timeslot_service && $timeslot_service->is_active == 1)
                                                <div class="surcharge-badge-timeslot items">
                                                    @if ($timeslot_service_price > 0)
                                                        <span>+ <span class="currency_dhiram"></span>
                                                            {{ $timeslot_service_price }}</span>
                                                    @endif
                                                    <input type="radio" id="time{{ $i }}"
                                                        name="time_slot" value="{{ $timeslot_data->id }}"
                                                        onclick="timeSlotClick('{{ $timeslot_service_price }}','{{ $timeslot_data->name }}')">
                                                    <label class="labeltime" for="time{{ $i }}"
                                                        style="border-radius: 50px;">
                                                        {{ $timeslot_data->name }}
                                                    </label>
                                                </div>
                                            @endif
                                            @php $i++; @endphp
                                        @endforeach



                                    </div>
                                    <p class="form-error-text" id="time_slot_error"
                                        style="color: red; margin-top: 10px;"></p>
                                </div>
                            </div>
                            <div class="step-buttons">
                                <button class="btn btn-secondary custome-black" type="button"
                                    onclick="prevStep(2)">Back</button>
                                <div class="sticky-footer-btn">
                                    <div class="row align-items-center">
                                        <div class="col-md-6 col-lg-12 col-sm-6 col-6">
                                            <div class="mobile_total">
                                                <div class="font-weight-bold">
                                                    <div class="cross_amount_div" style="display: none;">

                                                        <span class="currency_dhiram"></span>
                                                        <span class="cross_amount"
                                                            style="text-decoration: line-through;"></span>
                                                    </div>
                                                    <div class="mobile_price" style="font-size: 25px;"><span
                                                            class="currency_dhiram"></span>
                                                        <span class="total_to_pay">0.00</span>
                                                        <i style="margin-left: 5px;"
                                                            class="fa-solid fa-angle-up arrow-toggle-mobile"
                                                            id="aerrowicon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-12 col-sm-6 col-6">
                                            <button class="btn btn-primary custome-black" type="button"
                                                onclick="nextStep(4)">Next</button>
                                        </div>
                                    </div>

                                </div>
                                {{-- <button class="btn btn-primary" onclick="nextStep(4)">Next</button> --}}
                            </div>
                        </div>

                        <!-- Step 4: Payment -->
                        <div class="step-content" id="step4">
                            <h3>Your Location</h3>
                            <div class="form-group mb-3">
                                <label class="form-label fw500 dark-color " for="country">Where would you like your
                                    service?</label>
                                <p style="margin-top: -10px;font-size:14px;">Save your address details.</p>
                                <div class="radio-group">
                                    <input type="radio" id="address_type_home" name="address_type" value="home"
                                        checked>
                                    <label for="address_type_home" style="border-radius: 50px;">Home</label>

                                    <input type="radio" id="address_type_office" name="address_type"
                                        value="office">
                                    <label for="address_type_office" style="border-radius: 50px;">Office</label>

                                    <input type="radio" id="address_type_other" name="address_type"
                                        value="other">
                                    <label for="address_type_other" style="border-radius: 50px;">Other</label>
                                </div>
                                <p class="form-error-text" id="address_type_error"
                                    style="color: red; margin-top: 10px;">
                                </p>
                            </div>
                            <div class="form-group mb-3">
                                {{-- <label class="form-label fw500 dark-color " for="country">How often do you need cleaning?</label> --}}

                                <select class="form-control" name="city" id="city">
                                    <option value="">Select City</option>
                                    <option value="Dubai" data-id="17" selected>Dubai</option>
                                    <option value="Abu Dhabi" data-id="20">Abu Dhabi</option>
                                    <option value="Sharjah" data-id="22">Sharjah</option>
                                    <option value="Ajman" data-id="23">Ajman</option>
                                    <option value="Umm Al Quwain" data-id="24">Umm Al Quwain</option>
                                    <option value="Ras Al Khaimah" data-id="25">Ras Al Khaimah</option>
                                    <option value="Fujairah" data-id="26">Fujairah</option>
                                </select>

                                <p class="form-error-text" id="city_error" style="color: red; margin-top: 10px;">
                                </p>

                            </div>
                            <div class="form-group mb-3">
                                {{-- <label class="form-label fw500 dark-color " for="country">How often do you need cleaning?</label> --}}
                                <input type="text" name="area" id="area" class="form-control"
                                    placeholder="Enter Your Area">
                                <p class="form-error-text" id="area_error" style="color: red; margin-top: 10px;"></p>

                            </div>

                            <div class="form-group mb-3">
                                {{-- <label class="form-label fw500 dark-color " for="country">How often do you need cleaning?</label> --}}
                                <input type="text" name="building_street_no" id="building_street_no"
                                    class="form-control" placeholder="Enter your building name and/or street">
                                <p class="form-error-text" id="building_street_no_error"
                                    style="color: red; margin-top: 10px;"></p>

                            </div>

                            <div class="form-group mb-3">
                                {{-- <label class="form-label fw500 dark-color " for="country">How often do you need cleaning?</label> --}}
                                <input type="text" name="apartment_villa_no" id="apartment_villa_no"
                                    class="form-control"
                                    placeholder="Enter your apartment number & floor or villa number">
                                <p class="form-error-text" id="apartment_villa_no_error"
                                    style="color: red; margin-top: 10px;"></p>

                            </div>

                            <div class="step-buttons">
                                <button class="btn btn-secondary custome-black" type="button"
                                    onclick="prevStep(3)">Back</button>
                                <div class="sticky-footer-btn">
                                    <div class="row align-items-center">
                                        <div class="col-md-6 col-lg-12 col-sm-6 col-6">
                                            <div class="mobile_total">
                                                <div class="font-weight-bold">
                                                    <div class="cross_amount_div" style="display: none;">

                                                        <span class="currency_dhiram"></span>
                                                        <span class="cross_amount"
                                                            style="text-decoration: line-through;"></span>
                                                    </div>
                                                    <div class="mobile_price" style="font-size: 25px;"><span
                                                            class="currency_dhiram"></span>
                                                        <span class="total_to_pay">0.00</span>
                                                        <i style="margin-left: 5px;"
                                                            class="fa-solid fa-angle-up arrow-toggle-mobile"
                                                            id="aerrowicon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-12 col-sm-6 col-6">
                                            <button class="btn btn-primary custome-black" type="button"
                                                onclick="nextStep(5)">Next</button>
                                        </div>
                                    </div>

                                </div>
                                {{-- <button class="btn btn-primary" onclick="nextStep(5)">Next</button> --}}
                            </div>
                        </div>

                        <!-- Step 5: Payment Information -->
                        <div class="step-content" id="step5">
                            <h3>Payment Information</h3>
                            <div class="form-group mb-3">
                                <label class="form-label fw500 dark-color " for="country">How would you like to pay
                                    for your service?</label>
                                <p style="margin-top: -10px;font-size: 14px;">Please note cancellation or rescheduling
                                    fees may apply for last minute changes.</p>
                                <div class="radio-group payment-type payment-center">
                                    <input type="radio" id="paymet_2" name="payment_type" value="ONLINE" checked>
                                    <label for="paymet_2"
                                        style="border-radius: 50px;text-align: center;width:50%;">Online</label>
                                    <img src="{{ asset('public/site/images/pay_logo_new.png') }}"
                                        style="height: 45px;margin-bottom:10px;" class="img-center">
                                </div>
                                {{-- <p>Payment will only be processed once the service is successfully completed.</p> --}}

                                <div class="radio-group payment-type">
                                    <input type="radio" id="paymet_1" name="payment_type" value="COD">
                                    <label for="paymet_1"
                                        style="border-radius: 50px;text-align: center;width:50%;">Cash</label>
                                    <p class="cash_fee">+ <span class="currency_dhiram"></span>
                                        {{ \App\Enums\VC_ChargiesEnum::COD->percentage() }} Cash handling
                                        charges will be applied.</p>
                                </div>

                                <p class="form-error-text" id="payment_type_error"
                                    style="color: red; margin-top: 10px;">
                                </p>
                            </div>
                            <div class="step-buttons">
                                <button class="btn btn-secondary custome-black" type="button"
                                    onclick="prevStep(4)">Back</button>
                                <div class="sticky-footer-btn">
                                    <div class="row align-items-center">
                                        <div class="col-md-6 col-lg-12 col-sm-6 col-6">
                                            <div class="mobile_total">
                                                <div class="font-weight-bold">
                                                    <div class="cross_amount_div" style="display: none;">

                                                        <span class="currency_dhiram"></span>
                                                        <span class="cross_amount"
                                                            style="text-decoration: line-through;"></span>
                                                    </div>
                                                    <div class="mobile_price" style="font-size: 25px;"><span
                                                            class="currency_dhiram"></span>
                                                        <span class="total_to_pay">0.00</span>
                                                        <i style="margin-left: 5px;"
                                                            class="fa-solid fa-angle-up arrow-toggle-mobile"
                                                            id="aerrowicon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-12 col-sm-6 col-6">
                                            <button class="btn btn-primary custome-black" type="button"
                                                onclick="nextStep(6)">Next</button>
                                        </div>
                                    </div>

                                </div>
                                {{-- <button class="btn btn-primary" onclick="nextStep(6)">Next</button> --}}
                            </div>
                        </div>
                        <!-- Step 6: Final Summary -->
                        <div class="step-content sidebar-summary" id="step6">
                            <h3>Booking Summary</h3>
                            <div class="form-content-main pb-0 pre-confirm-desc px-md-2 last-summary-para ">

                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <h5 class="card-title mb-md-4">Please review your booking details and confirm
                                            your booking.</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="font-weight-bold h5">
                                    Service Details
                                </div>
                                <div class="my-2">
                                    <div class="d-flex justify-content-between">
                                        <div>Service</div>
                                        <div class="font-weight-bold sm-summary">
                                            <span>{{ $subservice_data->subservicename }}</span>
                                        </div>
                                    </div>
                                </div>


                                {{-- <div class="font-weight-bold h5">
                                Date &amp; Time
                        </div> --}}
                                <div class="my-2">
                                    <div class="d-flex justify-content-between">
                                        <div>Date & Time</div>
                                        <div class="font-weight-bold sm-summary">
                                            <span class="date_replace"></span>
                                            at
                                            <span class="time_replace"></span>
                                        </div>
                                    </div>
                                </div>


                                {{-- <div class="font-weight-bold h5">
                            Address
                        </div> --}}

                                <div class="my-2">
                                    <div class="d-flex justify-content-between">
                                        <div>Address</div>
                                        <div class="font-weight-bold sm-summary">
                                            <span class="address_replace">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <span class="underline"></span>
                                <div class="sidebar-cart"></div>



                                <div class="font-weight-bold h5">
                                    Payment Method
                                </div>

                                <div class="my-2">
                                    <div class="d-flex justify-content-between">
                                        <div>Payment Method</div>
                                        <div class="font-weight-bold sm-summary"><span class="payment_mode">Cash on
                                                Delivery</span></div>
                                    </div>
                                </div>
                                <div class="font-weight-bold h5">
                                    Payment Details
                                </div>

                                <div class="my-2">
                                    <div class="d-flex justify-content-between subheadingdev">
                                        <div>Service Charges</div>
                                        <div class="font-weight-bold sm-summary">
                                            <span class="currency_dhiram"></span>
                                            <span class="service_charge">0.00</span>
                                        </div>
                                    </div>
                                </div>


                                <div class="my-2">
                                    <div class="d-flex justify-content-between subheadingdev d-none timing-charge-div">

                                        <div>Timing fee
                                            @if ($subservice_data->timing_fee_popup != '')
                                                <a class="open-fee-modal" data-title="Timing Fee"
                                                    data-content="{{ $subservice_data->timing_fee_popup }}">
                                                    <img src="{{ asset('public/site/images/infoicon.svg') }}"
                                                        style="height: 15px;width: 15px;">
                                                </a>
                                            @endif

                                        </div>
                                        <div class="font-weight-bold sm-summary">
                                            <span class="currency_dhiram"></span>
                                            <span class="timing_charge"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="my-2">
                                    <div class="d-flex justify-content-between subheadingdev d-none cod-charge-div">
                                        <div>Delivery charge

                                            @if ($subservice_data->delivery_charge_popup != '')
                                                <a class="open-fee-modal" data-title="Timing Fee"
                                                    data-content="{{ $subservice_data->delivery_charge_popup }}">
                                                    <img src="{{ asset('public/site/images/infoicon.svg') }}"
                                                        style="height: 15px;width: 15px;">
                                                </a>
                                            @endif
                                        </div>
                                        <div class="font-weight-bold sm-summary">
                                            <span class="currency_dhiram"></span>
                                            <span class="cod_charge"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-2">
                                    <div class="d-flex justify-content-between subheadingdev d-none service-fee-div">
                                        <div>Service Fee

                                            @if ($subservice_data->service_fee_popup != '')
                                                <a class="open-fee-modal" data-title="Timing Fee"
                                                    data-content="{{ $subservice_data->service_fee_popup }}">
                                                    <img src="{{ asset('public/site/images/infoicon.svg') }}"
                                                        style="height: 15px;width: 15px;">
                                                </a>
                                            @endif
                                        </div>
                                        <div class="font-weight-bold sm-summary">
                                            <span class="currency_dhiram"></span>
                                            <span class="service_fee"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="my-2">
                                    <div class="d-flex justify-content-between subheadingdev d-none subtotal-div">
                                        <div>Sub Total</div>
                                        <div class="font-weight-bold sm-summary">
                                            <span class="currency_dhiram"></span>
                                            <span class="sub_total">0.00</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="my-2">
                                    <div class="d-flex justify-content-between subheadingdev d-none vat-div">
                                        <div>VAT ({{ \App\Enums\VC_ChargiesEnum::VAT_PERCENT->percentage() }}%)</div>
                                        <div class="font-weight-bold sm-summary">
                                            <span class="currency_dhiram"></span>
                                            <span class="vat_charge">0</span>
                                        </div>
                                    </div>
                                </div>



                                <div class="subheadingdev">
                                    <div
                                        class="d-flex justify-content-between subheadingdev d-none promo_dicount_replace_div">
                                        <div>Coupon Code</div>
                                        <a href="javascript:void(0)" onclick="remove_coupon();"><span
                                                class="flaticon-delete"></span>
                                        </a>

                                        <div class="font-weight-bold sm-summary subheadingdev"
                                            style="background-color:#FFD312;border-radius: 6px;
                                padding: 0px 5px 0px 5px;">
                                            - <span class="currency_dhiram"></span>
                                            <span class="promo_code">0.00</span>
                                        </div>
                                    </div>

                                    <div
                                        class="d-flex justify-content-between subheadingdev d-none promo_dicount_replace_div">
                                        <div>Applied Coupon Code</div>
                                        <div class="font-weight-bold sm-summary">
                                            <span class="promo_code_name">ABC</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <div>
                                        <input type="text" name="promo_code2" id="promo_code2"
                                            class="form-control-coupan" placeholder="Enter Promo code">

                                    </div>


                                    <div>
                                        <input type="button" id="promocode" name="promocode" value="Apply"
                                            class="ud-btn-apply btn-thm default-box-shadow2"
                                            onclick="apply_promo(2);">
                                    </div>
                                </div>

                                @php
                                    $userData = Session::get('user');
                                    if ($userData && isset($userData['userid'])) {
                                        $wallet_plus_amount = DB::table('front_user_wallet')
                                            ->where('refer_id', $userData['userid'])
                                            ->where('added_from', 0)
                                            ->sum('wallet_amount');

                                        $wallet_minus_amount = DB::table('front_user_wallet')
                                            ->where('refer_id', $userData['userid'])
                                            ->where('added_from', 1)
                                            ->sum('wallet_amount');

                                        $wallet_amount = $wallet_plus_amount - $wallet_minus_amount;
                                    } else {
                                        $wallet_amount = 0;
                                    }
                                @endphp

                                @if ($wallet_amount > 0)
                                    <div class="my-2">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <span id="wallet_amount">Wallet Amount (<span
                                                        class="currency_dhiram"></span>{{ $wallet_amount }})</span>

                                                <button onclick="apply_wallet_discount();" type="button"
                                                    class=" ud-btn-apply btn-thm default-box-shadow2 wallet_apply_new">Apply</button>

                                                <button id="" onclick="cancelWalletDiscount();"
                                                    type="button"
                                                    class=" ud-btn-apply btn-thm default-box-shadow2 wallet_cancel_new"
                                                    style="display: none;">Cancel</button>

                                            </div>
                                            <div class="font-weight-bold sm-summary d-none wallet_dicount_replace_div">
                                                <span class="wallet_amount_div"></span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="my-2">
                                    <div class="d-flex justify-content-between">
                                        <div class="font-weight-bold h5">
                                            Total to pay
                                        </div>


                                        <div class="font-weight-bold step6finaldiv"
                                            style="max-width: 50%; text-align: right;">
                                            <div class="cross_amount_div" style="display: none;">
                                                <span class="currency_dhiram"></span>
                                                <span class="cross_amount"
                                                    style="text-decoration: line-through;"></span>
                                            </div>
                                            <strong>
                                                <span class="currency_dhiram"></span>
                                                <span class="total_to_pay">0.00</span>
                                            </strong>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="step-buttons">
                                <button class="btn btn-secondary custome-black" type="button"
                                    onclick="prevStep(5)">Back</button>

                                <button class="ud-btn btn-thm default-box-shadow2 order_now custome-black book-now-web"
                                    type="button" disabled id="spinner_button" style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...</button>
                                <button type="button"
                                    class="ud-btn btn-thm default-box-shadow2 order_now custome-black book-now-web finalbooknow"
                                    id="nextBtn12" onclick="nextStep(6);">Book Now </button>
                                {{-- <button class="btn btn-primary" onclick="nextStep(6)">Next</button> --}}
                            </div>
                        </div>

                    </div>

                    <input type="hidden" name="service_charge" id="service_charge" value="">
                    <input type="hidden" name="timing_charge" id="timing_charge" value="">
                    <input type="hidden" name="date_charge" id="date_charge" value="">
                    <input type="hidden" name="t_charge" id="t_charge" value="">
                    <input type="hidden" name="sub_total" id="sub_total" value="">
                    <input type="hidden" name="cod_charge" id="cod_charge" value="">
                    <input type="hidden" name="service_fee" id="service_fee" value="9">
                    <input type="hidden" name="total_to_pay" id="total_to_pay" value="">
                    <input type="hidden" name="vat_total" id="vat_total" value="">
                    <input type="hidden" name="date" id="date" value="">
                    <input type="hidden" name="month" id="month" value="">
                    <input type="hidden" name="promo_discount" id="promo_discount" value="">
                    <input type="hidden" name="promo_name" id="promo_name" value="">
                    <input type="hidden" id="wallet_used" name="wallet_used" value="">
                    <input type="hidden" id="wallet_balance" name="wallet_balance" value="{{ $wallet_amount }}">
                </form>
            </div>
            <div class="col-lg-4 col-md-4 sol-sm-12">
                <div class="sidebar sidebar-summary" id="rightSidebar">
                    <div class="d-flex justify-content-center mt-2 is-r font-weight-bold-summary">
                        <h5>Total to pay</h5>
                    </div>
                    <div class="left-summary-total d-flex mb-2">
                        <div class="cross_amount_div " style="display: none;">
                            <strong>
                                <span class="currency_dhiram"></span>
                                <span class="cross_amount" style="text-decoration: line-through;">150</span>
                            </strong>
                        </div>
                        <strong>
                            <span class="currency_dhiram"></span>
                            <span class="total_to_pay">0.00</span>
                        </strong>
                    </div>
                    <div class="font-weight-bold-summary h5 servicedetail_heading">Service Details</div>
                    <div class="d-flex justify-content-between subheadingdev">
                        <div>Service</div>
                        <div class="font-weight-bold sm-summary">
                            {{ $subservice_data->subservicename }}
                        </div>
                    </div>
                    <div class="d-flex justify-content-between subheadingdev">
                        <div>Date & Time</div>
                        <div class="font-weight-bold date_time_summary">
                            <span class="date_replace"></span></br>
                            <span class="time_replace"></span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between subheadingdev">
                        <div>Address</div>
                        <div class="font-weight-bold sm-summary">
                            <span class="address_replace">

                            </span>
                        </div>
                    </div>
                    <span class="underline"></span>
                    <div class="sidebar-cart"></div>

                    {{-- <div id="cart_item_list">
                              <div class="d-flex justify-content-between">
                                <div>Add ons package * 1 
                                  <a href="javascript:void(0)" onclick="remove_to_cart_book_now(); return false;">
                                    <span class="flaticon-delete"></span>
                                  </a>
                                </div>
                                <div class="font-weight-bold sm-summary">
                                  <span id="frequency_left_summary_replace">
                                      <span class="currency_dhiram"></span>
                                      500
                                  </span>
                                </div>
                            </div>
                            </div> --}}
                    <div class="font-weight-bold-summary h5 summarydev">Payment Details</div>
                    <div class="d-flex justify-content-between subheadingdev service-charge-div d-none">
                        <div>Service Charges</div>
                        <div class="font-weight-bold sm-summary">
                            <span class="currency_dhiram"></span>
                            <span class="service_charge">0.00</span>
                        </div>
                    </div>
                    {{-- <div class="d-flex justify-content-between promo_dicount_replace_div subheadingdev">
                                <div>Promo Discount</div>
                                <div class="font-weight-bold sm-summary" style="background-color:#FFD312;border-radius: 6px;padding: 0px 5px 0px 5px;">
                                  - <span class="currency_dhiram"></span>
                                  <span class="promo_dicount">0.00</span>
                                </div>
                              </div> --}}
                    {{-- <div class="d-flex justify-content-between subheadingdev d-none" style="">
                                <div>Additional Charges</div>
                                <div class="font-weight-bold sm-summary"> 
                                  <span class="currency_dhiram"></span>
                                  <span class="additional_charge">5.00</span>
                                </div>
                              </div> --}}
                    <div class="d-flex justify-content-between subheadingdev d-none timing-charge-div">

                        <div>Timing fee</div>
                        <div class="font-weight-bold sm-summary">
                            <span class="currency_dhiram"></span>
                            <span class="timing_charge"></span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between subheadingdev d-none cod-charge-div">
                        <div>Delivery charge</div>
                        <div class="font-weight-bold sm-summary">
                            <span class="currency_dhiram"></span>
                            <span class="cod_charge"></span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between d-none service-fee-div">
                        <div>Service Fee</div>
                        <div class="font-weight-bold sm-summary">
                            <span class="currency_dhiram"></span>
                            <span class="service_fee">0.00</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between subheadingdev d-none subtotal-div">
                        <div>Sub Total</div>
                        <div class="font-weight-bold sm-summary">
                            <span class="currency_dhiram"></span>
                            <span class="sub_total">0.00</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between subheadingdev d-none vat-div">
                        <div>VAT ({{ \App\Enums\VC_ChargiesEnum::VAT_PERCENT->percentage() }}%)</div>
                        <div class="font-weight-bold sm-summary">
                            <span class="currency_dhiram"></span>
                            <span class="vat_charge">0</span>
                        </div>
                    </div>
                    <div class="subheadingdev">
                        <div class="d-flex justify-content-between subheadingdev d-none promo_dicount_replace_div">
                            <div>Coupon Code</div>
                            <a href="javascript:void(0)" onclick="remove_coupon();"><span
                                    class="flaticon-delete"></span>
                            </a>

                            <div class="font-weight-bold sm-summary subheadingdev"
                                style="background-color:#FFD312;border-radius: 6px;
                                padding: 0px 5px 0px 5px;">
                                - <span class="currency_dhiram"></span>
                                <span class="promo_code">0.00</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between subheadingdev d-none promo_dicount_replace_div">
                            <div>Applied Coupon Code</div>
                            <div class="font-weight-bold sm-summary">
                                <span class="promo_code_name">ABC</span>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex justify-content-between">
                        <div>
                            <input type="text" name="promo_code0" id="promo_code0" class="form-control-coupan"
                                placeholder="Enter Promo code">

                        </div>


                        <div>
                            <input type="button" id="promocode" name="promocode" value="Apply"
                                class="ud-btn-apply btn-thm default-box-shadow2" onclick="apply_promo(0);">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@include('front.includes.footer')

<!-- Modal -->
<div class="modal fade subservice-read-more-model" id="subservice-read-more-model_{{ $subservice_data->id }}"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title">Modal Title</h5> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <!-- Long Content Here -->
                <img src="{{ url('public/upload/subservice/' . $subservice_data->service_detail_image) }}"
                    class="img-fluid" style="width: 100%;"
                    alt="{{ $subservice_data->image_alt_tag ?? $subservice_data->subservicename }}">

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h5>About our {{ $subservice_data->subservicename }} Service Includes</h5>
                </div>
                <hr style="border: 1px solid #ddd; margin: 20px 0;">
                <div>
                    {!! html_entity_decode($subservice_data->service_detail_popup_description) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade subservice-read-more-model" id="mobilesummaryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title">Modal Title</h5> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body sidebar-summary">

                <div class="sidebar-cart"></div>
                <div class="d-flex justify-content-between service-charge-div d-none">
                    <div>Service Charges</div>
                    <div class="font-weight-bold sm-summary">
                        <span class="currency_dhiram"></span>
                        <span class="service_charge">0.00</span>
                    </div>
                </div>
                {{-- <div id="promo_discount_wrapper_mobile" class="promo_dicount_replace_div">
                <div class="d-flex justify-content-between" >
                  <div>Promo Discount</div>
                  <div class="font-weight-bold sm-summary" style="background-color:#FFD312;border-radius: 6px;
                    padding: 0px 5px 0px 5px;">
                    - <span class="currency_dhiram"></span> 
                    <span id="promo_dicount_mobile">0.00</span>
                  </div>
                </div>
          </div> --}}

                <div class="d-flex justify-content-between d-none timing-charge-div">
                    <div>Timing fee</div>
                    <div class="font-weight-bold sm-summary">
                        <span class="currency_dhiram"></span>
                        <span class="timing_charge"></span>
                    </div>
                </div>
                <div class="d-flex justify-content-between d-none cod-charge-div ">
                    <div>Delivery charge</div>
                    <div class="font-weight-bold sm-summary">
                        <span class="currency_dhiram"></span>
                        <span class="cod_charge"></span>
                    </div>
                </div>

                <div class="d-flex justify-content-between d-none service-fee-div">
                    <div>Service Fee</div>
                    <div class="font-weight-bold sm-summary">
                        <span class="currency_dhiram"></span>
                        <span class="service_fee">0.00</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between d-none subtotal-div">
                    <div>Sub Total</div>
                    <div class="font-weight-bold sm-summary">
                        <span class="currency_dhiram"></span>
                        <span class="sub_total">0.00</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between d-none vat-div">
                    <div>VAT ({{ \App\Enums\VC_ChargiesEnum::VAT_PERCENT->percentage() }}%)</div>
                    <div class="font-weight-bold sm-summary">
                        <span class="currency_dhiram"></span>
                        <span class="vat_charge">0</span>
                    </div>
                </div>
                <div class="subheadingdev">
                    <div class="d-flex justify-content-between subheadingdev d-none promo_dicount_replace_div">
                        <div>Coupon Code</div>
                        <a href="javascript:void(0)" onclick="remove_coupon();"><span class="flaticon-delete"></span>
                        </a>

                        <div class="font-weight-bold sm-summary subheadingdev"
                            style="background-color:#FFD312;border-radius: 6px;
                                padding: 0px 5px 0px 5px;">
                            - <span class="currency_dhiram"></span>
                            <span class="promo_code">0.00</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between subheadingdev d-none promo_dicount_replace_div">
                        <div>Applied Coupon Code</div>
                        <div class="font-weight-bold sm-summary">
                            <span class="promo_code_name">ABC</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <input type="text" name="promo_code1" id="promo_code1" class="form-control-coupan"
                            placeholder="Enter Promo code">

                    </div>


                    <div>
                        <input type="button" id="promocode" name="promocode" value="Apply"
                            class="ud-btn-apply btn-thm default-box-shadow2" onclick="apply_promo(1);">
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-2 is-r font-weight-bold-summary">
                    <h5>Total to pay</h5>
                </div>
                <div class="left-summary-total d-flex mb-2">
                    <div class="cross_amount_div" style="display: none">
                        <strong>
                            <span class="currency_dhiram"></span>
                            <span class="cross_amount" style="text-decoration: line-through;">150</span>
                        </strong>
                    </div>
                    <strong>
                        <span class="currency_dhiram"></span>
                        <span class="total_to_pay">0.00</span>
                    </strong>
                </div>


            </div>
        </div>
    </div>
</div>

@foreach ($package_cat as $package_cat_data)
    @php
        $package = DB::table('packages')
            ->where('service_id', $service_id)
            ->where('subservice_id', $subservice_id)
            ->where('packagecategory_id', $package_cat_data->id)
            ->get()
            ->toArray();
    @endphp


    @foreach ($package as $package_data)
        @php
            $price = $package_data->price;
            $discount_price = 0;

            if (!empty($package_data->discount) && isset($package_data->discount_type)) {
                $discount_price =
                    $package_data->discount_type == 0
                        ? ($package_data->discount / 100) * $package_data->price
                        : $package_data->discount;

                $price -= $discount_price;
            }
        @endphp
        <div class="modal fade subservice-read-more-model" id="package-detail-model_{{ $package_data->id }}"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        {{-- <h5 class="modal-title">Modal Title</h5> --}}
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Long Content Here -->
                        <img src="{{ url('public/upload/packages/popupimage/' . $package_data->popup_image) }}"
                            alt="{{ $package_data->image_alt_tag ?? $package_data->name }}" class="img-fluid"
                            style="width: 100%;">

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="">
                                <h5>{{ $package_data->name }}</h5>
                            </div>
                            <div class="" style="display: flex;align-items: center;gap: 13px;">
                                <b class="popup-price">
                                    <span class="currency_dhiram"></span>
                                    {{ $price }}</b>
                                @if ($discount_price > 0)
                                    <span
                                        style="text-decoration: line-through; margin-right: 10px; display: flex;align-items: center;gap: 2px;color: #000;">
                                        <span
                                            class="currency_dhiram"></span>{{ number_format($package_data->price, 2) }}
                                    </span>
                                @endif
                            </div>


                        </div>
                        <hr style="border: 1px solid #ddd; margin: 20px 0;">
                        <div>
                            {!! html_entity_decode($package_data->description) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endforeach

@if (isset($addons) && count($addons) > 0)
    @foreach ($addons as $addonsData)
        <div class="modal fade subservice-read-more-model" id="addons-detail-model_{{ $addonsData->id }}"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $addonsData->name ?? '' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Long Content Here -->
                        {{-- <img src="{{ url('public/upload/packages/popupimage/' . $package_data->popup_image) }}" alt="{{ $package_data->image_alt_tag ?? $package_data->name }}" class="img-fluid" style="width: 100%;"> --}}


                        <div>
                            {{ $addonsData->short_desc }}
                        </div>
                        <hr style="border: 1px solid #ddd; margin: 20px 0;">
                        @php
                            $priceaddons = $addonsData->price;
                            $discount_priceaddons = 0;

                            if (!empty($addonsData->discount) && isset($addonsData->discount_type)) {
                                $discount_priceaddons =
                                    $addonsData->discount_type == 0
                                        ? ($addonsData->discount / 100) * $addonsData->price
                                        : $addonsData->discount;

                                $priceaddons -= $discount_priceaddons;
                            }
                        @endphp

                        <div class="price-box text-left addons_popup">
                            <span class="new-price">
                                <p class="currency_dhiram"></p> {{ number_format($priceaddons, 2) }}
                            </span>
                            @if ($discount_priceaddons > 0)
                                <span class="old-price">
                                    <p class="currency_dhiram"></p> {{ number_format($addonsData->price, 2) }}
                                </span>
                            @endif
                        </div>
                        <hr style="border: 1px solid #ddd; margin: 20px 0;">
                        <div>
                            {!! html_entity_decode($addonsData->description) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
<!-- OTP Popup Start-->
<div class="modal modal-mobile-bottom-otp otp-login-form-modal" id="exampleModalLong" tabindex="-1"
    aria-labelledby="otpLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom-otp user-modal-dialog modal-dialog-centered">
        <div class="modal-content details-modal-content">
            <div class="modal-header details-header">
                <h5 class="modal-title w-100" id="modalStepTitle">Log in or Sign Up</h5>
            </div>

            <div class="modal-body">
                <div id="booknow_refresh_otp_div">
                    <input type="hidden" name="book_session_otp" id="book_session_otp"
                        value= "{{ session('book-login-otp') }}">
                </div>
                <form class="form-horizontal details-form" id="BookOtpForm" method="POST"
                    action="{{ route('booknow-user-otp-login') }}">

                    <input type="hidden" name="redirectUrl" value="{{ $redirectUrl }}">
                    <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
                    <input type="hidden" name="subservice_id" id="subservice_id" value="{{ $subservice_id }}">

                    @csrf

                    <!-- STEP 1: Mobile Input -->
                    <div id="booknow-step-phone">
                        <div class="form-group mb-2">
                            <label id="mobilename-label">Please Enter Your WhatsApp mobile number</label>
                            <input type="hidden" name="country_code_otp_popup_Modal"
                                id="country_code_otp_popup_Modal_book" value="">
                            <input type="tel" class="input-field" name="phone" id="user-phone-number"
                                placeholder="Mobile No" onkeypress="return validateNumber(event)">
                            <p id="booknow_otp_phone_error" style="display:none;color:red;"></p>
                        </div>
                        <a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp"
                            data-bs-target="#book_email_otp_popup_Modal">Don't have a WhatsApp Number? Login with
                            Email</a>
                        <div class="text-center mt-3">

                            <button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                type="button" disabled id="spinner_button_phone_book1" style="display: none;">
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>Loading...
                            </button>

                            <button type="button"
                                class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                id="submit_button_phone_book1"
                                onclick="booknow_otp_verification('1')">Continue</button>
                        </div>
                    </div>

                    <!-- STEP 2: OTP Verification -->
                    <div id="booknow-step-otp" style="display: none;">
                        <label id="mobilename-label">Please enter the <strong>WhatsApp code</strong> that was sent
                            to:<br>
                            <span id="booknow-whatsapp-number">+971 58 520 0722</span>
                        </label>

                        <div class="d-flex justify-content-center gap-2 my-3">
                            <input type="tel" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="tel" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="tel" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="tel" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="tel" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="tel" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                        </div>
                        <p id="booknow_otp_error" style="display:none;color:red;"></p>

                        <a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp"
                            data-bs-target="#book_email_otp_popup_Modal">Can't log in? Use your Email Address</a>

                        <div class="text-center mt-3">
                            <button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                type="button" disabled id="spinner_button_phone_book2" style="display: none;">
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>Loading...
                            </button>
                            <button type="button"
                                class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                id="submit_button_phone_book2" onclick="booknow_otp_verification('2')">Verify
                                Number</button>
                        </div>
                    </div>

                    <!-- STEP 3: Personal Details -->
                    <div id="booknow-step-details" style="display: none;">
                        <label id="mobilename-label">Contact information</label>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="book_name" id="booknow_user_name"
                                placeholder="Full Name">
                            <p id="booknow_name_error" style="display:none;color:red;"></p>
                        </div>
                        <div class="form-group mt-3">
                            <input type="email" class="form-control" id="booknow_user_email" name="book_email"
                                placeholder="Email">
                            <p id="booknow_email_error" style="display:none;color:red;"></p>
                        </div>

                        <div class="text-center mt-3">
                            <button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                type="button" disabled id="spinner_button_phone_book3" style="display: none;">

                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>Loading...</button>

                            <button type="button"
                                class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                id="submit_button_phone_book3" onclick="booknow_otp_verification('3')">All
                                Done</button>

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

<div class="modal modal-mobile-bottom-otp otp-login-form-modal" id="book_email_otp_popup_Modal" tabindex="-1"
    aria-labelledby="otpLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom-otp user-modal-dialog modal-dialog-centered">
        <div class="modal-content details-modal-content">
            <div class="modal-header details-header">
                <h5 class="modal-title w-100" id="booknow_email_modalStepTitle">Log in or Sign Up</h5>
            </div>

            <div class="modal-body">
                <div id="book_email_refresh_otp_div">
                    <input type="hidden" name="book_email_session_otp" id="book_email_session_otp"
                        value= "{{ session('book-email-login-otp') }}">
                </div>
                <form class="form-horizontal details-form" id="bookemailOtpForm" method="POST"
                    action="{{ route('home.book-email-otp-login') }}">
                    <input type="hidden" name="redirectUrl" value="{{ $redirectUrl }}">
                    <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
                    <input type="hidden" name="subservice_id" id="subservice_id" value="{{ $subservice_id }}">

                    <input type="hidden" name="country_code_book_popup_Modal_book"
                        id="country_code_book_popup_Modal_book" value="">
                    @csrf


                    <!-- STEP 1: Mobile Input -->
                    <div id="book-email-step-phone">
                        <div class="form-group mb-2">
                            <label id="mobilename-label">Please Enter Your Email Address</label>
                            <input type="text" class="input-field" name="book_email_email" id="book_email_email"
                                placeholder="Email Address">
                            <p id="book_email_email_error" style="display:none;color:red;"></p>
                        </div>
                        <a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp"
                            data-bs-target="#exampleModalLong">Can't access your email? Log in with WhatsApp</a>
                        <div class="text-center mt-3">
                            <button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                type="button" disabled id="spinner_button_email_book1" style="display: none;">

                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>

                                Loading...

                            </button>
                            <button type="button"
                                class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                id="submit_button_email_book1"
                                onclick="book_email_goToOtpVerification('1')">Continue</button>
                        </div>
                    </div>

                    <!-- STEP 2: OTP Verification -->
                    <div id="booknow-email-step-otp" style="display: none;">
                        <label id="mobilename-label">Please enter the <strong>OTP</strong> that was sent to:<br>
                            <span id="book_email_address_model">+971 58 520 0722</span>
                        </label>

                        <div class="d-flex justify-content-center gap-2 my-3">
                            <input type="text" maxlength="1"
                                class="book-email-otp-input form-control text-center" style="width: 40px;">
                            <input type="text" maxlength="1"
                                class="book-email-otp-input form-control text-center" style="width: 40px;">
                            <input type="text" maxlength="1"
                                class="book-email-otp-input form-control text-center" style="width: 40px;">
                            <input type="text" maxlength="1"
                                class="book-email-otp-input form-control text-center" style="width: 40px;">
                            <input type="text" maxlength="1"
                                class="book-email-otp-input form-control text-center" style="width: 40px;">
                            <input type="text" maxlength="1"
                                class="book-email-otp-input form-control text-center" style="width: 40px;">
                        </div>
                        <p id="book_email_otp_error" style="display:none;color:red;"></p>
                        <a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp"
                            data-bs-target="#exampleModalLong">Can't access your email? Log in with WhatsApp</a>

                        <div class="text-center mt-3">
                            <button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                type="button" disabled id="spinner_button_email_book2" style="display: none;">
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>Loading...</button>

                            <button type="button"
                                class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                id="submit_button_email_book2" onclick="book_email_goToOtpVerification('2')">Verify
                                Email</button>
                        </div>
                    </div>

                    <!-- STEP 3: Personal Details -->
                    <div id="booknow-email-step-details" style="display: none;">
                        <label id="mobilename-label">Contact information</label>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="book_email_name"
                                id="book_email_name" placeholder="Full Name">
                            <p id="book_email_name_error" style="display:none;color:red;"></p>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" id="book_email_mobile"
                                name="book_email_mobile" placeholder="Phone Number"
                                onkeypress="return validateNumber(event)">
                            <p id="book_email_mobile_error" style="display:none;color:red;"></p>
                        </div>

                        <div class="text-center mt-3">
                            <button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                type="button" disabled id="spinner_button_email_book3"
                                style="display: none;"><span class="spinner-border spinner-border-sm"
                                    role="status" aria-hidden="true"></span>Loading...</button>

                            <button type="button"
                                class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                id="submit_button_email_book3" onclick="book_email_goToOtpVerification('3')">All
                                Done</button>
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

<!--- Fee Popup Start ---->
{{--  
   <div class="modal fade" id="feeModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="feeModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" id="feeModalContent"></div>

    </div>
  </div>
</div> --}}

<div class="modal fade subservice-read-more-model" id="feeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feeModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="feeModalContent"></div>
        </div>
    </div>
</div>

<!--- Fee Popup End ---->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

<script>
    var booknowOtpUrl = "{{ url('booknow-otp-sent') }}";
    var booknowOtpUrlEmail = "{{ route('home.book-email-otp-sent') }}";
    var package_promo_check = "{{ route('package_promo_check') }}";
    const dirhamBlack = "{{ asset('public/site/images/automobile/Dirhamblack.png') }}";
</script>

<script>
    let codCharge = window.Enums.vcCharges.COD.value;
    let vatPercent = window.Enums.vcCharges.VAT_PERCENT.value;
</script>

<script src="{{ asset('public/site/js/booknownew.js') }}"></script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        //updateSidebarCart();
    });

    $(document).ready(function() {
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
        @if (Session::get('user') == '')
            $('#exampleModalLong').modal('show');
        @endif
    });


    let cart = {}; // unified cart for packages + addons

    $(document).ready(function() {

        // 1️⃣ Load cart from session
        $.get("{{ route('cart.package_cart') }}", function(data) {
            cart = data || {};

            Object.keys(cart).forEach(id => {
                // Packages
                let pkgBtn = $(".addbutton[data-id='" + id + "']");
                let pkgQty = $(".quantity-control[data-id='" + id + "']");
                if (pkgBtn.length) {
                    pkgBtn.hide();
                    pkgQty.show();
                    pkgQty.find(".quantity").text(cart[id].qty);
                }

                // Addons
                let addBtn = $(".addons-addbutton[data-id='" + id + "']");
                let addQty = $(".addons-quantity-control[data-id='" + id + "']");
                if (addBtn.length) {
                    addBtn.hide();
                    addQty.show();
                    addQty.find(".addons-quantity").text(cart[id].qty);
                }
            });

            updateSidebarCart();
        });

        // 2️⃣ Add Package
        $(document).on("click", ".addbutton", function() {
            let id = $(this).data("id").toString();
            let name = $(this).data("name");
            let price = parseFloat($(this).data("price"));
            let service = $(this).data("service");
            let subservice_id = $(this).data("subservice_id");
            let type = $(this).data("type");


            $(this).hide();
            let qtyDiv = $(".quantity-control[data-id='" + id + "']");
            qtyDiv.show();

            if (!cart[id]) cart[id] = {
                name,
                price,
                qty: 1,
                service,
                subservice_id,
                type
            };
            qtyDiv.find(".quantity").text(cart[id].qty);
            updateSidebarCart();
        });

        // 3️⃣ Add Addon
        $(document).on("click", ".addons-addbutton", function() {
            let id = $(this).data("id").toString();
            let name = $(this).data("name");
            let price = parseFloat($(this).data("price"));
            let service = $(this).data("service");
            let subservice_id = $(this).data("subservice_id");
            let type = $(this).data("type");

            $(this).hide();
            let qtyDiv = $(".addons-quantity-control[data-id='" + id + "']");
            qtyDiv.show();

            if (!cart[id]) cart[id] = {
                name,
                price,
                qty: 1,
                service,
                subservice_id,
                type
            };
            qtyDiv.find(".addons-quantity").text(cart[id].qty);
            updateSidebarCart();
        });

        // 4️⃣ Plus/Minus Packages
        $(document).on("click", ".plus-btn, .minus-btn", function() {
            let parent = $(this).closest(".quantity-control");
            let id = parent.data("id").toString();

            if (!cart[id]) return;

            cart[id].qty = Number(cart[id].qty); // FORCE number
            cart[id].qty += $(this).hasClass("plus-btn") ? 1 : -1;

            if (cart[id].qty <= 0) {
                delete cart[id];
                parent.hide();
                $(".addbutton[data-id='" + id + "']").show();
            } else {
                parent.find(".quantity").text(cart[id].qty);
            }

            updateSidebarCart();
        });

        // 5️⃣ Plus/Minus Addons
        $(document).on("click", ".addons-plus-btn, .addons-minus-btn", function() {
            let parent = $(this).closest(".addons-quantity-control");
            let id = parent.data("id").toString();

            if (!cart[id]) return;

            cart[id].qty = Number(cart[id].qty); // FORCE number
            cart[id].qty += $(this).hasClass("addons-plus-btn") ? 1 : -1;

            if (cart[id].qty <= 0) {
                delete cart[id];
                parent.hide();
                $(".addons-addbutton[data-id='" + id + "']").show();
            } else {
                parent.find(".addons-quantity").text(cart[id].qty);
            }

            updateSidebarCart();
        });

        // 6️⃣ Remove item from sidebar
        $(document).on("click", ".remove-item", function() {
            let id = $(this).data("id").toString();
            delete cart[id];

            // hide buttons
            $(".quantity-control[data-id='" + id + "']").hide().find(".quantity").text(1);
            $(".addbutton[data-id='" + id + "']").show();

            $(".addons-quantity-control[data-id='" + id + "']").hide().find(".addons-quantity").text(1);
            $(".addons-addbutton[data-id='" + id + "']").show();

            updateSidebarCart();
        });

    });

    // 7️⃣ Update sidebar + totals
    function updateSidebarCart() {

        //checkapplyPromo();

        let html = "",
            total = 0;

        Object.keys(cart).forEach(id => {
            let item = cart[id];
            let subtotal = item.price * item.qty;
            total += subtotal;

            html += `
            <div class="d-flex justify-content-between cart-row">
                <div>${item.name} x ${item.qty}
                    <!--<a href="javascript:void(0)" class="remove-item" data-id="${id}">
                        <span class="flaticon-delete"></span>
                    </a>-->
                </div>
                <div class="font-weight-bold sm-summary">
                    <span class="currency_dhiram"></span>
                    ${subtotal.toFixed(2)}
                </div>
            </div>
        `;
        });

        $(".sidebar-cart").html(html);


        // Your calculation logic
        let serviceCharge = parseFloat($("#service_charge").val()) || 0;

        let DateCharge = parseFloat($("#date_charge").val()) || 0;
        let tCharge = parseFloat($("#t_charge").val()) || 0;
        let codCharge = parseFloat($("#cod_charge").val()) || 0;
        let serviceFee = parseFloat($("#service_fee").val()) || 0;
        let promo_discount = parseFloat($("#promo_discount").val()) || 0;
        let wallet_used = parseFloat($("#wallet_used").val()) || 0;
        let promo_name = $("#promo_name").val();

        // alert(promo_name);
        // alert(promo_discount);

        var finalTimingcharge = DateCharge + tCharge;
        $("#timing_charge").val(finalTimingcharge.toFixed(2));


        let timingCharge = parseFloat($("#timing_charge").val()) || 0;

        //alert(timingCharge);

        let subtotalCharge = total + timingCharge + codCharge + serviceFee;
        let vat_charge = subtotalCharge * (vatPercent / 100);
        let totalToPay = subtotalCharge + vat_charge - promo_discount - wallet_used;

        // alert(totalToPay);
        // alert(wallet_used);

        // BEFORE PROMO
        let beforePromo = subtotalCharge + vat_charge - promo_discount - wallet_used;

        $("#service_charge").val(total.toFixed(2));
        $("#sub_total").val(subtotalCharge.toFixed(2));
        $("#vat_total").val(vat_charge.toFixed(2));
        $("#total_to_pay").val(totalToPay.toFixed(2));

        $(".total_to_pay").text(totalToPay.toFixed(2));

        $(".promo_code").text(promo_discount.toFixed(2));
        $(".promo_code_name").text(promo_name);



        // Store in Laravel session
        $.ajax({
            url: "{{ route('cart.package_cart_store') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                cart
            }
        });

        checkapplyPromo(beforePromo);

        updateAllSummaries();


    }

    function checkapplyPromo(baseTotal) {

        $.get("{{ route('package.get_coupon') }}", function(couponData) {

            let couponDiscount = 0;

            // 🔥 FIX: Always ensure valid numbers
            baseTotal = parseFloat(baseTotal) || 0;
            couponDiscount = parseFloat(couponDiscount) || 0;

            if (couponData) {

                if (couponData.coupanvalue == '0') {
                    couponDiscount = (couponData.discount / 100) * baseTotal;
                } else {
                    couponDiscount = couponData.discount;
                }

                $('#promo_name').val(couponData.coupancode);
                $('.promo_code_name').text(couponData.coupancode);

            } else {
                $('#promo_name').val('');
                couponDiscount = 0;
            }

            // 🔥 FIX: enforce number again before toFixed()
            couponDiscount = parseFloat(couponDiscount) || 0;

            $('#promo_discount').val(couponDiscount.toFixed(2));

            let totalToPay = baseTotal - couponDiscount;

            $("#total_to_pay").val(totalToPay.toFixed(2));
            $(".total_to_pay").text(totalToPay.toFixed(2));
            $(".promo_code").text(couponDiscount.toFixed(2));

            // 🔥 SHOW / HIDE CROSSED AMOUNT
            if (couponDiscount > 0) {
                $(".cross_amount").text(baseTotal.toFixed(2));
                $(".cross_amount_div").show();
            } else {
                $(".cross_amount_div").hide();
            }
            updateAllSummaries();
        });
    }


    function remove_coupon() {

        Swal.fire({
            title: "Remove Promo Code?",
            text: "Are you sure you want to remove this coupon?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Remove",
            cancelButtonText: "Cancel"
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "{{ route('package.remove_coupon') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {

                        $('#promo_name').val('');
                        $('#promo_discount').val('0.00');
                        $(".promo_code").text('0.00');
                        $(".promo_code_name").text('');
                        $(".cross_amount_div").hide();

                        updateSidebarCart();

                        Swal.fire({
                            icon: "success",
                            title: "Coupon Removed!",
                            showConfirmButton: false,
                            timer: 1200
                        });
                    }
                });

            }

        });
    }

    function removeCoupan() {
        $.ajax({
            url: "{{ route('package.remove_coupon') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function() {

                $('#promo_name').val('');
                $('#promo_discount').val('0.00');
                $(".promo_code").text('0.00');
                $(".promo_code_name").text('');
                $(".cross_amount_div").hide();

                updateSidebarCart();

            }
        });
    }



    function updateAllSummaries() {
        //alert("called");
        const charges = [{
                id: '#service_charge',
                row: '.service-charge-div',
                span: '.service_charge'
            },
            {
                id: '#timing_charge',
                row: '.timing-charge-div',
                span: '.timing_charge'
            },
            {
                id: '#sub_total',
                row: '.subtotal-div',
                span: '.sub_total'
            },
            {
                id: '#cod_charge',
                row: '.cod-charge-div',
                span: '.cod_charge'
            },
            {
                id: '#vat_total',
                row: '.vat-div',
                span: '.vat_charge'
            },
            {
                id: '#total_to_pay',
                row: '.left-summary-total',
                span: '.total_to_pay'
            },
            {
                id: '#service_fee',
                row: '.service-fee-div',
                span: '.service_fee'
            },
            {
                id: '#promo_discount',
                row: '.promo_dicount_replace_div',
                span: '.promo_code'
            },
            {
                id: '#promo_name',
                row: '.promo_name_replace_div',
                span: '.promo_code_name'
            },
            {
                id: '#wallet_used',
                row: '.wallet_dicount_replace_div',
                span: '.wallet_amount_div'
            },
        ];

        $(".sidebar-summary").each(function() {
            let summary = $(this);

            charges.forEach(c => {
                let value = parseFloat($(c.id).val()) || 0;
                let row = summary.find(c.row);

                if (value > 0) {
                    row.removeClass("d-none").show();
                    summary.find(c.span).text(value.toFixed(2));
                } else {
                    row.addClass("d-none").hide();
                }
            });

        });
    }

    function dateclickfunction(dayName, monthName, dayNum, price) {
        //alert(`Selected: ${dayName}, ${monthName} ${dayNum} ${price}`);

        $('#date').val(dayNum);
        $('#month').val(monthName);

        $('#t_charge').val('');
        $('.time_replace').html('');

        let year = new Date().getFullYear();
        let fullSummaryDate = `${dayNum} ${monthName} ${year}`;
        $('.date_replace').html(fullSummaryDate);

        // Store display date like "21 November"
        let displayDate = `${dayNum} ${monthName}`;
        $('#selected_display_date').val(displayDate);

        // Store backend date like "2025-11-21"

        let backendDate = `${year}-${convertMonthToNumber(monthName)}-${String(dayNum).padStart(2,'0')}`;
        $('#selected_backend_date').val(backendDate);

        // Update price
        if (price == 0) {
            $('#date_charge').val('');
        } else {
            $('#date_charge').val(price);
        }

        // Apply blur effect
        $(".time_replace_ab").addClass("time-loading");

        $.ajax({
            url: "{{ route('package.package_get_timeslots') }}",
            type: "POST",
            data: {
                date: backendDate,
                subservice_id: @json($subservice_data->id),
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                $(".time_replace_ab").html(res.html);

                // Remove blur effect
                $(".time_replace_ab").removeClass("time-loading");
            },
            error: function() {
                $(".time_replace_ab").removeClass("time-loading");
            }
        });

        updateSidebarCart();
    }

    function convertMonthToNumber(monthName) {
        const months = {
            "January": "01",
            "February": "02",
            "March": "03",
            "April": "04",
            "May": "05",
            "June": "06",
            "July": "07",
            "August": "08",
            "September": "09",
            "October": "10",
            "November": "11",
            "December": "12"
        };
        return months[monthName];
    }

    function timeSlotClick(price, name) {

        $('.time_replace').html(name);

        if (price == 0) {
            $('#t_charge').val('');
        } else {
            $('#t_charge').val(price);
        }

        updateSidebarCart();
    }

    function validateStep1() {

        var serviceFee = parseFloat($("#service_charge").val());

        if (isNaN(serviceFee) || serviceFee <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Package Selected',
                text: 'Please select at least one package to continue.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
            });
            return false;
        }

        return true;
    }

    function validateStep2() {
        return true;
    }

    function validateStep3() {

        let date = $('#date').val();

        if (!date) {
            Swal.fire({
                icon: 'warning',
                title: 'Please Select a Date',
                text: 'You must choose a date to continue.',
                confirmButtonColor: '#3085d6',
            });

            return false;
        }
        let timeSlot = $('input[name="time_slot"]:checked').val();

        if (!timeSlot) {
            Swal.fire({
                icon: 'warning',
                title: 'Please Select a Time Slot',
                text: 'You must choose a time slot to continue.',
                confirmButtonColor: '#3085d6',
            });

            return false;
        }

        return true;
    }

    function validateStep4() {

        let city = $('#city').val();
        if (!city) {
            Swal.fire({
                icon: 'warning',
                title: 'Please Select a City',
                text: 'You must choose a City to continue.',
                confirmButtonColor: '#3085d6',
            });

            return false;
        }

        let area = $('#area').val();
        if (!area) {
            Swal.fire({
                icon: 'warning',
                title: 'Please Enter Area',
                //text: 'You must Enter Area to continue.',
                confirmButtonColor: '#3085d6',
            });

            return false;
        }

        let building_street_no = $('#building_street_no').val();
        if (!building_street_no) {
            Swal.fire({
                icon: 'warning',
                title: 'Please Enter your building name or street',
                //text: 'You must Enter Area to continue.',
                confirmButtonColor: '#3085d6',
            });

            return false;
        }

        let apartment_villa_no = $('#apartment_villa_no').val();
        if (!apartment_villa_no) {
            Swal.fire({
                icon: 'warning',
                title: 'Please Enter your apartment number & floor or villa number',
                //text: 'You must Enter Area to continue.',
                confirmButtonColor: '#3085d6',
            });

            return false;
        }

        var address = city + ', ' + area + ', ' + building_street_no + ', ' + apartment_villa_no;

        $('.address_replace').html(address);

        return true;
    }

    function validateStep5() {

        var payment_type = $("input[name='payment_type']:checked").val();
        if (payment_type == 'COD') {
            var charge_text = "Cash on Delivery";
        } else {
            var charge_text = "Online";
        }

        $('.payment_mode').html(charge_text);

        return true;
    }

    $("input[name='payment_type']").on("change", function() {

        var payment_type = $("input[name='payment_type']:checked").val();

        if (payment_type == 'COD') {
            var charge_payment = codCharge;
        } else {
            var charge_payment = 0;
        }

        $('#cod_charge').val(charge_payment);

        updateSidebarCart();



    });

    function validateStep6() {
        //('.sidebar').hide();

        $('#spinner_button').show();
        $('.finalbooknow').hide();

        localStorage.removeItem('currentStep');

        $('#bookingForm').submit();

        //alert("Booking Confirmed Successfully!");
        return true;
    }

    $(document).on("click", ".open-fee-modal", function() {

        var title = $(this).data("title");
        var content = $(this).data("content");

        $("#feeModalLabel").text(title);
        $("#feeModalContent").html(content);

        $("#feeModal").modal("show");
    });
</script>
