@include('front.includes.header')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
<style>
.currency_dhiram {
    display: inline-block;
        width: 18px;
    height: 18px;

    background-color: currentColor;

    -webkit-mask: url('{{ asset("public/site/icons/dirham.svg") }}') no-repeat center;
    mask: url('{{ asset("public/site/icons/dirham.svg") }}') no-repeat center;

    -webkit-mask-size: contain;
    mask-size: contain;
}
.main_price .currency_dhiram{
    width: 25px;
    height: 25px;
}
.frequency_summary_strong{
        display: flex;
    align-items: center;
    gap: 2px;
}
#how_many_rooms_painted_slider_spatie .splide__arrow--prev{
	left: 0em;
}
#how_many_rooms_painted_slider_spatie .splide__arrow--next{
	right: 0em;
}

#how_many_rooms_painted_slider_spatie .splide__arrow{
	
	bottom: -40% !important;
	background: inherit;
	top: inherit;
}


#how_many_walls_painted_slider_spatie .splide__arrow--prev{
	left: 0em;
}
#how_many_walls_painted_slider_spatie .splide__arrow--next{
	right: 0em;
}

#how_many_walls_painted_slider_spatie .splide__arrow{
	
	bottom: -40% !important;
	background: inherit;
	top: inherit;
}

.modal-content {border-radius: 1.3rem;}
.splide__slide .items {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%; /* ensures uniform height if needed */
    text-align: center;
    white-space: nowrap; /* or wrap if label too long */
    /* padding: 8px; */
    border-radius: 8px;
    background-color: #fff;
    }
.splide__slide label {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .splide__slide {
        /* margin-right: 0!important; */
        width: auto !important;
    }
     .wallet_apply{
        border: none;
        background-color: inherit;
        color: #0040E6;
    }
    .wallet_cancel{
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
  .booking-summary{
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
  .modal-dialog{
    max-width: 60%;
    height: auto !important;
    max-height:70% !important;
  }

  .mobile-next{
    top: 20px !important;
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

.time_replace_ab{
    
    margin-top: 2%;
}
.time_replace_ab .surcharge-badge-timeslot{
    position: relative;
    margin-top: 4%;
}
  /* Show the button on mobile screens (less than 768px wide) */
  @media only screen and (max-width: 768px) {
	  
	  #how_many_rooms_painted_slider_spatie .splide__arrow {
		 
		  top: inherit !important;
	  }
	  #how_many_rooms_painted_slider_spatie .splide__arrow--prev {
			left: 1em;
		}
		#how_many_rooms_painted_slider_spatie .splide__arrow--next {
			right: 1em;
		}
		
		#how_many_walls_painted_slider_spatie .splide__arrow {
		 
		  top: inherit !important;
	  }
	  #how_many_walls_painted_slider_spatie .splide__arrow--prev {
			left: 1em;
		}
		#how_many_walls_painted_slider_spatie .splide__arrow--next {
			right: 1em;
		}
	  
    .hour_input .items{
        margin-left: 30px;
    }
    #modal-digi{
        max-width: 100% !important;
    }
   .sticky-button {
      display: block !important;
    }
    .mobile-hide{
        display: none !important;
    }
    #summary_div_left{
        display: none !important;
    }
    #summary_div_left_mobile {
        display: none;
        position: fixed;
        bottom: -100%; /* Initially hide the div outside the viewport */
        right: 0;
        width: 100%;
        transition: all 0.3s ease-in-out; /* Smooth transition effect */
        z-index: 99999; /* Make sure it stays on top */
    }
    .book-now-web{
        display:none !important;
    }
    #learn_more{
        font-weight: 50 !important;
    }
    #mobile-table{
        width:100% !important;
    }
    #nextBtn12{
        background-color : #0040E6 !important;
        border:none !important;
    }

    #summary_div_left_mobile.open {
        display: block !important;
        bottom: 0; /* Slide up into view */
        background: #fff;
        bottom: 81px;
        /* padding-top: 121px; */
        padding:0 0 68px !important;
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


    
    .splide__arrow{
        background: none !important;
        top: 120% !important;
    }
    .splide__arrow--prev{
        content: '\f104'; /* FontAwesome left arrow */
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        margin-left: -4% !important;
        top: 80px !important;
    }

    .splide__arrow--next{
        content: '\f105'; /* FontAwesome right arrow */
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        margin-right: -4% !important;    
        top: 80px !important;
    }
    .splide__arrow svg {
        fill: #000;
        height: 15px;
        width: 15px;
    }
    .payment-center{
        display: block !important;
        margin: 0 auto;
        text-align: center;
    }
    .img-center{
        text-align: center;
    }
    
}
  .time-slot-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* 2 columns */
        gap: 15px; /* spacing between items */
    }


table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 50%;
        }

        td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        }

  
    /* Style the labels to look like buttons */
    .radio-group label {
        display: inline-block;
        padding: 7px 21px;
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


    .radio-checked input[type="radio"] + label {
        color: #000;
        /* outline: grey; */
    }
    /* Change style when radio button is checked */
    .radio-checked input[type="radio"]:checked + label {
        background-color: #0040E6;
        color: #fff;
    }
    .radio-group input[type="radio"]:checked + label {
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
    .checkbox-group input[type="checkbox"]:checked + label {
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

    .calendar-input {
        width: 100%;
        text-align: center;
    }
    .calendar-container {
        display: flex;
        align-items: center;
        /* justify-content: center; */
        /* margin-top: 20px; */
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
    .calendar-day-label, .calendar-date-label {
        display: block;
    }
    .surcharge-badge {
        color: red;
    }
    .surcharge-badge-timeslot{
        color: red;
        /* padding-top: 20px; */
/*        display: inline-block;*/
    }

    .surcharge-badge-timeslot span{
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
        top: -30%;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2px;
    }
    .surcharge-badge-timeslot span .currency_dhiram{
        margin: 0;
        color: #000;
    }
    .surcharge-badge-dayslot{
        color: red;
        width: 30%;
        display: inline-block;
    }
    .surcharge-badge-dayslot span{
        position: absolute;
        top: -100px;
        right: 50px;
        background: #ffda40;
        padding: 2px 3px;
        color: #000;
        white-space: nowrap;
        font-size: 13px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;

    }
    .button_weekly label{
        width: 83% !important;
        padding: 0 20px;
        padding-top: 10px;

    @media (max-width: 768px) {
    width: 100% !important;
   
    
    }
    }
    .button_weekly ul li{
        list-style-type: "- " !important;
        margin-left: -20px;
    }
    .hour_input label{
       border-radius: 50px;
       /* padding: 7px 20% !important; */
    }
    .hour_input span{
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
    .material label{
        border-radius: 50px;
        padding: 12px 24px;
    }
    .fw500 {
    font-weight: 1000;
    font-size: 16px;
    }
    .cleaning_weekly_new{
        color:#222222;
        float: right;
        background-color:#ffda40;
        padding: 0 4px 0 4px;
        border-radius: 7px;
        font-size:13px;
    }
    .dettol{
        display: contents;"
    }
    .mid_col{
        /* box-shadow: 0 6px 15px #00000029; */
        padding: 13px 13px 13px 13px;
        border-radius: 10px;
    }
    .last_col{
        box-shadow: 0px 6px 15px #00000029;
        /* box-shadow: 0 0 10px 2px rgba(0,0,0,0.1); */
        padding: 13px 13px 13px 13px;
        border-radius: 10px;
    }
    .last_col h3{
        text-align: center;
    }
    .underline{
        border: 1px solid #707070;
        border-style: dashed;
        color: #707070;
        display: inline-block;
        width: 100%;
        margin: 10px 0
    }
    .step-underline{
        border: 1px solid #707070;
        color: #707070;
        width: 206%;
        display: inline-block;
    }
    .font-weight-bold-summary{
        font-weight: 1000;
    }
    .payment-type{
        display:inline;
    }
    /* .payment-li{
        width: 100% !important;
    } */
    .sm-summary{
        /* max-width: 50%; */
         text-align: right;
         color:#0040E6;
    }
    .step-p {
       margin: 0 0 -8px 2.2%;
        font-size: 18px;
    }
    .step-title {
        margin-left: 0;
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .custome-black{
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
    .custome-black:hover:before{
        background-color: #000 !important;
    }
    .left-summary-total{
        background-color :#0040E6;
        color: #fff;
        padding: 13px 0px;
        border-radius: 11px;
    }
    .left-summary-without-cross-total{
        background-color :#0040E6;
        color: #fff;
        /* padding: 16px 0px 7px 67px; */
        padding: 13px 0px;
        border-radius: 11px;
    }
    .main-title{
        margin-bottom: 25px;
    }
    .firstBlur {
  /* margin:50px 20px 0; */
  padding:20px;
  position:relative;
}

/* === CSS FILTER EFFECTS === */
.firstBlur.modalBlur > *:not(.modal) {
  -webkit-filter: blur(7px) !important;
}
.firstBlur.modalDesaturate > *:not(.modal) {
  -webkit-filter: saturate(0%) !important;
}
/* === SOFTEN THE MODAL BACKDROP SO THE EFFECT IS MORE VISIBLE === */
.modal-backdrop {
  opacity: 0.65; 
  filter: alpha(opacity=65) !important;
}
.selected-color-label-display{display: none !important;}
.moving-in-out-painting-show{display: none !important;}
.additional-charges-display{display: none !important;}
.selected-ceilings-label-display{display: none !important;}
.summary-movein-out-service-show{display: none !important;}
.summary-paint-rooms-hide{display: none !important;}
.summary-paint-walls-hide{display: none !important;}
.mobile-total-price-btn{display: none !important;}

.qoute-summary-rooms{display: none !important;}
.qoute-summary-walls{display: none !important;}


/* VCSS */
.first-edit{position: relative;}
.first-edit-anch{position: absolute;top: auto;text-decoration: underline;left: 93%;bottom: 15%;}


.spinner_button{
    background-color: #000 !important;
    border: 2px solid #000 !important;
    color: #ffffff;
    border-radius: 50px;
    padding: 7px 40px 7px 40px;
}


.promo_dicount_replace_new_div {display: none !important;}
.timing_charge_replace_div {display: none !important;}
.cod_charge_replace_div {display: none !important;}

  textarea::placeholder {
    font-size: 12px; 
    }

    #service-step-title {
        position: fixed;
        top: 92px !important;
        background: #fafafa;
        z-index: 1;
        padding: 10px 0;
        width: 100%;
        /* left: 0; */
        padding-left: 0;

        transition: all 0.4s ease;
        opacity: 1;
        transform: translateY(0);
    }
	
	#summary_div_left_package{background-color: #fff;border:1px solid #ccc;box-shadow: inherit;}

    #service-step-title .step-p {
        transition: all 0.4s ease;
        opacity: 1;
        transform: translateY(0);
        overflow: hidden;
    }
	
	.body_content{background-color: #fafafa;}
	
	header.nav-homepage-style{
		background-color: #fff;
	}
	

    #service-step-title .step-p.hide {
        opacity: 0;
        max-height: 0;
        transform: translateY(-10px);
        visibility: hidden;
        /* Removed: display: none; */
    }
    #category_form_new {
            margin-top:80px;
			border: 1px solid #ccc;
			background-color: #fff;
        }
@media (max-width: 767px) {
    textarea::placeholder {
    font-size: 12px !important; 
    }
    .mid_col{
        box-shadow: unset !important;
    }
    #service-step-title {
        position: fixed;
        top: 80px !important;
        background: #fafafa;
        z-index: 9999;
        padding: 10px 0;
        width: 100%;
        left: 0;
        padding-left: 10px;
        transition: all 0.4s ease;
        opacity: 1;
        transform: translateY(0);
    }

    #service-step-title .step-p {
        transition: all 0.4s ease;
        opacity: 1;
        transform: translateY(0);
        overflow: hidden;
    }

    #service-step-title .step-p.hide {
        opacity: 0;
        max-height: 0;
        transform: translateY(-10px);
        visibility: hidden;
        /* Removed: display: none; */
    }
    #category_form_new {
        margin-top:60px;
    }
    .step-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 20px;
    }

    .back-icon i {
        font-size: 18px;
        cursor: pointer;
    }
    .step-p {
        margin: 0 0 -8px 9% !important;
        font-size:18px !important;
    }
     .subservice-name{
        font-size: 20px !important;
    }
    .modal-header-mobile{
        padding: 10px 10px 2px 10px !important;
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
}

.ceilings-price{
   font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 2px;
}

.surcharge-badge-dayslot .currency_dhiram{
        margin: 0;
    color: #000;
    width: 14px;
    height: 14px;
}


@media (max-width: 767.98px) {
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

  .modal-content {
    border-radius: 20px 20px 0 0;
    height: 100%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }
  .details-modal-content{
    border-radius: 20px !important;
    height: 100%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }
  
.login-form-modal .user-modal-dialog{
        max-width: 60%;
        height: auto !important;
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

  .modal-dialog-centered{
    min-height:0 !important;
  }
 .modal-mobile{
    padding: 10px 16px !important;
  }
}
.service-fee-custome-modal{
    max-width: 450px !important; 
}
.charge-desc-popup{
    border-radius: 13px !important;
}
.modal{
    z-index:99999 !important;
}
#summary_div_left {
    padding-top: 81px;
	
}
.container {
    max-width: 960px !important;
}
 .back-icon i {
    font-size: 25px;
    cursor: pointer;
}
.modal-title {
    font-size: 20px;
}
.booknow-otp-input{
    padding-left: 0px !important;   
}

.book-email-otp-input{
    padding-left: 0px !important;   
}

.main_price {
font-size: 28px;
    /* display: inline-block; */
    width: 100%;
    text-align: center;
    display: flex;
    align-items: center;
    gap: 2px;
    justify-content: center;
}
.main_price .dhiram {
       width: 25px;
}

.dhiram {
    width: 15px;
}
.sm-summary {
    /* max-width: 65%; */
    text-align: right;
    color: #0040E6;
    display: flex;
    align-items: center;
    gap: 2px;
}

.cod_fee_p{
        display: flex;
    align-items: center;
    gap: 2px;
}
    </style>

