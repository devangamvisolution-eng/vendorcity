@include('front.includes.header')
<link rel="stylesheet" href="{{ asset('public/site/css/homecleaning.css') }}">
<link rel="stylesheet" href="{{ asset('public/site/css/homedirham.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* .currency_dhiramnew {
        margin-right: 3px
    } */

    #stickyHeader:empty {
        display: none !important;
        padding: 0 !important;
        margin: 0 !important;
        border: none !important;
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
        top: 1px;
    }

    .mabrook-saving-banner .currency_dhiramnew {
        position: relative;
        /* top: 1px; */
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
    /* Bootstrap default: modal z-index 1055, backdrop 1050.        */
    /* When an info popup opens on Step 6 mobile, it must sit above  */
    /* the mobilesummaryModal (z-index 1060) that may already be     */
    /* open behind it.                                               */

    /* 1. Summary modal — sits at 1060 so info popups can go above */
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

    /* 2. Info fee popups — above the summary sheet */
    #delivery_charge_popup_{{ $subservice_id }},
    #service_fee_popup_{{ $subservice_id }},
    #timing_fee_popup_{{ $subservice_id }} {
        z-index: 1090 !important;
    }

    /* 3. The LAST modal-backdrop (for info popups) must be above summary modal.
          Bootstrap appends backdrops sequentially — target the last one.        */
    #mobilesummaryModal~.modal-backdrop {
        /* z-index: 1080 !important; */
    }

    /* ══════════════════════════════════════════════════
       ALL INFO / ADDON POPUPS — Bottom Sheet (Mobile)

       KEY RULE: Only override display when Bootstrap has
       opened the modal (.show). Never block display:none
       so the close button always works.
    ══════════════════════════════════════════════════ */

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

    /* ── Mobile (≤ 767px) — iOS Bottom Sheet ── */
    @media (max-width: 767px) {
        .addonsinstruction h5 {
            font-size: 11px;
        }

        .addonsinstruction h5 i {
            font-size: 11px;
        }

        /* 1. Modal overlay — flex to push dialog to bottom */
        .subservice-read-more-model.show {
            display: flex !important;
            align-items: flex-end !important;
            padding: 0 !important;
            /* NO overflow:hidden here — it blocks pointer events on close button */
        }

        /* 2. Dialog — fixed full-width strip at the bottom */
        .subservice-read-more-model .modal-dialog {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            /* Slide-up animation */
            transform: translateY(100%);
            transition: transform 0.32s cubic-bezier(0.32, 0.72, 0, 1) !important;
            will-change: transform;
        }

        /* 3. Animate in when Bootstrap adds .show */
        .subservice-read-more-model.show .modal-dialog {
            transform: translateY(0) !important;
        }

        /* 4. White card — shrinks to content, never exceeds 80% screen */
        .subservice-read-more-model .modal-content {
            border-radius: 20px 20px 0 0 !important;
            border: none !important;
            box-shadow: 0 -6px 32px rgba(0, 0, 0, 0.18) !important;
            height: auto !important;
            max-height: 80dvh !important;
            display: flex !important;
            flex-direction: column !important;
            /* overflow:hidden removed — was blocking close button taps on iOS */
            overflow: visible !important;
            padding-bottom: env(safe-area-inset-bottom, 0px) !important;
        }

        /* 5. Drag handle pill */
        .subservice-read-more-model .modal-drag-handle {
            flex: 0 0 auto !important;
            width: 100%;
            padding: 10px 0 4px;
            text-align: center;
            border-radius: 20px 20px 0 0;
            background: #fff;
        }

        /* 6. Header row — never scrolls, pinned */
        .subservice-read-more-model .modal-header {
            flex: 0 0 auto !important;
            border-bottom: 1px solid #f0f0f0 !important;
            padding: 12px 20px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            background: #fff;
            /* Ensure close button is always tappable */
            position: relative;
            z-index: 10;
        }

        /* 7. Body — scrolls only when content overflows, doesn't stretch */
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

        /* 8. Footer — pinned */
        .subservice-read-more-model .modal-footer,
        .subservice-read-more-model .modal-footer-sticky {
            flex: 0 0 auto !important;
            background: #fff;
        }

        /* 9. Close button — large enough to tap easily */
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

    /* Sticky footer inside addon detail modals */
    .modal-footer-sticky {
        position: sticky;
        bottom: 0;
        background: #fff;
        padding: 16px 20px;
        border-top: 1px solid #eee;
        z-index: 10;
    }

    /* Hide main sticky footer when OTHER modals open — but NOT when mobilesummaryModal is open */
    body.modal-open:not(.summary-modal-open) .sticky-footer-btn,
    body.modal-open:not(.summary-modal-open) .mobile_total {
        display: none !important;
    }

    /* ─────────────────────────────────────────────
       mobilesummaryModal  — iOS/Android Bottom Sheet
       Fully tested: iPhone Safari, Chrome Android, iPad
    ───────────────────────────────────────────── */

    /* Prevent background page scroll while sheet is open */
    body.summary-modal-open {
        overflow: hidden;
        touch-action: none;
    }

    /* The dialog itself — fixed to bottom, full width */
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
        /* Respect iPhone notch / home indicator */
        padding-bottom: env(safe-area-inset-bottom, 0px);
    }

    #mobilesummaryModal.show .modal-summary-sheet {
        transform: translateY(0) !important;
    }

    /* modal-content: the white card.
       Use explicit height so iOS Safari respects the boundary */
    #mobilesummaryModal .modal-content {
        border-radius: 20px 20px 0 0 !important;
        background: #fff !important;
        border: none !important;
        box-shadow: 0 -8px 40px rgba(0, 0, 0, 0.14) !important;

        /* Explicit height cap — dvh is safer on iOS than vh */
        height: 88vh !important;
        height: 88dvh !important;
        /* dynamic viewport height (iOS 16+) */
        max-height: 80vh !important;
        max-height: 80dvh !important;

        /* Flex column — header pinned top, footer pinned bottom */
        display: -webkit-box !important;
        display: -ms-flexbox !important;
        display: flex !important;
        -webkit-box-orient: vertical !important;
        -webkit-box-direction: normal !important;
        -ms-flex-direction: column !important;
        flex-direction: column !important;

        /* Critical: clip overflow so header/footer don't bleed */
        overflow: hidden !important;
        -webkit-overflow-scrolling: auto !important;
    }

    /* Drag pill — never shrinks, never scrolls */
    #mobilesummaryModal .modal-drag-handle {
        -webkit-box-flex: 0 !important;
        -ms-flex: 0 0 auto !important;
        flex: 0 0 auto !important;
        width: 100%;
    }

    /* Header row — never shrinks, never scrolls */
    #mobilesummaryModal .modal-sheet-header {
        -webkit-box-flex: 0 !important;
        -ms-flex: 0 0 auto !important;
        flex: 0 0 auto !important;
        width: 100%;
        /* Prevent iOS tap-highlight glitch */
        -webkit-tap-highlight-color: transparent;
    }

    /* Scrollable body — takes all remaining space, scrolls only here */
    #mobilesummaryModal .modal-body {
        -webkit-box-flex: 1 !important;
        -ms-flex: 1 1 0% !important;
        flex: 1 1 0% !important;
        /* 0% base avoids iOS flex-grow bug */
        min-height: 0 !important;
        /* critical: prevents content from stretching parent */
        max-height: none !important;
        /* Use scroll not auto for iOS Safari scroll momentum */
        overflow-y: scroll !important;
        -webkit-overflow-scrolling: touch !important;
        overscroll-behavior: contain !important;
        /* Prevent content from being clipped */
        overflow-x: hidden !important;
    }

    /* Sticky footer — never shrinks, accounts for home indicator */
    #mobilesummaryModal .modal-sheet-footer {
        -webkit-box-flex: 0 !important;
        -ms-flex: 0 0 auto !important;
        flex: 0 0 auto !important;
        width: 100%;
        /* Add padding for iPhone home bar */
        padding-bottom: max(20px, calc(12px + env(safe-area-inset-bottom, 0px))) !important;
    }

    /* ─── Tablet overrides (iPad etc) ─── */
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
                <form id="bookingForm" method="POST" action="{{ route('book_now_homecleaning') }}">
                    @csrf
                    <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
                    <input type="hidden" name="subservice_id" id="subservice_id" value="{{ $subservice_id }}">
                    <div class="main-content ">

                        <div class="step-content active" id="step1">



                            <div class="sticky-header" id="stickyHeader"></div>



                            <div class="section-packages">
                                {{-- <h5 class="font-weight-bold h3 subservice-name">{{ $subservice_name }} </h5> --}}
                                <p class="card-text">
                                    {{-- <span>Complete the booking form, and we'll match you with a
                                        top-notch cleaner to ensure your home sparkles with freshness and
                                        comfort.</span> --}}
                                    <a href="javascript:void(0)" data-bs-toggle="modal" id="read_more"
                                        data-bs-target="#exampleModalLong" style="text-decoration: underline;">
                                        Read more about Our Home Cleaning Service includes.
                                    </a>

                                <div class="form-group mb-3  slider-top">
                                    <label class="form-label fw500 dark-color " for="country">How many hours do you
                                        need your cleaner to stay?

                                        <span>
                                            <a style="cursor: pointer;margin-left:3px;" data-bs-toggle="modal"
                                                id="cleaner_stay" data-bs-target="#Learnmore">
                                                <img src="{{ asset('public/site/images/infoicon.svg') }}"
                                                    style="height: 15px;width: 15px;">
                                            </a>
                                        </span>
                                    </label>
                                    <div id="how_many_hours_need_cleaner_slider_spatie" class="splide radio-group ">
                                        <div class="splide__track">
                                            <ul class="splide__list">
                                                <li class="splide__slide text-center">
                                                    <input type="radio" id="how_many_hours_2"
                                                        name="how_many_hours_should_they_stay" value="2"
                                                        onclick="calculation()">
                                                    <label for="how_many_hours_2">2</label>
                                                    {{-- <p style="" class="home_hour_p">
                                                        <span class="home_hour_span">
                                                            <span class="currency_dhiramnew">AED</span>
                                                            @if ($is_first_time_user)

                                                            {{ $cleaning_price[0]->hourly_price }}/hr
                                                            @else
                                                            {{ $cleaning_price[0]->hourly_price }}/hr
                                                            @endif
                                                        </span>
                                                    </p> --}}
                                                </li>

                                                <li class="splide__slide text-center">
                                                    <input type="radio" id="how_many_hours_3"
                                                        name="how_many_hours_should_they_stay" value="3"
                                                        onclick="calculation()">
                                                    <label for="how_many_hours_3">3</label>
                                                    {{-- <p style="" class="home_hour_p">
                                                        <span class="home_hour_span">
                                                            <span class="currency_dhiramnew">AED</span>
                                                            @if ($is_first_time_user)

                                                            {{ $cleaning_price[1]->hourly_price }}/hr
                                                            @else
                                                            {{ $cleaning_price[1]->hourly_price }}/hr
                                                            @endif
                                                        </span>
                                                    </p> --}}
                                                </li>

                                                <li class="splide__slide text-center">
                                                    {{-- <span class="popular">Popular</span> --}}
                                                    <input type="radio" id="how_many_hours_4"
                                                        name="how_many_hours_should_they_stay" value="4" checked
                                                        onclick="calculation()">
                                                    <label for="how_many_hours_4">4</label>
                                                    {{-- <p style="" class="home_hour_p">
                                                        <span class="home_hour_span">
                                                            <span class="currency_dhiramnew">AED</span>
                                                            @if ($is_first_time_user)

                                                            {{ $cleaning_price[2]->hourly_price }}/hr
                                                            @else
                                                            {{ $cleaning_price[2]->hourly_price }}/hr
                                                            @endif
                                                        </span>
                                                    </p> --}}
                                                </li>

                                                <li class="splide__slide text-center">
                                                    <input type="radio" id="how_many_hours_5"
                                                        name="how_many_hours_should_they_stay" value="5"
                                                        onclick="calculation()">
                                                    <label for="how_many_hours_5">5</label>
                                                    {{-- <p style="" class="home_hour_p">
                                                        <span class="home_hour_span">
                                                            <span class="currency_dhiramnew">AED</span>
                                                            @if ($is_first_time_user)

                                                            {{ $cleaning_price[3]->hourly_price }}/hr
                                                            @else
                                                            {{ $cleaning_price[3]->hourly_price }}/hr
                                                            @endif
                                                        </span>
                                                    </p> --}}
                                                </li>

                                                <li class="splide__slide text-center">
                                                    <input type="radio" id="how_many_hours_6"
                                                        name="how_many_hours_should_they_stay" value="6"
                                                        onclick="calculation()">
                                                    <label for="how_many_hours_6">6</label>
                                                    {{-- <p style="" class="home_hour_p">
                                                        <span class="home_hour_span">
                                                            <span class="currency_dhiramnew">AED</span>
                                                            @if ($is_first_time_user)

                                                            {{ $cleaning_price[4]->hourly_price }}/hr
                                                            @else
                                                            {{ $cleaning_price[4]->hourly_price }}/hr
                                                            @endif
                                                        </span>
                                                    </p> --}}
                                                </li>

                                                <li class="splide__slide text-center">
                                                    <input type="radio" id="how_many_hours_7"
                                                        name="how_many_hours_should_they_stay" value="7"
                                                        onclick="calculation()">
                                                    <label for="how_many_hours_7">7</label>
                                                    {{-- <p style="" class="home_hour_p">
                                                        <span class="home_hour_span">
                                                            <span class="currency_dhiramnew">AED</span>
                                                            @if ($is_first_time_user)

                                                            {{ $cleaning_price[5]->hourly_price }}/hr
                                                            @else
                                                            {{ $cleaning_price[5]->hourly_price }}/hr
                                                            @endif
                                                        </span>
                                                    </p> --}}
                                                </li>
                                                <li class="splide__slide text-center">
                                                    <input type="radio" id="how_many_hours_8"
                                                        name="how_many_hours_should_they_stay" value="8"
                                                        onclick="calculation()">
                                                    <label for="how_many_hours_8">8</label>
                                                    {{-- <p style="" class="home_hour_p">
                                                        <span class="home_hour_span">
                                                            <span class="currency_dhiramnew">AED</span>
                                                            @if ($is_first_time_user)

                                                            {{ $cleaning_price[6]->hourly_price }}/hr
                                                            @else
                                                            {{ $cleaning_price[6]->hourly_price }}/hr
                                                            @endif
                                                        </span>
                                                    </p> --}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group mb-3 slider-top">
                                    <label class="form-label fw500 dark-color " for="country">How many cleaners do
                                        you require?</label>
                                    <div id="how_many_cleaner_require_slider_spatie" class="splide radio-group">
                                        <div class="splide__track">
                                            <ul class="splide__list">

                                                <li class="splide__slide text-center">
                                                    <input type="radio" id="1"
                                                        name="how_many_cleaners_do_you_need" value="1" checked
                                                        onclick="calculation();">
                                                    <label for="1">1</label>
                                                </li>

                                                <li class="splide__slide text-center">
                                                    <input type="radio" id="2"
                                                        name="how_many_cleaners_do_you_need" value="2"
                                                        onclick="calculation()">
                                                    <label for="2">2</label>
                                                </li>
                                                <li class="splide__slide text-center">
                                                    <input type="radio" id="3"
                                                        name="how_many_cleaners_do_you_need" value="3"
                                                        onclick="calculation()">
                                                    <label for="3">3</label>
                                                </li>
                                                <li class="splide__slide text-center">
                                                    <input type="radio" id="4"
                                                        name="how_many_cleaners_do_you_need" value="4"
                                                        onclick="calculation()">
                                                    <label for="4">4</label>
                                                </li>
                                                <li class="splide__slide text-center">
                                                    <input type="radio" id="5"
                                                        name="how_many_cleaners_do_you_need" value="5"
                                                        onclick="calculation()">
                                                    <label for="5">5</label>
                                                </li>
                                                <li class="splide__slide text-center">
                                                    <input type="radio" id="6"
                                                        name="how_many_cleaners_do_you_need" value="6"
                                                        onclick="calculation()">
                                                    <label for="6">6</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="form-error-text" id="how_many_cleaners_do_you_need_error"
                                        style="color: red; margin-top: 10px;">
                                    </p>
                                </div>

                                @php

                                    if ($system_data->weekly_percentage > 0 && $system_data->weekly_percentage != '') {
                                        $weekly_discout = ' ' . $system_data->weekly_percentage . '% off Per Visit ';
                                        $weekly_discout_1 = $system_data->weekly_percentage;
                                    } else {
                                        $weekly_discout = '';
                                        $weekly_discout_1 = '';
                                    }
                                    if (
                                        $system_data->multiple_time_week > 0 &&
                                        $system_data->multiple_time_week != ''
                                    ) {
                                        $multiple_time_week_discout =
                                            ' ' . $system_data->multiple_time_week . '% off Per Visit ';
                                        $multiple_time_week_discout_1 = $system_data->multiple_time_week;
                                    } else {
                                        $multiple_time_week_discout = '';
                                        $multiple_time_week_discout_1 = '';
                                    }
                                @endphp

                                <div class="form-group mb-3">
                                    <label class="form-label fw500 dark-color" for="country">How often do you need
                                        cleaning?</label>

                                    {{-- <select class="form-control" name="how_often_do_you_need_cleaning"
                                        id="how_often_do_you_need_cleaning" onchange="cleaning_change(this.value)">
                                        <option value="">Select</option>
                                        <option value="Once">Once </option>
                                        <option value="Weekly">Weekly {{$weekly_discout}}</option>
                                        <option value="Multiple times a week">Multiple times a week
                                            {{$multiple_time_week_discout}}</option>
                                    </select> --}}
                                    <div class="radio-group radio-checked">
                                        <div class="button_weekly">
                                            <input type="radio" id="cleaning_once"
                                                name="how_often_do_you_need_cleaning" value="Once"
                                                onclick="cleaning_change(this.value)" checked>
                                            <label for="cleaning_once"><span style="font-weight:1000; ">ONCE</span>
                                                <ul>
                                                    <li style="font-weight:500;">One Time Cleaning Session</li>
                                                </ul>
                                            </label>
                                        </div>

                                        <div class="button_weekly">
                                            <input type="radio" id="cleaning_weekly"
                                                name="how_often_do_you_need_cleaning" value="Weekly"
                                                onclick="cleaning_change(this.value)">
                                            <label for="cleaning_weekly"><span><b>WEEKLY</b></span><span
                                                    class="cleaning_weekly_new"><b>{{ $weekly_discout }}</b></span>
                                                <ul>
                                                    <li style="font-weight:500;">Get the same cleaner each time</li>
                                                    <li style="font-weight:500;">Easily manage your subscription</li>
                                                </ul>
                                            </label>
                                        </div>

                                        <div class="button_weekly">
                                            <input type="radio" id="cleaning_multiple_times"
                                                name="how_often_do_you_need_cleaning" value="Multiple times a week"
                                                onclick="cleaning_change(this.value)">
                                            <label for="cleaning_multiple_times"><span><b>Multiple Times a
                                                        Week</b></span><span
                                                    class="cleaning_weekly_new"><b>{{ $multiple_time_week_discout }}</b></span>
                                                <ul>
                                                    <li style="font-weight:500;">Get the same cleaner each time</li>
                                                    <li style="font-weight:500;">Easily manage your subscription</li>
                                                </ul>
                                            </label>
                                        </div>
                                        <p class="form-error-text" id="how_often_do_you_need_cleaning_error"
                                            style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>


                                </div>

                                <div class="form-group mb-3" style="display: none" id="weekly_div">
                                    <label class="form-label fw500 dark-color " for="country">Which days of the week
                                        do you want the service?</label>

                                    <div class="checkbox-group">
                                        <input type="checkbox" id="Monday"
                                            name="which_day_of_the_week_do_you_want_the_service[]" value="Monday"
                                            onclick="calculation();">
                                        <label for="Monday">Monday</label>

                                        <input type="checkbox" id="Tuesday"
                                            name="which_day_of_the_week_do_you_want_the_service[]" value="Tuesday"
                                            onclick="calculation();">
                                        <label for="Tuesday">Tuesday</label>

                                        <input type="checkbox" id="Wednesday"
                                            name="which_day_of_the_week_do_you_want_the_service[]" value="Wednesday"
                                            onclick="calculation();">
                                        <label for="Wednesday">Wednesday</label>

                                        <input type="checkbox" id="Thursday"
                                            name="which_day_of_the_week_do_you_want_the_service[]" value="Thursday"
                                            onclick="calculation();">
                                        <label for="Thursday">Thursday</label>

                                        <input type="checkbox" id="Friday"
                                            name="which_day_of_the_week_do_you_want_the_service[]" value="Friday"
                                            onclick="calculation();">
                                        <label for="Friday">Friday</label>

                                        <input type="checkbox" id="Saturday"
                                            name="which_day_of_the_week_do_you_want_the_service[]" value="Saturday"
                                            onclick="calculation();">
                                        <label for="Saturday">Saturday</label>

                                        <input type="checkbox" id="Sunday"
                                            name="which_day_of_the_week_do_you_want_the_service[]" value="Sunday"
                                            onclick="calculation();">
                                        <label for="Sunday">Sunday</label>
                                    </div>

                                    <p class="form-error-text"
                                        id="which_day_of_the_week_do_you_want_the_service_error"
                                        style="color: red; margin-top: 10px;">
                                    </p>

                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label fw500 dark-color cleaning-mobile" for="country">Need
                                        cleaning materials? </label>
                                    <img src="{{ asset('public/site/images/dettol.png') }}"
                                        style="height: 25px;margin-right:-13px;">
                                    <p class="dettol">Powered by Dettol</p>
                                    @if ($subservice_id == 28)
                                        <span>
                                            <a style="cursor: pointer;margin-left:3px;" data-bs-toggle="modal"
                                                id="cleaner_stay" data-bs-target="#material">
                                                <img src="{{ asset('public/site/images/infoicon.svg') }}"
                                                    style="height: 15px;width: 15px;">
                                        </span>
                                        </a>
                                    @endif
                                    <p class="additional_p">A material charge of <span class="price-wrapper"><span
                                                class="currency_dhiramnew">AED</span>10/hr</span> applies.</p>
                                    <div class="radio-group">
                                        <div class="material">
                                            <input type="radio" id="do_you_need_yes"
                                                name="do_you_need_cleaning_material" value="Yes"
                                                onclick="calculation()">
                                            <label for="do_you_need_yes">Yes</label>

                                            <input type="radio" id="do_you_need_no"
                                                name="do_you_need_cleaning_material" value="No"
                                                onclick="calculation()" checked>
                                            <label for="do_you_need_no">No</label>
                                        </div>
                                    </div>
                                    <p class="form-error-text" id="do_you_need_cleaning_material_error"
                                        style="color: red; margin-top: 10px;">
                                    </p>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label fw500 dark-color " for="country">Do you have any special
                                        instructions?</label>
                                    <textarea name="any_special_instruction" id="any_special_instruction"
                                        placeholder="Example: You need a gate pass to enter the community, building code is #1234, etc."></textarea>

                                    <p class="form-error-text" id="any_special_instruction_error"
                                        style="color: red; margin-top: 10px;">
                                    </p>
                                </div>



                            </div>


                            <div class="step-buttons">
                                <span></span>
                                <div class="sticky-footer-btn">
                                    <div class="mabrook-saving-banner d-none">
                                        <span>🎉 Mabrook! You are saving</span> <span class="price-wrapper"><span
                                                class="currency_dhiramnew" style="font-size: 12px;">AED</span><span
                                                class="mabrook-saving-amount">0.00</span></span>.
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 col-lg-6 col-sm-6 col-8">
                                            <div class="mobile_totalnew">
                                                <div class="font-weight-bold">
                                                    {{-- <div class="cross_amount_div" style="display: none;">

                                                        <span class="currency_dhiramnew">AED</span>
                                                        <span class="cross_amount"
                                                            style="text-decoration: line-through;"></span>
                                                    </div> --}}
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
                                            <button class="btn btn-primary custome-black" onclick="nextStep()"
                                                type="button">Next</button>
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
                                        onclick="prevStep()">Back</button>
                                    <div class="sticky-footer-btn">
                                        <div class="mabrook-saving-banner d-none">
                                            <span>🎉 Mabrook! You are saving</span> <span class="price-wrapper"><span
                                                    class="currency_dhiramnew"
                                                    style="font-size: 12px;">AED</span><span
                                                    class="mabrook-saving-amount">0.00</span></span>.
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-md-8 col-lg-6 col-sm-6 col-8">
                                                <div class="mobile_totalnew">
                                                    <div class="font-weight-bold">
                                                        {{-- <div class="cross_amount_div" style="display: none;">

                                                            <span class="currency_dhiramnew">AED</span>
                                                            <span class="cross_amount"
                                                                style="text-decoration: line-through;"></span>
                                                        </div> --}}
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
                                                    onclick="nextStep()">Next</button>
                                            </div>
                                        </div>

                                    </div>
                                    {{-- <button class="btn btn-primary" onclick="nextStep()">Next</button> --}}
                                </div>

                            </div>
                        @endif
                        <!-- Step 3: Address -->

                        <div class="step-content" id="step3">
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

                                <select class="form-control" name="city" id="city"
                                    onchange="cleaner_check();">
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

                            <div class="step-buttons">
                                <button class="btn btn-secondary custome-black" onclick="prevStep()"
                                    type="button">Back</button>
                                <div class="sticky-footer-btn">
                                    <div class="mabrook-saving-banner d-none">
                                        <span>🎉 Mabrook! You are saving</span> <span class="price-wrapper"><span
                                                class="currency_dhiramnew" style="font-size: 12px;">AED</span><span
                                                class="mabrook-saving-amount">0.00</span></span>.
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 col-lg-6 col-sm-6 col-8">
                                            <div class="mobile_totalnew">
                                                <div class="font-weight-bold">
                                                    {{-- <div class="cross_amount_div" style="display: none;">

                                                        <span class="currency_dhiramnew">AED</span>
                                                        <span class="cross_amount"
                                                            style="text-decoration: line-through;"></span>
                                                    </div> --}}
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
                                            <button class="btn btn-primary custome-black" onclick="nextStep()"
                                                type="button">Next</button>
                                        </div>
                                    </div>

                                </div>
                                {{-- <button class="btn btn-primary" onclick="nextStep()">Next</button> --}}
                            </div>
                        </div>




                        <!-- Step 4: Payment -->

                        <div class="step-content" id="step4">
                            {{-- <h3>Date & Address</h3> --}}
                            <div class="booking-step">

                                <div id="cleaner_section">

                                    <div class="form-group mb-3">
                                        <label class="form-label fw500 dark-color" for="country">Select your
                                            preferred cleaner</label>

                                        @php
                                            $firstCleaner = DB::table('users')
                                                ->where('role_id', '16')
                                                ->where('is_active', 0)
                                                ->whereRaw('FIND_IN_SET(?, city)', [17])
                                                ->whereRaw('FIND_IN_SET(?, service)', [$service_id])
                                                ->whereRaw('FIND_IN_SET(?, subservice)', [$subservice_id])
                                                ->orderBy('id', 'asc') // Ensures the first cleaner is prioritized
                                                ->limit(1);

                                            $otherCleaners = DB::table('users')
                                                ->where('role_id', '16')
                                                ->where('is_active', 0)
                                                //->where('area', 'LIKE', '%' . $user_data->area . '%')
                                                ->whereRaw('FIND_IN_SET(?, city)', [17])
                                                ->whereRaw('FIND_IN_SET(?, service)', [$service_id])
                                                ->whereRaw('FIND_IN_SET(?, subservice)', [$subservice_id]);

                                            $cleaners = $firstCleaner->union($otherCleaners)->get();

                                        @endphp
                                        <div id="select_your_cleaner_slider_spatie" class="splide radio-group">
                                            <div class="splide__track">
                                                <ul class="splide__list" id="cleaner_slider_ul">
                                                    @foreach ($cleaners as $data)
                                                        {{-- <li class="splide__slide text-center">
                                                            <div class="cleaners-div"
                                                                onclick="cleaner_data('{{ $data->id }}', '{{ $data->name }}');">
                                                                <div class="items">
                                                                    <input type="radio" id="cleaner_{{ $data->id }}"
                                                                        name="cleaner" class="cleaners-radio"
                                                                        value="{{ $data->name }}" data-cleaner-id={{
                                                                        $data->id }}>

                                                                    <div class="cleaner-image">
                                                                        <img src="{{ asset('public/upload/cleaners/large/' . $data->profile_image) }}"
                                                                            class="cleaners-image-style">
                                                                    </div>

                                                                    <div class="cleaner-detail">

                                                                        @if ($data->id != 2)
                                                                        <a style="cursor: pointer;" data-bs-toggle="modal"
                                                                            data-bs-target="#cleaner_description_{{ $data->id }}">
                                                                            <p class="cleaner-name">
                                                                                {{ $data->name }}
                                                                            </p>
                                                                        </a>
                                                                        @else
                                                                        <a style="cursor: pointer;">
                                                                            <p class="cleaner-name">
                                                                                {{ $data->name }}
                                                                            </p>
                                                                        </a>
                                                                        @endif

                                                                        @if ($data->id != 2)
                                                                        <p class="cleaner-nationality">
                                                                            {{ $data->nationality }}
                                                                        </p>
                                                                        <p class="cleaners-para">Recommended in
                                                                            your Area</p>
                                                                        @else
                                                                        <p>&nbsp;</p>
                                                                        <p class="cleaners-para">Best in Your Area
                                                                        </p>
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li> --}}
                                                        <li class="splide__slide">
                                                            <div class="cleaner-selection-card {{ $loop->first ? 'selected' : '' }}"
                                                                onclick="cleaner_data(this,'{{ $data->id }}', '{{ $data->name }}');">

                                                                <input type="radio"
                                                                    id="cleaner_{{ $data->id }}" name="cleaner"
                                                                    class="cleaners-radio"
                                                                    value="{{ $data->name }}"
                                                                    data-cleaner-id="{{ $data->id }}"
                                                                    {{ $loop->first ? 'checked' : '' }}>

                                                                <div class="cleaner-card-avatar">
                                                                    <img src="{{ asset('public/upload/cleaners/large/' . $data->profile_image) }}"
                                                                        alt="{{ $data->name }}">
                                                                    @if ($data->id != 2)
                                                                        <div class="cleaner-info-badge">
                                                                            <i class="fa-solid fa-star"
                                                                                style="color: #FFD700; font-size: 10px;"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                                <div class="cleaner-card-name">
                                                                    @if ($data->id != 2)
                                                                        <a href="javascript:void(0)" class="mt-2"
                                                                            style="color: #0040E6;  font-weight: 600;"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#cleaner_description_{{ $data->id }}">{{ $data->name }}</a>
                                                                    @else
                                                                        <a href="javascript:void(0)" class="mt-2"
                                                                            style="color: #0040E6;  font-weight: 600;">{{ $data->name }}</a>
                                                                    @endif

                                                                </div>

                                                                @if ($data->id != 2)
                                                                    <div class="cleaner-card-meta">
                                                                        {{ $data->nationality }}
                                                                    </div>
                                                                    <div class="cleaner-card-tag">Recommended</div>

                                                                    {{-- <a href="javascript:void(0)" class="mt-2"
                                                                        style="font-size: 10px; color: #0040E6; text-decoration: underline; font-weight: 600;"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#cleaner_description_{{ $data->id }}">
                                                                        View Profile
                                                                    </a> --}}
                                                                @else
                                                                    <div class="cleaner-card-meta">Best Availability
                                                                    </div>
                                                                    <div class="cleaner-card-tag">Flexible</div>
                                                                @endif
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                {{-- <h5>When would you like your service?</h5> --}}

                                <div class="form-group">
                                    <label class="form-label fw500 dark-color wwylys" for="country">When would you
                                        like your
                                        service?</label>
                                </div>

                                <div class="date-slider-wrapper">
                                    <button class="arrow left" type="button">&lt;</button>

                                    <div class="date-slider" id="dateSlider"></div>

                                    <button class="arrow right" type="button">&gt;</button>
                                </div>

                                <div class="form-group mb-3 mt5">
                                    <label class="form-label fw500 dark-color" for="country">What time would you like
                                        us to start?</label>
                                    <div class="radio-group time-slot-grid time_replace_ab">
                                        @php $i = 1; @endphp

                                        @foreach ($timeslot as $timeslot_data)
                                            @php
                                                $timeslot_service = DB::table('subservice_timeslot_price')
                                                    ->where('subservice_id', $subservice_id)
                                                    ->where('time_slot_id', $timeslot_data->id)
                                                    ->where('is_active', 1)
                                                    ->first();

                                                $price =
                                                    $timeslot_service && $timeslot_service->price > 0
                                                        ? $timeslot_service->price
                                                        : 0;
                                            @endphp

                                            @if ($timeslot_service)
                                                <div class="surcharge-badge-timeslot items">
                                                    @if ($price > 0)
                                                        <span class="badgespantime"><span>+</span> <span
                                                                class="currency_dhiramnew">AED</span><span>{{ $price }}</span></span>
                                                    @endif

                                                    <input type="radio" id="time{{ $i }}"
                                                        name="time_slot" value="{{ $timeslot_data->id }}"
                                                        data-name="{{ $timeslot_data->name }}"
                                                        data-price="{{ $price }}">

                                                    <label for="time{{ $i }}" class="labeltime"
                                                        style="border-radius:50px;">
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
                                @if (!empty($subservice_data->cancel_policy))
                                    <div class="addonsinstruction">
                                        <h5 class=""> <i
                                                class="fas fa-info-circle tabby-banner-info-icon ms-2"></i>
                                            Enjoy free cancellation up to 6 hours before your booking start time.</h5>
                                        <div class="text-end" style="margin-right:28px">
                                            <a href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#cancelPolicyModal"
                                                style="text-decoration: underline; color: #150495; font-size: 13px; font-weight: 600;">View
                                                Policy</a>
                                        </div>
                                    </div>

                                    <!-- Cancel Policy Modal -->
                                    <div class="modal subservice-read-more-model fade" id="cancelPolicyModal"
                                        tabindex="-1" aria-hidden="true" style="z-index: 9999;">
                                        <div class="modal-dialog modal-dialog-scrollable" id="modal-digi"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-drag-handle"
                                                    style="padding:10px 0 4px; text-align:center;">
                                                    <div
                                                        style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;">
                                                    </div>
                                                </div>
                                                <div class="modal-header"
                                                    style="border-bottom:1px solid #f0f0f0; padding:12px 20px; display:flex; align-items:center; justify-content:space-between;">
                                                    <h5 class="modal-title"
                                                        style="margin:0; font-size:1rem; font-weight:800; color:#111;">
                                                        Cancellation Policy</h5>
                                                    <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                                        style="background:#f4f4f4; border:none; width:32px; height:32px; border-radius:50%; font-size:1.1rem; color:#555; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body"
                                                    style="padding:20px; overflow-y:scroll; -webkit-overflow-scrolling:touch;">
                                                    {!! $subservice_data->cancel_policy !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="step-buttons">
                                <button class="btn btn-secondary custome-black" onclick="prevStep()"
                                    type="button">Back</button>
                                <div class="sticky-footer-btn">
                                    <div class="mabrook-saving-banner d-none">
                                        <span>🎉 Mabrook! You are saving</span> <span class="price-wrapper"><span
                                                class="currency_dhiramnew" style="font-size: 12px;">AED</span><span
                                                class="mabrook-saving-amount">0.00</span></span>.
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 col-lg-6 col-sm-6 col-8">
                                            <div class="mobile_totalnew">
                                                <div class="font-weight-bold">
                                                    {{-- <div class="cross_amount_div" style="display: none;">

                                                        <span class="currency_dhiramnew">AED</span>
                                                        <span class="cross_amount"
                                                            style="text-decoration: line-through;"></span>
                                                    </div> --}}
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
                                            <button class="btn btn-primary custome-black" onclick="nextStep()"
                                                type="button">Next</button>
                                        </div>
                                    </div>

                                </div>
                                {{-- <button class="btn btn-primary" onclick="nextStep(4)">Next</button> --}}
                            </div>
                        </div>


                        <!-- Step 5: Payment Information -->
                        <div class="step-content" id="step5">
                            {{-- <h3>Payment Information</h3> --}}

                            {{-- <div class="tabby-promo-box"
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
                            </div> --}}
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

                                    <!-- <label class="payment-method-card" for="paymet_1">
                                        <input type="radio" id="paymet_1" name="payment_type" value="COD">
                                        <div class="payment-card-content">
                                            <div class="payment-card-header">
                                                <div class="payment-name">
                                                    <span class="payment-radio-circle"></span>
                                                    Cash
                                                </div>
                                            </div>
                                            <p class="cash_fee price-wrapper"><span>+</span> <span
                                                    class="currency_dhiramnew">AED</span>
                                                <span>{{ \App\Enums\VC_ChargiesEnum::COD->percentage() }}</span>
                                                <span> Cash handling
                                                    charges will be applied.</span>
                                            </p>
                                        </div>
                                    </label> -->

                                    {{-- <label class="payment-method-card" for="paymet_3">
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
                                        </div>
                                    </label> --}}
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
                                                                style="color: #16a34a; font-weight: 700; font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0; letter-spacing: 0.5px;">
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
                                                                    <span class="currency_dhiramnew">AED</span>
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
                            <div class="step-buttons">
                                <button class="btn btn-secondary custome-black" type="button"
                                    onclick="prevStep()">Back</button>

                                <div class="sticky-footer-btn">
                                    <div class="mabrook-saving-banner d-none">
                                        <span>🎉 Mabrook! You are saving</span> <span class="price-wrapper"><span
                                                class="currency_dhiramnew" style="font-size: 12px;">AED</span><span
                                                class="mabrook-saving-amount">0.00</span></span>.
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 col-lg-6 col-sm-6 col-7">
                                            <div class="mobile_totalnew">
                                                <div class="font-weight-bold">
                                                    {{-- <div class="cross_amount_div" style="display: none;">

                                                        <span class="currency_dhiramnew">AED</span>
                                                        <span class="cross_amount"
                                                            style="text-decoration: line-through;"></span>
                                                    </div> --}}
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

                    <input type="hidden" name="cleaner_id" id="cleaner_id" value="2">
                    <input type="hidden" name="cleaner_name" id="cleaner_name" value="Auto Assign">

                    <input type="hidden" name="service_charge" id="service_charge" value="78">
                    <input type="hidden" name="timing_charge" id="timing_charge" value="">
                    <input type="hidden" name="date_charge" id="date_charge" value="">
                    <input type="hidden" name="t_charge" id="t_charge" value="">
                    <input type="hidden" name="package_charge" id="package_charge" value="">
                    <input type="hidden" name="additional_charge" id="additional_charge" value="0">
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
                    <input type="hidden" id="wallet_balance" name="wallet_balance"
                        value="{{ isset($wallet_amount) ? $wallet_amount : 0 }}">

                    <input type="hidden" name="hour_charge_db" id="hour_charge_db" value="">
                    <input type="hidden" name="cleaning_material_charge_db" id="cleaning_material_charge_db"
                        value="">

                    <input type="hidden" name="no_of_hours" id="no_of_hours" value="4">
                    <input type="hidden" name="no_of_cleaners" id="no_of_cleaners" value="1">
                    <input type="hidden" name="frequency" id="frequency" value="Once">
                    <input type="hidden" name="days_of_the_week" id="days_of_the_week" value="">

                </form>
            </div>
            <div class="col-lg-4 col-md-4 sol-sm-12">
                <div class="sidebar sidebar-summary" id="rightSidebar">

                    <div class="font-weight-bold-summary h5 servicedetail_heading marginfiverem">Service Details</div>
                    <div class="d-flex justify-content-between subheadingdev">
                        <div>Service</div>
                        <div class="font-weight-bold sm-summary">
                            {{ $subservice_data->subservicename }}
                        </div>
                    </div>

                    <div class="d-flex justify-content-between subheadingdev d-none no_of_cleaners_div">
                        <div>No. of Cleaners</div>
                        <div class="font-weight-bold sm-summary">
                            <span class="cleaners_summary">1</span> Cleaner(s)
                        </div>
                    </div>
                    <div class="d-flex justify-content-between subheadingdev d-none hours_div">
                        <div>No. of Hours</div>
                        <div class="font-weight-bold sm-summary">
                            <span class="hours_summary">1</span> Hours
                        </div>
                    </div>
                    <div class="d-flex justify-content-between subheadingdev materials_div">
                        <div>Materials</div>
                        <div class="font-weight-bold sm-summary">
                            <span class="material_summary">No</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between subheadingdev d-none frequency_div">
                        <div>Frequency</div>
                        <div class="font-weight-bold sm-summary">
                            <span class="frequency_summary">Once</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between subheadingdev d-none frequency_days_div">
                        <div>Days of the week</div>
                        <div class="font-weight-bold sm-summary">
                            <span class="frequency_summary_days"></span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between subheadingdev d-none cleaners_name_div">
                        <div>Cleaner Name</div>
                        <div class="font-weight-bold sm-summary">
                            <span class="cleaner_name">Test Cleaner</span>
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
                    {{-- <div class="d-flex justify-content-between cart-row">
                        <div>Add ons package * 1
                            <!--<a href="javascript:void(0)" class="remove-item" data-id="${id}">
                                <span class="flaticon-delete"></span>
                            </a>-->
                        </div>
                        <div class="font-weight-bold sm-summary">
                            <span class="currency_dhiramnew">AED</span>
                            120
                        </div>
                    </div> --}}

                    {{-- <div id="cart_item_list">
                        <div class="d-flex justify-content-between">
                            <div>Add ons package * 1
                                <a href="javascript:void(0)" onclick="remove_to_cart_book_now(); return false;">
                                    <span class="flaticon-delete"></span>
                                </a>
                            </div>
                            <div class="font-weight-bold sm-summary">
                                <span id="frequency_left_summary_replace">
                                    <span class="currency_dhiramnew">AED</span>
                                    500
                                </span>
                            </div>
                        </div>
                    </div> --}}
                    <div class="font-weight-bold-summary h5 summarydev marginfiverem">Payment Details</div>
                    {{-- <div class="d-flex justify-content-between subheadingdev service-charge-div d-none">
                        <div>Service Charges</div>
                        <div class="font-weight-bold sm-summary price-wrapper">
                            <span class="currency_dhiramnew">AED</span>
                            <span class="service_charge">0.00</span>
                        </div>
                    </div> --}}

                    {{-- <div class="d-flex justify-content-between subheadingdev d-none timing-charge-div">

                        <div>Timing fee</div>
                        <div class="font-weight-bold sm-summary price-wrapper">
                            <span class="currency_dhiramnew">AED</span>
                            <span class="timing_charge"></span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between subheadingdev d-none cod-charge-div">
                        <div>Delivery charge</div>
                        <div class="font-weight-bold sm-summary price-wrapper">
                            <span class="currency_dhiramnew">AED</span>
                            <span class="cod_charge"></span>
                        </div>
                    </div> --}}


                    {{-- <div class="d-flex justify-content-between subheadingdev d-none additional-charge-div">
                        <div>Material Charges</div>
                        <div class="font-weight-bold sm-summary price-wrapper">
                            <span class="currency_dhiramnew">AED</span>
                            <span class="additional_charge"></span>
                        </div>
                    </div> --}}

                    <div class="d-flex justify-content-between subheadingdev d-none subtotal-div">
                        <div>Sub Total</div>
                        <div class="font-weight-bold sm-summary price-wrapper">
                            <span class="currency_dhiramnew">AED</span>
                            <span class="sub_total">0.00</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between subheadingdev d-none vat-div align-items-center">
                        <div>VAT ({{ \App\Enums\VC_ChargiesEnum::VAT_PERCENT->percentage() }}%)</div>
                        <div class="font-weight-bold sm-summary price-wrapper">
                            <span class="currency_dhiramnew">AED</span>
                            <span class="vat_charge">0</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between d-none service-fee-div">
                        <div>Service Fee @if ($subservice_data->service_fee_popup != '')
                                <a data-bs-toggle="modal" data-bs-target="#service_fee_popup_{{ $subservice_id }}"
                                    style="cursor:pointer; line-height:1;">
                                    <img src="{{ asset('public/site/images/infoicon.svg') }}"
                                        style="height:14px; width:14px; vertical-align:middle;">
                                </a>
                            @endif
                        </div>
                        <div class="font-weight-bold sm-summary">
                            <span class="currency_dhiramnew">AED</span>
                            <span class="service_fee">0.00</span>
                        </div>
                    </div>
                    <div class="subheadingdev">
                        <div class="d-flex justify-content-between subheadingdev d-none promo_dicount_replace_div">
                            <div>Promo Code</div>
                            <a href="javascript:void(0)" onclick="remove_coupon();"><span
                                    class="flaticon-delete"></span>
                            </a>

                            <div class="font-weight-bold sm-summary subheadingdev price-wrapper" style="">
                                - <span class="currency_dhiramnew">AED</span>
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

                        <div class="d-flex justify-content-between subheadingdev d-none promo_name_replace_div">
                            <div>Applied Promo Code</div>
                            <div class="font-weight-bold sm-summary">
                                <span class="promo_code_name">ABC</span>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="d-flex justify-content-center mt-2 is-r font-weight-bold-summary">
                        <h5>Total to pay</h5>
                    </div> --}}
                    <div class="left-summary-total d-flex  align-items-center">
                        <div class="cross_amount_div " style="display: none;">
                            <strong class="price-wrapper">
                                <span class="currency_dhiramnew">AED</span>
                                <span class="cross_amount" style="text-decoration: line-through;"></span>
                            </strong>
                        </div>
                        <strong>
                            <div class="price-wrapper">
                                <span class="currency_dhiramnew">AED</span>
                                <span class="total_to_pay">0.00</span>
                            </div>
                        </strong>
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

