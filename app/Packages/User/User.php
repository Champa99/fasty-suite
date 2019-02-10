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

	private $info;

	/**
	 * Holds the group perm info
	 */

	private $groupInfo;

	/**
	 * The LoadUser component
	 */

	private $userLoader;

	/**
	 * LoadGroup component
	 */

	private $groupLoader;

	public function __construct() {

		$this->userLoader = new LoadUser();
	}

	/**
	 * Loads the info from the userLoader component
	 * 
	 * @param $session - the session we want to load the user from
	 */

	public function loadInfo(string $session) {

		// Set the session for the userLoader component
		$this->userLoader->setSession($session);
		$info = $this->userLoader->loadInfo();

		// Set the loaded info to our class property
		$this->setInfo($info);

		// Load the group data
		$group_id = $this->getInfo()->group_id;
		$this->groupLoader = new LoadGroup($group_id);

		$this->groupInfo = $this->groupLoader->permissions();

		return $this;
	}

	/**
	 * Get the value of info
	 */ 
	public function getInfo() {

		return $this->info;
	}

	/**
	 * Set the value of info
	 *
	 * @return  self
	 */ 
	public function setInfo($info) {

		$this->info = $info;

		return $this;
	}

	/**
	 * Get the value of groupInfo
	 */ 
	public function getGroupInfo() {

		return $this->groupInfo;
	}

	/**
	 * Set the value of groupInfo
	 *
	 * @return  self
	 */ 
	public function setGroupInfo($groupInfo) {

		$this->groupInfo = $groupInfo;

		return $this;
	}
}