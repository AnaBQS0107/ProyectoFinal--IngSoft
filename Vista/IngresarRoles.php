<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PassWize -- Ingresa nuevo rol</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/IngresarRol.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <?php
        require_once '../Vista/header.php';
    ?>
    <br><br><br><br>
    <div class="container">
        <h1>Agregar Nuevo Rol</h1><br>
        <form action="../Modelo/Ingresar_Rol.php" method="post">
            <div class="form-group"><br>
                <label for="nombreRol">Nombre del Rol:</label>
                <input type="text" id="nombreRol" name="nombreRol" class="input_registro" required>
            </div>
            <input type="submit" value="Agregar Rol" class="btn_registrar">
        </form>
    </div>
    <script src="../JS/Roles.js"></script> 
</body>
</html>
