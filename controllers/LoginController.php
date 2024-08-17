<?php 

namespace Controllers;

use MVC\Router;
use Models\Admin;

class LoginController {
  public static function showLogin(Router $router) : void {
    $router->render('login', [
      'title' => 'Login - Catálogo De Productos',
      'errores' => []
    ]);
  }

  public static function login(string $usuario, string $contrasena): ?Admin {
    $admin = (new Admin(['usuario' => $usuario, 'contrasena' => $contrasena]));
    $errores = $admin->validar();
    if(!empty($errores)) {
      Admin::setError("Usuario y/o Contraseña Obligatorios");
      return null;
    }
    $admin = $admin->existeUsuario();
    if(!$admin) {
      Admin::setError("El usuario no existe");
      return null;
    }
    if (!$admin->comprobarPassword($contrasena)) {
      Admin::setError("La contraseña es incorrecta");
      return null;
    }

    self::crearSesion($admin);
    return $admin;
  } 

  private static function crearSesion(Admin $admin): void {
    session_start();
    $_SESSION['id'] = $admin->id;
    $_SESSION['usuario'] = $admin->nombre_usuario;
    $_SESSION['login'] = true; 
  }

  public function logout(): void {
    session_start();
    $_SESSION = [];
    session_destroy();
  }

  public static function estaAutenticado(): bool {
    session_start();
    return isset($_SESSION['login']) && $_SESSION['login'];
  }

  public static function procesarLogin(Router $router): void {
    $errores = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $usuario = $_POST['usuario'] ?? "";
      $contrasena = $_POST['contrasena'] ?? "";
      $admin = static::login($usuario, $contrasena);

      if ($admin) {
        header('Location: /admin');
        exit;
      } else {
        $errores = Admin::getErrores();
      }
    }

    $router->render('/login', [
      'title' => 'Login - Catálogo De Productos',
      'errores' => $errores
    ]);
  }

  public function procesarLogout(): void {
    $this->logout();
    header('Location: /');
    exit;
  }
}