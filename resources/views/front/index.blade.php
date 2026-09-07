@include('front.includes.header')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <link rel="stylesheet" href="{{ asset('public/site/css/intlTelInput.css') }}" media="print" onload="this.media='all'">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
    <script src="{{ asset('public/site/js/intlTelInput.min.js') }}" defer></script>
@endpush

<!-- Tabby Banner Start -->
<div class="tabby-banner-wrapper" data-bs-toggle="modal" data-bs-target="#tabby_info_modal">
    <div class="container">
        <div class="tabby-banner-content d-flex align-items-center justify-content-center">
            <img src="https://cdn.tabby.ai/assets/logo.png" alt="Tabby" style="height: 20px; margin-right: 10px;">
            <span class="tabby-text">available on selected services</span>
            <i class="fas fa-info-circle tabby-banner-info-icon ms-2"></i>
        </div>
    </div>
</div>
<!-- Tabby Banner End -->
<style type="text/css">
    .funfact_one.at-home2-hero .timer,
    .funfact_one.at-home2-hero span {
        color: #000
    }

    /* Tabby Banner Styles */
    .tabby-banner-wrapper {
        background-color: #c1fada;
        padding: 8px 0;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 90;
        /* Lower than modal backdrop and header menus */
        position: fixed;
        top: 90px !important;
        width: 100%;
        border-bottom: 1px solid rgba(0, 160, 90, 0.1);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }

    /* Hide banner and lower header z-index when modal is open to avoid design issues on scroll */
    body.modal-open .tabby-banner-wrapper {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }

    body.modal-open {
        overflow: hidden !important;
        position: fixed;
        width: 100%;
    }

    body.modal-open header.stricky,
    body.modal-open .mobilie_header_nav {
        z-index: 100 !important;
    }

    .tabby-banner-wrapper:hover {
        background-color: #a8efc9;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    /* Prevent hero section from being covered by fixed banner */
    .hero-banner-section {
        margin-top: 34px;
    }

    @media (max-width: 991px) {
        .tabby-banner-wrapper {
            top: 70px;
            /* Fallback for mobile header */
            padding: 6px 0;
        }

        .hero-banner-section {
            margin-top: 40px;
        }

        .tabby-banner-content {
            font-size: 12px;
            padding: 0 15px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .tabby-banner-content img {
            height: 14px !important;
        }
    }

    .tabby-banner-content {
        /* display: flex; */
        text-align: center;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-family: var(--title-font-family);
        font-size: 15px;
        color: #000;
        font-weight: 500;
        letter-spacing: 0.2px;
    }

    .tabby-banner-logo {
        font-weight: 900;
        font-size: 18px;
        letter-spacing: -0.8px;
        text-transform: lowercase;
    }

    .tabby-banner-info-icon {
        font-size: 14px;
        color: #000;
        margin-left: 2px;
    }

    /* Tabby Modal Styles */
    .tabby-modal-content {
        padding: 10px 0;
    }

    .tabby-main-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .tabby-sub-title {
        font-size: 14px;
        color: #666;
        margin-bottom: 20px;
    }

    .tabby-divider {
        margin: 20px 0;
        border-top: 1px solid #eee;
    }

    .tabby-how-it-works-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .tabby-step-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 20px;
        text-align: left;
    }

    .tabby-step-number {
        background-color: #000;
        color: #fff;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .tabby-step-text {
        font-size: 14px;
        line-height: 1.4;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .tabby-banner-content {
            font-size: 11px;
            padding: 0 10px;
        }

        .tabby-banner-content img {
            height: 16px !important;
        }

        .tabby-banner-logo {
            font-size: 14px;
        }

        .tabby-banner-wrapper {
            top: 80px !important;
        }
    }

    /* Enhanced Tabby Modal Styles */
    .tabby-hero-section {
        background: linear-gradient(135deg, #f8fff9 0%, #e8fdf0 100%);
        border-bottom: 1px solid #d4f2e1;
    }

    .tabby-main-heading {
        font-family: var(--title-font-family);
        font-weight: 800;
        color: #111;
        letter-spacing: -0.5px;
    }

    .tabby-highlight {
        color: #00d37d;
        /* Tabby Green */
        position: relative;
        display: inline-block;
    }

    .tabby-sub-heading {
        color: #666;
        font-size: 16px;
        font-weight: 500;
    }

    .tabby-step-card {
        background: #fff;
        padding: 30px 20px;
        border-radius: 20px;
        border: 1px solid #eee;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        height: 100%;
    }

    .tabby-step-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        border-color: #c1fada;
    }

    .tabby-step-number-pill {
        width: 35px;
        height: 35px;
        background: #000;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 16px;
        margin: 0 auto 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .tabby-info-footer {
        border-top: 1px solid #eee;
        font-size: 13px;
        color: #888;
    }

    #tabby_info_modal .btn-close {
        background-color: #fff;
        opacity: 1;
        border-radius: 50%;
        padding: 10px;
        position: absolute;
        right: 20px !important;
        left: auto !important;
        top: 20px !important;
        z-index: 100;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    #tabby_info_modal .btn-close:hover {
        transform: rotate(90deg);
        opacity: 1;
    }

    /* Mobile Responsive Modal Adjustments */
    @media (max-width: 991px) {
        #tabby_info_modal .modal-dialog {
            margin: 10px auto;
            align-items: flex-start;
            /* Don't center vertically on mobile to avoid overlap */
            display: flex;
        }

        #tabby_info_modal .modal-content {
            margin-top: 90px;
            /* Ensure it starts below mobile header */
            background-color: #fff !important;
            /* Solid background to prevent overlap readability issues */
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        #tabby_info_modal .btn-close {
            right: 15px !important;
            top: 15px !important;
            padding: 8px;
            width: 32px;
            height: 32px;
            background-size: 12px;
        }

        .tabby-modal-left {
            padding: 30px 20px !important;
        }

        .tabby-main-heading {
            font-size: 24px !important;
            margin-bottom: 15px !important;
        }

        .tabby-sub-heading {
            font-size: 14px !important;
        }

        .tabby-modal-right {
            padding: 20px !important;
        }

        .tabby-step-card {
            padding: 15px !important;
            margin-bottom: 10px;
        }
    }

    /* Extra Large Tabby Modal Layout */
    @media (min-width: 992px) {
        .tabby-modal-body {
            display: flex;
            min-height: 500px;
        }

        .tabby-modal-left {
            flex: 0 0 35%;
            background: linear-gradient(135deg, #f8fff9 0%, #e8fdf0 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            border-right: 1px solid #d4f2e1;
        }

        .tabby-modal-right {
            flex: 0 0 65%;
            padding: 30px 40px;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    }

    .tabby-hero-section {
        background: transparent;
        border-bottom: none;
        padding: 0;
    }

    #tabbyFaq .accordion-item {
        border: none;
        margin-bottom: 10px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    #tabbyFaq .accordion-button {
        font-weight: 600;
        color: #333;
        padding: 18px 20px;
        background: #fff;
    }

    #tabbyFaq .accordion-button:not(.collapsed) {
        background: #f8fff9;
        color: #00d37d;
        box-shadow: none;
    }

    #tabbyFaq .accordion-button::after {
        filter: grayscale(1);
    }

    #tabbyFaq .accordion-body {
        color: #666;
        padding: 0 20px 20px;
        background: #f8fff9;
        font-size: 14px;
    }

    @media (max-width: 767px) {
        .tabby-main-heading {
            font-size: 24px;
        }

        .tabby-step-card {
            padding: 20px 15px;
            margin-bottom: 10px;
        }
    }
