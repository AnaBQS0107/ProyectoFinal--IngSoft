<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Cantidad de Vehículos por Hora del Día</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link rel="stylesheet" href="Estilos/ReporteVehiculosPorHora.css">
</head>
<header>
        <?php include 'Header.php'; ?>
    </header>
<body>


    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
               <center> <h1 class="text-center mb-4">Reporte de Cantidad de Vehículos por Hora del Día</h1></center> 
               <br>
                <table class="table table-bordered">
                        <tr>
                            <th>Hora del Día</th>
                            <th>Cantidad de Vehículos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once '../Modelo/ReporteHora.php'; // Incluir el modelo PHP

                        $modelo = new CantidadVehiculosPorHoraModelo();
                        $resultados = $modelo->obtenerCantidadVehiculosPorHora();

                        if (isset($resultados) && (is_array($resultados) || is_object($resultados))) {
                            foreach ($resultados as $row) {
                                echo "<tr>";
                                echo "<td>{$row['HoraDelDia']}</td>";
                                echo "<td>{$row['CantidadVehiculos']}</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>No se encontraron resultados en la consulta.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <center>
                    <form action="../Reportes/pdfVehiculoporHora.php" method="post">
                        <button type="submit" class="btn btn-primary">Generar PDF</button>
                    </form>
                </center>
                
            </div>
        </div>
    </div>

    <br><br><br>
    <footer id="footer"></footer>
    <script src="../JS/footer.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
</body>
</html>

