@include('front.includes.header')
<style>
    .banner_sec {
        margin-left: 85%;
        text-align: center;
    }

    .cta-service-v3 {
        background-image: inherit;
        background-color: #eee;
    }

    .listing-style1 {
        border: none !important;
        margin-bottom: 15px !important;
    }

    .serviceimage_desktop {
        display: block;
    }

    .serviceimage_mobile {
        display: none;
    }

    .review-stars {
        justify-content: center;
    }

    .custom_splide.main-title {
        margin-bottom: 0px;
    }

    @media (max-width: 767px) {
        .google-button {
            font-size: 13px !important;
            padding: 5px 5px !important;
        }

        .google-text {
            font-size: 20px !important;
        }

        .googlereview p {
            font-size: 15px !important;
        }

        .mobile-splide {
            padding: 10px !important;
        }

        .serviceimage_desktop {
            display: none !important;
        }

        .serviceimage_mobile {
            display: block !important;
        }

        .review-description {
            font-size: 12px !important;
            max-height: 9em !important;
            height: 50px !important;
            margin-bottom: 0px !important;
        }

        .body_content {
            margin-top: 144px !important;
        }

        .mobile_img {
            display: block !important;
        }

        .desktop_img {
            display: none !important;
        }

        .content-title {
            margin-top: 80% !important;
        }

        .banner-content-center {
            position: absolute;
            top: 60%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 2;
            padding: 0 15px;
            width: 100% !important;
        }

        .banner_static_title {
            font-size: 22px !important;
        }

        .banner_static_subtitle {
            font-size: 12px !important;
        }





    }

    .content-title {
        margin-top: 0%;
    }

    .mobile_img {
        display: none;
    }

    .desktop_img {
        display: block;
    }


    .review-description {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        max-height: 10em;
        height: 90px;
        margin-bottom: 0px !important;
    }

    .service-v3-vector {
        top: 0% !important;
        right: 0% !important;
    }

    .cta-service-v3 {
        height: 440px !important;
    }

    .list-content h5 {
        font-size: 15px !important;
    }

    .popular_service {
        font-size: 24px !important;
        font-weight: 700;
    }

    .freelancer-style1 {
        padding: 15px;
    }

    .banner-content-center {
        position: absolute;
        top: 65%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 2;
        padding: 0 15px;
        width: 55%;
    }

    .banner_static_title {
        font-size: 32px;
        width: 100% !important;
    }

    @media (min-width: 768px) and (max-width: 1024px) {

        .service-v3-vector {
            width: auto !important;
        }

        .banner-content-center {
            top: 50%;
            width: 90%;
        }

    }

    @media only screen and (min-device-width: 820px) and (max-device-width: 1180px) and (-webkit-min-device-pixel-ratio: 2) {
        .service-v3-vector {
            width: auto !important;
        }

        .banner-content-center {
            top: 50%;
            width: 90%;
        }
    }

    .placeholder {
        height: 0;
        width: 100%;
        opacity: inherit;
        cursor: auto !important;
    }

    .booking_desc li {
        list-style-type: inherit !important;
    }
</style>
<section class="breadcumb-section pt0 mt120">
    <div>

        <div
            class="cta-service-v3 cta-banner mx-auto maxw1700 pt120 pb120 position-relative overflow-hidden d-flex align-items-center px30-lg">

            @if (isset($service_banner_attr->image))
                <img class="service-v3-vector desktop_img"
                    src="{{ asset('public/upload/service/banner_attr/' . $service_banner_attr->image) }}"
                    alt="{{ $service_banner_attr->image_alt_tag ?? $service_data->servicename }}" style="width:100%;">

                <img class="service-v3-vector mobile_img"
                    src="{{ asset('public/upload/service/banner_attr/large/' . $service_banner_attr->mobile_banner_image) }}"
                    alt="{{ $service_banner_attr->image_alt_tag ?? $service_data->servicename }}" style="width:100%;">
            @elseif(isset($service_data->image))
                <img class="service-v3-vector desktop_img"
                    src="{{ asset('public/upload/service/large/' . $service_data->image) }}"
                    alt="{{ $service_banner_attr->image_alt_tag ?? $service_data->servicename }}" style="width:100%;">
                <img class="service-v3-vector mobile_img"
                    src="{{ asset('public/upload/service/large/' . $service_data->image) }}"
                    alt="{{ $service_banner_attr->image_alt_tag ?? $service_data->servicename }}" style="width:100%;">
            @else
                <img class="service-v3-vector  d-lg-block"
                    src="{{ asset('public/upload/service/banner/large/Image_Available.jpg') }}"
                    alt="{{ $service_banner_attr->image_alt_tag ?? $service_data->servicename }}" style="width:100%;">
            @endif

            {{-- <div class="row col-lg-12 wow fadeInUp" style="text-align:center;">
                  <div class="col-xl-12"> --}}
            {{-- <div class="position-relative content-title">
                          <h2 class=" banner_title" style="color: #fff;" >{{"$service_banner_attr->title"}}</h2>
                          <div class="align-items-center">
                              <h6 class="mb-0" style="color: #fff;">{{"$service_banner_attr->sub_title"}}
                              </h6>
                          </div>
                      </div> --}}

            <div class="banner-content-center">
                <h2 class="banner_title text-white banner_static_title">{{ $service_banner_attr->title ?? '' }}</h2>
                <h6 class="text-white banner_static_subtitle">
                    {{ $service_banner_attr->short_description ?? '' }}
                </h6>
            </div>

            {{-- </div>
              </div> --}}
        </div>
    </div>
