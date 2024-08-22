<?php 

namespace MVC;

class Router {
  private array $getRoutes = [];
  private array $postRoutes = [];

  public function get(string $actualUrl, array $function, ?array $middleware = null) : void {
    $this->getRoutes[$actualUrl] = ['fn' => $function, 'middleware' => $middleware];
  }

  public function post(string $actualUrl, array $function, ?array $middleware = null) : void {
    $this->postRoutes[$actualUrl] = ['fn' => $function, 'middleware' => $middleware];
  }

  public function checkRoutes() : void {
    $actualUrl = $_SERVER['PATH_INFO'] ?? '/';
    $requestType = $_SERVER['REQUEST_METHOD'];

    if($requestType == 'GET') {
      $route = $this->getRoutes[$actualUrl] ?? null;
    } else {
      $route = $this->postRoutes[$actualUrl] ?? null;
    }

    if($route) {
      $fn = $route["fn"];
      $middleware = $route["middleware"] ?? null;

      if($middleware) {
        call_user_func($middleware);
      }
      call_user_func($fn, $this);
    } else {
      echo 'Pagina no encontrada';
    }
  }

  public function render(string $view, array $data = []) : void {
    foreach($data as $key => $value) {
      $$key = $value;
    }
    ob_start();
  
    if(strpos($view, "admin") !== false) {
      include __DIR__ . "/../views/layout/layout.html.php";
      include __DIR__ . "/../views/layout/header.html.php";
      include __DIR__ . "/../views/pages/admin/$view.html.php"; 
      include __DIR__ . "/../views/layout/admin_panel.html.php";
    } 
    else {
      //Codigo para otras vistas
      include __DIR__ . "/../views/layout/layout.html.php";
      include __DIR__ . "/../views/layout/header.html.php";
      include __DIR__ . "/../views/pages/$view.html.php";
      include __DIR__ . "/../views/layout/footer.html.php";
    }
  } 
}