<section class="our-register">
    <div class="container">
        <div id="service-step-title" class="main-title">
            <p class="step-p">Step 1 of 4</p>
                    <h2 class="title step-title">
                        <span class="back-icon"></span> 
                       Booking Summary</h2>
        </div>

        <div class="row wrap">
        
        <div class="col-lg-7">
                <form id="category_form_new" action="{{ route('book_now_order') }}" method="POST" class="mid_col" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="apply_button" id="apply_button" value="0">
                    <input type="hidden" name="cancel_button" id="cancel_button" value="1">

                    <input type="hidden" name="service_charge" id="service_charge" value="78"/>
                    <input type="hidden" name="is_book_or_quote" id="is_book_or_quote" value=""/>

                    <input type="hidden" name="cod_charge_new" id="cod_charge_new" value="0"/>
                    <input type="hidden" name="service_fee" id="service_fee" value="9"/>

                    <input type="hidden" name="type_of_painting" id="type_of_painting" value="">
                    <input type="hidden" name="selected_type_home" id="selected_type_home" value="Apartment">
                    <input type="hidden" name="selected_size_home" id="selected_size_home" value="Studio">

                    <input type="hidden" name="additional_charge_price" id="additional_charge_price" value="0">

                    <input type="hidden" name="size_of_home_price" id="size_of_home_price" value="0">
                    <input type="hidden" name="color_you_want_painted_price" id="color_you_want_painted_price" value="0">
                    <input type="hidden" name="color_your_walls_now_price" id="color_your_walls_now_price" value="0">

                    <input type="hidden" name="selected_you_want_color_name" id="selected_you_want_color_name" value="white">
                    <input type="hidden" name="selected_your_walls_now_name" id="selected_your_walls_now_name" value="white">

                    <input type="hidden" name="selected_home_furnished" id="selected_home_furnished" value="No">
                    <input type="hidden" name="selected_home_furnished_price" id="selected_home_furnished_price" value="0">

                    <input type="hidden" name="hidden_subtotal_price" id="hidden_subtotal_price" value="0">
                    <input type="hidden" name="hidden_discount_type" id="hidden_discount_type" value="0">
                    
                    <input type="hidden" name="hidden_discount_price" id="hidden_discount_price" value="0">
                    <input type="hidden" name="hidden_vat_charge_price" id="hidden_vat_charge_price" value="0">
                    <input type="hidden" name="total_to_pay_charge_price" id="total_to_pay_charge_price" value="0">

                    <input type="hidden" name="selected_ceiling_price" id="selected_ceiling_price" value="0">
                    <input type="hidden" name="timing_charge" id="timing_charge" value="0">
                    <input type="hidden" name="weekly_off_charge" id="weekly_off_charge" value="0">

                    <input type="hidden" name="no_of_ceilings" id="no_of_ceilings" value="">
                   
                    <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
                    <input type="hidden" name="subservice_id" id="subservice_id" value="{{ $subservice_id }}">

                    <input type="hidden" id="payment_type_new" name="payment_type" value="ONLINE" >
                <div class="tab1">

                    @php
                            $system_data = DB::table('system')->where('id',1)->first();
                            //echo"<pre>";print_r($system_data);echo"</pre>";exit;
                            if($system_data->weekly_percentage > 0 && $system_data->weekly_percentage != ''){
                                $weekly_discout = " ".$system_data->weekly_percentage."% off Per Visit ";
                                $weekly_discout_1 =$system_data->weekly_percentage;
                            }else{
                                $weekly_discout ="";
                                $weekly_discout_1 = "";
                            }
                            if($system_data->multiple_time_week > 0 && $system_data->multiple_time_week != ''){
                                $multiple_time_week_discout = " ".$system_data->multiple_time_week."% off Per Visit ";
                                $multiple_time_week_discout_1 =$system_data->multiple_time_week;
                            }else{
                                $multiple_time_week_discout ="";
                                $multiple_time_week_discout_1 = "";
                            }
                    @endphp


                    @if($subservice_id == 47)
                    {{-- <div class="image">
                        <img src="https://servicemarket.imgix.net/dist/css/img/service/cleaning-maid-services/about-cleaning.jpg" width="100%">
                    </div> --}}

                    <h5 class="font-weight-bold h3 subservice-name">About our {{ $subservice_name }} </h5>
                    <p class="card-text"><span>Complete the booking form, and we’ll match you with a skilled painter to give your home a fresh, vibrant look. Discover more about what our Painting Service includes.</span>
                    @if($subservice_id == 47)
                        <a href="javascript:void(0)" data-bs-toggle="modal" id="read_more" data-bs-target="#exampleModalLong_{{$subservice_id}}" style="text-decoration: underline;">
                            Read more
                        </a>
                    @endif
                    </p>
                    
                    <div class="form-group mb-3">
                        <label class=" fw500 dark-color" for="country">Please select the type of painting</label>
                        <select class="form-control searches_drop"
                            id="formfield_value_test"
                            name="formfield_value"
                            onchange="paintingServices(this.value)">
                            <option value="">Select the type of painting
                            </option>

                                @php
                                $paintingService = array(
                                                    "Move in / Move Out Painting",
                                                    "Custom Home Painting",
                                                    "Paint individual rooms",
                                                    "Paint individual walls",
                                                    "Office Painting",
                                                    "Exterior Painting"
                                                    );
                                @endphp

                                @foreach ($paintingService as $painting)
                                <option value="{{ $painting}}">
                                {{ $painting }}
                                </option>
                                @endforeach
                        </select>
                        <p style="color:red;" id="painting-select-error"></p>
                    </div>
                    <span id="movingOptionTab" style="display: none;">
                    <div class="form-group">
                        <label class=" fw500 dark-color"
                        for="country">What type of home do you live in?</label><br>
						
						<div id="type_of_home_slider_spatie" class="splide radio-group ">
                        <div class="splide__track">
                            <ul class="splide__list">

                            <li class="splide__slide text-center" >
                               <div class="hour_input">
                                <input type="radio" id="type-of-home-1" name="type_of_home" value="2" checked onclick="type_of_homeFun(1);">
                                <label for="type-of-home-1">Apartment</label>
                                <p style="font-size: 9px; margin-left:14px;"></p>
                            </div>
                            </li>

                            <li class="splide__slide text-center">
                                <div class="hour_input">
                                <input type="radio" id="type-of-home-2" name="type_of_home" value="3" onclick="type_of_homeFun(2);">
                                <label for="type-of-home-2">Villa</label>
                                <p style="font-size: 9px; margin-left:15px;"></p>
                            </div>
                            </li>


                            <!-- Add more slides as needed -->

                            </ul>
                        </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class=" fw500 dark-color"
                        for="country">What is the size of your home?</label><br>
                        @if($painting_price_data !="" && !empty($painting_price_data) && count($painting_price_data) > 0)
							
						<div id="size-of-home-slider-apartment" class="splide radio-group size-of-home-tab1">
                        <div class="splide__track">
                            <ul class="splide__list">
							
							@php
                                $count = 0;
                            @endphp
                            @foreach($painting_price_data as $apartmentPrice)
                            @php
                                if($count == 0){
                                    $isSelected = "checked";
                                }else{
                                    $isSelected = "";
                                }
                            @endphp

                            <li class="splide__slide text-center" >
                                 <div class="hour_input items">
									<input type="radio" id="size-of-home-studio-{{ $count }}" name="size_of_home_1" value="{{ $apartmentPrice->id }}" {{ $isSelected }} onclick="sizeOfHome();">
									<label for="size-of-home-studio-{{ $count }}">{{ $apartmentPrice->size_of_home }}</label>
									<p style="font-size: 9px; margin-left:14px;"></p>
								</div>
                            </li>
							@php
                                $count++;
                            @endphp
                            @endforeach
                            

                            <!-- Add more slides as needed -->

                            </ul>
                        </div>
                        </div>			
						
                        @endif
                        @if($villaPainting_price_data !="" && !empty($villaPainting_price_data) && count($villaPainting_price_data) > 0)
                        
                        <div id="size-of-home-slider-villa" class="splide radio-group size-of-home-tab2" style="display: none;">
                        <div class="splide__track">
                            <ul class="splide__list">
                            @php
                                $villa = 0;
                            @endphp
                            @foreach($villaPainting_price_data as $villaPrice)
                            @php
                                if($villa == 0){
                                    $isSelected = "checked";
                                }else{
                                    $isSelected = "";
                                }
                            @endphp
                            <li class="splide__slide text-center" >
                            <div class="hour_input items">
                                <input type="radio" id="size-of-home2-{{ $villa }}" name="size_of_home_2" value="{{ $villaPrice->id }}" {{ $isSelected }} onclick="sizeOfHome();">
                                <label for="size-of-home2-{{ $villa }}">{{ $villaPrice->size_of_home }}</label>
                                <p style="font-size: 9px; margin-left:14px;"></p>
                            </div>
                            </li>
                            @php
                                $villa++;
                            @endphp
                            @endforeach
                        </ul>
                        </div>
                        </div>
                        @endif

                        
                    </div>
                    

                    <div class="form-group ">
                        <label class=" fw500 dark-color"
                        for="country">What color do you want your walls painted?</label><br>
                       
                        <div id="color_want_slider_spatie" class="splide radio-group">
                        <div class="splide__track">
                            <ul class="splide__list">

                            <li class="splide__slide text-center" >   
                            <div class="hour_input">
                                <input type="radio" id="wallas-painted-1" name="color_do_you_want_walls_painted" value="white" onclick="newColor('1');">
                                <label for="wallas-painted-1">White</label>
                            </div>
                            </li>
                            
                            <li class="splide__slide text-center" >   
                            <div class="hour_input">
                                <input type="radio" id="wallas-painted-2" name="color_do_you_want_walls_painted" value="off-white" onclick="newColor('1');">
                                <label for="wallas-painted-2">Off-White</label>
                            </div>
                            </li>
                        </ul>
                           
                        </div>
                        </div>
                        <p style="color:#ff0000;" class="new-color-error"></p>
                    </div>

                    <div class="form-group mb-3">
                        <label class=" fw500 dark-color"
                        for="country">What color are your walls now?</label><br>
                          
                        <div id="your_walls_now_slider_spatie" class="splide radio-group">
                        <div class="splide__track">
                            <ul class="splide__list">

                            <li class="splide__slide text-center" >
                            <div class="hour_input items">
                                <input type="radio" id="color-are-you-walls-now-1" name="what_color_your_walls_now" value="white" onclick="newColor('2');">
                                <label for="color-are-you-walls-now-1">White</label>
                            </div>
                            </li>
                    
                            <li class="splide__slide text-center">
                            <div class="hour_input items">
                                <input type="radio" id="color-are-you-walls-now-2" name="what_color_your_walls_now" value="off-white" onclick="newColor('2');">
                                <label for="color-are-you-walls-now-2">Off-White</label>
                            </div>
                            </li>

                             <li class="splide__slide text-center" >
                            <div class="hour_input items">
                                <input type="radio" id="color-are-you-walls-now-3" name="what_color_your_walls_now" value="color" onclick="newColor('2');">
                                <label for="color-are-you-walls-now-3">Color</label>
                            </div>
                            </li>

                              <li class="splide__slide text-center" >
                            <div class="hour_input items">
                                <input type="radio" id="color-are-you-walls-now-4" name="what_color_your_walls_now" value="mixed" onclick="newColor('2');">
                                <label for="color-are-you-walls-now-4">Mixed</label>
                            </div>
                            </li>
                            <ul>
                        </div>
                        </div>
                        <p style="color:#ff0000;" class="old-color-error"></p>
                    </div>
                    
                    {{-- <div class="row"> --}}

                        <div class="form-group mt30">
                            <label class=" fw500 dark-color"
                            for="country">Is your home furnished?</label><br>
                        
                        <div id="home_furnished_slider_spatie" class="splide radio-group">
                        <div class="splide__track">
                            <ul class="splide__list">

                            <li class="splide__slide text-center" >   
                                <div class="hour_input">
                                    <input type="radio" id="is-your-home-furnished-1" name="isYourHomeFurnshed" value="Yes" onclick="homeFurnished();">
                                    <label for="is-your-home-furnished-1">Yes</label>
                                    <p style="font-size: 9px; margin-left:14px;"></p>
                                </div>
                            </li>
                        
                            <li class="splide__slide text-center" >
                                <div class="hour_input">
                                    <input type="radio" id="is-your-home-furnished-2" name="isYourHomeFurnshed" value="No" checked onclick="homeFurnished();">
                                    <label for="is-your-home-furnished-2">No</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                            </li>

                            </ul>
                            </div>
                            </div>
                        </div>
    
                        <div class="form-group">
                            <label class=" fw500 dark-color"
                            for="country">Do you need ceilings painted?</label><br>
                            
                               
                        <div id="ceilings_painted_slider_spatie" class="splide radio-group">
                        <div class="splide__track">
                            <ul class="splide__list">

                            <li class="splide__slide text-center" >   
                                <div class="hour_input">
                                    <input type="radio" id="do-you-need-ceiling-painted-1" name="do_you_need_ceiling_painted" value="1" onclick="isCeilingPainted();">
                                    <label for="do-you-need-ceiling-painted-1">Yes</label>
                                    <p style="font-size: 9px; margin-left:14px;"></p>
                                </div>
                            </li>

                             <li class="splide__slide text-center" >   
                                <div class="hour_input">
                                    <input type="radio" id="do-you-need-ceiling-painted-2" name="do_you_need_ceiling_painted" value="0" onclick="isCeilingPainted();" checked>
                                    <label for="do-you-need-ceiling-painted-2">No</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                             </li>

                            </ul>
                               
                            </div>
                        </div>
                        
                    </div>
                    {{-- </div> --}}
                   

                    <div class="form-group mb-3" id="ceilngs-painting-costs" style="display: none;">
                        <label class=" fw500 dark-color"
                        for="country">Do you need ceilings painted?</label><br/><span class=" ceilings-price">Ceilings painting costs <span class="currency_dhiram"></span> 125 per ceiling</span><br>
                   
                        <div id="ceilings_painted_per_ceil_slider_spatie" class="splide radio-group">
                        <div class="splide__track">
                            <ul class="splide__list"> 
                              
                            <li class="splide__slide text-center" >     
                            <div class="hour_input items">
                                <input type="radio" id="per-ceiling-costs-1" name="per_ceiling_costs" value="1" checked onclick="isCeilingPainted();">
                                <label for="per-ceiling-costs-1"style="padding: 10px 28px !important;">1</label>
                                <p style="font-size: 9px; margin-left:14px;"></p>
                            </div>
                            </li>
                    
                            <li class="splide__slide text-center" >  
                            <div class="hour_input items">
                                <input type="radio" id="per-ceiling-costs-2" name="per_ceiling_costs" value="2" onclick="isCeilingPainted();">
                                <label for="per-ceiling-costs-2" style="padding: 10px 28px !important;">2</label>
                                <p style="font-size: 9px; margin-left:15px;"></p>
                            </div>
                            </li>

                            <li class="splide__slide text-center" >  
                            <div class="hour_input items">
                                <input type="radio" id="per-ceiling-costs-3" name="per_ceiling_costs" value="3" onclick="isCeilingPainted();">
                                <label for="per-ceiling-costs-3" style="padding: 10px 28px !important;">3</label>
                                <p style="font-size: 9px; margin-left:15px;"></p>
                            </div>
                            </li>

                            <li class="splide__slide text-center" >  
                            <div class="hour_input items">
                                <input type="radio" id="per-ceiling-costs-4" name="per_ceiling_costs" value="4" onclick="isCeilingPainted();">
                                <label for="per-ceiling-costs-4" style="padding: 10px 28px !important;">4</label>
                                <p style="font-size: 9px; margin-left:15px;"></p>
                            </div>
                            </li>

                            <li class="splide__slide text-center" >  
                            <div class="hour_input items">
                                <input type="radio" id="per-ceiling-costs-5" name="per_ceiling_costs" value="5" onclick="isCeilingPainted();">
                                <label for="per-ceiling-costs-5" style="padding: 10px 28px !important;">5</label>
                                <p style="font-size: 9px; margin-left:15px;"></p>
                            </div>
                            </li>

                            </ul>
                        </div>
                    </div>
                    </div>

                    </span>
                    {{-- <span id="movingOptionTab1" style="display: none;">
                        <div class="form-group mb-3 col-md-12 col-sm-12">
                            <label class=" fw500 dark-color"
                            for="country">Where do you need the service?</label><br>
                            <div class="need_cleaner">
                                    <input type="text" id="type-of-home-1" class="form-control" name="type_of_home" value="" placeholder="Enter a location">
                                    <p style="font-size: 9px; margin-left:14px;"></p>
                            </div>
                        </div>
                    </span> --}}

                    <span id="movingOptionTab2" style="display: none;">
                        <div class="form-group mb-3 col-md-12 col-sm-12">
                            <label class=" fw500 dark-color"
                            for="country">How many rooms do you need painted?</label>


                        <div id="how_many_rooms_painted_slider_spatie" class="splide radio-group">
                        <div class="splide__track">
                            <ul class="splide__list"> 
                               
                                <li class="splide__slide text-center" >   
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-room-painted-1" name="how_many_rooms_painted" value="1" checked onclick="no_of_rooms_paint('1');">
                                    <label for="how-many-room-painted-1" class="paint-individual-label">1</label>
                                    <p style="font-size: 9px; margin-left:14px;"></p>
                                </div>
                                </li>
                                <li class="splide__slide text-center" >   
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-room-painted-2" name="how_many_rooms_painted" value="2" onclick="no_of_rooms_paint('2');">
                                    <label for="how-many-room-painted-2">2</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>
                                <li class="splide__slide text-center" >   
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-room-painted-3" name="how_many_rooms_painted" value="3" onclick="no_of_rooms_paint('3');">
                                    <label for="how-many-room-painted-3">3</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>
                                <li class="splide__slide text-center" >   
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-room-painted-4" name="how_many_rooms_painted" value="4" onclick="no_of_rooms_paint('4');">
                                    <label for="how-many-room-painted-4">4</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>
                                <li class="splide__slide text-center" >   
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-room-painted-5" name="how_many_rooms_painted" value="5" onclick="no_of_rooms_paint('5');">
                                    <label for="how-many-room-painted-5">5</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>
                                <li class="splide__slide text-center" >
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-room-painted-6" name="how_many_rooms_painted" value="6" onclick="no_of_rooms_paint('6');">
                                    <label for="how-many-room-painted-6">6</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>
                                <li class="splide__slide text-center" >   
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-room-painted-7" name="how_many_rooms_painted" value="7" onclick="no_of_rooms_paint('7');">
                                    <label for="how-many-room-painted-7">7</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>
                                <li class="splide__slide text-center" >   
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-room-painted-8" name="how_many_rooms_painted" value="8" onclick="no_of_rooms_paint('8');">
                                    <label for="how-many-room-painted-8">8</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>
                                <li class="splide__slide text-center" >   
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-room-painted-9" name="how_many_rooms_painted" value="9" onclick="no_of_rooms_paint('9');">
                                    <label for="how-many-room-painted-9">9</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>
                                <li class="splide__slide text-center" >   
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-room-painted-10" name="how_many_rooms_painted" value="10" onclick="no_of_rooms_paint('10');">
                                    <label for="how-many-room-painted-10">10</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>
                            </ul>

                            </div>
                        </div>
                        </div>
                    </span>



                    {{-- Lorem --}}
                    <span id="movingOptionTab4" style="display: none;">
                        <div class="form-group mb-3 col-md-12 col-sm-12">
                            <label class=" fw500 dark-color"
                            for="country">How many walls do you need painted?</label>
                            
                        <div id="how_many_walls_painted_slider_spatie" class="splide radio-group">
                        <div class="splide__track">
                            <ul class="splide__list"> 
                               
                                <li class="splide__slide text-center" >
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-wall-painted-1" name="how_many_walls_painted" value="1" checked onclick="no_of_walls_paint('1');">
                                    <label for="how-many-wall-painted-1" class="paint-individual-label">1</label>
                                    <p style="font-size: 9px; margin-left:14px;"></p>
                                </div>
                                </li>
                        
                                <li class="splide__slide text-center" >
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-wall-painted-2" name="how_many_walls_painted" value="2" onclick="no_of_walls_paint('2');">
                                    <label for="how-many-wall-painted-2">2</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>

                                <li class="splide__slide text-center" >
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-wall-painted-3" name="how_many_walls_painted" value="3" onclick="no_of_walls_paint('3');">
                                    <label for="how-many-wall-painted-3">3</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>

                                <li class="splide__slide text-center" >
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-wall-painted-4" name="how_many_walls_painted" value="4" onclick="no_of_walls_paint('4');">
                                    <label for="how-many-wall-painted-4">4</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>

                                <li class="splide__slide text-center" >
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-wall-painted-5" name="how_many_walls_painted" value="5" onclick="no_of_walls_paint('5');">
                                    <label for="how-many-wall-painted-5">5</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>

                                <li class="splide__slide text-center" >
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-wall-painted-6" name="how_many_walls_painted" value="6" onclick="no_of_walls_paint('6');">
                                    <label for="how-many-wall-painted-6">6</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>

                                <li class="splide__slide text-center" >
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-wall-painted-7" name="how_many_walls_painted" value="7" onclick="no_of_walls_paint('7');">
                                    <label for="how-many-wall-painted-7">7</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>

                                <li class="splide__slide text-center" >
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-wall-painted-8" name="how_many_walls_painted" value="8" onclick="no_of_walls_paint('8');">
                                    <label for="how-many-wall-painted-8">8</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>

                                <li class="splide__slide text-center" >
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-wall-painted-9" name="how_many_walls_painted" value="9" onclick="no_of_walls_paint('9');">
                                    <label for="how-many-wall-painted-9">9</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>

                                <li class="splide__slide text-center" >
                                <div class="hour_input items">
                                    <input type="radio" id="how-many-wall-painted-10" name="how_many_walls_painted" value="10" onclick="no_of_walls_paint('10');">
                                    <label for="how-many-wall-painted-10">10</label>
                                    <p style="font-size: 9px; margin-left:15px;"></p>
                                </div>
                                </li>
                            </ul>
                            </div>
                            </div>
                        </div>
                    </span>

                   

                    <div class="form-group mb-3">
                        <label class=" fw500 dark-color " for="country">Please describe the painting service you need.</label>
                        <textarea name="describe_painting_service" id="describe_painting_service" placeholder="Please enter as much detail as possible, such as the color of paint, type of paint, and size of unit you need painted so that we can get accurate quotes for you"></textarea>

                        <p class="form-error-text" id="any_special_instruction_error" style="color: red; margin-top: 10px;">
                        </p>
                    </div>

                    @endif

                    @if($subservice_id == 89)

                        {{-- <div class="image">
                            <img src="https://servicemarket.com/_next/image?url=%2Fdist%2Fcss%2Fimg%2Fservice%2Fgardening-companies%2Fgardening-companies.jpg&w=1920&q=75" width="100%">
                        </div> --}}

                        <h5 class="font-weight-bold h3 mt-3">Get quotes for your {{ $subservice_name }} Services </h5>
                            <p class="card-text"><span>Complete the booking form, and we’ll match you with a skilled Cleaner to give your Wooden Floor a fresh, vibrant look. Discover more about what our Wooden Floor Polishing Service includes.</span><br/>
                        
                                <a href="javascript:void(0)" data-bs-toggle="modal" id="read_more" data-bs-target="#WoodenfloorModal_{{$subservice_id}}" style="text-decoration: underline;">
                                    Read more
                                </a>
                            </p>

              

                        <div class="form-group mb-3">
                            <label class="fw500 dark-color" for="country">Type of Property ?</label>
                            <select class="form-control searches_drop form-select"
                                id="property_type"
                                name="property_type">
                                    @php
                                    $Property_Type = array(
                                                        "Apartment",
                                                        "Villa",
                                                        "Office",
                                                        "Commercial Space",
                                                        );
                                    @endphp
                                <option value="">Select Service Type</option>
                                @foreach ($Property_Type as $data)
                                <option value="{{ $data }}">
                                    {{ $data }}
                                </option>
                                @endforeach
                            </select>
                            <p style="color:red;" id="property_type_error"></p>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw500 dark-color" for="country">Approximate Area of Wooden Flooring (sq. ft.)</label>
                            <select class="form-control searches_drop form-select"
                                id="area_of_floor"
                                name="area_of_floor">
                                    @php
                                    $Area_of_wooden_floor = array(
                                                        "Less than 200 sq. ft.",
                                                        "200 – 500 sq. ft.",
                                                        "500 – 1000 sq. ft.",
                                                        "More than 1000 sq. ft.",
                                                        "Not Sure",
                                                        );
                                    @endphp
                                <option value="">Select Approximate Area of Wooden Flooring</option>
                                @foreach ($Area_of_wooden_floor as $data)
                                <option value="{{ $data }}">
                                    {{ $data }}
                                </option>
                                @endforeach
                            </select>
                            <p style="color:red;" id="area_of_floor_error"></p>
                        </div>


                        <div class="form-group mb-3">
                            <label class="form-label fw500 dark-color" for="country">Current Condition of the Floor</label>
                            <select class="form-control searches_drop form-select"
                                id="condition_of_floor"
                                name="condition_of_floor">
                                    @php
                                    $condition_of_floor = array(
                                                        "Current Condition of the Floor",
                                                        "Slight wear / dullness",
                                                        "Deep scratches / stains",
                                                        "Water damage",
                                                        "Just maintenance polish",
                                                        "Not sure",
                                                        );
                                    @endphp
                                <option value="">Select Current Condition of the Floor</option>
                                @foreach ($condition_of_floor as $data)
                                <option value="{{ $data }}">
                                    {{ $data }}
                                </option>
                                @endforeach
                            </select>
                            <p style="color:red;" id="condition_of_floor_error"></p>
                        </div>


                        <div class="form-group mb-3">
                            <label class="form-label fw500 dark-color" for="country">Service Required</label>
                            <select class="form-control searches_drop form-select"
                                id="service_required"
                                name="service_required">
                                    @php
                                    $Service_required = array(
                                                        "Floor polishing only",
                                                        "Scratch/stain removal + polishing",
                                                        "Full restoration (sanding & finishing)",
                                                        "Need expert advice",
                                                        );
                                    @endphp
                                <option value="">Select Required Service</option>
                                @foreach ($Service_required as $data)
                                <option value="{{ $data }}">
                                    {{ $data }}
                                </option>
                                @endforeach
                            </select>
                            <p style="color:red;" id="service_required_error"></p>
                        </div>


                        <div class="form-group mb-3">
                            <label class="form-label fw500 dark-color" for="country">Would you like to schedule a site survey?</label>
                            <select class="form-control searches_drop form-select"
                                id="schedule_site_survey"
                                name="schedule_site_survey" onchange="wooden_floor_calculation();">
                                
                                <option value="">Select Site Survey Schedule</option>
                                <option value="yes">Yes, please schedule a free survey</option>
                                <option value="no">No, I’ll upload floor video below</option>

                            </select>
                            <p style="color:red;" id="schedule_site_survey_error"></p>
                        </div>

                        <div class="form-group mb-3 d-none" id="upload_video_div"> 
                            <label class="form-label fw500 dark-color" for="country">Upload Video of the Wooden Floor</label>
                           <input type="file" name="upload_video" id="upload_video" class="form-control" placeholder="Upload Video of the Wooden Floor" accept=".mp4, .mov, .avi, .wmv, .flv, .mkv">
                            <p style="color:red;" id="upload_video_error"></p>
                        </div>
                   

                   

                        <div class="form-group mb-3">
                            <label class="form-label fw500 dark-color " for="country">Additional Notes or Special Requests (Optional)</label>
                            <textarea name="describe_your_requirements" id="describe_your_requirements" placeholder="If you have any other requirements, feel free to describe them here in as much detail as you want. Or just leave us a message to call you if its easier to explain on the phone"></textarea>

                            <p class="form-error-text" id="describe_your_requirements_error" style="color: red; margin-top: 10px;">
                            </p>
                        </div>
                    @endif

                    @if($subservice_id == 29)
                        
                    <div class="image">
                        <img src="https://servicemarket.imgix.net/dist/css/img/service/deep-cleaning/deep-cleaning.jpg?auto=format&q=46" width="100%">
                    </div>

                    <h5 class="font-weight-bold h3">{{ $subservice_name }} </h5>
                    @php

                            //  echo '<pre>ddddddddddd';
                            // print_r(session('book_array_package_id'));
                            // echo '</pre>';

                        $book_array_package_id_session = session('book_array_package_id');

                        if($book_array_package_id_session != ''){
                            $book_array_package_id_session = $book_array_package_id_session;
                        }else{
                            $book_array_package_id_session = array();
                        }
                        $package_cat = DB::table('package_categories')
                                        ->where('service_id',$service_id)
                                        ->where('subservice_id',$subservice_id)
                                        ->get()->toArray();

                        //echo"<pre>";print_r($book_array_package_id_session);echo"</pre>";exit;
                    @endphp


                        <div class="form-group mb-3">
                            <div class="radio-group">
                                @if(!empty($package_cat))

                                    @foreach($package_cat as $package_cat_data)
                                        <input type="radio" id="{{ $package_cat_data->id }}" name="package_cat" value="{{ $package_cat_data->id }}" checked >
                                        <label for="{{ $package_cat_data->id }}">{{ $package_cat_data->name }}</label>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        @if(!empty($package_cat))

                            @foreach($package_cat as $package_cat_data)

                            @php
                                $package = DB::table('packages')
                                                ->where('service_id',$service_id)
                                                ->where('subservice_id',$subservice_id)
                                                ->where('packagecategory_id',$package_cat_data->id)
                                                ->get()->toArray();

                                //$package =array();

                                //echo"<pre>";print_r($package);echo"</pre>";
                            @endphp

                            <div class="form-group mb-3" >
                                @if(!empty($package))

                                @foreach($package as $package_data)
                                
                                    <h5>{{ $package_data->name }}</h5>
                                    <div class="row mb30">
                                        <div class="col-lg-6">
                                            <span class="currency_dhiram"></span> {{ $package_data->price }}
                                        </div>
                                        <div class="col-lg-6">
                                            @if(in_array($package_data->id, $book_array_package_id_session))
                                            {{-- <button type="button" class="btn border border-primary rounded text-primary add-to-card px-3" id="nextBtn12"
                                            onclick="remove_to_cart('{{ $package_data->id }}')">Remove -</button> --}}
                                            {{ 'Already Added' }}
                                            @else
                                            <button type="button" class="btn border border-primary rounded text-primary add-to-card px-3" id="nextBtn12"
                                            onclick="add_to_cart_book('{{ $package_data->id }}')">Add +</button>

                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                            </div>
                            @endforeach
                        @endif
                            
                    @endif
                    <button type="button" class="ud-btn btn-thm default-box-shadow2 custome-black  mobile-hide" id="nextBtn12"
                                onclick="get_hide_show(2);">Next</button>
                </div>

                <div class="tab2" style="display:none">
                    <div class="form-group mb-3">
                        <label class="form-label fw500 dark-color " for="country">Where would you like your service?</label>
                        <p style="margin-top: -10px;font-size:14px;">Save your address details.</p>
                        <div class="radio-group">
                            <input type="radio" id="address_type_home" name="address_type" value="home"  checked>
                            <label for="address_type_home" style="border-radius: 50px;">Home</label>
                    
                            <input type="radio" id="address_type_office" name="address_type" value="office">
                            <label for="address_type_office" style="border-radius: 50px;">Office</label>

                            <input type="radio" id="address_type_other" name="address_type" value="other">
                            <label for="address_type_other" style="border-radius: 50px;">Other</label>
                        </div>
                        <p class="form-error-text" id="address_type_error" style="color: red; margin-top: 10px;">
                        </p>

                        <div class="form-group mb-3">
                            {{-- <label class="form-label fw500 dark-color " for="country">How often do you need cleaning?</label> --}}
    
                            <select class="form-control" name="city" id="city">
                                <option value="">Select City</option>
                                <option value="Dubai" selected>Dubai</option>
                                <option value="Abu Dhabhi">Abu Dhabhi</option>
                                <option value="Sharjah">Sharjah</option>
                                <option value="Ajman">Ajman</option>
                                <option value="Ras Al Khaimah">Ras Al Khaimah</option>
                                <option value="Umm Al Quwain">Umm Al Quwain</option>
                                <option value="Fujairah">Fujairah</option>
                            </select>
    
                            <p class="form-error-text" id="city_error" style="color: red; margin-top: 10px;">
                            </p>
    
                        </div>
                        <div class="form-group mb-3">
                            {{-- <label class="form-label fw500 dark-color " for="country">How often do you need cleaning?</label> --}}
                            <input type="text" name="area" id="area" class="form-control" placeholder="Enter Your Area">
                            <p class="form-error-text" id="area_error" style="color: red; margin-top: 10px;" ></p>
    
                        </div>
    
                        <div class="form-group mb-3">
                            {{-- <label class="form-label fw500 dark-color " for="country">How often do you need cleaning?</label> --}}
                            <input type="text" name="building_street_no" id="building_street_no" class="form-control" placeholder="Enter your building name and/or street">
                            <p class="form-error-text" id="building_street_no_error" style="color: red; margin-top: 10px;" ></p>
    
                        </div>
    
                        <div class="form-group mb-3">
                            {{-- <label class="form-label fw500 dark-color " for="country">How often do you need cleaning?</label> --}}
                            <input type="text" name="apartment_villa_no" id="apartment_villa_no" class="form-control" placeholder="Enter your apartment number & floor or villa number">
                            <p class="form-error-text" id="apartment_villa_no_error" style="color: red; margin-top: 10px;" ></p>
    
                        </div>
    
                        <button type="button" class="ud-btn btn-thm default-box-shadow2 custome-black" id="nextBtn12"
                                    onclick="get_hide_show(1);">Previous</button>
    
                        <button type="button" class="ud-btn btn-thm default-box-shadow2 custome-black  mobile-hide" id="nextBtn12"
                                    onclick="get_hide_show(3);">Next</button>
                    </div>
                </div>

                <div class="tab3" style="display:none">

                    <div class="form-group mb-3">
                        <label class="fw500 dark-color " for="country">Which day would you like us to come?</label>
                        <div class="calendar-input">
                            <p style="font-size:19px; font-weight:bold;" id="month_design" ></p>
                            <div class="calendar-container">
                                <button class="scroll-arrow" id="scroll-left" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                        <rect fill="none" height="24" width="24"></rect>
                                        <g>
                                            <polygon points="17.77,3.77 16,2 6,12 16,22 17.77,20.23 9.54,12"></polygon>
                                        </g>
                                    </svg>
                                </button>
                                <div class="dates-container" id="dates-container" onclick="date_select();">
                                    <div class="days-wrapper" id="days-wrapper"></div>
                                </div>
                                <button class="scroll-arrow" id="scroll-right" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                        <g>
                                            <path d="M0,0h24v24H0V0z" fill="none"></path>
                                        </g>
                                        <g>
                                            <polygon points="6.23,20.23 8,22 18,12 8,2 6.23,3.77 14.46,12"></polygon>
                                        </g>
                                    </svg>
                                </button>
                            </div>
    
                            <p class="form-error-text" id="date_error" style="color: red; margin-top: 10px;">
                            </p>
                        </div>
                        </div>
                        <input type="hidden" name="date" id="date" value="">
                        <input type="hidden" name="month" id="month" value="">
    
                        {{-- <div class="form-group mb-3">
                            <label class="form-label fw500 dark-color " for="country">What time would you like us to arrive?</label>
                            <div class="radio-group row time-slot-grid position relative">
    
                                @php
                                    $timeslot = DB::table('set_order')->orderBy('id','asc')->get()->toArray();
                                    $i=1;
                                @endphp
    
    
                                @foreach($timeslot as $timeslot_data)

                                @php
                                    $timeslot_service = DB::table('subservice_timeslot_price')
                                        ->where('subservice_id', $subservice_id)
                                        ->where('time_slot_id', $timeslot_data->id)
                                        ->where('is_active', 1)
                                        ->first();  
                                    // echo"<pre>";print_r($timeslot_service);echo"</pre>";exit;
    
                                    if ($timeslot_service 
                                    && $timeslot_service->price > 0) {
                                        $timeslot_service_price = $timeslot_service->price;
                                    } else {
                                        $timeslot_service_price = 0;
                                    }
                                @endphp
    
                                @if($timeslot_service && $timeslot_service->is_active == 1)

                                <div class="surcharge-badge-timeslot items">
                                @if($timeslot_service_price > 0)
                                    <span>+ <span class="currency_dhiram"></span> {{$timeslot_service_price}}</span>
                                @endif
                                <input type="radio" id="time{{$i}}" name="time_slot" data-name="{{$timeslot_data->name}}" onclick="timeslot_price('{{$timeslot_service_price}}','{{$timeslot_data->name}}');" value="{{$timeslot_data->id}}" >
                                <label class="labeltime" for="time{{$i}}" style="border-radius: 50px;">{{$timeslot_data->name}}</label>
    
                                </div>
                                @endif
                                @php
                                    $i++;
                                @endphp
                                @endforeach
                            </div>
                            <p class="form-error-text" id="time_slot_error" style="color: red; margin-top: 10px;">
                            </p>
                        </div> --}}

                       <div class="form-group mb-3">
                        <label class="form-label fw500 dark-color" for="country">What time would you like us to start?</label>
                        <div class="radio-group time-slot-grid time_replace_ab">
                            @php
    use Carbon\Carbon;
    date_default_timezone_set('Asia/Dubai');

    $timeslot = DB::table('time_slots')->orderBy('set_order', 'asc')->get()->toArray();
    $i = 1;
