<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 11/6/2017
 * Time: 11:43 PM
 */

namespace Qpdb\SlimApplication\Handlers;


use Qpdb\SlimApplication\Router\RouterDetails;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractHandler
{

	/**
	 * @var ContainerInterface
	 */
	protected $c;

	/**
	 * @var string
	 */
	protected $scope;

	/**
	 * @var integer
	 */
	protected $statusCode;



	public function __construct( ContainerInterface $c )
	{
		$this->c = $c;
		$this->scope =$c['routerScope'];
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
	{
		switch ($this->scope){

			case RouterDetails::API_ROUTER:


		}
	}

	protected function makeHtmlResponse( $responseCode )
	{

	}

}