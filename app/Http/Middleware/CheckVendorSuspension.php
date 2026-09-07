<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckVendorSuspension
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $vendor = auth()->user();
        
        if ($vendor && $vendor->is_active == 0 && $vendor->suspension_reason === 'document_expired') {
            // Check if the current route is NOT the update documents route
            if (!$request->routeIs('vendor.document.update') && !$request->routeIs('vendor.document.update.submit') && !$request->routeIs('vendor.document.update.thankyou') && !$request->routeIs('vendor.logout')) {
                return redirect()->route('vendor.document.update');
            }
        }

        return $next($request);
    }
}
