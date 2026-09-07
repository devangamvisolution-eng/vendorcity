<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\CleaningSubscriptionDuration;

class CleaningSubscriptionDurationController extends Controller
{
    public function index()
    {
        $data = CleaningSubscriptionDuration::orderBy('id', 'desc')->get();
        return view('admin.cleaning_subscription_durations.index', compact('data'));
    }
    public function create()
    {
        return view('admin.cleaning_subscription_durations.add');
    }
    public function store(Request $request)
    {
        CleaningSubscriptionDuration::create($request->all());
        return redirect()->route('cleaning-subscription-durations.index')->with('success', 'Added successfully');
    }
    public function edit($id)
    {
        $data = CleaningSubscriptionDuration::find($id);
        return view('admin.cleaning_subscription_durations.edit', compact('data'));
    }
    public function update(Request $request, $id)
    {
        $data = CleaningSubscriptionDuration::find($id);
        $data->update($request->all());
        return redirect()->route('cleaning-subscription-durations.index')->with('success', 'Updated successfully');
    }
    public function destroy($id)
    {
        CleaningSubscriptionDuration::find($id)->delete();
        return redirect()->route('cleaning-subscription-durations.index')->with('success', 'Deleted successfully');
    }
}
