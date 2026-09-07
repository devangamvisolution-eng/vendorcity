<!DOCTYPE html>
<html>
<head>
    <title>Document Expiry Reminder</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 5px;">
        <h2 style="color: #d9534f;">Action Required: Document Expiry Notice</h2>
        
        <p>Dear {{ $vendor->name ?? 'Vendor' }},</p>
        
        <p>This is a reminder that one or more of your important documents are either expiring soon or have already expired. Please click the secure link below to upload your new documents.</p>
        
        <p><strong>Affected Documents:</strong></p>
        <ul>
            @foreach($expiringDocuments as $document)
                <li>
                    <strong>{{ $document['name'] }}</strong> 
                    <br>
                    Expiry Date: 
                    @if($document['is_expired'])
                        <span style="color: red;">{{ $document['date'] }} (Expired)</span>
                    @else
                        <span style="color: #f0ad4e;">{{ $document['date'] }} (Expiring Soon)</span>
                    @endif
                </li>
            @endforeach
        </ul>
        
        <p style="margin-top: 30px;">
            <a href="{{ \Illuminate\Support\Facades\URL::signedRoute('vendor.document.update', ['vendor' => base64_encode($vendor->id)]) }}" style="background-color: #0275d8; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Securely Update Documents (No Login Required)</a>
        </p>

        <p style="margin-top: 30px; font-size: 12px; color: #777;">
            Note: If your documents remain expired for more than 30 days, your vendor account may be automatically deactivated.
        </p>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #999;">This is an automated message from Vendor City. Please do not reply directly to this email.</p>
    </div>
</body>
</html>
