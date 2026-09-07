<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Suspended - VendorsCity</title>
    <link href="{{ asset('public/site/images/v-cfavicon.png') }}" sizes="128x128" rel="shortcut icon" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #e5e7eb;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
        }

        .container {
            max-width: 600px;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: transparent;
        }

        .icon-circle {
            width: 100px;
            height: 100px;
            background-color: #df6666;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 25px;
        }

        .icon-inner {
            width: 35px;
            height: 35px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #df6666;
            font-size: 20px;
            font-weight: bold;
        }

        h1 {
            color: #4b5563;
            font-size: 32px;
            margin: 0 0 15px 0;
            font-weight: 700;
        }
        
        .emoji {
            font-size: 28px;
            vertical-align: middle;
        }

        p {
            color: #9ca3af;
            font-size: 18px;
            margin: 0 0 35px 0;
            line-height: 1.5;
        }

        .btn-upload {
            background-color: #4b7bc2;
            color: white;
            padding: 15px 35px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #5a8bd2;
            box-shadow: 0 0 0 4px rgba(90, 139, 210, 0.2);
            transition: all 0.2s ease;
            margin-bottom: 25px;
            text-transform: uppercase;
        }
        
        .btn-upload i {
            margin-right: 10px;
            font-size: 18px;
        }

        .btn-upload:hover {
            background-color: #3b6baf;
            border-color: #4a7bc2;
        }

        .support-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .support-link {
            color: #4b7bc2;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
        }

        .support-link:hover {
            text-decoration: underline;
        }

        .support-link i {
            margin-right: 8px;
        }

        .mail-link {
            color: #6b7280;
        }
    </style>
</head>
<body>

    <div class="container">
        
        <div class="icon-circle">
            <div class="icon-inner">!</div>
        </div>

        <h1>Your account is suspended! <span class="emoji">😞</span></h1>
        
        <p>Please upload your updated documents and contact Support to restore your account.</p>

        @php
            $signedUrl = \Illuminate\Support\Facades\URL::signedRoute('vendor.document.update', ['vendor' => base64_encode(auth()->user()->id)]);
            $whatsappNumber = '+971501234567'; // Placeholder, user will change this
            $whatsappMessage = urlencode('Hello, my vendor account (ID: '.auth()->user()->id.') has been suspended due to expired documents. I need help restoring it.');
            $supportEmail = 'support@vendorscity.com'; // Placeholder
        @endphp

        <a href="{{ $signedUrl }}" class="btn-upload">
            <i class="fas fa-file-upload"></i> UPLOAD DOCUMENTS
        </a>

        <div class="support-links">
            <a href="https://wa.me/{{ str_replace('+', '', $whatsappNumber) }}?text={{ $whatsappMessage }}" target="_blank" class="support-link">
                <i class="fab fa-whatsapp"></i> Talk to Support
            </a>
            
            <a href="mailto:{{ $supportEmail }}" class="support-link mail-link">
                <i class="far fa-envelope"></i> Email Support
            </a>
        </div>
        
    </div>

</body>
</html>
