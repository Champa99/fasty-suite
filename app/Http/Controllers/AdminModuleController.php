<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zip;
use Storage;
use App\Packages\System\Uploader;
use App\Packages\Installer\{Installer, InstallDiff};
use Illuminate\Filesystem\Filesystem;
use App\Packages\Modules\Modules;

class AdminModuleController extends Controller
{

	public function index(Request $request) {

		$modules = new Modules();

		return view('admin.modules', [
			'modules' => $modules->getAll()
		]);
	}

	public function installer(Request $request, ?int $step = null) {
		
		if($request->isMethod('get')) {

			return view('admin.moduleInstaller');
		}

		if($request->isMethod('post')) {

			if($step === null || $step === 1) {
				// If its the first installation step

				$file = $request->file()['file'];
				$uploader = new Uploader($file, 'PKG');

				// Lets upload the module to the server
				$uploader->upload();

				// And the extract it
				$zip = Zip::open(storage_path('platform/installer/packages/'. $uploader->getFileName()));
				$zip->extract(storage_path('platform/installer'));

				// Lets get the module information from the installer.json
				$moduleName = str_replace('.pkg.zip', '', $uploader->getFileName());
				$info = file_get_contents(storage_path('platform/installer/'. $moduleName . '/installer.json'));
				$info = json_decode($info);

				// Get the install differences
				$diff = new InstallDiff($info->files);
				$diff->differentiate();

				// After that, we can display the module information to the user
				return view('admin.moduleInformation', [
					'moduleInfo' => $info,
					'diff' => $diff->getResponse(),
					'moduleName' => $moduleName
				]);
			} else if($step == 2) {
				// The second installation step
	
				// Get the module name
				$moduleName = $request->input('m_name');

				// Initiate the installer
				$installer = new Installer($moduleName);
				$code = $installer->install();

				return view('admin.moduleInstallStatus', [
					'moduleName' => $moduleName,
					'code' => $code,
					'status' => $installer->getInstallStatus()
				]);
			}
		}
	}

	public function installerRemove(Request $request) {

		// Remove the module from the installation

		$module = $request->input('m_name');
		$path = 'storage/platform/installer/'. $module;

		// Lets check if the directory actually exists
		if (!file_exists($path) && !is_dir($path)) {

			$fileSystem = new Filesystem();
			
			$fileSystem->deleteDirectory(storage_path('platform/installer/'. $module));
			$fileSystem->delete(storage_path('platform/installer/packages/'. $module .'.pkg.zip'));
		}

	}
}
