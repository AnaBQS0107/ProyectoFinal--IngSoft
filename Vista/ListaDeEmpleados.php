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
    <br><br>
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
                            <a href="../Controlador/EditarUsuario.php?id=<?php echo $usuario['ID']; ?>"
                                class="btn-edit">Editar</a>
                            <a href="#" data-id="<?php echo $usuario['ID']; ?>" class="btn-delete">Eliminar</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else : ?>
                <tr>
                    <td colspan="10">No hay datos disponibles</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br><br>
        <div class="div_btn">
            <center>
                <button type="button" class="btn_asignar" onclick="location.href='../Vista/IngresarUsuario.php'">Asignar
                    un nuevo empleado</button>
            </center>
        </div>

        <br>
        <div class="div_btn">
            <center> <button type="submit" class="btn_registrar">Exportar PDF</button></center>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.btn-delete').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const employeeId = this.getAttribute('data-id');

                swal({
                    title: "¿Seguro que deseas borrar este usuario?",
                    text: "Una vez eliminado no podrás recuperarlo",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        fetch(`../Controlador/EliminarEmpleado.php?id=${employeeId}`, {
                                method: 'GET'
                            })
                            .then(response => response.text())
                            .then(data => {
                                if (data.trim() === 'success') {
                                    swal("Usuario eliminado con éxito", {
                                        icon: "success",
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    swal("No se pudo eliminar este usuario", {
                                        icon: "error",
                                    });
                                }
                            })
                            .catch(error => {
                                swal("Error: " + error, {
                                    icon: "error",
                                });
                            });
                    } else {
                        swal("El usuario permanecerá en la base de datos");
                    }
                });
            });
        });
    });
    </script>
</body>

</html>