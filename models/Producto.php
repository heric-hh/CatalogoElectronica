<?php

namespace Models;

class Producto extends ActiveRecord {
  protected static string $tabla = "productos";
  protected static array $columnasDb = [
    "id",
    "nombre",
    "imagen",
    "descripcion_larga",
    "descripcion_corta",
    "id_categoria",
    "id_marca",
    "precio",
    "disponible"
  ];
  public ?int $id;
  public string $nombre;
  public ?string $imagen;
  public string $descripcion_larga;
  public string $descripcion_corta;
  public ?int $id_categoria;
  public ?int $id_marca;
  public string $categoria_nombre;
  public string $marca_nombre;
  public string $precio;
  public bool $disponible;

  public function __construct(array $args = []) {
    $this->id = isset($args["id"]) ? (int)$args["id"] : null;
    $this->nombre = $args["nombre"] ?? "";
    $this->imagen = $args["imagen"] ?? "";
    $this->descripcion_larga = $args["descripcion_larga"] ?? "";
    $this->descripcion_corta = $args["descripcion_corta"] ?? "";
    $this->id_categoria = isset($args["id_categoria"]) ? (int)$args["id_categoria"] : null;
    $this->id_marca = isset($args["id_marca"]) ? (int)$args["id_marca"] : null;
    $this->categoria_nombre = $args["categoria_nombre"] ?? "";
    $this->marca_nombre = $args["marca_nombre"] ?? "";
    $this->precio = $args["precio"] ?? 0;
    $this->disponible = $args["disponible"] ?? false;
  }

  public static function getErrores() : array {
    return self::$errores;
  }

  public function validar() : array {
    if(!$this->nombre) {
      self::$errores[] = "Debes añadir el nombre del producto";
    }
    if(strlen(!$this->descripcion_larga) > 50) {
      self::$errores[] = "Debes añadir una descripción mas grande del producto";
    }
    if(!$this->descripcion_corta) {
      self::$errores[] = "Debes añadir una descripción del producto";
    }
    if(!$this->id_categoria) {
      self::$errores[] = "Debes añadir una categoría al producto";
    }
    if(!$this->id_marca) {
      self::$errores[] = "Debes añadir una marca al producto";
    }
    if(!$this->precio) {
      self::$errores[] = "Debes añadir el precio del producto";
    }
    if(!$this->disponible) {
      self::$errores[] = "Debes especificar la disponibilidad del producto"; 
    }
    return self::$errores;
  }

}