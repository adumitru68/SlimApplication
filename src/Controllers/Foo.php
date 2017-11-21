<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 11/10/2017
 * Time: 3:21 PM
 */

namespace Qpdb\SlimApplication\Controllers;


class Foo
{

	private $param;

	public function __construct( $param )
	{
		$this->param = $param;
	}

	public function getParam()
	{
		return $this->param;
	}

}