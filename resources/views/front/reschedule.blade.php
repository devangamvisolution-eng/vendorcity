@include('front.includes.header')
<style>
    .modal-content {border-radius: 1.3rem;}
.modal-title {font-size: 20px;}
    .dropdown-content-new {
        z-index: 999;
    }
    .furniture-modal li{
        list-style-type: initial !important;
    }
    .cleaners-modal li{
        list-style-type: initial !important;
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
    .calendar-day.disabled {
    opacity: 0.5; /* Optional: Lowers opacity to enhance the disabled effect */
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
        min-height: 75px;
        background-color: #fff;
        color: #fff;
        font-size: 23px;

    }
    .booking-summary{
        position: fixed;
        bottom: 7px;
        /* right: 146px; */
        z-index: 1000;
        height: auto;
        background-color: #fff;
        color: #fff;
        font-size: 23px;
        border: none;
        padding: 0;
        margin: 0;
    }
    #selected_weekly{
        margin-top:-3px; 
        font-size: 17px; 
        font-weight:1000;
        color: #000;
        margin-bottom: -15px;
    }
    .modal-dialog{
        max-width: 35%;
        height: auto !important;
        max-height:70% !important;
    }
    .furniture-modal .modal-dialog {
        max-width: 38% !important;  
        height: 70%;  
        }
    .closeBtn {
        background: none;
        font-size: 50px;
        color: #000;
        border: none;
        /* position: absolute; */
        right: 0;
        top: 0;
        margin: 0;
        padding: 0;
        width: 30px;
    }
    
    #mobile_view_br{
        display: none !important; 
    }
    .need_cleaner .owl-stage-outer .owl-stage{
        padding-top : 8px !important; 
    }
    #when_would_you_start_slider {
    padding: 0 20px 0 25px;
    }

    #when_would_you_start_slider .owl-nav .owl-next {
        position: absolute;
        top: 28px;
        right: -8px;
    }
    #when_would_you_start_slider .owl-nav .owl-prev {
        position: absolute;
        top: 28px;
        left: -5px;
    }
    #when_would_you_start_slider .owl-theme .owl-nav [class*=owl-]:hover {
        background: transparent;
        color: unset;
        text-decoration: none;
    }

    #days-wrapper {
    display: flex;
    overflow-x: auto;
    scroll-behavior: smooth; /* Smooth scrolling */
    cursor: grab; /* Change cursor to grab for desktop users */
    -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS devices */
    padding: 17px 10px;
}

#days-wrapper.dragging {
    cursor: grabbing; /* Change cursor to grabbing when dragging */
}

