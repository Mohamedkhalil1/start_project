<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Auth;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    public function __construct()
    {
        // We set the guard api as default driver
        auth()->setDefaultDriver('admin-api');
    }
    public function login(Request $request){
        try {
            $rules = [
                "password" => "required",
                "email" => "required|exists:admins,email"
            ];

            $messages=[
                'email.required' => __('messages.email'),
                'password.required' => __('messages.password'),
                'email.exists' => __('messages.email_exist'),
                "email.email" => __('messages.email_invalid'),
            ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            //login
            $credentials = $request->only('email', 'password');
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->errorResponse('0111','invalid_credentials',400);
            }
            //return token
            return response()->json([
                'token' => $token,
                'admin' => auth()->user()
            ]);
       
        }catch (\Exception $ex){
            return $this->errorResponse($ex->getCode(), $ex->getMessage(),404);
        }

    }
}
