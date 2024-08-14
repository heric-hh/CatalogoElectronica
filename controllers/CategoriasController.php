<?php 

namespace Controllers;
use MVC\Router;

class CategoriasController {
  public static function showIndex(Router $router) : void {
    $router->render('categorias', [
      'title' => "Categorías - Catálogo De Productos"
    ]);
  }
}