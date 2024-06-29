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
        $end_time = date('Y-m-d H:i:s');
        
        // Query to get the ongoing overtime entry
        $sql = "SELECT idExtras, Hora_Inicio FROM extras WHERE Empleados_Persona_Cedula = ? AND Hora_Salida IS NULL ORDER BY Hora_Inicio DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);
        $extra = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($extra) {
            $idExtras = $extra['idExtras'];
            $horaInicio = $extra['Hora_Inicio'];

            // Calculate the amount
            $sql = "SELECT SalarioBase FROM empleados WHERE Persona_Cedula = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$user_id]);
            $salariobase = $stmt->fetchColumn();

            $monto = (strtotime($end_time) - strtotime($horaInicio)) / 3600 * $salariobase * 1.5;

            // Update the ongoing overtime entry
            $sql = "UPDATE extras SET Hora_Salida = ?, Monto = ? WHERE idExtras = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$end_time, $monto, $idExtras]);
            echo json_encode(["message" => "Fin de horas extra registrado correctamente"]);
        } else {
            echo json_encode(["error" => true, "message" => "No se encontró un registro de horas extras en progreso"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => true, "message" => "Error al registrar fin de horas extra: " . $e->getMessage()]);
    } finally {
        $conn = null;
    }
} else {
    echo json_encode(["error" => true, "message" => "Usuario no autenticado. Inicie sesión para finalizar horas extra."]);
}
?>