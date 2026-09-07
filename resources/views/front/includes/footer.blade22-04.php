                            <!-- Our Footer -->
                            <section class="footer-style1 at-home5 pt25 pb-0" style="background-color: #222222;">

                                {{-- <div class="web_whatsapp">
        <a href="https://web.whatsapp.com/send?phone=9710568363677" target="_blank"><i class="fab fa-whatsapp"></i></a>
    </div> --}}
                                <div class="web_whatsapp">
                                    <a href="" id="whatsappButton" target="_blank"><i
                                            class="fab fa-whatsapp"></i></a>
                                </div>

                                <style>
                                    .footer-logo {
                                        width: 30% !important;
                                    }

                                    @media only screen and (max-width: 768px) {
                                        .footer-logo {
                                            width: 67% !important;
                                        }
                                    }
                                </style>

                                <div class="container">
                                    <!--<div class="row bdrb1 pb10 mb60">
            <div class="col-md-7">
                <div
                    class="d-block text-center text-md-start justify-content-center justify-content-md-start d-md-flex align-items-center mb-3 mb-md-0">
                    <a class="fz17 fw500 mr15-md mr30" href="{{ route('term_condition') }}" style="color: #fff;">Terms of Service</a>
                    <a class="fz17 fw500 mr15-md mr30" href="{{ route('privacy_policy') }}" style="color: #fff;">Privacy Policy</a>
                    <a class="fz17 fw500" href="" style="color: #fff;">Site Map</a>
                </div>
            </div>
            <div class="col-md-5">
                <div class="social-widget text-center text-md-end">
                    <div class="social-style1 light-style2">
                        <a class="me-2 fw500 fz17" href="" style="color: #fff;">Follow us</a>
                        
      <a href="https://www.facebook.com/myvendorscity" target="_blank">
      <i class="fab fa-facebook-f list-inline-item" style="color: #fff;"></i>
      </a>
      
                        <a href="https://x.com/myvendorsCity" target="_blank" style="padding: 0 10px 0px 10px;">
      <img src="{{ asset('/public/site/images/twitter.png') }}"
                                style="height: 15px;width: 16px;margin-top: -4px;">
                        </a>
      
                        {{-- <a href=""><i class="fa-brands fa-square-x-twitter list-inline-item"></i></a> --}}
                        
      <a href="https://www.instagram.com/myvendorscity/" target="_blank">
      <i class="fab fa-instagram list-inline-item" style="color: #fff;"></i>
      </a>
      
                        <a href="https://www.linkedin.com/company/vendorscity/" target="_blank">
      <i class="fab fa-linkedin-in list-inline-item" style="color: #fff;"></i>
      </a>
      
                    </div>
                </div>
            </div>
        </div>-->
                                    {{-- <h1 class="mb25" style="color: #fff;font-size: 60px;">VendorsCity</h1> --}}
                                    <img class="mb25 footer-logo"
                                        src="{{ asset('public/site/images/footer-logo.svg') }}" alt="Footer Logo">
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="link-style1 light-style at-home8 mb-4 mb-sm-5">
                                                <h4 class="mb15" style="color: #fff;">About VendorsCity</h4>
                                                <div class="link-list">
                                                    <a href="{{ route('about_us') }}" style="color: #eee;">About Us</a>
                                                    <li><a href="{{ route('contact') }}" style="color: #eee;">Contacting
                                                            VendorsCity</a></li>
                                                    <a href="{{ route('careers') }}" style="color: #eee;">Careers
                                                        Opportunities</a>
                                                    <a style="color: #eee;"
                                                        href="{{ route('payment_refund_policy') }}">Payment & Refund
                                                        Policy</a>
                                                    <a href="{{ url('/blog') }}" style="color: #eee;">Blogs</a>
                                                    <a href="{{ url('/services') }}" style="color: #eee;">Services</a>
                                                    <a href="{{ url('/our-vendors') }}" style="color: #eee;">Our
                                                        Vendors</a>
                                                    <!-- <a href="">Partnerships</a>
                        <a href="{{ route('privacy_policy') }}" style="color: #eee;">Privacy Policy</a>
                        <a href="{{ route('term_condition') }}" style="color: #eee;">Terms of Service</a>-->
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $service_data = DB::table('services')
                                                ->where('is_active', 0)
                                                ->orderBy('set_order')
                                                ->get();
                                        @endphp
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="link-style1 light-style at-home8 mb-4 mb-sm-5">
                                                <h4 class="mb15" style="color: #fff;">Services</h4>
                                                <ul class="ps-0">
                                                    @foreach ($service_data as $service)
                                                        <li><a href="{{ route('front.subservices', ['city' => session('search_city_name'), 'page_url' => $service->page_url]) }}"
                                                                style="text-decoration: none;color: #eee;">{{ $service->servicename }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <!--<div class="col-sm-6 col-lg-3">
                <div class="link-style1 light-style at-home8 mb-4 mb-sm-5">
                    <h4 class="mb15" style="color: #fff;">Support</h4>
                    <ul class="ps-0">
                        <li><a href="" style="color: #eee;">Help & Support</a></li>
                        <li><a href="" style="color: #eee;">Trust & Safety</a></li>
                        <li><a href="" style="color: #eee;">Selling on Vendorscity</a></li>
                        <li><a href="" style="color: #eee;">Buying on Vendorscity</a></li>
                    </ul>
                </div>
            </div>-->
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="link-style1 light-style at-home8 mb-4 mb-sm-5">
                                                <h4 class="mb15" style="color: #fff;">For Customers</h4>
                                                <ul class="ps-0">
                                                    @php
                                                        $userdata = Session::get('user');
                                                    @endphp
                                                    @if (isset($userdata))
                                                        <li><a href="{{ url('/my-profile') }}"
                                                                style="color: #eee;">Manage Your Account</a></li>
                                                    @else
                                                        <li><a href="{{ url('/Sign-in') }}" style="color: #eee;">Manage
                                                                Your Account</a></li>
                                                    @endif

                                                    @if (isset($userdata))
                                                        <li><a href="{{ url('/refer&earn') }}"
                                                                style="color: #eee;">Refer & Earn</a></li>
                                                    @else
                                                        <li><a href="{{ url('/Sign-in') }}"
                                                                style="color: #eee;">Refer & Earn</a></li>
                                                    @endif

                                                    <li><a href="https://www.google.com/search?q=vendorscity+dubai&sca_esv=e472bba1732e8ddb&sca_upv=1&rlz=1C5CHFA_enAE1014AE1015&sxsrf=ADLYWIKMm77ohxWtSjtB2FywHuiQPICeBA%3A1716628559794&ei=T6xRZquOMNCVxc8Ph-eCsAo&ved=0ahUKEwjr8ZHcu6iGAxXQSvEDHYezAKYQ4dUDCBA&uact=5&oq=vendorscity+dubai&gs_lp=Egxnd3Mtd2l6LXNlcnAiEXZlbmRvcnNjaXR5IGR1YmFpMgQQIxgnMggQABgIGA0YHjIIEAAYCBgNGB4yCBAAGAgYDRgeMgsQABiABBiGAxiKBTILEAAYgAQYhgMYigUyCxAAGIAEGIYDGIoFMgsQABiABBiGAxiKBTIIEAAYgAQYogQyCBAAGIAEGKIESMAKUMoEWN8GcAF4AZABAJgB_wGgAcYDqgEFMC4xLjG4AQPIAQD4AQGYAgOgAtMDwgIKEAAYsAMY1gQYR8ICBxAAGIAEGA3CAggQABgFGA0YHsICChAAGAUYDRgeGA-YAwDiAwUSATEgQIgGAZAGCJIHBTEuMC4yoAeUEA&sclient=gws-wiz-serp#lrd=0x4c30ffdf4bf81567:0xaf176b54bfc73c00,1"
                                                            style="color: #eee;">VC Reviews</a></li>
                                                </ul>
                                                <h4 class="mb15" style="color: #fff;">For Vendors</h4>
                                                <ul class="ps-0">
                                                    <li><a href="{{ url('/become-a-vendor') }}""
                                                            style="color: #eee;">Become a Vendor</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="link-style1 light-style at-home8 mb-4 mb-sm-5">
                                                <h4 class="mb15" style="color: #fff;">Get in Touch With Us</h4>
                                                {{-- <ul class="ps-0">
                    <li style="color: #eee;">
                        Bardab - Al Quoz 3 - Owned by Dubai Investment Fund 24TF-A-BLK Office No.
                    </li>
					<li style="color: #eee;"> <i class="fas fa-phone" style="color: #fff; margin-right: 5px;"></i><a href="tel:+971508807610" style="color: #eee; text-decoration: none;display:unset;">+971 50 880 7610</a></li>
					</ul> --}}
                                                <ul class="ps-0">
                                                    <li><a href="mailto:support@vendorscity.com"
                                                            style="color: #eee;">support@vendorscity.com</a></li>
                                                    <li style="color: #eee;">056 VENDORS (836 3677)</li>
                                                </ul>
                                                <h4 class="mb15" style="color: #fff;">Social Links</h4>
                                                <div class="social-widget text-center text-md-end">
                                                    <div class="social-style1 light-style2"
                                                        style="text-align: initial;">
                                                        <a href="https://www.facebook.com/myvendorscity"
                                                            target="_blank" style="display: initial;">
                                                            <i class="fab fa-facebook-f list-inline-item"
                                                                style="color: #fff;"></i>
                                                        </a>

                                                        <a href="https://x.com/myvendorsCity" target="_blank"
                                                            style="padding: 0 10px 0px 10px;display: initial;">
                                                            <img src="{{ asset('/public/site/images/twitter.png') }}"
                                                                style="height: 15px;width: 16px;margin-top: -4px;">
                                                        </a>

                                                        {{-- <a href=""><i class="fa-brands fa-square-x-twitter list-inline-item"></i></a> --}}

                                                        <a href="https://www.instagram.com/myvendorscity/"
                                                            target="_blank" style="display: initial;">
                                                            <i class="fab fa-instagram list-inline-item"
                                                                style="color: #fff;"></i>
                                                        </a>

                                                        <a href="https://www.linkedin.com/company/vendorscity/"
                                                            target="_blank" style="display: initial;">
                                                            <i class="fab fa-linkedin-in list-inline-item"
                                                                style="color: #fff;"></i>
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="text-center">
                                                <p class="copyright-text mb-2 mb-md0 text-dark-light ff-heading"
                                                    style="color: #eee;">
                                                    <a class="fz17 fw500 mr15-md mr30"
                                                        href="{{ route('term_condition') }}"
                                                        style="color: #fff;">Terms of Service</a>
                                                    <a class="fz17 fw500 mr15-md mr30"
                                                        href="{{ route('privacy_policy') }}"
                                                        style="color: #fff;">Privacy Policy</a>
                                                    <a class="fz17 fw500" href="" style="color: #fff;">Site
                                                        Map</a><br>Copyright © {{ date('Y') }} VendorsCity. All
                                                    rights reserved.
                                                </p>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6">
            <div class="footer_bottom_right_btns at-home8 text-center text-lg-end">
              <ul class="p-0 m-0">
                <li class="list-inline-item bg-white">
                  <select class="selectpicker show-tick">
                    <option>US$ USD</option>
                    <option>Euro</option>
                    <option>Pound</option>
                  </select>
                </li>
                <li class="list-inline-item bg-white">
                  <select class="selectpicker show-tick">
                    <option>English</option>
                    <option>Frenc</option>
                    <option>Italian</option>
                    <option>Spanish</option>
                    <option>Turkey</option>
                  </select>
                </li>
              </ul>
            </div>
          </div> -->
                                    </div>
                                </div>
                            </section>
                            {{-- <a class="scrollToHome" href="#" style="background: #fff;"><i class="fas fa-angle-up" style="color: #000;"></i></a> --}}


                            </div>
                            </div>
                            <!-- Wrapper End -->
                            <script src="{{ asset('public/site/js/jquery-3.6.4.min.js') }}"></script>
                            @if (Session::get('L_strsucessMessage') != '')
                                <script>
                                    (function($) {
                                        $(document).on('ready', function() {
                                            document.getElementById('message_succsess').innerHTML =
                                                "{{ Session::get('L_strsucessMessage') }}";
                                            setTimeout(function() {
                                                $("#message_succsess").show('blind', {}, 500)
                                            }, 5000);
                                            setTimeout(function() {
                                                $("#message_succsess").hide('blind', {}, 900)
                                            }, 9000);
                                        });
                                    })(window.jQuery);
                                </script>
                            @endif


                            <script src="{{ asset('public/site/js/jquery-migrate-3.0.0.min.js') }}"></script>
                            {{-- <script src="{{ asset('public/site/js/popper.min.js') }}"></script> --}}
                            <script src="{{ asset('public/site/js/bootstrap.min.js') }}"></script>
                            <script src="{{ asset('public/site/js/bootstrap-select.min.js') }}"></script>
                            <script src="{{ asset('public/site/js/jquery.mmenu.all.js') }}"></script>
                            <script src="{{ asset('public/site/js/ace-responsive-menu.js') }}"></script>
                            <script src="{{ asset('public/site/js/jquery-scrolltofixed-min.js') }}"></script>
                            <script src="{{ asset('public/site/js/wow.min.js') }}"></script>
                            <script src="{{ asset('public/site/js/owl.js') }}"></script>
                            <script src="{{ asset('public/site/js/jquery.counterup.js') }}"></script>
                            <script src="{{ asset('public/site/js/intlTelInput.min.js') }}"></script>
                            {{-- <script src="{{ asset('public/site/js/isotop.js') }}"></script> --}}
                            <script src="{{ asset('public/site/js/scrollbalance.js') }}"></script>
                            <script src="{{ asset('public/site/js/scrollbalance_new.js') }}"></script>
                            <!-- Custom script for all pages -->
                            <script src="{{ asset('public/site/js/script.js') }}"></script>
                            <script src="{{ asset('public/site/js/owl.carousel.min.js') }}"></script>
                            <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
                            {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script> --}}

                            <script>
                                window.Enums = {
                                    vcCharges: @json($vcChargesEnum)
                                };
                            </script>


                            <!-- Select2 JS -->

                            <script src="{{ asset('public/site/js/select2.min.js') }}"></script>

                            <script type="text/javascript">
                                function remove_to_cart(rowId) {

                                    var answer = window.confirm("Do you want to remove this Package from cart?");

                                    if (answer) {
                                        var url = '{{ url('cart_remove') }}';
                                        $.ajax({
                                            url: url,
                                            type: 'post',
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                "rowId": rowId
                                            },
                                            success: function(msg) {

                                                if (msg != '') {
                                                    $("#message_error").html("Package Removed From Cart");
                                                    $('#message_error').show().delay(0).fadeIn('show');
                                                    $('#message_error').show().delay(2000).fadeOut('show');
                                                    $("#mydiv_pc").load(location.href + " #mydiv_pc");
                                                    //  $("#header_cart").load(location.href + " #header_cart");
                                                    // $("#header_cart_count").load(location.href + " #header_cart_count");
                                                    return false;
                                                }

                                            }

                                        });
                                    }
                                }

                                function add_to_cart(package_id) {

                                    var qty = 1;

                                    $.ajax({

                                        type: 'POST',
                                        url: '{{ url('add_to_cart ') }}',
                                        data: {

                                            "_token": "{{ csrf_token() }}",
                                            'qty': qty,
                                            'package_id': package_id,

                                        },

                                        success: function(msg) {
                                            if (msg != 0) {
                                                // $("#header_cart").load(location.href + " #header_cart");
                                                // $("#header_cart_count").load(location.href + " #header_cart_count");
                                                // $("#message_succsess").html("Package Added To Cart");
                                                // $('#message_succsess').show().delay(0).fadeIn('show');
                                                // $('#message_succsess').show().delay(2000).fadeOut('show');
                                                $(".addtocart-btn_" + package_id).hide();
                                                $(".loader-test_" + package_id).show();
                                                setTimeout(function() {
                                                    window.location.href = "{{ route('cart') }}";
                                                    $(".addtocart-btn_" + package_id).show();
                                                    $(".loader-test_" + package_id).hide();
                                                }, 2000);
                                                return false;
                                            }
                                        }
                                    });

                                }

                                function validation_subs() {

                                    var email = $("#subs_email").val();
                                    if (email == '') {
                                        $("#validation_error").html("Please Enter Email Address");
                                        $('#validation_error').show().delay(0).fadeIn('show');
                                        $('#validation_error').show().delay(2000).fadeOut('show');
                                        return false;
                                    }

                                    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                                    if (!filter.test(email)) {
                                        jQuery('#validation_error').html("Please Enter Valid E-mail.");
                                        jQuery('#validation_error').show().delay(0).fadeIn('show');
                                        jQuery('#validation_error').show().delay(2000).fadeOut('show');
                                        return false;
                                    }

                                    var url = "{{ url('check_email') }}";

                                    $.ajax({
                                        url: url,
                                        type: 'post',
                                        data: {
                                            '_token': '{{ csrf_token() }}',
                                            'email': email
                                        },
                                        success: function(returndata) {
                                            //alert(returndata);
                                            if (returndata == 0) {
                                                $("#validation_error").html("Email Address Already Exists");
                                                $('#validation_error').show().delay(0).fadeIn('show');
                                                $('#validation_error').show().delay(2000).fadeOut('show');
                                                return false;
                                            } else {

                                                $('#news_letter').submit();
                                            }
                                        }
                                    });
                                }
                            </script>
                            @php
                                $subservices_he = DB::table('subservices')
                                    ->where('is_active', 0)
                                    ->orderBy('set_order', 'ASC')
                                    ->get();
                            @endphp

                            <script>
                                function search_banner_header() {


                                    var search_auto_header = jQuery("#search_auto_header").val();
                                    if (search_auto_header == '') {

                                        jQuery('#search_auto_header_error').html("Please Enter Some Service");
                                        jQuery('#search_auto_header_error').show().delay(0).fadeIn('show');
                                        jQuery('#search_auto_header_error').show().delay(2000).fadeOut('show');
                                        $('html, body').animate({
                                            scrollTop: $('#search_auto_header').offset().top - 150
                                        }, 1000);
                                        return false;

                                    }
                                    $('#search_banner_header').submit();
                                }

                                let names_header = [];
                                @if ($subservices_he != '')
                                    @foreach ($subservices_he as $subservices_he_data)
                                        names_header.push("{{ $subservices_he_data->subservicename }}");
                                    @endforeach
                                @endif

                                let sortedNames = names_header.sort();
                                let input = document.getElementById("search_auto_header");


                                input.addEventListener("keyup", (e) => {
                                    // Clear previous results
                                    removeElements_new();

                                    // Get the input value and convert it to lowercase
                                    let inputValue = input.value.toLowerCase();

                                    // Loop through sortedNames array
                                    for (let i of sortedNames) {
                                        // Convert current element `i` to lowercase
                                        let lowercaseName = i.toLowerCase();

                                        // Check if the input value is found anywhere in the lowercaseName
                                        if (lowercaseName.includes(inputValue) && inputValue !== "") {
                                            // Create li element
                                            let listItem = document.createElement("li");
                                            listItem.classList.add("list-items");
                                            listItem.style.cursor = "pointer";
                                            listItem.setAttribute("onclick", "displayNames_new('" + i + "')");

                                            // Highlight the matching part
                                            let startIndex = lowercaseName.indexOf(inputValue);
                                            let matchedPart = i.substr(startIndex, inputValue.length);
                                            let remainder = i.substr(startIndex + inputValue.length);

                                            // Display matched part in bold
                                            listItem.innerHTML = i.substr(0, startIndex) + "<b>" + matchedPart + "</b>" + remainder;

                                            // Append list item to the list
                                            document.querySelector(".list_header").appendChild(listItem);
                                        }
                                    }
                                });

                                function displayNames_new(value) {
                                    input.value = value;
                                    removeElements_new();
                                    var currentUrl = window.location.href;
                                    // alert(val);
                                    $('#currentUrl_header').val(currentUrl);
                                    //$('#search_banner_header').submit();
                                }

                                function removeElements_new() {
                                    //clear all the item
                                    let items = document.querySelectorAll(".list-items");
                                    items.forEach((item) => {
                                        item.remove();
                                    });
                                }

                                function search_city_header(val) {

                                    var currentUrl = window.location.href;
                                    // alert(val);
                                    $('#currentUrl_header').val(currentUrl);
                                    $('#search_city_header').val(val);
                                    $('#search_banner_header').submit();
                                }



                                let names_mobile = [];
                                @if ($subservices_he != '')
                                    @foreach ($subservices_he as $subservices_he_data)
                                        names_mobile.push("{{ $subservices_he_data->subservicename }}");
                                    @endforeach
                                @endif

                                let sortedNames_mobile = names_mobile.sort();
                                let input_mobile = document.getElementById("search_auto_mobile");


                                input_mobile.addEventListener("keyup", (e) => {
                                    // Clear previous results
                                    removeElements_new();

                                    // Get the input value and convert it to lowercase
                                    let inputValue = input_mobile.value.toLowerCase();

                                    // Loop through sortedNames array
                                    for (let i of sortedNames_mobile) {
                                        // Convert current element `i` to lowercase
                                        let lowercaseName = i.toLowerCase();

                                        // Check if the input value is found anywhere in the lowercaseName
                                        if (lowercaseName.includes(inputValue) && inputValue !== "") {
                                            // Create li element
                                            let listItem = document.createElement("li");
                                            listItem.classList.add("list-items");
                                            listItem.style.cursor = "pointer";
                                            listItem.setAttribute("onclick", "displayNames_mobile('" + i + "')");

                                            // Highlight the matching part
                                            let startIndex = lowercaseName.indexOf(inputValue);
                                            let matchedPart = i.substr(startIndex, inputValue.length);
                                            let remainder = i.substr(startIndex + inputValue.length);

                                            // Display matched part in bold
                                            listItem.innerHTML = i.substr(0, startIndex) + "<b>" + matchedPart + "</b>" + remainder;

                                            // Append list item to the list
                                            document.querySelector(".list_mobile").appendChild(listItem);
                                        }
                                    }
                                });

                                function displayNames_mobile(value) {
                                    input_mobile.value = value;
                                    removeElements_new();
                                    var currentUrl = window.location.href;
                                    // alert(val);
                                    $('#currentUrl_mobile').val(currentUrl);
                                    //$('#search_banner_header').submit();
                                }

                                function removeElements_new() {
                                    //clear all the item
                                    let items = document.querySelectorAll(".list-items");
                                    items.forEach((item) => {
                                        item.remove();
                                    });
                                }

                                function search_city_mobile(val) {

                                    var currentUrl = window.location.href;
                                    // alert(val);
                                    $('#currentUrl_mobile').val(currentUrl);
                                    $('#search_city_mobile_id').val(val);
                                    $('#search_banner_mobile').submit();
                                }
                            </script>
                            <script>
                                // JavaScript to open WhatsApp
                                document.getElementById('whatsappButton').addEventListener('click', function() {
                                    const phoneNumber = "971503204846"; // Replace with your WhatsApp number
                                    const message = ""; // Replace with your default message

                                    // Open WhatsApp in a new tab
                                    window.open(`https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`, '_blank');
                                });
                            </script>

                            <script>
                                /* When the user clicks on the button, 
                                                                                                                                                                                                                                                                                                                        toggle between hiding and showing the dropdown content */
                                function myFunction() {
                                    document.getElementById("myDropdownnew").classList.toggle("show-new");
                                }

                                // Close the dropdown if the user clicks outside of it
                                window.onclick = function(event) {
                                    if (!event.target.matches('.dropbtnnew')) {
                                        var dropdowns = document.getElementsByClassName("dropdown-content-new");
                                        var i;
                                        for (i = 0; i < dropdowns.length; i++) {
                                            var openDropdown = dropdowns[i];
                                            if (openDropdown.classList.contains('show-new')) {
                                                openDropdown.classList.remove('show-new');
                                            }
                                        }
                                    }
                                }
                            </script>


                            <script>
                                /* document.addEventListener("DOMContentLoaded", function () {
                                                                                                                                                                                                                                                                                                                        const Otpphoneinput = document.querySelector("#otp_phone_number"); // flagphone
                                                                                                                                                                                                                                                                                                                        const Otpphoneinputnew = window.intlTelInput(Otpphoneinput, {
                                                                                                                                                                                                                                                                                                                            initialCountry: "ae",  // UAE
                                                                                                                                                                                                                                                                                                                            separateDialCode: true,
                                                                                                                                                                                                                                                                                                                            autoPlaceholder: "aggressive",
                                                                                                                                                                                                                                                                                                                            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
                                                                                                                                                                                                                                                                                                                        });

                                                                                                                                                                                                                                                                                                                        // Assign globally to avoid the ReferenceError
                                                                                                                                                                                                                                                                                                                        window.Otpphoneinputnew = Otpphoneinputnew;
                                                                                                                                                                                                                                                                                                                    }); */

                                document.addEventListener("DOMContentLoaded", function() {
                                    const Otpphoneinput = document.querySelector("#otp_phone_number");

                                    const Otpphoneinputnew = window.intlTelInput(Otpphoneinput, {
                                        initialCountry: "ae", // UAE
                                        separateDialCode: true,
                                        autoPlaceholder: "aggressive",
                                        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
                                    });

                                    // Assign globally
                                    window.Otpphoneinputnew = Otpphoneinputnew;

                                    // Update hidden country code when user selects a country
                                    const countryCodeInput = document.querySelector("#country_code_otp_popup_Modal");

                                    function setCountryCode() {
                                        const countryData = Otpphoneinputnew.getSelectedCountryData();
                                        countryCodeInput.value = countryData.dialCode; // store only dial code (e.g. 971)
                                        // If you want full ISO code (like 'AE') → use countryData.iso2
                                    }

                                    // Set default initially
                                    setCountryCode();

                                    // Listen to country change
                                    Otpphoneinput.addEventListener("countrychange", function() {
                                        setCountryCode();
                                    });
                                });


                                document.addEventListener("DOMContentLoaded", function() {
                                    const Otpphoneinput1 = document.querySelector("#email_mobile");

                                    const Otpphoneinputnew1 = window.intlTelInput(Otpphoneinput1, {
                                        initialCountry: "ae", // UAE
                                        separateDialCode: true,
                                        autoPlaceholder: "aggressive",
                                        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
                                    });

                                    // Assign globally
                                    window.Otpphoneinputnew1 = Otpphoneinputnew1;

                                    // Update hidden country code when user selects a country
                                    const countryCodeInput = document.querySelector("#country_code_email_popup_Modal");

                                    function setCountryCode() {
                                        const countryData = Otpphoneinputnew1.getSelectedCountryData();
                                        countryCodeInput.value = countryData.dialCode; // store only dial code (e.g. 971)
                                        // If you want full ISO code (like 'AE') → use countryData.iso2
                                    }

                                    // Set default initially
                                    setCountryCode();

                                    // Listen to country change
                                    Otpphoneinput1.addEventListener("countrychange", function() {
                                        setCountryCode();
                                    });
                                });




                                // Function to get the selected country code
                                function getCountryCode() {
                                    const otpcountryData = window.Otpphoneinputnew.getSelectedCountryData();
                                    const otpcountryCode = otpcountryData.dialCode;
                                    return otpcountryCode;
                                }


                                function validateNumber(event) {
                                    var key = window.event ? event.keyCode : event.which;
                                    if (event.keyCode === 8 || event.keyCode === 46) {
                                        return true;
                                    } else if (key < 48 || key > 57) {
                                        return false;
                                    } else {
                                        return true;
                                    }
                                }



                                document.addEventListener('DOMContentLoaded', function() {
                                    var otpModal = document.getElementById('otp_popup_Modal');

                                    otpModal.addEventListener('show.bs.modal', function() {
                                        // Close mmenu menu if open
                                        if (typeof Mmenu !== 'undefined') {
                                            var menuInstance = document.querySelector('#menu')?.mmApi;
                                            if (menuInstance) {
                                                menuInstance.close();
                                            }
                                        }
                                        document.querySelector('.mm-wrapper__blocker')?.click(); // Simulate click on blocker
                                    });
                                });

                                function goToOtpVerification(id) {
                                    // STEP 1: Mobile Input
                                    if (id == '1') {
                                        var mobile = jQuery("#otp_phone_number").val().trim();

                                        const selectedCountryCode = getCountryCode();
                                        $("#country_code").val(selectedCountryCode);
                                        if (mobile == '') {

                                            jQuery('#otp_phone_error').html("Please Enter Mobile No");
                                            jQuery('#otp_phone_error').show().delay(0).fadeIn('show');
                                            jQuery('#otp_phone_error').show().delay(2000).fadeOut('show');
                                            return false;

                                        }
                                        if (mobile != '') {
                                            // var filter = /^\d{7}$/;
                                            if (mobile.length < 7 || mobile.length > 15) {
                                                jQuery('#otp_phone_error').html("Please Enter Valid Mobile Number");
                                                jQuery('#otp_phone_error').show().delay(0).fadeIn('show');
                                                jQuery('#otp_phone_error').show().delay(2000).fadeOut('show');
                                                return false;
                                            }
                                        }

                                        var url = '{{ url('otp-sent') }}';
                                        var mobile = $('#otp_phone_number').val();
                                        var country_code = $('#country_code_otp_popup_Modal').val();
                                        $.ajax({
                                            url: url,
                                            type: 'POST',
                                            data: {
                                                _token: '{{ csrf_token() }}',
                                                'mobile': mobile,
                                                'country_code': country_code
                                            },
                                            beforeSend: function() {

                                                $('#spinner_button_phone1').show();
                                                $('#submit_button_phone1').hide();
                                                //$('.detail-continue-btn').prop('disabled', true);
                                            },
                                            success: function(response) {

                                                if (response.success === true) {

                                                    $("#refresh_otp_div").load(location.href + " #refresh_otp_div");

                                                    document.getElementById('step-phone').style.display = 'none';
                                                    document.getElementById('step-otp').style.display = 'block';
                                                    document.getElementById('modalStepTitle').innerText = "Verify your phone number";

                                                    $('#whatsapp-number').text('+' + country_code + mobile);

                                                    if (response.user_data) {
                                                        $('#user_name').val(response.user_data.name);
                                                        $('#user_email').val(response.user_data.email);
                                                    }

                                                }

                                                $('#spinner_button_phone1').hide();
                                                $('#submit_button_phone1').show();


                                            },
                                            error: function(xhr) {

                                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                                    alert(xhr.responseJSON.message);
                                                    $('#otp_popup_Modal').modal('hide');

                                                } else {
                                                    alert("Failed to send OTP. Please try again.");
                                                    $('#otp_popup_Modal').modal('hide');
                                                }

                                            },
                                            complete: function() {
                                                // Re-enable button
                                                $('.detail-continue-btn').prop('disabled', false);
                                            }
                                        });

                                        return false;


                                    }

                                    // STEP 2: OTP Verification
                                    if (id == '2') {
                                        var allFilled = true;
                                        jQuery('.otp-input').each(function() {
                                            if (jQuery(this).val().trim() === '') {
                                                allFilled = false;
                                            }
                                        });

                                        if (!allFilled) {
                                            jQuery('#otp_error').html("Please Enter OTP");
                                            jQuery('#otp_error').show().delay(0).fadeIn('show');
                                            jQuery('#otp_error').show().delay(2000).fadeOut('show');
                                            return false;
                                        }

                                        let otp = $('#session_otp').val();
                                        let enteredOtp = '';
                                        document.querySelectorAll('.otp-input').forEach(input => {
                                            enteredOtp += input.value;
                                        });
                                        // alert(otp);

                                        if (otp != enteredOtp) {
                                            jQuery('#otp_error').html("OTP doesn't match");
                                            jQuery('#otp_error').show().delay(0).fadeIn('show');
                                            jQuery('#otp_error').show().delay(2000).fadeOut('show');
                                            return false;
                                        }



                                        let name = jQuery("input[name='name']").val().trim();
                                        let email = jQuery("input[name='email']").val().trim();

                                        $('#spinner_button_phone2').show();
                                        $('#submit_button_phone2').hide();

                                        if (name !== '' && email !== '') {
                                            // Both fields are filled, submit form directly
                                            jQuery("#OtpForm").submit();
                                        } else {
                                            // One or both fields are empty, show Step 3
                                            document.getElementById('step-otp').style.display = 'none';
                                            document.getElementById('step-details').style.display = 'block';
                                            document.getElementById('modalStepTitle').innerText = "Personal Details";
                                        }
                                    }

                                    // STEP 3: Personal Details
                                    if (id == '3') {
                                        var name = jQuery("input[name='name']").val().trim();
                                        var email = jQuery("input[name='email']").val().trim();
                                        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                                        if (name === '') {

                                            jQuery('#name_error').html("Please Enter Full  Name");
                                            jQuery('#name_error').show().delay(0).fadeIn('show');
                                            jQuery('#name_error').show().delay(2000).fadeOut('show');
                                            return false;
                                        }
                                        if (email === '') {
                                            jQuery('#email_error').html("Please Enter email");
                                            jQuery('#email_error').show().delay(0).fadeIn('show');
                                            jQuery('#email_error').show().delay(2000).fadeOut('show');
                                            return false;
                                        }

                                        if (!emailRegex.test(email)) {
                                            jQuery('#email_error').html("Please Enter Valid email");
                                            jQuery('#email_error').show().delay(0).fadeIn('show');
                                            jQuery('#email_error').show().delay(2000).fadeOut('show');
                                            return false;
                                        }

                                        $('#spinner_button_phone3').show();
                                        $('#submit_button_phone3').hide();

                                        // All validation passed, submit the form
                                        jQuery("#OtpForm").submit();
                                    }
                                }

                                $(document).ready(function() {
                                    $('.otp-input').on('input', function() {
                                        let input = $(this);
                                        let value = input.val();
                                        if (/^\d$/.test(value)) {
                                            input.next('.otp-input').focus();
                                        } else {
                                            input.val('');
                                        }
                                    });

                                    $('.otp-input').on('keydown', function(e) {
                                        let input = $(this);
                                        if (e.key === "Backspace" && input.val() === '') {
                                            input.prev('.otp-input').focus();
                                        }
                                    });

                                    $('.otp-input').on('paste', function(e) {
                                        let data = e.originalEvent.clipboardData.getData('text');
                                        let digits = data.replace(/\D/g, '').substring(0, 6).split('');
                                        $('.otp-input').each(function(index, element) {
                                            $(element).val(digits[index] || '');
                                        });
                                        if (digits.length > 0) {
                                            $('.otp-input').eq(digits.length - 1).focus();
                                        }
                                        e.preventDefault();
                                    });
                                });

                                function email_goToOtpVerification(id) {

                                    if (id == '1') {

                                        var email_email = jQuery("input[name='email_email']").val().trim();
                                        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                        if (email_email === '') {
                                            jQuery('#email_email_error').html("Please Enter email");
                                            jQuery('#email_email_error').show().delay(0).fadeIn('show');
                                            jQuery('#email_email_error').show().delay(2000).fadeOut('show');
                                            return false;
                                        }

                                        if (!emailRegex.test(email_email)) {
                                            jQuery('#email_email_error').html("Please Enter Valid email");
                                            jQuery('#email_email_error').show().delay(0).fadeIn('show');
                                            jQuery('#email_email_error').show().delay(2000).fadeOut('show');
                                            return false;
                                        }



                                        var url = '{{ route('home.email-otp-sent') }}';
                                        var mobile = $('#otp_phone_number').val();
                                        var country_code = $('#country_code').val();
                                        $.ajax({
                                            url: url,
                                            type: 'POST',
                                            data: {
                                                _token: '{{ csrf_token() }}',
                                                'email_email': email_email
                                            },
                                            beforeSend: function() {

                                                $('#spinner_button_email1').show();
                                                $('#submit_button_email1').hide();

                                                //$('.email-detail-continue-btn').prop('disabled', true);
                                            },
                                            success: function(response) {

                                                if (response.success === true) {

                                                    $("#email_refresh_otp_div").load(location.href + " #email_refresh_otp_div");

                                                    document.getElementById('email-step-phone').style.display = 'none';
                                                    document.getElementById('email-step-otp').style.display = 'block';
                                                    document.getElementById('email_modalStepTitle').innerText = "Verify your Email";

                                                    $('#email_address_model').text(email_email);

                                                    if (response.user_data) {
                                                        $('#email_name').val(response.user_data.name);
                                                        $('#email_mobile').val(response.user_data.mobile);
                                                        $('#country_code_email_popup_Modal').val(response.user_data.country_code);
                                                    }

                                                }


                                            },
                                            error: function(xhr) {

                                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                                    alert(xhr.responseJSON.message);
                                                    $('#email_otp_popup_Modal').modal('hide');
                                                } else {
                                                    alert("Failed to send OTP. Please try again.");
                                                    $('#email_otp_popup_Modal').modal('hide');
                                                }

                                                $('#spinner_button_email1').hide();
                                                $('#submit_button_email1').show();

                                            },
                                            complete: function() {

                                                $('#spinner_button_email1').hide();
                                                $('#submit_button_email1').show();
                                                // Re-enable button
                                                //$('.email-detail-continue-btn').prop('disabled', false);
                                            }
                                        });

                                    }

                                    // STEP 2: OTP Verification
                                    if (id == '2') {
                                        var allFilled = true;
                                        jQuery('.email-otp-input').each(function() {
                                            if (jQuery(this).val().trim() === '') {
                                                allFilled = false;
                                            }
                                        });

                                        if (!allFilled) {
                                            jQuery('#email_otp_error').html("Please Enter OTP");
                                            jQuery('#email_otp_error').show().delay(0).fadeIn('show');
                                            jQuery('#email_otp_error').show().delay(2000).fadeOut('show');
                                            return false;
                                        }

                                        let otp = $('#email_session_otp').val();
                                        let enteredOtp = '';
                                        document.querySelectorAll('.email-otp-input').forEach(input => {
                                            enteredOtp += input.value;
                                        });
                                        // alert(otp);

                                        if (otp != enteredOtp) {
                                            jQuery('#email_otp_error').html("OTP doesn't match");
                                            jQuery('#email_otp_error').show().delay(0).fadeIn('show');
                                            jQuery('#email_otp_error').show().delay(2000).fadeOut('show');
                                            return false;
                                        }

                                        // document.getElementById('step-otp').style.display = 'none';
                                        // document.getElementById('step-details').style.display = 'block';
                                        // document.getElementById('modalStepTitle').innerText = "Complete your profile";

                                        let email_name = jQuery("input[name='email_name']").val().trim();
                                        let email_mobile = jQuery("input[name='email_mobile']").val().trim();

                                        $('#spinner_button_email2').show();
                                        $('#submit_button_email2').hide();

                                        if (email_name !== '' && email_mobile !== '') {
                                            // Both fields are filled, submit form directly
                                            jQuery("#emailOtpForm").submit();
                                        } else {
                                            // One or both fields are empty, show Step 3
                                            document.getElementById('email-step-otp').style.display = 'none';
                                            document.getElementById('email-step-details').style.display = 'block';
                                            document.getElementById('email_modalStepTitle').innerText = "Personal Details";

                                            $('#spinner_button_email2').hide();
                                            $('#submit_button_email2').show();
                                        }
                                    }

                                    // STEP 3: Personal Details
                                    if (id == '3') {
                                        var email_name = jQuery("input[name='email_name']").val().trim();
                                        var email_mobile = jQuery("input[name='email_mobile']").val().trim();

                                        if (email_name === '') {

                                            jQuery('#email_name_error').html("Please Enter Full  Name");
                                            jQuery('#email_name_error').show().delay(0).fadeIn('show');
                                            jQuery('#email_name_error').show().delay(2000).fadeOut('show');
                                            return false;
                                        }
                                        if (email_mobile === '') {
                                            jQuery('#email_mobile_error').html("Please Enter Mobile Number");
                                            jQuery('#email_mobile_error').show().delay(0).fadeIn('show');
                                            jQuery('#email_mobile_error').show().delay(2000).fadeOut('show');
                                            return false;
                                        }

                                        if (email_mobile != '') {
                                            // var filter = /^\d{7}$/;
                                            if (email_mobile.length < 7 || email_mobile.length > 15) {
                                                jQuery('#email_mobile_error').html("Please Enter Valid Mobile Number");
                                                jQuery('#email_mobile_error').show().delay(0).fadeIn('show');
                                                jQuery('#email_mobile_error').show().delay(2000).fadeOut('show');
                                                return false;
                                            }
                                        }

                                        $('#spinner_button_email3').show();
                                        $('#submit_button_email3').hide();

                                        // All validation passed, submit the form
                                        jQuery("#emailOtpForm").submit();
                                    }
                                }

                                $(document).ready(function() {
                                    $('.email-otp-input').on('input', function() {
                                        let input = $(this);
                                        let value = input.val();
                                        if (/^\d$/.test(value)) {
                                            input.next('.email-otp-input').focus();
                                        } else {
                                            input.val('');
                                        }
                                    });

                                    $('.email-otp-input').on('keydown', function(e) {
                                        let input = $(this);
                                        if (e.key === "Backspace" && input.val() === '') {
                                            input.prev('.email-otp-input').focus();
                                        }
                                    });

                                    $('.email-otp-input').on('paste', function(e) {
                                        let data = e.originalEvent.clipboardData.getData('text');
                                        let digits = data.replace(/\D/g, '').substring(0, 6).split('');
                                        $('.email-otp-input').each(function(index, element) {
                                            $(element).val(digits[index] || '');
                                        });
                                        if (digits.length > 0) {
                                            $('.email-otp-input').eq(digits.length - 1).focus();
                                        }
                                        e.preventDefault();
                                    });
                                });

                                document.addEventListener('DOMContentLoaded', function() {
                                    const otpModal = document.getElementById('otp_popup_Modal');

                                    otpModal.addEventListener('shown.bs.modal', function() {
                                        // Reset to step 1
                                        document.getElementById('step-phone').style.display = 'block';
                                        document.getElementById('email-step-phone').style.display = 'block';
                                        document.getElementById('step-otp').style.display = 'none';
                                        document.getElementById('step-details').style.display = 'none';
                                        document.getElementById('email-step-otp').style.display = 'none';
                                        document.getElementById('email-step-details').style.display = 'none';

                                        // Reset input fields
                                        document.getElementById('otp_phone_number').value = '';
                                        document.getElementById('user_name').value = '';
                                        document.getElementById('user_email').value = '';
                                        document.getElementById('email_email').value = '';
                                        document.getElementById('email_name').value = '';
                                        document.getElementById('email_mobile').value = '';
                                        document.querySelectorAll('.otp-input').forEach(input => input.value = '');
                                        document.querySelectorAll('.email-otp-input').forEach(input => input.value = '');

                                        // Hide errors
                                        document.getElementById('otp_phone_error').style.display = 'none';
                                        document.getElementById('otp_error').style.display = 'none';
                                        document.getElementById('name_error').style.display = 'none';
                                        document.getElementById('email_error').style.display = 'none';
                                        document.getElementById('email_email_error').style.display = 'none';
                                        document.getElementById('email_otp_error').style.display = 'none';
                                        document.getElementById('email_name_error').style.display = 'none';
                                        document.getElementById('email_mobile_error').style.display = 'none';

                                        // Reset spinner buttons and enable primary buttons
                                        ['1', '2', '3'].forEach(step => {
                                            document.getElementById(`spinner_button_phone${step}`).style.display = 'none';
                                            document.getElementById(`submit_button_phone${step}`).style.display =
                                                'inline-block';
                                        });
                                        ['1', '2', '3'].forEach(step => {
                                            document.getElementById(`spinner_button_email${step}`).style.display = 'none';
                                            document.getElementById(`submit_button_email${step}`).style.display =
                                                'inline-block';
                                        });
                                    });
                                });
                            </script>


                            <!-- OTP Popup Start-->
                            <div class="modal modal-mobile-bottom-otp otp-login-form-modal" id="otp_popup_Modal"
                                tabindex="-1" aria-labelledby="otpLabel" aria-hidden="true">
                                <div
                                    class="modal-dialog modal-dialog-bottom-otp user-modal-dialog modal-dialog-centered">
                                    <div class="modal-content details-modal-content">
                                        <div class="modal-header details-header">
                                            <h5 class="modal-title w-100" id="modalStepTitle">Log in or Sign Up</h5>
                                            {{-- <button type="button" class="close closeBtn" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
	  </button> --}}
                                        </div>

                                        <div class="modal-body">
                                            <div id="refresh_otp_div">
                                                <input type="hidden" name="session_otp" id="session_otp"
                                                    value= "{{ session('login-otp') }}">
                                            </div>
                                            <form class="form-horizontal details-form" id="OtpForm" method="POST"
                                                action="{{ route('user-otp-login') }}">
                                                @csrf

                                                <!-- STEP 1: Mobile Input -->
                                                <div id="step-phone">
                                                    <div class="form-group mb-2">
                                                        <label id="mobilename-label">Please Enter Your WhatsApp mobile
                                                            number</label>
                                                        <input type="hidden" name="country_code_otp_popup_Modal"
                                                            id="country_code_otp_popup_Modal" value="">
                                                        <input type="tel" class="input-field" name="phone"
                                                            id="otp_phone_number" placeholder="Mobile No"
                                                            onkeypress="return validateNumber(event)">
                                                        <p id="otp_phone_error" style="display:none;color:red;"></p>
                                                    </div>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        class="email-whatsapp"
                                                        data-bs-target="#email_otp_popup_Modal">Don't have a WhatsApp
                                                        Number? Login with Email</a>
                                                    <div class="text-center mt-3">

                                                        <button
                                                            class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                                            type="button" disabled id="spinner_button_phone1"
                                                            style="display: none;">
                                                            <span class="spinner-border spinner-border-sm"
                                                                role="status" aria-hidden="true"></span>Loading...
                                                        </button>

                                                        <button type="button"
                                                            class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                                            id="submit_button_phone1"
                                                            onclick="goToOtpVerification('1')">Continue</button>
                                                    </div>
                                                </div>

                                                <!-- STEP 2: OTP Verification -->
                                                <div id="step-otp" style="display: none;">
                                                    <label id="mobilename-label">Please enter the <strong>WhatsApp
                                                            code</strong> that was sent to:<br>
                                                        <span id="whatsapp-number">+971 58 520 0722</span>
                                                    </label>

                                                    <div class="d-flex justify-content-center gap-2 my-3">
                                                        <input type="tel" maxlength="1"
                                                            class="otp-input form-control text-center"
                                                            style="width: 40px;">
                                                        <input type="tel" maxlength="1"
                                                            class="otp-input form-control text-center"
                                                            style="width: 40px;">
                                                        <input type="tel" maxlength="1"
                                                            class="otp-input form-control text-center"
                                                            style="width: 40px;">
                                                        <input type="tel" maxlength="1"
                                                            class="otp-input form-control text-center"
                                                            style="width: 40px;">
                                                        <input type="tel" maxlength="1"
                                                            class="otp-input form-control text-center"
                                                            style="width: 40px;">
                                                        <input type="tel" maxlength="1"
                                                            class="otp-input form-control text-center"
                                                            style="width: 40px;">
                                                    </div>
                                                    <p id="otp_error" style="display:none;color:red;"></p>

                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        class="email-whatsapp"
                                                        data-bs-target="#email_otp_popup_Modal">Can't log in? Use your
                                                        Email Address</a>

                                                    <div class="text-center mt-3">
                                                        <button
                                                            class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                                            type="button" disabled id="spinner_button_phone2"
                                                            style="display: none;">
                                                            <span class="spinner-border spinner-border-sm"
                                                                role="status" aria-hidden="true"></span>Loading...
                                                        </button>
                                                        <button type="button"
                                                            class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                                            id="submit_button_phone2"
                                                            onclick="goToOtpVerification('2')">Verify Number</button>
                                                    </div>
                                                </div>

                                                <!-- STEP 3: Personal Details -->
                                                <div id="step-details" style="display: none;">
                                                    <label id="mobilename-label">Contact information</label>
                                                    <div class="form-group mt-3">
                                                        <input type="text" class="form-control" name="name"
                                                            id="user_name" placeholder="Full Name">
                                                        <p id="name_error" style="display:none;color:red;"></p>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <input type="email" class="form-control" id="user_email"
                                                            name="email" placeholder="Email">
                                                        <p id="email_error" style="display:none;color:red;"></p>
                                                    </div>
                                                    <div class="text-center mt-3">
                                                        <button
                                                            class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                                            type="button" disabled id="spinner_button_phone3"
                                                            style="display: none;">

                                                            <span class="spinner-border spinner-border-sm"
                                                                role="status"
                                                                aria-hidden="true"></span>Loading...</button>

                                                        <button type="button"
                                                            class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                                            id="submit_button_phone3"
                                                            onclick="goToOtpVerification('3')">All Done</button>

                                                    </div>

                                                    <div class="mt-3">
                                                        <a href="{{ route('privacy_policy') }}"
                                                            class="footer-link me-3">Privacy Policy</a>
                                                        <a href="{{ route('term_condition') }}"
                                                            class="footer-link">Terms of Service</a>
                                                    </div>

                                                </div>


                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- OTP Popup End-->




                            <!-- email OTP Popup Start-->
                            <div class="modal modal-mobile-bottom-otp otp-login-form-modal" id="email_otp_popup_Modal"
                                tabindex="-1" aria-labelledby="otpLabel" aria-hidden="true">
                                <div
                                    class="modal-dialog modal-dialog-bottom-otp user-modal-dialog modal-dialog-centered">
                                    <div class="modal-content details-modal-content">
                                        <div class="modal-header details-header">
                                            <h5 class="modal-title w-100" id="email_modalStepTitle">Log in or Sign Up
                                            </h5>
                                            {{-- <button type="button" class="close closeBtn" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> --}}
                                        </div>

                                        <div class="modal-body">
                                            <div id="email_refresh_otp_div">
                                                <input type="hidden" name="email_session_otp" id="email_session_otp"
                                                    value= "{{ session('email-login-otp') }}">
                                            </div>
                                            <form class="form-horizontal details-form" id="emailOtpForm"
                                                method="POST" action="{{ route('home.user-email-otp-login') }}">
                                                @csrf

                                                <input type="hidden" name="country_code_email_popup_Modal"
                                                    id="country_code_email_popup_Modal" value="">

                                                <!-- STEP 1: Mobile Input -->
                                                <div id="email-step-phone">
                                                    <div class="form-group mb-2">
                                                        <label id="mobilename-label">Please Enter Your Email
                                                            Address</label>
                                                        <input type="text" class="input-field" name="email_email"
                                                            id="email_email" placeholder="Email Address">
                                                        <p id="email_email_error" style="display:none;color:red;"></p>
                                                    </div>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        class="email-whatsapp" data-bs-target="#otp_popup_Modal">Can't
                                                        access your email? Log in with WhatsApp</a>
                                                    <div class="text-center mt-3">
                                                        <button
                                                            class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                                            type="button" disabled id="spinner_button_email1"
                                                            style="display: none;">

                                                            <span class="spinner-border spinner-border-sm"
                                                                role="status" aria-hidden="true"></span>

                                                            Loading...

                                                        </button>
                                                        <button type="button"
                                                            class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                                            id="submit_button_email1"
                                                            onclick="email_goToOtpVerification('1')">Continue</button>
                                                    </div>
                                                </div>

                                                <!-- STEP 2: OTP Verification -->
                                                <div id="email-step-otp" style="display: none;">
                                                    <label id="mobilename-label">Please enter the <strong>OTP</strong>
                                                        that was sent to:<br>
                                                        <span id="email_address_model">+971 58 520 0722</span>
                                                    </label>

                                                    <div class="d-flex justify-content-center gap-2 my-3">
                                                        <input type="tel" maxlength="1"
                                                            class="email-otp-input form-control text-center"
                                                            style="width: 40px;">
                                                        <input type="tel" maxlength="1"
                                                            class="email-otp-input form-control text-center"
                                                            style="width: 40px;">
                                                        <input type="tel" maxlength="1"
                                                            class="email-otp-input form-control text-center"
                                                            style="width: 40px;">
                                                        <input type="tel" maxlength="1"
                                                            class="email-otp-input form-control text-center"
                                                            style="width: 40px;">
                                                        <input type="tel" maxlength="1"
                                                            class="email-otp-input form-control text-center"
                                                            style="width: 40px;">
                                                        <input type="tel" maxlength="1"
                                                            class="email-otp-input form-control text-center"
                                                            style="width: 40px;">
                                                    </div>
                                                    <p id="email_otp_error" style="display:none;color:red;"></p>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        class="email-whatsapp" data-bs-target="#otp_popup_Modal">Can't
                                                        access your email? Log in with WhatsApp</a>

                                                    <div class="text-center mt-3">
                                                        <button
                                                            class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                                            type="button" disabled id="spinner_button_email2"
                                                            style="display: none;">
                                                            <span class="spinner-border spinner-border-sm"
                                                                role="status"
                                                                aria-hidden="true"></span>Loading...</button>

                                                        <button type="button"
                                                            class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                                            id="submit_button_email2"
                                                            onclick="email_goToOtpVerification('2')">Verify
                                                            Email</button>
                                                    </div>
                                                </div>

                                                <!-- STEP 3: Personal Details -->
                                                <div id="email-step-details" style="display: none;">
                                                    <label id="mobilename-label">Contact information</label>
                                                    <div class="form-group mt-3">
                                                        <input type="text" class="form-control" name="email_name"
                                                            id="email_name" placeholder="Full Name">
                                                        <p id="email_name_error" style="display:none;color:red;"></p>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <input type="tel" class="form-control" id="email_mobile"
                                                            name="email_mobile" placeholder="Phone Number"
                                                            onkeypress="return validateNumber(event)">
                                                        <p id="email_mobile_error" style="display:none;color:red;">
                                                        </p>
                                                    </div>
                                                    <div class="text-center mt-3">
                                                        <button
                                                            class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                                            type="button" disabled id="spinner_button_email3"
                                                            style="display: none;"><span
                                                                class="spinner-border spinner-border-sm"
                                                                role="status"
                                                                aria-hidden="true"></span>Loading...</button>

                                                        <button type="button"
                                                            class="brds50 ud-btn btn-thm default-box-shadow2 detail-continue-btn"
                                                            id="submit_button_email3"
                                                            onclick="email_goToOtpVerification('3')">All Done</button>
                                                    </div>

                                                    <div class="mt-3">
                                                        <a href="{{ route('privacy_policy') }}"
                                                            class="footer-link me-3">Privacy Policy</a>
                                                        <a href="{{ route('term_condition') }}"
                                                            class="footer-link">Terms of Service</a>
                                                    </div>
                                                </div>


                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>



                            </body>

                            </html>
