<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

require_once '../Config/config.php';

$query = "SELECT ep.Nombre AS EstacionPeaje, tv.Tipo AS TipoVehiculo, COUNT(*) AS CantidadVehiculos
          FROM CobrosPeaje cp
          INNER JOIN EstacionesPeaje ep ON cp.EstacionesPeaje_idEstacionesPeaje = ep.idEstacionesPeaje
          INNER JOIN TipoVehiculo tv ON cp.TipoVehiculo_idTipoVehiculo = tv.idTipoVehiculo
          GROUP BY ep.Nombre, tv.Tipo
          ORDER BY ep.Nombre, tv.Tipo";

$database = new Database1(); 
$conn = $database->getConnection();

$resultados = []; 
if ($conn) {
    try {
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($resultados)) {
            echo "No se encontraron resultados en la consulta.";
        } else {
            $conn = null;
        }
    } catch (PDOException $e) {
        echo "Error al obtener datos: " . $e->getMessage();
    }
} else {
    echo "No se pudo establecer la conexión.";
}
?>