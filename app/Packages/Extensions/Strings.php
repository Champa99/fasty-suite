<?php

/**
 * Auto created by artisan on 23.05.2018 at 20:37
 * @author Champa
 */

namespace App\Packages\Extensions;

class Strings
{
	public static function lang_rep(string $source, ?string $lang) : string {

		switch($lang) {

			case 'bosnian':

				$replacement = [
					'č' => 'c', 'Č' => 'C',
					'ć' => 'c', 'Ć' => 'C',
					'š' => 's', 'Š' => 'S',
					'đ' => 'd', 'Đ' => 'D',
					'ž' => 'z', 'Ž' => 'Z'
				];

				break;

			default:
				$replacement = [];
				break;
		}

		foreach($replacement as $i => $u) {

			$source = mb_eregi_replace($i, $u, $source);
		}

		return $source;
	}

	public static function str_replace_first($find, $replace, $content)
	{
		$find = '/'.preg_quote($find, '/').'/';

		return preg_replace($find, $replace, $content, 1);
	}
}