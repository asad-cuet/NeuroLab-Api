<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $admin = Admin::where('email', $googleUser->getEmail())->first();

        if (!$admin) {
            return redirect(route('admin.login'))
                        ->with('error',"This Email Account not Found");
        }

        Auth::guard('admin')->login($admin);

        return redirect()->intended('/admin/dashboard');
    }
}
