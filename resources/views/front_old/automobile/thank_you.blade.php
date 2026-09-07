@include('front.includes.header')

<style>
    .top-icon {
    border-radius: 50%;
	width: 78px;
    height: 72px;
    background-color: #000;
    }
	
	.textp {
    font-size: 18px;
    margin-bottom: 15px;
    line-height: 25px;
    }
	@media only screen and (max-width: 768px) {
		.mobile-view-images{
			width: 100% !important;
		}
	}
</style>
<style type="text/css">
    
.myaccount-tab-list {
    display: block;
    margin-right: 30px;
    border: 1px solid #EEEEEE;
}

.nav {
    
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
}


.myaccount-tab-list a {
    font-weight: 500;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    -ms-flex-pack: justify;
    justify-content: space-between;
    padding: 14px 20px;

    border-bottom: 1px solid #EEEEEE;
}


.my_purchases_box_section .my_purchases_box_inner {
    display: table;
    width: 100%;
}
.my_purchases_box_section .custom-back-g-white {
    background: #fafafa;
    padding: 40px 15px;
    margin-bottom: 30px;
}

.my_purchases_box_section .my_purchases_box_inner .purchases_top_part {
    display: table;
    width: 100%;
    padding-bottom: 30px;
    border-bottom: 1px solid #cecece;
}

.my_purchases_box_section .track_order {
    text-align: right;
}

.my_purchases_box_section .track_order a {
    text-decoration: none;
    display: inline-block;
    font-weight: 700;
    font-size: 14px;
    color: #282828;
    border: 1px solid #cecece;
    padding: 10px 20px;
    vertical-align: middle;
}


.purchases_item_box .puchases_item_inner ul.purchaseul li.purchaseli.purchaseli_mob_left {
    width: 30%;
    float: left;
}

.purchases_item_box .puchases_item_inner ul.purchaseul li.purchaseli {
    margin: 0;
    padding: 0;
    list-style: none;
    vertical-align: top;
    margin-right: 17px;
    margin-bottom: 40px;
}

.my_purchases_box_section .my_purchases_box_inner .purchases_bottom_part {
    display: table;
    width: 100%;
    padding-top: 30px;
}


