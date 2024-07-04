<?php
require_once '../Config/config.php'; // Asegúrate de incluir tu archivo de configuración de la base de datos aquí

class PromedioDiarioVehiculosModelo {
    private $conn;

    public function __construct() {
        $database = new Database1(); // Instancia de tu clase Database1 para la conexión
        $this->conn = $database->getConnection();
    }

    public function obtenerDatosPromedioDiario() {
        $query = "SELECT vehiculos_por_dia.EstacionPeaje, ROUND(AVG(vehiculos_por_dia.CantidadVehiculos), 2) AS PromedioDiarioVehiculos
                  FROM (
                      SELECT ep.Nombre AS EstacionPeaje, DATE(cp.Fecha) AS Fecha, COUNT(*) AS CantidadVehiculos
                      FROM CobrosPeaje cp
                      INNER JOIN EstacionesPeaje ep ON cp.EstacionesPeaje_idEstacionesPeaje = ep.idEstacionesPeaje
                      GROUP BY ep.Nombre, DATE(cp.Fecha)
                  ) AS vehiculos_por_dia
                  GROUP BY vehiculos_por_dia.EstacionPeaje
                  ORDER BY vehiculos_por_dia.EstacionPeaje";

        $resultados = [];
        if ($this->conn) {
            try {
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Error al obtener datos: " . $e->getMessage();
            }
            $this->conn = null; // Cerrar la conexión después de usarla
        } else {
            echo "No se pudo establecer la conexión.";
        }

        return $resultados;
    }
}
?>