@endphp

@foreach($timeslot as $timeslot_data)
    @php
        // Get service-specific timeslot price
        $timeslot_service = DB::table('subservice_timeslot_price')
            ->where('subservice_id', $subservice_id)
            ->where('time_slot_id', $timeslot_data->id)
            ->where('is_active', 1)
            ->first();

        $timeslot_service_price = $timeslot_service && $timeslot_service->price > 0 ? $timeslot_service->price : 0;
    @endphp

    @if($timeslot_service && $timeslot_service->is_active == 1)
        <div class="surcharge-badge-timeslot items">
            @if($timeslot_service_price > 0)
                <span>+ <p class="currency_dhiram"></p> {{ $timeslot_service_price }}</span>
            @endif
            <input type="radio" id="time{{ $i }}" name="time_slot"
                data-name="{{ $timeslot_data->name }}"
                onclick="timeslot_price('{{ $timeslot_service_price }}', '{{ $timeslot_data->name }}', this);"
                value="{{ $timeslot_data->id }}">
            <label class="labeltime" for="time{{ $i }}" style="border-radius: 50px;">
                {{ $timeslot_data->name }}
            </label>
        </div>
    @endif

    @php $i++; @endphp
@endforeach

                        </div>
                        <p class="form-error-text" id="time_slot_error" style="color: red; margin-top: 10px;"></p>
                    </div>
     
                        <button type="button" class="ud-btn btn-thm default-box-shadow2 custome-black" id="nextBtn12"
                        onclick="get_hide_show(2);">Previous</button>
    
                        <button type="button" class="ud-btn btn-thm default-box-shadow2 custome-black mobile-hide" id="nextBtn12" onclick="get_hide_show(4);">Next</button>
                   
                   
                </div>

                <div class="tab4" style="display:none">
                    
                    <div class="form-group mb-3">
                        <label class="form-label fw500 dark-color " for="country">How would you like to pay for your service?</label>
                        <p style="margin-top: -10px;font-size: 14px;">Please note cancellation or rescheduling fees may apply for last minute changes.</p>
                        <div class="radio-group payment-type payment-center"> 
                            <input type="radio" id="paymet_2" name="payment_type_old" value="ONLINE" checked>
                            <label for="paymet_2" style="border-radius: 50px;text-align: center;width:50%;">Online</label>
                            <img src="{{ asset('public/site/images/pay_logo_new.png') }}" style="height: 45px;margin-bottom:10px;" class="img-center">
                        </div>
                            {{-- <p>Payment will only be processed once the service is successfully completed.</p> --}}

                            <div class="radio-group payment-type">
                            <input type="radio" id="paymet_1" name="payment_type_old" value="COD" >
                            <label for="paymet_1" style="border-radius: 50px;text-align: center;width:50%;">Cash</label>
                            <p class="cod_fee_p">+ <span class="currency_dhiram"></span> 5 Cash handling charges will be applied.</p>
                        </div>
                       
                        
                        <p class="form-error-text" id="payment_type_error" style="color: red; margin-top: 10px;">
                        </p>
                    </div>

                    <button type="button" class="ud-btn btn-thm default-box-shadow2 custome-black" id="nextBtn12"
                    onclick="get_hide_show(3);">Previous</button>
                    

                    <button type="button" class="ud-btn btn-thm default-box-shadow2 custome-black mobile-hide" id="nextBtn12"
                                onclick="get_hide_show(5);">Next</button>
                </div>

                <div class="tab5" style="display:none">

                    <div class="form-content-main pb-0 pre-confirm-desc mt-4 px-md-2">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <h5 class="card-title mb-md-4">Please review your booking details and confirm your booking.</h5>
                            </div>
                        </div>
                    </div>

                    <div class="p-md-3 px-md-2">
                        <hr>
                        <div class="font-weight-bold h5">
                                Booking Summary
                        </div>

                        @if($subservice_id == 47)
                        <div class="first-edit">
                            <a href="javascript:void(0);" class="first-edit-anch" onclick="get_hide_show(1);">Edit</a>
                        </div>
                       
                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Service</div>
                                <div class="font-weight-bold sm-summary" id="confirm-service-label">Move in / Move Out Painting</div>
                            </div>
                        </div>

                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Size of home</div>
                                <div class="font-weight-bold sm-summary" id="confirm-sizeHome-label">Apartment - Studio</div>
                            </div>
                        </div>

                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Furnished</div> 
                                <div class="font-weight-bold sm-summary" id="confirm-furnished-label">No</div>
                            </div>
                        </div>

                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Colors</div>
                                <div class="font-weight-bold sm-summary" id="confirm-colors-label">Off-white to Off-white</div>
                            </div>
                        </div>

                        <div class="my-2 confirm-ceilings-label-add-c selected-ceilings-label-display">
                            <div class="d-flex justify-content-between">
                                <div>Ceilings</div>
                                <div class="font-weight-bold sm-summary" id="confirm-ceilings-label"></div>
                            </div>
                        </div>
                        
                        
                        @endif                       

                      
                        <hr>

                        <div class="font-weight-bold h5">
                                Date &amp; Time
                        </div>

                        <div class="first-edit">
                            <a href="javascript:void(0);" class="first-edit-anch" onclick="get_hide_show(3);">Edit</a>
                        </div>

                        <div class="my-2" >
                            <div class="d-flex justify-content-between">
                                <div>Date</div>
                                <div class="font-weight-bold sm-summary"><span id="frequency_summary_date"></span></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>Start Time</div>
                                <div class="font-weight-bold sm-summary"><span id="frequency_summary_timeslot"></span>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="font-weight-bold h5">
                            Address
                        </div>

                        <div class="first-edit">
                            <a href="javascript:void(0);" class="first-edit-anch" onclick="get_hide_show(2);">Edit</a>
                        </div>

                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Address</div>
                                <div class="font-weight-bold sm-summary"><span id="frequency_summary_address"></span></div>
                            </div>
                        </div>

                        <hr>

                        <div class="font-weight-bold h5">
                            Payment Method
                        </div>

                        <div class="first-edit">
                            <a href="javascript:void(0);" class="first-edit-anch" onclick="get_hide_show(4);">Edit</a>
                        </div>

                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Payment Method</div>
                                <div class="font-weight-bold sm-summary"><span id="frequency_summary_payment_mode"></span></div>
                            </div>
                        </div>

                        <hr>
                        @php
                        $subservice_popup_data = DB::table('subservices')->where('id',$subservice_id)->first();
                       @endphp 
                        <div class="font-weight-bold h5">
                            Payment Details
                        </div>

                        <div class="my-2" >
                            <div class="d-flex justify-content-between">
                                <div>Service Charges</div>
                                <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span><span id="frequency_summary_service_charge"></span></div>
                            </div>
                        </div>
                        {{-- <div class="my-2" >
                            <div class="d-flex justify-content-between">
                                <div>Additional Charges</div>
                                <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span><span id="frequency_summary_addtional_charge">0.00</span></div>
                            </div>
                        </div> --}}
                         <div class="my-2"  id="additional_charge_wrapper" style="display: none;">
                            <div class="d-flex justify-content-between">
                                
                                <div>Additional Charges 
                                @if($subservice_popup_data->additional_charge_popup != "")
                                <span>
                                <a style="cursor: pointer;" data-bs-toggle="modal" id="cleaner_stay" data-bs-target="#additional_charge_popup_{{$subservice_id}}">
                                 <img src="{{ asset('public/site/images/infoicon.svg') }}" style="height: 15px;width: 15px;">
                                </a>
                                </span>
                                @endif
                                </div>
                                <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span><span id="frequency_summary_addtional_charge"></span></div>
                            </div>
                        </div>

                        {{-- <div class="my-2" >
                            <div class="d-flex justify-content-between">
                                <div>Cash on Delivery charge</div>
                                <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span><span id="frequency_summary_cod_charge"></span></div>
                            </div>
                        </div> --}}

                          <div class="my-2" id="cod_charge_wrapper"  style="display: none;">
                            <div class="d-flex justify-content-between " >
                                
                                <div>Delivery charge
                                    @if($subservice_popup_data->delivery_charge_popup != "")
                                    <span>
                                    <a style="cursor: pointer;" data-bs-toggle="modal" id="cleaner_stay" data-bs-target="#delivery_charge_popup_{{$subservice_id}}">
                                    <img src="{{ asset('public/site/images/infoicon.svg') }}" style="height: 15px;width: 15px;"></a>
                                    </span>
                                     @endif
                                </div>
                                <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span><span id="frequency_summary_cod_charge"></span></div>
                                
                            </div>
                        </div>


                        {{-- <div class="my-2" >
                            <div class="d-flex justify-content-between">
                                <div>Timing fee</div>
                                <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span><span id="frequency_summary_timing_fee"></span></div>
                            </div>
                        </div> --}}

                         <div class="my-2" id="timing_charge_wrapper"  style="display: none;">
                            <div class="d-flex justify-content-between">
                                
                                <div>Timing fee
                                    @if($subservice_popup_data->timing_fee_popup != "")
                                    <span>
                                    <a style="cursor: pointer;" data-bs-toggle="modal" id="cleaner_stay" data-bs-target="#timing_fee_popup_{{$subservice_id}}">
                                    <img src="{{ asset('public/site/images/infoicon.svg') }}" style="height: 15px;width: 15px;">
                                    </a>
                                    </span>
                                     @endif
                                </div>
                                <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span><span id="frequency_summary_timing_fee"></span></div>
                                
                            </div>
                        </div>

                        {{-- <div class="my-2" >
                            <div class="d-flex justify-content-between">
                                <div>Service Fee</div>
                                <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span><span id="frequency_summary_service_fee_charge"></span></div>
                            </div>
                        </div> --}}

                         <div class="my-2" id="service_fee_wrapper"  style="display: none;">
                            <div class="d-flex justify-content-between">
                                <div>Service Fee 
                                   @if($subservice_popup_data->service_fee_popup != "")
                                    <span> 
                                    <a style="cursor: pointer;" data-bs-toggle="modal" id="cleaner_stay" data-bs-target="#service_fee_popup_{{$subservice_id}}">
                                    <img src="{{ asset('public/site/images/infoicon.svg') }}" style="height: 15px;width: 15px;">
                                    </a></span>
                                     @endif
                                </div>
                                <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span><span id="frequency_summary_service_fee_charge"></span></div>
                            </div>
                        </div>

                         <div class="my-2" >
                            <div class="d-flex justify-content-between">
                                <div>Promo Discount</div>
                                <div class="font-weight-bold sm-summary" style="background-color:#FFD312;border-radius: 6px;
                                padding: 0 5px 0 5px;"><span class="currency_dhiram"></span><span id="frequency_summary_promo_discount"></span></div>
                            </div>
                        </div>
                        <div class="my-2" >
                            <div class="d-flex justify-content-between">
                                <div>Sub Total</div>
                                <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span><span id="frequency_summary_service_sub_total"></span></div>
                            </div>
                        </div>

                        <div class="my-2" >
                            <div class="d-flex justify-content-between">
                                <div>VAT (5%)</div>
                                <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span><span id="frequency_summary_service_vat"></span></div>
                            </div>
                        </div>
                        @php
                            $userData = Session::get('user');
                            
                            if ($userData && isset($userData['userid'])) {
                            $wallet_plus_amount = DB::table('front_user_wallet')
                                        ->where('refer_id', $userData['userid'])
                                        ->where('added_from',0)
                                        ->sum('wallet_amount');

                            $wallet_minus_amount = DB::table('front_user_wallet')
                                        ->where('refer_id', $userData['userid'])
                                        ->where('added_from',1)
                                        ->sum('wallet_amount');

                            // echo"<pre>";print_r($wallet_plus_amount);echo"</pre>";
                            // echo"<pre>";print_r($wallet_minus_amount);echo"</pre>";

                            $wallet_amount = $wallet_plus_amount - $wallet_minus_amount;
                            }else{
                                $wallet_amount = 0;
                            }
                        @endphp

                        @if($wallet_amount > 0)

                        <div class="my-2" >
                            <div class="d-flex justify-content-between">
                                <div><span id="wallet_amount">Wallet Amount ({{$wallet_amount}} <span class="currency_dhiram"></span>)</span>
                                   
                                    <button  onclick="apply_wallet_discount();" type="button" class="wallet_apply">Apply</button>
                                    
                                    <button id="cancel_wallet_discount" onclick="cancelWalletDiscount();" type="button" class="wallet_cancel" style="display: none;">Cancel</button>

                                   </div>
                                <div class="font-weight-bold sm-summary"><span id="frequency_wallet_amount"></span></div>
                            </div>
                        </div>
                        @endif

                        <hr>

                        

                        <div class="my-2" >
                            <div class="d-flex justify-content-between">
                                <div class="font-weight-bold h5">
                                    Total to pay
                                </div>
                                <div class="font-weight-bold" style="max-width: 50%; text-align: right;">
                                    {{-- <del><span class="currency_dhiram"></span><span id="frequency_summary_cross_total">0.00</span></del> --}}
                                    <br><strong class="frequency_summary_strong"><span class="currency_dhiram"></span> <span id="frequency_summary_total_to_pay"></span></strong>
                                </div>
                            </div>
                        </div>

                        

                    </div>
                    <button type="button" class="ud-btn btn-thm default-box-shadow2 custome-black" id="nextBtn12"
                    onclick="get_hide_show(4);">Previous</button>

                    <button class="btn btn-primary mb-1 book-now-web spinner_button" type="button" disabled id="spinner_button" style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...</button>
                    <button type="button" class="ud-btn btn-thm default-box-shadow2 order_now custome-black book-now-web" id="nextBtn12" 
                                onclick="get_hide_show(6);">Book Now </button>
                </div>

                <div class="tab6" style="display:none">

                     <div class="form-content-main pb-0 pre-confirm-desc mt-4 px-md-2">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <h5 class="card-title mb-md-4">Please review your request and submit it to start receiving your quotes.</h5>
                            </div>
                        </div>
                    </div>

                    <div class="p-md-3 px-md-2">
                        <hr>
                        <div class="font-weight-bold h5">
                                Booking Summary
                        </div>

                        @if($subservice_id == 47)
                        <div class="first-edit">
                            <a href="javascript:void(0);" class="first-edit-anch" onclick="get_hide_show(1);">Edit</a>
                        </div>
                       
                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Service</div>
                                <div class="font-weight-bold sm-summary" id="confirm-get-quote-service-label">Painting</div>
                            </div>

                            <div class="d-flex justify-content-between qoute-summary-rooms  qoute-summary-rooms-show">
                                <div>No.of rooms</div>
                                <div class="font-weight-bold sm-summary" id="confirm-get-quote-rooms-label">1</div>
                            </div>

                            <div class="d-flex justify-content-between qoute-summary-walls qoute-summary-show">
                                <div>No.of walls</div>
                                <div class="font-weight-bold sm-summary" id="confirm-get-quote-walls-label">1</div>
                            </div>
                        </div>

                        <hr>

                        <div class="font-weight-bold h5">
                            Additional instructions
                        </div>
                        <hr>
                        @endif   

                        @if($subservice_id == 89)

                        {{-- <div class="font-weight-bold h5">
                           Service Details
                        </div> --}}
                        <div class="first-edit">
                            <a href="javascript:void(0);" class="first-edit-anch" onclick="get_hide_show(1);">Edit</a>
                        </div>
                       
                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Service</div>
                                <div class="font-weight-bold sm-summary" id="last_summary_service_type">Wooden Floor Polishing</div>
                            </div>
                        </div>

                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Type of Property</div>
                                <div class="font-weight-bold sm-summary" id="last_summary_property_type"></div>
                            </div>
                        </div>

                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Approximate Area of Wooden Flooring</div>
                                <div class="font-weight-bold sm-summary" id="last_summary_area_of_floor"></div>
                            </div>
                        </div>

                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Current Condition of the Floor</div>
                                <div class="font-weight-bold sm-summary" id="last_summary_condition_of_floor"></div>
                            </div>
                        </div>

                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Service Required</div>
                                <div class="font-weight-bold sm-summary" id="last_summary_service_required"></div>
                            </div>
                        </div>

                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Would you like to schedule a site survey?</div>
                                <div class="font-weight-bold sm-summary" id="last_summary_schedule_site_survey"></div>
                            </div>
                         </div>  
                        
                         <hr>
                        @endif
                        
                        

                        <div class="font-weight-bold h5">
                                Date &amp; Time
                        </div>

                        <div class="first-edit">
                            <a href="javascript:void(0);" class="first-edit-anch" onclick="get_hide_show(3);">Edit</a>
                        </div>

                        <div class="my-2" >
                            <div class="d-flex justify-content-between">
                                <div>Date</div>
                                <div class="font-weight-bold sm-summary"><span id="get-quote-summary-date"></span></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>Start Time</div>
                                <div class="font-weight-bold sm-summary"><span id="get-quote-summary-time"></span>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="font-weight-bold h5">
                            Address
                        </div>

                        <div class="first-edit">
                            <a href="javascript:void(0);" class="first-edit-anch" onclick="get_hide_show(2);">Edit</a>
                        </div>

                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Address</div>
                                <div class="font-weight-bold sm-summary"><span id="get-quote-summary-address"></span></div>
                            </div>
                        </div>
                        <hr>                 
                    </div>
                    <button type="button" class="ud-btn btn-thm default-box-shadow2 custome-black" id="nextBtn12"
                    onclick="get_hide_show(3);">Previous</button>

                    <button class="btn btn-primary mb-1 book-now-web spinner_button" type="button" disabled id="spinner_button" style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...</button>
                    <button type="button" class="ud-btn btn-thm default-box-shadow2 order_now custome-black book-now-web" id="nextBtn12" 
                                onclick="get_hide_show(6);">Get Quotes </button>
                </div>

                <input type="hidden" name="service_charge" id="service_charge" value="78">
                <input type="hidden" name="promo_discount" id="promo_discount" value="0">
                <input type="hidden" name="cleaning_discount_additional" id="cleaning_discount_additional" value="0">
                <input type="hidden" name="additional_charge" id="additional_charge" value="0">
                {{-- <input type="hidden" name="timing_charge" id="timing_charge" value="0">
                <input type="hidden" name="weekly_off_charge" id="weekly_off_charge" value="0"> --}}
                <input type="hidden" name="sub_total" id="sub_total" value="78">
                <input type="hidden" name="sub_total_time" id="sub_total_time" value="78">
                <input type="hidden" name="vat_total" id="vat_total" value="3.90">
                <input type="hidden" name="cod_charge" id="cod_charge_book_now" value="0">
                <input type="hidden" name="service_fee" id="service_fee_book_now" value="9">
                <input type="hidden" name="total_to_pay" id="total_to_pay" value="81.90">

                </form>
            </div>

            <div class="sticky-button">

            <button id="stickyButton" class="booking-summary" style="bottom:20px;">

                <div class="d-flex justify-content-between mobile-total-price-show mobile-total-price-btn" style="color:#000;">
                    <div class="font-weight-bold">
                        @if($painting_dis_price->promo_discount > 0)
                        {{-- <div style="font-size: 15px;margin-right:75px;text-decoration: line-through;">
                            <span class="currency_dhiram"></span>
                            <span id="frequency_summary_cross_amount_mobile" style="text-decoration: line-through;"></span>
                        </div> --}}
                        @endif
          
                       @php
                       if($painting_dis_price->promo_discount > 0){
                            $style = "font-size: 25px;";
                       }else{
                            $style = "font-size: 25px;margin-top:20px;";
                       }
                           
                       @endphp
                        <div style="{{ $style }}">
                            <span class="currency_dhiram"></span> 
                            <span id="total_to_pay_charge_replace_mobile"></span>
                            <i style="margin-left: 5px;" class="fa-solid fa-angle-up" id="aerrowicon"></i>
                        </div>
                    </div>
                </div>
            <p id="selected_weekly" style="margin-top:-10px; font-size: 17px; font-weight:1000;color: #000;" ></p>
            </button>
            
            

             
            <button type="button" class="ud-btn btn-thm default-box-shadow2 backMobile custome-black mobile-tab2" id="nextBtn12" style=""onclick="get_hide_show(2);">Next</button>

             <button type="button" class="ud-btn btn-thm default-box-shadow2 backMobile custome-black mobile-tab3" id="nextBtn12" style="display: none;"onclick="get_hide_show(3);">Next</button>                                                                                                
             <button type="button" class="ud-btn btn-thm default-box-shadow2 backMobile custome-black mobile-tab4" id="nextBtn12" style="display: none;"onclick="get_hide_show(4);">Next</button>                                                                                                
             <button type="button" class="ud-btn btn-thm default-box-shadow2 backMobile custome-black mobile-tab5" id="nextBtn12" style="display: none;"onclick="get_hide_show(5);">Next</button>
             
            <button class="btn btn-primary mb-1 backMobile spinner-mobile-tab6 spinner_button" type="button" disabled id="spinner_button" style="color: #0d6efd;background-color: #fff;border-color: #fff;top: 15px; display:none;">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...</button>
                <button type="button" class="ud-btn btn-thm default-box-shadow2 order_now custome-black backMobile mobile-tab6 mobile-booknow-btn" id="nextBtn12" style="display: none;right:4px !important;" onclick="get_hide_show(6);">Book Now </button>

                <input type="hidden" name="service_fee" id="service_fee" value="9">
            </div>



            

            


            <div class="col-lg-5" id="summary_div_left">

                <div  id="summary_div_left_package" class="last_col">
                    <span class="moving-in-out-painting-show moving-in-out-painting-hide">
                    <div class="d-flex justify-content-center is-r font-weight-bold-summary">
                    <div  class="font-weight-bold-summary h5" style="font-size: 17px;">
                    <h3>Total to pay
                    </h3>
                    </div>
                    </div>
                    <div class="{{ $painting_dis_price->promo_discount > 0 ? 'left-summary-total' : 'left-summary-without-cross-total' }}">
                    @if($painting_dis_price->promo_discount > 0)
                    {{-- <stong style="width: 100%;text-align: center; display: inline-block;"><span class="currency_dhiram"></span><span id="cross_amount" style="text-decoration: line-through;"></span></stong> --}}
                    
                    @endif
                    <strong class="main_price" style=""><span class="currency_dhiram"></span> <span id="total_to_pay_charge_replace">546.00</span></strong>
                </div>
                <p id="selected_weekly" style="font-size: 17px; font-weight:1000;" ></p>

            </span>
                 <div  class="font-weight-bold-summary h5" style="font-size: 17px;">Booking Summary</div>
                <span class="underline"></span>
                <div class="font-weight-bold-summary h5">Service Details</div>

                @if($subservice_id == 47)
                <div class="d-flex justify-content-between"><div>Service</div><div class="font-weight-bold sm-summary" id="service-label">Painting</div></div>
                <span class="summary-movein-out-service-show summary-movein-out-service-hide">
                    <div class="d-flex justify-content-between moving-in-out-painting-show moving-in-out-painting-hide">    
                        <div>Size of Home</div>
                        <div class="font-weight-bold sm-summary" id="size-of-home-label-nn"><span id="size-of-home-label-type">Apartment</span> - <span id="size-of-home-label-size">Studio</span></div>
                    </div>
                    <div class="d-flex justify-content-between moving-in-out-painting-show moving-in-out-painting-hide">
                        <div>Furnished</div>
                        <div class="font-weight-bold sm-summary" id="furnished-label">No</div>
                    </div>
                    <div class="d-flex justify-content-between selected-color-label-display">
                        <div>Colors</div>
                        <div class="font-weight-bold sm-summary" id="selected-color-label"></div>
                    </div>

                    <div class="d-flex justify-content-between selected-ceilings-label-add-c selected-ceilings-label-display">
                        <div>Ceilings</div>
                        <div class="font-weight-bold sm-summary" id="selected-ceilings-label"></div>
                    </div>
                </span>

                <span class="summary-paint-rooms-show summary-paint-rooms-hide">
                    <div class="d-flex justify-content-between">
                        <div>No.of rooms</div>
                        <div class="font-weight-bold sm-summary" id="no-of-paint-rooms-label">1</div>
                    </div>
                </span>

                <span class="summary-paint-walls-show summary-paint-walls-hide">
                    <div class="d-flex justify-content-between">
                        <div>No.of walls</div>
                        <div class="font-weight-bold sm-summary" id="no-of-paint-walls-label">1</div>
                    </div>
                </span>
                <span class="underline"></span>

                @endif

            @if($subservice_id == 89)

                <div class="d-flex justify-content-between"><div>Service</div><div class="font-weight-bold sm-summary" id="service-label">Wooden Floor Polishing</div></div>

                <div class="d-flex justify-content-between"><div>Type of Property</div><div class="font-weight-bold sm-summary" id="property_type_lable"></div></div>

                <div class="d-flex justify-content-between"><div>Approximate Area</div><div class="font-weight-bold sm-summary" id="area_of_floor_lable"></div></div>

                <div class="d-flex justify-content-between"><div>Current Condition</div><div class="font-weight-bold sm-summary" id="condition_of_floor_lable"></div></div>

                <div class="d-flex justify-content-between"><div>Service Required</div><div class="font-weight-bold sm-summary" id="required_service_lable"></div></div>

                <div class="d-flex justify-content-between"><div>Schedule a site survey?</div><div class="font-weight-bold sm-summary" id="schedule_site_lable"></div></div>

   
                <div class="font-weight-bold-summary h5">Address</div>
                <div class="d-flex justify-content-between"><div class="font-weight-bold sm-summary" style="margin-left:155px; margin-top:-30px;"><span id="address_replace"></span></div></div>  
            @endif


                <div class="d-flex justify-content-between">
					<div class="font-weight-bold-summary h5">
					Date & Time
					</div>
					 <div class=""><div class="font-weight-bold sm-summary" style=""> <span id="date_replace"></span></br><span id="time_replace"></span></div></div>  
				</div>
               
                
                <span class="underline"></span>

                                  
                <span class="moving-in-out-painting-show moving-in-out-painting-hide">
                <div class="font-weight-bold-summary h5">Payment Details</div>
                <div class="d-flex justify-content-between"><div>Service Charges</div><div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span> <span id="service_charge_replace">550.00</span></div></div>

                <div class="d-flex justify-content-between additional-charges-label additional-charges-display additional_charge_replace_div" style="display: none !important"><div>Additional Charges</div><div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span> <span id="additional_charge_replace">20.00</span></div></div>
                    {{-- DisV --}}
                <div class="d-flex justify-content-between promo_dicount_replace_new_div" style="display: none !important"><div>Promo Discount</div><div class="font-weight-bold sm-summary" style="background-color:#FFD312;border-radius: 6px;
                padding: 0px 5px 0px 5px;">-<span class="currency_dhiram"></span> <span id="promo_dicount_replace_new">{{ number_format($painting_dis_price->promo_discount, 2) }}</span></div></div>

                

                <div class="d-flex justify-content-between timing_charge_replace_div" style="display: none !important">
                        
                        <div>Timing fee</div>
                        <div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span>
                            <span id="timing_charge_replace">0</span>
                        </div>
                       
                </div>

                <div class="d-flex justify-content-between cod_charge_replace_div" style="display: none !important">
                        
                        <div>Delivery charge</div>
                        <div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span>
                            <span id="cod_charge_replace">0</span>
                        </div>
                       
                </div>

                <div class="d-flex justify-content-between"><div>Sub Total</div><div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span><span id="sub_total_replace">520.00</span></div></div>
                <div class="d-flex justify-content-between"><div>VAT (5%)</div><div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span><span id="vat_charge_replace">26.00</span></div></div>
                <span class="underline"></span>
              

                
            </span>
            </div>
            </div>

            <diV class="summary_div_left_mobile" id="summary_div_left_mobile" style="display: none;">
              
                <div class="summuryInner">

                <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                        </button>

                @if($subservice_id == 30 || $subservice_id == 28 || $subservice_id == 47)
                {{-- Mobile hide --}}
                <div class="d-flex justify-content-between"><div>Service Charges</div><div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span><span id="service_charge_replace_mobile">0.00</span></div></div>

                {{-- <div class="d-flex justify-content-between additional-charges-label additional-charges-display"><div>Additional Charges</div><div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span><span id="additional_charge_replace_mobile">0.00</span></div></div> --}}

                <div id="additional_charge_wrapper_mobile" style="display: none;">
                <div class="d-flex justify-content-between">
                    <div>Additional Charges
                    @if($subservice_popup_data->additional_charge_popup != "") 
                    <span>
                    <a style="cursor: pointer;" data-bs-toggle="modal" id="cleaner_stay" data-bs-target="#additional_charge_popup_{{$subservice_id}}">
                       <img src="{{ asset('public/site/images/infoicon.svg') }}" style="height: 15px;width: 15px;">
                    </a>
                    </span>
                    @endif
                </div>
                <div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span><span id="additional_charge_replace_mobile"></span></div>
            </div>
            </div>
                

                <div class="d-flex justify-content-between"><div>Promo Discount</div><div class="font-weight-bold sm-summary" style="background-color:#FFD312;border-radius: 6px;
                padding: 0px 5px 0px 5px;">-<span class="currency_dhiram"></span><span id="promo_dicount_replace_mobile">0.00</span></div></div>

                {{-- <div class="d-flex justify-content-between " >
                                        
                    <div>Delivery charge</div>
                    <div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span>
                        <span id="cod_charge_replace_mobile">0</span>
                    </div>
                
                </div> --}}

                
            <div id="cod_charge_wrapper_mobile" style="display: none;">
                <div class="d-flex justify-content-between " >
                                        
                <div>Delivery charge
                    @if($subservice_popup_data->delivery_charge_popup != "") 
                    <span>
                    <a style="cursor: pointer;" data-bs-toggle="modal" id="cleaner_stay" data-bs-target="#delivery_charge_popup_{{$subservice_id}}">
                    <img src="{{ asset('public/site/images/infoicon.svg') }}" style="height: 15px;width: 15px;">
                    </a>
                    </span>
                    @endif
                </div>
                    <div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span>
                        <span id="cod_charge_replace_mobile">0</span>
                    </div>
                </div>
                </div>

                {{-- <div class="d-flex justify-content-between " >
                        
                    <div>Timing fee</div>
                    <div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span>
                        <span id="timing_charge_replace_mobile">0.00</span>
                    </div>
                   
            </div> --}}

            <div id="timing_charge_wrapper_mobile" style="display: none;">
                <div class="d-flex justify-content-between " >
                        
                <div>Timing fee
                    @if($subservice_popup_data->timing_fee_popup != "") 
                    <span>
                    <a style="cursor: pointer;" data-bs-toggle="modal" id="cleaner_stay" data-bs-target="#timing_fee_popup_{{$subservice_id}}">
                    <img src="{{ asset('public/site/images/infoicon.svg') }}" style="height: 15px;width: 15px;">
                    </a>
                    </span>
                    @endif
                </div>
                <div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span>
                    <span id="timing_charge_replace_mobile">0</span>
                </div>
                </div>
                </div>
                
                
                {{-- <div class="d-flex justify-content-between">
                        <div>Service Fee</div>
                        <div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span>
                        <span id="frequency_summary_service_fee_charge_mobile">0.00</span></div>
                </div> --}}
                <div id="service_fee_wrapper_mobile" style="display: none;">
                <div class="d-flex justify-content-between">
                    <div>Service Fee
 
                    @if($subservice_popup_data->service_fee_popup != "") 
                    <span>
                    <a style="cursor: pointer;" data-bs-toggle="modal" id="cleaner_stay" data-bs-target="#service_fee_popup_{{$subservice_id}}">
                    <img src="{{ asset('public/site/images/infoicon.svg') }}" style="height: 15px;width: 15px;">
                    </a>
                    </span>
                    @endif
                    </div>
                    <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span><span id="frequency_summary_service_fee_charge_mobile">0.00</span></div>
                </div>
                </div>

                <div class="d-flex justify-content-between"><div>Sub Total</div><div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span><span id="sub_total_replace_mobile">78.00</span></div></div>

                <div class="d-flex justify-content-between"><div>VAT (5%)</div><div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span><span id="vat_charge_replace_mobile">3.90</span></div></div>

                @endif
            </div>
        </div>
        </div>
        <input type="hidden" name="hour_charge_db" id="hour_charge_db" value="">
        <input type="hidden" name="cleaning_material_charge_db" id="cleaning_material_charge_db" value="">
    </div>
