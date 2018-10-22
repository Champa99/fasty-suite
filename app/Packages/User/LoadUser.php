<?php

/**
 * Auto created by artisan on 25.09.2018 at 12:40
 * @author Champa
 */

namespace App\Packages\User;

use Cache;
use DB;
use App\Packages\System\Time;

class LoadUser
{

	/**
	 * Returnes user info from the database
	 */

	public static function info(int $userId) : ?array {

		$data = Cache::remember('user_'. $userId .'_info', Time::WEEK, function() use ($userId) {

			$q = "SELECT ";
		});
	}
}