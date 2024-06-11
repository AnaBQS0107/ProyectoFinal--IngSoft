<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/login.css">

    <title>Login</title>
    
</head>
<body>

<img src="../img/FondoLogin.jpg" alt="Peaje" class="background">

    <form method="post" action="../Controlador/Login.php?action=login">


        <label for="cedula" class="label_login">Cedula:</label>
        <input type="text" id="cedula" name="cedula" placeholder="306220410" class="input_login" required>

        <label for="contrasena" class="label_login">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" placeholder="********" class="input_login" required>

        <button type="submit" class="button_login">Iniciar Sesión</button>
    </form>
</body>
</html>