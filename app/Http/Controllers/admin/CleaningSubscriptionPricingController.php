<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\CleaningSubscriptionPricing;

class CleaningSubscriptionPricingController extends Controller
{
    public function index() { 
        $data = CleaningSubscriptionPricing::orderBy('id', 'desc')->get(); 
        $durations = \App\Models\admin\CleaningSubscriptionDuration::all()->keyBy('id');
        $frequencies = \App\Models\admin\CleaningSubscriptionFrequency::all()->keyBy('id');
        $packages = \App\Models\admin\CleaningSubscriptionPackage::all()->keyBy('id');
        return view('admin.cleaning_subscription_pricing.index', compact('data', 'durations', 'frequencies', 'packages')); 
    }
    public function create() { 
        $durations = \App\Models\admin\CleaningSubscriptionDuration::all();
        $frequencies = \App\Models\admin\CleaningSubscriptionFrequency::all();
        $packages = \App\Models\admin\CleaningSubscriptionPackage::all();
        return view('admin.cleaning_subscription_pricing.add', compact('durations', 'frequencies', 'packages')); 
    }
    public function store(Request $request) { CleaningSubscriptionPricing::create($request->all()); return redirect()->route('cleaning-subscription-pricing.index')->with('success', 'Added successfully'); }
    public function edit($id) { 
        $data = CleaningSubscriptionPricing::find($id); 
        $durations = \App\Models\admin\CleaningSubscriptionDuration::all();
        $frequencies = \App\Models\admin\CleaningSubscriptionFrequency::all();
        $packages = \App\Models\admin\CleaningSubscriptionPackage::all();
        return view('admin.cleaning_subscription_pricing.edit', compact('data', 'durations', 'frequencies', 'packages')); 
    }
    public function update(Request $request, $id) { $data = CleaningSubscriptionPricing::find($id); $data->update($request->all()); return redirect()->route('cleaning-subscription-pricing.index')->with('success', 'Updated successfully'); }
    public function destroy($id) { CleaningSubscriptionPricing::find($id)->delete(); return redirect()->route('cleaning-subscription-pricing.index')->with('success', 'Deleted successfully'); }
}
