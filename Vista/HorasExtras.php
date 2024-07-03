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
        <button id="end-overtime" disabled>Fin Horas Extra</button>
        <input type="text" id="overtime-description" placeholder="Descripción de las horas extras" disabled>
        <h2>Total Mensual: <span id="monthly-total">0</span> colones</h2>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora de inicio</th>
                    <th>Hora de finalización</th>
                    <th>Monto</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody id="overtime-data">
            </tbody>
        </table>
    </div>
    <BR><BR></BR></BR>

    <footer class="footer-Calc-Extras">
        <?php include 'Footer.php'; ?>
    </footer>

    <script>
    const userId = <?php echo isset($_SESSION['user']['Persona_Cedula']) ? $_SESSION['user']['Persona_Cedula'] : 'null'; ?>;

    $(document).ready(function() {
        fetchMonthlyTotal();
        fetchOvertimeData();
    });

    $('#start-overtime').click(function() {
        $.post('../Controlador/InicioHorasExtras.php', { user_id: userId }, function(response) {
            if (response.error) {
                Swal.fire('Error', response.message, 'error');
            } else {
                Swal.fire('Inicio Horas Extra', response.message, 'success');
                $('#start-overtime').prop('disabled', true);
                $('#end-overtime').prop('disabled', false);
                $('#overtime-description').prop('disabled', false);
                fetchOvertimeData();
            }
            fetchMonthlyTotal();
        }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
        });
    });

    $('#end-overtime').click(function() {
        const description = $('#overtime-description').val();
        $.post('../Controlador/FinHorasExtras.php', { user_id: userId, description: description }, function(response) {
            if (response.error) {
                Swal.fire('Error', response.message, 'error');
            } else {
                Swal.fire('Fin Horas Extra', response.message, 'success');
                $('#start-overtime').prop('disabled', false);
                $('#end-overtime').prop('disabled', true);
                $('#overtime-description').prop('disabled', true).val('');
                fetchOvertimeData();
            }
            fetchMonthlyTotal();
        }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
        });
    });

    function fetchMonthlyTotal() {
        $.get('../Controlador/HorasExtrasMensuales.php', { user_id: userId }, function(data) {
            if (data.error) {
                Swal.fire('Error', data.message, 'error');
            } else {
                $('#monthly-total').text(data.monthly_total);
            }
        }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
        });
    }

    function fetchOvertimeData() {
        $.get('../Controlador/ObtenerHorasExtras.php', { user_id: userId }, function(data) {
            $('#overtime-data').empty();
            if (Array.isArray(data)) {
                data.forEach(function(entry) {
                    $('#overtime-data').append(`
                        <tr>
                            <td>${entry.Fecha}</td>
                            <td>${entry.Hora_Inicio}</td>
                            <td>${entry.Hora_Salida ? entry.Hora_Salida.split(' ')[1] : '-'}</td>
                            <td>${entry.Monto ? entry.Monto : '-'}</td>
                            <td>${entry.Descripcion ? entry.Descripcion : '-'}</td>
                        </tr>
                    `);
                });
            } else {
                console.error("Los datos recibidos no son un array:", data);
                Swal.fire('Error', 'Datos recibidos no son un array', 'error');
            }
        }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
        });
    }
    </script>
</body>

</html>