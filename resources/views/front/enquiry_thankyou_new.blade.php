@include('front.includes.header')

<style>
    /* Classic UI/UX Refinements matching deep cleaning */
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

    .stepper-item:first-child::before { display: none; }
    .stepper-item.completed::before { background-color: var(--primary-blue); }

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
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
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
    }

    /* Next Steps Info Box */
    .info-box {
        background: #eff6ff;
        border: 1px solid #dbeafe;
        border-radius: 16px;
        padding: 24px;
        text-align: left;
        margin-bottom: 24px;
        display: flex;
        gap: 16px;
    }

    .info-icon {
        font-size: 24px;
        color: var(--primary-blue);
        margin-top: 2px;
    }

    .pro-tip {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        text-align: left;
        margin-bottom: 24px;
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
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .btn-return:hover {
        background: #0033B8;
        transform: translateY(-2px);
    }

    @media (max-width: 767px) {
        .stepper-wrapper {
            flex-direction: column;
            gap: 20px;
        }
        .stepper-item::before { display: none; }
        .detail-list li {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
        }
        .order-success-header h2 {
            font-size: 26px;
        }
    }
</style>

<section class="mt20 mb60">
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
                        <div class="detail-value mb-2" style="font-size: 18px;">
                            Reference Code: <span class="text-primary text-uppercase">#{{ $enquiry->customer_id ?? 'VC-ENQ-' . $enquiry->id }}</span>
                        </div>
                        <p class="text-muted small">We are matching your request with up to 5 of our top-rated, certified vendors.</p>
                    </div>
                </div>

                <!-- Stepper Progress Tracker -->
                <div class="classic-card">
                    <h5 class="fw-bold mb-3">Next Steps Tracker</h5>
                    <div class="stepper-wrapper">
                        <div class="stepper-item completed">
                            <div class="step-counter" style="background-color: var(--primary-blue); color: #fff;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </div>
                            <div class="step-name">Request<br>Received</div>
                        </div>
                        <div class="stepper-item completed">
                            <div class="step-counter" style="background-color: var(--primary-blue); color: #fff;">
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
                        <li>
                            <span class="detail-label">Service Category</span>
                            <span class="detail-value">{!! Helper::servicename($enquiry->service_id) !!}</span>
                        </li>
                        <li>
                            <span class="detail-label">Service Type</span>
                            <span class="detail-value">{!! Helper::subservicename($enquiry->subservice_id) !!}</span>
                        </li>
                        <li>
                            <span class="detail-label">Move/Job Type</span>
                            <span class="detail-value">{{ $enquiry->form_type }}</span>
                        </li>
                        @foreach($submittedFields as $field)
                            @if($field->formfield_value != '')
                                @php
                                    $displayValue = $field->formfield_value;
                                    if (is_numeric($displayValue)) {
                                        $option = DB::table('form_attributes')->where('id', $displayValue)->first();
                                        if ($option) {
                                            $displayValue = $option->form_option;
                                        }
                                    }
                                @endphp
                                <li>
                                    <span class="detail-label">{{ $field->lable_name }}</span>
                                    <span class="detail-value">{{ $displayValue }}</span>
                                </li>
                                @php
                                    $subFields = DB::table('more_formfields_details_att')
                                        ->where('form_id', '=', $field->form_field_id)
                                        ->where('package_inquiry_id', '=', $enquiry->id)
                                        ->get();
                                        @endphp
                                @if(count($subFields) > 0)
                                    @foreach($subFields as $subField)
                                        @php
                                            $subLabel = "What is the size of your home?";
                                            if ($field->form_field_id == 35) {
                                                $subLabel = "What days of the week would you like the service";
                                            }
                                            $subValue = \Helper::form_fields_attr_more($subField->more_form_attributes_id);
                                        @endphp
                                        <li>
                                            <span class="detail-label">{{ $subLabel }}</span>
                                            <span class="detail-value">{{ $subValue }}</span>
                                        </li>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="mb-4">
                    <a href="{{ url('/') }}" class="btn-return">Return to Homepage</a>
                </div>

                <p class="text-center text-muted small">Need assistance? <a href="{{ route('contact') }}" style="color: var(--primary-blue); font-weight: 600; text-decoration: none;">Contact Support</a></p>

            </div>
        </div>
    </div>
</section>

@include('front.includes.footer')
