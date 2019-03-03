<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 3/12/2017 1:12 PM
 */

namespace Qpdb\SlimApplication\Config;


use Qpdb\Common\Prototypes\Abstracts\AbstractConfiguration;
use Qpdb\Common\Prototypes\Traits\AsSingletonPrototype;
use Qpdb\Common\Prototypes\Traits\AsStoredSettings;

final class ConfigService extends AbstractConfiguration
{

	use AsSingletonPrototype, AsStoredSettings;

	/**
	 * @return array
	 * @throws \Qpdb\Common\Exceptions\CommonException
	 */
	public function getSlimSettings() {
		return $this->getProperty( 'slim-settings' );
	}

	/**
	 * @param string|null $type
	 * @return array|string
	 * @throws \Qpdb\Common\Exceptions\CommonException
	 */
	public function getRoutes( $type = null ) {
		if ( !empty( $type ) )
			return $this->getProperty( 'routes' . $type );

		return $this->getProperty( 'routes' );
	}

}