<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VendorDocumentUpdateController extends Controller
{
    /**
     * Display the document update form for the specific vendor.
     */
    public function show(Request $request, $vendorId)
    {
        $vendorId = base64_decode($vendorId);
        $vendor = User::findOrFail($vendorId);

        // Calculate which documents are expiring to show only the necessary fields
        $now = Carbon::now();
        $documentsToCheck = [
            'vat_certificate_expiry' => ['name' => 'VAT Certificate', 'file_input' => 'vat_certificate', 'date_input' => 'vat_certificate_expiry'],
            'trn_certificate_expiry' => ['name' => 'TRN Certificate', 'file_input' => 'trn_certificate', 'date_input' => 'trn_certificate_expiry'],
            'tlexpiry' => ['name' => 'Trade License', 'file_input' => 'tradelicense', 'date_input' => 'tlexpiry'],
            'passport_expiry' => ['name' => 'Passport', 'file_input' => 'passport', 'date_input' => 'passport_expiry'],
            'emirates_id_expiry' => ['name' => 'Emirates ID', 'file_input' => 'emirates_id', 'date_input' => 'emirates_id_expiry']
        ];

        $expiringDocuments = [];

        foreach ($documentsToCheck as $column => $docInfo) {
            $dateString = trim($vendor->$column);
            if (!empty($dateString) && $dateString !== '0000-00-00' && $dateString !== '0000-00-00 00:00:00' && $dateString !== '1970-01-01') {
                try {
                    $expiryDate = Carbon::parse($dateString);
                    if ($expiryDate->year > 2000) {
                        $daysUntilExpiry = $now->diffInDays($expiryDate, false);
                        if ($daysUntilExpiry <= 60) {
                            $expiringDocuments[] = $docInfo;
                        }
                    }
                } catch (\Exception $e) {}
            }
        }

        // If no documents are expiring, maybe they already updated them
        if (count($expiringDocuments) === 0) {
            return redirect()->route('vendor.document.update.thankyou')->with([
                'title' => 'Up to Date!',
                'message' => 'Your documents are already up to date!'
            ]);
        }

        return view('front.vendor_document_update', compact('vendor', 'expiringDocuments'));
    }

    /**
     * Process the uploaded documents and save them to the database.
     */
    public function update(Request $request, $vendorId)
    {
        $vendorId = base64_decode($vendorId);
        $vendor = User::findOrFail($vendorId);
        
        $request->validate([
            'vat_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'trn_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'tradelicense' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'passport' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'emirates_id' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'vat_certificate_expiry' => 'nullable|date',
            'trn_certificate_expiry' => 'nullable|date',
            'tlexpiry' => 'nullable|date',
            'passport_expiry' => 'nullable|date',
            'emirates_id_expiry' => 'nullable|date',
        ]);

        $data = [];
        $path = public_path('upload/vendors/');

        // Mapping file inputs to db columns
        $fileFields = [
            'vat_certificate' => 'vatcertificate',
            'trn_certificate' => 'trncertificate',
            'tradelicense' => 'tradelicense',
            'passport' => 'passport',
            'emirates_id' => 'emirates_id'
        ];

        $dateFields = [
            'vat_certificate_expiry',
            'trn_certificate_expiry',
            'tlexpiry',
            'passport_expiry',
            'emirates_id_expiry'
        ];

        // Process files
        foreach ($fileFields as $inputName => $dbColumn) {
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $fileName);
                $data[$dbColumn] = $fileName;
            }
        }

        // Process dates
        foreach ($dateFields as $dateField) {
            if ($request->filled($dateField)) {
                $data[$dateField] = $request->input($dateField);
            }
        }

        // Reset the reminder flag so the cron job knows it was handled
        $data['last_expiry_reminder_sent_at'] = null;

        if (count($data) > 0) {
            $data['document_status'] = 'pending';
            DB::table('users')->where('id', $vendorId)->update($data);
        }

        return redirect()->route('vendor.document.update.thankyou')->with([
            'title' => 'Update Successful!',
            'message' => 'Your documents have been successfully updated! You can now log in.'
        ]);
    }

    /**
     * Display the thank you page.
     */
    public function thankYou()
    {
        return view('front.vendor_document_update_thankyou');
    }
}