</section>
@include('front.includes.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>


{{-- For Painting Read more Popup Start --}}
<div class="modal modal-mobile-bottom" id="exampleModalLong_{{$subservice_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div id="modal-digi" class="modal-dialog modal-dialog-bottom modal-dialog-centered" role="document" style="">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" style="font-size: 20px;">
                    What Our Painting Service Includes </h5>
                    <button type="button" class="close" id="close" data-bs-dismiss="modal" aria-label="Close" style="background: none; font-size: 50px; color: #000; border: none;">
                        <span aria-hidden="true">&times;</span>
                        </button>
            </div>
            <div>
            <p style="font-size: 15px; font-weight:100; margin-left:15px;">
            <span>Revitalize your home with a fresh, polished look through our professional painting services. Whether you’re updating a single room or transforming your entire space, our skilled team delivers precise and flawless results, letting you enjoy a vibrant new ambiance without the hassle.</span></p>
            </div>
            <h6 style="font-size: 18px; margin-left:15px;">Our Services Include:</h6>
            <div class="modal-body">
                <ul style="list-style-type: disc; list-style: inherit;">
                    <li style="list-style: inherit;"><b>Surface Preparation:</b> Cleaning, sanding, and priming walls for a smooth finish</li>
                    <li style="list-style: inherit;"><b>Wall and Ceiling Painting:</b> Professional application with even, streak-free coats</li>
                    <li style="list-style: inherit;"><b>Trim and Molding Painting:</b> Crisp lines for doors, windows, and baseboards</li>
                    <li style="list-style: inherit;"><b>Color Consultation:</b> Assistance in choosing the perfect hues to match your style</li>
                    <li style="list-style: inherit;"><b>Clean-Up:</b> Ensuring your space is left spotless after the job is done</li>
                    <li style="list-style: inherit;"><b>Additional Services:</b> Accent walls, exterior touch-ups, and custom finishes</li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- For Painting Read more Popup End --}}



{{-- For Wooden and Floor Read more Popup Start --}}

<div class="modal modal-mobile-bottom" id="WoodenfloorModal_{{$subservice_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div id="modal-digi" class="modal-dialog modal-dialog-bottom modal-dialog-centered" role="document" style="">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" style="font-size: 20px;">
                    What Our Wooden Floor Polishing Service Includes </h5>
                    <button type="button" class="close" id="close" data-bs-dismiss="modal" aria-label="Close" style="background: none; font-size: 50px; color: #000; border: none;">
                        <span aria-hidden="true">&times;</span>
                        </button>
            </div>

            <div>
                <p style="font-size: 15px; font-weight:100; margin-left:15px;">
                <span>Revitalize your home with a fresh, polished look through our professional painting services. Whether you’re updating a single room or transforming your entire space, our skilled team delivers precise and flawless results, letting you enjoy a vibrant new ambiance without the hassle.</span></p>
                </div>
                <h6 style="font-size: 18px; margin-left:15px;">Our Services Include:</h6>
                <div class="modal-body">
                    <ul style="list-style-type: disc; list-style: inherit;">
                        <li style="list-style: inherit;"><b>Surface Preparation:</b> Cleaning, sanding, and priming walls for a smooth finish</li>
                        <li style="list-style: inherit;"><b>Wall and Ceiling Painting:</b> Professional application with even, streak-free coats</li>
                        <li style="list-style: inherit;"><b>Trim and Molding Painting:</b> Crisp lines for doors, windows, and baseboards</li>
                        <li style="list-style: inherit;"><b>Color Consultation:</b> Assistance in choosing the perfect hues to match your style</li>
                        <li style="list-style: inherit;"><b>Clean-Up:</b> Ensuring your space is left spotless after the job is done</li>
                        <li style="list-style: inherit;"><b>Additional Services:</b> Accent walls, exterior touch-ups, and custom finishes</li>
                    </ul>
                </div>

        </div>
    </div>
</div>

{{-- For Wooden and Floor Read more Popup End --}}


<div class="modal modal-mobile-bottom" id="Learnmore_{{$subservice_id}}" tabindex="-1" role="dialog" aria-labelledby="LearnmoreTitle" aria-hidden="true">
    <div  id="modal-digi" class="modal-dialog modal-dialog-bottom modal-dialog-centered" role="document" style="overflow: auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="LearnmoreTitle" style="font-size: 20px;">
                    How Long Should I book for ?</h5>
                    <button type="button" class="close" id="close" data-bs-dismiss="modal" aria-label="Close" style="background: none; font-size: 50px; color: #000; border: none;">
                    <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div>
            <p style="font-size: 15px; font-weight:100; margin-left:15px;">
            <span>Every home is different, but generally, an additional bedroom will add about an hour to your cleaning time. Below are our estimated durations for various home sizes:</span></p>
            </div>
            <div class="modal-body">
                <table id="mobile-table" style="border:1px solid 
                #000;">
                    <tr>
                        <th>Numbers of Bedrooms</th>
                        <th>Cleaning Time*</th>
                    </tr>
                    <tr>
                        <td>Studio</td>
                        <td>1.5-2 Hours</td>
                    </tr>
                    <tr>
                        <td>1 Bedroom</td>
                        <td>2-3 Hours</td>
                    </tr>
                    <tr>
                        <td>2 Bedroom</td>
                        <td>3-4 Hours</td>
                    </tr>
                    <tr>
                        <td>3 Bedroom</td>
                        <td>4-5 Hours</td>
                    </tr>
                    <tr>
                        <td>4 Bedroom</td>
                        <td>5-6 Hours</td>
                    </tr>
                    <tr>
                        <td>5 Bedroom</td>
                        <td>6-7 Hours</td>
                    </tr>
                </table>
            </div>
            <h6 style="margin-left: 15px;">*Standard cleaning covers general cleaning tasks, including surface wiping, dusting, sweeping, mopping, and vacuuming. For additional tasks such as oven or fridge cleaning, blinds wiping, or balcony cleaning, please allocate an extra 30-45 minutes per task.</h6>
            <div class="modal-body">
                <h6><strong>For Larger homes or Vilas</strong> consider booking an additional hour.
                </h6>
                <p>Here is a checklist for standard cleaning. Discuss with your cleaner any specific requirements for your home:</p>
                <h6>Kitchen - 35 mins</h6>
                <ul style="list-style-type: disc; list-style: inherit;">
                    <li style="list-style: inherit;">Wash dishes</li>
                    <li style="list-style: inherit;">Clean sink, countertops, and kitchen appliances</li>
                    <li style="list-style: inherit;">Wipe down cabinet fronts</li>
                </ul>

                <h6>Bathroom - 35 mins</h6>
                <ul style="list-style-type: disc; list-style: inherit;">
                    <li style="list-style: inherit;">Scrub bathtub, shower, and toilet</li>
                    <li style="list-style: inherit;">Clean sink and countertops</li>
                    <li style="list-style: inherit;">Hang and fold towels</li>
                    <li style="list-style: inherit;">Shine mirrors</li>
                </ul>

                <h6>Bedroom - 30 mins</h6>
                <ul style="list-style-type: disc; list-style: inherit;">
                    <li style="list-style: inherit;">Make beds</li>
                    <li style="list-style: inherit;">Tidy up and fold clothes</li>
                    <li style="list-style: inherit;">Clean mirrors and dust surfaces</li>
                </ul>

                <h6>Living Areas - 45 mins</h6>
                <ul style="list-style-type: disc; list-style: inherit;">
                    <li style="list-style: inherit;">Tidy and organize items</li>
                    <li style="list-style: inherit;">Vacuum carpets and floors</li>
                    <li style="list-style: inherit;">Dust furniture and all surfaces</li>
                    <li style="list-style: inherit;">Clean light switches and door handles</li>
                    <li style="list-style: inherit;">Wipe window sills</li>
                    <li style="list-style: inherit;">Mop hard floors</li>
                    <li style="list-style: inherit;">Empty trash bins</li>
                </ul>

                <h6>Additional Tasks - add 30-45 mins per task</h6>
                <ul style="list-style-type: disc; list-style: inherit;">
                    <li style="list-style: inherit;">Laundry and ironing</li>
                    <li style="list-style: inherit;">Change bed linens and pillowcases</li>
                    <li style="list-style: inherit;">Clean interior windows</li>
                    <li style="list-style: inherit;">Sweep and mop balcony/patio</li>
                    <li style="list-style: inherit;">Clean inside cupboards</li>
                    <li style="list-style: inherit;">Polish wood surfaces</li>
                </ul>

                <p>This comprehensive checklist ensures that your home is thoroughly cleaned. Tailor it to meet your specific needs and communicate any additional requests to your cleaning professional.</p>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-mobile-bottom" id="material_{{$subservice_id}}" tabindex="-1" role="dialog" aria-labelledby="materialTitle" aria-hidden="true">
    <div id="modal-digi" class="modal-dialog modal-dialog-bottom modal-dialog-centered" role="document" style="overflow: auto;">
        <div class="modal-content">
            <div class="modal-header" style="display:block;"> 
            <button type="button" class="close" id="close" data-bs-dismiss="modal" aria-label="Close" style="background: none; font-size: 50px; color: #000; border: none;margin-left:90%;">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <h6 style="font-size: 18px; margin-left:15px;">Cleaning Equipment:</h6>
            <div class="modal-body">
                <ul style="list-style-type: disc; list-style: inherit;">
                    <li style="list-style: inherit;">Vacuum cleaner (with appropriate attachments)</li>
                    <li style="list-style: inherit;">Mop and bucket</li>
                    <li style="list-style: inherit;">Broom and dustpan</li>
                    <li style="list-style: inherit;">Microfiber mops or cloths</li>
                    <li style="list-style: inherit;">Scrub brushes or sponges</li>
                    <li style="list-style: inherit;">Vacuum cleaner (with appropriate attachments)</li>
                </ul>
            </div>
            <h6 style="font-size: 18px; margin-left:15px;">Cleaning Products:</h6>
            <div class="modal-body">
                <ul style="list-style-type: disc; list-style: inherit;">
                    <li style="list-style: inherit;">All-purpose cleaner</li>
                    <li style="list-style: inherit;">Glass cleaner</li>
                    <li style="list-style: inherit;">Disinfectant wipes or spray</li>
                    <li style="list-style: inherit;">Bathroom cleaner</li>
                    <li style="list-style: inherit;">Floor cleaner (suitable for the flooring type)</li>
                    <li style="list-style: inherit;">Dusting spray or polish</li>
                    <li style="list-style: inherit;">Toilet bowl cleaner</li>
                    <li style="list-style: inherit;">Paper towels or cleaning rags</li>
                    <li style="list-style: inherit;">Trash bags</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<!-- OTP Popup Start-->
