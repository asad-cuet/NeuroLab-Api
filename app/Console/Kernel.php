<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {

        Log::channel('schedule')->info("Schedule Running");
        
        // $schedule->command('inspire')->hourly()->appendOutputTo(storage_path('logs/inspire.log'));
        $schedule->command(\Spatie\Health\Commands\RunHealthChecksCommand::class)->everyMinute();
    }



    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
