<?php
require_once '../Config/config.php'; // Asegúrate de que esta línea esté presente y correcta

try {
    // Consulta para obtener los cobros por hora del día
    $queryCobrosPorHora = "SELECT cp.Fecha, ht.Entrada, ht.Salida, cp.TipoVehiculo_Codigo, cp.TipoVehiculo_Tarifa
                           FROM CobrosPeaje cp
                           INNER JOIN horario_trabajo ht ON TIME(cp.Fecha) BETWEEN ht.Entrada AND ht.Salida
                           ORDER BY cp.Fecha";

    $stmtCobrosPorHora = $conn->prepare($queryCobrosPorHora);
    $stmtCobrosPorHora->execute();
    $cobrosPorHora = $stmtCobrosPorHora->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Error al obtener los datos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cobros por Hora del Día</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<header>
    <?php include 'Header.php'; ?>
</header>
<div class="container mt-5">
    <h2>Cobros por Hora del Día</h2>

    <?php if (!empty($cobrosPorHora)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora de Entrada</th>
                    <th scope="col">Hora de Salida</th>
                    <th scope="col">Tipo de Vehículo</th>
                    <th scope="col">Tarifa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cobrosPorHora as $cobro): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cobro['Fecha']); ?></td>
                        <td><?php echo htmlspecialchars($cobro['Entrada']); ?></td>
                        <td><?php echo htmlspecialchars($cobro['Salida']); ?></td>
                        <td><?php echo htmlspecialchars($cobro['TipoVehiculo_Codigo']); ?></td>
                        <td><?php echo htmlspecialchars($cobro['TipoVehiculo_Tarifa']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            No se encontraron cobros por hora del día.
        </div>
    <?php endif; ?>
</div>
<footer>
    <?php include 'Footer.php'; ?>
    </footer>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
