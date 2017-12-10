<?php

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Qpdb\SlimApplication\Controllers\DemoController;
use Slim\App;

return function( App $app, ContainerInterface $container ) {


	$app->get( '/', function( $request, ResponseInterface $response ) use ( $container ) {
		return $response->getBody()->write( $this->routerType );
	} );

	$app->map( [ 'GET', 'POST' ], '/categs/{name:[a-z0-9A-Z_-]+}/[{page:[0-9]+}/]', DemoController::class . ':indexAction' )
		->add( \Qpdb\SlimApplication\Middleware\ExampleMiddleware::class );

	$app->get( '/details/{name:[a-z0-9A-Z_-]+}/', DemoController::class . ':indexAction' );

	$app->get(
		'/login/{email}/{passw}/',
		DemoController::class . ':login'
	);

	$app->add( new \Qpdb\SlimApplication\Middleware\TrailingSlash( true ) );
	$app->add( \Qpdb\SlimApplication\Middleware\RouteValidation::class );


};