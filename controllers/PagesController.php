<?php 

namespace Controllers;
use MVC\Router;

class PagesController {
  public static function showLandingPage(Router $router) : void {
    $router->render('index', [
      'title' => "Catálogo De Productos"
    ]);
  }

  public static function showNosotros(Router $router) : void {
    $router->render('nosotros',[
      'title' => 'Nosotros - Catálogo De Productos'
    ]);
  }
}