/* Hide scrollbar for a clean UI */
#days-wrapper::-webkit-scrollbar {
    display: none; /* Hide scrollbar in WebKit browsers */
}
#days-wrapper {
    -ms-overflow-style: none; /* Hide scrollbar in IE and Edge */
    scrollbar-width: none; /* Hide scrollbar in Firefox */
}
.blur {
        filter: blur(3px);
        pointer-events: none;
        opacity: 0.7;
    }
    .main-title {
        margin-bottom: 25px;
    }
	
	 
	  #how_many_hours_need_cleaner_slider_spatie label{
		  border-radius: 50px;
		  padding: 7px 25px;
	  }
	  #how_many_cleaner_require_slider_spatie label{
		  border-radius: 50px;
		  padding: 7px 25px;
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
}

      .mb-md-4 {margin-bottom: 0 !important;}
  /* Show the button on mobile screens (less than 768px wide) */
  @media only screen and (max-width: 768px) {
	  
	  .p-md-3 {padding: 0 !important;}
	  
	  
	  #how_many_hours_need_cleaner_slider_spatie label{
		  border-radius: 50px;
		  padding: 7px 37%;
	  }
	 #how_many_hours_need_cleaner_slider_spatie .splide__list { 
            margin: 10px 0 0 0 !important;
        }

    /* .owl-carousel {
    padding-right: 10px; 
    } */
    .cleaning-mobile{
        margin-bottom: 0px !important;
    }
     .main-title{
        top:0px !important;
    }
    #how_many_hours_need_cleaner_slider_spatie {
        padding:0 10px;
     }
     #how_many_cleaner_require_slider_spatie{
        padding:0 10px;
     }
     .slider-top{
        margin-bottom: 2rem!important;
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
    }

    .splide__arrow--next{
        content: '\f105'; /* FontAwesome right arrow */
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        margin-right: -4% !important;    
    }
    .splide__arrow svg {
        fill: #000;
        height: 15px;
        width: 15px;
    }



    #when_would_you_start_slider {
    padding: 0 20px 0 25px;
    }

    #when_would_you_start_slider .owl-nav .owl-next {
        position: absolute;
        top: 28px;
        right: -8px;
    }
    #when_would_you_start_slider .owl-nav .owl-prev {
        position: absolute;
        top: 28px;
        left: -5px;
    }
    .owl-theme .owl-nav .disabled {
        opacity:unset;
        cursor: default;
    }

    .owl-theme .owl-nav [class*=owl-]:hover {
        background: transparent;
        color: unset;
        text-decoration: none;
    }

    .owl-item.active {
    width: auto !important;
    }

    .hour_input label {
        border-radius: 23px !important;
        padding: 8px 23px !important;
    }
    #mobile_view_br{
    display: block !important; 
    }
    #modal-digi{
        max-width: 100% !important;
    }
    .modal-dialog {
    max-width: 60%; /* Keep the width as needed */
    height:70%; /* Height of the entire modal */
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
    .modal-body {
        height: 100%;
        max-height: calc(100% - 120px); /* Adjust for modal header and footer */
        overflow-y: auto; 
        -webkit-overflow-scrolling: touch; /* Enables smooth scrolling on iOS */
    }
   .sticky-button {
      display: block !important;
    }
    .mobile-hide{
        display: none !important;
    }
    .summary_div_left_new{
        display: none !important;
    }
    #summary_div_left_mobile {
        display: none;
        position: fixed;
        bottom: -100%; /* Initially hide the div outside the viewport */
        right: 0;
        width: 100%;
        transition: all 0.3s ease-in-out; /* Smooth transition effect */
        z-index: 999; /* Make sure it stays on top */
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
    .mobile-next{
        top: unset !important;
        bottom: 17px !important;
    }
    #summary_div_left_mobile.open {
            display: block !important;
            bottom: 0; /* Slide up into view */
            background: #fff;
            bottom: 70px;
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
    .body_content .our-register {
        margin-top: 121px !important; 
    }
    .advance-search-tab{
        display: none !important;
    }

    }


    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 50%;
        }

        td, th {
        border: 1px solid #dddddd;
        text-align: left;
        /* padding: 8px; */
        }

  
    /* Style the labels to look like buttons */
    .radio-group label {
        display: inline-block;
        padding: 5px 10px;
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
        color: #0040E6;
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
        border: 2px solid #0040E6;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    /* Default button style */
    .checkbox-group label {
        background-color: #fff;
        color: #0040E6;
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
        /* padding-top: 15px; */
    }
    .days-wrapper {
        display: flex;
        transition: transform 0.3s ease;
    }
    .calendar-day {
        flex: 0 0 auto;
        width: 43px;
        height: 80px;
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
        position: relative;
        /* padding-top: 20px; */
        /* display: inline-block; */
    }
    .time-slot-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* 2 columns */
        gap: 15px; /* spacing between items */
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
    top: -12px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    }
    .surcharge-badge-timeslot span .currency_dhiram{
            margin: 0;
    color: #000;
    }
    .surcharge-badge-dayslot{
        /* color: red;
        width: 30%;
        display: inline-block; */
    }
    .surcharge-badge-dayslot span{
       position: absolute;
        top: -86px;
        right: -9px;
        background: #ffda40;
        padding: 2px 3px;
        color: #000;
        white-space: nowrap;
        font-size: 13px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 2px;

    }
    .surcharge-badge-dayslot span .currency_dhiram{
        margin: 0;
        color: #000;
    }
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
    .slider{
        /* padding: 0 20px 0 7px !important;  */
    }
    .hour_input label{
        border-radius: 50px;
        padding: 7px 25px;
    }
    .popular{
        font-size: 11px;
        position: absolute;
        /* left: 0;
        right: 0; */
        margin-left: 10%;
        margin-right: auto;
        width: 62px;
        line-height:18px !important;
        text-align: center;
        background: #ffda40;
        padding: 0px;
        color: #000;
        /* top: 0; */
        border-radius: 10px;
        font-weight: 1000;
    }
    .material label{
        border-radius: 50px;
        padding: 10px 22px;
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
        box-shadow: 0 6px 15px #00000029;
        padding: 13px 13px 13px 13px;
        border-radius: 10px;
    }
    .last_col{
        box-shadow: 0 6px 15px #00000029;
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
        /* max-width: 65%; */
         text-align: right;
         color:#0040E6;
    }
    .step-p{
        margin:0  0 -8px 35px;
        font-size:18px;
    }
    .step-title{
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
        background-color: #0040E6;
        color: #fff;
        /* padding: 13px 0; */
        border-radius: 11px;
        width: 50%;
        margin: 0 auto;
        justify-content: center;
        gap: 10px;

    }
    .fixed-title {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background-color: white; /* Adjust as needed */
        z-index: 1000; /* Ensure it stays above other content */
        padding: 0; /* Add padding if needed */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional shadow */
    }
    .step-fix {
        position: fixed;
        top: 144px !important; 
        left: 0;
        right: 0;
        background-color: white; /* Adjust as needed */
        z-index: 1000; /* Ensure it stays above other content */
        padding: 0 12px; /* Add padding if needed */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional shadow */
    }
    .furniture-short-desc {
    color: #666;
    font-size: 14px;
    }
	
	.package-category-class .align-items-center {
    align-items: unset !important;
}
.package-category-class .mobile-furniture {padding-left: 0;}

    .add-to-card {
        cursor: pointer;
    }

    .mt-3 {
        margin-top: 1rem;
    }
    .furniture-small-image{
        max-width: 100%;
        height: auto;
        border-radius:10px;
    }
    .package-data-div{
        display: flex;
        align-items: center; 
        gap: 10px;
    }
   
    .subservice-image{
        width: 100%;
    }
    .subservice-desc{
        margin-top: 20px;
    }
    .furniture-learn-more{
        background: #ffda40; 
        border-radius: 50%; 
        padding: 0; 
        height: 26px; 
        width: 26px; 
        text-align: center; 
        font-weight: 1000; 
        color: #000; 
        font-size:12px;
    }

    .sticky-footer-btn {
        position: fixed;
        bottom: 0px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        width: 100%;
        text-align: center;
        background-color: #f8f9fa;
        padding: 10px;
        box-shadow: 0px 0px 20px 0px #00000029;
    }
    .fix-on-footer{
        width: 15%;
    }
	
	#select_your_cleaner_slider_spatie .splide__arrow--prev {
		left: -5% !important;
	}
	#select_your_cleaner_slider_spatie .splide__arrow--next {
		right: -2% !important;
	}
	#select_your_cleaner_slider_spatie .splide__arrow {
		background: inherit !important;
		border: inherit !important;
    border-radius: inherit !important;
	}
	
    @media only screen and (max-width: 768px) {
            
    .summary_div_left_mobile_new {
        position: relative;
        z-index: 999;
    }
    .radio-item label{
        padding: 5px 12px !important;
    }
    #sticky-header{
        left: 3.2% !important;
        padding: 12px !important;
        width: 428px !important; 
        border-bottom: 1px solid #ccc;
    }
    #sticky-header.sticky-active {
        position: fixed !important;
        top: 79px !important;
        right: 23px !important;
        z-index: 1000 !important;
        /* max-width: 93% !important; */
		        max-width: 100% !important;
        left: 0 !important;
    }
    .sticky_new {
        position: fixed !important;
        top: 272px !important;
        right: 23px !important;
        z-index: 1000 !important;
        max-width: 100% !important;
    }
    .mobile-radio label{
        padding: 1px 7px !important;
        margin: 1px !important;
		margin-bottom: 5px !important;
    }
    .mobile-view .col-lg-3{
        width: 40% !important;
        margin-bottom: 100px !important;
    }
    .mobile-view .col-lg-9{
        width: 60% !important;
    }
    .package-data-div h5 {
        font-size: 15px;
    }
    .package-data-div #learn_more {
        font-size: 15px;
    }
    .package-data-div #furniture-learn-more {
        font-size: 15px;
    }
    .furniture-short-desc{
        font-size: 13px;
    }
    .mobile-starting-from{
        font-size: 13px;
    }
    .mobile-furniture .d-flex{
        /* display: block !important; */
    }
	.package-category-class  .btn{padding: 1px;}
    .package-data-div{
        display: block !important;
    }
    .for-mobile-br{
        display: block;
		color: #000 !important;
    }
    #mobile_promo_code_div{
        display: block !important;
    }
    .popup-cleaner-image{
        width: 100px; 
        height: 100px;
    }
    .popup-price{
        margin-left: 40% !important;
    }
    #select_your_cleaner_slider_spatie .splide__track {
        margin-right: -20px !important; 
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
	 .for-mobile-br{
        color: #000 !important;
    }
    /* Make sure the column has position: relative so "left" works correctly */
    .col-lg-6 {
        position: relative;
    }
    #sticky-header {
        position: sticky; /* or fixed if needed */
        top: 101px;
        width: 100%; /* Fill the column width */
        max-width: 100%; /* Prevent it from growing outside */
        background-color: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        z-index: 8;
        padding: 10px;
        box-shadow: unset !important;
        /* overflow-x: auto;  */
    }

    #sticky-header.sticky-active {
        position: fixed;
        top: 101px;
        left: auto;
        width: 100%;
        max-width: 100%;
    }
    .sticky_new{
        position: fixed;
        top: 101px;
        /* left: 259px; */
        /* z-index: 1000; */
        max-width: 45.1%;
    }
    .quantity-num-one {
        border: none;
        border-radius: 4px 0 0 4px;
        font-size: 15px;
        height: 56px;
        max-width: 140px;
        outline: none;
        padding: 0;
        text-align: center;
        width: 100%;
    }
    /* .quantity{
        margin-left: -33% !important; 
    } */
    .custom-arrow {
    position: relative;
    text-decoration: none;
    color: #000;
    font-size: 16px;
    }
    .custom-arrow::after {
        content: '';
        display: inline-block;
        margin-left: 8px;
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #000; /* Change color to match your design */
    }
    .topcss1 {
        margin-top: 110px;
    }
    .ud-btn-apply{
        border-radius: 4px;
        display: inline-block;
        font-family: var(--title-font-family);
        font-weight: 700;
        font-size: 15px;
        font-style: normal;
        letter-spacing: 0em;
        padding: 5px 20px;
        position: relative;
        overflow: hidden;
        text-align: center;
        z-index: 0;
    }
    .form-control-coupan{
        border-radius: 8px;
        border: 2px solid transparent;
        box-shadow: none;
        height: 31px;
        outline: 1px solid #E9E9E9;
        padding-left: 5px;
    }
    #promocode{
        padding: 0 10px !important;
    font-size: 15px;
    }
    .form-control-coupan:focus {
        border: 2px solid transparent; /* Keep the same border on focus */
        outline: 1px solid #E9E9E9;
    }
    .cleaners-div{
        width: 160px !important;
        height: 220px;
        border: 0.5px solid #e0e0e0;
        padding: 10px;
        border-radius: 10px;
    }
    .cleaners-div:hover{
        border: 0.5px solid #0040E6;
    }
    .cleaners-radio:checked + .cleaners-div {
        border: 0.5px solid #0040E6;
    }
     .cleaner-image {
        display: table;
        margin: 0 auto;
    }
    .cleaners-image-style{
        border-radius: 50% !important;
    }
    .cleaner-detail {
        display: flex;
        flex-direction: column;
        align-items: center; 
    }
    .cleaner-detail p {
        margin: 0; 
        line-height: normal; 
    }
    .cleaner-name {
        font-weight: 100;
        font-size: 16px;
        color: #000;
        text-align: center;
       /*  text-decoration: underline; */
        margin-top: 10px !important;
    }
    .cleaners-para {
        font-size: 15px;
        text-align: center;
        margin-top: 10px !important;
    }
    .popup-cleaner-image{
        width: 150px; 
        height: 150px;
        border-radius: 10px;
    }
    .cleaner-nationality{
       background-color: #ffda40;
       color: #000;
       border-radius: 5px;
       padding: 0 10px 0 10px;
       font-weight: 500;
       margin-top: 5px !important;
    }
    .selected-cleaner {
        border: 0.5px solid #0040E6;
    }
    .disabled-slot {
    opacity: 0.5;
        pointer-events: none;
    }
    .charges-icon{
        background: #ffda40;
        border-radius: 50%;
        height: 22px;
        width: 22px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 1000;
        color: #000;
        font-size: 10px;
    }
    .service-fee-custome-modal{
        max-width: 450px !important; 
    }
    .popup-price{
        margin-left: 55%;
    }
   
