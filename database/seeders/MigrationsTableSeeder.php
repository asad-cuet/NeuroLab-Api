<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('migrations')->delete();
        
        DB::table('migrations')->insert([
            [
                'id' => 1,
                'migration' => '2014_10_12_000000_create_users_table',
                'batch' => 1,
            ],
            [
                'id' => 2,
                'migration' => '2014_10_12_100000_create_password_resets_table',
                'batch' => 1,
            ], 
            [
                'id' => 3,
                'migration' => '2019_08_19_000000_create_failed_jobs_table',
                'batch' => 1,
            ],
            [
                'id' => 4,
                'migration' => '2019_12_14_000001_create_permission_tables',
                'batch' => 1,
            ],
            [
                'id' => 5,
                'migration' => '2019_12_14_000001_create_personal_access_tokens_table',
                'batch' => 1,
            ],
            [
                'id' => 6,
                'migration' => '2022_03_14_083232_create_admins_table',
                'batch' => 1,
            ],
            [
                'id' => 7,
                'migration' => '2022_03_14_083311_create_admin_menus_table',
                'batch' => 1,
            ],
            [
                'id' => 8,
                'migration' => '2022_03_14_083440_create_settings_table',
                'batch' => 1,
            ],
        ]);
        
        
    }
}