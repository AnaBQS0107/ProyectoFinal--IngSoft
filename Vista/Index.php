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

<img src="../img/Login.svg" alt="Peaje" class="background">

<form method="post" action="../Controlador/Login.php?action=login">

    <label for="Persona_Cedula" class="label_login">Cédula:</label>
    <input type="text" id="Persona_Cedula" name="Persona_Cedula" placeholder="306220410" class="input_login" required>

    <label for="contrasena" class="label_login">Contraseña:</label>
    <input type="password" id="contrasena" name="contrasena" placeholder="********" class="input_login" required>

    <button type="submit" class="button_login">Iniciar Sesión</button>
</form>
</body>
</html>
