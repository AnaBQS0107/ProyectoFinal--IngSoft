<?php
require_once '../Modelo/Ingreso_Usuario.php';
require_once '../Controlador/EditarUsuario.php';

$trabajadoresTabla = new TrabajadoresTabla();
$resultHorarios = $trabajadoresTabla->obtenerHorarios();
$empleados = $trabajadoresTabla->obtenerTodosLosTrabajadores();

$empleado = [];

if (isset($_GET['id'])) {
    $idEmpleado = $_GET['id']; 
    foreach ($empleados as $emp) {
        if ($emp['Cedula'] == $idEmpleado) {
            $empleado = $emp;
            break;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PassWize - Actualizar Usuario</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/ActualizarEmpleado.css">
</head>

<body>
    <?php include_once '../Vista/header.php'; ?>

    <form id="form" method="post">
        <!-- Aquí va tu formulario -->
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre"
            value="<?php echo isset($empleado['Nombre']) ? htmlspecialchars($empleado['Nombre']) : ''; ?>"
            required><br><br>

        <label for="apellido1">Primer Apellido:</label>
        <input type="text" id="apellido1" name="apellido1"
            value="<?php echo isset($empleado['Apellido1']) ? htmlspecialchars($empleado['Apellido1']) : ''; ?>"
            required><br><br>

        <label for="apellido2">Segundo Apellido:</label>
        <input type="text" id="apellido2" name="apellido2"
            value="<?php echo isset($empleado['Apellido2']) ? htmlspecialchars($empleado['Apellido2']) : ''; ?>"
            required><br><br>

        <label for="Correo">Correo Electrónico:</label>
        <input type="text" id="Correo" name="Correo"
            value="<?php echo isset($empleado['Correo_Electronico']) ? htmlspecialchars($empleado['Correo_Electronico']) : ''; ?>"
            required><br><br>

        <div class="col-md-3 position-relative">
            <label for="estacion">Estación de Peaje:</label>
            <select class="form-select select_registro" id="estacion" type="text" name="Estacion_ID" required>
                <?php foreach ($resultEstaciones as $rowEstacion) : ?>
                <?php $selectedEstacion = ($rowEstacion['idEstacionesPeaje'] == $empleado['Estacion_ID']) ? 'selected' : ''; ?>
                <option value="<?php echo $rowEstacion['idEstacionesPeaje']; ?>" <?php echo $selectedEstacion; ?>>
                    <?php echo htmlspecialchars($rowEstacion['Nombre']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3 position-relative">
            <label for="rol">Rol:</label>
            <select class="form-select select_registro" id="rol" name="Rol_ID" required>
                <?php foreach ($resultRoles as $rowRol) : ?>
                <?php $selectedRol = ($rowRol['idRoles'] == $empleado['Rol_ID']) ? 'selected' : ''; ?>
                <option value="<?php echo $rowRol['idRoles']; ?>" <?php echo $selectedRol; ?>>
                    <?php echo htmlspecialchars($rowRol['Nombre_Rol']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3 position-relative">
            <label for="rol">Horario:</label>
            <select class="form-select select_registro" id="horario" name="Horario_ID" required>
                <?php if (!empty($empleado['Horario_ID'])) : ?>
                <?php foreach ($resultHorarios as $row) : ?>
                <?php $selectedHorario = ($row['IdHorario'] == $empleado['Horario_ID']) ? 'selected' : ''; ?>
                <option value="<?php echo $row['IdHorario']; ?>" <?php echo $selectedHorario; ?>>
                    <?php echo htmlspecialchars($row['Horario']); ?>
                </option>
                <?php endforeach; ?>
                <?php else : ?>
                <option disabled>No hay horarios disponibles</option>
                <?php endif; ?>
            </select>
        </div>

        <center><button type="submit" id="submitBtn">Guardar Cambios</button></center>
    </form>

    <footer class="footer-Act-Monto">
        <?php include 'Footer.php'; ?>
    </footer>

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
