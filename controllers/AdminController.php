<?php 

namespace Controllers;

use Models\ConsultaProducto;
use Models\Producto;
use MVC\Router;

class AdminController {
  public static function showAdmin(Router $router) : void {
    $resultado = $_GET["resultado"] ?? null;
    $productoMasVisto = ConsultaProducto::getProductoMasVisto();
    $categoriasMasVistas = ConsultaProducto::getCategoriasMasVistas();
    $marcasMasVistas = ConsultaProducto::getMarcasMasVistas();
    $productoMasVistos = ConsultaProducto::getProductosMasVistos();
    $router->render('admin', [
      'title' => 'Panel De Administración - Catálogo De Productos',
      'resultado' => $resultado,
      'productoMasVisto' => $productoMasVisto,
      'categoriasMasVistas' => $categoriasMasVistas,
      'marcasMasVistas' => $marcasMasVistas,
      'productosMasVistos' => $productoMasVistos
    ]);
  }  
}