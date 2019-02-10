<?php

/**
 * Auto created by artisan on 06.11.2018 at 17:50
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class RouteGuard extends Facade
{

	/**
	 * Tells our facade what dependency to return
	 */

    protected static function getFacadeAccessor() {
		
		return 'routeguard';
	}
}