.radio-slider-wrapper {
    display: flex;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch; /* enables momentum swipe on iOS */
    scroll-behavior: smooth;
    gap: 0.75rem;
    padding: 10px;
}

.radio-slider-wrapper::-webkit-scrollbar {
    display: none;
}

.radio-item {
    flex: 0 0 auto;
    scroll-snap-align: start;
}

.radio-item input[type="radio"] {
    display: none;
}

.radio-item label {
    display: inline-block;
    padding: 8px 16px;
    border: 2px solid #ccc;
    border-radius: 999px;
    background-color: #fff;
    color: #333;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.radio-item input[type="radio"]:checked + label {
    background-color: #0040E6;
    border-color: #0040E6;
    color: white;
}

.category-slider-container {
    position: relative;
    display: flex;
    align-items: center;
}

.slider-scroll-wrapper {
    overflow: hidden;
    width: 100%;
}

.radio-slider-wrapper {
    display: flex;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scroll-behavior: smooth;
    gap: 0.75rem;
    padding: 10px 0; /* Remove horizontal padding, avoid overlap */
}

.radio-slider-wrapper::-webkit-scrollbar {
    display: none;
}

/* Arrow styles */
.slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: white;
    border: 1px solid #ddd;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 10;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
}

.left-arrow {
    left: -15px; /* Push outside */
}

