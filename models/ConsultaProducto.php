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
}