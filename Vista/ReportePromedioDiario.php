<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Promedio Diario de Vehículos por Estación</title>
    <link rel="stylesheet" href="Estilos/ReporteTotalPorMes.css">
    <link rel="icon" type="image/png" href="../img/icono.png">
    <style>
    .table-header {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body>

    <header>
        <?php include 'Header.php'; ?>
    </header>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
            <center><h1 class="text-center mb-4">Promedio Diario de Vehículos por Estación</h1>
            <br>
                <table class="table table-bordered">
                        <tr>
                            <th>Estación de Peaje</th>
                            <th>Promedio Diario de Vehículos (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once '../Config/config.php';

                        $query = "SELECT vehiculos_por_dia.EstacionPeaje, ROUND(AVG(vehiculos_por_dia.CantidadVehiculos), 2) AS PromedioDiarioVehiculos
FROM (
    SELECT ep.Nombre AS EstacionPeaje, DATE(cp.Fecha) AS Fecha, COUNT(*) AS CantidadVehiculos
    FROM CobrosPeaje cp
    INNER JOIN EstacionesPeaje ep ON cp.EstacionesPeaje_idEstacionesPeaje = ep.idEstacionesPeaje
    GROUP BY ep.Nombre, DATE(cp.Fecha)
) AS vehiculos_por_dia
GROUP BY vehiculos_por_dia.EstacionPeaje
ORDER BY vehiculos_por_dia.EstacionPeaje";

                        $database = new Database1(); 
                        $conn = $database->getConnection();

                        $resultados = []; 
                        if ($conn) {
                            try {
                                $stmt = $conn->prepare($query);
                                $stmt->execute();
                                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                if (empty($resultados)) {
                                    echo "<tr><td colspan='2'>No se encontraron resultados en la consulta.</td></tr>";
                                } else {
                                    foreach ($resultados as $row) {
                                        echo "<tr>";
                                        echo "<td>{$row['EstacionPeaje']}</td>";
                                        echo "<td>{$row['PromedioDiarioVehiculos']} %</td>";
                                        echo "</tr>";
                                    }
                                }
                            } catch (PDOException $e) {
                                echo "<tr><td colspan='2'>Error al obtener datos: " . $e->getMessage() . "</td></tr>";
                            }
                            $conn = null;
                        } else {
                            echo "<tr><td colspan='2'>No se pudo establecer la conexión.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Botón para generar PDF -->
                <div class="text-center mt-4">
                    <form action="../Reportes/pdfPromedioDiario.php" method="post">
                        <button type="submit" class="btn btn-primary">Generar PDF</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<br><br><br><br><br>
    <footer>
        <?php include 'Footer.php'; ?>
    </footer>

    <!-- Incluir Bootstrap JS y jQuery (opcional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
