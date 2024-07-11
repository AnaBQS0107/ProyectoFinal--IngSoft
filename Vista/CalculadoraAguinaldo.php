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
    <script>
        $(document).ready(function() {
            // Habilitar/deshabilitar el botón de eliminar
            var aguinaldoExistente = <?php echo json_encode($aguinaldoExistente); ?>;
            if (!aguinaldoExistente) {
                $('#eliminarAguinaldo').prop('disabled', true);
            }

            $('form').submit(function(event) {
                event.preventDefault(); // Evita el envío estándar del formulario

                // Realiza la solicitud AJAX al script de cálculo
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#resultadoAguinaldo').text('Aguinaldo Calculado: ' + response.aguinaldo);
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: response.message
                            }).then((result) => {
                                // Habilitar el botón de eliminar si se ha calculado el aguinaldo
                                $('#eliminarAguinaldo').prop('disabled', false);
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
                                // Deshabilitar el botón de eliminar y limpiar el resultado del aguinaldo
                                $('#eliminarAguinaldo').prop('disabled', true);
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
        });
    </script>
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <div class="MainContentPlaceDiv">
        <br>
        <h1>Calculadora de Aguinaldo</h1>
        <div class="row">
            <div class="col-xs-12">
                
                <h2 class="Left">Salario bruto de los últimos meses</h2>
                <br><br>
                <ul>
                    <li>En cada una de las siguientes casillas se debe digitar el salario bruto devengado en cada mes según corresponda (Salario Bruto: Salario que incluye horas extras, comisiones, bonificaciones, sin rebajas de cargas sociales ni renta). <br><br></li>
                </ul>
                
            </div>
            <form action="../Controlador/CalculoAguinaldo.php" method="POST">
                <div class="col-lg-6 col-xs-12">
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
                </div>
                <div class="col-lg-6 col-xs-12">
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
                        <label for="setiembre">Setiembre:</label>
                        <input name="salarios[]" type="text" id="setiembre" class="form-control numeroConFormato">
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
                    
                    <div class="Left">
                        <h2>Salario en especie</h2>
                        <h4>(Si aplica)</h4>
                    </div>
                    <div class="Left">
                        <div class="form-group">
                            <input type="radio" name="salarioEspecie" value="0" class="salarioEspecieRadio">
                            Sin salario en especie<br>
                        </div>
                        <div class="form-group">
                            <input type="radio" name="salarioEspecie" value="1" class="salarioEspecieRadio">
                            Con salario en especie que corresponde a un porcentaje del salario base<br>
                        </div>
                        <div class="form-group">
                            <input type="radio" name="salarioEspecie" value="2" class="salarioEspecieRadio">
                            Con salario en especie que corresponde a un monto mensual específico<br>
                        </div>
                        <div class="form-group" id="PorcentajeEspecieTextBox" style="display:none">
                            <label for="PorcentajeEspecie">Porcentaje (%)</label>
                            <input name="PorcentajeEspecie" type="text" id="PorcentajeEspecie" class="form-control numeroConFormato">
                        </div>
                        <div class="form-group" id="MontoMensualEspecieTextBox" style="display:none">
                            <label for="MontoMensualEspecie">Monto mensual en especie (¢)</label>
                            <input name="MontoMensualEspecie" type="text" id="MontoMensualEspecie" class="form-control numeroConFormato">
                        </div>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <button type="submit" class="btn-calcularA">Calcular Aguinaldo</button>
                    <button type="button" id="eliminarAguinaldo" class="btn-eliminarA">Eliminar Aguinaldo</button>
                </div>
                <div class="form-group col-xs-12">
                    <div id="resultadoAguinaldo"></div>
                </div>
            </form>
        </div>
    </div>
    <br><br><br><br><br><br><br><br>
        <?php include 'Footer.php'; ?>
</body>
</html>


