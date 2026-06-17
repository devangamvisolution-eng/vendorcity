@include('front.includes.header')
<style>
    .main-title {
        margin-bottom: 30px;
    }
	section {
    padding: 80px 0;
    position: relative;
	}
	
	 .vendorTopContent {
        margin-bottom: 50px;
    }

    .vendorTopContent img {
        width: 190px;
        margin-bottom: 20px;
    }

    .vendorTopContent h3 {
        font-size: 22px;
    }
    @media only screen and (max-width: 600px) {
      .breadcumb-section {
          padding: 20px 15px;
      }
    }


</style>
<section class="breadcumb-section pt-4 container mt120">
<div>
    <div class="container cta-service-v3 cta-banner mx-auto maxw1700 pt120 pb120 position-relative overflow-hidden d-flex align-items-center px30-lg" style="background-image: linear-gradient(to right, #0040E6, #FFD312); height: 220px; border-radius: 20px;">
        
        <!--<img class="service-v3-vector d-none d-lg-block" src="{{ asset('public/site/images/test_new.jpg') }}"
            alt="Customer service experience with Vendorscity UAE">-->
        
            <div class="row wow fadeInUp container">
                <div class="col-xl-12">
                    <div class="position-relative">
                        <h1 class=" banner_title" style="color: #fff;" >About Us</h1>
                        <!-- <p class="text mb30 text-white">Give your visitor a smooth online experience with a solid UX design</p> -->
                        <!--<div class="d-flex align-items-center">
							<h6 class="mb-0" style="color: #fff;" >Use Code MoveitMoveit</h6>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
	<div class="container">
        <div class="row align-items-center container">
          <div class="col-md-5 col-xl-12">
            <div class="position-relative wow fadeInLeft" data-wow-delay="300ms">
              <h2 class="mt25 text-center">About Us</h2>
              <p class="text mb25">Welcome to VendorsCity, your one-stop destination for all home service needs across the UAE. Founded with a vision to simplify your life, we are committed to connecting you with the best service providers in the industry, ensuring quality, reliability, and convenience.</p>
            </div>
          </div>
        </div>
      </div>
	<section class="our-about pb0 pt60-lg">
      <div class="container">
        <div class="row container">
	
          <div class="col-md-5 col-xl-6">
            <div class="position-relative wow fadeInLeft" data-wow-delay="300ms">
              <h2 class="mb25">Our Mission</h2>
              <p class="text mb25">At VendorsCity, our mission is to make life easier for our customers by providing seamless access to a wide range of home services. From cleaning and maintenance to health and fitness, we aim to deliver top-notch solutions that save you time and effort, allowing you to focus on what truly matters.</p>
              
            </div>
          </div>
          <div class="col-md-5 col-xl-6">
            <div class="position-relative wow fadeInLeft" data-wow-delay="300ms">
              <h2 class="mb25">Our Vision</h2>
              <p class="text mb25">We envision a world where everyone can enjoy more leisure and family time, free from the hassle of household chores and maintenance. By continuously expanding our network of trusted service providers, we strive to become the leading platform for home services in the UAE, setting new standards for quality and customer satisfaction.</p>
              
            </div>
          </div>
	
        </div>
      </div>
    </section>
	
	<section class="p-0 container">
      <div class="cta-banner mx-auto maxw1600 pt80 pt60-lg pb40 pb60-lg position-relative overflow-hidden mx20-lg">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-xl-5 pl30-md pl15-xs wow fadeInRight" data-wow-delay="500ms">
              <div class="mb30">
                <div class="main-title">
                  <h2 class="title">Our Values</h2>
                </div>
              </div>
              <div class="why-chose-list">
                <div class="list-one d-flex align-items-start mb30">
                  <span class="list-icon flex-shrink-0 flaticon-badge"></span>
                  <div class="list-content flex-grow-1 ml20">
                    <h4 class="mb-1">Quality</h4>
                    <p class="text mb-0 fz15">We partner with only the most reliable and skilled service providers to ensure exceptional service delivery.</p>
                  </div>
                </div>
                <div class="list-one d-flex align-items-start mb30">
                  <span class="list-icon flex-shrink-0 flaticon-money"></span>
                  <div class="list-content flex-grow-1 ml20">
                    <h4 class="mb-1">Trust</h4>
                    <p class="text mb-0 fz15">Your trust is our top priority. We rigorously vet our vendors to guarantee safety and professionalism.</p>
                  </div>
                </div>
                <div class="list-one d-flex align-items-start mb30">
                  <span class="list-icon flex-shrink-0 flaticon-security"></span>
                  <div class="list-content flex-grow-1 ml20">
                    <h4 class="mb-1">Convenience</h4>
                    <p class="text mb-0 fz15">Our platform is designed for ease of use, allowing you to book services quickly and effortlessly.</p>
                  </div>
                </div>
				<div class="list-one d-flex align-items-start mb30">
                  <span class="list-icon flex-shrink-0 flaticon-star"></span>
                  <div class="list-content flex-grow-1 ml20">
                    <h4 class="mb-1">Customer Satisfaction</h4>
                    <p class="text mb-0 fz15">Your happiness is our success. We are dedicated to providing excellent customer service and support.</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-6 offset-xl-1 wow fadeInLeft" data-wow-delay="500ms">
              <div class="about-img"><img class="w100" src="{{ asset('public/site/images/about/our_values.png') }}" alt="Our values – Vendorscity professional service platform"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
	<section class="container pb40">
      <div class="container wow fadeInUp">
        <div class="row">
          <div class="col-lg-12">
            <div class="main-title text-center">
              <h2>Our Services</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 col-lg-3">
            <div class="iconbox-style1 border-less p-0 text-center">
              <div class="icon before-none"><img class="w100" src="{{ asset('public/site/images/about/cleaning.png') }}" alt="Professional cleaning services – Vendorscity"></div>
              <div class="details">
                <h4 class="title mt10 mb-1">Cleaning Services</h4>
				<p class="text">Deep cleaning, regular cleaning, and specialized cleaning services.</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="iconbox-style1 border-less p-0 text-center">
              <div class="icon before-none"><img class="w100" src="{{ asset('public/site/images/about/maintenance_and_repair.png') }}" alt="Maintenance and repair services in Dubai – Vendorscity"></div>
              <div class="details">
                <h4 class="title mt10 mb-1">Maintenance & Repair</h4>
				<p class="text">Handyman services, plumbing, electrical repairs, and more.</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="iconbox-style1 border-less p-0 text-center">
              <div class="icon before-none"><img class="w100" src="{{ asset('public/site/images/about/Moving_and_Storage.png') }}" alt="Moving and storage solutions – Vendorscity"></div>
              <div class="details">
                <h4 class="title mt10 mb-1">Moving & Storage</h4>
				<p class="text">Efficient moving solutions and secure storage options.</p>
              </div>
            </div>
          </div>
		  <div class="col-sm-6 col-lg-3">
            <div class="iconbox-style1 border-less p-0 text-center">
              <div class="icon before-none"><img class="w100" src="{{ asset('public/site/images/about/health_and_fitness.png') }}" alt="Health and fitness services – Vendorscity wellness experts"></div>
              <div class="details">
                <h4 class="title mt10 mb-1">Health & Fitness</h4>
				<p class="text">Personal training, yoga instructors, and wellness services.</p>
              </div>
            </div>
          </div>
		  <div class="col-sm-6 col-lg-3">
            <div class="iconbox-style1 border-less p-0 text-center">
              <div class="icon before-none"><img class="w100" src="{{ asset('public/site/images/about/automotive.png') }}" alt="Automotive services in Dubai – Vendorscity platform"></div>
              <div class="details">
                <h4 class="title mt10 mb-1">Automotive</h4>
				<p class="text">Car repair, maintenance, and detailing services.</p>
              </div>
            </div>
          </div>
		  <div class="col-sm-6 col-lg-3">
            <div class="iconbox-style1 border-less p-0 text-center">
              <div class="icon before-none"><img class="w100" src="{{ asset('public/site/images/about/gardening.png') }}" alt="Gardening and landscaping services – Vendorscity"></div>
              <div class="details">
                <h4 class="title mt10 mb-1">Gardening</h4>
				<p class="text">Landscaping, garden maintenance, and irrigation services.</p>
              </div>
            </div>
          </div>
		  <div class="col-sm-6 col-lg-3">
            <div class="iconbox-style1 border-less p-0 text-center">
              <div class="icon before-none"><img class="w100" src="{{ asset('public/site/images/about/ac.png') }}" alt="Air conditioning repair and maintenance services – Vendorscity"></div>
              <div class="details">
                <h4 class="title mt10 mb-1">AC Services</h4>
				<p class="text">Installation, repair, and maintenance of air conditioning systems.</p>
              </div>
            </div>
          </div>
		  <div class="col-sm-6 col-lg-3">
            <div class="iconbox-style1 border-less p-0 text-center">
              <div class="icon before-none"><img class="w100" src="{{ asset('public/site/images/about/insurance.png') }}" alt="Insurance and protection with Vendorscity services"></div>
              <div class="details">
                <h4 class="title mt10 mb-1">Insurance</h4>
				<p class="text">Comprehensive insurance solutions for home and property.</p>
              </div>
            </div>
          </div>
		  <div class="col-sm-6 col-lg-3">
            <div class="iconbox-style1 border-less p-0 text-center">
              <div class="icon before-none"><img class="w100" src="{{ asset('public/site/images/about/pro.png') }}" alt="Professional service providers – Vendorscity UAE"></div>
              <div class="details">
                <h4 class="title mt10 mb-1">PRO Services</h4>
				<p class="text">Professional document processing and legal assistance.</p>
              </div>
            </div>
          </div>
		  <div class="col-sm-6 col-lg-3">
            <div class="iconbox-style1 border-less p-0 text-center">
              <div class="icon before-none"><img class="w100" src="{{ asset('public/site/images/about/media.png') }}" alt="Media and press coverage of Vendorscity"></div>
              <div class="details">
                <h4 class="title mt10 mb-1">Media Services</h4>
				<p class="text">Photography, videography, and digital marketing.</p>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </section>
	<section class="our-register container">
    <div class="container">
            <div class="row wow fadeInRight" data-wow-delay="300ms">
			<div class="main-title">
                  <h2 class="title text-center">Why Choose Us</h2>
                </div>
                <div class="mx-auto">
                      <div class="row vendorTopContent text-center">
                            <div class="col-sm-12 col-xl-3">
                                <img src="{{ asset('public/site/images/about/extensive_network.png') }}" alt="Extensive service provider network – Vendorscity">
                                <h3>Extensive Network</h3>
                                <p>Access to a wide range of trusted vendors across the UAE.</p>
                            </div>
                            <div class="col-sm-12 col-xl-3">
                                <img src="{{ asset('public/site/images/about/ease_of_booking.png') }}" alt="Ease of booking services online – Vendorscity platform">
                                <h3>Ease of Booking</h3>
                                <p>Simple and user-friendly platform for hassle-free bookings.</p>
                            </div>
                            <div class="col-sm-12 col-xl-3">
                                <img src="{{ asset('public/site/images/about/secure_payments.png') }}" alt="Secure payment system – Vendorscity platform">
                                <h3>Secure Payments</h3>
                                <p>Safe and secure payment options for peace of mind.</p>
                            </div>
							<div class="col-sm-12 col-xl-3">
                                <img src="{{ asset('public/site/images/about/customer_support.png') }}" alt="24/7 customer support by Vendorscity">
                                <h3>Customer Support</h3>
                                <p>Dedicated support team ready to assist you with any queries or issues.</p>
                            </div>
                        </div> 
                </div>
            </div>
    </div>
</section>
@include('front.includes.footer')
