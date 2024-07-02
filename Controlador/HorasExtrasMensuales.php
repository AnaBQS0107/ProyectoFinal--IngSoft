<?php
include '../Config/config.php';


$conn = getConnection();


if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $sql = "SELECT SUM(TIMESTAMPDIFF(HOUR, Hora_Inicio, Hora_Salida)) AS monthly_total 
            FROM extras 
            WHERE Empleados_Persona_Cedula = ? 
            AND MONTH(Hora_Inicio) = MONTH(CURRENT_DATE())";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();


    $stmt->bindColumn('monthly_total', $monthly_total);
    $stmt->fetch(PDO::FETCH_ASSOC);


    if ($monthly_total !== null) {
        echo json_encode(["monthly_total" => (int) $monthly_total]);
    } else {
        echo json_encode(["monthly_total" => 0]);
    }


    $stmt->closeCursor();
} else {
    echo json_encode(["error" => true, "message" => "No se proporcionó el ID de usuario"]);
}


$conn = null;
?>
