<?php 

require_once __DIR__ . '/helpers/app.php';

use Controllers\PagesController;
use Controllers\CategoriasController;
use Controllers\ProductosController;
use Controllers\LoginController;
use Controllers\AdminController;
use Controllers\MarcaController;
use Controllers\MarcasController;
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

//Productos
$router->get('/admin/productos', [ProductosController::class, 'showProductos']);
$router->get('/admin/productos/crear', [ProductosController::class, 'showCrearProducto']);
$router->get('/admin/productos/editar', [ProductosController::class, 'editarProducto']);

$router->post('/admin/productos/crear', [ProductosController::class, 'showCrearProducto']);
$router->post('/admin/productos/editar', [ProductosController::class, 'guardarProducto']);
$router->post('/admin/productos/eliminar', [ProductosController::class, 'eliminarProducto']);

//Categorias
$router->get('/admin/categorias',[CategoriasController::class, 'showCategorias']);
$router->get('/admin/categorias/crear', [CategoriasController::class, 'crearCategoria']);
$router->get('/admin/categorias/editar', [CategoriasController::class, 'editarCategoria']);

$router->post('/admin/categorias/crear', [CategoriasController::class, 'crearCategoria']);
$router->post('/admin/categorias/editar', [CategoriasController::class, 'guardarCategoria']);
$router->post('/admin/categorias/eliminar', [CategoriasController::class, 'eliminarCategoria']);

//Marcas
$router->get('/admin/marcas', [MarcasController::class, 'showMarcas']);
$router->get('/admin/marcas/crear', [MarcasController::class, 'crearMarca']);
$router->get('/admin/marcas/editar', [MarcasController::class, 'editarMarca']);

$router->post('/admin/marcas/crear', [MarcasController::class, 'crearMarca']);

$router->checkRoutes();