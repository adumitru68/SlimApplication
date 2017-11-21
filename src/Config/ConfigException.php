<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 3/12/2017 1:10 PM
 */

namespace Qpdb\SlimApplication\Config;



class ConfigException extends \Exception
{

	const ERR_CONFIG_FILE_NOT_FOUND = 1;
	const ERR_PROPERTY_NOT_FOUND = 2;
}