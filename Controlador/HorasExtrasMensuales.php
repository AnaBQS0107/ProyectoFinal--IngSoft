<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

require_once '../Config/config.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    try {
        $conn = getConnection();

        $sql = "SELECT SUM(Monto) AS monthly_total FROM extras WHERE Empleados_Persona_Cedula = ? AND MONTH(Fecha) = MONTH(CURRENT_DATE()) AND YEAR(Fecha) = YEAR(CURRENT_DATE())";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode(["monthly_total" => $result['monthly_total'] ? $result['monthly_total'] : 0]);
        } else {
            echo json_encode(["monthly_total" => 0]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => true, "message" => "Error al obtener total mensual: " . $e->getMessage()]);
    } finally {
        $conn = null;
    }
} else {
    echo json_encode(["error" => true, "message" => "Usuario no autenticado. Inicie sesión para ver el total mensual."]);
}
?>