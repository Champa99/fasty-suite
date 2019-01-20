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


SecureRoute::get('/admin/module/installer', 'AdminModuleController@installer', 1, 2);
SecureRoute::post('/admin/module/installer', 'AdminModuleController@installer', 1, 2);
SecureRoute::post('/admin/module/installer/{step}', 'AdminModuleController@installer', 1, 2)->where('step', '[0-9]+');
SecureRoute::post('/admin/module/installer/remove', 'AdminModuleController@installerRemove', 1, 2);

// Login routes
SecureRoute::get('/login', 'LoginController@index');
SecureRoute::post('/login/auth', 'LoginController@auth');

SecureRoute::get('/', 'HomeController@index');

Route::get('/test', function() {

	$path = storage_path('platform/installer/FastyPackage');
	$info = file_get_contents($path . '/installer.json');
	$info = json_decode($info);

	$routes = (array) $info->routes;

	foreach ($routes AS $test=>$other) {

		echo $test;
		echo '<br/>';
		dump($other);
	}
});
