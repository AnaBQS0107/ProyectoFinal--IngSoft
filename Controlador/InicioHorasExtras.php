<?php
include '../Config/config.php';

$conn = getConnection();

$user_id = $_POST['user_id'];
$start_time = date('Y-m-d H:i:s');

$sql = "INSERT INTO extras (Empleados_Persona_Cedula, Hora_Inicio) VALUES ('$user_id', '$start_time')";

if ($conn->query($sql) === TRUE) {
    echo "Overtime started";
} else {
    echo "Error: Conexión fallida" . $sql . "<br>" . $conn->error;
}

$conn = null;
?>