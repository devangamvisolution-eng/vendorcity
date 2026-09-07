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


    /* New Css */
    .card-rounded {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .profile-img {
        width: 50px;
        height: 50px;
        background: #f0f0f0;
        border-radius: 50%;
    }

    .rating-star {
        color: #fbb034;
    }

    .status-completed {
        color: green;
        font-weight: 600;
    }

    hr {
        background-color: currentColor;
    }

    .option-row {
        padding: 0 16px 12px 12px;
        /* border-bottom: 1px solid #e0e0e0; */
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
    }

    .option-row:hover {
        background-color: #f9f9f9;
    }

    .option-label {
        display: flex;
        align-items: center;
        font-size: 16px;
    }

    .option-label span {
        margin-right: 8px;
        font-size: 27px;
        transform: rotate(90deg);
        color: #000;
    }

    .arrow-icon {
        font-size: 18px;
    }

    .bookagain {
        margin: 0;
        color: #000000de;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        font-size: 18px;
        letter-spacing: 0;
    }

    .text-primary {
        font-size: 22px;
        font-style: normal;
        font-weight: 700;
        letter-spacing: 0;
        line-height: 32px;
    }

    .option-row .arrow-icon::after {
        content: '\276F';
        /* Unicode for › (› = U+276F = &#10147;) */
        font-size: 18px;
        display: inline-block;
    }

    .text-muted {
        color: #000000de !important;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        font-size: 18px;
        letter-spacing: 0;
    }

    .arrow-icongethelp::after {
        content: '\276F';
        /* Unicode for › (› = U+276F = &#10147;) */
        font-size: 18px;
        display: inline-block;
    }

    .get-help-card a {
        padding: 0 16px !important;
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
        display: flex;
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

    .booking_detail .right {
        font-size: 16px;
        letter-spacing: .1px;
        color: #000000de;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
    }

    .booking_detail .showMore {
        font-size: 14px;
        line-height: 20px;
        font-style: normal;
        font-weight: 600;
        letter-spacing: 0;
    }




    .booking_detail_popup {}

    .booking_detail_popup.card-rounded {
        box-shadow: inherit;
    }

    .booking_detail_popup.card {
        border: inherit;
    }

    .booking_detail_popup ul li {
        align-items: center !important;
        justify-content: space-between !important;
        display: flex;
        margin-bottom: 0.75rem;
    }

    .booking_detail_popup ul li strong {
        font-size: 16px;
        letter-spacing: .1px;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        color: #00000061 !important;
    }


    .booking_detail_popup .right {
        font-size: 16px;
        letter-spacing: .1px;
        color: #000000de;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
    }

    .modal-dialog {
        max-width: 35%;
        height: auto !important;
        max-height: 70% !important;
    }

    .modal-content {
        border-radius: 1.3rem;
    }

    .closeBtn {
        background: none;
        font-size: 50px;
        color: #000;
        border: none;
        /* position: absolute; */
        right: 0;
        top: 0;
        margin: 0;
        padding: 0;
        width: 30px;
    }

    .modal-title {
        font-size: 20px;
        color: #000000;
        font-weight: bold;
    }

    .instruction-box {
        padding: 12px 0;
        border-radius: 8px;
        font-size: 14px;
    }

    .instruction-box {
        font-size: 14px;
    }

    .instruction-box strong {
        color: #000000de;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        font-size: 18px;
        letter-spacing: 0;
        margin-left: 2%;
    }

    .instruction-box p {
        font-size: 16px;
        letter-spacing: .1px;
        color: #000000de;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        display: -webkit-box;
        overflow: hidden;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .card-section-price-detail {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 16px;
        background-color: #fff;
        margin-top: 20px;
    }

    .payment-method img {
        height: 20px;
        margin-right: 4px;
    }


    .price_detail {
        padding: 1rem 1.5rem;
    }

    .price_detail h5 {
        color: #000000de;
        font-size: 22px;
        font-style: normal;
        font-weight: 700;
        letter-spacing: 0;
        line-height: 32px;
    }

    .price_detail ul li {
        align-items: center !important;
        justify-content: space-between !important;
        display: flex;
        margin-bottom: 0.75rem;
    }

    .price_detail ul li strong {
        font-size: 16px;
        letter-spacing: .1px;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        color: #00000061 !important;
    }

    .price_detail .status-completed {
        font-size: 16px;
        letter-spacing: .1px;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        color: #49a361 !important;
    }

    .price_detail .right {
        font-size: 16px;
        letter-spacing: .1px;
        color: #000000de;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        display: flex;
        align-items: center;
        gap: 2px;
    }

    .receipt-link a {
        display: flex;
        justify-content: space-between;
        align-items: center;

    }

    .receipt-link i {
        font-size: 12px;
    }

    .receipt-icon {
        font-size: 18px;
        margin-right: 8px;
    }

    .receipt-label {
        display: flex;
        align-items: center;
        font-size: 14px;
    }

    .option-row-receipt {

        align-items: center;
        justify-content: space-between;
        cursor: pointer;
    }

    .option-row-receipt .option-row-receipt:hover {
        background-color: #f9f9f9;
    }

    .option-row-receipt .option-label {
        display: flex;
        align-items: center;
        font-size: 16px;
    }

    .option-row-receipt .option-label span {
        margin-right: 8px;
        font-size: 27px;
        transform: inherit;
        color: #000;
    }

    .option-row-receipt .arrow-icon {
        font-size: 18px;
    }

    .option-row-receipt .arrow-icongethelp::after {
        content: '\276F';
        font-size: 18px;
        display: inline-block;
    }

    .rating-card {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        background-color: #fff;
        padding: 16px;
        margin-top: 20px;
    }

    .rating-title {
        color: #000000de;
        font-size: 22px;
        font-style: normal;
        font-weight: 700;
        letter-spacing: 0;
        line-height: 32px;
        display: flex;
        align-items: center;
    }

    .rating-title i {
        font-size: 18px;
        margin-right: 8px;
    }

    .rating-subtext {
        font-size: 16px;
        letter-spacing: .1px;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        color: #00000061 !important;
    }

    .stars i {
        color: #fbc02d;
        font-size: 18px;
        margin-left: 2px;
    }

    status-popup {
        background: white;
        border-radius: 10px;
        font-family: sans-serif;
        padding: 20px 0px;
    }

    .status-header {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 20px;
    }

    .close-btn {
        font-size: 24px;
        cursor: pointer;
    }

    .status-steps {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .status-steps li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
        position: relative;
        color: #aaa;
    }

    .status-steps li .icon-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #ccc !important;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        margin-right: 10px;
        flex-shrink: 0;
    }

    .status-steps li .status-text {
        flex-grow: 1;
    }

    .status-steps li .status-title {
        font-weight: bold;
        margin-bottom: 3px;
    }

    .status-steps li .status-desc {
        font-size: 13px;
        color: #666;
    }

    .status-steps li.active {
        color: #00AEEF;
    }

    .status-steps li.active .icon-circle {
        background: #00AEEF !important;
    }

    .status-steps li.active::after {
        background: #00AEEF !important;
    }

    .status-steps li:not(:last-child)::after {
        content: "";
        position: absolute;
        left: 14px;
        top: 30px;
        width: 2px;
        height: 40px;
        background: #ccc;
    }

    .status-steps li.active~li .icon-circle {
        background: #e0e0e0;
    }

    #edit_instruction_btn {
        background-color: #0040E6;
        color: #fff;
        width: 100%;
    }

    #whatsapp_Button {
        background-color: #0040E6;
        color: #fff;
        width: 100%;
    }

    .help_que_popup {
        padding: 10px !important;
    }

    .status-desc.hide {
        display: none;
    }

    .status-desc.show {
        display: block;
    }

    #getHelpModal .modal-content {
        padding: 20px !important;
    }

    .help-que-modal {
        padding: 0px 10px !important;
    }

    .edit-icon {
        font-weight: 300;
        font-size: 20px;
    }

    .white-text {
        color: #fff;
    }

    #cancel_order_btn.btn:hover {
        color: #fff !important;
    }

    #submit_order_btn.btn:hover {
        color: #fff !important;
    }

    .currency_dhiram {
        display: inline-block;
        width: 18px;
        height: 18px;

        background-color: currentColor;

        -webkit-mask: url('{{ asset('public/site/icons/dirham.svg') }}') no-repeat center;
        mask: url('{{ asset('public/site/icons/dirham.svg') }}') no-repeat center;

        -webkit-mask-size: contain;
        mask-size: contain;
    }

    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 5px;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        font-size: 2rem;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
    }

    /* Highlight stars on hover and when checked */
    .star-rating input:checked~label,
    .star-rating label:hover,
    .star-rating label:hover~label {
        color: #ffc107;
        /* Gold color */
    }

    /* Star Rating Logic */
    .rating-wrapper {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 8px;
    }

    .rating-wrapper input {
        display: none;
    }

    .rating-wrapper label {
        font-size: 32px;
        color: #e9ecef;
        /* Empty star color */
        cursor: pointer;
        transition: all 0.2s ease;
    }

    /* Hover & Checked Effects */
    .rating-wrapper input:checked~label,
    .rating-wrapper label:hover,
    .rating-wrapper label:hover~label {
        color: #FFD312;
        /* Brand yellow color */
        transform: scale(1.1);
    }

    /* Modal Input Styling */
    #review_content:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 3px rgba(0, 64, 230, 0.1);
        border: 1px solid #0040E6 !important;
    }

    @media only screen and (max-width: 767px) {
        .subservice-read-more-model .modal-dialog {
            margin: 0;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100% !important;
            max-width: 100% !important;
            height: auto;
            transform: translateY(100%);
            animation: slideUp 0.3s ease-out forwards;
        }

        .subservice-read-more-model .modal-dialog-centered {
            min-height: 0 !important;
        }
    }

    /* Tip Styles */
    .tip-btn {
        background-color: #0040E6;
        color: white;
        border: none;
        padding: 5px 15px;
        border-radius: 5px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .tip-btn:hover {
        background-color: #0032b3;
    }

    .tip-info {
        font-size: 13px;
        color: #28a745;
        font-weight: 600;
        margin-bottom: 4px;
    }

    /* Modal Styles */
    .tip-modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .tip-option {
        border: 1px solid #dee2e6;
        padding: 10px;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 10px;
    }

    .tip-option:hover,
    .tip-option.active {
        border-color: #0040E6;
        background-color: #e8f8ff;
        color: #0040E6;
    }

    .custom-tip-input {
        margin-top: 10px;
    }
</style>
<style>
    /* Unique styles to match your classic theme */
    .cleaner-container {
        position: relative;
        padding-left: 20px;
    }

    /* Vertical line connecting cleaners */
    .cleaner-container::before {
        content: '';
        position: absolute;
        left: 0;
        top: 10px;
        bottom: 10px;
        width: 2px;
        background: #e9ecef;
        border-radius: 2px;
    }

    .cleaner-node {
        position: relative;
        background: #ffffff;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .cleaner-node:hover {
        border-color: var(--classic-blue, #007bff);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    /* The dot on the timeline */
    .cleaner-node::before {
        content: '';
        position: absolute;
        left: -25px;
        top: 25px;
        width: 12px;
        height: 12px;
        background: var(--classic-blue, #007bff);
        border: 3px solid #fff;
        border-radius: 50%;
        box-shadow: 0 0 0 2px #e9ecef;
        z-index: 1;
    }

    .rating-pill {
        background: #f8f9fa;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        color: #555;
        border: 1px solid #eee;
    }

    .cleaner-avatar {
        width: 55px;
        height: 55px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #fff;
        outline: 1px solid #eee;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style type="text/css">
    :root {
        --classic-navy: #1e293b;
        --classic-blue: #0040E6;
        --classic-blue-hover: #0032b3;
        --classic-border: #e2e8f0;
        --classic-bg: #ffffff;
        --accent-soft: #f8fafc;
        --classic-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        --hover-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .body_content {
        background-color: #ffffff;
        /* Slightly cooler grey for better contrast with white cards */
        font-family: 'Outfit', 'Inter', system-ui, sans-serif;
        margin-top: 100px;
        padding-bottom: 80px;
    }

    /* CARD DESIGN & HOVER POPUP */
    .classic-card {
        background: var(--classic-bg);
        border-radius: 20px;
        padding: 35px;
        margin-bottom: 25px;
        box-shadow: var(--classic-shadow);
        border: 1px solid var(--classic-border);
        position: relative;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        /* Professional easing */
        width: 100%;
        overflow: hidden;
    }

    .classic-card:hover {
        transform: translateY(-8px);
        /* The "Popup" effect */
        box-shadow: var(--hover-shadow);
        border-color: #cbd5e1;
    }

    /* LEFT SIDE ACCENT */
    .classic-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 4px;
        /* Slightly thinner for a more modern classic look */
        background: var(--classic-blue);
    }

    /* TYPOGRAPHY */
    .classic-section-title {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .classic-info-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 20px;
        background: var(--accent-soft);
        padding: 20px;
        border-radius: 12px;
    }

    .classic-item-label {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 4px;
        display: block;
    }

    .classic-item-value {
        font-size: 16px;
        color: var(--classic-navy);
        font-weight: 600;
    }

    /* PAYMENT SECTION */
    .classic-total-banner {
        background: var(--classic-navy);
        border-radius: 12px;
        padding: 25px;
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
    }

    .classic-total-amount {
        font-size: 32px;
        font-weight: 800;
        letter-spacing: -1px;
    }

    /* BUTTONS: ATTRACTIVE & INTERACTIVE */
    .btn-action-primary {
        background: var(--classic-blue);
        color: white !important;
        border: none;
        padding: 18px 30px;
        border-radius: 14px;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(0, 64, 230, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-action-primary:hover {
        background: var(--classic-blue-hover);
        transform: scale(1.02);
        box-shadow: 0 6px 20px rgba(0, 64, 230, 0.4);
    }

    .btn-action-secondary {
        background: white;
        color: var(--classic-navy) !important;
        border: 2px solid var(--classic-border);
        padding: 18px 30px;
        border-radius: 14px;
        font-weight: 700;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-action-secondary:hover {
        border-color: var(--classic-navy);
        background: #f1f5f9;
        transform: scale(1.02);
    }

    /* REUSEABLE COMPONENT HOVER (Schedule Again / Help) */
    .btn-classic-action {
        border: 1px solid var(--classic-border);
        padding: 20px;
        border-radius: 15px;
        transition: 0.3s;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-decoration: none !important;
        background: white;
        margin-top: 12px;
    }

    .btn-classic-action:hover {
        border-color: var(--classic-blue);
        background: #f0f7ff;
    }

    .status-gif {
        width: 80px;
        mix-blend-mode: multiply;
        /* Cleaner look on white backgrounds */
    }
</style>
<style type="text/css">
    :root {
        --classic-navy: #1e293b;
        --classic-blue: #0040E6;
        --classic-border: #f1f5f9;
        --classic-bg: #ffffff;
        --accent-soft: #f8fafc;
    }

    /* Smaller, More Stylish Card */
    .classic-card {
        background: var(--classic-bg);
        border-radius: 16px;
        padding: 20px 25px;
        /* Reduced from 35px for smaller height */
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        border: 1px solid var(--classic-border);
        position: relative;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .classic-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.08);
    }

    /* Modern Accent Bar */
    .classic-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 2px;
        background: var(--classic-blue);
        border-radius: 16px 0 0 16px;
    }

    /* Medium Font Size Tweaks */
    .text-muted {
        font-size: 15px !important;
        /* Medium size */
        color: #64748b !important;
        line-height: 1.5;
    }

    .classic-info-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 15px;
        background: var(--accent-soft);
        padding: 15px;
        /* Smaller padding */
        border-radius: 10px;
    }

    .classic-item-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .classic-item-value {
        font-size: 15px;
        /* Medium font */
        color: var(--classic-navy);
        font-weight: 600;
    }

    /* Compact Total Banner */
    .classic-total-banner {
        background: #f1f5f9;
        /* Lighter modern look */
        border-radius: 12px;
        padding: 15px 20px;
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--classic-navy);
        border: 1px dashed #cbd5e1;
    }

    .classic-total-amount {
        font-size: 24px;
        /* Reduced from 32px */
        font-weight: 800;
        color: var(--classic-blue);
    }

    /* Stylish "Book Again" Button */
    .btn-classic-action {
        border: 1px solid #e2e8f0;
        padding: 12px 18px;
        border-radius: 12px;
        transition: 0.2s;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-decoration: none !important;
        background: #fff;
    }

    .btn-classic-action:hover {
        background: #f8fafc;
        border-color: var(--classic-blue);
    }

    @media (min-width: 768px) and (max-width: 1024px) {

        .sidebar-left {
            display: none !important;
        }
    }
</style>

<div class="body_content">
    <section class="our-login pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 sidebar-left">
                    @include('front.account_sidebar')
                </div>
                @php

                    $checkReview = DB::table('ci_cleaners_review')
                        ->where('order_id', $orders->order_id)
                        ->where('visit_date', $orders->visit_date ?? null)
                        ->first();

                    // echo '<pre>';
                    // print_r($orders);

                @endphp
                <div class="col-lg-8">
                    <div class="classic-card">
                        <div class="row align-items-center">
                            <div class="col-md-9">
                                <span class="badge mb-3"
                                    style="background: #eef2ff; color: #0040E6; padding: 4px 15px; border-radius: 30px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                                    REF: #{{ $orders->format_order_id }}
                                </span>

                                @php
                                    use Carbon\Carbon;
                                    date_default_timezone_set('Asia/Dubai');
                                    $today = date('Y-m-d');

                                    // 1. Determine Base Status from DB
                                    $dbStatus = $orders->order_status;
                                    $statusFlow = ['BK', 'BC', 'OTW', 'IP', 'CO', 'CL', 'UP'];

                                    // 2. Automate Status Progression based on time

                                    // 3. Map Display Status to UI Elements
                                    $statusText = 'Unknown';
                                    $statusColor = '';
                                    $statusIcon = 'bi-info-circle';
                                    $iconColor = 'text-secondary';
                                    $modalTarget = '';

                                    if ($dbStatus == 'BC' || $dbStatus == 'P' || $dbStatus == 'PA') {
                                        $statusText =
                                            $orders->items[0]->service_id == 50
                                                ? 'Awaiting Confirmation'
                                                : 'Booking Confirmed';
                                        $statusIcon = 'bi-check-circle-fill';
                                        $iconColor = 'text-success';
                                    } elseif ($dbStatus == 'OTW') {
                                        $statusText = 'On the way';
                                        $statusIcon = 'bi-truck';
                                        $iconColor = 'text-primary';
                                    } elseif ($dbStatus == 'IP') {
                                        $statusText = 'In progress';
                                        $statusIcon = 'bi-spinner';
                                        $iconColor = 'text-primary';
                                    } elseif ($dbStatus == 'CO') {
                                        $statusText = 'Booking Completed';
                                        $statusIcon = 'bi-patch-check-fill';
                                        $iconColor = 'text-primary';
                                    } elseif ($dbStatus == 'CL') {
                                        $statusText = 'Booking Cancelled';
                                        $statusColor = 'red';
                                        $statusIcon = 'bi-x-circle-fill';
                                        $iconColor = 'text-danger';
                                    } elseif ($dbStatus == 'BK') {
                                        $statusText = 'Booking Requested';
                                        $statusIcon = 'bi-calendar-event';
                                        $iconColor = 'text-warning';
                                    }

                                    // 4. Determine Modal Target & Current Step for calculation later
                                    if ($dbStatus != 'CL') {
                                        $modalTarget =
                                            $orders->dateorder_status == 'upcoming' ? '#ConfirmModal' : '#ConfirmModal';
                                    }
                                    $popupStepMap = [
                                        'BK' => 0,
                                        'BC' => 1,
                                        'P' => 1,
                                        'PA' => 1,
                                        'OTW' => 2,
                                        'IP' => 3,
                                        'CO' => 4,
                                    ];

                                    $currentStep = $popupStepMap[$dbStatus] ?? 0;

                                    // 5. Shared Past Visit Check
                                    $isPastVisit = false;
                                    if ($orders->dateorder_status == 'past' || $dbStatus == 'CO' || $dbStatus == 'CL') {
                                        $isPastVisit = true;
                                    } elseif (!empty($orders->visit_date) && $orders->visit_date < $today) {
                                        $isPastVisit = true;
                                    }
                                @endphp

                                <h3 class="mb-1" style="line-height: 1.2;">
                                    <a href="javascript:void(0)"
                                        @if ($modalTarget) data-bs-toggle="modal" data-bs-target="{{ $modalTarget }}" @endif
                                        data-status="{{ $statusText }}"
                                        style="color: {{ $statusColor ? $statusColor : 'var(--classic-navy)' }} !important; text-decoration: none;font-weight: 700;display: flex;align-items: center;gap: 8px;">
                                        {{ $statusText }}
                                        <i class="bi bi-chevron-right" style="font-size: 1rem; opacity: 0.7;"></i>
                                    </a>
                                </h3>

                                @if ($orders->dateorder_status == 'upcoming')
                                    <p class="text-muted mb-0">Thank you. We'll match you with a top-rated
                                        Professional.
                                    </p>
                                @else
                                    <p class="text-muted mb-0">We hope you're satisfied. We look forward to serving
                                        you
                                        again. 💙</p>
                                @endif

                                <p class="text-muted mt-1" style="font-size: 14px;">Booked on
                                    <span
                                        class="text-dark fw-bold">{{ date('d M, Y', strtotime($orders->created_at)) }}</span>
                                </p>
                                @if (!empty($orders->visit_date))
                                    <p class="text-primary mt-1" style="font-size: 15px; font-weight: 700;">
                                        <i class="bi bi-calendar-check me-1"></i>
                                        Service Visit:
                                        <span>{{ date('d M, Y', strtotime($orders->visit_date)) }}</span>
                                    </p>
                                @endif
                            </div>

                            <div class="col-md-3 text-md-end mt-3 mt-md-0">
                                @if (isset($orders->dateorder_status) && $orders->dateorder_status == 'upcoming')
                                    <div class="profile-img mb-1 ms-auto">
                                        <img src="{{ asset('public/site/images/confirm.png') }}" alt="Status"
                                            class="img-fluid rounded-circle">
                                    </div>
                                @else
                                    @php
                                        $cleanerIds = !empty($orders->items[0]->cleaner_id)
                                            ? explode(',', $orders->items[0]->cleaner_id)
                                            : [];
                                    @endphp

                                    {{-- @if (count($cleanerIds) == 1)
                                        @php
                                            $cleaner_data = DB::table('users')
                                                ->where('id', trim($cleanerIds[0]))
                                                ->first();
                                        @endphp
                                        @if ($cleaner_data) --}}
                                    {{-- <div class="text-center">
                                                <div class="profile-img mb-1 ms-auto">
                                                    <img src="{{ asset('public/upload/cleaners/large/' . $cleaner_data->profile_image) }}"
                                                        alt="Profile" class="img-fluid rounded-circle"
                                                        onerror="this.src='{{ asset('public/site/images/default-user.png') }}'">
                                                </div>
                                                <a href="javascript:void(0)" class="text-decoration-none">
                                                    <small class="text-muted fw-bold">{{ $cleaner_data->name }}</small>
                                                </a>
                                                @if (!empty($checkReview))
                                                    <div class="mt-1">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $checkReview->rating)
                                                                <i class="bi bi-star-fill text-warning"></i>
                                                            @else
                                                                <i class="bi bi-star text-muted"></i>
                                                            @endif
                                                        @endfor
                                                    </div>

                                                @endif
                                            </div> --}}
                                    {{-- @endif
                                    @else --}}
                                    <i class="bi {{ $statusIcon }} {{ $iconColor }}"
                                        style="font-size: 4rem; display: block;"></i>
                                    {{-- @endif --}}
                                @endif
                            </div>
                        </div>

                        <div class="mt-4">
                            @if ($isPastVisit)
                                <hr>
                                <a href="{{ $orders->items[0]->service_id == 50 ? route('automobile.listing', ['page_url' => 'vehicles-inspection']) : route('booknow', [\App\Models\Admin\Service::find($orders->items[0]->service_id)->page_url ?? $orders->items[0]->service_id, \App\Models\Admin\Subservice::find($orders->items[0]->subservice_id)->page_url ?? $orders->items[0]->subservice_id]) }}"
                                    class="btn-classic-action">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="action-icon-frame"
                                            style="background: #f0f0f0; color: #000; width:40px; height:40px; display:flex; align-items:center; justify-content:center; border-radius:50%;">
                                            <i class="bi bi-arrow-counterclockwise" style="font-size: 20px;"></i>
                                        </div>
                                        <span class="bookagain">Book again</span>
                                    </div>
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                                @if (empty($checkReview))
                                    <hr>
                                    <a href="javascript:void(0)" class="btn-classic-action"
                                        onclick="openReviewModal('{{ $orders->order_id }}', '{{ $orders->visit_date ?? '' }}')"
                                        data-bs-toggle="modal" data-bs-target="#reviewModal">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="action-icon-frame"
                                                style="background: #f0f0f0; color: #000; width:40px; height:40px; display:flex; align-items:center; justify-content:center; border-radius:50%;">
                                                <i class="bi bi-star-fill" style="font-size: 18px; color: #FFD312;"></i>
                                            </div>
                                            <span class="bookagain fw-bold">Rate Cleaner</span>
                                        </div>
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                @endif

                                <a href="{{ route('view-receipts', ['id' => $orders->order_id, 'visit_date' => $orders->visit_date]) }}"
                                    class="btn-classic-action">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="action-icon-frame"
                                            style="background: #f0f0f0; color: #000; width:40px; height:40px; display:flex; align-items:center; justify-content:center; border-radius:50%;">
                                            <i class="bi bi-receipt" style="font-size: 18px; color: #FFD312;"></i>
                                        </div>
                                        <span class="bookagain fw-bold">View Receipt</span>
                                    </div>
                                    <i class="bi bi-chevron-right"></i>
                                </a>

                                @php
                                    $booking_full_date = date(
                                        'Y-m-d',
                                        strtotime(
                                            $orders->items[0]->bookingyear .
                                                '-' .
                                                $orders->items[0]->month .
                                                '-' .
                                                $orders->items[0]->bookingdate,
                                        ),
                                    );
                                @endphp

                                <hr>
                                <div class="mt-2 text-end p-3">
                                    @if ($orders->total_tipped > 0)
                                        <div
                                            class="d-inline-flex align-items-center bg-light text-success border rounded-pill py-2 px-4 fw-bold shadow-sm">
                                            <i class="bi bi-gift-fill me-2"></i>Tipped: Ð{{ $orders->total_tipped }}
                                        </div>
                                    @else
                                        <button type="button"
                                            class="btn btn-primary bg-primary text-white border-0 px-4 py-2 w-100 d-flex align-items-center justify-content-center gap-2"
                                            onclick="openTipModal('{{ $orders->order_id }}', '{{ $orders->format_order_id ?: $orders->order_id }}', '{{ $orders->visit_date ?? '' }}')">
                                            <i class="bi bi-gift-fill"></i> Add Tip
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    @php
                        $recurring_visits = \App\Helpers\Helper::getUpcomingVisits($orders->order_id, 5);
                    @endphp

                    @if ($recurring_visits->count() > 0)
                        <div class="classic-card mt-3">
                            <div class="classic-section-title mb-3">
                                <i class="bi bi-calendar-event me-2"></i>Upcoming Schedule
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recurring_visits as $visit)
                                            <tr>
                                                <td><strong>{{ date('d M Y', strtotime($visit->visit_date)) }}</strong>
                                                </td>
                                                <td>
                                                    @if ($visit->visit_status == 'cancelled')
                                                        <span class="badge bg-danger">Skipped</span>
                                                    @elseif($visit->visit_status == 'completed')
                                                        <span class="badge bg-success">Completed</span>
                                                    @else
                                                        <span class="badge bg-info">Upcoming</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    @if ($visit->visit_status != 'cancelled' && $visit->visit_status != 'completed')
                                                        <button class="btn btn-sm btn-outline-danger user-cancel-visit"
                                                            data-date="{{ $visit->visit_date }}"
                                                            data-order="{{ $orders->order_id }}">
                                                            Skip Visit
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                $('.user-cancel-visit').on('click', function() {
                                    let visitDate = $(this).data('date');
                                    let orderId = $(this).data('order');

                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: "Do you want to skip this visit?",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Yes, skip it!',
                                        showLoaderOnConfirm: true,
                                        preConfirm: () => {
                                            return $.ajax({
                                                url: "{{ route('front.cancel_recurring_visit') }}",
                                                type: "POST",
                                                data: {
                                                    _token: "{{ csrf_token() }}",
                                                    visit_date: visitDate,
                                                    order_id: orderId
                                                }
                                            }).catch(error => {
                                                Swal.showValidationMessage(`Request failed: ${error}`);
                                            });
                                        },
                                        allowOutsideClick: () => !Swal.isLoading()
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            if (result.value.status == 1) {
                                                Swal.fire(
                                                    'Skipped!',
                                                    result.value.message,
                                                    'success'
                                                ).then(() => {
                                                    location.reload();
                                                });
                                            } else {
                                                Swal.fire(
                                                    'Error!',
                                                    result.value.message,
                                                    'error'
                                                );
                                            }
                                        }
                                    });
                                });
                            });
                        </script>
                    @endif

                    @if (!empty($pastVisits) && !request()->get('visit_date'))
                        <div class="classic-card mt-3">
                            <div class="classic-section-title mb-3">
                                <i class="bi bi-clock-history me-2"></i>Past Visits
                            </div>
                            <div class="past-visits-list">
                                @foreach ($pastVisits as $pVisit)
                                    <div class="appointment-card mb-3 p-3 border rounded shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="appointment-time fw-bold" style="color: #1e293b;">
                                                    <i class="bi bi-calendar-check me-1"></i>
                                                    {{ date('M d, Y', strtotime($pVisit->visit_date)) }},
                                                    {!! Helper::timeslotname($orders->items[0]->time_slot) !!}
                                                </div>
                                                <div class="badge bg-light text-success border mt-1">
                                                    <i class="bi bi-check-circle-fill me-1"></i>Visit Completed
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                @php
                                                    $pVisitReview = DB::table('ci_cleaners_review')
                                                        ->where('order_id', $orders->order_id)
                                                        ->where('visit_date', $pVisit->visit_date)
                                                        ->first();
                                                @endphp

                                                <div class="d-flex flex-column gap-2 mt-2">
                                                    @if ($pVisit->total_tipped > 0)
                                                        <div
                                                            class="badge bg-light text-success border py-2 px-3 fw-bold shadow-sm rounded-pill">
                                                            <i class="bi bi-gift-fill me-1"></i>Tipped:
                                                            Ð{{ $pVisit->total_tipped }}
                                                        </div>
                                                    @else
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                            onclick="openTipModal('{{ $orders->order_id }}', '{{ $orders->format_order_id ?: $orders->order_id }}', '{{ $pVisit->visit_date }}')">
                                                            <i class="bi bi-plus-circle me-1"></i>Add Tip
                                                        </button>
                                                    @endif

                                                    @if (!empty($pVisitReview))
                                                        <div
                                                            class="badge bg-light text-warning border py-2 px-3 fw-bold shadow-sm rounded-pill">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i
                                                                    class="bi bi-star{{ $i <= $pVisitReview->rating ? '-fill' : '' }}"></i>
                                                            @endfor
                                                            <span class="ms-1 text-dark">Reviewed</span>
                                                        </div>
                                                    @else
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                                                            onclick="openReviewModal('{{ $orders->order_id }}', '{{ $pVisit->visit_date }}')"
                                                            data-bs-toggle="modal" data-bs-target="#reviewModal">
                                                            <i class="bi bi-star me-1"></i>Leave Review
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @php
                        $visitDateForReview = request()->get('visit_date') ?? ($orders->visit_date ?? null);
                        $Getreview = DB::table('ci_cleaners_review')
                            ->where('order_id', $orders->order_id)
                            ->when($visitDateForReview, function ($query) use ($visitDateForReview) {
                                return $query->where('visit_date', $visitDateForReview);
                            })
                            ->get();
                    @endphp
                    @if (isset($Getreview) && count($Getreview) > 0)
                        <div class="classic-card">
                            <div class="classic-section-title mb-4">
                                <i class="bi bi-person-badge me-2"></i>Service Professionals
                            </div>

                            <div class="cleaner-container">

                                @foreach ($Getreview as $GetreviewData)
                                    @php
                                        $cleaner_data = DB::table('users')
                                            ->where('id', trim($GetreviewData->crew_id))
                                            ->first();

                                        $averageRating = DB::table('ci_cleaners_review')
                                            ->where('crew_id', $GetreviewData->crew_id)
                                            ->avg('rating');

                                    @endphp
                                    <div class="cleaner-node">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('public/upload/cleaners/large/' . $cleaner_data->profile_image) }}"
                                                class="cleaner-avatar me-3">
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>

                                                        <div class="fw-bold text-dark" style="font-size: 15px;">
                                                            {{ $cleaner_data->name }}
                                                        </div>
                                                    </div>
                                                    <span class="rating-pill"> <i
                                                            class="bi bi-star-fill text-warning"></i>
                                                        {{ number_format($averageRating, 1) }}</span>
                                                </div>

                                                <div class="d-flex align-items-center">
                                                    {{-- <span class="text-muted me-2" style="font-size: 11px;">Order
                                                            Rating:</span> --}}
                                                    <div class="text-warning" style="font-size: 12px;">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $GetreviewData->rating)
                                                                <i class="bi bi-star-fill text-warning"></i>
                                                            @else
                                                                <i class="bi bi-star "></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach




                            </div>
                        </div>
                    @endif

                    @if (isset($orders->items[0]->subservice_id) && $orders->items[0]->subservice_id == 93)
                        <div class="classic-card mb-3">
                            <div class="classic-section-title">
                                <i class="bi bi-car-front"></i> Car Details
                            </div>
                            <div class="classic-info-row">
                                <div>
                                    <span class="classic-item-label">Plate Source</span>
                                    <div class="classic-item-value">{{ $orders->items[0]->plate_source ?? '-' }}</div>
                                </div>
                                <div>
                                    <span class="classic-item-label">Plate Code</span>
                                    <div class="classic-item-value">{{ $orders->items[0]->plate_code ?? '-' }}</div>
                                </div>
                                <div>
                                    <span class="classic-item-label">Plate Number</span>
                                    <div class="classic-item-value">{{ $orders->items[0]->plate_number ?? '-' }}</div>
                                </div>
                                <div style="width: 100%; flex: 0 0 100%;">
                                    <span class="classic-item-label">Car Description</span>
                                    <div class="classic-item-value">{{ $orders->items[0]->describe_your_car ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="classic-card">
                        <div class="classic-section-title">
                            <i class="bi bi-calendar3"></i> Booking Details
                        </div>

                        <div class="classic-info-row">
                            <div>
                                <span class="classic-item-label">Service</span>
                                <div class="classic-item-value">{!! Helper::subservicename($orders->items[0]->subservice_id) !!}</div>
                            </div>
                            @if (isset($orders->items[0]->charger_type))
                                <div>
                                    <span class="classic-item-label">Charger Type</span>
                                    <div class="classic-item-value">{{ $orders->items[0]->charger_type }}</div>
                                </div>
                            @endif
                            @if (isset($orders->items[0]->installation_location_type))
                                <div>
                                    <span class="classic-item-label">Installation Location Type</span>
                                    <div class="classic-item-value">
                                        {{ $orders->items[0]->installation_location_type }}</div>
                                </div>
                            @endif
                            <div>
                                <span class="classic-item-label">Date</span>
                                <div class="classic-item-value">{{ $orders->items[0]->bookingdate }}
                                    {{ $orders->items[0]->month }}</div>
                            </div>
                            <div>
                                <span class="classic-item-label">Time Slot</span>
                                <div class="classic-item-value" style="color: var(--classic-blue)">
                                    {!! Helper::timeslotname($orders->items[0]->time_slot) !!}</div>
                            </div>

                            @php
                                $cleaNerscount = 0;
                                if (!empty($orders->items) && isset($orders->items[0]->how_many_cleaners_do_you_need)) {
                                    $cleaNerscount = $orders->items[0]->how_many_cleaners_do_you_need;
                                } elseif (!empty($orders->items) && isset($orders->items[0]->cleaner_id)) {
                                    $cleaNerscount = count(explode(',', $orders->items[0]->cleaner_id));
                                }
                            @endphp

                            @if ($orders->items[0]->subservice_id == 28)
                                @if ($cleaNerscount > 0)
                                    <div>
                                        <span class="classic-item-label">Cleaners</span>
                                        <div class="classic-item-value">{{ $cleaNerscount }}</div>
                                    </div>
                                @endif
                                @if (!empty($orders->items) && isset($orders->items[0]->how_many_hours_should_they_stay))
                                    <div>
                                        <span class="classic-item-label">Hours</span>
                                        <div class="classic-item-value">
                                            {{ $orders->items[0]->how_many_hours_should_they_stay }}</div>
                                    </div>
                                @endif
                            @endif

                            @if ($orders->items[0]->service_id == 50 && !empty($orders->items[0]->verifybuy_vehicle))
                                <div>
                                    <span class="classic-item-label">Vehicle</span>
                                    <div class="classic-item-value">{!! Helper::vehiclename($orders->items[0]->verifybuy_vehicle) !!}</div>
                                </div>
                            @endif

                            @if ($orders->items[0]->subservice_id != 28)
                                @php
                                    $package_data = DB::table('ci_order_item_packages')
                                        ->where('order_id', $orders->order_id)
                                        ->get();
                                @endphp
                                @if ($package_data->isNotEmpty())
                                    <div>
                                        <span class="classic-item-label">Package Info</span>
                                        <div class="classic-item-value">
                                            @foreach ($package_data as $pkg)
                                                {!! Helper::packages_enquiry($pkg->package_id) !!}@if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <div>
                                <span class="classic-item-label">Location</span>
                                <div class="classic-item-value text-truncate" style="max-width: 150px;">
                                    @if ($orders->items[0]->service_id == 50 && $orders->items[0]->subservice_id == 92)
                                        {{ $orders->items[0]->verifybuy_address }}
                                    @else
                                        {{ $orders->items[0]->area }}, {{ $orders->items[0]->city }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-between align-items-center">
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#bookingDetailsModal"
                                class="fw-bold text-decoration-none"
                                style="color: var(--classic-blue); font-size: 14px;">
                                View Full Details <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>

                    <div class="classic-card">
                        <div class="classic-section-title">
                            <i class="bi bi-wallet2"></i> Payment Summary
                        </div>

                        <div class="px-2">
                            @if ($orders->items[0]->service_id != 50)
                                {{-- 1. Base Service --}}
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Service Charge</span>
                                    <span class="fw-bold"><span class="currency_dhiram"></span>
                                        {{ number_format($orders->service_charge, 2) }}</span>
                                </div>

                                {{-- 2. Addons --}}
                                @if (isset($addons_data) && count($addons_data) > 0)
                                    @php
                                        $addOnstotal = 0;
                                        foreach ($addons_data as $addonsData) {
                                            $addOnstotal +=
                                                $addonsData->package_quantity * $addonsData->package_item_price;
                                        }
                                    @endphp
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Addons Charge</span>
                                        <span class="fw-bold"><span class="currency_dhiram"></span>
                                            {{ number_format($addOnstotal, 2) }}</span>
                                    </div>
                                @endif

                                {{-- 3. Fees --}}
                                @if ($orders->cod_charge > 0)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">COD Charge</span>
                                        <span class="fw-bold"><span class="currency_dhiram"></span>
                                            {{ number_format($orders->cod_charge, 2) }}</span>
                                    </div>
                                @endif

                                @if ($orders->service_fee > 0)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Service Fee</span>
                                        <span class="fw-bold"><span class="currency_dhiram"></span>
                                            {{ number_format($orders->service_fee, 2) }}</span>
                                    </div>
                                @endif

                                <hr class="my-2 opacity-50">

                                {{-- 4. Subtotal & VAT --}}
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span class="fw-bold"><span class="currency_dhiram"></span>
                                        {{ number_format($orders->sub_total, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">VAT (5%)</span>
                                    <span class="fw-bold"><span class="currency_dhiram"></span>
                                        {{ number_format($orders->vatcharge, 2) }}</span>
                                </div>

                                {{-- 5. Discounts --}}
                                @if (isset($orders->coupondiscount) && $orders->coupondiscount > 0)
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <span>Coupon Discount</span>
                                        <span class="fw-bold">- <span class="currency_dhiram"></span>
                                            {{ number_format($orders->coupondiscount, 2) }}</span>
                                    </div>
                                @endif
                                @if (isset($orders->front_wallet_amount) && $orders->front_wallet_amount > 0)
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <span>Wallet Discount</span>
                                        <span class="fw-bold">- <span class="currency_dhiram"></span>
                                            {{ number_format($orders->front_wallet_amount, 2) }}</span>
                                    </div>
                                @endif

                                @if ($orders->total_tipped > 0)
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <span>Tip Amount</span>
                                        <span class="fw-bold"><span class="currency_dhiram"></span>
                                            {{ number_format($orders->total_tipped, 2) }}</span>
                                    </div>
                                @endif
                            @endif

                            <div class="classic-total-banner">
                                <div>
                                    <div
                                        style="font-size: 11px; text-transform: uppercase; opacity: 0.8; font-weight: 700;">
                                        Total (Inc. VAT)</div>
                                    <div class="classic-total-amount"><span class="currency_dhiram"></span>
                                        {{ $orders->order_total }}</div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill fw-bold"
                                        style="font-size: 12px;">
                                        {{ $orders->paymentmode == 1 ? 'COD' : 'Online' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (
                        !$isPastVisit &&
                            $orders->dateorder_status == 'upcoming' &&
                            $orders->order_status != 'CL' &&
                            $orders->order_status != 'CO')
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <button class="btn-action-secondary w-100" data-bs-toggle="modal"
                                    data-bs-target="#Edit_instruction_Modal">
                                    <i class="bi bi-pencil-square"></i> Update Instructions
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn-action-primary w-100" data-bs-toggle="modal"
                                    data-bs-target="#EditbookingModal">
                                    <i class="bi bi-calendar-check"></i> Reschedule Booking
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

@include('front.includes.footer')

<!-- Tip Modal -->
<div class="modal fade" id="tipModal" tabindex="-1" aria-labelledby="tipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header tip-modal-header">
                <h5 class="modal-title" id="tipModalLabel">Add Tip for Order #<span id="tipOrderDisplayId"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('order-add-tip') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" id="tipOrderId">
                <input type="hidden" name="visit_date" id="tipVisitDate">
                <div class="modal-body">
                    <p class="text-muted mb-3">Show your appreciation for the service professionals.</p>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <div class="tip-option" onclick="selectTip(5)">Ð5</div>
                        </div>
                        <div class="col-4">
                            <div class="tip-option" onclick="selectTip(10)">Ð10</div>
                        </div>
                        <div class="col-4">
                            <div class="tip-option" onclick="selectTip(20)">Ð20</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="custom_tip" class="form-label font-weight-bold">Custom Amount (Ð)</label>
                        <input type="number" class="form-control" name="tip_amount" id="tip_amount" min="1"
                            placeholder="Enter amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary bg-primary text-white border-0 px-4">Pay
                        Tip</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openTipModal(orderId, displayId, visitDate) {
        document.getElementById('tipOrderId').value = orderId;
        document.getElementById('tipOrderDisplayId').innerText = displayId;
        document.getElementById('tipVisitDate').value = visitDate || '';
        if (visitDate) {
            document.getElementById('tipOrderDisplayId').innerText += ' (' + visitDate + ')';
        }
        $('#tipModal').modal('show');
    }

    function selectTip(amount) {
        document.getElementById('tip_amount').value = amount;
        document.querySelectorAll('.tip-option').forEach(opt => {
            opt.classList.remove('active');
            if (opt.innerText.includes(amount)) {
                opt.classList.add('active');
            }
        });
    }
</script>

{{-- Show more popup start --}}
@if (isset($orders))
    @php
        // echo '<pre>';
        // print_r($orders);
    @endphp
    <div class="modal fade subservice-read-more-model" id="bookingDetailsModal" tabindex="-1"
        aria-labelledby="bookingDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content ">

                <div class="modal-header">
                    <h5 class="modal-title" id="bookingDetailsModalLabel">Booking Details</h5>
                    <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-rounded booking_detail_popup">
                        <ul class="list-unstyled mb-3">

                            <li><strong>Reference Code:</strong> <span
                                    class="right">{{ $orders->format_order_id }}</span></li>

                            <li><strong>Service:</strong> <span class="right">{!! Helper::subservicename($orders->items[0]->subservice_id) !!}</span></li>

                            @if (isset($orders->items[0]->storage_type))
                                <li>
                                    <strong>Type of storage:</strong>
                                    <span class="right">
                                        {{ $orders->items[0]->storage_type }}
                                    </span>
                                </li>
                            @endif
                            @if (isset($orders->items[0]->storage_location))
                                <li>
                                    <strong>Where would you like to store:</strong>
                                    <span class="right">
                                        {{ $orders->items[0]->storage_location }}
                                    </span>
                                </li>
                            @endif
                            @if (isset($orders->items[0]->storage_from_date))
                                <li>
                                    <strong>From Date:</strong>
                                    <span class="right">
                                        {{ $orders->items[0]->storage_from_date }}
                                    </span>
                                </li>
                            @endif
                            @if (isset($orders->items[0]->storage_to_date))
                                <li>
                                    <strong>To Date:</strong>
                                    <span class="right">
                                        {{ $orders->items[0]->storage_to_date }}
                                    </span>
                                </li>
                            @endif
                            @if (isset($orders->items[0]->warehouse_name))
                                <li>
                                    <strong>Warehouse Name:</strong>
                                    <span class="right">
                                        {{ $orders->items[0]->warehouse_name }}
                                    </span>
                                </li>
                            @endif
                            @if (isset($orders->items[0]->unit_no))
                                <li>
                                    <strong>Unit No:</strong>
                                    <span class="right">
                                        {{ $orders->items[0]->unit_no }}
                                    </span>
                                </li>
                            @endif
                            @if (isset($orders->items[0]->emirate_id))
                                <li>
                                    <strong>Emirate ID:</strong>
                                    <span class="right">
                                        {{ $orders->items[0]->emirate_id }}
                                    </span>
                                </li>
                            @endif
                            @if (isset($orders->items[0]->trade_license))
                                <li>
                                    <strong>Company Trade Licence:</strong>
                                    <span class="right">
                                        {{ $orders->items[0]->trade_license }}
                                    </span>
                                </li>
                            @endif
                            @if (isset($orders->items[0]->space_required))
                                <li>
                                    <strong>Space Required:</strong>
                                    <span class="right">
                                        {{ $orders->items[0]->space_required }}
                                    </span>
                                </li>
                            @endif
                            @if (isset($orders->items[0]->space_price))
                                <li>
                                    <strong>Space Price:</strong>
                                    <span class="right">
                                        {{ $orders->items[0]->space_price }}
                                    </span>
                                </li>
                            @endif
                            @if (isset($orders->items[0]->items_to_store))
                                <li>
                                    <strong>What would you like to store?:</strong>
                                    <span class="right">
                                        {{ $orders->items[0]->items_to_store }}
                                    </span>
                                </li>
                            @endif



                            @php
                                $package_data = DB::table('ci_order_item_packages')
                                    ->where('order_id', $orders->order_id)
                                    ->get();
                                $filteredPackages = $package_data->filter(function ($item) {
                                    return $item->subservice_id != 28;
                                });
                            @endphp

                            @if ($filteredPackages->isNotEmpty())
                                <li>
                                    <strong>Service Details:</strong>
                                    <span class="right">
                                        @foreach ($filteredPackages as $data)
                                            {!! Helper::packages_enquiry($data->package_id) !!}<br>
                                        @endforeach
                                    </span>
                                </li>
                            @endif

                            @php
                                $addons_data = DB::table('ci_order_item_addons')
                                    ->where('order_id', $orders->order_id)
                                    ->get();
                                $filteredAddonsPackages = $addons_data->filter(function ($item) {
                                    return $item->subservice_id != 0;
                                });
                            @endphp

                            @if ($filteredAddonsPackages->isNotEmpty())
                                <li>
                                    <strong>Addons Details:</strong>
                                    <span class="right">
                                        @foreach ($filteredAddonsPackages as $data)
                                            {!! Helper::addonspackages_enquiry($data->package_id) !!} * {{ $data->package_quantity }}<br>
                                        @endforeach
                                    </span>
                                </li>
                            @endif

                            @if (isset($orders->items[0]->charger_type))
                                <li>
                                    <strong>Charger Type:</strong>
                                    <span class="right">
                                        {{ $orders->items[0]->charger_type }}
                                    </span>
                                </li>
                            @endif
                            @if (isset($orders->items[0]->installation_location_type))
                                <li>
                                    <strong>Installation Location Type:</strong>
                                    <span class="right">
                                        {{ $orders->items[0]->installation_location_type }}
                                    </span>
                                </li>
                            @endif

                            @php
                                $cleaNerscount = 0;

                                // ✅ Check from items
                                if (!empty($orders->items) && isset($orders->items[0]->how_many_cleaners_do_you_need)) {
                                    $cleaNerscount = $orders->items[0]->how_many_cleaners_do_you_need;
                                }
                                // ✅ Else check from cleaner_id
                                elseif (!empty($orders->items) && isset($orders->items[0]->cleaner_id)) {
                                    $cleaNerscount = count(explode(',', $orders->items[0]->cleaner_id));
                                }
                            @endphp



                            @if ($cleaNerscount > 0)
                                <li>
                                    <strong>No. of Cleaners:</strong>
                                    <span class="right">{{ $cleaNerscount }}</span>
                                </li>
                            @endif
                            @if (!empty($orders->items) && isset($orders->items[0]->how_many_hours_should_they_stay))
                                <li>
                                    <strong>No. of Hours:</strong>
                                    <span
                                        class="right">{{ $orders->items[0]->how_many_hours_should_they_stay }}</span>
                                </li>
                            @endif
                            @if (!empty($orders->items) && isset($orders->items[0]->which_day_of_the_week_do_you_want_the_service))
                                <li>
                                    <strong>Days of the week:</strong>
                                    <span
                                        class="right">{{ $orders->items[0]->which_day_of_the_week_do_you_want_the_service }}</span>
                                </li>
                            @endif
                            @if (!empty($orders->items) && isset($orders->items[0]->do_you_need_cleaning_material))
                                <li>
                                    <strong>Materials Provided:</strong>
                                    <span class="right">{{ $orders->items[0]->do_you_need_cleaning_material }}</span>
                                </li>
                            @endif



                            @if ($orders->items[0]->subservice_id == 28)
                                <li><strong>Frequency:</strong> <span
                                        class="right">{{ $orders->items[0]->how_often_do_you_need_cleaning }}</span>
                                </li>
                            @endif

                            <li><strong>Date & Time:</strong> <span
                                    class="right">{{ $orders->items[0]->bookingdate }}
                                    {{ $orders->items[0]->month }} {{ $orders->items[0]->bookingyear }},
                                    {!! Helper::timeslotname($orders->items[0]->time_slot) !!}</span></li>

                            @if ($orders->items[0]->service_id == 50 && $orders->items[0]->subservice_id == 92)
                                <li><strong>Vehicle Details:</strong> <span class="right">{!! Helper::vehiclename($orders->items[0]->verifybuy_vehicle) !!},
                                        {{ $orders->items[0]->verifybuy_model }}</span></li>

                                <li><strong>Address:</strong> <span
                                        class="right">{{ $orders->items[0]->verifybuy_address }}</span></li>
                            @else
                                <li><strong>Address:</strong> <span
                                        class="right">{{ $orders->items[0]->apartment_villa_no }},
                                        {{ $orders->items[0]->building_street_no }}, {{ $orders->items[0]->area }},
                                        {{ $orders->items[0]->city }}</span></li>
                            @endif

                            @if (!empty($orders->items) && isset($orders->items[0]->any_special_instruction))
                                <li><strong>Instruction:</strong> <span
                                        class="right">{{ $orders->items[0]->any_special_instruction }}</span>
                                </li>
                            @endif


                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Show more popup end --}}

{{-- Edit this booking popup start --}}

@if (isset($orders))
    <div class="modal fade subservice-read-more-model" id="EditbookingModal" tabindex="-1"
        aria-labelledby="EditbookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content ">

                <div class="modal-header">
                    <h5 class="modal-title" id="EditbookingModalLabel">Edit This Booking</h5>
                    <button type="button" class="close closeBtn" id="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($orders->items[0]->service_id != 50)
                        <div class="edit_booking_popup">
                            <ul class="list-unstyled mb-3">
                                <div class="option-row-receipt">
                                    <li>
                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#Edit_address_Modal"
                                            class="d-flex align-items-center justify-content-between text-decoration-none text-muted">
                                            <div class="option-label">
                                                <p class="bookagain">Change Address</p>
                                            </div>
                                            <div class="arrow-icongethelp"></div>
                                        </a>
                                    </li>
                                </div>
                            </ul>
                        </div>
                        <hr>
                        @php
                            $date = $orders->items[0]->bookingdate;
                            $monthName = $orders->items[0]->month;
                            $year = $orders->items[0]->bookingyear;

                            $fullDateStr = $date . ' ' . $monthName . ' ' . $year;
                            $bookingDate = \Carbon\Carbon::createFromFormat('d F Y', $fullDateStr);
                            $today = \Carbon\Carbon::today();
                        @endphp
                        @if ($bookingDate->gt($today))
                            <div class="edit_booking_popup">
                                <ul class="list-unstyled mb-3">
                                    <div class="option-row-receipt">
                                        <li>
                                            <div
                                                class="d-flex align-items-center justify-content-between text-decoration-none text-muted">
                                                <div class="option-label">
                                                    <a href="{{ route('reschedule', $orders->order_id) }}"
                                                        class="bookagain">Reschedule</a>
                                                </div>
                                                <div class="arrow-icongethelp"></div>
                                            </div>
                                        </li>
                                    </div>
                                </ul>
                            </div>
                            <hr>
                        @endif
                    @endif

                    <div class="edit_booking_popup">
                        <ul class="list-unstyled mb-3">
                            <div class="option-row-receipt">
                                <li>
                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                        data-bs-target="#Edit_cancel_Modal"
                                        class="d-flex align-items-center justify-content-between text-decoration-none text-muted">
                                        <div class="option-label">
                                            <p class="bookagain">Cancel</p>
                                        </div>
                                        <div class="arrow-icongethelp"></div>
                                    </a>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Edit this booking popup end --}}



<!-- Edit_address_Modal Start-->
@if (isset($orders))
    <div class="modal fade subservice-read-more-model" id="Edit_address_Modal" tabindex="-1"
        aria-labelledby="Edit_address_ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Edit Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>

                <form id="update_address_form" action="{{ route('update-address') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $orders->order_id }}">

                    <div class="modal-body pt-2 pb-0">
                        <div class="mb-2">
                            <select class="form-control form-select" name="city" id="city">
                                <option value="">Select City</option>
                                <option value="Dubai" {{ $orders->items[0]->city == 'Dubai' ? 'selected' : '' }}>
                                    Dubai</option>
                                <option value="Abu Dhabhi"
                                    {{ $orders->items[0]->city == 'Abu Dhabhi' ? 'selected' : '' }}>Abu Dhabhi</option>
                                <option value="Sharjah" {{ $orders->items[0]->city == 'Sharjah' ? 'selected' : '' }}>
                                    Sharjah</option>
                            </select>
                            <p class="alert alert-danger d-none mt-2" id="edit_city_message"></p>
                        </div>

                        <div class="mb-2">
                            <input type="text" name="area" id="area" class="form-control"
                                placeholder="Enter Your Area" value="{{ $orders->items[0]->area }}">
                            <p class="alert alert-danger d-none mt-2" id="edit_area_message"></p>
                        </div>

                        <div class="mb-2">
                            <input type="text" name="building_street_no" id="building_street_no"
                                class="form-control" placeholder="Enter your building name and/or street"
                                value="{{ $orders->items[0]->building_street_no }}">
                            <p class="alert alert-danger d-none mt-2" id="edit_building_street_no_message"></p>
                        </div>

                        <div class="mb-2">
                            <input type="text" name="apartment_villa_no" id="apartment_villa_no"
                                class="form-control"
                                placeholder="Enter your apartment number &amp; floor or villa number"
                                value="{{ $orders->items[0]->apartment_villa_no }}">
                            <p class="alert alert-danger d-none mt-2" id="edit_apartment_villa_no_message"></p>
                        </div>

                        <div class="text-center mt-3 mb-3">
                            <input type="button" class="btn px-5 py-2 rounded-pill" id="edit_instruction_btn"
                                value="Update" onclick="Update_address();">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endif

<!-- Edit_address_Modal End-->



<!-- Edit_cancel_Modal Start-->
@if (isset($orders))
    <div class="modal fade subservice-read-more-model" id="Edit_cancel_Modal" tabindex="-1"
        aria-labelledby="Edit_cancel_ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Cancel Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>
                <div class="modal-body">
                    <form action="{{ route('cancel-order') }}" id="cancel_form" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" id="order_id" value="{{ $orders->order_id }}">
                        <p class="text-center fw-bold" style="font-size: 17px;">Are you sure you want to cancel this
                            order?</p>
                        <div class="text-center">
                            <input type="button" class="btn btn-danger white-text" id="cancel_order_btn"
                                data-bs-dismiss="modal" value="Cancel">
                            <input type="button" class="btn btn-primary white-text" id="submit_order_btn"
                                value="Submit" onclick="cancel_order()">
                        </div>
                    </form>
                </div>



            </div>
        </div>
    </div>
@endif

<!-- Edit_cancel_Modal End-->

<!-- Confirm Status Modal -->
<div class="modal fade subservice-read-more-model" id="ConfirmModal" tabindex="-1"
    aria-labelledby="ConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="ConfirmModalLabel">Learn What Is Next</h5>
                <button type="button" class="close closeBtn" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>



            <div class="modal-body">
                <div class="status-popup">


                    <ul class="status-steps">
                        @php
                            $steps = [];

                            $steps[] = [
                                'label' => 'Booking Requested',
                                'icon' => '<i class="fa-solid fa-calendar-check"></i>',
                                'desc' =>
                                    'Your booking request has been received. please wait for confirmation from a service provider.',
                            ];

                            if ($orders->items[0]->service_id != 50) {
                                $steps[] = [
                                    'label' => 'Booking Confirmed',
                                    'icon' => '<i class="fa-solid fa-check"></i>',
                                    'desc' =>
                                        'A Service provider has accepted your booking.Your booking will be delivered as per the booked date and time.',
                                ];
                            } else {
                                $steps[] = [
                                    'label' => 'Awaiting Confirmation',
                                    'icon' => '<i class="fa-solid fa-check"></i>',
                                    'desc' =>
                                        'A Service provider has accepted your booking.Your booking will be delivered as per the booked date and time.',
                                ];
                            }

                            $steps[] = [
                                'label' => 'On the way',
                                'icon' => '<i class="fa-solid fa-truck"></i>',
                                'desc' => 'The vendor is on their way to your location. Get ready!',
                            ];
                            $steps[] = [
                                'label' => 'In progress',
                                'icon' => '<i class="fa-solid fa-spinner"></i>',
                                'desc' => 'Work is currently underway. We’ll keep you posted!',
                            ];
                            $steps[] = [
                                'label' => 'Booking Completed',
                                'icon' => '<i class="fa-solid fa-check-circle"></i>',
                                'desc' => 'All done! We hope you’re satisfied with the service.',
                            ];
                        @endphp

                        @foreach ($steps as $index => $step)
                            <li class="{{ $index <= $currentStep ? 'active' : '' }}">
                                <div class="icon-circle">{!! $step['icon'] !!}</div>
                                <div class="status-text">
                                    <div class="status-title">{{ $step['label'] }}</div>

                                    {{-- Only show description for the current step --}}
                                    @if ($step['desc'])
                                        <div class="status-desc"
                                            style="{{ $index === $currentStep ? '' : 'display: none;' }}">
                                            {{ $step['desc'] }}
                                        </div>
                                    @endif
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>


{{-- Status Modal End --}}


<!-- complete Status Modal -->
<div class="modal fade subservice-read-more-model" id="CompleteModal" tabindex="-1"
    aria-labelledby="CompleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="CompleteModalLabel">Learn What Is Next</h5>
                <button type="button" class="close closeBtn" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>



            <div class="modal-body">
                <div class="status-popup">

                    <ul class="status-steps">
                        @php
                            $steps = [];

                            if ($orders->items[0]->service_id != 50) {
                                $steps[] = [
                                    'label' => 'Confirmed',
                                    'icon' => '<i class="fa-solid fa-check"></i>',
                                    'desc' => 'Your booking is confirmed! Sit back while we get things ready.',
                                ];
                            } else {
                                $steps[] = [
                                    'label' => 'Awaiting Confirmation',
                                    'icon' => '<i class="fa-solid fa-check"></i>',
                                    'desc' => 'Your booking is confirmed! Sit back while we get things ready.',
                                ];
                            }
                            $steps[] = [
                                'label' => 'On the way',
                                'icon' => '<i class="fa-solid fa-truck"></i>',
                                'desc' => 'The vendor is on their way to your location. Get ready!',
                            ];
                            $steps[] = [
                                'label' => 'In progress',
                                'icon' => '<i class="fa-solid fa-spinner"></i>',
                                'desc' => 'Work is currently underway. We’ll keep you posted!',
                            ];
                            $steps[] = [
                                'label' => 'Completed',
                                'icon' => '<i class="fa-solid fa-check-circle"></i>',
                                'desc' => 'All done! We hope you’re satisfied with the service.',
                            ];
                        @endphp


                        @foreach ($steps as $index => $step)
                            <li class="{{ $index <= $currentStep ? 'active' : '' }}">
                                <div class="icon-circle">{!! $step['icon'] !!}</div>
                                <div class="status-text">
                                    <div class="status-title">{{ $step['label'] }}</div>

                                    {{-- Only show description for the current step --}}
                                    @if ($step['desc'])
                                        <div class="status-desc"
                                            style="{{ $index === $currentStep ? '' : 'display: none;' }}">
                                            {{ $step['desc'] }}
                                        </div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>


{{-- complete Modal End --}}


<!-- Edit_instruction_Modal Start-->
@if (isset($orders))
    <div class="modal fade subservice-read-more-model" id="Edit_instruction_Modal" tabindex="-1"
        aria-labelledby="Edit_instruction_ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Edit instructions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>

                <form id="update_instruction_form" action="{{ route('update-instruction') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $orders->order_id }}">

                    <div class="modal-body pt-2 pb-0">
                        <div class="mb-2">
                            <textarea class="form-control rounded shadow-sm" id="edit_instruction" name="edit_instruction" rows="4"
                                cols="50" placeholder="Enter your instruction here...">{{ $orders->items[0]->any_special_instruction }}</textarea>
                            <p class="alert alert-danger d-none mt-2" id="edit_instruction_message"></p>
                        </div>

                        <div class="text-center mt-3 mb-3">
                            <input type="button" class="btn px-5 py-2 rounded-pill" id="edit_instruction_btn"
                                value="Update" onclick="Update_instruction();">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endif

<!-- Edit_instruction_Modal End-->


<!-- getHelpModal Start-->
@if (isset($orders))

    @php
        $subserviceId = $orders->items[0]->subservice_id;

        $help = DB::table('help')
            ->whereRaw('FIND_IN_SET(?, subservice)', [$subserviceId])
            ->get();
    @endphp

    <!-- Help Modal -->
    <div class="modal fade subservice-read-more-model" id="getHelpModal" tabindex="-1"
        aria-labelledby="getHelpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold ">Appointment Help</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>
                @foreach ($help as $data)
                    <div class="help_que_popup">
                        <ul class="list-unstyled mb-3">
                            <div class="option-row-receipt">
                                <li>
                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                        data-bs-target="#help_que_Modal_{{ $data->id }}"
                                        class="d-flex align-items-center justify-content-between text-decoration-none text-muted">
                                        <div class="option-label">
                                            <p class="bookagain">{{ $data->question }}</p>
                                        </div>
                                        <div class="arrow-icongethelp"></div>
                                    </a>
                                </li>
                            </div>
                        </ul>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <!-- Dynamic Answer Modals for Each Question -->
    @foreach ($help as $data)
        <div class="modal fade subservice-read-more-model" id="help_que_Modal_{{ $data->id }}" tabindex="-1"
            aria-labelledby="helpQueModalLabel_{{ $data->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content help-que-modal">

                    <div class="modal-header border-0 pb-0">

                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <hr>
                    <div class="modal-body">
                        <h6 class="modal-title fw-bold mb-3">{{ $data->question }}</h6>

                        <p>{{ $data->answers }}</p>

                        <div class="text-center mt-3 mb-3">
                            @if ($data->appointment == 1)
                                <a href="{{ route('order-detail', $orders->order_id) }}"
                                    class="btn px-5 py-2 rounded-pill" id="edit_instruction_btn">APPOINTMENT
                                    DETAILS</a>
                            @endif
                        </div>
                        <div class="text-center mt-3 mb-3">
                            @if ($data->ticket == 1)
                                <a href="https://web.whatsapp.com/send?phone=971502827864" target="_blank"
                                    id="whatsapp_Button" class="btn px-5 py-2 rounded-pill"> CREATE SUPPORT TICKET
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach

@endif


<!-- getHelpModal End-->


{{-- help_que_Modal_Stat --}}


{{-- Review model --}}

<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <input type="hidden" id="review_order_id">
                <input type="hidden" id="review_visit_date">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 px-4 pb-4">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="bi bi-chat-left-quote-fill text-primary" style="font-size: 40px; opacity: 0.2;"></i>
                    </div>
                    <h4 class="fw-bold mb-1">Rate Your Cleaner</h4>
                    <p class="text-muted">Your feedback helps us improve.</p>
                </div>

                <div class="rating-wrapper mb-4">
                    <input type="radio" name="rating" id="star5" value="5"><label for="star5"
                        class="bi bi-star-fill"></label>
                    <input type="radio" name="rating" id="star4" value="4"><label for="star4"
                        class="bi bi-star-fill"></label>
                    <input type="radio" name="rating" id="star3" value="3"><label for="star3"
                        class="bi bi-star-fill"></label>
                    <input type="radio" name="rating" id="star2" value="2"><label for="star2"
                        class="bi bi-star-fill"></label>
                    <input type="radio" name="rating" id="star1" value="1"><label for="star1"
                        class="bi bi-star-fill"></label>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small text-uppercase text-muted">Review Details</label>
                    <textarea id="review_content" class="form-control bg-light border-0" rows="4"
                        placeholder="Share your experience with us..." style="border-radius: 12px; resize: none;"></textarea>
                </div>

                <button type="button" id="btnSubmitReview" class="btn btn-primary w-100 py-3 fw-bold"
                    style="border-radius: 12px; background: #0040E6;">
                    Submit My Review
                </button>
            </div>
        </div>
    </div>
</div>
{{-- review model end --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- help_que_Modal_End --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('whatsapp_Button')?.addEventListener('click', function() {
            const phoneNumber = "971502827864"; // Replace with your WhatsApp number
            const message = "Hello, I need support regarding my order."; // Your default message

            window.open(`https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`, '_blank');
        });
    });
</script>

<script>
    function Update_instruction() {
        const instruction = $('#edit_instruction').val().trim();

        if (instruction === "") {
            $('#edit_instruction_message')
                .removeClass('d-none')
                .text('Please enter instruction');
            $('html, body').animate({
                scrollTop: $('#edit_instruction').offset().top - 150
            }, 500);
            setTimeout(() => {
                $('#edit_instruction_message').addClass('d-none').text('');
            }, 3000);
            return false;
        }
        $('#update_instruction_form').submit();
    }

    function Update_address() {

        const city = $('#city').val().trim();

        if (city === "") {
            $('#edit_city_message')
                .removeClass('d-none')
                .text('Please Select City');
            $('html, body').animate({
                scrollTop: $('#city').offset().top - 150
            }, 500);
            setTimeout(() => {
                $('#edit_city_message').addClass('d-none').text('');
            }, 3000);
            return false;
        }

        const area = $('#area').val().trim();

        if (area === "") {
            $('#edit_area_message')
                .removeClass('d-none')
                .text('Please Enter Area');
            $('html, body').animate({
                scrollTop: $('#area').offset().top - 150
            }, 500);
            setTimeout(() => {
                $('#edit_area_message').addClass('d-none').text('');
            }, 3000);
            return false;
        }

        const building_street_no = $('#building_street_no').val().trim();

        if (building_street_no === "") {
            $('#edit_building_street_no_message')
                .removeClass('d-none')
                .text('Please Enter Building Street No');
            $('html, body').animate({
                scrollTop: $('#building_street_no').offset().top - 150
            }, 500);
            setTimeout(() => {
                $('#edit_building_street_no_message').addClass('d-none').text('');
            }, 3000);
            return false;
        }

        const apartment_villa_no = $('#apartment_villa_no').val().trim();

        if (apartment_villa_no === "") {
            $('#edit_apartment_villa_no_message')
                .removeClass('d-none')
                .text('Please Enter Apartment Villa No');
            $('html, body').animate({
                scrollTop: $('#apartment_villa_no').offset().top - 150
            }, 500);
            setTimeout(() => {
                $('#edit_apartment_villa_no_message').addClass('d-none').text('');
            }, 3000);
            return false;
        }

        $('#update_address_form').submit();

    }

    function cancel_order() {
        $('#cancel_form').submit();
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

    function openReviewModal(orderId, visitDate) {
        document.getElementById('review_order_id').value = orderId;
        document.getElementById('review_visit_date').value = visitDate;
        // Optionally reset the form
        document.getElementById('review_content').value = '';
        const selectedRating = document.querySelector('input[name="rating"]:checked');
        if (selectedRating) selectedRating.checked = false;
    }

    document.getElementById('btnSubmitReview').addEventListener('click', function() {

        const btn = this;
        const originalText = btn.innerHTML;

        const selectedRating = document.querySelector('input[name="rating"]:checked');
        const rating = selectedRating ? selectedRating.value : '';
        const content = document.getElementById('review_content').value.trim();
        const order_id = document.getElementById('review_order_id').value;
        const visit_date = document.getElementById('review_visit_date').value;

        // Validation
        if (!rating) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Please select a star rating"
            });
            return;
        }

        // Content validation removed to allow rating-only submissions

        // ✅ Start loading
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span> Submitting...`;

        $.ajax({
            url: "{{ route('submit.review') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                rating: rating,
                content: content,
                order_id: order_id,
                visit_date: visit_date
            },
            success: function(response) {

                if (response.status == 1) {

                    $('#reviewModal').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            },
            error: function(xhr) {

                // ❌ Restore button
                btn.disabled = false;
                btn.innerHTML = originalText;

                let errors = xhr.responseJSON?.errors;
                let errorMsg = '';

                if (errors) {
                    $.each(errors, function(key, value) {
                        errorMsg += value[0] + '\n';
                    });
                } else {
                    errorMsg = 'Something went wrong!';
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: errorMsg
                });
            }
        });

    });
</script>
