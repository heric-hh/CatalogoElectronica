<?php 

require_once __DIR__ . '/helpers/app.php';

use Controllers\PagesController;
use MVC\Router;

$router = new Router();

$router->get('/', [PagesController::class, 'showLandingPage']);

$router->checkRoutes();