</style>
<style type="text/css">
    .listing-style1 {
        border: none !important;
        margin-bottom: 15px !important;
    }

    .without_cut_out_paragraph {
        font-size: 20px !important;
        line-height: 35px;
        padding-left: 25px;
        font-weight: 500;
        color: #000;
    }

    .learn-more-btn {
        padding: 10px 20px;
        background: #FFD312;
        color: #000;
        border-radius: 50px;
        text-decoration: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        font-weight: 550;
        font-size: 25px;
    }

    #banner_url a.learn-more-btn:hover {
        color: #000 !important;
    }

    .home11-hero-img .iconbox-small1 {
        padding: 10px;
        bottom: 90px;
        left: -90px;
    }

    .home_slider_padding {
        padding-bottom: 80px
    }

    .home_slider_padding .home11-hero-content .title {
        line-height: 54px;
        margin-bottom: 20px;
    }

    .home_slider_padding p {
        margin-bottom: 0 !important
    }

    .iconbox-small1 {
        background-color: #eee;
    }

    .home11-hero-img .iconbox-small2 {
        padding: 0 15px 0 0;
        right: 0;
    }

    .iconbox-small2 {
        background-color: #eee;
    }

    .subservice_image_sec .list-thumb {
        /* padding: 10px; */
        padding: 0;
    }

    .subservice_image_sec .list-content {
        padding: 0;
        position: relative;
        background: #f3eeff;
    }

    .subservice_image_sec .list-content a {
        padding: 25px 30px;
        position: relative;
        background: #eee;
        font-weight: 500;
    }

    .subservice_image_sec .list-thumb img {
        /* border-radius: 20px; */
        border-radius: 0;
    }

    .services_banner_image img {
        width: 100%
    }

    .services_banner_text h2 {
        font-size: 47px;
        /*width: 80%;*/
    }

    a:hover {
        color: #0040E6;
    }

    .funfact_one_borderleft {
        border-right: 2px solid #000;
        border-left: none;
        padding-left: 0;
    }

    .browse_our_service {
        margin-top: 5%;
        padding-bottom: 0 !important;
    }

    .serviceimage_desktop {
        display: block;
        height: 160px !important;
    }

    .serviceimage_mobile {
        display: none;
    }

    .we_do_heading {
        font-size: 35px;
        line-height: normal;
    }

    .we_do_section {
        padding-top: 45px;
    }

    .new_search_banner {
        border: unset !important;
        background-color: inherit !important;

    }

    .new_search_banner .advance-search-field .box-search .icon {
        bottom: 32% !important;
    }

    @media only screen and (max-width: 767px) {

        #feature-slider .splide__arrow {
            top: 29%;
            margin-left: -5%;
            margin-right: -5%;
        }

        .serviceimage_desktop {
            display: none !important;
        }

        .serviceimage_mobile {
            display: block !important;
            height: 107px !important;
        }

        .service_desc {
            font-size: 14px;
        }

        .subservice-title {
            font-size: 13px !important;
        }

        .subservice-font {
            font-size: 13px !important;
        }

        .mobile-splide {
            padding: 10px !important;
        }

        .mobile-splide ul li .list-content a {
            line-height: normal !important;
        }

        .home_slider_padding .home11-hero-content .title {
            line-height: normal;
            color: #fff;
        }

        .home11-hero-content .title {
            font-size: 28px !important;
        }

        .hero-home11 {
            padding-top: 20px !important;
            background: url({{ asset('public/site/images/darkimage.jpg') }});
            background-size: cover;
        }

        .home_slider_padding {
            padding-bottom: 0;
            margin-bottom: 0 !important;
        }

        .home11-hero-img .iconbox-small2 {
            top: 56%;
        }

        .home11-hero-img .iconbox-small1 {
            bottom: 7px;
            left: 0;
        }

        .home11-hero-img img {
            width: 100%
        }

        .section2 {
            padding-top: 20px !important
        }

        .section3 .heading2 {
            font-size: 47px !important;
            line-height: normal;
            padding-top: 20px;
        }

        .funfact_one_borderleft {
            border-left: inherit;
            margin-bottom: 13px !important;
            padding-left: 0 !important;
        }

        .funfact_one .timer,
        .funfact_one span {
            font-size: 25px;
        }

        .pl50 {
            padding-left: 0px !important;
        }

        .sectionmarque1 {
            margin: 16px 0 !important;
        }

        .services_banner_text h2 {
            font-size: 28px;
            width: 100%;
            line-height: normal;
            margin-bottom: 10px !important;
        }

        .mm-navbar {
            position: relative;
        }

        .section2 .custom_box {
            height: auto;
        }

        .custom_slider_width .owl-item {
            width: auto !important;
            text-align: center;
        }

        .our-about .mb30-lg {
            margin-bottom: 0px !important;
        }

        .our-about {
            padding-top: 20px !important;
        }

        .we_do_heading {
            font-size: 37px;
            line-height: 46px;
        }

        .bgc-thm3 {
            padding: 30px 0;
        }

        .mgtop20 {
            margin-top: 20px;
        }

        .mgtop15 {
            margin-top: 15px;
        }

        .bordermob {
            border: 1px solid #ccc !important;
            border-radius: 8px;
        }

        .vam_nav_style.owl-theme .owl-nav button.owl-prev,
        .vam_nav_style.owl-theme .owl-nav button.owl-next {
            height: 40px;
            line-height: 40px;
            top: 35%;
            width: 40px;
        }

        .vam_nav_style.owl-theme .owl-nav button.owl-prev {
            left: 0;
        }

        .vam_nav_style.owl-theme .owl-nav button.owl-next {
            right: 0px;
        }

        .mrg0 {
            margin: 0 !important;
        }

        .ud-btn {
            padding: 10px 5px;
        }

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

        .reviewListBox {
            height: auto;
            margin: 0 0 10px 0;
        }

        .pdl0 {
            padding-left: 0 !important;
        }

        .hideDiv {
            display: none !important;
        }

        .we_cut_out_paragraph {
            border-left: none !important;
            padding-left: 0 !important;
        }

        .bgc-thm2 {
            border-radius: 13px !important;
        }

        .we-do-slider-desk {
            display: none !important;
        }

        .we-do-slider-mobile {
            display: block !important;
        }

        .we-do-mobile-slider.owl-carousel .owl-item img {
            width: 60% !important;
            margin: 0 auto !important;
        }

        .we-do-mobile-slider .owl-stage-outer {
            margin-left: -30px;
            /* Same as stagePadding value */
        }

        .mobile-head-text {
            font-size: 18px !important;
        }
    }

    @media screen and (min-width: 768px) and (max-width: 991px) {

        .home_slider_padding .home11-hero-content .title {
            line-height: normal;
            color: #fff;
        }

        .home11-hero-content .title {
            font-size: 28px !important;
        }

        .hero-home11 {
            padding-top: 20px !important;
            background: url({{ asset('public/site/images/darkimage.jpg') }});
            background-size: cover;
        }

        .home_slider_padding {
            padding-bottom: 0;
            margin-bottom: 0 !important;
        }

        .home11-hero-img .iconbox-small2 {
            top: 56%;
        }

        .home11-hero-img .iconbox-small1 {
            bottom: 7px;
            left: 0;
        }

        .home11-hero-img img {
            width: 100%
        }

        .section2 {
            padding-top: 20px !important
        }

        .section3 .heading2 {
            font-size: 47px !important;
            line-height: normal;
            padding-top: 20px;
        }

        .funfact_one_borderleft {
            border-left: inherit;
            margin-bottom: 13px !important;
            padding-left: 0 !important;
        }

        .funfact_one .timer,
        .funfact_one span {
            font-size: 25px;
        }

        .pl50 {
            padding-left: 0px !important;
        }

        .sectionmarque1 {
            margin: 16px 0 !important;
        }

        .services_banner_text h2 {
            font-size: 28px;
            width: 100%;
            line-height: normal;
            margin-bottom: 10px !important;
        }

        .mm-navbar {
            position: relative;
        }

        .section2 .custom_box {
            height: auto;
        }

        .custom_slider_width .owl-item {
            width: auto !important;
            text-align: center;
        }

        .our-about .mb30-lg {
            margin-bottom: 0px !important;
        }

        .our-about {
            padding-top: 20px !important;
        }

        /* .we_do_heading {
            font-size: 37px;
            line-height: 46px;
        } */

        .bgc-thm3 {
            padding: 30px 0;
        }

        .mgtop20 {
            margin-top: 20px;
        }

        .mgtop15 {
            margin-top: 15px;
        }

        .vam_nav_style.owl-theme .owl-nav button.owl-prev,
        .vam_nav_style.owl-theme .owl-nav button.owl-next {
            height: 40px;
            line-height: 40px;
            top: 35%;
            width: 40px;
        }

        .vam_nav_style.owl-theme .owl-nav button.owl-prev {
            left: 0;
        }

        .vam_nav_style.owl-theme .owl-nav button.owl-next {
            right: 0px;
        }

        .mrg0 {
            margin: 0 !important;
        }

        .ud-btn {
            padding: 10px 5px;
        }

        .reviewListBox {
            height: auto;
            margin: 0 0 10px 0;
        }

        .pdl0 {
            padding-left: 0 !important;
        }

        .hideDiv {
            display: none !important;
        }

        .we_cut_out_paragraph {
            border-left: none !important;
            padding-left: 0 !important;
        }

        .bgc-thm2 {
            border-radius: 13px !important;
        }

    }

    @media screen and (min-width: 992px) and (max-width: 1024px) {
        .home9-tags a {
            padding: 5px 10px;
            font-size: 14px;
        }

        .our-about {
            padding-top: 40px !important;
        }

        .bgc-thm2 {
            border-radius: 20px;
        }

    }

    /* @media (min-width: 768px) and (max-width: 991px) {

        .home_slider_padding .home11-hero-content .title {
            line-height: normal;
            color: #fff;
        }
        .hero-home11 {
                padding-top: 20px !important;
                background: url({{ asset('public/site/images/darkimage.jpg') }});
                background-size: cover;
            }
            
        .hideDiv {
                display: none !important;
            }

    } */


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

    .ticker-container1 {
        overflow: hidden;
        white-space: nowrap;
        width: 100%;
    }

    .ticker-items1 {
        display: inline-block;
        white-space: nowrap;
    }

    .ticker-item1 {
        display: inline-block;
        padding: 0 10px;
    }

    .we_cut_out_paragraph {
        line-height: 30px;
        border-left: 2px solid gray;
        padding-left: 25px;
        font-size: 16px !important;
    }


    ul.list {
        list-style: none;
    }

    .list {
        width: 100%;
        background-color: #ffffff;
        border-radius: 0 0 5px 5px;
    }

    .list-items {
        padding: 10px 5px;
    }

    .list-items:hover {
        background-color: #dddddd;
    }

    .our-faq {
        padding-top: 90px;
    }







    /*30-05-2024*/
    .home11-hero-content .title {
        font-size: 43px;
    }

    .section3 .heading2 {
        font-size: 40px;
        line-height: 53px;
    }

    .pd0 {
        padding: 0;
    }

    .googlereview {
        margin-bottom: 3%;
        margin-top: 0;
    }

    .ourLocations {
        font-size: 55px;
        line-height: 50px;
    }

    .offersDiv {
        background: #0040E6;
        color: #fff;
        font-size: 18px;
        font-weight: 500;
        padding: 10px;
        margin: 5px 0 10px;
        width: 100%;
        display: inline-block;
        border-radius: 7px;
    }

    .offerServices {
        font-weight: 500;
        padding-left: 10px;
        font-size: 18px;
        margin: 0;
    }

    .review-color {
        color: #f2c300;
        margin-right: 2px;
    }

    .hero-banner-section {
        position: relative;
        width: 100%;
        /* height: 55vh !important; Adjust height as needed */
        /* overflow: hidden; */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-bg-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 395px;
        background: url('{{ asset('public/site/images/Homepage/bg.webp') }}') no-repeat center center;
        background-size: cover;
        z-index: 0;
        top: 17%;
    }

    .hero-content {
        z-index: 1;
    }

    .hero-bottom-bar {
        background-color: #000;
        /* black bar */
        color: #fff;
        font-size: 14px;
        font-weight: 500;
        position: relative;
        z-index: 0;
        top: 0;
        padding: 0;
    }

    .choose-city {
        /* border-radius: 30px !important; */
        border: none !important;
        padding: 0px 25px 0 25px !important;
        outline: none !important;
        height: 44px;
        box-shadow: none !important;
    }

    .hero-bottom-bar i {
        color: #fff;
        /* optional: icon color */
    }

    .bottom-content {
        margin-right: 10px !important;
    }

    .bottom-content-logo {
        margin-right: 5px !important;
    }

    .city-select {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
    }

    .list_index {
        position: absolute;
        top: 100%;
        /* place directly under input */
        left: 0;
        right: 0;
        z-index: 9999999;
        background-color: white;
        color: #000;
        /*max-height: 200px;  so you can scroll if long */
        overflow-y: auto;
        /* border: 1px solid #ddd; */
        border-radius: 4px;
        margin-top: 2px;
        padding-left: 0;
        list-style: none;
    }

    .list_index li {
        padding: 8px 12px;
        cursor: pointer;
        text-align: left;
    }

    .list_index li:hover {
        background-color: #f0f0f0;
    }


    @media (max-width: 768px) {
        .hero-bar-content {
            flex-direction: column !important;
            text-align: center;
        }

        .hero-bottom-bar {
            font-size: 9px !important;
        }

        .hero-bg-image {
            background: url('{{ asset('public/site/images/Homepage/mobile_bvanner.png') }}') no-repeat center center;
            height: 284px;
            background-size: cover !important;
            top: 0%;

        }

        .hero-banner-section {
            /* padding: 0 !important; */
            padding-bottom: 0;
        }

        .browse_our_service {
            margin-top: 5%;
            padding-bottom: 0 !important;
            /* padding-top: 50% !important; */

        }

        .service_desc {
            display: none !important;
        }

        .list_index {
            top: 219% !important;
        }

        .mobile_title_n_first {
            font-size: 25px !important;
            margin: 0 0 30px 0px !important;
        }

        .mobile_title_n_second {
            font-size: 35px !important;
            margin: 0 0 40px 0 !important;
        }

        .mobile_search_border_col9 {
            border: 1px solid #ccc !important;
        }

        .mobile_search_border_col3 {
            border: 1px solid #ccc !important;
        }

        .mobile_title_n_first {
            font-size: 27px !important;
        }

        .home_view_all {
            right: 0% !important;
        }

        .freelancer-style1 {
            padding: 20px 8px !important;
        }

        .freelancer-style12 {
            padding: 20px 5px !important;
        }

        .our-location-slider .owl-stage-outer {
            margin-left: -30px;
            /* Same as stagePadding value */
        }

        .cta-banner-about2 {
            height: 900px !important;
        }

        .review-description {
            font-size: 12px !important;
            max-height: 9em !important;
            height: 50px !important;
            margin-bottom: 0px !important;
        }

        .we_do_slider_p {
            font-size: 12px !important;
            max-height: 9em !important;
            height: 50px !important;
        }

        .we_do_slider_h5 {
            font-size: 16px !important;
        }

        .banner-div-style {
            top: 0px !important;
        }

        .service-slider h3 {
            font-size: 18px !important;
        }
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

    .we_do_slider_p {
        max-height: 10em;
        height: 150px;
    }

    .mobile_title_n_first {
        font-style: italic;
        color: white;
        text-transform: uppercase;
        font-size: 46px;
        margin: 0 0 40px 0px;
        line-height: 0.3 !important;
    }

    .mobile_title_n_second {
        font-style: italic;
        color: white;
        text-transform: uppercase;
        font-weight: 1000;
        font-size: 73px;
        line-height: 0.3 !important;
        margin: 30px 0 40px 0;
    }


    #feature-slider li .details p {
        font-weight: 500;
        color: #000;
        line-height: normal !important;
    }

    .home_view_all {
        font-size: 12px;
        padding: 2px 10px;
        right: 30%;
    }

    .custom-splide .splide__arrow--prev {
        left: 93% !important;
    }

    .custom-splide .splide__arrow {
        top: -16% !important;
    }

    .splide__arrow {
        background: #fff;
        border: 1px solid #0040E6;
    }

    .splide__arrow svg {
        fill: #0040E6;
        /* this changes the arrow color */
    }

    .review-stars {
        justify-content: center;
    }

    .review-card-fixed {
        /* height: 250px; */
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    @media (min-width: 992px) {
        .owl-carousel .owl-nav.disabled {
            display: none !important;
        }

        .service-slider {
            padding-left: 0px !important;
        }
    }

    .freelancer-style1 {
        padding: 15px;
    }

    .freelancer-style12 {
        padding: 15px;
    }

    /* Our location CSS */
    .feature-style1 .top-area {
        top: auto !important;
        bottom: 5px;
        padding-left: 7px !important;
    }

    .feature-style1 .top-area p {
        font-weight: 800 !important;
    }

    /* Our location CSS */
    .cta-banner-about2 {
        max-width: 1200px !important;
    }

    /* .big-cleaning{
        width: 385px !important;
        height: 450px !important;
    } */
    .box-padding {
        padding: 20px 15px !important;
    }

    .iconbox-title {
        font-size: 17px !important;
    }

    .cta-banner-about2:before {
        background-color: #EFEFEF !important;
        border-radius: 10px;
        width: 80% !important;
    }

    .cta-banner-about2 {
        height: 600px;
    }

    .banner-div-style {
        top: 50px;
    }

    /**/

    .fw500 {
        font-weight: 500;
    }

    @media (min-width: 768px) and (max-width: 1024px) {

        .container,
        .container-md,
        .container-sm {
            max-width: 720px !important;
        }

        .cta-banner-about2:before {
            width: 100% !important;
            left: 0;
            right: 0;
        }

        .hero-bg-image {
            height: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            top: 0;
        }

        .hero-banner-section {
            padding: 120px 0;
        }

    }
</style>


<section class="hero-banner-section position-relative">
    <div class="hero-bg-image"></div>

    <div class="container position-relative z-1 banner-div-style">
        <div class="row justify-content-center text-center">
            <div class="col-md-12 text-white hero-content">
                <p class="title mobile_title_n_first">
                    Everything you need,
                </p>
                <p class="title mobile_title_n_second">
                    ALL IN ONE PLACE!
                </p>

                <div class=" advance-search-tab bgc-white p10 bdrs4-sm bdrs60 banner-btn mt20 mb20 mx-auto"
                    style="max-width: 700px;">
                    <form action="{{ url('search-package') }}" method="get" id="search_banner">
                        @csrf
                        <div class="row justify-content-center align-items-center g-2">
                            <div class="col-md-9 position-relative mobile_search_border_col9">

                                <input class="form-control me-2 choose-city" type="text" name="search"
                                    value="{{ session('search_content') }}"
                                    placeholder="What service are you looking for?" id="search_auto" autocomplete="off">
                                <ul class="list_index"></ul>
                            </div>

                            <div class="col-md-3 bdrl1 mobile_search_border_col3">
                                <select class="form-select me-2 city-select" onchange="search_city_new(this.value);"
                                    name="search_city" id="search_city_index">
                                    <option>Choose City</option>
                                    @if ($city != '')
                                        @foreach ($city as $city_data)
                                            <option value="{{ strtolower(str_replace(' ', '-', $city_data->name)) }}"
                                                @if ($city_data->id == session('search_city_id')) selected @endif>
                                                {{ $city_data->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        {{-- new_search_banner<div
                            class="advance-search-tab bgc-white bdrs60 p10 bdrs4-sm bdr1 position-relative zi9 animate-up-3 ">
                            <div class="row">
                                <div class="col-md-5 col-lg-6 col-xl-6">
                                    <div class="advance-search-field mb10-sm bdrr1 bdrn-sm">
                                        <div class="form-search position-relative">
                                            <div class="box-search">
                                                <span class="icon far fa-magnifying-glass"></span>
                                                <input class="form-control" type="text" name="search"
                                                    placeholder="What are you looking for?"
                                                    value="{{ session('search_content') }}" id="search_auto">
                                                <ul class="list_index"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <p id="search_auto_error" style="color:red"></p>
                                </div>
                                <div class="col-md-4 col-lg-4 col-xl-4">
                                    <div class="bselect-style1">
                                        <select class="selectpicker" data-width="100%"
                                            onchange="search_city_new(this.value);">
                                            @if ($city != '')
                                            @foreach ($city as $city_data)
                                            <option value="{{ $city_data->id }}" @if ($city_data->id == session('search_city_id')) selected @endif>
                                                {{ $city_data->name }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-2 col-xl-2">
                                    <div class="text-center text-xl-start">
                                        <button class="ud-btn btn-dark bdrs60 bdrs4-sm w-100 px-0" type="button"
                                            onclick="search_banner();"
                                            style="color:#fff; background-color:#0040E6">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </form>
                </div>

            </div>
        </div>

    </div>
</section>
<section class="hero-bottom-bar">
    <div class="container d-flex flex-wrap justify-content-center align-items-center text-white px-3 py-2  gap-md-5">

        <div class="d-flex align-items-center bottom-content">
            <i class="fa fa-check-circle bottom-content-logo"></i> Verified Vendors
        </div>
        <div class="d-flex align-items-center bottom-content">
            <i class="fa fa-tags bottom-content-logo"></i> Get up to 5 free quotes
        </div>
        <div class="d-flex align-items-center bottom-content">
            <i class="fa fa-headset bottom-content-logo"></i> Live Customer Support
        </div>
    </div>
</section>


<!-- Need something -->
<section class="our-features pb40 pb30-md pt150 section2" style="display:none;">
    <div class="container wow fadeInUp">
        <!-- <div class="row">
          <div class="col-lg-12">
            <div class="main-title">
              <h2>Need something done?</h2>
              <p class="text">Most viewed and all-time top-selling services</p>
            </div>
          </div>
        </div> -->
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="iconbox-style1 at-home5 p-23 custom_box">
                    <div class="icon before-none section_2_icon"><span class="flaticon-cv section_2flaticon"></span>
                    </div>
                    <div class="details">
                        <h4 class="title mt10 mb-3">500+ Services Offered</h4>
                        <p class="text">Explore our best in class services and widest range of home services.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="iconbox-style1 at-home5 p-23 custom_box">
                    <div class="icon before-none section_2_icon"><span
                            class="flaticon-web-design section_2flaticon"></span></div>
                    <div class="details">
                        <h4 class="title mt10 mb-3">100% Quality Assurance</h4>
                        <p class="text">Top quality from verified vendors,with your orders protected from payment to
                            completion.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="iconbox-style1 at-home5 p-23 custom_box">
                    <div class="icon before-none section_2_icon"><span class="flaticon-secure section_2flaticon"></span>
                    </div>
                    <div class="details">
                        <h4 class="title mt10 mb-3">Top-Rated Professionals</h4>
                        <p class="text">Our professionals are reliable & well-trained, with an average rating of 4.78
                            out of 5!</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="iconbox-style1 at-home5 p-23 custom_box">
                    <div class="icon before-none section_2_icon"><span
                            class="flaticon-customer-service section_2flaticon"></span></div>
                    <div class="details">
                        <h4 class="title mt10 mb-3">Same-Day Availability</h4>
                        <p class="text">Book in less than 60 seconds, and even select same-day slots.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mx-auto know_more_btn">
                <a href="#" class="ud-btn btn-thm2">View All Services</a>
            </div>
        </div>
    </div>
</section>

@if (isset($service) && count($service) > 0)
    <section class="pt-0 browse_our_service">
        <div class="container wow fadeInUp">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-title text-center ">
                        <h3 class="mobile-head-text">Browse Our Services</h3>
                    </div>
                </div>
            </div>

            <div id="feature-slider" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($service as $service_data)
                            <li class="splide__slide text-center">
                                <div class="iconbox-style1 border-less p-0">
                                    <div class="icon before-none">
                                        <div class="details">
                                            <a
                                                href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => $service_data->page_url]) }}">
                                                @if (isset($service_data->home_icon))
                                                    <img class="bdrs20"
                                                        src="{{ asset('public/upload/service/' . $service_data->home_icon) }}"
                                                        alt="{{ $service_data->homeicon_alt_tag ?? $service_data->servicename }}"
                                                        width="60px;">
                                            </a>
                        @endif
                </div>
            </div>
            <div class="details">
                <a
                    href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => $service_data->page_url]) }}">
                    <p class="title mb-3 subservice-title">{{ $service_data->servicename }}</p>
                </a>
            </div>
        </div>
        </li>
