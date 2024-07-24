<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
}

// Conexión a la base de datos
require_once '../Config/config.php';
$db = Database1::getInstance()->getConnection();
$Empleados_Persona_Cedula = htmlspecialchars($_SESSION['user']['Persona_Cedula']);

// Verificar si existe un registro de aguinaldo para el empleado actual
$stmt = $db->prepare("SELECT COUNT(*) FROM aguinaldo WHERE Empleados_Persona_Cedula1 = :cedula");
$stmt->bindParam(':cedula', $Empleados_Persona_Cedula);
$stmt->execute();
$aguinaldoExistente = $stmt->fetchColumn() > 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Aguinaldo</title>
    <link rel="stylesheet" href="Estilos/CalculadoraAguinaldo.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <script>
        $(document).ready(function() {
            // Habilitar/deshabilitar el botón de eliminar y guardar
            var aguinaldoExistente = <?php echo json_encode($aguinaldoExistente); ?>;
            if (!aguinaldoExistente) {
                $('#eliminarAguinaldo, #guardarAguinaldo').prop('disabled', true);
            }

            $('form').submit(function(event) {
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
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#resultadoAguinaldo').text('Aguinaldo Calculado: ¢' + response.aguinaldo);
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: response.message
                            }).then((result) => {
                                // Habilitar los botones de eliminar y guardar si se ha calculado el aguinaldo
                                $('#eliminarAguinaldo, #guardarAguinaldo').prop('disabled', false);
                            });
                        } else {
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

            // Mostrar u ocultar campos según selección de salario en especie
            $('input[name="salarioEspecie"]').change(function() {
                if ($(this).val() == '1') {
                    $('#PorcentajeEspecieTextBox').show();
                    $('#MontoMensualEspecieTextBox').hide();
                } else if ($(this).val() == '2') {
                    $('#PorcentajeEspecieTextBox').hide();
                    $('#MontoMensualEspecieTextBox').show();
                } else {
                    $('#PorcentajeEspecieTextBox').hide();
                    $('#MontoMensualEspecieTextBox').hide();
                }
            });

            // Eliminar aguinaldo
            $('#eliminarAguinaldo').click(function() {
                $.ajax({
                    url: '../Controlador/EliminarAguinaldo.php',
                    type: 'POST',
                    data: { Empleados_Persona_Cedula: '<?php echo $Empleados_Persona_Cedula; ?>' },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: response.message
                            }).then((result) => {
                                // Deshabilitar los botones de eliminar y guardar y limpiar el resultado del aguinaldo
                                $('#eliminarAguinaldo, #guardarAguinaldo').prop('disabled', true);
                                $('#resultadoAguinaldo').text('');
                            });
                        } else {
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

            // Guardar aguinaldo
            $('#guardarAguinaldo').click(function() {
                $.ajax({
                    url: '../Controlador/GuardarAguinaldo.php',
                    type: 'POST',
                    data: { Empleados_Persona_Cedula: '<?php echo $Empleados_Persona_Cedula; ?>' },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: response.message
                            });
                        } else {
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
        });
    </script>
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <div class="container">
        <div class="row">
            <form action="../Controlador/CalculoAguinaldo.php" method="POST">
                <div class="col-xs-12">
                    <h2>Calculadora de Aguinaldo</h2>
                    <br>
                    <div class="form-group">
                        <label for="diciembre">Diciembre (2023):</label>
                        <input name="salarios[]" type="text" id="diciembre" class="form-control numeroConFormato">
                    </div>
                    <div class="form-group">
                        <label for="enero">Enero:</label>
                        <input name="salarios[]" type="text" id="enero" class="form-control numeroConFormato">
                    </div>
                    <div class="form-group">
                        <label for="febrero">Febrero:</label>
                        <input name="salarios[]" type="text" id="febrero" class="form-control numeroConFormato">
                    </div>
                    <div class="form-group">
                        <label for="marzo">Marzo:</label>
                        <input name="salarios[]" type="text" id="marzo" class="form-control numeroConFormato">
                    </div>
                    <div class="form-group">
                        <label for="abril">Abril:</label>
                        <input name="salarios[]" type="text" id="abril" class="form-control numeroConFormato">
                    </div>
                    <div class="form-group">
                        <label for="mayo">Mayo:</label>
                        <input name="salarios[]" type="text" id="mayo" class="form-control numeroConFormato">
                    </div>
                    <div class="form-group">
                        <label for="junio">Junio:</label>
                        <input name="salarios[]" type="text" id="junio" class="form-control numeroConFormato">
                    </div>
                    <div class="form-group">
                        <label for="julio">Julio:</label>
                        <input name="salarios[]" type="text" id="julio" class="form-control numeroConFormato">
                    </div>
                    <div class="form-group">
                        <label for="agosto">Agosto:</label>
                        <input name="salarios[]" type="text" id="agosto" class="form-control numeroConFormato">
                    </div>
                    <div class="form-group">
                        <label for="septiembre">Septiembre:</label>
                        <input name="salarios[]" type="text" id="septiembre" class="form-control numeroConFormato">
                    </div>
                    <div class="form-group">
                        <label for="octubre">Octubre:</label>
                        <input name="salarios[]" type="text" id="octubre" class="form-control numeroConFormato">
                    </div>
                    <div class="form-group">
                        <label for="noviembre">Noviembre:</label>
                        <input name="salarios[]" type="text" id="noviembre" class="form-control numeroConFormato">
                    </div>
                </div>

                <div class="col-xs-12 SalarioEspecieContainer">
                    <ul>
                        <li><h2 for="salarioEspecie">Salario en especie</h2></li>
                        <li><h4 for="salarioEspecie">(Si aplica)</h4></li>
                    </ul>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <input type="radio" name="salarioEspecie" value="0" checked> No Incluir (No se incluye Salario en Especie).
                    </div>
                    <div class="form-group">
                        <input type="radio" name="salarioEspecie" value="1"> Con salario en especie (corresponde a un porcentaje del salario base).
                    </div>
                    <div class="form-group">
                        <input type="radio" name="salarioEspecie" value="2"> Con salario en especie (corresponde a un monto mensual específico).
                    </div>

                    <div class="form-group" id="PorcentajeEspecieTextBox" style="display:none;">
                        <label for="PorcentajeEspecie">Porcentaje Especie: (%)</label>
                        <input name="PorcentajeEspecie" type="text" id="PorcentajeEspecie" class="form-control">
                    </div>
                    <div class="form-group" id="MontoMensualEspecieTextBox" style="display:none;">
                        <label for="MontoMensualEspecie">Monto Mensual Especie: (¢)</label>
                        <input name="MontoMensualEspecie" type="text" id="MontoMensualEspecie" class="form-control">
                    </div>
                </div>

                <div class="col-xs-12">
                    <button type="submit" class="btn-calcularA">Calcular Aguinaldo</button>
                </div>
            </form>
            <div class="col-xs-12">
                <p id="resultadoAguinaldo"></p>
            </div>
            <div class="col-xs-12">
                <button id="guardarAguinaldo" class="btn-GuardarA">Guardar Aguinaldo</button>
                <button id="eliminarAguinaldo" class="btn-eliminarA" >Eliminar Aguinaldo</button>
            </div>
        </div>
    </div>
    <br><br><br><br><br><br><br><br>
    <footer id="footer"></footer>
    <script src="../JS/footer.js"></script>
    
</body>
</html>