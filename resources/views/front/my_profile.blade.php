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

    .my-profile-top {
        background-color: #fafafa;
        padding: 30px 15px;
    }

    @media (min-width: 768px) and (max-width: 1024px) {

        .sidebar-left {
            display: none !important;
        }
    }
</style>


<div class="body_content">
    <!-- Our LogIn Area -->
    <section class="our-login mt120">

        <div class="container">
            <div class="row">
                <div class="col-lg-4 sidebar-left">

                    @include('front.account_sidebar')
                </div>

                <div class="col-lg-8">

                    <x-my-profile-back-button />

                    <div class="my-profile-section">

                        <div class="my-profile-top">

                            <div class="custom-fields-profile">
                                <div class="col-md-12">
                                    <div class="custom-form-text">
                                        <h4>My Profile <span class="forms-edition" style="float: right;">
                                                <a href="{{ url('edit-profile') }}"><i class="fa fa-pencil"
                                                        aria-hidden="true"></i> Edit</a>
                                            </span></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-201">
                                    <div class="custom-form-labels">
                                        <p class="custom-forms-label">Name</p>
                                        <h6 class="custom-forms-text">{{ $user_data->name ?? '' }}</h6>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-201">
                                    <div class="custom-form-labels">
                                        <p class="custom-forms-label">Mobile Number</p>
                                        <h6 class="custom-forms-text">{{ $user_data->mobile ?? '' }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-201">
                                    <div class="custom-form-labels">
                                        <p class="custom-forms-label">Email Id</p>
                                        <h6 class="custom-forms-text">{{ $user_data->email ?? '' }}</h6>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
</div>


@include('front.includes.footer')
<script>
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
