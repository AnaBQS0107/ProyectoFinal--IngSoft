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

    public function agregarTipoVehiculo($codigo, $tipo, $tarifa) {
        try {
            $query = "INSERT INTO tipovehiculo (Codigo, Tipo, Tarifa) VALUES (:codigo, :tipo, :tarifa)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':tarifa', $tarifa);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al agregar tipo de vehículo: " . $e->getMessage();
        }
    }

    public function actualizarMonto($idTipoVehiculo, $monto) {
        try {
            $query = "UPDATE tipovehiculo SET Tarifa = :monto WHERE idTipoVehiculo = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $idTipoVehiculo);
            $stmt->bindParam(':monto', $monto);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al actualizar monto: " . $e->getMessage();
        }
    }

    public function eliminarTipoVehiculo($idTipoVehiculo) {
        try {
            $query = "DELETE FROM tipovehiculo WHERE idTipoVehiculo = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $idTipoVehiculo);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al eliminar tipo de vehículo: " . $e->getMessage();
        }
    }
}

$controller = new TiposVehiculoController();
$tiposVehiculo = $controller->obtenerTiposVehiculo();
?>
