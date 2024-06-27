<?php
include '../Config/config.php';

$conn = getConnection();

$user_id = $_POST['user_id'];
$end_time = date('Y-m-d H:i:s');

$sql = "UPDATE extras SET Hora_Salida = '$end_time', Fecha = '$end_time' WHERE Empleados_Persona_Cedula = '$user_id' AND Hora_Salida IS NULL";

if ($conn->query($sql) === TRUE) {
    $calculateHoursWorked = "UPDATE extras SET Monto = TIMESTAMPDIFF(HOUR, Hora_Inicio, Hora_Salida) * (SELECT salario FROM empleados WHERE Persona_Cedula = '$user_id') * 1.5 WHERE Empleados_Persona_Cedula = '$user_id' AND Hora_Salida = '$end_time'";
    if ($conn->query($calculateHoursWorked) === TRUE) {
        echo "Overtime ended and hours calculated";
    } else {
        echo "Error: Conexión fallida" . $calculateHoursWorked . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn = null;
?>