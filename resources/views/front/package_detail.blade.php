@include('front.includes.header')



@php

    // echo"<pre>";print_r($package_detail);echo"</pre>";
@endphp

<style type="text/css">
    .package_detail_banner .cta-service-single {

        background-image: inherit;

        background-color: #eee;

    }

    .fa-check-custom-red {

        background-color: red;

        padding: 4px;

        margin-right: 20px;

        color: #fff !important;

        box-sizing: initial;

    }

    [dir] .placeholder.rect {
        padding-bottom: 66.6%;
    }

    [dir] .rounded {
        border-radius: 0.25rem !important;
    }

    [dir] .bg-primary {
        background-color: #01788e !important;
    }

    .placeholder {
        height: auto;
    }

    .placeholder {
        height: 0;
        width: 100%;
    }
	.pd_sec{margin-left: 3%;}
	.pd_sec .ml25{margin-left: 0 !important;}
</style>

<section class="breadcumb-section pt-4 container package_detail_banner">

    <div
        class="cta-service-single cta-banner mx-auto maxw1700 pt120 pt60-sm pb120 pb60-sm bdrs16 position-relative overflow-hidden d-flex align-items-center mx20-lg px30-lg">



        <img class="service-v1-vector d-none d-xl-block"
            src="{{ asset('public/site/images/Packing-Boxes-removebg-preview.png') }}" alt="">

        <div class="container">

            <div class="row wow fadeInUp">

                <div class="col-xl-7 pd_sec">

                    <div class="position-relative">

                        <h2>{{ $package_detail->name }}</h2>

                        <div class="list-meta mt15">

                            <!-- <a class="list-inline-item mb5-sm" href="">

                    <span class="position-relative mr10">

                      <img class="rounded-circle" src="{{-- asset('public/site/images/team/fl-d-1.png') --}}" alt="Freelancer Photo">

                      <span class="online-badge"></span>

                    </span>

                    <span class="fz14">Eleanor Pena</span>

                  </a> -->

                            <p class="mb-0 dark-color fz14 list-inline-item ml25 ml15-sm mb5-sm ml0-xs"><i
                                    class="fas fa-star vam fz10 review-color me-2"></i> 4.82 94 reviews</p>

                            <p class="mb-0 dark-color fz14 list-inline-item ml25 ml15-sm mb5-sm ml0-xs"><i
                                    class="flaticon-file-1 vam fz20 me-2"></i> 500+ Bookings</p>

                            <!-- <p class="mb-0 dark-color fz14 list-inline-item ml25 ml15-sm mb5-sm ml0-xs"><i class="flaticon-website vam fz20 me-2"></i> 902 Views</p> -->

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



