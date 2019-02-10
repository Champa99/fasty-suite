<?php

/**
 * Auto created by artisan on 26.10.2018 at 12:29
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class User extends Facade
{

	/**
	 * Tells our facade what dependency to return
	 */

    protected static function getFacadeAccessor() {
		
		return 'platform.user';
	}
}