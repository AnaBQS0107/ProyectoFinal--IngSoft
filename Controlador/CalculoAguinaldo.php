<?php
require_once '../Config/config.php';

// Verifica si la sesión está activa, de lo contrario la inicia
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica si el usuario está autenticado en la sesión
if (!isset($_SESSION['user'])) {
    echo json_encode(array('error' => 'Usuario no autenticado. Por favor, inicia sesión para continuar.'));
    exit;
}

// Función para calcular el aguinaldo y guardar en la base de datos
function calcularAguinaldo($salarios, $Empleados_Persona_Cedula, $salarioEnEspecie, $esPorcentaje, $montoMensual) {
    // Suma de todos los salarios
    $sumaSalarios = array_sum($salarios);

    // Añadir salario en especie si aplica
    if ($salarioEnEspecie) {
        if ($esPorcentaje) {
            $sumaSalarios += ($sumaSalarios * ($salarioEnEspecie / 100));
        } else {
            $sumaSalarios += $montoMensual * count($salarios);
        }
    }

    // Calcular el aguinaldo
    $aguinaldo = $sumaSalarios / 12;

    try {
        // Conectar a la base de datos y preparar la consulta SQL para insertar el aguinaldo
        $db = Database1::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO aguinaldo (Meses, Monto_A_Pagar, Empleados_Persona_Cedula1) VALUES (NOW(), :monto, :cedula)");
        $stmt->bindParam(':monto', $aguinaldo);
        $stmt->bindParam(':cedula', $Empleados_Persona_Cedula);
        $stmt->execute();

        // Devolver un mensaje de éxito junto con el aguinaldo calculado
        return array('success' => true, 'message' => 'Aguinaldo calculado y guardado correctamente.', 'aguinaldo' => $aguinaldo);
    } catch (PDOException $e) {
        // Devolver un mensaje de error si falla la consulta
        return array('success' => false, 'message' => 'Error al calcular y guardar el aguinaldo: ' . $e->getMessage());
    }
}

// Verifica si se enviaron salarios y el ID del empleado
if (isset($_POST['salarios']) && isset($_POST['Empleados_Persona_Cedula'])) {
    // Sanitizar los datos recibidos
    $salarios = array_map('intval', $_POST['salarios']);
    $Empleados_Persona_Cedula = htmlspecialchars($_POST['Empleados_Persona_Cedula']);

    // Verificar si hay salario en especie y obtener los detalles
    $salarioEnEspecie = isset($_POST['salarioEspecie']) ? intval($_POST['salarioEspecie']) : 0;
    $esPorcentaje = isset($_POST['esPorcentaje']) ? true : false;
    $montoMensual = isset($_POST['montoMensual']) ? floatval($_POST['montoMensual']) : 0;

    // Calcular y guardar el aguinaldo
    $resultado = calcularAguinaldo($salarios, $Empleados_Persona_Cedula, $salarioEnEspecie, $esPorcentaje, $montoMensual);

    // Mostrar el resultado como JSON
    echo json_encode($resultado);
} else {
    // Devolver un mensaje de error si faltan datos
    echo json_encode(array('success' => false, 'message' => 'Faltan datos necesarios para calcular el aguinaldo.'));
}
?>