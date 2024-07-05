<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Aguinaldo</title>
    <link rel="stylesheet" href="Estilos/HorasExtras.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
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
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: response.message
                            }).then((result) => {
                                // Redirige o realiza alguna acción adicional si es necesario
                                // window.location.href = 'nueva_pagina.php'; // Ejemplo de redirección
                                // Puedes colocar aquí el código para redirigir o realizar otra acción
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
                <hr>
                <h2 class="Left">Salario bruto de los últimos meses</h2>
                <br><br>
                <ul>
                    <li>En cada una de las siguientes casillas se debe digitar el salario bruto devengado en cada mes según corresponda (Salario Bruto: Salario que incluye horas extras, comisiones, bonificaciones, sin rebajas de cargas sociales ni renta). <br><br></li>
                </ul>
                <hr>
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
                    <hr>
                    <div class="Left">
                        <h2>Salario en especie</h2>
                        (Si aplica)
                    </div>
                    <div class="Left">
                        <div class="form-group">
                            <input type="radio" name="salarioEspecie" value="0" class="salarioEspecioRadio" checked="checked">
                            Sin salario en especie<br>
                        </div>
                        <div class="form-group">
                            <input type="radio" name="salarioEspecie" value="1" class="salarioEspecioRadio">
                            Porcentaje de salario en especie<br>
                            <input name="esPorcentaje" type="hidden" value="1">
                            <input name="salarioEspecieValor" type="number" id="PorcentajeEspecieTextBox" class="form-control" style="display: none;">
                        </div>
                        <div class="form-group">
                            <input type="radio" name="salarioEspecie" value="2" class="salarioEspecioRadio">
                            Monto mensual en especie<br>
                            <input name="montoMensual" type="text" id="MontoMensualEspecieTextBox" class="form-control numeroConFormato" style="display: none;">
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <!-- Campo oculto para el ID del empleado -->
                <input type="hidden" name="Empleados_Persona_Cedula" value="<?php echo htmlspecialchars($_SESSION['user']['Persona_Cedula']); ?>">
                <input type="submit" value="Calcular" class="btn btn-primary marginCenter">
                <hr>
            </form>
        </div>
    </div>

    <footer class="footer-Calc-Extras">
        <?php include 'Footer.php'; ?>
    </footer>
</body>
</html>