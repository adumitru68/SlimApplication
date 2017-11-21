<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 3/12/2017 1:12 PM
 */

namespace Qpdb\SlimApplication\Config;


final class ConfigService
{


	/**
	 * @var ConfigService
	 */
	protected static $instance;

	/**
	 * @var array|mixed
	 */
	private $config;


	/**
	 * ConfigService constructor.
	 * @param string|bool $pathToConfig
	 */
	public function __construct( $pathToConfig = null )
	{
		if ( !empty( $pathToConfig ) )
			$this->withConfigPath( $pathToConfig );

		$this->config = require __DIR__ . '/../../config/global.php';
	}

	/**
	 * @param $pathToConfig
	 * @return $this
	 * @throws ConfigException
	 */
	public function withConfigPath( $pathToConfig )
	{
		if ( $pathToConfig && file_exists( $pathToConfig ) )
			/** @noinspection PhpIncludeInspection */
			$this->config = require $pathToConfig;
		else
			throw new ConfigException( 'Invalid config file path ( path/to/global.php )', ConfigException::ERR_CONFIG_FILE_NOT_FOUND );

		return $this;
	}

	/**
	 * @return array
	 */
	public function getSlimSettings()
	{
		return $this->getProperty( 'slim-settings' );
	}

	/**
	 * @param string|null $type
	 * @return array|string
	 */
	public function getRoutes( $type = null )
	{
		if ( !empty( $type ) )
			return $this->getProperty( 'routes' . $type );

		return $this->getProperty( 'routes' );
	}

	/**
	 * @param string $propertyName
	 * @return mixed
	 * @throws ConfigException
	 */
	public function getProperty( $propertyName )
	{
		$propertyNameArray = explode( '.', $propertyName );
		$cursor = $this->config;
		$recursiveProperties = [];
		foreach ( $propertyNameArray as $key ) {
			$recursiveProperties[] = $key;
			if ( is_array( $cursor ) ) {
				if ( array_key_exists( $key, $cursor ) ) {
					$cursor = $cursor[ $key ];
				}
				else {
					throw new ConfigException(
						'Property ' . implode( '.', $recursiveProperties ) . ' is not found!',
						ConfigException::ERR_PROPERTY_NOT_FOUND
					);
				}
			}
			else {
				return $cursor[ $key ];
			}
		}

		return $cursor;
	}

	/**
	 * @param null|string $pathToConfig
	 * @return ConfigService
	 */
	public static function getInstance( $pathToConfig = null )
	{
		if ( self::$instance === null ) {
			self::$instance = new self( $pathToConfig );
		}

		return self::$instance;
	}
}