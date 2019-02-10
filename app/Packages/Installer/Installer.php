<?php

/**
 * Auto created by artisan on 10.01.2019 at 12:42
 * @author Champa
 */

namespace App\Packages\Installer;

use DB;
use Artisan;
use Storage;
use Illuminate\Filesystem\Filesystem;

class Installer
{

	/**
	 * @var string
	 */
	protected $moduleName;

	/**
	 * @var InstallDiff
	 */
	protected $installDiff;

	/**
	 * @var object
	 */
	protected $moduleInfo;

	/**
	 * @var array
	 */
	protected $installStatus = [
		'errors' => [],
		'updates' => []
	];

	protected $reservedNames = [
		'API',
		'Core',
		'Extensions',
		'Installer',
		'System',
		'Transport',
		'User'
	];

	/**
	 * Constructor
	 */
	public function __construct(string $moduleName) {

		$this->moduleName = $moduleName;
	}

	/**
	 * Prepare the installer, and calculate the differences
	 */
	protected function prepare() {

		$path = storage_path('platform/installer/'. $this->moduleName);

		if(file_exists($path) && is_dir($path) && file_exists($path . '/installer.json')) {

			$this->moduleInfo = file_get_contents($path . '/installer.json');
			$this->moduleInfo = json_decode($this->moduleInfo);

			$this->installDiff = new InstallDiff($this->moduleInfo->files);

			$this->installDiff->differentiate();
		}
	}

	/**
	 * Start the installation of a module
	 * 
	 * @return - the exit code
	 */
	public function install() : int {

		// Prepare the installation process
		$this->prepare();

		if($this->installDiff->isPanicking()) {

			// If the system is panicking, immediately return an error
			return 1;
		}

		if(in_array($this->moduleName, $this->reservedNames)) {

			// If the module name is a reserved platform name, throw an error
			return 2;
		}

		if(!$this->installMigrations()) return 3; // If the migrations failed to install
		if(!$this->installControllers()) return 4; // If by some chance we failed to install the controllers
		if(!$this->installPackages()) return 5; // If the packages failed to install
		if(!$this->installViews()) return 6; // If the views failed to install (dont see why it would happen...)
		if(!$this->installThemes()) return 7; // If the theme files failed to install (also dont see why)

		// Insert the module information into the database
		$this->addToDatabase();

		// Insert the routes of the module
		$this->insertRoutes();

		return 0;
	}

	// Installer functions

