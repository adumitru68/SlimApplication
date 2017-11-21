<?php

use Qpdb\SlimApplication\Controllers\CategoriesController;
use Interop\Container\ContainerInterface;
use Slim\App;

return function( App $app, ContainerInterface $container ) {

	$app->add(function ($req, $res, $next) {
		$response = $next($req, $res);

		/** @noinspection PhpUndefinedMethodInspection */
		return $response
			->withHeader('Access-Control-Allow-Origin', '*')
			->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
			->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
			->withHeader('Allow', 'GET, POST, PUT, DELETE, OPTIONS')
			//->withHeader('Content-Type', 'application/json; charset=UTF-8')
			;
	});

	$app->map(
		['GET','POST'],
		'/categs/{name:[a-z0-9A-Z_-]+}/[{page:[0-9]+}/]',
		CategoriesController::class . ':indexAction' )
		->add( \Qpdb\SlimApplication\Middleware\ExampleMiddleware::class );

	$app->get('/details/{name:[a-z0-9A-Z_-]+}/', CategoriesController::class .':indexAction' );

	$app->post(
		'/login/',
		CategoriesController::class . ':login'
	);

	//$app->add( \Qpdb\SlimApplication\Middleware\ExampleMiddleware::class );

};