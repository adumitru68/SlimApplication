<?php

use Qpdb\SlimApplication\Controllers\CategoriesController;
use Slim\App;

function loadRoutes( App $app )
{

	$app->get( '/categs/{name:[a-z0-9A-Z_-]+}/[{page:[0-9]+}/]', CategoriesController::class . ':indexAction' );

}