@endforeach

{{-- <li class="splide__slide text-center">
                            <div class="iconbox-style1 border-less p-0">
                                <div class="icon before-none">
                                    <div class="details">
                                        <a
                                            href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => 'moving']) }}"><img
                                                class="bdrs20"
                                                src="{{ asset('public/site/images/Homepage/subservice_logo/moving_icon.png') }}"
                                                alt="Moving service icon – Vendorscity relocation experts"
                                                width="60px;"></a>
                                    </div>
                                </div>
                                <div class="details">
                                    <a
                                        href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => 'moving']) }}">
                                        <p class="title mb-3 subservice-title">Moving</p>
                                    </a>
                                </div>
                            </div>
                        </li>

                        <li class="splide__slide text-center">
                            <div class="iconbox-style1 border-less p-0">
                                <div class="icon before-none">
                                    <div class="details">
                                        <a
                                            href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => 'salon-spa-at-home']) }}">
                                            <img class="bdrs20"
                                                src="{{ asset('public/site/images/Homepage/subservice_logo/spa_salon_icon.png') }}"
                                                alt="Spa and salon service icon – Vendorscity wellness services"
                                                width="60px;"></a>
                                    </div>
                                </div>
                                <div class="details">
                                    <a
                                        href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => 'salon-spa-at-home']) }}">
                                        <p class="title mb-3 subservice-title">Salon & Spa</p>
                                    </a>
                                </div>
                            </div>
                        </li>

                        <li class="splide__slide text-center">
                            <div class="iconbox-style1 border-less p-0">
                                <div class="icon before-none">
                                    <div class="details">
                                        <a
                                            href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => 'storage']) }}"><img
                                                class="bdrs20"
                                                src="{{ asset('public/site/images/Homepage/subservice_logo/storage_icon.png') }}"
                                                alt="Storage service icon – Vendorscity secure storage solutions"
                                                width="60px;"></a>
                                    </div>
                                </div>
                                <div class="details">
                                    <a
                                        href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => 'storage']) }}">
                                        <p class="title mb-3 subservice-title">Storage</p>
                                    </a>
                                </div>
                            </div>
                        </li>

                        <li class="splide__slide text-center">
                            <div class="iconbox-style1 border-less p-0">
                                <div class="icon before-none">
                                    <div class="details">
                                        <a
                                            href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => 'pest-control-gardening']) }}"><img
                                                class="bdrs20"
                                                src="{{ asset('public/site/images/Homepage/subservice_logo/pest_control_icon.png') }}"
                                                alt="Pest control service icon – Vendorscity pest management UAE"
                                                width="60px;"></a>
                                    </div>
                                </div>
                                <div class="details">
                                    <a
                                        href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => 'pest-control-gardening']) }}">
                                        <p class="title mb-3 subservice-title">Pest Control & Gardening</p>
                                    </a>
                                </div>
                            </div>
                        </li>

                        <li class="splide__slide text-center">
                            <div class="iconbox-style1 border-less p-0">
                                <div class="icon before-none">
                                    <div class="details">
                                        <a
                                            href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => 'handyman-maintainence']) }}"><img
                                                class="bdrs20"
                                                src="{{ asset('public/site/images/Homepage/subservice_logo/handyman_icon.png') }}"
                                                alt="Handyman service icon – Vendorscity maintenance experts"
                                                width="60px;"></a>
                                    </div>
                                </div>
                                <div class="details">
                                    <a
                                        href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => 'handyman-maintainence']) }}">
                                        <p class="title mb-3 subservice-title">Handyman & Maintenance</p>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide text-center">
                            <div class="iconbox-style1 border-less p-0">
                                <div class="icon before-none">
                                    <div class="details">
                                        <a
                                            href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => 'automobile']) }}"><img
                                                class="bdrs20"
                                                src="{{ asset('public/site/images/Homepage/subservice_logo/car.png') }}"
                                                alt="" width="60px;"></a>
                                    </div>
                                </div>
                                <div class="details">
                                    <a
                                        href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => 'automobile']) }}">
                                        <p class="title mb-3 subservice-title">Automobile</p>
                                    </a>
                                </div>
                            </div>
                        </li> --}}

