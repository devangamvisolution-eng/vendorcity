<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Your booking is cancelled</title>
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
        $date = '';
        $time = '';
        $city = 'dubai'; // default city

        if ($firstItem) {
            $subserviceName = DB::table('subservices')->where('id', $firstItem->subservice_id)->value('subservicename');
            $date = $firstItem->bookingdate . ' ' . $firstItem->month . ', ' . $firstItem->bookingyear;
            $timeSlotName = DB::table('time_slots')->where('id', $firstItem->time_slot)->value('name');
            $time = $timeSlotName;

            if (!empty($firstItem->city)) {
                $city = strtolower(str_replace(' ', '-', $firstItem->city));
            }
        }
    @endphp

    <div class="header">
        <img src="{{ asset('public/site/images/VC-FULL-COLOR.png') }}" alt="VendorsCity">
    </div>

    <div class="email-container">
        <div class="content">
            <h2>Your booking has been cancelled</h2>

            <p>Hi {{ $user->name }},</p>

            <p>Your booking <strong>{{ $orderdata->format_order_id }}</strong> has been cancelled successfully.</p>

            <!-- Booking details -->
            <div class="section-title">Booking Details</div>

            <table class="details-table">
                <tr>
                    <td class="label">Service</td>
                    <td class="value">{{ $subserviceName }}</td>
                </tr>
                <tr>
                    <td class="label">Date</td>
                    <td class="value">{{ $date }}</td>
                </tr>
                <tr>
                    <td class="label">Time</td>
                    <td class="value">{{ $time }}</td>
                </tr>
            </table>

            <p style="margin-top: 30px;">
                If a cancellation fee applies, it will be deducted from your refund. Any remaining eligible amount will
                be refunded to your original payment method in accordance with our <a
                    href="{{ route('cancellations_policy', ['city' => $city]) }}">cancellation policy</a>.
            </p>

            <p>
                Need the service again? You can make a new booking anytime on <a href="{{ url('/') }}">VendorsCity</a>.
            </p>

            <p style="margin-top: 30px;">
                Thank you,<br>
                Team VendorsCity
            </p>
        </div>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} VendorsCity. All rights reserved.</p>
    </div>

</body>

</html>