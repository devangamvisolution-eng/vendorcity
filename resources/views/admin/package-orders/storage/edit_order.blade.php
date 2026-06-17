@extends('admin.includes.Template')
@section('content')
    @php
        $is_renewal = false; // Always false for edit page, though we keep the logic structure
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
                    <h3 class="page-title">Edit Package Order - Storage</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('storage_package_order') }}">Package Order -
                                Storage</a></li>
                        <li class="breadcrumb-item active">Edit Package Order</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('storage-package-order-update') }}" method="POST" id="form"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                            <input type="hidden" name="enquiry_id" value="{{ $enquiry_id }}">
                            <input type="hidden" name="customer_id" value="{{ $order->user_id }}">
                            <input type="hidden" name="service_charge" id="service_charge" value="0">
                            <input type="hidden" name="sub_total" id="sub_total" value="{{ $order->sub_total }}">
                            <input type="hidden" name="vat_charge" id="vat_charge" value="{{ $order->vatcharge }}">
                            <input type="hidden" name="include_vat" id="include_vat"
                                value="{{ $order->vatcharge > 0 ? 'yes' : 'no' }}">
                            <input type="hidden" name="order_total" id="order_total" value="{{ $order->order_total }}">
                            <input type="hidden" name="total_sum" id="total_sum" value="{{ $order->order_total }}">
                            <input type="hidden" name="grand_total" id="grand_total" value="{{ $order->order_total }}">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Customer Name*</label>
                                        <select id="customer_id" name="customer_id" class="form-control form-select">
                                            <option value="">Select Customer Name</option>
                                            @foreach ($customer_data as $item)
                                                <option value="{{ $item->id }}" data-email="{{ $item->email }}"
                                                    data-name="{{ $item->name }}" data-phone="{{ $item->mobile }}"
                                                    {{ $order->user_id == $item->id ? 'selected' : '' }}>
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
                                                    {{ ($storage_item->subservice_id ?? '') == $subservice->id ? 'selected' : '' }}>
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
                                            <option value="yes"
                                                {{ $order->send_notification == 'yes' ? 'selected' : '' }}>Yes</option>
                                            <option value="no"
                                                {{ $order->send_notification == 'no' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Payment Mode</label>
                                        <select name="payment_mode" id="payment_mode" class="form-control form-select">
                                            <option value="Cash" {{ $order->paymentmode == 'Cash' ? 'selected' : '' }}>
                                                Cash</option>
                                            <option value="Online"
                                                {{ $order->paymentmode == 'Online' ? 'selected' : '' }}>Online</option>
                                        </select>
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
                                            <option value="Personal"
                                                {{ ($storage_item->storage_type ?? '') == 'Personal' ? 'selected' : '' }}>
                                                Personal</option>
                                            <option value="Commercial"
                                                {{ ($storage_item->storage_type ?? '') == 'Commercial' ? 'selected' : '' }}>
                                                Commercial</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Where would you like to store?</label>
                                        <select id="storage_location" name="storage_location"
                                            class="form-control form-select">
                                            <option value="">Select Emirates</option>
                                            @foreach (['Abu Dhabi', 'Dubai', 'Sharjah', 'Ajman', 'Umm Al Quwain', 'Ras Al Khaimah', 'Fujairah'] as $emirate)
                                                <option value="{{ $emirate }}"
                                                    {{ ($storage_item->storage_location ?? '') == $emirate ? 'selected' : '' }}>
                                                    {{ $emirate }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>To Date*</label>
                                        <input type="date" id="storage_to_date" name="storage_to_date"
                                            class="form-control" value="{{ $storage_item->storage_to_date ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Move Date*</label>
                                        <input type="date" id="moving_date" name="moving_date" class="form-control"
                                            value="{{ $order->moving_date }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <div id="time_slot_change">
                                        <div class="form-group">
                                            <label>Time Slot*</label>
                                            <select id="time_slot" name="time_slot" class="form-control form-select">
                                                <option value="">Select Time Slot</option>
                                                @foreach ($time_slot as $ts)
                                                    <option value="{{ $ts->id }}"
                                                        {{ ($storage_item->time_slot ?? '') == $ts->id ? 'selected' : '' }}>
                                                        {{ $ts->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Warehouse Name</label>
                                        <input type="text" name="warehouse_name" id="warehouse_name"
                                            class="form-control" value="{{ $warehouse_name }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Unit No</label>
                                        <input type="text" name="unit_no" id="unit_no" class="form-control"
                                            value="{{ $unit_no }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Emirate ID</label>
                                        <input type="text" name="emirate_id" id="emirate_id" class="form-control"
                                            value="{{ $emirate_id }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Company Trade Licence</label>
                                        <input type="text" name="trade_license" id="trade_license"
                                            class="form-control" value="{{ $trade_license }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Space Required*</label>
                                        <input type="text" id="space_required" name="space_required"
                                            class="form-control" value="{{ $storage_item->space_required ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Space Price*</label>
                                        <input type="number" id="space_price" name="space_price" class="form-control"
                                            value="{{ $order->space_price ?? 0 }}" oninput="refreshCalculations()">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>What would you like to store?*</label><br>
                                        <div class="row">
                                            @php
                                                $possible_items = [
                                                    'Furniture',
                                                    'Personal Items',
                                                    'Company Goods / Inventory',
                                                    'Cars',
                                                    'Perishables',
                                                    'Event / Exhibition Items',
                                                    'Documents',
                                                    'Pianos',
                                                ];
                                                $stored_items = explode(', ', $storage_item->items_to_store ?? '');
                                            @endphp
                                            @foreach ($possible_items as $item)
                                                <div class="col-md-3">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="items_to_store[]" value="{{ $item }}"
                                                            id="item_{{ Str::slug($item) }}"
                                                            {{ in_array($item, $stored_items) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="item_{{ Str::slug($item) }}">{{ $item }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
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
                                        @foreach ($costing_attribute as $child)
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="updateid1xxx[]"
                                                        value="{{ $child->id }}">
                                                    <input type="text" name="descriptionu[]"
                                                        class="form-control description-input"
                                                        value="{{ $child->description }}" oninput="calculateRowValues()">
                                                </td>
                                                <td><input type="number" name="qtyu[]" class="form-control qty"
                                                        value="{{ $child->qty }}" oninput="calculateRowValues()"></td>
                                                <td><input type="number" step="0.01" name="provu[]"
                                                        class="form-control prov" value="{{ $child->prov }}"
                                                        oninput="calculateRowValues()"></td>
                                                <td><input type="text" name="totalu[]" class="form-control row-total"
                                                        value="{{ $child->total }}" readonly
                                                        style="background: #f8fafc;"></td>
                                                <td class="text-center">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger remove-existing-row"><i
                                                            class="fas fa-times"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <button type="button" class="btn-add-row" id="addRows">
                                <i class="fas fa-plus-circle me-1"></i> Add Another Line Item
                            </button>

                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <div class="section-title mt-0">
                                        <i class="fas fa-cog"></i> Visibility & Settings
                                    </div>
                                    <div class="form-check form-switch mb-4">
                                        <input class="form-check-input" type="checkbox" id="vat_toggle"
                                            {{ $order->vatcharge > 0 ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="vat_toggle"
                                            style="margin-left: 10px;">Apply 5% VAT Charge</label>
                                    </div>
                                </div>

                                <div class="col-md-5 offset-md-1">
                                    <div class="calculation-summary">
                                        <div class="summary-row d-none">
                                            <span class="summary-label text-muted">Items Base Total</span>
                                            <span class="summary-value" id="summary_base_total">0.00</span>
                                        </div>
                                        <div class="summary-row">
                                            <span class="summary-label">Margin (%)</span>
                                            <div style="width: 100px;">
                                                <input type="number" id="margin" name="margin"
                                                    class="form-control form-control-sm text-end fw-bold"
                                                    value="{{ $storage_item->subservice_booking_percentage ?? '0' }}"
                                                    oninput="calculateRowValues('margin')">
                                            </div>
                                        </div>
                                        <div class="summary-row">
                                            <span class="summary-label">Margin Amount</span>
                                            <div style="width: 120px;">
                                                <input type="number" id="margin_amount" name="margin_amount"
                                                    class="form-control form-control-sm text-end fw-bold text-success"
                                                    value="{{ $enquiry_data->margin_amount ?? '0' }}"
                                                    oninput="calculateRowValues('margin_amount')">
                                            </div>
                                        </div>
                                        <div class="summary-row" id="vat_summary_row"
                                            style="{{ $order->vatcharge > 0 ? '' : 'display: none;' }}">
                                            <span class="summary-label text-danger">VAT (5% on Subtotal)</span>
                                            <span class="summary-value text-danger" id="summary_vat">0.00</span>
                                        </div>
                                        <div class="summary-row mt-3 pt-3" style="border-top: 2px dashed #cbd5e1;">
                                            <span class="summary-label text-dark h5 mb-0">Grand Total</span>
                                            <span class="h3 mb-0 font-weight-bold text-primary"
                                                id="display_total_sum">0.00</span>
                                        </div>
                                        <div class="mt-2 text-end text-muted d-flex justify-content-between d-none"
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
                                            value="{{ $order->date_charge ?? 0 }}" oninput="refreshCalculations()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-4">
                                        <label>Timing Charge</label>
                                        <input type="number" id="timing_charge" name="timing_charge"
                                            class="form-control" value="{{ $order->timing_charge ?? 0 }}"
                                            oninput="refreshCalculations()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-4">
                                        <label>Service Fee</label>
                                        <input type="number" id="service_fee" name="service_fee" class="form-control"
                                            value="{{ $order->service_fee ?? 0 }}" oninput="refreshCalculations()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-4">
                                        <label>COD Charge</label>
                                        <input type="number" id="cod_charge" name="cod_charge" class="form-control"
                                            value="{{ $order->cod_charge ?? 0 }}" oninput="refreshCalculations()">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Additional information:</label>
                                    <textarea class="form-control" name="additional_message" id="additional_message" rows="4">{{ $storage_item->any_special_instruction ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="text-end border-top pt-4 mt-5">
                                <a href="{{ route('storage_package_order') }}" class="btn-cancel">Cancel</a>
                                <button type="button" class="btn-submit" id="submit_button" onclick="validate()">
                                    <i class="fas fa-save me-1"></i> Update Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function validate() {
            if (!$('#moving_date').val()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please select move date'
                });
                return false;
            }
            $('#submit_button').prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm me-1"></span> Processing...');
            $('#form').submit();
        }

        $('#subservice_id').on('change', function() {
            var subservice_id = $(this).val();
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
                    }
                });
            }
        });

        $(document).on('input change',
            '.qty, .prov, #margin, #margin_amount, #date_charge, #timing_charge, #service_fee, #cod_charge, #space_price',
            function() {
                let source = $(this).attr('id') === 'margin_amount' ? 'amount' : 'percent';
                refreshCalculations(source);
            });

        $('#vat_toggle').change(function() {
            $('#include_vat').val($(this).is(':checked') ? 'yes' : 'no');
            if ($(this).is(':checked')) $('#vat_summary_row').show();
            else $('#vat_summary_row').hide();
            refreshCalculations('percent');
        });

        $("#addRows").click(function() {
            var html = `<tr>
            <td><input type="text" name="description[]" class="form-control description-input" placeholder="Item description..." oninput="calculateRowValues()"></td>
            <td><input type="number" name="qty[]" class="form-control qty" placeholder="0" oninput="calculateRowValues()"></td>
            <td><input type="number" step="0.01" name="prov[]" class="form-control prov" placeholder="0.00" oninput="calculateRowValues()"></td>
            <td><input type="text" name="total[]" class="form-control row-total" readonly style="background: #f8fafc;"></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-row rounded-circle"><i class="fas fa-times"></i></button></td>
        </tr>`;
            $("#quote_table tbody").append(html);
        });

        $(document).on('click', '.remove-row, .remove-existing-row', function() {
            let row = $(this).closest('tr');
            Swal.fire({
                title: 'Remove Row?',
                text: "This item will be removed from the quote.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                confirmButtonText: 'Yes, remove it'
            }).then((result) => {
                if (result.isConfirmed) {
                    row.remove();
                    refreshCalculations('percent');
                }
            });
        });

        // function refreshCalculations(trigger = 'percent') {
        //     const parseAmount = (val) => parseFloat(val) || 0;
        //     let baseItemsTotal = 0;
        //     let securityDepositsTotal = 0;

        //     $("#quote_table tbody tr").each(function() {
        //         let row = $(this);
        //         let desc = row.find('.description-input').val() ? row.find('.description-input').val()
        //         .toLowerCase() : '';
        //         let qty = parseAmount(row.find('.qty').val());
        //         let prov = parseAmount(row.find('.prov').val());
        //         let total = qty * prov;
        //         row.find('.row-total').val(total.toFixed(2));

        //         if (desc.includes("security") || desc.includes("deposit") || desc.includes("refundable")) {
        //             securityDepositsTotal += total;
        //         } else {
        //             baseItemsTotal += total;
        //         }
        //     });

        //     if ($("#quote_table tbody tr").length === 0) {
        //         baseItemsTotal = parseAmount($('#space_price').val());
        //     }

        //     let marginPct = parseAmount($('#margin').val());
        //     let marginAmt = parseAmount($('#margin_amount').val());

        //     if (trigger === 'percent') {
        //         marginAmt = Math.round(baseItemsTotal * (marginPct / 100));
        //         $('#margin_amount').val(marginAmt);
        //     } else {
        //         marginPct = baseItemsTotal > 0 ? ((marginAmt / baseItemsTotal) * 100).toFixed(2) : 0;
        //         $('#margin').val(marginPct);
        //     }

        //     let taxableSubTotal = baseItemsTotal + marginAmt + parseAmount($('#date_charge').val()) + parseAmount($(
        //         '#timing_charge').val()) + parseAmount($('#service_fee').val()) + parseAmount($('#cod_charge').val());
        //     let vatVal = $('#vat_toggle').is(':checked') ? taxableSubTotal * 0.05 : 0;
        //     let grandTotal = taxableSubTotal + vatVal + securityDepositsTotal;

        //     $('#summary_base_total').text(baseItemsTotal.toFixed(2));
        //     $('#summary_vat').text(vatVal.toFixed(2));
        //     $('#summary_subtotal').text(taxableSubTotal.toFixed(2));
        //     $('#summary_security').text(securityDepositsTotal.toFixed(2));
        //     $('#display_total_sum').text(grandTotal.toFixed(2));

        //     $('#sub_total').val(taxableSubTotal.toFixed(2));
        //     $('#vat_charge').val(vatVal.toFixed(2));
        //     $('#order_total').val(grandTotal.toFixed(2));
        //     $('#total_sum').val(grandTotal.toFixed(2));
        // }
        function refreshCalculations(trigger = 'percent') {

            const parseAmount = (val) => parseFloat(val) || 0;

            let totalAll = 0;
            let depositTotal = 0;
            let nonDepositTotal = 0;

            $("#quote_table tbody tr").each(function() {
                let row = $(this);

                let desc = (row.find('.description-input').val() || '').toLowerCase();
                let qty = parseAmount(row.find('.qty').val());
                let prov = parseAmount(row.find('.prov').val());

                let total = qty * prov;
                row.find('.row-total').val(total.toFixed(2));

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

            // fallback
            if ($("#quote_table tbody tr").length === 0) {
                totalAll = parseAmount($('#space_price').val());
                nonDepositTotal = totalAll;
            }

            // ✅ MARGIN ON ALL ITEMS
            let marginPct = parseAmount($('#margin').val());
            let marginAmt = parseAmount($('#margin_amount').val());

            if (trigger === 'percent') {
                marginAmt = Math.round(totalAll * (marginPct / 100));
                $('#margin_amount').val(marginAmt);
            } else {
                marginPct = totalAll > 0 ? ((marginAmt / totalAll) * 100).toFixed(2) : 0;
                $('#margin').val(marginPct);
            }

            // ✅ SPLIT MARGIN
            let depositMargin = 0;
            let nonDepositMargin = 0;

            if (totalAll > 0) {
                depositMargin = (depositTotal / totalAll) * marginAmt;
                nonDepositMargin = (nonDepositTotal / totalAll) * marginAmt;
            }

            // ✅ TAXABLE subtotal (NO deposit)
            let taxableSubTotal =
                nonDepositTotal +
                nonDepositMargin +
                parseAmount($('#date_charge').val()) +
                parseAmount($('#timing_charge').val()) +
                parseAmount($('#service_fee').val()) +
                parseAmount($('#cod_charge').val());

            // ✅ VAT ONLY ON TAXABLE
            let applyVat = $('#vat_toggle').is(':checked');
            let vatVal = applyVat ? (taxableSubTotal * 0.05) : 0;

            if (applyVat) {
                $('#vat_summary_row').show();
            } else {
                $('#vat_summary_row').hide();
            }

            // ✅ DEPOSIT (NO VAT BUT WITH MARGIN)
            let totalRefundable = depositTotal + depositMargin;

            // ✅ FINAL TOTAL
            let grandTotal =
                taxableSubTotal +
                vatVal +
                totalRefundable;

            // UI
            $('#summary_base_total').text(nonDepositTotal.toFixed(2));
            $('#summary_vat').text(vatVal.toFixed(2));
            $('#summary_subtotal').text(taxableSubTotal.toFixed(2));
            $('#summary_security').text(totalRefundable.toFixed(2));
            $('#display_total_sum').text(grandTotal.toFixed(2));

            // hidden fields
            $('#sub_total').val(taxableSubTotal.toFixed(2));
            $('#vat_charge').val(vatVal.toFixed(2));
            $('#order_total').val(grandTotal.toFixed(2));
            $('#total_sum').val(grandTotal.toFixed(2));
        }

        function calculateRowValues(src = 'margin') {
            refreshCalculations(src === 'margin' ? 'percent' : 'amount');
        }

        $(document).ready(function() {
            refreshCalculations();
        });
    </script>
@stop
