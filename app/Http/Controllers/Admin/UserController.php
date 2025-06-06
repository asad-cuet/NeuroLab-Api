<?php

namespace App\Http\Controllers\Admin;

use \stdClass;
use Illuminate\Http\Request;
use App\Classes\SelfCoder\FileManager;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App;
use Auth;
use DB;
use App\Models\User;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-view|user-create|user-update|user-delete', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_title = 'User';
        $info = new stdClass();
        $info->title = 'Users';
        $info->first_button_title = 'Add User';
        $info->first_button_route = 'admin.users.create';
        $info->route_index = 'admin.users.index';
        $info->description = 'These  all are users';

        $per_page = request('per_page', 20);

        $data = app('App\Models\User');

        if ($request->search!='' && trim($request->search)!='') 
        {
            $data=keywordBaseSearch(
                $searh_key=trim($request->search),
                $columns_array=['name','email','phone'],
                $model_query=$data
            );
        }

        $data = $data->orderBy('id', 'DESC')->paginate($per_page);

        return view('admin.users.index', compact('page_title', 'data', 'info','per_page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'User';
        $info = new stdClass();
        $info->title = 'Users';
        $info->first_button_title = 'All Users';
        $info->first_button_route = 'admin.users.index';
        $info->form_route = 'admin.users.store';

        return view('admin.users.create', compact('page_title', 'info'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation_rules = [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password|min:8',
        ];
        $this->validate($request, $validation_rules);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_active = $request->is_active?? 1;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);

        // if ($request->hasFile('avatar')) {
        //     $user->addMediaFromRequest('avatar')
        //     // ->withResponsiveImages()
        //     ->toMediaCollection('avatars');
        // }

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
            $user->avatar = $image_response['filename'];
        }


        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = new stdClass();
        $info->title = 'User Details';
        $info->first_button_title = 'All User';
        $info->first_button_route = 'admin.users.index';
        $info->description = '';

        $page_title = 'User';

        $data = app('App\Models\User')->findOrFail($id);


        return view('admin.users.view', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'User';
        $info = new stdClass();
        $info->title = 'Edit User';
        $info->first_button_title = 'Add User';
        $info->first_button_route = 'admin.users.create';
        $info->second_button_title = 'All User';
        $info->second_button_route = 'admin.users.index';
        $info->form_route = 'admin.users.update';

        $row = User::findOrFail($id);

        return view('admin.users.edit', compact('page_title', 'info', 'row'))->with('id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id),
            ]
        ]);


        $row = User::findOrFail($id);
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

        // if ($request->hasFile('avatar')) {
        //     $row->addMediaFromRequest('avatar')->withResponsiveImages()->toMediaCollection('avatars');
        // }


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

        $row->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row=User::find($id);
        FileManager::deleteFile($row->avatar);  
        $row->delete();
        
        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }


    public function userLogin($user_id)
    {
        Auth::guard('web')->loginUsingId($user_id);
        return redirect(env('FRONTEND_URL').'/dashboard');

    }


    public function import() 
    {
        Excel::import(new UsersImport, storage_path('app/public/users.xlsx'));
        
        return 1;
    }

    public function getUserLoginHistory(Request $request, $userId)
    {
        $loginHistory = DB::table('sessions')
            ->where('user_id', $userId)
            ->get(['id', 'ip_address', 'user_agent', 'last_activity']);

        return response()->json($loginHistory);
    }


    public function logoutFromSpecificSession(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
        ]);

        $sessionId = $request->input('session_id');

        DB::table('sessions')->where('id', $sessionId)->delete();

        return response()->json(['message' => 'Logged out from the specific session successfully.']);
    }

    public function logoutFromAllSessions(Request $request)
    {
        DB::table('sessions')->where('user_id', $request->user_id)->delete();

        return response()->json(['message' => 'Logged out from all sessions successfully.']);
    }
}
