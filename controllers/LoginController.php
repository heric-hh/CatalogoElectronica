<?php 

namespace Controllers;
use MVC\Router;

class LoginController {
  public static function showLogin(Router $router) : void {
    $router->render('login', [
      'title' => 'Login - Catálogo De Productos'
    ]);
  }
}