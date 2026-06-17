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

    .ol-points li {
        list-style-type: decimal !important;
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

                    @php
                        $encryptedId = base64_encode($userid);
                    @endphp

                    <div class="tab-content">

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade show active">
                            <div class="myaccount-content dashboad">

                                <h4><b>Earn a 10% Discount by Referring Friends to VendorsCity!</b></h4>
                                <p>It’s simple! Here’s how you and your friends can enjoy exclusive savings:</p>

                                <ol class="ol-points">
                                    <li>Share Your Referral Link – Use the unique referral link provided below and send
                                        it to your friends via WhatsApp, social media, or email.</li>
                                    <li>Friend Registers & Books – Your friend must sign up and book a service using the
                                        same referral link.</li>
                                    <li> Enjoy the Discount! – Once your friend completes their first order, both of you
                                        will receive a 10% discount on your next service.</li>
                                </ol>

                                <p> <span>📩</span> Start Referring & Saving Now! Share below link and enjoy the
                                    rewards! <span>🚀</span></p>

                                <div class="myaccount-tab-list nav">
                                    {{-- <a href="{{ url('refer_and_earn/' . $userData) }}">
                                        {{ url('refer_and_earn/' . $userData) }} <i class="far fa-copy"></i></a> --}}

                                    {{-- <a href="{{ url('Sign-Up/' . $encryptedId) }}"> --}}
                                    <span
                                        style="padding: 20px;display: inline-block;width: 100%;">{{ url('Sign-Up/' . $encryptedId) }}
                                        <i class="far fa-copy" style="float: right;cursor: pointer;"
                                            id="copyLink"></i></span>
                                    {{-- </a> --}}
                                </div>
                            </div>
                        </div>
                        <!-- Single Tab Content End -->
                    </div>

                </div>
            </div>

        </div>
    </section>
</div>


@include('front.includes.footer')

<script>
    document.getElementById('copyLink').addEventListener('click', function(event) {
        event.preventDefault();

        // Create a temporary input element
        var tempInput = document.createElement('input');
        tempInput.value = "{{ url('Sign-Up/' . $encryptedId) }}";
        document.body.appendChild(tempInput);

        // Select and copy the text in the input element
        tempInput.select();
        document.execCommand('copy');

        // Remove the temporary input element
        document.body.removeChild(tempInput);

        // Optionally provide user feedback (e.g., alert or tooltip)
        // alert('URL copied to clipboard!');
    });
</script>

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
