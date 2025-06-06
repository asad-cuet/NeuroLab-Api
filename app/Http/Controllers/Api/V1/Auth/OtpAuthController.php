<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class OtpAuthController extends Controller
{
    public function signUp(Request $request)
    {

        $fixed_country_code=env('FIXED_COUNTRY_CODE');
        $validation_rules=[
            'name' => 'required|string',

            'country_code' => $fixed_country_code!=''? 'nullable':'required',

            'phone' => [
                'required',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('country_code', $fixed_country_code?? request('country_code'));
                }),
            ],

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
            'type' => 'signup'
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

        $user = new User;
        $user->name = $request->name;
        $user->country_code = $country_code;
        $user->signup_by = 'phone';
        $user->notify_by = 'phone';
        $user->phone = $request->phone;
        $user->password = '';
        $user->save();
        
  
        return loginUsingUser($user,'Registration Successful');
    }


    public function signIn(Request $request)
    {
        $fixed_country_code=env('FIXED_COUNTRY_CODE');
        $validation_rules=[
            'country_code' => $fixed_country_code!=''? 'nullable':'required',

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

        $token = $user->createToken('authToken')->plainTextToken;

        return loginUsingUser($user,"Logged In Successfully");
    }

    public function sendSignUpOtp(Request $request)
    {
        $fixed_country_code=env('FIXED_COUNTRY_CODE');
        $validation_rules=[
            'country_code' => $fixed_country_code!=''? 'nullable':'required',
            'phone' => [
                'required',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('country_code', env('FIXED_COUNTRY_CODE')?? request('country_code'));
                }),
            ],
        ];

        
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            return apiResponse(false,"Validation Error",['errors'=>$error_arr],400);
        }

        $country_code=$fixed_country_code?? $request->country_code;

        $otp = rand(9999, 9999);

        DB::table('phone_otps')
            ->where('country_code',$country_code)
            ->where('phone',$request->phone)
            ->where('type','signup')
            ->delete();

        DB::table('phone_otps')->insert([
                    'country_code' => $country_code, 
                    'phone' => $request->phone, 
                    'otp' => $otp, 
                    'type' => 'signup'
                ]);


        //SEND_OTP_HERE
        $text = "Your Otp for ".env('APP_NAME')." is: " . $otp;
        $sms_status = sendSSLSMS($request->phone, $text);

        if($sms_status?->status=='SUCCESS')
        {
            $message = "We have sent OTP to your phone";
        }
        else
        {
            $message =isset($sms_status->error_message)? $sms_status->error_message: "OTP sending failed";
        }

        return apiResponse($result=true,$message=$message,$data=null,$code=200);

    }

    public function sendSignInOtp(Request $request)  //for web, app
    {
        $fixed_country_code=env('FIXED_COUNTRY_CODE');

        $validation_rules=[
            'country_code' => $fixed_country_code!=''? 'nullable':'required',

            'phone' => 'required|string',
        ];

        
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            return apiResponse(false,"Validation Error",['errors'=>$error_arr],400);
        }

        $country_code=$fixed_country_code?? $request->country_code;

        //as user can login without signup before by otp in web
        $user=User::where('country_code',$country_code)->where('phone',$request->phone)->first();
        if($user!='')
        {
            if(!in_array($user->signup_by,['phone','both']))
            {
                return apiResponse(false,"Can't login to this account by phone");
            }
        }
        else
        {
            return apiResponse(false,"This phone didn't registered",null,201);
        }

        $otp = rand(9999, 9999);

        DB::table('phone_otps')
            ->where('country_code',$country_code)
            ->where('phone',$request->phone)
            ->where('type','signin')
            ->delete();

        DB::table('phone_otps')->insert([
            'country_code' => $country_code, 
            'phone' => $request->phone, 
            'otp' => $otp, 
            'type' => 'signin'
        ]);


        //SEND_OTP_HERE
        $text = "Your Otp for ".env('APP_NAME')." is: " . $otp;
        $sms_status = sendSSLSMS($request->phone, $text);

        if($sms_status?->status=='SUCCESS')
        {
            $message = "We have sent OTP to your phone";
        }
        else
        {
            $message =isset($sms_status->error_message)? $sms_status->error_message: "OTP sending failed";
        }

        return apiResponse($result=true,$message=$message,$data=null,$code=200);

    }

    public function sendResetOtp(Request $request)
    {
        $fixed_country_code=env('FIXED_COUNTRY_CODE');
        $validation_rules=[
            'country_code' => $fixed_country_code!=''? 'nullable':'required',
            'phone' => 'required|string',
        ];
        
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            return apiResponse(false,"Validation Error",['errors'=>$error_arr],400);
        }

        $country_code=$fixed_country_code?? $request->country_code;

        $user = User::where('country_code',$country_code)->where('phone', $request->phone)->first();


        if(!$user)
        {
            return apiResponse($result=false,$message="Invalid Phone",$data=null,$code=200);
        }

        $otp = rand(9999, 9999);

        DB::table('phone_otps')
            ->where('country_code',$country_code)
            ->where('phone',$request->phone)
            ->where('type','reset')
            ->delete();

        DB::table('phone_otps')->insert([
            'country_code' => $country_code, 
            'phone' => $request->phone, 
            'otp' => $otp, 
            'type' => 'reset'
        ]);

        //SEND_OTP_HERE
        $text = "Your Reset Otp for ".env('APP_NAME')." is: " . $otp;
        $sms_status = sendSSLSMS($request->phone, $text);

        if($sms_status?->status=='SUCCESS')
        {
            $message = "We have sent OTP to your phone";
        }
        else
        {
            $message =isset($sms_status->error_message)? $sms_status->error_message: "OTP sending failed";
        }

        return apiResponse($result=true,$message="OTP Sent",$data=null,$code=200);

    }

    public function verifyResetOtp(Request $request)
    {

        $fixed_country_code=env('FIXED_COUNTRY_CODE');

        $validation_rules=[
            'country_code' => $fixed_country_code!=''? 'nullable':'required',

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


        $check_otp_query = DB::table('phone_otps')
        ->where([
            'country_code'=>$country_code,
            'phone' => $request->phone, 
            'otp' => $request->otp, 
            'type' => 'reset'
        ]);

        $check_otp =$check_otp_query->first();
        
        if ($check_otp!='') 
        {
            $check_otp_query->delete();

            $token=uniqid();

            DB::table('phone_otps')
                ->where('country_code',$country_code)
                ->where('phone',$request->phone)
                ->where('type','reset_token')
                ->delete();

            DB::table('phone_otps')->insert([
                'country_code'=>$country_code,
                'phone' => $request->phone, 
                'otp' => $token, 
                'type' => 'reset_token'
            ]);

        }
        else
        {
            return apiResponse($result=false,$message="Invalid OTP",$data=null,$code=201);
        }

        return apiResponse($result=true,$message="OTP Validated",$data=['token'=>$token],$code=200);

    }

    public function resetPassword(Request $request)
    {

        $fixed_country_code=env('FIXED_COUNTRY_CODE');

        $validation_rules=[
            'country_code' => $fixed_country_code!=''? 'nullable':'required',

            'phone' => 'required|string',

            'token' => 'required|string',

            'password' => 'required|min:8',

            'confirm_password' => 'required|min:8|same:password'

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
            'otp' => $request->token, 
            'type' => 'reset_token'
        ]);

        $check_otp =$check_otp_query->first();
        
        if ($check_otp!='') 
        {
            $check_otp_query->delete();
        }
        else
        {
            return apiResponse($result=false,$message="Invalid Data",$data=null,$code=201);
        }

        $user = User::where('country_code',$country_code)->where('phone', $request->phone)->first();


        if($user!='')
        {
            $user->password=Hash::make($request->password);
            $user->save();

            return loginUsingUser($user,"Password Updated");

        }
        else
        {
            return apiResponse($result=false,$message="Invalid Phone",$data=null,$code=201);
        }

    }
}
