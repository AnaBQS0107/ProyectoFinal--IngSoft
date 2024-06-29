<?php
require_once '../Modelo/Ingreso_Usuario.php';
require_once '../Controlador/EditarUsuario.php';
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
            <label for="estacion">Estación de Peaje:</label>
            <select class="form-select select_registro"  id="estacion"  type="text" name="Estacion_ID" required>
                <?php foreach ($resultEstaciones as $rowEstacion) : ?>
                <?php $selectedEstacion = ($rowEstacion['idEstacionesPeaje'] == $empleado['EstacionesPeaje_idEstacionesPeaje']) ? 'selected' : ''; ?>
                <option value="<?php echo $rowEstacion['idEstacionesPeaje']; ?>" <?php echo $selectedEstacion; ?>>
                    <?php echo htmlspecialchars($rowEstacion['Nombre']); ?>
                </option>
                <?php endforeach; ?>
            </select>

            <div class="col-md-3 position-relative">
            <label for="rol">Rol:</label>
            <select class="form-select select_registro" id="rol" name="Rol_ID" required>
        <?php foreach ($resultRoles as $rowRol) : ?>
            <?php $selectedRol = ($rowRol['idRoles'] == $empleado['Roles_idRoles']) ? 'selected' : ''; ?>
            <option value="<?php echo $rowRol['idRoles']; ?>" <?php echo $selectedRol; ?>>
                <?php echo htmlspecialchars($rowRol['Nombre_Rol']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

        <label for="Contrasena">Contraseña:</label>
        <input type="password" id="Contrasena" name="Contrasena"
            value="<?php echo isset($empleado['Contraseña']) ? htmlspecialchars($empleado['Contraseña']) : ''; ?>"
            required><br><br>

        <center><button type="submit" id="submitBtn">Guardar Cambios</button></center>
    </form>
    <br><br>


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
    <br>
    <?php include 'Footer.php'; ?>
</body>

</html>