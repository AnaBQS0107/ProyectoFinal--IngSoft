<?php
require_once '../Modelo/ObtenerMontosPeaje.php';

$idTipoVehiculo = $_POST['idTipoVehiculo'];
$codigo = $_POST['codigo'];
$tipo = $_POST['tipo'];
$tarifa = $_POST['tarifa'];
$monto = $_POST['monto'];

if ($idTipoVehiculo) {
    $controller->actualizarMonto($idTipoVehiculo, $monto);
} else {
    $controller->agregarTipoVehiculo($codigo, $tipo, $tarifa);
}

if (isset($_GET['idTipoVehiculo'])) {
    $idTipoVehiculo = $_GET['idTipoVehiculo'];
    $controller->eliminarTipoVehiculo($idTipoVehiculo);
}

header('Location: ../Vista/TablaMontoVehiculos.php');
