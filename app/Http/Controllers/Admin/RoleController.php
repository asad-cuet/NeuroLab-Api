<?php


namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use stdClass;

class RoleController extends Controller
{
     /**
      * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
      */
     function __construct()
     {
          $this->middleware('permission:role-view|role-create|role-update|role-delete', ['only' => ['index']]);
          $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
          $this->middleware('permission:role-update', ['only' => ['edit', 'update']]);
          $this->middleware('permission:role-delete', ['only' => ['destroy']]);

          $this->table_columns = [

               [
                    "title" => 'Serial',
                    "index" => 'serial',
                    "design" => '1'
               ],
               [
                    "title" => 'Name',
                    "index" => 'name',
                    "max_char" => 30,
                    "design" => '7'
               ],
               [
                    "title" => 'Guard Name',
                    "index" => 'guard_name',
                    "max_char" => 30,
                    "design" => '7'
               ],
               [
                    "title" => 'Is Active:',
                    "index" => 'is_active',
                    "checked" => '',
                    "design" => '5'
               ],
               [
                    "title" => 'Actions',
                    "show_route" => 'admin.roles.index',
                    "edit_route" => 'admin.roles.edit',
                    "destroy_route" => 'admin.roles.destroy',
                    "design" => '2',
               ],
          ];

          $this->form_inputs = [
               [
                    "title" => 'Name:',
                    "placeholder" => 'Enter Name',
                    "name" => 'name',
                    "required" => '1',
                    "design" => '1'
               ],
               [
                    "title" => 'Is Active:',
                    "name" => 'is_active',
                    "checked" => '',
                    "design" => '5'
               ],

          ];

          $this->update_form_inputs = [
               [
                    "title" => 'Name:',
                    "placeholder" => 'Enter Name',
                    "name" => 'name',
                    "required" => '',
                    "update" => '',
                    "design" => '1'
               ],
               [
                    "title" => 'Is Active:',
                    "name" => 'is_active',
                    "checked" => '',
                    "update" => '',
                    "design" => '5'
               ],

          ];
     }

