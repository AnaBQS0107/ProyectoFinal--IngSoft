<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Horas Extras</title>
    <link rel="stylesheet" href="Estilos/HorasExtras.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="icon" type="image/png" href="../img/icono.png">
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <div class="container-HorasExtras">
        <h1>Contador de horas extras</h1>
       <center> <button id="start-overtime">Inicio Horas Extra</button></center> 
       <center><button id="end-overtime" disabled>Fin Horas Extra</button></center>
        <input type="text" id="overtime-description" placeholder="Descripción de las horas extras" disabled>
        <center><button id="delete-overtime" disabled>Eliminar Horas Extra</button></center>
        <h2>Total Mensual: <span id="monthly-total">0</span> colones</h2>
        <table>
            <thead>
                <tr>
                    <th>Seleccionar</th>
                    <th>Fecha</th>
                    <th>Hora de inicio</th>
                    <th>Hora de finalización</th>
                    <th>Monto</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
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
    const userId = <?php echo isset($_SESSION['user']['Persona_Cedula']) ? $_SESSION['user']['Persona_Cedula'] : 'null'; ?>;

    $(document).ready(function() {
        fetchMonthlyTotal();
        fetchOvertimeData();

        // Evento para habilitar el botón de eliminar cuando se selecciona una opción
        $(document).on('change', 'input[name="select-overtime"]', function() {
            const selectedId = $('input[name="select-overtime"]:checked').val();
            if (selectedId) {
                $('#delete-overtime').prop('disabled', false);
            } else {
                $('#delete-overtime').prop('disabled', true);
            }
        });
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

    $('#delete-overtime').click(function() {
        const selectedId = $('input[name="select-overtime"]:checked').val();
        if (selectedId) {
            $.post('../Controlador/EliminarHorasExtras.php', { id: selectedId }, function(response) {
                if (response.error) {
                    Swal.fire('Error', response.message, 'error');
                } else {
                    Swal.fire('Eliminar Horas Extra', response.message, 'success');
                    fetchOvertimeData();
                }
                fetchMonthlyTotal();
            }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
            });
        } else {
            Swal.fire('Error', 'Por favor seleccione una hora extra para eliminar', 'error');
        }
    });

    $(document).on('click', '.edit-description', function() {
        const row = $(this).closest('tr');
        const descriptionCell = row.find('.description-cell');
        const currentDescription = descriptionCell.text();
        const editInput = $('<input type="text" class="edit-input" value="' + currentDescription + '">');
        const saveButton = $('<button class="save-description">Guardar</button>');

        descriptionCell.html(editInput);
        $(this).replaceWith(saveButton);
    });

    $(document).on('click', '.save-description', function() {
    const row = $(this).closest('tr');
    const descriptionCell = row.find('.description-cell');
    const newDescription = descriptionCell.find('.edit-input').val();
    const recordId = row.find('input[name="select-overtime"]').val();

    $.post('../Controlador/ActualizarDescripcionHorasExtras.php', { id: recordId, description: newDescription }, function(response) {
        console.log(response); // Añade esta línea para imprimir la respuesta en la consola
        if (response.error) {
            Swal.fire('Error', response.message, 'error');
        } else {
            descriptionCell.html(newDescription);
            const editButton = $('<button class="edit-description">Editar</button>');
            $(this).replaceWith(editButton);
            Swal.fire('Descripción actualizada', response.message, 'success');
        }
    }.bind(this), 'json').fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        console.error("Respuesta del servidor:", jqXHR.responseText); // Añade esta línea para imprimir la respuesta del servidor
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
                            <td><input type="radio" name="select-overtime" value="${entry.idExtras}"></td>
                            <td>${entry.Fecha}</td>
                            <td>${entry.Hora_Inicio}</td>
                            <td>${entry.Hora_Salida ? entry.Hora_Salida.split(' ')[1] : '-'}</td>
                            <td>${entry.Monto ? entry.Monto : '-'}</td>
                            <td class="description-cell">${entry.Descripcion ? entry.Descripcion : '-'}</td>
                            <td><button class="edit-description">Editar Descripción</button></td>
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