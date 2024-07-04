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


        $sql = "SELECT idExtras, Hora_Inicio FROM extras WHERE Empleados_Persona_Cedula = ? AND Hora_Salida IS NULL ORDER BY Hora_Inicio DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);
        $extra = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($extra) {
            $idExtras = $extra['idExtras'];
            $horaInicio = $extra['Hora_Inicio'];

       
            $randomHours = rand(1, 8);
            $horaInicioDateTime = new DateTime($horaInicio);
            $horaInicioDateTime->add(new DateInterval('PT' . $randomHours . 'H'));
            $horaFinDateTime = $horaInicioDateTime->format('Y-m-d H:i:s');


            $interval = (new DateTime($horaInicio))->diff(new DateTime($horaFinDateTime));
            $minutos = ($interval->h * 60) + $interval->i;

            $horasCumplidas = ($minutos >= 45) ? ceil($minutos / 60) : 0;


            $sql = "SELECT SalarioBase FROM empleados WHERE Persona_Cedula = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$user_id]);
            $salariobase = $stmt->fetchColumn();

            $horaOrdinaria = $salariobase / 160;
            $mitadHoraOrdinaria = $horaOrdinaria / 2;
            $porHoraExtra = $horaOrdinaria + $mitadHoraOrdinaria;
            $monto = ($horasCumplidas * $porHoraExtra);

            $sql = "UPDATE extras SET Hora_Salida = ?, Monto = ?, Descripcion = ? WHERE idExtras = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$horaFinDateTime, $monto, $description, $idExtras]);
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
    echo json_encode(["error" => true, "message" => "Usuario no autenticado o descripción no proporcionada. Inicie sesión y proporcione una descripción para finalizar horas extra."]);
}
?>