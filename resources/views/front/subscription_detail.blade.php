@include('front.includes.header')

<link rel="stylesheet" href="{{ asset('public/site/css/select2/css/select2.min.css') }}">
<style>
    .select2-container--default .select2-selection--single {
        height: 42px;
        padding: 6px 10px;
        font-size: 14px;
        border: 1px solid #dbe1e8;
        border-radius: 8px;
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #1e293b;
        line-height: normal;
        padding-left: 0;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
        right: 10px;
    }
    .select2-container--default .select2-selection--single .select2-selection__clear {
        position: absolute;
        right: 35px;
        top: 50%;
        transform: translateY(-50%);
        margin-right: 0;
        font-size: 18px;
        color: #94a3b8;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #0040E6;
    }
    .select2-dropdown {
        border: 1px solid #dbe1e8;
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        z-index: 99999;
    }
    .select2-search__field {
        border-radius: 6px !important;
        border: 1px solid #dbe1e8 !important;
        padding: 8px 12px !important;
    }
</style>
<style>
    .mar-btn { margin-bottom: 60px; }
    @media (min-width: 768px) and (max-width: 1024px) { .sidebar-left { display: none !important; } }
    
    .body_content { background-color: #f8fafc; }
    .detail-card {
        background: #fff; border: 1px solid #dbe1e8; border-radius: 16px; box-shadow: 0 1px 2px rgba(15,23,42,0.04), 0 8px 20px rgba(15,23,42,0.06); overflow: hidden; margin-bottom: 24px;
    }
    
    /* Top Header */
    .detail-header {
        padding: 24px 20px; text-align: center; border-bottom: 1px solid #e2e8f0; background: linear-gradient(180deg, #fbfcfd 0%, #ffffff 100%);
    }
    .detail-category { font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
    .detail-title { font-size: 24px; font-weight: 800; color: #1a1a1a; margin: 0 0 10px 0; }
    .status-badge { font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 9999px; text-transform: capitalize; display: inline-flex; align-items: center; gap: 6px; border: none; letter-spacing: normal; }
    .status-active { background-color: #dcfce7; color: #166534; }
    .status-active::before { content: ""; width: 6px; height: 6px; border-radius: 50%; background-color: #166534; }
    .status-pending { background-color: #fef9c3; color: #854d0e; }
    .status-pending::before { content: ""; width: 6px; height: 6px; border-radius: 50%; background-color: #854d0e; }
    .status-cancelled { background-color: #fef2f2; color: #dc2626; border: 1px solid #fee2e2; }
    .status-paused { background-color: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
    .status-renewal-upcoming { background-color: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; }
    .status-payment-failed { background-color: #fef2f2; color: #dc2626; border: 1px solid #fee2e2; }
    .status-grace-period { background-color: #fff7ed; color: #ea580c; border: 1px solid #ffedd5; }
    .status-ending { background-color: #f3f4f6; color: #4b5563; border: 1px solid #e5e7eb; }
    .status-completed { background-color: #ecfdf5; color: #059669; border: 1px solid #d1fae5; }
    .status-suspended { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

    /* Dashboard Grid Layout */
    .dashboard-grid { display: grid; grid-template-columns: repeat(3, 1fr); background: #fff; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; }
    .dash-card { background: #fff; padding: 22px 20px; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; border-right: 1px solid #e2e8f0; }
    .dash-card:last-child { border-right: none; }
    .dash-card.progress-block { background: #fafbfc; }
    @media (max-width: 768px) {
        .dashboard-grid { grid-template-columns: 1fr; }
        .dash-card { border-right: none; border-bottom: 1px solid #e2e8f0; }
        .dash-card:last-child { border-bottom: none; }
    }
    
    /* Next Cleaning Block */
    .nc-label { font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
    .nc-date { font-size: 16px; font-weight: 800; color: #0040E6; margin-bottom: 6px; }
    .nc-details { font-size: 13px; color: #475569; font-weight: 600; margin-bottom: 12px; }
    
    /* Progress Block */
    .progress-dots { font-size: 20px; color: #0040E6; letter-spacing: 4px; margin: 8px 0; }
    .progress-dots span.empty { color: #cbd5e1; }
    .progress-text { font-size: 13px; font-weight: 600; color: #64748b; }
    
    /* Renewal Block */
    .renewal-label { font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
    .renewal-value { font-size: 16px; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
    .renewal-status { font-size: 12px; font-weight: 700; color: #059669; background: #ecfdf5; padding: 4px 10px; border-radius: 20px; display: inline-block; margin-top: 8px; }
    
    /* Quick Actions */
    .quick-actions { display: grid; grid-template-columns: repeat(2, 1fr); border-top: 1px solid #e2e8f0; background: #fff; }
    .qa-btn { background: #fff; padding: 16px; text-align: center; font-size: 13px; font-weight: 700; color: #0040E6; cursor: pointer; transition: background 0.2s; border-right: 1px solid #e2e8f0; }
    .qa-btn:last-child { border-right: none; }
    .qa-btn:hover { background: #f8fafc; }
    @media (max-width: 768px) { .quick-actions { grid-template-columns: repeat(2, 1fr); } }
    
    /* Tabs Styles */
    .visits-tabs { display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid #eaeaea; }
    .visit-tab { padding: 10px 20px; font-weight: 600; color: #64748b; cursor: pointer; border-bottom: 2px solid transparent; transition: all 0.3s; }
    .visit-tab.active { color: #0040E6; border-bottom-color: #0040E6; }
    .tab-content { display: none; }
    .tab-content.active { display: block; }
    
    .visit-list { display: flex; flex-direction: column; gap: 15px; }
    .visit-item { border: 1px solid #eaeaea; border-radius: 8px; padding: 20px; background: #fff; }
    .visit-item-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px dashed #eaeaea; }
    .visit-number { font-weight: 700; color: #0040E6; font-size: 15px; }
    .visit-status { font-size: 13px; font-weight: 600; color: #10b981; }
    .visit-details { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
    .v-detail-label { font-size: 13px; color: #64748b; margin-bottom: 4px; }
    .v-detail-value { font-weight: 600; color: #1e293b; font-size: 14px; }
    
    .visit-actions { margin-top: 15px; padding-top: 15px; border-top: 1px solid #f1f5f9; display: flex; gap: 15px; }
    .visit-btn { color: #0040E6; font-weight: 600; font-size: 14px; text-decoration: none; cursor: pointer; border: none; background: none; padding: 0; }
    .visit-btn:hover { text-decoration: underline; }

    /* Support Block */
    .support-block { background: #fff; border: 1px solid #eaeaea; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 40px; margin-top: 30px; }
    .support-title { font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 15px; }
    .support-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .support-btn { border: 1px solid #eaeaea; border-radius: 8px; padding: 12px; font-size: 13px; font-weight: 600; color: #475569; cursor: pointer; background: #fff; transition: all 0.2s; display: flex; align-items: center; justify-content: center; text-align: center; min-height: 48px; line-height: 1.3; }
    .support-btn:hover { border-color: #0040E6; color: #0040E6; }
    .support-btn.primary { background: #0040E6; color: #fff; border: none; padding: 14px 12px; font-size: 14px; margin-top: 10px; gap: 8px; }
    .support-btn.primary i { flex-shrink: 0; }
    @media (max-width: 480px) {
        .support-grid { grid-template-columns: 1fr; }
    }

    /* Switch */
    .switch { position: relative; display: inline-block; width: 50px; height: 24px; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px; }
    .slider:before { position: absolute; content: ""; height: 16px; width: 16px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; }
    input:checked + .slider { background-color: #059669; }
    input:checked + .slider:before { transform: translateX(26px); }

    .renewal-toggle-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 15px; border-top: 1px dashed #eaeaea; padding-top: 15px; }
    .renewal-toggle-row .switch { flex-shrink: 0; margin-top: 2px; }

    .rating-stars { color: #f59e0b; font-size: 18px; }

    /* Alert / Action Banners */
    .action-banner { border-radius: 8px; padding: 15px 20px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap; }
    .action-banner-amber { background-color: #fffbeb; border: 1px solid #fef3c7; }
    .action-banner-red { background-color: #fef2f2; border: 1px solid #fee2e2; }
    .action-banner-actions { display: flex; gap: 10px; flex-shrink: 0; }
    @media (max-width: 576px) {
        .action-banner { flex-direction: column; align-items: stretch; }
        .action-banner-actions { width: 100%; }
        .action-banner-actions .vc-btn-outline,
        .action-banner-actions .vc-btn-primary { flex: 1; width: auto; }
    }

    /* Manage Dropdown */
    .sub-detail-topbar { margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .sub-detail-topbar .back-link { color: #64748b; font-weight: 600; text-decoration: none; white-space: nowrap; }
    .sub-detail-topbar .vc-dropdown { flex-shrink: 0; }
    .manage-sub-btn { width: auto; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 0; white-space: nowrap; background-color: #ffffff !important; border: 1.5px solid #0040E6 !important; color: #0040E6 !important; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 64, 230, 0.1); transition: all 0.2s; }
    .manage-sub-btn:hover { background-color: #f8fafc !important; box-shadow: 0 4px 6px rgba(0, 64, 230, 0.15); transform: translateY(-1px); border-color: #0040E6 !important; color: #0040E6 !important;}
    @media (max-width: 480px) {
        .sub-detail-topbar { flex-direction: column; align-items: stretch; gap: 12px; }
        .sub-detail-topbar .vc-dropdown { width: 100%; }
        .manage-sub-btn { width: 100%; }
        .vc-dropdown-content { left: 0; right: 0; width: 100%; min-width: 0; }
    }
    .vc-dropdown { position: relative; display: inline-block; }
    .vc-dropdown-content { display: none; position: absolute; right: 0; background-color: #fff; min-width: 280px; box-shadow: 0 8px 16px rgba(0,0,0,0.1); border-radius: 8px; border: 1px solid #eaeaea; z-index: 1000; overflow:hidden; }
    .vc-dropdown-content a { color: #1e293b; padding: 12px 16px; text-decoration: none; display: block; font-size: 14px; font-weight: 500; border-bottom: 1px solid #f8fafc; cursor:pointer;}
    .vc-dropdown-content a:hover { background-color: #f8fafc; color: #0040E6; }
    .vc-dropdown-content a:last-child { border-bottom: none; color: #dc2626; }
    .vc-dropdown.active .vc-dropdown-content { display: block; }
    
    /* Modals */
    .vc-modal-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; }
    .vc-modal-overlay.active { display: flex; }
    .vc-modal { background: #fff; border-radius: 12px; width: 100%; max-width: 595px; padding: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); max-height: 90vh; overflow-y: auto; position: relative; scrollbar-width: none; -ms-overflow-style: none; }
    .vc-modal::-webkit-scrollbar { display: none; }
    .vc-modal h3 { margin-top: 0; margin-bottom: 15px; font-weight: 700; }
    .vc-modal-close { position: absolute; right: 20px; top: 20px; cursor: pointer; font-size: 20px; color: #64748b; background: #f1f5f9; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50%; }
    .vc-btn-primary { background: #0040E6; color: #fff; border: none; padding: 12px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; width: 100%; display:block; text-align:center; }
    .vc-btn-primary:hover { background: #0030b3; text-decoration: none; color: #fff;}
    .vc-btn-outline { background: transparent; color: #475569; border: 1px solid #cbd5e1; padding: 12px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; width: 100%; margin-top:10px; }

    .form-group { margin-bottom: 15px; text-align: left; }
    .form-group label { font-size:13px; font-weight:600; color:#1e293b; margin-bottom:5px; display:block; }
    .form-control { border:1px solid #cbd5e1; border-radius:6px; padding:10px 12px; width:100%; font-family: inherit;}

    .hide-scrollbar { scrollbar-width: none; -ms-overflow-style: none; }
    .hide-scrollbar::-webkit-scrollbar { display: none; }

    /* Mobile Bottom Sheet Modal */
    @media (max-width: 768px) {
        .vc-modal-overlay { align-items: flex-end; }
        .vc-modal {
            border-radius: 24px 24px 0 0;
            padding: 30px 20px env(safe-area-inset-bottom, 20px) 20px;
            animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            max-width: 100%;
        }
        .vc-modal::before {
            content: '';
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 4px;
            background: #e2e8f0;
            border-radius: 4px;
        }
    }
    @keyframes slideUp {
        from { transform: translateY(100%); }
        to { transform: translateY(0); }
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

    .currency_dhiram {
        display: inline-block;
        width: 18px;
        height: 14px;

        background-color: currentColor;

        -webkit-mask: url('{{ asset('public/site/icons/dirham.svg') }}') no-repeat center;
        mask: url('{{ asset('public/site/icons/dirham.svg') }}') no-repeat center;

        -webkit-mask-size: contain;
        mask-size: contain;
    }
</style>

<div class="body_content">
    <section class="our-login mt120" style="padding-top: 40px;">
        <div class="container mar-btn">
            <div class="row">
                <div class="col-lg-4 sidebar-left">
                    @include('front.account_sidebar')
                </div>

                <div class="col-lg-8">
                    
                    <!-- Header with Dropdown -->
                    <div class="sub-detail-topbar">
                        <a href="{{ route('front.subscriptions') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Subscriptions</a>
                        
                        <div class="vc-dropdown" id="manageDropdown">
                            <button class="vc-btn-outline manage-sub-btn" onclick="toggleDropdown()">
                                Manage Subscription <i class="fas fa-chevron-down" style="font-size:10px;"></i>
                            </button>
                            <div class="vc-dropdown-content">
                                <a onclick="openModal('planModal'); toggleDropdown();">Change Plan</a>
                                <a onclick="openModal('scheduleModal'); toggleDropdown();">Edit Regular Schedule</a>
                                <a onclick="openModal('cleanerModal'); toggleDropdown();">Cleaner Preference</a>
                                <a onclick="alert('Checking coverage for Address Change.'); toggleDropdown();">Service Address</a>
                                <a>Payment Method</a>
                                <a>Billing History</a>
                                <a>Cancellation & Rescheduling Policy</a>
                                <a onclick="openModal('cancelModal'); toggleDropdown();">Cancel Subscription</a>
                            </div>
                        </div>
                    </div>

                    @if($subscription->cleaner_unavailable && count($subscription->upcoming_visits) > 0)
                        <div class="action-banner action-banner-amber">
                            <div>
                                <strong style="color: #d97706; display:block; margin-bottom:4px;">Action Required</strong>
                                <span style="color: #b45309; font-size:14px;">{{ $subscription->preferred_cleaner }} isn't available for your cleaning on {{ $subscription->upcoming_visits[0]->date }}.</span>
                            </div>
                            <div class="action-banner-actions">
                                <button class="vc-btn-outline" style="background:#fff; border-color:#fcd34d; color:#b45309; padding:6px 12px; font-size:13px; width:auto; margin-top:0;" onclick="alert('Time kept. Another cleaner will be assigned.')">Keep my time</button>
                                <button class="vc-btn-primary" style="background:#d97706; padding:6px 12px; font-size:13px; width:auto;" onclick="alert('Proceed to choose another time slot for Sarah.')">Keep {{ $subscription->preferred_cleaner }}</button>
                            </div>
                        </div>
                    @endif

                    @if($subscription->payment_failed ?? true) <!-- Demo purpose: Set to true. In production, depends on backend flag -->
                        {{-- <div class="action-banner action-banner-red">
                            <div>
                                <strong style="color: #dc2626; display:block; margin-bottom:4px; font-size: 16px;"><i class="fas fa-exclamation-circle" style="margin-right:5px;"></i> We couldn’t renew your subscription</strong>
                                <span style="color: #991b1b; font-size:14px;">Update your payment method to keep your upcoming cleanings active.<br/> (Retry attempt 1 of 3)</span>
                            </div>
                            <div class="action-banner-actions">
                                <button class="vc-btn-primary" style="background:#dc2626; padding:6px 12px; font-size:12px; width:auto; border:none; white-space: nowrap;" onclick="openModal('paymentMethodModal')">Update Payment Method</button>
                            </div>
                        </div> --}}
                    @endif

                    <div class="detail-card">
                        <div class="detail-header">
                            <div class="detail-category">{{ $subscription->category }}</div>
                            <h2 class="detail-title">
                                {{ $subscription->plan_name }} 
                            </h2>

                            @php
                                $statusClass = 'status-' . strtolower(str_replace(' ', '-', $subscription->status ?? 'pending'));
                            @endphp
                            <span id="main-status-badge" class="status-badge {{ $statusClass }}">{{ $subscription->status ?? 'Pending' }}</span>
                            
                            <div id="main-status-subtitle" style="font-size:11px; color:#64748b; margin-top:4px; display:none;">Ends after current cycle</div>
                        </div>

                        <!-- Dashboard Grid -->
                        <div class="dashboard-grid">
                            <!-- Next Cleaning -->
                            <div class="dash-card next-cleaning-block">
                                <div class="nc-label">Next Cleaning</div>
                                <div class="nc-date" id="highlight-next-visit">{{ $subscription->next_visit_date }}<br>{{ $subscription->next_visit_time }}</div>
                                <div class="nc-details">{{ $subscription->preferred_cleaner }} • {{ count($subscription->upcoming_visits) > 0 ? $subscription->upcoming_visits[0]->duration : '3 Hours' }}</div>
                                {{-- <button class="vc-btn-outline" style="width: auto; padding: 6px 16px; font-size: 12px; margin-top: auto;" onclick="openRescheduleModal(null, '{{ $subscription->next_visit_date }}', '{{ $subscription->next_visit_time }}')">Manage Visit</button> --}}
                            </div>

                            <!-- Progress Bar -->
                            <div class="dash-card progress-block">
                                <div class="progress-text">{{ $subscription->visits_completed }} of {{ $subscription->visits_per_cycle }} visits completed</div>
                                <div class="progress-dots">
                                    @for($i = 0; $i < $subscription->visits_per_cycle; $i++)
                                        @if($i < $subscription->visits_completed)
                                            <span>●</span>
                                        @else
                                            <span class="empty">○</span>
                                        @endif
                                    @endfor
                                </div>
                                <div class="progress-text">{{ $subscription->visits_per_cycle - $subscription->visits_completed }} visits remaining</div>
                            </div>

                            <!-- Renewal Block -->
                            <div class="dash-card renewal-block">
                                <div class="renewal-label">Next Renewal</div>
                                <div class="renewal-value">{{ $subscription->next_renewal }}</div>
                                <div style="font-size: 14px; font-weight: 700; color: #475569; display: flex; align-items: center; justify-content: center; gap: 4px;"><span class="currency_dhiram"></span>{{ $subscription->renewal_amount }}</div>
                                <div class="renewal-status">
                                    Auto-renewal <span id="auto-renew-label">ON</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions Grid -->
                        <div class="quick-actions">
                            {{-- <div class="qa-btn" onclick="openRescheduleModal(null, '{{ $subscription->next_visit_date }}', '{{ $subscription->next_visit_time }}')"><i class="far fa-calendar-alt" style="margin-right:5px;"></i> Reschedule</div>
                            <div class="qa-btn" onclick="openSkipModal(null, '{{ $subscription->next_visit_date }}')"><i class="fas fa-forward" style="margin-right:5px;"></i> Skip Visit</div> --}}
                            <div class="qa-btn" onclick="openModal('pauseModal')"><i class="far fa-pause-circle" style="margin-right:5px;"></i> Pause Plan</div>
                            <div class="qa-btn" onclick="openModal('cleanerModal')"><i class="far fa-user" style="margin-right:5px;"></i> Change Cleaner</div>
                        </div>
                    </div>
                    
                    <!-- Tabs Section (Existing Style preserved) -->
                    <div class="visits-section" id="upcoming">
                        <div class="visits-tabs">
                            <div class="visit-tab active" onclick="switchTab('upcoming')">Upcoming Visits</div>
                            <div class="visit-tab" onclick="switchTab('history')">Past History</div>
                            <div class="visit-tab" onclick="switchTab('billing')">Billing & Renewal</div>
                        </div>
                        
                        <!-- Upcoming Visits Tab -->
                        <div id="tab-upcoming" class="tab-content active">
                            @if(count($subscription->upcoming_visits) > 0)
                                <div class="visit-list">
                                    @foreach($subscription->upcoming_visits as $visit)
                                        <div class="visit-item" id="visit-row-{{ $visit->visit_number }}">
                                            <div class="visit-item-header">
                                                <div class="visit-number">Visit {{ $visit->visit_number }} of {{ $visit->total_visits }}</div>
                                                <div class="visit-status" style="color: #0040E6; font-weight: 700; background: #eff6ff; padding: 4px 12px; border-radius: 20px; font-size: 12px;">{{ $visit->status ?? 'Scheduled' }}</div>
                                            </div>
                                            <div class="visit-details">
                                                <div>
                                                    <div class="v-detail-label">Date & Time</div>
                                                    <div class="v-detail-value visit-datetime">{{ $visit->date }}<br>{{ $visit->time }}</div>
                                                </div>
                                                <div>
                                                    <div class="v-detail-label">Service Details</div>
                                                    <div class="v-detail-value">Cleaner: {{ $visit->cleaner }}<br>Duration: {{ $visit->duration }}</div>
                                                </div>
                                            </div>
                                            <div class="visit-actions">
                                                <button class="visit-btn" onclick="openRescheduleModal({{ $visit->id }}, '{{ $visit->date }}', '{{ $visit->time }}')">Reschedule</button>
                                                <span style="color: #cbd5e1;">|</span>
                                                <button class="visit-btn" onclick="openSkipModal({{ $visit->id }}, '{{ $visit->date }}')">Skip</button>
                                                <span style="color: #cbd5e1;">|</span>
                                                <button class="visit-btn">View Details</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #475569;">
                                    No upcoming visits scheduled.
                                </div>
                            @endif
                        </div>
                        
                        <!-- Past Visits Tab -->
                        <div id="tab-history" class="tab-content">
                            @if(count($subscription->past_visits) > 0)
                                <div class="visit-list">
                                    @foreach($subscription->past_visits as $visit)
                                        <div class="visit-item">
                                            <div class="visit-item-header">
                                                <div class="visit-number">{{ $visit->date }}</div>
                                                <div class="visit-status" style="color: {{ $visit->status == 'Completed' ? '#10b981' : '#dc2626' }};">{{ $visit->status }}</div>
                                            </div>
                                            <div class="visit-details">
                                                <div>
                                                    <div class="v-detail-label">Time & Duration</div>
                                                    <div class="v-detail-value">{{ $visit->time }} ({{ $visit->duration }})</div>
                                                </div>
                                                <div>
                                                    <div class="v-detail-label">Cleaner</div>
                                                    <div class="v-detail-value">{{ $visit->cleaner }}</div>
                                                </div>
                                                <div>
                                                    <div class="v-detail-label">Booking ID</div>
                                                    <div class="v-detail-value">{{ $visit->booking_id }}</div>
                                                </div>
                                                <div>
                                                    <div class="v-detail-label">Rating</div>
                                                    <div class="v-detail-value">
                                                        @if(isset($visit->rating) && $visit->rating > 0)
                                                            <span class="rating-stars">
                                                                @for($i = 0; $i < $visit->rating; $i++)★@endfor
                                                            </span>
                                                        @else
                                                            <a href="#" style="color: #0040E6; text-decoration: underline;">Rate Your Cleaning</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="visit-actions">
                                                <a class="visit-btn">Invoice/Receipt</a>
                                                <span style="color: #cbd5e1;">|</span>
                                                <a class="visit-btn">Support/Report Issue</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #475569;">
                                    No past visits found.
                                </div>
                            @endif
                        </div>

                        <!-- Billing & Renewal Tab -->
                        <div id="tab-billing" class="tab-content">
                            
                            <!-- Payment Method Section -->
                            <div class="visit-item" style="margin-bottom: 15px;">
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                                    <h4 style="margin:0; font-weight:700; font-size:16px;">Payment Method</h4>
                                    <button class="vc-btn-outline" style="width:auto; padding:6px 12px; font-size:12px; margin-top:0;" onclick="openModal('paymentMethodModal')">Change Payment Method</button>
                                </div>
                                <div style="display:flex; align-items:center; gap:15px; border:1px solid #eaeaea; padding:15px; border-radius:8px; background:#f8fafc;">
                                    <div style="font-size:32px; color:#1a1f36;"><i class="fab fa-cc-visa"></i></div>
                                    <div>
                                        <div style="font-weight:700; color:#1e293b; font-size:14px;">Visa •••• 4242</div>
                                        <div style="font-size:13px; color:#64748b;">Expires 09/28</div>
                                    </div>
                                    <div style="margin-left:auto; background:#ecfdf5; color:#059669; font-size:11px; font-weight:700; padding:4px 8px; border-radius:4px; border:1px solid #d1fae5;">Default</div>
                                </div>
                            </div>

                            <!-- Next Payment & Auto-Renewal -->
                            <div class="visit-item" style="margin-bottom: 15px;">
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                                    <h4 style="margin:0; font-weight:700; font-size:16px;">Next Payment</h4>
                                    <div style="text-align:right;">
                                        <div style="font-weight:700; color:#1e293b; font-size:16px; display: flex; align-items: center; justify-content: flex-end; gap: 4px;"><span class="currency_dhiram"></span> {{ $subscription->renewal_amount ?? ' 350' }}</div>
                                        <div style="font-size:13px; color:#64748b;">{{ $subscription->next_renewal ?? '29 September 2026' }}</div>
                                    </div>
                                </div>
                                <div class="renewal-toggle-row">
                                    <div>
                                        <h4 style="margin:0 0 5px 0; font-weight:700; font-size:14px;">Auto-Renewal</h4>
                                        <p id="renewal-text" style="color:#64748b; margin:0; font-size:13px;">Your subscription will automatically renew on {{ $subscription->next_renewal ?? '29 September 2026' }}.</p>
                                    </div>
                                    <label class="switch">
                                      <input type="checkbox" id="autoRenewToggle" checked onchange="toggleAutoRenew(this)">
                                      <span class="slider"></span>
                                    </label>
                                </div>
                                <div id="renewal-warning" style="display:none; margin-top:15px; padding:15px; background:#fef2f2; border:1px solid #fee2e2; border-radius:8px; color:#dc2626; font-size:13px; font-weight:500;">
                                    Your remaining visits will not be affected. Your subscription will end after your current cycle and will not renew.
                                </div>
                            </div>

                            <!-- Billing History -->
                            <div class="visit-item">
                                <h4 style="margin:0 0 15px 0; font-weight:700; font-size:16px;">Billing History</h4>
                                <div style="display:flex; flex-direction:column; gap:10px;">
                                    <div style="display:flex; justify-content:space-between; align-items:center; padding:12px; border:1px solid #eaeaea; border-radius:8px;">
                                        <div>
                                            <div style="font-weight:600; color:#1e293b; font-size:14px;">29 Aug 2026</div>
                                            <div style="font-size:13px; color:#64748b;"><span class="currency_dhiram"></span>{{ $subscription->renewal_amount ?? ' 350' }} — <span style="color:#059669; font-weight:600;">Paid</span></div>
                                        </div>
                                        <a href="#" style="color:#0040E6; font-size:13px; font-weight:600; text-decoration:none;"><i class="fas fa-download" style="margin-right:4px;"></i> Invoice</a>
                                    </div>
                                    <div style="display:flex; justify-content:space-between; align-items:center; padding:12px; border:1px solid #eaeaea; border-radius:8px;">
                                        <div>
                                            <div style="font-weight:600; color:#1e293b; font-size:14px;">29 Jul 2026</div>
                                            <div style="font-size:13px; color:#64748b;"><span class="currency_dhiram"></span>{{ $subscription->renewal_amount ?? ' 350' }} — <span style="color:#059669; font-weight:600;">Paid</span></div>
                                        </div>
                                        <a href="#" style="color:#0040E6; font-size:13px; font-weight:600; text-decoration:none;"><i class="fas fa-download" style="margin-right:4px;"></i> Invoice</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Support Section -->
                    <div class="support-block">
                        <div class="support-title">Need Help With Your Subscription?</div>
                        <div class="support-grid">
                            <button class="support-btn" onclick="openSupportModal('Issue with a visit')">Issue with a visit</button>
                            <button class="support-btn" onclick="openSupportModal('Cleaner issue')">Cleaner issue</button>
                            <button class="support-btn" onclick="openSupportModal('Billing issue')">Billing issue</button>
                            <button class="support-btn" onclick="openSupportModal('Subscription question')">Subscription question</button>
                            <button class="support-btn primary" onclick="openSupportModal('Chat with support')" style="grid-column: span 1;"><i class="fas fa-comments"></i> Chat with support</button>
                            <button class="support-btn primary" onclick="window.location.href='tel:+971501234567'" style="grid-column: span 1; background: #059669;"><i class="fas fa-phone"></i>&nbsp;Call support</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modals -->

<!-- Support Modal -->
<div class="vc-modal-overlay" id="supportModal">
    <div class="vc-modal">
        <span class="vc-modal-close" onclick="closeModal('supportModal')">&times;</span>
        <h3>Contact Support</h3>
        <p style="font-size:14px; color:#64748b; margin-bottom:20px;">We're here to help. Your subscription context has been automatically attached for our agents.</p>
        
        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:15px; font-size:12px; color:#475569; margin-bottom:20px;">
            <strong>Context Attached:</strong><br>
            Topic: <span id="support-topic" style="font-weight:600; color:#1e293b;"></span><br>
            Subscription ID: <span style="font-weight:600; color:#1e293b;">#SUB-{{ $subscription->id }}</span><br>
            Customer ID: <span style="font-weight:600; color:#1e293b;">#CUST-{{ auth()->id() ?? '932' }}</span><br>
            Booking ID: <span style="font-weight:600; color:#1e293b;">#VC-84931</span>
        </div>
        
        <div class="form-group">
            <label>Message</label>
            <textarea class="form-control" rows="4" placeholder="How can we help you today?"></textarea>
        </div>
        
        <button class="vc-btn-primary" onclick="confirmModalAction('supportModal', 'Message Sent ✓')">Send Message</button>
        <div class="success-msg" style="display:none; color:#059669; font-weight:700; text-align:center; margin-top:15px;"></div>
    </div>
</div>

<!-- 1. Pause Modal -->
<div class="vc-modal-overlay" id="pauseModal">
    <div class="vc-modal">
        <span class="vc-modal-close" onclick="closeModal('pauseModal')">&times;</span>
        <h3>Pause Subscription</h3>
        <p style="font-size:14px; color:#64748b; margin-bottom:20px;">Temporarily suspend your visits without cancelling your subscription.</p>
        
        <div class="form-group">
            <label>Pause for:</label>
            <select class="form-control">
                <option>1 week</option>
                <option>2 weeks</option>
                <option>3 weeks</option>
                <option>Custom dates</option>
            </select>
        </div>
        
        <button class="vc-btn-primary" onclick="confirmModalAction('pauseModal', 'Subscription Paused ✓', () => { document.getElementById('main-status-badge').innerText = 'Paused'; document.getElementById('main-status-badge').className = 'status-badge status-pending'; document.getElementById('main-status-badge').style.background = ''; document.getElementById('main-status-badge').style.color = ''; })">Confirm Pause</button>
        <div class="success-msg" style="display:none; color:#059669; font-weight:700; text-align:center; margin-top:15px;"></div>
    </div>
</div>

<!-- Payment Method Modal -->
<div class="vc-modal-overlay" id="paymentMethodModal">
    <div class="vc-modal">
        <span class="vc-modal-close" onclick="closeModal('paymentMethodModal')">&times;</span>
        <h3>Payment Methods</h3>
        <p style="font-size:14px; color:#64748b; margin-bottom:20px;">Manage your saved payment methods for auto-renewal.</p>
        
        <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:20px;">
            <!-- Current Card -->
            <div style="border:1px solid #0040E6; background:#eff6ff; border-radius:8px; padding:15px; display:flex; justify-content:space-between; align-items:center;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="font-size:24px; color:#1a1f36;"><i class="fab fa-cc-visa"></i></div>
                    <div>
                        <div style="font-weight:700; color:#1e293b; font-size:14px;">Visa •••• 4242</div>
                        <div style="font-size:12px; color:#64748b;">Expires 09/28</div>
                    </div>
                </div>
                <div style="text-align:right;">
                    <span style="background:#0040E6; color:#fff; font-size:10px; font-weight:700; padding:3px 6px; border-radius:4px; text-transform:uppercase; margin-bottom:4px; display:inline-block;">Default</span><br>
                    <a href="#" style="color:#dc2626; font-size:11px; text-decoration:none; font-weight:600;" onclick="alert('Card removed')">Remove</a>
                </div>
            </div>

            <!-- Apple Pay -->
            <div style="border:1px solid #eaeaea; border-radius:8px; padding:15px; display:flex; justify-content:space-between; align-items:center; cursor:pointer;" onclick="confirmModalAction('paymentMethodModal', 'Default Payment Updated ✓')">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="font-size:24px; color:#000;"><i class="fab fa-apple"></i></div>
                    <div>
                        <div style="font-weight:700; color:#1e293b; font-size:14px;">Apple Pay</div>
                    </div>
                </div>
                <button class="vc-btn-outline" style="width:auto; padding:4px 10px; font-size:12px; margin-top:0;">Set Default</button>
            </div>
            
            <!-- Google Pay -->
            <div style="border:1px solid #eaeaea; border-radius:8px; padding:15px; display:flex; justify-content:space-between; align-items:center; cursor:pointer;" onclick="confirmModalAction('paymentMethodModal', 'Default Payment Updated ✓')">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="font-size:24px; color:#4285F4;"><i class="fab fa-google"></i></div>
                    <div>
                        <div style="font-weight:700; color:#1e293b; font-size:14px;">Google Pay</div>
                    </div>
                </div>
                <button class="vc-btn-outline" style="width:auto; padding:4px 10px; font-size:12px; margin-top:0;">Set Default</button>
            </div>
        </div>
        
        <button class="vc-btn-outline" style="width:100%; border:1px dashed #cbd5e1; background:#f8fafc; color:#0040E6; margin-bottom:15px;" onclick="alert('Redirect to Add Card gateway')"><i class="fas fa-plus"></i> Add New Card</button>
        
        <div class="success-msg" style="display:none; color:#059669; font-weight:700; text-align:center; margin-top:15px;"></div>
    </div>
</div>

<!-- 2. Cleaner Preferences Modal -->
<div class="vc-modal-overlay" id="cleanerModal">
    <div class="vc-modal">
        <span class="vc-modal-close" onclick="closeModal('cleanerModal')">&times;</span>
        <h3>Request Different Cleaner</h3>
        <div style="display:flex; justify-content:space-between; align-items:center; background:#f8fafc; padding:15px; border-radius:8px; margin-bottom:20px; border:1px solid #eaeaea;">
            <div>
                <div style="font-size:12px; color:#64748b; text-transform:uppercase; font-weight:600;">Your Preferred Cleaner</div>
                <div style="font-size:18px; font-weight:700; color:#1e293b;">{{ $subscription->preferred_cleaner }}</div>
            </div>
            @if($subscription->cleaner_rating)
            <div style="font-weight:600; color:#1e293b;"><span style="color:#f59e0b;">★</span> {{ $subscription->cleaner_rating }}</div>
            @endif
        </div>
        
        <div class="form-group">
            <label>Why would you like to change?</label>
            <select class="form-control" onchange="document.getElementById('otherReasonContainer').style.display = this.value === 'Other' ? 'block' : 'none'">
                <option value="Cleaner unavailable">Cleaner unavailable</option>
                <option value="Quality of service">Quality of service</option>
                <option value="Communication">Communication</option>
                <option value="Timing/reliability">Timing/reliability</option>
                <option value="Prefer another cleaner">Prefer another cleaner</option>
                <option value="Other">Other</option>
            </select>
            <div id="otherReasonContainer" style="display: none; margin-top: 10px;">
                <textarea class="form-control" rows="3" placeholder="Please specify your reason"></textarea>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:25px;">
            <label style="margin-bottom:10px;">Would you like the new cleaner for:</label>
            <label style="display:block; margin-bottom:8px; cursor:pointer;"><input type="radio" name="cleaner_scope" checked> Next visit only</label>
            <label style="display:block; cursor:pointer;"><input type="radio" name="cleaner_scope"> All future visits</label>
        </div>
        
        <button class="vc-btn-primary" onclick="confirmModalAction('cleanerModal', 'Cleaner Request Sent ✓')">Confirm Request</button>
        <div class="success-msg" style="display:none; color:#059669; font-weight:700; text-align:center; margin-top:15px;"></div>
    </div>
</div>

<!-- 3. Change Plan Modal -->
<div class="vc-modal-overlay" id="planModal">
    <div class="vc-modal">
        <span class="vc-modal-close" onclick="closeModal('planModal')">&times;</span>
        <h3>Change Plan</h3>
        <p style="font-size:14px; color:#64748b; margin-bottom:20px;">Upgrade or downgrade your cleaning frequency.</p>
        <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:20px;">
            <label style="border:1px solid #0040E6; background:#f8fafc; border-radius:8px; padding:15px; cursor:pointer; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="font-weight:700; color:#1e293b; font-size:16px;">1× Weekly <span style="font-size:12px; font-weight:normal; background:#0040E6; color:#fff; padding:2px 6px; border-radius:4px; margin-left:5px;">Current</span></div>
                    <div style="font-size:13px; color:#64748b;">4 visits/cycle</div>
                </div>
                <input type="radio" name="plan" checked>
            </label>
            <label style="border:1px solid #eaeaea; border-radius:8px; padding:15px; cursor:pointer; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="font-weight:700; color:#1e293b; font-size:16px;">2× Weekly</div>
                    <div style="font-size:13px; color:#64748b;">8 visits/cycle</div>
                </div>
                <input type="radio" name="plan">
            </label>
            <label style="border:1px solid #eaeaea; border-radius:8px; padding:15px; cursor:pointer; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="font-weight:700; color:#1e293b; font-size:16px;">3× Weekly</div>
                    <div style="font-size:13px; color:#64748b;">12 visits/cycle</div>
                </div>
                <input type="radio" name="plan">
            </label>
        </div>
        
        <div style="background:#fffbeb; border:1px solid #fef3c7; border-radius:8px; padding:15px; margin-bottom:20px;">
            <p style="margin:0; font-size:13px; color:#d97706; font-weight:600;"><i class="fas fa-info-circle" style="margin-right:5px;"></i> Your new plan will begin on your next renewal date.</p>
        </div>
        
        <button class="vc-btn-primary" onclick="confirmModalAction('planModal', 'Plan Change Scheduled ✓')">Confirm Change</button>
        <div class="success-msg" style="display:none; color:#059669; font-weight:700; text-align:center; margin-top:15px;"></div>
    </div>
</div>

<!-- 4. Edit Schedule Modal -->
<div class="vc-modal-overlay" id="scheduleModal">
    <div class="vc-modal">
        <span class="vc-modal-close" onclick="closeModal('scheduleModal')">&times;</span>
        <h3>Edit Regular Schedule</h3>
        <div style="font-size:14px; color:#475569; margin-bottom:20px;">Current Schedule: <strong>{{ $subscription->recurring_schedule }}</strong></div>
        <div class="form-group"><label>New Day of Week</label><select class="form-control"><option>Monday</option><option>Tuesday</option><option selected>Thursday</option></select></div>
        <div class="form-group"><label>New Time</label><select class="form-control"><option>08:00 AM</option><option selected>02:00 PM</option></select></div>
        
        <div class="form-group" style="margin-bottom:25px;">
            <label style="margin-bottom:10px;">Apply to:</label>
            <label style="display:block; margin-bottom:8px; cursor:pointer;"><input type="radio" name="schedule_scope" checked> Next visit only</label>
            <label style="display:block; cursor:pointer;"><input type="radio" name="schedule_scope"> All future visits</label>
        </div>

        <button class="vc-btn-primary" onclick="confirmModalAction('scheduleModal', 'Schedule Updated ✓')">Update Schedule</button>
        <div class="success-msg" style="display:none; color:#059669; font-weight:700; text-align:center; margin-top:15px;"></div>
    </div>
</div>

<!-- 5. Smart Cancellation Modal -->
<div class="vc-modal-overlay" id="cancelModal">
    <div class="vc-modal">
        <span class="vc-modal-close" onclick="closeModal('cancelModal')">&times;</span>
        
        <div id="cancel-step-1">
            <h3>Cancel Subscription</h3>
            <p style="font-size:14px; color:#64748b; margin-bottom:15px;">We're sorry to see you go. Why are you cancelling?</p>
            <div class="form-group hide-scrollbar" style="margin-bottom:25px; max-height:300px; overflow-y:auto; padding-right:5px;" onchange="document.getElementById('cancelOtherReasonContainer').style.display = (event.target.value === 'other') ? 'block' : 'none'">
                <label style="display:block; padding:10px; border:1px solid #eaeaea; border-radius:6px; margin-bottom:8px; cursor:pointer;"><input type="radio" name="cancel_reason" value="expensive" style="margin-right:8px;"> Too expensive</label>
                <label style="display:block; padding:10px; border:1px solid #eaeaea; border-radius:6px; margin-bottom:8px; cursor:pointer;"><input type="radio" name="cancel_reason" value="holiday" style="margin-right:8px;"> Going away</label>
                <label style="display:block; padding:10px; border:1px solid #eaeaea; border-radius:6px; margin-bottom:8px; cursor:pointer;"><input type="radio" name="cancel_reason" value="dont_need" style="margin-right:8px;"> Don’t need cleaning right now</label>
                <label style="display:block; padding:10px; border:1px solid #eaeaea; border-radius:6px; margin-bottom:8px; cursor:pointer;"><input type="radio" name="cancel_reason" value="quality" style="margin-right:8px;"> Service quality</label>
                <label style="display:block; padding:10px; border:1px solid #eaeaea; border-radius:6px; margin-bottom:8px; cursor:pointer;"><input type="radio" name="cancel_reason" value="cleaner" style="margin-right:8px;"> Cleaner issue</label>
                <label style="display:block; padding:10px; border:1px solid #eaeaea; border-radius:6px; margin-bottom:8px; cursor:pointer;"><input type="radio" name="cancel_reason" value="schedule" style="margin-right:8px;"> Schedule doesn’t work</label>
                <label style="display:block; padding:10px; border:1px solid #eaeaea; border-radius:6px; margin-bottom:8px; cursor:pointer;"><input type="radio" name="cancel_reason" value="other" style="margin-right:8px;"> Other</label>
            </div>
            <div id="cancelOtherReasonContainer" style="display: none; margin-bottom: 25px;">
                <textarea class="form-control" rows="3" placeholder="Please tell us more"></textarea>
            </div>
            <button class="vc-btn-primary" onclick="processCancellationStep2()">Continue</button>
        </div>
        
        <div id="cancel-step-2" style="display:none;">
            <h3>Wait! Before you cancel...</h3>
            <div id="retention-content" style="background:#f8fafc; padding:20px; border-radius:8px; margin-bottom:20px; text-align:center;"></div>
            <button class="vc-btn-primary" id="retention-btn" onclick="closeModal('cancelModal')" style="margin-bottom:10px;">Smart Action</button>
            <button class="vc-btn-outline" style="border:none; color:#94a3b8; margin-top:0;" onclick="showCancellationFinal()">No thanks, continue to cancel</button>
        </div>
        
        <div id="cancel-step-3" style="display:none;">
            <h3>Confirm Cancellation</h3>
            <div style="font-size:14px; color:#1e293b; background:#f8fafc; border:1px solid #eaeaea; padding:15px; border-radius:8px; margin-bottom:20px;">
                <ul style="margin:0; padding-left:20px; line-height:1.6; color:#475569;">
                    <li><strong>Last usable date:</strong> {{ $subscription->next_renewal ?? 'End of current cycle' }}</li>
                    <li><strong>Remaining visits:</strong> {{ $subscription->visits_per_cycle - $subscription->visits_completed }} visits</li>
                    <li><strong>Upcoming appointments:</strong> Will remain scheduled until your last usable date.</li>
                    <li><strong>Refund treatment:</strong> No prorated refunds for partially used cycles.</li>
                    <li><strong>Auto-renewal:</strong> Will be turned off immediately.</li>
                </ul>
            </div>
            <button class="vc-btn-primary" style="background:#dc2626;" onclick="confirmModalAction('cancelModal', 'Subscription Cancelled ✓', () => { document.getElementById('main-status-badge').innerText = 'Cancelled'; document.getElementById('main-status-badge').className = 'status-badge status-cancelled'; document.getElementById('main-status-badge').style.background = ''; document.getElementById('main-status-badge').style.color = ''; })">Confirm Cancellation</button>
            <div class="success-msg" style="display:none; color:#dc2626; font-weight:700; text-align:center; margin-top:15px;"></div>
        </div>
    </div>
</div>

<div class="vc-modal-overlay" id="rescheduleModal">
    <div class="vc-modal" id="reschedule-step-1">
        <span class="vc-modal-close" onclick="closeModal('rescheduleModal')">&times;</span>
        <h3 id="reschedule-modal-title">Reschedule Visit</h3>
        
        <div class="form-group">
            <label>New Date</label>
            <input type="date" class="form-control" id="reschedule-new-date" style="height: 42px; padding: 6px 12px;" min="{{ date('Y-m-d') }}">
        </div>
        
        <div class="form-group">
            <label>Available Time</label>
            @php
                use Carbon\Carbon;
                date_default_timezone_set('Asia/Dubai');
                $timeslot = DB::table('time_slots')->orderBy('set_order','asc')->get()->toArray();
            @endphp

            <select class="form-control" id="reschedule-new-time" name="reschedule_new_time" style="width: 100%;">
            @foreach ($timeslot as $timeslot_data)
                @php
                    $timeslot_service = DB::table('subservice_timeslot_price')
                        ->where('service_id', $subscription->service_id)
                        ->where('subservice_id', $subscription->subservice_id)
                        ->where('time_slot_id', $timeslot_data->id)
                        ->where('is_active', 1)
                        ->first();

                    $timeslot_service_price = $timeslot_service && $timeslot_service->price > 0 ? $timeslot_service->price : 0;
                @endphp

                @if ($timeslot_service && $timeslot_service->is_active == 1)
                    <option value="{{ $timeslot_data->name }}">
                        {{ $timeslot_data->name }} @if($timeslot_service_price > 0) (+ AED {{ $timeslot_service_price }}) @endif
                    </option>
                @endif
            @endforeach
            </select>
        </div>

        <div class="form-group" style="margin-bottom:20px;">
            <label>Cleaner Preference</label>
            <div style="display: flex; gap: 10px;">
                <label style="flex: 1; display:flex; flex-direction: column; align-items: flex-start; justify-content: center; cursor:pointer; font-size:13px; border:1px solid #eaeaea; padding:12px 10px; border-radius:6px; background:#fafafa;">
                    <div style="display:flex; align-items:center; margin-bottom: 4px;">
                        <input type="radio" name="reschedule_cleaner" value="keep" checked style="margin-right:6px;"> 
                        <span style="font-weight:600; color:#1e293b; line-height: 1.2;">Keep {{ $subscription->preferred_cleaner }}</span>
                    </div>
                    <span style="color:#64748b; font-size:11px; margin-left:18px; line-height: 1.2;">(May limit available slots)</span>
                </label>
                <label style="flex: 1; display:flex; flex-direction: column; align-items: flex-start; justify-content: center; cursor:pointer; font-size:13px; border:1px solid #eaeaea; padding:12px 10px; border-radius:6px; background:#fafafa;">
                    <div style="display:flex; align-items:center; margin-bottom: 4px;">
                        <input type="radio" name="reschedule_cleaner" value="any" style="margin-right:6px;"> 
                        <span style="font-weight:600; color:#1e293b; line-height: 1.2;">Any available</span>
                    </div>
                    <span style="color:#64748b; font-size:11px; margin-left:18px; line-height: 1.2;">(More time slots available)</span>
                </label>
            </div>
        </div>

        <div style="background:#fffbeb; border:1px solid #fef3c7; border-radius:8px; padding:15px; margin-bottom:20px;">
            <h4 style="margin:0 0 5px 0; font-size:13px; color:#d97706; font-weight:700;"><i class="fas fa-exclamation-circle"></i> Rescheduling Policy</h4>
            <p style="margin:0; font-size:12px; color:#b45309; line-height:1.4;">
                Free rescheduling is available until <strong>{{ $reschedule_policy_hours ?? 24 }} hours</strong> before your appointment. Late rescheduling may result in the visit being counted or a fee being charged.
            </p>
        </div>

        <button class="vc-btn-primary" onclick="confirmReschedule()">Confirm Reschedule</button>
    </div>

    <div class="vc-modal" id="reschedule-step-2" style="display:none; text-align:center; padding: 40px 20px;">
        <span class="vc-modal-close" onclick="closeModal('rescheduleModal')">&times;</span>
        <div style="font-size:48px; color:#059669; margin-bottom:15px;"><i class="fas fa-check-circle"></i></div>
        <h3 style="color:#059669; margin-bottom:20px;">Visit Rescheduled ✓</h3>
        
        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:20px; text-align:left; margin-bottom:20px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; padding-bottom:15px; border-bottom:1px dashed #cbd5e1;">
                <div style="width:45%;">
                    <div style="font-size:11px; text-transform:uppercase; color:#64748b; font-weight:700; margin-bottom:4px;">Previous</div>
                    <div style="font-size:14px; color:#94a3b8; text-decoration:line-through;" id="reschedule-old-datetime">Old Date<br>Old Time</div>
                </div>
                <div style="color:#cbd5e1;"><i class="fas fa-arrow-right"></i></div>
                <div style="width:45%; text-align:right;">
                    <div style="font-size:11px; text-transform:uppercase; color:#0040E6; font-weight:700; margin-bottom:4px;">New Appointment</div>
                    <div style="font-size:14px; font-weight:700; color:#1e293b;" id="reschedule-new-datetime">New Date<br>New Time</div>
                </div>
            </div>
            <div style="font-size:13px; color:#475569;">
                <strong>Cleaner:</strong> <span id="reschedule-cleaner-name">Name</span>
            </div>
        </div>

        <button class="vc-btn-outline" onclick="closeModal('rescheduleModal')">Done</button>
    </div>
</div>
<div class="vc-modal-overlay" id="skipModal">
    <div class="vc-modal">
        <span class="vc-modal-close" onclick="closeModal('skipModal')">&times;</span>
        <h3 id="skip-modal-title">Skip Visit?</h3>
        
        <div class="form-group" style="margin-bottom:25px;">
            <label style="margin-bottom:10px; display:block; font-weight:600; color:#1e293b;">Choose what happens to this visit:</label>
            <label style="border:1px solid #0040E6; background:#eff6ff; border-radius:8px; padding:15px; cursor:pointer; display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <div>
                    <div style="font-weight:700; color:#1e293b; font-size:15px; margin-bottom:4px;">Move this visit to the end of my subscription</div>
                    <div style="font-size:13px; color:#64748b;"><strong>Recommended:</strong> Preserves your visit. Renewal moves forward.</div>
                </div>
                <input type="radio" name="skip_action" value="move" checked>
            </label>
            <label style="border:1px solid #eaeaea; border-radius:8px; padding:15px; cursor:pointer; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="font-weight:700; color:#1e293b; font-size:15px; margin-bottom:4px;">Skip and forfeit this visit</div>
                    <div style="font-size:13px; color:#64748b;">You will lose this scheduled cleaning completely.</div>
                </div>
                <input type="radio" name="skip_action" value="forfeit">
            </label>
        </div>

        <button class="vc-btn-primary" onclick="confirmSkipAction()">Confirm Skip</button>
        <div class="success-msg" style="display:none; color:#059669; font-weight:700; text-align:center; margin-top:15px;"></div>
    </div>
</div>

<script>
    let activeVisitRow = null;

    function switchTab(tabId) {
        document.querySelectorAll('.visit-tab').forEach(tab => tab.classList.remove('active'));
        event.target.classList.add('active');
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        document.getElementById('tab-' + tabId).classList.add('active');
    }

    function toggleAutoRenew(el) {
        if(el.checked) {
            document.getElementById('renewal-warning').style.display = 'none';
            document.getElementById('renewal-text').innerHTML = 'Your subscription will automatically renew for {{ $subscription->renewal_amount }} on {{ $subscription->next_renewal }}.';
            document.getElementById('auto-renew-label').innerHTML = 'ON';
            document.getElementById('auto-renew-label').style.color = '#059669';
            document.getElementById('main-status-subtitle').style.display = 'none';
        } else {
            document.getElementById('renewal-warning').style.display = 'block';
            document.getElementById('renewal-text').innerHTML = 'Auto-renewal is currently disabled.';
            document.getElementById('auto-renew-label').innerHTML = 'OFF';
            document.getElementById('auto-renew-label').style.color = '#64748b';
            document.getElementById('main-status-subtitle').style.display = 'block';
        }
    }
    
    function toggleDropdown() {
        document.getElementById("manageDropdown").classList.toggle("active");
    }

    // Close dropdown if clicked outside
    window.onclick = function(event) {
        if (!event.target.matches('.vc-btn-outline') && !event.target.matches('.fa-chevron-down')) {
            var dropdowns = document.getElementsByClassName("vc-dropdown");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('active')) {
                    openDropdown.classList.remove('active');
                }
            }
        }
    }

    function openModal(id) {
        document.getElementById(id).classList.add('active');
        if(id === 'cancelModal') {
            document.getElementById('cancel-step-1').style.display = 'block';
            document.getElementById('cancel-step-2').style.display = 'none';
            document.getElementById('cancel-step-3').style.display = 'none';
        }
    }
    
    let currentRescheduleDate = '';
    let currentRescheduleTime = '';
    let currentVisitId = null;

    function openRescheduleModal(visitId, visitDate, visitTime) {
        currentVisitId = visitId;
        currentRescheduleDate = visitDate || '{{ $subscription->next_visit_date }}';
        currentRescheduleTime = visitTime || '{{ $subscription->next_visit_time }}';
        
        if (visitDate) {
            document.getElementById('reschedule-modal-title').innerText = 'Reschedule Visit (' + visitDate + ')';
        } else {
            document.getElementById('reschedule-modal-title').innerText = 'Reschedule Next Visit';
        }
        
        document.getElementById('reschedule-step-1').style.display = 'block';
        document.getElementById('reschedule-step-2').style.display = 'none';
        
        openModal('rescheduleModal');
        
        // Initialize Select2 for the time dropdown
        if (typeof jQuery !== 'undefined' && $.fn.select2) {
            $('#reschedule-new-time').select2({
                dropdownParent: $('#rescheduleModal'),
                width: '100%',
                placeholder: 'Search for a time...',
                allowClear: true
            });
        }
    }

    function confirmReschedule() {
        let newDateInput = document.getElementById('reschedule-new-date').value;
        let newTimeElement = document.getElementById('reschedule-new-time');
        if(!newTimeElement) { alert("Please select a time."); return; }
        let newTime = newTimeElement.value;
        let cleanerPref = document.querySelector('input[name="reschedule_cleaner"]:checked').value;
        
        if(!newDateInput) { alert("Please select a new date."); return; }
        if(!currentVisitId) { alert("Invalid visit."); return; }
        
        fetch('{{ route('subscription.visit.reschedule') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                visit_id: currentVisitId,
                new_date: newDateInput,
                new_time: newTime,
                cleaner_pref: cleanerPref
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.status == 1) {
                let newDate = new Date(newDateInput).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
                
                document.getElementById('reschedule-old-datetime').innerHTML = currentRescheduleDate + '<br>' + currentRescheduleTime;
                document.getElementById('reschedule-new-datetime').innerHTML = newDate + '<br>' + newTime;
                
                document.getElementById('reschedule-cleaner-name').innerText = (cleanerPref === 'keep') ? '{{ $subscription->preferred_cleaner }}' : 'Any available cleaner';

                document.getElementById('reschedule-step-1').style.display = 'none';
                document.getElementById('reschedule-step-2').style.display = 'block';
                setTimeout(() => window.location.reload(), 2000);
            } else {
                alert(data.message);
            }
        }).catch(err => alert("Something went wrong"));
    }

    function openSkipModal(visitId, visitDate) {
        currentVisitId = visitId;
        if(visitDate) {
            document.getElementById('skip-modal-title').innerText = 'Skip ' + visitDate + '?';
        } else {
            document.getElementById('skip-modal-title').innerText = 'Skip Next Visit?';
        }
        openModal('skipModal');
    }

    function confirmSkipAction() {
        let action = document.querySelector('input[name="skip_action"]:checked').value;
        if(!currentVisitId) { alert("Invalid visit."); return; }
        
        fetch('{{ route('subscription.visit.skip') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                visit_id: currentVisitId,
                action: action
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.status == 1) {
                confirmModalAction('skipModal', 'Visit Skipped ✓');
                setTimeout(() => window.location.reload(), 1200);
            } else {
                alert(data.message);
            }
        }).catch(err => alert("Something went wrong"));
    }
    
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
        let msg = document.getElementById(id).querySelector('.success-msg');
        if(msg) msg.style.display = 'none';
    }
    
    function confirmModalAction(id, msgText, callback) {
        let msg = document.getElementById(id).querySelector('.success-msg');
        if(msg) { msg.innerText = msgText; msg.style.display = 'block'; }
        if(callback) callback();
        setTimeout(() => closeModal(id), 1200);
    }

    function openSupportModal(topic) {
        document.getElementById('support-topic').innerText = topic;
        openModal('supportModal');
    }
    
    // Cancellation Flow
    function processCancellationStep2() {
        let reason = document.querySelector('input[name="cancel_reason"]:checked');
        if(!reason) { alert("Please select a reason."); return; }
        document.getElementById('cancel-step-1').style.display = 'none';
        
        let retention = document.getElementById('retention-content');
        let btn = document.getElementById('retention-btn');
        if(reason.value === 'holiday') {
            retention.innerHTML = "<h4>Going on holiday?</h4><p>You can pause your subscription instead and keep your remaining visits.</p>";
            btn.innerText = "Pause Instead";
            btn.onclick = () => { closeModal('cancelModal'); openModal('pauseModal'); };
            document.getElementById('cancel-step-2').style.display = 'block';
        } else if (reason.value === 'expensive') {
            retention.innerHTML = "<h4>Looking to save money?</h4><p>Switch to a lower-frequency plan instead of cancelling.</p>";
            btn.innerText = "Change Plan";
            btn.onclick = () => { closeModal('cancelModal'); openModal('planModal'); };
            document.getElementById('cancel-step-2').style.display = 'block';
        } else {
            // For other reasons, bypass smart retention to avoid dark patterns and proceed directly to step 3.
            showCancellationFinal();
        }
    }
    function showCancellationFinal() {
        document.getElementById('cancel-step-2').style.display = 'none';
        document.getElementById('cancel-step-3').style.display = 'block';
    }
</script>

@include('front.includes.footer')