<?php 

namespace Controllers;

use Models\Producto;
use MVC\Router;

class AdminController {
  public static function showAdmin(Router $router) : void {
    $router->render('admin', [
      'title' => 'Panel De Administración - Catálogo De Productos',
    ]);
  }

  //Administración de productos
  public static function showProductos(Router $router) : void {
    $paginaActual = $_GET['pagina'] ?? 1;
    $productosPorPagina = 20;
    $totalProductos = Producto::count();
    $totalPaginas = ceil($totalProductos / $productosPorPagina);

    $productos = Producto::allProductos($paginaActual, $productosPorPagina);
    $productosS = self::sanitize($productos);
    
    $router->render('admin_productos', [
      'title' => 'Administrador De Productos - Catálogo De Productos',
      'productosS' => $productosS,
      'totalProductos' => $totalProductos,
      'productosPorPagina' => $productosPorPagina,
      'paginaActual' => $paginaActual,
      'totalPaginas' => $totalPaginas
    ]);
  }

  protected static function sanitize(array $data): array {
    return array_map(function($item) {
      if (is_array($item)) {
          return $this->sanitize($item); // Recursión para arrays anidados
      } elseif (is_object($item)) {
          // Si es un objeto, recorrer sus propiedades y sanitizarlas
          foreach ($item as $key => $value) {
              if (is_string($value)) {
                  $item->$key = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
              }
          }
          return $item;
      } else {
          return is_string($item) ? htmlspecialchars($item, ENT_QUOTES, 'UTF-8') : $item;
      }
  }, $data);
  }

}