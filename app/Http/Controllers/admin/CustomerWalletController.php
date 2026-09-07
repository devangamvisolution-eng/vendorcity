<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

class CustomerWalletController extends Controller
{
    private function getPermissions()
    {
        $userId = Auth::id();
        $get_user_data = Helper::get_user_data($userId);

        $roleIds = explode(',', $get_user_data->role_id);
        $permission1 = [];
        $edit_perm = [];

        foreach ($roleIds as $roleId) {
            $roleId = trim($roleId);
            $get_permission_data = Helper::get_permission_data($roleId);

            if (is_object($get_permission_data)) {
                if (property_exists($get_permission_data, 'permission') && $get_permission_data->permission !== '') {
                    $perms = explode(',', $get_permission_data->permission);
                    $permission1 = array_merge($permission1, $perms);
                }

                if (property_exists($get_permission_data, 'editperm') && $get_permission_data->editperm != '') {
                    $perms = explode(',', $get_permission_data->editperm);
                    $edit_perm = array_merge($edit_perm, $perms);
                }
            }
        }

        return [
            'view' => array_values(array_unique($permission1)),
            'edit' => array_values(array_unique($edit_perm)),
        ];
    }

    public function index(Request $request)
    {
        $perms = $this->getPermissions();

        // Fetch all individual wallet transactions
        $query = DB::table('front_user_wallet as fuw')
            ->join('frontloginregisters as fr', 'fuw.userid', '=', 'fr.id')
            ->select('fuw.*', 'fr.customer_id', 'fr.name', 'fr.email', 'fr.mobile', 'fr.country_code');

        if ($request->filled('start_date')) {
            $query->whereDate('fuw.added_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('fuw.added_date', '<=', $request->end_date);
        }

        if ($request->filled('customer_id')) {
            $query->where('fuw.userid', $request->customer_id);
        }

        if ($request->filled('status')) {
            $query->where('fuw.added_from', $request->status);
        }

        $transactions = $query->orderBy('fuw.id', 'DESC')->get();

        if ($request->has('export') && $request->export == 'excel') {
            $filename = 'customer_wallet.xlsx';
            if ($request->filled('customer_id')) {
                $customer = DB::table('frontloginregisters')->where('id', $request->customer_id)->first();
                if ($customer) {
                    $filename = preg_replace('/[^A-Za-z0-9\-]/', '', strtolower($customer->name)) . '.xlsx';
                }
            }
            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\CustomerWalletExport($transactions), $filename);
        }

        $customers = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();

        $data = [
            'transactions' => $transactions,
            'customers' => $customers,
            'edit_perm' => $perms['edit'],
        ];

        return view('admin.customer_wallet.index', $data);
    }

    public function create()
    {
        $perms = $this->getPermissions();

        if (!in_array('86', $perms['edit'])) {
            return redirect()->back()->with('error', 'You do not have permission to modify Customer Wallets.');
        }

        $customers = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();
        return view('admin.customer_wallet.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $perms = $this->getPermissions();

        if (!in_array('86', $perms['edit'])) {
            return redirect()->back()->with('error', 'You do not have permission to modify Customer Wallets.');
        }

        $request->validate([
            'customer_id' => 'required|exists:frontloginregisters,id',
            'amount' => 'required|numeric|min:1',
        ]);

        if (!\Illuminate\Support\Facades\Schema::hasColumn('front_user_wallet', 'note')) {
            \Illuminate\Support\Facades\Schema::table('front_user_wallet', function ($table) {
                $table->text('note')->nullable();
            });
        }

        DB::table('front_user_wallet')->insert([
            'userid' => $request->customer_id,
            'refer_id' => "",
            'added_from' => 0, // 0 means Credit (Add)
            'wallet_amount' => $request->amount,
            'note' => $request->note ?? null,
            'added_date' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('customer-wallet.index')->with('success', "Wallet money added successfully.");
    }

    public function edit()
    {
        $perms = $this->getPermissions();

        if (!in_array('86', $perms['edit'])) {
            return redirect()->back()->with('error', 'You do not have permission to modify Customer Wallets.');
        }

        $customers = DB::table('frontloginregisters')->orderBy('id', 'DESC')->get();
        return view('admin.customer_wallet.edit', compact('customers'));
    }

    public function update(Request $request)
    {
        $perms = $this->getPermissions();

        if (!in_array('86', $perms['edit'])) {
            return redirect()->back()->with('error', 'You do not have permission to modify Customer Wallets.');
        }

        $request->validate([
            'customer_id' => 'required|exists:frontloginregisters,id',
            'amount' => 'required|numeric|min:1',
        ]);

        if (!\Illuminate\Support\Facades\Schema::hasColumn('front_user_wallet', 'note')) {
            \Illuminate\Support\Facades\Schema::table('front_user_wallet', function ($table) {
                $table->text('note')->nullable();
            });
        }

        DB::table('front_user_wallet')->insert([
            'userid' => $request->customer_id,
            'refer_id' => "",
            'added_from' => 1, // 1 means Debit (Deduct)
            'wallet_amount' => $request->amount,
            'note' => $request->note ?? null,
            'added_date' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('customer-wallet.index')->with('success', "Wallet money deducted successfully.");
    }
}
