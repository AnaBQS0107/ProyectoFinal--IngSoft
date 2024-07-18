<?php
require_once '../Config/config.php'; 

try {

    $queryTarifas = "SELECT idTipoVehiculo, Codigo, Tipo, Tarifa FROM TipoVehiculo";
    $stmtTarifas = $conn->prepare($queryTarifas);
    $stmtTarifas->execute();
    $tarifas = $stmtTarifas->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Error al obtener las tarifas de peaje: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilos/tarifasvigentes.css">
    <link rel="icon" type="image/png" href="../img/icono.png">
    <title>Tarifas de Peaje Vigentes</title>
    
</head>
<body>
<header>
        <?php include 'header.php'; ?>
    </header>
    <br>
<div class="container mt-5">
    <center><h1>Tarifas de Peaje Vigentes</h1></center>
<br>
    <?php if (!empty($tarifas)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID Tipo Vehículo</th>
                    <th scope="col">Código</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Tarifa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tarifas as $tarifa): ?>
                    <tr>
                        <td><?php echo $tarifa['idTipoVehiculo']; ?></td>
                        <td><?php echo htmlspecialchars($tarifa['Codigo']); ?></td>
                        <td><?php echo htmlspecialchars($tarifa['Tipo']); ?></td>
                        <td><?php echo number_format($tarifa['Tarifa'], 2, ',', '.'); ?> CRC</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            No se encontraron tarifas de peaje vigentes.
        </div>
    <?php endif; ?>
</div>

<br><br><br><br><br><br>
<footer>
    <?php include 'Footer.php'; ?>
    </footer>
</body>
</html>
