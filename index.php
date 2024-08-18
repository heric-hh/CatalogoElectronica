<?php 

require_once __DIR__ . '/helpers/app.php';

use Controllers\PagesController;
use Controllers\CategoriasController;
use Controllers\ProductosController;
use Controllers\LoginController;
use Controllers\AdminController;
use MVC\Router;

$router = new Router();

$router->get('/', [PagesController::class, 'showLandingPage']);
$router->get('/categorias', [CategoriasController::class, 'showIndex']);
$router->get('/productos', [ProductosController::class, 'showIndex']);
$router->get('/nosotros', [PagesController::class, 'showNosotros']);


//Login
$router->get('/login', [LoginController::class, 'showLogin']);
$router->post('/login', [LoginController::class, 'procesarLogin']);
$router->get('/logout', [LoginController::class, 'procesarLogout']);

//Administrador
$router->get('/admin', [AdminController::class, 'showAdmin']);
$router->get('/admin/productos', [ProductosController::class, 'showProductos']);
$router->get('/admin/productos/crear', [ProductosController::class, 'showCrearProducto']);
$router->post('/admin/productos/crear', [ProductosController::class, 'showCrearProducto']);


$router->checkRoutes();