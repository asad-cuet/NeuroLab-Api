<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;
use Spatie\Health\Facades\Health;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Health::checks([
            UsedDiskSpaceCheck::new(),
            DatabaseCheck::new(),
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::listen(function ($query) {
            Log::channel('query')->info($query->sql . ' >>[' . implode(', ', $query->bindings) . '] ;' . PHP_EOL);
        });

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
         });

         Paginator::defaultView('pagination.tork-pagination');
    }
}
