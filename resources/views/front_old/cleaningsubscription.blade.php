@include('front.includes.header')
<link rel="stylesheet" href="{{ asset('public/site/css/homecleaning.css') }}">
<link rel="stylesheet" href="{{ asset('public/site/css/booknownew.css?v=9') }}">
<link rel="stylesheet" href="{{ asset('public/site/css/homedirham.css?v=8') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- PRICING_RULES_DUMP: {{ json_encode($pricing_rules) }} -->

<link rel="stylesheet" href="{{ asset('public/assets/frontend/css/cleaning-subscription.css') }}?v={{ time() }}">

@php
    $userData = Session::get('user');
    if ($userData && isset($userData['userid'])) {
        $wallet_plus_amount = DB::table('front_user_wallet')
            ->where('refer_id', $userData['userid'])
            ->where('added_from', 0)
            ->sum('wallet_amount');

        $wallet_minus_amount = DB::table('front_user_wallet')
            ->where('refer_id', $userData['userid'])
            ->where('added_from', 1)
            ->sum('wallet_amount');

        $wallet_amount = $wallet_plus_amount - $wallet_minus_amount;
    } else {
        $wallet_amount = 0;
    }
@endphp
<section class="our-register">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="step-header-main mb-4">
                    <div class="step-header" style="font-size: 24px; font-weight: 700; color: #111;">
                        <span id="backArrow" style="cursor: pointer; display: none; margin-right: 8px;" onclick="goBack()">&larr;</span> 
                        <span style="font-size: 16px; color: #555;">Step <span id="currentStepNum">1</span> of <span id="totalStepNum">6</span></span> <br>
                        <span id="stepHeaderTitle" style="display: block; margin-top: 5px; font-size: 18px;">Cleaning Subscription</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Form Area -->
            <div class="col-lg-8 mb-4">
                <div class="main-card" style="padding: 15px; height: 100%;">
                    <form id="subscriptionForm" method="POST" action="{{ route('book_now_subscription') }}">
                        @csrf
                        <input type="hidden" id="service_id" name="service_id" value="{{ $service_id }}">
                        <input type="hidden" id="subservice_id" name="subservice_id" value="{{ $subservice_id }}">

                    <!-- STEP 1 -->
                    <div class="step-content active" id="step1">
                    @include('front.partials.subscription.subscription-hours')
                    @include('front.partials.subscription.subscription-packages')
                    @include('front.partials.subscription.subscription-frequency')
                    
                    <div class="step-buttons mt-4">
                        <div class="sticky-footer-btn">
                            <div class="row">
                                <div class="col-md-8 col-lg-6 col-sm-6 col-8">
                                    <div class="mobile_totalnew">
                                        <div class="font-weight-bold">
                                            <span class="totaltext">Total</span>
                                            <div class="mobile_price price-wrapper">
                                                <span class="currency_dhiramnew">AED</span>
                                                <span class="total_to_pay">0.00</span>
                                                <i style="margin-left: 5px;" class="fa-solid fa-angle-up arrow-toggle-mobile" id="aerrowicon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-6 col-sm-6 col-4">
                                    <button class="btn btn-primary custome-black" type="button" onclick="nextStep(2)">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 2: Choose Date & Time -->
                <div class="step-content" id="step2">
                    <div class="booking-step">
                        <div class="form-group mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw500 dark-color mb-0" style="font-size: 18px;">Which days do you prefer?</label>
                                <span class="badge" id="daysLabel" style="background-color: #f1f1f1; color: #555; padding: 6px 10px; border-radius: 12px; font-weight: 500;">Choose 1 day</span>
                            </div>
                            <style>
                                .slider-container {
                                    position: relative;
                                    display: flex;
                                    align-items: center;
                                    width: 100%;
                                    margin-bottom: 20px;
                                }
                                .slider-btn {
                                    background: white;
                                    border: none;
                                    font-size: 14px;
                                    cursor: pointer;
                                    z-index: 10;
                                    position: absolute;
                                    top: 50%;
                                    transform: translateY(-50%);
                                    height: 32px;
                                    width: 32px;
                                    border-radius: 50%;
                                    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
                                    color: #333;
                                    display: none; /* JS will toggle to flex */
                                    align-items: center;
                                    justify-content: center;
                                }
                                .slider-btn:hover {
                                    color: #000;
                                    box-shadow: 0 3px 8px rgba(0,0,0,0.2);
                                }
                                .slider-btn.left {
                                    left: -5px;
                                }
                                .slider-btn.right {
                                    right: -5px;
                                }
                                #daysSelection {
                                    display: flex;
                                    flex-wrap: nowrap !important;
                                    overflow-x: auto;
                                    gap: 10px;
                                    -ms-overflow-style: none;  /* IE and Edge */
                                    scrollbar-width: none;  /* Firefox */
                                    scroll-behavior: smooth;
                                    width: 100%;
                                    padding-left: 15px;
                                    padding-right: 15px;
                                    margin-bottom: 0 !important;
                                }
                                #daysSelection::-webkit-scrollbar {
                                    display: none; /* Chrome, Safari and Opera */
                                }
                                #daysSelection .day-pill {
                                    flex: 0 0 auto;
                                }
                            </style>
                            <div class="slider-container">
                                <button type="button" class="slider-btn left" id="slideLeftBtn" onclick="slideDays(-150)"><i class="fa fa-chevron-left"></i></button>
                                <div class="days-pills" id="daysSelection" onscroll="updateSliderBtns()">
                                    @php
                                        date_default_timezone_set('Asia/Dubai');
                                        // Start from tomorrow
                                        $startDay = \Carbon\Carbon::now()->addDay();
                                    @endphp
                                    @for ($i = 0; $i < 7; $i++)
                                        @php $dayName = $startDay->copy()->addDays($i)->format('l'); @endphp
                                        <div class="pill day-pill" data-val="{{ $dayName }}">{{ $dayName }}</div>
                                    @endfor
                                </div>
                                <button type="button" class="slider-btn right" id="slideRightBtn" onclick="slideDays(150)"><i class="fa fa-chevron-right"></i></button>
                            </div>
                            
                            <script>
                                function slideDays(offset) {
                                    const container = document.getElementById('daysSelection');
                                    container.scrollLeft += offset;
                                }
                                function updateSliderBtns() {
                                    const container = document.getElementById('daysSelection');
                                    const leftBtn = document.getElementById('slideLeftBtn');
                                    const rightBtn = document.getElementById('slideRightBtn');
                                    
                                    if (container.scrollLeft > 0) {
                                        leftBtn.style.display = 'flex';
                                    } else {
                                        leftBtn.style.display = 'none';
                                    }
                                    
                                    if (container.scrollLeft < (container.scrollWidth - container.clientWidth - 1)) {
                                        rightBtn.style.display = 'flex';
                                    } else {
                                        rightBtn.style.display = 'none';
                                    }
                                }
                                
                                // Update buttons whenever the container becomes visible (e.g. changing steps)
                                const observer = new IntersectionObserver((entries) => {
                                    if(entries[0].isIntersecting) {
                                        updateSliderBtns();
                                    }
                                }, { threshold: 0.1 });
                                observer.observe(document.getElementById('daysSelection'));

                                window.addEventListener('resize', updateSliderBtns);
                            </script>
                            <p class="form-error-text" id="days_error" style="color: red; margin-top: 10px;"></p>
                        </div>

                        <div class="form-group mb-3 mt-4">
                            <label class="form-label fw500 dark-color" for="country">What time would you like us to start?</label>
                            <div class="radio-group time-slot-grid time_replace_ab">
                                @php
                                    use Carbon\Carbon;
                                    date_default_timezone_set('Asia/Dubai');
                                    $i = 1;
                                    $timeslot = DB::table('time_slots')->orderBy('set_order','asc')->get()->toArray();
                                @endphp

                                @foreach ($timeslot as $timeslot_data)
                                    @php
                                        $timeslot_service = DB::table('subservice_timeslot_price')
                                            ->where('service_id', $subservice_data->serviceid)
                                            ->where('subservice_id', $subservice_data->id)
                                            ->where('time_slot_id', $timeslot_data->id)
                                            ->where('is_active', 1)
                                            ->first();

                                        $timeslot_service_price = $timeslot_service && $timeslot_service->price > 0 ? $timeslot_service->price : 0;
                                    @endphp

                                        @if ($timeslot_service && $timeslot_service->is_active == 1)
                                            <div class="surcharge-badge-timeslot items">
                                        @if ($timeslot_service_price > 0)
                                            <span class="badgespantime">
                                                <span>+</span>
                                                <span class="currency_dhiramnew">AED</span>
                                                <span>{{ $timeslot_service_price }}</span>
                                            </span>
                                        @endif
                                        <input type="radio" id="time{{ $i }}" name="time_slot" value="{{ $timeslot_data->id }}" onclick="timeSlotClick('{{ $timeslot_service_price }}','{{ $timeslot_data->name }}')">
                                        <label class="labeltime" for="time{{ $i }}" style="border-radius: 50px;">
                                            {{ $timeslot_data->name }}
                                        </label>
                                            </div>
                                        @endif
                                        @php $i++; @endphp
                                @endforeach
                            </div>
                            <p class="form-error-text" id="time_slot_error" style="color: red; margin-top: 10px;"></p>
                        </div>

                        <div class="form-group mb-3 mt-4">
                            <label class="form-label fw500 dark-color" style="font-size: 16px;">Need cleaning materials? <i class="fa fa-info-circle text-muted"></i></label>
                            <div class="d-flex gap-2" id="materialsSelection">
                                <div class="pill material-pill selected" data-val="No" style="border: 1px solid #ddd; padding: 8px 16px; border-radius: 20px; cursor: pointer;">No, I have them</div>
                                <div class="pill material-pill" data-val="Yes" style="border: 1px solid #ddd; padding: 8px 16px; border-radius: 20px; cursor: pointer;">Yes, please</div>
                            </div>
                        </div>

                        <div class="form-group mb-3 mt-4">
                            <label class="form-label fw500 dark-color" style="font-size: 16px;">Any instructions or special requirements?</label>
                            <div style="position: relative;">
                                <textarea class="form-control" id="special_instructions" rows="3" placeholder="Example: Key under the mat, ironing, window cleaning, etc." maxlength="150" style="resize: none; border-radius: 12px; background: #f9f9f9; padding: 15px; border: 1px solid #eaeaea;"></textarea>
                                <span id="charCount" style="position: absolute; bottom: 10px; right: 15px; font-size: 12px; color: #999;">0/150</span>
                            </div>
                        </div>
                    </div>
                    <div class="step-buttons mt-4">
                        <button class="btn btn-secondary custome-black" type="button" onclick="prevStep(1)">Back</button>
                        <div class="sticky-footer-btn">
                            <div class="row">
                                <div class="col-md-8 col-lg-6 col-sm-6 col-8">
                                    <div class="mobile_totalnew">
                                        <div class="font-weight-bold">
                                            <span class="totaltext">Total</span>
                                            <div class="mobile_price price-wrapper">
                                                <span class="currency_dhiramnew">AED</span>
                                                <span class="total_to_pay">0.00</span>
                                                <i style="margin-left: 5px;" class="fa-solid fa-angle-up arrow-toggle-mobile" id="aerrowicon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-6 col-sm-6 col-4">
                                    <button class="btn btn-primary custome-black" type="button" onclick="nextStep(3)">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: Address -->
                <div class="step-content" id="step3">
                    @include('front.partials.subscription.subscription-address')
                    <div class="step-buttons mt-4">
                        <button class="btn btn-secondary custome-black" type="button" onclick="prevStep(2)">Back</button>
                        <div class="sticky-footer-btn">
                            <div class="row">
                                <div class="col-md-8 col-lg-6 col-sm-6 col-8">
                                    <div class="mobile_totalnew">
                                        <div class="font-weight-bold">
                                            <span class="totaltext">Total</span>
                                            <div class="mobile_price price-wrapper">
                                                <span class="currency_dhiramnew">AED</span>
                                                <span class="total_to_pay">0.00</span>
                                                <i style="margin-left: 5px;" class="fa-solid fa-angle-up arrow-toggle-mobile" id="aerrowicon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-6 col-sm-6 col-4">
                                    <button class="btn btn-primary custome-black" type="button" onclick="nextStep(4)">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 4: Payment Information -->
                <div class="step-content" id="step4">
                    @include('front.partials.subscription.subscription-payment')
                    <div class="step-buttons mt-4">
                        <button class="btn btn-secondary custome-black" type="button" onclick="prevStep(3)">Back</button>
                        <div class="sticky-footer-btn">
                            <div class="row">
                                <div class="col-md-8 col-lg-6 col-sm-6 col-8">
                                    <div class="mobile_totalnew">
                                        <div class="font-weight-bold">
                                            <span class="totaltext">Total</span>
                                            <div class="mobile_price price-wrapper">
                                                <span class="currency_dhiramnew">AED</span>
                                                <span class="total_to_pay">0.00</span>
                                                <i style="margin-left: 5px;" class="fa-solid fa-angle-up arrow-toggle-mobile" id="aerrowicon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-6 col-sm-6 col-4">
                                    <button class="btn btn-primary custome-black" type="button" id="confirmBookingBtn" onclick="submitForm()" style="background-color:#0046fd; border:none;">Confirm & Pay</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wallet & Promo Hidden State -->
                <input type="hidden" id="wallet_balance" name="wallet_balance" value="{{ $wallet_amount ?? 0 }}">
                <input type="hidden" id="wallet_used" name="wallet_used" value="0.00">
                <input type="hidden" id="promo_discount" name="promo_discount" value="0.00">
                <input type="hidden" id="promo_name" name="promo_name" value="">
                <input type="hidden" id="wallet_reward_amount" name="wallet_reward_amount" value="0.00">
            </form>
        </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4 col-md-4 col-sm-12">
            @include('front.partials.subscription.booking-summary')
        </div>
    </div>
