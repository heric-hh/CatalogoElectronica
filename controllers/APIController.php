<?php

namespace Controllers;

use Models\Producto;

class APIController {
  public static function getProductos() : void {
    //Verificar el metodo de la solicitud
    if($_SERVER["REQUEST_METHOD"] !== "GET") {
      http_response_code(405);
      echo json_encode(["error" => "Metodo no permitido"]);
      return;
    }

    //Obtener y validar el termino de busqueda
    $termino = $_GET["q"] ?? "";
    if(empty($termino)) {
      echo json_encode(["productos" => []]);
      return;
    }

    //Realizar la busqueda
    $productos = Producto::buscarProductos($termino);

    //Sanitizar los resultados
    $productosSanitizados = array_map(function(array $producto) : array {
      return [
        'id' => (int)$producto["id"],
        'nombre' => htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'),
        'precio' => number_format((float)$producto['precio'], 2, '.', ''),
        'imagen' => htmlspecialchars($producto['imagen'], ENT_QUOTES, 'UTF-8')
      ];
    }, $productos);

    //Devolver los resultados como JSON
    header("Content-Type: application/json");
    echo json_encode(["productos" => $productosSanitizados]);
  }
}