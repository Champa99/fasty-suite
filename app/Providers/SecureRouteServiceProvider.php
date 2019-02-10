<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SecureRouteServiceProvider extends ServiceProvider
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
		\App::bind('secureroute', function() {

            return new \App\Packages\System\SecureRoute;
        });
    }
}
