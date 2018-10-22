<?php

/**
 * Auto created by artisan on 25.09.2018 at 19:54
 * @author Champa
 */

namespace App\Packages\System;

use Cache;
use DB;

class Time
{
	const HOUR = 3600;

	const DAY = 86400;

	const WEEK = 604800;

	public static function HoursToSeconds(int $hours) : int {

		return $hours * 3600;
	}
}