<?php
require_once '../config/config.php';

function obtenerCantidadVehiculosPorTipoYEstacion() {
    $database = Database1::getInstance();
    $conn = $database->getConnection();

    $query = "SELECT 
                e.Nombre AS Estacion,
                tv.Tipo AS TipoVehiculo,
                COUNT(cp.idCobrosPeaje) AS CantidadVehiculos
              FROM CobrosPeaje cp
              JOIN EstacionesPeaje e ON cp.EstacionesPeaje_idEstacionesPeaje = e.idEstacionesPeaje
              JOIN TipoVehiculo tv ON cp.TipoVehiculo_idTipoVehiculo = tv.idTipoVehiculo
              GROUP BY e.Nombre, tv.Tipo
              ORDER BY e.Nombre, tv.Tipo";

    $stmt = $conn->prepare($query);
    $stmt->execute();

    $resultados = [];
    if ($stmt->rowCount() > 0) {
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $resultados;
}
?>
