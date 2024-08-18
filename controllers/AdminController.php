<?php 

namespace Controllers;

use Models\Producto;
use MVC\Router;

class AdminController {
  public static function showAdmin(Router $router) : void {
    $resultado = $_GET["resultado"] ?? null;

    $router->render('admin', [
      'title' => 'Panel De Administración - Catálogo De Productos',
      'resultado' => $resultado
    ]);
  }  
}