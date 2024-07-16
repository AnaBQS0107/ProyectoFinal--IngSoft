<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
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
    <link rel="stylesheet" href="Estilos/Footer.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <div class="header-space"></div>
    <center>
        <h1>Lista de Empleados</h1>
    </center>
    <br>
    <center>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Buscar empleado...">
            <button type="button" id="searchButton">Buscar</button>
        </div>
    </center>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Cédula</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido 1</th>
                    <th scope="col">Apellido 2</th>
                    <th scope="col">Correo Electrónico</th>
                    <th scope="col">Horario</th>
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
                            <td><?php echo $usuario['Nombre']; ?></td>
                            <td><?php echo $usuario['Apellido1']; ?></td>
                            <td><?php echo $usuario['Apellido2']; ?></td>
                            <td><?php echo $usuario['Correo_Electronico']; ?></td>
                            <td>
                                <?php
                                if (isset($usuario['Horario_ID'])) {
                                    echo $trabajadoresTabla->obtenerHorarioPorId($usuario['Horario_ID']);
                                } else {
                                    echo 'Horario no asignado';
                                }
                                ?>
                            </td>
                            <td><?php echo $trabajadoresTabla->obtenerNombreEstacion($usuario['Estacion_ID']); ?></td>
                            <td><?php echo $trabajadoresTabla->obtenerTipoDeRol($usuario['Rol_ID']); ?></td>
                            <td>
                                <div class="button-container">
                                    <a href="ActualizarEmpleado.php?id=<?php echo  $usuario['Cedula']; ?>" class="btn-edit">Editar</a>
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
        <div class="footer-space"></div>
        <div class="div_btn">
            <br><br>
            <center>
                <button type="button" class="btn_asignar" onclick="location.href='../Vista/IngresarUsuario.php'">Agregar un nuevo usuario</button>
            </center>
        </div>
    </div>

    <script src="../JS/EmpleadosCRUD.js"></script>

</body>

<footer>
    <?php include 'Footer.php'; ?>
</footer>

</html>
