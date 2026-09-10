<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Service Booking Confirmation</title>
<style>
    .logo { border-bottom: 4px solid #FFD413; }
    .logo img{ width: 45%; }
    .wrapper { width: 100%; max-width:500px; margin:auto; font-size:14px; line-height:24px; font-family:Helvetica Neue, Helvetica, Arial, sans-serif; color:#555; padding:50px 0; }   
    .email_wrapper { width:100%; margin-top: 18px; font-size: 16px; }
    h2 { font-size: 26px; font-weight: bolder; margin: 0; }
</style>
</head>
<body>
<div class="wrapper">
    <div class="logo"><img src="{{ asset('public/site/images/VC-FULL-COLOR.png') }}"></div>
    <div class="email_wrapper"> 
        <p> Dear {{ $user->name }},</p>
        <p>Thank you for booking a service with VendorsCity! We are excited to assist you.</p>
        <p>Your booking details are as follows:</p>

        @foreach ($order_item_data as $item)
            @php
                $serviceName = DB::table('services')->where('id', $item->service_id)->value('servicename');
            @endphp
            <strong>Service: </strong> {{ $serviceName }}<br>
        @endforeach

        <strong>Date: </strong> {{ $orderdata->moving_date }}<br>
        <strong>Order No: </strong> {{ $orderdata->format_order_id }}
        
        @if ($payment_mode == 'COD')
            <p>Payment needs to be processed once our crew reaches the location. Accepted payment methods include cash, credit card, and debit card.</p>
        @else
            <p>Your payment has been successfully processed.</p>
        @endif
    </div>
</div>
</body>
</html>
