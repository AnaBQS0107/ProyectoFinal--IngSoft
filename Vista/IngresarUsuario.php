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
    <script>
        function soloLetras(event) {
            var inputValue = event.charCode;
            if (!(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0)) {
                event.preventDefault();
            }
        }
        function validarCedula(input) {
            var cedula = input.value.trim();
            if (cedula.length !== 9 || !/^\d{9}$/.test(cedula)) {
                input.setCustomValidity('La cédula debe contener exactamente 9 dígitos numéricos.');
            } else {
                input.setCustomValidity('');
            }
        }
        function validarFormulario() {
            var form = document.getElementById('registroForm');
            if (form.checkValidity()) {
                // Aquí puedes añadir cualquier lógica adicional antes de enviar el formulario
                form.submit();
            } else {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }
    </script>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <div class="container">
        <form id="registroForm" method="post" class="row g-3 needs-validation" novalidate style="margin-left: 250px;">
            <div class="col-md-3 position-relative">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="input_registro form-control" id="nombre" name="Nombre" required
                    pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+" onkeypress="soloLetras(event)">
                <div class="valid-tooltip"></div>
            </div>
            <div class="col-md-3 position-relative">
                <label for="apellido1" class="form-label">Primer Apellido</label>
                <input type="text" class="input_registro form-control" id="apellido1" name="Apellido1" required
                    pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+" onkeypress="soloLetras(event)">
            </div>
            <div class="col-md-3 position-relative">
                <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                <input type="text" class="input_registro form-control" id="segundo_apellido" name="Apellido2" required
                    pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+" onkeypress="soloLetras(event)">
                <div class="valid-tooltip"></div>
            </div>

            <div class="col-md-3 position-relative">
                <label for="cedula" class="form-label">Ingrese su Cédula</label>
                <input type="number" class="input_registro form-control" placeholder="104120845" id="cedula" name="Cedula" required
                    minlength="9" maxlength="9" pattern="\d{9}" oninput="validarCedula(this)">
                <div class="valid-tooltip"></div>
            </div>
            <div class="col-md-3 position-relative">
                <label for="contrasena" class="form-label">Ingrese su contraseña</label>
                <input type="password" class="input_registro form-control" placeholder="********" id="contrasena" name="Contrasena"
                    required>
                <div class="valid-tooltip"></div>
            </div>
            <div class="col-md-3 position-relative">
                <label for="email" class="form-label">Correo Electrónico</label>
                <div class="input-group has-validation">
                    <input type="email" class="input_registro form-control" placeholder="correoejemplo@gmail.com" id="email"
                        name="Correo_Electronico" required>
                </div>
            </div>
            <div class="col-md-3 position-relative">
                <label for="SalarioBase" class="form-label">Salario Base</label>
                <input type="number" class="input_registro form-control" id="SalarioBase" name="SalarioBase" required>
                <div class="valid-tooltip"></div>
            </div>
            <div class="col-md-3 position-relative">
                <label for="Fecha" class="form-label">Fecha de Entrada</label>
                <input type="date" class="form-control" id="Fecha" name="Fecha" required>
            </div>
            <br>
            <div class="col-md-3 position-relative">
                <label for="estacion" class="form-label">Estación a la que pertenece</label>
                <select class="select_registro form-select" id="estacion" name="Estacion_ID" required>
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
                <select class="select_registro form-select" id="rol" name="Rol_ID" required>
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
            <div class="col-md-3 position-relative">
                <label for="horario" class="form-label">Horario del empleado</label>
                <select class="select_registro form-select" id="horario" name="Horario_ID" required>
                    <?php if ($resultHorarios && count($resultHorarios) > 0) : ?>
                    <?php foreach ($resultHorarios as $row) : ?>
                    <?php 
                // Verificar si $empleado está definido y tiene 'Horario_ID'
                $selected = '';
                if (isset($empleado) && isset($empleado['Horario_ID'])) {
                    $selected = ($row['IdHorario'] == $empleado['Horario_ID']) ? 'selected' : '';
                }
                ?>
                    <option value="<?php echo $row["IdHorario"]; ?>" <?php echo $selected; ?>>
                        <?php echo $row["Horario"]; ?>
                    </option>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <option disabled>No hay horarios disponibles</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="invalid-tooltip"></div>
          <center>   <div class="div_btn">
                    <button type="submit" class="btn_registrar" onclick="validarFormulario()">Registrar un nuevo usuario</button>
                </div></center>
             
   
            <br><br>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/EmpleadosCRUD.js"></script>

    <?php include 'Footer.php'; ?>
</body>

</html>