<?php

/**
 * Auto created by artisan on 24.09.2018 at 22:43
 * @author Champa
 */

namespace App\Packages\User;

use Cache;
use DB;

class Group
{

	/**
	 * Holds the permissions for the given group
	 * @type array
	 */

	private static $permissions = [];

	/**
	 * Sets the group permissions
	 */

	public static function setPermissions($permissions) : void {

		self::$permissions = $permissions;
	}

	/**
	 * Determines if a group can use a specific feature (the user group has the permissions to do so)
	 */

	public static function canUse(int $permGroup, int $perm) : bool {

		return isset(self::$permissions[$permGroup]->$perm);
	} 
}