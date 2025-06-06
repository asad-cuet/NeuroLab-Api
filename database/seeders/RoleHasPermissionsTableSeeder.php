<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $data=[];

        for($i=1;$i<=3;$i++)
        {
            for($j=1;$j<=20;$j++)
            {
                if(($i==1 && in_array($j,[2,3,4,9,10,11,12,13,14,15,16])) || ($i==2 && in_array($j,[2,3,4]))){

                }else{
                    $row=[
                        'role_id' => $i,  
                        'permission_id' => $j,
                    ];
                    $data[]=$row;
                }
            }
        }

        DB::table('role_has_permissions')->insert($data);
        
        
        
    }
}