<?php

/**
 * Auto created by artisan on 22.10.2018 at 11:35
 * @author Champa
 */

namespace App\Packages\Core;

class API
{

	const FAIL = 0;
	const SUCCESS = 1;

	public static function response($code, $payload) : string {

		$response = [
			'code' => $code,
			'payload' => $payload
		];

		return json_encode($response);
	}
}