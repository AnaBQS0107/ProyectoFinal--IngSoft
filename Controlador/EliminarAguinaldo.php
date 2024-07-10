<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Conexión a la base de datos
require_once '../Config/config.php';
$db = Database1::getInstance()->getConnection();
$Empleados_Persona_Cedula = htmlspecialchars($_POST['Empleados_Persona_Cedula']);

try {
    $stmt = $db->prepare("DELETE FROM aguinaldo WHERE Empleados_Persona_Cedula1 = :cedula");
    $stmt->bindParam(':cedula', $Empleados_Persona_Cedula);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Aguinaldo eliminado exitosamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se encontró ningún registro de aguinaldo para eliminar.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error al eliminar el aguinaldo: ' . $e->getMessage()]);
}
?>