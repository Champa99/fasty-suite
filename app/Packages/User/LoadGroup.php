<?php

/**
 * Auto created by artisan on 25.09.2018 at 19:45
 * @author Champa
 */

namespace App\Packages\User;

use Cache;
use DB;

class LoadGroup
{
	/**
	 * Loads the group permissions into the array
	 */

	public static function permissions(int $groupId) : ?array {

		$data = Cache::rememberForever('group_'. $groupId, function() use ($groupId) {

			$q = "SELECT perm_group, perm FROM core_group_permissions WHERE group_id = :id";

			$qData = DB::select($q, ['id' => $groupId]);

			return \App\Packages\Extensions\Arrays::sort($qData, 'perm_group');
		});

		return $data;
	}
}