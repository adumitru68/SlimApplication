<?php

namespace Qpdb\SlimApplication\Handlers;


use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\AbstractHandler;
use Slim\Http\Body;
use UnexpectedValueException;


/**
 * Default Slim application not found handler.
 *
 * It outputs a simple message in either JSON, XML or HTML based on the
 * Accept header.
 */
class NotFoundHandler extends AbstractHandler
{

	/**
	 * @var ContainerInterface
	 */
	protected $c;

	/**
	 * @var string
	 */
	private $scope;



	public function __construct( ContainerInterface $c )
	{
		$this->c = $c;
		$this->scope =$c['routerScope'];
	}

	/**
	 * Invoke not found handler
	 *
	 * @param  ServerRequestInterface $request  The most recent Request object
	 * @param  ResponseInterface      $response The most recent Response object
	 *
	 * @return ResponseInterface
	 * @throws UnexpectedValueException
	 */
	public function __invoke( ServerRequestInterface $request, ResponseInterface $response )
	{

		//var_dump($request->getMethod());

		if ($request->getMethod() === 'OPTIONS') {
			$contentType = 'text/plain';
			$output = 'Options';
		} else {
			$contentType = $this->determineContentType($request);
			switch ($contentType) {
				case 'application/json; charset=UTF-8':
					$output ='json';
					break;

				case 'text/xml':
				case 'application/xml':
					$output = 'xml';
					break;

				case 'text/html':
					$output = 'html';
					break;

				default:
					throw new UnexpectedValueException('Cannot render unknown content type ' . $contentType);
			}
		}

		$body = new Body(fopen('php://temp', 'r+'));
		$body->write($output);

		return $response
			->withStatus(404)
			->withHeader('Content-Type', $contentType)
			->withBody($body);
	}

}