<div class="modal modal-mobile-bottom-otp otp-login-form-modal" id="exampleModalLong" tabindex="-1" aria-labelledby="otpLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-bottom-otp user-modal-dialog modal-dialog-centered">
    <div class="modal-content details-modal-content">
      <div class="modal-header details-header">
      <h5 class="modal-title w-100" id="modalStepTitle">Log in or Sign Up</h5>
      </div> 

      <div class="modal-body">
        <div id="booknow_refresh_otp_div">
        <input type="hidden" name="book_session_otp" id="book_session_otp" value= "{{session('book-login-otp')}}">
        </div>
        <form class="form-horizontal details-form" id="BookOtpForm" method="POST" action="{{ route('booknow-user-otp-login') }}">

        <input type="hidden" name="redirectUrl" value="{{ $redirectUrl }}">
        <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
        <input type="hidden" name="subservice_id" id="subservice_id" value="{{ $subservice_id }}">

        @csrf

          <!-- STEP 1: Mobile Input -->
          <div id="booknow-step-phone">
            <div class="form-group mb-2">
              <label id="mobilename-label">Please Enter Your WhatsApp mobile number</label>
              <input type="hidden" name="country_code_otp_popup_Modal" id="country_code_otp_popup_Modal_book" value="">
              <input type="text" class="input-field" name="phone" id="user-phone-number" placeholder="Mobile No" onkeypress="return validateNumber(event)">
              <p id="booknow_otp_phone_error" style="display:none;color:red;"></p>
            </div>
			<a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp" data-bs-target="#book_email_otp_popup_Modal">Don't have a WhatsApp Number? Login with Email</a>
            <div class="text-center mt-3">
			
			<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_phone_book1" style="display: none;">
				<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...
            </button>
			
              <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_phone_book1" onclick="booknow_otp_verification('1')">Continue</button>
            </div>
          </div>

          <!-- STEP 2: OTP Verification -->
          <div id="booknow-step-otp" style="display: none;">
            <label id="mobilename-label">Please enter the <strong>WhatsApp code</strong> that was sent to:<br>
              <span id="booknow-whatsapp-number">+971 58 520 0722</span>
            </label>

            <div class="d-flex justify-content-center gap-2 my-3">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
            </div>
            <p id="booknow_otp_error" style="display:none;color:red;"></p>

            <a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp" data-bs-target="#book_email_otp_popup_Modal">Can't log in? Use your Email Address</a>

            <div class="text-center mt-3">
			<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_phone_book2" style="display: none;">
				<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...
            </button>
              <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_phone_book2" onclick="booknow_otp_verification('2')" >Verify Number</button>
            </div>
          </div>

          <!-- STEP 3: Personal Details -->
        <div id="booknow-step-details" style="display: none;">
        <label id="mobilename-label">Contact information</label>
        <div class="form-group mt-3">
            <input type="text" class="form-control" name="book_name" id="booknow_user_name" placeholder="Full Name">
            <p id="booknow_name_error" style="display:none;color:red;"></p>
        </div>
        <div class="form-group mt-3">
            <input type="email" class="form-control" id="booknow_user_email" name="book_email" placeholder="Email">
            <p id="booknow_email_error" style="display:none;color:red;"></p>
        </div>
        <div class="text-center mt-3">
		<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_phone_book3" style="display: none;">

        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>

        <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_phone_book3" onclick="booknow_otp_verification('3')">All Done</button>

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

<div class="modal modal-mobile-bottom-otp otp-login-form-modal" id="book_email_otp_popup_Modal" tabindex="-1" aria-labelledby="otpLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-bottom-otp user-modal-dialog modal-dialog-centered">
    <div class="modal-content details-modal-content">
      <div class="modal-header details-header">
      <h5 class="modal-title w-100" id="booknow_email_modalStepTitle">Log in or Sign Up</h5>
      </div> 

      <div class="modal-body">
        <div id="book_email_refresh_otp_div">
        <input type="hidden" name="book_email_session_otp" id="book_email_session_otp" value= "{{session('book-email-login-otp')}}">
        </div>
        <form class="form-horizontal details-form" id="bookemailOtpForm" method="POST" action="{{ route('home.book-email-otp-login') }}">
        <input type="hidden" name="redirectUrl" value="{{ $redirectUrl }}">
        <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
        <input type="hidden" name="subservice_id" id="subservice_id" value="{{ $subservice_id }}">
		
		<input type="hidden" name="country_code_book_popup_Modal_book" id="country_code_book_popup_Modal_book" value="">
		
          @csrf


          <!-- STEP 1: Mobile Input -->
          <div id="book-email-step-phone">
            <div class="form-group mb-2">
              <label id="mobilename-label">Please Enter Your Email Address</label>
              <input type="text" class="input-field" name="book_email_email" id="book_email_email" placeholder="Email Address">
              <p id="book_email_email_error" style="display:none;color:red;"></p>
            </div>
			<a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp" data-bs-target="#exampleModalLong">Can't access your email? Log in with WhatsApp</a>
            <div class="text-center mt-3">
				<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_email_book1"
                                style="display: none;">

                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                Loading...

            </button>
              <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_email_book1" onclick="book_email_goToOtpVerification('1')">Continue</button>
            </div>
          </div>

          <!-- STEP 2: OTP Verification -->
          <div id="booknow-email-step-otp" style="display: none;">
            <label id="mobilename-label">Please enter the <strong>OTP</strong> that was sent to:<br>
			 <span id="book_email_address_model">+971 58 520 0722</span>
            </label>

            <div class="d-flex justify-content-center gap-2 my-3">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
              <input type="text" maxlength="1" class="book-email-otp-input form-control text-center" style="width: 40px;">
            </div>
            <p id="book_email_otp_error" style="display:none;color:red;"></p>
            <a href="javascript:void(0)" data-bs-toggle="modal" class="email-whatsapp" data-bs-target="#exampleModalLong">Can't access your email? Log in with WhatsApp</a>

            <div class="text-center mt-3">
			<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_email_book2" style="display: none;">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>

              <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_email_book2" onclick="book_email_goToOtpVerification('2')" >Verify Email</button>
            </div>
          </div>

          <!-- STEP 3: Personal Details -->
        <div id="booknow-email-step-details" style="display: none;">
        <label id="mobilename-label">Contact information</label>
        <div class="form-group mt-3">
            <input type="text" class="form-control" name="book_email_name" id="book_email_name" placeholder="Full Name">
            <p id="book_email_name_error" style="display:none;color:red;"></p>
        </div>
        <div class="form-group mt-3">
            <input type="text" class="form-control" id="book_email_mobile" name="book_email_mobile" placeholder="Phone Number" onkeypress="return validateNumber(event)">
            <p id="book_email_mobile_error" style="display:none;color:red;"></p>
        </div>
        {{-- <div class="form-group mt-3">
            <input type="text" class="form-control" id="book_email_area" name="book_email_area" placeholder="Area">
            <p id="book_email_area_error" style="display:none;color:red;"></p>
        </div> --}}
        <div class="text-center mt-3">
		<button class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" type="button" disabled id="spinner_button_email_book3" style="display: none;"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>

        <button type="button" class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn" id="submit_button_email_book3" onclick="book_email_goToOtpVerification('3')">All Done</button>
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

  @php
    $subservice_service_fee_popup = DB::table('subservices')->where('id',$subservice_id)->first();
    @endphp
  <!--- Service Fee Popup Start ---->
 
    <div class="modal modal-mobile-bottom" id="service_fee_popup_{{$subservice_id}}"  tabindex="-1" aria-labelledby="materialTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-bottom modal-dialog-centered modal-lg service-fee-custome-modal" id="modal-digi" role="document">
        <div class="modal-content charge-desc-popup">
            <div class="modal-header modal-header-mobile" style="display:block;">
            <h4>Service Fee Description</h4>
            <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            
            <div class="modal-body modal-mobile" style="max-height: 70vh; overflow-y: auto;">
                <div class="    ">
            <h6>{{ $subservice_service_fee_popup->service_fee_popup }}</h6>
                </div>
            </div>
            <div class="modal-footer">
            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
        </div>
    </div>

<!--- Service Fee Popup End ---->

<!--- Additional Charge Popup Start ---->
 
    <div class="modal modal-mobile-bottom"  id="additional_charge_popup_{{$subservice_id}}"  tabindex="-1" aria-labelledby="materialTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-bottom modal-dialog-centered modal-lg service-fee-custome-modal" id="modal-digi" role="document">
        <div class="modal-content charge-desc-popup">
            <div class="modal-header modal-header-mobile" style="display:block;">
                <h4>Additional Charge Fee Description</h4>
            <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            
            <div class="modal-body modal-mobile" style="max-height: 70vh; overflow-y: auto;">
                <div class="    ">
            <h6>{{ $subservice_service_fee_popup->additional_charge_popup }}</h6>
                </div>
            </div>
            <div class="modal-footer">
            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
        </div>
    </div>

<!--- Additional Charge Popup End ---->

<!--- Delivery Charge Popup Start ---->
 
    <div class="modal modal-mobile-bottom" id="delivery_charge_popup_{{$subservice_id}}"  tabindex="-1" aria-labelledby="materialTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-bottom modal-dialog-centered modal-lg service-fee-custome-modal" id="modal-digi" role="document">
        <div class="modal-content charge-desc-popup">
            <div class="modal-header modal-header-mobile" style="display:block;">
                <h4>Delivery Charge Description</h4>
            <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            
            <div class="modal-body modal-mobile" style="max-height: 70vh; overflow-y: auto;">
                <div class="    ">
            <h6>{{ $subservice_service_fee_popup->delivery_charge_popup }}</h6>
                </div>
            </div>
            <div class="modal-footer">
            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
        </div>
    </div>

<!--- Delivery Charge Popup End ---->

<!--- Timing Fee Popup Start ---->
 
    <div class="modal modal-mobile-bottom" id="timing_fee_popup_{{$subservice_id}}"  tabindex="-1" aria-labelledby="materialTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-bottom modal-dialog-centered modal-lg service-fee-custome-modal" id="modal-digi" role="document">
        <div class="modal-content charge-desc-popup">
            <div class="modal-header modal-header-mobile" style="display:block;">
             <h4>Timing Charge Description</h4>
            <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            
            <div class="modal-body modal-mobile" style="max-height: 70vh; overflow-y: auto;">
                <div>
            <h6>{{ $subservice_service_fee_popup->timing_fee_popup }}</h6>
                </div>
            </div>
            <div class="modal-footer">
            
            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
        </div>
    </div>

<!--- Timing Fee Popup End ---->

@php 
if($price_data != ''){
    $hourly_price = $price_data->hourly_price;
    $per_person_price = $price_data->per_person_price;
    $cleaning_material_price_per_hour = $price_data->cleaning_material_price_per_hour;
}else{
    $hourly_price = 0;
    $per_person_price = 0;
    $cleaning_material_price_per_hour = 0;
}
@endphp

<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

<script>


document.addEventListener('DOMContentLoaded', function () {
        new Splide('#type_of_home_slider_spatie', {
            type: 'slide',
            // perPage: 6,
            // gap: '1rem',
            autoplay: false,
            interval: 3000,
            pagination: false,
            arrows: false,
            breakpoints: {
			768: {
                    focus: 0,            // Start slide aligned left
            },
            },
        }).mount();
        });
		
		document.addEventListener('DOMContentLoaded', function () {
        new Splide('#size-of-home-slider-apartment', {
            type: 'slide',
            perPage: 6,
            // gap: '0.5rem',
            autoplay: false,
            interval: 3000,
            pagination: false,
            arrows: false,
            breakpoints: {
			768: {
                focus: 0,       
                arrows: true,
            },
            },
        }).mount();
        });

        document.addEventListener('DOMContentLoaded', function () {
        new Splide('#size-of-home-slider-villa', {
            type: 'slide',
            perPage: 8,
            // gap: '0.5rem',
            autoplay: false,
            interval: 3000,
            pagination: false,
            arrows: false,
            // fixedWidth: '13%',
            breakpoints: {
            768: {
                    focus: 0,            // Start slide aligned left
                    arrows: true,
            },
            },
        }).mount();
        });

