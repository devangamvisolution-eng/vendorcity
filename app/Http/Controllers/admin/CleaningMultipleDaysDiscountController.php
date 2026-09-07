<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;
use Helper;

class CleaningMultipleDaysDiscountController extends Controller
{
    public function index()
    {
        $data['discounts'] = DB::table('cleaning_multiple_days_discounts')->orderBy('number_of_days')->get();
        return view('admin.cleaning_multiple_days_discount.list', $data);
    }

    public function create()
    {
        return view('admin.cleaning_multiple_days_discount.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'number_of_days' => 'required|integer',
            'discount_value' => 'required|numeric'
        ]);

        $data = [
            'number_of_days' => $request->number_of_days,
            'discount_type' => 0, // Assuming 0 is percentage
            'discount_value' => $request->discount_value,
            'is_active' => $request->is_active ?? 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        DB::table('cleaning_multiple_days_discounts')->insert($data);

        return redirect()->route('cleaning_multiple_days_discounts.index')->with('success', 'Discount added successfully');
    }

    public function edit($id)
    {
        $data['discount'] = DB::table('cleaning_multiple_days_discounts')->where('id', $id)->first();
        if (!$data['discount']) {
            return redirect()->route('cleaning_multiple_days_discounts.index')->with('error', 'Discount not found');
        }
        return view('admin.cleaning_multiple_days_discount.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'number_of_days' => 'required|integer',
            'discount_value' => 'required|numeric'
        ]);

        $data = [
            'number_of_days' => $request->number_of_days,
            'discount_value' => $request->discount_value,
            'is_active' => $request->is_active ?? 1,
            'updated_at' => now()
        ];

        DB::table('cleaning_multiple_days_discounts')->where('id', $id)->update($data);

        return redirect()->route('cleaning_multiple_days_discounts.index')->with('success', 'Discount updated successfully');
    }

    public function destroy($id)
    {
        DB::table('cleaning_multiple_days_discounts')->where('id', $id)->delete();
        return redirect()->route('cleaning_multiple_days_discounts.index')->with('success', 'Discount deleted successfully');
    }
}