</div>

</section>

<!-- Mobile Summary Modal -->
<div class="modal fade" id="mobilesummaryModal" tabindex="-1">
    <div class="modal-dialog modal-summary-sheet"
        style="margin:0; position:fixed; bottom:0; left:0; right:0; width:100%; max-width:100%;">
        <div class="modal-content border-0" style="border-radius:20px 20px 0 0; background:#fff;">
            <div class="modal-drag-handle" style="padding:10px 0 6px; text-align:center; cursor:grab;">
                <div style="width:36px; height:4px; border-radius:99px; background:#ddd; margin:0 auto;"></div>
            </div>

            <div class="modal-sheet-header"
                style="display:flex; align-items:center; justify-content:space-between; padding:8px 20px 14px; position:relative;">
                <div>
                    <div
                        style="font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.12em; color:#aaa; margin-bottom:2px;">
                        Summary</div>
                    <h5 style="margin:0; font-size:1.25rem; font-weight:900; color:#000; letter-spacing:-0.02em;">
                        Booking Summary</h5>
                </div>
                <button type="button" data-bs-dismiss="modal"
                    style="width:36px; height:36px; border-radius:50%; border:1.5px solid #e0e0e0; background:#fff; display:flex; align-items:center; justify-content:center; color:#111; font-size:1.1rem; font-weight:700; line-height:1; cursor:pointer; flex-shrink:0; z-index:10;">
                    &times;
                </button>
            </div>

            <div class="modal-body sidebar-summary" style="flex:1; overflow-y:auto; padding:0 20px 16px;">
                <div style="background:#0040E6; border-radius:14px; padding:16px 18px; margin-bottom:16px;">
                    <div
                        style="font-size:0.7rem; font-weight:700; letter-spacing:0.1em; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-bottom:6px;">
                        Your Service</div>
                    <div style="font-size:1rem; font-weight:700; color:#fff;">Cleaning Subscription</div>
                </div>

                <div class="summary-addons-section" style="margin-bottom:6px;">
                    <div
                        style="font-size:0.68rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#bbb; margin-bottom:12px; padding-bottom:6px; border-bottom:1px solid #f0f0f0;">
                        Package Details</div>
                    <div class="sidebar-cart mobile-sidebar-cart" id="mobile_package_details" style="margin:0; font-size:0.88rem;">
                        <!-- Will be populated by JS -->
                    </div>
                </div>

                <div style="background:#f8f8f8; border-radius:14px; padding:16px; margin-top:16px;">
                    <div
                        style="font-size:0.7rem; font-weight:800; letter-spacing:0.1em; text-transform:uppercase; color:#aaa; margin-bottom:12px;">
                        Payment Summary</div>

                    <div class="d-flex justify-content-between py-1 subtotal-div">
                        <span style="font-size:0.85rem; color:#555;">Sub Total</span>
                        <span style="font-size:0.85rem; font-weight:700; color:#111;" class="price-wrapper">
                            <span class="currency_dhiramnew">AED</span> <span class="sub_total_display">0.00</span>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between py-1 vat-div">
                        <span style="font-size:0.85rem; color:#555;">VAT (5%)</span>
                        <span style="font-size:0.85rem; font-weight:700; color:#111;" class="price-wrapper">
                            <span class="currency_dhiramnew">AED</span> <span class="vat_charge_display">0.00</span>
                        </span>
                    </div>

                    <div
                        style="margin-top:12px; padding-top:12px; border-top:1.5px dashed #e0e0e0; display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-size:0.9rem; font-weight:700; color:#111;">Total</span>
                        <div class="left-summary-total"
                            style="margin:0 !important; padding:0 !important; background:transparent; border:none; display:flex !important; justify-content:flex-end !important; align-items:center !important; width:auto !important; gap:4px !important; color:#000 !important;">
                            <strong class="price-wrapper">
                                <span class="currency_dhiramnew" style="color:#000 !important;">AED</span>
                                <span class="total_to_pay"
                                    style="font-size:1.4rem; font-weight:900; color:#000;">0.00</span>
                            </strong>
                        </div>
                    </div>
                </div>
                <div style="height:16px;"></div>
            </div>

            <div class="modal-sheet-footer"
                style="padding:12px 20px 28px; background:#fff; border-top:1px solid #f0f0f0;">
                <div style="display:flex; align-items:center; justify-content:space-between;">
                    <div>
                        <div
                            style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:#bbb; margin-bottom:3px;">
                            Total to Pay</div>
                        <div style="display:flex; align-items:baseline; gap:4px;">
                            <span style="font-size:0.82rem; color:#888; font-weight:600;">AED</span>
                            <span class="total_to_pay"
                                style="font-size:1.65rem; font-weight:900; color:#000; letter-spacing:-0.03em;">0.00</span>
                        </div>
                    </div>
                    <button type="button" data-bs-dismiss="modal"
                        style="background:transparent; border:none; color:#aaa; font-size:0.8rem; font-weight:600; padding:6px 0; letter-spacing:0.03em; text-decoration:underline; text-underline-offset:3px; cursor:pointer;">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('front.includes.footer')
