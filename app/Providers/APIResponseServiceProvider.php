<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class APIResponseServiceProvider extends ServiceProvider
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
        \App::bind('platform.apibuilder', function() {

			return new \App\Packages\API\Builder;
		});
    }
}
