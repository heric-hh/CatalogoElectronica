<?php 

namespace Controllers;

use Models\Categoria;
use Models\Marca;
use Models\Producto;
use MVC\Router;

class ProductosController {
  public static function showIndex(Router $router) : void {
    $router->render('productos', [
      'title' => "Productos - Catálogo De Productos"
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

  public static function showCrearProducto(Router $router) : void {
    $categorias = Categoria::all("categoria");
    $marcas = Marca::all("marca");
    $producto = new Producto();
    $errores = [];

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $producto = new Producto($_POST["producto"]);
      
      if($producto->id_categoria) {
        $categoria = Categoria::find($producto->id_categoria);
        //La propiedad categoria en el objeto categoria si existe
        $producto->categoria_nombre = $categoria ? $categoria->categoria : "";
      }
      
      if($producto->id_marca) {
        $marca = Marca::find($producto->id_marca);
        //La propiedad marca en el objeto marca si existe
        $producto->marca_nombre = $marca ? $marca->marca : "";
      }
      
      $errores = $producto->validar();
      
      if(empty($errores)) {
        $resultado = $producto->guardar();
        if($resultado) {
          header('Location: /admin/productos?mensaje=1');
          exit;
        }
      }
    }
    
    $router->render('admin_crear_producto', [
      'title' => 'Crear Producto - Administrador de Productos',
      'errores' => [],
      'categorias' => $categorias,
      'marcas' => $marcas
    ]);
  }

  public static function crearProducto(Router $router) : void {
    $categorias = Categoria::all("categoria");
    $marcas = Marca::all("marca");
    $producto = new Producto($_POST["producto"]);
    debug($producto);
    $errores = $producto->validar();
    $router->render('admin_crear_producto', [
      'title' => 'Crear Producto - Admninistrador de Productos',
      'errores' => $errores,
      'categorias' => $categorias,
      'marcas' => $marcas
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
