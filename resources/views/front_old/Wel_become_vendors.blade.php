@include('front.includes.header')

			<section class="container wow animate__fadeIn pt40 mt120">
            <div class="container text-center">
			<div class="step-counter" style="background-color: #685F5E;color: #fff;border-radius: 50%;position: relative;z-index: 5;display: flex;justify-content: center;align-items: center;width: 80px;height: 80px;margin: 0 auto;border-radius: 50%;margin-bottom: 10px;">
			<i class="fa-solid fa-check" style="font-size: 40px;margin: 0 0 3px 4px;"></i></div>
                <h2 style="color: #0040E6;">Thank You for Your Interest in Joining VendorsCity!</h2>
				<p class="textp" style="font-size: 18px;margin-bottom: 0px;">We have received your vendor application and are thrilled that you want to partner with us.</p>
				<p class="textp" style="font-size: 18px;margin-bottom: 25px;line-height: 25px;">A VendorsCity representative will review your application and get in touch with you within <br> the next 2 business days.</p>
				<div class="container stepper-wrapper" style="width: 60%;">
					  <div class="stepper-item completed">
						<div class="step-counter" style="background-color: #0040E6;color: #fff;">
						<i class="fa-light fa-memo-pad" style="font-size: 35px;font-weight: 500;"></i>
						</div>
						<div class="step-name">Application Submitted</div>
					  </div>
					  <div class="stepper-item completed">
						<div class="step-counter" style="background-color: #FFD312;color: #fff;">
						<i class="fa-solid fa-pen-to-square" style="font-size: 35px;font-weight: 500;margin: 0 0 4px 4px;"></i>
						</div>
						<div class="step-name">Under Review</div>
					  </div>
					  <div class="stepper-item">
						<div class="step-counter" style="background-color: #FFD312;color: #fff;">
						<i class="fa-regular fa-user" style="font-size: 35px;font-weight: 500;"></i>
						</div>
						<div class="step-name">Accepted</div>
					  </div>
					  <div class="stepper-item">
						<div class="step-counter" style="background-color: #FFD312;color: #fff;">
						<i class="fa-solid fa-truck" style="font-size: 35px;margin: 0 0 0px 4px;font-weight: 500;"></i>
						</div>
						<div class="step-name">Receive Leads</div>
					  </div>
				</div>	
				
				<!--<div><img class="bdrs20" src="{{ asset('public/site/images/order_process.png') }}" alt=""></div>-->
				<!--<div><img class="bdrs20" src="{{ asset('public/site/images/quote-process.png') }}" alt=""></div>-->
				<p class="textp pt20" style="font-size: 18px;line-height: 25px;">During this time, you can prepare any additional information or documentation that may be <br>required for the onboarding process. If you have any urgent queries or if you haven't <br>heard from us after 2 business days, please don't please hesitate to reach out us at</p>
				<p class="textp" style="font-size: 18px;"><b>vendors@vendorscity.com</b></p>
				<p class="textp" style="font-size: 18px;line-height: 25px;">We appreciate your patience and look forward to starting this exciting journey together.<br>Thank you for choosing VendorsCity as your platform to showcase your services!</p>
            </div>
        </section>

@include('front.includes.footer')
