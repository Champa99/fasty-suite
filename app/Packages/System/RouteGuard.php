<?php

/**
 * Auto created by artisan on 28.10.2018 at 12:17
 * @author Champa
 */

namespace App\Packages\System;

use User;

class RouteGuard
{

	/**
	 * Hold the user group id here
	 */

	private $userGroup = 0;

	/**
	 * Hold user permissions here
	 */

	private $userPerm = [];

	/**
	 * Check if the user has the required permission
	 */

	public function perm(int $perm_group, int $perm) : bool {

		if($this->getUserGroup() === 1)
			return true;

		if(isset($this->userPerm[$perm_group][$perm]) && $this->userPerm[$perm_group][$perm])
			return true;

		return false;
	}

	/**
	 * Get the value of userPermissions
	 */ 
	public function getUserPerm()
	{
		return $this->userPermissions;
	}

	/**
	 * Set the value of userPermissions
	 *
	 * @return  self
	 */ 
	public function setUserPerm($userPermissions)
	{
		$this->userPermissions = $userPermissions;

		return $this;
	}

	/**
	 * Get the value of userGroup
	 */ 
	public function getUserGroup()
	{
		return $this->userGroup;
	}

	/**
	 * Set the value of userGroup
	 *
	 * @return  self
	 */ 
	public function setUserGroup($userGroup)
	{
		$this->userGroup = $userGroup;

		return $this;
	}
}