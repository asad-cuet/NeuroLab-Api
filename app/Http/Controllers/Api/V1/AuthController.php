<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Socialite;

class AuthController extends Controller
{


    public function sendSignupOTP(Request $request)
    {
        if (User::where('phone', $request->phone)->exists()) {
            return response()->json([
                'result' => false,
                'message' => 'Phone already exists.'
            ], 201);
        }

        $otp = rand(9999, 9999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->phone, 'type' => 'signup',],
            ['token' => $otp,  'created_at' => Carbon::now()]
        );

        $text = "Your Verification Code for ".config('app.name')." is: " . $otp;

        $sms_status =true; //sendSMS($request->phone, $text);

        $data = [
            'result' => true,
            'phone' => $request->phone,
            'message' => "We have sent OTP to your phone."
        ];
        return response()->json($data);
    }


    /*
    payload:  otp_signup(1|0), name, email, phone, otp_code (if otp_signup=1)
    */
    public function signup(Request $request)
    {

        $this->validate($request, [
            'email'   => 'email',
            'phone'   => 'numeric',
            'password' => 'required|min:6'
        ]);

        if ($request->phone=='' && $request->email=='') 
        {
            return response()->json([
                'result' => false,
                'message' => translate("Both Email and Phone can't be null")
            ], 201);
        }

        if ($request->phone && $request->otp_signup=='') 
        {
            return response()->json([
                'result' => false,
                'message' => "Send also otp_signup with phone in the payload"
            ], 201);
        }


        if ($request->otp_signup!='' && $request->phone!='') 
        {
            if (User::where('phone', $request->phone)->exists()) {
                return response()->json([
                    'result' => false,
                    'message' => 'Phone already exists.'
                ], 201);
            }

            $check_otp_sql = DB::table('password_reset_tokens')
            ->where(['email' => $request->phone, 'token' => $request->otp_code, 'type' => 'signup']);
            $check_otp = $check_otp_sql->first();

            if (!$check_otp) {
                return response()->json([
                    'result' => false,
                    'message' => 'Invalid OTP!'
                ], 201);
            }

            if ($request->password != '') {

                $user = new User([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password)
                ]);

                $user->save();
            } 
            else 
            {
                $user = new User([
                    'name' => $request->name,
                    'phone' => $request->phone
                ]);
                $user->save();
            }
        } 
        else
        {
            if (User::where('email', $request->email)->exists()) 
            {
                return response()->json([
                    'result' => false,
                    'message' => 'Email already exists.'
                ], 201);
            }
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $user->save();
        }


        if($user!='')
        {
            if($user->email!='')
            {
                $email=$user->email;
                $email_data=[];
                $email_data['subject']='Registration Complete';
                $email_data['body']="Thanks ".$user->name." for signing up in ".config('app.name');
                sendEmail($email,$email_data);
            }
            if(Auth::loginUsingId($user->id)) 
            {
                $token = $user->createToken('authToken')->plainTextToken;
    
                return response()->json([
                    'result' => true,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => auth()->user(),
                    'message' => 'Registration Successful.',
                    'user_id' => $user->id
                ], 201);
            } 
            else
            {
                return response()->json([
                    'result' => false,
                    'message' => 'Sign up Failed.'
                ], 201);
            }
        }
        else 
        {
            return response()->json([
                'result' => false,
                'message' => 'User not Found'
            ], 201);
        }
    }



    public function sendLoginOTP(Request $request)
    {
        if (User::where('phone', $request->phone)->exists()) {
            $otp = rand(9999, 9999);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->phone, 'type' => 'login',],
                ['token' => $otp,  'created_at' => Carbon::now()]
            );

            $text = "Your Verification Code for ".config('app.name')." is: " . $otp;

            $sms_status =true; //sendSMS($request->phone, $text);


            $data = [
                'result' => true,
                'phone' => $request->phone,
                'message' => "We have sent OTP to your phone."
            ];
            return response()->json($data);
        } else {
            $data = [
                'result' => false,
                'phone' => $request->phone,
                'message' => "Account not found with this phone.Please signup first."
            ];
            return response()->json($data);
        }
    }


    /*
    payload:  otp_login(1|0), name, email_or_phone, password,  otp_code(if otp_ogin)
    */

    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="Authenticate user and generate JWT token",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Login successful"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function login(Request $request)
    {
        $user = User::where('email', $request->email_or_phone)->orWhere('phone', $request->email_or_phone)->first();

        if($user=='')
        {
            return response()->json(['result' => false, 'message' => translate('User not found'), 'user' => null], 401);
        }



        if ($request->otp_login!='') 
        {
            $check_otp_sql = DB::table('password_reset_tokens')
            ->where('email', $request->phone)
            ->where('token',$request->otp_code)
            ->where('type','login')
            ->orderBy('id','desc');  //took the last otp
            $check_otp = $check_otp_sql->first();

            if (!$check_otp) {
                return response()->json([
                    'result' => false,
                    'message' => 'Invalid OTP!'
                ], 201);
            }
            else
            {
                return $this->loginSuccess($user);
            }
        }
        else
        {
            if($request->password!='')
            {
                if (Hash::check($request->password, $user->password)) {
                    return $this->loginSuccess($user);
                } 
                else 
                {
                    return response()->json(['result' => false, 'message' => 'Unauthorized', 'user' => null], 401);
                }
            }
            else
            {
                return response()->json(['result' => false, 'message' => 'Password can not be null without otp login', 'user' => null], 401);
            }

        } 





        
    }


    public function socialLogin(Request $request)
    {
        if (!$request->provider_id) {
            return response()->json([
                'result' => false,
                'message' => translate('User not found'),
                'user' => null
            ]);
        }

        switch ($request->provider) 
        {
            case 'facebook':
                $social_user = Socialite::driver('facebook')->user();
                break;
            case 'google':
                $social_user = Socialite::driver('google')->user();
            case 'github':
                $social_user = Socialite::driver('github')->user();
                break;
            default:
                $social_user = null;
        }



        if ($social_user == null) {
            return response()->json(['result' => false, 'message' => translate('No social provider matches'), 'user' => null]);
        }

        $social_user_details = $social_user->userFromToken($request->access_token);

        if ($social_user_details == null) {
            return response()->json(['result' => false, 'message' => translate('No social account matches'), 'user' => null]);
        }


        $existingUser = User::where('provider_id', $request->provider_id)->first();

        if ($existingUser) 
        {
            return $this->loginSuccess($existingUser);
        } 
        else 
        {
            $user = new User([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'provider_id' => $user->getId(),
                'provider' => $request->provider,
                'email_verified_at' => Carbon::now()
            ]);
            $user->save();
            return $this->loginSuccess($user);
        }
        
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'result' => true,
            'message' => translate('Successfully logged out')
        ]);
    }



    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
