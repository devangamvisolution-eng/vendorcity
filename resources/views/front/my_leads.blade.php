@include('front.includes.header')

<style type="text/css">
    .myaccount-tab-list {
        display: block;
        margin-right: 30px;
        border: 1px solid #EEEEEE;
    }

    .nav {

        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }

    .myaccount-tab-list a {
        font-weight: 500;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: justify;
        -webkit-justify-content: space-between;
        -ms-flex-pack: justify;
        justify-content: space-between;
        padding: 14px 20px;

        border-bottom: 1px solid #EEEEEE;
    }

    .my_purchases_box_section .my_purchases_box_inner {
        display: table;
        width: 100%;
    }

    .my_purchases_box_section .custom-back-g-white {
        background: #fafafa;
        padding: 40px 15px;
        margin-bottom: 30px;
    }

    .my_purchases_box_section .my_purchases_box_inner .purchases_top_part {
        display: table;
        width: 100%;
        padding-bottom: 30px;
        border-bottom: 1px solid #cecece;
    }

    .my_purchases_box_section .track_order {
        text-align: right;
    }

    .my_purchases_box_section .track_order a {
        text-decoration: none;
        display: inline-block;
        font-weight: 700;
        font-size: 14px;
        color: #282828;
        border: 1px solid #cecece;
        padding: 10px 20px;
        vertical-align: middle;
    }


    .purchases_item_box .puchases_item_inner ul.purchaseul li.purchaseli.purchaseli_mob_left {
        width: 30%;
        float: left;
    }

    .purchases_item_box .puchases_item_inner ul.purchaseul li.purchaseli {
        margin: 0;
        padding: 0;
        list-style: none;
        vertical-align: top;
        margin-right: 17px;
        margin-bottom: 40px;
    }

    .my_purchases_box_section .my_purchases_box_inner .purchases_bottom_part {
        display: table;
        width: 100%;
        padding-top: 30px;
    }

    .appointment-card {
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        padding: 1rem 1.25rem;
        margin-top: 1rem;
    }

    .appointment-header {
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: #000;
    }

    .status-completed {
        background-color: #d1e7dd;
        color: #0f5132;
        font-weight: 600;
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.5rem;
        float: right;
        user-select: none;
    }

    .appointment-time {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .tab-container {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        /* max-width: 600px; */
        margin: 0 auto;
        /* padding: 1rem; */
    }

    .nav-tabs {
        width: 100%;

    }

    .nav-item {
        width: 50%;
    }

    .nav-tabs .nav-link {
        font-weight: 600;
        color: #212529;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        width: 100%;
    }

    .nav-tabs .nav-link.active {
        color: #0040E6;
        border-color: #0040E6;
    }

    @media (min-width: 768px) and (max-width: 1024px) {

        .sidebar-left {
            display: none !important;
        }
    }
</style>


<div class="body_content">
    <!-- Our LogIn Area -->
    <section class="our-login">

        <div class="container">
            <div class="row">
                <div class="col-lg-4 sidebar-left">

                    @include('front.account_sidebar')
                </div>

                <div class="col-lg-8">

                    <x-my-profile-back-button />

                    <div class="tab-container">

                        <ul class="nav nav-tabs" role="tablist" id="appointmentTabs">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="latest-tab" data-bs-toggle="tab"
                                    data-bs-target="#latest" type="button" role="tab">
                                    Latest Quotes
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past"
                                    type="button" role="tab">
                                    Past Quotes
                                </button>
                            </li>
                        </ul>



                        <div class="tab-content mt-3">

                            <div class="tab-pane fade show active" id="latest" role="tabpanel">

                                @foreach ($latestLeads as $latestLeadsData)
                                    <div class="appointment-card-link">
                                        <div class="appointment-card">
                                            <a href="{{ route('front.mylead_detail', ['type' => $latestLeadsData->type, 'id' => $latestLeadsData->id]) }}"
                                                class="appointment-card-link">
                                                <div class="appointment-header">
                                                    <span>{!! Helper::servicename($latestLeadsData->service_id) !!}<br>{!! Helper::subservicename($latestLeadsData->subservice_id) !!}</span>

                                                    <span
                                                        class="status-completed">{{ $latestLeadsData->inquiry_id }}</span>
                                                    {{-- <span class="status-completed">Confirmed</span> --}}

                                                </div>
                                                <div class="appointment-time">
                                                    {{ date('M d, Y', strtotime($latestLeadsData->added_date)) }}
                                                </div>

                                            </a>

                                            @php
                                                $package_inquiry_accepted = \DB::table('package_inquiry_accepted')
                                                    ->where('packages_inquiry_id', $latestLeadsData->id)
                                                    ->get();
                                            @endphp
                                            @if (isset($package_inquiry_accepted))
                                                @foreach ($package_inquiry_accepted as $package_inquiryData)
                                                    <div class="appointment-user verified-user">
                                                        <i class="fas fa-user-circle me-2"></i>
                                                        <span>{!! Helper::vendorsname($package_inquiryData->vendor_id) !!}</span>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <div class="tab-pane fade" id="past" role="tabpanel">


                                @foreach ($pastLeads as $pastLeadsData)
                                    <div class="appointment-card-link">
                                        <div class="appointment-card">
                                            <a href="{{ route('front.mylead_detail', ['type' => $pastLeadsData->type, 'id' => $pastLeadsData->id]) }}"
                                                class="appointment-card-link">
                                                <div class="appointment-header">
                                                    <span>{!! Helper::servicename($pastLeadsData->service_id) !!}<br>{!! Helper::subservicename($pastLeadsData->subservice_id) !!}</span>

                                                    <span
                                                        class="status-completed">{{ $pastLeadsData->inquiry_id }}</span>
                                                </div>

                                                <div class="appointment-time">
                                                    {{ date('M d, Y', strtotime($pastLeadsData->added_date)) }}
                                                </div>
                                            </a>

                                            @php
                                                $package_inquiry_accepted = \DB::table('package_inquiry_accepted')
                                                    ->where('packages_inquiry_id', $pastLeadsData->id)
                                                    ->get();
                                            @endphp

                                            @if (isset($package_inquiry_accepted))
                                                @foreach ($package_inquiry_accepted as $package_inquiryData)
                                                    <div class="appointment-user verified-user">
                                                        <i class="fas fa-user-circle me-2"></i>
                                                        <span>{!! Helper::vendorsname($package_inquiryData->vendor_id) !!}</span>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                        </div>
                    </div>





                    {{-- @foreach ($allleads as $allleadsData)
                    <a href="" class="appointment-card-link">
                        <div class="appointment-card">
                            <div class="appointment-header">
                                <span >Moving Leads<br>Apartment moving</span>

                               
                                <span class="status-completed">Confirmed</span>
                               
                            </div>
                            <div class="appointment-time">
                                06-2-2025
                               {{ date('M d, Y', strtotime($packages_enquiryData->added_date)) }} 
                            </div>

                           
                        </div>
                    </a>
                    @endforeach --}}


                </div>

            </div>
        </div>

</div>
</section>
</div>


@include('front.includes.footer')

<script>
    function category_validation() {

        var email = jQuery("#email").val();
        if (email == '') {
            jQuery('#email_error').html("Please Enter Email");
            jQuery('#email_error').show().delay(0).fadeIn('show');
            jQuery('#email_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#email').offset().top - 150
            }, 1000);
            return false;
        }

        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (!filter.test(email)) {

            jQuery('#email_error').html("Please Enter Valid Email");
            jQuery('#email_error').show().delay(0).fadeIn('show');
            jQuery('#email_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#email').offset().top - 150
            }, 1000);
            return false;

        }
        var password = jQuery("#password").val();
        if (password == '') {

            jQuery('#password_error').html("Please Enter Password");
            jQuery('#password_error').show().delay(0).fadeIn('show');
            jQuery('#password_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#password').offset().top - 150
            }, 1000);
            return false;

        }

        $.ajax({
            type: "post",
            url: "{{ url('check_login') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "email": email,
                "password": password,

            },
            success: function(returndata) {
                if (returndata == 1) {

                    $('#spinner_button').show();

                    $('#submit_button').hide();

                    $('#category_form').submit();

                } else if (returndata == 2) {
                    // Code for status not equal to 1
                    $('#contact_error_login').html("Account is not active.");
                    $('#contact_error_login').show().delay(2000).fadeOut('show');
                    return false;
                } else {
                    jQuery('#contact_error_login').html(" Email OR Password Not Valid ");
                    jQuery('#contact_error_login').show().delay(0).fadeIn('show');
                    jQuery('#contact_error_login').show().delay(2000).fadeOut('show');
                    return false;

                }



            }
        });




    }

    $(document).ready(function() {
        // Lock both modals on load
        $('#otp_popup_Modal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false // Don't show initially
        });

        $('#email_otp_popup_Modal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        });

        // Show if user not logged in
        @if (Session::get('user') == '')
            $('#otp_popup_Modal').modal('show');
        @endif
    });
</script>
