<?php

use Interop\Container\ContainerInterface;
use Slim\App;

return function( App $app, ContainerInterface $container ) {


	//$app->get('/api/', )

	$this->app->add( \Qpdb\SlimApplication\Middleware\RouteValidation::class );

};