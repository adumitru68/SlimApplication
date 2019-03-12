<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 2/23/2019
 * Time: 4:00 PM
 */

namespace Qpdb\SlimApplication\Abstracts;


use Slim\Http\Request;
use Slim\Http\Response;

abstract class BasicSlimMiddleware
{

	/**
	 * @var Request
	 */
	protected $request;

	/**
	 * @var Response
	 */
	protected $response;

	/**
	 * @var string
	 */
	protected $routeUrl;


	/**
	 * @param Request  $request
	 * @param Response $response
	 * @param callable $next
	 * @return Response
	 */
	public function __invoke( Request $request, Response $response, callable $next ) {
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