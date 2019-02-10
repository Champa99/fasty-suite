<?php

/**
 * Auto created by artisan on 07.11.2018 at 14:43
 * @author Champa
 */

namespace App\Packages\Core;

use Cache;
use DB;
use App\Packages\System\CacheVisor;

class ButtonManager
{

	/**
	 * List of all our buttons
	 */

	static $buttonList = [];

	/**
	 * List of all subbuttons
	 */

	static $subButtonList = [];

	/**
	 * Button getter
	 */

	public static function getButtonList() {

		if(empty(self::$buttonList))
			self::loadButtons();

		return self::$buttonList;
	}

	/**
	 * Subbutton getter
	 */

	public static function getSubButtonList() {

		if(empty(self::$subButtonList))
			self::loadButtons();

		return self::$subButtonList;
	}

	/**
	 * Load the buttons from the cache/database
	 */

	private static function loadButtons() {

		$data = Cache::remember('buttonList', CacheVisor::time(), function() {
			
			$buttons['main'] = [];
			$buttons['sub'] = [];

			$q = "SELECT id, lang_key, icon, url, parent FROM core_buttons";

			$qData = DB::select($q);

			if(isset($qData)) {

				foreach($qData AS $button) {

					if($button->parent === null) {
						
						array_push($buttons['main'], $button);
					} else {

						if(!isset($buttons['sub'][$button->parent])) {

							$buttons['sub'][$button->parent] = [];
						}

						array_push($buttons['sub'][$button->parent], $button);
					}
				}
			}

			return $buttons;
		});

		self::$buttonList = $data['main'];
		self::$subButtonList = $data['sub'];
	}
}