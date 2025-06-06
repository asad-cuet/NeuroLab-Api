<?php

namespace App\Classes\SelfCoder;



class Installer
{
   
    public static function isInstalled()
    {

        if (file_exists(storage_path('installed'))) {
            return true;
        }
        return false;
    }

    
   
    public static function checkInstalled()
    {

        if (file_exists(storage_path('installed'))) {
            return true;
        }
        return redirect()->to('install')->send();
    }

    
}
