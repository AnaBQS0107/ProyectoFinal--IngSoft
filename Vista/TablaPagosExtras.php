<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprobación Horas Extras</title>
    <link rel="stylesheet" href="Estilos/TablaPagosExtras.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="Estilos/Footer2.css">
    <link rel="icon" type="image/png" href="../img/icono.png">
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br><br><br>
    <div class="container-PagosExtras">
        <div class="select-cedulasEmpleados">
        <h1>Empleados con Horas Extras Aprovadas</h1>
        <select id="select-empleado" name="select-empleado">
        <option value="">Seleccione un Empleado</option>
            <?php
            require_once '../Config/config.php';

            try {
                $conn = getConnection();
                $sql = "SELECT DISTINCT Empleados_Persona_Cedula FROM aprobacion_extras";
                $stmt = $conn->query($sql);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['Empleados_Persona_Cedula']}'>{$row['Empleados_Persona_Cedula']}</option>";
                }
            } catch (PDOException $e) {
                echo "<option value=''>Error al cargar empleados</option>";
            } finally {
                $conn = null;
            }
            ?>
        </select>
        <button id="select-extras">Seleccionar</button>
        </div>
        <table id="extras-table" style="display:none;">
            <thead>
                <tr>
                    <th>Cedula</th>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th>Motivo de Aprobación</th>
                </tr>
            </thead>
            <tbody id="extras-data">
            </tbody>
        </table>
    </div>

<footer id="footer"></footer>
<script src="../JS/footer.js"></script>
</body>

</html>