</section>


<!-- Listings All Lists -->
<section class="pt5 pb10">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row align-items-center mb20">
                    <div class="col-md-6">
                        <div class="text-center text-md-start">
                            <p class="text mb-0 mb10-sm popular_service">Popular services
                                available</p>
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
                                                alt="Service filter icon – Vendorscity search filter"> All
                                            Filter</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="pcs_dropdown dark-color pr10 text-center text-md-end"><span>Sort
                                    by</span>
                                <select class="selectpicker show-tick">
                                    <option>Best Selling</option>
                                    <option>Recommended</option>
                                    <option>New Arrivals</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    @foreach ($subservice_data as $subservice)
                        <div class="col-sm-6 col-xl-3 col-6 col-lg-3">
                            <div class="listing-style1">

                                <div class="list-thumb bdrs12">
                                    @if ($subservice->image != '')
                                        @if ($service_data->id == 50 && $subservice->id == 92)
                                            <a
                                                href="{{ route('automobile.listing', ['page_url' => $subservice->page_url]) }}">
                                            @else
                                                {{-- <a
                                                    href="{{ route('front.package_lists', ['city' => session('search_city_name'), 'page_url' => $subservice->page_url]) }}"> --}}
                                                @if ($subservice->is_bookable == 1)
                                                    <a
                                                        href="{{ route('enquiry', ['service_id' => $service_data->id, 'subservice_id' => $subservice->id]) }}">
                                                    @else
                                                        @php
                                                            $category_id = $_GET['category'] ?? '';
                                                        @endphp
                                                        <a
                                                            href="{{ route('booknow', ['service_id' => $service_data->id, 'subservice_id' => $subservice->id] + ($category_id != '' ? ['category' => $category_id] : [])) }}">
                                                @endif
                                        @endif

                                        <img src="{{ asset('public/upload/subservice/' . $subservice->image) }}"
                                            alt="{{ $subservice->image_alt_tag ?? $subservice->subservicename }}"
                                            class="serviceimage_desktop w-100">
                                        <img src="{{ asset('public/upload/subservice/' . $subservice->image) }}"
                                            alt="{{ $subservice->image_alt_tag ?? $subservice->subservicename }}"
                                            class="serviceimage_mobile w-100">
                                        </a>
                                    @else
                                        @if ($service_data->id == 50 && $subservice->id == 92)
                                            <a
                                                href="{{ route('automobile.listing', ['page_url' => $subservice->page_url]) }}">
                                            @else
                                                <a
                                                    href="{{ route('front.package_lists', ['city' => session('search_city_name'), 'page_url' => $subservice->page_url]) }}">
                                        @endif

                                        <img class="w-100"
                                            src="{{ asset('public/upload/service/large/Image_Available.jpg') }}"
                                            alt=""></a>
                                    @endif

                                </div>
                            </div>
                            <div class="list-content">
                                <h5 class="list-title"><a
                                        href="{{ route('front.package_lists', ['city' => session('search_city_name'), 'page_url' => $subservice->page_url]) }}"
                                        style="font-weight:600;">
                                        {{ strlen($subservice->subservicename . ' in ' . $formattedCity) > 32
                                            ? substr($subservice->subservicename . ' in ' . $formattedCity, 0, 32) . '...'
                                            : $subservice->subservicename . ' in ' . $formattedCity }}
                                    </a></h5>
                                @if ($subservice->sort_description != '')
                                    <div class="review-meta d-flex align-items-center">
                                        <p>{!! html_entity_decode($subservice->description) !!}</p>

                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@php
    //$package_attr = DB::table('service_attr')->where('pid', $subservice->serviceid)->get();
