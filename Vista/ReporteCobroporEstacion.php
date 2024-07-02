<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

// Incluir el archivo donde se realiza la consulta y se obtienen los resultados
require_once '../Modelo/ReporteCobradoPorEstacion.php';

// Verificar si $resultados está definido y es un array u objeto válido
if (isset($resultados) && (is_array($resultados) || is_object($resultados))) {
    // Limpiar el búfer de salida
    ob_clean();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte - Monto Total Cobrado por Estación</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Monto Total Cobrado por Estación</h2>

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
                    <td><?php echo htmlspecialchars($row['NombreEstacion']); ?></td>
                    <td>$ <?php echo number_format($row['MontoTotalCobrado'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form action="../Reporte/pdfCobroporEstacion" method="post" target="_blank">
        <input type="hidden" name="tipo_reporte" value="monto_por_estacion">
        <button type="submit" class="btn btn-primary">Exportar a PDF</button>
    </form>
</div>

<!-- Scripts de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
} else {
    // Manejar el caso donde $resultados no está definido o es nulo
    echo "No se encontraron resultados válidos para generar el PDF.";
}
?>
