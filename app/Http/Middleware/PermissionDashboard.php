<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->can(['list_*', 'view_*', 'edit_*', 'create_*', 'delete_*'])) {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
