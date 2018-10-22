<?php

/**
 * Auto created by artisan on 19.10.2018 at 14:12
 * @author Champa
 */

namespace App\Packages\Core;

class CacheVisor
{

	/**
		 * 3 types of cache
		 * 
		 * 		MINOR  - for data that is changed often
		 * 
		 * 		NORMAL - for data that is changed on a week basis maybe?
		 * 
		 * 		HIGH - for data that is rarely changed so we kinda hard-cache it
		 */

	public static function time(string $type = 'NORMAL') : int {

		$cacheMode = readConfig()->cache_mode;
		$cacheTime = 0;

		if($cacheMode === 'off')
			return 0;

		switch($type) {

			case 'MINOR':
				if($cacheMode === 'normal') $cacheTime = 60;
				else if($cacheMode === 'high') $cacheTime = 300;
				break;

			case 'NORMAL':
				if($cacheMode === 'normal') $cacheTime = 10080;
				else if($cacheMode === 'high') $cacheTime = 17280;
				break;

			case 'HIGH':
				if($cacheMode === 'normal') $cacheTime = 34560;
				else if($cacheMode === 'high') $cacheTime = 43200;
				break;
		}

		return $cacheTime;
	}
}