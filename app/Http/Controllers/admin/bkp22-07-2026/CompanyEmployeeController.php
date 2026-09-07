<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\CompanyProfile;
use App\Models\Admin\CompanyEmployee;
use App\Models\Admin\CompanyEmpDocument;
use Illuminate\Http\Request;
use App\Enums\EmployeeType;

class CompanyEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyEmployee = CompanyEmployee::orderBy('id', 'DESC')->get() ?? [];
        $employeeTypes  = EmployeeType::options();
        return view('admin.company_employees.list', compact('companyEmployee', 'employeeTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employeeTypes  = EmployeeType::options();
        return view('admin.company_employees.add', compact('employeeTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $request->validate([
                'employee' => 'required',
                'name' => 'required'
            ]);

            $companyEmployee = new CompanyEmployee;
            $companyEmployee->employee = $request->employee;
            $companyEmployee->name = $request->name;
            $companyEmployee->expiry_date_eid = $request->expiry_date;
            $companyEmployee->save();
            $id = $companyEmployee->id;

            if ($request->document_name && count($request->document_name) > 0) {
                for ($i = 0; $i < count($request->document_name); $i++) {
                    if (!empty($request->document_name[$i])) {
                        $content['eid']  = $id;
                        $content['document_name'] = $request->document_name[$i];

                        if (!empty($request->file('upload_file')[$i])) {
                            $document = $request->file('upload_file')[$i];
                            $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                            $extension = $document->getClientOriginalExtension();

                            $documentName = $originalName . '_' . time() . '.' . $extension;
                            $document->move(public_path('upload/companydriverpackers/'), $documentName);
                            $content['document'] = $documentName;
                        } else {
                            $content['document'] = null;
                        }

                        $this->insert_material($content);
                    }
                }
            }

            DB::commit();
            return redirect()->route('company-employees.index')->with('success', 'Company Employee Added Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Company Employee store Error : " . $e->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyEmployee $companyEmployee)
    {
        $companyEmployee->load('companyEmpDocuments');
        $companyEmpDocuments = $companyEmployee->companyEmpDocuments;
        $employeeTypes  = EmployeeType::options();
        return view('admin.company_employees.edit', compact('companyEmployee', 'companyEmpDocuments', 'employeeTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(request $request, $id)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'employee' => 'required',
                'name' => 'required'
            ]);
            $companyEmployee = CompanyEmployee::findorfail($id);
            $companyEmployee->employee = $request->employee;
            $companyEmployee->name = $request->name;
            $companyEmployee->expiry_date_eid = $request->expiry_date;
            $companyEmployee->save();

            if ($request->document_nameu && count($request->document_nameu) > 0) {
                for ($i = 0; $i < count($request->document_nameu); $i++) {
                    if (!empty($request->document_nameu[$i])) {
                        // $content['enquiry_id']  = $id;
                        $content['document_name']       = $request->document_nameu[$i];
                        $content['updateid1xxx'] = $request->updateid1xxx[$i];


                        $existingDoc = CompanyEmpDocument::where('id', $content['updateid1xxx'])->first();

                        if (isset($request->file('upload_fileu')[$i])) {
                            $document = $request->file('upload_fileu')[$i];
                            $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                            $extension = $document->getClientOriginalExtension();

                            $documentName = $originalName . '_' . time() . '.' . $extension;
                            $document->move(public_path('upload/companydriverpackers/'), $documentName);
                            $content['document'] = $documentName;
                        } else {

                            $content['document'] = $existingDoc ? $existingDoc->document : null;
                        }

                        $this->update_material($content);
                    }
                }
            }

            if ($request->document_name && count($request->document_name) > 0) {
                for ($i = 0; $i < count($request->document_name); $i++) {
                    if (!empty($request->document_name[$i])) {
                        $content['document_name']       = $request->document_name[$i];
                        $content['eid']  = $id;
                        $content['title']       = $request->document_name[$i];

                        if (!empty($request->file('upload_file')[$i])) {
                            $document = $request->file('upload_file')[$i];
                            //$documentName = $document->getClientOriginalName() . '_' . time();
                            $documentName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                            $extension = $document->getClientOriginalExtension();
                            $documentName = $documentName . '_' . time() . '.' . $extension;
                            $document->move(public_path('upload/companydriverpackers/'), $documentName);
                            $content['document'] = $documentName;
                        } else {
                            $content['document'] = null;
                        }
                        $this->insert_material($content);
                    }
                }
            }

            DB::commit();
            return redirect()->route('company-employees.index')->with('success', 'Company Employee Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Company Employee update Error : " . $e->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $delete_id = $request->selected;
            CompanyEmployee::whereIn('id', $delete_id)->delete();
            return redirect()->route('company-employees.index')->with('success', 'Company Employee deleted successfully.');
        } catch (\Exception $e) {

            Log::error("Company Employee delete Error : " . $e->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }


    function insert_material($content)
    {
        $data = [
            'eid'      => $content['eid'],
            'title'    => $content['document_name'],
            'document' => $content['document'],
        ];

        CompanyEmpDocument::create($data);
    }

    function update_material($content)
    {
        $data = [
            'title'     => $content['document_name'],
            'document'  => $content['document'],
        ];
        CompanyEmpDocument::where('id', $content['updateid1xxx'])->update($data);
    }

    public function delete_attribute($eid, $id)
    {
        try {

            CompanyEmpDocument::where('eid', $eid)->where('id', $id)->delete();
            return redirect()->route('company-employees.edit', $eid)->with('success', 'Company Employee Document deleted successfully.');
        } catch (\Exception $e) {

            Log::error("Company Employee Document delete Error : " . $e->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }
}
