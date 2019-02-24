<?php

use Interop\Container\ContainerInterface;
use Qpdb\SlimApplication\Controllers\DemoController;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function( App $app, ContainerInterface $container ) {

	$app->map( [ 'GET', 'POST' ], '/api/categs/{name:[a-z0-9A-Z_-]+}/[{page:[0-9]+}/]', DemoController::class . ':indexAction' );

	$app->options( '/{routes:.+}', function( Request $request, Response $response, $args ) {
		return $response;
	} );

	$this->app->add( \Qpdb\SlimApplication\Middleware\RouteValidation::class );

};