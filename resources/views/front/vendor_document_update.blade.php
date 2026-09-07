<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Expiring Documents - VendorsCity</title>
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
            --error-color: #ef4444;
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
            max-width: 600px;
            padding: 20px;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 40px;
            border: 1px solid var(--border-color);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            height: 45px;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 10px;
            color: var(--text-dark);
        }

        .header p {
            color: var(--text-light);
            font-size: 15px;
            margin: 0;
        }

        .document-group {
            background-color: #f9fafb;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.2s ease;
        }

        .document-group:hover {
            border-color: #d1d5db;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .document-group h3 {
            margin: 0 0 15px;
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            color: var(--text-dark);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
            color: var(--text-light);
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .is-invalid {
            border-color: var(--error-color) !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }

        .invalid-feedback {
            color: var(--error-color);
            font-size: 12px;
            margin-top: 5px;
            display: block;
            font-weight: 500;
        }

        .btn-submit {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 14px 24px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: var(--primary-hover);
        }

        .btn-submit:active {
            transform: translateY(1px);
        }

        .alert-info {
            background-color: #e0f2fe;
            color: #0369a1;
            padding: 12px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 20px;
            border: 1px solid #bae6fd;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 20px;
            border: 1px solid #fecaca;
        }
        
        .jquery-error {
            color: var(--error-color);
            font-size: 12px;
            margin-top: 5px;
            display: block;
            font-weight: 500;
        }

        .btn-loading {
            background-color: #93c5fd !important;
            cursor: not-allowed !important;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loader {
            border: 2px solid #f3f3f3;
            border-top: 2px solid white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="header">
                <img src="{{ asset('public/admin/assets/img/logo.png') }}"
                    onerror="this.src='{{ asset('public/site/images/v-cfavicon.png') }}'" alt="VendorsCity Logo">
                <h1>Update Your Documents</h1>
                <p>Welcome back, <strong>{{ $vendor->name }}</strong></p>
            </div>

            @if ($errors->any())
                <div class="alert-danger">
                    Please fix the errors below before submitting.
                </div>
            @endif

            <div class="alert-info">
                Please provide the updated files and new expiry dates for the documents listed below.
            </div>

            <form id="documentForm"
                action="{{ \Illuminate\Support\Facades\URL::signedRoute('vendor.document.update.submit', base64_encode($vendor->id)) }}"
                method="POST" enctype="multipart/form-data">
                @csrf

                @foreach($expiringDocuments as $doc)
                <div class="document-group">
                    <h3>{{ $doc['name'] }}</h3>
                    
                    <div class="form-group">
                        <label for="{{ $doc['file_input'] }}">Upload New Document (PDF/Image)</label>
                        <input type="file" name="{{ $doc['file_input'] }}" id="{{ $doc['file_input'] }}" class="form-control file-input @error($doc['file_input']) is-invalid @enderror">
                        <span class="jquery-error" id="error-{{ $doc['file_input'] }}" style="display:none;"></span>
                        @error($doc['file_input'])
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="{{ $doc['date_input'] }}">New Expiry Date</label>
                        <input type="date" name="{{ $doc['date_input'] }}" id="{{ $doc['date_input'] }}" class="form-control date-input @error($doc['date_input']) is-invalid @enderror">
                        <span class="jquery-error" id="error-{{ $doc['date_input'] }}" style="display:none;"></span>
                        @error($doc['date_input'])
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn-submit" id="submitBtn">
                <span class="btn-text">Submit Updates</span>
                <span class="loader" style="display:none;"></span>
            </button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#documentForm').on('submit', function(e) {
            let isValid = true;
            $('.jquery-error').hide();
            $('.form-control').removeClass('is-invalid');
            
            // Validate all file inputs
            $('.file-input').each(function() {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    $('#error-' + $(this).attr('id')).text('Please select a file to upload.').show();
                } else {
                    let ext = $(this).val().split('.').pop().toLowerCase();
                    if($.inArray(ext, ['gif','png','jpg','jpeg','pdf']) == -1) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                        $('#error-' + $(this).attr('id')).text('Only PDF and Image files are allowed.').show();
                    }
                }
            });

            // Validate all date inputs
            $('.date-input').each(function() {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    $('#error-' + $(this).attr('id')).text('Please select an expiry date.').show();
                }
            });

            if (!isValid) {
                e.preventDefault(); // Stop submission
            } else {
                // Show Loader
                $('#submitBtn').addClass('btn-loading').prop('disabled', true);
                $('.btn-text').hide();
                $('.loader').show();
            }
        });
        
        // Remove error styling when user changes input
        $('.form-control').on('change', function() {
            $(this).removeClass('is-invalid');
            $('#error-' + $(this).attr('id')).hide();
        });
    });
</script>

</body>
</html>