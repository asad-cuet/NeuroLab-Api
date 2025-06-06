<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Hash;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $auth_index_name=env('AUTH_PHONE_SUPPORT')? 'email_or_phone':'email';
        return [
            'country_code' => [env('FIXED_COUNTRY_CODE')? 'nullable':'required', 'string'],
            $auth_index_name => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $this->login();
        
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }



    public function login()
    {
        $country_code=env('FIXED_COUNTRY_CODE')?? $this->input('country_code');
        $auth_index_name=env('AUTH_PHONE_SUPPORT')? 'email_or_phone':'email';

        $email_or_phone=$this->input($auth_index_name);

        $user = \App\Models\User::where(function ($query1) use($email_or_phone,$country_code) {
                        $query1->where(function ($query2) use($email_or_phone) {
                            $query2->whereIn('signup_by', ['email','both'])
                                  ->where('email',$email_or_phone);
                        })
                        ->orWhere(function ($query3) use($email_or_phone,$country_code) {
                            $query3->whereIn('signup_by', ['phone','both'])
                                  ->where('country_code',$country_code)
                                  ->where('phone',$email_or_phone);
                        });
                    })
                    ->first();

        if($user!='')
        {

            if(Hash::check($this->input('password'), $user->password)) 
            {
                Auth::login($user);
                if(env('USER_ONE_DEVICE_LOGIN'))
                {
                    logOutFromOtherDevice();
                }
            } 
            else 
            {
                throw ValidationException::withMessages([
                    'message' => "Invalid phone or password",
                ]);
            }
        }
        else
        {
            throw ValidationException::withMessages([
                'message' => "Invalid credentials",
            ]);
        }

    }
}
