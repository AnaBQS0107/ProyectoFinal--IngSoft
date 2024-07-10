<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Conexión a la base de datos
require_once '../Config/config.php';
$db = Database1::getInstance()->getConnection();

$Empleados_Persona_Cedula = htmlspecialchars($_SESSION['user']['Persona_Cedula']);

if (isset($_POST['salarios']) && is_array($_POST['salarios'])) {
    $salarios = array_map('floatval', $_POST['salarios']);
    $totalSalarios = array_sum($salarios);
    $promedioMensual = $totalSalarios / count($salarios);
    $aguinaldo = $promedioMensual;
    $meses = implode(',', array_keys($_POST['salarios'])); // Convertir las claves de los salarios en una lista de meses separados por comas

    // Calculo del salario en especie
    if (isset($_POST['salarioEspecie'])) {
        $salarioEspecie = intval($_POST['salarioEspecie']);
        if ($salarioEspecie == 1 && isset($_POST['PorcentajeEspecie'])) {
            $porcentajeEspecie = floatval($_POST['PorcentajeEspecie']);
            $aguinaldo += $promedioMensual * ($porcentajeEspecie / 100);
        } elseif ($salarioEspecie == 2 && isset($_POST['MontoMensualEspecie'])) {
            $montoEspecie = floatval($_POST['MontoMensualEspecie']);
            $aguinaldo += $montoEspecie;
        }
    }

    // Guardar el aguinaldo en la base de datos
    try {
        $stmt = $db->prepare("INSERT INTO aguinaldo (Empleados_Persona_Cedula1, Monto_A_Pagar, Meses) VALUES (:cedula, :monto, :meses) ON DUPLICATE KEY UPDATE Monto_A_Pagar = :monto, Meses = :meses");
        $stmt->bindParam(':cedula', $Empleados_Persona_Cedula);
        $stmt->bindParam(':monto', $aguinaldo);
        $stmt->bindParam(':meses', $meses);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Aguinaldo calculado y guardado exitosamente.', 'aguinaldo' => $aguinaldo]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al guardar el aguinaldo: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Faltan datos necesarios para calcular el aguinaldo.']);
}
?>