     /**
      * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function index(Request $request)
     {
          $page_title = 'Role';
          $info = new stdClass();
          $info->title = 'Roles';
          $info->first_button_title = 'Add  Role';
          $info->first_button_route = 'admin.roles.create';
          $info->route_index = 'admin.roles.index';
          $info->description = 'These  all are Roles';
          $info->table_columns = $this->table_columns;
          // $permissions = Permission::all();
          // $permissions = $permissions->GroupBy('guard_name');
          $data = Role::orderBy('id', 'DESC')->get();
          return view('admin.roles.index', compact('data', 'page_title', 'info'));
     }


     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {

          $page_title = 'Role';
          $info = new stdClass();
          $info->title = 'Roles';
          $info->first_button_title = 'All Role';
          $info->first_button_route = 'admin.roles.index';
          $info->form_route = 'admin.roles.store';

          $info->form_inputs = $this->form_inputs;
          return view('admin.roles.create', compact('page_title', 'info'));
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
               'name' => 'required|unique:roles,name',
          ];
          $this->validate($request, $validation_rules);
          $validation_rules = json_decode('[]', true);

          $except_columns = json_decode('["_token"]', true);
          $row = Role::create($request->except($except_columns));
          $row->guard_name = 'admin';
          $row->save();

          return redirect()->route('admin.roles.index')
               ->with('success', 'Role created successfully');
     }
     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function show($id)
     {


          $data = Role::find($id);
          if(!$data)
          {
               return back()->with('error',"Invalid Role Id");
          }

          $page_title = 'Role';
          $info = new stdClass();
          $info->title = $data->name;
          $info->first_button_title = 'All  Roles';
          $info->first_button_route = 'admin.roles.index';
          $info->description = 'Role Permissions';


          return view('admin.roles.view', compact('data','page_title', 'info'));

     }


     /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit($id)
     {

          $page_title = 'Role';
          $info = new stdClass();
          $info->title = 'Roles';
          $info->first_button_title = 'Add Role';
          $info->first_button_route = 'admin.roles.create';
          $info->second_button_title = 'All Role';
          $info->second_button_route = 'admin.roles.index';
          $info->form_route = 'admin.roles.update';

          $row = Role::where('id', $id)->first();

          $info->form_inputs = $this->update_form_inputs;

          return view('admin.roles.edit', compact('page_title', 'info', 'row'))->with('id', $id);
     }

     public function update(Request $request, $id)
     {
          $update_validation_rules = [
               'name' => 'required',
          ];
          $this->validate($request, $update_validation_rules);;
          $update_validation_rules = json_decode('[]', true);

          $update_except_columns = json_decode('["_token"]', true);





          $row = Role::find($id);
          $row->fill($request->except($update_except_columns));
          $row->save();


          return redirect()->route('admin.roles.index')
               ->with('success', 'Role updated successfully');
     }
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy($id)
     {

          Role::where('id', $id)->delete();
          return redirect()->route('admin.roles.index')
               ->with('success', 'Role deleted successfully');
     }


     public function PermissionsByRole($role_id)
     {
          $all_permissions = Permission::where('guard_name', 'admin')->get();
          $approved_permissions = DB::table('role_has_permissions')->join('permissions', 'permissions.id', 'role_has_permissions.permission_id')->select('permissions.name')->where('role_has_permissions.role_id', $role_id)->get()->toArray();
          return view('admin.roles.ajax.permissions', compact('all_permissions', 'approved_permissions'));
     }
     public function AdminsByRole($role_id)
     {
          // $admins = DB::table('model_has_roles')->join('admins', 'admins.id', 'model_has_roles.model_id')->select('admins.*', 'model_has_roles.role_id')->where('model_has_roles.role_id', $role_id)->orderBy('id', 'DESC')->get();

          $admins=Admin::whereHas('roles',function($query) use ($role_id){
               $query->where('role_id',$role_id);
          })
          ->get();

          return view('admin.roles.ajax.admins', compact('admins'));
     }

     public function AdminsExceptThisRole($role_id)
     {
          $admin_ids=Admin::whereHas('roles',function($query) use ($role_id){
               $query->where('role_id',$role_id);
          })
          ->pluck('id')->toArray();

          $admins=Admin::whereNotIn('id',$admin_ids)->get(); 

          return view('admin.roles.ajax.other_admins', compact('admins'));
     }
     public function UpdatePermissions(Request $request, $id)
     {

          $role = Role::find($id);


          if ($request->permissions != null && $role != null) {

               DB::table("role_has_permissions")->where('role_id', $id)->delete();

               foreach ($request->permissions as $permission) {
                    $row = Permission::firstOrCreate(['guard_name' => 'admin', 'name' => $permission]);

                    DB::table('role_has_permissions')
                         ->insertOrIgnore(
                              ['role_id' => $id, 'permission_id' => $row->id],
                              ['role_id' => $id, 'permission_id' => $row->id]
                         );

                    $role->givePermissionTo($row);
               }
               // $role->syncPermissions([]);
          }
          return true;
     }
     public function AddUserRole(Request $request)
     {
          $role=Role::where('id',$request->role_id)->first();
          foreach ($request->admin_ids as $admin_id) {
               $admin = Admin::find($admin_id);
               $admin->assignRole($role->name);
          }

          $admins = DB::table('model_has_roles')->join('admins', 'admins.id', 'model_has_roles.model_id')->select('admins.*', 'model_has_roles.role_id')->where('model_has_roles.role_id', $request->role_id)->orderBy('id', 'DESC')->get();
          return view('admin.roles.ajax.admins', compact('admins'));
     }
     public function DeleteUserRole(Request $request)
     {

          DB::table('model_has_roles')->where('role_id', $request->role_id)->where('model_id', $request->admin_id)->delete();
          $admins = DB::table('model_has_roles')->join('admins', 'admins.id', 'model_has_roles.model_id')->select('admins.*', 'model_has_roles.role_id')->where('model_has_roles.role_id', $request->role_id)->orderBy('id', 'DESC')->get();
          return view('admin.roles.ajax.admins', compact('admins'));
     }
}