<div class="modal subservice-read-more-model" id="exampleModalLong" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" id="modal-digi" role="document">
        <div class="modal-content">
            <div class="modal-drag-handle" style="padding:10px 0 4px; text-align:center;">
                <div style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;"></div>
            </div>
            <div class="modal-header"
                style="border-bottom:1px solid #f0f0f0; padding:12px 20px; display:flex; align-items:center; justify-content:space-between;">
                <h5 class="modal-title" style="margin:0; font-size:1rem; font-weight:800; color:#111;">What's Included
                </h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close"
                    style="background:#f4f4f4; border:none; width:32px; height:32px; border-radius:50%; font-size:1.1rem; color:#555; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                    &times;
                </button>
            </div>
            <div class="modal-body" style="padding:20px; overflow-y:scroll; -webkit-overflow-scrolling:touch;">
                <p style="font-size:0.92rem; color:#444; line-height:1.7; margin-bottom:14px;">
                    Transform your living space into a sanctuary of cleanliness and comfort with our
                    professional home cleaning services. Whether you need regular upkeep or deep cleaning, our
                    experienced team ensures every nook and cranny shines, leaving you with more time to relax
                    and enjoy your home.
                </p>
                <h6 style="font-size:0.95rem; font-weight:800; color:#111; margin-bottom:10px;">Our Services Include:
                </h6>
                <ul style="list-style:disc; padding-left:20px; color:#444; font-size:0.9rem; line-height:2;">
                    <li>Thorough dusting and wiping of all surfaces</li>
                    <li>Vacuuming and mopping of floors</li>
                    <li>Cleaning and sanitizing bathrooms</li>
                    <li>Kitchen cleaning: countertops, sinks, appliances</li>
                    <li>Bedroom cleaning: bed-making, dusting, tidying</li>
                    <li>Additional services: laundry, interior window cleaning, fridge and oven cleaning</li>
                </ul>
                <p style="font-size:0.88rem; color:#777; margin-top:14px; line-height:1.6;">Experience the convenience
                    and peace of mind that comes with a meticulously cleaned home.</p>
            </div>
        </div>
    </div>
