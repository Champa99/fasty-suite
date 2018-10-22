<?php

/**
 * Auto created by artisan on 28.05.2018 at 15:02
 * @author Champa
 */

namespace App\Packages\Extensions;

class Colors
{
	public static function createRandom(?int $min = 0, ?int $max = 255) : string {

		$r = rand($min, $max);
		$g = rand($min, $max);
		$b = rand($min, $max);

		return 'rgba('. $r .', '. $g .', '. $b .', 1)';
	}
}