@include('front.includes.header')
<style>
    @media only screen and (max-width: 600px) {
      .breadcumb-section {
          padding: 20px 15px;
      }
    }
</style>
<!-- Our Terms & Conditions -->
<section class="breadcumb-section pt-4 container mt120">
    <div>
            <div class="container cta-service-v3 cta-banner mx-auto maxw1700 pt120 pb120 position-relative overflow-hidden d-flex align-items-center px30-lg" style="background-image: linear-gradient(to right, #0040E6, #FFD312); height: 220px; border-radius: 20px;">
                    <div class="row wow fadeInUp container">
                        <div class="col-xl-12">
                            <div class="position-relative">
                                <h1 class=" banner_title" style="color: #fff;" >{{ $cms_data->name }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
</section>
    <section class="our-terms pt60 pb60">
        <div class="row">
            {{-- <div class="col-md-3 col-lg-3 col-xl-2">
                <div class="terms_condition_widget mb30-sm">
                    <div class="widget_list">
                        <nav>
                            <div class="nav nav-tabs text-start" id="nav-tab" role="tablist">
                                <button class="nav-link text-start" id="nav-accountpayment-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-accountpayment" type="button" role="tab"
                                    aria-controls="nav-accountpayment" aria-selected="true">Account & Payments</button>
                                <button class="nav-link text-start" id="nav-manageother-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-manageother" type="button" role="tab"
                                    aria-controls="nav-manageother" aria-selected="false">Manage Orders</button>
                                <button class="nav-link text-start" id="nav-returrefund-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-returrefund" type="button" role="tab"
                                    aria-controls="nav-returrefund" aria-selected="false">Returns & Refunds</button>
                                <button class="nav-link text-start" id="nav-covid19-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-covid19" type="button" role="tab"
                                    aria-controls="nav-covid19" aria-selected="false">COVID-19</button>
                                <button class="nav-link text-start active" id="nav-other-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-other" type="button" role="tab" aria-controls="nav-other"
                                    aria-selected="false">Other</button>
                            </div>
                        </nav>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="terms_condition_grid text-start pl50">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-accountpayment" role="tabpanel"
                            aria-labelledby="nav-accountpayment-tab">
                            <div class="grids mb90 mb40-md">
                                {{-- <h4 class="title">{{ $cms_data->name }}</h4> --}}
                                {!! html_entity_decode($cms_data->description) !!}
                                {{-- <p class="text fz15"></p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@include('front.includes.footer')
