<?php 

namespace Controllers;

use Models\Categoria;
use Models\Marca;
use Models\Producto;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Models\ConsultaProducto;

class ProductosController {
  public static function showIndex(Router $router) : void {
    $paginaActual = isset($_GET['pagina']) ? (int)$_GET["pagina"] : 1;
    $productosPorPagina = 20;

    $categoriaFiltro = isset($_GET["categoria"]) ? (int)$_GET["categoria"] : 0;
    $marcaFiltro = isset($_GET["marca"]) ? (int)$_GET["marca"] : 0;
    $precioOrden = isset($_GET["precio-orden"]) ? $_GET["precio-orden"] : "";

    $totalProductos = Producto::count($categoriaFiltro, $marcaFiltro);
    $totalPaginas = (int)ceil($totalProductos/$productosPorPagina);
    $productos = Producto::filtrarProductos($paginaActual, $productosPorPagina, $categoriaFiltro, $marcaFiltro, $precioOrden);
    $productosSanitizados = self::sanitize($productos);
    $categorias = Categoria::all("categoria");
    $marcas = Marca::all("marca");

    $router->render('productos', [
      'title' => "Productos - Catálogo De Productos",
      'productos' => $productosSanitizados,
      'totalProductos' => $totalProductos,
      'productosPorPagina' => $productosPorPagina,
      'paginaActual' => $paginaActual,
      'totalPaginas' => $totalPaginas,
      'categorias' => $categorias,
      'marcas' => $marcas,
      'precioOrden' => $precioOrden
    ]);
  }

  public static function showProductoEspecifico(Router $router) {
    $id = $_GET["id"];
    $producto = Producto::findProducto($id);
    
    if($producto) {
      self::almacenarConsulta($producto);
    }

    $router->render('producto_especifico', [
      'title' => 'Producto - Catálogo De Productos',
      'producto' => $producto
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
      'totalPaginas' => $totalPaginas,
    ]);
  }

  public static function showCrearProducto(Router $router) : void {
    $categorias = Categoria::all("categoria");
    $marcas = Marca::all("marca");
    $producto = new Producto();
    $errores = [];

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $producto = new Producto($_POST["producto"]);
      $nombreImagen = md5(uniqid( rand(), true));

      //Si se ha enviado una imagen
      if($_FILES["producto"]["tmp_name"]["imagen"]) {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($_FILES["producto"]["tmp_name"]["imagen"]);
        $image->resize(width:640);
        $image->resize(height: 480);
        $producto->setImagen($nombreImagen);
      }
      
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

        if(!is_dir(CARPETA_IMAGENES)) {
          mkdir(CARPETA_IMAGENES);
        }

        $encoded = $image->toWebp();
        $encoded->save(CARPETA_IMAGENES . $nombreImagen . ".webp");
        $resultado = $producto->guardar();

        if($resultado) {
          header('Location: /admin/productos?resulado=1');
          exit;
        }
      }
    }
    
    $router->render('admin_crear_producto', [
      'title' => 'Crear Producto - Administrador de Productos',
      'errores' => $errores,
      'categorias' => $categorias,
      'marcas' => $marcas,
      'producto' => $producto
    ]);
  }

  public static function editarProducto(Router $router) : void {
    $id = validarORedireccionar("/admin");
    $categorias = Categoria::all("categoria");
    $producto = Producto::find($id); //Producto a editar
    $marcas = Marca::all("marca");
    $errores = Producto::getErrores();
    
    $router->render('admin_editar_producto', [
      'title' => 'Editar Producto - Catálogo De Productos',
      'producto' => $producto,
      'errores' => $errores,
      'categorias' => $categorias,
      'marcas' => $marcas
    ]);
  }

  public static function guardarProducto(Router $router) : void {
    $args = $_POST["producto"];
    $producto = Producto::find($args["id"]);

    $marcas = Marca::all("marca");
    $categorias = Categoria::all("categoria");
    
    $producto->sincronizar($args);
    $errores = $producto->validar();
    $nombreImagen = md5(uniqid( rand(), true));
    
    if($_FILES["producto"]["tmp_name"]["imagen"]) {
      $manager = new ImageManager(new Driver());
      $image = $manager->read($_FILES["producto"]["tmp_name"]["imagen"]);
      $image->resize(width:640);
      $image->resize(height: 480);
      $producto->setImagen($nombreImagen);
    }
    
    if(empty($errores)) {
      if($_FILES["producto"]["tmp_name"]["imagen"]) {
        $encoded = $image->toWebp();
        $encoded->save(CARPETA_IMAGENES . $nombreImagen . ".webp");
      }
      $producto->actualizar();
    }
    $router->render('admin_editar_producto', [
      'title' => 'Editar Producto - Catálogo De Productos',
      'producto' => $producto,
      'errores' => $errores,
      'categorias' => $categorias,
      'marcas' => $marcas
    ]);
  }

  public static function eliminarProducto(Router $router) : void {
    $id = $_POST["id"];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if($id) {
      $producto = Producto::find($id);
      $producto->eliminar();
    }
    self::showProductos($router);
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

  /** Almacenar las consultas para estadísticas de producto */

  private static function almacenarConsulta(Producto $producto) : void {
    $fecha_actual = date('Y-m-d H:i:s');
        
    $consulta_existente = ConsultaProducto::findByProductoId($producto->id);
    
    if ($consulta_existente instanceof ConsultaProducto) {
      $consulta_existente->fecha_consulta = $fecha_actual;
      $consulta_existente->veces_consultado++;
      $consulta_existente->update();
    } else {
      $nueva_consulta = new ConsultaProducto();
      $nueva_consulta->id_producto = $producto->id;
      $nueva_consulta->id_categoria = $producto->id_categoria;
      $nueva_consulta->id_marca = $producto->id_marca;
      $nueva_consulta->fecha_consulta = $fecha_actual;
      $nueva_consulta->fecha_consulta = $fecha_actual;
      $nueva_consulta->veces_consultado = 1;
      $nueva_consulta->save();
    }
  }  
}
