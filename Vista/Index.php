<!DOCTYPE html>
<html lang="es">

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
        <form method="post" action="../Controlador/Login.php">
            <center>
                <h1>PassWize</h1>
            </center>

            <!-- Mostrar mensajes de error -->
            <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "' . $_SESSION['error'] . '"
                    });
                </script>';
                unset($_SESSION['error']);
            }
            ?>

            <label for="Persona_Cedula" class="label_login">Cédula:</label>
            <br><br>
            <input type="text" id="Persona_Cedula" name="Persona_Cedula" placeholder="306220410" class="input_login" required>

            <label for="contrasena" class="label_login">Contraseña:</label>
            <br><br>
            <input type="password" id="contrasena" name="contrasena" placeholder="********" class="input_login" required>

            <br> <br> 
            <center>
                <button type="submit" name="login" class="button_login">Iniciar Sesión</button>
            </center>

        </form>
    </div>

</body>
</html>
