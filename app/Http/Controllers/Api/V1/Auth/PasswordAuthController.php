<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PasswordAuthController extends Controller
{
    public function signUp(Request $request)
    {

        $validation_rules=[
            'name' => 'nullable|string',
            
            'email' => 'required||unique:users,email',

            'password' => 'required|min:8',

        ];

        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            $firstValue = reset($error_arr)[0];
            return apiResponse($result=false,$message=$firstValue,$data=$error_arr,$code=200);
        }

        if (User::where('email', $request->email)->exists()) 
        {
            return apiResponse($result=false,$message="User is already Exist",$data=null);
        }


        $user = new User;
        $user->name = $request->name?? 'Guest';
        $user->signup_by = 'email';
        $user->notify_by = 'email';
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();


        return loginUsingUser($user,'Registration Successful');

    }


    public function signIn(Request $request)
    {

        $validation_rules=[      
            'email' => 'required|string',

            'password' => 'required|string',

        ];

        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            $firstValue = reset($error_arr)[0];
            return apiResponse($result=false,$message=$firstValue,$data=$error_arr,$code=200);
        }


        $user = User::where('email',$request->email)->first();

        if($user!='')
        {
            if(!in_array($user->signup_by,['email','both']))
            {
                return apiResponse(false,"Can't login to this account by email");

            }
        }


        if (!Auth::attempt($request->only('email', 'password'))) 
        {
            return apiResponse($result=false,$message="Invalid Email or Password",$data=null,$code=401);

        }


        $user = User::where('email', $request->email)->firstOrFail();

        return loginUsingUser($user,"Logged In Successfully");
    }



}
