<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 12/5/2017
 * Time: 4:38 AM
 */

namespace Qpdb\SlimApplication\Handlers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\NotAllowed;
use Slim\Http\Body;
use UnexpectedValueException;

class SlimAppNotAllowed extends NotAllowed {

	/**
	 * @var string
	 */
	protected $htmlContent;

	/**
	 * SlimAppNotFound constructor.
	 * @param string|null $htmlContent
	 */
	public function __construct( $htmlContent = null ) {
		$this->htmlContent = $htmlContent;
	}

	/**
	 * Invoke error handler
	 *
	 * @param  ServerRequestInterface $request  The most recent Request object
	 * @param  ResponseInterface      $response The most recent Response object
	 * @param  string[]               $methods  Allowed HTTP methods
	 *
	 * @return ResponseInterface
	 * @throws UnexpectedValueException
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $methods)
	{
		if ($request->getMethod() === 'OPTIONS') {
			$status = 200;
			$contentType = 'text/plain';
			$output = $this->renderPlainOptionsMessage($methods);
		} else {
			$status = 405;
			$contentType = $this->determineContentType($request);
			switch ($contentType) {
				case 'application/json':
					$output = $this->renderJsonNotAllowedMessage($methods);
					break;

				case 'text/xml':
				case 'application/xml':
					$output = $this->renderXmlNotAllowedMessage($methods);
					break;

				case 'text/html':
					$output = $this->htmlContent ?: $this->renderHtmlNotAllowedMessage($methods);
					break;
				default:
					throw new UnexpectedValueException('Cannot render unknown content type ' . $contentType);
			}
		}

		$body = new Body(fopen('php://temp', 'r+'));
		$body->write($output);
		$allow = implode(', ', $methods);

		return $response
			->withStatus($status)
			->withHeader('Content-type', $contentType)
			->withHeader('Allow', $allow)
			->withBody($body);
	}
}