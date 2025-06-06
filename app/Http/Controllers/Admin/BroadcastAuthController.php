<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class BroadcastAuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->session()->regenerateToken();
        $admin = $request->user();

        if ($admin) 
        {
            return Broadcast::auth($request);
        } 
        else
        {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }
}