/* New Css */
.card-rounded {
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .profile-img {
      width: 50px;
      height: 50px;
      background: #f0f0f0;
      border-radius: 50%;
    }
    .rating-star {
      color: #fbb034;
    }
    .status-completed {
      color: green;
      font-weight: 600;
    }

    hr {background-color: currentColor;}
.option-row {
      padding: 0 16px 12px 12px;
      /* border-bottom: 1px solid #e0e0e0; */
      display: flex;
      align-items: center;
      justify-content: space-between;
      cursor: pointer;
    }
    .option-row:hover {
      background-color: #f9f9f9;
    }
    .option-label {
      display: flex;
      align-items: center;
      font-size: 16px;
    }
    .option-label span {
      margin-right: 8px;
    font-size: 27px;
    transform: rotate(90deg);
    color: #000;
    }
    .arrow-icon {
      font-size: 18px;
    }
    .bookagain{
            margin: 0;
    color: #000000de;
    font-style: normal;
    font-weight: 400;
    line-height: 24px;
    font-size: 18px;
    letter-spacing: 0;
    }

    .text-primary{
        font-size: 22px;
    font-style: normal;
    font-weight: 700;
    letter-spacing: 0;
    line-height: 32px;
    }

    .option-row .arrow-icon::after {
  content: '\276F'; /* Unicode for › (› = U+276F = &#10147;) */
  font-size: 18px;
  display: inline-block;
}
.text-muted {
    color: #000000de !important;
    font-style: normal;
    font-weight: 400;
    line-height: 24px;
    font-size: 18px;
    letter-spacing: 0;
}

 .arrow-icongethelp::after {
  content: '\276F'; /* Unicode for › (› = U+276F = &#10147;) */
  font-size: 18px;
  display: inline-block;
}

.get-help-card a{
    padding: 0 16px !important;
}

.booking_detail{
    padding: 1rem 1.5rem;
}
.booking_detail h5{
    color: #000000de;
    font-size: 22px;
    font-style: normal;
    font-weight: 700;
    letter-spacing: 0;
    line-height: 32px;
}

.booking_detail ul li {
    align-items: center !important;
    justify-content: space-between !important;
    display: flex;
    margin-bottom: 0.75rem;
}

.booking_detail ul li strong {
    font-size: 16px;
    letter-spacing: .1px;
    font-style: normal;
    font-weight: 400;
    line-height: 24px;
    color: #00000061 !important;
}

.booking_detail .status-completed{
        font-size: 16px;
    letter-spacing: .1px;
    font-style: normal;
    font-weight: 400;
    line-height: 24px;
    color: #49a361 !important;
}

.booking_detail  .right{
    font-size: 16px;
    letter-spacing: .1px;
    color: #000000de;
    font-style: normal;
    font-weight: 400;
    line-height: 24px;
}

.booking_detail .showMore {
       font-size: 14px;
    line-height: 20px;
    font-style: normal;
    font-weight: 600;
    letter-spacing: 0;
}




.booking_detail_popup{
    
}
.booking_detail_popup.card-rounded{
    box-shadow: inherit;
}

.booking_detail_popup.card{
    border: inherit;
}

.booking_detail_popup ul li {
    align-items: center !important;
    justify-content: space-between !important;
    display: flex;
    margin-bottom: 0.75rem;
}

.booking_detail_popup ul li strong {
    font-size: 16px;
    letter-spacing: .1px;
    font-style: normal;
    font-weight: 400;
    line-height: 24px;
    color: #00000061 !important;
}


.booking_detail_popup  .right{
    font-size: 16px;
    letter-spacing: .1px;
    color: #000000de;
    font-style: normal;
    font-weight: 400;
    line-height: 24px;
}

.modal-dialog {
    max-width: 35%;
    height: auto !important;
    max-height: 70% !important;
}

.modal-content {
    border-radius: 1.3rem;
}

.closeBtn {
    background: none;
    font-size: 50px;
    color: #000;
    border: none;
    /* position: absolute; */
    right: 6px;
    top: 12px;
    margin: 0;
    padding: 0;
    width: 30px;
}

.modal-title {
    font-size: 20px;
    color: #000000;
    font-weight: bold;
}
.instruction-box {
      padding: 12px 0;
      border-radius: 8px;
      font-size: 14px;
    }

.instruction-box {
      font-size: 14px;
    }
    .instruction-box strong {
      color: #000000de;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        font-size: 18px;
        letter-spacing: 0;
        margin-left: 2%;
    }

    .instruction-box p {
          font-size: 16px;
    letter-spacing: .1px;
    color: #000000de;
    font-style: normal;
    font-weight: 400;
    line-height: 24px;
    display: -webkit-box;
    overflow: hidden;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    }

    .card-section-price-detail {
      border: 1px solid #e0e0e0;
      border-radius: 12px;
      padding: 16px;
      background-color: #fff;
      margin-top: 20px;
    }
    
    .payment-method img {
      height: 20px;
      margin-right: 4px;
    }


    .price_detail{
    padding: 1rem 1.5rem;
}
.price_detail h5{
    color: #000000de;
    font-size: 22px;
    font-style: normal;
    font-weight: 700;
    letter-spacing: 0;
    line-height: 32px;
}

.price_detail ul li {
    align-items: center !important;
    justify-content: space-between !important;
    display: flex;
    margin-bottom: 0.75rem;
}

.price_detail ul li strong {
    font-size: 16px;
    letter-spacing: .1px;
    font-style: normal;
    font-weight: 400;
    line-height: 24px;
    color: #00000061 !important;
}

.price_detail .status-completed{
        font-size: 16px;
    letter-spacing: .1px;
    font-style: normal;
    font-weight: 400;
    line-height: 24px;
    color: #49a361 !important;
}

.price_detail  .right{
    font-size: 16px;
    letter-spacing: .1px;
    color: #000000de;
    font-style: normal;
    font-weight: 400;
    line-height: 24px;
}

.receipt-link a {
      display: flex;
      justify-content: space-between;
      align-items: center;
      
    }
    .receipt-link i {
      font-size: 12px;
    }
    .receipt-icon {
      font-size: 18px;
      margin-right: 8px;
    }
    .receipt-label {
      display: flex;
      align-items: center;
      font-size: 14px;
    }

    .option-row-receipt {
     
      align-items: center;
      justify-content: space-between;
      cursor: pointer;
    }
    .option-row-receipt .option-row-receipt:hover {
      background-color: #f9f9f9;
    }
    .option-row-receipt .option-label {
      display: flex;
      align-items: center;
      font-size: 16px;
    }
    .option-row-receipt .option-label span {
      margin-right: 8px;
    font-size: 27px;
    transform: inherit;
    color: #000;
    }
    .option-row-receipt .arrow-icon {
      font-size: 18px;
    }

    .option-row-receipt .arrow-icongethelp::after {
    content: '\276F';
    font-size: 18px;
    display: inline-block;
}
.rating-card {
      border: 1px solid #e0e0e0;
      border-radius: 12px;
      background-color: #fff;
      padding: 16px;
      margin-top: 20px;
    }
    .rating-title {
          color: #000000de;
    font-size: 22px;
    font-style: normal;
    font-weight: 700;
    letter-spacing: 0;
    line-height: 32px;
    display: flex
;
    align-items: center;
    }
    .rating-title i {
      font-size: 18px;
      margin-right: 8px;
    }
    .rating-subtext {
          font-size: 16px;
    letter-spacing: .1px;
    font-style: normal;
    font-weight: 400;
    line-height: 24px;
    color: #00000061 !important;
    }
    .stars i {
      color: #fbc02d;
      font-size: 18px;
      margin-left: 2px;
    }
status-popup {
  background: white;
  border-radius: 10px;
  font-family: sans-serif;
  padding: 20px 0px;
}

.status-header {
  display: flex;
  justify-content: space-between;
  font-weight: bold;
  font-size: 16px;
  margin-bottom: 20px;
}

.close-btn {
  font-size: 24px;
  cursor: pointer;
}

.status-steps {
  list-style: none;
  padding: 0;
  margin: 0;
}

.status-steps li {
  display: flex;
  align-items: flex-start;
  margin-bottom: 20px;
  position: relative;
  color: #aaa;
}

.status-steps li .icon-circle {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background: #ccc !important;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  margin-right: 10px;
  flex-shrink: 0;
}

.status-steps li .status-text {
  flex-grow: 1;
}

.status-steps li .status-title {
  font-weight: bold;
  margin-bottom: 3px;
}

.status-steps li .status-desc {
  font-size: 13px;
  color: #666;
}

.status-steps li.active {
  color: #00AEEF;
}

.status-steps li.active .icon-circle {
  background: #00AEEF !important;
}

.status-steps li.active::after{
    background: #00AEEF !important;
}

.status-steps li:not(:last-child)::after {
  content: "";
  position: absolute;
  left: 14px;
  top: 30px;
  width: 2px;
  height: 40px;
  background: #ccc;
}

.status-steps li.active ~ li .icon-circle {
  background: #e0e0e0;
}
#edit_instruction_btn{
    background-color: #0040E6;
    color: #fff;
    width: 100%;
}
#whatsapp_Button{
  background-color: #0040E6;
    color: #fff;
    width: 100%;
}
.help_que_popup{
  padding: 10px !important;
}
.status-desc.hide {
    display: none;
}
.status-desc.show {
    display: block;
}
#getHelpModal .modal-content{
    padding: 20px !important;
}
.help-que-modal{
  padding: 0px 10px !important;
}
.edit-icon{
  font-weight: 300;
  font-size: 20px;
}
.white-text{
  color: #fff;
}
#cancel_order_btn.btn:hover{
 color: #fff !important;
}
#submit_order_btn.btn:hover{
  color: #fff !important;
}
 .flash-line {
    display: flex;
    gap: 10px;
  }

  .flash-item {
    display: none;
    align-items: center;
    gap: 8px;
  }

  .flash-item.active {
    display: flex;
  }

  .flash-item img {
    width: 30px;
    height: 30px;
    object-fit: contain;
  }
  .body_content{
    background-color: #fafafa;
  }
  .margin-time{
    margin-left:10px !important;
  }
