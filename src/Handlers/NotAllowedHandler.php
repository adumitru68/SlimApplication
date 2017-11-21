<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 11/6/2017
 * Time: 10:04 PM
 */

namespace Qpdb\SlimApplication\Handlers;


use Qpdb\SlimApplication\Router\RouterDetails;
use Interop\Container\ContainerInterface;

class NotAllowedHandler
{

	/**
	 * @var ContainerInterface
	 */
	private $c;

	/**
	 * @var string
	 */
	private $scope;


	public function __construct( ContainerInterface $c )
	{
		$this->c = $c;
		$this->scope =$c['routerScope'];
	}

	public function __invoke()
	{
		return $this->c['response']
			->withStatus(405)
			->withHeader('Content-Type', 'text/html')
			->write('Page not found');
	}

}