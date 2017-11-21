<?php

namespace Qpdb\SlimApplication\Router;


use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Qpdb\SlimApplication\Middleware\RouteValidation;
use Slim\App;

class RouterService
{

	/**
	 * @var App
	 */
	private $app;

	/**
	 * @var ContainerInterface
	 */
	private $container;


	/**
	 * RouterService constructor.
	 * @param App $app
	 * @param ContainerInterface $c
	 */
	public function __construct( App $app, ContainerInterface $c )
	{
		$this->app = $app;
		$this->container = $c;
		$this->initialize();
	}

	/**
	 * Initializes the application router. The $routerConfig parameter is typically
	 * loaded from config/router.php, which returns a configuration routing array (not
	 * enough explanatory, I know, but see config/router.php for more examples).
	 *
	 */
	protected function initialize()
	{

		/**
		 * Use the PSR 7 $response object
		 */
		$this->app->add( function( ServerRequestInterface $request, ResponseInterface $response, callable $next ) {
			return $next( $request, $response );
		} );

		//$this->app->add( RouteValidation::class );

		/** @noinspection PhpIncludeInspection */
		$loadRoutesFunction = require RouterDetails::getInstance()->getRoutesFile();
		call_user_func_array( $loadRoutesFunction, [ $this->app, $this->container ] );

	}

	/**
	 * @return ResponseInterface
	 * @throws \Exception
	 */
	public function run()
	{
		return $this->app->run();
	}

}