</style>






 <section class="our-login mt60">

        <div class="container">
            <div class="row">
                
				
                <div class="col-lg-8 mx-auto">
				<h2 class="mb-3"> <img src="{{ asset('public/site/images/orderic.png') }}" alt="Profile Image" class="img-fluid "> Order Placed</h2>

                    <div class="card card-rounded p-3 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                    <div>
                        
						
						<span class="text-primary fw-bold">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-status="" data-bs-target="#ConfirmModal" class="text-primary showMore"  
							style="color: #0d6efd !important;">Awating Confirmation  ></a>
                        </span>
						<div class="appointment-time mb-4" style="color: #000;"> <i class="fa-regular fa-calendar"></i> {{ $order_data->month}} {{ $order_data->bookingdate}},{{ $order_data->bookingyear}}
						<i class="fa-regular fa-timer margin-time"> </i> {!! Helper::timeslotname($order_data->time_slot) !!}</div>

                        <p class="mb-1 text-muted">Thank you. We'll match you with a top-rated Professional.  </p>

                    </div>
                   
                        <div class="text-end">
                            <div class="profile-img mb-1 mx-auto">
                                <img src="{{ asset('public/site/images/confirm.png') }}" alt="Profile Image" class="img-fluid rounded-circle">
                            </div>
                        </div>
                   
                    </div>
               
                </div>
				<div class="flash-line card card-rounded p-3 mb-1 text-muted mb-4" style="background-color: #FEEDBC;">
					  <div class="flash-item active">
						<img src="{{ asset('public/site/images/t1.png') }}" alt="icon">
						<p class="mb-0" style="color: #000;">Show Kind gestures, they go a long way</p>
					  </div>
					  <div class="flash-item">
						<img src="{{ asset('public/site/images/t2.png') }}" alt="icon">
						<p class="mb-0" style="color: #000;">Share a Beverage with them</p>
					  </div>
					  <div class="flash-item">
						<img src="{{ asset('public/site/images/t3.png') }}" alt="icon">
						<p class="mb-0" style="color: #000;">Learn there name and stories</p>
					  </div>
				</div>

                <!-- Booking Details -->
                <div class="card card-rounded mb-4  booking_detail">
                   
                    <h5 class="mb-3">Booking Details</h5>
                    <ul class="list-unstyled mb-3">
                       @php
                          if($orders->order_status == "P") {
                              $statusText = "Awating Confirmation";
                              $statusColor = "";
                          } elseif($orders->order_status == "PA") {
                              $statusText = "Vendor Assigned";
                              $statusColor = "";
                          } elseif($orders->order_status == "CO") {
                              $statusText = "Completed";
                              $statusColor = "";
                          } elseif($orders->order_status == "CL") {
                              $statusText = "Cancelled";
                              $statusColor = "red";
                          }
                          else {
                            $statusText = "Unknown";
                          }
                      @endphp
                    <li><strong>Status:</strong> <span class="status-completed" style="color: #000 !important;">{{ $statusText }}</span></li>
                    <li><strong>Reference Code:</strong> <span class="right">{{ $orders->format_order_id}}</span></li>
                    <li><strong>Service:</strong> <span class="right">{!! Helper::subservicename($order_data->subservice_id)  !!}</span></li>
                    <li><strong>Date & Time:</strong> <span class="right">{{ $order_data->month}} {{ $order_data->bookingdate}} {{ $order_data->bookingyear}} , {!! Helper::timeslotname($order_data->time_slot) !!}</span></li>
                    <li><strong>Vehicle Details:</strong><span class="right">{!! Helper::vehiclename($order_data->verifybuy_vehicle)!!}, {{ $order_data->verifybuy_model }}</span></li>
                 
                    <li><strong></strong> <span class="right "><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#bookingDetailsModal" class="text-primary showMore">Show more</a> </span></li>
                    </ul>
					
                   
                    <hr>
                    <div class="option-row-receipt">
                        <a href="{{ url('/order-detail',$order_data->order_id) }}" class="d-flex align-items-center justify-content-between text-decoration-none text-muted">
                        <div class="option-label">
                        <span>
                         
                          <i class="fa-regular fa-gear edit-icon"></i>
                       </span> 
                        <p class="bookagain">Manage This Booking</p>
                        </div>
                        <div class="arrow-icongethelp"></div>
                    </a>
                    </div>
            </div>
                 
                </div>
            </div>
            
        </div>
    </section>
	
			
        <!-- end section -->