<!-- Add more slides as needed -->

</ul>
</div>
</div>

</div>
</section>
@endif


{{-- <section class="bgc-thm2 container pb0 pt0 mb30 mt50 sectionmarque1 hideDiv">
    <div class="container">
        <div class="row align-items-center custom_marquee"> --}}


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

{{-- <div class="ticker-container">
                <div class="ticker-items">
                    <div class="ticker-item"><span class="fa-regular fa-message-pen custom_icon"></span> Up to 5 Free
                        Quotes </div>
                    <div class="ticker-item"><span class="fa-regular fa-phone custom_icon"></span> Live Customer Support
                    </div>
                    <div class="ticker-item"><span class="fa-regular fa-user custom_icon"></span>Trusted Vendors </div>
                    <!-- Add more items as needed -->
                </div>
            </div> --}}
{{--
        </div>
    </div>
</section> --}}


@if ($service != '')
    <section class="pb40 pb20-md pt10">


        @foreach ($service as $service_data)
            @php
                $subservice_data = DB::table('subservices')
                    ->where('serviceid', $service_data->id)
                    ->where('is_active', 0)
                    ->whereRaw('FIND_IN_SET(?, city)', [session('search_city_id')])
                    ->orderBy('set_order', 'ASC')
                    ->get();
                $subservice_count = count($subservice_data);
            @endphp

            @php
                // echo"<pre>";print_r($service_data);echo"</pre>";
            @endphp
            @if ($subservice_data != '' && count($subservice_data) > 0)
                <div class="container">
                    <div class="row align-items-center wow fadeInUp" data-wow-delay="00ms">
                        <div class="col-9 col-lg-9 service-slider">
                            <div style="position: relative;">
                                <h3 class="title">{{ $service_data->servicename }}</h3>
                                {{-- <p class="service_desc">From Deep Cleaning to Dry Cleaning. We've Got You Convered.</p> --}}
                            </div>
                        </div>
                        <div class="col-3 col-lg-3">
                            @if ($subservice_count > 5)
                                <div class="text-end text-lg-end mb-4 mb-lg-2 mrg0">
                                    <a class="ud-btn2 ud-btn btn-thm2 home_view_all"
                                        href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => $service_data->page_url]) }}">View
                                        All</a>
                                </div>
                            @endif
                        </div>

                    </div>

                    @if ($subservice_data != '')
                        <div id="splide_{{ $service_data->id }}"
                            class="custom_splide splide mobile-splide row wow fadeInUp main-title"
                            data-wow-delay="300ms" data-subservice-count="{{ $subservice_count }}">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    @foreach ($subservice_data as $subservice)
                                        <li class="splide__slide">
                                            <div class="item">
                                                <div class="listing-style1">
                                                    <div class="list-thumb bdrs12">
                                                        @if ($service_data->id == 50 && $subservice->id == 92)
                                                            <a
                                                                href="{{ route('automobile.listing', ['page_url' => $subservice->page_url]) }}">
                                                            @else
                                                                {{-- <a
                                                                    href="{{ route('front.package_lists', ['city' => session('search_city_name'), 'page_url' => $subservice->page_url]) }}">
                                                                    --}}
                                                                @if ($subservice->is_bookable == 1)
                                                                    <a
                                                                        href="{{ route('enquiry', ['service_id' => \App\Models\Admin\Service::find($service_data->id)->page_url ?? $service_data->id, 'subservice_id' => \App\Models\Admin\Subservice::find($subservice->id)->page_url ?? $subservice->id]) }}">
                                                                    @else
                                                                        @php
                                                                            $category_id = $_GET['category'] ?? '';
                                                                        @endphp
                                                                        <a
                                                                            href="{{ route('booknow', ['service_id' => \App\Models\Admin\Service::find($service_data->id)->page_url ?? $service_data->id, 'subservice_id' => \App\Models\Admin\Subservice::find($subservice->id)->page_url ?? $subservice->id] + ($category_id != '' ? ['category' => $category_id] : [])) }}">
                                                                @endif
                                                        @endif
                                                        <img src="{{ asset('public/upload/subservice/' . $subservice->image) }}"
                                                            alt="{{ $subservice->image_alt_tag ?? $subservice->subservicename }}"
                                                            class="serviceimage_desktop">
                                                        <img src="{{ asset('public/upload/subservice/' . $subservice->image) }}"
                                                            alt="{{ $subservice->image_alt_tag ?? $subservice->subservicename }}"
                                                            class="serviceimage_mobile">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="list-content">
                                                    @if ($service_data->id == 50)
                                                        <a href="{{ route('automobile.listing', ['page_url' => $subservice->page_url]) }}"
                                                            class="fw500">
                                                        @else
                                                            <a href="{{ route('front.package_lists', ['city' => session('search_city_name'), 'page_url' => $subservice->page_url]) }}"
                                                                class="fw500">
                                                    @endif
                                                    {{ strlen($subservice->subservicename . ' in ' . $formattedCity) > 24
                                                        ? substr($subservice->subservicename . ' in ' . $formattedCity, 0, 24) . '...'
                                                        : $subservice->subservicename . ' in ' . $formattedCity }}
                                                    </a>
                                                </div>

                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if ($service_data->image != '')
                        <section class="our-about bgc-thm2 pb0 pt0 mb30 hideDiv">
                            {{-- <div class="container">
                                <div class="row align-items-center">

                                    <div class="col-xl-6 services_banner_text">
                                        <div class="position-relative wow fadeInLeft pl50" data-wow-delay="300ms">
                                            @if ($service_data->title1 != '')
                                            <h4 class="">{{ $service_data->title1 }}</h4>
                                            @endif

                                            @if ($service_data->title2 != '')
                                            <h2 class=" mb35">{{ $service_data->title2 }}</h2>
                                            @endif

                                            @if ($service_data->banner_url != '')
                                            <a href="{{ $service_data->banner_url }}" class="ud-btn btn-thm">Get up to 5 Free Quotes
                                                Today!</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="position-relative">

                                            <div class="about-img wow fadeInRight services_banner_image" data-wow-delay="300ms">
                                                @if ($service_data->image != '')
                                                <img class="" src="{{ asset('public/upload/service/' . $service_data->image) }}" alt="">
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div> --}}




                            {{-- <div class="row align-items-center">
                                <div class="col-xl-12">
                                    <div class="position-relative mb30-lg mrgb0">
                                        <div class="about-img wow fadeInRight" data-wow-delay="300ms" style="position: relative;">
                                            @if (isset($service_data->image))
                                            <img style="width: 100%;" class="bdrs16 desktop_img"
                                                src="{{ asset('public/upload/service/' . $service_data->image) }}" alt="">

                                            <div id="banner_url" style="position: absolute; bottom: 10px; left: 20px; padding: 10px;">
                                                @if ($service_data->banner_url != '')
                                                <a href="{{ $service_data->banner_url }}" class="learn-more-btn"
                                                    style="padding: 15px 20px; display: inline-block;">Learn More</a>
                                                @endif
                                            </div>


                                            @else
                                            <img style="width: 100%;" class="bdrs16"
                                                src="{{ asset('public/upload/subservice/banner/no_image_subservice.png') }}" alt="">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div> --}}


                        </section>
                    @endif

                </div>
            @endif
        @endforeach

    </section>
