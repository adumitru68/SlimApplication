<?php

namespace Qpdb\SlimApplication\Controllers;


use Qpdb\SlimApplication\Config\ConfigService;
use Slim\Http\Request;
use Slim\Http\Response;

class MainController
{

	/**
	 * @var ConfigService
	 */
	private $configService;


	/**
	 * CategoriesController constructor.
	 * @param ConfigService $configService
	 */
	public function __construct( ConfigService $configService )
	{
		$this->configService = $configService;
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @return Response
	 */
	public function indexAction( Request $request, Response $response, array $args )
	{

		$otherParams = $request->getParam( 'foo' );

		$postParams = $request->getParsedBodyParam( 'foo' );

		return $response->write( 'bla api' );
	}

}