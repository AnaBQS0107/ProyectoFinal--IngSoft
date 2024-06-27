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
    <link rel="stylesheet" href="Estilos/HorasExtras.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    
    <div class="container-HorasExtras">
        <h1>Overtime Tracker</h1>
        <button id="start-overtime">Start Overtime</button>
        <button id="end-overtime">End Overtime</button>
        <h2>Monthly Total: <span id="monthly-total">0</span> hours</h2>
        <table>
            <thead>
                <tr>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Hours Worked</th>
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
        const userId = 1; // Change this as needed

        function fetchMonthlyTotal() {
            $.get('monthly_overtime.php', { user_id: userId }, function(data) {
                const result = JSON.parse(data);
                $('#monthly-total').text(result.monthly_total);
            });
        }

        $('#start-overtime').click(function() {
            $.post('start_overtime.php', { user_id: userId }, function(response) {
                alert(response);
                fetchMonthlyTotal();
            });
        });

        $('#end-overtime').click(function() {
            $.post('end_overtime.php', { user_id: userId }, function(response) {
                alert(response);
                fetchMonthlyTotal();
            });
        });

        $(document).ready(function() {
            fetchMonthlyTotal();
        });
    </script>

    
</body>

</html>