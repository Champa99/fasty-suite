<?php

namespace App\Packages\Extensions;

class Arrays
{

	/**
	 * Sorts an array based upon the given key
	 * @param forSort - the array we want to sort
	 * @param key - the key we want to sort it upon
	 * @param arrayBased is the array based on a array/array or array/stdClass
	 */

	public static function sort(array &$forSort, string $key, bool $arrayBased = false) : void {

		$size = count($forSort);

		if(!$arrayBased) {

			for($i = 0; $i < $size; $i++) {

				for($j = $i + 1; $j < $size; $j++) {

					if($forSort[$i]->$key < $forSort[$j]->$key) {

						$c = $forSort[$i];
						$forSort[$i] = $forSort[$j];
						$forSort[$j] = $c;
					}
				}
			}
		} else {

			for($i = 0; $i < $size; $i++) {

				for($j = $i + 1; $j < $size; $j++) {

					if($forSort[$i][$key] < $forSort[$j][$key]) {

						$c = $forSort[$i];
						$forSort[$i] = $forSort[$j];
						$forSort[$j] = $c;
					}
				}
			}
		}
	}

	/**
	 * Converts an hashmap array to a normal int index array
	 */

	public static function convertToInt(array &$array) : void {

		$i = 0;
		$tmp = [];

		foreach($array AS $key => $val) {

			$tmp[$i] = $val;
			$i ++;
			unset($array[$key]);
		}

		$array = $tmp;
		unset($tmp);

		return;
	}

	public static function groupByVal(array $array, $val, bool $arrayBased = false) {

		$tmp = [];

		if(!$arrayBased) {

			foreach($array AS $item) {
				dump("a");
				if(!isset($tmp[$item->$val])) {

					$tmp[$item->$val] = [];
				}
				
				array_push($tmp[$item->$val], $item);
			}
		} else {

			foreach($array AS $item) {

				if(!isset($tmp[$item[$val]])) {

					$tmp[$item[$val]] = [];
				}
				
				array_push($tmp[$item[$val]], $item);
			}
		}

		$array = $tmp;
		unset($tmp);

		return $array;
	}

	/**
	 * Converts an array/object to an array/array
	 */

	public static function stdToArray($stdArray) {
		
		foreach($stdArray AS $key => $item) {

			$stdArray[$key] = (array) $stdArray[$key];
		}

		return $stdArray;
	}
}