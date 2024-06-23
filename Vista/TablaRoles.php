<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../Controlador/ObtenerRoles.php';
$controller = new RolesController();
$roles = $controller->obtenerRoles();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PassWize - Roles</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/TablaEmpleados.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br><br><br><br>
    <center>
        <h1> Roles en la empresa </h1>
    </center>
    <br>
    <center>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Buscar rol...">
            <button type="button" id="searchButton">Buscar</button>
        </div>
    </center>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id Rol</th>
                    <th scope="col">Nombre del Rol</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roles as $rol) : ?>
                    <tr>
                        <td><?php echo $rol['idRoles']; ?></td>
                        <td><?php echo $rol['Nombre_Rol']; ?></td>
                        <td class="actions">
                            <button class="btn-edit">Editar</button>
                            <button class="btn-delete">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($roles)) : ?>
                    <tr>
                        <td colspan="2">No hay roles disponibles</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br><br>
        <div class="div_btn">
            <center>
                <!-- Enlace para añadir nuevo rol, ajusta según necesites -->
                <button type="button" class="btn_asignar" onclick="location.href='../Vista/AgregarRol.php'">Agregar un nuevo rol</button>
            </center>
        </div>
        <br>
    </div>

    <script src="../JS/EmpleadosCRUD.js"></script>
</body>

</html>