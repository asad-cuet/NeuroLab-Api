<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Classes\SelfCoder\Installer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
class LoginController extends Controller
{

    public function __construct()
    {
        Installer::checkInstalled();
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) 
        {
            return redirect()->route('admin.dashboard');
        } 
        else 
        {
            return redirect()->back()
                        ->withErrors(['email'=> __('auth.failed')])
                        ->withInput($request->only('email', 'remember'));
        }
    }

    public function logout(Request $request)
    {

        Auth::guard('admin')->logout();
        $request->session()->forget('password_hash_admin');

        return redirect(route('admin.login'));
    }

    /**
     * The user has been authenticated.
     *
     * @return mixed
     */
    protected function authenticated()
    {
        Auth::logoutOtherDevices(request('password'));
    }
}
