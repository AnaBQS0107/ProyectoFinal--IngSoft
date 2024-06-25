<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Controlador/Empleados.php';
require_once '../Modelo/Ingreso_Usuario.php';

$controller = new EmpleadoController1();

$controller->mostrarEmpleados();
$trabajadoresTabla = new TrabajadoresTabla();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PassWize - Registro</title>
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
            <h1>Lista de Empleados</h1>
        </center>
        <br>
    <center>
        <div class="search-container">
    <input type="text" id="searchInput" placeholder="Buscar empleado...">
    <button type="button" id="searchButton">Buscar</button></center>
</div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Cédula</th>
                    <th scope="col">Contraseña</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido 1</th>
                    <th scope="col">Apellido 2</th>
                    <th scope="col">Correo Electrónico</th>
                    <th scope="col">Estación ID</th>
                    <th scope="col">Rol ID</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($controller->resultTrabajadores)) : ?>
                <?php foreach ($controller->resultTrabajadores as $usuario) : ?>
                <tr>
                    <td><?php echo $usuario['Cedula']; ?></td>
                    <td><?php echo $usuario['Contrasena']; ?></td>
                    <td><?php echo $usuario['Nombre']; ?></td>
                    <td><?php echo $usuario['Apellido1']; ?></td>
                    <td><?php echo $usuario['Apellido2']; ?></td>
                    <td><?php echo $usuario['Correo_Electronico']; ?></td>
                    <td><?php echo $trabajadoresTabla->obtenerNombreEstacion($usuario['Estacion_ID']); ?></td>
                    <td><?php echo $trabajadoresTabla->obtenerTipoDeRol($usuario['Rol_ID']); ?></td>
                    <td>
                        <div class="button-container">
                            <a href="../Controlador/EditarUsuario.php?id=<?php echo $usuario['Cedula']; ?>"
                                class="btn-edit">Editar</a>
                            <a href="#" data-Cedula="<?php echo $usuario['Cedula']; ?>" class="btn-delete">Eliminar</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else : ?>
                <tr>
                    <td colspan="9">No hay datos disponibles</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br><br>
        <div class="div_btn">
        </div>

        <br>
    </div>


    <script src="../JS/EmpleadosCRUD.js"></script>
    <?php include 'Footer.php'; ?>
</body>

</html>
