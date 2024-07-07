<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

require_once '../Config/config.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $conn = getConnection();

        $sql = "DELETE FROM extras WHERE idExtras = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(["message" => "Horas extra eliminada correctamente"]);
        } else {
            echo json_encode(["error" => true, "message" => "No se encontró la horas extra para eliminar"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => true, "message" => "Error al eliminar horas extra: " . $e->getMessage()]);
    } finally {
        $conn = null;
    }
} else {
    echo json_encode(["error" => true, "message" => "ID de horas extra no proporcionado"]);
}
?>