<?php 

namespace Controllers;

use Models\Categoria;
use MVC\Router;

class CategoriasController {
  public static function showIndex(Router $router) : void {
    $router->render('categorias', [
      'title' => "Categorías - Catálogo De Productos"
    ]);
  }

  public static function showCategorias(Router $router) : void {
    $categorias = Categoria::all("categoria");
    $router->render('admin_categorias', [
      'title' => 'Administrar Categorías - Catálogo De Productos',
      'categorias' => $categorias
    ]);
  }

  public static function crearCategoria(Router $router) : void {
    $categoria = new Categoria();
    $errores = [];
    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $categoria = new Categoria($_POST["categoria"]);
      $errores = $categoria->validar();
      if(empty($errores)) {
        $resultado = $categoria->guardar();
        if($resultado) {
          header('Location: /admin/productos?mensaje=1');
          exit;
        }
      }
    }
    $router->render('admin_categorias_crear', [
      'title' => 'Crear Categoría - Catálogo De Productos',
      'errores' => $errores,
      'categoria' => $categoria
    ]);
  }

  public static function editarCategoria(Router $router) : void {
    $id = validarORedireccionar("/admin");
    $categoria = Categoria::find($id);
    $errores = Categoria::getErrores();
    $router->render('admin_editar_categoria', [
      'title' => 'Editar Categoría - Catálogo de Productos',
      'errores' => $errores,
      'categoria' => $categoria
    ]);
  }

  public static function guardarCategoria(Router $router) : void {
    $args = $_POST["categoria"];
    $categoria = Categoria::find($args["id"]);
    $categoria->sincronizar($args);
    $errores = $categoria->validar();
    if(empty($errores)) {
      $categoria->actualizar();
    }
    self::editarCategoria($router);
  }

  public static function eliminarCategoria(Router $router) : void {
    $id = $_POST["id"];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if($id) {
      $categoria = Categoria::find($id);
      $categoria->eliminar();
    }
    self::showCategorias($router);
  }
}