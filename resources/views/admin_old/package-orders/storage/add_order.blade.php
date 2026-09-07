@extends('admin.includes.Template')
@section('content')
    @php
        $is_renewal = request()->has('renew_id') || (isset($renew_id) && $renew_id);
        $renew_from_id = request()->get('renew_id') ?? ($renew_id ?? null);
    @endphp
    <style type="text/css">
        :root {
            --primary-blue: #3b82f6;
            --primary-hover: #2563eb;
            --accent-yellow: #facc15;
            --border-color: #e5e7eb;
            --text-main: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f9fafb;
        }

        .content-wrapper {
            padding: 2rem;
            background: var(--bg-light);
            min-height: 100vh;
            font-family: 'CircularStd', sans-serif;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-top: 10px;
            display: flex;
            align-items: center;
        }

        .breadcrumb-item {
            font-size: 13px;
            font-weight: 500;
            color: #94a3b8;
            display: flex;
            align-items: center;
        }

        .breadcrumb-item a {
            color: #64748b;
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: var(--primary-blue);
        }

        .breadcrumb-item.active {
            color: var(--primary-blue);
            font-weight: 700;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "/";
            color: #cbd5e1;
            padding: 0 10px;
        }

        .custom-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-header {
            background: var(--primary-blue) !important;
            color: #ffffff !important;
            padding: 18px 24px !important;
            border: none !important;
        }

        .card-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .card-body {
            padding: 30px !important;
        }

        .form-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-light);
            margin-bottom: 8px;
            display: block;
            letter-spacing: 0.025em;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 14px;
            transition: all 0.2s;
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eff6ff;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        /* Table Styling */
        .quote-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .quote-table thead th {
            background: #f8fafc;
            color: var(--text-light);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 12px 15px;
            border: none;
        }

        .quote-table tbody tr {
            background: #fff;
            transition: transform 0.2s;
        }

        .quote-table tbody td {
            padding: 10px;
            border-top: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
            background: #fff;
        }

        .quote-table tbody td:first-child {
            border-left: 1px solid #f1f5f9;
            border-radius: 8px 0 0 8px;
        }

        .quote-table tbody td:last-child {
            border-right: 1px solid #f1f5f9;
            border-radius: 0 8px 8px 0;
        }

        .btn-add-row {
            background: #eff6ff;
            color: var(--primary-blue);
            border: 1px dashed var(--primary-blue);
            padding: 10px;
            border-radius: 8px;
            width: 100%;
            font-weight: 600;
            transition: all 0.2s;
            margin-top: 10px;
        }

        .btn-add-row:hover {
            background: var(--primary-blue);
            color: #fff;
            border-style: solid;
        }

        .calculation-summary {
            background: #f8fafc;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #edf2f7;
        }

        .summary-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .summary-label {
            font-weight: 600;
            color: #647285;
            font-size: 13px;
        }

        .summary-value {
            font-weight: 700;
            color: var(--text-main);
            font-size: 15px;
        }

        .btn-submit {
            background: var(--primary-blue);
            color: #fff;
            border: none;
            padding: 14px 40px;
            border-radius: 8px;
            font-weight: 700;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-cancel {
            background: #f3f4f6;
            color: var(--text-main);
            padding: 14px 40px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            margin-right: 15px;
            display: inline-block;
        }

        .hidden {
            display: none;
        }

        .form-check-input:checked {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        ul li {
            list-style: inherit;
        }

        .form-check-inline {
            margin-right: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .form-check-input {
            margin-top: 0.3rem;
            cursor: pointer;
        }

        .form-check-label {
            cursor: pointer;
            font-weight: 400;
        }

        .price-input-wrapper .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .price-input-wrapper .form-control {
            border-left: none;
            padding-left: 5px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eff6ff;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .badge-vat {
            background: #fee2e2;
            color: #ef4444;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
            margin-left: 5px;
        }

        /* Switch Toggle Styling */
        .switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 22px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .4s;
            border-radius: 22px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: var(--primary-blue);
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }

        .readonly-box {
            background: #f8fafc !important;
            border-color: #e2e8f0 !important;
            color: var(--primary-blue) !important;
            font-weight: 700 !important;
        }

        .form-group label {
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            display: block;
        }
    </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Package Order - Storage</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('storage_package_order') }}">Package Order -
                                Storage</a>
                        </li>
                        <li class="breadcrumb-item active">Add Package Order - Storage</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div id="validator" class="alert alert-danger alert-dismissable" style="display:none;">
            <i class="fa fa-warning"></i>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
            <b>Error &nbsp;: </b><span id="error_msg1"></span>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Info</h4> -->

                        <form action="{{ route('storage-order-store') }}" method="POST" id="form"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="service_charge" id="service_charge" value="0">
                            <input type="hidden" name="sub_total" id="sub_total" value="0">
                            <input type="hidden" name="vat_charge" id="vat_charge" value="0">
                            <input type="hidden" name="enquiry_id" id="enquiry_id" value="{{ $enquiry_id }}">
                            <input type="hidden" name="renew_id" id="renew_id" value="{{ $renew_id }}">
                            <input type="hidden" name="include_vat" id="include_vat"
                                value="{{ ($enquiry_data->vat_charge ?? 0) == 1 ? 'yes' : 'no' }}">
                            <input type="hidden" name="order_total" id="order_total" value="0">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Customer Name*</label>
                                        <select id="customer_id" name="customer_id" class="form-control form-select">
                                            <option value="">Select Customer Name</option>
                                            @foreach ($customer_data as $item)
                                                <option value="{{ $item->id }}" data-email="{{ $item->email }}"
                                                    data-name="{{ $item->name }}" data-phone="{{ $item->mobile }}"
                                                    {{ ($enquiry_data->userid ?? ($old_order->user_id ?? '')) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->id }}-{{ $item->name }}-{{ $item->email }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="customer_id_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Select Subservice*</label>
                                        <select id="subservice_id" name="subservice_id" class="form-control form-select">
                                            <option value="">Select Subservice</option>
                                            @foreach ($subservice_data as $subservice)
                                                <option value="{{ $subservice->id }}"
                                                    {{ ($old_order_item->subservice_id ?? '') == $subservice->id ? 'selected' : '' }}>
                                                    {{ $subservice->subservicename }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="subservice_id_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Send Notification</label>
                                        <select id="send_notification" name="send_notification"
                                            class="form-control form-select">
                                            <option value="">Select</option>
                                            <option value="yes"
                                                {{ ($old_order->send_notification ?? '') == 'yes' ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="no"
                                                {{ ($old_order->send_notification ?? '') == 'yes' ? 'selected' : '' }}>No
                                            </option>
                                        </select>
                                        <p class="form-error-text" id="send_notification_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Payment Mode</label>
                                        <select name="payment_mode" id="payment_mode" class="form-control form-select">
                                            <option value="">Select Payment Mode</option>
                                            <option value="Cash"
                                                {{ ($old_order->paymentmode ?? '') == '1' ? 'selected' : '' }}>Cash
                                            </option>
                                            <option value="Online"
                                                {{ ($old_order->paymentmode ?? '') == '2' ? 'selected' : '' }}>Online
                                            </option>
                                        </select>
                                        <p class="form-error-text" id="payment_mode_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="section-title">
                                <i class="fas fa-info-circle"></i> Service Details
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Type of storage*</label>
                                        <select name="storage_type" id="storage_type" class="form-control form-select">
                                            <option value="">Select type</option>
                                            <option value="Personal"
                                                {{ ($old_order_item->storage_type ?? '') == 'Personal' ? 'selected' : '' }}>
                                                Personal</option>
                                            <option value="Commercial"
                                                {{ ($old_order_item->storage_type ?? '') == 'Commercial' ? 'selected' : '' }}>
                                                Commercial</option>
                                        </select>
                                        <p class="form-error-text" id="storage_type_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Where would you like to store?</label>
                                        <select id="storage_location" name="storage_location"
                                            class="form-control form-select">
                                            <option value="">Select Emirates</option>

                                            <option value="Abu Dhabi"
                                                {{ ($old_order_item->storage_location ?? '') == 'Abu Dhabi' ? 'selected' : '' }}>
                                                Abu Dhabi</option>
                                            <option value="Dubai"
                                                {{ ($old_order_item->storage_location ?? '') == 'Dubai' ? 'selected' : '' }}>
                                                Dubai
                                            </option>
                                            <option value="Sharjah"
                                                {{ ($old_order_item->storage_location ?? '') == 'Sharjah' ? 'selected' : '' }}>
                                                Sharjah</option>
                                            <option value="Ajman"
                                                {{ ($old_order_item->storage_location ?? '') == 'Ajman' ? 'selected' : '' }}>
                                                Ajman
                                            </option>
                                            <option value="Umm Al Quwain"
                                                {{ ($old_order_item->storage_location ?? '') == 'Umm Al Quwain' ? 'selected' : '' }}>
                                                Umm Al Quwain</option>
                                            <option value="Ras Al Khaimah"
                                                {{ ($old_order_item->storage_location ?? '') == 'Ras Al Khaimah' ? 'selected' : '' }}>
                                                Ras Al Khaimah</option>
                                            <option value="Fujairah"
                                                {{ ($old_order_item->storage_location ?? '') == 'Fujairah' ? 'selected' : '' }}>
                                                Fujairah</option>
                                        </select>
                                        <p class="form-error-text" id="storage_location_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>From Date*</label>
                                        <input type="date" id="from_date" name="from_date" class="form-control"
                                            value="{{ $warehouse_info['from_date'] ?? '' }}">
                                        <p class="form-error-text" id="from_date_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>To Date*</label>
                                        <input type="date" id="storage_to_date" name="storage_to_date"
                                            class="form-control" value="{{ $warehouse_info['to_date'] ?? '' }}">
                                        <p class="form-error-text" id="storage_to_date_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>When would you like to move?*</label>
                                        <input type="date" name="moving_date" id="moving_date" class="form-control"
                                            value="{{ $warehouse_info['from_date'] ?? '' }}">
                                        <p class="form-error-text" id="moving_date_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>What time would you like us to start?*</label>
                                        <div id="time_slot_change">
                                            <select id="time_slot" name="time_slot" class="form-control form-select">
                                                <option value="">Select Time Slot</option>
                                            </select>
                                        </div>
                                        <p class="form-error-text" id="time_slot_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Warehouse Name</label>
                                        <input type="text" name="warehouse_name" id="warehouse_name"
                                            class="form-control" value="{{ $warehouse_info['warehouse_name'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Unit No</label>
                                        <input type="text" name="unit_no" id="unit_no" class="form-control"
                                            value="{{ $warehouse_info['unit_no'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Emirate ID</label>
                                        <input type="text" name="emirate_id" id="emirate_id" class="form-control"
                                            value="{{ $warehouse_info['emirate_id'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Company Trade Licence</label>
                                        <input type="text" name="trade_license" id="trade_license"
                                            class="form-control" value="{{ $warehouse_info['trade_license'] ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Space Required*</label>
                                        <input type="text" id="space_required" name="space_required"
                                            class="form-control" placeholder="Enter space"
                                            value="{{ $old_order_item->space_required ?? '' }}">
                                        <p class="form-error-text" id="space_required_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Space Price*</label>
                                        <input type="number" id="space_price" name="space_price" class="form-control"
                                            placeholder="0"
                                            value="{{ $old_order->space_price ?? ($enquiry_data->grand_total ?? 0) }}"
                                            oninput="refreshCalculations()">
                                        <p class="form-error-text" id="space_price_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>What would you like to store?*</label><br>
                                        <div class="row">
                                            @php
                                                $items = [
                                                    'Furniture',
                                                    'Personal Items',
                                                    'Company Goods / Inventory',
                                                    'Cars',
                                                    'Perishables',
                                                    'Event / Exhibition Items',
                                                    'Documents',
                                                    'Pianos',
                                                ];
                                            @endphp
                                            @foreach ($items as $item)
                                                <div class="col-md-3">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input item-to-store" type="checkbox"
                                                            name="items_to_store[]" value="{{ $item }}"
                                                            id="item_{{ Str::slug($item) }}"
                                                            {{ in_array($item, $prefilled_items ?? []) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="item_{{ Str::slug($item) }}">{{ $item }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <p class="form-error-text" id="items_to_store_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>


                            </div>

                            <div class="section-title mt-4">
                                <i class="fas fa-list-ul"></i> Quotation Line Items
                            </div>

                            <div class="table-responsive">
                                <table class="quote-table" id="quote_table">
                                    <thead>
                                        <tr>
                                            <th style="width: 45%;">Description</th>
                                            <th style="width: 15%;">Qty</th>
                                            <th style="width: 15%;">Unit Price</th>
                                            <th style="width: 15%;">Total</th>
                                            <th style="width: 10%;" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($costing_attribute) && count($costing_attribute) > 0)
                                            @foreach ($costing_attribute as $child)
                                                @php
                                                    if (
                                                        $is_renewal &&
                                                        stripos($child->description, 'Storage') === false &&
                                                        stripos($child->description, 'Rent') === false
                                                    ) {
                                                        continue;
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="updateid1xxx[]"
                                                            value="{{ $child->id }}">
                                                        <input type="text" name="descriptionu[]"
                                                            class="form-control description-input"
                                                            value="{{ $child->description }}"
                                                            placeholder="Item description..." list="description_options"
                                                            oninput="calculateRowValues()">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="qtyu[]" class="form-control qty"
                                                            value="{{ $child->qty }}" placeholder="0"
                                                            oninput="calculateRowValues()">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" name="provu[]"
                                                            class="form-control prov" value="{{ $child->prov }}"
                                                            placeholder="0.00" oninput="calculateRowValues()">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="totalu[]"
                                                            class="form-control row-total" value="{{ $child->total }}"
                                                            readonly style="background: #f8fafc;">
                                                    </td>
                                                    <td class="text-center">

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>
                                                    <input type="text" name="description[]"
                                                        class="form-control description-input"
                                                        placeholder="Item description..." list="description_options"
                                                        oninput="calculateRowValues()">
                                                </td>
                                                <td>
                                                    <input type="number" name="qty[]" class="form-control qty"
                                                        placeholder="0" oninput="calculateRowValues()">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" name="prov[]"
                                                        class="form-control prov" placeholder="0.00"
                                                        oninput="calculateRowValues()">
                                                </td>
                                                <td>
                                                    <input type="text" name="total[]" class="form-control row-total"
                                                        readonly style="background: #f8fafc;">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger remove-row rounded-circle">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <datalist id="description_options">
                                @if (isset($descriptionofgoods))
                                    @foreach ($descriptionofgoods as $item)
                                        <option value="{{ $item->name }}">
                                    @endforeach
                                @endif
                            </datalist>

                            <button type="button" class="btn-add-row" id="addRows">
                                <i class="fas fa-plus-circle me-1"></i> Add Another Line Item
                            </button>

                            <div class="row mt-5">
                                <!-- Visibility & Settings (Left Side) -->
                                <div class="col-md-6">
                                    <div class="section-title mt-0">
                                        <i class="fas fa-cog"></i> Visibility & Settings
                                    </div>

                                    <div class="form-check form-switch mb-4">
                                        <input class="form-check-input" type="checkbox" name="vat_charge_toggle"
                                            id="vat_toggle" {{ ($enquiry_data->vat_charge ?? 0) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="vat_toggle"
                                            style="margin-left: 10px;">Apply 5% VAT Charge</label>
                                    </div>
                                </div>

                                <!-- Calculation Summary (Right Side) -->
                                <div class="col-md-5 offset-md-1">
                                    <div class="calculation-summary">
                                        <div class="summary-row d-none">
                                            <span class="summary-label text-muted">Items Base Total</span>
                                            <span class="summary-value" id="summary_base_total">0.00</span>
                                        </div>

                                        <div class="summary-row">
                                            <span class="summary-label">Margin (%)</span>
                                            <div style="width: 100px;">
                                                <input type="number" id="margin" name="margin_percentage"
                                                    class="form-control form-control-sm text-end fw-bold"
                                                    value="{{ $enquiry_data->margin_percent ?? '0' }}"
                                                    oninput="calculateRowValues('margin')">
                                            </div>
                                        </div>

                                        <div class="summary-row">
                                            <span class="summary-label">Margin Amount</span>
                                            <div style="width: 120px;">
                                                <input type="number" id="margin_amount"
                                                    class="form-control form-control-sm text-end fw-bold text-success"
                                                    value="{{ $enquiry_data->margin_amount ?? '0' }}"
                                                    oninput="calculateRowValues('margin_amount')">
                                            </div>
                                        </div>

                                        <div class="summary-row bg-white rounded p-2 my-2 border-light"
                                            style="display: none;" id="vat_summary_row">
                                            <span class="summary-label text-danger">VAT (5% on Subtotal)</span>
                                            <span class="summary-value text-danger" id="summary_vat">0.00</span>
                                        </div>

                                        <div class="summary-row mt-3 pt-3" style="border-top: 2px dashed #cbd5e1;">
                                            <span class="summary-label text-dark h5 mb-0">Grand Total</span>
                                            <div class="text-end">
                                                <span class="h3 mb-0 font-weight-bold text-primary"
                                                    id="display_total_sum">0.00</span>
                                                <input type="hidden" name="total_sum" id="total_sum" value="0.00">
                                                <input type="hidden" name="grand_total" id="grand_total"
                                                    value="0.00">
                                            </div>
                                        </div>

                                        <div class="mt-2 text-end text-muted font-italic d-flex justify-content-between d-none"
                                            style="font-size: 11px;">
                                            <span>Subtotal: <span id="summary_subtotal">0.00</span></span>
                                            <span>Refundable Deposit: <span id="summary_security">0.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section-title mt-5">
                                <i class="fas fa-truck-loading"></i>Additional fees
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-4">
                                        <label>Date Charge</label>
                                        <input type="number" id="date_charge" name="date_charge" class="form-control"
                                            placeholder="0" value="{{ $old_order->date_charge ?? 0 }}"
                                            oninput="refreshCalculations()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-4">
                                        <label>Timing Charge</label>
                                        <input type="number" id="timing_charge" name="timing_charge"
                                            class="form-control" placeholder="0"
                                            value="{{ $old_order->timing_charge ?? 0 }}" oninput="refreshCalculations()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-4">
                                        <label>Service Fee</label>
                                        <input type="number" id="service_fee" name="service_fee" class="form-control"
                                            placeholder="0" value="{{ $old_order->service_fee ?? 0 }}"
                                            oninput="refreshCalculations()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-4">
                                        <label>COD Charge</label>
                                        <input type="number" id="cod_charge" name="cod_charge" class="form-control"
                                            placeholder="0" value="{{ $old_order->cod_charge ?? 0 }}"
                                            oninput="refreshCalculations()">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Additional information:</label>
                                    <textarea class="form-control" name="additional_message" id="additional_message" rows="4" cols="50"
                                        style="display:none;"></textarea>
                                    <div id="additional_info_preview" class="p-3 bg-light border rounded"
                                        style="min-height: 50px; font-size: 14px; color: #666;">
                                        Line items from the table above will be automatically listed here.
                                    </div>
                                </div>
                            </div>

                            <div class="text-end border-top pt-4 mt-5">
                                <a href="{{ route('storage_package_order') }}" class="btn-cancel">Cancel</a>
                                <button type="button" class="btn-submit" id="submit_button" onclick="validate()">
                                    <i class="fas fa-check-circle me-1"></i> Submit Order
                                </button>
                            </div>
                            <div class="row mt-5" style="display:none;">
                                <!-- Removed duplicate hidden fields and redundant markup -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer_js')

    <script>
        let codCharge = window.Enums.vcCharges.COD.value;
        let vatPercent = window.Enums.vcCharges.VAT_PERCENT.value;
    </script>

    <script>
        function validate() {
            var customer_id = $('#customer_id').val();
            var subservice_id = $('#subservice_id').val();
            var storage_type = $('#storage_type').val();
            var storage_location = $('#storage_location').val();
            var from_date = $('#from_date').val();
            var storage_to_date = $('#storage_to_date').val();
            var moving_date = $('#moving_date').val();
            var time_slot = $('#time_slot').val();
            var space_required = $('#space_required').val();

            // Clear previous errors
            $('.form-error-text').html("");

            if (customer_id == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please Select Customer Name',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }

            if (subservice_id == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please Select Subservice',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }

            if (storage_type == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please Select Storage Type',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }

            if (from_date == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please Select From Date',
                    confirmButtonColor: '#3b82f6'
                });
                $('#from_date_error').html("Please Select From Date");
                $('#from_date').focus();
                return false;
            }

            if (storage_to_date == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please Select To Date',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }

            if (moving_date == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please Select Move Date',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }

            if (time_slot == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please Select Time Slot',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }

            if (space_required == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please Enter Space Required',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }

            $('#submit_button').attr('disabled', true).html(
                '<span class="spinner-border spinner-border-sm me-1"></span> Processing...');
            $('#form').submit();
        }

        /* $('#payment_method').on('change', function() {

            let payment_method = $(this).val();
            let charge_payment = 0;

            if (payment_method === 'COD') {
                charge_payment = codCharge;
            }

            $('#cod_charge').val(charge_payment);
        }); */

        $('#subservice_id').on('change', function() {
            var subservice_id = $(this).val();
            var moving_time = "{{ $old_order->moving_time ?? '' }}";
            if (subservice_id) {
                $.ajax({
                    url: '{{ url('get-time-slot') }}',
                    type: 'POST',
                    data: {
                        subservice_id: subservice_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#time_slot_change').html(data);
                        if (moving_time != "") {
                            $('#time_slot').val(moving_time);
                        }
                    }
                });
            }
        });

        $(document).ready(function() {
            if ($('#subservice_id').val() != "") {
                $('#subservice_id').trigger('change');
            }
        });
    </script>
    <script>
        //For 14 days avaialble for booking
        const today = new Date();
        const futureDate = new Date();

        // Set future date to 14 days from today
        futureDate.setDate(today.getDate() + 30);

        // Format dates to YYYY-MM-DD
        const todayStr = today.toISOString().split('T')[0];
        const futureDateStr = futureDate.toISOString().split('T')[0];

        // Set the min and max attributes
        const dateInput = document.getElementById('moving_date');
        const toDateInput = document.getElementById('storage_to_date');
        dateInput.min = todayStr;
        dateInput.max = futureDateStr;
        toDateInput.min = todayStr;
    </script>
    </script>
    <script>
        // Sync From Date to Moving Date for convenience
        $('#from_date').on('change', function() {
            if ($('#moving_date').val() == "") {
                $('#moving_date').val($(this).val());
            }
        });

        $(document).on('input change',
            '.qty, .prov, #margin, #margin_amount, .service-checkbox, .service-price-input, #padlock_charge, #security_deposit, #date_charge, #timing_charge, #service_fee, #include_vat, #cod_charge',
            function() {
                let source = $(this).attr('id') === 'margin_amount' ? 'amount' : 'percent';
                refreshCalculations(source);
            }
        );

        // VAT Toggle specifically
        $('#vat_toggle').change(function() {
            $('#include_vat').val($(this).is(':checked') ? 'yes' : 'no');
            refreshCalculations('percent');
        });

        // Add Row Logic
        $("#addRows").click(function() {
            var html = `
                    <tr>
                        <td>
                            <input type="text" name="description[]" class="form-control description-input" placeholder="Item description..." list="description_options">
                        </td>
                        <td>
                            <input type="number" name="qty[]" class="form-control qty" placeholder="0" oninput="calculateRowValues()">
                        </td>
                        <td>
                            <input type="number" step="0.01" name="prov[]" class="form-control prov" placeholder="0.00" oninput="calculateRowValues()">
                        </td>
                        <td>
                            <input type="text" name="total[]" class="form-control row-total" readonly style="background: #f8fafc;">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-row rounded-circle">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>`;
            $("#quote_table tbody").append(html);
        });

        // Remove Row Logic
        $(document).on('click', '.remove-row', function() {
            let row = $(this).closest('tr');
            Swal.fire({
                title: 'Remove Row?',
                text: "This item will be removed from the quote.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Yes, remove it'
            }).then((result) => {
                if (result.isConfirmed) {
                    row.remove();
                    refreshCalculations('percent');
                }
            });
        });

        // Initial Select2
        $('#customer_id').select2({
            placeholder: 'Select Customer Name',
            allowClear: true
        });

        // Triple-punch load trigger for total reliability
        refreshCalculations('percent');
        $(window).on('load', function() {
            refreshCalculations('percent');
        });
        setTimeout(function() {
            refreshCalculations('percent');
        }, 1000);

        /**
         * Unified Calculation Engine - Robust Version
         */
        // function refreshCalculations(trigger = 'percent') {
        //     // Helper to prevent NaN crashes
        //     const parseAmount = (val) => {
        //         let num = parseFloat(val);
        //         return isNaN(num) ? 0 : num;
        //     };

        //     let baseItemsTotal = 0;
        //     let securityDepositsTotal = 0;

        //     // 1. Sum Table Items
        //     $("#quote_table tbody tr").each(function() {
        //         let row = $(this);
        //         let desc = row.find('.description-input').val() ? row.find('.description-input').val()
        //             .toLowerCase() : '';
        //         let qty = parseAmount(row.find('.qty').val());
        //         let prov = parseAmount(row.find('.prov').val());
        //         let total = qty * prov;

        //         row.find('.row-total').val(total.toFixed(2));

        //         // USER RULE: Security Deposit (Refundable) is excluded from margin and VAT
        //         if (desc.includes("security") || desc.includes("deposit") || desc.includes("refundable")) {
        //             securityDepositsTotal += total;
        //         } else {
        //             baseItemsTotal += total;
        //         }
        //     });

        //     // Fallback for manual space price
        //     if ($("#quote_table tbody tr").length === 0) {
        //         baseItemsTotal = parseAmount($('#space_price').val());
        //     }

        //     // 2. Margin Logic
        //     let marginPct = parseAmount($('#margin').val());
        //     let marginAmt = parseAmount($('#margin_amount').val());

        //     if (trigger === 'percent') {
        //         marginAmt = Math.round(baseItemsTotal * (marginPct / 100));
        //         $('#margin_amount').val(marginAmt);
        //     } else if (trigger === 'amount') {
        //         if (baseItemsTotal > 0) {
        //             marginPct = ((marginAmt / baseItemsTotal) * 100).toFixed(2);
        //             $('#margin').val(marginPct);
        //         } else {
        //             marginPct = 0;
        //             $('#margin').val(0);
        //         }
        //     }

        //     // 3. Additional Fees
        //     let addServices = 0;
        //     $('.service-checkbox:checked').each(function() {
        //         let slug = $(this).attr('id').replace('service_', '');
        //         addServices += parseAmount($('#price_' + slug).val());
        //     });

        //     let padlock = parseAmount($('#padlock_charge').val());
        //     let directDeposit = parseAmount($('#security_deposit').val());
        //     let dCharge = parseAmount($('#date_charge').val());
        //     let tCharge = parseAmount($('#timing_charge').val());
        //     let sFee = parseAmount($('#service_fee').val());
        //     let codFee = parseAmount($('#cod_charge').val());

        //     // 4. Final Sub-calculation
        //     let taxableSubTotal = baseItemsTotal + marginAmt + addServices + padlock + dCharge + tCharge + sFee + codFee;

        //     let applyVat = $('#include_vat').val();
        //     let vatVal = (applyVat === 'yes') ? (taxableSubTotal * 0.05) : 0;

        //     if (applyVat === 'yes') $('#vat_summary_row').show();
        //     else $('#vat_summary_row').hide();

        //     let totalRefundable = directDeposit + securityDepositsTotal;
        //     let grandTotal = taxableSubTotal + vatVal + totalRefundable;

        //     // 5. Explicit UI Binding (Check for element existence to prevent failures)
        //     $('#summary_base_total').text(baseItemsTotal.toFixed(2));
        //     $('#summary_vat').text(vatVal.toFixed(2));
        //     $('#summary_subtotal').text(taxableSubTotal.toFixed(2));
        //     $('#summary_security').text(totalRefundable.toFixed(2));
        //     $('#display_total_sum').text(grandTotal.toFixed(2));

        //     // Hidden DB fields
        //     $('#sub_total').val(taxableSubTotal.toFixed(2));
        //     $('#vat_charge').val(vatVal.toFixed(2));
        //     $('#order_total').val(grandTotal.toFixed(2));
        //     $('#grand_total').val(grandTotal.toFixed(2));
        //     $('#total_sum').val(grandTotal.toFixed(2));
        // }
        // function refreshCalculations(trigger = 'percent') {

        //     // Helper to prevent NaN
        //     const parseAmount = (val) => {
        //         let num = parseFloat(val);
        //         return isNaN(num) ? 0 : num;
        //     };

        //     let items = [];

        //     // 1. Collect Table Data
        //     $("#quote_table tbody tr").each(function() {
        //         let row = $(this);

        //         items.push({
        //             desc: row.find('.description-input').val() || '',
        //             qty: parseAmount(row.find('.qty').val()),
        //             price: parseAmount(row.find('.prov').val()),
        //             row: row
        //         });
        //     });

        //     // 2. Fallback (Manual Space Price)
        //     if (items.length === 0) {
        //         items.push({
        //             desc: 'Storage Rent',
        //             qty: 1,
        //             price: parseAmount($('#space_price').val())
        //         });
        //     }

        //     let baseItemsTotal = 0;
        //     let securityDepositsTotal = 0;

        //     // 3. Calculate Totals
        //     items.forEach(item => {

        //         let total = item.qty * item.price;

        //         // Update row total UI
        //         if (item.row) {
        //             item.row.find('.row-total').val(total.toFixed(2));
        //         }

        //         let desc = item.desc.toLowerCase();

        //         let isDeposit =
        //             desc.includes("security") ||
        //             desc.includes("deposit") ||
        //             desc.includes("refundable");

        //         // 🚫 Deposit NOT taxable
        //         if (isDeposit) {
        //             securityDepositsTotal += total;
        //         } else {
        //             baseItemsTotal += total;
        //         }
        //     });

        //     // 4. Margin Calculation
        //     let marginPct = parseAmount($('#margin').val());
        //     let marginAmt = parseAmount($('#margin_amount').val());

        //     if (trigger === 'percent') {
        //         marginAmt = Math.round(baseItemsTotal * (marginPct / 100));
        //         $('#margin_amount').val(marginAmt);
        //     } else if (trigger === 'amount') {
        //         if (baseItemsTotal > 0) {
        //             marginPct = ((marginAmt / baseItemsTotal) * 100).toFixed(2);
        //             $('#margin').val(marginPct);
        //         } else {
        //             $('#margin').val(0);
        //         }
        //     }

        //     // 5. Additional Services
        //     let addServices = 0;
        //     $('.service-checkbox:checked').each(function() {
        //         let slug = $(this).attr('id').replace('service_', '');
        //         addServices += parseAmount($('#price_' + slug).val());
        //     });

        //     let padlock = parseAmount($('#padlock_charge').val());
        //     let directDeposit = parseAmount($('#security_deposit').val()); // manual deposit
        //     let dCharge = parseAmount($('#date_charge').val());
        //     let tCharge = parseAmount($('#timing_charge').val());
        //     let sFee = parseAmount($('#service_fee').val());
        //     let codFee = parseAmount($('#cod_charge').val());

        //     // 6. TAXABLE subtotal (NO deposit here 🚫)
        //     let taxableSubTotal =
        //         baseItemsTotal +
        //         marginAmt +
        //         addServices +
        //         padlock +
        //         dCharge +
        //         tCharge +
        //         sFee +
        //         codFee;

        //     // 7. VAT Calculation (ONLY on taxable)
        //     let applyVat = $('#include_vat').val(); // or use .is(':checked')
        //     let vatVal = (applyVat === 'yes') ? (taxableSubTotal * 0.05) : 0;

        //     if (applyVat === 'yes') {
        //         $('#vat_summary_row').show();
        //     } else {
        //         $('#vat_summary_row').hide();
        //     }

        //     // 8. Refundable (NO VAT)
        //     let totalRefundable = directDeposit + securityDepositsTotal;

        //     // 9. GRAND TOTAL
        //     let grandTotal = taxableSubTotal + vatVal + totalRefundable;

        //     // 10. UI Binding
        //     $('#summary_base_total').text(baseItemsTotal.toFixed(2));
        //     $('#summary_subtotal').text(taxableSubTotal.toFixed(2));
        //     $('#summary_vat').text(vatVal.toFixed(2));
        //     $('#summary_security').text(totalRefundable.toFixed(2));
        //     $('#display_total_sum').text(grandTotal.toFixed(2));

        //     // 11. Hidden Fields (DB)
        //     $('#sub_total').val(taxableSubTotal.toFixed(2));
        //     $('#vat_charge').val(vatVal.toFixed(2));
        //     $('#order_total').val(grandTotal.toFixed(2));
        //     $('#grand_total').val(grandTotal.toFixed(2));
        //     $('#total_sum').val(grandTotal.toFixed(2));

        //     // 🔍 DEBUG (remove in production)
        //     console.log({
        //         baseItemsTotal,
        //         securityDepositsTotal,
        //         taxableSubTotal,
        //         vatVal,
        //         totalRefundable,
        //         grandTotal
        //     });
        // }
        function refreshCalculations(trigger = 'percent') {

            const parseAmount = (val) => {
                let num = parseFloat(val);
                return isNaN(num) ? 0 : num;
            };

            let items = [];

            $("#quote_table tbody tr").each(function() {
                let row = $(this);

                items.push({
                    desc: row.find('.description-input').val() || '',
                    qty: parseAmount(row.find('.qty').val()),
                    price: parseAmount(row.find('.prov').val()),
                    row: row
                });
            });

            if (items.length === 0) {
                items.push({
                    desc: 'Storage Rent',
                    qty: 1,
                    price: parseAmount($('#space_price').val())
                });
            }

            let totalAll = 0; // ✅ ALL items
            let depositTotal = 0; // deposit
            let nonDepositTotal = 0; // taxable

            items.forEach(item => {

                let total = item.qty * item.price;

                if (item.row) {
                    item.row.find('.row-total').val(total.toFixed(2));
                }

                let desc = item.desc.toLowerCase();

                let isDeposit =
                    desc.includes("security") ||
                    desc.includes("deposit") ||
                    desc.includes("refundable");

                totalAll += total;

                if (isDeposit) {
                    depositTotal += total;
                } else {
                    nonDepositTotal += total;
                }
            });

            // ✅ Margin on ALL items (FIXED)
            let marginPct = parseAmount($('#margin').val());
            let marginAmt = parseAmount($('#margin_amount').val());

            if (trigger === 'percent') {
                marginAmt = Math.round(totalAll * (marginPct / 100));
                $('#margin_amount').val(marginAmt);
            } else {
                if (totalAll > 0) {
                    marginPct = ((marginAmt / totalAll) * 100).toFixed(2);
                    $('#margin').val(marginPct);
                } else {
                    $('#margin').val(0);
                }
            }

            // 👉 Split margin
            let depositMargin = 0;
            let nonDepositMargin = 0;

            if (totalAll > 0) {
                depositMargin = (depositTotal / totalAll) * marginAmt;
                nonDepositMargin = (nonDepositTotal / totalAll) * marginAmt;
            }

            // Additional charges
            let addServices = 0;
            $('.service-checkbox:checked').each(function() {
                let slug = $(this).attr('id').replace('service_', '');
                addServices += parseAmount($('#price_' + slug).val());
            });

            let padlock = parseAmount($('#padlock_charge').val());
            let directDeposit = parseAmount($('#security_deposit').val());
            let dCharge = parseAmount($('#date_charge').val());
            let tCharge = parseAmount($('#timing_charge').val());
            let sFee = parseAmount($('#service_fee').val());
            let codFee = parseAmount($('#cod_charge').val());

            // ✅ TAXABLE subtotal (ONLY non-deposit)
            let taxableSubTotal =
                nonDepositTotal +
                nonDepositMargin +
                addServices +
                padlock +
                dCharge +
                tCharge +
                sFee +
                codFee;

            // ✅ VAT (FIXED checkbox)
            // let applyVat = $('#vat_charge').is(':checked');

            // let vatVal = applyVat ? (taxableSubTotal * 0.05) : 0;

            // if (applyVat) {
            //     $('#vat_summary_row').show();
            // } else {
            //     $('#vat_summary_row').hide();
            // }

            let applyVat = $('#include_vat').val(); // or use .is(':checked')
            let vatVal = (applyVat === 'yes') ? (taxableSubTotal * 0.05) : 0;

            if (applyVat === 'yes') {
                $('#vat_summary_row').show();
            } else {
                $('#vat_summary_row').hide();
            }

            // ✅ Deposit (NO VAT but WITH margin)
            let totalRefundable = depositTotal + depositMargin + directDeposit;

            // ✅ FINAL TOTAL
            let grandTotal = taxableSubTotal + vatVal + totalRefundable;

            // UI
            $('#summary_base_total').text(nonDepositTotal.toFixed(2));
            $('#summary_subtotal').text(taxableSubTotal.toFixed(2));
            $('#summary_vat').text(vatVal.toFixed(2));
            $('#summary_security').text(totalRefundable.toFixed(2));
            $('#display_total_sum').text(grandTotal.toFixed(2));

            // Hidden fields
            $('#sub_total').val(taxableSubTotal.toFixed(2));
            $('#vat_charge').val(vatVal.toFixed(2)); // ✅ FIXED ID
            $('#order_total').val(grandTotal.toFixed(2));
            $('#grand_total').val(grandTotal.toFixed(2));
            $('#total_sum').val(grandTotal.toFixed(2));
        }

        function calculateRowValues(src = 'margin') {
            refreshCalculations(src === 'margin' ? 'percent' : 'amount');
        }

        function calculateTotal() {
            refreshCalculations('percent');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
@stop