	/**
	 * Installs the theme files
	 * 
	 * Returns true on success
	 */
	protected function installThemes() : bool {

		$platThemePath = public_path('themes/'. $this->moduleInfo->theme);
		$cssPath = $platThemePath .'/css';
		$jsPath = $platThemePath .'/js';
		$imgPath = $platThemePath .'/images';

		$fileSystem = new Filesystem();

		// Check if a folder/file with the theme name already exists, if not, create it
		if(!$fileSystem->exists($platThemePath) || !$fileSystem->isDirectory($platThemePath)) {

			$fileSystem->delete($platThemePath);
			$fileSystem->makeDirectory($platThemePath);
		}

		// Create the css folder if it doesnt exist and install the css files
		if(isset($this->moduleInfo->files->themes->css) && !empty($this->moduleInfo->files->themes->css)) {

			if(!$fileSystem->exists($cssPath) || !$fileSystem->isDirectory($cssPath)) {

				$fileSystem->delete($cssPath);
				$fileSystem->makeDirectory($cssPath);
			}

			// Install the css files
			foreach($this->moduleInfo->files->themes->css AS $cssFile) {

				$cssModPath = storage_path('platform/installer/'. $this->moduleName . '/themes/css/'. $cssFile);

				$fileSystem->copy($cssModPath, $cssPath .'/'. $cssFile);
				array_push($this->installStatus['updates'], $cssPath .'/'. $cssFile);
			}
		}

		// Create the js folder if it doesnt exist and install the js files
		if(isset($this->moduleInfo->files->themes->js) && !empty($this->moduleInfo->files->themes->js)) {

			if(!$fileSystem->exists($jsPath) || !$fileSystem->isDirectory($jsPath)) {

				$fileSystem->delete($jsPath);
				$fileSystem->makeDirectory($jsPath);
			}
			
			// Install the js files
			foreach($this->moduleInfo->files->themes->js AS $jsFile) {

				$jsModPath = storage_path('platform/installer/'. $this->moduleName . '/themes/js/'. $jsFile);

				$fileSystem->copy($jsModPath, $jsPath .'/'. $jsFile);
				array_push($this->installStatus['updates'], $jsPath .'/'. $jsFile);
			}
		}

		// Create the images folder if it doesnt exist and install the image files
		if(isset($this->moduleInfo->files->themes->images) && !empty($this->moduleInfo->files->themes->images)) {

			if(!$fileSystem->exists($imgPath) || !$fileSystem->isDirectory($imgPath)) {

				$fileSystem->delete($imgPath);
				$fileSystem->makeDirectory($imgPath);
			}
			
			// Install the image files
			foreach($this->moduleInfo->files->themes->images AS $imgFile) {

				$imgModPath = storage_path('platform/installer/'. $this->moduleName . '/themes/images/'. $imgFile);

				$fileSystem->copy($imgModPath, $imgPath .'/'. $imgFile);
				array_push($this->installStatus['updates'], $imgPath .'/'. $imgFile);
			}
		}

		return true;
	}

	/**
	 * Installs the views
	 * 
	 * Returns true on success
	 */
	protected function installViews() : bool {

		$platViewsPath = base_path('resources/views/'. $this->moduleName);

		$fileSystem = new Filesystem();

		// Check if a folder/file with the module name already exists, if not, create it
		if(!$fileSystem->exists($platViewsPath) || !$fileSystem->isDirectory($platViewsPath)) {

			$fileSystem->delete($platViewsPath);
			$fileSystem->makeDirectory($platViewsPath);
		}

		foreach($this->moduleInfo->files->views AS $viewFile) {
		
			$modViewPath = storage_path('platform/installer/'. $this->moduleName . '/views//'. $viewFile);

			$fileSystem->copy($modViewPath, $platViewsPath .'/'. $viewFile);
			array_push($this->installStatus['updates'], $platViewsPath .'/'. $viewFile);
		}

		return true;
	}

	/**
	 * Installs the packages
	 * 
	 * Returns true on success
	 */
	protected function installPackages() : bool {

		$platPkgPath = app_path('Packages/'. $this->moduleName);

		$fileSystem = new Filesystem();

		// Check if a folder/file with the module name already exists, if not, create it
		if(!$fileSystem->exists($platPkgPath) || !$fileSystem->isDirectory($platPkgPath)) {

			$fileSystem->delete($platPkgPath);
			$fileSystem->makeDirectory($platPkgPath);
		}

		foreach($this->moduleInfo->files->packages AS $packageFile) {

			$modPkgPath = storage_path('platform/installer/'. $this->moduleName . '/packages//'. $packageFile);

			$fileSystem->copy($modPkgPath, $platPkgPath .'/'. $packageFile);
			array_push($this->installStatus['updates'], $platPkgPath .'/'. $packageFile);
		}

		return true;
	}

	/**
	 * Installs the controllers
	 * 
	 * Returns true on success
	 */
	protected function installControllers() : bool {

		$platContrPath = app_path('Http/Controllers');
		$fileSystem = new Filesystem();

		$pathToModConts = $platContrPath .'/'. $this->moduleName;

		// Check if a folder/file with the module name already exists, if not, create it
		if(!$fileSystem->exists($pathToModConts) || !$fileSystem->isDirectory($pathToModConts)) {

			$fileSystem->delete($pathToModConts);
			$fileSystem->makeDirectory($pathToModConts);
		}


		foreach($this->moduleInfo->files->controllers AS $controllerFile) {

			$modContrPath = storage_path('platform/installer/'. $this->moduleName . '/controllers//'. $controllerFile);

			$fileSystem->copy($modContrPath, $pathToModConts .'/'. $controllerFile);
			array_push($this->installStatus['updates'], $pathToModConts .'/'. $controllerFile);
		}

		return true;
	}

