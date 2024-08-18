<?php 

namespace Models;

use Database\Database;
use PDO;

abstract class ActiveRecord {
  protected static ?PDO $db = null;
  protected static array $columnasDb = [];
  protected static string $tabla = "";
  protected static array $errores = [];
  
  public static function getDb() : ?PDO {
    self::$db = Database::getInstance()->getConnection();
    return self::$db ?? null;
  }

  public static function getErrores() : array {
    return static::$errores;
  }

  public function validar() : array {
    static::$errores = [];
    return static::$errores;
  }

  public function guardar() : void {
    if(!is_null($this->id)) {
      $this->actualizar();
    } else {
      $this->crear();
    }
  }

  public static function all(string $param) : array {
    $query = "SELECT * FROM " . static::$tabla . " ORDER BY :param";
    $db = static::getDb();
    $stmt = $db->prepare($query);
    $stmt->bindValue(':param', $param, PDO::PARAM_STR);
    $stmt->execute();
    return self::consultarSQL($stmt);
  }

  public static function allProductos(int $pagina, int $porPagina) : array {
    $rango = ($pagina - 1) * $porPagina;
    $query = "
      SELECT p.*, c.categoria AS categoria_nombre, m.marca AS marca_nombre FROM " . static::$tabla . " p
      JOIN categorias c ON p.id_categoria = c.id
      JOIN marcas m ON p.id_marca = m.id
      LIMIT :porPagina OFFSET :rango";
    $db = static::getDb();
    $stmt = $db->prepare($query);
    $stmt->bindValue(':porPagina', $porPagina, PDO::PARAM_INT);
    $stmt->bindValue(':rango', $rango, PDO::PARAM_INT);
    $stmt->execute();
    return self::consultarSQL($stmt);
  }

  public static function count() : int {
    $query = "SELECT COUNT(*) as total FROM " . static::$tabla;
    $db = self::getDb();
    $stmt = $db->query($query);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado["total"] ?? 0;
  }

  public static function get(int $cantidad) : array {
    $query = "SELECT * FROM " . static::$tabla . "LIMIT :cantidad";
    $stmt = self::$db-prepare($query);
    $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  
  }

  public static function find(int $id) : ?self {
    $query = "SELECT * FROM " . static::$tabla . " WHERE id = :id";
    $stmt = self::$db->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);
    return $registro ? static::crearObjeto($registro) : null;
  }

  public function crear() : void {
    $atributos = self::atributos();
    $columnas = join(', ', array_keys($atributos));
    $placeholders = join(', ', array_fill(0, count($atributos), '?'));
    $query = "INSERT INTO " . static::$tabla . " ($columnas) VALUES ($placeholders)";
    $stmt = self::$db->prepare($query);
    $resultado = $stmt->execute(array_values($atributos));
    if($resultado) {
      header("Location: /admin?resultado=1");
    } 
  }

  public function actualizar(): void {
    $atributos = $this->atributos();
    $valores = array_map(fn($key) => "$key = :$key", array_keys($atributos));
    $query = "UPDATE " . static::$tabla . " SET ";
    $query .= join(', ', $valores);
    $query .= " WHERE id = :id";
    $stmt = self::$db->prepare($query);
    // Añadir el id a los atributos
    $atributos['id'] = $this->id;
    $resultado = $stmt->execute($atributos);
    if ($resultado) {
        header('Location: ../admin?resultado=2');
    }
  }

  public function eliminar(): void {
    $query = "DELETE FROM " . static::$tabla . " WHERE id = :id LIMIT 1";
    $stmt = self::$db->prepare($query);
    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    $resultado = $stmt->execute();
    if ($resultado) {
        $this->borrarImagen();
        header('Location: ../admin?resultado=3');
    }
  }

  public static function consultarSQL(\PDOStatement $stmt): array {
    $array = [];
    while ($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $array[] = static::crearObjeto($registro);
    }
    return $array;
}

  protected static function crearObjeto(array $registro): self {
    $objeto = new static;
    foreach ($registro as $key => $value) {
      if (property_exists($objeto, $key)) {
          $objeto->$key = $value; 
      }
    }
    return $objeto;
  }

  public function atributos(): array {
    $atributos = [];
    foreach (static::$columnasDb as $columna) {
      if ($columna === 'id') continue;
      $atributos[$columna] = $this->$columna;
    }
    return $atributos;
  } 

  public function sincronizar(array $args = []): void {
    foreach ($args as $key => $value) {
      if ($key === 'id') continue;
      if (property_exists($this, $key) && !is_null($value)) {
        $this->$key = $value;
      }
    }
  }

  public function setImagen(string $imagen): void {
    if (!is_null($this->id)) {
      $this->borrarImagen();
    }
    if ($imagen) {
      $this->imagen = $imagen;
    }
  }

  public function borrarImagen(): void {
    $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
    if ($existeArchivo) {
      unlink(CARPETA_IMAGENES . $this->imagen);
  }
  }
}