document.addEventListener('DOMContentLoaded', function () {
    new Splide('#color_want_slider_spatie', {
        type: 'slide',
        // perPage: 6,
        // gap: '0.5rem',
        autoplay: false,
        pagination: false,
        arrows: false,
        breakpoints: {
            768: {
                 focus: 0,            // Start slide aligned left
            },
        },
    }).mount();
});

    document.addEventListener('DOMContentLoaded', function () {
    new Splide('#your_walls_now_slider_spatie', {
        type: 'slide',
        perPage: 6,
        // gap: '0.5rem',
        autoplay: false,
        interval: 3000,
        pagination: false,
        arrows: false,
        breakpoints: {
            768: {
                focus:0,
                 arrows: true,
            },
        },
    }).mount();
});


    document.addEventListener('DOMContentLoaded', function () {
    new Splide('#home_furnished_slider_spatie', {
        type: 'slide',
        perPage: 7,
        autoplay: false,
        pagination: false,
        arrows: false,
        breakpoints: {
            768: {
               
            },
        },
    }).mount();
});

    document.addEventListener('DOMContentLoaded', function () {
    new Splide('#ceilings_painted_slider_spatie', {
        type: 'slide',
        perPage: 7,
        autoplay: false,
        pagination: false,
        arrows: false,
        breakpoints: {
            768: {
            },
        },
    }).mount();
});

    document.addEventListener('DOMContentLoaded', function () {
    new Splide('#ceilings_painted_per_ceil_slider_spatie', {
        type: 'slide',
        perPage: 7,
        // gap: '3.5rem',
        autoplay: false,
        pagination: false,
        arrows: false,
        // fixedWidth: 50,
        breakpoints: {
            768: {
                arrows: true,
                 perPage: 3,
            },
        },
    }).mount();
});

    document.addEventListener('DOMContentLoaded', function () {
    new Splide('#how_many_rooms_painted_slider_spatie', {
        type: 'slide',
        perPage: 7,
        gap: '0.3rem',
        autoplay: false,
        pagination: false,
        arrows: true,
        // fixedWidth: 50,
        breakpoints: {
            768: {
                arrows: true,
                 perPage: 3,
            },
        },
    }).mount();
});

    document.addEventListener('DOMContentLoaded', function () {
    new Splide('#how_many_walls_painted_slider_spatie', {
        type: 'slide',
        perPage: 7,
        gap: '0.3rem',
        autoplay: false,
        pagination: false,
        arrows: true,
        // fixedWidth: 50,
        breakpoints: {
            768: {
                arrows: true,
                 perPage: 3,
            },
        },
    }).mount();
});

		
		

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
$(document).ready(function () {
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
  @if(Session::get('user') == "")
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

document.addEventListener("DOMContentLoaded", function () {
    const Otpphoneinput = document.querySelector("#user-phone-number");

    const Otpphoneinputnew = window.intlTelInput(Otpphoneinput, {
        initialCountry: "ae",  // UAE
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
    Otpphoneinput.addEventListener("countrychange", function () {
        setCountryCode();
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const Otpphoneinput = document.querySelector("#book_email_mobile");

    const Otpphoneinputnew = window.intlTelInput(Otpphoneinput, {
        initialCountry: "ae",  // UAE
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
    Otpphoneinput.addEventListener("countrychange", function () {
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
            beforeSend: function () {
                
				$('#spinner_button_phone_book1').show();
				$('#submit_button_phone_book1').hide();
                //$('.detail-continue-btn').prop('disabled', true);
            },
            success: function (response) {
                
                if(response.success === true){
                 
                $("#booknow_refresh_otp_div").load(location.href + " #booknow_refresh_otp_div");

                document.getElementById('booknow-step-phone').style.display = 'none';
                document.getElementById('booknow-step-otp').style.display = 'block';
                document.getElementById('modalStepTitle').innerText = "Verify your phone number";

                $('#booknow-whatsapp-number').text('+' + country_code  + mobile);
                
                if (response.user_data) {
                    $('#booknow_user_name').val(response.user_data.name);
                    $('#booknow_user_email').val(response.user_data.email);
                }

                }

				$('#spinner_button_phone_book1').hide();
				$('#submit_button_phone_book1').show();

                
            },
            error: function (xhr) {

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
            complete: function () {
                $('.detail-continue-btn').prop('disabled', false);
            }
        });

        return false;

       
    }

    // STEP 2: OTP Verification
    if (id == '2') {
        var allFilled = true;
        jQuery('.booknow-otp-input').each(function () {
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

        if(otp != enteredOtp){
            jQuery('#booknow_otp_error').html("OTP doesn't match");
            jQuery('#booknow_otp_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_otp_error').show().delay(2000).fadeOut('show');
            return false;
        }
        
      

        let name = jQuery("input[name='book_name']").val().trim();
        let email = jQuery("input[name='book_email']").val().trim();
		
		$('#spinner_button_phone_book2').show();
		$('#submit_button_phone_book2').hide();

        if (name !== '' && email !== '' ) {
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

$(document).ready(function () {
    $('.booknow-otp-input').on('input', function () {
        let input = $(this);
        let value = input.val();
        if (/^\d$/.test(value)) {
            input.next('.booknow-otp-input').focus();
        } else {
            input.val('');
        }
    });

    $('.booknow-otp-input').on('keydown', function (e) {
        let input = $(this);
        if (e.key === "Backspace" && input.val() === '') {
            input.prev('.booknow-otp-input').focus();
        }
    });

    $('.booknow-otp-input').on('paste', function (e) {
        let data = e.originalEvent.clipboardData.getData('text');
        let digits = data.replace(/\D/g, '').substring(0, 6).split('');
        $('.booknow-otp-input').each(function (index, element) {
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
            beforeSend: function () {
				
				$('#spinner_button_email_book1').show();
				$('#submit_button_email_book1').hide();
                
                //$('.email-detail-continue-btn').prop('disabled', true);
            },
            success: function (response) {
                
                if(response.success === true){
                 
					$("#book_email_refresh_otp_div").load(location.href + " #book_email_refresh_otp_div");

					document.getElementById('book-email-step-phone').style.display = 'none';
					document.getElementById('booknow-email-step-otp').style.display = 'block';
					document.getElementById('booknow_email_modalStepTitle').innerText = "Verify your Email";

					$('#book_email_address_model').text(email_email);
					
					if (response.user_data) {
						$('#book_email_name').val(response.user_data.name);
						$('#book_email_mobile').val(response.user_data.mobile);
						//$('#book_email_area').val(response.user_data.area);
						$('#country_code_book_popup_Modal_book').val(response.user_data.country_code);
					}

                }

                
            },
            error: function (xhr) {

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
            complete: function () {
				
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
        jQuery('.book-email-otp-input').each(function () {
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

        if(otp != enteredOtp){
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
        //var email_area = jQuery("input[name='book_email_area']").val().trim();

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

$(document).ready(function () {
    $('.book-email-otp-input').on('input', function () {
        let input = $(this);
        let value = input.val();
        if (/^\d$/.test(value)) {
            input.next('.book-email-otp-input').focus();
        } else {
            input.val('');
        }
    });

    $('.book-email-otp-input').on('keydown', function (e) {
        let input = $(this);
        if (e.key === "Backspace" && input.val() === '') {
            input.prev('.book-email-otp-input').focus();
        }
    });

    $('.book-email-otp-input').on('paste', function (e) {
        let data = e.originalEvent.clipboardData.getData('text');
        let digits = data.replace(/\D/g, '').substring(0, 6).split('');
        $('.book-email-otp-input').each(function (index, element) {
            $(element).val(digits[index] || '');
        });
        if (digits.length > 0) {
            $('.book-email-otp-input').eq(digits.length - 1).focus();
        }
        e.preventDefault();
    });
});

document.addEventListener('DOMContentLoaded', function () {
  const otpModal = document.getElementById('exampleModalLong');

  otpModal.addEventListener('shown.bs.modal', function () {
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
      document.getElementById(`spinner_button_phone_book${step}`).style.display = 'none';
      document.getElementById(`submit_button_phone_book${step}`).style.display = 'inline-block';
    });
    ['1', '2', '3'].forEach(step => {
      document.getElementById(`spinner_button_email_book${step}`).style.display = 'none';
      document.getElementById(`submit_button_email_book${step}`).style.display = 'inline-block';
    });
  });
});

$(document).ready(function(){
    $("#paint-individual-slider").owlCarousel({
        loop: false,          // Enables infinite looping
        margin: 10,          // Adjust the margin between items
        nav: false,
        dots:false,           // Show navigation buttons
        responsive: {
            0: {
                items: 4
            },
            600: {
                items: 4
            },
            1000: {
                items: 7
            }
        }
    });
});

$(document).ready(function(){
    $("#paint-individual-wall-slider").owlCarousel({
        loop: false,          // Enables infinite looping
        margin: 10,          // Adjust the margin between items
        nav: false,
        dots:false,           // Show navigation buttons
        responsive: {
            0: {
                items: 4
            },
            600: {
                items: 4
            },
            1000: {
                items: 7
            }
        }
    });
});



/* $(document).ready(function(){
    $("#size-of-home-slider").owlCarousel({
        loop: false,          // Enables infinite looping
        margin: 0,          // Adjust the margin between items
        nav: false,
        dots:false,           // Show navigation buttons
        responsive: {
            0: {
                items: 3
            },
            600: {
                items: 4
            },
            1000: {
                items: 6
            }
        }
    });
}); */
// $(document).ready(function(){
//     $("#your-walls-now-slider").owlCarousel({
//         loop: false,          // Enables infinite looping
//         margin: 0,          // Adjust the margin between items
//         nav: false,
//         dots:false,           // Show navigation buttons
//         responsive: {
//             0: {
//                 items: 3
//             },
//             600: {
//                 items: 4
//             },
//             1000: {
//                 items: 6
//             }
//         }
//     });
// });

// $(document).ready(function(){
//     $("#owl-carousel1").owlCarousel({
//         loop: false,          // Enables infinite looping
//         margin: 10,          // Adjust the margin between items
//         nav: false,
//         dots:false,           // Show navigation buttons
//         responsive: {
//             0: {
//                 items: 1
//             },
//             600: {
//                 items: 1
//             },
//             1000: {
//                 items: 1
//             }
//         }
//     });
// });
/* $("#user-phone-number").intlTelInput({
	initialCountry: "in",
	separateDialCode: true,
	 utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
}); */

/* document.ready(function(){
    
    calculationPaint();
}); */



function sizeOfHome(){
    var sizeOfHomeId;
    var typeOfHomeSizeLabel;
    if ($("input[name='type_of_home']:checked").val() == "2") {  // 2 is Apartment
        sizeOfHomeId = $("input[name='size_of_home_1']:checked").val();
        typeOfHomeSizeLabel = "Apartment - ";
    } else if ($("input[name='type_of_home']:checked").val() == "3") { // 3 is Villa
        sizeOfHomeId = $("input[name='size_of_home_2']:checked").val();
        typeOfHomeSizeLabel = "Villa - ";
    }
   
    $.ajax({
        type: 'POST',
        url: '{{ url('get-size-home-price') }}',
        data: {
            "_token": "{{ csrf_token() }}",
            'size_home_id': sizeOfHomeId,
        },
        success: function(responses) {
            //alert(responses);
            if(responses){
           
                var response_ajax = JSON.parse(responses);
                $("#size-of-home-label-size").html(response_ajax.size_of_home);
                $("#confirm-sizeHome-label").html(typeOfHomeSizeLabel + response_ajax.size_of_home);
                $("#size_of_home_price").val(response_ajax.price.toFixed(2));
                $("#selected_size_home").val(response_ajax.size_of_home);
                $("#frequency_summary_service_charge").html(response_ajax.price.toFixed(2));
                
                calculationNew();
            }
            
        }
    });
}



function newColor(colorType){

    

    var type_of_home = $("input[name='type_of_home']:checked").val();

    if(colorType == 1){
        var whatColornew = $("input[name='color_do_you_want_walls_painted']:checked").val() ? $("input[name='color_do_you_want_walls_painted']:checked").val() : "";
    }else{
        var whatColornew = $("input[name='what_color_your_walls_now']:checked").val() ? $("input[name='what_color_your_walls_now']:checked").val() : "";
    }

    if(type_of_home == 2){
        colorYouWantPaint = 1; 
        
    }else{
        colorYouWantPaint = 2; 
    }

    // alert(whatColornew);
    $.ajax({
            type: 'POST',
            url: '{{ url('get-color-painted-price') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                'color_you_want_paint_id': colorYouWantPaint,
                'color_type' : whatColornew
            },
            success: function(responses) {
                if(responses){
                    let floatPrice = parseFloat(responses);
                   // alert(floatPrice);
                    if(colorType == 1){
                        
                        $("#color_you_want_painted_price").val(floatPrice.toFixed(2));
                        $("#selected_you_want_color_name").val(whatColornew);
                    }else{

                        $("#color_your_walls_now_price").val(floatPrice.toFixed(2));
                        $("#selected_your_walls_now_name").val(whatColornew);
                    }
                    
                    calculationNew();
                }
            }
    });

}

function homeFurnished(){
    var isYourHomeFurnshed =  $("input[name='isYourHomeFurnshed']:checked").val(); 
    // alert(isYourHomeFurnshed);
    // return false;

    var type_of_home = $("input[name='type_of_home']:checked").val();

    if(type_of_home == 2){
        isYourHomeFurnishedFlag = 3; 
    }else{
        isYourHomeFurnishedFlag = 4; 
    }

    if(isYourHomeFurnshed == 'Yes'){
            $.ajax({
            type: 'POST',
            url: '{{ url('get-home-furnished-price') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                'is_your_home_furnished_flg': isYourHomeFurnishedFlag,
                'home_furnished_val': ""
            },
            success: function(responses) {

                let furnishedPrice = parseFloat(responses);

                $("#selected_home_furnished_price").val(furnishedPrice.toFixed(2));
                $("#furnished-label").html("Yes");
                $("#confirm-furnished-label").html("Yes");
                calculationNew();

            }
        });
    }else{
        $("#selected_home_furnished_price").val('0');
        $("#furnished-label").html("No");
        $("#confirm-furnished-label").html("No");
        calculationNew();
    } 
}

function isCeilingPainted(){

        let noOfCeilings;
        let selectedCeilingPrice;
        let sumofAdditionalChrgCeiling;

        if ($("input[name='do_you_need_ceiling_painted']:checked").val() == "1") { // ceiling option show if selected Yes
            $("#ceilngs-painting-costs").show();
            noOfCeilings = $("input[name='per_ceiling_costs']:checked").val();
        
            // Check if 'noOfCeilings' is valid and between 1-5
            if (noOfCeilings >= 1 && noOfCeilings <= 5) {
                selectedCeilingPrice = noOfCeilings * 125; // Calculate price for ceilings

                // alert(selectedCeilingPrice);
                $("#selected_ceiling_price").val(selectedCeilingPrice);
                $("#selected-ceilings-label").html(noOfCeilings);
                $("#confirm-ceilings-label").html(noOfCeilings);
                $("#no_of_ceilings").val(noOfCeilings);
                
                $(".confirm-ceilings-label-add-c").removeClass('selected-ceilings-label-display');
                calculationNew();
            }

        } else if ($("input[name='do_you_need_ceiling_painted']:checked").val() == "0") { 
            $("#ceilngs-painting-costs").hide();

            $("#selected_ceiling_price").val('0');
            $(".confirm-ceilings-label-add-c").addClass('selected-ceilings-label-display');
            calculationNew();
        }

}


function calculationNew(){

    //alert('calculationNew');
    displayDiscountPrice();
    let noOfCeilings;

    if ($("input[name='do_you_need_ceiling_painted']:checked").val() == "1") { // ceiling option show if selected Yes
        $("#ceilngs-painting-costs").show();
        noOfCeilings = $("input[name='per_ceiling_costs']:checked").val();
    } else if ($("input[name='do_you_need_ceiling_painted']:checked").val() == "0") { // ceiling option hide if selected No
        $("#ceilngs-painting-costs").hide();
        noOfCeilings = "";
    }
    let additionalSubTotal = 0;

    var size_of_home_price = $("#size_of_home_price").val();
    var color_you_want_painted_price = $("#color_you_want_painted_price").val();
    var color_your_walls_now_price = $("#color_your_walls_now_price").val();
    var selected_home_furnished_price = $("#selected_home_furnished_price").val();
    var hidden_subtotal_price = $("#hidden_subtotal_price").val();
    var selected_ceiling_price = $("#selected_ceiling_price").val();
    var cod_charge_new = $("#cod_charge_new").val();
    // alert(cod_charge_new);
    var service_fee = $("#service_fee").val();
    
    var hidden_discount_price = $("#hidden_discount_price").val();
    var timing_charge = $("#timing_charge").val();
    var weekly_off_charge = $("#weekly_off_charge").val();

    var selected_you_want_color_name = $("#selected_you_want_color_name").val();
    var selected_your_walls_now_name = $("#selected_your_walls_now_name").val();
    
    if(selected_you_want_color_name == selected_your_walls_now_name){

        var additionalCharge = parseFloat(selected_home_furnished_price) + parseFloat(selected_ceiling_price);
        $(".additional-charges-label").addClass("additional-charges-display");
        colorsLabelDisplay();

    }else if(color_you_want_painted_price != 0 && color_your_walls_now_price == 0){
        $(".additional-charges-label").removeClass("additional-charges-display");
        var additionalCharge = parseFloat(selected_home_furnished_price) + parseFloat(color_you_want_painted_price);
    
    }else{
        colorsLabelDisplay();

        $(".additional-charges-label").removeClass("additional-charges-display");
        var additionalCharge = parseFloat(selected_home_furnished_price) + parseFloat(color_your_walls_now_price) + parseFloat(selected_ceiling_price) + parseFloat(timing_charge) + parseFloat(weekly_off_charge);
    }

    if(selected_home_furnished_price > 0){
        var additionalCharge = parseFloat(selected_home_furnished_price) + parseFloat(selected_ceiling_price);
       // alert(additionalCharge);
        $(".additional-charges-label").removeClass("additional-charges-display");
    }

    let sub_total = parseFloat(hidden_subtotal_price) + parseFloat(additionalCharge);


   /* var service_charge = $('#size_of_home_price').val();
    var additional_charge = $('#additional_charge_price').val();
    var cod_charge = $('#cod_charge_new').val();
    var service_fee = $('#service_fee').val();
    var timing_charge = $('#timing_charge').val();
    var promo_discount = $('#hidden_discount_price').val(); */

    //var sub_total = parseInt(percleanprice) + parseInt(additional_charge) + parseInt(timing_charge) + parseInt(cod_charge) - parseInt(discount_amount);

    var sub_total_new = parseInt(size_of_home_price) + parseInt(additionalCharge) - parseInt(hidden_discount_price) + parseInt(cod_charge_new) + parseFloat(timing_charge) + parseFloat(weekly_off_charge);

    //alert(sub_total);

    var vat_total = sub_total_new * 5 /100;

    let get_vat_amount = $("#hidden_vat_charge_price").val();
    //alert(parseFloat(get_vat_amount));
    let cross_total = parseInt(size_of_home_price) + parseFloat(additionalCharge) ;
    // alert("Total Of Service "+ cross_total);
    let cross_total_vat_plus = parseFloat(cross_total) * 5 /100;

    // alert("Total Of vat "+ cross_total_vat_plus);
    let cross_total_price = parseFloat(cross_total) + parseFloat(cross_total_vat_plus);

    // alert("Total Of final cross "+ cross_total_price);
    
    var total_to_pay = sub_total_new + vat_total;
   /* var vat_total = (sub_total) * 5/100;
    var total_to_pay = sub_total + vat_total;*/

    $("#cross_amount").html(parseFloat(cross_total_price).toFixed(2));
    $("#vat_charge_replace").html(parseFloat(vat_total).toFixed(2));
    $("#vat_charge_replace_mobile").html(parseFloat(vat_total).toFixed(2));
    $("#hidden_vat_charge_price").val(parseFloat(vat_total).toFixed(2));
    $("#total_to_pay_charge_replace").html(parseFloat(total_to_pay).toFixed(2));
    $("#sub_total_replace_mobile").html(parseFloat(sub_total_new).toFixed(2));
    $("#total_to_pay_charge_price").val(parseFloat(total_to_pay).toFixed(2));
    $("#frequency_summary_cross_amount_mobile").html(parseFloat(cross_total_price).toFixed(2));
    $("#total_to_pay_charge_replace_mobile").html(parseFloat(total_to_pay).toFixed(2));

    $("#sub_total_replace").html(parseFloat(sub_total_new).toFixed(2));
    $("#hidden_subtotal_price").val(parseFloat(sub_total_new).toFixed(2));

    let additionChargeNo = parseFloat(additionalCharge);

    let cod_charge = $("#cod_charge_new").val();
    // alert(cod_charge);
    $("#additional_charge_price").val(additionChargeNo.toFixed(2));
    $("#additional_charge_replace").html(additionChargeNo.toFixed(2));

     if (parseFloat(additionChargeNo) !== 0) {
            $('#additional_charge_wrapper').show();
            $('#additional_charge_wrapper_mobile').show();
        }else{
            $('#additional_charge_wrapper').hide();
            $('#additional_charge_wrapper_mobile').hide();
        } 
    $("#additional_charge_replace_mobile").html(additionChargeNo.toFixed(2));
    $("#frequency_summary_addtional_charge").html(additionChargeNo.toFixed(2));
    $("#service_charge_replace").html(size_of_home_price);
    $("#service_charge_replace_mobile").html(size_of_home_price);


    $('#frequency_summary_cod_charge').html(parseFloat(cod_charge).toFixed(2));
    $('#cod_charge_replace').html(parseFloat(cod_charge).toFixed(2));
    $('#cod_charge_replace_mobile').html(parseFloat(cod_charge).toFixed(2));

    var total_timing_charge = parseFloat(timing_charge) + parseFloat(weekly_off_charge);

    $('#timing_charge_replace').html(parseFloat(total_timing_charge).toFixed(2));
    $('#timing_charge_replace_mobile').html(parseFloat(total_timing_charge).toFixed(2));

     if (parseFloat(total_timing_charge) !== 0) {
                $('#timing_charge_wrapper').show();
                $('#timing_charge_wrapper_mobile').show();
    }else{
        $('#timing_charge_wrapper').hide();
        $('#timing_charge_wrapper_mobile').hide();
    } 
    if (parseFloat(cod_charge) !== 0) {
        $('#cod_charge_wrapper').show();
        $('#cod_charge_wrapper_mobile').show();
    }else{
        $('#cod_charge_wrapper').hide();
        $('#cod_charge_wrapper_mobile').hide();
    } 
    if(total_timing_charge > 0){
        $('.timing_charge_replace_div').attr('style', 'display: flex !important');
    } else {
        $('.timing_charge_replace_div').attr('style', 'display: none !important');
    }

    
    if(additionChargeNo > 0){
        $('.additional_charge_replace_div').attr('style', 'display: flex !important');
    } else {
        $('.additional_charge_replace_div').attr('style', 'display: none !important');
    }

    if(cod_charge > 0){
        $('.cod_charge_replace_div').attr('style', 'display: flex !important');
    } else {
        $('.cod_charge_replace_div').attr('style', 'display: none !important');
    }

    
}

function colorsLabelDisplay(){

    var selectedColor1 =  $("input[name='color_do_you_want_walls_painted']:checked").val();
    var selectedColor2 = $("input[name='what_color_your_walls_now']:checked").val();

    // alert(selectedColor1);
    // alert(selectedColor2);

    if(selectedColor1 && selectedColor2){
        var parts = selectedColor1.split("-");
        var parts2 = selectedColor2.split("-");

        for (var i = 0; i < parts.length; i++) {
            parts[i] = parts[i].charAt(0).toUpperCase() + parts[i].slice(1);
        }
        for (var i = 0; i < parts2.length; i++) {
            parts2[i] = parts2[i].charAt(0).toUpperCase() + parts2[i].slice(1);
        }
        selectedColor1 = parts.join("-");
        selectedColor2 = parts2.join("-");

        var toColor = selectedColor1.charAt(0).toUpperCase() + selectedColor1.slice(1); // Capitalize the first letter
        var fromColor = selectedColor2.charAt(0).toUpperCase() + selectedColor2.slice(1); // Capitalize the first letter

        let colorToColor = fromColor + ' to ' + toColor;
        // alert(colorToColor);
        $(".selected-color-label-display").removeClass('selected-color-label-display');
        $("#selected-color-label").html(colorToColor);
        $("#confirm-colors-label").html(colorToColor);
   }

}

function displayDiscountPrice(){
    let subtotal = 0;
    let serviceChargeDiscount =  @json($painting_dis_price);
    let sizeOfHomePrice = $("#size_of_home_price").val();
    //alert(sizeOfHomePrice);
    if (serviceChargeDiscount && serviceChargeDiscount.promo_discount !== null && serviceChargeDiscount.promo_discount > 0) {          
        var discount_type = serviceChargeDiscount.discount_type;
        var discount = serviceChargeDiscount.promo_discount;
        var discount_amount = 0; // Default to 0

       // alert(discount);
        if (serviceChargeDiscount.discount_type == 1) {

            //percentange
            discount_amount = parseFloat(sizeOfHomePrice) * (parseFloat(discount) / 100);
            
        } else if (serviceChargeDiscount.discount_type == 0) {
            //price
            discount_amount = parseFloat(discount);
        }

        let final_price = parseFloat(sizeOfHomePrice) - discount_amount;
        $("#promo_dicount_replace").html(final_price.toFixed(2)); //DisJs
        $("#hidden_discount_price").val(discount_amount.toFixed(2)); //DisJs
        

        subtotal = parseFloat(sizeOfHomePrice) - discount_amount;
    } else {
        // No valid discount, just set the original price
        subtotal = parseFloat(sizeOfHomePrice);
        $("#promo_dicount_replace").html(parseFloat(sizeOfHomePrice).toFixed(2));
    }
    // Calculate subtotal after applying discount

    $("#promo_dicount_replace_new").html(discount_amount);
    $("#sub_total_replace").html(subtotal);
    $("#hidden_subtotal_price").val(subtotal);

    if(discount_amount > 0){
        $('.promo_dicount_replace_new_div').attr('style', 'display: flex !important');
    } else {
        $('.promo_dicount_replace_new_div').attr('style', 'display: none !important');
    }
}

function calculationOfCeiling(){
    let noOfCeilings;
    let selectedCeilingPrice;
    let sumofAdditionalChrgCeiling;

    if ($("input[name='do_you_need_ceiling_painted']:checked").val() == "1") { // ceiling option show if selected Yes
        $("#ceilngs-painting-costs").show();
        noOfCeilings = $("input[name='per_ceiling_costs']:checked").val();
        // alert(noOfCeilings);
    } else if ($("input[name='do_you_need_ceiling_painted']:checked").val() == "0") { // ceiling option hide if selected No
        $("#ceilngs-painting-costs").hide();
        noOfCeilings = "";
    }

    let sumOfSubTotalCeilingPrice = hidded_selected_color_price + hidded_selected_furnished_price;
    let addtionalChargeLast = parseFloat($("#additional_charge_price").val()) || 0; // Ensure it is a valid number

    // Check if 'noOfCeilings' is valid and between 1-5
    if (noOfCeilings >= 1 && noOfCeilings <= 5) {
        selectedCeilingPrice = noOfCeilings * 125; // Calculate price for ceilings
        
        sumofAdditionalChrgCeiling = sumOfSubTotalCeilingPrice + selectedCeilingPrice;
        // alert(sumofAdditionalChrgCeiling);
        // Update the DOM elements
        $("#additional_charge_price").val(sumofAdditionalChrgCeiling.toFixed(2));
        $("#additional_charge_replace").html(sumofAdditionalChrgCeiling.toFixed(2));
    }
}

function no_of_rooms_paint(element){
    $("#no-of-paint-rooms-label").html(element);
   $("#confirm-get-quote-rooms-label").html(element);
}

function no_of_walls_paint(element){
    $("#no-of-paint-walls-label").html(element);
    $("#confirm-get-quote-walls-label").html(element);
}



(function(){
   //Show Modal
  $('#exampleModalLong').on('show.bs.modal', function (e) {
    console.log('show');
    $('.firstBlur').addClass('modalBlur');
    $('body').addClass('modal-open');
  })
  
  //Remove modal
  $('#exampleModalLong').on('hide.bs.modal', function (e) {
     console.log('hide');
    $('.firstBlur').removeClass('modalBlur');
    $('body').removeClass('modal-open');
  })
})();

    function type_of_homeFun(typeVal){

        if(typeVal == 1){
            $("#size-of-home-label-type").html('Apartment');
            $("#selected_type_home").val('Apartment');
            $("#size-of-home-label-size").html('Studio');
            $(".size-of-home-tab1").show();
            $(".size-of-home-tab2").hide();
            sizeOfHome();
        }else{
            $("#size-of-home-label-type").html('Villa');
            $("#selected_type_home").val('Villa');
            $("#size-of-home-label-size").html('2BR');
            $('.size-of-home-tab2').show();
            $(".size-of-home-tab1").hide();
            sizeOfHome();
        }
    }

    function paintingServices(element){
        if(element === "Move in / Move Out Painting"){
            calculationNew();
            sizeOfHome();
            // alert(element);
            $("#service-label").html(element);
            $("#confirm-service-label").html(element);
            $("#type_of_painting").val(element);
            $("#is_book_or_quote").val("booking");
            $("#movingOptionTab").show();
            $("#movingOptionTab2").hide();
            $("#movingOptionTab1").hide();
            $(".moving-in-out-painting-show").removeClass("moving-in-out-painting-show");
            $(".summary-movein-out-service-hide").removeClass("summary-movein-out-service-show");
            $(".mobile-total-price-show").removeClass("mobile-total-price-btn");
            $(".summary-paint-rooms-show").addClass("summary-paint-rooms-hide");
            $(".summary-paint-walls-show").addClass("summary-paint-walls-hide");

            $(".qoute-summary-rooms-show").addClass("qoute-summary-rooms");
            $(".qoute-summary-show").addClass("qoute-summary-walls");


        }else if(element === "Custom Home Painting"){
            $("#service-label").html(element);
            $("#is_book_or_quote").val("get-quote");
            $("#confirm-service-label").html(element);
            $("#confirm-get-quote-service-label").html(element);
            $("#type_of_painting").val(element);
            $("#movingOptionTab1").show();
            $("#movingOptionTab").hide();
            $("#movingOptionTab2").hide();
            $(".moving-in-out-painting-hide").addClass("moving-in-out-painting-show");
            $(".summary-movein-out-service-hide").addClass("summary-movein-out-service-show");
            $(".summary-paint-rooms-show").addClass("summary-paint-rooms-hide");
            $(".summary-paint-walls-show").addClass("summary-paint-walls-hide");
            $(".mobile-total-price-show").addClass("mobile-total-price-btn");

            $(".qoute-summary-rooms-show").addClass("qoute-summary-rooms");
            $(".qoute-summary-show").addClass("qoute-summary-walls");

        }else if(element === "Paint individual rooms"){
            $("#service-label").html(element);
            $("#is_book_or_quote").val("get-quote");
            $("#confirm-service-label").html(element);
            $("#confirm-get-quote-service-label").html(element);
            $("#type_of_painting").val(element);
            $("#movingOptionTab2").show();
            $("#movingOptionTab1").hide();
            $("#movingOptionTab4").hide(); // walls rooms paint
            $("#movingOptionTab").hide();
            $(".moving-in-out-painting-hide").addClass("moving-in-out-painting-show");
            $(".summary-movein-out-service-hide").addClass("summary-movein-out-service-show");
            $(".summary-paint-rooms-show").removeClass("summary-paint-rooms-hide");
            $(".mobile-total-price-show").addClass("mobile-total-price-btn");

            $(".qoute-summary-rooms-show").removeClass("qoute-summary-rooms");
            $(".qoute-summary-show").addClass("qoute-summary-walls");

        }else if(element === "Paint individual walls"){
            $("#service-label").html(element);
            $("#confirm-service-label").html(element);
            $("#is_book_or_quote").val("get-quote");
            $("#confirm-get-quote-service-label").html(element);
            $("#type_of_painting").val(element);
            $("#movingOptionTab2").hide();
            $("#movingOptionTab4").show(); // walls rooms paint
            
            $("#movingOptionTab1").hide();
            $("#movingOptionTab").hide();
            $(".moving-in-out-painting-hide").addClass("moving-in-out-painting-show");
            $(".summary-movein-out-service-hide").addClass("summary-movein-out-service-show");
            $(".summary-paint-rooms-show").addClass("summary-paint-rooms-hide");
            $(".summary-paint-walls-show").removeClass("summary-paint-walls-hide");
            $(".mobile-total-price-show").addClass("mobile-total-price-btn");

            $(".qoute-summary-rooms-show").addClass("qoute-summary-rooms");
            $(".qoute-summary-show").removeClass("qoute-summary-walls");
            
            
        }else if(element === "Office Painting"){
            $("#service-label").html(element);
            $("#confirm-service-label").html(element);
            $("#is_book_or_quote").val("get-quote");
            $("#confirm-get-quote-service-label").html(element);
            $("#type_of_painting").val(element);
            $("#movingOptionTab2").hide();
            $("#movingOptionTab4").hide();
            
            $("#movingOptionTab1").hide();
            $("#movingOptionTab").hide();
            $(".moving-in-out-painting-hide").addClass("moving-in-out-painting-show");
            $(".summary-movein-out-service-hide").addClass("summary-movein-out-service-show");
            $(".summary-paint-rooms-show").addClass("summary-paint-rooms-hide");
            $(".summary-paint-walls-show").addClass("summary-paint-walls-hide");
            $(".mobile-total-price-show").addClass("mobile-total-price-btn");

            $(".qoute-summary-rooms-show").addClass("qoute-summary-rooms");
            $(".qoute-summary-show").addClass("qoute-summary-walls");
            
        }else if(element === "Exterior Painting"){
            $("#service-label").html(element);
            $("#confirm-service-label").html(element);
            $("#is_book_or_quote").val("get-quote");
            $("#confirm-get-quote-service-label").html(element);
            $("#type_of_painting").val(element);
            $("#movingOptionTab2").hide();
            $("#movingOptionTab4").hide();
            
            $("#movingOptionTab1").hide();
            $("#movingOptionTab").hide();
            $(".moving-in-out-painting-hide").addClass("moving-in-out-painting-show");
            $(".summary-movein-out-service-hide").addClass("summary-movein-out-service-show");

            $(".summary-paint-rooms-show").addClass("summary-paint-rooms-hide");
            $(".summary-paint-walls-show").addClass("summary-paint-walls-hide");
            $(".mobile-total-price-show").addClass("mobile-total-price-btn");

            $(".qoute-summary-rooms-show").addClass("qoute-summary-rooms");
            $(".qoute-summary-show").addClass("qoute-summary-walls");
            
        }else{
            $("#movingOptionTab").hide();
            $("#movingOptionTab1").hide();
            $("#movingOptionTab2").hide();
            $("#movingOptionTab3").hide();  
            $("#movingOptionTab4").hide();          
        }
        
    }

    function doYouNeedCeilingsPainted(element){
        if(element === true){
            $("#ceilngs-painting-costs").show();
        }else{
            $("#ceilngs-painting-costs").hide();
        }
    }



        $("input[name='which_day_of_the_week_do_you_want_the_service[]']").on("change", function() {
            var selectedDays = [];
            $("input[name='which_day_of_the_week_do_you_want_the_service[]']:checked").each(function() {
                selectedDays.push($(this).val());
            });
            var selectedDaysStr = selectedDays.join(', ');
            $('#frequency_days_left_summary_replace').html(selectedDaysStr);
            //alert('Selected Days: ' + selectedDaysStr);
        });

        $("input[name='payment_type_old']").on("change", function() {
            var selectedValue = $("input[name='payment_type_old']:checked").val();
            $('#payment_type_new').val(selectedValue);

            if(selectedValue == 'COD'){
                var charge_payment = 5;
            }else{
                var charge_payment = 0;
            }   
        //    / alert(charge_payment);
            $('#cod_charge_new').val(charge_payment);

            @php 
    if($subservice_id == 30 || $subservice_id == 28 || $subservice_id == 47){
        @endphp
    calculationNew();
    @php 
    }else{
    @endphp
    calculation_book_now();
     @php 
    }
    @endphp
            //alert('Selected Payment Type: ' + selectedValue);
        });

       


    function cleaning_change(value){
        // alert(value);
        // if(value == "Weekly"){
            
        // }else{
            
        // }
        

        if(value == 'Multiple times a week'){
            // alert('in');
            $('#selected_weekly').text('For first visit only');
            $("#weekly_div").css("display", "block");
            $("#frequency_left_summary_div").attr("style", "display: flex !important;");
        }else{
            // alert('out');
            $('#selected_weekly').text('');
            $("#weekly_div").css("display", "none");
            $("#frequency_left_summary_div").attr("style", "display: none !important;");
            $("input[name='which_day_of_the_week_do_you_want_the_service[]']").prop('checked', false);
            
        }

        
        $('#frequency_left_summary_replace').html(value);

        calculation();
    }

    function calculation(){
        const radios_1 = document.getElementsByName('how_many_cleaners_do_you_need');
        let how_many_cleaners_do_you_need_value = '';

        for (let i = 0; i < radios_1.length; i++) {
            if (radios_1[i].checked) {
                how_many_cleaners_do_you_need_value = radios_1[i].value;
                break;
            }
        }

        const radios_2 = document.getElementsByName('how_many_hours_should_they_stay');
        let how_many_hours_should_they_stay_value = '';

        for (let i = 0; i < radios_2.length; i++) {
            if (radios_2[i].checked) {
                how_many_hours_should_they_stay_value = radios_2[i].value;
                break;
            }
        }

        var service_id = '{{ $subservice_id }}';


        $.ajax({

            type: 'POST',
            url: '{{ url('get_price_cleaning ') }}',
            data: {

                "_token": "{{ csrf_token() }}",
                'service_id': service_id,
                'how_many_hours_should_they_stay_value': how_many_hours_should_they_stay_value,

            },

            success: function(msg) {

                var response_ajax = JSON.parse(msg);

                if (response_ajax.status === 'success') {
                   var hour_charge_db = response_ajax.hour_price;
                   var cleaning_material_charge_db = response_ajax.cleaning_material_price_per_hour;

                   $('#hour_charge_db').val(hour_charge_db);
                   $('#cleaning_material_charge_db').val(cleaning_material_charge_db);


                   var no_of_cleaners = how_many_cleaners_do_you_need_value;
                   var no_of_hours = how_many_hours_should_they_stay_value;

                   var calchrs = parseInt(no_of_hours);
                   if(calchrs > 0){
                        var calprice = calchrs * hour_charge_db;
                   }else{
                        var calprice = 0;
                   }

                   var percleanprice = (parseInt(calprice)) * no_of_cleaners;

                    const radios_3 = document.getElementsByName('do_you_need_cleaning_material');
                    let do_you_need_cleaning_material_value = '';

                    for (let i = 0; i < radios_3.length; i++) {
                        if (radios_3[i].checked) {
                            do_you_need_cleaning_material_value = radios_3[i].value;
                            break;
                        }
                    }
                    if(do_you_need_cleaning_material_value == 'No'){
                        var additional_charge = 0;
                    }else{
                        var additional_charge = (no_of_hours * cleaning_material_charge_db) * no_of_cleaners ;
                    }

                    
                    

                    if(response_ajax.promo_discount != 'null' && response_ajax.promo_discount > 0){

                        var discount = response_ajax.promo_discount;

                        if(response_ajax.promo_discount_type == 1){

                            var discount_amount = (percleanprice) * discount/100;

                        }else if(response_ajax.promo_discount_type == 0){
                            var discount_amount = parseInt(discount);
                        }else{
                            var discount_amount = 0;
                        }
                        // var promo_discount = 15;
                    }else{
                        var discount_amount = 0;
                    }

                    discount_amount = Math.round(discount_amount);

                    

                    var how_often_do_you_need_cleaning = $('input[name="how_often_do_you_need_cleaning"]:checked').val();

                    if(how_often_do_you_need_cleaning == 'Weekly'){


                        var discount_percentage_new = '{{$weekly_discout_1}}';
            
                        var cleaning_discount = '{{$weekly_discout_1}}';
                        var cleaning_discount_amount =(percleanprice) * cleaning_discount/100;
                        var percleanprice_new = parseInt(percleanprice) - parseInt(cleaning_discount_amount);

                        // var crossprice_discount = percleanprice * 5/100;
                        // var crossprice = percleanprice + crossprice_discount;

                        var cleaning_discount_additional =(additional_charge) * cleaning_discount/100;
                        // alert(additional_charge);
                        var additional_charge_new = parseInt(additional_charge) - parseInt(cleaning_discount_additional);
                        


                    }else if(how_often_do_you_need_cleaning == 'Multiple times a week'){

                        var cleaning_discount = '{{$multiple_time_week_discout_1}}';
                        var cleaning_discount_amount =(percleanprice) * cleaning_discount/100;
                        var percleanprice_new = parseInt(percleanprice) - parseInt(cleaning_discount_amount);

                        var discount_percentage_new = '{{$multiple_time_week_discout_1}}';

                        // var crossprice_discount = percleanprice * 5/100;
                        // var crossprice = percleanprice + crossprice_discount;

                        var cleaning_discount_additional =(additional_charge) * cleaning_discount/100;
                        var additional_charge_new = parseInt(additional_charge) - parseInt(cleaning_discount_additional);

                    }else{
                        var cleaning_discount = 0;
                        var cleaning_discount_amount = 0;
                        var cleaning_discount_additional = 0;
                        var percleanprice_new = parseInt(percleanprice) - parseInt(cleaning_discount_amount);
                        var discount_percentage_new = 0;
                        var additional_charge_new = parseInt(additional_charge) - parseInt(cleaning_discount_additional);
                    }

                  
                    var timing_charge = $('#timing_charge').val();
                    var weekly_off_charge = $('#weekly_off_charge').val();

                    var cod_charge = $('#cod_charge').val();
                    
                    // sub_total = parseInt(sub_total) - parseInt(cleaning_discount_amount);
                    // alert(additional_charge);
                    var sub_total = parseInt(percleanprice_new) + parseInt(additional_charge_new) + parseInt(timing_charge) + parseInt(weekly_off_charge) + parseInt(cod_charge) - parseInt(discount_amount);

                    // alert(cod_charge);

                    var vat_total = (sub_total) * 5/100;

                    var service_fee = parseFloat($('#service_fee').val()) 

                    //  console.log(service_fee); // Check the result

                    var total_to_pay = sub_total + vat_total;

                    var percleanprice_new1 =parseFloat(percleanprice_new).toFixed(2);
                    var discount_amount =parseFloat(discount_amount).toFixed(2);
                    var additional_charge_new1 =parseFloat(additional_charge_new).toFixed(2);
                    var timing_charge =parseFloat(timing_charge).toFixed(2);
                    var cod_charge =parseFloat(cod_charge).toFixed(2);
                    var sub_total =parseFloat(sub_total).toFixed(2);
                    var vat_total =parseFloat(vat_total).toFixed(2);
                    var cross_price =parseFloat(crossprice).toFixed(2);
                    var total_to_pay =parseFloat(total_to_pay).toFixed(2);

                    var vat_amount = parseFloat(percleanprice)*5/100;

                    var crossprice_discount = parseInt(percleanprice)*discount_percentage_new /100;

                    var additional_charge_discount = parseInt(additional_charge)*discount_percentage_new /100;

                    // alert(additional_charge);

                    var crossprice_new = parseInt(sub_total) + parseInt(crossprice_discount) + parseFloat(discount_amount) + parseFloat(vat_amount) + Math.round(additional_charge_discount);

                 
                    var crossprice = parseFloat(percleanprice_new1).toFixed(2);

                    // alert(crossprice_discount);
                    // alert(percleanprice);
                    // alert(vat_amount);
                    // alert(crossprice);
                   
                    var dateSelected = $('#date').val();
                    var monthSelected = $('#month').val();
                    var currentDate = new Date();
                    var currentYear = currentDate.getFullYear();
                    var date = dateSelected + ' ' + monthSelected + ' ' + currentYear; 
                    // $('#frequency_summary_date').html(date); 


                    var time_slotSelected = document.querySelector('input[name="time_slot"]:checked');
                    //var selectedName = time_slotSelected.getAttribute('data-name');
                    // $('#frequency_summary_timeslot').html(selectedName);

                    
                    // $('#frequency_summary_address').html(address); 

                    // var service_fee = $('#service_fee').val();


                    $('#cleaner_replace').html(no_of_cleaners);
                    $('#material_left_summary_replace').html(do_you_need_cleaning_material_value);
                    $('#hour_replace').html(no_of_hours);
                    $('#service_charge_replace').html(percleanprice_new1);
                    $('#service_charge_replace_mobile').html(percleanprice_new1);
                    $('#frequency_summary_cross_amount_mobile').html(percleanprice_new1);
                    //$('#date_replace').html(date);
                    $('#cross_amount').html(crossprice);
                    $('#promo_dicount_replace').html(discount_amount);
                    $('#promo_dicount_replace_mobile').html(discount_amount);
                    $('#additional_charge_replace').html(additional_charge_new1);
                    $('#sub_total_replace').html(sub_total);
                    $('#sub_total_replace_mobile').html(sub_total);
                    $('#vat_charge_replace').html(vat_total);
                    $('#vat_charge_replace_mobile').html(vat_total);
                    $('#total_to_pay_charge_replace').html(total_to_pay);
                    $('#total_to_pay_charge_replace_mobile').html(total_to_pay);
                    // $('#service_fee_replace_charge_mobile').html(service_fee);

                    var total_timing_charge = parseFloat(timing_charge) + parseFloat(weekly_off_charge);

                    $('#timing_charge_replace').html(total_timing_charge);
                    $('#timing_charge_replace_mobile').html(total_timing_charge);
                    $('#frequency_timing_charge_replace').html(total_timing_charge);

                    $('#cod_charge_replace').html(cod_charge);
                    $('#cod_charge_replace_mobile').html(cod_charge);
                    $('#frequency_cod_charge_replace').html(cod_charge);

                    $('#service_charge').val(percleanprice_new1);
                    $('#promo_discount').val(discount_amount);
                    $('#cleaning_discount_additional').val(cleaning_discount_additional);
                    $('#additional_charge').val(additional_charge_new1);
                    $('#sub_total').val(sub_total);
                    $('#vat_total').val(vat_total);
                    $('#total_to_pay').val(total_to_pay);

                    if(additional_charge_new1 > 0){
                        $('.additional_charge_replace_div').attr('style', 'display: flex !important');
                    } else {
                        $('.additional_charge_replace_div').attr('style', 'display: none !important');
                    }


                    if(total_timing_charge > 0){
                        $('.timing_charge_replace_div').attr('style', 'display: flex !important');
                    } else {
                        $('.timing_charge_replace_div').attr('style', 'display: none !important');
                    }

                    if(cod_charge > 0){
                        $('.cod_charge_replace_div').attr('style', 'display: flex !important');
                    } else {
                        $('.cod_charge_replace_div').attr('style', 'display: none !important');
                    }


                  
                //    alert(percleanprice_new1);
                //    alert(additional_charge_new1);
                }
            }
        });

    }

    function timeslot_price(price,name){

        $('#time_replace').html(name);
        $('#get-quote-summary-time').html(name);
        $('#frequency_summary_timeslot').html(name);
        $('#timing_charge').val(price);
        @php 
            if($subservice_id == 30 || $subservice_id == 28 || $subservice_id == 47){
        @endphp
            calculationNew();
        @php 
            }else{
        @endphp
            calculation_book_now();
        @php 
            }
        @endphp 
    }
@php 
    if($subservice_id == 30 || $subservice_id == 28){
        @endphp
    window.onload = calculation;
    @php 
    }

    if($subservice_id == 29){
        @endphp
    window.onload = calculation_book_now;
    @php 
    }
   @endphp

   function calculation_book_now(){

    //alert('here');

    @php
        $subtotal = 0;
        if (Cart::count() > 0){

            foreach (Cart::content() as $items){
                
                if ($items->options->discount_type != '') {
                    if ($items->options->discount_type == 0) {
                        //percentage
                        $disc_price_new =
                            ($items->price * $items->options->discount) / 100;

                        $disc_price = $items->price - $disc_price_new;

                        $p_price = $disc_price;
                    } elseif ($items->options->discount_type == 1) {
                        $disc_price = $items->price - $items->options->discount;
                        $p_price = $disc_price;
                    } else {
                        $disc_price = '0';
                        $p_price = $items->price;
                    }
                } else {
                    $disc_price = '0';
                }


                if ($items->qty >= 1) {
                    $subtotal += $items->qty * round($p_price);
                } else {
                    $subtotal += round($p_price);
                }
            }
            
        }

    @endphp

    //alert('{{ $subtotal }}');
        
        var additional_charge = 0;

        var timing_charge = $('#timing_charge').val();
        var weekly_off_charge = $('#weekly_off_charge').val();

        
        var cod_charge = $('#cod_charge').val();
        
        // sub_total = parseInt(sub_total) - parseInt(cleaning_discount_amount);

        //var sub_total = parseInt(percleanprice) + parseInt(additional_charge) + parseInt(timing_charge) + parseInt(cod_charge) - parseInt(discount_amount);

        var sub_total = parseInt('{{ $subtotal }}') + parseInt(additional_charge) + parseInt(timing_charge) + parseInt(weekly_off_charge) + parseInt(cod_charge);

        var vat_total = (sub_total) * 5/100;

        var total_to_pay = sub_total + vat_total;



        

        $('#additional_charge_replace').html(additional_charge);
        $('#sub_total_replace').html(sub_total);
        $('#vat_charge_replace').html(vat_total);
        $('#total_to_pay_charge_replace').html(total_to_pay);
       
         $('#timing_charge_replace').html(timing_charge);
        $('#frequency_timing_charge_replace').html(timing_charge);

        $('#cod_charge_replace').html(cod_charge);
        $('#frequency_cod_charge_replace').html(cod_charge);

        
        $('#service_charge').val('{{ $subtotal }}');
        $('#additional_charge').val(additional_charge);
        $('#sub_total').val(sub_total);
        $('#vat_total').val(vat_total);
        $('#total_to_pay').val(total_to_pay);

        if(timing_charge > 0){
            $('.timing_charge_replace_div').attr('style', 'display: flex !important');
        } else {
            $('.timing_charge_replace_div').attr('style', 'display: none !important');
        }

        if(cod_charge > 0){
            $('.cod_charge_replace_div').attr('style', 'display: flex !important');
        } else {
            $('.cod_charge_replace_div').attr('style', 'display: none !important');
        }

   }

    // Get references to the select elements
    const propertyTypeSelect = document.getElementById('property_type');
    const areaSelect = document.getElementById('area_of_floor');
    const conditionSelect = document.getElementById('condition_of_floor');
    const serviceSelect = document.getElementById('service_required');
    const scheduleSelect = document.getElementById('schedule_site_survey');

    // Get references to the div elements where data will be shown
    const propertyTypeLabel = document.getElementById('property_type_lable');
    const areaOfFloorLabel = document.getElementById('area_of_floor_lable');
    const conditionOfFloorLabel = document.getElementById('condition_of_floor_lable');
    const requiredServiceLabel = document.getElementById('required_service_lable');
    const scheduleSiteLabel = document.getElementById('schedule_site_lable');

    // Function to update the labels
    function updateLabels() {
        propertyTypeLabel.textContent = propertyTypeSelect.value;
        areaOfFloorLabel.textContent = areaSelect.value;
        conditionOfFloorLabel.textContent = conditionSelect.value;
        requiredServiceLabel.textContent = serviceSelect.value;
        scheduleSiteLabel.textContent = scheduleSelect.value;
    }

    // Add event listeners for each select dropdown to update labels when a value is selected
    propertyTypeSelect.addEventListener('change', updateLabels);
    areaSelect.addEventListener('change', updateLabels);
    conditionSelect.addEventListener('change', updateLabels);
    serviceSelect.addEventListener('change', updateLabels);
    scheduleSelect.addEventListener('change', updateLabels);

    // Initialize labels on page load (in case any options are pre-selected)
    updateLabels();

    function wooden_floor_calculation() {
        var schedule_site_survey = $('#schedule_site_survey').val();

        if(schedule_site_survey === "no"){
            $('#upload_video_div').removeClass('d-none');  
        } else {
            $('#upload_video_div').addClass('d-none');     
        }
    }
   

    function get_hide_show(id){

        if (id == 1) {            

            $(".tab1").css("display", "block");
            $(".tab2").css("display", "none");
            $(".tab3").css("display", "none");
            $(".tab4").css("display", "none");
            $(".tab5").css("display", "none");
            $(".tab6").css("display", "none");

            $(".mobile-tab2").css("display", "inline-block");
            $(".mobile-tab3").css("display", "none");
            $(".mobile-tab4").css("display", "none");
            $(".mobile-tab5").css("display", "none");
            $(".mobile-tab6").css("display", "none");
            $(".mobile-booknow-btn").css("display", "none");

            $(".step-p").text("Step 1 of 4");
            $(".step-title .back-icon")
            .off("click")
            .html('<i class="fas fa-arrow-left"></i>');
            $(".step-title .back-icon")
            .css("cursor", "pointer")
            .on("click", function () {
                window.location.href = "{{ url('/') }}";
            });
            $(".step-title").contents().filter(function () {
                return this.nodeType === 3;
            }).remove();
            $(".step-title").append("Booking Summary");

            $("#summary_div_left").css("display", "block");

                $('html, body').animate({
                    scrollTop: $('.tab1').offset().top - 300
            }, 1000);
        }

        if(id == 2){
           // alert(id);
            var formfield_value_test = $('#formfield_value_test').val();
            if (formfield_value_test == '') {
                jQuery('#painting-select-error').html("Please select the type of painting");
                jQuery('#painting-select-error').show().delay(0).fadeIn('show');
                jQuery('#painting-select-error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#painting-select-error').offset().top - 300
                }, 1000);
                return false;
            } 

            
           if($("#type_of_painting").val() === "Move in / Move Out Painting"){         

            var newColor = $("input[name='color_do_you_want_walls_painted']:checked");
            if (newColor.length === 0) {
                jQuery('.new-color-error').html("Please select the color do you want your walls painted.");
                jQuery('.new-color-error').show().delay(0).fadeIn('show');
                jQuery('.new-color-error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('.new-color-error').offset().top - 300
                }, 1000);
                return false;
            }
            var oldColorWalls = $("input[name='what_color_your_walls_now']:checked");
            if (oldColorWalls.length === 0) {
                jQuery('.old-color-error').html("Please select the color are your walls now.");
                jQuery('.old-color-error').show().delay(0).fadeIn('show');
                jQuery('.old-color-error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('.old-color-error').offset().top - 400
                }, 1000);
                return false;
            }
        }


        //  For Wooden Flooor Polishing Validition Start 
        var subservice_id = $("#subservice_id").val();

        if (subservice_id == 89) {

        var property_type = $("#property_type").val();
            if (!property_type) {
                jQuery('#property_type_error').html("Please Select Property Type.");
                jQuery('#property_type_error').show().delay(0).fadeIn('show');
                jQuery('#property_type_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#property_type_error').offset().top - 300
                }, 1000);
                return false;
            }

        var area_of_floor = $("#area_of_floor").val();
            if (!area_of_floor) {
                jQuery('#area_of_floor_error').html("Please Select Area Of Floor.");
                jQuery('#area_of_floor_error').show().delay(0).fadeIn('show');
                jQuery('#area_of_floor_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#area_of_floor_error').offset().top - 300
                }, 1000);
                return false;
            }

        var condition_of_floor = $("#condition_of_floor").val();
            if (!condition_of_floor) {
                jQuery('#condition_of_floor_error').html("Please Select Current Condition of Floor.");
                jQuery('#condition_of_floor_error').show().delay(0).fadeIn('show');
                jQuery('#condition_of_floor_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#condition_of_floor_error').offset().top - 300
                }, 1000);
                return false;
            }

        var service_required = $("#service_required").val();
            if (!service_required) {
                jQuery('#service_required_error').html("Please Select Required Service.");
                jQuery('#service_required_error').show().delay(0).fadeIn('show');
                jQuery('#service_required_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#service_required_error').offset().top - 300
                }, 1000);
                return false;
            }

        var schedule_site_survey = $("#schedule_site_survey").val();
            if (!schedule_site_survey) {
                jQuery('#schedule_site_survey_error').html("Please Select Would you like to Schedule a Site Survey.");
                jQuery('#schedule_site_survey_error').show().delay(0).fadeIn('show');
                jQuery('#schedule_site_survey_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#schedule_site_survey_error').offset().top - 300
                }, 1000);
                return false;
            }
            
            if(schedule_site_survey === 'no'){
                var upload_video = $("#upload_video").val();
                if (upload_video == '') {
                    jQuery('#upload_video_error').html("Please Upload Video.");
                    jQuery('#upload_video_error').show().delay(0).fadeIn('show');
                    jQuery('#upload_video_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#upload_video_error').offset().top - 300
                    }, 1000);
                    return false;
                }
            }

        }


        //  For Wooden Flooor Polishing Validition End


           $(".tab1").css("display", "none");
            $(".mobile-tab2").css("display", "none");
            $(".mobile-tab3").css("display", "inline-block");
            $(".mobile-tab4").css("display", "none");
            $(".mobile-tab5").css("display", "none");
            $(".mobile-tab6").css("display", "none");
            $(".mobile-booknow-btn").css("display", "none");
            $(".tab2").css("display", "block");
            $(".tab3").css("display", "none");
            $(".tab4").css("display", "none");
            $(".tab5").css("display", "none");
            $(".tab6").css("display", "none");

            $(".step-p").text("Step 2 of 4");
            $(".step-title .back-icon") 
            .off("click")
            .html('<i class="fas fa-arrow-left"></i>');
            $(".step-title .back-icon")
            .css("cursor", "pointer")
            .on("click", function (event) {
                event.preventDefault(); 
                get_hide_show(1); 
            });
            $(".step-title").contents().filter(function () {
                return this.nodeType === 3;
            }).remove();
            $(".step-title").append("Your Location");

            // $(".step-title").text("Your Location");
            $("#summary_div_left").css("display", "block");

           
            $('html, body').animate({
                    scrollTop: $('.tab2').offset().top - 300
            }, 1000);

            
        }

        if(id == 3){

           

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

            var area = $('#area').val();
            if (area == '') {
                jQuery('#area_error').html(
                    "Please Enter Your Area");
                jQuery('#area_error').show().delay(0).fadeIn('show');
                jQuery('#area_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#area_error').offset().top - 150
                }, 1000);
                return false;
            }

            var building_street_no = $('#building_street_no').val();
            if (building_street_no == '') {
                jQuery('#building_street_no_error').html(
                    "Please Enter Building Or Street No");
                jQuery('#building_street_no_error').show().delay(0).fadeIn('show');
                jQuery('#building_street_no_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#building_street_no_error').offset().top - 150
                }, 1000);
                return false;
            }

            var apartment_villa_no = $('#apartment_villa_no').val();
            if (apartment_villa_no == '') {
                jQuery('#apartment_villa_no_error').html(
                    "Please Enter Apartment / Villa No");
                jQuery('#apartment_villa_no_error').show().delay(0).fadeIn('show');
                jQuery('#apartment_villa_no_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#apartment_villa_no_error').offset().top - 150
                }, 1000);
                return false;
            } 

            var citySelected = $('#city').val();
            var areaSelected = $('#area').val();
            var building_street_noSelected = $('#building_street_no').val();
            var apartment_villa_noSelected = $('#apartment_villa_no').val();

            var address = citySelected + ', ' + areaSelected + ', ' + building_street_noSelected + ', ' + apartment_villa_noSelected; 

            $('#address_replace').html(address);
            $('#get-quote-summary-address').html(address);

          


            $(".tab1").css("display", "none");
            $(".tab2").css("display", "none");
            $(".mobile-tab2").css("display", "none");
            $(".mobile-tab3").css("display", "none");
            $(".mobile-tab4").css("display", "inline-block");
            $(".mobile-tab5").css("display", "none");
            $(".mobile-tab6").css("display", "none");
            $(".mobile-booknow-btn").css("display", "none");
            $(".tab3").css("display", "block");
            $(".tab4").css("display", "none");
            $(".tab5").css("display", "none");
            $(".tab6").css("display", "none");

            $(".step-p").text("Step 3 of 4");
            $(".step-title .back-icon") 
            .off("click")
            .html('<i class="fas fa-arrow-left"></i>');
            $(".step-title .back-icon")
            .css("cursor", "pointer")
            .on("click", function (event) {
                event.preventDefault();
                get_hide_show(2); 
            });
            $(".step-title").contents().filter(function () {
                return this.nodeType === 3;
            }).remove();
            $(".step-title").append("Scheduling Your Service");

            // $(".step-title").text("Scheduling Your Service");
            $("#summary_div_left").css("display", "block");

            $('html, body').animate({
                    scrollTop: $('.tab3').offset().top - 300
            }, 1000);
        }

        if(id == 4){


            @php
                if($subservice_id == 89){
            @endphp
            

            var property_type = $("#property_type").val();
            var area_of_floor = $("#area_of_floor").val();
            var condition_of_floor = $("#condition_of_floor").val();
            var service_required = $("#service_required").val();
            var schedule_site_survey = $("#schedule_site_survey").val();


            $('#last_summary_property_type').html(property_type);
            $('#last_summary_area_of_floor').html(area_of_floor);
            $('#last_summary_condition_of_floor').html(condition_of_floor);
            $('#last_summary_service_required').html(service_required);
            $('#last_summary_schedule_site_survey').html(schedule_site_survey);

            @php
                }
            @endphp
            
            var date = $('#date').val();
            if (date == '') {
                jQuery('#date_error').html("Please Select Date");
                jQuery('#date_error').show().delay(0).fadeIn('show');
                jQuery('#date_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#date_error').offset().top - 150
                }, 1000);
                return false;
            }
            const timeSlots = document.getElementsByName('time_slot');
            let timeSlotSelected = false;
            
            for (const timeSlot of timeSlots) {
                if (timeSlot.checked) {
                    timeSlotSelected = true;
                    break;
                }
            }

            if (!timeSlotSelected) {
                jQuery('#time_slot_error').html(
                    "Please Select Time Slot");
                jQuery('#time_slot_error').show().delay(0).fadeIn('show');
                jQuery('#time_slot_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#time_slot_error').offset().top - 150
                }, 1000);
                return false;
            }

            if($("#formfield_value_test").val() !== "Move in / Move Out Painting"){
                $("#summary_div_left").css("display", "none");
                $(".tab1").css("display", "none");
                $(".tab2").css("display", "none");
                $(".mobile-tab2").css("display", "none");
                $(".mobile-tab3").css("display", "none");
                $(".mobile-tab4").css("display", "none");
                $(".mobile-tab5").css("display", "inline-block");
                $(".mobile-tab6").css("display", "none");
                $(".mobile-booknow-btn").css("display", "none");
                $(".tab3").css("display", "none");
                $(".tab6").css("display", "block");
                $(".tab5").css("display", "none");
                $(".step-p").text("Step 4 of 4");

                  $(".step-title .back-icon")
                        .off("click")
                        .html('<i class="fas fa-arrow-left"></i>');
                        $(".step-title .back-icon")
                        .css("cursor", "pointer")
                        .on("click", function (event) {
                            event.preventDefault();
                            get_hide_show(3); 
                });
                $(".step-title").contents().filter(function () {
                    return this.nodeType === 3;
                }).remove();
                    $(".step-title").append("Review & Confirm");
                // $(".step-title").text("Review & Confirm");
                $("#summary_div_left").css("display", "none"); 
            }else{
                $("#summary_div_left").css("display", "block");
                $(".tab1").css("display", "none");
                $(".tab2").css("display", "none");
                $(".mobile-tab2").css("display", "none");
                $(".mobile-tab3").css("display", "none");
                $(".mobile-tab4").css("display", "none");
                $(".mobile-tab5").css("display", "inline-block");
                $(".mobile-tab6").css("display", "none");
                $(".tab3").css("display", "none");
                $(".tab4").css("display", "block");
                $(".tab5").css("display", "none");
                $(".step-p").text("Step 4 of 4");
                $(".step-title .back-icon")
                        .off("click")
                        .html('<i class="fas fa-arrow-left"></i>');
                        $(".step-title .back-icon")
                        .css("cursor", "pointer")
                        .on("click", function (event) {
                            event.preventDefault();
                            get_hide_show(3); 
                });
                $(".step-title").contents().filter(function () {
                    return this.nodeType === 3;
                }).remove();
                $(".step-title").append("Payment Information");
                // $(".step-title").text("Payment Information");
            }

             $('html, body').animate({
                    scrollTop: $('.tab4').offset().top - 300
            }, 1000);

        }

        if(id == 5){

            
            var paymentTypeSelected = document.querySelector('input[name="payment_type_old"]:checked');

            //alert(paymentTypeSelected);

            if (!paymentTypeSelected) {
                jQuery('#payment_type_error').html(
                    "Please Payment Type");
                jQuery('#payment_type_error').show().delay(0).fadeIn('show');
                jQuery('#payment_type_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#payment_type_error').offset().top - 150
                }, 1000);
                return false;
            }

            @php

            if($subservice_id == 30 || $subservice_id == 28){
            @endphp

            var cleanersSelected = document.querySelector('input[name="how_many_cleaners_do_you_need"]:checked');
            $('#cleaners_summary').html(cleanersSelected.value);

            var hoursSelected = document.querySelector('input[name="how_many_hours_should_they_stay"]:checked');
            $('#hours_summary').html(hoursSelected.value);

            var materialSelected = document.querySelector('input[name="do_you_need_cleaning_material"]:checked');
            $('#material_summary').html(materialSelected.value);

            var frequenceSelected = $('#how_often_do_you_need_cleaning').val();
            $('#frequency_summary').html(frequenceSelected);

            if(frequenceSelected == 'Multiple times a week'){
                $("#frequency_div_summary").css("display", "block");

                var selectedDays = [];
                document.querySelectorAll('input[name="which_day_of_the_week_do_you_want_the_service[]"]:checked').forEach(function(checkbox) {
                    selectedDays.push(checkbox.value);
                });

                var selectedDays = selectedDays.join(',');
                $('#frequency_summary_days').html(selectedDays);

            }else{
                $("#frequency_div_summary").css("display", "none");
            }

            @php
            }
            @endphp

            var citySelected = $('#city').val();
            var areaSelected = $('#area').val();
            var building_street_noSelected = $('#building_street_no').val();
            var apartment_villa_noSelected = $('#apartment_villa_no').val();

            var address = citySelected + ', ' + areaSelected + ', ' + building_street_noSelected + ', ' + apartment_villa_noSelected; 
            $('#frequency_summary_address').html(address); 
            $('#get-quote-summary-address').html(address); 



            var dateSelected = $('#date').val();
            var monthSelected = $('#month').val();
            var currentDate = new Date();
            var currentYear = currentDate.getFullYear();
            var date = dateSelected + ' ' + monthSelected + ' ' + currentYear; 
            // $('#frequency_summary_date').html(date); 


            var time_slotSelected = document.querySelector('input[name="time_slot"]:checked');
            //var selectedName = time_slotSelected.getAttribute('data-name');
            //$('#frequency_summary_timeslot').html(selectedName);

            var payment_typeSelected = document.querySelector('input[name="payment_type_old"]:checked');
            if(payment_typeSelected.value == 'COD'){
                var payment_mode = 'Cash on Delivery';
                $("#frequency_summary_cod_div").attr("style", "display: block !important;");
            }else{
                $("#frequency_summary_cod_div").attr("style", "display: none !important;");
                var payment_mode = 'Online';
            }
            $('#frequency_summary_payment_mode').html(payment_mode);


            var service_charge = $('#size_of_home_price').val();
            var additional_charge = $('#additional_charge_price').val();
            var cod_charge = $('#cod_charge_new').val();
            var service_fee = $('#service_fee').val();
            var timing_charge = $('#timing_charge').val();
            var weekly_off_charge = $('#weekly_off_charge').val();
            var promo_discount = $('#hidden_discount_price').val(); 

            var total_timing_charge = parseFloat(timing_charge) + parseFloat(weekly_off_charge);
            //var sub_total = parseInt(percleanprice) + parseInt(additional_charge) + parseInt(timing_charge) + parseInt(cod_charge) - parseInt(discount_amount);
          
            var sub_total = parseInt(service_charge) + parseInt(additional_charge) + parseInt(cod_charge) + parseInt(total_timing_charge) + parseInt(service_fee) - parseInt(promo_discount) ;

            // alert(sub_total);
            // alert(service_charge);
            // alert(additional_charge);
            // alert(cod_charge);
            // alert(timing_charge);
            // alert(service_fee);

            //alert(sub_total);

            var vat_charge = sub_total * 5 /100;

            //alert(vat_charge);

            let last_summary_cross_amount = parseInt(service_charge) + parseInt(additional_charge) + parseInt(cod_charge) + parseInt(timing_charge) + parseInt(service_fee);

            var total_to_pay = sub_total + vat_charge;

            let last_summary_vat = parseFloat(last_summary_cross_amount) * 5 /100;

            let summary_cross_amount =  last_summary_cross_amount + last_summary_vat;

          //  alert(total_to_pay);

            var sub_total = $('#hidden_subtotal_price').val(parseFloat(sub_total));
            let last_sub_total = parseFloat($('#hidden_subtotal_price').val());
            // var vat_total = $('#hidden_subtotal_price').val(vat_charge);
            // var total_to_pay = $('#total_to_pay_charge_price').val(total_to_pay);

          // alert(last_sub_total);return false;
            var total_to_pay = total_to_pay.toFixed(2);

            var service_fee = parseFloat(service_fee).toFixed(2);


            //alert(sub_total);

           
            if (parseFloat(service_fee) !== 0) {
                $('#service_fee_wrapper').show();
                $('#service_fee_wrapper_mobile').show();
            }else{
                $('#service_fee_wrapper').hide();
                $('#service_fee_wrapper_mobile').hide();
            } 


            $('#total_to_pay_charge_price').val(total_to_pay);
            $('#frequency_summary_service_charge').html(service_charge);
            $('#frequency_summary_cross_amount').html(service_charge);
            $('#frequency_summary_cross_amount_mobile').html(last_sub_total.toFixed(2));
            $('#frequency_summary_promo_discount').html(promo_discount);
            $('#frequency_summary_additional_charge').html(additional_charge);
            $('#frequency_summary_timing_fee').html(total_timing_charge.toFixed(2));
            $('#frequency_summary_service_fee_charge').html(service_fee);
            $('#frequency_summary_service_fee_charge_mobile').html(parseFloat(service_fee).toFixed(2));
            $('#sub_total_replace_mobile').html(last_sub_total.toFixed(2));
            $('#frequency_summary_service_sub_total').html(last_sub_total.toFixed(2));
            $('#sub_total_replace').html(last_sub_total.toFixed(2));
            $('#frequency_summary_service_vat').html(vat_charge.toFixed(2));
            $('#vat_charge_replace').html(vat_charge.toFixed(2));
            $('#hidden_vat_charge_price').val(vat_charge.toFixed(2));
            $('#frequency_summary_cross_total').html(summary_cross_amount.toFixed(2));
            $('#cross_amount').html(summary_cross_amount.toFixed(2));
            $('#frequency_summary_total_to_pay').html(total_to_pay);
           
            $('#total_to_pay_charge_replace').html(total_to_pay);
            $('#total_to_pay_charge_replace_mobile').html(total_to_pay);

            
          
            $('#frequency_summary_cod_charge').html(parseFloat(cod_charge).toFixed(2));

            var walletAmount = parseFloat($('#wallet_amount').text().replace('Wallet Amount (', '').replace(' AED)', ''));
            // alert(walletAmount);

            $('.wallet_apply').attr('onclick', 'apply_wallet_discount("' + total_to_pay + '", "' + walletAmount + '");');

            $('.wallet_cancel').attr('onclick', 'cancelWalletDiscount("' + total_to_pay + '", "' + walletAmount + '");');


            $('#frequency_summary_cod_charge').html(parseFloat(cod_charge).toFixed(2));
            
          

            $("#summary_div_left").css("display", "none");

            $(".tab1").css("display", "none");
            $(".tab2").css("display", "none");
            $(".tab3").css("display", "none");
            $(".tab4").css("display", "none");
            $(".tab5").css("display", "block");
            $(".mobile-tab2").css("display", "none");
            $(".mobile-tab3").css("display", "none");
            $(".mobile-tab4").css("display", "none");
            $(".mobile-tab5").css("display", "none");
            $(".mobile-tab6").css("display", "inline-block");
            $(".step-p").text("Step 5");
             $(".step-title .back-icon")
            .off("click")
            .html('<i class="fas fa-arrow-left"></i>');
            $(".step-title .back-icon")
            .css("cursor", "pointer")
            .on("click", function (event) {
                 event.preventDefault();
                get_hide_show(4); 
            });
            $(".step-title").contents().filter(function () {
                return this.nodeType === 3;
            }).remove();
            $(".step-title").append("Booking Summary");
            //$("#summary_div_left").css("display", "block");

              $('html, body').animate({
                    scrollTop: $('.tab5').offset().top - 300
            }, 1000);
            }

            if(id == 6){
                $(".mobile-tab2").css("display", "none");
                $(".mobile-tab3").css("display", "none");
                $(".mobile-tab4").css("display", "none");
                $(".mobile-tab5").css("display", "none");
                $(".mobile-tab6").css("display", "none");
                $(".spinner-mobile-tab6").css("display", "block");
                $('.spinner_button').show();
                $('.order_now').hide();
                $('#category_form_new').submit();
            }
    }
    </script>

