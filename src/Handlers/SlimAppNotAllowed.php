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

class SlimAppNotAllowed extends SlimAppHandler
{

	public function __construct( $htmlContent = null )
	{
		parent::__construct( $htmlContent );
		$this->statusCode = ResponseStatusCodes::HTTP_METHOD_NOT_ALLOWED;
		$this->message = ResponseStatusCodes::$statusTexts[ $this->statusCode ];
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
		$this->message .= '. Must be one of: ' . implode( ', ', $methods );

		return parent::__invoke( $request, $response, $methods );
	}

}