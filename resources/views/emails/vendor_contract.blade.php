<!DOCTYPE html>
<html>
<head>
    <title>Vendor Contract</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); max-width: 600px; margin: auto; }
        .header { background-color: #007bff; color: white; padding: 10px; border-radius: 8px 8px 0 0; text-align: center; }
        .content { padding: 20px; font-size: 16px; color: #333; line-height: 1.6; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
        .button { display: inline-block; padding: 10px 20px; margin-top: 20px; background-color: #28a745; color: #fff; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Contract Pending Signature</h2>
        </div>
        <div class="content">
            <p>Dear {{ $vendorData->name ?? 'Vendor' }},</p>
            <p>Your documents have been verified successfully. Attached to this email is your vendor contract.</p>
            <p>Please follow these steps:</p>
            <ol>
                <li>Download the attached PDF contract.</li>
                <li>Print and sign the document manually (or use a digital signature tool).</li>
                <li>Scan and upload the signed document using the button below.</li>
            </ol>
            <p>Once you have uploaded the signed contract, our team will review and approve your account.</p>
            <a href="{{ URL::signedRoute('vendor.contract.upload.form', ['id' => $vendorData->id]) }}" class="button">Upload Signed Contract</a>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Vendor City. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
