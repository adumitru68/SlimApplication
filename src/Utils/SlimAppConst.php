<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 12/10/2017
 * Time: 12:57 PM
 */

namespace Qpdb\SlimApplication\Utils;


final class SlimAppConst
{

	/** Methods */
	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';
	const METHOD_DELETE = 'DELETE';
	const METHOD_HEAD = 'HEAD';
	const METHOD_PATCH = 'PATCH';
	const METHOD_OPTIONS = 'OPTIONS';

	/** Content type */
	const CONTENT_APPLICATION_JSON = 'application/json';
	const CONTENT_APPLICATION_XML = 'application/xml';
	const CONTENT_TEXT_XML = 'text/xml';
	const CONTENT_TEXT_HTML = 'text/html';
	const CONTENT_TEXT_PLAIN = 'text/plain';
	const CONTENT_TYPE_ALL = '*/*';


	/**
	 * SlimAppConst constructor.
	 */
	private function __construct() {}

}