<?php 

namespace Database;
use PDO;
use PDOException;
use Exception;

class Database {
  private static ?Database $instancia = null;
  private ?PDO $pdo = null;

  //Configuración de la base de datos
  private string $host = "localhost";
  private string $dbname = "catalogo";
  private string $username = "admin";
  private string $password = "admin";
  private string $charset = "utf8mb4";

  //Evitar la creación directa de la clase
  private function __construct() {
    $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=$this->charset";
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
      $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
    } catch (PDOException $e) {
      throw new Exception("Error en la conexion: " . $e->getMessage());
    }
  }

  //Obtener la instancia única de la clase
  public static function getInstance() : Database {
    if(self::$instancia === null) {
      self::$instancia = new self();
    }
    return self::$instancia;
  }

  //Obtener el objeto PDO
  public function getConnection(): PDO {
    return $this->pdo;
  }

  public function isConnected() : bool {
    return $this->pdo !== null;
  }
}
