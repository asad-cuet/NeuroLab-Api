<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        $roles=[

            [
                'name' => 'Super Admin',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'Developer',
                'guard_name' => 'admin',
            ],

            [
                'name' => 'Admin',
                'guard_name' => 'admin',
            ],
        
        ];
        
        $i=0;

        foreach($roles as $role){

            DB::table('roles')->insert([
                'id' => ++$i,
                'name' => $role['name'],
                'guard_name' => $role['guard_name'],
                'is_active' => 1,
            ]);

        }
        
        
        
    }
}