<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Illuminate\View\View;


class VendorAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.vendorslogin');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

         // Check if the user exists and is a vendor
        $user = \App\Models\User::where('email', $request->email)
                                ->whereIn('role_id', [16, 15, 8])
                                ->first();


            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => 'You are not authorized as a vendor.',
                ]);
            }

            // Attempt login with vendor flag check
            if (Auth::attempt($credentials, $request->remember)) {
                return redirect()->route('vendor.dashboard');
            }

            throw ValidationException::withMessages([
                'email' => 'Invalid credentials.',
            ]);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('vendor.login');
    }
}
