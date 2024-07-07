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
    <title>Calcular Salario de Vacaciones</title>
    <link rel="stylesheet" href="Estilos/CalcularVacaciones.css">
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
<br><br>
    <div class="MainContentPlaceDiv">
        <br>
        <h1>Calculo de Salario de Vacaciones</h1>
        <br>
        <form action="../Controlador/CalcularSalario_Vacaciones.php" method="post">
            <div class="form-group">
               <center> <label for="fecha_inicio">Fecha de Inicio:</label> </center>
                <input type="date" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div class="form-group">
            <center><label for="fecha_fin">Fecha de Fin:</label></center>
                <input type="date" id="fecha_fin" name="fecha_fin" required>
            </div>
            <!-- Campo oculto para la cédula del empleado -->
            <input type="hidden" name="Empleados_Persona_Cedula" value="<?php echo htmlspecialchars($user['Persona_Cedula']); ?>">
            <input type="submit" value="Calcular Salario Vacacional" class="btn btn-primary">
        </form>
    </div>
<br><br>
    <footer class="footer-Calc-Extras">
        <?php include 'Footer.php'; ?>
    </footer>
</body>
</html>
