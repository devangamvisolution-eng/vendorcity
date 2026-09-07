<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class ERP_EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['erp_enquiry_data'] = DB::table('erp_enquiry')->where('enquiry_level', 0)->orderBy('id', 'desc')->get();

        return view('admin.erp_inquiry.list_erp_enquiry', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['customer_type'] = DB::table('customer_type')->get();
        $data['country_data'] = DB::table('countries')->get();
        $data['sourcelead_data'] = DB::table('source_leads')->where('is_active', 0)->orderBy('set_order', 'asc')->get();
        $data['enquiry_mode_data'] = DB::table('enquiry_mode')->where('is_active', 0)->orderBy('set_order', 'asc')->get();
        $data['salesperson_data'] = DB::table('users')->whereIn('role_id', ['11', '12'])->where('is_active', 0)->where('vendor', 0)->get();
        $data['service_data'] = DB::table('services')->where('is_active', '0')->get();


        return view('admin.erp_inquiry.add_erp_enquiry', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  echo"<pre>";print_r($request->all());echo"</pre>";exit;

        $rules = [
            'customer_type' => 'required',
            'service' => 'required|exists:services,id',
            'enquiry_date' => 'required|date',

            'client_box' => 'nullable|in:0,1',
            'client_name' => 'nullable|string|max:255',
            'client_mobile' => 'nullable|min:7|max:15',
            // 'contact_person' => 'nullable|string|max:255',
            // 'contact_person_mobile' => 'nullable|min:7|max:15',
            'address' => 'nullable|string|max:500',

            'origin_desti_move' => 'nullable|in:0,1',

            'general_info_details' => 'nullable|in:0,1',
            'sourcelead_id' => 'nullable',
            'enquiry_mode' => 'nullable',
            'status_id' => 'nullable|in:0,1',
            'salesperson_id' => 'nullable|exists:users,id',
        ];

        // Add conditional rules based on inputs
        // if ($request->input('client_box') == 1) {
        //     $rules = array_merge($rules, [
        //         'client_name' => 'required|string|max:255',
        //         'client_mobile' => 'required|min:7|max:15',
        //         // 'contact_person' => 'nullable|string|max:255',
        //         // 'contact_person_mobile' => 'nullable|min:7|max:15',
        //         'address' => 'required|string|max:500',
        //     ]);
        // }

        // if ($request->input('origin_desti_move') == 1 && $request->input('service') == 30) {
        //     $rules = array_merge($rules, [
        //         'desc_of_goods' => 'required|string|max:255',
        //         'service_required' => 'nullable|string|max:255',
        //         'mode_of_transport' => 'nullable|string|max:255',
        //         'estimated_volume' => 'nullable|numeric',

        //         'origin_add' => 'nullable|string|max:255',
        //         'origin_country' => 'nullable|exists:countries,id',
        //         'origin_state' => 'nullable|string|max:255',
        //         'origin_city' => 'nullable|string|max:255',
        //         'origin_location' => 'nullable|string|max:255',
        //         'origin_zip_post' => 'nullable|string|max:20',

        //         'desti_add' => 'nullable|string|max:255',
        //         'desti_country' => 'nullable|exists:countries,id',
        //         'desti_state' => 'nullable|string|max:255',
        //         'desti_city' => 'nullable|string|max:255',
        //         'desti_location' => 'nullable|string|max:255',
        //         'desti_zip_post' => 'nullable|string|max:20',
        //     ]);
        // }

        // if ($request->input('general_info_details') == 1) {
        //     $rules = array_merge($rules, [
        //         'sourcelead_id' => 'required',
        //         'enquiry_mode' => 'required',
        //         'status_id' => 'required|in:0,1',
        //         'salesperson_id' => 'required|exists:users,id',
        //     ]);
        // }

        $validated = $request->validate($rules);

        $user = Auth::user();

        $data['service'] = $request->service;
        $data['customer_type'] = $request->customer_type;
        $data['enquiry_date'] = date('Y-m-d', strtotime($request->enquiry_date));

        if ($request->client_box != '') {
            $data['client_box'] = '0';
        } else {
            $data['client_box'] = '1';
        }
        $data['client_name'] = $request->client_name;
        $data['client_email'] = $request->client_email;
        $data['client_mobile'] = $request->client_mobile;
        $data['contact_person'] = $request->contact_person;
        $data['contact_person_mobile'] = $request->contact_person_mobile;
        $data['address'] = $request->address;

        if ($request->origin_desti_move != '') {
            $data['origin_desti_move'] = '0';
        } else {
            $data['origin_desti_move'] = '1';
        }
        $data['service_required'] = $request->service_required;

        /* if ($request->input('origin_desti_move') == 1 && $request->input('service') == 30) {
            $data['desc_of_goods']      = $request->desc_of_goods;
        }else{
            $data['desc_of_goods']      = \Helper::servicename($request->input('service'));
        } */
        $data['desc_of_goods'] = \Helper::servicename($request->input('service'));
        $data['mode_of_transport'] = $request->mode_of_transport;
        $data['estimated_volume'] = $request->estimated_volume;
        $data['origin_add'] = $request->origin_add;
        $data['origin_country'] = $request->origin_country;
        $data['origin_state'] = $request->origin_state;
        $data['origin_city'] = $request->origin_city;
        $data['origin_location'] = $request->origin_location;
        $data['origin_zip_post'] = $request->origin_zip_post;
        $data['desti_add'] = $request->desti_add;
        $data['desti_country'] = $request->desti_country;
        $data['desti_state'] = $request->desti_state;
        $data['desti_city'] = $request->desti_city;
        $data['desti_location'] = $request->desti_location;
        $data['desti_zip_post'] = $request->desti_zip_post;

        if ($request->general_info_details != '') {
            $data['general_info_details'] = '0';
        } else {
            $data['general_info_details'] = '1';
        }
        $data['sourcelead_id'] = $request->sourcelead_id;
        $data['enquiry_mode'] = $request->enquiry_mode;
        $data['status_id'] = $request->status_id;
        $data['salesperson_id'] = $request->salesperson_id;
        $data['notes'] = $request->notes;
        $data['added_by'] = $user->id;
        $data['added_date'] = date('Y-m-d');

        $id = DB::table('erp_enquiry')->insertGetId($data);
        if ($id != "") {
            $enquiryId = sprintf('%06d', $id);
            $currentYear = date('Y');
            $datau['quote_no'] = 'ENQ-' . $currentYear . '-' . $enquiryId;

            if ($request->status_id == 1) {
                $datau['survey_id'] = 'SUR-' . $currentYear . '-' . $enquiryId;
                $datau['enquiry_level'] = 1;
            }

            DB::table('erp_enquiry')->where('id', $id)->update($datau);
        }

        return redirect()->route('erp_enquiry.lists')->with('success', 'Enquiry  added successfully');
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
    public function edit($id)
    {
        $data['erp_enquiry'] = DB::table('erp_enquiry')->where('id', $id)->first();

        $data['customer_type'] = DB::table('customer_type')->get();
        $data['country_data'] = DB::table('countries')->get();
        $data['sourcelead_data'] = DB::table('source_leads')->where('is_active', 0)->orderBy('set_order', 'asc')->get();
        $data['enquiry_mode_data'] = DB::table('enquiry_mode')->where('is_active', 0)->orderBy('set_order', 'asc')->get();
        $data['salesperson_data'] = DB::table('users')->whereIn('role_id', ['11', '12'])->where('is_active', 0)->where('vendor', 0)->get();
        $data['service_data'] = DB::table('services')->where('is_active', '0')->get();


        return view('admin.erp_inquiry.edit_erp_enquiry', $data);
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
        $rules = [
            'customer_type' => 'required',
            'service' => 'required|exists:services,id',
            'enquiry_date' => 'required|date',

            'client_box' => 'nullable|in:0,1',
            'client_name' => 'nullable|string|max:255',
            'client_mobile' => 'nullable|min:7|max:15',
            // 'contact_person' => 'nullable|string|max:255',
            // 'contact_person_mobile' => 'nullable|min:7|max:15',
            'address' => 'nullable|string|max:500',

            'origin_desti_move' => 'nullable|in:0,1',

            'general_info_details' => 'nullable|in:0,1',
            'sourcelead_id' => 'nullable',
            'enquiry_mode' => 'nullable',
            'status_id' => 'nullable|in:0,1',
        ];

        // if ($request->input('client_box') == 1) {
        //     $rules = array_merge($rules, [
        //         'client_name' => 'required|string|max:255',
        //         'client_mobile' => 'required|min:7|max:15',
        //         'contact_person' => 'nullable|string|max:255',
        //         'contact_person_mobile' => 'nullable|min:7|max:15',
        //         'address' => 'required|string|max:500',
        //     ]);
        // }

        // if ($request->input('origin_desti_move') == 1 && $request->input('service') == 30) {
        //     $rules = array_merge($rules, [
        //         'desc_of_goods' => 'required|string|max:255',
        //         'service_required' => 'nullable|string|max:255',
        //         'mode_of_transport' => 'nullable|string|max:255',
        //         'estimated_volume' => 'nullable|numeric',

        //         'origin_add' => 'nullable|string|max:255',
        //         'origin_country' => 'nullable|exists:countries,id',
        //         'origin_state' => 'nullable|string|max:255',
        //         'origin_city' => 'nullable|string|max:255',
        //         'origin_location' => 'nullable|string|max:255',
        //         'origin_zip_post' => 'nullable|string|max:20',

        //         'desti_add' => 'nullable|string|max:255',
        //         'desti_country' => 'nullable|exists:countries,id',
        //         'desti_state' => 'nullable|string|max:255',
        //         'desti_city' => 'nullable|string|max:255',
        //         'desti_location' => 'nullable|string|max:255',
        //         'desti_zip_post' => 'nullable|string|max:20',
        //     ]);
        // }

        // if ($request->input('general_info_details') == 1) {
        //     $rules = array_merge($rules, [
        //         'sourcelead_id' => 'required',
        //         'enquiry_mode' => 'required',
        //         'status_id' => 'required|in:0,1',
        //         'salesperson_id' => 'required|exists:users,id',
        //     ]);
        // }

        $validated = $request->validate($rules);

        $data['service'] = $request->service;
        $data['customer_type'] = $request->customer_type;
        $data['enquiry_date'] = date('Y-m-d', strtotime($request->enquiry_date));

        if ($request->client_box != '') {
            $data['client_box'] = '0';
        } else {
            $data['client_box'] = '1';
        }
        $data['client_name'] = $request->client_name;
        $data['client_email'] = $request->client_email;
        $data['client_mobile'] = $request->client_mobile;
        $data['contact_person'] = $request->contact_person;
        $data['contact_person_mobile'] = $request->contact_person_mobile;
        $data['address'] = $request->address;

        if ($request->origin_desti_move != '') {
            $data['origin_desti_move'] = '0';
        } else {
            $data['origin_desti_move'] = '1';
        }
        $data['service_required'] = $request->service_required;
        $data['desc_of_goods'] = $request->desc_of_goods;
        $data['mode_of_transport'] = $request->mode_of_transport;
        $data['estimated_volume'] = $request->estimated_volume;
        $data['origin_add'] = $request->origin_add;
        $data['origin_country'] = $request->origin_country;
        $data['origin_state'] = $request->origin_state;
        $data['origin_city'] = $request->origin_city;
        $data['origin_location'] = $request->origin_location;
        $data['origin_zip_post'] = $request->origin_zip_post;
        $data['desti_add'] = $request->desti_add;
        $data['desti_country'] = $request->desti_country;
        $data['desti_state'] = $request->desti_state;
        $data['desti_city'] = $request->desti_city;
        $data['desti_location'] = $request->desti_location;
        $data['desti_zip_post'] = $request->desti_zip_post;

        if ($request->general_info_details != '') {
            $data['general_info_details'] = '0';
        } else {
            $data['general_info_details'] = '1';
        }
        $data['sourcelead_id'] = $request->sourcelead_id;
        $data['enquiry_mode'] = $request->enquiry_mode;
        $data['status_id'] = $request->status_id;
        $data['salesperson_id'] = $request->salesperson_id;
        $data['notes'] = $request->notes;

        if ($request->status_id == 1) {
            $enquiryId = sprintf('%06d', $id);
            $currentYear = date('Y');
            if ($request->status_id == 1) {
                $data['survey_id'] = 'SUR-' . $currentYear . '-' . $enquiryId;
                $data['enquiry_level'] = 1;
            }
        }

        DB::table('erp_enquiry')->where('id', $id)->update($data);

        if ($request->status_id == 1) {
            return redirect()->route('erp_survey.lists')->with('success', 'Survey has been added successfully');
        } else {
            return redirect()->route('erp_enquiry.lists')->with('success', 'Enquiry updated successfully');
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
        $delete_id = $request->selected;
        DB::table('erp_enquiry')->whereIn('id', $delete_id)->delete();
        return redirect()->route('erp_enquiry.lists')->with('success', 'Enquiry deleted successfully.');
    }
}
