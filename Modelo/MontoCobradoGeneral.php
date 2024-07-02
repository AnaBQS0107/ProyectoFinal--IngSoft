<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

require_once '../Config/config.php'; 


$query = "SELECT SUM(cp.TipoVehiculo_Tarifa) AS MontoTotalCobrado
          FROM CobrosPeaje cp
          INNER JOIN EstacionesPeaje ep ON cp.EstacionesPeaje_idEstacionesPeaje = ep.idEstacionesPeaje
          ORDER BY MontoTotalCobrado DESC
          LIMIT 5"; 

$database = new Database1(); 
$conn = $database->getConnection();

$resultadoTotal = 0; 

if ($conn) {
    try {
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $resultadoTotal = $row['MontoTotalCobrado'];
        $conn = null;

    } catch (PDOException $e) {

        echo "Error al obtener datos: " . $e->getMessage();
        exit; 
    }
} else {
    echo "No se pudo establecer la conexión.";
    exit; 
}
?>
