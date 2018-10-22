<?php

use App\Packages\Core\RouteManager;

// Route manager
$RouteManager = new RouteManager();
$RouteManager->loadRoutes();

$routes = $RouteManager->routes();

foreach($routes AS $route) {

	if($route->method == 'GET') {

		Route::get($route->uri, $route->controller);
		continue;
	}

	if($route->method == 'POST') {

		Route::post($route->uri, $route->controller);
		continue;
	}
}

// Admin panel
Route::get('/admin', 'AdminController@index');

// Login routes
Route::get('/login', 'LoginController@index');
Route::post('/login/auth', 'LoginController@auth');

Route::get('/', function () {
	
	$session = new \App\Packages\User\Session(1);

	$session->create(1);
});
