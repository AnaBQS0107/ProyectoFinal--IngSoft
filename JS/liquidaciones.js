
$(document).ready(function() {
    const calcularBtn = $('#calcularAguinaldoBtn');
    const calculadoraAguinaldo = $('#calculadoraAguinaldo');
    const preaviso = $('#preaviso');
    const diasPreavisoContainer = $('#diasPreavisoContainer');
    const resultadosContainer = $('#resultadosContainer');

    // Mostrar el formulario de calculadora de aguinaldo al hacer clic en el botón
    calcularBtn.click(function() {
        calculadoraAguinaldo.show();
    });

    // Mostrar y ocultar el contenedor de días de preaviso basado en la selección
    preaviso.change(function() {
        if (preaviso.val() === 'dias_pendientes') {
            diasPreavisoContainer.show();
        } else {
            diasPreavisoContainer.hide();
        }
    });

    // Manejar el clic en el botón de calcular (dentro del formulario)
    $('#formAguinaldo').submit(function(event) {
        event.preventDefault(); // Evita el envío estándar del formulario

        // Validar que al menos un campo de salario tenga un valor numérico válido
        var salariosValidos = false;
        $('input[name="salarios[]"]').each(function() {
            var salario = $(this).val().trim();
            if (salario !== '' && !isNaN(parseFloat(salario))) {
                salariosValidos = true;
                return false; // Sale del bucle si encuentra un valor válido
            }
        });

        if (!salariosValidos) {
            // Mostrar alerta de SweetAlert2 si ningún salario es válido
            Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'Por favor, completa al menos un campo de salario con un valor numérico válido.'
            });
            return; // Sale de la función si no hay salarios válidos
        }

        // Realiza la solicitud AJAX al script de cálculo
        $.ajax({
            url: '../Controlador/CalcularLiquidaciones.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Mostrar el contenedor de resultados
                    resultadosContainer.show();

                    // Construir el texto con los datos recibidos
                    var resultText = 
                        '<strong>Antigüedad:</strong> ' + response.data.antiguedad + '<br>' +
                        '<strong>Salario Promedio:</strong> ¢' + response.data.salarioPromedio.toFixed(2) + '<br>' +
                        '<strong>Salario Diario:</strong> ¢' + response.data.salarioDiario.toFixed(2) + '<br>' +
                        '<strong>Rango de Fechas:</strong> ' + response.data.rangoFechas + '<br>' +
                        '<strong>Saldo Vacaciones:</strong> ¢' + response.data.saldoVacaciones.toFixed(2) + '<br>' +
                        '<strong>Aguinaldo:</strong> ¢' + response.data.aguinaldo.toFixed(2) + '<br>' +
                        '<strong>Vacaciones:</strong> ¢' + response.data.vacaciones.toFixed(2) + '<br>' +
                        '<strong>Preaviso:</strong> ¢' + response.data.preaviso.toFixed(2) + '<br>' +
                        '<strong>Cesantía:</strong> ¢' + response.data.cesantia.toFixed(2) + '<br>' +
                        '<strong>Total:</strong> ¢' + response.data.total.toFixed(2);

                    // Mostrar el texto en el elemento <p> con id resultadoAguinaldo
                    $('#resultadoAguinaldo').html(resultText);

                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message
                    }).then(() => {
                        // Habilitar los botones de eliminar y guardar si se ha calculado el aguinaldo
                        $('#eliminarAguinaldo, #guardarAguinaldo').prop('disabled', false);
                    });
                } else {
                    // Mostrar el mensaje de error en el elemento <p>
                    $('#resultadoAguinaldo').html('<strong>Error:</strong> ' + response.message);
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error del servidor',
                    text: 'Hubo un problema al procesar tu solicitud. Inténtalo de nuevo más tarde.'
                });
            }
        });
    });

    // Formatear los campos de salario para aceptar solo números
    $('.numeroConFormato').on('input', function() {
        $(this).val($(this).val().replace(/[^0-9.]/g, ''));
    });
});

