<?php
require_once '../Config/config.php'; 

$cobros = []; 
$database = new Database1();
$conn = $database->getConnection();

if ($conn) {
    try {
        $query = "SELECT 
                    cp.idCobrosPeaje, 
                    cp.Fecha, 
                    ep.Nombre AS EstacionPeaje, 
                    cp.Empleados_Persona_Cedula, 
                    tv.Tipo AS TipoVehiculo, 
                    cp.TipoVehiculo_Codigo, 
                    cp.TipoVehiculo_Tarifa 
                  FROM 
                    CobrosPeaje cp
                    INNER JOIN TipoVehiculo tv ON cp.TipoVehiculo_idTipoVehiculo = tv.idTipoVehiculo
                    INNER JOIN EstacionesPeaje ep ON cp.EstacionesPeaje_idEstacionesPeaje = ep.idEstacionesPeaje";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $cobros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error al obtener datos: " . $e->getMessage();
    }
} else {
    echo "No se pudo establecer la conexión.";
}

function eliminarCobro($idCobro) {
    $database = new Database1();
    $conn = $database->getConnection();

    if ($conn) {
        try {
            $query = "DELETE FROM CobrosPeaje WHERE idCobrosPeaje = :idCobro";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':idCobro', $idCobro, PDO::PARAM_INT);
            $stmt->execute();
            return true; 
        } catch (PDOException $e) {
            echo "Error al eliminar cobro: " . $e->getMessage();
            return false; 
        }
    } else {
        echo "No se pudo establecer la conexión.";
        return false;
    }
}

if (isset($_GET['eliminarCobro'])) {
    $idCobro = $_GET['eliminarCobro'];
    if (eliminarCobro($idCobro)) {
  
        header("Location: TablaCobros.php");
        exit();
    } else {
        echo "Error al intentar eliminar el cobro.";
    }
}
?>