<script>
    function apply_wallet_discount(total_wallet_amount,userWalletamount) {
        // alert(total_amount);
        // alert(wallet_amount);
        $.ajax({
                type: 'POST',
                url: '{{ url("apply-wallet-discount-book_now") }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "total_wallet_amount": total_wallet_amount,
                    "userWalletamount": userWalletamount
                },
                success: function (result) {
                    if (result !== '') {
            let UserWalletAmount;

            if (@json(Session::get('user_wallet_amount')) !== "") {
                UserWalletAmount = parseFloat(userWalletamount);
                // alert(UserWalletAmount); return false;
            }else{
                UserWalletAmount = parseFloat(@json(Session::get('user_wallet_amount')));
                // alert(UserWalletAmount); return false;
            }

            // alert(UserWalletAmount);return false;

            let TotalwalletAmount =  parseFloat(total_wallet_amount);

            let updatedTotal = parseFloat(result);

            // Calculate the new order total after applying wallet amount
            let order_total_new1;

            if (UserWalletAmount >= TotalwalletAmount) {
                order_total_new1 = 0; // Wallet covers the entire order
                UserWalletAmount = TotalwalletAmount;
            } else {
                order_total_new1 = TotalwalletAmount - UserWalletAmount; // Remaining amount to be paid
            }
            if(order_total_new1 == 0){
            $('#payment_type_new').val('COD');
            }else{
                var payment_typeSelected = document.querySelector('input[name="payment_type_old"]:checked');
                $('#payment_type_new').val(payment_typeSelected.value);
            }
             // Update the wallet amount display
            $('#frequency_wallet_amount').html(`
    - <span class="currency_dhiram"></span>
    ${UserWalletAmount.toFixed(2)}
`);
            // Update the displayed order grand total
            $('#frequency_summary_total_to_pay').text(`${order_total_new1.toFixed(2)}`);
            $('#apply_button').val(1);
            $('#cancel_button').val(1);
            document.querySelector('.wallet_apply').style.display = 'none';
            document.querySelector('.wallet_cancel').style.display = 'inline-block';
           
        }
    }

});
    }

