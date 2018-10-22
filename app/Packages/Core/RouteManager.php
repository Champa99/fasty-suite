<?php

/**
 * Auto created by artisan on 25.09.2018 at 20:01
 * @author Champa
 */

namespace App\Packages\Core;

use Cache;
use DB;
use App\Packages\System\Time;

class RouteManager
{

	/**
	 * Holds our application routes
	 */

	private $routes = [];

	/**
	 * Loads the routes from the datbase/cache
	 */

	public function loadRoutes() {

		$data = Cache::remember('routes', 0, function() {

			$q = "SELECT method, uri, controller FROM core_routes WHERE isEnabled = 1";

			return DB::select($q);
		});

		$this->routes = $data;
	}

	/**
	 * Route array getter
	 */

	public function routes() : ?array {

		return $this->routes;
	}
}