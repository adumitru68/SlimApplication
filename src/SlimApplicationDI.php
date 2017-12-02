<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 11/6/2017
 * Time: 12:42 PM
 */

namespace Qpdb\SlimApplication;


use Qpdb\SlimApplication\Config\ConfigException;
use Qpdb\SlimApplication\Config\ConfigService;
use Qpdb\SlimApplication\Router\RouterService;
use Jgut\Slim\PHPDI\Container;
use Jgut\Slim\PHPDI\ContainerBuilder;

class SlimApplicationDI
{

	/**
	 * @var Container
	 */
	private static $container;


	/**
	 * @param string $moduleName
	 * @return mixed
	 * @throws ConfigException
	 */
	public static function singleton( $moduleName )
	{
		return self::getContainer()->get( $moduleName );
	}

	/**
	 * @param string $moduleName
	 * @return mixed
	 * @throws \DI\DependencyException
	 * @throws \DI\NotFoundException
	 * @throws ConfigException
	 */
	public static function instance( $moduleName )
	{
		return self::getContainer()->make( $moduleName );
	}

	/**
	 * @param bool $newInstance
	 * @return RouterService
	 * @throws ConfigException
	 * @throws \DI\DependencyException
	 * @throws \DI\NotFoundException
	 */
	public static function routerService( $newInstance = false )
	{
		if ( $newInstance )
			return self::getContainer()->make( RouterService::class );

		return self::getContainer()->get( RouterService::class );
	}

	/**
	 * @return Container
	 * @throws ConfigException
	 */
	public static function getContainer()
	{
		if ( self::$container === null ) {
			self::$container = ContainerBuilder::build(
				ConfigService::getInstance()->getSlimSettings()
			);
		}

		return self::$container;
	}

}