<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\User;
use Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // public function __invoke(EmailVerificationRequest $request)
    // {
    //     if ($request->user()->hasVerifiedEmail()) {
    //         return redirect()->intended(
    //             config('app.frontend_url').RouteServiceProvider::HOME.'?verified=1'
    //         );
    //     }

    //     if ($request->user()->markEmailAsVerified()) {
    //         event(new Verified($request->user()));
    //     }

    //     return redirect()->intended(
    //         config('app.frontend_url').RouteServiceProvider::HOME.'?verified=1'
    //     );
    // }

    public function __invoke(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        // Validate the hash matches the user's email
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) { //if already verified
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended(
                config('app.frontend_url') . RouteServiceProvider::HOME . '?verified=1'
            );
        }


        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(
            config('app.frontend_url') . RouteServiceProvider::HOME . '?verified=1'
        );
    }
}
