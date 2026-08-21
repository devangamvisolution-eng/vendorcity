<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Your booking request has been received</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f5f7;
            margin: 0;
            padding: 40px 0;
            color: #333333;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-top: 4px solid #FFD413;
        }

        .header {
            text-align: center;
            padding: 30px 0;
            background-color: #f4f5f7;
        }

        .header img {
            max-width: 150px;
        }

        .content {
            padding: 40px;
        }

        h2 {
            font-size: 20px;
            color: #4a5568;
            margin-top: 0;
            margin-bottom: 20px;
        }

        p {
            font-size: 14px;
            line-height: 1.6;
            color: #4a5568;
            margin: 10px 0;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #4a5568;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 10px;
            margin-top: 40px;
            margin-bottom: 20px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .details-table td {
            padding: 12px 0;
            vertical-align: top;
            color: #4a5568;
        }

        .details-table .label {
            font-weight: bold;
            width: 35%;
        }

        .details-table .value {
            width: 65%;
        }

        .addon-item {
            display: block;
            color: #718096;
            margin-top: 4px;
        }

        .payment-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .payment-table td {
            padding: 12px 0;
            color: #4a5568;
        }

        .payment-table .label {
            font-weight: bold;
        }

        .payment-table .value {
            text-align: right;
        }

        .payment-table tr {
            border-bottom: 1px solid #edf2f7;
        }

        .payment-table tr:last-child {
            border-bottom: none;
        }

        .payment-table .total-row td {
            font-weight: bold;
            padding-top: 20px;
        }

        .footer {
            padding: 40px;
            text-align: center;
            background-color: #f4f5f7;
            font-size: 12px;
            color: #a0aec0;
        }

        .footer p {
            font-size: 12px;
            color: #a0aec0;
        }

        .support-text {
            text-align: center;
            margin-top: 40px;
            font-weight: bold;
            color: #4a5568;
        }
    </style>
</head>

<body>

    @php
        $firstItem = $order_item_data->first();
        $subserviceName = '';
        $address = '';
        $dateTime = '';

        if ($firstItem) {
            $subserviceName = DB::table('subservices')->where('id', $firstItem->subservice_id)->value('subservicename');

            $addressParts = array_filter([
                $firstItem->apartment_villa_no,
                $firstItem->building_street_no,
                $firstItem->area,
                $firstItem->city,
            ]);
            $address = implode(', ', $addressParts);

            $timeSlotName = DB::table('time_slots')->where('id', $firstItem->time_slot)->value('name');
            $dateTime =
                $firstItem->bookingdate .
                ' ' .
                $firstItem->month .
                ' ' .
                $firstItem->bookingyear .
                ' at ' .
                $timeSlotName;
        }

        $addons = DB::table('ci_order_item_addons')->where('order_id', $orderdata->order_id)->get();
        $packages = DB::table('ci_order_item_packages')->where('order_id', $orderdata->order_id)->get();
    @endphp

    <div class="header">
        <img src="{{ asset('public/site/images/VC-FULL-COLOR.png') }}" alt="VendorsCity">
    </div>

    <div class="email-container">
        <div class="content">
            <h2>Your booking request has been received</h2>

            <p>Hi {{ $user->name }},</p>

            <p>Thank you for making a {{ $subserviceName }} booking with VendorsCity! You will receive another email
                shortly confirming your booking.</p>

            <p>In the meantime, please go over your booking details and let us know if you would like to make any
                changes by replying to this email.</p>

            <!-- Booking details -->
            <div class="section-title">Booking details</div>

            <table class="details-table">
                <tr>
                    <td class="label">Service</td>
                    <td class="value">
                        {{ $subserviceName }}
                        @foreach ($packages as $package)
                            <span class="addon-item">{{ $package->package_item_name }} x
                                {{ $package->package_quantity }}</span>
                        @endforeach
                        @foreach ($addons as $addon)
                            <span class="addon-item">{{ $addon->package_item_name }} x
                                {{ $addon->package_quantity }}</span>
                        @endforeach


                    </td>
                </tr>
                @if (!empty($firstItem->how_many_cleaners_do_you_need))
                    <tr>
                        <td class="label">No. of Cleaners</td>
                        <td class="value">{{ $firstItem->how_many_cleaners_do_you_need }}</td>
                    </tr>
                @endif

                @if (!empty($firstItem->how_many_hours_should_they_stay))
                    <tr>
                        <td class="label">No. of Hours</td>
                        <td class="value">{{ $firstItem->how_many_hours_should_they_stay }}</td>
                    </tr>
                @endif

                @if (!empty($firstItem->how_often_do_you_need_cleaning))
                    <tr>
                        <td class="label">Frequency</td>
                        <td class="value">{{ $firstItem->how_often_do_you_need_cleaning }}</td>
                    </tr>
                @endif

                @if (!empty($firstItem->which_day_of_the_week_do_you_want_the_service))
                    <tr>
                        <td class="label">Days of the week</td>
                        <td class="value">{{ $firstItem->which_day_of_the_week_do_you_want_the_service }}</td>
                    </tr>
                @endif

                @if (!empty($firstItem->do_you_need_cleaning_material))
                    <tr>
                        <td class="label">Materials Provided</td>
                        <td class="value">{{ $firstItem->do_you_need_cleaning_material }}</td>
                    </tr>
                @endif

                <tr>
                    <td class="label">When</td>
                    <td class="value">{{ $dateTime }}</td>
                </tr>
                <tr>
                    <td class="label">Where</td>
                    <td class="value">{{ $address }}</td>
                </tr>
                <tr>
                    <td class="label">Reference ID</td>
                    <td class="value">{{ $orderdata->format_order_id }}</td>
                </tr>
            </table>

            <!-- Payment details -->
            <div class="section-title">Payment details</div>

            <table class="payment-table">
                <tr>
                    <td class="label">Service Charges</td>
                    <td class="value">AED
                        {{ number_format($orderdata->service_charge + $orderdata->timing_charge + $orderdata->service_fee + $orderdata->cod_charge, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="label">VAT</td>
                    <td class="value">AED {{ number_format($orderdata->vatcharge, 2) }}</td>
                </tr>
                @if ($orderdata->coupondiscount > 0)
                    <tr>
                        <td class="label">Discount</td>
                        <td class="value">- AED {{ number_format($orderdata->coupondiscount, 2) }}</td>
                    </tr>
                @endif
                @if ($orderdata->front_wallet_amount > 0)
                    <tr>
                        <td class="label">Wallet Used</td>
                        <td class="value">- AED {{ number_format($orderdata->front_wallet_amount, 2) }}</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td class="label">Total</td>
                    <td class="value">AED {{ number_format($orderdata->order_total, 2) }}</td>
                </tr>
            </table>

            <div class="support-text">
                <p>To make changes to your booking or get help from customer support, please contact us.</p>
            </div>

            <p>Have a lovely day!<br>
                The VendorsCity Team</p>
        </div>
    </div>

    <div class="footer">
        <p>You are receiving this email because you booked a service on VendorsCity. If you wish to stop receiving email
            updates about your booking, please reply to this email.</p>
        <p>&copy; {{ date('Y') }} VendorsCity. All rights reserved.</p>
    </div>

</body>

</html>
