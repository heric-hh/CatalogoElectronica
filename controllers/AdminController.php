<?php 

namespace Controllers;

use MVC\Router;

class AdminController {
  public static function showAdmin(Router $router) : void {
    $router->render('admin', [
      'title' => 'Panel De Administración - Catálogo De Productos',
    ]);
  }

  //Administración de productos
  public static function showProductos(Router $router) : void {
    $router->render('admin_productos', [
      'title' => 'Administrador De Productos - Catálogo De Productos',
    ]);
  }
}