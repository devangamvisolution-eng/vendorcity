<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post(
    '/v1/auth/send-otp',
    [AuthController::class, 'sendOtp']
);

Route::post(
    '/v1/auth/verify-otp',
    [AuthController::class, 'verifyOtp']
);

Route::middleware('auth:api')->group(function () {

    Route::get('/services', [ServiceController::class, 'index']);
});
