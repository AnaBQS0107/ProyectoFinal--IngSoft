<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

require_once '../Config/config.php';

if (isset($_POST['user_id']) && isset($_POST['description'])) {
    $user_id = $_POST['user_id'];
    $description = $_POST['description'];

    try {
        $conn = getConnection();

        $sql = "SELECT Hora_Inicio FROM extras WHERE Empleados_Persona_Cedula = ? AND Hora_Salida IS NULL ORDER BY Hora_Inicio DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $horaInicio = new DateTime($result['Hora_Inicio']);
            $horaSalida = new DateTime();
            $intervalo = $horaInicio->diff($horaSalida);
            $horasExtras = $intervalo->h + ($intervalo->i / 60);

            $sql = "SELECT SalarioBase FROM empleados WHERE Persona_Cedula = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $salarioBase = $result['SalarioBase'];
                $monto = ($salarioBase / 240) * 1.5 * $horasExtras;

                $sql = "UPDATE extras SET Hora_Salida = NOW(), Monto = ?, Descripcion = ? WHERE Empleados_Persona_Cedula = ? AND Hora_Salida IS NULL ORDER BY Hora_Inicio DESC LIMIT 1";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$monto, $description, $user_id]);

                echo json_encode(["message" => "Fin de horas extra registrado correctamente"]);
            } else {
                echo json_encode(["error" => true, "message" => "No se encontró el salario del empleado"]);
            }
        } else {
            echo json_encode(["error" => true, "message" => "No hay horas extra iniciadas para este usuario"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => true, "message" => "Error al registrar fin de horas extra: " . $e->getMessage()]);
    } finally {
        $conn = null;
    }
} else {
    echo json_encode(["error" => true, "message" => "Datos incompletos para registrar fin de horas extra"]);
}
?>