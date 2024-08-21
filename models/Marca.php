<?php 

namespace Models;

class Marca extends ActiveRecord {
  protected static string $tabla = "marcas";
  protected static array $columnasDb = [
    "id",
    "marca"
  ];

  public ?int $id;
  public string $marca;

  public function __construct(array $args = []) {
    $this->id = isset($args["id"]) ? (int)$args["id"] : null;
    $this->marca = $args["marca"] ?? "";
  }

  public function validar() : array {
    if(!$this->marca) {
      self::$errores[] = "Debes añadir el nombre de la marca";
    }
    return self::$errores;
  }
}