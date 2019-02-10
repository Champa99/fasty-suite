<?php

/**
 * Auto created by artisan on 18.12.2018 at 17:43
 * @author Champa
 */

namespace App\Packages\System;

use App\Packages\System\Image;

class Uploader
{

	/**
	 * Holds the http file
	 * @var mixed
	 */
	private $file;

	/**
	 * The size of the file its gonna ocupy on the server
	 * @var integer
	 */
	private $fileSize;

	/**
	 * The extension of the file
	 * @var string
	 */
	private $fileExt;

	/**
	 * Name of the file
	 * @var string
	 */
	private $fileName;

	/**
	 * This is the maximum image size we're gonna allow to be uploaded
	 * @var int
	 */
	private $maxSizeImage = 5242880;

	/**
	 * Maximum file size...
	 * @var int
	 */
	private $maxFileSize = 52428800;

	/**
	 * Type of the file
	 * @var string
	 */
	private $type;

	/**
	 * Allowed image extensions
	 * @var array
	 */
	private $imageExtensions = ['jpeg', 'jpg', 'png', 'gif', 'tif', 'ico', 'webp'];

	/**
	 * Allowed file extensions
	 * @var array
	 */
	private $fileExtensions = ['txt', 'log', 'doc', 'docx', 'xlsx', 'pptx', 'psd', 'zip', 'rar', 'tar'];

	/**
	 * Is the file an image ?
	 * @var bool
	 */
	private $isImage = null;

	/**
	 * The uploaded file path
	 * @var string
	 */
	private $uploadedPath = '';

	/**
	 * The real name of the file
	 * @var string
	 */
	private $realName = '';

	public function __construct($file, ?string $type = 'DEFAULT') {

		$this->file				=		$file;
		$this->fileSize 		= 		$this->file->getClientSize();
		$this->realName			=		$this->file->getClientOriginalName();
		$val 					=		explode(".", $this->realName);
		$this->fileExt 			= 		strtolower(array_pop($val));
		$this->type				=		$type;

		if($this->type == 'PKG')
			$this->fileName = $this->realName;
		else
			$this->fileName = md5(str_random(5) . '-'. $this->realName) .'.'. $this->fileExt;
	}

	/**
	 * Main function we call to upload the file
	 */
	public function upload() {

		if(in_array($this->fileExt, $this->imageExtensions)) {

			// Handle the file as an image
			$this->isImage = true;

			return $this->handleImage();
		}
		
		if(in_array($this->fileExt, $this->fileExtensions)) {

			// Handle the file as a file
			$this->isImage = false;

			return $this->handleFile();
		}

		// Otherwise, the extension isn't valid
		return 9;
	}

	/**
	 * This gets called if the system recognizes that the uploaded file is a file and not an image
	 */
	private function handleFile() {

		if($this->fileSize > $this->maxFileSize) {

			// If the file size is too big
			return 8;
		}

		switch($this->type) {

			default:
				$path = public_path('storage/attachments');
				$dbPath = '/storage/attachments/'. $this->fileName;
				break;

			case 'PKG':
				$path = storage_path('platform/installer/packages');
				$dbPath = '/platform/installer/packages/'. $this->fileName;
				break;
		}

		$this->file->move($path, $this->fileName);
		$this->uploadedPath = $dbPath;

		return 0;
	}

	private function handleImage() {

		if($this->fileSize > $this->maxSizeImage) {

			// If the file size is too big
			return 8;
		}

		switch($this->type) {

			default:
				$path = public_path('storage/images/content');
				$dbPath = 'storage/images/content/'. $this->fileName;
				break;
		}

		$this->file->move($path, $this->fileName);
		$this->uploadedPath = $dbPath;

		//$image_info = getimagesize($this->file);
		//$image_width = $image_info[0];
		//$image_height = $image_info[1];
		//adjusted height = <user-chosen width> * original height / original width
		//adjusted width = <user-chosen height> * original width / original height

		Image::tidyUp($this->uploadedPath, $this->fileExt, 80, 0, 0);

		return 0;
	}

	/**
	 * Get the uploaded file path
	 *
	 * @return  string
	 */
	public function getUploadedPath() : ?string {

		return $this->uploadedPath;
	}

	/**
	 * Get is the file an image ?
	 *
	 * @return  bool
	 */
	public function getIsImage() : ?bool {

		return $this->isImage;
	}

	/**
	 * Get the extension of the file
	 *
	 * @return  string
	 */
	public function getFileExt() : ?string {

		return $this->fileExt;
	}

	/**
	 * Get the real name of the file
	 *
	 * @return  string
	 */
	public function getRealName() : ?string {

		return $this->realName;
	}

	/**
	 * Get name of the file
	 *
	 * @return  string
	 */
	public function getFileName() : ?string {

		return $this->fileName;
	}
}