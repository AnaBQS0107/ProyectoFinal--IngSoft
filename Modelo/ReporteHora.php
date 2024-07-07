<?php
require_once '../Config/config.php'; // Asegúrate de incluir tu archivo de configuración de la base de datos aquí

class CantidadVehiculosPorHoraModelo {
    private $conn;

    public function __construct() {
        $database = new Database1(); // Instancia de tu clase Database1 para la conexión
        $this->conn = $database->getConnection();
    }

    public function obtenerCantidadVehiculosPorHora() {
        $query = "SELECT 
                    HOUR(cp.Fecha) AS HoraDelDia,
                    COUNT(*) AS CantidadVehiculos
                  FROM 
                    CobrosPeaje cp
                  GROUP BY 
                    HOUR(cp.Fecha)
                  ORDER BY 
                    HOUR(cp.Fecha)";

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
