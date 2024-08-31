<?php 
require_once __DIR__ . '/helpers/app.php';
use Controllers\PagesController;
use Controllers\CategoriasController;
use Controllers\ProductosController;
use Controllers\LoginController;
use Controllers\AdminController;
use Controllers\MarcasController;
use Controllers\APIController;
use Middleware\AuthMiddleware;

use MVC\Router;

$router = new Router();

$router->get('/', [PagesController::class, 'showLandingPage']);
$router->get('/categorias', [CategoriasController::class, 'showIndex']);
$router->get('/productos', [ProductosController::class, 'showIndex']);
$router->get('/producto', [ProductosController::class, 'showProductoEspecifico']);
$router->get('/nosotros', [PagesController::class, 'showNosotros']);

//Login
$router->get('/login', [LoginController::class, 'showLogin']);
$router->post('/login', [LoginController::class, 'procesarLogin']);
$router->get('/logout', [LoginController::class, 'procesarLogout']);

//Administrador
$router->get('/admin', [AdminController::class, 'showAdmin'], [AuthMiddleware::class, 'verificarAutenticacion']);

//Productos
$router->get('/admin/productos', [ProductosController::class, 'showProductos'], [AuthMiddleware::class, 'verificarAutenticacion']);
$router->get('/admin/productos/crear', [ProductosController::class, 'showCrearProducto'], [AuthMiddleware::class, 'verificarAutenticacion']);
$router->get('/admin/productos/editar', [ProductosController::class, 'editarProducto'], [AuthMiddleware::class, 'verificarAutenticacion']);

$router->post('/admin/productos/crear', [ProductosController::class, 'showCrearProducto'], [AuthMiddleware::class, 'verificarAutenticacion']);
$router->post('/admin/productos/editar', [ProductosController::class, 'guardarProducto'], [AuthMiddleware::class, 'verificarAutenticacion']);
$router->post('/admin/productos/eliminar', [ProductosController::class, 'eliminarProducto'], [AuthMiddleware::class, 'verificarAutenticacion']);

//Categorias
$router->get('/admin/categorias',[CategoriasController::class, 'showCategorias'], [AuthMiddleware::class, 'verificarAutenticacion']);
$router->get('/admin/categorias/crear', [CategoriasController::class, 'crearCategoria'], [AuthMiddleware::class, 'verificarAutenticacion']);
$router->get('/admin/categorias/editar', [CategoriasController::class, 'editarCategoria'], [AuthMiddleware::class, 'verificarAutenticacion']);

$router->post('/admin/categorias/crear', [CategoriasController::class, 'crearCategoria'], [AuthMiddleware::class, 'verificarAutenticacion']);
$router->post('/admin/categorias/editar', [CategoriasController::class, 'guardarCategoria'], [AuthMiddleware::class, 'verificarAutenticacion']);
$router->post('/admin/categorias/eliminar', [CategoriasController::class, 'eliminarCategoria'], [AuthMiddleware::class, 'verificarAutenticacion']);

//Marcas
$router->get('/admin/marcas', [MarcasController::class, 'showMarcas'], [AuthMiddleware::class, 'verificarAutenticacion']);
$router->get('/admin/marcas/crear', [MarcasController::class, 'crearMarca'], [AuthMiddleware::class, 'verificarAutenticacion']);
$router->get('/admin/marcas/editar', [MarcasController::class, 'editarMarca'], [AuthMiddleware::class, 'verificarAutenticacion']);

$router->post('/admin/marcas/crear', [MarcasController::class, 'crearMarca'], [AuthMiddleware::class, 'verificarAutenticacion']);
$router->post('/admin/marcas/editar', [MarcasController::class, 'editarMarca'], [AuthMiddleware::class, 'verificarAutenticacion']);
$router->post('/admin/marcas/eliminar', [MarcasController::class, 'eliminarMarca'], [AuthMiddleware::class, 'verificarAutenticacion']);

//API
$router->get('/api/productos', [APIController::class, 'getProductos']);

$router->checkRoutes();
