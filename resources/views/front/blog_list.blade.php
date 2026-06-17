
@include('front.includes.header')

<style type="text/css">
  /* ul li{list-style: inherit;} */
.banner_sec{margin-left: 9%;}
.cta-service-v3{background-image: inherit;background-color: #eee;}
a:hover, .btn:hover {
    color: #0a58ca !important;
    text-decoration: none;
}
.page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #0a58ca !important;
    border-color: #0a58ca !important;
}

section {font-style: normal;}
</style>
<section class="breadcumb-section pt-4" style="display:none;">
<div class="container">
    <div
        class="cta-service-v3 cta-banner mx-auto maxw1700 pt120 pb120 bdrs16 position-relative overflow-hidden d-flex align-items-center mx20-lg px30-lg">
        
        <img class="service-v3-vector d-none d-lg-block" src="{{ asset('public/site/images/test_new.jpg') }}"
            alt="Customer service experience with Vendorscity UAE">
        
            <div class="row wow fadeInUp">
                <div class="col-xl-10 banner_sec">
                    <div class="position-relative">
                        <h2 class=" banner_title" >Blog</h2>
						<div class="d-flex align-items-center">

                            <h6 class="mb-0">Give your visitor a smooth online experience with a solid UX design
                            </h6>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--
<section class="breadcumb-section pt-0">
  <div class="container">
  <div class="cta-about-v1 mx-auto maxw1700 pt120 pb120 bdrs16 position-relative overflow-hidden d-flex align-items-center mx20-lg">
    <div class="container">
      <div class="row">
        <div class="col-xl-5">
          <div class="position-relative">
            <h2 class="text-white">Blogs</h2>
            <p class="text-white mb-0">Give your visitor a smooth online experience with a solid UX design</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section> -->
@if(isset($blog) && !empty($blog))
<section class="our-blog pt-0 mt30" style="display: none;">
  <div class="container">
    <div class="row wow fadeInUp" data-wow-delay="300ms">
      <div class="col-xl-12">
        <div class="tab-pane fade show active fz15 text" id="nav-item1" role="tabpanel" aria-labelledby="nav-item1-tab">
          <div class="row">
            @foreach($blog as $data)
            <div class="col-sm-6 col-xl-4">
              <div class="listing-style1">
                <div class="list-thumb">
                  @if ($data->image != '')
                    <img class="w-100"
                        src="{{ asset('public/upload/blog/large/' . $data->image) }}"
                        alt="{{$data->image_alt_tag ?? ''}}">
                @else
                    <img class="w-100"
                        src="{{ asset('public/upload/blog/large/Image_Available.jpg') }}"
                        alt="{{$data->image_alt_tag ?? ''}}">
                @endif
                </div>
                <div class="list-content">
                  <a class="date" href="">{{$data->date}}</a>
                  <h4 class="title mt-1"><a href="{{route('blog_detail',$data->blog_url)}}">{{$data->title}}</a></h4>
                  <p class="text mb-0">{!! html_entity_decode ($data->short_description) !!}</p>
                </div>
              </div>
            </div>
            @endforeach
          
            
          </div>
        </div>
      </div>
      
      {!! $blog->appends($_GET)->render("pagination::bootstrap-4") !!}

    </div>
  </div>
</section>
@endif
@if(isset($blog) && !empty($blog))
<!-- Blog Section Area -->
    <section class="our-blog pt40 mt120">
      <div class="container">
        <div class="row wow fadeInUp" data-wow-delay="300ms">
          <div class="col-lg-8">

              @foreach($blog as $data)
            <div class="blog-style1 large-size mb20">
              <div class="blog-img">
                  @if ($data->image != '')
                    <img class="w-100"
                        src="{{ asset('public/upload/blog/large/' . $data->image) }}"
                        alt="{{$data->image_alt_tag ?? ''}}">
                @else
                    <img class="w-100"
                        src="{{ asset('public/upload/blog/large/Image_Available.jpg') }}"
                        alt="{{$data->image_alt_tag ?? ''}}">
                @endif
                <!-- <img class="w-100 bdrs4" src="{{ asset('public/site/images/blog/blog-17.jpg')}}" alt=""> -->
              </div>
              <div class="blog-content px-0 pt20 pb-0">
                <div class="blog-single-meta mb25">
                  <div class="post-author d-sm-flex align-items-center">
                    <a class="ml15 body-light-color" href="{{route('blog_detail',$data->blog_url)}}">{{$data->date}}</a>
                  </div>
                </div>
                <h3 class="title mt-1 mb10"><a href="{{route('blog_detail',$data->blog_url)}}" style="color:#0040E6;">{{$data->title}}</a></h3>
                <p class="text mb25">{!! html_entity_decode ($data->short_description) !!}</p>
                <a href="{{route('blog_detail',$data->blog_url)}}" class="ud-btn btn-thm2 add-joining ml10">Read More<i class="fal fa-arrow-right-long"></i></a>
              </div>
            </div>
