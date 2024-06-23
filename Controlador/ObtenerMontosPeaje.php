<?php
require_once '../Config/config.php';

class TiposVehiculoController {

    protected $db;

    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->exec("set names utf8");
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit;
        }
    }

    public function obtenerTiposVehiculo() {
        try {
            $query = "SELECT idTipoVehiculo, Codigo, Tipo, Tarifa FROM tipovehiculo";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $tiposVehiculo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $tiposVehiculo;
        } catch (PDOException $e) {
            echo "Error al obtener tipos de vehículo: " . $e->getMessage();
            return [];
        }
    }
}

$controller = new TiposVehiculoController();
$tiposVehiculo = $controller->obtenerTiposVehiculo();
?>
