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

    .card-rounded {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.booking_detail {
    padding: 1rem 1.5rem;
}

.booking_detail h5 {
    color: #000000de;
    font-size: 22px;
    font-style: normal;
    font-weight: 700;
    letter-spacing: 0;
    line-height: 32px;
}
.booking_detail ul li {
    align-items: center !important;
    justify-content: space-between !important;
    display: flex
;
    margin-bottom: 0.75rem;
}
.booking_detail ul li strong {
    font-size: 16px;
    letter-spacing: .1px;
    font-style: normal;
    font-weight: 400;
    line-height: 24px;
    color: #00000061 !important;
}
.booking_detail .status-completed {
    font-size: 16px;
    letter-spacing: .1px;
    font-style: normal;
    font-weight: 400;
    line-height: 24px;
    color: #49a361 !important;
}
.right {
	color: #000;
    display: flex;
    align-items: center;
    gap: 2px;
}
.right  .dhiram{
	width: 15px;
}
.currency_dhiram {
    display: inline-block;
        width: 18px;
    height: 18px;

    background-color: currentColor;

    -webkit-mask: url('{{ asset("public/site/icons/dirham.svg") }}') no-repeat center;
    mask: url('{{ asset("public/site/icons/dirham.svg") }}') no-repeat center;

    -webkit-mask-size: contain;
    mask-size: contain;
}
</style>


<div class="body_content">
    <!-- Our LogIn Area -->
    <section class="our-login">

        <div class="container">
            <div class="row">
                <div class="col-lg-4">

                    @include('front.account_sidebar')
                </div>

                <div class="col-lg-8">

                    <div class="card card-rounded mb-4  booking_detail">
                  
                        <h5 class="mb-3">Quotes Details</h5>
                        <ul class="list-unstyled mb-3">
                        
                        <li><strong>Reference Code:</strong> <span class="right">{{ $lead->inquiry_id ?? ''}}</span></li>

                        <li><strong>Service:</strong> <span class="right">{!! Helper::servicename($lead->service_id ?? '0') !!}</span></li>
                        <li><strong>Sub Service:</strong> <span class="right">{!! Helper::subservicename($lead->subservice_id ?? '0') !!}</span></li>
                        @if($type == 'packages')

                        @php
                            $packages_enquiry = \DB::table('more_formfields_details')->where('package_inquiry_id',$lead->id ?? '0')->get();

                            //echo "<pre>";print_r($packages_enquiry);echo"";
                        @endphp

                       @if ($packages_enquiry != '')
                            @php $i = 0; @endphp
                            @foreach ($packages_enquiry as $packages_enquiry_data)
                                @if ($packages_enquiry_data->formfield_value != '')
                                    @php
                                        $value = $packages_enquiry_data->formfield_value;
                                        $isNumeric = is_numeric($value) && $packages_enquiry_data->form_field_id != 30;
                                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];
                                        $extension = pathinfo($value, PATHINFO_EXTENSION);
                                    @endphp

                                    {{-- Single clean row --}}
                                    <li>
                                        <strong>{!! Helper::form_fields($packages_enquiry_data->form_field_id) !!}:</strong>
                                        <span class="right">
                                            @if ($isNumeric)
                                                {!! Helper::form_fields_attr($value) !!}
                                            @elseif (in_array(strtolower($extension), $imageExtensions))
                                                <a href="{{ url('admin/download/' . $value) }}">Download</a>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </span>
                                    </li>

                                    {{-- Extra form fields --}}
                                    @php
                                        $get_more_id = DB::table('more_formfields_details_att')
                                            ->where('form_id', '=', $packages_enquiry_data->form_field_id)
                                            ->where('package_inquiry_id', '=', $packages_enquiry_data->package_inquiry_id)
                                            ->get()
                                            ->toArray();
                                    @endphp

                                    @if (!empty($get_more_id))
                                        <li>
                                            <strong>Type of Home:</strong>
                                            <span class="right">
                                                @foreach ($get_more_id as $get_more_id_data)
                                                    {!! Helper::form_fields_attr_more($get_more_id_data->more_form_attributes_id) !!}{{ !$loop->last ? ', ' : '' }}
                                                @endforeach
                                            </span>
                                        </li>
                                    @endif

                                    @php $i = $packages_enquiry_data->form_field_id; @endphp
                                @endif
                            @endforeach
                        @endif


                        @endif


                        @if($type == 'wooden')
                            <li><strong>Type of Property:</strong><span class="right">{{ $lead->property_type ?? ''}}</span></li>
                            <li><strong>Area Of Floor:</strong><span class="right">{{ $lead->area_of_floor ?? '' }}</span></li>
                            <li><strong>Condition Of Floor:</strong><span class="right">{{ $lead->condition_of_floor ?? '' }}</span></li>
                            <li><strong>Required Service:</strong><span class="right">{{ $lead->service_required ?? '' }}</span></li>
                            <li><strong>Scheduling Site Survey:</strong><span class="right">@if($lead->schedule_site_survey === 'yes')
                                                        Yes Surveyor will visit the site
                                                        @else
                                                        Floor Video Uploaded
                                                        @endif</span></li>
                            <li><strong>Address:</strong><span class="right">{{
                                collect([
                                    $lead->city,
                                    $lead->area,
                                    $lead->building_street_no
                                ])->filter()->implode(', ')
                            }}</span></li>
                            <li><strong>Date:</strong><span class="right">{{
                                collect([
                                    $lead->enquiry_month,
                                    $lead->enquiry_date,
                                    $lead->enquiry_year
                                ])->filter()->implode(', ')
                            }}</span></li>

                            <li><strong>Time:</strong><span class="right">{!! Helper::timeslotname(strval($lead->time_slot)) !!}</span></li>
                            <li><strong>Describe Wooden Floor Polishing Service:</strong><span class="right">{{ $lead->describe_your_requirements ?? "" }}</span></li>

                        @endif

                        @if($type == 'painting')
                            <li><strong>Type of Painting:</strong><span class="right">{{ $lead->type_of_painting ?? "" }}</span></li>
                            <li><strong>Address:</strong><span class="right">{{
                                collect([
                                    $lead->city,
                                    $lead->area,
                                    $lead->building_street_no
                                ])->filter()->implode(', ')
                            }}</span></li>
                            <li><strong>Date:</strong><span class="right">{{
                                collect([
                                    $lead->enquiry_month,
                                    $lead->enquiry_date,
                                    $lead->enquiry_year
                                ])->filter()->implode(', ')
                            }}</span></li>
                            <li><strong>Time:</strong><span class="right">{!! Helper::timeslotname(strval($lead->time_slot)) !!}</span></li>
                            <li><strong>Describe Painting Service:</strong><span class="right">{{ $lead->describe_painting_service ?? "" }}</span></li>

                            @if($lead->no_of_rooms_painted != 0)
                                <li><strong>No.of Rooms:</strong><span class="right">{{ $lead->no_of_rooms_painted ?? "" }}</span></li>
                            @endif
                            @if($lead->no_of_walls_painted != 0)
                                <li><strong>No.of Walls:</strong><span class="right">{{ $lead->no_of_walls_painted ?? "" }}</span></li>
                            @endif
                        @endif


                        @if($type == 'pcgarden')
                        
                            @php
                                $pcgardenData = \DB::table('garden_enquiry')->where('inquiry_id',$lead->id)->first();
                            @endphp

                            @if(isset($pcgardenData->service_type))
                                <li><strong>Which service do you need quotes for:</strong><span class="right">{{ $pcgardenData->service_type ?? "" }}</span></li>
                            @endif
                            @if(isset($pcgardenData->service_date))
                                <li><strong>When do you need the service:</strong><span class="right">{{ $pcgardenData->service_date ?? "" }}</span></li>
                            @endif

                             @if(isset($pcgardenData->city))
                                <li><strong>Which city do you need the service:</strong><span class="right">{!! Helper::cityname(strval($pcgardenData->city)) !!}</span></li>
                            @endif
                             @if(isset($pcgardenData->address))
                                <li><strong>Where do you need the service:</strong><span class="right">{{ $pcgardenData->address ?? "" }}</span></li>
                            @endif
                             @if(isset($pcgardenData->type_of_home))
                                <li><strong>What is the type of the unit you live in:</strong><span class="right">{{ $pcgardenData->type_of_home ?? "" }}</span></li>
                            @endif
                             @if(isset($pcgardenData->size_of_home))
                                <li><strong>What is the size of your home:</strong><span class="right">{{ $pcgardenData->size_of_home ?? "" }}</span></li>
                            @endif
                             @if(isset($pcgardenData->describe_your_requirements))
                                <li><strong>Please describe the job in as much detail as possible:</strong><span class="right">{{ $pcgardenData->describe_your_requirements ?? "" }}</span></li>
                            @endif


                        @endif
                        </ul>
                    </div>

                    @php
                        $package_inquiry_accepted = \DB::table('package_inquiry_accepted')->where('packages_inquiry_id',$lead->id ?? '0')->get();
                    @endphp
                @if(isset($package_inquiry_accepted))
                    @foreach($package_inquiry_accepted as $package_inquiryData)

                        @php
                            $vendorData = \DB::table('users')->where('id',$package_inquiryData->vendor_id)->first();

                            $latestQuote = \DB::table('qoute_includes')
                                                ->where('vendor_id', $package_inquiryData->vendor_id)
                                                ->where('packages_inquiry_id', $package_inquiryData->packages_inquiry_id)
                                                ->orderBy('id', 'desc') // or use 'created_at' if available
                                                ->first();

                                                //echo "<pre>";print_r($latestQuote);echo"</pre>";
                        @endphp
                        <div class="card card-rounded  booking_detail mb-4">
                            <h5 class="mb-3">Vendor Details</h5>
                            <ul class="list-unstyled mb-3">
                                
                                @if(isset($vendorData->name))
                                <li><strong>Name:</strong> <span class="right">{{$vendorData->name}}</span></li>
                                @endif
                                @if(isset($vendorData->email))
                                <li><strong>Email:</strong> <span class="right">{{$vendorData->email}}</span></li>
                                @endif
                                @if(isset($vendorData->mobile))
                                <li><strong>Mobile:</strong> <span class="right">{{$vendorData->mobile}}</span></li>
                                @endif

                                @if(isset($latestQuote->qoute))
                                <li><strong>Quote Amount:</strong> <span class="right"><span class="currency_dhiram"></span> {{$latestQuote->qoute}}</span></li>
                                @endif
                        
                            </ul>
                        </div>
                     @endforeach
                @endif   

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
