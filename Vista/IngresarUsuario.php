<?php
require_once '../Controlador/TrabajadoresInfo.php';
$diasVacaciones = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fechaEntrada = $_POST['Fecha'];
    $diasVacaciones = calcularVacaciones($fechaEntrada);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PassWize - Registro</title>
    <link rel="stylesheet" href="Estilos/IngresarUsuario.css">
    <link rel="stylesheet" href="Estilos/Footer2.css">
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function soloLetras(event) {
            var inputValue = event.charCode;
            if (!(inputValue >= 65 && inputValue <= 122) && !(inputValue >= 192 && inputValue <= 255) && (inputValue != 32 && inputValue != 0)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Entrada no válida',
                    text: 'Este campo solo acepta letras.'
                });
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

        function validarFormulario(event) {
            var form = document.getElementById('registroForm');
            if (form.checkValidity()) {
                event.preventDefault(); // Evitar el envío del formulario por defecto
                Swal.fire({
                    icon: 'success',
                    title: '¡Registro Exitoso!',
                    text: 'El empleado se ha registrado correctamente.',
                    showConfirmButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Enviar el formulario después de la confirmación
                    }
                });
            } else {
                event.preventDefault(); // Evitar el envío del formulario si hay errores
                event.stopPropagation(); // Detener la propagación del evento
            }
            form.classList.add('was-validated');
        }

        document.addEventListener('DOMContentLoaded', function () {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('Fecha').setAttribute('max', today);

            document.querySelector('form').addEventListener('submit', validarFormulario);
        });

        function calcularVacaciones() {
            var fechaEntrada = document.getElementById('Fecha').value;
            if (fechaEntrada) {
                var today = new Date();
                var entrada = new Date(fechaEntrada);
                var diff = today.getTime() - entrada.getTime();
                var diasVacaciones = Math.floor(diff / (1000 * 60 * 60 * 24 * 30)); // 1 día de vacaciones por cada mes
                document.getElementById('vacaciones').value = diasVacaciones;
            }
        }

        function validarNumeros(event) {
            var inputValue = event.charCode;
            if (inputValue >= 65 && inputValue <= 122) { // Letras
                Swal.fire({
                    icon: 'error',
                    title: 'Entrada no válida',
                    text: 'Este campo solo acepta números.'
                });
                event.preventDefault();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('input[type="number"]').forEach(function (input) {
                input.addEventListener('keypress', validarNumeros);
            });
        });
    </script>

</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <center>
        <div class="container-ingresarEmpleado">
            <form id="registroForm" method="post" class="row g-3 needs-validation">
                <div class="col-md-3 position-relative">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="input_registro form-control" id="nombre" name="Nombre" required
                        pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+" onkeypress="soloLetras(event)">
                </div>
                <div class="col-md-3 position-relative">
                    <label for="apellido1" class="form-label">Primer Apellido</label>
                    <input type="text" class="input_registro form-control" id="apellido1" name="Apellido1" required
                        pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+" onkeypress="soloLetras(event)">
                </div>
                <div class="col-md-3 position-relative">
                    <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                    <input type="text" class="input_registro form-control" id="segundo_apellido" name="Apellido2"
                        required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+" onkeypress="soloLetras(event)">
                </div>

                <div class="col-md-3 position-relative">
                    <label for="cedula" class="form-label">Cédula</label>
                    <input type="number" class="input_registro form-control" placeholder="104120845" id="cedula"
                        name="Cedula" required minlength="9" maxlength="9" pattern="\d{9}"
                        oninput="validarCedula(this)">
                </div>
                <div class="col-md-3 position-relative">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <div class="input-group has-validation">
                        <input type="email" class="input_registro form-control" placeholder="correoejemplo@gmail.com"
                            id="email" name="Correo_Electronico" required>
                    </div>
                </div>
                <div class="col-md-3 position-relative">
                    <label for="SalarioBase" class="form-label">Salario Base</label>
                    <input type="number" class="input_registro form-control" id="SalarioBase" name="SalarioBase"
                        required>
                </div>
                <div class="col-md-3 position-relative">
                    <label for="Fecha" class="form-label">Fecha de Entrada</label>
                    <input type="date" class="form-control" id="Fecha" name="Fecha" required
                        onchange="calcularVacaciones()">
                </div>
                <br>
                <div class="col-md-3 position-relative">
                    <label for="vacaciones" class="form-label">Días de Vacaciones</label>
                    <input type="number" class="input_registro form-control" id="vacaciones" name="Vacaciones" readonly
                        value="<?php echo $diasVacaciones; ?>">
                </div>
                <div class="col-md-3 position-relative">
                    <label for="estacion" class="form-label">Estación a la que pertenece</label>
                    <select class="select_registro form-select" id="estacion" name="Estacion_ID" required>
                        <?php if ($resultEstaciones && count($resultEstaciones) > 0) : ?>
                        <?php foreach ($resultEstaciones as $row) : ?>
                        <option value="<?php echo $row["idEstacionesPeaje"]; ?>">
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
                        <option value="<?php echo $row["idRoles"]; ?>">
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
                        <option value="<?php echo $row["IdHorario"]; ?>">
                            <?php echo $row["Horario"]; ?>
                        </option>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <option disabled>No hay horarios disponibles</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="invalid-tooltip"></div>
                <center>
                    <div class="div_btn">
                        <button type="submit" class="btn_registrar">Registrar nuevo empleado</button>
                    </div>
                </center>
                <br>
            </form>
        </div>
    </center>
</body>

</html>
