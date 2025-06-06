<?php

namespace App\Http\Controllers\Admin;

use DB;
use \stdClass;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:admin-view|admin-create|admin-update|admin-delete', ['only' => ['index']]);
        $this->middleware('permission:admin-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd(Auth::user()->name);
        //$user->hasPermissionTo('publish articles', 'admin');
        // dd(Auth::user()->getAllPermissions(), Auth::getDefaultDriver(), Auth::user()->getRoleNames());
        // return dd($this);
        $page_title = 'Admin';
        $info = new stdClass();
        $info->title = 'Admins';
        $info->first_button_title = __('button.add_admin');
        $info->first_button_route = 'admin.admins.create';
        $info->route_index = 'admin.admins.index';
        $info->description = 'These  all are Admin';

        $data = Admin::orderBy('id', 'DESC')->get();

        return view('admin.admins.index', compact('page_title', 'data', 'info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return create file
        $page_title = 'Admin';
        // call stdClass
        $info = new stdClass();
        $info->title = 'Add Admin';
        $info->first_button_title = 'All Admin';
        $info->first_button_route = 'admin.admins.index';
        // admin data store route
        $info->form_route = 'admin.admins.store';

        return view('admin.admins.create', compact('page_title', 'info'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // vaildate input data
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:admins,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password|min:8',
        ]);

        $row = new Admin();

        $row->name = $request->name;
        $row->email = $request->email;
        $row->phone = $request->phone;
        $row->is_active = $request->is_active;
        $row->password = Hash::make($request->password);

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
            $row->avatar = $image_response['filename'];
        }

        $row->save();

        return redirect()->route('admin.admins.index')->with('success','Admin create success!');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get admin data
        $data = Admin::find($id);
        if(!$data)
        {
            return back()->with('warning','Admin data not found!');
        }
        // return view admin view file
        // show admin view file
        $page_title = 'Admin';
        // call stdClass
        $info = new stdClass();
        $info->title = 'Admin Details';
        $info->first_button_title = 'All Admin';
        // admin data list route
        $info->first_button_route = 'admin.admins.index';
        return view('admin.admins.view', compact('id', 'info', 'page_title', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // admin data edit file credentials
        $page_title = 'Admin';
        // call std class
        $info = new stdClass();
        $info->title = 'Admins';
        $info->first_button_title = 'Add Admin';
        $info->first_button_route = 'admin.admins.create';
        $info->second_button_title = 'All Admin';
        // admin data list route
        $info->second_button_route = 'admin.admins.index';
        // admin updata data route
        $info->form_route = 'admin.admins.update';

        // find admin data form dataBase
        $row = Admin::where('id', $id)->first();
        // return admin eidt view file
        return view('admin.admins.edit', compact('page_title', 'info', 'row'))->with('id', $id);
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
        // validation form data
        $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('admins', 'email')->ignore($id),
            ]
        ]);
        // get admin current data
        $row = Admin::findOrFail($id);
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
        $row->is_active = $request->is_active;
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::destroy($id);
        return redirect()
            ->route('admin.admins.index')->with('success','User delete success!');
    }
}
