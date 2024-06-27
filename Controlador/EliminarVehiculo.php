<?php
require_once '../Modelo/ObtenerMontosPeaje.php';

if (isset($_GET['idTipoVehiculo'])) {
    $idTipoVehiculo = $_GET['idTipoVehiculo'];
    $controller->eliminarTipoVehiculo($idTipoVehiculo);
}

header('Location: ../Vista/TablaMontoVehiculos.php');
exit();
?>
