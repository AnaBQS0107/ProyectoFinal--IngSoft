<?php
session_start();

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

require_once '../Config/config.php';
require_once '../Modelo/Validar_Credenciales.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["codigo"])) {
    $codigo = $_POST["codigo"];
    $insert = isset($_POST["insert"]) ? $_POST["insert"] : false;

    try {
        $database = new Database1();
        $conn = $database->getConnection();


        $query_peaje = "SELECT * FROM tipovehiculo WHERE Codigo = :codigo";
        $stmt_peaje = $conn->prepare($query_peaje);
        $stmt_peaje->bindParam(':codigo', $codigo);
        $stmt_peaje->execute();

        if ($stmt_peaje->rowCount() > 0) {
            $datos_peaje = $stmt_peaje->fetch(PDO::FETCH_ASSOC);

            $validador = new ValidarCredenciales();
            $estacion_data = $validador->getEstacionesPeaje($user['Nombre']);

            if ($estacion_data) {
                $estacion_nombre = $estacion_data['Nombre_Estacion'];
                
            
                $fecha_actual = new DateTime();
                $fecha_formateada = $fecha_actual->format('Y-m-d H:i:s'); 


                echo "<td>1</td>";
                echo "<td>" . $datos_peaje['Tipo'] . "</td>";
                echo "<td>" . $fecha_formateada . "</td>";
                echo "<td>" . $datos_peaje['Codigo'] . "</td>";
                echo "<td>" . $datos_peaje['Tarifa'] . "</td>";
                echo "<td>" . $user['Nombre'] . "</td>";
                echo "<td>" . $estacion_nombre . "</td>";
                echo "</tr>";
                echo "</table>";

                if ($insert) {
                    try {
                       
                        $query_cedula = "SELECT Cedula FROM persona WHERE Nombre = :nombre_usuario";
                        $stmt_cedula = $conn->prepare($query_cedula);
                        $stmt_cedula->bindParam(':nombre_usuario', $user['Nombre']);
                        $stmt_cedula->execute();
                        $cedula_persona = $stmt_cedula->fetchColumn(); 
                
                     
                        $query_tipo_vehiculo = "SELECT idTipoVehiculo FROM TipoVehiculo WHERE Codigo = :codigo";
                        $stmt_tipo_vehiculo = $conn->prepare($query_tipo_vehiculo);
                        $stmt_tipo_vehiculo->bindParam(':codigo', $codigo);
                        $stmt_tipo_vehiculo->execute();
                        $tipo_vehiculo_id = $stmt_tipo_vehiculo->fetchColumn(); 
                
                       
                        $query_estacion = "SELECT idEstacionesPeaje FROM estacionespeaje WHERE Nombre = :estacion_nombre";
                        $stmt_estacion = $conn->prepare($query_estacion);
                        $stmt_estacion->bindParam(':estacion_nombre', $estacion_nombre);
                        $stmt_estacion->execute();
                        $estacion_id = $stmt_estacion->fetchColumn(); 
                

                        $tipo_vehiculo_codigo = $datos_peaje['Codigo'];
                        $stmt_insert_cobro = $conn->prepare("INSERT INTO cobrospeaje (TipoVehiculo_idTipoVehiculo, EstacionesPeaje_idEstacionesPeaje, TipoVehiculo_Codigo, TipoVehiculo_Tarifa, Empleados_Persona_Cedula, Fecha) VALUES (:tipo_vehiculo_id, :estacion_id, :codigo, :monto, :tramitador, :fecha)");
                        $stmt_insert_cobro->bindParam(':tipo_vehiculo_id', $tipo_vehiculo_id);
                        $stmt_insert_cobro->bindParam(':estacion_id', $estacion_id);
                        $stmt_insert_cobro->bindParam(':codigo', $tipo_vehiculo_codigo);
                        $stmt_insert_cobro->bindParam(':monto', $datos_peaje['Tarifa']);
                        $stmt_insert_cobro->bindParam(':tramitador', $cedula_persona);
                        $stmt_insert_cobro->bindParam(':fecha', $fecha_formateada); 
                        $stmt_insert_cobro->execute();

                    
                   
                    } catch (PDOException $exception) {
                        echo "<p>Error al realizar el pago: " . $exception->getMessage() . "</p>";
                    }
                } else {

                }
            } else {
                echo "<p>No se encontró una estación de peaje válida para el usuario actual.</p>";
            }
        } else {
            echo "<p>No se encontraron datos para el código proporcionado.</p>";
        }
    } catch (PDOException $exception) {
        echo "<p>Error en la conexión a la base de datos: " . $exception->getMessage() . "</p>";
    }
}
?>