@endphp

@if (isset($top_description->description))
    <section class="pt30 pbm0  pb30 pt0-sm ">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 subservice-name">
                    @if (isset($top_description->description))
                        {!! html_entity_decode($top_description->description) !!}
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif
@if (isset($package_attr) && count($package_attr) > 0)
    <section class="pt30 pbm0 pb30 pt0-sm">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 subservice-name">
                    <div class="row mb-5 align-items-center mrgb0">
                        @foreach ($package_attr as $index => $package_attribut)
                            @php
                                $isEven = $index % 2 == 0;
                            @endphp

                            <div
                                class="col-12 d-md-flex align-items-center mb-4 flex-md-row {{ $isEven ? '' : 'flex-md-row-reverse' }}">

                                {{-- ✅ Image always comes first in HTML so mobile sees image → description --}}
                                {{-- <div class="col-12 col-md-5 p-0">
                                    <div class="placeholder rect bg-primary rounded"
                                        style="background: url('{{ asset('public/upload/service/service_attr/large/' . $package_attribut->image) }}');
                                           background-size: cover;
                                           background-position:center;
                                           width: 100%;
                                           height: 300px;">
                                    </div>
                                </div> --}}

                                {{-- ✅ Description second --}}
                                <div class="col-12 col-md-12 p-4 booking_desc">
                                    <h3 class="mb-4 font-weight-bold">{{ $package_attribut->title_addmore }}</h3>
                                    {!! html_entity_decode($package_attribut->description_addmore) !!}
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif



<div class="container mt25">
    <div class="row align-items-center wow fadeInUp">
        <div class="col-lg-9">
            <div class="main-title">
                <h2 class="title">Read Our Verified Reviews</h2>
            </div>
        </div>
    </div>
    <div class="row wow fadeInUp" data-wow-delay="300ms">
        <div class="col-lg-12">

            <div id="review-slider" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        @if (!empty($googleReview))
                            @foreach ($googleReview as $googleReview_data)
                                <li class="splide__slide text-center">
                                    <div
                                        class="freelancer-style1 text-center bdr1 bdrs16 hover-box-shadow review-card-fixed">

                                        <div class="details">
                                            @if ($googleReview_data->name != '')
                                                <h5 class="title mb-1">{{ $googleReview_data->name }}</h5>
                                            @endif

                                            <div class="review">
                                                @if ($googleReview_data->label != '')
                                                    <div class="d-flex review-stars">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $googleReview_data->label)
                                                                <i class="fas fa-star review-color"></i>
                                                            @else
                                                                <i class="far fa-star review-color ms-2"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                @endif
                                            </div>

                                            <hr class="opacity-100 mt20 mb15">
                                            @if ($googleReview_data->description != '')
                                                @php
                                                    $shortDescription = Str::limit($googleReview_data->description, 80);
                                                @endphp

                                                <p class="review-description">“{{ $shortDescription }}”</p>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif

                        <!-- Add more slides as needed -->

                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="container pb10">
    <div class="googlereview ">
        <div class="row align-items-md-center">
            <div class="col-lg-5 wow fadeInUp" data-wow-delay="300ms">
                <h3 class="google-text">Curious about what sets apart?</h3>
                <p>Explore our Google Reviews and discover why customers trust us with home service needs</p>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp" data-wow-delay="300ms">
                <a style="width: 100%;"
                    href="https://www.google.com/search?q=vendorscity+dubai&sca_esv=e472bba1732e8ddb&sca_upv=1&rlz=1C5CHFA_enAE1014AE1015&sxsrf=ADLYWIKMm77ohxWtSjtB2FywHuiQPICeBA%3A1716628559794&ei=T6xRZquOMNCVxc8Ph-eCsAo&ved=0ahUKEwjr8ZHcu6iGAxXQSvEDHYezAKYQ4dUDCBA&uact=5&oq=vendorscity+dubai&gs_lp=Egxnd3Mtd2l6LXNlcnAiEXZlbmRvcnNjaXR5IGR1YmFpMgQQIxgnMggQABgIGA0YHjIIEAAYCBgNGB4yCBAAGAgYDRgeMgsQABiABBiGAxiKBTILEAAYgAQYhgMYigUyCxAAGIAEGIYDGIoFMgsQABiABBiGAxiKBTIIEAAYgAQYogQyCBAAGIAEGKIESMAKUMoEWN8GcAF4AZABAJgB_wGgAcYDqgEFMC4xLjG4AQPIAQD4AQGYAgOgAtMDwgIKEAAYsAMY1gQYR8ICBxAAGIAEGA3CAggQABgFGA0YHsICChAAGAUYDRgeGA-YAwDiAwUSATEgQIgGAZAGCJIHBTEuMC4yoAeUEA&sclient=gws-wiz-serp#lrd=0x4c30ffdf4bf81567:0xaf176b54bfc73c00,1"
                    target="_blank" class="ud-btn btn-thm google-button">Read More Reviews</a>
            </div>
            <div class="col-lg-4 col-6 wow fadeInUp" data-wow-delay="300ms" style="text-align: right;">
                <img class="w100" src="{{ asset('public/site/images/googlereview.png') }}"
                    alt="Graphic representation of Google reviews" style="max-width: 400px;">
            </div>
        </div>
    </div>
