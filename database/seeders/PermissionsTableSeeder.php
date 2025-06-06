<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        $permissions=[

            
            [
                'name' => 'admin-view',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'admin-create',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'admin-update',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'admin-delete',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'user-view',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'user-create',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'user-update',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'user-delete',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'role-view',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'role-create',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'role-update',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'role-delete',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'admin-menu-view',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'admin-menu-create',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'admin-menu-update',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'admin-menu-delete',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'setting-view',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'setting-create',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'setting-update',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'setting-delete',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'website-setting-view',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'website-setting-create',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'website-setting-update',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'website-setting-delete',
                'guard_name' => 'admin',
            ],


            [
                'name' => 'blog-category-view',
                'guard_name' => 'admin',
            ],
        [
                'name' => 'blog-category-create',
                'guard_name' => 'admin',
            ],
        [
                'name' => 'blog-category-update',
                'guard_name' => 'admin',
            ],
        [
                'name' => 'blog-category-delete',
                'guard_name' => 'admin',
            ],
        
        [
                'name' => 'blog-view',
                'guard_name' => 'admin',
            ],
        [
                'name' => 'blog-create',
                'guard_name' => 'admin',
            ],
        [
                'name' => 'blog-update',
                'guard_name' => 'admin',
            ],
        [
                'name' => 'blog-delete',
                'guard_name' => 'admin',
            ],
        
        [
                'name' => 'blog-comment-view',
                'guard_name' => 'admin',
            ],
        [
                'name' => 'blog-comment-create',
                'guard_name' => 'admin',
            ],
        [
                'name' => 'blog-comment-update',
                'guard_name' => 'admin',
            ],
        [
                'name' => 'blog-comment-delete',
                'guard_name' => 'admin',
            ],
            
            [
                'name' => 'page-view',
                'guard_name' => 'admin',
            ],
        [
                'name' => 'page-create',
                'guard_name' => 'admin',
            ],
        [
                'name' => 'page-update',
                'guard_name' => 'admin',
            ],
        [
                'name' => 'page-delete',
                'guard_name' => 'admin',
            ],
            
            [
                'name' => 'media-library-view',
                'guard_name' => 'admin',
            ],
        [
                'name' => 'media-library-create',
                'guard_name' => 'admin',
            ],
        [
                'name' => 'media-library-update',
                'guard_name' => 'admin',
            ],
        [
                'name' => 'media-library-delete',
                'guard_name' => 'admin',
            ],

            
            // [
        
            //     'name' => 'file-manager-create',
            //     'guard_name' => 'admin',
            // ],
            // [
        
            //     'name' => 'file-manager-view',
            //     'guard_name' => 'admin',
            // ],
            // [
        
            //     'name' => 'file-manager-update',
            //     'guard_name' => 'admin',
            // ],
            // [
        
            //     'name' => 'file-manager-delete',
            //     'guard_name' => 'admin',
            // ],

            //permission-seeds


        ];

        foreach($permissions as $permission){

            DB::table('permissions')->insert([
                'name' => $permission['name'],
                'guard_name' => $permission['guard_name'],
            ]);

        }
        
        
        
    }
}