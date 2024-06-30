<?php
include '../Config/config.php';

// Obtener la conexión a la base de datos
$conn = getConnection();

// Verificar si el parámetro user_id se recibió correctamente
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Preparar la consulta SQL para obtener el total mensual de horas extras
    $sql = "SELECT SUM(TIMESTAMPDIFF(HOUR, Hora_Inicio, Hora_Salida)) AS monthly_total 
            FROM extras 
            WHERE Empleados_Persona_Cedula = ? 
            AND MONTH(Hora_Inicio) = MONTH(CURRENT_DATE())";

    // Preparar la declaración
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();

    // Vincular el resultado de la consulta a variables
    $stmt->bindColumn('monthly_total', $monthly_total);
    $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se obtuvieron resultados
    if ($monthly_total !== null) {
        echo json_encode(["monthly_total" => (int) $monthly_total]);
    } else {
        // Si no hay resultados, devolver un total mensual de 0 horas
        echo json_encode(["monthly_total" => 0]);
    }

    // Cerrar la declaración preparada
    $stmt->closeCursor();
} else {
    // Si no se recibió user_id, devolver un error
    echo json_encode(["error" => true, "message" => "No se proporcionó el ID de usuario"]);
}

// Cerrar la conexión a la base de datos
$conn = null;
?>
