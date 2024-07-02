<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

// Incluir el archivo donde se realiza la consulta y se obtienen los resultados
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <header>
    <?php include 'Header.php'; ?>
</header>
</head>
<body>
<div class="container mt-5">
   <center><h2 class="mb-4">Monto Total Recaudado por Mes</h2></center> 

    <?php if (!empty($resultados)): ?>
        <table class="table table-bordered">
            <thead>
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
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            No se encontraron resultados para generar el reporte.
        </div>
    <?php endif; ?>
</div>

<!-- Scripts de Bootstrap -->
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
    echo "No se encontraron resultados para generar el reporte.";
}
?>
