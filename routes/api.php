<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\Homecleaningapicontroller;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\BookingApiController;
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
    Route::get('/homeapi', [ServiceController::class, 'homeapi']);
    Route::get('/address-list', [ServiceController::class, 'address_list']);
    Route::get('/home-cleanig-api', [Homecleaningapicontroller::class, 'home_cleaning_api']);
    Route::get('/home-cleaning-config', [Homecleaningapicontroller::class, 'home_cleaning_config']);
    Route::get('/profile', [ProfileController::class, 'profile']);

    Route::put('/edit-address/{id}', [ServiceController::class, 'edit_address']);
    Route::delete('/delete-address/{id}', [ServiceController::class, 'delete_address']);



    Route::post('/subservice', [ServiceController::class, 'subservice']);
    Route::post('/add-address', [ServiceController::class, 'add_address']);
    Route::post('/get-addons', [Homecleaningapicontroller::class, 'get_addons']);
    Route::post('/cleaner-availability-check', [Homecleaningapicontroller::class, 'cleaner_availability_check']);
    Route::post('/profile/update', [ProfileController::class, 'updateProfile']);
    Route::post('/cancelpolicy', [Homecleaningapicontroller::class, 'cancelpolicy']);
    Route::post('/my-bookings', [BookingApiController::class, 'myBookings']);
    Route::post('/booking-details', [BookingApiController::class, 'bookingDetails']);
});
