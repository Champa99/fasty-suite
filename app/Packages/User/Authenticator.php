<?php

/**
 * Auto created by artisan on 19.10.2018 at 14:09
 * @author Champa
 */

namespace App\Packages\User;

use Cache;
use DB;
use App\Packages\System\Time;
use Hash;

class Authenticator
{

	private $user;

	private $password;

	public function __construct(string $user, string $password) {

		$this->user = $user;
		$this->password = $password;
	}

	/**
	 * Attempt to authenticate the user
	 * @return mixed bool/integer
	 */

	public function attempt() {

		$q = "SELECT id, password FROM core_users WHERE username = :user OR email = :email LIMIT 1";
		$data = DB::select($q, [
			'user' => $this->user,
			'email' => $this->user
		]);

		if (isset($data[0]) && isset($data[0]->password)) {

			// If a user exists...

			$hashedPassword = $data[0]->password;

			if (Hash::check($this->password, $hashedPassword)) {

				// If the passwords are the same

				return $data[0]->id;
			}
		}

		return false;
	}
}