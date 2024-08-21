<?php 

namespace MVC;

class Router {
  private array $getRoutes = [];
  private array $postRoutes = [];

  public function get(string $actualUrl, array $function) : void {
    $this->getRoutes[$actualUrl] = $function;
  }

  public function post(string $actualUrl, array $function) : void {
    $this->postRoutes[$actualUrl] = $function;
  }

  public function checkRoutes() : void {
    $actualUrl = $_SERVER['PATH_INFO'] ?? '/';
    $requestType = $_SERVER['REQUEST_METHOD'];

    if($requestType == 'GET') {
      $fn = $this->getRoutes[$actualUrl] ?? null;
    } else {
      $fn = $this->postRoutes[$actualUrl] ?? null;
    }

    if($fn) {
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
