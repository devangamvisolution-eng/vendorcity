<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FrontLoginRegister;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class MyAccountApiController extends Controller
{
    public function walletAmountCheck(Request $request)
    {
        try {

            $authUser = JWTAuth::parseToken()->authenticate();

            $userId = $request->userId;

            $user = FrontLoginRegister::find($userId);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                    'data' => []
                ], 404);
            }

            $wallet_plus_amount = DB::table('front_user_wallet')
                ->where('refer_id', $user->id)
                ->where('added_from', 0)
                ->sum('wallet_amount');

            $wallet_minus_amount = DB::table('front_user_wallet')
                ->where('refer_id', $user->id)
                ->where('added_from', 1)
                ->sum('wallet_amount');

            $plusAmountWallet = $wallet_plus_amount ?? 0;
            $minusAmountWallet = $wallet_minus_amount ?? 0;

            $totalAmountWallet = max($plusAmountWallet - $minusAmountWallet, 0);

            $userWalletAmount = $totalAmountWallet;
            $requestAmount = $request->amount ?? 0;

            if ($requestAmount > $userWalletAmount) {

                return response()->json([
                    'status' => false,
                    'message' => 'Insufficient wallet balance.',
                    'data' => [
                        'current_wallet_amount' => $userWalletAmount,
                    ]
                ], 400);
            }

            return response()->json([
                'status' => true,
                'message' => 'Sufficient wallet balance.',
                'data' => [
                    'current_wallet_amount' => $userWalletAmount,
                ]
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function ratingOrder(Request $request)
    {
        try {

            $authUser = JWTAuth::parseToken()->authenticate();

            $validator = Validator::make($request->all(), [
                'order_id'       => 'required',
                'rating'         => 'required|integer|min:1|max:5',
                'comments'       => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => []
                ], 422);
            }

            $order_data = DB::table('ci_order_item')->where('order_id', $request->order_id)->first();

            if (!$order_data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Order not found.',
                    'data' => []
                ], 404);
            }
            // Check if user already reviewed this service/order
            $alreadyReviewed = DB::table('ci_service_review')
                ->where('user_id', $request->userId)
                ->where('order_id', $request->order_id)
                ->exists();

            if ($alreadyReviewed) {
                return response()->json([
                    'status' => false,
                    'message' => 'Review already given.',
                    'data' => []
                ], 409);
            }

            $reviewId = DB::table('ci_service_review')->insertGetId([
                'order_id'        => $request->order_id,
                'user_id'        => $request->userId,
                'service_id'     => $order_data->service_id,
                'subservice_id' => $order_data->subservice_id,
                'rating'         => $request->rating,
                'comments'       => $request->comments,
                'created_at'     => now(),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Review submitted successfully.',
                'data' => [
                    'id' => $reviewId
                ]
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
}