@endif

<section class="pt0-lg pb0-lg pb40 pt0 section3 hideDiv">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-xl-7 wow fadeInRight">
                <div class="cta-style6 mb30-sm">
                    <h2 class="cta-title mb25 heading2">Explore millions of
                        offerings <br> tailored to
                        your specific needs</h2>

                </div>
            </div>
            <div class="col-lg-6 col-xl-5 wow fadeInRight hideDiv">
                <div class="row" style="text-align:center;">
                    <div class="col-3" style="padding-left:0 !important; padding-right: 0 !important">
                        <div class="funfact_one funfact_one_borderleft mb40">
                            <div class="details">
                                <ul class="ps-4 mb-0 d-flex">
                                    <li>
                                        <div class="timer text_blue">30</div>
                                    </li>
                                    <li><span class="text_blue">+</span></li>
                                </ul>
                                <p class="mb-0">services</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3" style="padding-left:0 !important; padding-right: 0 !important">
                        <div class="funfact_one funfact_one_borderleft mb40">
                            <div class="details">
                                <ul class="ps-5 mb-0 d-flex">
                                    <li>
                                        <div class="timer text_blue">7</div>
                                    </li>
                                    {{-- <li><span class="text_blue">+</span></li> --}}
                                </ul>
                                <p class="mb-0 pdl0" style="padding-left: 8px">Cities</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3" style="padding-left:0 !important; padding-right: 0 !important">
                        <div class="funfact_one funfact_one_borderleft mb40">
                            <div class="details">
                                <ul class="ps-4 mb-0 d-flex">
                                    <li>
                                        <div class="timer text_blue">50</div>
                                    </li>
                                    <li><span class="text_blue">+</span></li>
                                </ul>
                                <p class="mb-0 pdl0">Vendors</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3" style="padding-left:0 !important; padding-right: 0 !important">
                        <div class="funfact_one funfact_one_borderleft mb40" style="border: none;">
                            <div class="details">
                                <ul class="ps-4 mb-0 d-flex">
                                    <li>
                                        <div class="timer text_blue">5 </div>
                                    </li>
                                    <li><span class="text_blue"><span class="fa-regular fa-star"></span></span></li>
                                </ul>
                                <p class="mb-0">Reviews
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

</section>

