<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 11/26/2017
 * Time: 9:42 PM
 */

namespace Qpdb\SlimApplication\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

class TrailingSlash
{

	/**
	 * @var bool Add or remove the slash
	 */
	private $addSlash;

	/**
	 * Configure whether add or remove the slash.
	 *
	 * @param bool $addSlash
	 */
	public function __construct( $addSlash = false )
	{
		$this->addSlash = (bool)$addSlash;
	}

	/**
	 * Execute the middleware.
	 *
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface|Response $response
	 * @param callable $next
	 *
	 * @return ResponseInterface
	 */
	public function __invoke( ServerRequestInterface $request, ResponseInterface $response, callable $next )
	{
		$uri = $request->getUri();
		$path = $uri->getPath();

		//Add/remove slash
		if ( strlen( $path ) > 1 ) {
			if ( $this->addSlash ) {
				if ( substr( $path, -1 ) !== '/' && !pathinfo( $path, PATHINFO_EXTENSION ) ) {
					$path .= '/';
				}
			}
			else {
				$path = rtrim( $path, '/' );
			}
		}

		//redirect
		if ( $uri->getPath() !== $path ) {
			if ( $request->getMethod() == 'GET' ) {
				return $response->withRedirect( (string)$path, 301 );
			}
			else {
				return $next( $request->withUri( $uri->withPath($path) ), $response );
			}
		}

		return $next( $request, $response );
	}
}