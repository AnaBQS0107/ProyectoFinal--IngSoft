<?php
require_once '../Config/config.php'; 

class Cobro {
    private $conn;

    public function __construct() {
        $database = new Database1();
        $this->conn = $database->getConnection();
    }

    public function getCobrosPorTipoVehiculoYEstacion($tipoVehiculoId, $estacionPeajeId) {
        try {
            $query = "SELECT cp.idCobrosPeaje, cp.Fecha, ep.Nombre AS EstacionPeaje, cp.Empleados_Persona_Cedula, tv.Tipo AS TipoVehiculo, tv.Codigo AS TipoVehiculo_Codigo, tv.Tarifa AS TipoVehiculo_Tarifa
                      FROM CobrosPeaje cp
                      INNER JOIN EstacionesPeaje ep ON cp.EstacionesPeaje_idEstacionesPeaje = ep.idEstacionesPeaje
                      INNER JOIN TipoVehiculo tv ON cp.TipoVehiculo_idTipoVehiculo = tv.idTipoVehiculo
                      WHERE cp.TipoVehiculo_idTipoVehiculo = :tipoVehiculoId AND cp.EstacionesPeaje_idEstacionesPeaje = :estacionPeajeId";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':tipoVehiculoId', $tipoVehiculoId, PDO::PARAM_INT);
            $stmt->bindParam(':estacionPeajeId', $estacionPeajeId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getSumaTarifasPorTipoVehiculoYEstacion($tipoVehiculoId, $estacionPeajeId) {
        try {
            $query = "SELECT tv.Tipo AS TipoVehiculo, ep.Nombre AS EstacionPeaje,
                             SUM(cp.TipoVehiculo_Tarifa) AS TotalTarifa
                      FROM CobrosPeaje cp
                      INNER JOIN TipoVehiculo tv ON cp.TipoVehiculo_idTipoVehiculo = tv.idTipoVehiculo
                      INNER JOIN EstacionesPeaje ep ON cp.EstacionesPeaje_idEstacionesPeaje = ep.idEstacionesPeaje
                      WHERE cp.TipoVehiculo_idTipoVehiculo = :tipoVehiculoId 
                        AND cp.EstacionesPeaje_idEstacionesPeaje = :estacionPeajeId
                      GROUP BY tv.Tipo, ep.Nombre";
    
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':tipoVehiculoId', $tipoVehiculoId, PDO::PARAM_INT);
            $stmt->bindParam(':estacionPeajeId', $estacionPeajeId, PDO::PARAM_INT);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    
    
    
    public function getTiposVehiculo() {
        $sql = "SELECT idTipoVehiculo, Tipo FROM TipoVehiculo";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEstacionesPeaje() {
        $sql = "SELECT idEstacionesPeaje, Nombre FROM EstacionesPeaje";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

