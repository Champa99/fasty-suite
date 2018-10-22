<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Packages\User\Authenticator;
use App\Packages\User\Session;
use App\Packages\Core\API;
use Cookie;

class LoginController extends Controller
{

	/**
	 * Displaying the login form
	 */

	public function index() {

		return view('login.index');
	}

	/**
	 * Responsible for handling the authentication
	 */

	public function auth(Request $request) {

		$user = $request->input('user');
		$password = $request->input('password');

		$authenticator = new Authenticator($user, $password);

		if($userId = $authenticator->attempt()) {

			$session = new Session($userId);

			$id = $session->create();

			Cookie::queue(Cookie::forever('_lvc', $id));
			session(['user_session' => $id]);

			return API::response(API::SUCCESS, 1);
		} else {

			return API::response(API::FAIL, 1);
		}
	}
}
