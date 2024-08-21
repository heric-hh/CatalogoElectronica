<?php 

namespace Controllers;

use Models\Marca;
use MVC\Router;

class MarcasController {
  public static function showMarcas(Router $router) : void {
    $marcas = Marca::all("marca");
    
    $router->render('admin_marcas', [
      'title' => 'Marcas - Catálogo De Productos',
      'marcas' => $marcas
    ]);
  }

  public static function crearMarca(Router $router) : void {
    $marca = new Marca();
    $errores = [];
    
    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $marca = new Marca($_POST["marca"]);
      $errores = $marca->validar();
      if(empty($errores)) {
        $resultado = $marca->guardar();
        if($resultado) {
          header('Location: /admin/marcas?mensaje=1');
          exit;
        }
      }
    }
    $router->render('admin_crear_marca', [
      'title' => 'Crear Marca - Catálogo De Productos',
      'marca' => $marca,
      'errores' => $errores
    ]);
  }

  public static function editarMarca(Router $router) : void {

  }
}