<!-- CTA Banner -->
<section class="cta-banner-about2 at-home10 mx-auto position-relative pt60-lg pb30-lg we-do-slider-desk">
    <img class="cta-about2-img big-cleaning at-home10 bdrs24 d-none d-xl-block"
        src="{{ asset('public/site/images/Homepage/bigcleaning.webp') }}"
        alt="Deep cleaning services in Dubai – Vendorscity professional cleaning solutions">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 offset-xl-5 wow fadeInUp" data-wow-delay="200ms">
                <div class="main-title">
                    <h2 class="title text-capitalize mobile-head-text">We do the work, so that you can chill.</h2>
                    <p class="text">We cut out the unnecessary steps with our easy to order process that makes your
                        to-do-lists for your home easy, fast, and stress-free.</p>
                </div>
            </div>
        </div>
        <div class="row wow fadeInDown" data-wow-delay="400ms">
            <div class="col-xl-10 offset-xl-2">
                <div class="row">
                    <div class="col-sm-6 col-lg-4">
                        <div
                            class="iconbox-style9 default-box-shadow1 bgc-white box-padding bdrs12 position-relative mb30">
                            <img src="{{ asset('public/site/images/Homepage/search.png') }}"
                                alt="Search services in Dubai and UAE on Vendorscity platform">
                            <h4 class="iconbox-title mt20">Find your required service</h4>
                            <p class="text mb-0">Choose from 50+ services, 100+ vendors, same-day slots, live support,
                                easy booking</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div
                            class="iconbox-style9 default-box-shadow1 bgc-white box-padding bdrs12 position-relative mb30">
                            <img src="{{ asset('public/site/images/Homepage/verified.png') }}"
                                alt="Verified service providers on Vendorscity platform">
                            <h4 class="iconbox-title mt20">Book your Service in Minutes</h4>
                            <p class="text mb-0">Secure pay, easy cancel, flexible slots, free quotes, managed
                                packages.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div
                            class="iconbox-style9 default-box-shadow1 bgc-white box-padding bdrs12 position-relative mb30">
                            <img src="{{ asset('public/site/images/Homepage/relax.png') }}"
                                alt="Relax while Vendorscity handles moving and cleaning services">
                            <h4 class="iconbox-title mt20">Relax & Let Us Handle the Work</h4>
                            <p class="text mb-0">100% satisfaction, referral rewards,no hidden fees, quality checks,
                                and personalized services</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="container we-do-slider-mobile" style="display:none;">
    <div class="row align-items-center wow fadeInUp">
        <div class="col-lg-9">
            <div class="main-title">
                <h2 class="title mobile-head-text">We do the work, so that you can chill.</h2>
                <p class="paragraph">We cut out the unnecessary steps with our easy to order process that makes your
                    to-do-lists for your home easy, fast, and stress-free.</p>
            </div>
        </div>

    </div>
    <div class="row wow fadeInUp" data-wow-delay="300ms">
        <div class="col-lg-12">

            <div id="we-do-slider-mobile" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">

                        <li class="splide__slide text-center">
                            <div class="freelancer-style12 text-center bdr1 bdrs16 hover-box-shadow">
                                <div class="thumb w90 mb25 mx-auto position-relative rounded-circle">
                                    <img src="{{ asset('public/site/images/Homepage/search.png') }}"
                                        alt="Search services in Dubai and UAE on Vendorscity platform">
                                </div>
                                <div class="details">
                                    <h5 class="title mb-1 we_do_slider_h5">Find your required service</h5>
                                    <p class="mb-0 we_do_slider_p">Choose from 50+ services, 100+ vendors, same-day
                                        slots, live support, easy booking</p>
                                </div>
                            </div>
                        </li>

                        <li class="splide__slide text-center">
                            <div class="freelancer-style12 text-center bdr1 bdrs16 hover-box-shadow">
                                <div class="thumb w90 mb25 mx-auto position-relative rounded-circle">
                                    <img src="{{ asset('public/site/images/Homepage/verified.png') }}"
                                        alt="Verified service providers on Vendorscity platform">
                                </div>
                                <div class="details">
                                    <h5 class="title mb-1 we_do_slider_h5">Book your Service in Minutes</h5>
                                    <p class="mb-0 we_do_slider_p">Secure pay, easy cancel, flexible slots, free
                                        quotes, managed packages.</p>
                                </div>
                            </div>
                        </li>

                        <li class="splide__slide text-center">
                            <div class="freelancer-style12 text-center bdr1 bdrs16 hover-box-shadow">
                                <div class="thumb w90 mb25 mx-auto position-relative rounded-circle">
                                    <img src="{{ asset('public/site/images/Homepage/relax.png') }}"
                                        alt="Relax while Vendorscity handles moving and cleaning services">
                                </div>
                                <div class="details">
                                    <h5 class="title mb-1 we_do_slider_h5">Relax & Let Us Handle the Work</h5>
                                    <p class="mb-0 we_do_slider_p">100% satisfaction, referral rewards,no hidden fees,
                                        quality checks, and personalized services</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>



<section class=" mt-30 pb-0" style="display: none;">
    <div class="container">
        <div class="row wow fadeInUp" data-wow-delay="00ms">
            <div class="col-lg-6">
                <div class="main-title2">
                    <h2 class="title">Hear what Our Clients Have to say About Us</h2>
                </div>
            </div>
            <div class="col-lg-6">

                <p class="paragraph we_cut_out_paragraph">Step into a world of satisfaction and trust as you explore
                    stories and positive experiences ahared by our delighted customers. Discover firsthand the joy and
                    reliability that defines our services!
                </p>

            </div>
        </div>

    </div>
</section>

{{-- <section class="pb30 pb30-md"> --}}
<div class="container mt25">
    <div class="row align-items-center wow fadeInUp">
        <div class="col-lg-9">
            <div class="main-title">
                <h2 class="title mobile-head-text">Read Our Verified Reviews</h2>
                {{-- <p class="paragraph">Most viewed and all-time top-selling services</p> --}}
            </div>
        </div>
        {{-- <div class="col-lg-3">
                <div class="text-lg-end mb-3">
                    <a href="page-freelancer-v1.html" class="ud-btn2">All Freelancers <i
                            class="fal fa-arrow-right-long"></i></a>
                </div>
            </div> --}}
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
            {{-- <div class="vam_nav_style dots_none review-slider owl-carousel owl-theme">

                    @if (!empty($googleReview))
                    @foreach ($googleReview as $googleReview_data)
                    <div class="item">
                        <div class="freelancer-style1 text-center bdr1 bdrs16 hover-box-shadow review-card-fixed">

                            <div class="details">
                                @if ($googleReview_data->name != '')
                                <h5 class="title mb-1">{{$googleReview_data->name}}</h5>
                                @endif

                                <div class="review">
                                    @if ($googleReview_data->label != '')
                                    <div class="d-flex review-stars">
                                        @for ($i = 1; $i <= 5; $i++) @if ($i <= $googleReview_data->label)
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
                                <p>“{{$googleReview_data->description}}”</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div> --}}
        </div>
    </div>
</div>
{{--
</section> --}}

<div class="container">
    <div class="googlereview">
        <div class="row align-items-md-center">
            <div class="col-lg-5 wow fadeInUp" data-wow-delay="300ms">
                <h3 class="google-text">Curious about what sets apart?</h3>
                <p>Explore our Google Reviews and discover why customers trust us with home service needs</p>
            </div>
            <div class="col-lg-3 col-7 wow fadeInUp" data-wow-delay="300ms">
                <a style="width: 100%;"
                    href="https://www.google.com/search?q=vendorscity+dubai&sca_esv=e472bba1732e8ddb&sca_upv=1&rlz=1C5CHFA_enAE1014AE1015&sxsrf=ADLYWIKMm77ohxWtSjtB2FywHuiQPICeBA%3A1716628559794&ei=T6xRZquOMNCVxc8Ph-eCsAo&ved=0ahUKEwjr8ZHcu6iGAxXQSvEDHYezAKYQ4dUDCBA&uact=5&oq=vendorscity+dubai&gs_lp=Egxnd3Mtd2l6LXNlcnAiEXZlbmRvcnNjaXR5IGR1YmFpMgQQIxgnMggQABgIGA0YHjIIEAAYCBgNGB4yCBAAGAgYDRgeMgsQABiABBiGAxiKBTILEAAYgAQYhgMYigUyCxAAGIAEGIYDGIoFMgsQABiABBiGAxiKBTIIEAAYgAQYogQyCBAAGIAEGKIESMAKUMoEWN8GcAF4AZABAJgB_wGgAcYDqgEFMC4xLjG4AQPIAQD4AQGYAgOgAtMDwgIKEAAYsAMY1gQYR8ICBxAAGIAEGA3CAggQABgFGA0YHsICChAAGAUYDRgeGA-YAwDiAwUSATEgQIgGAZAGCJIHBTEuMC4yoAeUEA&sclient=gws-wiz-serp#lrd=0x4c30ffdf4bf81567:0xaf176b54bfc73c00,1"
                    target="_blank" class="ud-btn btn-thm google-button">Read More Reviews</a>
            </div>
            <div class="col-lg-4 col-5 wow fadeInUp" data-wow-delay="300ms" style="text-align: right;">
                <img class="w100" src="{{ asset('public/site/images/googlereview.png') }}"
                    alt="Graphic representation of Google reviews" style="max-width: 400px;">
            </div>
        </div>
    </div>
</div>

{{-- <section class="pt20 pb-0">
    <div class="container">
        <div class="row wow fadeInUp" data-wow-delay="00ms">
            <div class="col-lg-12">
                <div class="main-title2 mb30">
                    <h2 class="title ourLocations">Our Locations</h2>
                    <h3 class="offersDiv">VendorsCity currently offers services in:</h3>
                    <h3 class="offerServices" style="font-weight: bold;font-size: 19px;">United Arab Emirates - </h3>
                    <h3 class="offerServices">Dubai, Abu Dhabi, Sharjah, Ras Al Khamiah, Ajman, Umm Al Quwain, Fujairah
                    </h3>
                </div>
            </div>
        </div>
    </div>
</section> --}}


{{-- Our Location Section --}}

@if (session('search_country_name') == 'United Arab Emirates')
    <section class="pb90 pb30-md pt-0">
        <div class="container">
            <div class="row align-items-center wow fadeInUp" data-wow-delay="00ms">
                <div class="col-lg-9">
                    <div class="main-title2">
                        <h2 class="title mobile-head-text">Our Locations</h2>
                        <p class="paragraph">VendorsCity currently offers services in</p>
                    </div>
                </div>
            </div>

            <div id="our-location-slider" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">

                        <li class="splide__slide text-center">
                            <div class="feature-style1 at-home13 mb30 bdrs12">
                                <div class="feature-img bdrs12 overflow-hidden"><img class="w-100"
                                        src="{{ asset('public/site/images/home13-team-1.png') }}"
                                        alt="Vendorscity professional team for moving and cleaning services"></div>
                                <div class="feature-content">
                                    <div class="top-area">
                                        <p class="title mb-1">Dubai</p>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="splide__slide text-center">
                            <div class="feature-style1 at-home13 mb30 bdrs12">
                                <div class="feature-img bdrs12 overflow-hidden"><img class="w-100"
                                        src="{{ asset('public/site/images/abudhabi.png') }}"
                                        alt="Abu Dhabi cleaning, moving, and handyman services – Vendorscity"></div>
                                <div class="feature-content">
                                    <div class="top-area">
                                        <p class="title mb-1">Abu Dhabi</p>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="splide__slide text-center">
                            <div class="feature-style1 at-home13 mb30 bdrs12">
                                <div class="feature-img bdrs12 overflow-hidden"><img class="w-100"
                                        src="{{ asset('public/site/images/sharjaha.png') }}"
                                        alt="Sharjah cleaning and moving services – Vendorscity UAE"></div>
                                <div class="feature-content">
                                    <div class="top-area">
                                        <p class="title mb-1">Sharjah</p>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="splide__slide text-center">
                            <div class="feature-style1 at-home13 mb30 bdrs12">
                                <div class="feature-img bdrs12 overflow-hidden"><img class="w-100"
                                        src="{{ asset('public/site/images/rasal.png') }}"
                                        alt="Ras Al Khaimah moving and cleaning services – Vendorscity"></div>
                                <div class="feature-content">
                                    <div class="top-area">
                                        <p class="title mb-1">Ras Al Khamiah</p>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="splide__slide text-center">
                            <div class="feature-style1 at-home13 mb30 bdrs12">
                                <div class="feature-img bdrs12 overflow-hidden"><img class="w-100"
                                        src="{{ asset('public/site/images/ajman.png') }}"
                                        alt="Ajman moving and cleaning services by Vendorscity"></div>
                                <div class="feature-content">
                                    <div class="top-area">
                                        <p class="title mb-1">Ajman</p>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="splide__slide text-center">
                            <div class="feature-style1 at-home13 mb30 bdrs12">
                                <div class="feature-img bdrs12 overflow-hidden"><img class="w-100"
                                        src="{{ asset('public/site/images/quwain.png') }}"
                                        alt="Umm Al Quwain moving and cleaning services – Vendorscity"></div>
                                <div class="feature-content">
                                    <div class="top-area">
                                        <p class="title mb-1">Umm Al Quwain</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide text-center">
                            <div class="feature-style1 at-home13 mb30 bdrs12">
                                <div class="feature-img bdrs12 overflow-hidden"><img class="w-100"
                                        src="{{ asset('public/site/images/fujairah.png') }}"
                                        alt="Fujairah moving and cleaning services – Vendorscity"></div>
                                <div class="feature-content">
                                    <div class="top-area">
                                        <p class="title mb-1">Fujairah</p>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Add more slides as needed -->

                    </ul>
                </div>
            </div>

        </div>
    </section>
