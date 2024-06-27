<?php
require_once '../Controlador/HorasExtrasMensuales.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Horas Extras</title>
    <link rel="stylesheet" href="Estilos/HorasExtras.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <div class="container-HorasExtras">
        <h1>Contador de horas extras</h1>
        <button id="start-overtime">Inicio Horas Extra</button>
        <button id="end-overtime">Fin Horas Extra</button>
        <h2>Total Mensual: <span id="monthly-total">0</span> colones</h2>
        <table>
            <thead>
                <tr>
                    <th>Hora de inicio</th>
                    <th>Hora de finalización</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody id="overtime-data">
            </tbody>
        </table>
    </div>

    <footer class="footer-Calc-Extras">
        <?php include 'Footer.php'; ?>
    </footer>

    <script>
        const userId = 1; // Cambia esto según sea necesario

        function fetchMonthlyTotal() {
            $.get('../Controlador/HorasExtrasMensuales.php', { user_id: userId }, function(data) {
                const result = JSON.parse(data);
                $('#monthly-total').text(result.monthly_total);
            });
        }

        $('#start-overtime').click(function() {
            $.post('../Controlador/InicioHorasExtras.php', { user_id: userId }, function(response) {
                Swal.fire('Inicio Horas Extra', response, 'success');
                fetchMonthlyTotal();
            });
        });

        $('#end-overtime').click(function() {
            $.post('../Controlador/FinHorasExtras.php', { user_id: userId }, function(response) {
                Swal.fire('Fin Horas Extra', response, 'success');
                fetchMonthlyTotal();
            });
        });

        $(document).ready(function() {
            fetchMonthlyTotal();
        });
    </script>
</body>
</html>