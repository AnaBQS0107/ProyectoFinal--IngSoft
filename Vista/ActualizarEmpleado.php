<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PassWize - Actualizar Usuario</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
    }

    .navbar {
        display: flex;
        jutify-content: space-between;
        align-items: center;
        background-color: #005c53;
        padding: 10px;
        position: fixed;
        width: 100%;
        top: 0;
        left: 0;
        z-index: 1000;
    }

    .navbar-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .navbar-brand img {
        border-radius: 5px;
    }

    .navbar-title {
        color: #fff;
        text-decoration: none;
        font-size: 23px;
    }

    /* Estilos del botón de menú */
    .hamburger-menu {
        font-size: 30px;
        color: #fff;
        cursor: pointer;
        border: 2.5px solid #9fc13152;
        /* Borde transparente */
        border-radius: 7px;
        /* Bordes curvos */
        padding: 7px;
        /* Añade un poco de espacio interior */
        padding-top: 1px;
        padding-bottom: 1px;
        margin-right: 10px;
        /* Mueve el botón 10px a la izquierda */
    }

    .hamburger-menu:hover {
        background-color: #9fc13152;
    }

    /* Estilos del menú desplegable */
    .navbar-links {
        font-size: 16px;
        font-weight: 200;
        display: none;
        position: absolute;
        top: calc(100%);
        /* Ajusta la distancia desde la parte superior */
        right: 0px;
        /* Alinea a la derecha */
        background-color: #003b36;
        z-index: 999;
        /* Asegura que esté por encima de otros elementos */
        border-radius: 5px;
        transition: height 0.3s;
        /* Añade una transición suave */
        width: auto;
        /* Anchura fija para el menú desplegable */
        height: 500%;
    }

    /* Estilos de la lista de elementos del menú */
    .navbar-links ul {
        list-style: none;
        flex-direction: column;
        width: 100%;
        padding-top: 10px;
        /* Añade relleno para separar los elementos del menú */
        text-align: center;
        /* Centra el texto */
    }

    /* Estilos de los elementos de la lista */
    .navbar-links ul li {
        text-align: center;
        padding: 10px;
        left: auto;
        /* Ajusta la posición a la izquierda */
        right: 10px;
        /* Ajusta la posición a la derecha */
    }


    /* Estilos de los enlaces en la lista */
    .navbar-links ul li a {
        color: #fff;
        text-decoration: none;
        padding: 5px 10px;
        display: block;
        text-align: center;
        /* Centra el texto */
    }

    /* Estilos al pasar el mouse sobre los enlaces */
    .navbar-links ul li a:hover {
        color: #fff;
        background-color: #015e569c;
        border-radius: 5px;
    }

    /* Estilos del menú desplegable del elemento de menú */
    .nav-item.dropdown .dropdown-menu {
        display: none;
        position: absolute;
        background-color: #9fc13152;
        border: none;
        margin-top: 10px;
        left: auto;
        /* Ajusta la posición a la izquierda */
        right: 0px;
        /* Ajusta la posición a la derecha */
        max-height: 0;
        /* Altura inicial del menú desplegable */
        overflow: hidden;
        /* Oculta el contenido que exceda la altura máxima */
        transition: max-height 0.3s ease;
        /* Transición suave de la altura */
    }

    /* Mostrar el menú desplegable cuando se pasa el mouse sobre el elemento de menú */
    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
        max-height: 200px;
        /* Altura máxima del menú desplegable */
        margin-top: 5px;
        /* Ajusta el margen superior */
    }

    /* Ajuste de posición de otros elementos cuando se muestra el menú desplegable */
    .nav-item.dropdown:hover~.nav-item {
        transform: translateY(126px);
        /* Ajusta la distancia para mover los elementos */
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        padding: 20px;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="password"] {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 14px;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #45a049;
    }
    </style>
</head>

<body>
    <?php include_once '../Vista/header.php'; ?>
    <br> <br> <br> 
    <form method="post">
        <label>Nombre:</label>
        <input type="text" name="Nombre" value="<?php echo isset($empleado['Nombre']) ? $empleado['Nombre'] : ''; ?>">
        <br>
        <label>Cédula:</label>
        <input type="text" name="Cedula" value="<?php echo isset($empleado['Cedula']) ? $empleado['Cedula'] : ''; ?>">
        <br>
        <label>Contraseña:</label>
        <input type="password" name="Contrasena"
            value="<?php echo isset($empleado['Contrasena']) ? $empleado['Contrasena'] : ''; ?>">
        <br>
        <label>Apellido 1:</label>
        <input type="text" name="Apellido1"
            value="<?php echo isset($empleado['Apellido1']) ? $empleado['Apellido1'] : ''; ?>">
        <br>
        <label>Apellido 2:</label>
        <input type="text" name="Apellido2"
            value="<?php echo isset($empleado['Apellido2']) ? $empleado['Apellido2'] : ''; ?>">
        <br>
        <label>Correo Electrónico:</label>
        <input type="text" name="Correo_Electronico"
            value="<?php echo isset($empleado['Correo_Electronico']) ? $empleado['Correo_Electronico'] : ''; ?>">
        <br>
        <label>Estación ID:</label>
        <input type="text" name="Estacion_ID"
            value="<?php echo isset($empleado['Estacion_ID']) ? $empleado['Estacion_ID'] : ''; ?>">
        <br>
        <label>Rol ID:</label>
        <input type="text" name="Roles" value="<?php echo isset($empleado['Rol_ID']) ? $empleado['Rol_ID'] : ''; ?>">
        <br> <br>
        <center><button type="submit" class="btn btn-primary">Actualizar</button></center>
    </form>
</body>

</html>