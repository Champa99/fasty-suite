<?php

/*
	Platform helpers used for shorthand syntax and overall better productivity
*/

/**
	Config helpers
 */

 #region
if (!function_exists('themeComponent')) {

	function themeComponent(string $component) : string {

		return \App\Packages\Core\ConfigManager::themeComponent($component);
	}
}

if (!function_exists('jsComponent')) {

	function jsComponent(string $component) : string {

		$comp = \App\Packages\Core\ConfigManager::themeComponent($component .'.js');

		return '<script src="'. $comp .'"></script>';
	}
}

if (!function_exists('cssComponent')) {

	function cssComponent(string $component) : string {

		$comp = \App\Packages\Core\ConfigManager::themeComponent($component .'.css');

		return '<link rel="stylesheet" type="text/css" href="'. $comp .'" media="screen,projection">';
	}
}

if (!function_exists('readConfig')) {

	function readConfig() : object {

		return \App\Packages\Core\ConfigManager::read();
	}
}
 #endregion

 /**
	Request helpers
  */

#region
if (!function_exists('getBrowser')) {

	function getBrowser() : array {

		return App\Packages\System\Request::getBrowser();
	}
}

if (!function_exists('getIp')) {

	function getIp() : string {

		return App\Packages\System\Request::getIp();
	}
}

if (!function_exists('getOS')) {

	function getOS() : string {

		return App\Packages\System\Request::getOS();
	}
}
#endregion