<?php

/**
 * Auto created by artisan on 21.10.2018 at 11:07
 * @author Champa
 */

namespace App\Packages\User;

use Cache;
use DB;
use App\Packages\System\CacheVisor;
use App\Packages\System\Time;

class Session
{

	private $userId;

	public function __construct(int $userId) {
		
		$this->userId = $userId;
	}

	/**
	 * Returns a hashed version of the token
	 */

	public static function hashToken(string $token) : string {

		return hash('sha256', $token);
	}

	/**
	 * Generates a new session id
	 * 
	 * @return array - hashed session id and the plain one
	 */

	protected function generateId() : array {

		$cstrong = true;
		$time = time();
		$lastNum = ($time % 10000) * rand(1, 99);
		$bytes = openssl_random_pseudo_bytes(15, $cstrong);

		$key = str_random(30) . (int) ($time / 10000 + rand(1000, 3000)) . str_random(15) .'111'. str_random(60) . $lastNum . bin2hex($bytes);

		//dump(hash_equals($hashed, hash('sha256', $key)));

		$session = [
			'id' => $key,
			'hashed' => hash('sha256', $key)
		];

		return $session;
	}

	/**
	 * Creates the user session and saves it to the database
	 * 
	 * @param remember - create a persistant session or a temp one
	 */

	public function create(bool $remember = false) {

		$q = "INSERT INTO core_sessions (id, user_id, created, expires, agent, os, browser, browser_ver, ip) VALUES
		(:id, :user_id, :created, :expires, :agent, :os, :browser, :browser_ver, :ip)";

		$session = $this->generateId();
		$browser = getBrowser();

		$length = ($remember ? '+1 year' : '+1 day');

		DB::insert($q, [
			'id'			=>	$session['hashed'],
			'user_id'		=>	$this->userId,
			'created'		=>	date('Y-m-d H:i:s'),
			'expires'		=>	date('Y-m-d H:i:s', strtotime($length)),
			'agent'			=>	$browser['userAgent'],
			'os'			=>	getOS(),
			'browser'		=>	$browser['name'],
			'browser_ver'	=>	$browser['version'],
			'ip'			=>	getIp()
		]);

		return $session['id'];
	}

	public function isValid(string $token) : bool {

		if($token != null) {

			$token = hash('sha256', $token);

			$q = "SELECT browser, browser_ver, ip FROM core_sessions WHERE id = :id LIMIT 1";

			$data = DB::select($q, [
				'id'	=>	$token
			]);

			// Check if the session even exists
			if(isset($data[0]) && !empty($data)) {

				$browser = getBrowser();
				$ip = getIp();
				$session = $data[0];

				// Make sure there isn't any forgery
				if($session->browser == $browser['name'] && $session->browser_ver == $browser['version'] && $session->ip == $ip) {

					// If everything is good
					return true;
				}
			}
		}

		// Houston, we have a problem..
		return false;
	}
}