.right-arrow {
    right: -15px; /* Push outside */
}
@media (max-width: 768px) {
    .slider-arrow {
        width: 24px;
        height: 24px;
        font-size: 14px;
    }

    .left-arrow {
        left: -15px;
    }

    .right-arrow {
        right: -15px;
    }
    .material label {
        border-radius: 23px;
        padding: 8px 20px;
    }
    /* .last-summary-para{
        margin-top: -30px !important;
    } */
 }


	.body_content{background-color: #fafafa;}
	
	header.nav-homepage-style{
		background-color: #fff;
	}
	
	#summary_div_left_package{background-color: #fff;border:1px solid #ccc;box-shadow: inherit;}
	
    #reschedule_form {
        border: 1px solid #ccc;
        background-color: #fff;
        padding: 13px 13px 13px 20px;
        border-radius: 10px;
    }
@media (max-width: 767px) {
    .step-p{
        font-size:18px !important;
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
        margin: 0px 0 -10px 32px !important;
    }
    .subservice-name{
        font-size: 20px !important;
    }
    .modal-header h6{
        font-size: 18px !important;
        padding: 1px 22px 2px 7px !important;
      }
    .cancel-policy-back {
        flex-direction: column;
        align-items: flex-start;
    }

    .cancel-details {
        float: none;
        /* margin-top: 8px; */
    }
    .cancel-text img {
       margin-bottom: 30px !important;
    }
    #cancel-table table tr td span{
    font-size: 14px !important; 
    }
    .cleaners-image-style{
        width: 70% !important;
    }
    .cleaners-para{
        line-height: 1.0 !important;  
    }
    .cleaner-name{
        font-size: 14px !important; 
    }
    .cleaners-div{
        height: 190px !important;
        width: 140px !important;
    }
    #tab2-div{
        min-height:0px !important;
    }
    .modal-mobile{
        padding: 10px 16px !important;
    }
    .modal-header-mobile{
        padding: 10px 10px 2px 10px !important;
    }
}
 .back-icon i {
        font-size: 25px;
        cursor: pointer;
    }
.cancel-policy-back {
    background-color: #F5F5F5 !important;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    padding: 10px 10px;
    width: 100%;
    border-radius: 6px;
}

.cancel-text {
    display: flex;
    align-items: center;
    flex: 1 1 auto;
    font-size: 14px;
    color: #555;
    margin-right: 10px;
}

.cancel-text img {
    height: 15px;
    width: 15px;
    margin-right: 8px;
    flex-shrink: 0;
}

.cancel-details {
    cursor: pointer;
    font-weight: 600;
    color: #0040E6;
    text-decoration: underline;
    font-size: 13px;
    float: right;
}
#cancel-table table{
    width:100% !important;  
}
.cancel-footer{
    color: #FF4757;
}
.charge-desc-popup{
    border-radius: 13px !important;
}
#tab2-div{
    min-height:1100px;
}
.container {
    max-width: 1005px !important;
}
.modal{
    z-index:99999 !important;
}

.summarydev {
    font-size: 15px;
    margin-bottom: 0;
}
.subheadingdev {
    font-size: 13px;
}
.blur-loader {
    filter: blur(3px);
    pointer-events: none;
    opacity: 0.6;
}
.dhiram {
    width: 15px;
}
</style>

