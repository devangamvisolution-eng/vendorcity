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
	
        <!-- start section -->
        <!--<section class="wow animate__fadeIn">
            <div class="container">
                <h1 style="text-align:center;"><?php echo $message; ?></h1>
            </div>
        </section>-->

        @php
        $userdata = session('user');

        $payment_mode = session('order_payment_mode');

        if($payment_mode == 1){
            $text = "Your payment needs to be processed before our crew reaches the location.";
        }else{
            $text = "Your payment has been successfully processed.";
        }
    @endphp
	
		<section class="wow animate__fadeIn pt40 mt120">
            <div class="container text-center">
			<div class="step-counter" style="background-color: #685F5E;color: #fff;border-radius: 50%;position: relative;z-index: 5;display: flex;justify-content: center;align-items: center;width: 80px;height: 80px;margin: 0 auto;border-radius: 50%;">
			<i class="fa-solid fa-check" style="font-size: 40px;margin: 0 0 3px 4px;"></i>
						</div>
                <h2 style="color: #0040E6;">Thank you for choosing VendorsCity!</h2>
				<p class="textp">Hi {{ $userdata['name'] }}, we have received your booking </p>
                    {{-- for the follwing service:</p> --}}
				<p class="textp">
                    {{-- <b>Appartment Villa</b><br> --}}
                    Order Number : {{ session('format_order_id') }}<br></p>
				<div class="container stepper-wrapper mobile-view-images" style="width: 60%;">
					  <div class="stepper-item completed">
						<div class="step-counter" style="background-color: #0040E6;color: #fff;"><i class="fa-solid fa-pen-to-square" style="font-size: 35px;margin: 0 0 3px 4px;font-weight: 500;"></i>
						</div>
						<div class="step-name">Booking Received</div>
					  </div>
					  <div class="stepper-item completed">
						<div class="step-counter" style="background-color: #FFD312;color: #fff;">
						<i class="fa-regular fa-user" style="font-size: 35px;font-weight: 500;"></i>
						</div>
						<div class="step-name">Vendor Assigned</div>
					  </div>
					  <div class="stepper-item">
						<div class="step-counter" style="background-color: #FFD312;color: #fff;">
						<i class="fa-regular fa-credit-card" style="font-size: 35px;font-weight: 500;"></i>
						</div>
						<div class="step-name">Payment</div>
					  </div>
					  <div class="stepper-item">
						<div class="step-counter" style="background-color: #FFD312;color: #fff;">
						<i class="fa-solid fa-truck" style="font-size: 35px;margin: 0 0 3px 4px;font-weight: 500;"></i>
						</div>
						<div class="step-name">Receive your Service</div>
					  </div>
				</div>	
				
				<!--<div><img class="bdrs20" src="{{ asset('public/site/images/order_process.png') }}" alt=""></div>-->
				<!--<div><img class="bdrs20" src="{{ asset('public/site/images/quote-process.png') }}" alt=""></div>-->
				<p class="textp pt20"><b>{{ $text }}</b></p>
				<p class="textp">You will receive a detailed invoice on your email address shared.<br>Accepted payment methods include cash, credit card, and debit card.</p>
				<p class="textp pt20"><b>Next Steps:</b></p>
				<p class="textp">We will assign a vendor to your service request shortly. They will contact you to <br>confirm the details and make any necessary arrangements.</p>
				<p class="textp">Once confirmed, ensure that you are at the specified time and location to <br>receive your service.</p>
            </div>
        </section>
		
        <!-- end section -->
@include('front.includes.footer')