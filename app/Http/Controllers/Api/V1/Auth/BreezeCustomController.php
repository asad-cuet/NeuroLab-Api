<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Auth;


class BreezeCustomController extends Controller
{

    public function signIn(Request $request)
    {


        $fixed_country_code=env('FIXED_COUNTRY_CODE');
        $validation_rules=[
            'country_code' => $fixed_country_code? 'nullable':'required',
            'phone' => 'required|string',
            'otp' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            return apiResponse(false,"Validation Error",['errors'=>$error_arr],400);
        }

        $country_code=$fixed_country_code?? $request->country_code;



        $check_otp_query = DB::table('phone_otps')->where([
            'country_code'=>$country_code,
            'phone' => $request->phone, 
            'otp' => $request->otp, 
            'type' => 'signin'
        ]);


        $check_otp =$check_otp_query->first();
        
        if ($check_otp!='') 
        {
            $check_otp_query->delete();
        }
        else
        {
            return apiResponse($result=false,$message="Invalid OTP",$data=null,$code=201);
        }

        $user = User::where('country_code',$country_code)->where('phone', $request->phone)->first();
        
        if(!$user)
        {
            return apiResponse(false,"This phone didn't registered",null,201);

        }

        Auth::login($user);

        $request->session()->regenerate();

        logOutFromOtherDevice();

        return apiResponse($result=true,$message="Login Successfull",$data=null,$code=201);

    }


    public function resetPassword(Request $request)
    {

        $validation_rules=[
            'email' => 'required|string',

            'token' => 'required|string',

            'password' => 'required|min:8',

            'confirm_password' => 'required|min:8|same:password'

        ];



        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            $firstValue = reset($error_arr)[0];
            return apiResponse($result=false,$message=$firstValue,$data=$error_arr,$code=200);
        }


        $check_otp_query = DB::table('password_reset_tokens')->where(['email' => $request->email, 'token' => $request->token, 'type' => 'reset_token']);
        $check_otp =$check_otp_query->first();
        
        if ($check_otp!='') 
        {
            $check_otp_query->delete();
        }
        else
        {
            return apiResponse($result=false,$message="Invalid Data",$data=null,$code=201);
        }

        $user = User::where('email', $request->email)->first();

        if($user!='')
        {
            $user->password=Hash::make($request->password);
            $user->save();

            Auth::login($user);

            $request->session()->regenerate();

            logOutFromOtherDevice();

            return apiResponse($result=true,$message="Password Updaed Successfully",$data=null);


        }
        else
        {
            return apiResponse($result=false,$message="Invalid Phone",$data=null,$code=201);
        }

    }


}
