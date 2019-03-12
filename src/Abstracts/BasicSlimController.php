<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 2/24/2019
 * Time: 11:07 AM
 */

namespace Qpdb\SlimApplication\Abstracts;


use Slim\Http\Request;
use Slim\Http\Response;

abstract class BasicSlimController
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
	 * @param Request  $request
	 * @param Response $response
	 * @param array    $args
	 */
	public function __invoke( Request $request, Response $response, array $args = [] ) {
		$this->request = $request;
		$this->response = $response;
	}

}