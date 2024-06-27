<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../Modelo/ObtenerMontosPeaje.php';

$idTipoVehiculo = '';
$monto = '';

if (isset($_GET['idTipoVehiculo'])) {
    $idTipoVehiculo = $_GET['idTipoVehiculo'];
    $tiposVehiculo = $controller->obtenerTiposVehiculo();
    foreach ($tiposVehiculo as $vehiculo) {
        if ($vehiculo['idTipoVehiculo'] == $idTipoVehiculo) {
            $monto = $vehiculo['Tarifa'];
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PassWize - Actualizar Monto</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/TablaEmpleados.css">
    <link rel="stylesheet" href="Estilos/Footer.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br><br><br><br>
    <center>
        <h1><?php echo $idTipoVehiculo ? 'Actualizar Monto del Vehículo' : 'Agregar Monto del Vehículo'; ?></h1>
    </center>
    <br>
    <center>
        <form action="../Controlador/GuardarMonto.php" method="POST">
            <input type="hidden" name="idTipoVehiculo" value="<?php echo $idTipoVehiculo; ?>">
            <div class="form-group">
                <label for="monto">Monto:</label>
                <input type="number" step="0.01" id="monto" name="monto" value="<?php echo $monto; ?>" required>
            </div>
            <button type="submit"><?php echo $idTipoVehiculo ? 'Actualizar' : 'Agregar'; ?></button>
        </form>
    </center>
    <br>
    <?php include 'Footer.php'; ?>
</body>

</html>
