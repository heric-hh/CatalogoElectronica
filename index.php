<?php 

require_once __DIR__ . '/helpers/app.php';

use Controllers\PagesController;
use Controllers\CategoriasController;
use Controllers\ProductosController;
use Controllers\LoginController;

use MVC\Router;

$router = new Router();

$router->get('/', [PagesController::class, 'showLandingPage']);
$router->get('/categorias', [CategoriasController::class, 'showIndex']);
$router->get('/productos', [ProductosController::class, 'showIndex']);
$router->get('/nosotros', [PagesController::class, 'showNosotros']);
$router->get('/login', [LoginController::class, 'showLogin']);
$router->checkRoutes();
