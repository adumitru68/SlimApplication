<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 11/19/2017
 * Time: 12:40 PM
 */

namespace Qpdb\SlimApplication\Middleware;


use Slim\Exception\NotFoundException;

class RouteValidation extends Middleware
{

	/**
	 * @throws NotFoundException
	 */
	protected function before()
	{
		if ( 0 === strpos( $this->routeUrl, '//' ) )
			throw new NotFoundException( $this->request, $this->response );
	}

	protected function after()
	{
		// TODO: Implement after() method.
	}
}