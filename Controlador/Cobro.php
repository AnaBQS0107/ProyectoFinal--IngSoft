<?php
class Database {
    private $host = "localhost:3307"; // Ajusta el puerto si es necesario
    private $db_name = "servicio_autobuses";
    private $username = "root";
    private $password = "";

    public function getConnection() {
        try {
            $conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            return null;
        }
    }
}

$cobros = []; 
$database = new Database();
$conn = $database->getConnection();

if ($conn) {
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

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $cobros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error al obtener datos: " . $e->getMessage();
    }
} else {
    echo "No se pudo establecer la conexión.";
}
?>