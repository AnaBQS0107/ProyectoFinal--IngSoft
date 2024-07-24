<?php


require_once '../Modelo/ReporteCobradoporTipo.php';

if (isset($resultados) && (is_array($resultados) || is_object($resultados))) {
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exportar a PDF</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/ReporteCobroMes.css">
</head>
<body>
<header>
    <?php include 'Header.php'; ?>
</header>
    <div class="container mt-5">
       <center><h2 class="mb-4">Monto Total Cobrado por Cada Tipo de Vehículo</h2></center> 

        <table class="table table-bordered">
                <tr>
                    <th scope="col">Tipo de Vehículo</th>
                    <th scope="col">Monto Total Cobrado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['TipoVehiculo']); ?></td>
                    <td>₡ <?php echo number_format($row['MontoTotalCobrado'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
<br>
        <form action="../Reportes/pdfCobroPorTipo.php" method="post" target="_blank">
            <input type="hidden" name="tipo_reporte" value="monto_por_tipo_vehiculo">
            <center><button type="submit" class="btn btn-primary">Exportar a PDF</button></center>
        </form>
        <br><br><br>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<br>
<footer id="footer"></footer>
<script src="../JS/footer.js"></script>
</body>

</html>

<?php
} else {
   
    echo "No se encontraron resultados.";
}
?>
