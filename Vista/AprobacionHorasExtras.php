<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprobación Horas Extras</title>
    <link rel="stylesheet" href="Estilos/AprobacionHorasExtras.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br><br><br>
    <div class="container-AprobacionHorasExtras">
        <h1>Aprobación de Horas Extras</h1>
        <input type="text" id="search-persona-cedula" placeholder="Buscar por Persona_Cedula">
        <button id="search-extras">Buscar</button>
        
        <table id="extras-table" style="display:none;">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora de inicio</th>
                    <th>Hora de finalización</th>
                    <th>Monto</th>
                    <th>Descripción</th>
                    <th>Aprobar</th>
                    <th>Rechazar</th>
                </tr>
            </thead>
            <tbody id="extras-data">
            </tbody>
        </table>

        <div id="motivo-section" style="display:none;">
            <h2>Motivo</h2>
            <textarea id="motivo" placeholder="Ingrese el motivo de la aprobación o rechazo"></textarea>
            <button id="submit-decision">Enviar</button>
        </div>
    </div>

    <script>
    let selectedExtraId = null;
    let action = '';

    $('#search-extras').click(function() {
        const personaCedula = $('#search-persona-cedula').val();
        if (personaCedula) {
            $.get('../Controlador/ObtenerHorasExtras.php', { user_id: personaCedula }, function(data) {
                $('#extras-data').empty();
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(function(entry) {
                        $('#extras-data').append(`
                            <tr>
                                <td>${entry.Fecha}</td>
                                <td>${entry.Hora_Inicio}</td>
                                <td>${entry.Hora_Salida ? entry.Hora_Salida.split(' ')[1] : '-'}</td>
                                <td>${entry.Monto ? entry.Monto : '-'}</td>
                                <td>${entry.Descripcion ? entry.Descripcion : '-'}</td>
                                <td><button class="approve-extra" data-id="${entry.idExtras}">Aprobar</button></td>
                                <td><button class="reject-extra" data-id="${entry.idExtras}">Rechazar</button></td>
                            </tr>
                        `);
                    });
                    $('#extras-table').show();
                } else {
                    Swal.fire('Error', 'No se encontraron horas extras para el usuario proporcionado', 'error');
                }
            }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
            });
        } else {
            Swal.fire('Error', 'Por favor, ingrese una Persona_Cedula', 'error');
        }
    });

    $(document).on('click', '.approve-extra, .reject-extra', function() {
        selectedExtraId = $(this).data('id');
        action = $(this).hasClass('approve-extra') ? 'approve' : 'reject';
        $('#motivo-section').show();
    });

    $('#submit-decision').click(function() {
        const motivo = $('#motivo').val();
        if (selectedExtraId && motivo) {
            const url = action === 'approve' ? '../Controlador/AprobarHorasExtras.php' : '../Controlador/RechazarHorasExtras.php';
            $.post(url, { idExtras: selectedExtraId, motivo: motivo }, function(response) {
                if (response.error) {
                    Swal.fire('Error', response.message, 'error');
                } else {
                    Swal.fire('Éxito', response.message, 'success');
                    $('#motivo-section').hide();
                    $('#motivo').val('');
                    $('#search-extras').click(); // Refresh the table
                }
            }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
            });
        } else {
            Swal.fire('Error', 'Por favor, ingrese el motivo', 'error');
        }
    });
    </script>
<br><br><br>
        <?php include 'Footer.php'; ?>
    
</body>

</html>