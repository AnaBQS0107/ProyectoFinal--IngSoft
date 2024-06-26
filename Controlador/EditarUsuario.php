<?php
require_once '../Config/config.php';

// Función para obtener conexión a la base de datos
function obtenerConexion() {
    $database = new Database1();
    return $database->getConnection();
}

function obtenerEmpleadoPorId($cedula) {
    $conn = obtenerConexion();

    try {
        $query = "SELECT p.Nombre, p.Primer_Apellido, p.Segundo_Apellido, e.Correo_Electronico, 
                         est.Nombre as NombreEstacion, e.EstacionesPeaje_idEstacionesPeaje, 
                         r.Nombre_Rol as NombreRol, e.Roles_idRoles, u.Contraseña
                  FROM persona p
                  INNER JOIN empleados e ON p.Cedula = e.Persona_Cedula
                  LEFT JOIN usuarios u ON e.Persona_Cedula = u.Empleados_Persona_Cedula
                  LEFT JOIN estacionespeaje est ON e.EstacionesPeaje_idEstacionesPeaje = est.idEstacionesPeaje
                  LEFT JOIN roles r ON e.Roles_idRoles = r.idRoles
                  WHERE p.Cedula = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $cedula);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
        // Manejo del error en caso de falla en la consulta
        error_log("Error al obtener empleado por ID: " . $exception->getMessage());
        return false;
    }
}

function actualizarEmpleado($cedula, $datos) {
    $conn = obtenerConexion();

    try {
        // Actualizar tabla persona
        $sql_persona = "UPDATE persona SET Nombre = :nombre, Primer_Apellido = :apellido1, Segundo_Apellido = :apellido2 WHERE Cedula = :cedula";
        $stmt_persona = $conn->prepare($sql_persona);
        $stmt_persona->bindParam(':nombre', $datos['nombre']);
        $stmt_persona->bindParam(':apellido1', $datos['apellido1']);
        $stmt_persona->bindParam(':apellido2', $datos['apellido2']);
        $stmt_persona->bindParam(':cedula', $cedula);
        $stmt_persona->execute();
    
        // Actualizar tabla empleados
        $sql_empleados = "UPDATE empleados SET Correo_Electronico = :correo, EstacionesPeaje_idEstacionesPeaje = :estacionID, Roles_idRoles = :rolID WHERE Persona_Cedula = :cedula";
        $stmt_empleados = $conn->prepare($sql_empleados);
        $stmt_empleados->bindParam(':correo', $datos['Correo']);
        $stmt_empleados->bindParam(':estacionID', $datos['Estacion_ID']);
        $stmt_empleados->bindParam(':rolID', $datos['Rol_ID']); // Aquí se usa el valor del rol
        $stmt_empleados->bindParam(':cedula', $cedula);
        $stmt_empleados->execute();
    
        // Actualizar tabla usuarios (si existe)
        if (isset($datos['Contrasena'])) {
            $sql_usuarios = "UPDATE usuarios SET Contraseña = :contrasena WHERE Empleados_Persona_Cedula = :cedula";
            $stmt_usuarios = $conn->prepare($sql_usuarios);
            $stmt_usuarios->bindParam(':contrasena', $datos['Contrasena']);
            $stmt_usuarios->bindParam(':cedula', $cedula);
            $stmt_usuarios->execute();
        }
    
        return true; // Retorna true si todas las actualizaciones fueron exitosas
    } catch (PDOException $e) {
        // Manejo del error en caso de falla en la actualización
        error_log("Error al actualizar empleado: " . $e->getMessage());
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
            // Redirigir a la lista de empleados después de actualizar
            header("Location: ../Vista/ListaDeEmpleados.php");
            exit;
        } else {
            // Manejar el caso de error de actualización (puedes redirigir a otra página de error si lo deseas)
            echo "Hubo un error al actualizar el empleado.";
            exit;
        }
    } else {
        // Si es una petición GET, mostrar el formulario para editar el empleado
        $empleado = obtenerEmpleadoPorId($id_empleado);
        if ($empleado) {
            include_once '../Vista/ActualizarEmpleado.php'; // Incluir el formulario de actualización
        } else {
            // Manejar el caso de empleado no encontrado (puedes redirigir a otra página de error si lo deseas)
            echo "Empleado no encontrado.";
            exit;
        }
    }
} else {
    // Si no se proporcionó un ID válido, redirigir a la lista de empleados
    header("Location: ../Vista/ListaDeEmpleados.php");
    exit;
}
?>
