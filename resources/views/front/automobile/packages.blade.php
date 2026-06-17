@include('front.includes.header')
<style>
.desktop_img{
        display: block;
        width: 100%;
        height: auto;   
    }
.mobile_img{
        display: none;
        width: 100%;
        height: auto;   
    }

.automobile_sec{
    padding: 0;
}

.automobile_lists{
    position: relative;
    top: 91px;
}
.pricing_packages{
    border: inherit !important;
}

.pricing_packages:hover{

border: inherit !important;
background-color: #FFD312 !important;
}

.pricing_packages  .package_title {
    background: #000;
    color: #fff;
    border-radius: 9999px;
    font-size: 1.25rem;
    line-height: 1.75rem;
    padding-left: 1.25rem;
    padding-right: 1.25rem;
    padding-top: 6px;
    padding-bottom: 6px;
    max-width: 13rem;
    margin: 0 auto;
}

.tag_title {
    background: #FFD312;
    color: #000;
    border-radius: 9999px;
    font-size: 12px;
    line-height: 1.75rem;
    max-width: 8rem;
    margin: 0 auto;
	font-weight: 500;
}
.tag_hig {
	height: 40px;
}
.dhiram {
	height: 19px;
    margin-right: 5px;
    margin-top: -5px;
}
.pricing_packages .text1 {
font-weight: 800;
    font-size: 1.25rem;
    line-height: 1.75rem;
}

.pricing_packages .details .pricing-list{
    text-align: left;
}

.pricing_packages .pricing-list li{
    font-size: 1rem;
    line-height: 1.5rem;
}
.pricing_packages .pricing-list li i{
     font-size: 1rem;
    line-height: 1.5rem;
    margin-right:10px;
}
    @media only screen and (max-width: 600px) {
        .desktop_img{
            display: none;
        }
        .mobile_img{
            display: block;
        }
    }
</style>
<div class="automobile_lists">
<section class="our-about  automobile_sec  mrgb0">
    <div>
        <div class="row align-items-center">
            {{-- <div class="col-xl-5 offset-xl-1">
                <div class="position-relative wow fadeInLeft" data-wow-delay="300ms">
                    <h2 class=" mb35">Explore the best deals on moving</h2>

                </div>
                <div class="list-style2 light-style">
                    <ul class="mb30">
                        <li><i class="far fa-check fa-check-custom"></i>Use Code MoveitMoveit</li>
                    </ul>
                </div>
            </div> --}}
            <div class="col-xl-12">
                <div class="position-relative mb30-lg mrgb0">
                    <div class="wow fadeInRight mb-3" data-wow-delay="300ms">
                        @if(isset($subservices_data->banner_image))
                            <img style="width: 100%;" class="desktop_img"
                                src="{{ asset('public/upload/subservice/banner/' . $subservices_data->banner_image) }}"
                                alt="">

                            <img style="width: 100%;" class="mobile_img"
                                src="{{ asset('public/upload/subservice/banner/' . $subservices_data->mobile_banner_image) }}"
                                alt="">

                            {{-- Centered Content --}}
                            
                        @else
                            <img style="width: 100%;"
                                src="{{ asset('public/upload/subservice/banner/no_image_subservice.png') }}"  alt="">
                        @endif
                    </div>
                </div>

                 
            </div>

        </div>

    </div>
