<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 11/10/2017
 * Time: 6:27 PM
 */

namespace Qpdb\SlimApplication\Middleware;


class ExampleMiddleware extends Middleware
{

	protected function before()
	{
		$this->response->getBody()->write('Start Middleware <br>');
	}

	protected function after()
	{
		$this->response->getBody()->write('<br> End Middleware');
	}
}