	/**
	 * Installs the migrations
	 * 
	 * Returns true on success
	 */
	protected function installMigrations() : bool {

		// Tells wheter or not the module migrations mangle with core_ tables
		$noPanic = true;

		foreach($this->moduleInfo->files->migrations AS $migrationFile) {

			$modMigPath = storage_path('platform/installer/'. $this->moduleName . '/migrations//'. $migrationFile);
			$migrationContent = file_get_contents($modMigPath);

			if(preg_match("/core_/i", $migrationContent, $match)) {

				// The module is trying to mess with the core tables, we can start panicking now...
				$noPanic = false;

				// Add this file to the list of files which are causing errors
				array_push($this->installStatus['errors'], $migrationFile);
			}
		}

		// Check if we're panicking
		if($noPanic) {

			// Creates an instance of the filesystem
			$fileSystem = new Filesystem();

			$pathToModMigs = database_path('migrations') .'/'. $this->moduleName;

			// Check if a folder/file with the module name already exists, if not, create it
			if(!$fileSystem->exists($pathToModMigs) || !$fileSystem->isDirectory($pathToModMigs)) {

				$fileSystem->delete($pathToModMigs);
				$fileSystem->makeDirectory($pathToModMigs);
			}

			// Move the migration files to the platform folder...
			foreach($this->moduleInfo->files->migrations AS $migrationFile) {
				
				$modMigPath = storage_path('platform/installer/'. $this->moduleName . '/migrations//'. $migrationFile);

				$fileSystem->copy($modMigPath, $pathToModMigs .'/'. $migrationFile);
				array_push($this->installStatus['updates'], $pathToModMigs .'/'. $migrationFile);
			}

			// Dump autoload files
			Artisan::call('dump-autoload');

			// If everythings good, call the migration service lol
			Artisan::call('migrate');
		}

		return $noPanic;
	}

	/**
	 * Insert the module information into the database
	 */
	protected function addToDatabase() : void {

		$q = "INSERT IGNORE INTO core_modules (name, version, cycle, type, author, website, installed_on, updated_on)
		VALUES (:name, :version, :cycle, :type, :author, :website, :currDate, :currDate2)";

		$time = time();

		DB::insert($q, [
			'name'		=>	$this->moduleInfo->name,
			'version'	=>	$this->moduleInfo->version,
			'cycle'		=>	$this->moduleInfo->cycle,
			'type'		=>	$this->moduleInfo->type,
			'author'	=>	$this->moduleInfo->author,
			'website'	=>	$this->moduleInfo->website,
			'currDate'	=>	$time,
			'currDate2'	=>	$time
		]);
	}

	/**
	 * Insert the routes to the database
	 */
	protected function insertRoutes() : void {

		$routes = (array) $this->moduleInfo->routes;

		if(!empty($routes)) {

			DB::transaction(function () use ($routes) {

				foreach($routes AS $path => $property) {

					$q = "INSERT  IGNORE INTO core_routes (method, uri, controller, perm_group, perm) VALUES
					(:method, :uri, :controller, :perm_group, :perm)";

					DB::insert($q, [
						'method'		=>	$property->method,
						'uri'			=>	$path,
						'controller'	=>	$property->controller,
						'perm_group'	=>	$property->perm_group,
						'perm'			=>	$property->perm
					]);
				}
			}, 3);
		}
	}

	/**
	 * Get the value of installStatus
	 *
	 * @return  array
	 */
	public function getInstallStatus() : ?array {

		return $this->installStatus;
	}
}