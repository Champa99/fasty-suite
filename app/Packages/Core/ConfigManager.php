<?php

/**
 * Auto created by artisan on 26.09.2018 at 14:03
 * @author Champa
 */

namespace App\Packages\Core;

use Cache;
use DB;
use App\Packages\System\Time;

class ConfigManager
{

	/**
	 * Default settings
	 */

	private static $defaults = [];

	/**
	 * Holds the platform configuration
	 * @type array
	 */

	private static $config = [];

	/**
	 * Loads the default configuration
	 */

	private static function initDefaults() {

		self::$defaults = (object) [
			'theme' => 'Vivica',
			'community_name' => config('app.name'),
			'cache_mode' => 'normal',
			'login_redir' => '/'
		];
	}

	/**
	 * Loads the configuration from the database/cache
	 */

	public static function load() {

		self::initDefaults();

		self::$config = Cache::remember('config_platforma', Time::HoursToSeconds(0), function() {

			$q = "SELECT setting, val FROM core_config";

			$data = DB::select($q);

			$data = \App\Packages\Extensions\Arrays::stdToArray($data);
			$tmp = new \stdClass();

			foreach($data AS $item) {

				$obj = $item['setting'];
				$tmp->$obj = $item['val'];
			}

			unset($data);

			$tmp = (object) array_merge((array) self::$defaults, (array) $tmp);

			return $tmp;
		});
	}

	/**
	 * Config getter
	 */

	public static function read() : object {

		return self::$config;
	}

	/**
	 * Defaults getter
	 */

	public static function defaults() {

		return self::$defaults;
	}

	/**
	 * Returns the current theme (if it doesnt exist, the default is returned)
	 */

	public static function themeComponent(string $module) : string {

		$module = htmlentities($module);

		$path = 'themes/'. self::read()->theme .'/'. $module;

		// If a module exists, return it
		if(file_exists($path)) {

			return $path;
		}

		// Otherwise, return the default theme module
		return 'themes/'. self::defaults()->theme .'/'. $module;
	}
}