<section class="pt10 pb90 pb30-md">

    <div class="container">

        <div class="row wrap">

            <div class="col-lg-8">

                <div class="column">

                    @php

                        $packages_images = DB::table('packages_image')

                            ->where('pid', $package_detail->id)

                            ->orderBy('id', 'DESC')

                            ->get();

                        // echo '<pre>';

                        // print_r($packages_images);

                        // echo '</pre>';

                    @endphp

                    @if ($packages_images != '' && count($packages_images) > 0)

                        <div class="service-single-sldier vam_nav_style slider-1-grid owl-carousel owl-theme mb60">

                            @foreach ($packages_images as $packages_image)
                                <div class="item">

                                    <div class="thumb p50 p30-sm">

                                        <img src="{{ asset('public/upload/packages_slider_img/large/' . $packages_image->image) }}"
                                            alt="" class="w-100">

                                    </div>
                                </div>
                            @endforeach



                            <!-- <div class="item">Bessie Cooper

                  <div class="thumb p50 p30-sm"><img src="{{ asset('public/site/images/listings/service-details-1.jpg') }}" alt="" class="w-100"></div>

                </div>

                <div class="item">

                  <div class="thumb p50 p30-sm"><img src="{{ asset('public/site/images/listings/service-details-1.jpg') }}" alt="" class="w-100"></div>

                </div> -->

                        </div>

                    @endif

                    @php

                        $inave = 1;

                    @endphp

                    @if ($packages_images != '' && count($packages_images) > 0)

                        @foreach ($packages_images as $packages_image)
                            <style>
                                .service-single-sldier button.owl-dot:nth-child({{ $inave }}) {

                                    background-image: url("{{ asset('public/upload/packages_slider_img/small/' . $packages_image->image) }}");

                                }
                            </style>

                            @php

                                $inave++;

                            @endphp
                        @endforeach

                    @endif



                    <div class="service-about">

                        @if ($package_detail->description)
                            <h4>Description</h4>
                            <p class="text mb30">{!! html_entity_decode($package_detail->description) !!}</p>
                        @endif

                        @php
                            $package_attr = DB::table('package_attr')
                                ->where('pid', $package_detail->id)
                                ->get();

                        @endphp
                        @isset($package_attr)
                            <div class="row mb-5 align-items-center">
                                @foreach ($package_attr as $index => $package_attribut)
                                    @if ($index % 2 == 1)
                                        <div class="col-12 col-md-6 px-5 px-md-0 pr-md-0 stack-bottom stack-adjust--right">
                                            <div class="bg-light rounded border p-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 class="mb-4 font-weight-bold">
                                                            {{ $package_attribut->title_addmore }}</h4>
                                                    </div>
                                                    <div class="col-12">{{ $package_attribut->description_addmore }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-5 col-md-6 pl-md-0 stack-top stack-adjust--left">
                                            <div class="placeholder rect bg-primary rounded b-lazy b-loaded"
                                                style="background: url('{{ asset('public/upload/packages/packages_attr/large/' . $package_attribut->image) }}')">
                                            </div>
                                        </div>
                                    @else
                                        <!-- Reverse the order for odd indices -->
                                        <div class="col-12 mb-5 col-md-6 pl-md-0 stack-top stack-adjust--left">
                                            <div class="placeholder rect bg-primary rounded b-lazy b-loaded"
                                                style="background: url('{{ asset('public/upload/packages/packages_attr/large/' . $package_attribut->image) }}')">
                                            </div>
                                        </div>

                                        <div
                                            class="col-12 
                col-md-6 px-5 px-md-0 pr-md-0 stack-bottom stack-adjust--right">
                                            <div class="bg-light rounded border p-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 class="mb-4 font-weight-bold">
                                                            {{ $package_attribut->title_addmore }}</h4>
                                                    </div>
                                                    <div class="col-12">{{ $package_attribut->description_addmore }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        @endisset





                        @php
                            $faq_packages = DB::table('faqs')
                                ->where('packages', $package_detail->id)
                                ->get();

                            // echo '<pre>';
                            // print_r($faq_packages);
                            // echo '</pre>';
                            // exit();

                        @endphp


                        <!-- <h4>Frequently Asked Questions</h4> -->
                        @if (isset($faq_packages) && count($faq_packages) > 0)
                            <hr class="opacity-100 mb60">
                            <div class="accordion-style1 faq-page mb-4 mb-lg-5 mt30">

                                <div class="accordion" id="accordionExample">
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($faq_packages as $faq_data)
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
                            <hr class="opacity-100 mb60">
                        @endif
                        @php
                            $inclusions_packages = DB::table('packages_incluser')

                                ->where('pid', $package_detail->id)
                                ->get();
                            $exclusions_packages = DB::table('packages_excluser')

                                ->where('pid', $package_detail->id)
                                ->get();

                            // echo '<pre>';
                            // print_r($inclusions_packages);
                            // echo '</pre>';
                            // exit();

                        @endphp
                        @if (isset($inclusions_packages) && count($inclusions_packages) > 0)
                            <div class="list-style1 mb-5">

                                <h4>Inclusions</h4>

                                <ul class="">
                                    @foreach ($inclusions_packages as $inclusions_packages_data)
                                        <li class="mb15"><i
                                                class="far fa-check text-thm3 bgc-thm3-light fa-check-custom"></i>{{ $inclusions_packages_data->incluser_name }}
                                        </li>
                                    @endforeach

                                    {{-- <li><i class="far fa-check text-thm3 bgc-thm3-light fa-check-custom"></i>100%

                                    satisfaction guaranteed</li> --}}

                                    {{-- <li><i class="far fa-check text-thm3 bgc-thm3-light fa-check-custom"></i>Same

                                    day delivery</li> --}}

                                </ul>

                            </div>
                        @endif

                        @if (isset($exclusions_packages) && count($exclusions_packages) > 0)
                            <div class="list-style1">

                                <h4>Exclusions</h4>

                                <ul class="">
                                    @foreach ($exclusions_packages as $exclusions_packages_data)
                                        <li class="mb15"><i
                                                class="far fa-times text-thm3 bgc-thm3-light fa-check-custom-red"></i>{{ $exclusions_packages_data->excluser_name }}
                                        </li>
                                    @endforeach

                                    {{-- <li><i class="far fa-times text-thm3 bgc-thm3-light fa-check-custom-red"></i>100%

                                        satisfaction guaranteed</li>

                                    <li><i class="far fa-times text-thm3 bgc-thm3-light fa-check-custom-red"></i>Same

                                        day delivery</li> --}}

                                </ul>

                            </div>
                        @endif



                        <hr class="opacity-100 mb15">

                        {{-- <div class="product_single_content mb50">

                            <div class="mbp_pagination_comments">

                                <div class="row">

                                    <div class="col-lg-12">

                                        <div class="total_review mb30 mt45">

                                            <!-- <h4>80 Reviews</h4> -->

                                        </div>

                                        <div class="d-md-flex align-items-center mb30">

                                            <div
                                                class="total-review-box d-flex align-items-center text-center mb30-sm">

                                                <div class="wrapper mx-auto">

                                                    <div class="t-review mb15">4.96</div>

                                                    <h5>Exceptional</h5>

                                                    <p class="text mb-0">3,014 reviews</p>

                                                </div>

                                            </div>

                                            <div class="wrapper ml60 ml0-sm">

                                                <div class="review-list d-flex align-items-center mb10">

                                                    <div class="list-number">5 Star</div>

                                                    <div class="progress">

                                                        <div class="progress-bar" style="width: 90%;"
                                                            role="progressbar" aria-valuenow="90" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                        </div>

                                                    </div>

                                                    <div class="value text-end">58</div>

                                                </div>

                                                <div class="review-list d-flex align-items-center mb10">

                                                    <div class="list-number">4 Star</div>

                                                    <div class="progress">

                                                        <div class="progress-bar w-75" role="progressbar"
                                                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">

                                                        </div>

                                                    </div>

                                                    <div class="value text-end">20</div>

                                                </div>

                                                <div class="review-list d-flex align-items-center mb10">

                                                    <div class="list-number">3 Star</div>

                                                    <div class="progress">

                                                        <div class="progress-bar w-50" role="progressbar"
                                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">

                                                        </div>

                                                    </div>

                                                    <div class="value text-end">15</div>

                                                </div>

                                                <div class="review-list d-flex align-items-center mb10">

                                                    <div class="list-number">2 Star</div>

                                                    <div class="progress">

                                                        <div class="progress-bar" style="width: 30%;"
                                                            role="progressbar" aria-valuenow="30" aria-valuemin="0"
                                                            aria-valuemax="100"></div>

                                                    </div>

                                                    <div class="value text-end">2</div>

                                                </div>

                                                <div class="review-list d-flex align-items-center mb10">

                                                    <div class="list-number">1 Star</div>

                                                    <div class="progress">

                                                        <div class="progress-bar" style="width: 20%;"
                                                            role="progressbar" aria-valuenow="10" aria-valuemin="0"
                                                            aria-valuemax="100"></div>

                                                    </div>

                                                    <div class="value text-end">1</div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div
                                            class="mbp_first position-relative d-flex align-items-center justify-content-start mb30-sm">

                                            <img src="{{ asset('public/site/images/blog/comments-2.png') }}"
                                                class="mr-3" alt="comments-2.png">

                                            <div class="ml20">

                                                <h6 class="mt-0 mb-0">Bessie Cooper</h6>

                                                <div><span class="fz14">12 March 2022</span></div>

                                            </div>

                                        </div>

                                        <p class="text mt20 mb20">There are many variations of passages of Lorem Ipsum

                                            available, but the majority have suffered alteration in some form, by

                                            injected humour, or randomised words which don't look even slightly

                                            believable. If you are going to use a passage of Lorem Ipsum, you need to be

                                            sure there isn't anything embarrassing hidden in the middle of text.</p>

                                        <div class="review_cansel_btns d-flex">

                                            <a href="#"><i class="fas fa-thumbs-up"></i>Helpful</a>

                                            <a href="#"><i class="fas fa-thumbs-down"></i>Not helpful</a>

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div
                                            class="mbp_first position-relative d-flex align-items-center justify-content-start mt30 mb30-sm">

                                            <img src="{{ asset('public/site/images/blog/comments-2.png') }}"
                                                class="mr-3" alt="comments-2.png">

                                            <div class="ml20">

                                                <h6 class="mt-0 mb-0">Darrell Steward</h6>

                                                <div><span class="fz14">12 March 2022</span></div>

                                            </div>

                                        </div>

                                        <p class="text mt20 mb20">There are many variations of passages of Lorem Ipsum

                                            available, but the majority have suffered alteration in some form, by

                                            injected humour, or randomised words which don't look even slightly

                                            believable. If you are going to use a passage of Lorem Ipsum, you need to be

                                            sure there isn't anything embarrassing hidden in the middle of text.</p>

                                        <div class="review_cansel_btns d-flex pb30">

                                            <a href="#"><i class="fas fa-thumbs-up"></i>Helpful</a>

                                            <a href="#"><i class="fas fa-thumbs-down"></i>Not helpful</a>

                                        </div>

                                    </div>

                                    <!-- <div class="col-md-12">

                <div class="position-relative bdrb1 pb50">

                  <a href="page-service-single.html" class="ud-btn btn-light-thm">See More<i class="fal fa-arrow-right-long"></i></a>

                </div>

              </div> -->

                                </div>

                            </div>

                        </div> --}}

                        {{-- <div class="bsp_reveiw_wrt">

                            <h6 class="fz17">Add a Review</h6>

                            <!-- <p class="text">Your email address will not be published. Required fields are marked *</p> -->

                            <h6>Your ratings for this service</h6>

                            <div class="d-flex">

                                <i class="fas fa-star review-color"></i>

                                <i class="far fa-star review-color ms-2"></i>

                                <i class="far fa-star review-color ms-2"></i>

                                <i class="far fa-star review-color ms-2"></i>

                                <i class="far fa-star review-color ms-2"></i>

                            </div>

                            <form class="comments_form mt30 mb30-md">

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="mb-4">

                                            <label class="fw500 fz16 ff-heading dark-color mb-2">Comment</label>

                                            <textarea class="pt15" rows="6"
                                                placeholder="There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text."></textarea>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="mb20">

                                            <label class="fw500 ff-heading dark-color mb-2">Name</label>

                                            <input type="text" class="form-control" placeholder="Ali Tufan">

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="mb20">

                                            <label class="fw500 ff-heading dark-color mb-2">Email</label>

                                            <input type="email" class="form-control"
                                                placeholder="creativelayers088">

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div
                                            class="checkbox-style1 d-block d-sm-flex align-items-center justify-content-between mb20">

                                            <label class="custom_checkbox fz15 ff-heading">Save my name, email, and

                                                website in this browser for the next time I comment.

                                                <input type="checkbox">

                                                <span class="checkmark"></span>

                                            </label>

                                        </div>

                                        <a href="" class="ud-btn btn-thm">Submit Review</a>

                                    </div>

                                </div>

                            </form>

                        </div> --}}

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="column">

                    <div class="blog-sidebar ms-lg-auto">

                        <div class="price-widget">

                            <div class="navtab-style1">

                                <!-- <nav>

              <div class="nav nav-tabs mb20" id="nav-tab2p" role="tablist">

                

                <button class="nav-link active fw500" id="nav-item2p-tab" data-bs-toggle="tab" data-bs-target="#nav-item2p" type="button" role="tab" aria-controls="nav-item2p" aria-selected="false">Standart</button>

                

              </div>

            </nav> -->

                                @php

                                    $disc_price = $package_detail->price; // Set a default value

                                    if ($package_detail->discount_type != '') {
                                        if ($package_detail->discount_type == 0) {
                                            $disc_price_new =
                                                ($package_detail->price * $package_detail->discount) / 100;

                                            $disc_price = $package_detail->price - $disc_price_new;
                                        } elseif ($package_detail->discount_type == 1) {
                                            $disc_price = $package_detail->price - $package_detail->discount;
                                        } else {
                                            $package_detail->price;
                                        }
                                    } else {
                                        $package_detail->price;
                                    }

                                    $subservices = DB::table('subservices')

                                        ->where('id', $package_detail->subservice_id)

                                        ->first();
                                @endphp

                                <div class="tab-content" id="nav-tabContent">



                                    <div class="tab-pane fade show active" id="nav-item2p" role="tabpanel"
                                        aria-labelledby="nav-item2p-tab">

                                        <div class="price-content">

                                            @if ($package_detail->discount_type != '2')
                                                <div class="price">AED {{ $disc_price }}

                                                    <del>{{ $package_detail->price }}</del>
                                                    @if ($package_detail->discount != '')
                                                        <span class="fz15"
                                                            style="color:red;">{{ $package_detail->discount }}%
                                                            OFF</span>
                                                    @endif

                                                </div>
                                            @else
                                                <div class="price">AED {{ $package_detail->price }}</div>
                                            @endif

                                            <!-- <div class="h5 mb-2">High-converting Landing Pages</div> -->

                                            <p class="text fz14">Moving can be stressful, be it international or

                                                within the Emirates. You can book

                                                professional movers in Dubai in just a few

                                                clicks.</p>

                                            <hr class="opacity-100 mb20">

                                            @php
                                                $others_packages = DB::table('packages_others')

                                                    ->where('pid', $package_detail->id)
                                                    ->get();

                                            @endphp
                                            @if (isset($others_packages) && count($others_packages) > 0)
                                                <div class="list-style1">

                                                    <ul class="">
                                                        @foreach ($others_packages as $others_package)
                                                            <li class="mb15"><i
                                                                    class="far fa-check text-thm3 bgc-thm3-light fa-check-custom"></i>{{ $others_package->others }}
                                                            </li>
                                                        @endforeach

                                                        {{-- <li><i
                                                            class="far fa-check text-thm3 bgc-thm3-light fa-check-custom"></i>100%

                                                        satisfaction guaranteed</li> --}}

                                                        {{-- <li><i
                                                            class="far fa-check text-thm3 bgc-thm3-light fa-check-custom"></i>Same

                                                        day delivery</li> --}}

                                                    </ul>

                                                </div>
                                            @endif

                                            <hr class="opacity-100 mb20">

                                            <div class="d-grid">

                                                @if (in_array('0', explode(',', $subservices->is_bookable)))
                                                    <a class="ud-btn btn-thm mb-2" href="{{ route('cart') }}"
                                                        onclick="add_to_cart('{{ $package_detail->id }}'); return false;">

                                                        <i class="fal fa-arrow-right-long"></i>Book Now!</a>
                                                @endif



                                                {{-- @if (in_array('1', explode(',', $subservices->is_bookable)))
                                                    <a class="ud-btn btn-thm mb-2"
                                                        href="{{ route('enquiry', ['id' => $package_detail->id, 'service_id' => $package_detail->service_id]) }}">

                                                        <!-- Replace $your_service_id with the actual service_id value -->

                                                        <i class="fal fa-arrow-right-long"></i>Get Multiple Quote</a>
                                                @endif --}}

                                            </div>



                                        </div>

                                    </div>



                                </div>

                            </div>

                        </div>



                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



<section class="pb90 pb30-md pt90 ptm0">
    <div class="container">
        <div class="row align-items-center wow fadeInUp" data-wow-delay="00ms">
            <div class="col-lg-6">
                <div class="main-title2">
                    <h2 class="title we_do_heading">Most Popular Services
                    </h2>

                </div>
            </div>
            <div class="col-lg-6">

                <p class="paragraph we_cut_out_paragraph">Get your weekend back, we've got your to-do list
                    covered. Hire our top rated verified vendors for the best
                    in class stress free service and top class prices
                </p>

            </div>
        </div>



        @php
            
            $services = DB::table('subservices')->where('id', '!=', $package_detail->subservice_id)->where('serviceid', $package_detail->service_id)->get();
            // echo '<pre>';
            // print_r($services);
            // echo '</pre>';
            // exit();
        @endphp


        <div class="tab-content ha" id="pills-tabContent">
            <div class="tab-pane fade fz15 text show active" id="pills-home" role="tabpanel"
                aria-labelledby="pills-home-tab">
                <div class="navi_pagi_bottom_center slider-4-grid owl-carousel owl-theme">
                    @foreach ($services as $services_data)
                        <div class="item">
                            <div class="listing-style1">
                                <div class="list-thumb">
                                    <a href="{{ url('package-lists/' . $services_data->page_url) }}">
                                        @if (isset($services_data->image) && $services_data->image != '')
                                            <img class="w-100"
                                                src="{{ asset('public/upload/subservice/large/' . $services_data->image) }}"
                                                alt="">
                                        @else
                                            <img class="w-100"
                                                src="{{ asset('public/upload/subservice/large/1715859524No_Image_Available.jpg') }}"
                                                alt="">
                                        @endif
                                    </a>
                                    {{-- <a href="" class="listing-fav fz12"><span class="far fa-heart"></span></a> --}}
                                </div>
                                <div class="list-content"
                                    style="padding: 35px 15px 20px 15px; background:#eee; !important">

                                    {{-- <div class="review-meta d-flex align-items-center">
                                        <i class="fas fa-star fz10 review-color"></i>
                                        <i class="fas fa-star fz10 review-color"></i>
                                        <i class="fas fa-star fz10 review-color"></i>
                                        <i class="fas fa-star fz10 review-color"></i>

                                    </div> --}}

                                    <div class="list-meta d-flex justify-content-between align-items-center">
                                        <a class="d-flex" href="{{ url('package-lists/' . $services_data->page_url) }}">
                                            <span class="fz14"
                                                style="font-size: 20px;!important">{{ $services_data->subservicename }}</span>
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



<section class="bgc-thm3">

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

                                        <div class="timer">4.9</div>

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

                                        <div class="timer">500</div>

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
                                    <h4 class="title text-thm text_blue">{{$googleReview_data->label}}</h4>
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

                                <h4 class="title text-thm text_blue">Great Service</h4>

                                <span class="icon fas fa-quote-left"></span>

                                <h4 class="t_content">“Extremely professional team with complete

                                    attention to detail. Their staff is very well

                                    trained and were very helpful and prompt.

                                    Thank you VendorsCity.”</h4>

                            </div>

                            <div class="thumb d-flex align-items-center">

                                <div class="flex-shrink-0">

                                    <img class="wa" src="{{ asset('public/site/images/customer1.png') }}"
                                        alt="">

                                </div>

                                <div class="flex-grow-1 ms-3">

                                    <h6 class="mb-0">Fatema Sheikh</h6>

                                   

                                </div>

                            </div>

                        </div>

                    </div>



                    <div class="item">

                        <div class="testimonial-style1 default-box-shadow1 position-relative bdrs16 mb35">

                            <div class="testimonial-content">

                                <h4 class="title text-thm text_blue">Great Service</h4>

                                <span class="icon fas fa-quote-left"></span>

                                <h4 class="t_content">“Extremely professional team with complete

                                    attention to detail. Their staff is very well

                                    trained and were very helpful and prompt.

                                    Thank you VendorsCity.”</h4>

                            </div>

                            <div class="thumb d-flex align-items-center">

                                <div class="flex-shrink-0">

                                    <img class="wa" src="{{ asset('public/site/images/customer1.png') }}"
                                        alt="">

                                </div>

                                <div class="flex-grow-1 ms-3">

                                    <h6 class="mb-0">Devang Patel</h6>

                                   

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


@if(!empty($faq))
<section class="our-faq pb90">

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

                            <!-- <div class="accordion-item active">

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

                            </div> -->

                        </div>

                    </div>

                </div>

            </div>

        </div>



    </div>

</section>
@endif


<section class="our-about bgc-thm2 container pb0 pt0 mb30 mt30">

    <div class="container">

        <div class="row align-items-center custom_marquee">





            <marquee width="100%" direction="left">| 15,000+ Customers | <span class="flaticon-star custom_icon">

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

            </marquee>



        </div>

    </div>

</section>

@include('front.includes.footer')
<script>
    //  Fixed sidebar Custom Script For That 
    $(function() {
        var cols = $('.wrap .column');
        var enabled = true;
        var scrollbalance = new ScrollBalance(cols, {
            minwidth: 1199
        });
        // bind to scroll and resize events
        scrollbalance.bind();
    });
</script>
