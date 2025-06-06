<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Auth\PasswordAuthController;
use App\Http\Controllers\Api\V1\Auth\OtpAuthController;
use App\Http\Controllers\Api\V1\Auth\SocialAuthController;
use Auth;
use Socialite;


class AuthCenterController extends Controller
{
    public function signUp(Request $request,$provider='')
    {
        switch ($provider) 
        {
            case "otp":
                if (env('AUTH_PHONE_SUPPORT')) 
                {
                    $OtpAuth=new OtpAuthController;
                    $provider_response=$OtpAuth->signUp($request);
                    break;
                }
                else
                {
                    return response()->json([
                        'result' => false,
                        'message' => 'OTP login is unavailable'
                    ], 201);
                }
            default:
                $PasswordAuth=new PasswordAuthController;
                $provider_response=$PasswordAuth->signUp($request);
        }

        return $provider_response;
    }



    public function signIn(Request $request,$provider='')
    {

        switch ($provider) 
        {
            case "otp":
                if (env('AUTH_PHONE_SUPPORT')) 
                {
                    $OtpAuth=new OtpAuthController;
                    $provider_response=$OtpAuth->signIn($request);
                    break;
                }
                else
                {
                    return response()->json([
                        'result' => false,
                        'message' => 'OTP login is unavailable'
                    ], 201);
                }
            case "facebook":
                break;
            case "google":
                {
                    $SocialAuth=new SocialAuthController;
                    $provider_response=$SocialAuth->signIn($request->provider);
                    break;
                }
            default:
                $PasswordAuth=new PasswordAuthController;
                $provider_response=$PasswordAuth->signIn($request);
        }

        return $provider_response;
    }

    public function signout(Request $request)
    {
        $request->user()->tokens()->delete();
        return apiResponse($result=true,$message="Logged Out Successfully",$data=null,$code=200);
    }



}
