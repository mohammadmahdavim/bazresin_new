<?php

namespace App\Http\Controllers\Api\v1\auth;

use App\ActivationCode;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use App\lib\Kavenegar;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate data
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'errors' => 'نام کاربری معتبر نیست',
                ],
                'status' => 'error'
            ]);
        }

        // End validate

        if (Auth::attempt($request->only('username', 'password'))) {
            return new LoginResource([
                'data' => [
                    'api_token' => Auth::user()->generateToken()
                ],
                'status' => 'success'

            ]);
        }

        return response([
            'data' => [
                'errors' => 'نام کاربری و یا رمز عبور شما صحیح نیست',
                'code' => '401',
                'status' => 'error'
            ]
        ], 401);
    }

    public function registerStep1(Request $request)
    {
        // Validate data

        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'iran_mobile', 'unique:users', 'is_not_persian'],
            'account_type' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'errors' => $validator->errors(),
                ],
                'status' => 'error'
            ]);
        }

        // End validate


        // Send sms for verify
        $code = rand(1000, 9999);
        ActivationCode::create([
            'mobile' => $request->mobile,
            'code' => $code,
            'status' => 0,
            'expire' => Carbon::now()->addMinutes(10)
        ]);

        Kavenegar::sendSMS($request->mobile, $code, 'RegisterMunicipality');
        // End

        return response([
            'data' => [
                'account_type' => $request->account_type,
                'mobile' => $request->mobile
            ]
        ], 200);

    }

    public function registerStep2(Request $request)
    {
        // Validate data
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'iran_mobile', 'unique:users', 'is_not_persian'],
            'code' => ['required'],
            'account_type' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'errors' => $validator->errors(),
                ],
                'status' => 'error'
            ]);
        }

        // End validate


        // Check verify for mobile
        $verify = ActivationCode::where('mobile', $request->mobile)
            ->where('code', $request->code)
            ->where('status', 0)
            ->where('expire', '>', Carbon::now())
            ->first();

        if ($verify != null) {
            $verify->update([
                'status' => 1
            ]);

            return response([
                'data' => [
                    'mobile' => $request->mobile,
                    'message' => 'validated',
                    'account_type' => $request->account_type
                ]
            ], 200);
        }
        // End

        return response([
            'data' => [
                'message' => 'کد وارد شده صحیح نیست',
            ]
        ], 401);
    }

    public function registerStep3(Request $request)
    {


        // Validate data
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'iran_mobile', 'unique:users', 'is_not_persian'],
            'password' => ['required', 'string', 'min:6', 'is_not_persian', 'confirmed'],
            'username' => ['required', 'min:8', 'is_not_persian', 'unique:users'],
            'national_code' => ['required'],
            'account_type' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'errors' => $validator->errors(),
                ],
                'status' => 'error'
            ]);
        }

        // for check melli-code user real account
        if ($request->account_type == 'real') {
            $this->validate($request, [
                'national_code' => ['melli_code'],
            ]);
        }
        // End

        // End validate

        // Check ok verify
        $activ = ActivationCode::where('mobile', $request->mobile)
            ->where('status', 1)
            ->orderby('id', 'desc')
            ->first();
        if ($activ == null) {
            return response([
                'data' => [
                    'message' => 'این شماره تایید نشده است',
                ]
            ], 401);
        }
        // End

        // Create User
        $user = User::create([
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'username' => $request->username,
            'account_type' => $request->account_type,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'sex' => $request->sex,
            'email' => $request->email,
            'national_code' => $request->national_code,
            'api_token' => str_random(50),
            'avatar' => 'avatar.png',
            'level' => 'user',
        ]);
        // End

        return new UserResource($user);

    }

    public function checkToken($request)
    {
        $token = $request->api_token;
        $user = User::where('api_token', $token)->first();
        if ($user != null) {
            return response([
                'data' => 'توکن معتبر می باشد',
                'status' => 'success'
            ],200);
        } else {
            return response([
                'data' => 'توکن معتبر نیست',
                'status' => 'error'
            ],401);
        }
    }

}
