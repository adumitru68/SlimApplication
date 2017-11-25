<?php

use Qpdb\SlimApplication\Controllers\CategoriesController;
use Interop\Container\ContainerInterface;
use Slim\App;

return function( App $app, ContainerInterface $container ) {

	$app->map( ['GET','POST'], '/categs/{name:[a-z0-9A-Z_-]+}/[{page:[0-9]+}/]', CategoriesController::class . ':indexAction' )
		->add( \Qpdb\SlimApplication\Middleware\ExampleMiddleware::class );

	$app->get('/details/{name:[a-z0-9A-Z_-]+}/', CategoriesController::class .':indexAction' );

	$app->post(
		'/login/',
		CategoriesController::class . ':login'
	);

	$this->app->add( \Qpdb\SlimApplication\Middleware\RouteValidation::class );

};