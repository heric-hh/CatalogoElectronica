<?php 

namespace Models;
use PDO;

class ConsultaProducto extends ActiveRecord {
  public static string $table = "consultas_productos";
  public int $id;
  public int $id_producto;
  public int $id_categoria;
  public int $id_marca;
  public string $fecha_consulta;
  public int $veces_consultado;
  public ?string $nombre;
  public ?string $descripcion_corta;
  public ?string $precio;
  public ?string $imagen;
  public ?string $total_consultas;
  public ?string $categoria;
  public ?string $marca;

  public function __construct() {}

  public static function findByProductoId(int $id_producto): ?self {
    $db = ActiveRecord::getDb();
    $query = "SELECT * FROM " . static::$table . " WHERE id_producto = :id_producto";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
      $consultaProducto = new self();
      $consultaProducto->id = $result['id'];
      $consultaProducto->id_producto = $result['id_producto'];
      $consultaProducto->id_categoria = $result['id_categoria'];
      $consultaProducto->id_marca = $result['id_marca'];
      $consultaProducto->fecha_consulta = $result['fecha_consulta'];
      $consultaProducto->veces_consultado = $result['veces_consultado'];
      return $consultaProducto;
    }
    return null;
  }

  public function save(): void {
    $db = ActiveRecord::getDb();
    $query = "INSERT INTO " . static::$table . " (id_producto, id_categoria, id_marca, fecha_consulta, veces_consultado) 
              VALUES (:id_producto, :id_categoria, :id_marca, :fecha_consulta, :veces_consultado)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id_producto', $this->id_producto, PDO::PARAM_INT);
    $stmt->bindParam(':id_categoria', $this->id_categoria, PDO::PARAM_INT);
    $stmt->bindParam(':id_marca', $this->id_marca, PDO::PARAM_INT);
    $stmt->bindParam(':fecha_consulta', $this->fecha_consulta, PDO::PARAM_STR);
    $stmt->bindParam(':veces_consultado', $this->veces_consultado, PDO::PARAM_INT);
    $stmt->execute();
  }

  public function update(): void {
    $db = ActiveRecord::getDb();
    $query = "UPDATE " . static::$table . "
              SET fecha_consulta = :fecha_consulta, veces_consultado = :veces_consultado 
              WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':fecha_consulta', $this->fecha_consulta, PDO::PARAM_STR);
    $stmt->bindParam(':veces_consultado', $this->veces_consultado, PDO::PARAM_INT);
    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    $stmt->execute();
  }

  public static function getProductoMasVisto() : ?self {
    $db = self::getDb();
    $query = "SELECT p.id, p.nombre, p.descripcion_corta, p.precio, p.imagen, SUM(cp.veces_consultado) AS total_consultas
      FROM consultas_productos cp
      JOIN productos p ON cp.id_producto = p.id
      GROUP BY cp.id_producto
      ORDER BY total_consultas DESC
      LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    if($resultado) {
      $pmv = new self();
      $pmv->id = $resultado["id"];
      $pmv->nombre = $resultado["nombre"];
      $pmv->descripcion_corta = $resultado["descripcion_corta"];
      $pmv->precio = $resultado["precio"];
      $pmv->imagen = $resultado["imagen"];
      $pmv->total_consultas = $resultado["total_consultas"];
      return $pmv;
    }
    return null;
  }

  public static function getCategoriasMasVistas() : array {
    $db = self::getDb();
    $query = "SELECT c.categoria, SUM(cp.veces_consultado) AS total_consultas
      FROM consultas_productos cp
      JOIN categorias c ON cp.id_categoria = c.id
      GROUP BY cp.id_categoria
      ORDER BY total_consultas DESC
      LIMIT 4";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return self::consultarSQL($stmt);
  }

  public static function getMarcasMasVistas() : array {
    $db = self::getDb();
    $query = "SELECT m.marca, SUM(cp.veces_consultado) AS total_consultas
      FROM consultas_productos cp
      JOIN marcas m ON cp.id_marca = m.id
      GROUP BY cp.id_marca
      ORDER BY total_consultas DESC
      LIMIT 5";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return self::consultarSQL($stmt);
  }

  public static function getProductosMasVistos() : array {
    $db = self::getDb();
    $query = "SELECT p.nombre, cp.veces_consultado FROM consultas_productos cp
      JOIN productos p ON cp.id_producto = p.id
      ORDER BY cp.veces_consultado DESC
      LIMIT 10";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return self::consultarSQL($stmt);
  }

}