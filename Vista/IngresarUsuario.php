<?php
require_once '../Modelo/Ingreso_Usuario.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PassWize - Registro</title>
    <link rel="stylesheet" href="Estilos/IngresarUsuario.css">
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <div class="container">
        <form method="post" action="../Controlador/TrabajadoresInfo.php" class="row g-3 needs-validation" novalidate>
            <div class="input-group-horizontal">
                <div class="col-md-3 position-relative">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="input_registro" id="nombre" name="Nombre" required>
                    <div class="valid-tooltip"></div>
                </div>
                <div class="col-md-3 position-relative">
                    <label for="apellido1" class="form-label">Primer Apellido</label>
                    <input type="text" class="input_registro" id="apellido1" name="Apellido1" required>
                </div>
                <div class="col-md-3 position-relative">
                    <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                    <input type="text" class="input_registro" id="segundo_apellido" name="Apellido2" required>
                    <div class="valid-tooltip"></div>
                </div>
            </div>

            
        <form method="post" action="../Controlador/TrabajadoresInfo.php" class="row g-3 needs-validation" novalidate>
            <div class="col-md-3 position-relative">
                <label for="cedula" class="form-label">Ingrese su Cedula</label>
                <input type="text" class="input_registro" placeholder="104120845" id="cedula" name="Cedula" required>
                <div class="valid-tooltip"></div>
            </div>
            <div class="col-md-3 position-relative">
                <label for="contrasena" class="form-label">Ingrese su contraseña</label>
                <input type="password" class="input_registro" placeholder="********" id="contrasena" name="Contrasena"
                    required>
                <div class="valid-tooltip"></div>
            </div>
            <div class="col-md-3 position-relative">
                <label for="email" class="form-label">Correo Electronico</label>
                <div class="input-group has-validation">
                    <input type="email" class="input_registro" placeholder="correoejemploi@gmail.com" id="email"
                        name="Correo_Electronico" aria-describedby="validationTooltipUsernamePrepend" required>
                    <div class="invalid-tooltip"></div>
                </div>
            </div>
           
            <div class="col-md-2 position-relative">
                <label for="SalarioBase" class="form-label">Salario Base</label>
                <input type="text" class="input_registro" id="SalarioBase" name="SalarioBase" required>
                <div class="valid-tooltip"></div>
            </div>
          
            <div class="col-md-3 position-relative">
                <label for="Fecha" class="form-label">Fecha de Entrada</label>
                <input type="date" class="form-control" id="Fecha" name="Fecha" required>
            </div>
            <br>
            <div class="col-md-3 position-relative">
                <label for="estacion" class="form-label">Estación a la que pertenece</label>
                <select class="select_registro" id="estacion" name="Estacion_ID" required>
                    <option selected disabled value="">Seleccione...</option>
                    <?php
        if ($resultEstaciones && count($resultEstaciones) > 0) {
            foreach ($resultEstaciones as $row) {
                echo '<option value="' . $row["idEstacionesPeaje"] . '">' . $row["Nombre"] . '</option>';
            }
        } else {
            echo '<option disabled>No hay estaciones disponibles</option>';
        }
        ?>
                </select>
            </div>
            <div class="col-md-3 position-relative">
                <label for="rol" class="form-label">Rol al que pertenece</label>
                <select class="select_registro" id="rol" name="Rol_ID" required>
                    <option selected disabled value="">Seleccione...</option>
                    <?php
        if ($resultRoles && count($resultRoles) > 0) {
            foreach ($resultRoles as $row) {
                echo '<option value="' . $row["idRoles"] . '">' . $row["Nombre_Rol"] . '</option>';
            }
        } else {
            echo '<option disabled>No hay roles disponibles</option>';
        }
        ?>
                </select>
                <div class="invalid-tooltip"></div>
            </div>
            <center>
                <div class="div_btn">
                    <button type="submit" class="btn_registrar">Registrar</button>
                </div>
            </center>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'Footer.php'; ?>
</body>

</html>