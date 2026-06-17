<?php



namespace App\Http\Controllers\admin;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Session;



class HomeController extends Controller

{

    public function index()

    {   

        return view('admin.dashboard');

    }



    public function logout()

    {

        Session::flush();

        Auth::logout();

        $request->session()->invalidate();
    $request->session()->regenerateToken();

        return redirect('login');

    }
     public function redirectToDashboard(){
        // echo "<pre>";print_r(Auth::user());echo"</pre>";exit;
        if (Auth::check()) {
            if (Auth::user()->vendor == 1) {

                //echo "HomeController";exit;
                return redirect()->route('vendor.dashboard');
            } else {
                return redirect()->route('admin.dashboard');
            }
        }
    }

}