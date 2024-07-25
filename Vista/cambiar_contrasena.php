<?php
// Iniciar la sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="Estilos/Footer2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/CambiarContra.css">
 
</head>
<body>
<header>
    <?php include 'header.php'; ?>
</header>
<br><br><br>
<div class="container">
    <?php
    // Mostrar mensaje de bienvenida si el usuario está logueado
    if (isset($_SESSION['user'])) {
        echo "<p style='color: blue;'>Bienvenido, " . htmlspecialchars($_SESSION['user']['Nombre']) . "!</p>";
    } else {
        echo "<p style='color: red;'>No estás logueado. Por favor, inicia sesión.</p>";
    }
    ?>
    <form action="../Controlador/procesar_cambio_contraseña.php" method="POST">
        <label for="nueva_contrasena">Nueva Contraseña:</label>
        <input type="password" id="nueva_contrasena" name="nueva_contrasena" required>
        <br>
        <label for="confirmar_contrasena">Confirmar Contraseña:</label>
        <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
        <br>
        <input type="submit" value="Cambiar Contraseña">
    </form>
</div>

<footer id="footer"></footer>
<script src="../JS/footer.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php
        // Mostrar mensaje de éxito si existe
        if (isset($_SESSION['success'])) {
            echo "Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '" . addslashes($_SESSION['success']) . "'
            });";
            unset($_SESSION['success']);
        }

        // Mostrar mensaje de error si existe
        if (isset($_SESSION['error'])) {
            echo "Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '" . addslashes($_SESSION['error']) . "'
            });";
            unset($_SESSION['error']);
        }
        ?>
    });
</script>
</body>
</html>
