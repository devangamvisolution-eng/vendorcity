<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckVendor
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
        if (auth()->check() && auth()->user()->vendor == 1) {
            $vendor = auth()->user();
            if ($vendor->is_active == 1 && $vendor->suspension_reason === 'document_expired') {
                // Check if the current route is NOT the suspended route and NOT the update documents route
                if (!$request->routeIs('vendor.suspended') && !$request->routeIs('vendor.document.update') && !$request->routeIs('vendor.document.update.submit') && !$request->routeIs('vendor.document.update.thankyou') && !$request->routeIs('vendor.logout') && !$request->is('vendor/update-documents*')) {
                    return redirect()->route('vendor.suspended');
                }
            }
        }

        return $next($request);
    }
}
