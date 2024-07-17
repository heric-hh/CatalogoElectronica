<?php 

namespace Controllers;
use MVC\Router;

class PagesController {
  public static function showLandingPage(Router $router) : void {
    echo "Desde el controlador";    
  }
}
