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
                        <h1 class=" banner_title" style="color: #fff;" >Careers</h1>
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
<section class="our-register container">
    <div class="container">
            <div class="row wow fadeInRight" data-wow-delay="300ms">
                <div class="mx-auto">
                      <div class="row vendorTopContent text-center">
                            <div class="col-sm-12 col-xl-3">
                                <img src="{{ asset('public/site/images/Careers_Working_at_VC.png') }}" alt="Careers at Vendorscity – working with a professional service platform">
                                <h3>Working at VendorsCity</h3>
                                <p>At VendorsCity, we believe in fostering a culture of innovation, collaboration, and growth. We are passionate about delivering top-notch services to our customers and creating a positive impact in the community.</p>
                            </div>
                            <div class="col-sm-12 col-xl-3">
                                <img src="{{ asset('public/site/images/Careers_Why_join_VC.png') }}" alt="Why join Vendorscity – career growth opportunities">
                                <h3>Why Join VendorsCity?</h3>
                                <p>Innovative Environment: Be part of a team that embraces creativity and encourages innovative ideas. We believe in pushing boundaries and exploring new possibilities.</p>
                            </div>
                            <div class="col-sm-12 col-xl-3">
                                <img src="{{ asset('public/site/images/Careers_Work_life_balance.png') }}" alt="Work life balance at Vendorscity careers">
                                <h3>Work-Life Balance</h3>
                                <p>We understand the importance of work-life balance and strive to create a flexible and supportive work environment where our employees can thrive both at work and in their personal lives.</p>
                            </div>
							<div class="col-sm-12 col-xl-3">
                                <img src="{{ asset('public/site/images/Careers_Growth_Opp.png') }}" alt="Career growth opportunities at Vendorscity">
                                <h3>Growth Opportunities</h3>
                                <p>We are committed to helping our employees grow both personally and professionally. With ongoing learning and development programs, you'll have the opportunity to expand your skills and advance your career.</p>
                            </div>
                        </div>

                        <div class="container row vendorTopContent text-center">
                            <div class="col-12">
                                <h3>Interested in joining VendorsCity?</h3>
                                <h4>Keep up to date with job postings or send us your CV on LinkedIn.</h4>
								<a class="ud-btn btn-thm2 add-joining" href="https://www.linkedin.com/company/vendorscity/" target="_blank" 
								style="margin: 10px;">Apply Now</a>
                                <p>Join us and let's build a brighter future together at VendorsCity.</p>
                            </div>
                        </div>  
                </div>
            </div>
    </div>
</section>
@include('front.includes.footer')
