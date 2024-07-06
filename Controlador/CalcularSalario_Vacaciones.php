<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['Empleados_Persona_Cedula'];
    $fechaInicio = $_POST['fecha_inicio'];
    $fechaFin = $_POST['fecha_fin'];

    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $dbname = "servicio_autobuses";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener el salario base del empleado
    $sql = "SELECT SalarioBase FROM empleados WHERE Persona_Cedula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cedula);
    $stmt->execute();
    $stmt->bind_result($salarioMensual);
    $stmt->fetch();
    $stmt->close();

    if ($salarioMensual === null) {
        $response = [
            'success' => false,
            'message' => 'Empleado no encontrado.'
        ];
        echo json_encode($response);
        exit;
    }

    $fechaInicioDateTime = new DateTime($fechaInicio);
    $fechaFinDateTime = new DateTime($fechaFin);
    $diasVacaciones = $fechaFinDateTime->diff($fechaInicioDateTime)->days + 1; 


    $salarioDiario = $salarioMensual / 30; 
    $salarioVacacional = $diasVacaciones * $salarioDiario;

    $sql = "INSERT INTO vacaciones (Fecha_Inicio, Fecha_Fin, Empleados_Persona_Cedula) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $fechaInicio, $fechaFin, $cedula);

    if ($stmt->execute()) {
        $response = [
            'success' => true,
            'message' => 'El salario de vacaciones para el empleado con cédula ' . htmlspecialchars($cedula) . ' es: ₡' . number_format($salarioVacacional, 2) . '. Los días de vacaciones calculados son: ' . $diasVacaciones . ' días. Datos insertados correctamente en la tabla vacaciones.'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error al insertar los datos en la tabla vacaciones.'
        ];
    }

    $stmt->close();
    $conn->close();

    echo json_encode($response);
    exit;
} else {
  
    header('Location: ../Vista/CalcularVacaciones.php');
    exit;
}
?>
