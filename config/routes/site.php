<?php

use Interop\Container\ContainerInterface;
use Qpdb\SlimApplication\Controllers\CategoriesController;
use Slim\App;

return function( App $app, ContainerInterface $container ) {

	$app->add( new \Qpdb\SlimApplication\Middleware\TrailingSlash( true ));

	$app->get( '/', function( $request, $response ) use ( $container ) {
		return $response->getBody()->write( $this->routerType );
	} );

	$app->map( [ 'GET', 'POST' ], '/categs/{name:[a-z0-9A-Z_-]+}/[{page:[0-9]+}/]', CategoriesController::class . ':indexAction' )
		->add( \Qpdb\SlimApplication\Middleware\ExampleMiddleware::class );

	$app->get( '/details/{name:[a-z0-9A-Z_-]+}/', CategoriesController::class . ':indexAction' );

	$app->get(
		'/login/{email}/{passw}/',
		CategoriesController::class . ':login'
	);

	$app->add( \Qpdb\SlimApplication\Middleware\RouteValidation::class );

};