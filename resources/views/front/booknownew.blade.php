@include('front.includes.header')


<link rel="stylesheet" href="{{ asset('public/site/css/booknownew.css?v=8') }}">
<link rel="stylesheet" href="{{ asset('public/site/css/homedirham.css?v=8') }}">
<script>
    window.isUserLoggedIn = {{ Session::has('user') ? 'true' : 'false' }};
    window.packageImageBase = "{{ asset('public/upload/packages/large/') }}/";
    window.addonImageBase = "{{ asset('public/upload/addons/') }}/";
</script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .pl {
        padding-left: 20px
    }

    .book-now-web {
        border-radius: 50px !important;
        padding: 7px 40px !important;
        font-size: 0.95rem !important;
        font-weight: 700 !important;
    }

    .currency_dhiram {
        -webkit-mask: url('{{ asset('public/site/icons/dirham.svg') }}') no-repeat center;
        mask: url('{{ asset('public/site/icons/dirham.svg') }}') no-repeat center;
        -webkit-mask-size: contain;
        mask-size: contain;
    }

    .mabrook-saving-banner {
        background: linear-gradient(135deg, rgb(243, 242, 249) 0%, rgb(231, 230, 244) 100%);
        color: #150495;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        padding: 8px 10px;
        width: 100%;
        border-bottom: 1px solid;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: -10px;
        margin-bottom: 10px;
        border-color: rgba(21, 4, 149, 0.3);
    }

    .mabrook-saving-banner .price-wrapper {
        font-weight: 800;
        color: #150495;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 4px;
        position: relative;
        /* top: 1px; */
    }

    .mabrook-saving-banner .currency_dhiramnew {
        position: relative;
        top: 1px;
    }

    @media (max-width: 767px) {

        .mabrook-saving-banner {
            font-size: 14px;
        }

        .mabrook-saving-banner .price-wrapper {
            top: inherit;
        }

        .mabrook-saving-banner .currency_dhiramnew {
            top: 0px;
        }
    }

    @media (min-width: 768px) {
        .mabrook-saving-banner {
            display: none !important;
        }
    }

    .totaltext {
        margin: 0;
        width: 100%;
        display: inline-block;
    }

    .mobile_totalnew .currency_dhiramnew {
        font-weight: 800;
        font-size: 18px !important;
        color: #000;
    }

    .mobile_totalnew .total_to_pay {
        font-weight: 800;
        font-size: 18px !important;
        color: #000;
    }

    /* ── Info popup modals must stack ABOVE mobilesummaryModal ── */
    #mobilesummaryModal {
        z-index: 1060 !important;
    }

    .currency_dhiramnew {
        font-family: 'aed', Arial, sans-serif;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        line-height: 1 !important;
        vertical-align: middle;
    }

    /* Common wrapper */
    .price-wrapper,
    .badgespantime,
    .mobile_price,
    .sm-summary,
    .font-weight-bold.sm-summary.price-wrapper,
    .price-addons,
    .old-price-addons,
    .price-badge {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 4px;
        line-height: 1 !important;
    }

    .addonsinstruction {
        background: linear-gradient(135deg, rgb(243, 242, 249) 0%, rgb(231, 230, 244) 100%);
        border-width: 1.5px;
        border-style: solid;
        border-color: rgba(21, 4, 149, 0.3);
        border-image: initial;
        border-radius: 12px;
        padding: 4px 8px;
        margin: 20px 0px 0px;
    }

    .addonsinstruction h5 {
        font-size: 14px;
        color: #150495;
        line-height: 1.5;
        margin: 0;
        padding: 5px 0;
    }

    .addonsinstruction h5 i {
        font-size: 13px;
    }

    @media only screen and (max-width: 767px) {
        .mobile_totalnew {
            /* display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 10px; */
            width: 100%;
            /* margin: 10px auto; */
            padding: 12px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .book-now-web {
            padding: 7px 30px !important;
        }

        .addonsinstruction h5 {
            font-size: 11px;
        }

        .addonsinstruction h5 i {
            font-size: 11px;
        }
    }

    @media (min-width: 1025px) {
        .mobile_totalnew {
            display: none !important;
        }
    }

    #delivery_charge_popup_{{ $subservice_id }},
    #service_fee_popup_{{ $subservice_id }},
    #timing_fee_popup_{{ $subservice_id }} {
        z-index: 1090 !important;
    }

    /* ── Mobile (≤ 767px) — iOS Bottom Sheet ── */
    @media (max-width: 767px) {
        .subservice-read-more-model.show {
            display: flex !important;
            align-items: flex-end !important;
            padding: 0 !important;
        }

        .subservice-read-more-model .modal-dialog {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            transform: translateY(100%);
            transition: transform 0.32s cubic-bezier(0.32, 0.72, 0, 1) !important;
            will-change: transform;
        }

        .subservice-read-more-model.show .modal-dialog {
            transform: translateY(0) !important;
        }

        .subservice-read-more-model .modal-content {
            border-radius: 20px 20px 0 0 !important;
            border: none !important;
            box-shadow: 0 -6px 32px rgba(0, 0, 0, 0.18) !important;
            height: auto !important;
            max-height: 80dvh !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: visible !important;
            padding-bottom: env(safe-area-inset-bottom, 0px) !important;
        }

        .subservice-read-more-model .modal-drag-handle {
            flex: 0 0 auto !important;
            width: 100%;
            padding: 10px 0 4px;
            text-align: center;
            border-radius: 20px 20px 0 0;
            background: #fff;
        }

        .subservice-read-more-model .modal-header {
            flex: 0 0 auto !important;
            border-bottom: 1px solid #f0f0f0 !important;
            padding: 12px 20px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            background: #fff;
            position: relative;
            z-index: 10;
        }

        .subservice-read-more-model .modal-body {
            flex: 0 0 auto !important;
            min-height: 0 !important;
            max-height: 55dvh !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch !important;
            overscroll-behavior: contain !important;
            overflow-x: hidden !important;
            background: #fff;
        }

        .subservice-read-more-model .modal-footer,
        .subservice-read-more-model .modal-footer-sticky {
            flex: 0 0 auto !important;
            background: #fff;
        }

        .subservice-read-more-model .modal-header button[data-bs-dismiss="modal"] {
            min-width: 44px !important;
            min-height: 44px !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            position: relative !important;
            z-index: 20 !important;
            pointer-events: auto !important;
            -webkit-tap-highlight-color: transparent !important;
        }
    }

    /* ── Tablet (768px +) — centred dialog ── */
    @media (min-width: 768px) {
        .subservice-read-more-model .modal-dialog {
            max-width: 480px;
            margin: 1.75rem auto;
        }

        .subservice-read-more-model .modal-content {
            border-radius: 16px;
            max-height: 80vh;
        }

        .modal-drag-handle {
            display: none !important;
        }
    }

    .modal-footer-sticky {
        position: sticky;
        bottom: 0;
        background: #fff;
        padding: 16px 20px;
        border-top: 1px solid #eee;
        z-index: 10;
    }

    body.modal-open:not(.summary-modal-open) .sticky-footer-btn,
    body.modal-open:not(.summary-modal-open) .mobile_total {
        display: none !important;
    }

    /* Prevent background page scroll while sheet is open */
    body.summary-modal-open {
        overflow: hidden;
        touch-action: none;
    }

    #mobilesummaryModal .modal-summary-sheet {
        margin: 0 !important;
        position: fixed !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        top: auto !important;
        width: 100% !important;
        max-width: 100% !important;
        transform: translateY(100%);
        transition: transform 0.38s cubic-bezier(0.32, 0.72, 0, 1);
        will-change: transform;
        padding-bottom: env(safe-area-inset-bottom, 0px);
    }

    #mobilesummaryModal.show .modal-summary-sheet {
        transform: translateY(0) !important;
    }

    #mobilesummaryModal .modal-content {
        border-radius: 20px 20px 0 0 !important;
        background: #fff !important;
        border: none !important;
        box-shadow: 0 -8px 40px rgba(0, 0, 0, 0.14) !important;
        height: 88vh !important;
        height: 88dvh !important;
        max-height: 88vh !important;
        max-height: 88dvh !important;
        display: flex !important;
        flex-direction: column !important;
        overflow: hidden !important;
        -webkit-overflow-scrolling: auto !important;
    }

    #mobilesummaryModal .modal-drag-handle {
        flex: 0 0 auto !important;
        width: 100%;
    }

    #mobilesummaryModal .modal-sheet-header {
        flex: 0 0 auto !important;
        width: 100%;
        -webkit-tap-highlight-color: transparent;
    }

    #mobilesummaryModal .modal-body {
        flex: 1 1 0% !important;
        min-height: 0 !important;
        max-height: none !important;
        overflow-y: scroll !important;
        -webkit-overflow-scrolling: touch !important;
        overscroll-behavior: contain !important;
        overflow-x: hidden !important;
    }

    #mobilesummaryModal .modal-sheet-footer {
        flex: 0 0 auto !important;
        width: 100%;
        padding-bottom: max(20px, calc(12px + env(safe-area-inset-bottom, 0px))) !important;
    }

    @media (min-width: 768px) {
        #mobilesummaryModal .modal-summary-sheet {
            max-width: 100% !important;
            left: 50% !important;
            right: auto !important;
            transform: translateX(-50%) translateY(100%) !important;
            border-radius: 20px 20px 0 0;
        }

        #mobilesummaryModal.show .modal-summary-sheet {
            transform: translateX(-50%) translateY(0) !important;
        }

        #mobilesummaryModal .modal-content {
            height: 80vh !important;
            height: 80dvh !important;
            max-height: 80vh !important;
        }
    }

    .package-description-popup ul li{
        list-style-type: inherit;
    }
    .package-description-popup p {color: #000000de;}
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

                            <!-- Google Ads Promo Banner was moved inside the package category loop -->

                            <div class="sticky-header" id="stickyHeader">
                                <input type="hidden" id="serviceTitle" value="{{ $subservice_data->subservicename }}">
                                <div class="sticky-header-inner">
                                    {{-- <h3><strong>{{ $subservice_data->subservicename }}</strong></h3> --}}
                                    <div class="category-tabs-wrapper" style="position: relative;">
                                        <button class="carousel-arrow left-arrow" type="button">&#8249;</button>
                                        <button class="carousel-arrow right-arrow" type="button">&#8250;</button>
                                        <div class="category-tabs-packages" id="categoryTabsPackages">
                                            @foreach ($package_cat as $package_cat_data)
                                                <button type="button"
                                                    class="@if ($loop->first) active @endif @if (!empty($package_cat_data->slider_image)) has-image @else no-image @endif"
                                                    data-target="sofa{{ $package_cat_data->id }}">
                                                    @if (!empty($package_cat_data->slider_image))
                                                        <img src="{{ url('public/upload/packagecategory/' . $package_cat_data->slider_image) }}"
                                                            alt="{{ $package_cat_data->name }}"
                                                            class="category-item-image scrolled-category-item-image"
                                                            style="width: 100%; height: 65px; object-fit: cover; border-radius: 8px; margin: 0 auto 5px; display: block;">
                                                        <span
                                                            style="display: block; text-align: center;line-height: normal;">{{ $package_cat_data->name }}</span>
                                                    @else
                                                        <span
                                                            style="display: block; text-align: center;line-height: normal;">{{ $package_cat_data->name }}</span>
                                                    @endif
                                                </button>
                                            @endforeach
                                            {{-- <button data-target="mattress">Mattress</button>
                                        <button data-target="carpet">Carpet</button>
                                        <button data-target="curtain">Curtain</button>
                                        <button data-target="combo">Combos</button>
                                        <button data-target="combo1">Combos1</button>
                                        <button data-target="combo2">Combos2</button>
                                        <button data-target="combo3">Combos3</button>
                                        <button data-target="combo4">Combos4</button>
                                        <button data-target="combo5">Combos5</button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section-packages">
                                {{-- <div class="image">
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
                                            {{ $subservice_data->service_detail_short_description }}
                                        </p>
                                    @endif
                                    <a href="javascript:void(0)" class="custom-arrow" data-bs-toggle="modal"
                                        id="read_more"
                                        data-bs-target="#subservice-read-more-model_{{ $subservice_data->id }}">Read
                                        more </a>
                                </div> --}}
                            </div>

                            @foreach ($package_cat as $package_cat_data)
                                <div id="sofa{{ $package_cat_data->id }}" class="section-packages" style="">
                                    <!-- <div id="sofa{{ $package_cat_data->id }}" class="section-packages"
                                    style="padding-top: 40px;"> -->

                                    @php
                                        $package = DB::table('packages')
                                            ->where('service_id', $service_id)
                                            ->where('subservice_id', $subservice_id)
                                            ->where('packagecategory_id', $package_cat_data->id)
                                            ->where('is_active', 0)
                                            ->orderBy('set_order', 'asc')
                                            ->get()
                                            ->toArray();

                                        //$package =array();

                                        //echo"<pre>";print_r($package);echo"</pre>";

                                    @endphp
                                    <h4 class="packagecatHeading" style="">
                                        {{ $package_cat_data->name }}</h4>
                                    @if ($package_cat_data->image != '')
                                        <img src="{{ url('public/upload/packagecategory/' . $package_cat_data->image) }}"
                                            alt="{{ $package_cat_data->name }}" class="w-100 rounded mb-4 bannerimage"
                                            style="object-fit: cover; max-height: 200px;">
                                    @endif


                                    @if (!empty($package))
                                        <div class="package-list-container">
                                            @if (count($package) > 3)
                                                @php
                                                    $lowest_price = PHP_INT_MAX;
                                                    $lowest_price_image = '';
                                                    foreach ($package as $p_data) {
                                                        $p_price = $p_data->price;
                                                        if (
                                                            !empty($p_data->discount) &&
                                                            isset($p_data->discount_type)
                                                        ) {
                                                            $disc =
                                                                $p_data->discount_type == 0
                                                                    ? ($p_data->discount / 100) * $p_data->price
                                                                    : $p_data->discount;
                                                            $p_price -= $disc;
                                                        }
                                                        if ($p_price < $lowest_price) {
                                                            $lowest_price = $p_price;
                                                            $lowest_price_image = $p_data->image;
                                                        }
                                                    }
                                                @endphp

                                                <div class="grouped-category-card entrance-anim"
                                                    style="cursor: pointer;" data-bs-toggle="modal"
                                                    data-bs-target="#category-modal-{{ $package_cat_data->id }}">
                                                    <div class="grouped-category-header">
                                                        @if (!empty($package_cat_data->slider_image))
                                                            <img src="{{ url('public/upload/packagecategory/' . $package_cat_data->slider_image) }}"
                                                                alt="{{ $package_cat_data->name }}"
                                                                class="grouped-category-img"
                                                                style="background-color: transparent;">
                                                        @elseif ($package_cat_data->image != '')
                                                            <img src="{{ url('public/upload/packagecategory/' . $package_cat_data->image) }}"
                                                                alt="{{ $package_cat_data->name }}"
                                                                class="grouped-category-img">
                                                        @else
                                                            <div class="package-list-no-img"
                                                                style="width:100px; height:100px; border-radius:12px;">
                                                                <i class="fa-solid fa-list"
                                                                    style="font-size:32px; margin-bottom:5px;"></i>
                                                                Options
                                                            </div>
                                                        @endif
                                                        <div class="grouped-category-info">
                                                            <h3 class="grouped-category-title">
                                                                {{ $package_cat_data->name }}</h3>
                                                            <p class="grouped-category-desc">Multiple customized options
                                                                available for your specific needs.</p>
                                                            <div class="options-badge">{{ count($package) }} Options
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="grouped-category-footer">
                                                        <div class="grouped-category-price">
                                                            Starts at <strong class="currency_dhiramnew">AED
                                                                {{ number_format($lowest_price, 2) }}</strong>
                                                        </div>
                                                        <button type="button" class="btn select-options-btn"
                                                            onclick="event.stopPropagation();" data-bs-toggle="modal"
                                                            data-bs-target="#category-modal-{{ $package_cat_data->id }}">Add
                                                            +</button>
                                                    </div>
                                                </div>

                                                <!-- Category Modal -->
                                                <div class="modal fade subservice-read-more-model"
                                                    id="category-modal-{{ $package_cat_data->id }}" tabindex="-1">
                                                    <div
                                                        class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <div class="modal-drag-handle">
                                                                <div
                                                                    style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;">
                                                                </div>
                                                            </div>
                                                            <div class="modal-header bn-modal-header">
                                                                <h5 class="modal-title" style="font-weight: 700;">
                                                                    {{ $package_cat_data->name }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body"
                                                                style="padding: 15px; background: #f9f9f9;">
                                                                <div class="package-list-container"
                                                                    style="margin-top: 0;">
                                                                    @foreach ($package as $package_data)
                                                                        @php
                                                                            $price = $package_data->price;
                                                                            $discount_price = 0;

                                                                            if (
                                                                                !empty($package_data->discount) &&
                                                                                isset($package_data->discount_type)
                                                                            ) {
                                                                                $discount_price =
                                                                                    $package_data->discount_type == 0
                                                                                        ? ($package_data->discount /
                                                                                                100) *
                                                                                            $package_data->price
                                                                                        : $package_data->discount;
                                                                                $price -= $discount_price;
                                                                            }
                                                                        @endphp
                                                                        <div class="package-list-row entrance-anim">
                                                                            @if (!empty($package_data->image))
                                                                                <div class="package-list-img-wrapper">
                                                                                    <img src="{{ asset('public/upload/packages/large/' . $package_data->image) }}"
                                                                                        alt="{{ $package_data->name }}"
                                                                                        class="package-list-img">
                                                                                </div>
                                                                            @else
                                                                                <div class="package-list-no-img">
                                                                                    <span>{{ $loop->iteration }}</span>
                                                                                    Option
                                                                                </div>
                                                                            @endif

                                                                            <div class="package-list-body">
                                                                                <a href="javascript:void(0)"
                                                                                    style="text-decoration: none;"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#package-detail-model_{{ $package_data->id }}">
                                                                                    <h3 class="package-list-title">
                                                                                        {{ $package_data->name }}</h3>
                                                                                </a>
                                                                                <p class="package-list-desc">
                                                                                    {{ $package_data->short_description }}
                                                                                </p>
                                                                                <div class="package-list-price-wrap">
                                                                                    <div class="price price-wrapper">
                                                                                        <span
                                                                                            class="currency_dhiramnew">AED</span>
                                                                                        <span>{{ number_format($price, 2) }}</span>
                                                                                    </div>
                                                                                    @if ($discount_price > 0)
                                                                                        <div
                                                                                            class="old-price price-wrapper">
                                                                                            <span
                                                                                                class="currency_dhiramnew">AED</span>
                                                                                            <span>{{ number_format($package_data->price, 2) }}</span>
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>

                                                                            <div class="package-list-action">
                                                                                <button type="button"
                                                                                    class="addbutton"
                                                                                    data-id="{{ $package_data->id }}"
                                                                                    data-name="{{ $package_data->name }}"
                                                                                    data-price="{{ $price }}"
                                                                                    data-oldprice="{{ $package_data->price }}"
                                                                                    data-image="{{ !empty($package_data->image) ? asset('public/upload/packages/large/' . $package_data->image) : '' }}"
                                                                                    data-service="{{ $service_id }}"
                                                                                    data-subservice_id="{{ $subservice_id }}"
                                                                                    data-type="package">Add +</button>
                                                                                <div class="quantity-control"
                                                                                    data-id="{{ $package_data->id }}"
                                                                                    style="display:none;">
                                                                                    <button class="minus-btn"
                                                                                        type="button"><i
                                                                                            class="fa-solid fa-minus"></i></button>
                                                                                    <span class="quantity">1</span>
                                                                                    <button class="plus-btn"
                                                                                        type="button"><i
                                                                                            class="fa-solid fa-plus"></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                @foreach ($package as $package_data)
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

                                                    <div class="package-list-row entrance-anim">
                                                        @if (!empty($package_data->image))
                                                            <div class="package-list-img-wrapper">
                                                                <img src="{{ asset('public/upload/packages/large/' . $package_data->image) }}"
                                                                    alt="{{ $package_data->name }}"
                                                                    class="package-list-img">
                                                            </div>
                                                        @else
                                                            <div class="package-list-no-img">
                                                                <span>{{ $loop->iteration }}</span>
                                                                Option
                                                            </div>
                                                        @endif

                                                        <div class="package-list-body">
                                                            <a href="javascript:void(0)"
                                                                style="text-decoration: none;" data-bs-toggle="modal"
                                                                id="package_detail"
                                                                data-bs-target="#package-detail-model_{{ $package_data->id }}">
                                                                <h3 class="package-list-title">
                                                                    {{ $package_data->name }}</h3>
                                                            </a>
                                                            <p class="package-list-desc">
                                                                {{ $package_data->short_description }}
                                                            </p>
                                                            <div class="package-list-price-wrap">
                                                                <div class="price price-wrapper">
                                                                    <span class="currency_dhiramnew">AED</span>
                                                                    <span>{{ number_format($price, 2) }}</span>
                                                                </div>
                                                                @if ($discount_price > 0)
                                                                    <div class="old-price price-wrapper">
                                                                        <span class="currency_dhiramnew">AED</span>
                                                                        <span>{{ number_format($package_data->price, 2) }}</span>
                                                                    </div>
                                                                @endif
                                                                <div class="package-list-action">
                                                            <button type="button" class="addbutton"
                                                                data-id="{{ $package_data->id }}"
                                                                data-name="{{ $package_data->name }}"
                                                                data-price="{{ $price }}"
                                                                data-oldprice="{{ $package_data->price }}"
                                                                data-image="{{ !empty($package_data->image) ? asset('public/upload/packages/large/' . $package_data->image) : '' }}"
                                                                data-service="{{ $service_id }}"
                                                                data-subservice_id="{{ $subservice_id }}"
                                                                data-type="package">Add +</button>

                                                            <div class="quantity-control"
                                                                data-id="{{ $package_data->id }}"
                                                                style="display:none;">
                                                                <button class="minus-btn" type="button"><i
                                                                        class="fa-solid fa-minus"></i></button>
                                                                <span class="quantity">1</span>
                                                                <button class="plus-btn" type="button"><i
                                                                        class="fa-solid fa-plus"></i></button>
                                                            </div>
                                                        </div>
                                                            </div>
                                                        </div>

                                                        
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endif

                                </div>
                            @endforeach

                            <!-- Google Ads Promo Banner — Step 1 (Sticky to bottom of content area) -->
                            <div id="step1_promo_banner"
                                style="display:{{ !empty($promo) && empty($session_coupon_applied) ? 'flex' : 'none' }}; ">
                                <span style="font-size:1.5rem; flex-shrink:0; margin-top:2px;">🏷️</span>
                                <span style="font-size:14px; color:#150495; line-height:1.5;">
                                    <strong id="step1_promo_banner_text"
                                        style="font-size:15px; color:#150495; font-weight:800;">{{ !empty($promo) ? strtoupper($promo) : '' }}</strong>
                                    voucher code is ready, please select one or more options from the list to get this
                                    voucher code applied!
                                </span>
                            </div>

                            <div class="step-buttons">
                                <span></span>
                                <div class="sticky-footer-btn" style="display:flex; flex-direction:column;">
                                    <div class="mabrook-saving-banner d-none">
                                        <span>🎉</span> <span class="price-wrapper"><span class="currency_dhiramnew"
                                                style="font-size: 12px;">AED</span><span
                                                class="mabrook-saving-amount">0.00</span></span><span> added to wallet.
                                            Use it on your next service.</span>
                                    </div>
                                    <!-- Removed banner from here to put it inside the main container with position: sticky -->
                                    <div class="row" style="width:100%; margin:0;">
                                        <div class="col-md-8 col-lg-6 col-sm-6 col-8" style="padding-left:0;">
                                            <div class="mobile_totalnew">
                                                <div class="font-weight-bold">
                                                    <span class="totaltext">Total</span>
                                                    <div class="mobile_price price-wrapper">

                                                        <span class="currency_dhiramnew">AED</span>
                                                        <span class="total_to_pay">0.00</span>
                                                        <i style="margin-left: 5px;"
                                                            class="fa-solid fa-angle-up arrow-toggle-mobile"
                                                            id="aerrowicon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-6 col-sm-6 col-4">
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
                                {{-- <h3 class="mb-4" style="font-weight: 700; font-size: 20px;">People also added</h3> --}}

                                <div class="addons-grid">
                                    @foreach ($addons as $addonsData)
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

                                            $addonImage = $addonsData->image;
                                            $addonImagePath = 'public/upload/addons/' . $addonImage;
                                            if (
                                                empty($addonImage) ||
                                                !file_exists(public_path('upload/addons/' . $addonImage))
                                            ) {
                                                if (strpos(strtolower($addonsData->name), 'balcony') !== false) {
                                                    $addonImagePath =
                                                        'public/upload/addons/1760765006-1729680028add-on_balcony-cleaning.webp';
                                                } else {
                                                    $addonImagePath = 'public/upload/addons/1760766270-no-image.png';
                                                }
                                            }
                                        @endphp
                                        <div class="addon-grid-card entrance-anim">
                                            <div class="addon-img-wrapper">
                                                <img src="{{ asset($addonImagePath) }}"
                                                    alt="{{ $addonsData->image_alt_tag ?? $addonsData->name }}"
                                                    class="addon-grid-img addon-clickable" data-bs-toggle="modal"
                                                    data-bs-target="#addons-detail-model_{{ $addonsData->id }}">

                                                @if ($discount_priceaddons > 0)
                                                    <div class="addon-discount-badge price-wrapper">
                                                        @if ($addonsData->discount_type == 0)
                                                            <span>-{{ round($addonsData->discount) }}%</span>
                                                        @else
                                                            <span>SAVE</span>
                                                            <span class="currency_dhiramnew">AED</span>
                                                            <span>{{ round($addonsData->discount) }}</span>
                                                        @endif
                                                    </div>
                                                @endif

                                                <!-- Floating Action Container -->
                                                <div class="addon-action-float">
                                                    <button type="button" class="addons-addbutton addon-float-add"
                                                        data-id="{{ $addonsData->id }}"
                                                        data-name="{{ $addonsData->name }}"
                                                        data-price="{{ $priceaddons }}"
                                                        data-oldprice="{{ $addonsData->price }}"
                                                        data-image="{{ asset($addonImagePath) }}"
                                                        data-service="{{ $service_id }}"
                                                        data-subservice_id="{{ $subservice_id }}" data-type="addons">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>

                                                    <div class="addons-quantity-control addon-float-quantity"
                                                        data-id="{{ $addonsData->id }}" style="display:none;">
                                                        <button class="addons-minus-btn" type="button"><i
                                                                class="fa-solid fa-minus"></i></button>
                                                        <span class="addons-quantity">1</span>
                                                        <button class="addons-plus-btn" type="button"><i
                                                                class="fa-solid fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="addon-grid-body addon-clickable" data-bs-toggle="modal"
                                                data-bs-target="#addons-detail-model_{{ $addonsData->id }}">
                                                <h6 class="addon-grid-title">
                                                    {{ $addonsData->name ?? '' }}
                                                </h6>

                                                <div class="addon-grid-price">
                                                    <span class="price-addons price-wrapper">
                                                        <span class="currency_dhiramnew">AED</span>
                                                        <span>{{ number_format($priceaddons, 0) }}</span>
                                                    </span>
                                                    @if ($discount_priceaddons > 0)
                                                        <span class="old-price-addons price-wrapper">
                                                            <span class="currency_dhiramnew">AED</span>
                                                            <span>{{ number_format($addonsData->price, 0) }}</span>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="addonsinstruction">
                                    <h5 class=""> <i class="fas fa-info-circle tabby-banner-info-icon ms-2"></i>
                                        The duration of the session may change based on your selection.</h5>
                                </div>

                                <div class="step-buttons">
                                    <button class="btn btn-secondary custome-black" type="button"
                                        onclick="prevStep(1)">Back</button>
                                    <div class="sticky-footer-btn">
                                        <div class="mabrook-saving-banner d-none">
                                            <span>🎉</span> <span class="price-wrapper"><span
                                                    class="currency_dhiramnew"
                                                    style="font-size: 12px;">AED</span><span
                                                    class="mabrook-saving-amount">0.00</span></span><span> added to
                                                wallet.
                                                Use it on your next service.</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8 col-lg-6 col-sm-6 col-8">
                                                <div class="mobile_totalnew">
                                                    <div class="font-weight-bold">
                                                        <span class="totaltext">Total</span>
                                                        <div class="mobile_price price-wrapper">

                                                            <span class="currency_dhiramnew">AED</span>
                                                            <span class="total_to_pay">0.00</span>
                                                            <i style="margin-left: 5px;"
                                                                class="fa-solid fa-angle-up arrow-toggle-mobile"
                                                                id="aerrowicon"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-6 col-sm-6 col-4">
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
                            <!-- <h3>Date & Address</h3> -->
                            <div class="booking-step">
                                {{-- <h5 class="form-label fw500 dark-color">When would you like your service?</h5> --}}

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
                                                        <span class="badgespantime">
                                                            <span>+</span>
                                                            <span class="currency_dhiramnew">AED</span>
                                                            <span>{{ $timeslot_service_price }}</span>
                                                        </span>
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
                            @if ($emiratesShow == true)
                                <div class="timeslotinstruction">
                                    <h5><i class="fas fa-info-circle tabby-banner-info-icon ms-2"></i></h5>
                                    <h5 class="">
                                        If your selected time slot is fully booked, our nurse/doctor will contact you to
                                        arrange an alternative appointment.</h5>
                                </div>

                                @if ($subservice_id == 95)
                                    <div class="timeslotinstruction">
                                        <h5><i class="fas fa-info-circle tabby-banner-info-icon ms-2"></i></h5>
                                        <h5 class="">
                                            The turnaround time will be confirmed by the service provider at the time of
                                            sample collection.</h5>
                                    </div>
                                @endif
                            @endif
                            <div class="step-buttons">
                                <button class="btn btn-secondary custome-black" type="button"
                                    onclick="prevStep(2)">Back</button>
                                <div class="sticky-footer-btn">
                                    <div class="mabrook-saving-banner d-none">
                                        <span>🎉</span> <span class="price-wrapper"><span class="currency_dhiramnew"
                                                style="font-size: 12px;">AED</span><span
                                                class="mabrook-saving-amount">0.00</span></span><span> added to wallet.
                                            Use it on your next service.</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 col-lg-6 col-sm-6 col-8">
                                            <div class="mobile_totalnew">
                                                <div class="font-weight-bold">
                                                    <span class="totaltext">Total</span>
                                                    <div class="mobile_price price-wrapper">

                                                        <span class="currency_dhiramnew">AED</span>
                                                        <span class="total_to_pay">0.00</span>
                                                        <i style="margin-left: 5px;"
                                                            class="fa-solid fa-angle-up arrow-toggle-mobile"
                                                            id="aerrowicon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-6 col-sm-6 col-4">
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
                            {{-- <h3>Your Location</h3> --}}
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
                                {{-- <label class="form-label fw500 dark-color " for="country">How often do you need
                                    cleaning?</label> --}}

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
                                {{-- <label class="form-label fw500 dark-color " for="country">How often do you need
                                    cleaning?</label> --}}
                                <input type="text" name="area" id="area" class="form-control"
                                    placeholder="Enter Your Area">
                                <p class="form-error-text" id="area_error" style="color: red; margin-top: 10px;"></p>

                            </div>

                            <div class="form-group mb-3">
                                {{-- <label class="form-label fw500 dark-color " for="country">How often do you need
                                    cleaning?</label> --}}
                                <input type="text" name="building_street_no" id="building_street_no"
                                    class="form-control" placeholder="Enter your building name and/or street">
                                <p class="form-error-text" id="building_street_no_error"
                                    style="color: red; margin-top: 10px;"></p>

                            </div>

                            <div class="form-group mb-3">
                                {{-- <label class="form-label fw500 dark-color " for="country">How often do you need
                                    cleaning?</label> --}}
                                <input type="text" name="apartment_villa_no" id="apartment_villa_no"
                                    class="form-control"
                                    placeholder="Enter your apartment number & floor or villa number">
                                <p class="form-error-text" id="apartment_villa_no_error"
                                    style="color: red; margin-top: 10px;"></p>

                            </div>

                            @if ($emiratesShow == true)
                                <div class="form-group mb-3">
                                    <label class="form-label fw500 dark-color">Document Type</label>
                                    <div class="radio-group">
                                        <input type="radio" id="doc_type_emirates" name="doc_type"
                                            value="emirates" checked>
                                        <label for="doc_type_emirates" style="border-radius: 50px;">Emirates
                                            ID</label>

                                        <input type="radio" id="doc_type_passport" name="doc_type"
                                            value="passport">
                                        <label for="doc_type_passport" style="border-radius: 50px;">Passport
                                            Number</label>
                                    </div>
                                </div>

                                <div class="form-group mb-3" id="emirates_id_container">
                                    <input type="text" name="emirates_id_number" id="emirates_id_number"
                                        class="form-control" placeholder="Enter Your Emirates ID Number">
                                    <p class="form-error-text" id="emirates_id_number_error"
                                        style="color: red; margin-top: 10px;"></p>
                                </div>

                                <div class="form-group mb-3" id="passport_container" style="display: none;">
                                    <input type="text" name="passport_number" id="passport_number"
                                        class="form-control" placeholder="Enter Your Passport Number">
                                    <p class="form-error-text" id="passport_number_error"
                                        style="color: red; margin-top: 10px;"></p>
                                </div>
                            @endif

                            <div class="step-buttons">
                                <button class="btn btn-secondary custome-black" type="button"
                                    onclick="prevStep(3)">Back</button>
                                <div class="sticky-footer-btn">
                                    <div class="mabrook-saving-banner d-none">
                                        <span>🎉</span> <span class="price-wrapper"><span class="currency_dhiramnew"
                                                style="font-size: 12px;">AED</span><span
                                                class="mabrook-saving-amount">0.00</span></span><span> added to wallet.
                                            Use it on your next service.</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 col-lg-6 col-sm-6 col-8">
                                            <div class="mobile_totalnew">
                                                <div class="font-weight-bold">
                                                    <span class="totaltext">Total</span>
                                                    <div class="mobile_price price-wrapper">

                                                        <span class="currency_dhiramnew">AED</span>
                                                        <span class="total_to_pay">0.00</span>
                                                        <i style="margin-left: 5px;"
                                                            class="fa-solid fa-angle-up arrow-toggle-mobile"
                                                            id="aerrowicon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-6 col-sm-6 col-4">
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
                            {{-- <h3>Payment Information</h3> --}}
                            <div class="tabby-promo-box"
                                style="margin-top: 12px; margin-bottom: 8px; padding: 8px 14px; background: #fff; border: 1.5px solid #3DF2A7; border-radius: 10px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 8px rgba(61, 242, 167, 0.1);">
                                <div
                                    style="font-size: 0.8rem; color: #111; display: flex; flex-wrap: wrap; gap: 4px; align-items: center; line-height: 1.2;">
                                    <span style="font-weight: 800;">4 interest-free payments.</span>
                                    <span style="color: #666; font-weight: 600;">No fees, no hidden costs.</span>
                                    <i class="fa-solid fa-circle-info"
                                        style="color: #aaa; cursor: pointer; margin-left: 2px; font-size: 1rem;"
                                        data-bs-toggle="modal" data-bs-target="#tabby_info_popup"></i>
                                </div>
                                <img src="{{ asset('public/site/images/tabby-badge.png') }}"
                                    style="height: 20px; object-fit: contain; margin-left: 8px;">
                            </div>
                            <div class="form-group mb-4 payment-selection-container">
                                <label class="form-label fw500 dark-color"
                                    style="font-size: 1.1rem; margin-bottom: 4px;">How would you like to pay for your
                                    service?</label>
                                <p style="font-size: 13px; color: #666; margin-bottom: 16px;">Please note cancellation
                                    or rescheduling fees may apply for last minute changes.</p>

                                <div class="payment-methods-grid">
                                    <label class="payment-method-card" for="paymet_2">
                                        <input type="radio" id="paymet_2" name="payment_type" value="ONLINE"
                                            checked>
                                        <div class="payment-card-content">
                                            <div class="payment-card-header">
                                                <div class="payment-name">
                                                    <span class="payment-radio-circle"></span>
                                                    Online
                                                </div>
                                                <img src="{{ asset('public/site/images/pay_logo_new.png') }}"
                                                    style="height: 22px; object-fit: contain;">
                                            </div>
                                        </div>
                                    </label>

                                    <label class="payment-method-card" for="paymet_1">
                                        <input type="radio" id="paymet_1" name="payment_type" value="COD">
                                        <div class="payment-card-content">
                                            <div class="payment-card-header">
                                                <div class="payment-name">
                                                    <span class="payment-radio-circle"></span>
                                                    Cash
                                                </div>
                                            </div>
                                            <p class="cash_fee price-wrapper">
                                                <span>+</span>
                                                <span class="currency_dhiramnew">AED</span>
                                                <span>{{ \App\Enums\VC_ChargiesEnum::COD->percentage() }}</span>
                                                <span>Cash handling charges will be applied.</span>
                                            </p>
                                        </div>
                                    </label>

                                    <label class="payment-method-card" for="paymet_3" id="tabby_payment_option">
                                        <input type="radio" id="paymet_3" name="payment_type" value="TABBY">
                                        <div class="payment-card-content">
                                            <div class="payment-card-header">
                                                <div class="payment-name">
                                                    <span class="payment-radio-circle"></span>
                                                    Tabby
                                                </div>
                                                <img src="{{ asset('public/site/images/tabby-badge.png') }}"
                                                    style="height: 18px; object-fit: contain;">
                                            </div>
                                            <div class="cash_fee tabby-helper-text" id="tabby_helper_text"
                                                style="display: none;"></div>
                                        </div>
                                    </label>
                                </div>

                                <p class="form-error-text" id="payment_type_error"
                                    style="color: red; margin-top: 10px;">
                                </p>
                                <div class="">

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

                                            // echo"<pre>";print_r($wallet_plus_amount);echo"</pre>";
                                            // echo"<pre>";print_r($wallet_minus_amount);echo"</pre>";

                                            $wallet_amount = $wallet_plus_amount - $wallet_minus_amount;
                                        } else {
                                            $wallet_amount = 0;
                                        }
                                    @endphp

                                    <div style="margin-top:20px; margin-bottom: 20px;">
                                        <label class="form-label fw500 dark-color" style="margin-bottom:12px;">Redeem
                                            Promo Code or Pay with Wallet Balance</label>


                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <!-- URL Promo Banner State -->
                                                <div id="url_promo_ready_banner"
                                                    style="display:none; background: #e0f7fa; padding: 12px 16px; border-radius: 8px; margin-bottom: 12px; align-items: center; gap: 12px;">
                                                    <i class="fa-solid fa-tag"
                                                        style="color: #00bcd4; font-size: 1.5rem;"></i>
                                                    <span style="font-size: 14px; color: #333;"><strong><span
                                                                id="ready_promo_code_name"></span></strong> voucher
                                                        code is ready, please select one or more options from the list
                                                        to get this voucher code applied!</span>
                                                </div>

                                                <!-- Promo Input State -->
                                                <div class="wallet-card-ui" id="promo_code_input_section"
                                                    style="padding: 12px 16px;">
                                                    <div style="display:flex; align-items:center; gap:12px; flex:1;">
                                                        <div class="wallet-icon-box"
                                                            style="background: rgba(22, 163, 74, 0.08); color: #16a34a;">
                                                            <i class="fa-solid fa-ticket-alt"></i>
                                                        </div>
                                                        <div class="wallet-info" style="flex:1;">
                                                            <div class="wallet-label">Promo Code</div>
                                                            <div class="promo-input-group">
                                                                <input type="text" name="promo_code2"
                                                                    id="promo_code2" class="promo-input-field"
                                                                    placeholder="Enter Promo Code">
                                                                <button type="button" id="promocode"
                                                                    class="promo-apply-btn"
                                                                    onclick="apply_promo(2);">Apply</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Promo Applied State -->
                                                <div class="wallet-card-ui d-none promo_dicount_replace_div"
                                                    style="border-color: #16a34a; background: rgba(22, 163, 74, 0.04); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; padding: 12px 16px;">
                                                    <div
                                                        style="display:flex; align-items:flex-start; gap:12px; flex:1; min-width: 220px;">
                                                        <div class="wallet-icon-box"
                                                            style="color: #16a34a; background: rgba(22, 163, 74, 0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                                                            <i class="fa-solid fa-check-circle"
                                                                style="font-size: 1.2rem;"></i>
                                                        </div>
                                                        <div class="wallet-info"
                                                            style="display: flex; flex-direction: column; gap: 4px; flex: 1;">
                                                            <div class="wallet-label"
                                                                style="color: #16a34a; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0; letter-spacing: 0.5px;">
                                                                Coupon Applied: <span class="promo_code_name"
                                                                    style="font-weight: 800;">ABC</span>
                                                            </div>
                                                            <div class="price-wrapper"
                                                                style="display: flex !important; flex-direction: column !important; align-items: flex-start !important; gap: 4px; width: 100%;">
                                                                <!-- Dynamically updated by JS -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="flex-shrink: 0; margin-left: auto;">
                                                        <button onclick="remove_coupon();" type="button"
                                                            class="wallet_cancel_new"
                                                            style="display: block; background: #fff; border: 1px solid #ddd; padding: 8px 16px; border-radius: 8px; font-weight: 700; color: #333; cursor: pointer; min-width: 80px;">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-12">
                                                @if ($wallet_amount > 0)
                                                    <div class="wallet-card-ui mt10" style="margin-bottom: 12px;">
                                                        <div style="display:flex; align-items:center; gap:12px;">
                                                            <div class="wallet-icon-box">
                                                                <i class="fa-solid fa-wallet"></i>
                                                            </div>
                                                            <div class="wallet-info">
                                                                <div class="wallet-label">Wallet Balance</div>
                                                                <div id="wallet_amount" class="price-wrapper">
                                                                    <span class="currency_dhiramnew"
                                                                        style="
    style=&quot;font-size: 0.95rem; font-weight:700; position:relative;
">AED</span>
                                                                    <span>{{ $wallet_amount }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <button onclick="apply_wallet_discount();" type="button"
                                                                class="wallet_apply_new">Apply</button>
                                                            <button onclick="cancelWalletDiscount();" type="button"
                                                                class="wallet_cancel_new"
                                                                style="display: none;">Cancel</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            @if ($emiratesShow == true)
                                <div class="timeslotinstruction">
                                    <h5><i class="fas fa-info-circle tabby-banner-info-icon ms-2"></i></h5>
                                    <h5 class="">
                                        Dubai Health Authority (DHA) may access electronic medical records, and test
                                        results may be shared where required by law.</h5>
                                </div>
                                <div class="timeslotinstruction">
                                    <h5><i class="fas fa-info-circle tabby-banner-info-icon ms-2"></i></h5>
                                    <h5 class="">
                                        For insurance claim purposes, an invoice and medical report will be provided
                                        after completion of the service.</h5>
                                </div>
                            @endif
                            <div class="step-buttons">
                                <button class="btn btn-secondary custome-black" type="button"
                                    onclick="prevStep()">Back</button>

                                <div class="sticky-footer-btn">
                                    <div class="mabrook-saving-banner d-none">
                                        <span>🎉</span> <span class="price-wrapper"><span class="currency_dhiramnew"
                                                style="font-size: 12px;">AED</span><span
                                                class="mabrook-saving-amount">0.00</span></span><span> added to wallet.
                                            Use it on your next service.</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 col-lg-6 col-sm-6 col-7">
                                            <div class="mobile_totalnew">
                                                <div class="font-weight-bold">
                                                    <span class="totaltext">Total</span>
                                                    <div class="mobile_price price-wrapper">

                                                        <span class="currency_dhiramnew">AED</span>
                                                        <span class="total_to_pay">0.00</span>
                                                        <i style="margin-left: 5px;"
                                                            class="fa-solid fa-angle-up arrow-toggle-mobile"
                                                            id="aerrowicon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-6 col-sm-6 col-5">
                                            <button
                                                class="ud-btn btn-thm default-box-shadow2 order_now custome-black book-now-web"
                                                type="button" disabled id="spinner_button" style="display: none;">
                                                <span class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Loading...</button>
                                            <button type="button"
                                                class="ud-btn btn-thm default-box-shadow2 order_now custome-black book-now-web finalbooknow"
                                                id="nextBtn12" onclick="nextStep()">Book Now </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Step 6: Final Summary -->


                    </div>

                    <input type="hidden" name="service_charge" id="service_charge" value="">
                    <input type="hidden" name="timing_charge" id="timing_charge" value="">
                    <input type="hidden" name="date_charge" id="date_charge" value="">
                    <input type="hidden" name="t_charge" id="t_charge" value="">
                    <input type="hidden" name="sub_total" id="sub_total" value="">
                    <input type="hidden" name="cod_charge" id="cod_charge" value="">
                    <input type="hidden" name="service_fee" id="service_fee" value="0">
                    <input type="hidden" name="total_to_pay" id="total_to_pay" value="">
                    <input type="hidden" name="vat_total" id="vat_total" value="">
                    <input type="hidden" name="date" id="date" value="">
                    <input type="hidden" name="month" id="month" value="">
                    <input type="hidden" name="promo_discount" id="promo_discount" value="">
                    <input type="hidden" name="wallet_reward_amount" id="wallet_reward_amount" value="0">
                    <input type="hidden" name="promo_name" id="promo_name" value="">
                    <input type="hidden" id="wallet_used" name="wallet_used" value="">
                    <input type="hidden" id="wallet_balance" name="wallet_balance" value="{{ $wallet_amount }}">
                </form>
            </div>
            <div class="col-lg-4 col-md-4 sol-sm-12">
                <div class="sidebar sidebar-summary" id="rightSidebar">

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
                                    <span  class="currency_dhiramnew">AED</span>
                                    500
                                </span>
                            </div>
                        </div>
                    </div> --}}
                    <div class="font-weight-bold-summary h5 summarydev pdheading">Payment Details</div>
                    <!-- <div class="d-flex justify-content-between subheadingdev service-charge-div d-none">
                        <div>Service Charges</div>
                        <div class="font-weight-bold sm-summary price-wrapper">
                            <span class="currency_dhiramnew">AED</span>
                            <span class="service_charge">0.00</span>
                        </div>
                    </div> -->
                    {{-- <div class="d-flex justify-content-between promo_dicount_replace_div subheadingdev">
                        <div>Promo Discount</div>
                        <div class="font-weight-bold sm-summary price-wrapper"
                            style="background-color:#FFD312;border-radius: 6px;padding: 0px 5px 0px 5px;">
                            <span>-</span> <span class="currency_dhiramnew">AED</span>
                            <span class="promo_dicount">0.00</span>
                        </div>
                    </div> --}}
                    {{-- <div class="d-flex justify-content-between subheadingdev d-none" style="">
                        <div>Additional Charges</div>
                        <div class="font-weight-bold sm-summary price-wrapper">
                            <span class="currency_dhiramnew">AED</span>
                            <span class="additional_charge">5.00</span>
                        </div>
                    </div> --}}
                    <!-- <div class="d-flex justify-content-between subheadingdev d-none timing-charge-div">
                        <div style="display:flex; align-items:center; gap:5px;">Timing fee
                            @if ($subservice_data->timing_fee_popup != '')
<a data-bs-toggle="modal" data-bs-target="#timing_fee_popup_{{ $subservice_id }}"
                                    style="cursor:pointer; line-height:1;">
                                    <img src="{{ asset('public/site/images/infoicon.svg') }}"
                                        style="height:14px; width:14px; vertical-align:middle;">
                                </a>
@endif
                        </div>
                        <div class="font-weight-bold sm-summary price-wrapper">
                            <span class="currency_dhiramnew">AED</span>
                            <span class="timing_charge"></span>
                        </div>
                    </div> -->
                    <!-- <div class="d-flex justify-content-between subheadingdev d-none cod-charge-div">
                        <div style="display:flex; align-items:center; gap:5px;">Delivery charge
                            @if ($subservice_data->delivery_charge_popup != '')
<a data-bs-toggle="modal"
                                    data-bs-target="#delivery_charge_popup_{{ $subservice_id }}"
                                    style="cursor:pointer; line-height:1;">
                                    <img src="{{ asset('public/site/images/infoicon.svg') }}"
                                        style="height:14px; width:14px; vertical-align:middle;">
                                </a>
@endif
                        </div>
                        <div class="font-weight-bold sm-summary price-wrapper">
                            <span class="currency_dhiramnew">AED</span>
                            <span class="cod_charge"></span>
                        </div>
                    </div> -->

                    <div class="d-flex justify-content-between subheadingdev d-none subtotal-div">
                        <div>Sub Total</div>
                        <div class="font-weight-bold sm-summary price-wrapper">
                            <span class="currency_dhiramnew">AED</span>
                            <span class="sub_total">0.00</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between d-none service-fee-div">
                        <div>Service Fee</div>
                        <div class="font-weight-bold sm-summary price-wrapper">
                            <span class="currency_dhiramnew">AED</span>
                            <span class="service_fee">0.00</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between subheadingdev d-none vat-div">
                        <div>VAT ({{ \App\Enums\VC_ChargiesEnum::VAT_PERCENT->percentage() }}%)</div>
                        <div class="font-weight-bold sm-summary price-wrapper">
                            <span class="currency_dhiramnew">AED</span>
                            <span class="vat_charge">0</span>
                        </div>
                    </div>
                    <div class="subheadingdev">
                        <div class="d-flex justify-content-between subheadingdev d-none promo_dicount_replace_div">
                            <div>Promo Code</div>
                            <a href="javascript:void(0)" onclick="remove_coupon();"><span
                                    class="flaticon-delete"></span>
                            </a>

                            <div class="font-weight-bold sm-summary price-wrapper" style="">
                                <span>-</span> <span class="currency_dhiramnew">AED</span>
                                <span class="promo_code">0.00</span>
                            </div>
                        </div>

                        <div
                            class="d-flex justify-content-between subheadingdev d-none wallet_reward_sidebar_div align-items-center">
                            <div>Wallet Reward</div>
                            <a href="javascript:void(0)" onclick="remove_coupon();"><span
                                    class="flaticon-delete"></span>
                            </a>

                            <div class="font-weight-bold sm-summary subheadingdev price-wrapper"
                                style="color: #16a34a;">
                                + <span class="currency_dhiramnew">AED</span>
                                <span class="wallet_reward_code_amount">0.00</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between subheadingdev d-none promo_dicount_replace_div">
                            <div>Applied Promo Code</div>
                            <div class="font-weight-bold sm-summary">
                                <span class="promo_code_name">ABC</span>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="d-flex justify-content-center mt-2 is-r font-weight-bold-summary">
                        <h5>Total to pay</h5>
                    </div> -->
                    <div class="left-summary-total d-flex align-items-center">
                        <div class="cross_amount_div" style="display: none;">
                            <strong class="price-wrapper">
                                <span class="currency_dhiramnew">AED</span>
                                <span class="cross_amount" style="text-decoration: line-through;">150</span>
                            </strong>
                        </div>
                        <strong>
                            <div class="price-wrapper">
                                <span class="currency_dhiramnew">AED</span>
                                <span class="total_to_pay">0.00</span>
                            </div>
                        </strong>
                    </div>

                    <div class="tabbbyrightsummary">
                        <div class="tabby-promo-box"
                            style="margin-top: 15px; margin-bottom: 10px; padding: 14px 18px; background: #ECFDF5; border: 1px solid #6EE7B7; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 12px rgba(110, 231, 183, 0.15); font-family: 'Inter', sans-serif; transition: all 0.3s ease;">

                            <div
                                style="display: flex; flex-direction: column; justify-content: center;line-height: normal;">
                                <div style="display: flex; align-items: baseline; gap: 4px;">
                                    <span class="price-wrapper" style="color: #111;">
                                        <span class="currency_dhiramnew" style="font-weight: 700; ">AED</span>
                                        <span class="tabby_split_amount" style="font-weight: 800; ">0.00</span>
                                    </span>
                                    <span style="font-size: 0.85rem; color: #4B5563; font-weight: 600;">/month</span>
                                </div>

                                <div
                                    style="font-size: 0.8rem; color: #6B7280; font-weight: 500; display: flex; align-items: center; margin-top: 2px;">
                                    <span class="tabby_split_count">for 4 months</span>
                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                        data-bs-target="#tabby_info_popup"
                                        style="color: #9CA3AF; display: inline-flex; align-items: center; margin-left: 6px; text-decoration: none;">
                                        <i class="fa-regular fa-circle-question"
                                            style="font-size: 13px; transition: color 0.2s ease;"></i>
                                    </a>
                                </div>
                            </div>

                            <img src="{{ asset('public/site/images/tabby-badge.png') }}"
                                style="height: 24px; object-fit: contain; flex-shrink: 0; margin-left: 10px;">
                        </div>
                    </div>


                    {{-- <div class="d-flex justify-content-between">
                        <div>
                            <input type="text" name="promo_code0" id="promo_code0" class="form-control-coupan"
                                placeholder="Enter Promo code">

                        </div>


                        <div>
                            <input type="button" id="promocode" name="promocode" value="Apply"
                                class="ud-btn-apply btn-thm default-box-shadow2" onclick="apply_promo(0);">
                        </div>
                    </div> --}}
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
            <div class="modal-header bn-modal-header">
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

<div class="modal fade" id="mobilesummaryModal" tabindex="-1">
    <div class="modal-dialog modal-summary-sheet"
        style="margin:0; position:fixed; bottom:0; left:0; right:0; width:100%; max-width:100%;">
        <div class="modal-content border-0" style="border-radius:20px 20px 0 0; background:#fff;">

            {{-- ── Drag Handle ── --}}
            <div class="modal-drag-handle" style="padding:10px 0 6px; text-align:center; cursor:grab;">
                <div style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;"></div>
            </div>

            {{-- ── Header ── --}}
            <div class="modal-sheet-header"
                style="display:flex; align-items:center; justify-content:space-between; padding:8px 20px 14px; position:relative;">
                <div>
                    <div
                        style="font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.12em; color:#aaa; margin-bottom:2px;">
                        Summary</div>
                    <h5 style="margin:0; font-size:1.25rem; font-weight:900; color:#000; letter-spacing:-0.02em;">
                        Booking Summary</h5>
                </div>
                <button type="button" data-bs-dismiss="modal"
                    style="width:36px; height:36px; border-radius:50%; border:1.5px solid #e0e0e0; background:#fff; display:flex; align-items:center; justify-content:center; color:#111; font-size:1.1rem; font-weight:700; line-height:1; cursor:pointer; flex-shrink:0; z-index:10;">
                    &times;
                </button>
            </div>

            {{-- ── Scrollable Body ── --}}
            <div class="modal-body sidebar-summary" style="flex:1; overflow-y:auto; padding:0 20px 16px;">

                {{-- ─ Your Service Chip ─ --}}
                <div style="background:#0040E6; border-radius:14px; padding:16px 18px; margin-bottom:16px;">
                    <div
                        style="font-size:0.7rem; font-weight:700; letter-spacing:0.1em; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-bottom:6px;">
                        Your Service</div>
                    <div style="font-size:1rem; font-weight:700; color:#fff;">{{ $subservice_data->subservicename }}
                    </div>
                </div>

                {{-- ─ Added Items (selected packages + addons) ─ --}}
                <div class="summary-addons-section" style="margin-bottom:6px; display:none;">
                    <div
                        style="font-size:0.68rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#bbb; margin-bottom:12px; padding-bottom:6px; border-bottom:1px solid #f0f0f0;">
                        Added Items</div>
                    <div class="sidebar-cart mobile-sidebar-cart" style="margin:0; font-size:0.88rem;"></div>
                </div>

                {{-- ─ Payment Summary Card ─ --}}
                <div style="background:#f8f8f8; border-radius:14px; padding:16px; margin-top:16px;">
                    <div
                        style="font-size:0.7rem; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:#aaa; margin-bottom:12px;">
                        Payment Summary</div>

                    <div class="d-flex justify-content-between py-1 service-charge-div d-none">
                        <span style="font-size:0.85rem; color:#555;">Service Charges</span>
                        <span style="font-size:0.85rem; font-weight:700; color:#111;" class="price-wrapper">
                            <span class="currency_dhiramnew">AED</span><span class="service_charge">0.00</span>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between py-1 d-none timing-charge-div align-items-center">
                        <span style="font-size:0.85rem; color:#555; display:flex; align-items:center; gap:5px;">Timing
                            Fee
                            @if ($subservice_data->timing_fee_popup != '')
                                <a data-bs-toggle="modal" data-bs-target="#timing_fee_popup_{{ $subservice_id }}"
                                    style="cursor:pointer; line-height:1;">
                                    <img src="{{ asset('public/site/images/infoicon.svg') }}"
                                        style="height:14px; width:14px; vertical-align:middle;">
                                </a>
                            @endif
                        </span>
                        <span style="font-size:0.85rem; font-weight:700; color:#111;" class="price-wrapper">
                            <span class="currency_dhiramnew">AED</span><span class="timing_charge"></span>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between py-1 d-none cod-charge-div align-items-center">
                        <span
                            style="font-size:0.85rem; color:#555; display:flex; align-items:center; gap:5px;">Delivery
                            Charge
                            @if ($subservice_data->delivery_charge_popup != '')
                                <a data-bs-toggle="modal"
                                    data-bs-target="#delivery_charge_popup_{{ $subservice_id }}"
                                    style="cursor:pointer; line-height:1;">
                                    <img src="{{ asset('public/site/images/infoicon.svg') }}"
                                        style="height:14px; width:14px; vertical-align:middle;">
                                </a>
                            @endif
                        </span>
                        <span style="font-size:0.85rem; font-weight:700; color:#111;" class="price-wrapper">
                            <span class="currency_dhiramnew">AED</span><span class="cod_charge"></span>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between py-1 d-none service-fee-div align-items-center">
                        <span style="font-size:0.85rem; color:#555; display:flex; align-items:center; gap:5px;">Service
                            Fee
                            @if ($subservice_data->service_fee_popup != '')
                                <a data-bs-toggle="modal" data-bs-target="#service_fee_popup_{{ $subservice_id }}"
                                    style="cursor:pointer; line-height:1;">
                                    <img src="{{ asset('public/site/images/infoicon.svg') }}"
                                        style="height:14px; width:14px; vertical-align:middle;">
                                </a>
                            @endif
                        </span>
                        <span style="font-size:0.85rem; font-weight:700; color:#111;" class="price-wrapper">
                            <span class="currency_dhiramnew">AED</span><span class="service_fee">0.00</span>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between py-1 d-none subtotal-div">
                        <span style="font-size:0.85rem; color:#555;">Sub Total</span>
                        <span style="font-size:0.85rem; font-weight:700; color:#111;" class="price-wrapper">
                            <span class="currency_dhiramnew">AED</span><span class="sub_total">0.00</span>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between py-1 d-none vat-div">
                        <span style="font-size:0.85rem; color:#555;">VAT
                            ({{ \App\Enums\VC_ChargiesEnum::VAT_PERCENT->percentage() }}%)</span>
                        <span style="font-size:0.85rem; font-weight:700; color:#111;" class="price-wrapper">
                            <span class="currency_dhiramnew">AED</span><span class="vat_charge">0</span>
                        </span>
                    </div>

                    {{-- Promo Applied --}}
                    <div class="subheadingdev">
                        <div
                            class="d-flex justify-content-between py-1 align-items-center d-none promo_dicount_replace_div">
                            <span style="font-size:0.85rem; color:#555;">Coupon Discount</span>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="font-size:0.82rem; font-weight:800; color:#16a34a;"
                                    class="price-wrapper">
                                    − <span class="currency_dhiramnew">AED</span><span class="promo_code">0.00</span>
                                </span>
                                <a href="javascript:void(0)" onclick="remove_coupon();"
                                    style="font-size:0.72rem; color:#999; text-decoration:none; background:#eee; padding:2px 8px; border-radius:6px;">Remove</a>
                            </div>
                        </div>
                        <div class="wallet_reward_summary_div d-none">
                            <div class="d-flex justify-content-between py-1 align-items-center">
                                <span style="font-size:0.85rem; color:#555;">Wallet Reward</span>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="font-size:0.82rem; font-weight:800; color:#16a34a;"
                                        class="price-wrapper">
                                        + <span class="currency_dhiramnew">AED</span><span
                                            class="wallet_reward_code_amount">0.00</span>
                                    </span>
                                    <a href="javascript:void(0)" onclick="remove_coupon();"
                                        style="font-size:0.72rem; color:#999; text-decoration:none; background:#eee; padding:2px 8px; border-radius:6px;">Remove</a>
                                </div>
                            </div>
                            <div class="wallet_reward_msg"
                                style="font-size:0.72rem; color:#16a34a; text-align:right; margin-top:-2px; margin-bottom: 5px;">
                                Reward credited after booking completion.
                            </div>
                        </div>
                    </div>

                    {{-- Total Line --}}
                    <div
                        style="margin-top:12px; padding-top:12px; border-top:1.5px dashed #e0e0e0; display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-size:0.9rem; font-weight:700; color:#111;">Total</span>
                        <div class="left-summary-total"
                            style="margin:0 !important; padding:0 !important; background:transparent; border:none; display:flex !important; justify-content:flex-end !important; align-items:center !important; width:auto !important; gap:4px !important; color:#000 !important;">
                            <div class="cross_amount_div" style="display:none; margin-right:8px;">
                                <span style="font-size:0.8rem; color:#ccc; text-decoration:line-through;"
                                    class="price-wrapper">
                                    <span class="currency_dhiramnew" style="color:#ccc !important;">AED</span><span
                                        class="cross_amount"></span>
                                </span>
                            </div>
                            <strong class="price-wrapper">
                                <span class="currency_dhiramnew" style="color:#000 !important;">AED</span>
                                <span class="total_to_pay"
                                    style="font-size:1.4rem; font-weight:900; color:#000;">0.00</span>
                            </strong>
                        </div>
                    </div>
                </div>
                <div class="tabbbyrightsummary">
                    <div class="tabby-promo-box"
                        style="margin-top: 15px; margin-bottom: 10px; padding: 14px 18px; background: #ECFDF5; border: 1px solid #6EE7B7; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 12px rgba(110, 231, 183, 0.15); font-family: 'Inter', sans-serif; transition: all 0.3s ease;">

                        <div style="display: flex; flex-direction: column; justify-content: center;">
                            <div style="display: flex; align-items: baseline; gap: 4px;">
                                <span class="price-wrapper" style="color: #111;">
                                    <span class="currency_dhiramnew"
                                        style="font-size: 0.85rem; font-weight: 700; margin-right: 2px;">AED</span>
                                    <span class="tabby_split_amount"
                                        style="font-weight: 800; font-size: 1.15rem;">0.00</span>
                                </span>
                                <span style="font-size: 0.85rem; color: #4B5563; font-weight: 600;">/month</span>
                            </div>

                            <div
                                style="font-size: 0.8rem; color: #6B7280; font-weight: 500; display: flex; align-items: center; margin-top: 2px;">
                                <span class="tabby_split_count">for 4 months</span> with
                                <a href="javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#tabby_info_popup"
                                    style="color: #9CA3AF; display: inline-flex; align-items: center; margin-left: 6px; text-decoration: none;">
                                    <i class="fa-regular fa-circle-question"
                                        style="font-size: 13px; transition: color 0.2s ease;"></i>
                                </a>
                            </div>
                        </div>

                        <img src="{{ asset('public/site/images/tabby-badge.png') }}"
                            style="height: 24px; object-fit: contain; flex-shrink: 0; margin-left: 10px;">
                    </div>
                </div>

                {{-- ─ Promo Code Input ─ --}}
                <!-- <div id="mobile_promo_container" style="margin-top:14px; display:flex; gap:8px;">
                    <input type="text" name="promo_code1" id="promo_code1" placeholder="Enter promo code"
                        style="flex:1; border:1.5px solid #e5e5e5; border-radius:10px; padding:10px 14px; font-size:0.85rem; color:#111; outline:none;">
                    <button type="button" onclick="apply_promo(1);"
                        style="background:#0040E6; color:#fff; border:none; padding:10px 18px; border-radius:10px; font-weight:700; font-size:0.82rem; white-space:nowrap; letter-spacing:0.02em;">
                        Apply
                    </button>
                </div> -->

                <div style="height:16px;"></div>
            </div>

            {{-- ── Sticky Footer ── --}}
            <div class="modal-sheet-footer"
                style="padding:12px 20px 28px; background:#fff; border-top:1px solid #f0f0f0;">
                <div style="display:flex; align-items:center; justify-content:space-between;">
                    <div>
                        <div
                            style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:#bbb; margin-bottom:3px;">
                            Total to Pay</div>
                        <div style="display:flex; align-items:baseline; gap:4px;">
                            <span style="font-size:0.82rem; color:#888; font-weight:600;">AED</span>
                            <span class="total_to_pay"
                                style="font-size:1.65rem; font-weight:900; color:#000; letter-spacing:-0.03em;">0.00</span>
                        </div>
                    </div>
                    <button type="button" data-bs-dismiss="modal"
                        style="background:transparent; border:none; color:#aaa; font-size:0.8rem; font-weight:600; padding:6px 0; letter-spacing:0.03em; text-decoration:underline; text-underline-offset:3px; cursor:pointer;">
                        Close
                    </button>
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
                    <div class="modal-header bn-modal-header" style="padding: 1rem 1.5rem;">
                        <h5 class="modal-title">{{ $package_data->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body" style="padding: 0;">
                        <!-- Long Content Here -->
                        @if (!empty($package_data->popup_image))
                            <img src="{{ url('public/upload/packages/popupimage/' . $package_data->popup_image) }}"
                                alt="{{ $package_data->image_alt_tag ?? $package_data->name }}" class="img-fluid"
                                style="width: 100%; display: block;">
                        @endif

                        <div style="padding-left: 1.5rem;padding-right: 1.5rem;color: #000000de;">
                            <div class="d-flex justify-content-between align-items-center" style="padding-top: 1rem;">
                                <div class="" style="line-height: normal;margin-bottom: 2%;">
                                    {{ $package_data->short_description }}
                                    <!-- <h5>{{ $package_data->name }}</h5> -->
                                </div>

                            </div>
                            <div class="" style="display: flex;align-items: center;gap: 13px;margin-bottom:2%">
                                <b class="popup-price price-wrapper">
                                        <span class="currency_dhiramnew">AED</span>
                                        <span>{{ $price }}</span>
                                    </b>
                                    @if ($discount_price > 0)
                                        <span class="price-wrapper"
                                            style="text-decoration: line-through; margin-right: 10px; color: #000;">
                                            <span class="currency_dhiramnew">AED</span>
                                            <span>{{ number_format($package_data->price, 2) }}</span>
                                        </span>
                                    @endif
                                </div>
                            <hr style="border: 1px solid #ddd; margin: 20px 0;">
                            <div class="package-description-popup">
                                {!! html_entity_decode($package_data->description) !!}
                            </div>
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
                    <div class="modal-header bn-modal-header">
                        <h5 class="modal-title">{{ $addonsData->name ?? '' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Long Content Here -->
                        {{-- <img src="{{ url('public/upload/packages/popupimage/' . $package_data->popup_image) }}"
                            alt="{{ $package_data->image_alt_tag ?? $package_data->name }}" class="img-fluid"
                            style="width: 100%;"> --}}


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
                            <span class="new-price price-wrapper">
                                <span class="currency_dhiramnew">AED</span>
                                <span>{{ number_format($priceaddons, 2) }}</span>
                            </span>
                            @if ($discount_priceaddons > 0)
                                <span class="old-price price-wrapper">
                                    <span class="currency_dhiramnew">AED</span>
                                    <span>{{ number_format($addonsData->price, 2) }}</span>
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
            <div class="modal-header details-header bn-modal-header">
                <h5 class="modal-title w-100" id="modalStepTitle">Log in or Sign Up</h5>
            </div>

            <div class="modal-body">
                <div id="booknow_refresh_otp_div">
                    <input type="hidden" name="book_session_otp" id="book_session_otp"
                        value="{{ session('book-login-otp') }}">
                </div>
                <form class="form-horizontal details-form" id="BookOtpForm" method="POST"
                    action="{{ route('booknow-user-otp-login') }}">

                    <input type="hidden" name="redirectUrl" value="{{ $redirectUrl }}">
                    <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
                    <input type="hidden" name="subservice_id" id="subservice_id"
                        value="{{ $subservice_id }}">

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
                            <input type="tel" maxlength="1"
                                class="booknow-otp-input form-control text-center" style="width: 40px;">
                            <input type="tel" maxlength="1"
                                class="booknow-otp-input form-control text-center" style="width: 40px;">
                            <input type="tel" maxlength="1"
                                class="booknow-otp-input form-control text-center" style="width: 40px;">
                            <input type="tel" maxlength="1"
                                class="booknow-otp-input form-control text-center" style="width: 40px;">
                            <input type="tel" maxlength="1"
                                class="booknow-otp-input form-control text-center" style="width: 40px;">
                            <input type="tel" maxlength="1"
                                class="booknow-otp-input form-control text-center" style="width: 40px;">
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
            <div class="modal-header details-header bn-modal-header">
                <h5 class="modal-title w-100" id="booknow_email_modalStepTitle">Log in or Sign Up</h5>
            </div>

            <div class="modal-body">
                <div id="book_email_refresh_otp_div">
                    <input type="hidden" name="book_email_session_otp" id="book_email_session_otp"
                        value="{{ session('book-email-login-otp') }}">
                </div>
                <form class="form-horizontal details-form" id="bookemailOtpForm" method="POST"
                    action="{{ route('home.book-email-otp-login') }}">
                    <input type="hidden" name="redirectUrl" value="{{ $redirectUrl }}">
                    <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
                    <input type="hidden" name="subservice_id" id="subservice_id"
                        value="{{ $subservice_id }}">

                    <input type="hidden" name="country_code_book_popup_Modal_book"
                        id="country_code_book_popup_Modal_book" value="">
                    @csrf


                    <!-- STEP 1: Mobile Input -->
                    <div id="book-email-step-phone">
                        <div class="form-group mb-2">
                            <label id="mobilename-label">Please Enter Your Email Address</label>
                            <input type="text" class="input-field" name="book_email_email"
                                id="book_email_email" placeholder="Email Address">
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

            <div class="modal-header bn-modal-header">
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
            <div class="modal-header bn-modal-header">
                <h5 class="modal-title" id="feeModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="feeModalContent"></div>
        </div>
    </div>
</div>

<!--- Fee Popup End ---->

<!--- Tabby Info Popup Start ---->
<div class="modal subservice-read-more-model" id="tabby_info_popup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #f5f7f9; border: none; border-radius: 20px 20px 0 0;">
            <div class="modal-drag-handle" style="padding:10px 0 4px; text-align:center;">
                <div style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;"></div>
            </div>
            <div class="modal-header bn-modal-header"
                style="border-bottom:none; padding:10px 20px 10px 20px; display:flex; align-items:center; justify-content:space-between;">
                <img src="{{ asset('public/site/images/tabby-badge.png') }}" style="height: 28px;">
                <button type="button" data-bs-dismiss="modal" aria-label="Close"
                    style="background: transparent; border:none; font-size:1.8rem; line-height:1; color:#333; cursor:pointer; -webkit-tap-highlight-color:transparent;">
                    &times;
                </button>
            </div>
            <div class="modal-body tabby-modal-body"
                style="padding:15px 20px; overflow-y:auto; -webkit-overflow-scrolling:touch; max-height:80vh;">

                <!-- Hero Section -->
                <div
                    style="background: linear-gradient(135deg, #4c2278 0%, #2f1754 100%); border-radius: 16px; padding: 30px 20px; color: #fff; margin-bottom: 16px; position: relative; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <div style="position: relative; z-index: 2;">
                        <h3
                            style="font-size: 1.6rem; font-weight: 800; margin-bottom: 8px; color:#fff; letter-spacing: -0.02em;">
                            Get more time to pay</h3>
                        <p style="font-size: 0.95rem; font-weight: 500; margin-bottom: 0; opacity: 0.9;">Split your
                            purchase in up to 12 payments</p>
                    </div>
                </div>

                <!-- Dynamic Cards Container -->
                <div id="tabby_dynamic_cards_container">
                    <!-- Cards will be injected here via AJAX based exactly on what Tabby returns -->
                </div>

                <!-- How it works -->
                <div
                    style="background: #fff; border-radius: 16px; padding: 20px 16px; margin-bottom: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                    <h5 style="font-weight: 800; color: #111; margin-bottom: 20px; font-size: 1.2rem;">How it works
                    </h5>

                    <div style="display:flex; margin-bottom: 16px;">
                        <div
                            style="width: 24px; height: 24px; border-radius: 50%; background: #f0f2f5; color: #111; display:flex; align-items:center; justify-content:center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0; margin-right: 12px; margin-top:2px;">
                            1</div>
                        <div style="font-size: 0.95rem; color: #333; font-weight: 500; line-height: 1.5;">Choose Tabby
                            at checkout to select a payment plan</div>
                    </div>
                    <div style="display:flex; margin-bottom: 16px;">
                        <div
                            style="width: 24px; height: 24px; border-radius: 50%; background: #f0f2f5; color: #111; display:flex; align-items:center; justify-content:center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0; margin-right: 12px; margin-top:2px;">
                            2</div>
                        <div style="font-size: 0.95rem; color: #333; font-weight: 500; line-height: 1.5;">Enter your
                            information and add your debit or credit card</div>
                    </div>
                    <div style="display:flex; margin-bottom: 16px;">
                        <div
                            style="width: 24px; height: 24px; border-radius: 50%; background: #f0f2f5; color: #111; display:flex; align-items:center; justify-content:center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0; margin-right: 12px; margin-top:2px;">
                            3</div>
                        <div style="font-size: 0.95rem; color: #333; font-weight: 500; line-height: 1.5;">Depending on
                            your plan, you may or may not make a down payment</div>
                    </div>
                    <div style="display:flex;">
                        <div
                            style="width: 24px; height: 24px; border-radius: 50%; background: #f0f2f5; color: #111; display:flex; align-items:center; justify-content:center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0; margin-right: 12px; margin-top:2px;">
                            4</div>
                        <div style="font-size: 0.95rem; color: #333; font-weight: 500; line-height: 1.5;">We'll send
                            you
                            a reminder when your next payment is due</div>
                    </div>
                </div>

                <!-- Trusted By -->
                <div
                    style="background: #fff; border-radius: 16px; padding: 16px; margin-bottom: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display: flex; align-items: flex-start; gap: 12px;">
                    <div
                        style="width: 40px; height: 40px; border-radius: 50%; background: #e6efff; color: #0040E6; display:flex; align-items:center; justify-content:center; flex-shrink: 0; font-size: 1.1rem;">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <div style="font-weight: 800; color: #111; font-size: 0.95rem; margin-bottom: 4px;">Trusted by
                            millions</div>
                        <div style="font-size: 0.85rem; color: #666; line-height: 1.4;">Over 20 million shoppers
                            discover products and pay their way with Tabby</div>
                    </div>
                </div>

                <!-- Shop safely -->
                <div
                    style="background: #fff; border-radius: 16px; padding: 16px; margin-bottom: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display: flex; align-items: flex-start; gap: 12px;">
                    <div
                        style="width: 40px; height: 40px; border-radius: 50%; background: #e6efff; color: #0040E6; display:flex; align-items:center; justify-content:center; flex-shrink: 0; font-size: 1.1rem;">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                    <div>
                        <div style="font-weight: 800; color: #111; font-size: 0.95rem; margin-bottom: 4px;">Shop
                            safely
                            with Tabby</div>
                        <div style="font-size: 0.85rem; color: #666; line-height: 1.4;">Buyer protection is included
                            with every purchase</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!--- Delivery Charge Popup Start ---->
@if ($subservice_data->delivery_charge_popup != '')
    <div class="modal subservice-read-more-model" id="delivery_charge_popup_{{ $subservice_id }}" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-drag-handle" style="padding:10px 0 4px; text-align:center;">
                    <div style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;"></div>
                </div>
                <div class="modal-header bn-modal-header"
                    style="border-bottom:1px solid #f0f0f0; padding:12px 20px; display:flex; align-items:center; justify-content:space-between;">
                    <h5 style="margin:0; font-size:1rem; font-weight:800; color:#111;">Delivery Charge</h5>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close"
                        style="background:#f0f0f0; border:none; min-width:44px; min-height:44px; width:44px; height:44px; border-radius:50%; font-size:1.3rem; line-height:1; color:#333; cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0; -webkit-tap-highlight-color:transparent;">
                        &times;
                    </button>
                </div>
                <div class="modal-body"
                    style="padding:20px; overflow-y:auto; -webkit-overflow-scrolling:touch; max-height:60vh;">
                    <p style="color:#444; line-height:1.7; font-size:0.95rem; margin:0;">
                        {{ $subservice_data->delivery_charge_popup }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif
<!--- Delivery Charge Popup End ---->

<!--- Timing Fee Popup Start ---->
@if ($subservice_data->timing_fee_popup != '')
    <div class="modal subservice-read-more-model" id="timing_fee_popup_{{ $subservice_id }}" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-drag-handle" style="padding:10px 0 4px; text-align:center;">
                    <div style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;"></div>
                </div>
                <div class="modal-header bn-modal-header"
                    style="border-bottom:1px solid #f0f0f0; padding:12px 20px; display:flex; align-items:center; justify-content:space-between;">
                    <h5 style="margin:0; font-size:1rem; font-weight:800; color:#111;">Timing Fee</h5>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close"
                        style="background:#f4f4f4; border:none; width:32px; height:32px; border-radius:50%; font-size:1.1rem; color:#555; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                        &times;
                    </button>
                </div>
                <div class="modal-body" style="padding:20px; overflow-y:scroll; -webkit-overflow-scrolling:touch;">
                    <p style="color:#444; line-height:1.7; font-size:0.95rem; margin:0;">
                        {{ $subservice_data->timing_fee_popup }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif
<!--- Timing Fee Popup End ---->

@php
    $subservice_service_fee_popup = DB::table('subservices')->where('id', $subservice_id)->first();
@endphp

<!--- Service Fee Popup Start ---->
@if ($subservice_service_fee_popup && $subservice_service_fee_popup->service_fee_popup != '')
    <div class="modal subservice-read-more-model" id="service_fee_popup_{{ $subservice_id }}" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-drag-handle" style="padding:10px 0 4px; text-align:center;">
                    <div style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;"></div>
                </div>
                <div class="modal-header bn-modal-header"
                    style="border-bottom:1px solid #f0f0f0; padding:12px 20px; display:flex; align-items:center; justify-content:space-between;">
                    <h5 style="margin:0; font-size:1rem; font-weight:800; color:#111;">Service Fee</h5>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close"
                        style="background:#f0f0f0; border:none; min-width:44px; min-height:44px; width:44px; height:44px; border-radius:50%; font-size:1.3rem; line-height:1; color:#333; cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0; -webkit-tap-highlight-color:transparent;">
                        &times;
                    </button>
                </div>
                <div class="modal-body"
                    style="padding:20px; overflow-y:auto; -webkit-overflow-scrolling:touch; max-height:60vh;">
                    <p style="color:#444; line-height:1.7; font-size:0.95rem; margin:0;">
                        {{ $subservice_service_fee_popup->service_fee_popup }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif
<!--- Service Fee Popup End ---->

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
    var emiratesShow = <?= isset($emiratesShow) && $emiratesShow ? 'true' : 'false' ?>;
</script>
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

        $(document).on('change', "input[name='doc_type']", function() {
            let val = $(this).val();
            if (val === 'emirates') {
                $('#emirates_id_container').show();
                $('#passport_container').hide();
                $('#passport_number').val('');
            } else {
                $('#emirates_id_container').hide();
                $('#passport_container').show();
                $('#emirates_id_number').val('');
            }
        });

        // Toggle sticky step footer and manage background scroll lock when modals are shown/hidden
        $(document).on('show.bs.modal', '.modal', function() {
            let modal = $(this);
            if (modal.attr('id') === 'mobilesummaryModal') {
                $('body').addClass('summary-modal-open');
            } else {
                $(".sticky-footer-btn").addClass("d-none").hide();
            }

            // Sync add-on quantities in the detail modal
            if (modal.hasClass('subservice-read-more-model')) {
                let id = modal.find('.addons-addbutton').data('id');
                if (id) {
                    id = id.toString();
                    if (cart[id] && cart[id].type === 'addons') {
                        modal.find('.addons-addbutton').hide();
                        modal.find('.addons-quantity-control').css('display', 'flex').show();
                        modal.find('.addons-quantity').text(cart[id].qty);
                    } else {
                        modal.find('.addons-addbutton').show();
                        modal.find('.addons-quantity-control').hide();
                    }
                }
            }
        });

        $(document).on('hidden.bs.modal', '.modal', function() {
            let modal = $(this);
            if (modal.attr('id') === 'mobilesummaryModal') {
                $('body').removeClass('summary-modal-open');
            } else {
                $(".sticky-footer-btn").removeClass("d-none").show();
            }
        });
    });


    let cart = {}; // unified cart for packages + addons

    $(document).ready(function() {

        const currentSubserviceId = $("#subservice_id").val();
        if (currentSubserviceId) {
            const lastServiceId = localStorage.getItem('lastServiceId');
            if (lastServiceId && lastServiceId !== currentSubserviceId) {
                localStorage.removeItem('currentStep');
            }
            localStorage.setItem('lastServiceId', currentSubserviceId);
        }

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
            let oldprice = parseFloat($(this).data("oldprice")) || price;
            let image = $(this).data("image") || '';
            let service = $(this).data("service");
            let subservice_id = $(this).data("subservice_id");
            let type = $(this).data("type");


            $(this).hide();
            let qtyDiv = $(".quantity-control[data-id='" + id + "']");
            qtyDiv.show();

            if (!cart[id]) cart[id] = {
                name,
                price,
                oldprice,
                image,
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
            let oldprice = parseFloat($(this).data("oldprice")) || price;
            let image = $(this).data("image") || '';
            let service = $(this).data("service");
            let subservice_id = $(this).data("subservice_id");
            let type = $(this).data("type");

            $(this).hide();
            let qtyDiv = $(".addons-quantity-control[data-id='" + id + "']");
            qtyDiv.show();

            if (!cart[id]) cart[id] = {
                name,
                price,
                oldprice,
                image,
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
                $(".quantity-control[data-id='" + id + "']").hide().find(".quantity").text(1);
                $(".addbutton[data-id='" + id + "']").show();
            } else {
                $(".quantity-control[data-id='" + id + "']").find(".quantity").text(cart[id].qty);
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
                $(".addons-quantity-control[data-id='" + id + "']").hide().find(".addons-quantity")
                    .text(1);
                $(".addons-addbutton[data-id='" + id + "']").show();
            } else {
                $(".addons-quantity-control[data-id='" + id + "']").find(".addons-quantity").text(cart[
                    id].qty);
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

        let mobileHtml = "";

        Object.keys(cart).forEach(id => {
            let item = cart[id];
            // Parse to numbers – values may arrive as strings from PHP session/AJAX
            let price = parseFloat(item.price) || 0;
            let oldprice = parseFloat(item.oldprice) || price;
            let qty = parseInt(item.qty) || 1;
            let subtotal = price * qty;
            total += subtotal;

            let rowHtml = `
            <div class="d-flex justify-content-between cart-row">
                <div>${item.name} x ${qty}
                    <!--<a href="javascript:void(0)" class="remove-item" data-id="${id}">
                        <span class="flaticon-delete"></span>
                    </a>-->
                </div>
                <div class="font-weight-bold  price-wrapper">
                    <span class="currency_dhiramnew">AED</span>
                    <span>${subtotal.toFixed(2)}</span>
                </div>
            </div>
        `;

            // Desktop sidebar: show all items (packages + addons)
            html += rowHtml;

            // Resolve item image if defined directly or in session options
            let itemImage = item.image;
            if (!itemImage && item.options && item.options.image) {
                if (item.type === 'package') {
                    itemImage = window.packageImageBase + item.options.image;
                } else if (item.type === 'addons') {
                    let imgName = item.options.image;
                    let existingAddonImages = [
                        "1760765006-1729680028add-on_balcony-cleaning.webp",
                        "1760765007-1729680028add-on_balcony-cleaning.webp",
                        "1763535953-17169873491715862175cushion_500x500-thumbnail.webp",
                        "1763536607-1739002763173893766817168178411715332477dining_chairs_500x500-thumbnail.webp",
                        "1763536681-17169868751715862144pillow_500x500-thumbnail(1).webp",
                        "1763536760-17169880161715861034headboard_500x500-thumbnail.webp",
                        "1763536860-1739003713173894280917169798391715595647baby_500x500-thumbnail.webp"
                    ];
                    if (existingAddonImages.includes(imgName)) {
                        itemImage = window.addonImageBase + imgName;
                    } else {
                        let nameLower = (item.name || "").toLowerCase();
                        if (nameLower.indexOf("balcony") !== -1) {
                            itemImage = window.addonImageBase +
                                "1760765006-1729680028add-on_balcony-cleaning.webp";
                        } else {
                            itemImage = window.addonImageBase + "1760766270-no-image.png";
                        }
                    }
                }
            }

            // Mobile modal: render as premium image-card (same design as addon row)
            let imgHtml = itemImage ?
                `<div style="width:48px;height:48px;border-radius:10px;overflow:hidden;flex-shrink:0;background:#f5f5f5;">
                       <img src="${itemImage}" alt="${item.name}" style="width:100%;height:100%;object-fit:cover;">
                   </div>` :
                `<div style="width:48px;height:48px;border-radius:10px;background:#f0f0f0;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                       <i class="fa-solid fa-box" style="color:#bbb;font-size:1.2rem;"></i>
                   </div>`;

            let oldPriceHtml = (oldprice > price) ?
                `<span class="price-wrapper" style="text-decoration:line-through;color:#ccc;margin-left:5px;font-size:0.78rem;">
                       <span class="currency_dhiramnew">AED</span>${oldprice.toFixed(0)}
                   </span>` :
                '';

            let controlsHtml = '';
            if (item.type === 'package') {
                controlsHtml = `
                    <div class="quantity-control" data-id="${id}"
                        style="display:flex; align-items:center; gap:0; background:#f5f5f5; border-radius:8px; overflow:hidden; height:32px;">
                        <button class="minus-btn" type="button"
                            style="background:transparent; border:none; width:34px; height:32px; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#000; font-size:0.9rem;">
                            <i class="fa-solid fa-minus" style="font-size:0.65rem;"></i>
                        </button>
                        <span class="quantity"
                            style="font-weight:800; font-size:0.95rem; min-width:22px; text-align:center; color:#000; line-height:32px;">${qty}</span>
                        <button class="plus-btn" type="button"
                            style="background:#0040E6; border:none; width:34px; height:32px; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#fff;">
                            <i class="fa-solid fa-plus" style="font-size:0.65rem;"></i>
                        </button>
                    </div>
                `;
            } else {
                controlsHtml = `
                    <div class="addons-quantity-control" data-id="${id}"
                        style="display:flex; align-items:center; gap:0; background:#f5f5f5; border-radius:8px; overflow:hidden; height:32px;">
                        <button class="addons-minus-btn" type="button"
                            style="background:transparent; border:none; width:34px; height:32px; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#000; font-size:0.9rem;">
                            <i class="fa-solid fa-minus" style="font-size:0.65rem;"></i>
                        </button>
                        <span class="addons-quantity"
                            style="font-weight:800; font-size:0.95rem; min-width:22px; text-align:center; color:#000; line-height:32px;">${qty}</span>
                        <button class="addons-plus-btn" type="button"
                            style="background:#0040E6; border:none; width:34px; height:32px; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#fff;">
                            <i class="fa-solid fa-plus" style="font-size:0.65rem;"></i>
                        </button>
                    </div>
                `;
            }

            let mobileCardHtml = `
            <div class="summary-addon-row" style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid #f8f8f8;">
                <div style="display:flex;align-items:center;gap:12px;flex:1;min-width:0;">
                    ${imgHtml}
                    <div style="min-width:0;">
                        <div style="font-size:0.88rem;font-weight:700;color:#111;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${item.name}</div>
                        <div style="font-size:0.82rem;color:#777;margin-top:2px;">
                            <span class="price-wrapper" style="font-weight:800;color:#111;font-size:0.9rem;">
                                <span class="currency_dhiramnew">AED</span>${price.toFixed(0)}
                            </span>
                            ${oldPriceHtml}
                        </div>
                    </div>
                </div>
                <div style="flex-shrink:0;margin-left:10px;">
                    ${controlsHtml}
                </div>
            </div>
            `;
            mobileHtml += mobileCardHtml;
        });

        // Desktop right sidebar
        $(".sidebar-cart:not(.mobile-sidebar-cart)").html(html);

        // Mobile summary modal — no duplicate addon text rows
        $(".mobile-sidebar-cart").html(mobileHtml);

        // Show/hide the summary-addons-section depending on if there are items in cart
        if (Object.keys(cart).length > 0) {
            $(".summary-addons-section").show();
        } else {
            $(".summary-addons-section").hide();
        }


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

        // Sync Step 1 promo banner visibility with current live cart total
        if (typeof window.updateCartPromoVisibility === 'function') {
            window.updateCartPromoVisibility(total); // pass raw package total directly
        }

    }

    function checkapplyPromo(baseTotal) {

        $.get("{{ route('package.get_coupon') }}", function(couponData) {
            if (typeof couponData === 'string') {
                try {
                    couponData = JSON.parse(couponData);
                } catch (e) {}
            }

            let couponDiscount = 0;
            let walletReward = 0;
            let coupanApplyWallet = 1; // Default to direct discount

            // 🔥 FIX: Always ensure valid numbers
            baseTotal = parseFloat(baseTotal) || 0;

            if (couponData && couponData !== 'null' && typeof couponData === 'object' && couponData
                .coupancode) {
                coupanApplyWallet = parseInt(couponData.coupan_apply_wallet) || 0;
                let discountVal = parseFloat(couponData.discount) || 0;
                let calculatedAmount = 0;
                if (couponData.coupanvalue == '0') {
                    calculatedAmount = (discountVal / 100) * baseTotal;
                } else {
                    calculatedAmount = discountVal;
                }

                if (coupanApplyWallet === 0) {
                    walletReward = calculatedAmount;
                    couponDiscount = 0; // Do NOT subtract from payable total
                } else {
                    couponDiscount = calculatedAmount;
                    walletReward = 0;
                }

                $('#promo_name').val(couponData.coupancode);
                $('.promo_code_name').text(couponData.coupancode);

                // Update Step 5 applied block UI
                if (coupanApplyWallet === 0) {
                    $(".promo_dicount_replace_div").find('.wallet-label').html(
                        'Coupon Applied: <span class="promo_code_name">' + couponData.coupancode + '</span>'
                    );
                    $(".promo_dicount_replace_div").find('.price-wrapper').html(
                        '<div style="font-size:0.95rem; font-weight:800; color:#16a34a; display:inline-flex; align-items:center; gap:4px; margin-top:2px; text-align:left;"><span class="currency_dhiramnew" style="font-size:0.95rem; font-weight:700; position:relative; ">AED</span><span class="wallet_reward_amount_display">' +
                        walletReward.toFixed(2) +
                        '</span></div><span style="font-size:0.82rem; font-weight:normal; color:#16a34a; line-height: 1.3; margin-top:2px; display:block; text-align:left;">Reward credited after booking completion.</span>'
                    );
                    $(".promo_dicount_replace_div").removeClass('d-none');

                    // Show Wallet Reward in summary, hide regular discount
                    $(".wallet_reward_summary_div").removeClass('d-none');
                    $(".wallet_reward_code_amount").text(walletReward.toFixed(2));
                } else {
                    $(".promo_dicount_replace_div").find('.wallet-label').html(
                        'Coupon Applied: <span class="promo_code_name">' + couponData.coupancode + '</span>'
                    );
                    $(".promo_dicount_replace_div").find('.price-wrapper').html(
                        '<div style="font-size:0.95rem; font-weight:800; color:#16a34a; display:inline-flex; align-items:center; gap:4px; margin-top:2px; text-align:left;"><span class="currency_dhiramnew" style="font-size:0.85rem; font-weight:700; position:relative; top:-1px;">AED</span><span class="promo_code">' +
                        couponDiscount.toFixed(2) + '</span></div>');
                    $(".promo_dicount_replace_div").removeClass('d-none');

                    $(".wallet_reward_summary_div").addClass('d-none');
                }

            } else {
                $('#promo_name').val('');
                couponDiscount = 0;
                walletReward = 0;
                $(".promo_dicount_replace_div").addClass('d-none');
                $(".wallet_reward_summary_div").addClass('d-none');
            }

            // 🔥 FIX: enforce number again before toFixed()
            couponDiscount = parseFloat(couponDiscount) || 0;
            walletReward = parseFloat(walletReward) || 0;

            $('#promo_discount').val(couponDiscount.toFixed(2));
            $('#wallet_reward_amount').val(walletReward.toFixed(2));

            let totalToPay = baseTotal - couponDiscount;

            $("#total_to_pay").val(totalToPay.toFixed(2));
            $(".total_to_pay").text(totalToPay.toFixed(2));

            if (coupanApplyWallet === 1) {
                $(".promo_code").text(couponDiscount.toFixed(2));
            } else {
                $(".promo_code").text("0.00");
                $(".wallet_reward_code_amount").text(walletReward.toFixed(2));
                $(".promo_dicount_replace_div").find('.promo_code').text(walletReward.toFixed(2));
            }

            // Dynamically update Tabby based on API
            if (typeof updateTabbyDisplay === 'function') {
                updateTabbyDisplay(totalToPay);
            }

            // 🔥 SHOW / HIDE CROSSED AMOUNT
            if (couponDiscount > 0) {
                $(".cross_amount").text(baseTotal.toFixed(2));
                $(".cross_amount_div").show();
            } else {
                $(".cross_amount_div").hide();
            }
            updateAllSummaries();

            // Mabrook savings banner toggle
            let savingVal = couponDiscount > 0 ? couponDiscount : walletReward;
            if (savingVal > 0) {
                $('.mabrook-saving-banner').removeClass('d-none').show();
                $('.mabrook-saving-amount').text(savingVal.toFixed(2));
            } else {
                $('.mabrook-saving-banner').addClass('d-none').hide();
            }

            // Hook: try auto-applying URL promo when cart has value
            if (typeof window.maybeAutoApplyPromo === 'function') {
                window.maybeAutoApplyPromo(baseTotal);
            }

            // Hook: auto-remove promo if cart drops to zero
            if (typeof window.maybeAutoRemovePromo === 'function') {
                window.maybeAutoRemovePromo(baseTotal);
            }
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

        let totalToPayValue = parseFloat($('#total_to_pay').val()) || 0;

        // 🔥 TABBY CONDITIONAL LOGIC
        // This is now dynamically handled via the AJAX call in updateTabbyDisplay
        if (typeof updateTabbyDisplay === 'function') {
            updateTabbyDisplay(totalToPayValue);
        }

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
            {
                id: '#wallet_reward_amount',
                row: '.wallet_reward_sidebar_div, .wallet_reward_summary_div',
                span: '.wallet_reward_code_amount'
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

        let backendDate = `${year}-${convertMonthToNumber(monthName)}-${String(dayNum).padStart(2, '0')}`;
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
        if (!window.isUserLoggedIn) {
            $('#exampleModalLong').modal('show');
            return false;
        }
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

        if (emiratesShow) {
            let docType = $("input[name='doc_type']:checked").val();
            if (docType === 'emirates') {
                let emirates_id_number = $('#emirates_id_number').val().trim();
                if (!emirates_id_number) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Please Enter Your Emirates ID Number',
                        confirmButtonColor: '#3085d6',
                    });
                    return false;
                }
            } else if (docType === 'passport') {
                let passport_number = $('#passport_number').val().trim();
                if (!passport_number) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Please Enter Your Passport Number',
                        confirmButtonColor: '#3085d6',
                    });
                    return false;
                }
            }
        }

        var address = city + ', ' + area + ', ' + building_street_no + ', ' + apartment_villa_no;

        $('.address_replace').html(address);

        $('#service_fee').val('9');
        updateSidebarCart();

        return true;
    }

    function validateStep5() {

        var payment_type = $("input[name='payment_type']:checked").val();
        if (payment_type == 'COD') {
            var charge_text = "Cash on Delivery";
        } else if (payment_type == 'TABBY') {
            var charge_text = "Tabby Installments";
            Swal.fire({
                title: 'Redirecting to Tabby',
                html: 'Please wait while we securely redirect you to Tabby Checkout...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        } else {
            var charge_text = "Online";
        }

        $('.payment_mode').html(charge_text);

        $('#spinner_button').show();
        $('.finalbooknow').hide();

        localStorage.removeItem('currentStep');

        $('#bookingForm').submit();

        //alert("Booking Confirmed Successfully!");
        return true;

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

    // function validateStep6() {
    //     //('.sidebar').hide();

    //     $('#spinner_button').show();
    //     $('.finalbooknow').hide();

    //     localStorage.removeItem('currentStep');

    //     $('#bookingForm').submit();

    //     //alert("Booking Confirmed Successfully!");
    //     return true;
    // }

    $(document).on("click", ".open-fee-modal", function() {

        var title = $(this).data("title");
        var content = $(this).data("content");

        $("#feeModalLabel").text(title);
        $("#feeModalContent").html(content);

        $("#feeModal").modal("show");
    });

    function submitLoginFormAjax(formId, callback) {
        var form = document.getElementById(formId);
        var formData = new FormData(form);
        var url = form.action;

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.success) {
                    window.isUserLoggedIn = true;
                    $('.modal').modal('hide');
                    if (callback && typeof callback === 'function') {
                        callback();
                    }
                } else {
                    alert(response.message || 'Login failed');
                    // Reset loading buttons in modals if they were hidden
                    $('#spinner_button_phone_book3').hide();
                    $('#submit_button_phone_book3').show();
                    $('#spinner_button_email_book3').hide();
                    $('#submit_button_email_book3').show();
                }
            },
            error: function(xhr) {
                var message = 'An error occurred. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                alert(message);
                $('#spinner_button_phone_book3').hide();
                $('#submit_button_phone_book3').show();
                $('#spinner_button_email_book3').hide();
                $('#submit_button_email_book3').show();
            }
        });
    }

    function proceedAfterLogin() {
        if (typeof nextStep === 'function') {
            nextStep();
        }
    }
</script>

<style>
    /* Tabby Conditional UI */
    .payment-method-card.tabby-disabled {
        opacity: 0.55;
        pointer-events: none;
        cursor: not-allowed;
    }

    .payment-method-card.tabby-disabled .payment-card-content {
        border-color: #f0f0f0;
        background: #fafafa;
    }

    .tabby-helper-text {
        font-size: 14px;
        font-weight: 500;
        margin-top: 6px;
        transition: all 0.3s ease;
    }

    .tabby-helper-text.error {
        color: #DC2626;
    }

    .tabby-helper-text.eligible {
        color: #16A34A;
    }

    .custom-toast-popup {
        margin-top: 80px !important;
    }
</style>
<script>
    function showToast(type, title, message) {
        let bgColor = '#28a745';
        let iconChar = '%';
        if (type === 'error') {
            bgColor = '#dc3545';
            iconChar = 'X';
        } else if (type === 'warning' || type === 'info') {
            bgColor = '#fd7e14';
            iconChar = '!';
        } else if (type === 'success' && title !== 'Promo Code Applied') {
            iconChar = '✓';
        }

        Swal.fire({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            showCloseButton: true,
            html: '<div style="text-align: left; display: flex; flex-direction: column; padding-right: 15px;">' +
                '  <div style="display: flex; align-items: center; gap: 10px;">' +
                '    <div style="background-color: ' + bgColor +
                '; min-width: 24px; height: 24px; border-radius: 4px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">' +
                '      <span style="color: white; font-size: 14px; font-weight:bold; line-height: 1;">' +
                iconChar + '</span>' +
                '    </div>' +
                '    <span style="font-size: 15px; font-weight: 700; color: #000; margin: 0;">' + title +
                '</span>' +
                '  </div>' +
                '  <div style="font-size: 13px; color: #666; margin-top: 4px; padding-left: 34px;">' + message +
                '</div>' +
                '</div>',
            customClass: {
                popup: 'custom-toast-popup',
                htmlContainer: 'm-0 p-2'
            }
        });
    }
    const showPromoToast = showToast;

    function apply_promo(from) {
        let promo_code = $('#promo_code' + from).val();
        if (!promo_code) {
            showPromoToast('warning', 'Warning', 'Please Enter Promo Code');
            return false;
        }

        var sub_total = parseFloat($('#sub_total').val()) || parseFloat($('#base_total').val()) || 0;

        $.ajax({
            url: "{{ route('home_promo_check') }}",
            type: 'POST',
            data: {
                'promo_code': promo_code,
                'service': @json($service_id),
                'sub_service': @json($subservice_id),
                'sub_total': sub_total,
                '_token': "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response === 'invalid') {
                    showPromoToast('error', 'Error', 'Invalid Promo Code');
                    $('#promo_code' + from).val('');
                } else if (response === 'Already' || response === 'Already Used') {
                    showPromoToast('info', 'Notice', 'Promo Code Already Used');
                    $('#promo_code' + from).val('');
                } else if (response === 'invalid_user_count') {
                    showPromoToast('info', 'Notice', 'Promo Code Expired.');
                    $('#promo_code' + from).val('');
                } else if (response === 'grater') {
                    showPromoToast('info', 'Notice', 'Promo Discount is greater than total amount');
                    $('#promo_code' + from).val('');
                } else if (response === 'success') {
                    $.get("{{ route('package.get_coupon') }}", function(couponData) {
                        if (typeof couponData === 'string') {
                            try {
                                couponData = JSON.parse(couponData);
                            } catch (e) {}
                        }
                        let toastMsg = 'Your promo code has been applied.';
                        if (couponData && couponData !== 'null' && typeof couponData === 'object' &&
                            couponData.coupancode) {
                            let rewardMsg = '';
                            if (couponData.coupanvalue == '0') {
                                rewardMsg = couponData.discount + '%';
                            } else {
                                rewardMsg =
                                    '<span class="price-wrapper"><span class="currency_dhiramnew">AED</span>' +
                                    couponData.discount + '</span>';
                            }

                            if (couponData.coupan_apply_wallet == '0') {
                                let valStr = couponData.coupanvalue == '0' ? couponData.discount +
                                    '%' :
                                    '<span class="price-wrapper"><span class="currency_dhiramnew">AED</span>' +
                                    couponData.discount + '</span>';
                                toastMsg = 'Coupon applied successfully. ' + valStr +
                                    ' will be credited to your wallet after successful order completion.';
                            } else {
                                toastMsg = rewardMsg + ' off applied successfully.';
                            }
                        }
                        showPromoToast('success', 'Promo Code Applied', toastMsg);
                    });

                    $('#promo_code_input_section').addClass('d-none');
                    $('.promo_dicount_replace_div').removeClass('d-none');
                    $('.promo_code_name').text(promo_code);

                    $(".wallet_apply_new").show();
                    $(".wallet_cancel_new").hide();
                    $('#wallet_used').val('0');

                    if (typeof calculation === 'function') {
                        calculation();
                    } else if (typeof updateSidebarCart === 'function') {
                        updateSidebarCart();
                    }
                } else {
                    showPromoToast('error', 'Error', 'Something went wrong');
                    $('#promo_code' + from).val('');
                }
            }
        });
        return false;
    }

    function remove_coupon() {
        Swal.fire({
            title: 'Are you sure you want to remove the promo code?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('homecleaning.remove_coupon') }}",
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

                        $('#promo_code_input_section').removeClass('d-none');
                        $('.promo_dicount_replace_div').addClass('d-none');
                        $('#promo_code2').val('');

                        if (typeof calculation === 'function') {
                            calculation();
                        } else if (typeof updateSidebarCart === 'function') {
                            updateSidebarCart();
                        }

                        showPromoToast('success', 'Promo Code Removed',
                            'Promo code removed successfully.');
                    }
                });
            }
        });
    }
</script>

{{-- ==================== Google Ads promo Auto-Apply ==================== --}}
<script>
    (function() {
        // Values passed from PHP controller
        @php
            $jsPromoCode = !empty($promo) ? $promo : '';
            $jsSessionCoupon = !empty($session_coupon_applied) ? $session_coupon_applied : '';
        @endphp
        var promoCode = @json($jsPromoCode);
        var sessionCouponCode = @json($jsSessionCoupon);

        // Track whether promo has been applied in this session
        var promoApplied = false;
        var promoAttempted = false;

        // ── On page load: if promo in URL, show banner in Step 1 ──────────────
        if (promoCode) {
            // If same code already in session, mark as applied and show UI.
            // Hide the Step 1 banner since promo is already applied.
            if (sessionCouponCode && sessionCouponCode === promoCode) {
                promoApplied = true;
                promoAttempted = true;
                $(function() {
                    showPromoAppliedUI(promoCode);
                    // Hide Step 1 banner — promo is already working
                    hideBanner();
                });
            } else {
                // Promo NOT yet applied — show Step 1 banner if cart is empty
                $(function() {
                    // Banner visibility is managed by updateCartPromoVisibility()
                    updateCartPromoVisibility();
                });
            }
        }

        /**
         * Show the "Promo Applied" green UI card in the payment section.
         */
        function showPromoAppliedUI(code) {
            $('#promo_code_input_section').addClass('d-none');
            $('.promo_dicount_replace_div').removeClass('d-none');
            $('.promo_code_name').text(code);
        }

        /** Hide the Step 1 promo banner (promo has been applied) */
        function hideBanner() {
            var banner = document.getElementById('step1_promo_banner');
            if (banner) banner.style.display = 'none';
        }

        /** Show the Step 1 promo banner (cart dropped to zero, invite user to add packages) */
        function showBanner() {
            var banner = document.getElementById('step1_promo_banner');
            if (banner) banner.style.display = 'flex';
        }

        /**
         * Sync Step 1 banner visibility with current cart total.
         * @param {number} cartTotal - Raw package total from the live cart object (not from DOM).
         */
        function updateCartPromoVisibility(cartTotal) {
            if (!promoCode) return;
            // cartTotal may be undefined on first call (page load) — fall back to 0
            var total = parseFloat(cartTotal) || 0;
            if (total > 0) {
                // Cart has items — hide the banner (promo will auto-apply or is already applied)
                hideBanner();
            } else {
                // Cart is empty — show banner only if promo not yet applied
                if (!promoApplied) showBanner();
            }
        }
        // Expose globally so updateSidebarCart can call it with live total
        window.updateCartPromoVisibility = updateCartPromoVisibility;

        /**
         * Silently remove promo from session — no confirmation dialog.
         */
        function silentRemovePromo(callback) {
            $.ajax({
                url: "{{ route('package.remove_coupon') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    $('#promo_name').val('');
                    $('#promo_discount').val('0.00');
                    $('.promo_code').text('0.00');
                    $('.promo_code_name').text('');
                    $('.cross_amount_div').hide();
                    $('#promo_code_input_section').removeClass('d-none');
                    $('.promo_dicount_replace_div').addClass('d-none');
                    $('#promo_code2').val('');
                    promoApplied = false;
                    promoAttempted = false; // allow re-apply if cart grows again
                    // Show banner again — user should add packages to reactivate promo
                    showBanner();
                    if (typeof callback === 'function') callback();
                }
            });
        }

        /**
         * Called from checkapplyPromo() after each cart recalculation.
         * Auto-applies the URL promo when cart first gets a positive value.
         */
        window.maybeAutoApplyPromo = function(baseTotal) {
            if (!promoCode) return;
            if (promoAttempted) return;

            // Compute raw package-only subtotal from the live cart object
            var rawCartTotal = 0;
            if (typeof cart === 'object') {
                Object.keys(cart).forEach(function(id) {
                    rawCartTotal += (parseFloat(cart[id].price) || 0) * (parseInt(cart[id].qty) || 1);
                });
            }

            if (rawCartTotal <= 0) return; // no packages yet — don't apply

            promoAttempted = true;

            // Hide the Step 1 banner — we are about to apply or already applied
            hideBanner();

            // If same promo already in session — just update UI
            if (sessionCouponCode && sessionCouponCode === promoCode) {
                showPromoAppliedUI(promoCode);
                promoApplied = true;
                return;
            }

            // If a DIFFERENT promo is in session — don't override
            if (sessionCouponCode && sessionCouponCode !== promoCode) {
                return;
            }

            // No coupon in session — apply via AJAX silently using raw cart subtotal
            $.ajax({
                url: "{{ route('home_promo_check') }}",
                type: 'POST',
                data: {
                    'promo_code': promoCode,
                    'service': @json($service_id),
                    'sub_service': @json($subservice_id),
                    'sub_total': rawCartTotal,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response === 'success') {
                        showPromoAppliedUI(promoCode);
                        promoApplied = true;
                        $.get("{{ route('package.get_coupon') }}", function(couponData) {
                            if (typeof couponData === 'string') {
                                try {
                                    couponData = JSON.parse(couponData);
                                } catch (e) {}
                            }
                            let toastMsg = 'Your promo code has been applied.';
                            if (couponData && couponData !== 'null' && typeof couponData ===
                                'object' && couponData.coupancode) {
                                let rewardMsg = '';
                                if (couponData.coupanvalue == '0') {
                                    rewardMsg = couponData.discount + '%';
                                } else {
                                    rewardMsg =
                                        '<span class="price-wrapper"><span class="currency_dhiramnew">AED</span>' +
                                        couponData.discount + '</span>';
                                }

                                if (couponData.coupan_apply_wallet == '0') {
                                    let valStr = couponData.coupanvalue == '0' ? couponData
                                        .discount + '%' :
                                        '<span class="price-wrapper"><span class="currency_dhiramnew">AED</span>' +
                                        couponData.discount + '</span>';
                                    toastMsg = 'Coupon applied successfully. ' + valStr +
                                        ' will be credited to your wallet after successful order completion.';
                                } else {
                                    toastMsg = rewardMsg + ' off applied successfully.';
                                }
                            }
                            showPromoToast('success', 'Promo Code Applied', toastMsg);
                        });
                        // Recalculate so discount shows in totals
                        if (typeof updateSidebarCart === 'function') updateSidebarCart();
                    } else if (response === 'grater') {
                        showPromoToast('info', 'Notice',
                            'Add more items — promo discount is greater than your current total.'
                        );
                        promoAttempted = false; // allow retry
                        showBanner(); // Show banner again — need more items
                    }
                    // For 'invalid', 'Already', 'expired' — silently do nothing
                }
            });
        };

        /**
         * Called from checkapplyPromo() after each cart recalculation.
         * Auto-removes the URL promo when cart drops to zero.
         */
        window.maybeAutoRemovePromo = function(baseTotal) {
            if (!promoCode) return;
            if (!promoApplied) return; // nothing to remove

            // Use raw package total from cart object (not baseTotal which includes VAT/fees)
            var rawTotal = 0;
            if (typeof cart === 'object') {
                Object.keys(cart).forEach(function(id) {
                    rawTotal += (parseFloat(cart[id].price) || 0) * (parseInt(cart[id].qty) || 1);
                });
            }

            if (rawTotal > 0) return; // cart still has items — keep promo

            // Cart is now empty — silently remove promo so it can re-apply later
            silentRemovePromo(function() {
                if (typeof updateSidebarCart === 'function') updateSidebarCart();
            });
        };

        window.updateTabbyDisplay = function(amount) {
            let tabbyOption = $("#tabby_payment_option");
            let tabbyHelper = $("#tabby_helper_text");
            let rightSummary = $(".tabbbyrightsummary");
            let sidebarPromo = $("#sidebar_tabby_promo");

            if (amount > 0) {
                $.ajax({
                    url: '{{ route('tabby.check_installments') }}',
                    type: 'POST',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content') ||
                            '{{ csrf_token() }}',
                        'amount': amount,
                        'currency': 'AED',
                        'name': $("input[name='name']").val() || $("input[name='first_name']").val() ||
                            'Guest User',
                        'email': $("input[name='email']").val() || 'guest@example.com',
                        'phone': $("input[name='mobile']").val() || $("input[name='phone']").val() ||
                            '+971500000000'
                    },
                    success: function(response) {
                        if (response && response.eligible) {
                            tabbyOption.removeClass("tabby-disabled");
                            tabbyHelper.removeClass("error").addClass("eligible").html(response
                                .display_text).show();
                            rightSummary.show();
                            sidebarPromo.css('display', 'flex');

                            let dynamicCardsHtml = '';
                            let sidebarUpdated = false;

                            if (response.products && response.products.installments) {
                                let inst = response.products.installments;
                                inst.forEach(function(product) {
                                    if (product.installments && product.installments
                                        .length > 0) {
                                        let count = product.installments.length;
                                        let amt = parseFloat(product.installments[0].amount)
                                            .toFixed(2);
                                        let fee = parseFloat(product.service_fee || 0);

                                        let feeHtml = fee > 0 ?
                                            '<span style="color: #666;">Includes <span class="price-wrapper"><span class="currency_dhiramnew">AED</span> ' +
                                            fee.toFixed(2) + '</span> monthly fee</span>' :
                                            '<span style="color: #16a34a; font-weight: 600;">No interest. No fees.</span>';

                                        dynamicCardsHtml += `
                                        <div style="background: #fff; border-radius: 16px; padding: 18px; margin-bottom: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display:flex; justify-content: space-between; align-items: center;">
                                            <div>
                                                <div style="font-size: 1rem; font-weight: 700; color: #111; margin-bottom: 4px;">${count} payments</div>
                                                <div style="font-size: 0.85rem;">${feeHtml}</div>
                                            </div>
                                            <div style="text-align: right; font-weight: 700; color: #111; display: inline-flex; align-items: baseline; gap: 4px;">
                                                <span class="price-wrapper">
                                                    <span class="currency_dhiramnew" style="font-size:0.85rem;">AED</span>
                                                    <span>${amt}</span>
                                                </span>/mo
                                            </div>
                                        </div>`;

                                        // Update the mini sidebar text to match the FIRST payment option
                                        if (!sidebarUpdated) {
                                            $(".tabby_split_amount").text(amt);
                                            $(".tabby_split_count").text("for " + count +
                                                " months");
                                            sidebarUpdated = true;
                                        }
                                    }
                                });
                            }

                            if (response.products && response.products.pay_later && response
                                .products.pay_later.length > 0) {
                                dynamicCardsHtml += `
                                <div style="background: #fff; border-radius: 16px; padding: 18px; margin-bottom: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                                    <div style="display:flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px;">
                                        <div style="font-size: 1rem; font-weight: 700; color: #111;">Pay Next Month</div>
                                        <div style="background: #e6f0ff; color: #0040E6; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 50px;">No down payment</div>
                                    </div>
                                    <div style="font-size: 0.85rem; color: #16a34a; font-weight: 600; margin-bottom: 2px;">No interest. No fees.</div>
                                    <div style="font-size: 0.85rem; color: #666; font-weight: 500;">Pay in Full in one bill next month</div>
                                </div>`;
                            }

                            // If Tabby fallback triggered (API error) and we have no products, generate just a 4 payment fallback card
                            if (dynamicCardsHtml === '' && response.installment_amount) {
                                let amt = parseFloat(response.installment_amount).toFixed(2);
                                dynamicCardsHtml = `
                                <div style="background: #fff; border-radius: 16px; padding: 18px; margin-bottom: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display:flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <div style="font-size: 1rem; font-weight: 700; color: #111; margin-bottom: 4px;">4 payments</div>
                                        <div style="font-size: 0.85rem;"><span style="color: #16a34a; font-weight: 600;">No interest. No fees.</span></div>
                                    </div>
                                    <div style="text-align: right; font-weight: 700; color: #111; display: inline-flex; align-items: baseline; gap: 4px;">
                                        <span class="price-wrapper">
                                            <span class="currency_dhiramnew" style="font-size:0.85rem;">AED</span>
                                            <span>${amt}</span>
                                        </span>/mo
                                    </div>
                                </div>`;
                                $(".tabby_split_amount").text(amt);
                                $(".tabby_split_count").text("for 4 months");
                            }

                            $("#tabby_dynamic_cards_container").html(dynamicCardsHtml);
                        } else {
                            hideTabby();
                        }
                    },
                    error: function() {
                        hideTabby();
                    }
                });
            } else {
                hideTabby();
            }

            function hideTabby() {
                tabbyOption.addClass("tabby-disabled");
                tabbyHelper.removeClass("eligible").addClass("error").text(
                    "Currently unavailable for this amount").show();
                rightSummary.hide();
                sidebarPromo.hide();

                if ($("#paymet_3").is(":checked")) {
                    $("#paymet_3").prop("checked", false);
                    $("#paymet_1").prop("checked", true);
                }
            }
        };

    })();
</script>
