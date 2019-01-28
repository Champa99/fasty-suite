<?php

/**
 * Auto created by artisan on 25.10.2018 at 14:31
 * @author Champa
 */

namespace App\Packages\System;

use Cache;
use DB;
use App\Packages\System\CacheVisor;
use App\Packages\System\Time;

class SecureRoute
{

	/**
	 * List of all routes
	 */

	protected $routes = [];

	/**
	 * Group prefix
	 */
	protected $prefix = '';

	/**
	 * Holds the laravel router component
	 */

	protected $router;

	public function __construct() {

		$this->router = app('router');
	}

	public function group(string $prefix, $cb) {

		$this->prefix = $prefix;

		$cb();

		$this->prefix = '';
	}

	/**
	 * Adds a get route to the collection
	 */

	public function get($uri, $action = null, int $perm_group = 0, int $perm = 0) {
		
		if(!empty($this->prefix))
			$uri = $this->prefix . $uri;

		$this->addSecureRoute($uri, $perm_group, $perm);

		return $this->router->get($uri, $action);
	}

	/**
	 * Adds a post route to the collection
	 */

	public function post($uri, $action = null, int $perm_group = 0, int $perm = 0) {
		
		if(!empty($this->prefix))
			$uri = $this->prefix . $uri;

		$this->addSecureRoute($uri, $perm_group, $perm);

		return $this->router->post($uri, $action);
	}

	/**
	 * Adds a authorization level to the given route
	 */

	private function addSecureRoute(string $uri, int $perm_group = 0, int $perm = 0) : SecureRoute {

		$this->routes[$uri] = [
			'perm_group' => $perm_group,
			'perm' => $perm
		];

		return $this;
	}

	/**
	 * Secure routes getter
	 * Returns all routes if the $uri param is not set
	 * Else returns the requested route
	 */

	public function getRoute(?string $uri = null) {

		if($uri === null)
			return $this->routes;

		if(isset($this->routes[$uri]))
			return $this->routes[$uri];
	}
}