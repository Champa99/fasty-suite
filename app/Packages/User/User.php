<?php

/**
 * Auto created by artisan on 25.09.2018 at 12:42
 * @author Champa
 */

namespace App\Packages\User;

use Cache;
use DB;

class User
{

	/**
	 * Holds user data
	 */

	private static $info;
	/**
	 * Sets the user data
	 */

	public static function setInfo(array $info) : void {

		self::$info = $info;
	}

	public static function info() {

		return self::$info;
	}
}