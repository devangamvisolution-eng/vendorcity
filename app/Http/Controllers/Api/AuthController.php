<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FrontLoginRegister;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Send OTP
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'country_code' => 'required'
        ]);

        $mobile = $request->mobile;
        $country_code = $request->country_code;

        $otp = rand(1000, 9999);

        DB::table('otp_verifications')->updateOrInsert(
            [
                'mobile' => $mobile,
                'country_code' => $country_code,
            ],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(5),
                'updated_at' => now(),
                'created_at' => now()
            ]
        );

        // $apiResponse = $this->booknow_otp_sent($mobile, $country_code, $otp);

        // if (!$apiResponse['success']) {

        //     return response()->json([
        //         'status' => false,
        //         'message' => $apiResponse['message'] ?? 'OTP sending failed',
        //         'error' => $apiResponse['response'] ?? null
        //     ], 400);
        // }

        return response()->json([
            'status' => true,
            'message' => 'OTP Sent Successfully',
            'otp' => $otp // remove in production
        ]);
    }

    function booknow_otp_sent($mobile, $country_code, $otp)
    {

        $phone = $country_code . $mobile;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://public.doubletick.io/whatsapp/message/template',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                "messages" => [
                    [
                        "content" => [
                            "language" => "en",
                            "templateData" => [
                                "body" => [
                                    "placeholders" => [
                                        (string)$otp
                                    ]
                                ]
                            ],
                            "templateName" => "login_otp_vc2"
                        ],
                        "from" => "+971503204846",
                        "to" => $phone
                    ]
                ]
            ]),
            CURLOPT_HTTPHEADER => array(
                'Authorization: key_uTZeOXQPMd',
                'accept: application/json',
                'content-type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            return [
                'success' => false,
                'message' => curl_error($curl)
            ];
        }

        curl_close($curl);

        $response = json_decode($response, true);

        if (
            isset($response['messages'][0]['status']) &&
            in_array($response['messages'][0]['status'], ['SENT', 'DELIVERED', 'ENQUEUED'])
        ) {
            return [
                'success' => true,
                'response' => $response
            ];
        }

        return [
            'success' => false,
            'response' => $response,
            'message' => $response['message'][0] ?? 'Failed to send OTP'
        ];
    }

    /**
     * Verify OTP & Login
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'otp' => 'required'
        ]);

        $otpData = DB::table('otp_verifications')
            ->where('mobile', $request->mobile)
            ->where('otp', $request->otp)
            ->first();

        if (!$otpData) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP'
            ], 401);
        }

        if (strtotime($otpData->expires_at) < time()) {
            return response()->json([
                'status' => false,
                'message' => 'OTP Expired'
            ], 401);
        }

        $user = FrontLoginRegister::where(
            'mobile',
            $request->mobile
        )->first();

        if (!$user) {

            $userId = DB::table('frontloginregisters')
                ->insertGetId([
                    'mobile' => $request->mobile,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

            $user = FrontLoginRegister::find($userId);
        } else {

            $userId = $user->id;
        }

        try {

            $token = JWTAuth::fromUser($user);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'JWT Error',
                'error' => $e->getMessage()
            ], 500);
        }

        DB::table('frontloginregisters')
            ->where('id', $userId)
            ->update([
                'api_token' => $token,
                'token_expiry' => now()->addDays(30),
                'updated_at' => now()
            ]);

        DB::table('otp_verifications')
            ->where('mobile', $request->mobile)
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Login Successful',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'customer_id' => $user->customer_id,
                'name' => $user->name,
                'email' => $user->email,
                'country_code' => $user->country_code,
                'mobile' => $user->mobile,
                'area' => $user->area,
                'status' => $user->status,
                'token_expiry' => $user->token_expiry,
            ]
        ]);
    }

    /**
     * Profile
     */
    public function profile()
    {
        return response()->json([
            'status' => true,
            'user' => auth('api')->user()
        ]);
    }

    /**
     * Logout
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'status' => true,
            'message' => 'Logout Successful'
        ]);
    }
}
