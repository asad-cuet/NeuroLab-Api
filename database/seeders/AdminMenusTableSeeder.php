<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AdminMenu;

class AdminMenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $adminMenus = 
            array (
              // 0 => 
              // array (
              //   'title' => 'Dashboard',
              //   'root' => true,
              //   'icon' => 'lni lni-grid-alt',
              //   'page' => '/admin/dashboard',
              //   'permission' => '',
              //   'new-tab' => false,
              // ),
              0 => 
              array (
                'title' => 'All Users',
                'root' => true,
                'icon' => 'lni lni-users',
                'page' => '/admin/users',
                'permission' => 'user',
                'new-tab' => false,
              ),
              1 => 
              array (
                'title' => 'Web Admins',
                'root' => true,
                'icon' => 'lni lni-user',
                'page' => '/admin/admins',
                'permission' => 'admin',
                'new-tab' => false,
              ),
              
              // 8 => 
              // array (
              //   'title' => 'Settings',
              //   'root' => true,
              //   'icon' => 'lni lni-cog',
              //   'page' => '/admin/settings',
              //   'permission' => 'setting',
              //   'new-tab' => false,
              // ),
              2 => 
              array (
                'title' => 'Logout',
                'root' => true,
                'icon' => 'lni lni-share-alt',
                'page' => '/admin/logout',
                'permission' => '',
                'new-tab' => false,
              ),
            );


        foreach ($adminMenus as $adminMenu) {
            $this->insertMenu($adminMenu);
        }
    }

    function insertMenu($adminMenu,$parent_id=0)
    {
        $admin_menu=new AdminMenu;

        $admin_menu->title = $adminMenu['title']?? '';
        $admin_menu->is_section = isset($adminMenu['section'])? 1:0;
        
        if($admin_menu->is_section==1)
        {
            $admin_menu->title =$adminMenu['section'];
        }

        $admin_menu->is_shortcut = isset($adminMenu['shortcut'])? 1:0;
        $admin_menu->is_quick_action = isset($adminMenu['quick_action'])? 1:0;
        $admin_menu->url      = $adminMenu['page']?? '';
        $admin_menu->permission      = $adminMenu['permission']?? '';
        $admin_menu->icon     = $adminMenu['icon']?? '';
        $admin_menu->is_newtab = $adminMenu['new_tab']?? 0;
        $admin_menu->parent_id = $parent_id;
        $admin_menu->is_active = 1;
        $admin_menu->save();

        if(isset($adminMenu['submenu']) && count($adminMenu['submenu']))
        {
            foreach($adminMenu['submenu'] as $subMenu)
            {
                $this->insertMenu($subMenu,$admin_menu->id);
            }
        }
    }
}
