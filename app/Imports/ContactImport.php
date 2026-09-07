<?php

namespace App\Imports;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $user = \DB::table('frontloginregisters')->get();
        $getUserEmail = $user->pluck('email');
        foreach ($rows as $row) {

            if($getUserEmail->contains($row['email']) == false){
                DB::table('frontloginregisters')->create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'mobile'=>$row['mobile'],
                    'created_at'=>$row['created_at'],
                    
                ]);
            }
        }
    }
}