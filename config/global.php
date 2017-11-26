<?php

use Qpdb\SlimApplication\Router\RouterDetails;
use Qpdb\SlimApplication\Router\RouterService;
use Interop\Container\ContainerInterface;
use Slim\App;

const QPDB_ROUTER_API = 'apiRouter';
const QPDB_ROUTER_ADMIN = 'adminRouter';
const QPDB_ROUTER_DEFAULT = 'defaultRouter';

return [

	'use-routers' => [
		QPDB_ROUTER_API => '/api/',
		QPDB_ROUTER_ADMIN => '/admin/',
		QPDB_ROUTER_DEFAULT => '/'
	],

	'routes' => [
		QPDB_ROUTER_API => __DIR__ . '/routes/api.php',
		QPDB_ROUTER_ADMIN => __DIR__ . '/routes/default.php',
		QPDB_ROUTER_DEFAULT => __DIR__ . '/routes/site.php'
	],

	'response-headers' => [

		QPDB_ROUTER_API => [
			'Content-Type' => 'application/json; charset=UTF-8'
		],

		QPDB_ROUTER_ADMIN => [
			'Content-Type' => 'text/html; charset=UTF-8'
		],

		QPDB_ROUTER_DEFAULT => [
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
			return new \Qpdb\SlimApplication\Handlers\SlimApplicationNotFound( null );
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

		'routerType' => function() {
			return RouterDetails::getInstance()->getRouterType();
		},

	]
];