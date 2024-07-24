<?php
require_once '../Controlador/Cobro.php';

$cobroController = new Cobro();
$tiposVehiculo = $cobroController->getTiposVehiculo();

$totalVehiculos = 0;

if (isset($_GET['submit'])) {
    $tipoVehiculoId = $_GET['tipoVehiculo'];
    if (!empty($tipoVehiculoId)) {
        $totalVehiculos = $cobroController->getTotalVehiculosPorTipo($tipoVehiculoId);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Cobros</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/Footer2.css">
    <link rel="stylesheet" href="Estilos/TipoEstacion.css">
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br><br>
    <div class="container mt-5">
        <br><br>
        <center>
            <h1>Total de Vehículos por Tipo</h1>
        </center>
        <br>
        <center>
            <form method="GET" action="">
                <label for="tipoVehiculo">Tipo de Vehículo:</label>
                <select id="tipoVehiculo" name="tipoVehiculo">
                    <option value="">Seleccione un tipo de vehículo</option>
                    <?php foreach ($tiposVehiculo as $tipo): ?>
                    <option value="<?php echo $tipo['idTipoVehiculo']; ?>"><?php echo $tipo['Tipo']; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="submit">Buscar</button>
            </form>

            <br>
            <div class="result-container">
                <?php if ($totalVehiculos > 0): ?>
                <h2>Total de Vehículos: <?php echo $totalVehiculos; ?></h2>
                <?php elseif (isset($_GET['submit'])): ?>
                <p>No se encontraron vehículos para el tipo seleccionado.</p>
                <?php endif; ?>
            </div>

    </div>
    <br><br><br><br>
    <footer id="footer"></footer>
    <script src="../JS/footer.js"></script>
</body>

</html>