<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Asegúrate de que la cédula del empleado esté en la sesión
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

require_once '../Config/config.php'; // Asegúrate de que la ruta es correcta

if (!isset($conn)) {
    die('Error: No se pudo conectar a la base de datos.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener valores del formulario
    $fechaEntrada = $_POST['fechaEntrada'] ?? '';
    $fechaSalida = $_POST['fechaSalida'] ?? '';
    $preaviso = $_POST['preaviso'] ?? '';
    $motivoSalida = $_POST['salida'] ?? '';
    $tipoPago = $_POST['tipoPago'] ?? '';
    $saldoVacaciones = $_POST['saldoVacaciones'] ?? 0;
    $salarios = $_POST['salarios'] ?? [];

    // Recuperar la cédula del empleado logueado desde la sesión
    $Persona_Cedula = isset($user['Persona_Cedula']) ? $user['Persona_Cedula'] : '';

    // Depuración: Verificar valores recibidos
    var_dump($_POST);
    error_log('Cédula del empleado en la sesión: ' . $Persona_Cedula);

    // Verificar si la cédula del empleado existe en la base de datos
    $sqlVerificar = "SELECT COUNT(*) FROM empleados WHERE Persona_Cedula = :Persona_Cedula";
    $stmtVerificar = $conn->prepare($sqlVerificar);
    $stmtVerificar->bindParam(':Persona_Cedula', $Persona_Cedula);
    $stmtVerificar->execute();
    $existeEmpleado = $stmtVerificar->fetchColumn();

    if ($existeEmpleado == 0) {
        error_log("Error: La cédula del empleado no existe en la base de datos.");
        echo "Error: La cédula del empleado no existe en la base de datos.";
        exit; // Detener la ejecución si el empleado no existe
    }

    try {
        // Verificar y calcular fechas
        if (empty($fechaEntrada) || empty($fechaSalida)) {
            throw new Exception('Las fechas de entrada y salida son obligatorias.');
        }
        $date1 = new DateTime($fechaEntrada);
        $date2 = new DateTime($fechaSalida);
        $interval = $date1->diff($date2);
        $antiguedad = $interval->y . ' años, ' . $interval->m . ' meses, ' . $interval->d . ' días';

        // Validar y calcular salarios
        $salarios = array_map('floatval', $salarios);
        $sumSalarios = array_sum($salarios);
        $countSalarios = count($salarios);
        $salarioPromedio = $countSalarios > 0 ? $sumSalarios / $countSalarios : 0.00;
        $salarioDiario = $salarioPromedio / 30;

        // Calcular aguinaldo, vacaciones y cesantía
        $aguinaldo = $salarioPromedio * 0.50; // 50% del salario promedio
        $vacaciones = $saldoVacaciones * $salarioDiario;
        $preavisoMonto = 0.00; // Asumir que el preaviso se calculará basado en la selección del usuario
        $cesantia = $salarioPromedio * 3.53; // Basado en la antigüedad y salario promedio
        $total = $aguinaldo + $vacaciones + $preavisoMonto + $cesantia;

        // Insertar datos en la base de datos usando PDO
        $sql = "INSERT INTO liquidaciones (FechaEntrada, FechaSalida, Preaviso, MotivoSalida, TipoPago, Empleados_Persona_Cedula, VacacionesDisponibles, MontoVacaciones, MontoPreaviso, MontoCesantia, Total) 
        VALUES (:fechaEntrada, :fechaSalida, :preaviso, :motivoSalida, :tipoPago, :Persona_Cedula, :saldoVacaciones, :vacaciones, :preavisoMonto, :cesantia, :total)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fechaEntrada', $fechaEntrada);
        $stmt->bindParam(':fechaSalida', $fechaSalida);
        $stmt->bindParam(':preaviso', $preaviso);
        $stmt->bindParam(':motivoSalida', $motivoSalida);
        $stmt->bindParam(':tipoPago', $tipoPago);
        $stmt->bindParam(':Persona_Cedula', $Persona_Cedula); 
        $stmt->bindParam(':saldoVacaciones', $saldoVacaciones);
        $stmt->bindParam(':vacaciones', $vacaciones);
        $stmt->bindParam(':preavisoMonto', $preavisoMonto);
        $stmt->bindParam(':cesantia', $cesantia);
        $stmt->bindParam(':total', $total);

        // Ejecutar la consulta
        $stmt->execute();

        // Guardar resultados en la sesión
        $_SESSION['resultados'] = [
            'antiguedad' => $antiguedad,
            'salarioPromedio' => $salarioPromedio,
            'salarioDiario' => $salarioDiario,
            'rangoFechas' => "del " . $date1->format('d/m/Y') . " al " . $date2->format('d/m/Y'),
            'saldoVacaciones' => $saldoVacaciones,
            'aguinaldo' => $aguinaldo,
            'vacaciones' => $vacaciones,
            'preaviso' => $preavisoMonto,
            'cesantia' => $cesantia,
            'total' => $total,
        ];

        header('Location: ../Vista/Resultados.php');
        exit();
    } catch (Exception $e) {
        // Agregar esta línea para depurar
        error_log('Error al calcular las liquidaciones: ' . $e->getMessage());
        $_SESSION['error'] = 'Error al calcular las liquidaciones: ' . $e->getMessage();
        header('Location: ../Vista/error.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'Método no permitido.';
    header('Location: ../Vista/error.php');
    exit();
}
?>
