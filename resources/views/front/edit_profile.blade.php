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

.my-address-section {
    background-color: #fafafa;
    padding: 30px 20px;
}
.myaccount-content {
    font-size: 16px;
    font-weight: 400;
}

input:not([type="checkbox"]):not([type="radio"]), textarea {
    font-size: 16px;
    font-weight: 400;
    display: block;
    width: 100%;
    padding: 10px 0;
    color: #333333;
    border: 2px solid transparent;
    border-bottom-color: #EDEDED;
    background-color: transparent;
}

</style>


<div class="body_content">
    <!-- Our LogIn Area -->
    <section class="our-login mt120">

        <div class="container">
            <div class="row">
                <div class="col-lg-4">

                    @include('front.account_sidebar')
                </div>

                <div class="col-lg-8">

                    @php
                        $userData = Session::get('user');
                        // $userData = Session::get('user');

                        //echo "<pre>";print_r($userData);echo"</pre>";
                    @endphp

                     <div class="my-address-section">
<div class="myaccount-content account-details">
                                <div class="account-details-form">
                                <form role="form" id="form" method="post" action="{{ url('edit-profile') }}">
                                    @csrf
                                <input type="hidden" name="action" value="update_profile">
                                <input type="hidden" name="id" id="id" value="18">
                                        <div class="row learts-mb-n30">
                                             <div class="col-md-12 col-12 learts-mb-30">
                                                <div class="custom-inner-form-title">
                                        <h4>Personal Information</h4>
                                    </div> 
                                                 </div>
                                            <div class="col-md-6 col-12 learts-mb-30">
                                                <div class="single-input-item">
                                                    <label for="first-name">Name <abbr class="required">*</abbr></label>
                                                    <input type="text" name="fname" id="fname" value="{{$user_data->name ?? ''}}" required="">
                                                    <p class="form-error-text" id="first_name_error" style="color: red;"></p>
                                                </div>
                                            </div>
                                           
                                            
                                             <div class="col-md-12 col-12 learts-mb-30">
                                                <div class="custom-inner-form-title">
                                        <h4>Sign In Details</h4>
                                    </div> 
                                                 </div>
                                        
                                           <div class="col-md-6 col-12 learts-mb-30">
                                                <div class="single-input-item">
                                                    <label for="last-name">Email Id<abbr class="required">*</abbr></label>
                                                    <input type="text" id="email_id" name="email_id" value="{{$user_data->email ?? ''}}" readonly=""> 
                                                    <p class="form-error-text" id="email_error" style="color: red;"></p>
                                                </div>
                                            </div>
                                            
                                               <div class="col-md-6 col-12 learts-mb-30">
                                                <div class="single-input-item">
                                                    <label for="last-name">Mobile No <abbr class="required">*</abbr></label>
                                                    <input type="text" id="mobile" name="mobile" value="{{$user_data->mobile ?? ''}}">
                                                    <p class="form-error-text" id="phone_error" style="color: red;"></p>
                                                </div>
                                            </div>
                            
                                            <div class="col-12 learts-mb-30">
                                                <button type="submit" class="ud-btn btn-thm2 add-joining" onclick="validation(); return false;">Update Profile</button>
                                            </div>
                                        </div>
                                    </form>
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
    function validation(){
        var first_name = jQuery("#fname").val();
        if (first_name == '') {
            jQuery('#first_name_error').html("Please enter First Name");
            jQuery('#first_name_error').show().delay(0).fadeIn('show');
            jQuery('#first_name_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#fname').offset().top - 150
            }, 1000);
            return false;
        }

        var email_id = jQuery("#email_id").val();
        if (email_id == '') {
            jQuery('#email_error').html("Please enter Email Address");
            jQuery('#email_error').show().delay(0).fadeIn('show');
            jQuery('#email_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#email_id').offset().top - 150
            }, 1000);
            return false;
        }

        var em = jQuery('#email_id').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(em)) {
            jQuery('#email_error').html("Please Enter Valid Email Address");
            jQuery('#email_error').show().delay(0).fadeIn('show');
            jQuery('#email_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#email_id').offset().top - 150
            }, 1000);
            return false;
        }

        

        var phone = jQuery("#mobile").val();
        var phone_length = phone.length;
        if (phone == '' || phone.length < 7 || phone.length > 15) {
            
            jQuery('#phone_error').html("Please enter a valid Phone Number");
            jQuery('#phone_error').show().delay(0).fadeIn('show');
            jQuery('#phone_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#mobile').offset().top - 150
            }, 1000);
            return false;
        }else{
            $('#form').submit();
        }
    }
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