<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\User;
use Auth;

class SocialAuthController extends Controller
{
    public function signInByRedirect($provider=null)
    {
        if(isNull($provider)) 
        {
            return apiResponse($result=false,$message="Provider is required",$data=null,$code=400);
        }

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        try 
        {
            if ($provider == 'twitter') 
            {
                $user = Socialite::driver('twitter')->user();
            } 
            else 
            {
                $user = Socialite::driver($provider)->stateless()->user();
            }
        } 
        catch (\Exception $e) 
        {
            flash("Something Went wrong. Please try again.")->error();
            return redirect(env('FRONTEND_URL', 'http://127.0.0.1:3000') . '/callback?result=false');
        }

        //check if provider_id exist
        // return $user->id;
        $user = User::where('provider_id', $user->id)->first();
        // return $existingUserByProviderId;

        if ($user) {
            //proceed to login
        } 
        else 
        {
            //check if email exist
            $user = User::where('email', $user->email)->first();

            if ($user) {
                //update provider_id
                $user = $existingUser;
                $user->provider_id = $user->id;
                $user->save();

                //proceed to login
            } 
            else 
            {
                //create a new user
                $user = new User;
                $user->signup_by = $provider;
                $user->name = $user->name;
                $user->email = $user->email;
                $user->email_verified_at = date('Y-m-d Hms');
                $user->provider_id = $user->id;
                $user->save();


                //proceed to login
            }
        }

        Auth::login($user);
        $request->session()->regenerate();
        if(env('USER_ONE_DEVICE_LOGIN'))
        {
            logOutFromOtherDevice();
        }
        return apiResponse(true,"Login Successfull",null,201);


    }

    public function signInByAccessToken(Request $request)
    {
        $validation_rules=[
            'provider' => 'required|string|in:facebook,google,apple',

            'access_token' => 'required|string',

            'source' => 'nullable:string|in:app,web' // Optional field to identify the source of the request
        ];

        $source= $request->input('source', 'web'); // Default to 'web'

        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            $firstValue = reset($error_arr)[0];
            return apiResponse($result=false,$message=$firstValue,$data=$error_arr,$code=200);
        }

        $name = 'Guest';
        $email = '';
        $avatar = '';
        $providerId = null;

        switch ($request->provider) 
        {
            case 'facebook':
                $socialUser = Socialite::driver('facebook')
                    ->fields(['name', 'first_name', 'last_name', 'email','picture'])
                    ->userFromToken($request->access_token);
                if ($socialUser) 
                {
                    $name = $socialUser->getName();
                    $email = $socialUser->getEmail();
                    $providerId = $socialUser->getId(); 
                    $avatar = $socialUser->getAvatar();
                }
                else
                {
                    return apiResponse(false,"Something went wrong");
                }
                break;
            case 'google':
                $socialUser = Socialite::driver('google')
                    ->userFromToken($request->access_token);
                if ($socialUser) 
                {
                    $name = $socialUser->getName();
                    $email = $socialUser->getEmail();
                    $providerId = $socialUser->getId(); 
                    $avatar = $socialUser->getAvatar();
                }
                else
                {
                    return apiResponse(false,"Something went wrong");
                }
                break;
            case 'apple':
                $idToken = $request->access_token;
                $idTokenParts = explode('.', $idToken);
                $idTokenPayload = json_decode(base64_decode($idTokenParts[1]), true);
                $providerId = $idTokenPayload['sub'];
                $email = $idTokenPayload['email'] ?? ''; 
                $name = $idTokenPayload['name'] ?? 'Guest';
                $avatar = '';
                break;
            default:
                return response()->json([
                    'result' => false,
                    'message' => translate('No social provider matches'),
                    'user' => null
                ]);
        }

        $user = User::where('provider_id', $providerId)->first();


        if($user) 
        {
            //login
        } 
        else 
        {
            if($email != '')
            {
                $user = User::where('email',$email)->first();
                if($user!='')
                {
                    //login
                }
                else
                {
                    $user = new User;
                    $user->signup_by = $request->provider;
                    $user->name = $name;
                    $user->email = $email;
                    $user->signup_by = 'email';
                    $user->notify_by = 'email';
                    $user->provider_id = $providerId;
                    $user->avatar = $avatar;
                    $user->email_verified_at = Carbon::now();
                    $user->save();
                }
            }
            else
            {
                $user = new User;
                $user->name = $name;
                $user->signup_by = $request->provider;
                $user->provider_id = $providerId;
                $user->avatar = $avatar;
                $user->email_verified_at = Carbon::now();
                $user->save();
            }
        }

        if($source=='app')
        {
            return loginUsingUser($user,"Logged In");
        }
        else
        {
            Auth::login($user);
            $request->session()->regenerate();
            if(env('USER_ONE_DEVICE_LOGIN'))
            {
                logOutFromOtherDevice();
            }
            return apiResponse(true,"Login Successfull",null,201);
        }
    }


}
