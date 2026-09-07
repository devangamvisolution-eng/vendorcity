<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use DB;

class AcceptLeadscontroller extends Controller
{
    //
    public function index()

    {

       $data['all_data'] = DB::table('leads')
                            ->where('accept_reject','1')
                            ->orderBy('id', 'desc') // Order by the 'id' column in descending order
                            ->get();

        //echo"<pre>";print_r($data);echo"</pre>";exit;       

       return view('admin.list_accept_leads',$data);

    }

    
}
