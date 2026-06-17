@include('front.includes.header')

<style type="text/css">
     .custom-desc li{    
        list-style: inherit;
        }
        figure.image img {
          width: 100%
        }
</style>

<section class="breadcumb-section pt-0 mt120">
    @if(isset($blog_detail) && !empty($blog_detail))
    <section class="our-blog pt40">
        {{-- <div class="container">
          <div class="row wow fadeInUp" data-wow-delay="100ms">
            <div class="col-lg-12">
              <h2 class="blog-title">Engendering a culture of professional development</h2>
              <div class="blog-single-meta">
                <div class="post-author d-sm-flex align-items-center">
                  <img class="mr10" src="images/blog/author-1.png" alt=""><a class="pr15 body-light-color" href="">Leslie Alexander</a><a class="ml15 pr15 body-light-color" href="">Business</a><a class="ml15 body-light-color" href="">{{$blog_detail->date}}</a>
                </div>
              </div>
            </div>
          </div>
        </div> --}}

        <div class="container">

        <div class="mx-auto maxw1600 mt60 wow fadeInUp" data-wow-delay="300ms">
            <div class="row">
              <div class="col-lg-12">
                <div class="large-thumb"><img class="w-100 bdrs16" src="{{ asset('public/upload/blog/large/' . $blog_detail->image) }}" alt="{{$blog_detail->image_alt_tag ?? ''}}"></div>
              </div>
            </div>
    
        <div class="roww wow fadeInUp" data-wow-delay="500ms">
          <div class="col-xl-12">
            <div class="ui-content mt45 mb60 custom-desc">
              <h5 class="mb20">{{$blog_detail->title}}</h5>
              
              <p class="mb25 ff-heading text">{!! html_entity_decode ($blog_detail->description) !!}</p>
            </div>
            
            </div>
            </div>
            </div>
        </section>
        @endif
</section>






@include('front.includes.footer')