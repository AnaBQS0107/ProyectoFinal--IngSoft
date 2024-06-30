<?php
require_once '../Controlador/Cobro.php';

$cobroController = new Cobro();
$cobros = $cobroController->getAllCobros();
$tiposVehiculo = $cobroController->getTiposVehiculo();
$estacionesPeaje = $cobroController->getEstacionesPeaje();


$sumasPorTipoYEstacion = [];

if (isset($_GET['submit'])) {
    $tipoVehiculoId = $_GET['tipoVehiculo'];
    $estacionPeajeId = $_GET['estacionPeaje'];

    // Verifica si se seleccionó tanto tipo de vehículo como estación de peaje
    if (!empty($tipoVehiculoId) && !empty($estacionPeajeId)) {
        $cobros = $cobroController->getCobrosPorTipoVehiculoYEstacion($tipoVehiculoId, $estacionPeajeId);
        $sumasPorTipoYEstacion = $cobroController->getSumaTarifasPorTipoVehiculoYEstacion($tipoVehiculoId, $estacionPeajeId);
    } elseif (!empty($tipoVehiculoId)) {
        $cobros = $cobroController->getCobrosPorTipoVehiculo($tipoVehiculoId);
    } elseif (!empty($estacionPeajeId)) {
        $cobros = $cobroController->getCobrosPorEstacion($estacionPeajeId);
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
    <link rel="stylesheet" href="Estilos/TablaCobros.css">
    <link rel="stylesheet" href="Estilos/Footer.css">
    <style>
    .mini-table {
        margin-top: 20px;
    }

    .mini-table table {
        width: 300px;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    .mini-table table th,
    .mini-table table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }
    </style>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br><br>
    <div class="container mt-5">
        <br><br><br><br>
        <center>
            <h1>Consulta de Cobros por Tipo y Estación</h1>
        </center>
        <br>
        <center>
        <form method="GET" action="../Vista/ConsultaTipoyEstacion.php">
            <label for="tipoVehiculo">Tipo de Vehículo:</label>
            <select id="tipoVehiculo" name="tipoVehiculo">
                <option value="">Seleccione un tipo de vehículo</option>
                <?php foreach ($tiposVehiculo as $tipo): ?>
                <option value="<?php echo $tipo['idTipoVehiculo']; ?>"><?php echo $tipo['Tipo']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="estacionPeaje">Estación de Peaje:</label>
            <select id="estacionPeaje" name="estacionPeaje">
                <option value="">Seleccione una estación de peaje</option>
                <?php foreach ($estacionesPeaje as $estacion): ?>
                <option value="<?php echo $estacion['idEstacionesPeaje']; ?>"><?php echo $estacion['Nombre']; ?>
                </option>
                <?php endforeach; ?>
            </select>
            </center>
            <br>
            <center>
            <button type="submit" name="submit">Buscar</button></center>
        </form>
        <br>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID Cobro</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Estación</th>
                        <th scope="col">Cédula Empleado</th>
                        <th scope="col">Tipo de Vehículo</th>
                        <th scope="col">Código</th>
                        <th scope="col">Tarifa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cobros as $cobros): ?>
                    <tr>
                        <td><?php echo $cobros['idCobrosPeaje']; ?></td>
                        <td><?php echo $cobros['Fecha']; ?></td>
                        <td><?php echo $cobros['EstacionPeaje']; ?></td>
                        <td><?php echo $cobros['Empleados_Persona_Cedula']; ?></td>
                        <td><?php echo $cobros['TipoVehiculo']; ?></td>
                        <td><?php echo $cobros['TipoVehiculo_Codigo']; ?></td>
                        <td><?php echo $cobros['TipoVehiculo_Tarifa']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <center>
        <?php if (!empty($sumasPorTipoYEstacion)): ?>
        <div class="mini-table">
            <br><br>
            <h2>Suma de Tarifas por Tipo de Vehículo y Estación de Peaje:</h2>
            <table>
                <thead>
                    <br>
                    <tr>
                        <th>Estación</th>
                        <th>Tipo de Vehículo</th>
                        <th>Total Tarifa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sumasPorTipoYEstacion as $suma): ?>
                    <tr>
                        <td><?php echo isset($suma['EstacionPeaje']) ? $suma['EstacionPeaje'] : 'N/A'; ?></td>
                        <td><?php echo isset($suma['TipoVehiculo']) ? $suma['TipoVehiculo'] : 'N/A'; ?></td>
                        <td><?php echo isset($suma['TotalTarifa']) ? number_format($suma['TotalTarifa'], 2) : 'N/A'; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
            </center>
        </div>
        <?php endif; ?>

    </div>
    <script src="../JS/CobrosCRUD.js"></script>
    <?php include 'Footer.php'; ?>
</body>

</html>