<?php
require_once '../Modelo/MontoTotalporMES.php';

if (isset($resultados) && (is_array($resultados) || is_object($resultados))) {
    ob_clean();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte - Monto Total Recaudado por Mes</title>
    <link rel="stylesheet" href="Estilos/ReporteTotalPorMes.css">
    <link rel="icon" type="image/png" href="../img/icono.png">
    <header>
    <?php include 'Header.php'; ?>
</header>
</head>
<br><br><br>
<body>
<div class="container mt-5">
   <center><h2 class="mb-4">Monto Total Recaudado por Mes</h2></center> 
<br>
    <?php if (!empty($resultados)): ?>
        <table class="table table-bordered">
                <tr>
                    <th scope="col">Mes</th>
                    <th scope="col">Monto Total Recaudado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Mes']); ?></td>
                        <td>$ <?php echo number_format($row['MontoTotal'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <center><form action="../Reportes/pdfCobroporMes.php" method="post" target="_blank">
            <button type="submit" class="btn btn-primary">Exportar a PDF</button>
        </form></center>
        <br><br><br><br>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            No se encontraron resultados para generar el reporte.
        </div>
    <?php endif; ?>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>


<footer>
    <?php include 'Footer.php'; ?>
    </footer>
</body>
</html>

<?php
} else {
    echo "No se encontraron resultados para generar el reporte.";
}
?>
