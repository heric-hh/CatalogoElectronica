<?php

namespace Middleware;
use Controllers\LoginController;

class AuthMiddleware {
  public static function verificarAutenticacion() : void {
    if(!LoginController::estaAutenticado()) {
      header('Location: /login');
      exit;
    }
  }
}