@include('front.partials.login_modal')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const pricingRules = @json($pricing_rules);
    const packagesData = @json($packages);
    var hasAddons = {{ isset($addons) && count($addons) > 0 ? 'true' : 'false' }};
    const ajaxTimeslotUrl = "{{ route('package.package_get_timeslots') }}";
    
    // Auth and Pricing Variables
    window.isUserLoggedIn = {{ session()->has('user') ? 'true' : 'false' }};
    window.codFeeAmount = typeof window.Enums !== 'undefined' && window.Enums.vcCharges ? window.Enums.vcCharges.COD.value : 10;
</script>

<!-- Hidden State inputs moved inside form -->

<script>
    function showPromoToast(type, title, message) {
        if (typeof showToast === 'function') {
            showToast(type, title, message);
        } else {
            Swal.fire({ icon: type, title: title, text: message });
        }
    }

    function apply_coupon() {
        var home_promo_check = "{{ route('home_promo_check') }}";
        let promo_code = $('#coupon_code').val();
        if (!promo_code) {
            showPromoToast('warning', 'Warning', 'Please Enter Promo Code');
            return false;
        }

        let sumSubtotal = parseFloat($('#summarySubtotal').text()) || 0;
        let packageDiscount = parseFloat($('#summaryDiscount').text()) || 0;
        let sub_total = sumSubtotal - packageDiscount;
        if(sub_total < 0) sub_total = 0;

        if(sub_total === 0) {
            showPromoToast('warning', 'Warning', 'Please select a package first.');
            return false;
        }

        $.ajax({
            url: home_promo_check,
            type: 'POST',
            data: {
                'promo_code': promo_code,
                'service': "{{ $subservice_data->serviceid }}",
                'sub_service': "{{ $subservice_data->id }}",
                'sub_total': sub_total,
                '_token': "{{ csrf_token() }}"
            },
            success: function (response) {
                if (response === 'invalid') {
                    showPromoToast('error', 'Error', 'Invalid Promo Code');
                    $('#coupon_code').val('');
                    return false;
                } else if (response === 'Already' || response === 'Already Used') {
                    showPromoToast('info', 'Notice', 'Promo Code Already Used');
                    $('#coupon_code').val('');
                    return false;
                } else if (response === 'invalid_user_count') {
                    showPromoToast('info', 'Notice', 'Promo Code Expired.');
                    $('#coupon_code').val('');
                    return false;
                } else if (response === 'grater') {
                    showPromoToast('info', 'Notice', 'Promo Discount is greater than total amount');
                    $('#coupon_code').val('');
                    return false;
                } else if (response === 'success') {
                    $.get("{{ route('homecleaning.get_coupon') }}", function (couponData) {
                        let toastMsg = 'Your promo code has been applied.';
                        if (typeof couponData === 'string') {
                            try { couponData = JSON.parse(couponData); } catch (e) { }
                        }
                        if (couponData && typeof couponData === 'object' && couponData.coupancode) {
                            let coupanApplyWallet = parseInt(couponData.coupan_apply_wallet) || 0;
                            let discountVal = parseFloat(couponData.discount) || 0;
                            let calculatedAmount = 0;
                            
                            if (couponData.coupanvalue == '0') {
                                calculatedAmount = (discountVal / 100) * sub_total;
                            } else {
                                calculatedAmount = discountVal;
                            }

                            if (coupanApplyWallet === 0) {
                                $('#wallet_reward_amount').val(calculatedAmount.toFixed(2));
                                $('#promo_discount').val('0.00');
                                
                                $(".promo_dicount_replace_div").find('.wallet-label').html('Coupon Applied: <span class="promo_code_name">' + couponData.coupancode + '</span>');
                                $(".promo_dicount_replace_div").find('.price-wrapper').html('<div style="font-size:0.95rem; font-weight:800; color:#16a34a; display:inline-flex; align-items:center; gap:4px; margin-top:2px; text-align:left;"><span class="currency_dhiramnew" style="font-size:0.95rem; font-weight:700; position:relative; ">AED</span><span class="wallet_reward_amount_display">' + calculatedAmount.toFixed(2) + '</span></div><span style="font-size:0.82rem; font-weight:normal; color:#16a34a; line-height: 1.3; margin-top:2px; display:block; text-align:left;">Reward credited after booking completion.</span>');
                                $(".wallet_reward_summary_div").removeClass('d-none');
                                $(".wallet_reward_code_amount").text(calculatedAmount.toFixed(2));
                                
                                let valStr = couponData.coupanvalue == '0' ? couponData.discount + '%' : '<span class="price-wrapper"><span class="currency_dhiramnew">AED</span>' + couponData.discount + '</span>';
                                toastMsg = 'Coupon applied successfully. ' + valStr + ' will be credited to your wallet after successful order completion.';
                            } else {
                                $('#promo_discount').val(calculatedAmount.toFixed(2));
                                $('#wallet_reward_amount').val('0.00');
                                
                                $(".promo_dicount_replace_div").find('.wallet-label').html('Coupon Applied: <span class="promo_code_name">' + couponData.coupancode + '</span>');
                                $(".promo_dicount_replace_div").find('.price-wrapper').html('<div style="font-size:0.95rem; font-weight:800; color:#16a34a; display:inline-flex; align-items:center; gap:4px; margin-top:2px; text-align:left;"><span class="currency_dhiramnew" style="font-size:0.85rem; font-weight:700; position:relative; top:-1px;">AED</span><span class="promo_code">' + calculatedAmount.toFixed(2) + '</span></div>');
                                $(".wallet_reward_summary_div").addClass('d-none');
                                
                                let rewardMsg = couponData.coupanvalue == '0' ? couponData.discount + '%' : '<span class="price-wrapper"><span class="currency_dhiramnew">AED</span>' + couponData.discount + '</span>';
                                toastMsg = rewardMsg + ' off applied successfully.';
                            }
                            $('#promo_name').val(couponData.coupancode);
                            $('.promo_code_name').text(couponData.coupancode);
                            $('#promo_code_input_section').addClass('d-none');
                            $('.promo_dicount_replace_div').removeClass('d-none');
                        }
                        showPromoToast('success', 'Promo Code Applied', toastMsg);
                        
                        $(".wallet_apply_new").show();
                        $(".wallet_cancel_new").hide();
                        $('#wallet_used').val('0.00');
                        
                        if (typeof updateUI === 'function') updateUI();
                    });
                } else {
                    showPromoToast('error', 'Error', 'Something went wrong');
                    $('#coupon_code').val('');
                }
            }
        });
    }

    function remove_coupon() {
        Swal.fire({
            title: "Remove Promo Code?",
            text: "Are you sure you want to remove this coupon?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Remove",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('homecleaning.remove_coupon') }}",
                    type: "POST",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function () {
                        $('#promo_name').val('');
                        $('#promo_discount').val('0.00');
                        $('#wallet_reward_amount').val('0.00');
                        $('#coupon_code').val('');
                        $('.promo_code').text('0.00');
                        $('.promo_code_name').text('');
                        
                        $('#promo_code_input_section').removeClass('d-none');
                        $('.promo_dicount_replace_div').addClass('d-none');
                        $('.wallet_reward_summary_div').addClass('d-none');
                        
                        if (typeof updateUI === 'function') updateUI();
                        showPromoToast('success', 'Coupon Removed!', 'Coupon Removed!');
                    }
                });
            }
        });
    }

    function apply_wallet_discount() {
        Swal.fire({
            title: "Are you sure you want to apply wallet balance?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, apply it!",
        }).then((result) => {
            if (result.isConfirmed) {
                let walletBalance = parseFloat($("#wallet_balance").val()) || 0;
                let sumSubtotal = parseFloat($('#summarySubtotal').text()) || 0;
                let packageDiscount = parseFloat($('#summaryDiscount').text()) || 0;
                let promoDiscount = parseFloat($('#promo_discount').val()) || 0;
                
                // Only consider COD fee if it's currently being applied
                let codFee = 0;
                let paymentType = document.querySelector('input[name="payment_type"]:checked');
                if (paymentType && paymentType.value === 'COD' && typeof window.codFeeAmount !== 'undefined') {
                    codFee = parseFloat(window.codFeeAmount);
                }
                
                let maxWalletApplicable = sumSubtotal - packageDiscount - promoDiscount + codFee;
                if (maxWalletApplicable < 0) maxWalletApplicable = 0;
                
                let walletUsed = 0;
                if (walletBalance >= maxWalletApplicable) {
                    walletUsed = maxWalletApplicable;
                } else {
                    walletUsed = walletBalance;
                }
                
                $("#wallet_used").val(walletUsed.toFixed(2));
                $(".wallet_apply_new").hide();
                $(".wallet_cancel_new").show();
                
                // If a coupon is applied, silently remove it
                if ($('#promo_name').val() !== '') {
                    $.ajax({
                        url: "{{ route('homecleaning.remove_coupon') }}",
                        type: "POST",
                        data: { _token: "{{ csrf_token() }}" },
                        success: function () {
                            $('#promo_name').val('');
                            $('#promo_discount').val('0.00');
                            $('#wallet_reward_amount').val('0.00');
                            $('#coupon_code').val('');
                            $('#promo_code_input_section').removeClass('d-none');
                            $('.promo_dicount_replace_div').addClass('d-none');
                            $('.wallet_reward_summary_div').addClass('d-none');
                            if (typeof updateUI === 'function') updateUI();
                        }
                    });
                } else {
                    if (typeof updateUI === 'function') updateUI();
                }

                Swal.fire({ icon: "success", title: "Wallet balance applied successfully", showConfirmButton: false, timer: 1200 });
            }
        });
    }

    function cancelWalletDiscount() {
        Swal.fire({
            title: "Are you sure you want to remove wallet balance?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, remove it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $("#wallet_used").val('0.00');
                $(".wallet_apply_new").show();
                $(".wallet_cancel_new").hide();
                
                if (typeof updateUI === 'function') updateUI();
                
                Swal.fire({ icon: "success", title: "Wallet balance removed successfully", showConfirmButton: false, timer: 1200 });
            }
        });
    }
</script>
<script src="{{ asset('public/assets/frontend/js/cleaning-subscription.js') }}?v={{ time() }}"></script>