@endif
<!-- Faq Area -->


<section class="our-about bgc-thm2 container pb0 pt0 mb30" style="display: none;">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-xl-6">
                <div class="position-relative wow fadeInLeft pl50" data-wow-delay="300ms">

                    <h2 class=" mb35">Register with us<br class="d-none d-lg-block">as a verified vendor
                    </h2>

                    <div class="list-style2 light-style">
                        <ul class="mb30">
                            <li><i class="far fa-check fa-check-custom"></i>Get qualified leads</li>
                            <li><i class="far fa-check fa-check-custom"></i>Reach out to direct customers</li>
                            <li><i class="far fa-check fa-check-custom"></i>Generate added revenue</li>
                            <li><i class="far fa-check fa-check-custom"></i>Help us take your business forward</li>
                        </ul>
                    </div>
                    <a href="{{ url(session('search_city_name', 'dubai') . '/become-a-vendor') }}"
                        class="ud-btn btn-thm">Register Now</a>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="position-relative">

                    <div class="about-img wow fadeInRight" data-wow-delay="300ms">
                        <img class="w100" src="{{ asset('public/site/images/regasvendor.png') }}"
                            alt="Graphic showing vendor registration process">
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

{{-- <section class="bgc-thm2 container pb0 pt0 mb30">
    <div class="container">
        <div class="row align-items-center custom_marquee">


            <div class="ticker-container1">
                <div class="ticker-items1">
                    <div class="ticker-item1"><span class="fa-regular fa-message-pen custom_icon"></span> Up to 5 Free
                        Quotes </div>
                    <div class="ticker-item1"><span class="fa-regular fa-phone custom_icon"></span> Live Customer
                        Support</div>
                    <div class="ticker-item1"><span class="fa-regular fa-user custom_icon"></span>Trusted Vendors </div>
                    <!-- Add more items as needed -->
                </div>
            </div>

        </div>
    </div>
</section> --}}

@include('front.includes.footer')

