@include('front.includes.header')
<style>


.automobile_lists{
       padding-top: 70px;
}
.main-title, .main-title2 {
    position: relative;
    margin-bottom: 30px;
}
.ud-btn {
	padding: 10px 35px;
}
.ud-btnnew {
	margin-top: 20px;
}
.w30 {
    width: 30%;
}
.bgc-dark {
    background-color: #0D0D0D;
}
.bgc-incol {
    background-color: #272727;
}
.bgc-in {
    background-color: #F2F2F2;
}
.cltext {
    color: #fff !important;
}
.stepc {
    color: #0040E6;
}
.titlebg {
    background-color: #0040E6;
    padding: 2px 10px;
    border-radius: 15px;
	color: #fff;
}
.titlecolr {
    color: #0040E6;
}
.bg-color{
  background-color: #F2F2F2;
}
.freelancer-style1 {
    padding: 12px;
}
.cars-detail{
  text-align: left !important;
}
#cars-slider .splide__track {
  margin-left: -30px; 
}
.tag {
    padding: 5px 6px;
    font-size: 11px;
    line-height: 20px;
    color: #fff;
    background-color: #000;
}
@media (max-width: 768px) {
  #cars-slider .splide__track {
  margin-left: 0px; 
}
.ttsubt{
  display: inline-block;
}
    .about-img img {
        height: auto !important;
    }
}
.car-name{
  color: #000;
  font-weight:800;
}
@media (max-width: 1199.98px) {
    .car-insept {
        padding-top: 0px !important;
    }
}
.car-desc{
  font-size:13px;
}

</style>
<div class="automobile_lists">
 <section class="p-0 container">
      <div class="cta-banner mx-auto maxw1600 pt80 car-insept pb40 pb60-lg position-relative overflow-hidden mx20-lg">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-xl-5 pl30-md pl15-xs wow " data-wow-delay="500ms">
              <div class="mb30">
                <div class="main-title">
                  <h1 class="title">Car Inspections, That <span class="titlecolr"> Come </span> To <span class="titlecolr"> You</span>.</h1>
				  <p class="text mb-0 fz15"><strong>625+ Point Car Inspections Across the UAE.</strong></p>
				  <p class="text mb-0 fz15">Fast. Accurate. Professional. Done Right at Your Doorstep.</p>
                </div>
              </div>
              <div class="why-chose-list">
                <p class="text mb-0 fz15"><i class="fa-regular fa-circle-check" style="color: #0040E6;"></i> Doorstep Inspection at Seller’s Location</p>
				<p class="text mb-0 fz15"><i class="fa-regular fa-circle-check" style="color: #0040E6;"></i> 625+ Checkpoints Covered</p>
				<p class="text mb-0 fz15"><i class="fa-regular fa-circle-check" style="color: #0040E6;"></i> Photos, Videos & Diagnostic Scans Included</p>
				<p class="text mb-0 fz15"><i class="fa-regular fa-circle-check" style="color: #0040E6;"></i> AI Powered Precision</p>
				<p class="text mb-0 fz15"><i class="fa-regular fa-circle-check" style="color: #0040E6;"></i> Agency Trained Inspectors</p>
              </div>
			  <a href="{{ route('automobile.packages') }}" class="ud-btn ud-btnnew btn-thm google-button">Book Your Inspection Now</a>
			  <p>
          <i class="fa-solid fa-arrow-up-right-from-square" style="color: #0040E6;"></i> 
          <a href="{{ asset('public/site/images/automobile/360+-+Advance+Sample+Report.pdf') }}" 
            target="_blank" 
            style="text-decoration: underline;">
            View Sample Inspection Report
          </a>
        </p>

			  <p style="color: #000;font-weight: 600;">Inspections Powered By: <span><img class="w30" src="{{ asset('public/site/images/automobile/verifybuy.png') }}" alt=""></span></p>
            </div>
			
            <div class="col-md-6 col-xl-6 offset-xl-1 wow " data-wow-delay="500ms">
              <div class="about-img"><img class="w100" src="{{ asset('public/site/images/automobile/Car-min.jpg') }}" alt=""></div>
            </div>
          </div>
        </div>
      </div>
    </section>

