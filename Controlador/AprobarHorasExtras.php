<?php
header('Content-Type: application/json');
require_once '../Config/config.php';

if (isset($_POST['idExtras']) && isset($_POST['motivo'])) {
    $idExtras = $_POST['idExtras'];
    $motivo = $_POST['motivo'];
    $fecha_aprobacion = date('Y-m-d H:i:s');

    try {
        $conn = getConnection();
        $sql = "INSERT INTO aprobacion_extras (idExtras, motivo, fecha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idExtras, $motivo, $fecha_aprobacion]);

        echo json_encode(["error" => false, "message" => "Hora extra aprobada correctamente."]);
    } catch (PDOException $e) {
        echo json_encode(["error" => true, "message" => "Error al aprobar horas extras: " . $e->getMessage()]);
    } finally {
        $conn = null;
    }
} else {
    echo json_encode(["error" => true, "message" => "Faltan datos requeridos"]);
}
?>