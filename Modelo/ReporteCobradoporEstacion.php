<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;


require_once '../Config/config.php'; 


$query = "SELECT ep.Nombre, SUM(cp.TipoVehiculo_Tarifa) AS MontoTotalCobrado
          FROM CobrosPeaje cp
          INNER JOIN EstacionesPeaje ep ON cp.EstacionesPeaje_idEstacionesPeaje = ep.idEstacionesPeaje
          GROUP BY ep.Nombre";

$database = new Database1(); 
$conn = $database->getConnection();

$resultados = []; 
if ($conn) {
    try {
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;

    } catch (PDOException $e) {
        echo "Error al obtener datos: " . $e->getMessage();
    }
} else {
    echo "No se pudo establecer la conexión.";
}
?>
