<?php
header('Content-Type: application/json');
require_once '../Config/config.php';

if (isset($_GET['idExtras'])) {
    $idExtras = $_GET['idExtras'];

    try {
        $conn = getConnection();

        // Verificar si hay registros de aprobación para este idExtras
        $sqlAprobado = "SELECT COUNT(*) AS count FROM aprobacion_extras WHERE idExtras = ?";
        $stmtAprobado = $conn->prepare($sqlAprobado);
        $stmtAprobado->execute([$idExtras]);
        $aprobado = $stmtAprobado->fetch(PDO::FETCH_ASSOC)['count'] > 0;

        // Verificar si hay registros de rechazo para este idExtras
        $sqlRechazado = "SELECT COUNT(*) AS count FROM rechazo_extras WHERE idExtras = ?";
        $stmtRechazado = $conn->prepare($sqlRechazado);
        $stmtRechazado->execute([$idExtras]);
        $rechazado = $stmtRechazado->fetch(PDO::FETCH_ASSOC)['count'] > 0;

        echo json_encode(["aprobado" => $aprobado, "rechazado" => $rechazado]);
    } catch (PDOException $e) {
        echo json_encode(["error" => true, "message" => "Error al verificar aprobación y rechazo: " . $e->getMessage()]);
    } finally {
        $conn = null;
    }
} else {
    echo json_encode(["error" => true, "message" => "Faltan datos requeridos"]);
}
?>