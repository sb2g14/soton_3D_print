<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role=null, $permission=null)
    {
        if (Auth::guest()) {
            return redirect('login');
        }
        
        if($role){
            $role = is_array($role)
                ? $role
                : explode('|', $role);

            if (! $request->user()->hasAnyRole($role)) {
                abort(403);
            }
        }

        if ($permission && ! $request->user()->can($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