<section class="our-register">
    <div class="container">
        
         <div id="service-step-title" class="main-title">
         <a href="{{ route('order-detail', $ci_order_item->order_id) }}">
                <span class="back-icon"><i class="fas fa-arrow-left"></i></span>
            </a><h2 class="title step-title">Reschedule</h2>
        </div>
        
        <div class="row justify-content-center">
        <div class="col-md-9">

      
        
        <form id="reschedule_form" action="{{ route('reschedule-from',$ci_order_item->order_id)}}"     method="POST" >
        @csrf
        <input type="hidden" name="old_order_id" id="old_order_id" value="{{ $ci_order_item->order_id}}">
        <input type="hidden" name="ci_cleaner_id" id="ci_cleaner_id" value="{{ $ci_order_item->cleaner_id}}">
        <input type="hidden" name="ci_date" id="ci_date" value="{{ $ci_order_item->bookingdate}}">
        <input type="hidden" name="ci_month" id="ci_month" value="{{ $ci_order_item->month}}">
        <input type="hidden" name="ci_year" id="ci_year" value="{{ $ci_order_item->bookingyear}}">
        <input type="hidden" name="ci_how_many_hours_should_they_stay" id="ci_how_many_hours_should_they_stay" value="{{ $ci_order_item->how_many_hours_should_they_stay }}">
        <input type="hidden" name="ci_weekly_off_charge" id="ci_weekly_off_charge" value="0">
        <input type="hidden" name="ci_subservice_id" id="ci_subservice_id" value="{{ $ci_order_item->subservice_id}}">
               

        <div class="tab2" id="tab2-div">

        <div class="form-group mb-3 cancel-policy-back">
                <div class="cancel-content">
                    <div class="cancel-text">
                        <img src="{{ asset('public/site/images/infoicon.svg') }}" alt="Info" data-bs-toggle="modal" data-bs-target="#cancel_policy_{{ $ci_order_item->subservice_id }}" style="cursor: pointer;">
                        Enjoy free cancellation up to 6 hours before your booking start time.
                    </div>
                    <a class="cancel-details" data-bs-toggle="modal" data-bs-target="#cancel_policy_{{ $ci_order_item->subservice_id }}">Details</a>
                </div>
            </div>

        @php
            $cleanerIds = explode(',',$ci_order_item->cleaner_id);
        @endphp

        @if($ci_order_item->subservice_id == 28 && count($cleanerIds) == 1)
        <div id="cleaner_section">
        @if($ci_orders->user_id != "")
            @php
           
            $firstCleaner = DB::table('users')
                            ->where('role_id','16')
                            ->whereRaw("FIND_IN_SET(?, service)", [$ci_order_item->service_id])
                            ->whereRaw("FIND_IN_SET(?, subservice)", [$ci_order_item->subservice_id])
                            ->orderBy('id', 'asc') // Ensures the first cleaner is prioritized
                            ->limit(1);

            $otherCleaners = DB::table('users')
                            ->where('role_id','16')
                            //->where('area', 'LIKE', '%' . $user_data->area . '%')
                            ->whereRaw("FIND_IN_SET(?, service)", [$ci_order_item->service_id])
                            ->whereRaw("FIND_IN_SET(?, subservice)", [$ci_order_item->subservice_id]);

            $cleaners = $firstCleaner->union($otherCleaners)->get();
                        
            @endphp
    <div class="form-group mb-3">
    <label class="form-label fw500 dark-color" for="country">Select your preferred cleaner</label>
    <div id="select_your_cleaner_slider_spatie" class="splide ">
        <div class="splide__track ">
            <ul class="splide__list">
                @foreach($cleaners as $data)
                   <li class="splide__slide text-center ">
                        <label for="cleaner_{{ $data->id }}" class="cleaner-label-wrapper">
                            <input type="radio" id="cleaner_{{ $data->id }}" name="cleaner" class="cleaners-radio" value="{{ $data->name }}"
                                {{ isset($ci_order_item->cleaner_id) && $ci_order_item->cleaner_id == $data->id ? 'checked' : '' }} hidden>
                            
                            <div class="cleaners-div" onclick="cleaner_data('{{ $data->id }}', '{{ $data->name }}');">
                                <div class="items">
                                    <div class="cleaner-image">
                                        <img src="{{ url('public/upload/cleaners/large/' . $data->profile_image) }}" class="cleaners-image-style">
                                    </div>

                                    <div class="cleaner-detail">
                                        @if($data->id != 2)
                                            <a style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#cleaner_description_{{ $data->id }}">
                                                <p class="cleaner-name">{{ $data->name }}</p>
                                            </a>
                                        @else
                                            <a style="cursor: pointer;">
                                                <p class="cleaner-name">{{ $data->name }}</p>
                                            </a>
                                        @endif

                                        @if($data->id != 2)
                                            <p class="cleaner-nationality">{{ $data->nationality }}</p>
                                            <p class="cleaners-para">Recommended in your Area</p>
                                        @else
                                            <p>&nbsp;</p>
                                            <p class="cleaners-para">Best in Your Area</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </label>
                    </li>

                @endforeach
            </ul>
          </div>
        </div>

        <p class="form-error-text" id="cleaner_error" style="color: red; margin-top: 10px;"></p>
    </div>

            @endif
            </div>
            @endif


                <div class="form-group mb-3">
                    <label class="form-label fw500 dark-color " for="country">When would you like your service?</label>
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

                  <div class="form-group mb-3">
                        <label class="form-label fw500 dark-color" for="country">What time would you like us to start?</label>
                        <div class="radio-group time-slot-grid time_replace_ab">
                            @php

                            use Carbon\Carbon;
                            date_default_timezone_set('Asia/Dubai');
                            $timeslot = DB::table('time_slots')->orderBy('set_order','asc')->get()->toArray();
                            $currentTime = Carbon::now();
                            $bufferTime = $currentTime->copy()->addHours(2);
                            $i = 1;
                            
                            @endphp

                            @foreach($timeslot as $timeslot_data)
                            @php
                                // Parse the start time from slot name
                                $startTimeString = explode('-', $timeslot_data->name)[0];
                                $slotStartTime = Carbon::createFromFormat('g:i A', trim($startTimeString), 'Asia/Dubai');

                                // Skip if slot is not after buffer time
                                if ($slotStartTime->lt($bufferTime)) {
                                    continue;
                                }

                                // Get service-specific timeslot price
                                $timeslot_service = DB::table('subservice_timeslot_price')
                                    ->where('subservice_id', $ci_order_item->subservice_id)
                                    ->where('time_slot_id', $timeslot_data->id)
                                    ->where('is_active', 1)
                                    ->first();

                                $timeslot_service_price = $timeslot_service && $timeslot_service->price > 0 ? $timeslot_service->price : 0;
                            @endphp

                            @if($timeslot_service && $timeslot_service->is_active == 1)
                                <div class="surcharge-badge-timeslot items">
                                    @if($timeslot_service_price > 0)
                                        <span>+ <span class="currency_dhiram"></span> {{ $timeslot_service_price }}</span>
                                    @endif
                                    <input type="radio" id="time{{ $i }}" name="time_slot"
                                        data-name="{{ $timeslot_data->name }}"
                                        onclick="timeslot_price('{{ $timeslot_service_price }}', '{{ $timeslot_data->name }}', this);"
                                        value="{{ $timeslot_data->id }}" {{ isset($ci_order_item->time_slot) && $ci_order_item->time_slot == $timeslot_data->id ? 'checked' : '' }}>
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

                    <button type="button" class="ud-btn btn-thm default-box-shadow2 order_now custome-black book-now-web" id="nextBtn12" 
                    onclick="reschedule_order();">Reschedule</button>

                
                </div>
                </div>
               
            </form>

            
        </div>
    </div>
</div>
    
</section>

