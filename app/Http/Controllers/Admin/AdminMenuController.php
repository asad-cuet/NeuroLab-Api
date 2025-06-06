<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminMenu;
use AdminSidebar;
use \stdClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Classes\SelfCoder\FileManager;

class AdminMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:admin-menu-view|admin-menu-create|admin-menu-update|admin-menu-delete', ['only' => ['index']]);
        $this->middleware('permission:admin-menu-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin-menu-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-menu-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title = 'Admin Menu';
        $info = new stdClass();
        $info->title = 'Admin Menus';
        $info->first_button_title = 'Add Admin Menu';
        $info->first_button_route = 'admin.admin-menus.create';
        $info->route_index = 'admin.admin-menus.index';
        $info->description = 'These  all are Admin Menus';
        $info->admin_menus = app('App\Models\AdminMenu')
            ->orderBy('order', 'ASC')
            ->get()
            ->groupBy('parent_id');
            

        return view('admin.admin-menus.index', compact('page_title', 'info'));
    }

    public function saveNestedMenus(Request $request)
    {
        $simplified_list = [];
        $this->recur1($request->nested_menus_array, $simplified_list);

        foreach ($simplified_list as $k => $v) {
            $menu = app('App\Models\AdminMenu')->find($v['menu_id']);
            $menu->parent_id = $v['parent_id'];
            $menu->order = $v['order'];
            $menu->save();
        }

        $this->syncLeftSidebarMenu();
        $this->syncHeaderMenu();

        return 'success';
    }

    public function syncAdminMenu()
    {
        $this->syncLeftSidebarMenu();
        $this->syncHeaderMenu();
        return back()->with('success',"Sync Menus Completed");
    }

    public function recur1($nested_array = [], &$simplified_list = [])
    {
        static $counter = 0;

        foreach ($nested_array as $k => $v) {
            $order = $k + 1;
            $simplified_list[] = [
                'menu_id' => $v['id'],
                'parent_id' => 0,
                'order' => $order,
            ];

            if (!empty($v['children'])) {
                $counter += 1;
                $this->recur2($v['children'], $simplified_list, $v['id']);
            }
        }
    }

    public function recur2($sub_nested_array = [], &$simplified_list = [], $parent_id = null)
    {
        static $counter = 0;

        foreach ($sub_nested_array as $k => $v) {
            $order = $k + 1;
            $simplified_list[] = [
                'menu_id' => $v['id'],
                'parent_id' => $parent_id,
                'order' => $order,
            ];

            if (!empty($v['children'])) {
                $counter += 1;
                return $this->recur2($v['children'], $simplified_list, $v['id']);
            }
        }
    }

    public function create()
    {
        $page_title = 'Admin Menu';
        $info = new stdClass();
        $info->title = 'Admin Menus';
        $info->first_button_title = 'All Admin Menu';
        $info->first_button_route = 'admin.admin-menus.index';
        $info->form_route = 'admin.admin-menus.store';

        $admin_menus = AdminMenu::get();
        return view('admin.admin-menus.create', compact('page_title', 'info', 'admin_menus'));
    }

    public function store(Request $request)
    {
        $validation_rules = json_decode('[]', true);
        $this->validate($request, $validation_rules);

        $except_columns = json_decode('["_token"]', true);

        $row = new AdminMenu;

        $row->title=$request->title;
        $row->icon=$request->icon;
        $row->url=$request->url;
        $row->permission=$request->permission;
        $row->is_newtab=$request->is_newtab?? 0;
        $row->is_shortcut=$request->is_shortcut?? 0;
        $row->is_quick_action=$request->is_quick_action?? 0;
        $row->is_section=$request->is_section?? 0;
        $row->is_separator=$request->is_separator?? 0;
        $row->is_active=$request->is_active?? 0;
        $row->parent_id = $request->parent_id ?? 0;

        $row->save();

        return redirect()
            ->route('admin.admin-menus.index')
            ->with('success', 'Admin Menu created successfully');
    }

    public function show()
    {
        //
    }

    public function edit($id)
    {
        $page_title = 'Admin Menu';
        $info = new stdClass();
        $info->title = 'Admin Menus';
        $info->first_button_title = 'All Admin Menus';
        $info->first_button_route = 'admin.admin-menus.index';
        $info->form_route = 'admin.admin-menus.update';
        $admin_menus = AdminMenu::get();

        $data = app('App\Models\AdminMenu')
            ->where('id', $id)
            ->first();


        return view('admin.admin-menus.edit', compact('page_title', 'info', 'data','admin_menus'))->with('id', $id);
    }

    public function update(Request $request, $id)
    {
        $row = AdminMenu::where('id', $id)->first();

        $row->title=$request->title;
        $row->icon=$request->icon;
        $row->url=$request->url;
        $row->permission=$request->permission;
        $row->is_newtab=$request->is_newtab?? 0;
        $row->is_shortcut=$request->is_shortcut?? 0;
        $row->is_quick_action=$request->is_quick_action?? 0;
        $row->is_section=$request->is_section?? 0;
        $row->is_separator=$request->is_separator?? 0;
        $row->is_active=$request->is_active?? 0;
        $row->parent_id = $request->parent_id ?? 0;

        $row->save();

        return redirect()
            ->route('admin.admin-menus.index')
            ->with('success', 'Admin Menu updated successfully');
    }

    public function destroy($id)
    {
        app('App\Models\AdminMenu')->destroy($id);
        return redirect()
            ->route('admin.admin-menus.index')
            ->with('success', 'Admin Menu deleted successfully');
    }

    public static function syncHeaderMenu()
    {
        $header_top_shortcuts = AdminMenu::where('is_shortcut', 1)
            ->select('title', 'url', 'icon', 'color_type')
            ->get()
            ->toArray();
        $quick_actions = AdminMenu::where('is_quick_action', 1)
            ->select('title', 'url', 'icon', 'color_type')
            ->get()
            ->toArray();

        $data = new stdClass();
        $data->header_top_shortcuts = $header_top_shortcuts;
        $data->quick_actions = $quick_actions;
        AdminSidebar::updateMenuHeader($data);
    }

    public function syncLeftSidebarMenu()
    {
        $left_sidebar_menus = [];
        $left_sidebar_menus[] = $this->createSidebarMenu();
        AdminSidebar::updateLeftSidebar($left_sidebar_menus);
    }
    public function createSidebarMenu($parent_id = 0): array
    {
        try {
            return \App\Models\AdminMenu::where('parent_id', $parent_id)
                ->where('is_active', 1)
                ->orderBy('order', 'ASC')
                ->get()
                ->map(function ($admin_menu) {
                    if ($admin_menu->is_section == 1) {
                        $data = [
                            'section' => $admin_menu->title,
                            'permission' => $admin_menu->permission,
                        ];
                    } elseif ($admin_menu->is_separator) {
                        $data = [
                            'separator' => $admin_menu->title,
                            'permission' => $admin_menu->permission,
                        ];
                    } else {
                        $data = [
                            'title' => $admin_menu->title,
                            'root' => $admin_menu->parent_id == 0,
                            'icon' => trim($admin_menu->icon) != '' ? $admin_menu->icon : 'flaticon2-menu-3',
                            'page' => $admin_menu->url,
                            'permission' => $admin_menu->permission,
                            'new-tab' => $admin_menu->is_newtab != 0,
                        ];
                    }

                    if (
                        \App\Models\AdminMenu::where('parent_id', $admin_menu->id)
                            ->where('is_active', 1)
                            ->exists()
                    ) {
                        $data['submenu'] = $this->createSidebarMenu($admin_menu->id);
                        $data['arrow'] = count($data['submenu']) > 0 ? true : false;
                    }
                    return $data;
                })
                ->all();
        } catch (\Exception $e) {
            return [];
        }
        return [];
    }
}
