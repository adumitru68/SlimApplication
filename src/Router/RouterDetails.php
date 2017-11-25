<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 10/29/2017
 * Time: 11:05 AM
 */

namespace Qpdb\SlimApplication\Router;


use Qpdb\SlimApplication\Config\ConfigService;

class RouterDetails
{

	const DEFAULT_ROUTER = '__qpdb_empty_router__';

	/**
	 * @var RouterDetails
	 */
	private static $instance;

	/**
	 * @var string;
	 */
	private $uri;

	/**
	 * @var array
	 */
	private $routers;

	/**
	 * @var string
	 */
	private $routerType = false;

	/**
	 * @var ConfigService
	 */
	private $config;


	public function __construct()
	{
		$this->config = ConfigService::getInstance();
		$this->initRouter();
	}

	public function initRouter()
	{

		$this->routers = $this->readRouters();
		$this->uri = rtrim( explode( '?', $_SERVER[ 'REQUEST_URI' ] )[ 0 ], '/' ) . '/';
		$this->calculateRouteType();
	}

	private function readRouters()
	{
		$routers = [];
		foreach ( $this->config->getProperty( 'use-routers' ) as $routerName => $routerUri )
			$routers[ $routerName ] = rtrim( $routerUri, '/' ) . '/';

		return $routers;
	}

	private function calculateRouteType()
	{
		$routersMatches = [];
		foreach ( $this->routers as $routerName => $routerUrl ) {
			if ( $this->matches( $routerUrl ) )
				$routersMatches[ $routerName ] = count( explode( '/', $routerUrl ) );
		}

		if(count($routersMatches))
			$this->routerType = array_keys( $routersMatches, max( $routersMatches ) )[0];
	}

	private function matches( $routerUrl )
	{
		if ( strpos( $this->uri, $routerUrl ) === 0 )
			return true;

		return false;
	}


	/**
	 * @return string
	 */
	public function getRouterType()
	{
		return $this->routerType;
	}

	/**
	 * @return string
	 */
	public function getRoutesFile()
	{
		return ConfigService::getInstance()->getProperty( 'routes.' . $this->routerType );
	}

	/**
	 * @return RouterDetails
	 */
	public static function getInstance()
	{
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		else {
			self::$instance->initRouter();
		}

		return self::$instance;
	}


}