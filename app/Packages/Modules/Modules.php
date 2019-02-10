<?php

/**
 * Auto created by artisan on 01.02.2019 at 23:10
 * @author Champa
 */

namespace App\Packages\Modules;

use Cache;
use DB;
use App\Packages\System\CacheVisor;

class Modules
{

	/**
	 * Instance of the paginator
	 * @var Paginator
	 */
	private $paginator;

	public function __construct() {

		// Create a new instance of the paginator
		$this->paginator = new \App\Packages\Core\Paginator();
	}

	public function getAll() {

		$key = 'modlist_'. $this->paginator->getOffset();

		$cache = Cache::remember($key, CacheVisor::time(), function() {

			$q = "SELECT id, name, version, cycle, type, author, website, installed_on, updated_on, picture
			FROM core_modules ORDER BY name DESC LIMIT :start, :max";

			return DB::select($q, [
				'start' => $this->paginator->getOffset(),
				'max' => $this->paginator->getPageSize()
			]);
		});

		return $cache;
	}
}