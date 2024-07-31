<?php
session_start(); // Asegúrate de iniciar la sesión

// Inicializa las variables
$resultados = $_SESSION['resultados'] ?? null;
$error = $_SESSION['error'] ?? null;

// Limpiar la sesión
unset($_SESSION['resultados']);
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Liquidación </title>
    <link rel="stylesheet" href="Estilos/Resultados.css"> <!-- Ajusta la ruta según sea necesario -->
    <link rel="stylesheet" href="Estilos/Footer2.css">
    <link rel="icon" type="image/png" href="../img/icono.png">
</head>

<header>
    <?php include 'Header.php'; ?>
</header>

<body>
    <br>
   <center> <h1>Resultados de Liquidación</h1></center>
<br><br>
    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php elseif ($resultados): ?>
    <div class="table-container">
        <center>    <table class="table">
                <tr><th>Antigüedad</th><td><?php echo htmlspecialchars($resultados['antiguedad']); ?></td></tr>
                <tr><th>Salario Promedio</th><td><?php echo htmlspecialchars(number_format($resultados['salarioPromedio'], 2)); ?></td></tr>
                <tr><th>Salario Diario</th><td><?php echo htmlspecialchars(number_format($resultados['salarioDiario'], 2)); ?></td></tr>
                <tr><th>Rango de Fechas</th><td><?php echo htmlspecialchars($resultados['rangoFechas']); ?></td></tr>
                <tr><th>Saldo Vacaciones</th><td><?php echo htmlspecialchars(number_format($resultados['saldoVacaciones'], 2)); ?></td></tr>
                <tr><th>Aguinaldo</th><td><?php echo htmlspecialchars(number_format($resultados['aguinaldo'], 2)); ?></td></tr>
                <tr><th>Vacaciones</th><td><?php echo htmlspecialchars(number_format($resultados['vacaciones'], 2)); ?></td></tr>
                <tr><th>Preaviso</th><td><?php echo htmlspecialchars(number_format($resultados['preaviso'], 2)); ?></td></tr>
                <tr><th>Cesantía</th><td><?php echo htmlspecialchars(number_format($resultados['cesantia'], 2)); ?></td></tr>
                <tr><th>Total</th><td><?php echo htmlspecialchars(number_format($resultados['total'], 2)); ?></td></tr>
            </table></center>
    <?php else: ?>
        <p>No se encontraron resultados.</p>
    <?php endif; ?>



</body>
<footer id="footer"></footer>
<script src="../JS/footer.js"></script>
</html>

