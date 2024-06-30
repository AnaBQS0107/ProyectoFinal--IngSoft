<?php
require_once '../Config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCobro = $_POST['idCobrosPeaje'];
    $fecha = $_POST['Fecha'];
    $estacion = $_POST['EstacionesPeaje_idEstacionesPeaje'];
    $cedula = $_POST['Empleados_Persona_Cedula'];
    $tipoVehiculo = $_POST['TipoVehiculo_idTipoVehiculo'];
    $codigo = $_POST['TipoVehiculo_Codigo'];
    $tarifa = $_POST['TipoVehiculo_Tarifa'];

    $database = new Database1();
    $conn = $database->getConnection();

    if ($conn) {
        try {
            $query = "UPDATE CobrosPeaje 
                      SET Fecha = :fecha, 
                          EstacionesPeaje_idEstacionesPeaje = :estacion, 
                          Empleados_Persona_Cedula = :cedula, 
                          TipoVehiculo_idTipoVehiculo = :tipoVehiculo, 
                          TipoVehiculo_Codigo = :codigo, 
                          TipoVehiculo_Tarifa = :tarifa 
                      WHERE idCobrosPeaje = :idCobro";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':estacion', $estacion);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':tipoVehiculo', $tipoVehiculo);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':tarifa', $tarifa);
            $stmt->bindParam(':idCobro', $idCobro, PDO::PARAM_INT);
            $stmt->execute();

            header("Location: ../Vista/TablaCobros.php");
            exit();
        } catch (PDOException $e) {
            echo "Error al actualizar datos: " . $e->getMessage();
        }
    } else {
        echo "No se pudo establecer la conexión.";
    }
}
?>
