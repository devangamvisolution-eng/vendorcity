<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\CleaningSubscriptionDuration;
use App\Models\admin\CleaningSubscriptionPackage;
use App\Models\admin\CleaningSubscriptionFrequency;
use App\Models\admin\CleaningSubscriptionPricing;

class CleaningSubscriptionConfigController extends Controller
{
    public function index()
    {
        $durations = CleaningSubscriptionDuration::all();
        $packages = CleaningSubscriptionPackage::all();
        $frequencies = CleaningSubscriptionFrequency::all();
        $pricings = CleaningSubscriptionPricing::with(['duration', 'frequency', 'package'])->get();

        return view('admin.cleaning_subscription_config', compact('durations', 'packages', 'frequencies', 'pricings'));
    }

    // --- Durations ---
    public function storeDuration(Request $request)
    {
        $request->validate(['hours' => 'required|numeric']);
        CleaningSubscriptionDuration::create($request->all());
        return redirect()->back()->with('success', 'Duration added successfully.');
    }
    public function deleteDuration($id)
    {
        CleaningSubscriptionDuration::find($id)->delete();
        return redirect()->back()->with('success', 'Duration deleted successfully.');
    }

    // --- Packages ---
    public function storePackage(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'discount_percentage' => 'required|numeric',
            'validity_months' => 'required|numeric'
        ]);
        CleaningSubscriptionPackage::create($request->all());
        return redirect()->back()->with('success', 'Package added successfully.');
    }
    public function deletePackage($id)
    {
        CleaningSubscriptionPackage::find($id)->delete();
        return redirect()->back()->with('success', 'Package deleted successfully.');
    }

    // --- Frequencies ---
    public function storeFrequency(Request $request)
    {
        $request->validate([
            'visits_per_week' => 'required|numeric',
            'label' => 'required'
        ]);
        CleaningSubscriptionFrequency::create($request->all());
        return redirect()->back()->with('success', 'Frequency added successfully.');
    }
    public function deleteFrequency($id)
    {
        CleaningSubscriptionFrequency::find($id)->delete();
        return redirect()->back()->with('success', 'Frequency deleted successfully.');
    }

    // --- Pricing ---
    public function storePricing(Request $request)
    {
        $request->validate([
            'duration_id' => 'required',
            'frequency_id' => 'required',
            'package_id' => 'required',
            'price_per_hour' => 'required|numeric'
        ]);
        CleaningSubscriptionPricing::create($request->all());
        return redirect()->back()->with('success', 'Pricing rule added successfully.');
    }
    public function deletePricing($id)
    {
        CleaningSubscriptionPricing::find($id)->delete();
        return redirect()->back()->with('success', 'Pricing rule deleted successfully.');
    }
}
