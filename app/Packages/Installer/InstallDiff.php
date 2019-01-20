<?php

/**
 * Auto created by artisan on 06.01.2019 at 19:22
 * @author Champa
 */

namespace App\Packages\Installer;

use Cache;
use DB;
use App\Packages\System\CacheVisor;

class InstallDiff
{
	/**
	 * @var array
	 */
	private $migrations = null;

	/**
	 * @var array
	 */
	private $controllers = null;

	/**
	 * @var array
	 */
	private $packages = null;

	/**
	 * @var array
	 */
	private $views = null;

	/**
	 * @var array
	 */
	private $themes = null;

	/**
	 * @var array
	 */
	private $response = null;

	/**
	 * @var array
	 */
	private $panicList = [
		'packages' => [ //Folders
			'Core',
			'System',
			'Installer',
			'Transport'
		],
		'controllers' => [ //Files
			'AdminController.php',
			'AdminModuleInstaller.php'
		]
	];

	/**
	 * Constructor
	 */
	public function __construct($files) {
		
		if(isset($files->migrations))
			$this->migrations = $files->migrations;
		
		if(isset($files->controllers))
			$this->controllers = $files->controllers;

		if(isset($files->packages))
			$this->packages = $files->packages;

		if(isset($files->views))
			$this->views = $files->views;

		if(isset($files->themes))
			$this->themes = $files->themes;

		$this->response = [
			'panic' => [],
			'conflict' => [],
			'add' => []
		];
	}

	/**
	 * Generate the difference status
	 */
	public function differentiate() : void {

		$this->controllerDiff();
		$this->packagesDiff();
	}

	/**
	 * Checks if there is any panic caused by the module
	 */
	public function isPanicking() : bool {

		return (count($this->response['panic']) > 0);
	}

	/**
	 * Check the differences for the controllers
	 */
	private function controllerDiff() : void {

		if($this->controllers !== null) {
			$dir = 'app/Http/Controllers/';

			foreach($this->controllers AS $controller) {
				
				if(in_array($controller, $this->panicList['controllers'])) {

					array_push($this->response['panic'], $dir.$controller);
					continue;
				}

				if(file_exists(base_path('/app/Http/Controllers/'. $controller))) {

					array_push($this->response['conflict'], $dir.$controller);
					continue;
				}

				array_push($this->response['add'], $dir.$controller);
			}
		}
	}

	/**
	 * Check the differences for the packages
	 */
	private function packagesDiff() : void {

		if($this->packages !== null) {
			$dir = 'app/Packages/';

			foreach($this->packages AS $package) {
				
				$packageFolder = explode("/", $package);
				$packageFolder = $packageFolder[0];

				if(in_array($packageFolder, $this->panicList['packages'])) {

					array_push($this->response['panic'], $dir.$package);
					continue;
				}

				if(file_exists(base_path('/app/Packages/'. $package))) {

					array_push($this->response['conflict'], $dir.$package);
					continue;
				}

				array_push($this->response['add'], $dir.$package);
			}
		}
	}

	/**
	 * Get the value of response
	 *
	 * @return  array
	 */
	public function getResponse() : ?array {

		return $this->response;
	}
}