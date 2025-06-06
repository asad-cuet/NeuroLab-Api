<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Classes\SelfCoder\FileManager;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Log;
use Validator;

class DevController extends Controller
{
    public function createToken(Request $request,$user_id)
    {   

        $user=\App\Models\User::find($user_id);
        $token = $user->createToken('API Token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    
    }
}