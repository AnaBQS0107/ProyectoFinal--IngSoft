<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprobación Horas Extras</title>
    <link rel="stylesheet" href="Estilos/AprobacionHorasExtras.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="Estilos/Footer2.css">
    <link rel="icon" type="image/png" href="../img/icono.png">
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br><br><br>
    <div class="container-AprobacionHorasExtras">
        <h1>Aprobación de Horas Extras</h1>
        <select id="select-empleado" name="select-empleado">
            <option value="">Seleccione un Empleado</option>
            <?php
            require_once '../Config/config.php';

            try {
                $conn = getConnection();
                $sql = "SELECT DISTINCT Empleados_Persona_Cedula FROM extras";
                $stmt = $conn->query($sql);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['Empleados_Persona_Cedula']}'>{$row['Empleados_Persona_Cedula']}</option>";
                }
            } catch (PDOException $e) {
                echo "<option value=''>Error al cargar empleados</option>";
            } finally {
                $conn = null;
            }
            ?>
        </select>
        <button id="select-extras">Seleccionar</button>

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
        <br><br><br>
        <div id="motivo-section" style="display:none;">
            <h2>Motivo</h2>
            <textarea id="motivo" placeholder="Ingrese el motivo de la aprobación o rechazo"></textarea>
            <button id="submit-decision">Enviar</button>
        </div>
    </div>
    <br><br><br>

    <footer id="footer"></footer>
    <script src="../JS/footer.js"></script>

    <script>
        $(document).ready(function() {
            let selectedExtraId = null;
            let action = '';

            $('#select-extras').click(function() {
                const empleadoCedula = $('#select-empleado').val();
                if (empleadoCedula) {
                    $.get('../Controlador/ObtenerHorasExtras.php', {
                        user_id: empleadoCedula
                    }, function(data) {
                        $('#extras-data').empty();
                        if (Array.isArray(data) && data.length > 0) {
                            data.forEach(function(entry) {
                                // Verificar si hay registros en las tablas aprobacion_extras o rechazo_extras para entry.idExtras
                                $.ajax({
                                    url: '../Controlador/VerificarAprobacionRechazo.php',
                                    method: 'GET',
                                    data: {
                                        idExtras: entry.idExtras
                                    },
                                    success: function(response) {
                                        // Si hay registros en alguna tabla, deshabilitar los botones correspondientes
                                        const aprobado = response.aprobado;
                                        const rechazado = response.rechazado;

                                        let approveButton = `<button class="approve-extra" data-id="${entry.idExtras}">Aprobar</button>`;
                                        let rejectButton = `<button class="reject-extra" data-id="${entry.idExtras}">Rechazar</button>`;

                                        if (aprobado) {
                                            approveButton = `<button class="approve-extra" data-id="${entry.idExtras}" disabled style="background-color: lightgray; color: green;">Aprobado</button>`;
                                            rejectButton = `<button class="reject-extra" data-id="${entry.idExtras}" disabled style="background-color: lightgray;">Rechazado</button>`;
                                        }

                                        if (rechazado) {
                                            rejectButton = `<button class="reject-extra" data-id="${entry.idExtras}" disabled style="background-color: lightgray; color: red;">Rechazado</button>`;
                                            approveButton = `<button class="approve-extra" data-id="${entry.idExtras}" disabled style="background-color: lightgray;">Aprobado</button>`;
                                        }

                                        // Construir la fila de la tabla con los botones apropiadamente habilitados o deshabilitados
                                        $('#extras-data').append(
                                            `<tr>
                                                <td>${entry.Fecha}</td>
                                                <td>${entry.Hora_Inicio}</td>
                                                <td>${entry.Hora_Salida ? entry.Hora_Salida.split(' ')[1] : '-'}</td>
                                                <td>${entry.Monto ? entry.Monto : '-'}</td>
                                                <td>${entry.Descripcion ? entry.Descripcion : '-'}</td>
                                                <td>${approveButton}</td>
                                                <td>${rejectButton}</td>
                                            </tr>`
                                        );
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                                        Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
                                    }
                                });
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
                    Swal.fire('Error', 'Por favor, seleccione un Empleado', 'error');
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
                    $.post(url, {
                        idExtras: selectedExtraId,
                        motivo: motivo
                    }, function(response) {
                        if (response.error) {
                            Swal.fire('Error', response.message, 'error');
                        } else {
                            Swal.fire('Éxito', response.message, 'success');
                            $('#motivo-section').hide();
                            $('#motivo').val('');
                            $('#select-extras').click(); // Refresh the table
                        }
                    }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
                        console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                        Swal.fire('Error', 'Error en la solicitud AJAX', 'error');
                    });
                } else {
                    Swal.fire('Error', 'Por favor, ingrese el motivo', 'error');
                }
            });
        });
    </script>

</body>

</html>