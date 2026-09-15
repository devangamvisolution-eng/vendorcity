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
                                // ->whereIn('role_id', [16, 15, 8])
                                ->first();

            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => 'You are not authorized as a vendor.',
                ]);
            }

            if ($user->is_active == 1) {
                throw ValidationException::withMessages([
                    'email' => 'This vendor is not active.',
                ]);
            }

            // Check if the password is correct
            if (!Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => 'Invalid credentials.',
                ]);
            }

            // Check for expiration
            if ($user->contract_status == 'approved' && $user->contract_end_date && strtotime($user->contract_end_date) < time()) {
                // Mark as expired
                $user->contract_status = 'expired';
                $user->save();
                
                // Update latest contract in vendor_contracts table
                $latestContract = \Illuminate\Support\Facades\DB::table('vendor_contracts')->where('vendor_id', $user->id)->orderBy('id', 'DESC')->first();
                if ($latestContract) {
                    \Illuminate\Support\Facades\DB::table('vendor_contracts')->where('id', $latestContract->id)->update([
                        'status' => 'expired',
                        'updated_at' => now()
                    ]);
                }
            }

            if ($user->contract_status == 'expired') {
                throw ValidationException::withMessages([
                    'email' => 'Your contract has expired. Please contact the administrator to renew your contract.',
                ]);
            }

            if ($user->contract_status && $user->contract_status !== 'approved') {
                throw ValidationException::withMessages([
                    'email' => 'Your account is pending contract approval. Please check your email for the contract upload link or await admin review.',
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
