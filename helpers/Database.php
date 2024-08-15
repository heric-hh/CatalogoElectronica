<?php 

class Database {
  private static ?Database $instancia = null;
  private ?PDO $pdo = null;

  //Configuración de la base de datos
  private string $host = "localhost";
  private string $dbname = "catalogo";
  private string $username = "root";
  private string $password = "";
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
      die("Error en la conexion: " . $e->getMessage());
    }
  }

  //Obtener la instancia única de la clase
  public static function getInstance() : Database {
    if(self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  //Obtener el objeto PDO
  public function getConecction(): PDO {
    return $this->pdo;
  }
}
