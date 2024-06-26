<?php
require_once '../Config/config.php';

if (isset($_GET['Cedula'])) {
    $Cedula_empleado = $_GET['Cedula'];

    $database = new Database1();
    $conn = $database->getConnection();

    try {
        // Comenzar una transacción
        $conn->beginTransaction();

        // Eliminar de la tabla 'usuario' (debe ser eliminado primero debido a la restricción de clave foránea)
        $query_usuario = "DELETE FROM usuarios WHERE Empleados_Persona_Cedula = :Cedula";
        $stmt_usuario = $conn->prepare($query_usuario);
        $stmt_usuario->bindParam(':Cedula', $Cedula_empleado);
        $stmt_usuario->execute();

        // Eliminar de la tabla 'empleados' (será eliminado automáticamente desde 'persona' debido a la configuración ON DELETE CASCADE)
        $query_empleados = "DELETE FROM empleados WHERE Persona_Cedula = :Cedula";
        $stmt_empleados = $conn->prepare($query_empleados);
        $stmt_empleados->bindParam(':Cedula', $Cedula_empleado);
        $stmt_empleados->execute();

        // No es necesario eliminar de la tabla 'persona' explícitamente si está configurada con ON DELETE CASCADE
        // Pero si lo deseas, puedes hacerlo después de eliminar empleados y usuarios
   
        $query_persona = "DELETE FROM persona WHERE Cedula = :Cedula";
        $stmt_persona = $conn->prepare($query_persona);
        $stmt_persona->bindParam(':Cedula', $Cedula_empleado);
        $stmt_persona->execute();
      

        // Commit si todas las operaciones fueron exitosas
        $conn->commit();

        echo "success"; // Devuelve 'success' si se eliminó correctamente
    } catch (PDOException $exception) {
        // Rollback en caso de error
        $conn->rollback();
        echo "Error al eliminar el empleado: " . $exception->getMessage();
        // Añadir más detalles de depuración si es necesario
    }
} else {
    echo "Solicitud de Cédula inválida.";
}
?>