@include('front.includes.footer')

<div class="modal fade" id="bookingDetailsModal" tabindex="-1" aria-labelledby="bookingDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
    
      <div class="modal-header">
        <h5 class="modal-title" id="bookingDetailsModalLabel">Booking Details</h5>
       <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
      </div>
      <div class="modal-body">
        <div class="card card-rounded booking_detail_popup">
            <ul class="list-unstyled mb-3">

            <li><strong>Reference Code:</strong> <span class="right">{{ $orders->format_order_id}}</span></li>
            <li><strong>Service:</strong> <span class="right">{!! Helper::subservicename($order_data->subservice_id)  !!}</span></li>
			<li><strong>Vehicle Details:</strong>
                    <span class="right">
                        {!! Helper::vehiclename($order_data->verifybuy_vehicle)!!}, {{ $order_data->verifybuy_model }}
                    </span>
                </li>
    

            <li><strong>Date & Time:</strong> <span class="right">{{ $order_data->month}} {{ $order_data->bookingdate}} {{ $order_data->bookingyear}} , {!! Helper::timeslotname($order_data->time_slot) !!}</span></li>

            <li><strong>Address:</strong> <span class="right"> {{ $order_data->verifybuy_address}} </span></li>
			<li><strong>Total (Inc VAT):</strong> <span class="right"> {{ $orders->order_currency}}  {{ $orders->order_total}}</span></li>
      @php
            if($orders->paymentmode == '1'){
              $payment_mode = 'COD';
            }elseif($orders->paymentmode == '2'){
              $payment_mode = 'Online';
            }else{
              $payment_mode = ' ';
            }
        @endphp
			<li><strong>Payment Mode:</strong> <span class="right"> 
        {{ $payment_mode }}
      </span></li>

            </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ConfirmModal" tabindex="-1" aria-labelledby="ConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="ConfirmModalLabel">Learn What Is Next</h5>
        <button type="button" class="close closeBtn" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      

      <div class="modal-body">
        <div class="status-popup">
           
            <ul class="status-steps">
			
                @php
				$status = "P";
            $statusFlow = ['P', 'PA', 'OTW', 'IP', 'CO'];
            $currentStep = array_search($status, $statusFlow);
                    $steps = [
                    ['label' => 'Awating Confirmation', 'icon' => '<i class="fa-solid fa-check"></i>', 'desc' => 'Your booking is confirmed! Sit back while we get things ready.'],

                    ['label' => 'Vendor Assigned', 'icon' => '<i class="fa-solid fa-user"></i>', 'desc' => 'We’ve matched you with a trusted vendor — you’re in good hands.'],
                    ['label' => 'On the way', 'icon' => '<i class="fa-solid fa-truck"></i>', 'desc' => 'The vendor is on their way to your location. Get ready!'],
                    ['label' => 'In progress', 'icon' => '<i class="fa-solid fa-spinner"></i>', 'desc' => 'Work is currently underway. We’ll keep you posted!'],
                    ['label' => 'Completed', 'icon' => '<i class="fa-solid fa-check-circle"></i>', 'desc' => 'All done! We hope you’re satisfied with the service.'],
                    ];
                @endphp

             @foreach($steps as $index => $step)
              <li class="{{ $index <= $currentStep ? 'active' : '' }}">
                  <div class="icon-circle">{!! $step['icon'] !!}</div>
                  <div class="status-text">
                      <div class="status-title">{{ $step['label'] }}</div>

                      {{-- Only show description for the current step --}}
                      @if($step['desc'])
                          <div class="status-desc" style="{{ $index === $currentStep ? '' : 'display: none;' }}">
                              {{ $step['desc'] }}
                          </div>
                      @endif
                  </div>
              </li>
          @endforeach

            </ul>
        </div>
      </div>

    </div>
  </div>
</div>
<script>
  const items = document.querySelectorAll('.flash-item');
  let current = 0;

  setInterval(() => {
    items[current].classList.remove('active');
    current = (current + 1) % items.length;
    items[current].classList.add('active');
  }, 2000); // change sentence every 2 seconds
</script>