<!-- Tabby Informational Modal Start -->
<div class="modal fade modal-mobile-bottom-otp" id="tabby_info_modal" tabindex="-1" aria-labelledby="tabbyLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content details-modal-content border-0 overflow-hidden bdrs24">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            <!-- Body -->
            <div class="modal-body p-0">
                <div class="tabby-modal-body">

                    <!-- Left Column: Hero -->
                    <div class="tabby-modal-left text-center">
                        <img src="https://cdn.tabby.ai/assets/logo.png" alt="Tabby"
                            style="max-height:40px; width:auto;" class="mb-4 mx-auto">

                        <h2 class="tabby-main-heading mb-4">
                            Shop now.
                            <span class="tabby-highlight">Pay later with Tabby.</span>
                        </h2>

                        <p class="tabby-sub-heading mb-4">
                            We've partnered with Tabby to bring you a more rewarding way to shop. Tabby lets you split
                            your
                            purchases into 4 interest-free payments with no fees.
                        </p>

                        <div class="tabby-info-footer mt-auto pt-4">
                            <p class="mb-0 small text-muted">You must be over 18 and have a valid Emirates ID. Subject
                                to
                                approval.</p>
                        </div>
                    </div>

                    <!-- Right Column: Content -->
                    <div class="tabby-modal-right">

                        <!-- How it Works -->
                        <div class="mb-4">
                            <h4 class="fw-bold mb-4" style="font-family: var(--title-font-family);">
                                Here's how it works
                            </h4>

                            <div class="row g-3">
                                <!-- Step 1 -->
                                <div class="col-md-4">
                                    <div class="tabby-step-card text-center p-3">
                                        <div class="tabby-step-number-pill mb-2">1</div>
                                        <h6 class="fw-bold mb-1" style="font-family: var(--title-font-family);">Choose
                                            Tabby</h6>
                                        <p class="mb-0 small text-muted">Select Tabby at checkout.</p>
                                    </div>
                                </div>
                                <!-- Step 2 -->
                                <div class="col-md-4">
                                    <div class="tabby-step-card text-center p-3">
                                        <div class="tabby-step-number-pill mb-2">2</div>
                                        <h6 class="fw-bold mb-1" style="font-family: var(--title-font-family);">
                                            Instant
                                            Approval</h6>
                                        <p class="mb-0 small text-muted">Link any debit or credit card and get instant
                                            approval.</p>
                                    </div>
                                </div>
                                <!-- Step 3 -->
                                <div class="col-md-4">
                                    <div class="tabby-step-card text-center p-3">
                                        <div class="tabby-step-number-pill mb-2">3</div>
                                        <h6 class="fw-bold mb-1" style="font-family: var(--title-font-family);">Pay
                                            Later</h6>
                                        <p class="mb-0 small text-muted">Complete checkout and Tabby will remind you.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Benefits & FAQ Split -->
                        <div class="row g-4">
                            <!-- Benefits -->
                            <div class="col-md-6">
                                <h5 class="fw-bold mb-3" style="font-family: var(--title-font-family);">Why Tabby?
                                </h5>
                                <ul class="list-unstyled">
                                    <li class="mb-3 d-flex align-items-start">
                                        <div class="bg-success-subtle p-1 rounded-circle me-2 mt-1"
                                            style="width:20px; height:20px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                            <i class="fas fa-check text-success small" style="font-size:10px;"></i>
                                        </div>
                                        <span class="small text-muted"><strong>Flexibility:</strong> Shop now, pay
                                            later
                                            without interest or fees.</span>
                                    </li>
                                    <li class="d-flex align-items-start">
                                        <div class="bg-success-subtle p-1 rounded-circle me-2 mt-1"
                                            style="width:20px; height:20px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                            <i class="fas fa-check text-success small" style="font-size:10px;"></i>
                                        </div>
                                        <span class="small text-muted"><strong>Trust:</strong> Shari’ah-compliant and
                                            licensed by the Saudi Central Bank.</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Small FAQ -->
                            <div class="col-md-6">
                                <h5 class="fw-bold mb-3" style="font-family: var(--title-font-family);">Common
                                    Questions
                                </h5>
                                <div class="accordion accordion-flush" id="tabbyFaqSmall">
                                    <div class="accordion-item bg-transparent border-bottom-0">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed p-2 small fw-bold bg-transparent"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#smallFaq1">
                                                Is Tabby free to use?
                                            </button>
                                        </h2>
                                        <div id="smallFaq1" class="accordion-collapse collapse"
                                            data-bs-parent="#tabbyFaqSmall">
                                            <div class="accordion-body p-2 small text-muted">
                                                Yes! Tabby split in 4 is interest-free with no fees when you pay on
                                                time.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item bg-transparent border-bottom-0">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed p-2 small fw-bold bg-transparent"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#smallFaq2">
                                                How do refunds work?
                                            </button>
                                        </h2>
                                        <div id="smallFaq2" class="accordion-collapse collapse"
                                            data-bs-parent="#tabbyFaqSmall">
                                            <div class="accordion-body p-2 small text-muted">
                                                Refunds are processed to your original card and Tabby updates your
                                                balance.
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
</div>
<!-- Tabby Informational Modal End -->
<script>
    function search_banner() {


        var search_auto = jQuery("#search_auto").val();
        if (search_auto == '') {

            jQuery('#search_auto_error').html("Please Enter Some Service");
            jQuery('#search_auto_error').show().delay(0).fadeIn('show');
            jQuery('#search_auto_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#search_auto').offset().top - 150
            }, 1000);
            return false;

        }
        $('#search_banner').submit();
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.0/gsap.min.js"></script>
<script>
    // const tickerContainer = document.querySelector('.ticker-container');
    // const tickerItems = document.querySelector('.ticker-items');
    // const items = document.querySelectorAll('.ticker-item');

    // // Calculate the width of all items combined
    // let itemsWidth = 0;
    // items.forEach(item => {
    //   itemsWidth += item.offsetWidth;
    // });

    // // Clone items to fill the container at least twice
    // while (tickerItems.offsetWidth < tickerContainer.offsetWidth * 2) {
    //   items.forEach(item => {
    //     const clone = item.cloneNode(true);
    //     tickerItems.appendChild(clone);
    //   });
    // }

    // // Set up GSAP animation
    // gsap.to(tickerItems, {
    //   duration: 5, // Adjust duration as needed
    //   x: -itemsWidth,
    //   ease: 'none',
    //   repeat: -1
    // });

    // const tickerContainer1 = document.querySelector('.ticker-container1');
    // const tickerItems1 = document.querySelector('.ticker-items1');
    // const items1 = document.querySelectorAll('.ticker-item1');

    // // Calculate the width of all items combined
    // let itemsWidth1 = 0;
    // items1.forEach(item1 => {
    //   itemsWidth1 += item1.offsetWidth;
    // });

    // // Clone items to fill the container at least twice
    // while (tickerItems1.offsetWidth < tickerContainer1.offsetWidth * 2) {
    //   items1.forEach(item1 => {
    //     const clone1 = item1.cloneNode(true);
    //     tickerItems1.appendChild(clone1);
    //   });
    // }

    // // Set up GSAP animation
    // gsap.to(tickerItems1, {
    //   duration: 5, // Adjust duration as needed
    //   x: itemsWidth1,
    //   ease: 'none',
    //   repeat: -1
    // });


    // let names = [
    //   "Ayla",
    //   "Jake",
    //   "Sean",
    //   "Henry",
    //   "Brad",
    //   "Stephen",
    //   "Taylor",
    //   "Timmy",
    //   "Cathy",
    //   "John",
    //   "Amanda",
    //   "Amara",
    //   "Sam",
    //   "Sandy",
    //   "Danny",
    //   "Ellen",
    //   "Camille",
    //   "Chloe",
    //   "Emily",
    //   "Nadia",
    //   "Mitchell",
    //   "Harvey",
    //   "Lucy",
    //   "Amy",
    //   "Glen",
    //   "Peter",
    // ];

    let names = [];
    @if ($sub_service != '')
        @foreach ($sub_service as $sub_service_data)
            names.push("{{ $sub_service_data->subservicename }}");
        @endforeach
    @endif

    let sortedNames_index = names.sort(); // Make sure `names` array is populated correctly before this line

    // Reference to input element
    let input_index = document.getElementById("search_auto");

    // Execute function on keyup
    input_index.addEventListener("keyup", (e) => {
        // Clear previous results
        removeElements();

        // Get the input value and convert it to lowercase
        let inputValue = input_index.value.toLowerCase();

        // Loop through sortedNames array
        for (let i of sortedNames_index) {
            // Convert current element `i` to lowercase
            let lowercaseName = i.toLowerCase();

            // Check if the input value is found anywhere in the lowercaseName
            if (lowercaseName.includes(inputValue) && inputValue !== "") {
                // Create li element
                let listItem = document.createElement("li");
                listItem.classList.add("list-items");
                listItem.style.cursor = "pointer";
                listItem.setAttribute("onclick", "displayNames('" + i + "')");

                // Highlight the matching part
                let startIndex = lowercaseName.indexOf(inputValue);
                let matchedPart = i.substr(startIndex, inputValue.length);
                let remainder = i.substr(startIndex + inputValue.length);

                // Display matched part in bold
                listItem.innerHTML = i.substr(0, startIndex) + "<b>" + matchedPart + "</b>" + remainder;

                // Append list item to the list
                document.querySelector(".list_index").appendChild(listItem);
            }
        }
    });

    function displayNames(value) {
        input_index.value = value;
        removeElements();

        //$('#search_banner').submit();
    }

    function removeElements() {
        //clear all the item
        let items = document.querySelectorAll(".list-items");
        items.forEach((item) => {
            item.remove();
        });
    }

    function search_city_new(val) {
        if (val && val !== 'Choose City') {
            window.location.href = '{{ url('/') }}' + '/' + val;
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js" defer></script>
<script>
    //  document.addEventListener('DOMContentLoaded', function () {
    //     // Select all .splide elements except #feature-slider
    //     document.querySelectorAll('.splide:not(#feature-slider)').forEach(function (splideElement) {
    //         new Splide('#' + splideElement.id, {
    //            type: 'slide',
    //             perPage: 5,
    //             gap: '1rem',
    //             autoplay: false,
    //             interval: 3000,
    //             pagination: false,
    //             arrows: false,
    //             breakpoints: {
    //                 768: {
    //                     perPage: 2,
    //                     gap: '0.5rem',
    //                 },
    //             },
    //         }).mount();


    //     });
    // });




    document.addEventListener('DOMContentLoaded', function() {
        new Splide('#feature-slider', {
            type: 'slide',
            perPage: 6,
            gap: '1rem',
            autoplay: false,
            interval: 3000,
            pagination: false,
            arrows: false,
            breakpoints: {
                768: {
                    fixedWidth: '20%',
                    perPage: 4,
                    // perMove: 3,
                    gap: '0.5rem',
                    arrows: false,
                },
            },
        }).mount();
    });

    document.addEventListener('DOMContentLoaded', function() {
        new Splide('#our-location-slider', {
            type: 'slide',
            perPage: 7,
            gap: '1rem',
            autoplay: false,
            interval: 3000,
            pagination: false,
            arrows: false,
            breakpoints: {
                768: {
                    fixedWidth: '40%', // Each slide takes 80% of container
                    focus: 0, // Start slide aligned left
                    gap: '1rem',
                    arrows: false,
                },
            },
        }).mount();
    });


    document.addEventListener('DOMContentLoaded', function() {
        new Splide('#we-do-slider-mobile', {
            type: 'slide',
            perPage: 2,
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

    document.addEventListener('DOMContentLoaded', function() {
        // Select all .splide elements except #feature-slider
        document.querySelectorAll('.custom_splide.splide:not(#feature-slider)').forEach(function(
            splideElement) {

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
            const prevButton = document.querySelector('.custom-prev-' + splideId.replace('splide_',
                ''));
            const nextButton = document.querySelector('.custom-next-' + splideId.replace('splide_',
                ''));

            if (prevButton && nextButton) {
                prevButton.addEventListener('click', () => splideInstance.go('<'));
                nextButton.addEventListener('click', () => splideInstance.go('>'));
            }
        });
    });
</script>

<script>
    // //Google Review Slider
    // function setEqualHeight() {
    //   const cards = document.querySelectorAll('.review-card-fixed');
    //   let maxHeight = 0;

    //   cards.forEach(card => {
    //     card.style.height = 'auto'; // Reset to get accurate height
    //     const height = card.offsetHeight;
    //     if (height > maxHeight) maxHeight = height;
    //   });

    //   cards.forEach(card => {
    //     card.style.height = maxHeight + 'px';
    //   });
    // }
    // $(document).ready(function () {
    //   let itemCount = $('.review-slider .item').length;
    //   let enableNav = itemCount > 5;

    //   $('.review-slider').owlCarousel({
    //     loop: false,
    //     margin: 30,
    //     nav: enableNav,
    //     navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
    //     dots: false,
    //     autoplay: false,
    //     responsive: {
    //       0: { items: 2, nav: false },
    //       480: { items: 2, nav: false },
    //       768: { items: 3, nav: false },
    //       992: { items: 4, nav: enableNav },
    //       1300: { items: 4, nav: enableNav }
    //     },
    //     onInitialized: setEqualHeight,
    //     onResized: setEqualHeight,
    //     onRefreshed: setEqualHeight,
    //     onInitialized: function(event) {
    //       toggleNavVisibility(event);
    //     },
    //     onResized: function(event) {
    //       toggleNavVisibility(event);
    //     }
    //   });

    //   function toggleNavVisibility(event) {
    //   const width = $(window).width();

    //   if (width < 992) {
    //     // Always hide nav on mobile/tablet (< 992px)
    //     $(event.target).find('.owl-nav').hide();
    //   } else {
    //     // On desktop, show nav only if more than 5 items
    //     if (itemCount > 5) {
    //       $(event.target).find('.owl-nav').show();
    //     } else {
    //       $(event.target).find('.owl-nav').hide();
    //     }
    //   }
    // }

    // });

    // Our Location Slider
    /* $(document).ready(function () {
    $('.our-location-slider').owlCarousel({
        loop: false,
        margin: 30,
        nav: false,
        dots: false,
        autoplay: false,
        responsive: {
            0: { items: 2,
                 stagePadding: 30,
             },
            600: { items: 2 },
            1000: { items: 7 },
            1200: { items: 7}
        }
    });

    }); */


    // We Do Mobile View Slider
    $(document).ready(function() {
        $('.we-do-mobile-slider').owlCarousel({
            loop: false,
            margin: 30,
            center: false,
            dots: false,
            nav: false,
            responsive: {
                0: {
                    items: 1,
                    stagePadding: 30,
                },
                480: {
                    items: 1,
                    stagePadding: 30,
                },
                600: {
                    items: 1,
                    stagePadding: 30,
                },
                768: {
                    items: 1,
                    stagePadding: 30,
                },
            }
        })

    });
</script>
<script>
    $(window).on('scroll load resize', function() {
        // Try to find the most appropriate header for the current viewport
        var header = $('.mobilie_header_nav:visible');
        if (!header.length) header = $('header.stricky:visible');
        if (!header.length) header = $('header:visible').first();

        var headerHeight = header.length ? header.outerHeight() : 0;

        // Ensure banner is always below header
        if ($('.tabby-banner-wrapper').length) {
            $('.tabby-banner-wrapper').css('top', headerHeight + 'px');
        }
    });
</script>
