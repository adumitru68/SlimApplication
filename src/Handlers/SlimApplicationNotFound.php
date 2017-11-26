<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 11/26/2017
 * Time: 1:04 PM
 */

namespace Qpdb\SlimApplication\Handlers;


class SlimApplicationNotFound extends SlimApplicationHandler
{

	/**
	 * @var string
	 */
	private $content;

	public function __construct( $content = null )
	{
		$this->statusCode = ResponseStatusCodes::HTTP_NOT_FOUND;
		$this->message = ResponseStatusCodes::$statusTexts[ $this->statusCode ];
		$this->content = $content;
	}

	public function renderHtmlOutput()
	{
		if ( !empty( $this->content ) )
			return $this->content;

		return $this->getDefaultContent();
	}

	private function getDefaultContent()
	{
		ob_start();

		?>
        <html>
        <head>
            <title>Page Not Found</title>
            <style>
                body {
                    margin: 0;
                    padding: 30px;
                    font: 12px/1.5 Helvetica, Arial, Verdana, sans-serif;
                }

                h1 {
                    margin: 0;
                    font-size: 48px;
                    font-weight: normal;
                    line-height: 48px;
                }

                strong {
                    display: inline-block;
                    width: 65px;
                }
            </style>
        </head>
        <body>
        <h1>Page Not Found</h1>
        <p>
            The page you are looking for could not be found. Check the address bar
            to ensure your URL is spelled correctly. If all else fails, you can
            visit our home page at the link below.
        </p>
        <a href='/'>Visit the Home Page</a>
        </body>
        </html>
        <?php

		$html = ob_get_contents();
		ob_clean();

		return $html;
	}

}