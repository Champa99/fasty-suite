<?php

/**
 * Auto created by artisan on 05.11.2018 at 23:52
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Authorizator extends Facade
{

	/**
	 * Tells our facade what dependency to return
	 */

    protected static function getFacadeAccessor() {
		
		return 'platform.authorizator';
	}
}