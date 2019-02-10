<?php

/**
 * Auto created by artisan on 03.12.2018 at 13:33
 * @author Champa
 */

namespace App\Packages\API;

class Builder
{
	/**
	 * @var Response
	 */
	private $response = null;

	public function __construct() {

		$this->response = new Response();
	}

	/**
	 * Builds a success response
	 */

	public function success(array $data = []) {

		return $this->generateResponse(true, 0, 'OK', time(), $data);
	}

	/**
	 * Builds an error reponse
	 */

	public function error(int $code, array $data = []) {

		return $this->generateResponse(false, $code, __('apicodes.'. $code), time(), $data);
	}

	/**
	 * Builds the response
	 */

	private function generateResponse(?bool $success, ?int $code, ?string $message, ?int $timestamp, ?array $data) {

		$this->response->setSuccess($success);
		$this->response->setCode($code);
		$this->response->setMessage($message);
		$this->response->setTimestamp($timestamp);
		$this->response->setData($data);
		$this->response->setLocale(config('app.locale'));

		$res = $this->response->get();

		return json_encode($res);
	}
}