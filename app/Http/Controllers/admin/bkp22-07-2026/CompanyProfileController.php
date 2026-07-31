<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\CompanyProfile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\CompanyProfileDocument;

class CompanyProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyProfile $companyProfile)
    {
        $companyProfile->load('companyProfileDocuments');
        $companyProfileDocuments = $companyProfile->companyProfileDocuments;
        return view('admin.company_profile.edit-company-profile', compact('companyProfile', 'companyProfileDocuments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $companyProfile = CompanyProfile::findorfail($id);
            $companyProfile->name = $request->comapnyname;
            $companyProfile->website = $request->website;
            $companyProfile->mobile = $request->mobile;
            $companyProfile->address = $request->address;
            $companyProfile->gmap = $request->g_map;
            $companyProfile->save();


            if ($request->titleu && count($request->titleu) > 0) {
                for ($i = 0; $i < count($request->titleu); $i++) {
                    if (!empty($request->titleu[$i])) {
                        // $content['enquiry_id']  = $id;
                        $content['title']       = $request->titleu[$i];
                        $content['updateid1xxx'] = $request->updateid1xxx[$i];


                        $existingDoc = CompanyProfileDocument::where('id', $content['updateid1xxx'])->first();
                        if (isset($request->file('upload_fileu')[$i])) {
                            $document = $request->file('upload_fileu')[$i];
                            $documentName = time() . '_' . $document->getClientOriginalName();
                            $document->move(public_path('upload/profile-docs'), $documentName);
                            $content['document_upload'] = $documentName;
                        } else {
                            $content['document_upload'] = $existingDoc ? $existingDoc->document : null;
                        }

                        $this->update_material($content);
                    }
                }
            }

            if ($request->title1 && count($request->title1) > 0) {
                for ($i = 0; $i < count($request->title1); $i++) {
                    if (!empty($request->title1[$i])) {
                        $content['cid']  = $id;
                        $content['title']       = $request->title1[$i];


                        if (!empty($request->file('upload_file1')[$i])) {
                            $document = $request->file('upload_file1')[$i];
                            $documentName = time() . '_' . $document->getClientOriginalName();
                            $document->move(public_path('upload/profile-docs'), $documentName);
                            $content['document_upload'] = $documentName;
                        } else {
                            $content['document_upload'] = null;
                        }


                        $this->insert_material($content);
                    }
                }
            }

            DB::commit();

            return redirect()->route('company-profile.edit', $id)->with('success', 'Company Profile Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Company Profile Edit Error : " . $e->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function insert_material($content)
    {
        $data = [
            'company_profile_id'  => $content['cid'],
            'title'       => $content['title'],
            'document'    => $content['document_upload'],
        ];

        CompanyProfileDocument::insert($data);
    }

    function update_material($content)
    {
        $data = [
            'title'       => $content['title'],
            'document'    => $content['document_upload'],
        ];

        CompanyProfileDocument::where('id', $content['updateid1xxx'])->update($data);
    }

    public function delete_attribute($cid, $id)
    {

        try {
            $res = CompanyProfileDocument::where('company_profile_id', $cid)->where('id', $id)->delete();
            return redirect()->route('company-profile.edit', $cid)->with('success', 'Company Document Deleted Successfully');
        } catch (\Exception $e) {
            Log::error("Company Profile Document Edit Error : " . $e->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }
}
