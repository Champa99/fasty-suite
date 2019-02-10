<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SecureRoute extends Facade
{

    protected static function getFacadeAccessor() {
		
		return 'secureroute';
	}
}