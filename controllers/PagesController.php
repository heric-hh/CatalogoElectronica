<?php 

namespace Controllers;
use MVC\Router;

class PagesController {
  public static function showLandingPage(Router $router) : void {
    $router->render('index', [
      'title' => "Catálogo De Productos"
    ]);
  }
}
