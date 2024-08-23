<?php 

namespace Models;
use PDO;

class ConsultaProducto extends ActiveRecord {
  public static string $table = "consulta_productos";
  public int $id;
  public int $id_producto;
  public int $id_categoria;
  public int $id_marca;
  public string $fecha_consulta;
  public string $fecha_ultima_consulta;
  public int $num_consultas;

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
      $consultaProducto->fecha_ultima_consulta = $result['fecha_ultima_consulta'];
      $consultaProducto->num_consultas = $result['num_consultas'];
      return $consultaProducto;
    }
    return null;
  }

  public function save(): void {
    $db = ActiveRecord::getDb();
    $query = "INSERT INTO " . static::$table . " (id_producto, id_categoria, id_marca, fecha_consulta, fecha_ultima_consulta, num_consultas) 
              VALUES (:id_producto, :id_categoria, :id_marca, :fecha_consulta, :fecha_ultima_consulta, :num_consultas)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id_producto', $this->id_producto, PDO::PARAM_INT);
    $stmt->bindParam(':id_categoria', $this->id_categoria, PDO::PARAM_INT);
    $stmt->bindParam(':id_marca', $this->id_marca, PDO::PARAM_INT);
    $stmt->bindParam(':fecha_consulta', $this->fecha_consulta, PDO::PARAM_STR);
    $stmt->bindParam(':fecha_ultima_consulta', $this->fecha_ultima_consulta, PDO::PARAM_STR);
    $stmt->bindParam(':num_consultas', $this->num_consultas, PDO::PARAM_INT);
    $stmt->execute();
  }

  public function update(): void {
    $db = ActiveRecord::getDb();
    $query = "UPDATE " . static::$table . "
              SET fecha_ultima_consulta = :fecha_ultima_consulta, num_consultas = :num_consultas 
              WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':fecha_ultima_consulta', $this->fecha_ultima_consulta, PDO::PARAM_STR);
    $stmt->bindParam(':num_consultas', $this->num_consultas, PDO::PARAM_INT);
    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    $stmt->execute();
  }
}