</div>

<div class="modal subservice-read-more-model" id="Learnmore" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-drag-handle" style="padding:10px 0 4px; text-align:center;">
                <div style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;"></div>
            </div>
            <div class="modal-header"
                style="border-bottom:1px solid #f0f0f0; padding:12px 20px; display:flex; align-items:center; justify-content:space-between;">
                <h5 style="margin:0; font-size:1rem; font-weight:800; color:#111;">How Long Should I Book For?</h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close"
                    style="background:#f4f4f4; border:none; width:32px; height:32px; border-radius:50%; font-size:1.1rem; color:#555; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                    &times;
                </button>
            </div>
            <div class="modal-body" style="padding:16px; overflow-y:scroll; -webkit-overflow-scrolling:touch;">
                <img src="{{ asset('public/site/images/homecleaninghour1.png') }}" alt="Cleaning Time"
                    style="width:100%; border-radius:12px;">
            </div>
        </div>
    </div>
</div>

<div class="modal subservice-read-more-model" id="material" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-drag-handle" style="padding:10px 0 4px; text-align:center;">
                <div style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;"></div>
            </div>
            <div class="modal-header"
                style="border-bottom:1px solid #f0f0f0; padding:12px 20px; display:flex; align-items:center; justify-content:space-between;">
                <h5 style="margin:0; font-size:1rem; font-weight:800; color:#111;">What We Bring</h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close"
                    style="background:#f4f4f4; border:none; width:32px; height:32px; border-radius:50%; font-size:1.1rem; color:#555; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                    &times;
                </button>
            </div>
            <div class="modal-body" style="padding:20px; overflow-y:scroll; -webkit-overflow-scrolling:touch;">
                <h6 style="font-size:0.95rem; font-weight:800; color:#111; margin-bottom:10px;">Cleaning Equipment:
                </h6>
                <ul style="list-style:disc; padding-left:20px; color:#444; font-size:0.9rem; line-height:2;">
                    <li>Vacuum cleaner (with appropriate attachments)</li>
                    <li>Mop and bucket</li>
                    <li>Broom and dustpan</li>
                    <li>Microfiber mops or cloths</li>
                    <li>Scrub brushes or sponges</li>
                </ul>
                <h6 style="font-size:0.95rem; font-weight:800; color:#111; margin:14px 0 10px;">Cleaning Products:
                </h6>
                <ul style="list-style:disc; padding-left:20px; color:#444; font-size:0.9rem; line-height:2;">
                    <li>All-purpose cleaner</li>
                    <li>Glass cleaner</li>
                    <li>Disinfectant wipes or spray</li>
                    <li>Bathroom cleaner</li>
                    <li>Floor cleaner (suitable for the flooring type)</li>
                    <li>Dusting spray or polish</li>
                    <li>Toilet bowl cleaner</li>
                    <li>Paper towels or cleaning rags</li>
                    <li>Trash bags</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@if (isset($addons) && count($addons) > 0)
    @foreach ($addons as $addonsData)
        <div class="modal fade subservice-read-more-model" id="addons-detail-model_{{ $addonsData->id }}"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0">
                    <div class="modal-drag-handle d-none"></div>
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" style="font-size: 1.4rem; color: #000;">
                            {{ $addonsData->name ?? '' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-4">
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

                        <div class="mb-3">
                            {{ $addonsData->short_desc }}
                        </div>
                        <hr style="border: 1px solid #eee; margin: 20px 0;">
                        <div class="addon-description" style="color: #444; line-height: 1.6;">
                            {!! html_entity_decode($addonsData->description) !!}
                        </div>
                    </div>

                    <div class="modal-footer modal-footer-sticky border-0 p-4 pt-0">
                        <div class="addon-action-modal w-100 d-flex justify-content-between align-items-center"
                            style="background: #f8f9fa; padding: 15px 25px; border-radius: 16px;">
                            <div class="addon-modal-price">
                                <span class="price-addons-modal"
                                    style="font-size: 1.3rem; font-weight: 800; color: #111;">
                                    <span class="currency_dhiramnew">AED</span>
                                    {{ number_format($priceaddons, 0) }}
                                </span>
                            </div>
                            <div class="addon-controls">
                                <button type="button" class="addons-addbutton modal-add-btn"
                                    data-id="{{ $addonsData->id }}" data-name="{{ $addonsData->name }}"
                                    data-price="{{ $priceaddons }}" data-service="{{ $service_id }}"
                                    data-subservice_id="{{ $subservice_id }}" data-type="addons"
                                    style="background: #0040E6; color: #fff; border: none; padding: 12px 30px; border-radius: 50px; font-weight: 700; font-size: 0.95rem; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                                    Add to Cart
                                </button>

                                <div class="addons-quantity-control modal-quantity-control"
                                    data-id="{{ $addonsData->id }}"
                                    style="display:none; align-items: center; gap: 20px; background: #fff; padding: 8px 12px; border-radius: 50px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #eee;">
                                    <button class="addons-minus-btn" type="button"
                                        style="background: #f4f4f4; border: none; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease; color: #000;"><i
                                            class="fa-solid fa-minus"></i></button>
                                    <span class="addons-quantity"
                                        style="font-weight: 800; font-size: 1.2rem; min-width: 25px; text-align: center; color: #000;">1</span>
                                    <button class="addons-plus-btn" type="button"
                                        style="background: #f4f4f4; border: none; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease; color: #000;"><i
                                            class="fa-solid fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

{{-- @if (isset($allcleaners) && count($allcleaners) > 0)
@foreach ($allcleaners as $data)
<div class="modal subservice-read-more-model" id="cleaner_description_{{ $data->id }}" tabindex="-1"
    aria-labelledby="materialTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="border:none;">
                <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <div
                    style="max-width: 500px; margin: 20px auto; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); text-align: center; font-family: Arial, sans-serif;">
                    <h3 style="font-size: 30px; color: #333; margin-bottom: 20px;">Cleaner Profile</h3>

                    <div style="display: flex; align-items: center; gap: 20px;">
                        <div class="popup-cleaner-image">
                            <img src="{{ url('public/upload/cleaners/large/' . $data->profile_image) }}">
                        </div>
                        <div style="text-align: left; font-size: 18px; color: #555;">
                            <p><strong>Name:</strong> {{ $data->name }}</p>
                            <p><strong>Nationality:</strong> {{ $data->nationality }}</p>
                            <p><strong>Languages:</strong> {{ $data->language }}</p>
                        </div>
                    </div>
                </div>
                <span> {!! html_entity_decode($data->cleaner_desc) !!}</span>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
@endforeach
@endif --}}

@if (isset($allcleaners) && count($allcleaners) > 0)
    @foreach ($allcleaners as $data)
        <div class="modal subservice-read-more-model" id="cleaner_description_{{ $data->id }}" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0" style="border-radius: 20px; overflow: hidden;">
                    <div class="modal-body p-0">
                        <!-- Banner Section -->
                        <div class="cleaner-profile-banner">
                            <div class="banner-bg-blur"
                                style="background-image: url('{{ url('public/upload/cleaners/large/' . $data->profile_image) }}');">
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                style="position: absolute; top: 15px; right: 15px; z-index: 10; filter: brightness(0) invert(1); background-color: rgba(0,0,0,0.2); padding: 10px; border-radius: 50%;"></button>
                        </div>

                        <!-- Profile Header -->
                        <div class="profile-avatar-wrapper">
                            <img src="{{ url('public/upload/cleaners/large/' . $data->profile_image) }}"
                                class="profile-avatar-large" alt="{{ $data->name }}">
                        </div>

                        <div class="profile-main-info">
                            <h4>{{ $data->name }}</h4>
                            <div class="nationality">
                                <i class="fa-solid fa-earth-americas" style="color: #0040E6;"></i>
                                {{ $data->nationality }}
                            </div>
                        </div>

                        <!-- Stats Section -->
                        <div class="profile-stats-container">
                            <div class="stat-pill">
                                <i class="fa-solid fa-language"></i>
                                <div class="stat-pill-content">
                                    <span class="stat-pill-label">Languages</span>
                                    <span class="stat-pill-value">{{ $data->language }}</span>
                                </div>
                            </div>
                            <div class="stat-pill">
                                <i class="fa-solid fa-star" style="color: #FFD700;"></i>
                                <div class="stat-pill-content">
                                    <span class="stat-pill-label">Rating</span>
                                    <span class="stat-pill-value">4.9 (120+)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Bio Section -->
                        <div class="profile-bio-section">
                            <div class="bio-title">About {{ explode(' ', $data->name)[0] }}</div>
                            <div class="bio-text">
                                {!! html_entity_decode($data->cleaner_desc) !!}
                            </div>
                        </div>
                    </div>

                    {{-- <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal"
                            style="border-radius: 50px; padding: 12px; font-weight: 700; background: #000; border: none; font-size: 14px;">
                            Close Profile
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>
    @endforeach
@endif

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
    <div class="modal-dialog modal-summary-sheet modal-dialog-scrollable"
        style="margin:0; position:fixed; bottom:0; left:0; right:0; width:100%; max-width:100%;">
        <div class="modal-content border-0" style="border-radius:20px 20px 0 0; background:#fff; max-height: 85vh;">

            {{-- ── Drag Handle ── --}}
            <div class="modal-drag-handle"
                style="padding:10px 0 6px; text-align:center; cursor:grab; flex-shrink:0;">
                <div style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;"></div>
            </div>

            {{-- ── Header ── --}}
            <div class="modal-header bn-modal-header"
                style="padding: 0.5rem 1.5rem 1rem; border-bottom: 1px solid #eee;">
                <div>
                    <div
                        style="font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.12em; color:#aaa; margin-bottom:2px;">
                        Summary</div>
                    <h5 class="modal-title"
                        style="margin:0; font-size:1.25rem; font-weight:900; color:#000; letter-spacing:-0.02em;">
                        Booking Summary</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- ── Scrollable Body ── --}}
            <div class="modal-body sidebar-summary" style="padding: 1rem 1.5rem 16px;">

                {{-- ─ Your Service Chip ─ --}}
                <div style="background:#0040E6; border-radius:14px; padding:16px 18px; margin-bottom:16px;">
                    <div
                        style="font-size:0.7rem; font-weight:700; letter-spacing:0.1em; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-bottom:6px;">
                        Your Service</div>
                    <div style="font-size:1rem; font-weight:700; color:#fff;">{{ $subservice_data->subservicename }}
                    </div>
                </div>

                {{-- ─ Add-ons (only shown if user has added items) ─ --}}
                @if (isset($addons) && count($addons) > 0)
                    <div class="summary-addons-section" style="margin-bottom:6px; display:none;">
                        <div
                            style="font-size:0.68rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#bbb; margin-bottom:12px; padding-bottom:6px; border-bottom:1px solid #f0f0f0;">
                            Added Items</div>

                        @foreach ($addons as $addonsData)
                            @php
                                $paPrice = $addonsData->price;
                                $paDiscount = 0;
                                if (!empty($addonsData->discount) && isset($addonsData->discount_type)) {
                                    $paDiscount =
                                        $addonsData->discount_type == 0
                                            ? ($addonsData->discount / 100) * $addonsData->price
                                            : $addonsData->discount;
                                    $paPrice -= $paDiscount;
                                }

                                $addonImage = $addonsData->image;
                                $addonImagePath = 'public/upload/addons/' . $addonImage;
                                if (empty($addonImage) || !file_exists(public_path('upload/addons/' . $addonImage))) {
                                    if (strpos(strtolower($addonsData->name), 'balcony') !== false) {
                                        $addonImagePath =
                                            'public/upload/addons/1760765006-1729680028add-on_balcony-cleaning.webp';
                                    } else {
                                        $addonImagePath = 'public/upload/addons/1760766270-no-image.png';
                                    }
                                }
                            @endphp
                            <div class="summary-addon-row"
                                style="display:flex; align-items:center; justify-content:space-between; padding:10px 0; border-bottom:1px solid #f8f8f8;">

                                {{-- Left: Image + Text --}}
                                <div style="display:flex; align-items:center; gap:12px; flex:1; min-width:0;">
                                    <div
                                        style="width:48px; height:48px; border-radius:10px; overflow:hidden; flex-shrink:0; background:#f5f5f5;">
                                        <img src="{{ asset($addonImagePath) }}" alt="{{ $addonsData->name }}"
                                            style="width:100%; height:100%; object-fit:cover;">
                                    </div>
                                    <div style="min-width:0;">
                                        <div
                                            style="font-size:0.88rem; font-weight:700; color:#111; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                            {{ $addonsData->name }}
                                        </div>
                                        <div style="font-size:0.82rem; color:#777; margin-top:2px;">
                                            <span class="price-wrapper"
                                                style="font-weight:800; color:#111; font-size:0.9rem;">
                                                <span
                                                    class="currency_dhiramnew">AED</span>{{ number_format($paPrice, 0) }}
                                            </span>
                                            @if ($paDiscount > 0)
                                                <span class="price-wrapper"
                                                    style="text-decoration:line-through; color:#ccc !important; margin-left:5px; font-size:0.78rem;">
                                                    <span
                                                        class="currency_dhiramnew">AED</span>{{ number_format($addonsData->price, 0) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Right: Controls --}}
                                <div style="flex-shrink:0; margin-left:10px;">
                                    {{-- + Add button (shown when not in cart) --}}
                                    <button type="button" class="addons-addbutton"
                                        data-id="{{ $addonsData->id }}" data-name="{{ $addonsData->name }}"
                                        data-price="{{ $paPrice }}" data-service="{{ $service_id }}"
                                        data-subservice_id="{{ $subservice_id }}" data-type="addons"
                                        style="background:#0040E6; color:#fff; border:none; height:32px; padding:0 14px; border-radius:8px; font-size:0.8rem; font-weight:700; display:flex; align-items:center; gap:5px; white-space:nowrap;">
                                        <i class="fa-solid fa-plus" style="font-size:0.65rem;"></i> Add
                                    </button>

                                    {{-- − qty + pill (shown when in cart) --}}
                                    <div class="addons-quantity-control" data-id="{{ $addonsData->id }}"
                                        style="display:none; align-items:center; gap:0; background:#f5f5f5; border-radius:8px; overflow:hidden; height:32px;">
                                        <button class="addons-minus-btn" type="button"
                                            style="background:transparent; border:none; width:34px; height:32px; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#000; font-size:0.9rem;">
                                            <i class="fa-solid fa-minus" style="font-size:0.65rem;"></i>
                                        </button>
                                        <span class="addons-quantity"
                                            style="font-weight:800; font-size:0.95rem; min-width:22px; text-align:center; color:#000; line-height:32px;">1</span>
                                        <button class="addons-plus-btn" type="button"
                                            style="background:#0040E6; border:none; width:34px; height:32px; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#fff;">
                                            <i class="fa-solid fa-plus" style="font-size:0.65rem;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- ─ Cart Items (selected packages) ─ --}}
                <div class="sidebar-cart" style="margin:14px 0 0; font-size:0.88rem;padding: 16px;"></div>

                {{-- ─ Payment Summary Card ─ --}}
                <div style="background:#f8f8f8; border-radius:14px; padding:16px; margin-top:16px;">
                    <div
                        style="font-size:0.7rem; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:#aaa; margin-bottom:12px;">
                        Payment Summary</div>

                    {{-- <div class="d-flex justify-content-between py-1 service-charge-div d-none">
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
                        <span style="font-size:0.85rem; color:#555; display:flex; align-items:center; gap:5px;">Delivery
                            Charge
                            @if ($subservice_data->delivery_charge_popup != '')
                            <a data-bs-toggle="modal" data-bs-target="#delivery_charge_popup_{{ $subservice_id }}"
                                style="cursor:pointer; line-height:1;">
                                <img src="{{ asset('public/site/images/infoicon.svg') }}"
                                    style="height:14px; width:14px; vertical-align:middle;">
                            </a>
                            @endif
                        </span>
                        <span style="font-size:0.85rem; font-weight:700; color:#111;" class="price-wrapper">
                            <span class="currency_dhiramnew">AED</span><span class="cod_charge"></span>
                        </span>
                    </div> --}}

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
                    <div class="d-flex justify-content-between py-1 d-none service-fee-div align-items-center">
                        <span
                            style="font-size:0.85rem; color:#555; display:flex; align-items:center; gap:5px;">Service
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

                    {{-- Promo Applied --}}
                    <div class="subheadingdev">
                        <div
                            class="d-flex justify-content-between py-1 align-items-center d-none promo_dicount_replace_div">
                            <span style="font-size:0.85rem; color:#555;">Coupon Discount</span>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="font-size:0.82rem; font-weight:800; color:#16a34a;"
                                    class="price-wrapper">
                                    − <span class="currency_dhiramnew">AED</span><span
                                        class="promo_code">0.00</span>
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

                {{-- ─ Promo Code Input ─ --}}
                {{-- <div style="margin-top:14px; display:flex; gap:8px;">
                    <input type="text" name="promo_code1" id="promo_code1" placeholder="Enter promo code"
                        style="flex:1; border:1.5px solid #e5e5e5; border-radius:10px; padding:10px 14px; font-size:0.85rem; color:#111; outline:none;">
                    <button onclick="apply_promo(1);"
                        style="background:#0040E6; color:#fff; border:none; padding:10px 18px; border-radius:10px; font-weight:700; font-size:0.82rem; white-space:nowrap; letter-spacing:0.02em;">
                        Apply
                    </button>
                </div> --}}

                <div style="height:16px;"></div>
            </div>

            {{-- ── Sticky Footer ── --}}
            <div class="modal-footer"
                style="padding:12px 20px; background:#fff; border-top:1px solid #f0f0f0; display:flex; align-items:center; justify-content:space-between; width:100%;">
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
<!--- Delivery Charge Popup Start ---->
<div class="modal subservice-read-more-model" id="delivery_charge_popup_{{ $subservice_id }}" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-drag-handle" style="padding:10px 0 4px; text-align:center;">
                <div style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;"></div>
            </div>
            <div class="modal-header"
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
<!--- Delivery Charge Popup End ---->

<!--- Tabby Info Popup Start ---->
<div class="modal subservice-read-more-model" id="tabby_info_popup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #f5f7f9; border: none; border-radius: 20px 20px 0 0;">
            <div class="modal-drag-handle" style="padding:10px 0 4px; text-align:center;">
                <div style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;"></div>
            </div>
            <div class="modal-header"
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

                <!-- 4 payments Card -->
                <div
                    style="background: #fff; border-radius: 16px; padding: 18px; margin-bottom: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display:flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-size: 1rem; font-weight: 700; color: #111; margin-bottom: 4px;">4 payments
                        </div>
                        <div style="font-size: 0.85rem; color: #16a34a; font-weight: 600;">No interest. No fees.</div>
                    </div>
                    <div style="text-align: right; font-weight: 700; color: #111;">
                        <span class="currency_dhiramnew" style="font-size:0.85rem;">AED</span> <span
                            id="tabby_split_amount">0.00</span>/mo
                    </div>
                </div>

                <!-- 6 payments Card -->
                <div
                    style="background: #fff; border-radius: 16px; padding: 18px; margin-bottom: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display:flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-size: 1rem; font-weight: 700; color: #111; margin-bottom: 4px;">6 payments
                        </div>
                        <div style="font-size: 0.85rem; color: #666; font-weight: 500;">Includes AED 0.73 monthly fee
                        </div>
                    </div>
                    <div style="text-align: right; font-weight: 700; color: #111;">
                        <span class="currency_dhiramnew" style="font-size:0.85rem;">AED</span> <span
                            id="tabby_split_amount_6">0.00</span>/mo
                    </div>
                </div>

                <!-- 8 payments Card -->
                <div
                    style="background: #fff; border-radius: 16px; padding: 18px; margin-bottom: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display:flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-size: 1rem; font-weight: 700; color: #111; margin-bottom: 4px;">8 payments
                        </div>
                        <div style="font-size: 0.85rem; color: #666; font-weight: 500;">Includes AED 0.99 monthly fee
                        </div>
                    </div>
                    <div style="text-align: right; font-weight: 700; color: #111;">
                        <span class="currency_dhiramnew" style="font-size:0.85rem;">AED</span> <span
                            id="tabby_split_amount_8">0.00</span>/mo
                    </div>
                </div>

                <!-- 12 payments Card -->
                <div
                    style="background: #fff; border-radius: 16px; padding: 18px; margin-bottom: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display:flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-size: 1rem; font-weight: 700; color: #111; margin-bottom: 4px;">12 payments
                        </div>
                        <div style="font-size: 0.85rem; color: #666; font-weight: 500;">Includes AED 1.24 monthly fee
                        </div>
                    </div>
                    <div style="text-align: right; font-weight: 700; color: #111;">
                        <span class="currency_dhiramnew" style="font-size:0.85rem;">AED</span> <span
                            id="tabby_split_amount_12">0.00</span>/mo
                    </div>
                </div>

                <!-- Pay Next Month Card -->
                <div
                    style="background: #fff; border-radius: 16px; padding: 18px; margin-bottom: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                    <div
                        style="display:flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px;">
                        <div style="font-size: 1rem; font-weight: 700; color: #111;">Pay Next Month</div>
                        <div
                            style="background: #e6f0ff; color: #0040E6; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 50px;">
                            No down payment</div>
                    </div>
                    <div style="font-size: 0.85rem; color: #16a34a; font-weight: 600; margin-bottom: 2px;">No
                        interest.
                        No fees.</div>
                    <div style="font-size: 0.85rem; color: #666; font-weight: 500;">Pay in Full in one bill next month
                    </div>
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
<!--- Tabby Info Popup End ---->
<!--- Timing Fee Popup Start ---->
{{-- @if ($subservice_data->timing_fee_popup != '')
<div class="modal subservice-read-more-model" id="timing_fee_popup_{{ $subservice_id }}" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-drag-handle" style="padding:10px 0 4px; text-align:center;">
                <div style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;"></div>
            </div>
            <div class="modal-header"
                style="border-bottom:1px solid #f0f0f0; padding:12px 20px; display:flex; align-items:center; justify-content:space-between;">
                <h5 style="margin:0; font-size:1rem; font-weight:800; color:#111;">Timing Fee</h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close"
                    style="background:#f0f0f0; border:none; min-width:44px; min-height:44px; width:44px; height:44px; border-radius:50%; font-size:1.3rem; line-height:1; color:#333; cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0; -webkit-tap-highlight-color:transparent;">
                    &times;
                </button>
            </div>
            <div class="modal-body"
                style="padding:20px; overflow-y:auto; -webkit-overflow-scrolling:touch; max-height:60vh;">
                <p style="color:#444; line-height:1.7; font-size:0.95rem; margin:0;">
                    {{ $subservice_data->timing_fee_popup }}</p>
            </div>
        </div>
    </div>
</div>
@endif --}}
@if ($subservice_data->timing_fee_popup != '')
    <div class="modal subservice-read-more-model" id="timing_fee_popup_{{ $subservice_id }}" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-drag-handle" style="padding:10px 0 4px; text-align:center;">
                    <div style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;"></div>
                </div>
                <div class="modal-header"
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
<div class="modal subservice-read-more-model" id="service_fee_popup_{{ $subservice_id }}" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-drag-handle" style="padding:10px 0 4px; text-align:center;">
                <div style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;"></div>
            </div>
            <div class="modal-header"
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
<!--- Service Fee Popup End ---->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

<script src="{{ asset('public/site/js/homecleaning.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.43/moment-timezone-with-data.min.js"></script>

<script>
    let codCharge = window.Enums.vcCharges.COD.value;
    let vatPercent = window.Enums.vcCharges.VAT_PERCENT.value;
    window.isUserLoggedIn = {{ Session::get('user') ? 'true' : 'false' }};
</script>

<script>
    $(document).ready(function() {
        // Lock both modals on load
        $('#otp_popup_Modal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false // Don't show initially
        });

        $('#email_otp_popup_Modal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        });

        // Show if user not logged in

    });

    function validateStep1() {
        $('#service_fee').val('0');

        var radios = document.getElementsByName('how_often_do_you_need_cleaning');
        var selectedValue = null;

        // Find selected radio button
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                selectedValue = radios[i].value;
                break;
            }
        }

        if (selectedValue === null) {
            Swal.fire({
                icon: 'warning',
                title: 'Please Select How often do you need cleaning',
                confirmButtonColor: '#3085d6',
            });
            return false;
        }

        if (selectedValue === 'Multiple times a week') {

            var checkedDaysCount = jQuery("input[name='which_day_of_the_week_do_you_want_the_service[]']:checked")
                .length;
            if (checkedDaysCount < 2) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Kindly select two days at least',
                    confirmButtonColor: '#3085d6',
                });
                return false;
            }
        }

        return true;
    }

    function validateStep2() {
        $('#service_fee').val('0');

        @if (Session::get('user') == '')
            if (!window.isUserLoggedIn) {
                $('#otp_popup_Modal').modal('show');
                return false;
            }
        @endif
        return true;
    }

    function validateStep3() {

        $('#service_fee').val('0');

        @if (Session::get('user') == '')
            if (!window.isUserLoggedIn) {
                $('#otp_popup_Modal').modal('show');
                return false;
            }
        @endif

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
                confirmButtonColor: '#3085d6',
            });
            return false;
        }

        let building_street_no = $('#building_street_no').val();
        if (!building_street_no) {
            Swal.fire({
                icon: 'warning',
                title: 'Please Enter your building name or street',
                confirmButtonColor: '#3085d6',
            });
            return false;
        }

        let apartment_villa_no = $('#apartment_villa_no').val();
        if (!apartment_villa_no) {
            Swal.fire({
                icon: 'warning',
                title: 'Please Enter your apartment number & floor or villa number',
                confirmButtonColor: '#3085d6',
            });
            return false;
        }

        var address = city + ', ' + area + ', ' + building_street_no + ', ' + apartment_villa_no;

        $('.address_replace').html(address);

        return true;

        return true;
    }

    function validateStep4() {
        // alert('here');
        $('#service_fee').val('0');

        @if (Session::get('user') == '')
            if (!window.isUserLoggedIn) {
                $('#otp_popup_Modal').modal('show');
                return false;
            }
        @endif

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

        $('#service_fee').val('9');

        calculation();
        return true;
    }

    function validateStep5() {

        // alert('5');

        //$('#service_fee').val('0');

        @if (Session::get('user') == '')
            if (!window.isUserLoggedIn) {
                $('#otp_popup_Modal').modal('show');
                return false;
            }
        @endif

        var payment_type = $("input[name='payment_type']:checked").val();
        if (payment_type == 'COD') {
            var charge_text = "Cash on Delivery";
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
    }

    $("input[name='payment_type']").on("change", function() {

        var payment_type = $("input[name='payment_type']:checked").val();

        if (payment_type == 'COD') {
            var charge_payment = codCharge;
        } else {
            var charge_payment = 0;
        }

        $('#cod_charge').val(charge_payment);

        //$('#service_fee').val('9');

        calculation();



    });

    // function validateStep6() {

    //     //alert('6');
    //     //('.sidebar').hide();


    //     $('#spinner_button').show();
    //     $('.finalbooknow').hide();

    //     localStorage.removeItem('currentStep');

    //     $('#bookingForm').submit();

    //     //alert("Booking Confirmed Successfully!");
    //     return true;
    // }

    function cleaner_check() {

        var city_id = $('#city').find('option:selected').data('id');
        //let city_id = $('#city').val();

        if (city_id === '') {
            $('#cleaner_slider_ul').html('');
            return;
        }

        $('#cleaner_id').val(2);
        $('#cleaner_name').val('No Preference');

        $.ajax({
            url: "{{ route('get.cleaners.by.city') }}",
            type: "POST",
            data: {
                city_id: city_id,
                service_id: "{{ $service_id }}",
                subservice_id: "{{ $subservice_id }}",
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                $('#cleaner_slider_ul').html(res.html);
                initCleanerSlider();
                initCleanerSelection();
            }
        });
    }

    let cleanerSplide = null;

    function initCleanerSlider() {

        if (cleanerSplide) {
            cleanerSplide.destroy(true);
        }

        cleanerSplide = new Splide('#select_your_cleaner_slider_spatie', {
            type: 'slide',
            perPage: 4,
            //focus: 'center',
            autoplay: false,
            pagination: false,
            arrows: true,
            gap: '0.5rem',
            stagePadding: 40,
            breakpoints: {
                768: {
                    fixedWidth: '40%',
                    focus: 'center',
                    stagePadding: 20,
                },
                480: {
                    fixedWidth: '40%',
                    focus: 'center',
                    stagePadding: 20,
                },
            },
        });

        cleanerSplide.on('mounted moved', updateCloneIds);

        cleanerSplide.mount();
    }

    document.addEventListener('DOMContentLoaded', function() {
        initCleanerSlider();
        initCleanerSelection();
    });

    function initCleanerSelection() {
        let cleanersDivs = document.querySelectorAll(".cleaners-div");
        let radioButtons = document.querySelectorAll(".cleaners-radio");

        if (radioButtons.length === 0) return;

        // Select first cleaner by default
        radioButtons.forEach(r => r.checked = false);
        cleanersDivs.forEach(d => d.classList.remove("selected-cleaner"));

        radioButtons[0].checked = true;
        cleanersDivs[0].classList.add("selected-cleaner");

        function updateSelection() {
            cleanersDivs.forEach(div => div.classList.remove("selected-cleaner"));

            let selectedRadio = document.querySelector(".cleaners-radio:checked");
            if (selectedRadio) {
                selectedRadio.closest(".cleaners-div").classList.add("selected-cleaner");
            }
        }

        radioButtons.forEach(radio => {
            radio.addEventListener("change", updateSelection);
        });

        cleanersDivs.forEach(div => {
            div.addEventListener("click", function() {
                let radio = this.querySelector(".cleaners-radio");
                if (radio) {
                    radio.checked = true;
                    updateSelection();
                }
            });
        });
    }


    // function dateclickfunction(dayName, monthName, dayNum, price) {
    //     //alert(`Selected: ${dayName}, ${monthName} ${dayNum} ${price}`);

    //     $('#date').val(dayNum);
    //     $('#month').val(monthName);
    //     $('#t_charge').val('');

    //     if (price == 0) {
    //         $('#date_charge').val('');
    //     } else {
    //         $('#date_charge').val(price);
    //     }

    //     $('#t_charge').val('');
    //     $('.time_replace').html('');

    //     let year = new Date().getFullYear();
    //     var fullSummaryDate = `${dayNum} ${monthName} ${year}`;
    //     $('.date_replace').html(fullSummaryDate);

    //     // let cleaner_id = parseInt($('#cleaner_id').val());

    //     let cleaner_id = $('input[name="cleaner"]:checked').data('cleaner-id') || null;

    //     let month = convertMonthToNumber(monthName); // 01–12
    //     let date = String(dayNum).padStart(2, '0');

    //     let selectedHours = parseInt(
    //         $('input[name="how_many_hours_should_they_stay"]:checked').val()
    //     ) || 0;

    //     // $('input[name="time_slot"]').prop('checked', false).prop('disabled', false);
    //     $('input[name="time_slot"]').prop('checked', false);
    //     $('#time_replace').html('');

    //     $.ajax({
    //         url: '{{ url('homecleaner-time-check') }}',
    //         type: 'POST',
    //         data: {
    //             _token: "{{ csrf_token() }}",
    //             cleaner_id,
    //             date,
    //             month,
    //             year,
    //             subservice_id: '{{ $subservice_id }}'
    //         },

    //         beforeSend: function() {
    //             $(".time_replace_ab").addClass("time-loading");
    //         },

    //         success: function(response) {

    //             let slotsMaster = response.timeslot_master || [];
    //             let bookedSlots = response.timeslot || [];
    //             let hours = response.hours || [];

    //             $('.time_replace_ab').empty();
    //             let slotHtml = '';
    //             let i = 1;
    //             let renderLimit = slotsMaster.length - selectedHours;

    //             if (renderLimit <= 0) {
    //                 $('.time_replace_ab').html('<p>No available time slots</p>');
    //                 return;
    //             }

    //             // RENDER SLOTS
    //             slotsMaster.forEach((slot, index) => {
    //                 if (index >= renderLimit) return;

    //                 slotHtml += `
    //                 <div class="surcharge-badge-timeslot items">
    //                     ${slot.price > 0 ? `<span> + <p class="currency_dhiramnew">AED</p>${slot.price}</span>` : ''}
    //                     <input type="radio"
    //                         id="time${i}"
    //                         name="time_slot"
    //                         data-name="${slot.slot_name}"
    //                         data-price="${slot.price}"
    //                         value="${slot.time_slot_id}">
    //                     <label for="time${i}" class="labeltime" style="cursor: pointer;border-radius: 50px;">
    //                         ${slot.slot_name}
    //                     </label>
    //                 </div>
    //             `;
    //                 i++;
    //             });

    //             $('.time_replace_ab').html(slotHtml);

    //             let slots = $('input[name="time_slot"]');

    //             if (cleaner_id !== 2) {
    //                 // DISABLE BOOKED SLOTS
    //                 bookedSlots.forEach((slot, index) => {
    //                     slots.each(function(i) {
    //                         if ($(this).val() == slot) {
    //                             disableSlot($(this));

    //                             let disableHours = parseInt(hours[index]) || 0;
    //                             for (let j = 1; j <= disableHours; j++) {
    //                                 let next = slots.eq(i + j);
    //                                 if (next.length) {
    //                                     disableSlot(next);
    //                                 }
    //                             }
    //                         }
    //                     });
    //                 });
    //             }

    //             /* =================================================
    //                ✅ TODAY + PAST TIME + 2 HOUR BUFFER (FIXED)
    //                ================================================= */

    //             // let now = moment().tz('Asia/Dubai');
    //             // let bufferTime = now.clone().add(2, 'hours');

    //             // let selectedDate = moment(
    //             //     `${year}-${month}-${date}`,
    //             //     'YYYY-MM-DD'
    //             // ).startOf('day');

    //             // let today = moment().tz('Asia/Dubai').startOf('day');

    //             // if (selectedDate.isSame(today, 'day')) {

    //             //     slots.each(function() {

    //             //         let timeName = $(this).data('name');
    //             //         if (!timeName) return;

    //             //         let startTime = timeName.split('-')[0].trim();

    //             //         let slotMoment = moment.tz(
    //             //             `${year}-${month}-${date} ${startTime}`,
    //             //             'YYYY-MM-DD h:mm A',
    //             //             'Asia/Dubai'
    //             //         );

    //             //         if (slotMoment.isBefore(bufferTime)) {
    //             //             if (cleaner_id !== 2) {
    //             //                 disableSlot($(this));
    //             //             }
    //             //         }
    //             //     });
    //             // }
    //             let now = moment().tz('Asia/Dubai');
    //             let bufferTime = now.clone().add(2, 'hours');

    //             let selectedDate = moment(
    //                 `${year}-${month}-${date}`,
    //                 'YYYY-MM-DD'
    //             );

    //             let today = moment().tz('Asia/Dubai').startOf('day');

    //             // ONLY apply buffer if TODAY
    //             if (selectedDate.isSame(today, 'day')) {

    //                 slots.each(function() {

    //                     let timeName = $(this).data('name');
    //                     if (!timeName) return;

    //                     let startTime = timeName.split('-')[0].trim();

    //                     let slotMoment = moment.tz(
    //                         `${year}-${month}-${date} ${startTime}`,
    //                         'YYYY-MM-DD h:mm A',
    //                         'Asia/Dubai'
    //                     );

    //                     if (slotMoment.isBefore(bufferTime)) {
    //                         disableSlot($(this));
    //                     }
    //                 });
    //             }

    //             // FINAL CHECK
    //             if ($('input[name="time_slot"]:not(:disabled)').length === 0) {
    //                 $('.time_replace_ab').html('<p>No available time slots</p>');
    //             }

    //             calculation();
    //         },

    //         complete: function() {
    //             $(".time_replace_ab").removeClass("time-loading");
    //         }
    //     });
    // }
    function dateclickfunction(dayName, monthName, dayNum, price) {

        let year = new Date().getFullYear();
        let month = convertMonthToNumber(monthName);
        let date = String(dayNum).padStart(2, '0');

        $('#date').val(dayNum);
        $('#month').val(monthName);
        $('#t_charge').val('');

        if (price == 0) {
            $('#date_charge').val('');
        } else {
            $('#date_charge').val(price);
        }

        //let year = new Date().getFullYear();
        var fullSummaryDate = `${dayNum} ${monthName} ${year}`;
        $('.date_replace').html(fullSummaryDate);

        let cleaner_id = $('input[name="cleaner"]:checked').data('cleaner-id') || null;

        let selectedHours = parseInt(
            $('input[name="how_many_hours_should_they_stay"]:checked').val()
        ) || 0;

        $.ajax({
            url: '{{ url(session('search_city_name') . '/homecleaner-time-check') }}',
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                cleaner_id,
                date,
                month,
                year,
                subservice_id: '{{ $subservice_id }}'
            },

            beforeSend() {
                $(".time_replace_ab").addClass("time-loading");
            },

            success(response) {

                let slotsMaster = response.timeslot_master || [];
                let bookedSlots = response.timeslot || [];
                let hours = response.hours || [];

                $('.time_replace_ab').empty();

                let slotHtml = '';
                let i = 1;
                let renderLimit = slotsMaster.length - selectedHours;

                if (renderLimit <= 0) {
                    $('.time_replace_ab').html('<p>No available time slots</p>');
                    return;
                }

                // RENDER SLOTS
                slotsMaster.forEach((slot, index) => {
                    if (index >= renderLimit) return;

                    slotHtml += `
                    <div class="surcharge-badge-timeslot items">
                        ${slot.price > 0 ? `<span class="badgespantime"><span>+</span> <span class="currency_dhiramnew">AED</span> <span>${slot.price}</span></span>` : ''}
                        <input type="radio"
                            id="time${i}"
                            name="time_slot"
                            data-name="${slot.slot_name}"
                            data-price="${slot.price}"
                            value="${slot.time_slot_id}">
                        <label for="time${i}" class="labeltime" style="border-radius:50px;">
                            ${slot.slot_name}
                        </label>
                    </div>
                `;
                    i++;
                });

                $('.time_replace_ab').html(slotHtml);

                let slots = $('input[name="time_slot"]');

                // =============================
                // DISABLE BOOKED SLOTS
                // =============================
                if (cleaner_id !== 2) {
                    bookedSlots.forEach((slot, index) => {
                        slots.each(function(i) {
                            if ($(this).val() == slot) {
                                disableSlot($(this));

                                let disableHours = parseInt(hours[index]) || 0;
                                for (let j = 1; j <= disableHours; j++) {
                                    let next = slots.eq(i + j);
                                    if (next.length) disableSlot(next);
                                }
                            }
                        });
                    });
                }

                // =============================
                // ✅ TODAY + 2 HOUR BUFFER
                // =============================
                let now = moment().tz('Asia/Dubai');
                let bufferTime = now.clone().add(2, 'hours');

                let selectedDate = moment(
                    `${year}-${month}-${date}`,
                    'YYYY-MM-DD'
                );

                let today = moment().tz('Asia/Dubai').startOf('day');

                if (selectedDate.isSame(today, 'day')) {
                    slots.each(function() {

                        let timeName = $(this).data('name');
                        if (!timeName) return;

                        let startTime = timeName.split('-')[0].trim();

                        let slotMoment = moment.tz(
                            `${year}-${month}-${date} ${startTime}`,
                            'YYYY-MM-DD h:mm A',
                            'Asia/Dubai'
                        );

                        if (slotMoment.isBefore(bufferTime)) {
                            disableSlot($(this));
                        }
                    });
                }

                // FINAL CHECK
                if ($('input[name="time_slot"]:not(:disabled)').length === 0) {
                    $('.time_replace_ab').html('<p>No available time slots</p>');
                }
                calculation();
            },

            complete() {
                $(".time_replace_ab").removeClass("time-loading");
            }
        });
    }

    function disableSlot($slot) {
        $slot.prop('disabled', true)
            .closest('.surcharge-badge-timeslot')
            .addClass('disabled-slot');
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

    $(document).on('change', 'input[name="time_slot"]', function() {

        var price = $(this).data('price');
        var name = $(this).data('name');

        timeSlotClick(price, name, this);
    });

    function timeSlotClick(price, slotName, el) {

        //console.log('Slot selected:', price, slotName);

        $('.time_replace').html(slotName);

        if (price > 0) {
            $('#t_charge').val(price);
        } else {
            $('#t_charge').val('');
        }

        calculation();
    }



    let addonsCart = {};
    let addonsSplide;

    /* ============================
    SPLIDE INIT + RESTORE
    ============================ */
    // $(window).on("load", function () {

    //     addonsSplide = new Splide('#addons-slider', {
    //         perPage: 3,
    //         gap: '1rem',
    //         pagination: false,
    //         arrows: true
    //     });

    //     addonsSplide.mount();

    //     // 🔥 restore AFTER splide mount
    //     restoreAddonsFromSession();
    // });

    $(document).ready(function() {
        restoreAddonsFromSession();

        $(document).on('show.bs.modal', '.modal', function() {
            let modal = $(this);

            if (modal.attr('id') === 'mobilesummaryModal') {
                // Summary modal: keep the sticky footer visible (user needs the arrow to close)
                $('body').addClass('summary-modal-open');
            } else {
                // All other modals: hide the sticky footer
                $(".sticky-footer-btn").addClass("d-none").hide();
            }

            // Sync add-ons inside the summary modal
            if (modal.attr('id') === 'mobilesummaryModal') {
                let hasAnyAdded = false;

                // Loop every add-on row in the summary modal
                modal.find('.summary-addon-row').each(function() {
                    let row = $(this);
                    let addBtn = row.find('.addons-addbutton');
                    let id = addBtn.data('id');
                    if (!id) return;
                    id = id.toString();

                    if (addonsCart[id]) {
                        // Item IS in cart — show row with quantity control
                        let qty = addonsCart[id].qty;
                        row.show();
                        addBtn.hide();
                        let qtyCtrl = row.find(".addons-quantity-control[data-id='" + id +
                            "']");
                        qtyCtrl.css('display', 'flex').show();
                        qtyCtrl.find('.addons-quantity').text(qty);
                        hasAnyAdded = true;
                    } else {
                        // Item NOT in cart — hide entire row
                        row.hide();
                    }
                });

                // Hide the "People Also Added" section header if nothing added
                let addonsSection = modal.find('.summary-addons-section');
                if (hasAnyAdded) {
                    addonsSection.show();
                } else {
                    addonsSection.hide();
                }
            }

            // Sync add-on quantities in the detail modal
            if (modal.hasClass('subservice-read-more-model')) {
                let id = modal.find('.addons-addbutton').data('id');
                if (id) {
                    id = id.toString();
                    if (addonsCart[id]) {
                        modal.find('.addons-addbutton').hide();
                        modal.find('.addons-quantity-control').css('display', 'flex').show();
                        modal.find('.addons-quantity').text(addonsCart[id].qty);
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

        /* ─── Z-index fix: info popups open above mobilesummaryModal ───
           When delivery/service/timing fee popup opens, the new backdrop
           Bootstrap appends must sit above the summary sheet (z-index 1060).
           We bump the last .modal-backdrop to 1080, and the popup itself
           is already set to 1090 via CSS.
        ─────────────────────────────────────────────────────────────── */
        //     const feePopupIds = [
        //         'delivery_charge_popup_{{ $subservice_id }}',
        //         'service_fee_popup_{{ $subservice_id }}',
        //         'timing_fee_popup_{{ $subservice_id }}'
        //     ];

        //     $(document).on('show.bs.modal',
        //         '#delivery_charge_popup_{{ $subservice_id }}, #service_fee_popup_{{ $subservice_id }}, #timing_fee_popup_{{ $subservice_id }}',
        //         function() {
        //             // Defer until Bootstrap has appended the new backdrop to <body>
        //             setTimeout(function() {
        //                 // Get ALL backdrops and boost the last one (the new one)
        //                 let backdrops = $('body > .modal-backdrop');
        //                 if (backdrops.length > 1) {
        //                     // Bump only the LAST backdrop above the summary modal
        //                     backdrops.last().css('z-index', '1080');
        //                 } else if (backdrops.length === 1) {
        //                     backdrops.css('z-index', '1080');
        //                 }
        //             }, 10);
        //         });

        //     $(document).on('hidden.bs.modal',
        //         '#delivery_charge_popup_{{ $subservice_id }}, #service_fee_popup_{{ $subservice_id }}, #timing_fee_popup_{{ $subservice_id }}',
        //         function() {
        //             // Restore remaining backdrops to default z-index
        //             $('body > .modal-backdrop').css('z-index', '');
        //         });
    });

    /* ============================
    RESTORE FROM SESSION
    ============================ */
    function restoreAddonsFromSession() {

        $.get("{{ route('homecleaningaddons_get') }}", function(data) {

            addonsCart = data || {};

            Object.keys(addonsCart).forEach(id => {

                // 🔥 UPDATE ALL BUTTONS (real + clones + modal)
                $(".addons-addbutton[data-id='" + id + "']").hide();

                $(".addons-quantity-control[data-id='" + id + "']").each(function() {
                    $(this).css('display', 'flex').show();
                    $(this).find(".addons-quantity").text(addonsCart[id].qty);
                });
            });

            updateAddonSidebar();
        });
    }

    /* ============================
    ADD ADDON
    ============================ */
    $(document).on("click", ".addons-addbutton", function() {

        let id = $(this).data("id");

        if (!addonsCart[id]) {
            addonsCart[id] = {
                name: $(this).data("name"),
                price: parseFloat($(this).data("price")),
                qty: 1
            };
        }

        // Hide ALL add buttons with this id (grid card, modal, summary sheet)
        $(".addons-addbutton[data-id='" + id + "']").hide();

        // Show ALL quantity controls with this id
        $(".addons-quantity-control[data-id='" + id + "']")
            .css('display', 'flex')
            .show()
            .find(".addons-quantity").text(addonsCart[id].qty);

        updateAddonSidebar();
    });

    /* ============================
    PLUS / MINUS
    ============================ */
    $(document).on("click", ".addons-plus-btn, .addons-minus-btn", function() {

        let parent = $(this).closest(".addons-quantity-control");
        let id = parent.data("id");

        if (!addonsCart[id]) return;

        addonsCart[id].qty = parseInt(addonsCart[id].qty);

        if ($(this).hasClass("addons-plus-btn")) {
            addonsCart[id].qty++;
        } else {
            addonsCart[id].qty--;
        }

        if (addonsCart[id].qty <= 0) {
            delete addonsCart[id];

            $(".addons-quantity-control[data-id='" + id + "']").hide();
            $(".addons-addbutton[data-id='" + id + "']").show();

        } else {
            // 🔥 UPDATE ALL CLONES
            $(".addons-quantity-control[data-id='" + id + "']")
                .css('display', 'flex')
                .show()
                .find(".addons-quantity")
                .text(addonsCart[id].qty);
        }

        updateAddonSidebar();
    });

    /* ============================
    SIDEBAR + TOTALS
    ============================ */
    function updateAddonSidebar() {

        let html = '';
        let addonsTotal = 0;

        Object.values(addonsCart).forEach(item => {

            let qty = parseInt(item.qty);
            let price = parseFloat(item.price);

            if (isNaN(qty) || isNaN(price)) return;

            let subtotal = qty * price;
            addonsTotal += subtotal;

            html += `
                <div class="d-flex justify-content-between">
                    <div>${item.name} x ${qty}</div>
                    <div class="addons_price_cart price-wrapper"><span class="currency_dhiramnew">AED</span>${subtotal.toFixed(2)}</div>
                </div>
            `;
        });

        $(".sidebar-cart").html(html);

        $("#package_charge").val(addonsTotal.toFixed(2));

        storeAddonsSession();
        calculation();
    }

    /* ============================
    STORE SESSION
    ============================ */
    function storeAddonsSession() {
        $.post("{{ route('homecleaningaddons_store') }}", {
            _token: "{{ csrf_token() }}",
            service_id: '{{ $service_id }}',
            subservice_id: '{{ $subservice_id }}',
            addons: addonsCart
        });
    }
    $(document).ready(function() {
        // Restore selections from localStorage after login reloads
        const hours = localStorage.getItem('hc_hours');
        if (hours) {
            let el = document.querySelector('input[name="how_many_hours_should_they_stay"][value="' + hours +
                '"]');
            if (el) el.checked = true;
        }

        const cleaners = localStorage.getItem('hc_cleaners');
        if (cleaners) {
            let el = document.querySelector('input[name="how_many_cleaners_do_you_need"][value="' + cleaners +
                '"]');
            if (el) el.checked = true;
        }

        const freq = localStorage.getItem('hc_freq');
        if (freq) {
            let el = document.querySelector('input[name="how_often_do_you_need_cleaning"][value="' + freq +
                '"]');
            if (el) el.checked = true;
        }

        const material = localStorage.getItem('hc_material');
        if (material) {
            let el = document.querySelector('input[name="do_you_need_cleaning_material"][value="' + material +
                '"]');
            if (el) el.checked = true;
        }

        setTimeout(() => {
            calculation();
        }, 500);
    });

    function calculation() {

        let selectedCleaner = document.querySelector('input[name="how_many_cleaners_do_you_need"]:checked');
        let selectedHours = document.querySelector('input[name="how_many_hours_should_they_stay"]:checked');
        let freq = document.querySelector('input[name="how_often_do_you_need_cleaning"]:checked');
        let material = document.querySelector('input[name="do_you_need_cleaning_material"]:checked');

        if (selectedHours) localStorage.setItem('hc_hours', selectedHours.value);
        if (selectedCleaner) localStorage.setItem('hc_cleaners', selectedCleaner.value);
        if (freq) localStorage.setItem('hc_freq', freq.value);
        if (material) localStorage.setItem('hc_material', material.value);

        if (selectedCleaner.value === '1') {
            $('#cleaner_section').css('display', 'block');
            $('#cleaner_id').val(2);
            $('#cleaner_name').val('No Preference');
        } else {
            $('#cleaner_section').css('display', 'none');
            $('#cleaner_id').val('');
            $('#cleaner_name').val('');
        }

        $('#no_of_cleaners').val(selectedCleaner.value);
        $('#no_of_hours').val(selectedHours.value);
        // alert(selectedCleaner.value);
        // alert(selectedHours.value);

        var service_id = '{{ $subservice_id }}';

        $.ajax({

            type: 'POST',
            url: '{{ url(session('search_city_name') . '/get_price_cleaning') }}',
            data: {

                "_token": "{{ csrf_token() }}",
                'service_id': service_id,
                'how_many_hours_should_they_stay_value': selectedHours.value,
            },
            success: function(msg) {

                var response_ajax = JSON.parse(msg);
                //console.log(response_ajax);
                if (response_ajax.status === 'success') {

                    // const hour_charge_db = parseFloat(response_ajax.hour_price) || 0;
                    // const cleaning_material_charge_db = parseFloat(response_ajax.cleaning_material_price_per_hour) || 0;

                    // $('#hour_charge_db').val(hour_charge_db);
                    // $('#cleaning_material_charge_db').val(cleaning_material_charge_db);

                    // const no_of_cleaners = parseInt(selectedCleaner.value) || 0;
                    // const no_of_hours = parseInt(selectedHours.value) || 0;


                    // /* ---------------- BASE PRICE ---------------- */
                    // const calprice = no_of_hours > 0 ? no_of_hours * hour_charge_db : 0;
                    // const percleanprice = calprice * no_of_cleaners;

                    //  /* ---------------- CLEANING MATERIAL ---------------- */
                    // const materialRadio = document.querySelector('input[name="do_you_need_cleaning_material"]:checked');
                    // const materialValue = materialRadio ? materialRadio.value : 'No';

                    // let additional_charge = 0;
                    // if (materialValue !== 'No') {
                    //     additional_charge = (no_of_hours * cleaning_material_charge_db) * no_of_cleaners;
                    // }

                    // /* ---------------- FREQUENCY DISCOUNT ---------------- */
                    // const frequency = $('input[name="how_often_do_you_need_cleaning"]:checked').val();

                    // var selectedDays = [];

                    // if(frequency === 'Multiple times a week'){                        
                    //      $("input[name='which_day_of_the_week_do_you_want_the_service[]']:checked").each(function() {
                    //         selectedDays.push($(this).val());
                    //     });
                    //     var selectedDaysStr = selectedDays.join(', ');

                    // }else{
                    //     var selectedDaysStr = '';
                    // }

                    // $('#days_of_the_week').val(selectedDaysStr);
                    // $('#frequency').val(frequency);

                    // let cleaning_discount = 0;
                    // let discount_percentage_new = 0;
                    // let percleanprice_new = percleanprice;
                    // let additional_charge_new = additional_charge;
                    // let cleaning_discount_amount = 0;
                    // let cleaning_discount_additional = 0;

                    // if (frequency === 'Weekly') {
                    //     cleaning_discount = {{ $weekly_discout_1 }};
                    // } 
                    // else if (frequency === 'Multiple times a week') {
                    //     cleaning_discount = {{ $multiple_time_week_discout_1 }};
                    // }
                    // // alert(cleaning_discount);
                    // if (cleaning_discount > 0) {
                    //     discount_percentage_new = cleaning_discount;
                    //     cleaning_discount_amount = parseFloat((percleanprice * cleaning_discount) / 100);
                    //     percleanprice_new = percleanprice - cleaning_discount_amount;

                    //     cleaning_discount_additional = (additional_charge * cleaning_discount) / 100;
                    //     additional_charge_new = additional_charge - cleaning_discount_additional;

                    //     $('.cross_amount_div').show();
                    // } else {
                    //     $('.cross_amount_div').hide();
                    // }

                    // // alert('cleaning_discount'  + cleaning_discount);
                    // // alert('percleanprice'  + percleanprice);
                    // // alert('percleanprice_new'  + percleanprice_new);
                    // // alert('cleaning_discount_amount'  + cleaning_discount_amount);
                    // // alert('additional_charge_new'  + additional_charge_new);


                    // /* ---------------- EXTRA CHARGES ---------------- */
                    // let DateCharge = parseFloat($("#date_charge").val()) || 0;
                    // let tCharge = parseFloat($("#t_charge").val()) || 0;
                    // const weekly_off_charge = parseFloat($('#weekly_off_charge').val()) || 0;
                    // const cod_charge = parseFloat($('#cod_charge').val()) || 0;
                    // const service_fee = parseFloat($('#service_fee').val()) || 0;
                    // const package_charge = parseFloat($('#package_charge').val()) || 0;
                    // let wallet_used = parseFloat($("#wallet_used").val()) || 0;

                    // // alert(package_charge);

                    // var finalTimingcharge = DateCharge + tCharge;
                    // $('#timing_charge').val(finalTimingcharge);

                    // let timing_charge = parseFloat($("#timing_charge").val()) || 0;

                    // //alert(additional_charge_new);

                    //  /* ---------------- SUB TOTAL ---------------- */
                    // let sub_total = percleanprice_new + additional_charge_new + timing_charge + weekly_off_charge + cod_charge + package_charge + service_fee;
                    // //alert('subtotal'+ sub_total);
                    // // if ($("#home_cleaning_left_value").val() == 2) {
                    // //     sub_total += service_fee;
                    // // }

                    // /* ---------------- VAT & TOTAL ---------------- */
                    // const vat_total = sub_total * 0.05;
                    // const total_to_pay = sub_total + vat_total ;
                    // // alert('subtotal' +sub_total );
                    // // alert('service_fee' +service_fee );
                    // // alert('vat_total' +vat_total );
                    // // alert('wallet_used' +wallet_used );
                    // // alert('total_to_pay' +total_to_pay );


                    // /* ---------------- CROSS PRICE ---------------- */
                    // const f = v => parseFloat(v).toFixed(2);

                    // // alert('sub_total' + sub_total);
                    // alert('cleaning_discount_amount' + cleaning_discount_amount);
                    // // alert('vat_total' + vat_total);

                    // //var cleaning_discount_amount1 = parseFloat(cleaning_discount_amount);

                    // const crossprice = f(
                    //     sub_total  +cleaning_discount_amount+
                    //     vat_total 

                    // );


                    // //alert('crossprice'+ crossprice);

                    // //  alert('crossprice' + crossprice);

                    // let beforePromo = sub_total  + vat_total - wallet_used;

                    // //alert('before'+beforePromo);

                    // $("#additional_charge").val(additional_charge_new.toFixed(2));
                    // $("#service_charge").val(percleanprice_new.toFixed(2));
                    // $("#sub_total").val(sub_total.toFixed(2));
                    // $("#vat_total").val(vat_total.toFixed(2));
                    // $("#total_to_pay").val(total_to_pay.toFixed(2));


                    // $(".total_to_pay").text(total_to_pay.toFixed(2));
                    // $(".cleaners_summary").text(no_of_cleaners);
                    // $('.cross_amount').html(crossprice);
                    // if(additional_charge_new > 0){
                    //     $('.material_summary').html('Yes');
                    // }else{
                    //     $('.material_summary').html('No');
                    // }

                    /* ================= GET DB VALUES ================= */
                    const hour_charge_db = parseFloat(response_ajax.hour_price) || 0;
                    const cleaning_material_charge_db = parseFloat(response_ajax
                        .cleaning_material_price_per_hour) || 0;

                    $('#hour_charge_db').val(hour_charge_db);
                    $('#cleaning_material_charge_db').val(cleaning_material_charge_db);

                    const no_of_cleaners = parseInt(selectedCleaner.value) || 0;
                    const no_of_hours = parseInt(selectedHours.value) || 0;

                    /* ================= BASE PRICE ================= */
                    const calprice = no_of_hours > 0 ? no_of_hours * hour_charge_db : 0;
                    const percleanprice = calprice * no_of_cleaners;

                    /* ================= CLEANING MATERIAL ================= */
                    const materialRadio = document.querySelector(
                        'input[name="do_you_need_cleaning_material"]:checked');
                    const materialValue = materialRadio ? materialRadio.value : 'No';

                    let additional_charge = 0;
                    if (materialValue !== 'No') {
                        additional_charge = (no_of_hours * cleaning_material_charge_db) *
                            no_of_cleaners;
                    }

                    /* ================= EXTRA CHARGES ================= */
                    let DateCharge = parseFloat($("#date_charge").val()) || 0;
                    let tCharge = parseFloat($("#t_charge").val()) || 0;
                    const weekly_off_charge = parseFloat($('#weekly_off_charge').val()) || 0;
                    const cod_charge = parseFloat($('#cod_charge').val()) || 0;
                    const service_fee = parseFloat($('#service_fee').val()) || 0;
                    const package_charge = parseFloat($('#package_charge').val()) || 0;
                    let wallet_used = parseFloat($("#wallet_used").val()) || 0;

                    let finalTimingcharge = DateCharge + tCharge;
                    $('#timing_charge').val(finalTimingcharge);
                    let timing_charge = finalTimingcharge;

                    /* ================= ORIGINAL TOTAL (NO DISCOUNT) ================= */
                    const original_sub_total =
                        percleanprice +
                        additional_charge +
                        timing_charge +
                        weekly_off_charge +
                        cod_charge +
                        package_charge;

                    const original_vat = original_sub_total * 0.05;
                    const original_total = original_sub_total + original_vat + service_fee;

                    /* ================= FREQUENCY ================= */
                    const frequency = $('input[name="how_often_do_you_need_cleaning"]:checked').val();

                    let selectedDays = [];
                    let selectedDaysStr = '';

                    if (frequency === 'Multiple times a week') {
                        $("input[name='which_day_of_the_week_do_you_want_the_service[]']:checked").each(
                            function() {
                                selectedDays.push($(this).val());
                            });
                        selectedDaysStr = selectedDays.join(', ');
                    }

                    $('#days_of_the_week').val(selectedDaysStr);
                    $('#frequency').val(frequency);

                    /* ================= DISCOUNT ================= */
                    let cleaning_discount = 0;

                    if (frequency === 'Weekly') {
                        cleaning_discount = {{ $weekly_discout_1 }};
                    } else if (frequency === 'Multiple times a week') {
                        cleaning_discount = {{ $multiple_time_week_discout_1 }};
                    }

                    let percleanprice_new = percleanprice;
                    let additional_charge_new = additional_charge;
                    let cleaning_discount_amount = 0;

                    if (cleaning_discount > 0) {
                        cleaning_discount_amount = (percleanprice * cleaning_discount) / 100;
                        const additional_discount = (additional_charge * cleaning_discount) / 100;

                        percleanprice_new -= cleaning_discount_amount;
                        additional_charge_new -= additional_discount;

                        $('.cross_amount_div').show();
                    } else {
                        $('.cross_amount_div').hide();
                    }

                    /* ================= SUB TOTAL (AFTER DISCOUNT) ================= */
                    let sub_total =
                        percleanprice_new +
                        additional_charge_new +
                        timing_charge +
                        weekly_off_charge +
                        cod_charge +
                        package_charge;

                    /* ================= VAT & TOTAL ================= */
                    const vat_total = sub_total * (vatPercent / 100);
                    const total_to_pay = sub_total + vat_total + service_fee - wallet_used;

                    /* ================= DISPLAY ================= */
                    const f = v => parseFloat(v).toFixed(2);

                    $("#additional_charge").val(f(additional_charge_new));
                    $("#service_charge").val(f(percleanprice_new));
                    $("#sub_total").val(f(sub_total));
                    $("#vat_total").val(f(vat_total));
                    $("#total_to_pay").val(f(total_to_pay));

                    $(".total_to_pay").text(f(total_to_pay));
                    $(".cleaners_summary").text(no_of_cleaners);
                    $(".material_summary").html(additional_charge_new > 0 ? 'Yes' : 'No');

                    /* ================= CROSS PRICE ================= */
                    $('.cross_amount').html(f(original_total));

                    let beforePromo = sub_total + vat_total + service_fee - wallet_used;


                    checkapplyPromo(beforePromo);
                    updateAllSummaries();

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response_ajax.message,
                        confirmButtonColor: '#3085d6',
                    });

                }

            }

        });
    }

    function checkapplyPromo(baseTotal) {

        //alert(baseTotal);

        // Auto-apply Google Ads promo if present in URL (one-shot, only when sub_total > 0)
        if (typeof window.maybeAutoApplyPromo === 'function') {
            window.maybeAutoApplyPromo(baseTotal);
        }

        $.get("{{ route('homecleaning.get_coupon') }}", function(couponData) {
            if (typeof couponData === 'string') {
                try {
                    couponData = JSON.parse(couponData);
                } catch (e) {}
            }

            if (couponData && couponData !== 'null' && typeof couponData === 'object' && couponData
                .coupancode) {

                window.currentAppliedCoupon = couponData.coupancode;
                window.lastValidPromoCode = couponData.coupancode;

                let minOrder = parseFloat(couponData.minimum_order) || 0;
                if (minOrder > 0 && baseTotal < minOrder) {
                    window.currentAppliedCoupon = null;
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
                            showToast('warning', 'Notice',
                                'Promo code removed. Minimum order amount is <span class="price-wrapper"><span class="currency_dhiramnew">AED</span>' +
                                minOrder + '</span>');
                            calculation();
                        }
                    });
                    return;
                }

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
                window.currentAppliedCoupon = null;
            }

            // 🔥 FIX: enforce number again before toFixed()
            couponDiscount = parseFloat(couponDiscount) || 0;
            walletReward = parseFloat(walletReward) || 0;

            $('#promo_discount').val(couponDiscount.toFixed(2));
            $('#wallet_reward_amount').val(walletReward.toFixed(2));


            let totalToPay = baseTotal - couponDiscount;

            //alert(totalToPay);

            $("#total_to_pay").val(totalToPay.toFixed(2));
            $(".total_to_pay").text(totalToPay.toFixed(2));
            $(".promo_code").text(couponDiscount.toFixed(2));

            let tabbySplit = totalToPay / 4;
            $("#tabby_split_amount").text(tabbySplit.toFixed(2));

            let tabbySplit6 = totalToPay / 6;
            $("#tabby_split_amount_6").text(tabbySplit6.toFixed(2));

            let tabbySplit8 = totalToPay / 8;
            $("#tabby_split_amount_8").text(tabbySplit8.toFixed(2));

            let tabbySplit12 = totalToPay / 12;
            $("#tabby_split_amount_12").text(tabbySplit12.toFixed(2));


            var frequency = $('input[name="how_often_do_you_need_cleaning"]:checked').val();
            // if (frequency === 'Weekly') {
            //     couponDiscount = {{ $weekly_discout_1 }};
            // } 
            // else if (frequency === 'Multiple times a week') {
            //     couponDiscount = {{ $multiple_time_week_discout_1 }};
            // }
            // alert(frequency);

            // 🔥 SHOW / HIDE CROSSED AMOUNT
            if (couponDiscount > 0) {
                $(".cross_amount").text(baseTotal.toFixed(2));
                $(".cross_amount_div").show();
            } else {
                if (frequency === 'Weekly') {
                    var frequencyDiscount = {{ $weekly_discout_1 }};
                } else if (frequency === 'Multiple times a week') {
                    var frequencyDiscount = {{ $multiple_time_week_discout_1 }};
                }
                if (frequencyDiscount > 0) {
                    $(".cross_amount_div").show();
                } else {
                    $(".cross_amount_div").hide();
                }

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
                        window.currentAppliedCoupon = null;

                        calculation();

                        showToast('success', 'Coupon Removed!', 'Coupon Removed!');
                    }
                });

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
                id: '#wallet_reward_amount',
                row: '.wallet_reward_sidebar_div, .wallet_reward_summary_div',
                span: '.wallet_reward_code_amount'
            },
            {
                id: '#wallet_used',
                row: '.wallet_dicount_replace_div',
                span: '.wallet_amount_div'
            },
            {
                id: '#no_of_hours',
                row: '.hours_div',
                span: '.hours_summary'
            },
            {
                id: '#no_of_cleaners',
                row: '.no_of_cleaners_div',
                span: '.cleaners_summary'
            },
            {
                id: '#frequency',
                row: '.frequency_div',
                span: '.frequency_summary'
            },
            {
                id: '#additional_charge',
                row: '.additional-charge-div',
                span: '.additional_charge'
            },
            {
                id: '#days_of_the_week',
                row: '.frequency_days_div',
                span: '.frequency_summary_days'
            },
        ];

        const n = v => parseFloat(v) || 0; // safe number
        const f = v => n(v).toFixed(2);

        $(".sidebar-summary").each(function() {
            let summary = $(this);

            charges.forEach(c => {

                let rawValue = $(c.id).val();
                let row = summary.find(c.row);

                // 🔹 STRING VALUE (Frequency)
                if (c.id === '#frequency' || c.id === '#days_of_the_week') {

                    if (rawValue && rawValue !== 'no') {
                        row.removeClass('d-none').show();
                        summary.find(c.span).text(rawValue);
                    } else {
                        row.addClass('d-none').hide();
                    }

                    return; // stop numeric logic
                }

                // 🔹 NUMERIC VALUE
                let value = n(rawValue);

                if (value > 0) {
                    row.removeClass('d-none').show();

                    // count values
                    if (
                        c.span === '.hours_summary' ||
                        c.span === '.cleaners_summary'
                    ) {
                        summary.find(c.span).text(parseInt(value));
                    }
                    // price values
                    else {
                        summary.find(c.span).text(f(value));
                    }

                } else {
                    row.addClass('d-none').hide();
                }
            });
        });
    }
