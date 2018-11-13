<?php

/**
 * Auto created by artisan on 12.11.2018 at 13:26
 * @author Champa
 */

namespace App\Packages\Transport;

use Cache;
use DB;
use App\Packages\System\CacheVisor;

class LoadNews
{

	/**
	 * The server we're gonna connect to get the news
	 */

	private static $newsServer = '';

	/**
	 * Connect to the remote server
	 */

	private static function connect() {

		return true;
	}

	/**
	 * Try to get the news from the server
	 */

	public static function try(int $offset = 0, int $limit = 7) {

		// Dummy news

		$arr = [];

		for($i = 0; $i < $limit; $i ++) {

			$article = [
				'id' => $i,
				'timestamp' => 1542029729,
				'urgent' => true,
				'title' => 'Update the platform ASAP',
				'content' => 'In ac purus sed lectus porta dapibus non ut diam. Praesent a sem ut enim maximus dignissim non eget felis.
				Pellentesque felis odio, rutrum nec tristique eu, sodales ut magna. Proin eget ante dignissim, rhoncus nibh at, viverra erat.
				Praesent id sodales ex, ac hendrerit nibh. Vivamus in tellus leo.
				Fusce vestibulum diam neque, et lacinia nibh accumsan a.
				Aenean vehicula risus a ex sodales pulvinar. Vivamus commodo felis nec tempus interdum. Orci
				varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed sollicitudin turpis felis.
				Cras ut nunc ipsum. Sed mi sapien, varius id tincidunt sed, commodo quis justo.
				Nulla ut scelerisque tortor, eu convallis elit. Nam eu commodo velit.
				Sed purus enim, vehicula euismod rhoncus id, mollis nec neque. Aenean sit amet lobortis eros.'
			];

			array_push($arr, $article);
		}

		return $arr;
	} 
}