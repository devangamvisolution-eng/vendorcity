@if (!request()->get('download'))
    @include('front.includes.header')
    <link rel="stylesheet" href="{{ asset('public/site/css/homedirham.css') }}">
@else
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>Receipt</title>
        <style>
            @font-face {
                font-family: 'aed';
                src: url('{{ asset('public/site/fonts/aed-s.p.0gs8mvhdnk64n.otf') }}') format('opentype');
            }

            @if (request()->get('download'))
                @page {
                    watermark-image: url('{{ public_path('site/images/VC-BLACK-SHORT.png') }}');
                    watermark-image-opacity: 0.025;
                    watermark-image-size: 300 300;
                    watermark-image-position: CC;
                }
            @endif

            body {
                margin: 0;
                padding: 0;
                background: #ffffff;
                font-family: 'Inter', 'Helvetica', 'Arial', sans-serif;
            }

            .currency_dhiramnew {
                font-family: 'aed', Arial, sans-serif;
            }
        </style>
    </head>

    <body style="margin: 0; padding: 0; background: #ffffff;">
@endif

<style>
    @font-face {
        font-family: 'aed';
        src: url('{{ asset('public/site/fonts/aed-s.p.0gs8mvhdnk64n.otf') }}') format('opentype');
    }

    .receipt-wrapper {
        background: #f4f6fc;
        min-height: 80vh;
        padding: 60px 0;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Inter', 'Outfit', sans-serif;
    }

    @if (request()->get('download'))
        .receipt-wrapper {
            background: #ffffff;
            padding: 0;
            min-height: auto;
            display: block;
        }
    @endif
    .receipt-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 15px 35px rgba(0, 64, 230, 0.05), 0 5px 15px rgba(0, 0, 0, 0.02);
        width: 100%;
        max-width: 680px;
        overflow: hidden;
        position: relative;
        border: 1px solid rgba(0, 64, 230, 0.08);

        @if (request()->get('download'))
            box-shadow: none;
            border: none;
            max-width: 100%;
        @endif
    }

    .currency_dhiramnew {
        font-family: 'aed', Arial, sans-serif;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        vertical-align: middle;
    }

    .price-wrapper {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        line-height: 1;
    }

    /* Action Buttons */
    .receipt-actions {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        margin-top: 40px;
    }

    .btn-receipt {
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none !important;
    }

    .btn-primary-receipt {
        background: #0040E6;
        color: #ffffff !important;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 64, 230, 0.2);
    }

    .btn-primary-receipt:hover {
        background: #002db3;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 64, 230, 0.3);
    }

    .btn-secondary-receipt {
        background: #ffffff;
        color: #475569 !important;
        border: 1px solid #e2e8f0;
    }

    .btn-secondary-receipt:hover {
        background: #f8fafc;
        color: #0f172a !important;
        border-color: #cbd5e1;
        transform: translateY(-2px);
    }
</style>

@php
    $orderId = $orders->order_id ?? 0;
    $packages = DB::table('ci_order_item_packages')->where('order_id', $orderId)->get();
    $addons = DB::table('ci_order_item_addons')->where('order_id', $orderId)->get();

    $subtotal = 0;
    if (isset($items[0]) && $items[0]->subservice_id == 28) {
        $price = $items[0]->product_discount_amount ?: $items[0]->package_item_price;
        $subtotal = $price * $items[0]->package_quantity;
    } else {
        foreach ($packages as $pkg) {
            $subtotal += ($pkg->package_item_price ?? 0) * ($pkg->package_quantity ?? 1);
        }
        foreach ($addons as $addon) {
            $subtotal += ($addon->package_item_price ?? 0) * ($addon->package_quantity ?? 1);
        }
        if ($packages->isEmpty() && $addons->isEmpty()) {
            foreach ($items as $item) {
                $price = $item->product_discount_amount ?: $item->package_item_price;
                $subtotal += $price * $item->package_quantity;
            }
        }
    }
    if ($subtotal == 0) {
        $subtotal = 51.43;
    }
    $vat = $orders->vatcharge ?? $subtotal * 0.05;
    $total = $orders->order_total ?? $subtotal + $vat;

    // Address Parsing
    $addrParts = [];
    if (
        isset($items[0]) &&
        (!empty($items[0]->city) ||
            !empty($items[0]->area) ||
            !empty($items[0]->building_street_no) ||
            !empty($items[0]->apartment_villa_no))
    ) {
        if (!empty($items[0]->apartment_villa_no)) {
            $addrParts[] = $items[0]->apartment_villa_no;
        }
        if (!empty($items[0]->building_street_no)) {
            $addrParts[] = $items[0]->building_street_no;
        }
        if (!empty($items[0]->area)) {
            $addrParts[] = $items[0]->area;
        }
        if (!empty($items[0]->city)) {
            $addrParts[] = $items[0]->city;
        }
    } elseif ($orders && (!empty($orders->address1) || !empty($orders->city))) {
        if (!empty($orders->address1)) {
            $addrParts[] = $orders->address1;
        }
        if (!empty($orders->address2)) {
            $addrParts[] = $orders->address2;
        }
        if (!empty($orders->city)) {
            $addrParts[] = $orders->city;
        }
    }
    $addrText = implode(', ', array_map('trim', array_filter($addrParts)));
    if (empty($addrText)) {
        $addrText = 'G02, BLDG 6 BLOCK A, Layan, Dubai';
    }
    $addrText = preg_replace('/,\s*,/', ',', $addrText);
    $addrText = trim($addrText, ', ');
