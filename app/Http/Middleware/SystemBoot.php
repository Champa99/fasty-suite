<?php

namespace App\Http\Middleware;

use Closure;

class SystemBoot
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

		// Load the site configuration
		\App\Packages\Core\ConfigManager::load();

        return $next($request);
    }
}
