<?php

use Qpdb\SlimApplication\Router\RouterDetails;
use Qpdb\SlimApplication\Router\RouterService;
use Interop\Container\ContainerInterface;
use Slim\App;


return [

	'use-routers' => [
		'apiRouter' => '/api/',
		'adminRouter' => '/admin/',
		'defaultRouter' => '/'
	],

	'routes' => [
		'apiRouter' => __DIR__ . '/routes/api.php',
		'adminRouter' => __DIR__ . '/routes/admin.php',
		'defaultRouter' => __DIR__ . '/routes/default.php'
	],

	'response-headers' => [

		'apiRouter' => [
			'Content-Type' => 'application/json; charset=UTF-8'
		],

		'adminRouter' => [
			'Content-Type' => 'text/html; charset=UTF-8'
		],

		'defaultRouter' => [
			'Content-Type' => 'text/html; charset=UTF-8'
		],

		'allRouters' => [
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
			'addContentLengthHeader' => false,
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
			return new \Qpdb\SlimApplication\Handlers\SlimAppNotFound( null );
		},

		'notAllowedHandler' => function() {
			return new \Qpdb\SlimApplication\Handlers\SlimAppNotAllowed( null );
		},

		'phpErrorHandler' => function( ContainerInterface $c ) {
			return new \Slim\Handlers\PhpError( $c->get( 'settings' )[ 'displayErrorDetails' ] );
		},

		'errorHandler' => function( ContainerInterface $c ) {
			return new \Slim\Handlers\Error( $c->get( 'settings' )[ 'displayErrorDetails' ] );
		},

		'routerType' => function() {
			return RouterDetails::getInstance()->getRouterType();
		},

	]
];