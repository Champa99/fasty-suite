<?php

use App\Packages\Core\RouteManager;

// Route manager
$RouteManager = new RouteManager();
$RouteManager->loadRoutes();

$routes = $RouteManager->routes();

foreach($routes AS $route) {

	if($route->method == 'GET') {

		SecureRoute::get($route->uri, $route->controller, $route->perm_group, $route->perm);
		continue;
	}

	if($route->method == 'POST') {

		SecureRoute::post($route->uri, $route->controller, $route->perm_group, $route->perm);
		continue;
	}
}

// Admin panel
SecureRoute::get('/admin', 'AdminController@index', 1, 1);

// Login routes
SecureRoute::get('/login', 'LoginController@index');
SecureRoute::post('/login/auth', 'LoginController@auth');

SecureRoute::get('/', 'HomeController@index', 1, 1);
