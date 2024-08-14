<?php 

require_once __DIR__ . '/helpers/app.php';

use Controllers\PagesController;
use Controllers\CategoriasController;
use MVC\Router;

$router = new Router();

$router->get('/', [PagesController::class, 'showLandingPage']);
$router->get('/categorias', [CategoriasController::class, 'showIndex']);

$router->checkRoutes();
