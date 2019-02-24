<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 12/9/2017
 * Time: 11:33 AM
 */

namespace Qpdb\SlimApplication\Controllers;


use Psr\Http\Message\RequestInterface;
use Qpdb\SlimApplication\Router\RouterDetails;
use Qpdb\SlimApplication\SlimApplicationDI;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Route;

class DemoController
{

	/**
	 * @var RouterDetails
	 */
	protected $router;

	/**
	 * @var string
	 */
	protected $contentType;


	public function __construct()
	{
		$this->router = RouterDetails::getInstance();
		$this->contentType = explode( '; ', $this->router->getResponseContentType() )[ 0 ];
	}

	public function indexAction( RequestInterface $request, Response $response, array $args = [] )
	{

		$bodyContent = [];
		$bodyContent['route-name'] = $request->getAttribute('route')->getName();
		$bodyContent[ 'route-uri' ] = $request->getUri()->getPath();
		$bodyContent[ 'query' ] = $request->getUri()->getQuery();
		$bodyContent[ 'args' ] = $args;
		$bodyContent[ 'params' ] = $request->getParams();
		$bodyContent[ 'query-params' ] = $request->getQueryParams();
		$bodyContent[ $request->getMethod() ] = $request->getParsedBody();
		$bodyContent[ 'response-content' ] = $this->router->getResponseContentType();

		/** @var Route $attr */
		$attr =  $request->getAttribute('route');

		$attr->getCallable();

		/** @var App $app */
		$app = SlimApplicationDI::getContainer()->get(App::class);



		$response->getBody()->write( $this->prepareBodyContent( $bodyContent ) );

		return $response;

	}

	private function prepareBodyContent( array $content )
	{
		if ( $this->contentType == 'application/json' )
			return json_encode( $content, JSON_PRETTY_PRINT );

		return "<pre>" . print_r( $content, 1 ) . "</pre>";
	}

}