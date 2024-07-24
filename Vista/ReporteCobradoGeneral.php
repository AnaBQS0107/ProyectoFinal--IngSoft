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
    <link rel="stylesheet" href="Estilos/ReporteCobradoGeneral.css">
    <link rel="icon" type="image/png" href="../img/icono.png">
</head>
<header>
    <?php include 'Header.php'; ?>
</header>
<br><br><br><br>
<body>
<div class="container mt-5">
    <br><br>
    <h2 class="mb-4">Monto Total Recaudado por los Cinco Puestos de Peaje</h2>
<br>
    <div class="alert alert-info" role="alert">
        Monto total recaudado: ₡ <?php echo number_format($resultadoTotal, 2); ?>
    </div>
<br><br>
    <center><form action="../Reportes/pdfCobroGeneral.php" method="post" target="_blank">
        <input type="hidden" name="tipo_reporte" value="monto_total_cinco_puestos">
        <button type="submit" class="btn btn-primary">Exportar a PDF</button>
    </form></center>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>



<footer id="footer"></footer>
<script src="../JS/footer.js"></script>

</body>
</html>

<?php
} else {
    echo "No se encontraron resultados válidos para generar el reporte.";
}
?>
