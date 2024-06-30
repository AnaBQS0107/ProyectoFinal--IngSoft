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

    <footer>
    <?php include 'Footer.php'; ?>
    </footer>

</body>

</html>