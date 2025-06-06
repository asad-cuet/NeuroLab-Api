<?php
namespace App\Http\Middleware;


class EnsureUserIsSuperAdmin
{

    public function handle($request, $next)
    {
        $admin=auth()->guard('admin')->user();
        if($admin!='' && $admin->hasRole('Super Admin'))
        {
            return $next($request);
        }
        else
        {
            return abort(403);
        }
    }
}