function cancelWalletDiscount(orderTotal, userWalletAmount) {
// AJAX to revert the applied discount
$.ajax({
    type: 'POST',
    url: '{{ url("cancel-wallet-discount-book-now") }}',
    data: {
        "_token": "{{ csrf_token() }}",
        "orderTotal": orderTotal,
        "userWalletAmount": userWalletAmount
    },
    success: function (result) {
        if (result !== '') {
            // Reset the displayed order total to the original value
            let originalOrderTotal = parseFloat(orderTotal);
            $('#cancel_button').val(0);
            $('#apply_button').val(0);
            $('#frequency_summary_total_to_pay').text(`${originalOrderTotal.toFixed(2)}`);
        
            // Reset the wallet amount display
            $('#frequency_wallet_amount').text('');

            // Hide the cancel button and show the apply button again
            document.querySelector('.wallet_apply').style.display = 'inline-block';
            document.querySelector('.wallet_cancel').style.display = 'none';

            
        }
    }
});
}
</script>

<script>
    // Function to add days to a date
    function addDays(date, days) {
        const result = new Date(date);
        result.setDate(result.getDate() + days);
        return result;
    }

    // Function to format the date
    function formatDate(date) {
        const dayNames = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return {
            day: dayNames[date.getDay()],
            date: date.getDate(),
            month: monthNames[date.getMonth()],
            year: date.getFullYear()  
        };
    }

    // Get the dates container and scroll buttons
    const datesContainer = document.getElementById('dates-container');
    const daysWrapper = document.getElementById('days-wrapper');
    const scrollLeftBtn = document.getElementById('scroll-left');
    const scrollRightBtn = document.getElementById('scroll-right');

    // Get the current date and generate the next 14 days
   const today = addDays(new Date(), 1);
    const daysToShow = 30;
    let currentIndex = 0;
    for (let i = 0; i < daysToShow; i++) {
        const currentDate = addDays(today, i);
        const formattedDate = formatDate(currentDate);

        const dayDiv = document.createElement('div');
        dayDiv.classList.add('calendar-day');
        dayDiv.innerHTML = `
    <div class="calendar-day-label" id="calenday_day">${formattedDate.day}</div>
    <div class="calendar-date-label" id="calender_date">${formattedDate.date}</div>
    ${
        (formattedDate.day === 'Sa' || formattedDate.day === 'Su' || isToday(currentDate))
        ? `
        <div class="surcharge-badge-dayslot" style="position:relative;">
            <span>
                + <p class="currency_dhiram"></p> 5
            </span>
        </div>`
        : ''
    }
`;


        // Add click event to each day
        dayDiv.addEventListener('click', function() {
            document.querySelectorAll('.calendar-day').forEach(day => day.classList.remove('is-selected'));
            dayDiv.classList.add('is-selected');
            $('#date').val(formattedDate.date);
            $('#month').val(formattedDate.month);

            var date_new = formattedDate.date + ' ' + formattedDate.month + ' ' + formattedDate.year;

            if (formattedDate.day === 'Sa' || formattedDate.day === 'Su' || isToday(currentDate)) {
            //    alert('You selected a weekend!');

                var weekly_off_charge = 5;
            }else{
                var weekly_off_charge = 0;
            }

            $('#weekly_off_charge').val(weekly_off_charge);

            $('#date_replace').html(date_new);
            $('#get-quote-summary-date').html(date_new);
            $('#frequency_summary_date').html(date_new);

           
            calculationNew();
            //calculation_book_now();

            
            //alert(`Selected date: ${formattedDate.day}, ${formattedDate.date} ${formattedDate.month}`);
        });

        daysWrapper.appendChild(dayDiv);
    }

    function isToday(date) {
        const today = new Date();
        return (
            date.getDate() === today.getDate() &&
            date.getMonth() === today.getMonth() &&
            date.getFullYear() === today.getFullYear()
        );
    }


    // Function to update the visible days
    function updateVisibleDays() {
        const offset = -currentIndex * 70; // 60px width + 10px margin per day
        daysWrapper.style.transform = `translateX(${offset}px)`;
    }

    // Scroll dates container left and right
    scrollLeftBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex -= 5;
            if (currentIndex < 0) currentIndex = 0;
            updateVisibleDays();
        }
    });

    scrollRightBtn.addEventListener('click', () => {
        if (currentIndex < daysToShow - 5) {
            currentIndex += 5;
            if (currentIndex > daysToShow - 5) currentIndex = daysToShow - 5;
            updateVisibleDays();
        }
    });

    // Initialize the visible days
    updateVisibleDays();

    function add_to_cart_book(package_id) {

        var qty = 1;

        $.ajax({

            type: 'POST',
            url: '{{ url('add_to_cart_book ') }}',
            data: {

                "_token": "{{ csrf_token() }}",
                'qty': qty,
                'package_id': package_id,

            },

            success: function(msg) {
                if (msg != 0) {
                    
                    //calculation_book_now();
                    $("#cart_div_form").load(location.href + " #cart_div_form");
                    $("#summary_div_left_package").load(location.href + " #summary_div_left_package");

                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                    // $(".addtocart-btn_" + package_id).hide();
                    // $(".loader-test_" + package_id).show();
                    // setTimeout(function() {
                    //     window.location.href = "{{ route('cart') }}";
                    //     $(".addtocart-btn_" + package_id).show();
                    //     $(".loader-test_" + package_id).hide();
                    // }, 2000);
                    return false;
                }
            }
        });

    }

    function remove_to_cart_book_now(rowId) {

var answer = window.confirm("Do you want to remove this Package from cart?");

if (answer) {
    var url = '{{ url('cart_remove_book_now') }}';
    $.ajax({
        url: url,
        type: 'post',
        data: {
            "_token": "{{ csrf_token() }}",
            "rowId": rowId
        },
        success: function(msg) {

            if (msg != '') {

                //calculation_book_now();
                $("#message_error").html("Package Removed From Cart");
                $('#message_error').show().delay(0).fadeIn('show');
                $('#message_error').show().delay(2000).fadeOut('show');
                $("#cart_div_form").load(location.href + " #cart_div_form");
                    $("#summary_div_left_package").load(location.href + " #summary_div_left_package");

                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                //  $("#header_cart").load(location.href + " #header_cart");
                // $("#header_cart_count").load(location.href + " #header_cart_count");
                return false;
            }

        }

    });
}
}

</script>
<script>
    function getCurrentMonthAndYear() {
        const now = new Date();
        const options = { month: 'long', year: 'numeric' }; 
        return now.toLocaleDateString('en-US', options);
    }
    document.getElementById('month').textContent = getCurrentMonthAndYear();
</script>
<script>
   document.getElementById('aerrowicon').addEventListener('click', function () {
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
    document.getElementById('close').addEventListener('click', function () {
        var summaryDiv = document.getElementById('summary_div_left_mobile');
        var aerrowIcon = document.getElementById('aerrowicon');

        // Close the div and reset the arrow icon
        if (summaryDiv.classList.contains('open')) {
            summaryDiv.classList.remove('open');
            aerrowIcon.style.transition = 'transform 0.3s ease'; // Smooth transition
            aerrowIcon.style.transform = 'rotate(0deg)'; // Reset rotation
        }
    });

$(document).ready(function () {
    if ($(window).width() <= 767) {
        const $stepText = $('#service-step-title .step-p');
        $(window).on('scroll', function () {
            if ($(this).scrollTop() > 10) {
                $stepText.addClass('hide');
            } else {
                $stepText.removeClass('hide');
            }
        });
    }
});
$(document).ready(function () {
$(".step-title .back-icon")
            .off("click")
            .html('<i class="fas fa-arrow-left"></i>');
			
			
			});
    function date_select(){
        //alert('Please select a date from the calendar.');

        var url = '{{ url('painting-time-check') }}';
        var date = $('#date').val();
        var dateText = $('#date_replace').html();
        var dateParts = dateText.split(' ');      // Split the string by spaces
        var month = dateParts[1];   
        var year = dateParts[2]; 

        $.ajax({
            url: url, // Laravel route
            method: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                'date': date,
                'month': month,
                'year': year,
                'subservice_id': '{{ $subservice_id }}'
            },
            success: function (response) {
                $(".time_replace_ab").html(response.html); // inject HTML into DOM
            },
            error: function () {
                alert("Failed to load time slots. Try again.");
            }
        });

    }
    </script>
    

