<?php 
require_once '../Controlador/TrabajadoresInfo.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PassWize - Registro</title>
    <link rel="stylesheet" href="Estilos/IngresarUsuario.css">
    <link rel="stylesheet" href="Estilos/Footer.css">
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <div class="container">
        <form id="registroForm" method="post" class="row g-3 needs-validation" novalidate>
            <div class="input-group-horizontal">
                <div class="col-md-3 position-relative">
                    <br><br><br>
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

            <div class="col-md-3 position-relative">
                <label for="cedula" class="form-label">Ingrese su Cédula</label>
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
                <label for="email" class="form-label">Correo Electrónico</label>
                <div class="input-group has-validation">
                    <input type="email" class="input_registro" placeholder="correoejemplo@gmail.com" id="email"
                        name="Correo_Electronico" required>
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
                    <?php if ($resultEstaciones && count($resultEstaciones) > 0) : ?>
                    <?php foreach ($resultEstaciones as $row) : ?>
                    <?php $selected = ($row['idEstacionesPeaje'] == $empleado['Estacion_ID']) ? 'selected' : ''; ?>
                    <option value="<?php echo $row["idEstacionesPeaje"]; ?>" <?php echo $selected; ?>>
                        <?php echo $row["Nombre"]; ?>
                    </option>
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
                        <?php echo $row["Nombre_Rol"]; ?>
                    </option>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <option disabled>No hay roles disponibles</option>
                    <?php endif; ?>
                </select>
            </div>


            <div class="invalid-tooltip"></div>
    </div>
    <center>
        <div class="div_btn">
            <button type="submit" class="btn_registrar">Registrar</button>
        </div>
    </center>
    <br><br>
    </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/EmpleadosCRUD.js"></script>

    <footer>
<div class="footer-container">
            <div class="footer-column">
                <h3>Sobre nosotros</h3>
                <p>PassWize es un servicio de gestión de peajes diseñado para facilitar tu viaje.</p>
            </div>
            <div class="footer-column">
                <h3>Contacto</h3>
                <p>Teléfono: 123456789</p>
                <p>Email: soporte@passwize.com</p>
            </div>
        </div>
        <center> <p>© 2024 PassWize. Todos los derechos reservados.</p> </center>
</footer>
</body>

</html>