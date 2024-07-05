<?php
include_once '../Config/config.php';

$host = "localhost:3307";
$db_name = "servicio_autobuses";
$username = "root";
$password = "";
$conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql_roles = "SELECT idRoles, Nombre_Rol FROM roles";
$stmt_roles = $conn->prepare($sql_roles);
$stmt_roles->execute();
$resultRoles = $stmt_roles->fetchAll(PDO::FETCH_ASSOC);


$sql_estaciones = "SELECT idEstacionesPeaje, Nombre FROM estacionespeaje";
$stmt_estaciones = $conn->prepare($sql_estaciones);
$stmt_estaciones->execute();
$resultEstaciones = $stmt_estaciones->fetchAll(PDO::FETCH_ASSOC);


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
    $salarioBase = $_POST['SalarioBase'];

    try {

        $conn->beginTransaction();

        $sql_persona = "INSERT INTO persona (Cedula, Nombre, Primer_Apellido, Segundo_Apellido)
                        VALUES (:cedula, :nombre, :apellido1, :apellido2)";
        $stmt_persona = $conn->prepare($sql_persona);
        $stmt_persona->bindParam(':cedula', $cedula);
        $stmt_persona->bindParam(':nombre', $nombre);
        $stmt_persona->bindParam(':apellido1', $apellido1);
        $stmt_persona->bindParam(':apellido2', $apellido2);
        $stmt_persona->execute();

        $sql_empleados = "INSERT INTO empleados (Fecha_Ingreso, Persona_Cedula, Roles_idRoles, SalarioBase, EstacionesPeaje_idEstacionesPeaje, Correo_Electronico)
                          VALUES (:fechaIngreso, :cedula, :rol_id, :salarioBase, :estacion_id, :email)";
        $stmt_empleados = $conn->prepare($sql_empleados);
        $stmt_empleados->bindParam(':fechaIngreso', $fechaIngreso);
        $stmt_empleados->bindParam(':cedula', $cedula);
        $stmt_empleados->bindParam(':rol_id', $rol_id);
        $stmt_empleados->bindParam(':salarioBase', $salarioBase);
        $stmt_empleados->bindParam(':estacion_id', $estacion_id);
        $stmt_empleados->bindParam(':email', $email);
        $stmt_empleados->execute();

// Hashear la contraseña
$contrasena_hasheada = password_hash($contrasena, PASSWORD_DEFAULT);

$sql_usuarios = "INSERT INTO usuarios (Contraseña, Empleados_Persona_Cedula)
                 VALUES (:contrasena, :cedula)";
$stmt_usuarios = $conn->prepare($sql_usuarios);
$stmt_usuarios->bindParam(':contrasena', $contrasena_hasheada); // Usar $contrasena_hasheada aquí
$stmt_usuarios->bindParam(':cedula', $cedula);
$stmt_usuarios->execute();


        $conn->commit();

        echo json_encode(['status' => 'success', 'message' => 'Registro exitoso']);
    } catch(PDOException $e) {
        $conn->rollBack();
        echo json_encode(['status' => 'error', 'message' => "Error al insertar registro: " . $e->getMessage()]);
    }
}
?>