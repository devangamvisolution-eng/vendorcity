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
    
    .subscription-card {
        border: 1px solid #eaeaea;
        border-radius: 12px;
        transition: all 0.3s ease;
        background: #fff;
        height: 100%;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
    }
    
    .subscription-card:hover {
        box-shadow: 0 10px 15px rgba(0,0,0,0.05);
        transform: translateY(-2px);
    }
    
    .subscription-header {
        padding: 20px;
        border-bottom: 1px solid #f5f5f5;
        background-color: #fafbfc;
        border-radius: 12px 12px 0 0;
    }
    
    .subscription-title {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 5px 0;
        line-height: 1.4;
    }

    .subscription-subtitle {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 10px;
        font-weight: 500;
    }
    
    .status-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }
    
    .status-active {
        background-color: #ecfdf5;
        color: #059669;
        border: 1px solid #d1fae5;
    }

    .status-pending {
        background-color: #fffbeb;
        color: #d97706;
        border: 1px solid #fef3c7;
    }
    
    .status-cancelled {
        background-color: #fef2f2;
        color: #dc2626;
        border: 1px solid #fee2e2;
    }
    
    .status-expired {
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    
    .subscription-body {
        padding: 20px;
        flex: 1;
    }
    
    .next-visit-block {
        background-color: #f8fafc;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        border-left: 4px solid #0040E6;
    }
    
    .next-visit-label {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }
    
    .next-visit-value {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .progress-section {
        margin-bottom: 20px;
    }
    
    .progress-text {
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
    }
    
    .progress-dots {
        display: flex;
        gap: 6px;
    }
    
    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #e2e8f0;
    }
    
    .dot.completed {
        background-color: #0040E6;
    }
    
    .renewal-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px dashed #e2e8f0;
        padding-top: 15px;
    }
    
    .renewal-date {
        font-size: 13px;
        color: #64748b;
    }
    
    .renewal-date strong {
        color: #334155;
    }
    
    .renewal-amount {
        font-size: 16px;
        font-weight: 700;
        color: #0040E6;
    }
    
    .subscription-footer {
        padding: 20px;
        border-top: 1px solid #f5f5f5;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-primary-custom {
        background-color: #0040E6;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s;
        display: block;
        width: 100%;
    }
    
    .btn-primary-custom:hover {
        background-color: #0030b3;
        color: #fff;
    }
    
    .btn-secondary-custom {
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s;
        display: block;
        width: 100%;
    }
    
    .btn-secondary-custom:hover {
        background-color: #e2e8f0;
        color: #1e293b;
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
                    <div style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                        <h2 style="font-weight: 700; font-size: 24px; margin: 0;">My Subscriptions</h2>
                    </div>

                    @if (count($subscriptions) > 0)
                        <div class="row">
                            @foreach ($subscriptions as $sub)
                                <div class="col-md-6 mb-4">
                                    <div class="subscription-card" onclick="window.location.href='{{ route('front.subscription_detail', ['id' => $sub->id]) }}'" style="cursor: pointer;">
                                        <div class="subscription-header">
                                            <h3 class="subscription-title">{{ $sub->category }}</h3>
                                            <div class="subscription-subtitle">{{ $sub->plan_name }} &bull; {{ $sub->frequency_desc }} &bull; {{ $sub->visits_per_cycle }} visits/cycle</div>
                                            
                                            @if($sub->status == 'ACTIVE')
                                                <span class="status-badge status-active">Active</span>
                                            @elseif($sub->status == 'PENDING ACTIVATION')
                                                <span class="status-badge status-pending">Pending Activation</span>
                                            @elseif($sub->status == 'CANCELLED')
                                                <span class="status-badge status-cancelled">Cancelled</span>
                                            @else
                                                <span class="status-badge status-expired">{{ ucfirst(strtolower($sub->status)) }}</span>
                                            @endif
                                        </div>
                                        
                                        <div class="subscription-body">
                                            <div class="next-visit-block">
                                                <div class="next-visit-label">Next Visit</div>
                                                <div class="next-visit-value">{{ $sub->next_visit_date }} &bull; {{ $sub->next_visit_time }}</div>
                                            </div>
                                            
                                            <div class="progress-section">
                                                <div class="progress-text">{{ $sub->visits_completed }} of {{ $sub->visits_per_cycle }} visits completed</div>
                                                <div class="progress-dots">
                                                    @for ($i = 0; $i < $sub->visits_per_cycle; $i++)
                                                        <span class="dot {{ $i < $sub->visits_completed ? 'completed' : '' }}"></span>
                                                    @endfor
                                                </div>
                                            </div>
                                            
                                            <div class="renewal-info">
                                                <div class="renewal-date">Next renewal: <strong>{{ $sub->next_renewal }}</strong></div>
                                                <div class="renewal-amount">{{ $sub->renewal_amount }}</div>
                                            </div>
                                        </div>
                                        
                                        <div class="subscription-footer">
                                            <a href="{{ route('front.subscription_detail', ['id' => $sub->id]) }}" class="btn-primary-custom" onclick="event.stopPropagation();">Manage Subscription</a>
                                            <a href="{{ route('front.subscription_detail', ['id' => $sub->id]) }}#upcoming" class="btn-secondary-custom" onclick="event.stopPropagation();">View Upcoming Visits</a>
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