</script>

<style>
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
        // alert('Promo applied');

        var home_promo_check = "{{ route('home_promo_check') }}";

        let promo_code = $('#promo_code' + from).val();
        if (!promo_code) {
            showPromoToast('warning', 'Warning', 'Please Enter Promo Code');
            return false;
        }

        var sub_total = parseFloat($('#sub_total').val());

        $.ajax({
            url: home_promo_check,
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
                    return false;
                } else if (response === 'Already') {
                    showPromoToast('info', 'Notice', 'Promo Code Already Used');
                    $('#promo_code' + from).val('');
                    return false;
                } else if (response === 'Already Used') {
                    showPromoToast('info', 'Notice', 'Promo Code Already Used');
                    $('#promo_code' + from).val('');
                    return false;
                } else if (response === 'invalid_user_count') {
                    showPromoToast('info', 'Notice', 'Promo Code Expired.');
                    $('#promo_code' + from).val('');
                    return false;
                } else if (response === 'grater') {
                    showPromoToast('info', 'Notice', 'Promo Discount is greater than total amount');
                    $('#promo_code' + from).val('');
                    return false;
                } else if (response === 'success') {
                    $.get("{{ route('homecleaning.get_coupon') }}", function(couponData) {
                        let toastMsg = 'Your promo code has been applied.';
                        if (typeof couponData === 'string') {
                            try {
                                couponData = JSON.parse(couponData);
                            } catch (e) {}
                        }
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
                    $(".wallet_apply_new").show();
                    $(".wallet_cancel_new").hide();

                    $('#wallet_used').val('0');
                    calculation();
                    return true;
                } else {
                    showPromoToast('error', 'Error', 'Something went wrong');
                    $('#promo_code' + from).val('');
                    return false;
                }

            },

        });
    }

    function removeCoupan() {
        $.ajax({
            url: "{{ route('homecleaning.remove_coupon') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function() {

                $('#promo_name').val('');
                $('#promo_discount').val('0.00');
                $('#wallet_reward_amount').val('0.00');
                $(".promo_code").text('0.00');
                $(".promo_code_name").text('');
                $(".cross_amount_div").hide();

                calculation();

            }
        });
    }
