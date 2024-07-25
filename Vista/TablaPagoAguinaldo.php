<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
}

require_once '../Config/config.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PassWize - Lista Pago Aguinaldo</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/TablaPagoAguinaldo.css">
    <link rel="stylesheet" href="Estilos/Footer2.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br>
    <div class="header-space"></div>
    <h1 class="titulo-listaEmpleados">Lista Pago Aguinaldo</h1>
    <br>
    
    <select id="select-empleado" name="select-empleado">
        <option value="">Seleccione un Empleado</option>
        <?php
        try {
            $conn = getConnection();
            $sql = "SELECT DISTINCT Empleados_Persona_Cedula1 FROM aguinaldo";
            $stmt = $conn->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['Empleados_Persona_Cedula1']}'>{$row['Empleados_Persona_Cedula1']}</option>";
            }
        } catch (PDOException $e) {
            echo "<option value=''>Error al cargar empleados</option>";
        } finally {
            $conn = null;
        }
        ?>
    </select>
    <button id="select-aguinaldo">Seleccionar</button>

    <table id="tabla-aguinaldo">
        <thead>
            <tr>
                <th>ID Aguinaldo</th>
                <th>Meses</th>
                <th>Monto a Pagar</th>
                <th>Cédula Empleado</th>
            </tr>
        </thead>
        <tbody id="cuerpo-tabla">
            <?php
            try {
                $conn = getConnection();
                $sql = "SELECT * FROM aguinaldo";
                $stmt = $conn->query($sql);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$row['idAguinaldo']}</td>";
                    echo "<td>{$row['Meses']}</td>";
                    echo "<td>{$row['Monto_A_Pagar']}</td>";
                    echo "<td>{$row['Empleados_Persona_Cedula1']}</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='4'>Error al cargar datos</td></tr>";
            } finally {
                $conn = null;
            }
            ?>
        </tbody>
    </table>

    <div class="footer-space"></div>
    <div class="div_btn"></div>
    
    <script src="../JS/EmpleadosCRUD.js"></script>
    <script>
        document.getElementById('select-aguinaldo').addEventListener('click', function() {
            const cedula = document.getElementById('select-empleado').value;
            if (cedula) {
                fetch(`../Controlador/ObtenerAguinaldoPorEmpleado.php?cedula=${cedula}`)
                    .then(response => response.json())
                    .then(data => {
                        const tbody = document.getElementById('cuerpo-tabla');
                        tbody.innerHTML = '';
                        data.forEach(row => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${row.idAguinaldo}</td>
                                <td>${row.Meses}</td>
                                <td>${row.Monto_A_Pagar}</td>
                                <td>${row.Empleados_Persona_Cedula}</td>
                            `;
                            tbody.appendChild(tr);
                        });
                    })
                    .catch(error => {
                        console.error('Error al obtener los datos:', error);
                    });
            }
        });
    </script>
</body>

<footer id="footer"></footer>
<script src="../JS/footer.js"></script>

</html>