<?php
require_once '../Modelo/HistorialCobrosDiarios.php';

$resultados = obtenerHistorialCobrosDiarios();

if (isset($resultados) && (is_array($resultados) || is_object($resultados))) {
    ob_clean();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Cobros Diarios</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/ReporteCobroDiarios.css">
</head>
<header>
    <?php include 'Header.php'; ?>
</header>
<body>
<div class="container mt-5">
    <br><br>
    <center> <h2 class="mb-4">Historial de Cobros Diarios</h2><center>
    <br>
    <?php if (!empty($resultados)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Estación de Peaje</th>
                    <th scope="col">Tipo de Vehículo</th>
                    <th scope="col">Monto Cobrado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Fecha']); ?></td>
                        <td><?php echo htmlspecialchars($row['Estacion']); ?></td>
                        <td><?php echo htmlspecialchars($row['TipoVehiculo']); ?></td>
                        <td>₡ <?php echo number_format($row['MontoCobrado'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

       <center> <form action="../Reportes/pdfHistorialCobrosDiarios.php" method="post" target="_blank">
            <input type="hidden" name="tipo_reporte" value="historial_cobros_diarios">
            <button type="submit" class="btn btn-primary">Exportar a PDF</button>
        </form></center>
        <br><br><br>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            No se encontraron resultados para generar el historial de cobros diarios.
        </div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
<footer id="footer"></footer>
<script src="../JS/footer.js"></script>
</html>

<?php
} else {
    echo "No se encontraron resultados válidos para generar el historial de cobros diarios.";
}
?>
