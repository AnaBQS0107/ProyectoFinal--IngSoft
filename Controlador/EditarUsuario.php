<?php
require_once '../Config/config.php';

function obtenerConexion() {
    $database = new Database1(); 
    return $database->getConnection();
}

function obtenerEmpleadoPorId($cedula) {
    $conn = obtenerConexion();

    try {
        $query = "SELECT p.Nombre, p.Primer_Apellido, p.Segundo_Apellido, e.Correo_Electronico, 
                         est.Nombre as NombreEstacion, e.EstacionesPeaje_idEstacionesPeaje, 
                         r.Nombre_Rol as NombreRol, e.Roles_idRoles, u.Contraseña, e.Horario_idHorario AS Horario_ID
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
        error_log("Error al obtener empleado por ID: " . $exception->getMessage());
        return false;
    }
}

function actualizarEmpleado($cedula, $datos) {
    $conn = obtenerConexion();

    try {

        $sql_persona = "UPDATE persona 
                        SET Nombre = :nombre, 
                            Primer_Apellido = :apellido1, 
                            Segundo_Apellido = :apellido2 
                        WHERE Cedula = :cedula";
        $stmt_persona = $conn->prepare($sql_persona);
        $stmt_persona->bindParam(':nombre', $datos['nombre']);
        $stmt_persona->bindParam(':apellido1', $datos['apellido1']);
        $stmt_persona->bindParam(':apellido2', $datos['apellido2']);
        $stmt_persona->bindParam(':cedula', $cedula);
        $stmt_persona->execute();


        $sql_empleados = "UPDATE empleados 
                          SET Correo_Electronico = :correo, 
                              EstacionesPeaje_idEstacionesPeaje = :estacionID, 
                              Roles_idRoles = :rolID 
                          WHERE Persona_Cedula = :cedula";
        $stmt_empleados = $conn->prepare($sql_empleados);
        $stmt_empleados->bindParam(':correo', $datos['Correo']);
        $stmt_empleados->bindParam(':estacionID', $datos['Estacion_ID']);
        $stmt_empleados->bindParam(':rolID', $datos['Rol_ID']);
        $stmt_empleados->bindParam(':cedula', $cedula);
        $stmt_empleados->execute();

    
        $sql_horario = "UPDATE empleados 
                        SET Horario_idHorario = :horarioID 
                        WHERE Persona_Cedula = :cedula";
        $stmt_horario = $conn->prepare($sql_horario);
        $stmt_horario->bindParam(':horarioID', $datos['Horario_ID']);
        $stmt_horario->bindParam(':cedula', $cedula);
        $stmt_horario->execute();

       
        if (isset($datos['Contrasena'])) {
            $sql_usuarios = "UPDATE usuarios 
                             SET Contraseña = :contrasena 
                             WHERE Empleados_Persona_Cedula = :cedula";
            $stmt_usuarios = $conn->prepare($sql_usuarios);
            $stmt_usuarios->bindParam(':contrasena', $datos['Contrasena']);
            $stmt_usuarios->bindParam(':cedula', $cedula);
            $stmt_usuarios->execute();
        }

        return true; 
    } catch (PDOException $e) {
        error_log("Error al actualizar empleado: " . $e->getMessage());
        return false;
    }
}


if (isset($_GET['id'])) {
    $id_empleado = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $actualizacion_exitosa = actualizarEmpleado($id_empleado, $_POST);

        if ($actualizacion_exitosa) {
            header("Location: ../Vista/ListaDeEmpleados.php");
            exit;
        } else {
            echo "Hubo un error al actualizar el empleado.";
            exit;
        }
    } else {
        $empleado = obtenerEmpleadoPorId($id_empleado);
        if ($empleado) {
            include_once '../Vista/ActualizarEmpleado.php';
        } else {
            echo "Empleado no encontrado.";
            exit;
        }
    }
} else {
    header("Location: ../Vista/ListaDeEmpleados.php");
    exit;
}
?>
