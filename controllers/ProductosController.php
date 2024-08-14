<?php 

namespace Controllers;
use MVC\Router;

class ProductosController {
  public static function showIndex(Router $router) : void {
    $router->render('productos', [
      'title' => "Productos - Catálogo De Productos"
    ]);
  }
}
