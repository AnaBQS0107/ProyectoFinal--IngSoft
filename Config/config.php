<?php
define('DB_HOST', 'localhost:3307');
define('DB_NAME', 'servicio_autobuses');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("set names utf8");
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit; // Asegúrate de salir del script si hay un error de conexión
}

class Database1 {
    public static $instance = null;
    public $conn;
    public $host = "localhost:3307";
    public $db_name = "servicio_autobuses";
    public $username = "root";
    public $password = "";

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database1();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}

function getConnection() {
    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        return null;
    }
}
?>