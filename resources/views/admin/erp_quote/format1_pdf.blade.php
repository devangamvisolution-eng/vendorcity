<!doctype html>
<html>

<head>
    <title>Quotation | VendorsCity</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* PDF-Safe Typography (Standard Helvetica/Arial) */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1A202C;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        /* Items Table - Explicit borders for MPDF */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .items-table th {
            background-color: #F2F2F2;
            color: #4B5563;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #D1D5DB;
        }

        .items-table td {
            padding: 12px 10px;
            font-size: 14px;
            border-bottom: 1px solid #E5E7EB;
        }

        /* Accept Button (Web Only) */
        .btn-accept {
            display: inline-block;
            background-color: #F39739;
            color: #FFFFFF !important;
            padding: 12px 24px;
            font-weight: bold;
            font-size: 16px;
            text-decoration: none;
            border-radius: 30px;
        }

        /* Shipment Table */
        .shipment-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .shipment-table th {
            background-color: #F2F2F2;
            padding: 10px;
            border: 1px solid #E5E7EB;
            text-align: left;
            width: 30%;
        }

        .shipment-table td {
            padding: 10px;
            border: 1px solid #E5E7EB;
            width: 70%;
        }

        /* MPDF Page Break Helper */
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    @php
        $subtotal = 0;
        $total_all = 0;

        if (isset($costing_attribute)) {
            foreach ($costing_attribute as $attribute) {
                $isSecurityDeposit = stripos($attribute->description, 'security deposit') !== false;

                $price =
                    isset($followup_data->margin_percent) && $followup_data->margin_percent > 0
                        ? $attribute->prov + ($attribute->prov * $followup_data->margin_percent) / 100
                        : $attribute->prov;

                $total = $price * $attribute->qty;

                $total_all += $total;

                if (!$isSecurityDeposit) {
                    $subtotal += $total;
                }
            }
        }

        $vat = $followup_data->vat_charge == 1 ? 0.05 * $subtotal : 0;

        $calculated_grand_total = $total_all + $vat;
    @endphp
    <div style="padding: 20px;">
        <!-- Action Button (Web Only) -->
        @unless ($forPdf)
            <div style="text-align:center; margin-bottom: 30px;">
                @if ($followup_data->accepted_quotation == 0)
                    <a href="{{ route('request.accept', ['enquiry_id' => $followup_data->id, 'format_type' => 1]) }}"
                        class="btn-accept" style="{{ $acceptQuoteStyle }}">
                        Accept Quotation
                    </a>
                @else
                    <div class="btn-accept" style="background-color: #38A169;">
                        Quotation Accepted ✓
                    </div>
                @endif
            </div>
        @endunless

        @if ($forPdf)
            <htmlpagefooter name="firstpagefooter">
                <div style="background-color: #F2F2F2; padding: 15px; border-radius: 8px;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width: 50%; vertical-align: top;">
                                <h3 style="margin: 0 0 8px 0; font-size: 16px; font-weight: bold;">Contact Us</h3>
                                <div style="font-size: 11px; color: #4B5563; line-height: 1.5;">
                                    📞 +971 56 VENDORS (836 3677)<br>
                                    🌐 www.vendorscity.com<br>
                                    ✉️ accounts@vendorscity.com
                                </div>
                            </td>
                            <td style="width: 50%; vertical-align: top;">
                                <h3 style="margin: 0 0 8px 0; font-size: 16px; font-weight: bold;">Bank Details</h3>
                                <div style="font-size: 11px; color: #4B5563; line-height: 1.5;">
                                    <b>Account Name:</b> VendorsCity Portal LLC<br>
                                    <b>Account No:</b> 13450800920001<br>
                                    <b>Bank:</b> Abu Dhabi Commercial Bank
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div
                        style="text-align: center; font-size: 10px; color: #718096; margin-top: 10px; border-top: 1px solid #D1D5DB; padding-top: 5px;">
                        Validity: 30 Days | Prepared by: <span
                            style="color: #0040E6;">{{ $followup_data->prepared_by ?? 'Team VendorsCity' }}</span>
                    </div>
                </div>
            </htmlpagefooter>

            <htmlpagefooter name="secondpagefooter">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td
                            style="text-align:center; padding:10px; font-size:12px; font-family: Helvetica; color:#6c757d; line-height:1.5;">
                            Please confirm your acceptance of the above quote by either sending us an email or<br>
                            providing a scanned copy of the signed quote.
                        </td>
                    </tr>
                </table>
            </htmlpagefooter>
            <sethtmlpagefooter name="firstpagefooter" value="on" page="1" />
        @endif

        <!-- Header Table -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <img src="{{ asset('public/admin/assets/img/VC-FULL-BLACK.png') }}" alt="Logo" width="220"
                        style="margin-bottom: 8px;" />
                    <div style="font-size: 13px; font-weight:bold; color:#635B5B;">VendorsCity Portal LLC</div>
                    <div style="font-size: 13px; color:#635B5B;">Dubai, United Arab Emirates</div>
                    <div style="font-size: 13px;"><a href="http://www.vendorscity.com"
                            style="color: #635B5B; text-decoration: none;">www.vendorscity.com</a></div>
                </td>
                <td style="width: 40%; vertical-align: top;">
                    <table width="100%" cellpadding="10" cellspacing="0"
                        style="background-color: #f2f2f2; border-radius: 6px;">
                        <tr>
                            <td style="text-align: center;">
                                <div style="font-weight:bold; font-size:16px; color: #000;">Quotation <span
                                        style="color:#0056b3;">Number</span></div>
                                <div style="font-size:14px; margin-top: 4px;">{{ $followup_data->quote_id ?? 'N/A' }}
                                </div>
                                <div style="font-weight:bold; font-size:16px; color: #000; margin-top: 12px;">Quotation
                                    <span style="color:#0056b3;">Date</span>
                                </div>
                                <div style="font-size:14px; margin-top: 4px;">
                                    {{ $followup_data->quotation_date ? \Carbon\Carbon::parse($followup_data->quotation_date)->format('d/m/Y') : '-' }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Quoted To Section -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <div style="font-weight:bold; font-size:15px; color:#A0A0A0; margin-bottom: 8px;">Quoted To:</div>
                    <div style="font-weight:bold; color:#0056b3; font-size: 17px; margin-bottom: 4px;">
                        {{ $followup_data->client_name ?? '' }}</div>
                    <div style="font-size: 11px; color:#A0A0A0;">
                        <b>P:</b> {{ $followup_data->client_mobile ?? '-' }} &nbsp;&nbsp; <b>E:</b>
                        {{ $followup_data->client_email ?? '-' }}<br>
                        <b>A:</b> {{ $followup_data->address ?? '-' }}
                    </div>
                </td>
                <td style="width: 40%; text-align: center; vertical-align: middle;">
                    <div style="font-weight:bold; font-size: 24px; color: #000;">Quoted Amount</div>
                    <div style="font-size: 26px; font-weight:bold; color:#0040E6;">
                        <img src="{{ asset('public/site/images/automobile/DirhamBlue.png') }}"
                            style="width: 14px; vertical-align: middle;">
                        {{ number_format($calculated_grand_total, 2) }}
                    </div>
                </td>
            </tr>
        </table>

        <!-- Items Table -->
        @if (isset($costing_attribute) && count($costing_attribute) > 0)
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 45px; text-align: center;">SI No.</th>
                        <th>Job Description</th>
                        <th style="width: 55px; text-align: center;">QTY.</th>
                        <th style="width: 100px; text-align: center;">Price(AED)</th>
                        <th style="width: 100px; text-align: center;">Total(AED)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $subtotal = 0; // for VAT calculation (excluding security deposit)
                        $total_all = 0; // final total before VAT
                    @endphp

                    @foreach ($costing_attribute as $key => $attribute)
                        @php
                            $isSecurityDeposit = stripos($attribute->description, 'security deposit') !== false;

                            // ✅ Apply margin for ALL items
                            $price =
                                isset($followup_data->margin_percent) && $followup_data->margin_percent > 0
                                    ? $attribute->prov + ($attribute->prov * $followup_data->margin_percent) / 100
                                    : $attribute->prov;

                            $total = $price * $attribute->qty;

                            $total_all += $total; // all items total

                            // ✅ Only non-security goes to VAT subtotal
                            if (!$isSecurityDeposit) {
                                $subtotal += $total;
                            }
                        @endphp

                        <tr>
                            <td style="text-align: center;">{{ $key + 1 }}</td>
                            <td>{{ $attribute->description ?? 'N/A' }}</td>
                            <td style="text-align: center;">{{ $attribute->qty ?? 0 }}</td>
                            <td style="text-align: center;">{{ number_format($price, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Totals Table -->
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="width: 60%; vertical-align: top;">
                        <div style="font-weight:bold; font-size: 13px; color: #635B5B;">
                            Job ETA:
                            <span style="font-weight: normal;">
                                {{ $followup_data->est_time_to_complete ?? '-' }}
                            </span>
                        </div>
                    </td>

                    <td style="width: 40%;">
                        <table width="100%" cellpadding="5">

                            @php
                                // ✅ VAT only on non-security items
                                $vat = $followup_data->vat_charge == 1 ? 0.05 * $subtotal : 0;

                                // ✅ Final total = all items + VAT
                                $grand_total = $total_all + $vat;
                            @endphp

                            <!-- Subtotal (All Items including Security Deposit) -->
                            <tr>
                                <td style="text-align: right; color:#635B5B; font-size: 13px;">
                                    <b>Subtotal:</b>
                                </td>
                                <td style="text-align: center; color:#635B5B; width: 90px; font-size: 13px;">
                                    <b>{{ number_format($total_all, 2) }}</b>
                                </td>
                            </tr>

                            <!-- VAT -->
                            @if ($followup_data->vat_charge == 1)
                                <tr>
                                    <td style="text-align: right; color:#635B5B; font-size: 13px;">
                                        VAT (5%):
                                    </td>
                                    <td style="text-align: center; color:#635B5B; font-size: 13px;">
                                        <b>{{ number_format($vat, 2) }}</b>
                                    </td>
                                </tr>
                            @endif

                            <!-- Total -->
                            <tr>
                                <td style="text-align: right; color:#635B5B; font-size: 14px;">
                                    <b>Total:</b>
                                </td>
                                <td style="text-align: center; color:#635B5B; font-size: 14px;">
                                    <b>{{ number_format($grand_total, 2) }}</b>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        @endif

        @if ($followup_data->service == 30)
            <!-- Shipment Details -->
            <div style="font-size:18px; font-weight:bold; margin-top: 25px; margin-bottom:10px; color:#635B5B;">Shipment
                Details</div>
            <table class="shipment-table">
                @php
                    $shipmentDetails = [
                        'Description of Goods' => $followup_data->desc_of_goods,
                        'Service Required' => $followup_data->service_required,
                        'Mode of Transport' => $followup_data->mode_of_transport,
                        'Estimated Volume (CBM)' => $followup_data->estimated_volume,
                    ];
                @endphp
                @foreach ($shipmentDetails as $label => $value)
                    @if (!empty($value))
                        <tr>
                            <th>{{ $label }}</th>
                            <td style="text-align:center;">{{ $value }}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        @endif

        @if ($forPdf)
            <pagebreak />
            <sethtmlpagefooter name="secondpagefooter" value="on" page="2" />
        @endif

        <!-- Second Page / Terms & Services -->
        <div style="margin-top: 15px;">
            @php
                $ScopeOfJob = $followup_data->scope_of_job ?? ($servicedata->scope_of_job ?? '');
                $priceIncludes = $followup_data->price_includes ?? ($servicedata->price_includes ?? '');
                $priceExcludes = $followup_data->price_excludes ?? ($servicedata->price_excludes ?? '');
                $disclaimer = $followup_data->disclaimer ?? ($servicedata->disclaimer ?? '');
                $insurance = $followup_data->insurance ?? ($servicedata->insurance ?? '');
                $paymentTerms = $followup_data->payment_terms ?? ($servicedata->payment_terms ?? '');
            @endphp

            <!-- Terms Sections -->
            @foreach (['Scope Of Job' => $ScopeOfJob, 'Price Includes' => $priceIncludes, 'Price Excludes' => $priceExcludes, 'Disclaimer ' => $disclaimer, 'Insurance ' => $insurance, 'Payment Terms' => $paymentTerms] as $title => $content)
                @if (!empty($content))
                    <p style="color:#000; font-size:16px; font-family: Helvetica; margin: 15px 0 5px 0;">
                        <b>{{ explode(' ', $title)[0] }}</b> {{ substr($title, strpos($title, ' ') + 1) }}
                    </p>
                    <div style="font-family: Helvetica; font-size:10px; color:#777; margin-bottom: 15px;">
                        {!! strip_tags(html_entity_decode($content), '<p><br><b><strong><ul><li>') !!}
                    </div>
                @endif
            @endforeach

            <!-- Additional Services Grid -->
            <h2 style="color:#000; font-size:17px; font-family: Helvetica; margin: 25px 0 10px 0;"><b>Additional
                    Services</b></h2>
            <table width="100%" cellpadding="0" cellspacing="10">
                @php
                    $srvs = [
                        ['Cleaning', 'cleaning_icon.png', 'Deep cleaning, regular and specialized services.'],
                        ['Moving', 'moving_icon.png', 'Efficient moving and secure storage solutions.'],
                        ['Laundry', 'dry_cleaning.png', 'Professional washing and dry cleaning care.'],
                        ['AC Services', 'ac_cleaning.png', 'Installation, repair, and maintenance of systems.'],
                        ['Salon & Spa', 'spa_salon_icon.png', 'Relaxation and beauty treatments at home.'],
                        ['Automobile', 'car.png', 'Comprehensive car care and detailing solutions.'],
                        ['Handyman', 'handyman_icon.png', 'Reliable home repairs and maintenance support.'],
                        ['Pest Control', 'pest_control_icon.png', 'Effective pest management and gardening care.'],
                    ];
                    $rows = array_chunk($srvs, 4);
                @endphp
                @foreach ($rows as $row)
                    <tr>
                        @foreach ($row as $s)
                            <td
                                style="width: 25%; text-align: center; padding: 12px; border: 1px solid #E5E7EB; border-radius: 8px; vertical-align: top; background-color: #F8F9FA;">
                                <img src="{{ asset('public/site/images/Homepage/subservice_logo/' . $s[1]) }}"
                                    width="35" height="35" style="margin-bottom: 8px;" />
                                <div
                                    style="font-weight:bold; font-family: Helvetica; font-size:10px; color:#555; margin-bottom: 2px;">
                                    {{ $s[0] }}</div>
                                <div style="font-size: 8px; color:#777; font-family: Helvetica; line-height: 1.2;">
                                    {{ $s[2] }}</div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>

</html>
