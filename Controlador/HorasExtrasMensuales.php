<?php
include '../Config/config.php';

$conn = getConnection();

$user_id = $_GET['user_id'];

$sql = "SELECT SUM(TIMESTAMPDIFF(HOUR, Hora_Inicio, Hora_Salida)) AS monthly_total FROM extras WHERE Empleados_Persona_Cedula = '$user_id' AND MONTH(Hora_Inicio) = MONTH(CURRENT_DATE())";

$result = $conn->query($sql);

if ($result->rowCount() > 0) {
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
} else {
    echo json_encode(["monthly_total" => 0]);
}

$conn = null;
?>