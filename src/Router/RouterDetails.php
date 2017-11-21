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


	const API_ROUTER = 'api';
	const ADMIN_ROUTER = 'admin';
	const DEFAULT_ROUTER = 'site';

	/**
	 * @var RouterDetails
	 */
	private static $instance;

	/**
	 * @var string;
	 */
	private $uri;

	/**
	 * @var string
	 */
	private $routeType;


	public function __construct()
	{
		$this->initRouter();
	}

	public function initRouter()
	{
		$this->uri = trim( explode( '?', $_SERVER[ 'REQUEST_URI' ] )[ 0 ], '/' );
		$this->uri = preg_replace('/(\/+)/','/',$this->uri);
		$this->calculateRouteType();
	}


	private function calculateRouteType()
	{
		$type = explode('/', $this->uri)[0];
		switch ($type) {
			case self::API_ROUTER:
				$this->routeType = self::API_ROUTER;
				break;
			case self::ADMIN_ROUTER:
				$this->routeType = self::ADMIN_ROUTER;
				break;
			default:
				$this->routeType = self::DEFAULT_ROUTER;
				break;
		}
	}

	/**
	 * @return string
	 */
	public function getRouteType()
	{
		return $this->routeType;
	}

	/**
	 * @return string
	 */
	public function getRoutesFile()
	{
		return ConfigService::getInstance()->getProperty( 'routes.' . $this->routeType );
	}

	/**
	 * @return string
	 */
	public function getUri()
	{
		return $this->uri;
	}

	/**
	 * @return RouterDetails
	 */
	public static function getInstance()
	{
		if (self::$instance === null){
			self::$instance = new self();
		} else {
			self::$instance->initRouter();
		}

		return self::$instance;
	}


}