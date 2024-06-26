<?php
require_once '../Modelo/Ingreso_Usuario.php';
?>

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
        justify-content: space-between;
        align-items: center;
        background-color: #005c53;
        padding: 10px;
        position: fixed;
        width: 100%;
        top: 0;
        left: 0;
        z-index: 1000;
    }

    footer {
        background-color: #005c53;
        color: white !important;
        padding: 20px 0;
        position: relative;
    }

    .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .footer-content {
        display: flex;
        justify-content: space-around;
        align-items: flex-start;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .about-us,
    .contact {
        flex: 1;
        min-width: 200px;
        text-align: center;
        margin: 10px;
    }

    .contact p {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }

    .contact i {
        margin-right: 10px;
        font-size: 1.2em;
    }

    .footer-icon-container {
        position: absolute;
        top: 20px;
        left: 20px;
    }

    .footer-icon {
        max-width: 150px;
        height: auto;
    }

    .footer-icon-container {
        position: absolute;
        top: 30px;
        left: 90px;
    }

    @media (max-width: 768px) {
        .footer-content {
            flex-direction: column;
            align-items: center;
        }

        .footer-icon-container {
            position: static;
            text-align: center;
            margin-bottom: 20px;
        }
    }

    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        background-color: #333;
        color: white !important;
        text-align: center;
        padding: 10px 0;
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

    .select_registro {
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
    <form id="form" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre"
            value="<?php echo isset($empleado['Nombre']) ? htmlspecialchars($empleado['Nombre']) : ''; ?>"
            required><br><br>

        <label for="apellido1">Primer Apellido:</label>
        <input type="text" id="apellido1" name="apellido1"
            value="<?php echo isset($empleado['Primer_Apellido']) ? htmlspecialchars($empleado['Primer_Apellido']) : ''; ?>"
            required><br><br>

        <label for="apellido2">Segundo Apellido:</label>
        <input type="text" id="apellido2" name="apellido2"
            value="<?php echo isset($empleado['Segundo_Apellido']) ? htmlspecialchars($empleado['Segundo_Apellido']) : ''; ?>"
            required><br><br>

        <label for="Correo">Correo Electrónico:</label>
        <input type="text" id="Correo" name="Correo"
            value="<?php echo isset($empleado['Correo_Electronico']) ? htmlspecialchars($empleado['Correo_Electronico']) : ''; ?>"
            required><br><br>

        <div class="col-md-3 position-relative">
            <label for="estacion" class="form-label">Estación a la que pertenece</label>
            <select class="select_registro" id="estacion" name="Estacion_ID" required>
                <?php if ($resultEstaciones && count($resultEstaciones) > 0) : ?>
                <?php foreach ($resultEstaciones as $row) : ?>
                <?php $selected = ($row['idEstacionesPeaje'] == $empleado['Estacion_ID']) ? 'selected' : ''; ?>
                <option value="<?php echo $row["idEstacionesPeaje"]; ?>" <?php echo $selected; ?>>
                    <?php echo $row["Nombre"]; ?></option>
                <?php endforeach; ?>
                <?php else : ?>
                <option disabled>No hay estaciones disponibles</option>
                <?php endif; ?>
            </select>
        </div>

        <div class="col-md-3 position-relative">
            <label for="rol" class="form-label">Rol al que pertenece</label>
            <select class="select_registro" id="rol" name="Rol_ID" required>
                <?php if ($resultRoles && count($resultRoles) > 0) : ?>
                <?php foreach ($resultRoles as $row) : ?>
                <?php $selected = ($row['idRoles'] == $empleado['Rol_ID']) ? 'selected' : ''; ?>
                <option value="<?php echo $row["idRoles"]; ?>" <?php echo $selected; ?>>
                    <?php echo $row["Nombre_Rol"]; ?></option>
                <?php endforeach; ?>
                <?php else : ?>
                <option disabled>No hay roles disponibles</option>
                <?php endif; ?>
            </select>
        </div>


        <label for="Contrasena">Contraseña:</label>
        <input type="password" id="Contrasena" name="Contrasena"
            value="<?php echo isset($empleado['Contraseña']) ? htmlspecialchars($empleado['Contraseña']) : ''; ?>"
            required><br><br>

        <center><button type="submit" id="submitBtn">Guardar Cambios</button></center>
    </form>
    <br><br>
    <?php include '../Vista/Footer.php'; ?>

    <!-- Script de SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
    document.getElementById('submitBtn').addEventListener('click', function(event) {
        event.preventDefault();
        const updated = true;

        if (updated) {
            Swal.fire({
                icon: 'success',
                title: '¡Actualización exitosa!',
                text: 'Los datos del empleado fueron actualizados correctamente.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form').submit();
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Hubo un problema al actualizar los datos del empleado.',
                confirmButtonText: 'OK'
            });
        }
    });
    </script>
</body>

</html>