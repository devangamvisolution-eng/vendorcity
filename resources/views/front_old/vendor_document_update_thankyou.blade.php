<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents Updated - VendorsCity</title>
    <link href="{{ asset('public/site/images/v-cfavicon.png') }}" sizes="128x128" rel="shortcut icon" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #007bff;
            --primary-hover: #0056b3;
            --bg-color: #f4f7fa;
            --card-bg: #ffffff;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --border-color: #e5e7eb;
            --success-color: #10b981;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 40px;
            border: 1px solid var(--border-color);
            text-align: center;
        }

        .header img {
            height: 45px;
            margin-bottom: 20px;
        }

        .success-icon {
            color: var(--success-color);
            font-size: 64px;
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
        }

        .success-icon svg {
            width: 80px;
            height: 80px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 10px;
            color: var(--text-dark);
        }

        p {
            color: var(--text-light);
            font-size: 15px;
            line-height: 1.5;
            margin: 0 0 30px;
        }

        .btn-login {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 14px 24px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            box-sizing: border-box;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s, transform 0.1s;
        }

        .btn-login:hover {
            background-color: var(--primary-hover);
        }

        .btn-login:active {
            transform: translateY(1px);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="header">
                <img src="{{ asset('public/admin/assets/img/logo.png') }}"
                    onerror="this.src='{{ asset('public/site/images/v-cfavicon.png') }}'" alt="VendorsCity Logo">
            </div>

            <div class="success-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>

            <h1>{{ session('title', 'Updated Successful!') }}</h1>

            <p>
                {{ session('message', 'Thank you! Your documents have been successfully updated.') }}
            </p>

            <a href="{{ url('vendor/login') }}" class="btn-login">
                Go to Login
            </a>
        </div>
    </div>

</body>

</html>
