<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(WebsiteSettingsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(AdminMenusTableSeeder::class);
        $this->call(MigrationsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        //MORE_SEEDER
    }
}
