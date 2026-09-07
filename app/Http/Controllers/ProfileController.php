<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Admin\CompanyProfile;
use App\Models\Admin\CompanyProfileDocument;
use App\Models\Admin\CompanyEmployee;
use App\Models\Admin\CompanyEmpDocument;
use App\Enums\EmployeeType;
use Illuminate\View\View;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $profile = CompanyProfile::findorfail('1');
        $profiledocument = CompanyProfileDocument::where('company_profile_id', 1)->get();

        $companydrivers = CompanyEmployee::where('employee', EmployeeType::DRIVER)->orderBy('id', 'DESC')->get();
        $companypackers = CompanyEmployee::where('employee', EmployeeType::CREW)->orderBy('id', 'DESC')->get();
        $companyofficestaffs = CompanyEmployee::where('employee', EmployeeType::OFFICE_STAFF)->orderBy('id', 'DESC')->get();

        return view('profile.edit', [
            'user' => $request->user(),
            'comapny_profile'     => $profile,
            'company_document'    => $profiledocument,
            'companydrivers'      => $companydrivers,
            'companypackers'      => $companypackers,
            'companyofficestaffs' => $companyofficestaffs,
        ]);
    }

    public function company_document_download($id)
    {
        $doc = CompanyProfileDocument::findOrFail($id);

        // If document path is stored like: storage/company/docs/file.pdf
        $filePath = public_path('upload/profile-docs/' . $doc->document);

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath);
    }

    public function driver_document_download(Request $request)
    {
        //echo "<pre>";print_r($request->all()); echo "</pre>";exit; 
        $driverIds = $request->selected;
        if (empty($driverIds)) {
            return back()->with('error', 'Please select at least one driver');
        }
        // Fetch documents
        $documents = CompanyEmpDocument::whereIn('eid', $driverIds)->pluck('document');

        if ($documents->isEmpty()) {
            return back()->with('error', 'No documents found');
        }

        $zip = new ZipArchive;
        $zipFileName = 'driverdocument.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {

            foreach ($documents as $doc) {

                $filePath = public_path('upload/companydriverpackers/' . $doc);

                if (File::exists($filePath)) {
                    // second param = name inside zip
                    $zip->addFile($filePath, basename($doc));
                }
            }

            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function packer_document_download(Request $request)
    {
        //echo "<pre>";print_r($request->all()); echo "</pre>";exit; 
        $packersIds = $request->selected;
        if (empty($packersIds)) {
            return back()->with('error', 'Please select at least one driver');
        }
        // Fetch documents
        $documents = CompanyEmpDocument::whereIn('eid', $packersIds)->pluck('document');

        if ($documents->isEmpty()) {
            return back()->with('error', 'No documents found');
        }

        $zip = new ZipArchive;
        $zipFileName = 'packerdocument.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {

            foreach ($documents as $doc) {

                $filePath = public_path('upload/companydriverpackers/' . $doc);

                if (File::exists($filePath)) {
                    // second param = name inside zip
                    $zip->addFile($filePath, basename($doc));
                }
            }

            $zip->close();
        }
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }


    public function office_staff_document_download(Request $request)
    {

        $officesatffIds = $request->selected;
        if (empty($officesatffIds)) {
            return back()->with('error', 'Please select at least one Company Office Staff');
        }
        // Fetch documents
        $documents = CompanyEmpDocument::whereIn('eid', $officesatffIds)->pluck('document');

        if ($documents->isEmpty()) {
            return back()->with('error', 'No documents found');
        }

        $zip = new ZipArchive;
        $zipFileName = 'officestaffdocument.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {

            foreach ($documents as $doc) {

                $filePath = public_path('upload/companydriverpackers/' . $doc);

                if (File::exists($filePath)) {
                    // second param = name inside zip
                    $zip->addFile($filePath, basename($doc));
                }
            }

            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
