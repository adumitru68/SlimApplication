<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 11/19/2017
 * Time: 12:40 PM
 */

namespace Qpdb\SlimApplication\Middleware;


use Qpdb\SlimApplication\Abstracts\BasicSlimMiddleware;
use Slim\Exception\NotFoundException;

class RouteValidation extends BasicSlimMiddleware
{

	/**
	 * @throws NotFoundException
	 */
	protected function before()
	{
//		if ( empty( $this->request->getAttribute( 'route' ) ) )
//			throw new NotFoundException( $this->request, $this->response );

		if ( 0 === strpos( $this->routeUrl, '//' ) )
			throw new NotFoundException( $this->request, $this->response );
	}

	/**
	 * @return mixed
	 */
	protected function after() {
		// TODO: Implement after() method.
	}
}