</div>
@if (isset($faq) && count($faq) > 0)
    <section class="our-faq pt60">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 m-auto wow fadeInUp" data-wow-delay="300ms">
                    <div class="main-title mb30">
                        <h2 class="title">Have Questions?<br>Get Answers.</h2>
                    </div>
                </div>
            </div>
            <div class="row wow fadeInUp" data-wow-delay="300ms">
                <div class="col-lg-12 mx-auto">
                    <div class="ui-content">
                        <div class="accordion-style1 faq-page mb-4 mb-lg-5">
                            <div class="accordion" id="accordionExample">

                                @php
                                    $i = 0;
                                @endphp

                                @foreach ($faq as $faq_data)
                                    <div class="accordion-item @php if($i == 0){echo 'active';} @endphp">
                                        <h2 class="accordion-header" id="headingOne_{{ $faq_data->id }}">
                                            <button
                                                class="accordion-button @php if($i != 0){echo 'collapsed';} @endphp"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne_{{ $faq_data->id }}"
                                                aria-expanded="true"
                                                aria-controls="collapseOne">{{ $faq_data->question }}</button>
                                        </h2>
                                        <div id="collapseOne_{{ $faq_data->id }}"
                                            class="accordion-collapse collapse @php if($i == 0){echo 'show';} @endphp"
                                            aria-labelledby="headingOne_{{ $faq_data->id }}"
                                            data-parent="#accordionExample">
                                            <div class="accordion-body">{!! html_entity_decode($faq_data->answer) !!}</div>
                                        </div>
                                    </div>

                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endif

@include('front.includes.footer')

<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Splide('#review-slider', {
            type: 'slide',
            perPage: 4,
            gap: '1rem',
            autoplay: false,
            interval: 3000,
            pagination: false,
            arrows: false,
            breakpoints: {
                768: {
                    fixedWidth: '65%', // Each slide takes 80% of container
                    focus: 0, // Start slide aligned left
                    gap: '1rem',
                    arrows: false,
                },
            },
        }).mount();
    });

    document.querySelectorAll('.custom_splide.splide:not(#feature-slider)').forEach(function(splideElement) {

        splideElement.classList.add('custom-splide');
        const splideId = splideElement.id;

        const subserviceCount = parseInt(splideElement.getAttribute('data-subservice-count')) || 0;
        const showArrows = subserviceCount > 5;

        const splideInstance = new Splide('#' + splideId, {
            type: 'slide',
            perPage: 5,
            gap: '1rem',
            autoplay: false,
            interval: 3000,
            pagination: false,
            arrows: showArrows,
            breakpoints: {
                768: {
                    fixedWidth: '34%', // Each slide takes 80% of container
                    focus: 0, // Start slide aligned left
                    gap: '0.5rem',
                    arrows: false,
                },
            },
        });

        splideInstance.mount();

        // Bind custom buttons using ID extracted from splideElement
        const prevButton = document.querySelector('.custom-prev-' + splideId.replace('splide_', ''));
        const nextButton = document.querySelector('.custom-next-' + splideId.replace('splide_', ''));

        if (prevButton && nextButton) {
            prevButton.addEventListener('click', () => splideInstance.go('<'));
            nextButton.addEventListener('click', () => splideInstance.go('>'));
        }
    });
</script>
