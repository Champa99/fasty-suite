<?php

/**
 * Auto created by artisan on 25.09.2018 at 19:45
 * @author Champa
 */

namespace App\Packages\User;

use Cache;
use DB;
use App\Packages\System\CacheVisor;

class LoadGroup
{

	/**
	 * Holds the group id
	 * @type int
	 */

	private $groupId;

	public function __construct(int $groupId) {

		$this->groupId = $groupId;
	}

	/**
	 * Loads the group permissions into the array
	 */

	public function permissions() : ?array {

		$data = Cache::remember('group_'. $this->groupId, CacheVisor::time('HIGH'), function () {
			
			$q = "SELECT perm_group, perm FROM core_group_permissions WHERE group_id = :id";

			$qData = DB::select($q, ['id' => $this->groupId]);

			return $this->groupPermissions($qData);
		});

		return $data;
	}

	private function groupPermissions(array $permissions) : ?array {

		$tmp = [];

		foreach($permissions AS $item) {

			// If we havent set the subarray properly, we create it
			if(!isset($tmp[$item->perm_group])) {

				$tmp[$item->perm_group] = [];
			}

			// Add the item to our array (the perm)
			$tmp[$item->perm_group][$item->perm] = true;
		}

		return $tmp;
	}

	/**
	 * Get the value of groupId
	 */ 
	public function getGroupId() {

		return $this->groupId;
	}

	/**
	 * Set the value of groupId
	 *
	 * @return  self
	 */ 
	public function setGroupId($groupId) {

		$this->groupId = $groupId;

		return $this;
	}
}