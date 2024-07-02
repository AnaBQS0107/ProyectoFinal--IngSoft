<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;


require_once '../Config/config.php'; 

$query = "SELECT MONTH(Fecha) AS Mes, SUM(TipoVehiculo_Tarifa) AS MontoTotal
          FROM CobrosPeaje
          GROUP BY MONTH(Fecha)";

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
