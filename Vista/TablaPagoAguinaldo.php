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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <div class="container-tablapagoaguinaldo">
        <h1 class="titulo-listaEmpleados">Lista Pago Aguinaldo</h1>

        <select id="select-empleado" name="select-empleado">
            <option value="">Seleccione un Empleado</option>
            <?php
            require_once '../Config/config.php';
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
                    <th>Cédula Empleado</th>
                    <th>Fecha</th>
                    <th>Monto a Pagar</th>
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
                        echo "<td>{$row['Empleados_Persona_Cedula1']}</td>";
                        echo "<td>{$row['Meses']}</td>";
                        echo "<td>₡ {$row['Monto_A_Pagar']}</td>";
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
    </div>
    <script>
        document.getElementById('select-aguinaldo').addEventListener('click', function() {
            const cedula = document.getElementById('select-empleado').value;
            const tbody = document.getElementById('cuerpo-tabla');
            if (cedula) {
                fetch(`../Controlador/ObtenerAguinaldoPorEmpleado.php?cedula=${cedula}`)
                    .then(response => response.json())
                    .then(data => {
                        tbody.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(row => {
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td>${row.idAguinaldo}</td>
                                    <td>${row.Meses}</td>
                                    <td>₡ ${row.Monto_A_Pagar}</td>
                                    <td>${row.Empleados_Persona_Cedula1}</td>
                                `;
                                tbody.appendChild(tr);
                            });
                        } else {
                            tbody.innerHTML = '<tr><td colspan="4">No se encontraron datos</td></tr>';
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener los datos:', error);
                        tbody.innerHTML = '<tr><td colspan="4">Error al obtener los datos</td></tr>';
                    });
            } else {
                swal.fire("Error", "No se ha seleccionado una cédula", "error");
            }
        });
    </script>
</body>

<footer id="footer"></footer>
<script src="../JS/footer.js"></script>

</html>