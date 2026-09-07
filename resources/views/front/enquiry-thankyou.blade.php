@include('front.includes.header')

@php
    $gardenEnquiry = Session::get('garden_enquiry_data');
    $refCode = Session::get('garden_ref_code', '');

    if ($gardenEnquiry) {
        // Ensure it is an array
        $gardenEnquiry = (array) $gardenEnquiry;
    } else {
        $gardenEnquiryId = Session::get('garden_enquiry_id');
        if ($gardenEnquiryId) {
            $dbEnquiry = DB::table('garden_enquiry')->where('id', $gardenEnquiryId)->first();
            if ($dbEnquiry) {
                $gardenEnquiry = (array) $dbEnquiry;
                $packageEnquiry = DB::table('packages_enquiry')->where('id', $dbEnquiry->inquiry_id)->first();
                if ($packageEnquiry && isset($packageEnquiry->inquiry_id)) {
                    $refCode = $packageEnquiry->inquiry_id;
                } else {
                    $refCode = 'VC-ENQ-' . $dbEnquiry->id;
                }
            }
        }
    }
@endphp

<style>
    /* Classic UI/UX Refinements matching enquiry_thankyou_new */
    :root {
        --primary-blue: #0040E6;
        --success-green: #2ecc71;
        --text-dark: #1a1a1a;
        --text-muted: #666666;
        --bg-light: #f8f9fa;
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--bg-light);
        color: var(--text-dark);
        font-family: 'Inter', sans-serif;
    }

    .order-success-header {
        text-align: center;
        margin-bottom: 25px;
        margin-top: 30px;
    }

    .order-success-header h2 {
        font-weight: 800;
        font-size: 32px;
        color: var(--text-dark);
        letter-spacing: -1px;
    }

    .success-icon-wrapper {
        position: relative;
        width: 80px;
        height: 80px;
        margin: 0 auto 20px auto;
    }

    .main-circle {
        width: 80px;
        height: 80px;
        background-color: var(--success-green);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 35px;
        position: relative;
        z-index: 2;
        box-shadow: 0 10px 20px rgba(46, 204, 113, 0.3);
    }

    .pulse-ring {
        position: absolute;
        top: 0;
        left: 0;
        width: 80px;
        height: 80px;
        background-color: var(--success-green);
        border-radius: 50%;
        z-index: 1;
        animation: pulse-animation 2s infinite;
    }

    @keyframes pulse-animation {
        0% {
            transform: scale(1);
            opacity: 0.6;
        }

        100% {
            transform: scale(1.6);
            opacity: 0;
        }
    }

    .header-classic-card {
        background: #fff;
        border: none;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        padding: 30px;
        margin-bottom: 24px;
    }

    .classic-card {
        background: #fff;
        border: none;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        padding: 30px;
        margin-bottom: 24px;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 14px;
        background: rgba(0, 64, 230, 0.1);
        color: var(--primary-blue);
        margin-bottom: 15px;
    }

    /* Stepper Track */
    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        margin-bottom: 30px;
        position: relative;
    }

    .stepper-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
    }

    .stepper-item::before {
        content: "";
        position: absolute;
        top: 24px;
        left: -50%;
        width: 100%;
        height: 4px;
        background-color: #e2e8f0;
        z-index: 1;
    }

    .stepper-item:first-child::before {
        display: none;
    }

    .stepper-item.completed::before {
        background-color: var(--primary-blue);
    }

    .step-counter {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 12px;
        z-index: 2;
        position: relative;
        border: 4px solid #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .step-name {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-align: center;
        line-height: 1.4;
    }

    .stepper-item.completed .step-name {
        color: #0f172a;
    }

    /* Detail List */
    .detail-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .detail-list li {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f1f1f1;
    }

    .detail-list li:last-child {
        border-bottom: none;
    }

    .detail-label {
        color: var(--text-muted);
        font-weight: 500;
    }

    .detail-value {
        color: var(--text-dark);
        font-weight: 600;
        text-align: right;
    }

    .btn-return {
        display: inline-block;
        background: var(--primary-blue);
        color: #fff !important;
        font-weight: 700;
        padding: 16px 40px;
        border-radius: 12px;
        text-decoration: none;
        transition: 0.2s;
        border: none;
        width: 100%;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-return:hover {
        background: #0033B8;
        transform: translateY(-2px);
    }

    .btn-outline {
        display: inline-block;
        background: #fff;
        color: #334155 !important;
        font-weight: 600;
        padding: 16px 32px;
        border-radius: 12px;
        text-decoration: none;
        transition: 0.2s;
        border: 1px solid #cbd5e1;
        width: 100%;
        text-align: center;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .btn-outline:hover {
        background: #f8fafc;
        color: #0f172a !important;
    }

    .our-register {
        padding: 140px 0 80px 0 !important;
    }

    @media (max-width: 767px) {
        .our-register {
            padding: 10px 0 40px 0 !important;
            /* Significantly reduced top padding */
        }

        .order-success-header {
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .order-success-header h2 {
            font-size: 24px;
        }

        .stepper-wrapper {
            display: flex;
            flex-direction: row !important;
            justify-content: space-between;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .stepper-item::before {
            display: block !important;
            top: 18px;
            /* Align line with center of 36px circle */
            left: -50%;
            height: 3px;
        }

        .step-counter {
            width: 36px !important;
            height: 36px !important;
            font-size: 13px;
            border-width: 3px;
            margin-bottom: 8px;
        }

        .step-name {
            font-size: 10px !important;
        }

        .detail-list li {
            flex-direction: row;
            align-items: flex-start;
            gap: 4px;
            font-size: 13px;
        }

        .detail-value {
            text-align: left;
        }
    }
</style>

<section class="our-register">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto">

                <div class="order-success-header">
                    <div class="success-icon-wrapper">
                        <div class="main-circle">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="pulse-ring"></div>
                    </div>
                    <h2>Request Received!</h2>
                    <p class="text-muted">Your quote request has been successfully submitted to our system.</p>
                </div>

                <div class="header-classic-card">
                    <div>
                        <span class="status-badge">Quote Requested</span>
                        @if ($refCode)
                            <div class="detail-value mb-2" style="font-size: 18px; text-align: left;">
                                Reference Code: <span class="text-primary text-uppercase">#{{ $refCode }}</span>
                            </div>
                        @elseif(Session::has('enquiry_user_data') && isset(Session::get('enquiry_user_data')['name']))
                            <div class="detail-value mb-2" style="font-size: 18px; text-align: left;">
                                Hi <span class="text-primary">{{ Session::get('enquiry_user_data')['name'] }}</span>
                            </div>
                        @endif
                        <p class="text-muted small">We are matching your request with up to 5 of our top-rated,
                            certified vendors.</p>
                    </div>
                </div>

                <!-- Stepper Progress Tracker -->
                <div class="classic-card">
                    <h5 class="fw-bold mb-3">Next Steps</h5>
                    <div class="stepper-wrapper">
                        <div class="stepper-item completed">
                            <div class="step-counter" style="background-color: var(--primary-blue); color: #fff;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </div>
                            <div class="step-name">Request<br>Received</div>
                        </div>
                        <div class="stepper-item ">
                            <div class="step-counter" style="background-color: #e2e8f0; color: #94a3b8;">
                                <i class="fa-solid fa-file-invoice"></i>
                            </div>
                            <div class="step-name">Compare<br>Quotes</div>
                        </div>
                        <div class="stepper-item">
                            <div class="step-counter" style="background-color: #e2e8f0; color: #94a3b8;">
                                <i class="fa-solid fa-handshake"></i>
                            </div>
                            <div class="step-name">Select<br>Vendor</div>
                        </div>
                        <div class="stepper-item">
                            <div class="step-counter" style="background-color: #e2e8f0; color: #94a3b8;">
                                <i class="fa-solid fa-truck-fast"></i>
                            </div>
                            <div class="step-name">Service<br>Delivery</div>
                        </div>
                    </div>
                </div>

                <!-- Job Details Summary Card -->
                <div class="classic-card">
                    <h5 class="fw-bold mb-3">Quote Request Summary</h5>
                    <ul class="detail-list">
                        @if ($gardenEnquiry)
                            <!-- <li>
                                <span class="detail-label">Service Category</span>
                                <span class="detail-value">{!! Helper::servicename($gardenEnquiry['service']) !!}</span>
                            </li> -->
                            <li>
                                <span class="detail-label">Service Type</span>
                                <span class="detail-value">{!! Helper::subservicename($gardenEnquiry['subservice']) !!}</span>
                            </li>
                            @if (isset($gardenEnquiry['service_type']) && $gardenEnquiry['service_type'])
                                <li>
                                    <span class="detail-label">Specific Service</span>
                                    <span class="detail-value">{{ $gardenEnquiry['service_type'] }}</span>
                                </li>
                            @endif
                            @if (isset($gardenEnquiry['service_date']) && $gardenEnquiry['service_date'])
                                <li>
                                    <span class="detail-label">Service Date</span>
                                    <span
                                        class="detail-value">{{ date('d-m-Y', strtotime($gardenEnquiry['service_date'])) }}</span>
                                </li>
                            @endif
                            @if (isset($gardenEnquiry['city']) && $gardenEnquiry['city'])
                                <li>
                                    <span class="detail-label">City</span>
                                    <span
                                        class="detail-value">{{ DB::table('cities')->where('id', $gardenEnquiry['city'])->value('name') }}</span>
                                </li>
                            @endif
                            @if (isset($gardenEnquiry['address']) && $gardenEnquiry['address'])
                                <li>
                                    <span class="detail-label">Address</span>
                                    <span class="detail-value">{{ $gardenEnquiry['address'] }}</span>
                                </li>
                            @endif
                            @if (isset($gardenEnquiry['type_of_home']) && $gardenEnquiry['type_of_home'])
                                <li>
                                    <span class="detail-label">Unit Type</span>
                                    <span class="detail-value">{{ $gardenEnquiry['type_of_home'] }}</span>
                                </li>
                            @endif
                            @if (isset($gardenEnquiry['size_of_home']) && $gardenEnquiry['size_of_home'])
                                <li>
                                    <span class="detail-label">Size of Home</span>
                                    <span class="detail-value">{{ $gardenEnquiry['size_of_home'] }}</span>
                                </li>
                            @endif
                            @if (isset($gardenEnquiry['describe_your_requirements']) && $gardenEnquiry['describe_your_requirements'])
                                <li style="flex-direction: column; align-items: flex-start; gap: 6px;">
                                    <span class="detail-label">Job Details / Requirements</span>
                                    <span class="detail-value"
                                        style="text-align: left; color: var(--text-dark);
    font-weight: 600;">{{ $gardenEnquiry['describe_your_requirements'] }}</span>
                                </li>
                            @endif
                        @elseif(Session::has('enquiry_user_data'))
                            @if (isset(Session::get('enquiry_user_data')['type_of_painting']))
                                <li>
                                    <span class="detail-label">Service Type</span>
                                    <span
                                        class="detail-value">{{ Session::get('enquiry_user_data')['type_of_painting'] }}</span>
                                </li>
                            @endif
                            @if (isset(Session::get('enquiry_user_data')['email']))
                                <li>
                                    <span class="detail-label">Email Address</span>
                                    <span class="detail-value">{{ Session::get('enquiry_user_data')['email'] }}</span>
                                </li>
                            @endif
                            @if (isset(Session::get('enquiry_user_data')['mobile']))
                                <li>
                                    <span class="detail-label">Phone Number</span>
                                    <span class="detail-value">{{ Session::get('enquiry_user_data')['mobile'] }}</span>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <a href="{{ url('/') }}" class="btn-return">Return to Homepage</a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('contact') }}" class="btn-outline">Contact Support</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@include('front.includes.footer')