</script>

{{-- ==================== Google Ads promo Auto-Apply ==================== --}}
<script>
    (function() {
        // Values passed from PHP controller
        var promoCode = @json($promo ?? '');
        window.lastValidPromoCode = promoCode || @json($session_coupon_applied ?? '');
        window.currentAppliedCoupon = @json($session_coupon_applied ?? '');

        /**
         * Show the "Promo Applied" green UI card.
         */
        function showPromoApplied(code) {
            $('#promo_code_input_section').addClass('d-none');
            $('.promo_dicount_replace_div').removeClass('d-none');
            $('.promo_code_name').text(code);
        }

        /**
         * Called from inside checkapplyPromo() after each calculation().
         * At that point sub_total is already populated with a real value.
         */
        window.maybeAutoApplyPromo = function(baseTotal) {
            if (!window.lastValidPromoCode) return; // no promo in URL or session
            if (baseTotal <= 0) return; // sub_total still 0, wait for next calc

            // If the exact same promo is already in PHP session — just show UI
            if (window.currentAppliedCoupon === window.lastValidPromoCode) {
                showPromoApplied(window.lastValidPromoCode);
                return;
            }

            // If a DIFFERENT promo is already applied — don't override
            if (window.currentAppliedCoupon && window.currentAppliedCoupon !== window.lastValidPromoCode) {
                return;
            }

            if (window.lastPromoAttemptTotal === baseTotal) {
                return;
            }
            window.lastPromoAttemptTotal = baseTotal;

            // No coupon in session — silently apply via AJAX
            $.ajax({
                url: "{{ route('home_promo_check') }}",
                type: 'POST',
                data: {
                    'promo_code': window.lastValidPromoCode,
                    'service': @json($service_id),
                    'sub_service': @json($subservice_id),
                    'sub_total': baseTotal,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response === 'success') {
                        showPromoApplied(promoCode);
                        $.get("{{ route('homecleaning.get_coupon') }}", function(couponData) {
                            let toastMsg = 'Your promo code has been applied.';
                            if (typeof couponData === 'string') {
                                try {
                                    couponData = JSON.parse(couponData);
                                } catch (e) {}
                            }
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
                        calculation(); // recalculate totals with the discount applied
                    }
                    // For 'Already', 'invalid', 'grater' etc — silently do nothing
                }
            });
        };
    })();
</script>
