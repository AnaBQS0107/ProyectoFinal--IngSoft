<?php
include_once '../Config/config.php';

$host = "localhost:3307";
$db_name = "servicio_autobuses";
$username = "root";
$password = "";
$conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Consulta para obtener los roles
$sql_roles = "SELECT idRoles, Nombre_Rol FROM roles";
$stmt_roles = $conn->prepare($sql_roles);
$stmt_roles->execute();
$resultRoles = $stmt_roles->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener las estaciones de peaje
$sql_estaciones = "SELECT idEstacionesPeaje, Nombre FROM estacionespeaje";
$stmt_estaciones = $conn->prepare($sql_estaciones);
$stmt_estaciones->execute();
$resultEstaciones = $stmt_estaciones->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener los horarios de trabajo
$sql_horarios = "SELECT IdHorario, CONCAT(Tipo, ' (', Entrada, ' - ', Salida, ')') AS Horario FROM horario_trabajo";
$stmt_horarios = $conn->prepare($sql_horarios);
$stmt_horarios->execute();
$resultHorarios = $stmt_horarios->fetchAll(PDO::FETCH_ASSOC);

$sql_vacaciones = "SELECT Persona_Cedula, VacacionesDisponibles FROM empleados";
$stmt_vacaciones = $conn->prepare($sql_vacaciones);
$stmt_vacaciones->execute();
$resultVacaciones = $stmt_vacaciones->fetchAll(PDO::FETCH_ASSOC);





function calcularVacaciones($fechaEntrada) {
    $fechaEntradaDateTime = new DateTime($fechaEntrada);
    $fechaActualDateTime = new DateTime();
    $interval = $fechaActualDateTime->diff($fechaEntradaDateTime);

    // Calcular días de vacaciones: 1 día por cada mes completo trabajado
    $mesesTrabajados = $interval->m + ($interval->y * 12); // Total de meses considerando años también
    $diasVacaciones = $mesesTrabajados;

    return $diasVacaciones;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $nombre = $_POST['Nombre'];
    $apellido1 = $_POST['Apellido1'];
    $apellido2 = $_POST['Apellido2'];
    $cedula = $_POST['Cedula'];
    $contrasena = $_POST['Contrasena'];
    $email = $_POST['Correo_Electronico'];
    $salarioBase = $_POST['SalarioBase'];
    $fechaEntrada = $_POST['Fecha'];
    $diasVacaciones = calcularVacaciones($fechaEntrada);
    $estacionID = $_POST['Estacion_ID'];
    $rolID = $_POST['Rol_ID'];
    $horarioID = $_POST['Horario_ID'];

    try {
        $conn->beginTransaction();

        // Insertar datos en la tabla persona
        $sql_persona = "INSERT INTO persona (Cedula, Nombre, Primer_Apellido, Segundo_Apellido)
                        VALUES (:cedula, :nombre, :apellido1, :apellido2)";
        $stmt_persona = $conn->prepare($sql_persona);
        $stmt_persona->bindParam(':cedula', $cedula);
        $stmt_persona->bindParam(':nombre', $nombre);
        $stmt_persona->bindParam(':apellido1', $apellido1);
        $stmt_persona->bindParam(':apellido2', $apellido2);
        $stmt_persona->execute();

        // Insertar datos en la tabla empleados
        $sql_empleados = "INSERT INTO empleados (Fecha_Ingreso, Persona_Cedula, Roles_idRoles, SalarioBase, EstacionesPeaje_idEstacionesPeaje, Correo_Electronico, Horario_idHorario, VacacionesDisponibles)
                          VALUES (:fechaIngreso, :cedula, :rol_id, :salarioBase, :estacion_id, :email, :horario_id, :vacaciones)";
        $stmt_empleados = $conn->prepare($sql_empleados);
        $stmt_empleados->bindParam(':fechaIngreso', $fechaEntrada);
        $stmt_empleados->bindParam(':cedula', $cedula);
        $stmt_empleados->bindParam(':rol_id', $rolID);
        $stmt_empleados->bindParam(':salarioBase', $salarioBase);
        $stmt_empleados->bindParam(':estacion_id', $estacionID);
        $stmt_empleados->bindParam(':email', $email);
        $stmt_empleados->bindParam(':horario_id', $horarioID);
        $stmt_empleados->bindParam(':vacaciones', $diasVacaciones);
        $stmt_empleados->execute();

        // Hashear la contraseña y insertar en la tabla usuarios
        $contrasena_hasheada = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql_usuarios = "INSERT INTO usuarios (Contraseña, Empleados_Persona_Cedula)
                         VALUES (:contrasena, :cedula)";
        $stmt_usuarios = $conn->prepare($sql_usuarios);
        $stmt_usuarios->bindParam(':contrasena', $contrasena_hasheada);
        $stmt_usuarios->bindParam(':cedula', $cedula);
        $stmt_usuarios->execute();

        $conn->commit();

        echo json_encode(['status' => 'success', 'message' => 'Registro exitoso']);
    } catch(PDOException $e) {
        $conn->rollBack();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}


?>