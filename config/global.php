<?php

use Qpdb\SlimApplication\Router\RouterDetails;
use Qpdb\SlimApplication\Router\RouterService;
use Interop\Container\ContainerInterface;
use Slim\App;

const QPDB_ROUTER_API = 'apiRouter';
const QPDB_ROUTER_ADMIN = 'adminRouter';
const QPDB_ROUTER_DEFAULT = 'defaultRouter';
const QPDB_ROUTER_API_V1= 'apiRouterV1';

return [

	'use-routers' => [
		QPDB_ROUTER_API => '/api/',
		QPDB_ROUTER_API_V1 => '/api/v1/',
		QPDB_ROUTER_ADMIN => '/admin/',
		QPDB_ROUTER_DEFAULT => '/'
	],

	'routes' => [
		QPDB_ROUTER_API => __DIR__ . '/routes/api.php',
		QPDB_ROUTER_ADMIN => __DIR__ . '/routes/admin.php',
		QPDB_ROUTER_DEFAULT => __DIR__ . '/routes/site.php'
	],

	'response-headers' => [

		QPDB_ROUTER_API => [
			'Access-Control-Allow-Origin' => '*',
			'Access-Control-Allow-Headers' => 'X-Requested-With, Content-Type, Accept, Origin, Authorization',
			'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
			'Allow' => 'GET, POST, PUT, DELETE, OPTIONS',
			'Content-Type' => 'application/json; charset=UTF-8'
		],

		QPDB_ROUTER_ADMIN => [
			'Access-Control-Allow-Origin' => '*',
			'Access-Control-Allow-Headers' => 'X-Requested-With, Content-Type, Accept, Origin, Authorization',
			'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
			'Allow' => 'GET, POST, PUT, DELETE, OPTIONS',
			'Content-Type' => 'text/html; charset=UTF-8'
		],

		QPDB_ROUTER_DEFAULT => [
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

		'routerType' => function() {
			return RouterDetails::getInstance()->getRouterType();
		},

	]
];