<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Login</title>

</head>

<body>

    <img src="../img/Login.svg" alt="Peaje" class="background">

    <div class="container-custom">
        <form method="post" action="../Controlador/Login.php?action=login">
            <center>
                <h1>PassWize</h1>
            </center>

            <label for="Persona_Cedula" class="label_login">Cédula:</label>
            <br><br>
            <input type="text" id="Persona_Cedula" name="Persona_Cedula" placeholder="306220410" class="input_login" required>

            <label for="contrasena" class="label_login">Contraseña:</label>
            <br><br>
            <input type="password" id="contrasena" name="contrasena" placeholder="********" class="input_login"
                required>

            <br> <br> 
            <center> <button type="submit" class="button_login">Iniciar Sesión</button></center>

            </form>

<?php
session_start();
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '$error',
        });
    </script>";
}
?>
</body>
</html>