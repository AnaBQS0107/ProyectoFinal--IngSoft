<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/icono.png">
    <title>Consulta de Monto Total Cobrado por Mes</title>
    <link rel="stylesheet" href="Estilos/ConsultaMontoAlMes.css">
</head>



<body>
<header>
    <?php include 'Header.php'; ?>
</header>
<br><br><br><br>
   <center><h1>Consulta de Monto Total Cobrado por Mes</h1>

    <?php
    require_once '../Config/config.php';

    $database = new Database1();
    $conn = $database->getConnection();

    if ($conn) {
        try {
            $query = "SELECT 
                        DATE_FORMAT(cp.Fecha, '%Y-%m') AS Mes,
                        SUM(cp.TipoVehiculo_Tarifa) AS MontoTotal
                      FROM 
                        CobrosPeaje cp
                      GROUP BY 
                        DATE_FORMAT(cp.Fecha, '%Y-%m')";

            $stmt = $conn->prepare($query);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                echo "<table>";
                echo "<tr><th>Mes</th><th>Monto Total Cobrado</th></tr>";

                foreach ($resultados as $resultado) {
                    echo "<tr>";
                    echo "<td>{$resultado['Mes']}</td>";
                    echo "<td>{$resultado['MontoTotal']}</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No se encontraron resultados.</p>";
            }

        } catch (PDOException $e) {
            echo "Error al realizar la consulta: " . $e->getMessage();
        }
    } else {
        echo "No se pudo establecer la conexión.";
    }
    ?>
    </center> 

    <footer id="footer"></footer>
    <script src="../JS/footer.js"></script>
</body>
</html>
