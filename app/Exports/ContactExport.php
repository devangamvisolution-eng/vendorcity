<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
// use Maatwebsite\Excel\Concerns\FromCollection;

class ContactExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Contact_us::all();
    // }

    public function view(): View
    {
        return view('admin.frontuser-csv', 
        [
            'frontuser' => DB::table('frontloginregisters')->get()
        ]);
    }
}