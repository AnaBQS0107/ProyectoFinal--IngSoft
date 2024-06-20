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

                if ($insert) {
                    // Insertar los datos en la tabla cobros
                    $query_insert_cobro = "INSERT INTO cobros (Tipo_De_Vehiculo, Codigo, Monto, Tramitador, Estacion) VALUES (:tipo_de_vehiculo, :codigo, :monto, :tramitador, :estacion)";
                    $stmt_insert_cobro = $conn->prepare($query_insert_cobro);
                    $stmt_insert_cobro->bindParam(':tipo_de_vehiculo', $datos_peaje['Tipo']);
                    $stmt_insert_cobro->bindParam(':codigo', $datos_peaje['Codigo']);
                    $stmt_insert_cobro->bindParam(':monto', $datos_peaje['Tarifa']);
                    $stmt_insert_cobro->bindParam(':tramitador', $user['Nombre']);
                    $stmt_insert_cobro->bindParam(':estacion', $estacion_nombre);
                    $stmt_insert_cobro->execute();
                }

                // Mostrar los datos en la tabla HTML
                echo "<tr><td>1</td><td>" . $datos_peaje['Tipo'] . "</td><td>" . $datos_peaje['Codigo'] . "</td><td>" . $datos_peaje['Tarifa'] . "</td><td>" . $user['Nombre'] . "</td><td>" . $estacion_nombre . "</td></tr>";
            } else {
                echo "<tr><td colspan='6'>No se encontró una estación de peaje válida para el usuario actual</td></tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No se encontraron datos para el código proporcionado</td></tr>";
        }
    } catch (PDOException $exception) {
        echo "<tr><td colspan='6'>Error en la conexión a la base de datos: " . $exception->getMessage() . "</td></tr>";
    }
    exit;
}
?>
