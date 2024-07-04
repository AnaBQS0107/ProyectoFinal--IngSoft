<?php
require_once '../Config/config.php';

// Verifica si la sesión está activa, de lo contrario la inicia
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// Requiere nuevamente el archivo de configuración (esto debería ser innecesario si ya fue requerido en config.php)
require_once '../Config/config.php';

// Verifica si hay un ID de usuario en la solicitud
if (isset($_POST['user_id'])) {
    // Recoge el ID del usuario
    $user_id = $_POST['user_id'];

    // Función para calcular el aguinaldo
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
            
            // Devolver un mensaje de éxito
            return "Aguinaldo calculado y guardado correctamente.";
        } catch (PDOException $e) {
            // Devolver un mensaje de error si falla la consulta
            return "Error al calcular y guardar el aguinaldo: " . $e->getMessage();
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
        
        // Devolver el resultado como JSON
        echo json_encode(array('message' => $resultado));
    } else {
        // Devolver un mensaje de error si faltan datos
        echo json_encode(array('error' => 'Faltan datos necesarios para calcular el aguinaldo.'));
    }
} else {
    // Devolver un mensaje de error si no hay ID de usuario
    echo json_encode(array('error' => 'Usuario no autenticado.'));
}
?>