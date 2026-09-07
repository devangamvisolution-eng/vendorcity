<!DOCTYPE html>

<html dir="ltr" lang="en">



<head>

    <meta name="DC.title" content="https://www.vendorscity.com/" />

    <meta name="geo.region" content="AE" />

    <meta name="geo.position" content="24.000249;53.999483" />

    <meta name="ICBM" content="24.000249, 53.999483" />

    <link rel="canonical" href="{{ url()->current() }}" />








    <link rel="stylesheet" href="{{ asset('public/site/css/intlTelInput.css') }}">



    <script src="{{ asset('public/site/js/intlTelInput.min.js') }}"></script>





    <meta charset="utf-8">

    <meta name="format-detection" content="telephone=no">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}

    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    {{-- <meta name="keywords"content="">

    <meta name="description" content=""> --}}

    <!-- <meta name="CreativeLayers" content="ATFN"> -->

    <!-- css file -->

    <link rel="stylesheet" href="{{ asset('public/site/css/bootstrap.min.css') }}">



    <link rel="stylesheet" href="{{ asset('public/site/css/jquery-ui.min.css') }}">

    <link rel="stylesheet" href="{{ asset('public/site/css/ace-responsive-menu.css') }}">

    <link rel="stylesheet" href="{{ asset('public/site/css/menu.css') }}">

    <link rel="stylesheet" href="{{ asset('public/site/css/fontawesome.css') }}">

    <link rel="stylesheet" href="{{ asset('public/site/css/flaticon.css') }}">

    <link rel="stylesheet" href="{{ asset('public/site/css/bootstrap-select.min.css') }}">

    <link rel="stylesheet" href="{{ asset('public/site/css/animate.css') }}">

    <link rel="stylesheet" href="{{ asset('public/site/css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset('public/site/css/slider.css') }}">

    <link rel="stylesheet" href="{{ asset('public/site/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('public/site/css/ud-custom-spacing.css') }}">

    <!-- Responsive stylesheet -->

    <link rel="stylesheet" href="{{ asset('public/site/css/responsive.css') }}">

    <link rel="stylesheet" href="{{ asset('public/site/css/owl.carousel.min.css') }}">

    <link rel="stylesheet" href="{{ asset('public/site/css/owl.theme.default.min.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">

    <link rel="stylesheet" {{-- href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" --}} />

    <!-- Title -->

    @if (!empty($meta_title))
        <title>{{ $meta_title }}</title>

        <meta property="og:title" content="{{ $meta_title }}" />
    @else
        <title>VendorsCity</title>

        <meta property="og:title" content="VendorsCity" />
    @endif



    @if (!empty($meta_keyword))
        <meta name="keywords"content="{{ $meta_keyword }}">
    @endif



    @if (!empty($meta_description))
        <meta name="description"content="{{ $meta_description }}">

        <meta property="og:description" content="{{ $meta_description }}" />
    @endif

    <!-- Favicon -->



    <meta property="og:site_name" content="VendorsCity">

    <meta property="og:image" itemprop="image" content="{{ asset('public/site/images/Homepage/bg.png') }}">

    <meta property="og:image:width" content="1200">

    <meta property="og:image:height" content="630">

    <meta property="og:url" content="{{ url()->current() }}" />

    <meta property="og:type" content="website" />








    <link href="{{ asset('public/site/images/v-cfavicon.png') }}" sizes="128x128" rel="shortcut icon"
        type="image/x-icon" />

    <link href="{{ asset('public/site/images/v-cfavicon.png') }}" sizes="128x128" rel="shortcut icon" />

    <!-- Apple Touch Icon -->

    <link href="{{ asset('public/site/images/v-cfavicon.png') }}" sizes="60x60" rel="apple-touch-icon">

    <link href="{{ asset('public/site/images/v-cfavicon.png') }}" sizes="72x72" rel="apple-touch-icon">

    <link href="{{ asset('public/site/images/v-cfavicon.png') }}" sizes="114x114" rel="apple-touch-icon">

    <link href="{{ asset('public/site/images/v-cfavicon.png') }}" sizes="180x180" rel="apple-touch-icon">





    <!-- Select2 CSS -->



    <link rel="stylesheet" href="{{ asset('public/site/css/select2/css/select2.min.css') }}">



    <link rel="stylesheet" href="{{ asset('public/site/css/customstyle.css') }}">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"

        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="

        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

    {{-- <link href="https://db.onlinewebfonts.com/c/060fd297f19446447a9a1325ad5b889b?family=SF+Pro+Rounded"

        rel="stylesheet"> --}}

    <style>
        header.nav-homepage-style {
            z-index: 999 !important;
        }

        header.nav-homepage-style.stricky.stricky-fixed {
            z-index: 999 !important;
        }


        header.nav-homepage-style.stricky.stricky-fixed {

            box-shadow: none !important;

        }



        header.header-nav.slideInDown {

            -webkit-animation-name: slideInDown;

            animation-name: none !important;

        }



        .valierror {

            background-color: #ee2e34;

            border-color: #ee2e34;

            color: #fff;

        }



        .alert-message {

            background-size: 40px 40px;

            /* background-image: linear-gradient(135deg, rgba(255, 255, 255, .05) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .05) 50%, rgba(255, 255, 255, .05) 75%, transparent 75%, transparent); */

            /* box-shadow: inset 0 -1px 0 rgb(255 255 255 / 40%); */

            width: 100%;

            border: 0px solid;

            color: #fff;

            padding: 10px;



            animation: animate-bg 5s linear infinite;

            display: block;

            margin-bottom: 5px;

            top: 0;

            z-index: 9999;

        }



        .successmain {

            background-color: #0040E6;

            border-color: #0040E6;

            font-weight: bold;

        }



        .size_active {

            background: #ABABAB;

            color: #000;

            border: 1px solid #09c6ab !important;

        }



        .color_active {

            border: 1px solid #09c6ab !important;

        }



        .alert-message_cart {

            background-size: 40px 40px;

            background-image: linear-gradient(135deg, rgba(255, 255, 255, .05) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .05) 50%, rgba(255, 255, 255, .05) 75%, transparent 75%, transparent);

            width: 100%;

            border: 0px solid;

            color: #000;

            padding: 10px;

            animation: animate-bg 5s linear infinite;

        }



        .topalert_cart {

            z-index: 9999;

            text-align: center;

            padding: 10px;

            font-size: 18px;

            color: #fff !important;

            position: fixed;

            top: 0px;

        }



        .successcart {

            background-color: #09c6ab;

            border-color: #09c6ab;

        }



        @media (min-width: 992px) {

            .navbar-expand-lg .navbar-collapse {

                display: flex !important;

                flex-basis: auto;

                float: right;

            }

        }



        .contact_successmain {

            background-color: #09c6ab;

            border-color: #09c6ab;

            z-index: 9999999;

            position: absolute;

        }



        .contact_successmain1 {

            background-color: #09c6ab;

            border-color: #09c6ab;

            z-index: 9999999;

            /*position: absolute;*/

        }



        .ui-menu {

            z-index: 3500 !important;

        }



        .ad-tag {

            position: absolute;

            left: initial;

            right: 12px;

            top: 4%;

        }



        a:hover,

        .btn:hover {

            color: #0a58ca
        }



        #get_button {

            background-color: #0040E6;

            border-radius: 30px;

            margin-top: 10px;



        }



        #get_button {

            font-size: 13px;

            font-family: var(--title-font-family);

            font-weight: 500;

            height: 40px;

            padding: 1px 13px !important;

        }



        #gets_button_book_now {

            font-size: 25px;

            font-family: var(--title-font-family);

            font-weight: 600;

            height: 45px;

            padding: 10px 23px 23px 27px;

            margin-left: -288%;

            background-color: #FFD312;

            color: #000;

            margin-bottom: -20%;



            /* font-style: italic !important; */

        }



        #gets_button_book_now:hover:before {

            background-color: #FFD312 !important;

        }



        #gets_button_get_quote {

            font-size: 25px;

            font-family: var(--title-font-family);

            font-weight: 500;

            height: 45px;

            padding: 10px 23px 23px 27px;

            margin-left: -221%;

            background-color: #0040E6;

            color: #fff;

            text-align: center;

            margin-bottom: -13%;

            /* font-style: italic !important; */

        }



        #gets_button_sticky_get_quote {

            font-size: 15px;

            font-family: var(--title-font-family);

            font-weight: 500;

            height: 40px;

            padding: 5px 100px;

            background-color: #F9D54B !important;

            color: #000;

            border: 1px solid #000;



        }



        #gets_button_sticky_get_quote:hover {

            background-color: #F9D54B !important;

            border: 1px solid #000;

        }



        #gets_button_sticky_get_quote:hover:before {

            background-color: #F9D54B !important;

        }



        #gets_button_sticky_book_now {

            font-size: 15px;

            font-family: var(--title-font-family);

            font-weight: 500;

            height: 40px;

            padding: 5px 100px;

            background-color: #F9D54B !important;

            color: #000;

            border: 1px solid #000;



        }



        #gets_button_sticky_book_now:hover {

            background-color: #F9D54B !important;

            border: 1px solid #000;

        }



        #gets_button_sticky_book_now:hover:before {

            background-color: #F9D54B !important;

        }



        #mega-menu {

            cursor: pointer;

            height: 42px !important;

            line-height: 30px !important;

            width: 100%;

            padding-top: 7px !important;

            margin-left: 20px !important;

        }



        .mega-menu-custom {

            /* margin-top: 6px; */

            /* background-color: #FFD312 !important; */

        }



        #mega-menu .drop-menu {

            height: auto;

            width: 250px !important;

            padding: 0;

        }



        .hover_effect_add {

            padding-left: 2px !important;

            padding-top: 0 !important;

        }



        .hover_effect_add a {

            padding: 20px 20px !important;

            /* margin-right: 13px !important; */

        }



        .hover_effect_add a:hover {

            border-left: 2px solid #0040E6 !important;

            background: #F0EFEC;

        }



        .hover_effect_add .cat-title {

            margin-bottom: 0 !important;

        }



        .select2-container .select2-selection--single {

            height: 45px !important;

            padding: 7px 0px 0px 0px;



        }



        header.nav-innerpage-style .ace-responsive-menu .sub-menu li:hover {

            background-color: #F0EFEC;

            border-left: 2px solid #0a58ca;

        }



        header.nav-innerpage-style .ace-responsive-menu .sub-menu li {

            border-left: 2px solid transparent;

            padding: 0 10px;

            width: auto;

            -webkit-transition: all 0.4s ease;

            -moz-transition: all 0.4s ease;

            -ms-transition: all 0.4s ease;

            -o-transition: all 0.4s ease;

            transition: all 0.4s ease;

        }



        .ace-responsive-menu>li>a>.arrow:before {

            margin-left: 5px;

        }



        .stepper-wrapper {

            margin-top: auto;

            display: flex;

            justify-content: space-between;

            margin-bottom: 20px;

        }



        .stepper-item {

            position: relative;

            display: flex;

            flex-direction: column;

            align-items: center;

            flex: 1;



            @media (max-width: 768px) {

                font-size: 12px;

            }

        }



        .stepper-item::before {

            position: absolute;

            content: "";

            border-bottom: 2px solid #ccc;

            width: 100%;

            top: 40px;

            left: -50%;

            z-index: 2;

        }



        .stepper-item::after {

            position: absolute;

            content: "";

            border-bottom: 0px solid #ccc;

            width: 100%;

            top: 20px;

            left: 50%;

            z-index: 2;

        }



        .stepper-item .step-counter {

            position: relative;

            z-index: 5;

            display: flex;

            justify-content: center;

            align-items: center;

            width: 80px;

            height: 80px;

            border-radius: 50%;

            background: #ccc;

            margin-bottom: 6px;

        }



        .stepper-item.active {

            font-weight: bold;

        }



        .stepper-item.completed .step-counter {

            background-color: #4bb543;

        }



        .stepper-item.completed::after {

            position: absolute;

            content: "";

            border-bottom: 0px solid #4bb543;

            width: 100%;

            top: 20px;

            left: 50%;

            z-index: 3;

        }



        .stepper-item:first-child::before {

            content: none;

        }



        .stepper-item:last-child::after {

            content: none;

        }



        .custom_button .dropdown-toggle {

            height: 30px !important;

            line-height: 20px !important;

        }



        .custom_button .filter-option-inner-inner {

            font-size: 15px !important;

        }



        .list_header {

            position: absolute;

            background: #fff;

            z-index: 999;

            width: 100%;

        }



        header.nav-homepage-style .ace-responsive-menu .sub-menu li:hover {

            background-color: #F0EFEC;

            border-left: 2px solid #FFD312 !important;



        }



        header.nav-homepage-style .ace-responsive-menu .megamenu_style a.list-item:before,

        header.nav-homepage-style .ace-responsive-menu .visible_list a.list-item:before {

            background-color: #FFD312;

        }



        #mega-menu .drop-menu {

            left: 323px !important;

        }



        #mega-menu .menu li:hover {

            border-left: 2px solid #FFD312;

        }



        .hover_effect_add a:hover {

            border-left: 2px solid #FFD312 !important;

            background: #F0EFEC;

        }



        /* for ipad mini */

        @media (max-width: 768px) {

            #gets_button_get_quote {

                /* margin-left: -15px !important; */

                margin-bottom: -15% !important;

                font-size: 17px;

                padding: 3px 10px 10px 10px !important;

                top: 0px;

            }



            #gets_button_book_now {

                margin-left: -16px !important;

                margin-bottom: 0% !important;

                font-size: 20px;

                font-weight: 600;

                /* top: 25px !important; */

            }

        }



        /* for ipad air */

        @media (min-width: 820px) {

            #gets_button_get_quote {

                margin-left: -18px !important;

                margin-bottom: -15% !important;

                font-size: 17px;

                padding: 6px 10px 30px 11px !important;

                top: 18px;

            }



            #gets_button_book_now {

                margin-left: -18px !important;

                margin-bottom: -4% !important;

                font-size: 17px;

                font-weight: 600;

                top: 25px !important;

            }

        }



        /* for ipad pro */

        @media (min-width: 1024px) {

            #gets_button_get_quote {

                margin-left: -4px !important;

                /* margin-bottom: -12% !important; */

                font-size: 25px;

                padding: 10px 18px 38px 18px !important;

                font-weight: 1000;

                bottom: 12px !important;

                top: -10px !important;

            }



            #gets_button_book_now {

                margin-left: 0px !important;

                /* margin-bottom: -18% !important; */

                font-size: 25px;

                font-weight: 600;

                top: 0px !important;

            }

        }



        @media only screen and (max-width: 600px) {

            .need_cleaner {

                top: 10px !important;

            }



            .popular {

                font-size: 11px !important;

                top: -15% !important;

            }



            .bordermob {

                border: 1px solid #ccc !important;

                border-radius: 8px;

            }



            h2 {

                font-size: 25px !important;

                line-height: normal !important;

            }



            .px-5 {

                padding-right: 0 !important;

                padding-left: 0 !important;

            }



            .reviewList h2 {

                font-size: 28px !important;

            }



            .we_cut_out_paragraph {

                font-size: 15px !important;

                line-height: 1.85 !important;

            }



            #search_auto_mobile {

                height: 35px !important;

                font-size: 14px !important;

            }



            .mobile_button_div .form-control {

                height: 35px !important;

                font-size: 14px !important;

                border-radius: 0px 8px 8px 0px !important;

            }



            .mt120 {

                margin-top: 5px !important;

            }



            a.mm-listitem__text:hover,

            a.mm-btn.mm-btn_next.mm-listitem__btn.mm-listitem__text:hover {

                color: #FFD312 !important;

                border-left: 2px solid #FFD312;

            }



            .subservice_image_sec .list-content a {

                padding: 25px 10px !important;

            }



            .button_weekly label {

                width: 98% !important;

            }



            .form-group label {

                font-size: 14px !important;

            }



            /* .surcharge-badge-timeslot input{

        width:27% !important;

    } */

            .dates-container {

                width: 100% !important;

            }



            .cleaning_weekly {

                color: #222222;

                float: right;

                background-color: #f7dd14;

                padding: 0px 4px 0px 4px;

                border-radius: 7px;

                font-size: 13px;

            }



            .hour_input label {

                border-radius: 43%;

                padding: 7px 25px;

            }



            .need_cleaner {

                display: block !important;

            }



            .hour_input {

                float: left;

            }



            .fw500 {

                font-weight: 1000;

                font-size: 16px;

            }



            .dettol {

                font-size: 11px;

                "



            }



            .mid_col {

                box-shadow: 0 0 8px 3px rgba(0, 0, 0, 0.2);

                padding: 13px 13px 13px 13px;

                border-radius: 10px;

                margin-bottom: 20px;

            }



            .payment-type label {

                display: grid;

                width: 100% !important;

            }



            .step-p {

                margin: 0 0 -10px 0 !important;

                font-size: 21px;

                padding-top: 15px;

            }



            .step-title {

                margin-left: 0 !important;

            }



            .left-summary-total {

                padding: 20px 0px 14px 90px !important;

            }



            .left-summary-title-strong {

                margin-left: 12px !important;

            }



            #gets_button_get_quote {

                margin-left: -12px !important;

                /* margin-bottom: -12% !important; */

                font-size: 17px;

            }



            #gets_button_book_now {

                margin-left: 0px !important;

                /* margin-bottom: -20% !important; */

                font-size: 22px !important;

                font-weight: 600 !important;

                width: 100%;

                padding: 8px 23px 23px 27px !important;



            }



            #gets_button_booknow {

                font-size: 22px !important;

                font-weight: 600 !important;

                width: 100%;

                padding: 8px 23px 23px 27px !important;

            }



            .scrollButton-h3-get-quote {

                display: none !important;

            }



            #gets_button_sticky_get_quote {

                left: 22px !important;

            }



            .scrollButton-h3-book-now {

                display: none !important;

            }



            #gets_button_sticky_book_now {

                left: 50px !important;

            }



        }



        @media(min-width: 414px) {

            #gets_button_sticky_get_quote {

                left: 32px !important;

            }



            #gets_button_sticky_book_now {

                left: 70px !important;

            }

        }



        @media(min-width: 375px) {

            #gets_button_sticky_get_quote {

                left: 15px !important;

            }



            #gets_button_sticky_book_now {

                left: 50px !important;

            }

        }



        @media(min-width: 390px) {

            #gets_button_sticky_get_quote {

                left: 20px !important;

            }



            #gets_button_sticky_book_now {

                left: 58px !important;

            }

        }



        @media(min-width: 412px) {

            #gets_button_sticky_get_quote {

                left: 32px !important;

            }



            #gets_button_sticky_book_now {

                left: 70px !important;

            }

        }



        @media(max-width: 360px) {

            #gets_button_sticky_get_quote {

                left: 8px !important;

            }



            #gets_button_sticky_book_now {

                left: 43px !important;

            }

        }



        .web_whatsapp a {

            display: inline-block;

            width: 46px;

            line-height: 44px;

            border-radius: 50%;

            position: fixed;

            bottom: 16%;

            right: 3%;

            text-align: center;

            font-size: 29px;

            color: #fff;

            z-index: 9999;

            background: #00e676;

        }



        .custom_font_awesome {

            margin-left: 0 !important;

            transform: inherit !important;

            margin-right: 7px !important;

        }



        .dropdown_mobile {

            position: relative;

            display: inline-block;

            font-family: Arial, sans-serif;

            width: 100%;

        }



        .dropdown_mobile .dropdown-search {

            display: block;

            /* width: 250px; */

            padding: 8px 16px;

            border: 2px solid #e9e9e9;

            border-radius: 7px;

            outline: none;

            text-align: left;

            font-size: 16px;

        }



        .dropdown_mobile .dropdown-search:focus {

            border-bottom: 2px solid #3e57ff;

            background-color: #f6f6f6;

        }



        .dropdown_mobile .dropdown .dropdown-list {

            position: absolute;

            overflow: auto;

            z-index: 9;

            top: 25px;

            left: 0;

            width: 250px;

            max-height: 250px;

            padding: 8px;

            display: none;

            border-radius: 7px;

            background: #fff;

            border: 1px solid #e9e9e9;

            box-shadow: 0 1px 2px rgb(204, 204, 204);

        }



        .dropdown_mobile .dropdown .dropdown-list::-webkit-scrollbar {

            width: 7px;

        }



        .dropdown_mobile .dropdown .dropdown-list::-webkit-scrollbar-track {

            background: #f1f1f1;

            border-radius: 25px;

        }



        .dropdown_mobile .dropdown .dropdown-list::-webkit-scrollbar-thumb {

            background: #ccc;

            border-radius: 25px;

        }



        .dropdown_mobile .dropdown .dropdown-list::-webkit-scrollbar-thumb:hover {

            background: #b3b3b3;

        }



        .dropdown_mobile .dropdown-list li {

            display: none;

            padding: 10px;

            border-radius: 4px;

            cursor: pointer;

            transition: all .2s ease-in-out;

        }



        .dropdown_mobile .dropdown-list li:hover {

            background-color: #f2f2f2;

        }



        .dropdown_mobile .not-found {

            cursor: default;

        }



        .list_mobile {

            position: absolute;

            background: #fff;

            z-index: 999;

            width: 100%;



            background-color: #3e57ff;

        }



        .list_mobile li {

            cursor: pointer;

            color: #fff;

            padding: 10px 10px 0 14px;

            border-bottom: 1px solid #fff;

        }



        /* Start Enquiry User Popup Modal Style */



        .input-field {

            display: block;

            width: 100%;

            height: 45px !important;

            padding: 6px 12px !important;

            font-size: 14px !important;

            line-height: 1.42857143 !important;

            color: #131313 !important;

            background-color: transparent !important;

            background-image: none !important;

            border: none !important;

            border-bottom: 1px solid #2b333a9e !important;

            border-radius: 0px !important;

            box-shadow: none !important;

            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;

        }



        /* .form-control:focus {

  border-color: #000;

  -webkit-box-shadow: none;

  box-shadow: none;

  border-bottom: 1px solid #000;

} */



        .login-form-modal .my_btn {

            font-size: 14px;

            color: #000;

            font-family: Avenir-Medium;

            text-transform: uppercase;

            border-style: solid;

            border-image-source: linear-gradient(270deg, #FCFF00, #18f0b8, #18a2f0, #FCFF00);

            border-image-slice: 1;

            border-width: 2px;

            margin-top: 0;

            padding: 14px 18px 10px 16px;

            position: relative;

            text-align: center;

            --borderWidth: 2px;

            border-radius: 0;

            /* border: none; */

            background: #fff;

            display: block;

            max-width: fit-content;

            margin-bottom: 10px;

            line-height: 20px;

            transition: .9s ease-in-out;

            margin: auto;

        }



        .modal-footer {

            margin-top: -20px;

            border-top: none !important;

        }





        .login-form-modal form {

            max-width: 90%;

            margin: auto;

            display: flex;

            flex-direction: column;

            row-gap: 8px;

            /* padding-top: 20px; */

        }



        .login-form-modal h3 {

            font-size: 22px;

            line-height: 32px;

        }



        .login-form-modal h3 br {

            /*display:  none;*/

        }



        .login-form-modal {

            padding: 50px 0 0 0;

            margin: auto;

            z-index: 999999999;

        }





        .View-land-submit {

            margin-bottom: 25px;

            text-align: center;

            padding: 10px 20px;

            background: #299c9c;

            text-decoration: none;

            border-radius: 40px;

            color: white;

            font-size: 18px;

            border: 2px solid #299c9c;

        }



        body.modal-open {

            overflow: hidden !important;

        }



        body.modal-open {

            padding-right: 0px !important;

        }



        .user-modal-dialog {

            max-width: 37% !important;

        }



        .login-form-modal {

            overflow-x: inherit !important;

            overflow-y: inherit !important;

        }



        .login-form-modal {

            padding-top: 10%;

        }





        @media (max-width: 768px) {

            .user-modal-dialog {

                max-width: 100% !important;

                padding-top: 20%;

            }



            .web_whatsapp a {

                z-index: 99 !important;

            }

        }



        @media only screen and (max-width: 767px) {



            .body_content {

                margin-top: 80px
            }



            .body_content .our-register {

                margin-top: 121px
            }

        }



        //.owl-item.active {

        //  width: auto !important;

        //}

        .modal-title {

            color: #000000;

            font-size: 30px;

            font-weight: bold;

        }



        .details-form label {

            font-size: 20px;

            color: #000000;

            font-weight: 500;

        }



        .detail-continue-btn {

            background-color: #FFCE00 !important;

            color: #000000;

            border-color: #FFCE00 !important;



            width: 100%;

            border-radius: 4px;

            display: inline-block;

            font-family: var(--title-font-family);

            font-weight: 700;

            font-size: 20px;

            font-style: normal;

            letter-spacing: 0em;

            padding: 8px 67px;

            position: relative;

            overflow: hidden;

            text-align: center;

            z-index: 0;

            margin-bottom: 10px;

            -webkit-transition: all 0.4s ease;

            -moz-transition: all 0.4s ease;

            -ms-transition: all 0.4s ease;

            -o-transition: all 0.4s ease;

            transition: all 0.4s ease;

        }



        .intl-tel-input,

        .iti {

            width: 100%;

        }



        .iti--allow-dropdown input,

        .iti--allow-dropdown input[type=text],

        .iti--allow-dropdown input[type=tel],

        .iti--separate-dial-code input,

        .iti--separate-dial-code input[type=text],

        .iti--separate-dial-code input[type=tel] {

            padding-right: 6px !important;

            padding-left: 91px !important;

            margin-left: 0;

        }



        .details-header {

            display: flex;

            flex-shrink: 0;

            align-items: center;

            justify-content: space-between;

            padding: 10px 2rem !important;

            border-bottom: 1px solid #dee2e6;

            border-top-left-radius: calc(.3rem - 1px);

            border-top-right-radius: calc(.3rem - 1px);

            /* margin-left: 20px; */

        }



        .details-modal-content {

            border-radius: 15px;

        }



        .container {

            max-width: 1120px !important;

        }



        /* End Enquiry User Popup Modal Style */









        /* .btn-thm2-custom{background-color: #FFD312 !important;} */
    </style>

    <style>
        .dropdownnew {

            position: relative;

            display: inline-block;

        }



        .dropdown-content-new {

            display: none;

            position: absolute;

            background-color: #ffffff;

            min-width: 700px;

            padding: 20px;

            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);

            border-radius: 8px;

            z-index: 9999;

            top: 58px;

        }

        #myDropdownnew {
            z-index: 99999 !important;
        }



        .mega-menu {

            padding: 0;

        }



        .mega-item h3 {

            font-size: 18px;

        }



        .mega-item ul li {

            font-size: 14px;

        }



        .dropdown-content-new a {

            color: #333;

            padding: 0 0 0 0px;

            text-decoration: none;

            display: block;

            border-radius: 5px;

            transition: background-color 0.3s ease;

        }



        .dropdown-content-new a:hover {

            /* background-color: #f0f0f0; */

        }



        #myDropdownnew h6 {

            font-weight: 600;

            padding: 00px 0 5px 30px;

            font-size: 20px;

            margin-bottom: 10px;

            border-bottom: 2px solid #eee;

        }



        #myDropdownnew {

            min-width: 1130px;

            max-width: 1000px;

            padding: 10px 16px;

            overflow: hidden;

            max-height: 700px;

            margin-top: 8px !important;

        }



        .show-new {

            display: block;

        }



        .btn-mega {

            color: white;

            border: none;

            border-radius: 5px;

            cursor: pointer;

            font-size: 16px;

        }



        .dropdown-item {

            white-space: normal;

            word-wrap: break-word;

        }



        .cleaning-subservice {

            font-weight: 600 !important;

        }



        @media screen and (max-width: 1366px) and (min-width: 1024px) {

            #mega-menu {

                max-width: 100% !important;

            }



        }



        .stricky-fixed .head_search_sticky {

            display: block !important;

        }



        .mobilie_header_nav.stylehome1 {

            position: fixed;

            top: 0;

            width: 100%;

            z-index: 9999;

            background: white;

        }



        .custom_menu_withotcontainer {

            padding-left: 40px;

            padding-right: 40px;

        }



        .custom_menu_withotcontainer .ace-responsive-menu>li>ul.sub-menu {

            right: 0 !important
        }



        .custom_menu_withotcontainer .head_search_sticky {

            width: 43%;

        }



        .custom_menu_withotcontainer .resfix a.mx30 {

            margin-left: 20px !important;

        }



        .closeBtn {

            background: none;

            font-size: 50px;

            color: #000;

            border: none;

            position: absolute;

            right: 10px;

            top: 9px;

            margin: 0;

            padding: 0;

            width: 30px;

        }



        #email_modalStepTitle {

            font-size: 18px !important;

        }



        #modalStepTitle {

            font-size: 18px !important;

        }



        #mobilename-label {

            font-size: 16px !important;

            color: #606060 !important;

        }



        .email-whatsapp {

            color: #989898;

            text-decoration: underline;

        }



        .otp-input {

            padding-left: 0px !important;

        }



        .email-otp-input {

            padding-left: 0px !important;

        }



        .otp-login-form-modal .my_btn {

            font-size: 14px;

            color: #000;

            font-family: Avenir-Medium;

            text-transform: uppercase;

            border-style: solid;

            border-image-source: linear-gradient(270deg, #FCFF00, #18f0b8, #18a2f0, #FCFF00);

            border-image-slice: 1;

            border-width: 2px;

            margin-top: 0;

            padding: 14px 18px 10px 16px;

            position: relative;

            text-align: center;

            --borderWidth: 2px;

            border-radius: 0;

            /* border: none; */

            background: #fff;

            display: block;

            max-width: fit-content;

            margin-bottom: 10px;

            line-height: 20px;

            transition: .9s ease-in-out;

            margin: auto;

        }



        .otp-login-form-modal {

            overflow-x: inherit !important;

            overflow-y: inherit !important;

        }



        .otp-login-form-modal form {

            max-width: 90%;

            margin: auto;

            display: flex;

            flex-direction: column;

            row-gap: 8px;

        }



        .otp-login-form-modal h3 {

            font-size: 22px;

            line-height: 32px;

        }



        .otp-login-form-modal {

            margin: auto;

            z-index: 999999999;

        }



        .brds50 {

            border-radius: 50px !important;

        }



        .footer-link {

            color: #989898;

            font-size: 14px;

            text-decoration: underline;

        }



        .footer-link:hover {

            color: #989898;

        }



        @media (max-width: 767.98px) {

            .modal-mobile-bottom-otp {

                padding: 0 !important;

            }



            .modal-dialog-bottom-otp {

                position: fixed;

                bottom: 0;

                left: 0;

                right: 0;

                margin: 0;

                width: 100%;

                max-width: 100%;

                transform: translateY(100%);

                transition: transform 0.5s ease-out, opacity 0.5s ease-out;

                opacity: 0;

                display: flex;

                flex-direction: column;

                z-index: 1055;

            }



            .modal.show .modal-dialog-bottom-otp {

                transform: translateY(0);

                opacity: 1;

            }

        }



        @media (max-width: 767.98px) {

            .modal-dialog-centered {

                min-height: 0 !important;

            }

        }



        @media (max-width: 767px) {

            .sidebarLeftcol {

                display: none !important;

            }

        }
    </style>




</head>



<body>



    <!-- Google Tag Manager (noscript) -->

    {{-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-ML9CL33C"

    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> --}}

    <!-- End Google Tag Manager (noscript) -->







    <div class="wrapper ovh">

        <div id="message_succsess" class="successmain alert-message topalert"
            style="text-align: center;display: none; position: fixed;"></div>

        <div id="message_error" class="valierror alert-message topalert"
            style="display:none;text-align: center;

            position: fixed;"></div>



        <div id="message_error" class="valierror alert-message topalert"
            style="display:none;text-align: center;

                    position: fixed;"></div>



        <div class="preloader"></div>







        <!-- Main Header Nav -->

        <header class="header-nav nav-homepage-style stricky stricky-fixed main-menu">


            <!-- Ace Responsive Menu -->

            <nav class="posr">

                <div class="posr menu_bdrt1 custom_menu_withotcontainer">

                    <div class="row align-items-center justify-content-between">

                        <div class="col-auto px-0">

                            <div class="d-flex align-items-center justify-content-between">

                                <div class="logos">

                                    <a class="header-logo logo1"
                                        href="{{ route('city.home', ['city' => session('search_city_name')]) }}"><img
                                            style="max-width: 150px;"
                                            src="{{ asset('public/site/images/VC-FULL-COLOR.png') }}"
                                            alt="Vendorscity"></a>



                                    <a class="header-logo logo2"
                                        href="{{ route('city.home', ['city' => session('search_city_name')]) }}"><img
                                            style="max-width: 150px;"
                                            src="{{ asset('public/site/images/VC-FULL-COLOR.png') }}"
                                            alt="Vendorscity"></a>

                                </div>

                                @php

                                    // $service_data = DB::table('services')->orderBy('set_order')->get();

                                    $service_data = DB::table('services')

                                        ->where('is_active', 0)

                                        ->whereRaw('FIND_IN_SET(?, city)', [session('search_city_id')])

                                        ->orderBy('set_order')

                                        ->get();

                                @endphp

                                <div class="home1_style">

                                    <div id="mega-menu" class="mega-menu-custom dropdown">

                                        <a class="btn-mega fw500 text-white dropbtnnew" onclick="myFunction()"><span
                                                class="pl20 pl10-xl pr5 fz15 vam flaticon-menu"> </span> All Services

                                        </a>

                                        <div id="myDropdownnew" class="dropdown-content-new">



                                            <div class="mega-menu">

                                                <div class="mega-grid">



                                                    @if ($service_data != '' && count($service_data) > 0)

                                                        @foreach ($service_data as $service_datadynamic)
                                                            @php

                                                                $subservice_data = DB::table('subservices')

                                                                    ->where('serviceid', $service_datadynamic->id)

                                                                    ->whereRaw('FIND_IN_SET(?, city)', [
                                                                        session('search_city_id'),
                                                                    ])

                                                                    ->where('is_active', 0)

                                                                    ->orderBy('set_order')

                                                                    ->get();

                                                            @endphp

                                                            <div class="mega-item">

                                                                <a
                                                                    href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => $service_datadynamic->page_url]) }}">

                                                                    <h3>{{ $service_datadynamic->servicename }}</h3>

                                                                </a>

                                                                <ul>



                                                                    @if ($subservice_data != '' && count($subservice_data) > 0)
                                                                        @foreach ($subservice_data as $subservice)
                                                                            <li>



                                                                                @if ($subservice->id == 92)
                                                                                    <a
                                                                                        href="{{ route('automobile.listing', ['page_url' => $subservice->page_url]) }}">
                                                                                    @else
                                                                                        <a
                                                                                            href="{{ route('front.package_lists', ['city' => session('search_city_name'), 'page_url' => $subservice->page_url]) }}">
                                                                                @endif







                                                                                <strong>{{ $subservice->subservicename }}</strong></a>

                                                                            </li>



                                                                            @php

                                                                                $package_categories = DB::table(
                                                                                    'package_categories',
                                                                                )

                                                                                    ->where(
                                                                                        'subservice_id',

                                                                                        $subservice->id,
                                                                                    )

                                                                                    ->where('set_in_menu', 0)

                                                                                    ->get();

                                                                            @endphp



                                                                            @if ($package_categories != '' && count($package_categories) > 0)
                                                                                @foreach ($package_categories as $package_categoriesData)
                                                                                    <li>



                                                                                        <a
                                                                                            href="{{ route('front.package_lists', ['city' => session('search_city_name'), 'page_url' => $subservice->page_url]) }}?category={{ $package_categoriesData->id }}">



                                                                                            {{ $package_categoriesData->name }}</a>

                                                                                    </li>
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach
                                                                    @endif

                                                                </ul>

                                                            </div>
                                                        @endforeach

                                                    @endif

                                                </div>

                                            </div>



                                        </div>

                                    </div>

                                </div>

                                <!-- Responsive Menu Structure-->

                                <ul class="ace-responsive-menu" data-menu-style="horizontal">

                                    {{-- <li class="visible_list"> <a class="list-item" href="{{ url('/') }}"><span

                                                class="title">Home</span></a>

                                       



                                    </li> --}}









                                    {{-- <li class="visible_list"> <a class="list-item "

                                            href="{{ url('/services') }}">Services</a>

                                    </li> --}}



                                    {{-- <li class="visible_list"> <a class="list-item "

                                            href="{{ url('/our-vendors') }}">Our Vendors</a>



                                    </li> --}}

                                    {{-- <li class="visible_list"> <a class="list-item "

                                            href="{{ url('/blog') }}">Blogs</a>



                                    </li> --}}

                                    {{-- <li class="visible_list"> <a class="list-item " href="#">Get Free Quote</a>

                                    </li> --}}

                                    <li> <a class="list-item " href="#"></a></li>

                                </ul>

                            </div>

                        </div>

                        @php

                            $segments_head = request()->segment(2);

                            if (empty($segments_head)) {
                                $display_div_head = 0;
                            } else {
                                $display_div_head = 1;
                            }

                            if ($display_div_head == 0) {
                                $style_div_head = 'display: none;';
                            } else {
                                $style_div_head = 'display: block;';
                            }

                        @endphp

                        {{-- @if ($display_div_head == 1) --}}

                        <div class="col-auto px-0 head_search_sticky"
                            style="position: relative;{{ $style_div_head }}">

                            <div
                                class="advance-search-tab bgc-white p5 bdrs4-sm bdrs60 banner-btn position-relative zi1  mt20 ">

                                <div class="row">

                                    <div class="col-md-4 col-lg-8 col-xl-8">

                                        <div class="advance-search-field mb10-sm">

                                            <form action="{{ url('search-package') }}" method="get"
                                                id="search_banner_header" class="form-search position-relative">

                                                @csrf

                                                <div class="box-search">

                                                    {{-- <span class="icon far fa-magnifying-glass"></span> --}}

                                                    <input class="form-control bordermob" type="text"
                                                        name="search" value="{{ session('search_content') }}"
                                                        placeholder="What service are you looking for?"
                                                        id="search_auto_header" autocomplete="off"
                                                        style="

                                                    padding: 4px;

                                                    height: 30px;

                                                    font-size: 15px;

                                                ">





                                                </div>



                                                <input type="hidden" name="search_city" value="17"
                                                    id="search_city_header">

                                                <input type="hidden" name="currentUrl_header" value=""
                                                    id="currentUrl_header">

                                            </form>

                                        </div>





                                    </div>



                                    <div class="col-md-5 col-lg-4 col-xl-4">



                                        @php

                                            if (session('search_country_name') == 'United Arab Emirates') {
                                                $city_head = DB::table('cities')

                                                    ->where('country', session('search_country_id'))

                                                    ->orderBy('name', 'asc')

                                                    ->get();
                                            } else {
                                                $StateId = session('search_state_id');

                                                $city_head = DB::table('cities')

                                                    ->where('country', session('search_country_id'))

                                                    ->when(!empty($StateId), function ($query) use ($StateId) {
                                                        return $query->where('state', $StateId);
                                                    })

                                                    ->get();
                                            }

                                        @endphp



                                        <div class="bselect-style1 bdrl1 bdrn-sm bordermob custom_button">

                                            <select class="selectpicker" data-width="100%"
                                                onchange="search_city_header(this.value);">

                                                <option>Choose City</option>

                                                @if ($city_head != '')

                                                    @foreach ($city_head as $city_head_data)
                                                        <option data-tokens="{{ $city_head_data->name }}"
                                                            value="{{ $city_head_data->id }}"
                                                            @if ($city_head_data->id == session('search_city_id')) selected @endif>

                                                            {{ $city_head_data->name }}

                                                        </option>
                                                    @endforeach

                                                @endif

                                            </select>

                                        </div>



                                    </div>

                                    {{-- <div class="col-md-3 col-lg-2 col-xl-3">

                                    <div class="text-center text-xl-start">

                                        <button class="ud-btn btn-thm w-100 bdrs60 mgtop20" type="button"

                                            onclick="search_banner_header()" style="

                                            padding: 0;

                                        ">Search</button>

                                    </div>

                                </div> --}}

                                </div>

                            </div>



                            <p class="form-error-text" id="search_auto_header_error"
                                style="color: red; margin-top: 10px;">

                            </p>

                            <ul class="list_header"></ul>

                        </div>



                        {{-- <div class="col-auto px-0 resfix mt10">

                            <div class="d-flex align-items-center">

                                <a class="ud-btn btn-thm2 add-joining ml10" href="tel:0568363677" style="

                                padding: 5px 18px !important;

                            ">

                            <i class="fa-solid fa-phone custom_font_awesome"></i>056 836 3677</a>

                            </div>

                        </div> --}}

                        {{-- @endif --}}





                        <div class="col-auto px-0 resfix">

                            <div class="d-flex align-items-center">

                                <a class="ud-btn btn-thm2 add-joining ml10 btn-thm2-custom" href="tel:0568363677"
                                    style="

                                padding: 5px 18px !important;

                            ">

                                    <i class="fa-solid fa-phone custom_font_awesome"></i>056 836 3677</a>

                                {{-- <a class="login-info" data-bs-toggle="modal" href="#exampleModalToggle"

                                    role="button"><span class="flaticon-loupe"></span></a> --}}

                                <a class="login-info mx10-lg mx30" href="{{ url('/become-a-vendor') }}"><span
                                        class="d-none d-xl-inline-block">Become a</span> Vendor</a>

                                @php

                                    $userData = Session::get('user');

                                    // $userData = Session::get('user');

                                @endphp

                                @if ($userData == '')
                                    {{-- <a class="login-info mr10-lg mr30" href="{{ url('Sign-Up') }}">Registration</a> --}}

                                    {{-- <a class="login-info mr10-lg mr30" href="{{ route('Sign-in') }}">Log

                                        in</a> --}}



                                    <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">

                                        <li class="visible_list"> <a style="padding-left: 0;" class="list-item"
                                                href="#"><span class="title">Login</span></a>





                                            <!-- Level Two-->

                                            <ul>

                                                <!-- <li><a href="{{ route('Sign-in') }}">Customer Login</a></li> -->



                                                <li> <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#otp_popup_Modal">Customer Login</a></li>





                                                <li><a href="{{ url('/vendor/login') }}">Vendor Login</a></li>

                                            </ul>

                                        </li>

                                    </ul>
                                @else
                                    {{-- <a class="login-info mr10-lg mr30" href="{{ route('user_signout') }}">Log out</a> --}}



                                    <!-- <a class="login-info mr10-lg mr30" href="{{ url('my-account') }}"> <i class="fa-regular fa-user text-thm2 pe-2 vam"></i></a> -->



                                    <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">

                                        <li class="visible_list"> <a style="padding-left: 0;" class="list-item"
                                                href="#"><span class="title">

                                                    {{ $userData['name'] }}</span></a>

                                            <ul>

                                                <li><a href="{{ url('my-account') }}"><i
                                                            class="far fa-home"></i>Dashboard </a></li>

                                                <li><a href="{{ route('front.myleads') }}"><i
                                                            class="far fa-file-alt"></i>My Quotes</a></li>

                                                <li><a href="{{ url('my-order') }}"><i class="far fa-file-alt"></i>My

                                                        Orders</a></li>

                                                <li><a href="{{ url('my-profile') }}"><i class="far fa-user"></i>My

                                                        Profile</a></li>

                                                <li><a href="{{ url('my-wallet') }}"><i
                                                            class="far fa-wallet"></i>Wallet</a></li>

                                                <li><a href="{{ url('refer&earn') }}"><i
                                                            class="fa-regular fa-gift"></i>Refer And Earn</a></li>

                                                <li><a href="{{ url('refral') }}"><i class="fa-regular fa-gift"></i>

                                                        Referral List</a></li>

                                                <li><a href="{{ route('user_signout') }}"><i
                                                            class="far fa-sign-out-alt"></i>Logout</a></li>

                                            </ul>

                                        </li>

                                    </ul>
                                @endif





                                {{-- <a class="ud-btn btn-thm2 add-joining" href="{{ url('/services') }}">Book Now!</a>

                                <a class="ud-btn btn-thm2 add-joining ml10 btn-thm2-custom" href="{{ url('/cart') }}" style="

                                    padding: 5px 18px !important;

                                "><span class="fa-solid fa-cart-shopping  "></span> Cart</a> --}}

                            </div>

                        </div>

                    </div>

                </div>

            </nav>

        </header>

        <!-- Search Modal -->

        <div class="search-modal">

            <div class="modal fade" id="exampleModalToggle" aria-hidden="true"
                aria-labelledby="exampleModalToggleLabel" tabindex="-1">

                <div class="modal-dialog modal-lg">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h5 class="modal-title" id="exampleModalToggleLabel"></h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                    class="fal fa-xmark"></i></button>

                        </div>

                        <div class="modal-body">

                            <div class="popup-search-field search_area">

                                <input type="text" class="form-control border-0"
                                    placeholder="What service are you looking for today?">

                                <label><span class="far fa-magnifying-glass"></span></label>

                                <button class="ud-btn btn-thm" type="submit">Search</button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <div class="hiddenbar-body-ovelay"></div>



        <!-- Mobile Nav  -->

        <div id="page" class="mobilie_header_nav stylehome1">

            <div class="mobile-menu">

                <div class="header bdrb1">

                    <div class="menu_and_widgets">

                        <div class="mobile_menu_bar d-flex justify-content-between align-items-center">

                            <a class="mobile_logo" href="{{ url('/') }}"><img style="max-width: 150px;"
                                    src="{{ asset('public/site/images/VC-FULL-COLOR.png') }}" alt=""></a>





                            <a class="ud-btn btn-thm2 add-joining ml10 btn-thm2-custom" href="tel:0568363677"
                                style="

                                    padding: 5px 18px !important;

                                    line-height: 30px;

                                    position: absolute;

                                    right: 65px;

                                ">

                                {{-- <span class="flaticon-call" style="

                                    top: 3px;

                                    position: relative;

                                    left: -4px;

                                "></span> --}}

                                <i class="fa-solid fa-phone custom_font_awesome"></i>



                                CALL</a>



                            <div class="right-side text-end">

                                <!-- <a class="" href="page-login.html">join</a> -->

                                <a class="menubar ml30" href="#menu"><img
                                        src="{{ asset('public/site/images/mobile-dark-nav-icon.svg') }}"
                                        alt="Dark-themed mobile menu navigation icon"></a>

                            </div>

                        </div>

                    </div>

                    <div class="posr">

                        <div class="mobile_menu_close_btn"><span class="far fa-times"></span></div>

                    </div>

                </div>



                {{-- Mobile Search Start --}}

                @if ($display_div_head == 1)

                    <div class="col-auto px-0">

                        <div
                            class="advance-search-tab bgc-white p10 bdrs4-sm  banner-btn position-relative zi1 animate-up-3 ">

                            <div class="row">

                                <div class="col-md-4 col-lg-7 col-xl-7">

                                    <div class="advance-search-field mb10-sm">

                                        <form action="{{ url('search-package') }}" method="get"
                                            id="search_banner_mobile" class="form-search position-relative">

                                            @csrf

                                            {{-- <div class="box-search">

                                               

                                                <input class="form-control bordermob" type="text" name="search" value="{{ session('search_content') }}"

                                                    placeholder="What service are you looking for?" id="search_auto_header" autocomplete="off" style="

                                                    padding: 4px;

                                                    height: 30px;

                                                    font-size: 13px;

                                                ">

        

                                                  

                                            </div> --}}



                                            <div class="dropdown_mobile" id="search_vendor">

                                                <input type="text" class="form-control" name="search"
                                                    value="{{ session('search_content') }}"
                                                    placeholder="What service are you looking for?"
                                                    id="search_auto_mobile" autocomplete="off">

                                                <ul class="dropdown-list-mobile list_mobile"
                                                    style="

                                                padding: 0;

                                                margin: 0;

                                            ">



                                                </ul>

                                            </div>

                                            <div class="mobile_button_div">

                                                @php

                                                    $city_head = DB::table('cities')->get();

                                                @endphp



                                                <select class="form-control" data-width="100%"
                                                    onchange="search_city_mobile(this.value);"
                                                    style="width: 31%;background: #0040E6;position: fixed;right: 2%;bottom: 23%;color: #fff;top:10px;">

                                                    <option>Choose City</option>

                                                    @if ($city_head != '')

                                                        @foreach ($city_head as $city_head_data)
                                                            <option data-tokens="{{ $city_head_data->name }}"
                                                                value="{{ $city_head_data->id }}"
                                                                @if ($city_head_data->id == session('search_city_id')) {{ 'selected' }} @endif>

                                                                {{ $city_head_data->name }}

                                                            </option>
                                                        @endforeach

                                                    @endif

                                                </select>



                                            </div>





                                            <input type="hidden" name="search_city" value="17"
                                                id="search_city_mobile_id">

                                            <input type="hidden" name="currentUrl" value=""
                                                id="currentUrl_mobile">

                                        </form>

                                    </div>





                                </div>



                                {{-- <div class="col-md-5 col-lg-5 col-xl-5">



                                    @php



                                        $city_head = DB::table('cities')->get();

                                    @endphp

        

                                    <div class="bselect-style1 bdrl1 bdrn-sm bordermob custom_button">

                                        <select class="selectpicker" data-width="100%" onchange="search_city_header(this.value);">

                                            <option>Choose City</option>

                                            @if ($city_head != '')

                                                @foreach ($city_head as $city_head_data)

                                                    <option data-tokens="{{ $city_head_data->name }}"

                                                        value="{{ $city_head_data->id }}" @if ($city_head_data->id == session('search_city_id')){{ 'selected' }}@endif>{{ $city_head_data->name }}

                                                    </option>

                                                @endforeach

                                            @endif

                                        </select>

                                    </div>

        

                                </div> --}}

                                {{-- <div class="col-md-3 col-lg-2 col-xl-3">

                                    <div class="text-center text-xl-start">

                                        <button class="ud-btn btn-thm w-100 bdrs60 mgtop20" type="button"

                                            onclick="search_banner_header()" style="

                                            padding: 0;

                                        ">Search</button>

                                    </div>

                                </div> --}}

                            </div>

                        </div>



                        {{-- <p class="form-error-text" id="search_auto_header_error" style="color: red; margin-top: 10px;">

                        </p>

                         <ul class="list_header"></ul> --}}

                    </div>

                @endif

                {{-- Mobile Search End --}}





            </div>

            <!-- /.mobile-menu -->

            <nav id="menu" class="">

                <ul>



                    @php

                        $staticServiceIds = [45, 30, 44, 34, 48, 47];

                    @endphp



                    @foreach ($staticServiceIds as $staticServiceId)

                        @php

                            $service = DB::table('services')->where('id', $staticServiceId)->first();

                            $subservices = DB::table('subservices')

                                ->where('serviceid', $staticServiceId)

                                ->where('is_active', 0)

                                ->orderBy('set_order')

                                ->get();

                        @endphp



                        @if ($service)
                            <li>

                                <span>{{ $service->servicename }}</span>

                                @if ($subservices->isNotEmpty())
                                    <ul>

                                        @foreach ($subservices as $sub)
                                            <li>

                                                <a class="dropdown-item"
                                                    href="{{ route('front.package_lists', ['city' => session('search_city_name'), 'page_url' => $sub->page_url]) }}">

                                                    {{ $sub->subservicename }}

                                                </a>

                                            </li>
                                        @endforeach

                                    </ul>
                                @endif

                            </li>
                        @endif

                    @endforeach





                    <li><a class="list-item" href="{{ url('/become-a-vendor') }}"><span>Become a Vendor</a></li>

                    {{-- <li><a class="list-item" href="{{ url('/cart') }}"><span>Cart</span></a></li> --}}

                    <li>

                        <span>My Account</span>

                        <ul>

                            <li>

                                <a href="{{ route('front.myaccount') }}"
                                    class="{{ Route::is('front.myaccount') ? 'active' : '' }}"> <i
                                        class="far fa-home"></i> &nbsp;&nbsp;Dashboard

                                </a>

                            </li>

                            <li>

                                <a href="{{ route('front.myleads') }}"
                                    class="{{ Route::is('front.myleads') || Route::is('front.mylead_detail') ? 'active' : '' }}">

                                    <i class="far fa-file-alt"></i> &nbsp;&nbsp;My Quotes

                                </a>

                            </li>

                            <li>

                                <a href="{{ route('front.myorder') }}"
                                    class="{{ Route::is('front.myorder') ? 'active' : '' }}">

                                    <i class="far fa-file-alt"></i> &nbsp;&nbsp;My Orders

                                </a>

                            </li>

                            <li>

                                <a href="{{ route('front.myprofile') }}"
                                    class="{{ Route::is('front.myprofile') ? 'active' : '' }}">

                                    <i class="far fa-user"></i> &nbsp;&nbsp;My Profile

                                </a>

                            </li>

                            <li>

                                <a href="{{ route('front.mywallet') }}"
                                    class="{{ Route::is('front.mywallet') ? 'active' : '' }}">

                                    <i class="far fa-wallet"></i> &nbsp;&nbsp;Wallet

                                </a>

                            </li>

                            <li>

                                <a href="{{ route('front.refer_earn') }}"
                                    class="{{ Route::is('front.refer_earn') ? 'active' : '' }}">

                                    <i class="fa-regular fa-gift"></i> &nbsp;&nbsp;Refer And Earn

                                </a>

                            </li>

                            <li>

                                <a href="{{ route('front.refral') }}"
                                    class="{{ Route::is('front.refral') ? 'active' : '' }}">

                                    <i class="fa-regular fa-gift"></i> &nbsp;&nbsp;Referral List

                                </a>

                            </li>

                            <li>

                                <a href="{{ route('user_signout') }}"
                                    class="{{ Route::is('front.user_signout') ? 'active' : '' }}">

                                    <i class="far fa-sign-out-alt"></i> &nbsp;&nbsp;Logout

                                </a>

                            </li>

                        </ul>



                    </li>

                    @php

                        $userData = Session::get('user');

                        // $userData = Session::get('user');

                    @endphp



                    @if ($userData == '')
                        {{-- <li><a class="list-item" href="{{ route('Sign-Up.create') }}"><span>Log in</span></a></li> --}}

                        <li><span>Login</span>

                            <ul>

                                <!-- <li><a href="{{ route('Sign-in') }}">Customer Login</a></li> -->

                                <li> <a href="javascript:void(0)" data-bs-toggle="modal"
                                        data-bs-target="#otp_popup_Modal">Customer Login</a></li>



                                <li><a href="{{ url('/vendor/login') }}">Vendor Login</a></li>

                            </ul>

                        </li>
                    @else
                        <li><a class="list-item" href="{{ url('user_signout') }}"><span>Log out</span></a></li>
                    @endif

                </ul>

            </nav>





        </div>











        <div class="body_content">
