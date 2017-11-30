<?php

use Interop\Container\ContainerInterface;
use Slim\App;
use Slim\Http\Response;

return function( App $app, ContainerInterface $container ) {

	$app->get('/api/{test}[/]', function (\Slim\Http\Request $request, Response $response, $args) {
		return $response->getBody()->write( $response->getStatusCode());
	});

	$app->options('/{routes:.+}', function (\Slim\Http\Request $request, Response $response, $args) {
		return $response;
	});

	$this->app->add( \Qpdb\SlimApplication\Middleware\RouteValidation::class );

};