<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 11/26/2017
 * Time: 12:20 PM
 */

namespace Qpdb\SlimApplication\Handlers;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Qpdb\SlimApplication\Router\RouterDetails;
use Slim\Http\Body;

abstract class SlimApplicationHandler
{

	/**
	 * @var string
	 */
	protected $message;

	/**
	 * @var integer
	 */
	protected $statusCode;

	/**
	 * @var string
	 */
	protected $contentType;

	/**
	 * @var string
	 */
	protected $routerType;

	/**
	 * @var array
	 */
	protected $knownContentTypes = [
		'application/json',
		'application/xml',
		'text/xml',
		'text/html',
		'text/plain',
	];

	public function __invoke( ServerRequestInterface $request, ResponseInterface $response )
	{
		$this->contentType = RouterDetails::getInstance()->getResponseHeaderConfigArray()['Content-Type'];

		$body = new Body(fopen('php://temp', 'r+'));
		$body->write($this->getBodyContent());

		return $response->withStatus($this->statusCode)
			->withHeader('Content-Type', $this->contentType )
			->withBody($body);
	}

	protected function getBodyContent()
	{
		$shortContentType = explode(';', $this->contentType )[0];

		switch ( $shortContentType ){
			case 'application/json':
				return $this->renderJsonOutput();
			case 'application/xml':
			case 'text/xml':
				return $this->renderXmlOutput();
			case 'text/html':
				return $this->renderHtmlOutput();
			default:
				return $this->renderPlainOutput();
		}
	}

	/**
	 * @return string
	 */
	protected function renderJsonOutput()
	{
		return json_encode(['message' => $this->message]);
	}

	/**
	 * @return string
	 */
	protected function renderXmlOutput()
	{
		return "<root><message>" . $this->message  . "</message></root>";
	}

	protected function renderHtmlOutput()
	{
		return "<h1>" . $this->message  . "</h1>";
	}

	protected function renderPlainOutput()
	{
		return $this->message;
	}

}