@include('front.includes.header')

<style>
    /* Classic UI/UX Refinements */
    :root {
        --primary-blue: #0040E6;
        --success-green: #27ae60;
        --text-dark: #1a1a1a;
        --text-muted: #666666;
        --bg-light: #f8f9fa;
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--bg-light);
        color: var(--text-dark);
    }

    .order-success-header {
        text-align: center;
        margin-bottom: 25px;
    }

    .order-success-header h2 {
        font-weight: 800;
        font-size: 32px;
        color: var(--text-dark);
    }

    /* Modern Card Styling */
    .header-classic-card {
        background: #fff;
        border: none;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        padding: 30px 30px 0px 30px;
        margin-bottom: 24px;
        transition: transform 0.3s ease;
    }

    .classic-card {
        background: #fff;
        border: none;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        padding: 30px;
        /* margin-bottom: 24px; */
        transition: transform 0.3s ease;
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

    .appointment-time {
        font-size: 18px;
        font-weight: 500;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 15px;
    }

    /* Flash Line - Tips section */
    .flash-container {
        background: #fff;
        border-radius: 15px;
        padding: 15px 25px;
        border-left: 5px solid #f1c40f;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    .flash-item {
        display: none;
        align-items: center;
        gap: 12px;
        font-weight: 500;
    }

    .flash-item.active {
        display: flex;
        animation: fadeIn 0.5s ease-in-out;
    }

    /* Booking Detail List */
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
        font-weight: 400;
    }

    .detail-value {
        color: var(--text-dark);
    }

    /* Buttons */
    .btn-manage {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: var(--primary-blue);
        color: #fff !important;
        padding: 15px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-manage:hover {
        background: #0030ad;
        transform: translateY(-2px);
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Modal Styling */
    .modal-content {
        border: none;
        border-radius: 24px;
        padding: 10px;
    }

    .status-steps li.active .icon-circle {
        background: var(--primary-blue) !important;
        box-shadow: 0 0 0 5px rgba(0, 64, 230, 0.1);
    }

    .btn-booking-detail {
        background: lightseagreen;
        color: white;
        border: none;
        border-radius: 12px !important;
    }

    .btn-booking-detail:hover {
        color: #ffffff;
    }
</style>
<style>
    .success-icon-wrapper {
        position: relative;
        width: 80px;
        height: 80px;
        margin: 0 auto;
    }

    .main-circle {
        width: 80px;
        height: 80px;
        background-color: #2ecc71;
        /* Success Green */
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
        background-color: #2ecc71;
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

    .mt60 {
        margin-top: 10px !important;
    }

    @media (max-width: 767px) {

        /* Stack Date and Time vertically on mobile to prevent overflow */
        .appointment-time {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 8px !important;
            font-size: 16px !important;
        }

        /* Adjust the card padding for a tighter mobile look */
        .header-classic-card,
        .classic-card {
            padding: 20px !important;
        }

        /* Ensure the Booking Summary list doesn't squeeze labels */
        .detail-list li {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
            padding: 10px 0;
        }

        .detail-list li .detail-value {
            text-align: left;
            width: 100%;
            font-weight: 600;
        }

        /* Stack buttons at the bottom */
        .classic-card .mt-2.d-flex {
            flex-direction: column;
            gap: 12px !important;
        }

        .service-fee-custome-modal {
            max-width: 450px !important;
        }
    }

    @media (max-width: 767.98px) {

        .quantity .quantity-block {
            height: 60px;
            width: 84px;
        }

        .modal-mobile-bottom {
            background-color: rgba(0, 0, 0, 0.2);
            padding: 0 !important;
        }

        .modal-dialog-bottom {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            margin: 0;
            width: 100%;
            max-width: 100%;
            /* height: 90vh; */
            transform: translateY(100%);
            transition: transform 0.5s ease-out, opacity 0.5s ease-out;
            opacity: 0;
            display: flex;
            flex-direction: column;
            z-index: 1055;
        }

        .modal.show .modal-dialog-bottom {
            transform: translateY(0);
            opacity: 1;
        }

        .modal-content {
            border-radius: 20px 20px 0 0 !important;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .details-modal-content {
            border-radius: 20px !important;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .login-form-modal .user-modal-dialog {
            max-width: 60%;
            height: auto !important;
        }

        .modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            -webkit-overflow-scrolling: touch;
        }

        .modal-footer {
            padding: 10px 16px;
            background-color: #fff;
            border-top: 1px solid #ddd;
            position: sticky;
            bottom: 0;
            z-index: 10;
        }

        /* Prevent Bootstrap's default top-down animation */
        .modal .modal-dialog {
            transform: none !important;
            transition: none !important;
        }

        .modal-dialog-centered {
            min-height: 0 !important;
        }
    }

    .mb60 {
        margin-bottom: 0 !important;
    }
</style>
<style>
    :root {
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --brand-blue: #1F6EEC;
        --success-green: #22c55e;
        --glass-surface: rgba(255, 255, 255, 0.98);
        --glass-border: #ffffff;
    }

    #ConfirmModal .modal-content {
        background: var(--glass-surface);
        backdrop-filter: blur(20px);
        border: 2px solid var(--glass-border);
        border-radius: 30px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
        color: var(--text-dark) !important;
    }

    #ConfirmModal .modal-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        padding: 20px 30px;
    }

    /* Track Container */
    .progress-track-container {
        padding: 40px 10px;
        position: relative;
    }

    /* Progress Line - Desktop Only */
    .progress-line {
        position: absolute;
        top: 62px;
        left: 50px;
        right: 50px;
        height: 6px;
        background: #e2e8f0;
        z-index: 1;
        border-radius: 10px;
        display: block;
    }

    .progress-line-fill {
        height: 100%;
        background: var(--brand-blue);
        border-radius: 10px;
        transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Desktop Wrapper */
    .steps-wrapper {
        display: flex;
        justify-content: space-between;
        position: relative;
        z-index: 2;
    }

    .step-box {
        text-align: center;
        flex: 1;
    }

    .step-icon-bg {
        width: 48px;
        height: 48px;
        background: white;
        border: 2px solid #cbd5e1;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 18px;
        color: #94a3b8;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .step-box.active .step-icon-bg {
        background: var(--brand-blue);
        color: white;
        border-color: var(--brand-blue);
        transform: scale(1.1);
    }

    .step-box.completed .step-icon-bg {
        background: var(--success-green);
        color: white;
        border-color: var(--success-green);
    }

    .step-label-text {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--text-muted);
        display: block;
    }

    /* Detail Card */
    .status-detail-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 20px;
        margin-top: 20px;
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .detail-icon-part {
        font-size: 24px;
        color: var(--brand-blue);
        background: white;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        flex-shrink: 0;
    }

    .btn-dismiss {
        background: var(--brand-blue);
        color: white;
        border: none;
        width: 100%;
        padding: 16px;
        border-radius: 16px;
        font-weight: 700;
        margin-top: 20px;
    }

    /* ==========================================
       RESPONSIVE MOBILE BREAKPOINT (Under 768px)
       ========================================== */
    @media (max-width: 767px) {
        .progress-line {
            display: none;
            /* Hide horizontal line */
        }

        .steps-wrapper {
            flex-direction: row;
            flex-wrap: wrap;
            /* Allow steps to flow */
            justify-content: center;
            gap: 10px;
        }

        .step-box {
            flex: 0 0 calc(33.33% - 10px);
            /* Show 3 icons per row */
            margin-bottom: 15px;
        }

        .step-icon-bg {
            width: 40px;
            height: 40px;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .step-label-text {
            font-size: 9px;
            letter-spacing: 0;
        }

        .status-detail-card {
            flex-direction: column;
            text-align: center;
            padding: 25px 15px;
        }

        #ConfirmModal .modal-title {
            font-size: 18px;
        }
    }

    /* Extra Small Screen Fix (Under 400px) */
    @media (max-width: 400px) {
        .step-box {
            flex: 0 0 calc(50% - 10px);
            /* Show 2 icons per row */
        }
    }

    .confirm-modal {
        max-width: 630px !important;
    }
</style>

<section class="mt60 mb60">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto">

                {{-- <div class="order-success-header">
                    <img src="{{ asset('public/site/images/orderic.png') }}" alt="Success" class="mb-3"
                        style="width: 60px;">
                    <h2>Order Confirmed!</h2>
                    <p class="text-muted">Your booking has been successfully placed and is being processed.</p>
                </div> --}}

                <div class="order-success-header text-center">
                    <div class="success-icon-wrapper mb-4">
                        <div class="main-circle">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="pulse-ring"></div>
                    </div>

                    <h2 class="fw-bold" style="color: #2d3436; letter-spacing: -1px;">Order Confirmed!</h2>
                    <p class="text-muted mx-auto" style="max-width: 300px;">
                        Your booking has been successfully placed and is being processed.
                    </p>
                </div>

                <div class="header-classic-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="status-badge" data-bs-toggle="modal" data-bs-target="#ConfirmModal">
                                @php
                                    $statuses = [
                                        'BK' => 'Booking Requested',
                                        'BC' => 'Booking Confirmed',
                                        'P' => 'Booking Confirmed',
                                        'PA' => 'Vendor Assigned',
                                        'OTW' => 'On the way',
                                        'IP' => 'In progress',
                                        'CO' => 'Booking Completed',
                                        'CL' => 'Booking Cancelled',
                                        'UP' => 'Unpaid',
                                    ];
                                    $currentStatusText = $statuses[$thank_order_data->order_status] ?? 'Processing';
                                @endphp
                                {{ $currentStatusText }}
                            </span>

                            <div class="appointment-time mb-2">
                                <span><i class="fa-regular fa-calendar-check text-primary"></i>
                                    {{ $thank_ci_order_data->month }} {{ $thank_ci_order_data->bookingdate }},
                                    {{ $thank_ci_order_data->bookingyear }}</span>
                                <span><i class="fa-regular fa-clock text-primary"></i>
                                    {!! Helper::timeslotname($thank_ci_order_data->time_slot) !!}</span>
                            </div>
                            <p class="text-muted small">Thank you. We'll match you with a top-rated Professional.</p>
                        </div>
                        {{-- <img src="{{ asset('public/site/images/confirm.png') }}" width="60"
                            class="rounded-circle shadow-sm"> --}}
                    </div>
                </div>

                <div class="flash-container mb-4">
                    <div class="flash-item active">
                        <img src="{{ asset('public/site/images/t1.png') }}" width="24" alt="tip">
                        <span>Show kind gestures, they go a long way.</span>
                    </div>
                    <div class="flash-item">
                        <img src="{{ asset('public/site/images/t2.png') }}" width="24" alt="tip">
                        <span>Feel free to share a beverage with the pro.</span>
                    </div>
                    <div class="flash-item">
                        <img src="{{ asset('public/site/images/t3.png') }}" width="24" alt="tip">
                        <span>Building a rapport makes the service better.</span>
                    </div>
                </div>

                <div class="classic-card">
                    <h5 class="fw-bold mb-2">Booking Summary</h5>
                    <ul class="detail-list">
                        <li class="mb-0 mt-0">
                            <span class="detail-label">Status</span>
                            <span class="detail-value text-uppercase">#{{ $thank_order_data->format_order_id }}</span>
                        </li>
                        <li class="mb-0 mt-0">
                            <span class="detail-label">Reference Code</span>
                            <span class="detail-value text-uppercase">#{{ $thank_order_data->format_order_id }}</span>
                        </li>
                        <li class="mb-0 mt-0">
                            <span class="detail-label">Service Type</span>
                            <span class="detail-value">{!! Helper::subservicename($thank_ci_order_data->subservice_id) !!}</span>
                        </li>
                        <li class="mb-0 mt-0">
                            <span class="detail-label">Date & Time</span>
                            <span class="detail-value text-primary">{{ $thank_ci_order_data->month }}
                                {{ $thank_ci_order_data->bookingdate }} {{ $thank_ci_order_data->bookingyear }} ,
                                {!! Helper::timeslotname($thank_ci_order_data->time_slot) !!}</span>
                        </li>
                    </ul>

                    <div class="mt-2 d-flex gap-3">
                        <button class="btn btn-outline-secondary w-100 py-3 rounded-3 btn-booking-detail"
                            data-bs-toggle="modal" data-bs-target="#bookingDetailsModal">
                            Booking Details
                        </button>
                        <a href="{{ route('order-detail', $thank_order_data->order_id) }}" class="btn-manage w-100">
                            <i class="fa-regular fa-gear"></i> Manage Booking
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- end section -->
@include('front.includes.footer')

<div class="modal modal-mobile-bottom" id="bookingDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom modal-dialog-centered service-fee-custome-modal" id="modal-digi"
        role="document">
        <div class="modal-content charge-desc-popup" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header modal-header-mobile" style="background: #f1f5f9;border-radius: 35px;">
                <div>
                    <h5 class="fw-bold mb-0" style="color: #000000; letter-spacing: 0.5px;">Booking Details</h5>
                    <span class="badge mt-2"
                        style="background: rgba(255,255,255,0.1); color: #000000; font-weight: 400;">REF:
                        #{{ $thank_order_data->format_order_id }}</span>
                </div>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body modal-mobile" style="max-height: 70vh; overflow-y: auto;">
                <div class="d-flex align-items-center p-3 mb-4 rounded-3"
                    style="background: #f1f5f9; border-left: 5px solid #6366f1;">
                    <div class="flex-shrink-0 text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px; background: #6366f1;">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    <div class="ms-3">
                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem;">Service
                            booked</small>
                        <span class="fw-bold text-dark" style="font-size: 1.1rem;">{!! Helper::subservicename($thank_ci_order_data->subservice_id) !!}</span>
                    </div>
                </div>
                <div class="row g-4 mb-2">
                    <div class="col-6">
                        <label class="text-muted small d-block mb-1 fw-bold text-uppercase"><i
                                class="far fa-calendar-alt me-1 text-primary"></i> Date</label>
                        <span class="fw-semibold">{{ $thank_ci_order_data->month }}
                            {{ $thank_ci_order_data->bookingdate }}, {{ $thank_ci_order_data->bookingyear }}</span>
                    </div>
                    <div class="col-6">
                        <label class="text-muted small d-block mb-1 fw-bold text-uppercase"><i
                                class="far fa-clock me-1 text-primary"></i> Time</label>
                        <span class="fw-semibold">{!! Helper::timeslotname($thank_ci_order_data->time_slot) !!}</span>
                    </div>
                    <div class="col-12">
                        <label class="text-muted small d-block mb-1 fw-bold text-uppercase"><i
                                class="fas fa-map-marker-alt me-1 text-primary"></i> Location</label>
                        <span class="text-dark">{{ $thank_ci_order_data->apartment_villa_no }},
                            {{ $thank_ci_order_data->building_street_no }}, {{ $thank_ci_order_data->area }},
                            {{ $thank_ci_order_data->city }}</span>
                    </div>
                </div>
                <div class="p-3 rounded-3 border-0 mb-3"
                    style="background: linear-gradient(135deg, #0a58cafc 0%, #3891ca 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="d-block opacity-75 text-uppercase fw-bold"
                                style="font-size: 0.65rem;">Payment
                                via</small>
                            <span class="fw-bold">@php
                                $payment_modes = ['1' => 'Cash on Delivery', '2' => 'Online Payment'];
                                echo $payment_modes[$thank_order_data->paymentmode] ?? 'N/A';
                            @endphp</span>
                        </div>
                        <div class="text-end">
                            <small class="d-block opacity-75 text-uppercase fw-bold" style="font-size: 0.65rem;">Total
                                (Incl. VAT)</small>
                            <span class="h4 fw-bold mb-0 text-light">{{ $thank_order_data->order_currency }}
                                {{ $thank_order_data->order_total }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Add this to your stylesheet */
    /*  .tracking-wider { letter-spacing: 1px; }
    #bookingDetailsModal .modal-body label { font-size: 0.75rem; text-transform: uppercase; font-weight: 700; }
    #bookingDetailsModal .btn-dark:hover { background-color: #000; transform: translateY(-1px); transition: all 0.2s; } */
</style>

<div class="modal modal-mobile-bottom" id="ConfirmModal" tabindex="-1" aria-labelledby="ConfirmModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom modal-dialog-centered service-fee-custome-modal confirm-modal">
        <div class="modal-content charge-desc-popup" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header modal-header-mobile">
                <h5 class="modal-title" id="ConfirmModalLabel">Learn What Is Next</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="filter: brightness(0);"></button>
            </div>

            <div class="modal-body modal-mobile" style="max-height: 70vh; overflow-y: auto;">
                @php
                    $status = $thank_order_data->order_status;

                    if ($status == 'CL') {
                        $statusFlow = ['CL'];
                        $steps = [
                            [
                                'label' => 'Booking Cancelled',
                                'icon' => '<i class="fa-solid fa-times-circle"></i>',
                                'desc' =>
                                    'Your booking has been cancelled. If this is a mistake, please contact support.',
                            ],
                        ];
                    } else {
                        $statusFlow = ['BK', 'P', 'PA', 'OTW', 'IP', 'CO'];
                        $steps = [
                            [
                                'label' => 'Requested',
                                'icon' => '<i class="fa-solid fa-calendar-check"></i>',
                                'desc' =>
                                    'Your booking request has been received. please wait for confirmation from a service provider.',
                            ],
                            [
                                'label' => 'Confirmed',
                                'icon' => '<i class="fa-solid fa-check"></i>',
                                'desc' =>
                                    'A Service provider has accepted your booking. Your booking will be delivered as per the booked date and time.',
                            ],
                            [
                                'label' => 'Assigned',
                                'icon' => '<i class="fa-solid fa-user"></i>',
                                'desc' => 'We’ve matched you with a trusted vendor — you’re in good hands.',
                            ],
                            [
                                'label' => 'On the way',
                                'icon' => '<i class="fa-solid fa-truck"></i>',
                                'desc' => 'The vendor is on their way to your location. Get ready!',
                            ],
                            [
                                'label' => 'In progress',
                                'icon' => '<i class="fa-solid fa-spinner fa-spin"></i>',
                                'desc' => 'Work is currently underway. We’ll keep you posted!',
                            ],
                            [
                                'label' => 'Completed',
                                'icon' => '<i class="fa-solid fa-check-circle"></i>',
                                'desc' => 'Your booking is completed! We hope you’re satisfied with the service.',
                            ],
                        ];
                    }

                    $currentStep = array_search($status, $statusFlow);

                    // Logic for progress line width
                    $count = count($statusFlow);
                    $progressWidth = $count > 1 ? ($currentStep / ($count - 1)) * 100 : 100;
                @endphp

                <div class="progress-track-container">
                    <div class="progress-line">
                        <div class="progress-line-fill" style="width: {{ $progressWidth }}%;"></div>
                    </div>
                    <div class="steps-wrapper">
                        @foreach ($steps as $index => $step)
                            @php
                                $isCompleted = $index < $currentStep;
                                $isActive = $index === $currentStep;
                                $class = $isCompleted ? 'completed' : ($isActive ? 'active' : '');
                            @endphp
                            <div class="step-box {{ $class }}">
                                <div class="step-icon-bg">
                                    {!! $isCompleted ? '<i class="fa-solid fa-check"></i>' : $step['icon'] !!}
                                </div>
                                <div class="step-label-text">{{ $step['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="status-detail-card">
                    <div class="detail-icon-part">
                        {!! $steps[$currentStep]['icon'] !!}
                    </div>
                    <div class="detail-text-part">
                        <h6>Current Phase: {{ $steps[$currentStep]['label'] }}</h6>
                        <p>{{ $steps[$currentStep]['desc'] }}</p>
                    </div>
                </div>

                <button type="button" class="btn-dismiss" data-bs-dismiss="modal">Close Tracker</button>
            </div>
        </div>
    </div>
</div>
<script>
    const items = document.querySelectorAll('.flash-item');
    let current = 0;

    setInterval(() => {
        items[current].classList.remove('active');
        current = (current + 1) % items.length;
        items[current].classList.add('active');
    }, 2000); // change sentence every 2 seconds
</script>
