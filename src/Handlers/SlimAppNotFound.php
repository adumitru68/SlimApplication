<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 12/5/2017
 * Time: 3:32 AM
 */

namespace Qpdb\SlimApplication\Handlers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\NotFound;
use Slim\Http\Body;
use UnexpectedValueException;

class SlimAppNotFound extends NotFound
{

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

	public function __invoke( ServerRequestInterface $request, ResponseInterface $response ) {
		if ( $request->getMethod() === 'OPTIONS' ) {
			$contentType = 'text/plain';
			$output = $this->renderPlainNotFoundOutput();
		} else {
			$contentType = $this->determineContentType( $request );
			switch ( $contentType ) {
				case 'application/json':
					$output = $this->renderJsonNotFoundOutput();
					break;

				case 'text/xml':
				case 'application/xml':
					$output = $this->renderXmlNotFoundOutput();
					break;

				case 'text/html':
					$output = $this->htmlContent ?: $this->renderHtmlNotFoundOutput( $request ) ;
					break;

				default:
					throw new UnexpectedValueException( 'Cannot render unknown content type ' . $contentType );
			}
		}

		$body = new Body( fopen( 'php://temp', 'r+' ) );
		$body->write( $output );

		return $response->withStatus( 404 )
			->withHeader( 'Content-Type', $contentType )
			->withBody( $body );
	}
}