@endforeach
            <!-- <div class="blog-style1 large-size mb20">
              <div class="blog-img"><img class="w-100 bdrs4" src="images/blog/blog-18.jpg" alt=""></div>
              <div class="blog-content px-0 pt20 pb-0">
                <div class="blog-single-meta mb25">
                  <div class="post-author d-sm-flex align-items-center">
                    <img class="mr10" src="images/blog/author-1.png" alt=""><a class="pr15 body-light-color" href="">Leslie Alexander</a><a class="ml15 pr15 body-light-color" href="">Business</a><a class="ml15 body-light-color" href="">December 2, 2022</a>
                  </div>
                </div>
                <h3 class="title mt-1 mb10"><a href="page-blog-single.html">Engendering a culture of professional development</a></h3>
                <p class="text mb25">Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.</p>
                <a href="page-blog-single.html" class="ud-btn btn-light-thm">Read More<i class="fal fa-arrow-right-long"></i></a>
              </div>
            </div>
            <div class="blog-style1 large-size mb50">
              <div class="blog-img"><img class="w-100 bdrs4" src="images/blog/blog-19.jpg" alt=""></div>
              <div class="blog-content px-0 pt20 pb-0">
                <div class="blog-single-meta mb25">
                  <div class="post-author d-sm-flex align-items-center">
                    <img class="mr10" src="images/blog/author-1.png" alt=""><a class="pr15 body-light-color" href="">Leslie Alexander</a><a class="ml15 pr15 body-light-color" href="">Business</a><a class="ml15 body-light-color" href="">December 2, 2022</a>
                  </div>
                </div>
                <h3 class="title mt-1 mb10"><a href="page-blog-single.html">Hey Job Seeker, It’s Time To Get Up And Get Hired</a></h3>
                <p class="text mb25">Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.</p>
                <a href="page-blog-single.html" class="ud-btn btn-light-thm">Read More<i class="fal fa-arrow-right-long"></i></a>
              </div>
            </div> -->
            <div class="row">
              <div class="mbp_pagination text-center mb40-md">
                {!! $blog->appends($_GET)->render("pagination::bootstrap-4") !!}
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="blog-sidebar ms-lg-auto">
              {{-- <div class="default-box-shadow1 mb30">
                <div class="search_area">
                  <input type="text" class="form-control" placeholder="Search">
                  <label><span class="flaticon-loupe"></span></label>
                </div>
              </div>
              <div class="sidebar-widget mb30">
                <h4 class="widget-title">Category</h4>
                <div class="category-list mt30">
                  <a class="d-flex align-items-center justify-content-between" href="">Designer <span class="body-light-color">(1,945)</span></a>
                  <a class="d-flex align-items-center justify-content-between" href="">Web Developers <span class="body-light-color">(8,136)</span></a>
                  <a class="d-flex align-items-center justify-content-between" href="">Illustrators <span class="body-light-color">(917)</span></a>
                  <a class="d-flex align-items-center justify-content-between" href="">Node.js <span class="body-light-color">(240)</span></a>
                  <a class="d-flex align-items-center justify-content-between" href="">Project Managers <span class="body-light-color">(2,460)</span></a>
                </div>
              </div> --}}

              @if(isset($recent_blog) && !empty($recent_blog))
              <div class="sidebar-widget mb30">
                <h4 class="widget-title">Recent Posts</h4>

                @foreach($recent_blog as $recent_blog_data)
                <div class="list-news-style d-flex align-items-center mt30 mb20">
                  <div class="news-img flex-shrink-0">
                    @if ($recent_blog_data->image != '')
                        <img src="{{ asset('public/upload/blog/small/' . $recent_blog_data->image) }}" alt="{{$recent_blog_data->image_alt_tag ?? ''}}">
                        @endif
                  </div>
                  <div class="news-content flex-shrink-1 ms-3">
                    <h6 class="new-text mb0">{{$recent_blog_data->title}}</h6>
                    <a class="body-light-color" href="{{route('blog_detail',$recent_blog_data->blog_url)}}">{{$recent_blog_data->date}}</a>
                  </div>
                </div>
                @endforeach
                <!-- <div class="list-news-style d-flex align-items-center mb20">
                  <div class="news-img flex-shrink-0"><img src="images/blog/blog-s-2.jpg" alt=""></div>
                  <div class="news-content flex-shrink-1 ms-3">
                    <h6 class="new-text mb0">The Benefits Of Using <br class="d-none d-xl-block">Technology In Learning</h6>
                    <a class="body-light-color" href="">December 2, 2022</a>
                  </div>
                </div>
                <div class="list-news-style d-flex align-items-center">
                  <div class="news-img flex-shrink-0"><img src="images/blog/blog-s-3.jpg" alt=""></div>
                  <div class="news-content flex-shrink-1 ms-3">
                    <h6 class="new-text mb0">A Better Alternative To <br class="d-none d-xl-block">Grading Student Writing</h6>
                    <a class="body-light-color" href="">December 2, 2022</a>
                  </div>
                </div> -->
              </div>

              @endif
              <!-- <div class="sidebar-widget mb30 pb20">
                <h4 class="widget-title">Tags</h4>
                <div class="tag-list mt30">
                  <a href="">Figma</a>
                  <a href="">Sketch</a>
                  <a href="">HTML5</a>
                  <a href="">Software Design</a>
                  <a href="">Prototyping</a>
                  <a href="">SaaS</a>
                  <a href="">Design Writing</a>
                </div>
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </section>
    @endif
@include('front.includes.footer')