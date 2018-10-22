<?php

namespace App\Http\Middleware;

use Closure;

class LoadPermissions
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

		\App\Packages\User\Group::loadPermissions(1);

        return $next($request);
    }
}
