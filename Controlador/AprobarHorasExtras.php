<?php
header('Content-Type: application/json');

require_once '../Config/config.php';

if (isset($_POST['idExtras']) && isset($_POST['motivo'])) {
    $idExtras = $_POST['idExtras'];
    $motivo = $_POST['motivo'];

    try {
        $conn = getConnection();
        $sql = "INSERT INTO aprobacion_extras (idExtras, Fecha, Motivo) VALUES (?, CURDATE(), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idExtras, $motivo]);

        echo json_encode(["message" => "Horas extras aprobadas correctamente"]);
    } catch (PDOException $e) {
        echo json_encode(["error" => true, "message" => "Error al aprobar horas extras: " . $e->getMessage()]);
    } finally {
        $conn = null;
    }
} else {
    echo json_encode(["error" => true, "message" => "Faltan datos requeridos"]);
}
?>