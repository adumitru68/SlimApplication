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
	 * @var array
	 */
	private $responseHeaderConfigArray;


	public function __construct()
	{
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
		foreach ( ConfigService::getInstance()->getProperty( 'use-routers' ) as $routerName => $routerUri )
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

		if ( count( $routersMatches ) )
			$this->routerType = array_keys( $routersMatches, max( $routersMatches ) )[ 0 ];
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
	 * @throws \Qpdb\Common\Exceptions\CommonException
	 */
	public function getRoutesFile()
	{
		return ConfigService::getInstance()->getProperty( 'routes.' . $this->routerType );
	}

	/**
	 * @return array
	 * @throws \Qpdb\Common\Exceptions\CommonException
	 */
	public function getResponseHeaderConfigArray()
	{
		if ( null === $this->responseHeaderConfigArray )
			$this->responseHeaderConfigArray = array_merge(
				ConfigService::getInstance()->getProperty('response-headers.allRouters'),
				ConfigService::getInstance()->getProperty( 'response-headers.' . $this->routerType )
			);

		return $this->responseHeaderConfigArray;
	}

	/**
	 * @param bool $onlyContentType
	 * @return mixed|string
	 * @throws \Qpdb\Common\Exceptions\CommonException
	 */
	public function getResponseContentType( $onlyContentType = false )
	{
		if ( $onlyContentType )
			return explode( ';', trim( $this->getResponseHeaderConfigArray()[ 'Content-Type' ] ) )[ 0 ];

		return $this->getResponseHeaderConfigArray()[ 'Content-Type' ];
	}

	/**
	 * @return RouterDetails
	 */
	public static function getInstance()
	{
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


}