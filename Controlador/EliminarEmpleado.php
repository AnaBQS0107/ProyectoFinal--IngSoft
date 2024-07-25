<?php
require_once '../Config/config.php';

if (isset($_GET['Cedula'])) {
    $Cedula_empleado = $_GET['Cedula'];

    $database = new Database1();
    $conn = $database->getConnection();

    try {
        $conn->beginTransaction();
        $query_empleados = "UPDATE empleados SET Estado = 'inactivo' WHERE Persona_Cedula = :Cedula";
        $stmt_empleados = $conn->prepare($query_empleados);
        $stmt_empleados->bindParam(':Cedula', $Cedula_empleado);
        $stmt_empleados->execute();

        $conn->commit();

        echo "success";
    } catch (PDOException $exception) {
        $conn->rollback();
        echo "Error al actualizar el estado del empleado: " . $exception->getMessage();
    }
} else {
    echo "Solicitud de Cédula inválida.";
}
?>
