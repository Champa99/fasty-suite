<?php

/**
 * Auto created by artisan on 03.12.2018 at 13:35
 * @author Champa
 */

namespace App\Packages\API;

/**
	Format
 * 
 * success: bool
 * code: int
 * message: string
 * timestamp: int
 * data: array
 */

class Response
{

	/**
	 * @var bool
	 */
	private $success;

	/**
	 * @var int
	 */
	private $code;

	/**
	 * @var string
	 */
	private $message;

	/**
	 * @var int
	 */
	private $timestamp;

	/**
	 * @var array
	 */
	private $data;

	/**
	 * @var string
	 */
	private $locale;

	public function __construct(
							?bool $success = null,
							?int $code = null,
							?string $message = null,
							?int $timestamp = null,
							?array $data = null,
							?string $locale = null) {

		if(isset($success)) $this->setSuccess($success);

		if(isset($code)) $this->setCode($code);

		if(isset($message)) $this->setMessage($message);

		if(isset($timestamp)) $this->setTimestamp($timestamp);

		if(isset($data)) $this->setData($data);

		if(isset($locale)) $this->setLocale($locale);
	}

	// Getters and setters...

	/**
	 * Get the complete response
	 * 
	 * @return array
	 */
	public function get() : array {

		return [
			'success' => $this->success,
			'code' => $this->code,
			'message' => $this->message,
			'locale' => $this->locale,
			'timestamp' => $this->timestamp,
			'data' => $this->data
		];
	}

	/**
	 * Get the value of success
	 *
	 * @return  bool
	 */
	public function getSuccess() : ?bool {

		return $this->success;
	}

	/**
	 * Set the value of success
	 *
	 * @param   bool  $success  
	 *
	 * @return  self
	 */
	public function setSuccess(bool $success) {

		$this->success = $success;

		return $this;
	}

	/**
	 * Get the value of code
	 *
	 * @return  int
	 */
	public function getCode() : ?int {

		return $this->code;
	}

	/**
	 * Set the value of code
	 *
	 * @param   int  $code  
	 *
	 * @return  self
	 */
	public function setCode(int $code) {

		$this->code = $code;

		return $this;
	}

	/**
	 * Get the value of message
	 *
	 * @return  string
	 */
	public function getMessage() : ?string {

		return $this->message;
	}

	/**
	 * Set the value of message
	 *
	 * @param   string  $message  
	 *
	 * @return  self
	 */
	public function setMessage(string $message) {

		$this->message = $message;

		return $this;
	}

	/**
	 * Get the value of timestamp
	 *
	 * @return  int
	 */
	public function getTimestamp() : ?int {

		return $this->timestamp;
	}

	/**
	 * Set the value of timestamp
	 *
	 * @param   int  $timestamp  
	 *
	 * @return  self
	 */
	public function setTimestamp(int $timestamp) {

		$this->timestamp = $timestamp;

		return $this;
	}

	/**
	 * Get the value of data
	 *
	 * @return  array
	 */
	public function getData() : ?array {

		return $this->data;
	}

	/**
	 * Set the value of data
	 *
	 * @param   array  $data  
	 *
	 * @return  self
	 */
	public function setData(array $data) {

		$this->data = $data;

		return $this;
	}

	/**
	 * Get the value of locale
	 *
	 * @return  string
	 */
	public function getLocale() : ?string {

		return $this->locale;
	}

	/**
	 * Set the value of locale
	 *
	 * @param   string  $locale  
	 *
	 * @return  self
	 */
	public function setLocale(string $locale) {

		$this->locale = $locale;

		return $this;
	}
}