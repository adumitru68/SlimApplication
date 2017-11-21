<?php

use Qpdb\SlimApplication\Router\RouterDetails;
use Qpdb\SlimApplication\Router\RouterService;
use Interop\Container\ContainerInterface;
use Slim\App;

return [

	'routes' => [
		RouterDetails::API_ROUTER => __DIR__ . '/routes/api.php',
		RouterDetails::ADMIN_ROUTER => __DIR__ . '/routes/admin.php',
		RouterDetails::DEFAULT_ROUTER => __DIR__ . '/routes/site.php'
	],

	'routes-url' => [
		RouterDetails::API_ROUTER => '/api/',
		RouterDetails::ADMIN_ROUTER => '/admin/',
		RouterDetails::DEFAULT_ROUTER => '/',
	],

	'response-headers' => [

		RouterDetails::API_ROUTER => [
			'Access-Control-Allow-Origin' => '*',
			'Access-Control-Allow-Headers' => 'X-Requested-With, Content-Type, Accept, Origin, Authorization',
			'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
			'Allow' => 'GET, POST, PUT, DELETE, OPTIONS',
			'Content-Type' => 'application/json; charset=UTF-8'
		],

		RouterDetails::ADMIN_ROUTER => [
			'Access-Control-Allow-Origin' => '*',
			'Access-Control-Allow-Headers' => 'X-Requested-With, Content-Type, Accept, Origin, Authorization',
			'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
			'Allow' => 'GET, POST, PUT, DELETE, OPTIONS',
			'Content-Type' => 'text/html; charset=UTF-8'
		],

		RouterDetails::DEFAULT_ROUTER => [
			'Access-Control-Allow-Origin' => '*',
			'Access-Control-Allow-Headers' => 'X-Requested-With, Content-Type, Accept, Origin, Authorization',
			'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
			'Allow' => 'GET, POST, PUT, DELETE, OPTIONS',
			'Content-Type' => 'text/html; charset=UTF-8'
		]

	],

	'slim-settings' => [

		'settings' => [
			'httpVersion' => '1.1',
			'responseChunkSize' => 4096,
			'outputBuffering' => 'append',
			'determineRouteBeforeAppMiddleware' => true,
			'displayErrorDetails' => true,
			'addContentLengthHeader' => true,
			'routerCacheFile' => false,
			'php-di' => [
				'use_autowiring' => true,
				'use_annotations' => false,
			]
		],

		App::class => function( ContainerInterface $c ) {
			return new App( $c );
		},

		RouterService::class => function( ContainerInterface $c ) {
			return new RouterService( $c->get( App::class ), $c );
		},

		'notFoundHandler' => function() {
			return new \Slim\Handlers\NotFound();
		},

		'notAllowedHandler' => function() {
			return new \Slim\Handlers\NotAllowed();
		},

		'phpErrorHandler' => function( ContainerInterface $c ) {
			return new \Slim\Handlers\PhpError( $c->get( 'settings' )[ 'displayErrorDetails' ] );
		},

		'errorHandler' => function( ContainerInterface $c ) {
			return new \Slim\Handlers\Error( $c->get( 'settings' )[ 'displayErrorDetails' ] );
		},

		'routerScope' => function() {
			return RouterDetails::getInstance()->getRouteType();
		},

	]
];