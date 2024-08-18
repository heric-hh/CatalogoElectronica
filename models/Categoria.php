<?php 

namespace Models;

class Categoria extends ActiveRecord {
  protected static string $tabla = "categorias";
  protected static array $columnasDb = [
    "id",
    "categoria"
  ];
  public ?int $id;
  public string $categoria;

  public function __construct(array $args = []) {
    $this->id = $args["id"] ?? null;
    $this->categoria = $args["categoria"] ?? "";
  }

  public static function getErrores() : array {
    return self::$errores;
  }

  public function validar() : array {
    if(!$this->categoria) {
      self::$errores[] = "Debes añadir el nombre de la categoría";
    }
    
    return self::$errores;
  }
}