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

    // Obtener los días de vacaciones disponibles del empleado
    $sql = "SELECT VacacionesDisponibles FROM empleados WHERE Persona_Cedula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cedula);
    $stmt->execute();
    $stmt->bind_result($VacacionesDisponibles);
    $stmt->fetch();
    $stmt->close();

    if ($VacacionesDisponibles === null) {
        $response = [
            'success' => false,
            'message' => 'Empleado no encontrado.'
        ];
        echo json_encode($response);
        exit;
    }

    if ($VacacionesDisponibles <= 0) {
        $response = [
            'success' => false,
            'message' => 'No tienes días de vacaciones disponibles.'
        ];
        echo json_encode($response);
        exit;
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

    if ($diasVacaciones > $VacacionesDisponibles) {
        $response = [
            'success' => false,
            'message' => 'No tienes suficientes días de vacaciones disponibles. Tienes ' . $VacacionesDisponibles . ' días disponibles.'
        ];
        echo json_encode($response);
        exit;
    }

    $salarioDiario = $salarioMensual / 30;
    $salarioVacacional = $diasVacaciones * $salarioDiario;

    // Insertar la solicitud de vacaciones con estado 'pendiente'
    $sql = "INSERT INTO vacaciones (Fecha_Inicio, Fecha_Fin, Empleados_Persona_Cedula, Estado) VALUES (?, ?, ?, 'pendiente')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $fechaInicio, $fechaFin, $cedula);

    if ($stmt->execute()) {
        // Actualizar los días de vacaciones disponibles del empleado
        $diasRestantes = $VacacionesDisponibles - $diasVacaciones;
        $sql = "UPDATE empleados SET VacacionesDisponibles = ? WHERE Persona_Cedula = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $diasRestantes, $cedula);
        $stmt->execute();
        $stmt->close();

        $response = [
            'success' => true,
            'message' => 'La solicitud de vacaciones ha sido enviada y está pendiente de aprobación. El salario de vacaciones para el empleado con cédula ' . htmlspecialchars($cedula) . ' es: ₡' . number_format($salarioVacacional, 2) . '. Los días de vacaciones calculados son: ' . $diasVacaciones . ' días.'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error al insertar los datos en la tabla vacaciones.'
        ];
    }

    $conn->close();
    echo json_encode($response);
    exit;
} else {
    header('Location: ../Vista/CalcularVacaciones.php');
    exit;
}
?>
