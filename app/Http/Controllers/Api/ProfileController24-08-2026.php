<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FrontLoginRegister;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        try {

            $authUser = JWTAuth::parseToken()->authenticate();

            $user = FrontLoginRegister::find($authUser->id);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                    'data' => []
                ], 404);
            }

            $data = [
                'id'             => $user->id,
                'name'           => $user->name,
                'email'          => $user->email,
                'mobile'         => $user->mobile,
                'country_code'   => $user->country_code,
                'birthdate'      => $user->birthdate,
                'language'       => $user->language,
                'gender'         => $user->gender,
            ];

            return response()->json([
                'status' => true,
                'message' => 'Profile fetched successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [

                'name' => 'required|string|max:100',

                'birthdate' => 'nullable|date',

                'language' => 'nullable|string|max:20',

                'gender' => 'nullable|in:male,female,non_binary,prefer_not_to_say'

            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => []
                ], 422);
            }

            $user = JWTAuth::parseToken()->authenticate();

            $user->name = $request->name;
            $user->birthdate = $request->birthdate;
            $user->language = $request->language;
            $user->gender = $request->gender;

            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'country_code' => $user->country_code,
                    'birthdate' => $user->birthdate,
                    'language' => $user->language,
                    'gender' => $user->gender,
                ]
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
}
