<?php
session_start();

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

require_once '../Config/config.php';
require_once '../Modelo/Validar_Credenciales.php';

// Función para obtener el nombre de la estación por ID
function obtenerEstacionPorID($estacionID, $conn) {
    $query = "SELECT idEstacionesPeaje, Nombre FROM EstacionesPeaje WHERE idEstacionesPeaje = :idEstacionesPeaje";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idEstacionesPeaje', $estacionID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Función para obtener el tipo de vehículo por ID
function obtenerTipoVehiculoPorID($tipoVehiculoID, $conn) {
    $query = "SELECT idTipoVehiculo, Tipo FROM TipoVehiculo WHERE idTipoVehiculo = :idTipoVehiculo";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idTipoVehiculo', $tipoVehiculoID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Inicializar $cobro para evitar errores de variable no definida y acceso a índices en un valor nulo
$cobro = [
    'idCobrosPeaje' => '',
    'Fecha' => '',
    'EstacionesPeaje_idEstacionesPeaje' => '',
    'Empleados_Persona_Cedula' => '',
    'TipoVehiculo_idTipoVehiculo' => '',
    'TipoVehiculo_Codigo' => '',
    'TipoVehiculo_Tarifa' => ''
];

// Obtener datos del cobro si se está editando
if (isset($_GET['id'])) {
    $idCobro = $_GET['id'];

    try {
        // Obtener la conexión a la base de datos
        $database = new Database1(); // Asegúrate de tener la clase Database1 configurada y funcionando correctamente
        $conn = $database->getConnection();

        // Verificar si la conexión se estableció correctamente
        if ($conn) {
            $query = "SELECT 
                        cp.idCobrosPeaje, 
                        cp.Fecha, 
                        cp.EstacionesPeaje_idEstacionesPeaje, 
                        cp.Empleados_Persona_Cedula, 
                        cp.TipoVehiculo_idTipoVehiculo, 
                        cp.TipoVehiculo_Codigo, 
                        cp.TipoVehiculo_Tarifa,
                        e.Nombre AS NombreEstacion,
                        p.Cedula AS Empleados_Persona_Cedula
                      FROM 
                        CobrosPeaje cp
                      INNER JOIN EstacionesPeaje e ON cp.EstacionesPeaje_idEstacionesPeaje = e.idEstacionesPeaje
                      INNER JOIN persona p ON cp.Empleados_Persona_Cedula = p.Cedula
                      WHERE 
                        cp.idCobrosPeaje = :idCobro";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':idCobro', $idCobro, PDO::PARAM_INT);
            $stmt->execute();
            $cobro = $stmt->fetch(PDO::FETCH_ASSOC);

        } else {
            echo "No se pudo establecer la conexión.";
        }

    } catch (PDOException $e) {
        echo "Error al obtener datos: " . $e->getMessage();
    }
}

// Procesar el formulario si se envió por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario POST
    $idCobrosPeaje = $_POST["idCobrosPeaje"];
    $fecha = $_POST["Fecha"];
    $estacion_id = $_POST["EstacionesPeaje_idEstacionesPeaje"];
    $cedula_empleado = $_POST["Empleados_Persona_Cedula"];
    $tipo_vehiculo_id = $_POST["TipoVehiculo_idTipoVehiculo"];
    $tipo_vehiculo_codigo = $_POST["TipoVehiculo_Codigo"];
    $tipo_vehiculo_tarifa = $_POST["TipoVehiculo_Tarifa"];

    try {
        // Obtener la conexión a la base de datos
        $database = new Database1(); // Asegúrate de tener la clase Database1 configurada y funcionando correctamente
        $conn = $database->getConnection();

        // Verificar si la conexión se estableció correctamente
        if ($conn) {
            // Actualizar o insertar en la tabla CobrosPeaje
            if (!empty($idCobrosPeaje)) {
                // Actualizar el cobro existente
                $query = "UPDATE CobrosPeaje 
                          SET Fecha = :fecha, 
                              EstacionesPeaje_idEstacionesPeaje = :estacion_id, 
                              Empleados_Persona_Cedula = :cedula_empleado, 
                              TipoVehiculo_idTipoVehiculo = :tipo_vehiculo_id, 
                              TipoVehiculo_Codigo = :tipo_vehiculo_codigo, 
                              TipoVehiculo_Tarifa = :tipo_vehiculo_tarifa 
                          WHERE idCobrosPeaje = :idCobrosPeaje";
        
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':idCobrosPeaje', $idCobrosPeaje, PDO::PARAM_INT);
            } else {
                // Insertar un nuevo cobro
                $query = "INSERT INTO CobrosPeaje (Fecha, EstacionesPeaje_idEstacionesPeaje, Empleados_Persona_Cedula, TipoVehiculo_idTipoVehiculo, TipoVehiculo_Codigo, TipoVehiculo_Tarifa) 
                          VALUES (:fecha, :estacion_id, :cedula_empleado, :tipo_vehiculo_id, :tipo_vehiculo_codigo, :tipo_vehiculo_tarifa)";
        
                $stmt = $conn->prepare($query);
            }
        
            // Bind de parámetros y ejecución de la consulta
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':estacion_id', $estacion_id, PDO::PARAM_INT);
            $stmt->bindParam(':cedula_empleado', $cedula_empleado, PDO::PARAM_INT);
            $stmt->bindParam(':tipo_vehiculo_id', $tipo_vehiculo_id, PDO::PARAM_INT);
            $stmt->bindParam(':tipo_vehiculo_codigo', $tipo_vehiculo_codigo);
            $stmt->bindParam(':tipo_vehiculo_tarifa', $tipo_vehiculo_tarifa);
        
            $stmt->execute();
        
            // Redirigir a otra página después de la operación
            header('Location: ../Vista/TablaCobros.php');
            exit; // Asegura que se detiene la ejecución después de la redirección
        } else {
            echo "No se pudo establecer la conexión.";
        }
        

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>




