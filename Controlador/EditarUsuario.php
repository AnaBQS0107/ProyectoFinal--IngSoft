<?php
require_once '../Config/config.php';

// Función para obtener conexión a la base de datos
function obtenerConexion() {
    $database = new Database1();
    return $database->getConnection();
}

// Función para obtener información del empleado por ID
function obtenerEmpleadoPorId($id_empleado) {
    $conn = obtenerConexion();

    try {
        $query = "SELECT * FROM trabajadores WHERE ID = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id_empleado);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
        echo "Error: " . $exception->getMessage();
        return false;
    }
}

// Función para actualizar la información del empleado
function actualizarEmpleado($id_empleado, $datos) {
    $conn = obtenerConexion();

    try {
        $query = "UPDATE trabajadores SET Nombre = :nombre, Cedula = :cedula, Contrasena = :contrasena, Apellido1 = :apellido1, Apellido2 = :apellido2, Correo_Electronico = :correo,  Estacion_ID = :estacion_id, Rol_ID = :rol_id WHERE ID = :id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':nombre', $datos['Nombre']);
        $stmt->bindParam(':cedula', $datos['Cedula']);
        $stmt->bindParam(':contrasena', $datos['Contrasena']);
        $stmt->bindParam(':apellido1', $datos['Apellido1']);
        $stmt->bindParam(':apellido2', $datos['Apellido2']);
        $stmt->bindParam(':correo', $datos['Correo_Electronico']);
        $stmt->bindParam(':estacion_id', $datos['Estacion_ID']);
        $stmt->bindParam(':rol_id', $datos['Roles']);
        $stmt->bindParam(':id', $id_empleado);

        return $stmt->execute();
    } catch (PDOException $exception) {
        echo "Error: " . $exception->getMessage();
        return false;
    }
}

// Inicio del manejo de la petición
if (isset($_GET['id'])) {
    $id_empleado = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Si se envió el formulario, actualizar el empleado
        $actualizacion_exitosa = actualizarEmpleado($id_empleado, $_POST);

        if ($actualizacion_exitosa) {
            echo "Empleado actualizado exitosamente.";
            echo '<script>setTimeout(function(){ location.reload(); }, 2000);</script>';
            exit;
        } else {
            echo "Error al actualizar el empleado.";
        }
    } else {
        // Si es una petición GET, mostrar el formulario para editar el empleado
        $empleado = obtenerEmpleadoPorId($id_empleado);
        if ($empleado) {
            include_once '../Vista/ActualizarEmpleado.php'; // Incluir el formulario de actualización
        } else {
            echo "Empleado no encontrado.";
        }
    }
} else {
    // Si no se proporcionó un ID válido, redirigir a la lista de empleados
    header("Location: ../Vista/ListaDeEmpleados");
    exit;
}
?>
