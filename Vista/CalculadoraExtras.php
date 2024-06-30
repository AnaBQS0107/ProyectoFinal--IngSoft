<?php
require_once '../Controlador/Cobro.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Horas Extras</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/CalculadoraExtras.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    
    <container class="Contenido-Extras">

    <div class="container-Caluladora-Extras">
        <h1>Calculadora de Horas Extras</h1>
        <form action="../Controlador/calculoExtras.php" method="POST">
            <label for="salario">Salario por hora ordinaria (en colones):</label>
            <input type="number" id="salario" name="salario" required>
            <label for="horas">Número de horas extras trabajadas:</label>
            <input type="number" id="horas" name="horas" required>
            <button type="submit">Calcular</button>
        </form>
        <?php
            if (isset($_GET['resultado'])) {
                echo '<div class="resultado">';
                echo '<h2>Pago total por horas extras: ' . htmlspecialchars($_GET['resultado']) . ' colones</h2>';
                echo '</div>';
            }
        ?>
    </div>    
    </container>
    <footer class="footer-Calc-Extras">
        <?php include 'Footer.php'; ?>
    </footer>
</body>

</html>