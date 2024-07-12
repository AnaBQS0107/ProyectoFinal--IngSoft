<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$response = ['success' => false, 'message' => ''];

if (isset($_POST['Empleados_Persona_Cedula'])) {
    $Empleados_Persona_Cedula = htmlspecialchars($_POST['Empleados_Persona_Cedula']);

    if (isset($_SESSION['aguinaldo_calculado'])) {
        $aguinaldo = $_SESSION['aguinaldo_calculado'];

        // Conexión a la base de datos
        require_once '../Config/config.php';
        $db = Database1::getInstance()->getConnection();

        try {
            // Guardar el aguinaldo en la base de datos
            $stmt = $db->prepare("INSERT INTO aguinaldo (Empleados_Persona_Cedula1, Monto_A_Pagar, Meses) VALUES (:cedula, :aguinaldo, NOW())");
            $stmt->bindParam(':cedula', $Empleados_Persona_Cedula);
            $stmt->bindParam(':aguinaldo', $aguinaldo);
            $stmt->execute();

            // Responder con éxito
            $response['success'] = true;
            $response['message'] = 'Aguinaldo guardado correctamente.';
        } catch (Exception $e) {
            // Error al ejecutar la consulta
            $response['message'] = 'Error al guardar el aguinaldo: ' . $e->getMessage();
        }
    } else {
        // No se ha calculado el aguinaldo
        $response['message'] = 'No se ha calculado el aguinaldo.';
    }
} else {
    // Datos faltantes
    $response['message'] = 'Datos incompletos.';
}

header('Content-Type: application/json');
echo json_encode($response);
?>