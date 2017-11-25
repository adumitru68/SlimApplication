<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 10/29/2017
 * Time: 8:53 PM
 */

namespace Qpdb\SlimApplication\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\NotFoundException;

abstract class Middleware
{


	/**
	 * @var ServerRequestInterface
	 */
	protected $request;

	/**
	 * @var ResponseInterface
	 */
	protected $response;

	/**
	 * @var string
	 */
	protected $routeUrl;



	/**
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param callable $next
	 * @return ResponseInterface
	 * @throws NotFoundException
	 */
	public function __invoke( ServerRequestInterface $request, ResponseInterface $response, callable $next )
	{

		$this->request = $request;
		$this->response = $response;
		$this->routeUrl = $request->getUri()->getPath();

		$this->before();
		$this->response = $next( $this->request, $this->response );

		if ( !is_null( $request->getAttribute( 'route' ) ) )
			$this->after();

		return $this->response;
	}

	abstract protected function before();

	protected function after()
	{

	}

}