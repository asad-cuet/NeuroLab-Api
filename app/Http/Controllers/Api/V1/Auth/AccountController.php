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

class AccountController extends Controller
{
    public function profileAccountUpdate(Request $request)
    {   

        $rules = [
            'name' => 'required',
            'email' => [
                'required',
               Rule::unique('users', 'email')->ignore(auth()->id()),
            ],
            'phone' => [
                'nullable',
                'digits:11'
            ]
            
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $error_arr=$validator->errors()->toArray();
            $firstValue = reset($error_arr)[0];
            return apiResponse($result=false,$message=$firstValue,$data=$error_arr,$code=400);
        }
  
        $row = User::findOrFail(auth()->id());
        
        $row->name = $request->name;
        $row->email = $request->email;
        if ($request->phone) 
        {
            $row->phone = $request->phone;
        }



        if($request->hasfile('avatar'))
        {
            $image_response=FileManager::saveFile(
                $request->file('avatar'),
                'storage/Users',
                ['png','jpg','jpeg']
            );
            if(isset($image_response['result']) && !$image_response['result'])
            {

                return apiResponse($image_response['result'],$image_response['message'],null,403);
            }

            $old_file=$row->avatar;
            FileManager::deleteFile($old_file);  
            
            $row->avatar = $image_response['filename'];
            $row->save();
        }

        $row->save();

        return apiResponse(true,'Profile Successfully Updated',$row,200);
    
    }

    public function changePassword(Request $request)
    {
        $rules=[
            'old_password' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            $firstValue = reset($error_arr)[0];
            return apiResponse($result=false,$message=$firstValue,$data=$error_arr,$code=400);
        }

        $row = User::findOrFail(auth()->id());
        
        if (!Hash::check($request->old_password, $row->password)) {
            
            return apiResponse(false,"Old Password did not match",null,400);
        }
        
        $row->password = Hash::make($request->password);
        $row->save();

        return apiResponse(true,"Password Changed Successfully",null,200);

    }
}