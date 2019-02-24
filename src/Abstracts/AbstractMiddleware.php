<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 2/23/2019
 * Time: 4:00 PM
 */

namespace Qpdb\SlimApplication\Abstracts;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;

abstract class AbstractMiddleware
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
	 * @param ResponseInterface      $response
	 * @param callable               $next
	 * @return ResponseInterface
	 */
	public function __invoke( RequestInterface $request, ResponseInterface $response, callable $next ) {
		$this->request = $request;
		$this->response = $response;
		$this->routeUrl = $request->getUri()->getPath();

		$this->before();
		$this->response = $next( $this->request, $this->response );

		if ( !is_null( $request->getAttribute( 'route' ) ) )
			$this->after();

		return $this->response;
	}

	/**
	 * @return mixed
	 */
	abstract protected function before();

	/**
	 * @return mixed
	 */
	abstract protected function after();


}