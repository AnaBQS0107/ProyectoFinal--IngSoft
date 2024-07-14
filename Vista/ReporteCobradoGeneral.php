<?php
require_once '../Modelo/MontoCobradoGeneral.php';

if ($resultadoTotal > 0) {
    ob_clean();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte - Monto Total Recaudado por Puestos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../img/icono.png">
</head>
<header>
    <?php include 'Header.php'; ?>
</header>
<body>
<div class="container mt-5">
    <br><br>
    <h2 class="mb-4">Monto Total Recaudado por los Cinco Puestos de Peaje</h2>

    <div class="alert alert-info" role="alert">
        Monto total recaudado: $ <?php echo number_format($resultadoTotal, 2); ?>
    </div>

    <center><form action="../Reportes/pdfCobroGeneral.php" method="post" target="_blank">
        <input type="hidden" name="tipo_reporte" value="monto_total_cinco_puestos">
        <button type="submit" class="btn btn-primary">Exportar a PDF</button>
    </form></center>
    <br><br><br>
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
