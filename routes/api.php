<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\Homecleaningapicontroller;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\MyAccountApiController;
use App\Http\Controllers\Api\HomeControllerApi;
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

Route::post('/contact-us', [HomeControllerApi::class, 'contactUsStore']);
Route::get('/faqs', [HomeControllerApi::class, 'getFaqs']);
Route::middleware('auth:api')->group(function () {

    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/homeapi', [ServiceController::class, 'homeapi']);
    Route::get('/address-list', [ServiceController::class, 'address_list']);
    Route::get('/home-cleanig-api', [Homecleaningapicontroller::class, 'home_cleaning_api']);
    Route::get('/home-cleaning-config', [Homecleaningapicontroller::class, 'home_cleaning_config']);
    Route::post('/packages', [Homecleaningapicontroller::class, 'packages']);
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
    Route::post('/payment-intent', [BookingApiController::class, 'paymentIntent']);
    Route::post('/home-cleaning-checkout', [Homecleaningapicontroller::class, 'store_checkout']);
    Route::post('/package-cleaning-checkout', [Homecleaningapicontroller::class, 'package_checkout']);

    Route::get('/home-subservice', [ServiceController::class, 'homesubservice']);
    Route::post('/wallet-amount-check', [MyAccountApiController::class, 'walletAmountCheck']);
    Route::post('/rating-order', [MyAccountApiController::class, 'ratingOrder']);
    Route::post('/wallet-transactions', [MyAccountApiController::class, 'walletTransactions']);
    Route::post('/moving-service', [HomeControllerApi::class, 'movingService']);
    Route::post('/search-service', [HomeControllerApi::class, 'searchSubservice']);
    Route::post('/store-moving-service', [HomeControllerApi::class, 'storeMovingServiceInquiry']);

    Route::post('/my-quotes', [MyAccountApiController::class, 'myQuotes']);
    Route::post('/my-quote-detail', [MyAccountApiController::class, 'myQuoteDetail']);
});
