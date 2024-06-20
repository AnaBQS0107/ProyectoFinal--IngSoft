<?php
include_once '../Config/config.php';

try {
    $host = "localhost:3307";
    $db_name = "servicio_autobuses";
    $username = "root";
    $password = "";
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST['Cedula'];
    $contrasena = $_POST['Contrasena'];
    $nombre = $_POST['Nombre'];
    $apellido1 = $_POST['Apellido1'];
    $apellido2 = $_POST['Apellido2'];
    $email = $_POST['Correo_Electronico'];
    $estacion_id = $_POST['Estacion_ID'];
    $rol_id = $_POST['Rol_ID'];
    $fechaIngreso = $_POST['Fecha'];
    $salarioBase = $_POST['SalarioBase']; // Assuming this input exists

    try {
        // Begin transaction
        $conn->beginTransaction();

        // Insert into persona table
        $sql_persona = "INSERT INTO persona (Cedula, Nombre, Primer_Apellido, Segundo_Apellido)
                        VALUES (:cedula, :nombre, :apellido1, :apellido2)";
        $stmt_persona = $conn->prepare($sql_persona);
        $stmt_persona->bindParam(':cedula', $cedula);
        $stmt_persona->bindParam(':nombre', $nombre);
        $stmt_persona->bindParam(':apellido1', $apellido1);
        $stmt_persona->bindParam(':apellido2', $apellido2);
        $stmt_persona->execute();

        // Insert into empleados table
        $sql_empleados = "INSERT INTO empleados (Fecha_Ingreso, Persona_Cedula, Roles_idRoles, SalarioBase, EstacionesPeaje_idEstacionesPeaje)
                          VALUES (:fechaIngreso, :cedula, :rol_id, :salarioBase, :estacion_id)";
        $stmt_empleados = $conn->prepare($sql_empleados);
        $stmt_empleados->bindParam(':fechaIngreso', $fechaIngreso);
        $stmt_empleados->bindParam(':cedula', $cedula);
        $stmt_empleados->bindParam(':rol_id', $rol_id);
        $stmt_empleados->bindParam(':salarioBase', $salarioBase);
        $stmt_empleados->bindParam(':estacion_id', $estacion_id);
        $stmt_empleados->execute();

        // Insert into usuarios table
        $sql_usuarios = "INSERT INTO usuarios (Contraseña, Empleados_Persona_Cedula)
                         VALUES (:contrasena, :cedula)";
        $stmt_usuarios = $conn->prepare($sql_usuarios);
        $stmt_usuarios->bindParam(':contrasena',$contrasena);
        $stmt_usuarios->bindParam(':cedula', $cedula);
        $stmt_usuarios->execute();

        // Commit transaction
        $conn->commit();

        echo "Registro exitoso.";
    } catch(PDOException $e) {
        // Rollback transaction if something failed
        $conn->rollBack();
        echo "Error al insertar registro: " . $e->getMessage();
    }
}
?>
