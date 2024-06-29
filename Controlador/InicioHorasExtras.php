<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

require_once '../Config/config.php';

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    try {
        $conn = getConnection();
        $sql = "INSERT INTO extras (Empleados_Persona_Cedula, Hora_Inicio, Fecha, Monto) VALUES (?, NOW(), CURDATE(), 0)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);
        echo json_encode(["message" => "Inicio de horas extra registrado correctamente"]);
    } catch (PDOException $e) {
        echo json_encode(["error" => true, "message" => "Error al registrar inicio de horas extra: " . $e->getMessage()]);
    } finally {
        $conn = null;
    }
} else {
    echo json_encode(["error" => true, "message" => "Usuario no autenticado. Inicie sesión para iniciar horas extra."]);
}
?>