</section>
 <!-- Pricing Table Area -->
    <section class="our-pricing pb90 pt40">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 m-auto wow fadeInUp">
            <div class="main-title text-center mb30">
              <h2 class="title">Select Package</h2>
              
            </div>
          </div>
        </div>
        
        <div class="row wow fadeInUp" data-wow-delay="300ms">
         
        @foreach($packages as $data)
        <div class="col-sm-6 col-xl-4">
            <a href="{{ route('automobile.bookinspection',$data->id) }}">
            <div class="pricing_packages text-center bdrs16">
                
               <div class="tag_hig">  @if(!empty($data->tag))<p class="tag_title "><i class="fa-solid fa-star"></i> {{$data->tag}}</p> @endif</div>
              
              <div class="heading mt10 mb10">
                
                <h1 class="package_title ">{{$data->name}}</h1>
                <h4 class="text1 mt-2"> <img class="dhiram" src="{{ asset('public/site/images/automobile/dhiram.png') }}" alt="">{{$data->price}} <small></small></h4>
				<p style="color: #000;">Onwards</p>
              </div>
              <div class="details">
                 @php 
                   $package_attr = App\Models\admin\VerifyBuyPackageAttr::where('verify_buy_package_id',$data->id)->orderBy('id','DESC')->get();
                 @endphp
                <div class="pricing-list mb40">
                  <ul class="px-0">
                    @foreach($package_attr as $data_attr)
                    <li><i class="fas fa-check"></i>{{$data_attr->details}}</li>
                    @endforeach
                    <!-- <li><i class="fas fa-check"></i>30 Days Visibility</li>
                    <li><i class="fas fa-check"></i>Highlighted in Search Results</li>
                    <li><i class="fas fa-check"></i>4 Revisions</li>
                    <li><i class="fas fa-check"></i>9 days Delivery Time</li>
                    <li><i class="fas fa-check"></i>Products Support</li> -->
                  </ul>
                </div>
                
              </div>
             
            </div>
             </a>
          </div>
          @endforeach

          {{--<div class="col-sm-6 col-xl-4">
            <a href="{{ route('automobile.bookinspection') }}">
            <div class="pricing_packages text-center bdrs16">
                
              <div class="heading mb10">
                
                <h1 class="package_title">360-Advance</h1>
                <h4 class="text1 mt-2">AED 599 <small></small></h4>
              </div>
              <div class="details">
                
                <div class="pricing-list mb40">
                  <ul class="px-0">
                    <li><i class="fas fa-check"></i>Under Body Examination</li>
                    <li><i class="fas fa-check"></i>30 Days Visibility</li>
                    <li><i class="fas fa-check"></i>Highlighted in Search Results</li>
                    <li><i class="fas fa-check"></i>4 Revisions</li>
                    <li><i class="fas fa-check"></i>9 days Delivery Time</li>
                    <li><i class="fas fa-check"></i>Products Support</li>
                  </ul>
                </div>
                
              </div>
             
            </div>
             </a>
          </div>

          <div class="col-sm-6 col-xl-4">
            <div class="pricing_packages  text-center bdrs16">
              <div class="heading mb10">
                <h1 class="package_title ">Comprehensive</h1>
                <h4 class="text1 mt-2">AED 299 <small></small></h4>
              </div>
              <div class="details">
                
                <div class="pricing-list mb40">
                  <ul class="px-0">
                    <li><i class="fas fa-check"></i>Under Body Examination</li>
                    <li><i class="fas fa-check"></i>30 Days Visibility</li>
                    <li><i class="fas fa-check"></i>Highlighted in Search Results</li>
                    <li><i class="fas fa-check"></i>4 Revisions</li>
                    <li><i class="fas fa-check"></i>9 days Delivery Time</li>
                    <li><i class="fas fa-check"></i>Products Support</li>
                  </ul>
                </div>
                
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-4">
            <div class="pricing_packages text-center bdrs16">
              <div class="heading mb10">
                <h1 class="package_title ">Accident History</h1>
                <h4 class="text1 mt-2">AED 220 <small></small></h4>
              </div>
              <div class="details">
                
                <div class="pricing-list mb40">
                  <ul class="px-0">
                    <li><i class="fas fa-check"></i>Under Body Examination</li>
                    <li><i class="fas fa-check"></i>30 Days Visibility</li>
                    <li><i class="fas fa-check"></i>Highlighted in Search Results</li>
                    <li><i class="fas fa-check"></i>4 Revisions</li>
                    <li><i class="fas fa-check"></i>9 days Delivery Time</li>
                    <li><i class="fas fa-check"></i>Products Support</li>
                  </ul>
                </div>
                
              </div>
            </div>
          </div> --}}
          
        </div>
      </div>
    </section>
</div>
@include('front.includes.footer')



