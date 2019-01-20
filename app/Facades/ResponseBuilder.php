<?php

/**
 * Auto created by artisan on 03.12.2018 at 14:26
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ResponseBuilder extends Facade
{

	/**
	 * Tells our facade what dependency to return
	 */

    protected static function getFacadeAccessor() {
		
		return 'platform.apibuilder';
	}
}