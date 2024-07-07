<?php
require_once '../Modelo/ReporteCantidadporTipoyEstacion.php';

$resultados = obtenerCantidadVehiculosPorTipoYEstacion();

if (isset($resultados) && (is_array($resultados) || is_object($resultados))) {
    ob_clean();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte - Cantidad de Vehículos por Tipo y Estación</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<header>
    <?php include 'Header.php'; ?>
</header>
<body>
<div class="container mt-5">
    <br><br>
    <h2 class="mb-4">Cantidad de Vehículos por Tipo y Estación</h2>

    <?php if (!empty($resultados)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Estación de Peaje</th>
                    <th scope="col">Tipo de Vehículo</th>
                    <th scope="col">Cantidad de Vehículos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Estacion']); ?></td>
                        <td><?php echo htmlspecialchars($row['TipoVehiculo']); ?></td>
                        <td><?php echo number_format($row['CantidadVehiculos']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

       <center> <form action="../Reportes/pdfCantidadVehiculoPorTipoYEstacion.php" method="post" target="_blank">
            <input type="hidden" name="tipo_reporte" value="cantidad_por_tipo_y_estacion">
            <button type="submit" class="btn btn-primary">Exportar a PDF</button>
        </form></center>
        <br><br><br>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            No se encontraron resultados para generar el reporte.
        </div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
<footer>
    <?php include 'Footer.php'; ?>
    </footer>
</html>

<?php
} else {
    echo "No se encontraron resultados válidos para generar el reporte.";
}
?>
