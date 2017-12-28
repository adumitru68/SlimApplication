<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 12/5/2017
 * Time: 1:46 AM
 */

namespace Qpdb\SlimApplication\Handlers;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Qpdb\SlimApplication\Router\RouterDetails;
use Slim\Http\Body;

abstract class SlimAppHandler
{

	/**
	 * @var string
	 */
	protected $contentType;

	/**
	 * @var int
	 */
	protected $statusCode;

	/**
	 * @var string
	 */
	protected $message;

	/**
	 * @var string
	 */
	protected $htmlContent;

	/**
	 * @var RouterDetails
	 */
	protected $router;

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

	/**
	 * @var array
	 */
	protected $methods;


	/**
	 * SlimAppHandler constructor.
	 * @param null $content
	 * @throws \Qpdb\SlimApplication\Config\ConfigException
	 */
	public function __construct( $htmlContent = null )
	{
		$this->router = RouterDetails::getInstance();
		$this->contentType = $this->router->getResponseContentType();
		if ( !is_null( $htmlContent ) )
			$this->htmlContent = $htmlContent;
	}

	/**
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param array $methods
	 * @return ResponseInterface
	 */
	public function __invoke( ServerRequestInterface $request, ResponseInterface $response, $methods = [] )
	{
		$this->methods = $methods;

		if($request->getMethod() === 'OPTIONS')
			$this->contentType = 'text/plain; charset=UTF-8';

		$body = new Body(fopen('php://temp', 'r+'));
		$body->write($this->getBodyContent());

		return $response
			->withStatus($this->statusCode)
			->withHeader('Content-Type', $this->contentType )
			->withBody($body);
	}

	/**
	 * @return null|string
	 */
	protected function getBodyContent()
	{
		switch ( true ) {
			case ( strpos( $this->contentType, 'text/html' ) === 0 ):
				return $this->renderHtmlOutput();
			case ( strpos( $this->contentType, 'application/json' ) === 0 ):
				return $this->renderJsonOutput();
			case ( strpos( $this->contentType, 'application/xml' ) === 0 ):
			case ( strpos( $this->contentType, 'text/xml' ) === 0 ):
				return $this->renderXmlOutput();
			default:
				return $this->renderPlainOutput();
		}
	}

	/**
	 * @return string
	 */
	protected function renderJsonOutput()
	{
		return json_encode( [ 'message' => $this->message ], JSON_PRETTY_PRINT );
	}

	/**
	 * @return string
	 */
	protected function renderXmlOutput()
	{
		return "<root><message>" . $this->message . "</message></root>";
	}

	/**
	 * @return string
	 */
	protected function renderHtmlOutput()
	{
		return $this->message;
	}

	/**
	 * @return string
	 */
	protected function renderPlainOutput()
	{
		return $this->message;
	}


}