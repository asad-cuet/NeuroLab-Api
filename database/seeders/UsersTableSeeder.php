<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $users=[

            [
                'name'=>'Tork User',
                'email'=>'user@thetork.com',
                'password'=>'password',
                'country_code'=>'+880',
                'signup_by'=>'email',
                'notify_by'=>'email',
            ]


        ];

        foreach($users as $index => $user){

            DB::table('users')->insert([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'country_code' => $user['country_code'],
                'signup_by' => $user['signup_by'],
                'notify_by' => $user['notify_by'],
            ]);

        }
        

        
        
        
        
    }
}