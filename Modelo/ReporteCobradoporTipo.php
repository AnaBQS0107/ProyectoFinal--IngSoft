<?php
require_once '../Config/config.php';

$query = "SELECT tv.Tipo AS TipoVehiculo, SUM(cp.TipoVehiculo_Tarifa) AS MontoTotalCobrado
          FROM CobrosPeaje cp
          INNER JOIN TipoVehiculo tv ON cp.TipoVehiculo_idTipoVehiculo = tv.idTipoVehiculo
          GROUP BY tv.Tipo";

$database = new Database1();
$conn = $database->getConnection();

if ($conn) {
    try {
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;  // Cerrar conexión

    } catch (PDOException $e) {
        echo "Error al obtener datos: " . $e->getMessage();
    }
} else {
    echo "No se pudo establecer la conexión.";
}
?>
