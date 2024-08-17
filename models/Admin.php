<?php 

namespace Models;

use Models\ActiveRecord;
use PDO;

class Admin extends ActiveRecord {
  protected static string $tabla = "administrador";
  protected static array $columnasDb = [
    'id',
    'nombre_usuario',
    'constrasena'
  ];
  public ?int $id;
  public string $nombre_usuario;
  public string $contrasena;

  public function __construct(array $args = []) {
    $this->id = $args["id"] ?? null;
    $this->nombre_usuario = $args["usuario"] ?? "";
    $this->contrasena = $args["contrasena"] ?? "";
  }

  public function validar() : array {
    if(empty($this->nombre_usuario)) {
      self::$errores[] = "El usuario es obligatorio";
    }
    if(empty($this->contrasena)) {
      self::$errores[] = "La contraseña es obligatoria";
    }
    return self::$errores;
  }

  public function existeUsuario() : ?self {
    $query = "SELECT * FROM " . self::$tabla . " WHERE nombre_usuario = :nombreUsuario LIMIT 1";
    $db = ActiveRecord::getDb();
    $stmt = $db->prepare($query);
    $stmt->bindParam(":nombreUsuario", $this->nombre_usuario, PDO::PARAM_STR);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$resultado) {
      return null;
    }
    return self::crearObjeto($resultado);
  }

  public function comprobarPassword(string $constrasena) : bool {
   return $this->contrasena === $constrasena;
  }

  public static function hashPassword(string $contrasena) : string {
    return password_hash($contrasena, PASSWORD_BCRYPT);
  }

  public static function setError(string $error) : array {
    self::$errores[] = $error;
    return self::$errores;
  }
}