@include('front.includes.header')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
<style>
    .wallet_apply {
        border: none;
        background-color: inherit;
        color: #0040E6;
    }

    .wallet_cancel {
        border: none;
        background-color: inherit;
        color: #0040E6;
    }

    .backMobile {
        position: absolute;
        right: 15px;
        top: 10px;
    }

    .radio-group input[type="radio"] {
        display: none;
    }

    .sticky-button {
        display: none !important;
        position: fixed;
        bottom: 0px;
        right: 0;
        z-index: 1000;
        height: 81px;
        background-color: #fff;
        color: #fff;
        font-size: 23px;

    }

    .booking-summary {
        position: fixed;
        bottom: 7px;
        /* right: 146px; */
        z-index: 1000;
        height: 50px;
        background-color: #fff;
        color: #fff;
        font-size: 23px;
        border: none;
        padding: 0;
        margin: 0;
    }

    .modal-dialog {
        max-width: 60%;
        height: auto !important;
        max-height: 70% !important;
    }

    .mobile-next {
        top: 20px !important;
    }

    .modal-content {
        border-radius: 1.3rem;
    }

    /* Show the button on mobile screens (less than 768px wide) */
    @media only screen and (max-width: 768px) {
        .modal-mobile-bottom {
            background-color: rgba(0, 0, 0, 0.2);
            padding: 0 !important;
        }

        .modal-dialog-bottom {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            margin: 0;
            width: 100%;
            max-width: 100%;
            height: 90vh;
            transform: translateY(100%);
            transition: transform 0.5s ease-out, opacity 0.5s ease-out;
            opacity: 0;
            display: flex;
            flex-direction: column;
            z-index: 1055;
        }

        .modal.show .modal-dialog-bottom {
            transform: translateY(0);
            opacity: 1;
        }

        .modal-dialog-centered {
            min-height: 0 !important;
        }

        .modal-content {
            border-radius: 20px 20px 0 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .details-modal-content {
            border-radius: 20px !important;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            -webkit-overflow-scrolling: touch;
        }

        .modal-footer {
            padding: 10px 16px;
            background-color: #fff;
            border-top: 1px solid #ddd;
            position: sticky;
            bottom: 0;
            z-index: 10;
        }

        /* Prevent Bootstrap's default top-down animation */
        .modal .modal-dialog {
            transform: none !important;
            transition: none !important;
        }

        .modal-dialog-centered {
            min-height: 0 !important;
        }

        .modal-mobile {
            padding: 10px 16px !important;
        }



        .hour_input .items {
            margin-left: 30px;
        }

        #modal-digi {
            max-width: 100% !important;
        }

        .sticky-button {
            display: block !important;
        }

        .mobile-hide {
            display: none !important;
        }

        #summary_div_left {
            display: none !important;
        }

        #summary_div_left_mobile {
            display: none;
            position: fixed;
            bottom: -100%;
            /* Initially hide the div outside the viewport */
            right: 0;
            width: 100%;
            transition: all 0.3s ease-in-out;
            /* Smooth transition effect */
            z-index: 99999;
            /* Make sure it stays on top */
        }

        .book-now-web {
            display: none !important;
        }

        #learn_more {
            font-weight: 50 !important;
        }

        #mobile-table {
            width: 100% !important;
        }

        #nextBtn12 {
            background-color: #0040E6 !important;
            border: none !important;
        }

        #summary_div_left_mobile.open {
            display: block !important;
            bottom: 0;
            /* Slide up into view */
            background: #fff;
            bottom: 81px;
            /* padding-top: 121px; */
            padding: 0 0 68px !important;
            height: 100%;
            background: rgba(0, 0, 0, .7)
        }

        .summuryInner {
            background: #fff;
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 70px 10px 10px;
        }

        .closeBtn {
            background: none;
            font-size: 50px;
            color: #000;
            border: none;
            position: absolute;
            right: 0;
            top: 0;
            margin: 0;
            padding: 0;
            width: 30px;
        }

    }


    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 50%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }


    /* Style the labels to look like buttons */
    .radio-group label {
        display: inline-block;
        padding: 10px 20px !important;
        margin: 5px;
        border: 2px solid #0040E6;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
        /* width: 100%;
        text-align: center; */
    }


    /* Default button style */
    .radio-group label {
        background-color: #fff;
        color: #007bff;
    }


    .radio-checked input[type="radio"]+label {
        color: #000;
        /* outline: grey; */
    }

    /* Change style when radio button is checked */
    .radio-checked input[type="radio"]:checked+label {
        background-color: #0040E6;
        color: #fff;
    }

    .radio-group input[type="radio"]:checked+label {
        background-color: #0040E6;
        color: #fff;
    }

    /* Change style on hover */
    .radio-group label:hover {
        background-color: #e0e0e0;
    }

    .labeltime {
        width: 100%;
        text-align: center;
        padding: 10px !important;
        margin: 0 !important;
    }

    /* Optional: Add active class for better styling control */
    .radio-group label:active {
        background-color: #d0d0d0;
    }

    /* Hide the checkboxes */
    .checkbox-group input[type="checkbox"] {
        display: none;
    }

    /* Style the labels to look like buttons */
    .checkbox-group label {
        display: inline-block;
        padding: 10px 20px;
        margin: 5px;
        border: 2px solid #007bff;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    /* Default button style */
    .checkbox-group label {
        background-color: #fff;
        color: #007bff;
    }

    /* Change style when checkbox is checked */
    .checkbox-group input[type="checkbox"]:checked+label {
        background-color: #0040E6;
        color: #fff;
    }

    /* Change style on hover */
    .checkbox-group label:hover {
        background-color: #e0e0e0;
    }

    /* Optional: Add active class for better styling control */
    .checkbox-group label:active {
        background-color: #d0d0d0;
    }

    /* Custom Radio & Checkbox Styles (Cards) */
    .radio-card-group,
    .checkbox-card-group {
        display: flex !important;
        flex-wrap: nowrap !important;
        /* Horizontal scrolling on mobile/tablet */
        overflow-x: auto !important;
        overflow-y: hidden !important;
        width: 100% !important;
        max-width: 100% !important;
        -webkit-overflow-scrolling: touch !important;
        touch-action: auto !important;
        /* Allow native touch behaviors */
        gap: 12px;
        margin-top: 12px;
        margin-bottom: 24px;
        padding-bottom: 8px;
        scrollbar-width: none;
    }

    .radio-card-group::-webkit-scrollbar,
    .checkbox-card-group::-webkit-scrollbar {
        display: none;
    }

    .radio-card-item,
    .checkbox-card-item,
    .radio-group label.radio-card-item {
        position: relative;
        background: #ffffff;
        border: 1.5px solid #0040E6 !important;
        border-radius: 30px !important;
        padding: 10px 24px !important;
        margin: 0 !important;
        min-width: 100px;
        /* Prevents short words from collapsing into vertical ellipses */
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        cursor: pointer;
        transition: all 0.2s ease;
        flex: 0 0 auto;
        touch-action: auto;
    }

    .radio-card-item:hover,
    .checkbox-card-item:hover {
        background-color: rgba(0, 64, 230, 0.05);
    }

    .radio-card-item input[type="radio"],
    .checkbox-card-item input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .radio-card-label,
    .checkbox-card-label {
        font-size: 15px;
        font-weight: 500;
        color: #0040E6;
        margin: 0;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .radio-card-item label,
    .checkbox-card-item label {
        border: none !important;
        padding: 0 !important;
        margin: 0 !important;
        background: transparent !important;
        color: inherit !important;
    }

    .radio-card-item.active,
    .checkbox-card-item.active,
    .radio-card-item:has(input:checked),
    .checkbox-card-item:has(input:checked) {
        background-color: #0040E6 !important;
        border-color: #0040E6 !important;
    }

    @media (min-width: 992px) {

        .radio-card-group,
        .checkbox-card-group {
            flex-wrap: wrap;
            /* Wrap on desktop screen widths */
            overflow-x: visible;
        }
    }

    .radio-card-item.active .radio-card-label,
    .checkbox-card-item.active .checkbox-card-label,
    .radio-card-item:has(input:checked) .radio-card-label,
    .checkbox-card-item:has(input:checked) .checkbox-card-label {
        color: #ffffff !important;
    }

    .calendar-input {
        width: 100%;
        text-align: center;
    }

    .calendar-container {
        display: flex;
        align-items: center;
        /* justify-content: center; */
        margin-top: 20px;
    }

    .scroll-arrow {
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        outline: none;
        border: none;
        padding: 0;
        background-color: transparent;
        position: relative;
    }

    .dates-container {
        display: flex;
        overflow: hidden;
        width: 100%;
        padding-top: 15px;
    }

    .days-wrapper {
        display: flex;
        transition: transform 0.3s ease;
    }

    .calendar-day {
        flex: 0 0 auto;
        width: 43px;
        height: 75px;
        text-align: center;
        padding: 10px;
        border: 1px solid #ddd;
        margin: 0 10px;
        border-radius: 50px;
        cursor: pointer;
        border: 2px solid #0040E6;
    }

    .calendar-day.is-selected {
        background-color: #0040E6;
        color: white;
    }

    .calendar-day-label,
    .calendar-date-label {
        display: block;
    }

    .surcharge-badge {
        color: red;
    }

    .surcharge-badge-timeslot {
        color: red;
        padding-top: 20px;
        /*        display: inline-block;*/
    }

    .surcharge-badge-timeslot span {
        position: absolute;
        left: 0;
        right: 0;
        margin-left: auto;
        margin-right: auto;
        width: 75px;
        text-align: center;
        background: #ffda40;
        padding: 0px 5px;
        color: #000;
        top: 3px;
        border-radius: 10px;
    }

    .surcharge-badge-dayslot {
        color: red;
        width: 30%;
        display: inline-block;
    }

    .surcharge-badge-dayslot span {
        position: relative;
        top: -83px;
        right: 24px;
        background: #ffda40;
        padding: 2px 3px;
        color: #000;
        white-space: nowrap;
        font-size: 13px;
        border-radius: 8px;

    }

    .button_weekly label {
        width: 83% !important;
        padding: 0 20px;
        padding-top: 10px;
    }

    @media (max-width: 768px) {
        .button_weekly label {
            width: 100% !important;
        }
    }

    .button_weekly ul li {
        list-style-type: "- " !important;
        margin-left: -20px;
    }

    .hour_input label {
        border-radius: 50px;
        padding: 7px 28px;
        width: 95%;
        text-align: center;
    }

    .hour_input span {
        position: absolute;
        left: 0;
        right: 0;
        margin-left: 3%;
        margin-right: auto;
        width: 62px;
        text-align: center;
        background: #ffda40;
        padding: 0px 5px;
        color: #000;
        top: -12%;
        border-radius: 10px;
        font-weight: 1000;
    }

    .material label {
        border-radius: 50px;
        padding: 12px 24px;
    }

    .fw500 {
        font-weight: 1000;
        font-size: 16px;
    }

    .cleaning_weekly_new {
        color: #222222;
        float: right;
        background-color: #ffda40;
        padding: 0 4px 0 4px;
        border-radius: 7px;
        font-size: 13px;
    }

    .dettol {
        display: contents;
        "

    }

    .mid_col {
        box-shadow: 0 6px 15px #00000029;
        padding: 13px 13px 13px 13px;
        border-radius: 10px;
    }

    .last_col {
        box-shadow: 0px 6px 15px #00000029;
        /* box-shadow: 0 0 10px 2px rgba(0,0,0,0.1); */
        padding: 13px 13px 13px 13px;
        border-radius: 10px;
    }

    .last_col h3 {
        text-align: center;
    }

    .underline {
        border: 1px solid #707070;
        border-style: dashed;
        color: #707070;
        display: inline-block;
        width: 100%;
        margin: 10px 0
    }

    .step-underline {
        border: 1px solid #707070;
        color: #707070;
        width: 206%;
        display: inline-block;
    }

    .font-weight-bold-summary {
        font-weight: 1000;
    }

    .payment-type {
        display: inline;
    }

    /* .payment-li{
        width: 100% !important;
    } */
    .sm-summary {
        max-width: 60%;
        text-align: right;
        color: #0040E6;
    }

    .step-p {
        margin: 0 0 -10px 34%;
        font-size: 21px;
    }

    .step-title {
        margin-left: 34%;
    }

    .custome-black {
        background-color: #000 !important;
        border: 2px solid #000 !important;
        color: #ffffff;
        border-radius: 50px;
        padding: 7px 40px 7px 40px;
    }

    .custome-black:hover {
        border: 2px solid #000 !important;
        background-color: #000 !important;
    }

    .custome-black:hover:before {
        background-color: #000 !important;
    }

    .left-summary-total {
        background-color: #0040E6;
        color: #fff;
        padding: 13px 0px;
        border-radius: 11px;
    }

    .left-summary-without-cross-total {
        background-color: #0040E6;
        color: #fff;
        padding: 16px 0px 7px 67px;
        border-radius: 11px;
    }

    .main-title {
        margin-bottom: 25px;
    }

    .firstBlur {
        /* margin:50px 20px 0; */
        padding: 20px;
        position: relative;
    }

    /* === CSS FILTER EFFECTS === */
    .firstBlur.modalBlur>*:not(.modal) {
        -webkit-filter: blur(7px) !important;
    }

    .firstBlur.modalDesaturate>*:not(.modal) {
        -webkit-filter: saturate(0%) !important;
    }

    /* === SOFTEN THE MODAL BACKDROP SO THE EFFECT IS MORE VISIBLE === */
    .modal-backdrop {
        opacity: 0.65;
        filter: alpha(opacity=65) !important;
    }

    .selected-color-label-display {
        display: none !important;
    }

    .moving-in-out-painting-show {
        display: none !important;
    }

    .additional-charges-display {
        display: none !important;
    }

    .selected-ceilings-label-display {
        display: none !important;
    }

    .summary-movein-out-service-show {
        display: none !important;
    }

    .summary-paint-rooms-hide {
        display: none !important;
    }

    .summary-paint-walls-hide {
        display: none !important;
    }

    .mobile-total-price-btn {
        display: none !important;
    }

    .qoute-summary-rooms {
        display: none !important;
    }

    .qoute-summary-walls {
        display: none !important;
    }


    /* VCSS */
    .first-edit {
        position: relative;
    }

    .first-edit-anch {
        position: absolute;
        top: auto;
        text-decoration: underline;
        left: 93%;
        bottom: 15%;
    }


    .spinner_button {
        background-color: #000 !important;
        border: 2px solid #000 !important;
        color: #ffffff;
        border-radius: 50px;
        padding: 7px 40px 7px 40px;
    }

    .container {
        max-width: 960px !important;
    }

    .modal-title {
        font-size: 20px;
    }

    .booknow-otp-input {
        padding-left: 0px !important;
    }

    .book-email-otp-input {
        padding-left: 0px !important;
    }

    /* Stepper Progress Bar & modern layout from enquiry_sub */
    .stepper-progress-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 600px;
        margin: 0 auto 0px auto;
        padding: 0 10px;
    }

    .step-item-new {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
        flex: 1;
    }

    .step-circle-new {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background-color: #E2E8F0;
        color: #64748B;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 700;
        font-size: 16px;
        border: 4px solid #F8FAFC;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }

    .step-label-new {
        font-size: 13px;
        font-weight: 600;
        color: #64748B;
        margin-top: 8px;
        transition: all 0.3s ease;
    }

    .step-line-new {
        height: 4px;
        background-color: #E2E8F0;
        flex: 1;
        margin: -22px 0 0 0;
        position: relative;
        z-index: 1;
        border-radius: 2px;
    }

    .step-item-new.active .step-circle-new {
        background-color: #0040E6;
        color: #ffffff;
        box-shadow: 0 0 0 4px rgba(0, 64, 230, 0.15);
    }

    .step-item-new.active .step-label-new {
        color: #0040E6;
        font-weight: 700;
    }

    .step-item-new.completed .step-circle-new {
        background-color: #10B981;
        color: #ffffff;
    }

    .step-item-new.completed .step-label-new {
        color: #10B981;
    }

    .step-line-new.completed {
        background-color: #10B981;
    }

    .enquiry-layout-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
        align-items: start;
        margin-top: 10px;
        max-width: 760px;
        margin-left: auto;
        margin-right: auto;
    }

    .enquiry-left-column {
        display: flex;
        flex-direction: column;
        gap: 24px;
        width: 100%;
    }

    .enquiry-card-ui {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
        padding: 35px;
        border: 1px solid rgba(0, 64, 230, 0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-title-new {
        font-size: 19px;
        font-weight: 700;
        color: #0F172A;
        margin-bottom: 25px;
        border-bottom: 1px solid #F1F5F9;
        padding-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .requiredStar::after {
        content: "*";
        color: #EF4444;
        margin-left: 4px;
    }

    .detail-list li {
        display: flex;
        justify-content: space-between;
        padding: 14px 0;
        border-bottom: 1px solid #F1F5F9;
    }

    .detail-list li:last-child {
        border-bottom: none;
    }

    /* Back button style */
    .btn-back-step {
        background: #F1F5F9;
        color: #475569 !important;
        border-radius: 10px;
        padding: 15px 30px;
        font-weight: 700;
        font-size: 16px;
        width: 100%;
        border: none;
        transition: all 0.25s ease;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        height: 52px !important;
    }

    .btn-back-step:hover {
        background: #E2E8F0;
    }

    /* Buttons */
    .enquiry-card-ui .btn-thm,
    .btn-thm {
        background: #0040E6 !important;
        color: #fff !important;
        border-radius: 10px !important;
        padding: 15px 30px !important;
        font-weight: 700 !important;
        font-size: 16px !important;
        width: 100% !important;
        border: none !important;
        transition: all 0.25s ease !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        gap: 10px !important;
        cursor: pointer !important;
        box-shadow: 0 4px 12px rgba(0, 64, 230, 0.15) !important;
        position: relative !important;
        overflow: hidden !important;
        height: 52px !important;
    }

    .enquiry-card-ui .btn-thm:hover,
    .btn-thm:hover {
        background: #0033B8 !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 6px 20px rgba(0, 64, 230, 0.25) !important;
    }

    /* Enforce hidden state on theme buttons when hidden by jQuery or inline styles */
    .btn-thm[style*="display: none"],
    .btn-thm[style*="display:none"] {
        display: none !important;
    }

    /* Disable expanding pseudo-elements on hover for custom wizard buttons */
    .enquiry-card-ui .btn-thm::before,
    .enquiry-card-ui .btn-thm::after,
    .btn-thm::before,
    .btn-thm::after {
        display: none !important;
        content: none !important;
    }

    #describe_your_requirements {
        height: 100px;
    }

    /* CSS overrides for Splide grid wrap on Desktop */
    @media (min-width: 769px) {

        #unit_you_live_slider_spatie .splide__list,
        .size-of-home-slider-class .splide__list {
            display: flex !important;
            flex-wrap: wrap !important;
            transform: none !important;
            gap: 12px;
        }

        #unit_you_live_slider_spatie .splide__slide,
        .size-of-home-slider-class .splide__slide {
            width: auto !important;
            margin: 0 !important;
        }

        #unit_you_live_slider_spatie .splide__arrows,
        .size-of-home-slider-class .splide__arrows {
            display: none !important;
        }
    }

    @media (max-width: 768px) {

        /* Splide Slider styling on mobile */
        #unit_you_live_slider_spatie,
        .size-of-home-slider-class {
            padding: 0 30px !important;
        }

        #unit_you_live_slider_spatie .splide__arrow--prev,
        .size-of-home-slider-class .splide__arrow--prev {
            left: 0px !important;
        }

        #unit_you_live_slider_spatie .splide__arrow--next,
        .size-of-home-slider-class .splide__arrow--next {
            right: 0px !important;
        }

        #unit_you_live_slider_spatie .splide__arrow,
        .size-of-home-slider-class .splide__arrow {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            width: 24px !important;
            height: 24px !important;
            opacity: 0.8 !important;
        }

        #unit_you_live_slider_spatie .splide__arrow svg,
        .size-of-home-slider-class .splide__arrow svg {
            width: 14px !important;
            height: 14px !important;
            fill: #475569 !important;
        }

        #unit_you_live_slider_spatie .splide__slide .radio-card-item,
        .size-of-home-slider-class .splide__slide .radio-card-item {
            width: 100% !important;
            min-width: 0 !important;
            padding: 6px 2px !important;
            box-sizing: border-box !important;
        }

        .radio-card-label,
        .checkbox-card-label {
            font-size: 12px !important;
        }
    }

    /* Responsive Spacing & Header Overlap Fixes */
    .our-register {
        padding: 140px 0 80px 0 !important;
        /* Extra padding to prevent sticky header overlap on desktop */
    }

    .main-title {
        margin-bottom: 15px !important;
    }

    .main-title .title {
        font-size: 32px;
        line-height: 1.2;
        margin-bottom: 10px !important;
    }

    .stepper-progress-container {
        max-width: 480px;
        /* More compact for 2 steps */
        margin: 0 auto 20px auto !important;
    }

    @media only screen and (max-width: 600px) {
        .form-group label {
            font-size: 10px !important;
        }
    }

    /* Media Queries for Tablet & Mobile Support */
    @media (max-width: 991px) {
        .our-register {
            padding: 40px 0 50px 0 !important;
            /* Significantly reduced top padding */
        }

        .main-title .title {
            font-size: 26px;
            margin-bottom: 20px;
        }
    }

    @media (max-width: 768px) {
        .modal-dialog {
            max-width: 90% !important;
        }

        #unit_you_live_slider_spatie {
            padding: 0 35px;
        }

        #unit_you_live_slider_spatie .splide__arrow--prev {
            left: 0px;
        }

        #unit_you_live_slider_spatie .splide__arrow--next {
            right: 0px;
        }

        .radio-card-group,
        .checkbox-card-group {
            gap: 8px;
        }

        .radio-card-item,
        .checkbox-card-item {
            padding: 8px 18px;
            min-width: 90px;
        }

        .detail-list {
            font-size: 13px;
        }
    }

    @media (max-width: 576px) {
        .our-register {
            padding: 0px 0 40px 0 !important;
            /* Significantly reduced top padding */
        }

        .main-title .title {
            font-size: 22px;
            margin-bottom: 15px;
        }

        .enquiry-card-ui {
            padding: 20px 15px !important;
            /* Smaller padding inside cards on mobile */
            border-radius: 12px;
        }

        .stepper-progress-container {
            margin-bottom: 25px;
        }

        .step-circle-new {
            width: 36px;
            height: 36px;
            font-size: 14px;
            border-width: 3px;
        }

        .step-line-new {
            margin: -18px 0 0 0;
            /* Align with center of 36px circle */
        }

        .step-label-new {
            font-size: 11px;
            margin-top: 6px;
        }

        .radio-group label {
            padding: 8px 16px !important;
            font-size: 13px !important;
        }

        .hour_input label {
            padding: 8px 16px !important;
            font-size: 13px !important;
        }

        .dates-container {
            justify-content: center;
        }

        .calendar-day {
            width: 38px;
            height: 68px;
            margin: 0 5px;
            padding: 6px;
        }
    }
