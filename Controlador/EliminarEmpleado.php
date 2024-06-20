<?php
require_once '../Config/config.php';

if (isset($_GET['Cedula'])) {
    $Cedula_empleado = $_GET['Cedula'];

    $database = new Database1();
    $conn = $database->getConnection();

    try {
        // Eliminar de la tabla 'usuario'
        $query_usuario = "DELETE FROM usuario WHERE Empleados_Persona_Cedula = :Cedula";
        $stmt_usuario = $conn->prepare($query_usuario);
        $stmt_usuario->bindParam(':Cedula', $Cedula_empleado);
        $stmt_usuario->execute();

        // Eliminar de la tabla 'empleados'
        $query_empleados = "DELETE FROM empleados WHERE Persona_Cedula = :Cedula";
        $stmt_empleados = $conn->prepare($query_empleados);
        $stmt_empleados->bindParam(':Cedula', $Cedula_empleado);
        $stmt_empleados->execute();

        // Eliminar de la tabla 'persona'
        $query_persona = "DELETE FROM persona WHERE Cedula = :Cedula";
        $stmt_persona = $conn->prepare($query_persona);
        $stmt_persona->bindParam(':Cedula', $Cedula_empleado);
        $stmt_persona->execute();

        echo "success"; // Devuelve 'success' si se eliminó correctamente
    } catch (PDOException $exception) {
        echo "Error al eliminar el empleado: " . $exception->getMessage();
    }
} else {
    echo "Solicitud de Cédula inválida.";
}
?>
