<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}


$user = $_SESSION['user'];
$cedula = $user['Persona_Cedula'];

// Configurar la conexión a la base de datos
require_once '../Config/config.php'; // Asegúrate de que la conexión a la base de datos está configurada correctamente

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("set names utf8");
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit();
}

try {
    $stmt = $conn->prepare("SELECT VacacionesDisponibles, Fecha_ingreso FROM empleados WHERE Persona_Cedula = :cedula");
    $stmt->bindParam(':cedula', $cedula, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $vacacionesDisponibles = $result['VacacionesDisponibles'] ?? 0;
    $fecha_ingreso = $result['Fecha_ingreso'] ?? '';
} catch(PDOException $e) {
    echo "Error al obtener los datos del empleado: " . $e->getMessage();
    $vacacionesDisponibles = 0;
    $fecha_ingreso = '';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de liquidaciones</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/Liquidaciones.css">
    <link rel="stylesheet" href="Estilos/Footer2.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <?php require_once '../Vista/header.php'; ?>
    <br><br><br><br>
    <center>
        <h1>Calcular liquidaciones</h1>
    </center>
    <div>
        <form action="../Controlador/CalcularLiquidaciones.php" id="liquidacionesForm" class="container" method="post">

            <div class="row">
                <div class="col-md-3 position-relative">
                    <label for="fechaEntrada" class="form-label">Fecha de entrada</label>
                    <input type="date" class="form-control" id="fechaEntrada" name="fechaEntrada" required
                    value="<?php echo isset($fecha_ingreso) ? $fecha_ingreso : ''; ?>" readonly>
                </div>
                <div class="col-md-3 position-relative">
                    <label for="fechaSalida" class="form-label">Fecha de salida</label>
                    <input type="date" class="form-control" id="fechaSalida" name="fechaSalida" required>
                </div>

                <div class="col-md-3 position-relative">
                    <label for="preaviso" class="form-label">Preaviso</label>
                    <select class="select_registro" id="preaviso" name="preaviso" required>
                        <option selected disabled value="">Seleccione...</option>
                        <option value="otro">Preaviso trabajado total</option>
                        <option value="otro">Preaviso a pagar total</option>

                    </select>
                </div>

                <div class="col-md-3 position-relative">
                    <label for="salida" class="form-label">Motivo de salida</label>
                    <select class="select_registro" id="salida" name="salida" required>
                        <option selected disabled value="">Seleccione...</option>
                        <option value="Renuncia">Renuncia</option>
                        <option value="despido_con">Despido con responsabilidad patronal</option>
                        <option value="despido_sin">Despido sin responsabilidad patronal</option>
                    </select>
                </div>

                <div class="col-md-3 position-relative">
                    <label for="tipoPago" class="form-label">Tipo de pago</label>
                    <select class="select_registro" id="tipoPago" name="tipoPago" required>
                        <option selected disabled value="">Seleccione...</option>
                        <option value="quincenal">Quincenal / Mensual</option>
                        <option value="mensual">Semanal</option>
                    </select>
                </div>

                <div class="col-md-3 position-relative">
                    <label for="saldoVacaciones" class="form-label">Saldo de vacaciones</label>
                    <input type="number" class="form-control" id="saldoVacaciones" name="saldoVacaciones" required
                        value="<?php echo $vacacionesDisponibles; ?>" readonly>
                </div>
            </div>

            <div id="calculadoraAguinaldo" class="container-CalculadoraAguinaldo">
                <h2>Salario bruto de los últimos meses</h2>
                <br>     <br>
                <br>     <br>
                <div class="form-group">
                <br>     <br>
                    <label for="diciembre">Mayo:</label>
                    <input name="salarios[]" type="text" id="diciembre" class="form-control numeroConFormato">
                </div>
                <div class="form-group">
                <br>     <br>
                    <label for="enero">Abril:</label>
                    <input name="salarios[]" type="text" id="enero" class="form-control numeroConFormato">
                </div>
                <div class="form-group">
                    <label for="febrero">Marzo:</label>
                    <input name="salarios[]" type="text" id="febrero" class="form-control numeroConFormato">
                </div>
                <div class="form-group">
                    <label for="marzo">Febrero:</label>
                    <input name="salarios[]" type="text" id="marzo" class="form-control numeroConFormato">
                </div>
                <div class="form-group">
                    <label for="abril">Enero:</label>
                    <input name="salarios[]" type="text" id="abril" class="form-control numeroConFormato">
                </div>
                <div class="form-group">
                    <label for="mayo">Diciembre:</label>
                    <input name="salarios[]" type="text" id="mayo" class="form-control numeroConFormato">
                </div>
                <div class="form-group">
                    <label for="junio">Junio:</label>
                    <input name="salarios[]" type="text" id="junio" class="form-control numeroConFormato">
                </div>
                <div class="form-group">
                    <label for="julio">Julio:</label>
                    <input name="salarios[]" type="text" id="julio" class="form-control numeroConFormato">
                </div>
                <div class="form-group">
                    <label for="agosto">Agosto:</label>
                    <input name="salarios[]" type="text" id="agosto" class="form-control numeroConFormato">
                </div>
                <div class="form-group">
                    <label for="septiembre">Septiembre:</label>
                    <input name="salarios[]" type="text" id="septiembre" class="form-control numeroConFormato">
                </div>
                <div class="form-group">
                    <label for="octubre">Octubre:</label>
                    <input name="salarios[]" type="text" id="octubre" class="form-control numeroConFormato">
                </div>
                <div class="form-group">
                    <label for="noviembre">Noviembre:</label>
                    <input name="salarios[]" type="text" id="noviembre" class="form-control numeroConFormato">
                </div>
            </div>

            <div class="col-auto mt-3">
                <div class="col-auto mt-3">
                    <center><button type="submit" id="calcularBtn" class="btn_calcular">Calcular</button></center>
                </div>
            </div>


        </form>
    </div>
    </div>
    </div>


    <footer id="footer"></footer>
    <script src="../JS/footer.js"></script>
    <script src="../JS/liquidaciones.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

</body>

</html>