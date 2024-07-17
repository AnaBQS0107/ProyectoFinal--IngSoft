<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generar Reporte de Vehículos por Tipo</title>
    <link rel="stylesheet" href="Estilos/ReporteTipoVehiculoEstacion.css">
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
            <center> <h1 class="mb-4">Generar Reporte de Vehículos por Tipo</h1>

                <table class="table table-bordered">
                        <tr>
                            <th>Estación de Peaje</th>
                            <th>Tipo de Vehículo</th>
                            <th>Cantidad de Vehículos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                 
                        require_once '../Config/config.php';

                        $query = "SELECT ep.Nombre AS EstacionPeaje, tv.Tipo AS TipoVehiculo, COUNT(*) AS CantidadVehiculos
                                  FROM CobrosPeaje cp
                                  INNER JOIN EstacionesPeaje ep ON cp.EstacionesPeaje_idEstacionesPeaje = ep.idEstacionesPeaje
                                  INNER JOIN TipoVehiculo tv ON cp.TipoVehiculo_idTipoVehiculo = tv.idTipoVehiculo
                                  GROUP BY ep.Nombre, tv.Tipo
                                  ORDER BY ep.Nombre, tv.Tipo";

                        $database = new Database1(); 
                        $conn = $database->getConnection();

                        $resultados = []; 
                        if ($conn) {
                            try {
                                $stmt = $conn->prepare($query);
                                $stmt->execute();
                                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                if (empty($resultados)) {
                                    echo "<tr><td colspan='3'>No se encontraron resultados en la consulta.</td></tr>";
                                } else {
                                    foreach ($resultados as $row) {
                                        echo "<tr>";
                                        echo "<td>{$row['EstacionPeaje']}</td>";
                                        echo "<td>{$row['TipoVehiculo']}</td>";
                                        echo "<td>{$row['CantidadVehiculos']}</td>";
                                        echo "</tr>";
                                    }
                                }
                            } catch (PDOException $e) {
                                echo "<tr><td colspan='3'>Error al obtener datos: " . $e->getMessage() . "</td></tr>";
                            }
                            $conn = null; 
                        } else {
                            echo "<tr><td colspan='3'>No se pudo establecer la conexión.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <div class="text-center">
                <center> <form action="../Reportes/pdfTipodeVehiculoporEstacion.php" method="post">
                        <button type="submit" class="btn btn-primary">Generar PDF</button>
                    </form>
                    <br><br><br>
                </div>
            </div>
        </div>
    </div>


    <footer>
        <?php include 'Footer.php'; ?>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
