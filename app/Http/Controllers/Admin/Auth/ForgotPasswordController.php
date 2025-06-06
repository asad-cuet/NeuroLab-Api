<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Notifications\ResetPassword;
use Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
    }


    protected function broker()
    {
      return Password::broker('admins');
    }

    protected function guard()
    {
    return Auth::guard('admin');
    }

    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            // Customize your mail message here
            return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject(Lang::get('Reset Password Notification'))
            ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
            ->action('Reset Password', route('admin.password.reset', $token))
            ->line(Lang::get('This password reset link will expire in :count.', ['count' => formatDuration(config('auth.passwords.admins.expire'))]));
        });


        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response === Password::RESET_LINK_SENT
            ? back()->with('status', __($response))
            : back()->withErrors(['email' => __($response)]);
    }

}
