<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your plan renews soon</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        h2 {
            color: #1a1a1a;
            margin-top: 0;
        }
        .content {
            font-size: 16px;
            line-height: 1.6;
            color: #475569;
        }
        .cta-button {
            display: inline-block;
            background-color: #0040E6;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your plan renews soon</h2>
        <div class="content">
            <p>Hi {{ $data['name'] ?? 'Customer' }},</p>
            <p>Your <strong>{{ $data['plan_name'] }}</strong> will renew for <strong>{{ $data['currency'] }} {{ $data['amount'] }}</strong> on <strong>{{ $data['renewal_date'] }}</strong>.</p>
            <p>To view your upcoming schedule, update your payment method, or pause your visits, click the button below to manage your subscription.</p>
        </div>
        <div class="footer">
            <div class="heading" style="font-weight: bold;font-size: 20px;
                    <div class="
                email_footer" style="width:100%;margin-top: 20px;">
                <h3
                    style=" font-size: 20px;font-weight: bolder;margin: 0;
                    border-bottom: 3px solid #6B7177;padding-bottom: 20px;
                    margin-bottom: 15px;">
                    The VendorsCity Team</h3>
                <div class="email_footer_div" style=" width:100%;
                    display: flex; ">
                    <div class="footer_left" style="width: 100px;
                    float: left;">
                        <img style="width:70%;" src="{{ asset('public/site/images/vcfaviconwap.png') }}">
                    </div>
                    <div class="footer_right" style="margin-left:10px;
                        float: left;">
                        <p style="margin:0;">Questions? Email <a style="color: #555;"
                                href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                        <p style="margin:0;">VendorsCity Portal LLC</p>
                        <div class="footer_links" style=" margin:10px 0;">
                            <a href="" style="width: 100%;color: #555;display: inline-block;">Terms of
                                Use</a>
                            <a href="" style="width: 100%;color: #555;display: inline-block;">Privacy
                                Policy</a>
                            <a href="" style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
