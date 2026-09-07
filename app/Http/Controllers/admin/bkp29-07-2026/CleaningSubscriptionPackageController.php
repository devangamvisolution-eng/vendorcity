<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\CleaningSubscriptionPackage;

class CleaningSubscriptionPackageController extends Controller
{
    public function index() { $data = CleaningSubscriptionPackage::orderBy('id', 'desc')->get(); return view('admin.cleaning_subscription_packages.index', compact('data')); }
    public function create() { return view('admin.cleaning_subscription_packages.add'); }
    public function store(Request $request) { CleaningSubscriptionPackage::create($request->all()); return redirect()->route('cleaning-subscription-packages.index')->with('success', 'Added successfully'); }
    public function edit($id) { $data = CleaningSubscriptionPackage::find($id); return view('admin.cleaning_subscription_packages.edit', compact('data')); }
    public function update(Request $request, $id) { $data = CleaningSubscriptionPackage::find($id); $data->update($request->all()); return redirect()->route('cleaning-subscription-packages.index')->with('success', 'Updated successfully'); }
    public function destroy($id) { CleaningSubscriptionPackage::find($id)->delete(); return redirect()->route('cleaning-subscription-packages.index')->with('success', 'Deleted successfully'); }
}
