<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\AppEmailVerificationNotification;

class PasswordResetController extends Controller
{

    // payloads: email_or_phone*, send_code_by*
    public function forgetRequest(Request $request)
    {

        if ($request->email_or_phone=='' || $request->send_code_by=='') {
            return response()->json([
                'result' => false,
                'message' => "Enough information didn't provided"], 404);
        }


        if (!User::where('email', $request->email_or_phone)->orWhere('phone',$request->email_or_phone)->exists()) {
            return response()->json([
                'result' => false,
                'message' => 'User is not found'], 404);
        }

        $user = User::where('email', $request->email_or_phone)->orWhere('phone',$request->email_or_phone)->first();



        $user->verification_code = rand(0, 999999);
        $user->save();

        if ($request->send_code_by == 'email') {
            // $user->notify(new AppEmailVerificationNotification());
            $email=$request->email_or_phone;
            $email_data=[];
            $email_data['subject']='Reset Password';
            $email_data['head']='Reset Password';
            $email_data['greeting']="Hello ".$user->name;
            $email_data['body']="## Your Email Verification Code for ".config('app.name')." is: " . $user->verification_code.". Don't share the code to anyone.";
            sendEmail($email,$email_data);
        } 


        if($request->send_code_by == 'phone')
        {
            if($user->phone!='')
            {
                $text = "Your OTP Code for ".config('app.name')." is: " . $user->verification_code;
                $sms_status =true; //sendSMS($request->phone, $text);

            }
            else
            {
                return response()->json([
                    'result' => false,
                    'message' => 'Provided phone number is not related to user'
                ], 200);
            }
        }


        return response()->json([
            'result' => true,
            'message' => 'A code is sent'
        ], 200);
    }


    public function confirmReset(Request $request)
    {
        $user = User::where('email', $request->email_or_phone)->orWhere('phone',$request->email_or_phone)->first();

        if ($user != null)
        {
            return response()->json([
                'result' => false,
                'message' => translate('No user is found'),
            ], 200);
        }


        if ($request->verification_code!='') 
        {
            if($user->verification_code==$request->verification_code)
            {
                $user->password = Hash::make($request->password);
            }
            else
            {
                return response()->json([
                    'result' => false,
                    'message' => translate('Invalid Verification Code!')
                ], 201);
            }
        }

        $user->verification_code='';
        $user->save();
        return response()->json([
            'result' => true,
            'message' => translate('Your password is reset.Please login'),
        ], 200);

    }

}
