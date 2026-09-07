<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class ApiTokenMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {

            return response()->json([
                'status' => false,
                'message' => 'Token Missing'
            ], 401);
        }

        $user = DB::table('frontloginregister')
            ->where('api_token', $token)
            ->first();

        if (!$user) {

            return response()->json([
                'status' => false,
                'message' => 'Invalid Token'
            ], 401);
        }

        if (strtotime($user->token_expiry) < time()) {

            return response()->json([
                'status' => false,
                'message' => 'Token Expired'
            ], 401);
        }

        $request->user = $user;

        return $next($request);
    }
}
