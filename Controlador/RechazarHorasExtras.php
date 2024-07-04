<?php
header('Content-Type: application/json');
require_once '../Config/config.php';

if (isset($_POST['idExtras']) && isset($_POST['motivo'])) {
    $idExtras = $_POST['idExtras'];
    $motivo = $_POST['motivo'];
    $fecha_rechazo = date('Y-m-d H:i:s');

    try {
        $conn = getConnection();
        $sql = "INSERT INTO rechazo_extras (idExtras, motivo, fecha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idExtras, $motivo, $fecha_rechazo]);

        echo json_encode(["error" => false, "message" => "Hora extra rechazada correctamente."]);
    } catch (PDOException $e) {
        echo json_encode(["error" => true, "message" => "Error al rechazar horas extras: " . $e->getMessage()]);
    } finally {
        $conn = null;
    }
} else {
    echo json_encode(["error" => true, "message" => "Faltan datos requeridos"]);
}
?>