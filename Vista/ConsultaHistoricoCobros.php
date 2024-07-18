<?php
require_once '../Config/config.php'; 
try {

    $queryCobros = "SELECT cp.idCobrosPeaje, cp.Fecha, e.Nombre AS Estacion, CONCAT(p.Nombre, ' ', p.Primer_Apellido, ' ', p.Segundo_Apellido) AS Empleado, tv.Tipo AS TipoVehiculo, cp.TipoVehiculo_Tarifa AS Tarifa
                    FROM CobrosPeaje cp
                    INNER JOIN EstacionesPeaje e ON cp.EstacionesPeaje_idEstacionesPeaje = e.idEstacionesPeaje
                    INNER JOIN Persona p ON cp.Empleados_Persona_Cedula = p.Cedula
                    INNER JOIN TipoVehiculo tv ON cp.TipoVehiculo_idTipoVehiculo = tv.idTipoVehiculo
                    ORDER BY cp.Fecha DESC";

    $stmtCobros = $conn->prepare($queryCobros);
    $stmtCobros->execute();
    $cobros = $stmtCobros->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Error al obtener el histórico de cobros: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Cobros por Estación de Peaje</title>
    <link rel="stylesheet" href="Estilos/historicocobros.css">
</head>
<body>
<header>
        <?php include 'header.php'; ?>
    </header>
    <br><br>
<div class="container mt-5">
   <center> <h1>Histórico de Cobros por Estación de Peaje</h1></center>

    <?php if (!empty($cobros)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID Cobro</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Estación</th>
                    <th scope="col">Empleado</th>
                    <th scope="col">Tipo Vehículo</th>
                    <th scope="col">Tarifa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cobros as $cobro): ?>
                    <tr>
                        <td><?php echo $cobro['idCobrosPeaje']; ?></td>
                        <td><?php echo htmlspecialchars($cobro['Fecha']); ?></td>
                        <td><?php echo htmlspecialchars($cobro['Estacion']); ?></td>
                        <td><?php echo htmlspecialchars($cobro['Empleado']); ?></td>
                        <td><?php echo htmlspecialchars($cobro['TipoVehiculo']); ?></td>
                        <td><?php echo number_format($cobro['Tarifa'], 2, ',', '.'); ?> CRC</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            No se encontraron registros de cobros.
        </div>
    <?php endif; ?>
</div>

<footer>
    <?php include 'Footer.php'; ?>
    </footer>
</body>
</html>
