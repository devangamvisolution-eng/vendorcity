<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use DB;

class Ckeditoruploadcontroller extends Controller
{
    //
    public function upload(Request $request)
{
    if ($request->hasFile('upload')) {
        $file     = $request->file('upload');
        $filename = time().'_'.$file->getClientOriginalName();
        
        // Save to public/upload/ckeditor
        $file->move(public_path('upload/ckeditor'), $filename);

        $url = asset('upload/ckeditor/'.$filename);

        return response()->json([
            'url' => $url
        ]);
    }

    return response()->json(['error' => 'No file uploaded.'], 400);
}

    
}