</div>
<section class="bgc-dark pt60 pb60 pb30-md">
      <div class="container">
        <div class="row align-items-center wow">
          <div class="col-lg-12">
            <div class="main-title text-center">
              <h2 class="title cltext"><span class="titlebg">Smarter Car</span> Inspections Start Here.</h2>
              <p class="paragraph cltext">Why Thousands Across the UAE Trust Our Pre-Purchase Inspections.</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 col-xl-6">
            <div class="job-list-style1 default-box-shadow1 bdrs16  bgc-incol">
              <div class="align-items-start">
                <div class="icon d-flex align-items-center mb20">
                  <img class="wa" src="{{ asset('public/site/images/automobile/1.png') }}" alt="">
                </div>
                <div class="details ml0-xl">
                  <h5 class="cltext"><b>Spot Problems Before They Cost You</b></h5>
                  <h6 class="mb-3 cltext">Our 625+ point inspection detects hidden mechanical, electrical, and structural issues — so you don’t end up with a lemon.</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-6">
            <div class="job-list-style1 default-box-shadow1 bdrs16  bgc-incol">
              <div class="align-items-start">
                <div class="icon d-flex align-items-center mb20">
                  <img class="wa" src="{{ asset('public/site/images/automobile/2.png') }}" alt="">
                </div>
                <div class="details ml0-xl">
                  <h5 class="cltext"><b>Buy With Confidence, Not Guesswork</b></h5>
                  <h6 class="mb-3 cltext">Every inspection comes with a detailed, easy-to-read report that helps you make informed, confident purchase decisions.</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-6">
            <div class="job-list-style1 default-box-shadow1 bdrs16  bgc-incol">
              <div class="align-items-start">
                <div class="icon d-flex align-items-center mb20">
                  <img class="wa" src="{{ asset('public/site/images/automobile/3.png') }}" alt="">
                </div>
                <div class="details ml0-xl">
                  <h5 class="cltext"><b>Built for UAE Car Buyers</b></h5>
                  <h6 class="mb-3 cltext">Our inspectors understand common issues in UAE vehicles - from desert wear to flood - damage—giving you a real local advantage.</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-6">
            <div class="job-list-style1 default-box-shadow1 bdrs16  bgc-incol">
              <div class="align-items-start">
                <div class="icon d-flex align-items-center mb20">
                  <img class="wa" src="{{ asset('public/site/images/automobile/4.png') }}" alt="">
                </div>
                <div class="details ml0-xl">
                  <h5 class="cltext"><b>Smart Reports Powered by AI</b></h5>
                  <h6 class="mb-3 cltext">Our inspection reports are backed by intelligent diagnostics, ensuring you get the full picture — fast, accurate, and trustworthy.</h6>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </section>
	
	<section class="pt60 pb60 pb30-md">
      <div class="container">
        <div class="row align-items-center wow">
          <div class="col-lg-12">
            <div class="main-title text-center">
              <h2 class="title ">Get Your Car Inspected in <span class="titlebg ttsubt">4 Simple Steps.</span></h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 col-xl-6">
            <div class="job-list-style1 default-box-shadow1 bdrs16  bgc-in">
              <div class="align-items-start">
                <div class="icon d-flex align-items-center">
                  <h1 class="stepc"><b>1</b></h1>
                </div>
                <div class="details ml0-xl">
                  <h5 class=""><b>Book Online in Seconds</b></h5>
                  <h6 class="mb-3 ">Our 625+ point inspection detects hidden Choose the car, enter the location, and schedule.</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-6">
            <div class="job-list-style1 default-box-shadow1 bdrs16  bgc-in">
              <div class="align-items-start">
                <div class="icon d-flex align-items-center">
                  <h1 class="stepc"><b>2</b></h1>
                </div>
                <div class="details ml0-xl">
                  <h5 class=""><b>We Inspect at the Seller’s Location</b></h5>
                  <h6 class="mb-3 ">Our certified experts go directly to the vehicle — no need for you to be there.</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-6">
            <div class="job-list-style1 default-box-shadow1 bdrs16 bgc-in">
              <div class="align-items-start">
                <div class="icon d-flex align-items-center">
                  <h1 class="stepc"><b>3</b></h1>
                </div>
                <div class="details ml0-xl">
                  <h5 class=""><b>Receive Your Digital Report</b></h5>
                  <h6 class="mb-3 ">Within hours, you’ll get a full AI-powered report including photos, videos, and expert insights.</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-6">
            <div class="job-list-style1 default-box-shadow1 bdrs16 bgc-in">
              <div class="align-items-start">
                <div class="icon d-flex align-items-center">
                  <h1 class="stepc"><b>4</b></h1>
                </div>
                <div class="details ml0-xl">
                  <h5 class=""><b>Ask Questions, Get Answers</b></h5>
                  <h6 class="mb-3 ">Need help understanding the report? Speak to our inspection expert.</h6>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </section>
	
	<section class=" bgc-dark p-0">
      <div class="cta-banner mx-auto maxw1600 pt80 pt60-lg pb40 pb60-lg position-relative overflow-hidden mx20-lg">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-xl-5 pl30-md pl15-xs wow " data-wow-delay="500ms">
              <div class="mb30">
                <div class="main-title">
                  <h2 class="title cltext">AI + Human Expertise = Accurate, Reliable Reports</h2>
				  <p class="text mb-0 fz15 cltext">Unlike basic checklists, our inspections are powered by AI-based diagnostics and verified by experienced professionals, ensuring unmatched accuracy and clarity.</p>
                </div>
				<div class="main-title">
                  <h2 class="title cltext">On Demand Mobile- Inspections Across UAE</h2>
				  <p class="text mb-0 fz15 cltext">Whether the car is in a dealership, private seller’s home, or showroom — our experts come to you. Save time and eliminate stress.</p>
                </div>
              </div>
            </div>
			
            <div class="col-md-6 col-xl-6 offset-xl-1 wow " data-wow-delay="500ms">
              <div class="about-img"><img class="w100 bdrs30" src="{{ asset('public/site/images/automobile/van.png') }}" alt=""></div>
            </div>
          </div>
        </div>
      </div>
    </section>
	

    <section class="pb0 pt60">
      <div class="container">
        <div class="row align-items-center wow fadeInUp">
          <div class="col-lg-12">
            <div class="main-title">
              <h2 class="title text-center">Recently Inspected Cars</h2>
            </div>
          </div>
          <!-- <div class="col-lg-3">
            <div class="text-start text-lg-end mb-4 mb-lg-2">
              <a class="ud-btn2" href="page-freelancer-v1.html">All Freelancers<i class="fal fa-arrow-right-long"></i></a>
            </div>
          </div> -->
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div id="cars-slider" class="splide">
        <div class="splide__track">
        <ul class="splide__list">
        <li class="splide__slide text-center" >
        <div class="freelancer-style1 text-center bdr1 hover-box-shadow mb60 bdrs12 bg-color">
                    <div class="thumb mb25 mx-auto position-relative rounded-circle">
                      <img class="mx-auto bdrs12"  src="{{ asset('public/site/images/automobile/1.jpg   ') }}" alt="">
                    </div>
                    <div class="details cars-detail">
                      <h5 class="title mb-1 car-name">Nissan Patrol</h5>
                      <p class="mb10 car-desc">A rugged full-size SUV known for off-road prowess and spacious comfort.</p>
                      <div class="skill-tags d-flex align-items-center mb5">
                        <span class="tag"><i class="fas fa-star fz10 review-color"></i>5/5</span>
                        <span class="tag mx5">88,000 Km</span>
                        <span class="tag">Petrol</span>
                      </div>
                    </div>
                  </div>
          </li>
          <li class="splide__slide text-center">
          <div class="freelancer-style1 text-center bdr1 hover-box-shadow mb60 bdrs12 bg-color">
                    <div class="thumb mb25 mx-auto position-relative rounded-circle">
                      <img class="mx-auto bdrs12"  src="{{ asset('public/site/images/automobile/2.jpg') }}" alt="">
                    </div>
                    <div class="details cars-detail">
                      <h5 class="title mb-1 car-name">BMW X7</h5>
                      <p class="mb10 car-desc">A luxury three-row SUV combining performance, technology, and elegance.</p>
                      <div class="skill-tags d-flex align-items-center mb5">
                        <span class="tag"><i class="fas fa-star fz10 review-color"></i> 5/5</span>
                        <span class="tag mx5">54,000 Km</span>
                        <span class="tag">Petrol</span>
                      </div>
                    </div>
                  </div>
          </li>
          <li class="splide__slide text-center">
          <div class="freelancer-style1 text-center bdr1 hover-box-shadow mb60 bdrs12 bg-color">
                    <div class="thumb mb25 mx-auto position-relative rounded-circle">
                      <img class="mx-auto bdrs12"  src="{{ asset('public/site/images/automobile/3.jpg') }}" alt="">
                    </div>
                    <div class="details cars-detail">
                      <h5 class="title mb-1 car-name">Range Rover Sport</h5>
                      <p class="mb10 car-desc">A dynamic luxury SUV blending refinement with impressive off-road capability.</p>
                      <div class="skill-tags d-flex align-items-center mb5">
                        <span class="tag"><i class="fas fa-star fz10 review-color"></i> 5/5</span>
                        <span class="tag mx5">72,500 Km</span>
                        <span class="tag">Petrol</span>
                      </div>
                    </div>
                  </div>
          </li>
          <li class="splide__slide text-center">
          <div class="freelancer-style1 text-center bdr1 hover-box-shadow mb60 bdrs12 bg-color">
                  <div class="thumb mb25 mx-auto position-relative rounded-circle">
                      <img class="mx-auto bdrs12"  src="{{ asset('public/site/images/automobile/4.jpg') }}" alt="">
                    </div>
                    <div class="details cars-detail">
                      <h5 class="title mb-1 car-name">Porsche 911</h5>
                      <p class="mb10 car-desc">An iconic sports car delivering thrilling performance and timeless design.</p>
                      <div class="skill-tags d-flex align-items-center mb5">
                        <span class="tag"><i class="fas fa-star fz10 review-color"></i>5/5</span>
                        <span class="tag mx5">39,000 Km</span>
                        <span class="tag">Petrol</span>
                      </div>
                    </div>
                  </div>
          </li>
          <li class="splide__slide text-center">
          <div class="freelancer-style1 text-center bdr1 hover-box-shadow mb60 bdrs12 bg-color">
                     <div class="thumb mb25 mx-auto position-relative rounded-circle">
                      <img class="mx-auto bdrs12"  src="{{ asset('public/site/images/automobile/5.jpg') }}" alt="">
                    </div>
                    <div class="details cars-detail">
                      <h5 class="title mb-1 car-name">Mercedes G63 AMG</h5>
                      <p class="mb10 car-desc">A bold luxury SUV with immense power and unmistakable road presence.</p>
                      <div class="skill-tags d-flex align-items-center mb5">
                        <span class="tag"><i class="fas fa-star fz10 review-color"></i> 3/5</span>
                        <span class="tag mx5">61,200 Km</span>
                        <span class="tag">Petrol</span>
                      </div>
                    </div>
                  </div>
          </li>
          <li class="splide__slide text-center">
          <div class="freelancer-style1 text-center bdr1 hover-box-shadow mb60 bdrs12 bg-color">
                     <div class="thumb mb25 mx-auto position-relative rounded-circle">
                      <img class="mx-auto bdrs12"  src="{{ asset('public/site/images/automobile/6.jpg') }}" alt="">
                    </div>
                    <div class="details cars-detail">
                      <h5 class="title mb-1 car-name">Tesla Model 3</h5>
                      <p class="mb10 car-desc">A sleek electric sedan offering smart tech, performance, and zero emissions.</p>
                      <div class="skill-tags d-flex align-items-center mb5">
                        <span class="tag"><i class="fas fa-star fz10 review-color"></i> 5/5</span>
                        <span class="tag mx5">47,300 km</span>
                        <span class="tag">Electric</span>
                      </div>
                    </div>
                  </div>
            </li>
        </ul>
      </div>
      </div>
          </div>
        </div>
      </div>
    </section>

    
	<section class="our-faq pt10 pb60">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 m-auto wow " data-wow-delay="300ms">
            <div class="main-title text-center">
              <h2 class="title">Frequently Asked Questions</h2>
            </div>
          </div>
        </div>
        <div class="row wow fadeInUp" data-wow-delay="300ms">
          <div class="col-lg-8 mx-auto">
            <div class="ui-content">
              <div class="accordion-style1 faq-page mb90">
                <div class="accordion" id="accordionExample">
                  <div class="accordion-item active">
                    <h2 class="accordion-header" id="headingOne">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Will I get the report immediately?</button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                      <div class="accordion-body">Yes, you’ll receive a detailed report within 30 minutes after the inspection.</div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">How long does an inspection take?</button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                      <div class="accordion-body">Around 1.5 hours, depending on the vehicle’s condition.</div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Can the inspection be done on-site?</button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                      <div class="accordion-body">Absolutely! Our inspectors will come to your location with all the necessary tools.</div>
                    </div>
                  </div>
				  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingfour">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">Can I choose when I want my inspection?</button>
                    </h2>
                    <div id="collapsefour" class="accordion-collapse collapse" aria-labelledby="headingfour" data-parent="#accordionExample">
                      <div class="accordion-body">Yes, you can select your preferred date and time and we will contact you based on our availability.</div>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
	
@include('front.includes.footer')
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  new Splide('#cars-slider', {
    type: 'slide',
    perPage: 4,
    gap: '1rem',
    focus: 0, // Align slides from the left
    padding: { right: '60px', left: 0 }, // Only right padding
    pagination: false,
    arrows: false,
    autoplay: false,
    breakpoints: {
      1024: {
        perPage: 2.2,
        padding: { right: '40px', left: 0 },
      },
      768: {
        perPage: 1.3,
        // padding: { right: 0 , left: 0 },
      }
    }
  }).mount();
});


</script>
