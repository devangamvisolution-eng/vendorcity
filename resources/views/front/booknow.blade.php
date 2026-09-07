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

    .quantity .quantity-block{
        height: 60px;
        width: 84px;
    }
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
        /* padding-top: 20px; */
        /* display: inline-block; */
    }
    .time-slot-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* 2 columns */
        gap: 15px; /* spacing between items */
    }
	.surcharge-badge-timeslot {
		 position: relative;
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
        color: red;
        width: 30%;
        display: inline-block;
    }
    .surcharge-badge-dayslot span{
        position: relative;
        top: -83px;
        right: 17px; 
        background: #ffda40;
        padding: 2px 3px;
        color: #000;
        white-space: nowrap;
        font-size: 13px;
        border-radius: 8px;

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
        top: 145px !important;
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
        /* width: 40% !important; */
        /* margin-bottom: 100px !important; */
    }
    .mobile-view .col-lg-9{
        /* width: 60% !important; */
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
        margin-bottom: 5px;
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
            width: 520px;
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


.additional_charge_replace_div{display: none !important;}
.timing_charge_replace_div{display: none !important;}
.cod_charge_replace_div{display: none !important;}
.promo_dicount_replace_div{display: none !important;}

  #service-step-title {
        position: fixed;
        top: 92px !important;
        background: #fafafa;
        z-index: 2;
        padding: 10px 0;
           width: 562px;
        /* left: 0; */
        padding-left: 0;

        /* transition: all 0.4s ease; */
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
	.body_content{background-color: #fafafa;}
	
	header.nav-homepage-style{
		background-color: #fff;
	}
	
	#summary_div_left_package{background-color: #fff;border:1px solid #ccc;box-shadow: inherit;}
	
    #category_form_new {
            margin-top:80px !important;
			border: 1px solid #ccc;
			background-color: #fff;
    padding: 13px 20px 13px 20px;
    border-radius: 10px;
    /* min-height: 100vh; */
        }
@media (max-width: 767px) {
    .step-p{
        font-size:18px !important;
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
    /* #category_form_new {
        padding-top:100px;
    } */
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
    /* min-height:1100px; */
    min-height:500px; 
}
/* .scrollbalance-inner {
    width:93% !important;
} */

/* .scrollbalance-inner {
    position: fixed !important;
        top: inherit !important;
    left: inherit !important;
} */

.scrollbalance-inner {
  /* position: fixed; */
  top: 0;
  left: 0;
}

.summary_div_left_new {
    padding-top: 80px;
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
.booknow-otp-input{
    padding-left: 0px !important;   
}

.book-email-otp-input{
    padding-left: 0px !important;   
}


@media (max-width: 768px) {
  .mobile-furniture .price-row {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    flex-wrap: nowrap !important;
    margin-top: 6px;
  }

  .mobile-furniture .new-price {
    font-weight: 600;
    font-size: 15px;
    color: #000;
  }

  .mobile-furniture .old-price {
    font-size: 13px;
    color: #999;
    text-decoration: line-through;
    display: block;
    margin-top: 2px;
  }

  .mobile-furniture .btn.add-to-card {
    white-space: nowrap;
    padding: 4px 10px;
    font-size: 14px;
    line-height: 1.2;
  }

  #category_form_new{
    border: inherit;
    padding: 0;
  }
}

@media (min-width: 768px) and (max-width: 1024px) {
  #sticky-header.sticky-active{width: 100% !important;}
  #service-step-title{
    top: 80px !important;
    width: 100%;
    left: 11px;
  }
  #category_form_new{margin-top: 22px !important;}
  #sticky-header.sticky-active{top: 174px !important;left: 11px !important;}
}
.home_hour_p{font-size: 11px;margin: 0 0 0 0px;}
.home_hour_p img {
	    width: 13px;
}

.home_hour_span {
	   display: flex;
    align-items: center;
    gap: 4px;
    color: #000;
    justify-content: center;
}

.home_hour_span .currency_dhiram{
    width: 15px;
    height: 15px;
}

.additional_p{
	font-size: 13px;
    color: #000;
        display: flex;
    align-items: center;
    gap: 2px;
}
.additional_p .currency_dhiram{
        width: 15px;
    height: 15px;
}

.additional_p img{
	width: 14px;
    margin-top: -1px;
}

.dhiram {
    width: 15px;
}

.cross_amount_div strong{
	    display: flex;
    align-items: center;
    gap: 2px;
}

.main_price_new{
	display: flex;
    align-items: center;
    gap: 2px;
}

.sm-summary {
    /* max-width: 65%; */
    text-align: right;
    color: #0040E6;
    display: flex;
    align-items: center;
    gap: 2px;
}

.surcharge-badge-dayslot span .dhiram{
	width: 12px;
}

.cash_fee_p{
	color: #000;
    display: flex;
    align-items: center;
    gap: 2px;
}
.cash_fee_p .currency_dhiram{
	width: 15px;
    height: 15px;
}

.cross_amount_div{
    display: flex;
    align-items: center;
    gap: 2px;
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

</style>

<section class="our-register">
    <div class="container">
        
        <div id="service-step-title" class="main-title ">
            <div class="row">
                <div class="col-lg-12">
                    <p class="step-p">Step 1 of 4</p>
                    <h2 class="title step-title">
                        <span class="back-icon"></span> 
                        Service Details</h2>
                </div>

            </div>
            
        </div>
        <div class="devtest">
        <div class="row wrap">
        
            
        <div class="col-lg-7">
                <form id="category_form_new" action="{{ route('book_now_order') }}" method="POST" >
                    @csrf

                    <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
                    <input type="hidden" name="subservice_id" id="subservice_id" value="{{ $subservice_id }}">
                    <input type="hidden" name="apply_button" id="apply_button" value="0">
                    <input type="hidden" name="cancel_button" id="cancel_button" value="1">
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


                    @if($subservice_id == 30 || $subservice_id == 28)
                    {{-- <div class="image">
                        <img src="https://servicemarket.imgix.net/dist/css/img/service/cleaning-maid-services/about-cleaning.jpg" width="100%">
                    </div> --}}

                    <h5 class="font-weight-bold h3 subservice-name">{{ $subservice_name }} </h5>
                    <p class="card-text"><span>Complete the booking form, and we'll match you with a top-notch cleaner to ensure your home sparkles with freshness and comfort.</span>
                        @if($subservice_id == 28)
                        <a href="javascript:void(0)" data-bs-toggle="modal" id="read_more" data-bs-target="#exampleModalLong_{{$subservice_id}}" style="text-decoration: underline;">
                            Read more about Our Home Cleaning Service includes.
                        </a>
                    @endif
                    </p>

                    <div class="form-group mb-3  slider-top">
                        <label class="form-label fw500 dark-color " for="country">How many hours do you need your cleaner <span><br id="mobile_view_br"></span> to stay? 
                            @if($subservice_id == 28)
                            <span> 
                                <a style="cursor: pointer;margin-left:3px;" data-bs-toggle="modal" id="cleaner_stay" data-bs-target="#Learnmore_{{$subservice_id}}">
                                    <img src="{{ asset('public/site/images/infoicon.svg') }}" style="height: 15px;width: 15px;">
                                </a></span>
                        @endif
                        </label>
						
						@php
                        $cleaning_price = DB::table('cleanin_subserviceprice')->Where('subservice_id',$subservice_id)->get()->toArray();

                        $user_id = Session::get('user')['userid'] ?? "";

                        $is_first_time_user = !DB::table('ci_order_item')->where('user_info_id', $user_id)->where('subservice_id', '28')->first();

                        @endphp
						
                       <div id="how_many_hours_need_cleaner_slider_spatie" class="splide radio-group ">
                        <div class="splide__track">
                            <ul class="splide__list">

                            <li class="splide__slide text-center" >
                                <input type="radio" id="how_many_hours_2" name="how_many_hours_should_they_stay" value="2" onclick="calculation()">
                                            <label for="how_many_hours_2">2</label>
                                            <p style="" class="home_hour_p">
											<span class="home_hour_span">
											<span class="currency_dhiram"></span>
                                            @if($is_first_time_user)
                                            {{-- 18/hr --}}
                                            {{$cleaning_price[0]->hourly_price}}/hr
                                            @else
                                            {{$cleaning_price[0]->hourly_price}}/hr
                                            @endif
											</span>
                                            </p>
                            </li>

                            <li class="splide__slide text-center">
                                <input type="radio" id="how_many_hours_3" name="how_many_hours_should_they_stay" value="3" onclick="calculation()">
                                            <label for="how_many_hours_3">3</label>
											<p style="" class="home_hour_p">
											<span class="home_hour_span">
											<span class="currency_dhiram"></span>
                                            @if($is_first_time_user)
                                            {{-- 18/hr --}}
                                            {{$cleaning_price[1]->hourly_price}}/hr
                                            @else
                                            {{$cleaning_price[1]->hourly_price}}/hr
                                            @endif
											</span>
                                            </p>
                            </li>

                            <li class="splide__slide text-center">
                                <span class="popular">Popular</span>
                                            <input type="radio" id="how_many_hours_4" name="how_many_hours_should_they_stay" value="4" checked onclick="calculation()">
                                            <label for="how_many_hours_4">4</label>
                                       <p style="" class="home_hour_p">
											<span class="home_hour_span">
											<span class="currency_dhiram"></span>
                                            @if($is_first_time_user)
                                            {{-- 18/hr --}}
                                            {{$cleaning_price[2]->hourly_price}}/hr
                                            @else
                                            {{$cleaning_price[2]->hourly_price}}/hr
                                            @endif
											</span>
                                            </p>
                            </li>

                            <li class="splide__slide text-center">
                                <input type="radio" id="how_many_hours_5" name="how_many_hours_should_they_stay" value="5" onclick="calculation()">
                                            <label for="how_many_hours_5">5</label>
                                        <p style="" class="home_hour_p">
											<span class="home_hour_span">
											<span class="currency_dhiram"></span>
                                            @if($is_first_time_user)
                                            {{-- 18/hr --}}
                                            {{$cleaning_price[3]->hourly_price}}/hr
                                            @else
                                            {{$cleaning_price[3]->hourly_price}}/hr
                                            @endif
											</span>
                                            </p>
                            </li>

                            <li class="splide__slide text-center">
                                <input type="radio" id="how_many_hours_6" name="how_many_hours_should_they_stay" value="6" onclick="calculation()">
                                            <label for="how_many_hours_6">6</label>
                                        <p style="" class="home_hour_p">
											<span class="home_hour_span">
											<span class="currency_dhiram"></span>
                                            @if($is_first_time_user)
                                            {{-- 18/hr --}}
                                            {{$cleaning_price[4]->hourly_price}}/hr
                                            @else
                                            {{$cleaning_price[4]->hourly_price}}/hr
                                            @endif
											</span>
                                            </p>
                            </li>

                            <li class="splide__slide text-center">
                                <input type="radio" id="how_many_hours_7" name="how_many_hours_should_they_stay" value="7" onclick="calculation()">
                                            <label for="how_many_hours_7">7</label>
                                        <p style="" class="home_hour_p">
											<span class="home_hour_span">
											<span class="currency_dhiram"></span>
                                            @if($is_first_time_user)
                                            {{-- 18/hr --}}
                                            {{$cleaning_price[5]->hourly_price}}/hr
                                            @else
                                            {{$cleaning_price[5]->hourly_price}}/hr
                                            @endif
											</span>
                                            </p>
                            </li>
                            <li class="splide__slide text-center">
                                <input type="radio" id="how_many_hours_8" name="how_many_hours_should_they_stay" value="8" onclick="calculation()">
                                            <label for="how_many_hours_8">8</label>
                                        <p style="" class="home_hour_p">
											<span class="home_hour_span">
											<span class="currency_dhiram"></span>
                                            @if($is_first_time_user)
                                            {{-- 18/hr --}}
                                            {{$cleaning_price[6]->hourly_price}}/hr
                                            @else
                                            {{$cleaning_price[6]->hourly_price}}/hr
                                            @endif
											</span>
                                            </p>
                            </li>

                            <!-- Add more slides as needed -->

                            </ul>
                        </div>
                        </div>
                        <p class="form-error-text" id="how_many_hours_should_they_stay_error" style="color: red; margin-top: 10px;">
                        </p>
                    </div>
                    

                    <div class="form-group mb-3 slider-top">
                        <label class="form-label fw500 dark-color " for="country">How many cleaners do you require?</label>
                      <div id="how_many_cleaner_require_slider_spatie" class="splide radio-group">
                        <div class="splide__track">
                            <ul class="splide__list">

                        <li class="splide__slide text-center" >
                            <div class="items">
                                <input type="radio" id="1" name="how_many_cleaners_do_you_need" value="1" checked onclick="calculation(); cleaner_assign_value();" >
                                <label for="1">1</label>
                            </div>
                        </li>
                        
                        <li class="splide__slide text-center" >
                            <div class="items">
                                <input type="radio" id="2" name="how_many_cleaners_do_you_need" value="2" onclick="calculation()">
                                <label for="2">2</label>
                            </div>
                        </li>
                         <li class="splide__slide text-center" >
                            <div class="items">
                                <input type="radio" id="3" name="how_many_cleaners_do_you_need" value="3" onclick="calculation()">
                                <label for="3">3</label>
                            </div>
                         </li>
                          <li class="splide__slide text-center" >
                            <div class="items">
                                <input type="radio" id="4" name="how_many_cleaners_do_you_need" value="4" onclick="calculation()">
                                <label for="4">4</label>
                            </div>
                          </li>
                           <li class="splide__slide text-center" >
                            <div class="items">
                                <input type="radio" id="5" name="how_many_cleaners_do_you_need" value="5" onclick="calculation()">
                                <label for="5">5</label>
                            </div>
                           </li>
                            <li class="splide__slide text-center" >
                            <div class="items">
                                <input type="radio" id="6" name="how_many_cleaners_do_you_need" value="6"  onclick="calculation()">
                                <label for="6">6</label>
                            </div>
                         </li>
                        </ul>
                    </div>
                </div>
                        <p class="form-error-text" id="how_many_cleaners_do_you_need_error" style="color: red; margin-top: 10px;">
                        </p>
                </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw500 dark-color" for="country">How often do you need cleaning?</label>
                        
                        {{-- <select class="form-control" name="how_often_do_you_need_cleaning" id="how_often_do_you_need_cleaning" onchange="cleaning_change(this.value)">
                            <option value="">Select</option>
                            <option value="Once">Once </option>
                            <option value="Weekly">Weekly {{$weekly_discout}}</option>
                            <option value="Multiple times a week">Multiple times a week {{$multiple_time_week_discout}}</option>
                        </select> --}}
                        <div class="radio-group radio-checked">
                            <div class="button_weekly">
                            <input type="radio" id="cleaning_once" name="how_often_do_you_need_cleaning" value="Once" onclick="cleaning_change(this.value)" checked>
                            <label for="cleaning_once"><span style="font-weight:1000; ">ONCE</span>
                            <ul>
                                <li style="font-weight:500;">One Time Cleaning Session</li>
                            </ul>
                            </label>
                            </div>
                        
                            <div class="button_weekly">
                            <input type="radio" id="cleaning_weekly" name="how_often_do_you_need_cleaning" value="Weekly" onclick="cleaning_change(this.value)">
                            <label for="cleaning_weekly"><span><b>WEEKLY</b></span><span class="cleaning_weekly_new"><b>{{$weekly_discout}}</b></span>
                            <ul>
                                <li style="font-weight:500;">Get the same cleaner each time</li>
                                <li style="font-weight:500;">Easily manage your subscription</li>
                            </ul>
                            </label>
                            </div>
                        
                            <div class="button_weekly">
                            <input type="radio" id="cleaning_multiple_times" name="how_often_do_you_need_cleaning" value="Multiple times a week" onclick="cleaning_change(this.value)">
                            <label for="cleaning_multiple_times"><span><b>Multiple Times a Week</b></span><span class="cleaning_weekly_new"><b>{{$multiple_time_week_discout}}</b></span>
                            <ul>
                                <li style="font-weight:500;">Get the same cleaner each time</li>
                                <li style="font-weight:500;">Easily manage your subscription</li>
                            </ul>
                            </label>
                            </div>
                            <p class="form-error-text" id="how_often_do_you_need_cleaning_error" style="color: red; margin-top: 10px;">
                        </p>
                        </div>
                        

                    </div>

                    <div class="form-group mb-3" style="display: none" id="weekly_div">
                        <label class="form-label fw500 dark-color " for="country">Which days of the week do you want the service?</label>

                        <div class="checkbox-group">
                            <input type="checkbox" id="Monday"   name="which_day_of_the_week_do_you_want_the_service[]" value="Monday">
                            <label for="Monday">Monday</label>
                    
                            <input type="checkbox" id="Tuesday" name="which_day_of_the_week_do_you_want_the_service[]" value="Tuesday">
                            <label for="Tuesday">Tuesday</label>
                    
                            <input type="checkbox" id="Wednesday" name="which_day_of_the_week_do_you_want_the_service[]" value="Wednesday">
                            <label for="Wednesday">Wednesday</label>

                            <input type="checkbox" id="Thursday" name="which_day_of_the_week_do_you_want_the_service[]" value="Thursday">
                            <label for="Thursday">Thursday</label>

                            <input type="checkbox" id="Friday" name="which_day_of_the_week_do_you_want_the_service[]" value="Friday">
                            <label for="Friday">Friday</label>

                            <input type="checkbox" id="Saturday" name="which_day_of_the_week_do_you_want_the_service[]" value="Saturday">
                            <label for="Saturday">Saturday</label>

                            <input type="checkbox" id="Sunday" name="which_day_of_the_week_do_you_want_the_service[]" value="Sunday">
                            <label for="Sunday">Sunday</label>
                        </div>

                        <p class="form-error-text" id="which_day_of_the_week_do_you_want_the_service_error" style="color: red; margin-top: 10px;">
                        </p>

                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw500 dark-color cleaning-mobile" for="country">Need cleaning materials? </label>
                        <img src="{{ asset('public/site/images/dettol.png') }}" style="height: 25px;margin-right:-13px;">
                       <p class="dettol">Powered by Dettol</p>
                       @if($subservice_id == 28)
                            <span> 
                            <a style="cursor: pointer;margin-left:3px;" data-bs-toggle="modal" id="cleaner_stay" data-bs-target="#material_{{$subservice_id}}">
                            <img src="{{ asset('public/site/images/infoicon.svg') }}" style="height: 15px;width: 15px;">                           
                            </span>
                            </a>@endif
                        <p class="additional_p">An additional charge of <span class="currency_dhiram"></span> 10/hr applies.</p>
                        <div class="radio-group">
                        <div class="material">
                            <input type="radio" id="do_you_need_yes" name="do_you_need_cleaning_material" value="Yes" onclick="calculation()">
                            <label for="do_you_need_yes">Yes</label>

                            <input type="radio" id="do_you_need_no" name="do_you_need_cleaning_material" value="No" onclick="calculation()" checked>
                            <label for="do_you_need_no">No</label>
                        </div>
                        </div>
                        <p class="form-error-text" id="do_you_need_cleaning_material_error" style="color: red; margin-top: 10px;">
                        </p>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw500 dark-color " for="country">Do you have any special instructions?</label>
                        <textarea name="any_special_instruction" id="any_special_instruction" placeholder="Example: You need a gate pass to enter the community, building code is #1234, etc."></textarea>

                        <p class="form-error-text" id="any_special_instruction_error" style="color: red; margin-top: 10px;">
                        </p>
                    </div>

                    @endif


                    @if($subservice_id == 70 || $subservice_id == 71 || $subservice_id == 29 || $subservice_id == 72 || $subservice_id == 73 || $subservice_id == 79 || $subservice_id == 80 || $subservice_id == 81 || $subservice_id == 82 || $subservice_id == 83 || $subservice_id == 84 || $subservice_id == 85 || $subservice_id == 86 || $subservice_id == 87 || $subservice_id == 88 || $subservice_id == 52 || $subservice_id == 93)

                    @php
                    $subservice_data = DB::table('subservices')
                                    ->where('id',$subservice_id)
                                    ->first();
                    @endphp

                        @php
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


                            <!-- Upper Category Pills (shown initially) -->
                            <div class="form-group mb-3 mobile-category-wrapper">
                                <div class="radio-group mobile-radio d-flex flex-wrap">
                                    @foreach($package_cat as $package_cat_data)
                                        <div class="radio-item me-2">
                                            <input 
                                                type="radio" 
                                                id="mobile-cat-{{ $package_cat_data->id }}" 
                                                name="package_cat" 
                                                value="{{ $package_cat_data->id }}" 
                                                class="d-none"
                                                @if($loop->first) checked @endif>
                                            <label for="mobile-cat-{{ $package_cat_data->id }}" class="category-pill">
                                                {{ $package_cat_data->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Sticky Header with Slider (hidden initially) -->
                            <div class="form-group mb-3 slider-category-wrapper d-none container-fluid px-3"  id="sticky-header">
                                <div class="category-slider-container position-relative d-flex align-items-center">
                                    
                                    <button type="button" class="slider-arrow left-arrow">&#10094;</button>
                                    <div class="slider-scroll-wrapper flex-grow-1 position-relative">
                                        <div class="radio-slider-wrapper d-flex flex-nowrap overflow-auto" id="radioSlider">
                                            @foreach($package_cat as $index => $package_cat_data)
                                                <div class="radio-item me-2 flex-shrink-0">
                                                    <input 
                                                        type="radio" 
                                                        id="cat-{{ $package_cat_data->id }}" 
                                                        name="package_cat" 
                                                        value="{{ $package_cat_data->id }}" 
                                                        class="d-none"
                                                        @if($loop->first) checked @endif>
                                                    <label for="cat-{{ $package_cat_data->id }}" class="category-pill">
                                                        {{ $package_cat_data->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <button type="button" class="slider-arrow right-arrow">&#10095;</button>
                                </div>
                            </div>

             
                       
                    <div class="image">
                        @if($subservice_data->service_detail_image !="") 
                        <img src="{{ url('public/upload/subservice/' . $subservice_data->service_detail_image) }}" class="img-fluid subservice-image" alt="{{ $subservice_data->image_alt_tag ??  $subservice_data->subservicename }}" >
                        @else
                        <img src="{{ asset('public/site/images/no-image.jpg') }}" class="img-fluid subservice-image" alt="{{ $subservice_data->image_alt_tag ??  $subservice_data->subservicename }}">
                        @endif
                    </div>

                   
                    <div class="subservice-desc">
                    <h5 class="font-weight-bold h3 subservice-name">About our {{ $subservice_name }} Service </h5>
                    @if(!empty($subservice_data->service_detail_short_description))
                    <p style="margin-bottom: 0;">{{ $subservice_data->service_detail_short_description }}</p>
                    @endif
                    <a href="javascript:void(0)" class="custom-arrow" 
                    data-bs-toggle="modal" id="read_more" 
                    data-bs-target="#subservice_popup_{{$subservice_data->id}}">Read more </a>
                    </div>

                    @if(!empty($package_cat))

                            @foreach($package_cat as $package_cat_data)

                            @php
                                $package = DB::table('packages')
                                                ->where('service_id',$service_id)
                                                ->where('subservice_id',$subservice_id)
                                                ->where('packagecategory_id',$package_cat_data->id)
                                                ->orderBy('set_order')
                                                ->get()->toArray();

                                //$package =array();

                                //echo"<pre>";print_r($package);echo"</pre>";
                            @endphp




                            <div class="form-group mb-3 package-category-class" id="package-category-{{ $package_cat_data->id }}" >

                                <h4 class="mb-3"><strong>{{ $package_cat_data->name }}</strong></h4>

                                @if($package_cat_data->image != "")
                                <img src="{{ url('public/upload/packagecategory/large/' . $package_cat_data->image) }}" alt="{{ $package_cat_data->image_alt_tag ?? $package_cat_data->name }}" class="w-100 rounded mb-4">
                                @endif



                                @if(!empty($package))

                                @foreach($package as $package_data)


                                <div class="row align-items-center mobile-view">
                                   @if(!empty($package_data->image))
                                    <div class="col-lg-3 col-3 text-center">
                                         
                                        <img src="{{ url('public/upload/packages/large/' . $package_data->image) }}" alt="{{ $package_data->image_alt_tag ?? $package_data->name }}" class="img-fluid furniture-small-image">
                                        
                                    </div>
                                     @endif

                                     @php
                                        if(!empty($package_data->image)){
                                           $classN = "col-lg-9 col-9 mobile-furniture"; 
                                        }else{
                                            $classN = "col-lg-12 col-9 ";
                                        }
                                     @endphp
                                   
                                    <div class="{{$classN}}">
                                        <div class="package-data-div" style="cursor: pointer;" data-bs-toggle="modal" id="furniture_popup_{{$package_data->id}}" data-bs-target="#material_furniture_{{$package_data->id}}">
                                        <h5 style="margin: 0;color:#000;">{{ $package_data->name }}</h5>
                                        <span> 
										{{-- <a style="cursor: pointer;" data-bs-toggle="modal" id="furniture_popup_{{$package_data->id}}" data-bs-target="#material_furniture_{{$package_data->id}}">
                                        <i class="fa-solid fa-info furniture-learn-more"></i>
                                        <span id="learn_more" style="font-weight: 50;">Learn more</span></a> --}}
                                        </span>
                                        </div>
                                        
                                        <p class="furniture-short-desc">{{ $package_data->short_description }}</p>
                                        <div class="d-flex justify-content-between align-items-center mt-1">

                                            @php
                                            $discount_price = 0;
                                            $price = $package_data->price;
                                            
                                            if (isset($package_data->discount) && isset($package_data->discount_type)) {
                                                if ($package_data->discount > 0) {
                                                    if ($package_data->discount_type == 0) {
                                                        $discount_price = ($package_data->discount / 100) * $package_data->price;
                                                    } elseif ($package_data->discount_type == 1) {
                                                        $discount_price = $package_data->discount;
                                                    }
                                                    $price = $package_data->price - $discount_price;
                                                }
                                            }
                                            @endphp
                                            
                                            <div>
                                            {{-- Starting From --}}
                                           <span class="for-mobile-br"><b><span class="currency_dhiram"></span> {{ number_format($price, 2) }}</b><span>
                                            @if($discount_price > 0)
                                                <span style="text-decoration: line-through; margin-right: 10px; color: #999;">
                                                    <span class="currency_dhiram"></span> {{ number_format($package_data->price, 2) }}
                                                </span>
                                            @endif
                                            </div>
                                           
                                @if(in_array($package_data->id, $book_array_package_id_session))
                                @if (Cart::count() > 0)
                                    @foreach (Cart::content() as $items)
                                        @if ($items->id == $package_data->id)
                                            <div id="package_{{ $items->id }}">
                                                <div class="quantity">
                                                    <div class="quantity-block">
                                                        <button type="button" id="minus_{{ $items->rowId }}" class="quantity-arrow-minus"
                                                                onclick="minus_qty_book_now('{{ $items->rowId }}', '{{ $items->qty }}');">
                                                            <span class="fa fa-minus"></span>
                                                        </button>
                                                        <input id="input_{{ $items->rowId }}" class="quantity-num-one qty_input_book_now_{{ $items->rowId }}"
                                                            type="text" value="{{ $items->qty }}" readonly/>
                                                        <button type="button" id="plus_{{ $items->rowId }}" class="quantity-arrow-plus"
                                                                onclick="plus_qty_book_now('{{ $items->rowId }}', '{{ $items->qty }}');">
                                                            <span class="fas fa-plus"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                @else
                                    <div id="package_{{ $package_data->id }}">
                                        {{-- <button id="add-btn-{{ $package_data->id }}" type="button" class="btn border border-primary rounded text-primary add-to-card px-3"
                                                onclick="add_to_cart_book('{{ $package_data->id }}')">Add +</button> --}}

                                                <button id="add-btn-{{ $package_data->id }}" class="btn border border-primary rounded text-primary add-to-card px-3 add-to-cart-btn-book" 
                                                data-package-id="{{ $package_data->id }}" 
                                                data-qty="1">Add +</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr style="border: 1px solid #ddd; margin: 20px 0;">
                    @endforeach
                    @endif
                </div>
                @endforeach
                @endif
                @endif
        
                    <div class="sticky-footer-btn">
                        <button type="button" 
                                class="ud-btn btn-thm default-box-shadow2 custome-black mobile-hide fix-on-footer"
                                id="nextBtn12"
                                onclick="get_hide_show(2);">
                            Next
                        </button>
                    </div>
                        
                </div>

            <div class="tab2" id="tab2-div"style="display:none;">

            @php
            $user_id = Session::get('user');
            $user_data = DB::table('frontloginregisters')
                        ->where('id',$user_id)->first();
            
            @endphp
            @if($subservice_id == 28)
            <div id="cleaner_section">
            @if($user_id != "")
                @php
                $firstCleaner = DB::table('users')
                                ->where('role_id','16')
                                ->whereRaw("FIND_IN_SET(?, service)", [$service_id])
                                ->whereRaw("FIND_IN_SET(?, subservice)", [$subservice_id])
                                ->orderBy('id', 'asc') // Ensures the first cleaner is prioritized
                                ->limit(1);

                $otherCleaners = DB::table('users')
                                ->where('role_id','16')
                                //->where('area', 'LIKE', '%' . $user_data->area . '%')
                                ->whereRaw("FIND_IN_SET(?, service)", [$service_id])
                                ->whereRaw("FIND_IN_SET(?, subservice)", [$subservice_id]);

                $cleaners = $firstCleaner->union($otherCleaners)->get();
                            
                @endphp
              <div class="form-group mb-3">
    <label class="form-label fw500 dark-color" for="country">Select your preferred cleaner</label>

    <div id="select_your_cleaner_slider_spatie" class="splide radio-group">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach($cleaners as $data)
                    <li class="splide__slide text-center">
                        <div class="cleaners-div" onclick="cleaner_data('{{ $data->id }}', '{{ $data->name }}');">
                            <div class="items">
                                <input type="radio" id="cleaner_{{ $data->id }}" name="cleaner" class="cleaners-radio" value="{{ $data->name }}">

                                <div class="cleaner-image">
                                    <img src="{{ url('public/upload/cleaners/large/' . $data->profile_image) }}" class="cleaners-image-style">
                                </div>

                                <div class="cleaner-detail">
								
									@if($data->id != 2)
								
                                    <a style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#cleaner_description_{{ $data->id }}">
                                        <p class="cleaner-name">{{ $data->name }}</p>
                                    </a>
									@else
										<a style="cursor: pointer;" >
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

                            //echo "<pre>";print_r($timeslot);echo"</pre>";exit;
                            
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
					
					@if($subservice_id != 28)
						
					@php
						if($subservice_id == 93){
							$placeholder = "Please mention car type, color and number plate details.";
						}else{
							$placeholder = "Example: You need a gate pass to enter the community, building code is #1234, etc.";
						}
					@endphp
					
					<div class="form-group mb-3">
                        <label class="form-label fw500 dark-color " for="country">Any instructions or special requirements?</label>
                        <textarea name="any_special_instruction" id="any_special_instruction" placeholder="{{$placeholder}}"></textarea>

                        <p class="form-error-text" id="any_special_instruction_error" style="color: red; margin-top: 10px;">
                        </p>
                    </div>
					@endif

                    <div class="form-group mb-3 cancel-policy-back">
                        <div class="cancel-content">
                    <div class="cancel-text">
                        <img src="{{ asset('public/site/images/infoicon.svg') }}" alt="Info" data-bs-toggle="modal" data-bs-target="#cancel_policy_{{ $subservice_id }}" style="cursor: pointer;">
                        Enjoy free cancellation up to 6 hours before your booking start time.
                    </div>
                    <a class="cancel-details" data-bs-toggle="modal" data-bs-target="#cancel_policy_{{ $subservice_id }}">Details</a>
                </div>
                </div>
 
                    <button type="button" class="ud-btn btn-thm default-box-shadow2 custome-black" id="nextBtn12"
                    onclick="get_hide_show(1);">Previous</button>
                    <div class="sticky-footer-btn">
                    <button type="button" class="ud-btn btn-thm default-box-shadow2 custome-black mobile-hide fix-on-footer" id="nextBtn12"
                                onclick="get_hide_show(3);">Next</button>
                    </div>

                               


                    
                </div>

                <div class="tab3" id="tab2-div" style="display:none">
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
                    </div>

                    <div class="form-group mb-3">
                        {{-- <label class="form-label fw500 dark-color " for="country">How often do you need cleaning?</label> --}}

                        <select class="form-control" name="city" id="city">
                            <option value="">Select City</option>
                            <option value="Dubai" selected>Dubai</option>
                            <option value="Abu Dhabhi">Abu Dhabhi</option>
                            <option value="Sharjah">Sharjah</option>
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
                                onclick="get_hide_show(2);">Previous</button>
                    <div class="sticky-footer-btn">
                    <button type="button" class="ud-btn btn-thm default-box-shadow2 custome-black  mobile-hide fix-on-footer" id="nextBtn12"
                                onclick="get_hide_show(4);">Next</button>
                    </div>
                   
                    </div>

                <div class="tab4" id="tab2-div" style="display:none">
                    
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
                            <p class="cash_fee_p">+ <span class="currency_dhiram"></span> 5 Cash handling charges will be applied.</p>
                        </div>
                       
                        
                        <p class="form-error-text" id="payment_type_error" style="color: red; margin-top: 10px;">
                        </p>
                    </div>

                    <button type="button" class="ud-btn btn-thm default-box-shadow2 custome-black" id="nextBtn12"
                    onclick="get_hide_show(3);">Previous</button>
                    
                    <div class="sticky-footer-btn">
                    <button type="button" class="ud-btn btn-thm default-box-shadow2 custome-black mobile-hide fix-on-footer" id="nextBtn12" 
                                onclick="get_hide_show(5);">Next</button>
                    </div>
                </div>

                <div class="tab5" style="display:none">

                   
                    <div class="form-content-main pb-0 pre-confirm-desc px-md-2 last-summary-para ">

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

                        @if($subservice_id == 30 || $subservice_id == 28)

                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>No. of Cleaners</div>
                                <div class="font-weight-bold sm-summary"><span id="cleaners_summary">1</span> Cleaner(s)</div>
                            </div>
                        </div>

                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>No. of Hours</div>
                                <div class="font-weight-bold sm-summary"><span id="hours_summary">2</span> Hours</div>
                            </div>
                        </div>

                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Materials</div> 
                                <div class="font-weight-bold sm-summary"><span id="material_summary">No</span></div>
                            </div>
                        </div>

                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Frequency</div>
                                <div class="font-weight-bold sm-summary"><span id="frequency_summary">Once</span></div>
                            </div>
                        </div>

                        <div class="my-2" id="frequency_div_summary" style="display: none">
                            <div class="d-flex justify-content-between">
                                <div>Days of the week</div>
                                <div class="font-weight-bold sm-summary"><span id="frequency_summary_days">Once</span></div>
                            </div>
                        </div>
                       
                        <div class="d-flex justify-content-between">
                            <div>Cleaner Name</div>
                            <div class="font-weight-bold sm-summary"><span id="frequency_summary_cleaner_name"></span></div>
                        </div>

                        @endif

                <div class="coupan-apply">
                @if($subservice_id == 29 || $subservice_id == 70 || $subservice_id == 71 ||     $subservice_id == 72 || $subservice_id == 73 || $subservice_id == 79 || $subservice_id == 80 || $subservice_id == 81 || $subservice_id == 82 || $subservice_id == 83 || $subservice_id == 84 || $subservice_id == 85 || $subservice_id == 86 || $subservice_id == 87 || $subservice_id == 88 || $subservice_id == 52 || $subservice_id == 93)
                    @php
                        $subtotal = 0;
                    @endphp
                            @if (Cart::count() > 0)

                                @foreach (Cart::content() as $items)

                                @php

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

                                    if ($disc_price != '0'){
                                        $package_price = $disc_price;
                                    }else{
                                        $package_price = $items->price;
                                    }
                                @endphp
                                    <div class="my-2">
                                        <div class="d-flex justify-content-between">
                                            <div>{{ $items->name }} * {{ $items->qty }}</div>
                                            <div class="font-weight-bold sm-summary" ><span id="frequency_summary"><span class="currency_dhiram"></span> {{ $package_price }}</span></div>
                                        </div>
                                    </div>

                                    @php

                                        if ($items->qty >= 1) {
                                            $subtotal += $items->qty * round($p_price);
                                        } else {
                                            $subtotal += round($p_price);
                                        }

                                    @endphp
                                @endforeach
                            @endif
                        @endif


                        

                        <hr>

                        <div class="font-weight-bold h5">
                                Date &amp; Time
                        </div>

                        <div class="my-2" >
                            <div class="d-flex justify-content-between">
                                <div>Date & Time</div>
                                <div class="font-weight-bold sm-summary"><span id="frequency_summary_date"></span> at <span id="frequency_summary_timeslot"></span></div>
                            </div>
                        </div>

                        

                        <hr>

                        <div class="font-weight-bold h5">
                            Address
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

                        <div class="my-2">
                            <div class="d-flex justify-content-between">
                                <div>Payment Method</div>
                                <div class="font-weight-bold sm-summary"><span id="frequency_summary_payment_mode"></span></div>
                            </div>
                        </div>

                        <hr>

                        <div class="font-weight-bold h5">
                            Payment Details
                        </div>

                        <div class="my-2" >
                            <div class="d-flex justify-content-between">
                                <div>Service Charges</div>
                                <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span><span id="frequency_summary_service_charge"></span></div>
                            </div>
                        </div>

                        {{-- <div class="my-2" id="promo_discount_wrapper">
                            <div class="d-flex justify-content-between">
                                <div>Promo Discount</div>
                                <div class="font-weight-bold sm-summary" style="background-color:#FFD312;border-radius: 6px;
                                padding: 0 5px 0 5px;"><span id="frequency_summary_promo_discount"></span></div>
                            </div>
                        </div> --}}
                        
                        @php
                        $subservice_popup_data = DB::table('subservices')->where('id',$subservice_id)->first();
                       @endphp 
                        {{-- For last --}}
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
                                <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span><span id="frequency_summary_additional_charge"></span></div>
                            </div>
                        </div>
                        

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
                                <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span><span id="frequency_timing_charge_replace"></span></div>
                                
                            </div>
                        </div>

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
                                <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span><span id="frequency_cod_charge_replace"></span></div>
                                
                            </div>
                        </div>

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
                        <div class="last_summary_session_div">
                            @if(session()->has('coupan_data'))
                            <div class="d-flex justify-content-between"><div>Coupon Code</div>
                                <a href="javascript:void(0)"
                                onclick="last_summary_remove_coupon();" style="margin-left:47%;"><span class="flaticon-delete"></span></a>
                            <div class="font-weight-bold sm-summary" style="background-color:#FFD312;border-radius: 6px;
                            padding: 0px 5px 0px 5px;">- <span class="currency_dhiram"></span> <span id="frequency_summary_promo_code_replace">0.00</span></div></div>
            
                            <div class="d-flex justify-content-between">
                            <div>Applied Coupon Code</div><div class="font-weight-bold sm-summary"><span id="frequency_summary_promo_code_name_replace"></span></div>
                            </div>
                            @endif
                        </div>
                        <div class="last_summary_session_home_cleaning_div" style="display: none;"> 
                            <div class="d-flex justify-content-between"><div>Coupon Code</div>
                                <a href="javascript:void(0)"
                                onclick="last_summary_home_cleaning_remove_coupon();" style="margin-left:47%;"><span class="flaticon-delete"></span></a>
                            <div class="font-weight-bold sm-summary" style="background-color:#FFD312;border-radius: 6px;
                            padding: 0px 5px 0px 5px;">- <span class="currency_dhiram"></span> <span id="frequency_summary_promo_code_replace">0.00</span></div></div>
            
                            <div class="d-flex justify-content-between">
                            <div>Applied Coupon Code</div><div class="font-weight-bold sm-summary"><span id="frequency_summary_promo_code_name_replace"></span></div>
                            </div>
                        </div>
                        @if($subservice_id != 28 )
                        <div class="d-flex justify-content-between">
                            <div><input type="text" name="frequency_summary_promo_code" id="frequency_summary_promo_code" class="form-control-coupan" placeholder="Enter Promo code">
            
                            <div id="frequency_summary_promo_code_error" class="alert-message valierror "
                            style="display:none; margin-bottom: 0px; width: 100%;margin-top: 5px;"></div>
                            <div id="frequency_summary_promo_code_success" class="successmain alert-message "
                            style="display:none; margin-bottom: 0px; width: 100%;  margin-top: 5px;"></div>
                            </div>
                            
                           
                            <div><input type="button" id="promocode" name="promocode" value="Apply" class="ud-btn-apply btn-thm default-box-shadow2" onclick="last_summary_apply_promo();"></div>
                        </div>
                            @else
                            
                            <div class="d-flex justify-content-between">
                                <div><input type="text" name="frequency_summary_promo_code" id="frequency_summary_promo_code" class="form-control-coupan" placeholder="Enter Promo code">
                
                                <div id="frequency_summary_promo_code_error" class="alert-message valierror "
                                style="display:none; margin-bottom: 0px; width: 100%;margin-top: 5px;"></div>
                                <div id="frequency_summary_promo_code_success" class="successmain alert-message "
                                style="display:none; margin-bottom: 0px; width: 100%;  margin-top: 5px;"></div>
                                </div>
                                
                               
                                <div><input type="button" id="promocode" name="promocode" value="Apply" class="ud-btn-apply btn-thm default-box-shadow2" onclick="last_summary_apply_promo_home_cleaning();"></div>
                            </div>

                            @endif
                        
                        
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
                            <div class="font-weight-bold" style="max-width: 50%; text-align: right;" >
                <div  class="cross_amount_div" style="display: none;">

                {{-- @if($subservice_id != 29 && $subservice_id != 70 && $subservice_id != 71 && $subservice_id != 72 &&  $subservice_id != 73  && $subservice_id != 79 && $subservice_id != 80 && $subservice_id != 81 && $subservice_id != 82 && $subservice_id != 83 && $subservice_id != 84 && $subservice_id != 85 && $subservice_id != 86 && $subservice_id != 87 || $subservice_id == 93) --}}
                                <span class="currency_dhiram"></span> <span id="frequency_summary_cross_amount" style="text-decoration: line-through;"></span>
                                </br>
                    {{-- @endif --}}
                            </div>
                                <strong class="main_price_new">
                                <span class="currency_dhiram"></span><span id="frequency_summary_total_to_pay"></span></strong>
                            </div>
                        </div>
                    </div>

                        

                    </div>

                    </div>
                    <button type="button" class="ud-btn btn-thm default-box-shadow2 custome-black" id="nextBtn12"
                    onclick="get_hide_show(4);">Previous</button>

                    <button class="btn btn-primary mb-1 book-now-web" type="button" disabled id="spinner_button" style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...</button>
                    <button type="button" class="ud-btn btn-thm default-box-shadow2 order_now custome-black book-now-web" id="nextBtn12" 
                                onclick="get_hide_show(6);">Book Now </button>
                </div>
                

                <input type="hidden" name="service_charge" id="service_charge" value="78">
                <input type="hidden" name="promo_discount" id="promo_discount" value="0">
                <input type="hidden" name="cleaning_discount_additional" id="cleaning_discount_additional" value="0">
                <input type="hidden" name="additional_charge" id="additional_charge" value="0">
                <input type="hidden" name="timing_charge" id="timing_charge" value="0">
                <input type="hidden" name="weekly_off_charge" id="weekly_off_charge" value="0">
                <input type="hidden" name="sub_total" id="sub_total" value="78">
                <input type="hidden" name="sub_total_time" id="sub_total_time" value="78">
                <input type="hidden" name="vat_total" id="vat_total" value="3.90">
                <input type="hidden" name="cod_charge" id="cod_charge" value="0">
                <input type="hidden" name="service_fee" id="service_fee" value="9">
                <input type="hidden" name="total_to_pay" id="total_to_pay" value="">

                <input type="hidden" name="cleaner_id" id="cleaner_id" value="2">
                <input type="hidden" name="cleaner_name" id="cleaner_name" value="Auto Assign">

                <input type="hidden" name="home_cleaning_left_value" id="home_cleaning_left_value" value="">
                <input type="hidden" name="coupan_value" id="coupan_value" value="0">
                <input type="hidden" name="wallet_amount_new" id="wallet_amount_new" value="{{ $wallet_amount }}">

                <div id="coupan_refresh_id">
                <input type="hidden" id="coupan_data_element" value='@json(session("coupan_data"))'>
                </div>
                <div id="mobile_coupan_refresh_id">
                <input type="hidden" id="mobile_coupan_data_element" value='@json(session("coupan_data"))'>
                </div>
                <input type="hidden" id="payment_type_new" name="payment_type" value="ONLINE" >

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
                            // echo"<pre>";print_r($subtotal);echo"</pre>";
                        }
                        
                    }

                @endphp

                <div class="hidden_refresh_cart">
                <input type="hidden" id="cart_subtotal_hidden" name="cart_subtotal_hidden" value="{{ $subtotal }}" >
                </div>


                </form>
            </div>

            <div class="sticky-button">

            <button id="stickyButton" class="booking-summary" style="bottom:15px;margin-bottom: 22px;">
                <div class="d-flex justify-content-between" style="color:#000;">
                <div class="font-weight-bold">
            @if($subservice_id == 30 || $subservice_id == 28)
            <div class="cross_amount_div"  style="display: none;">
                <div style="font-size: 15px;margin-right:75px;text-decoration: line-through;"><span class="currency_dhiram"></span><span id="frequency_summary_cross_amount_mobile" style="text-decoration: line-through;"></span>
                </div>
                </div>

            @endif
            <div style="font-size: 25px;"><span class="currency_dhiram"></span>
                <span id="total_to_pay_charge_replace_mobile"></span>
                <i style="margin-left: 5px;" class="fa-solid fa-angle-up" id="aerrowicon"></i>
            </div>
            </div>
            </div>
            @if($subservice_id == 30 || $subservice_id == 28)
            <p id="selected_weekly"></p>
            @endif
            </button>
            
            

             
            <button type="button" class="ud-btn btn-thm default-box-shadow2 backMobile custome-black mobile-tab2 mobile-next " id="nextBtn12" style=""onclick="get_hide_show(2);">Next</button>

             <button type="button" class="ud-btn btn-thm default-box-shadow2 backMobile custome-black mobile-tab3 mobile-next" id="nextBtn12" style="display: none;"onclick="get_hide_show(3);">Next</button>                                                                                                
             <button type="button" class="ud-btn btn-thm default-box-shadow2 backMobile custome-black mobile-tab4 mobile-next" id="nextBtn12" style="display: none;"onclick="get_hide_show(4);">Next</button>                                                                                                
             <button type="button" class="ud-btn btn-thm default-box-shadow2 backMobile custome-black mobile-tab5 mobile-next" id="nextBtn12" style="display: none;"onclick="get_hide_show(5);">Next</button>
             
             <button class="btn btn-primary mb-1 backMobile spinner-mobile-tab6 mobile-next" type="button" disabled id="spinner_button" style="color: #0d6efd;background-color: #fff;border-color: #fff;top: 15px; display:none;">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...</button>
                <button type="button" class="ud-btn btn-thm default-box-shadow2 order_now custome-black backMobile mobile-tab6 mobile-next" id="nextBtn12" style="display: none;right:4px !important;" onclick="get_hide_show(6);">Book Now </button>

                <input type="hidden" name="service_fee" id="service_fee" value="9">
            </div>

            

            


             <div class="col-lg-5">
            <div class="column right_column">
             <div class="summary_div_left_new">
               
                <div  id="summary_div_left_package" class="last_col">
                     <div class="d-flex justify-content-center mt-2 is-r font-weight-bold-summary">

                {{-- <div  class="font-weight-bold-summary h5" style="font-size: 17px;">Total to pay</div> --}}
                 <h5>Total to pay</h5>
                </div>
                <div class="left-summary-total d-flex">
                <div class="cross_amount_div"  style="display: none;">
                {{-- @if($subservice_id != 29 && $subservice_id != 70 && $subservice_id != 71 && $subservice_id != 72 &&  $subservice_id != 73 && $subservice_id != 79 && $subservice_id != 80 && $subservice_id != 81 && $subservice_id != 82 && $subservice_id != 83 && $subservice_id != 84 && $subservice_id != 85 && $subservice_id != 86 && $subservice_id != 87) --}}
                
                    <strong ><span class="currency_dhiram"></span> <span id="cross_amount" style="text-decoration: line-through;"></span></stong><br>
                    {{-- @endif --}}
                   </div>
                    <strong class="main_price_new"><span class="currency_dhiram"></span> <span id="total_to_pay_charge_replace"></span></strong>
                </div>
                <p id="selected_weekly_left_summary" style="font-size: 17px; font-weight:1000;" ></p>
                 {{-- <div  class="font-weight-bold-summary h5 summarydev" >Booking Summary</div> --}}
               
                {{-- <span class="underline"></span> --}}
                <div class="font-weight-bold-summary h5 summarydev">Service Details</div>

                @if($subservice_id == 30 || $subservice_id == 28)
                <div class="d-flex justify-content-between subheadingdev" ><div >No. of Cleaners</div><div class="font-weight-bold sm-summary"><span id="cleaner_replace">1</span> Cleaner(s)</div></div>

                <div class="d-flex justify-content-between subheadingdev">
                    <div>No. of Hours</div>
                    <div class="font-weight-bold sm-summary"><span id="hour_replace">2</span> Hours</div>
                </div>

                <div class="d-flex justify-content-between subheadingdev">
                    <div>Materials</div>
                    <div class="font-weight-bold sm-summary"><span id="material_left_summary_replace">No</span></div>
                </div>

                <div class="d-flex justify-content-between subheadingdev">
                    <div>Frequency</div>
                    <div class="font-weight-bold sm-summary"><span id="frequency_left_summary_replace">Once</span></div>
                </div>
                

                <div class="d-flex justify-content-between subheadingdev" id="frequency_left_summary_div" style="display: none !important">
                    <div>Days of the week</div>
                    <div class="font-weight-bold sm-summary"><span id="frequency_days_left_summary_replace"></span></div>
                </div>

                {{-- <div class="d-flex justify-content-between subheadingdev">
                    <div>Cleaner Name</div>
                    <div class="font-weight-bold sm-summary"><span id="left_summary_cleaner_name"></span></div>
                </div> --}}
                {{-- <span class="underline"></span> --}}

                @endif

                <div class="d-flex justify-content-between subheadingdev">
					<div>Date & Time</div>
					<div class="font-weight-bold sm-summary"> <span id="date_replace"></span></br><span id="time_replace"></span></div>
				</div>
                
                <div class="d-flex justify-content-between subheadingdev">
                    <div>Address</div>
                    <div class="font-weight-bold sm-summary"> <span id="address_replace"></span></div>
                </div>
                <span class="underline"></span>
                

                @php
                    //echo "<pre>";print_r(Cart::content());echo"</pre>";
                    $book_array_package_id = array();
                    $subtotal = 0;
                @endphp

                @if($subservice_id == 29 || $subservice_id == 70 || $subservice_id == 71 || $subservice_id == 72 || $subservice_id == 73 || $subservice_id == 79 || $subservice_id == 80 || $subservice_id == 81 || $subservice_id == 82 || $subservice_id == 83 || $subservice_id == 84 || $subservice_id == 85 || $subservice_id == 86 || $subservice_id == 87 || $subservice_id == 88 || $subservice_id == 52 || $subservice_id == 93)

                <div id="cart_item_list">
                    @if (Cart::count() > 0)

                        @foreach (Cart::content() as $items)
                        @php
                            $book_array_package_id[] = $items->id;
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

                            if ($disc_price != '0'){
                                $package_price = $disc_price;
                            }else{
                                $package_price = $items->price;
                            }

                        @endphp

                            <div class="d-flex justify-content-between">
                                <div>{{ $items->name }} * {{ $items->qty }} <a href="javascript:void(0)"
                                    onclick="remove_to_cart_book_now('{{ $items->rowId }}'); return false;"><span
                                        class="flaticon-delete"></span></a></div>
                                <div class="font-weight-bold sm-summary"><span id="frequency_left_summary_replace"><span class="currency_dhiram"></span> {{ $package_price }}</span></div>
                            </div>

                            @php

                                if ($items->qty >= 1) {
                                    $subtotal += $items->qty * round($p_price);
                                } else {
                                    $subtotal += round($p_price);
                                }

                            @endphp

                        @endforeach
                        
                    @endif
                </div>
               
                @endif

                @php
                    session(['book_array_package_id' => $book_array_package_id]);

                            //         echo '<pre>';
                            // print_r($book_array_package_id);
                            // echo '</pre>';
                @endphp

               
                
                <div class="font-weight-bold-summary h5 summarydev">Payment Details</div>
                <div class="d-flex justify-content-between subheadingdev"><div >Service Charges</div><div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span> <span id="service_charge_replace">  </span></div></div>

                <div class="d-flex justify-content-between promo_dicount_replace_div subheadingdev"><div>Promo Discount</div><div class="font-weight-bold sm-summary" style="background-color:#FFD312;border-radius: 6px;
                padding: 0px 5px 0px 5px;">- <span class="currency_dhiram"></span> <span id="promo_dicount_replace">0.00</span></div></div>

                <div class="d-flex justify-content-between additional_charge_replace_div subheadingdev" style="display: none !important"><div>Additional Charges</div><div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span> <span id="additional_charge_replace">0.00</span></div></div>

                <div class="d-flex justify-content-between timing_charge_replace_div subheadingdev" >
                        
                        <div>Timing fee</div>
                        <div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span>
                            <span id="timing_charge_replace">0</span>
                        </div>
                       
                </div>

                <div class="d-flex justify-content-between cod_charge_replace_div subheadingdev" >
                        
                        <div>Delivery charge</div>
                        <div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span> 
                            <span id="cod_charge_replace">0</span>
                        </div>
                       
                </div>

                <div class="d-flex justify-content-between subheadingdev"><div>Sub Total</div><div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span> <span id="sub_total_replace">0.00</span></div></div>
                <div class="d-flex justify-content-between subheadingdev"><div>VAT (5%)</div><div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span> <span id="vat_charge_replace">3.90</span></div></div>
                <div class="home_cleaning_session_div subheadingdev" style="display: none;">
                <div class="d-flex justify-content-between subheadingdev"><div>Coupon Code</div>
                    <a href="javascript:void(0)"
                    onclick="home_cleaning_remove_coupon();" style="margin-left:43%;"><span class="flaticon-delete"></span></a>
                <div class="font-weight-bold sm-summary subheadingdev" style="background-color:#FFD312;border-radius: 6px;
                padding: 0px 5px 0px 5px;">-<span class="currency_dhiram"></span><span id="promo_code_replace_home">0.00</span></div></div>

                <div class="d-flex justify-content-between subheadingdev">
                <div>Applied Coupon Code</div><div class="font-weight-bold sm-summary"><span id="promo_code_name_replace_home"></span></div>
                </div>
                </div>

                @if(session()->has('coupan_data'))
                <div class="d-flex justify-content-between subheadingdev"><div>Coupon Code</div>
                    <a href="javascript:void(0)"
                    onclick="remove_coupon();" style="margin-left:43%;"><span class="flaticon-delete"></span></a>
                <div class="font-weight-bold sm-summary subheadingdev" style="background-color:#FFD312;border-radius: 6px;
                padding: 0px 5px 0px 5px;">-<span class="currency_dhiram"></span> <span id="promo_code_replace">0.00</span></div></div>

                <div class="d-flex justify-content-between subheadingdev">
                <div>Applied Coupon Code</div><div class="font-weight-bold sm-summary"><span id="promo_code_name_replace"></span></div>
                </div>
                @endif

                @if($subservice_id != 28 )
                <div class="d-flex justify-content-between">
                <div><input type="text" name="promo_code" id="promo_code" class="form-control-coupan" placeholder="Enter Promo code">

                <div id="promo_code_error" class="alert-message valierror "
                style="display:none; margin-bottom: 0px; width: 100%;margin-top: 5px;"></div>
                <div id="promo_code_success" class="successmain alert-message "
                style="display:none; margin-bottom: 0px; width: 100%; margin-top: 5px;"></div>
                </div>
                
               
                <div><input type="button" id="promocode" name="promocode" value="Apply" class="ud-btn-apply btn-thm default-box-shadow2" onclick="apply_promo();"></div>
            </div>
            @else
            <div class="d-flex justify-content-between">
                <div><input type="text" name="promo_code" id="promo_code" class="form-control-coupan" placeholder="Enter Promo code">

                <div id="promo_code_error" class="alert-message valierror "
                style="display:none; margin-bottom: 0px; width: 100%;margin-top: 5px;"></div>
                <div id="promo_code_success" class="successmain alert-message "
                style="display:none; margin-bottom: 0px; width: 100%; margin-top: 5px;"></div>
                </div>
                
               
                <div><input type="button" id="promocode" name="promocode" value="Apply" class="ud-btn-apply btn-thm default-box-shadow2" onclick="apply_promo_home_cleaning(0);"></div>
            </div>

            @endif

              
              
                
            </div>
           
            </div>
            </div>
          </div>
        <div id="footer"></div>
        <div class="summary_div_left_mobile_new">
        <div class="summary_div_left_mobile" id="summary_div_left_mobile" style="display: none;">
              
            <div class="summuryInner">

            <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>

                {{-- @if($subservice_id == 30 || $subservice_id == 28) --}}
                
                <div class="d-flex justify-content-between"><div>Service Charges</div><div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span> <span id="service_charge_replace_mobile">{{ $subtotal }}</span></div></div>
                <div id="promo_discount_wrapper_mobile" class="promo_dicount_replace_div">
                <div class="d-flex justify-content-between" ><div>Promo Discount</div><div class="font-weight-bold sm-summary" style="background-color:#FFD312;border-radius: 6px;
                padding: 0px 5px 0px 5px;">-<span class="currency_dhiram"></span> <span id="promo_dicount_replace_mobile">0.00</span></div></div>
                </div>
            {{-- For topup --}}
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
                <div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span> <span id="additional_charge_replace_mobile"></span></div>
            </div>
            </div>

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
                    <div class="font-weight-bold sm-summary"><span class="currency_dhiram"></span> <span id="frequency_summary_service_fee_charge_mobile">0.00</span></div>
                </div>
                </div>

                <div class="d-flex justify-content-between"><div>Sub Total</div><div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span> <span id="sub_total_replace_mobile">78.00</span></div></div>

                <div class="d-flex justify-content-between"><div>VAT (5%)</div><div class="font-weight-bold sm-summary"> <span class="currency_dhiram"></span> <span id="vat_charge_replace_mobile">3.90</span></div></div>

                <div class="mobile_last_summary_session_div">
                    @if(session()->has('coupan_data'))
                    <div class="d-flex justify-content-between"><div>Coupon Code</div>
                        <a href="javascript:void(0)"
                        onclick="remove_coupon();" style="margin-left:50%;"><span class="flaticon-delete"></span></a>
                    <div class="font-weight-bold sm-summary" style="background-color:#FFD312;border-radius: 6px;
                    padding: 0px 5px 0px 5px;">-<span class="currency_dhiram"></span> <span id="mobile_promo_code_replace">0.00</span></div></div>
    
                    <div class="d-flex justify-content-between">
                    <div>Applied Coupon Code</div><div class="font-weight-bold sm-summary"><span id="mobile_promo_code_name_replace"></span></div>
                    </div>
                    @endif
                </div>
            <div class="mobile_home_cleaning_session_div" style="display: none;">
                <div class="d-flex justify-content-between"><div>Coupon Code</div>
                        <a href="javascript:void(0)"
                        onclick="home_cleaning_remove_coupon();" style="margin-left:50%;"><span class="flaticon-delete"></span></a>
                    <div class="font-weight-bold sm-summary" style="background-color:#FFD312;border-radius: 6px;
                    padding: 0px 5px 0px 5px;">-<span class="currency_dhiram"></span> <span id="mobile_promo_code_replace">0.00</span></div></div>
    
                    <div class="d-flex justify-content-between">
                    <div>Applied Coupon Code</div><div class="font-weight-bold sm-summary"><span id="mobile_promo_code_name_replace"></span></div>
                    </div>
            </div>

                @if($subservice_id != 28 )
                <div id="mobile-promo-code-view">
                <div class="d-flex justify-content-between" >
                    <div><input type="text" name="mobile_promo_code" id="mobile_promo_code" class="form-control-coupan" placeholder="Enter Promo code">

                    <div id="mobile_promo_code_error" class="alert-message valierror "
                    style="display:none; margin-bottom: 0px; width: 100%;margin-top: 5px;"></div>
                    <div id="mobile_promo_code_success" class="successmain alert-message "
                    style="display:none; margin-bottom: 0px; width: 100%; margin-top: 5px;"></div>
                    </div>
                    
                
                    <div><input type="button" id="promocode" name="promocode" value="Apply" class="ud-btn-apply btn-thm default-box-shadow2" onclick="apply_promo();"></div>
                </div>
                </div>
                @else
                <div id="mobile-promo-code-view">
                    <div class="d-flex justify-content-between" >
                        <div><input type="text" name="mobile_promo_code" id="mobile_promo_code" class="form-control-coupan" placeholder="Enter Promo code">
    
                        <div id="mobile_promo_code_error" class="alert-message valierror "
                        style="display:none; margin-bottom: 0px; width: 100%;margin-top: 5px;"></div>
                        <div id="mobile_promo_code_success" class="successmain alert-message "
                        style="display:none; margin-bottom: 0px; width: 100%; margin-top: 5px;"></div>
                        </div>
                        
                    
                        <div><input type="button" id="promocode" name="promocode" value="Apply" class="ud-btn-apply btn-thm default-box-shadow2" onclick="apply_promo_home_cleaning(0);"></div>
                    </div>
                    </div>
            @endif

                {{-- @endif --}}

            </div>
        </div>
        </div>
        </div>
        </div>
        
        <input type="hidden" name="hour_charge_db" id="hour_charge_db" value="">
        <input type="hidden" name="cleaning_material_charge_db" id="cleaning_material_charge_db" value="">
    </div>
    
</section>

@include('front.includes.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.43/moment-timezone-with-data.min.js"></script>


<div class="modal modal-mobile-bottom" id="exampleModalLong_{{$subservice_id}}"  tabindex="-1" aria-labelledby="materialTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom modal-lg modal-dialog-centered" id="modal-digi" role="document">
      <div class="modal-content">
        <div class="modal-header" >
           
                <h6 class="modal-title" id="exampleModalLongTitle">
                    What our Home Cleaning Service Includes </h6>
                    <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
           
        </button>
        </div>
        
        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
            <div>
                <p style="font-size: 15px; font-weight:100; margin-left:15px;">
                <span>Transform your living space into a sanctuary of cleanliness and comfort with our professional home cleaning services. Whether you need regular upkeep or deep cleaning, our experienced team ensures every nook and cranny shines, leaving you with more time to relax and enjoy your home.</span></p>
            </div>
            <h6 style="font-size: 18px; margin-left:15px;">Our Services Include:</h6>
            <ul style="list-style-type: disc; list-style: inherit;">
                <li style="list-style: inherit;">Thorough dusting and wiping of all surfaces</li>
                <li style="list-style: inherit;">Vacuuming and mopping of floors</li>
                <li style="list-style: inherit;">Cleaning and sanitizing bathrooms</li>
                <li style="list-style: inherit;">Kitchen cleaning: countertops, sinks, appliances</li>
                <li style="list-style: inherit;">Bedroom cleaning: bed-making, dusting, tidying</li>
                <li style="list-style: inherit;">Additional services: laundry, interior window cleaning, fridge and oven cleaning</li>
            </ul>
            <h6 style="margin-left: 15px;">Experience the convenience and peace of mind that comes with a meticulously cleaned home.</h6>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>



<div class="modal modal-mobile-bottom " id="Learnmore_{{$subservice_id}}"  tabindex="-1" aria-labelledby="LearnmoreTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom modal-lg modal-dialog-centered" id="modal-digi" role="document">
      <div class="modal-content">
        <div class="modal-header" >
        <h6 class="modal-title" id="LearnmoreTitle">
            How Long Should I book for ?</h6>
            <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        
        
        <div class="modal-body" style="overflow-y: auto;">
           <img src="{{ asset('public/site/images/homecleaninghour1.png') }}" alt="Cleaning Time" style="width: 100%; border-radius:1.3rem; margin-bottom: 20px;">

		   {{-- <div>
                <p style="font-size: 15px; font-weight:100; margin-left:15px;">
                <span>Every home is different, but generally, an additional bedroom will add about an hour to your cleaning time. Below are our estimated durations for various home sizes:</span></p>
            </div>
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
        
        <h6 style="margin-left: 15px;">*Standard cleaning covers general cleaning tasks, including surface wiping, dusting, sweeping, mopping, and vacuuming. For additional tasks such as oven or fridge cleaning, blinds wiping, or balcony cleaning, please allocate an extra 30-45 minutes per task.</h6>
       
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

            <p>This comprehensive checklist ensures that your home is thoroughly cleaned. Tailor it to meet your specific needs and communicate any additional requests to your cleaning professional.</p> --}}
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>
  


<div class="modal modal-mobile-bottom" id="material_{{$subservice_id}}"  tabindex="-1" aria-labelledby="materialTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom modal-lg modal-dialog-centered" id="modal-digi" role="document">
      <div class="modal-content">
        <div class="modal-header" >
        <h6 class="modal-title" id="LearnmoreTitle">
            Which materials will Vendorscity bring?</h6>
            <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        
        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
            <h6 style="font-size: 18px; margin-left:15px;">Cleaning Equipment:</h6>
                <ul style="list-style-type: disc; list-style: inherit;">
                    <li style="list-style: inherit;">Vacuum cleaner (with appropriate attachments)</li>
                    <li style="list-style: inherit;">Mop and bucket</li>
                    <li style="list-style: inherit;">Broom and dustpan</li>
                    <li style="list-style: inherit;">Microfiber mops or cloths</li>
                    <li style="list-style: inherit;">Scrub brushes or sponges</li>
                    <li style="list-style: inherit;">Vacuum cleaner (with appropriate attachments)</li>
                </ul>
            <h6 style="font-size: 18px; margin-left:15px;">Cleaning Products:</h6>
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
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>

  <!-- furniture Popup Modal End -->

  @php
    $subservice_service_fee_popup = DB::table('subservices')->where('id',$subservice_id)->first();
    @endphp
  <!--- Service Fee Popup Start ---->
 
    <div class="modal modal-mobile-bottom" id="service_fee_popup_{{$subservice_id}}"  tabindex="-1" aria-labelledby="materialTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-bottom modal-dialog-centered modal-lg service-fee-custome-modal" id="modal-digi" role="document">
        <div class="modal-content charge-desc-popup">
            <div class="modal-header modal-header-mobile" >
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
            <div class="modal-header modal-header-mobile" >
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
            <div class="modal-header modal-header-mobile" >
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
            <div class="modal-header modal-header-mobile" >
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

<!--- Cancel Policy Popup start ---->


 <div class="modal modal-mobile-bottom" id="cancel_policy_{{$subservice_id}}"  tabindex="-1" aria-labelledby="materialTitle" aria-hidden="true">
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
            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
        </div>
</div>

<!--- Cancel Policy Popup End ---->


<!---Cleaners Popup Modal Start ---->
@if($subservice_id == 28)     
@if($user_id !="")     
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
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>

@endforeach
@endif
@endif

<!---Cleaners Popup Modal End ---->


{{-- furniture Popup Modal Start --}}
@if($subservice_id == 70 || $subservice_id == 29 || $subservice_id == 71 || $subservice_id == 72 || $subservice_id == 73 || $subservice_id == 79 || $subservice_id == 80 || $subservice_id == 81 || $subservice_id == 82 || $subservice_id == 83 || $subservice_id == 84 || $subservice_id == 85 || $subservice_id == 86 || $subservice_id == 87 || $subservice_id == 88 || $subservice_id == 52 || $subservice_id == 93)

@foreach($package_cat as $package_cat_data)

@php
    $package = DB::table('packages')
                    ->where('service_id',$service_id)
                    ->where('subservice_id',$subservice_id)
                    ->where('packagecategory_id',$package_cat_data->id)
                    ->get()->toArray();
@endphp

@foreach($package as $package_data)

@php
$discount_price = 0;
$price = $package_data->price;

if (isset($package_data->discount) && isset($package_data->discount_type)) {
    if ($package_data->discount > 0) {
        if ($package_data->discount_type == 0) {
            $discount_price = ($package_data->discount / 100) * $package_data->price;
        } elseif ($package_data->discount_type == 1) {
            $discount_price = $package_data->discount;
        }
        $price = $package_data->price - $discount_price;
    }
}
@endphp

<div class="modal modal-mobile-bottom furniture-modal" id="material_furniture_{{$package_data->id}}"  tabindex="-1" aria-labelledby="materialTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom modal-lg modal-dialog-centered" id="modal-digi" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border:none;">
         <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        
        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
            <img src="{{ url('public/upload/packages/popupimage/' . $package_data->popup_image) }}" alt="{{ $package_data->image_alt_tag ?? $package_data->name }}" class="img-fluid" style="width: 100%;">

            <div class="d-flex justify-content-between align-items-center mt-3">
                <h5>{{$package_data->name}}</h5>
                <b class="popup-price"><span class="currency_dhiram"></span> {{ $price }}</b>
                @if($discount_price > 0)
                <span style="text-decoration: line-through; margin-right: 10px; color: #999;">
                    <span class="currency_dhiram"></span> {{ number_format($package_data->price, 2) }}
                </span>
                @endif
            </div>
            <hr style="border: 1px solid #ddd; margin: 20px 0;">
            <div>
                {!! html_entity_decode($package_data->description) !!}
            </div>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>


@endforeach
@endforeach
@endif

{{-- furniture Popup Modal End --}}

{{-- Subsevice Popup Modal Start --}}
@if($subservice_id == 70 || $subservice_id == 29 || $subservice_id == 71 || $subservice_id == 72 || $subservice_id == 73 || $subservice_id == 79 || $subservice_id == 80 || $subservice_id == 81 || $subservice_id == 82 || $subservice_id == 83 || $subservice_id == 84 || $subservice_id == 85 || $subservice_id == 86 || $subservice_id == 87 || $subservice_id == 88 || $subservice_id == 52 || $subservice_id == 93)

@php
$subservice_data = DB::table('subservices')
                ->where('id',$subservice_id)
                ->first();
@endphp
<div class="modal modal-mobile-bottom furniture-modal" id="subservice_popup_{{$subservice_data->id}}"  tabindex="-1" aria-labelledby="materialTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom modal-lg modal-dialog-centered" id="modal-digi" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border:none;">
         <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        
        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
            <img src="{{ url('public/upload/subservice/' . $subservice_data->service_detail_image) }}"  class="img-fluid" style="width: 100%;" alt="{{ $subservice_data->image_alt_tag ??  $subservice_data->subservicename }}">

            <div class="d-flex justify-content-between align-items-center mt-3">
                <h5>About our {{$subservice_data->subservicename}} Service Includes</h5>
            </div>
            <hr style="border: 1px solid #ddd; margin: 20px 0;">
            <div>
                {!! html_entity_decode($subservice_data->service_detail_popup_description) !!}
            </div>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>


  @endif
{{-- Subsevice Popup Modal End --}}
  
        
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
              <input type="tel" class="input-field" name="phone" id="user-phone-number" placeholder="Mobile No" onkeypress="return validateNumber(event)">
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
              <input type="number" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="number" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="number" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="number" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="number" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
              <input type="number" maxlength="1" class="booknow-otp-input form-control text-center" style="width: 40px;">
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
        {{-- <div class="form-group mt-3">
            <input type="text" class="form-control" id="booknow_user_area" name="book_area" placeholder="Area">
            <p id="booknow_area_error" style="display:none;color:red;"></p>
        </div> --}}
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

<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

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

<script>

// document.addEventListener("DOMContentLoaded", () => {
//   const stickyDiv = document.querySelector('.summary_div_left_new');
//   const stickyOffset = stickyDiv.offsetTop;

  
//   window.addEventListener('scroll', () => {
//     if (window.scrollY >= stickyOffset) {
//         stickyDiv.classList.add('topcss');
//     } else {
//         stickyDiv.classList.remove('topcss');
//     }
//   });
// });



// document.addEventListener("DOMContentLoaded", () => {
//   const stickyDiv = document.querySelector('.summary_div_left_new');
//   const stickyDiv2 = document.querySelector('.scrollbalance-inner');
//   const footer = document.querySelector('.footer-style1');

//   if (!stickyDiv || !stickyDiv2 || !footer) return;

//   const stickyOffset = stickyDiv.offsetTop;

//   window.addEventListener('scroll', () => {
//     const scrollY = window.scrollY;
//     const stickyBottom = stickyDiv.getBoundingClientRect().bottom + scrollY;
//     const footerOffset = footer.offsetTop;

//     if (scrollY >= stickyOffset && stickyBottom < footerOffset) {
//       stickyDiv2.style.setProperty('position', 'fixed', 'important');
//       stickyDiv2.style.setProperty('top', 'inherit', 'important');
//       stickyDiv2.style.setProperty('left', 'inherit', 'important');
//     } else {
//       stickyDiv2.style.setProperty('position', 'absolute', 'important');
//       stickyDiv2.style.setProperty('top', stickyOffset + 'px', 'important');
//       stickyDiv2.style.setProperty('left', '0px', 'important');
//     }
//   });
// });


document.addEventListener("DOMContentLoaded", () => {
  const stickyDiv = document.querySelector('.summary_div_left_new');
  const stickyInner = document.querySelector('.scrollbalance-inner');
  const footer = document.querySelector('.footer-style1');

  if (!stickyDiv || !stickyInner || !footer) return;

  const stickyOffsetTop = stickyDiv.offsetTop;

  window.addEventListener('scroll', () => {
    const scrollY = window.scrollY;
    const stickyHeight = stickyDiv.offsetHeight;
    const footerOffsetTop = footer.offsetTop;
    const stickyBottom = scrollY + stickyHeight;
	
	
	console.log("test",stickyHeight,footerOffsetTop, stickyBottom);


    if (stickyBottom >= footerOffsetTop) {
      // Stop above the footer
      const absoluteTop = footerOffsetTop - stickyHeight - stickyDiv.offsetParent.offsetTop;
      stickyInner.style.setProperty('position', 'absolute', 'important');
      stickyInner.style.setProperty('top', absoluteTop + 'px', 'important');
      stickyInner.style.setProperty('left', '0px', 'important');
    } else {
      // Always fixed when not hitting footer
      stickyInner.style.setProperty('position', 'fixed', 'important');
      stickyInner.style.setProperty('top', '0px', 'important');
      stickyInner.style.setProperty('left', stickyDiv.getBoundingClientRect().left + 'px', 'important');
    }
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const stepTitle = document.querySelector('#service-step-title');
  const footer = document.querySelector('.footer-style1');

  if (!stepTitle || !footer) return;

  const stepTitleOffset = stepTitle.offsetTop;
  const stepTitleHeight = stepTitle.offsetHeight;
  const getFixedTop = () => window.innerWidth <= 768 ? 79 : 92;

  window.addEventListener('scroll', () => {
    const scrollY = window.scrollY;
    const footerTop = footer.offsetTop;
    const stepBottom = scrollY + fixedTop + stepTitleHeight;

    if (stepBottom >= footerTop) {
      // Switch to absolute above footer
      const absoluteTop = footerTop - stepTitleHeight;
      stepTitle.style.setProperty('position', 'absolute', 'important');
      stepTitle.style.setProperty('top', absoluteTop + 'px', 'important');
    } else {
      // Stay fixed at top: 92px
      stepTitle.style.setProperty('position', 'fixed', 'important');
      stepTitle.style.setProperty('top', fixedTop + 'px', 'important');
    }
  });
});






// Observe the footer element


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
}); */

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




// Function to get the selected country code
/* function getCountryCode() {
  const countryData = phoneInput.getSelectedCountryData();
  const countryCode = countryData.dialCode; // Get the dial code (country code)
  console.log(countryCode); // Example: "+971" for UAE
  return countryCode;
} */

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

        var url = '{{ url(session('search_city_name') . '/booknow-otp-sent') }}';
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
                    //$('#booknow_user_area').val(response.user_data.area);
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

            return false;

            document.getElementById('booknow-step-otp').style.display = 'none';
            document.getElementById('booknow_user_name').style.display = 'none';
            document.getElementById('booknow_user_email').style.display = 'none';
            document.getElementById('booknow-step-details').style.display = 'block';
            document.getElementById('modalStepTitle').innerText = "Personal Details";
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
        //var area = jQuery("input[name='book_area']").val().trim();
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

        //  if (area === '') {
        //     jQuery('#booknow_area_error').html("Please Enter area");
        //     jQuery('#booknow_area_error').show().delay(0).fadeIn('show');
        //     jQuery('#booknow_area_error').show().delay(2000).fadeOut('show');
        //     return false;
        // }
		
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
						$('#country_code_book_popup_Modal_book').val(response.user_data.country_code);
						//$('#book_email_area').val(response.user_data.area);
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

            return false;
           
            document.getElementById('book_email_name').style.display = 'none';
            document.getElementById('book_email_mobile').style.display = 'none';
            document.getElementById('booknow-email-step-otp').style.display = 'none';
            document.getElementById('booknow-email-step-details').style.display = 'block';
            document.getElementById('booknow_email_modalStepTitle').innerText = "Personal Details";

            
           
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
        //   if (email_area === '') {

        //     jQuery('#book_email_area_error').html("Please Enter Area");
        //     jQuery('#book_email_area_error').show().delay(0).fadeIn('show');
        //     jQuery('#book_email_area_error').show().delay(2000).fadeOut('show');
        //     return false;
        // }
		
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
    //document.getElementById('booknow_user_area').value = '';
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
    $('#cod_charge').val(charge_payment);

    @php 
    if($subservice_id == 30 || $subservice_id == 28){
    @endphp
    calculation();
    @php 
    }else{
    @endphp
    calculation_book_now('0');
    @php 
    }
    @endphp
        //alert('Selected Payment Type: ' + selectedValue);
    });
    

    function cleaner_assign_value(){
         
        $('#cleaner_id').val(2);
        $('#cleaner_name').val('Auto Assign');

       }

    function cleaning_change(value){


        if(value == 'Multiple times a week'){
            // alert('in');
            $('#selected_weekly').text('For first visit only');
            $('#selected_weekly_left_summary').text('For first visit only');
            $("#weekly_div").css("display", "block");
            $("#frequency_left_summary_div").attr("style", "display: flex !important;");
            // $('#cleaner_id').val('');
            // $('#cleaner_name').val('');
            $('.sticky-button').css('min-height', '100px');
            $('#stickyButton').css('margin-bottom', '1px');
        }else if(value == "Weekly"){
            // alert('in');
            $('#selected_weekly').text('');
            $('#selected_weekly_left_summary').text('');
            $("#weekly_div").css("display", "none");
            $('.sticky-button').css('min-height', '75px');
            $('#stickyButton').css('margin-bottom', '12px');
            $("#frequency_left_summary_div").attr("style", "display: none !important;");
            $("input[name='which_day_of_the_week_do_you_want_the_service[]']").prop('checked', false);
        }else{
            // alert('out');
            $('#selected_weekly').text('');
            $('#selected_weekly_left_summary').text('');
            $("#weekly_div").css("display", "none");
            $("#frequency_left_summary_div").attr("style", "display: none !important;");
            $("input[name='which_day_of_the_week_do_you_want_the_service[]']").prop('checked', false);
            updateCalendarDays();
            $('.sticky-button').css('min-height', '75px');
            $('#stickyButton').css('margin-bottom', '22px');
        }
         
        
        $('#frequency_left_summary_replace').html(value);

        calculation();
    }


    function calculation(){

   
    let coupanData;

    // Check if the viewport width is less than or equal to 768px (common breakpoint for mobile devices)
    if (window.innerWidth <= 768) {
        coupanData = JSON.parse($('#mobile_coupan_data_element').val() || '{}');

        // alert('here');
    } else {
        // alert('here 2');
        coupanData = JSON.parse($('#coupan_data_element').val() || '{}');
    }

    // alert(coupanData);

        const radios_1 = document.getElementsByName('how_many_cleaners_do_you_need');
        let how_many_cleaners_do_you_need_value = '';

        for (let i = 0; i < radios_1.length; i++) {
            if (radios_1[i].checked) {
                how_many_cleaners_do_you_need_value = radios_1[i].value;
                break;
            }
        }
        // alert(how_many_cleaners_do_you_need_value);
        
        if (how_many_cleaners_do_you_need_value === '1') {
            $('#cleaner_section').css('display', 'block');
        } else {
            $('#cleaner_section').css('display', 'none');
            $('#cleaner_id').val('');
            $('#cleaner_name').val('');
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
            url: '{{ url(session('search_city_name') . '/get_price_cleaning') }}',
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

                    //alert(no_of_hours);

                   var calchrs = parseInt(no_of_hours);
                   if(calchrs > 0){
                        var calprice = calchrs * hour_charge_db;
                   }else{
                        var calprice = 0;
                   }

                    //alert(calprice);
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

                        var cleaning_discount_additional =(additional_charge) * cleaning_discount/100;

                        var additional_charge_new = parseInt(additional_charge) - parseInt(cleaning_discount_additional);

                        $('.cross_amount_div').show();

                        
                        


                    }else if(how_often_do_you_need_cleaning == 'Multiple times a week'){

                        var cleaning_discount = '{{$multiple_time_week_discout_1}}';
                        var cleaning_discount_amount =(percleanprice) * cleaning_discount/100;
                        var percleanprice_new = parseInt(percleanprice) - parseInt(cleaning_discount_amount);

                        var discount_percentage_new = '{{$multiple_time_week_discout_1}}';

                        $('.cross_amount_div').show();
                        var cleaning_discount_additional =(additional_charge) * cleaning_discount/100;
                        var additional_charge_new = parseInt(additional_charge) - parseInt(cleaning_discount_additional);

                    }else{
                        var cleaning_discount = 0;
                        var cleaning_discount_amount = 0;
                        var cleaning_discount_additional = 0;
                        var percleanprice_new = parseInt(percleanprice) - parseInt(cleaning_discount_amount);
                        var discount_percentage_new = 0;
                        var additional_charge_new = parseInt(additional_charge) - parseInt(cleaning_discount_additional);
                        $('.cross_amount_div').hide();
                    }

                   

                    // alert(cleaner_name);
                    var timing_charge = $('#timing_charge').val();
                    var weekly_off_charge = $('#weekly_off_charge').val();

                   

                    var cod_charge = $('#cod_charge').val();
                    
                    
                    var coupan_value = 0;

                    var service_fee = parseFloat($('#service_fee').val());

                    // alert(coupan_value);
                   
                    
                var home_cleaning_left_value = $("#home_cleaning_left_value").val();
                
                if(home_cleaning_left_value == 2){

                    var sub_total = parseInt(percleanprice_new) + parseInt(additional_charge_new) + parseInt(timing_charge) +  parseInt(weekly_off_charge) + parseInt(cod_charge) - parseInt(discount_amount) + service_fee;
                }else{
                    var sub_total = parseInt(percleanprice_new) + parseInt(additional_charge_new) + parseInt(timing_charge) +  parseInt(weekly_off_charge) + parseInt(cod_charge) - parseInt(discount_amount);
                }
                    

                if (coupanData && coupanData.discount !== '' && coupanData.coupanvalue == 0) {
                        var coupon_discounted = Math.round((sub_total * coupanData.discount) / 100);
                        
                        coupan_name = coupanData.coupancode;
                        
                        if(coupanData.coupan_apply_wallet === 1){
                            coupan_value = coupon_discounted;
                        }else{
                            coupan_value = 0;
                           
                        }
                        $('#coupan_value').val(coupan_value);
                        $('#promo_code_name_replace_home').html(coupan_name);
                        $('#mobile_promo_code_name_replace').html(coupan_name);
                        $('#frequency_summary_promo_code_name_replace').html(coupan_name);
                        $('.cross_amount_div').show();
                    }
                    if (coupanData && coupanData.discount !== '' && coupanData.coupanvalue == 1) {
                        var coupon_discounted = coupanData.discount;
                       
                        coupan_name = coupanData.coupancode;

                        if(coupanData.coupan_apply_wallet === 1){
                            coupan_value = coupon_discounted;
                        }else{
                            coupan_value = 0;
                        }
                        $('#promo_code_name_replace_home').html(coupan_name);
                        $('#mobile_promo_code_name_replace').html(coupan_name);
                        $('#frequency_summary_promo_code_name_replace').html(coupan_name);
                        $('.cross_amount_div').show();
                    }
                    
                   
                  
                    var vat_total = (sub_total) * 5/100;

                    var total_to_pay = parseFloat(sub_total) + parseFloat(vat_total) - parseFloat(coupan_value);

                    // alert(coupan_value);
                    // alert(sub_total);
                    // alert(total_to_pay);

                    $('#mobile_promo_code_replace').html(coupan_value);
                    $('#promo_code_replace_home').html(coupan_value);
                    $('#frequency_summary_promo_code_replace').html(coupan_value);

                    var percleanprice_new1 =parseFloat(percleanprice_new).toFixed(2);
                    var discount_amount =parseFloat(discount_amount).toFixed(2);
                    var additional_charge_new1 =parseFloat(additional_charge_new).toFixed(2);
                    var timing_charge =parseFloat(timing_charge).toFixed(2);
                    var weekly_off_charge =parseFloat(weekly_off_charge).toFixed(2);
                    var cod_charge =parseFloat(cod_charge).toFixed(2);
                    var sub_total =parseFloat(sub_total).toFixed(2);
                    var vat_total =parseFloat(vat_total).toFixed(2);
                    var cross_price =parseFloat(crossprice).toFixed(2);
                    var total_to_pay =parseFloat(total_to_pay).toFixed(2);

                    var vat_amount = parseFloat(sub_total)*5/100;

                    var percleanprice_discount = parseInt(percleanprice)*discount_percentage_new /100;

                    var additional_charge_discount = parseInt(additional_charge)*discount_percentage_new /100;

                    
                    var crossprice_new = parseInt(sub_total) +  parseInt(cleaning_discount_amount) + parseFloat(discount_amount) +  parseFloat(vat_amount);

                    // alert(percleanprice_new1);
                    // alert(discount_amount);
                    // alert(crossprice_new);
                 
                    var crossprice = parseFloat(crossprice_new).toFixed(2);

               
                   
                    var dateSelected = $('#date').val();
                    var monthSelected = $('#month').val();
                    var currentDate = new Date();
                    var currentYear = currentDate.getFullYear();
                    var date = dateSelected + ' ' + monthSelected + ' ' + currentYear; 
                    // $('#frequency_summary_date').html(date); 


                    var time_slotSelected = document.querySelector('input[name="time_slot"]:checked');

                    var Cleaners_Selected = document.querySelector('input[name="cleaner"]:checked');
                    // alert(Cleaners_Selected);
               
                    var cleaner_name = $('#cleaner_name').val();

                    $('#left_summary_cleaner_name').html(cleaner_name);
                    $('#cleaner_replace').html(no_of_cleaners);
                    $('#material_left_summary_replace').html(do_you_need_cleaning_material_value);
                    $('#hour_replace').html(no_of_hours);
                    $('#service_charge_replace').html(percleanprice_new1);
                    $('#service_charge_replace_mobile').html(percleanprice_new1);
                     if (parseFloat(additional_charge_new1) !== 0) {
                        $('#additional_charge_wrapper_mobile').show();
                    } else{
                        $('#additional_charge_wrapper_mobile').hide();
                    }
                    $('#additional_charge_replace_mobile').html(additional_charge_new1);
                    $('#frequency_summary_cross_amount_mobile').html(crossprice);
                    //$('#date_replace').html(date);
                    $('#cross_amount').html(crossprice);
                    $('#frequency_summary_cross_amount').html(crossprice);
                    $('#promo_dicount_replace').html(discount_amount);
                    $('#promo_dicount_replace_mobile').html(discount_amount);
                    $('#additional_charge_replace').html(additional_charge_new1);
                    $('#sub_total_replace').html(sub_total);
                    $('#sub_total_replace_mobile').html(sub_total);
                    $('#vat_charge_replace').html(vat_total);
                    $('#vat_charge_replace_mobile').html(vat_total);
                    $('#total_to_pay_charge_replace').html(total_to_pay);
                    $('#frequency_summary_total_to_pay').html(total_to_pay);
                    $('#total_to_pay_charge_replace_mobile').html(total_to_pay);
                    // $('#service_fee_replace_charge_mobile').html(service_fee);



                    var total_timing_charge_old = parseInt(timing_charge) +  parseInt(weekly_off_charge);
                    // alert(total_timing_charge_old);
                    var total_timing_charge =parseFloat(total_timing_charge_old).toFixed(2);
                    if (parseFloat(total_timing_charge) !== 0) {
                        $('#timing_charge_wrapper').show();
                    }else{
                        $('#timing_charge_wrapper').hide();
                    }
                    $('#timing_charge_replace').html(total_timing_charge);
                    $('#timing_charge_replace_mobile').html(total_timing_charge);
                    $('#frequency_timing_charge_replace').html(total_timing_charge);

                    $('#cod_charge_replace').html(cod_charge);
                    $('#cod_charge_replace_mobile').html(cod_charge);

                    if (parseFloat(cod_charge) !== 0) {
                        $('#cod_charge_wrapper').show();
                        $('#cod_charge_wrapper_mobile').show();
                    }else{
                       $('#cod_charge_wrapper').hide();
                        $('#cod_charge_wrapper_mobile').hide();
                    }

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
                    if(discount_amount > 0){
                        $('.promo_dicount_replace_div').attr('style', 'display: flex !important');
                    } else {
                        $('.promo_dicount_replace_div').attr('style', 'display: none !important');
                    }

                    
                    
                 
                }
            }
        });

    }

    function timeslot_price(price,name,element){

       
        $('#time_replace').html(name);
        $('#frequency_summary_timeslot').html(name);

        $('#timing_charge').val(price);

        // alert(name);

    @php 
    if($subservice_id == 30 || $subservice_id == 28){
    @endphp
    calculation();
    @php 
    }else{
    @endphp
    calculation_book_now('0');
     @php 
    }
    @endphp

    let timeslotId = element.value;
    var cleaner_id = $('#cleaner_id').val();

    // alert(cleaner_id);
    var date = $('#date').val();
    var dateText = $('#date_replace').html();
    var dateParts = dateText.split(' ');      // Split the string by spaces
    var month = dateParts[1];    
    var year = dateParts[2];    

    var subserviceId = $('#subservice_id').val();

    const radios_2 = document.getElementsByName('how_many_hours_should_they_stay');
        let hours = '';

        for (let i = 0; i < radios_2.length; i++) {
            if (radios_2[i].checked) {
                hours = radios_2[i].value;
                break;
            }
        }

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
document.addEventListener("DOMContentLoaded", function () {
    let cleanersDivs = document.querySelectorAll(".cleaners-div");
    let radioButtons = document.querySelectorAll(".cleaners-radio");

    // Select the first radio button by default
    if (radioButtons.length > 0) {
        radioButtons[0].checked = true;
        cleanersDivs[0].classList.add("selected-cleaner");
    }

    // Function to handle selection
    function updateSelection() {
        cleanersDivs.forEach(div => div.classList.remove("selected-cleaner"));
        
        let selectedRadio = document.querySelector(".cleaners-radio:checked");
        if (selectedRadio) {
            selectedRadio.closest(".cleaners-div").classList.add("selected-cleaner");
        }
    }

    // Attach event listeners to radio buttons
    radioButtons.forEach(radio => {
        radio.addEventListener("change", updateSelection);
    });

    // Also trigger selection when clicking on the cleaner div
    cleanersDivs.forEach(div => {
        div.addEventListener("click", function () {
            let radio = this.querySelector(".cleaners-radio");
            if (radio) {
                radio.checked = true;
                updateSelection();
            }
        });
    });
});

function cleaner_data(id,name){

    $('#cleaner_id').val(id);

    $('#cleaner_name').val(name);
    $('input[name="time_slot"]').prop('checked', false);
    $('#time_replace').html(''); 
    $('#timing_charge').val(0);
    $('#weekly_off_charge').val(0);
    $('#date').val('');
    $('#month').val(''); 
    $('#date_replace').html(''); 
    $('.dates-container .is-selected').removeClass('is-selected'); 
    $('#when_would_you_start_slider .disabled-slot').removeClass('disabled-slot'); 
   
    @php 
        if($subservice_id == 30 || $subservice_id == 28){
    @endphp
        calculation();
    @php 
        }else{
    @endphp
        calculation_book_now('0');
    @php 
        }
    @endphp

   
}    


	// function date_select_old() {
		
	// 	var url = '{{ url('cleaner-time-check') }}';
	// 	var cleaner_id = $('#cleaner_id').val();
	// 	var date = $('#date').val();
	// 	var dateText = $('#date_replace').html();
	// 	var dateParts = dateText.split(' ');      // Split the string by spaces
	// 	var month = dateParts[1];   
	// 	var year = dateParts[2];   

	// 	// alert(date);

	// 	$('input[name="time_slot"]').prop('checked', false);
	// 	$('#time_replace').html('');

	// 	$('input[name="time_slot"]').prop('disabled', false);
	// 	$('.surcharge-badge-timeslot').removeClass('disabled-slot');

	// 	// if (cleaner_id != 2) {
	// 		$.ajax({
	// 			url: url,
	// 			type: 'POST',
	// 			data: {
	// 				"_token": "{{ csrf_token() }}",
	// 				'cleaner_id': cleaner_id,
	// 				'date': date,
	// 				'month': month,
	// 				'year': year,
	// 				'subservice_id': '{{ $subservice_id }}'
	// 			},
			  

	//  success: function(response) {
	// 	const res = response.data ?? response; 

	// 	const dateStr = `${res.date}-${res.month}-${res.year}`;
	// 	const selectedDate = moment.tz(dateStr, 'D MMM YYYY', 'Asia/Dubai').startOf('day');
	// 	const today = moment().tz('Asia/Dubai').startOf('day');
	// 	const currentDateTime = moment.tz('Asia/Dubai');
	// 	const isToday = selectedDate.isSame(today, 'day');
	// 	const bufferTime = currentDateTime.clone().add(2, 'hours');

	// 	console.log('Selected Date:', selectedDate.format());
	// 	console.log('Today:', today.format());
	// 	console.log('Is Today:', isToday);
	// 	console.log('Buffer Time:', bufferTime.format());

	// 	let slotHtml = '';
	// 	let i = 1;

	// 	if (!response.timeslot_master || !Array.isArray(response.timeslot_master)) {
	// 		console.error('Missing or invalid timeslot_master');
	// 		return;
	// 	}

	// 	response.timeslot_master.forEach(function(slot) {
	// 		let price = 0;

	// 		slotHtml += `<div class="surcharge-badge-timeslot items">`;

	// 		if (price > 0) {
	// 			slotHtml += `<span>+ AED ${price}</span>`;
	// 		}

	// 		slotHtml += `
	// 			<input type="radio" id="time${i}" name="time_slot"
	// 				data-name="${slot.slot_name}"
	// 				onclick="timeslot_price('${price}', '${slot.slot_name}', this);"
	// 				value="${slot.time_slot_id}">
	// 			<label class="labeltime" for="time${i}" style="border-radius: 50px;">
	// 				${slot.slot_name}
	// 			</label>
	// 		</div>`;
	// 		i++;
	// 	});

	// 	if (slotHtml) {
	// 		$('.time_replace_ab').html(slotHtml);
	// 	} else {
	// 		$('.time_replace_ab').html('<p>No available time slots</p>');
	// 	}

	// 	const slots = $('input[name="time_slot"]');

	// 	// Disable booked slots only if cleaner_id != '2'
	// 	if (res.cleaner_id !== '2') {
	// 		const booked_slots = response.timeslot || [];
	// 		const hours = response.hours || [];

	// 		booked_slots.forEach(function(slot, index) {
	// 			const slotValue = slot.toString();
	// 			const disableHours = parseInt(hours[index], 10);

	// 			slots.each(function(i) {
	// 				if ($(this).val() === slotValue) {
	// 					$(this).prop('disabled', true);
	// 					$(this).closest('.surcharge-badge-timeslot').addClass('disabled-slot');

	// 					for (let j = 1; j <= disableHours; j++) {
	// 						const nextSlot = slots.eq(i + j);
	// 						if (nextSlot.length) {
	// 							nextSlot.prop('disabled', true);
	// 							nextSlot.closest('.surcharge-badge-timeslot').addClass('disabled-slot');
	// 						}
	// 					}
	// 				}
	// 			});
	// 		});
	// 	}

	// 	// Apply buffer filtering for all cleaners if today
	// 	if (isToday) {
	// 		slots.each(function() {
	// 			const timeName = $(this).data('name');
	// 			if (!timeName) return;

	// 			const timeText = timeName.split('-')[0].trim();
	// 			const slotStart = moment.tz(
	// 				selectedDate.format('YYYY-MM-DD') + ' ' + timeText,
	// 				'YYYY-MM-DD h:mm A',
	// 				'Asia/Dubai'
	// 			);

	// 			if (!slotStart.isValid()) return;

	// 			if (slotStart.isBefore(bufferTime)) {
	// 				$(this).prop('disabled', true);
	// 				$(this).closest('.surcharge-badge-timeslot').addClass('disabled-slot');
	// 			}
	// 		});
	// 	}

	// 	// Fallback: Show "no slots" if all are disabled
	// 	const anyEnabled = $('input[name="time_slot"]:not(:disabled)').length > 0;
	// 	if (!anyEnabled) {
	// 		$('.time_replace_ab').html('<p>No available time slots</p>');
	// 	}
	// }
	//  });
	// }
	
	function date_select() {
    var url = '{{ url(session('search_city_name') . '/cleaner-time-check') }}';
    var cleaner_id = $('#cleaner_id').val();
    var date = $('#date').val();
    var dateText = $('#date_replace').html();
    var dateParts = dateText.split(' ');

    var month = dateParts[1];   
    var year = dateParts[2];   

    // alert(dateParts);
    var selectedHours = parseInt($('input[name="how_many_hours_should_they_stay"]:checked').val(), 10) || 0;

    $('input[name="time_slot"]').prop('checked', false);
    $('#time_replace').html('');
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
            'subservice_id': '{{ $subservice_id }}'
        },
          beforeSend: function() {
        // Show blur effect on time slot area
        $('.time_replace_ab').addClass('blur-loader');

        },
        success: function(response) {
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

                let price = slot.price;

                slotHtml += `<div class="surcharge-badge-timeslot items">`;

               if (price > 0) {
					slotHtml += `
						<span>
							+ <p class="currency_dhiram"></p> ${price}
						</span>
					`;
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





function calculation_book_now(id_mobile) {


    if (window.innerWidth <= 768) {
        var coupanData = JSON.parse($('#mobile_coupan_data_element').val() || '{}');
    } else {
        var coupanData = JSON.parse($('#coupan_data_element').val() || '{}');
    }

    @php
    if($subservice_id != 28){
        $subtotal = 0;
        if (Cart::count() > 0) {
            foreach (Cart::content() as $items) {
                if ($items->options->discount_type != '') {
                    if ($items->options->discount_type == 0) {
                        //percentage
                        $disc_price_new = ($items->price * $items->options->discount) / 100;
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
        }else{
            Session::forget('coupan_data');
        }
    }
    @endphp

    var additional_charge = 0;
    var sub_total_old = $('#cart_subtotal_hidden').val().replace(/,/g, '');

    // alert(sub_total_old);
    var timing_charge = $('#timing_charge').val().replace(/,/g, '');
    var weekly_off_charge = $('#weekly_off_charge').val().replace(/,/g, '');
    var cod_charge = $('#cod_charge').val().replace(/,/g, '');

    if (id_mobile == 5) {
        var service_fee = $('#service_fee').val().replace(/,/g, '');
    } else {
        var service_fee = '0';
    }

    var additional_charge = $('#additional_charge').val().replace(/,/g, '');

    sub_total_old = parseFloat(sub_total_old) || 0;
    timing_charge = parseFloat(timing_charge) || 0;
    weekly_off_charge = parseFloat(weekly_off_charge) || 0;
    cod_charge = parseFloat(cod_charge) || 0;
    service_fee = parseFloat(service_fee) || 0;
    additional_charge = parseFloat(additional_charge) || 0;

    var sub_total = sub_total_old + additional_charge + timing_charge + weekly_off_charge + cod_charge;
    var sub_total_new = sub_total + service_fee;
    var vat_total = sub_total * 5 / 100;
    var vat_total_new = sub_total_new * 5 / 100;

    var coupan_value = 0;

if (coupanData && coupanData.discount !== '' && coupanData.coupanvalue == 0) {
    var coupon_discounted = Math.round((sub_total_new * coupanData.discount) / 100);
    coupan_name = coupanData.coupancode;
    if(coupanData.coupan_apply_wallet == 1){
        coupan_value = coupon_discounted;
    }else{
        coupan_value = 0;
    }
    $('#coupan_value').val(coupan_value);
    $('#promo_code_name_replace').html(coupan_name);
    $('#mobile_promo_code_name_replace').html(coupan_name);
    $('#frequency_summary_promo_code_name_replace').html(coupan_name);
    $('.cross_amount_div').show();
}
  
if (coupanData && coupanData.discount !== '' && coupanData.coupanvalue == 1) {

    // alert(1);
    var coupon_discounted = coupanData.discount;
    coupan_name = coupanData.coupancode;
    if(coupanData.coupan_apply_wallet == 1){
        coupan_value = coupon_discounted;
        // alert('discount');
    }else{
        coupan_value = 0;
    }
    $('#coupan_value').val(coupan_value);
    $('#promo_code_name_replace').html(coupan_name);
    $('#mobile_promo_code_name_replace').html(coupan_name);
    $('#frequency_summary_promo_code_name_replace').html(coupan_name);
    $('.cross_amount_div').show();
}

// alert(coupan_value);

    var cross_amount = sub_total + vat_total;
    var total_to_pay = sub_total + vat_total - coupan_value;
    var total_to_pay = parseFloat(total_to_pay).toFixed(2);
    var total_to_pay_grand = sub_total_new + vat_total_new - coupan_value;

    // alert(sub_total_new);
    // alert(vat_total_new);
    // alert(coupan_value);
    var cleaner_name = $('#cleaner_name').val();
    $('#left_summary_cleaner_name').html(cleaner_name);
    $('#frequency_summary_service_charge').html(sub_total_old.toFixed(2));
    $('#frequency_summary_service_sub_total').html(sub_total_new.toFixed(2));
    $('#additional_charge_replace').html(additional_charge.toFixed(2));
    $('#cross_amount').html(cross_amount.toFixed(2));
    $('#sub_total_replace').html(sub_total.toFixed(2));
    $('#frequency_summary_service_sub_total').html(sub_total_new.toFixed(2));
    $('#frequency_summary_service_vat').html(vat_total_new.toFixed(2));
    $('#vat_charge_replace').html(vat_total);
    $('#promo_code_replace').html(coupan_value);
    $('#mobile_promo_code_replace').html(coupan_value);
    
    $('#frequency_summary_promo_code_replace').html(coupan_value);
    $('#total_to_pay_charge_replace').html(total_to_pay);

    var total_weely_charge = parseInt(timing_charge) + parseInt(weekly_off_charge);
    $('#timing_charge_replace').html(total_weely_charge);

    if (!isNaN(parseFloat(total_weely_charge)) && parseFloat(total_weely_charge) !== 0) {
        $('#timing_charge_wrapper').show();
        $('#timing_charge_wrapper_mobile').show();
    }else{
        $('#timing_charge_wrapper').hide();
        $('#timing_charge_wrapper_mobile').hide();
    }
    // alert(total_weely_charge);
    $('#frequency_timing_charge_replace').html(total_weely_charge);

    if (parseFloat(cod_charge) !== 0) {
        $('#cod_charge_wrapper').show();
        $('#cod_charge_wrapper_mobile').show();
    }else{
        $('#cod_charge_wrapper').hide();
        $('#cod_charge_wrapper_mobile').hide();
    }

    $('#cod_charge_replace').html(cod_charge);
    $('#frequency_cod_charge_replace').html(cod_charge);

    $('#service_charge_replace').html(sub_total_old);
    $('#service_charge').val(sub_total_old);
    $('#additional_charge').val(additional_charge);
    $('#sub_total').val(sub_total_new);
    $('#vat_total').val(vat_total_new);
    $('#total_to_pay').val(total_to_pay_grand);

    $('#total_to_pay_charge_replace_mobile').html(total_to_pay_grand.toFixed(2));
    $('#frequency_summary_total_to_pay').html(total_to_pay_grand.toFixed(2));
    $('#cod_charge_replace_mobile').html(cod_charge);
    $('#timing_charge_replace_mobile').html(total_weely_charge);

    if (parseFloat(service_fee) !== 0) {
        $('#service_fee_wrapper_mobile').show();
    }else{
        $('#service_fee_wrapper_mobile').hide();
    }
    $('#frequency_summary_service_fee_charge_mobile').html(service_fee);
    $('#sub_total_replace_mobile').html(sub_total_new);
    
    $('#service_charge_replace_mobile').html(sub_total_new);
     if (parseFloat(additional_charge) !== 0) {
        $('#additional_charge_wrapper_mobile').show();
    }else{
        $('#additional_charge_wrapper_mobile').hide();
    }
    $('#additional_charge_replace_mobile').html(additional_charge);
    $('#vat_charge_replace_mobile').html(vat_total_new);

    if(additional_charge > 0){
        $('.additional_charge_replace_div').attr('style', 'display: flex !important');
    } else {
        $('.additional_charge_replace_div').attr('style', 'display: none !important');
    }

    if(total_weely_charge > 0){
        $('.timing_charge_replace_div').attr('style', 'display: flex !important');
    } else {
        $('.timing_charge_replace_div').attr('style', 'display: none !important');
    }

    if(cod_charge > 0){
        $('.cod_charge_replace_div').attr('style', 'display: flex !important');
    } else {
        $('.cod_charge_replace_div').attr('style', 'display: none !important');
    }

    // if(discount_amount > 0){
    //     $('.promo_dicount_replace_div').attr('style', 'display: flex !important');
    // } else {
    //     $('.promo_dicount_replace_div').attr('style', 'display: none !important');
    // }
}



    function get_hide_show(id){
        

        if (id == 1) {

            $(".tab1").css("display", "block");
            $(".mobile-tab2").css("display", "inline-block");
            $(".mobile-tab3").css("display", "none");
            $(".mobile-tab4").css("display", "none");
            $(".mobile-tab5").css("display", "none");
            $(".mobile-tab6").css("display", "none");
            $(".tab2").css("display", "none");
            $(".tab3").css("display", "none");
            $(".tab4").css("display", "none");
            $(".tab5").css("display", "none");

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
            $(".step-title").append("Service Details");


            const stickyDiv = document.querySelector('.summary_div_left_new');
            // stickyDiv.classList.add('topcss');

            // $(function() {
            //     var cols = $('.wrap .column');
            //     var enabled = true;
            //     var scrollbalance = new ScrollBalance(cols, {
            //     minwidth: 1199
            // });
            // // bind to scroll and resize events
            // scrollbalance.bind();
            // }); 

            
            $('input[name="time_slot"]').prop('checked', false);
            document.querySelectorAll('.calendar-day').forEach(day => day.classList.remove('is-selected'));
            $('#time_replace').html('');
            $('#date').val('');
            $('#month').val('');
            $('#date_replace').html('');
            $('#frequency_summary_date').html('');
        

        }

        if(id == 2){
            //alert(id);
         

            @php

                if($subservice_id == 30 || $subservice_id == 28){
            @endphp

            const radios = document.getElementsByName('how_often_do_you_need_cleaning');
            let selectedValue = null;
            
            // Loop through the radio buttons to find if any is checked
            for (const radio of radios) {
                if (radio.checked) {
                    selectedValue = radio.value;
                    break;
                }
            }

            //alert(selectedValue);

            if (selectedValue == null) {
                jQuery('#how_often_do_you_need_cleaning_error').html(
                    "Please Select How often do you need cleaning");
                jQuery('#how_often_do_you_need_cleaning_error').show().delay(0).fadeIn('show');
                jQuery('#how_often_do_you_need_cleaning_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#how_often_do_you_need_cleaning_error').offset().top - 150
                }, 1000);
                return false;
            }

            if(selectedValue == 'Multiple times a week'){
                var isChecked = $("input[name='which_day_of_the_week_do_you_want_the_service[]']:checked").length > 0;
                
                if (!isChecked) {
                    jQuery('#which_day_of_the_week_do_you_want_the_service_error').html(
                    "Kindly select two days at least");
                    jQuery('#which_day_of_the_week_do_you_want_the_service_error').show().delay(0).fadeIn('show');
                    jQuery('#which_day_of_the_week_do_you_want_the_service_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#which_day_of_the_week_do_you_want_the_service_error').offset().top - 150
                    }, 1000);
                    return false;
                }

                var isChecked_length = $("input[name='which_day_of_the_week_do_you_want_the_service[]']:checked").length;

                if(isChecked_length < 2){
                    jQuery('#which_day_of_the_week_do_you_want_the_service_error').html(
                    "Kindly select two days at least");
                    jQuery('#which_day_of_the_week_do_you_want_the_service_error').show().delay(0).fadeIn('show');
                    jQuery('#which_day_of_the_week_do_you_want_the_service_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#which_day_of_the_week_do_you_want_the_service_error').offset().top - 150
                    }, 1000);
                    return false;
                }
                //alert(isChecked);
               
            }


            // if (!timeSlot1Selected) {
            //     jQuery('#time_slot_error').html(
            //         "Please Select Time Slot");
            //     jQuery('#time_slot_error').show().delay(0).fadeIn('show');
            //     jQuery('#time_slot_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#time_slot_error').offset().top - 150
            //     }, 1000);
            //     return false;
            // }

            @php

               }
            @endphp

            @php

        if($subservice_id == 29 || $subservice_id == 70 || $subservice_id == 71 || 
            $subservice_id == 72 || $subservice_id == 73 || $subservice_id == 79 || 
            $subservice_id == 80 || $subservice_id == 81 || $subservice_id == 82 || 
            $subservice_id == 83 || $subservice_id == 84 || $subservice_id == 85 || 
            $subservice_id == 86 || $subservice_id == 87  || $subservice_id == 52 || $subservice_id == 93){
            @endphp
                var cart_subtotal_hidden = $('#cart_subtotal_hidden').val();

                if(cart_subtotal_hidden != '' && cart_subtotal_hidden < 100){
                    alert('The minimum order of Dirham 100 is required for this service. Add more in the cart.'); return false;
                }
                            
            @php
               }
            @endphp

            $('html, body').animate({
                    scrollTop: $('.tab2').offset().top - 150
                }, 1000);

            $(".tab1").css("display", "none");
            $(".mobile-tab2").css("display", "none");
            $(".mobile-tab3").css("display", "inline-block");
            $(".mobile-tab4").css("display", "none");
            $(".mobile-tab5").css("display", "none");
            $(".mobile-tab6").css("display", "none");
            $(".tab2").css("display", "block");
            $(".tab3").css("display", "none");
            $(".tab4").css("display", "none");
            $(".tab5").css("display", "none");

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
            $(".step-title").append("Scheduling Your Service");

            const stickyDiv = document.querySelector('.summary_div_left_new');
            // stickyDiv.classList.remove('topcss');

            // $(function() {
            // var cols = $('');
            // var enabled = true;
            // var scrollbalance = new ScrollBalance(cols, {
            //     minwidth: 1199
            // });
            // // bind to scroll and resize events
            // scrollbalance.bind();
            // }); 

        }

        if(id == 3){

            // var cleaner_name = $('#cleaner_name').val();
            // // alert(CleanersSelected);
            // if (cleaner_name == "") {
            //     jQuery('#cleaner_error').html("Please Select Cleaner");
            //     jQuery('#cleaner_error').show().delay(0).fadeIn('show');
            //     jQuery('#cleaner_error').show().delay(2000).fadeOut('show');
            //     // $('html, body').animate({
            //     //     scrollTop: $('#cleaner_error').offset().top - 150
            //     // }, 500);
            //     return false;
            // }

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

            @php

                if($subservice_id == 93){
            @endphp

            var any_special_instruction = $('#any_special_instruction').val();
            if (any_special_instruction == '') {
                jQuery('#any_special_instruction_error').html(
                    "Please mention car type, color and number plate details");
                jQuery('#any_special_instruction_error').show().delay(0).fadeIn('show');
                jQuery('#any_special_instruction_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#any_special_instruction_error').offset().top - 150
                }, 1000);
                return false;
            }


                    

            @php
                }
            @endphp

            $('html, body').animate({
                    scrollTop: $('.tab4').offset().top - 150
                }, 1000);


            

            $(".tab1").css("display", "none");
            $(".tab2").css("display", "none");
            $(".mobile-tab2").css("display", "none");
            $(".mobile-tab3").css("display", "none");
            $(".mobile-tab4").css("display", "inline-block");
            $(".mobile-tab5").css("display", "none");
            $(".mobile-tab6").css("display", "none");
            $(".tab3").css("display", "block");
            $(".tab4").css("display", "none");
            $(".tab5").css("display", "none");

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
            $(".step-title").append("Your Location");

            const stickyDiv = document.querySelector('.summary_div_left_new');
            // stickyDiv.classList.remove('topcss'); 
            
            // $(function() {
            // var cols = $('');
            // var enabled = true;
            // var scrollbalance = new ScrollBalance(cols, {
            //     minwidth: 1199
            // });
            // // bind to scroll and resize events
            // scrollbalance.bind();
            // }); 
            
            // $(".step-title").text("Your Location");
            }

        if(id == 4){

            var city = $('#city').val();
            if (city == '') {
                jQuery('#city_error').html(
                    "Please Select City");
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

            $(".summary_div_left_new").css("display", "block");

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

            const stickyDiv = document.querySelector('.summary_div_left_new');
            // stickyDiv.classList.remove('topcss');
            
            // $(function() {
            // var cols = $('');
            // var enabled = true;
            // var scrollbalance = new ScrollBalance(cols, {
            //     minwidth: 1199
            // });
            // // bind to scroll and resize events
            // scrollbalance.bind();
            // }); 
                // $(".step-title").text("Payment Information");

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
                var cleaner_name = $('#cleaner_name').val();
                $('#frequency_summary_cleaner_name').html(cleaner_name);
            @php
                }
            @endphp

            var cleaner_name = $('#cleaner_name').val();
            $('#frequency_summary_cleaner_name').html(cleaner_name);

            var citySelected = $('#city').val();
            var areaSelected = $('#area').val();
            var building_street_noSelected = $('#building_street_no').val();
            var apartment_villa_noSelected = $('#apartment_villa_no').val();

            var address = citySelected + ', ' + areaSelected + ', ' + building_street_noSelected + ', ' + apartment_villa_noSelected; 
            $('#frequency_summary_address').html(address); 



            var dateSelected = $('#date').val();
            var monthSelected = $('#month').val();
            var currentDate = new Date();
            var currentYear = currentDate.getFullYear();
            var date = dateSelected + ' ' + monthSelected + ' ' + currentYear; 
            // $('#frequency_summary_date').html(date); 


            var time_slotSelected = document.querySelector('input[name="time_slot"]:checked');

            var Cleaners_Selected = document.querySelector('input[name="cleaner"]:checked');
           
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


            var service_charge = $('#service_charge').val();
            var additional_charge = $('#additional_charge').val();
            var cod_charge = $('#cod_charge').val();
            var service_fee = $('#service_fee').val();
            var timing_charge = $('#timing_charge').val();
            var weekly_off_charge = $('#weekly_off_charge').val();
           var promo_discount = $('#promo_discount').val(); 
           


            //var sub_total = parseInt(percleanprice) + parseInt(additional_charge) + parseInt(timing_charge) + parseInt(cod_charge) - parseInt(discount_amount);

            var sub_total = parseInt(service_charge) + parseInt(additional_charge) + parseInt(cod_charge) + parseInt(timing_charge) + parseInt(weekly_off_charge) + parseInt(service_fee) - parseInt(promo_discount) ;

            var vat_charge = sub_total * 5 /100;
           
            var how_often_do_you_need_cleaning = $('input[name="how_often_do_you_need_cleaning"]:checked').val();

            if(how_often_do_you_need_cleaning == 'Weekly'){

                var cleaning_discount = '{{$weekly_discout_1}}';
                var original_service_charge = service_charge / (1 - cleaning_discount / 100);
                var cleaning_discount_amount = original_service_charge - service_charge;
            }else if(how_often_do_you_need_cleaning == 'Multiple times a week'){

                var cleaning_discount = '{{$multiple_time_week_discout_1}}';
                var original_service_charge = service_charge / (1 - cleaning_discount / 100);
                var cleaning_discount_amount = original_service_charge - service_charge;
               
            }else{
                var cleaning_discount = 0;
                var cleaning_discount_amount = 0;
                $('.cross_amount_div').hide();
            }
            // alert(cleaning_discount_amount);
            var crossprice = parseFloat(sub_total) + parseInt(cleaning_discount_amount) + parseFloat(vat_charge) + parseFloat(promo_discount);
            //  alert(sub_total);
            //  alert(cleaning_discount_amount);
            //  alert(vat_charge);
            //  alert(promo_discount);
            //  alert(crossprice);
            
            let coupan_value = 0;
            
            if (window.innerWidth <= 768) {
            var coupan_element_data = $('#mobile_coupan_data_element').val();
            }else{
            var coupan_element_data = $('#coupan_data_element').val();
            }

            // alert(coupan_element_data);
            var parsedData = JSON.parse(coupan_element_data || '{}');

            if (parsedData && parsedData.discount !== '' && parsedData.coupanvalue == 0) {
            var coupon_discounted = Math.round((sub_total * parsedData.discount) / 100);
            if(parsedData.coupan_apply_wallet == 1){
                coupan_value = coupon_discounted;
            }else{
                coupan_value = 0;
            }
            coupan_name = parsedData.coupancode;
            $('.cross_amount_div').show();
            }
            if (parsedData && parsedData.discount !== '' && parsedData.coupanvalue == 1) {
                var coupon_discounted = parsedData.discount;
                if(parsedData.coupan_apply_wallet == 1){
                    coupan_value = coupon_discounted;
                }else{
                    coupan_value = 0;
                }
                coupan_name = parsedData.coupancode;
                $('.cross_amount_div').show();
            }

            var total_to_pay = sub_total + vat_charge - coupan_value;

            var sub_total = $('#sub_total').val(sub_total);
            var vat_total = $('#vat_total').val(vat_charge);
            var total_to_pay = $('#total_to_pay').val(total_to_pay);


            var sub_total = $('#sub_total').val();
            var vat_total = $('#vat_total').val();
            var vat_total = parseFloat(vat_total).toFixed(2);

            var total_to_pay = $('#total_to_pay').val();
           
            var sub_total =parseFloat(sub_total).toFixed(2);

            var total_to_pay =parseFloat(total_to_pay).toFixed(2);

            var service_fee =parseFloat(service_fee).toFixed(2);

            var crossprice =parseFloat(crossprice).toFixed(2);

            if (parseFloat(additional_charge) !== 0) {
                $('#additional_charge_wrapper').show();
            }else{
                $('#additional_charge_wrapper').hide();
            } 
            if (parseFloat(service_fee) !== 0) {
                $('#service_fee_wrapper').show();
                $('#service_fee_wrapper_mobile').show();
            } else{
                $('#service_fee_wrapper').hide();
                $('#service_fee_wrapper_mobile').hide();
            }

            $('#frequency_summary_service_charge').html(service_charge);
            $('#frequency_summary_cross_amount').html(crossprice);
            $('#frequency_summary_cross_amount_mobile').html(crossprice);
            $('#frequency_summary_promo_discount').html(promo_discount);
            $('#frequency_summary_additional_charge').html(additional_charge);
            $('#frequency_summary_service_fee_charge').html(service_fee);
            $('#frequency_summary_service_fee_charge_mobile').html(service_fee);
            $('#frequency_summary_service_sub_total').html(sub_total);
            $('#frequency_summary_service_vat').html(vat_total);
            $('#frequency_summary_total_to_pay').html(total_to_pay);
            $('#total_to_pay_charge_replace_mobile').html(total_to_pay);
            $('#frequency_summary_cod_charge').html(cod_charge);

            var walletAmount = parseFloat($('#wallet_amount').text().replace('Wallet Amount (', '').replace(' AED)', ''));
            // alert(walletAmount);

            // $('.wallet_apply').attr('onclick', 'apply_wallet_discount("' + total_to_pay + '", "' + walletAmount + '");');

            // $('.wallet_cancel').attr('onclick', 'cancelWalletDiscount("' + total_to_pay + '", "' + walletAmount + '");');

            $('#frequency_summary_cod_charge').html(cod_charge);
            
            
            

            $(".summary_div_left_new").css("display", "none");

            // alert('test');
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
            $("#mobile-promo-code-view").css("display", "none");
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

            // calculation();

            @php
        if($subservice_id == 29 || $subservice_id == 70 || $subservice_id == 71 ||
           $subservice_id == 72|| $subservice_id == 73 || $subservice_id == 79 || 
           $subservice_id == 80 || $subservice_id == 81 || $subservice_id == 82 ||
           $subservice_id == 83 || $subservice_id == 84 || $subservice_id == 85 || 
           $subservice_id == 86 || $subservice_id == 87 || $subservice_id == 88 || $subservice_id == 52 || $subservice_id == 93){
            @endphp
            calculation_book_now('5');
            @php

            }
            @endphp

            // alert('here');
           
            @php
            if($subservice_id == 28){
                
            @endphp
            var home_cleaning_left_value = $('#home_cleaning_left_value').val();
            // alert(home_cleaning_left_value);
            if(home_cleaning_left_value == 1){
            apply_promo_home_cleaning(5);
            }
            @php
            }
            @endphp
            

            }

            if(id == 6){
                // alert('test');

                $(".mobile-tab2").css("display", "none");
                $(".mobile-tab3").css("display", "none");
                $(".mobile-tab4").css("display", "none");
                $(".mobile-tab5").css("display", "none");
                $(".mobile-tab6").css("display", "none");
                $(".spinner-mobile-tab6").css("display", "block");
                $('#spinner_button').show();
                $('.order_now').hide();
                $('#category_form_new').submit();
            }
    }
    </script>
    <script>
        function apply_wallet_discount() {

            var total_wallet_amount = $('#total_to_pay').val();
            var userWalletamount = $('#wallet_amount_new').val();
           
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
					- <img class="dhiram"
						   src="{{ asset('public/site/images/automobile/DirhamBlue.png') }}"
						   alt="Dirham Icon">
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
    
function cancelWalletDiscount() {
    // AJAX to revert the applied discount
    var orderTotal = $('#total_to_pay').val();
    var Walletamount = $('#wallet_amount_new').val();

    // alert(orderTotal);
    // alert(userWalletamount);
    $.ajax({
        type: 'POST',
        url: '{{ url("cancel-wallet-discount-book-now") }}',
        data: {
            "_token": "{{ csrf_token() }}",
            "orderTotal": orderTotal,
            "userWalletAmount": Walletamount
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
        ? `
        <div class="surcharge-badge-dayslot" style="position:relative;">
            <span>
                + <img class="dhiram"
                       src="{{ asset('public/site/images/automobile/DirhamBlack.png') }}"
                       alt="Dirham Icon"> 5
            </span>
        </div>`
        : ''
    }
`;

    dayDiv.addEventListener('click', function() {
        if (!dayDiv.classList.contains('disabled')) {
            document.querySelectorAll('.calendar-day').forEach(day => day.classList.remove('is-selected'));
            dayDiv.classList.add('is-selected');


                        
            // If it's Saturday (6) or Sunday (0)
            if (formattedDate.day === 'Sa' || formattedDate.day === 'Su' || isToday(currentDate)) {
            //    alert('You selected a weekend!');

                var weekly_off_charge = 5;
            }else{
                var weekly_off_charge = 0;
            }

            $('#weekly_off_charge').val(weekly_off_charge);


            // Update date and month somewhere in your form
            $('#date').val(formattedDate.date);
            $('#month').val(formattedDate.month);
            const date_new = formattedDate.date + ' ' + formattedDate.month + ' ' + formattedDate.year;
            $('#date_replace').html(date_new);
            $('#frequency_summary_date').html(date_new);
            calculation();
            calculation_book_now('0');
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

                    
                    $("#message_error").html("Package Removed From Cart");
                    $('#message_error').show().delay(0).fadeIn('show');
                    $('#message_error').show().delay(2000).fadeOut('show');
                    // $("#cart_div_form").load(location.href + " #cart_div_form");
                        $(".summary_div_left_new").load(location.href + " .summary_div_left_new");
                        calculation_book_now('0');
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
         // Arrow Icon Click Event
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


$(document).ready(function(){
    var itemCount = $("#when_would_you_start_slider").children().length;
    // Set loop to true if there are more than 3 items.
    var shouldLoop = itemCount > 3;
    $("#when_would_you_start_slider").owlCarousel({
        loop: shouldLoop,          // Enables infinite looping
        margin: 10,          // Adjust the margin between items
        nav: true,
        dots:false,           // Show navigation buttons
        navText: ['<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><rect fill="none" height="24" width="24"></rect><g><polygon points="17.77,3.77 16,2 6,12 16,22 17.77,20.23 9.54,12"></polygon></g></svg>', '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><g><path d="M0,0h24v24H0V0z" fill="none"></path></g><g><polygon points="6.23,20.23 8,22 18,12 8,2 6.23,3.77 14.46,12"></polygon></g></svg>'],
        responsive: {
            0: {
                items: 1.5
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        },
        onInitialized: updateCloneIds,
        onTranslated: updateCloneIds
    });
    function updateCloneIds() {
        $('#when_would_you_start_slider .owl-item.cloned').each(function(index, element) {
            $(element).find('input[type="radio"]').each(function(i, radioButton) {
                var newId = $(radioButton).attr('id') + '_cloned_' + index;
                $(radioButton).attr('id', newId);
                $(radioButton).siblings('label').attr('for', newId);
            });
        });
    }
});
$(document).ready(function(){
    var itemCount = $("#select_your_cleaner").children().length;
    // Set loop to true if there are more than 3 items.
    var shouldLoop = itemCount > 3;
    $("#select_your_cleaner").owlCarousel({
        loop: shouldLoop,          // Enables infinite looping
        margin: 10,          // Adjust the margin between items
        nav: true,
        dots:false,           // Show navigation buttons
        navText: ['<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><rect fill="none" height="24" width="24"></rect><g><polygon points="17.77,3.77 16,2 6,12 16,22 17.77,20.23 9.54,12"></polygon></g></svg>', '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><g><path d="M0,0h24v24H0V0z" fill="none"></path></g><g><polygon points="6.23,20.23 8,22 18,12 8,2 6.23,3.77 14.46,12"></polygon></g></svg>'],
        responsive: {
            0: {
                items: 1.5
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        },
        onInitialized: updateCloneIds,
        onTranslated: updateCloneIds
    });
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

document.addEventListener('DOMContentLoaded', function () {
    new Splide('#select_your_cleaner_slider_spatie', {
        type: 'slide',
        perPage: 3,
        focus: 'center',
        autoplay: false,
        pagination: false,
        arrows: true,
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
        // ✅ Correct placement of these event handlers
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
    
    $(document).ready(function() {
        var mainTitle = $('.mobilie_header_nav');
        var Step = $('.main-title');
        var categoryForm = $('#category_form_new');
        var originalOffset = mainTitle.offset().top;

        $(window).scroll(function() {
            if ($(window).width() <= 768) { 
                if ($(window).scrollTop() > originalOffset) {
                    // categoryForm.css('margin-top', '380px');
                    mainTitle.addClass('fixed-title');
                    /* Step.addClass('step-fix'); 
                    Step.css({
                        'position': 'fixed',
                        'top': '0', 
                        'width': '100%', 
                        'z-index': '1000'
                    }); */

                    // Add top margin to category_form_new to offset the fixed header
                   
                } else {
                    categoryForm.css('margin-top', '0');
                    mainTitle.removeClass('fixed-title'); // Remove fixed class and show original
                    /* Step.removeClass('step-fix'); // Remove fixed class and show original
                    Step.css({
                        'position': 'relative' // Reset to normal flow when not fixed
                    }); */

                    // Reset margin when header is not fixed
                   
                }
            } else {
                // Optionally, you can reset the styles for larger screens
                categoryForm.css('margin-top', '0');
                mainTitle.removeClass('fixed-title');
                /* Step.removeClass('step-fix');
                Step.css({
                    'position': 'relative' // Reset to normal flow for larger screens
                }); */

                // Reset margin for larger screens
              
            }
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
        const slider = document.getElementById('radioSlider');
        const leftArrow = document.querySelector('.left-arrow');
        const rightArrow = document.querySelector('.right-arrow');

        leftArrow.addEventListener('click', () => {
            slider.scrollBy({ left: -200, behavior: 'smooth' });
        });

        rightArrow.addEventListener('click', () => {
            slider.scrollBy({ left: 200, behavior: 'smooth' });
        });
    });
// For fixed package category scroller slider
    
document.querySelectorAll('.radio-slider-wrapper input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function () {
        this.closest('.radio-item').scrollIntoView({ behavior: 'smooth', inline: 'center' });
    });
});

   const slider = document.querySelector('.radio-slider-wrapper');

    let isSliderDown = false;
    let sliderStartX;
    let sliderScrollLeft;

    slider.addEventListener('mousedown', (e) => {
        isSliderDown = true;
        slider.classList.add('dragging');
        sliderStartX = e.pageX - slider.offsetLeft;
        sliderScrollLeft = slider.scrollLeft;
    });

    slider.addEventListener('mouseleave', () => {
        isSliderDown = false;
        slider.classList.remove('dragging');
    });

    slider.addEventListener('mouseup', () => {
        isSliderDown = false;
        slider.classList.remove('dragging');
    });

    slider.addEventListener('mousemove', (e) => {
        if (!isSliderDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - sliderStartX) * 1.5;
        slider.scrollLeft = sliderScrollLeft - walk;
    });

    const scrollRadioIntoView = (radio) => {
    const sliderContainer = radio.closest('.radio-slider-wrapper');
    if (!sliderContainer) return;

    const radioItem = radio.closest('.radio-item');
    const sliderRect = sliderContainer.getBoundingClientRect();
    const radioRect = radioItem.getBoundingClientRect();

    // Check if radioItem is fully visible in the container
    const isFullyVisible =
        radioRect.left >= sliderRect.left &&
        radioRect.right <= sliderRect.right;

    if (!isFullyVisible) {
        // Calculate how far we need to scroll to fully show the item
        const scrollOffset = radioItem.offsetLeft - (sliderContainer.offsetWidth / 2) + (radioItem.offsetWidth / 2);

        // Clamp the scroll value to not exceed max scroll
        const maxScrollLeft = sliderContainer.scrollWidth - sliderContainer.clientWidth;
        const finalScroll = Math.max(0, Math.min(scrollOffset, maxScrollLeft));

        sliderContainer.scrollTo({
            left: finalScroll,
            behavior: 'smooth'
        });
    }
};






         //for Furniture Cleaning Scroll down fucntionality
        document.addEventListener("DOMContentLoaded", function() {
        const categorySections = document.querySelectorAll("[id^='package-category-']");
        const radioButtons = document.querySelectorAll("input[name='package_cat']");
        const urlParams = new URLSearchParams(window.location.search);
        const categoryFromUrl = urlParams.get("category");

        // alert(categoryFromUrl);

        // Function to scroll to the category smoothly
        const scrollToCategory = (categoryId) => {
            const targetElement = document.getElementById(`package-category-${categoryId}`);
            if (targetElement) {
                setTimeout(() => {
                    targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 300); // Delay to ensure everything loads
            }
        };

        // Handle category from URL
        if (categoryFromUrl) {
        scrollToCategory(categoryFromUrl);

        // Select the corresponding radio button
        radioButtons.forEach(radio => {
            const isActive = radio.value.trim() === categoryFromUrl.trim();
            radio.checked = isActive;

            if (isActive) {
                radio.parentElement.classList.add('active');
                setTimeout(() => {
                    scrollRadioIntoView(radio); // <== keep this!
                }, 100);
            }
            else {
                radio.parentElement.classList.remove('active');
            }
        });
    }


            const observer = new IntersectionObserver((entries) => {
            const visibleEntry = entries.find(entry => entry.isIntersecting);
            if (!visibleEntry) return;

            const categoryId = visibleEntry.target.id.replace('package-category-', '');

            radioButtons.forEach(radio => {
                const isActive = radio.value === categoryId;
                radio.checked = isActive;
                radio.parentElement.classList.toggle('active', isActive);

                if (isActive) {
                    setTimeout(() => scrollRadioIntoView(radio), 100);
                }
            });
        }, {
            threshold: window.innerWidth < 768 ? 0.1 : 0.3 // 👈 More sensitive on mobile
        });



        // Observe all sections
        categorySections.forEach(section => {
            observer.observe(section);
        });

        // Handle radio button change to scroll to the category
        radioButtons.forEach(radio => {
            radio.addEventListener('change', () => {
                scrollToCategory(radio.value);
                scrollRadioIntoView(radio); // <== Add this too just in case!
            });
        });

        // Sticky header logic
        // $(window).scroll(function () {
        // const isSticky = $(this).scrollTop() > 0;

        //     if (isSticky) {
        //         $('#sticky-header').addClass('sticky-active');
        //         $('.mobile-category-wrapper').addClass('d-none');
        //         $('.slider-category-wrapper').removeClass('d-none');
        //     } else {
        //         $('#sticky-header').removeClass('sticky-active');
        //         $('.mobile-category-wrapper').removeClass('d-none');
        //         $('.slider-category-wrapper').addClass('d-none');
        //     }
        // });
        // Sticky header + other scroll logic in one place
$(window).scroll(function () {
    const scrollTop = $(this).scrollTop();
    const isSticky = scrollTop > 0;
    const stickyHeader = $('#sticky-header');
    const footer = $('.footer-style1');

    // Sticky header toggle
    if (isSticky) {
        stickyHeader.addClass('sticky-active');
        $('.mobile-category-wrapper').addClass('d-none');
        $('.slider-category-wrapper').removeClass('d-none');
    } else {
        stickyHeader.removeClass('sticky-active');
        $('.mobile-category-wrapper').removeClass('d-none');
        $('.slider-category-wrapper').addClass('d-none');
    }

    // --- hide header 100px before footer ---
    if (footer.length > 0) {
        const footerTop = footer.offset().top;
        const headerBottom = scrollTop + stickyHeader.outerHeight();

        if (headerBottom + 300 >= footerTop) { 
            if (stickyHeader.is(':visible')) stickyHeader.fadeOut();
        } else {
            if (!stickyHeader.is(':visible')) stickyHeader.fadeIn();
        }
    }
});




    });

    $(window).scroll(function () {
    if ($(window).scrollTop() > 0) {
        const col = $('.col-lg-6:has(#sticky-header)');
        const offset = col.offset();
        const width = col.outerWidth();

        const newWidth = width * 0.96; 
        const newLeft = offset.left + (width - newWidth) / 2;

        $('#sticky-header').addClass('sticky-active').css({
            position: 'fixed',
            top: '185px',
            left: newLeft + 'px',
            width: newWidth + 'px'
        });
        
    } else {
        $('#sticky-header').removeClass('sticky-active').css({
            position: '',
            top: '',
            left: '',
            width: ''
        });
    }
});

// $(window).resize(function () {
//     if ($('#sticky-header').hasClass('sticky-active')) {
//         const col = $('.col-lg-6:has(#sticky-header)');
//         const offset = col.offset();
//         const width = col.outerWidth();

//         $('#sticky-header').css({
//             left: offset.left + 'px',
//             width: width + 'px'
//         });
//     }
// });

</script>


<script>
function plus_qty_book_now(rowid) {

    // alert
    var input = $('#input_' + rowid);
    var currentQty = parseInt(input.val());
    var newCount = currentQty + 1;

    // alert(input);
    // alert(currentQty);
    // alert(newCount);

    var url = '{{ url('update_cart_book_now') }}';

    $.ajax({
        url: url,
        type: 'post',
        data: {
            '_token': '{{ csrf_token() }}',
            'rowid': rowid,
            'count': newCount,
        },
        success: function (msg) {
            var data = JSON.parse(msg);

            input.val(data.count); // Update the input value with the server response
            $('#cart_subtotal_hidden').val(data.subtotal);

            $('#plus_' + rowid).prop("disabled", false);

            // $(".summary_div_left_new").load(location.href + " .summary_div_left_new", function () {
            //     calculation_book_now('0');
            // });
            // $(".hidden_refresh_cart").load(location.href + " .hidden_refresh_cart");
         
                // $(".summary_div_left_new").addClass("blur");
                $(".summary_div_left_new").load(location.href + " .summary_div_left_new", function() {
                        calculation_book_now('0');
                        // $(".summary_div_left_new").removeClass("blur");
                    });
                $(".hidden_refresh_cart").load(location.href + " .hidden_refresh_cart", function() {
                });
        }
    });

    return false;
}


function minus_qty_book_now(rowid) {
    var input = $('#input_' + rowid);
    var currentQty = parseInt(input.val());
    var newCount = currentQty - 1;

    // If the quantity reaches 0, remove the item from the cart
    if (newCount <= 0) {
        // Confirm before removing the item
        if (!confirm("Do you want to remove this item from the cart?")) {
            return false;
        }
    }

    $('#minus_' + rowid).prop('disabled', true);

    $.ajax({
        url: newCount <= 0 ? '{{ url('minus-quantity-cart-remove-book-now') }}' : '{{ url('update_cart_book_now') }}',
        type: 'post',
        data: {
            '_token': '{{ csrf_token() }}',
            'rowid': rowid,
            'count': newCount <= 0 ? 0 : newCount,
        },
        success: function (msg) {
            var data = JSON.parse(msg);

            if (newCount <= 0) {
                // Remove the item from the cart UI
                $('#cart_item_' + rowid).remove();
                $('#package_' + data.package_id).html(`
                    <button type="button" class="btn border border-primary rounded text-primary add-to-card px-3"
                            onclick="add_to_cart_book('${data.package_id}')">Add +</button>
                `);
                $(".hidden_refresh_cart").load(location.href + " .hidden_refresh_cart");
                calculation_book_now('0');
            } else {
                // Update the input value with the server response
                input.val(data.count);
                $(".hidden_refresh_cart").load(location.href + " .hidden_refresh_cart");
                calculation_book_now('0');
            }

            // Update the cart subtotal and other UI components
            $('#cart_subtotal_hidden').val(data.subtotal);
            // $(".summary_div_left_new").addClass("blur");
            $(".summary_div_left_new").load(location.href + " .summary_div_left_new", function () {
                calculation_book_now('0');
                // $(".summary_div_left_new").removeClass("blur");
            });
            $(".hidden_refresh_cart").load(location.href + " .hidden_refresh_cart");
        },
        complete: function () {
            $('#minus_' + rowid).prop('disabled', false);
        }
    });

    return false;
}

function apply_promo() {
    var promo_code = $("#promo_code").val(); // Desktop input field
    var mobile_promo_code = $("#mobile_promo_code").val(); // Mobile input field

    // Determine if the user is on mobile or desktop
    var isMobile = $(window).width() <= 768; // Assuming width <= 768px is mobile

    // Use the appropriate promo code based on the device
    var promo = isMobile ? mobile_promo_code : promo_code;

    // Input validation
    if (promo === '') {
        if (isMobile) {
            $("#mobile_promo_code_error").html("Enter Coupon Code.");
            $('#mobile_promo_code_error').show().delay(2000).fadeOut('show');
            $("#mobile_promo_code_success").html("");
        } else {
            $("#promo_code_error").html("Enter Coupon Code.");
            $('#promo_code_error').show().delay(2000).fadeOut('show');
            $("#promo_code_success").html("");
        }
        return false;
    }

    // AJAX Request to validate promo code
    var url = '{{ url('promo_codecheck') }}';
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            '_token': '{{ csrf_token() }}',
            'promo': promo,
        },
        success: function(result) {
            console.log(result);

            // Handle response
            if (result === 'invalid') {
                if (isMobile) {
                    $("#mobile_promo_code_error").html("Invalid Coupon Code.");
                    $('#mobile_promo_code_error').show().delay(2000).fadeOut('show');
                    $("#mobile_promo_code_success").html("");
                } else {
                    $("#promo_code_error").html("Invalid Coupon Code.");
                    $('#promo_code_error').show().delay(2000).fadeOut('show');
                    $("#promo_code_success").html("");
                }
            }else if (result === 'invalid_date') {
                if (isMobile) {
                    $("#mobile_promo_code_error").html("Coupon Code Expired.");
                    $('#mobile_promo_code_error').show().delay(2000).fadeOut('show');
                    $("#mobile_promo_code_success").html("");
                } else {
                    $("#promo_code_error").html("Coupon Code Expired.");
                    $('#promo_code_error').show().delay(2000).fadeOut('show');
                    $("#promo_code_success").html("");
                }
            }else if (result === 'invalid_user_count') {
                if (isMobile) {
                    $("#mobile_promo_code_error").html("Coupon Code Expired.");
                    $('#mobile_promo_code_error').show().delay(2000).fadeOut('show');
                    $("#mobile_promo_code_success").html("");
                } else {
                    $("#promo_code_error").html("Coupon Code Expired.");
                    $('#promo_code_error').show().delay(2000).fadeOut('show');
                    $("#promo_code_success").html("");
                }
            }else if (result === 'Already') {
                if (isMobile) {
                    $("#mobile_promo_code_error").html("Coupon Code is Already Applied.");
                    $('#mobile_promo_code_error').show().delay(2000).fadeOut('show');
                    $("#mobile_promo_code_success").html("");
                } else {
                    $("#promo_code_error").html("Coupon Code is Already Applied.");
                    $('#promo_code_error').show().delay(2000).fadeOut('show');
                    $("#promo_code_success").html("");
                }
            } else if (result === 'success') {
                calculation_book_now('0');
            if (isMobile) {
                // alert('here');
                $("#mobile_promo_code_error").html("");
                $("#mobile_promo_code_success").html("Coupon Code Applied Successfully.");
                $('#mobile_promo_code_success').show().delay(2000).fadeOut('show');


                $("#mobile_coupan_refresh_id").load(location.href + " #mobile_coupan_refresh_id", function () {
                var coupan_apply_wallet_data = $('#mobile_coupan_data_element').val();

                // Ensure that the data is parsed correctly
                coupan_apply_wallet_data = JSON.parse(coupan_apply_wallet_data);

                if (coupan_apply_wallet_data.coupan_apply_wallet == 1) {
                    $('#mobile_coupan_refresh_id').show();
                    $('.home_cleaning_session_div').css('display', 'block');
                    $('.mobile_home_cleaning_session_div').css('display', 'block');
                    $('.last_summary_session_home_cleaning_div').css('display', 'block');
                    setTimeout(location.reload.bind(location), 2000);
                } else {
                    $('#mobile_coupan_refresh_id').hide();
                    $('.home_cleaning_session_div').css('display', 'block');
                    $('.mobile_home_cleaning_session_div').css('display', 'block');
                    $('.last_summary_session_home_cleaning_div').css('display', 'block');

                    alert("Congratulations! The coupon amount will be added to your wallet after this order.");

                    location.reload();
                }
                });
            } else {
                $("#promo_code_error").html("");
                $("#promo_code_success").html("Coupon Code Applied Successfully.");
                $('#promo_code_success').show().delay(2000).fadeOut('show');

                $("#coupan_refresh_id").load(location.href + " #coupan_refresh_id", function () {
                    var coupan_apply_wallet_data = $('#coupan_data_element').val();

                    coupan_apply_wallet_data = JSON.parse(coupan_apply_wallet_data);

                    if (coupan_apply_wallet_data.coupan_apply_wallet == 1) {
                        $('#coupan_refresh_id').show();
                        $('.home_cleaning_session_div').css('display', 'block');
                        $('.mobile_home_cleaning_session_div').css('display', 'block');
                        $('.last_summary_session_home_cleaning_div').css('display', 'block');
                        setTimeout(location.reload.bind(location), 2000);
                    } else {
                        $('#coupan_refresh_id').hide();
                        $('.home_cleaning_session_div').css('display', 'block');
                        $('.mobile_home_cleaning_session_div').css('display', 'block');
                        $('.last_summary_session_home_cleaning_div').css('display', 'block');

                        alert("Congratulations! The coupon amount will be added to your wallet after this order.");

                        location.reload();
                    }
                });
            }
            

            } else if (result === 'grater') {
                if (isMobile) {
                    $("#mobile_promo_code_error").html("Coupon Code Value Greater Than Your Total.");
                    $('#mobile_promo_code_error').show().delay(2000).fadeOut('show');
                } else {
                    $("#promo_code_error").html("Coupon Code Value Greater Than Your Total.");
                    $('#promo_code_error').show().delay(2000).fadeOut('show');
                }
            } else {
                if (isMobile) {
                    $("#mobile_promo_code_error").html(`
    Minimum order amount should be 
    <img class="dhiram"
         src="{{ asset('public/site/images/automobile/DirhamBlack.png') }}"
         alt="Dirham Icon">
    ${result}
`);
                    $('#mobile_promo_code_error').show().delay(2000).fadeOut('show');
                } else {
                    $("#promo_code_error").html(`
						Minimum order amount should be 
						<img class="dhiram"
							 src="{{ asset('public/site/images/automobile/DirhamBlack.png') }}"
							 alt="Dirham Icon">
						${result}
					`);
                    $('#promo_code_error').show().delay(2000).fadeOut('show');
                }
            }
        }
    });
}

function remove_coupon(){

var answer = window.confirm("Do you want to remove this Coupon Code?");
if (answer) {

    var url = '{{ url('remove_coupon') }}';
    $.ajax({

        type : 'POST',
        url : url,
        data :{'_token': '{{ csrf_token() }}'},

        success : function(msg){
            setTimeout(location.reload.bind(location), 0);
            calculation_book_now('0');
        }

    });

}
}

function last_summary_apply_promo() {

var promo_code = $("#frequency_summary_promo_code").val(); // Desktop input field

var additional_charge = $('#additional_charge').val();
var weekly_off_charge = $('#weekly_off_charge').val();
var cod_charge = $('#cod_charge').val();
var service_fee = $('#service_fee').val();
var timing_charge = $('#timing_charge').val();
var promo_discount = $('#promo_discount').val(); 

var promo = promo_code;

// Input validation
if (promo === '') {
        $("#frequency_summary_promo_code_error").html("Enter Coupon Code.");
        $('#frequency_summary_promo_code_error').show().delay(2000).fadeOut('show');
        $("#frequency_summary_promo_code_success").html("");
    return false;
}

// AJAX Request to validate promo code
var url = '{{ url('lat_summary_promo_codecheck') }}';
$.ajax({
    url: url,
    type: 'POST',
    data: {
        '_token': '{{ csrf_token() }}',
        'promo': promo,
        'additional_charge': additional_charge,
        'weekly_off_charge': weekly_off_charge,
        'cod_charge': cod_charge,
        'service_fee': service_fee,
        'promo_discount': promo_discount,
        'timing_charge': timing_charge,
    },
    success: function(result) {
        console.log(result);

        // Handle response
        if (result === 'invalid') {
            $("#frequency_summary_promo_code_error").html("Invalid Coupon Code.");
            $('#frequency_summary_promo_code_error').show().delay(2000).fadeOut('show');
            $("#frequency_summary_promo_code_success").html("");
        }else if (result === 'invalid_date') {
            $("#frequency_summary_promo_code_error").html("Coupon Code Expired.");
            $('#frequency_summary_promo_code_error').show().delay(2000).fadeOut('show');
            $("#frequency_summary_promo_code_success").html("");
         } else if (result === 'invalid_user_count') {
            $("#frequency_summary_promo_code_error").html("Coupon Code Expired.");
            $('#frequency_summary_promo_code_error').show().delay(2000).fadeOut('show');
            $("#frequency_summary_promo_code_success").html("");
        } else if (result === 'success') {
            $("#frequency_summary_promo_code_error").html("");
            $("#frequency_summary_promo_code_success").html("Coupon Code Applied Successfully.");
            $('#frequency_summary_promo_code_success').show().delay(2000).fadeOut('show');
        
            if ($(window).width() >= 768) {
                // $("#coupan_refresh_id").load(location.href + " #coupan_refresh_id");    
                    $("#coupan_refresh_id").load(location.href + " #coupan_refresh_id", function () {
                    var coupan_apply_wallet_data = $('#coupan_data_element').val();
                    // alert(coupan_apply_wallet_data);
                    
                    coupan_apply_wallet_data = JSON.parse(coupan_apply_wallet_data);
                    // console.log(coupan_apply_wallet_data.coupan_apply_wallet);
                    if (coupan_apply_wallet_data.coupan_apply_wallet == 1) {
                            setTimeout(() => {
                            get_hide_show(5); // Replace page reload with this function
                            calculation_book_now('5');
                        }, 2000);
                        $('#coupan_refresh_id').show();
                        $('.last_summary_session_div').show();
                        $('.home_cleaning_session_div').css('display', 'block');
                        $('.mobile_home_cleaning_session_div').css('display', 'block');
                        $('.last_summary_session_home_cleaning_div').css('display', 'block');
                       
                    } else {
                        $('#coupan_refresh_id').show();
                        $('.last_summary_session_div').show();
                        $('.home_cleaning_session_div').css('display', 'block');
                        $('.mobile_home_cleaning_session_div').css('display', 'block');
                        $('.last_summary_session_home_cleaning_div').css('display', 'block');
                        alert("Congratulations! The coupon amount will be added to your wallet after this order.");
                        calculation_book_now('5');
                    }
                 });
                } else{
                    setTimeout(() => {
                        get_hide_show(5); // Replace page reload with this function
                        calculation_book_now('5');
                    }, 2000);
                    $("#mobile_coupan_refresh_id").load(location.href + " #mobile_coupan_refresh_id", function () {

                    var coupan_apply_wallet_data = $('#mobile_coupan_data_element').val();
                    coupan_apply_wallet_data = JSON.parse(coupan_apply_wallet_data);

                    if (coupan_apply_wallet_data.coupan_apply_wallet == 1) {
                        $('#coupan_refresh_id').show();
                        $('.last_summary_session_div').show();
                        $('.home_cleaning_session_div').css('display', 'block');
                        $('.mobile_home_cleaning_session_div').css('display', 'block');
                        $('.last_summary_session_home_cleaning_div').css('display', 'block');
                       
                    } else {
                        $('#coupan_refresh_id').show();
                        $('.last_summary_session_div').show();
                        $('.home_cleaning_session_div').css('display', 'block');
                        $('.mobile_home_cleaning_session_div').css('display', 'block');
                        $('.last_summary_session_home_cleaning_div').css('display', 'block');
                        alert("Congratulations! The coupon amount will be added to your wallet after this order.");
                        calculation_book_now('5');
                    }
                 });
                }
                }
                else if (result === 'grater') {
                $("#frequency_summary_promo_code_error").html("Coupon Code Value Greater Than Your Total.");
                $('#frequency_summary_promo_code_error').show().delay(2000).fadeOut('show');
                } 
                else {
                $("#frequency_summary_promo_code_error").html(`
    Minimum order amount should be 
    <img class="dhiram"
         src="{{ asset('public/site/images/automobile/DirhamBlack.png') }}"
         alt="Dirham Icon">
    ${result}
`);
                $('#frequency_summary_promo_code_error').show().delay(2000).fadeOut('show');
            }
        }
    });
    }

function last_summary_remove_coupon(){

var answer = window.confirm("Do you want to remove this Coupon Code?");
if (answer) {

    var url = '{{ url('last_summary_remove_coupon') }}';
    $.ajax({

        type : 'POST',
        url : url,
        data :{'_token': '{{ csrf_token() }}'},

        success : function(msg){
            setTimeout(() => {
                    get_hide_show(5); // Replace page reload with this function
                    calculation_book_now('5');
                }, 2000);

                if ($("#coupan_refresh_id").length > 0) {
                    // Refresh the desktop div
                    $("#coupan_refresh_id").load(location.href + " #coupan_refresh_id");
                    $(".last_summary_session_div").load(location.href + " .last_summary_session_div");
                    $('#coupan_refresh_id').hide();
                    $('.last_summary_session_div').hide();
                }
                if ($("#mobile_coupan_refresh_id").length > 0) {
                    // Refresh the mobile div (use the correct mobile-specific ID)
                    $("#mobile_coupan_refresh_id").load(location.href + " #mobile_coupan_refresh_id");
                    $(".mobile_last_summary_session_div").load(location.href + " .mobile_last_summary_session_div");
                    $('#coupan_refresh_id').hide();
                    $('.last_summary_session_div').hide();
                }

        }

    });

}
}


function apply_promo_home_cleaning(id) {
            
    var promo_code, coupan_value = 0, coupan_name = '', total_to_pay = 0;

    if(id == 0){
        // For desktop
        promo_code = $("#promo_code").val();

        //For Mobile
        var mobile_promo_code = $("#mobile_promo_code").val();
    } else {
        
        if (window.innerWidth <= 768) {
            //For Mobile
            var Coupan_new_Data =  $('#mobile_coupan_data_element').val();
        }else{
                //For Desktop
            var Coupan_new_Data = $('#coupan_data_element').val();
        }
        
        var parsedData = JSON.parse(Coupan_new_Data || '{}');

        promo_code = parsedData.coupancode || ''; 

        var promo = promo_code;


        var sub_total = $('#sub_total').val();
        var vat_total = $('#vat_total').val();

        if (parsedData && parsedData.discount !== '' && parsedData.coupanvalue == 0) {
            var coupon_discounted = Math.round((sub_total * parsedData.discount) / 100);
            if(parsedData.coupan_apply_wallet == 1){
                coupan_value = coupon_discounted;
            }else{
                coupan_value = 0;
            }
            coupan_name = parsedData.coupancode;

        }
        if (parsedData && parsedData.discount !== '' && parsedData.coupanvalue == 1) {
            var coupon_discounted = parsedData.discount;
            if(parsedData.coupan_apply_wallet == 1){
                coupan_value = coupon_discounted;
            }else{
                coupan_value = 0;
            }
            coupan_name = parsedData.coupancode;
        }

        $('#coupan_value').val(coupan_value);

        // Calculate total to pay
        total_to_pay = parseFloat(sub_total) + parseFloat(vat_total) - parseFloat(coupan_value);

        $('#total_to_pay').val(total_to_pay);
        //For Desktop Replces
        $('#promo_code_name_replace_home').html(coupan_name);
        $('#frequency_summary_promo_code_replace').html(coupan_value);
        $('#frequency_summary_promo_code_name_replace').html(coupan_name);
        $('#frequency_summary_total_to_pay').html(total_to_pay);


        //For Mobile Repleces
        $('#mobile_promo_code_name_replace').html(coupan_name);
        $('#mobile_promo_code_replace').html(coupan_value);
        $('#sub_total_replace_mobile').html(sub_total);
        $('#total_to_pay_charge_replace_mobile').html(total_to_pay);
        
    }


    // Determine if the user is on mobile or desktop
    var isMobile = $(window).width() <= 768; // Assuming width <= 768px is mobile

    // Use the appropriate promo code based on the device
    var promo = isMobile ? mobile_promo_code : promo_code;

    var sub_total = $('#sub_total').val();
    var sub_service = $('#subservice_id').val();
    var service = $('#service_id').val();

      

    // Input validation
    if (promo === '') {
        if (isMobile) {
            $("#mobile_promo_code_error").html("Enter Coupon Code.");
            $('#mobile_promo_code_error').show().delay(2000).fadeOut('show');
            $("#mobile_promo_code_success").html("");
        } else {
            $("#promo_code_error").html("Enter Coupon Code.");
            $('#promo_code_error').show().delay(2000).fadeOut('show');
            $("#promo_code_success").html("");
        }
        return false;
    }

    // AJAX Request to validate promo code
    var url = '{{ url('promo_codecheck_home_cleaning') }}';
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            '_token': '{{ csrf_token() }}',
            'promo': promo,
            'sub_total': sub_total,
            'sub_service': sub_service,
            'service': service,
        },
        success: function(result) {
            console.log(result);
            
            // Handle response
            if (result === 'invalid') {
                if (isMobile) {
                    $("#mobile_promo_code_error").html("Invalid Coupon Code.");
                    $('#mobile_promo_code_error').show().delay(2000).fadeOut('show');
                    $("#mobile_promo_code_success").html("");
                } else {
                    $("#promo_code_error").html("Invalid Coupon Code.");
                    $('#promo_code_error').show().delay(2000).fadeOut('show');
                    $("#promo_code_success").html("");
                }
            } else if (result === 'invalid_date') {
                if (isMobile) {
                    $("#mobile_promo_code_error").html("Coupon Code Expired.");
                    $('#mobile_promo_code_error').show().delay(2000).fadeOut('show');
                    $("#mobile_promo_code_success").html("");
                } else {
                    $("#promo_code_error").html("Coupon Code Expired.");
                    $('#promo_code_error').show().delay(2000).fadeOut('show');
                    $("#promo_code_success").html("");
                }
            }else if (result === 'invalid_user_count') {
                if (isMobile) {
                    $("#mobile_promo_code_error").html("Coupon Code Expired.");
                    $('#mobile_promo_code_error').show().delay(2000).fadeOut('show');
                    $("#mobile_promo_code_success").html("");
                } else {
                    $("#promo_code_error").html("Coupon Code Expired.");
                    $('#promo_code_error').show().delay(2000).fadeOut('show');
                    $("#promo_code_success").html("");
                }
            }else if (result === 'Already') {
                if (isMobile) {
                    $("#mobile_promo_code_error").html("Coupon Code is Already Applied.");
                    $('#mobile_promo_code_error').show().delay(2000).fadeOut('show');
                    $("#mobile_promo_code_success").html("");
                } else {
                    $("#promo_code_error").html("Coupon Code is Already Applied.");
                    $('#promo_code_error').show().delay(2000).fadeOut('show');
                    $("#promo_code_success").html("");
                }
            } else if (result === 'success') {
                
                $("#home_cleaning_left_value").val('1');
               
                if (isMobile) {
                    // alert('here');
                    $("#mobile_promo_code_error").html("");
                    $("#mobile_promo_code_success").html("Coupon Code Applied Successfully.");
                    $('#mobile_promo_code_success').show().delay(2000).fadeOut('show');


                    $("#mobile_coupan_refresh_id").load(location.href + " #mobile_coupan_refresh_id", function () {
                    var coupan_apply_wallet_data = $('#mobile_coupan_data_element').val();

                    // Ensure that the data is parsed correctly
                    coupan_apply_wallet_data = JSON.parse(coupan_apply_wallet_data);

                    if (coupan_apply_wallet_data.coupan_apply_wallet == 1) {
                        $('#mobile_coupan_refresh_id').show();
                        $('.home_cleaning_session_div').css('display', 'block');
                        $('.mobile_home_cleaning_session_div').css('display', 'block');
                        $('.last_summary_session_home_cleaning_div').css('display', 'block');

                        setTimeout(() => {
                            if (id == 0) {
                                get_hide_show(1);
                                calculation();
                            }
                        }, 2000);
                    } else {
                        $('#mobile_coupan_refresh_id').hide();
                        $('.home_cleaning_session_div').css('display', 'block');
                        $('.mobile_home_cleaning_session_div').css('display', 'block');
                        $('.last_summary_session_home_cleaning_div').css('display', 'block');
                        setTimeout(() => {
                            if (id == 0) {
                                get_hide_show(1);
                                calculation();
                            }
                        }, 2000);
                        alert("Congratulations! The coupon amount will be added to your wallet after this order.");
                    }
                 });
                    } else {
                        $("#promo_code_error").html("");
                        $("#promo_code_success").html("Coupon Code Applied Successfully.");
                        $('#promo_code_success').show().delay(2000).fadeOut('show');

                        $("#coupan_refresh_id").load(location.href + " #coupan_refresh_id", function () {
                            var coupan_apply_wallet_data = $('#coupan_data_element').val();

                            // Ensure that the data is parsed correctly
                            coupan_apply_wallet_data = JSON.parse(coupan_apply_wallet_data);

                            // console.log("Updated Coupon Data:", coupan_apply_wallet_data);

                            if (coupan_apply_wallet_data.coupan_apply_wallet == 1) {
                                $('#coupan_refresh_id').show();
                                $('.home_cleaning_session_div').css('display', 'block');
                                $('.mobile_home_cleaning_session_div').css('display', 'block');
                                $('.last_summary_session_home_cleaning_div').css('display', 'block');

                                setTimeout(() => {
                                    if (id == 0) {
                                        get_hide_show(1);
                                        calculation();
                                    }
                                }, 2000);
                            } else {
                                $('#coupan_refresh_id').hide();
                                $('.home_cleaning_session_div').css('display', 'block');
                                $('.mobile_home_cleaning_session_div').css('display', 'block');
                                $('.last_summary_session_home_cleaning_div').css('display', 'block');
                                setTimeout(() => {
                            if (id == 0) {
                                get_hide_show(1);
                                calculation();
                            }
                        }, 2000);
                                alert("Congratulations! The coupon amount will be added to your wallet after this order.");
                            }
                        });
                    }

              
                
                } else if (result === 'grater') {
                    if (isMobile) {
                        $("#mobile_promo_code_error").html("Coupon Code Value Greater Than Your Total.");
                        $('#mobile_promo_code_error').show().delay(2000).fadeOut('show');
                    } else {
                        $("#promo_code_error").html("Coupon Code Value Greater Than Your Total.");
                        $('#promo_code_error').show().delay(2000).fadeOut('show');
                    }
                } else {
                    if (isMobile) {
                        $("#mobile_promo_code_error").html(`
    Minimum order amount should be 
    <img class="dhiram"
         src="{{ asset('public/site/images/automobile/DirhamBlack.png') }}"
         alt="Dirham Icon">
    ${result}
`);
                        $('#mobile_promo_code_error').show().delay(2000).fadeOut('show');
                    } else {
                        $("#promo_code_error").html(`
    Minimum order amount should be 
    <img class="dhiram"
         src="{{ asset('public/site/images/automobile/DirhamBlack.png') }}"
         alt="Dirham Icon">
    ${result}
`);
                        $('#promo_code_error').show().delay(2000).fadeOut('show');
                    }
                }
        }
    });
}

function home_cleaning_remove_coupon(){

var answer = window.confirm("Do you want to remove this Coupon Code?");
if (answer) {

    var url = '{{ url('home_cleaning_remove_coupon') }}';
    $.ajax({

        type : 'POST',
        url : url,
        data :{'_token': '{{ csrf_token() }}'},

        success : function(msg){
            setTimeout(() => {
                    get_hide_show(1); // Replace page reload with this function
                    calculation();
                }, 2000);
                if ($("#coupan_refresh_id").length > 0) {
                    // Refresh the desktop div
                    $("#coupan_refresh_id").load(location.href + " #coupan_refresh_id");
                    $('#coupan_refresh_id').hide();
                    $('.home_cleaning_session_div').css('display', 'none');
                    $('.last_summary_session_home_cleaning_div').css('display', 'none');
                }
                if ($("#mobile_coupan_refresh_id").length > 0) {
                    // Refresh the mobile div (use the correct mobile-specific ID)
                    $("#mobile_coupan_refresh_id").load(location.href + " #mobile_coupan_refresh_id");
                    $('#mobile_coupan_refresh_id').hide();
                    $('.mobile_home_cleaning_session_div').css('display', 'none');
                    $('.last_summary_session_home_cleaning_div').css('display', 'none');
                }
            
            
        }

    });

}
}



function last_summary_apply_promo_home_cleaning() {

    // alert('here');  
    var promo_code = $("#frequency_summary_promo_code").val(); // Desktop input field

    var sub_total = $('#sub_total').val();
    var sub_service = $('#subservice_id').val();
    var service = $('#service_id').val();
    var service_fee = $('#service_fee').val();
    var promo = promo_code;

    // Input validation
    if (promo === '') {
            $("#frequency_summary_promo_code_error").html("Enter Coupon Code.");
            $('#frequency_summary_promo_code_error').show().delay(2000).fadeOut('show');
            $("#frequency_summary_promo_code_success").html("");
        return false;
    }

    // AJAX Request to validate promo code
    var url = '{{ url('lat_summary_home_cleaning_promo_codecheck') }}';
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            '_token': '{{ csrf_token() }}',
            'promo': promo,
            'sub_total': sub_total,
            'sub_service': sub_service,
            'service': service,
            'service_fee': service_fee,
        },
        success: function(result) {
            console.log(result);

            // Handle response
            if (result === 'invalid') {
                $("#frequency_summary_promo_code_error").html("Invalid Coupon Code.");
                $('#frequency_summary_promo_code_error').show().delay(2000).fadeOut('show');
                $("#frequency_summary_promo_code_success").html("");
            } else if (result === 'invalid_date') {
                $("#frequency_summary_promo_code_error").html("Coupon Code Expired.");
                $('#frequency_summary_promo_code_error').show().delay(2000).fadeOut('show');
                $("#frequency_summary_promo_code_success").html("");
            }else if (result === 'invalid_user_count') {
                $("#frequency_summary_promo_code_error").html("Coupon Code Expired.");
                $('#frequency_summary_promo_code_error').show().delay(2000).fadeOut('show');
                $("#frequency_summary_promo_code_success").html("");
            } else if (result === 'Already') {
                $("#frequency_summary_promo_code_error").html("Coupon Code is Already Applied.");
                $('#frequency_summary_promo_code_error').show().delay(2000).fadeOut('show');
                $("#frequency_summary_promo_code_success").html("");
            } else if (result === 'success') {

                // alert('here too');

                $('#home_cleaning_left_value').val('2');
                $("#frequency_summary_promo_code_error").html("");
                $("#frequency_summary_promo_code_success").html("Coupon Code Applied Successfully.");
                $('#frequency_summary_promo_code_success').show().delay(2000).fadeOut('show');
               
                if ($(window).width() >= 768) {
                    $("#coupan_refresh_id").load(location.href + " #coupan_refresh_id", function () {
                    var coupan_apply_wallet_data = $('#coupan_data_element').val();
                    coupan_apply_wallet_data = JSON.parse(coupan_apply_wallet_data);

                    if (coupan_apply_wallet_data.coupan_apply_wallet == 1) {
                        $('#coupan_refresh_id').show();
                        $('.last_summary_session_home_cleaning_div').css('display', 'block');
                        setTimeout(() => {
                            get_hide_show(5); 
                            calculation();
                        }, 2000);
                    } else {

                        $('#mobile_coupan_refresh_id').hide();
                        $('.last_summary_session_home_cleaning_div').css('display', 'block');
                        setTimeout(() => {
                            get_hide_show(5);
                            calculation();
                        }, 2000);
                        alert("Congratulations! The coupon amount will be added to your wallet after this order.");
                    }
                 });
                }else {
                   
                    $("#mobile_coupan_refresh_id").load(location.href + " #mobile_coupan_refresh_id", function () {
                    var coupan_apply_wallet_data = $('#mobile_coupan_data_element').val();
                    coupan_apply_wallet_data = JSON.parse(coupan_apply_wallet_data);

                    if (coupan_apply_wallet_data.coupan_apply_wallet == 1) {
                        $('#mobile_coupan_refresh_id').show();
                        $('.home_cleaning_session_div').css('display', 'block');
                        $('.mobile_home_cleaning_session_div').css('display', 'block');
                        $('.last_summary_session_home_cleaning_div').css('display', 'block');
                        setTimeout(() => {
                            get_hide_show(5); 
                            calculation();
                        }, 2000);
                    } else {
                        $('#mobile_coupan_refresh_id').hide();
                        $('.last_summary_session_home_cleaning_div').css('display', 'none');
                        setTimeout(() => {
                            get_hide_show(5);
                        }, 2000);
                        alert("Congratulations! The coupon amount will be added to your wallet after this order.");
                    }
                 });
                }
                
                }
                else if (result === 'grater') {
                $("#frequency_summary_promo_code_error").html("Coupon Code Value Greater Than Your Total.");
                $('#frequency_summary_promo_code_error').show().delay(2000).fadeOut('show');
                } 
                else {
                $("#frequency_summary_promo_code_error").html(`
    Minimum order amount should be 
    <img class="dhiram"
         src="{{ asset('public/site/images/automobile/DirhamBlack.png') }}"
         alt="Dirham Icon">
    ${result}
`);
                $('#frequency_summary_promo_code_error').show().delay(2000).fadeOut('show');
            }
        }
    });
}
function last_summary_home_cleaning_remove_coupon(){

var answer = window.confirm("Do you want to remove this Coupon Code?");
if (answer) {

    var url = '{{ url('last_summary_home_cleaning_remove_coupon') }}';
    $.ajax({

        type : 'POST',
        url : url,
        data :{'_token': '{{ csrf_token() }}'},

        success : function(msg){
            setTimeout(() => {
                    get_hide_show(5); // Replace page reload with this function
                    calculation();
                }, 2000);
                if ($("#coupan_refresh_id").length > 0) {
                    // Refresh the desktop div
                    $("#coupan_refresh_id").load(location.href + " #coupan_refresh_id");
                    $('#coupan_refresh_id').hide();
                    $('.home_cleaning_session_div').css('display', 'none');
                    $('.last_summary_session_home_cleaning_div').css('display', 'none');
                }
                if ($("#mobile_coupan_refresh_id").length > 0) {
                    // Refresh the mobile div (use the correct mobile-specific ID)
                    $("#mobile_coupan_refresh_id").load(location.href + " #mobile_coupan_refresh_id");
                    $('#mobile_coupan_refresh_id').hide();
                    $('.mobile_home_cleaning_session_div').css('display', 'none');
                    $('.last_summary_session_home_cleaning_div').css('display', 'none');
                }
            
            
        }

    });

}

}




</script>

<script>
    window.onload = function() {
        history.scrollRestoration = "manual";
        window.scrollTo(0, 0);
        get_hide_show(1);

        @php
            if ($subservice_id == 30 || $subservice_id == 28) {
                // Session::forget('coupan_data');
        @endphp
                calculation();
                document.getElementById('coupan_refresh_id').style.display = 'none';
                document.querySelector('.home_cleaning_session_div').style.display = 'none';
                document.querySelector('.mobile_home_cleaning_session_div').style.display = 'none';
                document.querySelector('.last_summary_session_home_cleaning_div').style.display = 'none';
        @php
            } elseif ($subservice_id == 29 || $subservice_id == 70 || $subservice_id == 71 || 
                        $subservice_id == 72|| $subservice_id == 73 || $subservice_id == 79 || 
                        $subservice_id == 80 || $subservice_id == 81 || $subservice_id == 82 || 
                        $subservice_id == 83 || $subservice_id == 84 || $subservice_id == 85 || 
                        $subservice_id == 86 || $subservice_id == 87 || $subservice_id == 88 || $subservice_id == 52 || $subservice_id == 93) {
        @endphp
                calculation_book_now(0);
        @php
            }
        @endphp
    };


    $(document).on('click', '.add-to-cart-btn-book', function(e) {
        e.preventDefault();

        let button = $(this);
        let packageId = button.data('package-id');
        let qty = button.data('qty');

        button.prop('disabled', true).text('Adding...');

        $.ajax({
            
            type: 'POST',
            url: '{{ url('add_to_cart_book') }}',
            data: {
                package_id: packageId,
                qty: qty,
                "_token": "{{ csrf_token() }}",
            },
            success: function(msg) {
                // ✅ Update subtotal
                if (msg != 0) {

                    // Update cart subtotal or other elements if needed
                $('#cart_subtotal_hidden').val(msg.subtotal);
                
                    $('#package_' + packageId).html(`
                    <div class="quantity">
                        <div class="quantity-block">
                            <button type="button" id="minus_${msg.rowId}" class="quantity-arrow-minus"
                                    onclick="minus_qty_book_now('${msg.rowId}', '${qty}');">
                                <span class="fa fa-minus"></span>
                            </button>
                            <input id="input_${msg.rowId}" class="quantity-num-one qty_input_book_now_${msg.rowId}"
                                   type="text" value="${qty}" readonly/>
                            <button type="button" id="plus_${msg.rowId}" class="quantity-arrow-plus"
                                    onclick="plus_qty_book_now('${msg.rowId}');">
                                <span class="fas fa-plus"></span>
                            </button>
                        </div>
                    </div>
                `);

                

                let displayPrice = msg.desc_price != 0 ? msg.desc_price : msg.price;

                // Optionally update the cart summary UI
               $('#cart_item_list').append(`
    <div class="d-flex justify-content-between">
        <div>
            ${msg.name} * ${msg.qty}
            <a href="javascript:void(0)"
               onclick="remove_to_cart_book_now('${msg.rowId}'); return false;">
                <span class="flaticon-delete"></span>
            </a>
        </div>
        <div class="font-weight-bold sm-summary">
            <img class="dhiram"
                 src="{{ asset('public/site/images/automobile/DirhamBlack.png') }}"
                 alt="Dirham Icon">
            ${displayPrice}
        </div>
    </div>
`);
                }

                $(".hidden_refresh_cart").load(location.href + " .hidden_refresh_cart", function () {
                    calculation_book_now('0');
                });
            },
            error: function(xhr) {
                alert("Something went wrong!");
            },
            complete: function() {
                button.prop('disabled', false).text('Add to Cart');
            }
        });
    });
	
	document.addEventListener('DOMContentLoaded', function () {
        new Splide('#how_many_hours_need_cleaner_slider_spatie', {
            type: 'slide',
            perPage: 6,
            gap: '1rem',
            autoplay: false,
            interval: 3000,
            pagination: false,
            arrows: false,
			fixedWidth: '10%',
            breakpoints: {
			768: {
               fixedWidth: '17%',   // Each slide takes 80% of container
                    focus: 0,            // Start slide aligned left
                    gap: '0.8rem',
                    arrows: true,
            },
            },
        }).mount();
        });

	document.addEventListener('DOMContentLoaded', function () {
    new Splide('#how_many_cleaner_require_slider_spatie', {
        type: 'slide',
        perPage: 6,
        gap: '1rem',
        autoplay: false,
        pagination: false,
        arrows: false, 
        fixedWidth: '10%',
        breakpoints: {
            768: {
                fixedWidth: '17%',
                gap: '0.8rem',
                perPage: 3,
                arrows: true,
            },
        },
    }).mount();
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

/*  $(function() {
        var cols = $('.wrap .column');
        var enabled = true;
        var scrollbalance = new ScrollBalance(cols, {
        minwidth: 1199
    });
    bind to scroll and resize events
    scrollbalance.bind();
    }); */


$(function () {
    var footer = $('.footer-style1');
    var sidebar = $('.wrap .right_column');
    var sidebarInitialTop = sidebar.offset().top;
    var sidebarInitialWidth = sidebar.outerWidth(); // Save original width
    var sidebarHeight = sidebar.outerHeight(true);

    $(window).on('scroll resize', function () {
        var scrollTop = $(window).scrollTop();
        var windowHeight = $(window).height();
        var footerTop = footer.offset().top;
        var sidebarBottom = scrollTop + sidebarHeight + 300; // 150 is top offset

        if (scrollTop + 300 > sidebarInitialTop) {
            // If bottom of sidebar goes beyond footer top, stop it
            if (sidebarBottom >= footerTop) {
                var offset = footerTop - sidebarHeight - 120; // 20px before footer
                sidebar.css({
                    position: 'absolute',
                    top: offset + 'px',
                    bottom: 'auto',
                    width: sidebarInitialWidth + 'px'
                });
            } else {
                // Sidebar scrolls normally and stays fixed
                sidebar.css({
                    position: 'fixed',
                    top: '120px',
                    bottom: 'auto',
                    width: sidebarInitialWidth + 'px'
                });
            }
        } else {
            // Reset to original position and styling
            sidebar.css({
                position: 'static',
                top: '',
                bottom: '',
                width: ''
            });
        }
    });

    // Recalculate width on window resize
    $(window).on('resize', function () {
        sidebarInitialWidth = sidebar.parent().width();
        sidebar.css('width', sidebarInitialWidth + 'px');
    });
});




</script>




    

