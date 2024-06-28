<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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
    // Obtener el ID del usuario desde PHP (podría ser a través de una variable PHP)
    const userId =
        <?php echo isset($_SESSION['user']['Persona_Cedula']) ? $_SESSION['user']['Persona_Cedula'] : 'null'; ?>;

    // Llamar a la función fetchMonthlyTotal al cargar la página
    $(document).ready(function() {
        fetchMonthlyTotal();
    });

    $('#start-overtime').click(function() {
        $.post('../Controlador/InicioHorasExtras.php', function(response) {
            // Mostrar mensaje de éxito o error usando SweetAlert2
            Swal.fire('Inicio Horas Extra', response.message, response.error ? 'error' : 'success');

            // Actualizar el total mensual de horas extras después de iniciar
            fetchMonthlyTotal();

            // Actualizar la tabla de horas extras iniciadas
            fetchStartedOvertime();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            // Manejar errores de la solicitud AJAX
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
        });
    });

    function fetchMonthlyTotal() {
    $.get('../Controlador/HorasExtrasMensuales.php', {
        user_id: userId
    }, function(data) {
        try {
            const result = JSON.parse(data);
            if (result.hasOwnProperty('monthly_total')) {
                if (result.monthly_total !== null) {
                    $('#monthly-total').text(result.monthly_total);
                } else {
                    $('#monthly-total').text('0');
                }
            } else {
                console.error("La respuesta JSON no contiene 'monthly_total':", result);
                Swal.fire('Error', 'Respuesta inesperada del servidor', 'error');
            }
        } catch (error) {
            console.error("Error al parsear respuesta JSON:", error);
            Swal.fire('Error', 'Error al procesar la respuesta del servidor', 'error');
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
    });
}

    function fetchStartedOvertime() {
        $.get('../Controlador/HorasExtrasIniciadas.php', {
            user_id: userId
        }, function(data) {
            try {
                const overtimeData = JSON.parse(data);
                $('#overtime-data').empty(); // Limpiar tabla antes de agregar nuevos datos
                overtimeData.forEach(function(entry) {
                    $('#overtime-data').append(`
                        <tr>
                            <td>${entry.Hora_Inicio}</td>
                            <td>${entry.Hora_Fin ? entry.Hora_Fin : '-'}</td>
                            <td>${entry.Monto ? entry.Monto : '-'}</td>
                        </tr>
                    `);
                });
            } catch (error) {
                console.error("Error al parsear respuesta JSON:", error);
                Swal.fire('Error', 'Error al procesar la respuesta del servidor', 'error');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
        });
    }
    </script>
</body>

</html>
