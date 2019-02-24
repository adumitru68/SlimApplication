<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 2/24/2019
 * Time: 10:54 AM
 */

namespace Qpdb\SlimApplication\Abstracts;


use Qpdb\SlimApplication\SlimApplicationDI;
use Slim\App;

abstract class AbstractRequest
{

	/**
	 * @var App
	 */
	protected $app;

	/**
	 * AbstractRequest constructor.
	 * @param App|null $app
	 * @throws \Qpdb\SlimApplication\Config\ConfigException
	 */
	public function __construct( App $app = null ) {
		$this->app = $app ?: SlimApplicationDI::getContainer()->get( App::class );
	}

}