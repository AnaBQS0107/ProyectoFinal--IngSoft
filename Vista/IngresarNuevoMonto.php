<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

}
require_once '../Modelo/ObtenerMontosPeaje.php';

$idTipoVehiculo = '';
$codigo = '';
$tipo = '';
$tarifa = '';

if (isset($_GET['idTipoVehiculo'])) {
    $idTipoVehiculo = $_GET['idTipoVehiculo'];
    $tiposVehiculo = $controller->obtenerTiposVehiculo();
    foreach ($tiposVehiculo as $vehiculo) {
        if ($vehiculo['idTipoVehiculo'] == $idTipoVehiculo) {
            $codigo = $vehiculo['Codigo'];
            $tipo = $vehiculo['Tipo'];
            $tarifa = $vehiculo['Tarifa'];
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
    <title>PassWize - Formulario Vehículo</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/NuevoMonto.css">
    <link rel="stylesheet" href="Estilos/Footer2.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br><br>
    <center>
        <h1><?php echo $idTipoVehiculo ? 'Editar Tipo de Vehículo' : 'Ingresar Nuevo Tipo de Vehículo'; ?></h1>
    </center>
    <br>
    <center>
        <form action="../Controlador/GuardarMonto.php" method="POST">
            <input type="hidden" name="idTipoVehiculo" value="<?php echo $idTipoVehiculo; ?>">
            <div class="form-group">
                <label for="codigo">Código:</label>
                <input type="text" id="codigo" name="codigo" value="<?php echo $codigo; ?>" required>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <input type="text" id="tipo" name="tipo" value="<?php echo $tipo; ?>" required>
            </div>
            <div class="form-group">
                <label for="tarifa">Tarifa:</label>
                <input type="number" step="0.01" id="tarifa" name="tarifa" value="<?php echo $tarifa; ?>" required>
            </div>
            <button type="submit"><?php echo $idTipoVehiculo ? 'Actualizar' : 'Agregar'; ?></button>
        </form>
    </center>
    <br>
    
    <footer id="footer"></footer>
    <script src="../JS/footer.js"></script>
    
</body>

</html>
