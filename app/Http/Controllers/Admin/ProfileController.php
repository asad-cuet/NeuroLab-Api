<?php
namespace App\Http\Controllers\Admin;

use App\Classes\SelfCoder\FileManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SettingController;
use App\Models\Setting;
use App\Models\Admin;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use DB;
use Auth;
use Hash;
use \stdClass;
use Illuminate\Support\Facades\Gate;

//IMPORT


class ProfileController extends Controller
{
     public function __construct()
     {
          $this->middleware('auth:admin');

          $this->language = languageArray();

          $this->time_zone = timeZoneArray();

          //METHOD_PERMISSION
     }


     public function index()
     {
        return view('admin.profile.index');
     }






    public function update(Request $request)
    {
        // validation form data
        $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('admins', 'email')->ignore(auth()->id()),
            ]
        ]);
        // get admin current data
        $row = Admin::findOrFail(auth()->id());
        if(!empty($request->password) || !empty($request->confirm_password)) {
            $request->validate([
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password|min:8',
            ]);
            $row->password = Hash::make($request->password);
        }

        $row->name = $request->name;
        $row->email = $request->email;
        $row->phone = $request->phone;
        $row->save();

        if($request->hasfile('avatar'))
        {
            $image_response=FileManager::saveFile(
                $request->file('avatar'),
                'storage/Admins',
                ['png','jpg','jpeg','gif']
            );
            if(isset($image_response['result']) && !$image_response['result'])
            {
                return back()->with('warning',$image_response['message']);
            }

            $old_file=$row->avatar;
            FileManager::deleteFile($old_file);  
            
            $row->avatar = $image_response['filename'];
            $row->save();
        }

        return back()->with('success','Admin update success!');
    }

}
