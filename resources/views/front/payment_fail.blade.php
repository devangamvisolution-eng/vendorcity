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
			<div class="step-counter" style="background-color: #F70000;color: #fff;border-radius: 50%;position: relative;z-index: 5;display: flex;justify-content: center;align-items: center;width: 100px;height: 100px;margin: 30px auto;border-radius: 50%;">
			<i class="fa-solid fa-xmark" style="font-size: 65px;margin: 0 0 3px 4px;"></i>
			</div>
                <h2 style="color: #0040E6;">Payment Failed</h2>
				<p class="textp">Hi {{ $userdata['name'] }}, We were unable to process your payment. Please check your <br> payment details and try again.</p>
				<p class="textp">
                    if the issue  persists,contact your  bank for  <a href="{{'contact'}}">Contact Us</a>  and we will sort it out.</p>
            </div>
        </section>
		
        <!-- end section -->
@include('front.includes.footer') 