@include('front.includes.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.43/moment-timezone-with-data.min.js"></script>



<!--- Cancel Policy Popup start ---->
    @php
    $subservice_service_fee_popup = DB::table('subservices')->where('id',$ci_order_item->subservice_id)->first();
    @endphp

 <div class="modal modal-mobile-bottom" id="cancel_policy_{{$ci_order_item->subservice_id}}"  tabindex="-1" aria-labelledby="materialTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-bottom  modal-lg service-fee-custome-modal modal-dialog-centered" id="modal-digi" role="document">
        <div class="modal-content">
            <div class="modal-header" >
            <h6 class="modal-title" id="LearnmoreTitle">Cancellation and rescheduling policy </h6>
            <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <div>
                    <span id="cancel-table">{!! html_entity_decode($subservice_service_fee_popup->cancel_policy) !!}</span>
                </div>
            </div>
            <div class="modal-footer">
                <p class="cancel-footer">*You can reschedule a cash-paid booking up to two times.</p>
           
            </div>
        </div>
        </div>
</div>
<!--- Cancel Policy Popup End ---->


<!---Cleaners Popup Modal Start ---->
@if($ci_order_item->subservice_id == 28)     
@if($ci_orders->user_id !="")     
@foreach($cleaners as $data)
  
<div class="modal modal-mobile-bottom cleaners-modal" id="cleaner_description_{{$data->id}}"  tabindex="-1" aria-labelledby="materialTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom modal-lg modal-dialog-centered" id="modal-digi" role="document" style="max-width: 50%;">
      <div class="modal-content">
        <div class="modal-header" style="border:none;">
         <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        
        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
            <div style="max-width: 500px; margin: 20px auto; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); text-align: center; font-family: Arial, sans-serif;">
                <h3 style="font-size: 30px; color: #333; margin-bottom: 20px;">Cleaner Profile</h3>
                
                <div style="display: flex; align-items: center; gap: 20px;">
                    <div class="popup-cleaner-image">
                        <img src="{{ url('public/upload/cleaners/large/' . $data->profile_image) }}"  >
                    </div>
                    <div style="text-align: left; font-size: 18px; color: #555;">
                        <p><strong>Name:</strong> {{ $data->name }}</p>
                        <p><strong>Nationality:</strong> {{ $data->nationality }}</p>
                        <p><strong>Languages:</strong> {{ $data->language }}</p>
                    </div>
                </div>
            </div>
              <span>  {!! html_entity_decode($data->cleaner_desc) !!}</span>
        </div>
        <div class="modal-footer">
         
        </div>
      </div>
    </div>
  </div>

@endforeach
@endif
@endif

<!---Cleaners Popup Modal End ---->

<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>


<script>

function cleaner_data(id,name){

    $('#ci_cleaner_id').val(id);
    $('input[name="time_slot"]').prop('checked', false);
    $('#ci_date').val('');
    $('#date').val('');
    $('#ci_month').val(''); 
    $('#month').val(''); 
    $('.dates-container .is-selected').removeClass('is-selected'); 
    $('#when_would_you_start_slider .disabled-slot').removeClass('disabled-slot'); 
}    

</script>
   
<script>
  const preselectDay = {{ $ci_order_item->bookingdate }};
  const preselectMonth = "{{ $ci_order_item->month }}";
  const preselectYear = {{ $ci_order_item->bookingyear }};
</script>

<script>
let scrollIndex = 0;
const daysToShow = 14; // The number of days being displayed
const visibleDays = 5; // Number of days visible at once in the container
const dayWidth = 70; // The width of each day element (adjust this as needed)
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

// Function to update enabled/disabled calendar days
function updateCalendarDays() {
    const selectedDays = getSelectedDays();
    const calendarDays = document.querySelectorAll('.calendar-day');

    calendarDays.forEach(day => {
        const dayLabel = day.querySelector('.calendar-day-label').textContent;
        if (selectedDays.length === 0 || selectedDays.includes(dayLabel)) {
            day.classList.remove('disabled');
        } else {
            day.classList.add('disabled');
        }
    });
}

// Function to get selected checkboxes (weekdays)
function getSelectedDays() {
    const selectedCheckboxes = document.querySelectorAll('input[name="which_day_of_the_week_do_you_want_the_service[]"]:checked');
    const selectedDays = Array.from(selectedCheckboxes).map(checkbox => {
        switch (checkbox.value) {
            case 'Monday': return 'Mo';
            case 'Tuesday': return 'Tu';
            case 'Wednesday': return 'We';
            case 'Thursday': return 'Th';
            case 'Friday': return 'Fr';
            case 'Saturday': return 'Sa';
            case 'Sunday': return 'Su';
        }
    });
    return selectedDays;
}

// Generate the next 14 days in the calendar
const datesContainer = document.getElementById('dates-container');
const daysWrapper = document.getElementById('days-wrapper');
const scrollLeftBtn = document.getElementById('scroll-left');
const scrollRightBtn = document.getElementById('scroll-right');

const today = new Date();
for (let i = 0; i < daysToShow; i++) {
    const currentDate = addDays(today, i);
    const formattedDate = formatDate(currentDate);

    const dayDiv = document.createElement('div');
    dayDiv.classList.add('calendar-day');
    dayDiv.innerHTML = `
    <div class="calendar-day-label">${formattedDate.day}</div>
    <div class="calendar-date-label">${formattedDate.date}</div>
    ${
        (formattedDate.day === 'Sa' || formattedDate.day === 'Su' || isToday(currentDate))
        ? `<div class="surcharge-badge-dayslot" style="position:relative;">
               <span>+ <p class="currency_dhiram"></p> 5</span>
           </div>`
        : ''
    }
`;

    // Check if this date matches the preselected date
    if (
        formattedDate.date === preselectDay &&
        formattedDate.month === preselectMonth &&
        formattedDate.year === preselectYear
    ) {
        dayDiv.classList.add('is-selected');

        // Update hidden inputs & weekly charge as in your click event
        if (formattedDate.day === 'Sa' || formattedDate.day === 'Su' || isToday(currentDate)) {
            $('#ci_weekly_off_charge').val(5);
        } else {
            $('#ci_weekly_off_charge').val(0);
        }
        $('#ci_date').val(formattedDate.date);
        $('#ci_month').val(formattedDate.month);
        $('#date').val(formattedDate.date);
        $('#month').val(formattedDate.month);
    }

    dayDiv.addEventListener('click', function() {
        if (!dayDiv.classList.contains('disabled')) {
            document.querySelectorAll('.calendar-day').forEach(day => day.classList.remove('is-selected'));
            dayDiv.classList.add('is-selected');

            var ci_weekly_off_charge = 0;
            if (formattedDate.day === 'Sa' || formattedDate.day === 'Su' || isToday(currentDate)) {
                ci_weekly_off_charge = 5;
            }
            $('#ci_weekly_off_charge').val(ci_weekly_off_charge);

            $('#ci_date').val(formattedDate.date);
            $('#ci_month').val(formattedDate.month);
            $('#date').val(formattedDate.date);
            $('#month').val(formattedDate.month);
        }
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
// Scroll left button click event
scrollLeftBtn.addEventListener('click', () => {
    if (scrollIndex > 0) {
        scrollIndex -= 1;
        updateVisibleDays();
    }
});

// Scroll right button click event
scrollRightBtn.addEventListener('click', () => {
    if (scrollIndex < daysToShow - visibleDays) {
        scrollIndex += 1;
        updateVisibleDays();
    }
});

// Function to handle checkbox changes and update the calendar
document.querySelectorAll('input[name="which_day_of_the_week_do_you_want_the_service[]"]').forEach(checkbox => {
    checkbox.addEventListener('change', updateCalendarDays);
});

// Initialize the calendar days
updateCalendarDays();

//const daysWrapper = document.getElementById('days-wrapper');
let isDown = false;
let startX;
let scrollLeft;

// Prevent text selection globally during dragging
const disableTextSelection = () => {
    document.body.style.userSelect = 'none';
};

const enableTextSelection = () => {
    document.body.style.userSelect = 'auto';
};

// Mouse Events (for desktop)
daysWrapper.addEventListener('mousedown', (e) => {
    isDown = true;
    daysWrapper.classList.add('dragging');
    startX = e.pageX - daysWrapper.offsetLeft;
    scrollLeft = daysWrapper.scrollLeft;
    disableTextSelection(); // Disable text selection on mousedown
});

daysWrapper.addEventListener('mouseleave', () => {
    isDown = false;
    daysWrapper.classList.remove('dragging');
    enableTextSelection(); // Enable text selection when drag ends
});

daysWrapper.addEventListener('mouseup', () => {
    isDown = false;
    daysWrapper.classList.remove('dragging');
    enableTextSelection(); // Enable text selection when drag ends
});

daysWrapper.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - daysWrapper.offsetLeft;
    const walk = (x - startX) * 2; // Adjust the scroll speed for desktop drag
    daysWrapper.scrollLeft = scrollLeft - walk;
});

// Touch Events (for mobile)
daysWrapper.addEventListener('touchstart', (e) => {
    isDown = true;
    startX = e.touches[0].pageX - daysWrapper.offsetLeft;
    scrollLeft = daysWrapper.scrollLeft;
    disableTextSelection(); // Disable text selection for touch as well
});

daysWrapper.addEventListener('touchmove', (e) => {
    if (!isDown) return;
    const x = e.touches[0].pageX - daysWrapper.offsetLeft;
    const walk = (x - startX) * 1.5; // Adjust the scroll speed for touch devices
    daysWrapper.scrollLeft = scrollLeft - walk;
});

daysWrapper.addEventListener('touchend', () => {
    isDown = false;
    enableTextSelection(); // Enable text selection when drag ends
});

// Scroll left button click event
scrollLeftBtn.addEventListener('click', () => {
    daysWrapper.scrollLeft -= 300; // Adjust scroll distance for left button
});

// Scroll right button click event
scrollRightBtn.addEventListener('click', () => {
    daysWrapper.scrollLeft += 300; // Adjust scroll distance for right button
});


function updateVisibleDays() {
    // const offset = -scrollIndex * dayWidth; // Scroll amount based on the current index
    // daysWrapper.style.transform = `translateX(${offset}px)`;

    const maxScrollLeft = daysWrapper.scrollWidth - daysWrapper.clientWidth; // The max scroll left boundary
    const scrollAmount = scrollIndex * dayWidth;

    // Ensure the scroll doesn't exceed the boundaries
    if (scrollAmount <= maxScrollLeft) {
        daysWrapper.scrollLeft = scrollAmount;
    } else {
        daysWrapper.scrollLeft = maxScrollLeft; // Stop at the end
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
       
document.addEventListener('DOMContentLoaded', function () {
    new Splide('#select_your_cleaner_slider_spatie', {
        type: 'slide',
        perPage: 4,  // Show 4 items by default
        autoplay: false,
        pagination: false,
        arrows: false,
        gap: '1rem', // Adjust spacing between slides
        breakpoints: {
            1024: {
                perPage: 3,  // Show 3 on tablets
                gap: '1rem',
            },
            768: {
                perPage: 3 ,  // Show 2 on mobile
                gap: '0.75rem',
            },
            480: {
                perPage: 2,
                gap: '0.5rem',
            },
        },
        onInitialized: updateCloneIds,
        onMoved: updateCloneIds,
    }).mount();

    function updateCloneIds() {
        $('#select_your_cleaner .owl-item.cloned').each(function(index, element) {
            $(element).find('input[type="radio"]').each(function(i, radioButton) {
                var newId = $(radioButton).attr('id') + '_cloned_' + index;
                $(radioButton).attr('id', newId);
                $(radioButton).siblings('label').attr('for', newId);
            });
        });
    }
});

    </script>
 

<script>

function date_select() {

    var url = '{{ url('cleaner-time-check') }}';
    var cleaner_id = $('#ci_cleaner_id').val();
    var date = $('#ci_date').val();
    var month = $('#ci_month').val();
    var year = $('#ci_year').val();   
    var selectedHours = $('#ci_how_many_hours_should_they_stay').val();
    // alert(selectedHours);

    $('input[name="time_slot"]').prop('checked', false);
    $('input[name="time_slot"]').prop('disabled', false);
    $('.surcharge-badge-timeslot').removeClass('disabled-slot');

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            'cleaner_id': cleaner_id,
            'date': date,
            'month': month,
            'year': year,
            'subservice_id': '{{ $ci_order_item->subservice_id }}'
        },
          beforeSend: function() {
        // Show blur effect on time slot area
        $('.time_replace_ab').addClass('blur-loader');

        },
        success: function(response) {

            // alert(response);

            const res = response.data ?? response;
            const dateStr = `${res.date}-${res.month}-${res.year}`;
            const selectedDate = moment.tz(dateStr, 'D MMM YYYY', 'Asia/Dubai').startOf('day');
            const today = moment().tz('Asia/Dubai').startOf('day');
            const currentDateTime = moment.tz('Asia/Dubai');
            const isToday = selectedDate.isSame(today, 'day');
            const bufferTime = currentDateTime.clone().add(2, 'hours');
            

            let slotHtml = '';
            let i = 1;

            const allSlots = response.timeslot_master || [];
            const totalSlots = allSlots.length;
            const renderLimit = totalSlots - selectedHours;

            if (renderLimit <= 0) {
                $('.time_replace_ab').html('<p>No available time slots for selected duration</p>');
                return;
            }

            // Render time slots (excluding last N based on selected hours)
            allSlots.forEach(function(slot, index) {
                if (index >= renderLimit) return;

                let price =slot.price;

                slotHtml += `<div class="surcharge-badge-timeslot items">`;

                if (price > 0) {
                    slotHtml += `<span>+ <p class="currency_dhiram"></p> ${price}</span>`;
                }

                slotHtml += `
                    <input type="radio" id="time${i}" name="time_slot"
                        data-name="${slot.slot_name}"
                        onclick="timeslot_price('${price}', '${slot.slot_name}', this);"
                        value="${slot.time_slot_id}">
                    <label class="labeltime" for="time${i}" style="border-radius: 50px;">
                        ${slot.slot_name}
                    </label>
                </div>`;
                i++;
            });

            $('.time_replace_ab').html(slotHtml);

            const slots = $('input[name="time_slot"]');

            // Disable booked slots (and consecutive hours)
            if (res.cleaner_id !== '2') {
                const booked_slots = response.timeslot || [];
                const hours = response.hours || [];

                // alert(booked_slots);
                // alert(hours);

                booked_slots.forEach(function(slot, index) {
                    const slotValue = slot.toString();
                    const disableHours = parseInt(hours[index], 10);

                    slots.each(function(i) {
                        if ($(this).val() === slotValue) {
                            $(this).prop('disabled', true);
                            $(this).closest('.surcharge-badge-timeslot').addClass('disabled-slot');

                            for (let j = 1; j <= disableHours; j++) {
                                const nextSlot = slots.eq(i + j);
                                if (nextSlot.length) {
                                    nextSlot.prop('disabled', true);
                                    nextSlot.closest('.surcharge-badge-timeslot').addClass('disabled-slot');
                                }
                            }
                        }
                    });
                });
            }

            // Buffer logic (disable past slots for today)
            if (isToday) {
                slots.each(function() {
                    const timeName = $(this).data('name');
                    if (!timeName) return;

                    const timeText = timeName.split('-')[0].trim();
                    const slotStart = moment.tz(
                        selectedDate.format('YYYY-MM-DD') + ' ' + timeText,
                        'YYYY-MM-DD h:mm A',
                        'Asia/Dubai'
                    );

                    if (!slotStart.isValid()) return;

                    if (slotStart.isBefore(bufferTime)) {
                        $(this).prop('disabled', true);
                        $(this).closest('.surcharge-badge-timeslot').addClass('disabled-slot');
                    }
                });
            }

            // Final fallback if all slots are disabled
            const anyEnabled = $('input[name="time_slot"]:not(:disabled)').length > 0;
            if (!anyEnabled) {
                $('.time_replace_ab').html('<p>No available time slots</p>');
            }
        },
           complete: function() {
        // Remove blur and loader after success or error
        $('.time_replace_ab').removeClass('blur-loader');
 
    },
    });
}



function timeslot_price(price,name,element){

   
    let timeslotId = element.value;
    // alert(timeslotId);
    var cleaner_id = $('#ci_cleaner_id').val();

    // alert(cleaner_id);
    var date = $('#ci_date').val();
    var month = $('#ci_month').val();
    var year = $('#ci_year').val();   
    var selectedHours = $('#ci_how_many_hours_should_they_stay').val();

    // alert(selectedHours);

    var subserviceId = '{{ $ci_order_item->subservice_id }}';

    

    let hours = selectedHours;

        var url = "{{ url('hours-check')}}";
        // alert(hours);
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                "_token": "{{ csrf_token() }}",
                 "hours": hours,
                 "timeslotId" : timeslotId,
                 "cleaner_id" : cleaner_id,
                 "date" : date,
                 "month" : month,
                 "year" : year,
                 "subserviceId" : subserviceId,
            },
            dataType: "json",  // Ensure response is treated as JSON
            success: function(response) {
                if (response.status === "error") {
                    alert(response.message); 
                    $("#time" + timeslotId).prop("checked", false);
                    $('#time_replace').html('');
                } else {
                    console.log("Success");
                }
            },
        });
         
}


function reschedule_order(){
    var date = $('#date').val();
            if (date == '') {
                jQuery('#date_error').html(
                    "Please Select Date");
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

    $('#reschedule_form').submit();
}
</script>





    

