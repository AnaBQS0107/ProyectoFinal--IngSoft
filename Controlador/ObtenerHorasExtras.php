<?php
header('Content-Type: application/json');

require_once '../Config/config.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    try {
        $conn = getConnection();
        $sql = "SELECT Fecha, Hora_Inicio, Hora_Salida, Monto FROM extras WHERE Empleados_Persona_Cedula = ? ORDER BY Hora_Inicio DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);
        $extras = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($extras);
    } catch (PDOException $e) {
        echo json_encode(["error" => true, "message" => "Error al obtener horas extras: " . $e->getMessage()]);
    } finally {
        $conn = null;
    }
} else {
    echo json_encode(["error" => true, "message" => "Usuario no autenticado. Inicie sesión para ver horas extra."]);
}
?>