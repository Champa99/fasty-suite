<?php

/**
 * Auto created by artisan on 25.09.2018 at 12:40
 * @author Champa
 */

namespace App\Packages\User;

use Cache;
use DB;
use App\Packages\System\CacheVisor;

class LoadUser
{

	/**
	 * Holds the session we want to load the user from
	 */

	private $session_id;

	/**
	 * Returnes user info from the database
	 */

	public function loadInfo() : ?\stdClass {

		$data = Cache::remember('user_'. $this->session_id .'_info', CacheVisor::time(), function() {

			$q = "SELECT core_users.id, core_users.username, core_users.avatar, core_users.group_id
					FROM core_users INNER JOIN core_sessions ON
					core_users.id = core_sessions.user_id
					WHERE core_sessions.id = :session_id
					LIMIT 1";

			return DB::select($q, [
				'session_id' => $this->session_id
			]);
		});

		if(isset($data[0])) {

			return $data[0];
		}
	}

	/**
	 * Session id setter
	 */

	public function setSession(string $session) {

		$this->session_id = $session;

		return $this;
	}
}