</style>
<section class="our-register">
    <div class="container">

        <div class="row">
            <div class="col-lg-6 m-auto wow fadeInUp" data-wow-delay="300ms">
                <div class="main-title text-center">
                    <h2 class="title" id="head_hide" style="display: block">YOUR QUOTE REQUEST</h2>
                    {{-- <p class="paragraph">Give your visitor a smooth online experience with a solid UX design</p> --}}
                </div>
            </div>
        </div>

        <!-- Progress Stepper -->
        <div class="row mb-4" id="enquiry_stepper_row">
            <div class="col-12">
                <div class="stepper-progress-container" style="max-width: 480px;">
                    <div class="step-item-new active" id="step1_indicator">
                        <div class="step-circle-new">1</div>
                        <div class="step-label-new">Job Details</div>
                    </div>
                    <div class="step-line-new" id="step_line_1"></div>
                    <div class="step-item-new" id="step2_indicator">
                        <div class="step-circle-new">2</div>
                        <div class="step-label-new">Summary Details</div>
                    </div>
                </div>
            </div>
        </div>

        <form id="category_form_new" action="{{ route('book-now-garden-order') }}" method="POST">
            @csrf
            <input type="hidden" name="service" id="service" value="{{ $service_id }}">
            <input type="hidden" name="subservice" id="subservice" value="{{ $subservice_id }}">
            <input type="hidden" name="size_of_home_id" id="size_of_home_id" value="">

            <div class="enquiry-layout-grid wow fadeInRight" data-wow-delay="300ms">
                <!-- Left Column -->
                <div class="enquiry-left-column">

                    <!-- STEP 1: Job Details Form -->
                    <div class="enquiry-card-ui" id="step1_container">
                        @if ($subservice_id == 78 || $subservice_id == 77)

                            @if ($subservice_id == 78)
                                <div class="image mb-4">
                                    <img src="https://servicemarket.com/_next/image?url=%2Fdist%2Fcss%2Fimg%2Fservice%2Fgardening-companies%2Fgardening-companies.jpg&w=1920&q=75"
                                        width="100%" style="border-radius: 12px;">
                                </div>
                            @elseif($subservice_id == 77)
                                <div class="image mb-4">
                                    <img src="https://servicemarket.com/_next/image?url=%2Fdist%2Fcss%2Fimg%2Fservice%2Fpest-control-companies%2Fpest-control.jpg&w=1920&q=75"
                                        width="100%" style="border-radius: 12px;">
                                </div>
                            @endif

                            @if ($subservice_id == 78)
                                <h5 class="font-weight-bold h3 mt-3">Get quotes for your {{ $subservice_name }} Services
                                </h5>
                                <p class="card-text mb-4"><span>Get up to 5 free quotes from top companies by filling
                                        out this short form.</span><br />
                                    <a href="javascript:void(0)" data-bs-toggle="modal" id="read_more"
                                        data-bs-target="#GardeningModal_{{ $subservice_id }}"
                                        style="text-decoration: underline; color: #0040E6;">
                                        Read more
                                    </a>
                                </p>
                            @endif

                            @if ($subservice_id == 77)
                                <h5 class="font-weight-bold h3 mt-3">Get quotes for your {{ $subservice_name }} Services
                                </h5>
                                <p class="card-text mb-4"><span>Get up to 5 free quotes from top companies by filling
                                        out this short form.</span><br />
                                    <a href="javascript:void(0)" data-bs-toggle="modal" id="read_more"
                                        data-bs-target="#MousePestModal_{{ $subservice_id }}"
                                        style="text-decoration: underline; color: #0040E6;">
                                        Read more
                                    </a>
                                </p>
                            @endif

                            @if ($subservice_id == 78)
                                <div class="form-group mb-3">
                                    <label class="form-label fw500 dark-color requiredStar" for="service_type">Which
                                        service do you need quotes for?</label>
                                    <select class="form-control searches_drop form-select" id="service_type"
                                        name="service_type" onchange="garden_calculation();">
                                        @php
                                            $GardeningService = [
                                                'General gardening and maintenance',
                                                'Annual gardening contract',
                                                'Gazebos, decks and porches',
                                                'Grass and artificial lawns',
                                                'Landscaping',
                                            ];
                                        @endphp
                                        <option value="">Select Service Type</option>
                                        @foreach ($GardeningService as $garden)
                                            <option value="{{ $garden }}">
                                                {{ $garden }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p style="color:red;" id="service_type_error"></p>
                                </div>
                            @endif

                            <div class="form-group mb-3">
                                <label class="form-label fw500 dark-color requiredStar" for="service_date">When do you
                                    need the service?</label> <br>
                                <input type="text" name="service_date" id="service_date" class="form-control"
                                    placeholder="Service Date" onchange="garden_calculation();">
                                <p style="color:red;" id="service_date_error"></p>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label fw500 dark-color requiredStar" for="city">Which city do
                                    you need the service?</label> <br>
                                <select class="form-control searches_drop form-select" id="city" name="city">
                                    <option value="">Select City</option>
                                    @foreach ($city_data as $data)
                                        <option value="{{ $data->id }}">
                                            {{ $data->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p style="color:red;" id="city_error"></p>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label fw500 dark-color requiredStar" for="address">Where do you
                                    need the service?</label> <br>
                                <input type="text" name="address" id="address" class="form-control"
                                    placeholder="Enter Address">
                                <p style="color:red;" id="address_error"></p>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label fw500 dark-color requiredStar" for="type_of_home">What is the
                                    type of the unit you live in?</label><br>

                                <div id="unit_you_live_slider_spatie" class="splide radio-group">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            @php
                                                $form_attributes_data = DB::table('form_attributes')
                                                    ->where('form_id', $form_fileds_data->id)
                                                    ->get();
                                            @endphp
                                            @foreach ($form_attributes_data as $attributes_data)
                                                @if (!($subservice_id == 78 && $attributes_data->form_option == 'Warehouse'))
                                                    <li class="splide__slide text-center" style="cursor: pointer;">
                                                        <label class="radio-card-item"
                                                            for="type-of-home-{{ $attributes_data->id }}"
                                                            style="cursor: pointer; width: 100%; display: inline-flex;">
                                                            <input type="radio"
                                                                id="type-of-home-{{ $attributes_data->id }}"
                                                                name="type_of_home"
                                                                value="{{ $attributes_data->form_option }}"
                                                                onclick="type_of_homeGarden('{{ $attributes_data->form_option }}');">
                                                            <span
                                                                class="radio-card-label">{{ $attributes_data->form_option }}</span>
                                                        </label>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <p style="color:red;" id="type_of_home_error"></p>
                            </div>

                            @foreach ($form_attributes_data as $attributes_data)
                                @php
                                    if ($attributes_data->form_option == 'Apartment') {
                                        $form_option = 'Apartment';
                                    } elseif ($attributes_data->form_option == 'Villa') {
                                        $form_option = 'Villa';
                                    } elseif ($attributes_data->form_option == 'Warehouse') {
                                        $form_option = 'Warehouse';
                                    } elseif ($attributes_data->form_option == 'Office') {
                                        $form_option = 'Office';
                                    } else {
                                        $form_option = 'Other';
                                    }
                                @endphp
                                <div class="form-group main-garden-home-{{ $attributes_data->form_option }} {{ $form_option }} mb-3"
                                    style="display: none;">
                                    <label class="form-label fw500 dark-color requiredStar" for="size_of_home_1">What
                                        is the size of your home?</label><br>
                                    <div id="size_of_home_slider_{{ $attributes_data->id }}"
                                        class="splide radio-group size-of-home-slider-class">
                                        <div class="splide__track">
                                            <ul class="splide__list">
                                                @php
                                                    $more_form_attributes = DB::table('more_form_attributes')
                                                        ->where('form_id', $form_fileds_data->id)
                                                        ->where('attr_id', $attributes_data->id)
                                                        ->get();
                                                @endphp
                                                @foreach ($more_form_attributes as $more_attributes_data)
                                                    <li class="splide__slide text-center" style="cursor: pointer;">
                                                        <label class="radio-card-item"
                                                            for="{{ $more_attributes_data->id }}"
                                                            style="cursor: pointer; width: 100%; display: inline-flex;">
                                                            <input type="radio"
                                                                id="{{ $more_attributes_data->id }}"
                                                                name="size_of_home_1"
                                                                value="{{ $more_attributes_data->more_form_option }}">
                                                            <span
                                                                class="radio-card-label">{{ $more_attributes_data->more_form_option }}</span>
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <p style="color:red;" id="size_of_home_1_error"></p>

                            <div class="form-group mb-3">
                                <label class="form-label fw500 dark-color " for="describe_your_requirements">Please
                                    describe the job in as much detail as possible (Optional)</label>
                                <textarea name="describe_your_requirements" id="describe_your_requirements" class="form-control"
                                    placeholder="If you have any other requirements, feel free to describe them here in as much detail as you want. Or just leave us a message to call you if its easier to explain on the phone"></textarea>
                                <p class="form-error-text" id="describe_your_requirements_error"
                                    style="color: red; margin-top: 10px;"></p>
                            </div>
                        @endif

                        <!-- Step 1 Button -->
                        <div class="d-grid mt-4 pt-3" style="border-top: 1px solid #F1F5F9;">
                            <button type="button" class="btn-thm" onclick="goToStep2()" id="continue_button">
                                Continue <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2: Booking Summary & Final Submit -->
                    <div class="enquiry-card-ui" id="step2_container" style="display: none;">
                        <div class="card-title-new"
                            style="display: flex; align-items: center; gap: 10px; margin-bottom: 25px;">
                            <i class="fa-solid fa-clipboard-check" style="color: #0040E6; font-size: 20px;"></i>
                            <span style="font-size: 20px; font-weight: 700; color: #0F172A;">Booking Summary</span>
                        </div>

                        <ul class="detail-list" style="list-style: none; padding: 0; margin: 0 0 25px 0;">
                            <!-- <li style="display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #F1F5F9;">
                                <span style="color: #64748B; font-weight: 500;">Service Category</span>
                                <span style="color: #0F172A; font-weight: 600;">{!! Helper::servicename($service_id) !!}</span>
                            </li> -->
                            <li
                                style="display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #F1F5F9;">
                                <span style="color: #64748B; font-weight: 500;">Service Type</span>
                                <span style="color: #0F172A; font-weight: 600;">{!! Helper::subservicename($subservice_id) !!}</span>
                            </li>
                            @if ($subservice_id == 78)
                                <li
                                    style="display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #F1F5F9;">
                                    <span style="color: #64748B; font-weight: 500;">Specific Service</span>
                                    <span style="color: #0F172A; font-weight: 600;"
                                        id="summary_specific_service">-</span>
                                </li>
                            @endif
                            <li
                                style="display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #F1F5F9;">
                                <span style="color: #64748B; font-weight: 500;">Service Date</span>
                                <span style="color: #0F172A; font-weight: 600;" id="summary_service_date">-</span>
                            </li>
                            <li
                                style="display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #F1F5F9;">
                                <span style="color: #64748B; font-weight: 500;">City</span>
                                <span style="color: #0F172A; font-weight: 600;" id="summary_city">-</span>
                            </li>
                            <li
                                style="display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #F1F5F9;">
                                <span style="color: #64748B; font-weight: 500;">Address</span>
                                <span style="color: #0F172A; font-weight: 600;" id="summary_address">-</span>
                            </li>
                            <li
                                style="display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #F1F5F9;">
                                <span style="color: #64748B; font-weight: 500;">Unit Type</span>
                                <span style="color: #0F172A; font-weight: 600;" id="summary_unit_type">-</span>
                            </li>
                            <li style="display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #F1F5F9;"
                                id="summary_size_row">
                                <span style="color: #64748B; font-weight: 500;">Size of Home</span>
                                <span style="color: #0F172A; font-weight: 600;" id="summary_size_of_home">-</span>
                            </li>
                            <li
                                style="display: flex; flex-direction: column; padding: 14px 0; border-bottom: 1px solid #F1F5F9;">
                                <span style="color: #64748B; font-weight: 500; margin-bottom: 6px;">Job Details /
                                    Requirements</span>
                                <span style="color: #0F172A; font-weight: 600; font-size: 14px;"
                                    id="summary_requirements">-</span>
                            </li>
                        </ul>

                        <!-- Step 2 Actions -->
                        <div class="row mt-4 pt-3" style="border-top: 1px solid #F1F5F9;">
                            <div class="col-md-6 mb-2">
                                <button type="button" class="btn-back-step" onclick="goToStep1()">
                                    <i class="fa-solid fa-arrow-left"></i> Back to Edit
                                </button>
                            </div>
                            <div class="col-md-6 mb-2">
                                <button type="submit" class="btn-thm" id="book_now_garden" style="width: 100%;">
                                    Get Quote <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>

        {{-- Old hidden sidebar & mobile layouts for references --}}
        <div style="display: none;">
            <div class="col-lg-4" id="summary_div_left">
                <div id="summary_div_left_package" class="last_col">
                    <h3>Summary</h3>
                    <span class="underline"></span>
                    <div class="font-weight-bold-summary h5">Service Details</div>

                    @if ($subservice_id == 78 || $subservice_id == 77)

                        @if ($subservice_id == 78)
                            <div class="d-flex justify-content-between">
                                <div>Service Type</div>
                                <div class="font-weight-bold sm-summary" id="left_service_type"></div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <div>Date</div>
                            <div class="font-weight-bold sm-summary" id="left_service_date"></div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>Address</div>
                            <div class="font-weight-bold sm-summary" id="left_address"></div>
                        </div>
                        <span class="underline"></span>
                    @endif
                </div>
            </div>

            {{-- For mobile view Start --}}
            <div class="summary_div_left_mobile" id="summary_div_left_mobile" style="display: none;">
                <div class="summuryInner">
                    <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    @if ($subservice_id == 78 || $subservice_id == 77)
                        <h3>Summary</h3>
                        <span class="underline"></span>
                        <div class="font-weight-bold-summary h5">Service Details</div>

                        @if ($subservice_id == 78)
                            <div class="d-flex justify-content-between">
                                <div>Service Type</div>
                                <div class="font-weight-bold sm-summary" id="mobile_left_service_type"></div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <div>Date</div>
                            <div class="font-weight-bold sm-summary" id="mobile_left_service_date"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>Address</div>
                            <div class="font-weight-bold sm-summary" id="mobile_left_address"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@include('front.includes.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>




{{-- For Gardening Read more Popup Start --}}
<div class="modal modal-mobile-bottom" id="GardeningModal_{{ $subservice_id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div id="modal-digi" class="modal-dialog modal-dialog-bottom modal-dialog-centered" role="document"
        style="">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" style="font-size: 20px;">
                    How to use this service: </h5>
                <button type="button" class="close" id="close" data-bs-dismiss="modal" aria-label="Close"
                    style="background: none; font-size: 50px; color: #000; border: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <img src="https://servicemarket.com/_next/image?url=%2Fdist%2Fcss%2Fimg%2Fservice%2Fgardening-companies%2Fgardening-companies.jpg&w=640&q=75"
                        style="width: 100%; padding:5%;">
                </div>

                <div class="col-md-6">

                    <ul style="list-style-type: disc; list-style: inherit;">
                        <li style="list-style: inherit;">Fill out this short form, and our professional companies will
                            submit their best quote for your request.</li>
                        <li style="list-style: inherit;">You will receive the quotes over email, and can view them
                            anytime in your User account, under My Quotes.</li>
                        <li style="list-style: inherit;">Compare your quotes and user reviews, choose the company of
                            your choice, and contact them directly to book a service.</li>
                        <li style="list-style: inherit;">All companies on our platform are licensed and vetted through
                            hundreds of genuine customer reviews.</li>
                    </ul>

                </div>

            </div>

        </div>
    </div>
</div>

{{-- For Gardening Read more Popup End --}}

{{-- For Mouse and pest Read more Popup Start --}}
<div class="modal modal-mobile-bottom" id="MousePestModal_{{ $subservice_id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div id="modal-digi" class="modal-dialog modal-dialog-bottom modal-dialog-centered" role="document"
        style="">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" style="font-size: 20px;">
                    How to use this service: </h5>
                <button type="button" class="close" id="close" data-bs-dismiss="modal" aria-label="Close"
                    style="background: none; font-size: 50px; color: #000; border: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <img src="https://servicemarket.com/_next/image?url=%2Fdist%2Fcss%2Fimg%2Fservice%2Fpest-control-companies%2Fpest-control.jpg&w=1920&q=75"
                        style="width: 100%; padding:5%;">
                </div>

                <div class="col-md-6">

                    <ul style="list-style-type: disc; list-style: inherit;">
                        <li style="list-style: inherit;">Fill out this short form, and our professional companies will
                            submit their best quote for your request.</li>
                        <li style="list-style: inherit;">You will receive the quotes over email, and can view them
                            anytime in your User account, under My Quotes.</li>
                        <li style="list-style: inherit;">Compare your quotes and user reviews, choose the company of
                            your choice, and contact them directly to book a service.</li>
                        <li style="list-style: inherit;">All companies on our platform are licensed and vetted through
                            hundreds of genuine customer reviews.</li>
                    </ul>

                </div>

            </div>

        </div>
    </div>
</div>

{{-- For Mouse pest Read more Popup End --}}

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
                            <input type="text" class="input-field" name="phone" id="user-phone-number"
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
                            <input type="text" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="text" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="text" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="text" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="text" maxlength="1" class="booknow-otp-input form-control text-center"
                                style="width: 40px;">
                            <input type="text" maxlength="1" class="booknow-otp-input form-control text-center"
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
                            <input type="text" class="form-control" name="book_email_name" id="book_email_name"
                                placeholder="Full Name">
                            <p id="book_email_name_error" style="display:none;color:red;"></p>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" id="book_email_mobile"
                                name="book_email_mobile" placeholder="Phone Number"
                                onkeypress="return validateNumber(event)">
                            <p id="book_email_mobile_error" style="display:none;color:red;"></p>
                        </div>
                        {{-- <div class="form-group mt-3">
            <input type="text" class="form-control" id="book_email_area" name="book_email_area" placeholder="Area">
            <p id="book_email_area_error" style="display:none;color:red;"></p>
        </div> --}}
                        <div class="text-center mt-3">
                            <button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                type="button" disabled id="spinner_button_email_book3" style="display: none;"><span
                                    class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>Loading...</button>

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

<script>
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

    /* const phoneInputField = document.querySelector("#user-phone-number"); // flagphone
    const phoneInput = window.intlTelInput(phoneInputField, {
      initialCountry: "ae",  // UAE flag and country code (+971) as default
      separateDialCode: true, // Separate country code from the number field
      autoPlaceholder: "aggressive",
      utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });

    // Function to get the selected country code
    function getCountryCode() {
      const countryData = phoneInput.getSelectedCountryData();
      const countryCode = countryData.dialCode; // Get the dial code (country code)
      console.log(countryCode); // Example: "+971" for UAE
      return countryCode;
    } */

    document.addEventListener("DOMContentLoaded", function() {
        const Otpphoneinput = document.querySelector("#user-phone-number");

        const Otpphoneinputnew = window.intlTelInput(Otpphoneinput, {
            initialCountry: "ae", // UAE
            separateDialCode: true,
            autoPlaceholder: "aggressive",
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        // Assign globally
        window.Otpphoneinputnew = Otpphoneinputnew;

        // Update hidden country code when user selects a country
        const countryCodeInput = document.querySelector("#country_code_otp_popup_Modal_book");

        function setCountryCode() {
            const countryData = Otpphoneinputnew.getSelectedCountryData();
            countryCodeInput.value = countryData.dialCode; // store only dial code (e.g. 971)
            // If you want full ISO code (like 'AE') → use countryData.iso2
        }

        // Set default initially
        setCountryCode();

        // Listen to country change
        Otpphoneinput.addEventListener("countrychange", function() {
            setCountryCode();
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const Otpphoneinput = document.querySelector("#book_email_mobile");

        const Otpphoneinputnew = window.intlTelInput(Otpphoneinput, {
            initialCountry: "ae", // UAE
            separateDialCode: true,
            autoPlaceholder: "aggressive",
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        // Assign globally
        window.Otpphoneinputnew = Otpphoneinputnew;

        // Update hidden country code when user selects a country
        const countryCodeInput = document.querySelector("#country_code_book_popup_Modal_book");

        function setCountryCode() {
            const countryData = Otpphoneinputnew.getSelectedCountryData();
            countryCodeInput.value = countryData.dialCode; // store only dial code (e.g. 971)
            // If you want full ISO code (like 'AE') → use countryData.iso2
        }

        // Set default initially
        setCountryCode();

        // Listen to country change
        Otpphoneinput.addEventListener("countrychange", function() {
            setCountryCode();
        });
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
            var country_code = $('#country_code_otp_popup_Modal_book').val();
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    'mobile': mobile,
                    'country_code': country_code
                },
                beforeSend: function() {

                    $('#spinner_button_phone_book1').show();
                    $('#submit_button_phone_book1').hide();
                    //$('.detail-continue-btn').prop('disabled', true);
                },
                success: function(response) {

                    if (response.success === true) {

                        $("#booknow_refresh_otp_div").load(location.href + " #booknow_refresh_otp_div");

                        document.getElementById('booknow-step-phone').style.display = 'none';
                        document.getElementById('booknow-step-otp').style.display = 'block';
                        document.getElementById('modalStepTitle').innerText = "Verify your phone number";

                        $('#booknow-whatsapp-number').text('+' + country_code + mobile);

                        if (response.user_data) {
                            $('#booknow_user_name').val(response.user_data.name);
                            $('#booknow_user_email').val(response.user_data.email);
                        }

                    }

                    $('#spinner_button_phone_book1').hide();
                    $('#submit_button_phone_book1').show();


                },
                error: function(xhr) {

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
                complete: function() {
                    $('.detail-continue-btn').prop('disabled', false);
                }
            });

            return false;


        }

        // STEP 2: OTP Verification
        if (id == '2') {
            var allFilled = true;
            jQuery('.booknow-otp-input').each(function() {
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

            if (otp != enteredOtp) {
                jQuery('#booknow_otp_error').html("OTP doesn't match");
                jQuery('#booknow_otp_error').show().delay(0).fadeIn('show');
                jQuery('#booknow_otp_error').show().delay(2000).fadeOut('show');
                return false;
            }



            let name = jQuery("input[name='book_name']").val().trim();
            let email = jQuery("input[name='book_email']").val().trim();

            $('#spinner_button_phone_book2').show();
            $('#submit_button_phone_book2').hide();

            if (name !== '' && email !== '') {
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

    $(document).ready(function() {
        $('.booknow-otp-input').on('input', function() {
            let input = $(this);
            let value = input.val();
            if (/^\d$/.test(value)) {
                input.next('.booknow-otp-input').focus();
            } else {
                input.val('');
            }
        });

        $('.booknow-otp-input').on('keydown', function(e) {
            let input = $(this);
            if (e.key === "Backspace" && input.val() === '') {
                input.prev('.booknow-otp-input').focus();
            }
        });

        $('.booknow-otp-input').on('paste', function(e) {
            let data = e.originalEvent.clipboardData.getData('text');
            let digits = data.replace(/\D/g, '').substring(0, 6).split('');
            $('.booknow-otp-input').each(function(index, element) {
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
                beforeSend: function() {

                    $('#spinner_button_email_book1').show();
                    $('#submit_button_email_book1').hide();

                    //$('.email-detail-continue-btn').prop('disabled', true);
                },
                success: function(response) {

                    if (response.success === true) {

                        $("#book_email_refresh_otp_div").load(location.href +
                            " #book_email_refresh_otp_div");

                        document.getElementById('book-email-step-phone').style.display = 'none';
                        document.getElementById('booknow-email-step-otp').style.display = 'block';
                        document.getElementById('booknow_email_modalStepTitle').innerText =
                            "Verify your Email";

                        $('#book_email_address_model').text(email_email);

                        if (response.user_data) {
                            $('#book_email_name').val(response.user_data.name);
                            $('#book_email_mobile').val(response.user_data.mobile);
                            $('#country_code_book_popup_Modal_book').val(response.user_data.country_code);
                            //$('#book_email_area').val(response.user_data.area);
                        }

                    }


                },
                error: function(xhr) {

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
                complete: function() {

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
            jQuery('.book-email-otp-input').each(function() {
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

            if (otp != enteredOtp) {
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
            // var email_area = jQuery("input[name='book_email_area']").val().trim();

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
            /* if (email_area === '') {

            jQuery('#book_email_area_error').html("Please Enter Area");
            jQuery('#book_email_area_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_area_error').show().delay(2000).fadeOut('show');
            return false;
        } */

            $('#spinner_button_email_book3').show();
            $('#submit_button_email_book3').hide();

            // All validation passed, submit the form
            jQuery("#bookemailOtpForm").submit();
        }
    }

    $(document).ready(function() {
        $('.book-email-otp-input').on('input', function() {
            let input = $(this);
            let value = input.val();
            if (/^\d$/.test(value)) {
                input.next('.book-email-otp-input').focus();
            } else {
                input.val('');
            }
        });

        $('.book-email-otp-input').on('keydown', function(e) {
            let input = $(this);
            if (e.key === "Backspace" && input.val() === '') {
                input.prev('.book-email-otp-input').focus();
            }
        });

        $('.book-email-otp-input').on('paste', function(e) {
            let data = e.originalEvent.clipboardData.getData('text');
            let digits = data.replace(/\D/g, '').substring(0, 6).split('');
            $('.book-email-otp-input').each(function(index, element) {
                $(element).val(digits[index] || '');
            });
            if (digits.length > 0) {
                $('.book-email-otp-input').eq(digits.length - 1).focus();
            }
            e.preventDefault();
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const otpModal = document.getElementById('exampleModalLong');

        otpModal.addEventListener('shown.bs.modal', function() {
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
            //document.getElementById('book_email_area').value = '';
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
            //document.getElementById('book_email_area_error').style.display = 'none';

            // Reset spinner buttons and enable primary buttons
            ['1', '2', '3'].forEach(step => {
                document.getElementById(`spinner_button_phone_book${step}`).style.display =
                    'none';
                document.getElementById(`submit_button_phone_book${step}`).style.display =
                    'inline-block';
            });
            ['1', '2', '3'].forEach(step => {
                document.getElementById(`spinner_button_email_book${step}`).style.display =
                    'none';
                document.getElementById(`submit_button_email_book${step}`).style.display =
                    'inline-block';
            });
        });
    });


    // Initialize Splide Sliders with breakpoint configurations
    $(document).ready(function() {
        // Type of Unit Live in Splide
        new Splide('#unit_you_live_slider_spatie', {
            type: 'slide',
            perPage: 3,
            focus: 0,
            autoplay: false,
            pagination: false,
            arrows: true,
            gap: '10px',
            trimSpace: true,
            mediaQuery: 'min',
            breakpoints: {
                769: {
                    destroy: true,
                },
            }
        }).mount();

        // Size of Home Splides
        const sizeSliders = document.querySelectorAll('.size-of-home-slider-class');
        sizeSliders.forEach(slider => {
            new Splide(slider, {
                type: 'slide',
                perPage: 4,
                focus: 0,
                autoplay: false,
                pagination: false,
                arrows: true,
                gap: '10px',
                trimSpace: true,
                mediaQuery: 'min',
                breakpoints: {
                    769: {
                        destroy: true,
                    },
                }
            }).mount();
        });
    });


    function type_of_homeGarden(value) {

        if (value == 'Apartment') {
            $('.main-garden-home-' + value).show();
            $('.Villa').hide();
            $('.Warehouse').hide();
            $('.Office').hide();
            $('.Other').hide();
        } else if (value == 'Villa') {
            $('.main-garden-home-' + value).show();
            $('.Apartment').hide();
            $('.Warehouse').hide();
            $('.Office').hide();
            $('.Other').hide();
        } else if (value == 'Warehouse') {
            $('.main-garden-home-' + value).show();
            $('.Apartment').hide();
            $('.Villa').hide();
            $('.Office').hide();
            $('.Other').hide();
        } else {
            $('.Apartment').hide();
            $('.Villa').hide();
            $('.Warehouse').hide();
            $('.Office').hide();
            $('.Other').hide();

        }
        $('.main-garden-home-' + value + ' input[type="radio"], .garden-villa-div input[type="radio"]').prop('checked',
            false);
    }

    $(function() {
        $('#service_date').datepicker({
            format: 'dd-mm-yyyy', // Ensure this format matches backend expectation
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function(e) {
            $(this).datepicker('hide'); // Hide datepicker after selection
        });
    });

    function garden_calculation() {

        let service_type = $('#service_type').val();
        let service_date = $('#service_date').val();

        $('#left_service_type').html(service_type);
        $('#mobile_left_service_type').html(service_type);
        $('#left_service_date').html(service_date);
        $('#mobile_left_service_date').html(service_date);
    }

    $(document).ready(function() {
        $('#address').on('input', function() {
            var address = $(this).val();
            $('#left_address').text(address);
            $('#mobile_left_address').text(address);
        });
    });

    function validateSizeOfHome() {


        var type_of_home_size = document.getElementsByName('size_of_home_1');
        var selected = false;

        // Loop through radio buttons to check if one is selected
        for (var i = 0; i < type_of_home_size.length; i++) {
            if (type_of_home_size[i].checked) {
                selected = true;
                break;
            }
        }

        if (!selected) {
            jQuery('#size_of_home_1_error').html("Please Select Size of Home");
            jQuery('#size_of_home_1_error').show().delay(0).fadeIn('show');
            jQuery('#size_of_home_1_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#size_of_home_1_error').offset().top - 150
            }, 1000);
            return false;
        }

        return true;

    }



    function goToStep2() {
        var subservice_id = jQuery('#subservice').val();
        if (subservice_id == 78) {
            var service_type = $('#service_type').val();
            if (service_type == '') {
                jQuery('#service_type_error').html("Please Select the type of Service");
                jQuery('#service_type_error').show().delay(0).fadeIn('show');
                jQuery('#service_type_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#service_type_error').offset().top - 150
                }, 1000);
                return false;
            }
        }

        var service_date = $('#service_date').val();
        if (service_date == '') {
            jQuery('#service_date_error').html("Please Select the Service Date");
            jQuery('#service_date_error').show().delay(0).fadeIn('show');
            jQuery('#service_date_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#service_date_error').offset().top - 150
            }, 1000);
            return false;
        }

        var city = $('#city').val();
        if (city == '') {
            jQuery('#city_error').html("Please Select City");
            jQuery('#city_error').show().delay(0).fadeIn('show');
            jQuery('#city_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#city_error').offset().top - 150
            }, 1000);
            return false;
        }

        var address = $('#address').val();
        if (address == '') {
            jQuery('#address_error').html("Please Enter Address");
            jQuery('#address_error').show().delay(0).fadeIn('show');
            jQuery('#address_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#address_error').offset().top - 150
            }, 1000);
            return false;
        }

        var type_of_home = document.querySelector('input[name="type_of_home"]:checked');
        if (type_of_home) {
            type_of_home = type_of_home.value;
        } else {
            type_of_home = '';
        }

        if (type_of_home == "") {
            jQuery('#type_of_home_error').html("Please Select Type of Home");
            jQuery('#type_of_home_error').show().delay(0).fadeIn('show');
            jQuery('#type_of_home_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#type_of_home_error').offset().top - 150
            }, 1000);
            return false;
        }

        if (type_of_home === "Apartment" || type_of_home === "Villa" || type_of_home === "Warehouse") {
            if (!validateSizeOfHome()) {
                return false;
            }
        }

        // Populate Summary
        if (subservice_id == 78) {
            $('#summary_specific_service').text($('#service_type').val());
        }
        $('#summary_service_date').text(service_date);
        $('#summary_city').text($('#city option:selected').text().trim());
        $('#summary_address').text(address);
        $('#summary_unit_type').text(type_of_home);

        var size_of_home = '';
        if (type_of_home === "Apartment" || type_of_home === "Villa" || type_of_home === "Warehouse") {
            var size_radio = document.querySelector('input[name="size_of_home_1"]:checked');
            if (size_radio) {
                size_of_home = size_radio.value;
            }
        }
        if (size_of_home) {
            $('#summary_size_row').show();
            $('#summary_size_of_home').text(size_of_home);
        } else {
            $('#summary_size_row').hide();
        }

        var reqs = $('#describe_your_requirements').val().trim();
        $('#summary_requirements').text(reqs ? reqs : 'None provided');

        // Stepper updates
        $('#step1_indicator').removeClass('active').addClass('completed');
        $('#step1_indicator .step-circle-new').html('<i class="fa-solid fa-check"></i>');
        $('#step_line_1').addClass('completed');
        $('#step2_indicator').addClass('active');

        // Hide Step 1, Show Step 2
        $('#step1_container').hide();
        $('#step2_container').show();
        $('html, body').animate({
            scrollTop: 0
        }, 500);
    }

    function goToStep1() {
        // Stepper updates
        $('#step1_indicator').removeClass('completed').addClass('active');
        $('#step1_indicator .step-circle-new').text('1');
        $('#step_line_1').removeClass('completed');
        $('#step2_indicator').removeClass('active');

        // Hide Step 2, Show Step 1
        $('#step2_container').hide();
        $('#step1_container').show();
        $('html, body').animate({
            scrollTop: 0
        }, 500);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('category_form_new');
        if (form) {
            form.addEventListener('submit', function() {
                const btn = document.getElementById('book_now_garden');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="margin-right: 8px;"></span>Loading...';
                }
            });
        }

        // Click handler to make sure clicking anywhere inside the entire li checks the radio button
        $(document).on('click', '.splide__slide', function(e) {
            if (!$(e.target).is('input') && !$(e.target).is('label') && !$(e.target).is(
                    '.radio-card-label')) {
                $(this).find('input[type="radio"]').trigger('click');
            }
        });
    });
</script>

<script>
    // Arrow Icon Click Event
    document.getElementById('aerrowicon').addEventListener('click', function() {
        var summaryDiv = document.getElementById('summary_div_left_mobile');
        var aerrowIcon = document.getElementById('aerrowicon');

        // Toggle the 'open' class on click to slide the div up or down
        if (summaryDiv.classList.contains('open')) {
            summaryDiv.classList.remove('open');
            aerrowIcon.style.transition = 'transform 0.3s ease'; // Smooth transition
            aerrowIcon.style.transform = 'rotate(0deg)'; // Reset rotation
        } else {
            summaryDiv.classList.add('open');
            aerrowIcon.style.transition = 'transform 0.3s ease'; // Smooth transition
            aerrowIcon.style.transform = 'rotate(180deg)'; // Rotate icon
        }
    });

    // Close Button Click Event
    document.getElementById('close').addEventListener('click', function() {
        var summaryDiv = document.getElementById('summary_div_left_mobile');
        var aerrowIcon = document.getElementById('aerrowicon');

        // Close the div and reset the arrow icon
        if (summaryDiv.classList.contains('open')) {
            summaryDiv.classList.remove('open');
            aerrowIcon.style.transition = 'transform 0.3s ease'; // Smooth transition
            aerrowIcon.style.transform = 'rotate(0deg)'; // Reset rotation
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('input[name="type_of_home"]').on('change', function() {

            const type_of_home = $('input[name="type_of_home"]:checked').val();
            let selectedId;

            if (type_of_home === "Office") {
                selectedId = 69;
            } else if (type_of_home === "Other") {
                selectedId = 70;
            } else {
                selectedId = "";
            }

            $('#size_of_home_id').val(selectedId);
        });
    });

    $(document).ready(function() {
        $('input[name="size_of_home_1"]').on('change', function() {
            let selectedId = $(this).attr('id');
            $('#size_of_home_id').val(selectedId);
        });
    });
</script>
