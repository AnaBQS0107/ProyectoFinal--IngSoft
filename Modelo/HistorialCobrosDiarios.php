<?php

function obtenerHistorialCobrosDiarios() {
    try {
        $conn = new PDO("mysql:host=localhost:3307;dbname=servicio_autobuses", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT Fecha, e.Nombre AS Estacion, tv.Tipo AS TipoVehiculo, cp.TipoVehiculo_Tarifa AS MontoCobrado
                  FROM CobrosPeaje cp
                  JOIN EstacionesPeaje e ON cp.EstacionesPeaje_idEstacionesPeaje = e.idEstacionesPeaje
                  JOIN TipoVehiculo tv ON cp.TipoVehiculo_idTipoVehiculo = tv.idTipoVehiculo
                  ORDER BY Fecha DESC";

        $stmt = $conn->prepare($query);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;

    } catch(PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        return [];
    }
}
?>
