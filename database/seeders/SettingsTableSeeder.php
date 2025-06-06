<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{

    public function run()
    {
        
        $settings=[

            [
                'title' => 'Title',
                'root' => 'general',
                'root_title' =>'General Settings',
                'key' => 'title',
                'type' => 'app',
                'design' => '1',
                'value' => 'This is Tork title',
            ],

            [
                'title' => 'Phone',
                'root' => 'contact',
                'root_title' =>'Contact Info',
                'key' => 'phone',
                'type' => 'app',
                'design' => '1',
                'value' => '01313941166',
            ],

            [
                'title' => 'Meta Title',
                'root' => 'seo',
                'root_title' =>'SEO',
                'key' => 'meta_title',
                'type' => 'app',
                'design' => '1',
                'value' => 'This is Tork meta title',
            ],

            [
                'title' => 'Meta Description',
                'root' => 'seo',
                'root_title' =>'SEO',
                'key' => 'meta_description',
                'type' => 'app',
                'design' => '1',
                'value' => 'This is Tork meta description',
            ],

            [
                'title' => 'Light Logo',
                'root' => 'general',
                'root_title' =>'General Settings',
                'key' => 'light_logo',
                'type' => 'app',
                'design' => '1',
                'value' => 'assets/images/logo/logo.png',
            ],

            [
                'title' => 'Dark Logo',
                'root' => 'general',
                'root_title' =>'General Settings',
                'key' => 'dark_logo',
                'type' => 'app',
                'design' => '1',
                'value' => 'assets/images/logo/logo-dark.png',
            ],

            [
                'title' => 'Favicon',
                'root' => 'general',
                'root_title' =>'General Settings',
                'key' => 'favicon',
                'type' => 'app',
                'design' => '1',
                'value' => 'assets/images/favicon.png',
            ],

            [
                'title' => 'Email',
                'root' => 'contact',
                'root_title' =>'Contact Info',
                'key' => 'email',
                'type' => 'app',
                'design' => '2',
                'value' => 'mail@thetork.com',
            ],

            [
                'title' => 'Address',
                'root' => 'contact',
                'root_title' =>'Contact Info',
                'key' => 'address',
                'type' => 'app',
                'design' => '2',
                'value' => 'House-19, Road-03, Block-G, Dhaka 1219, Bangladesh',
            ],

            [   
                'root'=> 'about',
                'root_title' => 'About',
                'title' => 'About Us',
                'key' => 'about_us',
                'type' => 'app',
                'design' => '2',
                'value' => 'About Us Example',
            ],
            [
                'root' => 'privacy',
                'root_title' => 'Privacy',
                'title' => 'Privacy Policy',
                'key' => 'privacy_policy',
                'type' => 'app',
                'design' => '2',
                'value' => 'Privacy Policy Example',
            ],
            [
                'root' => 'copyright',
                'root_title' => 'Copyright Policy',
                'title' => 'Copyright Policy',
                'key' => 'copyright_policy',
                'type' => 'app',
                'design' => '2',
                'value' => 'Copyright Policy Example',
            ],
            [
                'root' => 'comapny_info',
                'root_title' => 'Company Info',
                'title' => 'Company Info',
                'key' => 'company_name',
                'type' => 'app',
                'design' => '2',
                'value' => 'Tork Inc.',
            ],
            [
                'root' => 'comapny_info',
                'root_title' => 'Company Info',
                'title' => 'Company Info',
                'key' => 'company_name',
                'type' => 'app',
                'design' => '2',
                'value' => 'Tork Inc.',
            ],
            [
                'root' => 'comapny_info',
                'root_title' => 'Company Info',
                'title' => 'Company Info',
                'key' => 'company_email',
                'type' => 'app',
                'design' => '2',
                'value' => 'mail@thetork.com',
            ],
            [
                'root' => 'comapny_info',
                'root_title' => 'Company Info',
                'title' => 'Company Info',
                'key' => 'company_language',
                'type' => 'app',
                'design' => '2',
                'value' => 'English',
            ],
            [
                'root' => 'comapny_info',
                'root_title' => 'Company Info',
                'title' => 'Company Info',
                'key' => 'company_time_zone',
                'type' => 'app',
                'design' => '2',
                'value' => '(GMT+06:00) Dhaka',
            ],
            [
                'root' => 'theme',
                'root_title' => 'Theme Setting',
                'title' => 'Theme Setting',
                'key' => 'sidebar_theme',
                'type' => 'app',
                'design' => '2',
                'value' => 'dark',
            ],


        ];

        foreach($settings as $setting){

            DB::table('settings')->insert([
                'title' => $setting['title'],
                'root' => $setting['root'],
                'root_title' => $setting['root_title'],
                'key' => $setting['key'],
                'design' => $setting['design'],
                'value' => $setting['value'],
            ]);

        }
        
    }
}