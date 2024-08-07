<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
}

$vacacionesDisponibles = 0;

if ($user) {
    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $dbname = "servicio_autobuses";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener los días de vacaciones disponibles del empleado
    $sql = "SELECT VacacionesDisponibles FROM empleados WHERE Persona_Cedula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user['Persona_Cedula']);
    $stmt->execute();
    $stmt->bind_result($vacacionesDisponibles);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salario de Vacaciones</title>
    <link rel="stylesheet" href="Estilos/CalculodeVacaciones.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/Footer2.css">

    <script>
    $(document).ready(function() {
        $('form').submit(function(event) {
            event.preventDefault();

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
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error AJAX:', textStatus, errorThrown);
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
        <h1>Calcular Salario de Vacaciones</h1>
        <br>
        <div class="vacaciones-disponibles">
            <center><h2>Días de Vacaciones Disponibles: <?php echo htmlspecialchars($vacacionesDisponibles); ?></h2></center>
        </div>
        <br>
        <form action="../Controlador/CalcularSalario_Vacaciones.php" method="post">
            <div class="form-group">
                <center><label for="fecha_inicio">Fecha de Inicio:</label></center>
                <input type="date" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div class="form-group">
                <center><label for="fecha_fin">Fecha de Fin:</label></center>
                <input type="date" id="fecha_fin" name="fecha_fin" required>
            </div>
            <input type="hidden" name="Empleados_Persona_Cedula"
                value="<?php echo htmlspecialchars($user['Persona_Cedula']); ?>">
            <input type="submit" value="Calcular Salario Vacacional" class="btn btn-primary">
        </form>
        <br>

    </div>

    <footer id="footer"></footer>
    <script src="../JS/footer.js"></script>
</body>

</html>
