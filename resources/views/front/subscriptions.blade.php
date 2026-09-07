@include('front.includes.header')

<style>
    .mar-btn {
        margin-bottom: 60px;
    }

    @media (min-width: 768px) and (max-width: 1024px) {
        .sidebar-left {
            display: none !important;
        }
    }

    /* Subscription Card Premium UI */
    .sub-page-header {
        display: flex;
        align-items: center;
        margin-bottom: 24px;
    }
    
    .sub-back-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4b5563;
        text-decoration: none;
        margin-right: 16px;
        transition: all 0.2s;
    }
    
    .sub-back-btn:hover {
        background-color: #f3f4f6;
        color: #111827;
    }
    
    .sub-page-title {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .sub-tabs-container {
        display: flex;
        gap: 12px;
        margin-bottom: 30px;
    }
    
    .sub-tab {
        padding: 8px 24px;
        border-radius: 9999px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    
    .sub-tab.active {
        background-color: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
    }
    
    .sub-tab:not(.active) {
        background-color: #ffffff;
        color: #4b5563;
        border-color: #e5e7eb;
    }
    
    .sub-tab:not(.active):hover {
        background-color: #f9fafb;
    }

    .sub-card {
        background: #ffffff;
        border: 1px solid #f3f4f6;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        overflow: hidden;
        margin-bottom: 24px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .sub-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .sub-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 20px;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .sub-icon-wrapper {
        width: 50px;
        height: 50px;
        background-color: #f8fafc;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
        flex-shrink: 0;
    }
    
    .sub-icon-wrapper img {
        width: 32px;
        height: 32px;
        object-fit: contain;
    }
    
    .sub-title {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 4px 0;
    }
    
    .sub-meta {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
        margin: 0;
    }
    
    .sub-status {
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .sub-status.active {
        background-color: #dcfce7;
        color: #166534;
    }
    
    .sub-status.active::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #166534;
    }
    
    .sub-status.cancelled {
        background-color: #fef2f2;
        color: #991b1b;
    }
    
    .sub-status.cancelled::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #991b1b;
    }
    
    .sub-card-body {
        padding: 20px;
    }
    
    .sub-label {
        font-size: 11px;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }
    
    .sub-value {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
    }
    
    .sub-progress-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 8px;
    }
    
    .sub-progress-text {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }
    
    .sub-progress-percent {
        font-size: 14px;
        color: #16a34a;
        font-weight: 700;
    }
    
    .sub-progress-bar-bg {
        height: 4px;
        background-color: #e5e7eb;
        border-radius: 2px;
        margin-bottom: 16px;
        overflow: hidden;
    }
    
    .sub-progress-bar-fill {
        height: 100%;
        background-color: #16a34a;
        border-radius: 2px;
    }
    
    .sub-renewal-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .sub-renewal-text {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .sub-renewal-icon {
        color: #3b82f6;
        font-size: 14px;
    }
    
    .sub-price {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
    }
    
    .sub-manage-btn {
        display: block;
        width: 100%;
        background-color: #1a0bdb;
        color: #ffffff;
        text-align: center;
        padding: 12px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        text-decoration: none;
        transition: background-color 0.2s;
        border: none;
    }
    
    .sub-manage-btn:hover {
        background-color: #1207ab;
        color: #ffffff;
    }

</style>
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

    .tab-container {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        /* max-width: 600px; */
        margin: 0 auto;
        /* padding: 1rem; */
    }

    .nav-tabs {
        width: 100%;

    }

    .nav-item {
        width: 50%;
    }

    .nav-tabs .nav-link {
        font-weight: 600;
        color: #212529;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        width: 100%;
    }

    .nav-tabs .nav-link.active {
        color: #0040E6;
        border-color: #0040E6;
    }

    .appointment-card {
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        padding: 1rem 1.25rem;
        margin-top: 1rem;
    }

    .appointment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #000;
    }

    .appointment-time {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .appointment-user {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
        color: #000;
    }

    .appointment-user svg {
        width: 20px;
        height: 20px;
        color: #0040E6;
    }

    .star-rating {
        color: #f0ad4e;
        font-weight: 600;
        margin-left: 0.25rem;
        user-select: none;
    }

    .status-completed {
        background-color: #ecfdf5;
        color: #059669;
        font-weight: 700;
        font-size: 11px;
        padding: 4px 12px;
        border-radius: 6px;
        user-select: none;
        white-space: nowrap;
        border: 1px solid #d1fae5;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .upcoming {
        background-image: url(https://deax38zvkau9d.cloudfront.net/prod/assets/static/group-2.jpg?f=webp);
        background-size: contain;
        height: 400px;
        background-repeat: no-repeat;
    }

    .upcoming p {
        color: #000;
        text-align: center;
    }

    .badge-style {
        display: inline-flex;
        align-items: center;
        background-color: #e8f8ff;
        color: #0040E6;
        font-weight: 500;
        font-size: 14px;
        padding: 4px 10px;
        border-radius: 6px;
        margin-top: 5px;
    }

    .verified-user {
        display: flex;
        align-items: center;
        font-weight: 500;
        color: #333;
        font-size: 14px;
        margin-top: 8px;
    }

    .verified-user i {
        font-size: 18px;
        color: #0040E6;
        background-color: #e8f8ff;
        border-radius: 50%;
        padding: 4px;
    }

    /* --- PREMIUM PAGINATION STYLES --- */
    .custom-pagination {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #f1f5f9;
        width: 100%;
        clear: both;
    }

    .custom-pagination nav {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        gap: 1.25rem !important;
        width: 100% !important;
    }

    /* Hide mobile-only defaults */
    .custom-pagination .flex.justify-between.flex-1.sm\:hidden {
        display: none !important;
    }

    /* Container for info and links */
    .custom-pagination .hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        gap: 1rem !important;
        width: 100% !important;
    }

    /* "Showing X to Y of Z" results */
    .custom-pagination .text-sm.text-gray-700 {
        color: #94a3b8 !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        margin: 0 !important;
        order: 2;
    }

    /* New Premium Pagination Design */
    .custom-new-pagination {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        margin-top: 30px !important;
        margin-bottom: 30px !important;
    }

    .pagination-info {
        color: #64748b !important;
        font-weight: 500 !important;
        font-size: 15px !important;
    }

    .pagination-links {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
    }

    .pagination-link,
    .pagination-active,
    .pagination-ellipsis {
        font-weight: 600 !important;
        font-size: 15px !important;
        text-decoration: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 36px !important;
        height: 36px !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .pagination-link {
        color: #475569 !important;
    }

    .pagination-link:hover {
        color: #0040E6 !important;
        transform: scale(1.1) !important;
    }

    .pagination-active {
        background-color: #0040E6 !important;
        color: #fff !important;
        border-radius: 50% !important;
        box-shadow: 0 4px 10px rgba(0, 64, 230, 0.3) !important;
    }

    .pagination-next {
        color: #0040E6 !important;
        font-weight: 700 !important;
        text-decoration: none !important;
        margin-left: 15px !important;
        font-size: 14px !important;
        letter-spacing: 0.5px !important;
        transition: all 0.2s !important;
    }

    .pagination-next:hover {
        color: #002db3 !important;
        transform: translateX(3px) !important;
    }

    .pagination-next.disabled {
        color: #cbd5e1 !important;
        cursor: not-allowed !important;
    }

    @media (max-width: 640px) {
        .custom-new-pagination {
            flex-direction: column !important;
            gap: 20px !important;
        }
    }


    .mar-btn {
        margin-bottom: 60px;
    }

    section {
        padding: 0px 0px;
        !important;
    }

    @media (min-width: 768px) and (max-width: 1024px) {

        .sidebar-left {
            display: none !important;
        }
    }

    .tip-btn {
        background-color: #0040E6;
        color: white;
        border: none;
        padding: 5px 15px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 10px;
        transition: background-color 0.3s;
    }

    .tip-btn:hover {
        background-color: #0030b3;
    }

    .tip-info {
        font-size: 13px;
        color: #28a745;
        font-weight: 600;
        margin-top: 5px;
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

<div class="body_content">
    <section class="our-login mt120">
        <div class="container mar-btn">
            <div class="row">
                <div class="col-lg-4 sidebar-left">
                    @include('front.account_sidebar')
                </div>

                <div class="col-lg-8">
                    <!-- Page Header -->
                    <div class="sub-page-header">
                        <a href="javascript:history.back()" class="sub-back-btn">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h2 class="sub-page-title">Subscriptions</h2>
                    </div>
                    
                    <!-- Tabs -->
                    <div class="sub-tabs-container">
                        <a href="#" class="sub-tab active">Active</a>
                        <a href="#" class="sub-tab">Paused</a>
                        <a href="#" class="sub-tab">Cancelled</a>
                    </div>

                    @if (count($subscriptions) > 0)
                        <div class="row">
                            @foreach ($subscriptions as $sub)
                                @php
                                    $progress_percent = $sub->visits_per_cycle > 0 ? round(($sub->visits_completed / $sub->visits_per_cycle) * 100) : 0;
                                @endphp
                                <div class="col-md-6">
                                    <div class="sub-card" onclick="window.location.href='{{ route('front.subscription_detail', ['id' => $sub->id]) }}'" style="cursor: pointer;">
                                        <!-- Header -->
                                        <div class="sub-card-header">
                                            <div class="d-flex align-items-center">
                                                <div class="sub-icon-wrapper">
                                                    <img src="{{ asset('public/assets/images/service-placeholder.png') }}" onerror="this.src='https://cdn-icons-png.flaticon.com/512/994/994928.png'" alt="icon">
                                                </div>
                                                <div>
                                                    <h3 class="sub-title">{{ $sub->category }}</h3>
                                                    <p class="sub-meta">{{ $sub->frequency_desc }} &bull; {{ $sub->visits_per_cycle }} visits/cycle</p>
                                                </div>
                                            </div>
                                            @if($sub->status == 'ACTIVE')
                                                <span class="sub-status active">Active</span>
                                            @elseif($sub->status == 'CANCELLED')
                                                <span class="sub-status cancelled">Cancelled</span>
                                            @else
                                                <span class="sub-status" style="background-color: #f3f4f6; color: #4b5563;">{{ ucfirst(strtolower($sub->status)) }}</span>
                                            @endif
                                        </div>
                                        
                                        <!-- Body -->
                                        <div class="sub-card-body">
                                            <div class="sub-label">NEXT VISIT</div>
                                            <div class="sub-value">{{ $sub->next_visit_date }} &bull; {{ $sub->next_visit_time }}</div>
                                            
                                            <div class="sub-progress-header">
                                                <div class="sub-progress-text">{{ $sub->visits_completed }} of {{ $sub->visits_per_cycle }} visits completed</div>
                                                <div class="sub-progress-percent">{{ $progress_percent }}%</div>
                                            </div>
                                            <div class="sub-progress-bar-bg">
                                                <div class="sub-progress-bar-fill" style="width: {{ $progress_percent }}%;"></div>
                                            </div>
                                            
                                            <div class="sub-renewal-row">
                                                <div class="sub-renewal-text">
                                                    <i class="fas fa-sync-alt sub-renewal-icon"></i> Renews on {{ $sub->next_renewal }}
                                                </div>
                                                <div class="sub-price">{{ $sub->renewal_amount }}</div>
                                            </div>
                                            
                                            <button onclick="event.stopPropagation(); window.location.href='{{ route('front.subscription_detail', ['id' => $sub->id]) }}'" class="sub-manage-btn">
                                                Manage Subscription
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="background: #f8f9fc; border: 1px solid #eef0f7; border-radius: 12px; padding: 40px 20px; text-align: center;">
                            <div style="font-size: 48px; color: #cbd5e1; margin-bottom: 15px;">
                                <i class="far fa-folder-open"></i>
                            </div>
                            <h4 style="font-size: 18px; color: #475569; font-weight: 600; margin-bottom: 10px;">No Active Subscriptions</h4>
                            <p style="color: #64748b; font-size: 15px; margin: 0;">You don't have any active subscriptions.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

@include('front.includes.footer')
