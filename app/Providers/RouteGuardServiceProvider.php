<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RouteGuardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
		\App::bind('routeguard', function() {

			return new \App\Packages\System\RouteGuard;
		});
    }
}
