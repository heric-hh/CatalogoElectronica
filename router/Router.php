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
}
