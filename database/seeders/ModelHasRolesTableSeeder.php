<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelHasRolesTableSeeder extends Seeder
{

    public function run()
    {
        

        $roles=[

            [
                'role_id' => '1',
                'model_type' => 'App\Models\Admin',
                'model_id' => '1',
            ],
            [
                'role_id' => '2',
                'model_type' => 'App\Models\Admin',
                'model_id' => '2',
            ],
            [
                'role_id' => '3',
                'model_type' => 'App\Models\Admin',
                'model_id' => '3',
            ],

        ];

        foreach($roles as $role){

            DB::table('model_has_roles')->insert([
                'role_id' => $role['role_id'],
                'model_type' => $role['model_type'],
                'model_id' => $role['model_id'],
            ]);

        }
        
        
        
    }
}