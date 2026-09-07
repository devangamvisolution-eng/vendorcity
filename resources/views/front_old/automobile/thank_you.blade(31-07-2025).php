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
	
        

       
		<section class="wow animate__fadeIn pt40 mt120">
            <div class="container text-center">
			<div class="step-counter" style="background-color: #685F5E;color: #fff;border-radius: 50%;position: relative;z-index: 5;display: flex;justify-content: center;align-items: center;width: 80px;height: 80px;margin: 0 auto;border-radius: 50%;">
			<i class="fa-solid fa-check" style="font-size: 40px;margin: 0 0 3px 4px;"></i>
						</div>
                <h2 style="color: #0040E6;">Thank you for choosing VendorsCity!</h2>
				
            </div>
        </section>
		
        <!-- end section -->
@include('front.includes.footer')