<?php
require_once '../Modelo/ReporteCobradoporEstacion.php';

if (isset($resultados) && (is_array($resultados) || is_object($resultados))) {
    ob_clean();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte - Monto Total Cobrado por Estación</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/ReporteCobroporEstacion.css">
</head>

<header>
    <?php include 'Header.php'; ?>
</header>
<br> <br>
<body>
<div class="container mt-5">
    <br><br>
    <h2 class="mb-4">Monto Total Cobrado por Estación</h2>
    <br>
    <?php if (!empty($resultados)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Estación de Peaje</th>
                    <th scope="col">Monto Total Cobrado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
                        <td>₡ <?php echo number_format($row['MontoTotalCobrado'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

       <center> <form action="../Reportes/pdfCobroporEstacion.php" method="post" target="_blank">
            <input type="hidden" name="tipo_reporte" value="monto_por_estacion">
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
<br><br>
<footer>
    <?php include 'Footer.php'; ?>
    </footer>
</body>
</html>

<?php
} else {
    echo "No se encontraron resultados válidos para generar el reporte.";
}
?>
