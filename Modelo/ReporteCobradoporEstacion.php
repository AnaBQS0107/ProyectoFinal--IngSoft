<?php
// Conexión a la base de datos y configuración
require_once '../Config/config.php';

// Query SQL para obtener el monto total cobrado por estación
$query = "SELECT ep.NombreEstacion, SUM(cp.TipoVehiculo_Tarifa) AS MontoTotalCobrado
          FROM CobrosPeaje cp
          INNER JOIN EstacionesPeaje ep ON cp.EstacionesPeaje_idEstacionesPeaje = ep.idEstacionesPeaje
          GROUP BY ep.NombreEstacion";

$database = new Database1(); // Asegúrate de ajustar la clase de conexión a tu implementación
$conn = $database->getConnection();

$resultados = []; // Inicializar el array para almacenar los resultados

if ($conn) {
    try {
        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cerrar la conexión
        $conn = null;

    } catch (PDOException $e) {
        // Manejar errores de consulta
        echo "Error al obtener datos: " . $e->getMessage();
    }
} else {
    echo "No se pudo establecer la conexión.";
}

// Devolver o utilizar $resultados según sea necesario en tu aplicación
?>
