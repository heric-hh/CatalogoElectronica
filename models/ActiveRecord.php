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
    if(!is_null($this->id) && $this->id > 0) {
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

  /**
   * Este método cuenta el número total de productos, opcionalmente filtrados por categoría y/o marca:
   * Si se proporciona una categoría o marca, añade las condiciones correspondientes a la consulta. 
   * Devuelve el conteo total de productos que coinciden con los criterios.
   */
  public static function count(int $categoria = 0, int $marca = 0) : int {
    $query = "SELECT COUNT(*) as total FROM " . static::$tabla . " WHERE 1=1 ";
    $params = [];

    if($categoria > 0 ) {
      $query .= " AND id_categoria = :categoria";
      $params[":categoria"] = $categoria;
    }

    if($marca > 0) {
      $query .= " AND id_marca = :marca";
      $params[":marca"] = $marca;
    }

    $db = self::getDb();
    $stmt = $db->prepare($query);

    foreach ($params as $key => $value) {
      $stmt->bindValue($key, $value, PDO::PARAM_INT);
    }

    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return (int)($resultado["total"] ?? 0);
  }

  /**
   * Este método recupera una lista paginada de productos, opcionalmente filtrados por categoría y/o marca:
   * Calcula el rango para la paginación.
   * Si se proporcionan filtros de categoría o marca, añade las condiciones correspondientes a la consulta.
   * Añade límites para la paginación (LIMIT y OFFSET).
   * Devuelve los resultados como un array de objetos producto.
   */

  public static function filtrarProductos(int $pagina, int $porPagina, int $categoria = 0, int $marca = 0, string $precioOrden = "") : array {
    $rango = ($pagina - 1) * $porPagina;
    $query = "
        SELECT p.*, c.categoria AS categoria_nombre, m.marca AS marca_nombre 
        FROM " . static::$tabla . " p
        JOIN categorias c ON p.id_categoria = c.id
        JOIN marcas m ON p.id_marca = m.id
        WHERE 1=1";
    $params = [];

    $categoria = (int)$categoria;
    $marca = (int)$marca;

    if($categoria > 0) {
      $query .= " AND p.id_categoria = :categoria";
      $params[":categoria"] = $categoria;
    }

    if($marca > 0) {
      $query .= " AND p.id_marca = :marca";
      $params[":marca"] = $marca;
    }

    if($precioOrden === "asc" || $precioOrden === "desc") {
      $query .= " ORDER BY p.precio " . ($precioOrden === "asc" ? "ASC" : "DESC");
    }
    
    $query .= " LIMIT :porPagina OFFSET :rango";
    $params[":porPagina"] = $porPagina;
    $params[":rango"] = $rango;

    $db = self::getDb();
    $stmt = $db->prepare($query);

    foreach ($params as $key => $value) {
      $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    $stmt->execute();
    
    return self::consultarSQL($stmt);
  }

  public static function get(int $cantidad) : array {
    $query = "SELECT * FROM " . static::$tabla . "LIMIT :cantidad";
    $stmt = self::$db-prepare($query);
    $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  
  }

  public static function find(int $id) : ?self {
    $db = self::getDb();
    $query = "SELECT * FROM " . static::$tabla . " WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($registro) {
      $objeto = static::crearObjeto($registro);
      return self::sanitizarObjeto($objeto);
    }
    return null;
  }

  public static function findProducto(int $id) : ?self {
    $db = self::getDb();
    $query = "SELECT p.*, c.categoria AS categoria_nombre, m.marca AS marca_nombre FROM " . static::$tabla . " p
      JOIN categorias c ON p.id_categoria = c.id
      JOIN marcas m ON p.id_marca = m.id
      WHERE p.id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($registro) {
      $objeto = static::crearObjeto($registro);
      return self::sanitizarObjeto($objeto);
    }
    return null;
  }

  public static function buscarProductos(string $termino, int $limite = 5) : array {
    $query = "SELECT id, nombre, precio, imagen FROM " . static::$tabla . " WHERE nombre LIKE :termino LIMIT :limite";
    $db = static::getDb();
    $stmt = $db->prepare($query);
    $terminoBusqueda = "%" . $termino . "%";
    $stmt->bindParam(":termino", $terminoBusqueda, PDO::PARAM_STR);
    $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function crear() : void {
    $db = self::getDb();
    $atributos = self::atributos();
    $columnas = join(', ', array_keys($atributos));
    $placeholders = join(', ', array_fill(0, count($atributos), '?'));
    $query = "INSERT INTO " . static::$tabla . " ($columnas) VALUES ($placeholders)";
    $stmt = $db->prepare($query);
    $resultado = $stmt->execute(array_values($atributos));
    if($resultado) {
      header("Location: /admin?resultado=1");
    } 
  }

  public function actualizar(): void {
    $atributos = $this->atributos();
    // debug($atributos);
    $valores = array_map(fn($key) => "$key = :$key", array_keys($atributos));
    $query = "UPDATE " . static::$tabla . " SET ";
    $query .= join(', ', $valores);
    $query .= " WHERE id = :id";
    $stmt = self::$db->prepare($query);
    // Añadir el id a los atributos
    $atributos['id'] = $this->id;
    $resultado = $stmt->execute($atributos);
    if ($resultado) {
      header('Location: /admin?resultado=2');
    }
  }

  public function eliminar(): void {
    $query = "DELETE FROM " . static::$tabla . " WHERE id = :id LIMIT 1";
    $stmt = self::$db->prepare($query);
    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    $resultado = $stmt->execute();
    if ($resultado) {
      $this->borrarImagen();
      header('Location: /admin?resultado=3');
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

  protected static function sanitizarObjeto(object $objeto): object {
    $objetoSanitizado = new static;

    foreach (get_object_vars($objeto) as $key => $value) {
        if (is_string($value)) {
            $objetoSanitizado->$key = self::sanitizarString($value);
        } elseif (is_array($value)) {
            $objetoSanitizado->$key = self::sanitizarArray($value);
        } elseif (is_object($value)) {
            $objetoSanitizado->$key = self::sanitizarObjeto($value);
        } else {
            $objetoSanitizado->$key = $value;
        }
    }
    return $objetoSanitizado;
  }

  protected static function sanitizarString(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }

  protected static function sanitizarArray(array $array): array {
    $arraySanitizado = [];

    foreach ($array as $key => $value) {
        if (is_string($value)) {
            $arraySanitizado[$key] = self::sanitizarString($value);
        } elseif (is_array($value)) {
            $arraySanitizado[$key] = self::sanitizarArray($value);
        } elseif (is_object($value)) {
            $arraySanitizado[$key] = self::sanitizarObjeto($value);
        } else {
            $arraySanitizado[$key] = $value;
        }
    }

    return $arraySanitizado;
}

  public function setImagen(string $imagen): void {
    //Eliminar la imagen previa si ya existe un registro
    if (!is_null($this->id)) {
      $this->borrarImagen();
    }
    //Asignar al atributo imagen el nombre de la imagen
    if ($imagen) {
      $this->imagen = $imagen;
    }
  }

  public function borrarImagen(): void {
    $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen . ".webp");
    if ($existeArchivo) {
      unlink(CARPETA_IMAGENES . $this->imagen . ".webp");
    }
  }
}