@endphp

<div class="receipt-wrapper @if (!request()->get('download')) mt90 @endif">
    <div class="receipt-card" style="position: relative; overflow: hidden;">
        <!-- Watermark Background Logo -->
        @if (!request()->get('download'))
            <div class="watermark-bg"
                style="position: absolute;top: 70%;left: 50%;transform: translate(-50%, -50%);width: 116%;height: 100%;opacity: 0.025;z-index: 0;pointer-events: none;">
                <img src="{{ asset('public/site/images/VC-BLACK-SHORT.png') }}" style="width: 100%; height: auto;"
                    alt="Watermark Logo">
            </div>
        @endif

        <div style="position: relative; z-index: 1; width: 100%;">
            <!-- Top Blue Header Banner with Curved bottom and Monogram Logo -->
            <div style="background: #0040E6; padding: 25px 30px; color: #ffffff; border-radius: 12px 12px 0 0;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td>
                            <img src="{{ asset('public/site/images/VC_White.png') }}"
                                style="height: 44px; vertical-align: middle;" alt="VendorsCity Logo">
                        </td>

                    </tr>
                </table>
            </div>

            <!-- Receipt title and Customer Name -->
            <div style="padding: 30px 30px 20px 30px;">
                <div
                    style="font-size: 24px; font-weight: 600; color: #0f172a; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
                    Receipt</div>
                <div style="font-size: 15px; color: #64748b; font-family: 'Inter', sans-serif;">
                    {{ $orders->user_name ?? 'Customer' }}</div>
            </div>

            <!-- Total Paid Row (Pill shape table) -->
            <div style="padding: 0 30px; margin-bottom: 20px;">
                <table style="width: 100%;  padding: 15px 20px; border-collapse: collapse;">
                    <tr>
                        <td
                            style="font-size: 17px; color: #475569; font-weight: 600; font-family: 'Inter', sans-serif;">
                            Total Amount (including VAT)</td>
                        <td
                            style="text-align: right; font-size: 20px; font-weight: 600; color: #0040E6; font-family: 'Outfit', sans-serif;">
                            <span class="price-wrapper"><span class="currency_dhiramnew">AED</span>
                                <span>{{ number_format($total, 2) }}</span></span>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Main Information Grid (Table layout for 100% mPDF compatibility) -->
            <div style="padding: 0 30px;">
                <table
                    style="width: 100%; border-collapse: collapse; margin-bottom: 30px; font-family: 'Inter', sans-serif;">
                    <!-- Date & Time Row -->
                    <tr>
                        <td
                            style="padding: 15px 0; font-size: 13px; color: #8fa0ba; vertical-align: top; width: 30%; border-bottom: 1px solid #e2e8f0;">
                            Date & Time</td>
                        <td
                            style="padding: 15px 0; font-size: 14px; color: #1e293b; font-weight: 600; vertical-align: top; width: 70%; border-bottom: 1px solid #e2e8f0;">
                            {{ $visit_date ? date('d M Y', strtotime($visit_date)) : '16 Jun 2025' }},
                            {{ isset($items[0]->time_slot) ? \Helper::timeslotname(strval($items[0]->time_slot)) : '17:00-19:00' }}
                        </td>
                    </tr>
                    <!-- Service Type Row -->
                    <tr>
                        <td
                            style="padding: 15px 0; font-size: 13px; color: #8fa0ba; vertical-align: top; border-bottom: 1px solid #e2e8f0;">
                            Service Type</td>
                        <td
                            style="padding: 15px 0; font-size: 14px; color: #1e293b; font-weight: 600; vertical-align: top; border-bottom: 1px solid #e2e8f0;">
                            {{ isset($items[0]) ? \Helper::servicename($items[0]->service_id) : 'Cleaning' }}
                        </td>
                    </tr>
                    <!-- Service Details Row -->
                    <tr>
                        <td
                            style="padding: 15px 0; font-size: 13px; color: #8fa0ba; vertical-align: top; border-bottom: 1px solid #e2e8f0;">
                            Service Details</td>
                        <td
                            style="padding: 15px 0; font-size: 14px; color: #1e293b; vertical-align: top; border-bottom: 1px solid #e2e8f0;">
                            @if (!$packages->isEmpty() || !$addons->isEmpty())
                                @foreach ($packages as $pkg)
                                    <div style="font-weight: 600; color: #1e293b; margin-bottom: 4px;">
                                        {!! !empty($pkg->package_item_name) ? $pkg->package_item_name : \Helper::packages_enquiry($pkg->package_id) !!} * {{ $pkg->package_quantity ?? 1 }}
                                    </div>
                                @endforeach
                                @foreach ($addons as $addon)
                                    <div style="font-weight: 600; color: #1e293b; margin-bottom: 4px;">
                                        {!! !empty($addon->package_item_name)
                                            ? $addon->package_item_name
                                            : \Helper::addonspackages_enquiry($addon->package_id) !!} (Addon) * {{ $addon->package_quantity ?? 1 }}
                                    </div>
                                @endforeach
                            @else
                                @foreach ($items as $item)
                                    <div style="font-weight: 600; color: #1e293b; margin-bottom: 4px;">
                                        {{ \Helper::subservicename($item->subservice_id) }} *
                                        {{ $item->package_quantity }}
                                    </div>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                    <!-- Reference Code Row -->
                    <tr>
                        <td
                            style="padding: 15px 0; font-size: 13px; color: #8fa0ba; vertical-align: top; border-bottom: 1px solid #e2e8f0;">
                            Reference Code</td>
                        <td
                            style="padding: 15px 0; font-size: 14px; color: #1e293b; font-weight: 600; vertical-align: top; border-bottom: 1px solid #e2e8f0;">
                            {{ $orders->format_order_id ?? '549D35' }}
                        </td>
                    </tr>
                    <!-- Payment Method Row -->
                    <tr>
                        <td
                            style="padding: 15px 0; font-size: 13px; color: #8fa0ba; vertical-align: top; border-bottom: 1px solid #e2e8f0;">
                            Payment Method</td>
                        <td
                            style="padding: 15px 0; font-size: 14px; color: #1e293b; font-weight: 600; vertical-align: top; border-bottom: 1px solid #e2e8f0;">
                            {{ $orders->paymentmode == 1 ? 'Cash on Delivery' : 'Online Payment' }}
                        </td>
                    </tr>
                    <!-- Address Row -->
                    <tr>
                        <td style="padding: 15px 0; font-size: 13px; color: #8fa0ba; vertical-align: top;">Address</td>
                        <td
                            style="padding: 15px 0; font-size: 14px; color: #1e293b; font-weight: 600; vertical-align: top;">
                            {{ $addrText }}, United Arab Emirates
                        </td>
                    </tr>
                </table>

                <!-- Thank you note -->
                <div
                    style="text-align: center; margin-top: 35px; padding-top: 25px; border-top: 1px solid #f1f5f9; font-family: 'Inter', sans-serif;">
                    <h4 style="font-size: 16px; font-weight: bold; color: #1e293b; margin: 0 0 6px 0;">Thank you for
                        choosing VendorsCity!</h4>
                    <p style="font-size: 14px; color: #64748b; margin: 0;">We look forward to serving you again. Visit
                        us at <a href="https://www.vendorscity.com/" target="_blank"
                            style="color: #0040E6; text-decoration: none; font-weight: 600;">vendorscity.com</a></p>
                </div>

                <!-- Action buttons (Hidden in PDF) -->
                @if (!request()->get('download'))
                    <div class="receipt-actions" style="margin-bottom: 40px;">
                        <a href="{{ route('front.myorder') }}" class="btn-receipt btn-secondary-receipt">
                            <i class="fa fa-arrow-left"></i> Back to Orders
                        </a>
                        <a href="?download=pdf&visit_date={{ request()->get('visit_date') }}" id="downloadPdfBtn"
                            class="btn-receipt btn-primary-receipt">
                            <i class="fa fa-download"></i> Download PDF
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if (!request()->get('download'))
    @include('front.includes.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const downloadBtn = document.getElementById('downloadPdfBtn');
            if (downloadBtn) {
                downloadBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Show loader state
                    const originalContent = downloadBtn.innerHTML;
                    downloadBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Generating PDF...';
                    downloadBtn.style.pointerEvents = 'none';
                    downloadBtn.style.opacity = '0.7';

                    const url = downloadBtn.getAttribute('href');

                    fetch(url)
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.blob();
                        })
                        .then(blob => {
                            // Create local download link
                            const blobUrl = window.URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = blobUrl;

                            // Default filename
                            const filename =
                                '{{ $orders->format_order_id ?? ($orders->order_number ?? ($orders->order_id ?? 'Order')) }}.pdf';

                            a.download = filename;
                            document.body.appendChild(a);
                            a.click();
                            document.body.removeChild(a);
                            window.URL.revokeObjectURL(blobUrl);
                        })
                        .catch(error => {
                            console.error('PDF generation failed:', error);
                            alert('Failed to generate PDF. Please try again.');
                        })
                        .finally(() => {
                            // Restore button state
                            downloadBtn.innerHTML = originalContent;
                            downloadBtn.style.pointerEvents = 'auto';
                            downloadBtn.style.opacity = '1';
                        });
                });
            }
        });
    </script>
@else
    </body>

    </html>
@endif
