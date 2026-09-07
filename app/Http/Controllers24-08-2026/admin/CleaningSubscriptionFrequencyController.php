<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\CleaningSubscriptionFrequency;

class CleaningSubscriptionFrequencyController extends Controller
{
    public function index()
    {
        $data = CleaningSubscriptionFrequency::orderBy('id', 'desc')->get();
        return view('admin.cleaning_subscription_frequencies.index', compact('data'));
    }
    public function create()
    {
        return view('admin.cleaning_subscription_frequencies.add');
    }
    public function store(Request $request)
    {
        CleaningSubscriptionFrequency::create($request->all());
        return redirect()->route('cleaning-subscription-frequencies.index')->with('success', 'Added successfully');
    }
    public function edit($id)
    {
        $data = CleaningSubscriptionFrequency::find($id);
        return view('admin.cleaning_subscription_frequencies.edit', compact('data'));
    }
    public function update(Request $request, $id)
    {
        $data = CleaningSubscriptionFrequency::find($id);
        $data->update($request->all());
        return redirect()->route('cleaning-subscription-frequencies.index')->with('success', 'Updated successfully');
    }
    public function destroy($id)
    {
        CleaningSubscriptionFrequency::find($id)->delete();
        return redirect()->route('cleaning-subscription-frequencies.index')->with('success', 'Deleted successfully');
    }
}
