<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 11/10/2017
 * Time: 11:49 PM
 */

namespace Qpdb\SlimApplication\Handlers;


use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class BlaHandler
{

	public function __construct( ContainerInterface $c )
	{

	}

	public function __invoke( Request $request, Response $response )
	{
		var_dump( $response->getStatusCode());
		return $response
			->withStatus(404)
			->write('not found');
	}

}