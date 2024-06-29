<?php
require_once '../Config/config.php'; 

class Cobro {
    private $conn;

    public function __construct() {
        $database = new Database1();
        $this->conn = $database->getConnection();
    }

    public function getAllCobros() {
        if ($this->conn) {
            try {
                $query = "SELECT 
                            cp.idCobrosPeaje, 
                            cp.Fecha, 
                            ep.Nombre AS EstacionPeaje, 
                            cp.Empleados_Persona_Cedula, 
                            tv.Tipo AS TipoVehiculo, 
                            cp.TipoVehiculo_Codigo, 
                            cp.TipoVehiculo_Tarifa 
                          FROM 
                            CobrosPeaje cp
                            INNER JOIN TipoVehiculo tv ON cp.TipoVehiculo_idTipoVehiculo = tv.idTipoVehiculo
                            INNER JOIN EstacionesPeaje ep ON cp.EstacionesPeaje_idEstacionesPeaje = ep.idEstacionesPeaje";

                $stmt = $this->conn->prepare($query);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                echo "Error al obtener datos: " . $e->getMessage();
            }
        } else {
            echo "No se pudo establecer la conexión.";
        }
        return [];
    }

    public function eliminarCobro($idCobro) {
        if ($this->conn) {
            try {
                $query = "DELETE FROM CobrosPeaje WHERE idCobrosPeaje = :idCobro";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':idCobro', $idCobro, PDO::PARAM_INT);
                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                return "Error al eliminar cobro: " . $e->getMessage();
            }
        } else {
            return "No se pudo establecer la conexión.";
        }
    }
}
?>
