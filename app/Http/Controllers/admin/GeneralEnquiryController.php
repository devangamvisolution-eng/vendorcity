<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\GeneralEnquiry;
use App\Models\FrontLoginRegister;
use App\Models\Admin\Service;
use App\Models\Admin\Subservice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GeneralEnquiryController extends Controller
{
    public function __construct()
    {
        if (!\Illuminate\Support\Facades\Schema::hasColumn('general_enquiries', 'notes')) {
            \Illuminate\Support\Facades\Schema::table('general_enquiries', function ($table) {
                $table->text('notes')->nullable();
            });
        }
    }

    public function index(Request $request)
    {
        $query = GeneralEnquiry::leftJoin('services', 'services.id', '=', 'general_enquiries.service_id')
            ->leftJoin('subservices', 'subservices.id', '=', 'general_enquiries.subservice_id')
            ->leftJoin('users', 'users.id', '=', 'general_enquiries.salesperson_id')
            ->leftJoin('source_leads', 'source_leads.id', '=', 'general_enquiries.source_lead_id')
            ->leftJoin('frontloginregisters', 'frontloginregisters.id', '=', 'general_enquiries.customer_id')
            ->select('general_enquiries.*', 'services.servicename', 'subservices.subservicename', 'users.name as salesperson_name', 'source_leads.name as source_name', 'frontloginregisters.name as c_name', 'frontloginregisters.mobile as c_mobile');

        $user_data = Auth::user();
        $roleIds = explode(',', $user_data->role_id ?? '');

        // Restrict list to unassigned enquiries AND the user's own enquiries if they are a salesperson
        if (in_array('11', $roleIds) && !in_array('1', $roleIds)) {
            $query->where(function ($q) use ($user_data) {
                $q->whereNull('general_enquiries.salesperson_id')
                    ->orWhere('general_enquiries.salesperson_id', $user_data->id);
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('general_enquiries.created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('general_enquiries.created_at', '<=', $request->end_date);
        }
        if ($request->filled('customer_id')) {
            $query->where('general_enquiries.customer_id', $request->customer_id);
        }
        if ($request->filled('status')) {
            $query->where('general_enquiries.status', $request->status);
        }
        if ($request->filled('salesperson_id')) {
            $query->where('general_enquiries.salesperson_id', $request->salesperson_id);
        }
        if ($request->filled('source_lead_id')) {
            $query->whereRaw('FIND_IN_SET(?, general_enquiries.source_lead_id)', [$request->source_lead_id]);
        }
        if ($request->filled('service_id')) {
            $query->where('general_enquiries.service_id', $request->service_id);
        }
        if ($request->filled('subservice_id')) {
            $query->where('general_enquiries.subservice_id', $request->subservice_id);
        }

        $subservice_summary = (clone $query)
            ->groupBy('subservices.subservicename')
            ->select('subservices.subservicename as name', DB::raw('count(*) as total'))
            ->get();

        $enquiriesForSource = (clone $query)->pluck('general_enquiries.source_lead_id');
        $sourceCounts = [];
        foreach ($enquiriesForSource as $source_lead_id_str) {
            if ($source_lead_id_str) {
                $ids = explode(',', $source_lead_id_str);
                foreach ($ids as $id) {
                    $id = trim($id);
                    if ($id !== '') {
                        $sourceCounts[$id] = ($sourceCounts[$id] ?? 0) + 1;
                    }
                }
            }
        }

        $source_summary = collect();
        if (!empty($sourceCounts)) {
            $sourceLeadsData = DB::table('source_leads')->whereIn('id', array_keys($sourceCounts))->get()->keyBy('id');
            foreach ($sourceCounts as $id => $count) {
                if (isset($sourceLeadsData[$id])) {
                    $source_summary->push((object)[
                        'name' => $sourceLeadsData[$id]->name,
                        'total' => $count
                    ]);
                }
            }
        }

        $status_summary = (clone $query)
            ->groupBy('general_enquiries.status')
            ->select('general_enquiries.status as name', DB::raw('count(*) as total'))
            ->get();

        $query->orderBy('general_enquiries.id', 'DESC');

        $source_leads = [];
        if (DB::getSchemaBuilder()->hasTable('source_leads')) {
            $source_leads = DB::table('source_leads')->where('is_active', '0')->orderBy('name', 'ASC')->get();
        }

        if ($request->export === 'excel') {
            $enquiriesForExport = $query->get();
            $filename = "general_enquiries_" . date('Ymd_His') . ".xlsx";

            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\GeneralEnquiriesExport(
                    $enquiriesForExport,
                    $source_leads,
                    $subservice_summary,
                    $source_summary,
                    $status_summary
                ),
                $filename
            );
        }

        $enquiries = $query->paginate(15)->appends($request->except('page'));

        $salespersonsQuery = DB::table('users')
            ->whereIn('role_id', [11, 12])
            ->where('is_active', '0');

        if (in_array('11', $roleIds) && !in_array('1', $roleIds)) {
            $salespersonsQuery->where('id', $user_data->id);
        }

        $salespersons = $salespersonsQuery->orderBy('name', 'asc')->get();

        $customers = FrontLoginRegister::orderBy('name', 'ASC')->get();

        $services = Service::where('is_active', 0)->orderBy('servicename', 'ASC')->get();

        $subservices = [];
        if ($request->filled('service_id')) {
            $subservices = Subservice::where('serviceid', $request->service_id)->where('is_active', 0)->orderBy('subservicename', 'ASC')->get();
        }

        return view('admin.general_enquiries.index', compact('enquiries', 'salespersons', 'customers', 'source_leads', 'services', 'subservices', 'subservice_summary', 'source_summary', 'status_summary'));
    }

    public function create()
    {
        $customers = FrontLoginRegister::orderBy('name', 'ASC')->get();
        $services = Service::where('is_active', 0)->orderBy('servicename', 'ASC')->get();
        // Fallback check if source_leads table exists or we can just fetch it:
        $source_leads = [];
        if (DB::getSchemaBuilder()->hasTable('source_leads')) {
            $source_leads = DB::table('source_leads')->where('is_active', '0')->orderBy('name', 'ASC')->get();
        }
        return view('admin.general_enquiries.add', compact('customers', 'services', 'source_leads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
            'customer_name' => 'required',
            'customer_phone' => 'required',
        ]);

        $customerId = $request->customer_id;

        // If no customer is selected, check if mobile exists or create new
        if (empty($customerId)) {
            $existingCustomer = FrontLoginRegister::where('mobile', $request->customer_phone)->first();
            if ($existingCustomer) {
                $customerId = $existingCustomer->id;
            } else {
                $newCustomer = FrontLoginRegister::create([
                    'name' => $request->customer_name,
                    'email' => $request->customer_email,
                    'mobile' => $request->customer_phone,
                    'country_code' => $request->country_code,
                    'password' => bcrypt('12345678') // default dummy password
                ]);
                $customerId = $newCustomer->id;
            }
        } else {
            // Update the existing customer if details were changed
            $customer = FrontLoginRegister::find($customerId);
            if ($customer) {
                $customer->update([
                    'name' => $request->customer_name,
                    'email' => $request->customer_email,
                    'mobile' => $request->customer_phone,
                    'country_code' => $request->country_code
                ]);
            }
        }

        $enquiry = new GeneralEnquiry();
        $enquiry->customer_id = $customerId;
        $enquiry->service_id = $request->service_id;
        $enquiry->subservice_id = $request->subservice_id;
        $enquiry->source_lead_id = is_array($request->source_lead_id) ? implode(',', $request->source_lead_id) : $request->source_lead_id;
        $enquiry->customer_name = $request->customer_name;
        $enquiry->customer_email = $request->customer_email;
        $enquiry->customer_phone = $request->customer_phone;
        $enquiry->country_code = $request->country_code;
        $enquiry->notes = $request->notes;
        if ($request->has('status') && $request->status) {
            $enquiry->status = $request->status;
        } else {
            $enquiry->status = 'Pending';
        }
        $enquiry->created_by = Auth::id();
        $enquiry->save();

        return redirect()->route('general-enquiries.index')->with('success', 'Enquiry added successfully.');
    }

    public function edit($id)
    {
        $enquiry = GeneralEnquiry::findOrFail($id);
        $customers = FrontLoginRegister::orderBy('name', 'ASC')->get();
        $services = Service::where('is_active', 0)->orderBy('servicename', 'ASC')->get();
        $subservices = Subservice::where('serviceid', $enquiry->service_id)->where('is_active', 0)->orderBy('subservicename', 'ASC')->get();

        $source_leads = [];
        if (DB::getSchemaBuilder()->hasTable('source_leads')) {
            $source_leads = DB::table('source_leads')->where('is_active', '0')->orderBy('name', 'ASC')->get();
        }

        return view('admin.general_enquiries.edit', compact('enquiry', 'customers', 'services', 'subservices', 'source_leads'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'service_id' => 'required',
            'customer_name' => 'required',
            'customer_phone' => 'required',
        ]);

        $enquiry = GeneralEnquiry::findOrFail($id);
        $customerId = $request->customer_id;

        if (empty($customerId)) {
            $existingCustomer = FrontLoginRegister::where('mobile', $request->customer_phone)->first();
            if ($existingCustomer) {
                $customerId = $existingCustomer->id;
            } else {
                $newCustomer = FrontLoginRegister::create([
                    'name' => $request->customer_name,
                    'email' => $request->customer_email,
                    'mobile' => $request->customer_phone,
                    'country_code' => $request->country_code,
                    'password' => bcrypt('12345678')
                ]);
                $customerId = $newCustomer->id;
            }
        } else {
            $customer = FrontLoginRegister::find($customerId);
            if ($customer) {
                $customer->update([
                    'name' => $request->customer_name,
                    'email' => $request->customer_email,
                    'mobile' => $request->customer_phone,
                    'country_code' => $request->country_code
                ]);
            }
        }

        $enquiry->customer_id = $customerId;
        $enquiry->service_id = $request->service_id;
        $enquiry->subservice_id = $request->subservice_id;
        $enquiry->source_lead_id = is_array($request->source_lead_id) ? implode(',', $request->source_lead_id) : $request->source_lead_id;
        $enquiry->customer_name = $request->customer_name;
        $enquiry->customer_email = $request->customer_email;
        $enquiry->customer_phone = $request->customer_phone;
        $enquiry->country_code = $request->country_code;
        $enquiry->notes = $request->notes;
        if ($request->has('status') && $request->status) {
            $enquiry->status = $request->status;
        }
        $enquiry->save();

        return redirect()->route('general-enquiries.index')->with('success', 'Enquiry updated successfully.');
    }

    public function destroy($id)
    {
        $enquiry = GeneralEnquiry::findOrFail($id);
        $enquiry->delete();
        return redirect()->route('general-enquiries.index')->with('success', 'Enquiry deleted successfully.');
    }

    // AJAX endpoints
    public function getCustomerDetails(Request $request)
    {
        $customer = FrontLoginRegister::find($request->customer_id);
        if ($customer) {
            return response()->json([
                'success' => true,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->mobile,
                'country_code' => $customer->country_code ?? '+971',
            ]);
        }
        return response()->json(['success' => false]);
    }

    public function getSubservices(Request $request)
    {
        $subservices = Subservice::where('serviceid', $request->service_id)
            ->where('is_active', 0)
            ->orderBy('subservicename', 'ASC')
            ->get();
        return response()->json($subservices);
    }

    public function checkCustomerExist(Request $request)
    {
        $phone = $request->phone;
        $customer = FrontLoginRegister::where('mobile', $phone)->first();

        if ($customer) {
            return response()->json([
                'exists' => true,
                'customer_id' => $customer->id,
                'name' => $customer->name
            ]);
        }

        return response()->json(['exists' => false]);
    }

    public function assignSalesperson(Request $request)
    {
        $request->validate([
            'enquiry_id' => 'required|exists:general_enquiries,id',
            'salesperson_id' => 'nullable|exists:users,id',
            'status' => 'required|string'
        ]);

        $enquiry = GeneralEnquiry::find($request->enquiry_id);
        if ($enquiry) {
            $enquiry->salesperson_id = $request->salesperson_id;
            $enquiry->status = $request->status;
            $enquiry->save();

            return response()->json(['success' => true, 'message' => 'Salesperson and Status updated successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Enquiry not found.']);
    }
}
