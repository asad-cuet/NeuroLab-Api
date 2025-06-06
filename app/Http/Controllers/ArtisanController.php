<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use DB;
use App\Http\Middleware\EnsureUserIsSuperAdmin;

class ArtisanController extends Controller
{

    public function __construct()
    {
        $this->middleware(EnsureUserIsSuperAdmin::class);
    }

    public function artisanMigrate()
    {
        Artisan::call('migrate');
        return back()->with('success',"Migrated");
    }

    public function artisanMigrateFile($file)
    {
        Artisan::call('migrate --path=database/migrations/'.$file);
        return back()->with('success',"Migrated");
    }

    public function artisanMigrateSeed()
    {
        Artisan::call('migrate:fresh --seed');
        return back()->with('success',"Migrated & Seeded");
    }

    public function seedClass($class)
    {
        Artisan::call('db:seed --class='.$class);
        return back()->with('success',"Seeded");
    }

    public function generateSeeder($table)
    {
        Artisan::call('iseed '.$table.' --classnamesuffix=Backup --force');
        return back()->with('success',"Seeder Generated");
    }

    public function artisanStorageLink()
    {
        Artisan::call('storage:link');
        return back()->with('success',"Storage Linked");
    }

    public function artisanOptimizeClear()
    {
        Artisan::call('optimize:clear');
        return back()->with('success',"Optimize Cleared");
    }


    public function backupRun()
    {
        Artisan::call('backup:run');
        return back()->with('success',"Backup Run Completed");
    }

    public function backupClean()
    {
        Artisan::call('backup:clean');
        return back()->with('success',"Backup Cleaned");
    }

    public function backupList()
    {
        Artisan::call('backup:list');
        return back()->with('success',"Backup Listed");
    }

    public function backupMonitor()
    {
        Artisan::call('backup:monitor');
        return back()->with('success',"Backup Monitored");
    }

    public function healthCheck()
    {
        Artisan::call('health:check');
        return back()->with('success',"Health Checked");
    }
    
    public function artisanCacheClear()
    {
        Artisan::call('config:cache');
        return back()->with('success',"Cache Cleared");
    }

    public function artisanSubmit(Request $request)
    {
        if($request->migrate_filename!='')
        {
            return $this->artisanMigrateFile($request->migrate_filename);
        }

        if($request->seed_classname!='')
        {
            return $this->seedClass($request->seed_classname);
        }

        if($request->seeder_tablename!='')
        {
            return $this->generateSeeder($request->seeder_tablename);
        }
    }
    
    


}
