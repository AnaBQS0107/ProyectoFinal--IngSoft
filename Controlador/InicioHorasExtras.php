<?php
// Iniciar sesión si aún no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluir la configuración y la conexión a la base de datos
require_once '../Config/config.php';

// Verificar si el usuario está autenticado y obtener su ID (Cédula)
if (isset($_SESSION['user']['Persona_Cedula'])) {
    $user_id = $_SESSION['user']['Persona_Cedula'];

    try {
        // Obtener la conexión a la base de datos
        $conn = getConnection();

        // Insertar la hora de inicio de las horas extras para el usuario actual con la fecha actual
        $sql = "INSERT INTO extras (Empleados_Persona_Cedula, Hora_Inicio, Fecha) VALUES (?, NOW(), CURDATE())";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);

        // Si se insertó correctamente, devolver un mensaje de éxito
        echo json_encode(["message" => "Inicio de horas extra registrado correctamente"]);
    } catch (PDOException $e) {
        // Capturar y mostrar cualquier error de la base de datos
        echo json_encode(["error" => true, "message" => "Error al registrar inicio de horas extra: " . $e->getMessage()]);
    } finally {
        // Cerrar la conexión a la base de datos
        $conn = null;
    }
} else {
    // Si el usuario no está autenticado, devolver un mensaje de error
    echo json_encode(["error" => true, "message" => "Usuario no autenticado. Inicie sesión para iniciar horas extra."]);
}
?>
