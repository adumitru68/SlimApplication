<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 12/5/2017
 * Time: 3:32 AM
 */

namespace Qpdb\SlimApplication\Handlers;


class SlimAppNotFound extends SlimAppHandler
{

	public function __construct( $htmlContent = null )
	{
		parent::__construct( $htmlContent );
		$this->statusCode = ResponseStatusCodes::HTTP_NOT_FOUND;
		$this->message = ResponseStatusCodes::$statusTexts[ $this->statusCode ];
	}

	protected function renderHtmlOutput()
	{
		if ( empty( $this->htmlContent ) )
			return $this->getDefaultContent();

		return $this->htmlContent;
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